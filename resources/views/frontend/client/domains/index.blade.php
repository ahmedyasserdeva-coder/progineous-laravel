@extends('frontend.client.layout')

@section('title', app()->getLocale() == 'ar' ? 'نطاقاتي' : 'My Domains')

@section('content')
<div class="space-y-6">
    <!-- Page Header with Gradient Background -->
    <div class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 rounded-2xl p-6 sm:p-8">
        <div class="absolute inset-0 bg-grid-white/10 [mask-image:linear-gradient(0deg,transparent,white)]"></div>
        <div class="absolute -top-24 {{ app()->getLocale() == 'ar' ? '-left-24' : '-right-24' }} w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 {{ app()->getLocale() == 'ar' ? '-right-24' : '-left-24' }} w-64 h-64 bg-blue-400/20 rounded-full blur-3xl"></div>
        
        <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                        </svg>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-white">
                        {{ app()->getLocale() == 'ar' ? 'نطاقاتي' : 'My Domains' }}
                    </h1>
                </div>
                <p class="text-blue-100 text-sm sm:text-base max-w-md">
                    {{ app()->getLocale() == 'ar' ? 'إدارة وتتبع جميع النطاقات المسجلة في حسابك' : 'Manage and track all domains registered in your account' }}
                </p>
            </div>
            <a href="{{ route('domains.search') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-white text-blue-700 text-sm font-semibold rounded-xl hover:bg-blue-50 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ app()->getLocale() == 'ar' ? 'تسجيل نطاق جديد' : 'Register New Domain' }}
            </a>
        </div>
    </div>

    <!-- Stats Widgets -->
    @php
        $totalDomains = $domains->total();
        $activeDomains = \App\Models\Domain::where('client_id', auth('client')->id())->where('status', 'active')->count();
        $expiringDomains = \App\Models\Domain::where('client_id', auth('client')->id())
            ->where('status', 'active')
            ->where('expiry_date', '<=', now()->addDays(30))
            ->where('expiry_date', '>', now())
            ->count();
        $expiredDomains = \App\Models\Domain::where('client_id', auth('client')->id())->where('status', 'expired')->count();
    @endphp
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Domains -->
        <a href="{{ route('client.domains.index') }}" class="group bg-white rounded-2xl border border-gray-100 p-5 hover:border-blue-200 transition-colors">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                    </svg>
                </div>
                <div>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalDomains }}</p>
                    <p class="text-sm text-gray-500">{{ app()->getLocale() == 'ar' ? 'إجمالي النطاقات' : 'Total Domains' }}</p>
                </div>
            </div>
        </a>

        <!-- Active Domains -->
        <a href="{{ route('client.domains.index', ['status' => 'active']) }}" class="group bg-white rounded-2xl border border-gray-100 p-5 hover:border-green-200 transition-colors">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-3xl font-bold text-gray-900">{{ $activeDomains }}</p>
                    <p class="text-sm text-gray-500">{{ app()->getLocale() == 'ar' ? 'نطاقات نشطة' : 'Active' }}</p>
                </div>
            </div>
        </a>

        <!-- Expiring Soon -->
        <a href="{{ route('client.domains.index', ['expiring' => '30']) }}" class="group bg-white rounded-2xl border border-gray-100 p-5 {{ $expiringDomains > 0 ? 'border-amber-200 bg-amber-50/30' : '' }} hover:border-amber-200 transition-colors">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-3xl font-bold {{ $expiringDomains > 0 ? 'text-amber-600' : 'text-gray-900' }}">{{ $expiringDomains }}</p>
                    <p class="text-sm text-gray-500">{{ app()->getLocale() == 'ar' ? 'تنتهي قريباً' : 'Expiring Soon' }}</p>
                </div>
            </div>
        </a>

        <!-- Expired -->
        <a href="{{ route('client.domains.index', ['status' => 'expired']) }}" class="group bg-white rounded-2xl border border-gray-100 p-5 {{ $expiredDomains > 0 ? 'border-red-200 bg-red-50/30' : '' }} transition-colors">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-red-500 to-rose-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-3xl font-bold {{ $expiredDomains > 0 ? 'text-red-600' : 'text-gray-900' }}">{{ $expiredDomains }}</p>
                    <p class="text-sm text-gray-500">{{ app()->getLocale() == 'ar' ? 'منتهية' : 'Expired' }}</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Search & Filters -->
    <div class="bg-white rounded-xl border border-gray-200 p-3 sm:p-4">
        <form action="{{ route('client.domains.index') }}" method="GET">
            <div class="flex flex-col sm:flex-row gap-3">
                <!-- Search Input -->
                <div class="flex-1">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="{{ app()->getLocale() == 'ar' ? 'ابحث عن نطاق...' : 'Search domains...' }}"
                               class="w-full {{ app()->getLocale() == 'ar' ? 'pr-10 pl-3' : 'pl-10 pr-3' }} py-2.5 text-sm border border-gray-200 bg-gray-50 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-colors text-gray-900 placeholder-gray-400">
                        <div class="absolute {{ app()->getLocale() == 'ar' ? 'right-3' : 'left-3' }} top-1/2 -translate-y-1/2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Status Filter - Custom Dropdown -->
                <div class="sm:w-44 relative" x-data="{ open: false, selected: '{{ request('status') }}' }">
                    <button type="button" 
                            @click="open = !open" 
                            @click.away="open = false"
                            class="w-full flex items-center justify-between gap-2 px-3 py-2.5 text-sm border border-gray-200 bg-gray-50 rounded-lg hover:bg-white hover:border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all text-gray-700 cursor-pointer">
                        <span class="flex items-center gap-2">
                            @if(request('status'))
                                @php
                                    $statusColors = [
                                        'active' => 'bg-emerald-500',
                                        'pending' => 'bg-amber-500',
                                        'pending_registration' => 'bg-blue-500',
                                        'pending_transfer' => 'bg-indigo-500',
                                        'expired' => 'bg-red-500',
                                        'grace_period' => 'bg-orange-500',
                                        'redemption_period' => 'bg-red-500',
                                        'cancelled' => 'bg-gray-400',
                                        'transferred_away' => 'bg-slate-500',
                                    ];
                                @endphp
                                <span class="w-2 h-2 rounded-full {{ $statusColors[request('status')] ?? 'bg-gray-400' }}"></span>
                            @endif
                            <span>{{ request('status') ? ($statuses[request('status')] ?? ucfirst(request('status'))) : (app()->getLocale() == 'ar' ? 'جميع الحالات' : 'All Statuses') }}</span>
                        </span>
                        <svg class="w-4 h-4 text-gray-400 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute z-50 mt-2 w-full bg-white rounded-xl border border-gray-200 shadow-lg overflow-hidden {{ app()->getLocale() == 'ar' ? 'right-0' : 'left-0' }}"
                         style="display: none;">
                        <div class="py-1">
                            <!-- All Statuses Option -->
                            <a href="{{ route('client.domains.index', array_merge(request()->except('status', 'page'), [])) }}" 
                               class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-gray-50 transition-colors {{ !request('status') ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }}">
                                <span class="w-2 h-2 rounded-full bg-gray-300"></span>
                                <span>{{ app()->getLocale() == 'ar' ? 'جميع الحالات' : 'All Statuses' }}</span>
                                @if(!request('status'))
                                    <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'mr-auto' : 'ml-auto' }} text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                @endif
                            </a>
                            
                            @php
                                $statusColors = [
                                    'active' => 'bg-emerald-500',
                                    'pending' => 'bg-amber-500',
                                    'pending_registration' => 'bg-blue-500',
                                    'pending_transfer' => 'bg-indigo-500',
                                    'expired' => 'bg-red-500',
                                    'grace_period' => 'bg-orange-500',
                                    'redemption_period' => 'bg-red-500',
                                    'cancelled' => 'bg-gray-400',
                                    'transferred_away' => 'bg-slate-500',
                                ];
                            @endphp
                            
                            @foreach($statuses as $key => $label)
                                <a href="{{ route('client.domains.index', array_merge(request()->except('page'), ['status' => $key])) }}" 
                                   class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-gray-50 transition-colors {{ request('status') == $key ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }}">
                                    <span class="w-2 h-2 rounded-full {{ $statusColors[$key] ?? 'bg-gray-400' }}"></span>
                                    <span>{{ $label }}</span>
                                    @if(request('status') == $key)
                                        <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'mr-auto' : 'ml-auto' }} text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Hidden select for form submission -->
                    <select name="status" class="hidden">
                        <option value="">{{ app()->getLocale() == 'ar' ? 'جميع الحالات' : 'All Statuses' }}</option>
                        @foreach($statuses as $key => $label)
                            <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Actions -->
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 sm:flex-none px-4 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        {{ app()->getLocale() == 'ar' ? 'بحث' : 'Search' }}
                    </button>
                    @if(request('search') || request('status'))
                        <a href="{{ route('client.domains.index') }}" class="px-3 py-2.5 bg-gray-100 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors flex items-center justify-center" title="{{ app()->getLocale() == 'ar' ? 'مسح' : 'Clear' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Domains List -->
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <!-- Widget Header -->
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                    </div>
                    <h2 class="text-base font-semibold text-gray-900">
                        {{ app()->getLocale() == 'ar' ? 'قائمة النطاقات' : 'Domain List' }}
                    </h2>
                </div>
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 bg-blue-50 text-blue-700 text-sm font-medium rounded-full">
                        {{ $domains->total() }} {{ app()->getLocale() == 'ar' ? 'نطاق' : ($domains->total() == 1 ? 'domain' : 'domains') }}
                    </span>
                </div>
            </div>
        </div>

        @if($domains->count() > 0)
            <!-- Desktop Table -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50/50">
                            <th class="px-6 py-4 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                {{ app()->getLocale() == 'ar' ? 'النطاق' : 'Domain' }}
                            </th>
                            <th class="px-6 py-4 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                {{ app()->getLocale() == 'ar' ? 'الحالة' : 'Status' }}
                            </th>
                            <th class="px-6 py-4 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                {{ app()->getLocale() == 'ar' ? 'تاريخ الانتهاء' : 'Expiry Date' }}
                            </th>
                            <th class="px-6 py-4 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                {{ app()->getLocale() == 'ar' ? 'التجديد التلقائي' : 'Auto Renew' }}
                            </th>
                            <th class="px-6 py-4 {{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }} text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                {{ app()->getLocale() == 'ar' ? 'الإجراءات' : 'Actions' }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($domains as $domain)
                            @php
                                $daysLeft = $domain->expiry_date ? now()->diffInDays($domain->expiry_date, false) : null;
                                $isExpiringSoon = $daysLeft !== null && $daysLeft >= 0 && $daysLeft <= 30;
                                $isExpired = $daysLeft !== null && $daysLeft < 0;
                            @endphp
                            <tr class="group hover:bg-blue-50/30 transition-colors {{ $isExpired ? 'bg-red-50/30' : ($isExpiringSoon ? 'bg-amber-50/30' : '') }}">
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-50 rounded-xl flex items-center justify-center">
                                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900">{{ $domain->domain_name }}</p>
                                            @if($domain->registration_date)
                                                <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    {{ app()->getLocale() == 'ar' ? 'مسجل' : 'Registered' }} {{ $domain->registration_date->format('M d, Y') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    @php
                                        $statusConfig = [
                                            'active' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'dot' => 'bg-emerald-500'],
                                            'pending' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200', 'dot' => 'bg-amber-500'],
                                            'expired' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-200', 'dot' => 'bg-red-500'],
                                            'grace_period' => ['bg' => 'bg-orange-50', 'text' => 'text-orange-700', 'border' => 'border-orange-200', 'dot' => 'bg-orange-500'],
                                            'redemption_period' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-200', 'dot' => 'bg-red-500'],
                                            'cancelled' => ['bg' => 'bg-gray-50', 'text' => 'text-gray-600', 'border' => 'border-gray-200', 'dot' => 'bg-gray-400'],
                                            'transferred_away' => ['bg' => 'bg-slate-50', 'text' => 'text-slate-700', 'border' => 'border-slate-200', 'dot' => 'bg-slate-500'],
                                        ];
                                        $config = $statusConfig[$domain->status] ?? $statusConfig['cancelled'];
                                    @endphp
                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold border {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }}">
                                        <span class="w-2 h-2 rounded-full {{ $config['dot'] }}"></span>
                                        {{ $statuses[$domain->status] ?? ucfirst($domain->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    @if($domain->expiry_date)
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ $isExpired ? 'bg-red-100' : ($isExpiringSoon ? 'bg-amber-100' : 'bg-gray-100') }}">
                                                <svg class="w-5 h-5 {{ $isExpired ? 'text-red-600' : ($isExpiringSoon ? 'text-amber-600' : 'text-gray-500') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold {{ $isExpired ? 'text-red-600' : ($isExpiringSoon ? 'text-amber-600' : 'text-gray-900') }}">
                                                    {{ $domain->expiry_date->format('d M Y') }}
                                                </p>
                                                @if($isExpired)
                                                    <p class="text-xs text-red-500 font-medium mt-0.5">{{ app()->getLocale() == 'ar' ? 'منتهي الصلاحية!' : 'Expired!' }}</p>
                                                @elseif($daysLeft == 0)
                                                    <p class="text-xs text-red-500 font-medium mt-0.5">{{ app()->getLocale() == 'ar' ? 'ينتهي اليوم!' : 'Expires today!' }}</p>
                                                @elseif($isExpiringSoon)
                                                    <p class="text-xs text-amber-600 mt-0.5">{{ $daysLeft }} {{ app()->getLocale() == 'ar' ? 'يوم متبقي' : 'days left' }}</p>
                                                @elseif($daysLeft <= 90)
                                                    <p class="text-xs text-gray-500 mt-0.5">{{ $daysLeft }} {{ app()->getLocale() == 'ar' ? 'يوم متبقي' : 'days left' }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-gray-300">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3" 
                                         x-data="{ 
                                             autoRenew: {{ $domain->auto_renew ? 'true' : 'false' }},
                                             loading: false,
                                             async toggleAutoRenew() {
                                                 if (this.loading || '{{ $domain->status }}' !== 'active') return;
                                                 this.loading = true;
                                                 try {
                                                     const response = await fetch('{{ route('client.domains.toggle-auto-renew', $domain) }}', {
                                                         method: 'POST',
                                                         headers: {
                                                             'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                             'Accept': 'application/json',
                                                             'Content-Type': 'application/json'
                                                         }
                                                     });
                                                     const data = await response.json();
                                                     if (data.success) {
                                                         this.autoRenew = data.value;
                                                         // Show toast notification
                                                         if (typeof Swal !== 'undefined') {
                                                             Swal.fire({
                                                                 toast: true,
                                                                 position: 'top-end',
                                                                 icon: 'success',
                                                                 title: data.message,
                                                                 showConfirmButton: false,
                                                                 timer: 3000
                                                             });
                                                         }
                                                     } else {
                                                         if (typeof Swal !== 'undefined') {
                                                             Swal.fire({
                                                                 toast: true,
                                                                 position: 'top-end',
                                                                 icon: 'error',
                                                                 title: data.message || '{{ app()->getLocale() == 'ar' ? 'حدث خطأ' : 'An error occurred' }}',
                                                                 showConfirmButton: false,
                                                                 timer: 3000
                                                             });
                                                         }
                                                     }
                                                 } catch (error) {
                                                     console.error('Error:', error);
                                                 }
                                                 this.loading = false;
                                             }
                                         }">
                                        <button type="button" 
                                                @click="toggleAutoRenew()"
                                                :disabled="loading || '{{ $domain->status }}' !== 'active'"
                                                :class="{ 'opacity-50 cursor-not-allowed': loading || '{{ $domain->status }}' !== 'active', 'cursor-pointer hover:opacity-80': !loading && '{{ $domain->status }}' === 'active' }"
                                                class="relative w-10 h-5 rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                                :style="autoRenew ? 'background-color: rgb(34, 197, 94)' : 'background-color: rgb(229, 231, 235)'">
                                            <span class="absolute top-0.5 w-4 h-4 bg-white rounded-full shadow-sm transition-all"
                                                  :class="autoRenew ? '{{ app()->getLocale() == 'ar' ? 'left-0.5' : 'left-5' }}' : '{{ app()->getLocale() == 'ar' ? 'left-5' : 'left-0.5' }}'"></span>
                                            <span x-show="loading" class="absolute inset-0 flex items-center justify-center">
                                                <svg class="animate-spin h-3 w-3 text-gray-600" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                            </span>
                                        </button>
                                        <span class="text-sm transition-colors"
                                              :class="autoRenew ? 'text-green-600 font-medium' : 'text-gray-400'">
                                            <span x-text="autoRenew ? '{{ app()->getLocale() == 'ar' ? 'مفعّل' : 'On' }}' : '{{ app()->getLocale() == 'ar' ? 'معطّل' : 'Off' }}'"></span>
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 {{ app()->getLocale() == 'ar' ? 'text-left' : 'text-right' }}">
                                    <a href="{{ route('client.domains.show', $domain) }}" 
                                       class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-colors">
                                        {{ app()->getLocale() == 'ar' ? 'إدارة' : 'Manage' }}
                                        <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile/Tablet Cards -->
            <div class="lg:hidden">
                @foreach($domains as $domain)
                    @php
                        $daysLeft = $domain->expiry_date ? now()->diffInDays($domain->expiry_date, false) : null;
                        $isExpiringSoon = $daysLeft !== null && $daysLeft >= 0 && $daysLeft <= 30;
                        $isExpired = $daysLeft !== null && $daysLeft < 0;
                    @endphp
                    <a href="{{ route('client.domains.show', $domain) }}" 
                       class="block p-5 border-b border-gray-100 last:border-b-0 hover:bg-blue-50/50 transition-colors {{ $isExpired ? 'bg-red-50/30' : ($isExpiringSoon ? 'bg-amber-50/30' : '') }}">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-blue-100 to-blue-50 rounded-xl flex items-center justify-center">
                                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="font-bold text-gray-900 truncate text-lg">{{ $domain->domain_name }}</p>
                                        @php
                                            $statusConfig = [
                                                'active' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700'],
                                                'pending' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700'],
                                                'expired' => ['bg' => 'bg-red-100', 'text' => 'text-red-700'],
                                            ];
                                            $config = $statusConfig[$domain->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-600'];
                                        @endphp
                                        <span class="inline-flex items-center mt-2 px-2.5 py-1 rounded-md text-xs font-semibold {{ $config['bg'] }} {{ $config['text'] }}">
                                            {{ $statuses[$domain->status] ?? ucfirst($domain->status) }}
                                        </span>
                                    </div>
                                    <svg class="w-5 h-5 text-gray-400 flex-shrink-0 {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </div>
                                <div class="mt-4 flex flex-wrap items-center gap-4 text-sm">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 {{ $isExpired ? 'text-red-500' : ($isExpiringSoon ? 'text-amber-500' : 'text-gray-400') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="{{ $isExpired ? 'text-red-600 font-medium' : ($isExpiringSoon ? 'text-amber-600 font-medium' : 'text-gray-600') }}">
                                            {{ $domain->expiry_date ? $domain->expiry_date->format('d M Y') : '—' }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full {{ $domain->auto_renew ? 'bg-green-500' : 'bg-gray-300' }}"></span>
                                        <span class="text-gray-500">
                                            {{ $domain->auto_renew ? (app()->getLocale() == 'ar' ? 'تجديد تلقائي' : 'Auto-renew') : (app()->getLocale() == 'ar' ? 'يدوي' : 'Manual') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Custom Pagination -->
            @if($domains->hasPages())
                <div class="px-6 py-5 border-t border-gray-100 bg-gray-50/50">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <p class="text-sm text-gray-500">
                            {{ app()->getLocale() == 'ar' ? 'عرض' : 'Showing' }}
                            <span class="font-semibold text-gray-700">{{ $domains->firstItem() ?? 0 }}</span>
                            {{ app()->getLocale() == 'ar' ? 'إلى' : 'to' }}
                            <span class="font-semibold text-gray-700">{{ $domains->lastItem() ?? 0 }}</span>
                            {{ app()->getLocale() == 'ar' ? 'من' : 'of' }}
                            <span class="font-semibold text-gray-700">{{ $domains->total() }}</span>
                            {{ app()->getLocale() == 'ar' ? 'نطاق' : 'domains' }}
                        </p>
                        <div class="flex items-center gap-2">
                            @if($domains->onFirstPage())
                                <span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed text-sm">
                                    {{ app()->getLocale() == 'ar' ? 'السابق' : 'Previous' }}
                                </span>
                            @else
                                <a href="{{ $domains->previousPageUrl() }}" class="px-4 py-2 text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium">
                                    {{ app()->getLocale() == 'ar' ? 'السابق' : 'Previous' }}
                                </a>
                            @endif
                            
                            <div class="hidden sm:flex items-center gap-1">
                                @foreach($domains->getUrlRange(max(1, $domains->currentPage() - 2), min($domains->lastPage(), $domains->currentPage() + 2)) as $page => $url)
                                    @if($page == $domains->currentPage())
                                        <span class="w-10 h-10 flex items-center justify-center bg-blue-600 text-white rounded-lg font-semibold text-sm">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}" class="w-10 h-10 flex items-center justify-center text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors text-sm">{{ $page }}</a>
                                    @endif
                                @endforeach
                            </div>
                            
                            @if($domains->hasMorePages())
                                <a href="{{ $domains->nextPageUrl() }}" class="px-4 py-2 text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium">
                                    {{ app()->getLocale() == 'ar' ? 'التالي' : 'Next' }}
                                </a>
                            @else
                                <span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed text-sm">
                                    {{ app()->getLocale() == 'ar' ? 'التالي' : 'Next' }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="py-20 px-6 text-center">
                <div class="relative w-24 h-24 mx-auto mb-6">
                    <div class="absolute inset-0 bg-blue-100 rounded-3xl rotate-6"></div>
                    <div class="absolute inset-0 bg-blue-50 rounded-3xl -rotate-3"></div>
                    <div class="relative w-full h-full bg-white rounded-3xl border-2 border-dashed border-blue-200 flex items-center justify-center">
                        <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">
                    {{ request('search') || request('status') 
                        ? (app()->getLocale() == 'ar' ? 'لا توجد نتائج' : 'No Results Found')
                        : (app()->getLocale() == 'ar' ? 'لا توجد نطاقات بعد' : 'No Domains Yet') }}
                </h3>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">
                    {{ request('search') || request('status') 
                        ? (app()->getLocale() == 'ar' ? 'جرب تغيير معايير البحث أو الفلاتر للعثور على ما تبحث عنه' : 'Try adjusting your search or filters to find what you\'re looking for') 
                        : (app()->getLocale() == 'ar' ? 'ابدأ رحلتك الرقمية بتسجيل أول نطاق خاص بك' : 'Start your digital journey by registering your first domain') }}
                </p>
                @if(request('search') || request('status'))
                    <a href="{{ route('client.domains.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        {{ app()->getLocale() == 'ar' ? 'مسح الفلاتر' : 'Clear Filters' }}
                    </a>
                @else
                    <a href="{{ route('domains.search') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        {{ app()->getLocale() == 'ar' ? 'سجّل نطاقك الأول' : 'Register Your First Domain' }}
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

<style>
    .bg-grid-white\/10 {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='40' viewBox='0 0 40 40'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M0 0h1v1H0zM20 0h1v1h-1zM0 20h1v1H0zM20 20h1v1h-1z'/%3E%3C/g%3E%3C/svg%3E");
    }
</style>
@endsection
