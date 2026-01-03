<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AffiliateTierReward extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'target_value',
        'reward_type',
        'reward_value',
        'icon',
        'is_active',
    ];

    protected $casts = [
        'reward_value' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Reward types
     */
    public const TYPES = [
        'referrals' => 'Total Referrals',
        'conversions' => 'Active Conversions', 
        'earnings' => 'Total Earnings',
    ];

    /**
     * Reward payout types
     */
    public const REWARD_TYPES = [
        'bonus' => 'Cash Bonus',
        'commission_boost' => 'Commission Boost',
        'gift' => 'Gift/Prize',
    ];

    /**
     * Default milestone rewards
     */
    public const DEFAULT_REWARDS = [
        [
            'name' => 'First Steps',
            'description' => 'Get your first 5 referrals',
            'type' => 'referrals',
            'target_value' => 5,
            'reward_type' => 'bonus',
            'reward_value' => 25.00,
            'icon' => '🎯',
        ],
        [
            'name' => 'Growing Network',
            'description' => 'Reach 10 referrals',
            'type' => 'referrals',
            'target_value' => 10,
            'reward_type' => 'bonus',
            'reward_value' => 50.00,
            'icon' => '🌱',
        ],
        [
            'name' => 'Rising Star',
            'description' => 'Get 25 referrals',
            'type' => 'referrals',
            'target_value' => 25,
            'reward_type' => 'bonus',
            'reward_value' => 100.00,
            'icon' => '⭐',
        ],
        [
            'name' => 'Affiliate Pro',
            'description' => 'Reach 50 referrals',
            'type' => 'referrals',
            'target_value' => 50,
            'reward_type' => 'bonus',
            'reward_value' => 200.00,
            'icon' => '🚀',
        ],
        [
            'name' => 'Super Affiliate',
            'description' => 'Get 100 referrals',
            'type' => 'referrals',
            'target_value' => 100,
            'reward_type' => 'bonus',
            'reward_value' => 500.00,
            'icon' => '💫',
        ],
        [
            'name' => 'First Conversion',
            'description' => 'Get your first paying customer',
            'type' => 'conversions',
            'target_value' => 1,
            'reward_type' => 'bonus',
            'reward_value' => 10.00,
            'icon' => '🎉',
        ],
        [
            'name' => 'Conversion Master',
            'description' => 'Get 10 paying customers',
            'type' => 'conversions',
            'target_value' => 10,
            'reward_type' => 'bonus',
            'reward_value' => 75.00,
            'icon' => '🏆',
        ],
        [
            'name' => 'Earnings Milestone',
            'description' => 'Earn $500 in commissions',
            'type' => 'earnings',
            'target_value' => 500,
            'reward_type' => 'bonus',
            'reward_value' => 50.00,
            'icon' => '💰',
        ],
        [
            'name' => 'Top Earner',
            'description' => 'Earn $2000 in commissions',
            'type' => 'earnings',
            'target_value' => 2000,
            'reward_type' => 'bonus',
            'reward_value' => 200.00,
            'icon' => '💎',
        ],
    ];

    /**
     * Get earned rewards
     */
    public function earnedRewards(): HasMany
    {
        return $this->hasMany(AffiliateEarnedReward::class);
    }

    /**
     * Check if an affiliate has earned this reward
     */
    public function isEarnedBy(Affiliate $affiliate): bool
    {
        return $this->earnedRewards()->where('affiliate_id', $affiliate->id)->exists();
    }

    /**
     * Get progress for an affiliate
     */
    public function getProgressFor(Affiliate $affiliate): array
    {
        $currentValue = match($this->type) {
            'referrals' => $affiliate->total_referrals,
            'conversions' => $affiliate->active_referrals,
            'earnings' => (float) $affiliate->total_earnings,
            default => 0,
        };

        $percentage = $this->target_value > 0 
            ? min(100, ($currentValue / $this->target_value) * 100) 
            : 100;

        return [
            'current' => $currentValue,
            'target' => $this->target_value,
            'percentage' => round($percentage, 1),
            'remaining' => max(0, $this->target_value - $currentValue),
            'completed' => $currentValue >= $this->target_value,
        ];
    }

    /**
     * Scope for active rewards
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('target_value');
    }

    /**
     * Scope by type
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Get translation key for reward name
     */
    public function getTranslationKey(): string
    {
        // Convert name to snake_case translation key
        $key = strtolower(str_replace([' ', '-'], '_', $this->name));
        return 'reward_' . $key;
    }

    /**
     * Get translated name
     */
    public function getTranslatedNameAttribute(): string
    {
        $key = 'affiliate.' . $this->getTranslationKey();
        $translated = __($key);
        
        // If translation not found, return original name
        return $translated === $key ? $this->name : $translated;
    }

    /**
     * Get translated description
     */
    public function getTranslatedDescriptionAttribute(): string
    {
        $key = 'affiliate.' . $this->getTranslationKey() . '_desc';
        $translated = __($key);
        
        // If translation not found, return original description
        return $translated === $key ? $this->description : $translated;
    }
}
