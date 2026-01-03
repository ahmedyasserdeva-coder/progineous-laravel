@extends('admin.layout')

@section('page-title', __('crm.promotions_coupons'))

@section('content')
<div class="container mx-auto px-4 py-8" x-data="{ 
    activeTab: window.location.hash ? window.location.hash.substring(1) : 'coupons',
    showDeleteModal: false,
    deleteType: '',
    deleteId: null,
    deleteName: '',
    init() {
        this.$watch('activeTab', value => {
            window.location.hash = value;
        });
    },
    confirmDelete(type, id, name) {
        this.deleteType = type;
        this.deleteId = id;
        this.deleteName = name;
        this.showDeleteModal = true;
    },
    async performDelete() {
        const url = this.deleteType === 'coupon' 
            ? `/unleasha/system-settings/promotions/coupons/${this.deleteId}/delete`
            : `/unleasha/system-settings/promotions/campaigns/${this.deleteId}/delete`;
        
        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
            });
            
            const data = await response.json().catch(() => ({}));
            
            if (response.ok) {
                window.location.reload();
            } else {
                console.error('Delete error:', response.status, data);
                alert('{{ __('crm.error_deleting') }}' + (data.message ? ': ' + data.message : ''));
            }
        } catch (error) {
            console.error('Delete exception:', error);
            alert('{{ __('crm.error_occurred') }}' + ': ' + error.message);
        }
    },
    async toggleStatus(type, id) {
        const url = type === 'coupon'
            ? `/unleasha/system-settings/promotions/coupons/${id}/toggle`
            : `/unleasha/system-settings/promotions/campaigns/${id}/toggle`;
        
        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    'Accept': 'application/json',
                },
            });
            
            if (response.ok) {
                window.location.reload();
            } else {
                alert('{{ __('crm.error_updating_status') }}');
            }
        } catch (error) {
            alert('{{ __('crm.error_occurred') }}');
        }
    }
}">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">
                    {{ __('crm.promotions_coupons') }}
                </h1>
                <p class="text-slate-600 dark:text-slate-400">
                    {{ __('crm.manage_promotions_and_coupons') }}
                </p>
            </div>
            <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-3">
                <a href="{{ route('admin.system-settings.index') }}" 
                   class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2 px-4 py-2 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>{{ __('crm.back_to_settings') }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-6 py-4 rounded-lg flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-3">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="font-medium">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 px-6 py-4 rounded-lg flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-3">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="font-medium">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Main Content -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700">
        
        <!-- Tabs Navigation -->
        <div class="border-b border-slate-200 dark:border-slate-700" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
            <div class="flex overflow-x-auto">
                <button @click="activeTab = 'coupons'" 
                        :class="activeTab === 'coupons' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:border-slate-300 dark:hover:border-slate-600'"
                        class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors">
                    {{ __('crm.discount_coupons') }}
                </button>
                <button @click="activeTab = 'promotions'" 
                        :class="activeTab === 'promotions' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:border-slate-300 dark:hover:border-slate-600'"
                        class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors">
                    {{ __('crm.promotional_campaigns') }}
                </button>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="p-6">
            
            <!-- Discount Coupons Tab -->
            <div x-show="activeTab === 'coupons'" x-transition>
                <div class="space-y-6">
                    <!-- Header with Actions -->
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-xl font-semibold text-slate-900 dark:text-white">
                                {{ __('crm.discount_coupons') }}
                            </h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                                {{ __('crm.create_and_manage_discount_coupons') }}
                            </p>
                        </div>
                        <a href="{{ route('admin.system-settings.promotions.coupons.create') }}" class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span>{{ __('crm.create_coupon') }}</span>
                        </a>
                    </div>

                    @if($coupons->count() > 0)
                        <!-- Coupons List -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($coupons as $coupon)
                            <div class="bg-white dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow">
                                <div class="p-6">
                                    <!-- Coupon Code -->
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2">
                                            <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-mono font-bold text-lg rounded">
                                                {{ $coupon->code }}
                                            </span>
                                            @if($coupon->is_active)
                                                <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-medium rounded">
                                                    {{ __('crm.active') }}
                                                </span>
                                            @else
                                                <span class="px-2 py-1 bg-gray-100 dark:bg-gray-900/30 text-gray-700 dark:text-gray-300 text-xs font-medium rounded">
                                                    {{ __('crm.inactive') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Discount Info -->
                                    <div class="mb-4">
                                        <div class="text-3xl font-bold text-slate-900 dark:text-white">
                                            @if($coupon->type === 'percentage')
                                                {{ $coupon->value }}%
                                            @else
                                                ${{ number_format($coupon->value, 2) }}
                                            @endif
                                        </div>
                                        <div class="text-sm text-slate-500 dark:text-slate-400">
                                            {{ $coupon->type === 'percentage' ? __('crm.percentage') : __('crm.fixed_amount') }} {{ __('crm.discount') }}
                                        </div>
                                    </div>

                                    <!-- Details -->
                                    <div class="space-y-2 text-sm mb-4">
                                        @if($coupon->expires_at)
                                        <div class="flex items-center text-slate-600 dark:text-slate-400">
                                            <i class="fas fa-calendar text-slate-400 w-4 me-2"></i>
                                            <span>{{ __('crm.expires') }}: {{ $coupon->expires_at->format('Y-m-d') }}</span>
                                        </div>
                                        @endif

                                        <div class="flex items-center text-slate-600 dark:text-slate-400">
                                            <i class="fas fa-chart-line text-slate-400 w-4 me-2"></i>
                                            <span>{{ __('crm.used') }}: {{ $coupon->used_count }} / {{ $coupon->max_uses ?? '∞' }}</span>
                                        </div>

                                        @if($coupon->customer_type !== 'all')
                                        <div class="flex items-center text-slate-600 dark:text-slate-400">
                                            <i class="fas fa-users text-slate-400 w-4 me-2"></i>
                                            <span>
                                                @if($coupon->customer_type === 'new')
                                                    {{ __('crm.new_customers_only') }}
                                                @else
                                                    {{ __('crm.existing_customers_only') }}
                                                @endif
                                            </span>
                                        </div>
                                        @endif
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex items-center justify-end {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2 pt-4 border-t border-slate-200 dark:border-slate-800">
                                        <a href="{{ route('admin.system-settings.promotions.coupons.edit', $coupon->id) }}" class="px-3 py-1.5 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded transition-colors" title="{{ __('crm.edit') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <button @click="confirmDelete('coupon', {{ $coupon->id }}, {{ json_encode($coupon->code) }})" class="px-3 py-1.5 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded transition-colors" title="{{ __('crm.delete') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                        <button @click="toggleStatus('coupon', {{ $coupon->id }})" class="px-3 py-1.5 {{ $coupon->is_active ? 'text-yellow-600 dark:text-yellow-400' : 'text-green-600 dark:text-green-400' }} hover:bg-slate-50 dark:hover:bg-slate-800 rounded transition-colors" title="{{ $coupon->is_active ? __('crm.deactivate') : __('crm.activate') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                @if($coupon->is_active)
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                @endif
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <!-- Coupons List (Empty State) -->
                        <div class="text-center py-12 bg-slate-50 dark:bg-slate-900/50 rounded-lg border-2 border-dashed border-slate-300 dark:border-slate-700">
                            <svg class="mx-auto h-12 w-12 text-slate-400 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-slate-900 dark:text-white">{{ __('crm.no_coupons_yet') }}</h3>
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ __('crm.get_started_by_creating_coupon') }}</p>
                            <div class="mt-6">
                                <a href="{{ route('admin.system-settings.promotions.coupons.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    <svg class="{{ app()->getLocale() == 'ar' ? '-mr-1 ml-2' : '-ml-1 mr-2' }} h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    {{ __('crm.create_coupon') }}
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Promotional Campaigns Tab -->
            <div x-show="activeTab === 'promotions'" x-transition>
                <div class="space-y-6">
                    <!-- Header with Actions -->
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-xl font-semibold text-slate-900 dark:text-white">
                                {{ __('crm.promotional_campaigns') }}
                            </h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                                {{ __('crm.create_promotional_campaigns_and_offers') }}
                            </p>
                        </div>
                        <a href="{{ route('admin.system-settings.promotions.campaigns.create') }}" class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2 px-4 py-2 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span>{{ __('crm.create_campaign') }}</span>
                        </a>
                    </div>

                    @if($campaigns->count() > 0)
                        <!-- Campaigns List -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($campaigns as $campaign)
                            <div class="bg-white dark:bg-slate-900 rounded-lg border-2 {{ $campaign->is_active ? 'border-purple-200 dark:border-purple-800' : 'border-slate-200 dark:border-slate-800' }} shadow-sm hover:shadow-md transition-all duration-200">
                                <div class="p-6">
                                    <!-- Campaign Header -->
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex-1">
                                            <h4 class="text-lg font-bold text-slate-900 dark:text-white mb-1">
                                                {{ app()->getLocale() == 'ar' ? ($campaign->name_ar ?? $campaign->name) : ($campaign->name_en ?? $campaign->name) }}
                                            </h4>
                                            <!-- Campaign Type Badge -->
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($campaign->type === 'seasonal') bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300
                                                @elseif($campaign->type === 'product_launch') bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300
                                                @else bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300
                                                @endif">
                                                {{ __('crm.' . $campaign->type) }}
                                            </span>
                                        </div>
                                        <!-- Status Badge -->
                                        @if($campaign->is_active && $campaign->isActive())
                                            <span class="px-2.5 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-medium rounded-full">
                                                {{ __('crm.active') }}
                                            </span>
                                        @elseif($campaign->has_started)
                                            <span class="px-2.5 py-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 text-xs font-medium rounded-full">
                                                {{ __('crm.expired') }}
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 text-xs font-medium rounded-full">
                                                {{ __('crm.upcoming') }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Discount Badge -->
                                    <div class="mb-4">
                                        <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-lg shadow-md">
                                            <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                                            </svg>
                                            <span class="text-2xl font-bold">{{ $campaign->discount_percentage }}%</span>
                                            <span class="text-xs {{ app()->getLocale() == 'ar' ? 'mr-1' : 'ml-1' }} opacity-90">{{ __('crm.discount') }}</span>
                                        </div>
                                    </div>

                                    <!-- Campaign Details -->
                                    <div class="space-y-2 text-sm mb-4">
                                        <!-- Duration -->
                                        <div class="flex items-center text-slate-600 dark:text-slate-400">
                                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <span>{{ $campaign->start_date->format('Y-m-d') }} - {{ $campaign->end_date->format('Y-m-d') }}</span>
                                        </div>

                                        @if($campaign->isActive())
                                        <!-- Days Remaining -->
                                        <div class="flex items-center text-green-600 dark:text-green-400 font-medium">
                                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span>{{ $campaign->days_remaining }} {{ $campaign->days_remaining == 1 ? __('frontend.day_left') : __('frontend.days_left') }}</span>
                                        </div>
                                        @endif

                                        <!-- Apply To -->
                                        <div class="flex items-center text-slate-600 dark:text-slate-400">
                                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                            </svg>
                                            <span>
                                                @if($campaign->apply_to_all)
                                                    {{ __('crm.all_products') }}
                                                @else
                                                    {{ count($campaign->products) }} {{ __('crm.selected_products') }}
                                                @endif
                                            </span>
                                        </div>

                                        <!-- Customer Type -->
                                        @if($campaign->customer_type !== 'all')
                                        <div class="flex items-center text-slate-600 dark:text-slate-400">
                                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                            <span>
                                                @if($campaign->customer_type === 'new')
                                                    {{ __('crm.new_customers_only') }}
                                                @else
                                                    {{ __('crm.existing_customers_only') }}
                                                @endif
                                            </span>
                                        </div>
                                        @endif
                                    </div>

                                    <!-- Banner URL -->
                                    @if($campaign->banner_url)
                                    <div class="mb-4 text-xs text-slate-500 dark:text-slate-400">
                                        <div class="flex items-center">
                                            <svg class="w-3 h-3 {{ app()->getLocale() == 'ar' ? 'ml-1' : 'mr-1' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                            </svg>
                                            <span class="truncate">{{ __('crm.has_banner_link') }}</span>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Actions -->
                                    <div class="flex items-center justify-end {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2 pt-4 border-t border-slate-200 dark:border-slate-800">
                                        <a href="{{ route('admin.system-settings.promotions.campaigns.edit', $campaign->id) }}" class="px-3 py-1.5 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded transition-colors" title="{{ __('crm.edit') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <button @click="confirmDelete('campaign', {{ $campaign->id }}, {{ json_encode(app()->getLocale() == 'ar' ? ($campaign->name_ar ?? $campaign->name) : ($campaign->name_en ?? $campaign->name)) }})" class="px-3 py-1.5 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded transition-colors" title="{{ __('crm.delete') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                        <button @click="toggleStatus('campaign', {{ $campaign->id }})" class="px-3 py-1.5 {{ $campaign->is_active ? 'text-yellow-600 dark:text-yellow-400' : 'text-green-600 dark:text-green-400' }} hover:bg-slate-50 dark:hover:bg-slate-800 rounded transition-colors" title="{{ $campaign->is_active ? __('crm.deactivate') : __('crm.activate') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                @if($campaign->is_active)
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                @endif
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <!-- Campaigns List (Empty State) -->
                        <div class="text-center py-12 bg-slate-50 dark:bg-slate-900/50 rounded-lg border-2 border-dashed border-slate-300 dark:border-slate-700">
                            <svg class="mx-auto h-12 w-12 text-slate-400 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-slate-900 dark:text-white">{{ __('crm.no_campaigns_yet') }}</h3>
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ __('crm.get_started_by_creating_campaign') }}</p>
                            <div class="mt-6">
                                <a href="{{ route('admin.system-settings.promotions.campaigns.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700">
                                    <svg class="{{ app()->getLocale() == 'ar' ? '-mr-1 ml-2' : '-ml-1 mr-2' }} h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    {{ __('crm.create_campaign') }}
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <template x-if="showDeleteModal">
        <div class="fixed inset-0 z-[9999] overflow-y-auto" 
             aria-labelledby="modal-title" 
             role="dialog" 
             aria-modal="true"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" 
                 @click="showDeleteModal = false"
                 aria-hidden="true"></div>

            <!-- Modal container -->
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <!-- Modal panel -->
                <div class="relative inline-block align-middle bg-white dark:bg-slate-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     @click.stop>
                    
                    <div class="bg-white dark:bg-slate-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/30 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 {{ app()->getLocale() == 'ar' ? 'sm:mr-4' : 'sm:ml-4' }} sm:text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                                    {{ __('crm.confirm_deletion') }}
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        <span x-text="deleteType === 'coupon' ? '{{ __('crm.confirm_delete_coupon') }}' : '{{ __('crm.confirm_delete_campaign') }}'"></span>
                                        <strong class="text-gray-900 dark:text-white" x-text="deleteName"></strong>?
                                    </p>
                                    <p class="text-sm text-red-600 dark:text-red-400 mt-2">
                                        {{ __('crm.delete_warning_irreversible') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 dark:bg-slate-900 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-3">
                        <button type="button" 
                                @click="performDelete()"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm transition-colors">
                            {{ __('crm.delete') }}
                        </button>
                        <button type="button" 
                                @click="showDeleteModal = false"
                                class="mt-3 sm:mt-0 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-slate-700 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto sm:text-sm transition-colors">
                            {{ __('crm.cancel') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
@endsection
