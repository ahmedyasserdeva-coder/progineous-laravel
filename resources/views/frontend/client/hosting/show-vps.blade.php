@extends('frontend.client.layout')

@section('title', __('frontend.vps_details') . ' - ' . config('app.name'))

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js"></script>
@endpush

@section('content')
<div class="max-w-full overflow-x-hidden">
    <!-- Header -->
    <div class="mb-4 md:mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <a href="{{ route('client.hosting.vps') }}" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </a>
                    <h1 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white">
                        {{ __('frontend.vps_details') }}
                    </h1>
                </div>
                <p class="text-xs md:text-sm text-gray-600 dark:text-gray-400">
                    {{ $service->service_name ?? 'VPS Server' }}
                </p>
            </div>
            <span class="px-4 py-2 text-sm font-semibold rounded-lg
                {{ $service->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : '' }}
                {{ $service->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
                {{ $service->status === 'suspended' ? 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400' : '' }}
                {{ $service->status === 'failed' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : '' }}">
                {{ ucfirst($service->status) }}
            </span>
        </div>
    </div>

    <!-- Service Info Bar -->
    <div class="bg-white dark:bg-gray-800 rounded-lg md:rounded-xl border md:border-2 border-gray-200 dark:border-gray-700 p-4 md:p-6 mb-4 md:mb-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <!-- Info Section -->
            <div class="flex flex-wrap items-center gap-3 md:gap-4">
                @if($service->status === 'active' && $serverData)
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="text-xs md:text-sm font-semibold text-green-600" id="server-status">{{ __('frontend.checking') }}</span>
                </div>
    
                <div class="h-6 md:h-8 w-px bg-gray-300 dark:bg-gray-600"></div>
                <div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ __('frontend.order_number') }}</div>
                    <div class="text-xs md:text-sm font-semibold text-gray-900 dark:text-white">#{{ $service->order->order_number ?? $service->order_id }}</div>
                </div>
                @if($service->billing_cycle)
                <div class="hidden sm:block h-6 md:h-8 w-px bg-gray-300 dark:bg-gray-600"></div>
                <div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ __('frontend.billing_cycle') }}</div>
                    <div class="text-xs md:text-sm font-semibold text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $service->billing_cycle)) }}</div>
                </div>
                @endif
    
                @if($service->next_due_date)
                <div class="hidden md:block h-6 md:h-8 w-px bg-gray-300 dark:bg-gray-600"></div>
                <div class="hidden md:block">
                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ __('frontend.next_due_date') }}</div>
                    <div class="text-xs md:text-sm font-semibold text-gray-900 dark:text-white">{{ $service->next_due_date->format('Y-m-d') }}</div>
                </div>
                @endif
                @endif
    
            </div>
            
            <!-- Actions & Price Section -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 md:gap-4 w-full lg:w-auto">
                @if($service->status === 'active' && $serverData)
                <div class="grid grid-cols-2 sm:flex sm:flex-wrap gap-2">
                    <button id="btn-start" onclick="executeAction('start')" disabled 
                        class="inline-flex items-center justify-center gap-1.5 px-2.5 py-2 sm:px-3 sm:py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded-md transition-colors disabled:bg-gray-300 dark:disabled:bg-gray-700 disabled:text-gray-500 dark:disabled:text-gray-500 disabled:cursor-not-allowed">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                        </svg>
                        <span class="hidden sm:inline">{{ __('frontend.start') }}</span>
                    </button>

                    <button id="btn-restart" onclick="executeAction('restart')" disabled 
                        class="inline-flex items-center justify-center gap-1.5 px-2.5 py-2 sm:px-3 sm:py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-md transition-colors disabled:bg-gray-300 dark:disabled:bg-gray-700 disabled:text-gray-500 dark:disabled:text-gray-500 disabled:cursor-not-allowed">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <span class="hidden sm:inline">{{ __('frontend.restart') }}</span>
                    </button>

                    <button id="btn-stop" onclick="executeAction('stop')" disabled 
                        class="inline-flex items-center justify-center gap-1.5 px-2.5 py-2 sm:px-3 sm:py-1.5 bg-orange-500 hover:bg-orange-600 text-white text-xs font-medium rounded-md transition-colors disabled:bg-gray-300 dark:disabled:bg-gray-700 disabled:text-gray-500 dark:disabled:text-gray-500 disabled:cursor-not-allowed">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 00-1 1v4a1 1 0 001 1h4a1 1 0 001-1V8a1 1 0 00-1-1H8z" clip-rule="evenodd"/>
                        </svg>
                        <span class="hidden sm:inline">{{ __('frontend.stop') }}</span>
                    </button>

                    <button id="btn-power-off" onclick="executeAction('power_off')" disabled 
                        class="inline-flex items-center justify-center gap-1.5 px-2.5 py-2 sm:px-3 sm:py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-md transition-colors disabled:bg-gray-300 dark:disabled:bg-gray-700 disabled:text-gray-500 dark:disabled:text-gray-500 disabled:cursor-not-allowed">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <span class="hidden sm:inline">{{ __('frontend.power_off') }}</span>
                    </button>

                    <button id="btn-console" onclick="openConsole()" 
                        class="inline-flex items-center justify-center gap-1.5 px-2.5 py-2 sm:px-3 sm:py-1.5 bg-purple-600 hover:bg-purple-700 text-white text-xs font-medium rounded-md transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="hidden sm:inline">Console</span>
                    </button>
                </div>
                @endif
                
                @if($service->recurring_amount && $service->recurring_amount > 0)
                <div class="text-lg sm:text-xl md:text-2xl font-bold text-blue-600 dark:text-blue-400 text-center sm:text-left shrink-0">
                    ${{ number_format($service->recurring_amount, 2) }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    @if($service->status === 'active' && $serverData)
    <div class="mb-4 md:mb-6">
        <!-- Tabs Navigation - Minimalist Design -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 flex justify-center">
            <!-- Tabs Container -->
            <div id="tabs-container" 
                 class="flex gap-1 overflow-x-auto py-2 px-2" 
                 style="scrollbar-width: none; -ms-overflow-style: none;">
                
                <!-- Overview Tab -->
                <button onclick="switchTab('overview')" 
                        id="tab-overview" 
                        class="tab-button active flex-shrink-0 flex items-center justify-center gap-1.5 px-3 py-2 rounded-md text-xs font-medium transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span class="hidden sm:inline">Overview</span>
                </button>
                    
                    <!-- Graphs Tab -->
                    <button onclick="switchTab('graphs')" 
                            id="tab-graphs" 
                            class="tab-button flex-shrink-0 flex items-center justify-center gap-1.5 px-3 py-2 rounded-md text-xs font-medium transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span class="hidden sm:inline">Graphs</span>
                    </button>
                    
                    <!-- Backups Tab -->
                    <button onclick="switchTab('backups')" 
                            id="tab-backups" 
                            class="tab-button flex-shrink-0 flex items-center justify-center gap-1.5 px-3 py-2 rounded-md text-xs font-medium transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                        <span class="hidden sm:inline">Backups</span>
                    </button>
                    
                    <!-- Snapshots Tab -->
                    <button onclick="switchTab('snapshots')" 
                            id="tab-snapshots" 
                            class="tab-button flex-shrink-0 flex items-center justify-center gap-1.5 px-3 py-2 rounded-md text-xs font-medium transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="hidden sm:inline">Snapshots</span>
                    </button>
                    
                    <!-- ISO Images Tab -->
                    <button onclick="switchTab('iso')" 
                            id="tab-iso" 
                            class="tab-button flex-shrink-0 flex items-center justify-center gap-1.5 px-3 py-2 rounded-md text-xs font-medium transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" stroke-width="2"/>
                            <circle cx="12" cy="12" r="2.5" stroke-width="2"/>
                        </svg>
                        <span class="hidden sm:inline">ISO</span>
                    </button>
                    
                    <!-- Network Tab -->
                    <button onclick="switchTab('network')" 
                            id="tab-network" 
                            class="tab-button flex-shrink-0 flex items-center justify-center gap-1.5 px-3 py-2 rounded-md text-xs font-medium transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                        </svg>
                        <span class="hidden sm:inline">Network</span>
                    </button>
                </div>
            </div>
    </div>
    @endif

    <!-- Tab Contents -->
    @if($service->status === 'active' && $serverData)
    <!-- Overview Tab Content -->
    <div id="content-overview" class="tab-content">
    <!-- Server Resources -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-4 md:mb-6">
        <div class="bg-blue-500 px-4 py-3">
            <h3 class="text-sm font-semibold text-white">{{ __('frontend.server_resources') }}</h3>
        </div>
        
        <div class="grid grid-cols-2 divide-x divide-gray-200 dark:divide-gray-700">
            <!-- vCPU -->
            <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('frontend.vcpu') }}</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white" id="server-cpu">--</p>
                    </div>
                </div>
            </div>

            <!-- RAM -->
            <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('frontend.ram') }}</p>
                        <div class="flex items-baseline gap-1">
                            <p class="text-2xl font-bold text-gray-900 dark:text-white" id="server-ram">--</p>
                            <span class="text-xs text-gray-500">GB</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 divide-x divide-gray-200 dark:divide-gray-700 border-t border-gray-200 dark:border-gray-700">
            <!-- Disk -->
            <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('frontend.disk') }}</p>
                        <div class="flex items-baseline gap-1">
                            <p class="text-2xl font-bold text-gray-900 dark:text-white" id="server-disk">--</p>
                            <span class="text-xs text-gray-500">GB</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Traffic -->
            <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('frontend.traffic_out') }}</p>
                        <div class="flex items-baseline gap-1">
                            <p class="text-xl font-bold text-gray-900 dark:text-white" id="server-traffic">--</p>
                            <span class="text-gray-400 text-xs">/</span>
                            <p class="text-lg font-semibold text-gray-600 dark:text-gray-400" id="server-traffic-limit">--</p>
                            <span class="text-xs text-gray-500">TB</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Server Information Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg md:rounded-xl border md:border-2 border-gray-200 dark:border-gray-700 p-4 md:p-6 mb-4 md:mb-6">
        <h2 class="text-base md:text-lg font-bold text-gray-900 dark:text-white mb-4 md:mb-6">{{ __('frontend.server_information') }}</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-4">
            @if($serverIp)
            <div class="p-4 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-lg border border-blue-200 dark:border-blue-700">
                <div class="flex items-center gap-3 mb-2">
                    <div class="p-2 bg-blue-500 rounded-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                        </svg>
                    </div>
                    <div class="text-xs font-semibold text-blue-700 dark:text-blue-300">{{ __('frontend.server_ip') }}</div>
                </div>
                <div class="font-mono text-sm md:text-base font-bold text-blue-900 dark:text-blue-100 break-all" dir="ltr">{{ $serverIp }}</div>
            </div>
            @endif

            @if(isset($serverData['root_password']))
            <div class="p-4 bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-lg border border-purple-200 dark:border-purple-700">
                <div class="flex items-center gap-3 mb-2">
                    <div class="p-2 bg-purple-500 rounded-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="text-xs font-semibold text-purple-700 dark:text-purple-300">{{ __('frontend.root_password') }}</div>
                        <div class="text-xs text-purple-600 dark:text-purple-400 mt-0.5">Initial password (if changed manually, not updated here)</div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span id="password-field" class="font-mono text-xs md:text-sm font-medium text-purple-900 dark:text-purple-100 break-all">••••••••••••</span>
                    <button onclick="togglePassword()" class="p-1 hover:bg-purple-200 dark:hover:bg-purple-700 rounded transition-colors">
                        <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
            </div>
            @endif

            @if(isset($serverData['server_type']))
            <div class="p-4 bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-lg border border-green-200 dark:border-green-700">
                <div class="flex items-center gap-3 mb-2">
                    <div class="p-2 bg-green-500 rounded-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                        </svg>
                    </div>
                    <div class="text-xs font-semibold text-green-700 dark:text-green-300">{{ __('frontend.server_type') }}</div>
                </div>
                <div class="font-semibold text-green-900 dark:text-green-100">{{ strtoupper($serverData['server_type']) }}</div>
            </div>
            @endif

            @if($osName)
            <div class="p-4 bg-gradient-to-br from-cyan-50 to-cyan-100 dark:from-cyan-900/20 dark:to-cyan-800/20 rounded-lg border border-cyan-200 dark:border-cyan-700">
                <div class="flex items-center gap-3 mb-2">
                    <div class="p-2 bg-cyan-500 rounded-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                        </svg>
                    </div>
                    <div class="text-xs font-semibold text-cyan-700 dark:text-cyan-300">{{ __('frontend.operating_system') }}</div>
                </div>
                <div class="font-semibold text-cyan-900 dark:text-cyan-100">{{ $osName }}</div>
            </div>
            @endif

            @if(isset($serverData['location']))
            <div class="p-4 bg-gradient-to-br from-yellow-50 to-yellow-100 dark:from-yellow-900/20 dark:to-yellow-800/20 rounded-lg border border-yellow-200 dark:border-yellow-700">
                <div class="flex items-center gap-3 mb-2">
                    <div class="p-2 bg-yellow-500 rounded-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div class="text-xs font-semibold text-yellow-700 dark:text-yellow-300">{{ __('frontend.location') }}</div>
                </div>
                <div class="font-semibold text-yellow-900 dark:text-yellow-100">{{ strtoupper($serverData['location']) }}</div>
            </div>
            @endif

            @if(isset($serverData['ipv6']))
            <div class="p-4 bg-gradient-to-br from-indigo-50 to-indigo-100 dark:from-indigo-900/20 dark:to-indigo-800/20 rounded-lg border border-indigo-200 dark:border-indigo-700 col-span-full">
                <div class="flex items-center gap-3 mb-2">
                    <div class="p-2 bg-indigo-500 rounded-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div class="text-xs font-semibold text-indigo-700 dark:text-indigo-300">{{ __('frontend.ipv6_address') }}</div>
                </div>
                <div class="font-mono text-xs md:text-sm font-medium text-indigo-900 dark:text-indigo-100 break-all" dir="ltr">{{ $serverData['ipv6'] }}</div>
            </div>
            @endif
        </div>
    </div>

    <!-- Location -->
    <div class="mb-4 md:mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg md:rounded-xl border md:border-2 border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-cyan-600 px-4 md:px-6 py-3 md:py-4">
                <div class="flex items-center gap-2 md:gap-3">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="text-base md:text-xl font-bold text-white">{{ __('frontend.server_location') }}</h3>
                </div>
            </div>
            
            <div class="p-4 md:p-6">
                <!-- Location Details -->
                <div id="location-details" class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-4">
                    <div class="p-4 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-lg border border-blue-200 dark:border-blue-700">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 bg-blue-500 rounded-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                                </svg>
                            </div>
                            <div class="text-xs font-semibold text-blue-700 dark:text-blue-300">{{ __('frontend.datacenter') }}</div>
                        </div>
                        <div id="loc-datacenter" class="font-semibold text-blue-900 dark:text-blue-100">--</div>
                    </div>
                    
                    <div class="p-4 bg-gradient-to-br from-cyan-50 to-cyan-100 dark:from-cyan-900/20 dark:to-cyan-800/20 rounded-lg border border-cyan-200 dark:border-cyan-700">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 bg-cyan-500 rounded-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <div class="text-xs font-semibold text-cyan-700 dark:text-cyan-300">{{ __('frontend.city') }}</div>
                        </div>
                        <div id="loc-city" class="font-semibold text-cyan-900 dark:text-cyan-100">--</div>
                    </div>
                    
                    <div class="p-4 bg-gradient-to-br from-teal-50 to-teal-100 dark:from-teal-900/20 dark:to-teal-800/20 rounded-lg border border-teal-200 dark:border-teal-700">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 bg-teal-500 rounded-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="text-xs font-semibold text-teal-700 dark:text-teal-300">{{ __('frontend.country') }}</div>
                        </div>
                        <div id="loc-country" class="font-semibold text-teal-900 dark:text-teal-100">--</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activities -->
    <div class="mb-4 md:mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg md:rounded-xl border md:border-2 border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-4 md:px-6 py-3 md:py-4">
                <div class="flex items-center gap-2 md:gap-3">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="text-base md:text-xl font-bold text-white">{{ __('frontend.activities') }}</h3>
                </div>
            </div>
            
            <div class="p-4 md:p-6">
                <div id="activities-list" class="space-y-3">
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p>{{ __('frontend.loading_activities') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($service->status === 'active')
    <!-- Snapshots -->
    <div class="mb-4 md:mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg md:rounded-xl border md:border-2 border-gray-200 dark:border-gray-700 p-4 md:p-6">
            <div class="flex items-center gap-2 mb-3 md:mb-4">
                <svg class="w-5 h-5 md:w-6 md:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <h2 class="text-base md:text-lg font-bold text-gray-900 dark:text-white">{{ __('frontend.snapshots_backups') }}</h2>
            </div>
            <p class="text-xs md:text-sm text-gray-600 dark:text-gray-400 mb-3 md:mb-4">{{ __('frontend.snapshot_description') }}</p>
            <button onclick="createSnapshot()" class="w-full px-4 py-3 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white rounded-lg font-semibold transition-all transform hover:scale-105 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('frontend.create_snapshot') }}
            </button>
        </div>
    </div>
    @endif

    </div>
    <!-- End Overview Tab -->

    <!-- Graphs Tab Content -->
    <div id="content-graphs" class="tab-content hidden">
        <div class="grid grid-cols-1 gap-4 md:gap-6">
            <!-- CPU Graph -->
            <div class="bg-white dark:bg-gray-800 rounded-lg md:rounded-xl border md:border-2 border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-4 md:px-6 py-3 md:py-4">
                    <h3 class="text-base md:text-lg font-bold text-white">CPU Usage</h3>
                </div>
                <div class="p-4 md:p-6 relative">
                    <div id="cpu-loader" class="absolute inset-0 flex items-center justify-center bg-white dark:bg-gray-800 z-10">
                        <div class="text-center">
                            <div class="relative w-24 h-24 mx-auto mb-4">
                                <div class="absolute inset-0 border-4 border-purple-200 dark:border-purple-800 rounded-full"></div>
                                <div class="absolute inset-0 border-4 border-transparent border-t-purple-600 rounded-full animate-spin"></div>
                                <div class="absolute inset-2 border-4 border-transparent border-t-indigo-600 rounded-full animate-spin" style="animation-duration: 1.5s; animation-direction: reverse;"></div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 font-semibold">Loading CPU data...</p>
                        </div>
                    </div>
                    <canvas id="cpu-chart" style="height: 300px;"></canvas>
                </div>
            </div>

            <!-- Network Graph -->
            <div class="bg-white dark:bg-gray-800 rounded-lg md:rounded-xl border md:border-2 border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-cyan-600 px-4 md:px-6 py-3 md:py-4">
                    <h3 class="text-base md:text-lg font-bold text-white">Network Traffic</h3>
                </div>
                <div class="p-4 md:p-6 relative">
                    <div id="network-loader" class="absolute inset-0 flex items-center justify-center bg-white dark:bg-gray-800 z-10">
                        <div class="text-center">
                            <div class="relative w-24 h-24 mx-auto mb-4">
                                <div class="absolute inset-0 border-4 border-blue-200 dark:border-blue-800 rounded-full"></div>
                                <div class="absolute inset-0 border-4 border-transparent border-t-blue-600 rounded-full animate-spin"></div>
                                <div class="absolute inset-2 border-4 border-transparent border-t-cyan-600 rounded-full animate-spin" style="animation-duration: 1.5s; animation-direction: reverse;"></div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 font-semibold">Loading Network data...</p>
                        </div>
                    </div>
                    <canvas id="network-chart" style="height: 300px;"></canvas>
                </div>
            </div>

            <!-- Disk IOPS Graph -->
            <div class="bg-white dark:bg-gray-800 rounded-lg md:rounded-xl border md:border-2 border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-4 md:px-6 py-3 md:py-4">
                    <h3 class="text-base md:text-lg font-bold text-white">Disk IOPS</h3>
                </div>
                <div class="p-4 md:p-6 relative">
                    <div id="disk-loader" class="absolute inset-0 flex items-center justify-center bg-white dark:bg-gray-800 z-10">
                        <div class="text-center">
                            <div class="relative w-24 h-24 mx-auto mb-4">
                                <div class="absolute inset-0 border-4 border-green-200 dark:border-green-800 rounded-full"></div>
                                <div class="absolute inset-0 border-4 border-transparent border-t-green-600 rounded-full animate-spin"></div>
                                <div class="absolute inset-2 border-4 border-transparent border-t-emerald-600 rounded-full animate-spin" style="animation-duration: 1.5s; animation-direction: reverse;"></div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 font-semibold">Loading Disk data...</p>
                        </div>
                    </div>
                    <canvas id="disk-chart" style="height: 300px;"></canvas>
                </div>
            </div>

            <!-- Bandwidth Graph -->
            <div class="bg-white dark:bg-gray-800 rounded-lg md:rounded-xl border md:border-2 border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="bg-gradient-to-r from-orange-500 to-red-600 px-4 md:px-6 py-3 md:py-4">
                    <h3 class="text-base md:text-lg font-bold text-white">Network Bandwidth</h3>
                </div>
                <div class="p-4 md:p-6 relative">
                    <div id="bandwidth-loader" class="absolute inset-0 flex items-center justify-center bg-white dark:bg-gray-800 z-10">
                        <div class="text-center">
                            <div class="relative w-24 h-24 mx-auto mb-4">
                                <div class="absolute inset-0 border-4 border-orange-200 dark:border-orange-800 rounded-full"></div>
                                <div class="absolute inset-0 border-4 border-transparent border-t-orange-600 rounded-full animate-spin"></div>
                                <div class="absolute inset-2 border-4 border-transparent border-t-red-600 rounded-full animate-spin" style="animation-duration: 1.5s; animation-direction: reverse;"></div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 font-semibold">Loading Bandwidth data...</p>
                        </div>
                    </div>
                    <canvas id="bandwidth-chart" style="height: 300px;"></canvas>
                </div>
            </div>

            <!-- Disk Throughput Graph -->
            <div class="bg-white dark:bg-gray-800 rounded-lg md:rounded-xl border md:border-2 border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="bg-gradient-to-r from-yellow-500 to-amber-600 px-4 md:px-6 py-3 md:py-4">
                    <h3 class="text-base md:text-lg font-bold text-white">Disk Throughput</h3>
                </div>
                <div class="p-4 md:p-6 relative">
                    <div id="throughput-loader" class="absolute inset-0 flex items-center justify-center bg-white dark:bg-gray-800 z-10">
                        <div class="text-center">
                            <div class="relative w-24 h-24 mx-auto mb-4">
                                <div class="absolute inset-0 border-4 border-yellow-200 dark:border-yellow-800 rounded-full"></div>
                                <div class="absolute inset-0 border-4 border-transparent border-t-yellow-600 rounded-full animate-spin"></div>
                                <div class="absolute inset-2 border-4 border-transparent border-t-amber-600 rounded-full animate-spin" style="animation-duration: 1.5s; animation-direction: reverse;"></div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 font-semibold">Loading Throughput data...</p>
                        </div>
                    </div>
                    <canvas id="throughput-chart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>
    <!-- End Graphs Tab -->

    <!-- Backups Tab -->
    <div id="content-backups" class="tab-content hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg md:rounded-xl border md:border-2 border-gray-200 dark:border-gray-700 p-4 md:p-6 mb-4 md:mb-6">
            <div class="flex items-start gap-3 md:gap-4 mb-4 md:mb-6">
                <div class="p-2 md:p-3 bg-blue-100 dark:bg-blue-900/30 rounded-lg shrink-0">
                    <svg class="w-6 h-6 md:w-8 md:h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <h2 class="text-base md:text-xl font-bold text-gray-900 dark:text-white mb-2">Server Backups</h2>
                    <p class="text-gray-600 dark:text-gray-400 text-xs md:text-sm leading-relaxed">Automatic backup management for your VPS server</p>
                </div>
            </div>

            <div class="bg-blue-50 dark:bg-blue-900/20 border md:border-2 border-blue-200 dark:border-blue-700 rounded-lg md:rounded-xl p-4 md:p-6 mb-4 md:mb-6">
                <div class="flex items-start gap-3 mb-4">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <h3 class="font-bold text-gray-900 dark:text-white mb-3">About Backups</h3>
                        <div class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                            <p>Backups are automatic copies of your server's disks. For every server there are <strong>seven slots</strong> for backups.</p>
                            <p>If all slots are full and an additional one is created, then the <strong>oldest backup will be deleted</strong>.</p>
                            <p>We recommend that you <strong>power off your server</strong> before creating a backup to ensure data consistency on the disks.</p>
                            <p class="text-blue-700 dark:text-blue-300 font-semibold">Enabling Backups for your server will cost <strong>20%</strong> of your server plan per month.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Backup Status -->
            <div id="backup-status-container" class="bg-gray-50 dark:bg-gray-900/50 rounded-lg md:rounded-xl p-4 md:p-6 border md:border-2 border-gray-200 dark:border-gray-700 mb-4 md:mb-6">
                <div class="flex items-center justify-center py-8">
                    <div class="text-center">
                        <div class="relative w-16 h-16 mx-auto mb-4">
                            <div class="absolute inset-0 border-4 border-blue-200 dark:border-blue-800 rounded-full"></div>
                            <div class="absolute inset-0 border-4 border-transparent border-t-blue-600 rounded-full animate-spin"></div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 font-semibold">Loading backup status...</p>
                    </div>
                </div>
            </div>

            <!-- Backups List -->
            <div id="backups-list-container" class="hidden">
                <!-- Will be populated by JavaScript -->
            </div>
        </div>
    </div>
    <!-- End Backups Tab -->

    <!-- ISO Images Tab -->
    <div id="content-iso" class="tab-content hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg md:rounded-xl border md:border-2 border-gray-200 dark:border-gray-700 p-4 md:p-6 mb-4 md:mb-6">
            <div class="flex items-start gap-3 md:gap-4 mb-4 md:mb-6">
                <div class="p-2 md:p-3 bg-purple-100 dark:bg-purple-900/30 rounded-lg shrink-0">
                    <svg class="w-6 h-6 md:w-8 md:h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke-width="2"/>
                        <circle cx="12" cy="12" r="2.5" stroke-width="2"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2.5v2M12 19.5v2M2.5 12h2M19.5 12h2"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <h2 class="text-base md:text-xl font-bold text-gray-900 dark:text-white mb-2">ISO Images</h2>
                    <p class="text-gray-600 dark:text-gray-400 text-xs md:text-sm leading-relaxed">Mount ISO images to install custom operating systems</p>
                </div>
            </div>

            <div class="bg-purple-50 dark:bg-purple-900/20 border md:border-2 border-purple-200 dark:border-purple-700 rounded-lg md:rounded-xl p-4 md:p-6 mb-4 md:mb-6">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <h3 class="font-bold text-gray-900 dark:text-white mb-3">About ISO Images</h3>
                        <div class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                            <p>ISO images allow you to install custom operating systems on your server.</p>
                            <p>When you mount an ISO, your server will be rebooted and boot from the mounted image.</p>
                            <p>You can access the server console to complete the installation process.</p>
                            <p class="text-purple-700 dark:text-purple-300 font-semibold"><strong>Note:</strong> Your server will be unavailable during the installation process.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Currently Mounted ISO -->
            <div id="mounted-iso-container" class="mb-4 md:mb-6">
                <!-- Will be populated by JavaScript if ISO is mounted -->
            </div>

            <!-- ISO Images List -->
            <div id="iso-images-container" class="bg-gray-50 dark:bg-gray-900/50 rounded-lg md:rounded-xl p-4 md:p-6 border md:border-2 border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base md:text-lg font-semibold text-gray-900 dark:text-white">Available ISO Images</h3>
                    <div class="flex items-center gap-2">
                        <input type="text" id="iso-search" placeholder="Search ISOs..." class="px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>
                
                <div class="flex items-center justify-center py-8" id="iso-loading">
                    <div class="text-center">
                        <div class="relative w-16 h-16 mx-auto mb-4">
                            <div class="absolute inset-0 border-4 border-purple-200 dark:border-purple-800 rounded-full"></div>
                            <div class="absolute inset-0 border-4 border-transparent border-t-purple-600 rounded-full animate-spin"></div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 font-semibold">Loading ISO images...</p>
                    </div>
                </div>

                <div id="iso-list" class="hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="iso-grid">
                        <!-- Will be populated by JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End ISO Images Tab -->

    <!-- Network Tab Content -->
    <div id="content-network" class="tab-content hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg md:rounded-xl border md:border-2 border-gray-200 dark:border-gray-700 p-4 md:p-6 overflow-hidden">
            <div class="flex items-center justify-between mb-4 md:mb-6">
                <h2 class="text-base md:text-lg font-bold text-gray-900 dark:text-white">Public Network</h2>
                <button onclick="openFloatingIPModal()" class="inline-flex items-center gap-2 px-3 md:px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs md:text-sm font-semibold rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Add Floating IP</span>
                </button>
            </div>
            
            <div class="mb-4 md:mb-6">
                <div class="flex items-center gap-2 mb-3 md:mb-4">
                    <svg class="w-4 h-4 md:w-5 md:h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="text-sm md:text-base font-semibold text-gray-900 dark:text-white">IP Addresses</h3>
                </div>

                <div class="w-full overflow-x-auto overflow-y-auto max-h-[500px] border border-gray-200 dark:border-gray-700 rounded-lg">
                    <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700 sticky top-0 z-10">
                            <tr>
                                <th class="px-2 md:px-4 py-2 text-left text-[10px] md:text-xs font-medium text-gray-500 dark:text-gray-300 uppercase whitespace-nowrap">IP Address</th>
                                <th class="px-2 md:px-4 py-2 text-left text-[10px] md:text-xs font-medium text-gray-500 dark:text-gray-300 uppercase whitespace-nowrap">Type</th>
                                <th class="px-2 md:px-4 py-2 text-left text-[10px] md:text-xs font-medium text-gray-500 dark:text-gray-300 uppercase whitespace-nowrap">Reverse DNS</th>
                                <th class="px-2 md:px-4 py-2 text-left text-[10px] md:text-xs font-medium text-gray-500 dark:text-gray-300 uppercase whitespace-nowrap">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="network-table" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <tr>
                                <td colspan="4" class="px-3 md:px-6 py-3 md:py-4 text-center text-gray-500 dark:text-gray-400">
                                    <svg class="animate-spin h-5 w-5 mx-auto text-blue-600" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span class="mt-2 block">Loading network information...</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- End Network Tab -->

    <!-- Floating IP Modal -->
    <div id="floatingIPModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <!-- Step 1: Floating IP Configuration -->
            <div id="step1-config" class="step-content">
                <!-- Modal Header -->
                <div class="sticky top-0 bg-blue-500 px-6 py-4 flex items-center justify-between rounded-t-xl">
                    <h3 class="text-lg md:text-xl font-bold text-white">Add Floating IP</h3>
                    <button onclick="closeFloatingIPModal()" class="text-white hover:text-gray-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Pricing Info -->
                <div class="px-6 py-4 bg-blue-50 dark:bg-blue-900/20 border-b border-gray-200 dark:border-gray-700">
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-semibold text-gray-900 dark:text-white">IPv4:</span>
                            <span class="text-gray-700 dark:text-gray-300">$5.00/month (excl. VAT)</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-semibold text-gray-900 dark:text-white">IPv6:</span>
                            <span class="text-gray-700 dark:text-gray-300">$3.00/month (excl. VAT)</span>
                        </div>
                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-2">
                            <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">Our terms and conditions apply.</a>
                        </p>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-6">
                    <form id="floatingIPForm" class="space-y-6">
                        <!-- Protocol Selection -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-3">
                                Protocol <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="relative flex items-center p-4 border-2 border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-blue-500 dark:hover:border-blue-400 transition-colors">
                                    <input type="radio" name="protocol" value="ipv4" checked class="w-4 h-4 text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-400" onchange="updateFloatingIPPrice()">
                                    <div class="ml-3">
                                        <span class="block text-sm font-semibold text-gray-900 dark:text-white">IPv4</span>
                                        <span class="block text-xs text-gray-500 dark:text-gray-400">$5.00/month</span>
                                    </div>
                                </label>
                                <label class="relative flex items-center p-4 border-2 border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-blue-500 dark:hover:border-blue-400 transition-colors">
                                    <input type="radio" name="protocol" value="ipv6" class="w-4 h-4 text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-400" onchange="updateFloatingIPPrice()">
                                    <div class="ml-3">
                                        <span class="block text-sm font-semibold text-gray-900 dark:text-white">IPv6</span>
                                        <span class="block text-xs text-gray-500 dark:text-gray-400">$3.00/month</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Location Selection -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-3">
                                Location <span class="text-red-500">*</span>
                            </label>
                            <div class="space-y-2" id="locationOptions">
                                <!-- Locations will be loaded dynamically -->
                                <div class="text-center py-4">
                                    <svg class="animate-spin h-5 w-5 mx-auto text-blue-600" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span class="text-sm text-gray-500 mt-2 block">Loading locations...</span>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-gray-600 dark:text-gray-400 flex items-start gap-1">
                                <svg class="w-4 h-4 text-blue-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <span>Only servers from the same network zone can be assigned to a Floating IP</span>
                            </p>
                        </div>

                        <!-- Name Field -->
                        <div>
                            <label for="floatingIPName" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                                Name <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="floatingIPName" 
                                name="name" 
                                required
                                placeholder="Enter a name for the Floating IP"
                                class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                            >
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <button 
                                type="button" 
                                onclick="closeFloatingIPModal()"
                                class="px-4 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors"
                            >
                                Cancel
                            </button>
                            <button 
                                type="button"
                                onclick="proceedToPayment()"
                                class="px-6 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors flex items-center gap-2"
                            >
                                <span>Continue to Payment</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Step 2: Payment Method Selection -->
            <div id="step2-payment" class="step-content hidden">
                <!-- Modal Header -->
                <div class="sticky top-0 bg-blue-500 px-6 py-4 flex items-center justify-between rounded-t-xl">
                    <div class="flex items-center gap-3">
                        <button onclick="backToConfig()" class="text-white hover:text-gray-200 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <h3 class="text-lg md:text-xl font-bold text-white">Payment Method</h3>
                    </div>
                    <button onclick="closeFloatingIPModal()" class="text-white hover:text-gray-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Order Summary -->
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700">
                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Order Summary</h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Floating IP (<span id="summary-protocol">IPv4</span>)</span>
                            <span class="font-semibold text-gray-900 dark:text-white" id="summary-price">$5.00/mo</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Billing Cycle</span>
                            <span class="font-semibold text-gray-900 dark:text-white" id="summary-cycle">{{ ucfirst(str_replace('_', ' ', $service->billing_cycle ?? 'monthly')) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Location</span>
                            <span class="font-semibold text-gray-900 dark:text-white" id="summary-location">-</span>
                        </div>
                        <div class="pt-2 border-t border-gray-300 dark:border-gray-600 flex justify-between items-center">
                            <span class="font-bold text-lg text-gray-900 dark:text-white">Total Amount</span>
                            <span class="font-bold text-xl text-blue-600 dark:text-blue-400" id="summary-total">$5.00</span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 pt-1">
                            <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            This amount covers the full billing cycle period
                        </p>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="px-6 py-6">
                    <form id="paymentForm" class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-3">
                                Select Payment Method <span class="text-red-500">*</span>
                            </label>
                            <div class="space-y-3">
                                <!-- Wallet Balance -->
                                <label class="relative flex items-center p-4 border-2 border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-blue-500 dark:hover:border-blue-400 transition-colors">
                                    <input type="radio" name="payment_method" value="wallet" checked class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                                    <div class="ml-3 flex-1">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                                    <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                                                </svg>
                                                <span class="block text-sm font-semibold text-gray-900 dark:text-white">Wallet Balance</span>
                                            </div>
                                            <span class="text-sm font-bold text-green-600">{{ number_format($client->wallet_balance ?? 0, 2) }} USD</span>
                                        </div>
                                        <span class="block text-xs text-gray-500 dark:text-gray-400 mt-1">Pay using your wallet balance</span>
                                    </div>
                                </label>

                                <!-- Credit/Debit Card -->
                                <label class="relative flex items-center p-4 border-2 border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-blue-500 dark:hover:border-blue-400 transition-colors">
                                    <input type="radio" name="payment_method" value="card" class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                                    <div class="ml-3 flex-1">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                                <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                                            </svg>
                                            <span class="block text-sm font-semibold text-gray-900 dark:text-white">Credit / Debit Card</span>
                                        </div>
                                        <span class="block text-xs text-gray-500 dark:text-gray-400 mt-1">Visa, Mastercard, Amex</span>
                                    </div>
                                </label>

                                <!-- Fawry -->
                                <label class="relative flex items-center p-4 border-2 border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-blue-500 dark:hover:border-blue-400 transition-colors">
                                    <input type="radio" name="payment_method" value="fawry" class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                                    <div class="ml-3 flex-1">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span class="block text-sm font-semibold text-gray-900 dark:text-white">Fawry</span>
                                        </div>
                                        <span class="block text-xs text-gray-500 dark:text-gray-400 mt-1">Pay at Fawry locations</span>
                                    </div>
                                </label>

                                <!-- Mobile Wallet -->
                                <label class="relative flex items-center p-4 border-2 border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-blue-500 dark:hover:border-blue-400 transition-colors">
                                    <input type="radio" name="payment_method" value="mobile_wallet" class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                                    <div class="ml-3 flex-1">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                            </svg>
                                            <span class="block text-sm font-semibold text-gray-900 dark:text-white">Mobile Wallet</span>
                                        </div>
                                        <span class="block text-xs text-gray-500 dark:text-gray-400 mt-1">Vodafone Cash, Orange Cash, Etisalat Cash</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                            <button 
                                type="button" 
                                onclick="backToConfig()"
                                class="px-4 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors flex items-center gap-2"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                                <span>Back</span>
                            </button>
                            <button 
                                type="submit"
                                class="px-6 py-2.5 text-sm font-semibold text-white bg-green-600 hover:bg-green-700 rounded-lg transition-colors flex items-center gap-2"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>Complete Payment</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Floating IP Modal -->

    <!-- Snapshots Tab Content -->
    <div id="content-snapshots" class="tab-content hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg md:rounded-xl border md:border-2 border-gray-200 dark:border-gray-700 p-4 md:p-6 mb-4 md:mb-6">
            <div class="flex items-start gap-3 md:gap-4 mb-4 md:mb-6">
                <div class="p-2 md:p-3 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg shrink-0">
                    <svg class="w-6 h-6 md:w-8 md:h-8 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <h2 class="text-base md:text-xl font-bold text-gray-900 dark:text-white mb-2">Server Snapshots</h2>
                    <p class="text-gray-600 dark:text-gray-400 text-xs md:text-sm leading-relaxed">Instant copies of your server's disks</p>
                </div>
            </div>

            <div class="bg-indigo-50 dark:bg-indigo-900/20 border md:border-2 border-indigo-200 dark:border-indigo-700 rounded-lg md:rounded-xl p-4 md:p-6 mb-4 md:mb-6">
                <div class="flex items-start gap-2 md:gap-3 mb-3 md:mb-4">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-indigo-600 dark:text-indigo-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="min-w-0">
                        <h3 class="font-bold text-gray-900 dark:text-white mb-2 md:mb-3 text-sm md:text-base">About Snapshots</h3>
                        <div class="space-y-2 text-xs md:text-sm text-gray-700 dark:text-gray-300">
                            <p><strong>Snapshots are instant copies of your server's disks.</strong></p>
                            <p>We recommend that you <strong>power off your server</strong> before taking a snapshot to ensure data consistency.</p>
                            <p class="text-indigo-700 dark:text-indigo-300 font-semibold">Snapshots cost <strong>$0.05/GB/month</strong> (incl. 0% VAT).</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Snapshots List -->
            <div id="snapshots-list-container">
                <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-12 border-2 border-dashed border-gray-300 dark:border-gray-600 text-center">
                    <svg class="w-20 h-20 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <h3 class="text-base md:text-lg font-semibold text-gray-900 dark:text-white mb-2">No Snapshots Yet</h3>
                    <p class="text-xs md:text-sm text-gray-600 dark:text-gray-400 mb-4 md:mb-6">You currently don't have any snapshots for this server.</p>
                    <button onclick="createSnapshot()" class="w-full sm:w-auto px-4 sm:px-8 py-2.5 sm:py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white text-sm font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center gap-2 mx-auto">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>Take Snapshot</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Snapshots Tab -->
    @endif

    <!-- Error/Pending State -->
    @if($service->status === 'failed')
    <!-- Error Alert -->
    <div class="bg-red-50 dark:bg-red-900/20 border md:border-2 border-red-200 dark:border-red-800 rounded-lg md:rounded-xl p-4 md:p-6 mb-4 md:mb-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-red-900 dark:text-red-200 mb-2">{{ __('frontend.service_activation_failed') }}</h3>
                @if($serverData && isset($serverData['error']))
                    <p class="text-sm text-red-700 dark:text-red-300 mb-3">{{ $serverData['error'] }}</p>
                @endif
                <p class="text-sm text-red-600 dark:text-red-400">{{ __('frontend.contact_support_for_help') }}</p>
            </div>
        </div>
    </div>
    @elseif($service->status === 'pending')
    <!-- Pending Alert -->
    <div class="bg-yellow-50 dark:bg-yellow-900/20 border md:border-2 border-yellow-200 dark:border-yellow-800 rounded-lg md:rounded-xl p-4 md:p-6 mb-4 md:mb-6">
        <div class="flex items-center gap-3">
            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            <div>
                <h3 class="text-lg font-semibold text-yellow-900 dark:text-yellow-200 mb-1">{{ __('frontend.vps_being_provisioned') }}</h3>
                <p class="text-sm text-yellow-700 dark:text-yellow-300">{{ __('frontend.please_wait') }}</p>
            </div>
        </div>
    </div>
    @endif

</div>

<script>
// Version: 1.1.0
const serviceId = {{ $service->id }};
const actualPassword = @json($serverData['root_password'] ?? '');
let passwordVisible = false;

// Load server resources on page load
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Lottie animations for loaders
    const lottieAnimations = ['cpu', 'network', 'disk', 'bandwidth'];
    lottieAnimations.forEach(type => {
        const container = document.getElementById(`${type}-lottie`);
        if (container) {
            lottie.loadAnimation({
                container: container,
                renderer: 'svg',
                loop: true,
                autoplay: true,
                path: '/assets/images/Data%20visualization%20%237.json'
            });
        }
    });
    
    loadServerResources();
    loadServerLocation();
    loadServerActivities();
    
    // Restore last active tab from localStorage
    const savedTab = localStorage.getItem('vps_active_tab') || 'overview';
    switchTab(savedTab);
    
    // Clean up interval when page is unloaded
    window.addEventListener('beforeunload', function() {
        if (graphsRefreshInterval) {
            clearInterval(graphsRefreshInterval);
        }
    });
});

// Tab switching function
function switchTab(tab) {
    // Save selected tab to localStorage
    localStorage.setItem('vps_active_tab', tab);
    
    // Remove active class from all tabs
    document.querySelectorAll('.tab-button').forEach(btn => {
        btn.classList.remove('active', 'border-blue-500', 'text-blue-600', 'dark:border-blue-400', 'dark:text-blue-400');
        btn.classList.add('border-transparent', 'text-gray-600', 'dark:text-gray-400');
    });
    
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Show selected tab
    const selectedTab = document.getElementById(`tab-${tab}`);
    const selectedContent = document.getElementById(`content-${tab}`);
    
    selectedTab.classList.add('active', 'border-blue-500', 'text-blue-600', 'dark:border-blue-400', 'dark:text-blue-400');
    selectedTab.classList.remove('border-transparent', 'text-gray-600', 'dark:text-gray-400');
    selectedContent.classList.remove('hidden');
    
    // Load graphs when switching to graphs tab and start auto-refresh
    if (tab === 'graphs') {
        loadServerGraphs();
        // Start auto-refresh every 5 seconds
        if (graphsRefreshInterval) {
            clearInterval(graphsRefreshInterval);
        }
        graphsRefreshInterval = setInterval(loadServerGraphs, 5000);
    } else if (tab === 'backups') {
        // Load backups when switching to backups tab
        loadBackupStatus();
    } else if (tab === 'iso') {
        // Load ISO images when switching to ISO tab
        loadISOImages();
    } else if (tab === 'snapshots') {
        // Load snapshots when switching to snapshots tab
        loadSnapshots();
    } else if (tab === 'network') {
        // Load network information when switching to network tab
        loadNetworkInfo();
    } else {
        // Stop auto-refresh when leaving graphs tab
        if (graphsRefreshInterval) {
            clearInterval(graphsRefreshInterval);
            graphsRefreshInterval = null;
        }
    }
}

// Load server resources from API
async function loadServerResources() {
    try {
        const response = await fetch(`/services/vps/${serviceId}/resources`);
        const data = await response.json();
        
        if (data.success && data.resources) {
            const res = data.resources;
            document.getElementById('server-cpu').textContent = res.cores || '--';
            document.getElementById('server-ram').textContent = res.memory || '--';
            document.getElementById('server-disk').textContent = res.disk || '--';
            document.getElementById('server-traffic').textContent = res.traffic_used || '0';
            document.getElementById('server-traffic-limit').textContent = res.traffic_limit || '--';
        }
    } catch (error) {
        console.error('Failed to load server resources:', error);
    }
}

// Load server location from API
async function loadServerLocation() {
    try {
        const response = await fetch(`/services/vps/${serviceId}/resources`);
        const data = await response.json();
        
        if (data.success && data.location) {
            const loc = data.location;
            
            // Update location details in cards
            document.getElementById('loc-datacenter').textContent = loc.name || '--';
            document.getElementById('loc-city').textContent = loc.city || '--';
            document.getElementById('loc-country').textContent = loc.country || '--';
        }
    } catch (error) {
        console.error('Failed to load server location:', error);
    }
}

// Load server activities from API
async function loadServerActivities() {
    try {
        const response = await fetch(`/services/vps/${serviceId}/activities`);
        const data = await response.json();
        
        const activitiesList = document.getElementById('activities-list');
        
        if (data.success && data.activities && data.activities.length > 0) {
            activitiesList.innerHTML = data.activities.map(activity => {
                const statusColors = {
                    'success': 'bg-green-100 text-green-800 border-green-200',
                    'running': 'bg-blue-100 text-blue-800 border-blue-200',
                    'error': 'bg-red-100 text-red-800 border-red-200'
                };
                const statusColor = statusColors[activity.status] || 'bg-gray-100 text-gray-800 border-gray-200';
                
                const commandNames = {
                    'start_server': '{{ __('frontend.start_server') }}',
                    'stop_server': '{{ __('frontend.stop_server') }}',
                    'reboot_server': '{{ __('frontend.reboot_server') }}',
                    'shutdown_server': '{{ __('frontend.shutdown_server') }}',
                    'reset_server': '{{ __('frontend.reset_server') }}',
                    'create_server': '{{ __('frontend.create_server') }}',
                    'delete_server': '{{ __('frontend.delete_server') }}',
                    'create_image': '{{ __('frontend.create_image') }}',
                    'request_console': '{{ __('frontend.request_console') }}',
                    'attach_iso': '{{ __('frontend.attach_iso') }}',
                    'detach_iso': '{{ __('frontend.detach_iso') }}',
                    'change_type': '{{ __('frontend.change_type') }}',
                    'rebuild_server': '{{ __('frontend.rebuild_server') }}'
                };
                
                // If command not found in translations, format it nicely
                let commandName = commandNames[activity.command];
                if (!commandName) {
                    // Replace underscores with spaces and capitalize each word
                    commandName = activity.command.split('_').map(word => 
                        word.charAt(0).toUpperCase() + word.slice(1)
                    ).join(' ');
                }
                
                // Translate status
                const statusNames = {
                    'success': '{{ __('frontend.success') }}',
                    'running': '{{ __('frontend.running') }}',
                    'error': '{{ __('frontend.error') }}'
                };
                const statusName = statusNames[activity.status] || activity.status;
                
                const date = new Date(activity.started);
                const formattedDate = date.toLocaleString('{{ app()->getLocale() }}', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
                
                return `
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                        <div class="flex items-center gap-3 flex-1">
                            <div class="p-2 bg-purple-500 rounded-lg">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="font-semibold text-gray-900 dark:text-gray-100">${commandName}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">${formattedDate}</div>
                            </div>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold border ${statusColor}">
                            ${statusName}
                        </span>
                    </div>
                `;
            }).join('');
        } else {
            activitiesList.innerHTML = `
                <div class="text-center py-8 text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p>{{ __('frontend.no_activities') }}</p>
                </div>
            `;
        }
    } catch (error) {
        console.error('Failed to load server activities:', error);
        document.getElementById('activities-list').innerHTML = `
            <div class="text-center py-8 text-red-500">
                <p>{{ __('frontend.failed_to_load') }}</p>
            </div>
        `;
    }
}

// Password functions
function togglePassword() {
    const field = document.getElementById('password-field');
    passwordVisible = !passwordVisible;
    field.textContent = passwordVisible ? actualPassword : '••••••••••••';
}

function copyPassword() {
    navigator.clipboard.writeText(actualPassword);
    showNotification('{{ __('frontend.password_copied') }}', 'success');
}

// Server control actions
async function executeAction(action) {
    if (!confirm('{{ __('frontend.confirm_action') }}')) return;
    
    // Disable all buttons immediately
    updateControlButtons('starting');
    
    showNotification('{{ __('frontend.executing_action') }}', 'info');
    
    try {
        const response = await fetch(`/services/vps/${serviceId}/action`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ action })
        });
        
        const data = await response.json();
        
        if (data.success) {
            showNotification(data.message || '{{ __('frontend.action_success') }}', 'success');
            // Check status immediately and continue checking
            setTimeout(() => {
                checkStatus();
                // Keep checking status every 5 seconds until action completes
                const statusCheckInterval = setInterval(() => {
                    checkStatus();
                }, 5000);
                // Stop checking after 2 minutes
                setTimeout(() => clearInterval(statusCheckInterval), 120000);
            }, 2000);
        } else {
            showNotification(data.error || '{{ __('frontend.action_failed') }}', 'error');
            // Re-enable buttons on error
            checkStatus();
        }
    } catch (error) {
        showNotification('{{ __('frontend.network_error') }}', 'error');
        // Re-enable buttons on error
        checkStatus();
    }
}

