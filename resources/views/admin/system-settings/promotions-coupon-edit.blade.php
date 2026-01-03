@extends('admin.layout')

@section('title', __('crm.edit_coupon'))

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white">
                    {{ __('crm.edit_coupon') }}
                </h1>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                    {{ __('crm.edit_discount_coupon_description') }}
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
        applyToAll: {{ $coupon->apply_to_all ? 'true' : 'false' }},
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
        <form action="{{ route('admin.system-settings.promotions.coupons.update', $coupon->id) }}" method="POST" class="p-6 space-y-6">
            @csrf

            <!-- Coupon Code -->
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                    {{ __('crm.coupon_code') }} <span class="text-red-500">*</span>
                </label>
                <div class="flex gap-2">
                    <input type="text" 
                           name="code"
                           id="coupon_code"
                           required
                           value="{{ old('code', $coupon->code) }}"
                           class="flex-1 px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-transparent uppercase"
                           placeholder="SAVE20">
                    <button type="button"
                            @click="generateCouponCode()"
                            class="px-4 py-2 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 flex items-center space-x-2 whitespace-nowrap">
                        <i class="fas fa-magic"></i>
                        <span>{{ __('crm.generate') }}</span>
                    </button>
                </div>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                    {{ __('crm.coupon_code_help') }}
                </p>
            </div>

            <!-- Discount Type -->
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                    {{ __('crm.discount_type') }} <span class="text-red-500">*</span>
                </label>
                <select name="type" 
                        required
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-transparent">
                    <option value="percentage" {{ $coupon->type === 'percentage' ? 'selected' : '' }}>{{ __('crm.percentage') }}</option>
                    <option value="fixed" {{ $coupon->type === 'fixed' ? 'selected' : '' }}>{{ __('crm.fixed_amount') }}</option>
                </select>
            </div>

            <!-- Discount Value -->
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                    {{ __('crm.discount_value') }} <span class="text-red-500">*</span>
                </label>
                <input type="number" 
                       name="value" 
                       required
                       step="0.01"
                       min="0"
                       value="{{ old('value', $coupon->value) }}"
                       class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-transparent"
                       placeholder="20">
            </div>

            <!-- Min Order Value -->
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                    {{ __('crm.min_order_value') }}
                </label>
                <input type="number" 
                       name="min_order" 
                       step="0.01"
                       min="0"
                       value="{{ old('min_order', $coupon->min_order) }}"
                       class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-transparent"
                       placeholder="0">
            </div>

            <!-- Max Uses -->
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                    {{ __('crm.max_uses') }}
                </label>
                <input type="number" 
                       name="max_uses" 
                       min="0"
                       value="{{ old('max_uses', $coupon->max_uses) }}"
                       class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-transparent"
                       placeholder="{{ __('crm.unlimited') }}">
            </div>

            <!-- Expiry Date -->
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                    {{ __('crm.expiry_date') }}
                </label>
                <input type="date" 
                       name="expires_at"
                       value="{{ old('expires_at', $coupon->expires_at ? $coupon->expires_at->format('Y-m-d') : '') }}"
                       class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-transparent">
            </div>

            <!-- Product Selection -->
            <div class="space-y-4">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                    {{ __('crm.applicable_products') }}
                </label>
                
                <!-- Apply to All Products Toggle -->
                <div class="flex items-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                    <input type="checkbox" 
                           name="apply_to_all" 
                           id="apply_to_all"
                           value="1"
                           {{ old('apply_to_all', $coupon->apply_to_all) ? 'checked' : '' }}
                           x-model="applyToAll"
                           class="w-4 h-4 text-blue-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 rounded focus:ring-blue-500 dark:focus:ring-blue-600">
                    <label for="apply_to_all" class="ms-3 text-sm font-medium text-slate-700 dark:text-slate-300">
                        {{ __('crm.apply_to_all_products') }}
                    </label>
                </div>

                <!-- Product Categories (shown when not applying to all) -->
                <div x-show="!applyToAll" x-transition class="space-y-3">
                    
                    @if($sharedHosting->count() > 0)
                    <!-- Shared Hosting -->
                    <div class="border border-slate-200 dark:border-slate-700 rounded-lg">
                        <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-800/50 cursor-pointer" @click="showSharedHosting = !showSharedHosting">
                            <div class="flex items-center">
                                <i class="fas fa-server text-blue-500 me-3"></i>
                                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ __('crm.shared_hosting') }}</span>
                                <span class="ms-2 text-xs text-slate-500">({{ $sharedHosting->count() }})</span>
                            </div>
                            <i class="fas fa-chevron-down text-slate-400 transition-transform" :class="showSharedHosting ? 'rotate-180' : ''"></i>
                        </div>
                        <div x-show="showSharedHosting" x-transition class="p-4 space-y-2 border-t border-slate-200 dark:border-slate-700">
                            @foreach($sharedHosting as $product)
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       name="products[]" 
                                       value="shared-{{ $product->id }}"
                                       id="product_{{ $product->id }}"
                                       {{ in_array('shared-' . $product->id, old('products', $coupon->products ?? [])) ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 rounded focus:ring-blue-500">
                                <label for="product_{{ $product->id }}" class="ms-3 text-sm text-slate-700 dark:text-slate-300">
                                    {{ $product->name }}
                                    <span class="text-xs text-slate-500">({{ $product->billing_cycle }})</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($cloudHosting->count() > 0)
                    <!-- Cloud Hosting -->
                    <div class="border border-slate-200 dark:border-slate-700 rounded-lg">
                        <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-800/50 cursor-pointer" @click="showCloudHosting = !showCloudHosting">
                            <div class="flex items-center">
                                <i class="fas fa-cloud text-cyan-500 me-3"></i>
                                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ __('crm.cloud_hosting') }}</span>
                                <span class="ms-2 text-xs text-slate-500">({{ $cloudHosting->count() }})</span>
                            </div>
                            <i class="fas fa-chevron-down text-slate-400 transition-transform" :class="showCloudHosting ? 'rotate-180' : ''"></i>
                        </div>
                        <div x-show="showCloudHosting" x-transition class="p-4 space-y-2 border-t border-slate-200 dark:border-slate-700">
                            @foreach($cloudHosting as $product)
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       name="products[]" 
                                       value="cloud-{{ $product->id }}"
                                       id="product_cloud_{{ $product->id }}"
                                       {{ in_array('cloud-' . $product->id, old('products', $coupon->products ?? [])) ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 rounded focus:ring-blue-500">
                                <label for="product_cloud_{{ $product->id }}" class="ms-3 text-sm text-slate-700 dark:text-slate-300">
                                    {{ $product->name }}
                                    <span class="text-xs text-slate-500">({{ $product->billing_cycle }})</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($resellerHosting->count() > 0)
                    <!-- Reseller Hosting -->
                    <div class="border border-slate-200 dark:border-slate-700 rounded-lg">
                        <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-800/50 cursor-pointer" @click="showResellerHosting = !showResellerHosting">
                            <div class="flex items-center">
                                <i class="fas fa-users text-green-500 me-3"></i>
                                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ __('crm.reseller_hosting') }}</span>
                                <span class="ms-2 text-xs text-slate-500">({{ $resellerHosting->count() }})</span>
                            </div>
                            <i class="fas fa-chevron-down text-slate-400 transition-transform" :class="showResellerHosting ? 'rotate-180' : ''"></i>
                        </div>
                        <div x-show="showResellerHosting" x-transition class="p-4 space-y-2 border-t border-slate-200 dark:border-slate-700">
                            @foreach($resellerHosting as $product)
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       name="products[]" 
                                       value="reseller-{{ $product->id }}"
                                       id="product_reseller_{{ $product->id }}"
                                       {{ in_array('reseller-' . $product->id, old('products', $coupon->products ?? [])) ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 rounded focus:ring-blue-500">
                                <label for="product_reseller_{{ $product->id }}" class="ms-3 text-sm text-slate-700 dark:text-slate-300">
                                    {{ $product->name }}
                                    <span class="text-xs text-slate-500">({{ $product->billing_cycle }})</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($vpsPlans->count() > 0)
                    <!-- VPS Plans -->
                    <div class="border border-slate-200 dark:border-slate-700 rounded-lg">
                        <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-800/50 cursor-pointer" @click="showVPS = !showVPS">
                            <div class="flex items-center">
                                <i class="fas fa-hdd text-blue-500 me-3"></i>
                                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ __('crm.vps_plans') }}</span>
                                <span class="ms-2 text-xs text-slate-500">({{ $vpsPlans->count() }})</span>
                            </div>
                            <i class="fas fa-chevron-down text-slate-400 transition-transform" :class="showVPS ? 'rotate-180' : ''"></i>
                        </div>
                        <div x-show="showVPS" x-transition class="p-4 space-y-2 border-t border-slate-200 dark:border-slate-700">
                            @foreach($vpsPlans as $plan)
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       name="products[]" 
                                       value="vps-{{ $plan->id }}"
                                       id="product_vps_{{ $plan->id }}"
                                       {{ in_array('vps-' . $plan->id, old('products', $coupon->products ?? [])) ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 rounded focus:ring-blue-500">
                                <label for="product_vps_{{ $plan->id }}" class="ms-3 text-sm text-slate-700 dark:text-slate-300">
                                    {{ $plan->plan_name }}
                                    <span class="text-xs text-slate-500">({{ $plan->vcpu_count }} vCPU, {{ $plan->ram_gb }} GB RAM)</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($dedicatedPlans->count() > 0)
                    <!-- Dedicated Server -->
                    <div class="border border-slate-200 dark:border-slate-700 rounded-lg">
                        <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-800/50 cursor-pointer" @click="showDedicated = !showDedicated">
                            <div class="flex items-center">
                                <i class="fas fa-database text-purple-500 me-3"></i>
                                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ __('crm.dedicated_server') }}</span>
                                <span class="ms-2 text-xs text-slate-500">({{ $dedicatedPlans->count() }})</span>
                            </div>
                            <i class="fas fa-chevron-down text-slate-400 transition-transform" :class="showDedicated ? 'rotate-180' : ''"></i>
                        </div>
                        <div x-show="showDedicated" x-transition class="p-4 space-y-2 border-t border-slate-200 dark:border-slate-700">
                            @foreach($dedicatedPlans as $plan)
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       name="products[]" 
                                       value="dedicated-{{ $plan->id }}"
                                       id="product_dedicated_{{ $plan->id }}"
                                       {{ in_array('dedicated-' . $plan->id, old('products', $coupon->products ?? [])) ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 rounded focus:ring-blue-500">
                                <label for="product_dedicated_{{ $plan->id }}" class="ms-3 text-sm text-slate-700 dark:text-slate-300">
                                    {{ $plan->plan_name }}
                                    <span class="text-xs text-slate-500">({{ $plan->cpu_count }} CPU, {{ $plan->ram_gb }} GB RAM)</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($domainPricing->count() > 0)
                    <!-- Domain Registration -->
                    <div class="border border-slate-200 dark:border-slate-700 rounded-lg">
                        <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-800/50 cursor-pointer" @click="showDomains = !showDomains">
                            <div class="flex items-center">
                                <i class="fas fa-globe text-indigo-500 me-3"></i>
                                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ __('crm.domain_registration') }}</span>
                                <span class="ms-2 text-xs text-slate-500">({{ $domainPricing->count() }})</span>
                            </div>
                            <i class="fas fa-chevron-down text-slate-400 transition-transform" :class="showDomains ? 'rotate-180' : ''"></i>
                        </div>
                        <div x-show="showDomains" x-transition class="p-4 space-y-2 border-t border-slate-200 dark:border-slate-700 max-h-96 overflow-y-auto">
                            @foreach($domainPricing as $domain)
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       name="products[]" 
                                       value="domain-{{ $domain->id }}"
                                       id="product_domain_{{ $domain->id }}"
                                       {{ in_array('domain-' . $domain->id, old('products', $coupon->products ?? [])) ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 rounded focus:ring-blue-500">
                                <label for="product_domain_{{ $domain->id }}" class="ms-3 text-sm text-slate-700 dark:text-slate-300">
                                    <span class="font-mono font-semibold">.{{ $domain->tld }}</span>
                                    @if($domain->is_featured)
                                        <span class="ms-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                            <i class="fas fa-star text-xs me-1"></i>{{ __('crm.featured') }}
                                        </span>
                                    @endif
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                </div>

                <p class="text-xs text-slate-500 dark:text-slate-400">
                    {{ __('crm.coupon_products_help') }}
                </p>
            </div>

            <!-- Billing Cycles -->
            <div class="space-y-4">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                    {{ __('crm.applicable_billing_cycles') }}
                </label>
                
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    <!-- Monthly -->
                    <div class="flex items-center p-3 border border-slate-200 dark:border-slate-700 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <input type="checkbox" 
                               name="billing_cycles[]" 
                               value="monthly"
                               id="cycle_monthly"
                               {{ in_array('monthly', old('billing_cycles', $coupon->billing_cycles ?? [])) ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 rounded focus:ring-blue-500">
                        <label for="cycle_monthly" class="ms-3 text-sm text-slate-700 dark:text-slate-300 cursor-pointer">
                            {{ __('crm.monthly') }}
                        </label>
                    </div>

                    <!-- Quarterly -->
                    <div class="flex items-center p-3 border border-slate-200 dark:border-slate-700 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <input type="checkbox" 
                               name="billing_cycles[]" 
                               value="quarterly"
                               id="cycle_quarterly"
                               {{ in_array('quarterly', old('billing_cycles', $coupon->billing_cycles ?? [])) ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 rounded focus:ring-blue-500">
                        <label for="cycle_quarterly" class="ms-3 text-sm text-slate-700 dark:text-slate-300 cursor-pointer">
                            {{ __('crm.quarterly') }}
                        </label>
                    </div>

                    <!-- Semi-Annually -->
                    <div class="flex items-center p-3 border border-slate-200 dark:border-slate-700 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <input type="checkbox" 
                               name="billing_cycles[]" 
                               value="semi-annually"
                               id="cycle_semi_annually"
                               {{ in_array('semi-annually', old('billing_cycles', $coupon->billing_cycles ?? [])) ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 rounded focus:ring-blue-500">
                        <label for="cycle_semi_annually" class="ms-3 text-sm text-slate-700 dark:text-slate-300 cursor-pointer">
                            {{ __('crm.semi_annually') }}
                        </label>
                    </div>

                    <!-- Annually -->
                    <div class="flex items-center p-3 border border-slate-200 dark:border-slate-700 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <input type="checkbox" 
                               name="billing_cycles[]" 
                               value="annually"
                               id="cycle_annually"
                               {{ in_array('annually', old('billing_cycles', $coupon->billing_cycles ?? [])) ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 rounded focus:ring-blue-500">
                        <label for="cycle_annually" class="ms-3 text-sm text-slate-700 dark:text-slate-300 cursor-pointer">
                            {{ __('crm.annually') }}
                        </label>
                    </div>

                    <!-- Biennially -->
                    <div class="flex items-center p-3 border border-slate-200 dark:border-slate-700 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <input type="checkbox" 
                               name="billing_cycles[]" 
                               value="biennially"
                               id="cycle_biennially"
                               {{ in_array('biennially', old('billing_cycles', $coupon->billing_cycles ?? [])) ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 rounded focus:ring-blue-500">
                        <label for="cycle_biennially" class="ms-3 text-sm text-slate-700 dark:text-slate-300 cursor-pointer">
                            {{ __('crm.biennially') }}
                        </label>
                    </div>

                    <!-- Triennially -->
                    <div class="flex items-center p-3 border border-slate-200 dark:border-slate-700 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <input type="checkbox" 
                               name="billing_cycles[]" 
                               value="triennially"
                               id="cycle_triennially"
                               {{ in_array('triennially', old('billing_cycles', $coupon->billing_cycles ?? [])) ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 rounded focus:ring-blue-500">
                        <label for="cycle_triennially" class="ms-3 text-sm text-slate-700 dark:text-slate-300 cursor-pointer">
                            {{ __('crm.triennially') }}
                        </label>
                    </div>
                </div>

                <p class="text-xs text-slate-500 dark:text-slate-400">
                    {{ __('crm.coupon_billing_cycles_help') }}
                </p>
            </div>

            <!-- Customer Eligibility -->
            <div class="space-y-4">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                    {{ __('crm.customer_eligibility') }}
                </label>
                
                <div class="space-y-3">
                    <!-- All Customers -->
                    <div class="flex items-start p-4 border-2 border-slate-200 dark:border-slate-700 rounded-lg hover:border-blue-300 dark:hover:border-blue-600 transition-colors">
                        <input type="radio" 
                               name="customer_type" 
                               value="all"
                               id="customer_all"
                               {{ old('customer_type', $coupon->customer_type) === 'all' ? 'checked' : '' }}
                               class="w-4 h-4 mt-0.5 text-blue-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 focus:ring-blue-500">
                        <div class="ms-3">
                            <label for="customer_all" class="text-sm font-semibold text-slate-700 dark:text-slate-300 cursor-pointer">
                                {{ __('crm.all_customers') }}
                            </label>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                {{ __('crm.all_customers_desc') }}
                            </p>
                        </div>
                    </div>

                    <!-- New Customers Only -->
                    <div class="flex items-start p-4 border-2 border-slate-200 dark:border-slate-700 rounded-lg hover:border-green-300 dark:hover:border-green-600 transition-colors">
                        <input type="radio" 
                               name="customer_type" 
                               value="new"
                               id="customer_new"
                               {{ old('customer_type', $coupon->customer_type) === 'new' ? 'checked' : '' }}
                               class="w-4 h-4 mt-0.5 text-green-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 focus:ring-green-500">
                        <div class="ms-3">
                            <label for="customer_new" class="text-sm font-semibold text-slate-700 dark:text-slate-300 cursor-pointer">
                                <i class="fas fa-user-plus text-green-500 me-1"></i>{{ __('crm.new_customers_only') }}
                            </label>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                {{ __('crm.new_customers_only_desc') }}
                            </p>
                        </div>
                    </div>

                    <!-- Existing Customers Only -->
                    <div class="flex items-start p-4 border-2 border-slate-200 dark:border-slate-700 rounded-lg hover:border-purple-300 dark:hover:border-purple-600 transition-colors">
                        <input type="radio" 
                               name="customer_type" 
                               value="existing"
                               id="customer_existing"
                               {{ old('customer_type', $coupon->customer_type) === 'existing' ? 'checked' : '' }}
                               class="w-4 h-4 mt-0.5 text-purple-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 focus:ring-purple-500">
                        <div class="ms-3">
                            <label for="customer_existing" class="text-sm font-semibold text-slate-700 dark:text-slate-300 cursor-pointer">
                                <i class="fas fa-user-check text-purple-500 me-1"></i>{{ __('crm.existing_customers_only') }}
                            </label>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                {{ __('crm.existing_customers_only_desc') }}
                            </p>
                        </div>
                    </div>
                </div>

                <p class="text-xs text-slate-500 dark:text-slate-400">
                    {{ __('crm.coupon_customer_type_help') }}
                </p>
            </div>

            <!-- Usage Restrictions -->
            <div class="space-y-4">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                    {{ __('crm.usage_restrictions') }}
                </label>
                
                <div class="space-y-3">
                    <!-- Apply once per order -->
                    <div class="flex items-start p-4 bg-amber-50 dark:bg-amber-900/10 border border-amber-200 dark:border-amber-800 rounded-lg">
                        <input type="checkbox" 
                               name="once_per_order" 
                               id="once_per_order"
                               value="1"
                               {{ old('once_per_order', $coupon->once_per_order) ? 'checked' : '' }}
                               class="w-4 h-4 mt-0.5 text-amber-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 rounded focus:ring-amber-500">
                        <div class="ms-3">
                            <label for="once_per_order" class="text-sm font-semibold text-slate-700 dark:text-slate-300 cursor-pointer">
                                <i class="fas fa-shopping-cart text-amber-500 me-1"></i>{{ __('crm.apply_once_per_order') }}
                            </label>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                {{ __('crm.apply_once_per_order_desc') }}
                            </p>
                        </div>
                    </div>

                    <!-- Apply once per client globally -->
                    <div class="flex items-start p-4 bg-rose-50 dark:bg-rose-900/10 border border-rose-200 dark:border-rose-800 rounded-lg">
                        <input type="checkbox" 
                               name="once_per_client" 
                               id="once_per_client"
                               value="1"
                               {{ old('once_per_client', $coupon->once_per_client) ? 'checked' : '' }}
                               class="w-4 h-4 mt-0.5 text-rose-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 rounded focus:ring-rose-500">
                        <div class="ms-3">
                            <label for="once_per_client" class="text-sm font-semibold text-slate-700 dark:text-slate-300 cursor-pointer">
                                <i class="fas fa-user-lock text-rose-500 me-1"></i>{{ __('crm.apply_once_per_client') }}
                            </label>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                {{ __('crm.apply_once_per_client_desc') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-3 bg-blue-50 dark:bg-blue-900/10 border border-blue-200 dark:border-blue-800 rounded-lg">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-500 mt-0.5 me-2"></i>
                        <p class="text-xs text-slate-600 dark:text-slate-400">
                            {{ __('crm.usage_restrictions_note') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                    {{ __('crm.description') }}
                </label>
                <textarea name="description" 
                          rows="3"
                          class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-transparent"
                          placeholder="{{ __('crm.coupon_description_placeholder') }}">{{ old('description', $coupon->description) }}</textarea>
            </div>

            <!-- Active Status -->
            <div class="flex items-center">
                <input type="checkbox" 
                       name="is_active" 
                       id="is_active"
                       value="1"
                       {{ $coupon->is_active ? 'checked' : '' }}
                       class="w-4 h-4 text-blue-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 rounded focus:ring-blue-500 dark:focus:ring-blue-600">
                <label for="is_active" class="ms-2 text-sm font-medium text-slate-700 dark:text-slate-300">
                    {{ __('crm.active') }}
                </label>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-slate-200 dark:border-slate-800">
                <a href="{{ route('admin.system-settings.promotions') }}" 
                   class="px-6 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-lg transition-colors">
                    {{ __('crm.cancel') }}
                </a>
                <button type="submit" 
                        class="flex items-center space-x-2 px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>{{ __('crm.update_coupon') }}</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
