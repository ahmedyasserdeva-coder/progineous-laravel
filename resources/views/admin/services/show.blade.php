@extends('admin.layout')

@section('title', $service->service_name . ' - ' . __('crm.shared_hosting_management'))

@section('content')
@php
    $isArabic = app()->getLocale() == 'ar';
    
    $statusLabels = [
        'active' => $isArabic ? 'نشط' : 'Active',
        'pending' => $isArabic ? 'قيد الانتظار' : 'Pending',
        'suspended' => $isArabic ? 'معلق' : 'Suspended',
        'cancelled' => $isArabic ? 'ملغي' : 'Cancelled',
        'terminated' => $isArabic ? 'منتهي' : 'Terminated',
        'failed' => $isArabic ? 'فشل' : 'Failed',
    ];
    
    $billingCycleLabels = [
        'monthly' => __('crm.monthly'),
        'quarterly' => __('crm.quarterly'),
        'semi-annually' => __('crm.semi_annually'),
        'annually' => __('crm.annually'),
        'biennially' => __('crm.biennially'),
        'triennially' => __('crm.triennially'),
    ];
@endphp

<div class="container mx-auto px-4 py-6">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.clients.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    {{ __('crm.clients') }}
                </a>
            </li>
            @if($service->client)
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <a href="{{ route('admin.clients.show', $service->client) }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">
                        {{ $service->client->first_name }} {{ $service->client->last_name }}
                    </a>
                </div>
            </li>
            @endif
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-500">{{ __('crm.shared_hosting') }}</span>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-500">{{ $service->service_name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Header - Minimal Design -->
    <div class="bg-white border border-gray-200 rounded-2xl p-6 mb-6 shadow-sm">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <h1 class="text-xl font-bold text-gray-900">{{ $service->service_name }}</h1>
                        @php
                            $statusConfig = [
                                'active' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/20',
                                'pending' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-600/20',
                                'suspended' => 'bg-red-50 text-red-700 ring-1 ring-red-600/20',
                                'cancelled' => 'bg-gray-100 text-gray-600 ring-1 ring-gray-500/20',
                                'terminated' => 'bg-gray-100 text-gray-600 ring-1 ring-gray-500/20',
                                'failed' => 'bg-red-50 text-red-700 ring-1 ring-red-600/20',
                            ];
                        @endphp
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold {{ $statusConfig[$service->status] ?? 'bg-gray-100 text-gray-600' }}">
                            @if($service->status === 'active')
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                            @endif
                            {{ $statusLabels[$service->status] ?? ucfirst($service->status) }}
                        </span>
                    </div>
                    <div class="flex items-center gap-4 text-sm text-gray-500">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                            </svg>
                            {{ $service->id }}
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9"/>
                            </svg>
                            {{ $service->domain ?? '-' }}
                        </span>
                        @if($service->server)
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2"/>
                            </svg>
                            {{ $service->server->name }}
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-2">
                @if($service->client)
                <a href="{{ route('admin.clients.show', $service->client) }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-all text-sm font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    {{ $service->client->first_name }} {{ $service->client->last_name }}
                </a>
                @endif
                @if($service->status === 'active' && $service->username && $service->server)
                <a href="https://{{ $service->server->hostname }}:2083/login/?user={{ $service->username }}&pass={{ urlencode($service->decrypted_password) }}" target="_blank" 
                   class="inline-flex items-center gap-2 px-4 py-2.5 text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all text-sm font-medium shadow-lg shadow-blue-500/25">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    {{ $isArabic ? 'دخول cPanel' : 'cPanel Login' }}
                </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions - Minimal Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 mb-6">
        @if($service->status === 'active' && $service->username && $service->server)
        <!-- Change Password -->
        <button type="button" onclick="document.getElementById('changePasswordModal').classList.remove('hidden')" 
                class="group flex flex-col items-center gap-2 p-4 bg-white border border-gray-200 rounded-xl hover:border-purple-300 hover:bg-purple-50/50 transition-all">
            <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
            </div>
            <span class="text-xs font-medium text-gray-700 text-center">{{ $isArabic ? 'كلمة المرور' : 'Password' }}</span>
        </button>
                
        <!-- Change Username -->
        <button type="button" onclick="document.getElementById('changeUsernameModal').classList.remove('hidden')" 
                class="group flex flex-col items-center gap-2 p-4 bg-white border border-gray-200 rounded-xl hover:border-indigo-300 hover:bg-indigo-50/50 transition-all">
            <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center group-hover:bg-indigo-200 transition-colors">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <span class="text-xs font-medium text-gray-700 text-center">{{ $isArabic ? 'اسم المستخدم' : 'Username' }}</span>
        </button>
        @endif
        
        @if($service->status === 'active')
        <!-- Suspend -->
        <button type="button" onclick="document.getElementById('suspendModal').classList.remove('hidden')" 
                class="group flex flex-col items-center gap-2 p-4 bg-white border border-gray-200 rounded-xl hover:border-amber-300 hover:bg-amber-50/50 transition-all">
            <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center group-hover:bg-amber-200 transition-colors">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <span class="text-xs font-medium text-gray-700 text-center">{{ __('crm.suspend') }}</span>
        </button>
        @elseif($service->status === 'suspended')
        <form action="{{ route('admin.services.unsuspend', $service) }}" method="POST" class="contents">
            @csrf
            <button type="submit" class="group flex flex-col items-center gap-2 p-4 bg-white border border-gray-200 rounded-xl hover:border-green-300 hover:bg-green-50/50 transition-all">
                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center group-hover:bg-green-200 transition-colors">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-700 text-center">{{ __('crm.unsuspend') }}</span>
            </button>
        </form>
        @endif

        @if(!in_array($service->status, ['terminated', 'cancelled']))
        <!-- Terminate -->
        <form action="{{ route('admin.services.terminate', $service) }}" method="POST" class="contents">
            @csrf
            <button type="submit" onclick="return confirm('{{ __('crm.confirm_terminate') }}')" 
                    class="group flex flex-col items-center gap-2 p-4 bg-white border border-gray-200 rounded-xl hover:border-red-300 hover:bg-red-50/50 transition-all">
                <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center group-hover:bg-red-200 transition-colors">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-700 text-center">{{ __('crm.terminate') }}</span>
            </button>
        </form>
        @endif

        <!-- Delete -->
        <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="contents">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('{{ __('crm.confirm_delete_service') }}')" 
                    class="group flex flex-col items-center gap-2 p-4 bg-white border border-gray-200 rounded-xl hover:border-red-300 hover:bg-red-50/50 transition-all">
                <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center group-hover:bg-red-100 transition-colors">
                    <svg class="w-5 h-5 text-gray-500 group-hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-700 text-center">{{ __('crm.delete') }}</span>
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content - 2 columns -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Service Details -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-base font-semibold text-gray-900">{{ __('crm.service_details') }}</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="flex items-center justify-between p-4 bg-gray-50/50 rounded-xl hover:bg-gray-50 transition-colors">
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">{{ __('crm.service_name') }}</dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $service->service_name }}</dd>
                            </div>
                            @if($service->status === 'active' && $service->username && $service->server)
                            <button type="button" onclick="document.getElementById('changePackageModal').classList.remove('hidden')" 
                                    class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            @endif
                        </div>
                        <div class="flex items-center justify-between p-4 bg-gray-50/50 rounded-xl">
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">{{ __('crm.type') }}</dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ __('crm.shared_hosting') }}</dd>
                            </div>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-gray-50/50 rounded-xl hover:bg-gray-50 transition-colors">
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">{{ __('crm.domain') }}</dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $service->domain ?? '-' }}</dd>
                            </div>
                            @if($service->status === 'active' && $service->username && $service->server)
                            <button type="button" onclick="document.getElementById('changeDomainModal').classList.remove('hidden')" 
                                    class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            @endif
                        </div>
                        <div class="p-4 bg-gray-50/50 rounded-xl">
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">{{ __('crm.status') }}</dt>
                            <dd class="mt-2">
                                @php
                                    $statusBadge = [
                                        'active' => 'bg-emerald-100 text-emerald-700',
                                        'pending' => 'bg-amber-100 text-amber-700',
                                        'suspended' => 'bg-red-100 text-red-700',
                                        'cancelled' => 'bg-gray-100 text-gray-700',
                                        'terminated' => 'bg-gray-100 text-gray-700',
                                        'failed' => 'bg-red-100 text-red-700',
                                    ];
                                @endphp
                                <span class="px-3 py-1.5 text-xs font-semibold rounded-lg {{ $statusBadge[$service->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ $statusLabels[$service->status] ?? ucfirst($service->status) }}
                                </span>
                            </dd>
                        </div>
                        @if($service->package_name)
                        <div class="p-4 bg-gray-50/50 rounded-xl">
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">{{ __('crm.package') }}</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $service->package_name }}</dd>
                        </div>
                        @endif
                        @if($service->username)
                        <div class="p-4 bg-gray-50/50 rounded-xl">
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">{{ __('crm.username') }}</dt>
                            <dd class="mt-1 text-sm font-mono font-semibold text-gray-900">{{ $service->username }}</dd>
                        </div>
                        @endif
                        @if($service->cpanel_username)
                        <div class="p-4 bg-gray-50/50 rounded-xl">
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">cPanel {{ __('crm.username') }}</dt>
                            <dd class="mt-1 text-sm font-mono font-semibold text-gray-900">{{ $service->cpanel_username }}</dd>
                        </div>
                        @endif
                        @if($service->decrypted_password)
                        <div class="p-4 bg-gray-50/50 rounded-xl">
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">cPanel {{ $isArabic ? 'كلمة المرور' : 'Password' }}</dt>
                            <dd class="mt-1" x-data="{ show: false }">
                                <div class="flex items-center gap-2">
                                    <span x-show="!show" class="font-mono text-sm text-gray-900">••••••••</span>
                                    <span x-show="show" class="font-mono text-sm text-gray-900">{{ $service->decrypted_password }}</span>
                                    <button @click="show = !show" type="button" class="p-1 text-gray-400 hover:text-blue-600 rounded transition-colors">
                                        <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                    </button>
                                </div>
                            </dd>
                        </div>
                        @endif
                        @if($service->ip_address)
                        <div class="p-4 bg-gray-50/50 rounded-xl">
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">{{ __('crm.ip_address') }}</dt>
                            <dd class="mt-1 text-sm font-mono font-semibold text-gray-900">{{ $service->ip_address }}</dd>
                        </div>
                        @endif
                        @if($service->server)
                        <div class="flex items-center justify-between p-4 bg-gray-50/50 rounded-xl hover:bg-gray-50 transition-colors">
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">{{ $isArabic ? 'السيرفر' : 'Server' }}</dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $service->server->name ?? '-' }}</dd>
                            </div>
                            @if($service->status === 'active' && $service->username)
                            <button type="button" onclick="document.getElementById('changeServerModal').classList.remove('hidden')" 
                                    class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            @endif
                        </div>
                        @endif
                        @php
                            $datacenterName = null;
                            $currentDcCode = null;
                            // Try to get datacenter from orderItem configuration
                            if ($service->orderItem && isset($service->orderItem->configuration['datacenter_name'])) {
                                $datacenterName = $service->orderItem->configuration['datacenter_name'];
                                $currentDcCode = $service->orderItem->configuration['datacenter'] ?? null;
                            } elseif ($service->orderItem && isset($service->orderItem->configuration['datacenter'])) {
                                // Fallback: translate datacenter code to name
                                $datacenterCodes = [
                                    'us-east' => 'United States (East)',
                                    'us-west' => 'United States (West)',
                                    'eu-west' => 'Europe (West)',
                                    'eu-central' => 'Europe (Central)',
                                    'asia-pacific' => 'Asia Pacific',
                                    'australia' => 'Australia',
                                    'canada' => 'Canada',
                                    'uk' => 'United Kingdom',
                                    'germany' => 'Germany',
                                    'france' => 'France',
                                    'singapore' => 'Singapore',
                                    'japan' => 'Japan',
                                    'EGYPT' => 'Egypt',
                                ];
                                $currentDcCode = $service->orderItem->configuration['datacenter'];
                                $datacenterName = $datacenterCodes[$currentDcCode] ?? ucfirst(str_replace('-', ' ', $currentDcCode));
                            } elseif ($service->server_data && isset($service->server_data['datacenter_name'])) {
                                // Fallback: use server_data
                                $datacenterName = $service->server_data['datacenter_name'];
                                $currentDcCode = $service->server_data['datacenter'] ?? null;
                            } elseif ($service->server_data && isset($service->server_data['datacenter'])) {
                                $datacenterCodes = [
                                    'us-east' => 'United States (East)',
                                    'us-west' => 'United States (West)',
                                    'eu-west' => 'Europe (West)',
                                    'eu-central' => 'Europe (Central)',
                                    'asia-pacific' => 'Asia Pacific',
                                    'australia' => 'Australia',
                                    'canada' => 'Canada',
                                    'uk' => 'United Kingdom',
                                    'germany' => 'Germany',
                                    'france' => 'France',
                                    'singapore' => 'Singapore',
                                    'japan' => 'Japan',
                                    'EGYPT' => 'Egypt',
                                ];
                                $currentDcCode = $service->server_data['datacenter'];
                                $datacenterName = $datacenterCodes[$currentDcCode] ?? ucfirst(str_replace('-', ' ', $currentDcCode));
                            } elseif ($service->server && $service->server->datacenter) {
                                // Fallback: use server's datacenter
                                $datacenterName = $service->server->datacenter;
                            }
                        @endphp
                        <div class="flex items-center justify-between p-4 bg-gray-50/50 rounded-xl hover:bg-gray-50 transition-colors">
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">{{ $isArabic ? 'الداتا سنتر' : 'Datacenter' }}</dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    </svg>
                                    {{ $datacenterName ?? ($isArabic ? 'غير محدد' : 'Not Set') }}
                                </dd>
                            </div>
                            <button type="button" onclick="document.getElementById('changeDatacenterModal').classList.remove('hidden')" 
                                    class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Billing Information -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-base font-semibold text-gray-900">{{ __('crm.billing_info') }}</h3>
                </div>
                <div class="p-6">
                    @php
                        $firstPayment = $service->orderItem?->total ?? $service->order?->total ?? null;
                        $setupFee = $service->orderItem?->configuration['setup_fee'] ?? 0;
                    @endphp
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="p-4 bg-gradient-to-br from-gray-50 to-gray-100/50 rounded-xl">
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">{{ $isArabic ? 'الدفعة الأولى' : 'First Payment' }}</dt>
                            <dd class="mt-1 text-lg font-bold text-gray-900">
                                @if($firstPayment)
                                    ${{ number_format($firstPayment, 2) }}
                                    @if($setupFee > 0)
                                        <span class="text-xs font-normal text-gray-500">({{ $isArabic ? '+رسوم إعداد' : '+setup' }})</span>
                                    @endif
                                @else
                                    -
                                @endif
                            </dd>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-gradient-to-br from-emerald-50 to-emerald-100/50 rounded-xl hover:from-emerald-100 hover:to-emerald-100/50 transition-colors">
                            <div>
                                <dt class="text-xs font-medium text-emerald-600 uppercase tracking-wide">{{ __('crm.recurring_amount') }}</dt>
                                <dd class="mt-1 text-lg font-bold text-emerald-700">${{ number_format($service->recurring_amount ?? 0, 2) }}</dd>
                            </div>
                            <button type="button" onclick="document.getElementById('changeRecurringAmountModal').classList.remove('hidden')" 
                                    class="p-2 text-emerald-500 hover:text-emerald-700 hover:bg-emerald-100 rounded-lg transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-gray-50/50 rounded-xl hover:bg-gray-50 transition-colors">
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">{{ __('crm.billing_cycle') }}</dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $billingCycleLabels[strtolower($service->billing_cycle ?? '')] ?? ucfirst($service->billing_cycle ?? 'N/A') }}</dd>
                            </div>
                            <button type="button" onclick="document.getElementById('changeBillingCycleModal').classList.remove('hidden')" 
                                    class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                        </div>
                        @php
                            $dueDate = $service->next_due_date ? \Carbon\Carbon::parse($service->next_due_date) : null;
                            $daysUntilDue = $dueDate ? (int) now()->diffInDays($dueDate, false) : null;
                            $dueBgClass = $daysUntilDue !== null && $daysUntilDue <= 0 ? 'bg-red-50' : ($daysUntilDue !== null && $daysUntilDue < 7 ? 'bg-amber-50' : 'bg-gray-50/50');
                        @endphp
                        <div class="flex items-center justify-between p-4 {{ $dueBgClass }} rounded-xl hover:bg-gray-50 transition-colors">
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">{{ __('crm.next_due_date') }}</dt>
                                @if($dueDate)
                                    <dd class="mt-1 text-sm font-semibold {{ $daysUntilDue < 7 ? 'text-red-600' : ($daysUntilDue < 30 ? 'text-amber-600' : 'text-gray-900') }}">
                                        {{ $dueDate->format('M d, Y') }}
                                        @if($daysUntilDue < 30 && $daysUntilDue > 0)
                                            <span class="text-xs font-normal">({{ $daysUntilDue }} {{ __('crm.days_left') }})</span>
                                        @elseif($daysUntilDue <= 0)
                                            <span class="text-xs font-normal text-red-600">({{ $isArabic ? 'متأخر' : 'Overdue' }})</span>
                                        @endif
                                    </dd>
                                @else
                                    <dd class="mt-1 text-sm font-semibold text-gray-900">-</dd>
                                @endif
                            </div>
                            <button type="button" onclick="document.getElementById('changeNextDueDateModal').classList.remove('hidden')" 
                                    class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                        </div>
                        <div class="p-4 bg-gray-50/50 rounded-xl md:col-span-2">
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">{{ $isArabic ? 'تاريخ الشراء' : 'Purchase Date' }}</dt>
                            @php
                                $purchaseDate = $service->order?->created_at ?? $service->created_at;
                            @endphp
                            <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $purchaseDate ? \Carbon\Carbon::parse($purchaseDate)->format('M d, Y H:i') : '-' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Service Invoices -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-semibold text-gray-900">{{ $isArabic ? 'الفواتير' : 'Invoices' }}</h3>
                        @if(isset($invoices) && $invoices->count() > 0)
                            <span class="px-2 py-0.5 text-xs font-medium bg-gray-100 text-gray-600 rounded-full">{{ $invoices->count() }}</span>
                        @endif
                    </div>
                </div>
                <div class="p-6">
                    @if(isset($invoices) && $invoices->count() > 0)
                        <div class="space-y-3">
                            @foreach($invoices as $invoice)
                                @php
                                    $statusConfig = [
                                        'paid' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'ring' => 'ring-emerald-600/20', 'icon' => 'text-emerald-500'],
                                        'unpaid' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'ring' => 'ring-amber-600/20', 'icon' => 'text-amber-500'],
                                        'overdue' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'ring' => 'ring-red-600/20', 'icon' => 'text-red-500'],
                                        'cancelled' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-600', 'ring' => 'ring-gray-500/20', 'icon' => 'text-gray-400'],
                                        'refunded' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'ring' => 'ring-purple-600/20', 'icon' => 'text-purple-500'],
                                    ];
                                    $config = $statusConfig[$invoice->status] ?? $statusConfig['unpaid'];
                                    
                                    $statusLabelsInvoice = [
                                        'paid' => $isArabic ? 'مدفوعة' : 'Paid',
                                        'unpaid' => $isArabic ? 'غير مدفوعة' : 'Unpaid',
                                        'overdue' => $isArabic ? 'متأخرة' : 'Overdue',
                                        'cancelled' => $isArabic ? 'ملغاة' : 'Cancelled',
                                        'refunded' => $isArabic ? 'مستردة' : 'Refunded',
                                        'partially_paid' => $isArabic ? 'مدفوعة جزئياً' : 'Partially Paid',
                                    ];
                                @endphp
                                <a href="{{ route('admin.invoices.show', $invoice) }}" 
                                   class="block p-4 bg-gray-50/50 rounded-xl hover:bg-gray-100/70 transition-all group">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 {{ $config['bg'] }} rounded-lg flex items-center justify-center">
                                                @if($invoice->status === 'paid')
                                                    <svg class="w-4 h-4 {{ $config['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                @elseif($invoice->status === 'overdue')
                                                    <svg class="w-4 h-4 {{ $config['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4 {{ $config['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                @endif
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">
                                                    #{{ $invoice->invoice_number }}
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    {{ $invoice->invoice_date ? \Carbon\Carbon::parse($invoice->invoice_date)->format('M d, Y') : $invoice->created_at->format('M d, Y') }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-bold text-gray-900">${{ number_format($invoice->total, 2) }}</p>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium {{ $config['bg'] }} {{ $config['text'] }} ring-1 {{ $config['ring'] }}">
                                                {{ $statusLabelsInvoice[$invoice->status] ?? ucfirst($invoice->status) }}
                                            </span>
                                        </div>
                                    </div>
                                    @if($invoice->due_date && $invoice->status !== 'paid')
                                        <div class="flex items-center gap-1.5 text-xs text-gray-500 mt-2 pt-2 border-t border-gray-200/50">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            {{ $isArabic ? 'تاريخ الاستحقاق:' : 'Due:' }} {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}
                                        </div>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <p class="text-sm text-gray-500">{{ $isArabic ? 'لا توجد فواتير لهذه الخدمة' : 'No invoices for this service' }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Notes -->
            @if($service->notes)
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-base font-semibold text-gray-900">{{ __('crm.notes') }}</h3>
                </div>
                <div class="p-6">
                    <p class="text-sm text-gray-700 whitespace-pre-wrap leading-relaxed">{{ $service->notes }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Client Info -->
            @if($service->client)
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-blue-500/20">
                            {{ strtoupper(substr($service->client->first_name, 0, 1)) }}{{ strtoupper(substr($service->client->last_name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-900 truncate">{{ $service->client->first_name }} {{ $service->client->last_name }}</p>
                            <p class="text-sm text-gray-500 truncate">{{ $service->client->email }}</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.clients.show', $service->client) }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-blue-700 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        {{ __('crm.view_client') }}
                    </a>
                </div>
            </div>
            @endif

            <!-- Activity Timeline -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-base font-semibold text-gray-900">{{ $isArabic ? 'سجل النشاط' : 'Activity' }}</h3>
                </div>
                <div class="p-6">
                    <div class="relative">
                        <div class="absolute {{ $isArabic ? 'right-2' : 'left-2' }} top-0 bottom-0 w-0.5 bg-gray-100"></div>
                        <div class="space-y-6">
                            <div class="relative flex gap-4">
                                <div class="w-5 h-5 bg-blue-500 rounded-full flex items-center justify-center ring-4 ring-white z-10">
                                    <div class="w-2 h-2 bg-white rounded-full"></div>
                                </div>
                                <div class="flex-1 pb-2">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">{{ __('crm.created_at') }}</p>
                                    <p class="text-sm font-semibold text-gray-900">{{ $service->created_at->format('M d, Y H:i') }}</p>
                                </div>
                            </div>
                            @if($service->activated_at)
                            <div class="relative flex gap-4">
                                <div class="w-5 h-5 bg-emerald-500 rounded-full flex items-center justify-center ring-4 ring-white z-10">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                </div>
                                <div class="flex-1 pb-2">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">{{ __('crm.activated_at') }}</p>
                                    <p class="text-sm font-semibold text-emerald-600">{{ $service->activated_at->format('M d, Y H:i') }}</p>
                                </div>
                            </div>
                            @endif
                            @if($service->suspended_at)
                            <div class="relative flex gap-4">
                                <div class="w-5 h-5 bg-amber-500 rounded-full flex items-center justify-center ring-4 ring-white z-10">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6"/></svg>
                                </div>
                                <div class="flex-1 pb-2">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">{{ __('crm.suspended_at') }}</p>
                                    <p class="text-sm font-semibold text-amber-600">{{ $service->suspended_at->format('M d, Y H:i') }}</p>
                                </div>
                            </div>
                            @endif
                            @if($service->terminated_at)
                            <div class="relative flex gap-4">
                                <div class="w-5 h-5 bg-red-500 rounded-full flex items-center justify-center ring-4 ring-white z-10">
                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">{{ __('crm.terminated_at') }}</p>
                                    <p class="text-sm font-semibold text-red-600">{{ $service->terminated_at->format('M d, Y H:i') }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals (outside grid) -->
    <!-- Suspend Modal -->
            <div id="suspendModal" class="fixed inset-0 z-50 hidden" onclick="if(event.target === this) this.classList.add('hidden')">
                <!-- Backdrop -->
                <div class="fixed inset-0 bg-black/50"></div>
                <!-- Modal Content -->
                <div class="fixed inset-0 flex items-center justify-center">
                    <div class="relative bg-white rounded-lg shadow-xl w-96 mx-4 p-5 z-10" onclick="event.stopPropagation()">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ __('crm.suspend') }}
                        </h3>
                        <button type="button" onclick="document.getElementById('suspendModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <form action="{{ route('admin.services.suspend', $service) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('crm.suspension_reason') }}
                            </label>
                            <!-- Custom Dropdown -->
                            <div class="relative" x-data="{ open: false, selected: 'Non-payment', selectedLabel: '{{ $isArabic ? 'عدم الدفع' : 'Non-payment' }}', isOther: false }">
                                <input type="hidden" name="reason" :value="selected">
                                
                                <!-- Dropdown Button -->
                                <button type="button" @click="open = !open" 
                                        class="w-full flex items-center justify-between px-4 py-2.5 text-sm bg-white border border-gray-300 rounded-lg hover:border-amber-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">
                                    <div class="flex items-center gap-2">
                                        <template x-if="selected === 'Non-payment'">
                                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </template>
                                        <template x-if="selected === 'Invoice Overdue'">
                                            <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </template>
                                        <template x-if="selected === 'Terms of Service Violation'">
                                            <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </template>
                                        <template x-if="selected === 'Abuse/Spam'">
                                            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                            </svg>
                                        </template>
                                        <template x-if="selected === 'Security Issue'">
                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                            </svg>
                                        </template>
                                        <template x-if="selected === 'Resource Overuse'">
                                            <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                            </svg>
                                        </template>
                                        <template x-if="selected === 'Client Request'">
                                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </template>
                                        <template x-if="selected === 'Fraudulent Activity'">
                                            <svg class="w-4 h-4 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                            </svg>
                                        </template>
                                        <template x-if="selected === 'Administrative Action'">
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </template>
                                        <template x-if="selected === 'other'">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </template>
                                        <span x-text="selectedLabel" class="text-gray-700"></span>
                                    </div>
                                    <svg class="w-4 h-4 text-gray-400 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                
                                <!-- Dropdown Menu -->
                                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                                     class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden">
                                    <div class="max-h-60 overflow-y-auto">
                                        <!-- Non-payment -->
                                        <button type="button" @click="selected = 'Non-payment'; selectedLabel = '{{ $isArabic ? 'عدم الدفع' : 'Non-payment' }}'; isOther = false; open = false" 
                                                class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-amber-50 transition-colors"
                                                :class="{ 'bg-amber-50': selected === 'Non-payment' }">
                                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ $isArabic ? 'عدم الدفع' : 'Non-payment' }}
                                        </button>
                                        
                                        <!-- Invoice Overdue -->
                                        <button type="button" @click="selected = 'Invoice Overdue'; selectedLabel = '{{ $isArabic ? 'تجاوز موعد دفع الفاتورة' : 'Invoice Overdue' }}'; isOther = false; open = false" 
                                                class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-amber-50 transition-colors"
                                                :class="{ 'bg-amber-50': selected === 'Invoice Overdue' }">
                                            <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ $isArabic ? 'تجاوز موعد دفع الفاتورة' : 'Invoice Overdue' }}
                                        </button>
                                        
                                        <!-- Terms Violation -->
                                        <button type="button" @click="selected = 'Terms of Service Violation'; selectedLabel = '{{ $isArabic ? 'مخالفة شروط الخدمة' : 'Terms of Service Violation' }}'; isOther = false; open = false" 
                                                class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-amber-50 transition-colors"
                                                :class="{ 'bg-amber-50': selected === 'Terms of Service Violation' }">
                                            <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            {{ $isArabic ? 'مخالفة شروط الخدمة' : 'Terms of Service Violation' }}
                                        </button>
                                        
                                        <!-- Abuse/Spam -->
                                        <button type="button" @click="selected = 'Abuse/Spam'; selectedLabel = '{{ $isArabic ? 'إساءة استخدام / رسائل مزعجة' : 'Abuse/Spam' }}'; isOther = false; open = false" 
                                                class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-amber-50 transition-colors"
                                                :class="{ 'bg-amber-50': selected === 'Abuse/Spam' }">
                                            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                            </svg>
                                            {{ $isArabic ? 'إساءة استخدام / رسائل مزعجة' : 'Abuse/Spam' }}
                                        </button>
                                        
                                        <!-- Security Issue -->
                                        <button type="button" @click="selected = 'Security Issue'; selectedLabel = '{{ $isArabic ? 'مشكلة أمنية' : 'Security Issue' }}'; isOther = false; open = false" 
                                                class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-amber-50 transition-colors"
                                                :class="{ 'bg-amber-50': selected === 'Security Issue' }">
                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                            </svg>
                                            {{ $isArabic ? 'مشكلة أمنية' : 'Security Issue' }}
                                        </button>
                                        
                                        <!-- Resource Overuse -->
                                        <button type="button" @click="selected = 'Resource Overuse'; selectedLabel = '{{ $isArabic ? 'استهلاك زائد للموارد' : 'Resource Overuse' }}'; isOther = false; open = false" 
                                                class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-amber-50 transition-colors"
                                                :class="{ 'bg-amber-50': selected === 'Resource Overuse' }">
                                            <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                            </svg>
                                            {{ $isArabic ? 'استهلاك زائد للموارد' : 'Resource Overuse' }}
                                        </button>
                                        
                                        <!-- Client Request -->
                                        <button type="button" @click="selected = 'Client Request'; selectedLabel = '{{ $isArabic ? 'طلب العميل' : 'Client Request' }}'; isOther = false; open = false" 
                                                class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-amber-50 transition-colors"
                                                :class="{ 'bg-amber-50': selected === 'Client Request' }">
                                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            {{ $isArabic ? 'طلب العميل' : 'Client Request' }}
                                        </button>
                                        
                                        <!-- Fraudulent Activity -->
                                        <button type="button" @click="selected = 'Fraudulent Activity'; selectedLabel = '{{ $isArabic ? 'نشاط احتيالي' : 'Fraudulent Activity' }}'; isOther = false; open = false" 
                                                class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-amber-50 transition-colors"
                                                :class="{ 'bg-amber-50': selected === 'Fraudulent Activity' }">
                                            <svg class="w-4 h-4 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                            </svg>
                                            {{ $isArabic ? 'نشاط احتيالي' : 'Fraudulent Activity' }}
                                        </button>
                                        
                                        <!-- Administrative Action -->
                                        <button type="button" @click="selected = 'Administrative Action'; selectedLabel = '{{ $isArabic ? 'إجراء إداري' : 'Administrative Action' }}'; isOther = false; open = false" 
                                                class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-amber-50 transition-colors"
                                                :class="{ 'bg-amber-50': selected === 'Administrative Action' }">
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            {{ $isArabic ? 'إجراء إداري' : 'Administrative Action' }}
                                        </button>
                                        
                                        <!-- Divider -->
                                        <div class="border-t border-gray-100"></div>
                                        
                                        <!-- Other -->
                                        <button type="button" @click="selected = 'other'; selectedLabel = '{{ $isArabic ? 'سبب آخر...' : 'Other reason...' }}'; isOther = true; open = false" 
                                                class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-amber-50 transition-colors"
                                                :class="{ 'bg-amber-50': selected === 'other' }">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ $isArabic ? 'سبب آخر...' : 'Other reason...' }}
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Custom reason input -->
                                <input x-show="isOther" type="text" name="custom_reason" 
                                       placeholder="{{ $isArabic ? 'أدخل السبب...' : 'Enter reason...' }}"
                                       class="mt-2 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                       x-transition>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <button type="button" onclick="document.getElementById('suspendModal').classList.add('hidden')" 
                                    class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                {{ __('crm.cancel') }}
                            </button>
                            <button type="submit" 
                                    class="flex-1 px-4 py-2 text-sm font-medium text-white bg-amber-500 rounded-lg hover:bg-amber-600 transition-colors">
                                {{ __('crm.suspend') }}
                            </button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>

            <!-- Change Password Modal -->
            <div id="changePasswordModal" class="fixed inset-0 z-50 hidden" onclick="if(event.target === this) this.classList.add('hidden')">
                <!-- Backdrop -->
                <div class="fixed inset-0 bg-black/50"></div>
                <!-- Modal Content -->
                <div class="fixed inset-0 flex items-center justify-center">
                    <div class="relative bg-white rounded-lg shadow-xl w-96 mx-4 p-5 z-10" onclick="event.stopPropagation()">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                </svg>
                                {{ $isArabic ? 'تغيير كلمة مرور cPanel' : 'Change cPanel Password' }}
                            </h3>
                            <button type="button" onclick="document.getElementById('changePasswordModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <form action="{{ route('admin.services.change-password', $service) }}" method="POST" x-data="{ password: '', showPassword: false }">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ $isArabic ? 'كلمة المرور الجديدة' : 'New Password' }}
                                </label>
                                <div class="relative">
                                    <input :type="showPassword ? 'text' : 'password'" name="password" x-model="password" required minlength="8"
                                           class="w-full px-4 py-2.5 pe-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                           placeholder="{{ $isArabic ? 'أدخل كلمة المرور الجديدة' : 'Enter new password' }}">
                                    <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 {{ $isArabic ? 'left-0 pl-3' : 'right-0 pr-3' }} flex items-center text-gray-400 hover:text-gray-600">
                                        <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                        </svg>
                                    </button>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">{{ $isArabic ? 'يجب أن تكون 8 أحرف على الأقل' : 'Must be at least 8 characters' }}</p>
                            </div>
                            <div class="mb-4">
                                <button type="button" @click="password = '{{ \Illuminate\Support\Str::random(16) }}'" class="text-sm text-purple-600 hover:text-purple-800">
                                    {{ $isArabic ? 'توليد كلمة مرور عشوائية' : 'Generate random password' }}
                                </button>
                            </div>
                            <div class="flex gap-3">
                                <button type="button" onclick="document.getElementById('changePasswordModal').classList.add('hidden')" 
                                        class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                    {{ __('crm.cancel') }}
                                </button>
                                <button type="submit" 
                                        class="flex-1 px-4 py-2 text-sm font-medium text-white bg-purple-500 rounded-lg hover:bg-purple-600 transition-colors">
                                    {{ $isArabic ? 'تغيير' : 'Change' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Change Username Modal -->
            <div id="changeUsernameModal" class="fixed inset-0 z-50 hidden" onclick="this.classList.add('hidden')">
                <!-- Backdrop -->
                <div class="fixed inset-0 bg-gray-500/75 transition-opacity"></div>
                
                <!-- Modal Content -->
                <div class="fixed inset-0 flex items-center justify-center">
                    <div class="relative bg-white rounded-lg shadow-xl w-96 mx-4 p-5 z-10" onclick="event.stopPropagation()">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                {{ $isArabic ? 'تغيير اسم المستخدم cPanel' : 'Change cPanel Username' }}
                            </h3>
                            <button type="button" onclick="document.getElementById('changeUsernameModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <form action="{{ route('admin.services.change-username', $service) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ $isArabic ? 'اسم المستخدم الحالي' : 'Current Username' }}
                                </label>
                                <input type="text" value="{{ $service->username }}" readonly
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ $isArabic ? 'اسم المستخدم الجديد' : 'New Username' }}
                                </label>
                                <input type="text" name="username" required minlength="1" maxlength="16" pattern="[a-zA-Z][a-zA-Z0-9]*"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                       placeholder="{{ $isArabic ? 'أدخل اسم المستخدم الجديد' : 'Enter new username' }}">
                                <p class="mt-1 text-xs text-gray-500">{{ $isArabic ? 'يجب أن يبدأ بحرف، بدون مسافات، أقصى 16 حرف' : 'Must start with letter, no spaces, max 16 chars' }}</p>
                            </div>
                            <div class="bg-amber-50 border border-amber-200 rounded-lg p-3 mb-4">
                                <p class="text-xs text-amber-700">
                                    <svg class="w-4 h-4 inline-block {{ $isArabic ? 'ml-1' : 'mr-1' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                    {{ $isArabic ? 'تحذير: تغيير اسم المستخدم سيؤثر على جميع خدمات cPanel المرتبطة' : 'Warning: Changing username will affect all related cPanel services' }}
                                </p>
                            </div>
                            <div class="flex gap-3">
                                <button type="button" onclick="document.getElementById('changeUsernameModal').classList.add('hidden')" 
                                        class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                    {{ __('crm.cancel') }}
                                </button>
                                <button type="submit" 
                                        class="flex-1 px-4 py-2 text-sm font-medium text-white bg-indigo-500 rounded-lg hover:bg-indigo-600 transition-colors">
                                    {{ $isArabic ? 'تغيير' : 'Change' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Change Package Modal -->
            <div id="changePackageModal" class="fixed inset-0 z-50 hidden" onclick="this.classList.add('hidden')">
                <!-- Backdrop -->
                <div class="fixed inset-0 bg-gray-500/75 transition-opacity"></div>
                
                <!-- Modal Content -->
                <div class="fixed inset-0 flex items-center justify-center">
                    <div class="relative bg-white rounded-lg shadow-xl w-[450px] mx-4 p-5 z-10" onclick="event.stopPropagation()">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                                {{ $isArabic ? 'تغيير الخطة' : 'Change Package' }}
                            </h3>
                            <button type="button" onclick="document.getElementById('changePackageModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <form action="{{ route('admin.services.change-package', $service) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ $isArabic ? 'الخطة الحالية' : 'Current Package' }}
                                </label>
                                @php
                                    $currentPackage = $service->package_name 
                                        ?? $service->whm_package 
                                        ?? ($service->server_data['whm_package'] ?? null);
                                @endphp
                                <input type="text" value="{{ $currentPackage ?? '-' }}" readonly
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ $isArabic ? 'الخطة الجديدة' : 'New Package' }}
                                </label>
                                @php
                                    $hostingProducts = \App\Models\Product::where('is_active', true)
                                        ->whereNotNull('whm_package_name')
                                        ->where('server_id', $service->server_id)
                                        ->get();
                                @endphp
                                <select name="product_id" id="packageSelect" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        onchange="document.getElementById('selectedWhmPackage').value = this.options[this.selectedIndex].dataset.whmPackage">
                                    <option value="">{{ $isArabic ? 'اختر الخطة' : 'Select Package' }}</option>
                                    @foreach($hostingProducts as $product)
                                        <option value="{{ $product->id }}" 
                                                data-whm-package="{{ $product->whm_package_name }}"
                                                {{ $service->product_id == $product->id ? 'disabled' : '' }}>
                                            {{ $product->name }} ({{ $product->whm_package_name }})
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="package" id="selectedWhmPackage" value="">
                                <p class="mt-1 text-xs text-gray-500">{{ $isArabic ? 'اختر من الخطط المتاحة على نفس السيرفر' : 'Choose from available packages on the same server' }}</p>
                            </div>
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                                <p class="text-xs text-blue-700">
                                    <svg class="w-4 h-4 inline-block {{ $isArabic ? 'ml-1' : 'mr-1' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $isArabic ? 'ملاحظة: تغيير الخطة سيغير موارد الحساب (المساحة، الباندويث، إلخ)' : 'Note: Changing package will modify account resources (disk, bandwidth, etc.)' }}
                                </p>
                            </div>
                            <div class="flex gap-3">
                                <button type="button" onclick="document.getElementById('changePackageModal').classList.add('hidden')" 
                                        class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                    {{ __('crm.cancel') }}
                                </button>
                                <button type="submit" 
                                        class="flex-1 px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-600 transition-colors">
                                    {{ $isArabic ? 'تغيير' : 'Change' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Change Domain Modal -->
            <div id="changeDomainModal" class="fixed inset-0 z-50 hidden" onclick="this.classList.add('hidden')">
                <!-- Backdrop -->
                <div class="fixed inset-0 bg-gray-500/75 transition-opacity"></div>
                
                <!-- Modal Content -->
                <div class="fixed inset-0 flex items-center justify-center">
                    <div class="relative bg-white rounded-lg shadow-xl w-[450px] mx-4 p-5 z-10" onclick="event.stopPropagation()">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                </svg>
                                {{ $isArabic ? 'تغيير الدومين' : 'Change Domain' }}
                            </h3>
                            <button type="button" onclick="document.getElementById('changeDomainModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <form action="{{ route('admin.services.change-domain', $service) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ $isArabic ? 'الدومين الحالي' : 'Current Domain' }}
                                </label>
                                <input type="text" value="{{ $service->domain ?? '-' }}" readonly
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ $isArabic ? 'الدومين الجديد' : 'New Domain' }}
                                </label>
                                <input type="text" name="new_domain" required placeholder="example.com"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <p class="mt-1 text-xs text-gray-500">{{ $isArabic ? 'أدخل اسم الدومين الجديد بدون http أو www' : 'Enter new domain name without http or www' }}</p>
                            </div>
                            <div class="bg-amber-50 border border-amber-200 rounded-lg p-3 mb-4">
                                <p class="text-xs text-amber-700">
                                    <svg class="w-4 h-4 inline-block {{ $isArabic ? 'ml-1' : 'mr-1' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                    {{ $isArabic ? 'تحذير: تغيير الدومين سيغير الدومين الرئيسي للحساب على السيرفر. تأكد من تحديث إعدادات DNS للدومين الجديد.' : 'Warning: Changing domain will modify the primary domain on the server. Make sure to update DNS settings for the new domain.' }}
                                </p>
                            </div>
                            <div class="flex gap-3">
                                <button type="button" onclick="document.getElementById('changeDomainModal').classList.add('hidden')" 
                                        class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                    {{ __('crm.cancel') }}
                                </button>
                                <button type="submit" 
                                        class="flex-1 px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-600 transition-colors">
                                    {{ $isArabic ? 'تغيير' : 'Change' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Change Recurring Amount Modal -->
            <!-- Change Next Due Date Modal -->
            <div id="changeNextDueDateModal" class="fixed inset-0 z-50 hidden" onclick="this.classList.add('hidden')">
                <!-- Backdrop -->
                <div class="fixed inset-0 bg-gray-500/75 transition-opacity"></div>
                
                <!-- Modal Content -->
                <div class="fixed inset-0 flex items-center justify-center">
                    <div class="relative bg-white rounded-lg shadow-xl w-[450px] mx-4 p-5 z-10" onclick="event.stopPropagation()">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $isArabic ? 'تغيير تاريخ الاستحقاق' : 'Change Next Due Date' }}
                            </h3>
                            <button type="button" onclick="document.getElementById('changeNextDueDateModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <form action="{{ route('admin.services.change-next-due-date', $service) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ $isArabic ? 'التاريخ الحالي' : 'Current Date' }}
                                </label>
                                <input type="text" value="{{ $service->next_due_date ? \Carbon\Carbon::parse($service->next_due_date)->format('Y-m-d') : '-' }}" readonly
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ $isArabic ? 'التاريخ الجديد' : 'New Date' }}
                                </label>
                                <input type="date" name="next_due_date" required
                                       value="{{ $service->next_due_date ? \Carbon\Carbon::parse($service->next_due_date)->format('Y-m-d') : now()->format('Y-m-d') }}"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">{{ $isArabic ? 'اختصارات سريعة' : 'Quick Options' }}</label>
                                <div class="flex flex-wrap gap-2">
                                    <button type="button" onclick="setDueDateOffset(1, 'month')" class="px-3 py-1.5 text-xs bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">+1 {{ $isArabic ? 'شهر' : 'Month' }}</button>
                                    <button type="button" onclick="setDueDateOffset(3, 'month')" class="px-3 py-1.5 text-xs bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">+3 {{ $isArabic ? 'أشهر' : 'Months' }}</button>
                                    <button type="button" onclick="setDueDateOffset(6, 'month')" class="px-3 py-1.5 text-xs bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">+6 {{ $isArabic ? 'أشهر' : 'Months' }}</button>
                                    <button type="button" onclick="setDueDateOffset(1, 'year')" class="px-3 py-1.5 text-xs bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">+1 {{ $isArabic ? 'سنة' : 'Year' }}</button>
                                    <button type="button" onclick="setDueDateOffset(2, 'year')" class="px-3 py-1.5 text-xs bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">+2 {{ $isArabic ? 'سنة' : 'Years' }}</button>
                                </div>
                            </div>
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                                <p class="text-xs text-blue-700">
                                    <svg class="w-4 h-4 inline-block {{ $isArabic ? 'ml-1' : 'mr-1' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $isArabic ? 'سيتم استخدام هذا التاريخ لإنشاء فواتير التجديد وإرسال التذكيرات.' : 'This date will be used for generating renewal invoices and sending reminders.' }}
                                </p>
                            </div>
                            <div class="flex gap-3">
                                <button type="button" onclick="document.getElementById('changeNextDueDateModal').classList.add('hidden')" 
                                        class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                    {{ __('crm.cancel') }}
                                </button>
                                <button type="submit" 
                                        class="flex-1 px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-600 transition-colors">
                                    {{ $isArabic ? 'تغيير' : 'Change' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                function setDueDateOffset(amount, unit) {
                    const dateInput = document.querySelector('#changeNextDueDateModal input[name="next_due_date"]');
                    const currentDate = new Date();
                    
                    if (unit === 'month') {
                        currentDate.setMonth(currentDate.getMonth() + amount);
                    } else if (unit === 'year') {
                        currentDate.setFullYear(currentDate.getFullYear() + amount);
                    }
                    
                    dateInput.value = currentDate.toISOString().split('T')[0];
                }
            </script>

            <!-- Change Billing Cycle Modal -->
            <div id="changeBillingCycleModal" class="fixed inset-0 z-50 hidden" onclick="this.classList.add('hidden')">
                <!-- Backdrop -->
                <div class="fixed inset-0 bg-gray-500/75 transition-opacity"></div>
                
                <!-- Modal Content -->
                <div class="fixed inset-0 flex items-center justify-center">
                    <div class="relative bg-white rounded-lg shadow-xl w-[450px] mx-4 p-5 z-10" onclick="event.stopPropagation()">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $isArabic ? 'تغيير دورة الفوترة' : 'Change Billing Cycle' }}
                            </h3>
                            <button type="button" onclick="document.getElementById('changeBillingCycleModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <form action="{{ route('admin.services.change-billing-cycle', $service) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ $isArabic ? 'الدورة الحالية' : 'Current Cycle' }}
                                </label>
                                <input type="text" value="{{ $billingCycleLabels[strtolower($service->billing_cycle ?? '')] ?? ucfirst($service->billing_cycle ?? 'N/A') }}" readonly
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ $isArabic ? 'الدورة الجديدة' : 'New Cycle' }}
                                </label>
                                <select name="billing_cycle" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">{{ $isArabic ? 'اختر الدورة' : 'Select Cycle' }}</option>
                                    <option value="monthly" {{ strtolower($service->billing_cycle ?? '') === 'monthly' ? 'selected' : '' }}>{{ $isArabic ? 'شهري' : 'Monthly' }}</option>
                                    <option value="quarterly" {{ strtolower($service->billing_cycle ?? '') === 'quarterly' ? 'selected' : '' }}>{{ $isArabic ? 'ربع سنوي (3 أشهر)' : 'Quarterly (3 Months)' }}</option>
                                    <option value="semi_annually" {{ in_array(strtolower($service->billing_cycle ?? ''), ['semi_annually', 'semiannually']) ? 'selected' : '' }}>{{ $isArabic ? 'نصف سنوي (6 أشهر)' : 'Semi-Annually (6 Months)' }}</option>
                                    <option value="annually" {{ strtolower($service->billing_cycle ?? '') === 'annually' ? 'selected' : '' }}>{{ $isArabic ? 'سنوي' : 'Annually (1 Year)' }}</option>
                                    <option value="biennially" {{ strtolower($service->billing_cycle ?? '') === 'biennially' ? 'selected' : '' }}>{{ $isArabic ? 'كل سنتين' : 'Biennially (2 Years)' }}</option>
                                    <option value="triennially" {{ strtolower($service->billing_cycle ?? '') === 'triennially' ? 'selected' : '' }}>{{ $isArabic ? 'كل 3 سنوات' : 'Triennially (3 Years)' }}</option>
                                </select>
                                <p class="mt-1 text-xs text-gray-500">{{ $isArabic ? 'اختر دورة الفوترة الجديدة للخدمة' : 'Select the new billing cycle for this service' }}</p>
                            </div>
                            <div class="mb-4">
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="recalculate_due_date" value="1" checked
                                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    <span class="text-sm text-gray-700">{{ $isArabic ? 'إعادة حساب تاريخ الاستحقاق' : 'Recalculate next due date' }}</span>
                                </label>
                            </div>
                            <div class="bg-amber-50 border border-amber-200 rounded-lg p-3 mb-4">
                                <p class="text-xs text-amber-700">
                                    <svg class="w-4 h-4 inline-block {{ $isArabic ? 'ml-1' : 'mr-1' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $isArabic ? 'ملاحظة: تغيير دورة الفوترة لن يُعدّل المبلغ المتكرر تلقائياً. يرجى تحديث المبلغ يدوياً إذا لزم الأمر.' : 'Note: Changing the billing cycle will not automatically adjust the recurring amount. Please update the amount manually if needed.' }}
                                </p>
                            </div>
                            <div class="flex gap-3">
                                <button type="button" onclick="document.getElementById('changeBillingCycleModal').classList.add('hidden')" 
                                        class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                    {{ __('crm.cancel') }}
                                </button>
                                <button type="submit" 
                                        class="flex-1 px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-600 transition-colors">
                                    {{ $isArabic ? 'تغيير' : 'Change' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div id="changeRecurringAmountModal" class="fixed inset-0 z-50 hidden" onclick="this.classList.add('hidden')">
                <!-- Backdrop -->
                <div class="fixed inset-0 bg-gray-500/75 transition-opacity"></div>
                
                <!-- Modal Content -->
                <div class="fixed inset-0 flex items-center justify-center">
                    <div class="relative bg-white rounded-lg shadow-xl w-[450px] mx-4 p-5 z-10" onclick="event.stopPropagation()">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $isArabic ? 'تغيير المبلغ المتكرر' : 'Change Recurring Amount' }}
                            </h3>
                            <button type="button" onclick="document.getElementById('changeRecurringAmountModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <form action="{{ route('admin.services.change-recurring-amount', $service) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ $isArabic ? 'المبلغ الحالي' : 'Current Amount' }}
                                </label>
                                <input type="text" value="${{ number_format($service->recurring_amount ?? 0, 2) }}" readonly
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ $isArabic ? 'المبلغ الجديد (USD)' : 'New Amount (USD)' }}
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 {{ $isArabic ? 'right-0 pr-3' : 'left-0 pl-3' }} flex items-center text-gray-500">$</span>
                                    <input type="number" name="recurring_amount" step="0.01" min="0" required
                                           value="{{ $service->recurring_amount ?? 0 }}"
                                           class="w-full px-4 py-2.5 {{ $isArabic ? 'pr-8' : 'pl-8' }} border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <p class="mt-1 text-xs text-gray-500">{{ $isArabic ? 'أدخل المبلغ المتكرر الجديد للخدمة' : 'Enter the new recurring amount for this service' }}</p>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ $isArabic ? 'سبب التغيير (اختياري)' : 'Reason for Change (Optional)' }}
                                </label>
                                <textarea name="reason" rows="2" 
                                          class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="{{ $isArabic ? 'مثال: ترقية الخطة، خصم خاص...' : 'e.g., Plan upgrade, special discount...' }}"></textarea>
                            </div>
                            <div class="flex gap-3">
                                <button type="button" onclick="document.getElementById('changeRecurringAmountModal').classList.add('hidden')" 
                                        class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                    {{ __('crm.cancel') }}
                                </button>
                                <button type="submit" 
                                        class="flex-1 px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-600 transition-colors">
                                    {{ $isArabic ? 'تحديث' : 'Update' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Change Datacenter Modal -->
            <div id="changeDatacenterModal" class="fixed inset-0 z-50 hidden" onclick="this.classList.add('hidden')">
                <!-- Backdrop -->
                <div class="fixed inset-0 bg-gray-500/75 transition-opacity"></div>
                
                <!-- Modal Content -->
                <div class="fixed inset-0 flex items-center justify-center">
                    <div class="relative bg-white rounded-lg shadow-xl w-[450px] mx-4 p-5 z-10" onclick="event.stopPropagation()">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $isArabic ? 'تغيير الداتا سنتر' : 'Change Datacenter' }}
                            </h3>
                            <button type="button" onclick="document.getElementById('changeDatacenterModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <form action="{{ route('admin.services.change-datacenter', $service) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ $isArabic ? 'الداتا سنتر الحالي' : 'Current Datacenter' }}
                                </label>
                                <input type="text" value="{{ $datacenterName ?? ($isArabic ? 'غير محدد' : 'Not Set') }}" readonly
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ $isArabic ? 'الداتا سنتر الجديد' : 'New Datacenter' }}
                                </label>
                                <select name="datacenter" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">{{ $isArabic ? 'اختر الداتا سنتر' : 'Select Datacenter' }}</option>
                                    <option value="us-east" {{ $currentDcCode === 'us-east' ? 'selected' : '' }}>United States (East)</option>
                                    <option value="us-west" {{ $currentDcCode === 'us-west' ? 'selected' : '' }}>United States (West)</option>
                                    <option value="eu-west" {{ $currentDcCode === 'eu-west' ? 'selected' : '' }}>Europe (West)</option>
                                    <option value="eu-central" {{ $currentDcCode === 'eu-central' ? 'selected' : '' }}>Europe (Central)</option>
                                    <option value="uk" {{ $currentDcCode === 'uk' ? 'selected' : '' }}>United Kingdom</option>
                                    <option value="germany" {{ $currentDcCode === 'germany' ? 'selected' : '' }}>Germany</option>
                                    <option value="france" {{ $currentDcCode === 'france' ? 'selected' : '' }}>France</option>
                                    <option value="canada" {{ $currentDcCode === 'canada' ? 'selected' : '' }}>Canada</option>
                                    <option value="australia" {{ $currentDcCode === 'australia' ? 'selected' : '' }}>Australia</option>
                                    <option value="asia-pacific" {{ $currentDcCode === 'asia-pacific' ? 'selected' : '' }}>Asia Pacific</option>
                                    <option value="singapore" {{ $currentDcCode === 'singapore' ? 'selected' : '' }}>Singapore</option>
                                    <option value="japan" {{ $currentDcCode === 'japan' ? 'selected' : '' }}>Japan</option>
                                    <option value="EGYPT" {{ $currentDcCode === 'EGYPT' ? 'selected' : '' }}>Egypt</option>
                                </select>
                                <p class="mt-1 text-xs text-gray-500">{{ $isArabic ? 'اختر الداتا سنتر الجديد للخدمة' : 'Select the new datacenter for this service' }}</p>
                            </div>
                            <div class="bg-amber-50 border border-amber-200 rounded-lg p-3 mb-4">
                                <p class="text-xs text-amber-700">
                                    <svg class="w-4 h-4 inline-block {{ $isArabic ? 'ml-1' : 'mr-1' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $isArabic ? 'ملاحظة: هذا التغيير سيُحدّث البيانات المحفوظة فقط. إذا كنت تنقل الخدمة فعلياً لداتا سنتر آخر، تأكد من نقل البيانات والملفات أيضاً.' : 'Note: This change will only update the stored data. If you are actually migrating the service to another datacenter, make sure to migrate the data and files as well.' }}
                                </p>
                            </div>
                            <div class="flex gap-3">
                                <button type="button" onclick="document.getElementById('changeDatacenterModal').classList.add('hidden')" 
                                        class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                    {{ __('crm.cancel') }}
                                </button>
                                <button type="submit" 
                                        class="flex-1 px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-600 transition-colors">
                                    {{ $isArabic ? 'تغيير' : 'Change' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Change Server Modal -->
            <div id="changeServerModal" class="fixed inset-0 z-50 hidden" onclick="this.classList.add('hidden')">
                <!-- Backdrop -->
                <div class="fixed inset-0 bg-gray-500/75 transition-opacity"></div>
                
                <!-- Modal Content -->
                <div class="fixed inset-0 flex items-center justify-center">
                    <div class="relative bg-white rounded-lg shadow-xl w-[450px] mx-4 p-5 z-10" onclick="event.stopPropagation()">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                                </svg>
                                {{ $isArabic ? 'تغيير السيرفر' : 'Change Server' }}
                            </h3>
                            <button type="button" onclick="document.getElementById('changeServerModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <form action="{{ route('admin.services.change-server', $service) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ $isArabic ? 'السيرفر الحالي' : 'Current Server' }}
                                </label>
                                <input type="text" value="{{ $service->server->name ?? '-' }}" readonly
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ $isArabic ? 'السيرفر الجديد' : 'New Server' }}
                                </label>
                                @php
                                    $availableServers = \App\Models\Server::where(function($q) {
                                            $q->where('status', true)
                                              ->orWhere('status', 'active')
                                              ->orWhere('status', 1);
                                        })
                                        ->whereIn('type', ['cpanel', 'whm'])
                                        ->where('id', '!=', $service->server_id)
                                        ->get();
                                @endphp
                                <select name="server_id" required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">{{ $isArabic ? 'اختر السيرفر' : 'Select Server' }}</option>
                                    @foreach($availableServers as $server)
                                        <option value="{{ $server->id }}">{{ $server->name }} ({{ $server->hostname }})</option>
                                    @endforeach
                                </select>
                                <p class="mt-1 text-xs text-gray-500">{{ $isArabic ? 'اختر السيرفر الذي تريد نقل الخدمة إليه' : 'Select the server to migrate this service to' }}</p>
                            </div>
                            <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-4">
                                <p class="text-xs text-red-700">
                                    <svg class="w-4 h-4 inline-block {{ $isArabic ? 'ml-1' : 'mr-1' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                    {{ $isArabic ? 'تحذير هام: هذا سيغير السيرفر في قاعدة البيانات فقط. يجب عليك نقل الحساب يدوياً باستخدام WHM Transfer Tool أو إنشاء حساب جديد على السيرفر الجديد.' : 'Important Warning: This will only change the server in the database. You must manually migrate the account using WHM Transfer Tool or create a new account on the new server.' }}
                                </p>
                            </div>
                            <div class="flex gap-3">
                                <button type="button" onclick="document.getElementById('changeServerModal').classList.add('hidden')" 
                                        class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                    {{ __('crm.cancel') }}
                                </button>
                                <button type="submit" 
                                        class="flex-1 px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-600 transition-colors">
                                    {{ $isArabic ? 'تغيير' : 'Change' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
</div>
@endsection
