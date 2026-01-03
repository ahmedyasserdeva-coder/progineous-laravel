@extends('frontend.client.layout')

@section('title', __('frontend.dedicated_servers') . ' - ' . config('app.name'))

@section('content')
<div class="p-4 md:p-6 space-y-6">
    <!-- Header & Stats Combined Widget -->
    <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 dark:from-black dark:via-slate-900 dark:to-black rounded-2xl overflow-hidden relative">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.4\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>
        
        <div class="relative p-6">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-white/10 backdrop-blur-sm rounded-2xl ring-1 ring-white/20">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white">{{ __('frontend.dedicated_servers') }}</h1>
                        <p class="text-slate-400 text-sm mt-0.5">{{ __('frontend.manage_dedicated_servers') }}</p>
                    </div>
                </div>
                <a href="{{ route('dedicated.servers') }}" 
                   class="inline-flex items-center justify-center px-5 py-2.5 bg-white text-slate-900 text-sm font-semibold rounded-xl hover:bg-slate-100 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 group">
                    <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    {{ __('frontend.order_new_dedicated') }}
                </a>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                <!-- Total -->
                <div class="bg-white/5 backdrop-blur-sm rounded-xl p-4 border border-white/10 hover:bg-white/10 transition-all group">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-slate-500/20 rounded-lg group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-white">{{ $stats['total'] }}</div>
                            <div class="text-xs text-slate-400">{{ __('frontend.total_services') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Active -->
                <div class="bg-emerald-500/10 backdrop-blur-sm rounded-xl p-4 border border-emerald-500/20 hover:bg-emerald-500/20 transition-all group">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-emerald-500/20 rounded-lg group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-emerald-400">{{ $stats['active'] }}</div>
                            <div class="text-xs text-emerald-400/70">{{ __('frontend.active') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Pending -->
                <div class="bg-amber-500/10 backdrop-blur-sm rounded-xl p-4 border border-amber-500/20 hover:bg-amber-500/20 transition-all group">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-amber-500/20 rounded-lg group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-amber-400">{{ $stats['pending'] }}</div>
                            <div class="text-xs text-amber-400/70">{{ __('frontend.pending') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Suspended -->
                <div class="bg-red-500/10 backdrop-blur-sm rounded-xl p-4 border border-red-500/20 hover:bg-red-500/20 transition-all group">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-red-500/20 rounded-lg group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-red-400">{{ $stats['suspended'] }}</div>
                            <div class="text-xs text-red-400/70">{{ __('frontend.suspended') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Servers Grid -->
    @if($dedicatedServers->isEmpty())
        <!-- Empty State -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-12">
            <div class="text-center max-w-md mx-auto">
                <div class="inline-flex p-5 bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-700 dark:to-slate-600 rounded-2xl mb-5">
                    <svg class="w-14 h-14 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                    {{ __('frontend.no_dedicated_servers') }}
                </h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6">
                    {{ __('frontend.no_dedicated_servers_desc') }}
                </p>
                <a href="{{ route('dedicated.servers') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl transition-all hover:shadow-lg hover:-translate-y-0.5">
                    <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    {{ __('frontend.order_dedicated_now') }}
                </a>
            </div>
        </div>
    @else
        <!-- Servers Cards Grid -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
            @foreach($dedicatedServers as $service)
                @php
                    $serverData = $service->server_data;
                    if (is_string($serverData)) {
                        $serverData = json_decode($serverData, true);
                    }
                    $serverIp = $serverData['ipv4'] ?? $service->ip_address ?? null;
                    $serverType = $serverData['server_type'] ?? null;
                    $location = $serverData['location'] ?? null;
                @endphp
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg hover:border-blue-300 dark:hover:border-blue-600 transition-all group">
                    <!-- Card Header with Status -->
                    <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between bg-gray-50/50 dark:bg-gray-800/50">
                        <div class="flex items-center gap-3">
                            <div class="p-2.5 bg-gradient-to-br from-slate-600 to-slate-700 rounded-xl shadow-sm">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <h3 class="font-semibold text-gray-900 dark:text-white truncate">
                                    {{ $serverData['hetzner_server_name'] ?? $service->service_name ?? 'Dedicated Server #' . $service->id }}
                                </h3>
                                @if($serverIp)
                                    <div class="flex items-center gap-1.5 mt-0.5">
                                        <code class="text-xs text-gray-500 dark:text-gray-400 font-mono">{{ $serverIp }}</code>
                                        <button onclick="navigator.clipboard.writeText('{{ $serverIp }}'); this.querySelector('svg').classList.add('text-emerald-500'); setTimeout(() => this.querySelector('svg').classList.remove('text-emerald-500'), 1500)" 
                                                class="p-0.5 text-gray-400 hover:text-blue-600 transition-colors rounded" title="Copy IP">
                                            <svg class="w-3 h-3 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                            </svg>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <!-- Status Badge -->
                        @if($service->status === 'active')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 text-xs font-semibold rounded-full">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                                {{ __('frontend.active') }}
                            </span>
                        @elseif(in_array($service->status, ['pending', 'pending_approval', 'provisioning']))
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 text-xs font-semibold rounded-full">
                                <svg class="w-3 h-3 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                {{ $service->status === 'provisioning' ? __('frontend.provisioning') : __('frontend.pending') }}
                            </span>
                        @elseif($service->status === 'suspended')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 text-xs font-semibold rounded-full">
                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                {{ __('frontend.suspended') }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 text-xs font-semibold rounded-full">
                                {{ ucfirst($service->status) }}
                            </span>
                        @endif
                    </div>

                    <!-- Card Body -->
                    <div class="p-5">
                        <!-- Server Info Grid -->
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            @if($serverType)
                            <div class="text-center p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                                </svg>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ __('frontend.server_type') }}</div>
                                <div class="text-sm font-bold text-gray-900 dark:text-white">{{ strtoupper($serverType) }}</div>
                            </div>
                            @endif
                            @if($location)
                            <div class="text-center p-3 bg-slate-50 dark:bg-slate-700/50 rounded-xl">
                                <svg class="w-5 h-5 text-slate-600 dark:text-slate-400 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ __('frontend.location') }}</div>
                                <div class="text-sm font-bold text-gray-900 dark:text-white">{{ strtoupper($location) }}</div>
                            </div>
                            @endif
                            <div class="text-center p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl">
                                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ __('frontend.price') }}</div>
                                <div class="text-sm font-bold text-emerald-600 dark:text-emerald-400">${{ number_format($service->recurring_amount, 2) }}<span class="text-xs font-normal text-gray-500">/{{ $service->billing_cycle }}</span></div>
                            </div>
                        </div>

                        <!-- Additional Info -->
                        <div class="flex flex-wrap items-center gap-2 mb-4 text-xs">
                            @if($service->next_due_date)
                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded-md">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ __('frontend.next_due_date') }}: {{ \Carbon\Carbon::parse($service->next_due_date)->format('M d, Y') }}
                                </span>
                            @endif
                            @if(isset($serverData['ipv6']))
                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-md">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                    </svg>
                                    IPv6 {{ __('frontend.enabled') }}
                                </span>
                            @endif
                        </div>

                        <!-- Action Button -->
                        @if($service->status === 'active')
                            <a href="{{ route('client.hosting.dedicated.show', $service->id) }}" 
                               class="flex items-center justify-center w-full px-4 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-sm font-semibold rounded-xl transition-all hover:shadow-lg group-hover:-translate-y-0.5">
                                <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ __('frontend.manage') }}
                            </a>
                        @else
                            <a href="{{ route('client.hosting.dedicated.show', $service->id) }}" 
                               class="flex items-center justify-center w-full px-4 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-semibold rounded-xl transition-colors">
                                <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                {{ __('frontend.view_details') }}
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($dedicatedServers->hasPages())
            <div class="mt-6">
                {{ $dedicatedServers->links() }}
            </div>
        @endif
    @endif
</div>
@endsection
