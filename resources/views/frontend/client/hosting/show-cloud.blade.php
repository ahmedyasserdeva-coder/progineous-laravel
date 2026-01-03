@extends('frontend.client.layout')

@section('title', $service->domain . ' - ' . config('app.name'))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50/30 to-purple-50/20 dark:from-gray-900 dark:via-blue-900/10 dark:to-purple-900/10 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Cancellation Request Notice -->
        @if($service->cancellation_requested_at)
        <div class="bg-orange-100 dark:bg-orange-900/30 border-l-4 border-orange-500 rounded-lg p-4 mb-6 shadow-md">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-orange-800 dark:text-orange-200 mb-1">
                        {{ __('frontend.cancellation_pending') ?? 'Cancellation Request Pending' }}
                    </h3>
                    <p class="text-sm text-orange-700 dark:text-orange-300 mb-2">
                        {{ __('frontend.cancellation_submitted_on') ?? 'Cancellation request submitted on' }}: 
                        <strong>{{ \Carbon\Carbon::parse($service->cancellation_requested_at)->format('M d, Y \a\t h:i A') }}</strong>
                    </p>
                    <p class="text-sm text-orange-600 dark:text-orange-400">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ __('frontend.cancellation_processing_notice') ?? 'Your request is being processed. Expected processing time: 24 hours.' }}
                    </p>
                </div>
            </div>
        </div>
        @endif

        <!-- Service Header with Enhanced Design -->
        <div class="relative bg-gradient-to-r from-blue-600 via-blue-700 to-purple-600 rounded-2xl shadow-2xl p-8 mb-8 overflow-hidden">
            <div class="relative flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="flex items-center gap-5">
                    <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-lg border border-white/30">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-2 tracking-tight">{{ $service->domain }}</h1>
                        <p class="text-blue-100 text-base flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                            </svg>
                            {{ $service->service_name }}
                        </p>
                    </div>
                </div>
                
                <div class="flex items-center gap-3">
                    @if($service->status === 'active')
                        <span class="px-5 py-2.5 bg-green-500 text-white text-sm font-semibold rounded-xl shadow-lg flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            {{ __('frontend.active') }}
                        </span>
                        
                        @if($service->username)
                        <a href="{{ route('client.hosting.cpanel', $service->id) }}" target="_blank" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white hover:bg-blue-50 text-blue-600 font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                            {{ __('frontend.open_cpanel') ?? 'Open cPanel' }}
                        </a>
                        @endif
                    @elseif($service->status === 'pending')
                        <span class="px-5 py-2.5 bg-orange-500 text-white text-sm font-semibold rounded-xl shadow-lg flex items-center gap-2">
                            <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            {{ __('frontend.pending') }}
                        </span>
                    @elseif($service->status === 'suspended')
                        <span class="px-5 py-2.5 bg-red-500 text-white text-sm font-semibold rounded-xl shadow-lg flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"></path>
                            </svg>
                            {{ __('frontend.suspended') }}
                        </span>
                    @endif
                </div>
            </div>
            
            <!-- Service Information Cards -->
            @if($service->username && $service->status === 'active')
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- cPanel Username -->
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-blue-200 uppercase tracking-wide mb-1">cPanel Username</p>
                            <p class="text-sm font-semibold text-white truncate">{{ $service->username }}</p>
                        </div>
                        <button onclick="copyToClipboard('{{ $service->username }}', this)" class="text-white/70 hover:text-white transition-colors" title="Copy">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Hostname -->
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-blue-200 uppercase tracking-wide mb-1">Hostname</p>
                            <p class="text-sm font-semibold text-white truncate">{{ $service->server->hostname ?? 'N/A' }}</p>
                        </div>
                        @if($service->server && $service->server->hostname)
                        <button onclick="copyToClipboard('{{ $service->server->hostname }}', this)" class="text-white/70 hover:text-white transition-colors" title="Copy">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                        </button>
                        @endif
                    </div>
                </div>
                
                <!-- DNS Nameservers -->
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-blue-200 uppercase tracking-wide mb-1">DNS Nameservers</p>
                            @if($service->server && $service->server->nameserver1)
                            <p class="text-xs font-medium text-white truncate">{{ $service->server->nameserver1 }}</p>
                            @if($service->server->nameserver2)
                            <p class="text-xs font-medium text-white truncate">{{ $service->server->nameserver2 }}</p>
                            @endif
                            @else
                            <p class="text-sm font-semibold text-white">N/A</p>
                            @endif
                        </div>
                        @if($service->server && $service->server->nameserver1)
                        <button onclick="copyNameservers()" class="text-white/70 hover:text-white transition-colors" title="Copy">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Statistics Section with Charts -->
        @if($service->username && $service->status === 'active')
        <div class="mb-8">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">{{ __('frontend.usage_statistics') ?? 'Usage Statistics' }}</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Disk Usage Chart -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('frontend.disk_usage') ?? 'Disk Usage' }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-center" style="height: 140px;">
                        <canvas id="diskChart"></canvas>
                    </div>
                    <div class="mt-4 text-center">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white" id="diskUsageText">--</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" id="diskUsageDetails">{{ __('frontend.loading') ?? 'Loading...' }}</p>
                    </div>
                </div>

                <!-- Bandwidth Chart -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('frontend.bandwidth') ?? 'Bandwidth' }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-center" style="height: 140px;">
                        <canvas id="bandwidthChart"></canvas>
                    </div>
                    <div class="mt-4 text-center">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white" id="bandwidthText">--</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" id="bandwidthDetails">{{ __('frontend.loading') ?? 'Loading...' }}</p>
                    </div>
                </div>

                <!-- Addon Domains Chart -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('frontend.addon_domains') ?? 'Addon Domains' }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-center" style="height: 140px;">
                        <canvas id="domainsChart"></canvas>
                    </div>
                    <div class="mt-4 text-center">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white" id="domainsText">--</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" id="domainsDetails">{{ __('frontend.loading') ?? 'Loading...' }}</p>
                    </div>
                </div>

                <!-- Email Accounts Chart -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('frontend.email_accounts') ?? 'Email Accounts' }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-center" style="height: 140px;">
                        <canvas id="emailsChart"></canvas>
                    </div>
                    <div class="mt-4 text-center">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white" id="emailsText">--</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" id="emailsDetails">{{ __('frontend.loading') ?? 'Loading...' }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Main Content Grid - Two Columns -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Left Column -->
            <div class="space-y-6">
                
                <!-- Service Details Card -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <button onclick="toggleServiceDetails()" class="w-full bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between hover:from-blue-100 hover:to-purple-100 dark:hover:from-blue-900/30 dark:hover:to-purple-900/30 transition-colors">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ __('frontend.service_details') ?? 'Service Details' }}
                        </h2>
                        <svg id="service-details-icon" class="w-5 h-5 text-gray-500 dark:text-gray-400 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div id="service-details-content" class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">{{ __('frontend.domain') }}</p>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $service->domain }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">{{ __('frontend.status') }}</p>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ ucfirst($service->status) }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">{{ __('frontend.created_date') }}</p>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $service->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            @if($service->next_due_date)
                            <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">{{ __('frontend.next_due_date') }}</p>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($service->next_due_date)->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            @if($service->username)
                            <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-4 border border-gray-200 dark:border-gray-700 md:col-span-2">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">{{ __('frontend.username') ?? 'Username' }}</p>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white font-mono">{{ $service->username }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Change cPanel Password Card -->
                @if($service->username && $service->status === 'active')
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <button onclick="togglePasswordSection()" class="w-full bg-gradient-to-r from-green-50 to-teal-50 dark:from-green-900/20 dark:to-teal-900/20 px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between hover:from-green-100 hover:to-teal-100 dark:hover:from-green-900/30 dark:hover:to-teal-900/30 transition-colors">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                            </svg>
                            {{ __('frontend.change_cpanel_password') ?? 'Change cPanel Password' }}
                        </h2>
                        <svg id="password-section-icon" class="w-5 h-5 text-gray-500 dark:text-gray-400 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div id="password-section-content" class="p-6">
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-4">
                            <p class="text-sm text-blue-800 dark:text-blue-200 flex items-start gap-2">
                                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ __('frontend.password_change_info') ?? 'Your new password must be at least 8 characters long and contain uppercase, lowercase, numbers, and special characters.' }}</span>
                            </p>
                        </div>

                        <form id="changePasswordForm" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('frontend.new_password') ?? 'New Password' }} <span class="text-red-500">*</span>
                                </label>
                                <div class="flex gap-2">
                                    <div class="relative flex-1">
                                        <input type="password" id="newPassword" class="w-full px-4 py-3 pr-12 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 dark:bg-gray-700 dark:text-white" placeholder="{{ __('frontend.enter_new_password') ?? 'Enter new password' }}" required>
                                        <button type="button" onclick="togglePasswordVisibility('newPassword', 'newPasswordIcon')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                                            <svg id="newPasswordIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <button type="button" onclick="generateStrongPassword()" class="px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors whitespace-nowrap flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                        <span class="hidden sm:inline">{{ __('frontend.generate') ?? 'Generate' }}</span>
                                    </button>
                                </div>
                                <p id="passwordStrength" class="text-xs mt-1"></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('frontend.confirm_password') ?? 'Confirm Password' }} <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="password" id="confirmPassword" class="w-full px-4 py-3 pr-12 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 dark:bg-gray-700 dark:text-white" placeholder="{{ __('frontend.confirm_new_password') ?? 'Confirm new password' }}" required>
                                    <button type="button" onclick="togglePasswordVisibility('confirmPassword', 'confirmPasswordIcon')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                                        <svg id="confirmPasswordIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                </div>
                                <p id="passwordMatchError" class="text-xs text-red-600 dark:text-red-400 mt-1" style="display: none;">{{ __('frontend.passwords_not_match') ?? 'Passwords do not match' }}</p>
                            </div>

                            <div id="passwordChangeError" class="hidden bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-3">
                                <p class="text-sm text-red-800 dark:text-red-200"></p>
                            </div>

                            <div id="passwordChangeSuccess" class="hidden bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-3">
                                <p class="text-sm text-green-800 dark:text-green-200"></p>
                            </div>

                            <div class="flex gap-3 justify-end">
                                <button type="button" onclick="resetPasswordForm()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium rounded-lg transition-colors">
                                    {{ __('frontend.reset') ?? 'Reset' }}
                                </button>
                                <button type="submit" id="changePasswordBtn" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                                    {{ __('frontend.change_password') ?? 'Change Password' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @endif

                <!-- Domains Manager -->
                @if($service->username && $service->status === 'active')
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <button onclick="toggleDomainsSection()" class="w-full bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between hover:from-purple-100 hover:to-pink-100 dark:hover:from-purple-900/30 dark:hover:to-pink-900/30 transition-colors">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                            </svg>
                            {{ __('frontend.domains_manager') ?? 'Domains Manager' }}
                        </h2>
                        <svg id="domains-section-icon" class="w-5 h-5 text-gray-500 dark:text-gray-400 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div id="domains-section-content" class="collapsible-content collapsed p-6">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ __('frontend.manage_domains') ?? 'Manage your domains and subdomains' }}</p>
                        
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-blue-900 dark:text-blue-300 mb-1">
                                        {{ __('frontend.domains_info_title') ?? 'Domain Management' }}
                                    </p>
                                    <p class="text-xs text-blue-700 dark:text-blue-400">
                                        {{ __('frontend.domains_info_desc') ?? 'Manage your addon domains, subdomains, and domain redirects through cPanel. Click the button below to access the domains manager.' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <a href="{{ route('client.hosting.cpanel.domains', $service->id) }}" target="_blank" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-medium rounded-lg transition-all shadow-md hover:shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                {{ __('frontend.open_domains_manager') ?? 'Open Domains Manager' }}
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                
                <!-- Email Accounts -->
                @if($service->username && $service->status === 'active')
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <button onclick="toggleEmailSection()" class="w-full bg-gradient-to-r from-indigo-50 to-blue-50 dark:from-indigo-900/20 dark:to-blue-900/20 px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between hover:from-indigo-100 hover:to-blue-100 dark:hover:from-indigo-900/30 dark:hover:to-blue-900/30 transition-colors">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            {{ __('frontend.email_accounts') ?? 'Email Accounts' }}
                        </h2>
                        <svg id="email-section-icon" class="w-5 h-5 text-gray-500 dark:text-gray-400 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div id="email-section-content" class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('frontend.manage_email_accounts') ?? 'Manage your email accounts' }}</p>
                            <button onclick="openCreateEmailModal()" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                {{ __('frontend.create_email') ?? 'Create Email' }}
                            </button>
                        </div>

                        <div id="emailAccountsLoading" class="text-center py-8">
                            <svg class="animate-spin h-8 w-8 mx-auto text-indigo-600" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">{{ __('frontend.loading') ?? 'Loading...' }}</p>
                        </div>

                        <div id="emailAccountsList" class="hidden space-y-3"></div>

                        <div id="noEmailAccounts" class="hidden text-center py-8">
                            <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('frontend.no_email_accounts') ?? 'No email accounts found' }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- FTP Accounts -->
                @if($service->username && $service->status === 'active')
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <button onclick="toggleFtpSection()" class="w-full bg-gradient-to-r from-orange-50 to-amber-50 dark:from-orange-900/20 dark:to-amber-900/20 px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between hover:from-orange-100 hover:to-amber-100 dark:hover:from-orange-900/30 dark:hover:to-amber-900/30 transition-colors">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                            </svg>
                            {{ __('frontend.ftp_accounts') ?? 'FTP Accounts' }}
                        </h2>
                        <svg id="ftp-section-icon" class="w-5 h-5 text-gray-500 dark:text-gray-400 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div id="ftp-section-content" class="collapsible-content collapsed p-6">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ __('frontend.manage_ftp_accounts') ?? 'Manage your FTP accounts' }}</p>
                        
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-blue-900 dark:text-blue-300 mb-1">
                                        {{ __('frontend.ftp_info_title') ?? 'FTP Access Information' }}
                                    </p>
                                    <p class="text-xs text-blue-700 dark:text-blue-400">
                                        {{ __('frontend.ftp_info_desc') ?? 'FTP accounts can be managed through your cPanel. Click the button below to access cPanel and manage your FTP accounts.' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <a href="{{ route('client.hosting.cpanel.ftp', $service->id) }}" target="_blank" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white font-medium rounded-lg transition-all shadow-md hover:shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                {{ __('frontend.manage_in_cpanel') ?? 'Manage in cPanel' }}
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Database Wizard -->
                @if($service->username && $service->status === 'active')
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <button onclick="toggleDatabaseSection()" class="w-full bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between hover:from-green-100 hover:to-emerald-100 dark:hover:from-green-900/30 dark:hover:to-emerald-900/30 transition-colors">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                            </svg>
                            {{ __('frontend.database_wizard') ?? 'Database Wizard' }}
                        </h2>
                        <svg id="database-section-icon" class="w-5 h-5 text-gray-500 dark:text-gray-400 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div id="database-section-content" class="collapsible-content collapsed p-6">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ __('frontend.manage_databases') ?? 'Create and manage your databases' }}</p>
                        
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-blue-900 dark:text-blue-300 mb-1">
                                        {{ __('frontend.database_info_title') ?? 'Database Management' }}
                                    </p>
                                    <p class="text-xs text-blue-700 dark:text-blue-400">
                                        {{ __('frontend.database_info_desc') ?? 'Use the Database Wizard in cPanel to easily create MySQL databases, database users, and assign privileges. Click the button below to access the wizard.' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <a href="{{ route('client.hosting.cpanel.database', $service->id) }}" target="_blank" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-medium rounded-lg transition-all shadow-md hover:shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                {{ __('frontend.open_database_wizard') ?? 'Open Database Wizard' }}
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Quick Access Tools Section -->
        @if($service->username && $service->status === 'active')
        <div class="mt-8">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">{{ __('frontend.quick_access_tools') ?? 'Quick Access Tools' }}</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- File Manager -->
                <a href="{{ route('client.hosting.file.manager', $service->id) }}" target="_blank" class="group bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl border border-gray-200 dark:border-gray-700 p-6 transition-all duration-200 hover:-translate-y-1">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white truncate">{{ __('frontend.file_manager') ?? 'File Manager' }}</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ __('frontend.manage_files') ?? 'Manage your files' }}</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>

                <!-- Databases -->
                <a href="{{ route('client.hosting.databases', $service->id) }}" target="_blank" class="group bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl border border-gray-200 dark:border-gray-700 p-6 transition-all duration-200 hover:-translate-y-1">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white truncate">{{ __('frontend.databases') ?? 'Databases' }}</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ __('frontend.mysql_databases') ?? 'MySQL Databases' }}</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-green-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>

                <!-- Email Accounts -->
                <a href="{{ route('client.hosting.cpanel.email.accounts', $service->id) }}" target="_blank" class="group bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl border border-gray-200 dark:border-gray-700 p-6 transition-all duration-200 hover:-translate-y-1">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white truncate">{{ __('frontend.email_accounts') ?? 'Email Accounts' }}</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ __('frontend.manage_emails') ?? 'Manage email accounts' }}</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-indigo-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>

                <!-- PHP Selector -->
                <a href="{{ route('client.hosting.php.selector', $service->id) }}" target="_blank" class="group bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl border border-gray-200 dark:border-gray-700 p-6 transition-all duration-200 hover:-translate-y-1">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white truncate">{{ __('frontend.php_selector') ?? 'PHP Selector' }}</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ __('frontend.php_version') ?? 'PHP Version & Settings' }}</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-purple-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>

                <!-- WordPress -->
                <a href="{{ route('client.hosting.wordpress', $service->id) }}" target="_blank" class="group bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl border border-gray-200 dark:border-gray-700 p-6 transition-all duration-200 hover:-translate-y-1">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.158 12.786l-2.698 7.84c.806.236 1.657.365 2.54.365 1.047 0 2.05-.18 2.986-.51-.024-.037-.046-.078-.065-.123l-2.763-7.572zm-5.203 3.644l3.157-9.143.015-.042c-.74.108-1.44.29-2.094.541l-.126.058-.488 8.586zM9.566 5.945l3.346 9.17 1.017-2.787c.44-1.21.782-2.074.782-2.82 0-1.08-.388-1.826-.718-2.403-.44-.718-.854-1.326-.854-2.042 0-.801.608-1.547 1.466-1.547.038 0 .075.005.112.008-.779-1.14-2.04-1.89-3.465-1.89-1.792 0-3.367 1.14-4.24 2.843.12.004.235.006.343.006.56 0 1.43-.068 1.43-.068.29-.017.323.408.034.442 0 0-.291.034-.615.05l1.956 5.815 1.175-3.524-.836-2.29c-.29-.017-.564-.052-.564-.052-.29-.017-.257-.458.034-.442 0 0 .88.068 1.405.068.56 0 1.43-.068 1.43-.068.29-.017.323.408.034.442 0 0-.292.034-.615.05l1.94 5.768.536-1.787c.233-.748.41-1.285.41-1.748 0-.64-.232-1.08-.43-1.423-.265-.43-.515-.796-.515-1.226 0-.48.365-.927.88-.927.025 0 .048.003.072.005l.006-.002c-.835-1.083-2.08-1.78-3.48-1.78-1.58 0-2.964.893-3.685 2.198.102.003.2.005.29.005.557 0 1.419-.068 1.419-.068.29-.017.323.408.034.442 0 0-.291.034-.615.05l1.956 5.815.85-2.54z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white truncate">{{ __('frontend.wordpress') ?? 'WordPress' }}</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ __('frontend.wp_manager') ?? 'WordPress Manager' }}</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-cyan-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>

                <!-- ModSecurity -->
                <a href="{{ route('client.hosting.modsecurity', $service->id) }}" target="_blank" class="group bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl border border-gray-200 dark:border-gray-700 p-6 transition-all duration-200 hover:-translate-y-1">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white truncate">{{ __('frontend.modsecurity') ?? 'ModSecurity' }}</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ __('frontend.security_settings') ?? 'Security Settings' }}</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-red-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>

                <!-- Sitejet Builder -->
                <a href="{{ route('client.hosting.sitejet', $service->id) }}" target="_blank" class="group bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl border border-gray-200 dark:border-gray-700 p-6 transition-all duration-200 hover:-translate-y-1">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-pink-600 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white truncate">{{ __('frontend.sitejet_builder') ?? 'Sitejet Builder' }}</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ __('frontend.website_builder') ?? 'Website Builder' }}</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-pink-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>

                <!-- Sitepad -->
                <a href="{{ route('client.hosting.sitepad', $service->id) }}" target="_blank" class="group bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl border border-gray-200 dark:border-gray-700 p-6 transition-all duration-200 hover:-translate-y-1">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white truncate">{{ __('frontend.sitepad') ?? 'Sitepad' }}</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ __('frontend.site_builder') ?? 'Site Builder' }}</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-orange-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>

                <!-- Social Media -->
                <a href="{{ route('client.hosting.social', $service->id) }}" target="_blank" class="group bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl border border-gray-200 dark:border-gray-700 p-6 transition-all duration-200 hover:-translate-y-1">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-teal-600 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white truncate">{{ __('frontend.social_media') ?? 'Social Media' }}</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ __('frontend.social_tools') ?? 'Social Media Tools' }}</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-teal-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>
            </div>
        </div>
        @endif

        <!-- Request Cancellation Button -->
        <div class="mt-8 flex justify-start">
            @if($service->cancellation_requested_at)
            <button disabled class="inline-flex items-center gap-2 px-6 py-3 bg-gray-400 cursor-not-allowed text-white font-semibold rounded-xl opacity-60">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ __('frontend.cancellation_requested') ?? 'Cancellation Requested' }}
            </button>
            @else
            <button onclick="openCancellationModal()" class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                {{ __('frontend.request_cancellation') ?? 'Request Cancellation' }}
            </button>
            @endif
        </div>

        <!-- Cancellation Confirmation Modal -->
        <div id="cancellationModal" style="background-color: rgba(0, 0, 0, 0.8);" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full transform transition-all">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            {{ __('frontend.confirm_cancellation_title') ?? 'Confirm Cancellation' }}
                        </h3>
                        <button onclick="closeCancellationModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
            <div id="modalStep1" class="space-y-4">
                <p class="text-gray-600 dark:text-gray-400">
                    {{ __('frontend.cancellation_warning') ?? 'Are you sure you want to cancel this service? A verification code will be sent to your email.' }}
                </p>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('frontend.cancellation_reason_label') ?? 'Reason for Cancellation' }} <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="cancellationReasonSelect" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:text-white appearance-none bg-no-repeat" style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%236b7280%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-position: right 0.75rem center; background-size: 1.5em 1.5em; padding-right: 2.5rem; padding-left: 1rem;">
                            <option value="">{{ __('frontend.select_reason') ?? 'Select a reason' }}</option>
                        <option value="too_expensive">{{ __('frontend.reason_too_expensive') ?? 'Too expensive' }}</option>
                        <option value="switching_provider">{{ __('frontend.reason_switching_provider') ?? 'Switching to another provider' }}</option>
                        <option value="not_satisfied">{{ __('frontend.reason_not_satisfied') ?? 'Not satisfied with service' }}</option>
                        <option value="technical_issues">{{ __('frontend.reason_technical_issues') ?? 'Technical issues' }}</option>
                        <option value="no_longer_needed">{{ __('frontend.reason_no_longer_needed') ?? 'No longer needed' }}</option>
                        <option value="other">{{ __('frontend.reason_other') ?? 'Other' }}</option>
                        </select>
                    </div>
                    <p id="reasonError" style="display: none;" class="text-sm text-red-600 dark:text-red-400 mt-2">{{ __('frontend.reason_required') ?? 'Please select a reason' }}</p>
                </div>
                
                <div id="otherReasonField" style="display: none;">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('frontend.please_specify') ?? 'Please specify' }} <span class="text-red-500">*</span>
                    </label>
                    <textarea id="otherReasonText" rows="3" placeholder="{{ __('frontend.enter_reason') ?? 'Enter your reason here...' }}" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:text-white resize-none"></textarea>
                    <p id="otherReasonError" style="display: none;" class="text-sm text-red-600 dark:text-red-400 mt-2">{{ __('frontend.other_reason_required') ?? 'Please enter your reason' }}</p>
                </div>
                
                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                    <p class="text-sm text-yellow-800 dark:text-yellow-200">
                        <strong>{{ __('frontend.note') ?? 'Note' }}:</strong> {{ __('frontend.cancellation_note') ?? 'Your service will remain active until the end of the billing period.' }}
                    </p>
                </div>
                <div class="flex gap-3 justify-end">
                    <button onclick="closeCancellationModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium rounded-lg transition-colors">
                        {{ __('frontend.cancel') ?? 'Cancel' }}
                    </button>
                    <button onclick="sendVerificationCode()" id="sendCodeBtn" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                        {{ __('frontend.send_code') ?? 'Send Verification Code' }}
                    </button>
                </div>
            </div>                    <div id="modalStep2" class="hidden space-y-4">
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-4">
                            <p class="text-sm text-blue-800 dark:text-blue-200">
                                {{ __('frontend.code_sent') ?? 'A verification code has been sent to your email address.' }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('frontend.verification_code') ?? 'Verification Code' }}
                            </label>
                            <input type="text" id="verificationCode" maxlength="6" placeholder="000000" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:text-white text-center text-2xl tracking-widest font-mono">
                            <p id="codeError" class="hidden text-sm text-red-600 dark:text-red-400 mt-2"></p>
                        </div>
                        <div class="flex gap-3 justify-end">
                            <button onclick="closeCancellationModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium rounded-lg transition-colors">
                                {{ __('frontend.cancel') ?? 'Cancel' }}
                            </button>
                            <button onclick="verifyAndSubmit()" id="verifyBtn" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                                {{ __('frontend.verify_and_submit') ?? 'Verify & Submit' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Email Modal -->
        <div id="createEmailModal" style="background-color: rgba(0, 0, 0, 0.5);" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full my-8 max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            {{ __('frontend.create_email_account') ?? 'Create Email Account' }}
                        </h3>
                        <button onclick="closeCreateEmailModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <form id="createEmailForm" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('frontend.email_address') ?? 'Email Address' }}
                            </label>
                            <div class="grid grid-cols-12 gap-2">
                                <div class="col-span-5">
                                    <input type="text" id="email_username" placeholder="user" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white" required>
                                </div>
                                <div class="col-span-1 flex items-center justify-center">
                                    <span class="text-gray-600 dark:text-gray-400 font-medium">@</span>
                                </div>
                                <div class="col-span-6 relative">
                                    <select id="email_domain" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-700 dark:text-white appearance-none pr-10" required>
                                        <option value="">{{ __('frontend.loading') ?? 'Loading...' }}</option>
                                    </select>
                                    <div id="domain-loading-spinner" class="absolute right-3 top-1/2 -translate-y-1/2 hidden">
                                        <svg class="animate-spin h-4 w-4 text-indigo-600" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </div>
                                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ __('frontend.email_username_hint') ?? 'Enter username without @domain' }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('frontend.password') ?? 'Password' }}
                            </label>
                            <div class="relative">
                                <input type="password" id="email_password" placeholder="••••••••" class="w-full px-4 py-2 pr-20 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white" required>
                                <button type="button" onclick="toggleEmailPasswordVisibility()" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 p-1">
                                    <svg id="email-password-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ __('frontend.password_min_8_chars') ?? 'Minimum 8 characters required' }}</p>
                            <button type="button" onclick="generateEmailPassword()" class="mt-2 text-sm text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium">
                                {{ __('frontend.generate_strong_password') ?? 'Generate Strong Password' }}
                            </button>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('frontend.quota') ?? 'Quota' }} (MB)
                            </label>
                            <input type="number" id="email_quota" value="250" min="10" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white" required>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ __('frontend.quota_hint') ?? 'Set to 0 for unlimited' }}</p>
                        </div>
                        
                        <div id="createEmailError" class="hidden p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                            <p class="text-sm text-red-600 dark:text-red-400"></p>
                        </div>
                        
                        <div class="flex gap-3 justify-end pt-2">
                            <button type="button" onclick="closeCreateEmailModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium rounded-lg transition-colors">
                                {{ __('frontend.cancel') ?? 'Cancel' }}
                            </button>
                            <button type="submit" id="createEmailBtn" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                <span id="createEmailBtnText">{{ __('frontend.create') ?? 'Create' }}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Processing Modal -->
        <div id="processingModal" style="background-color: rgba(0, 0, 0, 0.4);" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full p-8 text-center">
                <div class="mb-6">
                    <div class="mx-auto w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                    {{ __('frontend.request_submitted') ?? 'Request Submitted' }}
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-2">
                    {{ __('frontend.cancellation_processing') ?? 'Your cancellation request is being processed.' }}
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-500 mb-6">
                    {{ __('frontend.processing_time') ?? 'Expected processing time: 24 hours' }}
                </p>
                <button onclick="closeProcessingModal()" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                    {{ __('frontend.close') ?? 'Close' }}
                </button>
            </div>
        </div>

    </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
