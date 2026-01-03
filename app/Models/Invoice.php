<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use App\Services\HetznerService;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'client_id',
        'invoice_number',
        'invoice_date',
        'due_date',
        'subtotal',
        'tax',
        'discount',
        'total',
        'paid_amount',
        'balance',
        'currency',
        'status',
        'notes',
        'paid_at',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'balance' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::updated(function ($invoice) {
            // Check if invoice status changed to 'paid'
            if ($invoice->isDirty('status') && $invoice->status === 'paid') {
                // Check if this is a backup activation invoice
                if (str_contains($invoice->notes ?? '', 'Backup Service Activation Fee')) {
                    // Extract service ID from notes
                    preg_match('/VPS Service #(\d+)/', $invoice->notes, $matches);
                    if (isset($matches[1])) {
                        $serviceId = $matches[1];
                        
                        try {
                            $service = Service::find($serviceId);
                            if ($service && $service->type === 'vps') {
                                $serverId = $service->server_data['hetzner_server_id'] ?? null;
                                
                                if ($serverId) {
                                    // Enable backups on Hetzner
                                    $hetznerService = app(HetznerService::class);
                                    $result = $hetznerService->enableBackups($serverId);
                                    
                                    // Create wallet transaction record with reference
                                    WalletTransaction::create([
                                        'client_id' => $invoice->client_id,
                                        'amount' => $invoice->total,
                                        'type' => 'deduction',
                                        'status' => 'completed',
                                        'transaction_reference' => WalletTransaction::generateReference(),
                                        'payment_method' => 'backup_activation',
                                        'description' => 'Backup Service Activation Fee for VPS Service #' . $service->id,
                                        'completed_at' => now(),
                                        'metadata' => json_encode([
                                            'service_id' => $service->id,
                                            'service_name' => $service->service_name,
                                            'invoice_id' => $invoice->id,
                                            'invoice_number' => $invoice->invoice_number,
                                            'hetzner_server_id' => $serverId,
                                        ]),
                                    ]);
                                    
                                    // Update service notes
                                    $service->notes = ($service->notes ? $service->notes . "\n\n" : '') . 
                                        '[' . now() . '] Backups activated automatically after invoice ' . $invoice->invoice_number . ' payment';
                                    $service->save();
                                    
                                    Log::info('Backups enabled automatically', [
                                        'service_id' => $serviceId,
                                        'invoice_number' => $invoice->invoice_number,
                                        'hetzner_server_id' => $serverId
                                    ]);
                                }
                            }
                        } catch (\Exception $e) {
                            Log::error('Failed to auto-enable backups', [
                                'service_id' => $serviceId ?? null,
                                'invoice_number' => $invoice->invoice_number,
                                'error' => $e->getMessage()
                            ]);
                        }
                    }
                }
            }
        });
    }

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'invoice_number', 'invoice_number');
    }

    public function walletTransactions()
    {
        return $this->hasMany(WalletTransaction::class, 'client_id', 'client_id')
            ->where('type', 'withdrawal')
            ->where('amount', $this->total)
            ->whereDate('created_at', $this->paid_at);
    }

    // Get all transactions (both payments and wallet)
    public function getAllTransactions()
    {
        $transactions = collect();
        
        // Add payment transactions
        foreach ($this->payments as $payment) {
            $transactions->push([
                'date' => $payment->paid_at ?? $payment->created_at,
                'gateway' => ucfirst($payment->gateway),
                'transaction_id' => $payment->transaction_id ?? 'N/A',
                'amount' => $payment->amount,
                'currency' => $payment->currency ?? $this->currency,
                'type' => 'payment'
            ]);
        }
        
        // Add wallet transaction if paid via wallet
        if ($this->paid_at) {
            $walletTx = WalletTransaction::where('client_id', $this->client_id)
                ->where('type', 'withdrawal')
                ->where('amount', $this->total)
                ->whereDate('created_at', $this->paid_at->format('Y-m-d'))
                ->first();
                
            if ($walletTx) {
                $transactions->push([
                    'date' => $walletTx->completed_at ?? $walletTx->created_at,
                    'gateway' => 'Wallet',
                    'transaction_id' => $walletTx->transaction_reference ?? 'WT-' . $walletTx->id,
                    'amount' => $walletTx->amount,
                    'currency' => $this->currency,
                    'type' => 'wallet'
                ]);
            }
        }
        
        return $transactions->sortByDesc('date');
    }

    // Helper Methods
    public function generateInvoiceNumber()
    {
        return 'INV-' . date('Ymd') . '-' . str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }

    public function calculateBalance()
    {
        $this->balance = $this->total - $this->paid_amount;
        return $this->balance;
    }

    public function markAsPaid()
    {
        $this->status = 'paid';
        $this->paid_amount = $this->total;
        $this->balance = 0;
        $this->paid_at = now();
        $this->save();
    }

    public function addPayment($amount)
    {
        $this->paid_amount += $amount;
        $this->balance = $this->total - $this->paid_amount;
        
        if ($this->balance <= 0) {
            $this->status = 'paid';
            $this->paid_at = now();
        } else {
            $this->status = 'partially_paid';
        }
        
        $this->save();
    }
}
