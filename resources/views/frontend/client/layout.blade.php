@php
    // Set default language if not already set in session
    if (!session()->has('locale')) {
        $defaultLanguage = setting('default_language', 'en');
        app()->setLocale($defaultLanguage);
        session()->put('locale', $defaultLanguage);
    }
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', app()->getLocale() == 'ar' ? 'لوحة التحكم - Pro Gineous' : 'Dashboard - Pro Gineous')</title>
    <meta name="description" content="@yield('description', app()->getLocale() == 'ar' ? 'لوحة تحكم العميل - Pro Gineous' : 'Client Dashboard - Pro Gineous')">
    
    <!-- Favicon -->
    @if(setting('favicon'))
        <link rel="icon" type="image/png" href="{{ asset('storage/' . setting('favicon')) }}">
        <link rel="shortcut icon" type="image/png" href="{{ asset('storage/' . setting('favicon')) }}">
        <link rel="apple-touch-icon" href="{{ asset('storage/' . setting('favicon')) }}">
    @else
        <link rel="icon" type="image/png" href="{{ asset('logo/pro Gineous Blue_defult icon.png') }}">
        <link rel="shortcut icon" type="image/png" href="{{ asset('logo/pro Gineous Blue_defult icon.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('logo/pro Gineous Blue_defult icon.png') }}">
    @endif
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Flag Icons CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.2.3/css/flag-icons.min.css">
    
    <!-- Cairo Font for Both Arabic and English -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 50%, #e2e8f0 100%);
            min-height: 100vh;
            position: relative;
        }
        
        /* Subtle background pattern */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 25px 25px, rgba(37, 99, 235, 0.03) 2%, transparent 0%),
                radial-gradient(circle at 75px 75px, rgba(37, 99, 235, 0.03) 2%, transparent 0%);
            background-size: 100px 100px;
            z-index: 0;
            pointer-events: none;
        }
        
        /* Glass Morphism Effects with Blue Theme */
        .glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(37, 99, 235, 0.1);
            box-shadow: 0 8px 32px 0 rgba(37, 99, 235, 0.1);
        }
        
        .glass-dark {
            background: linear-gradient(135deg, 
                rgba(147, 197, 253, 0.15) 0%,
                rgba(191, 219, 254, 0.12) 25%,
                rgba(219, 234, 254, 0.1) 50%,
                rgba(191, 219, 254, 0.12) 75%,
                rgba(147, 197, 253, 0.15) 100%),
                rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(37, 99, 235, 0.15);
            box-shadow: 0 8px 32px 0 rgba(37, 99, 235, 0.15),
                        0 0 60px -15px rgba(37, 99, 235, 0.2);
        }
        
        .glass-header {
            background: linear-gradient(135deg, 
                rgba(147, 197, 253, 0.12) 0%,
                rgba(191, 219, 254, 0.1) 25%,
                rgba(219, 234, 254, 0.08) 50%,
                rgba(191, 219, 254, 0.1) 75%,
                rgba(147, 197, 253, 0.12) 100%),
                rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border-bottom: 1px solid rgba(37, 99, 235, 0.1);
            box-shadow: 0 4px 30px rgba(37, 99, 235, 0.08);
        }
        
        /* Animated gradient borders */
        @keyframes border-flow {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        .gradient-border {
            background: linear-gradient(90deg, #2563eb, #3b82f6, #60a5fa, #3b82f6, #2563eb);
            background-size: 200% auto;
            animation: border-flow 3s linear infinite;
        }
        
        /* Flag Icons - Rounded Corners */
        .fi {
            border-radius: 0.375rem;
            overflow: hidden;
            display: inline-block;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }
        
        /* Custom scrollbar for sidebar */
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }
        
        .sidebar-scroll::-webkit-scrollbar-track {
            background: rgba(37, 99, 235, 0.05);
        }
        
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #2563eb, #3b82f6);
            border-radius: 2px;
        }
        
        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #1d4ed8, #2563eb);
        }

        /* Sidebar transition with bounce */
        .sidebar-collapsed {
            width: 4rem !important;
        }
        
        .sidebar-item-icon {
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }
        
        /* Menu item hover effect */
        .menu-item {
            position: relative;
            overflow: hidden;
        }
        
        .menu-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(37, 99, 235, 0.1), transparent);
            transition: left 0.5s ease;
        }
        
        .menu-item:hover::before {
            left: 100%;
        }
        
        /* Header height adjustments */
        .header-height {
            height: 60px;
        }
        
        @media (min-width: 640px) {
            .header-height {
                height: 68px;
            }
        }
        
        /* Smooth animations */
        .smooth-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Custom backdrop blur */
        .backdrop-blur-custom {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        
        /* Enhanced shadows with depth */
        .shadow-custom {
            box-shadow: 0 10px 25px -3px rgba(37, 99, 235, 0.1), 
                        0 4px 6px -2px rgba(37, 99, 235, 0.05);
        }
        
        .shadow-depth {
            box-shadow: 0 1px 3px 0 rgba(37, 99, 235, 0.1), 
                        0 1px 2px 0 rgba(37, 99, 235, 0.06);
        }
        
        .shadow-depth:hover {
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.15), 
                        0 4px 6px -2px rgba(37, 99, 235, 0.1);
            transform: translateY(-2px);
        }
        
        /* Improved focus states */
        .focus-ring:focus {
            outline: 2px solid rgb(37 99 235);
            outline-offset: 2px;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }
        
        /* تحسين التدرجات اللونية */
        .avatar-gradient-smooth {
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 50%, #60a5fa 100%);
            background-size: 200% 200%;
            animation: gradient-shift 3s ease infinite;
        }
        
        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        /* تأثير النعومة والإضاءة */
        .avatar-glow {
            box-shadow: 0 4px 20px rgba(37, 99, 235, 0.3), 
                        0 1px 4px rgba(0, 0, 0, 0.1),
                        inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }
        
        .avatar-glow:hover {
            box-shadow: 0 8px 30px rgba(37, 99, 235, 0.4), 
                        0 2px 8px rgba(0, 0, 0, 0.15),
                        inset 0 1px 0 rgba(255, 255, 255, 0.3);
            transform: scale(1.05);
        }
        
        /* Glowing effects */
        .glow-blue {
            box-shadow: 0 0 20px rgba(37, 99, 235, 0.2),
                        0 0 40px rgba(37, 99, 235, 0.1),
                        0 0 60px rgba(37, 99, 235, 0.05);
        }
        
        /* Pulse animation for notifications */
        @keyframes pulse-blue {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.6;
            }
        }
        
        .pulse-animation {
            animation: pulse-blue 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        /* Ripple effect */
        .ripple {
            position: relative;
            overflow: hidden;
        }
        
        .ripple::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(37, 99, 235, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .ripple:active::after {
            width: 200px;
            height: 200px;
        }
        
        /* Floating animation */
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }
        
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
        
        /* Preloader Styles */
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 50%, #e2e8f0 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.5s ease-out, visibility 0.5s ease-out;
        }
        
        #preloader.hidden {
            opacity: 0;
            visibility: hidden;
        }
        
        .preloader-logo {
            width: 180px;
            height: 180px;
            margin-bottom: 40px;
            animation: float 2s ease-in-out infinite;
        }
        
        .preloader-spinner {
            width: 60px;
            height: 60px;
            position: relative;
            margin-bottom: 20px;
        }
        
        .preloader-spinner::before,
        .preloader-spinner::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 4px solid transparent;
            border-top-color: #2563eb;
            animation: spin 1.5s linear infinite;
        }
        
        .preloader-spinner::after {
            border-top-color: #60a5fa;
            animation-duration: 1s;
            animation-direction: reverse;
        }
        
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
        
        .preloader-text {
            font-size: 16px;
            font-weight: 600;
            color: #2563eb;
            margin-top: 10px;
            animation: pulse-blue 2s ease-in-out infinite;
        }
        
        .preloader-dots::after {
            content: '';
            animation: dots 1.5s steps(4, end) infinite;
        }
        
        @keyframes dots {
            0%, 20% {
                content: '';
            }
            40% {
                content: '.';
            }
            60% {
                content: '..';
            }
            80%, 100% {
                content: '...';
            }
        }
        
        /* Footer Glass Morphism */
        .glass-footer {
            background: rgba(255, 255, 255, 0.6) !important;
            backdrop-filter: blur(60px) saturate(180%) brightness(1.05) !important;
            -webkit-backdrop-filter: blur(60px) saturate(180%) brightness(1.05) !important;
            box-shadow: 0 -10px 40px rgba(59, 130, 246, 0.1);
        }

        /* Animated Blobs for Footer */
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

        /* Alpine.js Cloak - Hide elements until Alpine is ready */
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>
<body class="overflow-x-hidden">
    <!-- Preloader -->
    <div id="preloader">
        <div class="preloader-logo">
            @if(setting('customer_panel_logo'))
                <img src="{{ asset('storage/' . setting('customer_panel_logo')) }}" 
                     alt="{{ setting('company_name', 'Pro Gineous') }}" 
                     class="w-full h-full object-contain">
            @else
                <img src="{{ asset('logo/pro Gineous Blue_defult icon.png') }}" 
                     alt="Pro Gineous" 
                     class="w-full h-full object-contain">
            @endif
        </div>
        <div class="preloader-spinner"></div>
        <p class="preloader-text">
            <span class="preloader-dots">{{ app()->getLocale() == 'ar' ? 'جاري التحميل' : 'Loading' }}</span>
        </p>
    </div>
    
    <div class="min-h-screen flex client-layout-container" x-data="sidebarController()" x-init="init()">
        <!-- Mobile Menu Overlay -->
        <div x-show="mobileMenuOpen" x-cloak 
             x-transition:enter="transition-all ease-out duration-400"
             x-transition:enter-start="opacity-0 scale-105"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition-all ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-105"
             @click="closeMobileMenu()"
             class="fixed inset-0 glass-overlay backdrop-blur-enhanced z-40 lg:hidden client-sidebar-overlay"
             style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(147, 51, 234, 0.1));">
        </div>
        
        <!-- Sidebar -->
        <div class="fixed inset-y-0 {{ app()->getLocale() == 'ar' ? 'right-0 border-l' : 'left-0 border-r' }} glass-dark shadow-2xl border-white/10 transition-all duration-300 ease-in-out z-50 lg:z-30 transform lg:translate-x-0 glow-blue client-sidebar"
             :class="{
                'w-64': !sidebarCollapsed || window.innerWidth < 1024,
                'w-16': sidebarCollapsed && window.innerWidth >= 1024,
                'translate-x-0': mobileMenuOpen,
                '{{ app()->getLocale() == 'ar' ? 'translate-x-full' : '-translate-x-full' }}': !mobileMenuOpen && window.innerWidth < 1024
             }"
             x-cloak>
            <div class="flex flex-col h-full relative">
                <!-- Logo & Toggle -->
                <div class="flex items-center justify-between h-16 px-4 pt-8 border-b border-white/10">
                    <div class="flex items-center space-x-3 {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} overflow-hidden">
                        <!-- Logo when expanded -->
                        <div x-show="!sidebarCollapsed" x-cloak
                             x-transition:enter="transition ease-in-out duration-300"
                             x-transition:enter-start="opacity-0 transform scale-90"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in-out duration-200"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-90"
                             class="flex items-center space-x-3 {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }}">
                            @if(setting('customer_panel_logo'))
                                <img src="{{ asset('storage/' . setting('customer_panel_logo')) }}" 
                                     alt="{{ setting('company_name', 'Client Panel') }}" 
                                     class="h-8 lg:h-10 w-auto object-contain max-w-[160px] lg:max-w-[200px]">
                            @else
                                <img src="{{ asset('logo/pro Gineous_blue logo.svg') }}" 
                                     alt="Pro Gineous" 
                                     class="h-8 lg:h-10 w-auto object-contain">
                            @endif
                        </div>
                        
                        <!-- Icon when collapsed -->
                        <div x-show="sidebarCollapsed" x-cloak
                             x-transition:enter="transition ease-in-out duration-300"
                             x-transition:enter-start="opacity-0 transform scale-90"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in-out duration-200"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-90"
                             class="flex items-center justify-center">
                            @if(setting('customer_panel_logo_collapsed'))
                                <img src="{{ asset('storage/' . setting('customer_panel_logo_collapsed')) }}" 
                                     alt="{{ setting('company_name', 'Client') }}" 
                                     class="h-8 lg:h-10 w-8 lg:w-10 object-contain">
                            @elseif(setting('customer_panel_logo'))
                                <img src="{{ asset('storage/' . setting('customer_panel_logo')) }}" 
                                     alt="{{ setting('company_name', 'Client') }}" 
                                     class="h-8 lg:h-10 w-8 lg:w-10 object-contain">
                            @else
                                <img src="{{ asset('logo/pro Gineous Blue_defult icon.png') }}" 
                                     alt="PG" 
                                     class="h-8 lg:h-10 w-8 lg:w-10 object-contain">
                            @endif
                        </div>
                    </div>
                    
                    <!-- Close button for mobile -->
                    <button @click="closeMobileMenu()" class="lg:hidden p-2 rounded-md hover:bg-blue-50 transition-colors text-blue-600 hover:text-blue-700">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
                
                <!-- Toggle Button (Desktop only) -->
                <div class="hidden lg:block absolute {{ app()->getLocale() == 'ar' ? '-left-3' : '-right-3' }} top-20 z-10">
                    <button @click="sidebarCollapsed = !sidebarCollapsed" 
                            class="w-6 h-6 bg-white border border-blue-200 rounded-full flex items-center justify-center text-blue-600 hover:text-blue-700 hover:bg-blue-50 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <svg class="w-3 h-3 transition-transform duration-200" 
                             fill="currentColor" viewBox="0 0 20 20">
                            @if(app()->getLocale() == 'ar')
                            {{-- Arabic: When open show arrow pointing left (collapse), when collapsed show arrow pointing right (expand) --}}
                            <path x-show="!sidebarCollapsed" x-cloak fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            <path x-show="sidebarCollapsed" x-cloak fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            @else
                            {{-- English: When open show arrow pointing right (collapse), when collapsed show arrow pointing left (expand) --}}
                            <path x-show="!sidebarCollapsed" x-cloak fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            <path x-show="sidebarCollapsed" x-cloak fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            @endif
                        </svg>
                    </button>
                </div>
                
                <!-- Navigation -->
                <nav class="flex-1 px-3 py-6 space-y-2 overflow-y-auto sidebar-scroll">
                    <!-- Dashboard -->
                    <a href="{{ route('client.dashboard') }}" 
                       class="menu-item group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 relative overflow-hidden shadow-depth {{ request()->routeIs('client.dashboard') ? 'bg-blue-100 text-blue-700 border-l-2 border-blue-600' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}"
                       :class="sidebarCollapsed ? 'justify-center px-0' : ''"
                       x-tooltip="sidebarCollapsed ? '{{ __('frontend.dashboard') }}' : ''">
                        <div class="flex items-center justify-center w-6 h-6 flex-shrink-0" 
                             :class="sidebarCollapsed ? 'mx-auto' : '{{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}'">
                            <svg class="w-5 h-5 {{ request()->routeIs('client.dashboard') ? 'text-blue-600' : 'group-hover:text-blue-600' }} transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-3zM14 13a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1v-7z"/>
                            </svg>
                        </div>
                        <span x-show="!sidebarCollapsed" x-cloak 
                              x-transition:enter="transition ease-in-out duration-300 delay-100"
                              x-transition:enter-start="opacity-0 transform translate-x-4"
                              x-transition:enter-end="opacity-100 transform translate-x-0"
                              x-transition:leave="transition ease-in-out duration-150"
                              x-transition:leave-start="opacity-100 transform translate-x-0"
                              x-transition:leave-end="opacity-0 transform translate-x-4"
                              class="flex-1 whitespace-nowrap {{ app()->getLocale() == 'ar' ? 'mr-3 text-right' : 'ml-3 text-left' }}">
                            {{ __('frontend.dashboard') }}
                        </span>
                    </a>

                    <!-- Divider -->
                    <div class="border-t border-gray-200 my-4" 
                         :class="sidebarCollapsed ? 'mx-2' : 'mx-0'"></div>

                    <!-- AI Assistant -->
                    <a href="{{ route('ai.assistant') }}" 
                       class="menu-item group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 relative overflow-hidden shadow-depth {{ request()->routeIs('ai.*') ? 'bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-700 border-l-2 border-blue-600' : 'text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-cyan-50 hover:text-blue-600' }}"
                       :class="sidebarCollapsed ? 'justify-center px-0' : ''"
                       x-tooltip="sidebarCollapsed ? 'ProGineous AI' : ''">
                        <div class="flex items-center justify-center w-6 h-6 flex-shrink-0" 
                             :class="sidebarCollapsed ? 'mx-auto' : '{{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}'">
                            <svg class="w-5 h-5 {{ request()->routeIs('ai.*') ? 'text-blue-600' : 'group-hover:text-blue-600' }} transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                        <span x-show="!sidebarCollapsed" x-cloak 
                              x-transition:enter="transition ease-in-out duration-300 delay-100"
                              x-transition:enter-start="opacity-0 transform translate-x-4"
                              x-transition:enter-end="opacity-100 transform translate-x-0"
                              x-transition:leave="transition ease-in-out duration-150"
                              x-transition:leave-start="opacity-100 transform translate-x-0"
                              x-transition:leave-end="opacity-0 transform translate-x-4"
                              class="flex-1 whitespace-nowrap {{ app()->getLocale() == 'ar' ? 'mr-3 text-right' : 'ml-3 text-left' }}">
                            ProGineous AI
                        </span>
                        <span x-show="!sidebarCollapsed" x-cloak
                              class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gradient-to-r from-blue-500 to-cyan-500 text-white">
                            {{ app()->getLocale() == 'ar' ? 'جديد' : 'NEW' }}
                        </span>
                    </a>

                    <!-- Divider -->
                    <div class="border-t border-gray-200 my-4" 
                         :class="sidebarCollapsed ? 'mx-2' : 'mx-0'"></div>



                    <!-- Hosting Services -->
                    <div x-data="{ hostingOpen: false }">
                        <button @click="hostingOpen = !hostingOpen" 
                                class="menu-item group w-full flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 shadow-depth text-gray-700 hover:bg-blue-50 hover:text-blue-600"
                                :class="sidebarCollapsed ? 'justify-center px-0' : ''"
                                x-tooltip="sidebarCollapsed ? '{{ __('frontend.hosting') }}' : ''">
                            <div class="flex items-center justify-center w-6 h-6 flex-shrink-0" 
                                 :class="sidebarCollapsed ? 'mx-auto' : '{{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}'">
                                <svg class="w-5 h-5 transition-colors duration-200" :class="hostingOpen ? 'text-blue-600' : 'group-hover:text-blue-600'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                                </svg>
                            </div>
                            <span x-show="!sidebarCollapsed" x-cloak 
                                  x-transition:enter="transition ease-in-out duration-300 delay-100"
                                  x-transition:enter-start="opacity-0 transform translate-x-4"
                                  x-transition:enter-end="opacity-100 transform translate-x-0"
                                  x-transition:leave="transition ease-in-out duration-150"
                                  x-transition:leave-start="opacity-100 transform translate-x-0"
                                  x-transition:leave-end="opacity-0 transform translate-x-4"
                                  class="flex-1 whitespace-nowrap {{ app()->getLocale() == 'ar' ? 'mr-3 text-right' : 'ml-3 text-left' }}">
                                {{ __('frontend.hosting') }}
                            </span>
                            <svg x-show="!sidebarCollapsed" x-cloak
                                 class="w-4 h-4 transition-transform duration-200"
                                 :class="hostingOpen ? 'rotate-180' : ''"
                                 fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                        
                        <!-- Hosting Submenu -->
                        <div x-show="hostingOpen && !sidebarCollapsed" x-cloak
                             x-collapse
                             class="mt-2 space-y-1 {{ app()->getLocale() == 'ar' ? 'pr-6' : 'pl-6' }}">
                            
                            <!-- Shared Hosting -->
                            <a href="{{ route('client.hosting.index') }}" class="group flex items-center px-3 py-2 text-sm text-gray-600 hover:text-blue-600 hover:bg-blue-50 dark:text-gray-400 dark:hover:text-blue-400 dark:hover:bg-blue-900/20 rounded-lg transition-colors {{ request()->routeIs('client.hosting.index') || request()->routeIs('client.hosting.show') ? 'text-blue-600 bg-blue-50 dark:text-blue-400 dark:bg-blue-900/20' : '' }}">
                                <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                </svg>
                                {{ __('frontend.shared_hosting') }}
                            </a>
                            
                            <!-- Cloud Hosting -->
                            <a href="{{ route('client.hosting.cloud') }}" class="group flex items-center px-3 py-2 text-sm text-gray-600 hover:text-blue-600 hover:bg-blue-50 dark:text-gray-400 dark:hover:text-blue-400 dark:hover:bg-blue-900/20 rounded-lg transition-colors {{ request()->routeIs('client.hosting.cloud') ? 'text-blue-600 bg-blue-50 dark:text-blue-400 dark:bg-blue-900/20' : '' }}">
                                <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                                </svg>
                                {{ __('frontend.cloud_hosting') }}
                            </a>
                            
                            <!-- Reseller Hosting -->
                            <a href="{{ route('client.hosting.reseller') }}" class="group flex items-center px-3 py-2 text-sm text-gray-600 hover:text-blue-600 hover:bg-blue-50 dark:text-gray-400 dark:hover:text-blue-400 dark:hover:bg-blue-900/20 rounded-lg transition-colors {{ request()->routeIs('client.hosting.reseller*') ? 'text-blue-600 bg-blue-50 dark:text-blue-400 dark:bg-blue-900/20' : '' }}">
                                <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                {{ __('frontend.reseller_hosting') }}
                            </a>
                            
                            <!-- WordPress Hosting -->
                            <a href="{{ route('client.hosting.index') }}" class="group flex items-center px-3 py-2 text-sm text-gray-600 hover:text-blue-600 hover:bg-blue-50 dark:text-gray-400 dark:hover:text-blue-400 dark:hover:bg-blue-900/20 rounded-lg transition-colors">
                                <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} transition-colors" fill="currentColor" viewBox="0 0 97.75 97.75">
                                    <path d="M69.682,47.319c0-3.81-1.367-6.447-2.539-8.501c-1.563-2.539-3.029-4.688-3.029-7.228c0-2.834,2.15-5.471,5.178-5.471 c0.136,0,0.268,0.017,0.398,0.024c-5.483-5.023-12.789-8.091-20.812-8.091c-10.769,0-20.241,5.524-25.753,13.893 c0.723,0.021,1.405,0.037,1.984,0.037c3.224,0,8.214-0.392,8.214-0.392c1.661-0.099,1.857,2.343,0.198,2.539 c0,0-1.67,0.196-3.527,0.293l11.222,33.389l6.746-20.229l-4.803-13.157c-1.659-0.097-3.232-0.293-3.232-0.293 c-1.66-0.098-1.466-2.637,0.195-2.539c0,0,5.09,0.391,8.117,0.391c3.224,0,8.216-0.391,8.216-0.391 c1.663-0.098,1.856,2.342,0.196,2.539c0,0-1.674,0.196-3.527,0.293l11.139,33.133l3.074-10.272 C68.669,53.02,69.682,49.957,69.682,47.319z"/>
                                    <path d="M18.054,48.874c0,12.2,7.091,22.743,17.372,27.739L20.722,36.331C19.012,40.163,18.054,44.406,18.054,48.874z"/>
                                    <path d="M49.417,51.57l-9.249,26.871c2.762,0.812,5.682,1.257,8.708,1.257c3.589,0,7.031-0.621,10.235-1.748 c-0.084-0.132-0.158-0.271-0.221-0.425L49.417,51.57z"/>
                                    <path d="M64.37,75.516c9.164-5.343,15.327-15.271,15.327-26.641c0.001-5.359-1.368-10.397-3.776-14.788 c0.134,0.981,0.208,2.036,0.208,3.169c0,3.128-0.583,6.644-2.344,11.04L64.37,75.516z"/>
                                    <path d="M48.875,0C21.882,0,0,21.882,0,48.875S21.882,97.75,48.875,97.75S97.75,75.868,97.75,48.875S75.868,0,48.875,0z M48.876,83.156c-18.902,0-34.281-15.379-34.281-34.282c0-18.902,15.378-34.28,34.281-34.28c18.901,0,34.278,15.378,34.278,34.28 C83.154,67.777,67.777,83.156,48.876,83.156z"/>
                                </svg>
                                {{ __('frontend.wordpress_hosting') }}
                            </a>
                            
                            <!-- VPS Hosting -->
                            <a href="{{ route('client.hosting.vps') }}" class="group flex items-center px-3 py-2 text-sm text-gray-600 hover:text-blue-600 hover:bg-blue-50 dark:text-gray-400 dark:hover:text-blue-400 dark:hover:bg-blue-900/20 rounded-lg transition-colors {{ request()->routeIs('client.hosting.vps') ? 'text-blue-600 bg-blue-50 dark:text-blue-400 dark:bg-blue-900/20' : '' }}">
                                <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                                </svg>
                                {{ __('frontend.vps_hosting') }}
                            </a>
                            
                            <!-- Dedicated Servers -->
                            <a href="{{ route('client.hosting.dedicated') }}" class="group flex items-center px-3 py-2 text-sm text-gray-600 hover:text-blue-600 hover:bg-blue-50 dark:text-gray-400 dark:hover:text-blue-400 dark:hover:bg-blue-900/20 rounded-lg transition-colors {{ request()->routeIs('client.hosting.dedicated*') ? 'text-blue-600 bg-blue-50 dark:text-blue-400 dark:bg-blue-900/20' : '' }}">
                                <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                </svg>
                                {{ __('frontend.dedicated_servers') }}
                            </a>
                        </div>
                    </div>

                    <!-- Professional Email -->
                    <a href="#" 
                       class="menu-item group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 shadow-depth text-gray-700 hover:bg-blue-50 hover:text-blue-600"
                       :class="sidebarCollapsed ? 'justify-center px-0' : ''"
                       x-tooltip="sidebarCollapsed ? '{{ __('frontend.business_email') }}' : ''">
                        <div class="flex items-center justify-center w-6 h-6 flex-shrink-0" 
                             :class="sidebarCollapsed ? 'mx-auto' : '{{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}'">
                            <svg class="w-5 h-5 group-hover:text-blue-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <span x-show="!sidebarCollapsed" x-cloak 
                              x-transition:enter="transition ease-in-out duration-300 delay-100"
                              x-transition:enter-start="opacity-0 transform translate-x-4"
                              x-transition:enter-end="opacity-100 transform translate-x-0"
                              x-transition:leave="transition ease-in-out duration-150"
                              x-transition:leave-start="opacity-100 transform translate-x-0"
                              x-transition:leave-end="opacity-0 transform translate-x-4"
                              class="flex-1 whitespace-nowrap {{ app()->getLocale() == 'ar' ? 'mr-3 text-right' : 'ml-3 text-left' }}">
                            {{ __('frontend.business_email') }}
                        </span>
                    </a>

                    <!-- Domains -->
                    <div x-data="{ domainsOpen: false }">
                        <button @click="domainsOpen = !domainsOpen" 
                                class="menu-item group w-full flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 shadow-depth text-gray-700 hover:bg-blue-50 hover:text-blue-600"
                                :class="sidebarCollapsed ? 'justify-center px-0' : ''"
                                x-tooltip="sidebarCollapsed ? '{{ __('frontend.domains') }}' : ''">
                            <div class="flex items-center justify-center w-6 h-6 flex-shrink-0" 
                                 :class="sidebarCollapsed ? 'mx-auto' : '{{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}'">
                                <svg class="w-5 h-5 transition-colors duration-200" :class="domainsOpen ? 'text-blue-600' : 'group-hover:text-blue-600'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                </svg>
                            </div>
                            <span x-show="!sidebarCollapsed" x-cloak 
                                  x-transition:enter="transition ease-in-out duration-300 delay-100"
                                  x-transition:enter-start="opacity-0 transform translate-x-4"
                                  x-transition:enter-end="opacity-100 transform translate-x-0"
                                  x-transition:leave="transition ease-in-out duration-150"
                                  x-transition:leave-start="opacity-100 transform translate-x-0"
                                  x-transition:leave-end="opacity-0 transform translate-x-4"
                                  class="flex-1 whitespace-nowrap {{ app()->getLocale() == 'ar' ? 'mr-3 text-right' : 'ml-3 text-left' }}">
                                {{ __('frontend.domains') }}
                            </span>
                            <svg x-show="!sidebarCollapsed" x-cloak
                                 class="w-4 h-4 transition-transform duration-200"
                                 :class="domainsOpen ? 'rotate-180' : ''"
                                 fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                        
                        <!-- Domains Submenu -->
                        <div x-show="domainsOpen && !sidebarCollapsed" x-cloak
                             x-collapse
                             class="mt-2 space-y-1 {{ app()->getLocale() == 'ar' ? 'pr-6' : 'pl-6' }}">
                            
                            <!-- My Domains -->
                            <a href="{{ route('client.domains.index') }}" class="group flex items-center px-3 py-2 text-sm text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors {{ request()->routeIs('client.domains.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                                <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} group-hover:text-blue-600 transition-colors {{ request()->routeIs('client.domains.*') ? 'text-blue-600' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                </svg>
                                {{ app()->getLocale() == 'ar' ? 'نطاقاتي' : 'My Domains' }}
                            </a>
                            
                            <!-- New Domain -->
                            <a href="{{ route('domains.search') }}" class="group flex items-center px-3 py-2 text-sm text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                {{ app()->getLocale() == 'ar' ? 'نطاق جديد' : 'New Domain' }}
                            </a>
                            
                            <!-- Transfer Domain -->
                            <a href="{{ route('domains.transfer') }}" class="group flex items-center px-3 py-2 text-sm text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                </svg>
                                {{ __('frontend.domain_transfer') }}
                            </a>
                        </div>
                    </div>

                    <!-- Billing -->
                    <div x-data="{ billingOpen: false }">
                        <button @click="billingOpen = !billingOpen" 
                                class="menu-item group w-full flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 shadow-depth text-gray-700 hover:bg-blue-50 hover:text-blue-600"
                                :class="sidebarCollapsed ? 'justify-center px-0' : ''"
                                x-tooltip="sidebarCollapsed ? '{{ app()->getLocale() == 'ar' ? 'الفواتير' : 'Billing' }}' : ''">
                            <div class="flex items-center justify-center w-6 h-6 flex-shrink-0" 
                                 :class="sidebarCollapsed ? 'mx-auto' : '{{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}'">
                                <svg class="w-5 h-5 transition-colors duration-200" :class="billingOpen ? 'text-blue-600' : 'group-hover:text-blue-600'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                            </div>
                            <span x-show="!sidebarCollapsed" x-cloak 
                                  x-transition:enter="transition ease-in-out duration-300 delay-100"
                                  x-transition:enter-start="opacity-0 transform translate-x-4"
                                  x-transition:enter-end="opacity-100 transform translate-x-0"
                                  x-transition:leave="transition ease-in-out duration-150"
                                  x-transition:leave-start="opacity-100 transform translate-x-0"
                                  x-transition:leave-end="opacity-0 transform translate-x-4"
                                  class="flex-1 whitespace-nowrap {{ app()->getLocale() == 'ar' ? 'mr-3 text-right' : 'ml-3 text-left' }}">
                                {{ app()->getLocale() == 'ar' ? 'الفواتير' : 'Billing' }}
                            </span>
                            <svg x-show="!sidebarCollapsed" x-cloak
                                 class="w-4 h-4 transition-transform duration-200"
                                 :class="billingOpen ? 'rotate-180' : ''"
                                 fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                        
                        <!-- Billing Submenu -->
                        <div x-show="billingOpen && !sidebarCollapsed" x-cloak
                             x-collapse
                             class="mt-2 space-y-1 {{ app()->getLocale() == 'ar' ? 'pr-6' : 'pl-6' }}">
                            
                            <!-- My Invoices -->
                            <a href="{{ route('client.invoices') }}" class="group flex items-center px-3 py-2 text-sm text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                </svg>
                                {{ app()->getLocale() == 'ar' ? 'فواتيري' : 'My Invoices' }}
                            </a>
                            
                            <!-- Wallet -->
                            <a href="{{ route('client.wallet') }}" class="group flex items-center px-3 py-2 text-sm text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                {{ app()->getLocale() == 'ar' ? 'المحفظة' : 'Wallet' }}
                            </a>
                            
                            <!-- Add Funds -->
                            <a href="{{ route('client.wallet.add-funds') }}" class="group flex items-center px-3 py-2 text-sm text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                {{ app()->getLocale() == 'ar' ? 'إضافة رصيد' : 'Add Funds' }}
                            </a>
                        </div>
                    </div>

                    <!-- Support -->
                    <div x-data="{ supportOpen: false }">
                        <button @click="supportOpen = !supportOpen" 
                                class="menu-item group w-full flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 shadow-depth text-gray-700 hover:bg-blue-50 hover:text-blue-600"
                                :class="sidebarCollapsed ? 'justify-center px-0' : ''"
                                x-tooltip="sidebarCollapsed ? '{{ __('frontend.support') }}' : ''">
                            <div class="flex items-center justify-center w-6 h-6 flex-shrink-0" 
                                 :class="sidebarCollapsed ? 'mx-auto' : '{{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}'">
                                <svg class="w-5 h-5 transition-colors duration-200" :class="supportOpen ? 'text-blue-600' : 'group-hover:text-blue-600'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <span x-show="!sidebarCollapsed" x-cloak 
                                  x-transition:enter="transition ease-in-out duration-300 delay-100"
                                  x-transition:enter-start="opacity-0 transform translate-x-4"
                                  x-transition:enter-end="opacity-100 transform translate-x-0"
                                  x-transition:leave="transition ease-in-out duration-150"
                                  x-transition:leave-start="opacity-100 transform translate-x-0"
                                  x-transition:leave-end="opacity-0 transform translate-x-4"
                                  class="flex-1 whitespace-nowrap {{ app()->getLocale() == 'ar' ? 'mr-3 text-right' : 'ml-3 text-left' }}">
                                {{ __('frontend.support') }}
                            </span>
                            <svg x-show="!sidebarCollapsed" x-cloak
                                 class="w-4 h-4 transition-transform duration-200"
                                 :class="supportOpen ? 'rotate-180' : ''"
                                 fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                        
                        <!-- Support Submenu -->
                        <div x-show="supportOpen && !sidebarCollapsed" x-cloak
                             x-collapse
                             class="mt-2 space-y-1 {{ app()->getLocale() == 'ar' ? 'pr-6' : 'pl-6' }}">
                            
                            <!-- Support PIN / Tickets -->
                            <button @click="$dispatch('open-support-pin-modal')" class="w-full group flex items-center px-3 py-2 text-sm text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                {{ app()->getLocale() == 'ar' ? 'رقم الدعم السري' : 'Support PIN' }}
                            </button>
                            
                            <!-- Tickets -->
                            <a href="{{ route('client.tickets.index') }}" class="group flex items-center px-3 py-2 text-sm text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors {{ request()->routeIs('client.tickets.*') ? 'text-blue-600 bg-blue-50' : '' }}">
                                <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                                </svg>
                                {{ app()->getLocale() == 'ar' ? 'التذاكر' : 'Tickets' }}
                            </a>
                            
                            <!-- Announcements -->
                            <a href="#" class="group flex items-center px-3 py-2 text-sm text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                                </svg>
                                {{ app()->getLocale() == 'ar' ? 'الإعلانات' : 'Announcements' }}
                            </a>
                            
                            <!-- Knowledgebase -->
                            <a href="#" class="group flex items-center px-3 py-2 text-sm text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                {{ app()->getLocale() == 'ar' ? 'قاعدة المعرفة' : 'Knowledgebase' }}
                            </a>
                            
                            <!-- Network Status -->
                            <a href="#" class="group flex items-center px-3 py-2 text-sm text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                {{ app()->getLocale() == 'ar' ? 'حالة الشبكة' : 'Network Status' }}
                            </a>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-slate-700/50 my-4" 
                         :class="sidebarCollapsed ? 'mx-2' : 'mx-0'"></div>

                    <!-- Account Settings -->
                    <a href="{{ route('settings.index') }}" 
                       class="menu-item group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 shadow-depth {{ request()->routeIs('settings.index') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}"
                       :class="sidebarCollapsed ? 'justify-center px-0' : ''"
                       x-tooltip="sidebarCollapsed ? '{{ __('frontend.account_settings') }}' : ''">
                        <div class="flex items-center justify-center w-6 h-6 flex-shrink-0" 
                             :class="sidebarCollapsed ? 'mx-auto' : '{{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}'">
                            <svg class="w-5 h-5 group-hover:text-blue-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <span x-show="!sidebarCollapsed" x-cloak 
                              x-transition:enter="transition ease-in-out duration-300 delay-100"
                              x-transition:enter-start="opacity-0 transform translate-x-4"
                              x-transition:enter-end="opacity-100 transform translate-x-0"
                              x-transition:leave="transition ease-in-out duration-150"
                              x-transition:leave-start="opacity-100 transform translate-x-0"
                              x-transition:leave-end="opacity-0 transform translate-x-4"
                              class="flex-1 whitespace-nowrap {{ app()->getLocale() == 'ar' ? 'mr-3 text-right' : 'ml-3 text-left' }}">
                            {{ __('frontend.account_settings') }}
                        </span>
                    </a>
                </nav>
                
                <!-- Bottom Section - Home Button -->
                <div class="px-3 py-4 border-t border-white/10">
                    <a href="{{ route('home') }}" 
                       class="menu-item group flex items-center px-3 py-3 text-sm font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white"
                       :class="sidebarCollapsed ? 'justify-center px-0' : ''"
                       x-tooltip="sidebarCollapsed ? '{{ app()->getLocale() == 'ar' ? 'الصفحة الرئيسية' : 'Home' }}' : ''">
                        <div class="flex items-center justify-center w-6 h-6 flex-shrink-0" 
                             :class="sidebarCollapsed ? 'mx-auto' : '{{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}'">
                            <svg class="w-5 h-5 text-white transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </div>
                        <span x-show="!sidebarCollapsed" x-cloak 
                              x-transition:enter="transition ease-in-out duration-300 delay-100"
                              x-transition:enter-start="opacity-0 transform translate-x-4"
                              x-transition:enter-end="opacity-100 transform translate-x-0"
                              x-transition:leave="transition ease-in-out duration-150"
                              x-transition:leave-start="opacity-100 transform translate-x-0"
                              x-transition:leave-end="opacity-0 transform translate-x-4"
                              class="flex-1 whitespace-nowrap {{ app()->getLocale() == 'ar' ? 'mr-3 text-right' : 'ml-3 text-left' }}">
                            {{ app()->getLocale() == 'ar' ? 'الصفحة الرئيسية' : 'Home' }}
                        </span>
                    </a>
                    
                    <!-- Invest Button -->
                    <a href="#" 
                       class="menu-item group relative flex items-center px-3 py-3 mt-3 text-sm font-semibold rounded-xl transition-all duration-300 bg-transparent hover:bg-gradient-to-r hover:from-purple-50/30 hover:via-pink-50/30 hover:to-red-50/30"
                       style="border: 2px solid transparent; background-image: linear-gradient(white, white), linear-gradient(135deg, rgb(147, 51, 234), rgb(236, 72, 153), rgb(239, 68, 68)); background-origin: border-box; background-clip: padding-box, border-box;"
                       :class="sidebarCollapsed ? 'justify-center px-0' : ''"
                       x-tooltip="sidebarCollapsed ? '{{ app()->getLocale() == 'ar' ? 'استثمر معنا' : 'Invest' }}' : ''">
                        <div class="flex items-center justify-center w-6 h-6 flex-shrink-0" 
                             :class="sidebarCollapsed ? 'mx-auto' : '{{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}'">
                            <img src="{{ asset('assets/images/1money-svgrepo-com.svg') }}" 
                                 alt="Invest" 
                                 class="w-6 h-6 transition-transform duration-300 group-hover:scale-110 group-hover:rotate-12"
                                 style="filter: brightness(0) saturate(100%) invert(60%) sepia(80%) saturate(500%) hue-rotate(359deg) brightness(105%) contrast(100%);">
                        </div>
                        <span x-show="!sidebarCollapsed" x-cloak 
                              x-transition:enter="transition ease-in-out duration-300 delay-100"
                              x-transition:enter-start="opacity-0 transform translate-x-4"
                              x-transition:enter-end="opacity-100 transform translate-x-0"
                              x-transition:leave="transition ease-in-out duration-150"
                              x-transition:leave-start="opacity-100 transform translate-x-0"
                              x-transition:leave-end="opacity-0 transform translate-x-4"
                              class="flex-1 whitespace-nowrap text-gray-900 font-bold {{ app()->getLocale() == 'ar' ? 'mr-3 text-right' : 'ml-3 text-left' }}">
                            {{ app()->getLocale() == 'ar' ? 'استثمر مع Pro Gineous' : 'Invest with Pro Gineous' }}
                        </span>
                    </a>
                    
                    <!-- Affiliates Button -->
                    <a href="{{ route('client.affiliate') }}" 
                       class="menu-item group relative flex items-center px-3 py-3 mt-3 text-sm font-semibold rounded-xl transition-all duration-300 bg-transparent hover:bg-gradient-to-r hover:from-orange-50/30 hover:via-amber-50/30 hover:to-yellow-50/30"
                       style="border: 2px solid transparent; background-image: linear-gradient(white, white), linear-gradient(135deg, rgb(249, 115, 22), rgb(245, 158, 11), rgb(234, 179, 8)); background-origin: border-box; background-clip: padding-box, border-box;"
                       :class="sidebarCollapsed ? 'justify-center px-0' : ''"
                       x-tooltip="sidebarCollapsed ? '{{ app()->getLocale() == 'ar' ? 'التسويق بالعمولة' : 'Affiliates' }}' : ''">
                        <div class="flex items-center justify-center w-6 h-6 flex-shrink-0" 
                             :class="sidebarCollapsed ? 'mx-auto' : '{{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}'">
                            <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110 group-hover:-rotate-12" fill="none" stroke="url(#orangeGradient)" viewBox="0 0 24 24">
                                <defs>
                                    <linearGradient id="orangeGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" style="stop-color:rgb(249, 115, 22);stop-opacity:1" />
                                        <stop offset="50%" style="stop-color:rgb(245, 158, 11);stop-opacity:1" />
                                        <stop offset="100%" style="stop-color:rgb(234, 179, 8);stop-opacity:1" />
                                    </linearGradient>
                                </defs>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                            </svg>
                        </div>
                        <span x-show="!sidebarCollapsed" x-cloak 
                              x-transition:enter="transition ease-in-out duration-300 delay-100"
                              x-transition:enter-start="opacity-0 transform translate-x-4"
                              x-transition:enter-end="opacity-100 transform translate-x-0"
                              x-transition:leave="transition ease-in-out duration-150"
                              x-transition:leave-start="opacity-100 transform translate-x-0"
                              x-transition:leave-end="opacity-0 transform translate-x-4"
                              class="flex-1 whitespace-nowrap text-gray-900 font-bold {{ app()->getLocale() == 'ar' ? 'mr-3 text-right' : 'ml-3 text-left' }}">
                            {{ app()->getLocale() == 'ar' ? 'التسويق بالعمولة' : 'Affiliates' }}
                        </span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-h-screen overflow-x-hidden"
             :class="sidebarCollapsed && window.innerWidth >= 1024 ? '{{ app()->getLocale() == 'ar' ? 'mr-16' : 'ml-16' }}' : '{{ app()->getLocale() == 'ar' ? 'mr-0 lg:mr-64' : 'ml-0 lg:ml-64' }}'">
            
            <!-- Top Navigation -->
            <header class="glass-header sticky top-0 z-20 glow-blue">
                <div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-5">
                    <div class="flex items-center justify-between gap-4 sm:gap-6 lg:gap-8">
                        <!-- Left Section -->
                        <div class="flex items-center gap-3 sm:gap-4 lg:gap-5 min-w-0 flex-1">
                            <!-- Mobile menu button -->
                            <button @click="toggleMobileMenu()" 
                                    class="ripple lg:hidden p-2.5 rounded-xl text-blue-600 hover:text-blue-700 hover:bg-blue-50 transition-all duration-200 border border-blue-200 hover:border-blue-300 flex-shrink-0 shadow-depth">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                            
                            <!-- Logo on Mobile / Page Title on Desktop -->
                            <div class="min-w-0 flex-1">
                                <!-- Logo (Mobile Only) -->
                                @if(setting('customer_panel_logo'))
                                    <img src="{{ asset('storage/' . setting('customer_panel_logo')) }}" 
                                         alt="Logo" 
                                         class="h-9 sm:h-11 w-auto lg:hidden object-contain max-w-[150px] sm:max-w-[180px]">
                                @else
                                    <img src="{{ asset('logo/pro Gineous_blue logo.svg') }}" 
                                         alt="Logo" 
                                         class="h-9 sm:h-11 w-auto lg:hidden object-contain max-w-[150px] sm:max-w-[180px]">
                                @endif
                                
                                <!-- Page Title (Desktop Only) -->
                                <h1 class="hidden lg:block text-xl sm:text-2xl lg:text-3xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent truncate">
                                    @yield('page-title', __('frontend.dashboard'))
                                </h1>
                            </div>
                        </div>
                        
                        <!-- Right Section -->
                        <div class="flex items-center gap-2 sm:gap-3 lg:gap-4 flex-shrink-0">
                            <!-- Language Switcher Dropdown -->
                            @if(setting('enable_language_menu', true))
                            <div x-data="{ languageOpen: false }" class="relative">
                                <button @click="languageOpen = !languageOpen" 
                                        class="ripple flex items-center gap-2 px-3 sm:px-4 py-2 sm:py-2.5 bg-white/80 border border-blue-200 rounded-xl text-blue-600 hover:text-blue-700 hover:bg-blue-50 transition-all duration-200 shadow-depth">
                                    <!-- Globe Icon -->
                                    <svg class="w-4 h-4 lg:w-5 lg:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                                    </svg>
                                    <span class="text-xs sm:text-sm font-medium hidden sm:inline">{{ app()->getLocale() == 'ar' ? 'العربية' : 'English' }}</span>
                                    <!-- Dropdown Arrow -->
                                    <svg class="w-3 h-3 lg:w-4 lg:h-4 transition-transform duration-200" 
                                         :class="languageOpen ? 'rotate-180' : ''"
                                         fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                                
                                <!-- Dropdown Menu -->
                                <div x-show="languageOpen" x-cloak
                                     @click.away="languageOpen = false"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 transform scale-95"
                                     x-transition:enter-end="opacity-100 transform scale-100"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 transform scale-100"
                                     x-transition:leave-end="opacity-0 transform scale-95"
                                     class="absolute {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} mt-2 w-40 bg-white border border-gray-200 rounded-lg shadow-xl z-50 overflow-hidden">
                                    
                                    <!-- Arabic Option -->
                                    <a href="{{ route('language.switch', 'ar') }}" 
                                       class="flex items-center space-x-3 {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} px-4 py-3 text-sm transition-all duration-200 {{ app()->getLocale() == 'ar' ? 'bg-blue-600/20 text-blue-900 border-l-2 border-blue-500' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                                        </svg>
                                        <span class="flex-1">العربية</span>
                                        @if(app()->getLocale() == 'ar')
                                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        @endif
                                    </a>
                                    
                                    <!-- English Option -->
                                    <a href="{{ route('language.switch', 'en') }}" 
                                       class="flex items-center space-x-3 {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} px-4 py-3 text-sm transition-all duration-200 {{ app()->getLocale() == 'en' ? 'bg-blue-600/20 text-blue-900 border-l-2 border-blue-500' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                                        </svg>
                                        <span class="flex-1">English</span>
                                        @if(app()->getLocale() == 'en')
                                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        @endif
                                    </a>
                                </div>
                            </div>
                            @endif
                            
                            <!-- Notifications -->
                            <div class="relative" x-data="{ notificationsOpen: false }">
                                <button @click="notificationsOpen = !notificationsOpen" 
                                        class="ripple p-2.5 rounded-xl text-blue-600 hover:text-blue-700 hover:bg-blue-50 transition-all duration-200 border border-blue-200 hover:border-blue-300 shadow-depth">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                                    </svg>
                                </button>
                                @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                                    <span class="pulse-blue absolute -top-1 {{ app()->getLocale() == 'ar' ? '-left-1' : '-right-1' }} h-4 w-4 bg-red-500 rounded-full flex items-center justify-center shadow-lg">
                                        <span class="text-[10px] text-white font-bold leading-none">{{ $unreadNotificationsCount }}</span>
                                    </span>
                                @endif
                                
                                <!-- Notifications Dropdown -->
                                <div x-show="notificationsOpen" x-cloak
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     @click.away="notificationsOpen = false"
                                     class="absolute {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} mt-2 w-80 sm:w-96 bg-white/95 backdrop-blur-sm rounded-xl shadow-2xl border border-gray-200 z-50 overflow-hidden">
                                    
                                    <!-- Header -->
                                    <div class="px-4 py-3 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-purple-50">
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-sm font-bold text-blue-900">
                                                {{ app()->getLocale() == 'ar' ? 'الإشعارات' : 'Notifications' }}
                                            </h3>
                                            <button id="markAllAsReadBtn" class="text-xs text-blue-600 hover:text-blue-700 font-medium">
                                                {{ app()->getLocale() == 'ar' ? 'تعليم الكل كمقروء' : 'Mark all as read' }}
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Notifications List -->
                                    <div class="max-h-96 overflow-y-auto">
                                        @if(isset($notifications) && $notifications->count() > 0)
                                            @foreach($notifications as $notification)
                                                <div class="hover:bg-gray-50 transition-colors duration-200 border-b border-gray-100 cursor-pointer notification-item
                                                    @if(!$notification->read)
                                                        @if($notification->type == 'deposit_success') bg-green-50/50
                                                        @elseif($notification->type == 'deposit_failed') bg-red-50/50
                                                        @elseif($notification->type == 'deposit_cancelled') bg-gray-50/50
                                                        @elseif($notification->type == 'deposit_pending') bg-yellow-50/50
                                                        @else bg-blue-50/50
                                                        @endif
                                                    @endif" 
                                                     data-notification-id="{{ $notification->id }}"
                                                     data-is-read="{{ $notification->read ? 'true' : 'false' }}">
                                                    <div class="block px-4 py-3">
                                                        <div class="flex items-start gap-3">
                                                            <div class="w-10 h-10 rounded-full 
                                                                @if($notification->type == 'transfer_sent') bg-purple-100
                                                                @elseif($notification->type == 'transfer_received') bg-blue-100
                                                                @elseif($notification->type == 'deposit_success') bg-green-100
                                                                @elseif($notification->type == 'deposit_failed') bg-red-100
                                                                @elseif($notification->type == 'deposit_cancelled') bg-gray-100
                                                                @elseif($notification->type == 'deposit_pending') bg-yellow-100
                                                                @else bg-blue-100
                                                                @endif
                                                                flex items-center justify-center flex-shrink-0">
                                                                @if($notification->type == 'transfer_sent')
                                                                    <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path d="M8 5a1 1 0 100 2h5.586l-1.293 1.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L13.586 5H8zM12 15a1 1 0 100-2H6.414l1.293-1.293a1 1 0 10-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L6.414 15H12z"/>
                                                                    </svg>
                                                                @elseif($notification->type == 'transfer_received')
                                                                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path d="M8 5a1 1 0 100 2h5.586l-1.293 1.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L13.586 5H8zM12 15a1 1 0 100-2H6.414l1.293-1.293a1 1 0 10-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L6.414 15H12z"/>
                                                                    </svg>
                                                                @elseif($notification->type == 'deposit_success')
                                                                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                                    </svg>
                                                                @elseif($notification->type == 'deposit_failed')
                                                                    <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                                    </svg>
                                                                @elseif($notification->type == 'deposit_cancelled')
                                                                    <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"/>
                                                                    </svg>
                                                                @elseif($notification->type == 'deposit_pending')
                                                                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                    </svg>
                                                                @else
                                                                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                                                                    </svg>
                                                                @endif
                                                            </div>
                                                            <div class="flex-1 min-w-0">
                                                                <p class="text-sm font-semibold text-gray-900 mb-1">{{ $notification->getLocalizedTitle() }}</p>
                                                                <p class="text-xs text-gray-600">{{ $notification->getLocalizedMessage() }}</p>
                                                                <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                                            </div>
                                                            @if(!$notification->read)
                                                                <div class="w-2 h-2 rounded-full bg-blue-600 flex-shrink-0"></div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <!-- No Notifications -->
                                            <div class="p-8 text-center">
                                                <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-blue-50 flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                                    </svg>
                                                </div>
                                                <p class="text-sm font-medium text-gray-600 mb-1">
                                                    {{ app()->getLocale() == 'ar' ? 'لا توجد إشعارات' : 'No notifications' }}
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    {{ app()->getLocale() == 'ar' ? 'سيتم عرض الإشعارات الجديدة هنا' : 'New notifications will appear here' }}
                                                </p>
                                            </div>
                                        @endif
                                        
                                        <!-- Example Notification Item (Hidden by default) -->
                                        <div class="hidden hover:bg-gray-50 transition-colors duration-200 border-b border-gray-100">
                                            <a href="#" class="block px-4 py-3">
                                                <div class="flex items-start gap-3">
                                                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                                                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z"/>
                                                            <path d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z"/>
                                                        </svg>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-medium text-gray-900 mb-1">
                                                            Notification Title
                                                        </p>
                                                        <p class="text-xs text-gray-600 mb-1">
                                                            Notification description text goes here
                                                        </p>
                                                        <p class="text-xs text-gray-500">
                                                            2 minutes ago
                                                        </p>
                                                    </div>
                                                    <div class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0 mt-1"></div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- User Avatar & Dropdown -->
                            <div class="relative" x-data="{ userDropdown: false }">
                                <button @click="userDropdown = !userDropdown" 
                                        class="ripple flex items-center gap-2.5 sm:gap-3 p-2 sm:p-2.5 rounded-xl hover:bg-blue-50 transition-all duration-200 group shadow-depth border border-transparent hover:border-blue-200">
                                    <!-- User Avatar -->
                                    <div class="avatar-glow w-9 h-9 lg:w-10 lg:h-10 rounded-full bg-gradient-to-br from-blue-600 to-blue-400 flex items-center justify-center text-white font-bold text-sm lg:text-base flex-shrink-0">
                                        {{ strtoupper(substr(auth('client')->user()->name ?? 'C', 0, 1)) }}
                                    </div>
                                    
                                    <!-- User Info (Hidden on mobile) -->
                                    <div class="hidden lg:block min-w-0">
                                        <p class="text-sm font-semibold text-blue-900 truncate">{{ auth('client')->user()->name ?? 'العميل' }}</p>
                                        <p class="text-xs text-gray-600 truncate">{{ __('frontend.client') }}</p>
                                    </div>
                                    
                                    <!-- Dropdown Arrow -->
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-600 transition-colors duration-200 hidden sm:block flex-shrink-0" 
                                         :class="userDropdown ? 'rotate-180' : ''" 
                                         fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                                
                                <!-- Dropdown Menu -->
                                <div x-show="userDropdown" x-cloak
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     @click.away="userDropdown = false"
                                     class="absolute {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} mt-2 w-48 bg-white/95 backdrop-blur-sm rounded-xl shadow-xl border border-gray-200 py-2 z-50">
                                    <div class="px-4 py-3 border-b border-gray-200">
                                        <p class="text-sm font-medium text-blue-900">{{ auth('client')->user()->name ?? __('frontend.client') }}</p>
                                        <p class="text-xs text-gray-600">{{ auth('client')->user()->email ?? 'client@example.com' }}</p>
                                    </div>
                                    <a href="{{ route('client.profile') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-colors duration-200">
                                        <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ __('frontend.profile') }}
                                    </a>
                                    <a href="{{ route('settings.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-colors duration-200">
                                        <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ __('frontend.account_settings') }}
                                    </a>
                                    <div class="border-t border-gray-200 mt-2">
                                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                                            @csrf
                                            <button type="submit" class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:text-red-700 hover:bg-red-50 transition-colors duration-200 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
                                                <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ __('frontend.logout') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8 client-main-content overflow-x-hidden">
                <div class="max-w-7xl mx-auto min-h-[60vh]">
                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            @include('frontend.partials.footer')
        </div>
    </div>

    <!-- Alpine.js with Collapse Plugin -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        // إدارة حالة القائمة الجانبية مع الاحتفاظ بالحالة عند تحديث الصفحة
        document.addEventListener('alpine:init', () => {
            Alpine.data('sidebarController', () => ({
                sidebarCollapsed: false,
                mobileMenuOpen: false,
                
                init() {
                    // التحقق من دعم localStorage
                    if (this.isLocalStorageSupported()) {
                        // استرجاع حالة القائمة الجانبية من localStorage
                        this.loadSidebarState();
                    }
                    
                    // التحقق من حجم الشاشة عند التحميل
                    this.checkScreenSize();
                    
                    // إضافة مستمع للتغيير في حجم الشاشة
                    window.addEventListener('resize', () => {
                        this.checkScreenSize();
                    });

                    // مراقبة تغيير حالة القائمة الجانبية وحفظها
                    this.$watch('sidebarCollapsed', (value) => {
                        if (this.isLocalStorageSupported()) {
                            this.saveSidebarState(value);
                        }
                    });
                },

                // فحص دعم localStorage
                isLocalStorageSupported() {
                    try {
                        const test = 'test';
                        localStorage.setItem(test, test);
                        localStorage.removeItem(test);
                        return true;
                    } catch (e) {
                        return false;
                    }
                },

                // حفظ حالة القائمة الجانبية في localStorage
                saveSidebarState(collapsed) {
                    try {
                        localStorage.setItem('clientSidebarCollapsed', collapsed ? 'true' : 'false');
                    } catch (e) {
                        console.warn('Unable to save sidebar state to localStorage:', e);
                    }
                },

                // استرجاع حالة القائمة الجانبية من localStorage
                loadSidebarState() {
                    try {
                        const saved = localStorage.getItem('clientSidebarCollapsed');
                        if (saved !== null) {
                            this.sidebarCollapsed = saved === 'true';
                        } else {
                            // إذا لم تكن هناك حالة محفوظة، استخدم الحالة الافتراضية (مفتوحة)
                            this.sidebarCollapsed = false;
                        }
                    } catch (e) {
                        console.warn('Unable to load sidebar state from localStorage:', e);
                        // في حالة الخطأ، استخدم الحالة الافتراضية
                        this.sidebarCollapsed = false;
                    }
                },
                
                checkScreenSize() {
                    if (window.innerWidth >= 1024) {
                        this.mobileMenuOpen = false;
                        document.body.style.overflow = 'auto';
                    } else {
                        // على الشاشات الصغيرة، لا نحفظ حالة طي القائمة الجانبية
                        // لأنها تُخفى تلقائياً
                    }
                },
                
                toggleMobileMenu() {
                    this.mobileMenuOpen = !this.mobileMenuOpen;
                    
                    if (this.mobileMenuOpen) {
                        document.body.style.overflow = 'hidden';
                    } else {
                        document.body.style.overflow = 'auto';
                    }
                },
                
                closeMobileMenu() {
                    this.mobileMenuOpen = false;
                    document.body.style.overflow = 'auto';
                }
            }))
            
            // إضافة tooltip directive لـ Alpine.js
            Alpine.directive('tooltip', (el, { expression }, { evaluate }) => {
                const tooltipText = evaluate(expression);
                
                if (!tooltipText) return;
                
                let tooltip = null;
                
                const showTooltip = () => {
                    // إنشاء عنصر tooltip
                    tooltip = document.createElement('div');
                    tooltip.textContent = tooltipText;
                    tooltip.className = 'fixed z-[100] px-2 py-1 text-xs font-medium text-white bg-slate-900 rounded shadow-lg pointer-events-none whitespace-nowrap';
                    document.body.appendChild(tooltip);
                    
                    // حساب موضع tooltip
                    const rect = el.getBoundingClientRect();
                    const isRTL = document.documentElement.dir === 'rtl';
                    
                    if (isRTL) {
                        tooltip.style.right = `${window.innerWidth - rect.left + 10}px`;
                    } else {
                        tooltip.style.left = `${rect.right + 10}px`;
                    }
                    tooltip.style.top = `${rect.top + (rect.height / 2) - (tooltip.offsetHeight / 2)}px`;
                };
                
                const hideTooltip = () => {
                    if (tooltip) {
                        tooltip.remove();
                        tooltip = null;
                    }
                };
                
                el.addEventListener('mouseenter', showTooltip);
                el.addEventListener('mouseleave', hideTooltip);
                
                // تنظيف عند إزالة العنصر
                el._x_cleanups = el._x_cleanups || [];
                el._x_cleanups.push(() => {
                    el.removeEventListener('mouseenter', showTooltip);
                    el.removeEventListener('mouseleave', hideTooltip);
                    hideTooltip();
                });
            });
        });
    </script>
    
    <!-- Preloader Script -->
    <script>
        // إخفاء الـ Preloader بعد تحميل كامل الصفحة
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            
            // إضافة تأخير صغير لضمان تحميل Alpine.js
            setTimeout(() => {
                preloader.classList.add('hidden');
                
                // إزالة الـ Preloader من DOM بعد انتهاء الـ transition
                setTimeout(() => {
                    preloader.remove();
                }, 500);
            }, 300);
        });
        
        // Fallback: إخفاء الـ Preloader بعد 5 ثواني كحد أقصى
        setTimeout(() => {
            const preloader = document.getElementById('preloader');
            if (preloader && !preloader.classList.contains('hidden')) {
                preloader.classList.add('hidden');
                setTimeout(() => {
                    preloader.remove();
                }, 500);
            }
        }, 5000);
    </script>

    {{-- Support PIN Modal --}}
    <div x-data="supportPinModal()" 
         x-show="open" 
         x-cloak
         @open-support-pin-modal.window="openModal()"
         @keydown.escape.window="open = false"
         class="fixed inset-0 z-[9999] overflow-y-auto"
         aria-labelledby="support-pin-modal-title" 
         role="dialog" 
         aria-modal="true">
        
        <!-- Backdrop -->
        <div x-show="open"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="open = false"
             class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm"></div>
        
        <!-- Modal Panel -->
        <div class="flex min-h-full items-center justify-center p-4">
            <div x-show="open"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                 @click.stop
                 class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden">
                
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <h3 id="support-pin-modal-title" class="text-lg font-bold text-white">
                                {{ app()->getLocale() == 'ar' ? 'رقم الدعم السري' : 'Support PIN' }}
                            </h3>
                        </div>
                        <button @click="open = false" class="text-white/80 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Body -->
                <div class="p-6">
                    <p class="text-gray-600 text-sm mb-4 text-center">
                        {{ app()->getLocale() == 'ar' ? 'استخدم هذا الرقم عند التواصل مع فريق الدعم للتحقق من هويتك' : 'Use this PIN when contacting support to verify your identity' }}
                    </p>
                    
                    <!-- PIN Display -->
                    <div class="bg-gradient-to-r from-slate-50 to-slate-100 rounded-xl p-6 border border-slate-200">
                        <div class="flex justify-center gap-2" dir="ltr">
                            <template x-for="digit in pinDigits" :key="digit.index">
                                <div class="w-12 h-14 bg-white rounded-lg border-2 border-blue-200 flex items-center justify-center text-2xl font-bold text-blue-600 shadow-sm transition-all duration-300"
                                     :class="{ 'animate-pulse border-amber-300': secondsLeft <= 30 }">
                                    <span x-text="digit.value"></span>
                                </div>
                            </template>
                        </div>
                        
                        <!-- Timer -->
                        <div class="mt-4 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" :class="secondsLeft <= 30 ? 'text-amber-500' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm" :class="secondsLeft <= 30 ? 'text-amber-600 font-medium' : 'text-gray-500'">
                                {{ app()->getLocale() == 'ar' ? 'يتغير خلال' : 'Changes in' }}: 
                                <span x-text="formatTime(secondsLeft)" class="font-mono"></span>
                            </span>
                        </div>
                        
                        <!-- Progress Bar -->
                        <div class="mt-3 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full transition-all duration-1000 rounded-full"
                                 :class="secondsLeft <= 30 ? 'bg-amber-500' : 'bg-blue-500'"
                                 :style="'width: ' + (secondsLeft / 900 * 100) + '%'"></div>
                        </div>
                    </div>
                    
                    <!-- Copy Button -->
                    <button @click="copyPin()" 
                            class="mt-4 w-full flex items-center justify-center gap-2 bg-blue-50 hover:bg-blue-100 text-blue-600 font-medium py-3 px-4 rounded-xl transition-all duration-300"
                            :class="copied ? 'bg-green-50 text-green-600' : ''">
                        <template x-if="!copied">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </template>
                        <template x-if="copied">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </template>
                        <span x-text="copied ? '{{ app()->getLocale() == 'ar' ? 'تم النسخ' : 'Copied' }}' : '{{ app()->getLocale() == 'ar' ? 'نسخ الرقم' : 'Copy PIN' }}'"></span>
                    </button>
                    
                    <!-- Security Notice -->
                    <div class="mt-4 flex items-start gap-2 text-xs text-amber-600 bg-amber-50 rounded-lg p-3">
                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span>
                            {{ app()->getLocale() == 'ar' ? 'هذا الرقم يتغير كل 15 دقيقة لحمايتك. لا تشاركه مع أي شخص.' : 'This PIN changes every 15 minutes for your security. Never share it with anyone.' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function supportPinModal() {
            return {
                open: false,
                pin: '',
                pinDigits: [],
                expiresAt: 0,
                serverTimeDiff: 0,
                secondsLeft: 0,
                interval: null,
                copied: false,
                
                openModal() {
                    this.open = true;
                    this.copied = false;
                    this.fetchPin();
                },
                
                async fetchPin() {
                    try {
                        const response = await fetch('/api/support-pin', {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        });
                        const data = await response.json();
                        console.log('Support PIN data:', data);
                        
                        if (data.pin && data.expires_at !== undefined) {
                            this.pin = data.pin;
                            this.expiresAt = parseInt(data.expires_at);
                            // Calculate time difference between server and client
                            this.serverTimeDiff = Math.floor(Date.now() / 1000) - parseInt(data.server_time);
                            this.calculateSecondsLeft();
                            this.pinDigits = data.pin.split('').map((v, i) => ({ index: i, value: v }));
                            this.startTimer();
                        } else {
                            console.error('Invalid response:', data);
                            // Set default values
                            this.pin = '------';
                            this.secondsLeft = 0;
                            this.pinDigits = '------'.split('').map((v, i) => ({ index: i, value: v }));
                        }
                    } catch (error) {
                        console.error('Error fetching support PIN:', error);
                        this.pin = '------';
                        this.secondsLeft = 0;
                        this.pinDigits = '------'.split('').map((v, i) => ({ index: i, value: v }));
                    }
                },
                
                calculateSecondsLeft() {
                    // Get current time adjusted for server difference
                    const currentServerTime = Math.floor(Date.now() / 1000) - this.serverTimeDiff;
                    this.secondsLeft = Math.max(0, this.expiresAt - currentServerTime);
                },
                
                startTimer() {
                    if (this.interval) clearInterval(this.interval);
                    
                    this.interval = setInterval(() => {
                        this.calculateSecondsLeft();
                        if (this.secondsLeft <= 0) {
                            // PIN expired, fetch new one
                            this.fetchPin();
                        }
                    }, 1000);
                },
                
                formatTime(seconds) {
                    if (isNaN(seconds) || seconds === null || seconds === undefined) {
                        return '0:00';
                    }
                    const mins = Math.floor(seconds / 60);
                    const secs = seconds % 60;
                    return `${mins}:${secs.toString().padStart(2, '0')}`;
                },
                
                copyPin() {
                    if (!this.pin || this.pin === '------') {
                        console.error('No PIN to copy');
                        return;
                    }
                    
                    const self = this;
                    
                    // Try modern clipboard API first
                    if (navigator.clipboard && navigator.clipboard.writeText) {
                        navigator.clipboard.writeText(this.pin).then(() => {
                            self.copied = true;
                            setTimeout(() => { self.copied = false; }, 2000);
                        }).catch(err => {
                            console.error('Clipboard API failed:', err);
                            self.fallbackCopy();
                        });
                    } else {
                        // Fallback for older browsers or non-HTTPS
                        this.fallbackCopy();
                    }
                },
                
                fallbackCopy() {
                    const textArea = document.createElement('textarea');
                    textArea.value = this.pin;
                    textArea.style.position = 'fixed';
                    textArea.style.top = '0';
                    textArea.style.left = '0';
                    textArea.style.width = '2em';
                    textArea.style.height = '2em';
                    textArea.style.padding = '0';
                    textArea.style.border = 'none';
                    textArea.style.outline = 'none';
                    textArea.style.boxShadow = 'none';
                    textArea.style.background = 'transparent';
                    document.body.appendChild(textArea);
                    textArea.focus();
                    textArea.select();
                    
                    try {
                        const successful = document.execCommand('copy');
                        if (successful) {
                            this.copied = true;
                            setTimeout(() => { this.copied = false; }, 2000);
                        }
                    } catch (err) {
                        console.error('Fallback copy failed:', err);
                    }
                    
                    document.body.removeChild(textArea);
                },
                
                destroy() {
                    if (this.interval) clearInterval(this.interval);
                }
            };
        }
    </script>

    {{-- Notifications JavaScript --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mark notification as read when clicked
            const notificationItems = document.querySelectorAll('.notification-item');
            notificationItems.forEach(item => {
                item.addEventListener('click', async function() {
                    const notificationId = this.dataset.notificationId;
                    const isRead = this.dataset.isRead === 'true';
                    
                    // If already read, do nothing
                    if (isRead) return;
                    
                    try {
                        const response = await fetch(`/notifications/${notificationId}/read`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });
                        
                        const data = await response.json();
                        
                        if (data.success) {
                            // Update UI: Remove blue background and dot
                            this.classList.remove('bg-blue-50/50');
                            const blueDot = this.querySelector('.bg-blue-600');
                            if (blueDot) {
                                blueDot.remove();
                            }
                            
                            // Update unread count
                            const badge = document.querySelector('.pulse-blue span');
                            if (badge) {
                                const currentCount = parseInt(badge.textContent);
                                const newCount = currentCount - 1;
                                if (newCount > 0) {
                                    badge.textContent = newCount;
                                } else {
                                    badge.parentElement.remove();
                                }
                            }
                            
                            // Update data attribute
                            this.dataset.isRead = 'true';
                        }
                    } catch (error) {
                        console.error('Error marking notification as read:', error);
                    }
                });
            });
            
            // Mark all as read button
            const markAllBtn = document.getElementById('markAllAsReadBtn');
            if (markAllBtn) {
                markAllBtn.addEventListener('click', async function(e) {
                    e.stopPropagation(); // Prevent dropdown from closing
                    
                    try {
                        const response = await fetch('/notifications/mark-all-read', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });
                        
                        const data = await response.json();
                        
                        if (data.success) {
                            // Update all notification items
                            const allNotifications = document.querySelectorAll('.notification-item');
                            allNotifications.forEach(notification => {
                                // Remove blue background
                                notification.classList.remove('bg-blue-50/50');
                                
                                // Remove blue dot
                                const blueDot = notification.querySelector('.bg-blue-600');
                                if (blueDot) {
                                    blueDot.remove();
                                }
                                
                                // Update data attribute
                                notification.dataset.isRead = 'true';
                            });
                            
                            // Remove or hide unread count badge
                            const badge = document.querySelector('.pulse-blue');
                            if (badge) {
                                badge.remove();
                            }
                        }
                    } catch (error) {
                        console.error('Error marking all notifications as read:', error);
                    }
                });
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>

