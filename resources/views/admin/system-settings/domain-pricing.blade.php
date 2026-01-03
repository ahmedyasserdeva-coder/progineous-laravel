@extends('admin.layout')

@section('title', __('crm.domain_pricing'))

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-600 to-blue-600 rounded-xl shadow-lg p-8 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-white">{{ __('crm.domain_pricing') }}</h1>
                <p class="text-purple-100 text-sm mt-1">{{ __('crm.domain_pricing_desc') }}</p>
            </div>
            <div class="bg-white/20 backdrop-blur-sm rounded-lg p-4">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Registrars Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- Dynadot Card -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden hover:shadow-xl transition-shadow duration-300">
            <div class="p-6">
                <!-- Logo & Name -->
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <span class="text-2xl font-bold text-white">DD</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Dynadot</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ __('crm.affordable_pricing') }}</p>
                    </div>
                    @php
                        $dynadot = $registrars->firstWhere('type', 'dynadot');
                    @endphp
                    @if($dynadot)
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300">
                            {{ __('crm.active') }}
                        </span>
                    @else
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700 dark:bg-gray-900 dark:text-gray-300">
                            {{ __('crm.inactive') }}
                        </span>
                    @endif
                </div>

                <!-- Description -->
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">
                    {{ __('crm.dynadot_pricing_desc') }}
                </p>

                <!-- Stats -->
                <div class="grid grid-cols-2 gap-3 mb-4">
                    <div class="bg-slate-50 dark:bg-slate-900 rounded-lg p-3">
                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">{{ __('crm.tlds_available') }}</p>
                        <p class="text-lg font-bold text-slate-900 dark:text-white">500+</p>
                    </div>
                    <div class="bg-slate-50 dark:bg-slate-900 rounded-lg p-3">
                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">{{ __('crm.price_level') }}</p>
                        <p class="text-lg font-bold text-purple-600 dark:text-purple-400">Bulk</p>
                    </div>
                </div>

                <!-- Action Button -->
                @if($dynadot)
                    <a href="{{ route('admin.system-settings.domains.pricing.dynadot') }}" class="block w-full text-center px-4 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-semibold rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-200 shadow-md hover:shadow-lg">
                        {{ __('crm.view_pricing') }}
                    </a>
                @else
                    <a href="{{ route('admin.system-settings.domain-registrars.dynadot') }}" class="block w-full text-center px-4 py-3 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 font-semibold rounded-lg hover:bg-slate-300 dark:hover:bg-slate-600 transition-all duration-200">
                        {{ __('crm.configure_first') }}
                    </a>
                @endif
            </div>
        </div>

    </div>

    <!-- Featured TLDs Section -->
    <div class="mt-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white">{{ __('crm.featured_domains') }}</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ __('crm.most_popular_extensions') }}</p>
            </div>
        </div>

        <div id="featured-domains-container" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
            <!-- Loading state -->
            <div class="col-span-full flex justify-center py-8">
                <div class="inline-flex items-center gap-2">
                    <svg class="animate-spin h-5 w-5 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-slate-600 dark:text-slate-400">{{ __('crm.loading') }}...</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Domain Pricing Table -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden mt-6">
        <div class="p-6 border-b border-slate-200 dark:border-slate-700">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white">{{ __('crm.all_domain_prices') }}</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ __('crm.view_all_tld_pricing') }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <!-- Search -->
                    <div class="relative">
                        <input type="text" 
                            id="domain-search" 
                            placeholder="{{ __('crm.search_tlds') }}"
                            class="pl-10 pr-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            oninput="filterDomainPricing(this.value)">
                        <svg class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <!-- Currency Filter -->
                    <select id="currency-filter" 
                        class="px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-purple-500"
                        onchange="loadDomainPricing()">
                        <option value="USD">USD ($)</option>
                        <option value="EUR">EUR (€)</option>
                        <option value="GBP">GBP (£)</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full" {{ app()->getLocale() == 'ar' ? 'dir=rtl' : '' }}>
                <thead class="bg-slate-50 dark:bg-slate-900">
                    <tr>
                        <th class="px-6 py-3 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                            {{ __('crm.tld') }}
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider w-20">
                            {{ __('crm.featured') }}
                        </th>
                        <th class="px-6 py-3 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                            {{ __('crm.register') }}
                        </th>
                        <th class="px-6 py-3 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                            {{ __('crm.renew') }}
                        </th>
                        <th class="px-6 py-3 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                            {{ __('crm.transfer') }}
                        </th>
                        <th class="px-6 py-3 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                            {{ __('crm.restore') }}
                        </th>
                        <th class="px-6 py-3 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                            {{ __('crm.currency') }}
                        </th>
                    </tr>
                </thead>
                <tbody id="domain-pricing-tbody" class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-700">
                    <!-- Loading state -->
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center">
                            <div class="inline-flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span class="text-slate-600 dark:text-slate-400">{{ __('crm.loading') }}...</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination Info & Controls -->
        <div class="px-6 py-4 bg-slate-50 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-700">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <!-- Results Info -->
                <p id="pricing-results-info" class="text-sm text-slate-600 dark:text-slate-400"></p>
                
                <!-- Pagination Controls -->
                <div class="flex items-center gap-4">
                    <!-- Items per page -->
                    <div class="flex items-center gap-2">
                        <label class="text-sm text-slate-600 dark:text-slate-400">{{ __('crm.items_per_page') }}:</label>
                        <select id="items-per-page" 
                            class="px-3 py-1 border border-slate-300 dark:border-slate-600 rounded bg-white dark:bg-slate-700 text-slate-900 dark:text-white text-sm"
                            onchange="changeItemsPerPage()">
                            <option value="25">25</option>
                            <option value="50" selected>50</option>
                            <option value="100">100</option>
                            <option value="200">200</option>
                            <option value="-1">{{ __('crm.all') }}</option>
                        </select>
                    </div>
                    
                    <!-- Page Navigation -->
                    <div id="pagination-controls" class="flex items-center gap-2">
                        <!-- Will be populated by JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let allPricing = [];
