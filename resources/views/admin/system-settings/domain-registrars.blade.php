@extends('admin.layout')

@section('page-title', __('crm.domain_registrars'))

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
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-slate-400 {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="{{ app()->getLocale() == 'ar' ? 'mr-1 md:mr-2' : 'ml-1 md:ml-2' }} text-sm font-medium text-slate-500 dark:text-slate-400">
                        {{ __('crm.domain_registrars') }}
                    </span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Header Card -->
    <div class="mb-6 bg-gradient-to-r from-purple-600 to-purple-700 rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="bg-white/20 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white">{{ __('crm.domain_registrars') }}</h1>
                    <p class="text-purple-100 text-sm mt-1">{{ __('crm.domain_registrars_desc') }}</p>
                </div>
            </div>
            <a href="{{ route('admin.system-settings.index') }}" class="flex items-center gap-2 px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span class="hidden sm:inline">{{ __('crm.back') }}</span>
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-6 py-4 rounded-lg flex items-center gap-3">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Registrars Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- Namecheap -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden hover:shadow-xl transition-shadow">
            <div class="p-6">
                <!-- Logo & Name -->
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <span class="text-2xl font-bold text-white">NC</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Namecheap</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ __('crm.popular_registrar') }}</p>
                    </div>
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700 dark:bg-gray-900 dark:text-gray-300">
                        {{ __('crm.not_configured') }}
                    </span>
                </div>

                <!-- Description -->
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">
                    {{ __('crm.namecheap_desc') }}
                </p>

                <!-- Features -->
                <div class="space-y-2 mb-4">
                    <div class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ __('crm.auto_registration') }}
                    </div>
                    <div class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ __('crm.auto_renewal') }}
                    </div>
                    <div class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ __('crm.whois_privacy') }}
                    </div>
                </div>

                <!-- Action Button -->
                <a href="{{ route('admin.system-settings.domain-registrars.dynadot') }}" class="w-full block px-4 py-2 bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 text-center">
                    {{ __('crm.configure') }}
                </a>
            </div>
        </div>

        <!-- GoDaddy -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden hover:shadow-xl transition-shadow">
            <div class="p-6">
                <!-- Logo & Name -->
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-600 to-green-700 rounded-lg flex items-center justify-center flex-shrink-0">
                        <span class="text-2xl font-bold text-white">GD</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white">GoDaddy</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ __('crm.popular_registrar') }}</p>
                    </div>
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700 dark:bg-gray-900 dark:text-gray-300">
                        {{ __('crm.not_configured') }}
                    </span>
                </div>

                <!-- Description -->
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">
                    {{ __('crm.godaddy_desc') }}
                </p>

                <!-- Features -->
                <div class="space-y-2 mb-4">
                    <div class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ __('crm.auto_registration') }}
                    </div>
                    <div class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ __('crm.auto_renewal') }}
                    </div>
                    <div class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ __('crm.dns_management') }}
                    </div>
                </div>

                <!-- Action Button -->
                <button class="w-full px-4 py-2 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                    {{ __('crm.configure') }}
                </button>
            </div>
        </div>

        <!-- ResellerClub -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden hover:shadow-xl transition-shadow">
            <div class="p-6">
                <!-- Logo & Name -->
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-blue-700 rounded-lg flex items-center justify-center flex-shrink-0">
                        <span class="text-2xl font-bold text-white">RC</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white">ResellerClub</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ __('crm.reseller_focused') }}</p>
                    </div>
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700 dark:bg-gray-900 dark:text-gray-300">
                        {{ __('crm.not_configured') }}
                    </span>
                </div>

                <!-- Description -->
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">
                    {{ __('crm.resellerclub_desc') }}
                </p>

                <!-- Features -->
                <div class="space-y-2 mb-4">
                    <div class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ __('crm.bulk_operations') }}
                    </div>
                    <div class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ __('crm.white_label') }}
                    </div>
                    <div class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ __('crm.api_access') }}
                    </div>
                </div>

                <!-- Action Button -->
                <button class="w-full px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                    {{ __('crm.configure') }}
                </button>
            </div>
        </div>

        <!-- Enom -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden hover:shadow-xl transition-shadow">
            <div class="p-6">
                <!-- Logo & Name -->
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-red-600 to-red-700 rounded-lg flex items-center justify-center flex-shrink-0">
                        <span class="text-2xl font-bold text-white">EN</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Enom</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ __('crm.enterprise_solution') }}</p>
                    </div>
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700 dark:bg-gray-900 dark:text-gray-300">
                        {{ __('crm.not_configured') }}
                    </span>
                </div>

                <!-- Description -->
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">
                    {{ __('crm.enom_desc') }}
                </p>

                <!-- Features -->
                <div class="space-y-2 mb-4">
                    <div class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ __('crm.global_tlds') }}
                    </div>
                    <div class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ __('crm.reseller_programs') }}
                    </div>
                    <div class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ __('crm.domain_forwarding') }}
                    </div>
                </div>

                <!-- Action Button -->
                <button class="w-full px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                    {{ __('crm.configure') }}
                </button>
            </div>
        </div>

        <!-- Cloudflare -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden hover:shadow-xl transition-shadow">
            <div class="p-6">
                <!-- Logo & Name -->
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <span class="text-2xl font-bold text-white">CF</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Cloudflare</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ __('crm.cdn_included') }}</p>
                    </div>
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700 dark:bg-gray-900 dark:text-gray-300">
                        {{ __('crm.not_configured') }}
                    </span>
                </div>

                <!-- Description -->
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">
                    {{ __('crm.cloudflare_desc') }}
                </p>

                <!-- Features -->
                <div class="space-y-2 mb-4">
                    <div class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ __('crm.free_ssl') }}
                    </div>
                    <div class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ __('crm.ddos_protection') }}
                    </div>
                    <div class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ __('crm.cdn_network') }}
                    </div>
                </div>

                <!-- Action Button -->
                <button class="w-full px-4 py-2 bg-gradient-to-r from-yellow-600 to-orange-700 hover:from-yellow-700 hover:to-orange-800 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                    {{ __('crm.configure') }}
                </button>
            </div>
        </div>

        <!-- Dynadot -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden hover:shadow-xl transition-shadow">
            <div class="p-6">
                <!-- Logo & Name -->
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <span class="text-2xl font-bold text-white">DD</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Dynadot</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ __('crm.affordable_pricing') }}</p>
                    </div>
                    @php
                        $dynadot = \App\Models\DomainRegistrar::where('type', 'dynadot')->first();
                    @endphp
                    @if($dynadot && $dynadot->status)
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300">
                            {{ __('crm.configured') }}
                        </span>
                    @else
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700 dark:bg-gray-900 dark:text-gray-300">
                            {{ __('crm.not_configured') }}
                        </span>
                    @endif
                </div>

                <!-- Description -->
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">
                    {{ __('crm.dynadot_desc') }}
                </p>

                <!-- Features -->
                <div class="space-y-2 mb-4">
                    <div class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ __('crm.competitive_pricing') }}
                    </div>
                    <div class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ __('crm.rest_api') }}
                    </div>
                    <div class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ __('crm.instant_activation') }}
                    </div>
                </div>

                <!-- Action Button -->
                <a href="{{ route('admin.system-settings.domain-registrars.dynadot') }}" class="w-full block px-4 py-2 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 text-center">
                    {{ __('crm.configure') }}
                </a>
            </div>
        </div>

        <!-- Custom Registrar -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border-2 border-dashed border-slate-300 dark:border-slate-600 overflow-hidden hover:shadow-xl hover:border-blue-500 dark:hover:border-blue-500 transition-all">
            <div class="p-6 flex flex-col items-center justify-center text-center min-h-[300px]">
                <div class="w-16 h-16 bg-gradient-to-br from-slate-400 to-slate-500 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">{{ __('crm.custom_registrar') }}</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-6">
                    {{ __('crm.custom_registrar_desc') }}
                </p>
                <button class="px-6 py-2 bg-gradient-to-r from-slate-600 to-slate-700 hover:from-slate-700 hover:to-slate-800 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                    {{ __('crm.add_custom') }}
                </button>
            </div>
        </div>

    </div>

    <!-- Information Panel -->
    <div class="mt-8 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-base font-semibold text-blue-900 dark:text-blue-100 mb-2">
                    {{ __('crm.domain_registrar_info_title') }}
                </h3>
                <p class="text-sm text-blue-800 dark:text-blue-200 mb-3">
                    {{ __('crm.domain_registrar_info_desc') }}
                </p>
                <ul class="space-y-2 text-sm text-blue-700 dark:text-blue-300">
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ __('crm.registrar_benefit_1') }}</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ __('crm.registrar_benefit_2') }}</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ __('crm.registrar_benefit_3') }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
