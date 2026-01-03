@extends('frontend.layout')

@section('title', $vpsPlan->plan_name . ' - ' . __('frontend.configure_vps') . ' - ' . config('app.name'))

@section('content')
<section class="relative py-8 md:py-12 lg:py-20 bg-gradient-to-br from-slate-50 via-blue-50/30 to-cyan-50/20 min-h-screen">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} w-96 h-96 bg-gradient-to-br from-blue-400/10 to-cyan-400/5 rounded-full blur-3xl animate-float"></div>
        <div class="absolute -bottom-40 {{ app()->getLocale() == 'ar' ? 'right-0' : 'left-0' }} w-96 h-96 bg-gradient-to-tr from-cyan-400/10 to-blue-400/5 rounded-full blur-3xl animate-float animation-delay-2000"></div>
    </div>

    <div class="container mx-auto px-3 sm:px-4 md:px-6 lg:px-4 relative z-10">
        <div class="max-w-6xl mx-auto">
            <!-- Page Header -->
            <div class="text-center mb-6 md:mb-8 lg:mb-12">
                <div class="inline-flex items-center gap-2 px-3 sm:px-4 md:px-5 py-1.5 sm:py-2 bg-gradient-to-r from-blue-500/10 to-cyan-500/10 backdrop-blur-sm rounded-full mb-4 md:mb-6 border border-blue-200/50">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                    </svg>
                    <span class="text-xs sm:text-sm font-bold text-blue-900">
                        {{ __('frontend.configure_vps') }}
                    </span>
                </div>
                <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-black text-slate-900 mb-3 md:mb-4 px-2">
                    {{ $vpsPlan->plan_name }}
                </h1>
                @if($vpsPlan->plan_tagline)
                    <p class="text-base sm:text-lg md:text-xl text-slate-600 max-w-2xl mx-auto px-4">
                        {{ $vpsPlan->plan_tagline }}
                    </p>
                @endif
            </div>

            <div class="grid lg:grid-cols-3 gap-4 md:gap-6 lg:gap-8">
                <!-- Configuration Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white/90 backdrop-blur-sm rounded-xl md:rounded-2xl shadow-xl p-4 sm:p-6 md:p-8 border border-slate-200/50">
                        <form id="configure-form" action="{{ route('cart.add-vps') }}" method="POST">
                            @csrf
                            <input type="hidden" name="vps_plan_id" value="{{ $vpsPlan->id }}">
                            <input type="hidden" name="billing_cycle" id="billing-cycle-input" value="monthly">

                            <!-- Billing Cycle -->
                            <div class="mb-6 md:mb-8">
                                <label class="block text-base sm:text-lg font-bold text-slate-900 mb-3 md:mb-4">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 inline-block {{ app()->getLocale() == 'ar' ? 'ml-1 sm:ml-2' : 'mr-1 sm:mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ __('frontend.billing_cycle') }}
                                </label>
                                
                                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-2 sm:gap-3 md:gap-4">
                                    <label class="relative">
                                        <input type="radio" name="billing_cycle_display" value="monthly" class="peer sr-only" checked onchange="updatePrice()">
                                        <div class="p-3 sm:p-4 bg-slate-50 rounded-lg md:rounded-xl border-2 border-slate-200 cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all hover:border-blue-400 min-h-[100px] sm:min-h-[120px] md:min-h-[140px] flex items-center justify-center">
                                            <div class="text-center">
                                                <div class="text-sm sm:text-base font-bold text-slate-900 mb-1">{{ __('frontend.monthly') }}</div>
                                                <div class="text-lg sm:text-xl md:text-2xl font-black text-blue-600">${{ number_format($vpsPlan->monthly_price, 2) }}</div>
                                                <div class="text-xs text-slate-600">/{{ __('frontend.month') }}</div>
                                                <div class="h-4 sm:h-5 mt-1"></div>
                                            </div>
                                        </div>
                                    </label>

                                    @if($vpsPlan->quarterly_price)
                                    <label class="relative">
                                        <input type="radio" name="billing_cycle_display" value="quarterly" class="peer sr-only" onchange="updatePrice()">
                                        <div class="p-3 sm:p-4 bg-slate-50 rounded-lg md:rounded-xl border-2 border-slate-200 cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all hover:border-blue-400 min-h-[100px] sm:min-h-[120px] md:min-h-[140px] flex items-center justify-center">
                                            <div class="text-center">
                                                <div class="text-sm sm:text-base font-bold text-slate-900 mb-1">{{ __('frontend.quarterly') }}</div>
                                                <div class="text-lg sm:text-xl md:text-2xl font-black text-blue-600">${{ number_format($vpsPlan->quarterly_price, 2) }}</div>
                                                <div class="text-xs text-slate-600">/{{ __('frontend.3_months') }}</div>
                                                <span class="inline-block px-1.5 sm:px-2 py-0.5 bg-green-100 text-green-700 text-xs font-bold rounded-full mt-1">-5%</span>
                                            </div>
                                        </div>
                                    </label>
                                    @endif

                                    @if($vpsPlan->semi_annually_price)
                                    <label class="relative">
                                        <input type="radio" name="billing_cycle_display" value="semi_annually" class="peer sr-only" onchange="updatePrice()">
                                        <div class="p-3 sm:p-4 bg-slate-50 rounded-lg md:rounded-xl border-2 border-slate-200 cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all hover:border-blue-400 min-h-[100px] sm:min-h-[120px] md:min-h-[140px] flex items-center justify-center">
                                            <div class="text-center">
                                                <div class="text-sm sm:text-base font-bold text-slate-900 mb-1">{{ __('frontend.semi_annually') }}</div>
                                                <div class="text-lg sm:text-xl md:text-2xl font-black text-blue-600">${{ number_format($vpsPlan->semi_annually_price, 2) }}</div>
                                                <div class="text-xs text-slate-600">/{{ __('frontend.6_months') }}</div>
                                                <span class="inline-block px-1.5 sm:px-2 py-0.5 bg-green-100 text-green-700 text-xs font-bold rounded-full mt-1">-10%</span>
                                            </div>
                                        </div>
                                    </label>
                                    @endif

                                    @if($vpsPlan->annually_price)
                                    <label class="relative">
                                        <input type="radio" name="billing_cycle_display" value="annually" class="peer sr-only" onchange="updatePrice()">
                                        <div class="p-3 sm:p-4 bg-slate-50 rounded-lg md:rounded-xl border-2 border-slate-200 cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all hover:border-blue-400 min-h-[100px] sm:min-h-[120px] md:min-h-[140px] flex items-center justify-center">
                                            <div class="text-center">
                                                <div class="text-sm sm:text-base font-bold text-slate-900 mb-1">{{ __('frontend.annually') }}</div>
                                                <div class="text-lg sm:text-xl md:text-2xl font-black text-blue-600">${{ number_format($vpsPlan->annually_price, 2) }}</div>
                                                <div class="text-xs text-slate-600">/{{ __('frontend.year') }}</div>
                                                <span class="inline-block px-1.5 sm:px-2 py-0.5 bg-green-100 text-green-700 text-xs font-bold rounded-full mt-1">-15%</span>
                                            </div>
                                        </div>
                                    </label>
                                    @endif
                                </div>
                            </div>

                            <!-- Operating System -->
                            @if(!empty($operatingSystems) && count($operatingSystems) > 0)
                            <div class="mb-6 md:mb-8">
                                <label class="flex items-center gap-2 text-base sm:text-lg font-bold text-slate-900 mb-3 md:mb-4">
                                    <span class="inline-flex items-center justify-center w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-gradient-to-br from-blue-100 to-cyan-100 shadow-sm flex-shrink-0">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </span>
                                    <span class="truncate">{{ __('frontend.operating_system') }}</span>
                                    <span class="{{ app()->getLocale() == 'ar' ? 'mr-auto' : 'ml-auto' }} px-2 py-0.5 sm:py-1 bg-red-100 text-red-600 text-xs font-bold rounded-full whitespace-nowrap flex-shrink-0">{{ __('frontend.required') }}</span>
                                </label>
                                
                                <div class="mb-3 p-2.5 sm:p-3 bg-amber-50 border border-amber-200 rounded-lg">
                                    <p class="text-xs sm:text-sm text-amber-800 flex items-start gap-2">
                                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                        <span>{{ __('frontend.choose_os_or_app_not_both') }}</span>
                                    </p>
                                </div>
                                
                                @if(!empty($vpsPlan->os_options) && is_array($vpsPlan->os_options))
                                <div class="mb-3 p-2.5 sm:p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                    <p class="text-xs sm:text-sm text-blue-800 flex items-start gap-2">
                                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>{{ __('frontend.plan_specific_os_available') }}</span>
                                    </p>
                                </div>
                                @endif
                                
                                <div class="relative">
                                    <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'right-0 pr-4' : 'left-0 pl-4' }} flex items-center pointer-events-none z-10">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <select name="os_id" id="os-select" class="w-full {{ app()->getLocale() == 'ar' ? 'pr-12 pl-10' : 'pl-12 pr-10' }} py-4 bg-white border-2 border-slate-300 rounded-xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 text-slate-900 font-medium text-base hover:border-blue-400 transition-all duration-200 cursor-pointer appearance-none bg-gradient-to-r from-white to-slate-50 shadow-sm hover:shadow-md" required>
                                        <option value="">{{ __('frontend.select_os') }}</option>
                                        @foreach($operatingSystems as $os)
                                            <option value="{{ $os['id'] }}">{{ $os['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-0 pl-4' : 'right-0 pr-4' }} flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Marketplace Applications -->
                            @if(!empty($marketplaceApps) && count($marketplaceApps) > 0)
                            <div class="mb-6 md:mb-8">
                                <label class="flex items-center gap-2 text-base sm:text-lg font-bold text-slate-900 mb-3 md:mb-4">
                                    <span class="inline-flex items-center justify-center w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-gradient-to-br from-purple-100 to-pink-100 shadow-sm flex-shrink-0">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </span>
                                    <span class="truncate">{{ __('frontend.marketplace_apps') }}</span>
                                    <span class="px-2 py-0.5 sm:py-1 bg-slate-100 text-slate-600 text-xs font-medium rounded-full whitespace-nowrap flex-shrink-0">({{ __('frontend.optional') }})</span>
                                </label>
                                
                                <div class="mb-3 p-2.5 sm:p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                    <p class="text-xs sm:text-sm text-blue-800 flex items-start gap-2">
                                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>{{ __('frontend.apps_filtered_by_plan_specs') }}</span>
                                    </p>
                                </div>
                                
                                <div class="relative">
                                    <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'right-0 pr-4' : 'left-0 pl-4' }} flex items-center pointer-events-none z-10">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <select name="app_id" id="app-select" class="w-full {{ app()->getLocale() == 'ar' ? 'pr-12 pl-10' : 'pl-12 pr-10' }} py-4 bg-white border-2 border-slate-300 rounded-xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 text-slate-900 font-medium text-base hover:border-blue-400 transition-all duration-200 cursor-pointer appearance-none bg-gradient-to-r from-white to-slate-50 shadow-sm hover:shadow-md">
                                        <option value="">{{ __('frontend.none_preinstalled_os_only') }}</option>
                                        @foreach($marketplaceApps as $app)
                                            <option value="{{ $app['id'] }}">{{ $app['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-0 pl-4' : 'right-0 pr-4' }} flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                <p class="mt-3 text-sm text-slate-600 flex items-start gap-2">
                                    <svg class="w-4 h-4 text-slate-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ __('frontend.marketplace_apps_description') }}</span>
                                </p>
                            </div>
                            @endif

                            <!-- Datacenter -->
                            @if(!empty($datacenters) && count($datacenters) > 0)
                            <div class="mb-6 md:mb-8">
                                <label class="flex items-center gap-2 text-base sm:text-lg font-bold text-slate-900 mb-3 md:mb-4">
                                    <span class="inline-flex items-center justify-center w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-gradient-to-br from-green-100 to-emerald-100 shadow-sm flex-shrink-0">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </span>
                                    <span class="truncate">{{ __('frontend.datacenter_location') }}</span>
                                    <span class="{{ app()->getLocale() == 'ar' ? 'mr-auto' : 'ml-auto' }} px-2 py-0.5 sm:py-1 bg-red-100 text-red-600 text-xs font-bold rounded-full whitespace-nowrap flex-shrink-0">{{ __('frontend.required') }}</span>
                                </label>
                                
                                <div class="relative">
                                    <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'right-0 pr-4' : 'left-0 pl-4' }} flex items-center pointer-events-none z-10">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <select name="datacenter" id="datacenter-select" class="w-full {{ app()->getLocale() == 'ar' ? 'pr-12 pl-10' : 'pl-12 pr-10' }} py-4 bg-white border-2 border-slate-300 rounded-xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 text-slate-900 font-medium text-base hover:border-blue-400 transition-all duration-200 cursor-pointer appearance-none bg-gradient-to-r from-white to-slate-50 shadow-sm hover:shadow-md" required>
                                        <option value="">{{ __('frontend.select_datacenter') }}</option>
                                        @foreach($datacenters as $dc)
                                            <option value="{{ $dc['id'] }}" {{ $vpsPlan->vultr_region == $dc['id'] ? 'selected' : '' }}>
                                                {{ $dc['city'] }}, {{ $dc['country'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-0 pl-4' : 'right-0 pr-4' }} flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Hostname -->
                            <div class="mb-6 md:mb-8">
                                <label class="block text-base sm:text-lg font-bold text-slate-900 mb-3 md:mb-4">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 inline-block {{ app()->getLocale() == 'ar' ? 'ml-1 sm:ml-2' : 'mr-1 sm:mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                    </svg>
                                    <span class="inline">{{ __('frontend.hostname') }}</span> <span class="text-sm font-normal text-slate-600">({{ __('frontend.subdomain') }})</span>
                                </label>
                                <input type="text" name="hostname" id="hostname" class="w-full px-3 sm:px-4 py-3 bg-white border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-slate-900 text-sm sm:text-base" placeholder="server.example.com" pattern="[a-zA-Z0-9.-]+" required>
                                <p class="mt-2 text-xs sm:text-sm text-slate-600">{{ __('frontend.hostname_must_be_subdomain') }}</p>
                                <div id="hostname-error" class="hidden mt-2 p-3 bg-red-50 border border-red-200 rounded-lg">
                                    <div class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-red-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <p class="text-sm text-red-800 font-medium" id="hostname-error-message">{{ __('frontend.hostname_must_contain_subdomain') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Automatic Backups -->
                            <div class="mb-6 md:mb-8">
                                <div class="flex flex-col sm:flex-row items-start justify-between p-3 sm:p-4 md:p-5 bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-lg md:rounded-xl hover:shadow-lg transition-all duration-200 gap-3">
                                    <div class="flex-1 w-full">
                                        <label for="enable_backups" class="flex items-start cursor-pointer">
                                            <div class="{{ app()->getLocale() == 'ar' ? 'ml-2 sm:ml-3 md:ml-4' : 'mr-2 sm:mr-3 md:mr-4' }} flex-shrink-0">
                                                <svg class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="text-base sm:text-lg font-bold text-slate-900 mb-1">
                                                    {{ __('frontend.automatic_backups') }}
                                                </div>
                                                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                                    {{ __('frontend.automatic_backups_description') }}
                                                </p>
                                                <div class="mt-2 flex flex-wrap items-center gap-2 text-xs sm:text-sm">
                                                    <span class="px-2 py-0.5 sm:py-1 bg-blue-100 text-blue-700 rounded-md font-semibold whitespace-nowrap">
                                                        +20% {{ __('frontend.of_plan_price') }}
                                                    </span>
                                                    <span class="text-slate-500 hidden sm:inline">•</span>
                                                    <span class="text-slate-600">{{ __('frontend.daily_snapshots') }}</span>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'mr-0 sm:mr-2 md:mr-4' : 'ml-0 sm:ml-2 md:ml-4' }} w-full sm:w-auto justify-end">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="enable_backups" id="enable_backups" class="sr-only peer" value="1">
                                            <div class="w-12 h-6 sm:w-14 sm:h-7 bg-slate-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[4px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 sm:after:h-6 sm:after:w-6 after:transition-all peer-checked:bg-blue-600"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Public IPv4 (Required) -->
                            <div class="mb-6 md:mb-8">
                                <div class="p-3 sm:p-4 md:p-5 bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 rounded-lg md:rounded-xl">
                                    <div class="flex items-start gap-2 sm:gap-3 md:gap-4">
                                        <div class="{{ app()->getLocale() == 'ar' ? 'ml-2 sm:ml-3 md:ml-4' : 'mr-2 sm:mr-3 md:mr-4' }} flex-shrink-0">
                                            <svg class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                                <div class="text-base sm:text-lg font-bold text-slate-900">
                                                    {{ __('frontend.public_ipv4') }}
                                                </div>
                                                <span class="px-2 py-0.5 bg-green-600 text-white text-xs font-bold rounded-full whitespace-nowrap">
                                                    {{ __('frontend.required') }}
                                                </span>
                                            </div>
                                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-2">
                                                {{ __('frontend.public_ipv4_required_description') }}
                                            </p>
                                            <div class="flex flex-wrap items-center gap-2 text-xs sm:text-sm">
                                                <span class="px-2 py-0.5 sm:py-1 bg-green-100 text-green-700 rounded-md font-semibold whitespace-nowrap">
                                                    {{ __('frontend.included') }}
                                                </span>
                                                <span class="text-slate-500 hidden sm:inline">•</span>
                                                <span class="text-slate-600">1 {{ __('frontend.ipv4_address') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional IPv4 -->
                            <div class="mb-6 md:mb-8">
                                <div class="flex flex-col sm:flex-row items-start justify-between p-3 sm:p-4 md:p-5 bg-gradient-to-r from-purple-50 to-indigo-50 border-2 border-purple-200 rounded-lg md:rounded-xl hover:shadow-lg transition-all duration-200 gap-3">
                                    <div class="flex-1 w-full">
                                        <label for="additional_ipv4" class="flex items-start cursor-pointer">
                                            <div class="{{ app()->getLocale() == 'ar' ? 'ml-2 sm:ml-3 md:ml-4' : 'mr-2 sm:mr-3 md:mr-4' }} flex-shrink-0">
                                                <svg class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="text-base sm:text-lg font-bold text-slate-900 mb-1">
                                                    {{ __('frontend.additional_ipv4') }}
                                                    <span class="text-xs sm:text-sm font-normal text-slate-600">({{ __('frontend.optional') }})</span>
                                                </div>
                                                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                                    {{ __('frontend.additional_ipv4_description') }}
                                                </p>
                                                <div class="mt-2 flex flex-wrap items-center gap-2 text-xs sm:text-sm">
                                                    <span class="px-2 py-0.5 sm:py-1 bg-purple-100 text-purple-700 rounded-md font-semibold whitespace-nowrap">
                                                        +$5.00/{{ __('frontend.month') }}
                                                    </span>
                                                    <span class="text-slate-500 hidden sm:inline">•</span>
                                                    <span class="text-slate-600">{{ __('frontend.per_ip') }}</span>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="flex items-center gap-2 sm:gap-3 {{ app()->getLocale() == 'ar' ? 'mr-0 sm:mr-2 md:mr-4' : 'ml-0 sm:ml-2 md:ml-4' }} w-full sm:w-auto justify-end">
                                        <button type="button" onclick="changeIPv4Count(-1)" class="w-9 h-9 sm:w-10 sm:h-10 bg-purple-100 hover:bg-purple-200 active:bg-purple-300 text-purple-700 font-bold rounded-lg transition-colors flex items-center justify-center">
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                            </svg>
                                        </button>
                                        <input type="number" name="additional_ipv4" id="additional_ipv4" value="0" min="0" max="10" class="w-14 sm:w-16 text-center px-2 sm:px-3 py-1.5 sm:py-2 bg-white border-2 border-purple-300 rounded-lg font-bold text-sm sm:text-base text-purple-700 focus:ring-2 focus:ring-purple-500 focus:border-purple-500" readonly>
                                        <button type="button" onclick="changeIPv4Count(1)" class="w-9 h-9 sm:w-10 sm:h-10 bg-purple-100 hover:bg-purple-200 active:bg-purple-300 text-purple-700 font-bold rounded-lg transition-colors flex items-center justify-center">
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Public IPv6 -->
                            <div class="mb-6 md:mb-8">
                                <div class="flex flex-col sm:flex-row items-start justify-between p-3 sm:p-4 md:p-5 bg-gradient-to-r from-cyan-50 to-teal-50 border-2 border-cyan-200 rounded-lg md:rounded-xl hover:shadow-lg transition-all duration-200 gap-3">
                                    <div class="flex-1 w-full">
                                        <label for="enable_ipv6" class="flex items-start cursor-pointer">
                                            <div class="{{ app()->getLocale() == 'ar' ? 'ml-2 sm:ml-3 md:ml-4' : 'mr-2 sm:mr-3 md:mr-4' }} flex-shrink-0">
                                                <svg class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="text-base sm:text-lg font-bold text-slate-900 mb-1">
                                                    {{ __('frontend.public_ipv6') }}
                                                    <span class="text-xs sm:text-sm font-normal text-slate-600">({{ __('frontend.optional') }})</span>
                                                </div>
                                                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                                    {{ __('frontend.public_ipv6_description') }}
                                                </p>
                                                <div class="mt-2 flex flex-wrap items-center gap-2 text-xs sm:text-sm">
                                                    <span class="px-2 py-0.5 sm:py-1 bg-cyan-100 text-cyan-700 rounded-md font-semibold whitespace-nowrap">
                                                        {{ __('frontend.free') }}
                                                    </span>
                                                    <span class="text-slate-500 hidden sm:inline">•</span>
                                                    <span class="text-slate-600">{{ __('frontend.ipv6_subnet') }}</span>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'mr-0 sm:mr-2 md:mr-4' : 'ml-0 sm:ml-2 md:ml-4' }} w-full sm:w-auto justify-end">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="enable_ipv6" id="enable_ipv6" class="sr-only peer" value="1">
                                            <div class="w-12 h-6 sm:w-14 sm:h-7 bg-slate-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-cyan-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[4px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 sm:after:h-6 sm:after:w-6 after:transition-all peer-checked:bg-cyan-600"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- DDoS Protection -->
                            <div class="mb-6 md:mb-8">
                                <div class="flex flex-col sm:flex-row items-start justify-between p-3 sm:p-4 md:p-5 bg-gradient-to-r from-red-50 to-orange-50 border-2 border-red-200 rounded-lg md:rounded-xl hover:shadow-lg transition-all duration-200 gap-3">
                                    <div class="flex-1 w-full">
                                        <label for="enable_ddos" class="flex items-start cursor-pointer">
                                            <div class="{{ app()->getLocale() == 'ar' ? 'ml-2 sm:ml-3 md:ml-4' : 'mr-2 sm:mr-3 md:mr-4' }} flex-shrink-0">
                                                <svg class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="text-base sm:text-lg font-bold text-slate-900 mb-1">
                                                    {{ __('frontend.ddos_protection') }}
                                                    <span class="text-xs sm:text-sm font-normal text-slate-600">({{ __('frontend.optional') }})</span>
                                                </div>
                                                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                                    {{ __('frontend.ddos_protection_description') }}
                                                </p>
                                                <div class="mt-2 flex flex-wrap items-center gap-2 text-xs sm:text-sm">
                                                    <span class="px-2 py-0.5 sm:py-1 bg-red-100 text-red-700 rounded-md font-semibold whitespace-nowrap">
                                                        +$15.00/{{ __('frontend.month') }}
                                                    </span>
                                                    <span class="text-slate-500 hidden sm:inline">•</span>
                                                    <span class="text-slate-600">{{ __('frontend.advanced_protection') }}</span>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'mr-0 sm:mr-2 md:mr-4' : 'ml-0 sm:ml-2 md:ml-4' }} w-full sm:w-auto justify-end">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="enable_ddos" id="enable_ddos" class="sr-only peer" value="1">
                                            <div class="w-12 h-6 sm:w-14 sm:h-7 bg-slate-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[4px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 sm:after:h-6 sm:after:w-6 after:transition-all peer-checked:bg-red-600"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white/90 backdrop-blur-sm rounded-xl md:rounded-2xl shadow-xl p-4 sm:p-5 md:p-6 border border-slate-200/50 lg:sticky lg:top-24">
                        <h3 class="text-lg sm:text-xl font-black text-slate-900 mb-4 sm:mb-6 pb-3 sm:pb-4 border-b-2 border-slate-200">
                            {{ __('frontend.order_summary') }}
                        </h3>

                        <!-- Plan Details -->
                        <div class="space-y-3 sm:space-y-4 mb-4 sm:mb-6">
                            <div class="flex justify-between items-center">
                                <span class="text-xs sm:text-sm text-slate-600">{{ __('frontend.plan') }}</span>
                                <span class="font-bold text-sm sm:text-base text-slate-900 text-right">{{ $vpsPlan->plan_name }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs sm:text-sm text-slate-600">{{ __('frontend.cpu') }}</span>
                                <span class="font-bold text-sm sm:text-base text-slate-900">{{ $vpsPlan->vcpu_count }} {{ __('frontend.cores') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs sm:text-sm text-slate-600">{{ __('frontend.ram') }}</span>
                                <span class="font-bold text-sm sm:text-base text-slate-900">{{ $vpsPlan->ram_mb >= 1024 ? ($vpsPlan->ram_mb / 1024) . ' GB' : $vpsPlan->ram_mb . ' MB' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs sm:text-sm text-slate-600">{{ __('frontend.storage') }}</span>
                                <span class="font-bold text-sm sm:text-base text-slate-900">{{ $vpsPlan->storage_gb }} GB SSD</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs sm:text-sm text-slate-600">{{ __('frontend.bandwidth') }}</span>
                                <span class="font-bold text-sm sm:text-base text-slate-900">{{ $vpsPlan->bandwidth_gb >= 1024 ? ($vpsPlan->bandwidth_gb / 1024) . ' TB' : $vpsPlan->bandwidth_gb . ' GB' }}</span>
                            </div>
                        </div>

                        <!-- Pricing -->
                        <div class="border-t-2 border-slate-200 pt-6">
                            <div class="space-y-3">
                                <div class="flex justify-between text-lg">
                                    <span class="text-slate-600">{{ __('frontend.subtotal') }}</span>
                                    <span class="font-bold text-slate-900" id="subtotal-price">${{ number_format($vpsPlan->monthly_price, 2) }}</span>
                                </div>
                                @if($vpsPlan->setup_fee > 0)
                                <div class="flex justify-between">
                                    <span class="text-slate-600">{{ __('frontend.setup_fee') }}</span>
                                    <span class="font-bold text-slate-900">${{ number_format($vpsPlan->setup_fee, 2) }}</span>
                                </div>
                                @endif
                                <div class="flex justify-between" id="backup-cost-row" style="display: none;">
                                    <span class="text-slate-600 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                        </svg>
                                        {{ __('frontend.backups') }}
                                    </span>
                                    <span class="font-bold text-blue-600" id="backup-cost-value">$0.00</span>
                                </div>
                                <div class="flex justify-between" id="ipv4-cost-row" style="display: none;">
                                    <span class="text-slate-600 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        <span id="ipv4-count-label">{{ __('frontend.additional_ips') }}</span>
                                    </span>
                                    <span class="font-bold text-purple-600" id="ipv4-cost-value">$0.00</span>
                                </div>
                                <div class="flex justify-between" id="ddos-cost-row" style="display: none;">
                                    <span class="text-slate-600 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                        {{ __('frontend.ddos_protection') }}
                                    </span>
                                    <span class="font-bold text-red-600" id="ddos-cost-value">$0.00</span>
                                </div>
                            </div>

                            <div class="mt-4 sm:mt-6 pt-4 sm:pt-6 border-t-2 border-slate-200">
                                <div class="flex justify-between items-center mb-4 sm:mb-6">
                                    <span class="text-lg sm:text-xl font-black text-slate-900">{{ __('frontend.total') }}</span>
                                    <span class="text-2xl sm:text-3xl font-black text-blue-600" id="total-price">${{ number_format($vpsPlan->monthly_price + $vpsPlan->setup_fee, 2) }}</span>
                                </div>

                                <!-- Action Buttons -->
                                <div class="space-y-2 sm:space-y-3">
                                    <button type="submit" form="configure-form" class="w-full px-4 sm:px-6 py-3 sm:py-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold rounded-lg sm:rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl active:scale-95 sm:hover:scale-105 flex items-center justify-center gap-2 text-sm sm:text-base">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        {{ __('frontend.add_to_cart') }}
                                    </button>
                                    <a href="{{ route('vps.hosting') }}" class="w-full px-4 sm:px-6 py-3 sm:py-4 border-2 border-slate-300 text-slate-700 font-bold rounded-lg sm:rounded-xl hover:bg-slate-50 transition-colors flex items-center justify-center gap-2 text-sm sm:text-base">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                        </svg>
                                        {{ __('frontend.back_to_plans') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Price data
    const prices = {
        monthly: {{ $vpsPlan->monthly_price }},
        quarterly: {{ $vpsPlan->quarterly_price ?? 0 }},
        semi_annually: {{ $vpsPlan->semi_annually_price ?? 0 }},
        annually: {{ $vpsPlan->annually_price ?? 0 }},
        setup_fee: {{ $vpsPlan->setup_fee }},
        backup_percentage: 0.20, // Backup cost is 20% of plan price
        ipv4_monthly: 5.00, // Additional IPv4 cost per month
        ddos_monthly: 15.00 // DDoS Protection cost per month
    };

    // Change IPv4 count
    function changeIPv4Count(change) {
        const input = document.getElementById('additional_ipv4');
        let currentValue = parseInt(input.value) || 0;
        let newValue = currentValue + change;
        
        // Keep between 0 and 10
        if (newValue < 0) newValue = 0;
        if (newValue > 10) newValue = 10;
        
        input.value = newValue;
        updatePrice();
    }

    function updatePrice() {
        const selectedCycle = document.querySelector('input[name="billing_cycle_display"]:checked').value;
        document.getElementById('billing-cycle-input').value = selectedCycle;
        
        const price = prices[selectedCycle] || prices.monthly;
        const setupFee = prices.setup_fee;
        
        // Calculate backup cost based on billing cycle (20% of plan price)
        let backupCost = 0;
        const backupEnabled = document.getElementById('enable_backups')?.checked || false;
        
        if (backupEnabled) {
            backupCost = price * prices.backup_percentage;
        }
        
        // Calculate additional IPv4 cost
        let ipv4Cost = 0;
        const additionalIPv4 = parseInt(document.getElementById('additional_ipv4')?.value) || 0;
        
        if (additionalIPv4 > 0) {
            switch(selectedCycle) {
                case 'monthly':
                    ipv4Cost = prices.ipv4_monthly * additionalIPv4;
                    break;
                case 'quarterly':
                    ipv4Cost = prices.ipv4_monthly * 3 * additionalIPv4;
                    break;
                case 'semi_annually':
                    ipv4Cost = prices.ipv4_monthly * 6 * additionalIPv4;
                    break;
                case 'annually':
                    ipv4Cost = prices.ipv4_monthly * 12 * additionalIPv4;
                    break;
            }
        }
        
        // Calculate DDoS Protection cost
        let ddosCost = 0;
        const ddosEnabled = document.getElementById('enable_ddos')?.checked || false;
        
        if (ddosEnabled) {
            switch(selectedCycle) {
                case 'monthly':
                    ddosCost = prices.ddos_monthly;
                    break;
                case 'quarterly':
                    ddosCost = prices.ddos_monthly * 3;
                    break;
                case 'semi_annually':
                    ddosCost = prices.ddos_monthly * 6;
                    break;
                case 'annually':
                    ddosCost = prices.ddos_monthly * 12;
                    break;
            }
        }
        
        const total = price + setupFee + backupCost + ipv4Cost + ddosCost;

        document.getElementById('subtotal-price').textContent = '$' + price.toFixed(2);
        document.getElementById('total-price').textContent = '$' + total.toFixed(2);
        
        // Show/hide backup cost row
        const backupCostRow = document.getElementById('backup-cost-row');
        const backupCostValue = document.getElementById('backup-cost-value');
        
        if (backupEnabled && backupCost > 0) {
            backupCostRow.style.display = 'flex';
            backupCostValue.textContent = '$' + backupCost.toFixed(2);
        } else {
            backupCostRow.style.display = 'none';
        }
        
        // Show/hide IPv4 cost row
        const ipv4CostRow = document.getElementById('ipv4-cost-row');
        const ipv4CostValue = document.getElementById('ipv4-cost-value');
        const ipv4CountLabel = document.getElementById('ipv4-count-label');
        
        if (additionalIPv4 > 0 && ipv4Cost > 0) {
            ipv4CostRow.style.display = 'flex';
            ipv4CostValue.textContent = '$' + ipv4Cost.toFixed(2);
            ipv4CountLabel.textContent = additionalIPv4 + ' {{ __("frontend.additional_ips") }}';
        } else {
            ipv4CostRow.style.display = 'none';
        }
        
        // Show/hide DDoS cost row
        const ddosCostRow = document.getElementById('ddos-cost-row');
        const ddosCostValue = document.getElementById('ddos-cost-value');
        
        if (ddosEnabled && ddosCost > 0) {
            ddosCostRow.style.display = 'flex';
            ddosCostValue.textContent = '$' + ddosCost.toFixed(2);
        } else {
            ddosCostRow.style.display = 'none';
        }
    }

    // Validate hostname is subdomain
    function validateHostname() {
        const hostnameInput = document.getElementById('hostname');
        const hostnameError = document.getElementById('hostname-error');
        const hostnameErrorMessage = document.getElementById('hostname-error-message');
        const hostname = hostnameInput.value.trim();
        
        // Check if hostname contains only English letters, numbers, dots, and hyphens
        const validCharsRegex = /^[a-zA-Z0-9.-]+$/;
        if (!validCharsRegex.test(hostname)) {
            hostnameError.classList.remove('hidden');
            hostnameErrorMessage.textContent = '{{ __("frontend.hostname_english_only") }}';
            hostnameInput.classList.add('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
            hostnameInput.classList.remove('border-slate-300', 'focus:ring-blue-500', 'focus:border-blue-500');
            return false;
        }
        
        // Check if hostname contains at least one dot (subdomain.domain.tld)
        const parts = hostname.split('.');
        
        // Valid subdomain should have at least 3 parts: subdomain.domain.tld
        // Example: server.example.com (valid)
        // Example: example.com (invalid - domain only)
        if (parts.length < 3 || hostname === '' || !hostname.includes('.')) {
            hostnameError.classList.remove('hidden');
            hostnameErrorMessage.textContent = '{{ __("frontend.hostname_must_contain_subdomain") }}';
            hostnameInput.classList.add('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
            hostnameInput.classList.remove('border-slate-300', 'focus:ring-blue-500', 'focus:border-blue-500');
            return false;
        } else {
            hostnameError.classList.add('hidden');
            hostnameInput.classList.remove('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
            hostnameInput.classList.add('border-slate-300', 'focus:ring-blue-500', 'focus:border-blue-500');
            return true;
        }
    }

    // Initialize price
    document.addEventListener('DOMContentLoaded', function() {
        updatePrice();
        
        // Validate hostname on input
        const hostnameInput = document.getElementById('hostname');
        if (hostnameInput) {
            hostnameInput.addEventListener('input', validateHostname);
            hostnameInput.addEventListener('blur', validateHostname);
        }
        
        // Prevent form submission if hostname is invalid
        const configForm = document.getElementById('configure-form');
        if (configForm) {
            configForm.addEventListener('submit', function(e) {
                if (!validateHostname()) {
                    e.preventDefault();
                    hostnameInput.focus();
                    return false;
                }
            });
        }
        
        // Listen for backup toggle
        const backupCheckbox = document.getElementById('enable_backups');
        if (backupCheckbox) {
            backupCheckbox.addEventListener('change', updatePrice);
        }
        
        // Listen for DDoS toggle
        const ddosCheckbox = document.getElementById('enable_ddos');
        if (ddosCheckbox) {
            ddosCheckbox.addEventListener('change', updatePrice);
        }
    });

    // Handle OS and App mutual exclusivity
    const osSelect = document.getElementById('os-select');
    const appSelect = document.getElementById('app-select');

    if (osSelect && appSelect) {
        // Add visual feedback on hover
        [osSelect, appSelect].forEach(select => {
            select.addEventListener('mouseenter', function() {
                if (!this.disabled) {
                    this.style.transform = 'translateY(-2px)';
                }
            });
            
            select.addEventListener('mouseleave', function() {
                if (!this.disabled) {
                    this.style.transform = 'translateY(0)';
                }
            });
        });
        
        // When OS is selected, disable and clear App selection
        osSelect.addEventListener('change', function() {
            if (this.value) {
                appSelect.value = '';
                appSelect.disabled = true;
                appSelect.classList.add('opacity-50', 'cursor-not-allowed');
                appSelect.classList.remove('hover:border-blue-400');
                
                // Add visual feedback
                this.classList.add('border-green-500');
                setTimeout(() => this.classList.remove('border-green-500'), 1000);
            } else {
                appSelect.disabled = false;
                appSelect.classList.remove('opacity-50', 'cursor-not-allowed');
                appSelect.classList.add('hover:border-blue-400');
            }
        });

        // When App is selected, disable and clear OS selection (make it optional)
        appSelect.addEventListener('change', function() {
            if (this.value) {
                osSelect.removeAttribute('required');
                osSelect.value = '';
                osSelect.disabled = true;
                osSelect.classList.add('opacity-50', 'cursor-not-allowed');
                osSelect.classList.remove('hover:border-blue-400');
                
                // Add visual feedback
                this.classList.add('border-green-500');
                setTimeout(() => this.classList.remove('border-green-500'), 1000);
            } else {
                osSelect.setAttribute('required', 'required');
                osSelect.disabled = false;
                osSelect.classList.remove('opacity-50', 'cursor-not-allowed');
                osSelect.classList.add('hover:border-blue-400');
            }
        });
    }
    
    // Add enhanced focus and blur effects to all selects
    document.querySelectorAll('select').forEach(select => {
        select.addEventListener('focus', function() {
            const icon = this.parentElement.querySelector('svg:last-child');
            if (icon) {
                icon.style.transform = 'rotate(180deg)';
                icon.style.color = '#3b82f6';
            }
        });
        
        select.addEventListener('blur', function() {
            const icon = this.parentElement.querySelector('svg:last-child');
            if (icon) {
                icon.style.transform = 'rotate(0deg)';
                icon.style.color = '#94a3b8';
            }
        });
    });
</script>

<style>
    /* تحسين مظهر القوائم المنسدلة */
    select {
        background-image: none !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }
    
    select:focus {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.2);
    }
    
    select:hover:not(:disabled) {
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
        border-color: #60a5fa !important;
    }
    
    select:disabled {
        cursor: not-allowed !important;
        opacity: 0.5 !important;
        background: #f1f5f9 !important;
    }
    
    /* تحسين مظهر الخيارات */
    select option {
        padding: 12px 16px;
        font-weight: 500;
        line-height: 1.6;
    }
    
    select option:checked {
        background: linear-gradient(90deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        font-weight: 600;
    }
    
    /* تحسين الانتقالات */
    select,
    select + div svg {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    select:focus + div svg {
        transform: rotate(180deg);
        color: #3b82f6;
    }
    
    /* تأثيرات الأيقونات */
    select:hover ~ div svg,
    select:focus ~ div svg {
        color: #3b82f6;
    }
    
    /* تحسين مظهر الأيقونة اليسرى/اليمنى */
    select:focus ~ div:first-of-type svg,
    select:hover ~ div:first-of-type svg {
        color: #3b82f6;
        transform: scale(1.1);
    }
    
    /* تحسين المظهر على الشاشات الصغيرة */
    @media (max-width: 640px) {
        section select {
            font-size: 14px;
            padding-top: 12px !important;
            padding-bottom: 12px !important;
        }
        
        section select option {
            padding: 10px 12px;
        }
        
        /* تحسين عرض العناوين على الموبايل */
        section label span.truncate {
            max-width: 120px;
        }
        
        /* تحسين المسافات */
        section .space-y-4 > * + * {
            margin-top: 0.75rem;
        }
    }
    
    @media (max-width: 480px) {
        section select {
            font-size: 13px;
            padding-left: 2.5rem !important;
            padding-right: 2.5rem !important;
        }
        
        /* تصغير أحجام الأيقونات */
        section select ~ div svg {
            width: 1rem;
            height: 1rem;
        }
        
        /* تحسين الأزرار */
        section button:not(nav button):not(header button) {
            font-size: 14px;
        }
        
        /* تحسين البطاقات على الشاشات الصغيرة */
        section .flex-col.sm\:flex-row {
            gap: 0.75rem;
        }
        
        /* تحسين Toggle Switch */
        section .peer-checked\:after\:translate-x-full::after {
            width: 1.25rem;
            height: 1.25rem;
        }
    }
    
    /* تحسينات للشاشات الصغيرة جداً - للصفحة فقط */
    @media (max-width: 375px) {
        /* تقليل Padding بشكل أكبر */
        section .p-3, 
        section .sm\:p-4, 
        section .md\:p-5 {
            padding: 0.625rem !important;
        }
        
        /* تصغير النصوص */
        section .text-base {
            font-size: 14px;
        }
        
        section .text-sm {
            font-size: 12px;
        }
        
        section .text-xs {
            font-size: 11px;
        }
        
        /* تحسين الأيقونات */
        section .w-6, 
        section .sm\:w-7, 
        section .md\:w-8 {
            width: 1.25rem !important;
            height: 1.25rem !important;
        }
        
        /* تحسين العناوين */
        section h1 {
            font-size: 1.25rem !important;
        }
        
        /* تحسين البطاقات */
        section .rounded-lg, 
        section .md\:rounded-xl {
            border-radius: 0.5rem;
        }
    }
    
    /* الحفاظ على max-width للشاشات الكبيرة */
    @media (min-width: 1024px) {
        .max-w-6xl {
            max-width: 72rem !important;
        }
        
        .container {
            max-width: 100%;
        }
    }
    
    /* تحسين للشاشات المتوسطة والكبيرة - للصفحة فقط */
    @media (min-width: 768px) {
        section .lg\:col-span-2 {
            grid-column: span 2 / span 2;
        }
        
        section .lg\:col-span-1 {
            grid-column: span 1 / span 1;
        }
    }
    
    /* تحسين مظهر القائمة عند الفتح */
    select:focus {
        outline: none;
        border-width: 2px;
    }
    
    /* تأثير متقدم للقوائم */
    select {
        position: relative;
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
    }
    
    /* تحسين التباين للنص */
    select option {
        background-color: white;
        color: #1e293b;
    }
    
    select option:hover {
        background-color: #eff6ff;
    }
    
    select option:disabled {
        color: #94a3b8;
        background-color: #f8fafc;
    }
    
    /* تأثير تحميل جميل */
    @keyframes selectPulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.8; }
    }
    
    select.loading {
        animation: selectPulse 1.5s ease-in-out infinite;
    }
    
    /* تحسين مظهر placeholder */
    select option[value=""] {
        color: #94a3b8;
        font-style: italic;
    }
    
    /* تجاوب أفضل للغة العربية */
    html[dir="rtl"] select {
        text-align: right;
    }
    
    html[dir="ltr"] select {
        text-align: left;
    }
    
    /* تحسينات إضافية للموبايل */
    @media (max-width: 768px) {
        /* تحسين الـ sticky للملخص */
        .lg\:sticky {
            position: static !important;
        }
        
        /* تحسين العرض الشبكي */
        .grid {
            gap: 1rem;
        }
        
        /* تحسين المسافات الداخلية */
        .p-8 {
            padding: 1rem;
        }
        
        /* تحسين النصوص الطويلة */
        .truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    }
    
    /* تحسين العناصر التفاعلية على اللمس */
    @media (hover: none) and (pointer: coarse) {
        button:hover,
        select:hover,
        label:hover {
            transform: none;
        }
        
        button:active {
            transform: scale(0.98);
        }
    }
    
    /* منع التكبير التلقائي في iOS */
    @media screen and (-webkit-min-device-pixel-ratio: 0) {
        select,
        input[type="text"],
        input[type="number"] {
            font-size: 16px !important;
        }
    }
    
    /* منع التمرير الأفقي فقط على هذه الصفحة */
    section .container {
        overflow-x: hidden;
    }
    
    /* تحسين الصور والعناصر الكبيرة داخل المحتوى فقط */
    section .container img,
    section .container svg:not(nav svg):not(header svg),
    section .container video {
        max-width: 100%;
        height: auto;
    }
    
    /* منع تجاوز النصوص على الموبايل فقط داخل المحتوى */
    @media (max-width: 768px) {
        section .container p,
        section .container span,
        section .container div {
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
    }
    
    /* تحسين Container على الموبايل - للصفحة فقط */
    @media (max-width: 640px) {
        section .container {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
        
        /* منع overflow في البطاقات */
        section .flex-1 {
            min-width: 0;
        }
        
        /* تحسين Grid */
        section .grid {
            width: 100%;
        }
        
        /* تحسين عرض النصوص الطويلة */
        section .leading-relaxed {
            line-height: 1.5;
        }
    }
    
    /* تحسين التفاعل على الشاشات الصغيرة - للصفحة فقط */
    @media (max-width: 640px) {
        /* زيادة مساحة الضغط */
        section button:not(nav button):not(header button), 
        section label[for], 
        section input[type="checkbox"],
        section input[type="radio"] {
            min-height: 44px;
            min-width: 44px;
        }
        
        /* تحسين المسافات بين العناصر */
        section .gap-2 {
            gap: 0.375rem;
        }
        
        section .gap-3 {
            gap: 0.5rem;
        }
        
        /* تحسين الـ Toggle Switch للمس */
        section .peer:focus ~ div {
            outline: 2px solid #3b82f6;
            outline-offset: 2px;
        }
    }
</style>
@endpush
@endsection
