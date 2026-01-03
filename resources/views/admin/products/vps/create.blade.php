@extends('admin.layout')

@section('page-title', __('crm.add_vps_plan'))

@section('content')
<div class="container mx-auto px-4 py-8 max-w-5xl">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">
            {{ __('crm.add_vps_plan') }}
        </h1>
        <p class="text-slate-600 dark:text-slate-400">
            {{ __('crm.create_new_vps_plan') }}
        </p>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.system-settings.products.vps-plans.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Basic Information -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">{{ __('crm.basic_information') }}</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Plan Name -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.plan_name') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="plan_name" value="{{ old('plan_name') }}" required
                           class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-slate-700 dark:text-white">
                    @error('plan_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Plan Tagline -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.plan_tagline') }}
                    </label>
                    <input type="text" name="plan_tagline" value="{{ old('plan_tagline') }}"
                           class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-slate-700 dark:text-white">
                </div>

                <!-- Short Description -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.short_description') }}
                    </label>
                    <textarea name="plan_short_description" rows="2"
                              class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-slate-700 dark:text-white">{{ old('plan_short_description') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Server Specs -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">{{ __('crm.server_specifications') }}</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- vCPU Count -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.vcpu_count') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="vcpu_count" value="{{ old('vcpu_count', 1) }}" required min="1"
                           class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-slate-700 dark:text-white">
                    @error('vcpu_count')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- RAM (MB) -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.ram_mb') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="ram_mb" value="{{ old('ram_mb', 1024) }}" required min="512"
                           class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-slate-700 dark:text-white">
                    @error('ram_mb')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Storage (GB) -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.storage_gb') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="storage_gb" value="{{ old('storage_gb', 25) }}" required min="10"
                           class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-slate-700 dark:text-white">
                    @error('storage_gb')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Storage Type -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.storage_type') }} <span class="text-red-500">*</span>
                    </label>
                    <select name="storage_type" required
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-slate-700 dark:text-white">
                        <option value="SSD" {{ old('storage_type') == 'SSD' ? 'selected' : '' }}>SSD</option>
                        <option value="NVMe" {{ old('storage_type') == 'NVMe' ? 'selected' : '' }}>NVMe</option>
                    </select>
                </div>

                <!-- Bandwidth (GB) -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.bandwidth_gb') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="bandwidth_gb" value="{{ old('bandwidth_gb', 1000) }}" required min="0"
                           class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-slate-700 dark:text-white">
                    <p class="mt-1 text-xs text-slate-500">{{ __('crm.set_0_for_unlimited') }}</p>
                </div>
            </div>
        </div>

        <!-- Hetzner Configuration -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">{{ __('crm.hetzner_configuration') }}</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Hetzner Server Type -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.hetzner_server_type') }} <span class="text-red-500">*</span>
                    </label>
                    <select name="hetzner_server_type" required
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-slate-700 dark:text-white">
                        <option value="">{{ __('crm.select_server_type') }}</option>
                        @if(isset($serverTypes) && is_array($serverTypes))
                            @foreach($serverTypes as $type)
                                <option value="{{ $type['name'] ?? '' }}" {{ old('hetzner_server_type') == ($type['name'] ?? '') ? 'selected' : '' }}>
                                    {{ $type['name'] ?? '' }} - {{ $type['cores'] ?? 0 }} vCPU, {{ ($type['memory'] ?? 0) / 1024 }}GB RAM, {{ $type['disk'] ?? 0 }}GB - €{{ number_format($type['prices'][0]['price_monthly']['gross'] ?? 0, 2) }}/mo
                                </option>
                            @endforeach
                        @endif
                    </select>
                    <p class="mt-1 text-xs text-slate-500">{{ __('crm.hetzner_server_type_help') }}</p>
                    @error('hetzner_server_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Hetzner Location -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.hetzner_location') }}
                    </label>
                    <select name="hetzner_location"
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-slate-700 dark:text-white">
                        <option value="">{{ __('crm.select_location') }}</option>
                        @if(isset($locations) && is_array($locations))
                            @foreach($locations as $location)
                                <option value="{{ $location['name'] ?? '' }}" {{ old('hetzner_location') == ($location['name'] ?? '') ? 'selected' : '' }}>
                                    {{ $location['city'] ?? '' }} ({{ $location['country'] ?? '' }}) - {{ $location['name'] ?? '' }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    <p class="mt-1 text-xs text-slate-500">{{ __('crm.hetzner_location_help') }}</p>
                </div>
            </div>
        </div>

        <!-- Available Operating Systems -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">{{ __('crm.available_operating_systems') }}</h3>
            <p class="text-sm text-slate-600 dark:text-slate-400 mb-6">{{ __('crm.select_available_os_for_customers') }}</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                @if(isset($images) && is_array($images))
                    @foreach($images as $image)
                        @if(($image['type'] ?? '') === 'system')
                            <label class="flex items-center p-3 bg-slate-50 dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-700 hover:border-blue-500 dark:hover:border-blue-500 cursor-pointer transition-colors">
                                <input type="checkbox" name="os_options[]" value="{{ $image['name'] ?? '' }}" 
                                       {{ in_array($image['name'] ?? '', old('os_options', [])) ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                                <div class="{{app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3'}} flex-1">
                                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $image['description'] ?? $image['name'] ?? '' }}</span>
                                    @if(isset($image['os_flavor']))
                                        <span class="block text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ $image['os_flavor'] }}</span>
                                    @endif
                                </div>
                            </label>
                        @endif
                    @endforeach
                @else
                    <div class="col-span-3 text-center py-8 text-slate-500">
                        <svg class="w-12 h-12 mx-auto mb-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <p>{{ __('crm.no_operating_systems_available') }}</p>
                        <p class="text-xs mt-1">{{ __('crm.check_hetzner_api_connection') }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Pricing -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">{{ __('crm.pricing') }}</h3>
            
            <!-- Auto-calculation Info Notice -->
            <div class="mb-4 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 {{app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'}} flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="text-sm text-blue-900 dark:text-blue-300">
                        <span class="font-medium">{{ __('crm.auto_calculation_enabled') }}</span>
                        <p class="text-xs mt-1 text-blue-800 dark:text-blue-400">{{ __('crm.enter_monthly_price_auto_calculate') }}</p>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Monthly Price -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.monthly_price') }} ($) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="number" id="monthly_price_input" name="monthly_price" value="{{ old('monthly_price') }}" required min="0" step="0.01"
                               class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-slate-700 dark:text-white"
                               placeholder="0.00">
                        <div class="absolute inset-y-0 {{app()->getLocale() == 'ar' ? 'left-0 pl-3' : 'right-0 pr-3'}} flex items-center pointer-events-none">
                            <span class="text-slate-400 text-sm">/ {{ __('crm.month') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Quarterly Price -->
                <div>
                    <label class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-2 flex items-center">
                        {{ __('crm.quarterly_price') }} ($)
                        <span class="{{app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2'}} px-2 py-0.5 text-xs bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded">{{ __('crm.auto') }}</span>
                    </label>
                    <div class="relative">
                        <input type="number" id="quarterly_price_input" name="quarterly_price" value="{{ old('quarterly_price') }}" min="0" step="0.01"
                               class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-slate-700 dark:text-white"
                               placeholder="0.00">
                        <div class="absolute inset-y-0 {{app()->getLocale() == 'ar' ? 'left-0 pl-3' : 'right-0 pr-3'}} flex items-center pointer-events-none">
                            <span class="text-slate-400 text-sm">/ 3 {{ __('crm.months') }}</span>
                        </div>
                    </div>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('crm.quarterly_auto_hint') }}</p>
                </div>

                <!-- Semi-Annually Price -->
                <div>
                    <label class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-2 flex items-center">
                        {{ __('crm.semi_annually_price') }} ($)
                        <span class="{{app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2'}} px-2 py-0.5 text-xs bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded">{{ __('crm.auto') }}</span>
                    </label>
                    <div class="relative">
                        <input type="number" id="semi_annually_price_input" name="semi_annually_price" value="{{ old('semi_annually_price') }}" min="0" step="0.01"
                               class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-slate-700 dark:text-white"
                               placeholder="0.00">
                        <div class="absolute inset-y-0 {{app()->getLocale() == 'ar' ? 'left-0 pl-3' : 'right-0 pr-3'}} flex items-center pointer-events-none">
                            <span class="text-slate-400 text-sm">/ 6 {{ __('crm.months') }}</span>
                        </div>
                    </div>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('crm.semi_annually_auto_hint') }}</p>
                </div>

                <!-- Annually Price -->
                <div>
                    <label class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-2 flex items-center">
                        {{ __('crm.annually_price') }} ($)
                        <span class="{{app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2'}} px-2 py-0.5 text-xs bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded">{{ __('crm.auto') }}</span>
                    </label>
                    <div class="relative">
                        <input type="number" id="annually_price_input" name="annually_price" value="{{ old('annually_price') }}" min="0" step="0.01"
                               class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-slate-700 dark:text-white"
                               placeholder="0.00">
                        <div class="absolute inset-y-0 {{app()->getLocale() == 'ar' ? 'left-0 pl-3' : 'right-0 pr-3'}} flex items-center pointer-events-none">
                            <span class="text-slate-400 text-sm">/ {{ __('crm.year') }}</span>
                        </div>
                    </div>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('crm.annually_auto_hint') }}</p>
                </div>

                <!-- Setup Fee -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.setup_fee') }} ($)
                    </label>
                    <input type="number" name="setup_fee" value="{{ old('setup_fee', 0) }}" min="0" step="0.01"
                           class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-slate-700 dark:text-white">
                </div>
            </div>
            
            <!-- Automatic Backups Option -->
            <div class="mt-6 p-4 border border-slate-200 dark:border-slate-600 rounded-lg bg-slate-50 dark:bg-slate-900">
                <div class="flex items-start justify-between">
                    <div class="flex items-start">
                        <input type="checkbox" id="enable_backups" name="enable_backups" value="1" {{ old('enable_backups') ? 'checked' : '' }}
                               class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-blue-500 mt-0.5">
                        <div class="{{app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3'}}">
                            <label for="enable_backups" class="text-sm font-semibold text-slate-900 dark:text-white cursor-pointer flex items-center">
                                💾 {{ __('crm.enable_automatic_backups') }}
                                <span class="{{app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2'}} px-2 py-0.5 text-xs font-medium bg-amber-100 dark:bg-amber-900 text-amber-800 dark:text-amber-200 rounded">
                                    +20%
                                </span>
                            </label>
                            <p class="text-xs text-slate-600 dark:text-slate-400 mt-1">
                                {{ __('crm.automatic_backups_description') }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Backup Cost Calculation Display -->
                <div id="backup-cost-info" class="mt-3 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded hidden">
                    <div class="flex items-center text-sm">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400 {{app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'}}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        <div>
                            <span class="font-medium text-blue-900 dark:text-blue-300">{{ __('crm.backup_cost_calculation') }}:</span>
                            <div class="mt-1 space-y-1 text-xs text-blue-800 dark:text-blue-400">
                                <div class="flex items-center justify-between">
                                    <span>{{ __('crm.monthly_with_backup') }}:</span>
                                    <span id="monthly-with-backup" class="font-semibold">$0.00</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>{{ __('crm.quarterly_with_backup') }}:</span>
                                    <span id="quarterly-with-backup" class="font-semibold">$0.00</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>{{ __('crm.semi_annually_with_backup') }}:</span>
                                    <span id="semi-annually-with-backup" class="font-semibold">$0.00</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>{{ __('crm.annually_with_backup') }}:</span>
                                    <span id="annually-with-backup" class="font-semibold">$0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Advanced DDoS Protection Option -->
            <div class="mt-6 p-4 border border-slate-200 dark:border-slate-600 rounded-lg bg-slate-50 dark:bg-slate-900">
                <div class="flex items-start justify-between">
                    <div class="flex items-start">
                        <input type="checkbox" id="enable_ddos_protection" name="enable_ddos_protection" value="1" {{ old('enable_ddos_protection') ? 'checked' : '' }}
                               class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-blue-500 mt-0.5">
                        <div class="{{app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3'}}">
                            <label for="enable_ddos_protection" class="text-sm font-semibold text-slate-900 dark:text-white cursor-pointer flex items-center">
                                🛡️ {{ __('crm.enable_advanced_ddos_protection') }}
                                <span class="{{app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2'}} px-2 py-0.5 text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded">
                                    +$10/mo
                                </span>
                            </label>
                            <p class="text-xs text-slate-600 dark:text-slate-400 mt-1">
                                {{ __('crm.advanced_ddos_protection_description') }}
                            </p>
                            <div class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                                <div class="flex items-center">
                                    <svg class="w-3 h-3 text-green-600 dark:text-green-400 {{app()->getLocale() == 'ar' ? 'ml-1' : 'mr-1'}}" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>{{ __('crm.ddos_basic_free') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- DDoS Cost Calculation Display -->
                <div id="ddos-cost-info" class="mt-3 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded hidden">
                    <div class="flex items-center text-sm">
                        <svg class="w-4 h-4 text-green-600 dark:text-green-400 {{app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'}}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <div>
                            <span class="font-medium text-green-900 dark:text-green-300">{{ __('crm.ddos_cost_calculation') }}:</span>
                            <div class="mt-1 space-y-1 text-xs text-green-800 dark:text-green-400">
                                <div class="flex items-center justify-between">
                                    <span>{{ __('crm.monthly_with_ddos') }}:</span>
                                    <span id="monthly-with-ddos" class="font-semibold">$0.00</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>{{ __('crm.quarterly_with_ddos') }}:</span>
                                    <span id="quarterly-with-ddos" class="font-semibold">$0.00</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>{{ __('crm.semi_annually_with_ddos') }}:</span>
                                    <span id="semi-annually-with-ddos" class="font-semibold">$0.00</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>{{ __('crm.annually_with_ddos') }}:</span>
                                    <span id="annually-with-ddos" class="font-semibold">$0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Additional IPv4 Addresses Option -->
            <div class="mt-6 p-4 border border-slate-200 dark:border-slate-600 rounded-lg bg-slate-50 dark:bg-slate-900">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex-1">
                        <label class="text-sm font-semibold text-slate-900 dark:text-white flex items-center">
                            🌐 {{ __('crm.additional_ipv4_addresses') }}
                            <span class="{{app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2'}} px-2 py-0.5 text-xs font-medium bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 rounded">
                                +$3/mo each
                            </span>
                        </label>
                        <p class="text-xs text-slate-600 dark:text-slate-400 mt-1">
                            {{ __('crm.additional_ipv4_description') }}
                        </p>
                        <div class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-green-600 dark:text-green-400 {{app()->getLocale() == 'ar' ? 'ml-1' : 'mr-1'}}" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ __('crm.one_ipv4_included_free') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center space-x-3 {{app()->getLocale() == 'ar' ? 'space-x-reverse' : ''}}">
                    <label class="text-xs text-slate-700 dark:text-slate-300">{{ __('crm.number_of_additional_ipv4') }}:</label>
                    <input type="number" id="ipv4_count" name="ipv4_count" value="{{ old('ipv4_count', 1) }}" min="1" max="10"
                           class="w-24 px-3 py-1.5 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white text-sm">
                    <span class="text-xs text-slate-500 dark:text-slate-400">{{ __('crm.ipv4_note_one_free') }}</span>
                </div>
                
                <!-- IPv4 Cost Calculation Display -->
                <div id="ipv4-cost-info" class="mt-3 p-3 bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-700 rounded hidden">
                    <div class="flex items-center text-sm">
                        <svg class="w-4 h-4 text-purple-600 dark:text-purple-400 {{app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'}}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                        </svg>
                        <div>
                            <span class="font-medium text-purple-900 dark:text-purple-300">{{ __('crm.ipv4_cost_calculation') }}:</span>
                            <div class="mt-1 space-y-1 text-xs text-purple-800 dark:text-purple-400">
                                <div class="flex items-center justify-between">
                                    <span>{{ __('crm.monthly_with_ipv4') }}:</span>
                                    <span id="monthly-with-ipv4" class="font-semibold">$0.00</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>{{ __('crm.quarterly_with_ipv4') }}:</span>
                                    <span id="quarterly-with-ipv4" class="font-semibold">$0.00</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>{{ __('crm.semi_annually_with_ipv4') }}:</span>
                                    <span id="semi-annually-with-ipv4" class="font-semibold">$0.00</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>{{ __('crm.annually_with_ipv4') }}:</span>
                                    <span id="annually-with-ipv4" class="font-semibold">$0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- IPv6 Support Toggle -->
            <div class="mt-4 p-4 border border-slate-200 dark:border-slate-600 rounded-lg bg-slate-50 dark:bg-slate-900">
                <label class="flex items-start">
                    <input type="checkbox" name="enable_ipv6" value="1" {{ old('enable_ipv6', true) ? 'checked' : '' }}
                           class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-blue-500 mt-0.5">
                    <div class="{{app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3'}} flex-1">
                        <span class="text-sm font-semibold text-slate-900 dark:text-white flex items-center">
                            🌐 {{ __('crm.enable_ipv6_support') }}
                            <span class="{{app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2'}} px-2 py-0.5 text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded">
                                {{ __('crm.free') }}
                            </span>
                        </span>
                        <p class="text-xs text-slate-600 dark:text-slate-400 mt-1">
                            {{ __('crm.ipv6_support_description') }}
                        </p>
                    </div>
                </label>
            </div>
        </div>

        <!-- Settings -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">{{ __('crm.settings') }}</h3>
            
            <div class="space-y-4">
                <!-- Active -->
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                    <span class="{{app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3'}} text-sm font-medium text-slate-700 dark:text-slate-300">
                        {{ __('crm.is_active') }}
                    </span>
                </label>

                <!-- Featured -->
                <label class="flex items-center">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                    <span class="{{app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3'}} text-sm font-medium text-slate-700 dark:text-slate-300">
                        {{ __('crm.is_featured') }}
                    </span>
                </label>

                <!-- Allow SSH -->
                <label class="flex items-center">
                    <input type="checkbox" name="allow_ssh" value="1" {{ old('allow_ssh', true) ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                    <span class="{{app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3'}} text-sm font-medium text-slate-700 dark:text-slate-300">
                        {{ __('crm.allow_ssh') }}
                    </span>
                </label>

                <!-- Allow Root -->
                <label class="flex items-center">
                    <input type="checkbox" name="allow_root" value="1" {{ old('allow_root', true) ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                    <span class="{{app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3'}} text-sm font-medium text-slate-700 dark:text-slate-300">
                        {{ __('crm.allow_root') }}
                    </span>
                </label>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-4">
            <a href="{{ route('admin.system-settings.products.vps-plans.index') }}" 
               class="px-6 py-3 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors">
                {{ __('crm.cancel') }}
            </a>
            <button type="submit" 
                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                {{ __('crm.create_plan') }}
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get pricing inputs
    const monthlyPriceInput = document.getElementById('monthly_price_input');
    const quarterlyPriceInput = document.getElementById('quarterly_price_input');
    const semiAnnuallyPriceInput = document.getElementById('semi_annually_price_input');
    const annuallyPriceInput = document.getElementById('annually_price_input');
    
    // Auto-calculate pricing when monthly price changes
    if (monthlyPriceInput) {
        monthlyPriceInput.addEventListener('input', function() {
            const monthlyPrice = parseFloat(this.value) || 0;
            
            if (monthlyPrice > 0) {
                // Calculate with standard discounts
                // Quarterly: 3 months with 5% discount
                const quarterlyPrice = (monthlyPrice * 3 * 0.95).toFixed(2);
                // Semi-Annually: 6 months with 10% discount  
                const semiAnnuallyPrice = (monthlyPrice * 6 * 0.90).toFixed(2);
                // Annually: 12 months with 15% discount
                const annuallyPrice = (monthlyPrice * 12 * 0.85).toFixed(2);
                
                // Fill the other price inputs
                if (quarterlyPriceInput) {
                    quarterlyPriceInput.value = quarterlyPrice;
                    quarterlyPriceInput.classList.add('border-green-500', 'bg-green-50', 'dark:bg-green-900/20');
                    setTimeout(() => {
                        quarterlyPriceInput.classList.remove('border-green-500', 'bg-green-50', 'dark:bg-green-900/20');
                    }, 1000);
                }
                
                if (semiAnnuallyPriceInput) {
                    semiAnnuallyPriceInput.value = semiAnnuallyPrice;
                    semiAnnuallyPriceInput.classList.add('border-green-500', 'bg-green-50', 'dark:bg-green-900/20');
                    setTimeout(() => {
                        semiAnnuallyPriceInput.classList.remove('border-green-500', 'bg-green-50', 'dark:bg-green-900/20');
                    }, 1000);
                }
                
                if (annuallyPriceInput) {
                    annuallyPriceInput.value = annuallyPrice;
                    annuallyPriceInput.classList.add('border-green-500', 'bg-green-50', 'dark:bg-green-900/20');
                    setTimeout(() => {
                        annuallyPriceInput.classList.remove('border-green-500', 'bg-green-50', 'dark:bg-green-900/20');
                    }, 1000);
                }
            } else {
                // Clear all if monthly price is 0 or empty
                if (quarterlyPriceInput) quarterlyPriceInput.value = '';
                if (semiAnnuallyPriceInput) semiAnnuallyPriceInput.value = '';
                if (annuallyPriceInput) annuallyPriceInput.value = '';
            }
        });
    }
});
</script>
        const monthlyWithIPv4 = monthly + ipv4MonthlyCost;
        const quarterlyWithIPv4 = quarterly > 0 ? quarterly + (ipv4MonthlyCost * 3) : (monthly * 3 + ipv4MonthlyCost * 3);
        const semiAnnuallyWithIPv4 = semiAnnually > 0 ? semiAnnually + (ipv4MonthlyCost * 6) : (monthly * 6 + ipv4MonthlyCost * 6);
        const annuallyWithIPv4 = annually > 0 ? annually + (ipv4MonthlyCost * 12) : (monthly * 12 + ipv4MonthlyCost * 12);
        
        monthlyIPv4Display.textContent = '$' + monthlyWithIPv4.toFixed(2);
        quarterlyIPv4Display.textContent = '$' + quarterlyWithIPv4.toFixed(2);
        semiAnnuallyIPv4Display.textContent = '$' + semiAnnuallyWithIPv4.toFixed(2);
        annuallyIPv4Display.textContent = '$' + annuallyWithIPv4.toFixed(2);
    }
    
    // Event listeners
    backupCheckbox.addEventListener('change', calculateBackupCosts);
    ddosCheckbox.addEventListener('change', calculateDDoSCosts);
    ipv4Input.addEventListener('input', calculateIPv4Costs);
    
    // Note: Monthly price input already has its own listener above for auto-calculation
    // Only need to update other price inputs for backup/DDoS/IPv4 recalculation
    quarterlyPriceInput.addEventListener('input', function() {
        calculateBackupCosts();
        calculateDDoSCosts();
        calculateIPv4Costs();
    });
    semiAnnuallyPriceInput.addEventListener('input', function() {
        calculateBackupCosts();
        calculateDDoSCosts();
        calculateIPv4Costs();
    });
    annuallyPriceInput.addEventListener('input', function() {
        calculateBackupCosts();
        calculateDDoSCosts();
        calculateIPv4Costs();
    });
    
    // Initial calculations if enabled
    if (backupCheckbox.checked) {
        calculateBackupCosts();
    }
    if (ddosCheckbox.checked) {
        calculateDDoSCosts();
    }
    if (parseInt(ipv4Input.value) > 0) {
        calculateIPv4Costs();
    }
});
</script>

@endsection
