<?php

namespace App\Services;

use App\Models\Affiliate;
use App\Models\AffiliateReferral;
use App\Models\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AffiliateService
{
    /**
     * Link a newly registered client to their referrer affiliate
     *
     * @param Client $client The newly registered client
     * @return AffiliateReferral|null The created referral record or null
     */
    public function linkReferral(Client $client): ?AffiliateReferral
    {
        // Get the referral code from session
        $refCode = Session::get('affiliate_ref_code');
        
        if (!$refCode) {
            return null;
        }
        
        // Find the affiliate with this referral code
        $affiliate = Affiliate::where('referral_code', $refCode)
            ->where('status', 'active')
            ->first();
        
        if (!$affiliate) {
            Log::warning('Affiliate not found for referral code', [
                'referral_code' => $refCode,
                'client_id' => $client->id,
            ]);
            return null;
        }
        
        // Make sure the affiliate is not referring themselves
        if ($affiliate->client_id === $client->id) {
            Log::warning('Affiliate tried to refer themselves', [
                'affiliate_id' => $affiliate->id,
                'client_id' => $client->id,
            ]);
            return null;
        }
        
        // Check if this client was already referred
        $existingReferral = AffiliateReferral::where('referred_client_id', $client->id)->first();
        if ($existingReferral) {
            Log::info('Client already has a referral record', [
                'client_id' => $client->id,
                'existing_affiliate_id' => $existingReferral->affiliate_id,
            ]);
            return $existingReferral;
        }
        
        try {
            // Create the referral record
            $referral = AffiliateReferral::create([
                'affiliate_id' => $affiliate->id,
                'referred_client_id' => $client->id,
                'referral_code' => $refCode,
                'status' => 'active',
                'total_spent' => 0,
                'commission_earned' => 0,
            ]);
            
            // Increment the affiliate's total referrals count
            $affiliate->increment('total_referrals');
            $affiliate->increment('active_referrals');
            
            // Clear the referral code from session
            Session::forget('affiliate_ref_code');
            Session::forget('affiliate_click_' . $refCode);
            
            Log::info('Affiliate referral created successfully', [
                'referral_id' => $referral->id,
                'affiliate_id' => $affiliate->id,
                'referred_client_id' => $client->id,
                'referral_code' => $refCode,
            ]);
            
            return $referral;
            
        } catch (\Exception $e) {
            Log::error('Failed to create affiliate referral', [
                'error' => $e->getMessage(),
                'affiliate_id' => $affiliate->id,
                'client_id' => $client->id,
            ]);
            return null;
        }
    }
    
    /**
     * Calculate and add commission for a purchase
     *
     * @param Client $client The client who made the purchase
     * @param float $amount The purchase amount
     * @return float The commission amount added
     */
    public function addCommission(Client $client, float $amount): float
    {
        // Find if this client was referred
        $referral = AffiliateReferral::where('referred_client_id', $client->id)
            ->where('status', 'active')
            ->first();
        
        if (!$referral) {
            return 0;
        }
        
        $affiliate = $referral->affiliate;
        
        if (!$affiliate || $affiliate->status !== 'active') {
            return 0;
        }
        
        // Calculate commission based on affiliate's commission rate
        $commissionRate = $affiliate->commission_rate / 100;
        $commission = $amount * $commissionRate;
        
        // Update referral record
        $referral->increment('total_spent', $amount);
        $referral->increment('commission_earned', $commission);
        
        // Update affiliate earnings
        $affiliate->increment('total_earnings', $commission);
        $affiliate->increment('pending_earnings', $commission);
        
        Log::info('Affiliate commission added', [
            'affiliate_id' => $affiliate->id,
            'referral_id' => $referral->id,
            'purchase_amount' => $amount,
            'commission' => $commission,
            'commission_rate' => $affiliate->commission_rate,
        ]);
        
        return $commission;
    }
    
    /**
     * Check if there's an active referral code in session
     *
     * @return string|null The referral code or null
     */
    public function getActiveReferralCode(): ?string
    {
        return Session::get('affiliate_ref_code');
    }
    
    /**
     * Get the affiliate for a referral code
     *
     * @param string $refCode
     * @return Affiliate|null
     */
    public function getAffiliateByCode(string $refCode): ?Affiliate
    {
        return Affiliate::where('referral_code', $refCode)
            ->where('status', 'active')
            ->first();
    }
}
