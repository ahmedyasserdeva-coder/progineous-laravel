@extends('admin.layout')

@section('page-title', __('crm.edit_reseller_hosting'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">
                    {{ __('crm.edit_reseller_hosting') }}
                </h1>
                <p class="text-slate-600 dark:text-slate-400">
                    {{ __('crm.edit_reseller_hosting_plan') }}
                </p>
            </div>
            <a href="{{ route('admin.system-settings.products') }}" 
               class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2 px-4 py-2 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>{{ __('crm.back_to_products') }}</span>
            </a>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.system-settings.products.reseller-hosting.update', $product->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Details Section -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
            <div class="bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-800 dark:to-slate-700 px-6 py-4 border-b border-slate-200 dark:border-slate-600">
                <h2 class="text-lg font-semibold text-slate-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ __('crm.details') }}
                </h2>
            </div>
            
            <div class="p-6 space-y-6">
                <!-- Plan Name -->
                <div>
                    <label for="plan_name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.plan_name') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="plan_name" name="plan_name" required value="{{ old('plan_name', $product->name) }}"
                           class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                           placeholder="{{ __('crm.plan_name') }}">
                    @error('plan_name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Plan Tagline -->
                <div>
                    <label for="plan_tagline" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.plan_tagline') }}
                    </label>
                    <input type="text" id="plan_tagline" name="plan_tagline" value="{{ old('plan_tagline', $product->tagline) }}"
                           class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                           placeholder="{{ __('crm.plan_tagline') }}">
                </div>

                <!-- Plan Short Description -->
                <div>
                    <label for="plan_short_description" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.plan_short_description') }}
                    </label>
                    <textarea id="plan_short_description" name="plan_short_description" rows="3"
                              class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                              placeholder="{{ __('crm.plan_short_description') }}">{{ old('plan_short_description', $product->description) }}</textarea>
                </div>

                <!-- Plan Features -->
                <div>
                    <label for="plan_feature" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.plan_feature') }} (English)
                    </label>
                    <textarea id="plan_feature" name="plan_feature" rows="5"
                              class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                              placeholder="{{ __('crm.plan_feature') }}">{{ old('plan_feature', is_array($product->features_list) ? implode("\n", $product->features_list) : $product->features_list) }}</textarea>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('crm.one_feature_per_line') }}</p>
                </div>

                <!-- Plan Features Arabic -->
                <div>
                    <label for="plan_feature_ar" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.plan_feature') }} (العربية)
                    </label>
                    <textarea id="plan_feature_ar" name="plan_feature_ar" rows="5"
                              class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                              placeholder="ميزة الخطة" dir="rtl">{{ old('plan_feature_ar', is_array($product->features_list_ar) ? implode("\n", $product->features_list_ar) : $product->features_list_ar) }}</textarea>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('crm.one_feature_per_line') }}</p>
                </div>

                <!-- Welcome Email -->
                <div>
                    <label for="welcome_email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.welcome_email') }}
                    </label>
                    <select id="welcome_email" name="welcome_email"
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                        <option value="">{{ __('crm.select_email_template') }}</option>
                        @foreach($emailTemplates as $template)
                            <option value="{{ $template->id }}" {{ old('welcome_email', $product->welcome_email) == $template->id ? 'selected' : '' }}>
                                {{ $template->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Checkboxes Row -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Require Domain -->
                    <div>
                        <label class="flex items-start p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                            <input type="checkbox" name="require_domain" value="1" {{ old('require_domain', $product->require_domain) ? 'checked' : '' }}
                                   class="mt-1 w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                            <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }}">
                                <div class="text-sm font-medium text-slate-700 dark:text-slate-300">
                                    {{ __('crm.require_domain') }}
                                </div>
                                <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                    {{ __('crm.require_domain_desc') }}
                                </div>
                            </div>
                        </label>
                    </div>

                    <!-- Featured -->
                    <div>
                        <label class="flex items-start p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                                   class="mt-1 w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                            <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }}">
                                <div class="text-sm font-medium text-slate-700 dark:text-slate-300">
                                    {{ __('crm.featured') }}
                                </div>
                                <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                    {{ __('crm.featured_desc') }}
                                </div>
                            </div>
                        </label>
                    </div>

                    <!-- Hidden -->
                    <div>
                        <label class="flex items-start p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                            <input type="checkbox" name="is_hidden" value="1" {{ old('is_hidden', $product->is_hidden) ? 'checked' : '' }}
                                   class="mt-1 w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                            <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }}">
                                <div class="text-sm font-medium text-slate-700 dark:text-slate-300">
                                    {{ __('crm.hidden') }}
                                </div>
                                <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                    {{ __('crm.hidden_desc') }}
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pricing Section -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden" x-data="pricingForm()">
            <div class="bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-800 dark:to-slate-700 px-6 py-4 border-b border-slate-200 dark:border-slate-600">
                <h2 class="text-lg font-semibold text-slate-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ __('crm.pricing') }}
                </h2>
            </div>
            
            <div class="p-6 space-y-6">
                <!-- Payment Type -->
                <div>
                    <label for="payment_type" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.payment_type') }} <span class="text-red-500">*</span>
                    </label>
                    <select id="payment_type" name="payment_type" x-model="paymentType" required
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                        <option value="free" {{ old('payment_type', $product->payment_type) == 'free' ? 'selected' : '' }}>{{ __('crm.free') }}</option>
                        <option value="one_time" {{ old('payment_type', $product->payment_type) == 'one_time' ? 'selected' : '' }}>{{ __('crm.one_time') }}</option>
                        <option value="recurring" {{ old('payment_type', $product->payment_type) == 'recurring' ? 'selected' : '' }}>{{ __('crm.recurring') }}</option>
                    </select>
                </div>

                <!-- One Time Pricing Table -->
                <div x-show="paymentType === 'one_time'" x-transition class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700 border border-slate-200 dark:border-slate-700 rounded-lg">
                        <thead class="bg-slate-50 dark:bg-slate-900/50">
                            <tr>
                                <th class="px-6 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    {{ __('crm.one_time_monthly') }}
                                </th>
                                <th class="px-6 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    {{ __('crm.setup_fee') }}
                                </th>
                                <th class="px-6 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    {{ __('crm.price') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-700">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-white font-medium">
                                    {{ __('crm.one_time_monthly') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="number" name="one_time_setup_fee" step="0.01" min="0" value="{{ old('one_time_setup_fee', $product->pricing['one_time']['setup_fee'] ?? 0) }}"
                                           class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="number" name="one_time_price" step="0.01" min="0" value="{{ old('one_time_price', $product->pricing['one_time']['price'] ?? 0) }}"
                                           class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Recurring Pricing Table -->
                <div x-show="paymentType === 'recurring'" x-transition class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700 border border-slate-200 dark:border-slate-700 rounded-lg">
                        <thead class="bg-slate-50 dark:bg-slate-900/50">
                            <tr>
                                <th class="px-4 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    {{ __('crm.billing_cycle') }}
                                </th>
                                <th class="px-4 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    {{ __('crm.setup_fee') }}
                                </th>
                                <th class="px-4 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    {{ __('crm.price') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-700">
                            <!-- Monthly -->
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-white font-medium">
                                    {{ __('crm.one_time_monthly') }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <input type="number" name="monthly_setup_fee" step="0.01" min="0" value="{{ old('monthly_setup_fee', $product->pricing['recurring']['monthly']['setup_fee'] ?? 0) }}"
                                           class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <input type="number" name="monthly_price" step="0.01" min="0" value="{{ old('monthly_price', $product->pricing['recurring']['monthly']['price'] ?? 0) }}"
                                           class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </td>
                            </tr>

                            <!-- Quarterly -->
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-white font-medium">
                                    {{ __('crm.quarterly') }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <input type="number" name="quarterly_setup_fee" step="0.01" min="0" value="{{ old('quarterly_setup_fee', $product->pricing['recurring']['quarterly']['setup_fee'] ?? 0) }}"
                                           class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <input type="number" name="quarterly_price" step="0.01" min="0" value="{{ old('quarterly_price', $product->pricing['recurring']['quarterly']['price'] ?? 0) }}"
                                           class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </td>
                            </tr>

                            <!-- Semi-Annually -->
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-white font-medium">
                                    {{ __('crm.semi_annually') }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <input type="number" name="semi_annually_setup_fee" step="0.01" min="0" value="{{ old('semi_annually_setup_fee', $product->pricing['recurring']['semi_annually']['setup_fee'] ?? 0) }}"
                                           class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <input type="number" name="semi_annually_price" step="0.01" min="0" value="{{ old('semi_annually_price', $product->pricing['recurring']['semi_annually']['price'] ?? 0) }}"
                                           class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </td>
                            </tr>

                            <!-- Annually -->
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-white font-medium">
                                    {{ __('crm.annually') }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <input type="number" name="annually_setup_fee" step="0.01" min="0" value="{{ old('annually_setup_fee', $product->pricing['recurring']['annually']['setup_fee'] ?? 0) }}"
                                           class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <input type="number" name="annually_price" step="0.01" min="0" value="{{ old('annually_price', $product->pricing['recurring']['annually']['price'] ?? 0) }}"
                                           class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </td>
                            </tr>

                            <!-- Biennially -->
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-white font-medium">
                                    {{ __('crm.biennially') }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <input type="number" name="biennially_setup_fee" step="0.01" min="0" value="{{ old('biennially_setup_fee', $product->pricing['recurring']['biennially']['setup_fee'] ?? 0) }}"
                                           class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <input type="number" name="biennially_price" step="0.01" min="0" value="{{ old('biennially_price', $product->pricing['recurring']['biennially']['price'] ?? 0) }}"
                                           class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </td>
                            </tr>

                            <!-- Triennially -->
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-white font-medium">
                                    {{ __('crm.triennially') }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <input type="number" name="triennially_setup_fee" step="0.01" min="0" value="{{ old('triennially_setup_fee', $product->pricing['recurring']['triennially']['setup_fee'] ?? 0) }}"
                                           class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <input type="number" name="triennially_price" step="0.01" min="0" value="{{ old('triennially_price', $product->pricing['recurring']['triennially']['price'] ?? 0) }}"
                                           class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Allow Multiple Quantities -->
                <div x-show="paymentType !== 'free'">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.allow_multiple_quantities') }}
                    </label>
                    <div class="flex items-center gap-4">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="allow_multiple_quantities" value="0" {{ old('allow_multiple_quantities', $product->allow_multiple_quantities ? 1 : 0) == 0 ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 bg-white border-slate-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                            <span class="{{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }} text-sm text-slate-900 dark:text-white">{{ __('crm.no') }}</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="allow_multiple_quantities" value="1" {{ old('allow_multiple_quantities', $product->allow_multiple_quantities ? 1 : 0) == 1 ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 bg-white border-slate-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                            <span class="{{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }} text-sm text-slate-900 dark:text-white">{{ __('crm.yes') }}</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- cPanel Accounts Section -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
            <div class="bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-800 dark:to-slate-700 px-6 py-4 border-b border-slate-200 dark:border-slate-600">
                <h2 class="text-lg font-semibold text-slate-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    {{ __('crm.cpanel_accounts') }}
                </h2>
            </div>
            
            <div class="p-6 space-y-6" x-data="{ enableCpanelTiers: {{ old('enable_cpanel_tiers', $product->enable_cpanel_tiers) ? 'true' : 'false' }} }">
                <!-- Base cPanel Accounts -->
                <div>
                    <label for="base_cpanel_accounts" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.base_cpanel_accounts') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="base_cpanel_accounts" name="base_cpanel_accounts" value="{{ old('base_cpanel_accounts', $product->base_cpanel_accounts ?? 25) }}" min="0" required
                           class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('crm.base_cpanel_accounts_desc') }}</p>
                </div>

                <!-- Enable Additional cPanel Tiers -->
                <div class="border border-slate-200 dark:border-slate-700 rounded-lg p-4 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <label for="enable_cpanel_tiers" class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" id="enable_cpanel_tiers" name="enable_cpanel_tiers" value="1" 
                                       {{ old('enable_cpanel_tiers', $product->enable_cpanel_tiers) ? 'checked' : '' }}
                                       x-model="enableCpanelTiers"
                                       class="w-5 h-5 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                                <div>
                                    <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ __('crm.enable_additional_cpanel_tiers') }}</span>
                                    <p class="text-xs text-slate-600 dark:text-slate-400 mt-0.5">{{ __('crm.enable_additional_cpanel_tiers_desc') }}</p>
                                </div>
                            </label>
                        </div>
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                        </svg>
                    </div>
                </div>

                <!-- Important Note -->
                <div class="flex items-start gap-2 p-3 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg">
                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <div class="text-xs text-amber-800 dark:text-amber-200">
                        <strong>{{ app()->getLocale() == 'ar' ? 'مهم:' : 'Important:' }}</strong>
                        {{ __('crm.cpanel_accounts_note') }}
                    </div>
                </div>

                <!-- Additional cPanel Accounts Pricing -->
                <div x-show="enableCpanelTiers" x-transition>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-3">
                        {{ __('crm.additional_cpanel_accounts_pricing') }}
                    </label>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mb-4">{{ __('crm.additional_cpanel_accounts_pricing_desc') }}</p>
                    
                    <div class="space-y-6">
                        <!-- 50 Accounts -->
                        <div class="border border-slate-200 dark:border-slate-700 rounded-lg overflow-hidden">
                            <div class="flex items-center gap-2 p-4 bg-gradient-to-r from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-800/20 border-b border-slate-200 dark:border-slate-700">
                                <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                </svg>
                                <h3 class="font-semibold text-slate-900 dark:text-white">50 {{ __('crm.cpanel_accounts') }}</h3>
                            </div>
                            <div class="p-4 bg-slate-50 dark:bg-slate-900/50">
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">{{ __('crm.monthly') }}</label>
                                        <input type="number" name="cpanel_50_monthly" value="{{ old('cpanel_50_monthly', $product->cpanelTiers->where('tier', 50)->first()?->monthly_price ?? 0) }}" min="0" step="0.01"
                                               class="w-full px-3 py-2 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">{{ __('crm.quarterly') }}</label>
                                        <input type="number" name="cpanel_50_quarterly" value="{{ old('cpanel_50_quarterly', $product->cpanelTiers->where('tier', 50)->first()?->quarterly_price ?? 0) }}" min="0" step="0.01"
                                               class="w-full px-3 py-2 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">{{ __('crm.semi_annually') }}</label>
                                        <input type="number" name="cpanel_50_semi_annually" value="{{ old('cpanel_50_semi_annually', $product->cpanelTiers->where('tier', 50)->first()?->semi_annually_price ?? 0) }}" min="0" step="0.01"
                                               class="w-full px-3 py-2 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">{{ __('crm.annually') }}</label>
                                        <input type="number" name="cpanel_50_annually" value="{{ old('cpanel_50_annually', $product->cpanelTiers->where('tier', 50)->first()?->annually_price ?? 0) }}" min="0" step="0.01"
                                               class="w-full px-3 py-2 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">{{ __('crm.biennially') }}</label>
                                        <input type="number" name="cpanel_50_biennially" value="{{ old('cpanel_50_biennially', $product->cpanelTiers->where('tier', 50)->first()?->biennially_price ?? 0) }}" min="0" step="0.01"
                                               class="w-full px-3 py-2 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">{{ __('crm.triennially') }}</label>
                                        <input type="number" name="cpanel_50_triennially" value="{{ old('cpanel_50_triennially', $product->cpanelTiers->where('tier', 50)->first()?->triennially_price ?? 0) }}" min="0" step="0.01"
                                               class="w-full px-3 py-2 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 100 Accounts -->
                        <div class="border border-slate-200 dark:border-slate-700 rounded-lg overflow-hidden">
                            <div class="flex items-center gap-2 p-4 bg-gradient-to-r from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-800/20 border-b border-slate-200 dark:border-slate-700">
                                <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                </svg>
                                <h3 class="font-semibold text-slate-900 dark:text-white">100 {{ __('crm.cpanel_accounts') }}</h3>
                            </div>
                            <div class="p-4 bg-slate-50 dark:bg-slate-900/50">
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">{{ __('crm.monthly') }}</label>
                                        <input type="number" name="cpanel_100_monthly" value="{{ old('cpanel_100_monthly', $product->cpanelTiers->where('tier', 100)->first()?->monthly_price ?? 0) }}" min="0" step="0.01"
                                               class="w-full px-3 py-2 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">{{ __('crm.quarterly') }}</label>
                                        <input type="number" name="cpanel_100_quarterly" value="{{ old('cpanel_100_quarterly', $product->cpanelTiers->where('tier', 100)->first()?->quarterly_price ?? 0) }}" min="0" step="0.01"
                                               class="w-full px-3 py-2 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">{{ __('crm.semi_annually') }}</label>
                                        <input type="number" name="cpanel_100_semi_annually" value="{{ old('cpanel_100_semi_annually', $product->cpanelTiers->where('tier', 100)->first()?->semi_annually_price ?? 0) }}" min="0" step="0.01"
                                               class="w-full px-3 py-2 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">{{ __('crm.annually') }}</label>
                                        <input type="number" name="cpanel_100_annually" value="{{ old('cpanel_100_annually', $product->cpanelTiers->where('tier', 100)->first()?->annually_price ?? 0) }}" min="0" step="0.01"
                                               class="w-full px-3 py-2 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">{{ __('crm.biennially') }}</label>
                                        <input type="number" name="cpanel_100_biennially" value="{{ old('cpanel_100_biennially', $product->cpanelTiers->where('tier', 100)->first()?->biennially_price ?? 0) }}" min="0" step="0.01"
                                               class="w-full px-3 py-2 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">{{ __('crm.triennially') }}</label>
                                        <input type="number" name="cpanel_100_triennially" value="{{ old('cpanel_100_triennially', $product->cpanelTiers->where('tier', 100)->first()?->triennially_price ?? 0) }}" min="0" step="0.01"
                                               class="w-full px-3 py-2 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 200 Accounts -->
                        <div class="border border-slate-200 dark:border-slate-700 rounded-lg overflow-hidden">
                            <div class="flex items-center gap-2 p-4 bg-gradient-to-r from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-800/20 border-b border-slate-200 dark:border-slate-700">
                                <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                </svg>
                                <h3 class="font-semibold text-slate-900 dark:text-white">200 {{ __('crm.cpanel_accounts') }}</h3>
                            </div>
                            <div class="p-4 bg-slate-50 dark:bg-slate-900/50">
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">{{ __('crm.monthly') }}</label>
                                        <input type="number" name="cpanel_200_monthly" value="{{ old('cpanel_200_monthly', $product->cpanelTiers->where('tier', 200)->first()?->monthly_price ?? 0) }}" min="0" step="0.01"
                                               class="w-full px-3 py-2 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">{{ __('crm.quarterly') }}</label>
                                        <input type="number" name="cpanel_200_quarterly" value="{{ old('cpanel_200_quarterly', $product->cpanelTiers->where('tier', 200)->first()?->quarterly_price ?? 0) }}" min="0" step="0.01"
                                               class="w-full px-3 py-2 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">{{ __('crm.semi_annually') }}</label>
                                        <input type="number" name="cpanel_200_semi_annually" value="{{ old('cpanel_200_semi_annually', $product->cpanelTiers->where('tier', 200)->first()?->semi_annually_price ?? 0) }}" min="0" step="0.01"
                                               class="w-full px-3 py-2 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">{{ __('crm.annually') }}</label>
                                        <input type="number" name="cpanel_200_annually" value="{{ old('cpanel_200_annually', $product->cpanelTiers->where('tier', 200)->first()?->annually_price ?? 0) }}" min="0" step="0.01"
                                               class="w-full px-3 py-2 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">{{ __('crm.biennially') }}</label>
                                        <input type="number" name="cpanel_200_biennially" value="{{ old('cpanel_200_biennially', $product->cpanelTiers->where('tier', 200)->first()?->biennially_price ?? 0) }}" min="0" step="0.01"
                                               class="w-full px-3 py-2 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">{{ __('crm.triennially') }}</label>
                                        <input type="number" name="cpanel_200_triennially" value="{{ old('cpanel_200_triennially', $product->cpanelTiers->where('tier', 200)->first()?->triennially_price ?? 0) }}" min="0" step="0.01"
                                               class="w-full px-3 py-2 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 300 Accounts -->
                        <div class="border border-slate-200 dark:border-slate-700 rounded-lg overflow-hidden">
                            <div class="flex items-center gap-2 p-4 bg-gradient-to-r from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-800/20 border-b border-slate-200 dark:border-slate-700">
                                <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                </svg>
                                <h3 class="font-semibold text-slate-900 dark:text-white">300 {{ __('crm.cpanel_accounts') }}</h3>
                            </div>
                            <div class="p-4 bg-slate-50 dark:bg-slate-900/50">
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">{{ __('crm.monthly') }}</label>
                                        <input type="number" name="cpanel_300_monthly" value="{{ old('cpanel_300_monthly', $product->cpanelTiers->where('tier', 300)->first()?->monthly_price ?? 0) }}" min="0" step="0.01"
                                               class="w-full px-3 py-2 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">{{ __('crm.quarterly') }}</label>
                                        <input type="number" name="cpanel_300_quarterly" value="{{ old('cpanel_300_quarterly', $product->cpanelTiers->where('tier', 300)->first()?->quarterly_price ?? 0) }}" min="0" step="0.01"
                                               class="w-full px-3 py-2 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">{{ __('crm.semi_annually') }}</label>
                                        <input type="number" name="cpanel_300_semi_annually" value="{{ old('cpanel_300_semi_annually', $product->cpanelTiers->where('tier', 300)->first()?->semi_annually_price ?? 0) }}" min="0" step="0.01"
                                               class="w-full px-3 py-2 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">{{ __('crm.annually') }}</label>
                                        <input type="number" name="cpanel_300_annually" value="{{ old('cpanel_300_annually', $product->cpanelTiers->where('tier', 300)->first()?->annually_price ?? 0) }}" min="0" step="0.01"
                                               class="w-full px-3 py-2 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">{{ __('crm.biennially') }}</label>
                                        <input type="number" name="cpanel_300_biennially" value="{{ old('cpanel_300_biennially', $product->cpanelTiers->where('tier', 300)->first()?->biennially_price ?? 0) }}" min="0" step="0.01"
                                               class="w-full px-3 py-2 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">{{ __('crm.triennially') }}</label>
                                        <input type="number" name="cpanel_300_triennially" value="{{ old('cpanel_300_triennially', $product->cpanelTiers->where('tier', 300)->first()?->triennially_price ?? 0) }}" min="0" step="0.01"
                                               class="w-full px-3 py-2 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Example -->
                <div class="flex items-start gap-2 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                    <div class="text-xs text-green-800 dark:text-green-200">
                        <strong>{{ app()->getLocale() == 'ar' ? 'مثال:' : 'Example:' }}</strong>
                        {{ __('crm.cpanel_accounts_example') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Datacenter Locations Section -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
            <div class="bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-800 dark:to-slate-700 px-6 py-4 border-b border-slate-200 dark:border-slate-600">
                <h2 class="text-lg font-semibold text-slate-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ __('crm.datacenter_locations') }}
                </h2>
            </div>
            
            <div class="p-6">
                <p class="text-xs text-slate-500 dark:text-slate-400 mb-4">
                    {{ __('crm.datacenter_locations_desc') }}
                </p>
                
                <!-- Important Note -->
                <div class="flex items-start gap-2 p-3 mb-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="text-xs text-blue-800 dark:text-blue-200">
                        <strong>{{ app()->getLocale() == 'ar' ? 'مهم:' : 'Important:' }}</strong>
                        {{ __('crm.datacenter_price_note') }}
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    <!-- North America -->
                    <div class="col-span-full">
                        <h4 class="text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ __('crm.north_america') }}
                        </h4>
                    </div>
                    
                    <div class="relative p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="datacenter_locations[]" value="us-east" {{ in_array('us-east', old('datacenter_locations', $product->datacenter_locations ?? [])) ? 'checked' : '' }}
                                   class="datacenter-checkbox w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                            <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="fi fi-us text-2xl" style="font-size: 2rem; line-height: 1;"></span>
                                    <div>
                                        <div class="text-sm font-medium text-slate-900 dark:text-white">{{ __('crm.us_east') }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">New York</div>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <div class="mt-3 {{ app()->getLocale() == 'ar' ? 'pr-7' : 'pl-7' }}">
                            <label class="flex items-center gap-1 text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">
                                <span class="inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded">+</span>
                                {{ __('crm.additional_price') }} <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">({{ app()->getLocale() == 'ar' ? 'شهري' : 'Monthly' }})</span>
                            </label>
                            <input type="number" name="datacenter_price[us-east]" step="0.01" min="0" value="{{ old('datacenter_price.us-east', $product->datacenter_price['us-east'] ?? 0) }}"
                                   class="datacenter-price-input w-full px-3 py-1.5 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white disabled:bg-slate-100 dark:disabled:bg-slate-800 disabled:cursor-not-allowed"
                                   placeholder="0.00">
                        </div>
                    </div>

                    <div class="relative p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="datacenter_locations[]" value="us-west" {{ in_array('us-west', old('datacenter_locations', $product->datacenter_locations ?? [])) ? 'checked' : '' }}
                                   class="datacenter-checkbox w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                            <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="fi fi-us text-2xl" style="font-size: 2rem; line-height: 1;"></span>
                                    <div>
                                        <div class="text-sm font-medium text-slate-900 dark:text-white">{{ __('crm.us_west') }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">Los Angeles</div>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <div class="mt-3 {{ app()->getLocale() == 'ar' ? 'pr-7' : 'pl-7' }}">
                            <label class="flex items-center gap-1 text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">
                                <span class="inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded">+</span>
                                {{ __('crm.additional_price') }} <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">({{ app()->getLocale() == 'ar' ? 'شهري' : 'Monthly' }})</span>
                            </label>
                            <input type="number" name="datacenter_price[us-west]" step="0.01" min="0" value="{{ old('datacenter_price.us-west', $product->datacenter_price['us-west'] ?? 0) }}"
                                   class="datacenter-price-input w-full px-3 py-1.5 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white disabled:bg-slate-100 dark:disabled:bg-slate-800 disabled:cursor-not-allowed"
                                   placeholder="0.00">
                        </div>
                    </div>

                    <div class="relative p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="datacenter_locations[]" value="us-central" {{ in_array('us-central', old('datacenter_locations', $product->datacenter_locations ?? [])) ? 'checked' : '' }}
                                   class="datacenter-checkbox w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                            <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="fi fi-us text-2xl" style="font-size: 2rem; line-height: 1;"></span>
                                    <div>
                                        <div class="text-sm font-medium text-slate-900 dark:text-white">{{ __('crm.us_central') }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">Dallas</div>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <div class="mt-3 {{ app()->getLocale() == 'ar' ? 'pr-7' : 'pl-7' }}">
                            <label class="flex items-center gap-1 text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">
                                <span class="inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded">+</span>
                                {{ __('crm.additional_price') }} <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">({{ app()->getLocale() == 'ar' ? 'شهري' : 'Monthly' }})</span>
                            </label>
                            <input type="number" name="datacenter_price[us-central]" step="0.01" min="0" value="{{ old('datacenter_price.us-central', $product->datacenter_price['us-central'] ?? 0) }}"
                                   class="datacenter-price-input w-full px-3 py-1.5 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white disabled:bg-slate-100 dark:disabled:bg-slate-800 disabled:cursor-not-allowed"
                                   placeholder="0.00">
                        </div>
                    </div>

                    <div class="relative p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="datacenter_locations[]" value="canada" {{ in_array('canada', old('datacenter_locations', $product->datacenter_locations ?? [])) ? 'checked' : '' }}
                                   class="datacenter-checkbox w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                            <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="fi fi-ca text-2xl" style="font-size: 2rem; line-height: 1;"></span>
                                    <div>
                                        <div class="text-sm font-medium text-slate-900 dark:text-white">{{ __('crm.canada') }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">Toronto</div>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <div class="mt-3 {{ app()->getLocale() == 'ar' ? 'pr-7' : 'pl-7' }}">
                            <label class="flex items-center gap-1 text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">
                                <span class="inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded">+</span>
                                {{ __('crm.additional_price') }} <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">({{ app()->getLocale() == 'ar' ? 'شهري' : 'Monthly' }})</span>
                            </label>
                            <input type="number" name="datacenter_price[canada]" step="0.01" min="0" value="{{ old('datacenter_price.canada', $product->datacenter_price['canada'] ?? 0) }}"
                                   class="datacenter-price-input w-full px-3 py-1.5 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white disabled:bg-slate-100 dark:disabled:bg-slate-800 disabled:cursor-not-allowed"
                                   placeholder="0.00">
                        </div>
                    </div>

                    <!-- Europe -->
                    <div class="col-span-full mt-4">
                        <h4 class="text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ __('crm.europe') }}
                        </h4>
                    </div>

                    <div class="relative p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="datacenter_locations[]" value="eu-west" {{ in_array('eu-west', old('datacenter_locations', $product->datacenter_locations ?? [])) ? 'checked' : '' }}
                                   class="datacenter-checkbox w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                            <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="fi fi-gb text-2xl" style="font-size: 2rem; line-height: 1;"></span>
                                    <div>
                                        <div class="text-sm font-medium text-slate-900 dark:text-white">{{ __('crm.eu_west') }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">London</div>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <div class="mt-3 {{ app()->getLocale() == 'ar' ? 'pr-7' : 'pl-7' }}">
                            <label class="flex items-center gap-1 text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">
                                <span class="inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded">+</span>
                                {{ __('crm.additional_price') }} <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">({{ app()->getLocale() == 'ar' ? 'شهري' : 'Monthly' }})</span>
                            </label>
                            <input type="number" name="datacenter_price[eu-west]" step="0.01" min="0" value="{{ old('datacenter_price.eu-west', $product->datacenter_price['eu-west'] ?? 0) }}"
                                   class="datacenter-price-input w-full px-3 py-1.5 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white disabled:bg-slate-100 dark:disabled:bg-slate-800 disabled:cursor-not-allowed"
                                   placeholder="0.00">
                        </div>
                    </div>

                    <div class="relative p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="datacenter_locations[]" value="eu-central" {{ in_array('eu-central', old('datacenter_locations', $product->datacenter_locations ?? [])) ? 'checked' : '' }}
                                   class="datacenter-checkbox w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                            <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="fi fi-de text-2xl" style="font-size: 2rem; line-height: 1;"></span>
                                    <div>
                                        <div class="text-sm font-medium text-slate-900 dark:text-white">{{ __('crm.eu_central') }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">Frankfurt</div>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <div class="mt-3 {{ app()->getLocale() == 'ar' ? 'pr-7' : 'pl-7' }}">
                            <label class="flex items-center gap-1 text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">
                                <span class="inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded">+</span>
                                {{ __('crm.additional_price') }} <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">({{ app()->getLocale() == 'ar' ? 'شهري' : 'Monthly' }})</span>
                            </label>
                            <input type="number" name="datacenter_price[eu-central]" step="0.01" min="0" value="{{ old('datacenter_price.eu-central', $product->datacenter_price['eu-central'] ?? 0) }}"
                                   class="datacenter-price-input w-full px-3 py-1.5 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white disabled:bg-slate-100 dark:disabled:bg-slate-800 disabled:cursor-not-allowed"
                                   placeholder="0.00">
                        </div>
                    </div>

                    <div class="relative p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="datacenter_locations[]" value="eu-north" {{ in_array('eu-north', old('datacenter_locations', $product->datacenter_locations ?? [])) ? 'checked' : '' }}
                                   class="datacenter-checkbox w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                            <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="fi fi-nl text-2xl" style="font-size: 2rem; line-height: 1;"></span>
                                    <div>
                                        <div class="text-sm font-medium text-slate-900 dark:text-white">{{ __('crm.eu_north') }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">Amsterdam</div>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <div class="mt-3 {{ app()->getLocale() == 'ar' ? 'pr-7' : 'pl-7' }}">
                            <label class="flex items-center gap-1 text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">
                                <span class="inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded">+</span>
                                {{ __('crm.additional_price') }} <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">({{ app()->getLocale() == 'ar' ? 'شهري' : 'Monthly' }})</span>
                            </label>
                            <input type="number" name="datacenter_price[eu-north]" step="0.01" min="0" value="{{ old('datacenter_price.eu-north', $product->datacenter_price['eu-north'] ?? 0) }}"
                                   class="datacenter-price-input w-full px-3 py-1.5 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white disabled:bg-slate-100 dark:disabled:bg-slate-800 disabled:cursor-not-allowed"
                                   placeholder="0.00">
                        </div>
                    </div>

                    <!-- Asia Pacific -->
                    <div class="col-span-full mt-4">
                        <h4 class="text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ __('crm.asia_pacific') }}
                        </h4>
                    </div>

                    <div class="relative p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="datacenter_locations[]" value="asia-east" {{ in_array('asia-east', old('datacenter_locations', $product->datacenter_locations ?? [])) ? 'checked' : '' }}
                                   class="datacenter-checkbox w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                            <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="fi fi-sg text-2xl" style="font-size: 2rem; line-height: 1;"></span>
                                    <div>
                                        <div class="text-sm font-medium text-slate-900 dark:text-white">{{ __('crm.asia_east') }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">Singapore</div>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <div class="mt-3 {{ app()->getLocale() == 'ar' ? 'pr-7' : 'pl-7' }}">
                            <label class="flex items-center gap-1 text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">
                                <span class="inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded">+</span>
                                {{ __('crm.additional_price') }} <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">({{ app()->getLocale() == 'ar' ? 'شهري' : 'Monthly' }})</span>
                            </label>
                            <input type="number" name="datacenter_price[asia-east]" step="0.01" min="0" value="{{ old('datacenter_price.asia-east', $product->datacenter_price['asia-east'] ?? 0) }}"
                                   class="datacenter-price-input w-full px-3 py-1.5 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white disabled:bg-slate-100 dark:disabled:bg-slate-800 disabled:cursor-not-allowed"
                                   placeholder="0.00">
                        </div>
                    </div>

                    <div class="relative p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="datacenter_locations[]" value="asia-south" {{ in_array('asia-south', old('datacenter_locations', $product->datacenter_locations ?? [])) ? 'checked' : '' }}
                                   class="datacenter-checkbox w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                            <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="fi fi-in text-2xl" style="font-size: 2rem; line-height: 1;"></span>
                                    <div>
                                        <div class="text-sm font-medium text-slate-900 dark:text-white">{{ __('crm.asia_south') }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">Mumbai</div>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <div class="mt-3 {{ app()->getLocale() == 'ar' ? 'pr-7' : 'pl-7' }}">
                            <label class="flex items-center gap-1 text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">
                                <span class="inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded">+</span>
                                {{ __('crm.additional_price') }} <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">({{ app()->getLocale() == 'ar' ? 'شهري' : 'Monthly' }})</span>
                            </label>
                            <input type="number" name="datacenter_price[asia-south]" step="0.01" min="0" value="{{ old('datacenter_price.asia-south', $product->datacenter_price['asia-south'] ?? 0) }}"
                                   class="datacenter-price-input w-full px-3 py-1.5 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white disabled:bg-slate-100 dark:disabled:bg-slate-800 disabled:cursor-not-allowed"
                                   placeholder="0.00">
                        </div>
                    </div>

                    <div class="relative p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="datacenter_locations[]" value="asia-pacific" {{ in_array('asia-pacific', old('datacenter_locations', $product->datacenter_locations ?? [])) ? 'checked' : '' }}
                                   class="datacenter-checkbox w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                            <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="fi fi-jp text-2xl" style="font-size: 2rem; line-height: 1;"></span>
                                    <div>
                                        <div class="text-sm font-medium text-slate-900 dark:text-white">{{ __('crm.asia_pacific') }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">Tokyo</div>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <div class="mt-3 {{ app()->getLocale() == 'ar' ? 'pr-7' : 'pl-7' }}">
                            <label class="flex items-center gap-1 text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">
                                <span class="inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded">+</span>
                                {{ __('crm.additional_price') }} <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">({{ app()->getLocale() == 'ar' ? 'شهري' : 'Monthly' }})</span>
                            </label>
                            <input type="number" name="datacenter_price[asia-pacific]" step="0.01" min="0" value="{{ old('datacenter_price.asia-pacific', $product->datacenter_price['asia-pacific'] ?? 0) }}"
                                   class="datacenter-price-input w-full px-3 py-1.5 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white disabled:bg-slate-100 dark:disabled:bg-slate-800 disabled:cursor-not-allowed"
                                   placeholder="0.00">
                        </div>
                    </div>

                    <div class="relative p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="datacenter_locations[]" value="australia" {{ in_array('australia', old('datacenter_locations', $product->datacenter_locations ?? [])) ? 'checked' : '' }}
                                   class="datacenter-checkbox w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                            <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="fi fi-au text-2xl" style="font-size: 2rem; line-height: 1;"></span>
                                    <div>
                                        <div class="text-sm font-medium text-slate-900 dark:text-white">{{ __('crm.australia') }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">Sydney</div>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <div class="mt-3 {{ app()->getLocale() == 'ar' ? 'pr-7' : 'pl-7' }}">
                            <label class="flex items-center gap-1 text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">
                                <span class="inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded">+</span>
                                {{ __('crm.additional_price') }} <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">({{ app()->getLocale() == 'ar' ? 'شهري' : 'Monthly' }})</span>
                            </label>
                            <input type="number" name="datacenter_price[australia]" step="0.01" min="0" value="{{ old('datacenter_price.australia', $product->datacenter_price['australia'] ?? 0) }}"
                                   class="datacenter-price-input w-full px-3 py-1.5 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white disabled:bg-slate-100 dark:disabled:bg-slate-800 disabled:cursor-not-allowed"
                                   placeholder="0.00">
                        </div>
                    </div>

                    <!-- Middle East & Others -->
                    <div class="col-span-full mt-4">
                        <h4 class="text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ __('crm.middle_east_others') }}
                        </h4>
                    </div>

                    <div class="relative p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="datacenter_locations[]" value="uae" {{ in_array('uae', old('datacenter_locations', $product->datacenter_locations ?? [])) ? 'checked' : '' }}
                                   class="datacenter-checkbox w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                            <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="fi fi-ae text-2xl" style="font-size: 2rem; line-height: 1;"></span>
                                    <div>
                                        <div class="text-sm font-medium text-slate-900 dark:text-white">{{ __('crm.uae') }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">Dubai</div>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <div class="mt-3 {{ app()->getLocale() == 'ar' ? 'pr-7' : 'pl-7' }}">
                            <label class="flex items-center gap-1 text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">
                                <span class="inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded">+</span>
                                {{ __('crm.additional_price') }} <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">({{ app()->getLocale() == 'ar' ? 'شهري' : 'Monthly' }})</span>
                            </label>
                            <input type="number" name="datacenter_price[uae]" step="0.01" min="0" value="{{ old('datacenter_price.uae', $product->datacenter_price['uae'] ?? 0) }}"
                                   class="datacenter-price-input w-full px-3 py-1.5 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white disabled:bg-slate-100 dark:disabled:bg-slate-800 disabled:cursor-not-allowed"
                                   placeholder="0.00">
                        </div>
                    </div>

                    <div class="relative p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="datacenter_locations[]" value="saudi-arabia" {{ in_array('saudi-arabia', old('datacenter_locations', $product->datacenter_locations ?? [])) ? 'checked' : '' }}
                                   class="datacenter-checkbox w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                            <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="fi fi-sa text-2xl" style="font-size: 2rem; line-height: 1;"></span>
                                    <div>
                                        <div class="text-sm font-medium text-slate-900 dark:text-white">{{ __('crm.saudi_arabia') }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">Riyadh</div>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <div class="mt-3 {{ app()->getLocale() == 'ar' ? 'pr-7' : 'pl-7' }}">
                            <label class="flex items-center gap-1 text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">
                                <span class="inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded">+</span>
                                {{ __('crm.additional_price') }} <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">({{ app()->getLocale() == 'ar' ? 'شهري' : 'Monthly' }})</span>
                            </label>
                            <input type="number" name="datacenter_price[saudi-arabia]" step="0.01" min="0" value="{{ old('datacenter_price.saudi-arabia', $product->datacenter_price['saudi-arabia'] ?? 0) }}"
                                   class="datacenter-price-input w-full px-3 py-1.5 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white disabled:bg-slate-100 dark:disabled:bg-slate-800 disabled:cursor-not-allowed"
                                   placeholder="0.00">
                        </div>
                    </div>

                    <div class="relative p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="datacenter_locations[]" value="egypt" {{ in_array('egypt', old('datacenter_locations', $product->datacenter_locations ?? [])) ? 'checked' : '' }}
                                   class="datacenter-checkbox w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                            <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="fi fi-eg text-2xl" style="font-size: 2rem; line-height: 1;"></span>
                                    <div>
                                        <div class="text-sm font-medium text-slate-900 dark:text-white">{{ __('crm.egypt') }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">Cairo</div>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <div class="mt-3 {{ app()->getLocale() == 'ar' ? 'pr-7' : 'pl-7' }}">
                            <label class="flex items-center gap-1 text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">
                                <span class="inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded">+</span>
                                {{ __('crm.additional_price') }} <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">({{ app()->getLocale() == 'ar' ? 'شهري' : 'Monthly' }})</span>
                            </label>
                            <input type="number" name="datacenter_price[egypt]" step="0.01" min="0" value="{{ old('datacenter_price.egypt', $product->datacenter_price['egypt'] ?? 0) }}"
                                   class="datacenter-price-input w-full px-3 py-1.5 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white disabled:bg-slate-100 dark:disabled:bg-slate-800 disabled:cursor-not-allowed"
                                   placeholder="0.00">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Auto Setup Section -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
            <div class="bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-800 dark:to-slate-700 px-6 py-4 border-b border-slate-200 dark:border-slate-600">
                <h2 class="text-lg font-semibold text-slate-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ __('crm.auto_setup') }}
                </h2>
            </div>
            
            <div class="p-6">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-3">
                    {{ __('crm.auto_setup_option') }} <span class="text-red-500">*</span>
                </label>
                <p class="text-xs text-slate-500 dark:text-slate-400 mb-4">
                    {{ __('crm.auto_setup_desc') }}
                </p>
                
                <div class="space-y-3">
                    <!-- Option 1: As soon as order is placed -->
                    <label class="flex items-start p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                        <input type="radio" name="auto_setup" value="on_order" {{ old('auto_setup', $product->auto_setup) == 'on_order' ? 'checked' : '' }}
                               class="mt-1 w-4 h-4 text-blue-600 bg-white border-slate-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                        <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                            <div class="text-sm font-medium text-slate-900 dark:text-white">
                                {{ __('crm.auto_setup_on_order') }}
                            </div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                {{ __('crm.auto_setup_on_order_desc') }}
                            </p>
                        </div>
                    </label>

                    <!-- Option 2: As soon as first payment is received -->
                    <label class="flex items-start p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                        <input type="radio" name="auto_setup" value="on_payment" {{ old('auto_setup', $product->auto_setup) == 'on_payment' ? 'checked' : '' }}
                               class="mt-1 w-4 h-4 text-blue-600 bg-white border-slate-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                        <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                            <div class="text-sm font-medium text-slate-900 dark:text-white">
                                {{ __('crm.auto_setup_on_payment') }}
                            </div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                {{ __('crm.auto_setup_on_payment_desc') }}
                            </p>
                        </div>
                    </label>

                    <!-- Option 3: When manually accepting pending order -->
                    <label class="flex items-start p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                        <input type="radio" name="auto_setup" value="on_accept" {{ old('auto_setup', $product->auto_setup) == 'on_accept' ? 'checked' : '' }}
                               class="mt-1 w-4 h-4 text-blue-600 bg-white border-slate-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                        <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                            <div class="text-sm font-medium text-slate-900 dark:text-white">
                                {{ __('crm.auto_setup_on_accept') }}
                            </div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                {{ __('crm.auto_setup_on_accept_desc') }}
                            </p>
                        </div>
                    </label>

                    <!-- Option 4: Do not automatically setup -->
                    <label class="flex items-start p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                        <input type="radio" name="auto_setup" value="manual" {{ old('auto_setup', $product->auto_setup) == 'manual' ? 'checked' : '' }}
                               class="mt-1 w-4 h-4 text-blue-600 bg-white border-slate-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                        <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                            <div class="text-sm font-medium text-slate-900 dark:text-white">
                                {{ __('crm.auto_setup_manual') }}
                            </div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                {{ __('crm.auto_setup_manual_desc') }}
                            </p>
                        </div>
                    </label>
                </div>

                @error('auto_setup')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Free Domain Section -->
        <div x-data="{ freeDomainType: '{{ old('free_domain_type', $product->free_domain_config['type'] ?? 'none') }}' }" class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
            <div class="bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-800 dark:to-slate-700 px-6 py-4 border-b border-slate-200 dark:border-slate-600">
                <h2 class="text-lg font-semibold text-slate-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                    </svg>
                    {{ __('crm.free_domain') }}
                </h2>
            </div>
            
            <div class="p-6 space-y-6">
                <!-- Free Domain Type -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-3">
                        {{ __('crm.free_domain_type') }}
                    </label>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mb-4">
                        {{ __('crm.free_domain_type_desc') }}
                    </p>
                    
                    <div class="space-y-3">
                        <!-- Option 1: None -->
                        <label class="flex items-start p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                            <input type="radio" name="free_domain_type" value="none" x-model="freeDomainType" {{ old('free_domain_type', $product->free_domain_config['type'] ?? 'none') == 'none' ? 'checked' : '' }}
                                   class="mt-1 w-4 h-4 text-blue-600 bg-white border-slate-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                            <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                                <div class="text-sm font-medium text-slate-900 dark:text-white">
                                    {{ __('crm.free_domain_none') }}
                                </div>
                            </div>
                        </label>

                        <!-- Option 2: Registration/Transfer Only -->
                        <label class="flex items-start p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                            <input type="radio" name="free_domain_type" value="reg_transfer" x-model="freeDomainType" {{ old('free_domain_type', $product->free_domain_config['type'] ?? 'none') == 'reg_transfer' ? 'checked' : '' }}
                                   class="mt-1 w-4 h-4 text-blue-600 bg-white border-slate-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                            <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                                <div class="text-sm font-medium text-slate-900 dark:text-white">
                                    {{ __('crm.free_domain_reg_transfer') }}
                                </div>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                    {{ __('crm.free_domain_reg_transfer_desc') }}
                                </p>
                            </div>
                        </label>

                        <!-- Option 3: Registration/Transfer + Renewal -->
                        <label class="flex items-start p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                            <input type="radio" name="free_domain_type" value="reg_transfer_renewal" x-model="freeDomainType" {{ old('free_domain_type', $product->free_domain_config['type'] ?? 'none') == 'reg_transfer_renewal' ? 'checked' : '' }}
                                   class="mt-1 w-4 h-4 text-blue-600 bg-white border-slate-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                            <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                                <div class="text-sm font-medium text-slate-900 dark:text-white">
                                    {{ __('crm.free_domain_reg_transfer_renewal') }}
                                </div>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                    {{ __('crm.free_domain_reg_transfer_renewal_desc') }}
                                </p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Free Domain Payment Terms (shown when not "none") -->
                <div x-show="freeDomainType !== 'none'" x-transition class="space-y-6">
                    <!-- Payment Terms -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-3">
                            {{ __('crm.free_domain_payment_terms') }}
                        </label>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-4">
                            {{ __('crm.free_domain_payment_terms_desc') }}
                        </p>
                        
                        @php
                            $savedTerms = old('free_domain_terms', $product->free_domain_config['terms'] ?? []);
                        @endphp
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                            <!-- One Time -->
                            <label class="flex items-center p-3 bg-slate-50 dark:bg-slate-800/50 rounded-lg border border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-all has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                                <input type="checkbox" name="free_domain_terms[]" value="one_time" {{ in_array('one_time', $savedTerms) ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                                <span class="{{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }} text-sm text-slate-900 dark:text-white">{{ __('crm.one_time') }}</span>
                            </label>

                            <!-- Monthly -->
                            <label class="flex items-center p-3 bg-slate-50 dark:bg-slate-800/50 rounded-lg border border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-all has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                                <input type="checkbox" name="free_domain_terms[]" value="monthly" {{ in_array('monthly', $savedTerms) ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                                <span class="{{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }} text-sm text-slate-900 dark:text-white">{{ __('crm.monthly') }}</span>
                            </label>

                            <!-- Quarterly -->
                            <label class="flex items-center p-3 bg-slate-50 dark:bg-slate-800/50 rounded-lg border border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-all has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                                <input type="checkbox" name="free_domain_terms[]" value="quarterly" {{ in_array('quarterly', $savedTerms) ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                                <span class="{{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }} text-sm text-slate-900 dark:text-white">{{ __('crm.quarterly') }}</span>
                            </label>

                            <!-- Semi-Annually -->
                            <label class="flex items-center p-3 bg-slate-50 dark:bg-slate-800/50 rounded-lg border border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-all has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                                <input type="checkbox" name="free_domain_terms[]" value="semi_annually" {{ in_array('semi_annually', $savedTerms) ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                                <span class="{{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }} text-sm text-slate-900 dark:text-white">{{ __('crm.semi_annually') }}</span>
                            </label>

                            <!-- Annually -->
                            <label class="flex items-center p-3 bg-slate-50 dark:bg-slate-800/50 rounded-lg border border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-all has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                                <input type="checkbox" name="free_domain_terms[]" value="annually" {{ in_array('annually', $savedTerms) ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                                <span class="{{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }} text-sm text-slate-900 dark:text-white">{{ __('crm.annually') }}</span>
                            </label>

                            <!-- Biennially -->
                            <label class="flex items-center p-3 bg-slate-50 dark:bg-slate-800/50 rounded-lg border border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-all has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                                <input type="checkbox" name="free_domain_terms[]" value="biennially" {{ in_array('biennially', $savedTerms) ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                                <span class="{{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }} text-sm text-slate-900 dark:text-white">{{ __('crm.biennially') }}</span>
                            </label>

                            <!-- Triennially -->
                            <label class="flex items-center p-3 bg-slate-50 dark:bg-slate-800/50 rounded-lg border border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-all has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                                <input type="checkbox" name="free_domain_terms[]" value="triennially" {{ in_array('triennially', $savedTerms) ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                                <span class="{{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }} text-sm text-slate-900 dark:text-white">{{ __('crm.triennially') }}</span>
                            </label>
                        </div>
                    </div>

                    <!-- Free Domain TLDs -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-3">
                            {{ __('crm.free_domain_tlds') }}
                        </label>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-4">
                            {{ __('crm.free_domain_tlds_desc') }}
                        </p>
                        
                        <!-- Search TLDs -->
                        <div class="mb-4">
                            <input type="text" id="tld-search" placeholder="{{ __('crm.search_tlds') }}"
                                   class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                        </div>

                        <!-- TLD Checkboxes Container -->
                        <div class="bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-3 pb-3 border-b border-slate-200 dark:border-slate-700">
                                <div class="flex items-center gap-3">
                                    <button type="button" onclick="selectAllTLDs()" class="text-xs text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium">
                                        {{ __('crm.select_all') }}
                                    </button>
                                    <span class="text-slate-300 dark:text-slate-600">|</span>
                                    <button type="button" onclick="deselectAllTLDs()" class="text-xs text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium">
                                        {{ __('crm.deselect_all') }}
                                    </button>
                                </div>
                                <span class="text-xs text-slate-500 dark:text-slate-400">
                                    <span id="selected-tlds-count">0</span> {{ __('crm.selected') }}
                                </span>
                            </div>
                            
                            <div id="tld-checkboxes-container" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-2 max-h-96 overflow-y-auto">
                                <!-- TLDs will be loaded via JavaScript -->
                                <div class="col-span-full text-center py-8">
                                    <svg class="inline-block w-8 h-8 text-slate-400 dark:text-slate-600 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">{{ __('crm.loading_tlds') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-4">
            <a href="{{ route('admin.system-settings.products') }}" 
               class="px-6 py-2 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                {{ __('crm.cancel') }}
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                {{ __('crm.update_plan') }}
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function pricingForm() {
        return {
            paymentType: '{{ old('payment_type', $product->payment_type) }}'
        }
    }

    // Datacenter location price inputs enable/disable
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.datacenter-checkbox');
        
        checkboxes.forEach(checkbox => {
            const container = checkbox.closest('.relative');
            const priceInput = container.querySelector('.datacenter-price-input');
            
            // Set initial state
            if (priceInput) {
                priceInput.disabled = !checkbox.checked;
                if (!checkbox.checked) {
                    priceInput.classList.add('opacity-50');
                } else {
                    priceInput.classList.remove('opacity-50');
                }
            }
            
            // Handle change
            checkbox.addEventListener('change', function() {
                if (priceInput) {
                    priceInput.disabled = !this.checked;
                    if (!this.checked) {
                        priceInput.value = '0';
                        priceInput.classList.add('opacity-50');
                    } else {
                        priceInput.classList.remove('opacity-50');
                        priceInput.focus();
                    }
                }
            });
        });
    });

    // Load TLDs for Free Domain section
    let allTLDs = [];
    let selectedTLDsFromOld = @json(old('free_domain_tlds', $product->free_domain_config['tlds'] ?? []));
    
    document.addEventListener('DOMContentLoaded', async function() {
        await loadTLDs();
        updateSelectedCount();
    });

    async function loadTLDs() {
        try {
            const response = await fetch('{{ route('admin.system-settings.domains.pricing.list') }}?currency=USD');
            const data = await response.json();
            
            if (data.success) {
                allTLDs = data.pricing;
                renderTLDs(allTLDs);
            }
        } catch (error) {
            console.error('Error loading TLDs:', error);
            document.getElementById('tld-checkboxes-container').innerHTML = `
                <div class="col-span-full text-center py-8">
                    <p class="text-sm text-red-600 dark:text-red-400">{{ __('crm.error_loading_tlds') }}</p>
                </div>
            `;
        }
    }

    function renderTLDs(tlds) {
        const container = document.getElementById('tld-checkboxes-container');
        container.innerHTML = '';

        if (tlds.length === 0) {
            container.innerHTML = `
                <div class="col-span-full text-center py-8">
                    <p class="text-sm text-slate-500 dark:text-slate-400">{{ __('crm.no_tlds_found') }}</p>
                </div>
            `;
            return;
        }

        tlds.forEach(tld => {
            const isChecked = selectedTLDsFromOld.includes(tld.tld);
            const checkboxId = `tld-${tld.tld.replace(/\./g, '-')}`;
            const label = document.createElement('label');
            label.className = 'flex items-center gap-2 p-2 bg-white dark:bg-slate-800 rounded border border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-all has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20 tld-item';
            label.setAttribute('for', checkboxId);
            label.innerHTML = `
                <input type="checkbox" id="${checkboxId}" name="free_domain_tlds[]" value="${tld.tld}"
                       ${isChecked ? 'checked' : ''}
                       onchange="updateSelectedCount()"
                       class="w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                <span class="text-sm text-slate-900 dark:text-white" dir="ltr">.${tld.tld}</span>
            `;
            container.appendChild(label);
        });
    }

    // Search TLDs
    const tldSearchInput = document.getElementById('tld-search');
    if (tldSearchInput) {
        tldSearchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase().replace(/^\./, '');
            const filteredTLDs = allTLDs.filter(tld => tld.tld.toLowerCase().includes(searchTerm));
            renderTLDs(filteredTLDs);
        });
    }

    // Select/Deselect all TLDs
    function selectAllTLDs() {
        const checkboxes = document.querySelectorAll('#tld-checkboxes-container input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            if (!checkbox.checked) {
                checkbox.checked = true;
            }
        });
        updateSelectedCount();
    }

    function deselectAllTLDs() {
        const checkboxes = document.querySelectorAll('#tld-checkboxes-container input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        updateSelectedCount();
    }

    // Update selected count
    function updateSelectedCount() {
        const checkboxes = document.querySelectorAll('#tld-checkboxes-container input[type="checkbox"]:checked');
        const countElement = document.getElementById('selected-tlds-count');
        if (countElement) {
            countElement.textContent = checkboxes.length;
        }
    }
</script>
@endpush

@endsection
