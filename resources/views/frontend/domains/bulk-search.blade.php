@extends('frontend.layout')

@section('title', __('frontend.bulk_domain_search'))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-50 dark:from-slate-900 dark:via-slate-900 dark:to-slate-900">
    
    <!-- Hero Section -->
    <section class="relative py-16 md:py-20 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50/50 via-indigo-50/30 to-purple-50/50 dark:from-blue-900/10 dark:via-indigo-900/10 dark:to-purple-900/10"></div>
        
        <!-- Animated Orbs -->
        <div class="absolute top-20 {{ app()->getLocale() == 'ar' ? 'left-10' : 'right-10' }} w-72 h-72 bg-blue-400/20 dark:bg-blue-500/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 {{ app()->getLocale() == 'ar' ? 'right-20' : 'left-20' }} w-96 h-96 bg-purple-400/20 dark:bg-purple-500/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Page Header -->
            <div class="text-center mb-12">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500/10 dark:bg-blue-500/20 border border-blue-500/20 dark:border-blue-400/30 rounded-full mb-6">
                    <div class="w-2 h-2 bg-blue-500 dark:bg-blue-400 rounded-full animate-pulse"></div>
                    <span class="text-sm font-semibold text-blue-600 dark:text-blue-400 uppercase tracking-wider">
                        {{ __('frontend.bulk_search') }}
                    </span>
                </div>
                
                <!-- Title -->
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black text-transparent bg-clip-text bg-gradient-to-r from-slate-900 via-blue-800 to-indigo-900 dark:from-slate-100 dark:via-blue-200 dark:to-indigo-200 mb-6 leading-tight sm:leading-snug px-4">
                    {{ __('frontend.bulk_domain_search_title') }}
                </h1>
                
                <!-- Subtitle -->
                <p class="text-base sm:text-lg md:text-xl text-slate-600 dark:text-slate-300 max-w-3xl mx-auto leading-relaxed px-4">
                    {{ __('frontend.bulk_domain_search_desc') }}
                </p>
            </div>
        </div>
    </section>

    <!-- Main Search Section -->
    <section class="py-12 relative z-10">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
                
                <!-- Search Form Card -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-slate-200/50 dark:border-slate-700/50 p-6 md:p-8 lg:p-10 mb-8">
                    <form id="bulkSearchForm">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                            <!-- Domain Names Input -->
                            <div>
                                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-3">
                                    {{ __('frontend.domain_names') }}
                                    <span class="text-red-500">*</span>
                                </label>
                                <textarea
                                    name="domains"
                                    id="domainNames"
                                    rows="10"
                                    class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-700 rounded-xl focus:border-blue-500 dark:focus:border-blue-400 focus:ring-4 focus:ring-blue-500/20 outline-none transition-all duration-300 text-slate-800 dark:text-slate-100 font-mono text-sm"
                                    placeholder="{{ __('frontend.bulk_domain_placeholder') }}"
                                    required
                                ></textarea>
                                <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                                    {{ __('frontend.bulk_domain_hint') }}
                                </p>
                            </div>

                            <!-- Extensions Selection -->
                            <div>
                                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-3">
                                    {{ __('frontend.select_extensions') }}
                                    <span class="text-red-500">*</span>
                                </label>
                                
                                <!-- Search Extensions Input -->
                                <div class="mb-3">
                                    <div class="relative">
                                        <input
                                            type="text"
                                            id="extensionSearch"
                                            placeholder="{{ __('frontend.search_extensions') }}"
                                            class="w-full px-4 py-2.5 {{ app()->getLocale() == 'ar' ? 'pr-10' : 'pl-10' }} bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 rounded-lg focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all duration-300 text-slate-800 dark:text-slate-100 text-sm"
                                            oninput="filterExtensions(this.value)"
                                        >
                                        <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'right-0 pr-3' : 'left-0 pl-3' }} flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Quick Select Buttons -->
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <button type="button" onclick="selectPopularExtensions()" class="px-3 py-1.5 text-xs font-semibold bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-lg hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors">
                                        {{ __('frontend.popular') }}
                                    </button>
                                    <button type="button" onclick="selectAllExtensions()" class="px-3 py-1.5 text-xs font-semibold bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 rounded-lg hover:bg-indigo-200 dark:hover:bg-indigo-900/50 transition-colors">
                                        {{ __('frontend.select_all') }}
                                    </button>
                                    <button type="button" onclick="clearExtensions()" class="px-3 py-1.5 text-xs font-semibold bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors">
                                        {{ __('frontend.clear') }}
                                    </button>
                                </div>

                                <!-- Extensions Grid -->
                                <div id="extensionsGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-2 max-h-80 overflow-y-auto p-3 sm:p-4 bg-slate-50 dark:bg-slate-900 rounded-xl border-2 border-slate-200 dark:border-slate-700">
                                    @foreach($availableTlds as $tld)
                                    <label class="flex items-center gap-2 p-2.5 sm:p-2 rounded-lg hover:bg-white dark:hover:bg-slate-800 cursor-pointer transition-colors min-w-0">
                                        <input
                                            type="checkbox"
                                            name="extensions[]"
                                            value="{{ $tld['tld'] }}"
                                            class="w-4 h-4 flex-shrink-0 text-blue-600 bg-slate-100 border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600"
                                            data-popular="{{ in_array($tld['tld'], ['com', 'net', 'org', 'io', 'co']) ? 'true' : 'false' }}"
                                        >
                                        <span class="text-sm sm:text-sm font-medium text-slate-700 dark:text-slate-300 truncate">.{{ $tld['tld'] }}</span>
                                        <span class="text-xs text-slate-500 dark:text-slate-400 {{ app()->getLocale() == 'ar' ? 'mr-auto' : 'ml-auto' }} flex-shrink-0">${{ number_format($tld['price'], 2) }}</span>
                                    </label>
                                    @endforeach
                                </div>
                                
                                <p id="extensionCount" class="mt-2 text-xs font-semibold text-blue-600 dark:text-blue-400">
                                    {{ __('frontend.no_extensions_selected') }}
                                </p>
                            </div>
                        </div>

                        <!-- Search Button -->
                        <div class="flex justify-center">
                            <button
                                type="submit"
                                id="searchButton"
                                class="group relative inline-flex items-center justify-center px-12 py-4 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-2xl font-bold text-lg overflow-hidden transition-all duration-300 hover:scale-105 shadow-xl hover:shadow-blue-500/50"
                            >
                                <span id="buttonText">{{ __('frontend.check_availability') }}</span>
                                <svg id="buttonIcon" class="w-6 h-6 {{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <span id="loadingSpinner" class="hidden {{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }}">
                                    <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Results Section -->
                <div id="resultsSection" class="hidden">
                    <!-- Results Header -->
                    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl shadow-xl border border-slate-200/50 dark:border-slate-700/50 p-6 mb-6">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div>
                                <h2 class="text-2xl font-black text-slate-800 dark:text-slate-100">
                                    {{ __('frontend.search_results') }}
                                </h2>
                                <p id="resultsCount" class="text-sm text-slate-600 dark:text-slate-400 mt-1"></p>
                            </div>
                            <div class="flex gap-2">
                                <button onclick="exportResults('available')" class="px-4 py-2 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 rounded-lg font-semibold hover:bg-emerald-200 dark:hover:bg-emerald-900/50 transition-colors text-sm">
                                    {{ __('frontend.export_available') }}
                                </button>
                                <button onclick="exportResults('all')" class="px-4 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-lg font-semibold hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors text-sm">
                                    {{ __('frontend.export_all') }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Results Grid -->
                    <div id="resultsGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4"></div>
                </div>
            </div>
        </div>
    </section>

</div>

@push('scripts')
<script>
// Extension search/filter function
function filterExtensions(searchTerm) {
    const labels = document.querySelectorAll('#extensionsGrid label');
    const searchLower = searchTerm.toLowerCase().trim();
    
    let visibleCount = 0;
    labels.forEach(label => {
        const extensionText = label.textContent.toLowerCase();
        const checkbox = label.querySelector('input[type="checkbox"]');
        const extensionName = checkbox.value.toLowerCase();
        
        // Search in both extension name and text content
        if (extensionName.includes(searchLower) || extensionText.includes(searchLower)) {
            label.style.display = 'flex';
            visibleCount++;
        } else {
            label.style.display = 'none';
        }
    });
    
    // Show message if no results
    const grid = document.getElementById('extensionsGrid');
    let noResultsMsg = grid.querySelector('.no-results-message');
    
    if (visibleCount === 0) {
        if (!noResultsMsg) {
            noResultsMsg = document.createElement('div');
            noResultsMsg.className = 'no-results-message col-span-full text-center py-8 text-slate-500 dark:text-slate-400';
            noResultsMsg.innerHTML = `
                <svg class="w-12 h-12 mx-auto mb-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-sm font-medium">No extensions found</p>
            `;
            grid.appendChild(noResultsMsg);
        }
    } else {
        if (noResultsMsg) {
            noResultsMsg.remove();
        }
    }
}

// Extension selection helpers
function selectPopularExtensions() {
    // Clear search first
    document.getElementById('extensionSearch').value = '';
    filterExtensions('');
    
    document.querySelectorAll('input[name="extensions[]"]').forEach(checkbox => {
        checkbox.checked = checkbox.dataset.popular === 'true';
    });
    updateExtensionCount();
}

function selectAllExtensions() {
    // Only select visible extensions
    document.querySelectorAll('input[name="extensions[]"]').forEach(checkbox => {
        const label = checkbox.closest('label');
        if (label.style.display !== 'none') {
            checkbox.checked = true;
        }
    });
    updateExtensionCount();
}

function clearExtensions() {
    document.querySelectorAll('input[name="extensions[]"]').forEach(checkbox => {
        checkbox.checked = false;
    });
    updateExtensionCount();
}

function updateExtensionCount() {
    const count = document.querySelectorAll('input[name="extensions[]"]:checked').length;
    const countElement = document.getElementById('extensionCount');
    if (count === 0) {
        countElement.textContent = "{{ __('frontend.no_extensions_selected') }}";
        countElement.className = 'mt-2 text-xs font-semibold text-red-600 dark:text-red-400';
    } else {
        countElement.textContent = count + " {{ __('frontend.extensions_selected') }}";
        countElement.className = 'mt-2 text-xs font-semibold text-blue-600 dark:text-blue-400';
    }
}

// Listen for checkbox changes
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('input[name="extensions[]"]').forEach(checkbox => {
        checkbox.addEventListener('change', updateExtensionCount);
    });
});

