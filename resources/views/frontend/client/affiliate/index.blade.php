@extends('frontend.client.layout')

@section('title', __('affiliate.dashboard'))

@section('content')
<div class="space-y-6 overflow-x-hidden">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('affiliate.dashboard') }}</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('affiliate.dashboard_description') }}</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium
                @if($affiliate->status === 'active') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                @elseif($affiliate->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 @endif">
                <span class="w-2 h-2 rounded-full mr-2
                    @if($affiliate->status === 'active') bg-green-500 animate-pulse
                    @elseif($affiliate->status === 'pending') bg-yellow-500
                    @else bg-red-500 @endif"></span>
                {{ ucfirst($affiliate->status) }}
            </span>
        </div>
    </div>

    <!-- Referral Link Widget -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-6 sm:px-8">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 bg-blue-50 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-500" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M19.902 4.098a3.75 3.75 0 00-5.304 0l-4.5 4.5a3.75 3.75 0 001.035 6.037.75.75 0 01-.646 1.353 5.25 5.25 0 01-1.449-8.45l4.5-4.5a5.25 5.25 0 117.424 7.424l-1.757 1.757a.75.75 0 11-1.06-1.06l1.757-1.757a3.75 3.75 0 000-5.304zm-7.389 4.267a.75.75 0 011-.353 5.25 5.25 0 011.449 8.45l-4.5 4.5a5.25 5.25 0 11-7.424-7.424l1.757-1.757a.75.75 0 111.06 1.06l-1.757 1.757a3.75 3.75 0 105.304 5.304l4.5-4.5a3.75 3.75 0 00-1.035-6.037.75.75 0 01-.354-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('affiliate.your_referral_link') }}</h2>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">{{ __('affiliate.share_to_earn') }}</p>
                        </div>
                    </div>
                </div>
                <div class="hidden sm:block text-right">
                    <div class="text-gray-500 dark:text-gray-400 text-sm">{{ __('affiliate.commission_rate') }}</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $affiliate->commission_rate }}%</div>
                </div>
            </div>
            
            <div class="mt-5">
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1 bg-gray-50 dark:bg-gray-900 rounded-lg px-4 py-3 border border-gray-200 dark:border-gray-600 overflow-hidden">
                        <input type="text" id="referralLink" value="{{ $affiliate->referral_link }}" 
                            class="w-full bg-transparent text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none text-sm font-mono truncate"
                            readonly>
                    </div>
                    <button onclick="copyReferralLink()" 
                        class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        <svg id="copyIcon" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7.5 3.375c0-1.036.84-1.875 1.875-1.875h.375a3.75 3.75 0 013.75 3.75v1.875C13.5 8.161 14.34 9 15.375 9h1.875A3.75 3.75 0 0121 12.75v3.375C21 17.16 20.16 18 19.125 18h-9.75A1.875 1.875 0 017.5 16.125V3.375z" />
                            <path d="M15 5.25a5.23 5.23 0 00-1.279-3.434 9.768 9.768 0 016.963 6.963A5.23 5.23 0 0017.25 7.5h-1.875A.375.375 0 0115 7.125V5.25zM4.875 6H6v10.125A3.375 3.375 0 009.375 19.5H16.5v1.125c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 013 20.625V7.875C3 6.839 3.84 6 4.875 6z" />
                        </svg>
                        <svg id="checkIcon" class="w-4 h-4 hidden" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z" clip-rule="evenodd" />
                        </svg>
                        <span id="copyText">{{ __('affiliate.copy_link') }}</span>
                    </button>
                    <a href="{{ route('client.affiliate.campaigns') }}" 
                        class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-medium rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.25 6.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM15.75 9.75a3 3 0 116 0 3 3 0 01-6 0zM2.25 9.75a3 3 0 116 0 3 3 0 01-6 0zM6.31 15.117A6.745 6.745 0 0112 12a6.745 6.745 0 016.709 7.498.75.75 0 01-.372.568A12.696 12.696 0 0112 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 01-.372-.568 6.787 6.787 0 011.019-4.38z" clip-rule="evenodd" />
                            <path d="M5.082 14.254a8.287 8.287 0 00-1.308 5.135 9.687 9.687 0 01-1.764-.44l-.115-.04a.563.563 0 01-.373-.487l-.01-.121a3.75 3.75 0 013.57-4.047zM20.226 19.389a8.287 8.287 0 00-1.308-5.135 3.75 3.75 0 013.57 4.047l-.01.121a.563.563 0 01-.373.486l-.115.04c-.567.2-1.156.349-1.764.441z" />
                        </svg>
                        {{ __('affiliate.campaigns') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tier & Rewards Combined Section -->
    @if(isset($tierInfo) && $tierInfo['current_tier'])
    @php
        $tierColors = [
            'amber' => ['bg' => 'bg-amber-100 dark:bg-amber-900/30', 'ring' => 'ring-amber-500', 'text' => 'text-amber-600', 'icon' => 'text-amber-500'],
            'gray' => ['bg' => 'bg-gray-100 dark:bg-gray-700', 'ring' => 'ring-gray-400', 'text' => 'text-gray-600', 'icon' => 'text-gray-500'],
            'indigo' => ['bg' => 'bg-indigo-100 dark:bg-indigo-900/30', 'ring' => 'ring-indigo-500', 'text' => 'text-indigo-600', 'icon' => 'text-indigo-500'],
            'yellow' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900/30', 'ring' => 'ring-yellow-500', 'text' => 'text-yellow-600', 'icon' => 'text-yellow-500'],
            'blue' => ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'ring' => 'ring-blue-500', 'text' => 'text-blue-600', 'icon' => 'text-blue-500'],
        ];
        $currentColor = $tierColors[$tierInfo['current_tier']->color] ?? $tierColors['gray'];
    @endphp
    
    <!-- Tier & Progress Section -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-4 sm:p-6">
            <!-- Current Tier Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div class="flex items-center gap-3 sm:gap-4">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 {{ $currentColor['bg'] }} ring-2 {{ $currentColor['ring'] }} rounded-2xl flex items-center justify-center flex-shrink-0">
                        <span class="text-2xl sm:text-3xl">{{ $tierInfo['current_tier']->icon ?? '⭐' }}</span>
                    </div>
                    <div>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">{{ __('affiliate.your_tier') }}</p>
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white">{{ $tierInfo['current_tier']->name }}</h3>
                    </div>
                </div>
                <div class="flex items-center gap-4 sm:gap-6">
                    <div class="text-center sm:text-right">
                        <p class="text-2xl sm:text-3xl font-bold text-green-600">{{ $tierInfo['current_tier']->commission_rate }}%</p>
                        <p class="text-[10px] sm:text-xs text-gray-500">{{ __('affiliate.commission_rate') }}</p>
                    </div>
                </div>
            </div>

            <!-- Tier Benefits - Horizontal on mobile -->
            @if($tierInfo['current_tier']->benefits)
            @php
                $benefitTranslations = [
                    // Bronze
                    'Basic commission rate' => __('affiliate.benefit_basic_commission'),
                    'Access to affiliate dashboard' => __('affiliate.benefit_dashboard_access'),
                    'Standard support' => __('affiliate.benefit_standard_support'),
                    // Silver
                    '15% commission rate' => __('affiliate.benefit_15_commission'),
                    'Priority support' => __('affiliate.benefit_priority_support'),
                    'Early access to promotions' => __('affiliate.benefit_early_promotions'),
                    'Custom referral links' => __('affiliate.benefit_custom_links'),
                    // Gold
                    '20% commission rate' => __('affiliate.benefit_20_commission'),
                    'Dedicated account manager' => __('affiliate.benefit_dedicated_manager'),
                    'Exclusive promotions' => __('affiliate.benefit_exclusive_promotions'),
                    'Higher payout limits' => __('affiliate.benefit_higher_payout'),
                    'Custom marketing materials' => __('affiliate.benefit_custom_materials'),
                    // Platinum
                    '25% commission rate' => __('affiliate.benefit_25_commission'),
                    'VIP support 24/7' => __('affiliate.benefit_vip_support_24'),
                    'Exclusive deals & bonuses' => __('affiliate.benefit_exclusive_deals'),
                    'Unlimited payout' => __('affiliate.benefit_unlimited_payout'),
                    'Co-marketing opportunities' => __('affiliate.benefit_co_marketing'),
                    'Revenue sharing on renewals' => __('affiliate.benefit_revenue_sharing'),
                    // Generic
                    'Higher commission rate' => __('affiliate.benefit_higher_commission'),
                    'Custom commission rates' => __('affiliate.benefit_custom_rates'),
                    'VIP support' => __('affiliate.benefit_vip_support'),
                    'Unlimited payouts' => __('affiliate.benefit_unlimited_payouts'),
                ];
            @endphp
            <div class="flex flex-wrap gap-2 mb-6 pb-6 border-b border-gray-100 dark:border-gray-700">
                @foreach(array_slice($tierInfo['current_tier']->benefits, 0, 4) as $benefit)
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 text-xs sm:text-sm rounded-full">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    {{ $benefitTranslations[$benefit] ?? $benefit }}
                </span>
                @endforeach
            </div>
            @endif

            <!-- Tier Roadmap - Clean Design -->
            <div class="mb-6">
                <h4 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-4">{{ __('affiliate.tier_journey') }}</h4>
                
                <!-- All Screens: Simple Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    @foreach($allTiers as $index => $tier)
                    @php
                        $isCompleted = $affiliate->tier_id && $tier->id < $affiliate->tier_id;
                        $isCurrent = $affiliate->tier_id == $tier->id;
                        $isLocked = !$affiliate->tier_id || $tier->id > $affiliate->tier_id;
                    @endphp
                    <div class="relative p-4 rounded-xl border-2 transition-all cursor-pointer hover:shadow-md
                        {{ $isCurrent 
                            ? 'bg-green-50 dark:bg-green-900/20 border-green-500' 
                            : ($isCompleted 
                                ? 'bg-white dark:bg-gray-800 border-green-300 dark:border-green-700' 
                                : 'bg-gray-50 dark:bg-gray-800/50 border-gray-200 dark:border-gray-700 opacity-60') }}">
                        
                        @if($isCurrent)
                        <div class="absolute -top-2 -right-2 w-5 h-5 bg-green-500 rounded-full flex items-center justify-center shadow-sm">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        @elseif($isCompleted)
                        <div class="absolute -top-2 -right-2 w-5 h-5 bg-green-500 rounded-full flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        @elseif($isLocked)
                        <div class="absolute -top-2 -right-2 w-5 h-5 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center">
                            <svg class="w-3 h-3 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        @endif
                        
                        <div class="text-center">
                            <span class="text-3xl mb-2 block {{ $isLocked ? 'grayscale opacity-50' : '' }}">{{ $tier->icon ?? '⭐' }}</span>
                            <h5 class="font-bold text-sm {{ $isCurrent ? 'text-green-700 dark:text-green-400' : ($isCompleted ? 'text-green-600' : 'text-gray-700 dark:text-gray-300') }}">
                                {{ $tier->name }}
                            </h5>
                            <p class="text-lg font-bold {{ $isCurrent ? 'text-green-600' : ($isLocked ? 'text-gray-400' : 'text-gray-600 dark:text-gray-400') }}">
                                {{ $tier->commission_rate }}%
                            </p>
                            @if($isCurrent)
                            <span class="inline-block mt-2 px-2 py-1 bg-green-500 text-white text-[10px] font-bold rounded-full">
                                {{ __('affiliate.current') }}
                            </span>
                            @elseif($isLocked && $tier->min_referrals > 0)
                            <p class="text-[10px] text-gray-400 mt-1">{{ $tier->min_referrals }} referrals</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Progress to Next Tier -->
            @if(!$tierInfo['is_max_tier'] && $tierInfo['next_tier'] && $tierInfo['progress'])
            <div class="bg-gradient-to-br from-gray-50 to-gray-100/50 dark:from-gray-900/50 dark:to-gray-800/30 rounded-xl p-4 sm:p-5">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-4">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-gray-900 dark:text-white">{{ __('affiliate.progress_to_next') }} {{ $tierInfo['next_tier']->name }}</h4>
                            <p class="text-[10px] text-gray-500">{{ __('affiliate.complete_to_unlock') ?? 'Complete requirements to unlock' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-full sm:w-32 h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-blue-500 to-blue-600 rounded-full transition-all duration-500" style="width: {{ $tierInfo['progress']['overall'] }}%"></div>
                        </div>
                        <span class="text-sm font-bold text-blue-600 whitespace-nowrap">{{ round($tierInfo['progress']['overall']) }}%</span>
                    </div>
                </div>
                
                <!-- Progress Stats Grid -->
                <div class="grid grid-cols-3 gap-2 sm:gap-4">
                    <!-- Referrals -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-3 sm:p-4 text-center border border-gray-100 dark:border-gray-700">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 mx-auto mb-2 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <p class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">
                            {{ $affiliate->total_referrals }}<span class="text-xs sm:text-sm text-gray-400">/{{ $tierInfo['next_tier']->min_referrals }}</span>
                        </p>
                        <p class="text-[10px] sm:text-xs text-gray-500">{{ __('affiliate.referrals') }}</p>
                        <div class="mt-2 w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1">
                            <div class="bg-blue-500 h-1 rounded-full transition-all" style="width: {{ min($tierInfo['progress']['referrals'], 100) }}%"></div>
                        </div>
                    </div>
                    
                    <!-- Conversions -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-3 sm:p-4 text-center border border-gray-100 dark:border-gray-700">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 mx-auto mb-2 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">
                            {{ $affiliate->active_referrals }}<span class="text-xs sm:text-sm text-gray-400">/{{ $tierInfo['next_tier']->min_conversions }}</span>
                        </p>
                        <p class="text-[10px] sm:text-xs text-gray-500">{{ __('affiliate.conversions') }}</p>
                        <div class="mt-2 w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1">
                            <div class="bg-green-500 h-1 rounded-full transition-all" style="width: {{ min($tierInfo['progress']['conversions'], 100) }}%"></div>
                        </div>
                    </div>
                    
                    <!-- Earnings -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-3 sm:p-4 text-center border border-gray-100 dark:border-gray-700">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 mx-auto mb-2 rounded-full bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">
                            ${{ number_format($affiliate->total_earnings, 0) }}<span class="text-xs sm:text-sm text-gray-400">/${{ number_format($tierInfo['next_tier']->min_earnings, 0) }}</span>
                        </p>
                        <p class="text-[10px] sm:text-xs text-gray-500">{{ __('affiliate.earnings') }}</p>
                        <div class="mt-2 w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1">
                            <div class="bg-yellow-500 h-1 rounded-full transition-all" style="width: {{ min($tierInfo['progress']['earnings'], 100) }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
            @elseif($tierInfo['is_max_tier'])
            <!-- Ultra Minimal Max Tier Card -->
            <div class="relative bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- Top Accent -->
                <div class="h-1 bg-gradient-to-r from-amber-500 to-yellow-500"></div>
                
                <div class="p-5 flex items-center gap-4">
                    <!-- Star Badge Icon -->
                    <div class="flex-shrink-0 w-12 h-12 bg-amber-50 dark:bg-amber-900/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    
                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium text-amber-500 uppercase tracking-wide">{{ __('affiliate.elite_status') }}</p>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white mt-0.5">{{ __('affiliate.max_tier_reached') }}</h3>
                    </div>
                    
                    <!-- Commission Rate -->
                    <div class="flex-shrink-0 text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}">
                        <span class="text-2xl font-bold text-amber-500">{{ number_format($affiliate->commission_rate, 0) }}%</span>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('affiliate.commission') }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Milestone Rewards Section -->
    @if(isset($rewards) && count($rewards) > 0)
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <!-- Minimal Header -->
        <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-amber-50 dark:bg-amber-900/20 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-gray-900 dark:text-white">{{ __('affiliate.milestone_rewards') }}</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('affiliate.milestone_rewards_description') }}</p>
                </div>
            </div>
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">
                <span class="text-green-500 font-bold">{{ collect($rewards)->where('is_earned', true)->count() }}</span>/{{ count($rewards) }}
            </span>
        </div>
        
        <!-- Clean Grid -->
        <div class="p-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                @foreach($rewards as $rewardData)
                @php $reward = $rewardData['reward']; $isEarned = $rewardData['is_earned']; $progress = $rewardData['progress']; @endphp
                <div class="relative p-4 rounded-xl border transition-all
                    @if($isEarned) bg-green-50 dark:bg-green-900/10 border-green-200 dark:border-green-800
                    @else bg-gray-50 dark:bg-gray-900/30 border-gray-100 dark:border-gray-700 hover:border-gray-200 dark:hover:border-gray-600 @endif">
                    
                    <div class="flex items-start gap-3">
                        <!-- Simple Icon -->
                        <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center
                            @if($isEarned) bg-green-100 dark:bg-green-900/30
                            @elseif($reward->type === 'referrals') bg-blue-50 dark:bg-blue-900/20
                            @elseif($reward->type === 'conversions') bg-purple-50 dark:bg-purple-900/20
                            @else bg-amber-50 dark:bg-amber-900/20 @endif">
                            @if($isEarned)
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            @elseif($reward->type === 'referrals')
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            @elseif($reward->type === 'conversions')
                            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            @else
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            @endif
                        </div>
                        
                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $reward->translated_name }}</h4>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-xs font-bold {{ $isEarned ? 'text-green-500' : 'text-amber-500' }}">${{ number_format($reward->reward_value, 0) }}</span>
                                <span class="text-xs text-gray-400">•</span>
                                <span class="text-xs text-gray-500">{{ round($progress['percentage']) }}%</span>
                            </div>
                            <!-- Simple Progress Bar -->
                            <div class="mt-2 h-1 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                <div class="h-full rounded-full transition-all {{ $isEarned ? 'bg-green-500' : 'bg-amber-500' }}" 
                                     style="width: {{ $progress['percentage'] }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Marketing Materials Section -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-pink-50 dark:bg-pink-900/20 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-pink-600 dark:text-pink-500" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M20.599 1.5c-.376 0-.743.111-1.055.32l-5.08 3.385a18.747 18.747 0 00-3.471 2.987 10.04 10.04 0 014.815 4.815 18.748 18.748 0 002.987-3.472l3.386-5.079A1.902 1.902 0 0020.599 1.5zm-8.3 14.025a18.76 18.76 0 001.896-1.207 8.026 8.026 0 00-4.513-4.513A18.75 18.75 0 008.475 11.7l-.278.5a5.26 5.26 0 013.601 3.602l.502-.278zM6.75 13.5A3.75 3.75 0 003 17.25a1.5 1.5 0 01-1.601 1.497.75.75 0 00-.7 1.123 5.25 5.25 0 009.8-2.62 3.75 3.75 0 00-3.75-3.75z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-medium text-gray-900 dark:text-white">{{ __('affiliate.marketing_materials') }}</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('affiliate.marketing_materials_desc') }}</p>
                </div>
            </div>
        </div>
        
        <div class="p-5">
            <!-- Tabs -->
            <div x-data="{ activeTab: 'banners' }" class="space-y-4">
                <div class="flex flex-wrap gap-2 border-b border-gray-200 dark:border-gray-700">
                    <button @click="activeTab = 'banners'" 
                        :class="activeTab === 'banners' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400'"
                        class="flex items-center gap-2 px-4 py-2.5 border-b-2 font-medium text-sm transition-colors">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                        </svg>
                        {{ __('affiliate.banners') }}
                    </button>
                    <button @click="activeTab = 'texts'" 
                        :class="activeTab === 'texts' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400'"
                        class="flex items-center gap-2 px-4 py-2.5 border-b-2 font-medium text-sm transition-colors">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.125 3C3.089 3 2.25 3.84 2.25 4.875V18a3 3 0 003 3h15a3 3 0 01-3-3V4.875C17.25 3.839 16.41 3 15.375 3H4.125zM12 9.75a.75.75 0 000 1.5h1.5a.75.75 0 000-1.5H12zm-.75-2.25a.75.75 0 01.75-.75h1.5a.75.75 0 010 1.5H12a.75.75 0 01-.75-.75zM6 12.75a.75.75 0 000 1.5h7.5a.75.75 0 000-1.5H6zm-.75 3.75a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5H6a.75.75 0 01-.75-.75zM6 6.75a.75.75 0 00-.75.75v3c0 .414.336.75.75.75h3a.75.75 0 00.75-.75v-3A.75.75 0 009 6.75H6z" clip-rule="evenodd" />
                            <path d="M18.75 6.75h1.875c.621 0 1.125.504 1.125 1.125V18a1.5 1.5 0 01-3 0V6.75z" />
                        </svg>
                        {{ __('affiliate.marketing_texts') }}
                    </button>
                </div>

                <!-- Banners Tab -->
                <div x-show="activeTab === 'banners'" x-cloak>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Banner 728x90 - Leaderboard -->
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:border-blue-300 dark:hover:border-blue-600 transition-colors md:col-span-2 lg:col-span-3">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">728 × 90</span>
                                <span class="text-xs text-blue-600 dark:text-blue-400">{{ __('affiliate.leaderboard') }}</span>
                            </div>
                            <!-- Professional Banner Design - Responsive -->
                            <div class="relative rounded-lg overflow-hidden mb-3 shadow-lg w-full" style="background: linear-gradient(135deg, #1d71b8 0%, #0f4c81 50%, #1d71b8 100%); aspect-ratio: 728/90;">
                                <!-- Decorative Elements -->
                                <div class="absolute inset-0 opacity-10">
                                    <div class="absolute -top-10 -right-10 w-1/4 aspect-square rounded-full" style="background: radial-gradient(circle, white 0%, transparent 70%);"></div>
                                    <div class="absolute -bottom-10 -left-10 w-1/5 aspect-square rounded-full" style="background: radial-gradient(circle, white 0%, transparent 70%);"></div>
                                </div>
                                <!-- Grid Pattern -->
                                <div class="absolute inset-0 opacity-5" style="background-image: linear-gradient(white 1px, transparent 1px), linear-gradient(90deg, white 1px, transparent 1px); background-size: 20px 20px;"></div>
                                <!-- Content -->
                                <div class="relative h-full flex items-center justify-between px-3 sm:px-6">
                                    <div class="flex items-center gap-2 sm:gap-4">
                                        <img src="{{ asset('logo/pro Gineous_white logo_white icon.svg') }}" alt="Pro Gineous" class="h-6 sm:h-8 md:h-10">
                                        <div class="text-white">
                                            <div class="text-xs sm:text-sm md:text-lg font-bold tracking-wide">{{ __('affiliate.banner_tagline') }}</div>
                                            <div class="text-[8px] sm:text-[10px] md:text-xs opacity-80 hidden sm:block">{{ __('affiliate.banner_subtitle') }}</div>
                                        </div>
                                    </div>
                                    <div class="bg-white text-[#1d71b8] px-2 sm:px-4 md:px-5 py-1 sm:py-2 rounded-lg font-bold text-[10px] sm:text-xs md:text-sm shadow-lg whitespace-nowrap">
                                        {{ __('affiliate.banner_cta') }} →
                                    </div>
                                </div>
                            </div>
                            <button onclick="copyBannerCode('728x90')" class="w-full text-center text-xs text-blue-600 dark:text-blue-400 hover:underline">
                                {{ __('affiliate.copy_html_code') }}
                            </button>
                        </div>

                        <!-- Banner 300x250 - Medium Rectangle -->
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:border-blue-300 dark:hover:border-blue-600 transition-colors">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">300 × 250</span>
                                <span class="text-xs text-blue-600 dark:text-blue-400">{{ __('affiliate.medium_rectangle') }}</span>
                            </div>
                            <div class="relative rounded-lg overflow-hidden mb-3 shadow-lg mx-auto w-full max-w-[300px]" style="background: linear-gradient(180deg, #1d71b8 0%, #0f4c81 100%); aspect-ratio: 300/250;">
                                <!-- Decorative Circle -->
                                <div class="absolute -top-20 -right-20 w-64 h-64 rounded-full opacity-10" style="background: radial-gradient(circle, white 0%, transparent 60%);"></div>
                                <div class="absolute -bottom-10 -left-10 w-40 h-40 rounded-full opacity-10" style="background: radial-gradient(circle, white 0%, transparent 60%);"></div>
                                <!-- Diamond Pattern -->
                                <div class="absolute bottom-0 left-0 right-0 h-24 opacity-5" style="background: repeating-linear-gradient(45deg, white 0px, white 1px, transparent 1px, transparent 10px);"></div>
                                <!-- Content -->
                                <div class="relative h-full flex flex-col items-center justify-center p-4 sm:p-6 text-center">
                                    <img src="{{ asset('logo/pro Gineous_white logo_white icon.svg') }}" alt="Pro Gineous" class="h-8 sm:h-10 md:h-12 mb-2 sm:mb-4">
                                    <div class="text-white">
                                        <div class="text-base sm:text-lg md:text-xl font-bold mb-1 sm:mb-2 leading-tight">{{ __('affiliate.banner_tagline') }}</div>
                                        <div class="text-[10px] sm:text-xs opacity-80 mb-2 sm:mb-4">{{ __('affiliate.banner_subtitle') }}</div>
                                    </div>
                                    <div class="bg-white text-[#1d71b8] px-4 sm:px-6 py-1.5 sm:py-2.5 rounded-lg font-bold text-xs sm:text-sm shadow-lg">
                                        {{ __('affiliate.banner_cta') }} →
                                    </div>
                                </div>
                            </div>
                            <button onclick="copyBannerCode('300x250')" class="w-full text-center text-xs text-blue-600 dark:text-blue-400 hover:underline">
                                {{ __('affiliate.copy_html_code') }}
                            </button>
                        </div>

                        <!-- Banner 160x600 - Wide Skyscraper -->
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:border-blue-300 dark:hover:border-blue-600 transition-colors">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">160 × 600</span>
                                <span class="text-xs text-blue-600 dark:text-blue-400">{{ __('affiliate.wide_skyscraper') }}</span>
                            </div>
                            <div class="relative rounded-lg overflow-hidden mb-3 shadow-lg mx-auto w-[60px] sm:w-[80px] h-[200px] sm:h-[300px]" style="background: linear-gradient(180deg, #1d71b8 0%, #0a3d66 100%);">
                                <!-- Decorative Elements -->
                                <div class="absolute -top-10 -right-10 w-32 h-32 rounded-full opacity-10" style="background: radial-gradient(circle, white 0%, transparent 60%);"></div>
                                <div class="absolute top-1/2 -left-10 w-24 h-24 rounded-full opacity-10" style="background: radial-gradient(circle, white 0%, transparent 60%);"></div>
                                <div class="absolute -bottom-10 -right-10 w-28 h-28 rounded-full opacity-10" style="background: radial-gradient(circle, white 0%, transparent 60%);"></div>
                                <!-- Vertical Lines -->
                                <div class="absolute inset-0 opacity-5" style="background: repeating-linear-gradient(180deg, transparent 0px, transparent 20px, white 20px, white 21px);"></div>
                                <!-- Content -->
                                <div class="relative h-full flex flex-col items-center justify-between py-4 sm:py-6 px-2 sm:px-3 text-center">
                                    <img src="{{ asset('logo/pro Gineous_white logo_white icon.svg') }}" alt="Pro Gineous" class="w-12 sm:w-16">
                                    <div class="text-white">
                                        <div class="text-[8px] sm:text-[10px] font-bold mb-1 leading-tight">{{ __('affiliate.banner_vertical') }}</div>
                                        <div class="text-[7px] sm:text-[8px] opacity-80">{{ __('affiliate.banner_subtitle') }}</div>
                                    </div>
                                    <div class="bg-white text-[#1d71b8] px-2 sm:px-3 py-1 sm:py-1.5 rounded font-bold text-[7px] sm:text-[8px] shadow-lg">
                                        {{ __('affiliate.banner_cta') }} →
                                    </div>
                                </div>
                            </div>
                            <button onclick="copyBannerCode('160x600')" class="w-full text-center text-xs text-blue-600 dark:text-blue-400 hover:underline">
                                {{ __('affiliate.copy_html_code') }}
                            </button>
                        </div>

                        <!-- Banner 250x250 - Square -->
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:border-blue-300 dark:hover:border-blue-600 transition-colors">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">250 × 250</span>
                                <span class="text-xs text-blue-600 dark:text-blue-400">{{ __('affiliate.square') }}</span>
                            </div>
                            <div class="relative rounded-lg overflow-hidden mb-3 shadow-lg mx-auto w-full max-w-[180px] sm:max-w-[200px] aspect-square" style="background: #ffffff; border: 3px solid #1d71b8;">
                                <!-- Blue Corner Accent -->
                                <div class="absolute top-0 left-0 w-14 sm:w-20 h-14 sm:h-20" style="background: linear-gradient(135deg, #1d71b8 50%, transparent 50%);"></div>
                                <div class="absolute bottom-0 right-0 w-12 sm:w-16 h-12 sm:h-16" style="background: linear-gradient(-45deg, #1d71b8 50%, transparent 50%);"></div>
                                <!-- Content -->
                                <div class="relative h-full flex flex-col items-center justify-center p-3 sm:p-4 text-center">
                                    <img src="{{ asset('logo/pro Gineous_white logo_blue icon.svg') }}" alt="Pro Gineous" class="h-8 sm:h-10 mb-2 sm:mb-3">
                                    <div class="text-[#1d71b8]">
                                        <div class="text-xs sm:text-sm font-bold mb-1 leading-tight">{{ __('affiliate.banner_tagline') }}</div>
                                        <div class="text-[9px] sm:text-[10px] opacity-70 mb-2 sm:mb-3">{{ __('affiliate.banner_subtitle') }}</div>
                                    </div>
                                    <div class="bg-[#1d71b8] text-white px-3 sm:px-4 py-1 sm:py-1.5 rounded-lg font-bold text-[10px] sm:text-xs shadow-lg">
                                        {{ __('affiliate.banner_cta') }} →
                                    </div>
                                </div>
                            </div>
                            <button onclick="copyBannerCode('250x250')" class="w-full text-center text-xs text-blue-600 dark:text-blue-400 hover:underline">
                                {{ __('affiliate.copy_html_code') }}
                            </button>
                        </div>

                        <!-- Banner 320x50 - Mobile Banner -->
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:border-blue-300 dark:hover:border-blue-600 transition-colors">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">320 × 50</span>
                                <span class="text-xs text-blue-600 dark:text-blue-400">{{ __('affiliate.mobile_banner') }}</span>
                            </div>
                            <div class="relative rounded-lg overflow-hidden mb-3 shadow-lg mx-auto w-full h-[40px] sm:h-[50px] max-w-[280px] sm:max-w-[320px]" style="background: linear-gradient(90deg, #1d71b8 0%, #0f4c81 100%);">
                                <!-- Decorative -->
                                <div class="absolute -right-5 -top-5 w-20 h-20 rounded-full opacity-10" style="background: radial-gradient(circle, white 0%, transparent 60%);"></div>
                                <!-- Content -->
                                <div class="relative h-full flex items-center justify-between px-3 sm:px-4">
                                    <div class="flex items-center gap-2 sm:gap-3">
                                        <img src="{{ asset('logo/pro Gineous_white logo_white icon.svg') }}" alt="Pro Gineous" class="h-5 sm:h-6">
                                        <span class="text-white text-[10px] sm:text-xs font-medium">{{ __('affiliate.banner_cta_short') }}</span>
                                    </div>
                                    <div class="bg-white text-[#1d71b8] px-2 sm:px-3 py-1 rounded font-bold text-[10px] sm:text-xs shadow">
                                        {{ __('affiliate.start_now') }}
                                    </div>
                                </div>
                            </div>
                            <button onclick="copyBannerCode('320x50')" class="w-full text-center text-xs text-blue-600 dark:text-blue-400 hover:underline">
                                {{ __('affiliate.copy_html_code') }}
                            </button>
                        </div>

                        <!-- Banner 468x60 - Full Banner -->
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:border-blue-300 dark:hover:border-blue-600 transition-colors md:col-span-2">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">468 × 60</span>
                                <span class="text-xs text-blue-600 dark:text-blue-400">{{ __('affiliate.full_banner') }}</span>
                            </div>
                            <div class="relative rounded-lg overflow-hidden mb-3 shadow-lg mx-auto w-full h-[50px] sm:h-[60px] max-w-full sm:max-w-[468px]" style="background: #ffffff; border: 2px solid #1d71b8;">
                                <!-- Blue Accent Bar -->
                                <div class="absolute left-0 top-0 bottom-0 w-1.5 sm:w-2" style="background: #1d71b8;"></div>
                                <!-- Decorative Dots -->
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 hidden sm:flex gap-1.5 opacity-20">
                                    <div class="w-2 h-2 rounded-full" style="background: #1d71b8;"></div>
                                    <div class="w-2 h-2 rounded-full" style="background: #1d71b8;"></div>
                                    <div class="w-2 h-2 rounded-full" style="background: #1d71b8;"></div>
                                </div>
                                <!-- Content -->
                                <div class="relative h-full flex items-center justify-between px-4 sm:px-6 rtl:pr-4 sm:rtl:pr-6 ltr:pl-4 sm:ltr:pl-6">
                                    <div class="flex items-center gap-2 sm:gap-4">
                                        <img src="{{ asset('logo/pro Gineous_white logo_blue icon.svg') }}" alt="Pro Gineous" class="h-6 sm:h-8">
                                        <div class="text-[#1d71b8]">
                                            <div class="text-xs sm:text-sm font-bold">{{ __('affiliate.banner_tagline') }}</div>
                                            <div class="text-[8px] sm:text-[10px] opacity-70">{{ __('affiliate.banner_subtitle') }}</div>
                                        </div>
                                    </div>
                                    <div class="bg-[#1d71b8] text-white px-3 sm:px-4 py-1 sm:py-1.5 rounded-lg font-bold text-[10px] sm:text-xs shadow-lg">
                                        {{ __('affiliate.banner_cta') }} →
                                    </div>
                                </div>
                            </div>
                            <button onclick="copyBannerCode('468x60')" class="w-full text-center text-xs text-blue-600 dark:text-blue-400 hover:underline">
                                {{ __('affiliate.copy_html_code') }}
                            </button>
                        </div>
                    </div>

                    <!-- Domain Banners Section -->
                    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M21.721 12.752a9.711 9.711 0 00-.945-5.003 12.754 12.754 0 01-4.339 2.708 18.991 18.991 0 01-.214 4.772 17.165 17.165 0 005.498-2.477zM14.634 15.55a17.324 17.324 0 00.332-4.647c-.952.227-1.945.347-2.966.347-1.021 0-2.014-.12-2.966-.347a17.515 17.515 0 00.332 4.647 17.385 17.385 0 005.268 0zM9.772 17.119a18.963 18.963 0 004.456 0A17.182 17.182 0 0112 21.724a17.18 17.18 0 01-2.228-4.605zM7.777 15.23a18.87 18.87 0 01-.214-4.774 12.753 12.753 0 01-4.34-2.708 9.711 9.711 0 00-.944 5.004 17.165 17.165 0 005.498 2.477zM21.356 14.752a9.765 9.765 0 01-7.478 6.817 18.64 18.64 0 001.988-4.718 18.627 18.627 0 005.49-2.098zM2.644 14.752c1.682.971 3.53 1.688 5.49 2.099a18.64 18.64 0 001.988 4.718 9.765 9.765 0 01-7.478-6.816zM13.878 2.43a9.755 9.755 0 016.116 3.986 11.267 11.267 0 01-3.746 2.504 18.63 18.63 0 00-2.37-6.49zM12 2.276a17.152 17.152 0 012.805 7.121c-.897.23-1.837.353-2.805.353-.968 0-1.908-.122-2.805-.353A17.151 17.151 0 0112 2.276zM10.122 2.43a18.629 18.629 0 00-2.37 6.49 11.266 11.266 0 01-3.746-2.504 9.754 9.754 0 016.116-3.985z" />
                            </svg>
                            {{ __('affiliate.domain_banners') }}
                        </h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <!-- Domain Banner 728x90 -->
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:border-blue-300 dark:hover:border-blue-600 transition-colors md:col-span-2 lg:col-span-3">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">728 × 90</span>
                                    <span class="text-xs text-blue-600 dark:text-blue-400">{{ __('affiliate.leaderboard') }}</span>
                                </div>
                                <div class="relative rounded-lg overflow-hidden mb-3 shadow-lg w-full mx-auto" style="background: linear-gradient(135deg, #1d71b8 0%, #0f4c81 50%, #1d71b8 100%); aspect-ratio: 728/90;">
                                    <div class="absolute inset-0 opacity-10">
                                        <div class="absolute -top-10 -right-10 w-1/4 aspect-square rounded-full" style="background: radial-gradient(circle, white 0%, transparent 70%);"></div>
                                        <div class="absolute -bottom-10 -left-10 w-1/5 aspect-square rounded-full" style="background: radial-gradient(circle, white 0%, transparent 70%);"></div>
                                    </div>
                                    <div class="absolute inset-0 opacity-5" style="background-image: linear-gradient(white 1px, transparent 1px), linear-gradient(90deg, white 1px, transparent 1px); background-size: 20px 20px;"></div>
                                    <div class="relative h-full flex items-center justify-between px-3 sm:px-6">
                                        <div class="flex items-center gap-2 sm:gap-4">
                                            <img src="{{ asset('logo/pro Gineous_white logo_white icon.svg') }}" alt="Pro Gineous" class="h-6 sm:h-8 md:h-10">
                                            <div class="text-white">
                                                <div class="text-xs sm:text-sm md:text-lg font-bold tracking-wide">{{ __('affiliate.domain_tagline') }}</div>
                                                <div class="text-[8px] sm:text-[10px] md:text-xs opacity-80 hidden sm:block">{{ __('affiliate.domain_extensions') }} | {{ __('affiliate.from_price') }} $9.99{{ __('affiliate.per_year') }}</div>
                                            </div>
                                        </div>
                                        <div class="bg-white text-[#1d71b8] px-2 sm:px-4 md:px-5 py-1 sm:py-2 rounded-lg font-bold text-[10px] sm:text-xs md:text-sm shadow-lg whitespace-nowrap">
                                            {{ __('affiliate.domain_cta') }} →
                                        </div>
                                    </div>
                                </div>
                                <button onclick="copyBannerCode('domain-728x90')" class="w-full text-center text-xs text-blue-600 dark:text-blue-400 hover:underline">
                                    {{ __('affiliate.copy_html_code') }}
                                </button>
                            </div>

                            <!-- Domain Banner 300x250 -->
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:border-blue-300 dark:hover:border-blue-600 transition-colors">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">300 × 250</span>
                                    <span class="text-xs text-blue-600 dark:text-blue-400">{{ __('affiliate.medium_rectangle') }}</span>
                                </div>
                                <div class="relative rounded-lg overflow-hidden mb-3 shadow-lg mx-auto w-full max-w-[300px]" style="background: linear-gradient(180deg, #1d71b8 0%, #0f4c81 100%); aspect-ratio: 300/250;">
                                    <div class="absolute -top-20 -right-20 w-64 h-64 rounded-full opacity-10" style="background: radial-gradient(circle, white 0%, transparent 60%);"></div>
                                    <div class="absolute -bottom-10 -left-10 w-40 h-40 rounded-full opacity-10" style="background: radial-gradient(circle, white 0%, transparent 60%);"></div>
                                    <div class="relative h-full flex flex-col items-center justify-center p-4 sm:p-6 text-center">
                                        <img src="{{ asset('logo/pro Gineous_white logo_white icon.svg') }}" alt="Pro Gineous" class="h-8 sm:h-10 mb-2 sm:mb-3">
                                        <div class="text-white">
                                            <div class="text-lg sm:text-xl font-bold mb-1 leading-tight">{{ __('affiliate.domain_tagline') }}</div>
                                            <div class="text-[10px] sm:text-xs opacity-80 mb-1 sm:mb-2">{{ __('affiliate.domain_subtitle') }}</div>
                                            <div class="text-xs sm:text-sm font-medium opacity-90 mb-2 sm:mb-3">{{ __('affiliate.domain_extensions') }}</div>
                                        </div>
                                        <div class="bg-white text-[#1d71b8] px-4 sm:px-6 py-1.5 sm:py-2 rounded-lg font-bold text-xs sm:text-sm shadow-lg">
                                            {{ __('affiliate.domain_cta') }} →
                                        </div>
                                    </div>
                                </div>
                                <button onclick="copyBannerCode('domain-300x250')" class="w-full text-center text-xs text-blue-600 dark:text-blue-400 hover:underline">
                                    {{ __('affiliate.copy_html_code') }}
                                </button>
                            </div>

                            <!-- Domain Banner 250x250 -->
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:border-blue-300 dark:hover:border-blue-600 transition-colors">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">250 × 250</span>
                                    <span class="text-xs text-blue-600 dark:text-blue-400">{{ __('affiliate.square') }}</span>
                                </div>
                                <div class="relative rounded-lg overflow-hidden mb-3 shadow-lg mx-auto w-full max-w-[180px] sm:max-w-[200px] aspect-square" style="background: #ffffff; border: 3px solid #1d71b8;">
                                    <div class="absolute top-0 left-0 w-14 sm:w-20 h-14 sm:h-20" style="background: linear-gradient(135deg, #1d71b8 50%, transparent 50%);"></div>
                                    <div class="absolute bottom-0 right-0 w-12 sm:w-16 h-12 sm:h-16" style="background: linear-gradient(-45deg, #1d71b8 50%, transparent 50%);"></div>
                                    <div class="relative h-full flex flex-col items-center justify-center p-3 sm:p-4 text-center">
                                        <img src="{{ asset('logo/pro Gineous_white logo_blue icon.svg') }}" alt="Pro Gineous" class="h-6 sm:h-8 mb-1.5 sm:mb-2">
                                        <div class="text-[#1d71b8]">
                                            <div class="text-xs sm:text-sm font-bold mb-1 leading-tight">{{ __('affiliate.domain_tagline') }}</div>
                                            <div class="text-[9px] sm:text-[10px] opacity-70 mb-1.5 sm:mb-2">{{ __('affiliate.domain_extensions') }}</div>
                                        </div>
                                        <div class="bg-[#1d71b8] text-white px-3 sm:px-4 py-1 sm:py-1.5 rounded-lg font-bold text-[10px] sm:text-xs shadow-lg">
                                            {{ __('affiliate.domain_cta') }} →
                                        </div>
                                    </div>
                                </div>
                                <button onclick="copyBannerCode('domain-250x250')" class="w-full text-center text-xs text-blue-600 dark:text-blue-400 hover:underline">
                                    {{ __('affiliate.copy_html_code') }}
                                </button>
                            </div>

                            <!-- Domain Banner 320x50 -->
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:border-blue-300 dark:hover:border-blue-600 transition-colors">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">320 × 50</span>
                                    <span class="text-xs text-blue-600 dark:text-blue-400">{{ __('affiliate.mobile_banner') }}</span>
                                </div>
                                <div class="relative rounded-lg overflow-hidden mb-3 shadow-lg mx-auto w-full h-[40px] sm:h-[50px] max-w-[280px] sm:max-w-[320px]" style="background: linear-gradient(90deg, #1d71b8 0%, #0f4c81 100%);">
                                    <div class="absolute -right-5 -top-5 w-20 h-20 rounded-full opacity-10" style="background: radial-gradient(circle, white 0%, transparent 60%);"></div>
                                    <div class="relative h-full flex items-center justify-between px-3 sm:px-4">
                                        <div class="flex items-center gap-2 sm:gap-3">
                                            <img src="{{ asset('logo/pro Gineous_white logo_white icon.svg') }}" alt="Pro Gineous" class="h-5 sm:h-6">
                                            <span class="text-white text-[10px] sm:text-xs font-medium">{{ __('affiliate.domain_cta_short') }}</span>
                                        </div>
                                        <div class="bg-white text-[#1d71b8] px-2 sm:px-3 py-1 rounded font-bold text-[10px] sm:text-xs shadow">
                                            {{ __('affiliate.domain_cta') }}
                                        </div>
                                    </div>
                                </div>
                                <button onclick="copyBannerCode('domain-320x50')" class="w-full text-center text-xs text-blue-600 dark:text-blue-400 hover:underline">
                                    {{ __('affiliate.copy_html_code') }}
                                </button>
                            </div>

                            <!-- Domain Banner 468x60 -->
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:border-blue-300 dark:hover:border-blue-600 transition-colors md:col-span-2">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">468 × 60</span>
                                    <span class="text-xs text-blue-600 dark:text-blue-400">{{ __('affiliate.full_banner') }}</span>
                                </div>
                                <div class="relative rounded-lg overflow-hidden mb-3 shadow-lg mx-auto w-full h-[50px] sm:h-[60px] max-w-full sm:max-w-[468px]" style="background: #ffffff; border: 2px solid #1d71b8;">
                                    <div class="absolute left-0 top-0 bottom-0 w-1.5 sm:w-2" style="background: #1d71b8;"></div>
                                    <div class="absolute right-4 top-1/2 -translate-y-1/2 hidden sm:flex gap-1.5 opacity-20">
                                        <div class="w-2 h-2 rounded-full" style="background: #1d71b8;"></div>
                                        <div class="w-2 h-2 rounded-full" style="background: #1d71b8;"></div>
                                        <div class="w-2 h-2 rounded-full" style="background: #1d71b8;"></div>
                                    </div>
                                    <div class="relative h-full flex items-center justify-between px-4 sm:px-6 rtl:pr-4 sm:rtl:pr-6 ltr:pl-4 sm:ltr:pl-6">
                                        <div class="flex items-center gap-2 sm:gap-4">
                                            <img src="{{ asset('logo/pro Gineous_white logo_blue icon.svg') }}" alt="Pro Gineous" class="h-6 sm:h-8">
                                            <div class="text-[#1d71b8]">
                                                <div class="text-xs sm:text-sm font-bold">{{ __('affiliate.domain_tagline') }}</div>
                                                <div class="text-[8px] sm:text-[10px] opacity-70">{{ __('affiliate.domain_extensions') }} | {{ __('affiliate.from_price') }} $9.99{{ __('affiliate.per_year') }}</div>
                                            </div>
                                        </div>
                                        <div class="bg-[#1d71b8] text-white px-3 sm:px-4 py-1 sm:py-1.5 rounded-lg font-bold text-[10px] sm:text-xs shadow-lg">
                                            {{ __('affiliate.domain_cta') }} →
                                        </div>
                                    </div>
                                </div>
                                <button onclick="copyBannerCode('domain-468x60')" class="w-full text-center text-xs text-blue-600 dark:text-blue-400 hover:underline">
                                    {{ __('affiliate.copy_html_code') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Marketing Texts Tab -->
                <div x-show="activeTab === 'texts'" x-cloak>
                    <div class="space-y-4">
                        <!-- Short Text -->
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ __('affiliate.short_text') }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('affiliate.for_social_media') }}</span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-300 bg-gray-50 dark:bg-gray-900 rounded-lg p-3 mb-3 whitespace-pre-line break-all" id="shortText">{{ __('affiliate.promo_text_short', ['app' => config('app.name'), 'link' => $affiliate->referral_link]) }}</p>
                            <button onclick="copyText('shortText')" class="inline-flex items-center gap-1.5 text-xs text-blue-600 dark:text-blue-400 hover:underline">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M7.5 3.375c0-1.036.84-1.875 1.875-1.875h.375a3.75 3.75 0 013.75 3.75v1.875C13.5 8.161 14.34 9 15.375 9h1.875A3.75 3.75 0 0121 12.75v3.375C21 17.16 20.16 18 19.125 18h-9.75A1.875 1.875 0 017.5 16.125V3.375z" />
                                    <path d="M15 5.25a5.23 5.23 0 00-1.279-3.434 9.768 9.768 0 016.963 6.963A5.23 5.23 0 0017.25 7.5h-1.875A.375.375 0 0115 7.125V5.25zM4.875 6H6v10.125A3.375 3.375 0 009.375 19.5H16.5v1.125c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 013 20.625V7.875C3 6.839 3.84 6 4.875 6z" />
                                </svg>
                                {{ __('affiliate.copy_text') }}
                            </button>
                        </div>

                        <!-- Medium Text -->
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ __('affiliate.medium_text') }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('affiliate.for_blog_email') }}</span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-300 bg-gray-50 dark:bg-gray-900 rounded-lg p-3 mb-3 whitespace-pre-line break-all" id="mediumText">{{ __('affiliate.promo_text_medium', ['app' => config('app.name'), 'link' => $affiliate->referral_link]) }}</p>
                            <button onclick="copyText('mediumText')" class="inline-flex items-center gap-1.5 text-xs text-blue-600 dark:text-blue-400 hover:underline">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M7.5 3.375c0-1.036.84-1.875 1.875-1.875h.375a3.75 3.75 0 013.75 3.75v1.875C13.5 8.161 14.34 9 15.375 9h1.875A3.75 3.75 0 0121 12.75v3.375C21 17.16 20.16 18 19.125 18h-9.75A1.875 1.875 0 017.5 16.125V3.375z" />
                                    <path d="M15 5.25a5.23 5.23 0 00-1.279-3.434 9.768 9.768 0 016.963 6.963A5.23 5.23 0 0017.25 7.5h-1.875A.375.375 0 0115 7.125V5.25zM4.875 6H6v10.125A3.375 3.375 0 009.375 19.5H16.5v1.125c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 013 20.625V7.875C3 6.839 3.84 6 4.875 6z" />
                                </svg>
                                {{ __('affiliate.copy_text') }}
                            </button>
                        </div>

                        <!-- Long Text -->
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ __('affiliate.long_text') }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('affiliate.for_detailed_review') }}</span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-300 bg-gray-50 dark:bg-gray-900 rounded-lg p-3 mb-3 whitespace-pre-line break-all" id="longText">{{ __('affiliate.promo_text_long', ['app' => config('app.name'), 'link' => $affiliate->referral_link]) }}</p>
                            <button onclick="copyText('longText')" class="inline-flex items-center gap-1.5 text-xs text-blue-600 dark:text-blue-400 hover:underline">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M7.5 3.375c0-1.036.84-1.875 1.875-1.875h.375a3.75 3.75 0 013.75 3.75v1.875C13.5 8.161 14.34 9 15.375 9h1.875A3.75 3.75 0 0121 12.75v3.375C21 17.16 20.16 18 19.125 18h-9.75A1.875 1.875 0 017.5 16.125V3.375z" />
                                    <path d="M15 5.25a5.23 5.23 0 00-1.279-3.434 9.768 9.768 0 016.963 6.963A5.23 5.23 0 0017.25 7.5h-1.875A.375.375 0 0115 7.125V5.25zM4.875 6H6v10.125A3.375 3.375 0 009.375 19.5H16.5v1.125c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 013 20.625V7.875C3 6.839 3.84 6 4.875 6z" />
                                </svg>
                                {{ __('affiliate.copy_text') }}
                            </button>
                        </div>

                        <!-- WhatsApp Text -->
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-500" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ __('affiliate.whatsapp_text') }}</span>
                                </div>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('affiliate.for_whatsapp') }}</span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-300 bg-gray-50 dark:bg-gray-900 rounded-lg p-3 mb-3 whitespace-pre-line break-all" id="whatsappText">{{ __('affiliate.promo_text_whatsapp', ['app' => config('app.name'), 'link' => $affiliate->referral_link]) }}</p>
                            <button onclick="copyText('whatsappText')" class="inline-flex items-center gap-1.5 text-xs text-blue-600 dark:text-blue-400 hover:underline">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M7.5 3.375c0-1.036.84-1.875 1.875-1.875h.375a3.75 3.75 0 013.75 3.75v1.875C13.5 8.161 14.34 9 15.375 9h1.875A3.75 3.75 0 0121 12.75v3.375C21 17.16 20.16 18 19.125 18h-9.75A1.875 1.875 0 017.5 16.125V3.375z" />
                                    <path d="M15 5.25a5.23 5.23 0 00-1.279-3.434 9.768 9.768 0 016.963 6.963A5.23 5.23 0 0017.25 7.5h-1.875A.375.375 0 0115 7.125V5.25zM4.875 6H6v10.125A3.375 3.375 0 009.375 19.5H16.5v1.125c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 013 20.625V7.875C3 6.839 3.84 6 4.875 6z" />
                                </svg>
                                {{ __('affiliate.copy_text') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Widgets Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4" x-data="affiliateStats()" x-init="startPolling()">
        <!-- Link Clicks Widget -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-purple-50 dark:bg-purple-900/20 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-500" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M15.75 2.25H21a.75.75 0 01.75.75v5.25a.75.75 0 01-1.5 0V4.81l-8.97 8.97a.75.75 0 01-1.06-1.06l8.97-8.97h-3.44a.75.75 0 010-1.5zm-10.5 4.5a1.5 1.5 0 00-1.5 1.5v10.5a1.5 1.5 0 001.5 1.5h10.5a1.5 1.5 0 001.5-1.5V10.5a.75.75 0 011.5 0v8.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V8.25a3 3 0 013-3h8.25a.75.75 0 010 1.5H5.25z" clip-rule="evenodd" />
                    </svg>
                </div>
                <!-- Live indicator -->
                <div class="flex items-center gap-1.5">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                    </span>
                    <span class="text-xs text-gray-400 dark:text-gray-500">Live</span>
                </div>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">{{ __('affiliate.link_clicks') }}</p>
                <h3 class="text-2xl font-semibold text-gray-900 dark:text-white" 
                    x-text="linkClicks.toLocaleString()"
                    :class="{ 'text-green-600 dark:text-green-400': justUpdated }"
                    x-transition>{{ number_format($affiliate->link_clicks ?? 0) }}</h3>
            </div>
        </div>

        <!-- Total Earnings Widget -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-blue-50 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-500" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 01-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004zM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 01-.921.42z" />
                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v.816a3.836 3.836 0 00-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 01-.921-.421l-.879-.66a.75.75 0 00-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 001.5 0v-.81a4.124 4.124 0 001.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 00-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 00.933-1.175l-.415-.33a3.836 3.836 0 00-1.719-.755V6z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">{{ __('affiliate.total_earnings') }}</p>
                <h3 class="text-2xl font-semibold text-gray-900 dark:text-white">${{ number_format($affiliate->total_earned, 2) }}</h3>
            </div>
        </div>

        <!-- Available Balance Widget -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-green-50 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-500" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M2.273 5.625A4.483 4.483 0 015.25 4.5h13.5c1.141 0 2.183.425 2.977 1.125A3 3 0 0018.75 3H5.25a3 3 0 00-2.977 2.625zM2.273 8.625A4.483 4.483 0 015.25 7.5h13.5c1.141 0 2.183.425 2.977 1.125A3 3 0 0018.75 6H5.25a3 3 0 00-2.977 2.625zM5.25 9a3 3 0 00-3 3v6a3 3 0 003 3h13.5a3 3 0 003-3v-6a3 3 0 00-3-3H15a.75.75 0 00-.75.75 2.25 2.25 0 01-4.5 0A.75.75 0 009 9H5.25z" />
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">{{ __('affiliate.available_balance') }}</p>
                <h3 class="text-2xl font-semibold text-gray-900 dark:text-white">${{ number_format($affiliate->balance, 2) }}</h3>
            </div>
        </div>

        <!-- Total Referrals Widget -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-blue-50 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-500" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.25 6.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM15.75 9.75a3 3 0 116 0 3 3 0 01-6 0zM2.25 9.75a3 3 0 116 0 3 3 0 01-6 0zM6.31 15.117A6.745 6.745 0 0112 12a6.745 6.745 0 016.709 7.498.75.75 0 01-.372.568A12.696 12.696 0 0112 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 01-.372-.568 6.787 6.787 0 011.019-4.38z" clip-rule="evenodd" />
                        <path d="M5.082 14.254a8.287 8.287 0 00-1.308 5.135 9.687 9.687 0 01-1.764-.44l-.115-.04a.563.563 0 01-.373-.487l-.01-.121a3.75 3.75 0 013.57-4.047zM20.226 19.389a8.287 8.287 0 00-1.308-5.135 3.75 3.75 0 013.57 4.047l-.01.121a.563.563 0 01-.373.486l-.115.04c-.567.2-1.156.349-1.764.441z" />
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">{{ __('affiliate.total_referrals') }}</p>
                <h3 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($stats['total_referrals']) }}</h3>
            </div>
        </div>

        <!-- Total Paid Widget -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-blue-50 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-500" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">{{ __('affiliate.total_paid') }}</p>
                <h3 class="text-2xl font-semibold text-gray-900 dark:text-white">${{ number_format($affiliate->total_paid, 2) }}</h3>
            </div>
        </div>
    </div>

    <!-- Advanced Statistics Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <!-- Conversion Funnel -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-9 h-9 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-500" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 6a3 3 0 013-3h12a3 3 0 013 3v12a3 3 0 01-3 3H6a3 3 0 01-3-3V6zm4.5 7.5a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0v-2.25a.75.75 0 01.75-.75zm3.75-1.5a.75.75 0 00-1.5 0v4.5a.75.75 0 001.5 0V12zm2.25-3a.75.75 0 01.75.75v6.75a.75.75 0 01-1.5 0V9.75A.75.75 0 0113.5 9zm3.75-1.5a.75.75 0 00-1.5 0v9a.75.75 0 001.5 0v-9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-medium text-gray-900 dark:text-white">{{ __('affiliate.conversion_funnel') }}</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('affiliate.clicks_to_referrals') }}</p>
                </div>
            </div>
            
            <!-- Conversion Rate Circle -->
            <div class="flex items-center justify-center mb-4">
                <div class="relative w-32 h-32">
                    <svg class="w-32 h-32 transform -rotate-90">
                        <circle cx="64" cy="64" r="56" stroke="currentColor" stroke-width="12" fill="none" class="text-gray-200 dark:text-gray-700"/>
                        <circle cx="64" cy="64" r="56" stroke="currentColor" stroke-width="12" fill="none" 
                            class="text-indigo-600 dark:text-indigo-500"
                            stroke-dasharray="{{ 351.86 }}"
                            stroke-dashoffset="{{ 351.86 - (351.86 * min($advancedStats['conversion_rate'], 100) / 100) }}"
                            stroke-linecap="round"/>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $advancedStats['conversion_rate'] }}%</span>
                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('affiliate.conversion') }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Funnel Steps -->
            <div class="space-y-2">
                <div class="flex items-center justify-between p-2 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                    <span class="text-sm text-purple-700 dark:text-purple-400">{{ __('affiliate.link_clicks') }}</span>
                    <span class="text-sm font-semibold text-purple-700 dark:text-purple-400">{{ number_format($advancedStats['total_clicks']) }}</span>
                </div>
                <div class="flex justify-center">
                    <svg class="w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M12 3.75a.75.75 0 01.75.75v13.19l5.47-5.47a.75.75 0 111.06 1.06l-6.75 6.75a.75.75 0 01-1.06 0l-6.75-6.75a.75.75 0 111.06-1.06l5.47 5.47V4.5a.75.75 0 01.75-.75z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="flex items-center justify-between p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                    <span class="text-sm text-blue-700 dark:text-blue-400">{{ __('affiliate.total_referrals') }}</span>
                    <span class="text-sm font-semibold text-blue-700 dark:text-blue-400">{{ number_format($stats['total_referrals']) }}</span>
                </div>
                <div class="flex justify-center">
                    <svg class="w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M12 3.75a.75.75 0 01.75.75v13.19l5.47-5.47a.75.75 0 111.06 1.06l-6.75 6.75a.75.75 0 01-1.06 0l-6.75-6.75a.75.75 0 111.06-1.06l5.47 5.47V4.5a.75.75 0 01.75-.75z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="flex items-center justify-between p-2 bg-green-50 dark:bg-green-900/20 rounded-lg">
                    <span class="text-sm text-green-700 dark:text-green-400">{{ __('affiliate.converted') }}</span>
                    <span class="text-sm font-semibold text-green-700 dark:text-green-400">{{ number_format($advancedStats['converted_referrals']) }}</span>
                </div>
            </div>
        </div>

        <!-- Earnings Chart -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-green-50 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-600 dark:text-green-500" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z" clip-rule="evenodd" />
                            <path fill-rule="evenodd" d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-medium text-gray-900 dark:text-white">{{ __('affiliate.earnings_overview') }}</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('affiliate.last_30_days') }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('affiliate.avg_per_referral') }}</p>
                    <p class="text-lg font-semibold text-green-600 dark:text-green-500">${{ number_format($advancedStats['avg_earnings_per_referral'], 2) }}</p>
                </div>
            </div>
            
            <!-- Simple Bar Chart -->
            <div class="relative h-48 flex items-end gap-0.5 bg-gray-50 dark:bg-gray-900/50 rounded-lg p-3 pt-6" x-data="{ 
                data: {{ json_encode(array_values($advancedStats['earnings_chart'])) }},
                labels: {{ json_encode(array_keys($advancedStats['earnings_chart'])) }},
                max: {{ max(array_values($advancedStats['earnings_chart'])) ?: 1 }},
                hasData: {{ array_sum(array_values($advancedStats['earnings_chart'])) > 0 ? 'true' : 'false' }}
            }">
                <!-- Grid lines -->
                <div class="absolute inset-x-3 top-6 bottom-3 flex flex-col justify-between pointer-events-none">
                    <div class="border-t border-dashed border-gray-200 dark:border-gray-700"></div>
                    <div class="border-t border-dashed border-gray-200 dark:border-gray-700"></div>
                    <div class="border-t border-dashed border-gray-200 dark:border-gray-700"></div>
                    <div class="border-t border-gray-300 dark:border-gray-600"></div>
                </div>
                
                <!-- No data message -->
                <div x-show="!hasData" class="absolute inset-0 flex items-center justify-center">
                    <p class="text-sm text-gray-400 dark:text-gray-500">{{ __('affiliate.no_earnings_data') }}</p>
                </div>
                
                <!-- Bars -->
                <template x-for="(value, index) in data" :key="index">
                    <div class="flex-1 flex flex-col items-center group relative h-full justify-end">
                        <div class="w-full bg-gradient-to-t from-green-500 to-green-400 dark:from-green-600 dark:to-green-500 rounded-t transition-all duration-300 hover:from-green-600 hover:to-green-500 cursor-pointer min-h-[2px]"
                             :style="'height: ' + (hasData && value > 0 ? Math.max((value / max) * 100, 8) : 2) + '%'">
                        </div>
                        <!-- Tooltip -->
                        <div class="absolute bottom-full mb-2 hidden group-hover:block z-10">
                            <div class="bg-gray-900 text-white text-xs rounded py-1 px-2 whitespace-nowrap shadow-lg">
                                <span class="font-semibold" x-text="'$' + parseFloat(value).toFixed(2)"></span>
                                <br>
                                <span class="text-gray-400" x-text="labels[index]"></span>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            <div class="flex justify-between mt-2 text-xs text-gray-400">
                <span>{{ now()->subDays(29)->format('M d') }}</span>
                <span>{{ now()->format('M d') }}</span>
            </div>
        </div>
    </div>

    <!-- Best Days & Referrals Chart Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <!-- Best Performing Days -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-9 h-9 bg-orange-50 dark:bg-orange-900/20 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-orange-600 dark:text-orange-500" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 017.5 3v1.5h9V3A.75.75 0 0118 3v1.5h.75a3 3 0 013 3v11.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V7.5a3 3 0 013-3H6V3a.75.75 0 01.75-.75zm13.5 9a1.5 1.5 0 00-1.5-1.5H5.25a1.5 1.5 0 00-1.5 1.5v7.5a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5v-7.5z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-medium text-gray-900 dark:text-white">{{ __('affiliate.best_days') }}</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('affiliate.by_referrals') }}</p>
                </div>
            </div>
            
            @if($advancedStats['best_days']->count() > 0)
                <div class="space-y-2">
                    @foreach($advancedStats['best_days']->take(5) as $index => $day)
                        @php
                            $dayKey = 'affiliate.day_' . strtolower($day->day_name);
                            $translatedDay = __($dayKey) !== $dayKey ? __($dayKey) : $day->day_name;
                        @endphp
                        <div class="flex items-center gap-3">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full flex items-center justify-center text-xs font-medium
                                @if($index === 0) bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400
                                @elseif($index === 1) bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300
                                @elseif($index === 2) bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400
                                @else bg-gray-50 text-gray-500 dark:bg-gray-700/50 dark:text-gray-400 @endif">
                                {{ $index + 1 }}
                            </span>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $translatedDay }}</span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ $day->total }} {{ __('affiliate.referrals') }}</span>
                                </div>
                                <div class="mt-1 w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                                    <div class="bg-orange-500 h-1.5 rounded-full" style="width: {{ ($day->total / max($advancedStats['best_days']->max('total'), 1)) * 100 }}%"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('affiliate.no_data_yet') }}</p>
                </div>
            @endif
        </div>

        <!-- Referrals Chart -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-blue-50 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-500" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-medium text-gray-900 dark:text-white">{{ __('affiliate.referrals_trend') }}</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('affiliate.last_30_days') }}</p>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-3 sm:gap-4 text-sm">
                    <div class="flex items-center gap-1.5">
                        <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                        <span class="text-gray-600 dark:text-gray-400">{{ __('affiliate.converted') }}: {{ $advancedStats['converted_referrals'] }}</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-3 h-3 bg-yellow-500 rounded-full"></span>
                        <span class="text-gray-600 dark:text-gray-400">{{ __('affiliate.pending') }}: {{ $advancedStats['pending_referrals'] }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Simple Bar Chart for Referrals -->
            <div class="relative h-48 flex items-end gap-0.5 bg-gray-50 dark:bg-gray-900/50 rounded-lg p-3 pt-6" x-data="{ 
                data: {{ json_encode(array_values($advancedStats['referrals_chart'])) }},
                labels: {{ json_encode(array_keys($advancedStats['referrals_chart'])) }},
                max: {{ max(array_values($advancedStats['referrals_chart'])) ?: 1 }},
                hasData: {{ array_sum(array_values($advancedStats['referrals_chart'])) > 0 ? 'true' : 'false' }}
            }">
                <!-- Grid lines -->
                <div class="absolute inset-x-3 top-6 bottom-3 flex flex-col justify-between pointer-events-none">
                    <div class="border-t border-dashed border-gray-200 dark:border-gray-700"></div>
                    <div class="border-t border-dashed border-gray-200 dark:border-gray-700"></div>
                    <div class="border-t border-dashed border-gray-200 dark:border-gray-700"></div>
                    <div class="border-t border-gray-300 dark:border-gray-600"></div>
                </div>
                
                <!-- No data message -->
                <div x-show="!hasData" class="absolute inset-0 flex items-center justify-center">
                    <p class="text-sm text-gray-400 dark:text-gray-500">{{ __('affiliate.no_referrals_data') }}</p>
                </div>
                
                <!-- Bars -->
                <template x-for="(value, index) in data" :key="index">
                    <div class="flex-1 flex flex-col items-center group relative h-full justify-end">
                        <div class="w-full bg-gradient-to-t from-blue-500 to-blue-400 dark:from-blue-600 dark:to-blue-500 rounded-t transition-all duration-300 hover:from-blue-600 hover:to-blue-500 cursor-pointer min-h-[2px]"
                             :style="'height: ' + (hasData && value > 0 ? Math.max((value / max) * 100, 8) : 2) + '%'">
                        </div>
                        <!-- Tooltip -->
                        <div class="absolute bottom-full mb-2 hidden group-hover:block z-10">
                            <div class="bg-gray-900 text-white text-xs rounded py-1 px-2 whitespace-nowrap shadow-lg">
                                <span class="font-semibold" x-text="value + ' {{ __('affiliate.referrals') }}'"></span>
                                <br>
                                <span class="text-gray-400" x-text="labels[index]"></span>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            <div class="flex justify-between mt-2 text-xs text-gray-400">
                <span>{{ now()->subDays(29)->format('M d') }}</span>
                <span>{{ now()->format('M d') }}</span>
            </div>
        </div>
    </div>

    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <!-- Left Column - Payout Widget -->
        <div class="lg:col-span-1 space-y-4">
            <!-- Payout Request Widget -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-blue-50 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-500" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 7.5a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z" />
                                <path fill-rule="evenodd" d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v9.75c0 1.036-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 14.625v-9.75zM8.25 9.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM18.75 9a.75.75 0 00-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 00.75-.75V9.75a.75.75 0 00-.75-.75h-.008zM4.5 9.75A.75.75 0 015.25 9h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75H5.25a.75.75 0 01-.75-.75V9.75z" clip-rule="evenodd" />
                                <path d="M2.25 18a.75.75 0 000 1.5c5.4 0 10.63.722 15.6 2.075 1.19.324 2.4-.558 2.4-1.82V18.75a.75.75 0 00-.75-.75H2.25z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-medium text-gray-900 dark:text-white">{{ __('affiliate.request_payout') }}</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('affiliate.min_payout') }}: ${{ number_format($affiliate->minimum_payout, 2) }}</p>
                        </div>
                    </div>
                </div>
                <div class="p-5">
                    <div class="text-center mb-5">
                        <div class="text-3xl font-semibold text-gray-900 dark:text-white mb-1">${{ number_format($affiliate->balance, 2) }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('affiliate.available_for_withdrawal') }}</div>
                    </div>
                    
                    @if($affiliate->canRequestPayout())
                        <button onclick="requestPayout()" 
                            class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" />
                            </svg>
                            {{ __('affiliate.request_payout') }}
                        </button>
                    @else
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-3 text-center">
                                {{ __('affiliate.need_more', ['amount' => number_format($affiliate->minimum_payout - $affiliate->balance, 2)]) }}
                            </p>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full transition-all duration-500" 
                                    style="width: {{ min(($affiliate->balance / $affiliate->minimum_payout) * 100, 100) }}%"></div>
                            </div>
                            <p class="text-xs text-gray-400 mt-2 text-center">{{ number_format(($affiliate->balance / $affiliate->minimum_payout) * 100, 1) }}% {{ __('affiliate.of_minimum') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- This Month Stats Widget -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-blue-50 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-500" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 017.5 3v1.5h9V3A.75.75 0 0118 3v1.5h.75a3 3 0 013 3v11.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V7.5a3 3 0 013-3H6V3a.75.75 0 01.75-.75zm13.5 9a1.5 1.5 0 00-1.5-1.5H5.25a1.5 1.5 0 00-1.5 1.5v7.5a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5v-7.5z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-medium text-gray-900 dark:text-white">{{ __('affiliate.this_month') }}</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ now()->format('F Y') }}</p>
                        </div>
                    </div>
                </div>
                <div class="p-5 space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('affiliate.new_referrals') }}</span>
                        <span class="text-lg font-semibold text-gray-900 dark:text-white">{{ $stats['this_month_referrals'] }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('affiliate.earnings') }}</span>
                        <span class="text-lg font-semibold text-green-600 dark:text-green-500">${{ number_format($stats['this_month_earnings'], 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Recent Referrals -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-blue-50 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-500" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.25 6.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM15.75 9.75a3 3 0 116 0 3 3 0 01-6 0zM2.25 9.75a3 3 0 116 0 3 3 0 01-6 0zM6.31 15.117A6.745 6.745 0 0112 12a6.745 6.745 0 016.709 7.498.75.75 0 01-.372.568A12.696 12.696 0 0112 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 01-.372-.568 6.787 6.787 0 011.019-4.38z" clip-rule="evenodd" />
                                    <path d="M5.082 14.254a8.287 8.287 0 00-1.308 5.135 9.687 9.687 0 01-1.764-.44l-.115-.04a.563.563 0 01-.373-.487l-.01-.121a3.75 3.75 0 013.57-4.047zM20.226 19.389a8.287 8.287 0 00-1.308-5.135 3.75 3.75 0 013.57 4.047l-.01.121a.563.563 0 01-.373.486l-.115.04c-.567.2-1.156.349-1.764.441z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-medium text-gray-900 dark:text-white">{{ __('affiliate.recent_referrals') }}</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('affiliate.your_referred_users') }}</p>
                            </div>
                        </div>
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $stats['total_referrals'] }} {{ __('affiliate.total') }}
                        </span>
                    </div>
                </div>
                
                @if($referrals->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-700/50">
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('affiliate.user') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('affiliate.joined') }}</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('affiliate.status') }}</th>
                                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('affiliate.commission_earned') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach($referrals as $referral)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-600 dark:to-gray-700 rounded-full flex items-center justify-center">
                                                    <span class="text-sm font-semibold text-gray-600 dark:text-gray-300">
                                                        {{ strtoupper(substr($referral->referredClient->name ?? 'U', 0, 2)) }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $referral->referredClient->name ?? __('affiliate.unknown') }}</div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $referral->referredClient->email ?? '' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-white">{{ $referral->created_at->format('M d, Y') }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $referral->created_at->diffForHumans() }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($referral->status === 'converted')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                                                    {{ __('affiliate.converted') }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                                    <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full mr-1.5"></span>
                                                    {{ __('affiliate.pending') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <span class="text-sm font-semibold text-green-600 dark:text-green-400">${{ number_format($referral->commissions->sum('amount'), 2) }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @if($referrals->hasPages())
                        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 overflow-x-auto">
                            {{ $referrals->links() }}
                        </div>
                    @endif
                @else
                    <div class="px-6 py-16 text-center">
                        <div class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-gray-400" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.25 6.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM15.75 9.75a3 3 0 116 0 3 3 0 01-6 0zM2.25 9.75a3 3 0 116 0 3 3 0 01-6 0zM6.31 15.117A6.745 6.745 0 0112 12a6.745 6.745 0 016.709 7.498.75.75 0 01-.372.568A12.696 12.696 0 0112 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 01-.372-.568 6.787 6.787 0 011.019-4.38z" clip-rule="evenodd" />
                                <path d="M5.082 14.254a8.287 8.287 0 00-1.308 5.135 9.687 9.687 0 01-1.764-.44l-.115-.04a.563.563 0 01-.373-.487l-.01-.121a3.75 3.75 0 013.57-4.047zM20.226 19.389a8.287 8.287 0 00-1.308-5.135 3.75 3.75 0 013.57 4.047l-.01.121a.563.563 0 01-.373.486l-.115.04c-.567.2-1.156.349-1.764.441z" />
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('affiliate.no_referrals_yet') }}</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400 max-w-sm mx-auto">{{ __('affiliate.start_sharing') }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Live Visitors Widget - Full Width with Real-time Updates -->
        <div class="lg:col-span-3" 
             x-data="{ 
                 onlineCount: {{ $visitorStats['online_count'] ?? 0 }},
                 todayCount: {{ $visitorStats['today_count'] ?? 0 }},
                 checkoutCount: {{ $visitorStats['checkout_count'] ?? 0 }},
                 onlineVisitors: [],
                 isLoading: false,
                 init() {
                     this.fetchVisitors();
                     setInterval(() => this.fetchVisitors(), 3000);
                 },
                 fetchVisitors() {
                     fetch('{{ route('client.affiliate.live-visitors') }}')
                         .then(res => res.json())
                         .then(data => {
                             if (data.success) {
                                 this.onlineCount = data.online_count;
                                 this.todayCount = data.today_count;
                                 this.checkoutCount = data.checkout_count;
                                 this.onlineVisitors = data.online_visitors;
                             }
                         });
                 }
             }">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-green-50 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600 dark:text-green-500" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-medium text-gray-900 dark:text-white">{{ __('affiliate.live_visitors') }}</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('affiliate.real_time_tracking') }}</p>
                            </div>
                        </div>
                        <!-- Live indicator -->
                        <div class="flex items-center gap-1.5">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                            </span>
                            <span class="text-xs text-gray-400 dark:text-gray-500">Live</span>
                        </div>
                    </div>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <!-- Online Now -->
                        <div class="flex items-center justify-between p-4 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-100 dark:border-green-800">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                <span class="text-sm font-medium text-green-700 dark:text-green-400">{{ __('affiliate.online_now') }}</span>
                            </div>
                            <span class="text-2xl font-bold text-green-600 dark:text-green-400 transition-all duration-300" x-text="onlineCount"></span>
                        </div>
                        
                        <!-- Today's Visitors -->
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('affiliate.today_visitors') }}</span>
                            <span class="text-2xl font-bold text-gray-900 dark:text-white transition-all duration-300" x-text="todayCount"></span>
                        </div>
                        
                        <!-- Reached Checkout -->
                        <div class="flex items-center justify-between p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-100 dark:border-blue-800">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z" />
                                </svg>
                                <span class="text-sm font-medium text-blue-700 dark:text-blue-400">{{ __('affiliate.reached_checkout') }}</span>
                            </div>
                            <span class="text-2xl font-bold text-blue-600 dark:text-blue-400 transition-all duration-300" x-text="checkoutCount"></span>
                        </div>
                    </div>

                    <!-- Online Visitors List - Dynamic -->
                    <div x-show="onlineVisitors.length > 0" x-cloak class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase mb-3">{{ __('affiliate.active_sessions') }}</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                            <template x-for="visitor in onlineVisitors" :key="visitor.ip_address">
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/30 rounded-lg text-sm overflow-hidden">
                                    <div class="flex items-center gap-2 min-w-0 flex-1">
                                        <div class="w-2 h-2 bg-green-500 rounded-full flex-shrink-0"></div>
                                        <span class="text-gray-600 dark:text-gray-300 font-mono text-xs truncate" x-text="visitor.ip_address"></span>
                                    </div>
                                    <div class="flex items-center gap-2 flex-shrink-0">
                                        <span x-show="visitor.visited_checkout" class="px-1.5 py-0.5 text-xs bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 rounded">
                                            <svg class="w-3 h-3 inline" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25z" />
                                            </svg>
                                        </span>
                                        <span class="text-xs text-gray-400" x-text="visitor.last_activity"></span>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                    
                    <!-- Empty state when no visitors -->
                    <div x-show="onlineVisitors.length === 0 && onlineCount === 0" class="pt-4 border-t border-gray-200 dark:border-gray-700 text-center py-8">
                        <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-gray-400" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('affiliate.no_visitors_yet') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Commissions History Section -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-500" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 01-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004zM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 01-.921.42z" />
                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v.816a3.836 3.836 0 00-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 01-.921-.421l-.879-.66a.75.75 0 00-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 001.5 0v-.81a4.124 4.124 0 001.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 00-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 00.933-1.175l-.415-.33a3.836 3.836 0 00-1.719-.755V6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-medium text-gray-900 dark:text-white">{{ __('affiliate.commissions_history') }}</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('affiliate.commissions_history_description') }}</p>
                    </div>
                </div>
                <span class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $commissions->count() }} {{ __('affiliate.records') }}
                </span>
            </div>
        </div>
        <div class="overflow-x-auto">
            @if($commissions->count() > 0)
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-700/50">
                            <th class="px-5 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('affiliate.date') }}</th>
                            <th class="px-5 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('affiliate.commission_id') }}</th>
                            <th class="px-5 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('affiliate.client_name') }}</th>
                            <th class="px-5 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('affiliate.product_service') }}</th>
                            <th class="px-5 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('affiliate.product_status') }}</th>
                            <th class="px-5 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('affiliate.amount') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($commissions as $commission)
                            @php
                                $isMilestoneReward = str_contains($commission->description ?? '', 'Milestone Reward');
                                $isManualCredit = str_contains($commission->description ?? '', 'Manual Credit');
                                $isManualDebit = str_contains($commission->description ?? '', 'Manual Debit');
                                $isManualAdjustment = $isManualCredit || $isManualDebit;
                            @endphp
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                <!-- Date -->
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $commission->created_at->format('M d, Y') }}</span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $commission->created_at->format('h:i A') }}</span>
                                    </div>
                                </td>
                                
                                <!-- Commission ID -->
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                                        #{{ $commission->reference_id }}
                                    </span>
                                </td>
                                
                                <!-- Client Name -->
                                <td class="px-5 py-4 whitespace-nowrap">
                                    @if($isMilestoneReward)
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div>
                                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ __('affiliate.milestone_achievement') }}</span>
                                            </div>
                                        </div>
                                    @elseif($isManualAdjustment)
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full {{ $isManualCredit ? 'bg-gradient-to-br from-green-500 to-emerald-500' : 'bg-gradient-to-br from-red-500 to-rose-500' }} flex items-center justify-center">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ __('affiliate.admin_adjustment') }}</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                                <span class="text-xs font-medium text-gray-600 dark:text-gray-300">
                                                    {{ $commission->referral?->referredClient ? strtoupper(substr($commission->referral->referredClient->first_name ?? '', 0, 1) . substr($commission->referral->referredClient->last_name ?? '', 0, 1)) : '?' }}
                                                </span>
                                            </div>
                                            <div>
                                                <span class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $commission->referral?->referredClient ? ($commission->referral->referredClient->first_name . ' ' . $commission->referral->referredClient->last_name) : __('affiliate.unknown_client') }}
                                                </span>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                
                                <!-- Product/Service -->
                                <td class="px-5 py-4">
                                    @if($isMilestoneReward)
                                        @php
                                            $rewardName = str_replace('🎁 Milestone Reward: ', '', $commission->description);
                                            $rewardKey = 'affiliate.reward_' . strtolower(str_replace([' ', '-'], '_', $rewardName));
                                            $translatedRewardName = __($rewardKey) !== $rewardKey ? __($rewardKey) : $rewardName;
                                        @endphp
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M11.25 3v4.046a3 3 0 00-4.277 4.204H1.5v-6A2.25 2.25 0 013.75 3h7.5zM12.75 3v4.011a3 3 0 014.239 4.239H22.5v-6A2.25 2.25 0 0020.25 3h-7.5zM22.5 12.75h-8.983a4.125 4.125 0 004.108 3.75.75.75 0 010 1.5 5.623 5.623 0 01-4.875-2.817V21h7.5a2.25 2.25 0 002.25-2.25v-6zM11.25 21v-5.817A5.623 5.623 0 016.375 18a.75.75 0 010-1.5 4.126 4.126 0 004.108-3.75H1.5v6A2.25 2.25 0 003.75 21h7.5z" />
                                                </svg>
                                            </div>
                                            <div class="min-w-0">
                                                <span class="text-sm font-medium text-gray-900 dark:text-white block truncate max-w-[200px]">
                                                    {{ $translatedRewardName }}
                                                </span>
                                                <span class="text-xs text-purple-600 dark:text-purple-400">{{ __('affiliate.milestone_reward') }}</span>
                                            </div>
                                        </div>
                                    @elseif($isManualAdjustment)
                                        @php
                                            // Extract reason from description (e.g., "Manual Credit: Bonus - notes" -> "Bonus")
                                            $adjustmentDesc = $commission->description ?? '';
                                            $adjustmentDesc = preg_replace('/^Manual (Credit|Debit): /', '', $adjustmentDesc);
                                            
                                            // Translate common reasons
                                            $reasonTranslations = [
                                                'Bonus' => __('affiliate.reason_bonus'),
                                                'Adjustment' => __('affiliate.reason_adjustment'),
                                                'Promotion' => __('affiliate.reason_promotion'),
                                                'Correction' => __('affiliate.reason_correction'),
                                                'Chargeback' => __('affiliate.reason_chargeback'),
                                                'Refund' => __('affiliate.reason_refund'),
                                                'Other' => __('affiliate.reason_other'),
                                            ];
                                            
                                            // Check if the description starts with a known reason
                                            foreach ($reasonTranslations as $eng => $translated) {
                                                if (str_starts_with($adjustmentDesc, $eng)) {
                                                    $adjustmentDesc = str_replace($eng, $translated, $adjustmentDesc);
                                                    break;
                                                }
                                            }
                                        @endphp
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-lg {{ $isManualCredit ? 'bg-green-50 dark:bg-green-900/20' : 'bg-red-50 dark:bg-red-900/20' }} flex items-center justify-center flex-shrink-0">
                                                <svg class="w-4 h-4 {{ $isManualCredit ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                            </div>
                                            <div class="min-w-0">
                                                <span class="text-sm font-medium text-gray-900 dark:text-white block truncate max-w-[200px]">
                                                    {{ $adjustmentDesc }}
                                                </span>
                                                <span class="text-xs {{ $isManualCredit ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                                    {{ $isManualCredit ? __('affiliate.manual_credit') : __('affiliate.manual_debit') }}
                                                </span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-900/20 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M11.25 3v4.046a3 3 0 00-4.277 4.204H1.5v-6A2.25 2.25 0 013.75 3h7.5zM12.75 3v4.011a3 3 0 014.239 4.239H22.5v-6A2.25 2.25 0 0020.25 3h-7.5zM22.5 12.75h-8.983a4.125 4.125 0 004.108 3.75.75.75 0 010 1.5 5.623 5.623 0 01-4.875-2.817V21h7.5a2.25 2.25 0 002.25-2.25v-6zM11.25 21v-5.817A5.623 5.623 0 016.375 18a.75.75 0 010-1.5 4.126 4.126 0 004.108-3.75H1.5v6A2.25 2.25 0 003.75 21h7.5z" />
                                                    <path d="M11.085 10.354c.03.297.038.575.036.805a7.484 7.484 0 01-.805-.036c-.833-.084-1.677-.325-2.195-.843a1.5 1.5 0 012.122-2.122c.518.518.759 1.362.842 2.196z" />
                                                    <path d="M12.877 10.354c-.03.297-.038.575-.036.805.23.002.508-.006.805-.036.833-.084 1.677-.325 2.195-.843A1.5 1.5 0 0013.72 8.16c-.518.518-.759 1.362-.843 2.194z" />
                                                </svg>
                                            </div>
                                            <div class="min-w-0">
                                                <span class="text-sm font-medium text-gray-900 dark:text-white block truncate max-w-[200px]">
                                                    {{ $commission->invoice?->order?->product?->name ?? ($commission->description ?: __('affiliate.unknown_product')) }}
                                                </span>
                                                @if($commission->invoice?->invoice_number)
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">#{{ $commission->invoice->invoice_number }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                
                                <!-- Product Status -->
                                <td class="px-5 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                            'approved' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                            'paid' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                            'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                        ];
                                        $statusClass = $statusColors[$commission->status] ?? $statusColors['pending'];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                                        <span class="w-1.5 h-1.5 rounded-full mr-1.5 
                                            @if($commission->status === 'approved' || $commission->status === 'paid') bg-green-500
                                            @elseif($commission->status === 'pending') bg-yellow-500
                                            @else bg-red-500 @endif">
                                        </span>
                                        {{ __(('affiliate.status_' . $commission->status)) }}
                                    </span>
                                </td>
                                
                                <!-- Amount -->
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-semibold text-emerald-600 dark:text-emerald-400">
                                            +${{ number_format($commission->commission_amount, 2) }}
                                        </span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $commission->commission_rate }}% {{ __('affiliate.of') }} ${{ number_format($commission->amount, 2) }}
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="px-6 py-16 text-center">
                    <div class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-400" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 01-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004zM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 01-.921.42z" />
                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v.816a3.836 3.836 0 00-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 01-.921-.421l-.879-.66a.75.75 0 00-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 001.5 0v-.81a4.124 4.124 0 001.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 00-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 00.933-1.175l-.415-.33a3.836 3.836 0 00-1.719-.755V6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('affiliate.no_commissions_yet') }}</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400 max-w-sm mx-auto">{{ __('affiliate.start_earning_commissions') }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- How It Works Section -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-medium text-gray-900 dark:text-white">{{ __('affiliate.how_it_works') }}</h3>
        </div>
        <div class="p-5">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-medium text-sm">
                        1
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-white mb-1">{{ __('affiliate.step_1_title') }}</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('affiliate.step_1_description') }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-medium text-sm">
                        2
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-white mb-1">{{ __('affiliate.step_2_title') }}</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('affiliate.step_2_description') }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-medium text-sm">
                        3
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-white mb-1">{{ __('affiliate.step_3_title') }}</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('affiliate.step_3_description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyReferralLink() {
    const linkInput = document.getElementById('referralLink');
    const copyIcon = document.getElementById('copyIcon');
    const checkIcon = document.getElementById('checkIcon');
    const copyText = document.getElementById('copyText');
    
    navigator.clipboard.writeText(linkInput.value).then(() => {
        // Show success state
        copyIcon.classList.add('hidden');
        checkIcon.classList.remove('hidden');
        copyText.textContent = '{{ __('affiliate.copied') }}';
        
        // Reset after 2 seconds
        setTimeout(() => {
            copyIcon.classList.remove('hidden');
            checkIcon.classList.add('hidden');
            copyText.textContent = '{{ __('affiliate.copy_link') }}';
        }, 2000);
    });
}

function copyText(elementId) {
    const text = document.getElementById(elementId).innerText;
    navigator.clipboard.writeText(text).then(() => {
        // Show toast notification
        showToast('{{ __('affiliate.text_copied') }}');
    });
}

function copyBannerCode(size) {
    const referralLink = '{{ $affiliate->referral_link }}';
    const appName = '{{ config('app.name') }}';
    const logoBlue = '{{ url('/logo/pro Gineous_white logo_blue icon.svg') }}';
    const logoWhite = '{{ url('/logo/pro Gineous_white logo_white icon.svg') }}';
    const tagline = '{{ __('affiliate.banner_tagline') }}';
    const subtitle = '{{ __('affiliate.banner_subtitle') }}';
    const cta = '{{ __('affiliate.banner_cta') }}';
    const startNow = '{{ __('affiliate.start_now') }}';
    const ctaShort = '{{ __('affiliate.banner_cta_short') }}';
    
    // Domain banner variables
    const domainTagline = '{{ __('affiliate.domain_tagline') }}';
    const domainSubtitle = '{{ __('affiliate.domain_subtitle') }}';
    const domainCta = '{{ __('affiliate.domain_cta') }}';
    const domainCtaShort = '{{ __('affiliate.domain_cta_short') }}';
    const domainExtensions = '{{ __('affiliate.domain_extensions') }}';
    const fromPrice = '{{ __('affiliate.from_price') }}';
    const perYear = '{{ __('affiliate.per_year') }}';
    
    const bannerCodes = {
        '728x90': `<a href="${referralLink}" target="_blank" style="display:inline-block;text-decoration:none;">
    <div style="background:linear-gradient(135deg,#1d71b8 0%,#0f4c81 50%,#1d71b8 100%);border-radius:8px;width:728px;height:90px;position:relative;overflow:hidden;font-family:Arial,sans-serif;">
        <div style="position:absolute;top:-10px;right:-10px;width:160px;height:160px;border-radius:50%;background:radial-gradient(circle,rgba(255,255,255,0.1) 0%,transparent 70%);"></div>
        <div style="position:absolute;bottom:-10px;left:-10px;width:128px;height:128px;border-radius:50%;background:radial-gradient(circle,rgba(255,255,255,0.1) 0%,transparent 70%);"></div>
        <div style="height:100%;display:flex;align-items:center;justify-content:space-between;padding:0 24px;position:relative;">
            <div style="display:flex;align-items:center;gap:16px;">
                <img src="${logoWhite}" alt="${appName}" style="height:40px;">
                <div style="color:white;">
                    <div style="font-size:18px;font-weight:bold;">${tagline}</div>
                    <div style="font-size:12px;opacity:0.8;">${subtitle}</div>
                </div>
            </div>
            <div style="background:white;color:#1d71b8;padding:8px 20px;border-radius:8px;font-weight:bold;font-size:14px;">${cta} →</div>
        </div>
    </div>
</a>`,
        '300x250': `<a href="${referralLink}" target="_blank" style="display:inline-block;text-decoration:none;">
    <div style="background:linear-gradient(180deg,#1d71b8 0%,#0f4c81 100%);border-radius:8px;width:300px;height:250px;position:relative;overflow:hidden;font-family:Arial,sans-serif;">
        <div style="position:absolute;top:-80px;right:-80px;width:256px;height:256px;border-radius:50%;background:radial-gradient(circle,rgba(255,255,255,0.1) 0%,transparent 60%);"></div>
        <div style="position:absolute;bottom:-40px;left:-40px;width:160px;height:160px;border-radius:50%;background:radial-gradient(circle,rgba(255,255,255,0.1) 0%,transparent 60%);"></div>
        <div style="height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:24px;text-align:center;position:relative;">
            <img src="${logoWhite}" alt="${appName}" style="height:48px;margin-bottom:16px;">
            <div style="color:white;">
                <div style="font-size:20px;font-weight:bold;margin-bottom:8px;line-height:1.3;">${tagline}</div>
                <div style="font-size:12px;opacity:0.8;margin-bottom:16px;">${subtitle}</div>
            </div>
            <div style="background:white;color:#1d71b8;padding:10px 24px;border-radius:8px;font-weight:bold;font-size:14px;">${cta} →</div>
        </div>
    </div>
</a>`,
        '160x600': `<a href="${referralLink}" target="_blank" style="display:inline-block;text-decoration:none;">
    <div style="background:linear-gradient(180deg,#1d71b8 0%,#0a3d66 100%);border-radius:8px;width:160px;height:600px;position:relative;overflow:hidden;font-family:Arial,sans-serif;">
        <div style="position:absolute;top:-40px;right:-40px;width:128px;height:128px;border-radius:50%;background:radial-gradient(circle,rgba(255,255,255,0.1) 0%,transparent 60%);"></div>
        <div style="position:absolute;top:50%;left:-40px;width:96px;height:96px;border-radius:50%;background:radial-gradient(circle,rgba(255,255,255,0.1) 0%,transparent 60%);"></div>
        <div style="position:absolute;bottom:-40px;right:-40px;width:112px;height:112px;border-radius:50%;background:radial-gradient(circle,rgba(255,255,255,0.1) 0%,transparent 60%);"></div>
        <div style="height:100%;display:flex;flex-direction:column;align-items:center;justify-content:space-between;padding:48px 12px;text-align:center;position:relative;">
            <img src="${logoWhite}" alt="${appName}" style="width:128px;">
            <div style="color:white;">
                <div style="font-size:16px;font-weight:bold;margin-bottom:8px;line-height:1.3;">${tagline}</div>
                <div style="font-size:11px;opacity:0.8;">${subtitle}</div>
            </div>
            <div style="background:white;color:#1d71b8;padding:12px 24px;border-radius:8px;font-weight:bold;font-size:13px;">${cta} →</div>
        </div>
    </div>
</a>`,
        '320x50': `<a href="${referralLink}" target="_blank" style="display:inline-block;text-decoration:none;">
    <div style="background:linear-gradient(90deg,#1d71b8 0%,#0f4c81 100%);border-radius:8px;width:320px;height:50px;position:relative;overflow:hidden;font-family:Arial,sans-serif;">
        <div style="position:absolute;right:-20px;top:-20px;width:80px;height:80px;border-radius:50%;background:radial-gradient(circle,rgba(255,255,255,0.1) 0%,transparent 60%);"></div>
        <div style="height:100%;display:flex;align-items:center;justify-content:space-between;padding:0 16px;position:relative;">
            <div style="display:flex;align-items:center;gap:12px;">
                <img src="${logoWhite}" alt="${appName}" style="height:24px;">
                <span style="color:white;font-size:12px;font-weight:500;">${ctaShort}</span>
            </div>
            <div style="background:white;color:#1d71b8;padding:4px 12px;border-radius:4px;font-weight:bold;font-size:12px;">${startNow}</div>
        </div>
    </div>
</a>`,
        '250x250': `<a href="${referralLink}" target="_blank" style="display:inline-block;text-decoration:none;">
    <div style="background:white;border:3px solid #1d71b8;border-radius:8px;width:250px;height:250px;position:relative;overflow:hidden;font-family:Arial,sans-serif;">
        <div style="position:absolute;top:0;left:0;width:0;height:0;border-left:80px solid #1d71b8;border-bottom:80px solid transparent;"></div>
        <div style="position:absolute;bottom:0;right:0;width:0;height:0;border-right:64px solid #1d71b8;border-top:64px solid transparent;"></div>
        <div style="height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:16px;text-align:center;position:relative;">
            <img src="${logoBlue}" alt="${appName}" style="height:40px;margin-bottom:12px;">
            <div style="color:#1d71b8;">
                <div style="font-size:14px;font-weight:bold;margin-bottom:4px;line-height:1.3;">${tagline}</div>
                <div style="font-size:10px;opacity:0.7;margin-bottom:12px;">${subtitle}</div>
            </div>
            <div style="background:#1d71b8;color:white;padding:6px 16px;border-radius:8px;font-weight:bold;font-size:12px;">${cta} →</div>
        </div>
    </div>
</a>`,
        '468x60': `<a href="${referralLink}" target="_blank" style="display:inline-block;text-decoration:none;">
    <div style="background:white;border:2px solid #1d71b8;border-radius:8px;width:468px;height:60px;position:relative;overflow:hidden;font-family:Arial,sans-serif;">
        <div style="position:absolute;left:0;top:0;bottom:0;width:8px;background:#1d71b8;"></div>
        <div style="height:100%;display:flex;align-items:center;justify-content:space-between;padding:0 24px 0 32px;position:relative;">
            <div style="display:flex;align-items:center;gap:16px;">
                <img src="${logoBlue}" alt="${appName}" style="height:32px;">
                <div style="color:#1d71b8;">
                    <div style="font-size:14px;font-weight:bold;">${tagline}</div>
                    <div style="font-size:10px;opacity:0.7;">${subtitle}</div>
                </div>
            </div>
            <div style="background:#1d71b8;color:white;padding:6px 16px;border-radius:8px;font-weight:bold;font-size:12px;">${cta} →</div>
        </div>
    </div>
</a>`,
        // Domain Banners
        'domain-728x90': `<a href="${referralLink}" target="_blank" style="display:inline-block;text-decoration:none;">
    <div style="background:linear-gradient(135deg,#1d71b8 0%,#0f4c81 50%,#1d71b8 100%);border-radius:8px;width:728px;height:90px;position:relative;overflow:hidden;font-family:Arial,sans-serif;">
        <div style="position:absolute;top:-10px;right:-10px;width:160px;height:160px;border-radius:50%;background:radial-gradient(circle,rgba(255,255,255,0.1) 0%,transparent 70%);"></div>
        <div style="position:absolute;bottom:-10px;left:-10px;width:128px;height:128px;border-radius:50%;background:radial-gradient(circle,rgba(255,255,255,0.1) 0%,transparent 70%);"></div>
        <div style="height:100%;display:flex;align-items:center;justify-content:space-between;padding:0 24px;position:relative;">
            <div style="display:flex;align-items:center;gap:16px;">
                <img src="${logoWhite}" alt="${appName}" style="height:40px;">
                <div style="color:white;">
                    <div style="font-size:18px;font-weight:bold;">${domainTagline}</div>
                    <div style="font-size:12px;opacity:0.8;">${domainExtensions} | ${fromPrice} $9.99${perYear}</div>
                </div>
            </div>
            <div style="background:white;color:#1d71b8;padding:8px 20px;border-radius:8px;font-weight:bold;font-size:14px;">${domainCta} →</div>
        </div>
    </div>
</a>`,
        'domain-300x250': `<a href="${referralLink}" target="_blank" style="display:inline-block;text-decoration:none;">
    <div style="background:linear-gradient(180deg,#1d71b8 0%,#0f4c81 100%);border-radius:8px;width:300px;height:250px;position:relative;overflow:hidden;font-family:Arial,sans-serif;">
        <div style="position:absolute;top:-80px;right:-80px;width:256px;height:256px;border-radius:50%;background:radial-gradient(circle,rgba(255,255,255,0.1) 0%,transparent 60%);"></div>
        <div style="position:absolute;bottom:-40px;left:-40px;width:160px;height:160px;border-radius:50%;background:radial-gradient(circle,rgba(255,255,255,0.1) 0%,transparent 60%);"></div>
        <div style="height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:24px;text-align:center;position:relative;">
            <img src="${logoWhite}" alt="${appName}" style="height:40px;margin-bottom:12px;">
            <div style="color:white;">
                <div style="font-size:20px;font-weight:bold;margin-bottom:4px;line-height:1.3;">${domainTagline}</div>
                <div style="font-size:12px;opacity:0.8;margin-bottom:8px;">${domainSubtitle}</div>
                <div style="font-size:14px;font-weight:500;opacity:0.9;margin-bottom:12px;">${domainExtensions}</div>
            </div>
            <div style="background:white;color:#1d71b8;padding:10px 24px;border-radius:8px;font-weight:bold;font-size:14px;">${domainCta} →</div>
        </div>
    </div>
</a>`,
        'domain-250x250': `<a href="${referralLink}" target="_blank" style="display:inline-block;text-decoration:none;">
    <div style="background:white;border:3px solid #1d71b8;border-radius:8px;width:250px;height:250px;position:relative;overflow:hidden;font-family:Arial,sans-serif;">
        <div style="position:absolute;top:0;left:0;width:0;height:0;border-left:80px solid #1d71b8;border-bottom:80px solid transparent;"></div>
        <div style="position:absolute;bottom:0;right:0;width:0;height:0;border-right:64px solid #1d71b8;border-top:64px solid transparent;"></div>
        <div style="height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:16px;text-align:center;position:relative;">
            <img src="${logoBlue}" alt="${appName}" style="height:32px;margin-bottom:8px;">
            <div style="color:#1d71b8;">
                <div style="font-size:14px;font-weight:bold;margin-bottom:4px;line-height:1.3;">${domainTagline}</div>
                <div style="font-size:10px;opacity:0.7;margin-bottom:8px;">${domainExtensions}</div>
            </div>
            <div style="background:#1d71b8;color:white;padding:6px 16px;border-radius:8px;font-weight:bold;font-size:12px;">${domainCta} →</div>
        </div>
    </div>
</a>`,
        'domain-320x50': `<a href="${referralLink}" target="_blank" style="display:inline-block;text-decoration:none;">
    <div style="background:linear-gradient(90deg,#1d71b8 0%,#0f4c81 100%);border-radius:8px;width:320px;height:50px;position:relative;overflow:hidden;font-family:Arial,sans-serif;">
        <div style="position:absolute;right:-20px;top:-20px;width:80px;height:80px;border-radius:50%;background:radial-gradient(circle,rgba(255,255,255,0.1) 0%,transparent 60%);"></div>
        <div style="height:100%;display:flex;align-items:center;justify-content:space-between;padding:0 16px;position:relative;">
            <div style="display:flex;align-items:center;gap:12px;">
                <img src="${logoWhite}" alt="${appName}" style="height:24px;">
                <span style="color:white;font-size:12px;font-weight:500;">${domainCtaShort}</span>
            </div>
            <div style="background:white;color:#1d71b8;padding:4px 12px;border-radius:4px;font-weight:bold;font-size:12px;">${domainCta}</div>
        </div>
    </div>
</a>`,
        'domain-468x60': `<a href="${referralLink}" target="_blank" style="display:inline-block;text-decoration:none;">
    <div style="background:white;border:2px solid #1d71b8;border-radius:8px;width:468px;height:60px;position:relative;overflow:hidden;font-family:Arial,sans-serif;">
        <div style="position:absolute;left:0;top:0;bottom:0;width:8px;background:#1d71b8;"></div>
        <div style="height:100%;display:flex;align-items:center;justify-content:space-between;padding:0 24px 0 32px;position:relative;">
            <div style="display:flex;align-items:center;gap:16px;">
                <img src="${logoBlue}" alt="${appName}" style="height:32px;">
                <div style="color:#1d71b8;">
                    <div style="font-size:14px;font-weight:bold;">${domainTagline}</div>
                    <div style="font-size:10px;opacity:0.7;">${domainExtensions} | ${fromPrice} $9.99${perYear}</div>
                </div>
            </div>
            <div style="background:#1d71b8;color:white;padding:6px 16px;border-radius:8px;font-weight:bold;font-size:12px;">${domainCta} →</div>
        </div>
    </div>
</a>`,
    };
    
    navigator.clipboard.writeText(bannerCodes[size] || '').then(() => {
        showToast('{{ __('affiliate.code_copied') }}');
    });
}

