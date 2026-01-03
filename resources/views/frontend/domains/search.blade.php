@extends('frontend.layout')

@section('title', __('frontend.domain_name_search') . ' - ' . config('app.name'))
@section('description', __('frontend.domain_search_subtitle'))

@section('content')
<!-- Hero Section - Professional & Modern -->
<section class="relative pt-24 pb-32 overflow-hidden min-h-[75vh] flex items-center bg-gradient-to-br from-slate-50 via-blue-50/30 to-cyan-50/20 dark:from-slate-950 dark:via-blue-950/30 dark:to-cyan-950/20">
    
    <!-- Advanced Background Effects -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <!-- Gradient Mesh -->
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(59,130,246,0.08),transparent_50%),radial-gradient(circle_at_70%_60%,rgba(6,182,212,0.08),transparent_50%)]"></div>
        
        <!-- Animated Orbs -->
        <div class="absolute -top-40 {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} w-[600px] h-[600px] bg-gradient-to-br from-blue-400/15 to-cyan-400/10 dark:from-blue-500/10 dark:to-cyan-500/5 rounded-full blur-3xl animate-float"></div>
        <div class="absolute -bottom-40 {{ app()->getLocale() == 'ar' ? 'right-0' : 'left-0' }} w-[700px] h-[700px] bg-gradient-to-tr from-cyan-400/12 to-blue-400/8 dark:from-cyan-500/8 dark:to-blue-500/4 rounded-full blur-3xl animate-float animation-delay-2000"></div>
        
        <!-- Grid Pattern -->
        <div class="absolute inset-0 bg-[linear-gradient(rgba(59,130,246,0.03)_1px,transparent_1px),linear-gradient(90deg,rgba(59,130,246,0.03)_1px,transparent_1px)] bg-[size:64px_64px] [mask-image:radial-gradient(ellipse_80%_50%_at_50%_50%,black,transparent)]"></div>
        
        <!-- Floating Elements -->
        <div class="absolute top-1/4 {{ app()->getLocale() == 'ar' ? 'right-[10%]' : 'left-[10%]' }} w-2 h-2 bg-blue-500/40 rounded-full animate-ping"></div>
        <div class="absolute top-1/3 {{ app()->getLocale() == 'ar' ? 'left-[15%]' : 'right-[15%]' }} w-3 h-3 bg-cyan-500/40 rounded-full animate-ping animation-delay-1000"></div>
        <div class="absolute bottom-1/4 {{ app()->getLocale() == 'ar' ? 'left-[20%]' : 'right-[20%]' }} w-2 h-2 bg-blue-400/40 rounded-full animate-ping animation-delay-2000"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-2 mb-8 bg-blue-100/80 dark:bg-blue-900/30 backdrop-blur-sm border border-blue-200/50 dark:border-blue-800/50 rounded-full">
                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span class="text-sm font-semibold text-blue-900 dark:text-blue-100">
                        {{ __('frontend.domain_search_trusted') ?? 'البحث الأكثر موثوقية عن النطاقات' }}
                    </span>
                </div>
                
                <!-- Main Heading with Gradient -->
                <h1 class="text-5xl md:text-7xl lg:text-8xl font-black mb-8 leading-tight pb-2">
                    <span class="block text-slate-900 dark:text-white mb-3">
                        {{ __('frontend.domain_search_title_line1') ?? __('frontend.domain_name_search') }}
                    </span>
                    <span class="block bg-gradient-to-r from-blue-600 via-cyan-600 to-blue-700 dark:from-blue-400 dark:via-cyan-400 dark:to-blue-500 bg-clip-text text-transparent pb-1">
                        {{ __('frontend.domain_search_title_line2') ?? 'النطاق المثالي' }}
                    </span>
                </h1>
                
                <!-- Enhanced Subtitle -->
                <p class="text-xl md:text-2xl text-slate-600 dark:text-slate-400 mb-12 max-w-3xl mx-auto leading-relaxed font-light">
                    {{ __('frontend.domain_search_subtitle') }}
                </p>
            </div>

            <!-- Enhanced Search Box -->
            <div class="max-w-4xl mx-auto mb-12">
                <div class="relative group">
                    <!-- Glow Effect -->
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-cyan-600 rounded-3xl blur-xl opacity-25 group-hover:opacity-40 transition-opacity duration-300"></div>
                    
                    <!-- Search Form -->
                    <div class="relative bg-white/95 dark:bg-slate-900/95 backdrop-blur-sm rounded-3xl shadow-2xl p-6 border border-white/20 dark:border-slate-700/50">
                        <form id="domainSearchForm" class="flex flex-col md:flex-row gap-3">
                            @csrf
                            <div class="flex-1 relative">
                                <div class="absolute {{ app()->getLocale() == 'ar' ? 'right-6' : 'left-6' }} top-1/2 -translate-y-1/2 pointer-events-none">
                                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                    </svg>
                                </div>
                                <input 
                                    type="text" 
                                    name="domain"
                                    id="domainInput" 
                                    placeholder="{{ __('frontend.enter_domain_name') }}" 
                                    maxlength="20"
                                    pattern="[a-zA-Z0-9\u0600-\u06FF\-.]+"
                                    title="{{ __('frontend.domain_validation_message') }}"
                                    class="w-full {{ app()->getLocale() == 'ar' ? 'pr-14 pl-6' : 'pl-14 pr-6' }} py-5 bg-slate-50 dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-700 rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent text-lg font-medium transition-all"
                                    required
                                >
                            </div>
                            <button 
                                type="submit"
                                id="searchButton" 
                                class="group px-10 py-5 glass-button bg-gradient-to-r from-blue-600/90 to-cyan-600/90 hover:from-blue-700 hover:to-cyan-700 text-white font-bold text-lg rounded-2xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition-all duration-300 flex items-center justify-center gap-3 whitespace-nowrap border border-white/30"
                            >
                                <svg id="searchIcon" class="w-6 h-6 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <svg id="loadingIcon" class="w-6 h-6 animate-spin hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                <span id="searchText">{{ __('frontend.search_now') }}</span>
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Quick Stats -->
                <div class="flex flex-wrap items-center justify-center gap-6 mt-8 text-sm">
                    <div class="flex items-center gap-2 text-slate-600 dark:text-slate-400">
                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ __('frontend.instant_search') ?? 'بحث فوري' }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-600 dark:text-slate-400">
                        <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ __('frontend.best_prices') ?? 'أفضل الأسعار' }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-600 dark:text-slate-400">
                        <svg class="w-5 h-5 text-cyan-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ __('frontend.free_privacy') ?? 'حماية مجانية' }}</span>
                    </div>
                </div>
            </div>

            <!-- Popular Extensions Slider -->
            <div class="mt-16 relative">
                <!-- Transparent Slider Container -->
                <div class="relative overflow-hidden">
                    <!-- No gradient effects - Fully transparent -->

                    <!-- Slider Track - Auto Scroll -->
                    <div class="flex gap-4 overflow-x-auto scrollbar-hide pb-4" id="extensionsSlider">
                        @php
                            $extensionColors = [
                                'com' => ['bg' => 'blue', 'label' => __('frontend.most_popular')],
                                'net' => ['bg' => 'purple', 'label' => __('frontend.reliable')],
                                'org' => ['bg' => 'green', 'label' => __('frontend.organizations')],
                                'io' => ['bg' => 'cyan', 'label' => __('frontend.tech_startups')],
                                'co' => ['bg' => 'orange', 'label' => __('frontend.modern_business')],
                                'me' => ['bg' => 'pink', 'label' => __('frontend.personal')],
                                'online' => ['bg' => 'indigo', 'label' => __('frontend.web_presence')],
                                'app' => ['bg' => 'red', 'label' => __('frontend.applications')],
                                'dev' => ['bg' => 'teal', 'label' => __('frontend.developers')],
                                'store' => ['bg' => 'amber', 'label' => __('frontend.ecommerce')],
                                'tech' => ['bg' => 'violet', 'label' => __('frontend.technology')],
                                'shop' => ['bg' => 'rose', 'label' => __('frontend.shopping')],
                            ];
                        @endphp

                        @if(isset($popularExtensions) && $popularExtensions->count() > 0)
                            @foreach($popularExtensions as $extension)
                                @php
                                    $tldName = str_replace('.', '', $extension['tld']);
                                    $color = $extensionColors[$tldName]['bg'] ?? 'gray';
                                    $label = $extensionColors[$tldName]['label'] ?? '';
                                @endphp
                                <!-- Extension Card: {{ $extension['tld'] }} -->
                                <div class="flex-shrink-0 w-48 group">
                                    <div class="relative bg-white/60 dark:bg-slate-800/60 backdrop-blur-lg rounded-2xl p-6 border border-slate-200/50 dark:border-slate-700/50 hover:bg-white dark:hover:bg-slate-800 hover:shadow-xl hover:scale-105 transition-all duration-300">
                                        <div class="text-center">
                                            <div class="text-4xl font-black text-{{ $color }}-600 dark:text-{{ $color }}-400 mb-2">{{ $extension['tld'] }}</div>
                                            @if($label)
                                                <div class="text-sm text-slate-500 dark:text-slate-400 mb-3">{{ $label }}</div>
                                            @endif
                                            <div class="text-2xl font-bold text-slate-900 dark:text-white mb-1">${{ number_format($extension['price'], 2) }}</div>
                                            <div class="text-xs text-slate-500 dark:text-slate-400">{{ __('frontend.per_year') }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
                            <!-- Duplicate cards for infinite scroll effect -->
                            @foreach($popularExtensions as $extension)
                                @php
                                    $tldName = str_replace('.', '', $extension['tld']);
                                    $color = $extensionColors[$tldName]['bg'] ?? 'gray';
                                    $label = $extensionColors[$tldName]['label'] ?? '';
                                @endphp
                                <div class="flex-shrink-0 w-48 group">
                                    <div class="relative bg-white/60 dark:bg-slate-800/60 backdrop-blur-lg rounded-2xl p-6 border border-slate-200/50 dark:border-slate-700/50 hover:bg-white dark:hover:bg-slate-800 hover:shadow-xl hover:scale-105 transition-all duration-300">
                                        <div class="text-center">
                                            <div class="text-4xl font-black text-{{ $color }}-600 dark:text-{{ $color }}-400 mb-2">{{ $extension['tld'] }}</div>
                                            @if($label)
                                                <div class="text-sm text-slate-500 dark:text-slate-400 mb-3">{{ $label }}</div>
                                            @endif
                                            <div class="text-2xl font-bold text-slate-900 dark:text-white mb-1">${{ number_format($extension['price'], 2) }}</div>
                                            <div class="text-xs text-slate-500 dark:text-slate-400">{{ __('frontend.per_year') }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <!-- Fallback if no data from database -->
                            <div class="text-center py-8 text-slate-500 dark:text-slate-400">
                                {{ __('frontend.no_extensions_available') ?? 'لا توجد امتدادات متاحة حالياً' }}
                            </div>
                        @endif

                    </div>
                </div>

                <!-- Auto-scroll Script -->
                <script>
                    (function() {
                        const slider = document.getElementById('extensionsSlider');
                        if (!slider) return;
                        
                        let scrollSpeed = 1; // pixels per frame
                        let isPaused = false;
                        
                        // Auto scroll function
                        function autoScroll() {
                            if (!isPaused) {
                                slider.scrollLeft += scrollSpeed;
                                
                                // Reset to beginning for infinite loop
                                if (slider.scrollLeft >= slider.scrollWidth / 2) {
                                    slider.scrollLeft = 0;
                                }
                            }
                            requestAnimationFrame(autoScroll);
                        }
                        
                        // Pause on hover
                        slider.addEventListener('mouseenter', () => {
                            isPaused = true;
                        });
                        
                        slider.addEventListener('mouseleave', () => {
                            isPaused = false;
                        });
                        
                        // Start auto-scroll
                        autoScroll();
                    })();
                </script>
            </div>

            <!-- Loading State -->
            <div id="loadingState" class="hidden text-center py-12 mt-8">
                <div class="inline-flex items-center gap-3 text-blue-600 dark:text-blue-400">
                    <svg class="animate-spin h-8 w-8" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-xl font-semibold">{{ __('frontend.searching') }}...</span>
                </div>
            </div>

            <!-- Results Container -->
            <div id="resultsContainer" class="hidden mt-8">
                <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-8 text-center">
                    {{ __('frontend.search_results') }}
                </h2>
                
                <div id="resultsList" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">
                    <!-- Results will be inserted here by JavaScript -->
                </div>

                <!-- View More Button -->
                <div id="viewMoreContainer" class="hidden mt-8 text-center">
                    <button 
                        id="viewMoreBtn"
                        class="group inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-slate-700 to-slate-900 hover:from-slate-800 hover:to-black text-white font-bold text-lg rounded-2xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition-all duration-300 border border-white/20"
                    >
                        <span id="viewMoreText">{{ __('frontend.view_more_extensions') }}</span>
                        <span id="viewMoreCount" class="px-3 py-1 bg-white/20 rounded-full text-sm font-bold">+25</span>
                        <svg id="viewMoreIcon" class="w-5 h-5 group-hover:translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                        </svg>
                        <svg id="viewLessIcon" class="w-5 h-5 group-hover:-translate-y-1 transition-transform hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Trust the Experience Section -->
<section class="py-20 bg-white dark:bg-slate-900 relative overflow-hidden">
    <!-- Decorative Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-purple-100 dark:bg-purple-900/10 rounded-full blur-3xl opacity-30"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-blue-100 dark:bg-blue-900/10 rounded-full blur-3xl opacity-30"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-6xl mx-auto">
            <!-- Two Column Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                
                <!-- Left Column: Title + Trustpilot + Features -->
                <div class="space-y-8">
                    <!-- Title -->
                    <div>
                        <h2 class="text-4xl lg:text-5xl xl:text-6xl font-extrabold leading-tight">
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 via-blue-600 to-cyan-600 dark:from-purple-400 dark:via-blue-400 dark:to-cyan-400">
                                {{ __('frontend.trust_experience') }}
                            </span>
                            <br>
                            <span class="text-slate-900 dark:text-white">
                                {{ __('frontend.that_matters') }}
                            </span>
                        </h2>
                    </div>
                    
                    <!-- Trustpilot Rating Card -->
                    <div class="inline-flex items-center gap-3 bg-white dark:bg-slate-800 px-6 py-4 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700">
                        <span class="text-base font-bold text-slate-800 dark:text-slate-200">Excellent</span>
                        <div class="flex items-center gap-2">
                            <div class="flex gap-0.5">
                                @for ($i = 0; $i < 5; $i++)
                                    <svg class="w-5 h-5 {{ $i < 4 ? 'text-green-500' : 'text-gray-300 dark:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">4.5</span>
                        </div>
                        <div class="h-6 w-px bg-slate-300 dark:bg-slate-600"></div>
                        <img src="https://cdn.trustpilot.net/brand-assets/4.1.0/logo-black.svg" alt="Trustpilot" class="h-6 dark:invert opacity-80">
                    </div>

                    <!-- Features List -->
                    <div class="space-y-5">
                        <!-- Feature 1 -->
                        <div class="flex items-center gap-4 group">
                            <div class="w-12 h-12 flex-shrink-0 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-lg font-semibold text-slate-800 dark:text-slate-200">{{ __('frontend.icann_accredited') }}</p>
                                <p class="text-sm text-slate-500 dark:text-slate-400">{{ __('frontend.icann_accredited_desc') }}</p>
                            </div>
                        </div>

                        <!-- Feature 2 -->
                        <div class="flex items-center gap-4 group">
                            <div class="w-12 h-12 flex-shrink-0 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-lg font-semibold text-slate-800 dark:text-slate-200">{{ __('frontend.manage_confidence') }}</p>
                                <p class="text-sm text-slate-500 dark:text-slate-400">{{ __('frontend.manage_confidence_desc') }}</p>
                            </div>
                        </div>

                        <!-- Feature 3 -->
                        <div class="flex items-center gap-4 group">
                            <div class="w-12 h-12 flex-shrink-0 bg-gradient-to-br from-indigo-500 to-blue-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-lg font-semibold text-slate-800 dark:text-slate-200">{{ __('frontend.industry_tools') }}</p>
                                <p class="text-sm text-slate-500 dark:text-slate-400">{{ __('frontend.industry_tools_desc') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Stats Grid -->
                <div class="grid grid-cols-2 gap-6 lg:gap-8">
                    <!-- Stat 1 -->
                    <div class="bg-gradient-to-br from-purple-50 to-blue-50 dark:from-purple-900/20 dark:to-blue-900/20 p-8 rounded-3xl border border-purple-100 dark:border-purple-800/30 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-600 dark:from-purple-400 dark:to-blue-400 mb-3">50K+</div>
                        <div class="text-xl font-bold text-slate-900 dark:text-white mb-1">{{ __('frontend.domains_registered') }}</div>
                        <div class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">{{ __('frontend.worldwide') }}</div>
                    </div>

                    <!-- Stat 2 -->
                    <div class="bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 p-8 rounded-3xl border border-blue-100 dark:border-blue-800/30 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-600 dark:from-blue-400 dark:to-cyan-400 mb-3">5,000+</div>
                        <div class="text-xl font-bold text-slate-900 dark:text-white mb-1">{{ __('frontend.customers') }}</div>
                        <div class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">{{ __('frontend.worldwide') }}</div>
                    </div>

                    <!-- Stat 3 -->
                    <div class="bg-gradient-to-br from-cyan-50 to-teal-50 dark:from-cyan-900/20 dark:to-teal-900/20 p-8 rounded-3xl border border-cyan-100 dark:border-cyan-800/30 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-cyan-600 to-teal-600 dark:from-cyan-400 dark:to-teal-400 mb-3">2023</div>
                        <div class="text-xl font-bold text-slate-900 dark:text-white mb-1">{{ __('frontend.since') }}</div>
                        <div class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">{{ __('frontend.trusted_professionals') }}</div>
                    </div>

                    <!-- Stat 4 -->
                    <div class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 p-8 rounded-3xl border border-indigo-100 dark:border-indigo-800/30 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-purple-400 mb-3">{{ __('frontend.best_registrar') }}</div>
                        <div class="text-xl font-bold text-slate-900 dark:text-white mb-1">2023</div>
                        <div class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">{{ __('frontend.voted_namepros') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Find and Register Domain Section -->
<section class="relative py-24 overflow-hidden">
    <!-- Premium Gradient Background -->
    <div class="absolute inset-0 bg-gradient-to-br from-slate-50 via-blue-50/50 to-purple-50/50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900"></div>
    
    <!-- Animated Background Patterns -->
    <div class="absolute inset-0 opacity-30">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-400/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-400/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-cyan-400/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
    </div>
    
    <!-- Decorative Grid Pattern -->
    <div class="absolute inset-0 opacity-[0.03] dark:opacity-[0.05]">
        <div class="absolute inset-0" style="background-image: linear-gradient(to right, currentColor 1px, transparent 1px), linear-gradient(to bottom, currentColor 1px, transparent 1px); background-size: 40px 40px;"></div>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-7xl mx-auto">
            <!-- Enhanced Header -->
            <div class="text-center mb-20">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900/30 dark:to-purple-900/30 rounded-full mb-6 backdrop-blur-sm border border-blue-200/50 dark:border-blue-800/50">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span class="text-sm font-semibold text-blue-700 dark:text-blue-300">{{ __('frontend.premium_domain_services') }}</span>
                </div>
                
                <h2 class="text-5xl lg:text-6xl font-black text-slate-900 dark:text-white mb-6 leading-tight">
                    <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 dark:from-blue-400 dark:via-purple-400 dark:to-pink-400 text-transparent bg-clip-text">
                        {{ __('frontend.find_register_domain') }}
                    </span>
                </h2>
                <p class="text-xl text-slate-600 dark:text-slate-400 max-w-3xl mx-auto leading-relaxed">
                    {{ __('frontend.find_register_domain_desc') }}
                </p>
            </div>

            <!-- Enhanced Three Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-10">
                
                <!-- Card 1: Save on domain registrations -->
                <div class="group relative">
                    <!-- Animated Border Gradient -->
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-500 via-purple-500 to-blue-500 rounded-3xl opacity-30 group-hover:opacity-100 blur-sm group-hover:blur transition-all duration-500 animate-gradient-x"></div>
                    
                    <div class="relative bg-white dark:bg-slate-900 rounded-3xl p-8 lg:p-10 h-full shadow-xl hover:shadow-2xl transition-all duration-500 group-hover:-translate-y-2">
                        <!-- Decorative Elements -->
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-500/10 to-purple-500/10 rounded-full blur-3xl -z-0"></div>
                        
                        <div class="relative z-10">
                            <!-- Premium Icon Container -->
                            <div class="mb-8 relative inline-block">
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-purple-500 rounded-2xl blur-xl opacity-50 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <div class="relative w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-2xl group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <h3 class="text-2xl lg:text-3xl font-bold text-slate-900 dark:text-white mb-4 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300">
                                {{ __('frontend.save_registrations') }}
                            </h3>
                            <p class="text-base lg:text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
                                {{ __('frontend.save_registrations_desc') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Manage with ease -->
                <div class="group relative">
                    <!-- Animated Border Gradient -->
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-500 via-pink-500 to-purple-500 rounded-3xl opacity-30 group-hover:opacity-100 blur-sm group-hover:blur transition-all duration-500 animate-gradient-x" style="animation-delay: 0.2s;"></div>
                    
                    <div class="relative bg-white dark:bg-slate-900 rounded-3xl p-8 lg:p-10 h-full shadow-xl hover:shadow-2xl transition-all duration-500 group-hover:-translate-y-2">
                        <!-- Decorative Elements -->
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-purple-500/10 to-pink-500/10 rounded-full blur-3xl -z-0"></div>
                        
                        <div class="relative z-10">
                            <!-- Premium Icon Container -->
                            <div class="mb-8 relative inline-block">
                                <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl blur-xl opacity-50 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <div class="relative w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-2xl group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <h3 class="text-2xl lg:text-3xl font-bold text-slate-900 dark:text-white mb-4 group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors duration-300">
                                {{ __('frontend.manage_ease') }}
                            </h3>
                            <p class="text-base lg:text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
                                {{ __('frontend.manage_ease_desc') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Card 3: 24/7 Support -->
                <div class="group relative">
                    <!-- Animated Border Gradient -->
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-cyan-500 via-blue-500 to-cyan-500 rounded-3xl opacity-30 group-hover:opacity-100 blur-sm group-hover:blur transition-all duration-500 animate-gradient-x" style="animation-delay: 0.4s;"></div>
                    
                    <div class="relative bg-white dark:bg-slate-900 rounded-3xl p-8 lg:p-10 h-full shadow-xl hover:shadow-2xl transition-all duration-500 group-hover:-translate-y-2">
                        <!-- Decorative Elements -->
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-cyan-500/10 to-blue-500/10 rounded-full blur-3xl -z-0"></div>
                        
                        <div class="relative z-10">
                            <!-- Premium Icon Container -->
                            <div class="mb-8 relative inline-block">
                                <div class="absolute inset-0 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-2xl blur-xl opacity-50 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <div class="relative w-20 h-20 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-2xl group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <h3 class="text-2xl lg:text-3xl font-bold text-slate-900 dark:text-white mb-4 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors duration-300">
                                {{ __('frontend.support_247') }}
                            </h3>
                            <p class="text-base lg:text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
                                {{ __('frontend.support_247_desc') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
@keyframes gradient-x {
    0%, 100% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
}

.animate-gradient-x {
    background-size: 200% 200%;
    animation: gradient-x 3s ease infinite;
}

/* Hide scrollbar for Chrome, Safari and Opera */
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}

/* Hide scrollbar for IE, Edge and Firefox */
.scrollbar-hide {
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;  /* Firefox */
}
</style>

<!-- Domain Pricing Section - Professional Table -->
<section class="py-20 bg-gradient-to-br from-slate-50 via-blue-50/30 to-cyan-50/20 dark:from-slate-900 dark:via-blue-950/30 dark:to-cyan-950/20">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            
            <!-- Section Header -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center gap-2 px-4 py-2 mb-4 bg-blue-100/80 dark:bg-blue-900/30 backdrop-blur-sm border border-blue-200/50 dark:border-blue-800/50 rounded-full">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-semibold text-blue-900 dark:text-blue-100">
                        {{ __('frontend.transparent_pricing') ?? 'أسعار شفافة' }}
                    </span>
                </div>
                
                <h2 class="text-4xl lg:text-5xl font-black text-slate-900 dark:text-white mb-4">
                    {{ __('frontend.domain_pricing') }}
                </h2>
                <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
                    {{ __('frontend.domain_pricing_desc') }}
                </p>
            </div>

            <!-- Pricing Table Container -->
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-2xl overflow-hidden border border-slate-200 dark:border-slate-700">
                
                <!-- Search Box -->
                <div class="px-4 sm:px-8 py-4 sm:py-6 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/50">
                    <div class="relative max-w-md mx-auto">
                        <div class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'right-0 pr-3' : 'left-0 pl-3' }} flex items-center pointer-events-none">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            id="pricingSearchInput"
                            placeholder="{{ __('frontend.search_extension') ?? 'ابحث عن امتداد...' }}"
                            class="w-full {{ app()->getLocale() === 'ar' ? 'pr-10 text-right' : 'pl-10 text-left' }} py-2 sm:py-3 text-sm sm:text-base bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent text-slate-900 dark:text-white placeholder-slate-400 transition-all"
                        />
                        <div id="searchResultCount" class="absolute {{ app()->getLocale() === 'ar' ? 'left-3' : 'right-3' }} top-1/2 -translate-y-1/2 text-xs sm:text-sm text-slate-500 dark:text-slate-400 hidden">
                            <span id="resultCount">0</span> {{ __('frontend.results') ?? 'نتيجة' }}
                        </div>
                    </div>
                </div>
                
                <!-- Table Scroll Container -->
                <div class="overflow-x-auto">
                    <!-- Table Header -->
                    <div class="bg-gradient-to-r from-blue-600 to-cyan-600 dark:from-blue-700 dark:to-cyan-700 px-4 sm:px-8 py-4 sm:py-6 min-w-[640px]">
                        <div class="grid grid-cols-5 gap-2 sm:gap-4 text-white font-bold text-xs sm:text-sm lg:text-base">
                            <div class="{{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                                {{ __('frontend.extension') }}
                            </div>
                            <div class="text-center">{{ __('frontend.registration') }}</div>
                            <div class="text-center">{{ __('frontend.renewal') }}</div>
                            <div class="text-center">{{ __('frontend.transfer') }}</div>
                            <div class="text-center">{{ __('frontend.restore') }}</div>
                        </div>
                    </div>

                    <!-- Table Body - Scrollable -->
                    <div class="max-h-[600px] overflow-y-auto min-w-[640px]" id="pricingTableBody">
                        <!-- No Results Message -->
                        <div id="noResultsMessage" class="hidden px-4 sm:px-8 py-12 text-center">
                            <svg class="w-12 h-12 sm:w-16 sm:h-16 mx-auto text-slate-300 dark:text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-slate-600 dark:text-slate-400 text-base sm:text-lg font-medium">{{ __('frontend.no_results_found') ?? 'لا توجد نتائج' }}</p>
                            <p class="text-slate-500 dark:text-slate-500 text-xs sm:text-sm mt-2">{{ __('frontend.try_different_search') ?? 'جرب كلمة بحث مختلفة' }}</p>
                        </div>
                    
                    @if(isset($allDomainPricing) && $allDomainPricing->count() > 0)
                        @foreach($allDomainPricing as $index => $pricing)
                            <div class="pricing-row grid grid-cols-5 gap-2 sm:gap-4 px-4 sm:px-8 py-4 sm:py-5 border-b border-slate-200 dark:border-slate-700 hover:bg-blue-50 dark:hover:bg-slate-700/50 transition-colors duration-200 {{ $index % 2 === 0 ? 'bg-slate-50 dark:bg-slate-800/50' : 'bg-white dark:bg-slate-800' }}" data-tld="{{ strtolower($pricing['tld']) }}">
                                
                                <!-- Extension Name -->
                                <div class="{{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} flex items-center gap-1 sm:gap-2 {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }}">
                                    <span class="text-base sm:text-xl font-black text-blue-600 dark:text-blue-400">
                                        @if(app()->getLocale() === 'ar')
                                            {{ $pricing['tld'] }}.
                                        @else
                                            .{{ $pricing['tld'] }}
                                        @endif
                                    </span>
                                    @if(in_array($pricing['tld'], ['com', 'net', 'org']))
                                        <span class="px-1.5 sm:px-2 py-0.5 sm:py-1 text-[10px] sm:text-xs font-bold bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-full">
                                            {{ __('frontend.popular') }}
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Registration Price -->
                                <div class="text-center flex flex-col items-center justify-center">
                                    <span class="text-sm sm:text-lg font-bold text-slate-900 dark:text-white">
                                        ${{ number_format($pricing['register'], 2) }}
                                    </span>
                                    <span class="text-[10px] sm:text-xs text-slate-500 dark:text-slate-400">
                                        {{ __('frontend.per_year_short') }}
                                    </span>
                                </div>
                                
                                <!-- Renewal Price -->
                                <div class="text-center flex flex-col items-center justify-center">
                                    <span class="text-sm sm:text-lg font-bold text-slate-900 dark:text-white">
                                        ${{ number_format($pricing['renew'], 2) }}
                                    </span>
                                    <span class="text-[10px] sm:text-xs text-slate-500 dark:text-slate-400">
                                        {{ __('frontend.per_year_short') }}
                                    </span>
                                </div>
                                
                                <!-- Transfer Price -->
                                <div class="text-center flex flex-col items-center justify-center">
                                    <span class="text-sm sm:text-lg font-bold text-slate-900 dark:text-white">
                                        ${{ number_format($pricing['transfer'], 2) }}
                                    </span>
                                    <span class="text-[10px] sm:text-xs text-slate-500 dark:text-slate-400">
                                        {{ __('frontend.per_year_short') }}
                                    </span>
                                </div>
                                
                                <!-- Restore Price -->
                                <div class="text-center flex flex-col items-center justify-center">
                                    <span class="text-sm sm:text-lg font-bold text-slate-900 dark:text-white">
                                        ${{ number_format($pricing['restore'], 2) }}
                                    </span>
                                    <span class="text-[10px] sm:text-xs text-slate-500 dark:text-slate-400">
                                        {{ __('frontend.per_year_short') }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="px-4 sm:px-8 py-12 text-center">
                            <p class="text-slate-500 dark:text-slate-400">
                                {{ __('frontend.no_extensions_available') }}
                            </p>
                        </div>
                    @endif
                    </div>
                </div>

                <!-- Table Footer -->
                <div class="bg-slate-100 dark:bg-slate-900 px-4 sm:px-8 py-4 sm:py-6 text-center">
                    <p class="text-sm text-slate-600 dark:text-slate-400">
                        💡 {{ __('frontend.pricing_note') ?? 'جميع الأسعار بالدولار الأمريكي (USD) وتشمل سنة واحدة من الخدمة' }}
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Search Functionality Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('pricingSearchInput');
        const tableBody = document.getElementById('pricingTableBody');
        const noResultsMessage = document.getElementById('noResultsMessage');
        const resultCount = document.getElementById('resultCount');
        const searchResultCount = document.getElementById('searchResultCount');
        const pricingRows = document.querySelectorAll('.pricing-row');
        
        let searchTimeout;
        
        searchInput.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            
            searchTimeout = setTimeout(() => {
                const searchQuery = e.target.value.toLowerCase().trim();
                let visibleCount = 0;
                
                pricingRows.forEach(row => {
                    const tld = row.getAttribute('data-tld');
                    
                    if (searchQuery === '' || tld.includes(searchQuery)) {
                        row.style.display = 'grid';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });
                
                // Show/hide no results message
                if (visibleCount === 0 && searchQuery !== '') {
                    noResultsMessage.classList.remove('hidden');
                } else {
                    noResultsMessage.classList.add('hidden');
                }
                
                // Update result count
                if (searchQuery !== '') {
                    resultCount.textContent = visibleCount;
                    searchResultCount.classList.remove('hidden');
                } else {
                    searchResultCount.classList.add('hidden');
                }
            }, 300);
        });
        
        // Clear search on ESC key
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                searchInput.value = '';
                searchInput.dispatchEvent(new Event('input'));
                searchInput.blur();
            }
        });
    });
</script>

<!-- Why Choose ProGineous - Premium Section -->
<section class="relative py-32 overflow-hidden bg-gradient-to-br from-slate-900 via-blue-900 to-purple-900 dark:from-slate-950 dark:via-slate-900 dark:to-slate-950">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <!-- Gradient Orbs -->
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-500/30 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-purple-500/30 rounded-full blur-3xl animate-pulse" style="animation-delay: 1.5s;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-cyan-500/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 3s;"></div>
        
        <!-- Floating Particles -->
        <div class="absolute inset-0 opacity-30">
            <div class="absolute top-20 left-[10%] w-2 h-2 bg-blue-400 rounded-full animate-float"></div>
            <div class="absolute top-40 right-[20%] w-3 h-3 bg-purple-400 rounded-full animate-float" style="animation-delay: 0.5s;"></div>
            <div class="absolute bottom-32 left-[30%] w-2 h-2 bg-cyan-400 rounded-full animate-float" style="animation-delay: 1s;"></div>
            <div class="absolute bottom-20 right-[15%] w-3 h-3 bg-pink-400 rounded-full animate-float" style="animation-delay: 1.5s;"></div>
            <div class="absolute top-1/3 right-[40%] w-2 h-2 bg-indigo-400 rounded-full animate-float" style="animation-delay: 2s;"></div>
        </div>
        
        <!-- Grid Pattern -->
        <div class="absolute inset-0 opacity-[0.03]">
            <div class="h-full w-full" style="background-image: linear-gradient(to right, white 1px, transparent 1px), linear-gradient(to bottom, white 1px, transparent 1px); background-size: 50px 50px;"></div>
        </div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-7xl mx-auto">
            
            <!-- Section Header -->
            <div class="text-center mb-20">
                <!-- Premium Badge -->
                <div class="inline-flex items-center gap-2 px-5 py-2 bg-white/10 backdrop-blur-md rounded-full mb-8 border border-white/20">
                    <svg class="w-5 h-5 text-cyan-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span class="text-sm font-bold text-white">{{ __('frontend.why_choose_badge') }}</span>
                </div>
                
                <h2 class="text-5xl lg:text-6xl xl:text-7xl font-black text-white mb-6 leading-tight">
                    {{ __('frontend.why_choose_us_domains') }}
                </h2>
                <p class="text-xl lg:text-2xl text-blue-100 max-w-4xl mx-auto leading-relaxed">
                    {{ __('frontend.why_choose_us_domains_desc') }}
                </p>
            </div>

            <!-- Features Grid with Enhanced Design -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-10">
                
                <!-- Feature 1: Competitive Prices -->
                <div class="group relative">
                    <!-- Animated Glow Border -->
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 via-cyan-600 to-blue-600 rounded-3xl opacity-50 group-hover:opacity-100 blur-lg transition-all duration-700 animate-gradient-xy"></div>
                    
                    <div class="relative bg-white/10 backdrop-blur-xl rounded-3xl p-10 border border-white/20 hover:bg-white/15 transition-all duration-500 hover:scale-[1.02] h-full flex flex-col">
                        <!-- Icon Container with Floating Effect -->
                        <div class="mb-8 relative inline-block">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-2xl blur-2xl opacity-60 animate-pulse"></div>
                            <div class="relative w-24 h-24 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center shadow-2xl group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Number Badge -->
                        <div class="absolute top-6 right-6 w-12 h-12 bg-blue-500/20 backdrop-blur-sm rounded-xl flex items-center justify-center border border-blue-400/30">
                            <span class="text-2xl font-black text-blue-300">01</span>
                        </div>
                        
                        <!-- Content Area -->
                        <div class="flex-1 flex flex-col">
                            <h3 class="text-2xl lg:text-3xl font-bold text-white mb-4 group-hover:text-cyan-300 transition-colors duration-300 min-h-[80px] flex items-center">
                                {{ __('frontend.competitive_prices') }}
                            </h3>
                            <p class="text-lg text-blue-100 leading-relaxed mb-6 min-h-[120px]">
                                {{ __('frontend.competitive_prices_desc') }}
                            </p>
                        </div>
                        
                        <!-- Stats Bar -->
                        <div class="flex items-center gap-3 p-4 bg-white/10 rounded-xl border border-white/10 min-h-[88px] mt-auto">
                            <div class="flex-shrink-0 w-10 h-10 bg-green-500/20 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="text-sm text-blue-200 leading-tight mb-1">{{ __('frontend.save_up_to') }}</div>
                                <div class="text-xl font-black text-white leading-tight">40%</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Feature 2: Privacy Protection -->
                <div class="group relative">
                    <!-- Animated Glow Border -->
                    <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 via-pink-600 to-purple-600 rounded-3xl opacity-50 group-hover:opacity-100 blur-lg transition-all duration-700 animate-gradient-xy" style="animation-delay: 0.3s;"></div>
                    
                    <div class="relative bg-white/10 backdrop-blur-xl rounded-3xl p-10 border border-white/20 hover:bg-white/15 transition-all duration-500 hover:scale-[1.02] h-full flex flex-col">
                        <!-- Icon Container with Floating Effect -->
                        <div class="mb-8 relative inline-block">
                            <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl blur-2xl opacity-60 animate-pulse"></div>
                            <div class="relative w-24 h-24 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-2xl group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Number Badge -->
                        <div class="absolute top-6 right-6 w-12 h-12 bg-purple-500/20 backdrop-blur-sm rounded-xl flex items-center justify-center border border-purple-400/30">
                            <span class="text-2xl font-black text-purple-300">02</span>
                        </div>
                        
                        <!-- Content Area -->
                        <div class="flex-1 flex flex-col">
                            <h3 class="text-2xl lg:text-3xl font-bold text-white mb-4 group-hover:text-pink-300 transition-colors duration-300 min-h-[80px] flex items-center">
                                {{ __('frontend.free_privacy_protection') }}
                            </h3>
                            <p class="text-lg text-blue-100 leading-relaxed mb-6 min-h-[120px]">
                                {{ __('frontend.free_privacy_protection_desc') }}
                            </p>
                        </div>
                        
                        <!-- Stats Bar -->
                        <div class="flex items-center gap-3 p-4 bg-white/10 rounded-xl border border-white/10 min-h-[88px] mt-auto">
                            <div class="flex-shrink-0 w-10 h-10 bg-purple-500/20 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="text-sm text-blue-200 leading-tight mb-1">{{ __('frontend.protection_value') }}</div>
                                <div class="text-xl font-black text-white leading-tight">{{ __('frontend.free') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Feature 3: Instant Activation -->
                <div class="group relative">
                    <!-- Animated Glow Border -->
                    <div class="absolute -inset-1 bg-gradient-to-r from-cyan-600 via-teal-600 to-cyan-600 rounded-3xl opacity-50 group-hover:opacity-100 blur-lg transition-all duration-700 animate-gradient-xy" style="animation-delay: 0.6s;"></div>
                    
                    <div class="relative bg-white/10 backdrop-blur-xl rounded-3xl p-10 border border-white/20 hover:bg-white/15 transition-all duration-500 hover:scale-[1.02] h-full flex flex-col">
                        <!-- Icon Container with Floating Effect -->
                        <div class="mb-8 relative inline-block">
                            <div class="absolute inset-0 bg-gradient-to-r from-cyan-500 to-teal-500 rounded-2xl blur-2xl opacity-60 animate-pulse"></div>
                            <div class="relative w-24 h-24 bg-gradient-to-br from-cyan-500 to-teal-500 rounded-2xl flex items-center justify-center shadow-2xl group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Number Badge -->
                        <div class="absolute top-6 right-6 w-12 h-12 bg-cyan-500/20 backdrop-blur-sm rounded-xl flex items-center justify-center border border-cyan-400/30">
                            <span class="text-2xl font-black text-cyan-300">03</span>
                        </div>
                        
                        <!-- Content Area -->
                        <div class="flex-1 flex flex-col">
                            <h3 class="text-2xl lg:text-3xl font-bold text-white mb-4 group-hover:text-teal-300 transition-colors duration-300 min-h-[80px] flex items-center">
                                {{ __('frontend.instant_activation') }}
                            </h3>
                            <p class="text-lg text-blue-100 leading-relaxed mb-6 min-h-[120px]">
                                {{ __('frontend.instant_activation_desc') }}
                            </p>
                        </div>
                        
                        <!-- Stats Bar -->
                        <div class="flex items-center gap-3 p-4 bg-white/10 rounded-xl border border-white/10 min-h-[88px] mt-auto">
                            <div class="flex-shrink-0 w-10 h-10 bg-cyan-500/20 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="text-sm text-blue-200 leading-tight mb-1">{{ __('frontend.activation_time') }}</div>
                                <div class="text-xl font-black text-white leading-tight">{{ __('frontend.instant') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="mt-20 text-center">
                <div class="inline-flex flex-col sm:flex-row items-center gap-4 p-8 bg-white/10 backdrop-blur-xl rounded-3xl border border-white/20">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-500 rounded-2xl flex items-center justify-center shadow-xl">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div class="{{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                            <div class="text-2xl font-black text-white">{{ __('frontend.join_customers') }}</div>
                            <div class="text-blue-200">{{ __('frontend.join_customers_desc') }}</div>
                        </div>
                    </div>
                    <button onclick="document.getElementById('domainInput').focus()" class="px-8 py-4 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-500 hover:to-cyan-500 text-white font-bold rounded-xl shadow-2xl hover:shadow-cyan-500/50 transition-all duration-300 hover:scale-105">
                        {{ __('frontend.get_started_now') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How Does Our Domain Search Work Section -->
<section class="py-20 bg-gradient-to-br from-slate-50 via-blue-50 to-cyan-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <div class="inline-block mb-4">
                <span class="px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-600 text-white text-sm font-bold rounded-full shadow-lg">
                    {{ __('frontend.how_it_works') }}
                </span>
            </div>
            <h2 class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-4">
                {{ __('frontend.how_domain_search_works') }}
            </h2>
            <p class="text-lg text-slate-600 dark:text-slate-300 max-w-3xl mx-auto">
                {{ __('frontend.how_domain_search_desc') }}
            </p>
        </div>

        <!-- Steps Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            
            <!-- Step 1 -->
            <div class="group relative">
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-slate-200 dark:border-slate-700 h-full">
                    <!-- Step Number -->
                    <div class="absolute -top-4 {{ app()->getLocale() === 'ar' ? 'right-8' : 'left-8' }} w-12 h-12 bg-gradient-to-br from-blue-600 to-cyan-600 rounded-xl flex items-center justify-center shadow-lg">
                        <span class="text-2xl font-black text-white">1</span>
                    </div>
                    
                    <!-- Icon -->
                    <div class="mt-6 mb-6 w-16 h-16 bg-gradient-to-br from-blue-100 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/30 rounded-xl flex items-center justify-center {{ app()->getLocale() === 'ar' ? 'mr-auto' : 'ml-auto' }} group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    
                    <!-- Content -->
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                        {{ __('frontend.step_1_title') }}
                    </h3>
                    <p class="text-slate-600 dark:text-slate-300 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                        {{ __('frontend.step_1_desc') }}
                    </p>
                </div>
                
                <!-- Arrow (hidden on mobile, last item) -->
                <div class="hidden lg:block absolute top-1/2 {{ app()->getLocale() === 'ar' ? 'left-0 -translate-x-1/2 rotate-180' : 'right-0 translate-x-1/2' }} -translate-y-1/2 text-blue-300 dark:text-blue-700">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="group relative">
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-slate-200 dark:border-slate-700 h-full">
                    <div class="absolute -top-4 {{ app()->getLocale() === 'ar' ? 'right-8' : 'left-8' }} w-12 h-12 bg-gradient-to-br from-purple-600 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                        <span class="text-2xl font-black text-white">2</span>
                    </div>
                    
                    <div class="mt-6 mb-6 w-16 h-16 bg-gradient-to-br from-purple-100 to-pink-100 dark:from-purple-900/30 dark:to-pink-900/30 rounded-xl flex items-center justify-center {{ app()->getLocale() === 'ar' ? 'mr-auto' : 'ml-auto' }} group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                        {{ __('frontend.step_2_title') }}
                    </h3>
                    <p class="text-slate-600 dark:text-slate-300 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                        {{ __('frontend.step_2_desc') }}
                    </p>
                </div>
                
                <div class="hidden lg:block absolute top-1/2 {{ app()->getLocale() === 'ar' ? 'left-0 -translate-x-1/2 rotate-180' : 'right-0 translate-x-1/2' }} -translate-y-1/2 text-purple-300 dark:text-purple-700">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="group relative">
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-slate-200 dark:border-slate-700 h-full">
                    <div class="absolute -top-4 {{ app()->getLocale() === 'ar' ? 'right-8' : 'left-8' }} w-12 h-12 bg-gradient-to-br from-green-600 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                        <span class="text-2xl font-black text-white">3</span>
                    </div>
                    
                    <div class="mt-6 mb-6 w-16 h-16 bg-gradient-to-br from-green-100 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/30 rounded-xl flex items-center justify-center {{ app()->getLocale() === 'ar' ? 'mr-auto' : 'ml-auto' }} group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                        {{ __('frontend.step_3_title') }}
                    </h3>
                    <p class="text-slate-600 dark:text-slate-300 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                        {{ __('frontend.step_3_desc') }}
                    </p>
                </div>
                
                <div class="hidden lg:block absolute top-1/2 {{ app()->getLocale() === 'ar' ? 'left-0 -translate-x-1/2 rotate-180' : 'right-0 translate-x-1/2' }} -translate-y-1/2 text-green-300 dark:text-green-700">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="group relative">
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-slate-200 dark:border-slate-700 h-full">
                    <div class="absolute -top-4 {{ app()->getLocale() === 'ar' ? 'right-8' : 'left-8' }} w-12 h-12 bg-gradient-to-br from-orange-600 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                        <span class="text-2xl font-black text-white">4</span>
                    </div>
                    
                    <div class="mt-6 mb-6 w-16 h-16 bg-gradient-to-br from-orange-100 to-red-100 dark:from-orange-900/30 dark:to-red-900/30 rounded-xl flex items-center justify-center {{ app()->getLocale() === 'ar' ? 'mr-auto' : 'ml-auto' }} group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                        {{ __('frontend.step_4_title') }}
                    </h3>
                    <p class="text-slate-600 dark:text-slate-300 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                        {{ __('frontend.step_4_desc') }}
                    </p>
                </div>
            </div>

        </div>

        <!-- CTA Button -->
        <div class="mt-16 text-center">
            <button onclick="document.getElementById('domainInput').focus()" class="group px-10 py-5 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-500 hover:to-cyan-500 text-white font-bold text-lg rounded-2xl shadow-2xl hover:shadow-cyan-500/50 transition-all duration-300 hover:scale-105">
                {{ __('frontend.start_search_now') }}
                <svg class="inline-block w-6 h-6 {{ app()->getLocale() === 'ar' ? 'mr-2 rotate-180' : 'ml-2' }} group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </button>
        </div>
    </div>
</section>

<!-- What's Included Section -->
<section class="relative py-24 overflow-hidden bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 dark:from-black dark:via-slate-950 dark:to-black">
    <!-- Animated Background -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-500 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-cyan-500 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <div class="inline-block mb-6">
                <span class="px-6 py-3 bg-gradient-to-r from-cyan-500 to-blue-500 text-white text-sm font-black rounded-full shadow-2xl uppercase tracking-wider">
                    ⭐ {{ __('frontend.premium_features') }}
                </span>
            </div>
            <h2 class="text-4xl md:text-6xl font-black text-white mb-6 leading-tight">
                {{ __('frontend.whats_included_title') }}
            </h2>
            <p class="text-xl text-slate-300 max-w-3xl mx-auto">
                {{ __('frontend.whats_included_desc') }}
            </p>
        </div>

        <!-- Features Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <!-- Feature 1: Domain Privacy -->
            <div class="group relative bg-slate-800/50 backdrop-blur-lg rounded-2xl p-8 border border-slate-700 hover:border-cyan-500 transition-all duration-300 hover:shadow-2xl hover:shadow-cyan-500/20 hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/10 to-blue-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                
                <div class="relative">
                    <!-- Icon -->
                    <div class="w-16 h-16 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-cyan-500/50">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    
                    <!-- Content -->
                    <h3 class="text-2xl font-black text-white mb-3 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                        {{ __('frontend.feature_privacy_title') }}
                    </h3>
                    <p class="text-slate-300 leading-relaxed {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                        {{ __('frontend.feature_privacy_desc') }}
                    </p>
                    
                    <!-- Badge -->
                    <div class="mt-4 inline-block px-3 py-1 bg-green-500/20 text-green-400 text-xs font-bold rounded-full border border-green-500/30">
                        {{ __('frontend.free') }}
                    </div>
                </div>
            </div>

            <!-- Feature 2: DNS Management -->
            <div class="group relative bg-slate-800/50 backdrop-blur-lg rounded-2xl p-8 border border-slate-700 hover:border-blue-500 transition-all duration-300 hover:shadow-2xl hover:shadow-blue-500/20 hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-purple-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                
                <div class="relative">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-blue-500/50">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    
                    <h3 class="text-2xl font-black text-white mb-3 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                        {{ __('frontend.feature_dns_title') }}
                    </h3>
                    <p class="text-slate-300 leading-relaxed {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                        {{ __('frontend.feature_dns_desc') }}
                    </p>
                    
                    <div class="mt-4 inline-block px-3 py-1 bg-green-500/20 text-green-400 text-xs font-bold rounded-full border border-green-500/30">
                        {{ __('frontend.free') }}
                    </div>
                </div>
            </div>

            <!-- Feature 3: Email Forwarding -->
            <div class="group relative bg-slate-800/50 backdrop-blur-lg rounded-2xl p-8 border border-slate-700 hover:border-purple-500 transition-all duration-300 hover:shadow-2xl hover:shadow-purple-500/20 hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-500/10 to-pink-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                
                <div class="relative">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-purple-500/50">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    
                    <h3 class="text-2xl font-black text-white mb-3 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                        {{ __('frontend.feature_email_title') }}
                    </h3>
                    <p class="text-slate-300 leading-relaxed {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                        {{ __('frontend.feature_email_desc') }}
                    </p>
                    
                    <div class="mt-4 inline-block px-3 py-1 bg-green-500/20 text-green-400 text-xs font-bold rounded-full border border-green-500/30">
                        {{ __('frontend.free') }}
                    </div>
                </div>
            </div>

            <!-- Feature 4: Domain Forwarding -->
            <div class="group relative bg-slate-800/50 backdrop-blur-lg rounded-2xl p-8 border border-slate-700 hover:border-green-500 transition-all duration-300 hover:shadow-2xl hover:shadow-green-500/20 hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-br from-green-500/10 to-emerald-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                
                <div class="relative">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-green-500/50">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    
                    <h3 class="text-2xl font-black text-white mb-3 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                        {{ __('frontend.feature_forwarding_title') }}
                    </h3>
                    <p class="text-slate-300 leading-relaxed {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                        {{ __('frontend.feature_forwarding_desc') }}
                    </p>
                    
                    <div class="mt-4 inline-block px-3 py-1 bg-green-500/20 text-green-400 text-xs font-bold rounded-full border border-green-500/30">
                        {{ __('frontend.free') }}
                    </div>
                </div>
            </div>

            <!-- Feature 5: Domain Lock -->
            <div class="group relative bg-slate-800/50 backdrop-blur-lg rounded-2xl p-8 border border-slate-700 hover:border-orange-500 transition-all duration-300 hover:shadow-2xl hover:shadow-orange-500/20 hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-br from-orange-500/10 to-red-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                
                <div class="relative">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-orange-500/50">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    
                    <h3 class="text-2xl font-black text-white mb-3 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                        {{ __('frontend.feature_lock_title') }}
                    </h3>
                    <p class="text-slate-300 leading-relaxed {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                        {{ __('frontend.feature_lock_desc') }}
                    </p>
                    
                    <div class="mt-4 inline-block px-3 py-1 bg-green-500/20 text-green-400 text-xs font-bold rounded-full border border-green-500/30">
                        {{ __('frontend.free') }}
                    </div>
                </div>
            </div>

            <!-- Feature 6: 24/7 Support -->
            <div class="group relative bg-slate-800/50 backdrop-blur-lg rounded-2xl p-8 border border-slate-700 hover:border-yellow-500 transition-all duration-300 hover:shadow-2xl hover:shadow-yellow-500/20 hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-br from-yellow-500/10 to-orange-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                
                <div class="relative">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-yellow-500/50">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    
                    <h3 class="text-2xl font-black text-white mb-3 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                        {{ __('frontend.feature_support_title') }}
                    </h3>
                    <p class="text-slate-300 leading-relaxed {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                        {{ __('frontend.feature_support_desc') }}
                    </p>
                    
                    <div class="mt-4 inline-block px-3 py-1 bg-green-500/20 text-green-400 text-xs font-bold rounded-full border border-green-500/30">
                        {{ __('frontend.free') }}
                    </div>
                </div>
            </div>

        </div>

        <!-- Bottom CTA -->
        <div class="mt-20 text-center">
            <div class="inline-block bg-gradient-to-r from-slate-800/80 to-slate-700/80 backdrop-blur-lg rounded-3xl p-10 border border-slate-600">
                <div class="flex items-center justify-center gap-4 mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-2xl flex items-center justify-center animate-pulse">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-3xl font-black text-white mb-1">{{ __('frontend.all_included_title') }}</p>
                        <p class="text-slate-300">{{ __('frontend.all_included_desc') }}</p>
                    </div>
                </div>
                <button onclick="document.getElementById('domainInput').focus()" class="px-10 py-5 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-white font-black text-lg rounded-2xl shadow-2xl hover:shadow-cyan-500/50 transition-all duration-300 hover:scale-105">
                    {{ __('frontend.register_domain_now') }}
                    <svg class="inline-block w-6 h-6 {{ app()->getLocale() === 'ar' ? 'mr-2 rotate-180' : 'ml-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Domain Support Section -->
<section class="py-20 bg-gradient-to-br from-blue-50 via-cyan-50 to-slate-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-2xl overflow-hidden border border-slate-200 dark:border-slate-700">
            <div class="grid lg:grid-cols-2 gap-0">
                
                <!-- Left Side - Content -->
                <div class="p-12 lg:p-16 flex flex-col justify-center {{ app()->getLocale() === 'ar' ? 'lg:order-2' : '' }}">
                    <!-- Badge -->
                    <div class="inline-block mb-6">
                        <span class="px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-600 text-white text-sm font-bold rounded-full shadow-lg uppercase tracking-wider">
                            {{ __('frontend.support_badge') }}
                        </span>
                    </div>
                    
                    <!-- Title -->
                    <h2 class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-6 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                        {{ __('frontend.domain_support_title') }}
                    </h2>
                    
                    <!-- Description -->
                    <p class="text-xl text-slate-600 dark:text-slate-300 mb-8 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                        {{ __('frontend.domain_support_desc') }}
                    </p>
                    
                    <!-- Contact Buttons -->
                    <div class="grid sm:grid-cols-2 gap-4">
                        <!-- Email Button -->
                        <a href="mailto:domain@progineous.com" class="group relative bg-gradient-to-br from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 text-white rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                            <div class="flex items-center gap-4 {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }}">
                                <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div class="flex-1 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                                    <p class="text-sm font-semibold text-white/80 mb-1">{{ __('frontend.contact_via') }}</p>
                                    <p class="text-lg font-black text-white">{{ __('frontend.email') }}</p>
                                </div>
                                <svg class="w-5 h-5 text-white/60 group-hover:text-white group-hover:translate-x-1 transition-all {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </a>
                        
                        <!-- Chat Button -->
                        <a href="#" onclick="event.preventDefault(); openIntercomChat();" class="group relative bg-gradient-to-br from-cyan-600 to-cyan-700 hover:from-cyan-500 hover:to-cyan-600 text-white rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                            <div class="flex items-center gap-4 {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }}">
                                <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                </div>
                                <div class="flex-1 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                                    <p class="text-sm font-semibold text-white/80 mb-1">{{ __('frontend.contact_via') }}</p>
                                    <p class="text-lg font-black text-white">{{ __('frontend.live_chat') }}</p>
                                </div>
                                <svg class="w-5 h-5 text-white/60 group-hover:text-white group-hover:translate-x-1 transition-all {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </a>
                    </div>
                    
                    <!-- Additional Info -->
                    <div class="mt-8 pt-8 border-t border-slate-200 dark:border-slate-700">
                        <div class="flex items-center gap-3 {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }}">
                            <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div class="{{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                                <p class="text-sm font-semibold text-slate-600 dark:text-slate-400">{{ __('frontend.avg_response_time') }}</p>
                                <p class="text-lg font-black text-slate-900 dark:text-white">{{ __('frontend.response_time_value') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Side - Image/Illustration -->
                <div class="relative bg-gradient-to-br from-blue-600 via-cyan-600 to-blue-700 p-12 lg:p-16 flex items-center justify-center overflow-hidden {{ app()->getLocale() === 'ar' ? 'lg:order-1' : '' }}">
                    <!-- Decorative Elements -->
                    <div class="absolute inset-0 opacity-20">
                        <div class="absolute top-10 left-10 w-32 h-32 bg-white rounded-full blur-3xl"></div>
                        <div class="absolute bottom-10 right-10 w-40 h-40 bg-cyan-300 rounded-full blur-3xl"></div>
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-blue-300 rounded-full blur-3xl"></div>
                    </div>
                    
                    <!-- Support Icon/Illustration -->
                    <div class="relative z-10">
                        <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-12 border border-white/20">
                            <div class="relative">
                                <!-- Main Icon -->
                                <div class="w-40 h-40 bg-white rounded-3xl flex items-center justify-center shadow-2xl mb-8 mx-auto animate-float">
                                    <svg class="w-20 h-20 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                </div>
                                
                                <!-- Floating Elements -->
                                <div class="absolute -top-4 -left-4 w-16 h-16 bg-yellow-400 rounded-2xl flex items-center justify-center shadow-xl animate-float" style="animation-delay: 0.5s;">
                                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"/>
                                        <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z"/>
                                    </svg>
                                </div>
                                
                                <div class="absolute -bottom-4 -right-4 w-16 h-16 bg-green-400 rounded-2xl flex items-center justify-center shadow-xl animate-float" style="animation-delay: 1s;">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                
                                <div class="absolute top-1/2 -right-8 w-12 h-12 bg-pink-400 rounded-xl flex items-center justify-center shadow-xl animate-float" style="animation-delay: 1.5s;">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                                    </svg>
                                </div>
                            </div>
                            
                            <!-- Stats -->
                            <div class="grid grid-cols-3 gap-4 mt-12">
                                <div class="text-center">
                                    <p class="text-3xl font-black text-white mb-1">24/7</p>
                                    <p class="text-xs text-white/80 font-semibold">{{ __('frontend.available') }}</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-3xl font-black text-white mb-1">< 5{{ __('frontend.min') }}</p>
                                    <p class="text-xs text-white/80 font-semibold">{{ __('frontend.response') }}</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-3xl font-black text-white mb-1">99%</p>
                                    <p class="text-xs text-white/80 font-semibold">{{ __('frontend.satisfaction') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>

<!-- Domain Search FAQs Section -->
<section class="py-24 bg-gradient-to-br from-white via-blue-50 to-cyan-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <div class="inline-block mb-6">
                <span class="px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 text-white text-sm font-black rounded-full shadow-2xl uppercase tracking-wider">
                    ❓ {{ __('frontend.faq_badge') }}
                </span>
            </div>
            <h2 class="text-4xl md:text-6xl font-black text-slate-900 dark:text-white mb-6 text-center">
                {!! __('frontend.domain_faq_title') !!}
            </h2>
            <p class="text-xl text-slate-600 dark:text-slate-300 max-w-3xl mx-auto text-center">
                {{ __('frontend.domain_faq_desc') }}
            </p>
        </div>

        <!-- FAQ Accordion -->
        <div class="space-y-4" x-data="{ activeTab: 1 }">
            
            <!-- FAQ 1 -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden transition-all duration-300 hover:shadow-xl">
                <button @click="activeTab = activeTab === 1 ? null : 1" class="w-full px-8 py-6 flex items-center {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }} gap-4 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                    <div class="flex items-center gap-4 flex-1">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-cyan-600 rounded-xl flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-black text-lg">1</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                            {{ __('frontend.faq_1_question') }}
                        </h3>
                    </div>
                    <svg class="w-6 h-6 text-slate-400 transition-transform duration-300 flex-shrink-0" :class="{'rotate-180': activeTab === 1}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="activeTab === 1" x-collapse class="px-8 pb-6">
                    <div class="{{ app()->getLocale() === 'ar' ? 'pr-16' : 'pl-16' }}">
                        <p class="text-slate-600 dark:text-slate-300 leading-relaxed {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                            {{ __('frontend.faq_1_answer') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- FAQ 2 -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden transition-all duration-300 hover:shadow-xl">
                <button @click="activeTab = activeTab === 2 ? null : 2" class="w-full px-8 py-6 flex items-center {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }} gap-4 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                    <div class="flex items-center gap-4 flex-1">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-600 to-pink-600 rounded-xl flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-black text-lg">2</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                            {{ __('frontend.faq_2_question') }}
                        </h3>
                    </div>
                    <svg class="w-6 h-6 text-slate-400 transition-transform duration-300 flex-shrink-0" :class="{'rotate-180': activeTab === 2}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="activeTab === 2" x-collapse class="px-8 pb-6">
                    <div class="{{ app()->getLocale() === 'ar' ? 'pr-16' : 'pl-16' }}">
                        <p class="text-slate-600 dark:text-slate-300 leading-relaxed {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                            {{ __('frontend.faq_2_answer') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- FAQ 3 -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden transition-all duration-300 hover:shadow-xl">
                <button @click="activeTab = activeTab === 3 ? null : 3" class="w-full px-8 py-6 flex items-center {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }} gap-4 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                    <div class="flex items-center gap-4 flex-1">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-600 to-emerald-600 rounded-xl flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-black text-lg">3</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                            {{ __('frontend.faq_3_question') }}
                        </h3>
                    </div>
                    <svg class="w-6 h-6 text-slate-400 transition-transform duration-300 flex-shrink-0" :class="{'rotate-180': activeTab === 3}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="activeTab === 3" x-collapse class="px-8 pb-6">
                    <div class="{{ app()->getLocale() === 'ar' ? 'pr-16' : 'pl-16' }}">
                        <p class="text-slate-600 dark:text-slate-300 leading-relaxed {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                            {{ __('frontend.faq_3_answer') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- FAQ 4 -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden transition-all duration-300 hover:shadow-xl">
                <button @click="activeTab = activeTab === 4 ? null : 4" class="w-full px-8 py-6 flex items-center {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }} gap-4 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                    <div class="flex items-center gap-4 flex-1">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-600 to-red-600 rounded-xl flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-black text-lg">4</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                            {{ __('frontend.faq_4_question') }}
                        </h3>
                    </div>
                    <svg class="w-6 h-6 text-slate-400 transition-transform duration-300 flex-shrink-0" :class="{'rotate-180': activeTab === 4}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="activeTab === 4" x-collapse class="px-8 pb-6">
                    <div class="{{ app()->getLocale() === 'ar' ? 'pr-16' : 'pl-16' }}">
                        <p class="text-slate-600 dark:text-slate-300 leading-relaxed {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                            {{ __('frontend.faq_4_answer') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- FAQ 5 -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden transition-all duration-300 hover:shadow-xl">
                <button @click="activeTab = activeTab === 5 ? null : 5" class="w-full px-8 py-6 flex items-center {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }} gap-4 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                    <div class="flex items-center gap-4 flex-1">
                        <div class="w-12 h-12 bg-gradient-to-br from-yellow-600 to-orange-600 rounded-xl flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-black text-lg">5</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                            {{ __('frontend.faq_5_question') }}
                        </h3>
                    </div>
                    <svg class="w-6 h-6 text-slate-400 transition-transform duration-300 flex-shrink-0" :class="{'rotate-180': activeTab === 5}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="activeTab === 5" x-collapse class="px-8 pb-6">
                    <div class="{{ app()->getLocale() === 'ar' ? 'pr-16' : 'pl-16' }}">
                        <p class="text-slate-600 dark:text-slate-300 leading-relaxed {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                            {{ __('frontend.faq_5_answer') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- FAQ 6 -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden transition-all duration-300 hover:shadow-xl">
                <button @click="activeTab = activeTab === 6 ? null : 6" class="w-full px-8 py-6 flex items-center {{ app()->getLocale() === 'ar' ? 'flex-row-reverse' : '' }} gap-4 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                    <div class="flex items-center gap-4 flex-1">
                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-black text-lg">6</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                            {{ __('frontend.faq_6_question') }}
                        </h3>
                    </div>
                    <svg class="w-6 h-6 text-slate-400 transition-transform duration-300 flex-shrink-0" :class="{'rotate-180': activeTab === 6}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="activeTab === 6" x-collapse class="px-8 pb-6">
                    <div class="{{ app()->getLocale() === 'ar' ? 'pr-16' : 'pl-16' }}">
                        <p class="text-slate-600 dark:text-slate-300 leading-relaxed {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                            {{ __('frontend.faq_6_answer') }}
                        </p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Still Have Questions CTA -->
        <div class="mt-16 text-center">
            <div class="inline-block bg-gradient-to-br from-blue-600 to-cyan-600 rounded-3xl p-10 shadow-2xl">
                <div class="flex items-center justify-center gap-4 mb-6">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="{{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                        <h3 class="text-2xl font-black text-white mb-2">{{ __('frontend.still_have_questions') }}</h3>
                        <p class="text-white/80">{{ __('frontend.contact_support_team') }}</p>
                    </div>
                </div>
                <button onclick="openIntercomChat()" class="px-8 py-4 bg-white hover:bg-slate-100 text-blue-600 font-black rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                    {{ __('frontend.contact_us_now') }}
                    <svg class="inline-block w-5 h-5 {{ app()->getLocale() === 'ar' ? 'mr-2 rotate-180' : 'ml-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>

<style>
@keyframes float {
    0%, 100% {
        transform: translateY(0) translateX(0);
    }
    25% {
        transform: translateY(-20px) translateX(10px);
    }
    50% {
        transform: translateY(-10px) translateX(-10px);
    }
    75% {
        transform: translateY(-15px) translateX(5px);
    }
}

@keyframes gradient-xy {
    0%, 100% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animate-gradient-xy {
    background-size: 200% 200%;
    animation: gradient-xy 4s ease infinite;
}
</style>

@endsection

@push('scripts')
<script>
// Function to open Intercom chat
function openIntercomChat() {
    try {
        // Try to get Intercom configuration
        const intercomConfig = document.getElementById('intercom-config');
        
        if (intercomConfig) {
            const config = JSON.parse(intercomConfig.textContent);
            
            // Check if Intercom is loaded
            if (window.Intercom) {
                // Show the Intercom messenger
                window.Intercom('show');
            } else {
                // If Intercom is not loaded yet, try to boot it
                if (config && config.app_id) {
                    window.Intercom('boot', {
                        app_id: config.app_id
                    });
                    // Wait a bit then show
                    setTimeout(() => {
                        if (window.Intercom) {
                            window.Intercom('show');
                        }
                    }, 500);
                } else {
                    console.error('Intercom configuration not found');
                    alert('{{ __('frontend.chat_not_available') }}');
                }
            }
        } else {
            console.error('Intercom config element not found');
            alert('{{ __('frontend.chat_not_available') }}');
        }
    } catch (error) {
        console.error('Error opening Intercom:', error);
        alert('{{ __('frontend.chat_not_available') }}');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('domainSearchForm');
    const input = document.getElementById('domainInput');
    const loadingState = document.getElementById('loadingState');
    const resultsContainer = document.getElementById('resultsContainer');
    const resultsList = document.getElementById('resultsList');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        searchDomainAvailability(input.value);
    });

    window.searchDomain = function(tld) {
        const currentValue = input.value.replace(/\.[a-z]+$/i, '');
        input.value = currentValue + tld;
        searchDomainAvailability(input.value);
    };

    function searchDomainAvailability(domain) {
        if (!domain) return;

        // Show loading
        loadingState.classList.remove('hidden');
        resultsContainer.classList.add('hidden');
        resultsList.innerHTML = '';

        // Send AJAX request
        fetch('{{ route("domains.check") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ domain: domain })
        })
        .then(response => response.json())
        .then(data => {
            loadingState.classList.add('hidden');
            resultsContainer.classList.remove('hidden');
            
            if (data.success && data.results) {
                displayResults(data.results);
            } else {
                showError(data.message || '{{ __("frontend.search_error") }}');
            }
        })
        .catch(error => {
            loadingState.classList.add('hidden');
            showError('{{ __("frontend.search_error") }}');
            console.error('Error:', error);
        });
    }

    function displayResults(results) {
        resultsList.innerHTML = '';
        
        // Check if there's a primary result (domain with specific extension)
        const primaryResult = results.find(r => r.is_primary);
        const suggestionResults = results.filter(r => r.is_suggestion);
        
        // If primary result is not available and there are suggestions, show header
        if (primaryResult && !primaryResult.available && suggestionResults.length > 0) {
            // Add "Domain Not Available" message
            const notAvailableHeader = document.createElement('div');
            notAvailableHeader.className = 'col-span-full mb-4 p-6 bg-red-50 dark:bg-red-900/10 border-2 border-red-200 dark:border-red-800 rounded-2xl';
            notAvailableHeader.innerHTML = `
                <div class="flex items-center gap-3 mb-3">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-xl font-bold text-red-900 dark:text-red-100">
                        {{ __("frontend.domain_not_available") }}
                    </h3>
                </div>
                <p class="text-red-700 dark:text-red-300">
                    {{ __("frontend.domain_not_available_desc") }}
                </p>
            `;
            resultsList.appendChild(notAvailableHeader);
            
            // Show primary result
            resultsList.appendChild(createResultCard(primaryResult, false));
            
            // Add "Suggestions" header
            const suggestionsHeader = document.createElement('div');
            suggestionsHeader.className = 'col-span-full mt-8 mb-4';
            suggestionsHeader.innerHTML = `
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white">
                        {{ __("frontend.alternative_suggestions") }}
                    </h3>
                </div>
            `;
            resultsList.appendChild(suggestionsHeader);
            
            // Show suggestions
            suggestionResults.forEach(result => {
                resultsList.appendChild(createResultCard(result, false));
            });
            
            return; // Exit early
        }
        
        // Default behavior: Separate default and additional results
        const defaultResults = results.filter(r => !r.is_additional);
        const additionalResults = results.filter(r => r.is_additional);
        
        // Display default results (always visible)
        defaultResults.forEach(result => {
            resultsList.appendChild(createResultCard(result, false));
        });
        
        // Display additional results (initially hidden)
        additionalResults.forEach(result => {
            resultsList.appendChild(createResultCard(result, true));
        });
        
        // Show/hide View More button
        const viewMoreContainer = document.getElementById('viewMoreContainer');
        if (additionalResults.length > 0) {
            viewMoreContainer.classList.remove('hidden');
            setupViewMoreButton(additionalResults.length);
        } else {
            viewMoreContainer.classList.add('hidden');
        }
    }

    function createResultCard(result, isAdditional) {
        const card = document.createElement('div');
        
        // Add special styling for suggestions
        let cardClasses = `domain-result ${isAdditional ? 'additional-result hidden' : ''} p-6 rounded-2xl border-2 transition-all duration-200 `;
        
        if (result.is_suggestion && result.available) {
            // Suggestion cards with special styling
            cardClasses += 'bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 border-blue-300 dark:border-blue-700 hover:shadow-xl hover:scale-105 ring-2 ring-blue-200 dark:ring-blue-800';
        } else if (result.available) {
            cardClasses += 'bg-green-50 dark:bg-green-900/10 border-green-200 dark:border-green-800 hover:shadow-lg';
        } else {
            cardClasses += 'bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700';
        }
        
        card.className = cardClasses;
        
        card.innerHTML = `
                ${result.is_suggestion && result.available ? `
                    <div class="mb-3">
                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 text-xs font-bold rounded-full">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            {{ __("frontend.suggested") }}
                        </span>
                    </div>
                ` : ''}
                <div class="flex items-start justify-between gap-4 mb-4">
                    <div class="flex items-start gap-3 flex-1 min-w-0">
                        <div class="w-10 h-10 flex-shrink-0 rounded-full flex items-center justify-center ${
                            result.available 
                                ? 'bg-green-100 dark:bg-green-900/30' 
                                : 'bg-slate-200 dark:bg-slate-700'
                        }">
                            <svg class="w-6 h-6 ${
                                result.available 
                                    ? 'text-green-600 dark:text-green-400' 
                                    : 'text-slate-500'
                            }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                ${result.available 
                                    ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>'
                                    : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>'
                                }
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-bold break-all ${
                                result.available 
                                    ? 'text-green-900 dark:text-green-100' 
                                    : 'text-slate-900 dark:text-white'
                            }">
                                ${result.domain}
                            </h3>
                            <p class="text-sm ${
                                result.available 
                                    ? 'text-green-600 dark:text-green-400' 
                                    : 'text-slate-500'
                            }">
                                ${result.available ? '{{ __("frontend.available") }}' : '{{ __("frontend.not_available") }}'}
                            </p>
                        </div>
                    </div>
                    ${result.available ? `
                        <div class="flex-shrink-0 text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}">
                            <div class="text-2xl font-black text-blue-600 dark:text-blue-400 whitespace-nowrap">
                                $${result.price}
                            </div>
                            <div class="text-xs text-slate-500 whitespace-nowrap">
                                {{ __("frontend.per_year") }}
                            </div>
                        </div>
                    ` : ''}
                </div>
                ${result.available ? `
                    <button onclick="addToCart('${result.domain}', ${result.price}, 'register', '${result.tld || result.domain.split('.').pop()}', ${result.renewal_price || result.price})" class="w-full py-3 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 add-to-cart-btn">
                        {{ __("frontend.add_to_cart") }}
                    </button>
                ` : `
                    <button class="w-full py-3 bg-slate-200 dark:bg-slate-700 text-slate-500 dark:text-slate-400 font-bold rounded-xl cursor-not-allowed" disabled>
                        {{ __("frontend.not_available") }}
                    </button>
                `}
        `;
        
        return card;
    }

    function setupViewMoreButton(additionalCount) {
        const viewMoreBtn = document.getElementById('viewMoreBtn');
        const viewMoreText = document.getElementById('viewMoreText');
        const viewMoreIcon = document.getElementById('viewMoreIcon');
        const viewLessIcon = document.getElementById('viewLessIcon');
        const viewMoreCount = document.getElementById('viewMoreCount');
        let isExpanded = false;

        viewMoreCount.textContent = `+${additionalCount}`;

        viewMoreBtn.onclick = function() {
            const additionalResults = document.querySelectorAll('.additional-result');
            isExpanded = !isExpanded;

            additionalResults.forEach(result => {
                if (isExpanded) {
                    result.classList.remove('hidden');
                } else {
                    result.classList.add('hidden');
                }
            });

            // Update button text and icon
            if (isExpanded) {
                viewMoreText.textContent = '{{ __("frontend.view_less_extensions") }}';
                viewMoreIcon.classList.add('hidden');
                viewLessIcon.classList.remove('hidden');
                viewMoreCount.classList.add('hidden');
            } else {
                viewMoreText.textContent = '{{ __("frontend.view_more_extensions") }}';
                viewMoreIcon.classList.remove('hidden');
                viewLessIcon.classList.add('hidden');
                viewMoreCount.classList.remove('hidden');
            }

            // Smooth scroll to view more button
            if (!isExpanded) {
                viewMoreBtn.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        };
    }

    function showError(message) {
        resultsContainer.classList.remove('hidden');
        resultsList.innerHTML = `
            <div class="col-span-2 p-8 text-center bg-red-50 dark:bg-red-900/10 border-2 border-red-200 dark:border-red-800 rounded-2xl">
                <svg class="w-16 h-16 text-red-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-lg text-red-900 dark:text-red-100 font-semibold">${message}</p>
            </div>
        `;
    }
});

// Add to Cart Function
function addToCart(domain, price, type, tld, renewalPrice = null) {
    const button = event.target;
    const originalText = button.innerHTML;
    
    // Fix undefined TLD - extract from domain if needed
    if (!tld || tld === 'undefined' || tld === undefined) {
        const domainParts = domain.split('.');
        tld = domainParts.length >= 2 ? domainParts[domainParts.length - 1] : 'com';
    }
    
    // Default renewal price to registration price if not provided
    if (!renewalPrice || renewalPrice === 'undefined' || renewalPrice === undefined) {
        renewalPrice = price;
    }
    
    // Disable button and show loading
    button.disabled = true;
    button.innerHTML = '<svg class="animate-spin h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
    
    fetch('{{ route("cart.add-domain") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            domain: domain,
            price: price,
            type: type,
            tld: tld,
            renewal_price: renewalPrice
        })
    })
    .then(response => {
        // Check for 419 CSRF token error
        if (response.status === 419) {
            showNotification('{{ __("frontend.session_expired") ?? "Session expired. Please refresh the page." }}', 'error');
            button.innerHTML = originalText;
            button.disabled = false;
            // Reload page after 2 seconds to get new CSRF token
            setTimeout(() => {
                window.location.reload();
            }, 2000);
            return Promise.reject('CSRF token expired');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Show success message
            button.innerHTML = '<svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
            button.classList.remove('from-blue-600', 'to-cyan-600');
            button.classList.add('from-green-600', 'to-green-700');
            
            // Update cart count in header if exists
            updateCartCount(data.cartCount);
            
            // Show success notification
            showNotification(data.message, 'success');
            
            // Reset button after 2 seconds
            setTimeout(() => {
                button.innerHTML = originalText;
                button.classList.remove('from-green-600', 'to-green-700');
                button.classList.add('from-blue-600', 'to-cyan-600');
                button.disabled = false;
            }, 2000);
        } else {
            // Show error message
            showNotification(data.message, 'error');
            button.innerHTML = originalText;
            button.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('{{ __("frontend.domain_search_error") }}', 'error');
        button.innerHTML = originalText;
        button.disabled = false;
    });
}

// Update Cart Count
function updateCartCount(count) {
    const cartBadge = document.getElementById('cart-count');
    if (cartBadge) {
        cartBadge.textContent = count;
        if (count > 0) {
            cartBadge.classList.remove('hidden');
            cartBadge.classList.add('flex');
        } else {
            cartBadge.classList.add('hidden');
            cartBadge.classList.remove('flex');
        }
    }
}

// Show Notification
function showNotification(message, type = 'success') {
    const notificationContainer = document.getElementById('notification-container') || createNotificationContainer();
    
    const notification = document.createElement('div');
    notification.className = `transform transition-all duration-300 ease-in-out mb-4 ${
        type === 'success' 
            ? 'bg-green-500' 
            : 'bg-red-500'
    } text-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3`;
    
    notification.innerHTML = `
        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            ${type === 'success' 
                ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>'
                : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>'
            }
        </svg>
        <span class="font-semibold">${message}</span>
    `;
    
    notificationContainer.appendChild(notification);
    
    // Remove notification after 3 seconds
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Create Notification Container
function createNotificationContainer() {
    const container = document.createElement('div');
    container.id = 'notification-container';
    container.className = 'fixed top-4 {{ app()->getLocale() == "ar" ? "left-4" : "right-4" }} z-50 max-w-md';
    document.body.appendChild(container);
    return container;
}
</script>
@endpush

@push('styles')
<style>
/* Responsive domain cards - prevent overflow */
.domain-result {
    overflow: hidden;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

.domain-result h3 {
    word-break: break-all;
    hyphens: auto;
    line-height: 1.4;
}

/* Ensure grid items don't overflow */
#resultsList {
    overflow: hidden;
}

#resultsList > div {
    min-width: 0; /* Important for flex items */
}

/* For very small screens */
@media (max-width: 640px) {
    .domain-result h3 {
        font-size: 0.95rem;
    }
    
    .domain-result {
        padding: 1rem;
    }
}
</style>
@endpush
