@extends('admin.layout')

@section('page-title', __('crm.edit_dedicated_plan'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">
            {{ __('crm.edit_dedicated_plan') }}
        </h1>
        <p class="text-slate-600 dark:text-slate-400">
            {{ __('crm.edit_dedicated_plan_description') }}
        </p>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.system-settings.products.dedicated-plans.update', $dedicatedPlan) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Basic Information -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
            <h2 class="text-xl font-semibold text-slate-900 dark:text-white mb-4">
                {{ __('crm.basic_information') }}
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="plan_name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.plan_name') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="plan_name" id="plan_name" value="{{ old('plan_name', $dedicatedPlan->plan_name) }}" required
                           class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white">
                    @error('plan_name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="plan_tagline" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.plan_tagline') }}
                    </label>
                    <input type="text" name="plan_tagline" id="plan_tagline" value="{{ old('plan_tagline', $dedicatedPlan->plan_tagline) }}"
                           class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white">
                    @error('plan_tagline')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="plan_short_description" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.short_description') }}
                    </label>
                    <textarea name="plan_short_description" id="plan_short_description" rows="3"
                              class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white">{{ old('plan_short_description', $dedicatedPlan->plan_short_description) }}</textarea>
                    @error('plan_short_description')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Hardware Specifications -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
            <h2 class="text-xl font-semibold text-slate-900 dark:text-white mb-4">
                {{ __('crm.hardware_specifications') }}
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="cpu_type" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.cpu_type') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="cpu_type" id="cpu_type" value="{{ old('cpu_type', $dedicatedPlan->cpu_type) }}" required
                           placeholder="Intel Xeon E-2388G"
                           class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white">
                    @error('cpu_type')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="cpu_cores" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.cpu_cores') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="cpu_cores" id="cpu_cores" value="{{ old('cpu_cores', $dedicatedPlan->cpu_cores) }}" required min="1"
                           class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white">
                    @error('cpu_cores')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="cpu_threads" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.cpu_threads') }}
                    </label>
                    <input type="number" name="cpu_threads" id="cpu_threads" value="{{ old('cpu_threads', $dedicatedPlan->cpu_threads) }}" min="1"
                           class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white">
                    @error('cpu_threads')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="cpu_frequency" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.cpu_frequency') }}
                    </label>
                    <input type="text" name="cpu_frequency" id="cpu_frequency" value="{{ old('cpu_frequency', $dedicatedPlan->cpu_frequency) }}"
                           placeholder="3.2 GHz"
                           class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white">
                    @error('cpu_frequency')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="ram_gb" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.ram_gb') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="ram_gb" id="ram_gb" value="{{ old('ram_gb', $dedicatedPlan->ram_gb) }}" required min="1"
                           class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white">
                    @error('ram_gb')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="storage_type" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.storage_type') }} <span class="text-red-500">*</span>
                    </label>
                    <select name="storage_type" id="storage_type" required
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white">
                        <option value="SSD" {{ old('storage_type', $dedicatedPlan->storage_type) == 'SSD' ? 'selected' : '' }}>SSD</option>
                        <option value="NVMe" {{ old('storage_type', $dedicatedPlan->storage_type) == 'NVMe' ? 'selected' : '' }}>NVMe</option>
                        <option value="HDD" {{ old('storage_type', $dedicatedPlan->storage_type) == 'HDD' ? 'selected' : '' }}>HDD</option>
                        <option value="SATA" {{ old('storage_type', $dedicatedPlan->storage_type) == 'SATA' ? 'selected' : '' }}>SATA</option>
                    </select>
                    @error('storage_type')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="storage_total_gb" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.storage_total_gb') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="storage_total_gb" id="storage_total_gb" value="{{ old('storage_total_gb', $dedicatedPlan->storage_total_gb) }}" required min="10"
                           class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white"
                           onchange="updateStorageConfig()">
                    @error('storage_total_gb')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="disk_count" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.disk_count') }}
                    </label>
                    <input type="number" name="disk_count" id="disk_count" value="{{ old('disk_count', $dedicatedPlan->disk_count ?? 1) }}" min="1"
                           class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white"
                           onchange="updateStorageConfig()">
                    @error('disk_count')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('crm.disk_count_hint') }}</p>
                </div>

                <div>
                    <label for="storage_config" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.storage_config') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="storage_config" id="storage_config" value="{{ old('storage_config', $dedicatedPlan->storage_config) }}" required
                           placeholder="240 GB x 2 (SSD)"
                           class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white">
                    @error('storage_config')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('crm.storage_config_hint') }}</p>
                </div>
            </div>
        </div>

        <!-- Network Configuration -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
            <h2 class="text-xl font-semibold text-slate-900 dark:text-white mb-4">
                {{ __('crm.network_configuration') }}
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="bandwidth" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.bandwidth') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="bandwidth" id="bandwidth" value="{{ old('bandwidth', $dedicatedPlan->bandwidth) }}" required
                           placeholder="Unmetered or 10TB"
                           class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white">
                    @error('bandwidth')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="ipv4_count" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.ipv4_count') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="ipv4_count" id="ipv4_count" value="{{ old('ipv4_count', $dedicatedPlan->ipv4_count) }}" required min="1"
                           class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white">
                    @error('ipv4_count')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="enable_ipv6" class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2 cursor-pointer">
                        <input type="checkbox" name="enable_ipv6" id="enable_ipv6" value="1" {{ old('enable_ipv6', $dedicatedPlan->enable_ipv6) ? 'checked' : '' }}
                               class="w-5 h-5 text-purple-600 border-slate-300 rounded focus:ring-purple-500 dark:border-slate-600 dark:bg-slate-700">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ __('crm.enable_ipv6') }}</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Hetzner Configuration -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
            <h2 class="text-xl font-semibold text-slate-900 dark:text-white mb-4">
                {{ __('crm.hetzner_configuration') }}
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="hetzner_server_type" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.hetzner_server_type') }} <span class="text-red-500">*</span>
                    </label>
                    <select name="hetzner_server_type" id="hetzner_server_type" required
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white">
                        <option value="">{{ __('crm.select_server_type') }}</option>
                        @if(isset($serverTypes) && is_array($serverTypes))
                            @foreach($serverTypes as $type)
                                <option value="{{ $type['name'] ?? '' }}" {{ old('hetzner_server_type', $dedicatedPlan->hetzner_server_type) == ($type['name'] ?? '') ? 'selected' : '' }}>
                                    {{ $type['name'] ?? '' }} - {{ $type['cores'] ?? 0 }} vCPU, {{ ($type['memory'] ?? 0) / 1024 }}GB RAM, {{ $type['disk'] ?? 0 }}GB - €{{ number_format($type['prices'][0]['price_monthly']['gross'] ?? 0, 2) }}/mo
                                </option>
                            @endforeach
                        @endif
                    </select>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('crm.hetzner_server_type_help') }}</p>
                    @error('hetzner_server_type')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="hetzner_location" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.hetzner_location') }}
                    </label>
                    <select name="hetzner_location" id="hetzner_location"
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white">
                        <option value="">{{ __('crm.select_location') }}</option>
                        @if(isset($locations) && is_array($locations))
                            @foreach($locations as $location)
                                <option value="{{ $location['name'] ?? '' }}" {{ old('hetzner_location', $dedicatedPlan->hetzner_location) == ($location['name'] ?? '') ? 'selected' : '' }}>
                                    {{ $location['city'] ?? '' }} ({{ $location['country'] ?? '' }}) - {{ $location['name'] ?? '' }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('crm.hetzner_location_help') }}</p>
                </div>
            </div>
        </div>

        <!-- Pricing -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
            <h2 class="text-xl font-semibold text-slate-900 dark:text-white mb-4">
                {{ __('crm.pricing') }}
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="monthly_price" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.monthly_price') }} <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-slate-500 dark:text-slate-400">$</span>
                        <input type="number" name="monthly_price" id="monthly_price" value="{{ old('monthly_price', $dedicatedPlan->monthly_price) }}" required min="0" step="0.01"
                               class="w-full pl-8 pr-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white">
                    </div>
                    @error('monthly_price')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="quarterly_price" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.quarterly_price') }}
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-slate-500 dark:text-slate-400">$</span>
                        <input type="number" name="quarterly_price" id="quarterly_price" value="{{ old('quarterly_price', $dedicatedPlan->quarterly_price) }}" min="0" step="0.01"
                               class="w-full pl-8 pr-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white">
                    </div>
                    @error('quarterly_price')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="semi_annually_price" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.semi_annually_price') }}
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-slate-500 dark:text-slate-400">$</span>
                        <input type="number" name="semi_annually_price" id="semi_annually_price" value="{{ old('semi_annually_price', $dedicatedPlan->semi_annually_price) }}" min="0" step="0.01"
                               class="w-full pl-8 pr-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white">
                    </div>
                    @error('semi_annually_price')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="annually_price" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.annually_price') }}
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-slate-500 dark:text-slate-400">$</span>
                        <input type="number" name="annually_price" id="annually_price" value="{{ old('annually_price', $dedicatedPlan->annually_price) }}" min="0" step="0.01"
                               class="w-full pl-8 pr-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white">
                    </div>
                    @error('annually_price')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="setup_fee" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.setup_fee') }}
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-slate-500 dark:text-slate-400">$</span>
                        <input type="number" name="setup_fee" id="setup_fee" value="{{ old('setup_fee', $dedicatedPlan->setup_fee) }}" min="0" step="0.01"
                               class="w-full pl-8 pr-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white">
                    </div>
                    @error('setup_fee')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="setup_time" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.setup_time') }}
                    </label>
                    <input type="text" name="setup_time" id="setup_time" value="{{ old('setup_time', $dedicatedPlan->setup_time) }}"
                           placeholder="24-48 hours"
                           class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white">
                    @error('setup_time')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Control Panel Pricing -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
            <h2 class="text-xl font-semibold text-slate-900 dark:text-white mb-4">
                {{ __('crm.control_panel_pricing') }}
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="cpanel_price" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.cpanel_price') }}
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-slate-500 dark:text-slate-400">$</span>
                        <input type="number" name="cpanel_price" id="cpanel_price" value="{{ old('cpanel_price', $dedicatedPlan->cpanel_price) }}" min="0" step="0.01"
                               class="w-full pl-8 pr-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white">
                    </div>
                    @error('cpanel_price')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="plesk_price" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.plesk_price') }}
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-slate-500 dark:text-slate-400">$</span>
                        <input type="number" name="plesk_price" id="plesk_price" value="{{ old('plesk_price', $dedicatedPlan->plesk_price) }}" min="0" step="0.01"
                               class="w-full pl-8 pr-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white">
                    </div>
                    @error('plesk_price')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Management Options -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
            <h2 class="text-xl font-semibold text-slate-900 dark:text-white mb-4">
                {{ __('crm.management_options') }}
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="is_active" class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2 cursor-pointer">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $dedicatedPlan->is_active) ? 'checked' : '' }}
                               class="w-5 h-5 text-purple-600 border-slate-300 rounded focus:ring-purple-500 dark:border-slate-600 dark:bg-slate-700">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ __('crm.is_active') }}</span>
                    </label>
                </div>

                <div>
                    <label for="is_featured" class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2 cursor-pointer">
                        <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $dedicatedPlan->is_featured) ? 'checked' : '' }}
                               class="w-5 h-5 text-purple-600 border-slate-300 rounded focus:ring-purple-500 dark:border-slate-600 dark:bg-slate-700">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ __('crm.is_featured') }}</span>
                    </label>
                </div>

                <div>
                    <label for="auto_setup" class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2 cursor-pointer">
                        <input type="checkbox" name="auto_setup" id="auto_setup" value="1" {{ old('auto_setup', $dedicatedPlan->auto_setup) ? 'checked' : '' }}
                               class="w-5 h-5 text-purple-600 border-slate-300 rounded focus:ring-purple-500 dark:border-slate-600 dark:bg-slate-700">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ __('crm.auto_setup') }}</span>
                    </label>
                </div>

                <div>
                    <label for="requires_approval" class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2 cursor-pointer">
                        <input type="checkbox" name="requires_approval" id="requires_approval" value="1" {{ old('requires_approval', $dedicatedPlan->requires_approval) ? 'checked' : '' }}
                               class="w-5 h-5 text-purple-600 border-slate-300 rounded focus:ring-purple-500 dark:border-slate-600 dark:bg-slate-700">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ __('crm.requires_approval') }}</span>
                    </label>
                </div>

                <div>
                    <label for="allow_ipmi" class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2 cursor-pointer">
                        <input type="checkbox" name="allow_ipmi" id="allow_ipmi" value="1" {{ old('allow_ipmi', $dedicatedPlan->allow_ipmi) ? 'checked' : '' }}
                               class="w-5 h-5 text-purple-600 border-slate-300 rounded focus:ring-purple-500 dark:border-slate-600 dark:bg-slate-700">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ __('crm.allow_ipmi') }}</span>
                    </label>
                </div>

                <div>
                    <label for="allow_custom_os" class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2 cursor-pointer">
                        <input type="checkbox" name="allow_custom_os" id="allow_custom_os" value="1" {{ old('allow_custom_os', $dedicatedPlan->allow_custom_os) ? 'checked' : '' }}
                               class="w-5 h-5 text-purple-600 border-slate-300 rounded focus:ring-purple-500 dark:border-slate-600 dark:bg-slate-700">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ __('crm.allow_custom_os') }}</span>
                    </label>
                </div>

                <div>
                    <label for="allow_raid_config" class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2 cursor-pointer">
                        <input type="checkbox" name="allow_raid_config" id="allow_raid_config" value="1" {{ old('allow_raid_config', $dedicatedPlan->allow_raid_config) ? 'checked' : '' }}
                               class="w-5 h-5 text-purple-600 border-slate-300 rounded focus:ring-purple-500 dark:border-slate-600 dark:bg-slate-700">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ __('crm.allow_raid_config') }}</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-4">
            <a href="{{ route('admin.system-settings.products.dedicated-plans.index') }}" class="px-6 py-3 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 font-medium rounded-lg hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors">
                {{ __('crm.cancel') }}
            </a>
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-medium rounded-lg shadow-lg transition-colors">
                {{ __('crm.update_plan') }}
            </button>
        </div>
    </form>
</div>

<script>
function updateStorageConfig() {
    const storageTotal = document.getElementById('storage_total_gb').value;
    const diskCount = document.getElementById('disk_count').value || 1;
    const storageType = document.getElementById('storage_type').value;
    const storageConfig = document.getElementById('storage_config');
    
    if (storageTotal && storageType) {
        if (diskCount > 1) {
            storageConfig.value = `${storageTotal} GB x ${diskCount} (${storageType})`;
        } else {
            storageConfig.value = `${storageTotal} GB (${storageType})`;
        }
    }
}

// Update storage config when storage type changes
document.getElementById('storage_type').addEventListener('change', updateStorageConfig);
</script>
@endsection