// Chart instances
let charts = {
    cpu: null,
    network: null,
    disk: null,
    bandwidth: null,
    throughput: null
};

// Auto-refresh interval
let graphsRefreshInterval = null;

// Load server graphs from Hetzner API
async function loadServerGraphs() {
    try {
        const response = await fetch(`/services/vps/${serviceId}/graphs`);
        const data = await response.json();
        
        console.log('Graphs API Response:', data);
        
        if (data.success && data.graphs) {
            // CPU Graph
            if (data.graphs.cpu && data.graphs.cpu.data && data.graphs.cpu.data.length > 0) {
                updateChart('cpu-chart', data.graphs.cpu, 'CPU Usage (%)', 'rgba(147, 51, 234, 0.8)', 'rgba(99, 102, 241, 0.8)');
            }
            
            // Network Graph
            if (data.graphs.network && data.graphs.network.data && data.graphs.network.data.length > 0) {
                updateChart('network-chart', data.graphs.network, 'Network Traffic (MB/s)', 'rgba(59, 130, 246, 0.8)', 'rgba(6, 182, 212, 0.8)');
            }
            
            // Disk Graph
            if (data.graphs.disk && data.graphs.disk.data && data.graphs.disk.data.length > 0) {
                updateChart('disk-chart', data.graphs.disk, 'Disk IOPS', 'rgba(34, 197, 94, 0.8)', 'rgba(16, 185, 129, 0.8)');
            }
            
            // Bandwidth Graph
            if (data.graphs.bandwidth && data.graphs.bandwidth.data && data.graphs.bandwidth.data.length > 0) {
                updateChart('bandwidth-chart', data.graphs.bandwidth, 'Network Bandwidth (Mbps)', 'rgba(249, 115, 22, 0.8)', 'rgba(239, 68, 68, 0.8)');
            }
            
            // Disk Throughput Graph
            if (data.graphs.throughput && data.graphs.throughput.data && data.graphs.throughput.data.length > 0) {
                updateChart('throughput-chart', data.graphs.throughput, 'Disk Throughput (MB/s)', 'rgba(234, 179, 8, 0.8)', 'rgba(217, 119, 6, 0.8)');
            }
        } else {
            console.error('Graphs API Error:', data);
        }
    } catch (error) {
        console.error('Failed to load graphs:', error);
    }
}