let filteredPricing = [];
let currentPage = 1;
let itemsPerPage = 50;

// Load domain pricing on page load
document.addEventListener('DOMContentLoaded', function() {
    loadDomainPricing();
    loadFeaturedDomains();
});

async function loadFeaturedDomains() {
    const currency = document.getElementById('currency-filter').value;
    const container = document.getElementById('featured-domains-container');
    
    try {
        const response = await fetch(`{{ route('admin.system-settings.domains.pricing.list') }}?currency=${currency}`);
        const data = await response.json();
        
        if (data.success) {
            // Get only featured domains
            const featured = data.pricing.filter(item => item.is_featured);
            renderFeaturedDomains(featured, currency);
        }
    } catch (error) {
        console.error('Error loading featured domains:', error);
        container.innerHTML = `
            <div class="col-span-full text-center py-8">
                <p class="text-sm text-red-600 dark:text-red-400">{{ __('crm.error_loading_pricing') }}</p>
            </div>
        `;
    }
}

async function toggleFeatured(id, button) {
    try {
        const response = await fetch('{{ route('admin.system-settings.domains.pricing.toggle-featured') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ id: id })
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Update star icon
            const svg = button.querySelector('svg');
            const isFeatured = data.is_featured;
            
            if (isFeatured) {
                button.className = 'inline-flex items-center justify-center w-8 h-8 rounded-full transition-all duration-200 text-yellow-500 hover:text-yellow-600';
                svg.setAttribute('fill', 'currentColor');
                button.title = '{{ __('crm.remove_from_featured') }}';
            } else {
                button.className = 'inline-flex items-center justify-center w-8 h-8 rounded-full transition-all duration-200 text-slate-300 dark:text-slate-600 hover:text-yellow-500';
                svg.setAttribute('fill', 'none');
                button.title = '{{ __('crm.add_to_featured') }}';
            }
            
            // Reload featured domains section
            loadFeaturedDomains();
            
            // Show success message
            showNotification(data.message, 'success');
        }
    } catch (error) {
        console.error('Error toggling featured:', error);
        showNotification('{{ __('crm.error_occurred') }}', 'error');
    }
}

