@extends('admin.layout')

@section('page-title', __('crm.add_shared_hosting'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-slate-700 hover:text-blue-600 dark:text-slate-400 dark:hover:text-white">
                    <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    {{ __('crm.dashboard') }}
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-slate-400 {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="{{ route('admin.system-settings.index') }}" class="{{ app()->getLocale() == 'ar' ? 'mr-1 md:mr-2' : 'ml-1 md:ml-2' }} text-sm font-medium text-slate-700 hover:text-blue-600 dark:text-slate-400 dark:hover:text-white">
                        {{ __('crm.system_settings') }}
                    </a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-slate-400 {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="{{ route('admin.system-settings.products') }}" class="{{ app()->getLocale() == 'ar' ? 'mr-1 md:mr-2' : 'ml-1 md:ml-2' }} text-sm font-medium text-slate-700 hover:text-blue-600 dark:text-slate-400 dark:hover:text-white">
                        {{ __('crm.products_services') }}
                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-slate-400 {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="{{ app()->getLocale() == 'ar' ? 'mr-1 md:mr-2' : 'ml-1 md:ml-2' }} text-sm font-medium text-slate-500 dark:text-slate-400">
                        {{ __('crm.add_shared_hosting') }}
                    </span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Header Card -->
    <div class="mb-6 bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white">{{ __('crm.add_shared_hosting') }}</h1>
                    <p class="text-blue-100 text-sm mt-1">{{ __('crm.manage_shared_hosting') }}</p>
                </div>
            </div>
            <a href="{{ route('admin.system-settings.products') }}" class="flex items-center gap-2 px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span class="hidden sm:inline">{{ __('crm.back') }}</span>
            </a>
        </div>
    </div>

    <!-- Form -->
    <form id="shared-hosting-form" action="{{ route('admin.system-settings.products.shared-hosting.store') }}" method="POST" class="space-y-6" onsubmit="return validateDomainRequirement()">
        @csrf

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
                    <input type="text" id="plan_name" name="plan_name" required
                           class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                           placeholder="{{ __('crm.plan_name') }}" value="{{ old('plan_name') }}">
                    @error('plan_name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Plan Tagline -->
                <div>
                    <label for="plan_tagline" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.plan_tagline') }}
                    </label>
                    <input type="text" id="plan_tagline" name="plan_tagline"
                           class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                           placeholder="{{ __('crm.plan_tagline') }}" value="{{ old('plan_tagline') }}">
                </div>

                <!-- Plan Short Description -->
                <div>
                    <label for="plan_short_description" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.plan_short_description') }}
                    </label>
                    <textarea id="plan_short_description" name="plan_short_description" rows="3"
                              class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                              placeholder="{{ __('crm.plan_short_description') }}">{{ old('plan_short_description') }}</textarea>
                </div>

                <!-- Plan Features -->
                <div>
                    <label for="plan_feature" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.plan_feature') }}
                    </label>
                    <textarea id="plan_feature" name="plan_feature" rows="5"
                              class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                              placeholder="{{ __('crm.plan_feature') }}">{{ old('plan_feature') }}</textarea>
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
                            <option value="{{ $template->id }}" {{ old('welcome_email') == $template->id ? 'selected' : '' }}>
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
                            <input type="checkbox" id="require_domain_checkbox" name="require_domain" value="1" {{ old('require_domain') ? 'checked' : '' }}
                                   class="mt-1 w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600"
                                   onchange="toggleDomainRequirement()">
                            <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }}">
                                <div class="text-sm font-medium text-slate-700 dark:text-slate-300">
                                    {{ __('crm.require_domain') }}
                                </div>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ __('crm.require_domain_desc') }}</p>
                            </div>
                        </label>
                    </div>

                    <!-- Featured -->
                    <div>
                        <label class="flex items-start p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                            <input type="checkbox" name="featured" value="1" {{ old('featured') ? 'checked' : '' }}
                                   class="mt-1 w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                            <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }}">
                                <div class="text-sm font-medium text-slate-700 dark:text-slate-300">
                                    {{ __('crm.featured') }}
                                </div>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ __('crm.featured_desc') }}</p>
                            </div>
                        </label>
                    </div>

                    <!-- Hidden -->
                    <div>
                        <label class="flex items-start p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                            <input type="checkbox" name="hidden" value="1" {{ old('hidden') ? 'checked' : '' }}
                                   class="mt-1 w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                            <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }}">
                                <div class="text-sm font-medium text-slate-700 dark:text-slate-300">
                                    {{ __('crm.hidden') }}
                                </div>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ __('crm.hidden_desc') }}</p>
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
                        <option value="free">{{ __('crm.free') }}</option>
                        <option value="one_time">{{ __('crm.one_time') }}</option>
                        <option value="recurring" selected>{{ __('crm.recurring') }}</option>
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
                                    <input type="number" name="one_time_setup_fee" step="0.01" min="0" value="{{ old('one_time_setup_fee', 0) }}"
                                           class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="number" name="one_time_price" step="0.01" min="0" value="{{ old('one_time_price', 0) }}"
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
                                    <input type="number" name="monthly_setup_fee" step="0.01" min="0" value="{{ old('monthly_setup_fee', 0) }}"
                                           class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <input type="number" id="monthly_price" name="monthly_price" step="0.01" min="0" value="{{ old('monthly_price', 0) }}"
                                           class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </td>
                            </tr>

                            <!-- Quarterly -->
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-white font-medium">
                                    {{ __('crm.quarterly') }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <input type="number" name="quarterly_setup_fee" step="0.01" min="0" value="{{ old('quarterly_setup_fee', 0) }}"
                                           class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <input type="number" name="quarterly_price" step="0.01" min="0" value="{{ old('quarterly_price', 0) }}"
                                           class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </td>
                            </tr>

                            <!-- Semi-Annually -->
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-white font-medium">
                                    {{ __('crm.semi_annually') }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <input type="number" name="semi_annually_setup_fee" step="0.01" min="0" value="{{ old('semi_annually_setup_fee', 0) }}"
                                           class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <input type="number" name="semi_annually_price" step="0.01" min="0" value="{{ old('semi_annually_price', 0) }}"
                                           class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </td>
                            </tr>

                            <!-- Annually -->
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-white font-medium">
                                    {{ __('crm.annually') }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <input type="number" name="annually_setup_fee" step="0.01" min="0" value="{{ old('annually_setup_fee', 0) }}"
                                           class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <input type="number" name="annually_price" step="0.01" min="0" value="{{ old('annually_price', 0) }}"
                                           class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </td>
                            </tr>

                            <!-- Biennially -->
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-white font-medium">
                                    {{ __('crm.biennially') }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <input type="number" name="biennially_setup_fee" step="0.01" min="0" value="{{ old('biennially_setup_fee', 0) }}"
                                           class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <input type="number" name="biennially_price" step="0.01" min="0" value="{{ old('biennially_price', 0) }}"
                                           class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </td>
                            </tr>

                            <!-- Triennially -->
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-white font-medium">
                                    {{ __('crm.triennially') }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <input type="number" name="triennially_setup_fee" step="0.01" min="0" value="{{ old('triennially_setup_fee', 0) }}"
                                           class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <input type="number" name="triennially_price" step="0.01" min="0" value="{{ old('triennially_price', 0) }}"
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
                            <input type="radio" name="allow_multiple_quantities" value="0" {{ old('allow_multiple_quantities', '0') == '0' ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 bg-white border-slate-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                            <span class="{{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }} text-sm text-slate-900 dark:text-white">{{ __('crm.no') }}</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="allow_multiple_quantities" value="1" {{ old('allow_multiple_quantities') == '1' ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 bg-white border-slate-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                            <span class="{{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }} text-sm text-slate-900 dark:text-white">{{ __('crm.yes') }}</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Server Section -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
            <div class="bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-800 dark:to-slate-700 px-6 py-4 border-b border-slate-200 dark:border-slate-600">
                <h2 class="text-lg font-semibold text-slate-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                    </svg>
                    {{ __('crm.server') }}
                </h2>
            </div>
            
            <div class="p-6 space-y-6">
                <!-- Server Selection -->
                <div>
                    <label for="server_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.select_server') }} <span class="text-red-500">*</span>
                    </label>
                    <select id="server_id" name="server_id" required
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                        <option value="">{{ __('crm.select_server') }}</option>
                        @forelse($servers as $server)
                            <option value="{{ $server->id }}" {{ old('server_id') == $server->id ? 'selected' : '' }}>
                                {{ $server->name }} - {{ $server->hostname }} ({{ ucfirst($server->type) }})
                            </option>
                        @empty
                            <option value="" disabled>{{ __('crm.no_servers_available') }}</option>
                        @endforelse
                    </select>
                    <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                        {{ __('crm.select_server_desc') }}
                    </p>
                    @error('server_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- WHM Package Selection -->
                <div>
                    <label for="whm_package_name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.whm_package_name') }} <span class="text-red-500">*</span>
                    </label>
                    <select id="whm_package_name" name="whm_package_name" required
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                            disabled>
                        <option value="">{{ __('crm.select_server_first') }}</option>
                    </select>
                    <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                        {{ __('crm.whm_package_desc') }}
                    </p>
                    @error('whm_package_name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Datacenter Locations -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-3">
                        {{ __('crm.datacenter_locations') }}
                    </label>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mb-2">
                        {{ __('crm.datacenter_locations_desc') }}
                    </p>
                    
                    <!-- Important Note -->
                    <div class="flex items-start gap-2 p-3 mb-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
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
                                <input type="checkbox" name="datacenter_locations[]" value="us-east" {{ is_array(old('datacenter_locations')) && in_array('us-east', old('datacenter_locations')) ? 'checked' : '' }}
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
                                    {{ __('crm.additional_price') }}
                                </label>
                                <input type="number" name="datacenter_price[us-east]" step="0.01" min="0" value="{{ old('datacenter_price.us-east', 0) }}"
                                       class="datacenter-price-input w-full px-3 py-1.5 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white disabled:bg-slate-100 dark:disabled:bg-slate-800 disabled:cursor-not-allowed opacity-50"
                                       placeholder="0.00" disabled>
                            </div>
                        </div>

                        <div class="relative p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="datacenter_locations[]" value="us-west" {{ is_array(old('datacenter_locations')) && in_array('us-west', old('datacenter_locations')) ? 'checked' : '' }}
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
                                <label class="flex items-center gap-1 text-xs font-medium text-slate-700 dark:text-slate-300 mb-1"><span class="inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded">+</span>{{ __("crm.additional_price") }} <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">({{ app()->getLocale() == 'ar' ? 'شهري' : 'Monthly' }})</span></label>
                                <input type="number" name="datacenter_price[us-west]" step="0.01" min="0" value="{{ old('datacenter_price.us-west', 0) }}"
                                       class="datacenter-price-input w-full px-3 py-1.5 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white disabled:bg-slate-100 dark:disabled:bg-slate-800 disabled:cursor-not-allowed"
                                       placeholder="0.00">
                            </div>
                        </div>

                        <div class="relative p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="datacenter_locations[]" value="us-central" {{ is_array(old('datacenter_locations')) && in_array('us-central', old('datacenter_locations')) ? 'checked' : '' }}
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
                                <label class="flex items-center gap-1 text-xs font-medium text-slate-700 dark:text-slate-300 mb-1"><span class="inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded">+</span>{{ __("crm.additional_price") }} <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">({{ app()->getLocale() == 'ar' ? 'شهري' : 'Monthly' }})</span></label>
                                <input type="number" name="datacenter_price[us-central]" step="0.01" min="0" value="{{ old('datacenter_price.us-central', 0) }}"
                                       class="datacenter-price-input w-full px-3 py-1.5 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white disabled:bg-slate-100 dark:disabled:bg-slate-800 disabled:cursor-not-allowed opacity-50"
                                       placeholder="0.00" disabled>
                            </div>
                        </div>

                        <div class="relative p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="datacenter_locations[]" value="canada" {{ is_array(old('datacenter_locations')) && in_array('canada', old('datacenter_locations')) ? 'checked' : '' }}
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
                                <label class="flex items-center gap-1 text-xs font-medium text-slate-700 dark:text-slate-300 mb-1"><span class="inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded">+</span>{{ __("crm.additional_price") }} <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">({{ app()->getLocale() == 'ar' ? 'شهري' : 'Monthly' }})</span></label>
                                <input type="number" name="datacenter_price[canada]" step="0.01" min="0" value="{{ old('datacenter_price.canada', 0) }}"
                                       class="datacenter-price-input w-full px-3 py-1.5 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white disabled:bg-slate-100 dark:disabled:bg-slate-800 disabled:cursor-not-allowed opacity-50"
                                       placeholder="0.00" disabled>
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
                                <input type="checkbox" name="datacenter_locations[]" value="eu-west" {{ is_array(old('datacenter_locations')) && in_array('eu-west', old('datacenter_locations')) ? 'checked' : '' }}
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
                                <label class="flex items-center gap-1 text-xs font-medium text-slate-700 dark:text-slate-300 mb-1"><span class="inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded">+</span>{{ __("crm.additional_price") }} <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">({{ app()->getLocale() == 'ar' ? 'شهري' : 'Monthly' }})</span></label>
                                <input type="number" name="datacenter_price[eu-west]" step="0.01" min="0" value="{{ old('datacenter_price.eu-west', 0) }}"
                                       class="datacenter-price-input w-full px-3 py-1.5 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white disabled:bg-slate-100 dark:disabled:bg-slate-800 disabled:cursor-not-allowed opacity-50"
                                       placeholder="0.00" disabled>
                            </div>
                        </div>

                        <div class="relative p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="datacenter_locations[]" value="eu-central" {{ is_array(old('datacenter_locations')) && in_array('eu-central', old('datacenter_locations')) ? 'checked' : '' }}
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
                                <label class="flex items-center gap-1 text-xs font-medium text-slate-700 dark:text-slate-300 mb-1"><span class="inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded">+</span>{{ __("crm.additional_price") }} <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">({{ app()->getLocale() == 'ar' ? 'شهري' : 'Monthly' }})</span></label>
                                <input type="number" name="datacenter_price[eu-central]" step="0.01" min="0" value="{{ old('datacenter_price.eu-central', 0) }}"
                                       class="datacenter-price-input w-full px-3 py-1.5 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white disabled:bg-slate-100 dark:disabled:bg-slate-800 disabled:cursor-not-allowed opacity-50"
                                       placeholder="0.00" disabled>
                            </div>
                        </div>

                        <div class="relative p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="datacenter_locations[]" value="eu-north" {{ is_array(old('datacenter_locations')) && in_array('eu-north', old('datacenter_locations')) ? 'checked' : '' }}
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
                                <label class="flex items-center gap-1 text-xs font-medium text-slate-700 dark:text-slate-300 mb-1"><span class="inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded">+</span>{{ __("crm.additional_price") }} <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">({{ app()->getLocale() == 'ar' ? 'شهري' : 'Monthly' }})</span></label>
                                <input type="number" name="datacenter_price[eu-north]" step="0.01" min="0" value="{{ old('datacenter_price.eu-north', 0) }}"
                                       class="datacenter-price-input w-full px-3 py-1.5 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white disabled:bg-slate-100 dark:disabled:bg-slate-800 disabled:cursor-not-allowed opacity-50"
                                       placeholder="0.00" disabled>
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
                                <input type="checkbox" name="datacenter_locations[]" value="asia-east" {{ is_array(old('datacenter_locations')) && in_array('asia-east', old('datacenter_locations')) ? 'checked' : '' }}
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
                                <label class="flex items-center gap-1 text-xs font-medium text-slate-700 dark:text-slate-300 mb-1"><span class="inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded">+</span>{{ __("crm.additional_price") }} <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">({{ app()->getLocale() == 'ar' ? 'شهري' : 'Monthly' }})</span></label>
                                <input type="number" name="datacenter_price[asia-east]" step="0.01" min="0" value="{{ old('datacenter_price.asia-east', 0) }}"
                                       class="datacenter-price-input w-full px-3 py-1.5 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white disabled:bg-slate-100 dark:disabled:bg-slate-800 disabled:cursor-not-allowed opacity-50"
                                       placeholder="0.00" disabled>
                            </div>
                        </div>

                        <div class="relative p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="datacenter_locations[]" value="asia-south" {{ is_array(old('datacenter_locations')) && in_array('asia-south', old('datacenter_locations')) ? 'checked' : '' }}
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
                                <label class="flex items-center gap-1 text-xs font-medium text-slate-700 dark:text-slate-300 mb-1"><span class="inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded">+</span>{{ __("crm.additional_price") }} <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">({{ app()->getLocale() == 'ar' ? 'شهري' : 'Monthly' }})</span></label>
                                <input type="number" name="datacenter_price[asia-south]" step="0.01" min="0" value="{{ old('datacenter_price.asia-south', 0) }}"
                                       class="datacenter-price-input w-full px-3 py-1.5 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white disabled:bg-slate-100 dark:disabled:bg-slate-800 disabled:cursor-not-allowed opacity-50"
                                       placeholder="0.00" disabled>
                            </div>
                        </div>

                        <div class="relative p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="datacenter_locations[]" value="asia-pacific" {{ is_array(old('datacenter_locations')) && in_array('asia-pacific', old('datacenter_locations')) ? 'checked' : '' }}
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
                                <label class="flex items-center gap-1 text-xs font-medium text-slate-700 dark:text-slate-300 mb-1"><span class="inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded">+</span>{{ __("crm.additional_price") }} <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">({{ app()->getLocale() == 'ar' ? 'شهري' : 'Monthly' }})</span></label>
                                <input type="number" name="datacenter_price[asia-pacific]" step="0.01" min="0" value="{{ old('datacenter_price.asia-pacific', 0) }}"
                                       class="datacenter-price-input w-full px-3 py-1.5 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white disabled:bg-slate-100 dark:disabled:bg-slate-800 disabled:cursor-not-allowed opacity-50"
                                       placeholder="0.00" disabled>
                            </div>
                        </div>

                        <div class="relative p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="datacenter_locations[]" value="australia" {{ is_array(old('datacenter_locations')) && in_array('australia', old('datacenter_locations')) ? 'checked' : '' }}
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
                                <label class="flex items-center gap-1 text-xs font-medium text-slate-700 dark:text-slate-300 mb-1"><span class="inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded">+</span>{{ __("crm.additional_price") }} <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">({{ app()->getLocale() == 'ar' ? 'شهري' : 'Monthly' }})</span></label>
                                <input type="number" name="datacenter_price[australia]" step="0.01" min="0" value="{{ old('datacenter_price.australia', 0) }}"
                                       class="datacenter-price-input w-full px-3 py-1.5 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white disabled:bg-slate-100 dark:disabled:bg-slate-800 disabled:cursor-not-allowed opacity-50"
                                       placeholder="0.00" disabled>
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
                                <input type="checkbox" name="datacenter_locations[]" value="uae" {{ is_array(old('datacenter_locations')) && in_array('uae', old('datacenter_locations')) ? 'checked' : '' }}
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
                                <label class="flex items-center gap-1 text-xs font-medium text-slate-700 dark:text-slate-300 mb-1"><span class="inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded">+</span>{{ __("crm.additional_price") }} <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">({{ app()->getLocale() == 'ar' ? 'شهري' : 'Monthly' }})</span></label>
                                <input type="number" name="datacenter_price[uae]" step="0.01" min="0" value="{{ old('datacenter_price.uae', 0) }}"
                                       class="datacenter-price-input w-full px-3 py-1.5 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white disabled:bg-slate-100 dark:disabled:bg-slate-800 disabled:cursor-not-allowed opacity-50"
                                       placeholder="0.00" disabled>
                            </div>
                        </div>

                        <div class="relative p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="datacenter_locations[]" value="saudi-arabia" {{ is_array(old('datacenter_locations')) && in_array('saudi-arabia', old('datacenter_locations')) ? 'checked' : '' }}
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
                                <label class="flex items-center gap-1 text-xs font-medium text-slate-700 dark:text-slate-300 mb-1"><span class="inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded">+</span>{{ __("crm.additional_price") }} <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">({{ app()->getLocale() == 'ar' ? 'شهري' : 'Monthly' }})</span></label>
                                <input type="number" name="datacenter_price[saudi-arabia]" step="0.01" min="0" value="{{ old('datacenter_price.saudi-arabia', 0) }}"
                                       class="datacenter-price-input w-full px-3 py-1.5 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white disabled:bg-slate-100 dark:disabled:bg-slate-800 disabled:cursor-not-allowed opacity-50"
                                       placeholder="0.00" disabled>
                            </div>
                        </div>

                        <div class="relative p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="datacenter_locations[]" value="egypt" {{ is_array(old('datacenter_locations')) && in_array('egypt', old('datacenter_locations')) ? 'checked' : '' }}
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
                                <label class="flex items-center gap-1 text-xs font-medium text-slate-700 dark:text-slate-300 mb-1"><span class="inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded">+</span>{{ __("crm.additional_price") }} <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">({{ app()->getLocale() == 'ar' ? 'شهري' : 'Monthly' }})</span></label>
                                <input type="number" name="datacenter_price[egypt]" step="0.01" min="0" value="{{ old('datacenter_price.egypt', 0) }}"
                                       class="datacenter-price-input w-full px-3 py-1.5 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white disabled:bg-slate-100 dark:disabled:bg-slate-800 disabled:cursor-not-allowed opacity-50"
                                       placeholder="0.00" disabled>
                            </div>
                        </div>

                        <div class="relative p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="datacenter_locations[]" value="jordan" {{ is_array(old('datacenter_locations')) && in_array('jordan', old('datacenter_locations')) ? 'checked' : '' }}
                                       class="datacenter-checkbox w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                                <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                                    <div class="flex items-center gap-2">
                                        <span class="fi fi-jo text-2xl" style="font-size: 2rem; line-height: 1;"></span>
                                        <div>
                                            <div class="text-sm font-medium text-slate-900 dark:text-white">{{ __('crm.jordan') }}</div>
                                            <div class="text-xs text-slate-500 dark:text-slate-400">Amman</div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                            <div class="mt-3 {{ app()->getLocale() == 'ar' ? 'pr-7' : 'pl-7' }}">
                                <label class="flex items-center gap-1 text-xs font-medium text-slate-700 dark:text-slate-300 mb-1"><span class="inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded">+</span>{{ __("crm.additional_price") }} <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">({{ app()->getLocale() == 'ar' ? 'شهري' : 'Monthly' }})</span></label>
                                <input type="number" name="datacenter_price[jordan]" step="0.01" min="0" value="{{ old('datacenter_price.jordan', 0) }}"
                                       class="datacenter-price-input w-full px-3 py-1.5 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white disabled:bg-slate-100 dark:disabled:bg-slate-800 disabled:cursor-not-allowed opacity-50"
                                       placeholder="0.00" disabled>
                            </div>
                        </div>

                        <div class="relative p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="datacenter_locations[]" value="bahrain" {{ is_array(old('datacenter_locations')) && in_array('bahrain', old('datacenter_locations')) ? 'checked' : '' }}
                                       class="datacenter-checkbox w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                                <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                                    <div class="flex items-center gap-2">
                                        <span class="fi fi-bh text-2xl" style="font-size: 2rem; line-height: 1;"></span>
                                        <div>
                                            <div class="text-sm font-medium text-slate-900 dark:text-white">{{ __('crm.bahrain') }}</div>
                                            <div class="text-xs text-slate-500 dark:text-slate-400">Manama</div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                            <div class="mt-3 {{ app()->getLocale() == 'ar' ? 'pr-7' : 'pl-7' }}">
                                <label class="flex items-center gap-1 text-xs font-medium text-slate-700 dark:text-slate-300 mb-1"><span class="inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded">+</span>{{ __("crm.additional_price") }} <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">({{ app()->getLocale() == 'ar' ? 'شهري' : 'Monthly' }})</span></label>
                                <input type="number" name="datacenter_price[bahrain]" step="0.01" min="0" value="{{ old('datacenter_price.bahrain', 0) }}"
                                       class="datacenter-price-input w-full px-3 py-1.5 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white disabled:bg-slate-100 dark:disabled:bg-slate-800 disabled:cursor-not-allowed opacity-50"
                                       placeholder="0.00" disabled>
                            </div>
                        </div>

                        <div class="relative p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="datacenter_locations[]" value="kuwait" {{ is_array(old('datacenter_locations')) && in_array('kuwait', old('datacenter_locations')) ? 'checked' : '' }}
                                       class="datacenter-checkbox w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                                <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                                    <div class="flex items-center gap-2">
                                        <span class="fi fi-kw text-2xl" style="font-size: 2rem; line-height: 1;"></span>
                                        <div>
                                            <div class="text-sm font-medium text-slate-900 dark:text-white">{{ __('crm.kuwait') }}</div>
                                            <div class="text-xs text-slate-500 dark:text-slate-400">Kuwait City</div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                            <div class="mt-3 {{ app()->getLocale() == 'ar' ? 'pr-7' : 'pl-7' }}">
                                <label class="flex items-center gap-1 text-xs font-medium text-slate-700 dark:text-slate-300 mb-1"><span class="inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded">+</span>{{ __("crm.additional_price") }} <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">({{ app()->getLocale() == 'ar' ? 'شهري' : 'Monthly' }})</span></label>
                                <input type="number" name="datacenter_price[kuwait]" step="0.01" min="0" value="{{ old('datacenter_price.kuwait', 0) }}"
                                       class="datacenter-price-input w-full px-3 py-1.5 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white disabled:bg-slate-100 dark:disabled:bg-slate-800 disabled:cursor-not-allowed opacity-50"
                                       placeholder="0.00" disabled>
                            </div>
                        </div>

                        <div class="relative p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="datacenter_locations[]" value="africa" {{ is_array(old('datacenter_locations')) && in_array('africa', old('datacenter_locations')) ? 'checked' : '' }}
                                       class="datacenter-checkbox w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                                <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                                    <div class="flex items-center gap-2">
                                        <span class="fi fi-za text-2xl" style="font-size: 2rem; line-height: 1;"></span>
                                        <div>
                                            <div class="text-sm font-medium text-slate-900 dark:text-white">{{ __('crm.africa') }}</div>
                                            <div class="text-xs text-slate-500 dark:text-slate-400">South Africa</div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                            <div class="mt-3 {{ app()->getLocale() == 'ar' ? 'pr-7' : 'pl-7' }}">
                                <label class="flex items-center gap-1 text-xs font-medium text-slate-700 dark:text-slate-300 mb-1"><span class="inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded">+</span>{{ __("crm.additional_price") }} <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">({{ app()->getLocale() == 'ar' ? 'شهري' : 'Monthly' }})</span></label>
                                <input type="number" name="datacenter_price[africa]" step="0.01" min="0" value="{{ old('datacenter_price.africa', 0) }}"
                                       class="datacenter-price-input w-full px-3 py-1.5 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white disabled:bg-slate-100 dark:disabled:bg-slate-800 disabled:cursor-not-allowed opacity-50"
                                       placeholder="0.00" disabled>
                            </div>
                        </div>

                        <div class="relative p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="datacenter_locations[]" value="south-america" {{ is_array(old('datacenter_locations')) && in_array('south-america', old('datacenter_locations')) ? 'checked' : '' }}
                                       class="datacenter-checkbox w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                                <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                                    <div class="flex items-center gap-2">
                                        <span class="fi fi-br text-2xl" style="font-size: 2rem; line-height: 1;"></span>
                                        <div>
                                            <div class="text-sm font-medium text-slate-900 dark:text-white">{{ __('crm.south_america') }}</div>
                                            <div class="text-xs text-slate-500 dark:text-slate-400">São Paulo</div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                            <div class="mt-3 {{ app()->getLocale() == 'ar' ? 'pr-7' : 'pl-7' }}">
                                <label class="flex items-center gap-1 text-xs font-medium text-slate-700 dark:text-slate-300 mb-1"><span class="inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded">+</span>{{ __("crm.additional_price") }} <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">({{ app()->getLocale() == 'ar' ? 'شهري' : 'Monthly' }})</span></label>
                                <input type="number" name="datacenter_price[south-america]" step="0.01" min="0" value="{{ old('datacenter_price.south-america', 0) }}"
                                       class="datacenter-price-input w-full px-3 py-1.5 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white disabled:bg-slate-100 dark:disabled:bg-slate-800 disabled:cursor-not-allowed opacity-50"
                                       placeholder="0.00" disabled>
                            </div>
                        </div>
                    </div>

                    @error('datacenter_locations')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                @if($servers->isEmpty())
                    <!-- No Servers Warning -->
                    <div class="flex items-start gap-3 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                        <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                                {{ __('crm.no_servers_found') }}
                            </p>
                            <p class="mt-1 text-xs text-yellow-700 dark:text-yellow-300">
                                {{ __('crm.no_servers_warning') }}
                            </p>
                            <a href="{{ route('admin.system-settings.servers.create') }}" 
                               class="inline-flex items-center gap-2 mt-3 px-3 py-1.5 bg-yellow-600 hover:bg-yellow-700 text-white text-xs font-medium rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                {{ __('crm.add_server_now') }}
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Server Info Display (when server is selected) -->
                <div id="server-info" class="hidden p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-blue-800 dark:text-blue-200" id="server-info-title">
                                {{ __('crm.selected_server') }}
                            </p>
                            <div class="mt-2 space-y-1 text-xs text-blue-700 dark:text-blue-300" id="server-info-details">
                                <!-- Will be filled by JavaScript -->
                            </div>
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
                        <input type="radio" name="auto_setup" value="on_order" {{ old('auto_setup', 'on_payment') == 'on_order' ? 'checked' : '' }}
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
                        <input type="radio" name="auto_setup" value="on_payment" {{ old('auto_setup', 'on_payment') == 'on_payment' ? 'checked' : '' }}
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
                        <input type="radio" name="auto_setup" value="on_accept" {{ old('auto_setup') == 'on_accept' ? 'checked' : '' }}
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
                        <input type="radio" name="auto_setup" value="manual" {{ old('auto_setup') == 'manual' ? 'checked' : '' }}
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
        <div x-data="{ freeDomainType: '{{ old('free_domain_type', 'none') }}' }" class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
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
                            <input type="radio" name="free_domain_type" value="none" x-model="freeDomainType" {{ old('free_domain_type', 'none') == 'none' ? 'checked' : '' }}
                                   class="mt-1 w-4 h-4 text-blue-600 bg-white border-slate-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                            <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                                <div class="text-sm font-medium text-slate-900 dark:text-white">
                                    {{ __('crm.free_domain_none') }}
                                </div>
                            </div>
                        </label>

                        <!-- Option 2: Registration/Transfer Only -->
                        <label class="flex items-start p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border-2 border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-all hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                            <input type="radio" name="free_domain_type" value="reg_transfer" x-model="freeDomainType" {{ old('free_domain_type') == 'reg_transfer' ? 'checked' : '' }}
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
                            <input type="radio" name="free_domain_type" value="reg_transfer_renewal" x-model="freeDomainType" {{ old('free_domain_type') == 'reg_transfer_renewal' ? 'checked' : '' }}
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
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                            <!-- One Time -->
                            <label class="flex items-center p-3 bg-slate-50 dark:bg-slate-800/50 rounded-lg border border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-all has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                                <input type="checkbox" name="free_domain_terms[]" value="one_time" {{ (is_array(old('free_domain_terms')) && in_array('one_time', old('free_domain_terms'))) ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                                <span class="{{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }} text-sm text-slate-900 dark:text-white">{{ __('crm.one_time') }}</span>
                            </label>

                            <!-- Monthly -->
                            <label class="flex items-center p-3 bg-slate-50 dark:bg-slate-800/50 rounded-lg border border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-all has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                                <input type="checkbox" name="free_domain_terms[]" value="monthly" {{ (is_array(old('free_domain_terms')) && in_array('monthly', old('free_domain_terms'))) ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                                <span class="{{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }} text-sm text-slate-900 dark:text-white">{{ __('crm.monthly') }}</span>
                            </label>

                            <!-- Quarterly -->
                            <label class="flex items-center p-3 bg-slate-50 dark:bg-slate-800/50 rounded-lg border border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-all has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                                <input type="checkbox" name="free_domain_terms[]" value="quarterly" {{ (is_array(old('free_domain_terms')) && in_array('quarterly', old('free_domain_terms'))) ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                                <span class="{{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }} text-sm text-slate-900 dark:text-white">{{ __('crm.quarterly') }}</span>
                            </label>

                            <!-- Semi-Annually -->
                            <label class="flex items-center p-3 bg-slate-50 dark:bg-slate-800/50 rounded-lg border border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-all has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                                <input type="checkbox" name="free_domain_terms[]" value="semi_annually" {{ (is_array(old('free_domain_terms')) && in_array('semi_annually', old('free_domain_terms'))) ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                                <span class="{{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }} text-sm text-slate-900 dark:text-white">{{ __('crm.semi_annually') }}</span>
                            </label>

                            <!-- Annually -->
                            <label class="flex items-center p-3 bg-slate-50 dark:bg-slate-800/50 rounded-lg border border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-all has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                                <input type="checkbox" name="free_domain_terms[]" value="annually" {{ (is_array(old('free_domain_terms')) && in_array('annually', old('free_domain_terms'))) ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                                <span class="{{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }} text-sm text-slate-900 dark:text-white">{{ __('crm.annually') }}</span>
                            </label>

                            <!-- Biennially -->
                            <label class="flex items-center p-3 bg-slate-50 dark:bg-slate-800/50 rounded-lg border border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-all has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                                <input type="checkbox" name="free_domain_terms[]" value="biennially" {{ (is_array(old('free_domain_terms')) && in_array('biennially', old('free_domain_terms'))) ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                                <span class="{{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }} text-sm text-slate-900 dark:text-white">{{ __('crm.biennially') }}</span>
                            </label>

                            <!-- Triennially -->
                            <label class="flex items-center p-3 bg-slate-50 dark:bg-slate-800/50 rounded-lg border border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-all has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                                <input type="checkbox" name="free_domain_terms[]" value="triennially" {{ (is_array(old('free_domain_terms')) && in_array('triennially', old('free_domain_terms'))) ? 'checked' : '' }}
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

        <!-- Form Actions -->
        <div class="flex items-center justify-end gap-4 bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 px-6 py-4">
            <a href="{{ route('admin.system-settings.products') }}" 
               class="px-6 py-2 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors font-medium">
                {{ __('crm.cancel') }}
            </a>
            <button type="submit" 
                    class="flex items-center gap-2 px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ __('crm.save_plan') }}
            </button>
        </div>
    </form>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    .rtl-swal {
        direction: rtl;
    }
    .swal2-html-container ul {
        text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};
    }
</style>

<!-- Alpine.js Component for Pricing Logic -->
<script>
    function pricingForm() {
        return {
            paymentType: '{{ old('payment_type', 'recurring') }}',
        }
    }
</script>

<!-- Server Selection Logic -->
<script>
    // Server data from backend
    const serversData = {!! json_encode($servers->map(function($server) {
        return [
            'id' => $server->id,
            'name' => $server->name,
            'hostname' => $server->hostname,
            'ip_address' => $server->ip_address,
            'type' => $server->type,
            'status' => $server->status,
            'max_accounts' => $server->max_accounts,
            'assigned_ips' => $server->assigned_ips,
        ];
    })->keyBy('id')) !!};

    // Handle server selection
    document.getElementById('server_id').addEventListener('change', function() {
        const serverId = this.value;
        const serverInfoDiv = document.getElementById('server-info');
        const serverInfoDetails = document.getElementById('server-info-details');
        const whmPackageSelect = document.getElementById('whm_package_name');
        
        if (serverId && serversData[serverId]) {
            const server = serversData[serverId];
            
            // Build server info HTML
            let infoHtml = `
                <div><strong>{{ __('crm.hostname') }}:</strong> <span dir="ltr">${server.hostname}</span></div>
                <div><strong>{{ __('crm.ip_address') }}:</strong> <span dir="ltr">${server.ip_address || '{{ __('crm.not_available') }}'}</span></div>
                <div><strong>{{ __('crm.type') }}:</strong> ${server.type.charAt(0).toUpperCase() + server.type.slice(1)}</div>
                <div><strong>{{ __('crm.status') }}:</strong> 
                    <span class="inline-flex px-2 py-0.5 text-xs font-semibold rounded-full ${server.status ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300'}">
                        ${server.status ? '{{ __('crm.active') }}' : '{{ __('crm.inactive') }}'}
                    </span>
                </div>
            `;
            
            if (server.max_accounts) {
                infoHtml += `<div><strong>{{ __('crm.max_accounts') }}:</strong> ${server.max_accounts}</div>`;
            }
            
            if (server.assigned_ips) {
                infoHtml += `<div><strong>{{ __('crm.assigned_ips') }}:</strong> <span dir="ltr">${server.assigned_ips}</span></div>`;
            }
            
            serverInfoDetails.innerHTML = infoHtml;
            serverInfoDiv.classList.remove('hidden');
            
            // Load WHM packages for the selected server
            loadWHMPackages(serverId);
        } else {
            serverInfoDiv.classList.add('hidden');
            whmPackageSelect.disabled = true;
            whmPackageSelect.innerHTML = '<option value="">{{ __('crm.select_server_first') }}</option>';
        }
    });

    // Function to load WHM packages
    function loadWHMPackages(serverId) {
        const whmPackageSelect = document.getElementById('whm_package_name');
        
        // Show loading state
        whmPackageSelect.disabled = true;
        whmPackageSelect.innerHTML = '<option value="">{{ __('crm.loading_packages') }}</option>';
        
        // Fetch packages from server using Laravel route
        const url = `{{ url('unleasha/system-settings/servers') }}/${serverId}/whm-packages`;
        
        console.log('Fetching WHM packages from:', url);
        
        fetch(url)
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                return response.json();
            })
            .then(data => {
                console.log('Received data:', data);
                
                if (data.success && data.packages && data.packages.length > 0) {
                    let optionsHtml = '<option value="">{{ __('crm.select_whm_package') }}</option>';
                    data.packages.forEach(pkg => {
                        const selected = '{{ old('whm_package_name') }}' === pkg.name ? 'selected' : '';
                        optionsHtml += `<option value="${pkg.name}" ${selected}>${pkg.name}</option>`;
                    });
                    whmPackageSelect.innerHTML = optionsHtml;
                    whmPackageSelect.disabled = false;
                } else {
                    const errorMsg = data.message || '{{ __('crm.no_packages_available') }}';
                    whmPackageSelect.innerHTML = `<option value="">${errorMsg}</option>`;
                    whmPackageSelect.disabled = true;
                }
            })
            .catch(error => {
                console.error('Error loading WHM packages:', error);
                whmPackageSelect.innerHTML = '<option value="">{{ __('crm.no_packages_available') }}</option>';
                whmPackageSelect.disabled = true;
            });
    }

    // Trigger on page load if there's an old value
    @if(old('server_id'))
        document.getElementById('server_id').dispatchEvent(new Event('change'));
    @endif

    // Load TLDs for Free Domain section
    let allTLDs = [];
    let selectedTLDsFromOld = @json(old('free_domain_tlds', []));
    
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
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('tld-search');
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase().replace(/^\./, '');
                const filteredTLDs = allTLDs.filter(tld => tld.tld.toLowerCase().includes(searchTerm));
                renderTLDs(filteredTLDs);
            });
        }
    });

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

    // Domain Requirement Validation
    function validateDomainRequirement() {
        const requireDomainChecked = document.getElementById('require_domain_checkbox').checked;
        const freeDomainTypeElement = document.querySelector('input[name="free_domain_type"]:checked');
        const freeDomainType = freeDomainTypeElement ? freeDomainTypeElement.value : 'none';
        
        if (requireDomainChecked && freeDomainType === 'none') {
            const isArabic = '{{ app()->getLocale() }}' === 'ar';
            
            // Show error alert
            Swal.fire({
                icon: 'error',
                title: isArabic ? 'تنبيه!' : 'Warning!',
                html: isArabic ? 
                    '<div class="text-right"><p class="mb-3">لقد قمت بتفعيل <strong>(Require Domain)</strong></p><p class="mb-3">يجب عليك اختيار أحد خيارات النطاق المجاني:</p><ul class="list-disc list-inside space-y-2 text-sm"><li>تسجيل نطاق جديد فقط</li><li>تسجيل نطاق جديد + التجديد</li></ul><p class="mt-4 text-amber-600">لا يمكن إنشاء الخطة بدون اختيار خيار النطاق المجاني عند تفعيل (Require Domain)</p></div>' : 
                    '<div class="text-left"><p class="mb-3">You have enabled <strong>(Require Domain)</strong></p><p class="mb-3">You must select one of the free domain options:</p><ul class="list-disc list-inside space-y-2 text-sm"><li>Registration/Transfer Only</li><li>Registration/Transfer + Renewal</li></ul><p class="mt-4 text-amber-600">Cannot create the plan without selecting a free domain option when (Require Domain) is enabled</p></div>',
                confirmButtonText: isArabic ? 'فهمت' : 'Got it',
                confirmButtonColor: '#3b82f6',
                customClass: {
                    popup: 'rtl-swal',
                    htmlContainer: isArabic ? 'text-right' : 'text-left'
                }
            });
            
            // Scroll to Free Domain section
            const freeDomainSection = document.querySelector('[x-data*="freeDomainType"]');
            if (freeDomainSection) {
                freeDomainSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
                setTimeout(() => {
                    freeDomainSection.classList.add('ring-4', 'ring-red-500', 'ring-offset-2');
                    setTimeout(() => {
                        freeDomainSection.classList.remove('ring-4', 'ring-red-500', 'ring-offset-2');
                    }, 3000);
                }, 500);
            }
            
            return false;
        }
        
        return true;
    }

    // Toggle domain requirement info
    function toggleDomainRequirement() {
        const requireDomainChecked = document.getElementById('require_domain_checkbox').checked;
        const freeDomainSection = document.querySelector('[x-data*="freeDomainType"]');
        
        if (requireDomainChecked && freeDomainSection) {
            // Highlight the Free Domain section
            freeDomainSection.classList.add('ring-2', 'ring-blue-500', 'ring-offset-2');
            setTimeout(() => {
                freeDomainSection.classList.remove('ring-2', 'ring-blue-500', 'ring-offset-2');
            }, 2000);
            
            // Show info message
            const freeDomainTypeElement = document.querySelector('input[name="free_domain_type"]:checked');
            const freeDomainType = freeDomainTypeElement ? freeDomainTypeElement.value : 'none';
            if (freeDomainType === 'none') {
                Swal.fire({
                    icon: 'info',
                    title: '{{ app()->getLocale() == "ar" ? "تذكير" : "Reminder" }}',
                    text: '{{ app()->getLocale() == "ar" ? 
                        "عند تفعيل \"Require Domain\"، يجب عليك اختيار خيار نطاق مجاني (تسجيل جديد أو تسجيل + تجديد)" : 
                        "When \"Require Domain\" is enabled, you must select a free domain option (Registration/Transfer or Registration/Transfer + Renewal)" 
                    }}',
                    confirmButtonText: '{{ app()->getLocale() == "ar" ? "فهمت" : "Understood" }}',
                    confirmButtonColor: '#3b82f6',
                    timer: 5000,
                    timerProgressBar: true
                });
            }
        }
    }

    // Datacenter pricing functionality
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.datacenter-checkbox');
        
        checkboxes.forEach(checkbox => {
            const card = checkbox.closest('.relative');
            const priceInput = card.querySelector('.datacenter-price-input');
            
            // Initialize state
            updatePriceInputState(checkbox, priceInput);
            
            // Listen for changes
            checkbox.addEventListener('change', function() {
                updatePriceInputState(this, priceInput);
            });
        });
        
        function updatePriceInputState(checkbox, priceInput) {
            if (checkbox.checked) {
                priceInput.disabled = false;
                priceInput.classList.remove('opacity-50');
            } else {
                priceInput.disabled = true;
                priceInput.value = 0;
                priceInput.classList.add('opacity-50');
            }
        }
    });

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Check initial state
        const requireDomainChecked = document.getElementById('require_domain_checkbox').checked;
        if (requireDomainChecked) {
            toggleDomainRequirement();
        }
        
        // Auto-calculate prices based on monthly price
        const monthlyPriceInput = document.getElementById('monthly_price');
        if (monthlyPriceInput) {
            monthlyPriceInput.addEventListener('input', function() {
                const monthlyPrice = parseFloat(this.value) || 0;
                
                // Calculate prices for each period (Monthly × number of months)
                document.querySelector('input[name="quarterly_price"]').value = (monthlyPrice * 3).toFixed(2);
                document.querySelector('input[name="semi_annually_price"]').value = (monthlyPrice * 6).toFixed(2);
                document.querySelector('input[name="annually_price"]').value = (monthlyPrice * 12).toFixed(2);
                document.querySelector('input[name="biennially_price"]').value = (monthlyPrice * 24).toFixed(2);
                document.querySelector('input[name="triennially_price"]').value = (monthlyPrice * 36).toFixed(2);
            });
        }
    });
</script>
@endsection



