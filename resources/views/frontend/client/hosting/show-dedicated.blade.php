@extends('frontend.client.layout')

@section('title', __('frontend.dedicated_details') . ' - ' . config('app.name'))

@section('content')
@php
    $serverIp = $serverData['ipv4'] ?? null;
    $serverIpv6 = $serverData['ipv6'] ?? null;
    $serverType = $serverData['server_type'] ?? null;
    $location = $serverData['location'] ?? null;
    $rootPassword = $serverData['root_password'] ?? null;
    $hetznerServerId = $serverData['hetzner_server_id'] ?? null;
    $serverName = $serverData['hetzner_server_name'] ?? $service->service_name ?? 'Dedicated Server #' . $service->id;
@endphp

<div class="p-4 md:p-6 space-y-6">
    <!-- Header with Gradient Background -->
    <div class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 rounded-2xl p-6 md:p-8">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <defs>
                    <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                        <path d="M 10 0 L 0 0 0 10" fill="none" stroke="currentColor" stroke-width="0.5"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)"/>
            </svg>
        </div>
        
        <!-- Glowing Orbs -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-cyan-500/20 rounded-full blur-3xl"></div>
        
        <div class="relative">
            <!-- Back Button & Status -->
            <div class="flex items-center justify-between mb-6">
                <a href="{{ route('client.hosting.dedicated') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-white transition-colors group">
                    <div class="p-2 rounded-lg bg-white/5 group-hover:bg-white/10 transition-colors">
                        <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </div>
                    <span class="text-sm font-medium">{{ __('frontend.back') }}</span>
                </a>
                
                @if($service->status === 'active')
                    <div class="flex items-center gap-2 px-4 py-2 bg-emerald-500/20 backdrop-blur-sm rounded-full border border-emerald-500/30">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                        </span>
                        <span class="text-sm font-medium text-emerald-400">{{ __('frontend.active') }}</span>
                    </div>
                @elseif(in_array($service->status, ['pending', 'pending_approval', 'provisioning']))
                    <div class="flex items-center gap-2 px-4 py-2 bg-amber-500/20 backdrop-blur-sm rounded-full border border-amber-500/30">
                        <svg class="w-4 h-4 text-amber-400 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-sm font-medium text-amber-400">{{ $service->status === 'provisioning' ? __('frontend.provisioning') : __('frontend.pending') }}</span>
                    </div>
                @elseif($service->status === 'suspended')
                    <div class="flex items-center gap-2 px-4 py-2 bg-red-500/20 backdrop-blur-sm rounded-full border border-red-500/30">
                        <span class="h-2.5 w-2.5 rounded-full bg-red-500"></span>
                        <span class="text-sm font-medium text-red-400">{{ __('frontend.suspended') }}</span>
                    </div>
                @endif
            </div>
            
            <!-- Server Info -->
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-3 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-500 shadow-lg shadow-blue-500/25">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold text-white">{{ $serverName }}</h1>
                            @if($serverType)
                            <span class="text-slate-400 text-sm">{{ strtoupper($serverType) }}</span>
                            @endif
                        </div>
                    </div>
                    
                    @if($serverIp)
                    <div class="flex items-center gap-2 mt-4">
                        <code class="px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-lg text-slate-300 font-mono text-sm border border-white/10">{{ $serverIp }}</code>
                        <button onclick="copyToClipboard('{{ $serverIp }}', this)" class="p-2 text-slate-400 hover:text-white hover:bg-white/10 rounded-lg transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </button>
                    </div>
                    @endif
                    
                    <!-- Server Specs -->
                    @if(isset($serverSpecs) && $serverSpecs)
                    <div class="flex flex-wrap items-center gap-3 mt-4">
                        @if($serverSpecs['cores'])
                        <div class="flex items-center gap-2 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-lg border border-white/10">
                            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                            </svg>
                            <span class="text-sm text-white font-medium">{{ $serverSpecs['cores'] }} vCPU</span>
                        </div>
                        @endif
                        
                        @if($serverSpecs['memory'])
                        <div class="flex items-center gap-2 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-lg border border-white/10">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            <span class="text-sm text-white font-medium">{{ $serverSpecs['memory'] }} GB RAM</span>
                        </div>
                        @endif
                        
                        @if($serverSpecs['disk'])
                        <div class="flex items-center gap-2 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-lg border border-white/10">
                            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                            </svg>
                            <span class="text-sm text-white font-medium">{{ $serverSpecs['disk'] }} GB {{ strtoupper($serverSpecs['disk_type'] ?? 'SSD') }}</span>
                        </div>
                        @endif
                        
                        @if($serverSpecs['included_traffic'])
                        <div class="flex items-center gap-2 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-lg border border-white/10">
                            <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                            <span class="text-sm text-white font-medium">{{ $serverSpecs['included_traffic'] }} TB Traffic</span>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
                
                @if($service->recurring_amount)
                <div class="text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}">
                    <div class="text-slate-400 text-xs uppercase tracking-wider mb-1">{{ __('frontend.price') }}</div>
                    <div class="text-3xl font-bold text-white">${{ number_format($service->recurring_amount, 2) }}</div>
                    <div class="text-slate-500 text-sm">/{{ __('frontend.' . $service->billing_cycle) ?? $service->billing_cycle }}</div>
                </div>
                @endif
            </div>
            
            <!-- Server Control Buttons -->
            @if($service->status === 'active' && $hetznerServerId)
            <div class="flex flex-wrap items-center gap-2 mt-6 pt-6 border-t border-white/10">
                <!-- Server Status Indicator -->
                <div id="server-status-indicator" class="flex items-center gap-2 px-4 py-2 bg-gray-500/20 backdrop-blur-sm rounded-xl border border-gray-500/30 mr-2">
                    <span class="relative flex h-2.5 w-2.5">
                        <span id="status-ping" class="animate-ping absolute inline-flex h-full w-full rounded-full bg-gray-400 opacity-75"></span>
                        <span id="status-dot" class="relative inline-flex rounded-full h-2.5 w-2.5 bg-gray-500"></span>
                    </span>
                    <span id="status-text" class="text-sm font-medium text-gray-400">{{ __('frontend.checking') ?? 'Checking...' }}</span>
                </div>
                
                <button onclick="serverAction('start')" id="btn-start" disabled
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-500/20 hover:bg-emerald-500/30 text-emerald-400 border border-emerald-500/30 rounded-xl transition-all hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-medium">{{ __('frontend.start') }}</span>
                </button>
                
                <button onclick="serverAction('stop')" id="btn-stop" disabled
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-amber-500/20 hover:bg-amber-500/30 text-amber-400 border border-amber-500/30 rounded-xl transition-all hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/>
                    </svg>
                    <span class="text-sm font-medium">{{ __('frontend.stop') }}</span>
                </button>
                
                <button onclick="serverAction('power_off')" id="btn-power-off" disabled
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-500/20 hover:bg-red-500/30 text-red-400 border border-red-500/30 rounded-xl transition-all hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 11-12.728 0M12 3v9"/>
                    </svg>
                    <span class="text-sm font-medium">{{ __('frontend.power_off') }}</span>
                </button>
                
                <!-- Loading Indicator -->
                <div id="action-loading" class="hidden items-center gap-2 px-4 py-2.5 text-slate-400">
                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-sm">{{ __('frontend.processing') ?? 'Processing...' }}</span>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @if($service->order)
        <div class="group bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 hover:border-blue-500/50 dark:hover:border-blue-500/50 transition-all hover:shadow-lg hover:shadow-blue-500/5">
            <div class="flex items-center gap-3">
                <div class="p-2.5 rounded-lg bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ __('frontend.order_number') }}</div>
                    <div class="text-sm font-semibold text-gray-900 dark:text-white">#{{ $service->order->order_number ?? $service->order_id }}</div>
                </div>
            </div>
        </div>
        @endif
        
        @if($service->billing_cycle)
        <div class="group bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 hover:border-emerald-500/50 dark:hover:border-emerald-500/50 transition-all hover:shadow-lg hover:shadow-emerald-500/5">
            <div class="flex items-center gap-3">
                <div class="p-2.5 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </div>
                <div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ __('frontend.billing_cycle') }}</div>
                    <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $service->billing_cycle)) }}</div>
                </div>
            </div>
        </div>
        @endif
        
        @if($service->next_due_date)
        <div class="group bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 hover:border-amber-500/50 dark:hover:border-amber-500/50 transition-all hover:shadow-lg hover:shadow-amber-500/5">
            <div class="flex items-center gap-3">
                <div class="p-2.5 rounded-lg bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ __('frontend.next_due_date') }}</div>
                    <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($service->next_due_date)->format('M d, Y') }}</div>
                </div>
            </div>
        </div>
        @endif
        
        @if($location)
        <div class="group bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 hover:border-teal-500/50 dark:hover:border-teal-500/50 transition-all hover:shadow-lg hover:shadow-teal-500/5">
            <div class="flex items-center gap-3">
                <div class="p-2.5 rounded-lg bg-teal-50 dark:bg-teal-500/10 text-teal-600 dark:text-teal-400 group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ __('frontend.location') }}</div>
                    <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ strtoupper($location) }}</div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Quick Connect Card -->
            @if($service->status === 'active' && $serverIp)
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-5 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-lg bg-gradient-to-br from-cyan-500 to-blue-500 text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-base font-semibold text-gray-900 dark:text-white">{{ __('frontend.quick_connect') }}</h2>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('frontend.connect_to_server') ?? 'Connect to your server instantly' }}</p>
                        </div>
                    </div>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- SSH -->
                        <div class="group relative bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 border-2 border-dashed border-gray-200 dark:border-gray-600 hover:border-blue-500 dark:hover:border-blue-500 transition-colors">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-lg bg-gray-900 dark:bg-gray-600 flex items-center justify-center">
                                        <span class="text-white text-xs font-bold">SSH</span>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Terminal</span>
                                </div>
                                <button onclick="copyToClipboard('ssh root@{{ $serverIp }}', this)" class="p-2 text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-500/10 rounded-lg transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                </button>
                            </div>
                            <code class="block text-sm font-mono text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-800 px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-600 truncate">ssh root@{{ $serverIp }}</code>
                        </div>
                        
                        <!-- SFTP -->
                        <div class="group relative bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 border-2 border-dashed border-gray-200 dark:border-gray-600 hover:border-emerald-500 dark:hover:border-emerald-500 transition-colors">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-500 flex items-center justify-center">
                                        <span class="text-white text-xs font-bold">FTP</span>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">File Transfer</span>
                                </div>
                                <button onclick="copyToClipboard('sftp://root@{{ $serverIp }}', this)" class="p-2 text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-500/10 rounded-lg transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                </button>
                            </div>
                            <code class="block text-sm font-mono text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-800 px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-600 truncate">sftp://root@{{ $serverIp }}</code>
                        </div>
                    </div>
                    
                    <!-- Web Console - Full Width -->
                    @if(isset($serverData['hetzner_server_id']))
                    <div class="mt-4 group relative bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 border-2 border-dashed border-gray-200 dark:border-gray-600 hover:border-purple-500 dark:hover:border-purple-500 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-purple-500 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('frontend.web_console') ?? 'Web Console' }}</span>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('frontend.vnc_access') ?? 'Direct VNC access to your server' }}</p>
                                </div>
                            </div>
                            <button onclick="openConsole()" class="text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded-lg transition-colors flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                                {{ __('frontend.open_console') ?? 'Open Console' }}
                            </button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Server Details Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-5 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-lg bg-gradient-to-br from-slate-500 to-slate-700 text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-base font-semibold text-gray-900 dark:text-white">{{ __('frontend.server_information') }}</h2>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('frontend.technical_details') ?? 'Technical details and network information' }}</p>
                        </div>
                    </div>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @if($serverIp)
                    <div class="flex items-center justify-between p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-500/10 flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ __('frontend.ipv4_address') }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Primary IP Address</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <code class="text-sm font-mono text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 px-3 py-1.5 rounded-lg">{{ $serverIp }}</code>
                            <button onclick="copyToClipboard('{{ $serverIp }}', this)" class="p-2 text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    @endif
                    
                    @if($serverIpv6)
                    <div class="flex items-center justify-between p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-500/10 flex items-center justify-center">
                                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ __('frontend.ipv6_address') }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">IPv6 Network</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <code class="text-xs font-mono text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 px-3 py-1.5 rounded-lg truncate max-w-[180px]" title="{{ $serverIpv6 }}">{{ $serverIpv6 }}</code>
                            <button onclick="copyToClipboard('{{ $serverIpv6 }}', this)" class="p-2 text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    @endif
                    
                    @if($serverType)
                    <div class="flex items-center justify-between p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-cyan-50 dark:bg-cyan-500/10 flex items-center justify-center">
                                <svg class="w-5 h-5 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ __('frontend.server_type') }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Hardware Configuration</div>
                            </div>
                        </div>
                        <span class="px-3 py-1.5 bg-gradient-to-r from-cyan-500 to-blue-500 text-white text-sm font-semibold rounded-lg">{{ strtoupper($serverType) }}</span>
                    </div>
                    @endif
                    
                    @if($hetznerServerId)
                    <div class="flex items-center justify-between p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ __('frontend.server_id') }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Internal Reference</div>
                            </div>
                        </div>
                        <span class="text-sm font-mono text-gray-700 dark:text-gray-300">{{ $hetznerServerId }}</span>
                    </div>
                    @endif
                    
                    @if($rootPassword && $service->status === 'active')
                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-amber-50/50 to-orange-50/50 dark:from-amber-900/10 dark:to-orange-900/10 hover:from-amber-50 hover:to-orange-50 dark:hover:from-amber-900/20 dark:hover:to-orange-900/20 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ __('frontend.root_password') }}</div>
                                <div class="text-xs text-amber-600 dark:text-amber-400">{{ __('frontend.root_password_warning') }}</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="password" id="root-password" value="{{ $rootPassword }}" readonly 
                                   class="w-32 text-sm font-mono bg-white dark:bg-gray-800 border border-amber-200 dark:border-amber-700/50 rounded-lg px-3 py-1.5 text-gray-900 dark:text-white">
                            <button onclick="togglePassword()" class="p-2 text-amber-600 dark:text-amber-400 hover:bg-amber-100 dark:hover:bg-amber-800/30 rounded-lg transition-all" title="Show/Hide">
                                <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                            <button onclick="copyToClipboard('{{ $rootPassword }}', this)" class="p-2 text-amber-600 dark:text-amber-400 hover:bg-amber-100 dark:hover:bg-amber-800/30 rounded-lg transition-all" title="Copy">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Server Metrics Graphs -->
            @if($service->status === 'active' && $hetznerServerId)
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-5 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="p-2 rounded-lg bg-gradient-to-br from-emerald-500 to-teal-600 text-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-base font-semibold text-gray-900 dark:text-white">{{ __('frontend.server_metrics') ?? 'Server Metrics' }}</h2>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('frontend.performance_graphs') ?? 'Performance monitoring graphs' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <select id="metrics-period" onchange="loadMetrics()" class="text-xs bg-gray-100 dark:bg-gray-700 border-0 rounded-lg px-3 py-1.5 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500">
                                <option value="0.083">{{ __('frontend.last_5_minutes') ?? 'Last 5 Minutes' }}</option>
                                <option value="1">{{ __('frontend.last_hour') ?? 'Last Hour' }}</option>
                                <option value="6">{{ __('frontend.last_6_hours') ?? 'Last 6 Hours' }}</option>
                                <option value="24" selected>{{ __('frontend.last_24_hours') ?? 'Last 24 Hours' }}</option>
                                <option value="168">{{ __('frontend.last_7_days') ?? 'Last 7 Days' }}</option>
                            </select>
                            <button onclick="loadMetrics()" class="p-2 text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-all" title="Refresh">
                                <svg id="metrics-refresh-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="p-5 space-y-6">
                    <!-- Loading State -->
                    <div id="metrics-loading" class="flex items-center justify-center py-12">
                        <div class="inline-flex items-center gap-2 text-gray-500 dark:text-gray-400">
                            <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>{{ __('frontend.loading_metrics') ?? 'Loading metrics...' }}</span>
                        </div>
                    </div>
                    
                    <!-- Graphs Container -->
                    <div id="metrics-container" class="hidden space-y-6">
                        <!-- CPU Usage Graph -->
                        <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-4">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('frontend.cpu_usage') ?? 'CPU Usage' }}</span>
                                </div>
                                <span id="cpu-current" class="text-sm font-semibold text-blue-600 dark:text-blue-400">--%</span>
                            </div>
                            <div class="h-40">
                                <canvas id="cpu-chart"></canvas>
                            </div>
                        </div>
                        
                        <!-- Disk Throughput Graph -->
                        <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-4">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('frontend.disk_throughput') ?? 'Disk Throughput' }}</span>
                                </div>
                                <span id="disk-current" class="text-sm font-semibold text-amber-600 dark:text-amber-400">-- MB/s</span>
                            </div>
                            <div class="h-40">
                                <canvas id="disk-chart"></canvas>
                            </div>
                        </div>
                        
                        <!-- Network Traffic Graph -->
                        <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-4">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('frontend.network_traffic') ?? 'Network Traffic' }}</span>
                                </div>
                                <span id="network-current" class="text-sm font-semibold text-emerald-600 dark:text-emerald-400">-- Mbps</span>
                            </div>
                            <div class="h-40">
                                <canvas id="network-chart"></canvas>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Error State -->
                    <div id="metrics-error" class="hidden py-8 text-center">
                        <div class="w-12 h-12 mx-auto rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center mb-3">
                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('frontend.metrics_error') ?? 'Failed to load metrics' }}</p>
                        <button onclick="loadMetrics()" class="mt-2 text-sm text-blue-600 dark:text-blue-400 hover:underline">{{ __('frontend.try_again') ?? 'Try again' }}</button>
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Backups Section -->
            @if($service->status === 'active' && $hetznerServerId)
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-5 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-lg bg-gradient-to-br from-blue-500 to-indigo-600 text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-base font-semibold text-gray-900 dark:text-white">{{ __('frontend.backups') ?? 'Backups' }}</h2>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('frontend.automatic_backup_copies') ?? 'Automatic backup copies of your server' }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-5 space-y-4">
                    <!-- Backups Loading -->
                    <div id="backups-loading" class="flex items-center justify-center py-4">
                        <div class="inline-flex items-center gap-2 text-gray-500 dark:text-gray-400">
                            <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>{{ __('frontend.loading') ?? 'Loading...' }}</span>
                        </div>
                    </div>
                    
                    <!-- Backups Content -->
                    <div id="backups-content" class="hidden">
                        <!-- Backups Disabled State -->
                        <div id="backups-disabled" class="hidden space-y-4">
                            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4 border border-blue-100 dark:border-blue-800/50">
                                <div class="flex gap-3">
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div class="text-sm">
                                        <p class="font-medium text-blue-800 dark:text-blue-300 mb-2">{{ __('frontend.backup_info_title') ?? 'About Server Backups' }}</p>
                                        <ul class="text-blue-700 dark:text-blue-400 space-y-1 text-xs">
                                            <li>• {{ __('frontend.backup_slots') ?? '7 backup slots available' }}</li>
                                            <li>• {{ __('frontend.backup_auto_delete') ?? 'Oldest backup auto-deleted when full' }}</li>
                                            <li>• {{ __('frontend.backup_power_off') ?? 'Recommended: Power off before backup' }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Cost Info Box -->
                            <div class="bg-amber-50 dark:bg-amber-900/20 rounded-xl p-4 border border-amber-100 dark:border-amber-800/50">
                                <div class="flex gap-3">
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div class="text-sm flex-1">
                                        <p class="font-medium text-amber-800 dark:text-amber-300">{{ __('frontend.backup_cost') ?? 'Additional Cost' }}</p>
                                        <div class="mt-2 space-y-1">
                                            <div class="flex justify-between text-xs">
                                                <span class="text-amber-700 dark:text-amber-400">{{ __('frontend.backup_price') ?? 'Backup Price' }}:</span>
                                                <span class="font-semibold text-amber-800 dark:text-amber-300" id="backup-price-display">--</span>
                                            </div>
                                            <div class="flex justify-between text-xs">
                                                <span class="text-amber-700 dark:text-amber-400">{{ __('frontend.billing_cycle') ?? 'Billing Cycle' }}:</span>
                                                <span class="font-semibold text-amber-800 dark:text-amber-300" id="backup-cycle-display">--</span>
                                            </div>
                                            <div class="flex justify-between text-xs pt-1 border-t border-amber-200 dark:border-amber-700">
                                                <span class="text-amber-700 dark:text-amber-400">{{ __('frontend.wallet_balance') ?? 'Wallet Balance' }}:</span>
                                                <span class="font-semibold" id="wallet-balance-display">--</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Insufficient Balance Warning -->
                            <div id="insufficient-balance-warning" class="hidden bg-red-50 dark:bg-red-900/20 rounded-xl p-4 border border-red-100 dark:border-red-800/50">
                                <div class="flex gap-3">
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                        </svg>
                                    </div>
                                    <div class="text-sm">
                                        <p class="font-medium text-red-800 dark:text-red-300">{{ __('frontend.insufficient_balance') ?? 'Insufficient Balance' }}</p>
                                        <p class="text-red-700 dark:text-red-400 text-xs mt-1">{{ __('frontend.add_funds_to_enable_backup') ?? 'Please add funds to your wallet to enable backups.' }}</p>
                                        <a href="{{ route('client.wallet') }}" class="inline-flex items-center gap-1 mt-2 text-xs font-medium text-red-700 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                            </svg>
                                            {{ __('frontend.add_funds') ?? 'Add Funds' }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <button onclick="enableBackups()" id="enable-backups-btn" class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-sm font-semibold rounded-xl transition-all flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                                </svg>
                                <span>{{ __('frontend.enable_backups') ?? 'Enable Backups' }}</span>
                            </button>
                        </div>
                        
                        <!-- Backups Enabled State -->
                        <div id="backups-enabled" class="hidden space-y-4">
                            <div class="bg-emerald-50 dark:bg-emerald-900/20 rounded-xl p-4 border border-emerald-100 dark:border-emerald-800/50">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-emerald-800 dark:text-emerald-300">{{ __('frontend.backups_enabled') ?? 'Backups Enabled' }}</p>
                                        <p class="text-xs text-emerald-600 dark:text-emerald-400" id="backup-window-text">{{ __('frontend.backup_window') ?? 'Backup Window' }}: --</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                <span id="backup-count">0</span>/7 {{ __('frontend.backup_slots_used') ?? 'slots used' }}
                            </div>
                            
                            <!-- Backups List -->
                            <div id="backups-list" class="space-y-2">
                                <!-- Backups will be rendered here -->
                            </div>
                            
                            <div id="no-backups" class="hidden text-center py-6">
                                <div class="w-12 h-12 mx-auto rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('frontend.no_backups_yet') ?? 'No backups yet' }}</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">{{ __('frontend.first_backup_info') ?? 'First backup will be created automatically' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Backups Error -->
                    <div id="backups-error" class="hidden py-4 text-center">
                        <div class="w-10 h-10 mx-auto rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center mb-2">
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('frontend.backup_load_error') ?? 'Failed to load backups' }}</p>
                        <button onclick="loadBackups()" class="mt-2 text-sm text-blue-600 dark:text-blue-400 hover:underline">{{ __('frontend.try_again') ?? 'Try again' }}</button>
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Snapshots Section -->
            @if($service->status === 'active' && $hetznerServerId)
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-5 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-lg bg-gradient-to-br from-cyan-500 to-blue-600 text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-base font-semibold text-gray-900 dark:text-white">{{ __('frontend.snapshots') ?? 'Snapshots' }}</h2>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('frontend.snapshot_description') ?? 'Instant copies of your server disk' }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-5 space-y-4">
                    <!-- Snapshots Loading -->
                    <div id="snapshots-loading" class="flex items-center justify-center py-4">
                        <div class="inline-flex items-center gap-2 text-gray-500 dark:text-gray-400">
                            <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>{{ __('frontend.loading') ?? 'Loading...' }}</span>
                        </div>
                    </div>
                    
                    <!-- Snapshots Content -->
                    <div id="snapshots-content" class="hidden space-y-4">
                        <!-- Snapshot Info Box -->
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4 border border-blue-100 dark:border-blue-800/50">
                            <div class="flex gap-3">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="text-sm">
                                    <p class="font-medium text-blue-800 dark:text-blue-300 mb-2">{{ __('frontend.snapshot_info_title') ?? 'About Server Snapshots' }}</p>
                                    <ul class="text-blue-700 dark:text-blue-400 space-y-1 text-xs">
                                        <li>• {{ __('frontend.snapshot_instant_copy') ?? 'Instant copy of your server disk' }}</li>
                                        <li>• {{ __('frontend.snapshot_power_off_recommended') ?? 'Recommended: Power off server before snapshot' }}</li>
                                        <li>• {{ __('frontend.snapshot_monthly_billing') ?? 'Billed monthly at $0.5/GB' }}</li>
                                        <li>• {{ __('frontend.snapshot_auto_delete_warning') ?? 'Auto-deleted after 3 days if renewal payment fails' }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Cost Info Box -->
                        <div class="bg-amber-50 dark:bg-amber-900/20 rounded-xl p-4 border border-amber-100 dark:border-amber-800/50">
                            <div class="flex gap-3">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="text-sm flex-1">
                                    <p class="font-medium text-amber-800 dark:text-amber-300">{{ __('frontend.snapshot_cost') ?? 'Snapshot Cost' }}</p>
                                    <div class="mt-2 space-y-1">
                                        <div class="flex justify-between text-xs">
                                            <span class="text-amber-700 dark:text-amber-400">{{ __('frontend.disk_size') ?? 'Disk Size' }}:</span>
                                            <span class="font-semibold text-amber-800 dark:text-amber-300" id="snapshot-disk-size-display">--</span>
                                        </div>
                                        <div class="flex justify-between text-xs">
                                            <span class="text-amber-700 dark:text-amber-400">{{ __('frontend.snapshot_price') ?? 'Snapshot Price' }}:</span>
                                            <span class="font-semibold text-amber-800 dark:text-amber-300" id="snapshot-price-display">--</span>
                                        </div>
                                        <div class="flex justify-between text-xs">
                                            <span class="text-amber-700 dark:text-amber-400">{{ __('frontend.price_per_gb') ?? 'Price/GB/Month' }}:</span>
                                            <span class="font-semibold text-amber-800 dark:text-amber-300">$0.50</span>
                                        </div>
                                        <div class="flex justify-between text-xs pt-1 border-t border-amber-200 dark:border-amber-700">
                                            <span class="text-amber-700 dark:text-amber-400">{{ __('frontend.wallet_balance') ?? 'Wallet Balance' }}:</span>
                                            <span class="font-semibold" id="snapshot-wallet-balance-display">--</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Insufficient Balance Warning -->
                        <div id="snapshot-insufficient-balance-warning" class="hidden bg-red-50 dark:bg-red-900/20 rounded-xl p-4 border border-red-100 dark:border-red-800/50">
                            <div class="flex gap-3">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                                <div class="text-sm">
                                    <p class="font-medium text-red-800 dark:text-red-300">{{ __('frontend.insufficient_balance') ?? 'Insufficient Balance' }}</p>
                                    <p class="text-red-700 dark:text-red-400 text-xs mt-1">{{ __('frontend.add_funds_to_create_snapshot') ?? 'Please add funds to your wallet to create a snapshot.' }}</p>
                                    <a href="{{ route('client.wallet') }}" class="inline-flex items-center gap-1 mt-2 text-xs font-medium text-red-700 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        {{ __('frontend.add_funds') ?? 'Add Funds' }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Take Snapshot Button -->
                        <button onclick="createSnapshot()" id="create-snapshot-btn" class="w-full py-3 px-4 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white text-sm font-semibold rounded-xl transition-all flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>{{ __('frontend.take_snapshot') ?? 'Take Snapshot' }}</span>
                        </button>
                        
                        <!-- Snapshots List -->
                        <div id="snapshots-list-container" class="hidden">
                            <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-2">{{ __('frontend.existing_snapshots') ?? 'Existing Snapshots' }}</h3>
                            <div id="snapshots-list" class="space-y-2">
                                <!-- Snapshots will be rendered here -->
                            </div>
                        </div>
                        
                        <div id="no-snapshots" class="hidden text-center py-4">
                            <div class="w-10 h-10 mx-auto rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mb-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                </svg>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('frontend.no_snapshots_yet') ?? 'No snapshots yet' }}</p>
                        </div>
                    </div>
                    
                    <!-- Snapshots Error -->
                    <div id="snapshots-error" class="hidden py-4 text-center">
                        <div class="w-10 h-10 mx-auto rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center mb-2">
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('frontend.snapshot_load_error') ?? 'Failed to load snapshots' }}</p>
                        <button onclick="loadSnapshots()" class="mt-2 text-sm text-blue-600 dark:text-blue-400 hover:underline">{{ __('frontend.try_again') ?? 'Try again' }}</button>
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Network Section -->
            @if($service->status === 'active' && $hetznerServerId)
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-5 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-lg bg-gradient-to-br from-emerald-500 to-teal-600 text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-base font-semibold text-gray-900 dark:text-white">{{ __('frontend.network') ?? 'Network' }}</h2>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('frontend.network_description') ?? 'IP addresses and network settings' }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-5 space-y-4">
                    <!-- Network Loading -->
                    <div id="network-loading" class="flex items-center justify-center py-4">
                        <div class="inline-flex items-center gap-2 text-gray-500 dark:text-gray-400">
                            <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>{{ __('frontend.loading') ?? 'Loading...' }}</span>
                        </div>
                    </div>
                    
                    <!-- Network Content -->
                    <div id="network-content" class="hidden space-y-4">
                        <!-- Primary IPs Section -->
                        <div class="space-y-3">
                            <h3 class="text-sm font-medium text-gray-900 dark:text-white flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                                </svg>
                                {{ __('frontend.primary_ips') ?? 'Primary IPs' }}
                            </h3>
                            
                            <!-- IPv4 -->
                            <div id="ipv4-container" class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-4 space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="px-2 py-0.5 text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded">IPv4</span>
                                        <span id="ipv4-address" class="font-mono text-sm text-gray-900 dark:text-white">--</span>
                                    </div>
                                    <button onclick="copyToClipboard(document.getElementById('ipv4-address').textContent)" class="p-1.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="flex items-center gap-2">
                                    <label class="text-xs text-gray-500 dark:text-gray-400 flex-shrink-0">{{ __('frontend.reverse_dns') ?? 'Reverse DNS' }}:</label>
                                    <input type="text" id="ipv4-dns-ptr" class="flex-1 text-xs bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg px-3 py-1.5 focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="example.com, mail.example.com">
                                    <button onclick="updateReverseDns('ipv4')" class="px-3 py-1.5 text-xs font-medium bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg transition-colors">
                                        {{ __('frontend.save') ?? 'Save' }}
                                    </button>
                                </div>
                            </div>
                            
                            <!-- IPv6 -->
                            <div id="ipv6-container" class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-4 space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="px-2 py-0.5 text-xs font-medium bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 rounded">IPv6</span>
                                        <span id="ipv6-address" class="font-mono text-sm text-gray-900 dark:text-white truncate max-w-[200px]" title="">--</span>
                                    </div>
                                    <button onclick="copyToClipboard(document.getElementById('ipv6-address').textContent)" class="p-1.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="flex items-center gap-2">
                                    <label class="text-xs text-gray-500 dark:text-gray-400 flex-shrink-0">{{ __('frontend.reverse_dns') ?? 'Reverse DNS' }}:</label>
                                    <input type="text" id="ipv6-dns-ptr" class="flex-1 text-xs bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg px-3 py-1.5 focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="example.com, mail.example.com">
                                    <button onclick="updateReverseDns('ipv6')" class="px-3 py-1.5 text-xs font-medium bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg transition-colors">
                                        {{ __('frontend.save') ?? 'Save' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Floating IPs Section -->
                        <div class="space-y-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white flex items-center gap-2">
                                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                    </svg>
                                    {{ __('frontend.floating_ips') ?? 'Floating IPs' }}
                                </h3>
                                <button onclick="openFloatingIpModal()" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium bg-amber-500 hover:bg-amber-600 text-white rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    {{ __('frontend.add_floating_ip') ?? 'Add Floating IP' }}
                                </button>
                            </div>
                            
                            <!-- Floating IPs List -->
                            <div id="floating-ips-list" class="space-y-2">
                                <!-- Floating IPs will be rendered here -->
                            </div>
                            
                            <!-- No Floating IPs -->
                            <div id="no-floating-ips" class="hidden text-center py-4">
                                <div class="w-10 h-10 mx-auto rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mb-2">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                    </svg>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('frontend.no_floating_ips') ?? 'No floating IPs yet' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Network Error -->
                    <div id="network-error" class="hidden py-4 text-center">
                        <div class="w-10 h-10 mx-auto rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center mb-2">
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('frontend.network_load_error') ?? 'Failed to load network info' }}</p>
                        <button onclick="loadNetwork()" class="mt-2 text-sm text-emerald-600 dark:text-emerald-400 hover:underline">{{ __('frontend.try_again') ?? 'Try again' }}</button>
                    </div>
                </div>
            </div>
            @endif
            
            <!-- ISO Images Section -->
            @if($service->status === 'active' && isset($serverData['hetzner_server_id']))
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-5 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v7m0-7l-9-5m9 5l9-5"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-base font-semibold text-gray-900 dark:text-white">{{ __('frontend.iso_images') ?? 'ISO Images' }}</h2>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('frontend.iso_images_subtitle') ?? 'Mount bootable ISO images to your server' }}</p>
                            </div>
                        </div>
                        <button onclick="loadIsoImages()" id="iso-refresh-btn" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <div class="p-5">
                    <!-- ISO Info Message -->
                    <div class="mb-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 dark:border-blue-800">
                        <p class="text-sm text-blue-800 dark:text-blue-300">
                            {{ __('frontend.iso_mount_info') ?? 'Mounting an ISO Image will attach it to the virtual drive in your server.' }}
                        </p>
                        <p class="text-sm text-blue-700 dark:text-blue-400 mt-2">
                            {{ __('frontend.iso_reboot_info') ?? 'Rebooting your server while an ISO image is mounted will cause it to boot from the image. After rebooting the server you can access our web console to complete the installation. Some images may require you to press a key in the console during boot, otherwise the server will boot from disk again.' }}
                        </p>
                        <p class="text-sm text-blue-700 dark:text-blue-400 mt-2">
                            {{ __('frontend.iso_custom_info') ?? 'If you want to use your own ISO image, please follow the instructions in our Docs.' }}
                        </p>
                    </div>
                    
                    <!-- Currently Mounted ISO -->
                    <div id="mounted-iso-section" class="hidden mb-4">
                        <div class="flex items-center justify-between p-4 bg-green-50 dark:bg-green-900/20 rounded-xl border border-green-200 dark:border-green-800">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-800/40 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-green-800 dark:text-green-300">{{ __('frontend.currently_mounted') ?? 'Currently Mounted' }}</p>
                                    <p id="mounted-iso-name" class="text-xs text-green-600 dark:text-green-400"></p>
                                </div>
                            </div>
                            <button onclick="unmountIso()" id="unmount-iso-btn" class="px-4 py-2 text-sm font-medium text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/30 hover:bg-red-100 dark:hover:bg-red-900/50 rounded-lg transition-colors">
                                {{ __('frontend.unmount') ?? 'Unmount' }}
                            </button>
                        </div>
                    </div>
                    
                    <!-- ISO Loading -->
                    <div id="iso-loading" class="py-8 text-center">
                        <div class="w-8 h-8 mx-auto border-2 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ __('frontend.loading_iso_images') ?? 'Loading ISO images...' }}</p>
                    </div>
                    
                    <!-- Available ISO Images -->
                    <div id="iso-images-list" class="hidden">
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">{{ __('frontend.available_iso_images') ?? 'Available ISO Images' }}</h3>
                        <div class="space-y-2 max-h-80 overflow-y-auto" id="iso-images-container">
                            <!-- ISO images will be loaded here -->
                        </div>
                    </div>
                    
                    <!-- ISO Empty State -->
                    <div id="iso-empty" class="hidden py-4 text-center">
                        <div class="w-10 h-10 mx-auto rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mb-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" stroke-width="2"/>
                                <circle cx="12" cy="12" r="3" stroke-width="2"/>
                            </svg>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('frontend.no_iso_images') ?? 'No ISO images available' }}</p>
                    </div>
                    
                    <!-- ISO Error -->
                    <div id="iso-error" class="hidden py-4 text-center">
                        <div class="w-10 h-10 mx-auto rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center mb-2">
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('frontend.iso_load_error') ?? 'Failed to load ISO images' }}</p>
                        <button onclick="loadIsoImages()" class="mt-2 text-sm text-blue-600 dark:text-blue-400 hover:underline">{{ __('frontend.try_again') ?? 'Try again' }}</button>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:sticky lg:top-6 space-y-6 self-start">
            <!-- Service Timeline -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-5 border-b border-gray-100 dark:border-gray-700">
                    <h2 class="text-base font-semibold text-gray-900 dark:text-white">{{ __('frontend.service_details') }}</h2>
                </div>
                <div class="p-5">
                    <div class="relative">
                        <!-- Timeline Line -->
                        <div class="absolute {{ app()->getLocale() == 'ar' ? 'right-4' : 'left-4' }} top-0 bottom-0 w-px bg-gray-200 dark:bg-gray-700"></div>
                        
                        <!-- Created -->
                        <div class="relative flex items-start gap-4 pb-6">
                            <div class="relative z-10 w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 border-2 border-blue-500 flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ __('frontend.created_at') }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $service->created_at->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-400 dark:text-gray-500">{{ $service->created_at->format('h:i A') }}</div>
                            </div>
                        </div>
                        
                        <!-- Activated -->
                        @if($service->activated_at)
                        <div class="relative flex items-start gap-4 pb-6">
                            <div class="relative z-10 w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-900/30 border-2 border-emerald-500 flex items-center justify-center">
                                <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ __('frontend.activated_at') }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $service->activated_at->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-400 dark:text-gray-500">{{ $service->activated_at->format('h:i A') }}</div>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Next Due -->
                        @if($service->next_due_date)
                        <div class="relative flex items-start gap-4">
                            <div class="relative z-10 w-8 h-8 rounded-full bg-amber-100 dark:bg-amber-900/30 border-2 border-amber-500 flex items-center justify-center">
                                <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ __('frontend.next_due_date') }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($service->next_due_date)->format('M d, Y') }}</div>
                                <div class="text-xs text-amber-600 dark:text-amber-400">{{ \Carbon\Carbon::parse($service->next_due_date)->diffForHumans() }}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Server Activities -->
            @if($service->status === 'active' && $hetznerServerId)
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-4 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="p-1.5 rounded-lg bg-gradient-to-br from-blue-500 to-cyan-600 text-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h2 class="text-sm font-semibold text-gray-900 dark:text-white">{{ __('frontend.server_activities') ?? 'Server Activities' }}</h2>
                        </div>
                        <button onclick="loadActivities()" class="p-1.5 text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-all" title="Refresh">
                            <svg id="refresh-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="max-h-64 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-600 scrollbar-track-transparent" id="activities-container">
                    <!-- Loading State -->
                    <div id="activities-loading" class="p-6 text-center">
                        <div class="inline-flex items-center gap-2 text-gray-500 dark:text-gray-400">
                            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-xs">{{ __('frontend.loading') ?? 'Loading...' }}</span>
                        </div>
                    </div>
                    
                    <!-- Activities List (populated by JS) -->
                    <div id="activities-list" class="hidden divide-y divide-gray-100 dark:divide-gray-700"></div>
                    
                    <!-- Empty State -->
                    <div id="activities-empty" class="hidden p-6 text-center">
                        <div class="w-10 h-10 mx-auto rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mb-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('frontend.no_activities') ?? 'No recent activities' }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Need Help Card -->
            <div class="relative overflow-hidden bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl p-6">
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                        <defs>
                            <pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse">
                                <circle cx="2" cy="2" r="1" fill="currentColor"/>
                            </pattern>
                        </defs>
                        <rect width="100%" height="100%" fill="url(#dots)"/>
                    </svg>
                </div>
                
                <div class="relative">
                    <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">{{ __('frontend.need_help') }}</h3>
                    <p class="text-blue-100 text-sm mb-4">{{ __('frontend.need_help_desc') }}</p>
                    <a href="mailto:support@{{ request()->getHost() }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-blue-600 font-medium text-sm rounded-xl hover:bg-blue-50 transition-colors">
                        {{ __('frontend.contact_support') }}
                        <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Start Server Confirmation Modal -->
