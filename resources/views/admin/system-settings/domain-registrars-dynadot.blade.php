@extends('admin.layout')

@section('page-title', __('crm.configure_dynadot'))

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
                    <a href="{{ route('admin.system-settings.domain-registrars') }}" class="{{ app()->getLocale() == 'ar' ? 'mr-1 md:mr-2' : 'ml-1 md:ml-2' }} text-sm font-medium text-slate-700 hover:text-blue-600 dark:text-slate-400 dark:hover:text-white">
                        {{ __('crm.domain_registrars') }}
                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-slate-400 {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="{{ app()->getLocale() == 'ar' ? 'mr-1 md:mr-2' : 'ml-1 md:ml-2' }} text-sm font-medium text-slate-500 dark:text-slate-400">
                        Dynadot
                    </span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Header Card -->
    <div class="mb-6 bg-gradient-to-r from-yellow-500 to-orange-600 rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="bg-white/20 p-3 rounded-lg">
                    <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center">
                        <span class="text-xl font-bold text-orange-600">DD</span>
                    </div>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white">{{ __('crm.configure_dynadot') }}</h1>
                    <p class="text-yellow-100 text-sm mt-1">{{ __('crm.dynadot_api_integration') }}</p>
                </div>
            </div>
            <a href="{{ route('admin.system-settings.domain-registrars') }}" class="flex items-center gap-2 px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span class="hidden sm:inline">{{ __('crm.back') }}</span>
            </a>
        </div>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('admin.system-settings.domain-registrars.dynadot.store') }}" class="space-y-6">
        @csrf

        <!-- Info Alert if Editing -->
        @if($registrar)
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm text-blue-800 dark:text-blue-200">
                    {{ __('crm.editing_existing_configuration') }}
                </p>
            </div>
        </div>
        @endif

        <!-- API Configuration Section -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700">
            <div class="border-b border-slate-200 dark:border-slate-700 p-6">
                <h2 class="text-lg font-semibold text-slate-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                    {{ __('crm.api_configuration') }}
                </h2>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">{{ __('crm.dynadot_api_config_desc') }}</p>
            </div>

            <div class="p-6 space-y-6">
                <!-- Registrar Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.registrar_name') }} <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        value="{{ old('name', $registrar->name ?? 'Dynadot') }}"
                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent dark:bg-slate-700 dark:text-white @error('name') border-red-500 @enderror"
                        required
                    >
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- API Key -->
                <div>
                    <label for="api_key" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.api_key') }} <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            name="api_key" 
                            id="api_key" 
                            value="{{ old('api_key', $registrar->api_key ?? '') }}"
                            class="w-full px-4 py-2 {{ app()->getLocale() == 'ar' ? 'pl-10' : 'pr-10' }} border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent dark:bg-slate-700 dark:text-white @error('api_key') border-red-500 @enderror"
                            placeholder="{{ __('crm.enter_api_key') }}"
                            required
                        >
                        <button type="button" onclick="togglePassword('api_key')" class="absolute {{ app()->getLocale() == 'ar' ? 'left-3' : 'right-3' }} top-1/2 transform -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                    @error('api_key')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        {{ __('crm.dynadot_api_key_hint') }}
                    </p>
                </div>

                <!-- API Secret -->
                <div>
                    <label for="api_secret" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('crm.api_secret') }} <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            name="api_secret" 
                            id="api_secret" 
                            value="{{ old('api_secret', $registrar->api_secret ?? '') }}"
                            class="w-full px-4 py-2 {{ app()->getLocale() == 'ar' ? 'pl-10' : 'pr-10' }} border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent dark:bg-slate-700 dark:text-white @error('api_secret') border-red-500 @enderror"
                            placeholder="{{ __('crm.enter_api_secret') }}"
                            required
                        >
                        <button type="button" onclick="togglePassword('api_secret')" class="absolute {{ app()->getLocale() == 'ar' ? 'left-3' : 'right-3' }} top-1/2 transform -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                    @error('api_secret')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        {{ __('crm.dynadot_api_secret_hint') }}
                    </p>
                </div>

                <!-- Test Connection Button -->
                <div>
                    <button 
                        type="button" 
                        onclick="testDynadotConnection()" 
                        class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 flex items-center gap-2"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        {{ __('crm.test_connection') }}
                    </button>
                    <div id="connection-result" class="mt-3 hidden"></div>
                </div>

                <!-- Test Mode Toggle -->
                <div>
                    @if(app()->getLocale() == 'ar')
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="test_mode" value="1" {{ old('test_mode', $registrar->test_mode ?? true) ? 'checked' : '' }} class="sr-only peer">
                            <div class="relative w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-orange-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-slate-700 peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:right-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-orange-600"></div>
                            <span class="mr-3 text-sm font-medium text-slate-700 dark:text-slate-300">
                                {{ __('crm.test_mode') }}
                            </span>
                        </label>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400 mr-0">
                            {{ __('crm.test_mode_desc') }}
                        </p>
                    @else
                        <label class="flex items-center cursor-pointer">
                            <span class="mr-3 text-sm font-medium text-slate-700 dark:text-slate-300">
                                {{ __('crm.test_mode') }}
                            </span>
                            <input type="checkbox" name="test_mode" value="1" {{ old('test_mode', $registrar->test_mode ?? true) ? 'checked' : '' }} class="sr-only peer">
                            <div class="relative w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-orange-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-orange-600"></div>
                        </label>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400 ml-14">
                            {{ __('crm.test_mode_desc') }}
                        </p>
                    @endif
                </div>

                <!-- Status Toggle -->
                <div>
                    @if(app()->getLocale() == 'ar')
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="status" value="1" {{ old('status', $registrar->status ?? false) ? 'checked' : '' }} class="sr-only peer">
                            <div class="relative w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-orange-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-slate-700 peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:right-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-green-600"></div>
                            <span class="mr-3 text-sm font-medium text-slate-700 dark:text-slate-300">
                                {{ __('crm.active') }}
                            </span>
                        </label>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400 mr-0">
                            {{ __('crm.registrar_active_desc') }}
                        </p>
                    @else
                        <label class="flex items-center cursor-pointer">
                            <span class="mr-3 text-sm font-medium text-slate-700 dark:text-slate-300">
                                {{ __('crm.active') }}
                            </span>
                            <input type="checkbox" name="status" value="1" {{ old('status', $registrar->status ?? false) ? 'checked' : '' }} class="sr-only peer">
                            <div class="relative w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-orange-300 dark:peer-focus:ring-orange-800 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-green-600"></div>
                        </label>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400 ml-14">
                            {{ __('crm.registrar_active_desc') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Information Panel -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-base font-semibold text-blue-900 dark:text-blue-100 mb-2">
                        {{ __('crm.how_to_get_dynadot_api') }}
                    </h3>
                    <ol class="space-y-2 text-sm text-blue-800 dark:text-blue-200 list-decimal {{ app()->getLocale() == 'ar' ? 'pr-5' : 'pl-5' }}">
                        <li>{{ __('crm.dynadot_step_1') }}</li>
                        <li>{{ __('crm.dynadot_step_2') }}</li>
                        <li>{{ __('crm.dynadot_step_3') }}</li>
                        <li>{{ __('crm.dynadot_step_4') }}</li>
                        <li class="font-semibold text-orange-700 dark:text-orange-400">{{ __('crm.dynadot_step_5') }}</li>
                    </ol>
                    <div class="mt-4">
                        <a href="https://www.dynadot.com/domain/api-document" target="_blank" class="inline-flex items-center gap-2 text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">
                            {{ __('crm.view_api_documentation') }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- IP Whitelist Warning -->
        <div class="bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800 rounded-xl p-6">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-base font-semibold text-orange-900 dark:text-orange-100 mb-2">
                        {{ __('crm.important_ip_whitelist') }}
                    </h3>
                    <p class="text-sm text-orange-800 dark:text-orange-200 mb-2">
                        {{ __('crm.dynadot_ip_warning') }}
                    </p>
                    <div class="bg-white dark:bg-slate-800 rounded-lg p-3 mt-2">
                        <p class="text-xs text-slate-600 dark:text-slate-400 mb-1">{{ __('crm.your_server_ip') }}:</p>
                        <code class="text-sm font-mono bg-slate-100 dark:bg-slate-700 px-3 py-1 rounded text-orange-600 dark:text-orange-400">
                            {{ request()->ip() }}
                        </code>
                    </div>
                </div>
            </div>
        </div>

        <!-- Coupon Management Section -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700">
            <div class="border-b border-slate-200 dark:border-slate-700 p-6">
                <h2 class="text-lg font-semibold text-slate-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    {{ __('crm.coupon_management') }}
                </h2>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">{{ __('crm.fetch_and_manage_dynadot_coupons') }}</p>
            </div>

            <div class="p-6 space-y-6">
                <!-- Fetch Available Coupons -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-3">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            {{ __('crm.fetch_available_coupons') }}
                        </span>
                    </label>
                    
                    <div class="flex gap-3 mb-4">
                        <select id="coupon_type" class="flex-1 px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-slate-700 dark:text-white">
                            <option value="registration">{{ __('crm.registration_coupons') }}</option>
                            <option value="renewal">{{ __('crm.renewal_coupons') }}</option>
                            <option value="transfer">{{ __('crm.transfer_coupons') }}</option>
                        </select>
                        <button 
                            type="button" 
                            onclick="fetchDynadotCoupons()" 
                            class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 flex items-center gap-2 whitespace-nowrap"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            {{ __('crm.fetch_coupons') }}
                        </button>
                    </div>

                    <!-- Coupons List Display -->
                    <div id="coupons-list" class="hidden">
                        <div class="bg-slate-50 dark:bg-slate-700/50 rounded-lg p-4 max-h-96 overflow-y-auto">
                            <div id="coupons-content"></div>
                        </div>
                    </div>
                    
                    <div id="coupons-loading" class="hidden">
                        <div class="flex items-center justify-center gap-2 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                            <svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-sm text-blue-700 dark:text-blue-300">{{ __('crm.fetching_coupons') }}...</span>
                        </div>
                    </div>

                    <div id="coupons-error" class="hidden">
                        <div class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                            <p class="text-sm text-red-700 dark:text-red-300"></p>
                        </div>
                    </div>
                </div>

                <hr class="border-slate-200 dark:border-slate-700">

                <!-- Manage Preferred Coupons -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-3">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                            {{ __('crm.preferred_coupons') }}
                        </span>
                    </label>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mb-3">
                        {{ __('crm.preferred_coupons_desc') }}
                    </p>

                    <div id="preferred-coupons-container" class="space-y-3">
                        @php
                            $preferredCoupons = old('preferred_coupons', $registrar->preferred_coupons ?? []);
                            if (is_string($preferredCoupons)) {
                                $preferredCoupons = json_decode($preferredCoupons, true) ?? [];
                            }
                        @endphp

                        @if(!empty($preferredCoupons))
                            @foreach($preferredCoupons as $index => $coupon)
                            <div class="flex gap-2 coupon-row">
                                <select name="preferred_coupons[{{ $index }}][type]" class="flex-shrink-0 w-40 px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-green-500 dark:bg-slate-700 dark:text-white text-sm">
                                    <option value="registration" {{ ($coupon['type'] ?? '') == 'registration' ? 'selected' : '' }}>{{ __('crm.registration') }}</option>
                                    <option value="renewal" {{ ($coupon['type'] ?? '') == 'renewal' ? 'selected' : '' }}>{{ __('crm.renewal') }}</option>
                                    <option value="transfer" {{ ($coupon['type'] ?? '') == 'transfer' ? 'selected' : '' }}>{{ __('crm.transfer') }}</option>
                                </select>
                                <input 
                                    type="text" 
                                    name="preferred_coupons[{{ $index }}][code]" 
                                    value="{{ $coupon['code'] ?? '' }}"
                                    placeholder="{{ __('crm.coupon_code') }}"
                                    class="flex-1 px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-green-500 dark:bg-slate-700 dark:text-white text-sm"
                                >
                                <button 
                                    type="button" 
                                    onclick="removeCouponRow(this)"
                                    class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors flex-shrink-0"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                            @endforeach
                        @else
                            <div class="flex gap-2 coupon-row">
                                <select name="preferred_coupons[0][type]" class="flex-shrink-0 w-40 px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-green-500 dark:bg-slate-700 dark:text-white text-sm">
                                    <option value="registration">{{ __('crm.registration') }}</option>
                                    <option value="renewal">{{ __('crm.renewal') }}</option>
                                    <option value="transfer">{{ __('crm.transfer') }}</option>
                                </select>
                                <input 
                                    type="text" 
                                    name="preferred_coupons[0][code]" 
                                    placeholder="{{ __('crm.coupon_code') }}"
                                    class="flex-1 px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-green-500 dark:bg-slate-700 dark:text-white text-sm"
                                >
                                <button 
                                    type="button" 
                                    onclick="removeCouponRow(this)"
                                    class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors flex-shrink-0"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        @endif
                    </div>

                    <button 
                        type="button" 
                        onclick="addCouponRow()" 
                        class="mt-3 px-4 py-2 bg-slate-600 hover:bg-slate-700 text-white text-sm font-medium rounded-lg transition-colors flex items-center gap-2"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        {{ __('crm.add_another_coupon') }}
                    </button>

                    <div class="mt-3 p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                        <p class="text-xs text-yellow-800 dark:text-yellow-200">
                            <strong>💡 {{ __('crm.tip') }}:</strong> {{ __('crm.preferred_coupons_tip') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-between {{ app()->getLocale() == 'ar' ? 'flex-row-reverse' : '' }} gap-4">
            <a href="{{ route('admin.system-settings.domain-registrars') }}" class="px-6 py-2 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                {{ __('crm.cancel') }}
            </a>
            <button type="submit" class="px-6 py-2 bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                {{ __('crm.save_configuration') }}
            </button>
        </div>
    </form>
</div>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    if (field.type === 'password') {
        field.type = 'text';
    } else {
        field.type = 'password';
    }
}

function testDynadotConnection() {
    const apiKey = document.getElementById('api_key').value;
    const apiSecret = document.getElementById('api_secret').value;
    const resultDiv = document.getElementById('connection-result');
    
    if (!apiKey || !apiSecret) {
        resultDiv.className = 'mt-3 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg';
        resultDiv.textContent = '{{ __("crm.please_enter_api_credentials") }}';
        resultDiv.classList.remove('hidden');
        return;
    }
    
    resultDiv.className = 'mt-3 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded-lg';
    resultDiv.innerHTML = '<div class="flex items-center gap-2"><svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> {{ __("crm.testing_connection") }}...</div>';
    resultDiv.classList.remove('hidden');
    
    fetch('{{ route("admin.system-settings.domain-registrars.dynadot.test") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            api_key: apiKey,
            api_secret: apiSecret
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Dynadot API Response:', data); // للتصحيح
        
        if (data.success) {
            resultDiv.className = 'mt-3 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg';
            let html = '<div class="flex items-center gap-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><strong>' + data.message + '</strong></div>';
            if (data.account) {
                html += '<div class="mt-2 text-sm"><strong>{{ __("crm.account_info") }}:</strong><ul class="list-disc list-inside mt-1">';
                html += '<li>{{ __("crm.username") }}: ' + (data.account.username || 'N/A') + '</li>';
                html += '<li>{{ __("crm.balance") }}: ' + (data.account.balance || 'N/A') + '</li>';
                html += '<li>{{ __("crm.price_level") }}: ' + (data.account.price_level || 'N/A') + '</li>';
                html += '</ul></div>';
            }
            resultDiv.innerHTML = html;
        } else {
            resultDiv.className = 'mt-3 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg';
            resultDiv.innerHTML = '<div class="flex items-center gap-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg><strong>' + data.message + '</strong></div>';
        }
    })
    .catch(error => {
        resultDiv.className = 'mt-3 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg';
        resultDiv.innerHTML = '<div class="flex items-center gap-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg><strong>{{ __("crm.connection_error") }}: ' + error.message + '</strong></div>';
    });
}

// Coupon Management Functions
let couponIndex = {{ count($preferredCoupons ?? []) }};

function addCouponRow() {
    const container = document.getElementById('preferred-coupons-container');
    const newRow = document.createElement('div');
    newRow.className = 'flex gap-2 coupon-row';
    newRow.innerHTML = `
        <select name="preferred_coupons[${couponIndex}][type]" class="flex-shrink-0 w-40 px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-green-500 dark:bg-slate-700 dark:text-white text-sm">
            <option value="registration">{{ __('crm.registration') }}</option>
            <option value="renewal">{{ __('crm.renewal') }}</option>
            <option value="transfer">{{ __('crm.transfer') }}</option>
        </select>
        <input 
            type="text" 
            name="preferred_coupons[${couponIndex}][code]" 
            placeholder="{{ __('crm.coupon_code') }}"
            class="flex-1 px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-green-500 dark:bg-slate-700 dark:text-white text-sm"
        >
        <button 
            type="button" 
            onclick="removeCouponRow(this)"
            class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors flex-shrink-0"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </button>
    `;
    container.appendChild(newRow);
    couponIndex++;
}

function removeCouponRow(button) {
    const row = button.closest('.coupon-row');
    const container = document.getElementById('preferred-coupons-container');
    
    // Don't allow removing the last row
    if (container.querySelectorAll('.coupon-row').length > 1) {
        row.remove();
    } else {
        // Clear the inputs instead
        row.querySelector('input').value = '';
    }
}

function fetchDynadotCoupons() {
    const apiKey = document.getElementById('api_key').value;
    const apiSecret = document.getElementById('api_secret').value;
    const couponType = document.getElementById('coupon_type').value;
    
    const listDiv = document.getElementById('coupons-list');
    const loadingDiv = document.getElementById('coupons-loading');
    const errorDiv = document.getElementById('coupons-error');
    const contentDiv = document.getElementById('coupons-content');
    
    if (!apiKey || !apiSecret) {
        errorDiv.querySelector('p').textContent = '{{ __("crm.please_enter_api_credentials_first") }}';
        errorDiv.classList.remove('hidden');
        listDiv.classList.add('hidden');
        loadingDiv.classList.add('hidden');
        return;
    }
    
    // Show loading
    listDiv.classList.add('hidden');
    errorDiv.classList.add('hidden');
    loadingDiv.classList.remove('hidden');
    
    fetch('{{ route("admin.system-settings.domain-registrars.dynadot.coupons") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            api_key: apiKey,
            api_secret: apiSecret,
            coupon_type: couponType
        })
    })
    .then(response => response.json())
    .then(data => {
        loadingDiv.classList.add('hidden');
        
        if (data.success && data.coupons && data.coupons.length > 0) {
            let html = '<div class="space-y-3">';
            html += `<div class="flex items-center justify-between mb-3">
                <h4 class="font-semibold text-slate-900 dark:text-white">{{ __('crm.available_coupons') }} (${data.coupons.length})</h4>
            </div>`;
            
            data.coupons.forEach(coupon => {
                const discountInfo = coupon.DiscountType === 'PERCENTAGE_OFF' 
                    ? `${coupon.DiscountInfo?.Percentage || 'N/A'}%` 
                    : `$${coupon.DiscountInfo?.USD || 'N/A'}`;
                
                const startDate = coupon.StartDate ? new Date(parseInt(coupon.StartDate)).toLocaleDateString() : 'N/A';
                const endDate = coupon.EndDate ? new Date(parseInt(coupon.EndDate)).toLocaleDateString() : 'N/A';
                
                html += `
                    <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 text-sm font-bold rounded-full">
                                        🎫 ${coupon.Code}
                                    </span>
                                    <span class="inline-flex items-center px-2 py-1 bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-300 text-xs font-semibold rounded">
                                        ${discountInfo} {{ __('crm.off') }}
                                    </span>
                                </div>
                                <p class="text-sm text-slate-700 dark:text-slate-300 mb-2">${coupon.Description || 'No description'}</p>
                                <div class="flex flex-wrap gap-2 text-xs text-slate-500 dark:text-slate-400">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        ${startDate} - ${endDate}
                                    </span>
                                    ${coupon.Restriction?.Tlds ? `
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                            </svg>
                                            ${coupon.Restriction.Tlds.join(', ')}
                                        </span>
                                    ` : ''}
                                </div>
                            </div>
                            <button 
                                type="button"
                                onclick="useCoupon('${coupon.Code}', '${couponType}')"
                                class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded transition-colors whitespace-nowrap"
                            >
                                {{ __('crm.use_coupon') }}
                            </button>
                        </div>
                    </div>
                `;
            });
            
            html += '</div>';
            contentDiv.innerHTML = html;
            listDiv.classList.remove('hidden');
        } else {
            errorDiv.querySelector('p').textContent = data.message || '{{ __("crm.no_coupons_found") }}';
            errorDiv.classList.remove('hidden');
        }
    })
    .catch(error => {
        loadingDiv.classList.add('hidden');
        errorDiv.querySelector('p').textContent = '{{ __("crm.error_fetching_coupons") }}: ' + error.message;
        errorDiv.classList.remove('hidden');
    });
}

function useCoupon(code, type) {
    // Find the first empty row or add a new one
    const container = document.getElementById('preferred-coupons-container');
    const rows = container.querySelectorAll('.coupon-row');
    let foundEmpty = false;
    
    for (let row of rows) {
        const input = row.querySelector('input[type="text"]');
        if (!input.value.trim()) {
            input.value = code;
            row.querySelector('select').value = type;
            foundEmpty = true;
            
            // Highlight the row
            row.classList.add('ring-2', 'ring-green-500', 'rounded-lg');
            setTimeout(() => {
                row.classList.remove('ring-2', 'ring-green-500');
            }, 2000);
            
            break;
        }
    }
    
    if (!foundEmpty) {
        addCouponRow();
        // Wait for DOM update
        setTimeout(() => {
            const newRow = container.lastElementChild;
            newRow.querySelector('input[type="text"]').value = code;
            newRow.querySelector('select').value = type;
            
            // Highlight the row
            newRow.classList.add('ring-2', 'ring-green-500', 'rounded-lg');
            setTimeout(() => {
                newRow.classList.remove('ring-2', 'ring-green-500');
            }, 2000);
            
            // Scroll to the new row
            newRow.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }, 100);
    }
}
</script>
@endsection