let verificationCodeSent = false;

// Chart instances
let diskChart, bandwidthChart, domainsChart, emailsChart;

// Copy to clipboard function
function copyToClipboard(text, button) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success feedback
        const originalHTML = button.innerHTML;
        button.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
        button.classList.add('text-green-400');
        
        setTimeout(function() {
            button.innerHTML = originalHTML;
            button.classList.remove('text-green-400');
        }, 2000);
    }).catch(function(err) {
        console.error('Failed to copy: ', err);
    });
}

// Copy nameservers function
function copyNameservers() {
    const ns1 = '{{ $service->server->nameserver1 ?? "" }}';
    const ns2 = '{{ $service->server->nameserver2 ?? "" }}';
    const text = ns2 ? ns1 + '\n' + ns2 : ns1;
    
    navigator.clipboard.writeText(text).then(function() {
        // Show notification
        showNotification('{{ __("frontend.copied_to_clipboard") ?? "Copied to clipboard!" }}', 'success');
    }).catch(function(err) {
        console.error('Failed to copy: ', err);
    });
}

function openCancellationModal() {
    document.getElementById('cancellationModal').classList.remove('hidden');
    document.getElementById('modalStep1').classList.remove('hidden');
    document.getElementById('modalStep2').classList.add('hidden');
}