<div id="start-modal" class="fixed inset-0 z-50 hidden">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closeStartModal()"></div>
    
    <!-- Modal Content -->
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-lg w-full transform transition-all" onclick="event.stopPropagation()">
            <!-- Header -->
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-4">
                    <div class="p-3 rounded-xl bg-emerald-100 dark:bg-emerald-500/20">
                        <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ __('frontend.confirm_start_title') ?? 'Are you sure you want to start this server?' }}</h3>
                    </div>
                </div>
            </div>
            
            <!-- Body -->
            <div class="p-6 space-y-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('frontend.start_server_description') ?? 'This will power on your server and boot the operating system. The server will be available within a few moments.' }}
                </p>
                <div class="flex items-start gap-3 p-4 bg-emerald-50 dark:bg-emerald-500/10 rounded-xl border border-emerald-200 dark:border-emerald-500/30">
                    <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm text-emerald-700 dark:text-emerald-400">
                        {{ __('frontend.start_billing_note') ?? 'Billing will resume once the server is running.' }}
                    </p>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="p-6 border-t border-gray-200 dark:border-gray-700 flex items-center justify-end gap-3">
                <button onclick="closeStartModal()" 
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl transition-colors">
                    {{ __('frontend.cancel') ?? 'Cancel' }}
                </button>
                <button onclick="confirmStart()" id="modal-start-btn"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-emerald-500 hover:bg-emerald-600 rounded-xl transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ __('frontend.start') ?? 'Start' }}
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Shutdown Confirmation Modal -->
<div id="shutdown-modal" class="fixed inset-0 z-50 hidden">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closeShutdownModal()"></div>
    
    <!-- Modal Content -->
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-lg w-full transform transition-all" onclick="event.stopPropagation()">
            <!-- Header -->
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-4">
                    <div class="p-3 rounded-xl bg-amber-100 dark:bg-amber-500/20">
                        <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ __('frontend.confirm_shutdown_title') ?? 'Are you sure you want to shutdown this server?' }}</h3>
                    </div>
                </div>
            </div>
            
            <!-- Body -->
            <div class="p-6 space-y-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('frontend.shutdown_warning_acpi') ?? 'This will send an ACPI signal to your server. If your server is using a standard configuration, it will do a soft shutdown. If this does not work, this will lead to a hard shutdown of your server.' }}
                </p>
                <div class="flex items-start gap-3 p-4 bg-red-50 dark:bg-red-500/10 rounded-xl border border-red-200 dark:border-red-500/30">
                    <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <p class="text-sm text-red-700 dark:text-red-400 font-medium">
                        {{ __('frontend.shutdown_data_loss_warning') ?? 'This action may cause data loss.' }}
                    </p>
                </div>
                <div class="flex items-start gap-3 p-4 bg-blue-50 dark:bg-blue-500/10 rounded-xl border border-blue-200 dark:border-blue-500/30">
                    <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm text-blue-700 dark:text-blue-400">
                        {{ __('frontend.shutdown_billing_note') ?? 'Please note that we still have to bill powered off servers.' }}
                        <a href="#" class="underline hover:no-underline">{{ __('frontend.see_docs') ?? 'See Docs' }}</a> {{ __('frontend.for_details') ?? 'for details.' }}
                    </p>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="p-6 border-t border-gray-200 dark:border-gray-700 flex items-center justify-end gap-3">
                <button onclick="closeShutdownModal()" 
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl transition-colors">
                    {{ __('frontend.cancel') ?? 'Cancel' }}
                </button>
                <button onclick="confirmShutdown()" id="modal-shutdown-btn"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-amber-500 hover:bg-amber-600 rounded-xl transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/>
                    </svg>
                    {{ __('frontend.shutdown') ?? 'Shutdown' }}
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Power Off Confirmation Modal -->
<div id="poweroff-modal" class="fixed inset-0 z-50 hidden">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closePowerOffModal()"></div>
    
    <!-- Modal Content -->
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-lg w-full transform transition-all" onclick="event.stopPropagation()">
            <!-- Header -->
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-4">
                    <div class="p-3 rounded-xl bg-red-100 dark:bg-red-500/20">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 11-12.728 0M12 3v9"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ __('frontend.confirm_poweroff_title') ?? 'Are you sure you want to power off this server?' }}</h3>
                    </div>
                </div>
            </div>
            
            <!-- Body -->
            <div class="p-6 space-y-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('frontend.poweroff_warning') ?? 'This will immediately cut power to your server without graceful shutdown. This is equivalent to pulling the power cord.' }}
                </p>
                <div class="flex items-start gap-3 p-4 bg-red-50 dark:bg-red-500/10 rounded-xl border border-red-200 dark:border-red-500/30">
                    <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <p class="text-sm text-red-700 dark:text-red-400 font-medium">
                        {{ __('frontend.poweroff_data_loss_warning') ?? 'This action WILL cause data loss if the server has unsaved data!' }}
                    </p>
                </div>
                <div class="flex items-start gap-3 p-4 bg-blue-50 dark:bg-blue-500/10 rounded-xl border border-blue-200 dark:border-blue-500/30">
                    <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm text-blue-700 dark:text-blue-400">
                        {{ __('frontend.shutdown_billing_note') ?? 'Please note that we still have to bill powered off servers.' }}
                        <a href="#" class="underline hover:no-underline">{{ __('frontend.see_docs') ?? 'See Docs' }}</a> {{ __('frontend.for_details') ?? 'for details.' }}
                    </p>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="p-6 border-t border-gray-200 dark:border-gray-700 flex items-center justify-end gap-3">
                <button onclick="closePowerOffModal()" 
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl transition-colors">
                    {{ __('frontend.cancel') ?? 'Cancel' }}
                </button>
                <button onclick="confirmPowerOff()" id="modal-poweroff-btn"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-red-500 hover:bg-red-600 rounded-xl transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 11-12.728 0M12 3v9"/>
                    </svg>
                    {{ __('frontend.power_off') ?? 'Power Off' }}
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div id="toast" class="fixed bottom-4 right-4 transform translate-y-full opacity-0 transition-all duration-300 z-50">
    <div class="bg-gray-900 text-white px-4 py-3 rounded-xl shadow-2xl flex items-center gap-3">
        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        <span id="toast-message">Copied to clipboard!</span>
    </div>
