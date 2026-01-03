@extends('admin.layout')

@section('title', __('crm.general_settings'))

@section('content')
<div class="p-6">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">
                    {{ __('crm.general_settings') }}
                </h1>
                <p class="text-slate-600 dark:text-slate-400">
                    {{ __('crm.general_settings_desc') }}
                </p>
            </div>
            <a href="{{ route('admin.system-settings.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-slate-600 hover:bg-slate-700 text-white rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ __('crm.back_to_system_settings') }}
            </a>
        </div>
    </div>

    <!-- Settings Sections Accordion -->
    <div class="space-y-4" x-data="{ 
        activeSection: localStorage.getItem('activeSettingsSection') || 'general',
        saveSection(section) {
            this.activeSection = section;
            if (section === null) {
                localStorage.removeItem('activeSettingsSection');
            } else {
                localStorage.setItem('activeSettingsSection', section);
            }
        }
    }">
        
        <!-- General Section -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
            <button @click="saveSection(activeSection === 'general' ? null : 'general')" 
                    class="w-full flex items-center justify-between p-6 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors duration-200">
                <div class="flex items-center flex-1">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center {{ app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4' }} flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-slate-900 dark:text-white">
                            {{ __('crm.general') }}
                        </h2>
                        <p class="text-sm text-slate-600 dark:text-slate-400">
                            {{ __('crm.general_section_desc') }}
                        </p>
                    </div>
                </div>
                <svg class="w-6 h-6 text-slate-400 transition-transform duration-200 flex-shrink-0 {{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }}" 
                     :class="{ 'rotate-180': activeSection === 'general' }"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="activeSection === 'general'" 
                 x-collapse
                 class="border-t border-slate-200 dark:border-slate-700">
                <div class="p-6 bg-slate-50 dark:bg-slate-900/50">
                    <!-- Success Message -->
                    @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-400 rounded-lg flex items-center">
                        <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                    @endif

                    <form action="{{ route('admin.system-settings.general.save') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <!-- Company Name -->
                        <div>
                            <label for="company_name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                {{ __('crm.company_name') }}
                            </label>
                            <input type="text" 
                                   id="company_name" 
                                   name="company_name" 
                                   value="{{ old('company_name', $settings['company_name'] ?? '') }}"
                                   class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('crm.company_name_desc') }}</p>
                            @error('company_name')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Address -->
                        <div>
                            <label for="email_address" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                {{ __('crm.email_address') }}
                            </label>
                            <input type="email" 
                                   id="email_address" 
                                   name="email_address" 
                                   value="{{ old('email_address', $settings['email_address'] ?? '') }}"
                                   class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('crm.email_address_desc') }}</p>
                            @error('email_address')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Domain -->
                        <div>
                            <label for="domain" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                {{ __('crm.domain') }}
                            </label>
                            <input type="url" 
                                   id="domain" 
                                   name="domain" 
                                   value="{{ old('domain', $settings['domain'] ?? '') }}"
                                   placeholder="https://example.com"
                                   class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('crm.domain_desc') }}</p>
                            @error('domain')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Logos Section -->
                        <div class="border-t border-slate-300 dark:border-slate-600 pt-6">
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">{{ __('crm.logos') }}</h3>
                            
                            <!-- Sidebar Admin Logo (Expanded) -->
                            <div class="mb-4">
                                <label for="sidebar_admin_logo" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                    {{ __('crm.sidebar_admin_logo') }}
                                </label>
                                @if(!empty($settings['sidebar_admin_logo']))
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $settings['sidebar_admin_logo']) }}" alt="Sidebar Admin Logo" class="h-16 rounded-lg border border-slate-300 dark:border-slate-600">
                                    </div>
                                @endif
                                <input type="file" 
                                       id="sidebar_admin_logo" 
                                       name="sidebar_admin_logo" 
                                       accept=".png,.svg"
                                       class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-slate-700 dark:file:text-blue-400 dark:hover:file:bg-slate-600">
                                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('crm.sidebar_admin_logo_desc') }}</p>
                                @error('sidebar_admin_logo')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Sidebar Admin Logo Collapsed (Icon) -->
                            <div class="mb-4">
                                <label for="sidebar_admin_logo_collapsed" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                    {{ __('crm.sidebar_admin_logo_collapsed') }}
                                </label>
                                @if(!empty($settings['sidebar_admin_logo_collapsed']))
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $settings['sidebar_admin_logo_collapsed']) }}" alt="Sidebar Collapsed Logo" class="h-12 w-12 rounded-lg border border-slate-300 dark:border-slate-600">
                                    </div>
                                @endif
                                <input type="file" 
                                       id="sidebar_admin_logo_collapsed" 
                                       name="sidebar_admin_logo_collapsed" 
                                       accept=".png,.svg"
                                       class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-slate-700 dark:file:text-blue-400 dark:hover:file:bg-slate-600">
                                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('crm.sidebar_admin_logo_collapsed_desc') }}</p>
                                @error('sidebar_admin_logo_collapsed')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Customer Control Panel Logo -->
                            <div class="mb-4">
                                <label for="customer_panel_logo" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                    {{ __('crm.customer_panel_logo') }}
                                </label>
                                @if(!empty($settings['customer_panel_logo']))
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $settings['customer_panel_logo']) }}" alt="Customer Panel Logo" class="h-16 rounded-lg border border-slate-300 dark:border-slate-600">
                                    </div>
                                @endif
                                <input type="file" 
                                       id="customer_panel_logo" 
                                       name="customer_panel_logo" 
                                       accept=".png,.svg"
                                       class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-slate-700 dark:file:text-blue-400 dark:hover:file:bg-slate-600">
                                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('crm.customer_panel_logo_desc') }}</p>
                                @error('customer_panel_logo')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Customer Control Panel Logo (Collapsed) -->
                            <div class="mb-4">
                                <label for="customer_panel_logo_collapsed" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                    {{ __('crm.customer_panel_logo_collapsed') }}
                                </label>
                                @if(!empty($settings['customer_panel_logo_collapsed']))
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $settings['customer_panel_logo_collapsed']) }}" alt="Customer Panel Logo Collapsed" class="h-16 w-16 rounded-lg border border-slate-300 dark:border-slate-600 object-contain">
                                    </div>
                                @endif
                                <input type="file" 
                                       id="customer_panel_logo_collapsed" 
                                       name="customer_panel_logo_collapsed" 
                                       accept=".png,.svg"
                                       class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-slate-700 dark:file:text-blue-400 dark:hover:file:bg-slate-600">
                                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('crm.customer_panel_logo_collapsed_desc') }}</p>
                                @error('customer_panel_logo_collapsed')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Website Logo -->
                            <div>
                                <label for="website_logo" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                    {{ __('crm.website_logo') }}
                                </label>
                                @if(!empty($settings['website_logo']))
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $settings['website_logo']) }}" alt="Website Logo" class="h-16 rounded-lg border border-slate-300 dark:border-slate-600">
                                    </div>
                                @endif
                                <input type="file" 
                                       id="website_logo" 
                                       name="website_logo" 
                                       accept=".png,.svg"
                                       class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-slate-700 dark:file:text-blue-400 dark:hover:file:bg-slate-600">
                                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('crm.website_logo_desc') }}</p>
                                @error('website_logo')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Favicon -->
                            <div>
                                <label for="favicon" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                    {{ __('crm.favicon') }}
                                </label>
                                @if(!empty($settings['favicon']))
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $settings['favicon']) }}" alt="Favicon" class="h-8 w-8 rounded border border-slate-300 dark:border-slate-600">
                                    </div>
                                @endif
                                <input type="file" 
                                       id="favicon" 
                                       name="favicon" 
                                       accept=".png,.ico,.svg"
                                       class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-slate-700 dark:file:text-blue-400 dark:hover:file:bg-slate-600">
                                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('crm.favicon_desc') }}</p>
                                @error('favicon')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Activity Log Limit -->
                        <div class="border-t border-slate-300 dark:border-slate-600 pt-6">
                            <label for="activity_log_limit" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                {{ __('crm.activity_log_limit') }}
                            </label>
                            <input type="number" 
                                   id="activity_log_limit" 
                                   name="activity_log_limit" 
                                   value="{{ old('activity_log_limit', $settings['activity_log_limit'] ?? 1000) }}"
                                   min="0"
                                   class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('crm.activity_log_limit_desc') }}</p>
                            @error('activity_log_limit')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Maintenance Mode Section -->
                        <div class="border-t border-slate-300 dark:border-slate-600 pt-6">
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">{{ __('crm.maintenance_mode_section') }}</h3>
                            
                            <!-- Maintenance Mode Toggle -->
                            <div class="mb-4">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" 
                                           id="maintenance_mode" 
                                           name="maintenance_mode" 
                                           value="1"
                                           {{ old('maintenance_mode', $settings['maintenance_mode'] ?? false) ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="relative w-11 h-6 bg-slate-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-blue-600"></div>
                                    <span class="ms-3 text-sm font-medium text-slate-700 dark:text-slate-300">{{ __('crm.maintenance_mode') }}</span>
                                </label>
                                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('crm.maintenance_mode_desc') }}</p>
                            </div>

                            <!-- Maintenance Mode Message -->
                            <div class="mb-4">
                                <label for="maintenance_message" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                    {{ __('crm.maintenance_message') }}
                                </label>
                                <textarea id="maintenance_message" 
                                          name="maintenance_message" 
                                          rows="4"
                                          class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">{{ old('maintenance_message', $settings['maintenance_message'] ?? '') }}</textarea>
                                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('crm.maintenance_message_desc') }}</p>
                                @error('maintenance_message')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Maintenance Mode Redirect URL -->
                            <div>
                                <label for="maintenance_redirect_url" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                    {{ __('crm.maintenance_redirect_url') }}
                                </label>
                                <input type="url" 
                                       id="maintenance_redirect_url" 
                                       name="maintenance_redirect_url" 
                                       value="{{ old('maintenance_redirect_url', $settings['maintenance_redirect_url'] ?? '') }}"
                                       placeholder="https://status.example.com"
                                       class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('crm.maintenance_redirect_url_desc') }}</p>
                                @error('maintenance_redirect_url')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Save Button -->
                        <div class="flex items-center justify-end pt-6 border-t border-slate-300 dark:border-slate-600">
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ __('crm.save_general_settings') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Localisation Section -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
            <button @click="saveSection(activeSection === 'localisation' ? null : 'localisation')" 
                    class="w-full flex items-center justify-between p-6 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors duration-200">
                <div class="flex items-center flex-1">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center {{ app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4' }} flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-slate-900 dark:text-white">
                            {{ __('crm.localisation') }}
                        </h2>
                        <p class="text-sm text-slate-600 dark:text-slate-400">
                            {{ __('crm.localisation_section_desc') }}
                        </p>
                    </div>
                </div>
                <svg class="w-6 h-6 text-slate-400 transition-transform duration-200 flex-shrink-0 {{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }}" 
                     :class="{ 'rotate-180': activeSection === 'localisation' }"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="activeSection === 'localisation'" 
                 x-collapse
                 class="border-t border-slate-200 dark:border-slate-700">
                <div class="p-6">
                    <form action="{{ route('admin.system-settings.localisation.save') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- Default Language -->
                        <div>
                            <label for="default_language" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                {{ __('crm.default_language') }}
                            </label>
                            <select id="default_language" 
                                    name="default_language" 
                                    class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                                <option value="ar" {{ old('default_language', $settings['default_language'] ?? 'ar') == 'ar' ? 'selected' : '' }}>
                                    العربية (Arabic)
                                </option>
                                <option value="en" {{ old('default_language', $settings['default_language'] ?? 'ar') == 'en' ? 'selected' : '' }}>
                                    English (الإنجليزية)
                                </option>
                            </select>
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('crm.default_language_desc') }}</p>
                            @error('default_language')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Enable Language Menu -->
                        <div>
                            <label class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                                <div class="flex-1">
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">
                                            {{ __('crm.enable_language_menu') }}
                                        </span>
                                    </div>
                                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('crm.enable_language_menu_desc') }}</p>
                                </div>
                                <div class="relative">
                                    <input type="checkbox" 
                                           id="enable_language_menu" 
                                           name="enable_language_menu" 
                                           value="1"
                                           {{ old('enable_language_menu', $settings['enable_language_menu'] ?? true) ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-slate-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-500 peer-checked:bg-blue-600"></div>
                                </div>
                            </label>
                            @error('enable_language_menu')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Save Button -->
                        <div class="flex justify-end pt-4 border-t border-slate-300 dark:border-slate-600">
                            <button type="submit" 
                                    class="px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                                {{ __('crm.save_localisation_settings') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Ordering Section -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
            <button @click="saveSection(activeSection === 'ordering' ? null : 'ordering')" 
                    class="w-full flex items-center justify-between p-6 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors duration-200">
                <div class="flex items-center flex-1">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center {{ app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4' }} flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-slate-900 dark:text-white">
                            {{ __('crm.ordering') }}
                        </h2>
                        <p class="text-sm text-slate-600 dark:text-slate-400">
                            {{ __('crm.ordering_section_desc') }}
                        </p>
                    </div>
                </div>
                <svg class="w-6 h-6 text-slate-400 transition-transform duration-200 flex-shrink-0 {{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }}" 
                     :class="{ 'rotate-180': activeSection === 'ordering' }"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="activeSection === 'ordering'" 
                 x-collapse
                 class="border-t border-slate-200 dark:border-slate-700">
                <div class="p-6 bg-slate-50 dark:bg-slate-900/50">
                    <div class="text-center py-8 text-slate-400">
                        <svg class="w-16 h-16 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        <p class="text-sm">{{ __('crm.section_coming_soon') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Domains Section -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
            <button @click="saveSection(activeSection === 'domains' ? null : 'domains')" 
                    class="w-full flex items-center justify-between p-6 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors duration-200">
                <div class="flex items-center flex-1">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center {{ app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4' }} flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-slate-900 dark:text-white">
                            {{ __('crm.domains') }}
                        </h2>
                        <p class="text-sm text-slate-600 dark:text-slate-400">
                            {{ __('crm.domains_section_desc') }}
                        </p>
                    </div>
                </div>
                <svg class="w-6 h-6 text-slate-400 transition-transform duration-200 flex-shrink-0 {{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }}" 
                     :class="{ 'rotate-180': activeSection === 'domains' }"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="activeSection === 'domains'" 
                 x-collapse
                 class="border-t border-slate-200 dark:border-slate-700">
                <div class="p-6 bg-slate-50 dark:bg-slate-900/50">
                    <div class="text-center py-8 text-slate-400">
                        <svg class="w-16 h-16 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-sm">{{ __('crm.section_coming_soon') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mail Section -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
            <button @click="saveSection(activeSection === 'mail' ? null : 'mail')" 
                    class="w-full flex items-center justify-between p-6 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors duration-200">
                <div class="flex items-center flex-1">
                    <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center {{ app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4' }} flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-slate-900 dark:text-white">
                            {{ __('crm.mail') }}
                        </h2>
                        <p class="text-sm text-slate-600 dark:text-slate-400">
                            {{ __('crm.mail_section_desc') }}
                        </p>
                    </div>
                </div>
                <svg class="w-6 h-6 text-slate-400 transition-transform duration-200 flex-shrink-0 {{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }}" 
                     :class="{ 'rotate-180': activeSection === 'mail' }"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="activeSection === 'mail'" 
                 x-collapse
                 class="border-t border-slate-200 dark:border-slate-700">
                <div class="p-6 bg-slate-50 dark:bg-slate-900/50">
                    <div class="text-center py-8 text-slate-400">
                        <svg class="w-16 h-16 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <p class="text-sm">{{ __('crm.section_coming_soon') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Support Section -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
            <button @click="saveSection(activeSection === 'support' ? null : 'support')" 
                    class="w-full flex items-center justify-between p-6 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors duration-200">
                <div class="flex items-center flex-1">
                    <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-teal-600 rounded-lg flex items-center justify-center {{ app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4' }} flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-slate-900 dark:text-white">
                            {{ __('crm.support') }}
                        </h2>
                        <p class="text-sm text-slate-600 dark:text-slate-400">
                            {{ __('crm.support_section_desc') }}
                        </p>
                    </div>
                </div>
                <svg class="w-6 h-6 text-slate-400 transition-transform duration-200 flex-shrink-0 {{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }}" 
                     :class="{ 'rotate-180': activeSection === 'support' }"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="activeSection === 'support'" 
                 x-collapse
                 class="border-t border-slate-200 dark:border-slate-700">
                <div class="p-6 bg-slate-50 dark:bg-slate-900/50">
                    <div class="text-center py-8 text-slate-400">
                        <svg class="w-16 h-16 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm">{{ __('crm.section_coming_soon') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoices Section -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
            <button @click="saveSection(activeSection === 'invoices' ? null : 'invoices')" 
                    class="w-full flex items-center justify-between p-6 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors duration-200">
                <div class="flex items-center flex-1">
                    <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-pink-600 rounded-lg flex items-center justify-center {{ app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4' }} flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-slate-900 dark:text-white">
                            {{ __('crm.invoices') }}
                        </h2>
                        <p class="text-sm text-slate-600 dark:text-slate-400">
                            {{ __('crm.invoices_section_desc') }}
                        </p>
                    </div>
                </div>
                <svg class="w-6 h-6 text-slate-400 transition-transform duration-200 flex-shrink-0 {{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }}" 
                     :class="{ 'rotate-180': activeSection === 'invoices' }"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="activeSection === 'invoices'" 
                 x-collapse
                 class="border-t border-slate-200 dark:border-slate-700">
                <div class="p-6 bg-slate-50 dark:bg-slate-900/50">
                    <div class="text-center py-8 text-slate-400">
                        <svg class="w-16 h-16 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <p class="text-sm">{{ __('crm.section_coming_soon') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Credit Section -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
            <button @click="saveSection(activeSection === 'credit' ? null : 'credit')" 
                    class="w-full flex items-center justify-between p-6 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors duration-200">
                <div class="flex items-center flex-1">
                    <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-lg flex items-center justify-center {{ app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4' }} flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-slate-900 dark:text-white">
                            {{ __('crm.credit') }}
                        </h2>
                        <p class="text-sm text-slate-600 dark:text-slate-400">
                            {{ __('crm.credit_section_desc') }}
                        </p>
                    </div>
                </div>
                <svg class="w-6 h-6 text-slate-400 transition-transform duration-200 flex-shrink-0 {{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }}" 
                     :class="{ 'rotate-180': activeSection === 'credit' }"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="activeSection === 'credit'" 
                 x-collapse
                 class="border-t border-slate-200 dark:border-slate-700">
                <div class="p-6 bg-slate-50 dark:bg-slate-900/50">
                    <div class="text-center py-8 text-slate-400">
                        <svg class="w-16 h-16 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm">{{ __('crm.section_coming_soon') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Affiliates Section -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
            <button @click="saveSection(activeSection === 'affiliates' ? null : 'affiliates')" 
                    class="w-full flex items-center justify-between p-6 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors duration-200">
                <div class="flex items-center flex-1">
                    <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-amber-600 rounded-lg flex items-center justify-center {{ app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4' }} flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-slate-900 dark:text-white">
                            {{ __('crm.affiliates') }}
                        </h2>
                        <p class="text-sm text-slate-600 dark:text-slate-400">
                            {{ __('crm.affiliates_section_desc') }}
                        </p>
                    </div>
                </div>
                <svg class="w-6 h-6 text-slate-400 transition-transform duration-200 flex-shrink-0 {{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }}" 
                     :class="{ 'rotate-180': activeSection === 'affiliates' }"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="activeSection === 'affiliates'" 
                 x-collapse
                 class="border-t border-slate-200 dark:border-slate-700">
                <div class="p-6 bg-slate-50 dark:bg-slate-900/50">
                    <div class="text-center py-8 text-slate-400">
                        <svg class="w-16 h-16 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <p class="text-sm">{{ __('crm.section_coming_soon') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Section -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
            <button @click="saveSection(activeSection === 'security' ? null : 'security')" 
                    class="w-full flex items-center justify-between p-6 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors duration-200">
                <div class="flex items-center flex-1">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center {{ app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4' }} flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-slate-900 dark:text-white">
                            {{ __('crm.security') }}
                        </h2>
                        <p class="text-sm text-slate-600 dark:text-slate-400">
                            {{ __('crm.security_section_desc') }}
                        </p>
                    </div>
                </div>
                <svg class="w-6 h-6 text-slate-400 transition-transform duration-200 flex-shrink-0 {{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }}" 
                     :class="{ 'rotate-180': activeSection === 'security' }"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="activeSection === 'security'" 
                 x-collapse
                 class="border-t border-slate-200 dark:border-slate-700">
                <div class="p-6 bg-slate-50 dark:bg-slate-900/50">
                    <div class="text-center py-8 text-slate-400">
                        <svg class="w-16 h-16 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <p class="text-sm">{{ __('crm.section_coming_soon') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Social Section -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
            <button @click="saveSection(activeSection === 'social' ? null : 'social')" 
                    class="w-full flex items-center justify-between p-6 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors duration-200">
                <div class="flex items-center flex-1">
                    <div class="w-12 h-12 bg-gradient-to-br from-violet-500 to-violet-600 rounded-lg flex items-center justify-center {{ app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4' }} flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-slate-900 dark:text-white">
                            {{ __('crm.social') }}
                        </h2>
                        <p class="text-sm text-slate-600 dark:text-slate-400">
                            {{ __('crm.social_section_desc') }}
                        </p>
                    </div>
                </div>
                <svg class="w-6 h-6 text-slate-400 transition-transform duration-200 flex-shrink-0 {{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }}" 
                     :class="{ 'rotate-180': activeSection === 'social' }"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="activeSection === 'social'" 
                 x-collapse
                 class="border-t border-slate-200 dark:border-slate-700">
                <div class="p-6 bg-slate-50 dark:bg-slate-900/50">
                    <div class="text-center py-8 text-slate-400">
                        <svg class="w-16 h-16 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                        </svg>
                        <p class="text-sm">{{ __('crm.section_coming_soon') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Other Section -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
            <button @click="saveSection(activeSection === 'other' ? null : 'other')" 
                    class="w-full flex items-center justify-between p-6 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors duration-200">
                <div class="flex items-center flex-1">
                    <div class="w-12 h-12 bg-gradient-to-br from-slate-500 to-slate-600 rounded-lg flex items-center justify-center {{ app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4' }} flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-slate-900 dark:text-white">
                            {{ __('crm.other') }}
                        </h2>
                        <p class="text-sm text-slate-600 dark:text-slate-400">
                            {{ __('crm.other_section_desc') }}
                        </p>
                    </div>
                </div>
                <svg class="w-6 h-6 text-slate-400 transition-transform duration-200 flex-shrink-0 {{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }}" 
                     :class="{ 'rotate-180': activeSection === 'other' }"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="activeSection === 'other'" 
                 x-collapse
                 class="border-t border-slate-200 dark:border-slate-700">
                <div class="p-6 bg-slate-50 dark:bg-slate-900/50">
                    <div class="text-center py-8 text-slate-400">
                        <svg class="w-16 h-16 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/>
                        </svg>
                        <p class="text-sm">{{ __('crm.section_coming_soon') }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
