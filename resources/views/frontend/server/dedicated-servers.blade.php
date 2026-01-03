@extends('frontend.layout')

@section('title', __('frontend.dedicated_servers') . ' - ' . config('app.name'))
@section('meta_description', __('frontend.dedicated_servers_meta_description'))

@section('content')
<!-- Hero Section -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-slate-950 via-blue-950 to-slate-950">
    <!-- Grid Pattern Background -->
    <div class="absolute inset-0 bg-[linear-gradient(to_right,#4f4f4f12_1px,transparent_1px),linear-gradient(to_bottom,#4f4f4f12_1px,transparent_1px)] bg-[size:44px_44px]"></div>
    
    <!-- Animated Gradient Orbs -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-0 ltr:left-0 rtl:right-0 w-[600px] h-[600px] bg-gradient-to-br from-blue-600/30 to-purple-600/30 rounded-full mix-blend-multiply filter blur-[120px] animate-blob"></div>
        <div class="absolute top-0 ltr:right-0 rtl:left-0 w-[600px] h-[600px] bg-gradient-to-br from-purple-600/30 to-pink-600/30 rounded-full mix-blend-multiply filter blur-[120px] animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-32 ltr:left-1/3 rtl:right-1/3 w-[600px] h-[600px] bg-gradient-to-br from-cyan-600/30 to-blue-600/30 rounded-full mix-blend-multiply filter blur-[120px] animate-blob animation-delay-4000"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center">
            <!-- Premium Badge -->
            <div class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600/10 to-purple-600/10 backdrop-blur-2xl rounded-full border border-blue-500/30 mb-8 shadow-2xl shadow-blue-500/20 hover:shadow-blue-500/40 transition-all duration-300">
                <span class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-gradient-to-r from-blue-400 to-purple-400"></span>
                </span>
                <span class="text-blue-200 text-sm font-bold tracking-wide uppercase">{{ __('frontend.enterprise_grade_infrastructure') }}</span>
                <svg class="w-4 h-4 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
            </div>

            <!-- Main Heading with Gradient -->
            <h1 class="text-5xl sm:text-6xl lg:text-8xl font-black mb-8 leading-[1.1]">
                <span class="bg-gradient-to-r from-white via-blue-100 to-white bg-clip-text text-transparent drop-shadow-2xl">
                    {{ __('frontend.dedicated_servers') }}
                </span>
            </h1>
            
            <p class="text-xl sm:text-2xl text-blue-100/90 mb-12 max-w-4xl mx-auto leading-relaxed font-light">
                {{ __('frontend.dedicated_servers_description') }}
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-5 justify-center mb-20">
                <a href="#plans" class="group relative inline-flex items-center justify-center px-10 py-5 bg-gradient-to-r from-blue-600 via-blue-500 to-purple-600 text-white font-bold rounded-2xl overflow-hidden transition-all duration-500 hover:shadow-2xl hover:shadow-blue-500/50 hover:scale-105 hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <span class="relative z-10 flex items-center gap-3">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
                        </svg>
                        {{ __('frontend.view_plans') }}
                        <svg class="w-5 h-5 group-hover:ltr:translate-x-1 group-hover:rtl:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </span>
                </a>
                <button onclick="if(typeof Intercom !== 'undefined') { Intercom('show'); }" class="group inline-flex items-center justify-center gap-3 px-10 py-5 bg-white/5 backdrop-blur-2xl text-white font-bold rounded-2xl border-2 border-white/20 hover:bg-white/10 hover:border-white/40 transition-all duration-300 cursor-pointer hover:scale-105 hover:-translate-y-1 shadow-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                    </svg>
                    {{ __('frontend.talk_to_expert') }}
                </button>
            </div>

            <!-- Key Features Grid with Professional SVG Icons -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl mx-auto">
                <!-- Feature 1: Root Access -->
                <div class="group relative bg-gradient-to-br from-white/[0.07] to-white/[0.02] backdrop-blur-2xl rounded-3xl p-8 border border-white/10 hover:border-blue-500/50 transition-all duration-500 hover:scale-105 hover:-translate-y-2 shadow-xl hover:shadow-blue-500/20">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-600/0 to-purple-600/0 group-hover:from-blue-600/10 group-hover:to-purple-600/10 rounded-3xl transition-all duration-500"></div>
                    <div class="relative">
                        <div class="w-16 h-16 mb-6 bg-gradient-to-br from-blue-500/20 to-purple-500/20 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-white font-bold text-lg mb-3">{{ __('frontend.full_root_access') }}</h3>
                        <p class="text-blue-200/70 text-sm leading-relaxed">{{ __('frontend.complete_server_control') }}</p>
                    </div>
                </div>
                
                <!-- Feature 2: DDoS Protection -->
                <div class="group relative bg-gradient-to-br from-white/[0.07] to-white/[0.02] backdrop-blur-2xl rounded-3xl p-8 border border-white/10 hover:border-purple-500/50 transition-all duration-500 hover:scale-105 hover:-translate-y-2 shadow-xl hover:shadow-purple-500/20">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-600/0 to-pink-600/0 group-hover:from-purple-600/10 group-hover:to-pink-600/10 rounded-3xl transition-all duration-500"></div>
                    <div class="relative">
                        <div class="w-16 h-16 mb-6 bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h3 class="text-white font-bold text-lg mb-3">{{ __('frontend.ddos_protection') }}</h3>
                        <p class="text-blue-200/70 text-sm leading-relaxed">{{ __('frontend.enterprise_security') }}</p>
                    </div>
                </div>
                
                <!-- Feature 3: High Performance -->
                <div class="group relative bg-gradient-to-br from-white/[0.07] to-white/[0.02] backdrop-blur-2xl rounded-3xl p-8 border border-white/10 hover:border-pink-500/50 transition-all duration-500 hover:scale-105 hover:-translate-y-2 shadow-xl hover:shadow-pink-500/20">
                    <div class="absolute inset-0 bg-gradient-to-br from-pink-600/0 to-orange-600/0 group-hover:from-pink-600/10 group-hover:to-orange-600/10 rounded-3xl transition-all duration-500"></div>
                    <div class="relative">
                        <div class="w-16 h-16 mb-6 bg-gradient-to-br from-pink-500/20 to-orange-500/20 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-white font-bold text-lg mb-3">{{ __('frontend.high_performance') }}</h3>
                        <p class="text-blue-200/70 text-sm leading-relaxed">{{ __('frontend.nvme_ssd_storage') }}</p>
                    </div>
                </div>
                
                <!-- Feature 4: 24/7 Monitoring -->
                <div class="group relative bg-gradient-to-br from-white/[0.07] to-white/[0.02] backdrop-blur-2xl rounded-3xl p-8 border border-white/10 hover:border-green-500/50 transition-all duration-500 hover:scale-105 hover:-translate-y-2 shadow-xl hover:shadow-green-500/20">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-600/0 to-cyan-600/0 group-hover:from-green-600/10 group-hover:to-cyan-600/10 rounded-3xl transition-all duration-500"></div>
                    <div class="relative">
                        <div class="w-16 h-16 mb-6 bg-gradient-to-br from-green-500/20 to-cyan-500/20 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-white font-bold text-lg mb-3">{{ __('frontend.24_7_monitoring') }}</h3>
                        <p class="text-blue-200/70 text-sm leading-relaxed">{{ __('frontend.proactive_support') }}</p>
                    </div>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="mt-20 grid grid-cols-2 lg:grid-cols-4 gap-8 max-w-5xl mx-auto">
                <div class="text-center">
                    <div class="text-4xl font-black bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent mb-2">99.9%</div>
                    <div class="text-blue-200/70 text-sm font-medium">{{ __('frontend.uptime_sla') }}</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-black bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent mb-2">24/7</div>
                    <div class="text-blue-200/70 text-sm font-medium">{{ __('frontend.expert_support_badge') }}</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-black bg-gradient-to-r from-pink-400 to-orange-400 bg-clip-text text-transparent mb-2">10Gbps</div>
                    <div class="text-blue-200/70 text-sm font-medium">{{ __('frontend.network_speed') }}</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-black bg-gradient-to-r from-green-400 to-cyan-400 bg-clip-text text-transparent mb-2">Intel</div>
                    <div class="text-blue-200/70 text-sm font-medium">{{ __('frontend.xeon_processors') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-10 ltr:left-1/2 rtl:right-1/2 ltr:-translate-x-1/2 rtl:translate-x-1/2 animate-bounce">
        <div class="w-8 h-12 rounded-full border-2 border-white/30 flex items-start justify-center p-2">
            <div class="w-1.5 h-3 bg-white/70 rounded-full animate-pulse"></div>
        </div>
    </div>
</section>

<!-- Why Choose Dedicated Servers Section - Circular/Radial Design -->
<section class="relative py-32 overflow-hidden bg-gradient-to-br from-slate-900 via-blue-950 to-purple-950">
    <!-- Animated Background Pattern -->
    <div class="absolute inset-0">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 50% 50%, rgba(59, 130, 246, 0.3) 1px, transparent 1px); background-size: 40px 40px;"></div>
    </div>
    
    <!-- Gradient Orbs -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-blue-500/10 rounded-full blur-[150px] animate-pulse"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-purple-500/10 rounded-full blur-[120px] animate-pulse" style="animation-delay: 1s;"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-24">
            <div class="inline-flex items-center gap-2 px-6 py-3 bg-white/10 backdrop-blur-xl rounded-full border border-white/20 mb-8 shadow-2xl">
                <div class="w-2 h-2 bg-blue-400 rounded-full animate-pulse"></div>
                <span class="text-white text-sm font-bold tracking-wider uppercase">{{ __('frontend.why_dedicated') }}</span>
            </div>
            <h2 class="text-5xl sm:text-7xl font-black text-white mb-6 leading-tight">
                {{ __('frontend.unmatched_performance_control') }}
            </h2>
            <p class="text-xl text-blue-100 max-w-3xl mx-auto leading-relaxed">
                {{ __('frontend.dedicated_servers_benefits_intro') }}
            </p>
        </div>

        <!-- Circular Layout for Desktop / Grid for Mobile -->
        <!-- Mobile & Tablet View (Grid) -->
        <div class="block lg:hidden">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Feature 1 -->
                <div class="bg-white/10 backdrop-blur-xl rounded-3xl p-6 border border-white/20 hover:border-blue-400 transition-all duration-300">
                    <div class="flex items-start gap-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/50 flex-shrink-0">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white mb-2">{{ __('frontend.dedicated_resources') }}</h3>
                            <p class="text-sm text-blue-100 leading-relaxed">{{ __('frontend.dedicated_resources_desc') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white/10 backdrop-blur-xl rounded-3xl p-6 border border-white/20 hover:border-purple-400 transition-all duration-300">
                    <div class="flex items-start gap-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg shadow-purple-500/50 flex-shrink-0">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white mb-2">{{ __('frontend.maximum_performance') }}</h3>
                            <p class="text-sm text-blue-100 leading-relaxed">{{ __('frontend.maximum_performance_desc') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white/10 backdrop-blur-xl rounded-3xl p-6 border border-white/20 hover:border-green-400 transition-all duration-300">
                    <div class="flex items-start gap-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg shadow-green-500/50 flex-shrink-0">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white mb-2">{{ __('frontend.enhanced_security') }}</h3>
                            <p class="text-sm text-blue-100 leading-relaxed">{{ __('frontend.enhanced_security_desc') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 4 -->
                <div class="bg-white/10 backdrop-blur-xl rounded-3xl p-6 border border-white/20 hover:border-orange-400 transition-all duration-300">
                    <div class="flex items-start gap-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg shadow-orange-500/50 flex-shrink-0">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white mb-2">{{ __('frontend.full_customization') }}</h3>
                            <p class="text-sm text-blue-100 leading-relaxed">{{ __('frontend.full_customization_desc') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 5 -->
                <div class="bg-white/10 backdrop-blur-xl rounded-3xl p-6 border border-white/20 hover:border-pink-400 transition-all duration-300">
                    <div class="flex items-start gap-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg shadow-pink-500/50 flex-shrink-0">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white mb-2">{{ __('frontend.99_9_uptime') }}</h3>
                            <p class="text-sm text-blue-100 leading-relaxed">{{ __('frontend.99_9_uptime_desc') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 6 -->
                <div class="bg-white/10 backdrop-blur-xl rounded-3xl p-6 border border-white/20 hover:border-cyan-400 transition-all duration-300">
                    <div class="flex items-start gap-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-2xl flex items-center justify-center shadow-lg shadow-cyan-500/50 flex-shrink-0">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white mb-2">{{ __('frontend.24_7_expert_support') }}</h3>
                            <p class="text-sm text-blue-100 leading-relaxed">{{ __('frontend.24_7_expert_support_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Desktop View (Circular Layout) -->
        <div class="hidden lg:block relative max-w-6xl mx-auto overflow-visible" style="min-height: 900px; padding: 100px 0;">
            <!-- Center Circle - Main Icon -->
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-20">
                <div class="relative">
                    <!-- Rotating Ring -->
                    <div class="absolute inset-0 w-48 h-48 rounded-full border-4 border-blue-500/30 border-t-blue-500 animate-spin" style="animation-duration: 8s;"></div>
                    <div class="absolute inset-0 w-48 h-48 rounded-full border-4 border-purple-500/30 border-b-purple-500" style="animation: spin 10s linear infinite reverse;"></div>
                    
                    <!-- Center Icon -->
                    <div class="relative w-48 h-48 bg-gradient-to-br from-blue-600 via-purple-600 to-pink-600 rounded-full flex items-center justify-center shadow-2xl shadow-blue-500/50 animate-spin" style="animation-duration: 20s;">
                        <div class="w-44 h-44 bg-slate-900 rounded-full flex items-center justify-center">
                            <img src="{{ asset('logo/pro Gineous_white logo_white icon.svg') }}" alt="Pro Gineous" class="w-24 h-24">
                        </div>
                    </div>
                    
                    <!-- Center Text -->
                    <div class="absolute -bottom-20 left-1/2 transform -translate-x-1/2 text-center whitespace-nowrap">
                        <p class="text-2xl font-bold text-white">Dedicated Server</p>
                        <p class="text-sm text-blue-300">Enterprise Power</p>
                    </div>
                </div>
            </div>

            <!-- Orbital Features -->
            <!-- Feature 1: Dedicated Resources (Top) -->
            <div class="absolute top-16 left-1/2 transform -translate-x-1/2 group z-30">
                <!-- Connection Line -->
                <div class="absolute top-full left-1/2 w-0.5 h-24 bg-gradient-to-b from-blue-500/50 to-transparent transform -translate-x-1/2"></div>
                
                <!-- Feature Circle -->
                <div class="relative">
                    <div class="w-28 h-28 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center shadow-xl shadow-blue-500/50 group-hover:scale-110 transition-all duration-500 cursor-pointer border-4 border-blue-400/30 group-hover:border-blue-400 group-hover:shadow-2xl group-hover:shadow-blue-500/70">
                        <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    
                    <!-- Info Box - Positioned Below -->
                    <div class="absolute top-full left-1/2 transform -translate-x-1/2 mt-28 w-72 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                        <div class="bg-slate-900/95 backdrop-blur-xl rounded-2xl p-6 border-2 border-blue-500/50 shadow-2xl shadow-blue-500/30">
                            <h3 class="text-xl font-bold text-white mb-3 text-center">{{ __('frontend.dedicated_resources') }}</h3>
                            <p class="text-sm text-blue-100 text-center leading-relaxed">{{ __('frontend.dedicated_resources_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feature 2: Maximum Performance (Top Right) -->
            <div class="absolute group z-30" style="top: 18%; right: 8%;">
                <div class="absolute top-1/2 right-full w-32 h-0.5 bg-gradient-to-l from-purple-500/50 to-transparent transform -translate-y-1/2"></div>
                
                <div class="relative">
                    <div class="w-28 h-28 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center shadow-xl shadow-purple-500/50 group-hover:scale-110 transition-all duration-500 cursor-pointer border-4 border-purple-400/30 group-hover:border-purple-400 group-hover:shadow-2xl group-hover:shadow-purple-500/70">
                        <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    
                    <!-- Info Box - Positioned Right -->
                    <div class="absolute top-1/2 right-full transform -translate-y-1/2 mr-36 w-72 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                        <div class="bg-slate-900/95 backdrop-blur-xl rounded-2xl p-6 border-2 border-purple-500/50 shadow-2xl shadow-purple-500/30">
                            <h3 class="text-xl font-bold text-white mb-3">{{ __('frontend.maximum_performance') }}</h3>
                            <p class="text-sm text-blue-100 leading-relaxed">{{ __('frontend.maximum_performance_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feature 3: Enhanced Security (Bottom Right) -->
            <div class="absolute group z-30" style="bottom: 18%; right: 8%;">
                <div class="absolute bottom-1/2 right-full w-32 h-0.5 bg-gradient-to-l from-green-500/50 to-transparent transform translate-y-1/2"></div>
                
                <div class="relative">
                    <div class="w-28 h-28 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center shadow-xl shadow-green-500/50 group-hover:scale-110 transition-all duration-500 cursor-pointer border-4 border-green-400/30 group-hover:border-green-400 group-hover:shadow-2xl group-hover:shadow-green-500/70">
                        <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    
                    <!-- Info Box - Positioned to Left (inside viewport) -->
                    <div class="absolute top-1/2 right-full transform -translate-y-1/2 mr-36 w-72 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-[100]">
                        <div class="bg-slate-900/95 backdrop-blur-xl rounded-2xl p-6 border-2 border-green-500/50 shadow-2xl shadow-green-500/30">
                            <h3 class="text-xl font-bold text-white mb-3">{{ __('frontend.enhanced_security') }}</h3>
                            <p class="text-sm text-blue-100 leading-relaxed">{{ __('frontend.enhanced_security_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feature 4: Full Customization (Bottom) -->
            <div class="absolute bottom-12 left-1/2 transform -translate-x-1/2 group z-30">
                <div class="absolute bottom-full left-1/2 w-0.5 h-24 bg-gradient-to-t from-orange-500/50 to-transparent transform -translate-x-1/2"></div>
                
                <div class="relative">
                    <div class="w-28 h-28 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center shadow-xl shadow-orange-500/50 group-hover:scale-110 transition-all duration-500 cursor-pointer border-4 border-orange-400/30 group-hover:border-orange-400 group-hover:shadow-2xl group-hover:shadow-orange-500/70">
                        <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    
                    <!-- Info Box - Positioned Above -->
                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-28 w-72 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                        <div class="bg-slate-900/95 backdrop-blur-xl rounded-2xl p-6 border-2 border-orange-500/50 shadow-2xl shadow-orange-500/30">
                            <h3 class="text-xl font-bold text-white mb-3 text-center">{{ __('frontend.full_customization') }}</h3>
                            <p class="text-sm text-blue-100 text-center leading-relaxed">{{ __('frontend.full_customization_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feature 5: 99.9% Uptime (Bottom Left) -->
            <div class="absolute group z-30" style="bottom: 18%; left: 8%;">
                <div class="absolute bottom-1/2 left-full w-32 h-0.5 bg-gradient-to-r from-pink-500/50 to-transparent transform translate-y-1/2"></div>
                
                <div class="relative">
                    <div class="w-28 h-28 bg-gradient-to-br from-pink-500 to-pink-600 rounded-full flex items-center justify-center shadow-xl shadow-pink-500/50 group-hover:scale-110 transition-all duration-500 cursor-pointer border-4 border-pink-400/30 group-hover:border-pink-400 group-hover:shadow-2xl group-hover:shadow-pink-500/70">
                        <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    
                    <!-- Info Box - Positioned Left -->
                    <div class="absolute bottom-1/2 left-full transform translate-y-1/2 ml-36 w-72 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                        <div class="bg-slate-900/95 backdrop-blur-xl rounded-2xl p-6 border-2 border-pink-500/50 shadow-2xl shadow-pink-500/30">
                            <h3 class="text-xl font-bold text-white mb-3">{{ __('frontend.99_9_uptime') }}</h3>
                            <p class="text-sm text-blue-100 leading-relaxed">{{ __('frontend.99_9_uptime_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feature 6: {{ __('frontend.support_247') }} Support (Top Left) -->
            <div class="absolute group z-30" style="top: 18%; left: 8%;">
                <div class="absolute top-1/2 left-full w-32 h-0.5 bg-gradient-to-r from-cyan-500/50 to-transparent transform -translate-y-1/2"></div>
                
                <div class="relative">
                    <div class="w-28 h-28 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-full flex items-center justify-center shadow-xl shadow-cyan-500/50 group-hover:scale-110 transition-all duration-500 cursor-pointer border-4 border-cyan-400/30 group-hover:border-cyan-400 group-hover:shadow-2xl group-hover:shadow-cyan-500/70">
                        <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    
                    <!-- Info Box - Positioned Left -->
                    <div class="absolute top-1/2 left-full transform -translate-y-1/2 ml-36 w-72 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                        <div class="bg-slate-900/95 backdrop-blur-xl rounded-2xl p-6 border-2 border-cyan-500/50 shadow-2xl shadow-cyan-500/30">
                            <h3 class="text-xl font-bold text-white mb-3">{{ __('frontend.24_7_expert_support') }}</h3>
                            <p class="text-sm text-blue-100 leading-relaxed">{{ __('frontend.24_7_expert_support_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>
</section>

<!-- Pricing Plans Section -->
<section id="plans" class="py-24 bg-gradient-to-b from-gray-50 to-white" x-data="{ period: 'monthly' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-12">
            <div class="inline-block px-4 py-2 bg-blue-100 text-blue-600 rounded-full text-sm font-semibold mb-6">
                {{ __('frontend.dedicated_server_plans') }}
            </div>
            <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-6">
                {{ __('frontend.choose_perfect_plan') }}
            </h2>
            <p class="text-xl text-gray-600">
                {{ __('frontend.dedicated_features_description') }}
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

        @if($dedicatedPlans->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-600 text-lg">{{ __('frontend.no_plans_available') }}</p>
            </div>
        @else
            <!-- Plans Table -->
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-200/60">
                <!-- Table Container with Horizontal Scroll -->
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[1000px]">
                        <!-- Table Header -->
                        <thead>
                            <tr class="bg-gradient-to-r from-slate-50 to-gray-50 border-b-2 border-gray-200">
                                <th class="px-4 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-bold text-gray-700 uppercase tracking-wide">
                                    {{ __('frontend.plan_name') }}
                                </th>
                                <th class="px-3 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wide">
                                    {{ __('frontend.cpu') }}
                                </th>
                                <th class="px-3 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wide">
                                    RAM
                                </th>
                                <th class="px-3 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wide">
                                    {{ __('frontend.storage') }}
                                </th>
                                <th class="px-3 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wide">
                                    {{ __('frontend.bandwidth') }}
                                </th>
                                <th class="px-3 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wide">
                                    {{ __('frontend.ip_addresses') }}
                                </th>
                                <th class="px-3 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wide">
                                    {{ __('frontend.price') }}
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wide">
                                    {{ __('frontend.action') }}
                                </th>
                            </tr>
                        </thead>

                        <!-- Table Body -->
                        <tbody class="divide-y divide-gray-100">
                            @foreach($dedicatedPlans as $index => $plan)
                                <tr class="group hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-transparent transition-all duration-300 {{ $plan->is_featured ? 'bg-blue-50/30' : '' }}">
                                    <!-- Plan Name -->
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            @if($plan->is_featured)
                                                <div class="flex-shrink-0">
                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-xs font-semibold bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-sm">
                                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                        </svg>
                                                        {{ __('frontend.popular') }}
                                                    </span>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="text-sm font-semibold text-gray-900 group-hover:text-blue-700 transition-colors">{{ $plan->plan_name }}</div>
                                                @if($plan->plan_tagline)
                                                    <div class="text-xs text-gray-500 mt-0.5">{{ $plan->plan_tagline }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <!-- CPU -->
                                    <td class="px-3 py-4 whitespace-nowrap text-center">
                                        <div class="inline-flex flex-col items-center">
                                            <span class="text-sm font-semibold text-gray-900">{{ $plan->cpu_cores }}</span>
                                            <span class="text-xs text-gray-500">{{ __('frontend.cores') }}</span>
                                            @if($plan->cpu_type)
                                                <span class="text-xs text-gray-400 mt-0.5">{{ $plan->cpu_type }}</span>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- RAM -->
                                    <td class="px-3 py-4 whitespace-nowrap text-center">
                                        <div class="inline-flex flex-col items-center">
                                            <span class="text-sm font-semibold text-gray-900">{{ $plan->ram_gb }} GB</span>
                                            <span class="text-xs text-gray-500">DDR4 ECC</span>
                                        </div>
                                    </td>

                                    <!-- Storage -->
                                    <td class="px-3 py-4 whitespace-nowrap text-center">
                                        <div class="inline-flex flex-col items-center">
                                            <span class="text-sm font-semibold text-gray-900">{{ $plan->storage_config }}</span>
                                        </div>
                                    </td>

                                    <!-- Bandwidth -->
                                    <td class="px-3 py-4 whitespace-nowrap text-center">
                                        <span class="text-sm font-semibold text-gray-900">{{ $plan->bandwidth }}</span>
                                    </td>

                                    <!-- IP Addresses -->
                                    <td class="px-3 py-4 whitespace-nowrap text-center">
                                        <div class="inline-flex flex-col items-center">
                                            <span class="text-sm font-semibold text-gray-900">{{ $plan->ipv4_count }} IPv4</span>
                                            @if($plan->enable_ipv6)
                                                <span class="text-xs text-gray-500">+ IPv6</span>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Price -->
                                    <td class="px-3 py-4 whitespace-nowrap text-center">
                                        <!-- Monthly Price -->
                                        <div x-show="period === 'monthly'" x-transition>
                                            <div class="text-xl font-bold text-gray-900">${{ number_format($plan->monthly_price, 2) }}</div>
                                            <div class="text-xs text-gray-500 font-medium">/{{ __('frontend.month') }}</div>
                                        </div>
                                        <!-- Quarterly Price -->
                                        <div x-show="period === 'quarterly'" x-transition x-cloak>
                                            <div class="text-xl font-bold text-gray-900">${{ number_format($plan->quarterly_price, 2) }}</div>
                                            <div class="text-xs text-gray-500 font-medium">/{{ __('frontend.3_months') }}</div>
                                            <span class="inline-block px-2 py-0.5 bg-emerald-100 text-emerald-700 text-xs font-semibold rounded mt-1">-5%</span>
                                        </div>
                                        <!-- Semi-Annually Price -->
                                        <div x-show="period === 'semi_annually'" x-transition x-cloak>
                                            <div class="text-xl font-bold text-gray-900">${{ number_format($plan->semi_annually_price, 2) }}</div>
                                            <div class="text-xs text-gray-500 font-medium">/{{ __('frontend.6_months') }}</div>
                                            <span class="inline-block px-2 py-0.5 bg-emerald-100 text-emerald-700 text-xs font-semibold rounded mt-1">-10%</span>
                                        </div>
                                        <!-- Annually Price -->
                                        <div x-show="period === 'annually'" x-transition x-cloak>
                                            <div class="text-xl font-bold text-gray-900">${{ number_format($plan->annually_price, 2) }}</div>
                                            <div class="text-xs text-gray-500 font-medium">/{{ __('frontend.year') }}</div>
                                            <span class="inline-block px-2 py-0.5 bg-emerald-100 text-emerald-700 text-xs font-semibold rounded mt-1">-15%</span>
                                        </div>
                                        @if($plan->setup_fee > 0)
                                            <div class="text-xs text-gray-400 mt-1">+ ${{ number_format($plan->setup_fee, 2) }} {{ __('frontend.setup') }}</div>
                                        @endif
                                    </td>

                                    <!-- Action Button -->
                                    <td class="px-4 py-4 whitespace-nowrap text-center">
                                        <a href="{{ route('dedicated.configure', $plan->id) }}" class="inline-flex items-center justify-center px-5 py-2 bg-gray-900 hover:bg-blue-600 text-white text-sm font-semibold rounded-lg transition-all duration-300 shadow-sm hover:shadow-md group-hover:scale-105">
                                            {{ __('frontend.order_now') }}
                                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'mr-1.5 -scale-x-100' : 'ml-1.5' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

<!-- Technical Specifications Section -->
<section class="py-24 bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 text-white relative overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute w-96 h-96 bg-blue-500/10 rounded-full blur-3xl -top-48 -left-48 animate-pulse"></div>
        <div class="absolute w-96 h-96 bg-purple-500/10 rounded-full blur-3xl -bottom-48 -right-48 animate-pulse delay-1000"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16">
            <span class="inline-block px-6 py-2.5 bg-gradient-to-r from-blue-500/20 to-purple-500/20 backdrop-blur-xl text-blue-300 rounded-full text-sm font-semibold mb-6 border border-blue-500/30 shadow-lg">
                {{ __('frontend.technical_specs') }}
            </span>
            <h2 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-6 text-white leading-tight pb-2">
                {{ __('frontend.enterprise_hardware') }}
            </h2>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto leading-relaxed">
                {{ __('frontend.enterprise_hardware_desc') }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Spec 1: Processors -->
            <div class="group relative bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-xl rounded-2xl p-8 border border-white/20 hover:border-blue-400/60 hover:shadow-2xl hover:shadow-blue-500/20 transition-all duration-500 hover:-translate-y-2">
                <!-- Glow Effect -->
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/0 to-blue-500/0 group-hover:from-blue-500/10 group-hover:to-transparent rounded-2xl transition-all duration-500"></div>
                
                <div class="relative z-10">
                    <!-- Icon Container -->
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500/20 to-blue-600/20 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 border border-blue-400/30">
                        <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                        </svg>
                    </div>
                    
                    <h3 class="text-2xl font-bold mb-3 group-hover:text-blue-300 transition-colors duration-300">
                        {{ __('frontend.intel_xeon_processors') }}
                    </h3>
                    <p class="text-gray-400 leading-relaxed group-hover:text-gray-300 transition-colors duration-300">
                        {{ __('frontend.latest_generation_cpus') }}
                    </p>
                    
                    <!-- Decorative Line -->
                    <div class="mt-6 h-1 w-0 group-hover:w-full bg-gradient-to-r from-blue-500 to-transparent rounded transition-all duration-500"></div>
                </div>
            </div>

            <!-- Spec 2: Memory -->
            <div class="group relative bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-xl rounded-2xl p-8 border border-white/20 hover:border-purple-400/60 hover:shadow-2xl hover:shadow-purple-500/20 transition-all duration-500 hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-500/0 to-purple-500/0 group-hover:from-purple-500/10 group-hover:to-transparent rounded-2xl transition-all duration-500"></div>
                
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500/20 to-purple-600/20 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 border border-purple-400/30">
                        <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    
                    <h3 class="text-2xl font-bold mb-3 group-hover:text-purple-300 transition-colors duration-300">
                        {{ __('frontend.ecc_ram') }}
                    </h3>
                    <p class="text-gray-400 leading-relaxed group-hover:text-gray-300 transition-colors duration-300">
                        {{ __('frontend.error_correcting_memory') }}
                    </p>
                    
                    <div class="mt-6 h-1 w-0 group-hover:w-full bg-gradient-to-r from-purple-500 to-transparent rounded transition-all duration-500"></div>
                </div>
            </div>

            <!-- Spec 3: Storage -->
            <div class="group relative bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-xl rounded-2xl p-8 border border-white/20 hover:border-emerald-400/60 hover:shadow-2xl hover:shadow-emerald-500/20 transition-all duration-500 hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/0 to-emerald-500/0 group-hover:from-emerald-500/10 group-hover:to-transparent rounded-2xl transition-all duration-500"></div>
                
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-500/20 to-emerald-600/20 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 border border-emerald-400/30">
                        <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                        </svg>
                    </div>
                    
                    <h3 class="text-2xl font-bold mb-3 group-hover:text-emerald-300 transition-colors duration-300">
                        {{ __('frontend.nvme_storage') }}
                    </h3>
                    <p class="text-gray-400 leading-relaxed group-hover:text-gray-300 transition-colors duration-300">
                        {{ __('frontend.lightning_fast_io') }}
                    </p>
                    
                    <div class="mt-6 h-1 w-0 group-hover:w-full bg-gradient-to-r from-emerald-500 to-transparent rounded transition-all duration-500"></div>
                </div>
            </div>

            <!-- Spec 4: Network -->
            <div class="group relative bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-xl rounded-2xl p-8 border border-white/20 hover:border-pink-400/60 hover:shadow-2xl hover:shadow-pink-500/20 transition-all duration-500 hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-br from-pink-500/0 to-pink-500/0 group-hover:from-pink-500/10 group-hover:to-transparent rounded-2xl transition-all duration-500"></div>
                
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-gradient-to-br from-pink-500/20 to-pink-600/20 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 border border-pink-400/30">
                        <svg class="w-8 h-8 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                        </svg>
                    </div>
                    
                    <h3 class="text-2xl font-bold mb-3 group-hover:text-pink-300 transition-colors duration-300">
                        {{ __('frontend.10gbps_network') }}
                    </h3>
                    <p class="text-gray-400 leading-relaxed group-hover:text-gray-300 transition-colors duration-300">
                        {{ __('frontend.redundant_connectivity') }}
                    </p>
                    
                    <div class="mt-6 h-1 w-0 group-hover:w-full bg-gradient-to-r from-pink-500 to-transparent rounded transition-all duration-500"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Operating Systems Section -->
<section id="operating-systems-section" class="py-24 bg-gradient-to-b from-white to-gray-50" x-data="{ showAll: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
            <div class="inline-block px-4 py-2 bg-blue-100 text-blue-600 rounded-full text-sm font-semibold mb-6">
                {{ __('frontend.operating_systems') }}
            </div>
            <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-6">
                {{ __('frontend.choose_your_os') }}
            </h2>
            <p class="text-xl text-gray-600 leading-relaxed">
                {{ __('frontend.os_description_dedicated') }}
            </p>
        </div>

        @if(!empty($operatingSystems) && count($operatingSystems) > 0)
            @php
                // All Hetzner OS images are displayable (no filtering needed)
                $displayableOS = collect($operatingSystems);
                
                $totalOS = $displayableOS->count();
                $initialShow = 16;
            @endphp

            <!-- OS Grid from Hetzner API -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 gap-4">
                @foreach($displayableOS as $index => $os)
                    @php
                        // Determine OS family for styling (use os_flavor from Hetzner)
                        $family = strtolower($os['os_flavor'] ?? 'other');
                        
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
                        class="group relative bg-white rounded-xl p-4 shadow-lg hover:shadow-2xl transition-all duration-500 border-2 border-transparent hover:border-blue-500 hover:-translate-y-2 cursor-pointer overflow-hidden"
                        x-show="showAll || {{ $index }} < {{ $initialShow }}"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        style="{{ $index >= $initialShow ? 'display: none;' : '' }}"
                        data-aos="fade-up" 
                        data-aos-delay="{{ ($index % 8) * 50 }}"
                    >
                        <!-- Gradient Background on Hover -->
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        <div class="relative flex flex-col items-center text-center">
                            <!-- OS Icon from Simple Icons CDN -->
                            <div class="w-16 h-16 mb-3 flex items-center justify-center rounded-xl shadow-md group-hover:shadow-xl transition-all duration-300 transform group-hover:scale-110 bg-white p-2">
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
                            <h3 class="text-sm font-bold text-gray-900 group-hover:text-blue-600 transition-colors mb-1 leading-tight px-1">
                                {{ $os['name'] }}
                            </h3>
                            
                            <!-- OS Architecture -->
                            <div class="flex gap-1 flex-wrap justify-center">
                                @if(!empty($os['arch']))
                                    <span class="inline-block px-1.5 py-0.5 bg-gray-100 group-hover:bg-blue-100 text-gray-600 group-hover:text-blue-700 text-xs rounded-full font-medium transition-colors">
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
                        <svg class="w-5 h-5 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        <svg class="w-5 h-5 transform rotate-180 rtl:rotate-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>
            @endif
        @else
            <!-- Fallback: Static OS List if API fails -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 gap-4">
                @foreach(['Ubuntu', 'CentOS', 'Debian', 'Fedora', 'AlmaLinux', 'Rocky Linux', 'Windows', 'Arch Linux'] as $index => $osName)
                    <div class="group relative bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 border-2 border-transparent hover:border-blue-500 hover:-translate-y-2 cursor-pointer" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-20 h-20 mb-4 flex items-center justify-center">
                                <div class="w-16 h-16 rounded-lg bg-blue-500 flex items-center justify-center text-white font-bold text-xl">
                                    {{ strtoupper(substr($osName, 0, 2)) }}
                                </div>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-500 transition-colors">{{ $osName }}</h3>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<!-- Marketplace Apps Section -->
<section id="marketplace-apps-section" class="py-24 bg-gradient-to-b from-gray-50 to-white" x-data="{ showAllApps: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
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
                $initialShowApps = 16;
            @endphp

            <!-- Apps Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 gap-4">
                @foreach($marketplaceApps as $index => $app)
                    @php
                        // Clean app name for icon matching
                        $appNameLower = strtolower($app['short_name'] ?? $app['name']);
                        
                        // Icon and color mapping
                        $appConfig = [
                            'wordpress' => ['icon' => 'wordpress', 'color' => '#21759B'],
                            'docker' => ['icon' => 'docker', 'color' => '#2496ED'],
                            'cpanel' => ['icon' => 'cpanel', 'color' => '#FF6C2C'],
                            'plesk' => ['icon' => 'plesk', 'color' => '#52BBE6'],
                            'mysql' => ['icon' => 'mysql', 'color' => '#4479A1'],
                            'nginx' => ['icon' => 'nginx', 'color' => '#009639'],
                            'nodejs' => ['icon' => 'nodedotjs', 'color' => '#339933'],
                        ];
                        
                        $config = null;
                        foreach ($appConfig as $key => $value) {
                            if (str_contains($appNameLower, $key)) {
                                $config = $value;
                                break;
                            }
                        }
                        
                        if (!$config) {
                            $config = ['icon' => null, 'color' => '#6366F1'];
                        }
                    @endphp
                    
                    <div 
                        class="group relative bg-white rounded-xl p-4 shadow-lg hover:shadow-2xl transition-all duration-500 border-2 border-transparent hover:border-purple-500 hover:-translate-y-2 cursor-pointer overflow-hidden"
                        x-show="showAllApps || {{ $index }} < {{ $initialShowApps }}"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        style="{{ $index >= $initialShowApps ? 'display: none;' : '' }}"
                        data-aos="fade-up" 
                        data-aos-delay="{{ ($index % 8) * 50 }}"
                    >
                        <div class="absolute inset-0 bg-gradient-to-br from-purple-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        <div class="relative flex flex-col items-center text-center">
                            <div class="w-16 h-16 mb-3 flex items-center justify-center rounded-xl shadow-md group-hover:shadow-xl transition-all duration-300 transform group-hover:scale-110 bg-gradient-to-br from-gray-50 to-white p-2">
                                @if($config['icon'])
                                    <img 
                                        src="https://cdn.simpleicons.org/{{ $config['icon'] }}/{{ ltrim($config['color'], '#') }}" 
                                        alt="{{ $app['name'] }}" 
                                        class="w-full h-full object-contain"
                                        loading="lazy"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                    >
                                    <div class="w-full h-full rounded-lg hidden items-center justify-center" style="display:none; background: linear-gradient(135deg, {{ $config['color'] }} 0%, {{ $config['color'] }}dd 100%);">
                                        <span class="text-white font-bold">{{ strtoupper(substr($app['name'], 0, 2)) }}</span>
                                    </div>
                                @else
                                    <div class="w-full h-full rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, {{ $config['color'] }} 0%, {{ $config['color'] }}dd 100%);">
                                        <span class="text-white font-bold">{{ strtoupper(substr($app['name'], 0, 2)) }}</span>
                                    </div>
                                @endif
                            </div>
                            
                            <h3 class="text-sm font-bold text-gray-900 group-hover:text-purple-600 transition-colors mb-1 leading-tight px-1">
                                {{ $app['name'] }}
                            </h3>
                            
                            <span class="inline-block px-1.5 py-0.5 bg-purple-100 group-hover:bg-purple-200 text-purple-600 group-hover:text-purple-700 text-xs rounded-full font-medium transition-colors">
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
                        <svg class="w-5 h-5 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>

                <div class="mt-12 text-center" x-show="showAllApps" x-cloak>
                    <button 
                        @click="showAllApps = false; window.scrollTo({top: document.querySelector('#marketplace-apps-section').offsetTop - 100, behavior: 'smooth'})"
                        class="inline-flex items-center gap-3 px-8 py-4 bg-gray-600 text-white font-bold rounded-xl hover:bg-gray-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105"
                    >
                        <span>{{ __('frontend.show_less_apps') }}</span>
                        <svg class="w-5 h-5 transform rotate-180 rtl:rotate-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <p class="text-gray-500">{{ __('frontend.no_apps_available') }}</p>
            </div>
        @endif
    </div>
</section>

<!-- cPanel Management Section -->
<section class="py-24 bg-gradient-to-br from-white via-blue-50/30 to-white relative overflow-hidden">
    <!-- Background Decoration -->
    <div class="absolute inset-0 bg-grid-slate-100 [mask-image:linear-gradient(0deg,white,rgba(255,255,255,0.6))] -z-10"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div class="order-2 lg:order-1">
                <div class="inline-block px-4 py-2 bg-gradient-to-r from-orange-100 to-red-100 text-orange-600 rounded-full text-sm font-semibold mb-6">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path>
                        </svg>
                        {{ __('frontend.cpanel_control_panel') }}
                    </span>
                </div>
                
                <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-6">
                    {{ __('frontend.cpanel_management') }}
                </h2>
                
                <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                    {{ __('frontend.cpanel_description') }}
                </p>

                <!-- Features List -->
                <div class="space-y-4 mb-8">
                    <div class="flex items-start gap-3 group">
                        <div class="flex-shrink-0 w-6 h-6 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center mt-0.5">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-900 font-semibold">{{ __('frontend.cpanel_os_support') }}</p>
                            <p class="text-gray-600 text-sm mt-1">{{ __('frontend.cpanel_os_support_desc') }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 group">
                        <div class="flex-shrink-0 w-6 h-6 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center mt-0.5">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-900 font-semibold">{{ __('frontend.cpanel_full_admin') }}</p>
                            <p class="text-gray-600 text-sm mt-1">{{ __('frontend.cpanel_full_admin_desc') }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 group">
                        <div class="flex-shrink-0 w-6 h-6 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center mt-0.5">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-900 font-semibold">{{ __('frontend.cpanel_scalable') }}</p>
                            <p class="text-gray-600 text-sm mt-1">{{ __('frontend.cpanel_scalable_desc') }}</p>
                        </div>
                    </div>
                </div>

                <!-- CTA Button -->
                <div class="flex flex-wrap gap-4">
                    <a href="#plans" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105">
                        {{ __('frontend.cpanel_get_started') }}
                        <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'mr-2 -scale-x-100' : 'ml-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                    <a href="#" class="inline-flex items-center px-6 py-3 bg-white hover:bg-gray-50 text-gray-900 font-semibold rounded-xl border-2 border-gray-300 transition-all duration-300">
                        {{ __('frontend.cpanel_learn_more') }}
                    </a>
                </div>
            </div>

            <!-- Right Image/Illustration -->
            <div class="order-1 lg:order-2">
                <div class="relative">
                    <!-- Main Card -->
                    <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-2xl shadow-2xl p-8 transform hover:scale-105 transition-transform duration-500">
                        <!-- cPanel Logo Area -->
                        <div class="bg-gradient-to-r from-orange-500 to-red-500 rounded-xl p-6 mb-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="text-white font-bold text-2xl">cPanel</div>
                                <div class="flex gap-2">
                                    <div class="w-3 h-3 bg-white/40 rounded-full"></div>
                                    <div class="w-3 h-3 bg-white/40 rounded-full"></div>
                                    <div class="w-3 h-3 bg-white/40 rounded-full"></div>
                                </div>
                            </div>
                            <div class="text-white/90 text-sm">{{ __('frontend.cpanel_dashboard') }}</div>
                        </div>

                        <!-- Stats Cards -->
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20">
                                <div class="text-blue-400 text-sm mb-1">{{ __('frontend.cpanel_websites') }}</div>
                                <div class="text-white text-2xl font-bold">24</div>
                            </div>
                            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20">
                                <div class="text-green-400 text-sm mb-1">{{ __('frontend.cpanel_emails') }}</div>
                                <div class="text-white text-2xl font-bold">156</div>
                            </div>
                            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20">
                                <div class="text-purple-400 text-sm mb-1">{{ __('frontend.cpanel_databases') }}</div>
                                <div class="text-white text-2xl font-bold">38</div>
                            </div>
                            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20">
                                <div class="text-orange-400 text-sm mb-1">{{ __('frontend.cpanel_domains') }}</div>
                                <div class="text-white text-2xl font-bold">12</div>
                            </div>
                        </div>

                        <!-- Feature Icons -->
                        <div class="flex justify-between items-center">
                            <div class="text-center">
                                <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center mb-2">
                                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                    </svg>
                                </div>
                                <div class="text-white/60 text-xs">{{ __('frontend.cpanel_files') }}</div>
                            </div>
                            <div class="text-center">
                                <div class="w-10 h-10 bg-green-500/20 rounded-lg flex items-center justify-center mb-2">
                                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="text-white/60 text-xs">{{ __('frontend.cpanel_email') }}</div>
                            </div>
                            <div class="text-center">
                                <div class="w-10 h-10 bg-purple-500/20 rounded-lg flex items-center justify-center mb-2">
                                    <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                                    </svg>
                                </div>
                                <div class="text-white/60 text-xs">{{ __('frontend.cpanel_mysql') }}</div>
                            </div>
                            <div class="text-center">
                                <div class="w-10 h-10 bg-orange-500/20 rounded-lg flex items-center justify-center mb-2">
                                    <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <div class="text-white/60 text-xs">{{ __('frontend.cpanel_stats') }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Floating Badge -->
                    <div class="absolute -top-4 -right-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white px-4 py-2 rounded-full shadow-lg text-sm font-semibold">
                        {{ __('frontend.cpanel_easy_migration') }}
                    </div>

                    <!-- Decorative Elements -->
                    <div class="absolute -bottom-4 -left-4 w-24 h-24 bg-orange-500/20 rounded-full blur-2xl"></div>
                    <div class="absolute -top-8 -right-8 w-32 h-32 bg-blue-500/20 rounded-full blur-2xl"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Use Cases Section -->
<section class="py-24 bg-gradient-to-br from-slate-50 via-blue-50/30 to-purple-50/30 relative overflow-hidden">
    <!-- Animated Background -->
    <div class="absolute inset-0">
        <div class="absolute w-96 h-96 bg-blue-400/10 rounded-full blur-3xl top-0 left-1/4 animate-pulse"></div>
        <div class="absolute w-96 h-96 bg-purple-400/10 rounded-full blur-3xl bottom-0 right-1/4 animate-pulse delay-1000"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <span class="inline-block px-6 py-2.5 bg-gradient-to-r from-purple-100 to-pink-100 text-purple-600 rounded-full text-sm font-semibold mb-6 border border-purple-200">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                    </svg>
                    {{ __('frontend.use_cases') }}
                </span>
            </span>
            <h2 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 mb-6">
                {{ __('frontend.perfect_for_demanding_workloads') }}
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                {{ __('frontend.usecase_mission_critical_desc') }}
            </p>
        </div>

        <!-- Use Cases Zigzag Layout -->
        <div class="space-y-24">
            <!-- Use Case 1: Game Servers (Image Right) -->
            <div class="grid lg:grid-cols-2 gap-12 items-center" data-aos="fade-up">
                <!-- Content -->
                <div class="lg:pr-12 rtl:lg:pr-0 rtl:lg:pl-12">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-100 text-blue-600 rounded-full text-sm font-semibold mb-6">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"></path>
                        </svg>
                        {{ __('frontend.game_servers') }}
                    </div>
                    
                    <h3 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                        {{ __('frontend.game_servers') }}
                    </h3>
                    
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        {{ __('frontend.game_servers_desc') }}
                    </p>

                    <!-- Features -->
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start gap-3 group/item">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mt-0.5 group-hover/item:bg-blue-600 transition-colors duration-300">
                                <svg class="w-5 h-5 text-blue-600 group-hover/item:text-white transition-colors duration-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 text-lg font-medium">{{ __('frontend.low_latency_gameplay') }}</span>
                        </li>
                        <li class="flex items-start gap-3 group/item">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mt-0.5 group-hover/item:bg-blue-600 transition-colors duration-300">
                                <svg class="w-5 h-5 text-blue-600 group-hover/item:text-white transition-colors duration-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 text-lg font-medium">{{ __('frontend.ddos_protection_included') }}</span>
                        </li>
                    </ul>

                    <a href="#plans" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-semibold hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl group/btn">
                        <span>{{ __('frontend.learn_more') }}</span>
                        <svg class="w-5 h-5 group-hover/btn:translate-x-1 rtl:group-hover/btn:-translate-x-1 transition-transform duration-300 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>

                <!-- Visual Card -->
                <div class="relative group" data-aos="fade-left" data-aos-delay="100">
                    <div class="relative bg-gradient-to-br from-blue-500 to-blue-600 rounded-3xl p-12 text-white overflow-hidden shadow-2xl transform group-hover:scale-105 transition-all duration-500">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-400/20 to-transparent"></div>
                        <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl -mr-32 -mt-32"></div>
                        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/5 rounded-full blur-2xl -ml-24 -mb-24"></div>
                        
                        <div class="relative z-10 flex items-center justify-center h-64">
                            <svg class="w-48 h-48 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Use Case 2: High Traffic Websites (Image Left) -->
            <div class="grid lg:grid-cols-2 gap-12 items-center" data-aos="fade-up">
                <!-- Visual Card -->
                <div class="relative group lg:order-1 order-2" data-aos="fade-right" data-aos-delay="100">
                    <div class="relative bg-gradient-to-br from-purple-500 to-pink-600 rounded-3xl p-12 text-white overflow-hidden shadow-2xl transform group-hover:scale-105 transition-all duration-500">
                        <div class="absolute inset-0 bg-gradient-to-br from-purple-400/20 to-transparent"></div>
                        <div class="absolute top-0 left-0 w-96 h-96 bg-white/10 rounded-full blur-3xl -ml-32 -mt-32"></div>
                        <div class="absolute bottom-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-2xl -mr-24 -mb-24"></div>
                        
                        <div class="relative z-10 flex items-center justify-center h-64">
                            <svg class="w-48 h-48 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="lg:pl-12 rtl:lg:pl-0 rtl:lg:pr-12 lg:order-2 order-1">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-purple-100 text-purple-600 rounded-full text-sm font-semibold mb-6">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        {{ __('frontend.high_traffic_websites') }}
                    </div>
                    
                    <h3 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                        {{ __('frontend.high_traffic_websites') }}
                    </h3>
                    
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        {{ __('frontend.high_traffic_websites_desc') }}
                    </p>

                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start gap-3 group/item">
                            <div class="flex-shrink-0 w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mt-0.5 group-hover/item:bg-purple-600 transition-colors duration-300">
                                <svg class="w-5 h-5 text-purple-600 group-hover/item:text-white transition-colors duration-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 text-lg font-medium">{{ __('frontend.handle_millions_requests') }}</span>
                        </li>
                        <li class="flex items-start gap-3 group/item">
                            <div class="flex-shrink-0 w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mt-0.5 group-hover/item:bg-purple-600 transition-colors duration-300">
                                <svg class="w-5 h-5 text-purple-600 group-hover/item:text-white transition-colors duration-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 text-lg font-medium">{{ __('frontend.optimized_performance') }}</span>
                        </li>
                    </ul>

                    <a href="#plans" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-xl font-semibold hover:from-purple-700 hover:to-pink-700 transition-all duration-300 shadow-lg hover:shadow-xl group/btn">
                        <span>{{ __('frontend.learn_more') }}</span>
                        <svg class="w-5 h-5 group-hover/btn:translate-x-1 rtl:group-hover/btn:-translate-x-1 transition-transform duration-300 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Use Case 3: Database Hosting (Image Right) -->
            <div class="grid lg:grid-cols-2 gap-12 items-center" data-aos="fade-up">
                <!-- Content -->
                <div class="lg:pr-12 rtl:lg:pr-0 rtl:lg:pl-12">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-100 text-emerald-600 rounded-full text-sm font-semibold mb-6">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                        </svg>
                        {{ __('frontend.database_hosting') }}
                    </div>
                    
                    <h3 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                        {{ __('frontend.database_hosting') }}
                    </h3>
                    
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        {{ __('frontend.database_hosting_desc') }}
                    </p>

                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start gap-3 group/item">
                            <div class="flex-shrink-0 w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center mt-0.5 group-hover/item:bg-emerald-600 transition-colors duration-300">
                                <svg class="w-5 h-5 text-emerald-600 group-hover/item:text-white transition-colors duration-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 text-lg font-medium">{{ __('frontend.high_iops_storage') }}</span>
                        </li>
                        <li class="flex items-start gap-3 group/item">
                            <div class="flex-shrink-0 w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center mt-0.5 group-hover/item:bg-emerald-600 transition-colors duration-300">
                                <svg class="w-5 h-5 text-emerald-600 group-hover/item:text-white transition-colors duration-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 text-lg font-medium">{{ __('frontend.automated_backups') }}</span>
                        </li>
                    </ul>

                    <a href="#plans" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-xl font-semibold hover:from-emerald-700 hover:to-teal-700 transition-all duration-300 shadow-lg hover:shadow-xl group/btn">
                        <span>{{ __('frontend.learn_more') }}</span>
                        <svg class="w-5 h-5 group-hover/btn:translate-x-1 rtl:group-hover/btn:-translate-x-1 transition-transform duration-300 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>

                <!-- Visual Card -->
                <div class="relative group" data-aos="fade-left" data-aos-delay="100">
                    <div class="relative bg-gradient-to-br from-emerald-500 to-teal-600 rounded-3xl p-12 text-white overflow-hidden shadow-2xl transform group-hover:scale-105 transition-all duration-500">
                        <div class="absolute inset-0 bg-gradient-to-br from-emerald-400/20 to-transparent"></div>
                        <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl -mr-32 -mt-32"></div>
                        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/5 rounded-full blur-2xl -ml-24 -mb-24"></div>
                        
                        <div class="relative z-10 flex items-center justify-center h-64">
                            <svg class="w-48 h-48 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Use Case 4: AI/ML Workloads (Image Left) -->
            <div class="grid lg:grid-cols-2 gap-12 items-center" data-aos="fade-up">
                <!-- Visual Card -->
                <div class="relative group lg:order-1 order-2" data-aos="fade-right" data-aos-delay="100">
                    <div class="relative bg-gradient-to-br from-orange-500 to-red-600 rounded-3xl p-12 text-white overflow-hidden shadow-2xl transform group-hover:scale-105 transition-all duration-500">
                        <div class="absolute inset-0 bg-gradient-to-br from-orange-400/20 to-transparent"></div>
                        <div class="absolute top-0 left-0 w-96 h-96 bg-white/10 rounded-full blur-3xl -ml-32 -mt-32"></div>
                        <div class="absolute bottom-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-2xl -mr-24 -mb-24"></div>
                        
                        <div class="relative z-10 flex items-center justify-center h-64">
                            <svg class="w-48 h-48 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="lg:pl-12 rtl:lg:pl-0 rtl:lg:pr-12 lg:order-2 order-1">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-orange-100 text-orange-600 rounded-full text-sm font-semibold mb-6">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                        {{ __('frontend.ai_ml_workloads') }}
                    </div>
                    
                    <h3 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                        {{ __('frontend.ai_ml_workloads') }}
                    </h3>
                    
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        {{ __('frontend.ai_ml_workloads_desc') }}
                    </p>

                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start gap-3 group/item">
                            <div class="flex-shrink-0 w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mt-0.5 group-hover/item:bg-orange-600 transition-colors duration-300">
                                <svg class="w-5 h-5 text-orange-600 group-hover/item:text-white transition-colors duration-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 text-lg font-medium">{{ __('frontend.powerful_processors') }}</span>
                        </li>
                        <li class="flex items-start gap-3 group/item">
                            <div class="flex-shrink-0 w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mt-0.5 group-hover/item:bg-orange-600 transition-colors duration-300">
                                <svg class="w-5 h-5 text-orange-600 group-hover/item:text-white transition-colors duration-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 text-lg font-medium">{{ __('frontend.large_ram_capacity') }}</span>
                        </li>
                    </ul>

                    <a href="#plans" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-orange-600 to-red-600 text-white rounded-xl font-semibold hover:from-orange-700 hover:to-red-700 transition-all duration-300 shadow-lg hover:shadow-xl group/btn">
                        <span>{{ __('frontend.learn_more') }}</span>
                        <svg class="w-5 h-5 group-hover/btn:translate-x-1 rtl:group-hover/btn:-translate-x-1 transition-transform duration-300 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Management Tools Section -->
<section class="py-24 bg-white relative overflow-hidden">
    <!-- Minimal Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, #6366f1 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Section Header - Minimal -->
        <div class="text-center mb-20" data-aos="fade-up">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-gray-900 text-white rounded-full text-sm font-medium mb-6">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                </svg>
                {{ __('frontend.management_tools') }}
            </div>
            <h2 class="text-5xl sm:text-6xl font-bold text-gray-900 mb-6 tracking-tight">
                {{ __('frontend.powerful_control_panel') }}
            </h2>
            <p class="text-xl text-gray-500 max-w-2xl mx-auto font-light">
                {{ __('frontend.powerful_control_panel_desc') }}
            </p>
        </div>

        <!-- Grid - Minimal Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Card 1: IPMI Access -->
            <div class="group relative bg-white rounded-2xl p-8 border border-gray-200 hover:border-gray-900 hover:shadow-xl transition-all duration-300" data-aos="fade-up" data-aos-delay="100">
                <!-- Icon -->
                <div class="w-14 h-14 bg-gray-900 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                
                <!-- Content -->
                <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-gray-900">
                    {{ __('frontend.ipmi_access') }}
                </h3>
                <p class="text-gray-600 leading-relaxed text-sm">
                    {{ __('frontend.ipmi_access_desc') }}
                </p>

                <!-- Hover Accent Line -->
                <div class="absolute bottom-0 left-0 w-0 h-1 bg-gray-900 group-hover:w-full transition-all duration-500 rounded-b-2xl"></div>
            </div>

            <!-- Card 2: OS Reload -->
            <div class="group relative bg-white rounded-2xl p-8 border border-gray-200 hover:border-gray-900 hover:shadow-xl transition-all duration-300" data-aos="fade-up" data-aos-delay="200">
                <div class="w-14 h-14 bg-gray-900 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </div>
                
                <h3 class="text-xl font-bold text-gray-900 mb-3">
                    {{ __('frontend.os_reload') }}
                </h3>
                <p class="text-gray-600 leading-relaxed text-sm">
                    {{ __('frontend.os_reload_desc') }}
                </p>

                <div class="absolute bottom-0 left-0 w-0 h-1 bg-gray-900 group-hover:w-full transition-all duration-500 rounded-b-2xl"></div>
            </div>

            <!-- Card 3: Real-time Monitoring -->
            <div class="group relative bg-white rounded-2xl p-8 border border-gray-200 hover:border-gray-900 hover:shadow-xl transition-all duration-300" data-aos="fade-up" data-aos-delay="300">
                <div class="w-14 h-14 bg-gray-900 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                
                <h3 class="text-xl font-bold text-gray-900 mb-3">
                    {{ __('frontend.real_time_monitoring') }}
                </h3>
                <p class="text-gray-600 leading-relaxed text-sm">
                    {{ __('frontend.real_time_monitoring_desc') }}
                </p>

                <div class="absolute bottom-0 left-0 w-0 h-1 bg-gray-900 group-hover:w-full transition-all duration-500 rounded-b-2xl"></div>
            </div>

            <!-- Card 4: Firewall Management -->
            <div class="group relative bg-white rounded-2xl p-8 border border-gray-200 hover:border-gray-900 hover:shadow-xl transition-all duration-300" data-aos="fade-up" data-aos-delay="100">
                <div class="w-14 h-14 bg-gray-900 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                
                <h3 class="text-xl font-bold text-gray-900 mb-3">
                    {{ __('frontend.firewall_management') }}
                </h3>
                <p class="text-gray-600 leading-relaxed text-sm">
                    {{ __('frontend.firewall_management_desc') }}
                </p>

                <div class="absolute bottom-0 left-0 w-0 h-1 bg-gray-900 group-hover:w-full transition-all duration-500 rounded-b-2xl"></div>
            </div>

            <!-- Card 5: Backup Solutions -->
            <div class="group relative bg-white rounded-2xl p-8 border border-gray-200 hover:border-gray-900 hover:shadow-xl transition-all duration-300" data-aos="fade-up" data-aos-delay="200">
                <div class="w-14 h-14 bg-gray-900 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                    </svg>
                </div>
                
                <h3 class="text-xl font-bold text-gray-900 mb-3">
                    {{ __('frontend.backup_solutions') }}
                </h3>
                <p class="text-gray-600 leading-relaxed text-sm">
                    {{ __('frontend.backup_solutions_desc') }}
                </p>

                <div class="absolute bottom-0 left-0 w-0 h-1 bg-gray-900 group-hover:w-full transition-all duration-500 rounded-b-2xl"></div>
            </div>

            <!-- Card 6: Reverse DNS -->
            <div class="group relative bg-white rounded-2xl p-8 border border-gray-200 hover:border-gray-900 hover:shadow-xl transition-all duration-300" data-aos="fade-up" data-aos-delay="300">
                <div class="w-14 h-14 bg-gray-900 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                    </svg>
                </div>
                
                <h3 class="text-xl font-bold text-gray-900 mb-3">
                    {{ __('frontend.reverse_dns') }}
                </h3>
                <p class="text-gray-600 leading-relaxed text-sm">
                    {{ __('frontend.reverse_dns_desc') }}
                </p>

                <div class="absolute bottom-0 left-0 w-0 h-1 bg-gray-900 group-hover:w-full transition-all duration-500 rounded-b-2xl"></div>
            </div>
        </div>

        <!-- Bottom CTA - Minimal -->
        <div class="mt-16 text-center" data-aos="fade-up">
            <a href="#plans" class="inline-flex items-center gap-3 px-8 py-4 bg-gray-900 hover:bg-gray-800 text-white font-medium rounded-full transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-xl">
                <span>{{ __('frontend.explore_all_features') }}</span>
                <svg class="w-5 h-5 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Dedicated Resources & Features Section (Zigzag Design) -->
<section class="py-24 bg-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Row 1: 100% Yours (Image Right) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-32">
            <!-- Content Left -->
            <div class="order-2 lg:order-1" data-aos="fade-right">
                <div class="inline-block px-4 py-2 bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-600 rounded-full text-sm font-semibold mb-6">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
                        </svg>
                        {{ __('frontend.dedicated_resources_badge') }}
                    </span>
                </div>
                
                <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                    {{ __('frontend.yours_no_sharing') }}<br>
                    <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">{{ __('frontend.no_sharing_resources') }}</span>
                </h2>
                
                <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                    {{ __('frontend.yours_description') }}
                </p>

                <div class="space-y-4">
                    <div class="flex items-start gap-4 p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors duration-300">
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-1">{{ __('frontend.full_root_access') }}</h4>
                            <p class="text-gray-600 text-sm">{{ __('frontend.full_root_access_desc') }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors duration-300">
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-1">{{ __('frontend.maximum_performance') }}</h4>
                            <p class="text-gray-600 text-sm">{{ __('frontend.maximum_performance_desc') }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors duration-300">
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-1">{{ __('frontend.enhanced_security') }}</h4>
                            <p class="text-gray-600 text-sm">{{ __('frontend.enhanced_security_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image Right -->
            <div class="order-1 lg:order-2" data-aos="fade-left">
                <div class="relative">
                    <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-3xl p-8 shadow-2xl transform hover:scale-105 transition-transform duration-500">
                        <div class="bg-white/10 backdrop-blur-xl rounded-2xl p-6 border border-white/20">
                            <!-- Server Stats -->
                            <div class="text-white mb-6">
                                <div class="text-sm opacity-80 mb-2">{{ __('frontend.server_resources') }}</div>
                                <div class="text-3xl font-bold">{{ __('frontend.dedicated_100') }}</div>
                            </div>

                            <!-- Resource Bars -->
                            <div class="space-y-4">
                                <div>
                                    <div class="flex justify-between text-white/90 text-sm mb-2">
                                        <span>{{ __('frontend.cpu_usage') }}</span>
                                        <span>{{ __('frontend.available_100') }}</span>
                                    </div>
                                    <div class="h-3 bg-white/20 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-green-400 to-emerald-500 rounded-full" style="width: 100%"></div>
                                    </div>
                                </div>

                                <div>
                                    <div class="flex justify-between text-white/90 text-sm mb-2">
                                        <span>{{ __('frontend.ram') }}</span>
                                        <span>{{ __('frontend.available_100') }}</span>
                                    </div>
                                    <div class="h-3 bg-white/20 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-blue-400 to-blue-500 rounded-full" style="width: 100%"></div>
                                    </div>
                                </div>

                                <div>
                                    <div class="flex justify-between text-white/90 text-sm mb-2">
                                        <span>{{ __('frontend.storage') }}</span>
                                        <span>{{ __('frontend.available_100') }}</span>
                                    </div>
                                    <div class="h-3 bg-white/20 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-purple-400 to-purple-500 rounded-full" style="width: 100%"></div>
                                    </div>
                                </div>

                                <div>
                                    <div class="flex justify-between text-white/90 text-sm mb-2">
                                        <span>{{ __('frontend.bandwidth') }}</span>
                                        <span>{{ __('frontend.available_100') }}</span>
                                    </div>
                                    <div class="h-3 bg-white/20 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-orange-400 to-red-500 rounded-full" style="width: 100%"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- No Sharing Badge -->
                            <div class="mt-6 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl p-4 text-center">
                                <div class="text-white font-bold text-lg">{{ __('frontend.no_resource_sharing') }}</div>
                                <div class="text-white/90 text-sm">{{ __('frontend.all_power_dedicated') }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Floating Elements -->
                    <div class="absolute -top-6 -right-6 w-24 h-24 bg-blue-500/20 rounded-full blur-2xl"></div>
                    <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-indigo-500/20 rounded-full blur-2xl"></div>
                </div>
            </div>
        </div>

        <!-- Row 2: Datacenter Reliability (Image Left) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-32">
            <!-- Image Left -->
            <div class="order-1" data-aos="fade-right">
                <div class="relative">
                    <div class="bg-gradient-to-br from-purple-600 to-pink-600 rounded-3xl p-8 shadow-2xl transform hover:scale-105 transition-transform duration-500">
                        <div class="bg-white/10 backdrop-blur-xl rounded-2xl p-6 border border-white/20">
                            <!-- Datacenter Info -->
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-16 h-16 bg-white/20 rounded-xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <div class="text-white">
                                    <div class="text-sm opacity-80">{{ __('frontend.hosted_in') }}</div>
                                    <div class="text-2xl font-bold">{{ __('frontend.phoenixnap_datacenter') }}</div>
                                    <div class="text-sm opacity-90">{{ __('frontend.arizona_usa') }}</div>
                                </div>
                            </div>

                            <!-- Features Grid -->
                            <div class="grid grid-cols-2 gap-3 mb-4">
                                <div class="bg-white/10 rounded-lg p-3 text-center border border-white/20">
                                    <div class="text-2xl font-bold text-white">99.9%</div><div class="text-xs text-white/80">{{ __("frontend.uptime_sla") }}</div>
                                </div>
                                <div class="bg-white/10 rounded-lg p-3 text-center border border-white/20">
                                    <div class="text-2xl font-bold text-white">24/7</div><div class="text-xs text-white/80">{{ __("frontend.monitoring") }}</div>
                                </div>
                                <div class="bg-white/10 rounded-lg p-3 text-center border border-white/20">
                                    <div class="text-2xl font-bold text-white">Tier III</div><div class="text-xs text-white/80">{{ __("frontend.tier_infrastructure") }}</div>
                                </div>
                                <div class="bg-white/10 rounded-lg p-3 text-center border border-white/20">
                                    <div class="text-2xl font-bold text-white">N+1</div><div class="text-xs text-white/80">{{ __("frontend.redundancy") }}</div>
                                </div>
                            </div>

                            <!-- Certified Badge -->
                            <div class="flex items-center justify-center gap-3 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl p-3">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-white font-bold">{{ __("frontend.enterprise_certified") }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Decorative Elements -->
                    <div class="absolute -top-6 -left-6 w-24 h-24 bg-purple-500/20 rounded-full blur-2xl"></div>
                    <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-pink-500/20 rounded-full blur-2xl"></div>
                </div>
            </div>

            <!-- Content Right -->
            <div class="order-2" data-aos="fade-left">
                <div class="inline-block px-4 py-2 bg-gradient-to-r from-purple-100 to-pink-100 text-purple-600 rounded-full text-sm font-semibold mb-6">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z" clip-rule="evenodd"></path>
                        </svg>
                        {{ __('frontend.infrastructure_badge') }}
                    </span>
                </div>
                
                <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                    {{ __('frontend.datacenter_powered') }}
                    <span class="bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent block">{{ __("frontend.reliability") }}</span>
                </h2>
                
                <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                    {{ __('frontend.datacenter_description') }}
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-6 border-2 border-purple-200 hover:shadow-lg transition-all duration-300">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                            </svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">{{ __("frontend.enterprise_processors") }}</h4>
                        <p class="text-gray-600 text-sm">{{ __("frontend.enterprise_processors_desc") }}</p>
                    </div>

                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-6 border-2 border-purple-200 hover:shadow-lg transition-all duration-300">
                        <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-pink-600 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">{{ __("frontend.ecc_memory") }}</h4>
                        <p class="text-gray-600 text-sm">{{ __("frontend.ecc_memory_desc") }}</p>
                    </div>

                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-6 border-2 border-purple-200 hover:shadow-lg transition-all duration-300">
                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">{{ __("frontend.redundant_network") }}</h4>
                        <p class="text-gray-600 text-sm">{{ __("frontend.redundant_network_desc") }}</p>
                    </div>

                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-6 border-2 border-purple-200 hover:shadow-lg transition-all duration-300">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">{{ __("frontend.raid_storage") }}</h4>
                        <p class="text-gray-600 text-sm">{{ __("frontend.raid_storage_desc") }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 3: 24/7 Support (Image Right) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-32">
            <!-- Content Left -->
            <div class="order-2 lg:order-1" data-aos="fade-right">
                <div class="inline-block px-4 py-2 bg-gradient-to-r from-green-100 to-emerald-100 text-green-600 rounded-full text-sm font-semibold mb-6">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                        </svg>
                        {{ __('frontend.customer_support') }}
                    </span>
                </div>
                
                <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                    {{ __('frontend.support_247') }}
                    <span class="bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent block">{{ __('frontend.expert_support_badge') }}</span>
                </h2>
                
                <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                    {{ __('frontend.support_description') }}
                </p>

                <div class="space-y-4 mb-8">
                    <div class="flex items-start gap-4 p-5 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border-2 border-green-200 hover:shadow-lg transition-all duration-300">
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-1">{{ __("frontend.round_clock") }}</h4>
                            <p class="text-gray-600 text-sm">{{ __("frontend.round_clock_desc") }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-5 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border-2 border-green-200 hover:shadow-lg transition-all duration-300">
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-1">{{ __("frontend.technical_experts") }}</h4>
                            <p class="text-gray-600 text-sm">{{ __("frontend.technical_experts_desc") }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-5 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border-2 border-green-200 hover:shadow-lg transition-all duration-300">
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-1">{{ __("frontend.proactive_monitoring") }}</h4>
                            <p class="text-gray-600 text-sm">{{ __("frontend.proactive_monitoring_desc") }}</p>
                        </div>
                    </div>
                </div>

                <!-- Support Channels -->
                <div class="flex flex-wrap gap-3">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white border-2 border-gray-200 rounded-lg text-sm font-semibold text-gray-700 hover:border-green-500 transition-colors duration-300">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        {{ __('frontend.live_chat') }}
                    </div>
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white border-2 border-gray-200 rounded-lg text-sm font-semibold text-gray-700 hover:border-green-500 transition-colors duration-300">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        {{ __('frontend.phone_support') }}
                    </div>
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white border-2 border-gray-200 rounded-lg text-sm font-semibold text-gray-700 hover:border-green-500 transition-colors duration-300">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                        {{ __('frontend.ticket_system') }}
                    </div>
                </div>
            </div>

            <!-- Image Right -->
            <div class="order-1 lg:order-2" data-aos="fade-left">
                <div class="relative">
                    <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-3xl p-8 shadow-2xl transform hover:scale-105 transition-transform duration-500">
                        <div class="bg-white/10 backdrop-blur-xl rounded-2xl p-6 border border-white/20">
                            <!-- Support Header -->
                            <div class="flex items-center justify-between mb-6">
                                <div class="text-white">
                                    <div class="text-sm opacity-80">{{ __("frontend.support_status") }}</div>
                                    <div class="text-2xl font-bold">{{ __("frontend.always_online") }}</div>
                                </div>
                                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center animate-pulse">
                                    <div class="w-4 h-4 bg-green-400 rounded-full"></div>
                                </div>
                            </div>

                            <!-- Response Time -->
                            <div class="bg-white/10 rounded-xl p-4 mb-4 border border-white/20">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-white/80 text-sm">{{ __("frontend.avg_response_time") }}</span>
                                    <span class="text-white font-bold">{{ __("frontend.less_5_min") }}</span>
                                </div>
                                <div class="h-2 bg-white/20 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-green-400 to-emerald-500 rounded-full animate-pulse" style="width: 95%"></div>
                                </div>
                            </div>

                            <!-- Support Stats -->
                            <div class="grid grid-cols-3 gap-3 mb-4">
                                <div class="bg-white/10 rounded-lg p-3 text-center border border-white/20">
                                    <div class="text-2xl font-bold text-white">99.8%</div><div class="text-xs text-white/80">{{ __("frontend.satisfaction") }}</div>
                                </div>
                                <div class="bg-white/10 rounded-lg p-3 text-center border border-white/20">
                                    <div class="text-2xl font-bold text-white">24/7</div><div class="text-xs text-white/80">{{ __("frontend.available") }}</div>
                                </div>
                                <div class="bg-white/10 rounded-lg p-3 text-center border border-white/20">
                                    <div class="text-2xl font-bold text-white">365</div><div class="text-xs text-white/80">{{ __("frontend.days_year") }}</div>
                                </div>
                            </div>

                            <!-- Support Team -->
                            <div class="bg-gradient-to-r from-white/10 to-white/5 rounded-xl p-4 border border-white/20">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="flex -space-x-2">
                                        <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-500 rounded-full border-2 border-white"></div>
                                        <div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-purple-500 rounded-full border-2 border-white"></div>
                                        <div class="w-8 h-8 bg-gradient-to-br from-pink-400 to-pink-500 rounded-full border-2 border-white"></div>
                                        <div class="w-8 h-8 bg-gradient-to-br from-orange-400 to-orange-500 rounded-full border-2 border-white flex items-center justify-center text-white text-xs font-bold">+5</div>
                                    </div>
                                    <div class="text-white text-sm">
                                        <div class="font-bold">{{ __("frontend.expert_team") }}</div>
                                        <div class="text-white/80 text-xs">{{ __("frontend.expert_team_desc") }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Floating Badge -->
                    <div class="absolute -top-4 -right-4 bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-4 py-2 rounded-full shadow-lg text-sm font-semibold animate-bounce">
                        {{ __('frontend.pro_gineous_support') }}
                    </div>

                    <!-- Decorative Elements -->
                    <div class="absolute -bottom-4 -left-4 w-24 h-24 bg-green-500/20 rounded-full blur-2xl"></div>
                    <div class="absolute -top-8 -right-8 w-32 h-32 bg-emerald-500/20 rounded-full blur-2xl"></div>
                </div>
            </div>
        </div>

        <!-- Row 4: Server Level Choice (Image Left) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Image Left -->
            <div class="order-1" data-aos="fade-right">
                <div class="relative">
                    <div class="bg-gradient-to-br from-orange-500 to-red-600 rounded-3xl p-8 shadow-2xl transform hover:scale-105 transition-transform duration-500">
                        <div class="bg-white/10 backdrop-blur-xl rounded-2xl p-6 border border-white/20">
                            <!-- Server Tiers -->
                            <div class="text-white mb-6">
                                <div class="text-sm opacity-80 mb-2">{{ __("frontend.server_configurations") }}</div>
                                <div class="text-3xl font-bold">{{ __("frontend.choose_your_level") }}</div>
                            </div>

                            <!-- Tier Cards -->
                            <div class="space-y-3">
                                <div class="bg-gradient-to-r from-blue-500/30 to-blue-600/30 backdrop-blur-sm rounded-xl p-4 border border-white/30 hover:scale-105 transition-transform duration-300">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-white font-bold text-lg">{{ __("frontend.entry_level") }}</span>
                                        <span class="px-3 py-1 bg-blue-500 text-white text-xs font-bold rounded-full">{{ __("frontend.basic_badge") }}</span>
                                    </div>
                                    <p class="text-white/80 text-sm">{{ __("frontend.entry_level_desc") }}</p>
                                </div>

                                <div class="bg-gradient-to-r from-purple-500/30 to-purple-600/30 backdrop-blur-sm rounded-xl p-4 border border-white/30 hover:scale-105 transition-transform duration-300">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-white font-bold text-lg">{{ __("frontend.medium") }}</span>
                                        <span class="px-3 py-1 bg-purple-500 text-white text-xs font-bold rounded-full">{{ __("frontend.popular_badge") }}</span>
                                    </div>
                                    <p class="text-white/80 text-sm">{{ __("frontend.medium_desc") }}</p>
                                </div>

                                <div class="bg-gradient-to-r from-orange-500/30 to-red-600/30 backdrop-blur-sm rounded-xl p-4 border border-white/30 hover:scale-105 transition-transform duration-300">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-white font-bold text-lg">{{ __("frontend.advanced") }}</span>
                                        <span class="px-3 py-1 bg-gradient-to-r from-yellow-400 to-orange-500 text-white text-xs font-bold rounded-full">{{ __("frontend.pro_badge") }}</span>
                                    </div>
                                    <p class="text-white/80 text-sm">{{ __("frontend.advanced_desc") }}</p>
                                </div>
                            </div>

                            <!-- Customization Badge -->
                            <div class="mt-6 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl p-4 text-center">
                                <div class="flex items-center justify-center gap-2 text-white font-bold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                                    </svg>
                                    {{ __('frontend.fully_customizable') }}
                                </div>
                                <div class="text-white/90 text-sm mt-1">{{ __('frontend.cpu_ram_storage_raid') }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Decorative Elements -->
                    <div class="absolute -top-6 -left-6 w-24 h-24 bg-orange-500/20 rounded-full blur-2xl"></div>
                    <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-red-500/20 rounded-full blur-2xl"></div>
                </div>
            </div>

            <!-- Content Right -->
            <div class="order-2" data-aos="fade-left">
                <div class="inline-block px-4 py-2 bg-gradient-to-r from-orange-100 to-red-100 text-orange-600 rounded-full text-sm font-semibold mb-6">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                        {{ __('frontend.flexible_configuration') }}
                    </span>
                </div>
                
                <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                    {{ __('frontend.server_level_choice') }}
                </h2>
                
                <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                    {{ __('frontend.server_level_choice_desc') }}
                </p>

                <div class="space-y-4">
                    <div class="flex items-start gap-4 group">
                        <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-1">{{ __('frontend.entry_level_servers') }}</h4>
                            <p class="text-gray-600 text-sm">{{ __('frontend.entry_level_servers_desc') }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 group">
                        <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-1">{{ __('frontend.medium_servers') }}</h4>
                            <p class="text-gray-600 text-sm">{{ __('frontend.medium_servers_desc') }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 group">
                        <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-orange-500 to-red-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-1">{{ __('frontend.advanced_servers') }}</h4>
                            <p class="text-gray-600 text-sm">{{ __('frontend.advanced_servers_desc') }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 bg-gradient-to-br from-orange-50 to-red-50 rounded-2xl p-6 border-2 border-orange-200">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <svg class="w-12 h-12 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-2">{{ __('frontend.custom_config_available') }}</h4>
                            <p class="text-gray-600 text-sm mb-3">{{ __('frontend.mix_and_match_desc') }}</p>
                            <a href="#plans" class="inline-flex items-center text-orange-600 font-semibold hover:text-orange-700 transition-colors duration-300">
                                {{ __('frontend.view_all_plans') }}
                                <svg class="w-4 h-4 ml-2 rtl:mr-2 rtl:ml-0 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQs Section - Modern Design -->
<section class="py-24 bg-white relative overflow-hidden">
    <!-- Minimal Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, #6366f1 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-gray-900 text-white rounded-full text-sm font-medium mb-6">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ __('frontend.faq_section') }}
            </div>
            <h2 class="text-5xl sm:text-6xl font-bold text-gray-900 mb-6 tracking-tight">
                {{ __('frontend.dedicated_servers_faqs') }}
            </h2>
            <p class="text-xl text-gray-500 max-w-2xl mx-auto font-light">
                {{ __('frontend.dedicated_faqs_description') }}
            </p>
        </div>

        <!-- FAQ Grid - Two Columns Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <!-- FAQ 1 -->
            <div class="group" data-aos="fade-up" data-aos-delay="50">
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:border-gray-900 hover:shadow-lg transition-all duration-300">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-5 text-left rtl:text-right flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="text-lg font-semibold text-gray-900 ltr:pr-6 rtl:pl-6 group-hover:text-gray-900">
                            {{ __('frontend.faq_what_is_dedicated') }}
                        </span>
                        <div class="flex-shrink-0 w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center group-hover:bg-gray-800 transition-colors">
                            <svg class="w-5 h-5 text-white transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div class="faq-content px-6 text-gray-600 leading-relaxed text-left rtl:text-right" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out;">
                        <div class="pb-5 pt-2 border-t border-gray-100">
                            <p>{{ __('frontend.faq_what_is_dedicated_answer') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ 2 -->
            <div class="group" data-aos="fade-up" data-aos-delay="100">
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:border-gray-900 hover:shadow-lg transition-all duration-300">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-5 text-left rtl:text-right flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="text-lg font-semibold text-gray-900 ltr:pr-6 rtl:pl-6 group-hover:text-gray-900">
                            {{ __('frontend.faq_dedicated_vs_vps') }}
                        </span>
                        <div class="flex-shrink-0 w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center group-hover:bg-gray-800 transition-colors">
                            <svg class="w-5 h-5 text-white transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div class="faq-content px-6 text-gray-600 leading-relaxed text-left rtl:text-right" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out;">
                        <div class="pb-5 pt-2 border-t border-gray-100">
                            <p>{{ __('frontend.faq_dedicated_vs_vps_answer') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ 3 -->
            <div class="group" data-aos="fade-up" data-aos-delay="150">
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:border-gray-900 hover:shadow-lg transition-all duration-300">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-5 text-left rtl:text-right flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="text-lg font-semibold text-gray-900 ltr:pr-6 rtl:pl-6 group-hover:text-gray-900">
                            {{ __('frontend.faq_managed_unmanaged') }}
                        </span>
                        <div class="flex-shrink-0 w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center group-hover:bg-gray-800 transition-colors">
                            <svg class="w-5 h-5 text-white transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div class="faq-content px-6 text-gray-600 leading-relaxed text-left rtl:text-right" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out;">
                        <div class="pb-5 pt-2 border-t border-gray-100">
                            <p>{{ __('frontend.faq_managed_unmanaged_answer') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ 4 -->
            <div class="group" data-aos="fade-up" data-aos-delay="200">
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:border-gray-900 hover:shadow-lg transition-all duration-300">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-5 text-left rtl:text-right flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="text-lg font-semibold text-gray-900 ltr:pr-6 rtl:pl-6 group-hover:text-gray-900">
                            {{ __('frontend.faq_deployment_time') }}
                        </span>
                        <div class="flex-shrink-0 w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center group-hover:bg-gray-800 transition-colors">
                            <svg class="w-5 h-5 text-white transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div class="faq-content px-6 text-gray-600 leading-relaxed text-left rtl:text-right" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out;">
                        <div class="pb-5 pt-2 border-t border-gray-100">
                            <p>{{ __('frontend.faq_deployment_time_answer') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ 5 -->
            <div class="group" data-aos="fade-up" data-aos-delay="250">
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:border-gray-900 hover:shadow-lg transition-all duration-300">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-5 text-left rtl:text-right flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="text-lg font-semibold text-gray-900 ltr:pr-6 rtl:pl-6 group-hover:text-gray-900">
                            {{ __('frontend.faq_upgrade_downgrade') }}
                        </span>
                        <div class="flex-shrink-0 w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center group-hover:bg-gray-800 transition-colors">
                            <svg class="w-5 h-5 text-white transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div class="faq-content px-6 text-gray-600 leading-relaxed text-left rtl:text-right" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out;">
                        <div class="pb-5 pt-2 border-t border-gray-100">
                            <p>{{ __('frontend.faq_upgrade_downgrade_answer') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ 6 -->
            <div class="group" data-aos="fade-up" data-aos-delay="300">
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:border-gray-900 hover:shadow-lg transition-all duration-300">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-5 text-left rtl:text-right flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="text-lg font-semibold text-gray-900 ltr:pr-6 rtl:pl-6 group-hover:text-gray-900">
                            {{ __('frontend.faq_bandwidth_included') }}
                        </span>
                        <div class="flex-shrink-0 w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center group-hover:bg-gray-800 transition-colors">
                            <svg class="w-5 h-5 text-white transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div class="faq-content px-6 text-gray-600 leading-relaxed text-left rtl:text-right" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out;">
                        <div class="pb-5 pt-2 border-t border-gray-100">
                            <p>{{ __('frontend.faq_bandwidth_included_answer') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ 7 -->
            <div class="group" data-aos="fade-up" data-aos-delay="350">
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:border-gray-900 hover:shadow-lg transition-all duration-300">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-5 text-left rtl:text-right flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="text-lg font-semibold text-gray-900 ltr:pr-6 rtl:pl-6 group-hover:text-gray-900">
                            {{ __('frontend.faq_backup_policy') }}
                        </span>
                        <div class="flex-shrink-0 w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center group-hover:bg-gray-800 transition-colors">
                            <svg class="w-5 h-5 text-white transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div class="faq-content px-6 text-gray-600 leading-relaxed text-left rtl:text-right" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out;">
                        <div class="pb-5 pt-2 border-t border-gray-100">
                            <p>{{ __('frontend.faq_backup_policy_answer') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ 8 -->
            <div class="group" data-aos="fade-up" data-aos-delay="400">
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:border-gray-900 hover:shadow-lg transition-all duration-300">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-5 text-left rtl:text-right flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="text-lg font-semibold text-gray-900 ltr:pr-6 rtl:pl-6 group-hover:text-gray-900">
                            {{ __('frontend.faq_support_level') }}
                        </span>
                        <div class="flex-shrink-0 w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center group-hover:bg-gray-800 transition-colors">
                            <svg class="w-5 h-5 text-white transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div class="faq-content px-6 text-gray-600 leading-relaxed text-left rtl:text-right" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out;">
                        <div class="pb-5 pt-2 border-t border-gray-100">
                            <p>{{ __('frontend.faq_support_level_answer') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ 9: What are Dedicated Servers used for? -->
            <div class="group" data-aos="fade-up" data-aos-delay="50">
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:border-gray-900 hover:shadow-lg transition-all duration-300">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-5 text-left rtl:text-right flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="text-lg font-semibold text-gray-900 ltr:pr-6 rtl:pl-6 group-hover:text-gray-900">
                            {{ __('frontend.faq_dedicated_uses') }}
                        </span>
                        <div class="flex-shrink-0 w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center group-hover:bg-gray-800 transition-colors">
                            <svg class="w-5 h-5 text-white transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div class="faq-content px-6 text-gray-600 leading-relaxed text-left rtl:text-right" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out;">
                        <div class="pb-5 pt-2 border-t border-gray-100">
                            <p>{{ __('frontend.faq_dedicated_uses_answer') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ 10: Windows Dedicated Server -->
            <div class="group" data-aos="fade-up" data-aos-delay="100">
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:border-gray-900 hover:shadow-lg transition-all duration-300">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-5 text-left rtl:text-right flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="text-lg font-semibold text-gray-900 ltr:pr-6 rtl:pl-6 group-hover:text-gray-900">
                            {{ __('frontend.faq_windows_server') }}
                        </span>
                        <div class="flex-shrink-0 w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center group-hover:bg-gray-800 transition-colors">
                            <svg class="w-5 h-5 text-white transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div class="faq-content px-6 text-gray-600 leading-relaxed text-left rtl:text-right" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out;">
                        <div class="pb-5 pt-2 border-t border-gray-100">
                            <p>{{ __('frontend.faq_windows_server_answer') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ 11: Security and Privacy -->
            <div class="group" data-aos="fade-up" data-aos-delay="150">
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:border-gray-900 hover:shadow-lg transition-all duration-300">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-5 text-left rtl:text-right flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="text-lg font-semibold text-gray-900 ltr:pr-6 rtl:pl-6 group-hover:text-gray-900">
                            {{ __('frontend.faq_security_privacy') }}
                        </span>
                        <div class="flex-shrink-0 w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center group-hover:bg-gray-800 transition-colors">
                            <svg class="w-5 h-5 text-white transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div class="faq-content px-6 text-gray-600 leading-relaxed text-left rtl:text-right" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out;">
                        <div class="pb-5 pt-2 border-t border-gray-100">
                            <p>{{ __('frontend.faq_security_privacy_answer') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ 12: VPS Upgrade to Dedicated -->
            <div class="group" data-aos="fade-up" data-aos-delay="200">
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:border-gray-900 hover:shadow-lg transition-all duration-300">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-5 text-left rtl:text-right flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="text-lg font-semibold text-gray-900 ltr:pr-6 rtl:pl-6 group-hover:text-gray-900">
                            {{ __('frontend.faq_vps_to_dedicated') }}
                        </span>
                        <div class="flex-shrink-0 w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center group-hover:bg-gray-800 transition-colors">
                            <svg class="w-5 h-5 text-white transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div class="faq-content px-6 text-gray-600 leading-relaxed text-left rtl:text-right" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out;">
                        <div class="pb-5 pt-2 border-t border-gray-100">
                            <p>{{ __('frontend.faq_vps_to_dedicated_answer') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ 13: Scaling -->
            <div class="group" data-aos="fade-up" data-aos-delay="250">
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:border-gray-900 hover:shadow-lg transition-all duration-300">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-5 text-left rtl:text-right flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="text-lg font-semibold text-gray-900 ltr:pr-6 rtl:pl-6 group-hover:text-gray-900">
                            {{ __('frontend.faq_scaling') }}
                        </span>
                        <div class="flex-shrink-0 w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center group-hover:bg-gray-800 transition-colors">
                            <svg class="w-5 h-5 text-white transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div class="faq-content px-6 text-gray-600 leading-relaxed text-left rtl:text-right" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out;">
                        <div class="pb-5 pt-2 border-t border-gray-100">
                            <p>{{ __('frontend.faq_scaling_answer') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ 14: Control Panel -->
            <div class="group" data-aos="fade-up" data-aos-delay="300">
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:border-gray-900 hover:shadow-lg transition-all duration-300">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-5 text-left rtl:text-right flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="text-lg font-semibold text-gray-900 ltr:pr-6 rtl:pl-6 group-hover:text-gray-900">
                            {{ __('frontend.faq_control_panel') }}
                        </span>
                        <div class="flex-shrink-0 w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center group-hover:bg-gray-800 transition-colors">
                            <svg class="w-5 h-5 text-white transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div class="faq-content px-6 text-gray-600 leading-relaxed text-left rtl:text-right" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out;">
                        <div class="pb-5 pt-2 border-t border-gray-100">
                            <p>{{ __('frontend.faq_control_panel_answer') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ 15: Number of Websites -->
            <div class="group" data-aos="fade-up" data-aos-delay="350">
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:border-gray-900 hover:shadow-lg transition-all duration-300">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-5 text-left rtl:text-right flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="text-lg font-semibold text-gray-900 ltr:pr-6 rtl:pl-6 group-hover:text-gray-900">
                            {{ __('frontend.faq_websites_limit') }}
                        </span>
                        <div class="flex-shrink-0 w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center group-hover:bg-gray-800 transition-colors">
                            <svg class="w-5 h-5 text-white transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div class="faq-content px-6 text-gray-600 leading-relaxed text-left rtl:text-right" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out;">
                        <div class="pb-5 pt-2 border-t border-gray-100">
                            <p>{{ __('frontend.faq_websites_limit_answer') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ 16: Root Access Management -->
            <div class="group" data-aos="fade-up" data-aos-delay="400">
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:border-gray-900 hover:shadow-lg transition-all duration-300">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-5 text-left rtl:text-right flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="text-lg font-semibold text-gray-900 ltr:pr-6 rtl:pl-6 group-hover:text-gray-900">
                            {{ __('frontend.faq_root_access') }}
                        </span>
                        <div class="flex-shrink-0 w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center group-hover:bg-gray-800 transition-colors">
                            <svg class="w-5 h-5 text-white transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div class="faq-content px-6 text-gray-600 leading-relaxed text-left rtl:text-right" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out;">
                        <div class="pb-5 pt-2 border-t border-gray-100">
                            <p>{{ __('frontend.faq_root_access_answer') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ 17: Setup Time and Fees -->
            <div class="group" data-aos="fade-up" data-aos-delay="50">
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:border-gray-900 hover:shadow-lg transition-all duration-300">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-5 text-left rtl:text-right flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="text-lg font-semibold text-gray-900 ltr:pr-6 rtl:pl-6 group-hover:text-gray-900">
                            {{ __('frontend.faq_setup_time_fees') }}
                        </span>
                        <div class="flex-shrink-0 w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center group-hover:bg-gray-800 transition-colors">
                            <svg class="w-5 h-5 text-white transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div class="faq-content px-6 text-gray-600 leading-relaxed text-left rtl:text-right" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out;">
                        <div class="pb-5 pt-2 border-t border-gray-100">
                            <p>{{ __('frontend.faq_setup_time_fees_answer') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ 18: Custom Software Installation -->
            <div class="group" data-aos="fade-up" data-aos-delay="100">
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:border-gray-900 hover:shadow-lg transition-all duration-300">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-5 text-left rtl:text-right flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="text-lg font-semibold text-gray-900 ltr:pr-6 rtl:pl-6 group-hover:text-gray-900">
                            {{ __('frontend.faq_custom_software') }}
                        </span>
                        <div class="flex-shrink-0 w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center group-hover:bg-gray-800 transition-colors">
                            <svg class="w-5 h-5 text-white transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div class="faq-content px-6 text-gray-600 leading-relaxed text-left rtl:text-right" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out;">
                        <div class="pb-5 pt-2 border-t border-gray-100">
                            <p>{{ __('frontend.faq_custom_software_answer') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ 19: Server Management Options -->
            <div class="group" data-aos="fade-up" data-aos-delay="150">
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:border-gray-900 hover:shadow-lg transition-all duration-300">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-5 text-left rtl:text-right flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="text-lg font-semibold text-gray-900 ltr:pr-6 rtl:pl-6 group-hover:text-gray-900">
                            {{ __('frontend.faq_management_options') }}
                        </span>
                        <div class="flex-shrink-0 w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center group-hover:bg-gray-800 transition-colors">
                            <svg class="w-5 h-5 text-white transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div class="faq-content px-6 text-gray-600 leading-relaxed text-left rtl:text-right" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out;">
                        <div class="pb-5 pt-2 border-t border-gray-100">
                            <p>{{ __('frontend.faq_management_options_answer') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ 20: Hardware Options -->
            <div class="group" data-aos="fade-up" data-aos-delay="200">
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:border-gray-900 hover:shadow-lg transition-all duration-300">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-5 text-left rtl:text-right flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="text-lg font-semibold text-gray-900 ltr:pr-6 rtl:pl-6 group-hover:text-gray-900">
                            {{ __('frontend.faq_hardware_options') }}
                        </span>
                        <div class="flex-shrink-0 w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center group-hover:bg-gray-800 transition-colors">
                            <svg class="w-5 h-5 text-white transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div class="faq-content px-6 text-gray-600 leading-relaxed text-left rtl:text-right" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out;">
                        <div class="pb-5 pt-2 border-t border-gray-100">
                            <p>{{ __('frontend.faq_hardware_options_answer') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ 21: E-commerce Support -->
            <div class="group" data-aos="fade-up" data-aos-delay="250">
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:border-gray-900 hover:shadow-lg transition-all duration-300">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-5 text-left rtl:text-right flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="text-lg font-semibold text-gray-900 ltr:pr-6 rtl:pl-6 group-hover:text-gray-900">
                            {{ __('frontend.faq_ecommerce_support') }}
                        </span>
                        <div class="flex-shrink-0 w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center group-hover:bg-gray-800 transition-colors">
                            <svg class="w-5 h-5 text-white transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div class="faq-content px-6 text-gray-600 leading-relaxed text-left rtl:text-right" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out;">
                        <div class="pb-5 pt-2 border-t border-gray-100">
                            <p>{{ __('frontend.faq_ecommerce_support_answer') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ 22: CloudLinux -->
            <div class="group" data-aos="fade-up" data-aos-delay="300">
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:border-gray-900 hover:shadow-lg transition-all duration-300">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-5 text-left rtl:text-right flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="text-lg font-semibold text-gray-900 ltr:pr-6 rtl:pl-6 group-hover:text-gray-900">
                            {{ __('frontend.faq_cloudlinux') }}
                        </span>
                        <div class="flex-shrink-0 w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center group-hover:bg-gray-800 transition-colors">
                            <svg class="w-5 h-5 text-white transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div class="faq-content px-6 text-gray-600 leading-relaxed text-left rtl:text-right" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out;">
                        <div class="pb-5 pt-2 border-t border-gray-100">
                            <p>{{ __('frontend.faq_cloudlinux_answer') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ 23: Private Network/VLAN -->
            <div class="group" data-aos="fade-up" data-aos-delay="350">
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:border-gray-900 hover:shadow-lg transition-all duration-300">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-5 text-left rtl:text-right flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="text-lg font-semibold text-gray-900 ltr:pr-6 rtl:pl-6 group-hover:text-gray-900">
                            {{ __('frontend.faq_private_network') }}
                        </span>
                        <div class="flex-shrink-0 w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center group-hover:bg-gray-800 transition-colors">
                            <svg class="w-5 h-5 text-white transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div class="faq-content px-6 text-gray-600 leading-relaxed text-left rtl:text-right" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out;">
                        <div class="pb-5 pt-2 border-t border-gray-100">
                            <p>{{ __('frontend.faq_private_network_answer') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ 24: Data Center Location -->
            <div class="group" data-aos="fade-up" data-aos-delay="400">
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:border-gray-900 hover:shadow-lg transition-all duration-300">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-5 text-left rtl:text-right flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="text-lg font-semibold text-gray-900 ltr:pr-6 rtl:pl-6 group-hover:text-gray-900">
                            {{ __('frontend.faq_datacenter_location') }}
                        </span>
                        <div class="flex-shrink-0 w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center group-hover:bg-gray-800 transition-colors">
                            <svg class="w-5 h-5 text-white transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div class="faq-content px-6 text-gray-600 leading-relaxed text-left rtl:text-right" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out;">
                        <div class="pb-5 pt-2 border-t border-gray-100">
                            <p>{{ __('frontend.faq_datacenter_location_answer') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ 25: Best Plan for Business -->
            <div class="group" data-aos="fade-up" data-aos-delay="50">
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:border-gray-900 hover:shadow-lg transition-all duration-300">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-5 text-left rtl:text-right flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="text-lg font-semibold text-gray-900 ltr:pr-6 rtl:pl-6 group-hover:text-gray-900">
                            {{ __('frontend.faq_best_plan') }}
                        </span>
                        <div class="flex-shrink-0 w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center group-hover:bg-gray-800 transition-colors">
                            <svg class="w-5 h-5 text-white transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    <div class="faq-content px-6 text-gray-600 leading-relaxed text-left rtl:text-right" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out;">
                        <div class="pb-5 pt-2 border-t border-gray-100">
                            <p>{{ __('frontend.faq_best_plan_answer') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact CTA - Clean Minimal Design -->
        <div class="mt-16" data-aos="fade-up" data-aos-delay="450">
            <div class="bg-gray-900 rounded-2xl p-10 text-center relative overflow-hidden">
                <!-- Subtle Pattern -->
                <div class="absolute inset-0 opacity-5">
                    <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 32px 32px;"></div>
                </div>

                <div class="relative z-10">
                    <h3 class="text-3xl font-bold text-white mb-3">
                        {{ __('frontend.still_have_questions') }}
                    </h3>
                    <p class="text-gray-400 mb-8 text-lg">
                        {{ __('frontend.contact_support_team') }}
                    </p>

                    <button onclick="if(typeof Intercom !== 'undefined') { Intercom('show'); } else { alert('{{ app()->getLocale() == 'ar' ? 'جاري تحميل نظام الدعم...' : 'Loading support system...' }}'); }" class="inline-flex items-center justify-center gap-3 px-8 py-4 bg-white hover:bg-gray-100 text-gray-900 font-semibold rounded-xl transition-all duration-300 cursor-pointer group">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                        <span>{{ __('frontend.contact_us') }}</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 rtl:group-hover:-translate-x-1 transition-transform rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </button>
                </div>
            </div>
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

// Animation for blob effect
document.addEventListener('DOMContentLoaded', function() {
    const style = document.createElement('style');
    style.textContent = `
        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
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
    `;
    document.head.appendChild(style);
});
</script>

@endsection


