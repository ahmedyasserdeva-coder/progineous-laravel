@extends('frontend.layout')

@section('title', __('frontend.new_tlds_title') . ' - ' . config('app.name'))
@section('meta_description', __('frontend.new_tlds_meta_description'))
@section('meta_keywords', __('frontend.new_tlds_meta_keywords'))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    
    <!-- Hero Section -->
    <section class="relative py-16 md:py-24 overflow-hidden">
        <!-- Modern Background Pattern -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <!-- Grid Pattern -->
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#8080800a_1px,transparent_1px),linear-gradient(to_bottom,#8080800a_1px,transparent_1px)] bg-[size:14px_24px]"></div>
            
            <!-- Gradient Orbs -->
            <div class="absolute top-0 {{ app()->getLocale() == 'ar' ? 'right-0' : 'left-0' }} w-[500px] h-[500px] bg-gradient-to-br from-blue-500/20 via-indigo-500/20 to-transparent rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} w-[600px] h-[600px] bg-gradient-to-tl from-purple-500/20 via-pink-500/20 to-transparent rounded-full blur-3xl"></div>
            
            <!-- Floating Domain Extensions -->
            <div class="absolute top-20 {{ app()->getLocale() == 'ar' ? 'left-[10%]' : 'right-[10%]' }} animate-float hidden lg:block">
                <div class="px-4 py-2 bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-full border border-blue-200 dark:border-blue-800 shadow-lg">
                    <span class="text-sm font-bold text-blue-600 dark:text-blue-400">.tech</span>
                </div>
            </div>
            <div class="absolute top-40 {{ app()->getLocale() == 'ar' ? 'right-[15%]' : 'left-[15%]' }} animate-float animation-delay-1000 hidden lg:block">
                <div class="px-4 py-2 bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-full border border-indigo-200 dark:border-indigo-800 shadow-lg">
                    <span class="text-sm font-bold text-indigo-600 dark:text-indigo-400">.app</span>
                </div>
            </div>
            <div class="absolute bottom-32 {{ app()->getLocale() == 'ar' ? 'left-[20%]' : 'right-[20%]' }} animate-float animation-delay-2000 hidden lg:block">
                <div class="px-4 py-2 bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-full border border-purple-200 dark:border-purple-800 shadow-lg">
                    <span class="text-sm font-bold text-purple-600 dark:text-purple-400">.store</span>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-5xl mx-auto">
                <!-- Badge with Animation -->
                <div class="flex justify-center mb-8 animate-fade-in-down">
                    <div class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-500/10 via-indigo-500/10 to-purple-500/10 backdrop-blur-sm border border-blue-500/20 rounded-full shadow-lg">
                        <div class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
                        </div>
                        <span class="text-sm font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400">
                            {{ __('frontend.new_tlds_badge') }}
                        </span>
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </div>
                </div>

                <!-- Main Title with Gradient -->
                <h1 class="text-center mb-8 animate-fade-in-up px-4">
                    <span class="block text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-black leading-snug sm:leading-normal">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-slate-900 via-blue-900 to-slate-900 dark:from-slate-100 dark:via-blue-100 dark:to-slate-100">
                            {{ __('frontend.new_tlds_title') }}
                        </span>
                    </span>
                </h1>

                <!-- Subtitle with Better Typography -->
                <p class="text-center text-lg sm:text-xl md:text-2xl text-slate-600 dark:text-slate-300 mb-8 max-w-3xl mx-auto font-medium leading-relaxed animate-fade-in-up animation-delay-200 px-4">
                    {{ __('frontend.new_tlds_subtitle') }}
                </p>

                <!-- Description -->
                <p class="text-center text-sm sm:text-base md:text-lg text-slate-500 dark:text-slate-400 max-w-2xl mx-auto leading-loose animate-fade-in-up animation-delay-300 px-4">
                    {{ __('frontend.new_tlds_description') }}
                </p>
            </div>
        </div>
    </section>

    <!-- Stats Section - Professional Design -->
    <section class="relative py-16 md:py-24 overflow-hidden bg-gradient-to-b from-slate-50 via-white to-slate-50 dark:from-slate-900 dark:via-slate-900 dark:to-slate-900">
        <!-- Advanced Background Effects -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <!-- Gradient Orbs -->
            <div class="absolute top-20 {{ app()->getLocale() == 'ar' ? 'right-0' : 'left-0' }} w-96 h-96 bg-gradient-to-br from-blue-500/20 via-indigo-500/20 to-purple-500/20 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 {{ app()->getLocale() == 'ar' ? 'left-1/4' : 'right-1/4' }} w-[500px] h-[500px] bg-gradient-to-tl from-pink-500/15 via-purple-500/15 to-indigo-500/15 rounded-full blur-3xl"></div>
            
            <!-- Grid Pattern -->
            <div class="absolute inset-0 bg-[linear-gradient(rgba(99,102,241,0.03)_1px,transparent_1px),linear-gradient(90deg,rgba(99,102,241,0.03)_1px,transparent_1px)] bg-[size:64px_64px] [mask-image:radial-gradient(ellipse_80%_50%_at_50%_50%,black,transparent)]"></div>
            
            <!-- Floating Dots -->
            <div class="absolute top-1/4 {{ app()->getLocale() == 'ar' ? 'left-1/4' : 'right-1/4' }} w-2 h-2 bg-blue-500 rounded-full animate-ping opacity-75"></div>
            <div class="absolute bottom-1/3 {{ app()->getLocale() == 'ar' ? 'right-1/3' : 'left-1/3' }} w-2 h-2 bg-indigo-500 rounded-full animate-ping opacity-75" style="animation-delay: 0.5s"></div>
        </div>
        
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-500/10 via-indigo-500/10 to-purple-500/10 border border-blue-500/20 dark:border-blue-400/20 rounded-full mb-6">
                    <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                    <span class="text-sm font-semibold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 dark:from-blue-400 dark:via-indigo-400 dark:to-purple-400">
                        {{ __('frontend.trusted_by_thousands') }}
                    </span>
                </div>
                <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-black text-slate-900 dark:text-white mb-4 leading-tight sm:leading-snug px-4">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-slate-900 via-blue-900 to-slate-900 dark:from-white dark:via-blue-300 dark:to-white">
                        {{ __('frontend.join_our_community') }}
                    </span>
                </h2>
            </div>

            <!-- Stats Grid - Horizontal Scroll on Mobile -->
            <div class="overflow-x-auto pb-6 -mx-4 px-4 sm:overflow-visible sm:pb-0 sm:mx-0 sm:px-0 scrollbar-hide">
                <div class="flex gap-6 sm:grid sm:grid-cols-2 lg:grid-cols-4 sm:gap-8 min-w-max sm:min-w-0">
                    <!-- Stat 1 - Available TLDs -->
                    <div class="group flex-shrink-0 w-72 sm:w-auto">
                        <div class="relative h-full">
                            <!-- Glow Effect -->
                            <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-3xl opacity-0 group-hover:opacity-100 blur-xl transition-all duration-500"></div>
                            
                            <!-- Card -->
                            <div class="relative h-full bg-white dark:bg-slate-800 rounded-3xl p-8 transition-all duration-500 border-2 border-slate-100 dark:border-slate-700 group-hover:border-blue-500/50 dark:group-hover:border-blue-400/50 group-hover:-translate-y-2 group-hover:shadow-2xl overflow-hidden">
                                <!-- Background Pattern -->
                                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-500/5 to-transparent rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                                
                                <!-- Accent Line -->
                                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-blue-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                                
                                <div class="relative">
                                    <!-- Icon -->
                                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl mb-6 shadow-xl shadow-blue-500/30 transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                    </div>
                                    
                                    <!-- Number -->
                                    <div class="mb-3">
                                        <span class="text-6xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-blue-700 dark:from-blue-400 dark:to-blue-500 tracking-tight">500</span>
                                        <span class="text-4xl font-black text-blue-500 dark:text-blue-400">+</span>
                                    </div>
                                    
                                    <!-- Label -->
                                    <p class="text-base font-bold text-slate-700 dark:text-slate-300 mb-2">
                                        {{ __('frontend.available_tlds') }}
                                    </p>
                                    
                                    <!-- Description -->
                                    <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                                        {{ __('frontend.available_tlds_desc') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stat 2 - New Extensions -->
                    <div class="group flex-shrink-0 w-72 sm:w-auto">
                        <div class="relative h-full">
                            <!-- Glow Effect -->
                            <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-3xl opacity-0 group-hover:opacity-100 blur-xl transition-all duration-500"></div>
                            
                            <!-- Card -->
                            <div class="relative h-full bg-white dark:bg-slate-800 rounded-3xl p-8 transition-all duration-500 border-2 border-slate-100 dark:border-slate-700 group-hover:border-indigo-500/50 dark:group-hover:border-indigo-400/50 group-hover:-translate-y-2 group-hover:shadow-2xl overflow-hidden">
                                <!-- Background Pattern -->
                                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-indigo-500/5 to-transparent rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                                
                                <!-- Accent Line -->
                                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 to-indigo-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                                
                                <div class="relative">
                                    <!-- Icon -->
                                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl mb-6 shadow-xl shadow-indigo-500/30 transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                        </svg>
                                    </div>
                                    
                                    <!-- Number -->
                                    <div class="mb-3">
                                        <span class="text-6xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-indigo-700 dark:from-indigo-400 dark:to-indigo-500 tracking-tight">50</span>
                                        <span class="text-4xl font-black text-indigo-500 dark:text-indigo-400">+</span>
                                    </div>
                                    
                                    <!-- Label -->
                                    <p class="text-base font-bold text-slate-700 dark:text-slate-300 mb-2">
                                        {{ __('frontend.new_extensions') }}
                                    </p>
                                    
                                    <!-- Description -->
                                    <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                                        {{ __('frontend.new_extensions_desc') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stat 3 - Starting Price -->
                    <div class="group flex-shrink-0 w-72 sm:w-auto">
                        <div class="relative h-full">
                            <!-- Glow Effect -->
                            <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-500 to-purple-600 rounded-3xl opacity-0 group-hover:opacity-100 blur-xl transition-all duration-500"></div>
                            
                            <!-- Card -->
                            <div class="relative h-full bg-white dark:bg-slate-800 rounded-3xl p-8 transition-all duration-500 border-2 border-slate-100 dark:border-slate-700 group-hover:border-purple-500/50 dark:group-hover:border-purple-400/50 group-hover:-translate-y-2 group-hover:shadow-2xl overflow-hidden">
                                <!-- Background Pattern -->
                                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-purple-500/5 to-transparent rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                                
                                <!-- Accent Line -->
                                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-purple-500 to-purple-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                                
                                <div class="relative">
                                    <!-- Icon -->
                                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl mb-6 shadow-xl shadow-purple-500/30 transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    
                                    <!-- Number -->
                                    <div class="mb-3">
                                        <span class="text-4xl font-black text-purple-600 dark:text-purple-400">$</span>
                                        <span class="text-6xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-purple-700 dark:from-purple-400 dark:to-purple-500 tracking-tight">1</span>
                                        <span class="text-4xl font-black text-purple-500 dark:text-purple-400">+</span>
                                    </div>
                                    
                                    <!-- Label -->
                                    <p class="text-base font-bold text-slate-700 dark:text-slate-300 mb-2">
                                        {{ __('frontend.starting_from') }}
                                    </p>
                                    
                                    <!-- Description -->
                                    <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                                        {{ __('frontend.starting_from_desc') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stat 4 - 24/7 Activation -->
                    <div class="group flex-shrink-0 w-72 sm:w-auto">
                        <div class="relative h-full">
                            <!-- Glow Effect -->
                            <div class="absolute -inset-0.5 bg-gradient-to-r from-pink-500 to-pink-600 rounded-3xl opacity-0 group-hover:opacity-100 blur-xl transition-all duration-500"></div>
                            
                            <!-- Card -->
                            <div class="relative h-full bg-white dark:bg-slate-800 rounded-3xl p-8 transition-all duration-500 border-2 border-slate-100 dark:border-slate-700 group-hover:border-pink-500/50 dark:group-hover:border-pink-400/50 group-hover:-translate-y-2 group-hover:shadow-2xl overflow-hidden">
                                <!-- Background Pattern -->
                                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-pink-500/5 to-transparent rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                                
                                <!-- Accent Line -->
                                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-pink-500 to-pink-600 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                                
                                <div class="relative">
                                    <!-- Icon -->
                                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-pink-500 to-pink-600 rounded-2xl mb-6 shadow-xl shadow-pink-500/30 transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                        </svg>
                                    </div>
                                    
                                    <!-- Number -->
                                    <div class="mb-3">
                                        <span class="text-6xl font-black text-transparent bg-clip-text bg-gradient-to-r from-pink-600 to-pink-700 dark:from-pink-400 dark:to-pink-500 tracking-tight">24</span>
                                        <span class="text-4xl font-black text-pink-500 dark:text-pink-400">/7</span>
                                    </div>
                                    
                                    <!-- Label -->
                                    <p class="text-base font-bold text-slate-700 dark:text-slate-300 mb-2">
                                        {{ __('frontend.instant_activation') }}
                                    </p>
                                    
                                    <!-- Description -->
                                    <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                                        {{ __('frontend.instant_activation_desc_short') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile Scroll Indicator -->
            <div class="flex justify-center items-center gap-3 mt-8 sm:hidden">
                <svg class="w-5 h-5 text-slate-400 dark:text-slate-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                </svg>
                <span class="text-xs font-medium text-slate-500 dark:text-slate-500">Swipe to see more</span>
            </div>
        </div>

        <!-- Bottom Decorative Line -->
        <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-slate-200 dark:via-slate-800 to-transparent"></div>
    </section>

    <!-- Categories Section - Professional Design -->
    <section class="relative py-20 md:py-28 overflow-hidden bg-white dark:bg-slate-900">
        <!-- Background Effects -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <!-- Gradient Mesh -->
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-gradient-to-br from-blue-500/10 via-purple-500/10 to-pink-500/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-gradient-to-tl from-indigo-500/10 via-purple-500/10 to-blue-500/10 rounded-full blur-3xl"></div>
            
            <!-- Dot Pattern -->
            <div class="absolute inset-0 bg-[radial-gradient(rgba(99,102,241,0.08)_1px,transparent_1px)] bg-[size:24px_24px] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_50%,black,transparent)]"></div>
        </div>
        
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-500/10 via-purple-500/10 to-pink-500/10 border border-blue-500/20 dark:border-blue-400/20 rounded-full mb-6">
                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                    </svg>
                    <span class="text-sm font-semibold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 dark:from-blue-400 dark:via-purple-400 dark:to-pink-400">
                        {{ __('frontend.browse_by_category') }}
                    </span>
                </div>
                
                <!-- Title -->
                <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-black text-slate-900 dark:text-white mb-6 leading-tight sm:leading-snug px-4">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-slate-900 via-blue-900 to-slate-900 dark:from-white dark:via-blue-300 dark:to-white">
                        {{ __('frontend.browse_by_category_desc') }}
                    </span>
                </h2>
                
                <!-- Subtitle -->
                <p class="text-base sm:text-lg md:text-xl text-slate-600 dark:text-slate-400 max-w-3xl mx-auto leading-relaxed px-4">
                    {{ __('frontend.browse_category_subtitle') }}
                </p>
            </div>

            <!-- Categories Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                <!-- Technology Category -->
                <div class="group relative">
                    <!-- Glow Effect -->
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-3xl opacity-0 group-hover:opacity-75 blur-xl transition-all duration-500"></div>
                    
                    <!-- Card -->
                    <div class="relative h-full bg-white dark:bg-slate-800 rounded-3xl p-8 transition-all duration-500 border-2 border-slate-100 dark:border-slate-700 group-hover:border-blue-500/50 dark:group-hover:border-blue-400/50 group-hover:-translate-y-2 group-hover:shadow-2xl overflow-hidden">
                        <!-- Background Pattern -->
                        <div class="absolute top-0 {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} w-40 h-40 bg-gradient-to-br from-blue-500/10 to-transparent rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                        
                        <!-- Accent Corner -->
                        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-blue-500/20 to-transparent rounded-bl-3xl"></div>
                        
                        <div class="relative">
                            <!-- Icon -->
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl mb-6 shadow-xl shadow-blue-500/30 transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                                </svg>
                            </div>
                            
                            <!-- Title -->
                            <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-3">
                                {{ __('frontend.technology_tlds') }}
                            </h3>
                            
                            <!-- Description -->
                            <p class="text-sm text-slate-600 dark:text-slate-400 mb-6 leading-relaxed">
                                {{ __('frontend.technology_tlds_desc') }}
                            </p>
                            
                            <!-- TLD Count Badge -->
                            <div class="flex items-center gap-2 mb-4">
                                <div class="px-3 py-1.5 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                                    <span class="text-xs font-bold text-blue-700 dark:text-blue-300">15+ TLDs</span>
                                </div>
                                <div class="flex-1 h-px bg-gradient-to-r from-blue-500/50 to-transparent"></div>
                            </div>
                            
                            <!-- Example TLDs -->
                            <div class="flex flex-wrap gap-2 mb-6">
                                <span class="px-3 py-1.5 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 text-blue-700 dark:text-blue-300 rounded-lg text-sm font-bold border border-blue-200 dark:border-blue-800 hover:scale-105 transition-transform">.tech</span>
                                <span class="px-3 py-1.5 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 text-blue-700 dark:text-blue-300 rounded-lg text-sm font-bold border border-blue-200 dark:border-blue-800 hover:scale-105 transition-transform">.dev</span>
                                <span class="px-3 py-1.5 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 text-blue-700 dark:text-blue-300 rounded-lg text-sm font-bold border border-blue-200 dark:border-blue-800 hover:scale-105 transition-transform">.app</span>
                                <span class="px-3 py-1.5 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 text-blue-700 dark:text-blue-300 rounded-lg text-sm font-bold border border-blue-200 dark:border-blue-800 hover:scale-105 transition-transform">.io</span>
                                <span class="px-3 py-1.5 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 text-blue-700 dark:text-blue-300 rounded-lg text-sm font-bold border border-blue-200 dark:border-blue-800 hover:scale-105 transition-transform">.ai</span>
                            </div>
                            
                            <!-- View All Link -->
                            <a href="#tldPricingSection" class="category-filter inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 font-semibold text-sm hover:gap-3 transition-all duration-300" data-category="technology">
                                <span>{{ __('frontend.view_all_technology') }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Business Category -->
                <div class="group relative">
                    <!-- Glow Effect -->
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-3xl opacity-0 group-hover:opacity-75 blur-xl transition-all duration-500"></div>
                    
                    <!-- Card -->
                    <div class="relative h-full bg-white dark:bg-slate-800 rounded-3xl p-8 transition-all duration-500 border-2 border-slate-100 dark:border-slate-700 group-hover:border-indigo-500/50 dark:group-hover:border-indigo-400/50 group-hover:-translate-y-2 group-hover:shadow-2xl overflow-hidden">
                        <!-- Background Pattern -->
                        <div class="absolute top-0 {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} w-40 h-40 bg-gradient-to-br from-indigo-500/10 to-transparent rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                        
                        <!-- Accent Corner -->
                        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-indigo-500/20 to-transparent rounded-bl-3xl"></div>
                        
                        <div class="relative">
                            <!-- Icon -->
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl mb-6 shadow-xl shadow-indigo-500/30 transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            
                            <!-- Title -->
                            <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-3">
                                {{ __('frontend.business_tlds') }}
                            </h3>
                            
                            <!-- Description -->
                            <p class="text-sm text-slate-600 dark:text-slate-400 mb-6 leading-relaxed">
                                {{ __('frontend.business_tlds_desc') }}
                            </p>
                            
                            <!-- TLD Count Badge -->
                            <div class="flex items-center gap-2 mb-4">
                                <div class="px-3 py-1.5 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                                    <span class="text-xs font-bold text-indigo-700 dark:text-indigo-300">12+ TLDs</span>
                                </div>
                                <div class="flex-1 h-px bg-gradient-to-r from-indigo-500/50 to-transparent"></div>
                            </div>
                            
                            <!-- Example TLDs -->
                            <div class="flex flex-wrap gap-2 mb-6">
                                <span class="px-3 py-1.5 bg-gradient-to-r from-indigo-50 to-indigo-100 dark:from-indigo-900/20 dark:to-indigo-800/20 text-indigo-700 dark:text-indigo-300 rounded-lg text-sm font-bold border border-indigo-200 dark:border-indigo-800 hover:scale-105 transition-transform">.co</span>
                                <span class="px-3 py-1.5 bg-gradient-to-r from-indigo-50 to-indigo-100 dark:from-indigo-900/20 dark:to-indigo-800/20 text-indigo-700 dark:text-indigo-300 rounded-lg text-sm font-bold border border-indigo-200 dark:border-indigo-800 hover:scale-105 transition-transform">.biz</span>
                                <span class="px-3 py-1.5 bg-gradient-to-r from-indigo-50 to-indigo-100 dark:from-indigo-900/20 dark:to-indigo-800/20 text-indigo-700 dark:text-indigo-300 rounded-lg text-sm font-bold border border-indigo-200 dark:border-indigo-800 hover:scale-105 transition-transform">.company</span>
                                <span class="px-3 py-1.5 bg-gradient-to-r from-indigo-50 to-indigo-100 dark:from-indigo-900/20 dark:to-indigo-800/20 text-indigo-700 dark:text-indigo-300 rounded-lg text-sm font-bold border border-indigo-200 dark:border-indigo-800 hover:scale-105 transition-transform">.solutions</span>
                            </div>
                            
                            <!-- View All Link -->
                            <a href="#tldPricingSection" class="category-filter inline-flex items-center gap-2 text-indigo-600 dark:text-indigo-400 font-semibold text-sm hover:gap-3 transition-all duration-300" data-category="business">
                                <span>{{ __('frontend.view_all_business') }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- E-commerce Category -->
                <div class="group relative">
                    <!-- Glow Effect -->
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-500 to-purple-600 rounded-3xl opacity-0 group-hover:opacity-75 blur-xl transition-all duration-500"></div>
                    
                    <!-- Card -->
                    <div class="relative h-full bg-white dark:bg-slate-800 rounded-3xl p-8 transition-all duration-500 border-2 border-slate-100 dark:border-slate-700 group-hover:border-purple-500/50 dark:group-hover:border-purple-400/50 group-hover:-translate-y-2 group-hover:shadow-2xl overflow-hidden">
                        <!-- Background Pattern -->
                        <div class="absolute top-0 {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} w-40 h-40 bg-gradient-to-br from-purple-500/10 to-transparent rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                        
                        <!-- Accent Corner -->
                        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-purple-500/20 to-transparent rounded-bl-3xl"></div>
                        
                        <div class="relative">
                            <!-- Icon -->
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl mb-6 shadow-xl shadow-purple-500/30 transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            
                            <!-- Title -->
                            <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-3">
                                {{ __('frontend.ecommerce_tlds') }}
                            </h3>
                            
                            <!-- Description -->
                            <p class="text-sm text-slate-600 dark:text-slate-400 mb-6 leading-relaxed">
                                {{ __('frontend.ecommerce_tlds_desc') }}
                            </p>
                            
                            <!-- TLD Count Badge -->
                            <div class="flex items-center gap-2 mb-4">
                                <div class="px-3 py-1.5 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                                    <span class="text-xs font-bold text-purple-700 dark:text-purple-300">10+ TLDs</span>
                                </div>
                                <div class="flex-1 h-px bg-gradient-to-r from-purple-500/50 to-transparent"></div>
                            </div>
                            
                            <!-- Example TLDs -->
                            <div class="flex flex-wrap gap-2 mb-6">
                                <span class="px-3 py-1.5 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 text-purple-700 dark:text-purple-300 rounded-lg text-sm font-bold border border-purple-200 dark:border-purple-800 hover:scale-105 transition-transform">.store</span>
                                <span class="px-3 py-1.5 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 text-purple-700 dark:text-purple-300 rounded-lg text-sm font-bold border border-purple-200 dark:border-purple-800 hover:scale-105 transition-transform">.shop</span>
                                <span class="px-3 py-1.5 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 text-purple-700 dark:text-purple-300 rounded-lg text-sm font-bold border border-purple-200 dark:border-purple-800 hover:scale-105 transition-transform">.market</span>
                                <span class="px-3 py-1.5 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 text-purple-700 dark:text-purple-300 rounded-lg text-sm font-bold border border-purple-200 dark:border-purple-800 hover:scale-105 transition-transform">.buy</span>
                            </div>
                            
                            <!-- View All Link -->
                            <a href="#tldPricingSection" class="category-filter inline-flex items-center gap-2 text-purple-600 dark:text-purple-400 font-semibold text-sm hover:gap-3 transition-all duration-300" data-category="ecommerce">
                                <span>{{ __('frontend.view_all_ecommerce') }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Creative Category -->
                <div class="group relative">
                    <!-- Glow Effect -->
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-pink-500 to-pink-600 rounded-3xl opacity-0 group-hover:opacity-75 blur-xl transition-all duration-500"></div>
                    
                    <!-- Card -->
                    <div class="relative h-full bg-white dark:bg-slate-800 rounded-3xl p-8 transition-all duration-500 border-2 border-slate-100 dark:border-slate-700 group-hover:border-pink-500/50 dark:group-hover:border-pink-400/50 group-hover:-translate-y-2 group-hover:shadow-2xl overflow-hidden">
                        <!-- Background Pattern -->
                        <div class="absolute top-0 {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} w-40 h-40 bg-gradient-to-br from-pink-500/10 to-transparent rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                        
                        <!-- Accent Corner -->
                        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-pink-500/20 to-transparent rounded-bl-3xl"></div>
                        
                        <div class="relative">
                            <!-- Icon -->
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-pink-500 to-pink-600 rounded-2xl mb-6 shadow-xl shadow-pink-500/30 transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                                </svg>
                            </div>
                            
                            <!-- Title -->
                            <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-3">
                                {{ __('frontend.creative_tlds') }}
                            </h3>
                            
                            <!-- Description -->
                            <p class="text-sm text-slate-600 dark:text-slate-400 mb-6 leading-relaxed">
                                {{ __('frontend.creative_tlds_desc') }}
                            </p>
                            
                            <!-- TLD Count Badge -->
                            <div class="flex items-center gap-2 mb-4">
                                <div class="px-3 py-1.5 bg-pink-100 dark:bg-pink-900/30 rounded-lg">
                                    <span class="text-xs font-bold text-pink-700 dark:text-pink-300">14+ TLDs</span>
                                </div>
                                <div class="flex-1 h-px bg-gradient-to-r from-pink-500/50 to-transparent"></div>
                            </div>
                            
                            <!-- Example TLDs -->
                            <div class="flex flex-wrap gap-2 mb-6">
                                <span class="px-3 py-1.5 bg-gradient-to-r from-pink-50 to-pink-100 dark:from-pink-900/20 dark:to-pink-800/20 text-pink-700 dark:text-pink-300 rounded-lg text-sm font-bold border border-pink-200 dark:border-pink-800 hover:scale-105 transition-transform">.design</span>
                                <span class="px-3 py-1.5 bg-gradient-to-r from-pink-50 to-pink-100 dark:from-pink-900/20 dark:to-pink-800/20 text-pink-700 dark:text-pink-300 rounded-lg text-sm font-bold border border-pink-200 dark:border-pink-800 hover:scale-105 transition-transform">.art</span>
                                <span class="px-3 py-1.5 bg-gradient-to-r from-pink-50 to-pink-100 dark:from-pink-900/20 dark:to-pink-800/20 text-pink-700 dark:text-pink-300 rounded-lg text-sm font-bold border border-pink-200 dark:border-pink-800 hover:scale-105 transition-transform">.media</span>
                                <span class="px-3 py-1.5 bg-gradient-to-r from-pink-50 to-pink-100 dark:from-pink-900/20 dark:to-pink-800/20 text-pink-700 dark:text-pink-300 rounded-lg text-sm font-bold border border-pink-200 dark:border-pink-800 hover:scale-105 transition-transform">.studio</span>
                            </div>
                            
                            <!-- View All Link -->
                            <a href="#tldPricingSection" class="category-filter inline-flex items-center gap-2 text-pink-600 dark:text-pink-400 font-semibold text-sm hover:gap-3 transition-all duration-300" data-category="creative">
                                <span>{{ __('frontend.view_all_creative') }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Community Category -->
                <div class="group relative">
                    <!-- Glow Effect -->
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-3xl opacity-0 group-hover:opacity-75 blur-xl transition-all duration-500"></div>
                    
                    <!-- Card -->
                    <div class="relative h-full bg-white dark:bg-slate-800 rounded-3xl p-8 transition-all duration-500 border-2 border-slate-100 dark:border-slate-700 group-hover:border-emerald-500/50 dark:group-hover:border-emerald-400/50 group-hover:-translate-y-2 group-hover:shadow-2xl overflow-hidden">
                        <!-- Background Pattern -->
                        <div class="absolute top-0 {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} w-40 h-40 bg-gradient-to-br from-emerald-500/10 to-transparent rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                        
                        <!-- Accent Corner -->
                        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-emerald-500/20 to-transparent rounded-bl-3xl"></div>
                        
                        <div class="relative">
                            <!-- Icon -->
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl mb-6 shadow-xl shadow-emerald-500/30 transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            
                            <!-- Title -->
                            <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-3">
                                {{ __('frontend.community_tlds') }}
                            </h3>
                            
                            <!-- Description -->
                            <p class="text-sm text-slate-600 dark:text-slate-400 mb-6 leading-relaxed">
                                {{ __('frontend.community_tlds_desc') }}
                            </p>
                            
                            <!-- TLD Count Badge -->
                            <div class="flex items-center gap-2 mb-4">
                                <div class="px-3 py-1.5 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg">
                                    <span class="text-xs font-bold text-emerald-700 dark:text-emerald-300">8+ TLDs</span>
                                </div>
                                <div class="flex-1 h-px bg-gradient-to-r from-emerald-500/50 to-transparent"></div>
                            </div>
                            
                            <!-- Example TLDs -->
                            <div class="flex flex-wrap gap-2 mb-6">
                                <span class="px-3 py-1.5 bg-gradient-to-r from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 text-emerald-700 dark:text-emerald-300 rounded-lg text-sm font-bold border border-emerald-200 dark:border-emerald-800 hover:scale-105 transition-transform">.community</span>
                                <span class="px-3 py-1.5 bg-gradient-to-r from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 text-emerald-700 dark:text-emerald-300 rounded-lg text-sm font-bold border border-emerald-200 dark:border-emerald-800 hover:scale-105 transition-transform">.social</span>
                                <span class="px-3 py-1.5 bg-gradient-to-r from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 text-emerald-700 dark:text-emerald-300 rounded-lg text-sm font-bold border border-emerald-200 dark:border-emerald-800 hover:scale-105 transition-transform">.club</span>
                                <span class="px-3 py-1.5 bg-gradient-to-r from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 text-emerald-700 dark:text-emerald-300 rounded-lg text-sm font-bold border border-emerald-200 dark:border-emerald-800 hover:scale-105 transition-transform">.network</span>
                            </div>
                            
                            <!-- View All Link -->
                            <a href="#tldPricingSection" class="category-filter inline-flex items-center gap-2 text-emerald-600 dark:text-emerald-400 font-semibold text-sm hover:gap-3 transition-all duration-300" data-category="community">
                                <span>{{ __('frontend.view_all_community') }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Personal Category -->
                <div class="group relative">
                    <!-- Glow Effect -->
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-amber-500 to-amber-600 rounded-3xl opacity-0 group-hover:opacity-75 blur-xl transition-all duration-500"></div>
                    
                    <!-- Card -->
                    <div class="relative h-full bg-white dark:bg-slate-800 rounded-3xl p-8 transition-all duration-500 border-2 border-slate-100 dark:border-slate-700 group-hover:border-amber-500/50 dark:group-hover:border-amber-400/50 group-hover:-translate-y-2 group-hover:shadow-2xl overflow-hidden">
                        <!-- Background Pattern -->
                        <div class="absolute top-0 {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} w-40 h-40 bg-gradient-to-br from-amber-500/10 to-transparent rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                        
                        <!-- Accent Corner -->
                        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-amber-500/20 to-transparent rounded-bl-3xl"></div>
                        
                        <div class="relative">
                            <!-- Icon -->
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl mb-6 shadow-xl shadow-amber-500/30 transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            
                            <!-- Title -->
                            <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-3">
                                {{ __('frontend.personal_tlds') }}
                            </h3>
                            
                            <!-- Description -->
                            <p class="text-sm text-slate-600 dark:text-slate-400 mb-6 leading-relaxed">
                                {{ __('frontend.personal_tlds_desc') }}
                            </p>
                            
                            <!-- TLD Count Badge -->
                            <div class="flex items-center gap-2 mb-4">
                                <div class="px-3 py-1.5 bg-amber-100 dark:bg-amber-900/30 rounded-lg">
                                    <span class="text-xs font-bold text-amber-700 dark:text-amber-300">7+ TLDs</span>
                                </div>
                                <div class="flex-1 h-px bg-gradient-to-r from-amber-500/50 to-transparent"></div>
                            </div>
                            
                            <!-- Example TLDs -->
                            <div class="flex flex-wrap gap-2 mb-6">
                                <span class="px-3 py-1.5 bg-gradient-to-r from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-800/20 text-amber-700 dark:text-amber-300 rounded-lg text-sm font-bold border border-amber-200 dark:border-amber-800 hover:scale-105 transition-transform">.me</span>
                                <span class="px-3 py-1.5 bg-gradient-to-r from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-800/20 text-amber-700 dark:text-amber-300 rounded-lg text-sm font-bold border border-amber-200 dark:border-amber-800 hover:scale-105 transition-transform">.name</span>
                                <span class="px-3 py-1.5 bg-gradient-to-r from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-800/20 text-amber-700 dark:text-amber-300 rounded-lg text-sm font-bold border border-amber-200 dark:border-amber-800 hover:scale-105 transition-transform">.bio</span>
                                <span class="px-3 py-1.5 bg-gradient-to-r from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-800/20 text-amber-700 dark:text-amber-300 rounded-lg text-sm font-bold border border-amber-200 dark:border-amber-800 hover:scale-105 transition-transform">.life</span>
                            </div>
                            
                            <!-- View All Link -->
                            <a href="#tldPricingSection" class="category-filter inline-flex items-center gap-2 text-amber-600 dark:text-amber-400 font-semibold text-sm hover:gap-3 transition-all duration-300" data-category="personal">
                                <span>{{ __('frontend.view_all_personal') }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- TLD Pricing Grid Section -->
        </div>
    </section>

    <!-- TLD Pricing Table Section -->
    <section id="tldPricingSection" class="py-16 bg-white/30 dark:bg-slate-800/30 backdrop-blur-sm">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-slate-800 dark:text-slate-100 mb-4 leading-tight sm:leading-snug px-4">
                    {{ __('frontend.all_new_tlds') }}
                </h2>
                <p class="text-base sm:text-lg text-slate-600 dark:text-slate-400 px-4">
                    {{ __('frontend.all_new_tlds_desc') }}
                </p>
            </div>

            <!-- Filter Indicator -->
            <div id="filterIndicator" class="hidden max-w-2xl mx-auto mb-6">
                <div class="flex items-center justify-between bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl px-6 py-3">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        <span class="font-semibold text-blue-700 dark:text-blue-300">
                            {{ app()->getLocale() == 'ar' ? 'تصفية حسب:' : 'Filtering by:' }}
                            <span id="filterCategoryName" class="font-black"></span>
                        </span>
                    </div>
                    <button id="clearFilter" class="text-sm font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 flex items-center gap-2">
                        <span>{{ app()->getLocale() == 'ar' ? 'إزالة التصفية' : 'Clear Filter' }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Search Box -->
            <div class="max-w-2xl mx-auto mb-12">
                <div class="relative">
                    <input type="text" 
                           id="tldSearch"
                           placeholder="{{ __('frontend.search_tlds') }}"
                           class="w-full px-6 py-4 {{ app()->getLocale() == 'ar' ? 'pr-14' : 'pl-14' }} bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 rounded-2xl focus:border-blue-500 dark:focus:border-blue-400 focus:ring-4 focus:ring-blue-500/20 outline-none transition-all duration-300 text-slate-800 dark:text-slate-100">
                    <svg class="absolute {{ app()->getLocale() == 'ar' ? 'right-5' : 'left-5' }} top-1/2 transform -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>

            <!-- TLD Pricing Grid -->
            <div id="tldGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @forelse($newTlds as $tld)
                @php
                    // تحديد الفئة حسب TLD
                    $category = 'other';
                    $tldName = strtolower($tld['tld']);
                    
                    // Technology
                    if (in_array($tldName, ['tech', 'dev', 'app', 'io', 'ai', 'digital', 'software', 'cloud', 'data', 'code', 'web', 'online', 'network', 'systems', 'solutions'])) {
                        $category = 'technology';
                    }
                    // Business
                    elseif (in_array($tldName, ['co', 'biz', 'company', 'solutions', 'services', 'agency', 'consulting', 'group', 'ventures', 'enterprises', 'inc', 'llc'])) {
                        $category = 'business';
                    }
                    // E-commerce
                    elseif (in_array($tldName, ['store', 'shop', 'market', 'buy', 'sale', 'deals', 'shopping', 'boutique', 'trade', 'commerce'])) {
                        $category = 'ecommerce';
                    }
                    // Creative
                    elseif (in_array($tldName, ['design', 'art', 'media', 'studio', 'gallery', 'photo', 'photography', 'video', 'music', 'graphics', 'creative', 'artist', 'portfolio', 'works'])) {
                        $category = 'creative';
                    }
                    // Community
                    elseif (in_array($tldName, ['community', 'social', 'club', 'network', 'group', 'team', 'forum', 'chat', 'world', 'global'])) {
                        $category = 'community';
                    }
                    // Personal
                    elseif (in_array($tldName, ['me', 'name', 'bio', 'life', 'personal', 'blog', 'website', 'page', 'profile'])) {
                        $category = 'personal';
                    }
                @endphp
                <div class="tld-card group bg-white dark:bg-slate-800 rounded-xl p-4 shadow hover:shadow-xl transition-all duration-300 border-2 border-transparent hover:border-blue-500 cursor-pointer"
                     data-tld="{{ $tld['tld'] }}"
                     data-category="{{ $category }}">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}">
                                <span class="text-white font-bold text-sm">.{{ strtoupper(substr($tld['tld'], 0, 2)) }}</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100">.{{ $tld['tld'] }}</h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $tld['description'] }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pricing Details -->
                    <div class="space-y-2 mb-3">
                        <!-- Register Price -->
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-medium text-slate-600 dark:text-slate-400">{{ __('frontend.register_price') }}:</span>
                            <span class="text-lg font-bold text-blue-600 dark:text-blue-400">${{ number_format($tld['register_price'], 2) }}</span>
                        </div>
                        
                        <!-- Renew Price -->
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-medium text-slate-600 dark:text-slate-400">{{ __('frontend.renew_price') }}:</span>
                            <span class="text-sm font-semibold text-indigo-600 dark:text-indigo-400">${{ number_format($tld['renew_price'], 2) }}</span>
                        </div>
                        
                        <!-- Transfer Price -->
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-medium text-slate-600 dark:text-slate-400">{{ __('frontend.transfer_price') }}:</span>
                            <span class="text-sm font-semibold text-purple-600 dark:text-purple-400">${{ number_format($tld['transfer_price'], 2) }}</span>
                        </div>
                        
                        <!-- Grace Price (if available) -->
                        @if($tld['grace_price'])
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-medium text-slate-600 dark:text-slate-400">{{ __('frontend.grace_price') }}:</span>
                            <span class="text-sm font-semibold text-amber-600 dark:text-amber-400">${{ number_format($tld['grace_price'], 2) }}</span>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Action Button -->
                    <div class="pt-3 border-t border-slate-200 dark:border-slate-700">
                        <button class="w-full px-4 py-2.5 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white rounded-lg text-sm font-semibold transition-all duration-300 group-hover:scale-105 shadow-lg">
                            {{ __('frontend.register') }}
                        </button>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <svg class="w-16 h-16 text-slate-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-slate-600 dark:text-slate-400">{{ __('frontend.no_tlds_found') }}</p>
                </div>
                @endforelse
            </div>

            <!-- Show More Button -->
            @if($newTlds->count() > 20)
            <div class="text-center mt-12">
                <button id="showMoreBtn" class="px-8 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white rounded-xl font-semibold transition-all duration-300 hover:scale-105 shadow-lg">
                    {{ __('frontend.show_more') }}
                </button>
            </div>
            @endif
        </div>
    </section>

    <!-- Features Section -->
    <section class="relative py-24 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50/40 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900"></div>
        
        <!-- Animated Background Orbs -->
        <div class="absolute top-20 {{ app()->getLocale() == 'ar' ? 'left-10' : 'right-10' }} w-72 h-72 bg-blue-400/20 dark:bg-blue-500/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 {{ app()->getLocale() == 'ar' ? 'right-20' : 'left-20' }} w-96 h-96 bg-indigo-400/20 dark:bg-indigo-500/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        
        <!-- Dot Pattern Overlay -->
        <div class="absolute inset-0 opacity-30 dark:opacity-20" style="background-image: radial-gradient(circle at 1px 1px, rgb(148 163 184 / 0.3) 1px, transparent 0); background-size: 40px 40px;"></div>
        
        <div class="container mx-auto px-4 relative z-10">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500/10 dark:bg-blue-500/20 border border-blue-500/20 dark:border-blue-400/30 rounded-full mb-6">
                    <div class="w-2 h-2 bg-blue-500 dark:bg-blue-400 rounded-full animate-pulse"></div>
                    <span class="text-sm font-semibold text-blue-600 dark:text-blue-400 uppercase tracking-wider">
                        {{ __('frontend.features') }}
                    </span>
                </div>
                
                <!-- Title -->
                <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-black text-transparent bg-clip-text bg-gradient-to-r from-slate-900 via-blue-800 to-indigo-900 dark:from-slate-100 dark:via-blue-200 dark:to-indigo-200 mb-6 leading-tight sm:leading-snug px-4">
                    {{ __('frontend.why_choose_new_tlds') }}
                </h2>
                
                <!-- Subtitle -->
                <p class="text-base sm:text-lg md:text-xl text-slate-600 dark:text-slate-300 max-w-3xl mx-auto leading-relaxed px-4">
                    {{ __('frontend.why_choose_new_tlds_desc') }}
                </p>
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1: Memorable Names -->
                <div class="group relative">
                    <!-- Glow Effect -->
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-3xl opacity-0 group-hover:opacity-75 blur-xl transition-all duration-500"></div>
                    
                    <!-- Card -->
                    <div class="relative bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-3xl p-8 shadow-xl border border-slate-200/50 dark:border-slate-700/50 transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl">
                        <!-- Background Pattern -->
                        <div class="absolute top-0 {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} w-32 h-32 bg-gradient-to-br from-blue-500/10 to-blue-600/5 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-500"></div>
                        
                        <!-- Icon Container -->
                        <div class="relative mb-6">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 dark:from-blue-400 dark:to-blue-500 rounded-2xl shadow-lg group-hover:shadow-blue-500/50 group-hover:scale-110 transition-all duration-500">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <h3 class="text-2xl font-black text-slate-800 dark:text-slate-100 mb-3 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300">
                            {{ __('frontend.memorable_names') }}
                        </h3>
                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                            {{ __('frontend.memorable_names_desc') }}
                        </p>
                    </div>
                </div>

                <!-- Feature 2: Brand Identity -->
                <div class="group relative">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-3xl opacity-0 group-hover:opacity-75 blur-xl transition-all duration-500"></div>
                    <div class="relative bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-3xl p-8 shadow-xl border border-slate-200/50 dark:border-slate-700/50 transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl">
                        <div class="absolute top-0 {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} w-32 h-32 bg-gradient-to-br from-indigo-500/10 to-indigo-600/5 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-500"></div>
                        <div class="relative mb-6">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-indigo-500 to-indigo-600 dark:from-indigo-400 dark:to-indigo-500 rounded-2xl shadow-lg group-hover:shadow-indigo-500/50 group-hover:scale-110 transition-all duration-500">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-2xl font-black text-slate-800 dark:text-slate-100 mb-3 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-300">
                            {{ __('frontend.brand_identity') }}
                        </h3>
                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                            {{ __('frontend.brand_identity_desc') }}
                        </p>
                    </div>
                </div>

                <!-- Feature 3: SEO Benefits -->
                <div class="group relative">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-500 to-purple-600 rounded-3xl opacity-0 group-hover:opacity-75 blur-xl transition-all duration-500"></div>
                    <div class="relative bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-3xl p-8 shadow-xl border border-slate-200/50 dark:border-slate-700/50 transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl">
                        <div class="absolute top-0 {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} w-32 h-32 bg-gradient-to-br from-purple-500/10 to-purple-600/5 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-500"></div>
                        <div class="relative mb-6">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-purple-500 to-purple-600 dark:from-purple-400 dark:to-purple-500 rounded-2xl shadow-lg group-hover:shadow-purple-500/50 group-hover:scale-110 transition-all duration-500">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-2xl font-black text-slate-800 dark:text-slate-100 mb-3 group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors duration-300">
                            {{ __('frontend.seo_benefits') }}
                        </h3>
                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                            {{ __('frontend.seo_benefits_desc') }}
                        </p>
                    </div>
                </div>

                <!-- Feature 4: Affordable Pricing -->
                <div class="group relative">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-pink-500 to-pink-600 rounded-3xl opacity-0 group-hover:opacity-75 blur-xl transition-all duration-500"></div>
                    <div class="relative bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-3xl p-8 shadow-xl border border-slate-200/50 dark:border-slate-700/50 transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl">
                        <div class="absolute top-0 {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} w-32 h-32 bg-gradient-to-br from-pink-500/10 to-pink-600/5 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-500"></div>
                        <div class="relative mb-6">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-pink-500 to-pink-600 dark:from-pink-400 dark:to-pink-500 rounded-2xl shadow-lg group-hover:shadow-pink-500/50 group-hover:scale-110 transition-all duration-500">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-2xl font-black text-slate-800 dark:text-slate-100 mb-3 group-hover:text-pink-600 dark:group-hover:text-pink-400 transition-colors duration-300">
                            {{ __('frontend.affordable_pricing') }}
                        </h3>
                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                            {{ __('frontend.affordable_pricing_desc') }}
                        </p>
                    </div>
                </div>

                <!-- Feature 5: Instant Setup -->
                <div class="group relative">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-3xl opacity-0 group-hover:opacity-75 blur-xl transition-all duration-500"></div>
                    <div class="relative bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-3xl p-8 shadow-xl border border-slate-200/50 dark:border-slate-700/50 transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl">
                        <div class="absolute top-0 {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} w-32 h-32 bg-gradient-to-br from-emerald-500/10 to-emerald-600/5 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-500"></div>
                        <div class="relative mb-6">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-emerald-500 to-emerald-600 dark:from-emerald-400 dark:to-emerald-500 rounded-2xl shadow-lg group-hover:shadow-emerald-500/50 group-hover:scale-110 transition-all duration-500">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-2xl font-black text-slate-800 dark:text-slate-100 mb-3 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors duration-300">
                            {{ __('frontend.instant_setup') }}
                        </h3>
                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                            {{ __('frontend.instant_setup_desc') }}
                        </p>
                    </div>
                </div>

                <!-- Feature 6: Full Support -->
                <div class="group relative">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-amber-500 to-amber-600 rounded-3xl opacity-0 group-hover:opacity-75 blur-xl transition-all duration-500"></div>
                    <div class="relative bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-3xl p-8 shadow-xl border border-slate-200/50 dark:border-slate-700/50 transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl">
                        <div class="absolute top-0 {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} w-32 h-32 bg-gradient-to-br from-amber-500/10 to-amber-600/5 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-500"></div>
                        <div class="relative mb-6">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-amber-500 to-amber-600 dark:from-amber-400 dark:to-amber-500 rounded-2xl shadow-lg group-hover:shadow-amber-500/50 group-hover:scale-110 transition-all duration-500">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-2xl font-black text-slate-800 dark:text-slate-100 mb-3 group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors duration-300">
                            {{ __('frontend.full_support') }}
                        </h3>
                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                            {{ __('frontend.full_support_desc') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section - Enhanced Design -->
    <section class="relative py-16 md:py-20 overflow-hidden">
        <!-- Modern Gradient Background - Matching Other Sections -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-500 via-indigo-500 to-purple-600"></div>
        
        <!-- Animated Mesh Pattern -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_120%,rgba(99,102,241,0.4),rgba(255,255,255,0))]"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_80%_20%,rgba(168,85,247,0.3),rgba(255,255,255,0))]"></div>
        </div>
        
        <!-- Animated Orbs -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 {{ app()->getLocale() == 'ar' ? 'right-0' : 'left-0' }} w-72 h-72 bg-blue-400/20 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute top-1/2 {{ app()->getLocale() == 'ar' ? 'left-1/4' : 'right-1/4' }} w-80 h-80 bg-purple-400/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
            <div class="absolute -bottom-40 {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} w-72 h-72 bg-pink-400/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
        </div>
        
        <!-- Grid Pattern Overlay -->
        <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.05)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.05)_1px,transparent_1px)] bg-[size:100px_100px] [mask-image:radial-gradient(ellipse_80%_50%_at_50%_50%,black,transparent)]"></div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-5xl mx-auto">
                <!-- Badge -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/20 backdrop-blur-xl border border-white/30 rounded-full shadow-lg">
                        <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                        <span class="text-sm font-bold text-white uppercase tracking-wider">
                            {{ __('frontend.get_started') }}
                        </span>
                    </div>
                </div>
                
                <!-- Main Content -->
                <div class="text-center mb-12">
                    <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-black text-white mb-6 leading-tight sm:leading-snug px-4">
                        {{ __('frontend.ready_to_register') }}
                    </h2>
                    <p class="text-base sm:text-lg md:text-xl lg:text-2xl text-blue-50/90 max-w-3xl mx-auto leading-relaxed px-4 font-medium">
                        {{ __('frontend.ready_to_register_desc') }}
                    </p>
                </div>
                
                <!-- CTA Buttons - Enhanced -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center px-4">
                    <!-- Primary Button -->
                    <a href="{{ route('domains.search') }}" class="group relative inline-flex items-center justify-center px-8 py-4 sm:px-10 sm:py-5 bg-white text-blue-600 rounded-2xl font-bold overflow-hidden transition-all duration-300 hover:scale-105 shadow-2xl hover:shadow-white/25 w-full sm:w-auto">
                        <!-- Button Glow Effect -->
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-50 to-indigo-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        
                        <!-- Icon -->
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} relative z-10 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        
                        <!-- Text -->
                        <span class="relative z-10 text-base sm:text-lg">{{ __('frontend.search_now') }}</span>
                        
                        <!-- Arrow Animation -->
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 {{ app()->getLocale() == 'ar' ? 'mr-0 ml-2' : 'ml-2 mr-0' }} relative z-10 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                    
                    <!-- Secondary Button -->
                    <a href="{{ route('domains.transfer') }}" class="group relative inline-flex items-center justify-center px-8 py-4 sm:px-10 sm:py-5 bg-white/10 backdrop-blur-xl text-white border-2 border-white/40 rounded-2xl font-bold overflow-hidden transition-all duration-300 hover:scale-105 hover:bg-white/20 hover:border-white/60 shadow-xl w-full sm:w-auto">
                        <!-- Icon -->
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                        
                        <!-- Text -->
                        <span class="text-base sm:text-lg">{{ __('frontend.transfer_domain') }}</span>
                    </a>
                </div>
                
                <!-- Trust Indicators -->
                <div class="mt-12 pt-8 border-t border-white/20">
                    <div class="flex flex-wrap items-center justify-center gap-6 sm:gap-8 md:gap-12 text-white/80">
                        <!-- Indicator 1 -->
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm font-semibold">{{ __('frontend.instant_activation') }}</span>
                        </div>
                        
                        <!-- Indicator 2 -->
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm font-semibold">{{ __('frontend.secure_transfer') }}</span>
                        </div>
                        
                        <!-- Indicator 3 -->
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm font-semibold">{{ __('frontend.support_247') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // TLD Search Functionality
    const searchInput = document.getElementById('tldSearch');
    const tldCards = document.querySelectorAll('.tld-card');
    const filterIndicator = document.getElementById('filterIndicator');
    const filterCategoryName = document.getElementById('filterCategoryName');
    const clearFilterBtn = document.getElementById('clearFilter');
    
    let currentFilter = null;

    // Category names translation
    const categoryNames = {
        'technology': '{{ __("frontend.technology_tlds") }}',
        'business': '{{ __("frontend.business_tlds") }}',
        'ecommerce': '{{ __("frontend.ecommerce_tlds") }}',
        'creative': '{{ __("frontend.creative_tlds") }}',
        'community': '{{ __("frontend.community_tlds") }}',
        'personal': '{{ __("frontend.personal_tlds") }}'
    };

    // Category Filter Functionality
    const categoryFilters = document.querySelectorAll('.category-filter');
    categoryFilters.forEach(filter => {
        filter.addEventListener('click', function(e) {
            e.preventDefault();
            const category = this.getAttribute('data-category');
            currentFilter = category;
            
            // Show filter indicator
            filterIndicator.classList.remove('hidden');
            filterCategoryName.textContent = categoryNames[category];
            
            // Clear search
            if (searchInput) {
                searchInput.value = '';
            }
            
            // Filter cards
            filterByCategory(category);
            
            // Scroll to pricing section
            document.getElementById('tldPricingSection').scrollIntoView({ 
                behavior: 'smooth',
                block: 'start'
            });
        });
    });

    // Clear Filter
    if (clearFilterBtn) {
        clearFilterBtn.addEventListener('click', function() {
            currentFilter = null;
            filterIndicator.classList.add('hidden');
            showAllCards();
        });
    }

    // Filter by category function
    function filterByCategory(category) {
        tldCards.forEach(card => {
            const cardCategory = card.getAttribute('data-category');
            if (cardCategory === category) {
                card.style.display = '';
                card.classList.add('fade-in');
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Show all cards function
    function showAllCards() {
        tldCards.forEach(card => {
            card.style.display = '';
            card.classList.add('fade-in');
        });
    }

    // Search Functionality
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            
            // Clear category filter when searching
            if (searchTerm && currentFilter) {
                currentFilter = null;
                filterIndicator.classList.add('hidden');
            }
            
            tldCards.forEach(card => {
                const tld = card.getAttribute('data-tld').toLowerCase();
                const category = card.getAttribute('data-category');
                
                // Apply search filter
                if (tld.includes(searchTerm)) {
                    // If there's a category filter, apply it too
                    if (currentFilter) {
                        if (category === currentFilter) {
                            card.style.display = '';
                            card.classList.add('fade-in');
                        } else {
                            card.style.display = 'none';
                        }
                    } else {
                        card.style.display = '';
                        card.classList.add('fade-in');
                    }
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

    // Show More Functionality
    const showMoreBtn = document.getElementById('showMoreBtn');
    if (showMoreBtn) {
        let showing = 20;
        const tldGrid = document.getElementById('tldGrid');
        const allCards = Array.from(tldCards);
        
        // Initially hide cards beyond 20
        allCards.slice(20).forEach(card => card.style.display = 'none');
        
        showMoreBtn.addEventListener('click', function() {
            const hiddenCards = allCards.slice(showing, showing + 20);
            hiddenCards.forEach(card => {
                card.style.display = '';
                card.classList.add('fade-in');
            });
            showing += 20;
            
            if (showing >= allCards.length) {
                showMoreBtn.style.display = 'none';
            }
        });
    }

    // Register button click
    document.querySelectorAll('.tld-card button').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const card = e.target.closest('.tld-card');
            const tld = card.getAttribute('data-tld');
            window.location.href = '{{ route("domains.search") }}?tld=' + tld;
        });
    });
});
</script>

<style>
/* Fade In Animations */
.animate-fade-in-down {
    animation: fadeInDown 0.6s ease-out;
}

.animate-fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in {
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Animation Delays */
.animation-delay-200 {
    animation-delay: 0.2s;
}

.animation-delay-300 {
    animation-delay: 0.3s;
}

.animation-delay-400 {
    animation-delay: 0.4s;
}

.animation-delay-1000 {
    animation-delay: 1s;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

/* Float Animation for TLD Badges */
@keyframes float {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-15px);
    }
}

.animate-float {
    animation: float 4s ease-in-out infinite;
}

/* Pulse Animation for Badge Dot */
@keyframes ping {
    75%, 100% {
        transform: scale(2);
        opacity: 0;
    }
}

.animate-ping {
    animation: ping 1s cubic-bezier(0, 0, 0.2, 1) infinite;
}

/* Smooth Transitions */
* {
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
</style>
@endpush

@endsection