// Form submission
document.getElementById('bulkSearchForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const domainNames = document.getElementById('domainNames').value.trim();
    const selectedExtensions = Array.from(document.querySelectorAll('input[name="extensions[]"]:checked')).map(cb => cb.value);
    
    // Validation
    if (!domainNames) {
        alert("{{ __('frontend.please_enter_domains') }}");
        return;
    }
    
    if (selectedExtensions.length === 0) {
        alert("{{ __('frontend.please_select_extensions') }}");
        return;
    }
    
    // Update button state
    const button = document.getElementById('searchButton');
    const buttonText = document.getElementById('buttonText');
    const buttonIcon = document.getElementById('buttonIcon');
    const loadingSpinner = document.getElementById('loadingSpinner');
    
    button.disabled = true;
    buttonText.textContent = "{{ __('frontend.checking') }}";
    buttonIcon.classList.add('hidden');
    loadingSpinner.classList.remove('hidden');
    
    try {
        const response = await fetch("{{ route('domains.bulk-check') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                domains: domainNames,
                extensions: selectedExtensions
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            displayResults(data.results, data.total_checked);
        } else {
            alert(data.message || "{{ __('frontend.error_occurred') }}");
        }
    } catch (error) {
        console.error('Error:', error);
        alert("{{ __('frontend.error_occurred') }}");
    } finally {
        // Reset button state
        button.disabled = false;
        buttonText.textContent = "{{ __('frontend.check_availability') }}";
        buttonIcon.classList.remove('hidden');
        loadingSpinner.classList.add('hidden');
    }
});