// Update chart with new data (with animation)
function updateChart(canvasId, graphData, label, color1, color2) {
    const chartKey = canvasId.replace('-chart', '');
    const data = graphData.data || [];
    
    // Hide loader
    const loader = document.getElementById(`${chartKey}-loader`);
    if (loader) {
        loader.style.display = 'none';
    }
    
    // If chart exists, update it
    if (charts[chartKey]) {
        const newLabels = data.map(point => {
            const date = new Date(point.timestamp * 1000);
            return date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
        });
        const newValues = data.map(point => point.value);
        
        // Update chart data with animation
        charts[chartKey].data.labels = newLabels;
        charts[chartKey].data.datasets[0].data = newValues;
        charts[chartKey].update('active'); // Smooth animation
    } else {
        // Create new chart if doesn't exist
        displayChart(canvasId, graphData, label, color1, color2);
    }
}

// Display interactive chart using Chart.js
function displayChart(canvasId, graphData, label, color1, color2) {
    const canvas = document.getElementById(canvasId);
    const ctx = canvas.getContext('2d');
    
    // Hide loader
    const chartKey = canvasId.replace('-chart', '');
    const loader = document.getElementById(`${chartKey}-loader`);
    if (loader) {
        loader.style.display = 'none';
    }
    
    // Destroy existing chart if exists
    if (charts[chartKey]) {
        charts[chartKey].destroy();
    }
    
    // Prepare data
    const data = graphData.data || [];
    const labels = data.map(point => {
        const date = new Date(point.timestamp * 1000);
        return date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
    });
    const values = data.map(point => point.value);
    
    // Create gradient
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, color1);
    gradient.addColorStop(1, color2);
    
    // Create chart
    charts[chartKey] = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: label,
                data: values,
                borderColor: color1,
                backgroundColor: gradient,
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointHoverRadius: 6,
                pointBackgroundColor: color1,
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 2000,
                easing: 'easeInOutQuart'
            },
            interaction: {
                intersect: false,
                mode: 'index'
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        color: document.documentElement.classList.contains('dark') ? '#fff' : '#374151',
                        font: {
                            size: 12,
                            weight: 'bold'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: color1,
                    borderWidth: 1,
                    padding: 12,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return label + ': ' + context.parsed.y.toFixed(2);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: document.documentElement.classList.contains('dark') ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        color: document.documentElement.classList.contains('dark') ? '#9ca3af' : '#6b7280'
                    }
                },
                x: {
                    grid: {
                        color: document.documentElement.classList.contains('dark') ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        color: document.documentElement.classList.contains('dark') ? '#9ca3af' : '#6b7280',
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            }
        }
    });
}