function closeCancellationModal() {
    document.getElementById('cancellationModal').classList.add('hidden');
    document.getElementById('verificationCode').value = '';
    document.getElementById('codeError').classList.add('hidden');
    document.getElementById('cancellationReasonSelect').value = '';
    document.getElementById('otherReasonText').value = '';
    document.getElementById('otherReasonField').style.display = 'none';
    document.getElementById('reasonError').style.display = 'none';
    document.getElementById('otherReasonError').style.display = 'none';
    verificationCodeSent = false;
}

// Show/hide other reason field based on selection
document.addEventListener('DOMContentLoaded', function() {
    const reasonSelect = document.getElementById('cancellationReasonSelect');
    const otherReasonField = document.getElementById('otherReasonField');
    
    if (reasonSelect && otherReasonField) {
        reasonSelect.addEventListener('change', function() {
            if (this.value === 'other') {
                otherReasonField.style.display = 'block';
            } else {
                otherReasonField.style.display = 'none';
                document.getElementById('otherReasonText').value = '';
                document.getElementById('otherReasonError').style.display = 'none';
            }
            document.getElementById('reasonError').style.display = 'none';
        });
    }
});

function sendVerificationCode() {
    const reasonSelect = document.getElementById('cancellationReasonSelect');
    const otherReasonText = document.getElementById('otherReasonText');
    const reasonError = document.getElementById('reasonError');
    const otherReasonError = document.getElementById('otherReasonError');
    
    // Validate reason selection
    if (!reasonSelect.value) {
        reasonError.style.display = 'block';
        return;
    }
    reasonError.style.display = 'none';
    
    // Validate other reason text if "other" is selected
    if (reasonSelect.value === 'other' && !otherReasonText.value.trim()) {
        otherReasonError.style.display = 'block';
        return;
    }
    otherReasonError.style.display = 'none';
    
    const btn = document.getElementById('sendCodeBtn');
    const originalText = btn.textContent;
    btn.disabled = true;
    btn.innerHTML = '<svg class="animate-spin h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
    
    const reason = reasonSelect.value === 'other' ? otherReasonText.value.trim() : reasonSelect.options[reasonSelect.selectedIndex].text;
    
    // Send verification code via AJAX
    fetch('{{ route("client.hosting.send-cancellation-code", $service->id) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ reason: reason })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            verificationCodeSent = true;
            document.getElementById('modalStep1').classList.add('hidden');
            document.getElementById('modalStep2').classList.remove('hidden');
        } else {
            alert(data.message || '{{ __("frontend.error_sending_code") ?? "Error sending verification code" }}');
        }
    })
    .catch(error => {
        alert('{{ __("frontend.error_occurred") ?? "An error occurred. Please try again." }}');
    })
    .finally(() => {
        btn.disabled = false;
        btn.textContent = originalText;
    });
}

