@extends('frontend.client.layout')

@section('title', __('frontend.cloud_hosting') . ' - ' . config('app.name'))

@push('styles')
<style>
    .service-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .service-card:hover {
        transform: translateY(-4px);
    }
    
    .stat-card {
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="container mx-auto px-4 max-w-7xl">
        
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                    {{ __('frontend.cloud_hosting') ?? 'Cloud Hosting' }}
                </h1>
            </div>
            <p class="text-gray-600 dark:text-gray-400">
                {{ __('frontend.manage_cloud_hosting_services') ?? 'Manage all your cloud hosting services from one place' }}
            </p>
        </div>
        
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Services -->
            <div class="stat-card bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                            {{ __('frontend.total_services') ?? 'Total Services' }}
                        </p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">
                            {{ $stats['total'] }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Active Services -->
            <div class="stat-card bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                            {{ __('frontend.active') ?? 'Active' }}
                        </p>
                        <p class="text-3xl font-bold text-green-600 dark:text-green-400">
                            {{ $stats['active'] }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Pending Services -->
            <div class="stat-card bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                            {{ __('frontend.pending') ?? 'Pending' }}
                        </p>
                        <p class="text-3xl font-bold text-orange-600 dark:text-orange-400">
                            {{ $stats['pending'] }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Suspended Services -->
            <div class="stat-card bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                            {{ __('frontend.suspended') ?? 'Suspended' }}
                        </p>
                        <p class="text-3xl font-bold text-red-600 dark:text-red-400">
                            {{ $stats['suspended'] }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Services List -->
        @if($cloudHostingServices->count() > 0)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                <!-- Header -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ __('frontend.your_cloud_hosting_services') ?? 'Your Cloud Hosting Services' }}
                        </h2>
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $cloudHostingServices->total() }} {{ __('frontend.services_found') ?? 'services found' }}
                        </span>
                    </div>
                </div>
                
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ __('frontend.service') ?? 'Service' }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ __('frontend.domain') ?? 'Domain' }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ __('frontend.status') ?? 'Status' }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ __('frontend.created_date') ?? 'Created Date' }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ __('frontend.next_due_date') ?? 'Renewal Date' }}
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ __('frontend.actions') ?? 'Actions' }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($cloudHostingServices as $service)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $service->service_name }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                #{{ $service->order_id }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center text-sm text-gray-900 dark:text-white">
                                        <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                        </svg>
                                        {{ $service->domain ?? 'N/A' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($service->status === 'active')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 text-xs font-medium rounded-full">
                                            <span class="w-1.5 h-1.5 bg-green-600 dark:bg-green-400 rounded-full"></span>
                                            {{ __('frontend.active') }}
                                        </span>
                                    @elseif($service->status === 'pending')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400 text-xs font-medium rounded-full">
                                            <span class="w-1.5 h-1.5 bg-orange-600 dark:bg-orange-400 rounded-full"></span>
                                            {{ __('frontend.pending') }}
                                        </span>
                                    @elseif($service->status === 'suspended')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 text-xs font-medium rounded-full">
                                            <span class="w-1.5 h-1.5 bg-red-600 dark:bg-red-400 rounded-full"></span>
                                            {{ __('frontend.suspended') }}
                                        </span>
                                    @elseif($service->status === 'failed')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 text-xs font-medium rounded-full">
                                            <span class="w-1.5 h-1.5 bg-red-600 dark:bg-red-400 rounded-full"></span>
                                            {{ __('frontend.failed') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    <div>{{ $service->created_at->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $service->created_at->format('h:i A') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($service->next_due_date)
                                        <div class="text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($service->next_due_date)->format('M d, Y') }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ \Carbon\Carbon::parse($service->next_due_date)->diffForHumans() }}
                                        </div>
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('client.hosting.cloud.show', $service->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                        {{ __('frontend.manage') ?? 'Manage' }}
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($cloudHostingServices->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $cloudHostingServices->links() }}
                </div>
                @endif
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-12 text-center">
                <div class="max-w-md mx-auto">
                    <div class="w-20 h-20 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                        </svg>
                    </div>
                    
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                        {{ __('frontend.no_cloud_hosting_services') ?? 'No Cloud Hosting Services' }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        {{ __('frontend.no_cloud_hosting_services_description') ?? 'You don\'t have any cloud hosting services yet. Start by ordering a new service.' }}
                    </p>
                    
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        {{ __('frontend.order_cloud_hosting') ?? 'Order Cloud Hosting' }}
                    </a>
                </div>
            </div>
        @endif
        
    </div>
</div>
@endsection