// Show no data message
function showNoData(containerId) {
    const container = document.getElementById(containerId);
    container.innerHTML = `
        <div class="text-center text-gray-600 dark:text-gray-400 py-8">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            <p class="text-sm">{{ __('frontend.no_data_available') }}</p>
            <p class="text-xs text-gray-500 mt-2">Metrics will be available after the server runs for a while</p>
        </div>
    `;
}

// Show error message
function showError(containerId, message) {
    const container = document.getElementById(containerId);
    container.innerHTML = `
        <div class="text-center text-gray-600 dark:text-gray-400 py-8">
            <svg class="w-16 h-16 mx-auto mb-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm text-red-600 dark:text-red-400">${message}</p>
        </div>
    `;
}

// Load Backup Status
async function loadBackupStatus() {
    const statusContainer = document.getElementById('backup-status-container');
    const listContainer = document.getElementById('backups-list-container');
    
    try {
        const response = await fetch(`/services/vps/${serviceId}/backup-status`);
        const data = await response.json();
        
        if (data.success) {
            const isEnabled = data.backup_enabled || false;
            const backups = data.backups || [];
            const hasPending = data.has_pending_backup || false;
            
            // Update status container
            statusContainer.innerHTML = `
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h3 class="font-bold text-gray-900 dark:text-white mb-2">Backup Status</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Backups are currently 
                            <span class="font-semibold ${isEnabled ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'}">
                                ${isEnabled ? 'enabled' : 'disabled'}
                            </span> 
                            for this server
                        </p>
                        ${isEnabled ? `<p class="text-xs text-gray-500 dark:text-gray-400 mt-1">${backups.length} / 7 backup slots used</p>` : ''}
                    </div>
                    ${!isEnabled ? `
                        <button onclick="enableBackups()" class="w-full sm:w-auto px-4 sm:px-6 py-2.5 sm:py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-sm font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="whitespace-nowrap">Enable Backups</span>
                        </button>
                    ` : `
                        <button onclick="createBackup()" class="w-full sm:w-auto px-4 sm:px-6 py-2.5 sm:py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white text-sm font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span class="whitespace-nowrap">Create Backup</span>
                        </button>
                    `}
                </div>
            `;
            
            // Display backups list if enabled
            if (hasPending) {
                // Show pending backup creation message
                listContainer.classList.remove('hidden');
                listContainer.innerHTML = `
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl p-12 border-2 border-blue-200 dark:border-blue-800 text-center relative overflow-hidden">
                        <!-- Background decoration -->
                        <div class="absolute inset-0 opacity-10">
                            <div class="absolute top-0 left-0 w-40 h-40 bg-blue-400 rounded-full filter blur-3xl"></div>
                            <div class="absolute bottom-0 right-0 w-40 h-40 bg-indigo-400 rounded-full filter blur-3xl"></div>
                        </div>
                        
                        <!-- Loading animation -->
                        <div class="relative mb-6">
                            <div class="flex justify-center items-center">
                                <div class="relative">
                                    <!-- Outer rotating ring -->
                                    <div class="w-24 h-24 rounded-full border-4 border-blue-200 dark:border-blue-800"></div>
                                    <div class="absolute top-0 left-0 w-24 h-24 rounded-full border-4 border-transparent border-t-blue-600 dark:border-t-blue-400 animate-spin"></div>
                                    
                                    <!-- Middle rotating ring -->
                                    <div class="absolute top-2 left-2 w-20 h-20 rounded-full border-4 border-indigo-200 dark:border-indigo-800"></div>
                                    <div class="absolute top-2 left-2 w-20 h-20 rounded-full border-4 border-transparent border-t-indigo-600 dark:border-t-indigo-400 animate-spin" style="animation-duration: 1.5s; animation-direction: reverse;"></div>
                                    
                                    <!-- Inner pulsing icon -->
                                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                                        <svg class="w-10 h-10 text-blue-600 dark:text-blue-400 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Text content -->
                        <div class="relative">
                            <h3 class="text-lg md:text-2xl font-bold text-gray-900 dark:text-white mb-3 flex items-center justify-center gap-2">
                                <span>Creating Backup</span>
                                <span class="inline-flex gap-1">
                                    <span class="animate-bounce" style="animation-delay: 0ms;">.</span>
                                    <span class="animate-bounce" style="animation-delay: 150ms;">.</span>
                                    <span class="animate-bounce" style="animation-delay: 300ms;">.</span>
                                </span>
                            </h3>
                            <p class="text-sm md:text-base text-gray-600 dark:text-gray-400 mb-3 md:mb-4">Please wait while your backup is being created.</p>
                            <p class="text-xs md:text-sm text-gray-500 dark:text-gray-500">This process may take a few minutes depending on your server size.</p>
                            
                            <!-- Progress indicator -->
                            <div class="mt-6 max-w-xs mx-auto">
                                <div class="h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-600 rounded-full animate-pulse" style="width: 100%; animation-duration: 2s;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                // Auto-refresh to check if backup is ready
                setTimeout(loadBackupStatus, 10000); // Check again in 10 seconds
            } else if (isEnabled && backups.length > 0) {
                listContainer.classList.remove('hidden');
                listContainer.innerHTML = `
                    <div class="bg-white dark:bg-gray-800 rounded-lg md:rounded-xl border md:border-2 border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="px-3 md:px-6 py-3 md:py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-sm md:text-base font-bold text-gray-900 dark:text-white">Available Backups</h3>
                        </div>
                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            ${backups.map(backup => `
                                <div class="px-3 md:px-6 py-3 md:py-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2 md:gap-3 mb-2">
                                                <svg class="w-4 h-4 md:w-5 md:h-5 text-blue-600 dark:text-blue-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                                </svg>
                                                <h4 class="text-sm md:text-base font-semibold text-gray-900 dark:text-white truncate">${backup.description || 'Backup #' + backup.id}</h4>
                                            </div>
                                            <div class="flex flex-wrap items-center gap-2 md:gap-4 text-xs md:text-sm text-gray-600 dark:text-gray-400">
                                                <span class="flex items-center gap-1">
                                                    <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    ${new Date(backup.created).toLocaleString()}
                                                </span>
                                                <span class="flex items-center gap-1">
                                                    <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                                                    </svg>
                                                    ${(backup.image_size || 0).toFixed(2)} GB
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 shrink-0">
                                            <button onclick="restoreBackup(${backup.id})" class="px-3 md:px-4 py-1.5 md:py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs md:text-sm font-semibold rounded-lg transition-colors whitespace-nowrap">
                                                Restore
                                            </button>
                                            <button onclick="deleteBackup(${backup.id})" class="px-3 md:px-4 py-1.5 md:py-2 bg-red-600 hover:bg-red-700 text-white text-xs md:text-sm font-semibold rounded-lg transition-colors whitespace-nowrap">
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `;
            } else if (isEnabled) {
                listContainer.classList.remove('hidden');
                listContainer.innerHTML = `
                    <div class="bg-gray-50 dark:bg-gray-900/50 rounded-lg md:rounded-xl p-6 md:p-8 border md:border-2 border-dashed border-gray-300 dark:border-gray-600 text-center">
                        <svg class="w-12 h-12 md:w-16 md:h-16 mx-auto mb-3 md:mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                        <h3 class="text-base md:text-lg font-semibold text-gray-900 dark:text-white mb-2">No Backups Yet</h3>
                        <p class="text-xs md:text-sm text-gray-600 dark:text-gray-400 mb-3 md:mb-4">Create your first backup to protect your server data</p>
                        <button onclick="createBackup()" class="w-full sm:w-auto px-4 sm:px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-colors">
                            Create First Backup
                        </button>
                    </div>
                `;
            } else {
                listContainer.classList.add('hidden');
            }
        } else {
            statusContainer.innerHTML = `
                <div class="text-center py-4 text-red-600 dark:text-red-400">
                    <p>Failed to load backup status</p>
                </div>
            `;
        }
    } catch (error) {
        console.error('Error loading backup status:', error);
        statusContainer.innerHTML = `
            <div class="text-center py-4 text-red-600 dark:text-red-400">
                <p>Error loading backup status</p>
            </div>
        `;
    }
}

// Enable Backups
function enableBackups() {
    if (!confirm('Are you sure you want to enable backups? This will cost 20% of your server plan per month. An invoice will be created for payment.')) {
        return;
    }
    
    // Show loading state
    const button = event.target.closest('button');
    const originalContent = button.innerHTML;
    button.disabled = true;
    button.innerHTML = `
        <svg class="animate-spin h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    `;
    
    fetch('/services/vps/{{ $service->id }}/enable-backups', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            alert('Invoice created successfully! You will be redirected to the payment page.');
            
            // Redirect to invoice page
            window.location.href = data.redirect_url;
        } else {
            alert('Error: ' + (data.error || 'Failed to create invoice'));
            button.disabled = false;
            button.innerHTML = originalContent;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
        button.disabled = false;
        button.innerHTML = originalContent;
    });
}

// Create Backup// Create Backup
async function createBackup() {
    if (!confirm('Are you sure you want to create a backup? We recommend powering off the server first.')) {
        return;
    }
    
    try {
        const response = await fetch(`/services/vps/${serviceId}/create-backup`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert('Backup creation started successfully!');
            loadBackupStatus();
        } else {
            alert('Failed to create backup: ' + (data.message || 'Unknown error'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while creating backup');
    }
}

// Restore Backup
async function restoreBackup(backupId) {
    if (!confirm('WARNING: Restoring a backup will overwrite all current data on the server. This action cannot be undone. Are you sure?')) {
        return;
    }
    
    try {
        const response = await fetch(`/services/vps/${serviceId}/restore-backup/${backupId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert('Backup restoration started successfully! The server will be rebooted.');
            setTimeout(() => location.reload(), 2000);
        } else {
            alert('Failed to restore backup: ' + (data.message || 'Unknown error'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while restoring backup');
    }
}

// Delete Backup
async function deleteBackup(backupId) {
    if (!confirm('Are you sure you want to delete this backup? This action cannot be undone.')) {
        return;
    }
    
    try {
        const response = await fetch(`/services/vps/${serviceId}/delete-backup/${backupId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert('Backup deleted successfully!');
            loadBackupStatus();
        } else {
            alert('Failed to delete backup: ' + (data.message || 'Unknown error'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while deleting backup');
    }
}

// Create snapshot
async function createSnapshot() {
    const description = prompt('{{ __('frontend.snapshot_description_prompt') }}');
    if (!description) return;
    
    showNotification('{{ __('frontend.creating_snapshot') }}', 'info');
    
    try {
        const response = await fetch(`/services/vps/${serviceId}/snapshot`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ description })
        });
        
        const data = await response.json();
        
        if (data.success) {
            showNotification('{{ __('frontend.snapshot_created') }}', 'success');
        } else {
            showNotification(data.error || '{{ __('frontend.snapshot_failed') }}', 'error');
        }
    } catch (error) {
        showNotification('{{ __('frontend.network_error') }}', 'error');
    }
}

// Check server status
async function checkStatus() {
    try {
        const response = await fetch(`/services/vps/${serviceId}/status`);
        const data = await response.json();
        
        const statusElement = document.getElementById('server-status');
        if (statusElement && data.status) {
            const statusMap = {
                'running': { text: '{{ __('frontend.running') }}', class: 'text-green-600' },
                'off': { text: '{{ __('frontend.stopped') }}', class: 'text-red-600' },
                'starting': { text: '{{ __('frontend.starting') }}', class: 'text-yellow-600' }
            };
            
            const status = statusMap[data.status] || { text: data.status, class: 'text-gray-600' };
            statusElement.textContent = status.text;
            statusElement.className = `text-sm font-semibold ${status.class}`;
            
            // Update button states based on server status
            updateControlButtons(data.status);
        }
    } catch (error) {
        console.error('Status check failed:', error);
    }
}

// Update control buttons based on server status
function updateControlButtons(status) {
    const btnRestart = document.getElementById('btn-restart');
    const btnStop = document.getElementById('btn-stop');
    const btnStart = document.getElementById('btn-start');
    const btnPowerOff = document.getElementById('btn-power-off');
    
    // Reset all buttons first
    [btnRestart, btnStop, btnStart, btnPowerOff].forEach(btn => {
        if (btn) btn.disabled = false;
    });
    
    if (status === 'off') {
        // Server is stopped - only Start button enabled
        if (btnRestart) btnRestart.disabled = true;
        if (btnStop) btnStop.disabled = true;
        if (btnPowerOff) btnPowerOff.disabled = true;
    } else if (status === 'running') {
        // Server is running - disable Start button
        if (btnStart) btnStart.disabled = true;
    } else if (status === 'starting') {
        // Server is starting/restarting - disable all buttons
        if (btnRestart) btnRestart.disabled = true;
        if (btnStop) btnStop.disabled = true;
        if (btnStart) btnStart.disabled = true;
        if (btnPowerOff) btnPowerOff.disabled = true;
    }
}

// Notification helper
function showNotification(message, type = 'info') {
    const colors = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        info: 'bg-blue-500'
    };
    
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 ${colors[type]} text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in`;
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.add('animate-fade-out');
        setTimeout(() => notification.remove(), 500);
    }, 3000);
}

// Create Snapshot
async function createSnapshot() {
    const description = prompt('Enter a description for this snapshot (optional):');
    
    if (description === null) {
        return; // User cancelled
    }
    
    if (!confirm('Are you sure you want to create a snapshot? We recommend powering off the server first to ensure data consistency.')) {
        return;
    }
    
    try {
        const response = await fetch(`/services/vps/${serviceId}/create-snapshot`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                description: description || undefined
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert('Snapshot creation started successfully! This may take a few minutes.');
            loadSnapshots();
        } else {
            // Check if it's insufficient balance error
            if (data.insufficient_balance) {
                const currentBalance = parseFloat(data.current_balance || 0).toFixed(2);
                const requiredBalance = parseFloat(data.required_balance || 15).toFixed(2);
                const message = `{{ __('frontend.insufficient_balance_for_snapshot') ?? 'Insufficient wallet balance' }}\n\n` +
                               `{{ __('frontend.current_balance') ?? 'Current Balance' }}: $${currentBalance}\n` +
                               `{{ __('frontend.required_balance') ?? 'Required Balance' }}: $${requiredBalance}\n\n` +
                               `{{ __('frontend.please_add_funds') ?? 'Please add funds to your wallet' }}`;
                alert(message);
                
                // Optional: redirect to wallet page
                if (confirm(`{{ __('frontend.go_to_wallet') ?? 'Go to wallet page?' }}`)) {
                    window.location.href = '/client/wallet/add-funds';
                }
            } else {
                alert('Failed to create snapshot: ' + (data.error || 'Unknown error'));
            }
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while creating snapshot');
    }
}

// Load Snapshots
async function loadSnapshots() {
    const container = document.getElementById('snapshots-list-container');
    
    // Show loading state
    container.innerHTML = `
        <div class="flex items-center justify-center py-12">
            <div class="text-center">
                <div class="relative w-16 h-16 mx-auto mb-4">
                    <div class="absolute inset-0 border-4 border-indigo-200 dark:border-indigo-800 rounded-full"></div>
                    <div class="absolute inset-0 border-4 border-transparent border-t-indigo-600 rounded-full animate-spin"></div>
                </div>
                <p class="text-gray-600 dark:text-gray-400 font-semibold">Loading snapshots...</p>
            </div>
        </div>
    `;
    
    try {
        const response = await fetch(`/services/vps/${serviceId}/snapshots`);
        const data = await response.json();
        
        if (data.success) {
            const snapshots = data.snapshots || [];
            const hasPending = data.has_pending_snapshot || false;
            
            if (hasPending) {
                // Show pending snapshot creation message
                container.innerHTML = `
                    <div class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-xl p-12 border-2 border-indigo-200 dark:border-indigo-800 text-center relative overflow-hidden">
                        <!-- Background decoration -->
                        <div class="absolute inset-0 opacity-10">
                            <div class="absolute top-0 left-0 w-40 h-40 bg-indigo-400 rounded-full filter blur-3xl"></div>
                            <div class="absolute bottom-0 right-0 w-40 h-40 bg-purple-400 rounded-full filter blur-3xl"></div>
                        </div>
                        
                        <!-- Loading animation -->
                        <div class="relative mb-6">
                            <div class="flex justify-center items-center">
                                <div class="relative">
                                    <!-- Outer rotating ring -->
                                    <div class="w-24 h-24 rounded-full border-4 border-indigo-200 dark:border-indigo-800"></div>
                                    <div class="absolute top-0 left-0 w-24 h-24 rounded-full border-4 border-transparent border-t-indigo-600 dark:border-t-indigo-400 animate-spin"></div>
                                    
                                    <!-- Middle rotating ring -->
                                    <div class="absolute top-2 left-2 w-20 h-20 rounded-full border-4 border-purple-200 dark:border-purple-800"></div>
                                    <div class="absolute top-2 left-2 w-20 h-20 rounded-full border-4 border-transparent border-t-purple-600 dark:border-t-purple-400 animate-spin" style="animation-duration: 1.5s; animation-direction: reverse;"></div>
                                    
                                    <!-- Inner pulsing icon -->
                                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                                        <svg class="w-10 h-10 text-indigo-600 dark:text-indigo-400 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Text content -->
                        <div class="relative">
                            <h3 class="text-lg md:text-2xl font-bold text-gray-900 dark:text-white mb-3 flex items-center justify-center gap-2">
                                <span>Creating Snapshot</span>
                                <span class="inline-flex gap-1">
                                    <span class="animate-bounce" style="animation-delay: 0ms;">.</span>
                                    <span class="animate-bounce" style="animation-delay: 150ms;">.</span>
                                    <span class="animate-bounce" style="animation-delay: 300ms;">.</span>
                                </span>
                            </h3>
                            <p class="text-sm md:text-base text-gray-600 dark:text-gray-400 mb-3 md:mb-4">Please wait while your snapshot is being created.</p>
                            <p class="text-xs md:text-sm text-gray-500 dark:text-gray-500">This process may take several minutes depending on your server size.</p>
                            
                            <!-- Progress indicator -->
                            <div class="mt-4 md:mt-6 max-w-xs mx-auto">
                                <div class="h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-600 rounded-full animate-pulse" style="width: 100%; animation-duration: 2s;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                // Auto-refresh to check if snapshot is ready
                setTimeout(loadSnapshots, 10000); // Check again in 10 seconds
            } else if (snapshots.length > 0) {
                container.innerHTML = `
                    <div class="bg-white dark:bg-gray-800 rounded-lg md:rounded-xl border md:border-2 border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="px-3 md:px-6 py-3 md:py-4 border-b border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 sm:gap-0">
                            <h3 class="text-sm md:text-base font-bold text-gray-900 dark:text-white">Available Snapshots</h3>
                            <button onclick="createSnapshot()" class="w-full sm:w-auto px-3 md:px-4 py-1.5 md:py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs md:text-sm font-semibold rounded-lg transition-colors whitespace-nowrap">
                                + New Snapshot
                            </button>
                        </div>
                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            ${snapshots.map(snapshot => `
                                <div class="px-3 md:px-6 py-3 md:py-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2 md:gap-3 mb-2">
                                                <svg class="w-4 h-4 md:w-5 md:h-5 text-indigo-600 dark:text-indigo-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                <h4 class="text-sm md:text-base font-semibold text-gray-900 dark:text-white truncate">${snapshot.description || 'Snapshot #' + snapshot.id}</h4>
                                            </div>
                                            <div class="flex flex-wrap items-center gap-2 md:gap-4 text-xs md:text-sm text-gray-600 dark:text-gray-400">
                                                <span class="flex items-center gap-1">
                                                    <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    ${new Date(snapshot.created).toLocaleString()}
                                                </span>
                                                <span class="flex items-center gap-1">
                                                    <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                                                    </svg>
                                                    ${(snapshot.image_size || 0).toFixed(2)} GB
                                                </span>
                                                <span class="flex items-center gap-1 text-indigo-600 dark:text-indigo-400 font-semibold">
                                                    <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    $${((snapshot.image_size || 0) * 0.05).toFixed(2)}/mo
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 shrink-0">
                                            <button onclick="deleteSnapshot(${snapshot.id})" class="px-3 md:px-4 py-1.5 md:py-2 bg-red-600 hover:bg-red-700 text-white text-xs md:text-sm font-semibold rounded-lg transition-colors whitespace-nowrap">
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `;
            } else {
                container.innerHTML = `
                    <div class="bg-gray-50 dark:bg-gray-900/50 rounded-lg md:rounded-xl p-8 md:p-12 border md:border-2 border-dashed border-gray-300 dark:border-gray-600 text-center">
                        <svg class="w-16 h-16 md:w-20 md:h-20 mx-auto mb-3 md:mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <h3 class="text-base md:text-lg font-semibold text-gray-900 dark:text-white mb-2">No Snapshots Yet</h3>
                        <p class="text-xs md:text-sm text-gray-600 dark:text-gray-400 mb-4 md:mb-6">You currently don't have any snapshots for this server.</p>
                        <button onclick="createSnapshot()" class="w-full sm:w-auto px-4 sm:px-8 py-2.5 sm:py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white text-sm font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center gap-2 mx-auto">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>Take Snapshot</span>
                        </button>
                    </div>
                `;
            }
        } else {
            container.innerHTML = `
                <div class="text-center py-8 text-red-600 dark:text-red-400">
                    <p>Failed to load snapshots</p>
                </div>
            `;
        }
    } catch (error) {
        console.error('Error:', error);
        container.innerHTML = `
            <div class="text-center py-8 text-red-600 dark:text-red-400">
                <p>Error loading snapshots</p>
            </div>
        `;
    }
}

// Delete Snapshot
async function deleteSnapshot(snapshotId) {
    if (!confirm('Are you sure you want to delete this snapshot? This action cannot be undone.')) {
        return;
    }
    
    try {
        const response = await fetch(`/services/vps/${serviceId}/delete-snapshot/${snapshotId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert('Snapshot deleted successfully!');
            loadSnapshots();
        } else {
            alert('Failed to delete snapshot: ' + (data.error || 'Unknown error'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while deleting snapshot');
    }
}

// Load Network Information
async function loadNetworkInfo() {
    try {
        const response = await fetch(`/services/vps/${serviceId}/network`);
        const data = await response.json();
        
        if (data.success && data.network) {
            const networkTable = document.getElementById('network-table');
            networkTable.innerHTML = '';
            
            // IPv4
            if (data.network.ipv4) {
                const ipv4 = data.network.ipv4;
                networkTable.innerHTML += `
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-2 md:px-4 py-3">
                            <div class="flex items-center gap-1 md:gap-2">
                                <span class="font-mono text-xs md:text-sm font-semibold text-gray-900 dark:text-white break-all">${ipv4.ip}</span>
                                <button onclick="copyToClipboard('${ipv4.ip}')" class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 flex-shrink-0">
                                    <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td class="px-2 md:px-4 py-3">
                            <span class="px-1.5 md:px-2 py-0.5 md:py-1 text-[10px] md:text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400 whitespace-nowrap">
                                IPv4
                            </span>
                        </td>
                        <td class="px-2 md:px-4 py-3">
                            <div id="dns-ipv4-display" class="font-mono text-xs md:text-sm text-gray-700 dark:text-gray-300 break-all max-w-xs">
                                ${ipv4.dns_ptr || '<span class="text-gray-400">Not set</span>'}
                            </div>
                            <input type="text" id="dns-ipv4-input" class="hidden w-full px-2 py-1.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white font-mono text-xs" value="${ipv4.dns_ptr || ''}" />
                        </td>
                        <td class="px-2 md:px-4 py-3">
                            <button onclick="editReverseDNS('ipv4', '${ipv4.ip}')" id="edit-btn-ipv4" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-semibold text-xs md:text-sm whitespace-nowrap">
                                Edit
                            </button>
                            <div id="save-cancel-ipv4" class="hidden flex items-center gap-1 md:gap-2">
                                <button onclick="saveReverseDNS('ipv4', '${ipv4.ip}')" class="text-green-600 hover:text-green-800 dark:text-green-400 font-semibold text-xs md:text-sm whitespace-nowrap">
                                    Save
                                </button>
                                <button onclick="cancelEditDNS('ipv4')" class="text-gray-600 hover:text-gray-800 dark:text-gray-400 font-semibold text-xs md:text-sm whitespace-nowrap">
                                    Cancel
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            }
            
            // IPv6
            if (data.network.ipv6) {
                const ipv6 = data.network.ipv6;
                // Extract the base IPv6 address without /64 and add ::1
                const ipv6Base = ipv6.ip.replace('/64', '');
                const ipv6Address = ipv6Base.endsWith('::') ? ipv6Base + '1' : ipv6Base + '::1';
                const currentDns = Array.isArray(ipv6.dns_ptr) && ipv6.dns_ptr.length > 0 ? ipv6.dns_ptr[0] : '';
                
                networkTable.innerHTML += `
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-2 md:px-4 py-3">
                            <div class="flex items-center gap-1 md:gap-2">
                                <span class="font-mono text-xs md:text-sm font-semibold text-gray-900 dark:text-white break-all">${ipv6.ip}</span>
                                <button onclick="copyToClipboard('${ipv6Address}')" class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 flex-shrink-0">
                                    <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td class="px-2 md:px-4 py-3">
                            <span class="px-1.5 md:px-2 py-0.5 md:py-1 text-[10px] md:text-xs font-semibold rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400 whitespace-nowrap">
                                IPv6
                            </span>
                        </td>
                        <td class="px-2 md:px-4 py-3">
                            <div id="dns-ipv6-display" class="font-mono text-xs md:text-sm text-gray-700 dark:text-gray-300 break-all max-w-xs">
                                ${currentDns || '<span class="text-gray-400">Not set</span>'}
                            </div>
                            <input type="text" id="dns-ipv6-input" class="hidden w-full px-2 py-1.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white font-mono text-xs" value="${currentDns}" />
                        </td>
                        <td class="px-2 md:px-4 py-3">
                            <button onclick="editReverseDNS('ipv6', '${ipv6Address}')" id="edit-btn-ipv6" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-semibold text-xs md:text-sm whitespace-nowrap">
                                Edit
                            </button>
                            <div id="save-cancel-ipv6" class="hidden flex items-center gap-1 md:gap-2">
                                <button onclick="saveReverseDNS('ipv6', '${ipv6Address}')" class="text-green-600 hover:text-green-800 dark:text-green-400 font-semibold text-xs md:text-sm whitespace-nowrap">
                                    Save
                                </button>
                                <button onclick="cancelEditDNS('ipv6')" class="text-gray-600 hover:text-gray-800 dark:text-gray-400 font-semibold text-xs md:text-sm whitespace-nowrap">
                                    Cancel
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            }
            
            // Floating IPs
            if (data.network.floating_ips && data.network.floating_ips.length > 0) {
                data.network.floating_ips.forEach(floatingIp => {
                    const typeLabel = floatingIp.type.toUpperCase();
                    const typeColor = floatingIp.type === 'ipv4' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-400';
                    
                    networkTable.innerHTML += `
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 border-l-4 border-green-500">
                            <td class="px-2 md:px-4 py-3">
                                <div class="flex items-center gap-1 md:gap-2">
                                    <span class="font-mono text-xs md:text-sm font-semibold text-gray-900 dark:text-white break-all">${floatingIp.ip}</span>
                                    <button onclick="copyToClipboard('${floatingIp.ip}')" class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 flex-shrink-0">
                                        <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                    </button>
                                    <span class="px-2 py-0.5 text-[10px] font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                        Floating
                                    </span>
                                </div>
                                ${floatingIp.name ? `<div class="text-xs text-gray-500 dark:text-gray-400 mt-1">${floatingIp.name}</div>` : ''}
                            </td>
                            <td class="px-2 md:px-4 py-3">
                                <span class="px-1.5 md:px-2 py-0.5 md:py-1 text-[10px] md:text-xs font-semibold rounded-full ${typeColor} whitespace-nowrap">
                                    ${typeLabel}
                                </span>
                            </td>
                            <td class="px-2 md:px-4 py-3">
                                <div class="text-xs text-gray-600 dark:text-gray-400">
                                    <div>Location: ${floatingIp.location || 'N/A'}</div>
                                    <div>Billing: ${floatingIp.billing_cycle || 'N/A'}</div>
                                    <div class="font-semibold text-gray-900 dark:text-white">$${floatingIp.monthly_price || '0.00'}/mo</div>
                                </div>
                            </td>
                            <td class="px-2 md:px-4 py-3">
                                <button onclick="deleteFloatingIP('${floatingIp.id}')" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-semibold text-xs md:text-sm whitespace-nowrap">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    `;
                });
            }
        } else {
            document.getElementById('network-table').innerHTML = `
                <tr>
                    <td colspan="4" class="px-3 md:px-6 py-3 md:py-4 text-center text-red-500">
                        Failed to load network information
                    </td>
                </tr>
            `;
        }
    } catch (error) {
        console.error('Error loading network info:', error);
        document.getElementById('network-table').innerHTML = `
            <tr>
                <td colspan="4" class="px-6 py-4 text-center text-red-500">
                    Error: ${error.message}
                </td>
            </tr>
        `;
    }
}

// Edit Reverse DNS
function editReverseDNS(type, ip) {
    document.getElementById(`dns-${type}-display`).classList.add('hidden');
    document.getElementById(`dns-${type}-input`).classList.remove('hidden');
    document.getElementById(`edit-btn-${type}`).classList.add('hidden');
    document.getElementById(`save-cancel-${type}`).classList.remove('hidden');
}

// Cancel Edit DNS
function cancelEditDNS(type) {
    document.getElementById(`dns-${type}-display`).classList.remove('hidden');
    document.getElementById(`dns-${type}-input`).classList.add('hidden');
    document.getElementById(`edit-btn-${type}`).classList.remove('hidden');
    document.getElementById(`save-cancel-${type}`).classList.add('hidden');
}

// Save Reverse DNS
async function saveReverseDNS(type, ip) {
    const newDns = document.getElementById(`dns-${type}-input`).value.trim();
    
    try {
        const response = await fetch(`/services/vps/${serviceId}/network/reverse-dns`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                ip: ip,
                dns_ptr: newDns || null
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert('Reverse DNS updated successfully!');
            loadNetworkInfo();
        } else {
            alert('Failed to update Reverse DNS: ' + (data.error || 'Unknown error'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while updating Reverse DNS');
    }
}

// Copy to clipboard
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        // Show a brief notification
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
        notification.textContent = 'IP copied to clipboard!';
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 2000);
    });
}

// Floating IP Modal Functions
let serverLocation = null;
let hetznerLocations = [];
let floatingIPData = {};

function openFloatingIPModal() {
    const modal = document.getElementById('floatingIPModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    showStep('step1-config');
    loadHetznerLocations();
}

function closeFloatingIPModal() {
    const modal = document.getElementById('floatingIPModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.getElementById('floatingIPForm').reset();
    document.getElementById('paymentForm').reset();
    floatingIPData = {};
}

function showStep(stepId) {
    document.querySelectorAll('.step-content').forEach(step => {
        step.classList.add('hidden');
    });
    document.getElementById(stepId).classList.remove('hidden');
}

function updateFloatingIPPrice() {
    const protocol = document.querySelector('input[name="protocol"]:checked').value;
    const monthlyPrice = protocol === 'ipv4' ? 5.00 : 3.00;
    
    // Get billing cycle from service
    const billingCycle = '{{ $service->billing_cycle ?? "monthly" }}';
    
    // Calculate multiplier based on billing cycle
    const multipliers = {
        'monthly': 1,
        'quarterly': 3,
        'semi_annually': 6,
        'annually': 12
    };
    
    const multiplier = multipliers[billingCycle] || 1;
    const totalPrice = monthlyPrice * multiplier;
    
    // Update summary if visible
    if (document.getElementById('summary-protocol')) {
        document.getElementById('summary-protocol').textContent = protocol.toUpperCase();
        document.getElementById('summary-price').textContent = '$' + monthlyPrice.toFixed(2) + '/mo';
        document.getElementById('summary-total').textContent = '$' + totalPrice.toFixed(2);
    }
}

function proceedToPayment() {
    const form = document.getElementById('floatingIPForm');
    
    // Validate form
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
    // Collect data
    const formData = new FormData(form);
    floatingIPData = {
        protocol: formData.get('protocol'),
        location: formData.get('location'),
        name: formData.get('name'),
    };
    
    // Find selected location name
    const selectedLocation = hetznerLocations.find(loc => loc.name === floatingIPData.location);
    
    // Update summary
    document.getElementById('summary-protocol').textContent = floatingIPData.protocol.toUpperCase();
    document.getElementById('summary-location').textContent = selectedLocation ? selectedLocation.city : floatingIPData.location;
    updateFloatingIPPrice();
    
    // Show payment step
    showStep('step2-payment');
}

function backToConfig() {
    showStep('step1-config');
}

async function loadHetznerLocations() {
    try {
        const response = await fetch(`/services/vps/${serviceId}/hetzner-locations`);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success) {
            serverLocation = data.serverLocation;
            hetznerLocations = data.locations || [];
            
            if (hetznerLocations.length === 0) {
                document.getElementById('locationOptions').innerHTML = `
                    <div class="text-center py-4 text-yellow-600">
                        <p>No locations available</p>
                    </div>
                `;
                return;
            }
            
            renderLocationOptions();
        } else {
            console.error('API Error:', data);
            document.getElementById('locationOptions').innerHTML = `
                <div class="text-center py-4 text-red-600">
                    <p>Failed to load locations: ${data.error || 'Unknown error'}</p>
                </div>
            `;
        }
    } catch (error) {
        console.error('Error loading locations:', error);
        document.getElementById('locationOptions').innerHTML = `
            <div class="text-center py-4 text-red-600">
                <p>Error loading locations: ${error.message}</p>
            </div>
        `;
    }
}

function renderLocationOptions() {
    const container = document.getElementById('locationOptions');
    container.innerHTML = '';
    
    hetznerLocations.forEach(location => {
        const isServerLocation = location.name === serverLocation;
        const isDisabled = !isServerLocation;
        
        const locationDiv = document.createElement('label');
        locationDiv.className = `relative flex items-center p-4 border-2 rounded-lg cursor-pointer transition-colors ${
            isDisabled 
                ? 'border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 opacity-50 cursor-not-allowed' 
                : 'border-gray-300 dark:border-gray-600 hover:border-blue-500 dark:hover:border-blue-400'
        }`;
        
        locationDiv.innerHTML = `
            <input 
                type="radio" 
                name="location" 
                value="${location.name}" 
                ${isServerLocation ? 'checked' : ''}
                ${isDisabled ? 'disabled' : ''}
                required
                class="w-4 h-4 text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-400"
            >
            <div class="ml-3 flex-1">
                <div class="flex items-center gap-2">
                    <span class="text-sm font-semibold text-gray-900 dark:text-white">${location.city}</span>
                    ${isServerLocation ? '<span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Server Location</span>' : ''}
                </div>
                <span class="text-xs text-gray-500 dark:text-gray-400">${location.description || location.name}</span>
            </div>
        `;
        
        container.appendChild(locationDiv);
    });
}

// Handle Payment Form Submission
document.addEventListener('DOMContentLoaded', () => {
    const paymentForm = document.getElementById('paymentForm');
    if (paymentForm) {
        paymentForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
            
            // Combine floating IP data with payment method
            const requestData = {
                ...floatingIPData,
                payment_method: paymentMethod,
                billing_cycle: '{{ $service->billing_cycle ?? "monthly" }}'
            };
            
            try {
                // Disable submit button
                const submitBtn = e.target.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Processing...</span>
                `;
                
                const response = await fetch(`/services/vps/${serviceId}/floating-ip`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(requestData)
                });
                
                const result = await response.json();
                
                // Re-enable button
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
                
                if (result.success) {
                    // Check if we need to redirect (card payment or pending)
                    if (result.redirect && result.url) {
                        // Redirect to payment gateway
                        window.location.href = result.url;
                        return;
                    }
                    
                    // Check for Fawry payment
                    if (result.payment_method === 'fawry' && result.reference_code) {
                        closeFloatingIPModal();
                        showNotification('Fawry payment initiated. Reference code: ' + result.reference_code, 'success');
                        if (result.pending_url) {
                            setTimeout(() => {
                                window.location.href = result.pending_url;
                            }, 2000);
                        }
                        return;
                    }
                    
                    // Check for mobile wallet payment
                    if (result.payment_method === 'mobile_wallet' && result.reference) {
                        closeFloatingIPModal();
                        showNotification('Mobile wallet payment initiated', 'success');
                        if (result.pending_url) {
                            setTimeout(() => {
                                window.location.href = result.pending_url;
                            }, 2000);
                        }
                        return;
                    }
                    
                    // Wallet payment success
                    showNotification('Floating IP created successfully!', 'success');
                    closeFloatingIPModal();
                    loadNetworkInfo(); // Refresh network info
                } else {
                    showNotification(result.message || 'Failed to create Floating IP', 'error');
                }
            } catch (error) {
                console.error('Error creating Floating IP:', error);
                showNotification('An error occurred while creating Floating IP', 'error');
                
                // Re-enable button
                const submitBtn = e.target.querySelector('button[type="submit"]');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        });
    }
});

// Delete Floating IP Function
async function deleteFloatingIP(floatingIpId) {
    if (!confirm('Are you sure you want to delete this Floating IP? This action cannot be undone.')) {
        return;
    }

    try {
        const response = await fetch(`/services/vps/${serviceId}/floating-ip/${floatingIpId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        const result = await response.json();

        if (result.success) {
            showNotification('Floating IP deleted successfully!', 'success');
            loadNetworkInfo(); // Refresh network info
        } else {
            showNotification(result.message || 'Failed to delete Floating IP', 'error');
        }
    } catch (error) {
        console.error('Error deleting Floating IP:', error);
        showNotification('An error occurred while deleting Floating IP', 'error');
    }
}

// Load ISO Images
let isoImages = [];
async function loadISOImages() {
    const loadingDiv = document.getElementById('iso-loading');
    const listDiv = document.getElementById('iso-list');
    const mountedContainer = document.getElementById('mounted-iso-container');
    
    try {
        loadingDiv.classList.remove('hidden');
        listDiv.classList.add('hidden');
        
        const response = await fetch(`/services/vps/${serviceId}/iso-images`, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            isoImages = data.images || [];
            const mountedIso = data.mounted_iso;
            
            // Display mounted ISO if exists
            if (mountedIso) {
                mountedContainer.innerHTML = `
                    <div class="bg-green-50 dark:bg-green-900/20 border-2 border-green-500 dark:border-green-600 rounded-xl p-4 md:p-6 mb-4">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-start gap-3">
                                <div class="p-2 bg-green-100 dark:bg-green-900/50 rounded-lg">
                                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 dark:text-white mb-1">Currently Mounted ISO</h4>
                                    <p class="text-sm text-gray-700 dark:text-gray-300 mb-2"><strong>${mountedIso.name}</strong></p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">${mountedIso.description || 'No description'}</p>
                                </div>
                            </div>
                            <button onclick="unmountISO()" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg transition-colors">
                                Unmount ISO
                            </button>
                        </div>
                    </div>
                `;
            } else {
                mountedContainer.innerHTML = '';
            }
            
            // Display ISO images list
            renderISOImages(isoImages);
            
            loadingDiv.classList.add('hidden');
            listDiv.classList.remove('hidden');
        } else {
            throw new Error(data.message || 'Failed to load ISO images');
        }
    } catch (error) {
        console.error('Error loading ISO images:', error);
        loadingDiv.innerHTML = `
            <div class="text-center py-8">
                <svg class="w-16 h-16 mx-auto mb-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-red-600 dark:text-red-400 font-semibold">Failed to load ISO images</p>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">${error.message}</p>
            </div>
        `;
    }
}

function renderISOImages(images) {
    const gridDiv = document.getElementById('iso-grid');
    
    if (images.length === 0) {
        gridDiv.innerHTML = `
            <div class="col-span-full text-center py-8">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-gray-600 dark:text-gray-400">No ISO images available</p>
            </div>
        `;
        return;
    }
    
    gridDiv.innerHTML = images.map(iso => `
        <div class="bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-xl p-4 hover:border-purple-500 dark:hover:border-purple-400 transition-all">
            <div class="flex items-start gap-3 mb-3">
                <div class="p-2 bg-purple-100 dark:bg-purple-900/30 rounded-lg shrink-0">
                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke-width="2"/>
                        <circle cx="12" cy="12" r="2.5" stroke-width="2"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="font-bold text-gray-900 dark:text-white text-sm mb-1 truncate">${iso.name}</h4>
                    <span class="inline-block px-2 py-1 text-xs font-semibold rounded ${iso.type === 'public' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400'}">
                        ${iso.type || 'Public'}
                    </span>
                </div>
            </div>
            
            ${iso.description ? `<p class="text-xs text-gray-600 dark:text-gray-400 mb-3 line-clamp-2">${iso.description}</p>` : ''}
            
            <button onclick="mountISO(${iso.id}, '${iso.name.replace(/'/g, "\\'")}')" class="w-full px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-semibold rounded-lg transition-colors">
                Mount ISO
            </button>
        </div>
    `).join('');
}

// Search ISO Images
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('iso-search');
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            const filtered = isoImages.filter(iso => 
                iso.name.toLowerCase().includes(searchTerm) || 
                (iso.description && iso.description.toLowerCase().includes(searchTerm))
            );
            renderISOImages(filtered);
        });
    }
});

// Mount ISO
async function mountISO(isoId, isoName) {
    if (!confirm(`Are you sure you want to mount "${isoName}"? Your server will be rebooted.`)) {
        return;
    }
    
    try {
        const response = await fetch(`/services/vps/${serviceId}/iso/mount`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ iso_id: isoId })
        });
        
        const result = await response.json();
        
        if (result.success) {
            showNotification('ISO mounted successfully! Server is rebooting...', 'success');
            loadISOImages(); // Refresh the list
            setTimeout(() => {
                checkStatus(); // Update server status
            }, 3000);
        } else {
            showNotification(result.message || 'Failed to mount ISO', 'error');
        }
    } catch (error) {
        console.error('Error mounting ISO:', error);
        showNotification('An error occurred while mounting ISO', 'error');
    }
}

// Unmount ISO
async function unmountISO() {
    if (!confirm('Are you sure you want to unmount the ISO? Your server will be rebooted.')) {
        return;
    }
    
    try {
        const response = await fetch(`/services/vps/${serviceId}/iso/unmount`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            showNotification('ISO unmounted successfully! Server is rebooting...', 'success');
            loadISOImages(); // Refresh the list
            setTimeout(() => {
                checkStatus(); // Update server status
            }, 3000);
        } else {
            showNotification(result.message || 'Failed to unmount ISO', 'error');
        }
    } catch (error) {
        console.error('Error unmounting ISO:', error);
        showNotification('An error occurred while unmounting ISO', 'error');
    }
}

// Open Console
async function openConsole() {
    try {
        // Open console page in new window
        const consoleWindow = window.open(`/services/vps/${serviceId}/console`, 'VPS_Console', 'width=1200,height=800,menubar=no,toolbar=no,location=no,status=no');
        if (!consoleWindow) {
            showNotification('Please allow popups to open the console', 'error');
        }
    } catch (error) {
        console.error('Error opening console:', error);
        showNotification('An error occurred while opening console', 'error');
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    @if($service->status === 'active' && $serverData)
    checkStatus();
    setInterval(checkStatus, 30000); // Update every 30 seconds
    @endif
});
</script>

<style>
/* Hide Scrollbar */
#tabs-container::-webkit-scrollbar {
    display: none;
}

/* Minimalist Tab Button Styles */
.tab-button {
    position: relative;
    transition: all 0.2s ease;
    background-color: transparent;
    color: #9CA3AF;
}

.dark .tab-button {
    color: #6B7280;
}

.tab-button:active {
    transform: scale(0.95);
}

.tab-button.active {
    background-color: #3B82F6;
    color: #FFFFFF !important;
}

.dark .tab-button.active {
    background-color: #2563EB;
}

/* Mobile Touch Optimization */
@media (max-width: 639px) {
    #tabs-container {
        -webkit-overflow-scrolling: touch;
        scroll-snap-type: x mandatory;
    }
    
    .tab-button {
        scroll-snap-align: center;
    }
}
@keyframes fade-in {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes fade-out {
    from { opacity: 1; }
    to { opacity: 0; }
}
.animate-fade-in { animation: fade-in 0.3s ease-out; }
.animate-fade-out { animation: fade-out 0.5s ease-out; }
</style>
@endsection
