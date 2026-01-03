<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Affiliate;
use App\Models\AffiliateCampaign;
use App\Models\AffiliateCommission;
use App\Models\AffiliatePayout;
use App\Models\AffiliateTier;
use App\Models\AffiliateTierReward;
use App\Models\AffiliateVisitor;
use App\Models\WalletTransaction;
use App\Services\AffiliateTierService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AffiliateController extends Controller
{
    protected AffiliateTierService $tierService;

    public function __construct(AffiliateTierService $tierService)
    {
        $this->tierService = $tierService;
    }

    /**
     * Show affiliate dashboard
     */
    public function index()
    {
        $client = Auth::guard('client')->user();
        $affiliate = Affiliate::where('client_id', $client->id)->first();
        
        // If not an affiliate, show activation page
        if (!$affiliate) {
            return view('frontend.client.affiliate.activate', compact('client'));
        }
        
        // Initialize tier system if needed
        $this->initializeTierSystem($affiliate);
        
        // Get tier info
        $tierInfo = $this->tierService->getTierProgress($affiliate);
        $allTiers = AffiliateTier::active()->get();
        $rewards = $this->tierService->getRewardsWithProgress($affiliate);
        
        // Check for new rewards
        $this->tierService->checkAndAwardRewards($affiliate);
        $this->tierService->checkAndUpdateTier($affiliate);
        
        // Refresh affiliate data
        $affiliate->refresh();
        
        // Get referrals
        $referrals = $affiliate->referrals()
            ->with('referredClient')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Get recent commissions with relationships
        $commissions = $affiliate->commissions()
            ->with(['referral.referredClient', 'invoice.order.product'])
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get();
        
        // Get recent payouts
        $payouts = $affiliate->payouts()
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Visitor statistics (if table exists)
        $visitorStats = $this->getVisitorStats($affiliate);
        
        // Advanced Statistics
        $advancedStats = $this->getAdvancedStats($affiliate);
        
        // Statistics
        $stats = [
            'total_referrals' => $affiliate->total_referrals,
            'active_referrals' => $affiliate->active_referrals,
            'total_earnings' => $affiliate->total_earnings,
            'pending_earnings' => $affiliate->pending_earnings,
            'paid_earnings' => $affiliate->paid_earnings,
            'commission_rate' => $affiliate->effective_commission_rate,
            'this_month_earnings' => $affiliate->commissions()
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->where('status', '!=', 'cancelled')
                ->sum('commission_amount'),
            'this_month_referrals' => $affiliate->referrals()
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];
        
        return view('frontend.client.affiliate.index', compact(
            'client', 
            'affiliate', 
            'referrals', 
            'commissions', 
            'payouts',
            'stats',
            'visitorStats',
            'advancedStats',
            'tierInfo',
            'allTiers',
            'rewards'
        ));
    }

    /**
     * Initialize tier system for affiliate
     */
    protected function initializeTierSystem(Affiliate $affiliate): void
    {
        // Seed tiers if none exist
        if (AffiliateTier::count() === 0) {
            $this->tierService->initialize();
        }
        
        // Assign default tier if affiliate has none
        if (!$affiliate->tier_id) {
            $this->tierService->assignDefaultTier($affiliate);
        }
    }

    /**
     * Get advanced statistics for affiliate
     */
    protected function getAdvancedStats(Affiliate $affiliate): array
    {
        // Conversion Rate
        $totalClicks = $affiliate->link_clicks ?? 0;
        $totalReferrals = $affiliate->total_referrals ?? 0;
        $conversionRate = $totalClicks > 0 ? round(($totalReferrals / $totalClicks) * 100, 2) : 0;
        
        // Earnings by day (last 30 days)
        $earningsChart = $affiliate->commissions()
            ->where('status', '!=', 'cancelled')
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, SUM(commission_amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('total', 'date')
            ->toArray();
        
        // Fill missing days with 0
        $last30Days = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $last30Days[$date] = $earningsChart[$date] ?? 0;
        }
        
        // Referrals by day (last 30 days)
        $referralsChart = $affiliate->referrals()
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('total', 'date')
            ->toArray();
        
        // Fill missing days with 0
        $referralsLast30Days = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $referralsLast30Days[$date] = $referralsChart[$date] ?? 0;
        }
        
        // Best performing days (by referrals)
        $bestDays = $affiliate->referrals()
            ->selectRaw('DAYNAME(created_at) as day_name, DAYOFWEEK(created_at) as day_num, COUNT(*) as total')
            ->groupBy('day_name', 'day_num')
            ->orderByDesc('total')
            ->get();
        
        // Clicks by day (last 7 days) - if we track this
        $clicksChart = [];
        if (Schema::hasTable('affiliate_visitors')) {
            $clicksData = $affiliate->visitors()
                ->where('created_at', '>=', now()->subDays(7))
                ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
                ->groupBy('date')
                ->orderBy('date')
                ->get()
                ->pluck('total', 'date')
                ->toArray();
            
            for ($i = 6; $i >= 0; $i--) {
                $date = now()->subDays($i)->format('Y-m-d');
                $clicksChart[$date] = $clicksData[$date] ?? 0;
            }
        }
        
        // Average earnings per referral
        $avgEarningsPerReferral = $totalReferrals > 0 
            ? round($affiliate->total_earnings / $totalReferrals, 2) 
            : 0;
        
        // Converted vs Pending referrals (using status column)
        $convertedReferrals = $affiliate->referrals()->where('status', 'converted')->count();
        $pendingReferrals = $affiliate->referrals()->where('status', 'pending')->count();
        
        return [
            'conversion_rate' => $conversionRate,
            'earnings_chart' => $last30Days,
            'referrals_chart' => $referralsLast30Days,
            'clicks_chart' => $clicksChart,
            'best_days' => $bestDays,
            'avg_earnings_per_referral' => $avgEarningsPerReferral,
            'converted_referrals' => $convertedReferrals,
            'pending_referrals' => $pendingReferrals,
            'total_clicks' => $totalClicks,
        ];
    }

    /**
     * Get visitor statistics for affiliate
     */
    protected function getVisitorStats(Affiliate $affiliate): array
    {
        if (!Schema::hasTable('affiliate_visitors')) {
            return [
                'online_count' => 0,
                'today_count' => 0,
                'checkout_count' => 0,
                'online_visitors' => collect(),
            ];
        }

        return [
            'online_count' => $affiliate->visitors()->online()->count(),
            'today_count' => $affiliate->visitors()->today()->count(),
            'checkout_count' => $affiliate->visitors()->where('visited_checkout', true)->today()->count(),
            'online_visitors' => $affiliate->visitors()
                ->online()
                ->orderBy('last_activity_at', 'desc')
                ->take(10)
                ->get(),
        ];
    }

    /**
     * Activate affiliate account
     */
    public function activate(Request $request)
    {
        $client = Auth::guard('client')->user();
        
        // Check if already an affiliate
        if (Affiliate::where('client_id', $client->id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => __('affiliate.already_activated')
            ]);
        }
        
        try {
            // Get the default tier (Bronze - lowest sort_order)
            $defaultTier = \App\Models\AffiliateTier::where('is_active', true)
                ->orderBy('sort_order', 'asc')
                ->first();
            
            // Create affiliate account
            $affiliate = Affiliate::create([
                'client_id' => $client->id,
                'referral_code' => Affiliate::generateReferralCode(),
                'commission_rate' => $defaultTier ? $defaultTier->commission_rate : 10.00,
                'tier_id' => $defaultTier ? $defaultTier->id : null,
                'status' => 'active',
                'minimum_payout' => 50.00,
            ]);
            
            // Update client to be an affiliate
            $client->update(['is_affiliate' => true]);
            
            return response()->json([
                'success' => true,
                'message' => __('affiliate.activated_successfully'),
                'referral_code' => $affiliate->referral_code,
                'referral_link' => $affiliate->referral_link,
            ]);
        } catch (\Exception $e) {
            \Log::error('Affiliate activation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get referral statistics (AJAX)
     */
    public function stats()
    {
        $client = Auth::guard('client')->user();
        $affiliate = Affiliate::where('client_id', $client->id)->first();
        
        if (!$affiliate) {
            return response()->json(['success' => false, 'message' => 'Not an affiliate']);
        }
        
        return response()->json([
            'success' => true,
            'stats' => [
                'total_referrals' => $affiliate->total_referrals,
                'active_referrals' => $affiliate->active_referrals,
                'total_earnings' => number_format($affiliate->total_earnings, 2),
                'pending_earnings' => number_format($affiliate->pending_earnings, 2),
                'paid_earnings' => number_format($affiliate->paid_earnings, 2),
                'link_clicks' => $affiliate->link_clicks ?? 0,
            ]
        ]);
    }

    /**
     * Get live visitor statistics (AJAX - Real-time polling)
     */
    public function liveVisitors()
    {
        $client = Auth::guard('client')->user();
        $affiliate = Affiliate::where('client_id', $client->id)->first();
        
        if (!$affiliate) {
            return response()->json(['success' => false, 'message' => 'Not an affiliate']);
        }
        
        $visitorStats = $this->getVisitorStats($affiliate);
        
        // Format online visitors for JSON response
        $onlineVisitors = $visitorStats['online_visitors']->map(function($visitor) {
            return [
                'ip_address' => Str::limit($visitor->ip_address, 15),
                'visited_checkout' => $visitor->visited_checkout,
                'last_activity' => $visitor->last_activity_at->diffForHumans(),
            ];
        });
        
        return response()->json([
            'success' => true,
            'online_count' => $visitorStats['online_count'],
            'today_count' => $visitorStats['today_count'],
            'checkout_count' => $visitorStats['checkout_count'],
            'online_visitors' => $onlineVisitors,
        ]);
    }

    /**
     * Request payout
     */
    public function requestPayout(Request $request)
    {
        $client = Auth::guard('client')->user();
        $affiliate = Affiliate::where('client_id', $client->id)->first();
        
        if (!$affiliate) {
            return response()->json([
                'success' => false,
                'message' => __('affiliate.not_an_affiliate')
            ]);
        }
        
        if (!$affiliate->canRequestPayout()) {
            return response()->json([
                'success' => false,
                'message' => __('affiliate.minimum_payout_not_reached', ['amount' => $affiliate->minimum_payout])
            ]);
        }
        
        try {
            // Use wallet as default payment method if not specified
            $paymentMethod = $request->input('payment_method', 'wallet');
            $paymentDetails = null;
            
            if ($paymentMethod !== 'wallet' && $request->has('payment_details')) {
                $paymentDetails = ['info' => $request->payment_details];
            }
            
            $payout = AffiliatePayout::create([
                'affiliate_id' => $affiliate->id,
                'amount' => $affiliate->pending_earnings,
                'payment_method' => $paymentMethod,
                'payment_details' => $paymentDetails,
                'status' => 'completed', // Auto-complete for wallet
            ]);
            
            $payoutAmount = $affiliate->pending_earnings;
            
            // Deduct from pending earnings and add to paid earnings
            $affiliate->decrement('pending_earnings', $payoutAmount);
            $affiliate->increment('paid_earnings', $payoutAmount);
            
            // If payment method is wallet, add to client's wallet balance
            if ($paymentMethod === 'wallet') {
                // Create wallet transaction
                WalletTransaction::create([
                    'client_id' => $client->id,
                    'amount' => $payoutAmount,
                    'type' => 'deposit',
                    'status' => 'completed',
                    'payment_method' => 'affiliate_payout',
                    'payment_provider' => 'affiliate',
                    'transaction_reference' => 'AFF-' . strtoupper(Str::random(10)),
                    'description' => __('affiliate.payout_description', ['amount' => number_format($payoutAmount, 2)]),
                    'notes' => 'Affiliate commission payout #' . $payout->id,
                    'metadata' => [
                        'affiliate_id' => $affiliate->id,
                        'payout_id' => $payout->id,
                    ],
                    'completed_at' => now(),
                ]);
                
                // Update client's wallet balance
                $client->increment('wallet_balance', $payoutAmount);
            }
            
            return response()->json([
                'success' => true,
                'message' => __('affiliate.payout_requested'),
                'payout_id' => $payout->id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update payment settings
     */
    public function updatePaymentSettings(Request $request)
    {
        $client = Auth::guard('client')->user();
        $affiliate = Affiliate::where('client_id', $client->id)->first();
        
        if (!$affiliate) {
            return response()->json([
                'success' => false,
                'message' => __('affiliate.not_an_affiliate')
            ]);
        }
        
        $request->validate([
            'payment_method' => 'required|in:paypal,bank_transfer,wallet',
            'payment_details' => 'nullable|array',
        ]);
        
        $affiliate->update([
            'payment_method' => $request->payment_method,
            'payment_details' => $request->payment_details,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => __('affiliate.settings_updated'),
        ]);
    }

    /**
     * Show FAQs page
     */
    public function faqs()
    {
        return view('frontend.client.affiliate.faqs');
    }

    // ==========================================
    // Campaign Management Methods
    // ==========================================

    /**
     * Show campaigns page
     */
    public function campaigns(Request $request)
    {
        $client = Auth::guard('client')->user();
        $affiliate = Affiliate::where('client_id', $client->id)->first();
        
        if (!$affiliate) {
            return redirect()->route('client.affiliate.index');
        }
        
        $source = $request->get('source', 'all');
        
        // Ensure source is a string
        if (is_array($source)) {
            $source = 'all';
        }
        
        $query = $affiliate->campaigns()->orderBy('created_at', 'desc');
        
        if ($source !== 'all' && array_key_exists($source, AffiliateCampaign::SOURCES)) {
            $query->where('source', $source);
        }
        
        $campaigns = $query->paginate(10)->withQueryString();
        
        // Get all unique sources from user's campaigns (not just current page)
        $usedSources = $affiliate->campaigns()->distinct()->pluck('source')->toArray();
        
        $sources = AffiliateCampaign::SOURCES;
        
        return view('frontend.client.affiliate.campaigns', compact('affiliate', 'campaigns', 'sources', 'source', 'usedSources'));
    }

    /**
     * Store a new campaign
     */
    public function storeCampaign(Request $request)
    {
        $client = Auth::guard('client')->user();
        $affiliate = Affiliate::where('client_id', $client->id)->first();
        
        if (!$affiliate) {
            return response()->json([
                'success' => false,
                'message' => __('affiliate.not_an_affiliate')
            ], 403);
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'source' => 'required|string|in:' . implode(',', array_keys(AffiliateCampaign::SOURCES)),
            'description' => 'nullable|string|max:1000',
            'destination_url' => 'nullable|url|max:500',
        ]);
        
        try {
            $campaign = AffiliateCampaign::create([
                'affiliate_id' => $affiliate->id,
                'name' => $request->name,
                'source' => $request->source,
                'description' => $request->description,
                'destination_url' => $request->destination_url,
            ]);
            
            return response()->json([
                'success' => true,
                'message' => __('affiliate.campaign_created'),
                'campaign' => [
                    'id' => $campaign->id,
                    'name' => $campaign->name,
                    'tracking_link' => $campaign->tracking_link,
                    'qr_code_url' => $campaign->qr_code_url,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update campaign status
     */
    public function updateCampaignStatus(Request $request, $id)
    {
        $client = Auth::guard('client')->user();
        $affiliate = Affiliate::where('client_id', $client->id)->first();
        
        if (!$affiliate) {
            return response()->json([
                'success' => false,
                'message' => __('affiliate.not_an_affiliate')
            ], 403);
        }
        
        $campaign = AffiliateCampaign::where('id', $id)
            ->where('affiliate_id', $affiliate->id)
            ->first();
        
        if (!$campaign) {
            return response()->json([
                'success' => false,
                'message' => __('affiliate.campaign_not_found')
            ], 404);
        }
        
        $request->validate([
            'status' => 'required|in:active,paused,archived',
        ]);
        
        $campaign->update(['status' => $request->status]);
        
        return response()->json([
            'success' => true,
            'message' => __('affiliate.campaign_updated'),
        ]);
    }

    /**
     * Delete a campaign
     */
    public function deleteCampaign($id)
    {
        $client = Auth::guard('client')->user();
        $affiliate = Affiliate::where('client_id', $client->id)->first();
        
        if (!$affiliate) {
            return response()->json([
                'success' => false,
                'message' => __('affiliate.not_an_affiliate')
            ], 403);
        }
        
        $campaign = AffiliateCampaign::where('id', $id)
            ->where('affiliate_id', $affiliate->id)
            ->first();
        
        if (!$campaign) {
            return response()->json([
                'success' => false,
                'message' => __('affiliate.campaign_not_found')
            ], 404);
        }
        
        $campaign->delete();
        
        return response()->json([
            'success' => true,
            'message' => __('affiliate.campaign_deleted'),
        ]);
    }

    /**
     * Get campaign statistics (AJAX)
     */
    public function campaignStats($id)
    {
        $client = Auth::guard('client')->user();
        $affiliate = Affiliate::where('client_id', $client->id)->first();
        
        if (!$affiliate) {
            return response()->json(['success' => false], 403);
        }
        
        $campaign = AffiliateCampaign::where('id', $id)
            ->where('affiliate_id', $affiliate->id)
            ->first();
        
        if (!$campaign) {
            return response()->json(['success' => false], 404);
        }
        
        return response()->json([
            'success' => true,
            'stats' => [
                'clicks' => $campaign->clicks,
                'referrals' => $campaign->referrals,
                'conversions' => $campaign->conversions,
                'earnings' => number_format($campaign->earnings, 2),
                'conversion_rate' => $campaign->conversion_rate,
                'last_click_at' => $campaign->last_click_at?->diffForHumans(),
            ],
        ]);
    }
}
