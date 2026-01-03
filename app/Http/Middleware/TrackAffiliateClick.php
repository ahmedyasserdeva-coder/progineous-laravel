<?php

namespace App\Http\Middleware;

use App\Models\Affiliate;
use App\Models\AffiliateCampaign;
use App\Models\AffiliateVisitor;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

class TrackAffiliateClick
{
    /**
     * Checkout page patterns to track
     */
    protected array $checkoutPatterns = [
        'checkout',
        'cart',
        'payment',
        'order/create',
        'subscribe',
    ];

    /**
     * Handle an incoming request.
     *
     * Track affiliate link clicks when user arrives with ref parameter
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if ref parameter exists in the request
        $refCode = $request->query('ref');
        $campaignSlug = $request->query('campaign');
        
        if ($refCode) {
            // Find the affiliate with this referral code (active status)
            $affiliate = Affiliate::where('referral_code', $refCode)
                ->where('status', 'active')
                ->first();
            
            if ($affiliate) {
                // Check for campaign
                $campaign = null;
                if ($campaignSlug) {
                    $campaign = AffiliateCampaign::where('slug', $campaignSlug)
                        ->where('affiliate_id', $affiliate->id)
                        ->where('status', 'active')
                        ->first();
                }
                
                // Check if this is a new click (not from same session)
                $sessionKey = 'affiliate_click_' . $refCode . ($campaign ? '_' . $campaign->id : '');
                
                if (!$request->session()->has($sessionKey)) {
                    // Increment link clicks on affiliate
                    $affiliate->increment('link_clicks');
                    
                    // Increment clicks on campaign if exists
                    if ($campaign) {
                        $campaign->incrementClicks();
                    }
                    
                    // Mark this referral as tracked in session to avoid duplicate counting
                    $request->session()->put($sessionKey, now()->timestamp);
                    
                    // Store the referral code and campaign in session for registration
                    $request->session()->put('affiliate_ref_code', $refCode);
                    if ($campaign) {
                        $request->session()->put('affiliate_campaign_id', $campaign->id);
                    }
                    
                    Log::info('Affiliate link click tracked', [
                        'affiliate_id' => $affiliate->id,
                        'referral_code' => $refCode,
                        'campaign_id' => $campaign?->id,
                        'campaign_slug' => $campaignSlug,
                        'ip' => $request->ip(),
                        'user_agent' => $request->userAgent(),
                    ]);
                } else {
                    // Even if already clicked, make sure ref code is in session
                    $request->session()->put('affiliate_ref_code', $refCode);
                    if ($campaign) {
                        $request->session()->put('affiliate_campaign_id', $campaign->id);
                    }
                }
                
                // Track visitor if table exists
                $this->trackVisitor($request, $affiliate, $refCode, $campaign);
            }
        }
        
        // Update last activity for existing affiliate visitors
        $this->updateVisitorActivity($request);
        
        // Track checkout page visits
        $this->trackCheckoutVisit($request);

        return $next($request);
    }

    /**
     * Track or update visitor record
     */
    protected function trackVisitor(Request $request, Affiliate $affiliate, string $refCode, ?AffiliateCampaign $campaign = null): void
    {
        // Check if table exists
        if (!Schema::hasTable('affiliate_visitors')) {
            return;
        }

        try {
            $sessionId = $request->session()->getId();
            
            $data = [
                'ip_address' => $request->ip(),
                'user_agent' => substr($request->userAgent() ?? '', 0, 255),
                'referral_code' => $refCode,
                'landing_page' => $request->fullUrl(),
                'last_activity_at' => now(),
            ];
            
            // Add campaign_id if campaign exists and column exists
            if ($campaign && Schema::hasColumn('affiliate_visitors', 'campaign_id')) {
                $data['campaign_id'] = $campaign->id;
            }
            
            AffiliateVisitor::updateOrCreate(
                [
                    'affiliate_id' => $affiliate->id,
                    'session_id' => $sessionId,
                ],
                $data
            );
        } catch (\Exception $e) {
            Log::error('Failed to track affiliate visitor', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Update visitor's last activity
     */
    protected function updateVisitorActivity(Request $request): void
    {
        if (!Schema::hasTable('affiliate_visitors')) {
            return;
        }

        $refCode = $request->session()->get('affiliate_ref_code');
        
        if ($refCode) {
            try {
                AffiliateVisitor::where('session_id', $request->session()->getId())
                    ->where('referral_code', $refCode)
                    ->update(['last_activity_at' => now()]);
            } catch (\Exception $e) {
                // Silently fail
            }
        }
    }

    /**
     * Track if visitor reached checkout page
     */
    protected function trackCheckoutVisit(Request $request): void
    {
        if (!Schema::hasTable('affiliate_visitors')) {
            return;
        }

        $refCode = $request->session()->get('affiliate_ref_code');
        
        if (!$refCode) {
            return;
        }

        $currentPath = $request->path();
        
        // Check if current page matches checkout patterns
        foreach ($this->checkoutPatterns as $pattern) {
            if (str_contains($currentPath, $pattern)) {
                try {
                    AffiliateVisitor::where('session_id', $request->session()->getId())
                        ->where('referral_code', $refCode)
                        ->where('visited_checkout', false)
                        ->update([
                            'visited_checkout' => true,
                            'checkout_visited_at' => now(),
                            'last_activity_at' => now(),
                        ]);
                } catch (\Exception $e) {
                    // Silently fail
                }
                break;
            }
        }
    }
}