</div>

<!-- Floating IP Modal -->
<div id="floating-ip-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <!-- Backdrop -->
        <div class="fixed inset-0 transition-opacity bg-gray-900/75 backdrop-blur-sm" onclick="closeFloatingIpModal()"></div>
        
        <!-- Modal Content -->
        <div class="relative z-10 w-full max-w-md transform overflow-hidden rounded-2xl bg-white dark:bg-gray-800 text-left shadow-xl transition-all">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        {{ __('frontend.add_floating_ip') ?? 'Add Floating IP' }}
                    </h3>
                    <button onclick="closeFloatingIpModal()" class="p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Body -->
            <div class="px-6 py-5 space-y-4">
                <!-- Pricing Info -->
                <div class="bg-amber-50 dark:bg-amber-900/20 rounded-xl p-4 border border-amber-100 dark:border-amber-800/50">
                    <div class="flex gap-3">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="text-sm">
                            <p class="font-medium text-amber-800 dark:text-amber-300 mb-2">{{ __('frontend.floating_ip_pricing') ?? 'Pricing' }}</p>
                            <ul class="text-amber-700 dark:text-amber-400 space-y-1 text-xs">
                                <li>• <strong>IPv4:</strong> $5/{{ __('frontend.month') ?? 'month' }} ({{ __('frontend.excl_vat') ?? 'excl. VAT' }})</li>
                                <li>• <strong>IPv6:</strong> $3/{{ __('frontend.month') ?? 'month' }} ({{ __('frontend.excl_vat') ?? 'excl. VAT' }})</li>
                            </ul>
                            <p class="text-xs mt-2 text-amber-600 dark:text-amber-500">{{ __('frontend.terms_apply') ?? 'Our terms and conditions apply.' }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Wallet Balance -->
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('frontend.wallet_balance') ?? 'Wallet Balance' }}:</span>
                    <span id="floating-ip-wallet-balance" class="text-sm font-semibold text-gray-900 dark:text-white">$0.00</span>
                </div>
                
                <!-- Insufficient Balance Warning -->
                <div id="floating-ip-insufficient-warning" class="hidden bg-red-50 dark:bg-red-900/20 rounded-xl p-4 border border-red-100 dark:border-red-800/50">
                    <div class="flex gap-3">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div class="text-sm">
                            <p class="font-medium text-red-800 dark:text-red-300">{{ __('frontend.insufficient_balance') ?? 'Insufficient Balance' }}</p>
                            <p class="text-red-700 dark:text-red-400 text-xs mt-1">{{ __('frontend.add_funds_for_floating_ip') ?? 'Please add funds to your wallet to create a floating IP.' }}</p>
                            <a href="{{ route('client.wallet') }}" class="inline-flex items-center gap-1 mt-2 text-xs font-medium text-red-700 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                {{ __('frontend.add_funds') ?? 'Add Funds' }}
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Location Info -->
                <div class="flex items-center gap-2 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-100 dark:border-blue-800/50">
                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="text-xs text-blue-700 dark:text-blue-300">{{ __('frontend.location') ?? 'Location' }}: <strong id="floating-ip-location">--</strong></span>
                    <span class="text-xs text-blue-600 dark:text-blue-400">({{ __('frontend.same_as_server') ?? 'Same as server' }})</span>
                </div>
                
                <!-- Protocol Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('frontend.ip_protocol') ?? 'IP Protocol' }}</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label id="ipv4-label" class="relative flex items-center justify-center p-4 border-2 rounded-xl cursor-pointer transition-all border-amber-500 bg-amber-50 dark:bg-amber-900/20">
                            <input type="radio" name="floating_ip_type" value="ipv4" id="floating-ip-ipv4" class="sr-only" checked onchange="selectFloatingIpType('ipv4')">
                            <div class="text-center">
                                <div class="text-lg font-bold text-gray-900 dark:text-white">IPv4</div>
                                <div class="text-sm text-amber-600 dark:text-amber-400 font-semibold">$5/{{ __('frontend.month') ?? 'month' }}</div>
                            </div>
                            <div id="ipv4-check" class="absolute top-2 right-2">
                                <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </label>
                        <label id="ipv6-label" class="relative flex items-center justify-center p-4 border-2 rounded-xl cursor-pointer transition-all border-gray-200 dark:border-gray-700 hover:border-amber-300 dark:hover:border-amber-700">
                            <input type="radio" name="floating_ip_type" value="ipv6" id="floating-ip-ipv6" class="sr-only" onchange="selectFloatingIpType('ipv6')">
                            <div class="text-center">
                                <div class="text-lg font-bold text-gray-900 dark:text-white">IPv6</div>
                                <div class="text-sm text-amber-600 dark:text-amber-400 font-semibold">$3/{{ __('frontend.month') ?? 'month' }}</div>
                            </div>
                            <div id="ipv6-check" class="absolute top-2 right-2 hidden">
                                <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </label>
                    </div>
                </div>
                
                <!-- Name Input -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('frontend.name') ?? 'Name' }} <span class="text-gray-400">({{ __('frontend.optional') ?? 'Optional' }})</span></label>
                    <input type="text" id="floating-ip-name" class="w-full px-4 py-2.5 text-sm bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent" placeholder="{{ __('frontend.floating_ip_name_placeholder') ?? 'e.g., My Floating IP' }}">
                </div>
            </div>
            
            <!-- Footer -->
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">
                <div class="text-sm">
                    <span class="text-gray-500 dark:text-gray-400">{{ __('frontend.total') ?? 'Total' }}:</span>
                    <span id="floating-ip-total-cost" class="text-lg font-bold text-gray-900 dark:text-white ml-1">$5.00</span>
                    <span class="text-gray-500 dark:text-gray-400">/{{ __('frontend.month') ?? 'month' }}</span>
                </div>
                <div class="flex gap-3">
                    <button onclick="closeFloatingIpModal()" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">
                        {{ __('frontend.cancel') ?? 'Cancel' }}
                    </button>
                    <button onclick="showFloatingIpConfirmation()" id="create-floating-ip-btn" class="px-5 py-2 text-sm font-semibold bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white rounded-xl transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                        {{ __('frontend.add_buy_now') ?? 'Add & Buy Now' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Floating IP Confirmation Modal -->