let allResults = [];

function displayResults(results, total) {
    allResults = results;
    const resultsSection = document.getElementById('resultsSection');
    const resultsGrid = document.getElementById('resultsGrid');
    const resultsCount = document.getElementById('resultsCount');
    
    const availableCount = results.filter(r => r.available).length;
    resultsCount.textContent = `${total} {{ __('frontend.domains_checked') }}, ${availableCount} {{ __('frontend.available') }}`;
    
    resultsGrid.innerHTML = '';
    
    results.forEach(result => {
        const card = document.createElement('div');
        card.className = `group relative bg-white dark:bg-slate-800 rounded-xl p-4 sm:p-5 border-2 transition-all duration-300 ${
            result.available 
                ? 'border-emerald-200 dark:border-emerald-800 hover:border-emerald-400 dark:hover:border-emerald-600 hover:shadow-lg' 
                : 'border-slate-200 dark:border-slate-700 opacity-60'
        }`;
        
        card.innerHTML = `
            <div class="flex items-start justify-between mb-3 gap-2">
                <div class="flex-1 min-w-0">
                    <h3 class="text-base sm:text-lg font-bold text-slate-800 dark:text-slate-100 truncate">${result.display_name}</h3>
                    <p class="text-xs sm:text-sm ${result.available ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400'} font-semibold mt-1">
                        ${result.available ? "{{ __('frontend.available') }}" : "{{ __('frontend.taken') }}"}
                    </p>
                </div>
                <div class="flex-shrink-0 ${result.available ? 'bg-emerald-100 dark:bg-emerald-900/30' : 'bg-slate-100 dark:bg-slate-700'} rounded-full p-2">
                    ${result.available 
                        ? '<svg class="w-4 h-4 sm:w-5 sm:h-5 text-emerald-600 dark:text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>'
                        : '<svg class="w-4 h-4 sm:w-5 sm:h-5 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>'
                    }
                </div>
            </div>
            ${result.available && result.price ? `
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 pt-3 border-t border-slate-200 dark:border-slate-700">
                    <div class="flex flex-col gap-1">
                        <span class="text-xl sm:text-2xl font-black text-blue-600 dark:text-blue-400">$${parseFloat(result.price).toFixed(2)}</span>
                        ${result.renewal_price && result.renewal_price != result.price ? `
                            <span class="text-xs text-amber-600 dark:text-amber-400">
                                {{ __('frontend.renewal_price') }}: $${parseFloat(result.renewal_price).toFixed(2)}
                            </span>
                        ` : ''}
                    </div>
                    <button onclick="addBulkToCart('${result.display_name}', ${result.price}, '${result.tld || 'com'}', ${result.renewal_price || result.price})" class="w-full sm:w-auto text-center px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg font-semibold hover:scale-105 transition-transform text-sm whitespace-nowrap">
                        {{ __('frontend.register') }}
                    </button>
                </div>
            ` : ''}
        `;
        
        resultsGrid.appendChild(card);
    });
    
    resultsSection.classList.remove('hidden');
    resultsSection.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

function exportResults(type) {
    const results = type === 'available' ? allResults.filter(r => r.available) : allResults;
    
    if (results.length === 0) {
        alert("{{ __('frontend.no_results_to_export') }}");
        return;
    }
    
    const csv = [
        ['Domain', 'Status', 'Price', 'Currency'].join(','),
        ...results.map(r => [
            r.display_name,
            r.available ? 'Available' : 'Taken',
            r.price || 'N/A',
            r.currency || 'USD'
        ].join(','))
    ].join('\n');
    
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `bulk-domain-search-${type}-${Date.now()}.csv`;
    a.click();
    window.URL.revokeObjectURL(url);
}

// Add domain to cart from bulk search
function addBulkToCart(domain, price, tld, renewalPrice = null) {
    const button = event.target;
    const originalHTML = button.innerHTML;
    
    // Show loading state
    button.disabled = true;
    button.innerHTML = '<svg class="w-4 h-4 animate-spin inline-block" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> {{ __('frontend.adding') }}...';
    
    fetch('{{ route('cart.add-domain') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            domain: domain,
            price: price,
            type: 'register',
            tld: tld,
            renewal_price: renewalPrice || price
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Change button to "Added" with checkmark
            button.innerHTML = '<svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> {{ __('frontend.added') }}';
            button.classList.remove('from-blue-500', 'to-indigo-600');
            button.classList.add('from-green-500', 'to-emerald-600');
            
            // Update cart count in header
            updateCartCount(data.cartCount);
            
            // Show notification
            showNotification('{{ __('frontend.domain_added_to_cart') }}', 'success');
            
            // Re-enable after 2 seconds
            setTimeout(() => {
                button.disabled = false;
            }, 2000);
        } else {
            button.disabled = false;
            button.innerHTML = originalHTML;
            showNotification(data.message || '{{ __('frontend.error_occurred') }}', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        button.disabled = false;
        button.innerHTML = originalHTML;
        showNotification('{{ __('frontend.error_occurred') }}', 'error');
    });
}

// Update Cart Count in Header
function updateCartCount(count) {
    const cartBadge = document.getElementById('cart-count');
    if (cartBadge) {
        cartBadge.textContent = count;
        if (count > 0) {
            cartBadge.classList.remove('hidden');
            cartBadge.classList.add('flex');
        } else {
            cartBadge.classList.add('hidden');
            cartBadge.classList.remove('flex');
        }
    }
}

// Simple notification function
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `fixed top-24 ${document.documentElement.dir === 'rtl' ? 'left-4' : 'right-4'} z-50 px-6 py-3 rounded-lg shadow-lg ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white font-semibold animate-fade-in`;
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateY(-20px)';
        notification.style.transition = 'all 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}
</script>
@endpush
@endsection
