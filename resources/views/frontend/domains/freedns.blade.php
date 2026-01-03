@extends('frontend.layout')

@section('title', __('frontend.free_dns'))

@section('content')

<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-green-600 via-emerald-700 to-teal-800 py-24 md:py-32 overflow-hidden">
    <!-- Animated Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 -left-4 w-72 h-72 bg-white rounded-full mix-blend-multiply filter blur-xl animate-blob"></div>
        <div class="absolute top-0 -right-4 w-72 h-72 bg-yellow-200 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-200 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-4000"></div>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-5xl mx-auto">
            <!-- Badge -->
            <div class="text-center mb-8">
                <span class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm text-white px-6 py-3 rounded-full text-sm font-bold shadow-lg">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span dir="auto">{{ __('frontend.free_dns_badge') }}</span>
                </span>
            </div>

            <!-- Main Title -->
            <div class="text-center mb-12">
                <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 leading-tight" dir="auto">
                    {{ __('frontend.free_dns_title') }}
                </h1>
                <p class="text-xl md:text-2xl text-green-100 max-w-3xl mx-auto leading-relaxed mb-8" dir="auto">
                    {{ __('frontend.free_dns_subtitle') }}
                </p>
            </div>

            <!-- Features Grid in Hero -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <!-- Feature 1 -->
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 hover:bg-white/20 transition-all duration-300">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white mb-2" dir="auto">{{ __('frontend.instant_activation') }}</h3>
                            <p class="text-green-100 text-sm" dir="auto">{{ __('frontend.instant_activation_desc') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 hover:bg-white/20 transition-all duration-300">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white mb-2" dir="auto">{{ __('frontend.total_control') }}</h3>
                            <p class="text-green-100 text-sm" dir="auto">{{ __('frontend.total_control_desc') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 hover:bg-white/20 transition-all duration-300">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white mb-2" dir="auto">{{ __('frontend.easy_management') }}</h3>
                            <p class="text-green-100 text-sm" dir="auto">{{ __('frontend.easy_management_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ route('register') }}" class="inline-flex items-center gap-3 bg-white text-green-600 font-bold py-4 px-8 rounded-2xl shadow-2xl hover:shadow-3xl transform hover:scale-105 transition-all duration-200">
                    <span dir="auto">{{ __('frontend.get_started_now') }}</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
                <a href="#features" class="inline-flex items-center gap-3 bg-white/20 backdrop-blur-sm text-white border-2 border-white font-bold py-4 px-8 rounded-2xl hover:bg-white/30 transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span dir="auto">{{ __('frontend.learn_more') }}</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- What is Free DNS Section -->
<section id="features" class="py-20 bg-white dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-2 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-full text-sm font-semibold mb-4" dir="auto">
                    {{ __('frontend.what_is_freedns') }}
                </span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6" dir="auto">
                    {{ __('frontend.freedns_power_title') }}
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto" dir="auto">
                    {{ __('frontend.freedns_power_desc') }}
                </p>
            </div>

            <!-- Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-3xl p-8 border border-green-200 dark:border-green-800">
                    <div class="flex items-start gap-4 mb-6">
                        <div class="w-14 h-14 bg-green-500 rounded-2xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3" dir="auto">{{ __('frontend.included_all_domains') }}</h3>
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed" dir="auto">{{ __('frontend.included_all_domains_desc') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-3xl p-8 border border-blue-200 dark:border-blue-800">
                    <div class="flex items-start gap-4 mb-6">
                        <div class="w-14 h-14 bg-blue-500 rounded-2xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3" dir="auto">{{ __('frontend.complete_control') }}</h3>
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed" dir="auto">{{ __('frontend.complete_control_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- DNS Features Section -->
<section class="py-20 bg-gray-50 dark:bg-gray-800">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6" dir="auto">
                    {{ __('frontend.dns_features') }}
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto" dir="auto">
                    {{ __('frontend.dns_features_desc') }}
                </p>
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1: A Records -->
                <div class="group bg-white dark:bg-gray-900 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-200 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4" dir="auto">{{ __('frontend.a_records') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed" dir="auto">{{ __('frontend.a_records_desc') }}</p>
                </div>

                <!-- Feature 2: CNAME Records -->
                <div class="group bg-white dark:bg-gray-900 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-200 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4" dir="auto">{{ __('frontend.cname_records') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed" dir="auto">{{ __('frontend.cname_records_desc') }}</p>
                </div>

                <!-- Feature 3: MX Records -->
                <div class="group bg-white dark:bg-gray-900 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-200 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4" dir="auto">{{ __('frontend.mx_records') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed" dir="auto">{{ __('frontend.mx_records_desc') }}</p>
                </div>

                <!-- Feature 4: TXT Records -->
                <div class="group bg-white dark:bg-gray-900 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-200 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4" dir="auto">{{ __('frontend.txt_records') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed" dir="auto">{{ __('frontend.txt_records_desc') }}</p>
                </div>

                <!-- Feature 5: NS Records -->
                <div class="group bg-white dark:bg-gray-900 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-200 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4" dir="auto">{{ __('frontend.ns_records') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed" dir="auto">{{ __('frontend.ns_records_desc') }}</p>
                </div>

                <!-- Feature 6: AAAA Records -->
                <div class="group bg-white dark:bg-gray-900 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-200 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-amber-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4" dir="auto">{{ __('frontend.aaaa_records') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed" dir="auto">{{ __('frontend.aaaa_records_desc') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How DNS Works - Informative Section -->
<section class="py-20 bg-gradient-to-br from-blue-600 via-indigo-700 to-purple-800 relative overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-20 left-20 w-72 h-72 bg-white rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-20 w-96 h-96 bg-purple-300 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-blue-300 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-6xl mx-auto">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <div class="inline-block px-6 py-2 bg-white/20 backdrop-blur-sm rounded-full border border-white/30 mb-6">
                    <span class="text-white font-semibold text-sm" dir="auto">{{ __('frontend.how_it_works') }}</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-6" dir="auto">
                    {{ __('frontend.how_dns_works_title') }}
                </h2>
                <p class="text-xl text-blue-100 max-w-3xl mx-auto leading-relaxed" dir="auto">
                    {{ __('frontend.how_dns_works_desc') }}
                </p>
            </div>

            <!-- Steps Container -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <!-- Step 1 -->
                <div class="group relative">
                    <div class="absolute inset-0 bg-white rounded-2xl transform group-hover:scale-105 transition-transform duration-300 shadow-2xl"></div>
                    <div class="relative p-8 bg-gradient-to-br from-white to-blue-50 rounded-2xl border-2 border-blue-200 h-full">
                        <!-- Step Number -->
                        <div class="absolute -top-4 -right-4 w-12 h-12 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-full flex items-center justify-center shadow-lg">
                            <span class="text-white font-bold text-lg">1</span>
                        </div>
                        
                        <!-- Icon -->
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-900 mb-3" dir="auto">{{ __('frontend.dns_step1_title') }}</h3>
                        <p class="text-gray-600 text-sm leading-relaxed" dir="auto">{{ __('frontend.dns_step1_desc') }}</p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="group relative">
                    <div class="absolute inset-0 bg-white rounded-2xl transform group-hover:scale-105 transition-transform duration-300 shadow-2xl"></div>
                    <div class="relative p-8 bg-gradient-to-br from-white to-purple-50 rounded-2xl border-2 border-purple-200 h-full">
                        <!-- Step Number -->
                        <div class="absolute -top-4 -right-4 w-12 h-12 bg-gradient-to-br from-purple-600 to-pink-600 rounded-full flex items-center justify-center shadow-lg">
                            <span class="text-white font-bold text-lg">2</span>
                        </div>
                        
                        <!-- Icon -->
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-900 mb-3" dir="auto">{{ __('frontend.dns_step2_title') }}</h3>
                        <p class="text-gray-600 text-sm leading-relaxed" dir="auto">{{ __('frontend.dns_step2_desc') }}</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="group relative">
                    <div class="absolute inset-0 bg-white rounded-2xl transform group-hover:scale-105 transition-transform duration-300 shadow-2xl"></div>
                    <div class="relative p-8 bg-gradient-to-br from-white to-green-50 rounded-2xl border-2 border-green-200 h-full">
                        <!-- Step Number -->
                        <div class="absolute -top-4 -right-4 w-12 h-12 bg-gradient-to-br from-green-600 to-emerald-600 rounded-full flex items-center justify-center shadow-lg">
                            <span class="text-white font-bold text-lg">3</span>
                        </div>
                        
                        <!-- Icon -->
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                            </svg>
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-900 mb-3" dir="auto">{{ __('frontend.dns_step3_title') }}</h3>
                        <p class="text-gray-600 text-sm leading-relaxed" dir="auto">{{ __('frontend.dns_step3_desc') }}</p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="group relative">
                    <div class="absolute inset-0 bg-white rounded-2xl transform group-hover:scale-105 transition-transform duration-300 shadow-2xl"></div>
                    <div class="relative p-8 bg-gradient-to-br from-white to-orange-50 rounded-2xl border-2 border-orange-200 h-full">
                        <!-- Step Number -->
                        <div class="absolute -top-4 -right-4 w-12 h-12 bg-gradient-to-br from-orange-600 to-red-600 rounded-full flex items-center justify-center shadow-lg">
                            <span class="text-white font-bold text-lg">4</span>
                        </div>
                        
                        <!-- Icon -->
                        <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-900 mb-3" dir="auto">{{ __('frontend.dns_step4_title') }}</h3>
                        <p class="text-gray-600 text-sm leading-relaxed" dir="auto">{{ __('frontend.dns_step4_desc') }}</p>
                    </div>
                </div>
            </div>

            <!-- Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card 1 -->
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 hover:bg-white/20 transition-all duration-300">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-white mb-2" dir="auto">{{ __('frontend.dns_speed_title') }}</h4>
                            <p class="text-blue-100 text-sm" dir="auto">{{ __('frontend.dns_speed_desc') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 hover:bg-white/20 transition-all duration-300">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-white mb-2" dir="auto">{{ __('frontend.dns_security_title') }}</h4>
                            <p class="text-blue-100 text-sm" dir="auto">{{ __('frontend.dns_security_desc') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 hover:bg-white/20 transition-all duration-300">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-white mb-2" dir="auto">{{ __('frontend.dns_global_title') }}</h4>
                            <p class="text-blue-100 text-sm" dir="auto">{{ __('frontend.dns_global_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- DNSSEC Section -->
<section class="py-20 bg-white dark:bg-gray-900 relative overflow-hidden">
    <!-- Background Decoration -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute top-0 left-0 w-full h-full" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%239C92AC\' fill-opacity=\'0.4\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div>
                    <!-- Badge -->
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-green-100 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/30 rounded-full border border-green-300 dark:border-green-700 mb-6">
                        <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <span class="text-sm font-semibold text-green-700 dark:text-green-300" dir="auto">{{ __('frontend.dnssec_badge') }}</span>
                    </div>

                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6" dir="auto">
                        {{ __('frontend.dnssec_title') }}
                    </h2>
                    
                    <p class="text-xl text-gray-600 dark:text-gray-400 mb-8 leading-relaxed" dir="auto">
                        {{ __('frontend.dnssec_description') }}
                    </p>

                    <!-- Features List -->
                    <div class="space-y-4 mb-8">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white mb-1" dir="auto">{{ __('frontend.dnssec_feature1_title') }}</h4>
                                <p class="text-gray-600 dark:text-gray-400 text-sm" dir="auto">{{ __('frontend.dnssec_feature1_desc') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white mb-1" dir="auto">{{ __('frontend.dnssec_feature2_title') }}</h4>
                                <p class="text-gray-600 dark:text-gray-400 text-sm" dir="auto">{{ __('frontend.dnssec_feature2_desc') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-8 h-8 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white mb-1" dir="auto">{{ __('frontend.dnssec_feature3_title') }}</h4>
                                <p class="text-gray-600 dark:text-gray-400 text-sm" dir="auto">{{ __('frontend.dnssec_feature3_desc') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- CTA Button -->
                    <a href="#what-is-dnssec" class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 hover:from-blue-700 hover:via-indigo-700 hover:to-purple-700 text-white font-bold rounded-xl shadow-2xl hover:shadow-3xl transform hover:scale-105 transition-all duration-300 group">
                        <svg class="w-6 h-6 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span dir="auto">{{ __('frontend.enable_dnssec') }}</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                </div>

                <!-- Right Visual -->
                <div class="relative">
                    <!-- Main Card -->
                    <div class="relative bg-gradient-to-br from-green-50 to-emerald-100 dark:from-green-900/20 dark:to-emerald-900/30 rounded-3xl p-8 border-2 border-green-200 dark:border-green-700 shadow-2xl">
                        <!-- Shield Icon -->
                        <div class="absolute -top-6 -right-6 w-20 h-20 bg-gradient-to-br from-green-600 to-emerald-600 rounded-2xl flex items-center justify-center shadow-2xl transform rotate-12 animate-pulse">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>

                        <!-- Security Layers -->
                        <div class="space-y-6">
                            <!-- Layer 1 -->
                            <div class="flex items-center gap-4 p-4 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-green-200 dark:border-green-700">
                                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-md">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h5 class="font-bold text-gray-900 dark:text-white mb-1" dir="auto">{{ __('frontend.dnssec_layer1') }}</h5>
                                    <div class="flex items-center gap-2">
                                        <div class="flex-1 h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-green-500 to-emerald-600 rounded-full animate-pulse" style="width: 100%"></div>
                                        </div>
                                        <span class="text-xs font-semibold text-green-600 dark:text-green-400">100%</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Layer 2 -->
                            <div class="flex items-center gap-4 p-4 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-blue-200 dark:border-blue-700 ml-8">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-md">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h5 class="font-bold text-gray-900 dark:text-white mb-1" dir="auto">{{ __('frontend.dnssec_layer2') }}</h5>
                                    <div class="flex items-center gap-2">
                                        <div class="flex-1 h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full animate-pulse" style="width: 100%; animation-delay: 0.5s"></div>
                                        </div>
                                        <span class="text-xs font-semibold text-blue-600 dark:text-blue-400">100%</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Layer 3 -->
                            <div class="flex items-center gap-4 p-4 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-purple-200 dark:border-purple-700 ml-16">
                                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center shadow-md">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h5 class="font-bold text-gray-900 dark:text-white mb-1" dir="auto">{{ __('frontend.dnssec_layer3') }}</h5>
                                    <div class="flex items-center gap-2">
                                        <div class="flex-1 h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-purple-500 to-pink-600 rounded-full animate-pulse" style="width: 100%; animation-delay: 1s"></div>
                                        </div>
                                        <span class="text-xs font-semibold text-purple-600 dark:text-purple-400">100%</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status Badge -->
                        <div class="mt-8 flex items-center justify-center gap-2 p-4 bg-green-600 dark:bg-green-700 rounded-xl shadow-lg">
                            <svg class="w-6 h-6 text-white animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-white font-bold text-lg" dir="auto">{{ __('frontend.dnssec_protected') }}</span>
                        </div>
                    </div>

                    <!-- Floating Elements -->
                    <div class="absolute -bottom-4 -left-4 w-24 h-24 bg-green-200 dark:bg-green-800 rounded-full blur-2xl opacity-50 animate-pulse"></div>
                    <div class="absolute -top-4 -right-4 w-32 h-32 bg-blue-200 dark:bg-blue-800 rounded-full blur-2xl opacity-50 animate-pulse" style="animation-delay: 1s"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- What is DNSSEC - Detailed Explanation Section -->
<section id="what-is-dnssec" class="py-20 bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 dark:from-gray-900 dark:via-blue-900/20 dark:to-indigo-900/20 relative overflow-hidden">
    <!-- Animated Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, currentColor 1px, transparent 1px); background-size: 40px 40px;"></div>
    </div>
    
    <!-- Floating Blobs -->
    <div class="absolute top-20 left-10 w-72 h-72 bg-blue-300 dark:bg-blue-700 rounded-full mix-blend-multiply dark:mix-blend-normal filter blur-3xl opacity-20 animate-blob"></div>
    <div class="absolute top-40 right-10 w-72 h-72 bg-purple-300 dark:bg-purple-700 rounded-full mix-blend-multiply dark:mix-blend-normal filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
    <div class="absolute bottom-20 left-1/2 w-72 h-72 bg-pink-300 dark:bg-pink-700 rounded-full mix-blend-multiply dark:mix-blend-normal filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-7xl mx-auto">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full shadow-lg mb-6 transform hover:scale-105 transition-all duration-300">
                    <svg class="w-5 h-5 text-white animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <span class="text-white font-bold text-sm tracking-wide" dir="auto">{{ __('frontend.technical_details') }}</span>
                </div>
                <h2 class="text-5xl md:text-6xl font-black mb-6 animate-fade-in" dir="auto">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 dark:from-blue-400 dark:via-indigo-400 dark:to-purple-400">
                        {{ __('frontend.what_is_dnssec_title') }}
                    </span>
                </h2>
                <p class="text-xl md:text-2xl text-gray-700 dark:text-gray-300 max-w-4xl mx-auto leading-relaxed font-medium" dir="auto">
                    {{ __('frontend.what_is_dnssec_subtitle') }}
                </p>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
                <!-- Left Column: Explanation -->
                <div class="space-y-8">
                    <!-- Card 1: The Problem -->
                    <div class="group relative bg-gradient-to-br from-white to-red-50 dark:from-gray-900 dark:to-red-900/10 rounded-3xl p-8 shadow-2xl border-2 border-red-200 dark:border-red-800 hover:shadow-3xl hover:scale-[1.02] transition-all duration-300">
                        <!-- Decorative Corner -->
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-red-500/10 to-transparent rounded-bl-full"></div>
                        
                        <div class="flex items-start gap-4 mb-6 relative z-10">
                            <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="inline-block px-3 py-1 bg-red-100 dark:bg-red-900/50 text-red-700 dark:text-red-300 text-xs font-bold rounded-full mb-2" dir="auto">{{ __('frontend.security_risk') }}</div>
                                <h3 class="text-2xl md:text-3xl font-black text-gray-900 dark:text-white mb-3" dir="auto">{{ __('frontend.dnssec_problem_title') }}</h3>
                                <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-6 text-lg" dir="auto">
                                    {{ __('frontend.dnssec_problem_desc') }}
                                </p>
                                <ul class="space-y-3">
                                    <li class="flex items-start gap-3 p-3 bg-white/50 dark:bg-gray-800/50 rounded-xl hover:bg-white dark:hover:bg-gray-800 transition-colors duration-200">
                                        <div class="flex-shrink-0 w-6 h-6 bg-red-100 dark:bg-red-900/50 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </div>
                                        <span class="text-gray-800 dark:text-gray-200 font-medium flex-1" dir="auto">{{ __('frontend.dns_attack1') }}</span>
                                    </li>
                                    <li class="flex items-start gap-3 p-3 bg-white/50 dark:bg-gray-800/50 rounded-xl hover:bg-white dark:hover:bg-gray-800 transition-colors duration-200">
                                        <div class="flex-shrink-0 w-6 h-6 bg-red-100 dark:bg-red-900/50 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </div>
                                        <span class="text-gray-800 dark:text-gray-200 font-medium flex-1" dir="auto">{{ __('frontend.dns_attack2') }}</span>
                                    </li>
                                    <li class="flex items-start gap-3 p-3 bg-white/50 dark:bg-gray-800/50 rounded-xl hover:bg-white dark:hover:bg-gray-800 transition-colors duration-200">
                                        <div class="flex-shrink-0 w-6 h-6 bg-red-100 dark:bg-red-900/50 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </div>
                                        <span class="text-gray-800 dark:text-gray-200 font-medium flex-1" dir="auto">{{ __('frontend.dns_attack3') }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: The Solution -->
                    <div class="group relative bg-gradient-to-br from-white to-green-50 dark:from-gray-900 dark:to-green-900/10 rounded-3xl p-8 shadow-2xl border-2 border-green-200 dark:border-green-800 hover:shadow-3xl hover:scale-[1.02] transition-all duration-300">
                        <!-- Decorative Corner -->
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-green-500/10 to-transparent rounded-bl-full"></div>
                        
                        <div class="flex items-start gap-4 mb-6 relative z-10">
                            <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:-rotate-3 transition-all duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="inline-block px-3 py-1 bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300 text-xs font-bold rounded-full mb-2">{{ __('frontend.dnssec_protected') }}</div>
                                <h3 class="text-2xl md:text-3xl font-black text-gray-900 dark:text-white mb-3" dir="auto">{{ __('frontend.dnssec_solution_title') }}</h3>
                                <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-6 text-lg" dir="auto">
                                    {{ __('frontend.dnssec_solution_desc') }}
                                </p>
                                <ul class="space-y-3">
                                    <li class="flex items-start gap-3 p-3 bg-white/50 dark:bg-gray-800/50 rounded-xl hover:bg-white dark:hover:bg-gray-800 transition-colors duration-200">
                                        <div class="flex-shrink-0 w-6 h-6 bg-green-100 dark:bg-green-900/50 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <span class="text-gray-800 dark:text-gray-200 font-medium flex-1" dir="auto">{{ __('frontend.dnssec_benefit1') }}</span>
                                    </li>
                                    <li class="flex items-start gap-3 p-3 bg-white/50 dark:bg-gray-800/50 rounded-xl hover:bg-white dark:hover:bg-gray-800 transition-colors duration-200">
                                        <div class="flex-shrink-0 w-6 h-6 bg-green-100 dark:bg-green-900/50 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <span class="text-gray-800 dark:text-gray-200 font-medium flex-1" dir="auto">{{ __('frontend.dnssec_benefit2') }}</span>
                                    </li>
                                    <li class="flex items-start gap-3 p-3 bg-white/50 dark:bg-gray-800/50 rounded-xl hover:bg-white dark:hover:bg-gray-800 transition-colors duration-200">
                                        <div class="flex-shrink-0 w-6 h-6 bg-green-100 dark:bg-green-900/50 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <span class="text-gray-800 dark:text-gray-200 font-medium flex-1" dir="auto">{{ __('frontend.dnssec_benefit3') }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: How it Works -->
                <div class="space-y-8">
                    <div class="relative bg-white dark:bg-gray-900 rounded-3xl p-8 shadow-2xl border-2 border-blue-200 dark:border-blue-700 overflow-hidden">
                        <!-- Decorative Background -->
                        <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-br from-blue-500/10 via-indigo-500/10 to-purple-500/10"></div>
                        
                        <div class="relative z-10">
                            <div class="flex items-center justify-center gap-3 mb-8">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg animate-pulse">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl md:text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400" dir="auto">
                                    {{ __('frontend.how_dnssec_works') }}
                                </h3>
                            </div>

                            <!-- Process Steps -->
                            <div class="space-y-6">
                                <!-- Step 1 -->
                                <div class="group relative pl-10 pb-8 border-l-4 border-blue-200 dark:border-blue-700 hover:border-blue-500 dark:hover:border-blue-400 transition-colors duration-300">
                                    <div class="absolute -left-4 top-0 w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-125 group-hover:rotate-12 transition-all duration-300">
                                        <span class="text-white text-sm font-bold">1</span>
                                    </div>
                                    <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-xl">
                                        <h4 class="font-black text-gray-900 dark:text-white mb-2 text-lg" dir="auto">{{ __('frontend.dnssec_step1_title') }}</h4>
                                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed" dir="auto">{{ __('frontend.dnssec_step1_detail') }}</p>
                                    </div>
                                </div>

                                <!-- Step 2 -->
                                <div class="group relative pl-10 pb-8 border-l-4 border-indigo-200 dark:border-indigo-700 hover:border-indigo-500 dark:hover:border-indigo-400 transition-colors duration-300">
                                    <div class="absolute -left-4 top-0 w-8 h-8 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-125 group-hover:rotate-12 transition-all duration-300">
                                        <span class="text-white text-sm font-bold">2</span>
                                    </div>
                                    <div class="bg-indigo-50 dark:bg-indigo-900/20 p-4 rounded-xl">
                                        <h4 class="font-black text-gray-900 dark:text-white mb-2 text-lg" dir="auto">{{ __('frontend.dnssec_step2_title') }}</h4>
                                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed" dir="auto">{{ __('frontend.dnssec_step2_detail') }}</p>
                                    </div>
                                </div>

                                <!-- Step 3 -->
                                <div class="group relative pl-10 pb-8 border-l-4 border-purple-200 dark:border-purple-700 hover:border-purple-500 dark:hover:border-purple-400 transition-colors duration-300">
                                    <div class="absolute -left-4 top-0 w-8 h-8 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-125 group-hover:rotate-12 transition-all duration-300">
                                        <span class="text-white text-sm font-bold">3</span>
                                    </div>
                                    <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-xl">
                                        <h4 class="font-black text-gray-900 dark:text-white mb-2 text-lg" dir="auto">{{ __('frontend.dnssec_step3_title') }}</h4>
                                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed" dir="auto">{{ __('frontend.dnssec_step3_detail') }}</p>
                                    </div>
                                </div>

                                <!-- Step 4 -->
                                <div class="group relative pl-10">
                                    <div class="absolute -left-4 top-0 w-8 h-8 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-125 group-hover:rotate-12 transition-all duration-300">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-xl">
                                        <h4 class="font-black text-gray-900 dark:text-white mb-2 text-lg" dir="auto">{{ __('frontend.dnssec_step4_title') }}</h4>
                                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed" dir="auto">{{ __('frontend.dnssec_step4_detail') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Key Components Section -->
            <div class="mb-16">
                <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-8 text-center" dir="auto">
                    {{ __('frontend.dnssec_components_title') }}
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Component 1: DNSKEY -->
                    <div class="group bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-lg border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-500 transition-all duration-300 hover:shadow-2xl hover:-translate-y-2">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-2" dir="auto">DNSKEY</h4>
                        <p class="text-gray-600 dark:text-gray-400 text-sm" dir="auto">{{ __('frontend.dnskey_desc') }}</p>
                    </div>

                    <!-- Component 2: RRSIG -->
                    <div class="group bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-lg border-2 border-gray-200 dark:border-gray-700 hover:border-purple-500 dark:hover:border-purple-500 transition-all duration-300 hover:shadow-2xl hover:-translate-y-2">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-2" dir="auto">RRSIG</h4>
                        <p class="text-gray-600 dark:text-gray-400 text-sm" dir="auto">{{ __('frontend.rrsig_desc') }}</p>
                    </div>

                    <!-- Component 3: DS -->
                    <div class="group bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-lg border-2 border-gray-200 dark:border-gray-700 hover:border-green-500 dark:hover:border-green-500 transition-all duration-300 hover:shadow-2xl hover:-translate-y-2">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-2" dir="auto">DS Record</h4>
                        <p class="text-gray-600 dark:text-gray-400 text-sm" dir="auto">{{ __('frontend.ds_desc') }}</p>
                    </div>

                    <!-- Component 4: NSEC/NSEC3 -->
                    <div class="group bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-lg border-2 border-gray-200 dark:border-gray-700 hover:border-orange-500 dark:hover:border-orange-500 transition-all duration-300 hover:shadow-2xl hover:-translate-y-2">
                        <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-2" dir="auto">NSEC/NSEC3</h4>
                        <p class="text-gray-600 dark:text-gray-400 text-sm" dir="auto">{{ __('frontend.nsec_desc') }}</p>
                    </div>
                </div>
            </div>

            <!-- Statistics Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-8 text-center shadow-2xl transform hover:scale-105 transition-all duration-300">
                    <div class="text-5xl font-bold text-white mb-2">99.9%</div>
                    <p class="text-blue-100 font-semibold" dir="auto">{{ __('frontend.dnssec_stat1') }}</p>
                </div>
                <div class="bg-gradient-to-br from-green-600 to-emerald-700 rounded-2xl p-8 text-center shadow-2xl transform hover:scale-105 transition-all duration-300">
                    <div class="text-5xl font-bold text-white mb-2">&lt;5ms</div>
                    <p class="text-green-100 font-semibold" dir="auto">{{ __('frontend.dnssec_stat2') }}</p>
                </div>
                <div class="bg-gradient-to-br from-purple-600 to-pink-700 rounded-2xl p-8 text-center shadow-2xl transform hover:scale-105 transition-all duration-300">
                    <div class="text-5xl font-bold text-white mb-2">100%</div>
                    <p class="text-purple-100 font-semibold" dir="auto">{{ __('frontend.dnssec_stat3') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Our DNS Section -->
<section class="py-20 bg-white dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6" dir="auto">
                    {{ __('frontend.why_our_dns') }}
                </h2>
            </div>

            <!-- Benefits Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Benefit 1 -->
                <div class="flex items-start gap-6">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2" dir="auto">{{ __('frontend.lightning_fast') }}</h3>
                        <p class="text-gray-600 dark:text-gray-400" dir="auto">{{ __('frontend.lightning_fast_desc') }}</p>
                    </div>
                </div>

                <!-- Benefit 2 -->
                <div class="flex items-start gap-6">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2" dir="auto">{{ __('frontend.global_network') }}</h3>
                        <p class="text-gray-600 dark:text-gray-400" dir="auto">{{ __('frontend.global_network_desc') }}</p>
                    </div>
                </div>

                <!-- Benefit 3 -->
                <div class="flex items-start gap-6">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2" dir="auto">{{ __('frontend.high_security') }}</h3>
                        <p class="text-gray-600 dark:text-gray-400" dir="auto">{{ __('frontend.high_security_desc') }}</p>
                    </div>
                </div>

                <!-- Benefit 4 -->
                <div class="flex items-start gap-6">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2" dir="auto">{{ __('frontend.instant_propagation') }}</h3>
                        <p class="text-gray-600 dark:text-gray-400" dir="auto">{{ __('frontend.instant_propagation_desc') }}</p>
                    </div>
                </div>

                <!-- Benefit 5 -->
                <div class="flex items-start gap-6">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-pink-100 dark:bg-pink-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2" dir="auto">{{ __('frontend.easy_interface') }}</h3>
                        <p class="text-gray-600 dark:text-gray-400" dir="auto">{{ __('frontend.easy_interface_desc') }}</p>
                    </div>
                </div>

                <!-- Benefit 6 -->
                <div class="flex items-start gap-6">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-teal-100 dark:bg-teal-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2" dir="auto">{{ __('frontend.expert_support') }}</h3>
                        <p class="text-gray-600 dark:text-gray-400" dir="auto">{{ __('frontend.expert_support_desc') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- DNS Checker Section -->
<section class="py-20 bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <span class="inline-block px-4 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full text-sm font-semibold mb-4" dir="auto">
                    {{ __('frontend.dns_checker_tool') }}
                </span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6" dir="auto">
                    {{ __('frontend.check_dns_records') }}
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto" dir="auto">
                    {{ __('frontend.dns_checker_desc') }}
                </p>
            </div>

            <!-- DNS Checker Form -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-700">
                <!-- Form Section -->
                <div class="p-8 md:p-12 bg-gradient-to-br from-white to-blue-50 dark:from-gray-800 dark:to-gray-900">
                    <form id="dns-checker-form" class="space-y-6">
                        @csrf
                        <div>
                            <label for="dns-domain-input" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3" dir="auto">
                                {{ __('frontend.enter_domain_name') }}
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'right-0 pr-4' : 'left-0 pl-4' }} flex items-center pointer-events-none">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" 
                                       id="dns-domain-input" 
                                       name="domain" 
                                       class="w-full {{ app()->getLocale() == 'ar' ? 'pr-14 pl-4' : 'pl-14 pr-4' }} py-4 text-lg border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                                       placeholder="{{ __('frontend.example_domain_com') }}"
                                       required>
                            </div>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400" dir="auto">
                                {{ __('frontend.dns_checker_hint') }}
                            </p>
                        </div>

                        <!-- Record Type Selection -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3" dir="auto">
                                {{ __('frontend.select_record_types') }}
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                <label class="relative flex items-center p-4 bg-white dark:bg-gray-700 rounded-xl border-2 border-gray-200 dark:border-gray-600 cursor-pointer hover:border-blue-500 dark:hover:border-blue-500 transition-all duration-200 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                                    <input type="checkbox" name="record_types[]" value="A" class="sr-only peer" checked>
                                    <div class="flex items-center gap-2 w-full">
                                        <div class="w-2 h-2 rounded-full border-2 border-gray-400 peer-checked:border-blue-500 peer-checked:bg-blue-500"></div>
                                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 peer-checked:text-blue-600 dark:peer-checked:text-blue-400">A</span>
                                    </div>
                                </label>
                                
                                <label class="relative flex items-center p-4 bg-white dark:bg-gray-700 rounded-xl border-2 border-gray-200 dark:border-gray-600 cursor-pointer hover:border-blue-500 dark:hover:border-blue-500 transition-all duration-200 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                                    <input type="checkbox" name="record_types[]" value="AAAA" class="sr-only peer" checked>
                                    <div class="flex items-center gap-2 w-full">
                                        <div class="w-2 h-2 rounded-full border-2 border-gray-400 peer-checked:border-blue-500 peer-checked:bg-blue-500"></div>
                                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 peer-checked:text-blue-600 dark:peer-checked:text-blue-400">AAAA</span>
                                    </div>
                                </label>

                                <label class="relative flex items-center p-4 bg-white dark:bg-gray-700 rounded-xl border-2 border-gray-200 dark:border-gray-600 cursor-pointer hover:border-blue-500 dark:hover:border-blue-500 transition-all duration-200 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                                    <input type="checkbox" name="record_types[]" value="CNAME" class="sr-only peer" checked>
                                    <div class="flex items-center gap-2 w-full">
                                        <div class="w-2 h-2 rounded-full border-2 border-gray-400 peer-checked:border-blue-500 peer-checked:bg-blue-500"></div>
                                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 peer-checked:text-blue-600 dark:peer-checked:text-blue-400">CNAME</span>
                                    </div>
                                </label>

                                <label class="relative flex items-center p-4 bg-white dark:bg-gray-700 rounded-xl border-2 border-gray-200 dark:border-gray-600 cursor-pointer hover:border-blue-500 dark:hover:border-blue-500 transition-all duration-200 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                                    <input type="checkbox" name="record_types[]" value="MX" class="sr-only peer" checked>
                                    <div class="flex items-center gap-2 w-full">
                                        <div class="w-2 h-2 rounded-full border-2 border-gray-400 peer-checked:border-blue-500 peer-checked:bg-blue-500"></div>
                                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 peer-checked:text-blue-600 dark:peer-checked:text-blue-400">MX</span>
                                    </div>
                                </label>

                                <label class="relative flex items-center p-4 bg-white dark:bg-gray-700 rounded-xl border-2 border-gray-200 dark:border-gray-600 cursor-pointer hover:border-blue-500 dark:hover:border-blue-500 transition-all duration-200 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                                    <input type="checkbox" name="record_types[]" value="TXT" class="sr-only peer" checked>
                                    <div class="flex items-center gap-2 w-full">
                                        <div class="w-2 h-2 rounded-full border-2 border-gray-400 peer-checked:border-blue-500 peer-checked:bg-blue-500"></div>
                                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 peer-checked:text-blue-600 dark:peer-checked:text-blue-400">TXT</span>
                                    </div>
                                </label>

                                <label class="relative flex items-center p-4 bg-white dark:bg-gray-700 rounded-xl border-2 border-gray-200 dark:border-gray-600 cursor-pointer hover:border-blue-500 dark:hover:border-blue-500 transition-all duration-200 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                                    <input type="checkbox" name="record_types[]" value="NS" class="sr-only peer" checked>
                                    <div class="flex items-center gap-2 w-full">
                                        <div class="w-2 h-2 rounded-full border-2 border-gray-400 peer-checked:border-blue-500 peer-checked:bg-blue-500"></div>
                                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 peer-checked:text-blue-600 dark:peer-checked:text-blue-400">NS</span>
                                    </div>
                                </label>

                                <label class="relative flex items-center p-4 bg-white dark:bg-gray-700 rounded-xl border-2 border-gray-200 dark:border-gray-600 cursor-pointer hover:border-blue-500 dark:hover:border-blue-500 transition-all duration-200 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                                    <input type="checkbox" name="record_types[]" value="SOA" class="sr-only peer" checked>
                                    <div class="flex items-center gap-2 w-full">
                                        <div class="w-2 h-2 rounded-full border-2 border-gray-400 peer-checked:border-blue-500 peer-checked:bg-blue-500"></div>
                                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 peer-checked:text-blue-600 dark:peer-checked:text-blue-400">SOA</span>
                                    </div>
                                </label>

                                <label class="relative flex items-center p-4 bg-white dark:bg-gray-700 rounded-xl border-2 border-gray-200 dark:border-gray-600 cursor-pointer hover:border-blue-500 dark:hover:border-blue-500 transition-all duration-200 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                                    <input type="checkbox" name="record_types[]" value="PTR" class="sr-only peer">
                                    <div class="flex items-center gap-2 w-full">
                                        <div class="w-2 h-2 rounded-full border-2 border-gray-400 peer-checked:border-blue-500 peer-checked:bg-blue-500"></div>
                                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 peer-checked:text-blue-600 dark:peer-checked:text-blue-400">PTR</span>
                                    </div>
                                </label>

                                <label class="relative flex items-center p-4 bg-white dark:bg-gray-700 rounded-xl border-2 border-gray-200 dark:border-gray-600 cursor-pointer hover:border-blue-500 dark:hover:border-blue-500 transition-all duration-200 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                                    <input type="checkbox" name="record_types[]" value="CAA" class="sr-only peer">
                                    <div class="flex items-center gap-2 w-full">
                                        <div class="w-2 h-2 rounded-full border-2 border-gray-400 peer-checked:border-blue-500 peer-checked:bg-blue-500"></div>
                                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 peer-checked:text-blue-600 dark:peer-checked:text-blue-400">CAA</span>
                                    </div>
                                </label>

                                <label class="relative flex items-center p-4 bg-white dark:bg-gray-700 rounded-xl border-2 border-gray-200 dark:border-gray-600 cursor-pointer hover:border-blue-500 dark:hover:border-blue-500 transition-all duration-200 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                                    <input type="checkbox" name="record_types[]" value="SRV" class="sr-only peer">
                                    <div class="flex items-center gap-2 w-full">
                                        <div class="w-2 h-2 rounded-full border-2 border-gray-400 peer-checked:border-blue-500 peer-checked:bg-blue-500"></div>
                                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 peer-checked:text-blue-600 dark:peer-checked:text-blue-400">SRV</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-4 px-8 rounded-xl shadow-xl hover:shadow-2xl transform hover:scale-[1.02] transition-all duration-200 flex items-center justify-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <span id="dns-check-button-text" dir="auto">{{ __('frontend.check_dns_now') }}</span>
                        </button>
                    </form>
                </div>

                <!-- Loading State -->
                <div id="dns-loading" class="hidden p-8 bg-blue-50 dark:bg-gray-800 border-t-2 border-blue-200 dark:border-blue-800">
                    <div class="flex items-center justify-center gap-4">
                        <div class="relative">
                            <div class="w-12 h-12 border-4 border-blue-200 dark:border-blue-800 rounded-full"></div>
                            <div class="absolute top-0 left-0 w-12 h-12 border-4 border-blue-600 dark:border-blue-400 rounded-full animate-spin border-t-transparent"></div>
                        </div>
                        <div class="text-center">
                            <p class="text-lg font-bold text-blue-600 dark:text-blue-400" dir="auto">{{ __('frontend.checking_dns') }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400" dir="auto">{{ __('frontend.please_wait') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Error Display -->
                <div id="dns-error" class="hidden p-6 bg-red-50 dark:bg-red-900/20 border-t-2 border-red-200 dark:border-red-800">
                    <div class="flex items-start gap-4">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="text-lg font-bold text-red-800 dark:text-red-400 mb-2" dir="auto">{{ __('frontend.dns_error_title') }}</h4>
                            <p id="dns-error-message" class="text-red-700 dark:text-red-300" dir="auto"></p>
                        </div>
                    </div>
                </div>

                <!-- Results Display -->
                <div id="dns-results" class="hidden">
                    <div class="p-8 bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border-t-2 border-green-200 dark:border-green-800">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white" dir="auto">{{ __('frontend.dns_results_for') }} <span id="checked-domain" class="text-green-600 dark:text-green-400"></span></h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400" dir="auto">{{ __('frontend.dns_check_completed') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- DNS Records -->
                    <div id="dns-records-container" class="divide-y divide-gray-200 dark:divide-gray-700">
                        <!-- Records will be inserted here by JavaScript -->
                    </div>
                </div>
            </div>

            <!-- DNS Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h4 class="font-bold text-gray-900 dark:text-white" dir="auto">{{ __('frontend.instant_results') }}</h4>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400" dir="auto">{{ __('frontend.instant_results_desc') }}</p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h4 class="font-bold text-gray-900 dark:text-white" dir="auto">{{ __('frontend.accurate_data') }}</h4>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400" dir="auto">{{ __('frontend.accurate_data_desc') }}</p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                            </svg>
                        </div>
                        <h4 class="font-bold text-gray-900 dark:text-white" dir="auto">{{ __('frontend.multiple_records') }}</h4>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400" dir="auto">{{ __('frontend.multiple_records_desc') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-br from-green-600 via-emerald-700 to-teal-800">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6" dir="auto">
                {{ __('frontend.ready_to_start') }}
            </h2>
            <p class="text-xl text-green-100 mb-10" dir="auto">
                {{ __('frontend.ready_to_start_desc') }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-3 bg-white text-green-600 font-bold py-4 px-8 rounded-2xl shadow-2xl hover:shadow-3xl transform hover:scale-105 transition-all duration-200">
                    <span dir="auto">{{ __('frontend.start_free_now') }}</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
                <button onclick="showIntercom()" class="inline-flex items-center justify-center gap-3 bg-white/20 backdrop-blur-sm text-white border-2 border-white font-bold py-4 px-8 rounded-2xl hover:bg-white/30 transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <span dir="auto">{{ __('frontend.contact_us') }}</span>
                </button>
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

@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 1s ease-out;
}

/* Smooth scroll behavior */
html {
    scroll-behavior: smooth;
    scroll-padding-top: 100px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('dns-checker-form');
    const loadingDiv = document.getElementById('dns-loading');
    const errorDiv = document.getElementById('dns-error');
    const resultsDiv = document.getElementById('dns-results');
    const errorMessage = document.getElementById('dns-error-message');
    const recordsContainer = document.getElementById('dns-records-container');
    const checkedDomainSpan = document.getElementById('checked-domain');
    const buttonText = document.getElementById('dns-check-button-text');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const domain = document.getElementById('dns-domain-input').value.trim();
        const checkboxes = form.querySelectorAll('input[name="record_types[]"]:checked');
        const recordTypes = Array.from(checkboxes).map(cb => cb.value);

        if (recordTypes.length === 0) {
            errorDiv.classList.remove('hidden');
            errorMessage.textContent = '{{ __("frontend.select_at_least_one_record") }}';
            setTimeout(() => errorDiv.classList.add('hidden'), 3000);
            return;
        }

        // Hide previous results and errors
        errorDiv.classList.add('hidden');
        resultsDiv.classList.add('hidden');
        
        // Show loading
        loadingDiv.classList.remove('hidden');
        buttonText.textContent = '{{ __("frontend.checking") }}...';

        try {
            const response = await fetch('{{ route("domains.freedns.check") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    domain: domain,
                    record_types: recordTypes
                })
            });

            const data = await response.json();

            // Hide loading
            loadingDiv.classList.add('hidden');
            buttonText.textContent = '{{ __("frontend.check_dns_now") }}';

            if (data.success) {
                displayResults(domain, data.records);
            } else {
                showError(data.message || '{{ __("frontend.dns_check_failed") }}');
            }
        } catch (error) {
            loadingDiv.classList.add('hidden');
            buttonText.textContent = '{{ __("frontend.check_dns_now") }}';
            showError('{{ __("frontend.dns_network_error") }}');
        }
    });

    function showError(message) {
        errorDiv.classList.remove('hidden');
        errorMessage.textContent = message;
        errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function displayResults(domain, records) {
        checkedDomainSpan.textContent = domain;
        recordsContainer.innerHTML = '';

        const recordTypeColors = {
            'A': { bg: 'bg-gradient-to-br from-green-50 to-emerald-100 dark:from-green-900/20 dark:to-emerald-900/30', border: 'border-green-300 dark:border-green-700', icon: 'text-green-600 dark:text-green-400', badge: 'bg-green-500' },
            'AAAA': { bg: 'bg-gradient-to-br from-yellow-50 to-amber-100 dark:from-yellow-900/20 dark:to-amber-900/30', border: 'border-yellow-300 dark:border-yellow-700', icon: 'text-yellow-600 dark:text-yellow-400', badge: 'bg-yellow-500' },
            'CNAME': { bg: 'bg-gradient-to-br from-blue-50 to-cyan-100 dark:from-blue-900/20 dark:to-cyan-900/30', border: 'border-blue-300 dark:border-blue-700', icon: 'text-blue-600 dark:text-blue-400', badge: 'bg-blue-500' },
            'MX': { bg: 'bg-gradient-to-br from-purple-50 to-fuchsia-100 dark:from-purple-900/20 dark:to-fuchsia-900/30', border: 'border-purple-300 dark:border-purple-700', icon: 'text-purple-600 dark:text-purple-400', badge: 'bg-purple-500' },
            'TXT': { bg: 'bg-gradient-to-br from-orange-50 to-red-100 dark:from-orange-900/20 dark:to-red-900/30', border: 'border-orange-300 dark:border-orange-700', icon: 'text-orange-600 dark:text-orange-400', badge: 'bg-orange-500' },
            'NS': { bg: 'bg-gradient-to-br from-teal-50 to-cyan-100 dark:from-teal-900/20 dark:to-cyan-900/30', border: 'border-teal-300 dark:border-teal-700', icon: 'text-teal-600 dark:text-teal-400', badge: 'bg-teal-500' },
            'SOA': { bg: 'bg-gradient-to-br from-indigo-50 to-blue-100 dark:from-indigo-900/20 dark:to-blue-900/30', border: 'border-indigo-300 dark:border-indigo-700', icon: 'text-indigo-600 dark:text-indigo-400', badge: 'bg-indigo-500' },
            'CAA': { bg: 'bg-gradient-to-br from-rose-50 to-pink-100 dark:from-rose-900/20 dark:to-pink-900/30', border: 'border-rose-300 dark:border-rose-700', icon: 'text-rose-600 dark:text-rose-400', badge: 'bg-rose-500' },
            'PTR': { bg: 'bg-gradient-to-br from-pink-50 to-rose-100 dark:from-pink-900/20 dark:to-rose-900/30', border: 'border-pink-300 dark:border-pink-700', icon: 'text-pink-600 dark:text-pink-400', badge: 'bg-pink-500' },
            'SRV': { bg: 'bg-gradient-to-br from-violet-50 to-purple-100 dark:from-violet-900/20 dark:to-purple-900/30', border: 'border-violet-300 dark:border-violet-700', icon: 'text-violet-600 dark:text-violet-400', badge: 'bg-violet-500' }
        };

        if (Object.keys(records).length === 0) {
            recordsContainer.innerHTML = `
                <div class="p-8 text-center">
                    <div class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                    </div>
                    <p class="text-lg font-semibold text-gray-600 dark:text-gray-400" dir="auto">{{ __("frontend.no_dns_records_found") }}</p>
                </div>
            `;
        } else {
            for (const [type, values] of Object.entries(records)) {
                const colors = recordTypeColors[type] || recordTypeColors['A'];
                const recordHtml = createRecordSection(type, values, colors);
                recordsContainer.insertAdjacentHTML('beforeend', recordHtml);
            }
        }

        resultsDiv.classList.remove('hidden');
        resultsDiv.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function createRecordSection(type, values, colors) {
        const isRtl = document.dir === 'rtl';
        const recordCount = Array.isArray(values) ? values.length : 0;
        
        // Get icon based on type
        const getRecordIcon = (type) => {
            const icons = {
                'A': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>',
                'AAAA': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>',
                'CNAME': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>',
                'MX': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>',
                'TXT': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>',
                'NS': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>',
                'SOA': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>',
                'CAA': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>',
                'PTR': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path>',
                'SRV': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>'
            };
            return icons[type] || icons['A'];
        };
        
        let valuesHtml = '';
        if (Array.isArray(values) && values.length > 0) {
            valuesHtml = values.map((value, index) => {
                if (typeof value === 'object') {
                    // For complex records (MX, SOA, A with TTL, etc.)
                    const details = Object.entries(value)
                        .filter(([key, val]) => val !== null && val !== '') // Filter out null/empty values
                        .map(([key, val]) => {
                            // Special formatting for specific fields
                            if (key.toLowerCase() === 'ttl') {
                                return `
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 rounded-full text-xs font-medium">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>${val}s</span>
                                    </div>`;
                            } else if (key.toLowerCase().includes('priority') || key.toLowerCase().includes('weight') || key.toLowerCase().includes('port')) {
                                return `
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-purple-100 dark:bg-purple-900/50 text-purple-700 dark:text-purple-300 rounded-full text-xs font-medium">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                                        </svg>
                                        <span class="font-semibold">${key}:</span> <span>${val}</span>
                                    </div>`;
                            } else if (key.toLowerCase().includes('ip') || key === 'address') {
                                return `
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300 rounded-full text-xs font-mono">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                        </svg>
                                        ${val}
                                    </div>`;
                            } else if (key.toLowerCase().includes('target') || key.toLowerCase().includes('nameserver') || key.toLowerCase().includes('name')) {
                                return `
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full text-xs">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="font-semibold">${key}:</span> <span class="break-all">${val}</span>
                                    </div>`;
                            } else {
                                return `
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-400 rounded-full text-xs">
                                        <span class="font-semibold">${key}:</span> <span>${val}</span>
                                    </div>`;
                            }
                        })
                        .join('');
                    
                    return `<div class="group relative p-5 bg-white dark:bg-gray-800 rounded-xl border-2 border-gray-200 dark:border-gray-700 hover:border-${colors.badge.split('-')[1]}-400 dark:hover:border-${colors.badge.split('-')[1]}-500 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                        <div class="absolute top-3 ${isRtl ? 'left-3' : 'right-3'}">
                            <span class="inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white ${colors.badge} rounded-full shadow-lg">
                                ${index + 1}
                            </span>
                        </div>
                        <div class="flex flex-wrap items-center gap-2">
                            ${details}
                        </div>
                    </div>`;
                } else {
                    // For simple string values
                    return `<div class="group relative p-4 bg-white dark:bg-gray-800 rounded-xl border-2 border-gray-200 dark:border-gray-700 hover:border-${colors.badge.split('-')[1]}-400 dark:hover:border-${colors.badge.split('-')[1]}-500 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 w-8 h-8 ${colors.badge} rounded-lg flex items-center justify-center shadow-md">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 dark:text-gray-300 break-all font-mono text-sm flex-1">${value}</span>
                        </div>
                    </div>`;
                }
            }).join('');
        } else {
            valuesHtml = `<div class="p-6 text-center">
                <svg class="w-12 h-12 mx-auto text-gray-400 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <p class="text-gray-500 dark:text-gray-400 font-medium" dir="auto">{{ __("frontend.no_records_found") }}</p>
            </div>`;
        }

        return `
            <div class="mb-6 overflow-hidden rounded-2xl ${colors.bg} border-2 ${colors.border} shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="p-5 border-b-2 ${colors.border}">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="relative">
                                <div class="w-14 h-14 ${colors.badge} rounded-xl flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        ${getRecordIcon(type)}
                                    </svg>
                                </div>
                                <div class="absolute -top-1 -${isRtl ? 'left' : 'right'}-1 w-4 h-4 ${colors.badge} rounded-full animate-ping"></div>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold ${colors.icon} mb-1">${type} Records</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <span class="font-semibold">${recordCount}</span> ${recordCount === 1 ? '{{ __("frontend.record_found") }}' : '{{ __("frontend.records") }}'}
                                </p>
                            </div>
                        </div>
                        <div class="hidden sm:flex items-center gap-2 px-4 py-2 ${colors.bg} rounded-full border ${colors.border}">
                            <div class="w-2 h-2 ${colors.badge} rounded-full animate-pulse"></div>
                            <span class="text-xs font-medium ${colors.icon}">Active</span>
                        </div>
                    </div>
                </div>
                <div class="p-6 space-y-4 bg-white/50 dark:bg-gray-900/50">
                    ${valuesHtml}
                </div>
            </div>
        `;
    }
});
</script>

@endsection
