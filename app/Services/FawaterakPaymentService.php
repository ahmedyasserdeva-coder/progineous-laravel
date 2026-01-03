<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FawaterakPaymentService
{
    protected $apiUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->apiUrl = config('payment.fawaterak.api_url');
        $this->apiKey = config('payment.fawaterak.api_key');
    }

    /**
     * Get available payment methods from Fawaterak
     * Step 1: Get Payment Methods
     * 
     * @return array
     */
    public function getPaymentMethods()
    {
        try {
            // Configure SSL certificate verification
            $http = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->apiKey,
            ]);
            
            // Check if we're on local Laragon environment
            $laravelCertPath = base_path('../etc/ssl/cacert.pem');
            if (app()->environment('local') && file_exists($laravelCertPath)) {
                $http = $http->withOptions(['verify' => $laravelCertPath]);
            }
            
            $response = $http->get($this->apiUrl . '/getPaymentmethods');

            if ($response->successful()) {
                $data = $response->json();
                
                if ($data['status'] === 'success') {
                    return [
                        'success' => true,
                        'methods' => $data['data'],
                    ];
                }
            }

            Log::error('Fawaterak Get Payment Methods Failed', [
                'response' => $response->body(),
                'status' => $response->status(),
            ]);

            return [
                'success' => false,
                'message' => 'Failed to fetch payment methods',
            ];

        } catch (\Exception $e) {
            Log::error('Fawaterak Get Payment Methods Exception', [
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Execute payment with Fawaterak
     * Step 2: Initiate Payment
     * 
     * @param array $paymentData
     * @return array
     */
    public function initiatePayment(array $paymentData)
    {
        try {
            // Validate required fields
            $requiredFields = ['payment_method_id', 'cartTotal', 'currency', 'customer', 'cartItems'];
            foreach ($requiredFields as $field) {
                if (!isset($paymentData[$field])) {
                    return [
                        'success' => false,
                        'message' => "Missing required field: {$field}",
                    ];
                }
            }

            // Prepare payment request
            $payload = [
                'payment_method_id' => $paymentData['payment_method_id'],
                'cartTotal' => $paymentData['cartTotal'],
                'currency' => $paymentData['currency'],
                'customer' => [
                    'first_name' => $paymentData['customer']['first_name'],
                    'last_name' => $paymentData['customer']['last_name'],
                    'email' => $paymentData['customer']['email'],
                    'phone' => $paymentData['customer']['phone'] ?? null,
                    'address' => $paymentData['customer']['address'] ?? null,
                ],
                'redirectionUrls' => [
                    'successUrl' => $paymentData['redirectionUrls']['successUrl'] ?? route('payment.success'),
                    'failUrl' => $paymentData['redirectionUrls']['failUrl'] ?? route('payment.fail'),
                    'pendingUrl' => $paymentData['redirectionUrls']['pendingUrl'] ?? route('payment.pending'),
                ],
                'cartItems' => $paymentData['cartItems'],
            ];

            // Optional fields
            if (isset($paymentData['invoice_number'])) {
                $payload['invoice_number'] = $paymentData['invoice_number'];
            }

            if (isset($paymentData['lang'])) {
                $payload['lang'] = $paymentData['lang']; // 'ar' or 'en'
            }

            if (isset($paymentData['sendEmail'])) {
                $payload['sendEmail'] = $paymentData['sendEmail'];
            }

            if (isset($paymentData['sendSMS'])) {
                $payload['sendSMS'] = $paymentData['sendSMS'];
            }

            if (isset($paymentData['payLoad'])) {
                $payload['payLoad'] = $paymentData['payLoad'];
            }

            if (isset($paymentData['taxData'])) {
                $payload['taxData'] = $paymentData['taxData'];
            }

            if (isset($paymentData['discountData'])) {
                $payload['discountData'] = $paymentData['discountData'];
            }

            // Make API request
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->apiKey,
            ])->post($this->apiUrl . '/invoiceInitPay', $payload);

            if ($response->successful()) {
                $data = $response->json();
                
                if ($data['status'] === 'success') {
                    return [
                        'success' => true,
                        'invoice_id' => $data['data']['invoice_id'],
                        'invoice_key' => $data['data']['invoice_key'],
                        'payment_data' => $data['data']['payment_data'],
                    ];
                }
            }

            Log::error('Fawaterak Initiate Payment Failed', [
                'payload' => $payload,
                'response' => $response->body(),
                'status' => $response->status(),
            ]);

            return [
                'success' => false,
                'message' => 'Payment initiation failed',
                'response' => $response->json(),
            ];

        } catch (\Exception $e) {
            Log::error('Fawaterak Initiate Payment Exception', [
                'error' => $e->getMessage(),
                'payload' => $paymentData,
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get transaction data by invoice key
     * 
     * @param string $invoiceKey
     * @return array
     */
    public function getTransactionData($invoiceKey)
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->apiKey,
            ])->get($this->apiUrl . '/getInvoiceData/' . $invoiceKey);

            if ($response->successful()) {
                $data = $response->json();
                
                if ($data['status'] === 'success') {
                    return [
                        'success' => true,
                        'data' => $data['data'],
                    ];
                }
            }

            return [
                'success' => false,
                'message' => 'Failed to fetch transaction data',
            ];

        } catch (\Exception $e) {
            Log::error('Fawaterak Get Transaction Data Exception', [
                'error' => $e->getMessage(),
                'invoice_key' => $invoiceKey,
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Check payment status from Fawaterak
     * 
     * @param string $invoiceKey
     * @return array
     */
    public function checkPaymentStatus($invoiceKey)
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->apiKey,
            ])->get($this->apiUrl . '/getInvoiceData/' . $invoiceKey);

            if ($response->successful()) {
                $data = $response->json();
                
                if ($data['status'] === 'success' && isset($data['data'])) {
                    $invoiceData = $data['data'];
                    
                    return [
                        'success' => true,
                        'payment_status' => $invoiceData['payment_status'] ?? 'pending',
                        'invoice_status' => $invoiceData['invoice_status'] ?? null,
                        'paid_amount' => $invoiceData['paid_amount'] ?? 0,
                        'data' => $invoiceData,
                    ];
                }
            }

            return [
                'success' => false,
                'payment_status' => 'pending',
                'message' => 'Failed to check payment status',
            ];

        } catch (\Exception $e) {
            Log::error('Fawaterak Check Payment Status Exception', [
                'error' => $e->getMessage(),
                'invoice_key' => $invoiceKey,
            ]);

            return [
                'success' => false,
                'payment_status' => 'pending',
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Handle webhook from Fawaterak
     * 
     * @param array $webhookData
     * @return bool
     */
    public function handleWebhook(array $webhookData)
    {
        try {
            Log::info('Fawaterak Webhook Received', $webhookData);

            // Verify webhook signature if needed
            // Fawaterak sends payment status updates via webhook

            return true;

        } catch (\Exception $e) {
            Log::error('Fawaterak Webhook Exception', [
                'error' => $e->getMessage(),
                'data' => $webhookData,
            ]);

            return false;
        }
    }
}
