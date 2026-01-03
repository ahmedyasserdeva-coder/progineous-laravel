<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\WalletTransaction;
use App\Services\FawaterakPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class WalletController extends Controller
{
    protected $fawaterakService;

    public function __construct(FawaterakPaymentService $fawaterakService)
    {
        $this->fawaterakService = $fawaterakService;
    }

    /**
     * Show add funds page
     */
    public function addFunds()
    {
        $client = Auth::guard('client')->user();
        
        // Predefined amounts
        $predefinedAmounts = [
            50, 100, 200, 500, 1000, 2000
        ];
        
        // Get Fawaterak payment methods from API
        $fawaterakPaymentMethods = [];
        $paymentMethodsResponse = $this->fawaterakService->getPaymentMethods();
        
        if ($paymentMethodsResponse['success'] && isset($paymentMethodsResponse['methods'])) {
            $fawaterakPaymentMethods = $paymentMethodsResponse['methods'];
            Log::info('Fawaterak Payment Methods Retrieved', ['count' => count($fawaterakPaymentMethods)]);
        } else {
            Log::warning('Failed to get Fawaterak payment methods', ['response' => $paymentMethodsResponse]);
        }
        
        // Additional payment methods (Bank Transfer, etc.)
        $additionalPaymentMethods = [];
        
        return view('frontend.client.wallet.add-funds', compact('client', 'predefinedAmounts', 'fawaterakPaymentMethods', 'additionalPaymentMethods'));
    }
    
    /**
     * Process add funds request
     */
    public function storeFunds(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10|max:100000',
            'payment_method' => 'required|string',
        ], [
            'amount.required' => app()->getLocale() == 'ar' ? 'المبلغ مطلوب' : 'Amount is required',
            'amount.numeric' => app()->getLocale() == 'ar' ? 'المبلغ يجب أن يكون رقماً' : 'Amount must be a number',
            'amount.min' => app()->getLocale() == 'ar' ? 'الحد الأدنى للمبلغ هو :min' : 'Minimum amount is :min',
            'amount.max' => app()->getLocale() == 'ar' ? 'الحد الأقصى للمبلغ هو :max' : 'Maximum amount is :max',
            'payment_method.required' => app()->getLocale() == 'ar' ? 'طريقة الدفع مطلوبة' : 'Payment method is required',
        ]);
        
        $client = Auth::guard('client')->user();
        $amount = $request->amount;
        $paymentMethod = $request->payment_method;
        
        // Check if it's a Fawaterak payment method
        if (str_starts_with($paymentMethod, 'fawaterak_')) {
            // Extract the payment ID from the value (e.g., "fawaterak_123" -> "123")
            $fawaterakPaymentId = str_replace('fawaterak_', '', $paymentMethod);
            
            try {
                // Create payment invoice via Fawaterak API
                // Prepare customer data with proper validation
                $firstName = $client->first_name ?? $client->username ?? 'Customer';
                $lastName = $client->last_name ?? '';
                
                // Clean phone number - Fawaterak requires Egyptian format: 01xxxxxxxxx
                $phone = $client->phone ?? '';
                if (!empty($phone)) {
                    // Remove any non-digit characters
                    $phone = preg_replace('/[^0-9]/', '', $phone);
                    
                    // Convert to Egyptian format (01xxxxxxxxx)
                    // If phone starts with country code (2), remove it
                    if (str_starts_with($phone, '2') && strlen($phone) == 12) {
                        $phone = '0' . substr($phone, 2);
                    }
                    // If phone starts with 00, remove the leading zeros
                    elseif (str_starts_with($phone, '00')) {
                        $phone = substr($phone, 2);
                        if (str_starts_with($phone, '2')) {
                            $phone = '0' . substr($phone, 2);
                        }
                    }
                    
                    // Validate final format (must start with 01 and be 11 digits)
                    if (!str_starts_with($phone, '01') || strlen($phone) != 11) {
                        Log::warning('Invalid phone format after cleaning', [
                            'original' => $client->phone,
                            'cleaned' => $phone,
                            'client_id' => $client->id,
                        ]);
                        
                        return redirect()->back()
                            ->withInput()
                            ->with('error', app()->getLocale() == 'ar' 
                                ? 'رقم الهاتف غير صالح. يرجى تحديث رقم الهاتف في حسابك ليكون بصيغة مصرية: 01xxxxxxxxx'
                                : 'Invalid phone number. Please update your phone number to Egyptian format: 01xxxxxxxxx');
                    }
                }
                
                $paymentData = [
                    'payment_method_id' => $fawaterakPaymentId,
                    'cartTotal' => $amount,
                    'currency' => 'USD',
                    'customer' => [
                        'first_name' => $firstName,
                        'last_name' => $lastName,
                        'email' => $client->email,
                        'phone' => $phone, // Required for mobile wallet payments
                        'address' => $client->address1 ?? '',
                    ],
                    'redirectionUrls' => [
                        'successUrl' => route('client.wallet.payment.success'),
                        'failUrl' => route('client.wallet.payment.failed'),
                        'pendingUrl' => route('client.wallet.payment.pending'),
                        'webhookUrl' => route('webhooks.fawaterak'), // Custom webhook URL
                    ],
                    'cartItems' => [
                        [
                            'name' => app()->getLocale() == 'ar' ? 'إضافة رصيد' : 'Add Funds',
                            'price' => $amount,
                            'quantity' => 1,
                        ]
                    ],
                    'lang' => app()->getLocale(), // ar or en
                    'sendEmail' => true, // Send invoice email to customer
                ];
                
                $response = $this->fawaterakService->initiatePayment($paymentData);
                
                if ($response['success'] && isset($response['payment_data'])) {
                    // Create transaction record in database
                    $transaction = WalletTransaction::create([
                        'client_id' => $client->id,
                        'amount' => $amount,
                        'type' => 'deposit',
                        'status' => 'pending',
                        'payment_method' => $paymentMethod,
                        'payment_provider' => 'fawaterak',
                        'fawaterak_invoice_id' => $response['invoice_id'] ?? null,
                        'fawaterak_invoice_key' => $response['invoice_key'] ?? null,
                        'transaction_reference' => WalletTransaction::generateReference(),
                        'metadata' => [
                            'payment_method_id' => $fawaterakPaymentId,
                            'currency' => 'USD',
                        ],
                    ]);
                    
                    // Store transaction in session before redirecting
                    session([
                        'pending_transaction' => [
                            'transaction_id' => $transaction->id,
                            'amount' => $amount,
                            'payment_method' => $paymentMethod,
                            'fawaterak_invoice_id' => $response['invoice_id'] ?? null,
                            'fawaterak_invoice_key' => $response['invoice_key'] ?? null,
                            'payment_data' => $response['payment_data'] ?? null,
                            'created_at' => now(),
                        ]
                    ]);
                    
                    $paymentData = $response['payment_data'];
                    
                    // Log payment data for debugging
                    Log::info('Payment Data Received', [
                        'payment_method_id' => $fawaterakPaymentId,
                        'payment_data' => $paymentData,
                        'full_response' => $response,
                    ]);
                    
                    // Check if there's an error in payment_data
                    if (isset($paymentData['error'])) {
                        $errorMessage = $paymentData['error'];
                        
                        Log::error('Fawaterak payment_data contains error', [
                            'error' => $errorMessage,
                            'payment_method_id' => $fawaterakPaymentId,
                        ]);
                        
                        // Translate common errors
                        if (str_contains(strtolower($errorMessage), 'phone')) {
                            $userMessage = app()->getLocale() == 'ar' 
                                ? 'رقم الهاتف غير صالح. يرجى تحديث رقم الهاتف في حسابك ليكون بصيغة مصرية: 01xxxxxxxxx'
                                : 'Invalid phone number. Please update your phone number to Egyptian format: 01xxxxxxxxx';
                        } else {
                            $userMessage = app()->getLocale() == 'ar' 
                                ? "خطأ: {$errorMessage}"
                                : "Error: {$errorMessage}";
                        }
                        
                        return redirect()->back()
                            ->withInput()
                            ->with('error', $userMessage);
                    }
                    
                    // Handle different payment method responses
                    if (isset($paymentData['redirectTo'])) {
                        // Visa/Mastercard - Redirect to payment page
                        Log::info('Redirecting to Visa/Mastercard payment page');
                        return redirect($paymentData['redirectTo']);
                        
                    } elseif (isset($paymentData['fawryCode'])) {
                        // Fawry - Show code to user
                        Log::info('Showing Fawry payment code', ['code' => $paymentData['fawryCode']]);
                        return redirect()->route('client.wallet.payment.pending')
                            ->with('payment_info', [
                                'type' => 'fawry',
                                'code' => $paymentData['fawryCode'],
                                'expire_date' => $paymentData['expireDate'] ?? null,
                            ]);
                        
                    } elseif (isset($paymentData['amanCode'])) {
                        // Aman - Show code to user
                        Log::info('Showing Aman payment code', ['code' => $paymentData['amanCode']]);
                        return redirect()->route('client.wallet.payment.pending')
                            ->with('payment_info', [
                                'type' => 'aman',
                                'code' => $paymentData['amanCode'],
                            ]);
                        
                    } elseif (isset($paymentData['meezaReference']) || isset($paymentData['mobileWalletNumber'])) {
                        // Meeza/Mobile Wallet - Show reference and QR code
                        // Note: Some responses may have different field names
                        $reference = $paymentData['meezaReference'] ?? $paymentData['reference'] ?? null;
                        $qrCode = $paymentData['meezaQrCode'] ?? $paymentData['qrCode'] ?? null;
                        
                        Log::info('Showing Mobile Wallet payment info', [
                            'reference' => $reference,
                            'has_qr_code' => !empty($qrCode),
                        ]);
                        
                        return redirect()->route('client.wallet.payment.pending')
                            ->with('payment_info', [
                                'type' => 'meeza',
                                'reference' => $reference,
                                'qr_code' => $qrCode,
                            ]);
                        
                    } elseif (isset($paymentData['masaryCode']) || isset($paymentData['bastaCode'])) {
                        // Basta/Masary - Show code to user
                        $code = $paymentData['masaryCode'] ?? $paymentData['bastaCode'] ?? null;
                        
                        Log::info('Showing Basta/Masary payment code', ['code' => $code]);
                        
                        return redirect()->route('client.wallet.payment.pending')
                            ->with('payment_info', [
                                'type' => 'basta',
                                'code' => $code,
                            ]);
                        
                    } else {
                        // Unknown payment method response - Log details for debugging
                        Log::warning('Unknown payment method response structure', [
                            'payment_data' => $paymentData,
                            'payment_data_keys' => array_keys($paymentData),
                            'full_response' => $response,
                        ]);
                        
                        // Check if it's a redirect-based method that we haven't handled
                        if (!empty($paymentData) && is_array($paymentData)) {
                            // Try to find any URL-like value
                            foreach ($paymentData as $key => $value) {
                                if (is_string($value) && (str_starts_with($value, 'http://') || str_starts_with($value, 'https://'))) {
                                    Log::info('Found redirect URL in payment data', ['key' => $key, 'url' => $value]);
                                    return redirect($value);
                                }
                            }
                        }
                        
                        return redirect()->back()
                            ->withInput()
                            ->with('error', app()->getLocale() == 'ar' 
                                ? 'استجابة غير متوقعة من بوابة الدفع. يرجى المحاولة مرة أخرى أو التواصل مع الدعم الفني.' 
                                : 'Unexpected payment gateway response. Please try again or contact support.');
                    }
                } else {
                    $errorMessage = $response['message'] ?? (app()->getLocale() == 'ar' 
                        ? 'حدث خطأ أثناء إنشاء فاتورة الدفع' 
                        : 'Error creating payment invoice');
                    
                    return redirect()->back()
                        ->withInput()
                        ->with('error', $errorMessage);
                }
                
            } catch (\Exception $e) {
                Log::error('Fawaterak payment error: ' . $e->getMessage());
                
                return redirect()->back()
                    ->withInput()
                    ->with('error', app()->getLocale() == 'ar' 
                        ? 'حدث خطأ أثناء معالجة الدفع. يرجى المحاولة مرة أخرى.' 
                        : 'Error processing payment. Please try again.');
            }
        }
        
        // Handle other payment methods (Bank Transfer, etc.)
        if ($paymentMethod === 'bank_transfer') {
            // TODO: Show bank transfer instructions
            return redirect()->back()->with('info', app()->getLocale() == 'ar' 
                ? 'سيتم عرض تفاصيل التحويل البنكي قريباً'
                : 'Bank transfer details will be available soon');
        }
        
        // Unsupported payment method
        return redirect()->back()
            ->withInput()
            ->with('error', app()->getLocale() == 'ar' 
                ? 'طريقة الدفع غير مدعومة' 
                : 'Payment method not supported');
    }
    
    /**
     * Payment Success Callback
     */
    public function paymentSuccess(Request $request)
    {
        $client = Auth::guard('client')->user();
        $pendingTransaction = session('pending_transaction');
        
        if (!$pendingTransaction) {
            return redirect()->route('client.wallet')
                ->with('error', app()->getLocale() == 'ar' 
                    ? 'لم يتم العثور على معلومات المعاملة' 
                    : 'Transaction information not found');
        }
        
        // Get invoice key from Fawaterak callback
        $invoiceKey = $request->query('invoice_key');
        
        if ($invoiceKey && isset($pendingTransaction['fawaterak_invoice_key'])) {
            // Verify payment with Fawaterak API
            $paymentInfo = $this->fawaterakService->getTransactionData($invoiceKey);
            
            if ($paymentInfo['success']) {
                $transactionData = $paymentInfo['data'];
                
                // Use database transaction to ensure data consistency
                DB::beginTransaction();
                try {
                    // Find the transaction record
                    $transaction = WalletTransaction::find($pendingTransaction['transaction_id']);
                    
                    if ($transaction && $transaction->isPending()) {
                        // Update transaction status
                        $transaction->update([
                            'status' => 'completed',
                            'completed_at' => now(),
                            'fawaterak_reference_id' => $transactionData['referenceId'] ?? null,
                            'metadata' => array_merge($transaction->metadata ?? [], [
                                'fawaterak_response' => $transactionData,
                                'completed_at' => now()->toDateTimeString(),
                            ]),
                        ]);
                        
                        // Add funds to client wallet
                        $client->addFunds(
                            $transaction->amount, 
                            "Fawaterak Payment - Invoice: {$invoiceKey}"
                        );
                        
                        // Create success notification
                        \App\Models\Notification::createDepositNotification(
                            $client->id,
                            'success',
                            $transaction->amount,
                            $transaction->reference,
                            $transaction->payment_method
                        );
                        
                        DB::commit();
                        
                        // Clear pending transaction
                        session()->forget('pending_transaction');
                        
                        $successMessage = app()->getLocale() == 'ar' 
                            ? 'تمت عملية الدفع بنجاح! تم إضافة $' . number_format($transaction->amount, 2) . ' إلى محفظتك.'
                            : 'Payment successful! $' . number_format($transaction->amount, 2) . ' has been added to your wallet.';
                        
                        return redirect()->route('client.wallet')
                            ->with('success', $successMessage);
                    }
                    
                    DB::commit();
                    
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('Payment success processing error: ' . $e->getMessage(), [
                        'client_id' => $client->id,
                        'invoice_key' => $invoiceKey,
                    ]);
                    
                    return redirect()->route('client.wallet')
                        ->with('error', app()->getLocale() == 'ar' 
                            ? 'حدث خطأ أثناء معالجة الدفع' 
                            : 'Error processing payment');
                }
            }
        }
        
        return redirect()->route('client.wallet')
            ->with('info', app()->getLocale() == 'ar' 
                ? 'جارٍ معالجة الدفع. سيتم تحديث رصيدك قريباً.' 
                : 'Payment is being processed. Your balance will be updated soon.');
    }
    
    /**
     * Payment Failed Callback
     */
    public function paymentFailed(Request $request)
    {
        $client = Auth::guard('client')->user();
        $pendingTransaction = session('pending_transaction');
        
        // Mark transaction as failed if exists
        if ($pendingTransaction && isset($pendingTransaction['transaction_id'])) {
            $transaction = WalletTransaction::find($pendingTransaction['transaction_id']);
            
            if ($transaction && $transaction->isPending()) {
                $transaction->update([
                    'status' => 'failed',
                    'notes' => app()->getLocale() == 'ar' 
                        ? 'فشلت عملية الدفع' 
                        : 'Payment failed',
                ]);
                
                // Create failed notification
                \App\Models\Notification::createDepositNotification(
                    $client->id,
                    'failed',
                    $transaction->amount,
                    $transaction->reference,
                    $transaction->payment_method
                );
            }
        }
        
        // Clear pending transaction
        session()->forget('pending_transaction');
        
        return redirect()->route('client.wallet.add-funds')
            ->with('error', app()->getLocale() == 'ar' 
                ? 'فشلت عملية الدفع. يرجى المحاولة مرة أخرى.' 
                : 'Payment failed. Please try again.');
    }
    
    /**
     * Payment Pending Callback
     * Shows payment instructions for cash/code-based payment methods
     */
    public function paymentPending(Request $request)
    {
        $client = Auth::guard('client')->user();
        $pendingTransaction = session('pending_transaction');
        
        // Create pending notification if transaction exists
        if ($pendingTransaction && isset($pendingTransaction['transaction_id'])) {
            $transaction = WalletTransaction::find($pendingTransaction['transaction_id']);
            
            if ($transaction && $transaction->isPending()) {
                // Create pending notification
                \App\Models\Notification::createDepositNotification(
                    $client->id,
                    'pending',
                    $transaction->amount,
                    $transaction->transaction_reference,
                    $transaction->payment_method
                );
            }
        }
        
        // Check if there's payment_info in session (from Fawry, Aman, etc.)
        if (session()->has('payment_info')) {
            return view('frontend.client.wallet.payment-pending', compact('client'));
        }
        
        // Otherwise redirect to wallet with info message
        return redirect()->route('client.wallet')
            ->with('info', app()->getLocale() == 'ar' 
                ? 'الدفع قيد المراجعة. سيتم تحديث رصيدك بعد التأكيد.' 
                : 'Payment is pending review. Your balance will be updated after confirmation.');
    }

    /**
     * Payment Cancelled Callback
     */
    public function paymentCancelled(Request $request)
    {
        $client = Auth::guard('client')->user();
        $pendingTransaction = session('pending_transaction');
        
        // Mark transaction as cancelled if exists
        if ($pendingTransaction && isset($pendingTransaction['transaction_id'])) {
            $transaction = WalletTransaction::find($pendingTransaction['transaction_id']);
            
            if ($transaction && $transaction->isPending()) {
                $transaction->update([
                    'status' => 'cancelled',
                    'notes' => app()->getLocale() == 'ar' 
                        ? 'تم إلغاء عملية الدفع' 
                        : 'Payment cancelled',
                ]);
                
                // Create cancelled notification
                \App\Models\Notification::createDepositNotification(
                    $client->id,
                    'cancelled',
                    $transaction->amount,
                    $transaction->reference,
                    $transaction->payment_method
                );
            }
        }
        
        // Clear pending transaction
        session()->forget('pending_transaction');
        
        return redirect()->route('client.wallet.add-funds')
            ->with('info', app()->getLocale() == 'ar' 
                ? 'تم إلغاء عملية الدفع.' 
                : 'Payment has been cancelled.');
    }
    
    /**
     * Show wallet page
     */
    public function index(Request $request)
    {
        $client = Auth::guard('client')->user();
        
        // Get wallet transactions from database
        $transactions = WalletTransaction::where('client_id', $client->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        $balance = $client->wallet_balance;
        
        // Get statistics
        $stats = [
            'total_deposits' => WalletTransaction::where('client_id', $client->id)
                ->where('type', 'deposit')
                ->where('status', 'completed')
                ->sum('amount'),
            'total_withdrawals' => WalletTransaction::where('client_id', $client->id)
                ->where('type', 'withdrawal')
                ->where('status', 'completed')
                ->sum('amount'),
            'pending_transactions' => WalletTransaction::where('client_id', $client->id)
                ->where('status', 'pending')
                ->count(),
        ];
        
        // If AJAX request, return JSON with partial HTML
        if ($request->ajax() || $request->wantsJson()) {
            $rtl = app()->getLocale() == 'ar';
            
            // Mobile view HTML
            $mobileHtml = view('frontend.client.wallet.partials.transactions-mobile', compact('transactions', 'rtl'))->render();
            
            // Desktop view HTML
            $desktopHtml = view('frontend.client.wallet.partials.transactions-desktop', compact('transactions', 'rtl'))->render();
            
            // Pagination HTML
            $paginationHtml = $transactions->links()->render();
            
            return response()->json([
                'success' => true,
                'mobileHtml' => $mobileHtml,
                'desktopHtml' => $desktopHtml,
                'paginationHtml' => $paginationHtml
            ]);
        }
        
        return view('frontend.client.wallet.index', compact('client', 'transactions', 'balance', 'stats'));
    }

    /**
     * Send OTP to client email for card verification
     */
    public function sendCardOtp(Request $request)
    {
        $client = Auth::guard('client')->user();
        
        try {
            // Create OTP
            $otp = \App\Models\CardVerificationOtp::createForClient(
                $client->id,
                $request->ip()
            );
            
            // Send email with OTP
            Mail::raw(
                app()->getLocale() == 'ar' 
                    ? "رمز التحقق لإظهار رقم بطاقة المحفظة: {$otp->otp_code}\n\nصالح لمدة 5 دقائق فقط."
                    : "Your wallet card verification code: {$otp->otp_code}\n\nValid for 5 minutes only.",
                function ($message) use ($client) {
                    $message->to($client->email)
                            ->subject(app()->getLocale() == 'ar' ? 'رمز التحقق - رقم البطاقة' : 'Verification Code - Card Number');
                }
            );
            
            return response()->json([
                'success' => true,
                'message' => app()->getLocale() == 'ar' 
                    ? 'تم إرسال الكود إلى بريدك الإلكتروني'
                    : 'Code sent to your email'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to send card OTP', [
                'client_id' => $client->id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar' 
                    ? 'فشل إرسال الكود. حاول مرة أخرى.'
                    : 'Failed to send code. Try again.'
            ], 500);
        }
    }

    /**
     * Verify OTP and return card number
     */
    public function verifyCardOtp(Request $request)
    {
        $client = Auth::guard('client')->user();
        $otpCode = $request->input('otp_code');
        
        // Find valid OTP
        $otp = \App\Models\CardVerificationOtp::where('client_id', $client->id)
            ->where('otp_code', $otpCode)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->first();
        
        if (!$otp) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar' 
                    ? 'الكود غير صحيح أو منتهي الصلاحية'
                    : 'Invalid or expired code'
            ], 400);
        }
        
        // Mark as used
        $otp->markAsUsed();
        
        // Return card number
        return response()->json([
            'success' => true,
            'card_number' => $client->getWalletCardNumber(),
            'message' => app()->getLocale() == 'ar' 
                ? 'تم التحقق بنجاح'
                : 'Verified successfully'
        ]);
    }

    /**
     * Show transfer form
     */
    public function showTransferForm()
    {
        $client = Auth::guard('client')->user();
        return view('frontend.client.wallet.transfer', compact('client'));
    }

    /**
     * Verify receiver by card number
     */
    public function verifyReceiver(Request $request)
    {
        $request->validate([
            'card_number' => 'required|string|size:19'
        ]);

        $client = Auth::guard('client')->user();
        $cardNumber = trim($request->input('card_number'));

        // Validate card number format (XXXX XXXX XXXX XXXX)
        if (!preg_match('/^\d{4} \d{4} \d{4} \d{4}$/', $cardNumber)) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar' 
                    ? 'صيغة رقم البطاقة غير صحيحة'
                    : 'Invalid card number format'
            ], 400);
        }

        // Find receiver by card number
        $receiver = \App\Models\Client::where('wallet_card_number', $cardNumber)->first();

        if (!$receiver) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar' 
                    ? 'رقم البطاقة غير صحيح'
                    : 'Invalid card number'
            ], 404);
        }

        // Check if trying to transfer to self
        if ($receiver->id === $client->id) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar' 
                    ? 'لا يمكنك التحويل إلى نفس المحفظة'
                    : 'Cannot transfer to your own wallet'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'receiver' => [
                'id' => $receiver->id,
                'name' => $receiver->username,
                'email' => $receiver->email
            ]
        ]);
    }

    /**
     * Send OTP for transfer verification
     */
    public function sendTransferOtp(Request $request)
    {
        $client = Auth::guard('client')->user();
        
        try {
            // Create OTP
            $otp = \App\Models\TransferVerificationOtp::createForClient(
                $client->id,
                $request->ip()
            );
            
            // Send email with OTP
            Mail::raw(
                app()->getLocale() == 'ar' 
                    ? "رمز التحقق لإتمام عملية التحويل: {$otp->otp_code}\n\nصالح لمدة 5 دقائق فقط.\n\nإذا لم تقم بطلب هذا الرمز، يرجى تجاهل هذه الرسالة."
                    : "Your transfer verification code: {$otp->otp_code}\n\nValid for 5 minutes only.\n\nIf you didn't request this code, please ignore this message.",
                function ($message) use ($client) {
                    $message->to($client->email)
                            ->subject(app()->getLocale() == 'ar' ? 'رمز التحقق - تحويل الأموال' : 'Verification Code - Transfer Funds');
                }
            );
            
            return response()->json([
                'success' => true,
                'message' => app()->getLocale() == 'ar' 
                    ? 'تم إرسال رمز التحقق إلى بريدك الإلكتروني'
                    : 'Verification code sent to your email'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to send transfer OTP', [
                'client_id' => $client->id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar' 
                    ? 'فشل إرسال رمز التحقق. حاول مرة أخرى.'
                    : 'Failed to send verification code. Try again.'
            ], 500);
        }
    }

    /**
     * Process wallet transfer
     */
    public function processTransfer(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:clients,id',
            'amount' => 'required|numeric|min:1',
            'receiver_card_number' => 'required|string|size:19',
            'otp_code' => 'required|string|size:6',
            'notes' => 'nullable|string|max:500'
        ]);

        $sender = Auth::guard('client')->user();
        $receiverId = $request->input('receiver_id');
        $amount = $request->input('amount');
        $receiverCardNumber = $request->input('receiver_card_number');
        $otpCode = $request->input('otp_code');
        $notes = $request->input('notes');

        // Verify OTP
        $otp = \App\Models\TransferVerificationOtp::where('client_id', $sender->id)
            ->where('otp_code', $otpCode)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otp) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar' 
                    ? 'رمز التحقق غير صحيح أو منتهي الصلاحية'
                    : 'Invalid or expired verification code'
            ], 400);
        }

        // Validate receiver
        $receiver = \App\Models\Client::find($receiverId);
        
        if (!$receiver) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar' 
                    ? 'المستلم غير موجود'
                    : 'Receiver not found'
            ], 404);
        }

        // Check if receiver card number matches
        if ($receiver->wallet_card_number !== $receiverCardNumber) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar' 
                    ? 'رقم البطاقة غير صحيح'
                    : 'Invalid card number'
            ], 400);
        }

        // Check self-transfer
        if ($sender->id === $receiver->id) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar' 
                    ? 'لا يمكنك التحويل إلى نفس المحفظة'
                    : 'Cannot transfer to your own wallet'
            ], 400);
        }

        // Calculate fee (1%)
        $fee = round($amount * 0.01, 2);
        $totalAmount = $amount + $fee;

        // Check sufficient balance (amount + fee)
        if ($sender->wallet_balance < $totalAmount) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar' 
                    ? 'رصيدك غير كافٍ (المبلغ + رسوم التحويل 1%)'
                    : 'Insufficient balance (amount + 1% transfer fee)'
            ], 400);
        }

        try {
            DB::beginTransaction();

            // Generate unique reference for transfer record
            $transferReference = \App\Models\WalletTransfer::generateReference();
            
            // Generate unique references for each transaction
            $senderTxnRef = WalletTransaction::generateReference();
            $receiverTxnRef = WalletTransaction::generateReference();
            $feeTxnRef = WalletTransaction::generateReference();

            // Deduct total amount from sender (amount + fee)
            $sender->decrement('wallet_balance', $totalAmount);
            
            // Create withdrawal transaction for sender
            WalletTransaction::create([
                'client_id' => $sender->id,
                'amount' => $amount,
                'type' => 'withdrawal',
                'status' => 'completed',
                'transaction_reference' => $senderTxnRef,
                'payment_method' => 'wallet_transfer',
                'metadata' => [
                    'transfer_type' => 'sent',
                    'transfer_reference' => $transferReference,
                    'receiver_id' => $receiver->id,
                    'receiver_name' => $receiver->full_name,
                    'receiver_card' => $receiverCardNumber,
                    'transfer_fee' => $fee,
                    'total_deducted' => $totalAmount,
                    'notes' => $notes
                ]
            ]);

            // Create fee transaction
            WalletTransaction::create([
                'client_id' => $sender->id,
                'amount' => $fee,
                'type' => 'withdrawal',
                'status' => 'completed',
                'transaction_reference' => $feeTxnRef,
                'payment_method' => 'transfer_fee',
                'metadata' => [
                    'transfer_reference' => $transferReference,
                    'fee_percentage' => 1,
                    'transfer_amount' => $amount
                ]
            ]);

            // Add to receiver
            $receiver->increment('wallet_balance', $amount);
            
            // Create deposit transaction for receiver
            WalletTransaction::create([
                'client_id' => $receiver->id,
                'amount' => $amount,
                'type' => 'deposit',
                'status' => 'completed',
                'transaction_reference' => $receiverTxnRef,
                'payment_method' => 'wallet_transfer',
                'metadata' => [
                    'transfer_type' => 'received',
                    'transfer_reference' => $transferReference,
                    'sender_id' => $sender->id,
                    'sender_name' => $sender->full_name,
                    'sender_card' => $sender->wallet_card_number,
                    'notes' => $notes
                ]
            ]);

            // Create transfer record
            \App\Models\WalletTransfer::create([
                'sender_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'amount' => $amount,
                'receiver_card_number' => $receiverCardNumber,
                'reference' => $transferReference,
                'status' => 'completed',
                'notes' => $notes,
                'completed_at' => now(),
                'metadata' => [
                    'sender_transaction_ref' => $senderTxnRef,
                    'receiver_transaction_ref' => $receiverTxnRef,
                    'fee_transaction_ref' => $feeTxnRef,
                    'transfer_fee' => $fee,
                    'total_deducted' => $totalAmount,
                    'sender_balance_before' => $sender->wallet_balance + $totalAmount,
                    'sender_balance_after' => $sender->wallet_balance,
                    'receiver_balance_before' => $receiver->wallet_balance - $amount,
                    'receiver_balance_after' => $receiver->wallet_balance
                ]
            ]);

            // Mark OTP as used
            $otp->markAsUsed();

            // Create notifications for sender and receiver
            \App\Models\Notification::createTransferNotification(
                $sender->id,
                'transfer_sent',
                $amount,
                $receiver->username,
                $transferReference
            );

            \App\Models\Notification::createTransferNotification(
                $receiver->id,
                'transfer_received',
                $amount,
                $sender->username,
                $transferReference
            );

            DB::commit();

            Log::info('Wallet transfer completed', [
                'transfer_reference' => $transferReference,
                'sender_txn_ref' => $senderTxnRef,
                'receiver_txn_ref' => $receiverTxnRef,
                'fee_txn_ref' => $feeTxnRef,
                'sender_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'amount' => $amount,
                'fee' => $fee,
                'total_deducted' => $totalAmount
            ]);

            return response()->json([
                'success' => true,
                'message' => app()->getLocale() == 'ar' 
                    ? 'تم التحويل بنجاح'
                    : 'Transfer completed successfully',
                'reference' => $transferReference
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Wallet transfer failed', [
                'sender_id' => $sender->id,
                'receiver_id' => $receiverId,
                'amount' => $amount,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar' 
                    ? 'فشل التحويل. حاول مرة أخرى.'
                    : 'Transfer failed. Try again.'
            ], 500);
        }
    }
}
