@extends('frontend.client.layout')

@section('title', __('frontend.reseller_hosting'))

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-teal-600 to-cyan-600 rounded-2xl p-6 md:p-8 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="absolute -top-24 {{ app()->getLocale() == 'ar' ? '-left-24' : '-right-24' }} w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 {{ app()->getLocale() == 'ar' ? '-right-24' : '-left-24' }} w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        
        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="p-2 bg-white/20 backdrop-blur-sm rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-bold">{{ __('frontend.reseller_hosting') }}</h1>
                </div>
                <p class="text-white/80 text-sm md:text-base">{{ __('frontend.manage_reseller_services') ?? 'Manage your reseller hosting packages and WHM accounts' }}</p>
            </div>
            <a href="{{ route('hosting.reseller') }}" class="inline-flex items-center gap-2 bg-white text-teal-600 px-5 py-2.5 rounded-xl font-semibold hover:bg-teal-50 transition-all shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                {{ __('frontend.order_new') ?? 'Order New' }}
            </a>
        </div>
    </div>
    
    <!-- Statistics Widgets -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <!-- Total Services -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3">
                <div class="p-2.5 bg-teal-100 dark:bg-teal-900/30 rounded-xl">
                    <svg class="w-5 h-5 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total'] }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('frontend.total_services') ?? 'Total Services' }}</p>
                </div>
            </div>
        </div>
        
        <!-- Active Services -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3">
                <div class="p-2.5 bg-green-100 dark:bg-green-900/30 rounded-xl">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['active'] }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('frontend.active') }}</p>
                </div>
            </div>
        </div>
        
        <!-- Pending Services -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3">
                <div class="p-2.5 bg-amber-100 dark:bg-amber-900/30 rounded-xl">
                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['pending'] }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('frontend.pending') }}</p>
                </div>
            </div>
        </div>
        
        <!-- Suspended Services -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3">
                <div class="p-2.5 bg-red-100 dark:bg-red-900/30 rounded-xl">
                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['suspended'] }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('frontend.suspended') }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Services List -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                    {{ __('frontend.your_reseller_packages') ?? 'Your Reseller Packages' }}
                </h2>
            </div>
        </div>
        
        @if($resellerServices->count() > 0)
            <!-- Desktop View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="px-6 py-3 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('frontend.package') ?? 'Package' }}</th>
                            <th class="px-6 py-3 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('frontend.domain') }}</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('frontend.status') }}</th>
                            <th class="px-6 py-3 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('frontend.price') }}</th>
                            <th class="px-6 py-3 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('frontend.next_due_date') ?? 'Next Due Date' }}</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('frontend.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($resellerServices as $service)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-lg">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900 dark:text-white">{{ $service->service_name }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $service->orderItem->configuration['plan'] ?? 'Reseller' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-gray-900 dark:text-white font-medium">{{ $service->domain ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @switch($service->status)
                                        @case('active')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                                                {{ __('frontend.active') }}
                                            </span>
                                            @break
                                        @case('pending')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400">
                                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                                                {{ __('frontend.pending') }}
                                            </span>
                                            @break
                                        @case('suspended')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                                {{ __('frontend.suspended') }}
                                            </span>
                                            @break
                                        @default
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                                                {{ ucfirst($service->status) }}
                                            </span>
                                    @endswitch
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-gray-900 dark:text-white font-semibold">${{ number_format($service->recurring_amount, 2) }}</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">/{{ __('frontend.' . ($service->billing_cycle ?? 'monthly')) }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($service->next_due_date)
                                        <span class="text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($service->next_due_date)->format('M d, Y') }}</span>
                                        @if(\Carbon\Carbon::parse($service->next_due_date)->isPast())
                                            <span class="block text-xs text-red-600 dark:text-red-400">{{ __('frontend.overdue') ?? 'Overdue' }}</span>
                                        @elseif(\Carbon\Carbon::parse($service->next_due_date)->diffInDays(now()) <= 7)
                                            <span class="block text-xs text-amber-600 dark:text-amber-400">{{ __('frontend.due_soon') ?? 'Due Soon' }}</span>
                                        @endif
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('client.hosting.reseller.show', $service->id) }}" class="p-2 text-teal-600 hover:bg-teal-50 dark:hover:bg-teal-900/20 rounded-lg transition-colors" title="{{ __('frontend.manage') }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Mobile View -->
            <div class="md:hidden divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($resellerServices as $service)
                    <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-lg">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $service->service_name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $service->domain ?? '-' }}</p>
                                </div>
                            </div>
                            @switch($service->status)
                                @case('active')
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                                        {{ __('frontend.active') }}
                                    </span>
                                    @break
                                @case('pending')
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400">
                                        <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                                        {{ __('frontend.pending') }}
                                    </span>
                                    @break
                                @case('suspended')
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                        {{ __('frontend.suspended') }}
                                    </span>
                                    @break
                            @endswitch
                        </div>
                        
                        <div class="grid grid-cols-2 gap-3 text-sm mb-3">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-xs">{{ __('frontend.price') }}</p>
                                <p class="font-semibold text-gray-900 dark:text-white">${{ number_format($service->recurring_amount, 2) }}<span class="text-xs font-normal text-gray-500">/{{ __('frontend.' . ($service->billing_cycle ?? 'monthly')) }}</span></p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-xs">{{ __('frontend.next_due_date') ?? 'Next Due' }}</p>
                                <p class="font-medium text-gray-900 dark:text-white">
                                    @if($service->next_due_date)
                                        {{ \Carbon\Carbon::parse($service->next_due_date)->format('M d, Y') }}
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <a href="{{ route('client.hosting.reseller.show', $service->id) }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ __('frontend.manage') }}
                        </a>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($resellerServices->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $resellerServices->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="p-12 text-center">
                <div class="mx-auto w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('frontend.no_reseller_services') ?? 'No Reseller Packages' }}</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6 max-w-md mx-auto">{{ __('frontend.no_reseller_services_desc') ?? 'You don\'t have any reseller hosting packages yet. Start your hosting business today!' }}</p>
                <a href="{{ route('hosting.reseller') }}" class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white px-6 py-3 rounded-xl font-semibold transition-all shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    {{ __('frontend.get_started') ?? 'Get Started' }}
                </a>
            </div>
        @endif
    </div>
    
    <!-- Info Widget -->
    <div class="bg-gradient-to-r from-teal-50 to-cyan-50 dark:from-teal-900/20 dark:to-cyan-900/20 rounded-2xl p-6 border border-teal-100 dark:border-teal-800">
        <div class="flex items-start gap-4">
            <div class="p-3 bg-teal-100 dark:bg-teal-800/50 rounded-xl flex-shrink-0">
                <svg class="w-6 h-6 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-teal-900 dark:text-teal-100 mb-2">{{ __('frontend.reseller_info_title') ?? 'What is Reseller Hosting?' }}</h3>
                <p class="text-teal-700 dark:text-teal-300 text-sm mb-3">{{ __('frontend.reseller_info_desc') ?? 'Reseller hosting allows you to start your own web hosting business. You get access to WHM (Web Host Manager) to create and manage cPanel accounts for your clients.' }}</p>
                <div class="flex flex-wrap gap-3">
                    <div class="flex items-center gap-2 text-sm text-teal-600 dark:text-teal-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ __('frontend.whm_access') ?? 'Full WHM Access' }}
                    </div>
                    <div class="flex items-center gap-2 text-sm text-teal-600 dark:text-teal-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ __('frontend.white_label') ?? 'White Label Branding' }}
                    </div>
                    <div class="flex items-center gap-2 text-sm text-teal-600 dark:text-teal-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ __('frontend.create_packages') ?? 'Create Custom Packages' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
