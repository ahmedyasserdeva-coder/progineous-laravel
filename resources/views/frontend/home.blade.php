@extends('frontend.layout')

@section('title', __('frontend.home') . ' - ' . config('app.name'))
@section('description', __('frontend.hero_subtitle'))

@section('content')
<!-- Domain Search Results Modal -->
<div id="domainSearchResults" class="fixed inset-0 z-[100] pointer-events-none">
    <!-- Backdrop -->
    <div id="searchResultsBackdrop" class="absolute inset-0 bg-black/50 opacity-0 pointer-events-none" style="transition: opacity 1s ease-out;"></div>
    
    <!-- Results Panel - slides from bottom to top -->
    <div id="searchResultsPanel" class="absolute left-0 right-0 bg-white rounded-t-3xl shadow-2xl pointer-events-auto" style="top: 100%; height: calc(100vh - 60px); transition: top 1.2s cubic-bezier(0.16, 1, 0.3, 1);">
        <!-- Header -->
        <div class="sticky top-0 bg-white rounded-t-3xl border-b border-gray-100 px-6 py-4 z-10">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">{{ __('frontend.domain_search_results') }}</h3>
                    <p id="searchedDomainName" class="text-sm text-gray-500"></p>
                </div>
                <button id="closeSearchResults" class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                    <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Search Another Domain -->
            <form id="modalDomainSearchForm" class="flex items-center gap-2">
                <div class="relative flex-1">
                    <div class="absolute {{ app()->getLocale() == 'ar' ? 'right-4' : 'left-4' }} top-1/2 -translate-y-1/2 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        id="modalDomainInput" 
                        placeholder="{{ __('frontend.search_another_domain') }}" 
                        class="w-full {{ app()->getLocale() == 'ar' ? 'pr-12 pl-4' : 'pl-12 pr-4' }} py-2.5 bg-gray-50 border border-gray-200 rounded-full text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                    >
                </div>
                <button 
                    type="submit"
                    class="px-5 py-2.5 bg-blue-500 hover:bg-blue-600 text-white font-medium text-sm rounded-full transition-all"
                >
                    {{ __('frontend.search') }}
                </button>
            </form>
        </div>
        
        <!-- Loading State -->
        <div id="searchResultsLoading" class="hidden p-8 text-center">
            <div class="inline-block w-12 h-12 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
            <p class="mt-4 text-gray-600">{{ __('frontend.searching') }}...</p>
        </div>
        
        <!-- Results Content -->
        <div id="searchResultsContent" class="overflow-y-auto p-6" style="max-height: calc(100vh - 250px);">
            <!-- Results will be injected here -->
        </div>
    </div>
</div>

<!-- Sticky Domain Search Bar -->
<div class="sticky top-0 z-50 bg-white shadow-sm py-3">
    <div class="w-full flex flex-col md:flex-row items-center justify-between px-4 md:px-8 gap-3 md:gap-0">
        <!-- Search Form - Far Left -->
        <form id="stickyDomainSearchForm" class="flex items-center w-full md:w-auto">
            @csrf
            <div class="relative w-full md:w-[320px] lg:w-[400px] xl:w-[500px]">
                <div class="absolute {{ app()->getLocale() == 'ar' ? 'right-4' : 'left-4' }} top-1/2 -translate-y-1/2 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input 
                    type="text" 
                    name="domain"
                    id="stickyDomainInput" 
                    placeholder="mybusiness.com" 
                    class="w-full {{ app()->getLocale() == 'ar' ? 'pr-24 pl-4' : 'pl-12 pr-24' }} py-2.5 bg-white border border-gray-200 rounded-full text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                >
                <button 
                    type="submit"
                    class="absolute {{ app()->getLocale() == 'ar' ? 'left-1' : 'right-1' }} top-1/2 -translate-y-1/2 px-4 py-1.5 bg-blue-500 hover:bg-blue-600 text-white font-medium text-sm rounded-full transition-all"
                >
                    {{ __('frontend.search') }}
                </button>
            </div>
        </form>
        
        <!-- TLD Prices - Far Right -->
        <div class="flex items-center gap-2 md:gap-3 flex-wrap justify-center lg:justify-end">
            @php
                // Default TLD prices if no featured domains in database
                $defaultTlds = [
                    ['tld' => 'com', 'price' => 13.06],
                    ['tld' => 'net', 'price' => 15.02],
                    ['tld' => 'org', 'price' => 12.64],
                ];
                $displayDomains = $featuredDomains->count() > 0 
                    ? $featuredDomains->take(3)->map(fn($d) => ['tld' => $d->tld, 'price' => $d->progineous_register])
                    : collect($defaultTlds);
            @endphp
            @foreach($displayDomains as $domain)
                <div class="px-3 md:px-4 py-1.5 md:py-2 rounded-full text-xs md:text-sm bg-sky-50">
                    <span class="text-sky-700">.{{ $domain['tld'] }}</span>
                    <span class="text-sky-900 font-bold ml-1">${{ number_format($domain['price'], 2) }} USD</span>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Hero Section - Dark Gradient Style -->
