@extends('frontend.layout')

@section('title', __('frontend.vps_hosting') . ' - ' . config('app.name'))
@section('description', __('frontend.vps_hosting_description'))
@section('keywords', 'VPS, Virtual Private Server, Cloud VPS, Linux VPS, Windows VPS')

@push('styles')
<!-- Three.js Globe CSS -->
<style>
    [x-cloak] { display: none !important; }
    #datacenters-map {
        position: relative;
        cursor: grab;
    }
    #datacenters-map:active {
        cursor: grabbing;
    }
    
    /* Tooltip Animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translate(-50%, -50%) scale(0.9);
        }
        to {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1);
        }
    }
    
    .animate-fade-in {
        animation: fadeIn 0.3s ease-out forwards;
    }
    
    /* Pulse Animation */
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
    }
    
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="relative py-24 bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900 overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <!-- Grid Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: linear-gradient(to right, rgba(255,255,255,0.1) 1px, transparent 1px), linear-gradient(to bottom, rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 50px 50px;"></div>
        </div>
        <!-- Gradient Orbs -->
        <div class="absolute top-0 -left-4 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute top-0 -right-4 w-96 h-96 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-96 h-96 bg-blue-800 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-4xl mx-auto">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-500/20 backdrop-blur-sm text-white rounded-full text-sm font-medium mb-8 border border-blue-400/30">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                </svg>
                <span class="font-semibold">{{ __('frontend.vps_hosting') }}</span>
            </div>

            <!-- Main Heading -->
            <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold text-white mb-6 leading-tight">
                {{ __('frontend.powerful_vps_hosting') }}
            </h1>

            <!-- Description -->
            <p class="text-xl sm:text-2xl text-blue-100 mb-10 leading-relaxed">
                {{ __('frontend.vps_hosting_hero_description') }}
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-16">
                <a href="#plans" class="inline-flex items-center justify-center px-10 py-5 bg-white text-blue-600 font-bold rounded-xl hover:bg-blue-50 transition-all duration-300 shadow-2xl hover:shadow-blue-500/50 hover:scale-105 transform">
                    {{ __('frontend.view_plans') }}
                    <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
                <a href="#features" class="inline-flex items-center justify-center px-10 py-5 bg-transparent text-white font-bold rounded-xl border-2 border-white hover:bg-white hover:text-blue-600 transition-all duration-300 hover:scale-105 transform">
                    {{ __('frontend.learn_more') }}
                </a>
            </div>
        </div>

        <!-- Hero Cards -->
        <div class="mt-20 relative">
            <div class="relative mx-auto max-w-6xl">
                <!-- Main Container with Glass Effect -->
                <div class="relative bg-white/10 backdrop-blur-xl rounded-3xl shadow-2xl p-8 border border-white/20">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Server Card -->
                        <div class="group bg-gradient-to-br from-blue-500/20 to-blue-600/20 backdrop-blur-md rounded-2xl p-8 border border-blue-400/30 hover:border-blue-300/50 transition-all duration-300 hover:transform hover:scale-105">
                            <div class="text-white text-center">
                                <div class="w-20 h-20 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg group-hover:shadow-blue-500/50 transition-all duration-300">
                                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3 12v3c0 1.657 3.134 3 7 3s7-1.343 7-3v-3c0 1.657-3.134 3-7 3s-7-1.343-7-3z"></path>
                                        <path d="M3 7v3c0 1.657 3.134 3 7 3s7-1.343 7-3V7c0 1.657-3.134 3-7 3S3 8.657 3 7z"></path>
                                        <path d="M17 5c0 1.657-3.134 3-7 3S3 6.657 3 5s3.134-3 7-3 7 1.343 7 3z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold mb-3">{{ __('frontend.high_performance') }}</h3>
                                <p class="text-base text-blue-100">{{ __('frontend.ssd_storage') }}</p>
                            </div>
                        </div>

                        <!-- Speed Card -->
                        <div class="group bg-gradient-to-br from-blue-500/20 to-blue-600/20 backdrop-blur-md rounded-2xl p-8 border border-blue-400/30 hover:border-blue-300/50 transition-all duration-300 hover:transform hover:scale-105">
                            <div class="text-white text-center">
                                <div class="w-20 h-20 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg group-hover:shadow-blue-500/50 transition-all duration-300">
                                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold mb-3">{{ __('frontend.fast_deployment') }}</h3>
                                <p class="text-base text-blue-100">{{ __('frontend.instant_setup') }}</p>
                            </div>
                        </div>

                        <!-- Security Card -->
                        <div class="group bg-gradient-to-br from-blue-500/20 to-blue-600/20 backdrop-blur-md rounded-2xl p-8 border border-blue-400/30 hover:border-blue-300/50 transition-all duration-300 hover:transform hover:scale-105">
                            <div class="text-white text-center">
                                <div class="w-20 h-20 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg group-hover:shadow-blue-500/50 transition-all duration-300">
                                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold mb-3">{{ __('frontend.secure_protected') }}</h3>
                                <p class="text-base text-blue-100">{{ __('frontend.ddos_protection') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
@keyframes blob {
    0%, 100% {
        transform: translate(0, 0) scale(1);
    }
    33% {
        transform: translate(30px, -50px) scale(1.1);
    }
    66% {
        transform: translate(-20px, 20px) scale(0.9);
    }
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
</style>

<!-- Features Section -->
<section id="features" class="py-24 bg-gradient-to-b from-white to-blue-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-20">
            <div class="inline-block px-4 py-2 bg-blue-100 text-blue-600 rounded-full text-sm font-semibold mb-6">
                {{ __('frontend.features') }}
            </div>
            <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-6">
                {{ __('frontend.why_choose_our_vps') }}
            </h2>
            <p class="text-xl text-gray-600 leading-relaxed">
                {{ __('frontend.vps_features_description') }}
            </p>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Feature 1 - Root Access -->
            <div class="group relative bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 border-2 border-transparent hover:border-blue-500 hover:-translate-y-2">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-500 to-blue-600 rounded-t-2xl transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:shadow-blue-500/50 transform group-hover:scale-110 transition-all duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-blue-600 transition-colors duration-300">{{ __('frontend.full_root_access') }}</h3>
                <p class="text-gray-600 leading-relaxed text-lg">{{ __('frontend.full_root_access_desc') }}</p>
            </div>

            <!-- Feature 2 - SSD Storage -->
            <div class="group relative bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 border-2 border-transparent hover:border-blue-500 hover:-translate-y-2">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-600 to-blue-700 rounded-t-2xl transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
                <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:shadow-blue-600/50 transform group-hover:scale-110 transition-all duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-blue-600 transition-colors duration-300">{{ __('frontend.ssd_storage') }}</h3>
                <p class="text-gray-600 leading-relaxed text-lg">{{ __('frontend.ssd_storage_desc') }}</p>
            </div>

            <!-- Feature 3 - DDoS Protection -->
            <div class="group relative bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 border-2 border-transparent hover:border-blue-500 hover:-translate-y-2">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-700 to-blue-800 rounded-t-2xl transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
                <div class="w-16 h-16 bg-gradient-to-br from-blue-700 to-blue-800 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:shadow-blue-700/50 transform group-hover:scale-110 transition-all duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-blue-600 transition-colors duration-300">{{ __('frontend.ddos_protection') }}</h3>
                <p class="text-gray-600 leading-relaxed text-lg">{{ __('frontend.ddos_protection_desc') }}</p>
            </div>

            <!-- Feature 4 - Uptime -->
            <div class="group relative bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 border-2 border-transparent hover:border-blue-500 hover:-translate-y-2">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-500 to-blue-600 rounded-t-2xl transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:shadow-blue-500/50 transform group-hover:scale-110 transition-all duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-blue-600 transition-colors duration-300">{{ __('frontend.99_uptime') }}</h3>
                <p class="text-gray-600 leading-relaxed text-lg">{{ __('frontend.99_uptime_desc') }}</p>
            </div>

            <!-- Feature 5 - 24/7 Support -->
            <div class="group relative bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 border-2 border-transparent hover:border-blue-500 hover:-translate-y-2">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-600 to-blue-700 rounded-t-2xl transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
                <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:shadow-blue-600/50 transform group-hover:scale-110 transition-all duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-blue-600 transition-colors duration-300">{{ __('frontend.24_7_support') }}</h3>
                <p class="text-gray-600 leading-relaxed text-lg">{{ __('frontend.24_7_support_desc') }}</p>
            </div>

            <!-- Feature 6 - Automated Backups -->
            <div class="group relative bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 border-2 border-transparent hover:border-blue-500 hover:-translate-y-2">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-700 to-blue-800 rounded-t-2xl transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
                <div class="w-16 h-16 bg-gradient-to-br from-blue-700 to-blue-800 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:shadow-blue-700/50 transform group-hover:scale-110 transition-all duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-blue-600 transition-colors duration-300">{{ __('frontend.instant_backups') }}</h3>
                <p class="text-gray-600 leading-relaxed text-lg">{{ __('frontend.instant_backups_desc') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Pricing Plans Section -->
<section id="plans" class="py-24 bg-gradient-to-b from-gray-50 to-white" x-data="{ period: 'monthly' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-12">
            <div class="inline-block px-4 py-2 bg-blue-100 text-blue-600 rounded-full text-sm font-semibold mb-6">
                {{ __('frontend.vps_hosting_plans') }}
            </div>
            <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-6">
                {{ __('frontend.choose_perfect_plan') }}
            </h2>
            <p class="text-xl text-gray-600">
                {{ __('frontend.vps_features_description') }}
            </p>
        </div>

        <!-- Billing Period Filter -->
        <div class="flex justify-center mb-12">
            <div class="inline-flex flex-col sm:flex-row bg-white rounded-2xl p-2 shadow-lg border-2 border-gray-200 gap-2 sm:gap-0">
                <button @click="period = 'monthly'" 
                    :class="period === 'monthly' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-md' : 'text-gray-600 hover:text-blue-600'"
                    class="px-6 sm:px-8 py-3 rounded-xl font-semibold transition-all duration-300 focus:outline-none whitespace-nowrap">
                    {{ __('frontend.monthly') }}
                </button>
                <button @click="period = 'quarterly'" 
                    :class="period === 'quarterly' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-md' : 'text-gray-600 hover:text-blue-600'"
                    class="px-6 sm:px-8 py-3 rounded-xl font-semibold transition-all duration-300 focus:outline-none relative whitespace-nowrap">
                    {{ __('frontend.quarterly') }}
                    <span class="absolute -top-2 {{ app()->getLocale() == 'ar' ? '-left-2' : '-right-2' }} bg-green-500 text-white text-xs px-2 py-0.5 rounded-full font-bold">-5%</span>
                </button>
                <button @click="period = 'semi_annually'" 
                    :class="period === 'semi_annually' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-md' : 'text-gray-600 hover:text-blue-600'"
                    class="px-6 sm:px-8 py-3 rounded-xl font-semibold transition-all duration-300 focus:outline-none relative whitespace-nowrap">
                    {{ __('frontend.semi_annually') }}
                    <span class="absolute -top-2 {{ app()->getLocale() == 'ar' ? '-left-2' : '-right-2' }} bg-green-500 text-white text-xs px-2 py-0.5 rounded-full font-bold">-10%</span>
                </button>
                <button @click="period = 'annually'" 
                    :class="period === 'annually' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-md' : 'text-gray-600 hover:text-blue-600'"
                    class="px-6 sm:px-8 py-3 rounded-xl font-semibold transition-all duration-300 focus:outline-none relative whitespace-nowrap">
                    {{ __('frontend.annually') }}
                    <span class="absolute -top-2 {{ app()->getLocale() == 'ar' ? '-left-2' : '-right-2' }} bg-green-500 text-white text-xs px-2 py-0.5 rounded-full font-bold">-15%</span>
                </button>
            </div>
        </div>

        @if($vpsPlans->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-600 text-lg">{{ __('frontend.no_plans_available') }}</p>
            </div>
        @else
            <!-- Plans Table -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-200">
                <!-- Table Container with Horizontal Scroll -->
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[1000px]">
                        <!-- Table Header -->
                        <thead>
                            <tr class="bg-gradient-to-r from-blue-600 to-blue-700">
                                <th class="px-6 py-5 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-sm font-bold text-white uppercase tracking-wider">
                                    {{ __('frontend.plan_name') }}
                                </th>
                                <th class="px-6 py-5 text-center text-sm font-bold text-white uppercase tracking-wider">
                                    {{ __('frontend.cpu_cores') }}
                                </th>
                                <th class="px-6 py-5 text-center text-sm font-bold text-white uppercase tracking-wider">
                                    RAM
                                </th>
                                <th class="px-6 py-5 text-center text-sm font-bold text-white uppercase tracking-wider">
                                    {{ __('frontend.storage') }}
                                </th>
                                <th class="px-6 py-5 text-center text-sm font-bold text-white uppercase tracking-wider">
                                    {{ __('frontend.bandwidth') }}
                                </th>
                                <th class="px-6 py-5 text-center text-sm font-bold text-white uppercase tracking-wider">
                                    {{ __('frontend.price') }}
                                </th>
                                <th class="px-6 py-5 text-center text-sm font-bold text-white uppercase tracking-wider">
                                    {{ __('frontend.action') }}
                                </th>
                            </tr>
                        </thead>

                        <!-- Table Body -->
                        <tbody class="divide-y divide-gray-200">
                            @foreach($vpsPlans as $index => $plan)
                                <tr class="hover:bg-blue-50 transition-colors duration-300 {{ $plan->is_featured ? 'bg-blue-50/50' : ($index % 2 == 0 ? 'bg-white' : 'bg-gray-50') }}">
                                    <!-- Plan Name -->
                                    <td class="px-6 py-6 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            @if($plan->is_featured)
                                                <div class="flex-shrink-0">
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-md">
                                                        <svg class="w-3 h-3 {{ app()->getLocale() == 'ar' ? 'ml-1' : 'mr-1' }}" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                        </svg>
                                                        {{ __('frontend.popular') }}
                                                    </span>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="text-lg font-bold text-gray-900">{{ $plan->plan_name }}</div>
                                                @if($plan->plan_tagline)
                                                    <div class="text-sm text-gray-500 mt-1">{{ $plan->plan_tagline }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <!-- CPU -->
                                    <td class="px-6 py-6 whitespace-nowrap text-center">
                                        <div class="flex flex-col items-center gap-1">
                                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                                            </svg>
                                            <span class="text-base font-semibold text-gray-900">{{ $plan->vcpu_count }} {{ __('frontend.cores') }}</span>
                                        </div>
                                    </td>

                                    <!-- RAM -->
                                    <td class="px-6 py-6 whitespace-nowrap text-center">
                                        <div class="flex flex-col items-center gap-1">
                                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                                            </svg>
                                            <span class="text-base font-semibold text-gray-900">
                                                {{ $plan->ram_mb >= 1024 ? ($plan->ram_mb / 1024) . ' GB' : $plan->ram_mb . ' MB' }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Storage -->
                                    <td class="px-6 py-6 whitespace-nowrap text-center">
                                        <div class="flex flex-col items-center gap-1">
                                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                                            </svg>
                                            <span class="text-base font-semibold text-gray-900">{{ $plan->storage_gb }} GB SSD</span>
                                        </div>
                                    </td>

                                    <!-- Bandwidth -->
                                    <td class="px-6 py-6 whitespace-nowrap text-center">
                                        <div class="flex flex-col items-center gap-1">
                                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                            <span class="text-base font-semibold text-gray-900">
                                                {{ $plan->bandwidth_gb >= 1024 ? ($plan->bandwidth_gb / 1024) . ' TB' : $plan->bandwidth_gb . ' GB' }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Price -->
                                    <td class="px-6 py-6 whitespace-nowrap text-center">
                                        <div class="flex flex-col items-center gap-1">
                                            <!-- Monthly Price -->
                                            <div x-show="period === 'monthly'" x-transition>
                                                <div class="text-3xl font-bold text-blue-600">${{ number_format($plan->monthly_price, 2) }}</div>
                                                <div class="text-sm text-gray-500">/{{ __('frontend.month') }}</div>
                                            </div>
                                            <!-- Quarterly Price -->
                                            <div x-show="period === 'quarterly'" x-transition x-cloak>
                                                <div class="text-3xl font-bold text-blue-600">${{ number_format($plan->quarterly_price, 2) }}</div>
                                                <div class="text-sm text-gray-500">/{{ __('frontend.3_months') }}</div>
                                                <span class="inline-block px-2 py-0.5 bg-green-100 text-green-700 text-xs font-bold rounded-full mt-1">-5%</span>
                                            </div>
                                            <!-- Semi-Annually Price -->
                                            <div x-show="period === 'semi_annually'" x-transition x-cloak>
                                                <div class="text-3xl font-bold text-blue-600">${{ number_format($plan->semi_annually_price, 2) }}</div>
                                                <div class="text-sm text-gray-500">/{{ __('frontend.6_months') }}</div>
                                                <span class="inline-block px-2 py-0.5 bg-green-100 text-green-700 text-xs font-bold rounded-full mt-1">-10%</span>
                                            </div>
                                            <!-- Annually Price -->
                                            <div x-show="period === 'annually'" x-transition x-cloak>
                                                <div class="text-3xl font-bold text-blue-600">${{ number_format($plan->annually_price, 2) }}</div>
                                                <div class="text-sm text-gray-500">/{{ __('frontend.year') }}</div>
                                                <span class="inline-block px-2 py-0.5 bg-green-100 text-green-700 text-xs font-bold rounded-full mt-1">-15%</span>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Action Button -->
                                    <td class="px-6 py-6 whitespace-nowrap text-center">
                                        <a href="{{ route('vps.configure', $plan->id) }}" class="inline-flex items-center justify-center px-6 py-3 {{ $plan->is_featured ? 'bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800' : 'bg-blue-600 hover:bg-blue-700' }} text-white font-bold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                                            {{ __('frontend.order_now') }}
                                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Operating Systems Section -->
<section id="operating-systems-section" class="py-24 bg-gradient-to-b from-white to-gray-50" x-data="{ showAll: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-16">
            <div class="inline-block px-4 py-2 bg-blue-100 text-blue-600 rounded-full text-sm font-semibold mb-6">
                {{ __('frontend.operating_systems') }}
            </div>
            <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-6">
                {{ __('frontend.choose_your_os') }}
            </h2>
            <p class="text-xl text-gray-600 leading-relaxed">
                {{ __('frontend.os_description') }}
            </p>
        </div>

        @if(!empty($operatingSystems) && count($operatingSystems) > 0)
            @php
                // Filter out non-user OS and get displayable OS
                $displayableOS = collect($operatingSystems)->filter(function ($os) {
                    return !in_array($os['family'], ['iso', 'snapshot', 'backup', 'application']);
                })->values();
                
                $totalOS = $displayableOS->count();
                $initialShow = 12;
            @endphp

            <!-- OS Grid from Vultr API -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-6">
                @foreach($displayableOS as $index => $os)
                    @php
                        // Determine OS family for styling
                        $family = strtolower($os['family'] ?? 'other');
                        
                        // Color and icon mapping for Simple Icons CDN
                        $familyConfig = [
                            'ubuntu' => ['color' => '#E95420', 'icon' => 'ubuntu'],
                            'centos' => ['color' => '#262577', 'icon' => 'centos'],
                            'debian' => ['color' => '#A81D33', 'icon' => 'debian'],
                            'fedora' => ['color' => '#51A2DA', 'icon' => 'fedora'],
                            'fedora-coreos' => ['color' => '#51A2DA', 'icon' => 'fedora'],
                            'almalinux' => ['color' => '#000000', 'icon' => 'almalinux'],
                            'rockylinux' => ['color' => '#10B981', 'icon' => 'rockylinux'],
                            'rocky' => ['color' => '#10B981', 'icon' => 'rockylinux'],
                            'windows' => ['color' => '#0078D4', 'icon' => 'windows'],
                            'archlinux' => ['color' => '#1793D1', 'icon' => 'archlinux'],
                            'arch' => ['color' => '#1793D1', 'icon' => 'archlinux'],
                            'opensuse' => ['color' => '#73BA25', 'icon' => 'opensuse'],
                            'freebsd' => ['color' => '#AB2B28', 'icon' => 'freebsd'],
                            'openbsd' => ['color' => '#F2CA30', 'icon' => 'openbsd'],
                            'alpinelinux' => ['color' => '#0D597F', 'icon' => 'alpinelinux'],
                            'flatcar' => ['color' => '#4C96D7', 'icon' => 'flatcar'],
                        ];
                        
                        $config = $familyConfig[$family] ?? ['color' => '#6B7280', 'icon' => null];
                    @endphp
                    
                    <div 
                        class="group relative bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 border-2 border-transparent hover:border-blue-500 hover:-translate-y-2 cursor-pointer overflow-hidden"
                        x-show="showAll || {{ $index }} < {{ $initialShow }}"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        style="{{ $index >= $initialShow ? 'display: none;' : '' }}"
                    >
                        <!-- Gradient Background on Hover -->
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        <div class="relative flex flex-col items-center text-center">
                            <!-- OS Icon from Simple Icons CDN -->
                            <div class="w-20 h-20 mb-4 flex items-center justify-center rounded-xl shadow-md group-hover:shadow-xl transition-all duration-300 transform group-hover:scale-110 bg-white p-3">
                                @if($config['icon'])
                                    @if($family === 'windows')
                                        <!-- Custom Windows SVG Logo -->
                                        <svg class="w-full h-full" viewBox="0 0 88 88" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0 12.402L35.687 7.162V42.43H0V12.402Z" fill="#0078D4"/>
                                            <path d="M40.234 6.567L88 0V41.896H40.234V6.567Z" fill="#0078D4"/>
                                            <path d="M0 45.563H35.687V80.831L0 75.591V45.563Z" fill="#0078D4"/>
                                            <path d="M40.234 46.158H88V88L40.234 81.433V46.158Z" fill="#0078D4"/>
                                        </svg>
                                    @else
                                        <!-- Simple Icons CDN for other OS -->
                                        <img 
                                            src="https://cdn.simpleicons.org/{{ $config['icon'] }}/{{ ltrim($config['color'], '#') }}" 
                                            alt="{{ $os['name'] }}" 
                                            class="w-full h-full object-contain"
                                            loading="lazy"
                                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                        >
                                        <!-- Fallback if icon fails to load -->
                                        <div class="w-full h-full rounded-lg hidden items-center justify-center text-white font-bold text-xl" style="display:none; background: linear-gradient(135deg, {{ $config['color'] }} 0%, {{ $config['color'] }}dd 100%);">
                                            {{ strtoupper(substr($os['name'], 0, 2)) }}
                                        </div>
                                    @endif
                                @else
                                    <!-- Fallback for unknown OS -->
                                    <div class="w-full h-full rounded-lg flex items-center justify-center text-white font-bold text-xl" style="background: linear-gradient(135deg, {{ $config['color'] }} 0%, {{ $config['color'] }}dd 100%);">
                                        {{ strtoupper(substr($os['name'], 0, 2)) }}
                                    </div>
                                @endif
                            </div>
                            
                            <!-- OS Name -->
                            <h3 class="text-base font-bold text-gray-900 group-hover:text-blue-600 transition-colors mb-2 leading-tight px-2">
                                {{ $os['name'] }}
                            </h3>
                            
                            <!-- OS Architecture -->
                            <div class="flex gap-2 flex-wrap justify-center">
                                @if(!empty($os['arch']))
                                    <span class="inline-block px-2 py-1 bg-gray-100 group-hover:bg-blue-100 text-gray-600 group-hover:text-blue-700 text-xs rounded-full font-medium transition-colors">
                                        {{ strtoupper($os['arch']) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Show More Button -->
            @if($totalOS > $initialShow)
                <div class="mt-12 text-center" x-show="!showAll">
                    <button 
                        @click="showAll = true"
                        class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105"
                    >
                        <span>{{ __('frontend.show_more_os') }}</span>
                        <span class="px-2 py-0.5 bg-white/20 rounded-full text-sm">+{{ $totalOS - $initialShow }}</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>

                <!-- Show Less Button -->
                <div class="mt-12 text-center" x-show="showAll" x-cloak>
                    <button 
                        @click="showAll = false; window.scrollTo({top: document.querySelector('#operating-systems-section').offsetTop - 100, behavior: 'smooth'})"
                        class="inline-flex items-center gap-3 px-8 py-4 bg-gray-600 text-white font-bold rounded-xl hover:bg-gray-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105"
                    >
                        <span>{{ __('frontend.show_less_os') }}</span>
                        <svg class="w-5 h-5 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>
            @endif
        @else
            <!-- Fallback: Static OS List if API fails -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                <!-- Ubuntu -->
                <div class="group relative bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 border-2 border-transparent hover:border-orange-500 hover:-translate-y-2 cursor-pointer">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-20 h-20 mb-4 flex items-center justify-center">
                            <div class="w-16 h-16 rounded-lg bg-orange-500 flex items-center justify-center text-white font-bold text-xl">
                                UB
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-orange-500 transition-colors">Ubuntu</h3>
                        <p class="text-sm text-gray-500 mt-1">Linux</p>
                    </div>
                </div>

                <!-- CentOS -->
                <div class="group relative bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 border-2 border-transparent hover:border-purple-500 hover:-translate-y-2 cursor-pointer">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-20 h-20 mb-4 flex items-center justify-center">
                            <div class="w-16 h-16 rounded-lg bg-purple-500 flex items-center justify-center text-white font-bold text-xl">
                                CE
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-purple-500 transition-colors">CentOS</h3>
                        <p class="text-sm text-gray-500 mt-1">Linux</p>
                    </div>
                </div>

                <!-- Debian -->
                <div class="group relative bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 border-2 border-transparent hover:border-red-500 hover:-translate-y-2 cursor-pointer">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-20 h-20 mb-4 flex items-center justify-center">
                            <div class="w-16 h-16 rounded-lg bg-red-500 flex items-center justify-center text-white font-bold text-xl">
                                DE
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-red-500 transition-colors">Debian</h3>
                        <p class="text-sm text-gray-500 mt-1">Linux</p>
                    </div>
                </div>

                <!-- Fedora -->
                <div class="group relative bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 border-2 border-transparent hover:border-blue-500 hover:-translate-y-2 cursor-pointer">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-20 h-20 mb-4 flex items-center justify-center">
                            <div class="w-16 h-16 rounded-lg bg-blue-500 flex items-center justify-center text-white font-bold text-xl">
                                FE
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-500 transition-colors">Fedora</h3>
                        <p class="text-sm text-gray-500 mt-1">Linux</p>
                    </div>
                </div>

                <!-- Windows -->
                <div class="group relative bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 border-2 border-transparent hover:border-blue-600 hover:-translate-y-2 cursor-pointer">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-20 h-20 mb-4 flex items-center justify-center">
                            <div class="w-16 h-16 rounded-lg bg-blue-600 flex items-center justify-center text-white font-bold text-xl">
                                WIN
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors">Windows Server</h3>
                        <p class="text-sm text-gray-500 mt-1">Windows</p>
                    </div>
                </div>

                <!-- FreeBSD -->
                <div class="group relative bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 border-2 border-transparent hover:border-red-600 hover:-translate-y-2 cursor-pointer">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-20 h-20 mb-4 flex items-center justify-center">
                            <div class="w-16 h-16 rounded-lg bg-red-600 flex items-center justify-center text-white font-bold text-xl">
                                BSD
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-red-600 transition-colors">FreeBSD</h3>
                        <p class="text-sm text-gray-500 mt-1">BSD</p>
                    </div>
                </div>
            </div>
        @endif

    </div>
</section>

<!-- Marketplace Apps Section -->
<section id="marketplace-apps-section" class="py-24 bg-gradient-to-b from-gray-50 to-white" x-data="{ showAllApps: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-16">
            <div class="inline-block px-4 py-2 bg-purple-100 text-purple-600 rounded-full text-sm font-semibold mb-6">
                {{ __('frontend.marketplace_apps') }}
            </div>
            <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-6">
                {{ __('frontend.one_click_apps') }}
            </h2>
            <p class="text-xl text-gray-600 leading-relaxed">
                {{ __('frontend.marketplace_description') }}
            </p>
        </div>

        @if(!empty($marketplaceApps) && count($marketplaceApps) > 0)
            @php
                $totalApps = count($marketplaceApps);
                $initialShowApps = 12;
            @endphp

            <!-- Apps Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-6">
                @foreach($marketplaceApps as $index => $app)
                    @php
                        // Clean app name for icon matching
                        $appNameLower = strtolower($app['short_name'] ?? $app['name']);
                        $appNameClean = str_replace([' ', '_', '-'], '', $appNameLower);
                        
                        // Icon and color mapping for Simple Icons
                        $appConfig = [
                            'wordpress' => ['icon' => 'wordpress', 'color' => '#21759B'],
                            'docker' => ['icon' => 'docker', 'color' => '#2496ED'],
                            'cpanel' => ['icon' => 'cpanel', 'color' => '#FF6C2C'],
                            'plesk' => ['icon' => 'plesk', 'color' => '#52BBE6'],
                            'mysql' => ['icon' => 'mysql', 'color' => '#4479A1'],
                            'mariadb' => ['icon' => 'mariadb', 'color' => '#003545'],
                            'mongodb' => ['icon' => 'mongodb', 'color' => '#47A248'],
                            'postgresql' => ['icon' => 'postgresql', 'color' => '#4169E1'],
                            'nginx' => ['icon' => 'nginx', 'color' => '#009639'],
                            'apache' => ['icon' => 'apache', 'color' => '#D22128'],
                            'nodejs' => ['icon' => 'nodedotjs', 'color' => '#339933'],
                            'node' => ['icon' => 'nodedotjs', 'color' => '#339933'],
                            'ruby' => ['icon' => 'ruby', 'color' => '#CC342D'],
                            'rails' => ['icon' => 'rubyonrails', 'color' => '#CC0000'],
                            'python' => ['icon' => 'python', 'color' => '#3776AB'],
                            'php' => ['icon' => 'php', 'color' => '#777BB4'],
                            'laravel' => ['icon' => 'laravel', 'color' => '#FF2D20'],
                            'django' => ['icon' => 'django', 'color' => '#092E20'],
                            'nextcloud' => ['icon' => 'nextcloud', 'color' => '#0082C9'],
                            'gitlab' => ['icon' => 'gitlab', 'color' => '#FC6D26'],
                            'github' => ['icon' => 'github', 'color' => '#181717'],
                            'jenkins' => ['icon' => 'jenkins', 'color' => '#D24939'],
                            'redis' => ['icon' => 'redis', 'color' => '#DC382D'],
                            'elasticsearch' => ['icon' => 'elasticsearch', 'color' => '#005571'],
                            'magento' => ['icon' => 'shopify', 'color' => '#EE672F'],
                            'prestashop' => ['icon' => 'prestashop', 'color' => '#DF0067'],
                            'opencart' => ['icon' => 'opencart', 'color' => '#29ABE2'],
                            'joomla' => ['icon' => 'joomla', 'color' => '#5091CD'],
                            'drupal' => ['icon' => 'drupal', 'color' => '#0678BE'],
                            'moodle' => ['icon' => 'moodle', 'color' => '#F98012'],
                            'odoo' => ['icon' => 'odoo', 'color' => '#714B67'],
                            'rabbitmq' => ['icon' => 'rabbitmq', 'color' => '#FF6600'],
                            'grafana' => ['icon' => 'grafana', 'color' => '#F46800'],
                            'prometheus' => ['icon' => 'prometheus', 'color' => '#E6522C'],
                            'kubernetes' => ['icon' => 'kubernetes', 'color' => '#326CE5'],
                            'terraform' => ['icon' => 'terraform', 'color' => '#7B42BC'],
                            'ansible' => ['icon' => 'ansible', 'color' => '#EE0000'],
                            'openvpn' => ['icon' => 'openvpn', 'color' => '#EA7E20'],
                            'wireguard' => ['icon' => 'wireguard', 'color' => '#88171A'],
                            'discourse' => ['icon' => 'discourse', 'color' => '#000000'],
                            'mattermost' => ['icon' => 'mattermost', 'color' => '#0058CC'],
                            'rocketchat' => ['icon' => 'rocketdotchat', 'color' => '#F5455C'],
                            'ghost' => ['icon' => 'ghost', 'color' => '#15171A'],
                            'mediawiki' => ['icon' => 'mediawiki', 'color' => '#000000'],
                            'owncloud' => ['icon' => 'owncloud', 'color' => '#1D2D44'],
                            'seafile' => ['icon' => 'seafile', 'color' => '#00A4CC'],
                            'plex' => ['icon' => 'plex', 'color' => '#E5A00D'],
                            'emby' => ['icon' => 'emby', 'color' => '#52B54B'],
                            'minecraft' => ['icon' => 'minecraft', 'color' => '#62B47A'],
                            'teamspeak' => ['icon' => 'teamspeak', 'color' => '#2580C3'],
                            // Additional apps
                            'bitnami' => ['icon' => null, 'color' => '#FF6600'],
                            'antmedia' => ['icon' => null, 'color' => '#E91E63'],
                            'cyberpanel' => ['icon' => null, 'color' => '#00BCD4'],
                            'cloudpanel' => ['icon' => null, 'color' => '#2196F3'],
                            'cloudhub' => ['icon' => null, 'color' => '#9C27B0'],
                            'cloudron' => ['icon' => null, 'color' => '#4CAF50'],
                            'clustercontrol' => ['icon' => null, 'color' => '#607D8B'],
                            'azuracast' => ['icon' => null, 'color' => '#2979FF'],
                            'botguard' => ['icon' => null, 'color' => '#795548'],
                            'browserbox' => ['icon' => null, 'color' => '#FF9800'],
                            'bun' => ['icon' => 'bun', 'color' => '#000000'],
                            'serverwand' => ['icon' => null, 'color' => '#3F51B5'],
                            'openlitespeed' => ['icon' => 'litespeed', 'color' => '#2EA3F2'],
                            'litespeed' => ['icon' => 'litespeed', 'color' => '#2EA3F2'],
                            'onlyoffice' => ['icon' => null, 'color' => '#FF6F3D'],
                            'asp.net' => ['icon' => 'dotnet', 'color' => '#512BD4'],
                            'dotnet' => ['icon' => 'dotnet', 'color' => '#512BD4'],
                        ];
                        
                        // Try to match app icon
                        $config = null;
                        foreach ($appConfig as $key => $value) {
                            if (str_contains($appNameLower, $key)) {
                                $config = $value;
                                break;
                            }
                        }
                        
                        // Default colors based on first letter if no match found
                        if (!$config) {
                            $firstLetter = strtoupper(substr($app['name'], 0, 1));
                            $colorMap = [
                                'A' => '#EF4444', 'B' => '#F59E0B', 'C' => '#10B981', 'D' => '#3B82F6',
                                'E' => '#8B5CF6', 'F' => '#EC4899', 'G' => '#14B8A6', 'H' => '#F97316',
                                'I' => '#6366F1', 'J' => '#84CC16', 'K' => '#06B6D4', 'L' => '#A855F7',
                                'M' => '#EF4444', 'N' => '#F59E0B', 'O' => '#10B981', 'P' => '#3B82F6',
                                'Q' => '#8B5CF6', 'R' => '#EC4899', 'S' => '#14B8A6', 'T' => '#F97316',
                                'U' => '#6366F1', 'V' => '#84CC16', 'W' => '#06B6D4', 'X' => '#A855F7',
                                'Y' => '#EF4444', 'Z' => '#F59E0B', '3' => '#3B82F6',
                            ];
                            $config = ['icon' => null, 'color' => $colorMap[$firstLetter] ?? '#6366F1'];
                        }
                    @endphp
                    
                    <div 
                        class="group relative bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 border-2 border-transparent hover:border-purple-500 hover:-translate-y-2 cursor-pointer overflow-hidden"
                        x-show="showAllApps || {{ $index }} < {{ $initialShowApps }}"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        style="{{ $index >= $initialShowApps ? 'display: none;' : '' }}"
                    >
                        <!-- Gradient Background on Hover -->
                        <div class="absolute inset-0 bg-gradient-to-br from-purple-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        <div class="relative flex flex-col items-center text-center">
                            <!-- App Icon from Simple Icons CDN -->
                            <div class="w-20 h-20 mb-4 flex items-center justify-center rounded-xl shadow-md group-hover:shadow-xl transition-all duration-300 transform group-hover:scale-110 bg-gradient-to-br from-gray-50 to-white p-3 relative overflow-hidden">
                                @if($config['icon'])
                                    <img 
                                        src="https://cdn.simpleicons.org/{{ $config['icon'] }}/{{ ltrim($config['color'], '#') }}" 
                                        alt="{{ $app['name'] }}" 
                                        class="w-full h-full object-contain relative z-10"
                                        loading="lazy"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                    >
                                    <!-- Fallback if icon fails to load -->
                                    <div class="w-full h-full rounded-lg hidden items-center justify-center relative z-10" style="display:none; background: linear-gradient(135deg, {{ $config['color'] }} 0%, {{ $config['color'] }}dd 100%);">
                                        <div class="text-center">
                                            <svg class="w-8 h-8 text-white mx-auto mb-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                            </svg>
                                            <span class="text-white font-bold text-xs">{{ strtoupper(substr($app['name'], 0, 2)) }}</span>
                                        </div>
                                    </div>
                                @else
                                    <!-- Fallback for apps without icon -->
                                    <div class="w-full h-full rounded-lg flex flex-col items-center justify-center relative z-10" style="background: linear-gradient(135deg, {{ $config['color'] }} 0%, {{ $config['color'] }}dd 100%);">
                                        <!-- App Icon SVG -->
                                        <svg class="w-8 h-8 text-white mb-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                        </svg>
                                        <span class="text-white font-bold text-xs">{{ strtoupper(substr($app['name'], 0, 2)) }}</span>
                                    </div>
                                @endif
                                <!-- Decorative Pattern -->
                                <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(circle at 2px 2px, {{ $config['color'] }} 1px, transparent 0); background-size: 8px 8px;"></div>
                            </div>
                            
                            <!-- App Name -->
                            <h3 class="text-base font-bold text-gray-900 group-hover:text-purple-600 transition-colors mb-2 leading-tight px-2">
                                {{ $app['name'] }}
                            </h3>
                            
                            <!-- App Type/Vendor -->
                            @if(!empty($app['vendor']) && $app['vendor'] !== 'vultr' && $app['vendor'] !== 'Pro Gineous')
                                <p class="text-xs text-gray-500 mb-2">{{ $app['vendor'] }}</p>
                            @elseif(!empty($app['type']))
                                <p class="text-xs text-gray-500 mb-2">{{ ucfirst($app['type']) }}</p>
                            @endif
                            
                            <!-- One-Click Badge -->
                            <span class="inline-block px-2 py-1 bg-purple-100 group-hover:bg-purple-200 text-purple-600 group-hover:text-purple-700 text-xs rounded-full font-medium transition-colors">
                                {{ __('frontend.one_click') }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Show More Button -->
            @if($totalApps > $initialShowApps)
                <div class="mt-12 text-center" x-show="!showAllApps">
                    <button 
                        @click="showAllApps = true"
                        class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-purple-600 to-purple-700 text-white font-bold rounded-xl hover:from-purple-700 hover:to-purple-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105"
                    >
                        <span>{{ __('frontend.show_more_apps') }}</span>
                        <span class="px-2 py-0.5 bg-white/20 rounded-full text-sm">+{{ $totalApps - $initialShowApps }}</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>

                <!-- Show Less Button -->
                <div class="mt-12 text-center" x-show="showAllApps" x-cloak>
                    <button 
                        @click="showAllApps = false; window.scrollTo({top: document.querySelector('#marketplace-apps-section').offsetTop - 100, behavior: 'smooth'})"
                        class="inline-flex items-center gap-3 px-8 py-4 bg-gray-600 text-white font-bold rounded-xl hover:bg-gray-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105"
                    >
                        <span>{{ __('frontend.show_less_apps') }}</span>
                        <svg class="w-5 h-5 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>
            @endif
        @else
            <!-- No Apps Message -->
            <div class="text-center py-12">
                <div class="inline-flex items-center gap-3 px-6 py-4 bg-gray-100 rounded-2xl">
                    <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <p class="text-gray-600 font-medium">{{ __('frontend.no_apps_available') }}</p>
                </div>
            </div>
        @endif

        <!-- Additional Info -->
        <div class="mt-16 text-center">
            <div class="inline-flex items-center gap-3 px-6 py-4 bg-purple-50 border-2 border-purple-200 rounded-2xl">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                <p class="text-gray-700 font-medium">
                    {{ __('frontend.apps_note') }}
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Global Data Centers Map Section -->
<section id="datacenters-section" class="py-24 bg-gradient-to-b from-white to-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-16">
            <div class="inline-block px-4 py-2 bg-green-100 text-green-600 rounded-full text-sm font-semibold mb-6">
                {{ __('frontend.global_network') }}
            </div>
            <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-6">
                {{ __('frontend.worldwide_datacenters') }}
            </h2>
            <p class="text-xl text-gray-600 leading-relaxed">
                {{ __('frontend.datacenters_description') }}
            </p>
        </div>

        @if(!empty($datacenters) && count($datacenters) > 0)
            <!-- Map Container -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-200 mb-12">
                <div id="datacenters-map" class="w-full h-[600px] relative">
                    <!-- Loading indicator -->
                    <div class="absolute inset-0 flex items-center justify-center bg-gray-50">
                        <div class="text-center">
                            <svg class="animate-spin h-12 w-12 text-blue-600 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <p class="text-gray-600 font-medium">{{ __('frontend.loading_map') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Centers Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($datacenters as $datacenter)
                    <div class="group bg-white rounded-xl p-6 shadow-md hover:shadow-2xl transition-all duration-300 border-2 border-transparent hover:border-green-500 cursor-pointer transform hover:-translate-y-1"
                         data-lat="{{ $datacenter['lat'] ?? 0 }}"
                         data-lon="{{ $datacenter['lon'] ?? 0 }}"
                         data-city="{{ $datacenter['city'] ?? '' }}"
                         onclick="focusDatacenter({{ $datacenter['lat'] ?? 0 }}, {{ $datacenter['lon'] ?? 0 }}, '{{ $datacenter['city'] ?? '' }}', '{{ $datacenter['country'] ?? '' }}')">
                        
                        <!-- Location Icon -->
                        <div class="flex items-start gap-4 mb-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-green-500/50 transition-all duration-300 group-hover:scale-110">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-bold text-gray-900 group-hover:text-green-600 transition-colors mb-1 truncate">
                                    {{ $datacenter['city'] ?? 'Unknown' }}
                                </h3>
                                <p class="text-sm text-gray-500 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $datacenter['country'] ?? 'Unknown' }}
                                </p>
                            </div>
                        </div>

                        <!-- Datacenter Info -->
                        <div class="space-y-2 pt-4 border-t border-gray-100">
                            @if(!empty($datacenter['continent']))
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-500">{{ __('frontend.continent') }}</span>
                                    <span class="font-semibold text-gray-900">{{ $datacenter['continent'] }}</span>
                                </div>
                            @endif
                            
                            @if(!empty($datacenter['id']))
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-500">{{ __('frontend.region_code') }}</span>
                                    <span class="font-mono text-xs bg-gray-100 px-2 py-1 rounded text-gray-900">{{ strtoupper($datacenter['id']) }}</span>
                                </div>
                            @endif

                            <!-- Available Badge -->
                            <div class="pt-2">
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ __('frontend.available') }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Map Statistics -->
            <div class="mt-12 grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="text-center p-6 bg-white rounded-2xl shadow-md">
                    <div class="text-4xl font-bold text-blue-600 mb-2">{{ count($datacenters) }}+</div>
                    <div class="text-gray-600 font-medium">{{ __('frontend.data_centers') }}</div>
                </div>
                <div class="text-center p-6 bg-white rounded-2xl shadow-md">
                    <div class="text-4xl font-bold text-green-600 mb-2">{{ collect($datacenters)->unique('continent')->count() }}+</div>
                    <div class="text-gray-600 font-medium">{{ __('frontend.continents') }}</div>
                </div>
                <div class="text-center p-6 bg-white rounded-2xl shadow-md">
                    <div class="text-4xl font-bold text-purple-600 mb-2">{{ collect($datacenters)->unique('country')->count() }}+</div>
                    <div class="text-gray-600 font-medium">{{ __('frontend.countries') }}</div>
                </div>
                <div class="text-center p-6 bg-white rounded-2xl shadow-md">
                    <div class="text-4xl font-bold text-orange-600 mb-2">99.9%</div>
                    <div class="text-gray-600 font-medium">{{ __('frontend.uptime_sla') }}</div>
                </div>
            </div>
        @else
            <!-- No Datacenters Message -->
            <div class="text-center py-12">
                <p class="text-gray-600 text-lg">{{ __('frontend.no_datacenters_available') }}</p>
            </div>
        @endif
    </div>
</section>

<!-- Three.js Advanced 3D Globe -->
@if(!empty($datacenters) && count($datacenters) > 0)
<script type="importmap">
{
  "imports": {
    "three": "https://unpkg.com/three@0.160.0/build/three.module.js",
    "three/addons/": "https://unpkg.com/three@0.160.0/examples/jsm/"
  }
}
</script>

<!-- Globe.gl Library - Realistic 3D Earth -->
<script src="//unpkg.com/three@0.160.0"></script>
<script src="//unpkg.com/globe.gl@2.32.1"></script>

<script>
    (function() {
        let globe;
        const datacenters = @json($datacenters);
        
        window.initMap = function() {
            try {
                const container = document.getElementById('datacenters-map');
                if (!container) return;
                
                // Remove loading indicator
                const loadingDiv = container.querySelector('div');
                if (loadingDiv) loadingDiv.remove();
                
                // Initialize Globe.gl with realistic Earth
                globe = Globe()(container)
                    // Earth textures - realistic satellite images
                    .globeImageUrl('//unpkg.com/three-globe@2.31.0/example/img/earth-blue-marble.jpg')
                    .bumpImageUrl('//unpkg.com/three-globe@2.31.0/example/img/earth-topology.png')
                    .backgroundImageUrl('//unpkg.com/three-globe@2.31.0/example/img/night-sky.png')
                    
                    // Camera settings
                    .width(container.offsetWidth)
                    .height(600)
                    
                    // Atmosphere
                    .atmosphereColor('lightskyblue')
                    .atmosphereAltitude(0.25)
                    
                    // Controls
                    .enablePointerInteraction(true);
                
                // Add datacenter points with logo images
                const pointsData = datacenters.filter(dc => dc.lat && dc.lon).map(dc => ({
                    lat: parseFloat(dc.lat),
                    lng: parseFloat(dc.lon),
                    size: 1.5,
                    label: `${dc.city}, ${dc.country}`,
                    city: dc.city,
                    country: dc.country
                }));
                
                // Add Egypt to the map
                pointsData.push({
                    lat: 30.0444,
                    lng: 31.2357,
                    size: 1.5,
                    label: 'Cairo, Egypt',
                    city: 'Cairo',
                    country: 'Egypt'
                });
                
                console.log('Creating markers for', pointsData.length, 'datacenters');
                
                // Use HTML elements for custom logo markers
                globe.htmlElementsData(pointsData)
                    .htmlElement(d => {
                        const el = document.createElement('div');
                        el.className = 'globe-marker';
                        el.style.pointerEvents = 'auto';
                        el.style.cursor = 'pointer';
                        el.style.userSelect = 'none';
                        
                        const img = document.createElement('img');
                        img.src = '{{ asset("logo/pro Gineous_white logo.svg") }}';
                        img.style.width = '48px';
                        img.style.height = '16px';
                        img.style.filter = 'drop-shadow(0 0 8px rgba(255,255,255,0.9))';
                        img.style.transform = 'translateZ(0)';
                        img.onerror = function() {
                            console.error('Failed to load logo for', d.city);
                            // Fallback to circle
                            this.style.display = 'none';
                            el.innerHTML = '<div style="width: 16px; height: 16px; background: #ffcc00; border-radius: 50%; border: 2px solid white; box-shadow: 0 0 10px rgba(255,204,0,0.8);"></div>';
                        };
                        img.onload = function() {
                            console.log('Logo loaded for', d.city);
                        };
                        
                        el.appendChild(img);
                        
                        // Add click event
                        el.onclick = () => {
                            alert(`📍 ${d.city}, ${d.country}`);
                        };
                        
                        // Add hover tooltip
                        el.title = `${d.city}, ${d.country}`;
                        
                        return el;
                    })
                    .htmlAltitude(0.015);
                
                // Add fewer arcs between datacenters (only connect nearby ones)
                const arcsData = [];
                for (let i = 0; i < pointsData.length; i++) {
                    // Only connect to the next datacenter (not all of them)
                    const j = (i + 1) % pointsData.length;
                    arcsData.push({
                        startLat: pointsData[i].lat,
                        startLng: pointsData[i].lng,
                        endLat: pointsData[j].lat,
                        endLng: pointsData[j].lng,
                        color: ['rgba(0, 200, 255, 0.2)', 'rgba(0, 255, 200, 0.2)']
                    });
                }
                
                globe.arcsData(arcsData)
                    .arcColor('color')
                    .arcDashLength(0.4)
                    .arcDashGap(0.2)
                    .arcDashAnimateTime(3000)
                    .arcStroke(0.5);
                
                // Add company logo behind the globe
                const logoImg = document.createElement('img');
                logoImg.src = '{{ asset("logo/pro Gineous_white logo.svg") }}';
                logoImg.style.position = 'absolute';
                logoImg.style.top = '50%';
                logoImg.style.left = '50%';
                logoImg.style.transform = 'translate(-50%, -50%)';
                logoImg.style.width = '800px';
                logoImg.style.height = 'auto';
                logoImg.style.opacity = '0.7';
                logoImg.style.zIndex = '0';
                logoImg.style.pointerEvents = 'none';
                container.style.position = 'relative';
                container.insertBefore(logoImg, container.firstChild);
                
                // Auto-rotate
                globe.controls().autoRotate = true;
                globe.controls().autoRotateSpeed = 0.5;
                
                // Handle window resize
                window.addEventListener('resize', () => {
                    if (globe && container) {
                        globe.width(container.offsetWidth);
                    }
                });
                
                // Focus on specific datacenter function
                window.focusDatacenter = function(lat, lon, city, country) {
                    if (globe) {
                        globe.pointOfView({
                            lat: parseFloat(lat),
                            lng: parseFloat(lon),
                            altitude: 1.5
                        }, 1000);
                    }
                };
                
                console.log('Globe.gl initialized successfully with', pointsData.length, 'datacenters');
                
            } catch (error) {
                console.error('Error initializing Globe.gl:', error);
            }
        };
        
        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', window.initMap);
        } else {
            window.initMap();
        }
    })();
</script>
@endif

<!-- Equipped for Every Project Section - Split Screen Asymmetrical Design -->
<section class="relative py-32 overflow-hidden bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900">
    <!-- Animated Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>

    <!-- Large Decorative Circles -->
    <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-gradient-to-br from-blue-500/20 to-purple-500/20 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/3"></div>
    <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-gradient-to-tr from-purple-500/20 to-pink-500/20 rounded-full blur-3xl transform -translate-x-1/3 translate-y-1/3"></div>

    <div class="relative max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Split Screen Container -->
        <div class="grid lg:grid-cols-12 gap-12 items-center">
            
            <!-- LEFT SIDE - Content (40%) -->
            <div class="lg:col-span-5 z-10">
                <!-- Badge -->
                <div class="inline-flex items-center px-6 py-3 rounded-full bg-gradient-to-r from-blue-500/20 to-purple-500/20 border border-blue-400/30 backdrop-blur-md mb-8 transform hover:scale-105 transition-all">
                    <svg class="w-5 h-5 ltr:mr-3 rtl:ml-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span class="text-white font-semibold text-sm tracking-wide">{{ __('frontend.powerful_solutions') }}</span>
                </div>

                <!-- Main Heading with Visual Hierarchy -->
                <h2 class="text-5xl sm:text-6xl lg:text-7xl font-black mb-8 leading-tight">
                    <span class="block text-white">{{ __('frontend.equipped_for_every_project') }}</span>
                </h2>

                <!-- Description -->
                <p class="text-xl text-gray-300 leading-relaxed mb-10 max-w-xl">
                    {{ __('frontend.equipped_for_every_project_desc') }}
                </p>

                <!-- Stats/Features - Overlapping Elements -->
                <div class="grid grid-cols-2 gap-6 mb-10">
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 hover:bg-white/20 transition-all transform hover:-translate-y-1">
                        <div class="text-4xl font-black text-blue-400 mb-2">24/7</div>
                        <div class="text-sm text-gray-300 font-medium">{{ __('frontend.full_support') }}</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 hover:bg-white/20 transition-all transform hover:-translate-y-1">
                        <div class="text-4xl font-black text-purple-400 mb-2">99.9%</div>
                        <div class="text-sm text-gray-300 font-medium">{{ __('frontend.uptime_guarantee') }}</div>
                    </div>
                </div>

                <!-- CTA Button -->
                <a href="#plans" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold rounded-xl shadow-2xl shadow-blue-500/50 hover:shadow-purple-500/50 transform hover:scale-105 transition-all duration-300">
                    <span>{{ __('frontend.explore_plans') }}</span>
                    <svg class="w-5 h-5 ltr:ml-3 rtl:mr-3 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>

            <!-- RIGHT SIDE - Overlapping Cards (60%) -->
            <div class="lg:col-span-7 relative">
                
                <!-- Card Container with Asymmetrical Positioning -->
                <div class="relative h-[800px]">
                    
                    <!-- Card 1: AI/LLM - Top Left, Largest -->
                    <div class="absolute top-0 left-0 w-[350px] z-40 group cursor-pointer hover:z-[100] active:z-[100]">
                        <div class="relative">
                            <!-- Glow Effect -->
                            <div class="absolute -inset-4 bg-gradient-to-br from-purple-500/50 to-purple-600/50 rounded-3xl blur-2xl opacity-0 group-hover:opacity-75 transition-all duration-500"></div>
                            
                            <!-- Card Content -->
                            <div class="relative bg-gradient-to-br from-slate-800/90 to-slate-900/90 backdrop-blur-xl rounded-3xl p-8 border-2 border-purple-500/30 shadow-2xl transform group-hover:scale-105 group-hover:-rotate-2 group-active:scale-105 group-active:-rotate-2 transition-all duration-500">
                                <!-- Number Badge -->
                                <div class="absolute -top-4 -right-4 w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center text-white font-black text-xl shadow-xl transform rotate-12 group-hover:rotate-0 transition-all">
                                    01
                                </div>
                                
                                <!-- Icon -->
                                <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-purple-500/50 transform group-hover:rotate-12 transition-all">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                    </svg>
                                </div>
                                
                                <h3 class="text-2xl font-black text-white mb-4">{{ __('frontend.ai_llm_apps') }}</h3>
                                <p class="text-gray-300 text-sm leading-relaxed">{{ __('frontend.ai_llm_apps_desc') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Web Apps - Top Right, Medium -->
                    <div class="absolute top-16 right-0 w-[320px] z-30 group cursor-pointer hover:z-[100] active:z-[100]">
                        <div class="relative">
                            <div class="absolute -inset-4 bg-gradient-to-br from-blue-500/50 to-blue-600/50 rounded-3xl blur-2xl opacity-0 group-hover:opacity-75 transition-all duration-500"></div>
                            <div class="relative bg-gradient-to-br from-slate-800/90 to-slate-900/90 backdrop-blur-xl rounded-3xl p-8 border-2 border-blue-500/30 shadow-2xl transform group-hover:scale-105 group-hover:rotate-2 group-active:scale-105 group-active:rotate-2 transition-all duration-500">
                                <div class="absolute -top-4 -right-4 w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center text-white font-black text-xl shadow-xl transform rotate-12 group-hover:rotate-0 transition-all">
                                    02
                                </div>
                                <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-blue-500/50 transform group-hover:rotate-12 transition-all">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-black text-white mb-4">{{ __('frontend.web_apps') }}</h3>
                                <p class="text-gray-300 text-sm leading-relaxed">{{ __('frontend.web_apps_desc') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: Open Source - Bottom Left, Medium -->
                    <div class="absolute bottom-32 left-16 w-[320px] z-20 group cursor-pointer hover:z-[100] active:z-[100]">
                        <div class="relative">
                            <div class="absolute -inset-4 bg-gradient-to-br from-green-500/50 to-green-600/50 rounded-3xl blur-2xl opacity-0 group-hover:opacity-75 transition-all duration-500"></div>
                            <div class="relative bg-gradient-to-br from-slate-800/90 to-slate-900/90 backdrop-blur-xl rounded-3xl p-8 border-2 border-green-500/30 shadow-2xl transform group-hover:scale-105 group-hover:-rotate-2 group-active:scale-105 group-active:-rotate-2 transition-all duration-500">
                                <div class="absolute -top-4 -right-4 w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center text-white font-black text-xl shadow-xl transform rotate-12 group-hover:rotate-0 transition-all">
                                    03
                                </div>
                                <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-green-500/50 transform group-hover:rotate-12 transition-all">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-black text-white mb-4">{{ __('frontend.open_source_apps') }}</h3>
                                <p class="text-gray-300 text-sm leading-relaxed">{{ __('frontend.open_source_apps_desc') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4: Ecommerce - Bottom Right, Smaller -->
                    <div class="absolute bottom-0 right-12 w-[300px] z-10 group cursor-pointer hover:z-[100] active:z-[100]">
                        <div class="relative">
                            <div class="absolute -inset-4 bg-gradient-to-br from-orange-500/50 to-orange-600/50 rounded-3xl blur-2xl opacity-0 group-hover:opacity-75 transition-all duration-500"></div>
                            <div class="relative bg-gradient-to-br from-slate-800/90 to-slate-900/90 backdrop-blur-xl rounded-3xl p-8 border-2 border-orange-500/30 shadow-2xl transform group-hover:scale-105 group-hover:rotate-2 group-active:scale-105 group-active:rotate-2 transition-all duration-500">
                                <div class="absolute -top-4 -right-4 w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center text-white font-black text-xl shadow-xl transform rotate-12 group-hover:rotate-0 transition-all">
                                    04
                                </div>
                                <div class="w-20 h-20 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-orange-500/50 transform group-hover:rotate-12 transition-all">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-black text-white mb-4">{{ __('frontend.high_traffic_ecommerce') }}</h3>
                                <p class="text-gray-300 text-sm leading-relaxed">{{ __('frontend.high_traffic_ecommerce_desc') }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- VPS Management Made Easy Section -->
<section class="relative py-32 overflow-hidden bg-white">
    <!-- Decorative Background -->
    <div class="absolute inset-0 bg-gradient-to-br from-blue-50/50 via-white to-purple-50/50"></div>
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-400/5 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-400/5 rounded-full blur-3xl"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center mb-20">
            <div class="inline-block mb-6">
                <span class="inline-flex items-center px-5 py-2 rounded-full bg-gradient-to-r from-blue-100 to-purple-100 text-blue-700 text-sm font-bold border border-blue-200">
                    <svg class="w-4 h-4 ltr:mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    {{ __('frontend.management_tools') }}
                </span>
            </div>
            <h2 class="text-5xl sm:text-6xl font-black text-gray-900 mb-6">
                {{ __('frontend.vps_management_made_easy') }}
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                {{ __('frontend.vps_management_description') }}
            </p>
        </div>

        <!-- Features Grid with Bento Box Layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- Feature 1: Managed Firewall - Large Card -->
            <div class="lg:col-span-2 lg:row-span-2 group relative">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-blue-600/10 rounded-3xl blur-xl opacity-0 group-hover:opacity-100 transition-all duration-500"></div>
                <div class="relative h-full bg-gradient-to-br from-blue-50 to-white border-2 border-blue-100 rounded-3xl p-10 hover:border-blue-300 transition-all duration-500 overflow-hidden">
                    <!-- Decorative Icon Background -->
                    <div class="absolute top-0 ltr:right-0 rtl:left-0 w-64 h-64 opacity-5 transform ltr:translate-x-16 rtl:-translate-x-16 -translate-y-16">
                        <svg fill="currentColor" class="text-blue-600 w-full h-full" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/>
                        </svg>
                    </div>
                    
                    <div class="relative z-10">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl mb-6 shadow-xl shadow-blue-500/30 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-black text-gray-900 mb-4">{{ __('frontend.managed_firewall') }}</h3>
                        <p class="text-gray-600 text-lg leading-relaxed mb-6">{{ __('frontend.managed_firewall_desc') }}</p>
                        
                        <!-- Visual Stats -->
                        <div class="grid grid-cols-2 gap-4 mt-8">
                            <div class="bg-white/80 backdrop-blur-sm rounded-xl p-4 border border-blue-100">
                                <div class="text-3xl font-black text-blue-600 mb-1">99.9%</div>
                                <div class="text-sm text-gray-600 font-medium">{{ __('frontend.protection_rate') }}</div>
                            </div>
                            <div class="bg-white/80 backdrop-blur-sm rounded-xl p-4 border border-blue-100">
                                <div class="text-3xl font-black text-blue-600 mb-1">24/7</div>
                                <div class="text-sm text-gray-600 font-medium">{{ __('frontend.monitoring') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feature 2: DDoS Protection -->
            <div class="group relative">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-500/10 to-purple-600/10 rounded-3xl blur-xl opacity-0 group-hover:opacity-100 transition-all duration-500"></div>
                <div class="relative h-full bg-gradient-to-br from-purple-50 to-white border-2 border-purple-100 rounded-3xl p-8 hover:border-purple-300 transition-all duration-500">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl mb-6 shadow-lg shadow-purple-500/30 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-3">{{ __('frontend.ddos_protection') }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ __('frontend.ddos_protection_desc') }}</p>
                </div>
            </div>

            <!-- Feature 3: API Integration -->
            <div class="group relative">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 to-indigo-600/10 rounded-3xl blur-xl opacity-0 group-hover:opacity-100 transition-all duration-500"></div>
                <div class="relative h-full bg-gradient-to-br from-indigo-50 to-white border-2 border-indigo-100 rounded-3xl p-8 hover:border-indigo-300 transition-all duration-500">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl mb-6 shadow-lg shadow-indigo-500/30 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-3">{{ __('frontend.api_integration') }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ __('frontend.api_integration_desc') }}</p>
                </div>
            </div>

            <!-- Feature 4: Browser Terminal -->
            <div class="group relative">
                <div class="absolute inset-0 bg-gradient-to-br from-green-500/10 to-green-600/10 rounded-3xl blur-xl opacity-0 group-hover:opacity-100 transition-all duration-500"></div>
                <div class="relative h-full bg-gradient-to-br from-green-50 to-white border-2 border-green-100 rounded-3xl p-8 hover:border-green-300 transition-all duration-500">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl mb-6 shadow-lg shadow-green-500/30 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-3">{{ __('frontend.browser_terminal') }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ __('frontend.browser_terminal_desc') }}</p>
                </div>
            </div>

            <!-- Feature 5: Docker Manager -->
            <div class="lg:col-span-2 group relative">
                <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/10 to-cyan-600/10 rounded-3xl blur-xl opacity-0 group-hover:opacity-100 transition-all duration-500"></div>
                <div class="relative h-full bg-gradient-to-br from-cyan-50 to-white border-2 border-cyan-100 rounded-3xl p-8 hover:border-cyan-300 transition-all duration-500 flex items-center">
                    <div class="flex-shrink-0 ltr:mr-8 rtl:ml-8">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-2xl shadow-xl shadow-cyan-500/30 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-2xl font-black text-gray-900 mb-3">{{ __('frontend.docker_manager') }}</h3>
                        <p class="text-gray-600 leading-relaxed">{{ __('frontend.docker_manager_desc') }}</p>
                    </div>
                </div>
            </div>

            <!-- Feature 6: Full Root Access -->
            <div class="group relative">
                <div class="absolute inset-0 bg-gradient-to-br from-orange-500/10 to-orange-600/10 rounded-3xl blur-xl opacity-0 group-hover:opacity-100 transition-all duration-500"></div>
                <div class="relative h-full bg-gradient-to-br from-orange-50 to-white border-2 border-orange-100 rounded-3xl p-8 hover:border-orange-300 transition-all duration-500">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl mb-6 shadow-lg shadow-orange-500/30 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-3">{{ __('frontend.full_root_access') }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ __('frontend.full_root_access_desc') }}</p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- 30-Day Money-Back Guarantee Section -->
<section class="relative py-24 overflow-hidden bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50">
    <!-- Decorative Elements -->
    <div class="absolute inset-0">
        <div class="absolute top-0 left-0 w-72 h-72 bg-green-400/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-emerald-400/10 rounded-full blur-3xl"></div>
    </div>
    
    <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            <div class="grid md:grid-cols-2 gap-0">
                
                <!-- Left Side - Icon & Badge -->
                <div class="relative bg-gradient-to-br from-green-500 to-emerald-600 p-12 flex items-center justify-center overflow-hidden">
                    <!-- Decorative Circles -->
                    <div class="absolute top-0 right-0 w-48 h-48 bg-white/10 rounded-full transform translate-x-1/2 -translate-y-1/2"></div>
                    <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full transform -translate-x-1/2 translate-y-1/2"></div>
                    
                    <div class="relative z-10 text-center">
                        <!-- Large Icon -->
                        <div class="inline-flex items-center justify-center w-32 h-32 bg-white/20 backdrop-blur-lg rounded-full mb-6 shadow-2xl animate-pulse">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        
                        <!-- Badge -->
                        <div class="inline-block bg-white/20 backdrop-blur-md px-6 py-3 rounded-full border-2 border-white/40">
                            <span class="text-white font-black text-5xl">30</span>
                            <span class="text-white/90 font-semibold text-lg ltr:ml-2 rtl:mr-2">{{ __('frontend.days') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Content -->
                <div class="p-12 flex flex-col justify-center">
                    <div class="mb-6">
                        <span class="inline-flex items-center px-4 py-2 rounded-full bg-green-100 text-green-700 text-sm font-bold border border-green-200 mb-4">
                            <svg class="w-4 h-4 ltr:mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ __('frontend.risk_free') }}
                        </span>
                    </div>
                    
                    <h2 class="text-4xl font-black text-gray-900 mb-4 leading-tight">
                        {{ __('frontend.money_back_guarantee') }}
                    </h2>
                    
                    <p class="text-lg text-gray-600 leading-relaxed mb-8">
                        {{ __('frontend.money_back_guarantee_desc') }}
                    </p>
                    
                    <!-- CTA Button -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#plans" class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold rounded-xl shadow-xl shadow-green-500/30 hover:shadow-green-500/50 hover:scale-105 transition-all duration-300">
                            <span>{{ __('frontend.get_started') }}</span>
                            <svg class="w-5 h-5 ltr:ml-2 rtl:mr-2 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                        <a href="#" class="inline-flex items-center justify-center px-8 py-4 bg-white text-green-600 font-semibold rounded-xl border-2 border-green-200 hover:border-green-300 hover:bg-green-50 transition-all duration-300">
                            <svg class="w-5 h-5 ltr:mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span>{{ __('frontend.refund_policy') }}</span>
                        </a>
                    </div>
                    
                    <!-- Trust Indicators -->
                    <div class="flex items-center gap-6 mt-8 pt-8 border-t border-gray-200">
                        <div class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-green-500 ltr:mr-2 rtl:ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-sm font-medium">{{ __('frontend.no_questions_asked') }}</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 text-green-500 ltr:mr-2 rtl:ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-sm font-medium">{{ __('frontend.full_refund') }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- VPS Hosting FAQs Section -->
<section class="py-32 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center mb-16">
            <div class="inline-block mb-6">
                <span class="inline-flex items-center px-5 py-2 rounded-full bg-gradient-to-r from-blue-100 to-purple-100 text-blue-700 text-sm font-bold border border-blue-200">
                    <svg class="w-4 h-4 ltr:mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ __('frontend.faq_section') }}
                </span>
            </div>
            <h2 class="text-5xl sm:text-6xl font-black text-gray-900 mb-6">
                {{ __('frontend.vps_hosting_faqs') }}
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                {{ __('frontend.vps_faqs_description') }}
            </p>
        </div>

        <!-- FAQ Accordion -->
        <div class="space-y-4">
            
            <!-- FAQ 1 -->
            <div class="group border-2 border-gray-200 rounded-2xl overflow-hidden hover:border-blue-300 transition-all duration-300">
                <button type="button" class="w-full px-8 py-6 flex items-center justify-between bg-white hover:bg-gray-50 transition-colors" onclick="toggleFaq(this)">
                    <span class="text-xl font-bold text-gray-900 ltr:text-left rtl:text-right ltr:pr-4 rtl:pl-4">{{ __('frontend.faq_what_is_vps') }}</span>
                    <svg class="w-6 h-6 text-blue-600 transform transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="faq-content max-h-0 overflow-hidden transition-all duration-300">
                    <div class="px-8 py-6 bg-gray-50 border-t-2 border-gray-100">
                        <p class="text-gray-700 leading-relaxed">{{ __('frontend.faq_what_is_vps_answer') }}</p>
                    </div>
                </div>
            </div>

            <!-- FAQ 2 -->
            <div class="group border-2 border-gray-200 rounded-2xl overflow-hidden hover:border-blue-300 transition-all duration-300">
                <button type="button" class="w-full px-8 py-6 flex items-center justify-between bg-white hover:bg-gray-50 transition-colors" onclick="toggleFaq(this)">
                    <span class="text-xl font-bold text-gray-900 ltr:text-left rtl:text-right ltr:pr-4 rtl:pl-4">{{ __('frontend.faq_what_is_kvm') }}</span>
                    <svg class="w-6 h-6 text-blue-600 transform transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="faq-content max-h-0 overflow-hidden transition-all duration-300">
                    <div class="px-8 py-6 bg-gray-50 border-t-2 border-gray-100">
                        <p class="text-gray-700 leading-relaxed">{{ __('frontend.faq_what_is_kvm_answer') }}</p>
                    </div>
                </div>
            </div>

            <!-- FAQ 3 -->
            <div class="group border-2 border-gray-200 rounded-2xl overflow-hidden hover:border-blue-300 transition-all duration-300">
                <button type="button" class="w-full px-8 py-6 flex items-center justify-between bg-white hover:bg-gray-50 transition-colors" onclick="toggleFaq(this)">
                    <span class="text-xl font-bold text-gray-900 ltr:text-left rtl:text-right ltr:pr-4 rtl:pl-4">{{ __('frontend.faq_why_choose_vps') }}</span>
                    <svg class="w-6 h-6 text-blue-600 transform transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="faq-content max-h-0 overflow-hidden transition-all duration-300">
                    <div class="px-8 py-6 bg-gray-50 border-t-2 border-gray-100">
                        <p class="text-gray-700 leading-relaxed">{{ __('frontend.faq_why_choose_vps_answer') }}</p>
                    </div>
                </div>
            </div>

            <!-- FAQ 4 -->
            <div class="group border-2 border-gray-200 rounded-2xl overflow-hidden hover:border-blue-300 transition-all duration-300">
                <button type="button" class="w-full px-8 py-6 flex items-center justify-between bg-white hover:bg-gray-50 transition-colors" onclick="toggleFaq(this)">
                    <span class="text-xl font-bold text-gray-900 ltr:text-left rtl:text-right ltr:pr-4 rtl:pl-4">{{ __('frontend.faq_kvm_safe') }}</span>
                    <svg class="w-6 h-6 text-blue-600 transform transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="faq-content max-h-0 overflow-hidden transition-all duration-300">
                    <div class="px-8 py-6 bg-gray-50 border-t-2 border-gray-100">
                        <p class="text-gray-700 leading-relaxed">{{ __('frontend.faq_kvm_safe_answer') }}</p>
                    </div>
                </div>
            </div>

            <!-- FAQ 5 -->
            <div class="group border-2 border-gray-200 rounded-2xl overflow-hidden hover:border-blue-300 transition-all duration-300">
                <button type="button" class="w-full px-8 py-6 flex items-center justify-between bg-white hover:bg-gray-50 transition-colors" onclick="toggleFaq(this)">
                    <span class="text-xl font-bold text-gray-900 ltr:text-left rtl:text-right ltr:pr-4 rtl:pl-4">{{ __('frontend.faq_custom_software') }}</span>
                    <svg class="w-6 h-6 text-blue-600 transform transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="faq-content max-h-0 overflow-hidden transition-all duration-300">
                    <div class="px-8 py-6 bg-gray-50 border-t-2 border-gray-100">
                        <p class="text-gray-700 leading-relaxed">{{ __('frontend.faq_custom_software_answer') }}</p>
                    </div>
                </div>
            </div>

            <!-- FAQ 6 -->
            <div class="group border-2 border-gray-200 rounded-2xl overflow-hidden hover:border-blue-300 transition-all duration-300">
                <button type="button" class="w-full px-8 py-6 flex items-center justify-between bg-white hover:bg-gray-50 transition-colors" onclick="toggleFaq(this)">
                    <span class="text-xl font-bold text-gray-900 ltr:text-left rtl:text-right ltr:pr-4 rtl:pl-4">{{ __('frontend.faq_vps_cost') }}</span>
                    <svg class="w-6 h-6 text-blue-600 transform transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="faq-content max-h-0 overflow-hidden transition-all duration-300">
                    <div class="px-8 py-6 bg-gray-50 border-t-2 border-gray-100">
                        <p class="text-gray-700 leading-relaxed">{{ __('frontend.faq_vps_cost_answer') }}</p>
                    </div>
                </div>
            </div>

            <!-- FAQ 7 -->
            <div class="group border-2 border-gray-200 rounded-2xl overflow-hidden hover:border-blue-300 transition-all duration-300">
                <button type="button" class="w-full px-8 py-6 flex items-center justify-between bg-white hover:bg-gray-50 transition-colors" onclick="toggleFaq(this)">
                    <span class="text-xl font-bold text-gray-900 ltr:text-left rtl:text-right ltr:pr-4 rtl:pl-4">{{ __('frontend.faq_cpu_ram_limits') }}</span>
                    <svg class="w-6 h-6 text-blue-600 transform transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="faq-content max-h-0 overflow-hidden transition-all duration-300">
                    <div class="px-8 py-6 bg-gray-50 border-t-2 border-gray-100">
                        <p class="text-gray-700 leading-relaxed">{{ __('frontend.faq_cpu_ram_limits_answer') }}</p>
                    </div>
                </div>
            </div>

            <!-- FAQ 8 -->
            <div class="group border-2 border-gray-200 rounded-2xl overflow-hidden hover:border-blue-300 transition-all duration-300">
                <button type="button" class="w-full px-8 py-6 flex items-center justify-between bg-white hover:bg-gray-50 transition-colors" onclick="toggleFaq(this)">
                    <span class="text-xl font-bold text-gray-900 ltr:text-left rtl:text-right ltr:pr-4 rtl:pl-4">{{ __('frontend.faq_how_to_start') }}</span>
                    <svg class="w-6 h-6 text-blue-600 transform transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="faq-content max-h-0 overflow-hidden transition-all duration-300">
                    <div class="px-8 py-6 bg-gray-50 border-t-2 border-gray-100">
                        <p class="text-gray-700 leading-relaxed">{{ __('frontend.faq_how_to_start_answer') }}</p>
                    </div>
                </div>
            </div>

            <!-- FAQ 9 -->
            <div class="group border-2 border-gray-200 rounded-2xl overflow-hidden hover:border-blue-300 transition-all duration-300">
                <button type="button" class="w-full px-8 py-6 flex items-center justify-between bg-white hover:bg-gray-50 transition-colors" onclick="toggleFaq(this)">
                    <span class="text-xl font-bold text-gray-900 ltr:text-left rtl:text-right ltr:pr-4 rtl:pl-4">{{ __('frontend.faq_operating_systems') }}</span>
                    <svg class="w-6 h-6 text-blue-600 transform transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="faq-content max-h-0 overflow-hidden transition-all duration-300">
                    <div class="px-8 py-6 bg-gray-50 border-t-2 border-gray-100">
                        <p class="text-gray-700 leading-relaxed">{{ __('frontend.faq_operating_systems_answer') }}</p>
                    </div>
                </div>
            </div>

            <!-- FAQ 10 -->
            <div class="group border-2 border-gray-200 rounded-2xl overflow-hidden hover:border-blue-300 transition-all duration-300">
                <button type="button" class="w-full px-8 py-6 flex items-center justify-between bg-white hover:bg-gray-50 transition-colors" onclick="toggleFaq(this)">
                    <span class="text-xl font-bold text-gray-900 ltr:text-left rtl:text-right ltr:pr-4 rtl:pl-4">{{ __('frontend.faq_assistance') }}</span>
                    <svg class="w-6 h-6 text-blue-600 transform transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="faq-content max-h-0 overflow-hidden transition-all duration-300">
                    <div class="px-8 py-6 bg-gray-50 border-t-2 border-gray-100">
                        <p class="text-gray-700 leading-relaxed">{{ __('frontend.faq_assistance_answer') }}</p>
                    </div>
                </div>
            </div>

            <!-- FAQ 11 -->
            <div class="group border-2 border-gray-200 rounded-2xl overflow-hidden hover:border-blue-300 transition-all duration-300">
                <button type="button" class="w-full px-8 py-6 flex items-center justify-between bg-white hover:bg-gray-50 transition-colors" onclick="toggleFaq(this)">
                    <span class="text-xl font-bold text-gray-900 ltr:text-left rtl:text-right ltr:pr-4 rtl:pl-4">{{ __('frontend.faq_vps_vs_cloud') }}</span>
                    <svg class="w-6 h-6 text-blue-600 transform transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="faq-content max-h-0 overflow-hidden transition-all duration-300">
                    <div class="px-8 py-6 bg-gray-50 border-t-2 border-gray-100">
                        <p class="text-gray-700 leading-relaxed">{{ __('frontend.faq_vps_vs_cloud_answer') }}</p>
                    </div>
                </div>
            </div>

            <!-- FAQ 12 -->
            <div class="group border-2 border-gray-200 rounded-2xl overflow-hidden hover:border-blue-300 transition-all duration-300">
                <button type="button" class="w-full px-8 py-6 flex items-center justify-between bg-white hover:bg-gray-50 transition-colors" onclick="toggleFaq(this)">
                    <span class="text-xl font-bold text-gray-900 ltr:text-left rtl:text-right ltr:pr-4 rtl:pl-4">{{ __('frontend.faq_public_api') }}</span>
                    <svg class="w-6 h-6 text-blue-600 transform transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="faq-content max-h-0 overflow-hidden transition-all duration-300">
                    <div class="px-8 py-6 bg-gray-50 border-t-2 border-gray-100">
                        <p class="text-gray-700 leading-relaxed">{{ __('frontend.faq_public_api_answer') }}</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Contact CTA -->
        <div class="mt-16 text-center p-8 bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl border-2 border-blue-100">
            <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ __('frontend.still_have_questions') }}</h3>
            <p class="text-gray-600 mb-6">{{ __('frontend.contact_support_team') }}</p>
            <button onclick="if(typeof Intercom !== 'undefined') { Intercom('show'); } else { alert('{{ app()->getLocale() == 'ar' ? 'جاري تحميل نظام الدعم...' : 'Loading support system...' }}'); }" class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold rounded-xl shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300 cursor-pointer">
                <svg class="w-5 h-5 ltr:mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                </svg>
                {{ __('frontend.contact_us') }}
            </button>
        </div>
    </div>
</section>

<script>
function toggleFaq(button) {
    const content = button.nextElementSibling;
    const icon = button.querySelector('svg');
    const isOpen = content.style.maxHeight && content.style.maxHeight !== '0px';
    
    // Close all other FAQs
    document.querySelectorAll('.faq-content').forEach(item => {
        if (item !== content) {
            item.style.maxHeight = '0px';
            item.previousElementSibling.querySelector('svg').style.transform = 'rotate(0deg)';
        }
    });
    
    // Toggle current FAQ
    if (isOpen) {
        content.style.maxHeight = '0px';
        icon.style.transform = 'rotate(0deg)';
    } else {
        content.style.maxHeight = content.scrollHeight + 'px';
        icon.style.transform = 'rotate(180deg)';
    }
}
</script>

@endsection
