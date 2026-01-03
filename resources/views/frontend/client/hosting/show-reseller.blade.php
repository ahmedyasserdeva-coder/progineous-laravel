@extends('frontend.client.layout')

@section('title', $service->domain . ' - Reseller Hosting - ' . config('app.name'))

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Section -->
        <div class="mb-6">
            <a href="{{ route('client.hosting.reseller') }}" class="inline-flex items-center gap-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                {{ __('frontend.back_to_reseller_hosting') ?? 'Back to Reseller Hosting' }}
            </a>
        </div>

        <!-- Cancellation Notice -->
        @if($service->cancellation_requested_at)
        <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl p-4 mb-6">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div>
                    <h3 class="font-semibold text-amber-800 dark:text-amber-200">{{ __('frontend.cancellation_pending') ?? 'Cancellation Request Pending' }}</h3>
                    <p class="text-sm text-amber-700 dark:text-amber-300 mt-1">
                        {{ __('frontend.cancellation_submitted_on') ?? 'Submitted on' }}: {{ \Carbon\Carbon::parse($service->cancellation_requested_at)->format('M d, Y') }}
                    </p>
                </div>
            </div>
        </div>
        @endif

        <!-- Service Header Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 mb-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-slate-600 to-slate-800 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-3 flex-wrap">
                            <h1 class="text-xl font-bold text-gray-900 dark:text-white">{{ $service->domain }}</h1>
                            @php
                                $statusStyles = [
                                    'active' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
                                    'pending' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                                    'suspended' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                ];
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $statusStyles[$service->status] ?? 'bg-gray-100 text-gray-700' }}">
                                @if($service->status === 'active')
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                @elseif($service->status === 'pending')
                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                                @else
                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                @endif
                                {{ __(('frontend.' . $service->status)) ?? ucfirst($service->status) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            {{ __('frontend.reseller_hosting') ?? 'Reseller Hosting' }} • ID: #{{ $service->id }}
                        </p>
                    </div>
                </div>
                
                @if($service->status === 'active' && $hasCredentials)
                <a href="{{ $whmCredentials['login_url'] }}" target="_blank" 
                   class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-slate-800 hover:bg-slate-900 dark:bg-slate-700 dark:hover:bg-slate-600 text-white rounded-lg font-medium transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    {{ __('frontend.login_to_whm') ?? 'Login to WHM' }}
                </a>
                @endif
            </div>
        </div>

        <!-- Pending Setup Notice -->
        @if($service->status === 'pending' || !$hasCredentials)
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-amber-200 dark:border-amber-800 p-8 mb-6">
            <div class="flex flex-col items-center text-center max-w-lg mx-auto">
                <div class="w-16 h-16 bg-amber-100 dark:bg-amber-900/30 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">
                    {{ __('frontend.service_being_setup') ?? 'Your Service is Being Set Up' }}
                </h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                    {{ __('frontend.reseller_setup_message') ?? 'Your reseller hosting account is being configured by our team. You will receive your WHM login credentials once the setup is complete. This usually takes 1-24 hours.' }}
                </p>
                <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    {{ __('frontend.email_notification') ?? 'You will be notified by email when your account is ready' }}
                </div>
            </div>
        </div>
        @endif

        <!-- Stats Widgets Row -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Status Widget -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('frontend.status') ?? 'Status' }}</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ __(('frontend.' . $service->status)) ?? ucfirst($service->status) }}</p>
                    </div>
                </div>
            </div>

            <!-- Billing Cycle Widget -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('frontend.billing_cycle') ?? 'Billing' }}</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ ucfirst($service->billing_cycle ?? 'Monthly') }}</p>
                    </div>
                </div>
            </div>

            <!-- Next Due Widget -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('frontend.next_due_date') ?? 'Next Due' }}</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                            @if($service->next_due_date)
                                {{ \Carbon\Carbon::parse($service->next_due_date)->format('M d, Y') }}
                            @else
                                -
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Amount Widget -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('frontend.recurring_amount') ?? 'Amount' }}</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">${{ number_format($service->recurring_amount ?? 0, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - 2/3 width -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- WHM Credentials Widget -->
                @if($service->status === 'active' && $hasCredentials)
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-slate-100 dark:bg-slate-800 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                </svg>
                            </div>
                            <h2 class="font-semibold text-gray-900 dark:text-white">{{ __('frontend.whm_credentials') ?? 'WHM Login Credentials' }}</h2>
                        </div>
                    </div>
                    <div class="p-5 space-y-4">
                        <!-- Login URL -->
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">
                                {{ __('frontend.login_url') ?? 'Login URL' }}
                            </label>
                            <div class="flex items-center gap-2">
                                <code class="flex-1 bg-gray-50 dark:bg-gray-900 px-4 py-2.5 rounded-lg text-sm font-mono text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-700 overflow-x-auto">
                                    {{ $whmCredentials['login_url'] }}
                                </code>
                                <button onclick="copyToClipboard('{{ $whmCredentials['login_url'] }}')" class="p-2.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors" title="Copy">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Username -->
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">
                                    {{ __('frontend.username') ?? 'Username' }}
                                </label>
                                <div class="flex items-center gap-2">
                                    <code class="flex-1 bg-gray-50 dark:bg-gray-900 px-4 py-2.5 rounded-lg text-sm font-mono text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-700">
                                        {{ $whmCredentials['username'] }}
                                    </code>
                                    <button onclick="copyToClipboard('{{ $whmCredentials['username'] }}')" class="p-2.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors" title="Copy">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Password -->
                            <div x-data="{ showPassword: false }">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">
                                    {{ __('frontend.password') ?? 'Password' }}
                                </label>
                                <div class="flex items-center gap-2">
                                    <code class="flex-1 bg-gray-50 dark:bg-gray-900 px-4 py-2.5 rounded-lg text-sm font-mono text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-700">
                                        <span x-show="!showPassword">••••••••••••</span>
                                        <span x-show="showPassword" x-cloak>{{ $whmCredentials['password'] }}</span>
                                    </code>
                                    <button @click="showPassword = !showPassword" class="p-2.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors" title="Toggle">
                                        <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <svg x-show="showPassword" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                        </svg>
                                    </button>
                                    <button onclick="copyToClipboard('{{ $whmCredentials['password'] }}')" class="p-2.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors" title="Copy">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- IP Address -->
                        @if(!empty($service->metadata['whm_ip_address']))
                        <div class="mt-4">
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">
                                {{ __('frontend.ip_address') ?? 'IP Address' }}
                            </label>
                            <div class="flex items-center gap-2">
                                <code class="flex-1 bg-gray-50 dark:bg-gray-900 px-4 py-2.5 rounded-lg text-sm font-mono text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-700">
                                    {{ $service->metadata['whm_ip_address'] }}
                                </code>
                                <button onclick="copyToClipboard('{{ $service->metadata['whm_ip_address'] }}')" class="p-2.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors" title="Copy">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Customer Note from Admin -->
                        @if(!empty($service->metadata['whm_customer_note']))
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800/50 rounded-lg p-3 mt-3">
                            <div class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <p class="text-xs font-medium text-blue-700 dark:text-blue-300 mb-1">{{ __('frontend.note_from_support') ?? 'Note from Support' }}</p>
                                    <p class="text-xs text-blue-600 dark:text-blue-400">{!! nl2br(e($service->metadata['whm_customer_note'])) !!}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Service Details Widget -->
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <h2 class="font-semibold text-gray-900 dark:text-white">{{ __('frontend.service_details') ?? 'Service Details' }}</h2>
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ __('frontend.domain') ?? 'Domain' }}</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $service->domain }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ __('frontend.plan') ?? 'Plan' }}</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $configuration['plan_name'] ?? $service->service_name ?? 'Reseller' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ __('frontend.created_at') ?? 'Created' }}</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $service->created_at->format('M d, Y') }}</p>
                            </div>
                            @if($service->activated_at)
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ __('frontend.activated_at') ?? 'Activated' }}</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($service->activated_at)->format('M d, Y') }}</p>
                            </div>
                            @endif
                            @if($service->next_due_date)
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ __('frontend.days_remaining') ?? 'Days Remaining' }}</p>
                                @php
                                    $daysLeft = (int) now()->diffInDays($service->next_due_date, false);
                                @endphp
                                <p class="text-sm font-medium {{ $daysLeft < 7 ? 'text-red-600' : ($daysLeft < 30 ? 'text-amber-600' : 'text-gray-900 dark:text-white') }}">
                                    {{ $daysLeft > 0 ? $daysLeft . ' ' . (__('frontend.days') ?? 'days') : (__('frontend.expired') ?? 'Expired') }}
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Invoices Widget -->
                @if(isset($invoices) && $invoices->count() > 0)
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                                </svg>
                            </div>
                            <h2 class="font-semibold text-gray-900 dark:text-white">{{ __('frontend.recent_invoices') ?? 'Recent Invoices' }}</h2>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($invoices as $invoice)
                        <div class="px-5 py-4 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                    <span class="text-xs font-bold text-gray-600 dark:text-gray-400">#</span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $invoice->invoice_number ?? $invoice->id }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $invoice->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="text-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">${{ number_format($invoice->total, 2) }}</p>
                                    @php
                                        $invoiceStatusStyles = [
                                            'paid' => 'text-emerald-600 dark:text-emerald-400',
                                            'unpaid' => 'text-red-600 dark:text-red-400',
                                        ];
                                    @endphp
                                    <p class="text-xs {{ $invoiceStatusStyles[$invoice->status] ?? 'text-gray-500' }}">{{ ucfirst($invoice->status) }}</p>
                                </div>
                                <a href="{{ route('client.invoices.show', $invoice->id) }}" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column - 1/3 width -->
            <div class="space-y-6">
                <!-- Quick Actions Widget -->
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="font-semibold text-gray-900 dark:text-white">{{ __('frontend.quick_actions') ?? 'Quick Actions' }}</h2>
                    </div>
                    <div class="p-4 space-y-2">
                        @if($service->status === 'active' && $hasCredentials)
                        <a href="{{ $whmCredentials['login_url'] }}" target="_blank" 
                           class="flex items-center gap-3 px-4 py-3 bg-slate-50 dark:bg-slate-800/50 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors">
                            <div class="w-8 h-8 bg-slate-200 dark:bg-slate-700 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('frontend.login_to_whm') ?? 'Login to WHM' }}</span>
                        </a>
                        @endif
                        
                        <a href="mailto:support@{{ config('app.domain', 'example.com') }}?subject=Support - {{ $service->domain }}" 
                           class="flex items-center gap-3 px-4 py-3 bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                            <div class="w-8 h-8 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('frontend.get_support') ?? 'Get Support' }}</span>
                        </a>
                        
                        @if($service->status === 'active' && !$service->cancellation_requested_at)
                        <button onclick="confirmCancellation()" 
                                class="w-full flex items-center gap-3 px-4 py-3 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-lg transition-colors">
                            <div class="w-8 h-8 bg-red-100 dark:bg-red-800/50 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-red-700 dark:text-red-300">{{ __('frontend.request_cancellation') ?? 'Request Cancellation' }}</span>
                        </button>
                        @endif
                    </div>
                </div>

                <!-- Plan Resources Widget -->
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="font-semibold text-gray-900 dark:text-white">{{ __('frontend.plan_resources') ?? 'Plan Resources' }}</h2>
                    </div>
                    <div class="p-4 space-y-4">
                        <!-- Plan Name -->
                        @if(isset($configuration['plan']) || $service->service_name)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                                {{ __('frontend.plan') ?? 'Plan' }}
                            </div>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $configuration['plan'] ?? $service->service_name }}</span>
                        </div>
                        @endif

                        <!-- Datacenter -->
                        @if(isset($configuration['datacenter_name']) || isset($configuration['datacenter']))
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ __('frontend.datacenter') ?? 'Datacenter' }}
                            </div>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $configuration['datacenter_name'] ?? $configuration['datacenter'] ?? '-' }}</span>
                        </div>
                        @endif

                        <!-- Disk Space -->
                        @if(isset($configuration['disk_space']))
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                                </svg>
                                {{ __('frontend.disk_space') ?? 'Disk Space' }}
                            </div>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $configuration['disk_space'] }}</span>
                        </div>
                        @endif
                        
                        <!-- Bandwidth -->
                        @if(isset($configuration['bandwidth']))
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                </svg>
                                {{ __('frontend.bandwidth') ?? 'Bandwidth' }}
                            </div>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $configuration['bandwidth'] }}</span>
                        </div>
                        @endif
                        
                        <!-- cPanel Accounts -->
                        @if(isset($configuration['cpanel_accounts']))
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                {{ __('frontend.cpanel_accounts') ?? 'cPanel Accounts' }}
                            </div>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $configuration['cpanel_accounts'] }}</span>
                        </div>
                        @endif

                        <!-- Billing Cycle -->
                        @if(isset($configuration['billing_cycle']))
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ __('frontend.billing_cycle') ?? 'Billing Cycle' }}
                            </div>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ ucfirst($configuration['billing_cycle']) }}</span>
                        </div>
                        @endif

                        <!-- Plan Features -->
                        @if(!empty($features))
                        <div class="pt-3 mt-3 border-t border-gray-200 dark:border-gray-700">
                            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                                {{ __('frontend.plan_features') ?? 'Plan Features' }}
                            </h4>
                            <ul class="space-y-2">
                                @foreach($features as $feature)
                                <li class="flex items-start gap-2 text-sm text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4 text-emerald-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span>{{ $feature }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Need Help Widget -->
                <div class="bg-gradient-to-br from-slate-700 to-slate-900 rounded-xl p-5 text-white">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold">{{ __('frontend.need_help') ?? 'Need Help?' }}</h3>
                            <p class="text-slate-300 text-xs">{{ __('frontend.support_team_ready') ?? 'Our support team is ready to assist you' }}</p>
                        </div>
                    </div>
                    <a href="mailto:support@{{ config('app.domain', 'example.com') }}?subject=Support - {{ $service->domain }}" 
                       class="block w-full text-center bg-white text-slate-800 font-medium py-2.5 rounded-lg hover:bg-slate-100 transition-colors text-sm">
                        {{ __('frontend.contact_support') ?? 'Contact Support' }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Copy Toast -->
<div id="copyToast" class="fixed bottom-4 {{ app()->getLocale() === 'ar' ? 'left-4' : 'right-4' }} bg-gray-900 text-white px-4 py-2.5 rounded-lg shadow-lg transform translate-y-full opacity-0 transition-all duration-300 z-50 flex items-center gap-2">
    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
    </svg>
    <span class="text-sm">{{ __('frontend.copied_to_clipboard') ?? 'Copied!' }}</span>
</div>
@endsection

@push('scripts')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        const toast = document.getElementById('copyToast');
        toast.classList.remove('translate-y-full', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');
        setTimeout(function() {
            toast.classList.remove('translate-y-0', 'opacity-100');
            toast.classList.add('translate-y-full', 'opacity-0');
        }, 2000);
    });
}

function confirmCancellation() {
    if (confirm('{{ __("frontend.confirm_cancellation") ?? "Are you sure you want to request cancellation?" }}')) {
        window.location.href = 'mailto:support@{{ config("app.domain", "example.com") }}?subject=Cancellation - {{ $service->domain }}';
    }
}
</script>
@endpush
