@extends('admin.layout')

@section('title', __('crm.system_settings'))

@section('content')
<div class="p-6">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">
            {{ __('crm.system_settings') }}
        </h1>
        <p class="text-slate-600 dark:text-slate-400">
            {{ __('crm.configure_system_settings') }}
        </p>
    </div>

    <!-- Settings Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        
        <!-- General Settings -->
        <a href="{{ route('admin.system-settings.general') }}" 
           class="group bg-white dark:bg-slate-800 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 p-6 border border-slate-200 dark:border-slate-700 hover:border-blue-500 dark:hover:border-blue-500">
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">
                    {{ __('crm.general_settings') }}
                </h3>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    {{ __('crm.general_settings_desc') }}
                </p>
            </div>
        </a>

        <!-- Automation Settings -->
        <a href="{{ route('admin.system-settings.automation') }}" 
           class="group bg-white dark:bg-slate-800 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 p-6 border border-slate-200 dark:border-slate-700 hover:border-purple-500 dark:hover:border-purple-500">
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">
                    {{ __('crm.automation_settings') }}
                </h3>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    {{ __('crm.automation_settings_desc') }}
                </p>
            </div>
        </a>

        <!-- Products/Services -->
        <a href="{{ route('admin.system-settings.products') }}" 
           class="group bg-white dark:bg-slate-800 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 p-6 border border-slate-200 dark:border-slate-700 hover:border-green-500 dark:hover:border-green-500">
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">
                    {{ __('crm.products_services') }}
                </h3>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    {{ __('crm.products_services_desc') }}
                </p>
            </div>
        </a>

        <!-- Product Addons -->
        <a href="{{ route('admin.system-settings.addons') }}" 
           class="group bg-white dark:bg-slate-800 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 p-6 border border-slate-200 dark:border-slate-700 hover:border-yellow-500 dark:hover:border-yellow-500">
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">
                    {{ __('crm.product_addons') }}
                </h3>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    {{ __('crm.product_addons_desc') }}
                </p>
            </div>
        </a>

        <!-- Promotions and Coupons -->
        <a href="{{ route('admin.system-settings.promotions') }}" 
           class="group bg-white dark:bg-slate-800 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 p-6 border border-slate-200 dark:border-slate-700 hover:border-pink-500 dark:hover:border-pink-500">
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">
                    {{ __('crm.promotions_coupons') }}
                </h3>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    {{ __('crm.promotions_coupons_desc') }}
                </p>
            </div>
        </a>

        <!-- Domain Pricing -->
        <a href="{{ route('admin.system-settings.domains') }}" 
           class="group bg-white dark:bg-slate-800 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 p-6 border border-slate-200 dark:border-slate-700 hover:border-indigo-500 dark:hover:border-indigo-500">
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">
                    {{ __('crm.domain_pricing') }}
                </h3>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    {{ __('crm.domain_pricing_desc') }}
                </p>
            </div>
        </a>

        <!-- Servers -->
        <a href="{{ route('admin.system-settings.servers') }}" 
           class="group bg-white dark:bg-slate-800 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 p-6 border border-slate-200 dark:border-slate-700 hover:border-red-500 dark:hover:border-red-500">
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">
                    {{ __('crm.servers') }}
                </h3>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    {{ __('crm.servers_desc') }}
                </p>
            </div>
        </a>

        <!-- Support Departments -->
        <a href="{{ route('admin.system-settings.departments') }}" 
           class="group bg-white dark:bg-slate-800 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 p-6 border border-slate-200 dark:border-slate-700 hover:border-teal-500 dark:hover:border-teal-500">
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">
                    {{ __('crm.support_departments') }}
                </h3>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    {{ __('crm.support_departments_desc') }}
                </p>
            </div>
        </a>

        <!-- Email Templates -->
        <a href="{{ route('admin.system-settings.emails') }}" 
           class="group bg-white dark:bg-slate-800 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 p-6 border border-slate-200 dark:border-slate-700 hover:border-orange-500 dark:hover:border-orange-500">
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">
                    {{ __('crm.email_templates') }}
                    <span class="ml-2 px-2 py-1 text-xs bg-blue-100 text-blue-600 dark:bg-blue-900 dark:text-blue-300 rounded-full">{{ __('crm.updated') }}</span>
                </h3>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    {{ __('crm.email_templates_desc') }}
                </p>
            </div>
        </a>

        <!-- Client Groups -->
        <a href="{{ route('admin.system-settings.client-groups') }}" 
           class="group bg-white dark:bg-slate-800 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 p-6 border border-slate-200 dark:border-slate-700 hover:border-cyan-500 dark:hover:border-cyan-500">
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">
                    {{ __('crm.client_groups') }}
                </h3>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    {{ __('crm.client_groups_desc') }}
                </p>
            </div>
        </a>

        <!-- Order Statuses -->
        <a href="{{ route('admin.system-settings.order-statuses') }}" 
           class="group bg-white dark:bg-slate-800 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 p-6 border border-slate-200 dark:border-slate-700 hover:border-lime-500 dark:hover:border-lime-500">
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-lime-500 to-lime-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">
                    {{ __('crm.order_statuses') }}
                </h3>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    {{ __('crm.order_statuses_desc') }}
                </p>
            </div>
        </a>

        <!-- Banned IPs -->
        <a href="{{ route('admin.system-settings.banned-ips') }}" 
           class="group bg-white dark:bg-slate-800 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 p-6 border border-slate-200 dark:border-slate-700 hover:border-rose-500 dark:hover:border-rose-500">
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-rose-500 to-rose-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">
                    {{ __('crm.banned_ips') }}
                </h3>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    {{ __('crm.banned_ips_desc') }}
                </p>
            </div>
        </a>

        <!-- Sign-In Integrations -->
        <a href="{{ route('admin.system-settings.sign-in-integrations') }}" 
           class="group bg-white dark:bg-slate-800 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 p-6 border border-slate-200 dark:border-slate-700 hover:border-violet-500 dark:hover:border-violet-500">
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-violet-500 to-violet-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">
                    {{ __('crm.sign_in_integrations') }}
                </h3>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    {{ __('crm.sign_in_integrations_desc') }}
                </p>
            </div>
        </a>

        <!-- Payment Gateways -->
        <a href="{{ route('admin.system-settings.payment-gateways') }}" 
           class="group bg-white dark:bg-slate-800 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 p-6 border border-slate-200 dark:border-slate-700 hover:border-emerald-500 dark:hover:border-emerald-500">
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">
                    {{ __('crm.payment_gateways') }}
                </h3>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    {{ __('crm.payment_gateways_desc') }}
                </p>
            </div>
        </a>

        <!-- Domain Registrars -->
        <a href="{{ route('admin.system-settings.domain-registrars') }}" 
           class="group bg-white dark:bg-slate-800 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 p-6 border border-slate-200 dark:border-slate-700 hover:border-sky-500 dark:hover:border-sky-500">
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-sky-500 to-sky-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">
                    {{ __('crm.domain_registrars') }}
                </h3>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    {{ __('crm.domain_registrars_desc') }}
                </p>
            </div>
        </a>

        <!-- Currencies -->
        <a href="{{ route('admin.system-settings.currencies') }}" 
           class="group bg-white dark:bg-slate-800 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 p-6 border border-slate-200 dark:border-slate-700 hover:border-amber-500 dark:hover:border-amber-500">
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">
                    {{ __('crm.currencies') }}
                </h3>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    {{ __('crm.currencies_desc') }}
                </p>
            </div>
        </a>

        <!-- Tax Configuration -->
        <a href="{{ route('admin.system-settings.tax-configuration') }}" 
           class="group bg-white dark:bg-slate-800 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 p-6 border border-slate-200 dark:border-slate-700 hover:border-fuchsia-500 dark:hover:border-fuchsia-500">
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-fuchsia-500 to-fuchsia-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">
                    {{ __('crm.tax_configuration') }}
                </h3>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    {{ __('crm.tax_configuration_desc') }}
                </p>
            </div>
        </a>

        <!-- Administrator Users -->
        <a href="{{ route('admin.system-settings.administrator-users') }}" 
           class="group bg-white dark:bg-slate-800 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 p-6 border border-slate-200 dark:border-slate-700 hover:border-slate-500 dark:hover:border-slate-500">
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-slate-500 to-slate-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">
                    {{ __('crm.administrator_users') }}
                </h3>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    {{ __('crm.administrator_users_desc') }}
                </p>
            </div>
        </a>

        <!-- Administrator Roles & Permissions -->
        <a href="{{ route('admin.system-settings.administrator-roles') }}" 
           class="group bg-white dark:bg-slate-800 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 p-6 border border-slate-200 dark:border-slate-700 hover:border-gray-500 dark:hover:border-gray-400">
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-gray-500 to-gray-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">
                    {{ __('crm.administrator_roles') }}
                </h3>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    {{ __('crm.administrator_roles_desc') }}
                </p>
            </div>
        </a>

    </div>
</div>
@endsection
