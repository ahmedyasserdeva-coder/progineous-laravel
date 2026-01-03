<?php

namespace App\Services;

use App\Models\Affiliate;
use App\Models\AffiliateTier;
use App\Models\AffiliateTierReward;
use App\Models\AffiliateEarnedReward;
use App\Models\AffiliateCommission;
use Illuminate\Support\Facades\DB;

class AffiliateTierService
{
    /**
     * Check and update affiliate's tier
     * Only upgrades tier if affiliate qualifies for a higher tier
     * Never downgrades tier (admin can set tier manually)
     */
    public function checkAndUpdateTier(Affiliate $affiliate): ?AffiliateTier
    {
        $tiers = AffiliateTier::active()->orderByDesc('sort_order')->get();
        $currentTierId = $affiliate->tier_id;
        
        foreach ($tiers as $tier) {
            if ($tier->qualifiesFor($affiliate)) {
                // Only upgrade if the new tier is higher than current
                // Never downgrade - admin manual tier changes should be preserved
                if (!$currentTierId || $tier->sort_order > ($affiliate->tier->sort_order ?? 0)) {
                    $this->upgradeTier($affiliate, $tier);
                    return $tier;
                }
                break;
            }
        }
        
        return $affiliate->tier;
    }

    /**
     * Upgrade affiliate to a new tier
     */
    public function upgradeTier(Affiliate $affiliate, AffiliateTier $tier): void
    {
        $oldTier = $affiliate->tier;
        
        $affiliate->update([
            'tier_id' => $tier->id,
            'tier_upgraded_at' => now(),
            'commission_rate' => $tier->commission_rate,
        ]);

        // Could dispatch event for notifications, emails, etc.
        // event(new AffiliateTierUpgraded($affiliate, $oldTier, $tier));
    }

    /**
     * Check and award milestone rewards
     */
    public function checkAndAwardRewards(Affiliate $affiliate): array
    {
        $newRewards = [];
        $rewards = AffiliateTierReward::active()->get();

        foreach ($rewards as $reward) {
            // Skip if already earned
            if ($reward->isEarnedBy($affiliate)) {
                continue;
            }

            $progress = $reward->getProgressFor($affiliate);
            
            if ($progress['completed']) {
                $earnedReward = $this->awardReward($affiliate, $reward);
                if ($earnedReward) {
                    $newRewards[] = $earnedReward;
                }
            }
        }

        return $newRewards;
    }

    /**
     * Award a reward to an affiliate
     */
    public function awardReward(Affiliate $affiliate, AffiliateTierReward $reward): ?AffiliateEarnedReward
    {
        return DB::transaction(function () use ($affiliate, $reward) {
            // Create earned reward record
            $earnedReward = AffiliateEarnedReward::create([
                'affiliate_id' => $affiliate->id,
                'affiliate_tier_reward_id' => $reward->id,
                'amount' => $reward->reward_value,
                'status' => 'approved',
                'earned_at' => now(),
            ]);

            // If it's a bonus, add to earnings and create commission record
            if ($reward->reward_type === 'bonus') {
                // Update affiliate earnings (pending_earnings = available balance)
                $affiliate->increment('pending_earnings', $reward->reward_value);
                $affiliate->increment('total_earnings', $reward->reward_value);
                
                // Create a commission record for the reward to show in history
                AffiliateCommission::create([
                    'affiliate_id' => $affiliate->id,
                    'referral_id' => null, // No referral for milestone rewards
                    'invoice_id' => null,
                    'amount' => $reward->reward_value,
                    'commission_rate' => 100, // Full bonus
                    'commission_amount' => $reward->reward_value,
                    'status' => 'approved',
                    'description' => '🎁 Milestone Reward: ' . $reward->name,
                ]);
            }

            // Could dispatch event for notifications
            // event(new AffiliateRewardEarned($affiliate, $reward, $earnedReward));

            return $earnedReward;
        });
    }

    /**
     * Get tier progress for an affiliate
     */
    public function getTierProgress(Affiliate $affiliate): array
    {
        $currentTier = $affiliate->tier;
        $nextTier = $currentTier?->next_tier ?? AffiliateTier::active()->first();
        
        if (!$nextTier && !$currentTier) {
            $nextTier = AffiliateTier::active()->first();
        }

        $progress = $nextTier ? $nextTier->getProgressFor($affiliate) : null;

        return [
            'current_tier' => $currentTier,
            'next_tier' => $currentTier ? $currentTier->next_tier : $nextTier,
            'progress' => $progress,
            'is_max_tier' => $currentTier && !$currentTier->next_tier,
        ];
    }

    /**
     * Get all rewards with progress for an affiliate
     */
    public function getRewardsWithProgress(Affiliate $affiliate): array
    {
        $rewards = AffiliateTierReward::active()->get();
        $earnedRewardIds = $affiliate->earnedRewards()->pluck('affiliate_tier_reward_id')->toArray();

        return $rewards->map(function ($reward) use ($affiliate, $earnedRewardIds) {
            $isEarned = in_array($reward->id, $earnedRewardIds);
            $progress = $reward->getProgressFor($affiliate);

            return [
                'reward' => $reward,
                'is_earned' => $isEarned,
                'progress' => $progress,
            ];
        })->toArray();
    }

    /**
     * Seed default tiers
     */
    public function seedDefaultTiers(): void
    {
        $sortOrder = 1;
        foreach (AffiliateTier::TIERS as $slug => $config) {
            AffiliateTier::updateOrCreate(
                ['slug' => $slug],
                array_merge($config, ['slug' => $slug, 'sort_order' => $sortOrder++])
            );
        }
    }

    /**
     * Seed default rewards
     */
    public function seedDefaultRewards(): void
    {
        foreach (AffiliateTierReward::DEFAULT_REWARDS as $reward) {
            AffiliateTierReward::updateOrCreate(
                ['name' => $reward['name'], 'type' => $reward['type'], 'target_value' => $reward['target_value']],
                $reward
            );
        }
    }

    /**
     * Initialize tier system (seed tiers and rewards)
     */
    public function initialize(): void
    {
        $this->seedDefaultTiers();
        $this->seedDefaultRewards();
    }

    /**
     * Assign default tier to affiliate if none
     */
    public function assignDefaultTier(Affiliate $affiliate): AffiliateTier
    {
        if (!$affiliate->tier_id) {
            $defaultTier = AffiliateTier::where('slug', 'bronze')->first() 
                ?? AffiliateTier::active()->first();
            
            if ($defaultTier) {
                $affiliate->update([
                    'tier_id' => $defaultTier->id,
                    'tier_upgraded_at' => now(),
                ]);
            }

            return $defaultTier;
        }

        return $affiliate->tier;
    }
}
