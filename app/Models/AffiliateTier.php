<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AffiliateTier extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'icon',
        'color',
        'commission_rate',
        'min_referrals',
        'min_conversions',
        'min_earnings',
        'benefits',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'commission_rate' => 'decimal:2',
        'min_earnings' => 'decimal:2',
        'benefits' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Default tiers configuration
     */
    public const TIERS = [
        'bronze' => [
            'name' => 'Bronze',
            'icon' => '🥉',
            'color' => 'amber',
            'commission_rate' => 10.00,
            'min_referrals' => 0,
            'min_conversions' => 0,
            'min_earnings' => 0,
            'benefits' => [
                'Basic commission rate',
                'Access to affiliate dashboard',
                'Standard support',
            ],
        ],
        'silver' => [
            'name' => 'Silver',
            'icon' => '🥈',
            'color' => 'gray',
            'commission_rate' => 15.00,
            'min_referrals' => 10,
            'min_conversions' => 5,
            'min_earnings' => 100,
            'benefits' => [
                '15% commission rate',
                'Priority support',
                'Early access to promotions',
                'Custom referral links',
            ],
        ],
        'gold' => [
            'name' => 'Gold',
            'icon' => '🥇',
            'color' => 'yellow',
            'commission_rate' => 20.00,
            'min_referrals' => 50,
            'min_conversions' => 25,
            'min_earnings' => 500,
            'benefits' => [
                '20% commission rate',
                'Dedicated account manager',
                'Exclusive promotions',
                'Higher payout limits',
                'Custom marketing materials',
            ],
        ],
        'platinum' => [
            'name' => 'Platinum',
            'icon' => '💎',
            'color' => 'blue',
            'commission_rate' => 25.00,
            'min_referrals' => 100,
            'min_conversions' => 50,
            'min_earnings' => 2000,
            'benefits' => [
                '25% commission rate',
                'VIP support 24/7',
                'Exclusive deals & bonuses',
                'Unlimited payout',
                'Co-marketing opportunities',
                'Revenue sharing on renewals',
            ],
        ],
    ];

    /**
     * Get affiliates in this tier
     */
    public function affiliates(): HasMany
    {
        return $this->hasMany(Affiliate::class, 'tier_id');
    }

    /**
     * Get the next tier
     */
    public function getNextTierAttribute(): ?self
    {
        return self::where('sort_order', '>', $this->sort_order)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->first();
    }

    /**
     * Check if an affiliate qualifies for this tier
     */
    public function qualifiesFor(Affiliate $affiliate): bool
    {
        return $affiliate->total_referrals >= $this->min_referrals
            && $affiliate->active_referrals >= $this->min_conversions
            && $affiliate->total_earnings >= $this->min_earnings;
    }

    /**
     * Get progress percentage for an affiliate towards this tier
     */
    public function getProgressFor(Affiliate $affiliate): array
    {
        $referralsProgress = $this->min_referrals > 0 
            ? min(100, ($affiliate->total_referrals / $this->min_referrals) * 100) 
            : 100;
        
        $conversionsProgress = $this->min_conversions > 0 
            ? min(100, ($affiliate->active_referrals / $this->min_conversions) * 100) 
            : 100;
        
        $earningsProgress = $this->min_earnings > 0 
            ? min(100, ($affiliate->total_earnings / $this->min_earnings) * 100) 
            : 100;

        return [
            'referrals' => round($referralsProgress, 1),
            'conversions' => round($conversionsProgress, 1),
            'earnings' => round($earningsProgress, 1),
            'overall' => round(($referralsProgress + $conversionsProgress + $earningsProgress) / 3, 1),
        ];
    }

    /**
     * Get Tailwind color classes
     */
    public function getColorClassesAttribute(): array
    {
        $colorMap = [
            'amber' => ['bg' => 'bg-amber-500', 'text' => 'text-amber-600', 'light' => 'bg-amber-100', 'border' => 'border-amber-500'],
            'gray' => ['bg' => 'bg-gray-400', 'text' => 'text-gray-600', 'light' => 'bg-gray-100', 'border' => 'border-gray-400'],
            'yellow' => ['bg' => 'bg-yellow-500', 'text' => 'text-yellow-600', 'light' => 'bg-yellow-100', 'border' => 'border-yellow-500'],
            'blue' => ['bg' => 'bg-blue-500', 'text' => 'text-blue-600', 'light' => 'bg-blue-100', 'border' => 'border-blue-500'],
        ];

        return $colorMap[$this->color] ?? $colorMap['gray'];
    }

    /**
     * Scope for active tiers
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
