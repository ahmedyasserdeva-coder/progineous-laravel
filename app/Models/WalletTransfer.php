<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletTransfer extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'amount',
        'receiver_card_number',
        'reference',
        'status',
        'notes',
        'metadata',
        'completed_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'metadata' => 'array',
        'completed_at' => 'datetime'
    ];

    /**
     * Generate a unique transfer reference
     */
    public static function generateReference(): string
    {
        return 'TRN-' . strtoupper(uniqid()) . '-' . time();
    }

    /**
     * Sender relationship
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'sender_id');
    }

    /**
     * Receiver relationship
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'receiver_id');
    }

    /**
     * Scope for completed transfers
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for sender transfers
     */
    public function scopeSender($query, $clientId)
    {
        return $query->where('sender_id', $clientId);
    }

    /**
     * Scope for receiver transfers
     */
    public function scopeReceiver($query, $clientId)
    {
        return $query->where('receiver_id', $clientId);
    }
}
