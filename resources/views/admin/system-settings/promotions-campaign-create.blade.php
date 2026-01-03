@extends('admin.layout')

@section('title', __('crm.create_campaign'))

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white">
                    {{ __('crm.create_campaign') }}
                </h1>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                    {{ __('crm.create_promotional_campaign_description') }}
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
        showDomains: false
    }">
        <form action="{{ route('admin.system-settings.promotions.campaigns.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <!-- Display Validation Errors -->
            @if ($errors->any())
            <div class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-triangle text-red-500 mt-0.5 me-2"></i>
                    <div class="flex-1">
                        <h3 class="text-sm font-semibold text-red-800 dark:text-red-300 mb-2">{{ __('crm.validation_errors') }}</h3>
                        <ul class="list-disc list-inside space-y-1 text-sm text-red-700 dark:text-red-400">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <!-- Campaign Name -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Name (English) -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.campaign_name') }} (English) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name_en" 
                           value="{{ old('name_en') }}"
                           required
                           class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 dark:focus:ring-purple-600 focus:border-transparent @error('name_en') border-red-500 @enderror"
                           placeholder="Summer Sale 2025">
                    @error('name_en')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Name (Arabic) -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.campaign_name') }} (العربية) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name_ar" 
                           value="{{ old('name_ar') }}"
                           required
                           dir="rtl"
                           class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 dark:focus:ring-purple-600 focus:border-transparent @error('name_ar') border-red-500 @enderror"
                           placeholder="تخفيضات الصيف 2025">
                    @error('name_ar')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Campaign Type -->
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                    {{ __('crm.campaign_type') }} <span class="text-red-500">*</span>
                </label>
                <select name="type" 
                        required
                        class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 dark:focus:ring-purple-600 focus:border-transparent">
                    <option value="seasonal">{{ __('crm.seasonal_campaign') }}</option>
                    <option value="product_launch">{{ __('crm.product_campaign') }}</option>
                    <option value="loyalty_reward">{{ __('crm.loyalty_campaign') }}</option>
                </select>
            </div>

            <!-- Discount Value -->
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                    {{ __('crm.discount_percentage') }} <span class="text-red-500">*</span>
                </label>
                <input type="number" 
                       name="discount_percentage" 
                       required
                       step="1"
                       min="0"
                       max="100"
                       class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 dark:focus:ring-purple-600 focus:border-transparent"
                       placeholder="20">
            </div>

            <!-- Start Date -->
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                    {{ __('crm.start_date') }} <span class="text-red-500">*</span>
                </label>
                <input type="date" 
                       name="start_date" 
                       required
                       class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 dark:focus:ring-purple-600 focus:border-transparent">
            </div>

            <!-- End Date -->
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                    {{ __('crm.end_date') }} <span class="text-red-500">*</span>
                </label>
                <input type="date" 
                       name="end_date" 
                       required
                       class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 dark:focus:ring-purple-600 focus:border-transparent">
            </div>

            <!-- Description -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Description (English) -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.description') }} (English) <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description_en" 
                              rows="4"
                              required
                              class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 dark:focus:ring-purple-600 focus:border-transparent @error('description_en') border-red-500 @enderror"
                              placeholder="Get amazing discounts on all products...">{{ old('description_en') }}</textarea>
                    @error('description_en')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description (Arabic) -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.description') }} (العربية) <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description_ar" 
                              rows="4"
                              required
                              dir="rtl"
                              class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 dark:focus:ring-purple-600 focus:border-transparent @error('description_ar') border-red-500 @enderror"
                              placeholder="احصل على خصومات مذهلة على جميع المنتجات...">{{ old('description_ar') }}</textarea>
                    @error('description_ar')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Target Products (Optional) -->
            <div class="space-y-4">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                    {{ __('crm.target_products') }}
                </label>
                
                <!-- Apply to All Products Toggle -->
                <div class="flex items-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                    <input type="checkbox" 
                           name="apply_to_all" 
                           id="apply_to_all"
                           value="1"
                           checked
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
                    {{ __('crm.leave_empty_all_products') }}
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
                               checked
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
                               checked
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
                               checked
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
                               checked
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
                               checked
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
                               checked
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
                               checked
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

            <!-- Banner Image URL (Optional) -->
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                    {{ __('crm.banner_image_url') }}
                </label>
                <input type="url" 
                       name="banner_url" 
                       class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 dark:focus:ring-purple-600 focus:border-transparent"
                       placeholder="https://example.com/banner.jpg">
            </div>

            <!-- Active Status -->
            <div class="flex items-center">
                <input type="checkbox" 
                       name="is_active" 
                       id="is_active"
                       value="1"
                       checked
                       class="w-4 h-4 text-purple-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-700 rounded focus:ring-purple-500 dark:focus:ring-purple-600">
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
                        class="flex items-center space-x-2 px-6 py-2 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>{{ __('crm.create_campaign') }}</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