<div id="floating-ip-confirm-modal" class="fixed inset-0 z-[60] hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm transition-opacity" onclick="closeFloatingIpConfirmation()"></div>
        
        <div class="relative inline-block w-full max-w-md p-6 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-gray-800 shadow-2xl rounded-2xl">
            <!-- Icon -->
            <div class="flex justify-center mb-4">
                <div class="w-16 h-16 rounded-full bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                    <svg class="w-8 h-8 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            
            <!-- Title -->
            <h3 class="text-lg font-bold text-center text-gray-900 dark:text-white mb-2">
                {{ __('frontend.confirm_purchase') ?? 'Confirm Purchase' }}
            </h3>
            
            <!-- Message -->
            <p class="text-center text-gray-600 dark:text-gray-400 mb-4">
                {{ __('frontend.floating_ip_confirm_message') ?? 'You are about to purchase a Floating IP' }}
            </p>
            
            <!-- Details Box -->
            <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-4 mb-6 space-y-2">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('frontend.ip_type') ?? 'IP Type' }}</span>
                    <span id="confirm-ip-type" class="text-sm font-semibold text-gray-900 dark:text-white">IPv4</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('frontend.monthly_cost') ?? 'Monthly Cost' }}</span>
                    <span id="confirm-ip-cost" class="text-sm font-semibold text-amber-600 dark:text-amber-400">$5.00</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('frontend.location') ?? 'Location' }}</span>
                    <span id="confirm-ip-location" class="text-sm font-semibold text-gray-900 dark:text-white">--</span>
                </div>
                <div class="border-t border-gray-200 dark:border-gray-700 pt-2 mt-2">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('frontend.wallet_balance') ?? 'Wallet Balance' }}</span>
                        <span id="confirm-wallet-balance" class="text-sm font-semibold text-emerald-600 dark:text-emerald-400">$0.00</span>
                    </div>
                </div>
            </div>
            
            <!-- Info Text -->
            <p class="text-xs text-center text-gray-500 dark:text-gray-400 mb-4">
                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ __('frontend.floating_ip_charge_info') ?? 'This amount will be charged from your wallet immediately.' }}
            </p>
            
            <!-- Buttons -->
            <div class="flex gap-3">
                <button onclick="closeFloatingIpConfirmation()" class="flex-1 px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl transition-colors">
                    {{ __('frontend.cancel') ?? 'Cancel' }}
                </button>
                <button onclick="confirmCreateFloatingIP()" id="confirm-floating-ip-btn" class="flex-1 px-4 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 rounded-xl transition-all">
                    {{ __('frontend.confirm_purchase') ?? 'Confirm Purchase' }}
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Floating IP Confirmation Modal -->
<div id="delete-floating-ip-modal" class="fixed inset-0 z-[60] hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm transition-opacity" onclick="closeDeleteFloatingIpModal()"></div>
        
        <div class="relative inline-block w-full max-w-sm p-6 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-gray-800 shadow-2xl rounded-2xl">
            <!-- Icon -->
            <div class="flex justify-center mb-4">
                <div class="w-16 h-16 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
            </div>
            
            <!-- Title -->
            <h3 class="text-lg font-bold text-center text-gray-900 dark:text-white mb-2">
                {{ __('frontend.delete_floating_ip') ?? 'Delete Floating IP' }}
            </h3>
            
            <!-- Message -->
            <p class="text-center text-gray-600 dark:text-gray-400 mb-2">
                {{ __('frontend.delete_floating_ip_message') ?? 'Are you sure you want to delete this Floating IP?' }}
            </p>
            
            <!-- IP Address Display -->
            <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-3 mb-4 text-center">
                <span id="delete-floating-ip-address" class="font-mono text-sm font-semibold text-gray-900 dark:text-white">--</span>
            </div>
            
            <!-- Warning -->
            <p class="text-xs text-center text-red-500 dark:text-red-400 mb-4">
                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                {{ __('frontend.action_cannot_be_undone') ?? 'This action cannot be undone.' }}
            </p>
            
            <!-- Buttons -->
            <div class="flex gap-3">
                <button onclick="closeDeleteFloatingIpModal()" class="flex-1 px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl transition-colors">
                    {{ __('frontend.cancel') ?? 'Cancel' }}
                </button>
                <button onclick="confirmDeleteFloatingIP()" id="confirm-delete-floating-ip-btn" class="flex-1 px-4 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 rounded-xl transition-all">
                    {{ __('frontend.delete') ?? 'Delete' }}
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Mount ISO Confirmation Modal -->
<div id="mount-iso-modal" class="fixed inset-0 z-[60] hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm transition-opacity" onclick="closeMountIsoModal()"></div>
        
        <div class="relative inline-block w-full max-w-md p-6 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-gray-800 shadow-2xl rounded-2xl">
            <!-- Icon -->
            <div class="flex justify-center mb-4">
                <div class="w-16 h-16 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke-width="2"/>
                        <circle cx="12" cy="12" r="3" stroke-width="2"/>
                    </svg>
                </div>
            </div>
            
            <!-- Title -->
            <h3 class="text-lg font-bold text-center text-gray-900 dark:text-white mb-2">
                {{ __('frontend.mount_iso_image') ?? 'Mount ISO Image' }}
            </h3>
            
            <!-- Message -->
            <p class="text-center text-gray-600 dark:text-gray-400 mb-4">
                {{ __('frontend.confirm_mount_iso') ?? 'Are you sure you want to mount this ISO image?' }}
            </p>
            
            <!-- ISO Name Display -->
            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4 mb-4 text-center border border-blue-100 dark:border-blue-800">
                <span id="mount-iso-name" class="text-sm font-semibold text-blue-800 dark:text-blue-300">--</span>
            </div>
            
            <!-- Warning Info -->
            <div class="bg-amber-50 dark:bg-amber-900/20 rounded-xl p-3 mb-4 border border-amber-100 dark:border-amber-800">
                <div class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <p class="text-xs text-amber-700 dark:text-amber-300">
                        {{ __('frontend.mount_iso_warning') ?? 'You will need to reboot your server for the changes to take effect. The server will boot from the ISO image after reboot.' }}
                    </p>
                </div>
            </div>
            
            <!-- Buttons -->
            <div class="flex gap-3">
                <button onclick="closeMountIsoModal()" class="flex-1 px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl transition-colors">
                    {{ __('frontend.cancel') ?? 'Cancel' }}
                </button>
                <button onclick="confirmMountIso()" id="confirm-mount-iso-btn" class="flex-1 px-4 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 rounded-xl transition-all">
                    {{ __('frontend.mount') ?? 'Mount' }}
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Unmount ISO Confirmation Modal -->
<div id="unmount-iso-modal" class="fixed inset-0 z-[60] hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm transition-opacity" onclick="closeUnmountIsoModal()"></div>
        
        <div class="relative inline-block w-full max-w-sm p-6 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-gray-800 shadow-2xl rounded-2xl">
            <!-- Icon -->
            <div class="flex justify-center mb-4">
                <div class="w-16 h-16 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
            </div>
            
            <!-- Title -->
            <h3 class="text-lg font-bold text-center text-gray-900 dark:text-white mb-2">
                {{ __('frontend.unmount_iso_image') ?? 'Unmount ISO Image' }}
            </h3>
            
            <!-- Message -->
            <p class="text-center text-gray-600 dark:text-gray-400 mb-4">
                {{ __('frontend.confirm_unmount_iso') ?? 'Are you sure you want to unmount the ISO image?' }}
            </p>
            
            <!-- Buttons -->
            <div class="flex gap-3">
                <button onclick="closeUnmountIsoModal()" class="flex-1 px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl transition-colors">
                    {{ __('frontend.cancel') ?? 'Cancel' }}
                </button>
                <button onclick="confirmUnmountIso()" id="confirm-unmount-iso-btn" class="flex-1 px-4 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 rounded-xl transition-all">
                    {{ __('frontend.unmount') ?? 'Unmount' }}
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function copyToClipboard(text, button) {
    navigator.clipboard.writeText(text).then(() => {
        showToast('{{ __("frontend.copied_to_clipboard") ?? "Copied to clipboard!" }}');
        
        // Animate button
        button.classList.add('scale-90');
        setTimeout(() => button.classList.remove('scale-90'), 150);
    });
}

