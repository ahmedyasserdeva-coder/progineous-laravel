<?php

namespace App\Http\Controllers;

use App\Models\WalletTransaction;
use App\Models\Client;
use App\Services\FawaterakPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    protected $fawaterakService;

    public function __construct(FawaterakPaymentService $fawaterakService)
    {
        $this->fawaterakService = $fawaterakService;
    }

    /**
     * Handle Fawaterak Webhook
     */
    public function fawaterak(Request $request)
    {
        try {
            // Log the webhook request
            Log::info('Fawaterak Webhook Received', [
                'payload' => $request->all(),
                'headers' => $request->headers->all(),
            ]);

            // Get webhook data
            $invoiceKey = $request->input('invoice_key');
            $status = $request->input('status'); // paid, pending, failed, etc.
            $referenceId = $request->input('referenceId');
            
            if (!$invoiceKey) {
                Log::warning('Fawaterak Webhook: Missing invoice_key');
                return response()->json(['message' => 'Missing invoice_key'], 400);
            }

            // Find the transaction by invoice key
            $transaction = WalletTransaction::where('fawaterak_invoice_key', $invoiceKey)->first();

            if (!$transaction) {
                Log::warning('Fawaterak Webhook: Transaction not found', [
                    'invoice_key' => $invoiceKey,
                ]);
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            // Skip if transaction is already completed
            if ($transaction->isCompleted()) {
                Log::info('Fawaterak Webhook: Transaction already completed', [
                    'transaction_id' => $transaction->id,
                ]);
                return response()->json(['message' => 'Transaction already processed'], 200);
            }

            // Verify payment status with Fawaterak API
            $paymentInfo = $this->fawaterakService->getTransactionData($invoiceKey);

            if (!$paymentInfo['success']) {
                Log::error('Fawaterak Webhook: Failed to verify payment', [
                    'invoice_key' => $invoiceKey,
                    'response' => $paymentInfo,
                ]);
                return response()->json(['message' => 'Failed to verify payment'], 500);
            }

            $paymentData = $paymentInfo['data'];
            $paymentStatus = $paymentData['paymentStatus'] ?? $status;

            // Process based on payment status
            DB::beginTransaction();
            try {
                if (in_array(strtolower($paymentStatus), ['paid', 'success', 'completed'])) {
                    // Payment successful - add funds to wallet
                    $transaction->update([
                        'status' => 'completed',
                        'completed_at' => now(),
                        'fawaterak_reference_id' => $referenceId ?? $paymentData['referenceId'] ?? null,
                        'metadata' => array_merge($transaction->metadata ?? [], [
                            'webhook_data' => $request->all(),
                            'payment_data' => $paymentData,
                            'processed_at' => now()->toDateTimeString(),
                        ]),
                    ]);

                    // Add funds to client wallet
                    $client = Client::find($transaction->client_id);
                    if ($client) {
                        $client->addFunds(
                            $transaction->amount,
                            "Fawaterak Webhook - Invoice: {$invoiceKey}"
                        );
                    }

                    Log::info('Fawaterak Webhook: Payment processed successfully', [
                        'transaction_id' => $transaction->id,
                        'amount' => $transaction->amount,
                        'client_id' => $transaction->client_id,
                    ]);

                } elseif (in_array(strtolower($paymentStatus), ['failed', 'cancelled', 'expired'])) {
                    // Payment failed
                    $transaction->update([
                        'status' => 'failed',
                        'notes' => "Payment {$paymentStatus}",
                        'metadata' => array_merge($transaction->metadata ?? [], [
                            'webhook_data' => $request->all(),
                            'payment_data' => $paymentData,
                            'failed_at' => now()->toDateTimeString(),
                        ]),
                    ]);

                    Log::info('Fawaterak Webhook: Payment failed', [
                        'transaction_id' => $transaction->id,
                        'status' => $paymentStatus,
                    ]);

                } else {
                    // Payment pending or other status
                    $transaction->update([
                        'metadata' => array_merge($transaction->metadata ?? [], [
                            'webhook_data' => $request->all(),
                            'payment_data' => $paymentData,
                            'updated_at' => now()->toDateTimeString(),
                        ]),
                    ]);

                    Log::info('Fawaterak Webhook: Payment status updated', [
                        'transaction_id' => $transaction->id,
                        'status' => $paymentStatus,
                    ]);
                }

                DB::commit();

                return response()->json([
                    'message' => 'Webhook processed successfully',
                    'transaction_id' => $transaction->id,
                    'status' => $transaction->status,
                ], 200);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('Fawaterak Webhook Error: ' . $e->getMessage(), [
                'payload' => $request->all(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'message' => 'Webhook processing failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
