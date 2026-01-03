<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletTransaction extends Model
{
    protected $fillable = [
        'client_id',
        'amount',
        'type',
        'status',
        'payment_method',
        'payment_provider',
        'fawaterak_invoice_id',
        'fawaterak_invoice_key',
        'fawaterak_reference_id',
        'transaction_reference',
        'description',
        'notes',
        'metadata',
        'completed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'metadata' => 'array',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the client that owns the transaction
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Accessor for 'reference' attribute (alias for transaction_reference)
     */
    public function getReferenceAttribute(): ?string
    {
        return $this->transaction_reference;
    }

    /**
     * Scope for completed transactions
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for pending transactions
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for deposits
     */
    public function scopeDeposits($query)
    {
        return $query->where('type', 'deposit');
    }

    /**
     * Scope for withdrawals
     */
    public function scopeWithdrawals($query)
    {
        return $query->where('type', 'withdrawal');
    }

    /**
     * Check if transaction is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if transaction is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if transaction is failed
     */
    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    /**
     * Mark transaction as completed
     */
    public function markAsCompleted(): void
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }

    /**
     * Mark transaction as failed
     */
    public function markAsFailed(): void
    {
        $this->update([
            'status' => 'failed',
        ]);
    }

    /**
     * Generate unique transaction reference
     */
    public static function generateReference(): string
    {
        return 'TXN-' . strtoupper(uniqid()) . '-' . time();
    }
}
