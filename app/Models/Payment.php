<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'gateway',
        'transaction_id',
        'invoice_number',
        'amount',
        'currency',
        'status',
        'gateway_data',
        'fawaterak_invoice_id',
        'fawaterak_invoice_key',
        'fawaterak_payment_method_id',
        'fawaterak_payment_method_name',
        'stripe_payment_intent_id',
        'stripe_charge_id',
        'paypal_order_id',
        'paypal_payer_id',
        'items',
        'customer_info',
        'tax_amount',
        'discount_amount',
        'description',
        'metadata',
        'refund_amount',
        'refunded_at',
        'refund_reason',
        'paid_at',
    ];

    protected $casts = [
        'gateway_data' => 'array',
        'items' => 'array',
        'customer_info' => 'array',
        'metadata' => 'array',
        'amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'refund_amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'refunded_at' => 'datetime',
    ];

    /**
     * Get the client that owns the payment.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Check if payment is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if payment is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if payment is failed
     */
    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    /**
     * Check if payment is refunded
     */
    public function isRefunded(): bool
    {
        return $this->status === 'refunded';
    }

    /**
     * Mark payment as completed
     */
    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'paid_at' => now(),
        ]);
    }

    /**
     * Mark payment as failed
     */
    public function markAsFailed()
    {
        $this->update(['status' => 'failed']);
    }

    /**
     * Get formatted amount
     */
    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->amount, 2) . ' ' . $this->currency;
    }
}