function showToast(message) {
    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toast-message');
    toastMessage.textContent = message;
    
    toast.classList.remove('translate-y-full', 'opacity-0');
    
    setTimeout(() => {
        toast.classList.add('translate-y-full', 'opacity-0');
    }, 2000);
}

function togglePassword() {
    const input = document.getElementById('root-password');
    const icon = document.getElementById('eye-icon');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`;
    } else {
        input.type = 'password';
        icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
    }
}

// Load server activities
async function loadActivities() {
    const loadingEl = document.getElementById('activities-loading');
    const listEl = document.getElementById('activities-list');
    const emptyEl = document.getElementById('activities-empty');
    const refreshIcon = document.getElementById('refresh-icon');
    
    if (!loadingEl) return;
    
    // Show loading, hide others
    loadingEl.classList.remove('hidden');
    listEl.classList.add('hidden');
    emptyEl.classList.add('hidden');
    
    // Animate refresh icon
    refreshIcon?.classList.add('animate-spin');
    
    try {
        const response = await fetch('{{ route("client.hosting.dedicated.activities", $service->id) }}');
        const data = await response.json();
        
        refreshIcon?.classList.remove('animate-spin');
        loadingEl.classList.add('hidden');
        
        if (data.success && data.activities && data.activities.length > 0) {
            listEl.innerHTML = data.activities.map(activity => renderActivity(activity)).join('');
            listEl.classList.remove('hidden');
        } else {
            emptyEl.classList.remove('hidden');
        }
    } catch (error) {
        console.error('Failed to load activities:', error);
        refreshIcon?.classList.remove('animate-spin');
        loadingEl.classList.add('hidden');
        emptyEl.classList.remove('hidden');
    }
}

function renderActivity(activity) {
    const statusColors = {
        'success': { bg: 'bg-emerald-100 dark:bg-emerald-900/30', text: 'text-emerald-600 dark:text-emerald-400', icon: 'M5 13l4 4L19 7' },
        'running': { bg: 'bg-blue-100 dark:bg-blue-900/30', text: 'text-blue-600 dark:text-blue-400', icon: 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15' },
        'error': { bg: 'bg-red-100 dark:bg-red-900/30', text: 'text-red-600 dark:text-red-400', icon: 'M6 18L18 6M6 6l12 12' }
    };
    
    const status = statusColors[activity.status] || statusColors['running'];
    const commandLabels = {
        'start_server': '{{ __("frontend.start_server") ?? "Start Server" }}',
        'stop_server': '{{ __("frontend.stop_server") ?? "Stop Server" }}',
        'reboot_server': '{{ __("frontend.reboot_server") ?? "Reboot Server" }}',
        'shutdown_server': '{{ __("frontend.shutdown_server") ?? "Shutdown Server" }}',
        'reset_server': '{{ __("frontend.reset_server") ?? "Reset Server" }}',
        'create_server': '{{ __("frontend.create_server") ?? "Create Server" }}',
        'rebuild_server': '{{ __("frontend.rebuild_server") ?? "Rebuild Server" }}',
        'change_type': '{{ __("frontend.change_type") ?? "Change Type" }}',
        'enable_rescue': '{{ __("frontend.enable_rescue") ?? "Enable Rescue Mode" }}',
        'disable_rescue': '{{ __("frontend.disable_rescue") ?? "Disable Rescue Mode" }}',
        'create_image': '{{ __("frontend.create_image") ?? "Create Image" }}',
        'attach_iso': '{{ __("frontend.attach_iso") ?? "Attach ISO" }}',
        'detach_iso': '{{ __("frontend.detach_iso") ?? "Detach ISO" }}',
        'enable_backup': '{{ __("frontend.enable_backup") ?? "Enable Backup" }}',
        'disable_backup': '{{ __("frontend.disable_backup") ?? "Disable Backup" }}',
        'assign_floating_ip': '{{ __("frontend.assign_floating_ip") ?? "Assign Floating IP" }}',
        'unassign_floating_ip': '{{ __("frontend.unassign_floating_ip") ?? "Unassign Floating IP" }}',
    };
    
    const commandLabel = commandLabels[activity.command] || activity.command.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
    const startedAt = new Date(activity.started);
    const timeAgo = getTimeAgo(startedAt);
    
    return `
        <div class="flex items-center gap-4 p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
            <div class="w-10 h-10 rounded-xl ${status.bg} flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 ${status.text} ${activity.status === 'running' ? 'animate-spin' : ''}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${status.icon}"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <div class="text-sm font-medium text-gray-900 dark:text-white">${commandLabel}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">${timeAgo}</div>
            </div>
            <div class="flex-shrink-0">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${status.bg} ${status.text}">
                    ${activity.status.charAt(0).toUpperCase() + activity.status.slice(1)}
                </span>
            </div>
        </div>
    `;
}

function getTimeAgo(date) {
    const seconds = Math.floor((new Date() - date) / 1000);
    
    const intervals = {
        year: 31536000,
        month: 2592000,
        week: 604800,
        day: 86400,
        hour: 3600,
        minute: 60
    };
    
    for (const [unit, secondsInUnit] of Object.entries(intervals)) {
        const interval = Math.floor(seconds / secondsInUnit);
        if (interval >= 1) {
            return interval === 1 ? `1 ${unit} ago` : `${interval} ${unit}s ago`;
        }
    }
    
    return 'Just now';
}

// Load activities and server status on page load
document.addEventListener('DOMContentLoaded', function() {
    @if($service->status === 'active' && $hetznerServerId)
    loadActivities();
    fetchServerStatus();
    @endif
});

// Modal functions
function openStartModal() {
    document.getElementById('start-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeStartModal() {
    document.getElementById('start-modal').classList.add('hidden');
    document.body.style.overflow = '';
}

function openShutdownModal() {
    document.getElementById('shutdown-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeShutdownModal() {
    document.getElementById('shutdown-modal').classList.add('hidden');
    document.body.style.overflow = '';
}

function openPowerOffModal() {
    document.getElementById('poweroff-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closePowerOffModal() {
    document.getElementById('poweroff-modal').classList.add('hidden');
    document.body.style.overflow = '';
}

function confirmStart() {
    closeStartModal();
    executeServerAction('start');
}

function confirmShutdown() {
    closeShutdownModal();
    executeServerAction('stop');
}

function confirmPowerOff() {
    closePowerOffModal();
    executeServerAction('power_off');
}

// Server Action Function
async function serverAction(action) {
    // For start, show modal
    if (action === 'start') {
        openStartModal();
        return;
    }
    
    // For stop, show modal
    if (action === 'stop') {
        openShutdownModal();
        return;
    }
    
    // For power_off, show modal
    if (action === 'power_off') {
        openPowerOffModal();
        return;
    }
    
    // For restart, use simple confirm
    const actionMessages = {
        'restart': '{{ __("frontend.confirm_restart") ?? "Are you sure you want to restart the server?" }}'
    };
    
    if (!confirm(actionMessages[action])) {
        return;
    }
    
    executeServerAction(action);
}

// Execute server action
async function executeServerAction(action) {
    const buttons = ['btn-start', 'btn-stop', 'btn-power-off'];
    const loadingEl = document.getElementById('action-loading');
    
    // Disable all buttons
    buttons.forEach(id => {
        const btn = document.getElementById(id);
        if (btn) btn.disabled = true;
    });
    
    // Show loading
    loadingEl?.classList.remove('hidden');
    loadingEl?.classList.add('inline-flex');
    
    try {
        const response = await fetch('{{ route("client.hosting.dedicated.action", $service->id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ action: action })
        });
        
        const data = await response.json();
        
        // Hide loading
        loadingEl?.classList.add('hidden');
        loadingEl?.classList.remove('inline-flex');
        
        if (data.success) {
            showToast(data.message || '{{ __("frontend.action_executed_successfully") ?? "Action executed successfully" }}');
            // Start polling for status change
            pollServerStatus();
            // Reload activities after action
            setTimeout(() => loadActivities(), 2000);
        } else {
            showToast(data.error || '{{ __("frontend.action_failed") ?? "Action failed" }}', true);
            // Re-fetch status to re-enable appropriate buttons
            fetchServerStatus();
        }
    } catch (error) {
        console.error('Server action failed:', error);
        showToast('{{ __("frontend.action_failed") ?? "Action failed" }}', true);
        // Hide loading
        loadingEl?.classList.add('hidden');
        loadingEl?.classList.remove('inline-flex');
        // Re-fetch status to re-enable appropriate buttons
        fetchServerStatus();
    }
}

// Current server status
let currentServerStatus = 'unknown';
let statusPollInterval = null;

// Fetch server status and update buttons accordingly
async function fetchServerStatus() {
    try {
        const response = await fetch('{{ route("client.hosting.dedicated.status", $service->id) }}');
        const data = await response.json();
        
        if (data.success) {
            currentServerStatus = data.status;
            updateStatusIndicator(data.status);
            updateButtonStates(data.status);
        }
    } catch (error) {
        console.error('Failed to fetch server status:', error);
        updateStatusIndicator('unknown');
    }
}

// Update the status indicator display
function updateStatusIndicator(status) {
    const indicator = document.getElementById('server-status-indicator');
    const statusDot = document.getElementById('status-dot');
    const statusPing = document.getElementById('status-ping');
    const statusText = document.getElementById('status-text');
    
    if (!indicator || !statusDot || !statusText) return;
    
    const statusConfig = {
        'running': {
            bg: 'bg-emerald-500/20',
            border: 'border-emerald-500/30',
            dotColor: 'bg-emerald-500',
            pingColor: 'bg-emerald-400',
            textColor: 'text-emerald-400',
            label: '{{ __("frontend.running") ?? "Running" }}',
            showPing: true
        },
        'starting': {
            bg: 'bg-blue-500/20',
            border: 'border-blue-500/30',
            dotColor: 'bg-blue-500',
            pingColor: 'bg-blue-400',
            textColor: 'text-blue-400',
            label: '{{ __("frontend.starting") ?? "Starting..." }}',
            showPing: true
        },
        'stopping': {
            bg: 'bg-amber-500/20',
            border: 'border-amber-500/30',
            dotColor: 'bg-amber-500',
            pingColor: 'bg-amber-400',
            textColor: 'text-amber-400',
            label: '{{ __("frontend.stopping") ?? "Stopping..." }}',
            showPing: true
        },
        'off': {
            bg: 'bg-gray-500/20',
            border: 'border-gray-500/30',
            dotColor: 'bg-gray-500',
            pingColor: 'bg-gray-400',
            textColor: 'text-gray-400',
            label: '{{ __("frontend.off") ?? "Off" }}',
            showPing: false
        },
        'initializing': {
            bg: 'bg-cyan-500/20',
            border: 'border-cyan-500/30',
            dotColor: 'bg-cyan-500',
            pingColor: 'bg-cyan-400',
            textColor: 'text-cyan-400',
            label: '{{ __("frontend.initializing") ?? "Initializing..." }}',
            showPing: true
        },
        'migrating': {
            bg: 'bg-blue-500/20',
            border: 'border-blue-500/30',
            dotColor: 'bg-blue-500',
            pingColor: 'bg-blue-400',
            textColor: 'text-blue-400',
            label: '{{ __("frontend.migrating") ?? "Migrating..." }}',
            showPing: true
        },
        'rebuilding': {
            bg: 'bg-indigo-500/20',
            border: 'border-indigo-500/30',
            dotColor: 'bg-indigo-500',
            pingColor: 'bg-indigo-400',
            textColor: 'text-indigo-400',
            label: '{{ __("frontend.rebuilding") ?? "Rebuilding..." }}',
            showPing: true
        },
        'unknown': {
            bg: 'bg-gray-500/20',
            border: 'border-gray-500/30',
            dotColor: 'bg-gray-500',
            pingColor: 'bg-gray-400',
            textColor: 'text-gray-400',
            label: '{{ __("frontend.unknown") ?? "Unknown" }}',
            showPing: false
        }
    };
    
    const config = statusConfig[status] || statusConfig['unknown'];
    
    // Reset classes
    indicator.className = `flex items-center gap-2 px-4 py-2 backdrop-blur-sm rounded-xl mr-2 ${config.bg} border ${config.border}`;
    statusDot.className = `relative inline-flex rounded-full h-2.5 w-2.5 ${config.dotColor}`;
    statusPing.className = config.showPing ? `animate-ping absolute inline-flex h-full w-full rounded-full ${config.pingColor} opacity-75` : 'hidden';
    statusText.className = `text-sm font-medium ${config.textColor}`;
    statusText.textContent = config.label;
}

// Update button states based on server status
function updateButtonStates(status) {
    const btnStart = document.getElementById('btn-start');
    const btnStop = document.getElementById('btn-stop');
    const btnPowerOff = document.getElementById('btn-power-off');
    
    // Disable all buttons first
    [btnStart, btnStop, btnPowerOff].forEach(btn => {
        if (btn) btn.disabled = true;
    });
    
    switch(status) {
        case 'running':
            // Server is running: can stop, power off. Cannot start.
            if (btnStop) btnStop.disabled = false;
            if (btnPowerOff) btnPowerOff.disabled = false;
            break;
            
        case 'off':
            // Server is off: can only start
            if (btnStart) btnStart.disabled = false;
            break;
            
        case 'starting':
        case 'stopping':
        case 'initializing':
        case 'migrating':
        case 'rebuilding':
            // Server is in transition: all buttons disabled
            // Already disabled above
            break;
            
        default:
            // Unknown state: allow power off as emergency option
            if (btnPowerOff) btnPowerOff.disabled = false;
            break;
    }
}

// Poll server status during transitions
function pollServerStatus() {
    // Clear any existing interval
    if (statusPollInterval) {
        clearInterval(statusPollInterval);
    }
    
    // Poll every 3 seconds
    statusPollInterval = setInterval(async () => {
        await fetchServerStatus();
        
        // Stop polling if server is in a stable state
        if (['running', 'off'].includes(currentServerStatus)) {
            clearInterval(statusPollInterval);
            statusPollInterval = null;
        }
    }, 3000);
    
    // Stop polling after 2 minutes max
    setTimeout(() => {
        if (statusPollInterval) {
            clearInterval(statusPollInterval);
            statusPollInterval = null;
        }
    }, 120000);
}

// ============================================
// Server Metrics Charts
// ============================================

let cpuChart = null;
let diskChart = null;
let networkChart = null;

// Chart.js default configuration
const chartDefaultOptions = {
    responsive: true,
    maintainAspectRatio: false,
    interaction: {
        intersect: false,
        mode: 'index'
    },
    plugins: {
        legend: {
            display: false
        },
        tooltip: {
            backgroundColor: 'rgba(0, 0, 0, 0.8)',
            titleColor: '#fff',
            bodyColor: '#fff',
            padding: 12,
            cornerRadius: 8,
            displayColors: false
        }
    },
    scales: {
        x: {
            display: true,
            grid: {
                display: false
            },
            ticks: {
                maxTicksLimit: 8,
                color: '#9CA3AF',
                font: {
                    size: 10
                }
            }
        },
        y: {
            display: true,
            beginAtZero: true,
            grid: {
                color: 'rgba(156, 163, 175, 0.1)'
            },
            ticks: {
                color: '#9CA3AF',
                font: {
                    size: 10
                }
            }
        }
    },
    elements: {
        line: {
            tension: 0.4,
            borderWidth: 2
        },
        point: {
            radius: 0,
            hoverRadius: 4
        }
    }
};

// Create gradient for charts
function createGradient(ctx, color) {
    const gradient = ctx.createLinearGradient(0, 0, 0, 160);
    gradient.addColorStop(0, color.replace('rgb', 'rgba').replace(')', ', 0.3)'));
    gradient.addColorStop(1, color.replace('rgb', 'rgba').replace(')', ', 0.0)'));
    return gradient;
}

// Initialize charts
function initCharts() {
    const cpuCtx = document.getElementById('cpu-chart');
    const diskCtx = document.getElementById('disk-chart');
    const networkCtx = document.getElementById('network-chart');
    
    if (!cpuCtx || !diskCtx || !networkCtx) return;
    
    // CPU Chart
    cpuChart = new Chart(cpuCtx.getContext('2d'), {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'CPU %',
                data: [],
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: createGradient(cpuCtx.getContext('2d'), 'rgb(59, 130, 246)'),
                fill: true
            }]
        },
        options: {
            ...chartDefaultOptions,
            scales: {
                ...chartDefaultOptions.scales,
                y: {
                    ...chartDefaultOptions.scales.y,
                    max: 100,
                    ticks: {
                        ...chartDefaultOptions.scales.y.ticks,
                        callback: (value) => value + '%'
                    }
                }
            },
            plugins: {
                ...chartDefaultOptions.plugins,
                tooltip: {
                    ...chartDefaultOptions.plugins.tooltip,
                    callbacks: {
                        label: (context) => `CPU: ${context.parsed.y.toFixed(1)}%`
                    }
                }
            }
        }
    });
    
    // Disk Chart
    diskChart = new Chart(diskCtx.getContext('2d'), {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Disk MB/s',
                data: [],
                borderColor: 'rgb(245, 158, 11)',
                backgroundColor: createGradient(diskCtx.getContext('2d'), 'rgb(245, 158, 11)'),
                fill: true
            }]
        },
        options: {
            ...chartDefaultOptions,
            scales: {
                ...chartDefaultOptions.scales,
                y: {
                    ...chartDefaultOptions.scales.y,
                    ticks: {
                        ...chartDefaultOptions.scales.y.ticks,
                        callback: (value) => value.toFixed(1) + ' MB/s'
                    }
                }
            },
            plugins: {
                ...chartDefaultOptions.plugins,
                tooltip: {
                    ...chartDefaultOptions.plugins.tooltip,
                    callbacks: {
                        label: (context) => `Throughput: ${context.parsed.y.toFixed(2)} MB/s`
                    }
                }
            }
        }
    });
    
    // Network Chart
    networkChart = new Chart(networkCtx.getContext('2d'), {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Network Mbps',
                data: [],
                borderColor: 'rgb(16, 185, 129)',
                backgroundColor: createGradient(networkCtx.getContext('2d'), 'rgb(16, 185, 129)'),
                fill: true
            }]
        },
        options: {
            ...chartDefaultOptions,
            scales: {
                ...chartDefaultOptions.scales,
                y: {
                    ...chartDefaultOptions.scales.y,
                    ticks: {
                        ...chartDefaultOptions.scales.y.ticks,
                        callback: (value) => value.toFixed(1) + ' Mbps'
                    }
                }
            },
            plugins: {
                ...chartDefaultOptions.plugins,
                tooltip: {
                    ...chartDefaultOptions.plugins.tooltip,
                    callbacks: {
                        label: (context) => `Traffic: ${context.parsed.y.toFixed(2)} Mbps`
                    }
                }
            }
        }
    });
}

// Load metrics from API
async function loadMetrics() {
    const loadingEl = document.getElementById('metrics-loading');
    const containerEl = document.getElementById('metrics-container');
    const errorEl = document.getElementById('metrics-error');
    const refreshIcon = document.getElementById('metrics-refresh-icon');
    const periodSelect = document.getElementById('metrics-period');
    
    if (!loadingEl || !containerEl) return;
    
    // Get selected period
    const hours = periodSelect ? periodSelect.value : 24;
    
    // Show loading
    loadingEl.classList.remove('hidden');
    containerEl.classList.add('hidden');
    errorEl?.classList.add('hidden');
    refreshIcon?.classList.add('animate-spin');
    
    try {
        const response = await fetch(`{{ route("client.hosting.dedicated.metrics", $service->id) }}?hours=${hours}`);
        const data = await response.json();
        
        refreshIcon?.classList.remove('animate-spin');
        loadingEl.classList.add('hidden');
        
        if (data.success && data.metrics) {
            containerEl.classList.remove('hidden');
            
            // Initialize charts if not already done
            if (!cpuChart) {
                initCharts();
            }
            
            // Update CPU chart
            if (data.metrics.cpu && cpuChart) {
                cpuChart.data.labels = data.metrics.cpu.labels;
                cpuChart.data.datasets[0].data = data.metrics.cpu.data;
                cpuChart.update('none');
                
                // Update current value
                const cpuCurrent = document.getElementById('cpu-current');
                if (cpuCurrent && data.metrics.cpu.data.length > 0) {
                    const lastValue = data.metrics.cpu.data[data.metrics.cpu.data.length - 1];
                    cpuCurrent.textContent = lastValue.toFixed(1) + '%';
                }
            }
            
            // Update Disk chart (convert bytes/s to MB/s)
            if (data.metrics.disk && diskChart) {
                diskChart.data.labels = data.metrics.disk.labels;
                diskChart.data.datasets[0].data = data.metrics.disk.data.map(v => v / 1024 / 1024);
                diskChart.update('none');
                
                // Update current value
                const diskCurrent = document.getElementById('disk-current');
                if (diskCurrent && data.metrics.disk.data.length > 0) {
                    const lastValue = data.metrics.disk.data[data.metrics.disk.data.length - 1] / 1024 / 1024;
                    diskCurrent.textContent = lastValue.toFixed(2) + ' MB/s';
                }
            }
            
            // Update Network chart (convert bytes/s to Mbps)
            if (data.metrics.network && networkChart) {
                networkChart.data.labels = data.metrics.network.labels;
                networkChart.data.datasets[0].data = data.metrics.network.data.map(v => (v * 8) / 1024 / 1024);
                networkChart.update('none');
                
                // Update current value
                const networkCurrent = document.getElementById('network-current');
                if (networkCurrent && data.metrics.network.data.length > 0) {
                    const lastValue = (data.metrics.network.data[data.metrics.network.data.length - 1] * 8) / 1024 / 1024;
                    networkCurrent.textContent = lastValue.toFixed(2) + ' Mbps';
                }
            }
        } else {
            errorEl?.classList.remove('hidden');
        }
    } catch (error) {
        console.error('Failed to load metrics:', error);
        refreshIcon?.classList.remove('animate-spin');
        loadingEl.classList.add('hidden');
        errorEl?.classList.remove('hidden');
    }
}

// Load backups from API
async function loadBackups() {
    const loadingEl = document.getElementById('backups-loading');
    const contentEl = document.getElementById('backups-content');
    const errorEl = document.getElementById('backups-error');
    const disabledEl = document.getElementById('backups-disabled');
    const enabledEl = document.getElementById('backups-enabled');
    
    if (!loadingEl || !contentEl) return;
    
    // Show loading
    loadingEl.classList.remove('hidden');
    contentEl.classList.add('hidden');
    errorEl?.classList.add('hidden');
    
    try {
        const response = await fetch(`{{ route("client.hosting.dedicated.backups", $service->id) }}`);
        const data = await response.json();
        
        loadingEl.classList.add('hidden');
        
        if (data.success) {
            contentEl.classList.remove('hidden');
            
            if (data.backups_enabled) {
                // Show enabled state
                disabledEl?.classList.add('hidden');
                enabledEl?.classList.remove('hidden');
                
                // Update backup window
                const windowText = document.getElementById('backup-window-text');
                if (windowText && data.backup_window) {
                    windowText.textContent = `{{ __('frontend.backup_window') ?? 'Backup Window' }}: ${data.backup_window}`;
                }
                
                // Update backup count
                const countEl = document.getElementById('backup-count');
                if (countEl) {
                    countEl.textContent = data.backups.length;
                }
                
                // Render backups list
                const listEl = document.getElementById('backups-list');
                const noBackupsEl = document.getElementById('no-backups');
                
                if (listEl) {
                    if (data.backups.length > 0) {
                        noBackupsEl?.classList.add('hidden');
                        listEl.innerHTML = data.backups.map(backup => `
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">${backup.description || 'Backup #' + backup.id}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">${new Date(backup.created).toLocaleDateString()} ${new Date(backup.created).toLocaleTimeString()}</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xs font-medium ${backup.status === 'available' ? 'text-emerald-600 dark:text-emerald-400' : 'text-amber-600 dark:text-amber-400'}">${backup.status}</div>
                                    <div class="text-xs text-gray-400">${(backup.image_size / 1024).toFixed(1)} GB</div>
                                </div>
                            </div>
                        `).join('');
                    } else {
                        noBackupsEl?.classList.remove('hidden');
                        listEl.innerHTML = '';
                    }
                }
            } else {
                // Show disabled state
                disabledEl?.classList.remove('hidden');
                enabledEl?.classList.add('hidden');
                
                // Load backup cost info
                loadBackupCost();
            }
        } else {
            errorEl?.classList.remove('hidden');
        }
    } catch (error) {
        console.error('Failed to load backups:', error);
        loadingEl.classList.add('hidden');
        errorEl?.classList.remove('hidden');
    }
}

// Backup cost data
let backupCostData = null;

// Load backup cost info
async function loadBackupCost() {
    try {
        const response = await fetch(`{{ route("client.hosting.dedicated.backups.cost", $service->id) }}`);
        const data = await response.json();
        
        if (data.success) {
            backupCostData = data;
            
            // Update price display
            const priceEl = document.getElementById('backup-price-display');
            if (priceEl) {
                priceEl.textContent = '$' + data.backup_cost.toFixed(2);
            }
            
            // Update billing cycle display
            const cycleEl = document.getElementById('backup-cycle-display');
            if (cycleEl) {
                const cycleLabels = {
                    'monthly': '{{ __("frontend.monthly") ?? "Monthly" }}',
                    'quarterly': '{{ __("frontend.quarterly") ?? "Quarterly" }}',
                    'semi-annually': '{{ __("frontend.semi_annually") ?? "Semi-Annually" }}',
                    'semiannually': '{{ __("frontend.semi_annually") ?? "Semi-Annually" }}',
                    'annually': '{{ __("frontend.annually") ?? "Annually" }}',
                    'yearly': '{{ __("frontend.annually") ?? "Annually" }}',
                    'biennially': '{{ __("frontend.biennially") ?? "Biennially" }}',
                    'triennially': '{{ __("frontend.triennially") ?? "Triennially" }}'
                };
                cycleEl.textContent = cycleLabels[data.billing_cycle] || data.billing_cycle;
            }
            
            // Update wallet balance display
            const balanceEl = document.getElementById('wallet-balance-display');
            if (balanceEl) {
                balanceEl.textContent = '$' + data.wallet_balance.toFixed(2);
                balanceEl.className = data.has_sufficient_balance 
                    ? 'font-semibold text-emerald-600 dark:text-emerald-400' 
                    : 'font-semibold text-red-600 dark:text-red-400';
            }
            
            // Show/hide insufficient balance warning
            const warningEl = document.getElementById('insufficient-balance-warning');
            const btn = document.getElementById('enable-backups-btn');
            
            if (!data.has_sufficient_balance) {
                warningEl?.classList.remove('hidden');
                if (btn) {
                    btn.disabled = true;
                    btn.classList.add('opacity-50', 'cursor-not-allowed');
                }
            } else {
                warningEl?.classList.add('hidden');
                if (btn) {
                    btn.disabled = false;
                    btn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }
        }
    } catch (error) {
        console.error('Failed to load backup cost:', error);
    }
}

// Enable backups
async function enableBackups() {
    const btn = document.getElementById('enable-backups-btn');
    if (!btn || btn.disabled) return;
    
    // Check if we have cost data and sufficient balance
    if (backupCostData && !backupCostData.has_sufficient_balance) {
        showNotification('error', '{{ __("frontend.insufficient_balance") ?? "Insufficient balance" }}');
        return;
    }
    
    // Confirm before charging
    const cost = backupCostData ? backupCostData.backup_cost.toFixed(2) : '?';
    if (!confirm(`{{ __("frontend.confirm_enable_backup") ?? "Enable backups for $" }}${cost}{{ __("frontend.confirm_enable_backup_suffix") ?? "? This amount will be charged from your wallet." }}`)) {
        return;
    }
    
    // Disable button and show loading
    btn.disabled = true;
    btn.innerHTML = `
        <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span>{{ __('frontend.enabling_backups') ?? 'Enabling backups...' }}</span>
    `;
    
    try {
        const response = await fetch(`{{ route("client.hosting.dedicated.backups.enable", $service->id) }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        const data = await response.json();
        
        if (data.success) {
            // Show success with charged amount
            const message = data.charged_amount 
                ? `{{ __("frontend.backups_enabled_charged") ?? "Backups enabled! $" }}${data.charged_amount.toFixed(2)}{{ __("frontend.charged_from_wallet") ?? " charged from your wallet." }}`
                : '{{ __("frontend.backups_enabled_success") ?? "Backups enabled successfully!" }}';
            showNotification('success', message);
            loadBackups();
        } else if (data.insufficient_balance) {
            // Show insufficient balance error
            showNotification('error', `{{ __("frontend.need_funds") ?? "Insufficient balance. You need $" }}${data.required_amount.toFixed(2)}{{ __("frontend.current_balance_is") ?? ". Current balance: $" }}${data.current_balance.toFixed(2)}`);
            // Refresh cost data
            loadBackupCost();
            // Reset button
            resetEnableButton(btn);
        } else {
            showNotification('error', data.error || '{{ __("frontend.backup_enable_error") ?? "Failed to enable backups" }}');
            resetEnableButton(btn);
        }
    } catch (error) {
        console.error('Failed to enable backups:', error);
        showNotification('error', '{{ __("frontend.backup_enable_error") ?? "Failed to enable backups" }}');
        resetEnableButton(btn);
    }
}

