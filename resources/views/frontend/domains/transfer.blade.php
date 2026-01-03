@extends('frontend.layout')

@section('title', __('frontend.domain_transfer_title') . ' - ' . config('app.name'))
@section('description', __('frontend.domain_transfer_subtitle'))

@push('styles')
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@section('content')
<!-- Hero Section - Domain Transfer -->
<section class="relative pt-24 pb-32 overflow-hidden min-h-[75vh] flex items-center bg-gradient-to-br from-emerald-50 via-teal-50/30 to-cyan-50/20 dark:from-slate-950 dark:via-emerald-950/30 dark:to-teal-950/20">
    
    <!-- Advanced Background Effects -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <!-- Gradient Mesh -->
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(16,185,129,0.08),transparent_50%),radial-gradient(circle_at_70%_60%,rgba(20,184,166,0.08),transparent_50%)]"></div>
        
        <!-- Animated Orbs -->
        <div class="absolute -top-40 {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} w-[600px] h-[600px] bg-gradient-to-br from-emerald-400/15 to-teal-400/10 dark:from-emerald-500/10 dark:to-teal-500/5 rounded-full blur-3xl animate-float"></div>
        <div class="absolute -bottom-40 {{ app()->getLocale() == 'ar' ? 'right-0' : 'left-0' }} w-[700px] h-[700px] bg-gradient-to-tr from-teal-400/12 to-emerald-400/8 dark:from-teal-500/8 dark:to-emerald-500/4 rounded-full blur-3xl animate-float animation-delay-2000"></div>
        
        <!-- Grid Pattern -->
        <div class="absolute inset-0 bg-[linear-gradient(rgba(16,185,129,0.03)_1px,transparent_1px),linear-gradient(90deg,rgba(16,185,129,0.03)_1px,transparent_1px)] bg-[size:64px_64px] [mask-image:radial-gradient(ellipse_80%_50%_at_50%_50%,black,transparent)]"></div>
        
        <!-- Floating Elements -->
        <div class="absolute top-1/4 {{ app()->getLocale() == 'ar' ? 'right-[10%]' : 'left-[10%]' }} w-2 h-2 bg-emerald-500/40 rounded-full animate-ping"></div>
        <div class="absolute top-1/3 {{ app()->getLocale() == 'ar' ? 'left-[15%]' : 'right-[15%]' }} w-3 h-3 bg-teal-500/40 rounded-full animate-ping animation-delay-1000"></div>
        <div class="absolute bottom-1/4 {{ app()->getLocale() == 'ar' ? 'left-[20%]' : 'right-[20%]' }} w-2 h-2 bg-emerald-400/40 rounded-full animate-ping animation-delay-2000"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-2 mb-8 bg-emerald-100/80 dark:bg-emerald-900/30 backdrop-blur-sm border border-emerald-200/50 dark:border-emerald-800/50 rounded-full">
                    <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-semibold text-emerald-900 dark:text-emerald-100">
                        {{ __('frontend.transfer_badge') ?? 'نقل آمن وسريع' }}
                    </span>
                </div>
                
                <!-- Main Heading with Gradient -->
                <h1 class="text-5xl md:text-7xl lg:text-8xl font-black mb-8 leading-tight pb-2">
                    <span class="block text-slate-900 dark:text-white mb-3">
                        {{ __('frontend.domain_transfer_title') }}
                    </span>
                    <span class="block bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-700 dark:from-emerald-400 dark:via-teal-400 dark:to-emerald-500 bg-clip-text text-transparent pb-1">
                        {{ __('frontend.domain_transfer_subtitle_main') ?? 'بكل سهولة وأمان' }}
                    </span>
                </h1>
                
                <!-- Enhanced Subtitle -->
                <p class="text-xl md:text-2xl text-slate-600 dark:text-slate-400 mb-12 max-w-3xl mx-auto leading-relaxed font-light">
                    {{ __('frontend.domain_transfer_subtitle') }}
                </p>
            </div>

            <!-- Enhanced Transfer Form -->
            <div class="max-w-5xl mx-auto mb-12">
                <div class="relative group">
                    <!-- Glow Effect -->
                    <div class="absolute -inset-1 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-3xl blur-xl opacity-25 group-hover:opacity-40 transition-opacity duration-300"></div>
                    
                    <!-- Transfer Form -->
                    <div class="relative bg-white/95 dark:bg-slate-900/95 backdrop-blur-sm rounded-3xl shadow-2xl p-8 border border-white/20 dark:border-slate-700/50">
                        <form id="domainTransferForm" class="space-y-6">
                            @csrf
                            
                            <!-- Domain Name Input -->
                            <div class="relative">
                                <label for="transferDomainInput" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
                                    {{ __('frontend.transfer_domain_label') ?? 'اسم النطاق المراد نقله' }}
                                </label>
                                <div class="relative">
                                    <div class="absolute {{ app()->getLocale() == 'ar' ? 'right-6' : 'left-6' }} top-1/2 -translate-y-1/2 pointer-events-none">
                                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                        </svg>
                                    </div>
                                    <input 
                                        type="text" 
                                        name="domain"
                                        id="transferDomainInput" 
                                        placeholder="{{ __('frontend.enter_domain_to_transfer') }}" 
                                        class="w-full {{ app()->getLocale() == 'ar' ? 'pr-14 pl-6' : 'pl-14 pr-6' }} py-5 bg-slate-50 dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-700 rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 dark:focus:ring-emerald-400 focus:border-transparent text-lg font-medium transition-all"
                                        required
                                    >
                                </div>
                                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
                                    {{ __('frontend.transfer_domain_hint') ?? 'مثال: example.com' }}
                                </p>
                            </div>

                            <!-- Auth Code Input -->
                            <div class="relative">
                                <label for="authCodeInput" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
                                    {{ __('frontend.auth_code_label') ?? 'رمز التحويل (Auth Code)' }}
                                </label>
                                <div class="relative">
                                    <div class="absolute {{ app()->getLocale() == 'ar' ? 'right-6' : 'left-6' }} top-1/2 -translate-y-1/2 pointer-events-none">
                                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                    </div>
                                    <input 
                                        type="text" 
                                        name="auth_code"
                                        id="authCodeInput" 
                                        placeholder="{{ __('frontend.enter_auth_code') }}" 
                                        class="w-full {{ app()->getLocale() == 'ar' ? 'pr-14 pl-6' : 'pl-14 pr-6' }} py-5 bg-slate-50 dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-700 rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 dark:focus:ring-emerald-400 focus:border-transparent text-lg font-medium transition-all"
                                        required
                                    >
                                </div>
                                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
                                    {{ __('frontend.auth_code_hint') ?? 'احصل على رمز التحويل من مزود الخدمة الحالي' }}
                                </p>
                            </div>

                            <!-- Submit Button -->
                            <button 
                                type="submit"
                                id="transferButton" 
                                class="group w-full px-10 py-5 glass-button bg-gradient-to-r from-emerald-600/90 to-teal-600/90 hover:from-emerald-700 hover:to-teal-700 text-white font-bold text-lg rounded-2xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition-all duration-300 flex items-center justify-center gap-3 border border-white/30"
                            >
                                <svg id="transferIcon" class="w-6 h-6 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                </svg>
                                <svg id="transferLoadingIcon" class="w-6 h-6 animate-spin hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                <span id="transferText">{{ __('frontend.start_transfer') }}</span>
                            </button>
                        </form>

                        <!-- Transfer Results Container -->
                        <div id="transferResults" class="mt-6 hidden"></div>
                    </div>
                </div>

                <!-- Important Notes -->
                <div class="mt-8 bg-blue-50/80 dark:bg-blue-900/20 backdrop-blur-sm border border-blue-200/50 dark:border-blue-800/50 rounded-2xl p-6">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="flex-1 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
                            <h3 class="text-lg font-bold text-blue-900 dark:text-blue-100 mb-3">
                                {{ __('frontend.transfer_important_notes') ?? 'ملاحظات مهمة' }}
                            </h3>
                            <ul class="space-y-2 text-sm text-blue-800 dark:text-blue-200">
                                <li class="flex items-start gap-2">
                                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>{{ __('frontend.transfer_note_1') }}</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>{{ __('frontend.transfer_note_2') }}</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>{{ __('frontend.transfer_note_3') }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Transfer Pricing Section -->
<section class="py-20 bg-white dark:bg-slate-900 relative overflow-hidden">
    <!-- Decorative Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-24 {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} w-96 h-96 bg-emerald-100 dark:bg-emerald-900/10 rounded-full blur-3xl opacity-30"></div>
        <div class="absolute -bottom-24 {{ app()->getLocale() == 'ar' ? 'right-0' : 'left-0' }} w-96 h-96 bg-teal-100 dark:bg-teal-900/10 rounded-full blur-3xl opacity-30"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-7xl mx-auto">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <h2 class="text-4xl lg:text-5xl font-extrabold mb-4">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-700 dark:from-emerald-400 dark:via-teal-400 dark:to-emerald-500">
                        {{ __('frontend.transfer_pricing_title') ?? 'أسعار نقل النطاقات' }}
                    </span>
                </h2>
                <p class="text-xl text-slate-600 dark:text-slate-400 max-w-3xl mx-auto mb-8">
                    {{ __('frontend.transfer_pricing_subtitle') ?? 'أسعار تنافسية لنقل نطاقك مع سنة إضافية مجانية' }}
                </p>
                
                @if(isset($transferPrices) && $transferPrices->count() > 0)
                    <!-- Search Box -->
                    <div class="max-w-xl mx-auto mb-8">
                        <div class="relative group">
                            <div class="absolute -inset-0.5 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-2xl blur opacity-25 group-hover:opacity-40 transition-opacity"></div>
                            <div class="relative">
                                <div class="absolute {{ app()->getLocale() == 'ar' ? 'right-4' : 'left-4' }} top-1/2 -translate-y-1/2 pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                                <input 
                                    type="text" 
                                    id="tldSearchInput"
                                    placeholder="{{ __('frontend.search_tld') ?? 'ابحث عن امتداد... (مثال: com, net, org)' }}"
                                    class="w-full {{ app()->getLocale() == 'ar' ? 'pr-12 pl-6' : 'pl-12 pr-6' }} py-4 bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 rounded-2xl text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 dark:focus:ring-emerald-400 focus:border-transparent transition-all"
                                >
                            </div>
                        </div>
                        <!-- Results Counter -->
                        <div class="mt-3 text-sm text-slate-600 dark:text-slate-400 text-center">
                            <span id="resultsCounter">{{ __('frontend.showing_results', ['count' => $transferPrices->count()]) }}</span>
                            <span id="totalResults" class="font-semibold">{{ $transferPrices->count() }}</span>
                            {{ __('frontend.total_extensions') ?? 'امتداد متاح' }}
                        </div>
                    </div>
                @endif
            </div>

            @if(isset($transferPrices) && $transferPrices->count() > 0)
                <!-- Pricing Grid -->
                <div id="tldPricingGrid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
                    @php
                        $tldColors = [
                            'com' => 'blue',
                            'net' => 'purple',
                            'org' => 'green',
                            'io' => 'cyan',
                            'co' => 'orange',
                            'me' => 'pink',
                            'online' => 'indigo',
                            'app' => 'red',
                            'dev' => 'teal',
                            'store' => 'amber',
                            'tech' => 'violet',
                            'shop' => 'rose',
                            'info' => 'sky',
                            'biz' => 'emerald',
                            'site' => 'lime',
                            'website' => 'fuchsia',
                        ];
                        
                        $popularTlds = ['.com', '.net', '.org', '.io', '.co', '.me'];
                    @endphp

                    @foreach($transferPrices as $index => $transfer)
                        @php
                            $tldName = str_replace('.', '', $transfer['tld']);
                            $color = $tldColors[$tldName] ?? 'slate';
                            $isPopular = in_array($transfer['tld'], $popularTlds);
                            // Hide cards after the 12th one initially
                            $isHidden = $index >= 12;
                        @endphp
                        
                        <!-- Transfer Price Card -->
                        <div class="tld-card {{ $isHidden ? 'hidden-card' : '' }} group relative bg-gradient-to-br from-white to-slate-50 dark:from-slate-800 dark:to-slate-900 rounded-2xl p-6 border-2 border-slate-200 dark:border-slate-700 hover:border-{{ $color }}-500 dark:hover:border-{{ $color }}-500 hover:shadow-2xl hover:scale-105 transition-all duration-300 overflow-hidden" data-tld="{{ $transfer['tld'] }}" data-tld-name="{{ $tldName }}" data-price="{{ $transfer['price'] }}" style="{{ $isHidden ? 'display: none;' : '' }}">
                            <!-- Popular Badge -->
                            @if($isPopular)
                                <div class="absolute top-2 {{ app()->getLocale() == 'ar' ? 'left-2' : 'right-2' }} z-10">
                                    <div class="flex items-center gap-1 px-2 py-1 bg-gradient-to-r from-amber-500 to-orange-500 rounded-full shadow-lg">
                                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        <span class="text-xs font-bold text-white">{{ __('frontend.popular') ?? 'شائع' }}</span>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Hover Glow Effect -->
                            <div class="absolute inset-0 bg-gradient-to-br from-{{ $color }}-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            <div class="relative text-center">
                                <!-- TLD Badge -->
                                <div class="inline-flex items-center justify-center w-16 h-16 bg-{{ $color }}-100 dark:bg-{{ $color }}-900/30 rounded-xl mb-4 group-hover:scale-110 transition-transform duration-300">
                                    <span class="text-2xl font-black text-{{ $color }}-600 dark:text-{{ $color }}-400">
                                        {{ strtoupper(str_replace('.', '', $transfer['tld'])) }}
                                    </span>
                                </div>
                                
                                <!-- TLD Extension -->
                                <div class="text-3xl font-black text-slate-900 dark:text-white mb-2">
                                    {{ $transfer['tld'] }}
                                </div>
                                
                                <!-- Price -->
                                <div class="mb-2">
                                    <span class="text-2xl font-bold text-{{ $color }}-600 dark:text-{{ $color }}-400">
                                        ${{ number_format($transfer['price'], 2) }}
                                    </span>
                                </div>
                                
                                <!-- Period Label -->
                                <div class="text-xs font-medium text-slate-500 dark:text-slate-400 mb-3">
                                    {{ __('frontend.transfer_price_label') ?? 'سعر النقل' }}
                                </div>
                                
                                <!-- Free Year Badge -->
                                <div class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-100 dark:bg-emerald-900/30 rounded-full">
                                    <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400">
                                        {{ __('frontend.free_year') ?? '+1 سنة' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Show More Button -->
                @if($transferPrices->count() > 12)
                    <div id="showMoreContainer" class="mt-8 text-center">
                        <button 
                            id="showMoreBtn"
                            class="group inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold text-lg rounded-2xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition-all duration-300 border border-white/30"
                        >
                            <span id="showMoreText">{{ __('frontend.show_more_extensions') ?? 'عرض المزيد من الامتدادات' }}</span>
                            <span id="showMoreCount" class="px-3 py-1 bg-white/20 rounded-full text-sm font-bold">
                                +{{ $transferPrices->count() - 12 }}
                            </span>
                            <svg id="showMoreIcon" class="w-5 h-5 group-hover:translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                            <svg id="showLessIcon" class="w-5 h-5 group-hover:-translate-y-1 transition-transform hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/>
                            </svg>
                        </button>
                    </div>
                @endif

                <!-- No Results Message -->
                <div id="noResultsMessage" class="hidden text-center py-16">
                    <div class="inline-flex flex-col items-center gap-4">
                        <svg class="w-20 h-20 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <div>
                            <p class="text-xl font-bold text-slate-600 dark:text-slate-400 mb-2">
                                {{ __('frontend.no_tld_found') ?? 'لم يتم العثور على نتائج' }}
                            </p>
                            <p class="text-sm text-slate-500 dark:text-slate-500">
                                {{ __('frontend.try_different_search') ?? 'جرب البحث بكلمات مختلفة' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="mt-12 text-center">
                    <div class="inline-flex items-center gap-3 px-6 py-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl border border-emerald-200 dark:border-emerald-800">
                        <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <div class="{{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
                            <p class="text-sm font-bold text-emerald-900 dark:text-emerald-100">
                                {{ __('frontend.transfer_bonus') ?? 'احصل على سنة إضافية مجاناً مع كل نقل!' }}
                            </p>
                            <p class="text-xs text-emerald-700 dark:text-emerald-300">
                                {{ __('frontend.transfer_bonus_desc') ?? 'عند نقل نطاقك إلينا، نضيف سنة كاملة إلى مدة تسجيلك الحالية' }}
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <!-- No Pricing Available -->
                <div class="text-center py-12">
                    <div class="inline-flex items-center gap-3 text-slate-500 dark:text-slate-400">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-xl font-semibold">{{ __('frontend.no_pricing_available') ?? 'لا توجد أسعار متاحة حالياً' }}</span>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Before Your Domain Transfer Section -->
<section class="py-20 bg-gradient-to-br from-slate-900 via-emerald-900 to-slate-900 dark:from-slate-950 dark:via-emerald-950 dark:to-slate-950 relative overflow-hidden">
    <!-- Background Effects -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <!-- Gradient Mesh -->
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(16,185,129,0.15),transparent_50%),radial-gradient(circle_at_70%_60%,rgba(20,184,166,0.15),transparent_50%)]"></div>
        
        <!-- Animated Circles -->
        <div class="absolute top-0 {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 {{ app()->getLocale() == 'ar' ? 'right-0' : 'left-0' }} w-96 h-96 bg-teal-500/10 rounded-full blur-3xl animate-pulse animation-delay-2000"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-6xl mx-auto">
            <!-- Section Header -->
            <div class="flex flex-col lg:flex-row items-start gap-12 mb-16">
                <!-- Left Side: Icon Animation -->
                <div class="flex-shrink-0">
                    <div class="relative w-32 h-32 lg:w-40 lg:h-40">
                        <!-- Animated Circles -->
                        <div class="absolute inset-0 flex items-center justify-center">
                            <!-- Outer Circle (animated) -->
                            <div class="absolute w-full h-full border-4 border-emerald-500/30 rounded-full animate-spin-slow"></div>
                            
                            <!-- Middle Circle -->
                            <div class="absolute w-24 h-24 lg:w-32 lg:h-32 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-full flex items-center justify-center">
                                <!-- Arrow Icon -->
                                <svg class="w-12 h-12 lg:w-16 lg:h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                </svg>
                            </div>
                            
                            <!-- Inner Circle (pulsing) -->
                            <div class="absolute w-20 h-20 lg:w-28 lg:h-28 bg-emerald-400/20 rounded-full animate-ping"></div>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Title and Description -->
                <div class="flex-1 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
                    <h2 class="text-4xl lg:text-5xl font-black text-white mb-6 leading-tight">
                        {{ __('frontend.before_transfer_title') ?? 'قبل نقل نطاقك' }}
                    </h2>
                    <p class="text-xl text-slate-300 leading-relaxed">
                        {{ __('frontend.before_transfer_subtitle') ?? 'قبل البدء في عملية نقل نطاقك، ضع النقاط التالية في اعتبارك:' }}
                    </p>
                    
                    <!-- Guide Button -->
                    <a href="#" class="inline-flex items-center gap-2 mt-6 px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <span>{{ __('frontend.domain_transfer_guide') ?? 'دليل نقل النطاق' }}</span>
                        <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Requirements Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Requirement 1: No Recent Changes -->
                <div class="group relative bg-slate-800/50 dark:bg-slate-900/50 backdrop-blur-sm rounded-2xl p-8 border border-slate-700/50 dark:border-slate-800/50 hover:border-emerald-500/50 transition-all duration-300 hover:shadow-2xl hover:shadow-emerald-500/10">
                    <!-- Icon -->
                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>

                    <!-- Title -->
                    <h3 class="text-xl font-bold text-white mb-4 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
                        {{ __('frontend.no_recent_changes') ?? 'لا توجد تغييرات حديثة' }}
                    </h3>

                    <!-- Description -->
                    <p class="text-slate-400 leading-relaxed {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
                        {{ __('frontend.no_recent_changes_desc') ?? 'يجب ألا يكون النطاق مسجلاً أو منقولاً حديثاً (خلال 60 يوماً)، أو منتهي الصلاحية، أو على وشك الانتهاء (نوصي ببدء النقل قبل أسبوعين على الأقل من انتهاء صلاحية النطاق).' }}
                    </p>
                </div>

                <!-- Requirement 2: Whois Email -->
                <div class="group relative bg-slate-800/50 dark:bg-slate-900/50 backdrop-blur-sm rounded-2xl p-8 border border-slate-700/50 dark:border-slate-800/50 hover:border-teal-500/50 transition-all duration-300 hover:shadow-2xl hover:shadow-teal-500/10">
                    <!-- Icon -->
                    <div class="w-16 h-16 bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>

                    <!-- Title -->
                    <h3 class="text-xl font-bold text-white mb-4 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
                        {{ __('frontend.whois_email_current') ?? 'عنوان البريد الإلكتروني Whois حالي' }}
                    </h3>

                    <!-- Description -->
                    <p class="text-slate-400 leading-relaxed {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
                        {{ __('frontend.whois_email_current_desc') ?? 'تأكد من أن عنوان البريد الإلكتروني Whois الخاص بك محدث حيث أن هذا هو العنوان الذي سنستخدمه لترخيص النقل.' }}
                    </p>
                </div>

                <!-- Requirement 3: 1 Year Extension -->
                <div class="group relative bg-slate-800/50 dark:bg-slate-900/50 backdrop-blur-sm rounded-2xl p-8 border border-slate-700/50 dark:border-slate-800/50 hover:border-emerald-500/50 transition-all duration-300 hover:shadow-2xl hover:shadow-emerald-500/10">
                    <!-- Icon -->
                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                        </svg>
                    </div>

                    <!-- Title -->
                    <h3 class="text-xl font-bold text-white mb-4 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
                        {{ __('frontend.one_year_extension') ?? 'تمديد سنة واحدة' }}
                    </h3>

                    <!-- Description -->
                    <p class="text-slate-400 leading-relaxed {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
                        {{ __('frontend.one_year_extension_desc') ?? 'كل نقل نطاق يمدد تسجيل نطاقك بسنة واحدة (مع بعض الاستثناءات - استكشف ذلك أدناه).' }}
                    </h3>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Transfer Section -->
<section class="relative py-24 bg-gradient-to-br from-white via-emerald-50/20 to-teal-50/20 dark:from-slate-900 dark:via-emerald-950/10 dark:to-teal-950/10 overflow-hidden">
    <!-- Decorative Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <!-- Animated Circles -->
        <div class="absolute top-20 left-1/4 w-64 h-64 bg-emerald-400/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-1/4 w-64 h-64 bg-teal-400/10 rounded-full blur-3xl animate-pulse animation-delay-2000"></div>
        
        <!-- Decorative Lines -->
        <div class="absolute top-1/3 left-0 w-full h-px bg-gradient-to-r from-transparent via-emerald-500/20 to-transparent"></div>
        <div class="absolute bottom-1/3 left-0 w-full h-px bg-gradient-to-r from-transparent via-teal-500/20 to-transparent"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <!-- Header -->
        <div class="text-center mb-20">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-emerald-500/10 via-teal-500/10 to-emerald-500/10 border border-emerald-500/30 rounded-full mb-8 backdrop-blur-sm">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                <span class="text-sm font-bold text-emerald-700 dark:text-emerald-300 tracking-wide">{{ __('frontend.premium_transfer_service') ?? 'Premium Transfer Service' }}</span>
            </div>

            <h2 class="text-5xl md:text-6xl lg:text-7xl font-black text-slate-900 dark:text-white mb-6 leading-tight">
                <span class="bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-600 dark:from-emerald-400 dark:via-teal-400 dark:to-emerald-400 bg-clip-text text-transparent">
                    {{ __('frontend.why_transfer_to_pro_gineous') ?? 'Why transfer your domains to Pro Gineous' }}
                </span>
            </h2>
            <p class="text-lg md:text-xl text-slate-600 dark:text-slate-300 max-w-4xl mx-auto leading-relaxed font-medium">
                {{ __('frontend.why_transfer_to_pro_gineous_desc') ?? 'With decades of experience and a dedicated team, we continually improve our services, making it easy to manage - from a single .COM to a portfolio of thousands of domains. Our prices are among the lowest, and transfers are quick, so you can get started as soon as you\'re ready.' }}
            </p>
        </div>

        <!-- Features List with Icons -->
        <div class="max-w-6xl mx-auto space-y-6">
            <!-- Feature 1: Domain Management -->
            <div class="group relative bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl rounded-3xl p-8 md:p-10 border border-emerald-200/50 dark:border-emerald-900/50 hover:border-emerald-400/50 dark:hover:border-emerald-500/50 transition-all duration-500 hover:shadow-2xl hover:shadow-emerald-500/10">
                <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                    <!-- Icon -->
                    <div class="flex-shrink-0">
                        <div class="relative w-24 h-24">
                            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-3xl opacity-20 group-hover:opacity-30 blur-xl transition-opacity duration-500"></div>
                            <div class="relative w-full h-full bg-gradient-to-br from-emerald-500 to-teal-500 rounded-3xl flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="flex-1">
                        <h3 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white mb-3 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors duration-300">
                            {{ __('frontend.domain_management_title') ?? 'Domain Management' }}
                        </h3>
                        <p class="text-base md:text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
                            {{ __('frontend.domain_management_desc') ?? 'We provide extensive options to help you manage the process of registering, organizing, and setting up your domains.' }}
                        </p>
                    </div>
                    
                    <!-- Number Badge -->
                    <div class="hidden lg:flex items-center justify-center w-16 h-16 bg-gradient-to-br from-emerald-100 to-teal-100 dark:from-emerald-900/30 dark:to-teal-900/30 rounded-2xl border-2 border-emerald-300 dark:border-emerald-700">
                        <span class="text-3xl font-black bg-gradient-to-br from-emerald-600 to-teal-600 bg-clip-text text-transparent">01</span>
                    </div>
                </div>
            </div>

            <!-- Feature 2: Save More -->
            <div class="group relative bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl rounded-3xl p-8 md:p-10 border border-teal-200/50 dark:border-teal-900/50 hover:border-teal-400/50 dark:hover:border-teal-500/50 transition-all duration-500 hover:shadow-2xl hover:shadow-teal-500/10">
                <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                    <!-- Icon -->
                    <div class="flex-shrink-0">
                        <div class="relative w-24 h-24">
                            <div class="absolute inset-0 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-3xl opacity-20 group-hover:opacity-30 blur-xl transition-opacity duration-500"></div>
                            <div class="relative w-full h-full bg-gradient-to-br from-teal-500 to-cyan-500 rounded-3xl flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="flex-1">
                        <h3 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white mb-3 group-hover:text-teal-600 dark:group-hover:text-teal-400 transition-colors duration-300">
                            {{ __('frontend.save_more_title') ?? 'Save More' }}
                        </h3>
                        <p class="text-base md:text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
                            {{ __('frontend.save_more_desc') ?? 'Regular sales and promotions mean that we offer some of the lowest domain prices available.' }}
                        </p>
                    </div>
                    
                    <!-- Number Badge -->
                    <div class="hidden lg:flex items-center justify-center w-16 h-16 bg-gradient-to-br from-teal-100 to-cyan-100 dark:from-teal-900/30 dark:to-cyan-900/30 rounded-2xl border-2 border-teal-300 dark:border-teal-700">
                        <span class="text-3xl font-black bg-gradient-to-br from-teal-600 to-cyan-600 bg-clip-text text-transparent">02</span>
                    </div>
                </div>
            </div>

            <!-- Feature 3: Transparent Pricing -->
            <div class="group relative bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl rounded-3xl p-8 md:p-10 border border-emerald-200/50 dark:border-emerald-900/50 hover:border-emerald-400/50 dark:hover:border-emerald-500/50 transition-all duration-500 hover:shadow-2xl hover:shadow-emerald-500/10">
                <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                    <!-- Icon -->
                    <div class="flex-shrink-0">
                        <div class="relative w-24 h-24">
                            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500 to-green-500 rounded-3xl opacity-20 group-hover:opacity-30 blur-xl transition-opacity duration-500"></div>
                            <div class="relative w-full h-full bg-gradient-to-br from-emerald-500 to-green-500 rounded-3xl flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="flex-1">
                        <h3 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white mb-3 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors duration-300">
                            {{ __('frontend.transparent_pricing_title') ?? 'Transparent Pricing' }}
                        </h3>
                        <p class="text-base md:text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
                            {{ __('frontend.transparent_pricing_desc') ?? 'Beyond low prices across all of our available domains, we make sure that there are no hidden fees or upselling when purchasing on the Pro Gineous platform.' }}
                        </p>
                    </div>
                    
                    <!-- Number Badge -->
                    <div class="hidden lg:flex items-center justify-center w-16 h-16 bg-gradient-to-br from-emerald-100 to-green-100 dark:from-emerald-900/30 dark:to-green-900/30 rounded-2xl border-2 border-emerald-300 dark:border-emerald-700">
                        <span class="text-3xl font-black bg-gradient-to-br from-emerald-600 to-green-600 bg-clip-text text-transparent">03</span>
                    </div>
                </div>
            </div>

            <!-- Feature 4: Live Support -->
            <div class="group relative bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl rounded-3xl p-8 md:p-10 border border-teal-200/50 dark:border-teal-900/50 hover:border-teal-400/50 dark:hover:border-teal-500/50 transition-all duration-500 hover:shadow-2xl hover:shadow-teal-500/10">
                <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                    <!-- Icon -->
                    <div class="flex-shrink-0">
                        <div class="relative w-24 h-24">
                            <div class="absolute inset-0 bg-gradient-to-br from-teal-500 to-blue-500 rounded-3xl opacity-20 group-hover:opacity-30 blur-xl transition-opacity duration-500"></div>
                            <div class="relative w-full h-full bg-gradient-to-br from-teal-500 to-blue-500 rounded-3xl flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="flex-1">
                        <h3 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white mb-3 group-hover:text-teal-600 dark:group-hover:text-teal-400 transition-colors duration-300">
                            {{ __('frontend.live_support_title') ?? 'Live Support' }}
                        </h3>
                        <p class="text-base md:text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
                            {{ __('frontend.live_support_desc') ?? 'We take customer service and support seriously. Contact us whenever you have an issue or a question, and our team will find a solution.' }}
                        </p>
                    </div>
                    
                    <!-- Number Badge -->
                    <div class="hidden lg:flex items-center justify-center w-16 h-16 bg-gradient-to-br from-teal-100 to-blue-100 dark:from-teal-900/30 dark:to-blue-900/30 rounded-2xl border-2 border-teal-300 dark:border-teal-700">
                        <span class="text-3xl font-black bg-gradient-to-br from-teal-600 to-blue-600 bg-clip-text text-transparent">04</span>
                    </div>
                </div>
            </div>

            <!-- Feature 5: Domain Aftermarket -->
            <div class="group relative bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl rounded-3xl p-8 md:p-10 border border-emerald-200/50 dark:border-emerald-900/50 hover:border-emerald-400/50 dark:hover:border-emerald-500/50 transition-all duration-500 hover:shadow-2xl hover:shadow-emerald-500/10">
                <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                    <!-- Icon -->
                    <div class="flex-shrink-0">
                        <div class="relative w-24 h-24">
                            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-3xl opacity-20 group-hover:opacity-30 blur-xl transition-opacity duration-500"></div>
                            <div class="relative w-full h-full bg-gradient-to-br from-emerald-500 to-teal-500 rounded-3xl flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="flex-1">
                        <h3 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white mb-3 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors duration-300">
                            {{ __('frontend.domain_aftermarket_title') ?? 'Domain Aftermarket' }}
                        </h3>
                        <p class="text-base md:text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
                            {{ __('frontend.domain_aftermarket_desc') ?? 'Upgrade and grow your portfolio with valuable domain acquisitions.' }}
                        </p>
                    </div>
                    
                    <!-- Number Badge -->
                    <div class="hidden lg:flex items-center justify-center w-16 h-16 bg-gradient-to-br from-emerald-100 to-teal-100 dark:from-emerald-900/30 dark:to-teal-900/30 rounded-2xl border-2 border-emerald-300 dark:border-emerald-700">
                        <span class="text-3xl font-black bg-gradient-to-br from-emerald-600 to-teal-600 bg-clip-text text-transparent">05</span>
                    </div>
                </div>
            </div>

            <!-- Feature 6: Powerful Tools -->
            <div class="group relative bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl rounded-3xl p-8 md:p-10 border border-teal-200/50 dark:border-teal-900/50 hover:border-teal-400/50 dark:hover:border-teal-500/50 transition-all duration-500 hover:shadow-2xl hover:shadow-teal-500/10">
                <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                    <!-- Icon -->
                    <div class="flex-shrink-0">
                        <div class="relative w-24 h-24">
                            <div class="absolute inset-0 bg-gradient-to-br from-teal-500 to-emerald-500 rounded-3xl opacity-20 group-hover:opacity-30 blur-xl transition-opacity duration-500"></div>
                            <div class="relative w-full h-full bg-gradient-to-br from-teal-500 to-emerald-500 rounded-3xl flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="flex-1">
                        <h3 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white mb-3 group-hover:text-teal-600 dark:group-hover:text-teal-400 transition-colors duration-300">
                            {{ __('frontend.powerful_tools_title') ?? 'Powerful Tools' }}
                        </h3>
                        <p class="text-base md:text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
                            {{ __('frontend.powerful_tools_desc') ?? 'From our website builder to our app to our industry-recognized API, we\'re always growing and improving our suite of domain tools to meet your needs.' }}
                        </p>
                    </div>
                    
                    <!-- Number Badge -->
                    <div class="hidden lg:flex items-center justify-center w-16 h-16 bg-gradient-to-br from-teal-100 to-emerald-100 dark:from-teal-900/30 dark:to-emerald-900/30 rounded-2xl border-2 border-teal-300 dark:border-teal-700">
                        <span class="text-3xl font-black bg-gradient-to-br from-teal-600 to-emerald-600 bg-clip-text text-transparent">06</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Transfer Steps Section -->
<section class="py-20 bg-slate-50 dark:bg-slate-950" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-slate-900 dark:text-white mb-4">
                {{ __('frontend.transfer_steps_title') ?? 'خطوات نقل النطاق' }}
            </h2>
            <p class="text-xl text-slate-600 dark:text-slate-400 max-w-3xl mx-auto">
                {{ __('frontend.transfer_steps_desc') ?? 'عملية بسيطة من 4 خطوات فقط' }}
            </p>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="relative">
                <!-- Connection Line -->
                <div class="absolute top-0 bottom-0 {{ app()->getLocale() == 'ar' ? 'right-8 md:right-8' : 'left-8 md:left-8' }} w-0.5 bg-gradient-to-b from-emerald-500 to-teal-500 hidden md:block"></div>

                <div class="space-y-12">
                    <!-- Step 1 -->
                    <div class="relative flex items-start gap-4 md:gap-6">
                        <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-full flex items-center justify-center text-white text-2xl font-bold shadow-lg z-10">
                            1
                        </div>
                        <div class="flex-1 bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700">
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">
                                {{ __('frontend.transfer_step_1_title') ?? 'فك قفل النطاق' }}
                            </h3>
                            <p class="text-slate-600 dark:text-slate-400">
                                {{ __('frontend.transfer_step_1_desc') ?? 'قم بفك قفل النطاق من لوحة تحكم مزود الخدمة الحالي' }}
                            </p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative flex items-start gap-4 md:gap-6">
                        <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-full flex items-center justify-center text-white text-2xl font-bold shadow-lg z-10">
                            2
                        </div>
                        <div class="flex-1 bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700">
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">
                                {{ __('frontend.transfer_step_2_title') ?? 'احصل على رمز التحويل' }}
                            </h3>
                            <p class="text-slate-600 dark:text-slate-400">
                                {{ __('frontend.transfer_step_2_desc') ?? 'اطلب رمز التحويل (EPP/Auth Code) من مزود الخدمة الحالي' }}
                            </p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative flex items-start gap-4 md:gap-6">
                        <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-full flex items-center justify-center text-white text-2xl font-bold shadow-lg z-10">
                            3
                        </div>
                        <div class="flex-1 bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700">
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">
                                {{ __('frontend.transfer_step_3_title') ?? 'أدخل بيانات النقل' }}
                            </h3>
                            <p class="text-slate-600 dark:text-slate-400">
                                {{ __('frontend.transfer_step_3_desc') ?? 'أدخل اسم النطاق ورمز التحويل في النموذج أعلاه' }}
                            </p>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="relative flex items-start gap-4 md:gap-6">
                        <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-full flex items-center justify-center text-white text-2xl font-bold shadow-lg z-10">
                            4
                        </div>
                        <div class="flex-1 bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700">
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">
                                {{ __('frontend.transfer_step_4_title') ?? 'أكمل الدفع' }}
                            </h3>
                            <p class="text-slate-600 dark:text-slate-400">
                                {{ __('frontend.transfer_step_4_desc') ?? 'أكمل عملية الدفع وسنبدأ عملية النقل فوراً' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-20 bg-gradient-to-br from-slate-50 to-white dark:from-slate-950 dark:to-slate-900" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-slate-900 dark:text-white mb-4">
                {{ __('frontend.transfer_domain_faqs') ?? 'Transfer Domain FAQs' }}
            </h2>
        </div>

        <div class="max-w-5xl mx-auto space-y-8">
            <!-- Domain Transfer Reminders and Exceptions -->
            <div class="bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-950/20 dark:to-teal-950/20 rounded-3xl p-8 border border-emerald-200 dark:border-emerald-900/50">
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-3">
                    <svg class="w-7 h-7 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ __('frontend.domain_transfer_reminders') ?? 'Domain transfer reminders and exceptions*' }}
                </h3>
                
                <div class="space-y-6">
                    <!-- Must Not Be -->
                    <div class="bg-white/80 dark:bg-slate-800/80 rounded-2xl p-6 backdrop-blur-sm">
                        <p class="text-slate-700 dark:text-slate-300 leading-relaxed">
                            {{ __('frontend.domain_must_not_be') ?? 'The domain must not be: a recent registration or transfer (within 60 days), expired, or about to expire (we recommend initiating a transfer at least 2 weeks before a domain expires).' }}
                        </p>
                    </div>

                    <!-- Whois Email -->
                    <div class="bg-white/80 dark:bg-slate-800/80 rounded-2xl p-6 backdrop-blur-sm">
                        <p class="text-slate-700 dark:text-slate-300 leading-relaxed">
                            {{ __('frontend.ensure_whois_email') ?? 'Ensure your Whois email address is current as that is the address we will use to authorize the transfer.' }}
                        </p>
                    </div>

                    <!-- One Year Extension -->
                    <div class="bg-white/80 dark:bg-slate-800/80 rounded-2xl p-6 backdrop-blur-sm">
                        <p class="text-slate-700 dark:text-slate-300 leading-relaxed mb-4">
                            {{ __('frontend.one_year_extension_info') ?? 'Each domain transfer extends your domain registration by one year, with a few top-level domains being the exception. When you transfer a domain, 1 year is added to the expiration date in most cases except:' }}
                        </p>
                        
                        <ul class="space-y-3 text-slate-600 dark:text-slate-400">
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-teal-600 dark:text-teal-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ __('frontend.exception_1') ?? 'Your domain expired at your previous registrar, then you renewed it during the renewal grace period, and transferred it to us within 45 days of the renewal.' }}</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-teal-600 dark:text-teal-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ __('frontend.exception_2') ?? 'Adding a year to the domain will exceed the maximum registration period (usually 10 years, but it varies) for each domain.' }}</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-teal-600 dark:text-teal-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ __('frontend.exception_3') ?? 'When you are transferring a .IT, .BE, .EU, or .DE domain, one year is added to the transfer completion date, not the expiration date.' }}</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-teal-600 dark:text-teal-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ __('frontend.exception_4') ?? 'For .UK and .LT domains, you need to ask your current registrar to push the domain to us. There is no cost to do this and no time is added to the domain.' }}</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-teal-600 dark:text-teal-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ __('frontend.exception_5') ?? '.NL domains retain their pre-transfer expiration date and then are automatically renewed for you closer to their expiration date. This is because the .NL registry only allows for 1 year of registration.' }}</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-teal-600 dark:text-teal-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ __('frontend.exception_6') ?? '.AI domains include a 2-year renewal when transferred as they can only be registered or renewed in 2-year increments.' }}</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-teal-600 dark:text-teal-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ __('frontend.exception_7') ?? 'For .AT, .SO, .CH and .LV domains, domain transfers do not extend the domain registration period as they do not include a renewal upon transfer.' }}</span>
                            </li>
                        </ul>

                        <div class="mt-6 p-4 bg-amber-50 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-900/50 rounded-xl">
                            <p class="text-amber-900 dark:text-amber-200 text-sm font-medium">
                                {{ __('frontend.ngo_note') ?? 'Please note that we do not currently accept .NGO domain transfers.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQs Accordion -->
            <div class="space-y-4">
                <!-- FAQ 1: Why transfer -->
                <details class="group bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 overflow-hidden hover:border-emerald-300 dark:hover:border-emerald-700 transition-colors">
                    <summary class="flex items-center justify-between px-6 py-5 cursor-pointer">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white flex-1">
                            {{ __('frontend.faq_why_transfer_q') ?? 'Why should I transfer domains to Pro Gineous?' }}
                        </h3>
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 group-open:rotate-180 transition-transform flex-shrink-0 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </summary>
                    <div class="px-6 pb-5 text-slate-600 dark:text-slate-400 leading-relaxed">
                        {{ __('frontend.faq_why_transfer_a') ?? 'We make it easy to manage and grow your domain portfolio with low prices, a clean control panel, and a solid aftermarket. Plus, every transfer adds a year to your domain\'s registration, so it\'s smarter than renewing elsewhere.' }}
                    </div>
                </details>

                <!-- FAQ 2: How long -->
                <details class="group bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 overflow-hidden hover:border-emerald-300 dark:hover:border-emerald-700 transition-colors">
                    <summary class="flex items-center justify-between px-6 py-5 cursor-pointer">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white flex-1">
                            {{ __('frontend.faq_how_long_q') ?? 'How long does it take to complete a domain transfer?' }}
                        </h3>
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 group-open:rotate-180 transition-transform flex-shrink-0 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </summary>
                    <div class="px-6 pb-5 text-slate-600 dark:text-slate-400 leading-relaxed">
                        {{ __('frontend.faq_how_long_a') ?? 'Domain transfers can take anywhere from 5-15 days.' }}
                    </div>
                </details>

                <!-- FAQ 3: Website affected -->
                <details class="group bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 overflow-hidden hover:border-emerald-300 dark:hover:border-emerald-700 transition-colors">
                    <summary class="flex items-center justify-between px-6 py-5 cursor-pointer">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white flex-1">
                            {{ __('frontend.faq_website_affected_q') ?? 'Will my website/email be affected during the domain transfer?' }}
                        </h3>
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 group-open:rotate-180 transition-transform flex-shrink-0 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </summary>
                    <div class="px-6 pb-5 text-slate-600 dark:text-slate-400 leading-relaxed">
                        {{ __('frontend.faq_website_affected_a') ?? 'In most cases no. This is because the name servers for your domain are not changed during the domain transfer.' }}
                    </div>
                </details>

                <!-- FAQ 4: Lose domain -->
                <details class="group bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 overflow-hidden hover:border-emerald-300 dark:hover:border-emerald-700 transition-colors">
                    <summary class="flex items-center justify-between px-6 py-5 cursor-pointer">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white flex-1">
                            {{ __('frontend.faq_lose_domain_q') ?? 'Will I lose my domain if the domain transfer fails?' }}
                        </h3>
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 group-open:rotate-180 transition-transform flex-shrink-0 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </summary>
                    <div class="px-6 pb-5 text-slate-600 dark:text-slate-400 leading-relaxed">
                        {{ __('frontend.faq_lose_domain_a') ?? 'No, your domain will just remain at your original registrar.' }}
                    </div>
                </details>

                <!-- FAQ 5: Whois email -->
                <details class="group bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 overflow-hidden hover:border-emerald-300 dark:hover:border-emerald-700 transition-colors">
                    <summary class="flex items-center justify-between px-6 py-5 cursor-pointer">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white flex-1">
                            {{ __('frontend.faq_whois_email_q') ?? 'I can\'t get my previous registrar to update my Whois email address. Can I still transfer my domain?' }}
                        </h3>
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 group-open:rotate-180 transition-transform flex-shrink-0 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </summary>
                    <div class="px-6 pb-5 text-slate-600 dark:text-slate-400 leading-relaxed">
                        {{ __('frontend.faq_whois_email_a') ?? 'You must be able to receive mail at your Whois email address, so you can authorize the transfer. We cannot complete your transfer otherwise.' }}
                    </div>
                </details>

                <!-- FAQ 6: Auth code -->
                <details class="group bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 overflow-hidden hover:border-emerald-300 dark:hover:border-emerald-700 transition-colors">
                    <summary class="flex items-center justify-between px-6 py-5 cursor-pointer">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white flex-1">
                            {{ __('frontend.faq_auth_code_q') ?? 'I can\'t get my domain transfer authorization code from my previous registrar. Can you still transfer my domain?' }}
                        </h3>
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 group-open:rotate-180 transition-transform flex-shrink-0 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </summary>
                    <div class="px-6 pb-5 text-slate-600 dark:text-slate-400 leading-relaxed">
                        {{ __('frontend.faq_auth_code_a') ?? 'Sorry, we cannot transfer a domain without a valid auth code.' }}
                    </div>
                </details>

                <!-- FAQ 7: Expired domain -->
                <details class="group bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 overflow-hidden hover:border-emerald-300 dark:hover:border-emerald-700 transition-colors">
                    <summary class="flex items-center justify-between px-6 py-5 cursor-pointer">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white flex-1">
                            {{ __('frontend.faq_expired_q') ?? 'Can I transfer my domain if it is expired?' }}
                        </h3>
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 group-open:rotate-180 transition-transform flex-shrink-0 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </summary>
                    <div class="px-6 pb-5 text-slate-600 dark:text-slate-400 leading-relaxed">
                        {{ __('frontend.faq_expired_a') ?? 'You are welcome to try, but chances are it will not work. Most registrars require you to renew before you can transfer a domain away.' }}
                    </div>
                </details>

                <!-- FAQ 8: Refund -->
                <details class="group bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 overflow-hidden hover:border-emerald-300 dark:hover:border-emerald-700 transition-colors">
                    <summary class="flex items-center justify-between px-6 py-5 cursor-pointer">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white flex-1">
                            {{ __('frontend.faq_refund_q') ?? 'Do I get my money back if the domain transfer fails?' }}
                        </h3>
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 group-open:rotate-180 transition-transform flex-shrink-0 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </summary>
                    <div class="px-6 pb-5 text-slate-600 dark:text-slate-400 leading-relaxed">
                        {{ __('frontend.faq_refund_a') ?? 'Your account will be credited the full domain transfer fee. The credit can be used for any future purchases. Sorry, we cannot issue a cash refund.' }}
                    </div>
                </details>

                <!-- FAQ 9: Between accounts -->
                <details class="group bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 overflow-hidden hover:border-emerald-300 dark:hover:border-emerald-700 transition-colors">
                    <summary class="flex items-center justify-between px-6 py-5 cursor-pointer">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white flex-1">
                            {{ __('frontend.faq_between_accounts_q') ?? 'How do I move a domain between two Pro Gineous accounts?' }}
                        </h3>
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 group-open:rotate-180 transition-transform flex-shrink-0 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </summary>
                    <div class="px-6 pb-5 text-slate-600 dark:text-slate-400 leading-relaxed">
                        {{ __('frontend.faq_between_accounts_a') ?? 'This is actually a change owner request and not a domain transfer. A change ownership request is free and can be started by the domain owner on our control panel change owner page.' }}
                    </div>
                </details>

                <!-- FAQ 10: UK domain -->
                <details class="group bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 overflow-hidden hover:border-emerald-300 dark:hover:border-emerald-700 transition-colors">
                    <summary class="flex items-center justify-between px-6 py-5 cursor-pointer">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white flex-1">
                            {{ __('frontend.faq_uk_domain_q') ?? 'How do I transfer in a .UK domain?' }}
                        </h3>
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 group-open:rotate-180 transition-transform flex-shrink-0 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </summary>
                    <div class="px-6 pb-5 text-slate-600 dark:text-slate-400 leading-relaxed">
                        {{ __('frontend.faq_uk_domain_a') ?? 'Transferring a .UK domain is different than most domain transfers. To transfer your .UK domain to Pro Gineous follow the steps here.' }}
                    </div>
                </details>
            </div>
        </div>
    </div>
</section>

<!-- Domain Transfer Support Section -->
<section class="py-12 bg-gradient-to-br from-emerald-500 via-teal-500 to-emerald-600 dark:from-emerald-900 dark:via-teal-900 dark:to-emerald-950 relative overflow-hidden" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <!-- Decorative Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <!-- Animated Circles -->
        <div class="absolute top-1/4 left-1/4 w-48 h-48 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-1/4 right-1/4 w-64 h-64 bg-teal-300/10 rounded-full blur-3xl animate-pulse animation-delay-2000"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <!-- Icon -->
            <div class="inline-flex items-center justify-center w-14 h-14 bg-white/20 backdrop-blur-xl rounded-2xl mb-4 shadow-2xl">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>

            <!-- Title -->
            <h2 class="text-3xl md:text-4xl font-black text-white mb-3 leading-tight">
                {{ __('frontend.get_domain_transfer_support') ?? 'Get Domain Transfer Support' }}
            </h2>

            <!-- Description -->
            <p class="text-base md:text-lg text-emerald-50 mb-8 leading-relaxed font-medium">
                {{ __('frontend.transfer_support_desc') ?? 'Have questions about transferring your domains? Contact us - our team is here to help.' }}
            </p>

            <!-- Support Options -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-2xl mx-auto">
                <!-- Email Support -->
                <a href="mailto:support@progineous.com" class="group relative bg-white/10 hover:bg-white/20 backdrop-blur-xl rounded-2xl p-6 border-2 border-white/20 hover:border-white/40 transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                    <!-- Glow Effect -->
                    <div class="absolute inset-0 bg-gradient-to-br from-white/0 to-white/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    
                    <div class="relative z-10">
                        <!-- Icon -->
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-4 mx-auto group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        
                        <!-- Title -->
                        <h3 class="text-xl font-bold text-white mb-1">
                            {{ __('frontend.email_support') ?? 'Email' }}
                        </h3>
                        
                        <!-- Description -->
                        <p class="text-emerald-50 text-sm">
                            {{ __('frontend.email_support_desc') ?? 'Get detailed assistance via email' }}
                        </p>
                        
                        <!-- Arrow -->
                        <div class="mt-3 flex items-center justify-center gap-2 text-white opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                            <span class="text-sm font-semibold">{{ __('frontend.send_email') ?? 'Send Email' }}</span>
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Chat Support -->
                <button onclick="Intercom('show')" class="group relative bg-white/10 hover:bg-white/20 backdrop-blur-xl rounded-2xl p-6 border-2 border-white/20 hover:border-white/40 transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                    <!-- Glow Effect -->
                    <div class="absolute inset-0 bg-gradient-to-br from-white/0 to-white/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    
                    <div class="relative z-10">
                        <!-- Icon with Pulse -->
                        <div class="relative w-12 h-12 mx-auto mb-4">
                            <div class="absolute inset-0 bg-white/30 rounded-xl animate-ping"></div>
                            <div class="relative w-full h-full bg-white/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Title -->
                        <h3 class="text-xl font-bold text-white mb-1">
                            {{ __('frontend.chat_support') ?? 'Chat' }}
                        </h3>
                        
                        <!-- Description -->
                        <p class="text-emerald-50 text-sm">
                            {{ __('frontend.chat_support_desc') ?? 'Chat with us in real-time' }}
                        </p>
                        
                        <!-- Arrow -->
                        <div class="mt-3 flex items-center justify-center gap-2 text-white opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                            <span class="text-sm font-semibold">{{ __('frontend.start_chat') ?? 'Start Chat' }}</span>
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </div>
                    </div>
                </button>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const transferForm = document.getElementById('domainTransferForm');
    const transferButton = document.getElementById('transferButton');
    const transferText = document.getElementById('transferText');
    const transferIcon = document.getElementById('transferIcon');
    const transferLoadingIcon = document.getElementById('transferLoadingIcon');
    const transferResults = document.getElementById('transferResults');
    const transferDomainInput = document.getElementById('transferDomainInput');
    const authCodeInput = document.getElementById('authCodeInput');

    const isRTL = '{{ app()->getLocale() }}' === 'ar';

    // TLD Search Functionality
    const searchInput = document.getElementById('tldSearchInput');
    const pricingGrid = document.getElementById('tldPricingGrid');
    const noResultsMessage = document.getElementById('noResultsMessage');
    const resultsCounter = document.getElementById('resultsCounter');
    const totalResults = document.getElementById('totalResults');
    
    // Show More/Less Functionality
    const showMoreBtn = document.getElementById('showMoreBtn');
    const showMoreText = document.getElementById('showMoreText');
    const showMoreCount = document.getElementById('showMoreCount');
    const showMoreIcon = document.getElementById('showMoreIcon');
    const showLessIcon = document.getElementById('showLessIcon');
    const showMoreContainer = document.getElementById('showMoreContainer');
    
    let isExpanded = false;

    if (showMoreBtn) {
        showMoreBtn.addEventListener('click', function() {
            const hiddenCards = pricingGrid.querySelectorAll('.hidden-card');
            
            if (!isExpanded) {
                // Show all cards
                hiddenCards.forEach(card => {
                    card.style.display = '';
                });
                
                // Update button text and icon
                showMoreText.textContent = isRTL ? 'عرض أقل' : 'Show Less';
                showMoreCount.classList.add('hidden');
                showMoreIcon.classList.add('hidden');
                showLessIcon.classList.remove('hidden');
                isExpanded = true;
                
                // Smooth scroll to show newly revealed content
                setTimeout(() => {
                    const firstHiddenCard = hiddenCards[0];
                    if (firstHiddenCard) {
                        firstHiddenCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    }
                }, 100);
            } else {
                // Hide extra cards
                hiddenCards.forEach(card => {
                    card.style.display = 'none';
                });
                
                // Update button text and icon
                showMoreText.textContent = isRTL ? 'عرض المزيد من الامتدادات' : 'Show More Extensions';
                showMoreCount.classList.remove('hidden');
                showMoreIcon.classList.remove('hidden');
                showLessIcon.classList.add('hidden');
                isExpanded = false;
                
                // Scroll back to pricing section
                setTimeout(() => {
                    pricingGrid.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 100);
            }
        });
    }

    if (searchInput && pricingGrid) {
        const allCards = Array.from(pricingGrid.querySelectorAll('.tld-card'));
        const totalCount = allCards.length;
        
        if (totalResults) {
            totalResults.textContent = totalCount;
        }

        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            let visibleCount = 0;
            
            // Hide show more button during search
            if (showMoreContainer) {
                showMoreContainer.style.display = searchTerm ? 'none' : '';
            }

            allCards.forEach((card, index) => {
                const tld = card.dataset.tld.toLowerCase();
                const tldName = card.dataset.tldName.toLowerCase();
                
                if (searchTerm === '') {
                    // When search is cleared, restore initial state
                    // Show only first 12 cards if not expanded
                    if (!isExpanded && index >= 12) {
                        card.style.display = 'none';
                    } else {
                        card.style.display = '';
                    }
                    visibleCount++;
                } else {
                    // During search, show all matching cards
                    if (tld.includes(searchTerm) || tldName.includes(searchTerm)) {
                        card.style.display = '';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                }
            });

            // Update counter
            if (resultsCounter) {
                resultsCounter.textContent = isRTL 
                    ? `عرض ${visibleCount} من ${totalCount}` 
                    : `Showing ${visibleCount} of ${totalCount}`;
            }

            // Show/hide no results message
            if (noResultsMessage) {
                if (visibleCount === 0) {
                    pricingGrid.style.display = 'none';
                    noResultsMessage.classList.remove('hidden');
                } else {
                    pricingGrid.style.display = 'grid';
                    noResultsMessage.classList.add('hidden');
                }
            }
        });
    }

    // Transfer Form Validation
    transferForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        const domain = transferDomainInput.value.trim();
        const authCode = authCodeInput.value.trim();

        if (!domain || !authCode) {
            Swal.fire({
                icon: 'error',
                title: isRTL ? 'خطأ' : 'Error',
                text: isRTL ? 'الرجاء إدخال اسم النطاق ورمز التحويل' : 'Please enter domain name and auth code',
            });
            return;
        }

        // Disable button and show loading
        transferButton.disabled = true;
        transferIcon.classList.add('hidden');
        transferLoadingIcon.classList.remove('hidden');
        transferText.textContent = isRTL ? 'جاري التحقق...' : 'Checking...';
        transferResults.innerHTML = '';
        transferResults.classList.add('hidden');

        try {
            const response = await fetch('{{ route('domains.transfer.validate') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    domain: domain,
                    auth_code: authCode
                })
            });

            const result = await response.json();
            
            // Log for debugging
            console.log('Transfer validation response:', result);

            // Check if response is successful and domain is eligible
            if (result.success && result.data && result.data.eligible) {
                const data = result.data;
                const pricing = result.pricing || {};
                
                // Format price display
                let priceDisplay = '';
                if (pricing.transfer) {
                    priceDisplay = `
                        <div class="mt-4 pt-4 border-t border-emerald-200 dark:border-emerald-800">
                            <div class="flex items-center justify-between">
                                <span class="text-emerald-800 dark:text-emerald-200 font-medium">
                                    ${isRTL ? 'سعر النقل:' : 'Transfer Price:'}
                                </span>
                                <span class="text-2xl font-bold text-emerald-900 dark:text-emerald-100">
                                    ${pricing.currency} ${parseFloat(pricing.transfer).toFixed(2)}
                                </span>
                            </div>
                            <p class="text-sm text-emerald-600 dark:text-emerald-400 mt-2">
                                ${isRTL ? '+ سنة إضافية مجاناً عند النقل' : '+ Free 1-year extension with transfer'}
                            </p>
                        </div>
                    `;
                }
                
                // Show success message
                transferResults.innerHTML = `
                    <div class="bg-emerald-50 dark:bg-emerald-900/20 border-2 border-emerald-500 rounded-xl p-6">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-emerald-600 dark:text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-emerald-900 dark:text-emerald-100 mb-2">
                                    ${data.message || (isRTL ? 'النطاق جاهز للنقل!' : 'Domain is ready for transfer!')}
                                </h3>
                                <p class="text-emerald-700 dark:text-emerald-300 mb-2">
                                    ${isRTL ? 'النطاق جاهز للنقل! يمكنك المتابعة للدفع.' : 'Domain is ready for transfer! You can proceed to payment.'}
                                </p>
                                ${priceDisplay}
                                <button onclick="addTransferToCart('${domain}', ${pricing.transfer || 0}, '${pricing.tld || 'com'}', ${pricing.transfer || 0}, '${authCode}')" class="mt-4 inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    ${isRTL ? 'المتابعة للدفع' : 'Proceed to Payment'}
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            } else {
                // Show error message
                const data = result.data || {};
                let errorMessage = data.message || result.message || (isRTL ? 'حدث خطأ أثناء التحقق من النطاق' : 'Error checking domain');
                
                transferResults.innerHTML = `
                    <div class="bg-red-50 dark:bg-red-900/20 border-2 border-red-500 rounded-xl p-6">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-red-900 dark:text-red-100 mb-2">
                                    ${isRTL ? 'لا يمكن نقل النطاق' : 'Transfer Not Available'}
                                </h3>
                                <p class="text-red-700 dark:text-red-300">
                                    ${errorMessage}
                                </p>
                            </div>
                        </div>
                    </div>
                `;
            }

            transferResults.classList.remove('hidden');

        } catch (error) {
            console.error('Transfer validation error:', error);
            Swal.fire({
                icon: 'error',
                title: isRTL ? 'خطأ' : 'Error',
                text: isRTL ? 'حدث خطأ أثناء التحقق من النطاق' : 'An error occurred while checking the domain',
            });
        } finally {
            // Re-enable button
            transferButton.disabled = false;
            transferIcon.classList.remove('hidden');
            transferLoadingIcon.classList.add('hidden');
            transferText.textContent = '{{ __('frontend.start_transfer') }}';
        }
    });
});

// Add Transfer to Cart Function
function addTransferToCart(domain, price, tld, renewalPrice = null, authCode = null) {
    const isRTL = document.documentElement.dir === 'rtl';
    const button = event.target.closest('button');
    const originalHTML = button.innerHTML;
    
    // Show loading state
    button.disabled = true;
    button.innerHTML = `
        <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        ${isRTL ? 'جاري الإضافة...' : 'Adding...'}
    `;
    
    fetch('{{ route('cart.add-domain') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            domain: domain,
            price: price,
            type: 'transfer',
            tld: tld,
            renewal_price: renewalPrice || price,
            auth_code: authCode
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Success - update cart count and redirect
            updateCartCount(data.cartCount);
            
            Swal.fire({
                icon: 'success',
                title: isRTL ? 'تمت الإضافة!' : 'Added!',
                text: isRTL ? 'تمت إضافة النطاق للسلة' : 'Domain added to cart',
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                window.location.href = '{{ route('cart.index') }}';
            });
        } else {
            // Error
            button.disabled = false;
            button.innerHTML = originalHTML;
            Swal.fire({
                icon: 'error',
                title: isRTL ? 'خطأ' : 'Error',
                text: data.message || (isRTL ? 'حدث خطأ أثناء الإضافة للسلة' : 'Error adding to cart')
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        button.disabled = false;
        button.innerHTML = originalHTML;
        Swal.fire({
            icon: 'error',
            title: isRTL ? 'خطأ' : 'Error',
            text: isRTL ? 'حدث خطأ أثناء الإضافة للسلة' : 'Error adding to cart'
        });
    });
}

// Update Cart Count in Header
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
</script>
@endpush
