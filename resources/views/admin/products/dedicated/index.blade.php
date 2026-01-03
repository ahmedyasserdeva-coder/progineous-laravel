@extends('admin.layout')

@section('page-title', __('crm.dedicated_plans'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">
                    {{ __('crm.dedicated_plans') }}
                </h1>
                <p class="text-slate-600 dark:text-slate-400">
                    {{ __('crm.manage_dedicated_plans') }}
                </p>
            </div>
            <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-3">
                <form action="{{ route('admin.system-settings.products.dedicated-plans.sync') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <span>{{ __('crm.sync_from_hetzner') }}</span>
                    </button>
                </form>
                <a href="{{ route('admin.system-settings.products.dedicated-plans.create') }}" class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg shadow-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>{{ __('crm.add_dedicated_plan') }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-6 py-4 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 px-6 py-4 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Plans Grid -->
    @if($plans->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($plans as $plan)
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden hover:shadow-xl transition-shadow">
                    <!-- Plan Header -->
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-6 text-white">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-xl font-bold">{{ $plan->plan_name }}</h3>
                            @if($plan->is_featured)
                                <span class="px-2 py-1 bg-yellow-400 text-yellow-900 text-xs font-semibold rounded">
                                    {{ __('crm.featured') }}
                                </span>
                            @endif
                        </div>
                        @if($plan->plan_tagline)
                            <p class="text-purple-100 text-sm">{{ $plan->plan_tagline }}</p>
                        @endif
                    </div>

                    <!-- Plan Body -->
                    <div class="p-6">
                        <!-- Specs -->
                        <div class="space-y-3 mb-6">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-600 dark:text-slate-400">{{ __('crm.cpu_type') }}</span>
                                <span class="font-semibold text-slate-900 dark:text-white">{{ $plan->cpu_type }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-600 dark:text-slate-400">{{ __('crm.cpu_cores') }}</span>
                                <span class="font-semibold text-slate-900 dark:text-white">{{ $plan->cpu_cores }} {{ __('crm.cores') }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-600 dark:text-slate-400">{{ __('crm.ram_gb') }}</span>
                                <span class="font-semibold text-slate-900 dark:text-white">{{ $plan->getFormattedRamAttribute() }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-600 dark:text-slate-400">{{ __('crm.storage_config') }}</span>
                                <span class="font-semibold text-slate-900 dark:text-white">{{ $plan->storage_config }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-600 dark:text-slate-400">{{ __('crm.bandwidth') }}</span>
                                <span class="font-semibold text-slate-900 dark:text-white">{{ $plan->bandwidth }}</span>
                            </div>
                        </div>

                        <!-- Pricing -->
                        <div class="border-t border-slate-200 dark:border-slate-700 pt-4 mb-4">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-slate-900 dark:text-white">
                                    ${{ number_format($plan->monthly_price, 2) }}
                                </div>
                                <div class="text-sm text-slate-600 dark:text-slate-400">{{ __('crm.per_month') }}</div>
                                @if($plan->setup_fee > 0)
                                    <div class="text-xs text-slate-500 mt-1">
                                        + ${{ number_format($plan->setup_fee, 2) }} {{ __('crm.setup_fee') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Status & Stats -->
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded {{ $plan->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400' }}">
                                {{ $plan->is_active ? __('crm.active') : __('crm.inactive') }}
                            </span>
                            @if($plan->requires_approval)
                                <span class="px-2 py-1 bg-orange-100 text-orange-800 dark:bg-orange-900/20 dark:text-orange-400 text-xs font-semibold rounded">
                                    {{ __('crm.requires_approval') }}
                                </span>
                            @endif
                            <span class="text-sm text-slate-600 dark:text-slate-400">
                                {{ $plan->instances->count() }} {{ __('crm.instances') }}
                            </span>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-2">
                            <a href="{{ route('admin.system-settings.products.dedicated-plans.edit', $plan) }}" class="flex-1 px-4 py-2 bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 text-center rounded-lg hover:bg-purple-100 dark:hover:bg-purple-900/40 transition-colors">
                                {{ __('crm.edit') }}
                            </a>
                            <form action="{{ route('admin.system-settings.products.dedicated-plans.destroy', $plan) }}" method="POST" class="flex-1" onsubmit="return confirm('{{ __('crm.confirm_delete') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full px-4 py-2 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/40 transition-colors">
                                    {{ __('crm.delete') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 p-12 text-center">
            <svg class="w-16 h-16 mx-auto mb-4 text-slate-400 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
            </svg>
            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">{{ __('crm.no_dedicated_plans_found') }}</h3>
            <p class="text-slate-600 dark:text-slate-400 mb-4">{{ __('crm.get_started_by_creating_dedicated_plan') }}</p>
            <div class="flex items-center justify-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-4">
                <a href="{{ route('admin.system-settings.products.dedicated-plans.create') }}" class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors">
                    {{ __('crm.add_dedicated_plan') }}
                </a>
                <form action="{{ route('admin.system-settings.products.dedicated-plans.sync') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                        {{ __('crm.sync_from_hetzner') }}
                    </button>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection
