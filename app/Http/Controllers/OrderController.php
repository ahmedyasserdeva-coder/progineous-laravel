<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Invoice;
use App\Models\Service;
use App\Models\WalletTransaction;
use App\Services\CpanelService;
use App\Services\DynadotService;
use App\Services\HetznerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    protected HetznerService $hetznerService;

    public function __construct(HetznerService $hetznerService)
    {
        $this->hetznerService = $hetznerService;
    }
    /**
     * معالجة الطلب من صفحة الدفع
     */
    public function processCheckout(Request $request)
    {
        Log::info('=== CHECKOUT STARTED ===', [
            'all_data' => $request->all(),
            'has_turnstile' => $request->has('cf-turnstile-response'),
            'is_authenticated' => Auth::guard('client')->check()
        ]);
        
        try {
            // التحقق من Cloudflare Turnstile (اختياري في التطوير المحلي)
            $turnstileToken = $request->input('cf-turnstile-response');
            if ($turnstileToken && !$this->validateTurnstile($turnstileToken)) {
                // إذا كان هناك token لكنه فاشل
                Log::error('Turnstile validation failed');
                return back()->withErrors(['turnstile' => __('frontend.turnstile_validation_failed', [], 'ar')])
                    ->withInput();
            }
            Log::info('Turnstile passed or skipped');
            // في حالة عدم وجود token (بيئة التطوير)، نستمر

            // Log request data for debugging
            Log::info('Request data:', $request->all());
            
            // التحقق من حالة المستخدم (مسجل دخول أم لا)
            $isAuthenticated = Auth::guard('client')->check();
            
            // قواعد التحقق مختلفة حسب حالة تسجيل الدخول
            $validationRules = [
                'payment_method' => 'required|string',
            ];
            
            // التحقق من الموافقة على الشروط فقط إذا لم يوافق المستخدم من قبل
            if ($isAuthenticated) {
                $client = Auth::guard('client')->user();
                // إذا لم يوافق من قبل، نطلب الموافقة
                if (!$client->hasAcceptedTerms()) {
                    $validationRules['accept_terms'] = 'required|accepted';
                }
            } else {
                // المستخدم الجديد يجب أن يوافق
                $validationRules['accept_terms'] = 'required|accepted';
            }
            
            // إذا لم يكن مسجل دخول، نطلب بيانات التسجيل
            if (!$isAuthenticated) {
                $validationRules = array_merge($validationRules, [
                    'username' => 'required|string|min:3|max:50|regex:/^[A-Za-z0-9]+$/|unique:clients,username',
                    'first_name' => 'required|string|max:15|regex:/^[A-Za-z]+$/',
                    'last_name' => 'required|string|max:15|regex:/^[A-Za-z]+$/',
                    'company_name' => 'nullable|string|max:30|regex:/^[A-Za-z0-9\s]+$/',
                    'email' => 'required|email|unique:clients,email',
                    'country_code' => 'required|string',
                    'phone' => 'required|string|regex:/^[0-9]+$/',
                    'address_1' => 'required|string|max:100',
                    'address_2' => 'nullable|string|max:100',
                    'city' => 'required|string|max:20|regex:/^[A-Za-z\s\-]+$/',
                    'state' => 'required|string|max:20|regex:/^[A-Za-z\s\-]+$/',
                    'postcode' => 'required|string|max:15',
                    'country' => 'required|string',
                    'tax_number' => 'nullable|string|max:20',
                    'password' => 'required|string|min:8|confirmed',
                ]);
            }
            
            $validated = $request->validate($validationRules);
            
            Log::info('Validation passed');

            // التحقق من وجود عناصر في السلة
            $cart = session('cart', []);
            if (empty($cart)) {
                return redirect()->route('cart.index')->with('error', __('frontend.cart_is_empty'));
            }

            DB::beginTransaction();

            try {
                // 1. الحصول على العميل (إنشاء جديد أو استخدام الحالي)
                if ($isAuthenticated) {
                    $client = Auth::guard('client')->user();
                    Log::info('Using authenticated client', ['client_id' => $client->id]);
                    
                    // حفظ الموافقة على الشروط إذا لم يوافق من قبل
                    if (!$client->hasAcceptedTerms() && $request->has('accept_terms')) {
                        $client->terms_accepted_at = now();
                        $client->save();
                        Log::info('Client accepted terms', ['client_id' => $client->id]);
                    }
                } else {
                    $client = $this->createClient($validated);
                    Log::info('Created new client', ['client_id' => $client->id]);
                }

                // 2. إنشاء الطلب
                $order = $this->createOrder($client, $cart, $validated);

                // 3. إنشاء عناصر الطلب
                $this->createOrderItems($order, $cart);

                // 4. إنشاء الفاتورة
                $invoice = $this->createInvoice($order, $client);

                // 5. معالجة الدفع حسب طريقة الدفع
                $paymentResult = $this->processPayment($order, $invoice, $validated['payment_method'], $client);

                DB::commit();

                // 6. تسجيل دخول العميل إذا لم يكن مسجل دخول بالفعل
                if (!$isAuthenticated) {
                    Auth::guard('client')->login($client);
                    Log::info('Client logged in after checkout');
                }
                
                // 7. مسح السلة بعد تسجيل الدخول
                session()->forget('cart');

                // 8. إرسال إيميل تأكيد
                $this->sendOrderConfirmationEmail($client, $order, $invoice);

                // 9. التوجيه حسب نتيجة الدفع
                if ($paymentResult['redirect']) {
                    return redirect($paymentResult['url']);
                } else {
                    return redirect()->route('order.success', ['order' => $order->id])
                        ->with('success', __('frontend.order_placed_successfully'));
                }

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Order creation failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('Checkout failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * إنشاء حساب العميل
     */
    private function createClient($data)
    {
        // دمج كود الدولة مع رقم الهاتف
        $fullPhone = $data['country_code'] . $data['phone'];
        
        $client = Client::create([
            'username' => $data['username'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'company_name' => $data['company_name'] ?? null,
            'email' => $data['email'],
            'phone' => $fullPhone, // رقم الهاتف مع كود الدولة
            'address1' => $data['address_1'], // Database uses address1 without underscore
            'address2' => $data['address_2'] ?? null, // Database uses address2 without underscore
            'city' => $data['city'],
            'state' => $data['state'],
            'postcode' => $data['postcode'],
            'country' => $data['country'],
            'tax_number' => $data['tax_number'] ?? null,
            'password' => Hash::make($data['password']),
            'email_verified_at' => now(),
            'status' => 'active',
            'preferred_language' => app()->getLocale(), // تعيين اللغة من اللغة الحالية
            'terms_accepted_at' => now(), // العميل الجديد يوافق على الشروط عند التسجيل
        ]);

        return $client;
    }

    /**
     * إنشاء الطلب
     */
    private function createOrder($client, $cart, $data)
    {
        // حساب الإجمالي
        $subtotal = 0;
        foreach ($cart as $item) {
            // Support both 'years' (from cart) and 'billing_cycle_years' (legacy)
            $years = $item['years'] ?? $item['billing_cycle_years'] ?? 1;
            $subtotal += $item['price'] * $years;
        }

        $tax = 0;
        
        // توليد order_number مؤقت (سنحدثه بعد الحصول على ID)
        $tempOrderNumber = 'ORD-' . date('Ymd') . '-' . uniqid();
        
        // billing_cycle للـ Order يكون null لأن كل منتج له billing_cycle خاص به
        // سيتم استخدام billing_cycle من configuration الخاص بكل OrderItem
        $billingCycle = null;
        
        // next_due_date سيتم حسابه لكل خدمة على حدة
        // هنا نضع أقرب تاريخ تجديد من المنتجات
        $nextDueDate = null;
        foreach ($cart as $item) {
            // Support both 'years' (from cart) and 'billing_cycle_years' (legacy)
            $years = $item['years'] ?? $item['billing_cycle_years'] ?? null;
            if ($years) {
                $itemDueDate = now()->addYears($years);
                if ($nextDueDate === null || $itemDueDate < $nextDueDate) {
                    $nextDueDate = $itemDueDate;
                }
            }
        }
        
        $order = new Order();
        $order->user_id = null; // nullable - نستخدم client_id
        $order->product_id = null; // nullable - المنتجات في order_items
        $order->client_id = $client->id;
        $order->order_number = $tempOrderNumber;
        $order->domain_name = null; // nullable - سيتم تعبئته من order_items
        $order->amount = $subtotal + $tax; // Old column, same as total
        $order->subtotal = $subtotal;
        $order->discount = 0;
        $order->tax = $tax;
        $order->total = $subtotal + $tax;
        $order->currency = 'USD';
        $order->status = 'pending';
        $order->payment_status = 'pending';
        $order->payment_method = $data['payment_method'];
        $order->billing_cycle = $billingCycle;
        $order->next_due_date = $nextDueDate;
        $order->order_details = json_encode($cart); // تفاصيل السلة
        $order->save();

        // تحديث order_number برقم الطلب الحقيقي
        $order->order_number = 'ORD-' . date('Ymd') . '-' . str_pad($order->id, 4, '0', STR_PAD_LEFT);
        $order->save();

        return $order;
    }

    /**
     * إنشاء عناصر الطلب
     */
    private function createOrderItems($order, $cart)
    {
        foreach ($cart as $item) {
            // Support both 'years' (from cart) and 'billing_cycle_years' (legacy)
            $quantity = $item['years'] ?? $item['billing_cycle_years'] ?? 1;
            $unitPrice = $item['price'];
            $subtotal = $unitPrice * $quantity;

            // إنشاء اسم المنتج بناءً على النوع
            $productName = $this->getProductName($item);
            
            // الحصول على اسم الخطة ونوعها
            $planName = $this->getPlanName($item);
            $productType = $this->getProductType($item);
            
            // Build configuration based on item type
            $configuration = [
                'domain' => $item['domain'] ?? null,
                'plan' => $planName,
                'product_type' => $productType,
                'billing_cycle' => $item['billing_cycle'] ?? null,
                'billing_cycle_years' => $quantity,
                'addons' => $item['addons'] ?? [],
                'nameservers' => $item['nameservers'] ?? [],
                'datacenter' => $item['datacenter'] ?? null,
                'datacenter_name' => $item['datacenter_name'] ?? null,
                'cpanel_accounts' => $item['cpanel_accounts'] ?? null,
                'cpanel_tier_id' => $item['cpanel_tier_id'] ?? null,
                'cpanel_tier_price' => $item['cpanel_tier_price'] ?? null,
            ];
            
            // Add domain-specific fields
            if ($item['type'] === 'domain') {
                $configuration['action'] = $item['action'] ?? 'register';
                $configuration['years'] = $quantity;
                $configuration['tld'] = $item['tld'] ?? null;
                $configuration['auth_code'] = $item['auth_code'] ?? null;
            }
            
            OrderItem::create([
                'order_id' => $order->id,
                'type' => $item['type'],
                'product_name' => $productName,
                'configuration' => $configuration,
                'unit_price' => $unitPrice,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
                'discount' => 0,
                'total' => $subtotal,
                'status' => 'pending',
            ]);
        }
    }

    /**
     * إنشاء الفاتورة
     */
    private function createInvoice($order, $client)
    {
        // توليد invoice_number مؤقت
        $tempInvoiceNumber = 'INV-' . date('Ymd') . '-' . uniqid();
        
        $invoice = new Invoice();
        $invoice->order_id = $order->id;
        $invoice->client_id = $client->id;
        $invoice->invoice_number = $tempInvoiceNumber;
        $invoice->invoice_date = now();
        $invoice->due_date = now()->addDays(7);
        $invoice->subtotal = $order->subtotal;
        $invoice->tax = $order->tax;
        $invoice->discount = $order->discount;
        $invoice->total = $order->total;
        $invoice->paid_amount = 0;
        $invoice->balance = $order->total;
        $invoice->currency = 'USD';
        $invoice->status = 'unpaid';
        $invoice->save();

        // تحديث invoice_number برقم الفاتورة الحقيقي
        $invoice->invoice_number = 'INV-' . date('Ymd') . '-' . str_pad($invoice->id, 4, '0', STR_PAD_LEFT);
        $invoice->save();

        return $invoice;
    }

    /**
     * معالجة الدفع
     */
    private function processPayment($order, $invoice, $paymentMethod, $client)
    {
        if ($paymentMethod === 'wallet') {
            if ($client->wallet_balance >= $order->total) {
                // Use database transaction to ensure atomicity
                DB::beginTransaction();
                try {
                    // Deduct from wallet balance
                    $client->wallet_balance -= $order->total;
                    $client->save();

                    // Create wallet transaction record
                    WalletTransaction::create([
                        'client_id' => $client->id,
                        'amount' => $order->total,
                        'type' => 'deduction',
                        'status' => 'completed',
                        'transaction_reference' => WalletTransaction::generateReference(),
                        'payment_method' => 'wallet_payment',
                        'completed_at' => now(),
                        'metadata' => [
                            'order_id' => $order->id,
                            'order_number' => $order->order_number,
                            'invoice_id' => $invoice->id,
                            'invoice_number' => $invoice->invoice_number,
                            'description' => 'Payment for Order #' . $order->order_number,
                        ]
                    ]);

                    $order->payment_status = 'paid';
                    $order->paid_at = now();
                    $order->status = 'processing';
                    $order->save();

                    $invoice->markAsPaid();
                    $this->activateServices($order);

                    DB::commit();
                    
                    return ['redirect' => false];
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('Wallet payment processing error: ' . $e->getMessage(), [
                        'client_id' => $client->id,
                        'order_id' => $order->id,
                    ]);
                    throw $e;
                }
            } else {
                throw new \Exception(__('frontend.insufficient_wallet_balance'));
            }
        }
        
        if (str_starts_with($paymentMethod, 'fawaterak_')) {
            $paymentId = str_replace('fawaterak_', '', $paymentMethod);
            $result = $this->createFawaterakPayment($order, $invoice, $paymentId);
            
            return $result;
        }

        return ['redirect' => false];
    }

    /**
     * إنشاء طلب دفع على Fawaterak
     */
    private function createFawaterakPayment($order, $invoice, $paymentId)
    {
        Log::info('Creating Fawaterak Payment', [
            'order_id' => $order->id,
            'payment_id' => $paymentId,
            'total' => $order->total
        ]);
        
        // استخدام FawaterakPaymentService مثل WalletController
        $fawaterakService = app(\App\Services\FawaterakPaymentService::class);
        
        // تنظيف رقم الهاتف - Fawaterak يتطلب صيغة مصرية: 01xxxxxxxxx
        $phone = $order->client->phone ?? '';
        if (!empty($phone)) {
            // إزالة أي رموز غير رقمية
            $phone = preg_replace('/[^0-9]/', '', $phone);
            
            // تحويل إلى صيغة مصرية (01xxxxxxxxx)
            if (str_starts_with($phone, '2') && strlen($phone) == 12) {
                $phone = '0' . substr($phone, 2);
            } elseif (str_starts_with($phone, '00')) {
                $phone = substr($phone, 2);
                if (str_starts_with($phone, '2')) {
                    $phone = '0' . substr($phone, 2);
                }
            }
        }
        
        $data = [
            'payment_method_id' => $paymentId,
            'cartTotal' => $invoice->total,
            'currency' => 'USD',
            'customer' => [
                'first_name' => $order->client->first_name,
                'last_name' => $order->client->last_name,
                'email' => $order->client->email,
                'phone' => $phone,
                'address' => $order->client->address1 ?? '',
            ],
            'redirectionUrls' => [
                'successUrl' => route('payment.success', ['order' => $order->id]),
                'failUrl' => route('payment.failed', ['order' => $order->id]),
                'pendingUrl' => route('payment.pending', ['order' => $order->id]),
            ],
            'cartItems' => $invoice->items && $invoice->items->count() > 0 
                ? $invoice->items->map(function($item) {
                    return [
                        'name' => $item->description ?? $item->product_name ?? 'Service',
                        'price' => $item->unit_price,
                        'quantity' => $item->quantity ?? 1,
                    ];
                })->toArray()
                : [[
                    'name' => $invoice->notes ?? 'Service Fee',
                    'price' => $invoice->total,
                    'quantity' => 1,
                ]],
            'lang' => app()->getLocale(),
            'sendEmail' => true,
        ];
        
        Log::info('Fawaterak Payment Request', ['data' => $data]);

        try {
            // استخدام الـ Service بدلاً من HTTP مباشرة
            $response = $fawaterakService->initiatePayment($data);

            if ($response['success']) {
                Log::info('Fawaterak Payment Response', ['response' => $response]);
                
                // Log all payment_data keys for debugging
                $paymentData = $response['payment_data'] ?? [];
                Log::info('Fawaterak Payment Data Keys', [
                    'payment_method_id' => $paymentId,
                    'available_keys' => array_keys($paymentData),
                    'full_data' => $paymentData
                ]);
                
                // حفظ معلومات الدفع
                $order->payment_gateway_id = $response['invoice_id'] ?? null;
                $order->save();
                
                $paymentData = $response['payment_data'] ?? [];
                
                // حفظ معلومات الدفع في الـ session لاستخدامها في صفحة pending
                session([
                    'order_payment_info' => [
                        'order_id' => $order->id,
                        'invoice_id' => $response['invoice_id'] ?? null,
                        'invoice_key' => $response['invoice_key'] ?? null,
                        'payment_data' => $paymentData,
                        'payment_method_id' => $paymentId, // Store payment method ID for pending page
                    ],
                    'payment_created_at' => now(), // Store timestamp for timeout check
                ]);
                
                // التحقق من نوع طريقة الدفع وإرجاع الاستجابة المناسبة
                
                // 1. Visa/Mastercard (payment_method_id = 2) - لديها رابط redirect مباشر
                if (!empty($paymentData['redirectTo'])) {
                    Log::info('Redirecting to card payment gateway');
                    return [
                        'redirect' => true,
                        'url' => $paymentData['redirectTo']
                    ];
                }
                
                // 2. Fawry (payment_method_id = 3) - نتحقق من payment_method_id لأن Fawaterak قد تُرجع fawryCode
                if ($paymentId == 3 || !empty($paymentData['fawryCode'])) {
                    // Check for error in payment_data
                    if (!empty($paymentData['error'])) {
                        Log::error('Fawry payment failed', ['error' => $paymentData['error']]);
                        $order->update([
                            'payment_status' => 'failed',
                            'order_status' => 'cancelled'
                        ]);
                        throw new \Exception($paymentData['error']);
                    }
                    
                    Log::info('Fawry payment selected', [
                        'fawryCode' => $paymentData['fawryCode'] ?? 'N/A',
                        'meezaReference' => $paymentData['meezaReference'] ?? 'N/A'
                    ]);
                    return [
                        'redirect' => true,
                        'url' => route('payment.pending', ['order' => $order->id])
                    ];
                }
                
                // 3. Aman (payment_method_id = 12) - لديها كود امان
                if ($paymentId == 12 || !empty($paymentData['amanCode'])) {
                    // Check for error in payment_data
                    if (!empty($paymentData['error'])) {
                        Log::error('Aman payment failed', ['error' => $paymentData['error']]);
                        $order->update([
                            'payment_status' => 'failed',
                            'order_status' => 'cancelled'
                        ]);
                        throw new \Exception($paymentData['error']);
                    }
                    
                    Log::info('Aman code generated', ['code' => $paymentData['amanCode']]);
                    return [
                        'redirect' => true,
                        'url' => route('payment.pending', ['order' => $order->id])
                    ];
                }
                
                // 4. Mobile Wallet/Meeza (payment_method_id = 4) - لديها رقم مرجعي
                if ($paymentId == 4 || !empty($paymentData['meezaReference']) || !empty($paymentData['mobileWalletNumber'])) {
                    // Check for error in payment_data
                    if (!empty($paymentData['error'])) {
                        Log::error('Mobile wallet payment failed', ['error' => $paymentData['error']]);
                        $order->update([
                            'payment_status' => 'failed',
                            'order_status' => 'cancelled'
                        ]);
                        throw new \Exception($paymentData['error']);
                    }
                    
                    Log::info('Mobile wallet/Meeza reference generated', ['reference' => $paymentData['meezaReference'] ?? $paymentData['mobileWalletNumber'] ?? 'N/A']);
                    return [
                        'redirect' => true,
                        'url' => route('payment.pending', ['order' => $order->id])
                    ];
                }
                
                // 5. Basata/Masary (payment_method_id = 14) - لديها كود
                if ($paymentId == 14 || !empty($paymentData['masaryCode']) || !empty($paymentData['bastaCode'])) {
                    // Check for error in payment_data
                    if (!empty($paymentData['error'])) {
                        Log::error('Basata payment failed', ['error' => $paymentData['error']]);
                        $order->update([
                            'payment_status' => 'failed',
                            'order_status' => 'cancelled'
                        ]);
                        throw new \Exception($paymentData['error']);
                    }
                    
                    Log::info('Basata code generated');
                    return [
                        'redirect' => true,
                        'url' => route('payment.pending', ['order' => $order->id])
                    ];
                }
                
                // محاولة أخيرة: البحث عن أي URL في payment_data
                foreach ($paymentData as $key => $value) {
                    if (is_string($value) && (str_starts_with($value, 'http://') || str_starts_with($value, 'https://'))) {
                        Log::info('Found redirect URL in payment data', ['key' => $key, 'url' => $value]);
                        return [
                            'redirect' => true,
                            'url' => $value
                        ];
                    }
                }
                
                // إذا لم يتم العثور على أي معلومات دفع، نوجه لصفحة pending
                Log::warning('No specific payment method detected, redirecting to pending');
                return [
                    'redirect' => true,
                    'url' => route('payment.pending', ['order' => $order->id])
                ];
                
            } else {
                $errorMessage = $response['message'] ?? 'Unknown error';
                Log::error('Fawaterak Payment Failed', [
                    'response' => $response,
                    'error' => $errorMessage
                ]);
                throw new \Exception('Fawaterak payment failed: ' . $errorMessage);
            }
        } catch (\Exception $e) {
            Log::error('Fawaterak payment creation failed', [
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * تفعيل الخدمات بعد الدفع
     */
    private function activateServices($order)
    {
        foreach ($order->items as $item) {
            // Get billing_cycle from OrderItem configuration (not from Order)
            $billingCycle = $item->configuration['billing_cycle'] ?? null;
            
            // Calculate next due date based on billing cycle
            $nextDueDate = null;
            if ($billingCycle) {
                $nextDueDate = now();
                switch ($billingCycle) {
                    case 'monthly':
                        $nextDueDate->addMonth();
                        break;
                    case 'quarterly':
                        $nextDueDate->addMonths(3);
                        break;
                    case 'semi_annually':
                        $nextDueDate->addMonths(6);
                        break;
                    case 'annually':
                        $nextDueDate->addYear();
                        break;
                    case 'biennially':
                        $nextDueDate->addYears(2);
                        break;
                    case 'triennially':
                        $nextDueDate->addYears(3);
                        break;
                }
            }
            
            // For domains, use years from configuration if billing_cycle is not set
            if ($item->type === 'domain' && !$billingCycle) {
                $years = $item->configuration['years'] ?? $item->configuration['billing_cycle_years'] ?? 1;
                $nextDueDate = now()->addYears($years);
                $billingCycle = $years == 1 ? 'annually' : ($years == 2 ? 'biennially' : 'triennially');
            }
            
            $service = Service::create([
                'client_id' => $order->client_id,
                'order_id' => $order->id,
                'order_item_id' => $item->id,
                'type' => $item->type,
                'service_name' => $item->product_name,
                // For domain services, domain is stored in domains table only (not duplicated here)
                // For hosting services, domain is stored here
                'domain' => $item->type === 'domain' ? null : ($item->configuration['domain'] ?? null),
                'status' => 'pending',
                'billing_cycle' => $billingCycle,
                'recurring_amount' => $item->unit_price,
                'next_due_date' => $nextDueDate,
            ]);

            switch ($item->type) {
                case 'hosting':
                    $this->provisionHosting($service, $item);
                    break;
                case 'domain':
                    $this->provisionDomain($service, $item);
                    break;
                case 'vps':
                    $this->provisionVPS($service, $item);
                    break;
                case 'dedicated':
                    $this->provisionDedicated($service, $item);
                    break;
            }
        }

        $order->status = 'completed';
        $order->completed_at = now();
        $order->save();
    }

    private function provisionHosting($service, $item)
    {
        try {
            Log::info('Provisioning hosting account', [
                'service_id' => $service->id,
                'domain' => $service->domain,
            ]);

            // Get product details for WHM package
            $planName = $item->configuration['plan'] ?? null;
            $product = null;
            $whmPackage = 'default';
            
            if ($planName) {
                $product = \App\Models\Product::where('name', $planName)
                    ->where('type', 'hosting')
                    ->first();
                    
                if ($product && $product->whm_package_name) {
                    $whmPackage = $product->whm_package_name;
                }
            }
            
            // Check if product requires manual setup (e.g., Reseller Hosting)
            // For manual setup products, just set to pending and don't call WHM API
            if ($product && ($product->auto_setup === 'manual' || $product->category === 'reseller_hosting')) {
                Log::info('Manual setup required for this product, skipping auto-provisioning', [
                    'service_id' => $service->id,
                    'product_name' => $product->name,
                    'category' => $product->category,
                    'auto_setup' => $product->auto_setup,
                ]);
                
                // Calculate next due date based on billing cycle
                $configuration = $item->configuration ?? [];
                $billingCycle = $configuration['billing_cycle'] ?? 'monthly';
                $years = $configuration['billing_cycle_years'] ?? 1;
                
                $nextDueDate = now();
                switch ($billingCycle) {
                    case 'monthly':
                        $nextDueDate = $nextDueDate->addMonths($years);
                        break;
                    case 'quarterly':
                        $nextDueDate = $nextDueDate->addMonths(3 * $years);
                        break;
                    case 'semi_annually':
                    case 'semiannually':
                        $nextDueDate = $nextDueDate->addMonths(6 * $years);
                        break;
                    case 'annually':
                        $nextDueDate = $nextDueDate->addYears($years);
                        break;
                    case 'biennially':
                        $nextDueDate = $nextDueDate->addYears(2 * $years);
                        break;
                    case 'triennially':
                        $nextDueDate = $nextDueDate->addYears(3 * $years);
                        break;
                    default:
                        $nextDueDate = $nextDueDate->addMonth();
                }
                
                // Set service as pending for manual setup
                $service->update([
                    'status' => 'pending',
                    'billing_cycle' => $billingCycle,
                    'next_due_date' => $nextDueDate,
                    'server_data' => [
                        'requires_manual_setup' => true,
                        'product_category' => $product->category,
                        'created_at' => now()->toDateTimeString(),
                    ]
                ]);
                
                return;
            }
            
            // Get client email
            $client = $service->client;
            $contactEmail = $client->email ?? '';
            
            // Check if domain already exists in active services
            $existingService = \App\Models\Service::where('domain', $service->domain)
                ->where('id', '!=', $service->id)
                ->where('status', 'active')
                ->first();
                
            if ($existingService) {
                // Domain already exists in another active service
                $service->update([
                    'status' => 'failed',
                    'server_data' => [
                        'error' => 'Domain already exists in another active service (Service #' . $existingService->id . ')',
                        'attempted_at' => now()->toDateTimeString(),
                    ]
                ]);
                
                Log::error('Domain already exists in another service', [
                    'service_id' => $service->id,
                    'domain' => $service->domain,
                    'existing_service_id' => $existingService->id,
                ]);
                
                return;
            }
            
            // Generate username from domain (first 8 chars of domain without TLD)
            $username = $this->generateCpanelUsername($service->domain);
            
            // Generate random password
            $password = \Illuminate\Support\Str::random(16);
            
            // Log provisioning details
            Log::info('Creating cPanel account', [
                'service_id' => $service->id,
                'domain' => $service->domain,
                'username' => $username,
                'package' => $whmPackage,
                'contact_email' => $contactEmail,
            ]);
            
            // Create cPanel account via WHM API
            $cpanelService = app(CpanelService::class);
            $result = $cpanelService->createAccount(
                $service->domain,
                $username,
                $password,
                $whmPackage,
                $contactEmail
            );
            
            // Check if account was created successfully
            // WHM API json-api returns: {"result": [{"status": 1, ...}]}
            $success = $result && 
                       isset($result['result']) && 
                       is_array($result['result']) && 
                       count($result['result']) > 0 &&
                       isset($result['result'][0]['status']) && 
                       $result['result'][0]['status'] == 1;
            
            if ($success) {
                // Calculate next due date based on billing cycle
                $configuration = $item->configuration ?? [];
                $billingCycle = $configuration['billing_cycle'] ?? 'monthly';
                $years = $configuration['billing_cycle_years'] ?? 1;
                
                $nextDueDate = now();
                switch ($billingCycle) {
                    case 'monthly':
                        $nextDueDate = $nextDueDate->addMonths($years);
                        break;
                    case 'quarterly':
                        $nextDueDate = $nextDueDate->addMonths(3 * $years);
                        break;
                    case 'semi_annually':
                    case 'semiannually':
                        $nextDueDate = $nextDueDate->addMonths(6 * $years);
                        break;
                    case 'annually':
                        $nextDueDate = $nextDueDate->addYears($years);
                        break;
                    case 'biennially':
                        $nextDueDate = $nextDueDate->addYears(2 * $years);
                        break;
                    case 'triennially':
                        $nextDueDate = $nextDueDate->addYears(3 * $years);
                        break;
                    default:
                        $nextDueDate = $nextDueDate->addMonth();
                }
                
                // Account created successfully
                $service->update([
                    'status' => 'active',
                    'activated_at' => now(),
                    'username' => $username,
                    'password' => encrypt($password), // Encrypt password for security
                    'server_id' => $product ? $product->server_id : null,
                    'billing_cycle' => $billingCycle,
                    'next_due_date' => $nextDueDate,
                    'server_data' => [
                        'cpanel_username' => $username,
                        'whm_package' => $whmPackage,
                        'created_at' => now()->toDateTimeString(),
                    ]
                ]);
                
                Log::info('Hosting account created successfully', [
                    'service_id' => $service->id,
                    'username' => $username,
                ]);
                
                // TODO: Send account details email to client
                
            } else {
                // Failed to create account
                $errorMsg = 'Unknown error';
                if ($result && isset($result['result'][0]['statusmsg'])) {
                    $errorMsg = $result['result'][0]['statusmsg'];
                }
                
                $service->update([
                    'status' => 'failed',
                    'server_data' => [
                        'error' => $errorMsg,
                        'attempted_at' => now()->toDateTimeString(),
                    ]
                ]);
                
                Log::error('Failed to create hosting account', [
                    'service_id' => $service->id,
                    'error' => $errorMsg,
                ]);
            }
            
        } catch (\Exception $e) {
            Log::error('Hosting provisioning error', [
                'service_id' => $service->id,
                'error' => $e->getMessage(),
            ]);
            
            $service->status = 'failed';
            $service->server_data = [
                'error' => $e->getMessage(),
                'attempted_at' => now()->toDateTimeString(),
            ];
            $service->save();
        }
    }

    /**
     * Extract phone country code from country ISO code
     */
    private function extractPhoneCountryCode(string $countryCode): string
    {
        $phoneCodes = [
            'US' => '1', 'CA' => '1', 'GB' => '44', 'UK' => '44',
            'DE' => '49', 'FR' => '33', 'IT' => '39', 'ES' => '34',
            'AU' => '61', 'NZ' => '64', 'JP' => '81', 'CN' => '86',
            'IN' => '91', 'BR' => '55', 'MX' => '52', 'RU' => '7',
            'SA' => '966', 'AE' => '971', 'EG' => '20', 'ZA' => '27',
            'NG' => '234', 'KE' => '254', 'PK' => '92', 'BD' => '880',
            'ID' => '62', 'MY' => '60', 'SG' => '65', 'PH' => '63',
            'TH' => '66', 'VN' => '84', 'KR' => '82', 'TW' => '886',
            'HK' => '852', 'NL' => '31', 'BE' => '32', 'SE' => '46',
            'NO' => '47', 'DK' => '45', 'FI' => '358', 'PL' => '48',
            'CZ' => '420', 'AT' => '43', 'CH' => '41', 'PT' => '351',
            'GR' => '30', 'TR' => '90', 'IL' => '972', 'JO' => '962',
            'LB' => '961', 'KW' => '965', 'QA' => '974', 'BH' => '973',
            'OM' => '968', 'YE' => '967', 'IQ' => '964', 'IR' => '98',
            'AF' => '93', 'AR' => '54', 'CL' => '56', 'CO' => '57',
            'PE' => '51', 'VE' => '58', 'EC' => '593', 'UY' => '598',
        ];
        
        return $phoneCodes[strtoupper($countryCode)] ?? '1';
    }

    private function provisionDomain($service, $item)
    {
        try {
            Log::info('Provisioning domain registration', [
                'service_id' => $service->id,
                'domain' => $service->domain,
            ]);

            // Get domain from item configuration (not from service, as we don't store domain in services for domain type)
            $domain = $item->configuration['domain'] ?? null;
            $action = $item->configuration['action'] ?? 'register';
            $years = $item->configuration['years'] ?? 1;
            
            if (!$domain) {
                throw new \Exception('Domain name not found in order item configuration');
            }
            
            // Get Dynadot registrar
            $registrar = \App\Models\DomainRegistrar::where('name', 'Dynadot')
                ->where('status', true)
                ->first();
            
            if (!$registrar) {
                throw new \Exception('Dynadot registrar not configured');
            }
            
            $dynadotService = new DynadotService($registrar);
            
            // Get the client for contact information
            $client = $service->client ?? ($item->order->client ?? null);
            $contactId = null;
            
            // Create contact in Dynadot from client data
            if ($client) {
                try {
                    // Parse phone number to extract country code and number
                    $phone = $client->phone ?? '';
                    $phoneCC = $this->extractPhoneCountryCode($client->country ?? 'US');
                    $phoneNum = $phone;
                    
                    // If phone starts with + or country code, extract it
                    if (preg_match('/^\+?(\d{1,4})(.+)$/', $phone, $matches)) {
                        $phoneCC = ltrim($matches[1], '0');
                        $phoneNum = $matches[2];
                    }
                    
                    $contactData = [
                        'name' => trim(($client->first_name ?? '') . ' ' . ($client->last_name ?? '')),
                        'email' => $client->email ?? '',
                        'phone' => $phoneNum,
                        'phone_cc' => $phoneCC,
                        'address1' => $client->address1 ?? $client->address_1 ?? '',
                        'address2' => $client->address2 ?? $client->address_2 ?? '',
                        'city' => $client->city ?? '',
                        'state' => $client->state ?? '',
                        'postcode' => $client->postcode ?? '',
                        'country' => $client->country ?? 'US',
                        'organization' => $client->company_name ?? '',
                    ];
                    
                    $contactResult = $dynadotService->createContact($contactData);
                    
                    // Extract contact ID from response
                    if (isset($contactResult['CreateContactResponse']['ResponseCode']) && 
                        $contactResult['CreateContactResponse']['ResponseCode'] == 0) {
                        $contactId = $contactResult['CreateContactResponse']['CreateContactContent']['ContactId'] ?? null;
                    } elseif (isset($contactResult['CreateContactContent']['ContactId'])) {
                        $contactId = $contactResult['CreateContactContent']['ContactId'];
                    }
                    
                    Log::info('Created Dynadot contact for domain registration', [
                        'domain' => $domain,
                        'client_id' => $client->id,
                        'contact_id' => $contactId,
                    ]);
                } catch (\Exception $e) {
                    Log::warning('Failed to create contact for domain, continuing without WHOIS info', [
                        'domain' => $domain,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
            
            if ($action === 'register') {
                // Extract domain name and TLD (needed for both success and failure cases)
                $domainParts = explode('.', $domain, 2);
                $domainName = $domainParts[0] ?? $domain;
                $tld = isset($domainParts[1]) ? '.' . $domainParts[1] : '';
                
                try {
                    // Build registration options with contact if available
                    $registerOptions = [];
                    if ($contactId) {
                        $registerOptions['registrant_contact'] = $contactId;
                        $registerOptions['admin_contact'] = $contactId;
                        $registerOptions['technical_contact'] = $contactId;
                        $registerOptions['billing_contact'] = $contactId;
                    }
                    
                    // Register new domain with contact information
                    $result = $dynadotService->registerDomain($domain, $years, $registerOptions);
                    
                    // Check if registration actually succeeded
                    // Dynadot returns Expiration timestamp on successful registration
                    $registrationSucceeded = false;
                    $registrarDomainId = null;
                    $expirationTimestamp = null;
                    
                    // Check for successful registration indicators
                    if (is_array($result)) {
                        // Check RegisterResponse format
                        if (isset($result['RegisterResponse'])) {
                            $response = $result['RegisterResponse'];
                            if (isset($response['Expiration']) && !empty($response['Expiration'])) {
                                $registrationSucceeded = true;
                                $expirationTimestamp = $response['Expiration'];
                            }
                            if (isset($response['DomainId'])) {
                                $registrarDomainId = $response['DomainId'];
                            }
                        }
                        // Direct format check
                        elseif (isset($result['Expiration']) && !empty($result['Expiration'])) {
                            $registrationSucceeded = true;
                            $expirationTimestamp = $result['Expiration'];
                            $registrarDomainId = $result['DomainId'] ?? $result['domain_id'] ?? null;
                        }
                    }
                    
                    // Verify by checking if domain now exists in Dynadot account
                    if (!$registrationSucceeded) {
                        $domainInfo = $dynadotService->getDomainInfo($domain);
                        if (!empty($domainInfo) && isset($domainInfo['Status'])) {
                            $registrationSucceeded = strtolower($domainInfo['Status']) === 'active';
                            if (isset($domainInfo['Expiration'])) {
                                $expirationTimestamp = $domainInfo['Expiration'];
                            }
                        }
                    }
                    
                    if ($registrationSucceeded) {
                        // Calculate expiry date from timestamp or default
                        $expiryDate = $expirationTimestamp 
                            ? \Carbon\Carbon::createFromTimestampMs($expirationTimestamp) 
                            : now()->addYears($years);
                        
                        // Calculate next due date (same as expiry for domains)
                        $nextDueDate = $expiryDate->copy();
                        
                        // Save to domains table with active status (use updateOrCreate to avoid duplicates)
                        $domainRecord = \App\Models\Domain::updateOrCreate(
                            ['domain_name' => $domain],
                            [
                                'client_id' => $service->client_id,
                                'order_id' => $service->order_id,
                                'tld' => $tld,
                                'status' => \App\Models\Domain::STATUS_ACTIVE,
                                'order_type' => 'register',
                                'registration_period' => $years,
                                'registration_date' => now(),
                                'expiry_date' => $expiryDate,
                                'next_due_date' => $nextDueDate,
                                'first_payment_amount' => $item->total ?? $item->unit_price ?? 0,
                                'recurring_amount' => $item->unit_price ?? 0,
                                'nameservers' => [
                                    'ns1.mysecurecloudhost.com',
                                    'ns2.mysecurecloudhost.com',
                                    'ns3.mysecurecloudhost.com',
                                    'ns4.mysecurecloudhost.com',
                                ],
                                'auto_renew' => true,
                                'registrar_domain_id' => $registrarDomainId,
                            ]
                        );
                        
                        // Update service - domain data is in domains table, not services
                        // services.domain is cleared for domain services (use domain_registration_id instead)
                        $service->update([
                            'status' => 'active',
                            'domain' => null, // Clear - domain data is in domains table
                            'activated_at' => now(),
                            'expiry_date' => $expiryDate,
                            'domain_registration_id' => $domainRecord->id,
                            'server_data' => [
                                'action' => 'register',
                                'registrar' => 'Dynadot',
                                'registered_at' => now()->toDateTimeString(),
                                'years' => $years,
                            ]
                        ]);
                        
                        Log::info('Domain registered successfully', [
                            'service_id' => $service->id,
                            'domain' => $domain,
                            'domain_record_id' => $domainRecord->id,
                        ]);
                    } else {
                        // Registration API returned but domain was not actually registered
                        // This happens when there's insufficient balance
                        throw new \Exception('Domain registration did not complete - domain not found in Dynadot account');
                    }
                    
                } catch (\Exception $registrationException) {
                    // Registration failed (e.g., insufficient balance, API error)
                    // Save domain with pending status for retry later
                    Log::warning('Domain registration failed, saving with pending status', [
                        'service_id' => $service->id,
                        'domain' => $domain,
                        'error' => $registrationException->getMessage(),
                    ]);
                    
                    $domainRecord = \App\Models\Domain::updateOrCreate(
                        ['domain_name' => $domain],
                        [
                            'client_id' => $service->client_id,
                            'order_id' => $service->order_id,
                            'tld' => $tld,
                            'status' => \App\Models\Domain::STATUS_PENDING,
                            'order_type' => 'register',
                            'registration_period' => $years,
                            'next_due_date' => now()->addYears($years),
                            'first_payment_amount' => $item->total ?? $item->unit_price ?? 0,
                            'recurring_amount' => $item->unit_price ?? 0,
                            'nameservers' => [
                                'ns1.mysecurecloudhost.com',
                                'ns2.mysecurecloudhost.com',
                                'ns3.mysecurecloudhost.com',
                                'ns4.mysecurecloudhost.com',
                            ],
                            'auto_renew' => true,
                        ]
                    );
                    
                    // Update service to pending (not failed) for retry
                    $service->update([
                        'status' => 'pending',
                        'domain_registration_id' => $domainRecord->id,
                        'server_data' => [
                            'action' => 'register',
                            'registrar' => 'Dynadot',
                            'years' => $years,
                            'domain_record_id' => $domainRecord->id,
                            'registration_error' => $registrationException->getMessage(),
                            'attempted_at' => now()->toDateTimeString(),
                        ]
                    ]);
                    
                    Log::info('Domain saved with pending status for retry', [
                        'service_id' => $service->id,
                        'domain' => $domain,
                        'domain_record_id' => $domainRecord->id,
                    ]);
                }
                
            } elseif ($action === 'transfer') {
                // Transfer domain
                $authCode = $item->configuration['auth_code'] ?? '';
                
                // Build transfer options with contact if available
                $transferOptions = [];
                if ($contactId) {
                    $transferOptions['registrant_contact'] = $contactId;
                    $transferOptions['admin_contact'] = $contactId;
                    $transferOptions['technical_contact'] = $contactId;
                    $transferOptions['billing_contact'] = $contactId;
                }
                
                $result = $dynadotService->transferDomain($domain, $authCode, $transferOptions);
                
                if ($result) {
                    // Extract domain name and TLD
                    $domainParts = explode('.', $domain, 2);
                    $domainName = $domainParts[0] ?? $domain;
                    $tld = isset($domainParts[1]) ? '.' . $domainParts[1] : '';
                    
                    // Save to domains table with pending_transfer status (use updateOrCreate to avoid duplicates)
                    $domainRecord = \App\Models\Domain::updateOrCreate(
                        ['domain_name' => $domain],
                        [
                            'client_id' => $service->client_id,
                            'order_id' => $service->order_id,
                            'tld' => $tld,
                            'status' => \App\Models\Domain::STATUS_PENDING_TRANSFER,
                            'order_type' => 'transfer',
                            'registration_period' => $years,
                            'next_due_date' => now()->addYears($years),
                            'first_payment_amount' => $item->total ?? $item->unit_price ?? 0,
                            'recurring_amount' => $item->unit_price ?? 0,
                            'nameservers' => [],
                            'auto_renew' => true,
                        ]
                    );
                    
                    $service->update([
                        'status' => 'pending',
                        'domain_registration_id' => $domainRecord->id,
                        'server_data' => [
                            'action' => 'transfer',
                            'registrar' => 'Dynadot',
                            'transfer_initiated_at' => now()->toDateTimeString(),
                            'domain_record_id' => $domainRecord->id,
                        ]
                    ]);
                    
                    Log::info('Domain transfer initiated', [
                        'service_id' => $service->id,
                        'domain' => $domain,
                        'domain_record_id' => $domainRecord->id,
                    ]);
                }
            } elseif ($action === 'renew') {
                // Renew existing domain
                try {
                    $result = $dynadotService->renewDomain($domain, $years);
                    
                    Log::info('Dynadot renewDomain result', [
                        'domain' => $domain,
                        'years' => $years,
                        'result' => $result,
                    ]);
                    
                    // Check for successful renewal
                    $renewalSucceeded = false;
                    $newExpirationTimestamp = null;
                    
                    if (is_array($result)) {
                        // Check RenewResponse format
                        if (isset($result['RenewResponse'])) {
                            $response = $result['RenewResponse'];
                            if (isset($response['Expiration']) && !empty($response['Expiration'])) {
                                $renewalSucceeded = true;
                                $newExpirationTimestamp = $response['Expiration'];
                            }
                        }
                        // Direct format check
                        elseif (isset($result['Expiration']) && !empty($result['Expiration'])) {
                            $renewalSucceeded = true;
                            $newExpirationTimestamp = $result['Expiration'];
                        }
                        // Success status check
                        elseif (isset($result['Status']) && strtolower($result['Status']) === 'success') {
                            $renewalSucceeded = true;
                        }
                    }
                    
                    // Find existing domain record
                    $domainRecord = \App\Models\Domain::where('domain_name', $domain)->first();
                    
                    if ($renewalSucceeded) {
                        // Update existing domain record with new expiry date
                        if ($domainRecord) {
                            $updateData = [];
                            
                            if ($newExpirationTimestamp) {
                                $updateData['expiry_date'] = \Carbon\Carbon::createFromTimestamp($newExpirationTimestamp / 1000);
                            } else {
                                // Add years to current expiry
                                $currentExpiry = $domainRecord->expiry_date ?? now();
                                $updateData['expiry_date'] = $currentExpiry->addYears($years);
                            }
                            
                            $domainRecord->update($updateData);
                            
                            Log::info('Domain renewal successful - expiry updated', [
                                'domain' => $domain,
                                'new_expiry' => $updateData['expiry_date'],
                            ]);
                        }
                        
                        $service->update([
                            'status' => 'active',
                            'domain_registration_id' => $domainRecord ? $domainRecord->id : null,
                            'server_data' => [
                                'action' => 'renew',
                                'registrar' => 'Dynadot',
                                'renewed_at' => now()->toDateTimeString(),
                                'years_added' => $years,
                                'new_expiration' => $newExpirationTimestamp,
                            ]
                        ]);
                    } else {
                        // Renewal failed or pending
                        $service->update([
                            'status' => 'pending',
                            'domain_registration_id' => $domainRecord ? $domainRecord->id : null,
                            'server_data' => [
                                'action' => 'renew',
                                'registrar' => 'Dynadot',
                                'attempted_at' => now()->toDateTimeString(),
                                'result' => $result,
                            ]
                        ]);
                        
                        Log::warning('Domain renewal may have failed', [
                            'domain' => $domain,
                            'result' => $result,
                        ]);
                    }
                    
                } catch (\Exception $renewError) {
                    Log::error('Domain renewal error', [
                        'domain' => $domain,
                        'error' => $renewError->getMessage(),
                    ]);
                    
                    $service->update([
                        'status' => 'failed',
                        'server_data' => [
                            'action' => 'renew',
                            'error' => $renewError->getMessage(),
                            'attempted_at' => now()->toDateTimeString(),
                        ]
                    ]);
                }
            }
            
        } catch (\Exception $e) {
            Log::error('Domain provisioning error', [
                'service_id' => $service->id,
                'error' => $e->getMessage(),
            ]);
            
            $service->update([
                'status' => 'failed',
                'server_data' => [
                    'error' => $e->getMessage(),
                    'attempted_at' => now()->toDateTimeString(),
                ]
            ]);
        }
    }
    
    /**
     * Generate a valid cPanel username from domain
     */
    private function generateCpanelUsername($domain)
    {
        // Generate completely random username to avoid reserved names
        // cPanel username: max 8 chars, must start with letter, lowercase only
        
        // Start with a letter (a-z)
        $letters = 'abcdefghijklmnopqrstuvwxyz';
        $username = $letters[rand(0, 25)];
        
        // Add 7 more random alphanumeric characters
        $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
        for ($i = 0; $i < 7; $i++) {
            $username .= $chars[rand(0, strlen($chars) - 1)];
        }
        
        return $username;
    }

    private function provisionVPS($service, $item)
    {
        try {
            Log::info('Provisioning VPS via Hetzner Cloud', [
                'service_id' => $service->id,
                'client_id' => $service->client_id,
                'order_id' => $service->order_id,
            ]);

            $client = $service->client;
            $configuration = $item->configuration ?? [];
            
            // Get VPS Plan to fetch hetzner_server_type
            $vpsPlan = null;
            if (isset($configuration['plan'])) {
                $vpsPlan = \App\Models\VpsPlan::find($configuration['plan']);
            }
            
            // If no plan found, try to find from service product name
            if (!$vpsPlan && $service->product_name) {
                $vpsPlan = \App\Models\VpsPlan::where('plan_name', $service->product_name)->first();
            }
            
            // Get VPS configuration from order or plan
            $serverType = $vpsPlan?->hetzner_server_type 
                ?? $configuration['server_type'] 
                ?? 'cx22'; // Default: CX22 (valid server type)
            
            $location = $vpsPlan?->hetzner_location 
                ?? $configuration['location'] 
                ?? 'fsn1'; // Default: Falkenstein
                
            $image = $configuration['image'] ?? 'ubuntu-22.04';
            $hostname = $service->domain ?? 'vps-' . $service->id . '.client.com';
            $label = "VPS-{$client->username}-{$service->id}";
            
            Log::info('VPS Provisioning Details', [
                'server_type' => $serverType,
                'location' => $location,
                'image' => $image,
                'plan_id' => $vpsPlan?->id,
            ]);
            
            // Create server in Hetzner
            $serverData = $this->hetznerService->createServer([
                'name' => $label,
                'server_type' => $serverType,
                'image' => $image,
                'location' => $location,
                'labels' => [
                    'client_id' => (string)$client->id,
                    'service_id' => (string)$service->id,
                    'managed_by' => 'laravel-crm',
                ],
                'start_after_create' => true,
            ]);
            
            // Extract server information
            $server = $serverData['server'];
            $rootPassword = $serverData['root_password'] ?? null;
            
            // Update service with Hetzner details
            $service->update([
                'status' => 'active',
                'server_ip' => $server['public_net']['ipv4']['ip'] ?? null,
                'server_data' => [
                    'hetzner_server_id' => $server['id'],
                    'hetzner_server_name' => $server['name'],
                    'ipv4' => $server['public_net']['ipv4']['ip'] ?? null,
                    'ipv6' => $server['public_net']['ipv6']['ip'] ?? null,
                    'location' => $server['datacenter']['location']['name'] ?? $location,
                    'server_type' => $server['server_type']['name'] ?? $serverType,
                    'created_at' => $server['created'],
                    'root_password' => $rootPassword,
                ]
            ]);
            
            Log::info('VPS provisioned successfully via Hetzner', [
                'service_id' => $service->id,
                'server_id' => $server['id'],
            ]);
            
            // Send email to client with VPS details
            $this->sendVPSDetailsEmail($service, $server, $rootPassword);
            
        } catch (\Exception $e) {
            Log::error('VPS provisioning error via Hetzner', [
                'service_id' => $service->id,
                'error' => $e->getMessage(),
            ]);
            
            $service->update([
                'status' => 'failed',
                'server_data' => [
                    'error' => $e->getMessage(),
                    'attempted_at' => now()->toDateTimeString(),
                    'configuration' => $item->configuration ?? [],
                ]
            ]);
            
            $this->notifyAdminVPSFailed($service, $e->getMessage());
        }
    }

    private function provisionDedicated($service, $item)
    {
        try {
            Log::info('Provisioning Dedicated Server via Hetzner Cloud', [
                'service_id' => $service->id,
                'client_id' => $service->client_id,
                'order_id' => $service->order_id,
            ]);

            $client = $service->client;
            $configuration = $item->configuration ?? [];
            
            // Get Dedicated Server configuration
            $serverType = $configuration['server_type'] ?? 'ccx13'; // Default: CCX13
            $location = $configuration['location'] ?? 'fsn1';
            $image = $configuration['image'] ?? 'ubuntu-22.04';
            $hostname = $service->domain ?? 'dedicated-' . $service->id . '.client.com';
            $label = "Dedicated-{$client->username}-{$service->id}";
            
            // Create server in Hetzner
            $serverData = $this->hetznerService->createServer([
                'name' => $label,
                'server_type' => $serverType,
                'image' => $image,
                'location' => $location,
                'labels' => [
                    'client_id' => (string)$client->id,
                    'service_id' => (string)$service->id,
                    'managed_by' => 'laravel-crm',
                    'server_class' => 'dedicated',
                ],
                'start_after_create' => true,
            ]);
            
            // Extract server information
            $server = $serverData['server'];
            $rootPassword = $serverData['root_password'] ?? null;
            
            // Update service with Hetzner details
            $service->update([
                'status' => 'active',
                'server_ip' => $server['public_net']['ipv4']['ip'] ?? null,
                'server_data' => [
                    'hetzner_server_id' => $server['id'],
                    'hetzner_server_name' => $server['name'],
                    'ipv4' => $server['public_net']['ipv4']['ip'] ?? null,
                    'ipv6' => $server['public_net']['ipv6']['ip'] ?? null,
                    'location' => $server['datacenter']['location']['name'] ?? $location,
                    'server_type' => $server['server_type']['name'] ?? $serverType,
                    'created_at' => $server['created'],
                    'root_password' => $rootPassword,
                    'server_class' => 'dedicated',
                ]
            ]);
            
            Log::info('Dedicated server provisioned successfully via Hetzner', [
                'service_id' => $service->id,
                'server_id' => $server['id'],
            ]);
            
            // Send email to client
            $this->sendDedicatedProvisioningEmail($service, $server, $rootPassword);
            
        } catch (\Exception $e) {
            Log::error('Dedicated Server provisioning error via Hetzner', [
                'service_id' => $service->id,
                'error' => $e->getMessage(),
            ]);
            
            $service->update([
                'status' => 'failed',
                'server_data' => [
                    'error' => $e->getMessage(),
                    'attempted_at' => now()->toDateTimeString(),
                    'configuration' => $item->configuration ?? [],
                ]
            ]);
        }
    }
    
    /**
     * Send VPS details email to client - Disabled
     */
    private function sendVPSDetailsEmail($service, $instance)
    {
        // Disabled due to Vultr removal
    }
    
    /**
     * Send Dedicated Server provisioning email to client - Disabled
     */
    private function sendDedicatedProvisioningEmail($service, $instance)
    {
        try {
            $client = $service->client;
            $order = $service->order;
            $expectedTime = $service->server_data['expected_ready_time'] ?? 'within 24 hours';
            
            $subject = app()->getLocale() == 'ar' 
                ? "السيرفر المخصص قيد التجهيز - #{$order->order_number}"
                : "Dedicated Server Deploying - #{$order->order_number}";
                
            $message = app()->getLocale() == 'ar'
                ? "عزيزي {$client->first_name},\n\nبدأ تجهيز السيرفر المخصص الخاص بك!\n\nرقم الطلب: {$order->order_number}\nاسم الخدمة: {$service->service_name}\n\nمعلومات السيرفر:\nعنوان IP: {$instance['main_ip']}\nنظام التشغيل: {$instance['os']}\nالمنطقة: {$instance['region']}\nالحالة: قيد التجهيز\n\nالسيرفرات المخصصة تستغرق وقتاً أطول للتجهيز (4-24 ساعة) بسبب طبيعتها.\n\nسنرسل لك بيانات الدخول الكاملة بمجرد أن يصبح السيرفر جاهزاً.\n\nشكراً لصبرك!"
                : "Dear {$client->first_name},\n\nYour Dedicated Server deployment has been initiated!\n\nOrder Number: {$order->order_number}\nService Name: {$service->service_name}\n\nServer Information:\nIP Address: {$instance['main_ip']}\nOperating System: {$instance['os']}\nRegion: {$instance['region']}\nStatus: Deploying\n\nDedicated servers take longer to provision (4-24 hours) due to their physical nature.\n\nWe'll send you the complete login credentials once the server is ready.\n\nThank you for your patience!";
            
            Mail::raw($message, function($mail) use ($client, $subject) {
                $mail->to($client->email)
                     ->subject($subject);
            });
            
        } catch (\Exception $e) {
            Log::error('Failed to send Dedicated provisioning email', [
                'service_id' => $service->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
    
    /**
     * Notify admin about VPS created successfully
     */
    private function notifyAdminVPSCreated($service, $instance)
    {
        try {
            $order = $service->order;
            $client = $service->client;
            $adminEmail = setting('admin_email', config('mail.from.address'));
            
            $subject = "✅ VPS Created Successfully - #{$order->order_number}";
            $message = "VPS Instance Created via Vultr API\n\n";
            $message .= "Order: {$order->order_number}\n";
            $message .= "Client: {$client->full_name} ({$client->email})\n";
            $message .= "Service: {$service->service_name}\n\n";
            $message .= "Instance Details:\n";
            $message .= "- Vultr ID: {$instance['id']}\n";
            $message .= "- IP Address: {$instance['main_ip']}\n";
            $message .= "- Region: {$instance['region']}\n";
            $message .= "- Plan: {$instance['plan']}\n";
            $message .= "- OS: {$instance['os']}\n";
            
            Mail::raw($message, function($mail) use ($adminEmail, $subject) {
                $mail->to($adminEmail)->subject($subject);
            });
            
        } catch (\Exception $e) {
            Log::error('Failed to notify admin VPS created', ['error' => $e->getMessage()]);
        }
    }
    
    /**
     * Notify admin about Dedicated Server created successfully
     */
    private function notifyAdminDedicatedCreated($service, $instance)
    {
        try {
            $order = $service->order;
            $client = $service->client;
            $adminEmail = setting('admin_email', config('mail.from.address'));
            
            $subject = "✅ Bare Metal Server Deploying - #{$order->order_number}";
            $message = "Bare Metal Instance Deployment Started via Vultr API\n\n";
            $message .= "Order: {$order->order_number}\n";
            $message .= "Client: {$client->full_name} ({$client->email})\n";
            $message .= "Service: {$service->service_name}\n\n";
            $message .= "Instance Details:\n";
            $message .= "- Vultr ID: {$instance['id']}\n";
            $message .= "- IP Address: {$instance['main_ip']}\n";
            $message .= "- Region: {$instance['region']}\n";
            $message .= "- Plan: {$instance['plan']}\n";
            $message .= "- OS: {$instance['os']}\n";
            $message .= "- Status: Deploying (will take 4-24 hours)\n\n";
            $message .= "Monitor deployment at: https://my.vultr.com/\n";
            
            Mail::raw($message, function($mail) use ($adminEmail, $subject) {
                $mail->to($adminEmail)->subject($subject);
            });
            
        } catch (\Exception $e) {
            Log::error('Failed to notify admin Dedicated created', ['error' => $e->getMessage()]);
        }
    }
    
    /**
     * Notify admin about VPS provisioning failure
     */
    private function notifyAdminVPSFailed($service, $errorMessage)
    {
        try {
            $order = $service->order;
            $client = $service->client;
            $adminEmail = setting('admin_email', config('mail.from.address'));
            
            $subject = "❌ VPS Provisioning Failed - #{$order->order_number}";
            $message = "URGENT: VPS provisioning failed via Vultr API\n\n";
            $message .= "Order: {$order->order_number}\n";
            $message .= "Client: {$client->full_name} ({$client->email})\n";
            $message .= "Service: {$service->service_name}\n\n";
            $message .= "Error: {$errorMessage}\n\n";
            $message .= "Please review and manually provision this VPS.\n";
            $message .= "Service URL: " . url('/admin/services/' . $service->id) . "\n";
            
            Mail::raw($message, function($mail) use ($adminEmail, $subject) {
                $mail->to($adminEmail)->subject($subject);
            });
            
        } catch (\Exception $e) {
            Log::error('Failed to notify admin VPS failed', ['error' => $e->getMessage()]);
        }
    }
    
    /**
     * Notify admin about Dedicated Server provisioning failure
     */
    private function notifyAdminDedicatedFailed($service, $errorMessage)
    {
        try {
            $order = $service->order;
            $client = $service->client;
            $adminEmail = setting('admin_email', config('mail.from.address'));
            
            $subject = "❌ Bare Metal Provisioning Failed - #{$order->order_number}";
            $message = "URGENT: Bare Metal server provisioning failed via Vultr API\n\n";
            $message .= "Order: {$order->order_number}\n";
            $message .= "Client: {$client->full_name} ({$client->email})\n";
            $message .= "Service: {$service->service_name}\n\n";
            $message .= "Error: {$errorMessage}\n\n";
            $message .= "Please review and manually provision this Dedicated Server.\n";
            $message .= "Service URL: " . url('/admin/services/' . $service->id) . "\n";
            
            Mail::raw($message, function($mail) use ($adminEmail, $subject) {
                $mail->to($adminEmail)->subject($subject);
            });
            
        } catch (\Exception $e) {
            Log::error('Failed to notify admin Dedicated failed', ['error' => $e->getMessage()]);
        }
    }
    
    /**
     * Notify admin about new VPS order (DEPRECATED - kept for compatibility)
     */
    private function notifyAdminNewVPSOrder($service)
    {
        try {
            $order = $service->order;
            $client = $service->client;
            
            // Get admin emails from settings or use default
            $adminEmail = setting('admin_email', config('mail.from.address'));
            
            $subject = "New VPS Order - Manual Setup Required #{$order->order_number}";
            $message = "New VPS Order Received\n\n";
            $message .= "Order Number: {$order->order_number}\n";
            $message .= "Client: {$client->full_name} ({$client->email})\n";
            $message .= "Service: {$service->service_name}\n";
            $message .= "Domain: {$service->domain}\n";
            $message .= "Status: Pending - Requires Manual Setup\n\n";
            $message .= "Please login to admin panel to configure this VPS:\n";
            $message .= url('/admin/services/' . $service->id) . "\n\n";
            $message .= "Configuration Details:\n";
            if (isset($service->server_data['configuration'])) {
                foreach ($service->server_data['configuration'] as $key => $value) {
                    $message .= "- " . ucfirst(str_replace('_', ' ', $key)) . ": {$value}\n";
                }
            }
            
            Mail::raw($message, function($mail) use ($adminEmail, $subject) {
                $mail->to($adminEmail)
                     ->subject($subject);
            });
            
            Log::info('Admin notified about new VPS order', [
                'service_id' => $service->id,
                'admin_email' => $adminEmail,
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to send admin VPS notification', [
                'service_id' => $service->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
    
    /**
     * Notify admin about new Dedicated Server order
     */
    private function notifyAdminNewDedicatedOrder($service)
    {
        try {
            $order = $service->order;
            $client = $service->client;
            
            $adminEmail = setting('admin_email', config('mail.from.address'));
            
            $subject = "New Dedicated Server Order - Manual Setup Required #{$order->order_number}";
            $message = "New Dedicated Server Order Received\n\n";
            $message .= "⚠️ URGENT: Hardware allocation required\n\n";
            $message .= "Order Number: {$order->order_number}\n";
            $message .= "Client: {$client->full_name} ({$client->email})\n";
            $message .= "Service: {$service->service_name}\n";
            $message .= "Domain: {$service->domain}\n";
            $message .= "Status: Pending - Requires Hardware Allocation & Setup\n\n";
            $message .= "Please login to admin panel to configure this Dedicated Server:\n";
            $message .= url('/admin/services/' . $service->id) . "\n\n";
            $message .= "Configuration Details:\n";
            if (isset($service->server_data['configuration'])) {
                foreach ($service->server_data['configuration'] as $key => $value) {
                    $message .= "- " . ucfirst(str_replace('_', ' ', $key)) . ": {$value}\n";
                }
            }
            
            Mail::raw($message, function($mail) use ($adminEmail, $subject) {
                $mail->to($adminEmail)
                     ->subject($subject);
            });
            
            Log::info('Admin notified about new Dedicated Server order', [
                'service_id' => $service->id,
                'admin_email' => $adminEmail,
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to send admin Dedicated Server notification', [
                'service_id' => $service->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
    
    /**
     * Notify client that VPS is pending setup
     */
    private function notifyClientVPSPending($service)
    {
        try {
            $client = $service->client;
            $order = $service->order;
            
            $subject = app()->getLocale() == 'ar' 
                ? "طلب VPS قيد المعالجة - #{$order->order_number}"
                : "VPS Order Being Processed - #{$order->order_number}";
                
            $message = app()->getLocale() == 'ar'
                ? "عزيزي {$client->first_name},\n\nشكراً لطلبك VPS!\n\nرقم الطلب: {$order->order_number}\nاسم الخدمة: {$service->service_name}\n\nطلبك قيد المعالجة حالياً. سيقوم فريقنا بإعداد VPS الخاص بك وسنرسل لك بيانات الدخول خلال 24-48 ساعة.\n\nسيتم إرسال:\n- عنوان IP الخاص بالسيرفر\n- بيانات تسجيل الدخول (Username & Password)\n- معلومات الوصول للوحة التحكم\n\nشكراً لثقتك بنا!"
                : "Dear {$client->first_name},\n\nThank you for ordering a VPS!\n\nOrder Number: {$order->order_number}\nService Name: {$service->service_name}\n\nYour order is currently being processed. Our team will set up your VPS and send you the login credentials within 24-48 hours.\n\nYou will receive:\n- Server IP Address\n- Login credentials (Username & Password)\n- Control panel access information\n\nThank you for choosing us!";
            
            Mail::raw($message, function($mail) use ($client, $subject) {
                $mail->to($client->email)
                     ->subject($subject);
            });
            
        } catch (\Exception $e) {
            Log::error('Failed to send client VPS pending notification', [
                'service_id' => $service->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
    
    /**
     * Notify client that Dedicated Server is pending setup
     */
    private function notifyClientDedicatedPending($service)
    {
        try {
            $client = $service->client;
            $order = $service->order;
            
            $subject = app()->getLocale() == 'ar' 
                ? "طلب السيرفر المخصص قيد المعالجة - #{$order->order_number}"
                : "Dedicated Server Order Being Processed - #{$order->order_number}";
                
            $message = app()->getLocale() == 'ar'
                ? "عزيزي {$client->first_name},\n\nشكراً لطلبك سيرفر مخصص!\n\nرقم الطلب: {$order->order_number}\nاسم الخدمة: {$service->service_name}\n\nطلبك قيد المعالجة حالياً. نظراً لطبيعة السيرفرات المخصصة، سيقوم فريقنا بتخصيص الأجهزة اللازمة وإعداد السيرفر الخاص بك. ستتلقى بيانات الدخول خلال 48-72 ساعة.\n\nسيتم إرسال:\n- عنوان IP الخاص بالسيرفر\n- بيانات الوصول الكاملة (Root Access)\n- معلومات المواصفات الفنية\n- معلومات الشبكة والاتصال\n\nشكراً لثقتك بنا!"
                : "Dear {$client->first_name},\n\nThank you for ordering a Dedicated Server!\n\nOrder Number: {$order->order_number}\nService Name: {$service->service_name}\n\nYour order is currently being processed. Due to the nature of dedicated servers, our team will allocate the necessary hardware and set up your server. You will receive login credentials within 48-72 hours.\n\nYou will receive:\n- Server IP Address\n- Full access credentials (Root Access)\n- Technical specifications\n- Network and connectivity information\n\nThank you for choosing us!";
            
            Mail::raw($message, function($mail) use ($client, $subject) {
                $mail->to($client->email)
                     ->subject($subject);
            });
            
        } catch (\Exception $e) {
            Log::error('Failed to send client Dedicated Server pending notification', [
                'service_id' => $service->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function sendOrderConfirmationEmail($client, $order, $invoice)
    {
        try {
            // Load relationships if not loaded
            $order->load(['items', 'services']);
            
            Mail::to($client->email)->send(new \App\Mail\OrderConfirmationMail($order, $client, $invoice));
            
            Log::info('Order confirmation email sent', [
                'order_id' => $order->id,
                'client_email' => $client->email,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send order confirmation email', [
                'order_id' => $order->id ?? null,
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function validateTurnstile($token)
    {
        if (!$token) {
            return false;
        }

        try {
            $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'secret' => config('services.turnstile.secret_key'),
                'response' => $token,
                'remoteip' => request()->ip(),
            ]);

            if ($response->successful()) {
                $result = $response->json();
                return $result['success'] ?? false;
            }

            return false;
        } catch (\Exception $e) {
            Log::error('Turnstile validation failed', ['error' => $e->getMessage()]);
            return false;
        }
    }

    public function success($orderId)
    {
        $order = Order::with(['items', 'invoice', 'services.domainRegistration'])->findOrFail($orderId);
        
        if ($order->client_id !== Auth::guard('client')->id()) {
            abort(403);
        }

        // التحقق من وجود invoice_id في الـ session (للفواتير المنفصلة)
        $invoiceId = session('payment_invoice_id');
        $targetInvoice = null;
        
        if ($invoiceId) {
            $targetInvoice = \App\Models\Invoice::where('id', $invoiceId)
                ->where('order_id', $orderId)
                ->first();
            
            // مسح الـ session بعد الاستخدام
            session()->forget('payment_invoice_id');
        }

        return view('frontend.client.order-success', compact('order', 'targetInvoice'));
    }

    public function failed($orderId)
    {
        $order = Order::findOrFail($orderId);
        
        if ($order->client_id !== Auth::guard('client')->id()) {
            abort(403);
        }

        return view('frontend.client.order-failed', compact('order'));
    }
    
    /**
     * إعادة محاولة الدفع للطلب
     */
    public function retryPayment(Request $request, $orderId)
    {
        $order = Order::with(['invoice'])->findOrFail($orderId);
        
        // التحقق من أن الطلب يخص العميل الحالي
        if ($order->client_id !== Auth::guard('client')->id()) {
            abort(403);
        }
        
        // متغير منفصل للفاتورة المستخدمة
        $targetInvoice = null;
        
        // إذا كان هناك invoice_id في الطلب، نتأكد من حالة الـ invoice
        $invoiceId = $request->input('invoice_id');
        if ($invoiceId) {
            $invoice = Invoice::where('id', $invoiceId)
                ->where('order_id', $orderId)
                ->where('client_id', Auth::guard('client')->id())
                ->firstOrFail();
            
            // التحقق من أن الفاتورة غير مدفوعة
            if ($invoice->status === 'paid') {
                return redirect()->route('client.invoices.show', $invoiceId)
                    ->with('error', __('frontend.invoice_already_paid'));
            }
            
            // استخدام الفاتورة المحددة
            $targetInvoice = $invoice;
        } else {
            // التحقق من أن الطلب في حالة pending أو failed
            if (!in_array($order->payment_status, ['pending', 'failed'])) {
                return redirect()->route('client.dashboard')
                    ->with('error', __('frontend.order_already_paid'));
            }
            
            // استخدام فاتورة الطلب الأساسية
            $targetInvoice = $order->invoice;
        }
        
        try {
            // الحصول على طريقة الدفع من الـ request
            $paymentMethod = $request->input('payment_method_id', session('payment_method_id', 2));
            
            // حفظ في الـ session للاستخدام المستقبلي
            session(['payment_method_id' => $paymentMethod]);
            
            // إذا كان هناك invoice محدد، نحفظه في الـ session
            if ($invoiceId) {
                session(['payment_invoice_id' => $invoiceId]);
            }
            
            // التحقق من طريقة الدفع
            if ($paymentMethod === 'wallet') {
                // الدفع عن طريق المحفظة
                $client = Auth::guard('client')->user();
                $amount = $targetInvoice ? $targetInvoice->total : $order->total;
                
                // التحقق من الرصيد
                if ($client->wallet_balance < $amount) {
                    return redirect()->back()
                        ->with('error', __('frontend.insufficient_wallet_balance'));
                }
                
                // خصم المبلغ من المحفظة
                $client->wallet_balance -= $amount;
                $client->save();
                
                // تسجيل المعاملة
                \App\Models\WalletTransaction::create([
                    'client_id' => $client->id,
                    'type' => 'deduction',
                    'amount' => $amount,
                    'balance_after' => $client->wallet_balance,
                    'description' => 'Payment for Invoice #' . ($targetInvoice ? $targetInvoice->invoice_number : $order->invoice->invoice_number),
                    'status' => 'completed',
                ]);
                
                // تحديث حالة الفاتورة
                if ($targetInvoice) {
                    $targetInvoice->status = 'paid';
                    $targetInvoice->paid_amount = $targetInvoice->total;
                    $targetInvoice->balance = 0;
                    $targetInvoice->paid_at = now();
                    $targetInvoice->save();
                } else {
                    $order->invoice->status = 'paid';
                    $order->invoice->paid_amount = $order->invoice->total;
                    $order->invoice->balance = 0;
                    $order->invoice->paid_at = now();
                    $order->invoice->save();
                }
                
                // توجيه للنجاح
                return redirect()->route('payment.success', ['order' => $order->id])
                    ->with('success', __('frontend.payment_successful'));
            }
            
            // إعادة إنشاء رابط الدفع (للطرق الأخرى)
            $paymentResponse = $this->createFawaterakPayment($order, $targetInvoice, $paymentMethod);
            
            Log::info('Payment response in retryPayment', [
                'payment_response' => $paymentResponse,
                'is_array' => is_array($paymentResponse),
                'payment_method' => $paymentMethod
            ]);
            
            // التحقق من نوع الاستجابة
            if (is_array($paymentResponse)) {
                if (isset($paymentResponse['redirect']) && $paymentResponse['redirect'] && isset($paymentResponse['url'])) {
                    Log::info('Redirecting to URL', ['url' => $paymentResponse['url']]);
                    return redirect($paymentResponse['url']);
                }
                // إذا كان المصفوفة لا تحتوي على redirect، نرجع لصفحة pending
                Log::info('No redirect URL, going to pending');
                return redirect()->route('payment.pending', ['order' => $order->id]);
            }
            
            // إذا كان string مباشر (legacy support)
            Log::info('String response, redirecting', ['url' => $paymentResponse]);
            return redirect($paymentResponse);
            
        } catch (\Exception $e) {
            Log::error('Payment retry failed', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Pass the actual error message from Fawaterak instead of generic translation
            return redirect()->route('order.failed', ['order' => $order->id])
                ->with('error', $e->getMessage());
        }
    }
    
    /**
     * توليد اسم المنتج من السلة مع جلب الأسماء من قاعدة البيانات
     */
    private function getProductName($item)
    {
        switch ($item['type']) {
            case 'domain':
                $action = $item['action'] ?? 'register';
                $domain = $item['domain'] ?? 'N/A';
                
                if ($action === 'transfer') {
                    return 'Domain Transfer - ' . $domain;
                } elseif ($action === 'renew') {
                    return 'Domain Renewal - ' . $domain;
                }
                return 'Domain Registration - ' . $domain;
                
            case 'hosting':
                $planName = 'Shared Hosting';
                // استخدام product_id بدلاً من plan_id
                if (isset($item['product_id'])) {
                    $product = \App\Models\Product::find($item['product_id']);
                    if ($product) {
                        $planName = $product->name_en ?? $product->name;
                    }
                }
                return $planName . ' - ' . ($item['domain'] ?? 'N/A');
                
            case 'vps':
                $planName = 'VPS Plan';
                if (isset($item['plan_id'])) {
                    $vpsPlan = \App\Models\VpsPlan::find($item['plan_id']);
                    if ($vpsPlan) {
                        $planName = $vpsPlan->name_en ?? $vpsPlan->name;
                    }
                }
                return $planName;
                
            case 'dedicated':
                $planName = 'Dedicated Server';
                if (isset($item['plan_id'])) {
                    $dedicatedPlan = \App\Models\DedicatedPlan::find($item['plan_id']);
                    if ($dedicatedPlan) {
                        $planName = $dedicatedPlan->name_en ?? $dedicatedPlan->name;
                    }
                }
                return $planName;
                
            default:
                return $item['type'] ?? 'Unknown Product';
        }
    }

    private function getPlanName($item)
    {
        switch ($item['type']) {
            case 'hosting':
                // استخدام product_id بدلاً من plan_id
                if (isset($item['product_id'])) {
                    $product = \App\Models\Product::find($item['product_id']);
                    if ($product) {
                        return $product->name_en ?? $product->name;
                    }
                }
                return null;
                
            case 'vps':
                if (isset($item['plan_id'])) {
                    $vpsPlan = \App\Models\VpsPlan::find($item['plan_id']);
                    if ($vpsPlan) {
                        return $vpsPlan->name_en ?? $vpsPlan->name;
                    }
                }
                return null;
                
            case 'dedicated':
                if (isset($item['plan_id'])) {
                    $dedicatedPlan = \App\Models\DedicatedPlan::find($item['plan_id']);
                    if ($dedicatedPlan) {
                        return $dedicatedPlan->name_en ?? $dedicatedPlan->name;
                    }
                }
                return null;
                
            default:
                return null;
        }
    }

    private function getProductType($item)
    {
        switch ($item['type']) {
            case 'domain':
                return 'Domain';
                
            case 'hosting':
                if (isset($item['product_id'])) {
                    $product = \App\Models\Product::find($item['product_id']);
                    if ($product && $product->category) {
                        // تنظيف القيمة من الشرطة السفلية و "Hosting"
                        $category = str_replace(['_hosting', ' Hosting', 'hosting'], '', strtolower($product->category));
                        $category = trim($category, '_ ');
                        
                        // عرض نوع الاستضافة حسب الفئة فقط
                        $categoryMap = [
                            'shared' => 'Shared',
                            'cloud' => 'Cloud',
                            'startup' => 'Startup',
                            'reseller' => 'Reseller',
                            'wordpress' => 'WordPress',
                        ];
                        return $categoryMap[$category] ?? ucfirst($category);
                    }
                }
                return 'Shared';
                
            case 'vps':
                return 'VPS';
                
            case 'dedicated':
                return 'Dedicated';
                
            default:
                return ucfirst($item['type'] ?? 'Unknown');
        }
    }
}
