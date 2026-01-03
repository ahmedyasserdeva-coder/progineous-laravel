<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- SEO Meta Tags -->
    <title>@yield('title', config('app.name'))</title>
    <meta name="description" content="@yield('description', setting('company_name', config('app.name')))">
    <meta name="keywords" content="@yield('keywords', 'hosting, cloud, vps, servers')">
    <meta name="author" content="{{ setting('company_name', config('app.name')) }}">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('title', config('app.name'))">
    <meta property="og:description" content="@yield('description', setting('company_name', config('app.name')))">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    @if(setting('website_logo'))
    <meta property="og:image" content="{{ asset('storage/' . setting('website_logo')) }}">
    @endif
    
    <!-- Favicon -->
    @if(!empty($favicon))
        @php
            $faviconPath = asset('storage/' . $favicon);
            $faviconExt = pathinfo($favicon, PATHINFO_EXTENSION);
            $faviconType = $faviconExt === 'svg' ? 'image/svg+xml' : ($faviconExt === 'png' ? 'image/png' : 'image/x-icon');
        @endphp
        <link rel="icon" type="{{ $faviconType }}" href="{{ $faviconPath }}">
        <link rel="shortcut icon" type="{{ $faviconType }}" href="{{ $faviconPath }}">
        <link rel="apple-touch-icon" href="{{ $faviconPath }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @endif
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @if(app()->getLocale() == 'ar')
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @else
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @endif
    
    <!-- Flag Icons Library -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.2.3/css/flag-icons.min.css">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Intercom Configuration -->
    @php
        $intercomConfig = \App\Helpers\IntercomHelper::getConfig();
    @endphp
    <script id="intercom-config" type="application/json">
        {!! json_encode($intercomConfig) !!}
    </script>
    
    <!-- User Data for Intercom -->
    @auth('client')
        @php
            $userData = \App\Helpers\IntercomHelper::getUserData(auth('client')->user());
        @endphp
        <script id="user-data" type="application/json">
            {!! json_encode($userData) !!}
        </script>
    @endauth
    
    <!-- Additional Styles -->
    <style>
        :root {
            --nav-height: 75px;
            --campaign-banner-height: 75px;
            --glass-bg: rgba(255, 255, 255, 0.7);
            --glass-border: rgba(255, 255, 255, 0.3);
            --glass-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            --blur-amount: 35px;
            
            /* Golden Ratio Variables (1.618) */
            --golden-ratio: 1.618;
            --base-size: 16px;
            --space-xs: 8px;      /* base / 2 */
            --space-sm: 13px;     /* 8 * 1.618 ≈ 13px */
            --space-md: 21px;     /* 13 * 1.618 ≈ 21px */
            --space-lg: 34px;     /* 21 * 1.618 ≈ 34px */
            --space-xl: 55px;     /* 34 * 1.618 ≈ 55px */
            
            /* Icon sizes based on golden ratio */
            --icon-sm: 16px;      /* base */
            --icon-md: 24px;      /* 16 * 1.5 */
            --icon-lg: 34px;      /* adjusted for better fit */
            
            /* Border radius based on golden ratio */
            --radius-sm: 8px;
            --radius-md: 13px;
            --radius-lg: 21px;
            
            /* Typography sizes */
            --text-xs: 12px;      /* 0.75 * base */
            --text-sm: 14px;      /* 0.875 * base */
            --text-base: 16px;    /* base */
            --text-lg: 18px;      /* 1.125 * base */
            --text-xl: 20px;      /* 1.25 * base */
        }

        * {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Campaign Banner Animations - Minimized */
        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        #campaign-banner {
            animation: slideDown 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Prevent flash during slide transitions */
        [x-cloak] { display: none !important; }
        
        /* Smooth slide container */
        .campaign-slide-container {
            position: relative;
            min-height: 56px;
        }

        /* Smooth transitions for navigation */
        nav {
            transition: top 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        main {
            transition: padding-top 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Modern Campaign Banner Gradient - Professional */
        .campaign-gradient {
            background: linear-gradient(135deg, 
                #667eea 0%, 
                #764ba2 100%
            );
            position: relative;
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);
        }
        
        .campaign-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, 
                transparent 0%, 
                rgba(255, 255, 255, 0.1) 50%, 
                transparent 100%
            );
            pointer-events: none;
        }

        /* Subtle Icon Animation */
        @keyframes subtleFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-3px); }
        }

        .subtle-float {
            animation: subtleFloat 4s ease-in-out infinite;
        }

        /* Subtle Pulse for Badge */
        @keyframes subtlePulse {
            0%, 100% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.03);
                opacity: 0.95;
            }
        }

        .subtle-pulse {
            animation: subtlePulse 3s ease-in-out infinite;
        }

        /* Enhanced Button Hover - Simplified */
        .shop-btn {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .shop-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transform: translateX(-100%);
            transition: transform 0.6s;
        }

        .shop-btn:hover::before {
            transform: translateX(100%);
        }

        .shop-btn span {
            position: relative;
            z-index: 1;
        }

        /* Countdown Timer Style - Professional */
        .countdown-timer {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* Progress Dots Enhancement */
        .dot-indicator {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .dot-indicator:hover {
            transform: scale(1.2);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        /* Campaign Close Button Enhancement */
        .close-campaign-btn {
            transition: all 0.2s ease;
            border-radius: 50%;
        }

        .close-campaign-btn:hover {
            transform: rotate(90deg);
            background: rgba(255, 255, 255, 0.2);
        }
        
        /* Professional Badge Styling */
        .campaign-badge {
            box-shadow: 0 2px 8px rgba(124, 58, 237, 0.3);
            transition: all 0.3s ease;
        }
        
        .campaign-badge:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.4);
        }
        
        /* Icon Container Professional Shadow */
        .campaign-icon-container {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }
        
        .campaign-icon-container:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }
        
        /* Navigation Arrows Professional Style */
        .campaign-nav-btn {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            transition: all 0.2s ease;
        }
        
        .campaign-nav-btn:hover:not(:disabled) {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        body {
            @if(app()->getLocale() == 'ar')
            font-family: 'Cairo', sans-serif;
            @else
            font-family: 'Inter', sans-serif;
            @endif
            background: #ffffff;
            min-height: 100vh;
        }

        /* Glass Morphism Effect */
        .glass {
            background: rgba(190, 216, 255, 0.973) !important;
            backdrop-filter: blur(100px) saturate(200%) brightness(1.1) !important;
            -webkit-backdrop-filter: blur(70px) saturate(200%) brightness(1.1) !important;
            border-bottom: 1px solid rgba(191, 219, 254, 0.6);
            box-shadow: 0 4px 30px rgba(59, 130, 246, 0.15);
            isolation: isolate;
            will-change: backdrop-filter;
            }
        

        /* Navigation Styles */
        .nav-glass {
            background: rgb(190, 216, 255) !important;
            border-bottom: 1px solid rgba(191, 219, 254, 0.6);
            box-shadow: 0 4px 30px rgba(59, 130, 246, 0.15);
        }

        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
            scroll-padding-top: var(--nav-height);
        }

        /* Mobile Menu Animation */
        .mobile-menu {
            transform: translateX(100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .mobile-menu.active {
            transform: translateX(0);
        }

        @if(app()->getLocale() == 'ar')
        .mobile-menu {
            transform: translateX(-100%);
        }
        
        .mobile-menu.active {
            transform: translateX(0);
        }
        @endif

        /* Hover Effects */
        .nav-link {
            position: relative;
            transition: color 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            @if(app()->getLocale() == 'ar')
            right: 0;
            @else
            left: 0;
            @endif
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }

        /* Responsive Typography */
        @media (max-width: 640px) {
            :root {
                --nav-height: 70px;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(59, 130, 246, 0.5);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(59, 130, 246, 0.7);
        }

        /* Footer Glass Morphism */
        .glass-footer {
            background: rgba(255, 255, 255, 0.6) !important;
            backdrop-filter: blur(60px) saturate(180%) brightness(1.05) !important;
            -webkit-backdrop-filter: blur(60px) saturate(180%) brightness(1.05) !important;
            box-shadow: 0 -10px 40px rgba(59, 130, 246, 0.1);
        }

        /* Animated Blobs */
        @keyframes blob {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            25% {
                transform: translate(20px, -20px) scale(1.1);
            }
            50% {
                transform: translate(-20px, 20px) scale(0.9);
            }
            75% {
                transform: translate(20px, 20px) scale(1.05);
            }
        }

        .animate-blob {
            animation: blob 20s ease-in-out infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        /* Smooth hover effects */
        .group:hover .group-hover\:translate-x-1 {
            transform: translateX(0.25rem);
        }

        [dir="rtl"] .group:hover .rtl\:group-hover\:-translate-x-1 {
            transform: translateX(-0.25rem);
        }
    </style>
    
    @stack('meta')
    @stack('styles')
</head>
<body x-data="navigation" x-init="init()" class="antialiased">
    <!-- Active Campaigns Banner -->
    @if(isset($activeCampaigns) && $activeCampaigns->count() > 0)
    <div class="sticky top-0 left-0 right-0 z-[60] campaign-gradient text-white overflow-hidden" 
         x-data="{ 
             currentIndex: 0, 
             campaigns: {{ $activeCampaigns->count() }},
             autoPlay: true,
             isTransitioning: false,
             startAutoPlay() {
                 setInterval(() => {
                     if (this.autoPlay && !this.isTransitioning) {
                         this.nextSlide();
                     }
                 }, 10000); // 10 seconds for better readability
             },
             nextSlide() {
                 this.isTransitioning = true;
                 this.currentIndex = (this.currentIndex + 1) % this.campaigns;
                 setTimeout(() => { this.isTransitioning = false; }, 400);
             },
             prevSlide() {
                 this.isTransitioning = true;
                 this.currentIndex = (this.currentIndex - 1 + this.campaigns) % this.campaigns;
                 setTimeout(() => { this.isTransitioning = false; }, 400);
             },
             goToSlide(index) {
                 if (!this.isTransitioning) {
                     this.isTransitioning = true;
                     this.currentIndex = index;
                     setTimeout(() => { this.isTransitioning = false; }, 400);
                 }
             }
         }"
         x-init="startAutoPlay()"
         @mouseenter="autoPlay = false"
         @mouseleave="autoPlay = true"
         id="campaign-banner">
        
        <!-- Subtle Background Pattern -->
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 32px 32px;"></div>

        <!-- Campaigns Slider -->
        <div class="relative z-10 campaign-slide-container">
            @foreach($activeCampaigns as $index => $campaign)
            <div x-show="currentIndex === {{ $index }}" 
                 x-cloak
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform translate-x-4"
                 x-transition:enter-end="opacity-100 transform translate-x-0"
                 x-transition:leave="transition ease-in duration-200 absolute inset-0"
                 x-transition:leave-start="opacity-100 transform translate-x-0"
                 x-transition:leave-end="opacity-0 transform -translate-x-4"
                 style="padding: var(--space-xs) var(--space-md);">
                <div class="max-w-7xl mx-auto flex items-center justify-between" style="gap: var(--space-md);">
                    
                    <!-- Left Side: Icon + Info -->
                    <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'flex-row-reverse' : '' }} flex-1 min-w-0" style="gap: var(--space-sm);">
                        
                        <!-- Campaign Icon with Subtle Animation -->
                        <div class="hidden sm:flex items-center justify-center bg-white/25 backdrop-blur-md subtle-float flex-shrink-0 border border-white/40 campaign-icon-container" style="width: var(--icon-lg); height: var(--icon-lg); border-radius: var(--radius-md);">
                            @if($campaign->type === 'seasonal')
                                <svg class="text-white drop-shadow-lg" style="width: var(--icon-md); height: var(--icon-md);" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M11.5 0.5v6.5l-3.6-3.6-1.4 1.4 4.3 4.3h-6.8v2h6.8l-4.3 4.3 1.4 1.4 3.6-3.6v6.5h2v-6.5l3.6 3.6 1.4-1.4-4.3-4.3h6.8v-2h-6.8l4.3-4.3-1.4-1.4-3.6 3.6v-6.5h-2z"/>
                                </svg>
                            @elseif($campaign->type === 'product_launch')
                                <svg class="text-white drop-shadow-lg" style="width: var(--icon-md); height: var(--icon-md);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            @else
                                <svg class="text-white drop-shadow-lg" style="width: var(--icon-md); height: var(--icon-md);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                                </svg>
                            @endif
                        </div>

                        <!-- Campaign Info -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center flex-wrap" style="gap: var(--space-xs);">
                                <!-- Campaign Name -->
                                <h3 class="font-bold tracking-tight drop-shadow-md" style="font-size: var(--text-lg);">
                                    {{ app()->getLocale() == 'ar' ? ($campaign->name_ar ?? $campaign->name) : ($campaign->name_en ?? $campaign->name) }}
                                </h3>
                                
                                <!-- Discount Badge with Professional Style -->
                                <span class="inline-flex items-center bg-white text-purple-700 font-bold campaign-badge flex-shrink-0" style="padding: var(--space-xs) var(--space-sm); border-radius: var(--radius-lg); font-size: var(--text-sm);">
                                    <svg class="{{ app()->getLocale() == 'ar' ? 'ml-1' : 'mr-1' }}" style="width: var(--text-sm); height: var(--text-sm);" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ number_format($campaign->discount_percentage, 0) }}% {{ __('crm.discount') }}
                                </span>

                                <!-- Campaign Type Badge -->
                                <span class="hidden md:inline-flex items-center bg-white/25 font-medium backdrop-blur-sm border border-white/40" style="padding: var(--space-xs) var(--space-sm); border-radius: var(--radius-sm); font-size: var(--text-xs); box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                    @if($campaign->type === 'seasonal')
                                        <svg class="{{ app()->getLocale() == 'ar' ? 'ml-1' : 'mr-1' }}" style="width: var(--text-xs); height: var(--text-xs);" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ __('crm.seasonal') }}
                                    @elseif($campaign->type === 'product_launch')
                                        <svg class="{{ app()->getLocale() == 'ar' ? 'ml-1' : 'mr-1' }}" style="width: var(--text-xs); height: var(--text-xs);" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        {{ __('crm.product_launch') }}
                                    @else
                                        <svg class="{{ app()->getLocale() == 'ar' ? 'ml-1' : 'mr-1' }}" style="width: var(--text-xs); height: var(--text-xs);" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ __('crm.loyalty_reward') }}
                                    @endif
                                </span>
                            </div>
                            
                            <!-- Description -->
                            <p class="text-white/95 hidden sm:block truncate font-light drop-shadow-sm" style="font-size: var(--text-sm); margin-top: 2px;">
                                @if(app()->getLocale() == 'ar')
                                    {{ Str::limit($campaign->description_ar ?? $campaign->description, 90) }}
                                @else
                                    {{ Str::limit($campaign->description_en ?? $campaign->description, 90) }}
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Right Side: Timer + Actions -->
                    <div class="flex items-center flex-shrink-0" style="gap: var(--space-sm);">
                        
                        <!-- Countdown Timer -->
                        @if($campaign->days_remaining > 0)
                        <div class="hidden lg:flex items-center countdown-timer" style="gap: var(--space-xs); padding: var(--space-xs) var(--space-sm); border-radius: var(--radius-sm); height: 34px;">
                            <svg class="text-white opacity-90 flex-shrink-0 drop-shadow-md" style="width: var(--icon-sm); height: var(--icon-sm);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="flex items-center" style="gap: var(--space-xs);">
                                <span class="font-bold leading-none" style="font-size: var(--text-lg);">{{ $campaign->days_remaining }}</span>
                                <span class="opacity-80 font-medium leading-none whitespace-nowrap" style="font-size: var(--text-sm);">
                                    {{ $campaign->days_remaining == 1 ? __('frontend.day_left') : __('frontend.days_left') }}
                                </span>
                            </div>
                        </div>
                        @endif

                        <!-- Shop Now Button -->
                        <a href="{{ route('products.hosting') }}" 
                           class="shop-btn bg-white text-purple-700 font-bold hover:bg-purple-50 transition-all duration-300 group flex-shrink-0" style="padding: var(--space-xs) var(--space-md); border-radius: var(--radius-sm); font-size: var(--text-sm); height: 34px; display: flex; align-items: center; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15); border: 1px solid rgba(124, 58, 237, 0.1);">
                            <span class="flex items-center" style="gap: var(--space-xs);">
                                {{ __('frontend.shop_now') }}
                                @if(app()->getLocale() == 'ar')
                                <svg class="transform group-hover:-translate-x-1 transition-transform drop-shadow-sm" style="width: var(--base-size); height: var(--base-size);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                @else
                                <svg class="transform group-hover:translate-x-1 transition-transform drop-shadow-sm" style="width: var(--base-size); height: var(--base-size);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                                @endif
                            </span>
                        </a>

                        <!-- Close Button -->
                        <button @click="
                            document.getElementById('campaign-banner').style.display = 'none';
                        " 
                                class="close-campaign-btn text-white/90 hover:text-white transition-all duration-200" style="padding: var(--space-xs); background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2);">
                            <svg style="width: var(--icon-sm); height: var(--icon-sm); filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.2));" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Navigation Arrows (if multiple campaigns) -->
        @if($activeCampaigns->count() > 1)
        <div class="absolute left-0 top-1/2 transform -translate-y-1/2 z-20 hidden md:block">
            <button @click="prevSlide()" 
                    :disabled="isTransitioning"
                    :class="isTransitioning ? 'opacity-50 cursor-not-allowed' : 'hover:bg-white/40'"
                    class="campaign-nav-btn bg-white/20 backdrop-blur-sm transition-all duration-200 border border-white/30" style="margin-left: var(--space-xs); padding: var(--space-xs); border-radius: var(--radius-sm);">
                <i class="fas fa-chevron-left text-white drop-shadow-md" style="font-size: var(--text-sm);"></i>
            </button>
        </div>
        <div class="absolute right-0 top-1/2 transform -translate-y-1/2 z-20 hidden md:block">
            <button @click="nextSlide()" 
                    :disabled="isTransitioning"
                    :class="isTransitioning ? 'opacity-50 cursor-not-allowed' : 'hover:bg-white/40'"
                    class="campaign-nav-btn bg-white/20 backdrop-blur-sm transition-all duration-200 border border-white/30" style="margin-right: var(--space-xs); padding: var(--space-xs); border-radius: var(--radius-sm);">
                <i class="fas fa-chevron-right text-white drop-shadow-md" style="font-size: var(--text-sm);"></i>
            </button>
        </div>

        <!-- Slider Indicators -->
        <div class="absolute left-1/2 transform -translate-x-1/2 flex z-20" style="bottom: 4px; gap: var(--space-xs);">
            @foreach($activeCampaigns as $index => $campaign)
            <button @click="goToSlide({{ $index }})" 
                    :disabled="isTransitioning"
                    class="dot-indicator rounded-full transition-all duration-300"
                    style="height: 6px;"
                    :style="currentIndex === {{ $index }} ? 'background: white; width: 24px;' : 'background: rgba(255,255,255,0.5); width: 6px;'"
                    @mouseenter="$el.style.background = 'rgba(255,255,255,0.8)'"
                    @mouseleave="if(currentIndex !== {{ $index }}) $el.style.background = 'rgba(255,255,255,0.5)'">
            </button>
            @endforeach
        </div>
        @endif
    </div>
    @endif

    <!-- Navigation -->
    <nav class="sticky top-0 left-0 right-0 z-50 nav-glass transition-all duration-300" 
         style="height: var(--nav-height);">
        <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-6 h-full">
            <div class="flex items-center justify-between h-full gap-4">
                <!-- Logo -->
                <div class="flex items-center flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }}">
                        @if(setting('website_logo'))
                            <img src="{{ asset('storage/' . setting('website_logo')) }}" 
                                 alt="{{ setting('company_name', config('app.name')) }}" 
                                 class="h-10 sm:h-11 lg:h-12 w-auto object-contain">
                        @else
                            <div class="flex items-center space-x-2 {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }}">
                                <div class="w-10 h-10 sm:w-11 sm:h-11 lg:w-12 lg:h-12 rounded-xl bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg sm:text-xl shadow-lg">
                                    {{ substr(setting('company_name', config('app.name')), 0, 1) }}
                                </div>
                                <span class="text-lg sm:text-xl lg:text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                    {{ setting('company_name', config('app.name')) }}
                                </span>
                            </div>
                        @endif
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex lg:items-center lg:space-x-1 {{ app()->getLocale() == 'ar' ? 'lg:space-x-reverse' : '' }}">
                    <!-- Domains Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                @click.away="open = false"
                                class="nav-link flex items-center space-x-1 {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} text-base font-medium text-gray-700 hover:text-blue-600 px-4 py-2 {{ request()->routeIs('domains.*') ? 'text-blue-600' : '' }}">
                            <span>{{ __('frontend.domains') }}</span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-95"
                             class="absolute {{ app()->getLocale() == 'ar' ? 'right-0' : 'left-0' }} mt-2 w-64 nav-glass rounded-xl shadow-lg py-2 z-50"
                             style="display: none;">
                            <a href="{{ route('domains.search') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-200">
                                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <span>{{ __('frontend.domain_name_search') }}</span>
                            </a>
                            <a href="{{ route('domains.transfer') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-200">
                                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                </svg>
                                <span>{{ __('frontend.domain_transfer') }}</span>
                            </a>
                            <a href="{{ route('domains.new-tlds') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-200">
                                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                <span>{{ __('frontend.new_tlds') }}</span>
                            </a>
                            <a href="{{ route('domains.bulk-search') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-200">
                                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                <span>{{ __('frontend.bulk_domain_search') }}</span>
                            </a>
                            <a href="{{ route('domains.tld-list') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-200">
                                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                </svg>
                                <span>{{ __('frontend.tld_list') }}</span>
                            </a>
                            <a href="{{ route('domains.whois') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-200">
                                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ __('frontend.whois_lookup') }}</span>
                            </a>
                            <a href="{{ route('domains.freedns') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-200">
                                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ __('frontend.free_dns') }}</span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Hosting Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                @click.away="open = false"
                                class="nav-link flex items-center space-x-1 {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} text-base font-medium text-gray-700 hover:text-blue-600 px-4 py-2 {{ request()->routeIs('hosting.*') ? 'text-blue-600' : '' }}">
                            <span>{{ __('frontend.hosting') }}</span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-95"
                             class="absolute {{ app()->getLocale() == 'ar' ? 'right-0' : 'left-0' }} mt-2 w-64 nav-glass rounded-xl shadow-lg py-2 z-50"
                             style="display: none;">
                            <a href="{{ route('hosting.shared') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-200">
                                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                                </svg>
                                <span>{{ __('frontend.shared_hosting') }}</span>
                            </a>
                            <a href="{{ route('hosting.cloud') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-200">
                                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                                </svg>
                                <span>{{ __('frontend.cloud_hosting') }}</span>
                            </a>
                            <a href="#" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-200">
                                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                </svg>
                                <span>{{ __('frontend.wordpress_hosting') }}</span>
                                <span class="mr-2 ml-2 px-2 py-0.5 text-xs font-semibold text-blue-600 bg-blue-100 rounded-full">{{ __('frontend.coming_soon') }}</span>
                            </a>
                            <a href="{{ route('hosting.reseller') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-200">
                                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span>{{ __('frontend.reseller_hosting') }}</span>
                            </a>
                            <a href="{{ route('vps.hosting') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-200">
                                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                                </svg>
                                <span>{{ __('frontend.vps_hosting') }}</span>
                            </a>
                            <a href="{{ route('dedicated.servers') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-200">
                                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                                </svg>
                                <span>{{ __('frontend.dedicated_servers') }}</span>
                            </a>
                            <a href="#" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-200">
                                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                <span>{{ __('frontend.migrate_to_pro_gineous') }}</span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Email Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                @click.away="open = false"
                                class="nav-link flex items-center space-x-1 {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} text-base font-medium text-gray-700 hover:text-blue-600 px-4 py-2 {{ request()->routeIs('email.*') ? 'active text-blue-600' : '' }}">
                            <span>{{ __('frontend.email') }}</span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-95"
                             class="absolute {{ app()->getLocale() == 'ar' ? 'right-0' : 'left-0' }} top-full mt-2 w-64 rounded-2xl shadow-2xl nav-glass border border-white/20 overflow-hidden z-50"
                             style="display: none;">
                            <a href="{{ route('email.index') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-200">
                                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span>{{ __('frontend.business_email') }}</span>
                            </a>
                            <a href="#" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-200">
                                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                </svg>
                                <span>{{ __('frontend.migrate_email') }}</span>
                            </a>
                            <a href="#" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-200">
                                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                <span>{{ __('frontend.anti_spam_protection') }}</span>
                            </a>
                            <a href="#" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-200">
                                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                                <span>{{ __('frontend.login_to_webmail') }}</span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Transfer to Us Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                @click.away="open = false"
                                class="nav-link flex items-center space-x-1 {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} text-base font-medium text-gray-700 hover:text-blue-600 px-4 py-2">
                            <span>{{ __('frontend.transfer_to_us') }}</span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-95"
                             class="absolute {{ app()->getLocale() == 'ar' ? 'right-0' : 'left-0' }} top-full mt-2 w-64 rounded-2xl shadow-2xl nav-glass border border-white/20 overflow-hidden z-50"
                             style="display: none;">
                            <a href="{{ route('domains.transfer') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-200">
                                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                </svg>
                                <span>{{ __('frontend.transfer_domains') }}</span>
                            </a>
                            <a href="#" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-200">
                                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                <span>{{ __('frontend.migrate_hosting') }}</span>
                            </a>
                            <a href="#" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-200">
                                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                </svg>
                                <span>{{ __('frontend.migrate_wordpress') }}</span>
                                <span class="mr-2 ml-2 px-2 py-0.5 text-xs font-semibold text-blue-600 bg-blue-100 rounded-full">{{ __('frontend.coming_soon') }}</span>
                            </a>
                            <a href="#" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-200">
                                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span>{{ __('frontend.migrate_email') }}</span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- More Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                @click.away="open = false"
                                class="nav-link flex items-center space-x-1 {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} text-base font-medium text-gray-700 hover:text-blue-600 px-4 py-2">
                            <span>{{ __('frontend.more') }}</span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-95"
                             class="absolute {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} mt-2 w-56 nav-glass rounded-xl shadow-lg py-2 z-50"
                             style="display: none;">
                            <a href="#" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-200">
                                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                                </svg>
                                <span>{{ __('frontend.marketing_tools') }}</span>
                            </a>
                            <a href="#" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-200">
                                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                <span>{{ __('frontend.security') }}</span>
                            </a>
                            <a href="#" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-200">
                                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <span>{{ __('frontend.help_center') }}</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Side Navigation -->
                <div class="flex items-center space-x-3 {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} flex-shrink-0">
                    <!-- Shopping Cart -->
                    <a href="{{ route('cart.index') }}" class="relative p-2 rounded-lg text-gray-700 hover:bg-gray-100/50 transition-colors duration-200 group">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        @php
                            $cartCount = count(Session::get('cart', []));
                        @endphp
                        @if($cartCount > 0)
                        <span id="cart-count" class="absolute -top-1 {{ app()->getLocale() == 'ar' ? '-left-1' : '-right-1' }} bg-gradient-to-r from-blue-600 to-cyan-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                            {{ $cartCount }}
                        </span>
                        @else
                        <span id="cart-count" class="absolute -top-1 {{ app()->getLocale() == 'ar' ? '-left-1' : '-right-1' }} bg-gradient-to-r from-blue-600 to-cyan-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center hidden">
                            0
                        </span>
                        @endif
                    </a>
                    
                    <!-- Language Switcher -->
                    @if(setting('enable_language_menu', true))
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                @click.away="open = false"
                                class="flex items-center space-x-2 {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100/50 transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                            </svg>
                            <span class="hidden sm:inline">{{ strtoupper(app()->getLocale()) }}</span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-95"
                             class="absolute {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} mt-2 w-48 nav-glass rounded-xl shadow-lg py-2 z-50"
                             style="display: none;">
                            <a href="{{ route('language.switch', 'ar') }}" 
                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-200 {{ app()->getLocale() == 'ar' ? 'font-semibold' : '' }}">
                                <span class="ml-3">العربية</span>
                                @if(app()->getLocale() == 'ar')
                                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'mr-auto' : 'ml-auto' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                @endif
                            </a>
                            <a href="{{ route('language.switch', 'en') }}" 
                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-200 {{ app()->getLocale() == 'en' ? 'font-semibold' : '' }}">
                                <span class="ml-3">English</span>
                                @if(app()->getLocale() == 'en')
                                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'mr-auto' : 'ml-auto' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                @endif
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- Auth Buttons -->
                    <div class="hidden md:flex items-center space-x-3 {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }}">
                        @auth('client')
                            <a href="{{ route('client.dashboard') }}" 
                               class="px-5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 backdrop-blur-sm">
                                {{ __('frontend.dashboard') }}
                            </a>
                        @else
                            <a href="{{ route('login') }}" 
                               class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors duration-200">
                                {{ __('frontend.login') }}
                            </a>
                            <a href="{{ route('register') }}" 
                               class="px-5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 backdrop-blur-sm">
                                {{ __('frontend.register') }}
                            </a>
                        @endauth
                    </div>

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" 
                            type="button" 
                            class="lg:hidden inline-flex items-center justify-center p-2 rounded-lg text-gray-700 hover:bg-gray-100/50 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 transition-colors duration-200"
                            aria-controls="mobile-menu"
                            aria-expanded="false">
                        <span class="sr-only">فتح القائمة</span>
                        <svg x-show="!mobileMenuOpen" class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-show="mobileMenuOpen" class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform -translate-y-1"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-1"
             class="lg:hidden glass rounded-b-3xl"
             id="mobile-menu"
             x-data="{ 
                 activeDropdown: null,
                 toggleDropdown(name) {
                     this.activeDropdown = this.activeDropdown === name ? null : name;
                 }
             }"
             style="display: none;">
            <div class="px-4 pt-2 pb-3 space-y-1">
                <!-- Domains Dropdown in Mobile -->
                <div>
                    <button @click="toggleDropdown('domains')"
                            class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-colors duration-200 {{ request()->routeIs('domains.*') ? 'text-blue-600 bg-blue-50' : '' }}">
                        <span>{{ __('frontend.domains') }}</span>
                        <svg class="w-5 h-5 transition-transform duration-200" :class="{ 'rotate-180': activeDropdown === 'domains' }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div x-show="activeDropdown === 'domains'"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100 transform translate-y-0"
                         x-transition:leave-end="opacity-0 transform -translate-y-2"
                         class="mt-1 space-y-1 bg-blue-50/50 rounded-lg p-2"
                         style="display: none;">
                        <a href="{{ route('domains.search') }}" 
                           class="flex items-center px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-white/50 transition-colors duration-200">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            {{ __('frontend.domain_name_search') }}
                        </a>
                        <a href="{{ route('domains.transfer') }}" 
                           class="flex items-center px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-white/50 transition-colors duration-200">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                            {{ __('frontend.domain_transfer') }}
                        </a>
                        <a href="{{ route('domains.new-tlds') }}" 
                           class="flex items-center px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-white/50 transition-colors duration-200">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            {{ __('frontend.new_tlds') }}
                        </a>
                        <a href="{{ route('domains.bulk-search') }}" 
                           class="flex items-center px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-white/50 transition-colors duration-200">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            {{ __('frontend.bulk_domain_search') }}
                        </a>
                        <a href="{{ route('domains.tld-list') }}" 
                           class="flex items-center px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-white/50 transition-colors duration-200">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                            </svg>
                            {{ __('frontend.tld_list') }}
                        </a>
                        <a href="{{ route('domains.whois') }}" 
                           class="flex items-center px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-white/50 transition-colors duration-200">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ __('frontend.whois_lookup') }}
                        </a>
                        <a href="{{ route('domains.freedns') }}" 
                           class="flex items-center px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-white/50 transition-colors duration-200">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ __('frontend.free_dns') }}
                        </a>
                    </div>
                </div>
                
                <!-- Hosting Dropdown in Mobile -->
                <div>
                    <button @click="toggleDropdown('hosting')"
                            class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-colors duration-200 {{ request()->routeIs('hosting.*') ? 'text-blue-600 bg-blue-50' : '' }}">
                        <span>{{ __('frontend.hosting') }}</span>
                        <svg class="w-5 h-5 transition-transform duration-200" :class="{ 'rotate-180': activeDropdown === 'hosting' }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div x-show="activeDropdown === 'hosting'"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100 transform translate-y-0"
                         x-transition:leave-end="opacity-0 transform -translate-y-2"
                         class="mt-1 space-y-1 bg-blue-50/50 rounded-lg p-2"
                         style="display: none;">
                        <a href="{{ route('hosting.shared') }}" 
                           class="flex items-center px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-white/50 transition-colors duration-200">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                            </svg>
                            {{ __('frontend.shared_hosting') }}
                        </a>
                        <a href="{{ route('hosting.cloud') }}" 
                           class="flex items-center px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-white/50 transition-colors duration-200">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                            </svg>
                            {{ __('frontend.cloud_hosting') }}
                        </a>
                        <a href="#" 
                           class="flex items-center px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-white/50 transition-colors duration-200">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                            </svg>
                            {{ __('frontend.wordpress_hosting') }}
                            <span class="mr-2 ml-2 px-2 py-0.5 text-xs font-semibold text-blue-600 bg-blue-100 rounded-full">{{ __('frontend.coming_soon') }}</span>
                        </a>
                        <a href="{{ route('hosting.reseller') }}" 
                           class="flex items-center px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-white/50 transition-colors duration-200">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            {{ __('frontend.reseller_hosting') }}
                        </a>
                        <a href="{{ route('vps.hosting') }}" 
                           class="flex items-center px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-white/50 transition-colors duration-200">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                            </svg>
                            {{ __('frontend.vps_hosting') }}
                        </a>
                        <a href="{{ route('dedicated.servers') }}" 
                           class="flex items-center px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-white/50 transition-colors duration-200">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                            </svg>
                            {{ __('frontend.dedicated_servers') }}
                        </a>
                        <a href="#" 
                           class="flex items-center px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-white/50 transition-colors duration-200">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            {{ __('frontend.migrate_to_pro_gineous') }}
                        </a>
                    </div>
                </div>
                
                <!-- Email Dropdown in Mobile -->
                <div>
                    <button @click="toggleDropdown('email')"
                            class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-colors duration-200 {{ request()->routeIs('email.*') ? 'text-blue-600 bg-blue-50' : '' }}">
                        <span>{{ __('frontend.email') }}</span>
                        <svg class="w-5 h-5 transition-transform duration-200" :class="{ 'rotate-180': activeDropdown === 'email' }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div x-show="activeDropdown === 'email'"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100 transform translate-y-0"
                         x-transition:leave-end="opacity-0 transform -translate-y-2"
                         class="mt-1 space-y-1 bg-blue-50/50 rounded-lg p-2"
                         style="display: none;">
                        <a href="{{ route('email.index') }}" 
                           class="flex items-center px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-white/50 transition-colors duration-200">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            {{ __('frontend.business_email') }}
                        </a>
                        <a href="#" 
                           class="flex items-center px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-white/50 transition-colors duration-200">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                            {{ __('frontend.migrate_email') }}
                        </a>
                        <a href="#" 
                           class="flex items-center px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-white/50 transition-colors duration-200">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            {{ __('frontend.anti_spam_protection') }}
                        </a>
                        <a href="#" 
                           class="flex items-center px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-white/50 transition-colors duration-200">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            {{ __('frontend.login_to_webmail') }}
                        </a>
                    </div>
                </div>
                
                <!-- Transfer to Us Dropdown in Mobile -->
                <div>
                    <button @click="toggleDropdown('transfer')"
                            class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-colors duration-200">
                        <span>{{ __('frontend.transfer_to_us') }}</span>
                        <svg class="w-5 h-5 transition-transform duration-200" :class="{ 'rotate-180': activeDropdown === 'transfer' }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div x-show="activeDropdown === 'transfer'"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100 transform translate-y-0"
                         x-transition:leave-end="opacity-0 transform -translate-y-2"
                         class="mt-1 space-y-1 bg-blue-50/50 rounded-lg p-2"
                         style="display: none;">
                        <a href="{{ route('domains.transfer') }}" 
                           class="flex items-center px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-white/50 transition-colors duration-200">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                            {{ __('frontend.transfer_domains') }}
                        </a>
                        <a href="#" 
                           class="flex items-center px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-white/50 transition-colors duration-200">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            {{ __('frontend.migrate_hosting') }}
                        </a>
                        <a href="#" 
                           class="flex items-center px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-white/50 transition-colors duration-200">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                            </svg>
                            {{ __('frontend.migrate_wordpress') }}
                            <span class="mr-2 ml-2 px-2 py-0.5 text-xs font-semibold text-blue-600 bg-blue-100 rounded-full">{{ __('frontend.coming_soon') }}</span>
                        </a>
                        <a href="#" 
                           class="flex items-center px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-white/50 transition-colors duration-200">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            {{ __('frontend.migrate_email') }}
                        </a>
                    </div>
                </div>
                
                <!-- More Dropdown in Mobile -->
                <div class="pt-2">
                    <button @click="toggleDropdown('more')"
                            class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-colors duration-200">
                        <span>{{ __('frontend.more') }}</span>
                        <svg class="w-5 h-5 transition-transform duration-200" :class="{ 'rotate-180': activeDropdown === 'more' }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div x-show="activeDropdown === 'more'"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100 transform translate-y-0"
                         x-transition:leave-end="opacity-0 transform -translate-y-2"
                         class="mt-1 space-y-1 bg-blue-50/50 rounded-lg p-2"
                         style="display: none;">
                        <a href="#" 
                           class="flex items-center px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-white/50 transition-colors duration-200">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                            </svg>
                            {{ __('frontend.marketing_tools') }}
                        </a>
                        <a href="#" 
                           class="flex items-center px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-white/50 transition-colors duration-200">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            {{ __('frontend.security') }}
                        </a>
                        <a href="#" 
                           class="flex items-center px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-white/50 transition-colors duration-200">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            {{ __('frontend.help_center') }}
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Mobile Auth Buttons -->
            <div class="pt-4 pb-3 border-t border-gray-200/50">
                <div class="px-4 space-y-2">
                    @auth('client')
                        <a href="{{ route('client.dashboard') }}" 
                           class="block w-full px-4 py-2.5 text-center text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-lg backdrop-blur-sm">
                            {{ __('frontend.dashboard') }}
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="block w-full px-4 py-2.5 text-center text-sm font-medium text-gray-700 bg-gray-100/50 rounded-lg hover:bg-gray-200/50 transition-colors duration-200">
                            {{ __('frontend.login') }}
                        </a>
                        <a href="{{ route('register') }}" 
                           class="block w-full px-4 py-2.5 text-center text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-lg backdrop-blur-sm">
                            {{ __('frontend.register') }}
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main style="min-height: calc(100vh - var(--nav-height));">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('frontend.partials.footer')

    <!-- Alpine.js for interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('navigation', () => ({
                mobileMenuOpen: false,
                scrolled: false,
                
                init() {
                    window.addEventListener('scroll', () => {
                        this.scrolled = window.pageYOffset > 100;
                    });
                }
            }));
        });
    </script>

    @stack('scripts')
</body>
</html>

