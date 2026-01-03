@extends('frontend.layout')

@section('title', __('frontend.about_us'))

@section('content')
<!-- Unified Dark Background for Entire Page -->
<div class="relative bg-gradient-to-br from-[#0a0e27] via-[#111827] to-[#0a0e27] overflow-hidden">
    
    <!-- Continuous Grid Background Pattern -->
    <div class="absolute inset-0 overflow-hidden">
        <!-- Grid Lines -->
        <div class="absolute inset-0" style="background-image: linear-gradient(rgba(59, 130, 246, 0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(59, 130, 246, 0.03) 1px, transparent 1px); background-size: 50px 50px;"></div>
        
        <!-- Glowing Grid Lines -->
        <div class="absolute inset-0">
            <!-- Vertical Lines -->
            <div class="absolute top-0 bottom-0 left-[10%] w-px bg-gradient-to-b from-transparent via-blue-500/30 to-transparent"></div>
            <div class="absolute top-0 bottom-0 left-[25%] w-px bg-gradient-to-b from-transparent via-blue-500/20 to-transparent"></div>
            <div class="absolute top-0 bottom-0 right-[25%] w-px bg-gradient-to-b from-transparent via-blue-500/20 to-transparent"></div>
            <div class="absolute top-0 bottom-0 right-[10%] w-px bg-gradient-to-b from-transparent via-blue-500/30 to-transparent"></div>
            
            <!-- Horizontal Lines -->
            <div class="absolute left-0 right-0 top-[10%] h-px bg-gradient-to-r from-transparent via-blue-500/20 to-transparent"></div>
            <div class="absolute left-0 right-0 top-[30%] h-px bg-gradient-to-r from-transparent via-blue-500/30 to-transparent"></div>
            <div class="absolute left-0 right-0 top-[50%] h-px bg-gradient-to-r from-transparent via-blue-500/30 to-transparent"></div>
            <div class="absolute left-0 right-0 top-[70%] h-px bg-gradient-to-r from-transparent via-blue-500/20 to-transparent"></div>
            <div class="absolute left-0 right-0 top-[90%] h-px bg-gradient-to-r from-transparent via-blue-500/20 to-transparent"></div>
        </div>

        <!-- Animated Gradient Orbs -->
        <div class="absolute top-[5%] left-[15%] w-96 h-96 bg-blue-500/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute top-[25%] right-[10%] w-96 h-96 bg-purple-500/10 rounded-full blur-3xl animate-pulse animation-delay-2000"></div>
        <div class="absolute top-[50%] left-[20%] w-96 h-96 bg-cyan-500/10 rounded-full blur-3xl animate-pulse animation-delay-1000"></div>
        <div class="absolute top-[75%] right-[15%] w-96 h-96 bg-pink-500/10 rounded-full blur-3xl animate-pulse"></div>
    </div>
    
    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col items-center justify-center min-h-screen py-12 sm:py-16 lg:py-20 max-w-7xl mx-auto">
                
                <!-- Top Content - Centered -->
                <div class="space-y-6 sm:space-y-8 text-center w-full mb-12 sm:mb-16">
                    <!-- Badge with Premium Design -->
                    <div class="inline-flex items-center gap-2 sm:gap-3 px-4 sm:px-5 py-2 sm:py-2.5 bg-gradient-to-r from-blue-500/10 via-cyan-500/10 to-blue-500/10 border border-blue-400/30 rounded-full backdrop-blur-md shadow-lg shadow-blue-500/10">
                        <div class="relative flex items-center gap-2">
                            <div class="relative">
                                <div class="w-2 h-2 bg-blue-400 rounded-full animate-pulse"></div>
                                <div class="absolute inset-0 w-2 h-2 bg-blue-400 rounded-full animate-ping"></div>
                            </div>
                            <span class="text-xs sm:text-sm font-semibold bg-gradient-to-r from-blue-300 to-cyan-300 bg-clip-text text-transparent tracking-wide">
                                {{ __('frontend.industry_leader_since_2023') }}
                            </span>
                        </div>
                    </div>

                    <!-- Main Title with Enhanced Typography -->
                    <div class="space-y-4 sm:space-y-6">
                        <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl xl:text-8xl font-black text-white leading-tight tracking-tight">
                            {{ __('frontend.transforming_ideas') }}
                            <span class="block mt-2 sm:mt-4 bg-gradient-to-r from-blue-400 via-cyan-300 to-blue-400 bg-clip-text text-transparent animate-gradient">
                                {{ __('frontend.into_digital_reality') }}
                            </span>
                        </h1>
                        
                        <!-- Accent Line -->
                        <div class="flex items-center justify-center gap-2 sm:gap-3">
                            <div class="h-0.5 sm:h-1 w-12 sm:w-20 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full shadow-lg shadow-blue-500/50"></div>
                            <div class="text-xs sm:text-sm font-medium text-blue-400 tracking-widest uppercase">{{ __('frontend.precision_performance_perfection') }}</div>
                        </div>
                    </div>

                    <!-- Mission Statement -->
                    <div class="space-y-3 sm:space-y-4 max-w-4xl mx-auto">
                        <p class="text-lg sm:text-xl md:text-2xl text-gray-300 leading-relaxed font-light">
                            {{ __('frontend.we_dont_just_host') }}
                        </p>
                        <p class="text-base sm:text-lg text-gray-400 leading-relaxed">
                            {{ __('frontend.every_millisecond_matters') }}
                        </p>
                    </div>
                </div>

                <!-- Animated Diagram - Centered -->
                <div class="relative flex items-center justify-center w-full mb-12 sm:mb-16">
                    <!-- Main Cycle Container with Glow Effect -->
                    <div class="relative w-full max-w-xl lg:max-w-2xl aspect-square">
                        <!-- Outer Glow -->
                        <div class="absolute inset-[-20px] bg-gradient-to-r from-blue-500/5 via-cyan-500/5 to-blue-500/5 rounded-full blur-3xl"></div>
                        
                        <!-- Outer Dashed Circle with Animation -->
                        <div class="absolute inset-0 rounded-full border-2 border-dashed border-blue-500/30 animate-spin-slow"></div>
                        
                        <!-- Middle Circle -->
                        <div class="absolute inset-[10%] rounded-full border border-blue-500/20"></div>
                        
                        <!-- Inner Solid Circle with Gradient -->
                        <div class="absolute inset-[15%] rounded-full border border-blue-500/50 bg-gradient-to-br from-blue-500/10 via-transparent to-cyan-500/10 backdrop-blur-sm shadow-inner"></div>

                        <!-- Center Core with Pulse -->
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            <div class="relative w-32 sm:w-40 h-32 sm:h-40 rounded-full bg-gradient-to-br from-blue-500/30 to-purple-500/30 backdrop-blur-md border border-blue-400/50 flex items-center justify-center shadow-2xl shadow-blue-500/20">
                                <!-- Rotating Ring -->
                                <div class="absolute inset-0 rounded-full border-2 border-transparent border-t-blue-400 border-r-cyan-400 animate-spin"></div>
                                
                                <!-- Logo -->
                                <div class="relative z-10 w-16 sm:w-20 h-16 sm:h-20">
                                    <img src="{{ asset('logo/pro Gineous_white logo_white icon.svg') }}" alt="Pro Gineous" class="w-full h-full object-contain drop-shadow-2xl">
                                </div>
                            </div>
                        </div>

                        <!-- Cycle Nodes with Enhanced Design -->
                        <!-- ANALYZE - Top -->
                        <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 group">
                            <div class="relative">
                                <div class="absolute inset-0 bg-blue-500/20 blur-xl rounded-full"></div>
                                <div class="relative px-6 sm:px-8 py-2 sm:py-3 bg-gradient-to-r from-gray-900 to-gray-800 backdrop-blur-sm border-2 border-blue-500/30 rounded-full shadow-2xl group-hover:border-blue-400/50 transition-all duration-300">
                                    <span class="text-xs sm:text-sm font-bold text-blue-300 tracking-[0.2em] uppercase">ANALYZE</span>
                                </div>
                            </div>
                        </div>

                        <!-- TRAIN - Right -->
                        <div class="absolute top-1/2 right-0 transform translate-x-1/2 -translate-y-1/2 group">
                            <div class="relative">
                                <div class="absolute inset-0 bg-cyan-500/20 blur-xl rounded-full"></div>
                                <div class="relative px-6 sm:px-8 py-2 sm:py-3 bg-gradient-to-r from-gray-900 to-gray-800 backdrop-blur-sm border-2 border-cyan-500/30 rounded-full shadow-2xl group-hover:border-cyan-400/50 transition-all duration-300">
                                    <span class="text-xs sm:text-sm font-bold text-cyan-300 tracking-[0.2em] uppercase">TRAIN</span>
                                </div>
                            </div>
                        </div>

                        <!-- TEST - Bottom -->
                        <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/2 group">
                            <div class="relative">
                                <div class="absolute inset-0 bg-orange-500/20 blur-xl rounded-full"></div>
                                <div class="relative px-6 sm:px-8 py-2 sm:py-3 bg-gradient-to-r from-gray-900 to-gray-800 backdrop-blur-sm border-2 border-purple-500/30 rounded-full shadow-2xl group-hover:border-purple-400/50 transition-all duration-300">
                                    <span class="text-xs sm:text-sm font-bold text-purple-300 tracking-[0.2em] uppercase">TEST</span>
                                </div>
                                <!-- Animated Glowing Dot -->
                                <div class="absolute -top-3 right-6 sm:right-8">
                                    <div class="relative">
                                        <div class="w-2 sm:w-3 h-2 sm:h-3 bg-orange-500 rounded-full shadow-lg shadow-orange-500/50"></div>
                                        <div class="absolute inset-0 w-2 sm:w-3 h-2 sm:h-3 bg-orange-500 rounded-full animate-ping"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- DEPLOY - Left -->
                        <div class="absolute top-1/2 left-0 transform -translate-x-1/2 -translate-y-1/2 group">
                            <div class="relative">
                                <div class="absolute inset-0 bg-green-500/20 blur-xl rounded-full"></div>
                                <div class="relative px-6 sm:px-8 py-2 sm:py-3 bg-gradient-to-r from-gray-900 to-gray-800 backdrop-blur-sm border-2 border-green-500/30 rounded-full shadow-2xl group-hover:border-green-400/50 transition-all duration-300">
                                    <span class="text-xs sm:text-sm font-bold text-green-300 tracking-[0.2em] uppercase">DEPLOY</span>
                                </div>
                            </div>
                        </div>

                        <!-- Connecting Animated Lines -->
                        <svg class="absolute inset-0 w-full h-full pointer-events-none" style="transform: rotate(-90deg);">
                            <!-- Main Circle Path -->
                            <circle cx="50%" cy="50%" r="42%" fill="none" stroke="rgba(59, 130, 246, 0.15)" stroke-width="1"/>
                            <circle cx="50%" cy="50%" r="42%" fill="none" stroke="url(#gradient)" stroke-width="2" stroke-dasharray="8 4" class="animate-spin-slow" style="transform-origin: center;"/>
                            
                            <defs>
                                <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:rgb(59, 130, 246);stop-opacity:0.4" />
                                    <stop offset="50%" style="stop-color:rgb(34, 211, 238);stop-opacity:0.6" />
                                    <stop offset="100%" style="stop-color:rgb(59, 130, 246);stop-opacity:0.4" />
                                </linearGradient>
                            </defs>
                        </svg>

                        <!-- Orbital Particles -->
                        <div class="absolute inset-0 animate-spin-slow" style="animation-duration: 15s;">
                            <div class="absolute top-[10%] left-1/2 w-2 h-2 bg-blue-400 rounded-full shadow-lg shadow-blue-400/50"></div>
                        </div>
                        <div class="absolute inset-0 animate-spin-slow" style="animation-duration: 20s; animation-direction: reverse;">
                            <div class="absolute top-[30%] left-1/2 w-1.5 h-1.5 bg-cyan-400 rounded-full shadow-lg shadow-cyan-400/50"></div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Content - Centered -->
                <div class="space-y-6 sm:space-y-8 text-center w-full max-w-5xl">
                    <!-- Premium Features Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                        <div class="flex flex-col items-center gap-2 sm:gap-3 group p-4 bg-white/5 backdrop-blur-sm rounded-xl border border-gray-700/50 hover:border-emerald-500/50 transition-all duration-300">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-lg bg-gradient-to-br from-emerald-500/20 to-green-500/20 flex items-center justify-center border border-emerald-500/30 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs sm:text-sm font-semibold text-white mb-1">{{ __('frontend.military_grade_infrastructure') }}</div>
                                <div class="text-[10px] sm:text-xs text-gray-500">{{ __('frontend.built_for_resilience') }}</div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col items-center gap-2 sm:gap-3 group p-4 bg-white/5 backdrop-blur-sm rounded-xl border border-gray-700/50 hover:border-blue-500/50 transition-all duration-300">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-lg bg-gradient-to-br from-blue-500/20 to-cyan-500/20 flex items-center justify-center border border-blue-500/30 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs sm:text-sm font-semibold text-white mb-1">{{ __('frontend.ai_powered_optimization') }}</div>
                                <div class="text-[10px] sm:text-xs text-gray-500">{{ __('frontend.intelligent_resource_allocation') }}</div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col items-center gap-2 sm:gap-3 group p-4 bg-white/5 backdrop-blur-sm rounded-xl border border-gray-700/50 hover:border-purple-500/50 transition-all duration-300">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-lg bg-gradient-to-br from-purple-500/20 to-pink-500/20 flex items-center justify-center border border-purple-500/30 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs sm:text-sm font-semibold text-white mb-1">{{ __('frontend.white_glove_support') }}</div>
                                <div class="text-[10px] sm:text-xs text-gray-500">{{ __('frontend.dedicated_success_team') }}</div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col items-center gap-2 sm:gap-3 group p-4 bg-white/5 backdrop-blur-sm rounded-xl border border-gray-700/50 hover:border-orange-500/50 transition-all duration-300">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-lg bg-gradient-to-br from-orange-500/20 to-red-500/20 flex items-center justify-center border border-orange-500/30 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs sm:text-sm font-semibold text-white mb-1">{{ __('frontend.zero_compromise_security') }}</div>
                                <div class="text-[10px] sm:text-xs text-gray-500">{{ __('frontend.enterprise_grade_protection') }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Premium CTA Buttons -->
                    <div class="flex flex-wrap justify-center gap-3 sm:gap-4 pt-6 sm:pt-8">
                        <a href="{{ route('register') }}" class="group relative px-6 sm:px-10 py-3 sm:py-4 bg-gradient-to-r from-blue-500 to-cyan-500 text-white rounded-lg font-bold overflow-hidden shadow-2xl shadow-blue-500/30 hover:shadow-blue-500/50 transition-all duration-300 transform hover:scale-105 text-sm sm:text-base">
                            <div class="absolute inset-0 bg-gradient-to-r from-cyan-500 to-blue-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <span class="relative flex items-center gap-2">
                                {{ __('frontend.start_your_journey') }}
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </span>
                        </a>
                        <a href="#story" class="group px-6 sm:px-10 py-3 sm:py-4 bg-white/5 backdrop-blur-sm text-white border-2 border-gray-700 hover:border-blue-500 rounded-lg font-bold transition-all duration-300 hover:bg-white/10 text-sm sm:text-base">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ __('frontend.watch_our_story') }}
                            </span>
                        </a>
                    </div>

                    <!-- Premium Trust Indicators -->
                    <div class="flex items-center justify-center flex-wrap gap-6 sm:gap-8 lg:gap-12 pt-6 sm:pt-8 border-t border-gray-800/50">
                        <div class="group">
                            <div class="flex items-baseline gap-1 justify-center">
                                <div class="text-2xl sm:text-3xl font-black bg-gradient-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent">10,000</div>
                                <div class="text-base sm:text-lg font-bold text-blue-400">+</div>
                            </div>
                            <div class="text-[10px] sm:text-xs text-gray-400 uppercase tracking-wider mt-1">{{ __('frontend.enterprises_trust_us') }}</div>
                        </div>
                        <div class="group">
                            <div class="flex items-baseline gap-1 justify-center">
                                <div class="text-2xl sm:text-3xl font-black bg-gradient-to-r from-emerald-400 to-green-400 bg-clip-text text-transparent">99.99</div>
                                <div class="text-base sm:text-lg font-bold text-emerald-400">%</div>
                            </div>
                            <div class="text-[10px] sm:text-xs text-gray-400 uppercase tracking-wider mt-1">{{ __('frontend.guaranteed_uptime_sla') }}</div>
                        </div>
                        <div class="group">
                            <div class="flex items-baseline gap-1 justify-center">
                                <div class="text-2xl sm:text-3xl font-black bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">&lt;5</div>
                                <div class="text-base sm:text-lg font-bold text-purple-400">ms</div>
                            </div>
                            <div class="text-[10px] sm:text-xs text-gray-400 uppercase tracking-wider mt-1">{{ __('frontend.average_response_time') }}</div>
                        </div>
                    </div>

                    <!-- Award Badges -->
                    <div class="flex items-center justify-center flex-wrap gap-3 sm:gap-4 pt-4">
                        <div class="flex items-center gap-2 px-3 sm:px-4 py-2 bg-gradient-to-r from-yellow-500/10 to-orange-500/10 border border-yellow-500/20 rounded-full">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <span class="text-[10px] sm:text-xs font-semibold text-yellow-400">{{ __('frontend.icann_accredited') }}</span>
                        </div>
                        <div class="flex items-center gap-2 px-3 sm:px-4 py-2 bg-gradient-to-r from-green-500/10 to-emerald-500/10 border border-green-500/20 rounded-full">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-[10px] sm:text-xs font-semibold text-green-400">{{ __('frontend.iso_certified') }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Our Story Section - Enhanced Professional Design -->
    <section id="story" class="relative py-20 md:py-32">
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-7xl mx-auto">
                <!-- Section Header -->
                <div class="text-center mb-16">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-500/10 to-purple-500/10 border border-blue-500/20 rounded-full mb-6">
                        <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-semibold text-blue-400">{{ __('frontend.our_journey') }}</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4">
                        {{ __('frontend.our_story_title') }}
                    </h2>
                    <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                        {{ __('frontend.our_story_subtitle') }}
                    </p>
                </div>

                <!-- Story Content Grid -->
                <div class="grid lg:grid-cols-2 gap-12 items-start mb-20">
                    <!-- Left Column - Story Text -->
                    <div class="space-y-8">
                        <!-- Main Story -->
                        <div class="relative">
                            <div class="absolute -right-4 top-0 w-1 h-full bg-gradient-to-b from-blue-500 via-purple-500 to-transparent rounded-full"></div>
                            <div class="space-y-6 text-gray-300 leading-relaxed">
                                <p class="text-lg">
                                    {{ __('frontend.story_paragraph_1') }}
                                </p>
                                <p class="text-lg">
                                    {{ __('frontend.story_paragraph_2') }}
                                </p>
                                <p class="text-lg">
                                    {{ __('frontend.story_paragraph_3') }}
                                </p>
                                <p class="text-lg">
                                    {{ __('frontend.story_paragraph_4') }}
                                </p>
                            </div>
                        </div>

                        <!-- Company Registration Card -->
                        <div class="relative group">
                            <div class="absolute inset-0 bg-gradient-to-r from-green-500/20 to-emerald-500/20 rounded-2xl blur-xl group-hover:blur-2xl transition-all duration-300"></div>
                            <div class="relative bg-gray-800/90 backdrop-blur-sm rounded-2xl p-6 border border-gray-700/50 hover:border-green-500/50 transition-all duration-300">
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-white">{{ __('frontend.officially_registered') }}</h3>
                                        <p class="text-sm text-gray-400">{{ __('frontend.egypt_commercial_registry') }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-green-500/10 rounded-xl p-4 border border-green-500/20">
                                        <div class="text-2xl font-bold text-green-400">90088</div>
                                        <div class="text-xs text-gray-400 mt-1">{{ __('frontend.registration_number') }}</div>
                                    </div>
                                    <div class="bg-blue-500/10 rounded-xl p-4 border border-blue-500/20 flex flex-col items-center justify-center">
                                        <span class="fi fi-eg text-4xl rounded-md shadow-lg mb-1"></span>
                                        <div class="text-xs text-gray-400 mt-1">{{ __('frontend.egyptian_company') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Achievements & Stats -->
                    <div class="space-y-6">
                        <!-- Timeline Card -->
                        <div class="relative group">
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/20 to-purple-500/20 rounded-3xl transform rotate-3 group-hover:rotate-6 transition-all duration-300"></div>
                            <div class="relative bg-gray-800/90 backdrop-blur-sm rounded-3xl p-8 border border-gray-700/50 shadow-2xl">
                                <!-- Foundation Year -->
                                <div class="flex items-center gap-4 mb-8 pb-6 border-b border-gray-700/50">
                                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/30">
                                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-3xl font-bold text-white">{{ __('frontend.founded_year') }}</h3>
                                        <p class="text-gray-300 text-lg">{{ __('frontend.journey_begins') }}</p>
                                    </div>
                                </div>

                                <!-- Key Achievements -->
                                <div class="space-y-4">
                                    <h4 class="text-xl font-bold text-white mb-4">{{ __('frontend.key_milestones') }}</h4>
                                    
                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                            <svg class="w-4 h-4 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-white font-semibold">{{ __('frontend.milestone_1_title') }}</p>
                                            <p class="text-sm text-gray-400">{{ __('frontend.milestone_1_desc') }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 bg-purple-500/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                            <svg class="w-4 h-4 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-white font-semibold">{{ __('frontend.milestone_2_title') }}</p>
                                            <p class="text-sm text-gray-400">{{ __('frontend.milestone_2_desc') }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 bg-cyan-500/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                            <svg class="w-4 h-4 text-cyan-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-white font-semibold">{{ __('frontend.milestone_3_title') }}</p>
                                            <p class="text-sm text-gray-400">{{ __('frontend.milestone_3_desc') }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 bg-green-500/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                            <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-white font-semibold">{{ __('frontend.milestone_4_title') }}</p>
                                            <p class="text-sm text-gray-400">{{ __('frontend.milestone_4_desc') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Current Stats Grid -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="relative group">
                                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-2xl blur-lg group-hover:blur-xl transition-all duration-300"></div>
                                <div class="relative bg-gray-800/90 backdrop-blur-sm rounded-2xl p-6 border border-blue-500/30 hover:border-blue-500/50 transition-all duration-300">
                                    <div class="text-4xl font-bold text-blue-400 mb-2">10K+</div>
                                    <div class="text-sm text-gray-300 font-medium">{{ __('frontend.global_clients') }}</div>
                                    <div class="text-xs text-gray-400 mt-1">{{ __('frontend.across_continents') }}</div>
                                </div>
                            </div>

                            <div class="relative group">
                                <div class="absolute inset-0 bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-2xl blur-lg group-hover:blur-xl transition-all duration-300"></div>
                                <div class="relative bg-gray-800/90 backdrop-blur-sm rounded-2xl p-6 border border-purple-500/30 hover:border-purple-500/50 transition-all duration-300">
                                    <div class="text-4xl font-bold text-purple-400 mb-2">99.9%</div>
                                    <div class="text-sm text-gray-300 font-medium">{{ __('frontend.uptime_sla') }}</div>
                                    <div class="text-xs text-gray-400 mt-1">{{ __('frontend.guaranteed_performance') }}</div>
                                </div>
                            </div>

                            <div class="relative group">
                                <div class="absolute inset-0 bg-gradient-to-br from-green-500/20 to-emerald-500/20 rounded-2xl blur-lg group-hover:blur-xl transition-all duration-300"></div>
                                <div class="relative bg-gray-800/90 backdrop-blur-sm rounded-2xl p-6 border border-green-500/30 hover:border-green-500/50 transition-all duration-300">
                                    <div class="text-4xl font-bold text-green-400 mb-2">24/7</div>
                                    <div class="text-sm text-gray-300 font-medium">{{ __('frontend.expert_support') }}</div>
                                    <div class="text-xs text-gray-400 mt-1">{{ __('frontend.always_available') }}</div>
                                </div>
                            </div>

                            <div class="relative group">
                                <div class="absolute inset-0 bg-gradient-to-br from-orange-500/20 to-red-500/20 rounded-2xl blur-lg group-hover:blur-xl transition-all duration-300"></div>
                                <div class="relative bg-gray-800/90 backdrop-blur-sm rounded-2xl p-6 border border-orange-500/30 hover:border-orange-500/50 transition-all duration-300">
                                    <div class="text-4xl font-bold text-orange-400 mb-2">15+</div>
                                    <div class="text-sm text-gray-300 font-medium">{{ __('frontend.data_centers') }}</div>
                                    <div class="text-xs text-gray-400 mt-1">{{ __('frontend.worldwide_coverage') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Banner - Pride Statement -->
                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-r from-green-500/10 via-blue-500/10 to-purple-500/10 rounded-3xl blur-2xl"></div>
                    <div class="relative bg-gray-800/80 backdrop-blur-sm rounded-3xl p-8 md:p-12 border border-gray-700/50 text-center">
                        <div class="flex items-center justify-center gap-6 mb-6">
                            <!-- Egypt Flag -->
                            <div class="relative group/flag">
                                <div class="absolute inset-0 bg-green-500/20 rounded-2xl blur-lg group-hover/flag:blur-xl transition-all duration-300"></div>
                                <div class="relative bg-gray-800/50 backdrop-blur-sm rounded-2xl p-4 border border-gray-700/50 hover:border-green-500/50 transition-all duration-300">
                                    <span class="fi fi-eg text-5xl rounded-lg shadow-2xl"></span>
                                </div>
                            </div>
                            
                            <!-- Globe Icon -->
                            <div class="relative group/globe">
                                <div class="absolute inset-0 bg-blue-500/20 rounded-2xl blur-lg group-hover/globe:blur-xl transition-all duration-300"></div>
                                <div class="relative bg-gray-800/50 backdrop-blur-sm rounded-2xl p-4 border border-gray-700/50 hover:border-blue-500/50 transition-all duration-300">
                                    <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                            
                            <!-- Rocket Icon -->
                            <div class="relative group/rocket">
                                <div class="absolute inset-0 bg-purple-500/20 rounded-2xl blur-lg group-hover/rocket:blur-xl transition-all duration-300"></div>
                                <div class="relative bg-gray-800/50 backdrop-blur-sm rounded-2xl p-4 border border-gray-700/50 hover:border-purple-500/50 transition-all duration-300">
                                    <svg class="w-12 h-12 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <h3 class="text-3xl md:text-4xl font-bold text-white mb-4">
                            {{ __('frontend.egyptian_excellence_global_reach') }}
                        </h3>
                        <p class="text-xl text-gray-300 max-w-4xl mx-auto leading-relaxed">
                            {{ __('frontend.pride_statement') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Mission & Vision - Enhanced Professional Design -->
    <section class="relative py-20 md:py-32">
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-7xl mx-auto">
                <!-- Section Header -->
                <div class="text-center mb-16">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-purple-500/10 to-blue-500/10 border border-purple-500/20 rounded-full mb-6">
                        <svg class="w-5 h-5 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"/>
                        </svg>
                        <span class="text-sm font-semibold text-purple-400">{{ __('frontend.our_purpose_vision') }}</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">
                        {{ __('frontend.driving_digital_transformation') }}
                    </h2>
                    <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                        {{ __('frontend.mission_vision_subtitle') }}
                    </p>
                </div>

                <!-- Mission & Vision Cards -->
                <div class="grid lg:grid-cols-2 gap-8 mb-16">
                    <!-- Mission Card -->
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-3xl blur-xl group-hover:blur-2xl transition-all duration-500"></div>
                        <div class="relative bg-gray-800/90 backdrop-blur-sm rounded-3xl p-8 md:p-10 border border-gray-700/50 hover:border-blue-500/50 transition-all duration-300 h-full">
                            <!-- Icon -->
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm text-blue-400 font-semibold uppercase tracking-wider mb-1">{{ __('frontend.our_mission') }}</div>
                                    <h3 class="text-2xl md:text-3xl font-bold text-white">{{ __('frontend.mission_title') }}</h3>
                                </div>
                            </div>
                            
                            <!-- Mission Statement -->
                            <p class="text-lg text-gray-300 leading-relaxed mb-6">
                                {{ __('frontend.mission_statement') }}
                            </p>

                            <!-- Mission Points -->
                            <div class="space-y-3">
                                <div class="flex items-start gap-3">
                                    <div class="w-6 h-6 bg-blue-500/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                        <svg class="w-4 h-4 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-300">{{ __('frontend.mission_point_1') }}</p>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-6 h-6 bg-blue-500/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                        <svg class="w-4 h-4 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-300">{{ __('frontend.mission_point_2') }}</p>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-6 h-6 bg-blue-500/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                        <svg class="w-4 h-4 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-300">{{ __('frontend.mission_point_3') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Vision Card -->
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-3xl blur-xl group-hover:blur-2xl transition-all duration-500"></div>
                        <div class="relative bg-gray-800/90 backdrop-blur-sm rounded-3xl p-8 md:p-10 border border-gray-700/50 hover:border-purple-500/50 transition-all duration-300 h-full">
                            <!-- Icon -->
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg shadow-purple-500/30 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm text-purple-400 font-semibold uppercase tracking-wider mb-1">{{ __('frontend.our_vision') }}</div>
                                    <h3 class="text-2xl md:text-3xl font-bold text-white">{{ __('frontend.vision_title') }}</h3>
                                </div>
                            </div>
                            
                            <!-- Vision Statement -->
                            <p class="text-lg text-gray-300 leading-relaxed mb-6">
                                {{ __('frontend.vision_statement') }}
                            </p>

                            <!-- Vision Points -->
                            <div class="space-y-3">
                                <div class="flex items-start gap-3">
                                    <div class="w-6 h-6 bg-purple-500/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                        <svg class="w-4 h-4 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-300">{{ __('frontend.vision_point_1') }}</p>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-6 h-6 bg-purple-500/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                        <svg class="w-4 h-4 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-300">{{ __('frontend.vision_point_2') }}</p>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-6 h-6 bg-purple-500/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                        <svg class="w-4 h-4 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-300">{{ __('frontend.vision_point_3') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Quote -->
                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 via-purple-500/10 to-pink-500/10 rounded-2xl blur-xl"></div>
                    <div class="relative bg-gray-800/80 backdrop-blur-sm rounded-2xl p-8 border border-gray-700/50 text-center">
                        <svg class="w-12 h-12 text-blue-400 mx-auto mb-4 opacity-50" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                        </svg>
                        <p class="text-xl md:text-2xl font-medium text-white mb-2">{{ __('frontend.mission_vision_quote') }}</p>
                        <p class="text-gray-400">{{ __('frontend.mission_vision_quote_author') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Journey Through Time Section -->
    <section class="relative py-20 md:py-32">
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-7xl mx-auto">
                <!-- Section Header -->
                <div class="text-center mb-16">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-cyan-500/10 to-blue-500/10 border border-cyan-500/20 rounded-full mb-6">
                        <svg class="w-5 h-5 text-cyan-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-semibold text-cyan-400">{{ __('frontend.our_timeline') }}</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6">
                        {{ __('frontend.journey_through_time') }}
                    </h2>
                    <p class="text-xl text-gray-300 max-w-4xl mx-auto leading-relaxed">
                        {{ __('frontend.timeline_intro') }}
                    </p>
                </div>

                <!-- Timeline -->
                <div class="relative">
                    <!-- Vertical Line -->
                    <div class="hidden lg:block absolute left-1/2 top-0 bottom-0 w-1 bg-gradient-to-b from-cyan-500 via-blue-500 to-purple-500 transform -translate-x-1/2 rounded-full"></div>
                    
                    <!-- Timeline Items -->
                    <div class="space-y-16">
                        <!-- 2023 - Foundation -->
                        <div class="relative">
                            <div class="lg:grid lg:grid-cols-2 lg:gap-12 items-center">
                                <div class="lg:text-right mb-8 lg:mb-0">
                                    <div class="inline-block lg:block">
                                        <div class="relative group">
                                            <div class="absolute inset-0 bg-gradient-to-br from-green-500/20 to-emerald-500/20 rounded-2xl blur-xl group-hover:blur-2xl transition-all duration-300"></div>
                                            <div class="relative bg-gray-800/90 backdrop-blur-sm rounded-2xl p-6 border border-gray-700/50 hover:border-green-500/50 transition-all duration-300">
                                                <div class="flex lg:flex-row-reverse items-center gap-4 mb-4">
                                                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                                        </svg>
                                                    </div>
                                                    <div class="text-left lg:text-right">
                                                        <div class="text-3xl font-bold text-green-400">2023</div>
                                                        <div class="text-sm text-gray-400 uppercase tracking-wider">{{ __('frontend.timeline_2023_label') }}</div>
                                                    </div>
                                                </div>
                                                <h3 class="text-xl font-bold text-white mb-3 text-left lg:text-right">{{ __('frontend.timeline_2023_title') }}</h3>
                                                <p class="text-gray-300 leading-relaxed text-left lg:text-right">{{ __('frontend.timeline_2023_desc') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="hidden lg:block"></div>
                            </div>
                            <!-- Center Dot -->
                            <div class="hidden lg:block absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 w-6 h-6 bg-green-500 rounded-full border-4 border-gray-800 shadow-lg shadow-green-500/50"></div>
                        </div>

                        <!-- 2023 - First Major Milestone -->
                        <div class="relative">
                            <div class="lg:grid lg:grid-cols-2 lg:gap-12 items-center">
                                <div class="hidden lg:block"></div>
                                <div class="mb-8 lg:mb-0">
                                    <div class="relative group">
                                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-2xl blur-xl group-hover:blur-2xl transition-all duration-300"></div>
                                        <div class="relative bg-gray-800/90 backdrop-blur-sm rounded-2xl p-6 border border-gray-700/50 hover:border-blue-500/50 transition-all duration-300">
                                            <div class="flex items-center gap-4 mb-4">
                                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <div class="text-3xl font-bold text-blue-400">{{ __('frontend.timeline_milestone1_year') }}</div>
                                                    <div class="text-sm text-gray-400 uppercase tracking-wider">{{ __('frontend.timeline_milestone1_label') }}</div>
                                                </div>
                                            </div>
                                            <h3 class="text-xl font-bold text-white mb-3">{{ __('frontend.timeline_milestone1_title') }}</h3>
                                            <p class="text-gray-300 leading-relaxed">{{ __('frontend.timeline_milestone1_desc') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Center Dot -->
                            <div class="hidden lg:block absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 w-6 h-6 bg-blue-500 rounded-full border-4 border-gray-800 shadow-lg shadow-blue-500/50"></div>
                        </div>

                        <!-- 2024 - Expansion -->
                        <div class="relative">
                            <div class="lg:grid lg:grid-cols-2 lg:gap-12 items-center">
                                <div class="lg:text-right mb-8 lg:mb-0">
                                    <div class="inline-block lg:block">
                                        <div class="relative group">
                                            <div class="absolute inset-0 bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-2xl blur-xl group-hover:blur-2xl transition-all duration-300"></div>
                                            <div class="relative bg-gray-800/90 backdrop-blur-sm rounded-2xl p-6 border border-gray-700/50 hover:border-purple-500/50 transition-all duration-300">
                                                <div class="flex lg:flex-row-reverse items-center gap-4 mb-4">
                                                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                    </div>
                                                    <div class="text-left lg:text-right">
                                                        <div class="text-3xl font-bold text-purple-400">2024</div>
                                                        <div class="text-sm text-gray-400 uppercase tracking-wider">{{ __('frontend.timeline_2024_label') }}</div>
                                                    </div>
                                                </div>
                                                <h3 class="text-xl font-bold text-white mb-3 text-left lg:text-right">{{ __('frontend.timeline_2024_title') }}</h3>
                                                <p class="text-gray-300 leading-relaxed text-left lg:text-right">{{ __('frontend.timeline_2024_desc') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="hidden lg:block"></div>
                            </div>
                            <!-- Center Dot -->
                            <div class="hidden lg:block absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 w-6 h-6 bg-purple-500 rounded-full border-4 border-gray-800 shadow-lg shadow-purple-500/50"></div>
                        </div>

                        <!-- 2025 - Today & Beyond -->
                        <div class="relative">
                            <div class="lg:grid lg:grid-cols-2 lg:gap-12 items-center">
                                <div class="hidden lg:block"></div>
                                <div class="mb-8 lg:mb-0">
                                    <div class="relative group">
                                        <div class="absolute inset-0 bg-gradient-to-br from-orange-500/20 to-red-500/20 rounded-2xl blur-xl group-hover:blur-2xl transition-all duration-300"></div>
                                        <div class="relative bg-gray-800/90 backdrop-blur-sm rounded-2xl p-6 border border-gray-700/50 hover:border-orange-500/50 transition-all duration-300">
                                            <div class="flex items-center gap-4 mb-4">
                                                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <div class="text-3xl font-bold text-orange-400">2025</div>
                                                    <div class="text-sm text-gray-400 uppercase tracking-wider">{{ __('frontend.timeline_2025_label') }}</div>
                                                </div>
                                            </div>
                                            <h3 class="text-xl font-bold text-white mb-3">{{ __('frontend.timeline_2025_title') }}</h3>
                                            <p class="text-gray-300 leading-relaxed">{{ __('frontend.timeline_2025_desc') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Center Dot -->
                            <div class="hidden lg:block absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 w-6 h-6 bg-orange-500 rounded-full border-4 border-gray-800 shadow-lg shadow-orange-500/50 animate-pulse"></div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Summary -->
                <div class="mt-20 relative group">
                    <div class="absolute inset-0 bg-gradient-to-r from-cyan-500/10 via-blue-500/10 to-purple-500/10 rounded-3xl blur-2xl"></div>
                    <div class="relative bg-gray-800/80 backdrop-blur-sm rounded-3xl p-8 md:p-12 border border-gray-700/50 text-center">
                        <h3 class="text-3xl md:text-4xl font-bold text-white mb-6">{{ __('frontend.timeline_bottom_title') }}</h3>
                        <p class="text-xl text-gray-300 max-w-4xl mx-auto leading-relaxed mb-8">
                            {{ __('frontend.timeline_bottom_desc') }}
                        </p>
                        <div class="flex flex-wrap items-center justify-center gap-4">
                            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-blue-600 to-cyan-600 text-white rounded-xl font-semibold hover:shadow-xl hover:shadow-blue-500/30 transition-all duration-300 transform hover:scale-105">
                                {{ __('frontend.join_our_journey') }}
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Core Values - Enhanced Professional Design -->
    <section class="relative py-20 md:py-32">
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-7xl mx-auto">
                <!-- Section Header -->
                <div class="text-center mb-16">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-emerald-500/10 to-green-500/10 border border-emerald-500/20 rounded-full mb-6">
                        <svg class="w-5 h-5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-semibold text-emerald-400">{{ __('frontend.what_drives_us') }}</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6">
                        {{ __('frontend.core_values_title') }}
                    </h2>
                    <p class="text-xl text-gray-300 max-w-4xl mx-auto leading-relaxed">
                        {{ __('frontend.core_values_subtitle') }}
                    </p>
                </div>

                <!-- Values Grid -->
                <div class="grid md:grid-cols-2 gap-8 mb-16">
                    <!-- Value 1: Integrity & Trust -->
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-3xl blur-xl group-hover:blur-2xl transition-all duration-500"></div>
                        <div class="relative bg-gray-800/90 backdrop-blur-sm rounded-3xl p-8 border border-gray-700/50 hover:border-blue-500/50 transition-all duration-300 h-full">
                            <div class="flex items-start gap-6 mb-6">
                                <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/30 flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl md:text-3xl font-bold text-white mb-2">{{ __('frontend.value_integrity_title') }}</h3>
                                    <div class="text-sm text-blue-400 font-semibold uppercase tracking-wider">{{ __('frontend.value_integrity_label') }}</div>
                                </div>
                            </div>
                            <p class="text-lg text-gray-300 leading-relaxed mb-4">
                                {{ __('frontend.value_integrity_description') }}
                            </p>
                            <ul class="space-y-2">
                                <li class="flex items-start gap-2 text-gray-400">
                                    <svg class="w-5 h-5 text-blue-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>{{ __('frontend.value_integrity_point_1') }}</span>
                                </li>
                                <li class="flex items-start gap-2 text-gray-400">
                                    <svg class="w-5 h-5 text-blue-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>{{ __('frontend.value_integrity_point_2') }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Value 2: Innovation & Excellence -->
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-3xl blur-xl group-hover:blur-2xl transition-all duration-500"></div>
                        <div class="relative bg-gray-800/90 backdrop-blur-sm rounded-3xl p-8 border border-gray-700/50 hover:border-purple-500/50 transition-all duration-300 h-full">
                            <div class="flex items-start gap-6 mb-6">
                                <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg shadow-purple-500/30 flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl md:text-3xl font-bold text-white mb-2">{{ __('frontend.value_innovation_title') }}</h3>
                                    <div class="text-sm text-purple-400 font-semibold uppercase tracking-wider">{{ __('frontend.value_innovation_label') }}</div>
                                </div>
                            </div>
                            <p class="text-lg text-gray-300 leading-relaxed mb-4">
                                {{ __('frontend.value_innovation_description') }}
                            </p>
                            <ul class="space-y-2">
                                <li class="flex items-start gap-2 text-gray-400">
                                    <svg class="w-5 h-5 text-purple-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>{{ __('frontend.value_innovation_point_1') }}</span>
                                </li>
                                <li class="flex items-start gap-2 text-gray-400">
                                    <svg class="w-5 h-5 text-purple-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>{{ __('frontend.value_innovation_point_2') }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Value 3: Customer Success -->
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-br from-green-500/20 to-emerald-500/20 rounded-3xl blur-xl group-hover:blur-2xl transition-all duration-500"></div>
                        <div class="relative bg-gray-800/90 backdrop-blur-sm rounded-3xl p-8 border border-gray-700/50 hover:border-green-500/50 transition-all duration-300 h-full">
                            <div class="flex items-start gap-6 mb-6">
                                <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center shadow-lg shadow-green-500/30 flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl md:text-3xl font-bold text-white mb-2">{{ __('frontend.value_customer_title') }}</h3>
                                    <div class="text-sm text-green-400 font-semibold uppercase tracking-wider">{{ __('frontend.value_customer_label') }}</div>
                                </div>
                            </div>
                            <p class="text-lg text-gray-300 leading-relaxed mb-4">
                                {{ __('frontend.value_customer_description') }}
                            </p>
                            <ul class="space-y-2">
                                <li class="flex items-start gap-2 text-gray-400">
                                    <svg class="w-5 h-5 text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>{{ __('frontend.value_customer_point_1') }}</span>
                                </li>
                                <li class="flex items-start gap-2 text-gray-400">
                                    <svg class="w-5 h-5 text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>{{ __('frontend.value_customer_point_2') }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Value 4: Arab Pride -->
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-br from-orange-500/20 to-red-500/20 rounded-3xl blur-xl group-hover:blur-2xl transition-all duration-500"></div>
                        <div class="relative bg-gray-800/90 backdrop-blur-sm rounded-3xl p-8 border border-gray-700/50 hover:border-orange-500/50 transition-all duration-300 h-full">
                            <div class="flex items-start gap-6 mb-6">
                                <div class="w-20 h-20 bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl flex items-center justify-center shadow-lg shadow-orange-500/30 flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl md:text-3xl font-bold text-white mb-2">{{ __('frontend.value_pride_title') }}</h3>
                                    <div class="text-sm text-orange-400 font-semibold uppercase tracking-wider">{{ __('frontend.value_pride_label') }}</div>
                                </div>
                            </div>
                            <p class="text-lg text-gray-300 leading-relaxed mb-4">
                                {{ __('frontend.value_pride_description') }}
                            </p>
                            <ul class="space-y-2">
                                <li class="flex items-start gap-2 text-gray-400">
                                    <svg class="w-5 h-5 text-orange-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>{{ __('frontend.value_pride_point_1') }}</span>
                                </li>
                                <li class="flex items-start gap-2 text-gray-400">
                                    <svg class="w-5 h-5 text-orange-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>{{ __('frontend.value_pride_point_2') }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Bottom Statement -->
                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 via-purple-500/10 to-orange-500/10 rounded-3xl blur-2xl"></div>
                    <div class="relative bg-gray-800/80 backdrop-blur-sm rounded-3xl p-8 md:p-12 border border-gray-700/50 text-center">
                        <p class="text-2xl md:text-3xl font-bold text-white mb-4">
                            {{ __('frontend.values_statement') }}
                        </p>
                        <p class="text-lg text-gray-300 max-w-4xl mx-auto">
                            {{ __('frontend.values_statement_desc') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Global Presence - Enhanced Professional Design -->
    <section class="relative py-20 md:py-32">
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-7xl mx-auto">
                <!-- Section Header -->
                <div class="text-center mb-16">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-red-500/10 to-yellow-500/10 border border-red-500/20 rounded-full mb-6">
                        <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12 1.586l-4 4v12.828l4-4V1.586zM3.707 3.293A1 1 0 002 4v10a1 1 0 00.293.707L6 18.414V5.586L3.707 3.293zM17.707 5.293L14 1.586v12.828l2.293 2.293A1 1 0 0018 16V6a1 1 0 00-.293-.707z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-semibold text-red-400">{{ __('frontend.our_headquarters') }}</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6">
                        {{ __('frontend.global_presence_title') }}
                    </h2>
                    <p class="text-xl text-gray-300 max-w-4xl mx-auto leading-relaxed">
                        {{ __('frontend.global_presence_description') }}
                    </p>
                </div>

                <!-- Egypt Headquarters - Enhanced Single Card -->
                <div class="max-w-4xl mx-auto mb-16">
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-br from-red-500/20 via-yellow-500/20 to-green-500/20 rounded-3xl blur-xl group-hover:blur-2xl transition-all duration-500"></div>
                        <div class="relative bg-gray-800/90 backdrop-blur-sm rounded-3xl p-8 md:p-12 border border-gray-700/50 hover:border-red-500/50 transition-all duration-300">
                            <div class="flex flex-col md:flex-row items-start gap-8">
                                <!-- Egyptian Flag Icon -->
                                <div class="w-24 h-24 bg-gradient-to-br from-red-500 via-white to-black rounded-2xl flex items-center justify-center shadow-lg shadow-red-500/30 flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                                    <span class="fi fi-eg text-6xl rounded-lg"></span>
                                </div>
                                
                                <!-- Office Details -->
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-4">
                                        <h3 class="text-3xl md:text-4xl font-bold text-white">
                                            {{ __('frontend.egypt_headquarters') }}
                                        </h3>
                                        <span class="px-3 py-1 bg-gradient-to-r from-red-500 to-yellow-500 text-white text-xs font-bold rounded-full uppercase tracking-wide">
                                            {{ __('frontend.main_office') }}
                                        </span>
                                    </div>
                                    
                                    <p class="text-xl text-gray-300 mb-6 leading-relaxed">
                                        {{ __('frontend.egypt_headquarters_description') }}
                                    </p>
                                    
                                    <!-- Address and Details Grid -->
                                    <div class="grid md:grid-cols-2 gap-6 mb-6">
                                        <!-- Location -->
                                        <div class="flex items-start gap-3">
                                            <div class="w-10 h-10 bg-red-500/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="text-sm font-semibold text-gray-400 uppercase tracking-wide mb-1">{{ __('frontend.location') }}</div>
                                                <div class="text-white font-medium">{{ __('frontend.egypt_city') }}</div>
                                                <div class="text-gray-400 text-sm">{{ __('frontend.egypt_address') }}</div>
                                            </div>
                                        </div>
                                        
                                        <!-- Registration -->
                                        <div class="flex items-start gap-3">
                                            <div class="w-10 h-10 bg-blue-500/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="text-sm font-semibold text-gray-400 uppercase tracking-wide mb-1">{{ __('frontend.commercial_registration') }}</div>
                                                <div class="text-white font-bold text-lg">90088</div>
                                                <div class="text-gray-400 text-sm">{{ __('frontend.registered_company') }}</div>
                                            </div>
                                        </div>
                                        
                                        <!-- Tax Registration -->
                                        <div class="flex items-start gap-3">
                                            <div class="w-10 h-10 bg-green-500/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="text-sm font-semibold text-gray-400 uppercase tracking-wide mb-1">{{ __('frontend.tax_registration') }}</div>
                                                <div class="text-white font-bold text-lg">755-552-334</div>
                                                <div class="text-gray-400 text-sm">{{ __('frontend.tax_card_number') }}</div>
                                            </div>
                                        </div>
                                        
                                        <!-- Established -->
                                        <div class="flex items-start gap-3">
                                            <div class="w-10 h-10 bg-purple-500/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="text-sm font-semibold text-gray-400 uppercase tracking-wide mb-1">{{ __('frontend.established') }}</div>
                                                <div class="text-white font-bold text-lg">2023</div>
                                                <div class="text-gray-400 text-sm">{{ __('frontend.years_of_excellence') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Why Egypt Badge -->
                                    <div class="relative group/badge">
                                        <div class="absolute inset-0 bg-gradient-to-r from-red-500/10 to-yellow-500/10 rounded-xl blur"></div>
                                        <div class="relative bg-gray-900/50 backdrop-blur-sm rounded-xl p-4 border border-gray-700/30">
                                            <div class="flex items-start gap-3">
                                                <svg class="w-6 h-6 text-yellow-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                                <div>
                                                    <div class="font-bold text-white mb-1">{{ __('frontend.why_beni_suef') }}</div>
                                                    <p class="text-gray-400 text-sm leading-relaxed">{{ __('frontend.why_beni_suef_description') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Global Infrastructure Info -->
                <div class="grid md:grid-cols-3 gap-6">
                    <!-- Data Centers -->
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-cyan-500/10 rounded-2xl blur-lg group-hover:blur-xl transition-all duration-300"></div>
                        <div class="relative bg-gray-800/80 backdrop-blur-sm rounded-2xl p-6 border border-gray-700/50 hover:border-blue-500/50 transition-all duration-300 text-center">
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                                </svg>
                            </div>
                            <div class="text-4xl font-bold text-white mb-2">15+</div>
                            <div class="text-gray-300 font-semibold mb-2">{{ __('frontend.global_data_centers') }}</div>
                            <p class="text-sm text-gray-400">{{ __('frontend.data_centers_description') }}</p>
                        </div>
                    </div>

                    <!-- Countries Served -->
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-br from-purple-500/10 to-pink-500/10 rounded-2xl blur-lg group-hover:blur-xl transition-all duration-300"></div>
                        <div class="relative bg-gray-800/80 backdrop-blur-sm rounded-2xl p-6 border border-gray-700/50 hover:border-purple-500/50 transition-all duration-300 text-center">
                            <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="text-4xl font-bold text-white mb-2">50+</div>
                            <div class="text-gray-300 font-semibold mb-2">{{ __('frontend.countries_served') }}</div>
                            <p class="text-sm text-gray-400">{{ __('frontend.countries_description') }}</p>
                        </div>
                    </div>

                    <!-- Languages -->
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-br from-green-500/10 to-emerald-500/10 rounded-2xl blur-lg group-hover:blur-xl transition-all duration-300"></div>
                        <div class="relative bg-gray-800/80 backdrop-blur-sm rounded-2xl p-6 border border-gray-700/50 hover:border-green-500/50 transition-all duration-300 text-center">
                            <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                                </svg>
                            </div>
                            <div class="text-4xl font-bold text-white mb-2">2</div>
                            <div class="text-gray-300 font-semibold mb-2">{{ __('frontend.support_languages') }}</div>
                            <p class="text-sm text-gray-400">{{ __('frontend.languages_description') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Message to the World - Inspiring & Motivational -->
    <section class="relative py-20 md:py-32 overflow-hidden">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0">
            <div class="absolute top-20 left-10 w-72 h-72 bg-blue-500/10 rounded-full filter blur-3xl animate-pulse"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-purple-500/10 rounded-full filter blur-3xl animate-pulse delay-1000"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-gradient-to-r from-red-500/5 via-yellow-500/5 to-green-500/5 rounded-full filter blur-3xl"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-6xl mx-auto">
                <!-- Section Badge -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-500/10 via-purple-500/10 to-pink-500/10 border border-blue-500/20 rounded-full backdrop-blur-sm">
                        <svg class="w-6 h-6 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"/>
                            <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z"/>
                        </svg>
                        <span class="text-sm font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400 uppercase tracking-wider">
                            {{ __('frontend.our_message_badge') }}
                        </span>
                    </div>
                </div>

                <!-- Main Message Card -->
                <div class="relative group mb-12">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/20 via-purple-500/20 to-pink-500/20 rounded-3xl blur-2xl group-hover:blur-3xl transition-all duration-500"></div>
                    <div class="relative bg-gray-800/90 backdrop-blur-sm rounded-3xl p-8 md:p-12 lg:p-16 border border-gray-700/50">
                        <!-- Quote Mark -->
                        <div class="absolute top-8 left-8 opacity-10">
                            <svg class="w-24 h-24 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                            </svg>
                        </div>

                        <!-- Title -->
                        <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-center mb-8 leading-tight">
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400">
                                {{ __('frontend.message_title') }}
                            </span>
                        </h2>

                        <!-- Message Content -->
                        <div class="space-y-6 text-lg md:text-xl text-gray-300 leading-relaxed">
                            <p class="text-center text-2xl md:text-3xl font-semibold text-white">
                                {{ __('frontend.message_opening') }}
                            </p>

                            <p class="text-center">
                                {{ __('frontend.message_paragraph_1') }}
                            </p>

                            <p class="text-center">
                                {{ __('frontend.message_paragraph_2') }}
                            </p>

                            <div class="relative my-8">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-gray-700/50"></div>
                                </div>
                                <div class="relative flex justify-center">
                                    <span class="px-4 bg-gray-800/90 text-yellow-400">
                                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <p class="text-center font-semibold text-xl text-white">
                                {{ __('frontend.message_paragraph_3') }}
                            </p>

                            <p class="text-center">
                                {{ __('frontend.message_paragraph_4') }}
                            </p>

                            <p class="text-center text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-red-400 via-yellow-400 to-green-400">
                                {{ __('frontend.message_closing') }}
                            </p>
                        </div>

                        <!-- Signature -->
                        <div class="mt-12 text-center">
                            <div class="inline-block">
                                <div class="flex items-center justify-center gap-4 mb-4">
                                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center shadow-lg shadow-blue-500/30 p-3">
                                        <img src="{{ asset('logo/pro Gineous_white logo_white icon.svg') }}" alt="Pro Gineous Logo" class="w-full h-full object-contain">
                                    </div>
                                    <div class="text-center">
                                        <div class="text-xl font-bold text-white">{{ __('frontend.pro_gineous_team') }}</div>
                                        <div class="text-sm text-gray-400 flex items-center justify-center gap-2">
                                            <span class="fi fi-eg text-lg"></span>
                                            {{ __('frontend.message_from_beni_suef') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="text-sm text-gray-500 italic text-center">
                                    {{ __('frontend.message_date') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Call to Action Cards -->
                <div class="grid md:grid-cols-3 gap-6">
                    <!-- Card 1: Join Our Network -->
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-2xl blur-lg group-hover:blur-xl transition-all duration-300"></div>
                        <div class="relative bg-gray-800/90 backdrop-blur-sm rounded-2xl p-6 border border-gray-700/50 hover:border-blue-500/50 transition-all duration-300 text-center h-full flex flex-col">
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-blue-500/30">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-2">{{ __('frontend.join_journey_title') }}</h3>
                            <p class="text-gray-400 text-sm flex-grow">{{ __('frontend.join_journey_desc') }}</p>
                        </div>
                    </div>

                    <!-- Card 2: Strategic Partnership -->
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-2xl blur-lg group-hover:blur-xl transition-all duration-300"></div>
                        <div class="relative bg-gray-800/90 backdrop-blur-sm rounded-2xl p-6 border border-gray-700/50 hover:border-purple-500/50 transition-all duration-300 text-center h-full flex flex-col">
                            <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-purple-500/30">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                    <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-2">{{ __('frontend.partner_title') }}</h3>
                            <p class="text-gray-400 text-sm flex-grow">{{ __('frontend.partner_desc') }}</p>
                        </div>
                    </div>

                    <!-- Card 3: Industry Recognition -->
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-br from-green-500/20 to-emerald-500/20 rounded-2xl blur-lg group-hover:blur-xl transition-all duration-300"></div>
                        <div class="relative bg-gray-800/90 backdrop-blur-sm rounded-2xl p-6 border border-gray-700/50 hover:border-green-500/50 transition-all duration-300 text-center h-full flex flex-col">
                            <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-green-500/30">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-2">{{ __('frontend.share_vision_title') }}</h3>
                            <p class="text-gray-400 text-sm flex-grow">{{ __('frontend.share_vision_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CEO Message Section -->
    <section class="relative py-20 md:py-32 overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0">
            <div class="absolute top-20 right-10 w-72 h-72 bg-blue-500/10 rounded-full filter blur-3xl animate-pulse"></div>
            <div class="absolute bottom-20 left-10 w-96 h-96 bg-purple-500/10 rounded-full filter blur-3xl animate-pulse delay-1000"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-6xl mx-auto">
                <!-- Section Header -->
                <div class="text-center mb-12">
                    <div class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-orange-500/10 to-red-500/10 border border-orange-500/20 rounded-full backdrop-blur-sm mb-6">
                        <svg class="w-6 h-6 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-bold text-orange-400 uppercase tracking-wider">
                            {{ __('frontend.ceo_message_badge') }}
                        </span>
                    </div>
                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4">
                        {{ __('frontend.ceo_message_title') }}
                    </h2>
                </div>

                <!-- CEO Card -->
                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-br from-orange-500/20 via-red-500/20 to-pink-500/20 rounded-3xl blur-2xl group-hover:blur-3xl transition-all duration-500"></div>
                    <div class="relative bg-gray-800/90 backdrop-blur-sm rounded-3xl overflow-hidden border border-gray-700/50">
                        <div class="grid md:grid-cols-[300px,1fr] gap-8">
                            <!-- CEO Image & Info -->
                            <div class="bg-gradient-to-br from-orange-500/10 to-red-500/10 p-8 flex flex-col items-center justify-center text-center border-r border-gray-700/50">
                                <div class="relative mb-6">
                                    <div class="absolute inset-0 bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl blur-lg"></div>
                                    <div class="relative w-40 h-40 rounded-2xl bg-gradient-to-br from-orange-500 to-red-500 flex items-center justify-center p-1">
                                        <div class="w-full h-full rounded-xl bg-gray-900 flex items-center justify-center p-3">
                                            <img src="{{ asset('logo/pro Gineous_white logo_white icon.svg') }}" alt="Pro Gineous" class="w-full h-full object-contain">
                                        </div>
                                    </div>
                                </div>
                                <h3 class="text-2xl font-bold text-white mb-2">{{ __('frontend.ceo_name') }}</h3>
                                <div class="px-4 py-2 bg-gradient-to-r from-orange-500/20 to-red-500/20 rounded-full border border-orange-500/30 mb-4">
                                    <p class="text-orange-400 font-semibold text-sm">{{ __('frontend.ceo_title') }}</p>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-400">
                                    <span class="fi fi-eg text-lg"></span>
                                    <span>{{ __('frontend.ceo_location') }}</span>
                                </div>
                            </div>

                            <!-- CEO Message Content -->
                            <div class="p-8 md:p-12">
                                <!-- Quote Mark -->
                                <div class="mb-6">
                                    <svg class="w-12 h-12 text-orange-400/30" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                                    </svg>
                                </div>

                                <!-- Message Text -->
                                <div class="space-y-4 text-lg text-gray-300 leading-relaxed">
                                    <p>{{ __('frontend.ceo_message_paragraph_1') }}</p>
                                    <p>{{ __('frontend.ceo_message_paragraph_2') }}</p>
                                    <p class="font-semibold text-white">{{ __('frontend.ceo_message_paragraph_3') }}</p>
                                </div>

                                <!-- Signature -->
                                <div class="mt-8 pt-6 border-t border-gray-700/50">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-orange-500 to-red-500 flex items-center justify-center p-2">
                                            <img src="{{ asset('logo/pro Gineous_white logo_white icon.svg') }}" alt="Pro Gineous Logo" class="w-full h-full object-contain">
                                        </div>
                                        <div>
                                            <div class="text-xl font-bold text-white">{{ __('frontend.ceo_name') }}</div>
                                            <div class="text-sm text-gray-400">{{ __('frontend.ceo_signature') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="relative py-32 overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0">
            <div class="absolute top-20 left-10 w-72 h-72 bg-purple-500/10 rounded-full filter blur-3xl animate-pulse"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-blue-500/10 rounded-full filter blur-3xl animate-pulse delay-1000"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-6xl mx-auto">
                <!-- Section Header -->
                <div class="text-center mb-16">
                    <div class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-500/10 to-blue-500/10 border border-purple-500/20 rounded-full backdrop-blur-sm mb-6">
                        <svg class="w-6 h-6 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                        </svg>
                        <span class="text-sm font-bold text-purple-400 uppercase tracking-wider">
                            {{ __('frontend.team_badge') }}
                        </span>
                    </div>
                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6">
                        {{ __('frontend.our_team') }}
                    </h2>
                    <p class="text-xl text-gray-400 max-w-3xl mx-auto">
                        {{ __('frontend.our_team_subtitle') }}
                    </p>
                </div>

                <!-- Team Content Card -->
                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/20 via-blue-500/20 to-cyan-500/20 rounded-3xl blur-2xl group-hover:blur-3xl transition-all duration-500"></div>
                    <div class="relative bg-gray-800/90 backdrop-blur-sm rounded-3xl overflow-hidden border border-gray-700/50">
                        <div class="p-12 text-center">
                            <!-- Icon Grid -->
                            <div class="flex justify-center gap-4 mb-8">
                                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-500/20 to-blue-500/20 flex items-center justify-center backdrop-blur-sm border border-purple-500/30">
                                    <svg class="w-8 h-8 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                    </svg>
                                </div>
                                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500/20 to-cyan-500/20 flex items-center justify-center backdrop-blur-sm border border-blue-500/30">
                                    <svg class="w-8 h-8 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-cyan-500/20 to-teal-500/20 flex items-center justify-center backdrop-blur-sm border border-cyan-500/30">
                                    <svg class="w-8 h-8 text-cyan-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>

                            <!-- Description -->
                            <p class="text-lg text-gray-300 leading-relaxed max-w-3xl mx-auto mb-8">
                                {{ __('frontend.team_description') }}
                            </p>

                            <!-- Stats -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12 max-w-4xl mx-auto">
                                <div class="p-6 rounded-2xl bg-gradient-to-br from-purple-500/10 to-blue-500/10 border border-purple-500/20 backdrop-blur-sm">
                                    <div class="text-3xl font-bold text-white mb-2">{{ __('frontend.team_stat_1_number') }}</div>
                                    <div class="text-sm text-gray-400">{{ __('frontend.team_stat_1_label') }}</div>
                                </div>
                                <div class="p-6 rounded-2xl bg-gradient-to-br from-blue-500/10 to-cyan-500/10 border border-blue-500/20 backdrop-blur-sm">
                                    <div class="text-3xl font-bold text-white mb-2">{{ __('frontend.team_stat_2_number') }}</div>
                                    <div class="text-sm text-gray-400">{{ __('frontend.team_stat_2_label') }}</div>
                                </div>
                                <div class="p-6 rounded-2xl bg-gradient-to-br from-cyan-500/10 to-teal-500/10 border border-cyan-500/20 backdrop-blur-sm">
                                    <div class="text-3xl font-bold text-white mb-2">{{ __('frontend.team_stat_3_number') }}</div>
                                    <div class="text-sm text-gray-400">{{ __('frontend.team_stat_3_label') }}</div>
                                </div>
                            </div>

                            <!-- CTA Button -->
                            <a href="{{ route('careers') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-xl font-semibold hover:shadow-2xl hover:shadow-purple-500/50 transition-all duration-300 transform hover:scale-105 group">
                                {{ __('frontend.join_our_team') }}
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="relative py-32 overflow-hidden">
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-5xl mx-auto">
                <!-- Main CTA Card -->
                <div class="relative group">
                    <!-- Glow Effect -->
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-blue-400 rounded-3xl blur-2xl opacity-75 group-hover:opacity-100 transition-opacity duration-500 animate-pulse"></div>
                    
                    <!-- Card Content -->
                    <div class="relative bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 rounded-3xl overflow-hidden border border-gray-700/50">
                        <!-- Top Pattern -->
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-600 to-blue-400"></div>
                        
                        <div class="p-12 lg:p-16">
                            <!-- Badge -->
                            <div class="flex justify-center mb-8">
                                <div class="inline-flex items-center gap-2 px-6 py-3 bg-blue-500/20 border border-blue-500/30 rounded-full backdrop-blur-sm">
                                    <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm font-bold text-blue-400 uppercase tracking-wider">
                                        {{ __('frontend.cta_badge') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Main Title -->
                            <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 text-center">
                                {{ __('frontend.ready_to_get_started') }}
                            </h2>
                            
                            <!-- Description -->
                            <p class="text-xl md:text-2xl text-gray-300 mb-12 text-center max-w-3xl mx-auto">
                                {{ __('frontend.get_started_description') }}
                            </p>

                            <!-- Features Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                                <div class="flex items-center gap-3 p-4 rounded-xl bg-blue-500/10 border border-blue-500/20 backdrop-blur-sm">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-white">{{ __('frontend.cta_feature_1') }}</div>
                                        <div class="text-xs text-gray-400">{{ __('frontend.cta_feature_1_desc') }}</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 p-4 rounded-xl bg-blue-500/10 border border-blue-500/20 backdrop-blur-sm">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-white">{{ __('frontend.cta_feature_2') }}</div>
                                        <div class="text-xs text-gray-400">{{ __('frontend.cta_feature_2_desc') }}</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 p-4 rounded-xl bg-blue-500/10 border border-blue-500/20 backdrop-blur-sm">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-white">{{ __('frontend.cta_feature_3') }}</div>
                                        <div class="text-xs text-gray-400">{{ __('frontend.cta_feature_3_desc') }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- CTA Buttons -->
                            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                                <a href="{{ route('home') }}" class="group relative inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-xl font-semibold hover:shadow-2xl hover:shadow-blue-500/50 transition-all duration-300 transform hover:scale-105 overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                    <svg class="w-5 h-5 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                    </svg>
                                    <span class="relative z-10">{{ __('frontend.create_account') }}</span>
                                    <svg class="w-5 h-5 relative z-10 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </a>
                                <a href="#" onclick="event.preventDefault(); showIntercom();" class="group inline-flex items-center gap-3 px-8 py-4 bg-white/10 backdrop-blur-sm text-white border-2 border-white/30 rounded-xl font-semibold hover:bg-white/20 hover:border-white/50 transition-all duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                    <span>{{ __('frontend.contact_us') }}</span>
                                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </a>
                            </div>

                            <!-- Trust Indicators -->
                            <div class="mt-12 pt-8 border-t border-gray-700/50">
                                <div class="flex flex-wrap items-center justify-center gap-8 text-sm text-gray-400">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span>{{ __('frontend.cta_trust_1') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span>{{ __('frontend.cta_trust_2') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span>{{ __('frontend.cta_trust_3') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection
