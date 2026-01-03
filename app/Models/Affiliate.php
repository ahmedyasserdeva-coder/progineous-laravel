<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Affiliate extends Model
{
    protected $fillable = [
        'client_id',
        'referral_code',
        'commission_rate',
        'tier_id',
        'tier_upgraded_at',
        'total_earnings',
        'pending_earnings',
        'paid_earnings',
        'total_referrals',
        'active_referrals',
        'link_clicks',
        'status',
        'payment_method',
        'payment_details',
        'minimum_payout',
        'last_payout_at',
    ];

    protected $casts = [
        'commission_rate' => 'decimal:2',
        'total_earnings' => 'decimal:2',
        'pending_earnings' => 'decimal:2',
        'paid_earnings' => 'decimal:2',
        'payment_details' => 'array',
        'minimum_payout' => 'decimal:2',
        'last_payout_at' => 'datetime',
    ];

    /**
     * Generate a unique referral code
     */
    public static function generateReferralCode(): string
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (self::where('referral_code', $code)->exists());
        
        return $code;
    }

    /**
     * Get the client that owns this affiliate account
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get all referrals for this affiliate
     */
    public function referrals(): HasMany
    {
        return $this->hasMany(AffiliateReferral::class);
    }

    /**
     * Get all commissions for this affiliate
     */
    public function commissions(): HasMany
    {
        return $this->hasMany(AffiliateCommission::class);
    }

    /**
     * Get all payouts for this affiliate
     */
    public function payouts(): HasMany
    {
        return $this->hasMany(AffiliatePayout::class);
    }

    /**
     * Get all visitors for this affiliate
     */
    public function visitors(): HasMany
    {
        return $this->hasMany(AffiliateVisitor::class);
    }

    /**
     * Get all campaigns for this affiliate
     */
    public function campaigns(): HasMany
    {
        return $this->hasMany(AffiliateCampaign::class);
    }

    /**
     * Get the affiliate's tier
     */
    public function tier(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(AffiliateTier::class, 'tier_id');
    }

    /**
     * Get earned rewards
     */
    public function earnedRewards(): HasMany
    {
        return $this->hasMany(AffiliateEarnedReward::class);
    }

    /**
     * Get the referral link
     */
    public function getReferralLinkAttribute(): string
    {
        return url('/?ref=' . $this->referral_code);
    }

    /**
     * Get effective commission rate (from tier or default)
     */
    public function getEffectiveCommissionRateAttribute(): float
    {
        if ($this->tier) {
            return (float) $this->tier->commission_rate;
        }
        return (float) $this->commission_rate;
    }

    /**
     * Check if affiliate can request payout
     */
    public function canRequestPayout(): bool
    {
        return $this->pending_earnings >= $this->minimum_payout && $this->status === 'active';
    }

    /**
     * Get available balance for payout
     */
    public function getAvailableBalanceAttribute(): float
    {
        return (float) $this->pending_earnings;
    }

    /**
     * Alias for available balance (balance)
     */
    public function getBalanceAttribute(): float
    {
        return (float) $this->pending_earnings;
    }

    /**
     * Alias for total earnings (total_earned)
     */
    public function getTotalEarnedAttribute(): float
    {
        return (float) $this->total_earnings;
    }
}