function verifyAndSubmit() {
    const code = document.getElementById('verificationCode').value;
    const errorDiv = document.getElementById('codeError');
    const btn = document.getElementById('verifyBtn');
    
    if (!code || code.length < 6) {
        errorDiv.textContent = '{{ __("frontend.enter_valid_code") ?? "Please enter a valid 6-digit code" }}';
        errorDiv.classList.remove('hidden');
        return;
    }
    
    errorDiv.classList.add('hidden');
    const originalText = btn.textContent;
    btn.disabled = true;
    btn.innerHTML = '<svg class="animate-spin h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
    
    // Verify code and submit cancellation request
    fetch('{{ route("client.hosting.verify-cancellation", $service->id) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ code: code })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeCancellationModal();
            document.getElementById('processingModal').classList.remove('hidden');
        } else {
            errorDiv.textContent = data.message || '{{ __("frontend.invalid_code") ?? "Invalid verification code" }}';
            errorDiv.classList.remove('hidden');
        }
    })
    .catch(error => {
        errorDiv.textContent = '{{ __("frontend.error_occurred") ?? "An error occurred. Please try again." }}';
        errorDiv.classList.remove('hidden');
    })
    .finally(() => {
        btn.disabled = false;
        btn.textContent = originalText;
    });
}

function closeProcessingModal() {
    document.getElementById('processingModal').classList.add('hidden');
    location.reload();
}