<section class="relative min-h-[85vh] flex items-center overflow-hidden" style="background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 40%, #2d5a7b 70%, #3d7a9e 100%);">
    <!-- Animated Stars/Dots Background -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <!-- Stars -->
        <div class="absolute w-1 h-1 bg-white/40 rounded-full top-[10%] left-[10%] animate-pulse"></div>
        <div class="absolute w-1.5 h-1.5 bg-white/30 rounded-full top-[15%] left-[25%] animate-pulse animation-delay-1000"></div>
        <div class="absolute w-1 h-1 bg-white/50 rounded-full top-[8%] left-[45%] animate-pulse animation-delay-2000"></div>
        <div class="absolute w-2 h-2 bg-white/20 rounded-full top-[20%] left-[60%] animate-pulse"></div>
        <div class="absolute w-1 h-1 bg-white/40 rounded-full top-[12%] left-[80%] animate-pulse animation-delay-1000"></div>
        <div class="absolute w-1.5 h-1.5 bg-white/30 rounded-full top-[30%] left-[15%] animate-pulse animation-delay-2000"></div>
        <div class="absolute w-1 h-1 bg-white/50 rounded-full top-[40%] left-[5%] animate-pulse"></div>
        <div class="absolute w-1 h-1 bg-white/40 rounded-full top-[50%] left-[90%] animate-pulse animation-delay-1000"></div>
        <div class="absolute w-2 h-2 bg-white/20 rounded-full top-[60%] left-[75%] animate-pulse animation-delay-2000"></div>
        <div class="absolute w-1 h-1 bg-white/30 rounded-full top-[70%] left-[20%] animate-pulse"></div>
        
        <!-- Animated Circle on the Right -->
        <div class="absolute {{ app()->getLocale() == 'ar' ? 'left-[10%]' : 'right-[10%]' }} top-1/2 -translate-y-1/2 w-64 h-64 md:w-80 md:h-80 lg:w-96 lg:h-96">
            <div class="absolute inset-0 border-2 border-white/30 rounded-full animate-spin-slow"></div>
            <div class="absolute inset-4 border border-white/20 rounded-full animate-spin-slow-reverse"></div>
            <div class="absolute inset-8 border border-white/10 rounded-full animate-pulse"></div>
        </div>
    </div>

    <div class="container mx-auto px-4 relative z-10 py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Content -->
            <div class="{{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
                <!-- Trust Badges -->
                <div class="flex flex-wrap items-center gap-3 mb-8 {{ app()->getLocale() == 'ar' ? 'justify-end' : 'justify-start' }}">
                    <div class="flex items-center gap-2 bg-white/10 backdrop-blur-sm rounded-full px-4 py-2">
                        <div class="flex">
                            @for($i = 0; $i < 5; $i++)
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-white text-sm font-medium">4.9/5 Trustpilot</span>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-full px-4 py-2">
                        <span class="text-white text-sm font-medium">+50,000 {{ __('frontend.happy_clients') }}</span>
                    </div>
                </div>

                <!-- Main Heading -->
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">
                    <span class="text-blue-300">{{ __('frontend.hero_title_speed') }}</span><br>
                    {{ __('frontend.hero_title_hosting') }}
                </h1>
                
                <!-- Subtitle -->
                <p class="text-lg md:text-xl text-white/80 mb-8 max-w-xl">
                    {{ __('frontend.hero_subtitle_new') }}
                </p>

                <!-- Features -->
                <div class="flex flex-wrap items-center gap-6 mb-10 {{ app()->getLocale() == 'ar' ? 'justify-end' : 'justify-start' }}">
                    <div class="flex items-center gap-2 text-white/80">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <span class="text-sm font-medium">{{ __('frontend.ultra_fast') }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-white/80">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <span class="text-sm font-medium">{{ __('frontend.full_security') }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-white/80">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm font-medium">{{ __('frontend.support_247') }}</span>
                    </div>
                </div>

                <!-- CTA Buttons -->
                <div class="flex flex-wrap items-center gap-4 {{ app()->getLocale() == 'ar' ? 'justify-end' : 'justify-start' }}">
                    <a href="{{ route('hosting.shared') }}" class="group inline-flex items-center gap-2 px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-full transition-all shadow-lg hover:shadow-xl">
                        {{ __('frontend.start_now') }} $2
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                    <a href="#hosting-plans" class="inline-flex items-center gap-2 px-8 py-4 bg-transparent border-2 border-white/30 hover:border-white/50 text-white font-semibold rounded-full transition-all">
                        {{ __('frontend.view_plans') }}
                    </a>
                </div>
            </div>

            <!-- Right Side - Empty for the Circle Animation -->
            <div class="hidden lg:block"></div>
        </div>
    </div>

    <!-- Wave Bottom -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
            <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="white" class="dark:fill-slate-900"/>
        </svg>
    </div>
</section>

<!-- Hosting Plans Section - Like Next.js Design -->
<section id="hosting-plans" class="py-16 lg:py-20 bg-white dark:bg-slate-900 overflow-hidden">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center mb-12">
            <h2 class="text-2xl lg:text-3xl font-bold text-slate-900 dark:text-white">
                {{ __('frontend.choose_hosting_plan') }}
            </h2>
            <p class="mt-3 text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
                {{ __('frontend.hosting_plans_description') }}
            </p>
        </div>

        <!-- Hosting Plans Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
            
            <!-- Shared Hosting -->
            <a href="{{ route('hosting.shared') }}" class="group relative rounded-2xl bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 p-6 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 border border-slate-100 dark:border-slate-700">
                <div class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-blue-600 shadow-lg">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-bold text-slate-900 dark:text-white">{{ __('frontend.shared_hosting') }}</h3>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">{{ __('frontend.shared_hosting_desc') }}</p>
                <div class="mt-4">
                    <span class="text-xs text-slate-500 dark:text-slate-500">{{ __('frontend.starting_at') }}</span>
                    <div class="flex items-baseline gap-0.5">
                        <span class="text-3xl font-bold text-slate-900 dark:text-white">$2</span>
                        <span class="text-sm text-slate-500 dark:text-slate-500">/{{ __('frontend.month') }}</span>
                    </div>
                </div>
                <ul class="mt-4 space-y-2">
                    <li class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                        <span class="h-1 w-1 rounded-full bg-blue-600"></span>{{ __('frontend.unlimited_ssd') }}
                    </li>
                    <li class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                        <span class="h-1 w-1 rounded-full bg-blue-600"></span>{{ __('frontend.free_ssl') }}
                    </li>
                    <li class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                        <span class="h-1 w-1 rounded-full bg-blue-600"></span>{{ __('frontend.unlimited_bandwidth') }}
                    </li>
                </ul>
                <div class="mt-4 flex items-center gap-1 text-blue-600 dark:text-blue-400 font-medium text-sm group-hover:gap-2 transition-all">
                    {{ __('frontend.learn_more') }}
                    <svg class="h-4 w-4 {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            <!-- Cloud Hosting -->
            <a href="{{ route('hosting.cloud') }}" class="group relative rounded-2xl bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 p-6 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 border border-slate-100 dark:border-slate-700">
                <div class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-purple-600 shadow-lg">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-bold text-slate-900 dark:text-white">{{ __('frontend.cloud_hosting') }}</h3>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">{{ __('frontend.cloud_hosting_desc') }}</p>
                <div class="mt-4">
                    <span class="text-xs text-slate-500 dark:text-slate-500">{{ __('frontend.starting_at') }}</span>
                    <div class="flex items-baseline gap-0.5">
                        <span class="text-3xl font-bold text-slate-900 dark:text-white">$4</span>
                        <span class="text-sm text-slate-500 dark:text-slate-500">/{{ __('frontend.month') }}</span>
                    </div>
                </div>
                <ul class="mt-4 space-y-2">
                    <li class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                        <span class="h-1 w-1 rounded-full bg-purple-600"></span>{{ __('frontend.dedicated_resources') }}
                    </li>
                    <li class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                        <span class="h-1 w-1 rounded-full bg-purple-600"></span>{{ __('frontend.auto_scaling') }}
                    </li>
                    <li class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                        <span class="h-1 w-1 rounded-full bg-purple-600"></span>{{ __('frontend.daily_backups') }}
                    </li>
                </ul>
                <div class="mt-4 flex items-center gap-1 text-purple-600 dark:text-purple-400 font-medium text-sm group-hover:gap-2 transition-all">
                    {{ __('frontend.learn_more') }}
                    <svg class="h-4 w-4 {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            <!-- Reseller Hosting -->
            <a href="{{ route('hosting.reseller') }}" class="group relative rounded-2xl bg-gradient-to-br from-cyan-50 to-cyan-100 dark:from-cyan-900/20 dark:to-cyan-800/20 p-6 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 border border-slate-100 dark:border-slate-700">
                <div class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-cyan-600 shadow-lg">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-bold text-slate-900 dark:text-white">{{ __('frontend.reseller_hosting') }}</h3>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">{{ __('frontend.reseller_hosting_desc') }}</p>
                <div class="mt-4">
                    <span class="text-xs text-slate-500 dark:text-slate-500">{{ __('frontend.starting_at') }}</span>
                    <div class="flex items-baseline gap-0.5">
                        <span class="text-3xl font-bold text-slate-900 dark:text-white">$20</span>
                        <span class="text-sm text-slate-500 dark:text-slate-500">/{{ __('frontend.month') }}</span>
                    </div>
                </div>
                <ul class="mt-4 space-y-2">
                    <li class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                        <span class="h-1 w-1 rounded-full bg-cyan-600"></span>{{ __('frontend.free_whm') }}
                    </li>
                    <li class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                        <span class="h-1 w-1 rounded-full bg-cyan-600"></span>{{ __('frontend.white_label') }}
                    </li>
                    <li class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                        <span class="h-1 w-1 rounded-full bg-cyan-600"></span>{{ __('frontend.unlimited_accounts') }}
                    </li>
                </ul>
                <div class="mt-4 flex items-center gap-1 text-cyan-600 dark:text-cyan-400 font-medium text-sm group-hover:gap-2 transition-all">
                    {{ __('frontend.learn_more') }}
                    <svg class="h-4 w-4 {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            <!-- VPS Hosting -->
            <a href="{{ route('hosting.vps') }}" class="group relative rounded-2xl bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 p-6 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 border border-slate-100 dark:border-slate-700">
                <div class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-600 shadow-lg">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-bold text-slate-900 dark:text-white">{{ __('frontend.vps_hosting') }}</h3>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">{{ __('frontend.vps_hosting_desc') }}</p>
                <div class="mt-4">
                    <span class="text-xs text-slate-500 dark:text-slate-500">{{ __('frontend.starting_at') }}</span>
                    <div class="flex items-baseline gap-0.5">
                        <span class="text-3xl font-bold text-slate-900 dark:text-white">$14.99</span>
                        <span class="text-sm text-slate-500 dark:text-slate-500">/{{ __('frontend.month') }}</span>
                    </div>
                </div>
                <ul class="mt-4 space-y-2">
                    <li class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                        <span class="h-1 w-1 rounded-full bg-emerald-600"></span>{{ __('frontend.full_root_access') }}
                    </li>
                    <li class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                        <span class="h-1 w-1 rounded-full bg-emerald-600"></span>{{ __('frontend.choice_of_os') }}
                    </li>
                    <li class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                        <span class="h-1 w-1 rounded-full bg-emerald-600"></span>{{ __('frontend.dedicated_ip') }}
                    </li>
                </ul>
                <div class="mt-4 flex items-center gap-1 text-emerald-600 dark:text-emerald-400 font-medium text-sm group-hover:gap-2 transition-all">
                    {{ __('frontend.learn_more') }}
                    <svg class="h-4 w-4 {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            <!-- Dedicated Servers -->
            <a href="{{ route('hosting.dedicated') }}" class="group relative rounded-2xl bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-800/20 p-6 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 border border-slate-100 dark:border-slate-700">
                <div class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-amber-600 shadow-lg">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-bold text-slate-900 dark:text-white">{{ __('frontend.dedicated_servers') }}</h3>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">{{ __('frontend.dedicated_servers_desc') }}</p>
                <div class="mt-4">
                    <span class="text-xs text-slate-500 dark:text-slate-500">{{ __('frontend.starting_at') }}</span>
                    <div class="flex items-baseline gap-0.5">
                        <span class="text-3xl font-bold text-slate-900 dark:text-white">$140</span>
                        <span class="text-sm text-slate-500 dark:text-slate-500">/{{ __('frontend.month') }}</span>
                    </div>
                </div>
                <ul class="mt-4 space-y-2">
                    <li class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                        <span class="h-1 w-1 rounded-full bg-amber-600"></span>{{ __('frontend.entire_server') }}
                    </li>
                    <li class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                        <span class="h-1 w-1 rounded-full bg-amber-600"></span>{{ __('frontend.ultra_fast_performance') }}
                    </li>
                    <li class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                        <span class="h-1 w-1 rounded-full bg-amber-600"></span>{{ __('frontend.expert_support') }}
                    </li>
                </ul>
                <div class="mt-4 flex items-center gap-1 text-amber-600 dark:text-amber-400 font-medium text-sm group-hover:gap-2 transition-all">
                    {{ __('frontend.learn_more') }}
                    <svg class="h-4 w-4 {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            <!-- Migrate Now -->
            <a href="{{ route('hosting.shared') }}?migrate=1" class="group relative rounded-2xl bg-gradient-to-br from-rose-50 to-rose-100 dark:from-rose-900/20 dark:to-rose-800/20 p-6 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 border border-slate-100 dark:border-slate-700">
                <div class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-rose-600 shadow-lg">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-bold text-slate-900 dark:text-white">{{ __('frontend.migrate_now') }}</h3>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">{{ __('frontend.migrate_now_desc') }}</p>
                <div class="mt-4">
                    <div class="flex items-baseline gap-0.5">
                        <span class="text-3xl font-bold text-rose-600 dark:text-rose-400">{{ __('frontend.free') }}</span>
                    </div>
                </div>
                <ul class="mt-4 space-y-2">
                    <li class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                        <span class="h-1 w-1 rounded-full bg-rose-600"></span>{{ __('frontend.zero_downtime') }}
                    </li>
                    <li class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                        <span class="h-1 w-1 rounded-full bg-rose-600"></span>{{ __('frontend.expert_team') }}
                    </li>
                    <li class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                        <span class="h-1 w-1 rounded-full bg-rose-600"></span>{{ __('frontend.money_back_guarantee') }}
                    </li>
                </ul>
                <div class="mt-4 flex items-center gap-1 text-rose-600 dark:text-rose-400 font-medium text-sm group-hover:gap-2 transition-all">
                    {{ __('frontend.learn_more') }}
                    <svg class="h-4 w-4 {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

        </div>
    </div>
</section>

<!-- Why Choose Online Section -->
<section class="py-20 bg-gradient-to-br from-slate-50 via-blue-50 to-cyan-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-96 h-96 bg-blue-500 rounded-full filter blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-cyan-500 rounded-full filter blur-3xl"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <!-- Section Header -->
        <div class="max-w-4xl mx-auto text-center mb-16">
            <span class="inline-block px-4 py-2 mb-4 text-sm font-semibold text-blue-600 dark:text-blue-400 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                {{ __('frontend.online_presence') }}
            </span>
            <h2 class="text-3xl md:text-5xl font-black text-slate-900 dark:text-white mb-6 leading-tight">
                {{ __('frontend.why_choose_online_title') }}
            </h2>
            <p class="text-lg md:text-xl text-slate-600 dark:text-slate-300 leading-relaxed">
                {{ __('frontend.why_choose_online_subtitle') }}
            </p>
        </div>

        <!-- Benefits Stack - Click to Expand (Reversed Order) -->
        <div class="max-w-3xl mx-auto relative" style="min-height: 520px;">
            
            <style>
                .benefit-stack-card {
                    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                }
                .benefit-stack-card.active {
                    transform: translateY(-300px) scale(1.03) !important;
                    z-index: 50 !important;
                }
                .benefit-stack-card.active .benefit-border {
                    border-width: 2px;
                }
                .benefit-stack-1 { top: 0px; z-index: 1; }
                .benefit-stack-2 { top: 60px; z-index: 2; }
                .benefit-stack-3 { top: 120px; z-index: 3; }
                .benefit-stack-4 { top: 180px; z-index: 4; }
                .benefit-stack-5 { top: 240px; z-index: 5; }
                .benefit-stack-6 { top: 300px; z-index: 6; }
                
                .benefit-stack-card.active .icon-circle {
                    transform: scale(1.15) rotate(5deg);
                }
            </style>

            <script>
                function toggleCard(cardElement) {
                    // Remove active class from all cards
                    document.querySelectorAll('.benefit-stack-card').forEach(card => {
                        card.classList.remove('active');
                    });
                    // Add active class to clicked card
                    cardElement.classList.add('active');
                }
            </script>

            <!-- Benefit 1: 24/7 Availability (First - at Back) -->
            <div class="benefit-stack-card benefit-stack-1 absolute inset-x-0 bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg cursor-pointer" onclick="toggleCard(this)">
                <div class="benefit-border border-2 border-slate-200 dark:border-slate-700 hover:border-blue-400 dark:hover:border-blue-400 rounded-2xl p-6 -m-6 transition-all">
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0">
                            <div class="icon-circle w-14 h-14 bg-blue-50 dark:bg-blue-900/20 rounded-full flex items-center justify-center transition-transform duration-300">
                                <svg class="w-7 h-7 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1">
                                {{ __('frontend.benefit_247_title') }}
                            </h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                                {{ __('frontend.benefit_247_desc') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Benefit 2: Wider Reach -->
            <div class="benefit-stack-card benefit-stack-2 absolute inset-x-0 bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg cursor-pointer" onclick="toggleCard(this)">
                <div class="benefit-border border-2 border-slate-200 dark:border-slate-700 hover:border-cyan-400 dark:hover:border-cyan-400 rounded-2xl p-6 -m-6 transition-all">
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0">
                            <div class="icon-circle w-14 h-14 bg-cyan-50 dark:bg-cyan-900/20 rounded-full flex items-center justify-center transition-transform duration-300">
                                <svg class="w-7 h-7 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1">
                                {{ __('frontend.benefit_reach_title') }}
                            </h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                                {{ __('frontend.benefit_reach_desc') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Benefit 3: Cost Effective -->
            <div class="benefit-stack-card benefit-stack-3 absolute inset-x-0 bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg cursor-pointer" onclick="toggleCard(this)">
                <div class="benefit-border border-2 border-slate-200 dark:border-slate-700 hover:border-green-400 dark:hover:border-green-400 rounded-2xl p-6 -m-6 transition-all">
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0">
                            <div class="icon-circle w-14 h-14 bg-green-50 dark:bg-green-900/20 rounded-full flex items-center justify-center transition-transform duration-300">
                                <svg class="w-7 h-7 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1">
                                {{ __('frontend.benefit_cost_title') }}
                            </h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                                {{ __('frontend.benefit_cost_desc') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Benefit 4: Customer Insights -->
            <div class="benefit-stack-card benefit-stack-4 absolute inset-x-0 bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg cursor-pointer" onclick="toggleCard(this)">
                <div class="benefit-border border-2 border-slate-200 dark:border-slate-700 hover:border-purple-400 dark:hover:border-purple-400 rounded-2xl p-6 -m-6 transition-all">
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0">
                            <div class="icon-circle w-14 h-14 bg-purple-50 dark:bg-purple-900/20 rounded-full flex items-center justify-center transition-transform duration-300">
                                <svg class="w-7 h-7 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1">
                                {{ __('frontend.benefit_insights_title') }}
                            </h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                                {{ __('frontend.benefit_insights_desc') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Benefit 5: Build Trust -->
            <div class="benefit-stack-card benefit-stack-5 absolute inset-x-0 bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg cursor-pointer" onclick="toggleCard(this)">
                <div class="benefit-border border-2 border-slate-200 dark:border-slate-700 hover:border-orange-400 dark:hover:border-orange-400 rounded-2xl p-6 -m-6 transition-all">
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0">
                            <div class="icon-circle w-14 h-14 bg-orange-50 dark:bg-orange-900/20 rounded-full flex items-center justify-center transition-transform duration-300">
                                <svg class="w-7 h-7 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1">
                                {{ __('frontend.benefit_trust_title') }}
                            </h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                                {{ __('frontend.benefit_trust_desc') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Benefit 6: Easy Updates (Last - at Front) -->
            <div class="benefit-stack-card benefit-stack-6 absolute inset-x-0 bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg cursor-pointer" onclick="toggleCard(this)">
                <div class="benefit-border border-2 border-slate-200 dark:border-slate-700 hover:border-indigo-400 dark:hover:border-indigo-400 rounded-2xl p-6 -m-6 transition-all">
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0">
                            <div class="icon-circle w-14 h-14 bg-indigo-50 dark:bg-indigo-900/20 rounded-full flex items-center justify-center transition-transform duration-300">
                                <svg class="w-7 h-7 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1">
                                {{ __('frontend.benefit_updates_title') }}
                            </h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                                {{ __('frontend.benefit_updates_desc') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- CTA Button -->
        <div class="text-center mt-16">
            <a href="#domain-search" 
               class="inline-flex items-center gap-3 px-10 py-5 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-bold text-lg rounded-2xl shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                <span>{{ __('frontend.start_your_journey') }}</span>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Why Pro Gineous Section - Clean & Minimal -->
<section class="relative py-32 bg-white dark:bg-slate-950">
    <!-- Subtle background -->
    <div class="absolute inset-0 bg-gradient-to-b from-blue-50 to-white dark:from-slate-950 dark:to-slate-900"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <!-- Section Header - Bold & Minimal -->
        <div class="max-w-5xl mx-auto text-center mb-24">
            <div class="inline-block px-4 py-2 mb-8 border-b-2 border-blue-600">
                <span class="text-sm font-bold text-blue-600 dark:text-blue-500 uppercase tracking-widest">
                    {{ __('frontend.why_pro_gineous') }}
                </span>
            </div>
            
            <h2 class="text-5xl md:text-7xl font-black text-slate-900 dark:text-white mb-8 leading-tight">
                {{ __('frontend.why_pro_gineous_title') }}
            </h2>
            
            <p class="text-xl md:text-2xl text-slate-600 dark:text-slate-400 max-w-4xl mx-auto font-light">
                {{ __('frontend.why_pro_gineous_subtitle') }}
            </p>
        </div>

        <!-- Features List - Typography Focused -->
        <div class="max-w-6xl mx-auto space-y-2">
            
            <!-- Feature 1: Support -->
            <div class="group relative overflow-hidden">
                <div class="flex items-center gap-8 px-8 py-12 border-b border-slate-200 dark:border-slate-800 hover:bg-blue-50 dark:hover:bg-slate-900/50 transition-all duration-300">
                    <!-- Number -->
                    <div class="flex-shrink-0">
                        <div class="text-7xl font-black text-blue-600/10 dark:text-blue-500/10 group-hover:text-blue-600/20 dark:group-hover:text-blue-500/20 transition-colors">
                            01
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="flex-grow">
                        <h3 class="text-3xl md:text-4xl font-bold text-slate-900 dark:text-white mb-3 group-hover:text-blue-600 dark:group-hover:text-blue-500 transition-colors">
                            {{ __('frontend.feature_support_title') }}
                        </h3>
                        <p class="text-lg text-slate-600 dark:text-slate-400 font-light">
                            {{ __('frontend.feature_support_desc') }}
                        </p>
                    </div>
                    
                    <!-- Icon -->
                    <div class="flex-shrink-0 hidden lg:block">
                        <svg class="w-16 h-16 text-blue-600 dark:text-blue-500 opacity-40 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Feature 2: Performance -->
            <div class="group relative overflow-hidden">
                <div class="flex items-center gap-8 px-8 py-12 border-b border-slate-200 dark:border-slate-800 hover:bg-blue-50 dark:hover:bg-slate-900/50 transition-all duration-300">
                    <div class="flex-shrink-0">
                        <div class="text-7xl font-black text-blue-600/10 dark:text-blue-500/10 group-hover:text-blue-600/20 dark:group-hover:text-blue-500/20 transition-colors">
                            02
                        </div>
                    </div>
                    
                    <div class="flex-grow">
                        <h3 class="text-3xl md:text-4xl font-bold text-slate-900 dark:text-white mb-3 group-hover:text-blue-600 dark:group-hover:text-blue-500 transition-colors">
                            {{ __('frontend.feature_performance_title') }}
                        </h3>
                        <p class="text-lg text-slate-600 dark:text-slate-400 font-light">
                            {{ __('frontend.feature_performance_desc') }}
                        </p>
                    </div>
                    
                    <div class="flex-shrink-0 hidden lg:block">
                        <svg class="w-16 h-16 text-blue-600 dark:text-blue-500 opacity-40 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Feature 3: Security -->
            <div class="group relative overflow-hidden">
                <div class="flex items-center gap-8 px-8 py-12 border-b border-slate-200 dark:border-slate-800 hover:bg-blue-50 dark:hover:bg-slate-900/50 transition-all duration-300">
                    <div class="flex-shrink-0">
                        <div class="text-7xl font-black text-blue-600/10 dark:text-blue-500/10 group-hover:text-blue-600/20 dark:group-hover:text-blue-500/20 transition-colors">
                            03
                        </div>
                    </div>
                    
                    <div class="flex-grow">
                        <h3 class="text-3xl md:text-4xl font-bold text-slate-900 dark:text-white mb-3 group-hover:text-blue-600 dark:group-hover:text-blue-500 transition-colors">
                            {{ __('frontend.feature_security_title') }}
                        </h3>
                        <p class="text-lg text-slate-600 dark:text-slate-400 font-light">
                            {{ __('frontend.feature_security_desc') }}
                        </p>
                    </div>
                    
                    <div class="flex-shrink-0 hidden lg:block">
                        <svg class="w-16 h-16 text-blue-600 dark:text-blue-500 opacity-40 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Feature 4: Pricing -->
            <div class="group relative overflow-hidden">
                <div class="flex items-center gap-8 px-8 py-12 border-b border-slate-200 dark:border-slate-800 hover:bg-blue-50 dark:hover:bg-slate-900/50 transition-all duration-300">
                    <div class="flex-shrink-0">
                        <div class="text-7xl font-black text-blue-600/10 dark:text-blue-500/10 group-hover:text-blue-600/20 dark:group-hover:text-blue-500/20 transition-colors">
                            04
                        </div>
                    </div>
                    
                    <div class="flex-grow">
                        <h3 class="text-3xl md:text-4xl font-bold text-slate-900 dark:text-white mb-3 group-hover:text-blue-600 dark:group-hover:text-blue-500 transition-colors">
                            {{ __('frontend.feature_pricing_title') }}
                        </h3>
                        <p class="text-lg text-slate-600 dark:text-slate-400 font-light">
                            {{ __('frontend.feature_pricing_desc') }}
                        </p>
                    </div>
                    
                    <div class="flex-shrink-0 hidden lg:block">
                        <svg class="w-16 h-16 text-blue-600 dark:text-blue-500 opacity-40 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Feature 5: Control Panel -->
            <div class="group relative overflow-hidden">
                <div class="flex items-center gap-8 px-8 py-12 border-b border-slate-200 dark:border-slate-800 hover:bg-blue-50 dark:hover:bg-slate-900/50 transition-all duration-300">
                    <div class="flex-shrink-0">
                        <div class="text-7xl font-black text-blue-600/10 dark:text-blue-500/10 group-hover:text-blue-600/20 dark:group-hover:text-blue-500/20 transition-colors">
                            05
                        </div>
                    </div>
                    
                    <div class="flex-grow">
                        <h3 class="text-3xl md:text-4xl font-bold text-slate-900 dark:text-white mb-3 group-hover:text-blue-600 dark:group-hover:text-blue-500 transition-colors">
                            {{ __('frontend.feature_control_title') }}
                        </h3>
                        <p class="text-lg text-slate-600 dark:text-slate-400 font-light">
                            {{ __('frontend.feature_control_desc') }}
                        </p>
                    </div>
                    
                    <div class="flex-shrink-0 hidden lg:block">
                        <svg class="w-16 h-16 text-blue-600 dark:text-blue-500 opacity-40 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Feature 6: Uptime -->
            <div class="group relative overflow-hidden">
                <div class="flex items-center gap-8 px-8 py-12 border-b border-slate-200 dark:border-slate-800 hover:bg-blue-50 dark:hover:bg-slate-900/50 transition-all duration-300">
                    <div class="flex-shrink-0">
                        <div class="text-7xl font-black text-blue-600/10 dark:text-blue-500/10 group-hover:text-blue-600/20 dark:group-hover:text-blue-500/20 transition-colors">
                            06
                        </div>
                    </div>
                    
                    <div class="flex-grow">
                        <h3 class="text-3xl md:text-4xl font-bold text-slate-900 dark:text-white mb-3 group-hover:text-blue-600 dark:group-hover:text-blue-500 transition-colors">
                            {{ __('frontend.feature_uptime_title') }}
                        </h3>
                        <p class="text-lg text-slate-600 dark:text-slate-400 font-light">
                            {{ __('frontend.feature_uptime_desc') }}
                        </p>
                    </div>
                    
                    <div class="flex-shrink-0 hidden lg:block">
                        <svg class="w-16 h-16 text-blue-600 dark:text-blue-500 opacity-40 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-20 bg-white dark:bg-slate-900">
    <div class="container mx-auto px-4">
        <!-- Section Header -->
        <div class="max-w-3xl mx-auto text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-slate-900 dark:text-white mb-4">
                {{ __('frontend.why_choose_us') }}
            </h2>
            <p class="text-lg text-slate-600 dark:text-slate-400">
                {{ __('frontend.why_choose_us_desc') }}
            </p>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="group p-6 bg-slate-50 dark:bg-slate-800 rounded-2xl hover:shadow-xl transition-all duration-300 border border-slate-200 dark:border-slate-700 hover:border-purple-300 dark:hover:border-purple-600">
                <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-indigo-500 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">{{ __('frontend.fast_performance') }}</h3>
                <p class="text-slate-600 dark:text-slate-400">{{ __('frontend.fast_performance_desc') }}</p>
            </div>

            <!-- Feature 2 -->
            <div class="group p-6 bg-slate-50 dark:bg-slate-800 rounded-2xl hover:shadow-xl transition-all duration-300 border border-slate-200 dark:border-slate-700 hover:border-purple-300 dark:hover:border-purple-600">
                <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">{{ __('frontend.high_security') }}</h3>
                <p class="text-slate-600 dark:text-slate-400">{{ __('frontend.high_security_desc') }}</p>
            </div>

            <!-- Feature 3 -->
            <div class="group p-6 bg-slate-50 dark:bg-slate-800 rounded-2xl hover:shadow-xl transition-all duration-300 border border-slate-200 dark:border-slate-700 hover:border-purple-300 dark:hover:border-purple-600">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">{{ __('frontend.support_247') }}</h3>
                <p class="text-slate-600 dark:text-slate-400">{{ __('frontend.support_247_desc') }}</p>
            </div>

            <!-- Feature 4 -->
            <div class="group p-6 bg-slate-50 dark:bg-slate-800 rounded-2xl hover:shadow-xl transition-all duration-300 border border-slate-200 dark:border-slate-700 hover:border-purple-300 dark:hover:border-purple-600">
                <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">{{ __('frontend.easy_management') }}</h3>
                <p class="text-slate-600 dark:text-slate-400">{{ __('frontend.easy_management_desc') }}</p>
            </div>

            <!-- Feature 5 -->
            <div class="group p-6 bg-slate-50 dark:bg-slate-800 rounded-2xl hover:shadow-xl transition-all duration-300 border border-slate-200 dark:border-slate-700 hover:border-purple-300 dark:hover:border-purple-600">
                <div class="w-14 h-14 bg-gradient-to-br from-pink-500 to-rose-500 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">{{ __('frontend.auto_backup') }}</h3>
                <p class="text-slate-600 dark:text-slate-400">{{ __('frontend.auto_backup_desc') }}</p>
            </div>

            <!-- Feature 6 -->
            <div class="group p-6 bg-slate-50 dark:bg-slate-800 rounded-2xl hover:shadow-xl transition-all duration-300 border border-slate-200 dark:border-slate-700 hover:border-purple-300 dark:hover:border-purple-600">
                <div class="w-14 h-14 bg-gradient-to-br from-teal-500 to-green-500 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">{{ __('frontend.ssl_certificate') }}</h3>
                <p class="text-slate-600 dark:text-slate-400">{{ __('frontend.ssl_certificate_desc') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-blue-600 to-cyan-600 relative overflow-hidden">
    <div class="absolute inset-0 bg-black/10"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                {{ __('frontend.ready_to_start') }}
            </h2>
            <p class="text-lg text-blue-100 mb-8">
                {{ __('frontend.ready_to_start_desc') }}
            </p>
            <a href="#plans" class="inline-flex items-center gap-2 px-8 py-4 bg-white hover:bg-slate-50 text-blue-600 font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200">
                {{ __('frontend.start_now') }}
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
        </div>
    </div>
</section>

@push('styles')
<style>
    /* Slow Spin Animation for Hero Circle */
    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    @keyframes spin-slow-reverse {
        from { transform: rotate(360deg); }
        to { transform: rotate(0deg); }
    }
    .animate-spin-slow {
        animation: spin-slow 20s linear infinite;
    }
    .animate-spin-slow-reverse {
        animation: spin-slow-reverse 15s linear infinite;
    }
    
    /* Animation Delays */
    .animation-delay-1000 { animation-delay: 1s; }
    .animation-delay-2000 { animation-delay: 2s; }
    
    /* Glass Card Effect */
    .glass-card {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        box-shadow: 
            0 8px 32px 0 rgba(59, 130, 246, 0.15),
            inset 0 1px 0 0 rgba(255, 255, 255, 0.6),
            inset 0 -1px 0 0 rgba(255, 255, 255, 0.3);
    }
    
    .dark .glass-card {
        background: rgba(30, 41, 59, 0.5);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        box-shadow: 
            0 8px 32px 0 rgba(0, 0, 0, 0.3),
            inset 0 1px 0 0 rgba(255, 255, 255, 0.05),
            inset 0 -1px 0 0 rgba(255, 255, 255, 0.02);
    }
    
    /* Glass Button Effect */
    .glass-button {
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        box-shadow: 
            0 4px 16px rgba(59, 130, 246, 0.4),
            inset 0 1px 0 0 rgba(255, 255, 255, 0.4);
    }
    
    .glass-button:hover {
        box-shadow: 
            0 8px 24px rgba(59, 130, 246, 0.6),
            inset 0 1px 0 0 rgba(255, 255, 255, 0.5);
    }
    
    /* Glass Icon Effect */
    .glass-icon {
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        box-shadow: 
            0 4px 12px rgba(59, 130, 246, 0.15),
            inset 0 1px 0 0 rgba(255, 255, 255, 0.3);
    }
    
    /* Glass Stat Card Effect */
    .glass-stat {
        background: rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(15px) saturate(180%);
        -webkit-backdrop-filter: blur(15px) saturate(180%);
        box-shadow: 
            0 4px 16px 0 rgba(59, 130, 246, 0.1),
            inset 0 1px 0 0 rgba(255, 255, 255, 0.5);
        transition: all 0.3s ease;
    }
    
    .dark .glass-stat {
        background: rgba(30, 41, 59, 0.4);
        backdrop-filter: blur(15px) saturate(180%);
        -webkit-backdrop-filter: blur(15px) saturate(180%);
        box-shadow: 
            0 4px 16px 0 rgba(0, 0, 0, 0.2),
            inset 0 1px 0 0 rgba(255, 255, 255, 0.05);
    }
    
    .glass-stat:hover {
        transform: translateY(-4px);
        box-shadow: 
            0 8px 24px 0 rgba(59, 130, 246, 0.2),
            inset 0 1px 0 0 rgba(255, 255, 255, 0.6);
    }
    
    .dark .glass-stat:hover {
        box-shadow: 
            0 8px 24px 0 rgba(0, 0, 0, 0.3),
            inset 0 1px 0 0 rgba(255, 255, 255, 0.1);
    }

    /* Grid Pattern */
    .bg-grid-pattern {
        background-image: 
            linear-gradient(rgba(148, 163, 184, 0.1) 1px, transparent 1px),
            linear-gradient(90deg, rgba(148, 163, 184, 0.1) 1px, transparent 1px);
        background-size: 50px 50px;
    }

    /* Blob Animation */
    @keyframes blob {
        0%, 100% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
    }
    .animate-blob {
        animation: blob 7s infinite;
    }
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    .animation-delay-4000 {
        animation-delay: 4s;
    }

    /* Fade In */
    @keyframes fade-in {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    .animate-fade-in {
        animation: fade-in 0.6s ease-out;
    }

    /* Fade In Up */
    @keyframes fade-in-up {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .animate-fade-in-up {
        animation: fade-in-up 0.6s ease-out;
    }

    /* Floating Animation */
    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-20px);
        }
    }
    .animate-float {
        animation: float 3s ease-in-out infinite;
    }

    /* Animation Delays */
    .animation-delay-200 {
        animation-delay: 0.2s;
        animation-fill-mode: backwards;
    }
    .animation-delay-400 {
        animation-delay: 0.4s;
        animation-fill-mode: backwards;
    }
    .animation-delay-600 {
        animation-delay: 0.6s;
        animation-fill-mode: backwards;
    }
    .animation-delay-800 {
        animation-delay: 0.8s;
        animation-fill-mode: backwards;
    }
    .animation-delay-1000 {
        animation-delay: 1s;
        animation-fill-mode: backwards;
    }
    .animation-delay-1200 {
        animation-delay: 1.2s;
        animation-fill-mode: backwards;
    }

    /* Pulse Animation with Delay */
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
    }
    
    /* Smooth Gradient Text */
    .bg-clip-text {
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.getElementById('domainSearchForm');
    const searchButton = document.getElementById('searchButton');
    const searchText = document.getElementById('searchText');
    const searchIcon = document.getElementById('searchIcon');
    const loadingIcon = document.getElementById('loadingIcon');
    const resultsContainer = document.getElementById('searchResults');
    const domainInput = document.getElementById('domainInput');
    
    // Transfer form elements
    const transferForm = document.getElementById('domainTransferForm');
    const transferDomainInput = document.getElementById('transferDomainInput');
    const authCodeInput = document.getElementById('authCodeInput');
    const transferButton = document.getElementById('transferButton');
    const transferText = document.getElementById('transferText');
    const transferIcon = document.getElementById('transferIcon');
    const transferLoadingIcon = document.getElementById('transferLoadingIcon');
    const transferResultsContainer = document.getElementById('transferResults');
    
    const isRTL = '{{ app()->getLocale() }}' === 'ar';
    
    // Domain Search Handler - only if form exists
    if (searchForm) {
    searchForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const domain = domainInput.value.trim();
        if (!domain) {
            showError('{{ __("frontend.please_enter_domain") }}');
            return;
        }
        
        // Show loading state
        searchButton.disabled = true;
        searchText.textContent = '{{ __("frontend.searching_domains") }}';
        searchIcon.classList.add('hidden');
        loadingIcon.classList.remove('hidden');
        resultsContainer.innerHTML = '';
        resultsContainer.classList.add('hidden');
        
        try {
            const response = await fetch(`{{ route('domains.search') }}?domain=${encodeURIComponent(domain)}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            const data = await response.json();
            
            if (data.success && data.results && data.results.length > 0) {
                displayResults(data.results, data.searchTerm);
            } else {
                showError(data.message || '{{ __("frontend.no_results_found") }}');
            }
        } catch (error) {
            console.error('Search error:', error);
            showError('{{ __("frontend.domain_search_error") }}');
        } finally {
            // Reset button state
            searchButton.disabled = false;
            searchText.textContent = '{{ __("frontend.search_now") }}';
            searchIcon.classList.remove('hidden');
            loadingIcon.classList.add('hidden');
        }
    });
    
    function displayResults(results, searchTerm) {
        resultsContainer.classList.remove('hidden');
        
        // Don't re-sort results - they are already sorted by backend
        // (Original domain first, then featured TLDs, then others)
        
        let html = `
            <div class="glass-card p-6 rounded-3xl border border-white/30">
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-3">
                    <svg class="w-7 h-7 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    ${isRTL ? 'نتائج البحث لـ' : 'Search Results for'} <span class="text-blue-600 dark:text-blue-400">${escapeHtml(searchTerm)}</span>
                </h3>
                
                <!-- Results List with Scrollbar -->
                <div class="max-h-96 overflow-y-auto pr-2 space-y-3" style="scrollbar-width: thin; scrollbar-color: rgb(59 130 246) rgb(226 232 240);">
        `;
        
        // Display all results in backend-provided order
        results.forEach(result => {
            html += createDomainListItem(result, result.available);
        });
        
        html += `
                </div>
            </div>
        `;
        
        resultsContainer.innerHTML = html;
    }
    
    function createDomainListItem(result, available) {
        const statusBadge = available 
            ? `<span class="px-3 py-1 bg-green-500/20 text-green-700 dark:text-green-300 rounded-lg font-bold text-xs border border-green-500/30 inline-flex items-center gap-1">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ __("frontend.domain_available") }}
            </span>`
            : `<span class="px-3 py-1 bg-red-500/20 text-red-700 dark:text-red-300 rounded-lg font-bold text-xs border border-red-500/30 inline-flex items-center gap-1">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                {{ __("frontend.domain_unavailable") }}
            </span>`;
        
        const priceSection = available 
            ? `<div class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div>
                        <div class="text-xs text-slate-600 dark:text-slate-400">{{ __("frontend.register_price") }}</div>
                        <div class="text-xl font-bold text-blue-600 dark:text-blue-400">
                            ${formatPrice(result.price)}
                        </div>
                    </div>
                    ${result.renew_price ? `<div>
                        <div class="text-xs text-slate-600 dark:text-slate-400">{{ __("frontend.renew_price") }}</div>
                        <div class="text-sm font-semibold text-slate-700 dark:text-slate-300">
                            ${formatPrice(result.renew_price)}
                        </div>
                    </div>` : ''}
                </div>
                <button onclick="addToCart('${escapeHtml(result.domain)}', ${result.price})" 
                        class="px-4 py-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center gap-2 text-sm whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    {{ __("frontend.add_to_cart") }}
                </button>
            </div>`
            : `<div class="text-xs text-slate-500 dark:text-slate-400">
                ${isRTL ? 'غير متاح للتسجيل' : 'Not available for registration'}
            </div>`;
        
        return `
            <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm border ${available ? 'border-green-200 dark:border-green-800/50 hover:border-green-300' : 'border-slate-200 dark:border-slate-700'} rounded-xl p-4 transition-all duration-200 hover:shadow-md">
                <div class="flex items-center justify-between gap-4 flex-wrap">
                    <div class="flex items-center gap-3 min-w-0 flex-1">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 ${available ? 'text-green-600' : 'text-slate-400'}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h4 class="text-lg font-bold text-slate-900 dark:text-white truncate">
                                ${escapeHtml(result.domain)}
                            </h4>
                            <div class="flex items-center gap-2 mt-1">
                                ${statusBadge}
                                <span class="text-xs text-slate-500 dark:text-slate-400">${result.tld.toUpperCase()}</span>
                            </div>
                        </div>
                    </div>
                    ${priceSection}
                </div>
            </div>
        `;
    }
    
    function showError(message) {
        resultsContainer.classList.remove('hidden');
        resultsContainer.innerHTML = `
            <div class="glass-card p-6 rounded-3xl border border-red-200 dark:border-red-800/50 bg-red-50/50 dark:bg-red-900/20">
                <div class="flex items-center gap-3 text-red-700 dark:text-red-300">
                    <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <p class="font-medium">${escapeHtml(message)}</p>
                </div>
            </div>
        `;
    }
    
    function formatPrice(price) {
        const currency = isRTL ? 'دولار' : 'USD';
        const formattedPrice = parseFloat(price).toFixed(2);
        return isRTL ? `${formattedPrice} ${currency}` : `$${formattedPrice}`;
    }
    
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Transfer Domain Handler
    transferForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const domain = transferDomainInput.value.trim();
        const authCode = authCodeInput.value.trim();
        
        if (!domain || !authCode) {
            showTransferError('{{ __("frontend.please_enter_domain") }}');
            return;
        }
        
        // Show loading state
        transferButton.disabled = true;
        transferText.textContent = '{{ __("frontend.checking_transfer_eligibility") }}';
        transferIcon.classList.add('hidden');
        transferLoadingIcon.classList.remove('hidden');
        transferResultsContainer.innerHTML = '';
        transferResultsContainer.classList.add('hidden');
        
        try {
            const response = await fetch('{{ route("domains.transfer.validate") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    domain: domain,
                    auth_code: authCode
                })
            });
            
            const data = await response.json();
            
            if (data.success && data.data.eligible) {
                displayTransferSuccess(data.data);
            } else {
                showTransferError(data.data.message || '{{ __("frontend.transfer_check_failed") }}');
            }
        } catch (error) {
            console.error('Transfer validation error:', error);
            showTransferError('{{ __("frontend.transfer_validation_error") }}');
        } finally {
            // Reset button state
            transferButton.disabled = false;
            transferText.textContent = '{{ __("frontend.start_transfer") }}';
            transferIcon.classList.remove('hidden');
            transferLoadingIcon.classList.add('hidden');
        }
    });

    function displayTransferSuccess(data) {
        transferResultsContainer.classList.remove('hidden');
        
        let html = `
            <div class="glass-card p-6 rounded-3xl border border-green-200 dark:border-green-800/50 bg-green-50/50 dark:bg-green-900/20">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        <svg class="w-12 h-12 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-2xl font-bold text-green-800 dark:text-green-300 mb-2">
                            {{ __('frontend.transfer_validated') }}
                        </h3>
                        <p class="text-lg text-green-700 dark:text-green-400 mb-4">
                            ${data.message}
                        </p>
                        
                        <div class="bg-white/70 dark:bg-slate-800/70 rounded-xl p-4 mb-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-sm text-slate-600 dark:text-slate-400">{{ __('frontend.domain') }}</div>
                                    <div class="text-xl font-bold text-slate-900 dark:text-white">${escapeHtml(data.display_domain || data.domain)}</div>
                                </div>
                                ${data.transfer_price ? `
                                <div class="text-right">
                                    <div class="text-sm text-slate-600 dark:text-slate-400">{{ __('frontend.transfer_price') }}</div>
                                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">${formatPrice(data.transfer_price)}</div>
                                </div>
                                ` : ''}
                            </div>
                        </div>
                        
                        ${data.notes && data.notes.length > 0 ? `
                        <div class="bg-blue-50/50 dark:bg-blue-900/20 rounded-xl p-4 mb-4">
                            <h4 class="text-sm font-bold text-blue-800 dark:text-blue-300 mb-2">
                                ${ isRTL ? 'ملاحظات هامة' : 'Important Notes' }:
                            </h4>
                            <ul class="space-y-2">
                                ${data.notes.map(note => `
                                <li class="flex items-start gap-2 text-sm text-blue-700 dark:text-blue-400">
                                    <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>${escapeHtml(note)}</span>
                                </li>
                                `).join('')}
                            </ul>
                        </div>
                        ` : ''}
                        
                        <button 
                            onclick="proceedToTransferCart('${escapeHtml(data.domain)}', ${data.transfer_price || 0})"
                            class="w-full px-6 py-4 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold text-lg rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center justify-center gap-3"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            {{ __('frontend.proceed_to_cart') }}
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        transferResultsContainer.innerHTML = html;
    }

    function showTransferError(message) {
        transferResultsContainer.classList.remove('hidden');
        transferResultsContainer.innerHTML = `
            <div class="glass-card p-6 rounded-3xl border border-red-200 dark:border-red-800/50 bg-red-50/50 dark:bg-red-900/20">
                <div class="flex items-center gap-3 text-red-700 dark:text-red-300">
                    <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <p class="font-medium">${escapeHtml(message)}</p>
                </div>
            </div>
        `;
    }
});

// Add to cart function for transfer
function proceedToTransferCart(domain, price) {
    // TODO: Implement cart functionality for domain transfer
    alert(`Adding ${domain} transfer to cart for ${price}`);
    console.log('Add transfer to cart:', { domain, price, type: 'transfer' });
}

// Add to cart function (to be implemented with cart system)
function addToCart(domain, price) {
    // TODO: Implement cart functionality
    alert(`Adding ${domain} to cart for ${price}`);
    console.log('Add to cart:', { domain, price });
}

// Typewriter effect for domain search input
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('stickyDomainInput');
    
    // Exit if input doesn't exist
    if (!input) return;
    
    const examples = ['mybusiness.com', 'yourcompany.net', 'startup.org', 'portfolio.io', 'shop.store'];
    let exampleIndex = 0;
    let charIndex = 0;
    let isDeleting = false;
    let isUserTyping = false;
    
    // Stop animation when user focuses on input
    input.addEventListener('focus', function() {
        isUserTyping = true;
        input.placeholder = '';
    });
    
    // Resume animation when user leaves input empty
    input.addEventListener('blur', function() {
        if (input.value === '') {
            isUserTyping = false;
            charIndex = 0;
            isDeleting = false;
            typeWriter();
        }
    });
    
    function typeWriter() {
        if (isUserTyping) return;
        
        const currentExample = examples[exampleIndex];
        
        if (isDeleting) {
            // Deleting
            input.placeholder = currentExample.substring(0, charIndex - 1);
            charIndex--;
            
            if (charIndex === 0) {
                isDeleting = false;
                exampleIndex = (exampleIndex + 1) % examples.length;
                setTimeout(typeWriter, 400); // Pause before typing next
                return;
            }
            setTimeout(typeWriter, 80); // Delete speed
        } else {
            // Typing
            input.placeholder = currentExample.substring(0, charIndex + 1);
            charIndex++;
            
            if (charIndex === currentExample.length) {
                isDeleting = true;
                setTimeout(typeWriter, 1500); // Pause at end before deleting
                return;
            }
            setTimeout(typeWriter, 120); // Typing speed
        }
    }
    
    // Start the typewriter effect
    typeWriter();
});

// Domain Search Results Modal Functions - wrap in DOMContentLoaded
document.addEventListener('DOMContentLoaded', function() {
    const searchResultsModal = document.getElementById('domainSearchResults');
    const searchResultsBackdrop = document.getElementById('searchResultsBackdrop');
    const searchResultsPanel = document.getElementById('searchResultsPanel');
    const searchResultsLoading = document.getElementById('searchResultsLoading');
    const searchResultsContent = document.getElementById('searchResultsContent');
    const searchedDomainName = document.getElementById('searchedDomainName');
    const closeSearchResultsBtn = document.getElementById('closeSearchResults');
    
    // Check if modal elements exist
    if (!searchResultsModal) return;

    function openSearchResults() {
        // Enable pointer events on modal
        searchResultsModal.style.pointerEvents = 'auto';
        searchResultsBackdrop.style.pointerEvents = 'auto';
        
        // Trigger animation after a small delay
        setTimeout(() => {
            searchResultsBackdrop.classList.remove('opacity-0');
            searchResultsBackdrop.classList.add('opacity-100');
            // Slide panel from bottom (100%) to top (60px)
            searchResultsPanel.style.top = '60px';
        }, 10);
        document.body.style.overflow = 'hidden';
    }

function closeSearchResults() {
    searchResultsBackdrop.classList.remove('opacity-100');
    searchResultsBackdrop.classList.add('opacity-0');
    // Slide panel back down
    searchResultsPanel.style.top = '100%';
    
    setTimeout(() => {
        searchResultsModal.style.pointerEvents = 'none';
        searchResultsBackdrop.style.pointerEvents = 'none';
    }, 700);
    document.body.style.overflow = '';
}

// Close on backdrop click
searchResultsBackdrop?.addEventListener('click', closeSearchResults);
closeSearchResultsBtn?.addEventListener('click', closeSearchResults);

// Close on Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && searchResultsPanel.style.top === '60px') {
        closeSearchResults();
    }
});

// Shared function to search domain
async function searchDomain(domain) {
    if (!domain) return;
    
    // Update the modal input with searched domain
    const modalInput = document.getElementById('modalDomainInput');
    if (modalInput) modalInput.value = domain;
    
    // Show modal with loading
    searchedDomainName.textContent = domain;
    searchResultsLoading.classList.remove('hidden');
    searchResultsContent.innerHTML = '';
    openSearchResults();
    
    try {
        // Make API call to check domain availability
        const response = await fetch('{{ route("domains.check") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ domain: domain })
        });
        
        const data = await response.json();
        
        // Hide loading
        searchResultsLoading.classList.add('hidden');
        
        // Display results
        displayDomainResults(domain, data);
        
    } catch (error) {
        console.error('Search error:', error);
        searchResultsLoading.classList.add('hidden');
        searchResultsContent.innerHTML = `
            <div class="text-center py-8">
                <svg class="w-16 h-16 mx-auto text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="mt-4 text-gray-600">{{ __('frontend.search_error') }}</p>
            </div>
        `;
    }
}

// Handle sticky domain search form submit
document.getElementById('stickyDomainSearchForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    const domainInput = document.getElementById('stickyDomainInput');
    searchDomain(domainInput.value.trim());
});

// Handle modal domain search form submit
document.getElementById('modalDomainSearchForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    const domainInput = document.getElementById('modalDomainInput');
    searchDomain(domainInput.value.trim());
});

function displayDomainResults(searchedDomain, data) {
    // Parse domain name and extension
    const parts = searchedDomain.split('.');
    const name = parts[0];
    const searchedTld = parts.length > 1 ? parts.slice(1).join('.') : 'com';
    
    // Translation strings
    const translations = {
        available: '{{ __("frontend.available_for_registration") }}',
        notAvailable: '{{ __("frontend.not_available") }}',
        addToCart: '{{ __("frontend.add_to_cart") }}',
        add: '{{ __("frontend.add") }}',
        otherExtensions: '{{ __("frontend.other_available_extensions") }}'
    };
    
    let html = '<div class="space-y-4">';
    
    // Main domain result
    const isAvailable = data.available !== false;
    html += `
        <div class="p-4 rounded-xl border-2 ${isAvailable ? 'border-green-200 bg-green-50' : 'border-red-200 bg-red-50'}">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="w-10 h-10 rounded-full flex items-center justify-center ${isAvailable ? 'bg-green-500' : 'bg-red-500'}">
                        ${isAvailable ? 
                            '<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>' :
                            '<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>'
                        }
                    </span>
                    <div>
                        <p class="font-bold text-lg text-gray-900">${name}.${searchedTld}</p>
                        <p class="text-sm ${isAvailable ? 'text-green-600' : 'text-red-600'}">${isAvailable ? translations.available : translations.notAvailable}</p>
                    </div>
                </div>
                ${isAvailable ? `
                    <div class="text-right">
                        <p class="text-2xl font-bold text-gray-900">$${data.price || '12.99'}</p>
                        <button onclick="addToCart('${name}.${searchedTld}', '${data.price || '12.99'}')" class="mt-2 px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-full text-sm font-medium transition-colors">
                            ${translations.addToCart}
                        </button>
                    </div>
                ` : ''}
            </div>
        </div>
    `;
    
    // Suggestions with other TLDs
    const suggestions = data.suggestions || [
        { tld: 'net', price: '14.99', available: true },
        { tld: 'org', price: '12.99', available: true },
        { tld: 'io', price: '39.99', available: true },
        { tld: 'co', price: '29.99', available: true },
    ];
    
    if (suggestions.length > 0) {
        html += `
            <div class="mt-6">
                <h4 class="text-sm font-semibold text-gray-500 uppercase mb-3">${translations.otherExtensions}</h4>
                <div class="grid gap-3">
        `;
        
        suggestions.forEach(s => {
            if (s.available !== false) {
                html += `
                    <div class="p-3 rounded-lg border border-gray-200 bg-white hover:border-blue-300 hover:shadow-sm transition-all flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <span class="font-medium text-gray-900">${name}.${s.tld}</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="font-bold text-gray-900">$${s.price}</span>
                            <button onclick="addToCart('${name}.${s.tld}', '${s.price}')" class="px-4 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-full text-sm font-medium transition-colors">
                                ${translations.add}
                            </button>
                        </div>
                    </div>
                `;
            }
        });
        
        html += '</div></div>';
    }
    
    html += '</div>';
    searchResultsContent.innerHTML = html;
}
}); // End of DOMContentLoaded for modal
</script>
@endpush
@endsection
