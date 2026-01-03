<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AffiliateEarnedReward extends Model
{
    protected $fillable = [
        'affiliate_id',
        'affiliate_tier_reward_id',
        'amount',
        'status',
        'earned_at',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'earned_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    /**
     * Reward statuses
     */
    public const STATUSES = [
        'pending' => 'Pending',
        'paid' => 'Paid',
        'cancelled' => 'Cancelled',
    ];

    /**
     * Get the affiliate
     */
    public function affiliate(): BelongsTo
    {
        return $this->belongsTo(Affiliate::class);
    }

    /**
     * Get the reward
     */
    public function reward(): BelongsTo
    {
        return $this->belongsTo(AffiliateTierReward::class, 'affiliate_tier_reward_id');
    }

    /**
     * Mark as paid
     */
    public function markAsPaid(): void
    {
        $this->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);
    }

    /**
     * Scope for pending rewards
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for paid rewards
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }
}