function showNotification(message, type = 'success') {
    // Simple notification (you can enhance this with a library like Toastr)
    const notification = document.createElement('div');
    notification.className = `fixed top-4 ${window.Lang && Lang.get && '{{ app()->getLocale() }}' === 'ar' ? 'left-4' : 'right-4'} px-6 py-3 rounded-lg shadow-lg z-50 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white`;
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

function renderFeaturedDomains(domains, currency) {
    const container = document.getElementById('featured-domains-container');
    const currSymbol = currency === 'USD' ? '$' : currency === 'EUR' ? '€' : '£';
    const isRTL = '{{ app()->getLocale() }}' === 'ar';
    
    if (domains.length === 0) {
        container.innerHTML = `
            <div class="col-span-full text-center py-8">
                <p class="text-sm text-slate-500 dark:text-slate-400">{{ __('crm.no_featured_domains') }}</p>
            </div>
        `;
        return;
    }
    
    container.innerHTML = '';
    
    domains.forEach(domain => {
        const card = document.createElement('div');
        card.className = 'bg-white dark:bg-slate-800 rounded-xl shadow-md border border-slate-200 dark:border-slate-700 p-4 hover:shadow-lg transition-shadow duration-200 hover:border-purple-500 dark:hover:border-purple-500';
        
        card.innerHTML = `
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-12 h-12 mb-3 rounded-full bg-gradient-to-br from-purple-100 to-blue-100 dark:from-purple-900 dark:to-blue-900">
                    <span class="text-lg font-bold text-purple-700 dark:text-purple-300" dir="ltr">.${domain.tld}</span>
                </div>
                <h3 class="text-sm font-semibold text-slate-900 dark:text-white mb-2" dir="ltr">.${domain.tld}</h3>
                <div class="space-y-1">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-500 dark:text-slate-400">{{ __('crm.register') }}:</span>
                        <span class="font-semibold text-slate-900 dark:text-white">
                            ${isRTL ? parseFloat(domain.progineous_register).toFixed(2) + currSymbol : currSymbol + parseFloat(domain.progineous_register).toFixed(2)}
                        </span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-500 dark:text-slate-400">{{ __('crm.renew') }}:</span>
                        <span class="font-semibold text-slate-900 dark:text-white">
                            ${isRTL ? parseFloat(domain.progineous_renew).toFixed(2) + currSymbol : currSymbol + parseFloat(domain.progineous_renew).toFixed(2)}
                        </span>
                    </div>
                </div>
            </div>
        `;
        
        container.appendChild(card);
    });
}

async function loadDomainPricing() {
    const currency = document.getElementById('currency-filter').value;
    const tbody = document.getElementById('domain-pricing-tbody');
    
    try {
        const response = await fetch(`{{ route('admin.system-settings.domains.pricing.list') }}?currency=${currency}`);
        const data = await response.json();
        
        if (data.success) {
            allPricing = data.pricing;
            filteredPricing = allPricing;
            currentPage = 1;
            renderDomainPricingTable();
            
            // Update featured domains with new currency
            loadFeaturedDomains();
        } else {
            showError(data.message || '{{ __('crm.failed_to_load_pricing') }}');
        }
    } catch (error) {
        console.error('Error loading pricing:', error);
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="px-6 py-8 text-center">
                    <div class="text-red-600 dark:text-red-400">
                        <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="font-semibold">{{ __('crm.error_loading_pricing') }}</p>
                        <p class="text-sm mt-1">{{ __('crm.please_try_again') }}</p>
                    </div>
                </td>
            </tr>
        `;
    }
}

function filterDomainPricing(query) {
    query = query.toLowerCase().trim();
    
    if (query === '') {
        filteredPricing = allPricing;
    } else {
        filteredPricing = allPricing.filter(item => 
            item.tld.toLowerCase().includes(query)
        );
    }
    
    currentPage = 1; // Reset to first page when filtering
    renderDomainPricingTable();
}

function changeItemsPerPage() {
    const select = document.getElementById('items-per-page');
    itemsPerPage = parseInt(select.value);
    currentPage = 1; // Reset to first page
    renderDomainPricingTable();
}

function goToPage(page) {
    currentPage = page;
    renderDomainPricingTable();
}

function renderDomainPricingTable() {
    const tbody = document.getElementById('domain-pricing-tbody');
    const currency = document.getElementById('currency-filter').value;
    const currSymbol = currency === 'USD' ? '$' : currency === 'EUR' ? '€' : '£';
    
    const totalItems = filteredPricing.length;
    const totalPages = itemsPerPage === -1 ? 1 : Math.ceil(totalItems / itemsPerPage);
    
    // Calculate pagination
    const startIndex = itemsPerPage === -1 ? 0 : (currentPage - 1) * itemsPerPage;
    const endIndex = itemsPerPage === -1 ? totalItems : Math.min(startIndex + itemsPerPage, totalItems);
    const paginatedData = filteredPricing.slice(startIndex, endIndex);
    
    if (filteredPricing.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="px-6 py-8 text-center">
                    <div class="text-slate-500 dark:text-slate-400">
                        <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="font-semibold">{{ __('crm.no_pricing_found') }}</p>
                        <p class="text-sm mt-1">{{ __('crm.try_different_search') }}</p>
                    </div>
                </td>
            </tr>
        `;
        document.getElementById('pricing-results-info').textContent = '{{ __('crm.no_results') }}';
        document.getElementById('pagination-controls').innerHTML = '';
        return;
    }
    
    tbody.innerHTML = '';
    
    paginatedData.forEach((item, index) => {
        const row = document.createElement('tr');
        row.className = index % 2 === 0 
            ? 'bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700' 
            : 'bg-slate-50 dark:bg-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800';
        
        const isRTL = '{{ app()->getLocale() }}' === 'ar';
        
        row.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-gradient-to-r from-purple-100 to-blue-100 dark:from-purple-900 dark:to-blue-900 text-purple-700 dark:text-purple-300" dir="ltr">
                    .${item.tld}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-center">
                <button 
                    onclick="toggleFeatured(${item.id}, this)"
                    class="inline-flex items-center justify-center w-8 h-8 rounded-full transition-all duration-200 ${item.is_featured ? 'text-yellow-500 hover:text-yellow-600' : 'text-slate-300 dark:text-slate-600 hover:text-yellow-500'}"
                    title="${item.is_featured ? '{{ __('crm.remove_from_featured') }}' : '{{ __('crm.add_to_featured') }}'}">
                    <svg class="w-5 h-5 ${item.is_featured ? 'fill-current' : ''}" stroke="currentColor" fill="${item.is_featured ? 'currentColor' : 'none'}" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </button>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="text-sm font-semibold text-slate-900 dark:text-white">
                    ${isRTL ? parseFloat(item.progineous_register).toFixed(2) + currSymbol : currSymbol + parseFloat(item.progineous_register).toFixed(2)}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="text-sm font-semibold text-slate-900 dark:text-white">
                    ${isRTL ? parseFloat(item.progineous_renew).toFixed(2) + currSymbol : currSymbol + parseFloat(item.progineous_renew).toFixed(2)}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="text-sm font-semibold text-slate-900 dark:text-white">
                    ${isRTL ? parseFloat(item.progineous_transfer).toFixed(2) + currSymbol : currSymbol + parseFloat(item.progineous_transfer).toFixed(2)}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="text-sm font-semibold text-slate-900 dark:text-white">
                    ${isRTL ? parseFloat(item.progineous_restore).toFixed(2) + currSymbol : currSymbol + parseFloat(item.progineous_restore).toFixed(2)}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300">
                    ${item.currency}
                </span>
            </td>
        `;
        
        tbody.appendChild(row);
    });
    
    // Update results info
    const showingFrom = startIndex + 1;
    const showingTo = endIndex;
    document.getElementById('pricing-results-info').textContent = 
        `{{ __('crm.showing') }} ${showingFrom} - ${showingTo} {{ __('crm.of') }} ${totalItems} {{ __('crm.tlds') }}`;
    
    // Render pagination controls
    renderPaginationControls(totalPages);
}

function renderPaginationControls(totalPages) {
    const controls = document.getElementById('pagination-controls');
    
    if (totalPages <= 1) {
        controls.innerHTML = '';
        return;
    }
    
    const isRTL = '{{ app()->getLocale() }}' === 'ar';
    let html = '';
    
    // Previous button (في العربي: التالي، في الإنجليزي: Previous)
    html += `
        <button 
            onclick="goToPage(${currentPage - 1})" 
            ${currentPage === 1 ? 'disabled' : ''}
            class="px-3 py-1 rounded border border-slate-300 dark:border-slate-600 text-sm ${currentPage === 1 ? 'bg-slate-100 dark:bg-slate-800 text-slate-400 cursor-not-allowed' : 'bg-white dark:bg-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-600'}">
            ${isRTL ? '{{ __('crm.previous') }}' : '{{ __('crm.previous') }}'}
        </button>
    `;
    
    // Page numbers
    const maxButtons = 5;
    let startPage = Math.max(1, currentPage - Math.floor(maxButtons / 2));
    let endPage = Math.min(totalPages, startPage + maxButtons - 1);
    
    if (endPage - startPage < maxButtons - 1) {
        startPage = Math.max(1, endPage - maxButtons + 1);
    }
    
    // First page
    if (startPage > 1) {
        html += `
            <button 
                onclick="goToPage(1)" 
                class="px-3 py-1 rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-600 text-sm">
                1
            </button>
        `;
        if (startPage > 2) {
            html += `<span class="text-slate-400">...</span>`;
        }
    }
    
    // Page numbers
    for (let i = startPage; i <= endPage; i++) {
        html += `
            <button 
                onclick="goToPage(${i})" 
                class="px-3 py-1 rounded border text-sm ${i === currentPage 
                    ? 'bg-purple-600 border-purple-600 text-white font-semibold' 
                    : 'border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-600'}">
                ${i}
            </button>
        `;
    }
    
    // Last page
    if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
            html += `<span class="text-slate-400">...</span>`;
        }
        html += `
            <button 
                onclick="goToPage(${totalPages})" 
                class="px-3 py-1 rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-600 text-sm">
                ${totalPages}
            </button>
        `;
    }
    
    // Next button (في العربي: السابق، في الإنجليزي: Next)
    html += `
        <button 
            onclick="goToPage(${currentPage + 1})" 
            ${currentPage === totalPages ? 'disabled' : ''}
            class="px-3 py-1 rounded border border-slate-300 dark:border-slate-600 text-sm ${currentPage === totalPages ? 'bg-slate-100 dark:bg-slate-800 text-slate-400 cursor-not-allowed' : 'bg-white dark:bg-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-600'}">
            ${isRTL ? '{{ __('crm.next') }}' : '{{ __('crm.next') }}'}
        </button>
    `;
    
    controls.innerHTML = html;
}

function showError(message) {
    const tbody = document.getElementById('domain-pricing-tbody');
    tbody.innerHTML = `
        <tr>
            <td colspan="7" class="px-6 py-8 text-center">
                <div class="text-red-600 dark:text-red-400">
                    <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="font-semibold">${message}</p>
                </div>
            </td>
        </tr>
    `;
}
</script>
@endsection
