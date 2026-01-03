@extends('frontend.layout')

@section('title', __('frontend.configure_dedicated_server') . ' - ' . config('app.name'))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-4 sm:py-6 md:py-8 lg:py-12">
    <!-- Toast Notification -->
    <div id="toast-notification" class="hidden fixed top-20 sm:top-24 left-2 right-2 sm:{{ app()->getLocale() == 'ar' ? 'right-8 left-auto' : 'left-8 right-auto' }} z-50 transform transition-all duration-300 ease-in-out">
        <div class="bg-white dark:bg-slate-800 rounded-xl sm:rounded-2xl shadow-2xl border-2 border-red-500 dark:border-red-600 overflow-hidden w-full sm:min-w-[360px] sm:max-w-md">
            <div class="p-3 sm:p-4 md:p-5">
                <div class="flex items-start gap-2 sm:gap-3 md:gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-lg sm:rounded-xl flex items-center justify-center shadow-lg">
                            <svg id="toast-icon" class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 pt-0.5 sm:pt-1">
                        <h3 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white mb-1">
                            {{ __('frontend.validation_error') ?? 'Validation Error' }}
                        </h3>
                        <p id="toast-message" class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                        </p>
                    </div>
                    <button onclick="hideToast()" class="flex-shrink-0 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="h-1 bg-gradient-to-r from-red-500 to-red-600"></div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-2 sm:px-4 md:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="text-center mb-4 sm:mb-6 md:mb-8 lg:mb-12 px-2 sm:px-3 md:px-4">
            <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl xl:text-5xl font-black text-slate-900 mb-2 sm:mb-3 md:mb-4">
                {{ __('frontend.configure_dedicated_server') }}
            </h1>
            <p class="text-sm sm:text-base md:text-lg text-slate-600">
                {{ __('frontend.customize_your_server') }}
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 sm:gap-4 md:gap-6 lg:gap-8">
            <!-- Configuration Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl sm:rounded-2xl shadow-xl p-3 sm:p-4 md:p-6 lg:p-8">
                    <h2 class="text-lg sm:text-xl md:text-2xl font-bold text-slate-900 mb-4 sm:mb-5 md:mb-6">{{ $dedicatedPlan->plan_name }}</h2>
                    
                    <form id="configure-form" action="{{ route('cart.add-dedicated') }}" method="POST">
                        @csrf
                        <input type="hidden" name="dedicated_plan_id" value="{{ $dedicatedPlan->id }}">
                        
                        <!-- Billing Cycle -->
                        <div class="mb-6 sm:mb-8">
                            <label class="text-base sm:text-lg font-bold text-slate-900 mb-3 sm:mb-4 flex items-center gap-2 px-2 sm:px-0">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ __('frontend.billing_cycle') }}
                            </label>
                            <input type="hidden" name="billing_cycle" id="billing-cycle-input" value="monthly">
                            
                            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-2 sm:gap-3 md:gap-4 px-2 sm:px-0">
                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="billing_cycle_display" value="monthly" class="peer sr-only" checked onchange="updatePrice()">
                                    <div class="p-3 sm:p-4 bg-gradient-to-br from-slate-50 to-slate-100 rounded-lg sm:rounded-xl border-2 border-slate-200 peer-checked:border-blue-500 peer-checked:from-blue-50 peer-checked:to-blue-100 transition-all min-h-[100px] sm:min-h-[120px] md:min-h-[140px] flex items-center justify-center hover:shadow-lg group-hover:scale-105 transform duration-300">
                                        <div class="text-center">
                                            <svg class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 mx-auto mb-1 sm:mb-2 text-slate-400 peer-checked:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <div class="text-xs sm:text-sm text-slate-600 mb-1 sm:mb-2 font-medium">{{ __('frontend.monthly') }}</div>
                                            <div class="text-lg sm:text-xl md:text-2xl font-bold text-slate-900">${{ number_format($dedicatedPlan->monthly_price, 2) }}</div>
                                        </div>
                                    </div>
                                </label>

                                @if($dedicatedPlan->quarterly_price)
                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="billing_cycle_display" value="quarterly" class="peer sr-only" onchange="updatePrice()">
                                    <div class="p-3 sm:p-4 bg-gradient-to-br from-slate-50 to-slate-100 rounded-lg sm:rounded-xl border-2 border-slate-200 peer-checked:border-blue-500 peer-checked:from-blue-50 peer-checked:to-blue-100 transition-all min-h-[100px] sm:min-h-[120px] md:min-h-[140px] flex items-center justify-center hover:shadow-lg group-hover:scale-105 transform duration-300">
                                        <div class="text-center">
                                            <svg class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 mx-auto mb-1 sm:mb-2 text-slate-400 peer-checked:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>
                                            <div class="text-xs sm:text-sm text-slate-600 mb-1 sm:mb-2 font-medium">{{ __('frontend.quarterly') }}</div>
                                            <div class="text-lg sm:text-xl md:text-2xl font-bold text-slate-900">${{ number_format($dedicatedPlan->quarterly_price, 2) }}</div>
                                        </div>
                                    </div>
                                </label>
                                @endif

                                @if($dedicatedPlan->semi_annually_price)
                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="billing_cycle_display" value="semi_annually" class="peer sr-only" onchange="updatePrice()">
                                    <div class="p-3 sm:p-4 bg-gradient-to-br from-slate-50 to-slate-100 rounded-lg sm:rounded-xl border-2 border-slate-200 peer-checked:border-blue-500 peer-checked:from-blue-50 peer-checked:to-blue-100 transition-all min-h-[100px] sm:min-h-[120px] md:min-h-[140px] flex items-center justify-center hover:shadow-lg group-hover:scale-105 transform duration-300">
                                        <div class="text-center">
                                            <svg class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 mx-auto mb-1 sm:mb-2 text-slate-400 peer-checked:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <div class="text-xs sm:text-sm text-slate-600 mb-1 sm:mb-2 font-medium">{{ __('frontend.semi_annually') }}</div>
                                            <div class="text-lg sm:text-xl md:text-2xl font-bold text-slate-900">${{ number_format($dedicatedPlan->semi_annually_price, 2) }}</div>
                                        </div>
                                    </div>
                                </label>
                                @endif

                                @if($dedicatedPlan->annually_price)
                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="billing_cycle_display" value="annually" class="peer sr-only" onchange="updatePrice()">
                                    <div class="p-3 sm:p-4 bg-gradient-to-br from-slate-50 to-slate-100 rounded-lg sm:rounded-xl border-2 border-slate-200 peer-checked:border-blue-500 peer-checked:from-blue-50 peer-checked:to-blue-100 transition-all min-h-[100px] sm:min-h-[120px] md:min-h-[140px] flex items-center justify-center hover:shadow-lg group-hover:scale-105 transform duration-300">
                                        <div class="text-center">
                                            <svg class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 mx-auto mb-1 sm:mb-2 text-slate-400 peer-checked:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                            </svg>
                                            <div class="text-xs sm:text-sm text-slate-600 mb-1 sm:mb-2 font-medium">{{ __('frontend.annually') }}</div>
                                            <div class="text-lg sm:text-xl md:text-2xl font-bold text-slate-900">${{ number_format($dedicatedPlan->annually_price, 2) }}</div>
                                        </div>
                                    </div>
                                </label>
                                @endif
                            </div>
                        </div>

                        <!-- Hostname -->
                        <div class="mb-8">
                            <label class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                </svg>
                                {{ __('frontend.hostname') }} ({{ __('frontend.subdomain') }})
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'right-0 pr-3' : 'left-0 pl-3' }} flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                                    </svg>
                                </div>
                                <input type="text" name="hostname" id="hostname" class="w-full {{ app()->getLocale() == 'ar' ? 'pr-10 pl-4' : 'pl-10 pr-4' }} py-3 bg-white border-2 border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-slate-900 transition-all" placeholder="server.example.com" pattern="[a-zA-Z0-9.-]+" required>
                            </div>
                            <p class="mt-2 text-sm text-slate-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ __('frontend.hostname_must_be_subdomain') }}
                            </p>
                        </div>

                        <!-- Disk Configuration -->
                        <div class="mb-8">
                            <label class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                                </svg>
                                {{ __('frontend.disk_configuration') }}
                            </label>
                            <div class="grid grid-cols-1 gap-3">
                                <label class="relative cursor-pointer disk-config-option group">
                                    <input type="radio" name="disk_configuration" value="raid_1" class="hidden disk-config-radio" checked>
                                    <div class="p-4 bg-gradient-to-r from-blue-50 to-blue-100 border-2 rounded-xl transition-all hover:shadow-md disk-config-box border-blue-500 group-hover:scale-102 transform duration-200">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full border-2 flex items-center justify-center disk-config-indicator border-blue-500 bg-blue-500 flex-shrink-0">
                                                <svg class="w-5 h-5 text-white disk-config-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-900">{{ __('frontend.raid_1_software') }}</div>
                                                <div class="text-sm text-slate-600 mt-0.5">Mirrored redundancy protection</div>
                                            </div>
                                        </div>
                                    </div>
                                </label>

                                <label class="relative cursor-pointer disk-config-option group">
                                    <input type="radio" name="disk_configuration" value="no_raid_formatted" class="hidden disk-config-radio">
                                    <div class="p-4 bg-gradient-to-r from-white to-slate-50 border-2 rounded-xl transition-all hover:shadow-md disk-config-box border-slate-200 group-hover:scale-102 transform duration-200">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full border-2 flex items-center justify-center disk-config-indicator border-slate-300 flex-shrink-0">
                                                <svg class="w-5 h-5 text-slate-400 disk-config-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-900">{{ __('frontend.no_raid_formatted') }}</div>
                                                <div class="text-sm text-slate-600 mt-0.5">Ready to use storage</div>
                                            </div>
                                        </div>
                                    </div>
                                </label>

                                <label class="relative cursor-pointer disk-config-option group">
                                    <input type="radio" name="disk_configuration" value="no_raid_unformatted" class="hidden disk-config-radio">
                                    <div class="p-4 bg-gradient-to-r from-white to-slate-50 border-2 rounded-xl transition-all hover:shadow-md disk-config-box border-slate-200 group-hover:scale-102 transform duration-200">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full border-2 flex items-center justify-center disk-config-indicator border-slate-300 flex-shrink-0">
                                                <svg class="w-5 h-5 text-slate-400 disk-config-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-900">{{ __('frontend.no_raid_unformatted') }}</div>
                                                <div class="text-sm text-slate-600 mt-0.5">Raw unformatted disks</div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Operating System -->
                        @if(!empty($operatingSystems) && count($operatingSystems) > 0)
                        <div class="mb-6 sm:mb-8 px-2 sm:px-0">
                            <label class="text-base sm:text-lg font-bold text-slate-900 mb-3 sm:mb-4 flex items-center gap-2">
                                <div class="w-8 h-8 sm:w-9 sm:h-9 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center shadow-md flex-shrink-0">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <span>{{ __('frontend.operating_system') }}</span>
                            </label>
                            
                            @if(!empty($dedicatedPlan->os_options) && is_array($dedicatedPlan->os_options))
                            <div class="mb-3 p-2 sm:p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                <p class="text-xs sm:text-sm text-blue-800 flex items-center gap-2">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ __('frontend.plan_specific_os_available') }}
                                </p>
                            </div>
                            @endif
                            
                            <select name="os_id" id="os-select" class="w-full px-4 py-3 sm:py-3.5 bg-white border-2 border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-slate-900 text-sm sm:text-base appearance-none cursor-pointer transition-all hover:border-blue-400">
                                <option value="">{{ __('frontend.select_os') }}</option>
                                @php
                                    $filteredOS = $operatingSystems;
                                    // Filter by plan's os_options if specified
                                    if (!empty($dedicatedPlan->os_options) && is_array($dedicatedPlan->os_options)) {
                                        $filteredOS = collect($operatingSystems)->filter(function($os) use ($dedicatedPlan) {
                                            return in_array($os['id'], $dedicatedPlan->os_options);
                                        });
                                    }
                                @endphp
                            @foreach($filteredOS as $os)
                                <option value="{{ $os['id'] }}">{{ $os['name'] }}</option>
                            @endforeach
                            </select>
                        </div>
                        @endif

                        <!-- Marketplace Applications -->
                        @if(!empty($marketplaceApps) && count($marketplaceApps) > 0)
                        <div class="mb-6 sm:mb-8 px-2 sm:px-0">
                            <label class="text-base sm:text-lg font-bold text-slate-900 mb-3 sm:mb-4 flex items-center gap-2">
                                <div class="w-8 h-8 sm:w-9 sm:h-9 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center shadow-md flex-shrink-0">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path>
                                    </svg>
                                </div>
                                <span>{{ __('frontend.marketplace_apps') }}</span>
                                <span class="text-xs sm:text-sm font-normal text-slate-600">({{ __('frontend.optional') }})</span>
                            </label>
                            
                            <div class="mb-3 p-2 sm:p-3 bg-amber-50 border border-amber-200 rounded-lg">
                                <p class="text-xs sm:text-sm text-amber-800 flex items-center gap-2">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                    {{ __('frontend.choose_os_or_app_not_both') }}
                                </p>
                            </div>
                            
                            @if(!empty($dedicatedPlan->app_options) && is_array($dedicatedPlan->app_options))
                            <div class="mb-3 p-2 sm:p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                <p class="text-xs sm:text-sm text-blue-800 flex items-center gap-2">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ __('frontend.apps_filtered_by_plan_specs') }}
                                </p>
                            </div>
                            @endif
                            
                            <select name="app_id" id="app-select" class="w-full px-4 py-3 sm:py-3.5 bg-white border-2 border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-slate-900 text-sm sm:text-base appearance-none cursor-pointer transition-all hover:border-blue-400">
                                <option value="">{{ __('frontend.none_preinstalled_os_only') }}</option>
                                @php
                                    $filteredApps = $marketplaceApps;
                                    // Filter by plan's app_options if specified
                                    if (!empty($dedicatedPlan->app_options) && is_array($dedicatedPlan->app_options)) {
                                        $filteredApps = collect($marketplaceApps)->filter(function($app) use ($dedicatedPlan) {
                                            return in_array($app['id'], $dedicatedPlan->app_options);
                                        });
                                    }
                                @endphp
                            @foreach($filteredApps as $app)
                                <option value="{{ $app['id'] }}">{{ $app['name'] }}</option>
                            @endforeach
                            </select>
                        </div>
                        @endif

                        <!-- Public IPv4 -->
                        <div class="mb-6 sm:mb-8 px-2 sm:px-0">
                            <label class="text-base sm:text-lg font-bold text-slate-900 mb-3 sm:mb-4 flex items-center gap-2">
                                <div class="w-8 h-8 sm:w-9 sm:h-9 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center shadow-md flex-shrink-0">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                    </svg>
                                </div>
                                <span>{{ __('frontend.public_ipv4') }}</span>
                            </label>
                            
                            <!-- Default IPv4 (Included) -->
                            <div class="mb-3 sm:mb-4 p-3 sm:p-4 bg-gradient-to-r from-blue-50 to-blue-100 border-2 border-blue-300 rounded-lg sm:rounded-xl shadow-sm">
                                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-0">
                                    <div class="flex items-center gap-2 sm:gap-3 w-full sm:w-auto">
                                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-500 rounded-lg sm:rounded-xl flex items-center justify-center shadow-md flex-shrink-0">
                                            <svg class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <div class="font-bold text-sm sm:text-base text-slate-900">1 × {{ __('frontend.public_ipv4') }}</div>
                                            <div class="text-xs sm:text-sm text-slate-600">{{ __('frontend.public_ipv4_required_description') }}</div>
                                        </div>
                                    </div>
                                    <div class="text-left sm:text-right w-full sm:w-auto">
                                        <div class="text-base sm:text-lg font-bold text-blue-600">{{ __('frontend.included') }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional IPv4 -->
                            <div class="mt-3 sm:mt-4">
                                <label class="text-sm sm:text-base font-bold text-slate-900 mb-2 sm:mb-3 flex items-center gap-2">
                                    <span>{{ __('frontend.additional_ipv4') }}</span>
                                    <span class="text-xs sm:text-sm font-normal text-slate-600">({{ __('frontend.optional') }})</span>
                                </label>
                                <p class="text-xs sm:text-sm text-slate-600 mb-2 sm:mb-3">{{ __('frontend.additional_ipv4_description') }}</p>
                                
                                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-4">
                                    <label class="text-xs sm:text-sm font-medium text-slate-700">{{ __('frontend.quantity') ?? 'Quantity' }}:</label>
                                    <select name="additional_ipv4" id="additional-ipv4" class="w-full sm:w-auto px-3 sm:px-4 py-2 bg-white border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-slate-900 text-sm sm:text-base" onchange="updateIPv4Price()">
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                    <span class="text-sm text-slate-600" id="ipv4-price-per-unit">× $6.00 {{ __('frontend.per_ip') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Public IPv6 -->
                        <div class="mb-6 sm:mb-8 px-2 sm:px-0">
                            <label class="text-base sm:text-lg font-bold text-slate-900 mb-3 sm:mb-4 flex items-center gap-2">
                                <div class="w-8 h-8 sm:w-9 sm:h-9 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center shadow-md flex-shrink-0">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <span>{{ __('frontend.public_ipv6') }}</span>
                                <span class="text-xs sm:text-sm font-normal text-slate-600">({{ __('frontend.optional') }})</span>
                            </label>
                            
                            <p class="text-xs sm:text-sm text-slate-600 mb-3 sm:mb-4">{{ __('frontend.public_ipv6_description') }}</p>
                            
                            <label class="relative cursor-pointer ipv6-option">
                                <input type="checkbox" name="enable_ipv6" id="enable-ipv6" value="1" class="hidden ipv6-checkbox">
                                <div class="p-3 sm:p-4 bg-white border-2 rounded-lg sm:rounded-xl transition-all hover:border-blue-300 ipv6-box border-slate-200">
                                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-0">
                                        <div class="flex items-center gap-2 sm:gap-3 w-full sm:w-auto">
                                            <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center ipv6-icon flex-shrink-0">
                                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <div class="font-bold text-sm sm:text-base text-slate-900">{{ __('frontend.enable') }} {{ __('frontend.public_ipv6') }}</div>
                                                <div class="text-xs sm:text-sm text-slate-600">{{ __('frontend.ipv6_subnet') }} - {{ __('frontend.free') }}</div>
                                            </div>
                                        </div>
                                        <div class="text-left sm:text-right w-full sm:w-auto">
                                            <div class="text-base sm:text-lg font-bold text-green-600">{{ __('frontend.free') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>

                    </form>
                </div>
            </div>

            <!-- Order Summary Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white/90 backdrop-blur-sm rounded-xl sm:rounded-2xl shadow-xl p-3 sm:p-4 md:p-5 lg:p-6 border border-slate-200/50 lg:sticky lg:top-8">
                    <h3 class="text-lg sm:text-xl font-black text-slate-900 mb-4 sm:mb-5 md:mb-6 pb-3 sm:pb-4 border-b-2 border-slate-200">
                        {{ __('frontend.order_summary') }}
                    </h3>

                    <!-- Plan Details -->
                    <div class="space-y-3 sm:space-y-4 mb-4 sm:mb-5 md:mb-6">
                        <div class="flex justify-between text-sm sm:text-base">
                            <span class="text-slate-600">{{ __('frontend.plan') }}</span>
                            <span class="font-bold text-slate-900">{{ $dedicatedPlan->plan_name }}</span>
                        </div>
                        <div class="flex justify-between text-sm sm:text-base">
                            <span class="text-slate-600">{{ __('frontend.cpu') }}</span>
                            <span class="font-bold text-slate-900">{{ $dedicatedPlan->cpu_cores }} {{ __('frontend.cores') }}</span>
                        </div>
                        <div class="flex justify-between text-sm sm:text-base">
                            <span class="text-slate-600">{{ __('frontend.ram') }}</span>
                            <span class="font-bold text-slate-900">{{ $dedicatedPlan->ram_gb }} GB</span>
                        </div>
                        <div class="flex justify-between text-sm sm:text-base">
                            <span class="text-slate-600">{{ __('frontend.storage') }}</span>
                            <span class="font-bold text-slate-900">{{ $dedicatedPlan->storage_total_gb }} GB</span>
                        </div>
                        <div class="flex justify-between text-sm sm:text-base">
                            <span class="text-slate-600">{{ __('frontend.number_of_disks') }}</span>
                            <span class="font-bold text-slate-900">{{ $dedicatedPlan->disk_count }}</span>
                        </div>
                        <div class="flex justify-between text-sm sm:text-base">
                            <span class="text-slate-600">{{ __('frontend.bandwidth') }}</span>
                            <span class="font-bold text-slate-900">{{ $dedicatedPlan->bandwidth }}</span>
                        </div>
                    </div>

                    <!-- Pricing -->
                    <div class="border-t-2 border-slate-200 pt-4 sm:pt-5 md:pt-6">
                        <div class="space-y-2 sm:space-y-3">
                            <div class="flex justify-between text-base sm:text-lg">
                                <span class="text-slate-600">{{ __('frontend.subtotal') }}</span>
                                <span class="font-bold text-slate-900" id="plan-price">${{ number_format($dedicatedPlan->monthly_price, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm sm:text-base" id="ipv4-cost-row" style="display: none;">
                                <span class="text-slate-600">{{ __('frontend.additional_ips') }}</span>
                                <span class="font-bold text-slate-900" id="ipv4-cost">$0.00</span>
                            </div>
                            @if($dedicatedPlan->setup_fee > 0)
                            <div class="flex justify-between text-sm sm:text-base">
                                <span class="text-slate-600">{{ __('frontend.setup_fee') }}</span>
                                <span class="font-bold text-slate-900">${{ number_format($dedicatedPlan->setup_fee, 2) }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4 sm:mt-5 md:mt-6 pt-4 sm:pt-5 md:pt-6 border-t-2 border-slate-200">
                        <div class="flex justify-between items-center mb-4 sm:mb-5 md:mb-6">
                            <span class="text-base sm:text-lg md:text-xl font-black text-slate-900">{{ __('frontend.total') }}</span>
                            <span class="text-xl sm:text-2xl md:text-3xl font-black text-blue-600" id="total-price">${{ number_format($dedicatedPlan->monthly_price + $dedicatedPlan->setup_fee, 2) }}</span>
                        </div>

                        <!-- Action Buttons -->
                        <div class="space-y-2 sm:space-y-3">
                            <button type="submit" form="configure-form" class="w-full px-4 sm:px-5 md:px-6 py-3 sm:py-3.5 md:py-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-sm sm:text-base font-bold rounded-lg sm:rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                {{ __('frontend.add_to_cart') }}
                            </button>
                            <a href="{{ route('dedicated.servers') }}" class="w-full px-4 sm:px-5 md:px-6 py-3 sm:py-3.5 md:py-4 border-2 border-slate-300 text-slate-700 text-sm sm:text-base font-bold rounded-lg sm:rounded-xl hover:bg-slate-50 transition-colors flex items-center justify-center gap-2">
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

@push('scripts')
<script>
    // Price data
    const prices = {
        monthly: {{ $dedicatedPlan->monthly_price }},
        quarterly: {{ $dedicatedPlan->quarterly_price ?? 0 }},
        semi_annually: {{ $dedicatedPlan->semi_annually_price ?? 0 }},
        annually: {{ $dedicatedPlan->annually_price ?? 0 }},
        setup_fee: {{ $dedicatedPlan->setup_fee }}
    };

    function updatePrice() {
        const selectedCycle = document.querySelector('input[name="billing_cycle_display"]:checked').value;
        document.getElementById('billing-cycle-input').value = selectedCycle;
        
        const price = prices[selectedCycle] || prices.monthly;
        const setupFee = prices.setup_fee;
        
        // Calculate IPv4 price per unit based on billing cycle
        const ipv4PricePerUnit = {
            'monthly': 6,
            'quarterly': 18,        // 6 * 3
            'semi_annually': 36,    // 6 * 6
            'annually': 72          // 6 * 12
        };
        
        const currentIpv4Price = ipv4PricePerUnit[selectedCycle] || 6;
        
        // Update price per unit display
        const pricePerUnitSpan = document.getElementById('ipv4-price-per-unit');
        if (pricePerUnitSpan) {
            pricePerUnitSpan.textContent = '× $' + currentIpv4Price.toFixed(2) + ' {{ __('frontend.per_ip') }}';
        }
        
        // Get additional IPv4 cost
        const ipv4Select = document.getElementById('additional-ipv4');
        const ipv4Count = ipv4Select ? parseInt(ipv4Select.value) : 0;
        const ipv4Cost = ipv4Count * currentIpv4Price;
        
        // Show/hide IPv4 cost row
        const ipv4CostRow = document.getElementById('ipv4-cost-row');
        if (ipv4Cost > 0) {
            ipv4CostRow.style.display = 'flex';
            document.getElementById('ipv4-cost').textContent = '$' + ipv4Cost.toFixed(2);
        } else {
            ipv4CostRow.style.display = 'none';
        }
        
        const total = price + setupFee + ipv4Cost;
        
        document.getElementById('plan-price').textContent = '$' + price.toFixed(2);
        document.getElementById('total-price').textContent = '$' + total.toFixed(2);
    }
    
    function updateIPv4Price() {
        updatePrice();
    }

    // Initialize price
    document.addEventListener('DOMContentLoaded', function() {
        updatePrice();
        
        // Disk Configuration selection handling
        const diskOptions = document.querySelectorAll('.disk-config-option');
        diskOptions.forEach(option => {
            option.addEventListener('click', function() {
                const radio = this.querySelector('.disk-config-radio');
                const box = this.querySelector('.disk-config-box');
                const indicator = this.querySelector('.disk-config-indicator');
                const dot = this.querySelector('.disk-config-dot');
                
                // Remove selection from all options
                document.querySelectorAll('.disk-config-box').forEach(b => {
                    b.classList.remove('border-blue-500', 'bg-blue-50', 'from-blue-50', 'to-blue-100');
                    b.classList.add('border-slate-200', 'from-white', 'to-slate-50');
                });
                document.querySelectorAll('.disk-config-indicator').forEach(i => {
                    i.classList.remove('border-blue-500', 'bg-blue-500');
                    i.classList.add('border-slate-300', 'bg-white');
                });
                document.querySelectorAll('.disk-config-icon').forEach(icon => {
                    icon.classList.remove('text-white');
                    icon.classList.add('text-slate-400');
                });
                
                // Add selection to clicked option
                radio.checked = true;
                box.classList.remove('border-slate-200', 'from-white', 'to-slate-50');
                box.classList.add('border-blue-500', 'bg-blue-50', 'from-blue-50', 'to-blue-100');
                indicator.classList.remove('border-slate-300', 'bg-white');
                indicator.classList.add('border-blue-500', 'bg-blue-500');
                const icon = this.querySelector('.disk-config-icon');
                if (icon) {
                    icon.classList.remove('text-slate-400');
                    icon.classList.add('text-white');
                }
            });
        });
        
        // OS and App mutual exclusivity
        const osSelect = document.getElementById('os-select');
        const appSelect = document.getElementById('app-select');
        
        if (osSelect && appSelect) {
            osSelect.addEventListener('change', function() {
                // If OS is selected, clear App selection
                if (this.value && appSelect.value) {
                    appSelect.value = '';
                }
                // Make OS required only if no app is selected
                if (!this.value && !appSelect.value) {
                    this.required = true;
                } else {
                    this.required = false;
                }
            });
            
            appSelect.addEventListener('change', function() {
                // If App is selected, clear OS selection
                if (this.value && osSelect.value) {
                    osSelect.value = '';
                }
                // Make OS required only if no app is selected
                if (this.value) {
                    osSelect.required = false;
                } else {
                    osSelect.required = true;
                }
            });
            
            // Form validation before submit
            const form = document.getElementById('configure-form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const osValue = osSelect.value;
                    const appValue = appSelect.value;
                    const hostnameInput = document.getElementById('hostname');
                    const hostname = hostnameInput ? hostnameInput.value.trim() : '';
                    
                    // Check hostname is subdomain (must have at least 2 dots)
                    if (hostname) {
                        const parts = hostname.split('.');
                        if (parts.length < 3) {
                            e.preventDefault();
                            showToast('{{ __('frontend.hostname_must_be_subdomain') }}');
                            hostnameInput.focus();
                            hostnameInput.classList.add('border-red-500');
                            setTimeout(() => {
                                hostnameInput.classList.remove('border-red-500');
                            }, 3000);
                            return false;
                        }
                        
                        // Check each part is valid (not empty)
                        const isValid = parts.every(part => part.length > 0 && /^[a-zA-Z0-9-]+$/.test(part));
                        if (!isValid) {
                            e.preventDefault();
                            showToast('{{ __('frontend.hostname_invalid_format') }}');
                            hostnameInput.focus();
                            hostnameInput.classList.add('border-red-500');
                            setTimeout(() => {
                                hostnameInput.classList.remove('border-red-500');
                            }, 3000);
                            return false;
                        }
                    }
                    
                    // Check if neither OS nor App is selected
                    if (!osValue && !appValue) {
                        e.preventDefault();
                        showToast('{{ __('frontend.must_select_os_or_app') }}');
                        return false;
                    }
                    
                    // Check if both are selected
                    if (osValue && appValue) {
                        e.preventDefault();
                        showToast('{{ __('frontend.cannot_select_both_os_and_app') }}');
                        return false;
                    }
                });
            }
        }
        
        // IPv6 toggle handling
        const ipv6Option = document.querySelector('.ipv6-option');
        if (ipv6Option) {
            ipv6Option.addEventListener('click', function() {
                const checkbox = this.querySelector('.ipv6-checkbox');
                const box = this.querySelector('.ipv6-box');
                const icon = this.querySelector('.ipv6-icon');
                
                // Toggle checkbox
                checkbox.checked = !checkbox.checked;
                
                // Update visual state
                if (checkbox.checked) {
                    box.classList.remove('border-slate-200');
                    box.classList.add('border-green-500', 'bg-green-50');
                    icon.classList.remove('bg-slate-100');
                    icon.classList.add('bg-green-100');
                    icon.querySelector('svg').classList.remove('text-slate-400');
                    icon.querySelector('svg').classList.add('text-green-600');
                } else {
                    box.classList.remove('border-green-500', 'bg-green-50');
                    box.classList.add('border-slate-200');
                    icon.classList.remove('bg-green-100');
                    icon.classList.add('bg-slate-100');
                    icon.querySelector('svg').classList.remove('text-green-600');
                    icon.querySelector('svg').classList.add('text-slate-400');
                }
            });
        }
        
        // Hostname validation on input
        const hostnameInput = document.getElementById('hostname');
        if (hostnameInput) {
            hostnameInput.addEventListener('input', function() {
                const value = this.value.trim();
                if (value) {
                    const parts = value.split('.');
                    // Valid subdomain should have at least 3 parts (subdomain.domain.tld)
                    if (parts.length >= 3 && parts.every(part => part.length > 0)) {
                        this.classList.remove('border-red-500');
                        this.classList.add('border-green-500');
                    } else {
                        this.classList.remove('border-green-500');
                        this.classList.add('border-red-500');
                    }
                } else {
                    this.classList.remove('border-green-500', 'border-red-500');
                }
            });
        }
        
        // Toast Notification Functions
        function showToast(message) {
            const toast = document.getElementById('toast-notification');
            const toastMessage = document.getElementById('toast-message');
            
            toastMessage.textContent = message;
            
            // Show toast with animation
            toast.classList.remove('hidden');
            setTimeout(() => {
                toast.classList.add('opacity-100', 'translate-y-0');
            }, 10);
            
            // Auto hide after 5 seconds
            setTimeout(() => {
                hideToast();
            }, 5000);
        }
        
        function hideToast() {
            const toast = document.getElementById('toast-notification');
            toast.classList.remove('opacity-100', 'translate-y-0');
            toast.classList.add('opacity-0', '-translate-y-4');
            
            setTimeout(() => {
                toast.classList.add('hidden');
                toast.classList.remove('opacity-0', '-translate-y-4');
            }, 300);
        }
    });
</script>

<style>
    /* Scoped Responsive Styles for Dedicated Configure Page */
    /* IMPORTANT: All styles target .min-h-screen container only to avoid affecting navbar */
    
    /* Extra Small Devices - 320px to 374px */
    @media (max-width: 374px) {
        .min-h-screen .max-w-7xl {
            padding-left: 0.5rem !important;
            padding-right: 0.5rem !important;
        }
        
        /* Reduce card padding on very small screens */
        .min-h-screen .bg-white.rounded-xl,
        .min-h-screen .bg-white.rounded-2xl {
            padding: 0.75rem !important;
            border-radius: 0.75rem !important;
        }
        
        /* Smaller buttons - only in main content */
        .min-h-screen .max-w-7xl button:not([aria-controls]):not([data-dropdown-toggle]),
        .min-h-screen .max-w-7xl .btn {
            font-size: 0.75rem !important;
            padding: 0.5rem 0.75rem !important;
        }
        
        /* Reduce gaps */
        .min-h-screen .gap-8 {
            gap: 0.75rem !important;
        }
        
        /* Billing cycle cards - smaller on tiny screens */
        .min-h-screen .peer + div {
            min-height: 85px !important;
            padding: 0.5rem !important;
        }
    }
    
    /* Small Phones - 375px to 479px */
    @media (min-width: 375px) and (max-width: 479px) {
        .min-h-screen .max-w-7xl {
            padding-left: 0.75rem !important;
            padding-right: 0.75rem !important;
        }
        
        .min-h-screen .bg-white.rounded-xl,
        .min-h-screen .bg-white.rounded-2xl {
            padding: 1rem !important;
        }
        
        .min-h-screen .peer + div {
            min-height: 95px !important;
        }
    }
    
    /* Medium Phones - 480px to 639px */
    @media (min-width: 480px) and (max-width: 639px) {
        .min-h-screen .peer + div {
            min-height: 100px !important;
        }
    }
    
    /* Desktop - ensure proper max width */
    @media (min-width: 1024px) {
        .min-h-screen .max-w-7xl {
            max-width: 80rem !important;
        }
    }
    
    /* IPv6 Option States */
    .ipv6-option:hover .ipv6-box {
        border-color: #60a5fa !important;
    }
    
    .ipv6-checkbox:checked + .ipv6-box {
        border-color: #10b981 !important;
        background-color: #ecfdf5 !important;
    }
    
    .ipv6-checkbox:checked + .ipv6-box .ipv6-icon {
        background-color: #d1fae5 !important;
    }
    
    .ipv6-checkbox:checked + .ipv6-box .ipv6-icon svg {
        color: #059669 !important;
    }
    
    /* Prevent horizontal overflow on mobile */
    @media (max-width: 639px) {
        /* Target only content area, not navbar */
        .min-h-screen .max-w-7xl * {
            max-width: 100%;
        }
        
        .min-h-screen .overflow-x-auto {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        /* Ensure select dropdowns don't overflow */
        .min-h-screen .max-w-7xl select {
            max-width: 100%;
        }
        
        /* Ensure form inputs don't overflow */
        .min-h-screen .max-w-7xl input[type="text"],
        .min-h-screen .max-w-7xl input[type="email"],
        .min-h-screen .max-w-7xl textarea {
            max-width: 100%;
        }
        
        /* Responsive toast notification */
        #toast-notification {
            left: 0.5rem !important;
            right: 0.5rem !important;
            min-width: auto !important;
            max-width: calc(100vw - 1rem) !important;
        }
    }
    
    /* Extra padding fixes for very small screens */
    @media (max-width: 374px) {
        /* Reduce margins on very small screens */
        .min-h-screen .max-w-7xl .mb-6,
        .min-h-screen .max-w-7xl .mb-8 {
            margin-bottom: 1rem !important;
        }
        
        /* Smaller form labels */
        .min-h-screen label {
            font-size: 0.875rem !important;
        }
        
        /* Compact icon boxes */
        .min-h-screen .w-8.h-8,
        .min-h-screen .w-9.h-9 {
            width: 1.75rem !important;
            height: 1.75rem !important;
        }
        
        .min-h-screen .w-8.h-8 svg,
        .min-h-screen .w-9.h-9 svg {
            width: 0.875rem !important;
            height: 0.875rem !important;
        }
    }
</style>
@endpush
@endsection