function requestCancellation() {
    if (confirm('{{ __('frontend.confirm_cancellation') ?? 'Are you sure you want to request cancellation for this service?' }}')) {
        window.location.href = '{{ route('client.hosting.show', $service->id) }}';
    }
}

function toggleServiceDetails() {
    const content = document.getElementById('service-details-content');
    const icon = document.getElementById('service-details-icon');
    
    if (content.classList.contains('collapsed')) {
        content.classList.remove('collapsed');
        content.classList.add('expanded');
        icon.style.transform = 'rotate(180deg)';
        // Save preference
        localStorage.setItem('cloudServiceDetailsExpanded', 'true');
    } else {
        content.classList.add('collapsed');
        content.classList.remove('expanded');
        icon.style.transform = 'rotate(0deg)';
        // Save preference
        localStorage.setItem('cloudServiceDetailsExpanded', 'false');
    }
}

function togglePasswordSection() {
    const content = document.getElementById('password-section-content');
    const icon = document.getElementById('password-section-icon');
    
    if (content.classList.contains('collapsed')) {
        content.classList.remove('collapsed');
        content.classList.add('expanded');
        icon.style.transform = 'rotate(180deg)';
        localStorage.setItem('cloudPasswordSectionExpanded', 'true');
    } else {
        content.classList.add('collapsed');
        content.classList.remove('expanded');
        icon.style.transform = 'rotate(0deg)';
        localStorage.setItem('cloudPasswordSectionExpanded', 'false');
    }
}

function toggleFtpSection() {
    const content = document.getElementById('ftp-section-content');
    const icon = document.getElementById('ftp-section-icon');
    
    if (content.classList.contains('collapsed')) {
        content.classList.remove('collapsed');
        content.classList.add('expanded');
        icon.style.transform = 'rotate(180deg)';
        localStorage.setItem('cloudFtpSectionExpanded', 'true');
    } else {
        content.classList.add('collapsed');
        content.classList.remove('expanded');
        icon.style.transform = 'rotate(0deg)';
        localStorage.setItem('cloudFtpSectionExpanded', 'false');
    }
}

function toggleDatabaseSection() {
    const content = document.getElementById('database-section-content');
    const icon = document.getElementById('database-section-icon');
    
    if (content.classList.contains('collapsed')) {
        content.classList.remove('collapsed');
        content.classList.add('expanded');
        icon.style.transform = 'rotate(180deg)';
        localStorage.setItem('cloudDatabaseSectionExpanded', 'true');
    } else {
        content.classList.add('collapsed');
        content.classList.remove('expanded');
        icon.style.transform = 'rotate(0deg)';
        localStorage.setItem('cloudDatabaseSectionExpanded', 'false');
    }
}

function toggleDomainsSection() {
    const content = document.getElementById('domains-section-content');
    const icon = document.getElementById('domains-section-icon');
    
    if (content.classList.contains('collapsed')) {
        content.classList.remove('collapsed');
        content.classList.add('expanded');
        icon.style.transform = 'rotate(180deg)';
        localStorage.setItem('cloudDomainsSectionExpanded', 'true');
    } else {
        content.classList.add('collapsed');
        content.classList.remove('expanded');
        icon.style.transform = 'rotate(0deg)';
        localStorage.setItem('cloudDomainsSectionExpanded', 'false');
    }
}

function togglePasswordVisibility(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
    } else {
        input.type = 'password';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
    }
}

function checkPasswordStrength() {
    const password = document.getElementById('newPassword').value;
    const strengthText = document.getElementById('passwordStrength');
    
    let strength = 0;
    if (password.length >= 8) strength++;
    if (password.match(/[a-z]/)) strength++;
    if (password.match(/[A-Z]/)) strength++;
    if (password.match(/[0-9]/)) strength++;
    if (password.match(/[^a-zA-Z0-9]/)) strength++;
    
    const strengthLabels = ['{{ __("frontend.very_weak") ?? "Very Weak" }}', '{{ __("frontend.weak") ?? "Weak" }}', '{{ __("frontend.fair") ?? "Fair" }}', '{{ __("frontend.good") ?? "Good" }}', '{{ __("frontend.strong") ?? "Strong" }}', '{{ __("frontend.very_strong") ?? "Very Strong" }}'];
    const strengthColors = ['text-red-600', 'text-orange-600', 'text-yellow-600', 'text-blue-600', 'text-green-600', 'text-green-700'];
    
    strengthText.textContent = password.length > 0 ? '{{ __("frontend.password_strength") ?? "Strength" }}: ' + strengthLabels[strength] : '';
    strengthText.className = 'text-xs mt-1 font-medium ' + (password.length > 0 ? strengthColors[strength] : '');
}

function checkPasswordMatch() {
    const password = document.getElementById('newPassword').value;
    const confirm = document.getElementById('confirmPassword').value;
    const matchError = document.getElementById('passwordMatchError');
    
    if (confirm.length > 0) {
        if (password !== confirm) {
            matchError.style.display = 'block';
        } else {
            matchError.style.display = 'none';
        }
    }
}

function resetPasswordForm() {
    document.getElementById('changePasswordForm').reset();
    document.getElementById('passwordStrength').textContent = '';
    document.getElementById('passwordMatchError').style.display = 'none';
    document.getElementById('passwordChangeError').classList.add('hidden');
    document.getElementById('passwordChangeSuccess').classList.add('hidden');
}

