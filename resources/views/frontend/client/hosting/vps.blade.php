@extends('frontend.client.layout')

@section('title', __('frontend.vps_hosting') . ' - ' . config('app.name'))

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ __('frontend.vps_hosting') }}
                </h1>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    {{ __('frontend.manage_vps_services') }}
                </p>
            </div>
            <a href="{{ route('vps.hosting') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                {{ __('frontend.order_new_vps') }}
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border-2 border-gray-200 dark:border-gray-700 hover:border-blue-400 dark:hover:border-blue-600 transition-all hover:shadow-md">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total'] }}</div>
                    <div class="text-xs text-gray-600 dark:text-gray-400">{{ __('frontend.total_services') }}</div>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border-2 border-gray-200 dark:border-gray-700 hover:border-green-400 dark:hover:border-green-600 transition-all hover:shadow-md">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-green-50 dark:bg-green-900/20 rounded-lg">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-green-600">{{ $stats['active'] }}</div>
                    <div class="text-xs text-gray-600 dark:text-gray-400">{{ __('frontend.active') }}</div>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border-2 border-gray-200 dark:border-gray-700 hover:border-yellow-400 dark:hover:border-yellow-600 transition-all hover:shadow-md">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                    <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</div>
                    <div class="text-xs text-gray-600 dark:text-gray-400">{{ __('frontend.pending') }}</div>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border-2 border-gray-200 dark:border-gray-700 hover:border-orange-400 dark:hover:border-orange-600 transition-all hover:shadow-md">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
                    <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-orange-600">{{ $stats['suspended'] }}</div>
                    <div class="text-xs text-gray-600 dark:text-gray-400">{{ __('frontend.suspended') }}</div>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border-2 border-gray-200 dark:border-gray-700 hover:border-red-400 dark:hover:border-red-600 transition-all hover:shadow-md">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-red-50 dark:bg-red-900/20 rounded-lg">
                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-red-600">{{ $stats['failed'] }}</div>
                    <div class="text-xs text-gray-600 dark:text-gray-400">{{ __('frontend.failed') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- VPS Services List -->
    @if($vpsServices->isEmpty())
        <div class="bg-white dark:bg-gray-800 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 p-16 text-center">
            <div class="inline-flex p-4 bg-blue-50 dark:bg-blue-900/20 rounded-full mb-4">
                <svg class="w-16 h-16 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                {{ __('frontend.no_vps_services') }}
            </h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-8 max-w-md mx-auto">
                {{ __('frontend.no_vps_services_desc') }}
            </p>
            <a href="{{ route('vps.hosting') }}" 
               class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all hover:shadow-lg hover:scale-105">
                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                {{ __('frontend.order_vps_now') }}
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 gap-4">
            @foreach($vpsServices as $service)
                <div class="bg-white dark:bg-gray-800 rounded-xl border-2 border-gray-200 dark:border-gray-700 p-6 hover:border-blue-400 dark:hover:border-blue-600 hover:shadow-lg transition-all">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <!-- Service Info -->
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-3">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ $service->domain }}
                                </h3>
                                <span class="px-2.5 py-0.5 text-xs font-medium rounded-full
                                    {{ $service->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                    {{ $service->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
                                    {{ $service->status === 'suspended' ? 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400' : '' }}
                                    {{ $service->status === 'failed' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : '' }}
                                    {{ !in_array($service->status, ['active', 'pending', 'suspended', 'failed']) ? 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400' : '' }}">
                                    {{ ucfirst($service->status) }}
                                </span>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div>
                                    <div class="text-gray-500 dark:text-gray-400 mb-1">{{ __('frontend.server_ip') }}</div>
                                    @php
                                        $serverIp = $service->server_ip;
                                        if (!$serverIp && $service->server_data) {
                                            $serverData = is_string($service->server_data) ? json_decode($service->server_data, true) : $service->server_data;
                                            $serverIp = $serverData['ipv4'] ?? null;
                                        }
                                    @endphp
                                    @if($serverIp)
                                        <div class="font-mono font-semibold text-blue-600 dark:text-blue-400" dir="ltr">
                                            {{ $serverIp }}
                                        </div>
                                    @else
                                        <div class="font-medium text-gray-400 dark:text-gray-500">
                                            --
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-gray-500 dark:text-gray-400 mb-1">{{ __('frontend.order_number') }}</div>
                                    <div class="font-medium text-gray-900 dark:text-white">
                                        #{{ $service->order->order_number ?? 'N/A' }}
                                    </div>
                                </div>
                                <div>
                                    <div class="text-gray-500 dark:text-gray-400 mb-1">{{ __('frontend.created_at') }}</div>
                                    <div class="font-medium text-gray-900 dark:text-white">
                                        {{ $service->created_at->format('Y-m-d') }}
                                    </div>
                                </div>
                                <div>
                                    <div class="text-gray-500 dark:text-gray-400 mb-1">{{ __('frontend.next_due_date') }}</div>
                                    <div class="font-medium text-gray-900 dark:text-white">
                                        @if($service->next_due_date)
                                            {{ $service->next_due_date->format('Y-m-d') }}
                                        @elseif($service->billing_cycle === null || $service->order->billing_cycle === 'one_time')
                                            <span class="text-gray-500 dark:text-gray-400">{{ __('frontend.one_time_payment') }}</span>
                                        @else
                                            --
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if($service->status === 'failed')
                                <div class="mt-3 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                                    <div class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <div class="text-sm">
                                            <div class="font-medium text-red-800 dark:text-red-300">{{ __('frontend.service_activation_failed') }}</div>
                                            <div class="text-red-700 dark:text-red-400 mt-1">{{ __('frontend.contact_support_for_help') }}</div>
                                        </div>
                                    </div>
                                </div>
                            @elseif($service->status === 'pending')
                                <div class="mt-3 p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                                    <div class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 flex-shrink-0 mt-0.5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                        </svg>
                                        <div class="text-sm text-yellow-800 dark:text-yellow-300">
                                            {{ __('frontend.vps_being_provisioned') }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Action Button -->
                        <div class="flex-shrink-0">
                            @if($service->status === 'active')
                                <a href="{{ route('client.hosting.vps.show', ['id' => $service->id]) }}" 
                                   class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-all hover:shadow-md hover:scale-105">
                                    {{ __('frontend.manage') }}
                                    <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            @else
                                <a href="{{ route('client.hosting.vps.show', ['id' => $service->id]) }}" 
                                   class="inline-flex items-center px-5 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-all hover:shadow-sm">
                                    {{ __('frontend.view_details') }}
                                    <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
