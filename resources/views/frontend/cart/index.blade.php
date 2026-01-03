@extends('frontend.layout')

@section('title', __('frontend.my_cart') . ' - ' . config('app.name'))

@section('content')
<section class="relative py-12 bg-slate-50 dark:bg-slate-900 min-h-screen">
    <!-- Toast Notification for DNS Errors -->
    <div id="dns-toast" class="hidden fixed top-24 left-1/2 -translate-x-1/2 z-50 transform transition-all duration-300 ease-in-out">
        <div class="bg-red-600 text-white px-5 py-3 rounded-lg shadow-lg flex items-center gap-3 min-w-[320px] max-w-md">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div class="flex-1">
                <p class="font-medium text-sm" id="dns-toast-message">
                    {{ __('frontend.dns_no_arabic') ?? 'Arabic characters are not allowed in DNS fields' }}
                </p>
                <p class="text-xs mt-0.5 opacity-80" id="dns-toast-subtitle">
                    {{ __('frontend.english_only_allowed') ?? 'Only English characters allowed' }}
                </p>
            </div>
            <button onclick="hideDNSToast()" class="flex-shrink-0 hover:bg-white/10 rounded p-1 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Confirmation Toast for Remove Item -->
    <div id="confirm-toast" class="hidden fixed top-24 left-1/2 -translate-x-1/2 z-50 transform transition-all duration-300 ease-in-out">
        <div class="bg-amber-600 text-white px-5 py-3 rounded-lg shadow-lg min-w-[320px] max-w-md">
            <div class="flex items-start gap-3 mb-3">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div class="flex-1">
                    <p class="font-medium text-sm">
                        {{ __('frontend.confirm_remove_item') ?? 'Are you sure you want to remove this item?' }}
                    </p>
                    <p class="text-xs mt-0.5 opacity-80">
                        {{ __('frontend.action_cannot_be_undone') ?? 'This action cannot be undone' }}
                    </p>
                </div>
            </div>
            <div class="flex gap-2 {{ app()->getLocale() == 'ar' ? 'flex-row-reverse' : '' }}">
                <button onclick="confirmRemove()" class="flex-1 bg-white/20 hover:bg-white/30 text-white font-medium py-2 px-4 rounded-lg transition-colors text-sm">
                    {{ __('frontend.yes_remove') ?? 'Yes, Remove' }}
                </button>
                <button onclick="hideConfirmToast()" class="flex-1 bg-white text-amber-600 hover:bg-slate-50 font-medium py-2 px-4 rounded-lg transition-colors text-sm">
                    {{ __('frontend.cancel') ?? 'Cancel' }}
                </button>
            </div>
        </div>
    </div>

    <!-- Error Toast for Linked Domain -->
    <div id="error-toast" class="hidden fixed top-24 left-1/2 -translate-x-1/2 z-50 transform transition-all duration-300 ease-in-out opacity-0 translate-y-[-20px]">
        <div class="bg-red-600 text-white px-5 py-3 rounded-lg shadow-lg min-w-[320px] max-w-md">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1">
                    <p class="font-medium text-sm" id="error-message"></p>
                </div>
                <button onclick="hideErrorToast()" class="flex-shrink-0 hover:bg-white/10 rounded p-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <!-- Page Header -->
            <div class="text-center mb-10">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-slate-100 dark:bg-slate-800 rounded-lg mb-4">
                    <svg class="w-4 h-4 text-slate-600 dark:text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                    </svg>
                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300">
                        {{ __('frontend.shopping_cart') ?? 'Shopping Cart' }}
                    </span>
                </div>
            </div>

            @if(empty($cart))
                <!-- Empty Cart -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-12 text-center border border-slate-200 dark:border-slate-700">
                    <!-- Icon -->
                    <div class="w-24 h-24 mx-auto mb-6 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>

                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">
                        {{ __('frontend.cart_is_empty') }}
                    </h2>
                    <p class="text-slate-600 dark:text-slate-400 mb-8 max-w-md mx-auto">
                        {{ __('frontend.start_shopping_message') ?? 'Start adding domains to your cart to build your online presence' }}
                    </p>
                    
                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="{{ route('domains.search') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-slate-800 hover:bg-slate-900 dark:bg-slate-700 dark:hover:bg-slate-600 text-white font-medium rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <span>{{ __('frontend.search_domains') ?? 'Search Domains' }}</span>
                        </a>
                        
                        <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-900 dark:text-white font-medium rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span>{{ __('frontend.go_home') ?? 'Go Home' }}</span>
                        </a>
                    </div>
                </div>
            @else
                <div class="grid lg:grid-cols-3 gap-6 items-start">
                    <!-- Cart Items -->
                    <div class="lg:col-span-2 space-y-4">
                        @foreach($cart as $key => $item)
                            @if(($item['type'] ?? 'domain') == 'hosting')
                                {{-- Hosting Item --}}
                                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-5 border border-slate-200 dark:border-slate-700" data-hosting-product="{{ $item['product_id'] }}">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex-1">
                                            <!-- Hosting Icon & Type -->
                                            <div class="flex items-center gap-3 mb-3">
                                                <div class="w-10 h-10 bg-slate-100 dark:bg-slate-700 rounded-lg flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                                                    </svg>
                                                </div>
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-xs font-medium rounded-md">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                                                    </svg>
                                                    {{ __('frontend.hosting') }}
                                                </span>
                                            </div>

                                            <!-- Product Name -->
                                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-3" data-hosting-name>
                                                {{ $item['product_name'] ?? __('frontend.hosting_plan') }}
                                            </h3>

                                            <!-- Hosting Details -->
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-3">
                                                <!-- Domain -->
                                                <div class="flex items-center gap-2 p-2.5 bg-slate-50 dark:bg-slate-700/50 rounded-lg">
                                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                                    </svg>
                                                    <div>
                                                        <div class="text-xs text-slate-500 dark:text-slate-400">{{ __('frontend.domain') }}</div>
                                                        <div class="text-sm font-medium text-slate-900 dark:text-white">{{ $item['domain'] ?? '-' }}</div>
                                                    </div>
                                                </div>

                                                <!-- Billing Cycle -->
                                                <div class="flex items-center gap-2 p-2.5 bg-slate-50 dark:bg-slate-700/50 rounded-lg">
                                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    <div>
                                                        <div class="text-xs text-slate-600 dark:text-slate-400">{{ __('frontend.billing_cycle') }}</div>
                                                        <div class="text-sm font-bold text-slate-900 dark:text-white">{{ __('frontend.' . ($item['billing_cycle'] ?? 'monthly')) }}</div>
                                                    </div>
                                                </div>

                                                <!-- Datacenter Info -->
                                                @if(isset($item['datacenter_name']) && $item['datacenter_name'])
                                                <div class="flex items-center gap-2 p-3 bg-slate-50 dark:bg-slate-700/30 rounded-lg mb-3">
                                                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <div>
                                                        <div class="text-xs text-slate-600 dark:text-slate-400">{{ __('frontend.datacenter_location') }}</div>
                                                        <div class="text-sm font-bold text-slate-900 dark:text-white">
                                                            {{ $item['datacenter_name'] }}
                                                            @if(isset($item['datacenter_price']) && $item['datacenter_price'] > 0)
                                                                <span class="text-xs text-purple-600 dark:text-purple-400">(+${{ number_format($item['datacenter_price'], 2) }})</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif

                                                <!-- cPanel Accounts (Reseller Hosting) -->
                                                @if(isset($item['cpanel_accounts']) && $item['cpanel_accounts'] > 0)
                                                <div class="flex items-center gap-2 p-3 bg-slate-50 dark:bg-slate-700/30 rounded-lg mb-3">
                                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                    </svg>
                                                    <div>
                                                        <div class="text-xs text-slate-600 dark:text-slate-400">{{ __('frontend.cpanel_accounts') }}</div>
                                                        <div class="text-sm font-bold text-slate-900 dark:text-white">
                                                            {{ $item['cpanel_accounts'] }} {{ __('frontend.accounts') }}
                                                            @if(isset($item['cpanel_tier_price']) && $item['cpanel_tier_price'] > 0)
                                                                <span class="text-xs text-blue-600 dark:text-blue-400">(+${{ number_format($item['cpanel_tier_price'], 2) }})</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif

                                                <!-- Additional Options -->
                                                @if(($item['ssl'] ?? false) || ($item['backups'] ?? false) || ($item['privacy'] ?? false))
                                                <div class="flex flex-wrap gap-2 mb-3">
                                                    @if($item['ssl'] ?? false)
                                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 text-xs font-bold rounded">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                                        </svg>
                                                        SSL
                                                    </span>
                                                    @endif
                                                    @if($item['backups'] ?? false)
                                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 text-xs font-bold rounded">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                                                        </svg>
                                                        {{ __('frontend.daily_backups') }}
                                                    </span>
                                                    @endif
                                                    @if($item['privacy'] ?? false)
                                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-xs font-medium rounded">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                                        </svg>
                                                        {{ __('frontend.domain_privacy') }}
                                                    </span>
                                                    @endif
                                                </div>
                                                @endif
                                            </div>

                                            <!-- Price & Remove -->
                                            <div class="flex flex-col items-end gap-3">
                                                <div class="text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}">
                                                    <div class="mb-2">
                                                        <div class="text-xl font-bold text-slate-900 dark:text-white">
                                                            ${{ number_format($item['price'], 2) }}
                                                        </div>
                                                        <div class="text-xs text-slate-500 dark:text-slate-400">
                                                            {{ __('frontend.hosting_price') }}
                                                        </div>
                                                    </div>
                                                    @if(isset($item['setup_fee']) && $item['setup_fee'] > 0)
                                                    <div class="mb-2">
                                                        <div class="text-sm font-medium text-slate-600 dark:text-slate-300">
                                                            ${{ number_format($item['setup_fee'], 2) }}
                                                        </div>
                                                        <div class="text-xs text-slate-500 dark:text-slate-400">
                                                            {{ __('frontend.setup_fee') }}
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                                <button onclick="removeFromCart('{{ $key }}')" class="p-2 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30 text-red-600 dark:text-red-400 rounded-lg transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif(($item['type'] ?? 'domain') == 'vps')
                                {{-- VPS Item --}}
                                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-5 border border-slate-200 dark:border-slate-700">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex-1">
                                            <!-- VPS Icon & Type -->
                                            <div class="flex items-center gap-3 mb-3">
                                                <div class="w-10 h-10 bg-slate-100 dark:bg-slate-700 rounded-lg flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                                                    </svg>
                                                </div>
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-xs font-medium rounded-md">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                                                    </svg>
                                                    VPS {{ __('frontend.hosting') }}
                                                </span>
                                            </div>

                                            <!-- VPS Name -->
                                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-3">
                                                {{ $item['product_name'] ?? __('frontend.vps_plan') }}
                                            </h3>

                                            <!-- VPS Specifications -->
                                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-3">
                                                <!-- CPU -->
                                                <div class="flex items-center gap-2 p-3 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                                                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                                                    </svg>
                                                    <div>
                                                        <div class="text-xs text-slate-600 dark:text-slate-400">{{ __('frontend.cpu') }}</div>
                                                        <div class="text-sm font-bold text-slate-900 dark:text-white">{{ $item['vcpu_count'] ?? '-' }} {{ __('frontend.cores') }}</div>
                                                    </div>
                                                </div>

                                                <!-- RAM -->
                                                <div class="flex items-center gap-2 p-3 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                                                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                                                    </svg>
                                                    <div>
                                                        <div class="text-xs text-slate-600 dark:text-slate-400">{{ __('frontend.ram') }}</div>
                                                        <div class="text-sm font-bold text-slate-900 dark:text-white">
                                                            {{ isset($item['ram_mb']) ? ($item['ram_mb'] >= 1024 ? ($item['ram_mb'] / 1024) . ' GB' : $item['ram_mb'] . ' MB') : '-' }}
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Storage -->
                                                <div class="flex items-center gap-2 p-3 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                                                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                                                    </svg>
                                                    <div>
                                                        <div class="text-xs text-slate-600 dark:text-slate-400">{{ __('frontend.storage') }}</div>
                                                        <div class="text-sm font-bold text-slate-900 dark:text-white">{{ $item['storage_gb'] ?? '-' }} GB SSD</div>
                                                    </div>
                                                </div>

                                                <!-- Bandwidth -->
                                                <div class="flex items-center gap-2 p-3 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                                                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                    </svg>
                                                    <div>
                                                        <div class="text-xs text-slate-600 dark:text-slate-400">{{ __('frontend.bandwidth') }}</div>
                                                        <div class="text-sm font-bold text-slate-900 dark:text-white">
                                                            {{ isset($item['bandwidth_gb']) ? ($item['bandwidth_gb'] >= 1024 ? ($item['bandwidth_gb'] / 1024) . ' TB' : $item['bandwidth_gb'] . ' GB') : '-' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Additional VPS Info -->
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                                                <!-- Hostname -->
                                                @if(isset($item['hostname']))
                                                <div class="flex items-center gap-2 p-3 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                                                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                                    </svg>
                                                    <div>
                                                        <div class="text-xs text-slate-600 dark:text-slate-400">{{ __('frontend.hostname') }}</div>
                                                        <div class="text-sm font-bold text-slate-900 dark:text-white">{{ $item['hostname'] }}</div>
                                                    </div>
                                                </div>
                                                @endif

                                                <!-- Billing Cycle -->
                                                <div class="flex items-center gap-2 p-3 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                                                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                    <div>
                                                        <div class="text-xs text-slate-600 dark:text-slate-400">{{ __('frontend.billing_cycle') }}</div>
                                                        <div class="text-sm font-bold text-slate-900 dark:text-white">{{ __('frontend.' . ($item['billing_cycle'] ?? 'monthly')) }}</div>
                                                    </div>
                                                </div>
                                                
                                                <!-- IPv4 Status -->
                                                <div class="flex items-center gap-2 p-3 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                                                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <div>
                                                        <div class="text-xs text-slate-600 dark:text-slate-400">{{ __('frontend.public_ipv4') }}</div>
                                                        <div class="text-xs text-slate-500 dark:text-slate-400">{{ __('frontend.included') }}</div>
                                                    </div>
                                                </div>
                                                
                                                <!-- IPv6 Status -->
                                                @if(isset($item['enable_ipv6']) && $item['enable_ipv6'])
                                                <div class="flex items-center gap-2 p-3 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                                                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <div>
                                                        <div class="text-xs text-slate-600 dark:text-slate-400">{{ __('frontend.public_ipv6') }}</div>
                                                        <div class="text-xs text-slate-500 dark:text-slate-400">{{ __('frontend.free') }}</div>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Price & Remove -->
                                        <div class="flex flex-col items-end gap-3">
                                            <div class="text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}">
                                                <div class="mb-2">
                                                    <div class="text-xl font-bold text-slate-900 dark:text-white">
                                                        ${{ number_format($item['price'], 2) }}
                                                    </div>
                                                    <div class="text-xs text-slate-500 dark:text-slate-400">
                                                        {{ __('frontend.vps_price') }}
                                                    </div>
                                                </div>
                                                @if(isset($item['setup_fee']) && $item['setup_fee'] > 0)
                                                <div class="mb-2">
                                                    <div class="text-sm font-medium text-slate-600 dark:text-slate-300">
                                                        ${{ number_format($item['setup_fee'], 2) }}
                                                    </div>
                                                    <div class="text-xs text-slate-500 dark:text-slate-400">
                                                        {{ __('frontend.setup_fee') }}
                                                    </div>
                                                </div>
                                                @endif
                                                @if(isset($item['enable_backups']) && $item['enable_backups'] && isset($item['backup_cost']) && $item['backup_cost'] > 0)
                                                <div class="mb-2 text-xs text-slate-500">
                                                    <span class="font-medium">${{ number_format($item['backup_cost'], 2) }}</span> {{ __('frontend.automatic_backups') }}
                                                </div>
                                                @endif
                                                @if(isset($item['additional_ipv4']) && $item['additional_ipv4'] > 0 && isset($item['ipv4_cost']) && $item['ipv4_cost'] > 0)
                                                <div class="mb-2 text-xs text-slate-500">
                                                    <span class="font-medium">${{ number_format($item['ipv4_cost'], 2) }}</span> {{ $item['additional_ipv4'] }} {{ __('frontend.additional_ips') }}
                                                </div>
                                                @endif
                                                @if(isset($item['enable_ddos']) && $item['enable_ddos'] && isset($item['ddos_cost']) && $item['ddos_cost'] > 0)
                                                <div class="mb-2 text-xs text-slate-500">
                                                    <span class="font-medium">${{ number_format($item['ddos_cost'], 2) }}</span> {{ __('frontend.ddos_protection') }}
                                                </div>
                                                @endif
                                            </div>
                                            <button onclick="removeFromCart('{{ $key }}')" class="p-2 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30 text-red-600 dark:text-red-400 rounded-lg transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @elseif(($item['type'] ?? 'domain') == 'dedicated')
                                {{-- Dedicated Server Item --}}
                                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-5 border border-slate-200 dark:border-slate-700">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex-1">
                                            <!-- Dedicated Server Icon & Type -->
                                            <div class="flex items-center gap-3 mb-3">
                                                <div class="w-10 h-10 bg-slate-100 dark:bg-slate-700 rounded-lg flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                                                    </svg>
                                                </div>
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-xs font-medium rounded-md">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                                                    </svg>
                                                    {{ __('frontend.dedicated_server') }}
                                                </span>
                                            </div>

                                            <!-- Server Name -->
                                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-3">
                                                {{ $item['product_name'] ?? __('frontend.dedicated_plan') }}
                                            </h3>

                                            <!-- Server Specifications -->
                                            <div class="grid grid-cols-2 md:grid-cols-4 gap-2 mb-3">
                                                <!-- CPU -->
                                                <div class="flex items-center gap-2 p-2.5 bg-slate-50 dark:bg-slate-700/50 rounded-lg">
                                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                                                    </svg>
                                                    <div>
                                                        <div class="text-xs text-slate-500 dark:text-slate-400">{{ __('frontend.cpu') }}</div>
                                                        <div class="text-sm font-medium text-slate-900 dark:text-white">{{ $item['cpu_cores'] ?? '-' }} {{ __('frontend.cores') }}</div>
                                                    </div>
                                                </div>

                                                <!-- RAM -->
                                                <div class="flex items-center gap-2 p-2.5 bg-slate-50 dark:bg-slate-700/50 rounded-lg">
                                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                                                    </svg>
                                                    <div>
                                                        <div class="text-xs text-slate-500 dark:text-slate-400">{{ __('frontend.ram') }}</div>
                                                        <div class="text-sm font-bold text-slate-900 dark:text-white">{{ $item['ram_gb'] ?? '-' }} GB</div>
                                                    </div>
                                                </div>

                                                <!-- Storage -->
                                                    <div class="flex items-center gap-2 p-3 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                                                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                                                        </svg>
                                                        <div>
                                                            <div class="text-xs text-slate-600 dark:text-slate-400">{{ __('frontend.storage') }}</div>
                                                            <div class="text-sm font-bold text-slate-900 dark:text-white">{{ $item['storage_total_gb'] ?? '-' }} GB</div>
                                                        </div>
                                                    </div>

                                                    <!-- Bandwidth -->
                                                    <div class="flex items-center gap-2 p-3 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                                                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                        </svg>
                                                        <div>
                                                            <div class="text-xs text-slate-600 dark:text-slate-400">{{ __('frontend.bandwidth') }}</div>
                                                            <div class="text-sm font-bold text-slate-900 dark:text-white">{{ $item['bandwidth'] ?? '-' }}</div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Additional Server Info -->
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                                                    <!-- Hostname -->
                                                    @if(isset($item['hostname']))
                                                    <div class="flex items-center gap-2 p-3 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                                                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                                        </svg>
                                                        <div>
                                                            <div class="text-xs text-slate-600 dark:text-slate-400">{{ __('frontend.hostname') }}</div>
                                                            <div class="text-sm font-bold text-slate-900 dark:text-white">{{ $item['hostname'] }}</div>
                                                        </div>
                                                    </div>
                                                    @endif

                                                    <!-- Billing Cycle -->
                                                    <div class="flex items-center gap-2 p-3 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                                                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                        <div>
                                                            <div class="text-xs text-slate-600 dark:text-slate-400">{{ __('frontend.billing_cycle') }}</div>
                                                            <div class="text-sm font-bold text-slate-900 dark:text-white">{{ __('frontend.' . ($item['billing_cycle'] ?? 'monthly')) }}</div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- IPv4 -->
                                                    <div class="flex items-center gap-2 p-3 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                                                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        <div>
                                                            <div class="text-xs text-slate-600 dark:text-slate-400">{{ __('frontend.public_ipv4') }}</div>
                                                            <div class="text-xs text-slate-500 dark:text-slate-400">1 {{ __('frontend.included') }}</div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- IPv6 Status -->
                                                    @if(isset($item['enable_ipv6']) && $item['enable_ipv6'])
                                                    <div class="flex items-center gap-2 p-3 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                                                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        <div>
                                                            <div class="text-xs text-slate-600 dark:text-slate-400">{{ __('frontend.public_ipv6') }}</div>
                                                            <div class="text-xs text-slate-500 dark:text-slate-400">{{ __('frontend.free') }}</div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>

                                            <!-- Price & Remove -->
                                            <div class="flex flex-col items-end gap-3">
                                                <div class="text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}">
                                                    <div class="mb-2">
                                                        <div class="text-xl font-bold text-slate-900 dark:text-white">
                                                            ${{ number_format($item['price'], 2) }}
                                                        </div>
                                                        <div class="text-xs text-slate-500 dark:text-slate-400">
                                                            {{ __('frontend.dedicated_price') }}
                                                        </div>
                                                    </div>
                                                    @if(isset($item['setup_fee']) && $item['setup_fee'] > 0)
                                                    <div class="mb-2">
                                                        <div class="text-sm font-medium text-slate-600 dark:text-slate-300">
                                                            ${{ number_format($item['setup_fee'], 2) }}
                                                        </div>
                                                        <div class="text-xs text-slate-500 dark:text-slate-400">
                                                            {{ __('frontend.setup_fee') }}
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @if(isset($item['additional_ipv4']) && $item['additional_ipv4'] > 0 && isset($item['ipv4_cost']) && $item['ipv4_cost'] > 0)
                                                    <div class="mb-2 text-xs text-slate-500">
                                                        <span class="font-medium">${{ number_format($item['ipv4_cost'], 2) }}</span> {{ $item['additional_ipv4'] }} {{ __('frontend.additional_ips') }}
                                                    </div>
                                                    @endif
                                                </div>
                                                <button onclick="removeFromCart('{{ $key }}')" class="p-2 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30 text-red-600 dark:text-red-400 rounded-lg transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                {{-- Domain Item --}}
                                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-5 border border-slate-200 dark:border-slate-700" data-domain-key="{{ $key }}">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex-1">
                                            <!-- Domain Icon & Type -->
                                            <div class="flex items-center gap-3 mb-3">
                                                <div class="w-10 h-10 bg-slate-100 dark:bg-slate-700 rounded-lg flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                                    </svg>
                                                </div>
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-xs font-medium rounded-md">
                                                    @if(isset($item['action']) && $item['action'] == 'register')
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                        </svg>
                                                        {{ __('frontend.domain_registration') }}
                                                    @elseif(isset($item['action']) && $item['action'] == 'transfer')
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                                        </svg>
                                                        {{ __('frontend.domain_transfer') }}
                                                    @else
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                        </svg>
                                                        {{ __('frontend.domain_renewal') }}
                                                    @endif
                                                </span>
                                            </div>

                                            <!-- Domain Name -->
                                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-3 break-all">
                                                {{ $item['domain'] ?? $item['product_name'] ?? 'Domain' }}
                                            </h3>

                                            <!-- TLD Badge -->
                                            @if(isset($item['tld']) && $item['tld'])
                                            <div class="mb-3">
                                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-slate-100 dark:bg-slate-700/50 text-slate-600 dark:text-slate-300 rounded text-sm">
                                                    .{{ $item['tld'] }}
                                                </span>
                                            </div>
                                            @endif

                                            <!-- Row 1: Registration Period + Privacy Protection (2 Columns) -->
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-3">
                                                <!-- Years Selection Column -->
                                                <div>
                                                    <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-2">
                                                        {{ __('frontend.registration_period') ?? 'Registration Period' }}
                                                    </label>
                                                    <div class="flex items-center gap-2">
                                                        <button onclick="updateYears('{{ $key }}', -1)" class="w-8 h-8 flex items-center justify-center bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 rounded-lg transition-colors">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                                            </svg>
                                                        </button>
                                                        <div class="flex-1 text-center">
                                                            <span id="years-{{ $key }}" class="text-lg font-bold text-slate-900 dark:text-white">
                                                                {{ $item['years'] ?? 1 }}
                                                            </span>
                                                            <span class="text-sm text-slate-600 dark:text-slate-400 ml-1">
                                                                {{ __('frontend.years') ?? 'Years' }}
                                                            </span>
                                                        </div>
                                                        <button onclick="updateYears('{{ $key }}', 1)" class="w-8 h-8 flex items-center justify-center bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 rounded-lg transition-colors">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>

                                                <!-- Privacy Protection Column -->
                                                <div>
                                                    <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-2">
                                                        {{ __('frontend.privacy_protection') ?? 'Privacy Protection' }}
                                                    </label>
                                                    <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-700/30 rounded-lg">
                                                        <div class="flex items-center gap-2">
                                                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                                            </svg>
                                                            <div>
                                                                <div class="text-sm font-bold text-slate-900 dark:text-white">
                                                                    {{ __('frontend.privacy_protection') ?? 'Privacy Protection' }}
                                                                </div>
                                                                <div class="text-xs text-slate-500 dark:text-slate-400">
                                                                    {{ __('frontend.free') ?? 'FREE' }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <label class="relative inline-flex items-center cursor-pointer">
                                                            <input type="checkbox" id="privacy-{{ $key }}" class="sr-only peer" {{ ($item['privacy'] ?? true) ? 'checked' : '' }} onchange="togglePrivacy('{{ $key }}')">
                                                            <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-slate-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-blue-600"></div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Row 2: DNS Settings (2 Columns for Default/Custom selection) -->
                                            <div class="mb-3">
                                                <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-2">
                                                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                                                    </svg>
                                                    {{ __('frontend.dns_settings') ?? 'DNS Settings' }}
                                                </label>
                                                
                                                <!-- DNS Type Selection in 2 Columns -->
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                    <label class="flex items-center p-3 bg-white dark:bg-slate-800 rounded-lg border-2 border-slate-200 dark:border-slate-700 cursor-pointer hover:border-blue-500 dark:hover:border-blue-500 transition-colors">
                                                        <input type="radio" name="dns-type-{{ $key }}" value="default" class="w-4 h-4 text-blue-600" {{ (!isset($item['dns_type']) || $item['dns_type'] == 'default') ? 'checked' : '' }} onchange="toggleDNSType('{{ $key }}', 'default')">
                                                        <span class="ml-2 text-sm font-medium text-slate-900 dark:text-white">
                                                            {{ __('frontend.use_default_dns') ?? 'Default' }}
                                                        </span>
                                                    </label>
                                                    
                                                    <label class="flex items-center p-3 bg-white dark:bg-slate-800 rounded-lg border-2 border-slate-200 dark:border-slate-700 cursor-pointer hover:border-blue-500 dark:hover:border-blue-500 transition-colors">
                                                        <input type="radio" name="dns-type-{{ $key }}" value="custom" class="w-4 h-4 text-blue-600" {{ (isset($item['dns_type']) && $item['dns_type'] == 'custom') ? 'checked' : '' }} onchange="toggleDNSType('{{ $key }}', 'custom')">
                                                        <span class="ml-2 text-sm font-medium text-slate-900 dark:text-white">
                                                            {{ __('frontend.use_custom_dns') ?? 'Custom' }}
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>

                                            <!-- Custom DNS Input (Full Width - Hidden by default) -->
                                            <div id="custom-dns-{{ $key }}" class="mb-3 {{ (!isset($item['dns_type']) || $item['dns_type'] == 'default') ? 'hidden' : '' }}">
                                                <div class="text-xs text-slate-600 dark:text-slate-400 mb-2">
                                                    <span class="text-red-500">*</span> {{ __('frontend.dns_required_note') ?? 'At least 2 DNS servers required' }}
                                                </div>
                                                
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                                    <input type="text" id="dns1-{{ $key }}" placeholder="Primary DNS * (ns1.example.com)" value="{{ $item['dns1'] ?? '' }}" class="w-full px-3 py-2 text-sm bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 required-dns" oninput="preventArabicInput(this)" onchange="updateDNS('{{ $key }}', 1, this.value)" required>
                                                    
                                                    <input type="text" id="dns2-{{ $key }}" placeholder="Secondary DNS * (ns2.example.com)" value="{{ $item['dns2'] ?? '' }}" class="w-full px-3 py-2 text-sm bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 required-dns" oninput="preventArabicInput(this)" onchange="updateDNS('{{ $key }}', 2, this.value)" required>
                                                    
                                                    <input type="text" id="dns3-{{ $key }}" placeholder="Third DNS (ns3.example.com)" value="{{ $item['dns3'] ?? '' }}" class="w-full px-3 py-2 text-sm bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" oninput="preventArabicInput(this)" onchange="updateDNS('{{ $key }}', 3, this.value)">
                                                    
                                                    <input type="text" id="dns4-{{ $key }}" placeholder="Fourth DNS (ns4.example.com)" value="{{ $item['dns4'] ?? '' }}" class="w-full px-3 py-2 text-sm bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" oninput="preventArabicInput(this)" onchange="updateDNS('{{ $key }}', 4, this.value)">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Enhanced Price & Remove -->
                                        <div class="flex flex-col items-end gap-4">
                                            <div class="text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}" data-price-section>
                                                <!-- Item Total Price (Dynamic) -->
                                                @if(isset($item['is_free_with_hosting']) && $item['is_free_with_hosting'])
                                                <!-- Free Domain with Hosting -->
                                                <div class="mb-3">
                                                    <div class="text-xl font-bold text-slate-900 dark:text-white">
                                                        {{ __('frontend.free') }}
                                                    </div>
                                                    <div class="text-xs text-slate-500 dark:text-slate-400">
                                                        {{ __('frontend.with_hosting_plan') }}
                                                    </div>
                                                    @if(isset($item['original_price']) && $item['original_price'] > 0)
                                                    <div class="text-xs text-slate-400 dark:text-slate-500 line-through mt-1">
                                                        ${{ number_format($item['original_price'], 2) }}
                                                    </div>
                                                    @endif
                                                </div>
                                                @else
                                                <!-- Regular Domain Price -->
                                                <div class="mb-3">
                                                    <div class="text-xl font-bold text-slate-900 dark:text-white" id="item-total-{{ $key }}" data-registration-price="{{ $item['price'] }}" data-renewal-price="{{ $item['renewal_price'] ?? $item['price'] }}">
                                                        @php
                                                            $years = $item['years'] ?? 1;
                                                            $registrationPrice = $item['price'];
                                                            $renewalPrice = $item['renewal_price'] ?? $item['price'];
                                                            $itemTotal = $years == 1 ? $registrationPrice : ($registrationPrice + ($renewalPrice * ($years - 1)));
                                                        @endphp
                                                        ${{ number_format($itemTotal, 2) }}
                                                    </div>
                                                    <div class="text-xs text-slate-500 dark:text-slate-400">
                                                        {{ __('frontend.total_for') ?? 'Total for' }} <span id="years-label-{{ $key }}">{{ $item['years'] ?? 1 }}</span> {{ ($item['years'] ?? 1) == 1 ? __('frontend.year') : __('frontend.years') }}
                                                    </div>
                                                </div>
                                                
                                                <!-- Registration/Purchase Price -->
                                                <div class="mb-2">
                                                    <div class="text-lg font-bold text-slate-700 dark:text-slate-300 mb-1">
                                                        ${{ number_format($item['price'], 2) }}
                                                    </div>
                                                    <div class="text-xs text-slate-500 dark:text-slate-400 font-medium">
                                                        {{ __('frontend.registration_price') ?? 'Registration Price' }}
                                                    </div>
                                                </div>
                                                
                                                <!-- Renewal Price -->
                                                @if(isset($item['renewal_price']) && $item['renewal_price'] != $item['price'])
                                                <div class="pt-2 border-t border-slate-200 dark:border-slate-700">
                                                    <div class="flex items-center gap-2 mb-1">
                                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                        </svg>
                                                        <span class="text-lg font-bold text-slate-700 dark:text-slate-300">
                                                            ${{ number_format($item['renewal_price'], 2) }}
                                                        </span>
                                                    </div>
                                                    <div class="text-xs text-slate-500 dark:text-slate-400">
                                                        {{ __('frontend.renewal_price') ?? 'Renewal Price' }}
                                                    </div>
                                                </div>
                                                @elseif(isset($item['renewal_price']))
                                                <div class="pt-2 border-t border-slate-200 dark:border-slate-700">
                                                    <div class="flex items-center gap-1 text-xs text-slate-500 dark:text-slate-400">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        <span class="font-medium">{{ __('frontend.same_renewal_price') ?? 'Same renewal price' }}</span>
                                                    </div>
                                                </div>
                                                @endif
                                                @endif
                                            </div>
                                            <button onclick="removeFromCart('{{ $key }}')" class="p-2 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30 text-red-600 dark:text-red-400 rounded-lg transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <!-- Order Summary (Sticky) -->
                    <div class="lg:col-span-1" id="order-summary-column">
                        <div id="order-summary" class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-5 border border-slate-200 dark:border-slate-700">
                                <!-- Header -->
                                <div class="flex items-center gap-2 mb-4 pb-4 border-b border-slate-200 dark:border-slate-700">
                                    <div class="w-8 h-8 bg-slate-100 dark:bg-slate-700 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-base font-bold text-slate-900 dark:text-white">
                                        {{ __('frontend.order_summary') ?? 'Order Summary' }}
                                    </h3>
                                </div>

                                <!-- Items Count -->
                                <div class="flex items-center justify-between mb-3 p-2 bg-slate-50 dark:bg-slate-700/50 rounded-lg">
                                    <span class="text-xs font-medium text-slate-600 dark:text-slate-400">{{ __('frontend.total_items') ?? 'Total Items' }}</span>
                                    <span class="text-lg font-bold text-slate-900 dark:text-white" id="cart-items-count" data-cart-count>{{ count($cart) }}</span>
                                </div>

                                <!-- Price Breakdown -->
                                <div class="space-y-2 mb-3 pb-3 border-b border-slate-200 dark:border-slate-700">
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-slate-600 dark:text-slate-400">{{ __('frontend.subtotal') ?? 'Subtotal' }}</span>
                                        <span class="font-medium text-slate-900 dark:text-white" data-cart-subtotal>${{ number_format($subtotal ?? $total, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between items-center text-sm">
                                        <div class="flex items-center gap-1">
                                            <span class="text-slate-600 dark:text-slate-400">{{ __('frontend.tax') ?? 'Tax' }}</span>
                                            <span class="text-xs bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 px-1.5 py-0.5 rounded font-medium">{{ __('frontend.free') ?? 'FREE' }}</span>
                                        </div>
                                        <span class="font-medium text-slate-900 dark:text-white">$0.00</span>
                                    </div>
                                </div>

                                <!-- Coupon Code Section -->
                                <div class="mb-4 pb-4 border-b border-slate-200 dark:border-slate-700">
                                    <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-2">
                                        <svg class="w-3.5 h-3.5 inline-block {{ app()->getLocale() == 'ar' ? 'ml-1' : 'mr-1' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                        {{ __('frontend.coupon_code') ?? 'Coupon Code' }}
                                    </label>
                                    <div class="flex gap-2 items-stretch">
                                        <input type="text" id="coupon-input" placeholder="{{ __('frontend.enter_coupon') ?? 'Enter code' }}" class="flex-1 min-w-0 px-3 py-2 text-sm bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-slate-400 focus:border-slate-400 transition-all" value="{{ session('coupon_code', '') }}" {{ session('coupon_code') ? 'disabled' : '' }}>
                                        <button onclick="applyCoupon()" id="apply-coupon-btn" class="flex-shrink-0 px-4 py-2 bg-slate-800 hover:bg-slate-900 dark:bg-slate-600 dark:hover:bg-slate-500 text-white text-sm font-medium rounded-lg transition-colors whitespace-nowrap">
                                            {{ __('frontend.apply') ?? 'Apply' }}
                                        </button>
                                    </div>
                                    
                                    <!-- Coupon Success Message -->
                                    <div id="coupon-success" class="{{ session('coupon_description') ? '' : 'hidden' }} mt-2 p-2 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                        <div class="flex items-center gap-2 text-xs">
                                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="text-green-700 dark:text-green-300 font-medium" id="coupon-success-text">{{ session('coupon_description') }}</span>
                                            <button onclick="removeCoupon()" class="ms-auto text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Coupon Error Message -->
                                    <div id="coupon-error" class="hidden mt-2 p-2 bg-red-50 dark:bg-red-900/20 rounded-lg">
                                        <p class="text-xs text-red-700 dark:text-red-300 font-bold" id="coupon-error-text"></p>
                                    </div>
                                    
                                    <!-- Discount Display -->
                                    <div id="discount-display" class="{{ ($discount ?? 0) > 0 ? '' : 'hidden' }}">
                                        <div class="mt-2 flex justify-between items-center text-sm">
                                            <span class="text-green-600 dark:text-green-400 font-bold">{{ __('frontend.discount') ?? 'Discount' }}</span>
                                            <span class="text-green-600 dark:text-green-400 font-bold" id="discount-amount">-${{ number_format($discount ?? 0, 2) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Subtotal Before Discount (shown only when coupon applied) -->
                                <div id="subtotal-before-discount" class="{{ ($discount ?? 0) > 0 ? '' : 'hidden' }} mb-3 pb-3 border-b border-slate-200 dark:border-slate-700">
                                    <div class="flex justify-between items-center">
                                        <span class="text-slate-600 dark:text-slate-400 text-sm font-medium">{{ __('frontend.subtotal_before_discount') ?? 'Subtotal Before Discount' }}</span>
                                        <span class="text-slate-900 dark:text-white font-bold line-through decoration-2 decoration-red-500" data-cart-subtotal-display>${{ number_format($subtotal ?? $total, 2) }}</span>
                                    </div>
                                </div>

                                <!-- Grand Total -->
                                <div class="mb-4 p-3 bg-slate-800 dark:bg-slate-700 rounded-xl">
                                    <div class="flex justify-between items-center">
                                        <span class="text-slate-300 text-xs font-medium">{{ __('frontend.total_to_pay') ?? 'Total to Pay' }}</span>
                                        <span class="text-xl font-bold text-white" data-cart-total>${{ number_format($total, 2) }}</span>
                                    </div>
                                    @if(($discount ?? 0) > 0)
                                    <div class="mt-2 pt-2 border-t border-slate-600">
                                        <div class="flex items-center justify-center gap-2 text-green-400 text-xs">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="font-medium">{{ __('frontend.you_save') ?? 'You Save' }}: ${{ number_format($discount, 2) }}</span>
                                        </div>
                                    </div>
                                    @endif
                                </div>

                                <!-- Action Buttons -->
                                <div class="space-y-2 mb-4">
                                    <button onclick="proceedToCheckout()" class="block w-full py-3 bg-slate-800 hover:bg-slate-900 dark:bg-slate-600 dark:hover:bg-slate-500 text-white text-center text-sm font-medium rounded-lg transition-colors">
                                        {{ __('frontend.proceed_to_checkout') }}
                                    </button>
                                    <a href="{{ route('domains.search') }}" class="block w-full py-3 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-900 dark:text-white text-center text-sm font-medium rounded-lg transition-colors">
                                        {{ __('frontend.continue_shopping') }}
                                    </a>
                                </div>

                                <!-- Trust Badges -->
                                <div class="flex items-center justify-center gap-4 pt-3 border-t border-slate-200 dark:border-slate-700">
                                    <div class="flex items-center gap-1 text-slate-500 dark:text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                        <span class="text-xs">{{ __('frontend.secure_checkout') ?? 'Secure' }}</span>
                                    </div>
                                    <div class="flex items-center gap-1 text-slate-500 dark:text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                        <span class="text-xs">SSL</span>
                                    </div>
                                </div>

                                <!-- Payment Methods -->
                                <div class="mt-4 pt-4 border-t border-slate-200 dark:border-slate-700">
                                    <h4 class="text-xs font-medium text-slate-500 dark:text-slate-400 mb-3 text-center">
                                        {{ __('frontend.payment_methods') }}
                                    </h4>
                                    <div class="flex flex-wrap items-center justify-center gap-2">
                                        @if(isset($fawaterakPaymentMethods) && count($fawaterakPaymentMethods) > 0)
                                            @foreach($fawaterakPaymentMethods as $method)
                                                <div class="w-12 h-8 bg-slate-50 dark:bg-slate-700/50 rounded p-1 flex items-center justify-center border border-slate-200 dark:border-slate-600">
                                                    <img src="{{ $method['logo'] }}" 
                                                         alt="{{ $method['name_en'] }}" 
                                                         class="max-w-full max-h-full object-contain"
                                                         loading="lazy">
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="w-12 h-8 bg-slate-50 dark:bg-slate-700/50 rounded p-1 flex items-center justify-center border border-slate-200 dark:border-slate-600">
                                                <svg class="w-full h-full text-slate-400" fill="currentColor" viewBox="0 0 48 48">
                                                    <path d="M44 4H4C1.79 4 0 5.79 0 8v32c0 2.21 1.79 4 4 4h40c2.21 0 4-1.79 4-4V8c0-2.21-1.79-4-4-4zm0 36H4V12h40v28z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <!-- Mobile Fixed Bottom Bar -->
                <div class="lg:hidden fixed bottom-0 left-0 right-0 z-50 bg-white dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700 shadow-[0_-4px_20px_rgba(0,0,0,0.1)] safe-area-bottom">
                    <div class="container mx-auto px-4 py-3">
                        <div class="flex items-center justify-between gap-4">
                            <!-- Price Summary -->
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-slate-500 dark:text-slate-400">{{ __('frontend.total') ?? 'Total' }}</span>
                                    <span class="text-xs text-slate-400">•</span>
                                    <span class="text-xs text-slate-500 dark:text-slate-400" data-mobile-cart-count>{{ count($cart) }} {{ __('frontend.items') ?? 'items' }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-lg font-bold text-slate-900 dark:text-white" data-mobile-cart-total>${{ number_format($total, 2) }}</span>
                                    @if(($discount ?? 0) > 0)
                                    <span class="text-xs line-through text-slate-400">${{ number_format($subtotal ?? $total, 2) }}</span>
                                    <span class="text-xs bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 px-1.5 py-0.5 rounded font-medium">-${{ number_format($discount, 2) }}</span>
                                    @endif
                                </div>
                            </div>
                            <!-- Checkout Button -->
                            <button onclick="proceedToCheckout()" class="flex-shrink-0 px-6 py-3 bg-slate-800 hover:bg-slate-900 dark:bg-slate-600 dark:hover:bg-slate-500 text-white text-sm font-medium rounded-xl transition-colors flex items-center gap-2">
                                <span>{{ __('frontend.checkout') ?? 'Checkout' }}</span>
                                <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

@push('styles')
<style>
/* Shake Animation for Error */
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
    20%, 40%, 60%, 80% { transform: translateX(5px); }
}

.animate-shake {
    animation: shake 0.5s ease-in-out;
}

/* Safe area for mobile bottom bar */
.safe-area-bottom {
    padding-bottom: env(safe-area-inset-bottom, 0);
}

/* Add padding to content on mobile to prevent overlap with fixed bar */
@media (max-width: 1023px) {
    section.relative {
        padding-bottom: 100px !important;
    }
}

/* Sticky Order Summary - Simple CSS Solution */
@media (min-width: 1024px) {
    #order-summary-column {
        position: -webkit-sticky !important;
        position: sticky !important;
        top: 85px !important;
        align-self: flex-start !important;
        height: fit-content !important;
        z-index: 30;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Show DNS Toast Notification with custom message
function showDNSToast(customMessage = null, customSubtitle = null) {
    const toast = document.getElementById('dns-toast');
    const messageElement = document.getElementById('dns-toast-message');
    const subtitleElement = document.getElementById('dns-toast-subtitle');
    
    // Update message if provided
    if (customMessage) {
        messageElement.textContent = customMessage;
    } else {
        messageElement.textContent = '{{ __("frontend.dns_no_arabic") ?? "Arabic characters are not allowed in DNS fields" }}';
    }
    
    // Update or hide subtitle
    if (customSubtitle !== null) {
        subtitleElement.textContent = customSubtitle;
        subtitleElement.style.display = customSubtitle ? 'block' : 'none';
    } else {
        subtitleElement.textContent = '{{ __("frontend.english_only_allowed") ?? "Only English characters allowed" }}';
        subtitleElement.style.display = 'block';
    }
    
    toast.classList.remove('hidden');
    toast.classList.add('animate-shake');
    
    // Auto hide after 5 seconds (longer for validation message)
    setTimeout(() => {
        hideDNSToast();
    }, 5000);
}

// Hide DNS Toast Notification
function hideDNSToast() {
    const toast = document.getElementById('dns-toast');
    toast.classList.add('opacity-0', 'translate-y-[-20px]');
    
    setTimeout(() => {
        toast.classList.add('hidden');
        toast.classList.remove('opacity-0', 'translate-y-[-20px]', 'animate-shake');
    }, 300);
}

// Store cart key and button for confirmation
let pendingRemoveKey = null;
let pendingRemoveButton = null;

// Cart data passed from backend (initial load)
let cartData = @json($cart);

function removeFromCart(key) {
    // Check if this is a domain item linked to hosting
    const item = cartData[key];
    
    if (item && item.type === 'domain' && item.is_free_with_hosting && item.linked_hosting) {
        // Check if the linked hosting still exists in the DOM
        const hostingExists = checkIfHostingExists(item.linked_hosting);
        
        if (!hostingExists) {
            // Hosting was removed, allow domain removal but update cartData first
            cartData[key].is_free_with_hosting = false;
            delete cartData[key].linked_hosting;
        } else {
            // Hosting still exists, prevent removal
            const hostingName = getHostingName(item.linked_hosting);
            
            const message = hostingName 
                ? '{{ __('frontend.cannot_remove_linked_domain_with_name') }}'.replace(':hosting', hostingName)
                : '{{ __('frontend.cannot_remove_linked_domain') }}';
                
            showErrorToast(message);
            return;
        }
    }
    
    // Store the key and button reference
    pendingRemoveKey = key;
    pendingRemoveButton = event.target.closest('button');
    
    // Show confirmation toast
    showConfirmToast();
}

// Check if hosting with given product_id still exists in DOM
function checkIfHostingExists(productId) {
    // Look for hosting cards in the DOM
    const hostingCards = document.querySelectorAll('[data-hosting-product]');
    for (const card of hostingCards) {
        if (parseInt(card.dataset.hostingProduct) === parseInt(productId)) {
            return true;
        }
    }
    return false;
}

// Get hosting name from DOM or cartData
function getHostingName(productId) {
    // Try to get from DOM first
    const hostingCards = document.querySelectorAll('[data-hosting-product]');
    for (const card of hostingCards) {
        if (parseInt(card.dataset.hostingProduct) === parseInt(productId)) {
            const nameElement = card.querySelector('[data-hosting-name]');
            if (nameElement) {
                return nameElement.textContent.trim();
            }
        }
    }
    
    // Fallback to cartData
    for (const [cartKey, cartItem] of Object.entries(cartData)) {
        if (cartItem.type === 'hosting' && cartItem.product_id === productId) {
            return cartItem.product_name;
        }
    }
    
    return '';
}

function showConfirmToast() {
    const toast = document.getElementById('confirm-toast');
    toast.classList.remove('hidden', 'opacity-0', 'translate-y-[-20px]');
    
    // Trigger animation
    setTimeout(() => {
        toast.classList.add('animate-shake');
    }, 10);
}

function hideConfirmToast() {
    const toast = document.getElementById('confirm-toast');
    toast.classList.add('opacity-0', 'translate-y-[-20px]');
    
    setTimeout(() => {
        toast.classList.add('hidden');
        toast.classList.remove('opacity-0', 'translate-y-[-20px]', 'animate-shake');
    }, 300);
    
    // Clear pending removal
    pendingRemoveKey = null;
    pendingRemoveButton = null;
}

function showErrorToast(message) {
    const toast = document.getElementById('error-toast');
    const messageEl = document.getElementById('error-message');
    
    messageEl.textContent = message;
    toast.classList.remove('hidden', 'opacity-0', 'translate-y-[-20px]');
    
    // Trigger animation
    setTimeout(() => {
        toast.classList.add('animate-shake');
    }, 10);
    
    // Auto hide after 5 seconds
    setTimeout(() => {
        hideErrorToast();
    }, 5000);
}

function hideErrorToast() {
    const toast = document.getElementById('error-toast');
    toast.classList.add('opacity-0', 'translate-y-[-20px]');
    
    setTimeout(() => {
        toast.classList.add('hidden');
        toast.classList.remove('opacity-0', 'translate-y-[-20px]', 'animate-shake');
    }, 300);
}

function confirmRemove() {
    if (!pendingRemoveKey || !pendingRemoveButton) {
        return;
    }
    
    // Store values before hiding toast (to prevent them from being cleared)
    const keyToRemove = pendingRemoveKey;
    const buttonToUpdate = pendingRemoveButton;
    
    // Hide confirmation toast
    const toast = document.getElementById('confirm-toast');
    toast.classList.add('opacity-0', 'translate-y-[-20px]');
    setTimeout(() => {
        toast.classList.add('hidden');
        toast.classList.remove('opacity-0', 'translate-y-[-20px]', 'animate-shake');
    }, 300);
    
    // Add loading state
    const originalHTML = buttonToUpdate.innerHTML;
    buttonToUpdate.disabled = true;
    buttonToUpdate.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

    fetch('{{ route("cart.remove") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ key: keyToRemove })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update cartData to remove the item
            delete cartData[keyToRemove];
            
            // Find the card - look for the closest card container
            const card = buttonToUpdate.closest('[data-hosting-product], [data-domain-key], .bg-white.rounded-xl, .dark\\:bg-slate-800.rounded-xl') 
                      || buttonToUpdate.closest('div.rounded-xl');
            
            if (card) {
                card.style.transition = 'all 0.3s ease-out';
                card.style.opacity = '0';
                card.style.transform = '{{ app()->getLocale() == "ar" ? "translateX(-50px)" : "translateX(50px)" }}';
            
                setTimeout(() => {
                    // Remove the card from DOM
                    card.remove();
                    
                    // If domains were restored, update their display AND cartData
                    if (data.restoredDomains && data.restoredDomains.length > 0) {
                        data.restoredDomains.forEach(restored => {
                            restoreDomainPrice(restored.key, restored.price);
                            
                            // Update cartData to reflect restored domain
                            if (cartData[restored.key]) {
                                cartData[restored.key].price = restored.price;
                                cartData[restored.key].is_free_with_hosting = false;
                                delete cartData[restored.key].linked_hosting;
                            }
                        });
                    }
                    
                    // Update cart count and totals
                    updateCartTotal(data.total, data.subtotal, data.discount, data.cartCount);
                    
                    // Check if cart is empty
                    if (data.cartCount === 0) {
                        // Reload the page to show empty cart
                        window.location.reload();
                    }
                }, 300);
            } else {
                // Card not found, just reload
                window.location.reload();
            }
        } else {
            showDNSToast(data.message || '{{ __("frontend.failed_to_remove_item") ?? "Failed to remove item" }}', '');
            buttonToUpdate.disabled = false;
            buttonToUpdate.innerHTML = originalHTML;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showDNSToast('{{ __("frontend.failed_to_remove_item") ?? "Failed to remove item. Please try again." }}', '');
        buttonToUpdate.disabled = false;
        buttonToUpdate.innerHTML = originalHTML;
    });
    
    // Clear pending removal after fetch is initiated
    pendingRemoveKey = null;
    pendingRemoveButton = null;
}

// Update Years Function
function updateYears(key, change) {
    const yearsElement = document.getElementById('years-' + key);
    const yearsLabelElement = document.getElementById('years-label-' + key);
    const itemTotalElement = document.getElementById('item-total-' + key);
    
    let currentYears = parseInt(yearsElement.textContent);
    let newYears = currentYears + change;
    
    // Limit between 1 and 10 years
    if (newYears < 1) newYears = 1;
    if (newYears > 10) newYears = 10;
    
    if (newYears === currentYears) return;
    
    // Update years display immediately
    yearsElement.textContent = newYears;
    if (yearsLabelElement) {
        yearsLabelElement.textContent = newYears;
    }
    
    // Calculate and update item total immediately
    if (itemTotalElement) {
        const registrationPrice = parseFloat(itemTotalElement.dataset.registrationPrice);
        const renewalPrice = parseFloat(itemTotalElement.dataset.renewalPrice);
        let itemTotal = newYears == 1 ? registrationPrice : (registrationPrice + (renewalPrice * (newYears - 1)));
        itemTotalElement.textContent = '$' + itemTotal.toFixed(2);
    }
    
    fetch('{{ route("cart.update-years") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ 
            key: key,
            years: newYears
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update all totals dynamically from server response
            updateCartTotal(data.total, data.subtotal, data.discount);
        } else {
            // Revert on error
            yearsElement.textContent = currentYears;
            if (yearsLabelElement) yearsLabelElement.textContent = currentYears;
            if (itemTotalElement) {
                const registrationPrice = parseFloat(itemTotalElement.dataset.registrationPrice);
                const renewalPrice = parseFloat(itemTotalElement.dataset.renewalPrice);
                let itemTotal = currentYears == 1 ? registrationPrice : (registrationPrice + (renewalPrice * (currentYears - 1)));
                itemTotalElement.textContent = '$' + itemTotal.toFixed(2);
            }
            showDNSToast(data.message, '{{ __("frontend.error") ?? "Error" }}');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Revert on error
        yearsElement.textContent = currentYears;
        if (yearsLabelElement) yearsLabelElement.textContent = currentYears;
        if (itemTotalElement) {
            const registrationPrice = parseFloat(itemTotalElement.dataset.registrationPrice);
            const renewalPrice = parseFloat(itemTotalElement.dataset.renewalPrice);
            let itemTotal = currentYears == 1 ? registrationPrice : (registrationPrice + (renewalPrice * (currentYears - 1)));
            itemTotalElement.textContent = '$' + itemTotal.toFixed(2);
        }
        showDNSToast('{{ __("frontend.error_occurred") ?? "An error occurred" }}', '{{ __("frontend.error") ?? "Error" }}');
    });
}

// Toggle Privacy Function
function togglePrivacy(key) {
    const checkbox = document.getElementById('privacy-' + key);
    const isEnabled = checkbox.checked;
    
    fetch('{{ route("cart.toggle-privacy") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ 
            key: key,
            privacy: isEnabled
        })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            alert(data.message);
            checkbox.checked = !isEnabled; // Revert
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('{{ __("frontend.error_occurred") ?? "An error occurred" }}');
        checkbox.checked = !isEnabled; // Revert
    });
}

// Restore domain price display when hosting is removed
function restoreDomainPrice(domainKey, restoredPrice) {
    // Find the domain card
    const domainCard = document.querySelector(`[data-domain-key="${domainKey}"]`);
    if (!domainCard) return;
    
    // Find the price display section
    const priceSection = domainCard.querySelector('[data-price-section]');
    if (!priceSection) return;
    
    // Replace FREE badge with regular price display
    const formattedPrice = parseFloat(restoredPrice).toFixed(2);
    
    // Get item total element (for multi-year calculation)
    const itemTotalElement = domainCard.querySelector(`#item-total-${domainKey}`);
    const years = parseInt(domainCard.querySelector(`#years-${domainKey}`)?.textContent || 1);
    
    // Calculate item total
    const registrationPrice = restoredPrice;
    const renewalPrice = itemTotalElement?.dataset.renewalPrice || restoredPrice;
    const itemTotal = years == 1 ? registrationPrice : (parseFloat(registrationPrice) + (parseFloat(renewalPrice) * (years - 1)));
    
    // Update the price display
    priceSection.innerHTML = `
        <!-- Regular Domain Price -->
        <div class="mb-3">
            <div class="text-xl font-bold text-slate-900 dark:text-white" id="item-total-${domainKey}" data-registration-price="${registrationPrice}" data-renewal-price="${renewalPrice}">
                $${itemTotal.toFixed(2)}
            </div>
            <div class="text-xs text-slate-500 dark:text-slate-400">
                {{ __('frontend.total_for') ?? 'Total for' }} <span id="years-label-${domainKey}">${years}</span> ${years == 1 ? '{{ __('frontend.year') }}' : '{{ __('frontend.years') }}'}
            </div>
        </div>
        
        <!-- Registration/Purchase Price -->
        <div class="mb-2">
            <div class="text-lg font-bold text-slate-700 dark:text-slate-300 mb-1">
                $${formattedPrice}
            </div>
            <div class="text-xs text-slate-500 dark:text-slate-400 font-medium">
                {{ __('frontend.registration_price') ?? 'Registration Price' }}
            </div>
        </div>
    `;
    
    // Add animation effect
    priceSection.style.transition = 'all 0.5s ease';
    priceSection.style.transform = 'scale(1.05)';
    setTimeout(() => {
        priceSection.style.transform = 'scale(1)';
    }, 300);
}

// Update Cart Total Dynamically
function updateCartTotal(newTotal, newSubtotal = null, newDiscount = null, itemCount = null) {
    // Update total displays (desktop & mobile)
    const totalElements = document.querySelectorAll('[data-cart-total], [data-mobile-cart-total]');
    totalElements.forEach(element => {
        element.textContent = '$' + parseFloat(newTotal).toFixed(2);
    });
    
    // Update subtotal if provided
    if (newSubtotal !== null) {
        const subtotalElements = document.querySelectorAll('[data-cart-subtotal]');
        subtotalElements.forEach(element => {
            element.textContent = '$' + parseFloat(newSubtotal).toFixed(2);
        });
        
        const subtotalDisplayElements = document.querySelectorAll('[data-cart-subtotal-display]');
        subtotalDisplayElements.forEach(element => {
            element.textContent = '$' + parseFloat(newSubtotal).toFixed(2);
        });
    }
    
    // Update item count if provided (desktop & mobile)
    if (itemCount !== null) {
        const cartCountElements = document.querySelectorAll('[data-cart-count]');
        cartCountElements.forEach(element => {
            element.textContent = itemCount;
        });
        
        // Update mobile cart count with items text
        const mobileCartCount = document.querySelector('[data-mobile-cart-count]');
        if (mobileCartCount) {
            mobileCartCount.textContent = itemCount + ' {{ __("frontend.items") ?? "items" }}';
        }
        
        // Update header cart badge
        const headerCartBadge = document.getElementById('cart-count');
        if (headerCartBadge) {
            headerCartBadge.textContent = itemCount;
            if (itemCount > 0) {
                headerCartBadge.classList.remove('hidden');
                headerCartBadge.classList.add('flex');
            } else {
                headerCartBadge.classList.add('hidden');
                headerCartBadge.classList.remove('flex');
            }
        }
    }
    
    // Update discount if provided
    if (newDiscount !== null && newDiscount > 0) {
        const discountAmount = document.getElementById('discount-amount');
        if (discountAmount) {
            discountAmount.textContent = '-$' + parseFloat(newDiscount).toFixed(2);
        }
        
        // Update "You Save" text
        const youSaveElements = document.querySelectorAll('.border-t.border-white\\/20 span.font-bold');
        youSaveElements.forEach(element => {
            if (element.textContent.includes('{{  __("frontend.you_save") }}') || element.textContent.includes('You Save') || element.textContent.includes('توفر')) {
                element.textContent = '{{ __("frontend.you_save") ?? "You Save" }}: $' + parseFloat(newDiscount).toFixed(2);
            }
        });
    }
}

// Toggle DNS Type
function toggleDNSType(key, type) {
    const customDnsDiv = document.getElementById('custom-dns-' + key);
    
    if (type === 'custom') {
        customDnsDiv.classList.remove('hidden');
    } else {
        customDnsDiv.classList.add('hidden');
    }
    
    fetch('{{ route("cart.update-dns-type") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ 
            key: key,
            dns_type: type
        })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Prevent Arabic Input in DNS fields
function preventArabicInput(input) {
    const arabicPattern = /[\u0600-\u06FF\u0750-\u077F\u08A0-\u08FF\uFB50-\uFDFF\uFE70-\uFEFF]/g;
    
    if (arabicPattern.test(input.value)) {
        // Remove Arabic characters immediately
        input.value = input.value.replace(arabicPattern, '');
        
        // Show Toast Notification
        showDNSToast();
        
        // Show visual feedback on input
        input.classList.add('border-red-500', 'ring-2', 'ring-red-500', 'animate-shake');
        
        // Remove error styling after 2 seconds
        setTimeout(() => {
            input.classList.remove('border-red-500', 'ring-2', 'ring-red-500', 'animate-shake');
        }, 2000);
    }
}

// Update DNS Servers
function updateDNS(key, dnsNumber, value) {
    const fieldName = 'dns' + dnsNumber;
    const inputElement = document.getElementById(fieldName + '-' + key);
    
    // Check for Arabic characters
    const arabicPattern = /[\u0600-\u06FF\u0750-\u077F\u08A0-\u08FF\uFB50-\uFDFF\uFE70-\uFEFF]/;
    if (arabicPattern.test(value)) {
        // Show error
        inputElement.classList.add('border-red-500', 'ring-2', 'ring-red-500');
        inputElement.value = value.replace(arabicPattern, ''); // Remove Arabic characters
        
        // Show alert
        alert('{{ __("frontend.dns_no_arabic") ?? "Arabic characters are not allowed in DNS fields" }}');
        
        // Remove error styling after 3 seconds
        setTimeout(() => {
            inputElement.classList.remove('border-red-500', 'ring-2', 'ring-red-500');
        }, 3000);
        
        return; // Don't send to server
    }
    
    fetch('{{ route("cart.update-dns") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ 
            key: key,
            field: fieldName,
            value: value
        })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Apply Coupon Code
function applyCoupon() {
    const couponInput = document.getElementById('coupon-input');
    const couponCode = couponInput.value.trim();
    const applyBtn = document.getElementById('apply-coupon-btn');
    
    // Hide previous messages
    document.getElementById('coupon-success').classList.add('hidden');
    document.getElementById('coupon-error').classList.add('hidden');
    
    if (!couponCode) {
        showCouponError('{{ __("frontend.enter_coupon_code") ?? "Please enter a coupon code" }}');
        return;
    }
    
    // Show loading state
    const originalBtnText = applyBtn.innerHTML;
    applyBtn.disabled = true;
    applyBtn.innerHTML = '<svg class="w-4 h-4 animate-spin inline-block" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
    
    fetch('{{ route("cart.apply-coupon") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ coupon_code: couponCode })
    })
    .then(response => response.json())
    .then(data => {
        applyBtn.disabled = false;
        applyBtn.innerHTML = originalBtnText;
        
        if (data.success) {
            showCouponSuccess(data.message, data.discount);
            updatePricesWithDiscount(data.new_total, data.discount, data.subtotal);
            couponInput.disabled = true;
        } else {
            showCouponError(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        applyBtn.disabled = false;
        applyBtn.innerHTML = originalBtnText;
        showCouponError('{{ __("frontend.error_occurred") ?? "An error occurred" }}');
    });
}

// Remove Coupon
function removeCoupon() {
    fetch('{{ route("cart.remove-coupon") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('coupon-input').value = '';
            document.getElementById('coupon-input').disabled = false;
            document.getElementById('coupon-success').classList.add('hidden');
            document.getElementById('discount-display').classList.add('hidden');
            updatePricesWithDiscount(data.new_total, 0);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Show Coupon Success Message
function showCouponSuccess(message, discount) {
    const successDiv = document.getElementById('coupon-success');
    const successText = document.getElementById('coupon-success-text');
    successText.textContent = message;
    successDiv.classList.remove('hidden');
}

// Show Coupon Error Message
function showCouponError(message) {
    const errorDiv = document.getElementById('coupon-error');
    const errorText = document.getElementById('coupon-error-text');
    errorText.textContent = message;
    errorDiv.classList.remove('hidden');
    
    // Auto hide after 5 seconds
    setTimeout(() => {
        errorDiv.classList.add('hidden');
    }, 5000);
}

// Update Prices with Discount
function updatePricesWithDiscount(newTotal, discount, subtotal = null) {
    // Update all total displays
    const totalElements = document.querySelectorAll('[data-cart-total]');
    totalElements.forEach(element => {
        element.textContent = '$' + parseFloat(newTotal).toFixed(2);
    });
    
    // Show/hide discount display
    const discountDisplay = document.getElementById('discount-display');
    const discountAmount = document.getElementById('discount-amount');
    const subtotalBeforeDiscount = document.getElementById('subtotal-before-discount');
    const subtotalDisplay = document.querySelector('[data-cart-subtotal-display]');
    
    if (discount > 0) {
        // Show discount
        discountAmount.textContent = '-$' + parseFloat(discount).toFixed(2);
        discountDisplay.classList.remove('hidden');
        
        // Show subtotal before discount
        if (subtotal) {
            subtotalDisplay.textContent = '$' + parseFloat(subtotal).toFixed(2);
        }
        subtotalBeforeDiscount.classList.remove('hidden');
        
        // Update "You Save" section in grand total
        const grandTotal = document.querySelector('.bg-slate-800.dark\\:bg-slate-700.rounded-xl');
        if (grandTotal) {
            const youSaveText = grandTotal.querySelector('.border-t span.font-bold');
            if (youSaveText) {
                youSaveText.textContent = '{{ __("frontend.you_save") ?? "You Save" }}: $' + parseFloat(discount).toFixed(2);
            }
        }
    } else {
        discountDisplay.classList.add('hidden');
        subtotalBeforeDiscount.classList.add('hidden');
    }
}

// Validate DNS and Proceed to Checkout
function proceedToCheckout() {
    // Get all custom DNS sections that are visible
    const customDnsSections = document.querySelectorAll('[id^="custom-dns-"]:not(.hidden)');
    
    let hasError = false;
    let errorMessage = '';
    
    customDnsSections.forEach(section => {
        const key = section.id.replace('custom-dns-', '');
        const dns1 = document.getElementById('dns1-' + key);
        const dns2 = document.getElementById('dns2-' + key);
        
        // Check if at least 2 DNS are filled
        if (!dns1.value.trim() || !dns2.value.trim()) {
            hasError = true;
            errorMessage = '{{ __("frontend.dns_validation_error") ?? "Please enter at least 2 DNS servers for domains with custom DNS" }}';
            
            // Highlight empty required fields
            if (!dns1.value.trim()) {
                dns1.classList.add('border-red-500');
                setTimeout(() => dns1.classList.remove('border-red-500'), 3000);
            }
            if (!dns2.value.trim()) {
                dns2.classList.add('border-red-500');
                setTimeout(() => dns2.classList.remove('border-red-500'), 3000);
            }
        }
    });
    
    if (hasError) {
        showDNSToast(errorMessage, ''); // Empty string to hide subtitle
        // Scroll to first error
        const firstError = document.querySelector('[id^="custom-dns-"]:not(.hidden)');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        return false;
    }
    
    // If validation passed, redirect to checkout
    window.location.href = '{{ route("cart.checkout") }}';
}
</script>
@endpush
@endsection