// Reset enable backup button
function resetEnableButton(btn) {
    btn.disabled = false;
    btn.innerHTML = `
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
        </svg>
        <span>{{ __('frontend.enable_backups') ?? 'Enable Backups' }}</span>
    `;
}

// Simple notification function
function showNotification(type, message) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all transform ${
        type === 'success' 
            ? 'bg-emerald-500 text-white' 
            : 'bg-red-500 text-white'
    }`;
    notification.innerHTML = `
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                ${type === 'success' 
                    ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>'
                    : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>'
                }
            </svg>
            <span>${message}</span>
        </div>
    `;
    document.body.appendChild(notification);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        notification.classList.add('opacity-0', 'translate-x-full');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// ==================== SNAPSHOTS ====================

// Snapshot cost data
let snapshotCostData = null;

// Load snapshots from API
async function loadSnapshots() {
    const loadingEl = document.getElementById('snapshots-loading');
    const contentEl = document.getElementById('snapshots-content');
    const errorEl = document.getElementById('snapshots-error');
    
    if (!loadingEl || !contentEl) return;
    
    // Show loading
    loadingEl.classList.remove('hidden');
    contentEl.classList.add('hidden');
    errorEl?.classList.add('hidden');
    
    try {
        // Load cost first
        await loadSnapshotCost();
        
        const response = await fetch(`{{ route("client.hosting.dedicated.snapshots", $service->id) }}`);
        const data = await response.json();
        
        loadingEl.classList.add('hidden');
        
        if (data.success) {
            contentEl.classList.remove('hidden');
            
            const listContainer = document.getElementById('snapshots-list-container');
            const listEl = document.getElementById('snapshots-list');
            const noSnapshotsEl = document.getElementById('no-snapshots');
            
            if (data.snapshots && data.snapshots.length > 0) {
                listContainer?.classList.remove('hidden');
                noSnapshotsEl?.classList.add('hidden');
                
                if (listEl) {
                    listEl.innerHTML = data.snapshots.map(snapshot => {
                        const billingInfo = snapshot.billing_info || {};
                        const nextCharge = billingInfo.next_charge_date 
                            ? new Date(billingInfo.next_charge_date).toLocaleDateString() 
                            : '--';
                        
                        return `
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">${snapshot.description || 'Snapshot #' + snapshot.id}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">${new Date(snapshot.created).toLocaleDateString()} ${new Date(snapshot.created).toLocaleTimeString()}</div>
                                        <div class="text-xs text-blue-600 dark:text-blue-400">{{ __('frontend.next_renewal') ?? 'Next renewal' }}: ${nextCharge}</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="text-right">
                                        <div class="text-xs font-medium ${snapshot.status === 'available' ? 'text-emerald-600 dark:text-emerald-400' : 'text-amber-600 dark:text-amber-400'}">${snapshot.status}</div>
                                        <div class="text-xs text-gray-400">${parseFloat(snapshot.image_size || 0).toFixed(1)} GB</div>
                                    </div>
                                    <button onclick="deleteSnapshot(${snapshot.id})" class="p-1.5 text-red-500 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors" title="{{ __('frontend.delete') ?? 'Delete' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        `;
                    }).join('');
                }
            } else {
                listContainer?.classList.add('hidden');
                noSnapshotsEl?.classList.remove('hidden');
            }
        } else {
            errorEl?.classList.remove('hidden');
        }
    } catch (error) {
        console.error('Failed to load snapshots:', error);
        loadingEl.classList.add('hidden');
        errorEl?.classList.remove('hidden');
    }
}