function generateStrongPassword() {
    const length = 16;
    const uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const lowercase = 'abcdefghijklmnopqrstuvwxyz';
    const numbers = '0123456789';
    const symbols = '!@#$%^&*()_+-=[]{}|;:,.<>?';
    
    const allChars = uppercase + lowercase + numbers + symbols;
    let password = '';
    
    // Ensure at least one character from each category
    password += uppercase[Math.floor(Math.random() * uppercase.length)];
    password += lowercase[Math.floor(Math.random() * lowercase.length)];
    password += numbers[Math.floor(Math.random() * numbers.length)];
    password += symbols[Math.floor(Math.random() * symbols.length)];
    
    // Fill the rest randomly
    for (let i = password.length; i < length; i++) {
        password += allChars[Math.floor(Math.random() * allChars.length)];
    }
    
    // Shuffle the password
    password = password.split('').sort(() => Math.random() - 0.5).join('');
    
    // Set password to both fields
    const newPasswordInput = document.getElementById('newPassword');
    const confirmPasswordInput = document.getElementById('confirmPassword');
    
    newPasswordInput.value = password;
    confirmPasswordInput.value = password;
    
    // Show password temporarily
    newPasswordInput.type = 'text';
    confirmPasswordInput.type = 'text';
    
    // Update strength indicator
    checkPasswordStrength();
    checkPasswordMatch();
    
    // Copy to clipboard
    navigator.clipboard.writeText(password).then(() => {
        // Show success message
        const successMsg = document.createElement('div');
        successMsg.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 flex items-center gap-2';
        successMsg.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><span>{{ __("frontend.password_copied") ?? "Password copied to clipboard" }}</span>';
        document.body.appendChild(successMsg);
        
        setTimeout(() => {
            successMsg.remove();
        }, 3000);
    });
}

function toggleEmailSection() {
    const content = document.getElementById('email-section-content');
    const icon = document.getElementById('email-section-icon');
    
    if (content.classList.contains('collapsed')) {
        content.classList.remove('collapsed');
        content.classList.add('expanded');
        icon.style.transform = 'rotate(180deg)';
        localStorage.setItem('cloudEmailSectionExpanded', 'true');
        
        // Load email accounts when opened
        loadEmailAccounts();
    } else {
        content.classList.add('collapsed');
        content.classList.remove('expanded');
        icon.style.transform = 'rotate(0deg)';
        localStorage.setItem('cloudEmailSectionExpanded', 'false');
    }
}

function loadEmailAccounts() {
    const loading = document.getElementById('emailAccountsLoading');
    const list = document.getElementById('emailAccountsList');
    const noAccounts = document.getElementById('noEmailAccounts');
    
    loading.classList.remove('hidden');
    list.classList.add('hidden');
    noAccounts.classList.add('hidden');
    
    fetch('/services/hosting/{{ $service->id }}/emails', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        loading.classList.add('hidden');
        
        if (data.success && data.accounts && data.accounts.length > 0) {
            list.classList.remove('hidden');
            list.innerHTML = '';
            
            data.accounts.forEach(account => {
                const accountCard = document.createElement('div');
                accountCard.className = 'bg-gray-50 dark:bg-gray-900/50 rounded-lg p-4 border border-gray-200 dark:border-gray-700';
                accountCard.innerHTML = `
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">${account.email || account.user + '@' + account.domain}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">${account.diskused || '0'} MB / ${account.diskquota || 'Unlimited'}</p>
                            </div>
                        </div>
                        <button onclick="deleteEmail('${account.email || account.user}')" class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                `;
                list.appendChild(accountCard);
            });
        } else {
            noAccounts.classList.remove('hidden');
        }
    })
    .catch(error => {
        loading.classList.add('hidden');
        noAccounts.classList.remove('hidden');
        console.error('Error loading email accounts:', error);
    });
}

function loadEmailDomains() {
    const domainSelect = document.getElementById('email_domain');
    const spinner = document.getElementById('domain-loading-spinner');
    
    if (!domainSelect) return;
    
    spinner.classList.remove('hidden');
    domainSelect.disabled = true;
    domainSelect.innerHTML = '<option value="">{{ __("frontend.loading") ?? "Loading..." }}</option>';
    
    fetch('/services/hosting/{{ $service->id }}/domains', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        spinner.classList.add('hidden');
        domainSelect.disabled = false;
        
        if (data.success && data.domains && data.domains.length > 0) {
            // Clear loading option
            domainSelect.innerHTML = '';
            
            // Service main domain
            const serviceDomain = '{{ $service->domain }}';
            
            // Filter function to exclude auto-generated subdomains
            const isValidDomain = (domain) => {
                // Exclude domains that end with server's main domain (e.g., .progineous.io, .test.com)
                const serverDomains = ['progineous.io', 'test.com', 'mysecurecloudhost.com'];
                
                // Check if domain is a subdomain of any server domain
                for (const serverDomain of serverDomains) {
                    // Match patterns like: testmynew.com.progineous.io or subdomain.example.com.test.com
                    if (domain !== serverDomain && domain.endsWith('.' + serverDomain)) {
                        return false;
                    }
                }
                return true;
            };
            
            // Filter domains
            const validDomains = data.domains.filter(isValidDomain);
            
            // Add main domain first (service domain)
            const mainDomainIndex = validDomains.indexOf(serviceDomain);
            if (mainDomainIndex !== -1) {
                const option = document.createElement('option');
                option.value = serviceDomain;
                option.textContent = serviceDomain + ' ({{ __("frontend.main_domain") ?? "Main" }})';
                option.selected = true;
                domainSelect.appendChild(option);
            }
            
            // Add other domains
            validDomains.forEach(domain => {
                if (domain !== serviceDomain) {
                    const option = document.createElement('option');
                    option.value = domain;
                    option.textContent = domain;
                    domainSelect.appendChild(option);
                }
            });
            
            // If main domain not found in list, add it
            if (mainDomainIndex === -1) {
                const option = document.createElement('option');
                option.value = serviceDomain;
                option.textContent = serviceDomain + ' ({{ __("frontend.main_domain") ?? "Main" }})';
                option.selected = true;
                domainSelect.insertBefore(option, domainSelect.firstChild);
            }
        } else {
            // Fallback to service domain
            domainSelect.innerHTML = '<option value="{{ $service->domain }}" selected>{{ $service->domain }}</option>';
        }
    })
    .catch(error => {
        console.error('Error loading domains:', error);
        spinner.classList.add('hidden');
        domainSelect.disabled = false;
        // Fallback to service domain
        domainSelect.innerHTML = '<option value="{{ $service->domain }}" selected>{{ $service->domain }}</option>';
    });
}

function openCreateEmailModal() {
    document.getElementById('createEmailModal').classList.remove('hidden');
    document.getElementById('createEmailForm').reset();
    document.getElementById('createEmailError').classList.add('hidden');
    // Load domains when modal opens
    loadEmailDomains();
}

function closeCreateEmailModal() {
    document.getElementById('createEmailModal').classList.add('hidden');
    document.getElementById('createEmailForm').reset();
    document.getElementById('createEmailError').classList.add('hidden');
}

function toggleEmailPasswordVisibility() {
    const input = document.getElementById('email_password');
    const icon = document.getElementById('email-password-icon');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
    } else {
        input.type = 'password';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
    }
}

function generateEmailPassword() {
    const length = 16;
    const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
    let password = "";
    
    // Ensure at least one of each type
    password += "ABCDEFGHIJKLMNOPQRSTUVWXYZ"[Math.floor(Math.random() * 26)];
    password += "abcdefghijklmnopqrstuvwxyz"[Math.floor(Math.random() * 26)];
    password += "0123456789"[Math.floor(Math.random() * 10)];
    password += "!@#$%^&*"[Math.floor(Math.random() * 8)];
    
    // Fill the rest randomly
    for (let i = password.length; i < length; i++) {
        password += charset[Math.floor(Math.random() * charset.length)];
    }
    
    // Shuffle the password
    password = password.split('').sort(() => Math.random() - 0.5).join('');
    
    document.getElementById('email_password').value = password;
    document.getElementById('email_password').type = 'text';
}

