<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AffiliateReferral extends Model
{
    protected $fillable = [
        'affiliate_id',
        'referred_client_id',
        'referral_code',
        'status',
        'total_spent',
        'commission_earned',
    ];

    protected $casts = [
        'total_spent' => 'decimal:2',
        'commission_earned' => 'decimal:2',
    ];

    /**
     * Get the affiliate
     */
    public function affiliate(): BelongsTo
    {
        return $this->belongsTo(Affiliate::class);
    }

    /**
     * Get the referred client
     */
    public function referredClient(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'referred_client_id');
    }

    /**
     * Get commissions for this referral
     */
    public function commissions(): HasMany
    {
        return $this->hasMany(AffiliateCommission::class, 'referral_id');
    }
}
