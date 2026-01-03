@extends('admin.layout')

@section('page-title', __('crm.products_services'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">
                    {{ __('crm.products_services') }}
                </h1>
                <p class="text-slate-600 dark:text-slate-400">
                    {{ __('crm.products_services_page_desc') }}
                </p>
            </div>
            <a href="{{ route('admin.system-settings.index') }}" 
               class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2 px-4 py-2 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>{{ __('crm.back_to_settings') }}</span>
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-6 py-4 rounded-lg flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-3">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Main Content -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700" x-data="{ 
        activeTab: window.location.hash ? window.location.hash.substring(1) : 'shared_hosting',
        init() {
            // Update URL hash when tab changes
            this.$watch('activeTab', value => {
                window.location.hash = value;
            });
        }
    }">
        
        <!-- Tabs Navigation -->
        <div class="border-b border-slate-200 dark:border-slate-700">
            <div class="flex {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} flex-wrap gap-4 px-6">
                <!-- Shared Hosting -->
                <button @click="activeTab = 'shared_hosting'" 
                        :class="activeTab === 'shared_hosting' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:border-slate-300 dark:hover:border-slate-600'"
                        class="py-4 px-1 border-b-2 font-medium text-sm transition-colors whitespace-nowrap">
                    {{ __('crm.shared_hosting_tab') }}
                </button>

                <!-- Cloud Hosting -->
                <button @click="activeTab = 'cloud_hosting'" 
                        :class="activeTab === 'cloud_hosting' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:border-slate-300 dark:hover:border-slate-600'"
                        class="py-4 px-1 border-b-2 font-medium text-sm transition-colors whitespace-nowrap">
                    {{ __('crm.cloud_hosting_tab') }}
                </button>

                <!-- Reseller Hosting -->
                <button @click="activeTab = 'reseller_hosting'" 
                        :class="activeTab === 'reseller_hosting' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:border-slate-300 dark:hover:border-slate-600'"
                        class="py-4 px-1 border-b-2 font-medium text-sm transition-colors whitespace-nowrap">
                    {{ __('crm.reseller_hosting_tab') }}
                </button>

                <!-- VPS/Servers -->
                <button @click="activeTab = 'vps_servers'" 
                        :class="activeTab === 'vps_servers' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:border-slate-300 dark:hover:border-slate-600'"
                        class="py-4 px-1 border-b-2 font-medium text-sm transition-colors whitespace-nowrap">
                    {{ __('crm.vps_servers_tab') }}
                </button>

                <!-- Dedicated Server -->
                <button @click="activeTab = 'dedicated_server'" 
                        :class="activeTab === 'dedicated_server' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:border-slate-300 dark:hover:border-slate-600'"
                        class="py-4 px-1 border-b-2 font-medium text-sm transition-colors whitespace-nowrap">
                    {{ __('crm.dedicated_server_tab') }}
                </button>

                <!-- Email Hosting -->
                <button @click="activeTab = 'email_hosting'" 
                        :class="activeTab === 'email_hosting' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:border-slate-300 dark:hover:border-slate-600'"
                        class="py-4 px-1 border-b-2 font-medium text-sm transition-colors whitespace-nowrap">
                    {{ __('crm.email_hosting_tab') }}
                </button>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="p-6">
            
            <!-- Shared Hosting Tab -->
            <div x-show="activeTab === 'shared_hosting'" x-transition>
                <div class="space-y-6">
                    <!-- Header with Add Button -->
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-xl font-semibold text-slate-900 dark:text-white">
                                {{ __('crm.shared_hosting_tab') }}
                            </h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                                {{ __('crm.manage_shared_hosting') }}
                            </p>
                        </div>
                        <a href="{{ route('admin.system-settings.products.shared-hosting.create') }}" class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span>{{ __('crm.add_shared_hosting') }}</span>
                        </a>
                    </div>

                    <!-- Products Table -->
                    <div class="overflow-x-auto rounded-lg border border-slate-200 dark:border-slate-700">
                        <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                            <thead class="bg-slate-50 dark:bg-slate-900/50">
                                <tr>
                                    <th class="px-6 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                        {{ __('crm.product_name') }}
                                    </th>
                                    <th class="px-6 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                        {{ __('crm.type') }}
                                    </th>
                                    <th class="px-6 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                        {{ __('crm.price') }}
                                    </th>
                                    <th class="px-6 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                        {{ __('crm.status') }}
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                        {{ __('crm.actions') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-700">
                                @forelse($sharedHostingProducts as $product)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-slate-900 dark:text-white">
                                                    {{ $product->name }}
                                                </div>
                                                @if($product->tagline)
                                                <div class="text-xs text-slate-500 dark:text-slate-400">
                                                    {{ $product->tagline }}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                                            {{ ucfirst(str_replace('_', ' ', $product->payment_type)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-white font-medium">
                                        ${{ number_format($product->price, 2) }}
                                        @if($product->payment_type === 'recurring')
                                            /{{ __('crm.month') }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($product->is_active)
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                                {{ __('crm.active') }}
                                            </span>
                                        @else
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300">
                                                {{ __('crm.inactive') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2">
                                            <a href="{{ route('admin.system-settings.products.shared-hosting.show', $product->id) }}" class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 transition-colors" title="{{ __('crm.view') }}">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.system-settings.products.shared-hosting.edit', $product->id) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors" title="{{ __('crm.edit') }}">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.system-settings.products.shared-hosting.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ app()->getLocale() == 'ar' ? 'هل أنت متأكد من حذف هذه الخطة؟ لا يمكن التراجع عن هذا الإجراء.' : 'Are you sure you want to delete this plan? This action cannot be undone.' }}');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 transition-colors" title="{{ __('crm.delete') }}">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-16 h-16 text-slate-400 dark:text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                            </svg>
                                            <p class="text-slate-500 dark:text-slate-400 mb-4">{{ __('crm.no_products_found') }}</p>
                                            <a href="{{ route('admin.system-settings.products.shared-hosting.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                                {{ __('crm.add_first_product') }}
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Cloud Hosting Tab -->
            <div x-show="activeTab === 'cloud_hosting'" x-transition>
                <div class="mb-6 bg-gradient-to-r from-purple-50 to-indigo-50 dark:from-purple-900/20 dark:to-indigo-900/20 rounded-xl p-6 border border-purple-100 dark:border-purple-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">
                                {{ __('crm.cloud_hosting_tab') }}
                            </h3>
                            <p class="text-slate-600 dark:text-slate-400 text-sm">
                                {{ __('crm.manage_cloud_hosting') }}
                            </p>
                        </div>
                        <a href="{{ route('admin.system-settings.products.cloud-hosting.create') }}" class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2 px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span>{{ __('crm.add_cloud_hosting') }}</span>
                        </a>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                            <thead class="bg-slate-50 dark:bg-slate-900/50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                        {{ __('crm.plan') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                        {{ __('crm.pricing') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                        {{ __('crm.status') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                        {{ __('crm.actions') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-700">
                                @forelse($cloudHostingProducts as $product)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-slate-900 dark:text-white">
                                                    {{ $product->name }}
                                                </div>
                                                @if($product->tagline)
                                                <div class="text-xs text-slate-500 dark:text-slate-400">
                                                    {{ $product->tagline }}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $pricing = $product->pricing;
                                            $lowestPrice = null;
                                            if (isset($pricing['recurring'])) {
                                                foreach (['monthly', 'quarterly', 'semiannually', 'annually'] as $cycle) {
                                                    if (isset($pricing['recurring'][$cycle]['price']) && $pricing['recurring'][$cycle]['price'] > 0) {
                                                        if ($lowestPrice === null || $pricing['recurring'][$cycle]['price'] < $lowestPrice) {
                                                            $lowestPrice = $pricing['recurring'][$cycle]['price'];
                                                        }
                                                    }
                                                }
                                            }
                                        @endphp
                                        @if($lowestPrice)
                                            <div class="text-sm font-semibold text-purple-600 dark:text-purple-400">
                                                ${{ number_format($lowestPrice, 2) }}
                                            </div>
                                            <div class="text-xs text-slate-500 dark:text-slate-400">
                                                {{ __('crm.starting_from') }}
                                            </div>
                                        @else
                                            <span class="text-xs text-slate-500 dark:text-slate-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($product->is_active)
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400">
                                                {{ __('crm.active') }}
                                            </span>
                                        @else
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400">
                                                {{ __('crm.inactive') }}
                                            </span>
                                        @endif
                                        @if($product->is_featured)
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400 {{ app()->getLocale() == 'ar' ? 'mr-1' : 'ml-1' }}">
                                                ⭐
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-3">
                                            <a href="{{ route('admin.system-settings.products.cloud-hosting.show', $product->id) }}" class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 transition-colors" title="{{ __('crm.view') }}">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.system-settings.products.cloud-hosting.edit', $product->id) }}" class="text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300 transition-colors" title="{{ __('crm.edit') }}">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.system-settings.products.cloud-hosting.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ app()->getLocale() == 'ar' ? 'هل أنت متأكد من حذف هذه الخطة؟ لا يمكن التراجع عن هذا الإجراء.' : 'Are you sure you want to delete this plan? This action cannot be undone.' }}');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 transition-colors" title="{{ __('crm.delete') }}">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <svg class="w-16 h-16 mx-auto mb-4 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                                        </svg>
                                        <p class="text-slate-500 dark:text-slate-400 mb-4">{{ __('crm.no_products_found') }}</p>
                                        <a href="{{ route('admin.system-settings.products.cloud-hosting.create') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                                            {{ __('crm.add_first_product') }}
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Reseller Hosting Tab -->
            <div x-show="activeTab === 'reseller_hosting'" x-transition>
                <div class="mb-6 bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-xl p-6 border border-indigo-100 dark:border-indigo-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">
                                {{ __('crm.reseller_hosting_tab') }}
                            </h3>
                            <p class="text-slate-600 dark:text-slate-400 text-sm">
                                {{ __('crm.manage_reseller_hosting') }}
                            </p>
                        </div>
                        <a href="{{ route('admin.system-settings.products.reseller-hosting.create') }}" class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2 px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span>{{ __('crm.add_reseller_hosting') }}</span>
                        </a>
                    </div>
                </div>

                <!-- Products Grid (Responsive) -->
                <div class="space-y-4">
                    @forelse($resellerProducts as $product)
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between gap-4 flex-wrap">
                            <!-- Product Info -->
                            <div class="flex items-start gap-4 flex-1 min-w-0">
                                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-1">
                                        {{ $product->name }}
                                    </h3>
                                    @if($product->tagline)
                                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-2">
                                        {{ $product->tagline }}
                                    </p>
                                    @endif
                                    <div class="flex items-center gap-3 flex-wrap">
                                        <span class="inline-flex items-center gap-1 text-xs text-slate-500 dark:text-slate-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"/>
                                            </svg>
                                            {{ $product->base_cpanel_accounts }} {{ __('crm.cpanel_accounts') }}
                                        </span>
                                        @if($product->enable_cpanel_tiers)
                                        <span class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300">
                                            + {{ __('crm.additional_tiers') }}
                                        </span>
                                        @endif
                                        <span class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300">
                                            {{ ucfirst(str_replace('_', ' ', $product->payment_type)) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Price & Status -->
                            <div class="flex items-center gap-4">
                                <div class="text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}">
                                    <div class="text-2xl font-bold text-slate-900 dark:text-white">
                                        ${{ number_format($product->price, 2) }}
                                    </div>
                                    @if($product->payment_type === 'recurring')
                                    <div class="text-xs text-slate-500 dark:text-slate-400">
                                        /{{ __('crm.month') }}
                                    </div>
                                    @endif
                                </div>
                                <div>
                                    @if($product->is_active)
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                        {{ __('crm.active') }}
                                    </span>
                                    @else
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300">
                                        {{ __('crm.inactive') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-2 mt-4 pt-4 border-t border-slate-200 dark:border-slate-700">
                            <a href="{{ route('admin.system-settings.products.reseller-hosting.show', $product->id) }}" class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-green-700 dark:text-green-400 bg-green-50 dark:bg-green-900/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                {{ __('crm.view') }}
                            </a>
                            <a href="{{ route('admin.system-settings.products.reseller-hosting.edit', $product->id) }}" class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-blue-700 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                {{ __('crm.edit') }}
                            </a>
                            <form action="{{ route('admin.system-settings.products.reseller-hosting.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ app()->getLocale() == 'ar' ? 'هل أنت متأكد من حذف هذه الخطة؟ لا يمكن التراجع عن هذا الإجراء.' : 'Are you sure you want to delete this plan? This action cannot be undone.' }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-red-700 dark:text-red-400 bg-red-50 dark:bg-red-900/20 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/30 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    {{ __('crm.delete') }}
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-12">
                        <div class="flex flex-col items-center">
                            <svg class="w-20 h-20 text-slate-400 dark:text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <p class="text-lg text-slate-500 dark:text-slate-400 mb-4">{{ __('crm.no_products_found') }}</p>
                            <a href="{{ route('admin.system-settings.products.reseller-hosting.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                {{ __('crm.add_first_product') }}
                            </a>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- VPS/Servers Tab -->
            <div x-show="activeTab === 'vps_servers'" x-transition>
                <div class="space-y-6">
                    <!-- Header with Actions -->
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-xl font-semibold text-slate-900 dark:text-white">
                                {{ __('crm.vps_plans') }}
                            </h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                                {{ __('crm.manage_vps_plans') }}
                            </p>
                        </div>
                        <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-3">
                            <a href="{{ route('admin.system-settings.products.vps-plans.create') }}" class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                <span>{{ __('crm.add_vps_plan') }}</span>
                            </a>
                            <a href="{{ route('admin.system-settings.products.vps-plans.index') }}" class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2 px-4 py-2 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                </svg>
                                <span>{{ __('crm.view_all') }}</span>
                            </a>
                        </div>
                    </div>

                    @if($vpsPlans->isEmpty())
                        <!-- Empty State -->
                        <div class="text-center py-12 bg-slate-50 dark:bg-slate-900/50 rounded-lg border-2 border-dashed border-slate-300 dark:border-slate-700">
                            <svg class="mx-auto h-12 w-12 text-slate-400 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-slate-900 dark:text-white">{{ __('crm.no_vps_plans') }}</h3>
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ __('crm.get_started_by_creating_vps_plan') }}</p>
                            <div class="mt-6">
                                <a href="{{ route('admin.system-settings.products.vps-plans.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    {{ __('crm.add_vps_plan') }}
                                </a>
                            </div>
                        </div>
                    @else
                        <!-- VPS Plans Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($vpsPlans as $plan)
                                <div class="bg-white dark:bg-slate-800 rounded-lg shadow-md border border-slate-200 dark:border-slate-700 hover:shadow-lg transition-shadow overflow-hidden">
                                    <div class="p-6">
                                        <!-- Plan Header -->
                                        <div class="flex items-start justify-between mb-4">
                                            <div class="flex-1">
                                                <h4 class="text-lg font-semibold text-slate-900 dark:text-white">
                                                    {{ $plan->plan_name }}
                                                </h4>
                                                @if($plan->plan_tagline)
                                                    <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                                                        {{ $plan->plan_tagline }}
                                                    </p>
                                                @endif
                                            </div>
                                            <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse mr-3' : 'ml-3' }} space-x-2">
                                                @if($plan->is_featured)
                                                    <span class="px-2 py-1 text-xs font-medium bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 rounded">
                                                        {{ __('crm.featured') }}
                                                    </span>
                                                @endif
                                                <span class="px-2 py-1 text-xs font-medium rounded {{ $plan->is_active ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' }}">
                                                    {{ $plan->is_active ? __('crm.active') : __('crm.inactive') }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Specs -->
                                        <div class="space-y-2 mb-4 py-4 border-t border-b border-slate-200 dark:border-slate-700">
                                            <div class="flex items-center justify-between text-sm">
                                                <span class="text-slate-600 dark:text-slate-400">{{ __('crm.vcpu') }}:</span>
                                                <span class="font-medium text-slate-900 dark:text-white">{{ $plan->vcpu_count }} {{ __('crm.cores') }}</span>
                                            </div>
                                            <div class="flex items-center justify-between text-sm">
                                                <span class="text-slate-600 dark:text-slate-400">{{ __('crm.ram') }}:</span>
                                                <span class="font-medium text-slate-900 dark:text-white">{{ number_format($plan->ram_mb / 1024, 1) }} GB</span>
                                            </div>
                                            <div class="flex items-center justify-between text-sm">
                                                <span class="text-slate-600 dark:text-slate-400">{{ __('crm.storage') }}:</span>
                                                <span class="font-medium text-slate-900 dark:text-white">{{ $plan->storage_gb }} GB {{ $plan->storage_type }}</span>
                                            </div>
                                            <div class="flex items-center justify-between text-sm">
                                                <span class="text-slate-600 dark:text-slate-400">{{ __('crm.bandwidth') }}:</span>
                                                <span class="font-medium text-slate-900 dark:text-white">
                                                    @if($plan->bandwidth_gb == 0)
                                                        {{ __('crm.unlimited') }}
                                                    @else
                                                        {{ number_format($plan->bandwidth_gb / 1024, 1) }} TB
                                                    @endif
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Pricing -->
                                        <div class="mb-4">
                                            <div class="flex items-baseline">
                                                <span class="text-3xl font-bold text-blue-600 dark:text-blue-400">
                                                    ${{ number_format($plan->monthly_price, 2) }}
                                                </span>
                                                <span class="text-slate-600 dark:text-slate-400 {{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }}">/ {{ __('crm.month') }}</span>
                                            </div>
                                        </div>

                                        <!-- Actions -->
                                        <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2">
                                            <a href="{{ route('admin.system-settings.products.vps-plans.edit', $plan) }}" class="flex-1 text-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded transition-colors">
                                                {{ __('crm.edit') }}
                                            </a>
                                            <form action="{{ route('admin.system-settings.products.vps-plans.destroy', $plan) }}" method="POST" class="flex-1" onsubmit="return confirm('{{ __('crm.confirm_delete') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded transition-colors">
                                                    {{ __('crm.delete') }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Dedicated Server Tab -->
            <div x-show="activeTab === 'dedicated_server'" x-transition>
                <div class="space-y-6">
                    <!-- Header with Actions -->
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-xl font-semibold text-slate-900 dark:text-white">
                                {{ __('crm.dedicated_plans') }}
                            </h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                                {{ __('crm.manage_dedicated_plans') }}
                            </p>
                        </div>
                        <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-3">
                            <a href="{{ route('admin.system-settings.products.dedicated-plans.create') }}" class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2 px-4 py-2 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                <span>{{ __('crm.add_dedicated_plan') }}</span>
                            </a>
                            <a href="{{ route('admin.system-settings.products.dedicated-plans.index') }}" class="px-4 py-2 text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 font-medium rounded-lg transition-colors">
                                {{ __('crm.view_all') }}
                            </a>
                        </div>
                    </div>

                    @if($dedicatedPlans->isEmpty())
                        <!-- Empty State -->
                        <div class="text-center py-12 bg-slate-50 dark:bg-slate-900/50 rounded-lg border-2 border-dashed border-slate-300 dark:border-slate-700">
                            <svg class="mx-auto h-12 w-12 text-slate-400 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-slate-900 dark:text-white">{{ __('crm.no_dedicated_plans') }}</h3>
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ __('crm.get_started_by_creating_dedicated_plan') }}</p>
                            <div class="mt-6">
                                <a href="{{ route('admin.system-settings.products.dedicated-plans.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    {{ __('crm.add_dedicated_plan') }}
                                </a>
                            </div>
                        </div>
                    @else
                        <!-- Dedicated Plans Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($dedicatedPlans as $plan)
                                <div class="bg-white dark:bg-slate-800 rounded-lg shadow-md border border-slate-200 dark:border-slate-700 hover:shadow-lg transition-shadow overflow-hidden">
                                    <div class="p-6">
                                        <!-- Plan Header -->
                                        <div class="flex items-start justify-between mb-4">
                                            <div class="flex-1">
                                                <h4 class="text-lg font-semibold text-slate-900 dark:text-white">
                                                    {{ $plan->plan_name }}
                                                </h4>
                                                @if($plan->plan_tagline)
                                                    <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                                                        {{ $plan->plan_tagline }}
                                                    </p>
                                                @endif
                                            </div>
                                            <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse mr-3' : 'ml-3' }} space-x-2">
                                                @if($plan->is_featured)
                                                    <span class="px-2 py-1 text-xs font-medium bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 rounded">
                                                        {{ __('crm.featured') }}
                                                    </span>
                                                @endif
                                                <span class="px-2 py-1 text-xs font-medium rounded {{ $plan->is_active ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' }}">
                                                    {{ $plan->is_active ? __('crm.active') : __('crm.inactive') }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Specs -->
                                        <div class="space-y-2 mb-4 py-4 border-t border-b border-slate-200 dark:border-slate-700">
                                            <div class="flex items-center justify-between text-sm">
                                                <span class="text-slate-600 dark:text-slate-400">{{ __('crm.cpu') }}:</span>
                                                <span class="font-medium text-slate-900 dark:text-white">{{ $plan->cpu_cores }} {{ __('crm.cores') }}</span>
                                            </div>
                                            <div class="flex items-center justify-between text-sm">
                                                <span class="text-slate-600 dark:text-slate-400">{{ __('crm.ram') }}:</span>
                                                <span class="font-medium text-slate-900 dark:text-white">{{ $plan->ram_gb }} GB</span>
                                            </div>
                                            <div class="flex items-center justify-between text-sm">
                                                <span class="text-slate-600 dark:text-slate-400">{{ __('crm.storage') }}:</span>
                                                <span class="font-medium text-slate-900 dark:text-white">{{ $plan->storage_total_gb }} GB {{ $plan->storage_type }}</span>
                                            </div>
                                            <div class="flex items-center justify-between text-sm">
                                                <span class="text-slate-600 dark:text-slate-400">{{ __('crm.bandwidth') }}:</span>
                                                <span class="font-medium text-slate-900 dark:text-white">{{ $plan->bandwidth }}</span>
                                            </div>
                                        </div>

                                        <!-- Pricing -->
                                        <div class="mb-4">
                                            <div class="flex items-baseline">
                                                <span class="text-3xl font-bold text-purple-600 dark:text-purple-400">
                                                    ${{ number_format($plan->monthly_price, 2) }}
                                                </span>
                                                <span class="text-slate-600 dark:text-slate-400 {{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }}">/ {{ __('crm.month') }}</span>
                                            </div>
                                        </div>

                                        <!-- Actions -->
                                        <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2">
                                            <a href="{{ route('admin.system-settings.products.dedicated-plans.edit', $plan) }}" class="flex-1 text-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded transition-colors">
                                                {{ __('crm.edit') }}
                                            </a>
                                            <form action="{{ route('admin.system-settings.products.dedicated-plans.destroy', $plan) }}" method="POST" class="flex-1" onsubmit="return confirm('{{ __('crm.confirm_delete') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded transition-colors">
                                                    {{ __('crm.delete') }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Email Hosting Tab -->
            <div x-show="activeTab === 'email_hosting'" x-transition>
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto mb-4 text-slate-400 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">{{ __('crm.email_hosting_tab') }}</h3>
                    <p class="text-slate-600 dark:text-slate-400 mb-4">{{ __('crm.email_hosting_coming_soon') }}</p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