// Handle create email form submission
document.addEventListener('DOMContentLoaded', function() {
    const createEmailForm = document.getElementById('createEmailForm');
    if (createEmailForm) {
        createEmailForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const username = document.getElementById('email_username').value.trim();
            const password = document.getElementById('email_password').value;
            const quota = document.getElementById('email_quota').value;
            const domain = document.getElementById('email_domain').value;
            const errorDiv = document.getElementById('createEmailError');
            const btn = document.getElementById('createEmailBtn');
            const btnText = document.getElementById('createEmailBtnText');
            
            // Validation
            if (!username || !password || !domain) {
                errorDiv.querySelector('p').textContent = '{{ __("frontend.please_fill_all_fields") ?? "Please fill all required fields" }}';
                errorDiv.classList.remove('hidden');
                return;
            }
            
            if (username.includes('@')) {
                errorDiv.querySelector('p').textContent = '{{ __("frontend.username_no_at") ?? "Username should not contain @ symbol" }}';
                errorDiv.classList.remove('hidden');
                return;
            }
            
            if (password.length < 8) {
                errorDiv.querySelector('p').textContent = '{{ __("frontend.password_min_length_8") ?? "Password must be at least 8 characters" }}';
                errorDiv.classList.remove('hidden');
                return;
            }
            
            errorDiv.classList.add('hidden');
            btn.disabled = true;
            btnText.textContent = '{{ __("frontend.creating") ?? "Creating..." }}';
            
            fetch('/services/hosting/{{ $service->id }}/emails', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    email_username: username,
                    email_domain: domain,
                    password: password,
                    quota: quota || 250
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('{{ __("frontend.email_created_successfully") ?? "Email account created successfully" }}', 'success');
                    closeCreateEmailModal();
                    setTimeout(() => {
                        loadEmailAccounts();
                    }, 1000);
                } else {
                    errorDiv.querySelector('p').textContent = data.message || '{{ __("frontend.failed_to_create_email") ?? "Failed to create email account" }}';
                    errorDiv.classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error('Error creating email:', error);
                errorDiv.querySelector('p').textContent = '{{ __("frontend.error_occurred") ?? "An error occurred" }}';
                errorDiv.classList.remove('hidden');
            })
            .finally(() => {
                btn.disabled = false;
                btnText.textContent = '{{ __("frontend.create") ?? "Create" }}';
            });
        });
    }
});

function deleteEmail(email) {
    if (!confirm('{{ __("frontend.confirm_delete_email") ?? "Are you sure you want to delete this email account?" }}')) {
        return;
    }
    
    showNotification('{{ __("frontend.deleting_email") ?? "Deleting email account..." }}', 'info');
    
    // Extract username from email (before @)
    const emailUser = email.includes('@') ? email.split('@')[0] : email;
    const emailDomain = email.includes('@') ? email.split('@')[1] : '{{ $service->domain }}';
    
    fetch('/services/hosting/{{ $service->id }}/emails/delete', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            email_user: emailUser,
            email_domain: emailDomain
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('{{ __("frontend.email_deleted_successfully") ?? "Email account deleted successfully" }}', 'success');
            // Reload email accounts list
            setTimeout(() => {
                loadEmailAccounts();
            }, 1500);
        } else {
            showNotification(data.message || '{{ __("frontend.failed_to_delete_email") ?? "Failed to delete email account" }}', 'error');
        }
    })
    .catch(error => {
        console.error('Error deleting email:', error);
        showNotification('{{ __("frontend.error_occurred") ?? "An error occurred while deleting email account" }}', 'error');
    });
}

function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
    const icon = type === 'success' 
        ? '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>'
        : '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
    
    notification.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-4 rounded-lg shadow-2xl z-50 flex items-center gap-3 transform transition-all duration-300 translate-x-0`;
    notification.innerHTML = `
        <div class="flex-shrink-0">
            ${icon}
        </div>
        <span class="font-medium">${message}</span>
        <button onclick="this.parentElement.remove()" class="ml-2 hover:bg-white/20 rounded p-1 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 10);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.style.transform = 'translateX(400px)';
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 5000);
}

// Load statistics data
function loadStatistics() {
    fetch('{{ route("client.hosting.stats", $service->id) }}')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateStatCard('disk', data.disk_used, data.disk_limit);
                updateStatCard('bandwidth', data.bandwidth_used, data.bandwidth_limit);
                updateStatCard('domains', data.addon_domains_used, data.addon_domains_limit);
                updateStatCard('emails', data.email_accounts_used, data.email_accounts_limit);
            }
        })
        .catch(error => {
            console.error('Error loading statistics:', error);
            // Show error state only if elements exist
            const mapping = {
                'disk': 'diskUsage',
                'bandwidth': 'bandwidth',
                'domains': 'domains',
                'emails': 'emails'
            };
            
            ['disk', 'bandwidth', 'domains', 'emails'].forEach(type => {
                const prefix = mapping[type];
                const textElement = document.getElementById(prefix + 'Text');
                const detailsElement = document.getElementById(prefix + 'Details');
                
                if (textElement) textElement.textContent = '--';
                if (detailsElement) detailsElement.textContent = '{{ __("frontend.error_loading") ?? "Error loading data" }}';
            });
        });
}

function updateStatCard(type, used, limit) {
    const percentage = limit > 0 ? (used / limit * 100) : 0;
    const isUnlimited = limit === 'unlimited' || limit === -1 || limit === 0;
    
    let displayText, detailsText;
    
    if (isUnlimited) {
        displayText = formatBytes(used);
        detailsText = '{{ __("frontend.unlimited") ?? "Unlimited" }}';
    } else {
        displayText = Math.round(percentage) + '%';
        detailsText = formatBytes(used) + ' / ' + formatBytes(limit);
    }
    
    // Update text elements
    const textElement = document.getElementById(type + 'UsageText') || document.getElementById(type + 'Text');
    const detailsElement = document.getElementById(type + 'UsageDetails') || document.getElementById(type + 'Details');
    
    if (textElement) {
        if (type === 'bandwidth' || type === 'disk') {
            textElement.textContent = displayText;
        } else {
            textElement.textContent = used + (isUnlimited ? '' : ' / ' + limit);
        }
    }
    
    if (detailsElement) {
        if (type === 'bandwidth' || type === 'disk') {
            detailsElement.textContent = detailsText;
        } else {
            detailsElement.textContent = isUnlimited ? '{{ __("frontend.unlimited") ?? "Unlimited" }}' : Math.round(percentage) + '% {{ __("frontend.used") ?? "used" }}';
        }
    }
    
    // Update or create chart
    updateChart(type, used, limit, percentage, isUnlimited);
}

function updateChart(type, used, limit, percentage, isUnlimited) {
    const chartId = type + 'Chart';
    const canvas = document.getElementById(chartId);
    
    if (!canvas) return;
    
    const ctx = canvas.getContext('2d');
    
    // Color schemes
    const colors = {
        disk: { primary: '#3b82f6', secondary: '#93c5fd', background: '#dbeafe' },
        bandwidth: { primary: '#10b981', secondary: '#6ee7b7', background: '#d1fae5' },
        domains: { primary: '#8b5cf6', secondary: '#c4b5fd', background: '#ede9fe' },
        emails: { primary: '#f97316', secondary: '#fdba74', background: '#fed7aa' }
    };
    
    const color = colors[type];
    const actualPercentage = isUnlimited ? Math.min((used / (1024 * 1024 * 1024)) * 10, 100) : Math.min(percentage, 100);
    const remaining = 100 - actualPercentage;
    
    // Destroy existing chart if it exists
    const chartKey = type + 'ChartInstance';
    if (window[chartKey]) {
        window[chartKey].destroy();
    }
    
    // Create doughnut chart
    window[chartKey] = new Chart(ctx, {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [actualPercentage, remaining],
                backgroundColor: [
                    actualPercentage >= 90 ? '#ef4444' : actualPercentage >= 75 ? '#f59e0b' : color.primary,
                    color.background
                ],
                borderWidth: 0,
                cutout: '75%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false },
                tooltip: { enabled: false }
            },
            animation: {
                animateRotate: true,
                animateScale: true,
                duration: 1000
            }
        },
        plugins: [{
            id: 'centerText',
            afterDraw: function(chart) {
                const width = chart.width;
                const height = chart.height;
                const ctx = chart.ctx;
                ctx.restore();
                
                const fontSize = (height / 80).toFixed(2);
                ctx.font = 'bold ' + fontSize + 'em sans-serif';
                ctx.textBaseline = 'middle';
                ctx.fillStyle = '#1f2937';
                
                const text = isUnlimited ? '∞' : Math.round(actualPercentage) + '%';
                const textX = Math.round((width - ctx.measureText(text).width) / 2);
                const textY = height / 2;
                
                ctx.fillText(text, textX, textY);
                ctx.save();
            }
        }]
    });
}

