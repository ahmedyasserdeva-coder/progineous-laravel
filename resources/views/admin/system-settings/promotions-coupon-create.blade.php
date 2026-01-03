@extends('admin.layout')

@section('title', __('crm.create_coupon'))

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white">
                    {{ __('crm.create_coupon') }}
                </h1>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                    {{ __('crm.create_discount_coupon_description') }}
                </p>
            </div>
            <a href="{{ route('admin.system-settings.promotions') }}" 
               class="flex items-center space-x-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>{{ __('crm.back') }}</span>
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800" x-data="{ 
        applyToAll: true,
        showSharedHosting: false,
        showCloudHosting: false,
        showResellerHosting: false,
        showVPS: false,
        showDedicated: false,
        showDomains: false,
        generateCouponCode() {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let code = '';
            for (let i = 0; i < 10; i++) {
                code += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            document.getElementById('coupon_code').value = code;
        }
    }">
        <form action="{{ route('admin.system-settings.promotions.coupons.store') }}" method="POST" class="p-8 space-y-8">
            @csrf

            <!-- Section 1: Basic Information -->
            <div class="bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-800/50 dark:to-slate-800/30 rounded-xl p-6 border border-slate-200 dark:border-slate-700">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 rounded-lg bg-blue-500 flex items-center justify-center {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">{{ __('crm.basic_information') }}</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ __('crm.coupon_basic_info_desc') }}</p>
                    </div>
                </div>

                <div class="space-y-5">
                    <!-- Coupon Code -->
                    <div>
                        <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
                            <svg class="w-4 h-4 text-blue-500 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            {{ __('crm.coupon_code') }} <span class="text-red-500 {{ app()->getLocale() == 'ar' ? 'mr-1' : 'ml-1' }}">*</span>
                        </label>
                        <div class="flex gap-3">
                            <div class="flex-1 relative">
                                <input type="text" 
                                       name="code"
                                       id="coupon_code"
                                       required
                                       class="w-full px-4 py-3 {{ app()->getLocale() == 'ar' ? 'pr-10' : 'pl-4' }} rounded-xl border-2 border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-blue-500 transition-all uppercase font-mono text-lg tracking-wider"
                                       placeholder="SAVE20">
                                <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-0 pl-3' : 'right-0 pr-3' }} flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                    </svg>
                                </div>
                            </div>
                            <button type="button"
                                    @click="generateCouponCode()"
                                    class="px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2 whitespace-nowrap font-semibold transform hover:scale-105">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                </svg>
                                <span>{{ __('crm.generate') }}</span>
                            </button>
                        </div>
                        <p class="mt-2 text-xs text-slate-500 dark:text-slate-400 flex items-center">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-1.5' : 'mr-1.5' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ __('crm.coupon_code_help') }}
                        </p>
                    </div>

                    <!-- Discount Type & Value (Grid) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Discount Type -->
                        <div>
                            <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
                                <svg class="w-4 h-4 text-green-500 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                                {{ __('crm.discount_type') }} <span class="text-red-500 {{ app()->getLocale() == 'ar' ? 'mr-1' : 'ml-1' }}">*</span>
                            </label>
                            <div class="relative">
                                <select name="type" 
                                        required
                                        class="w-full px-4 py-3 {{ app()->getLocale() == 'ar' ? 'pl-10' : 'pr-10' }} rounded-xl border-2 border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-blue-500 transition-all appearance-none cursor-pointer font-medium">
                                    <option value="percentage">{{ __('crm.percentage') }} (%)</option>
                                    <option value="fixed">{{ __('crm.fixed_amount') }} ({{  __('crm.currency') }})</option>
                                </select>
                                <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-0 pl-3' : 'right-0 pr-3' }} flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Discount Value -->
                        <div>
                            <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
                                <svg class="w-4 h-4 text-amber-500 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ __('crm.discount_value') }} <span class="text-red-500 {{ app()->getLocale() == 'ar' ? 'mr-1' : 'ml-1' }}">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       name="value" 
                                       required
                                       step="0.01"
                                       min="0"
                                       class="w-full px-4 py-3 {{ app()->getLocale() == 'ar' ? 'pr-10' : 'pl-4' }} rounded-xl border-2 border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-blue-500 transition-all font-semibold text-lg"
                                       placeholder="20">
                                <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-0 pl-3' : 'right-0 pr-3' }} flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Restrictions & Limits -->
            <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/10 rounded-xl p-6 border border-amber-200 dark:border-amber-800">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 rounded-lg bg-amber-500 flex items-center justify-center {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">{{ __('crm.restrictions_limits') }}</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ __('crm.set_usage_restrictions') }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <!-- Min Order Value -->
                    <div>
                        <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
                            <svg class="w-4 h-4 text-blue-500 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            {{ __('crm.min_order_value') }}
                        </label>
                        <div class="relative">
                            <input type="number" 
                                   name="min_order" 
                                   step="0.01"
                                   min="0"
                                   class="w-full px-4 py-3 {{ app()->getLocale() == 'ar' ? 'pr-10' : 'pl-4' }} rounded-xl border-2 border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-blue-500 transition-all"
                                   placeholder="0">
                            <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-0 pl-3' : 'right-0 pr-3' }} flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="mt-1.5 text-xs text-slate-500 dark:text-slate-400">{{ __('crm.min_order_help') }}</p>
                    </div>

                    <!-- Max Uses -->
                    <div>
                        <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
                            <svg class="w-4 h-4 text-purple-500 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                            </svg>
                            {{ __('crm.max_uses') }}
                        </label>
                        <div class="relative">
                            <input type="number" 
                                   name="max_uses" 
                                   min="0"
                                   class="w-full px-4 py-3 {{ app()->getLocale() == 'ar' ? 'pr-10' : 'pl-4' }} rounded-xl border-2 border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-blue-500 transition-all"
                                   placeholder="{{ __('crm.unlimited') }}">
                            <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-0 pl-3' : 'right-0 pr-3' }} flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                            </div>
                        </div>
                        <p class="mt-1.5 text-xs text-slate-500 dark:text-slate-400">{{ __('crm.max_uses_help') }}</p>
                    </div>

                    <!-- Expiry Date -->
                    <div>
                        <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
                            <svg class="w-4 h-4 text-red-500 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ __('crm.expiry_date') }}
                        </label>
                        <div class="relative">
                            <input type="date" 
                                   name="expires_at"
                                   min="{{ date('Y-m-d') }}"
                                   class="w-full px-4 py-3 {{ app()->getLocale() == 'ar' ? 'pr-10' : 'pl-4' }} rounded-xl border-2 border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-blue-500 transition-all">
                            <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-0 pl-3' : 'right-0 pr-3' }} flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="mt-1.5 text-xs text-slate-500 dark:text-slate-400">{{ __('crm.expiry_date_help') }}</p>
                    </div>
                </div>
            </div>

            <!-- Section 3: Applicable Products -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/10 rounded-xl p-6 border border-blue-200 dark:border-blue-800">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 rounded-lg bg-blue-500 flex items-center justify-center {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">{{ __('crm.applicable_products') }}</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ __('crm.select_products_for_coupon') }}</p>
                    </div>
                </div>
                
                <!-- Apply to All Products Toggle -->
                <div class="mb-6">
                    <label class="relative inline-flex items-center cursor-pointer group">
                        <input type="checkbox" 
                               name="apply_to_all" 
                               id="apply_to_all"
                               value="1"
                               checked
                               x-model="applyToAll"
                               class="sr-only peer">
                        <div class="w-14 h-7 bg-slate-300 dark:bg-slate-700 rounded-full peer peer-checked:after:translate-x-full {{ app()->getLocale() == 'ar' ? 'peer-checked:after:-translate-x-full' : '' }} rtl:peer-checked:after:-translate-x-full peer-checked:bg-gradient-to-r peer-checked:from-green-500 peer-checked:to-emerald-600 after:content-[''] after:absolute after:top-0.5 {{ app()->getLocale() == 'ar' ? 'after:right-[4px]' : 'after:left-[4px]' }} after:bg-white after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:after:shadow-lg"></div>
                        <span class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} text-sm font-bold text-slate-900 dark:text-white flex items-center">
                            <svg class="w-4 h-4 text-green-500 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ __('crm.apply_to_all_products') }}
                        </span>
                    </label>
                    <p class="mt-2 text-xs text-slate-500 dark:text-slate-400 {{ app()->getLocale() == 'ar' ? 'mr-[68px]' : 'ml-[68px]' }}">
                        {{ __('crm.apply_to_all_products_help') }}
                    </p>
                </div>

                <!-- Product Categories (shown when not applying to all) -->
                <div x-show="!applyToAll" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     class="space-y-4">
                    
                    @if($sharedHosting->count() > 0)
                    <!-- Shared Hosting -->
                    <div class="bg-white dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-700 rounded-xl overflow-hidden hover:border-blue-400 dark:hover:border-blue-600 transition-all duration-300">
                        <div class="flex items-center justify-between p-5 bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/30 dark:to-cyan-900/20 cursor-pointer group" @click="showSharedHosting = !showSharedHosting">
                            <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-3">
                                <div class="w-10 h-10 rounded-lg bg-blue-500 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-sm font-bold text-slate-900 dark:text-white">{{ __('crm.shared_hosting') }}</span>
                                    <span class="{{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }} px-2 py-0.5 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 text-xs font-semibold rounded-full">{{ $sharedHosting->count() }}</span>
                                </div>
                            </div>
                            <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2">
                                <span class="text-xs text-slate-500 dark:text-slate-400 font-medium" x-show="!showSharedHosting">{{ __('crm.expand') }}</span>
                                <span class="text-xs text-slate-500 dark:text-slate-400 font-medium" x-show="showSharedHosting">{{ __('crm.collapse') }}</span>
                                <svg class="w-4 h-4 text-slate-500 transition-transform duration-300" :class="showSharedHosting ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                        <div x-show="showSharedHosting" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="p-5 space-y-3 bg-slate-50/50 dark:bg-slate-800/50">
                            @foreach($sharedHosting as $product)
                            <label class="flex items-center p-3 bg-white dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-700 hover:border-blue-400 dark:hover:border-blue-600 hover:shadow-md transition-all cursor-pointer group">
                                <input type="checkbox" 
                                       name="products[]" 
                                       value="hosting_{{ $product->id }}"
                                       id="product_{{ $product->id }}"
                                       class="w-5 h-5 text-blue-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                                    <span class="text-sm font-semibold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400">{{ $product->name }}</span>
                                    <span class="{{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }} px-2 py-0.5 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-xs rounded">{{ $product->billing_cycle }}</span>
                                </div>
                                <svg class="w-5 h-5 text-blue-500 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($cloudHosting->count() > 0)
                    <!-- Cloud Hosting -->
                    <div class="bg-white dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-700 rounded-xl overflow-hidden hover:border-cyan-400 dark:hover:border-cyan-600 transition-all duration-300">
                        <div class="flex items-center justify-between p-5 bg-gradient-to-r from-cyan-50 to-sky-50 dark:from-cyan-900/30 dark:to-sky-900/20 cursor-pointer group" @click="showCloudHosting = !showCloudHosting">
                            <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-3">
                                <div class="w-10 h-10 rounded-lg bg-cyan-500 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-sm font-bold text-slate-900 dark:text-white">{{ __('crm.cloud_hosting') }}</span>
                                    <span class="{{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }} px-2 py-0.5 bg-cyan-100 dark:bg-cyan-900 text-cyan-700 dark:text-cyan-300 text-xs font-semibold rounded-full">{{ $cloudHosting->count() }}</span>
                                </div>
                            </div>
                            <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2">
                                <span class="text-xs text-slate-500 dark:text-slate-400 font-medium" x-show="!showCloudHosting">{{ __('crm.expand') }}</span>
                                <span class="text-xs text-slate-500 dark:text-slate-400 font-medium" x-show="showCloudHosting">{{ __('crm.collapse') }}</span>
                                <svg class="w-4 h-4 text-slate-500 transition-transform duration-300" :class="showCloudHosting ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                        <div x-show="showCloudHosting" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="p-5 space-y-3 bg-slate-50/50 dark:bg-slate-800/50">
                            @foreach($cloudHosting as $product)
                            <label class="flex items-center p-3 bg-white dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-700 hover:border-cyan-400 dark:hover:border-cyan-600 hover:shadow-md transition-all cursor-pointer group">
                                <input type="checkbox" 
                                       name="products[]" 
                                       value="hosting_{{ $product->id }}"
                                       id="product_cloud_{{ $product->id }}"
                                       class="w-5 h-5 text-cyan-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-cyan-500">
                                <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                                    <span class="text-sm font-semibold text-slate-900 dark:text-white group-hover:text-cyan-600 dark:group-hover:text-cyan-400">{{ $product->name }}</span>
                                    <span class="{{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }} px-2 py-0.5 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-xs rounded">{{ $product->billing_cycle }}</span>
                                </div>
                                <svg class="w-5 h-5 text-cyan-500 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($resellerHosting->count() > 0)
                    <!-- Reseller Hosting -->
                    <div class="bg-white dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-700 rounded-xl overflow-hidden hover:border-green-400 dark:hover:border-green-600 transition-all duration-300">
                        <div class="flex items-center justify-between p-5 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/20 cursor-pointer group" @click="showResellerHosting = !showResellerHosting">
                            <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-3">
                                <div class="w-10 h-10 rounded-lg bg-green-500 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-sm font-bold text-slate-900 dark:text-white">{{ __('crm.reseller_hosting') }}</span>
                                    <span class="{{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }} px-2 py-0.5 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 text-xs font-semibold rounded-full">{{ $resellerHosting->count() }}</span>
                                </div>
                            </div>
                            <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2">
                                <span class="text-xs text-slate-500 dark:text-slate-400 font-medium" x-show="!showResellerHosting">{{ __('crm.expand') }}</span>
                                <span class="text-xs text-slate-500 dark:text-slate-400 font-medium" x-show="showResellerHosting">{{ __('crm.collapse') }}</span>
                                <svg class="w-4 h-4 text-slate-500 transition-transform duration-300" :class="showResellerHosting ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                        <div x-show="showResellerHosting" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="p-5 space-y-3 bg-slate-50/50 dark:bg-slate-800/50">
                            @foreach($resellerHosting as $product)
                            <label class="flex items-center p-3 bg-white dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-700 hover:border-green-400 dark:hover:border-green-600 hover:shadow-md transition-all cursor-pointer group">
                                <input type="checkbox" 
                                       name="products[]" 
                                       value="hosting_{{ $product->id }}"
                                       id="product_reseller_{{ $product->id }}"
                                       class="w-5 h-5 text-green-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-green-500">
                                <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                                    <span class="text-sm font-semibold text-slate-900 dark:text-white group-hover:text-green-600 dark:group-hover:text-green-400">{{ $product->name }}</span>
                                    <span class="{{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }} px-2 py-0.5 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-xs rounded">{{ $product->billing_cycle }}</span>
                                </div>
                                <svg class="w-5 h-5 text-green-500 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($vpsPlans->count() > 0)
                    <!-- VPS Plans -->
                    <div class="bg-white dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-700 rounded-xl overflow-hidden hover:border-indigo-400 dark:hover:border-indigo-600 transition-all duration-300">
                        <div class="flex items-center justify-between p-5 bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/30 dark:to-purple-900/20 cursor-pointer group" @click="showVPS = !showVPS">
                            <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-3">
                                <div class="w-10 h-10 rounded-lg bg-indigo-500 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-sm font-bold text-slate-900 dark:text-white">{{ __('crm.vps_plans') }}</span>
                                    <span class="{{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }} px-2 py-0.5 bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300 text-xs font-semibold rounded-full">{{ $vpsPlans->count() }}</span>
                                </div>
                            </div>
                            <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2">
                                <span class="text-xs text-slate-500 dark:text-slate-400 font-medium" x-show="!showVPS">{{ __('crm.expand') }}</span>
                                <span class="text-xs text-slate-500 dark:text-slate-400 font-medium" x-show="showVPS">{{ __('crm.collapse') }}</span>
                                <svg class="w-4 h-4 text-slate-500 transition-transform duration-300" :class="showVPS ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                        <div x-show="showVPS" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="p-5 space-y-3 bg-slate-50/50 dark:bg-slate-800/50">
                            @foreach($vpsPlans as $plan)
                            <label class="flex items-center p-3 bg-white dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-700 hover:border-indigo-400 dark:hover:border-indigo-600 hover:shadow-md transition-all cursor-pointer group">
                                <input type="checkbox" 
                                       name="products[]" 
                                       value="vps-{{ $plan->id }}"
                                       id="product_vps_{{ $plan->id }}"
                                       class="w-5 h-5 text-indigo-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                                    <span class="text-sm font-semibold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400">{{ $plan->plan_name }}</span>
                                    <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2 mt-1">
                                        <span class="px-2 py-0.5 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-xs rounded">
                                            <svg class="w-3 h-3 inline {{ app()->getLocale() == 'ar' ? 'ml-1' : 'mr-1' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                                            </svg>
                                            {{ $plan->vcpu_count }} vCPU
                                        </span>
                                        <span class="px-2 py-0.5 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-xs rounded">
                                            <svg class="w-3 h-3 inline {{ app()->getLocale() == 'ar' ? 'ml-1' : 'mr-1' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                                            </svg>
                                            {{ $plan->ram_gb }} GB RAM
                                        </span>
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-indigo-500 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($dedicatedPlans->count() > 0)
                    <!-- Dedicated Server -->
                    <div class="bg-white dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-700 rounded-xl overflow-hidden hover:border-purple-400 dark:hover:border-purple-600 transition-all duration-300">
                        <div class="flex items-center justify-between p-5 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/30 dark:to-pink-900/20 cursor-pointer group" @click="showDedicated = !showDedicated">
                            <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-3">
                                <div class="w-10 h-10 rounded-lg bg-purple-500 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-sm font-bold text-slate-900 dark:text-white">{{ __('crm.dedicated_server') }}</span>
                                    <span class="{{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }} px-2 py-0.5 bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300 text-xs font-semibold rounded-full">{{ $dedicatedPlans->count() }}</span>
                                </div>
                            </div>
                            <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2">
                                <span class="text-xs text-slate-500 dark:text-slate-400 font-medium" x-show="!showDedicated">{{ __('crm.expand') }}</span>
                                <span class="text-xs text-slate-500 dark:text-slate-400 font-medium" x-show="showDedicated">{{ __('crm.collapse') }}</span>
                                <svg class="w-4 h-4 text-slate-500 transition-transform duration-300" :class="showDedicated ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                        <div x-show="showDedicated" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="p-5 space-y-3 bg-slate-50/50 dark:bg-slate-800/50">
                            @foreach($dedicatedPlans as $plan)
                            <label class="flex items-center p-3 bg-white dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-700 hover:border-purple-400 dark:hover:border-purple-600 hover:shadow-md transition-all cursor-pointer group">
                                <input type="checkbox" 
                                       name="products[]" 
                                       value="dedicated-{{ $plan->id }}"
                                       id="product_dedicated_{{ $plan->id }}"
                                       class="w-5 h-5 text-purple-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-purple-500">
                                <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                                    <span class="text-sm font-semibold text-slate-900 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400">{{ $plan->plan_name }}</span>
                                    <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2 mt-1">
                                        <span class="px-2 py-0.5 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-xs rounded">
                                            <svg class="w-3 h-3 inline {{ app()->getLocale() == 'ar' ? 'ml-1' : 'mr-1' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                                            </svg>
                                            {{ $plan->cpu_count }} CPU
                                        </span>
                                        <span class="px-2 py-0.5 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-xs rounded">
                                            <svg class="w-3 h-3 inline {{ app()->getLocale() == 'ar' ? 'ml-1' : 'mr-1' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                                            </svg>
                                            {{ $plan->ram_gb }} GB RAM
                                        </span>
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-purple-500 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($domainPricing->count() > 0)
                    <!-- Domain Registration -->
                    <div class="bg-white dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-700 rounded-xl overflow-hidden hover:border-pink-400 dark:hover:border-pink-600 transition-all duration-300">
                        <div class="flex items-center justify-between p-5 bg-gradient-to-r from-pink-50 to-rose-50 dark:from-pink-900/30 dark:to-rose-900/20 cursor-pointer group" @click="showDomains = !showDomains">
                            <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-3">
                                <div class="w-10 h-10 rounded-lg bg-pink-500 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-sm font-bold text-slate-900 dark:text-white">{{ __('crm.domain_registration') }}</span>
                                    <span class="{{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }} px-2 py-0.5 bg-pink-100 dark:bg-pink-900 text-pink-700 dark:text-pink-300 text-xs font-semibold rounded-full">{{ $domainPricing->count() }}</span>
                                </div>
                            </div>
                            <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2">
                                <span class="text-xs text-slate-500 dark:text-slate-400 font-medium" x-show="!showDomains">{{ __('crm.expand') }}</span>
                                <span class="text-xs text-slate-500 dark:text-slate-400 font-medium" x-show="showDomains">{{ __('crm.collapse') }}</span>
                                <svg class="w-4 h-4 text-slate-500 transition-transform duration-300" :class="showDomains ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                        <div x-show="showDomains" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="p-5 space-y-3 bg-slate-50/50 dark:bg-slate-800/50 max-h-96 overflow-y-auto">
                            @foreach($domainPricing as $domain)
                            <label class="flex items-center p-3 bg-white dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-700 hover:border-pink-400 dark:hover:border-pink-600 hover:shadow-md transition-all cursor-pointer group">
                                <input type="checkbox" 
                                       name="products[]" 
                                       value="domain-{{ $domain->id }}"
                                       id="product_domain_{{ $domain->id }}"
                                       class="w-5 h-5 text-pink-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-pink-500">
                                <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                                    <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2">
                                        <span class="text-sm font-semibold font-mono text-slate-900 dark:text-white group-hover:text-pink-600 dark:group-hover:text-pink-400">.{{ $domain->tld }}</span>
                                        @if($domain->is_featured)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-gradient-to-r from-yellow-400 to-orange-500 text-white">
                                                <svg class="w-3 h-3 {{ app()->getLocale() == 'ar' ? 'ml-1' : 'mr-1' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                                {{ __('crm.featured') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-pink-500 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                </div>

                <p class="text-xs text-slate-500 dark:text-slate-400">
                    {{ __('crm.coupon_products_help') }}
                </p>
            </div>

            <!-- Section 3.5: Billing Cycles -->
            <div class="bg-gradient-to-br from-teal-50 to-cyan-50 dark:from-teal-900/20 dark:to-cyan-900/10 rounded-xl p-6 border border-teal-200 dark:border-teal-800">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 rounded-lg bg-teal-500 flex items-center justify-center {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">{{ __('crm.applicable_billing_cycles') }}</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ __('crm.select_billing_periods') }}</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    <!-- Monthly -->
                    <label class="flex items-center p-4 bg-white dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-700 rounded-xl hover:border-teal-400 dark:hover:border-teal-600 hover:shadow-md transition-all cursor-pointer group">
                        <input type="checkbox" 
                               name="billing_cycles[]" 
                               value="monthly"
                               id="cycle_monthly"
                               checked
                               class="w-5 h-5 text-teal-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-teal-500">
                        <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                            <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-1.5">
                                <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ __('crm.monthly') }}</span>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-teal-500 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </label>

                    <!-- Quarterly -->
                    <label class="flex items-center p-4 bg-white dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-700 rounded-xl hover:border-teal-400 dark:hover:border-teal-600 hover:shadow-md transition-all cursor-pointer group">
                        <input type="checkbox" 
                               name="billing_cycles[]" 
                               value="quarterly"
                               id="cycle_quarterly"
                               checked
                               class="w-5 h-5 text-teal-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-teal-500">
                        <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                            <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-1.5">
                                <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ __('crm.quarterly') }}</span>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-teal-500 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </label>

                    <!-- Semi-Annually -->
                    <label class="flex items-center p-4 bg-white dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-700 rounded-xl hover:border-teal-400 dark:hover:border-teal-600 hover:shadow-md transition-all cursor-pointer group">
                        <input type="checkbox" 
                               name="billing_cycles[]" 
                               value="semi-annually"
                               id="cycle_semi_annually"
                               checked
                               class="w-5 h-5 text-teal-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-teal-500">
                        <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                            <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-1.5">
                                <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ __('crm.semi_annually') }}</span>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-teal-500 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </label>

                    <!-- Annually -->
                    <label class="flex items-center p-4 bg-white dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-700 rounded-xl hover:border-teal-400 dark:hover:border-teal-600 hover:shadow-md transition-all cursor-pointer group">
                        <input type="checkbox" 
                               name="billing_cycles[]" 
                               value="annually"
                               id="cycle_annually"
                               checked
                               class="w-5 h-5 text-teal-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-teal-500">
                        <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                            <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-1.5">
                                <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ __('crm.annually') }}</span>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-teal-500 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </label>

                    <!-- Biennially -->
                    <label class="flex items-center p-4 bg-white dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-700 rounded-xl hover:border-teal-400 dark:hover:border-teal-600 hover:shadow-md transition-all cursor-pointer group">
                        <input type="checkbox" 
                               name="billing_cycles[]" 
                               value="biennially"
                               id="cycle_biennially"
                               checked
                               class="w-5 h-5 text-teal-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-teal-500">
                        <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                            <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-1.5">
                                <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ __('crm.biennially') }}</span>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-teal-500 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </label>

                    <!-- Triennially -->
                    <label class="flex items-center p-4 bg-white dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-700 rounded-xl hover:border-teal-400 dark:hover:border-teal-600 hover:shadow-md transition-all cursor-pointer group">
                        <input type="checkbox" 
                               name="billing_cycles[]" 
                               value="triennially"
                               id="cycle_triennially"
                               checked
                               class="w-5 h-5 text-teal-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-teal-500">
                        <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                            <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-1.5">
                                <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ __('crm.triennially') }}</span>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-teal-500 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </label>
                </div>

                <div class="mt-4 p-3 bg-teal-50 dark:bg-teal-900/10 border border-teal-200 dark:border-teal-800 rounded-lg">
                    <p class="text-xs text-slate-600 dark:text-slate-400 flex items-center">
                        <svg class="w-4 h-4 text-teal-500 {{ app()->getLocale() == 'ar' ? 'ml-1.5' : 'mr-1.5' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ __('crm.coupon_billing_cycles_help') }}
                    </p>
                </div>
            </div>

            <!-- Section 4: Customer Eligibility -->
            <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/10 rounded-xl p-6 border border-purple-200 dark:border-purple-800">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 rounded-lg bg-purple-500 flex items-center justify-center {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">{{ __('crm.customer_eligibility') }}</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ __('crm.define_who_can_use_coupon') }}</p>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <!-- All Customers -->
                    <label class="block cursor-pointer group">
                        <div class="flex items-start p-5 border-2 border-slate-200 dark:border-slate-700 rounded-xl hover:border-blue-400 dark:hover:border-blue-600 transition-all bg-white dark:bg-slate-900 group-hover:shadow-lg">
                            <input type="radio" 
                                   name="customer_type" 
                                   value="all"
                                   id="customer_all"
                                   checked
                                   class="w-5 h-5 mt-0.5 text-blue-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 focus:ring-2 focus:ring-blue-500">
                            <div class="{{ app()->getLocale() == 'ar' ? 'mr-4' : 'ml-4' }} flex-1">
                                <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2 mb-1">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="text-sm font-bold text-slate-900 dark:text-white">{{ __('crm.all_customers') }}</span>
                                </div>
                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    {{ __('crm.all_customers_desc') }}
                                </p>
                            </div>
                            <svg class="w-5 h-5 text-blue-500 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </label>

                    <!-- New Customers Only -->
                    <label class="block cursor-pointer group">
                        <div class="flex items-start p-5 border-2 border-slate-200 dark:border-slate-700 rounded-xl hover:border-green-400 dark:hover:border-green-600 transition-all bg-white dark:bg-slate-900 group-hover:shadow-lg">
                            <input type="radio" 
                                   name="customer_type" 
                                   value="new"
                                   id="customer_new"
                                   class="w-5 h-5 mt-0.5 text-green-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 focus:ring-2 focus:ring-green-500">
                            <div class="{{ app()->getLocale() == 'ar' ? 'mr-4' : 'ml-4' }} flex-1">
                                <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2 mb-1">
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                    </svg>
                                    <span class="text-sm font-bold text-slate-900 dark:text-white">{{ __('crm.new_customers_only') }}</span>
                                </div>
                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    {{ __('crm.new_customers_only_desc') }}
                                </p>
                            </div>
                            <svg class="w-5 h-5 text-green-500 text-xl opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </label>

                    <!-- Existing Customers Only -->
                    <label class="block cursor-pointer group">
                        <div class="flex items-start p-5 border-2 border-slate-200 dark:border-slate-700 rounded-xl hover:border-purple-400 dark:hover:border-purple-600 transition-all bg-white dark:bg-slate-900 group-hover:shadow-lg">
                            <input type="radio" 
                                   name="customer_type" 
                                   value="existing"
                                   id="customer_existing"
                                   class="w-5 h-5 mt-0.5 text-purple-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 focus:ring-2 focus:ring-purple-500">
                            <div class="{{ app()->getLocale() == 'ar' ? 'mr-4' : 'ml-4' }} flex-1">
                                <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2 mb-1">
                                    <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                    </svg>
                                    <span class="text-sm font-bold text-slate-900 dark:text-white">{{ __('crm.existing_customers_only') }}</span>
                                </div>
                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    {{ __('crm.existing_customers_only_desc') }}
                                </p>
                            </div>
                            <svg class="w-5 h-5 text-purple-500 text-xl opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Section 5: Specific Customer Selection -->
            <div class="bg-gradient-to-br from-indigo-50 to-blue-50 dark:from-indigo-900/20 dark:to-blue-900/10 rounded-xl p-6 border border-indigo-200 dark:border-indigo-800">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 rounded-lg bg-indigo-500 flex items-center justify-center {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">
                            {{ __('crm.specific_customer') }}
                            <span class="text-xs font-normal text-slate-500 dark:text-slate-400 {{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }}">({{ __('crm.optional') }})</span>
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ __('crm.assign_coupon_to_specific_customer') }}</p>
                    </div>
                </div>
                
                <div class="relative">
                    <select name="specific_customer_id" 
                            id="specific_customer_select"
                            class="w-full px-4 py-4 rounded-xl border-2 border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-600 focus:border-indigo-500 transition-all font-medium">
                        <option value="">{{ __('crm.search_customer_placeholder') }}</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" 
                                    data-email="{{ $customer->email }}"
                                    data-name="{{ $customer->full_name }}">
                                {{ $customer->full_name }} - {{ $customer->email }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mt-5 p-4 bg-gradient-to-r from-yellow-50 to-amber-50 dark:from-yellow-900/20 dark:to-amber-900/10 border-2 border-yellow-200 dark:border-yellow-800 rounded-xl">
                    <div class="flex items-start {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-3">
                        <div class="w-9 h-9 rounded-lg bg-yellow-500 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-slate-900 dark:text-white mb-1.5 flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2">
                                <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                                <span>{{ __('crm.optional_field') }}</span>
                            </p>
                            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                                {{ __('crm.leave_empty_for_all_customers') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 6: Usage Restrictions -->
            <div class="bg-gradient-to-br from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-900/10 rounded-xl p-6 border border-red-200 dark:border-red-800">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 rounded-lg bg-red-500 flex items-center justify-center {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">{{ __('crm.usage_restrictions') }}</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ __('crm.set_coupon_usage_limits') }}</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Apply once per order -->
                    <label class="flex items-start p-5 bg-white dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-700 rounded-xl hover:border-amber-400 dark:hover:border-amber-600 hover:shadow-lg transition-all cursor-pointer group">
                        <input type="checkbox" 
                               name="once_per_order" 
                               id="once_per_order"
                               value="1"
                               class="w-5 h-5 mt-0.5 text-amber-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-amber-500">
                        <div class="{{ app()->getLocale() == 'ar' ? 'mr-4' : 'ml-4' }} flex-1">
                            <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2 mb-1">
                                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <span class="text-sm font-bold text-slate-900 dark:text-white">{{ __('crm.apply_once_per_order') }}</span>
                            </div>
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                {{ __('crm.apply_once_per_order_desc') }}
                            </p>
                        </div>
                        <svg class="w-5 h-5 text-amber-500 text-lg opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </label>

                    <!-- Apply once per client globally -->
                    <label class="flex items-start p-5 bg-white dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-700 rounded-xl hover:border-rose-400 dark:hover:border-rose-600 hover:shadow-lg transition-all cursor-pointer group">
                        <input type="checkbox" 
                               name="once_per_client" 
                               id="once_per_client"
                               value="1"
                               class="w-5 h-5 mt-0.5 text-rose-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-rose-500">
                        <div class="{{ app()->getLocale() == 'ar' ? 'mr-4' : 'ml-4' }} flex-1">
                            <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2 mb-1">
                                <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                <span class="text-sm font-bold text-slate-900 dark:text-white">{{ __('crm.apply_once_per_client') }}</span>
                            </div>
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                {{ __('crm.apply_once_per_client_desc') }}
                            </p>
                        </div>
                        <svg class="w-5 h-5 text-rose-500 text-lg opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </label>
                </div>
            </div>

            <!-- Section 7: Additional Information -->
            <div class="bg-gradient-to-br from-slate-50 to-gray-100 dark:from-slate-800/50 dark:to-slate-800/30 rounded-xl p-6 border border-slate-200 dark:border-slate-700">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 rounded-lg bg-slate-500 flex items-center justify-center {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">{{ __('crm.additional_information') }}</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ __('crm.optional_coupon_details') }}</p>
                    </div>
                </div>

                <div class="space-y-5">
                    <!-- Description -->
                    <div>
                        <label class="flex items-center text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
                            <svg class="w-4 h-4 text-slate-500 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                            </svg>
                            {{ __('crm.description') }}
                        </label>
                        <textarea name="description" 
                                  rows="4"
                                  class="w-full px-4 py-3 rounded-xl border-2 border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-blue-500 transition-all resize-none"
                                  placeholder="{{ __('crm.coupon_description_placeholder') }}"></textarea>
                        <p class="mt-2 text-xs text-slate-500 dark:text-slate-400 flex items-center">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-1.5' : 'mr-1.5' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                            {{ __('crm.description_help') }}
                        </p>
                    </div>

                    <!-- Active Status Toggle -->
                    <div class="p-5 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/10 border-2 border-green-200 dark:border-green-800 rounded-xl">
                        <label class="flex items-center justify-between cursor-pointer group">
                            <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-3">
                                <div class="w-10 h-10 rounded-lg bg-green-500 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-sm font-bold text-slate-900 dark:text-white">{{ __('crm.active_status') }}</span>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ __('crm.activate_coupon_immediately') }}</p>
                                </div>
                            </div>
                            <div class="relative">
                                <input type="checkbox" 
                                       name="is_active" 
                                       id="is_active"
                                       value="1"
                                       checked
                                       class="sr-only peer">
                                <div class="w-14 h-7 bg-slate-300 dark:bg-slate-700 rounded-full peer peer-checked:after:translate-x-full {{ app()->getLocale() == 'ar' ? 'peer-checked:after:-translate-x-full' : '' }} rtl:peer-checked:after:-translate-x-full peer-checked:bg-gradient-to-r peer-checked:from-green-500 peer-checked:to-emerald-600 after:content-[''] after:absolute after:top-0.5 {{ app()->getLocale() == 'ar' ? 'after:right-[4px]' : 'after:left-[4px]' }} after:bg-white after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:after:shadow-lg"></div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-between {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-4 pt-8">
                <a href="{{ route('admin.system-settings.promotions') }}" 
                   class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2 px-8 py-3.5 bg-slate-200 hover:bg-slate-300 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 rounded-xl transition-all duration-300 font-semibold shadow-md hover:shadow-lg transform hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ __('crm.cancel') }}</span>
                </a>
                <button type="submit" 
                        class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-3 px-10 py-4 bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 hover:from-blue-700 hover:via-blue-800 hover:to-indigo-800 text-white rounded-xl shadow-2xl hover:shadow-blue-500/50 transition-all duration-300 font-bold text-lg transform hover:scale-105">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ __('crm.create_coupon') }}</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M{{ app()->getLocale() == 'ar' ? '15 19l-7-7 7-7' : '9 5l7 7-7 7' }}"/>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Select2 Custom Styling */
    .select2-container--default .select2-selection--single {
        height: 56px !important;
        border: 2px solid rgb(203 213 225) !important;
        border-radius: 0.75rem !important;
        padding: 0.75rem 1rem !important;
        background: white !important;
    }
    
    .dark .select2-container--default .select2-selection--single {
        background-color: rgb(15 23 42) !important;
        border-color: rgb(71 85 105) !important;
        color: white !important;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 36px !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
        font-weight: 500 !important;
        color: rgb(15 23 42) !important;
    }
    
    .dark .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: white !important;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 52px !important;
    }
    
    .select2-container--default .select2-selection--single:focus,
    .select2-container--default.select2-container--open .select2-selection--single,
    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: rgb(99 102 241) !important;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1) !important;
        outline: none !important;
    }
    
    .select2-dropdown {
        border: 2px solid rgb(203 213 225) !important;
        border-radius: 0.75rem !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
        background: white !important;
        margin-top: 0.25rem !important;
        overflow: hidden !important;
    }
    
    .dark .select2-dropdown {
        background-color: rgb(30 41 59) !important;
        border-color: rgb(51 65 85) !important;
    }
    
    .select2-results {
        max-height: 300px !important;
        overflow-y: auto !important;
    }
    
    .select2-results__options {
        padding: 0 !important;
    }
    
    .select2-results__option {
        padding: 0.75rem 1rem !important;
        font-weight: 500 !important;
    }
    
    .select2-container--default .select2-results__option {
        color: rgb(15 23 42) !important;
    }
    
    .dark .select2-container--default .select2-results__option {
        color: white !important;
    }
    
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: rgb(99 102 241) !important;
        color: white !important;
    }
    
    .dark .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: rgb(59 130 246) !important;
        color: white !important;
    }
    
    .select2-search--dropdown {
        padding: 0.75rem !important;
        background: rgb(248 250 252) !important;
        border-bottom: 2px solid rgb(226 232 240) !important;
    }
    
    .dark .select2-search--dropdown {
        background: rgb(15 23 42) !important;
        border-bottom-color: rgb(51 65 85) !important;
    }
    
    .select2-search--dropdown .select2-search__field {
        border: 2px solid rgb(203 213 225) !important;
        border-radius: 0.5rem !important;
        padding: 0.625rem 0.875rem !important;
        font-size: 0.875rem !important;
        background: white !important;
        color: rgb(15 23 42) !important;
        width: 100% !important;
    }
    
    .select2-search--dropdown .select2-search__field:focus {
        border-color: rgb(99 102 241) !important;
        outline: none !important;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1) !important;
    }
    
    .dark .select2-search--dropdown .select2-search__field {
        background-color: rgb(30 41 59) !important;
        border-color: rgb(71 85 105) !important;
        color: white !important;
    }
    
    .dark .select2-search--dropdown .select2-search__field:focus {
        border-color: rgb(99 102 241) !important;
    }
    
    .select2-search--dropdown .select2-search__field::placeholder {
        color: rgb(148 163 184) !important;
    }
    
    .dark .select2-search--dropdown .select2-search__field::placeholder {
        color: rgb(100 116 139) !important;
    }
    
    /* Input animations */
    input:focus, textarea:focus, select:focus {
        transform: translateY(-1px);
        transition: all 0.2s ease;
    }
    
    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Select2 for customer selection
        $('#specific_customer_select').select2({
            placeholder: '{{ __("crm.search_customer") }}',
            allowClear: true,
            width: '100%',
            dropdownParent: $('#specific_customer_select').parent(),
            minimumResultsForSearch: 0, // Always show search box
            dir: '{{ app()->getLocale() == "ar" ? "rtl" : "ltr" }}',
            language: {
                noResults: function() {
                    return '{{ __("crm.no_results_found") }}';
                },
                searching: function() {
                    return '{{ __("crm.searching") }}...';
                },
                inputTooShort: function() {
                    return '{{ __("crm.please_enter_more_characters") }}';
                }
            },
            templateResult: formatCustomer,
            templateSelection: formatCustomerSelection
        });

        // Format customer in dropdown
        function formatCustomer(customer) {
            if (!customer.id) {
                return customer.text;
            }
            
            var $element = $(customer.element);
            var email = $element.data('email');
            var name = $element.data('name');
            
            if (!email || !name) {
                return customer.text;
            }
            
            var $customer = $(
                '<div class="flex items-center {{ app()->getLocale() == "ar" ? "space-x-reverse" : "" }} space-x-3 py-1">' +
                    '<div class="w-8 h-8 rounded-full bg-gradient-to-r from-indigo-500 to-blue-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">' +
                        name.charAt(0).toUpperCase() +
                    '</div>' +
                    '<div class="flex-1 min-w-0">' +
                        '<div class="font-semibold text-slate-900 dark:text-white truncate">' + name + '</div>' +
                        '<div class="text-xs text-slate-500 dark:text-slate-400 truncate">' + email + '</div>' +
                    '</div>' +
                '</div>'
            );
            return $customer;
        }

        // Format selected customer
        function formatCustomerSelection(customer) {
            if (!customer.id) {
                return customer.text;
            }
            
            var $element = $(customer.element);
            var name = $element.data('name');
            var email = $element.data('email');
            
            if (name && email) {
                return name + ' - ' + email;
            }
            
            return customer.text;
        }

        // Add smooth scroll behavior for form sections
        document.querySelectorAll('input, select, textarea').forEach(element => {
            element.addEventListener('invalid', (e) => {
                e.preventDefault();
                element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                element.focus();
            });
        });

        // Form submission animation
        $('form').on('submit', function() {
            const submitBtn = $(this).find('button[type="submit"]');
            submitBtn.prop('disabled', true);
            submitBtn.html('<svg class="w-5 h-5 animate-spin {{ app()->getLocale() == "ar" ? "ml-2" : "mr-2" }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg> {{ __("crm.processing") }}...');
        });
    });
</script>
@endpush
@endsection