function showToast(message) {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = 'fixed bottom-4 right-4 bg-gray-900 dark:bg-gray-700 text-white px-4 py-2 rounded-lg shadow-lg z-50 animate-fade-in';
    toast.innerHTML = `
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-green-400" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z" clip-rule="evenodd" />
            </svg>
            <span class="text-sm">${message}</span>
        </div>
    `;
    document.body.appendChild(toast);
    
    // Remove after 2 seconds
    setTimeout(() => {
        toast.remove();
    }, 2000);
}

function requestPayout() {
    if (confirm('{{ __('affiliate.confirm_payout_request') }}')) {
        fetch('{{ route('client.affiliate.request-payout') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.reload();
            } else {
                alert(data.message || '{{ __('affiliate.payout_error') }}');
            }
        })
        .catch(error => {
            alert('{{ __('affiliate.payout_error') }}');
        });
    }
}

// Alpine.js component for real-time stats
function affiliateStats() {
    return {
        linkClicks: {{ $affiliate->link_clicks ?? 0 }},
        justUpdated: false,
        pollingInterval: null,
        
        startPolling() {
            // Poll every 5 seconds for real-time updates
            this.pollingInterval = setInterval(() => {
                this.fetchStats();
            }, 5000);
        },
        
        async fetchStats() {
            try {
                const response = await fetch('{{ route('client.affiliate.stats') }}', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                if (response.ok) {
                    const data = await response.json();
                    if (data.success && data.stats) {
                        // Check if link clicks changed
                        if (data.stats.link_clicks !== this.linkClicks) {
                            this.linkClicks = data.stats.link_clicks;
                            this.justUpdated = true;
                            
                            // Reset highlight after 1 second
                            setTimeout(() => {
                                this.justUpdated = false;
                            }, 1000);
                        }
                    }
                }
            } catch (error) {
                console.error('Error fetching affiliate stats:', error);
            }
        },
        
        destroy() {
            if (this.pollingInterval) {
                clearInterval(this.pollingInterval);
            }
        }
    }
}
</script>
@endsection