function formatBytes(bytes, decimals = 2) {
    if (bytes === 0 || bytes === '0') return '0 Bytes';
    if (bytes === 'unlimited' || bytes === -1) return '{{ __("frontend.unlimited") ?? "Unlimited" }}';
    
    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    
    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const content = document.getElementById('service-details-content');
    const icon = document.getElementById('service-details-icon');
    
    // Get saved preference, default to expanded
    const isExpanded = localStorage.getItem('cloudServiceDetailsExpanded') !== 'false';
    
    if (isExpanded) {
        content.classList.add('expanded');
        icon.style.transform = 'rotate(180deg)';
    } else {
        content.classList.add('collapsed');
        icon.style.transform = 'rotate(0deg)';
    }

    // Load statistics if section exists
    if (document.getElementById('diskUsageText')) {
        loadStatistics();
    }

    // Password section initialization
    const passwordContent = document.getElementById('password-section-content');
    const passwordIcon = document.getElementById('password-section-icon');
    
    if (passwordContent && passwordIcon) {
        const isPasswordExpanded = localStorage.getItem('cloudPasswordSectionExpanded') !== 'false';
        
        if (isPasswordExpanded) {
            passwordContent.classList.add('expanded');
            passwordIcon.style.transform = 'rotate(180deg)';
        } else {
            passwordContent.classList.add('collapsed');
            passwordIcon.style.transform = 'rotate(0deg)';
        }
    }

    // Email section initialization
    const emailContent = document.getElementById('email-section-content');
    const emailIcon = document.getElementById('email-section-icon');
    
    if (emailContent && emailIcon) {
        const isEmailExpanded = localStorage.getItem('cloudEmailSectionExpanded') !== 'false';
        
        if (isEmailExpanded) {
            emailContent.classList.add('expanded');
            emailIcon.style.transform = 'rotate(180deg)';
            loadEmailAccounts();
        } else {
            emailContent.classList.add('collapsed');
            emailIcon.style.transform = 'rotate(0deg)';
        }
    }

    // FTP section initialization
    const ftpContent = document.getElementById('ftp-section-content');
    const ftpIcon = document.getElementById('ftp-section-icon');
    
    if (ftpContent && ftpIcon) {
        const isFtpExpanded = localStorage.getItem('cloudFtpSectionExpanded') !== 'false';
        
        if (isFtpExpanded) {
            ftpContent.classList.add('expanded');
            ftpIcon.style.transform = 'rotate(180deg)';
        } else {
            ftpContent.classList.add('collapsed');
            ftpIcon.style.transform = 'rotate(0deg)';
        }
    }

    // Database section initialization
    const databaseContent = document.getElementById('database-section-content');
    const databaseIcon = document.getElementById('database-section-icon');
    
    if (databaseContent && databaseIcon) {
        const isDatabaseExpanded = localStorage.getItem('cloudDatabaseSectionExpanded') !== 'false';
        
        if (isDatabaseExpanded) {
            databaseContent.classList.add('expanded');
            databaseIcon.style.transform = 'rotate(180deg)';
        } else {
            databaseContent.classList.add('collapsed');
            databaseIcon.style.transform = 'rotate(0deg)';
        }
    }

    // Domains section initialization
    const domainsContent = document.getElementById('domains-section-content');
    const domainsIcon = document.getElementById('domains-section-icon');
    
    if (domainsContent && domainsIcon) {
        const isDomainsExpanded = localStorage.getItem('cloudDomainsSectionExpanded') !== 'false';
        
        if (isDomainsExpanded) {
            domainsContent.classList.add('expanded');
            domainsIcon.style.transform = 'rotate(180deg)';
        } else {
            domainsContent.classList.add('collapsed');
            domainsIcon.style.transform = 'rotate(0deg)';
        }
    }

    // Password strength checker
    const newPasswordInput = document.getElementById('newPassword');
    const confirmPasswordInput = document.getElementById('confirmPassword');
    
    if (newPasswordInput) {
        newPasswordInput.addEventListener('input', checkPasswordStrength);
    }
    
    if (confirmPasswordInput) {
        confirmPasswordInput.addEventListener('input', checkPasswordMatch);
    }

    // Change password form submission
    const changePasswordForm = document.getElementById('changePasswordForm');
    if (changePasswordForm) {
        changePasswordForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const password = document.getElementById('newPassword').value;
            const confirm = document.getElementById('confirmPassword').value;
            const errorDiv = document.getElementById('passwordChangeError');
            const successDiv = document.getElementById('passwordChangeSuccess');
            const btn = document.getElementById('changePasswordBtn');
            
            // Hide previous messages
            errorDiv.classList.add('hidden');
            successDiv.classList.add('hidden');
            
            // Validate passwords match
            if (password !== confirm) {
                errorDiv.querySelector('p').textContent = '{{ __("frontend.passwords_not_match") ?? "Passwords do not match" }}';
                errorDiv.classList.remove('hidden');
                return;
            }
            
            // Validate password strength
            if (password.length < 8) {
                errorDiv.querySelector('p').textContent = '{{ __("frontend.password_too_short") ?? "Password must be at least 8 characters long" }}';
                errorDiv.classList.remove('hidden');
                return;
            }
            
            const originalText = btn.textContent;
            btn.disabled = true;
            btn.innerHTML = '<svg class="animate-spin h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
            
            // Send password change request
            fetch('{{ route("client.hosting.change-password", $service->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ 
                    new_password: password,
                    confirm_password: confirm
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    successDiv.querySelector('p').textContent = data.message || '{{ __("frontend.password_changed_successfully") ?? "Password changed successfully" }}';
                    successDiv.classList.remove('hidden');
                    resetPasswordForm();
                    
                    // Show floating notification
                    showNotification('{{ __("frontend.password_changed_successfully") ?? "Password changed successfully" }}', 'success');
                } else {
                    errorDiv.querySelector('p').textContent = data.message || '{{ __("frontend.password_change_failed") ?? "Failed to change password" }}';
                    errorDiv.classList.remove('hidden');
                    
                    // Show floating notification for error
                    showNotification(data.message || '{{ __("frontend.password_change_failed") ?? "Failed to change password" }}', 'error');
                }
            })
            .catch(error => {
                errorDiv.querySelector('p').textContent = '{{ __("frontend.error_occurred") ?? "An error occurred. Please try again." }}';
                errorDiv.classList.remove('hidden');
                
                // Show floating notification for error
                showNotification('{{ __("frontend.error_occurred") ?? "An error occurred. Please try again." }}', 'error');
            })
            .finally(() => {
                btn.disabled = false;
                btn.textContent = originalText;
            });
        });
    }
});
</script>

<style>
#service-details-content,
#password-section-content,
#email-section-content,
#ftp-section-content,
#database-section-content,
#domains-section-content {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
}

#service-details-content.collapsed,
#password-section-content.collapsed,
#email-section-content.collapsed,
#ftp-section-content.collapsed,
#database-section-content.collapsed,
#domains-section-content.collapsed {
    max-height: 0 !important;
    padding-top: 0 !important;
    padding-bottom: 0 !important;
    opacity: 0;
}

#service-details-content.expanded,
#password-section-content.expanded,
#email-section-content.expanded,
#ftp-section-content.expanded,
#database-section-content.expanded,
#domains-section-content.expanded {
    max-height: 2000px !important;
    padding: 1.5rem !important;
    opacity: 1;
}

#service-details-icon,
#password-section-icon,
#email-section-icon,
#ftp-section-icon,
#database-section-icon,
#domains-section-icon {
    transition: transform 0.3s ease-in-out;
}
</style>
@endsection
