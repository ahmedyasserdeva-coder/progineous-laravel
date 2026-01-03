@extends('admin.layout')

@section('page-title', __('crm.edit_vps_plan'))

@section('content')
<div class="container mx-auto px-4 py-8 max-w-5xl">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">
            {{ __('crm.edit_vps_plan') }}
        </h1>
        <p class="text-slate-600 dark:text-slate-400">
            {{ __('crm.edit_vps_plan_description') }}
        </p>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.system-settings.products.vps-plans.update', $vpsPlan) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Basic Information -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">{{ __('crm.basic_information') }}</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Plan Name -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.plan_name') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="plan_name" value="{{ old('plan_name', $vpsPlan->plan_name) }}" required
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
                    <input type="text" name="plan_tagline" value="{{ old('plan_tagline', $vpsPlan->plan_tagline) }}"
                           class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-slate-700 dark:text-white">
                </div>

                <!-- Short Description -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.short_description') }}
                    </label>
                    <textarea name="plan_short_description" rows="2"
                              class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-slate-700 dark:text-white">{{ old('plan_short_description', $vpsPlan->plan_short_description) }}</textarea>
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
                    <input type="number" name="vcpu_count" value="{{ old('vcpu_count', $vpsPlan->vcpu_count) }}" required min="1"
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
                    <input type="number" name="ram_mb" value="{{ old('ram_mb', $vpsPlan->ram_mb) }}" required min="512"
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
                    <input type="number" name="storage_gb" value="{{ old('storage_gb', $vpsPlan->storage_gb) }}" required min="10"
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
                        <option value="SSD" {{ old('storage_type', $vpsPlan->storage_type) == 'SSD' ? 'selected' : '' }}>SSD</option>
                        <option value="NVMe" {{ old('storage_type', $vpsPlan->storage_type) == 'NVMe' ? 'selected' : '' }}>NVMe</option>
                    </select>
                </div>

                <!-- Bandwidth (GB) -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.bandwidth_gb') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="bandwidth_gb" value="{{ old('bandwidth_gb', $vpsPlan->bandwidth_gb) }}" required min="0"
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
                                <option value="{{ $type['name'] ?? '' }}" {{ old('hetzner_server_type', $vpsPlan->hetzner_server_type) == ($type['name'] ?? '') ? 'selected' : '' }}>
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
                                <option value="{{ $location['name'] ?? '' }}" {{ old('hetzner_location', $vpsPlan->hetzner_location) == ($location['name'] ?? '') ? 'selected' : '' }}>
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
                                       {{ in_array($image['name'] ?? '', old('os_options', $vpsPlan->os_options ?? [])) ? 'checked' : '' }}
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
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Monthly Price -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.monthly_price') }} ($) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="monthly_price" name="monthly_price" value="{{ old('monthly_price', $vpsPlan->monthly_price) }}" required min="0" step="0.01"
                           class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-slate-700 dark:text-white">
                    <p class="mt-1 text-xs text-blue-600 dark:text-blue-400">💡 {{ __('crm.auto_calculate_prices_hint') }}</p>
                </div>

                <!-- Quarterly Price -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.quarterly_price') }} ($)
                        <span class="text-xs text-slate-500">(3 {{ __('crm.months') }})</span>
                    </label>
                    <input type="number" id="quarterly_price" name="quarterly_price" value="{{ old('quarterly_price', $vpsPlan->quarterly_price) }}" min="0" step="0.01"
                           class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-slate-700 dark:text-white">
                    <p class="mt-1 text-xs text-green-600 dark:text-green-400" id="quarterly_discount"></p>
                </div>

                <!-- Semi-Annually Price -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.semi_annually_price') }} ($)
                        <span class="text-xs text-slate-500">(6 {{ __('crm.months') }})</span>
                    </label>
                    <input type="number" id="semi_annually_price" name="semi_annually_price" value="{{ old('semi_annually_price', $vpsPlan->semi_annually_price) }}" min="0" step="0.01"
                           class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-slate-700 dark:text-white">
                    <p class="mt-1 text-xs text-green-600 dark:text-green-400" id="semi_annually_discount"></p>
                </div>

                <!-- Annually Price -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.annually_price') }} ($)
                        <span class="text-xs text-slate-500">(12 {{ __('crm.months') }})</span>
                    </label>
                    <input type="number" id="annually_price" name="annually_price" value="{{ old('annually_price', $vpsPlan->annually_price) }}" min="0" step="0.01"
                           class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-slate-700 dark:text-white">
                    <p class="mt-1 text-xs text-green-600 dark:text-green-400" id="annually_discount"></p>
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
            
            <!-- Hetzner Pricing Note -->
            <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 {{app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'}} flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-blue-900 dark:text-blue-300">{{ __('crm.hetzner_pricing_info') }}</p>
                        <p class="text-xs text-blue-800 dark:text-blue-400 mt-1">{{ __('crm.hetzner_pricing_description') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 p-6">
            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">{{ __('crm.settings') }}</h3>
            
            <div class="space-y-4">
                <!-- Active -->
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $vpsPlan->is_active) ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                    <span class="{{app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3'}} text-sm font-medium text-slate-700 dark:text-slate-300">
                        {{ __('crm.is_active') }}
                    </span>
                </label>

                <!-- Featured -->
                <label class="flex items-center">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $vpsPlan->is_featured) ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                    <span class="{{app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3'}} text-sm font-medium text-slate-700 dark:text-slate-300">
                        {{ __('crm.is_featured') }}
                    </span>
                </label>

                <!-- Allow SSH -->
                <label class="flex items-center">
                    <input type="checkbox" name="allow_ssh" value="1" {{ old('allow_ssh', $vpsPlan->allow_ssh) ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                    <span class="{{app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3'}} text-sm font-medium text-slate-700 dark:text-slate-300">
                        {{ __('crm.allow_ssh') }}
                    </span>
                </label>

                <!-- Allow Root -->
                <label class="flex items-center">
                    <input type="checkbox" name="allow_root" value="1" {{ old('allow_root', $vpsPlan->allow_root) ? 'checked' : '' }}
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
                {{ __('crm.update_plan') }}
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const monthlyInput = document.getElementById('monthly_price');
    const quarterlyInput = document.getElementById('quarterly_price');
    const semiAnnuallyInput = document.getElementById('semi_annually_price');
    const annuallyInput = document.getElementById('annually_price');
    
    const quarterlyDiscount = document.getElementById('quarterly_discount');
    const semiAnnuallyDiscount = document.getElementById('semi_annually_discount');
    const annuallyDiscount = document.getElementById('annually_discount');
    
    // Auto-calculate prices based on monthly price
    function autoCalculatePrices() {
        const monthlyPrice = parseFloat(monthlyInput.value) || 0;
        
        if (monthlyPrice > 0) {
            // Calculate with standard discounts
            // Quarterly: 3 months with 5% discount
            const quarterlyPrice = (monthlyPrice * 3 * 0.95).toFixed(2);
            // Semi-Annually: 6 months with 10% discount
            const semiAnnuallyPrice = (monthlyPrice * 6 * 0.90).toFixed(2);
            // Annually: 12 months with 15% discount
            const annuallyPrice = (monthlyPrice * 12 * 0.85).toFixed(2);
            
            // Set calculated values
            quarterlyInput.value = quarterlyPrice;
            semiAnnuallyInput.value = semiAnnuallyPrice;
            annuallyInput.value = annuallyPrice;
            
            // Calculate savings
            const quarterlySavings = (monthlyPrice * 3 - quarterlyPrice).toFixed(2);
            const semiAnnuallySavings = (monthlyPrice * 6 - semiAnnuallyPrice).toFixed(2);
            const annuallySavings = (monthlyPrice * 12 - annuallyPrice).toFixed(2);
            
            // Show discount information
            quarterlyDiscount.innerHTML = '<span class="text-green-600">✨ Save 5% ($' + quarterlySavings + ')</span>';
            semiAnnuallyDiscount.innerHTML = '<span class="text-green-600">✨ Save 10% ($' + semiAnnuallySavings + ')</span>';
            annuallyDiscount.innerHTML = '<span class="text-green-600">✨ Save 15% ($' + annuallySavings + ')</span>';
        } else {
            // Clear all if monthly price is 0 or empty
            quarterlyInput.value = '';
            semiAnnuallyInput.value = '';
            annuallyInput.value = '';
            quarterlyDiscount.textContent = '';
            semiAnnuallyDiscount.textContent = '';
            annuallyDiscount.textContent = '';
        }
    }
    
    // Event listeners for auto-calculation
    monthlyInput.addEventListener('input', autoCalculatePrices);
    
    // Initial calculation on page load
    autoCalculatePrices();
});
</script>

@endsection
