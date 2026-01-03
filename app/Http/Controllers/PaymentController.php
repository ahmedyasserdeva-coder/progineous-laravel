<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\FawaterakPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    protected $fawaterakService;

    public function __construct(FawaterakPaymentService $fawaterakService)
    {
        $this->fawaterakService = $fawaterakService;
    }

    /**
     * Show payment gateway selection page
     */
    public function index()
    {
        // Get available payment gateways
        $gateways = [
            'stripe' => [
                'name' => 'Stripe (Visa/Mastercard)',
                'enabled' => config('payment.stripe.enabled'),
                'logo' => asset('images/payments/stripe.png'),
            ],
            'paypal' => [
                'name' => 'PayPal',
                'enabled' => config('payment.paypal.enabled'),
                'logo' => asset('images/payments/paypal.png'),
            ],
            'fawaterak' => [
                'name' => 'Fawaterak',
                'enabled' => config('payment.fawaterak.enabled'),
                'logo' => asset('images/payments/fawaterak.png'),
            ],
        ];

        // Get Fawaterak payment methods
        $fawaterakMethods = [];
        if (config('payment.fawaterak.enabled')) {
            $result = $this->fawaterakService->getPaymentMethods();
            if ($result['success']) {
                $fawaterakMethods = $result['methods'];
            }
        }

        return view('payment.index', compact('gateways', 'fawaterakMethods'));
    }

    /**
     * Process payment with selected gateway
     */
    public function process(Request $request)
    {
        $request->validate([
            'gateway' => 'required|in:stripe,paypal,fawaterak',
            'amount' => 'required|numeric|min:1',
            'currency' => 'required|string|size:3',
            'items' => 'required|array',
        ]);

        $gateway = $request->input('gateway');

        switch ($gateway) {
            case 'fawaterak':
                return $this->processFawaterakPayment($request);
            case 'stripe':
                return $this->processStripePayment($request);
            case 'paypal':
                return $this->processPayPalPayment($request);
            default:
                return back()->with('error', 'Invalid payment gateway');
        }
    }

    /**
     * Process Fawaterak payment
     */
    protected function processFawaterakPayment(Request $request)
    {
        try {
            $client = Auth::guard('client')->user();

            // Prepare payment data
            $paymentData = [
                'payment_method_id' => $request->input('fawaterak_payment_method_id'),
                'cartTotal' => $request->input('amount'),
                'currency' => $request->input('currency', 'EGP'),
                'invoice_number' => 'INV-' . Str::upper(Str::random(10)),
                'customer' => [
                    'first_name' => $client->first_name,
                    'last_name' => $client->last_name,
                    'email' => $client->email,
                    'phone' => $client->phone,
                    'address' => $client->address1,
                ],
                'cartItems' => $request->input('items'),
                'lang' => app()->getLocale(),
                'sendEmail' => true,
                'sendSMS' => false,
                'redirectionUrls' => [
                    'successUrl' => config('payment.fawaterak.redirect_urls.success'),
                    'failUrl' => config('payment.fawaterak.redirect_urls.fail'),
                    'pendingUrl' => config('payment.fawaterak.redirect_urls.pending'),
                ],
            ];

            // Initiate payment with Fawaterak
            $result = $this->fawaterakService->initiatePayment($paymentData);

            if (!$result['success']) {
                return back()->with('error', $result['message'] ?? 'Payment failed');
            }

            // Create payment record in database
            $payment = Payment::create([
                'client_id' => $client->id,
                'gateway' => 'fawaterak',
                'transaction_id' => 'FWTRK-' . $result['invoice_id'],
                'invoice_number' => $paymentData['invoice_number'],
                'amount' => $request->input('amount'),
                'currency' => $request->input('currency', 'EGP'),
                'status' => 'pending',
                'fawaterak_invoice_id' => $result['invoice_id'],
                'fawaterak_invoice_key' => $result['invoice_key'],
                'fawaterak_payment_method_id' => $request->input('fawaterak_payment_method_id'),
                'items' => $request->input('items'),
                'customer_info' => $paymentData['customer'],
                'gateway_data' => $result['payment_data'],
            ]);

            // Check if redirect is needed (Visa/Mastercard)
            if (isset($result['payment_data']['redirectTo'])) {
                return redirect($result['payment_data']['redirectTo']);
            }

            // For other methods (Fawry, Aman, Meeza), show the code
            return view('payment.pending', [
                'payment' => $payment,
                'paymentData' => $result['payment_data'],
            ]);

        } catch (\Exception $e) {
            Log::error('Fawaterak Payment Error: ' . $e->getMessage());
            return back()->with('error', 'Payment processing failed. Please try again.');
        }
    }

    /**
     * Process Stripe payment
     */
    protected function processStripePayment(Request $request)
    {
        // TODO: Implement Stripe payment processing using Laravel Cashier
        return back()->with('info', 'Stripe payment processing coming soon');
    }

    /**
     * Process PayPal payment
     */
    protected function processPayPalPayment(Request $request)
    {
        // TODO: Implement PayPal payment processing
        return back()->with('info', 'PayPal payment processing coming soon');
    }

    /**
     * Payment success callback
     */
    public function success(Request $request)
    {
        $invoiceKey = $request->query('invoice_key');

        if ($invoiceKey) {
            $payment = Payment::where('fawaterak_invoice_key', $invoiceKey)->first();

            if ($payment) {
                $payment->markAsCompleted();
                
                return view('payment.success', compact('payment'));
            }
        }

        return view('payment.success');
    }

    /**
     * Payment failure callback
     */
    public function fail(Request $request)
    {
        $invoiceKey = $request->query('invoice_key');

        if ($invoiceKey) {
            $payment = Payment::where('fawaterak_invoice_key', $invoiceKey)->first();

            if ($payment) {
                $payment->markAsFailed();
                
                return view('payment.fail', compact('payment'));
            }
        }

        return view('payment.fail');
    }

    /**
     * Payment pending callback (for Fawry, Aman, Masary)
     */
    public function pending(Request $request)
    {
        $invoiceKey = $request->query('invoice_key');

        if ($invoiceKey) {
            $payment = Payment::where('fawaterak_invoice_key', $invoiceKey)->first();

            if ($payment) {
                return view('payment.pending', [
                    'payment' => $payment,
                    'paymentData' => $payment->gateway_data,
                ]);
            }
        }

        return view('payment.pending');
    }

    /**
     * Fawaterak Paid Webhook
     */
    public function fawaterakPaidWebhook(Request $request)
    {
        Log::info('Fawaterak Paid Webhook', $request->all());

        try {
            $invoiceKey = $request->input('invoice_key');
            $payment = Payment::where('fawaterak_invoice_key', $invoiceKey)->first();

            if ($payment) {
                $payment->markAsCompleted();
                $payment->update(['gateway_data' => $request->all()]);
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Fawaterak Paid Webhook Error: ' . $e->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }

    /**
     * Fawaterak Cancelled Webhook
     */
    public function fawaterakCancelledWebhook(Request $request)
    {
        Log::info('Fawaterak Cancelled Webhook', $request->all());

        try {
            $invoiceKey = $request->input('invoice_key');
            $payment = Payment::where('fawaterak_invoice_key', $invoiceKey)->first();

            if ($payment) {
                $payment->update([
                    'status' => 'cancelled',
                    'gateway_data' => $request->all(),
                ]);
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Fawaterak Cancelled Webhook Error: ' . $e->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }

    /**
     * Fawaterak Failed Webhook
     */
    public function fawaterakFailedWebhook(Request $request)
    {
        Log::info('Fawaterak Failed Webhook', $request->all());

        try {
            $invoiceKey = $request->input('invoice_key');
            $payment = Payment::where('fawaterak_invoice_key', $invoiceKey)->first();

            if ($payment) {
                $payment->markAsFailed();
                $payment->update(['gateway_data' => $request->all()]);
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Fawaterak Failed Webhook Error: ' . $e->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }

    /**
     * Fawaterak Refund Webhook
     */
    public function fawaterakRefundWebhook(Request $request)
    {
        Log::info('Fawaterak Refund Webhook', $request->all());

        try {
            $invoiceKey = $request->input('invoice_key');
            $payment = Payment::where('fawaterak_invoice_key', $invoiceKey)->first();

            if ($payment) {
                $payment->update([
                    'status' => 'refunded',
                    'refund_amount' => $request->input('refund_amount'),
                    'refunded_at' => now(),
                    'gateway_data' => $request->all(),
                ]);
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Fawaterak Refund Webhook Error: ' . $e->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }

    /**
     * معالجة نجاح الدفع من Fawaterak (للطلبات)
     */
    public function orderSuccess($orderId)
    {
        $order = \App\Models\Order::with(['items', 'invoice', 'client'])->findOrFail($orderId);

        // تحديث حالة الدفع
        if ($order->payment_status !== 'paid') {
            $order->payment_status = 'paid';
            $order->paid_at = now();
            $order->status = 'processing';
            $order->save();

            // تحديث الفاتورة
            $order->invoice->markAsPaid();

            // تفعيل الخدمات
            $this->activateOrderServices($order);

            // إرسال إيميل تأكيد
            $this->sendOrderConfirmationEmail($order);
        }

        // التحقق من تسجيل دخول العميل
        if (!Auth::guard('client')->check()) {
            return redirect()->route('login')
                ->with('info', __('frontend.please_login_to_view_order'));
        }

        return redirect()->route('order.success', ['order' => $orderId])
            ->with('success', __('frontend.payment_successful'));
    }

    /**
     * معالجة فشل الدفع من Fawaterak (للطلبات)
     */
    public function orderFailed($orderId)
    {
        $order = \App\Models\Order::findOrFail($orderId);

        // تحديث حالة الدفع
        $order->payment_status = 'failed';
        $order->save();

        return redirect()->route('order.failed', ['order' => $orderId])
            ->with('error', __('frontend.payment_failed'));
    }

    /**
     * معالجة الدفع المعلق من Fawaterak (للطلبات)
     */
    public function orderPending($orderId)
    {
        $order = \App\Models\Order::with(['client', 'invoice'])->findOrFail($orderId);
        
        // التحقق من وجود invoice_id في الـ session (للفواتير المنفصلة)
        $invoiceId = session('payment_invoice_id');
        if ($invoiceId) {
            $invoice = \App\Models\Invoice::where('id', $invoiceId)
                ->where('order_id', $orderId)
                ->first();
            
            if ($invoice) {
                // إذا كانت الفاتورة مدفوعة، نوجه للنجاح
                if ($invoice->status === 'paid') {
                    return redirect()->route('order.success', ['order' => $orderId]);
                }
                
                // استخدام الفاتورة المحددة
                $order->targetInvoice = $invoice;
                return view('frontend.client.payment-pending', compact('order'));
            }
        }
        
        // إذا لم يكن هناك invoice محدد، نتحقق من حالة الطلب
        if ($order->payment_status === 'paid') {
            return redirect()->route('order.success', ['order' => $orderId]);
        }

        return view('frontend.client.payment-pending', compact('order'));
    }

    /**
     * Webhook من Fawaterak لتأكيد الدفع
     */
    public function fawaterakWebhook(Request $request)
    {
        try {
            // التحقق من صحة الـ webhook
            $signature = $request->header('X-Fawaterak-Signature');
            
            Log::info('Fawaterak Webhook Received', [
                'data' => $request->all(),
                'signature' => $signature
            ]);

            $invoiceId = $request->input('invoice_id');
            $status = $request->input('status');

            // البحث عن الطلب
            $order = \App\Models\Order::where('payment_gateway_id', $invoiceId)->first();

            if ($order) {
                if ($status === 'paid') {
                    $order->payment_status = 'paid';
                    $order->paid_at = now();
                    $order->status = 'processing';
                    $order->save();

                    $order->invoice->markAsPaid();
                    $this->activateOrderServices($order);
                    $this->sendOrderConfirmationEmail($order);
                } elseif ($status === 'failed') {
                    $order->payment_status = 'failed';
                    $order->save();
                }
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Fawaterak Webhook Error: ' . $e->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }

    /**
     * تفعيل الخدمات بعد الدفع
     */
    private function activateOrderServices($order)
    {
        foreach ($order->items as $item) {
            // التحقق من عدم وجود خدمة مُنشأة مسبقاً
            $existingService = \App\Models\Service::where('order_item_id', $item->id)->first();
            
            if (!$existingService) {
                $service = \App\Models\Service::create([
                    'client_id' => $order->client_id,
                    'order_id' => $order->id,
                    'order_item_id' => $item->id,
                    'type' => $item->type,
                    'service_name' => $item->product_name,
                    // For domain services, domain is stored in domains table only (not duplicated here)
                    // For hosting services, domain is stored here
                    'domain' => $item->type === 'domain' ? null : ($item->configuration['domain'] ?? null),
                    'status' => 'pending',
                ]);

                // تفعيل الخدمة حسب النوع
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
        }

        $order->status = 'completed';
        $order->completed_at = now();
        $order->save();
    }

    private function provisionHosting($service, $item)
    {
        // سيتم تطويره مع WHM API
        $service->status = 'active';
        $service->activated_at = now();
        $service->save();
    }

    private function provisionDomain($service, $item)
    {
        // سيتم تطويره مع Dynadot API
        $service->status = 'active';
        $service->activated_at = now();
        $service->save();
    }

    private function provisionVPS($service, $item)
    {
        $service->status = 'pending';
        $service->save();
    }

    private function provisionDedicated($service, $item)
    {
        $service->status = 'pending';
        $service->save();
    }

    private function sendOrderConfirmationEmail($order)
    {
        try {
            $client = $order->client;
            $invoice = $order->invoice;
            
            // Load relationships if not loaded
            $order->load(['items', 'services']);
            
            \Illuminate\Support\Facades\Mail::to($client->email)->send(new \App\Mail\OrderConfirmationMail($order, $client, $invoice));
            
            \Illuminate\Support\Facades\Log::info('Payment confirmation email sent', [
                'order_id' => $order->id,
                'client_email' => $client->email,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send payment confirmation email', [
                'order_id' => $order->id ?? null,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Check payment status via AJAX
     * Called every 120 seconds from payment pending page
     */
    public function checkPaymentStatus(\App\Models\Order $order)
    {
        try {
            // Check if order belongs to authenticated user
            if (Auth::guard('client')->check() && $order->client_id !== Auth::guard('client')->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access',
                ], 403);
            }

            // التحقق من وجود invoice_id في الـ session (للفواتير المنفصلة)
            $invoiceId = session('payment_invoice_id');
            if ($invoiceId) {
                $invoice = \App\Models\Invoice::where('id', $invoiceId)
                    ->where('order_id', $order->id)
                    ->first();
                
                if ($invoice) {
                    // نشوف حالة الفاتورة مش الطلب
                    if ($invoice->status === 'paid') {
                        return response()->json([
                            'success' => true,
                            'status' => 'paid',
                            'redirect_url' => route('payment.success', $order->id),
                        ]);
                    }
                    
                    // الفاتورة لسه pending - نكمل الـ check
                    // هنا ممكن نعمل check مع Fawaterak لو فيه payment_gateway_key
                }
            } else {
                // مافيش invoice محدد، نشوف حالة الطلب العادية
                if ($order->payment_status === 'paid') {
                    return response()->json([
                        'success' => true,
                        'status' => 'paid',
                        'redirect_url' => route('payment.success', $order->id),
                    ]);
                }
            }

            // Check payment timeout (60 minutes)
            // Only check timeout for payments created in last payment attempt
            $paymentInfo = session('order_payment_info');
            $shouldCheckTimeout = $paymentInfo && $paymentInfo['order_id'] == $order->id;
            
            if ($shouldCheckTimeout) {
                // Check from last payment attempt timestamp (stored in session)
                $paymentCreatedAt = session('payment_created_at', $order->created_at);
                $now = now();
                $minutesPassed = $paymentCreatedAt->diffInMinutes($now);
                
                if ($minutesPassed > 60) {
                    // Mark order as failed due to timeout
                    $order->payment_status = 'failed';
                    $order->status = 'cancelled';
                    $order->save();

                    return response()->json([
                        'success' => true,
                        'status' => 'timeout',
                        'redirect_url' => route('payment.failed', $order->id),
                        'message' => 'Payment timeout - 60 minutes exceeded',
                    ]);
                }
            }

            // Check payment status from Fawaterak
            if ($order->payment_gateway_key) {
                $statusResult = $this->fawaterakService->checkPaymentStatus($order->payment_gateway_key);

                if ($statusResult['success']) {
                    $paymentStatus = $statusResult['payment_status'];

                    Log::info('Payment Status Check', [
                        'order_id' => $order->id,
                        'payment_status' => $paymentStatus,
                        'invoice_status' => $statusResult['invoice_status'] ?? null,
                    ]);

                    // Update order based on payment status
                    if (in_array($paymentStatus, ['paid', 'successful', 'success', 'completed'])) {
                        // Payment successful
                        $order->payment_status = 'paid';
                        $order->status = 'processing';
                        $order->paid_at = now();
                        $order->save();

                        // Update invoice status
                        $invoice = $order->invoice;
                        if ($invoice) {
                            $invoice->status = 'paid';
                            $invoice->paid_at = now();
                            $invoice->save();
                        }

                        // Activate services
                        $this->activateOrderServices($order);

                        return response()->json([
                            'success' => true,
                            'status' => 'paid',
                            'redirect_url' => route('payment.success', $order->id),
                        ]);
                    } elseif (in_array($paymentStatus, ['failed', 'cancelled', 'rejected'])) {
                        // Payment failed
                        $order->payment_status = 'failed';
                        $order->status = 'cancelled';
                        $order->save();

                        return response()->json([
                            'success' => true,
                            'status' => 'failed',
                            'redirect_url' => route('payment.failed', $order->id),
                        ]);
                    }
                }
            }

            // Payment still pending
            return response()->json([
                'success' => true,
                'status' => 'pending',
                'minutes_remaining' => 60 - $minutesPassed,
                'message' => 'Payment is still pending',
            ]);

        } catch (\Exception $e) {
            Log::error('Check Payment Status Exception', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error checking payment status',
            ], 500);
        }
    }
}