// Load snapshot cost info
async function loadSnapshotCost() {
    try {
        const response = await fetch(`{{ route("client.hosting.dedicated.snapshots.cost", $service->id) }}`);
        const data = await response.json();
        
        if (data.success) {
            snapshotCostData = data;
            
            // Update disk size display
            const diskSizeEl = document.getElementById('snapshot-disk-size-display');
            if (diskSizeEl) {
                diskSizeEl.textContent = data.disk_size + ' GB';
            }
            
            // Update price display
            const priceEl = document.getElementById('snapshot-price-display');
            if (priceEl) {
                priceEl.textContent = '$' + data.snapshot_cost.toFixed(2) + '/{{ __("frontend.month") ?? "month" }}';
            }
            
            // Update wallet balance display
            const balanceEl = document.getElementById('snapshot-wallet-balance-display');
            if (balanceEl) {
                balanceEl.textContent = '$' + data.wallet_balance.toFixed(2);
                balanceEl.className = data.has_sufficient_balance 
                    ? 'font-semibold text-emerald-600 dark:text-emerald-400' 
                    : 'font-semibold text-red-600 dark:text-red-400';
            }
            
            // Show/hide insufficient balance warning
            const warningEl = document.getElementById('snapshot-insufficient-balance-warning');
            const btn = document.getElementById('create-snapshot-btn');
            
            if (!data.has_sufficient_balance) {
                warningEl?.classList.remove('hidden');
                if (btn) {
                    btn.disabled = true;
                    btn.classList.add('opacity-50', 'cursor-not-allowed');
                }
            } else {
                warningEl?.classList.add('hidden');
                if (btn) {
                    btn.disabled = false;
                    btn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }
        }
    } catch (error) {
        console.error('Failed to load snapshot cost:', error);
    }
}

// Create snapshot
async function createSnapshot() {
    const btn = document.getElementById('create-snapshot-btn');
    if (!btn || btn.disabled) return;
    
    // Check if we have cost data and sufficient balance
    if (snapshotCostData && !snapshotCostData.has_sufficient_balance) {
        showNotification('error', '{{ __("frontend.insufficient_balance") ?? "Insufficient balance" }}');
        return;
    }
    
    // Confirm before charging
    const cost = snapshotCostData ? snapshotCostData.snapshot_cost.toFixed(2) : '?';
    if (!confirm(`{{ __("frontend.confirm_create_snapshot") ?? "Create a snapshot for $" }}${cost}{{ __("frontend.confirm_create_snapshot_suffix") ?? "/month? This amount will be charged from your wallet." }}`)) {
        return;
    }
    
    // Disable button and show loading
    btn.disabled = true;
    btn.innerHTML = `
        <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span>{{ __('frontend.creating_snapshot') ?? 'Creating snapshot...' }}</span>
    `;
    
    try {
        const response = await fetch(`{{ route("client.hosting.dedicated.snapshots.create", $service->id) }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        const data = await response.json();
        
        if (data.success) {
            // Show success with charged amount
            const message = data.charged_amount 
                ? `{{ __("frontend.snapshot_created_charged") ?? "Snapshot created! $" }}${data.charged_amount.toFixed(2)}{{ __("frontend.charged_from_wallet") ?? " charged from your wallet." }}`
                : '{{ __("frontend.snapshot_created_success") ?? "Snapshot created successfully!" }}';
            showNotification('success', message);
            
            // Reload snapshots list
            loadSnapshots();
        } else if (data.insufficient_balance) {
            // Show insufficient balance error
            showNotification('error', `{{ __("frontend.need_funds") ?? "Insufficient balance. You need $" }}${data.required_amount.toFixed(2)}{{ __("frontend.current_balance_is") ?? ". Current balance: $" }}${data.current_balance.toFixed(2)}`);
            // Refresh cost data
            loadSnapshotCost();
            // Reset button
            resetSnapshotButton(btn);
        } else {
            showNotification('error', data.error || '{{ __("frontend.snapshot_create_error") ?? "Failed to create snapshot" }}');
            resetSnapshotButton(btn);
        }
    } catch (error) {
        console.error('Failed to create snapshot:', error);
        showNotification('error', '{{ __("frontend.snapshot_create_error") ?? "Failed to create snapshot" }}');
        resetSnapshotButton(btn);
    }
}

// Delete snapshot
async function deleteSnapshot(snapshotId) {
    if (!confirm('{{ __("frontend.confirm_delete_snapshot") ?? "Are you sure you want to delete this snapshot? This action cannot be undone." }}')) {
        return;
    }
    
    try {
        const response = await fetch(`{{ url('/services/dedicated/' . $service->id . '/snapshots') }}/${snapshotId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        const data = await response.json();
        
        if (data.success) {
            showNotification('success', '{{ __("frontend.snapshot_deleted_success") ?? "Snapshot deleted successfully!" }}');
            loadSnapshots();
        } else {
            showNotification('error', data.error || '{{ __("frontend.snapshot_delete_error") ?? "Failed to delete snapshot" }}');
        }
    } catch (error) {
        console.error('Failed to delete snapshot:', error);
        showNotification('error', '{{ __("frontend.snapshot_delete_error") ?? "Failed to delete snapshot" }}');
    }
}

// Reset snapshot button
function resetSnapshotButton(btn) {
    btn.disabled = false;
    btn.innerHTML = `
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        <span>{{ __('frontend.take_snapshot') ?? 'Take Snapshot' }}</span>
    `;
}

// ==================== NETWORK ====================

// Network data
let networkData = null;

// Load network info from API
async function loadNetwork() {
    const loadingEl = document.getElementById('network-loading');
    const contentEl = document.getElementById('network-content');
    const errorEl = document.getElementById('network-error');
    
    if (!loadingEl || !contentEl) return;
    
    // Show loading
    loadingEl.classList.remove('hidden');
    contentEl.classList.add('hidden');
    errorEl?.classList.add('hidden');
    
    try {
        const response = await fetch(`{{ route("client.hosting.dedicated.network", $service->id) }}`);
        const data = await response.json();
        
        loadingEl.classList.add('hidden');
        
        if (data.success) {
            networkData = data;
            contentEl.classList.remove('hidden');
            
            // Update IPv4
            const ipv4Address = document.getElementById('ipv4-address');
            const ipv4DnsPtr = document.getElementById('ipv4-dns-ptr');
            if (ipv4Address && data.ipv4) {
                ipv4Address.textContent = data.ipv4;
            }
            if (ipv4DnsPtr && data.ipv4_dns_ptr) {
                ipv4DnsPtr.value = data.ipv4_dns_ptr;
            }
            
            // Update IPv6
            const ipv6Address = document.getElementById('ipv6-address');
            const ipv6DnsPtr = document.getElementById('ipv6-dns-ptr');
            if (ipv6Address && data.ipv6) {
                ipv6Address.textContent = data.ipv6;
                ipv6Address.title = data.ipv6;
            }
            if (ipv6DnsPtr && data.ipv6_dns_ptr) {
                ipv6DnsPtr.value = data.ipv6_dns_ptr;
            }
            
            // Update floating IPs list
            renderFloatingIps(data.floating_ips || []);
            
            // Update modal wallet balance
            const modalBalance = document.getElementById('floating-ip-wallet-balance');
            if (modalBalance) {
                modalBalance.textContent = '$' + (data.wallet_balance || 0).toFixed(2);
            }
            
            // Update modal location
            const locationEl = document.getElementById('floating-ip-location');
            if (locationEl && data.location) {
                locationEl.textContent = data.location.toUpperCase();
            }
            
        } else {
            errorEl?.classList.remove('hidden');
        }
    } catch (error) {
        console.error('Failed to load network:', error);
        loadingEl.classList.add('hidden');
        errorEl?.classList.remove('hidden');
    }
}

// Render floating IPs list
function renderFloatingIps(floatingIps) {
    const listEl = document.getElementById('floating-ips-list');
    const noFloatingIpsEl = document.getElementById('no-floating-ips');
    
    if (!listEl) return;
    
    if (floatingIps.length > 0) {
        noFloatingIpsEl?.classList.add('hidden');
        listEl.innerHTML = floatingIps.map(fip => {
            const billingInfo = fip.billing_info || {};
            const nextCharge = billingInfo.next_charge_date 
                ? new Date(billingInfo.next_charge_date).toLocaleDateString() 
                : '--';
            const ipType = fip.type.toUpperCase();
            const cost = fip.type === 'ipv4' ? '$5' : '$3';
            
            return `
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg ${fip.type === 'ipv4' ? 'bg-blue-100 dark:bg-blue-900/30' : 'bg-indigo-100 dark:bg-indigo-900/30'} flex items-center justify-center">
                            <svg class="w-4 h-4 ${fip.type === 'ipv4' ? 'text-blue-600 dark:text-blue-400' : 'text-indigo-600 dark:text-indigo-400'}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="px-1.5 py-0.5 text-xs font-medium ${fip.type === 'ipv4' ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300'} rounded">${ipType}</span>
                                <span class="font-mono text-sm text-gray-900 dark:text-white">${fip.ip}</span>
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                ${cost}/{{ __('frontend.month') ?? 'month' }} • {{ __('frontend.next_renewal') ?? 'Next renewal' }}: ${nextCharge}
                            </div>
                        </div>
                    </div>
                    <button onclick="showDeleteFloatingIpModal(${fip.id}, '${fip.ip}')" class="p-1.5 text-red-500 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors" title="{{ __('frontend.delete') ?? 'Delete' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
            `;
        }).join('');
    } else {
        noFloatingIpsEl?.classList.remove('hidden');
        listEl.innerHTML = '';
    }
}

// Update reverse DNS
async function updateReverseDns(ipVersion) {
    const ipEl = document.getElementById(`${ipVersion}-address`);
    const dnsPtrEl = document.getElementById(`${ipVersion}-dns-ptr`);
    
    if (!ipEl || !dnsPtrEl) return;
    
    const ip = ipEl.textContent.trim();
    const dnsPtr = dnsPtrEl.value.trim();
    
    // Validate IP is not empty or placeholder
    if (!ip || ip === '--' || ip === '') {
        showNotification('error', '{{ __("frontend.ip_not_available") ?? "IP address not available" }}');
        return;
    }
    
    // Validate dns_ptr is a valid domain name or empty
    if (dnsPtr && !/^[a-zA-Z0-9]([a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(\.[a-zA-Z0-9]([a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/.test(dnsPtr)) {
        showNotification('error', '{{ __("frontend.invalid_domain_name") ?? "Please enter a valid domain name" }}');
        return;
    }
    
    try {
        const response = await fetch(`{{ route("client.hosting.dedicated.network.reverse-dns", $service->id) }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ ip, dns_ptr: dnsPtr || null })
        });
        const data = await response.json();
        
        if (data.success) {
            showNotification('success', '{{ __("frontend.reverse_dns_updated") ?? "Reverse DNS updated successfully!" }}');
        } else {
            showNotification('error', data.error || '{{ __("frontend.reverse_dns_error") ?? "Failed to update reverse DNS" }}');
        }
    } catch (error) {
        console.error('Failed to update reverse DNS:', error);
        showNotification('error', '{{ __("frontend.reverse_dns_error") ?? "Failed to update reverse DNS" }}');
    }
}

// Open floating IP modal
function openFloatingIpModal() {
    const modal = document.getElementById('floating-ip-modal');
    if (modal) {
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        updateFloatingIpCost();
    }
}

// Close floating IP modal
function closeFloatingIpModal() {
    const modal = document.getElementById('floating-ip-modal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
}

// Select floating IP type (IPv4 or IPv6)
function selectFloatingIpType(type) {
    const ipv4Label = document.getElementById('ipv4-label');
    const ipv6Label = document.getElementById('ipv6-label');
    const ipv4Check = document.getElementById('ipv4-check');
    const ipv6Check = document.getElementById('ipv6-check');
    const ipv4Radio = document.getElementById('floating-ip-ipv4');
    const ipv6Radio = document.getElementById('floating-ip-ipv6');
    
    if (type === 'ipv4') {
        // Select IPv4
        ipv4Radio.checked = true;
        ipv4Label.classList.remove('border-gray-200', 'dark:border-gray-700');
        ipv4Label.classList.add('border-amber-500', 'bg-amber-50', 'dark:bg-amber-900/20');
        ipv4Check.classList.remove('hidden');
        
        // Deselect IPv6
        ipv6Radio.checked = false;
        ipv6Label.classList.remove('border-amber-500', 'bg-amber-50', 'dark:bg-amber-900/20');
        ipv6Label.classList.add('border-gray-200', 'dark:border-gray-700');
        ipv6Check.classList.add('hidden');
    } else {
        // Select IPv6
        ipv6Radio.checked = true;
        ipv6Label.classList.remove('border-gray-200', 'dark:border-gray-700');
        ipv6Label.classList.add('border-amber-500', 'bg-amber-50', 'dark:bg-amber-900/20');
        ipv6Check.classList.remove('hidden');
        
        // Deselect IPv4
        ipv4Radio.checked = false;
        ipv4Label.classList.remove('border-amber-500', 'bg-amber-50', 'dark:bg-amber-900/20');
        ipv4Label.classList.add('border-gray-200', 'dark:border-gray-700');
        ipv4Check.classList.add('hidden');
    }
    
    // Update cost display
    updateFloatingIpCost();
}

// Update floating IP cost display
function updateFloatingIpCost() {
    const selectedType = document.querySelector('input[name="floating_ip_type"]:checked')?.value || 'ipv4';
    const cost = selectedType === 'ipv4' ? 5 : 3;
    
    const costEl = document.getElementById('floating-ip-total-cost');
    if (costEl) {
        costEl.textContent = '$' + cost.toFixed(2);
    }
    
    // Check wallet balance
    const walletBalance = networkData?.wallet_balance || 0;
    const warningEl = document.getElementById('floating-ip-insufficient-warning');
    const btn = document.getElementById('create-floating-ip-btn');
    
    if (walletBalance < cost) {
        warningEl?.classList.remove('hidden');
        if (btn) {
            btn.disabled = true;
            btn.classList.add('opacity-50', 'cursor-not-allowed');
        }
    } else {
        warningEl?.classList.add('hidden');
        if (btn) {
            btn.disabled = false;
            btn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }
}

// Show floating IP confirmation popup
function showFloatingIpConfirmation() {
    const btn = document.getElementById('create-floating-ip-btn');
    if (!btn || btn.disabled) return;
    
    const selectedType = document.querySelector('input[name="floating_ip_type"]:checked')?.value || 'ipv4';
    const cost = selectedType === 'ipv4' ? 5 : 3;
    const walletBalance = networkData?.wallet_balance || 0;
    const location = networkData?.location || '--';
    
    // Update confirmation modal details
    document.getElementById('confirm-ip-type').textContent = selectedType.toUpperCase();
    document.getElementById('confirm-ip-cost').textContent = '$' + cost.toFixed(2);
    document.getElementById('confirm-ip-location').textContent = location;
    document.getElementById('confirm-wallet-balance').textContent = '$' + walletBalance.toFixed(2);
    
    // Show confirmation modal
    const modal = document.getElementById('floating-ip-confirm-modal');
    if (modal) {
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
}

// Close floating IP confirmation popup
function closeFloatingIpConfirmation() {
    const modal = document.getElementById('floating-ip-confirm-modal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
}

// Confirm and create floating IP
async function confirmCreateFloatingIP() {
    const confirmBtn = document.getElementById('confirm-floating-ip-btn');
    if (!confirmBtn) return;
    
    const selectedType = document.querySelector('input[name="floating_ip_type"]:checked')?.value || 'ipv4';
    const name = document.getElementById('floating-ip-name')?.value || '';
    const cost = selectedType === 'ipv4' ? 5 : 3;
    
    // Disable button and show loading
    confirmBtn.disabled = true;
    const originalText = confirmBtn.innerHTML;
    confirmBtn.innerHTML = `
        <svg class="w-5 h-5 animate-spin inline-block mr-1" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        {{ __('frontend.creating') ?? 'Creating...' }}
    `;
    
    try {
        const response = await fetch(`{{ route("client.hosting.dedicated.network.floating-ip.create", $service->id) }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ type: selectedType, name })
        });
        const data = await response.json();
        
        if (data.success) {
            showNotification('success', `{{ __("frontend.floating_ip_created_charged") ?? "Floating IP created! $" }}${data.charged_amount.toFixed(2)}{{ __("frontend.charged_from_wallet") ?? " charged from your wallet." }}`);
            closeFloatingIpConfirmation();
            closeFloatingIpModal();
            loadNetwork();
        } else if (data.insufficient_balance) {
            showNotification('error', `{{ __("frontend.need_funds") ?? "Insufficient balance. You need $" }}${data.required_amount.toFixed(2)}{{ __("frontend.current_balance_is") ?? ". Current balance: $" }}${data.current_balance.toFixed(2)}`);
            confirmBtn.disabled = false;
            confirmBtn.innerHTML = originalText;
        } else {
            showNotification('error', data.error || '{{ __("frontend.floating_ip_create_error") ?? "Failed to create floating IP" }}');
            confirmBtn.disabled = false;
            confirmBtn.innerHTML = originalText;
        }
    } catch (error) {
        console.error('Failed to create floating IP:', error);
        showNotification('error', '{{ __("frontend.floating_ip_create_error") ?? "Failed to create floating IP" }}');
        confirmBtn.disabled = false;
        confirmBtn.innerHTML = originalText;
    }
}

// Floating IP to delete
let floatingIpToDelete = null;

// Show delete floating IP confirmation modal
function showDeleteFloatingIpModal(floatingIpId, ipAddress) {
    floatingIpToDelete = floatingIpId;
    
    // Update IP address display
    document.getElementById('delete-floating-ip-address').textContent = ipAddress || 'Floating IP #' + floatingIpId;
    
    // Show modal
    const modal = document.getElementById('delete-floating-ip-modal');
    if (modal) {
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
}

// Close delete floating IP modal
function closeDeleteFloatingIpModal() {
    const modal = document.getElementById('delete-floating-ip-modal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
    floatingIpToDelete = null;
}

// Confirm delete floating IP
async function confirmDeleteFloatingIP() {
    if (!floatingIpToDelete) return;
    
    const btn = document.getElementById('confirm-delete-floating-ip-btn');
    if (!btn) return;
    
    // Disable button and show loading
    btn.disabled = true;
    const originalText = btn.innerHTML;
    btn.innerHTML = `
        <svg class="w-5 h-5 animate-spin inline-block" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    `;
    
    try {
        const response = await fetch(`{{ url('/services/dedicated/' . $service->id . '/network/floating-ip') }}/${floatingIpToDelete}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        const data = await response.json();
        
        if (data.success) {
            showNotification('success', '{{ __("frontend.floating_ip_deleted_success") ?? "Floating IP deleted successfully!" }}');
            closeDeleteFloatingIpModal();
            loadNetwork();
        } else {
            showNotification('error', data.error || '{{ __("frontend.floating_ip_delete_error") ?? "Failed to delete floating IP" }}');
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    } catch (error) {
        console.error('Failed to delete floating IP:', error);
        showNotification('error', '{{ __("frontend.floating_ip_delete_error") ?? "Failed to delete floating IP" }}');
        btn.disabled = false;
        btn.innerHTML = originalText;
    }
}

// Load metrics on page load
document.addEventListener('DOMContentLoaded', function() {
    // Load metrics after a short delay
    setTimeout(loadMetrics, 500);
    
    // Load backups
    setTimeout(loadBackups, 600);
    
    // Load snapshots
    setTimeout(loadSnapshots, 700);
    
    // Load network
    setTimeout(loadNetwork, 800);
    
    // Load ISO images
    setTimeout(loadIsoImages, 900);
});

// ISO Images Data
let isoImagesData = [];
let mountedIso = null;

// Load ISO images from API
async function loadIsoImages() {
    const loadingEl = document.getElementById('iso-loading');
    const listEl = document.getElementById('iso-images-list');
    const emptyEl = document.getElementById('iso-empty');
    const errorEl = document.getElementById('iso-error');
    const mountedSection = document.getElementById('mounted-iso-section');
    
    if (!loadingEl) return;
    
    // Show loading
    loadingEl.classList.remove('hidden');
    listEl?.classList.add('hidden');
    emptyEl?.classList.add('hidden');
    errorEl?.classList.add('hidden');
    mountedSection?.classList.add('hidden');
    
    try {
        const response = await fetch(`{{ route("client.hosting.dedicated.iso-images", $service->id) }}`);
        const data = await response.json();
        
        loadingEl.classList.add('hidden');
        
        if (data.success) {
            isoImagesData = data.iso_images || [];
            mountedIso = data.mounted_iso;
            
            // Show mounted ISO if any
            if (mountedIso) {
                mountedSection?.classList.remove('hidden');
                document.getElementById('mounted-iso-name').textContent = mountedIso.name || mountedIso.description || 'ISO #' + mountedIso.id;
            }
            
            // Render ISO images list
            if (isoImagesData.length > 0) {
                listEl?.classList.remove('hidden');
                renderIsoImages();
            } else {
                emptyEl?.classList.remove('hidden');
            }
        } else {
            errorEl?.classList.remove('hidden');
        }
    } catch (error) {
        console.error('Failed to load ISO images:', error);
        loadingEl.classList.add('hidden');
        errorEl?.classList.remove('hidden');
    }
}

// Render ISO images list
function renderIsoImages() {
    const container = document.getElementById('iso-images-container');
    if (!container || !isoImagesData.length) return;
    
    // Group by type/category
    const grouped = {};
    isoImagesData.forEach(iso => {
        // Extract OS name from description (e.g., "Ubuntu 22.04" from "Ubuntu 22.04 LTS")
        const osName = iso.name?.split('-')[0] || iso.description?.split(' ')[0] || 'Other';
        if (!grouped[osName]) {
            grouped[osName] = [];
        }
        grouped[osName].push(iso);
    });
    
    let html = '';
    
    Object.keys(grouped).sort().forEach(osName => {
        const images = grouped[osName];
        images.forEach(iso => {
            const isMounted = mountedIso && mountedIso.id === iso.id;
            const isDeprecated = iso.deprecated !== null;
            
            html += `
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800/50 transition-colors ${isDeprecated ? 'opacity-60' : ''}">
                    <div class="flex items-center gap-3 flex-1 min-w-0">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" stroke-width="2"/>
                                <circle cx="12" cy="12" r="3" stroke-width="2"/>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-medium text-gray-900 dark:text-white truncate">${iso.name || iso.description}</span>
                                ${isMounted ? '<span class="px-1.5 py-0.5 text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded">{{ __("frontend.mounted") ?? "Mounted" }}</span>' : ''}
                                ${isDeprecated ? '<span class="px-1.5 py-0.5 text-xs font-medium bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 rounded">{{ __("frontend.deprecated") ?? "Deprecated" }}</span>' : ''}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 truncate">${iso.description || ''}</div>
                        </div>
                    </div>
                    <div class="flex-shrink-0 ml-2">
                        ${isMounted ? `
                            <button onclick="unmountIso()" class="px-3 py-1.5 text-xs font-medium text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/30 hover:bg-red-100 dark:hover:bg-red-900/50 rounded-lg transition-colors">
                                {{ __('frontend.unmount') ?? 'Unmount' }}
                            </button>
                        ` : `
                            <button onclick="mountIso(${iso.id}, '${(iso.name || iso.description || '').replace(/'/g, "\\'")}')" class="px-3 py-1.5 text-xs font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30 hover:bg-blue-100 dark:hover:bg-blue-900/50 rounded-lg transition-colors">
                                {{ __('frontend.mount') ?? 'Mount' }}
                            </button>
                        `}
                    </div>
                </div>
            `;
        });
    });
    
    container.innerHTML = html;
}

// ISO to mount
let isoToMount = { id: null, name: null };

// Show mount ISO modal
function mountIso(isoId, isoName) {
    isoToMount = { id: isoId, name: isoName };
    
    // Update modal display
    document.getElementById('mount-iso-name').textContent = isoName || 'ISO #' + isoId;
    
    // Show modal
    const modal = document.getElementById('mount-iso-modal');
    if (modal) {
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
}

// Close mount ISO modal
function closeMountIsoModal() {
    const modal = document.getElementById('mount-iso-modal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
    isoToMount = { id: null, name: null };
}

// Confirm mount ISO
async function confirmMountIso() {
    if (!isoToMount.id) return;
    
    const btn = document.getElementById('confirm-mount-iso-btn');
    if (!btn) return;
    
    // Disable button and show loading
    btn.disabled = true;
    const originalText = btn.innerHTML;
    btn.innerHTML = `
        <svg class="w-5 h-5 animate-spin inline-block" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    `;
    
    try {
        const response = await fetch(`{{ route("client.hosting.dedicated.iso-images.mount", $service->id) }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ iso_id: isoToMount.id })
        });
        const data = await response.json();
        
        if (data.success) {
            showNotification('success', '{{ __("frontend.iso_mounted_success") ?? "ISO image mounted successfully! Reboot your server to boot from it." }}');
            closeMountIsoModal();
            loadIsoImages();
        } else {
            showNotification('error', data.error || '{{ __("frontend.iso_mount_error") ?? "Failed to mount ISO image" }}');
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    } catch (error) {
        console.error('Failed to mount ISO:', error);
        showNotification('error', '{{ __("frontend.iso_mount_error") ?? "Failed to mount ISO image" }}');
        btn.disabled = false;
        btn.innerHTML = originalText;
    }
}

// Show unmount ISO modal
function unmountIso() {
    const modal = document.getElementById('unmount-iso-modal');
    if (modal) {
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
}

// Close unmount ISO modal
function closeUnmountIsoModal() {
    const modal = document.getElementById('unmount-iso-modal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
}

// Confirm unmount ISO
async function confirmUnmountIso() {
    const btn = document.getElementById('confirm-unmount-iso-btn');
    if (!btn) return;
    
    // Disable button and show loading
    btn.disabled = true;
    const originalText = btn.innerHTML;
    btn.innerHTML = `
        <svg class="w-5 h-5 animate-spin inline-block" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    `;
    
    try {
        const response = await fetch(`{{ route("client.hosting.dedicated.iso-images.unmount", $service->id) }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        const data = await response.json();
        
        if (data.success) {
            showNotification('success', '{{ __("frontend.iso_unmounted_success") ?? "ISO image unmounted successfully!" }}');
            closeUnmountIsoModal();
            loadIsoImages();
        } else {
            showNotification('error', data.error || '{{ __("frontend.iso_unmount_error") ?? "Failed to unmount ISO image" }}');
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    } catch (error) {
        console.error('Failed to unmount ISO:', error);
        showNotification('error', '{{ __("frontend.iso_unmount_error") ?? "Failed to unmount ISO image" }}');
        btn.disabled = false;
        btn.innerHTML = originalText;
    }
}

// Open VNC Console
function openConsole() {
    try {
        const consoleWindow = window.open(
            '{{ route("client.hosting.dedicated.console", $service->id) }}', 
            'Dedicated_Console', 
            'width=1200,height=800,menubar=no,toolbar=no,location=no,status=no'
        );
        if (!consoleWindow) {
            showNotification('error', '{{ __("frontend.popup_blocked") ?? "Please allow popups to open the console" }}');
        }
    } catch (error) {
        console.error('Error opening console:', error);
        showNotification('error', '{{ __("frontend.console_error") ?? "An error occurred while opening console" }}');
    }
}
</script>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
@endpush
@endsection
