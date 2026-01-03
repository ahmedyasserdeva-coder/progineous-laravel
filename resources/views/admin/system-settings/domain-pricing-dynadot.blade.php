@extends('admin.layout')

@section('title', __('crm.dynadot_pricing'))

@section('content')
<!-- Toast Notification Container -->
<div id="toast-container" class="fixed top-4 {{ app()->getLocale() == 'ar' ? 'left-4' : 'right-4' }} z-50 space-y-2">
</div>

<div class="p-2 sm:p-4 lg:p-6 max-w-full overflow-hidden">
    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-600 to-blue-600 rounded-xl shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between" @if(app()->getLocale() == 'ar') dir="rtl" @endif>
            <div>
                <h1 class="text-2xl font-bold text-white">{{ __('crm.dynadot_pricing') }}</h1>
                <p class="text-purple-100 text-sm mt-1">{{ __('crm.dynadot_pricing_subtitle') }}</p>
            </div>
            <a href="{{ route('admin.system-settings.domains') }}" class="flex items-center gap-2 px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg transition-colors">
                @if(app()->getLocale() == 'ar')
                    <span class="hidden sm:inline">{{ __('crm.back') }}</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                @else
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span class="hidden sm:inline">{{ __('crm.back') }}</span>
                @endif
            </a>
        </div>
    </div>

    <!-- Controls -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 p-4 sm:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4" @if(app()->getLocale() == 'ar') dir="rtl" @endif>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4">
                <button onclick="fetchDynadotPricing()" id="fetch-btn" class="flex items-center justify-center gap-2 px-4 sm:px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-semibold rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-200 shadow-md hover:shadow-lg text-sm sm:text-base">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <span>{{ __('crm.fetch_pricing') }}</span>
                </button>
                
                <select id="currency-select" class="px-3 sm:px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white text-sm sm:text-base">
                    <option value="USD">USD ($)</option>
                    <option value="EUR">EUR (€)</option>
                    <option value="GBP">GBP (£)</option>
                    <option value="CAD">CAD ($)</option>
                    <option value="AUD">AUD ($)</option>
                </select>
            </div>

            <button onclick="savePricing()" id="save-btn" disabled class="flex items-center justify-center gap-2 px-4 sm:px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-all duration-200 shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed text-sm sm:text-base">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>{{ __('crm.save_pricing') }}</span>
            </button>
        </div>
    </div>

    <!-- Loading State -->
    <div id="loading-state" class="hidden bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 p-12">
        <div class="flex flex-col items-center justify-center">
            <svg class="animate-spin h-12 w-12 text-purple-600 mb-4" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="text-lg font-semibold text-slate-700 dark:text-slate-300">{{ __('crm.fetching_pricing') }}...</p>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">{{ __('crm.please_wait') }}</p>
        </div>
    </div>

    <!-- Pricing Settings -->
    <div id="pricing-settings" class="hidden bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 p-3 sm:p-5 mb-6" @if(app()->getLocale() == 'ar') dir="rtl" @endif>
        <h3 class="text-sm sm:text-base font-semibold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
            </svg>
            {{ __('crm.pricing_settings') }}
        </h3>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            <!-- Margin Type -->
            <div class="bg-slate-50 dark:bg-slate-900/50 p-3 rounded-lg border border-slate-200 dark:border-slate-700">
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                    {{ __('crm.margin_type') }}
                </label>
                <p class="text-xs text-slate-500 dark:text-slate-400 mb-2 line-clamp-2">{{ __('crm.margin_type_desc') }}</p>
                <select id="margin-type" class="w-full px-2.5 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent text-xs transition-all">
                    <option value="percentage">{{ __('crm.percentage') }}</option>
                    <option value="profit">{{ __('crm.profit_margin') }}</option>
                </select>
            </div>

            <!-- Markup Amount -->
            <div class="bg-slate-50 dark:bg-slate-900/50 p-3 rounded-lg border border-slate-200 dark:border-slate-700">
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                    {{ __('crm.markup_amount') }}
                </label>
                <p class="text-xs text-slate-500 dark:text-slate-400 mb-2 line-clamp-2">{{ __('crm.markup_amount_desc') }}</p>
                <div class="relative">
                    <input type="number" id="markup-value" value="20" min="0" step="0.01" class="w-full {{ app()->getLocale() == 'ar' ? 'pl-12 pr-2.5' : 'pr-12 pl-2.5' }} py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent text-xs transition-all {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
                    <div id="markup-symbol" class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} flex items-center {{ app()->getLocale() == 'ar' ? 'pl-3' : 'pr-3' }} pointer-events-none">
                        <span class="text-purple-600 dark:text-purple-400 text-xs font-semibold">%</span>
                    </div>
                </div>
            </div>

            <!-- Round to Next -->
            <div class="bg-slate-50 dark:bg-slate-900/50 p-3 rounded-lg border border-slate-200 dark:border-slate-700">
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                    {{ __('crm.round_to_next') }}
                </label>
                <p class="text-xs text-slate-500 dark:text-slate-400 mb-2 line-clamp-2">{{ __('crm.round_to_next_desc') }}</p>
                <select id="round-to" class="w-full px-2.5 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent text-xs transition-all">
                    <option value="none">{{ __('crm.no_rounding') }}</option>
                    <option value="0.99">0.99</option>
                    <option value="0.95">0.95</option>
                    <option value="0.50">0.50</option>
                    <option value="1.00">1.00</option>
                </select>
            </div>

            <!-- Options -->
            <div class="bg-slate-50 dark:bg-slate-900/50 p-3 rounded-lg border border-slate-200 dark:border-slate-700">
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                    {{ __('crm.options') }}
                </label>
                <p class="text-xs text-slate-500 dark:text-slate-400 mb-2">&nbsp;</p>
                
                <div class="space-y-2.5">
                    <!-- Sync Redemption/Grace Fee -->
                    <label class="flex items-start gap-2 cursor-pointer hover:bg-white dark:hover:bg-slate-800 p-2 rounded transition-colors {{ app()->getLocale() == 'ar' ? 'flex-row-reverse text-right' : '' }}" title="{{ app()->getLocale() == 'ar' ? 'عند التفعيل: تطبيق Markup تلقائياً على Restore/Grace. عند التعطيل: يمكنك تعديلها يدوياً' : 'When enabled: Auto-apply markup to Restore/Grace. When disabled: Edit them manually' }}">
                        <input type="checkbox" id="sync-fees" checked class="w-4 h-4 mt-0.5 text-purple-600 border-slate-300 dark:border-slate-600 rounded focus:ring-2 focus:ring-purple-500 cursor-pointer {{ app()->getLocale() == 'ar' ? 'ml-0 mr-auto' : 'mr-0 ml-auto' }}">
                        <div class="flex-1">
                            <span class="text-xs text-slate-700 dark:text-slate-300 select-none block">{{ __('crm.sync_fees') }}</span>
                            <span class="text-xs text-slate-500 dark:text-slate-400 select-none block mt-0.5">{{ app()->getLocale() == 'ar' ? 'تطبيق Markup تلقائياً' : 'Auto-apply markup' }}</span>
                        </div>
                    </label>

                    <!-- Auto Registration -->
                    <label class="flex items-center gap-2 cursor-pointer hover:bg-white dark:hover:bg-slate-800 p-2 rounded transition-colors {{ app()->getLocale() == 'ar' ? 'flex-row-reverse' : '' }}">
                        <input type="checkbox" id="auto-register" class="w-4 h-4 text-purple-600 border-slate-300 dark:border-slate-600 rounded focus:ring-2 focus:ring-purple-500 cursor-pointer">
                        <span class="text-xs text-slate-700 dark:text-slate-300 select-none">{{ __('crm.auto_registration') }}</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Apply Settings Button -->
        <div class="mt-4 flex {{ app()->getLocale() == 'ar' ? 'justify-start' : 'justify-end' }} border-t border-slate-200 dark:border-slate-700 pt-4">
            <button onclick="applyPricingSettings()" class="w-full sm:w-auto flex items-center justify-center gap-2 px-5 py-2.5 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-semibold rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-200 shadow-md hover:shadow-lg text-xs sm:text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ __('crm.apply_settings') }}
            </button>
        </div>
    </div>

    <!-- Pricing Table -->
    <div id="pricing-table" class="hidden space-y-3">
        <!-- Search Box Only -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 p-4 mb-6" @if(app()->getLocale() == 'ar') dir="rtl" @endif>
            <div class="relative flex-1 w-full sm:max-w-md mx-auto">
                <input type="text" id="tld-search" placeholder="{{ __('crm.search_tld') }}" 
                    class="w-full {{ app()->getLocale() == 'ar' ? 'pr-10 pl-4' : 'pl-10 pr-4' }} py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent text-sm transition-all"
                    oninput="filterTLDs(this.value)">
                <svg class="absolute {{ app()->getLocale() == 'ar' ? 'right-3' : 'left-3' }} top-1/2 transform -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <div class="mt-3 text-sm text-slate-600 dark:text-slate-400" id="results-info"></div>
        </div>

        <!-- Table Container -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden max-w-full" style="max-height: 70vh;">
            <div class="overflow-x-auto overflow-y-auto scrollbar-thin scrollbar-thumb-purple-600 scrollbar-track-slate-200 max-w-full" style="max-height: 70vh;">
                <table class="w-full min-w-[890px]">
                <thead class="bg-gradient-to-r from-purple-600 to-blue-600 text-white sticky top-0 z-10">
                    <tr>
                        <th class="px-1.5 py-2 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-semibold whitespace-nowrap sticky {{ app()->getLocale() == 'ar' ? 'right-0' : 'left-0' }} bg-gradient-to-r from-purple-600 to-purple-600 z-20" rowspan="2">TLD</th>
                        <th class="px-2 py-2 text-center text-xs font-semibold whitespace-nowrap" colspan="5">{{ __('crm.dynadot') }}</th>
                        <th class="px-2 py-2 text-center text-xs font-semibold whitespace-nowrap" colspan="5">{{ __('crm.progineous') }}</th>
                    </tr>
                    <tr class="bg-purple-700/50 sticky top-0 z-10">
                        <th class="px-1 py-2 text-center text-xs font-medium whitespace-nowrap" title="{{ __('crm.register') }}">{{ __('crm.reg') }}</th>
                        <th class="px-1 py-2 text-center text-xs font-medium whitespace-nowrap" title="{{ __('crm.renew') }}">{{ __('crm.ren') }}</th>
                        <th class="px-1 py-2 text-center text-xs font-medium whitespace-nowrap" title="{{ __('crm.transfer') }}">{{ __('crm.trans') }}</th>
                        <th class="px-1 py-2 text-center text-xs font-medium whitespace-nowrap" title="{{ __('crm.restore') }}">{{ __('crm.rest') }}</th>
                        <th class="px-1 py-2 text-center text-xs font-medium whitespace-nowrap" title="{{ __('crm.grace_fee') }}">{{ __('crm.grace') }}</th>
                        <th class="px-1 py-2 text-center text-xs font-medium whitespace-nowrap" title="{{ __('crm.register') }}">{{ __('crm.reg') }}</th>
                        <th class="px-1 py-2 text-center text-xs font-medium whitespace-nowrap" title="{{ __('crm.renew') }}">{{ __('crm.ren') }}</th>
                        <th class="px-1 py-2 text-center text-xs font-medium whitespace-nowrap" title="{{ __('crm.transfer') }}">{{ __('crm.trans') }}</th>
                        <th class="px-1 py-2 text-center text-xs font-medium whitespace-nowrap" title="{{ __('crm.restore') }}">{{ __('crm.rest') }}</th>
                        <th class="px-1 py-2 text-center text-xs font-medium whitespace-nowrap" title="{{ __('crm.grace_fee') }}">{{ __('crm.grace') }}</th>
                    </tr>
                </thead>
                <tbody id="pricing-tbody" class="divide-y divide-slate-200 dark:divide-slate-700">
                    <!-- Will be populated via JavaScript -->
                </tbody>
            </table>
        </div>
        </div>
    </div>

    <!-- Empty State -->
    <div id="empty-state" class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 p-12">
        <div class="flex flex-col items-center justify-center">
            <svg class="w-20 h-20 text-slate-300 dark:text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="text-xl font-semibold text-slate-700 dark:text-slate-300 mb-2">{{ __('crm.no_pricing_data') }}</h3>
            <p class="text-slate-500 dark:text-slate-400 text-center max-w-md mb-6">{{ __('crm.click_fetch_pricing') }}</p>
            <button onclick="fetchDynadotPricing()" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-semibold rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-200">
                {{ __('crm.fetch_now') }}
            </button>
        </div>
    </div>
</div>

<style>
/* Custom Scrollbar for Pricing Table */
.scrollbar-thin {
    scrollbar-width: thin;
    scrollbar-color: rgb(147 51 234) rgb(226 232 240);
}

.scrollbar-thumb-purple-600::-webkit-scrollbar-thumb {
    background-color: rgb(147 51 234);
    border-radius: 4px;
}

.scrollbar-thumb-purple-600::-webkit-scrollbar-thumb:hover {
    background-color: rgb(126 34 206);
}

.scrollbar-track-slate-200::-webkit-scrollbar-track {
    background-color: rgb(226 232 240);
}

.scrollbar-thin::-webkit-scrollbar {
    height: 10px;
    width: 10px;
}

.dark .scrollbar-track-slate-200::-webkit-scrollbar-track {
    background-color: rgb(51 65 85);
}

.dark .scrollbar-thin {
    scrollbar-color: rgb(147 51 234) rgb(51 65 85);
}

/* Sticky Column Shadow */
#pricing-table table td:first-child,
#pricing-table table th:first-child {
    box-shadow: 2px 0 4px -2px rgba(0, 0, 0, 0.1);
}

.dark #pricing-table table td:first-child,
.dark #pricing-table table th:first-child {
    box-shadow: 2px 0 4px -2px rgba(0, 0, 0, 0.3);
}

/* Table Responsiveness */
#pricing-table {
    max-width: 100vw;
}

#pricing-table table {
    table-layout: fixed;
    font-size: 0.75rem;
}

#pricing-table table th:first-child,
#pricing-table table td:first-child {
    width: 25px;
    min-width: 25px;
    max-width: 25px;
}

#pricing-table table th:not(:first-child),
#pricing-table table td:not(:first-child) {
    width: 85px;
    min-width: 85px;
}

/* Input Fields */
#pricing-table input[type="number"] {
    width: 70px !important;
    max-width: 70px;
    font-size: 0.7rem;
    padding: 0.25rem 0.35rem;
}

/* Responsive */
@media (max-width: 768px) {
    #pricing-table table th:first-child,
    #pricing-table table td:first-child {
        width: 50px;
        min-width: 50px;
    }
    
    #pricing-table table th:not(:first-child),
    #pricing-table table td:not(:first-child) {
        width: 70px;
        min-width: 70px;
    }
    
    #pricing-table input[type="number"] {
        width: 55px !important;
        max-width: 55px;
        font-size: 0.65rem;
        padding: 0.2rem 0.25rem;
    }
}

/* Smooth Scrolling */
#pricing-table > div {
    scroll-behavior: smooth;
}

/* Pricing Settings Improvements */
#pricing-settings .line-clamp-2 {
    overflow: hidden;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
    line-clamp: 2;
}

#pricing-settings input[type="number"]::-webkit-inner-spin-button,
#pricing-settings input[type="number"]::-webkit-outer-spin-button {
    opacity: 1;
}

#pricing-settings select:focus,
#pricing-settings input:focus {
    outline: none;
}

#pricing-settings label:has(input[type="checkbox"]):hover {
    background-color: rgba(147, 51, 234, 0.05);
}

.dark #pricing-settings label:has(input[type="checkbox"]):hover {
    background-color: rgba(147, 51, 234, 0.1);
}

/* Loading State */
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 150ms;
}

/* Responsive Grid */
@media (max-width: 640px) {
    #pricing-settings .grid {
        gap: 0.75rem;
    }
}
</style>

<script>
let pricingData = [];

async function fetchDynadotPricing() {
    const currency = document.getElementById('currency-select').value;
    const loadingState = document.getElementById('loading-state');
    const emptyState = document.getElementById('empty-state');
    const pricingTable = document.getElementById('pricing-table');
    const fetchBtn = document.getElementById('fetch-btn');

    // Show loading
    loadingState.classList.remove('hidden');
    emptyState.classList.add('hidden');
    pricingTable.classList.add('hidden');
    fetchBtn.disabled = true;

    try {
        const response = await fetch('{{ route("admin.system-settings.domains.pricing.dynadot.fetch") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ currency })
        });

        const data = await response.json();

        if (data.success && data.pricing) {
            pricingData = data.pricing;
            renderPricingTable(data.pricing, data.currency);
            loadingState.classList.add('hidden');
            pricingTable.classList.remove('hidden');
            document.getElementById('pricing-settings').classList.remove('hidden');
            document.getElementById('save-btn').disabled = false;
            
            // Show success toast
            const tldCount = Object.keys(data.pricing).length;
            const successMsg = '{{ __("crm.pricing_loaded_successfully", ["count" => ":count", "currency" => ":currency"]) }}'
                .replace(':count', tldCount)
                .replace(':currency', data.currency);
            showToast('✅ ' + successMsg, 'success');
        } else {
            throw new Error(data.message || 'Failed to fetch pricing');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('{{ __("crm.failed_to_fetch_pricing") }}: ' + error.message, 'error');
        loadingState.classList.add('hidden');
        emptyState.classList.remove('hidden');
    } finally {
        fetchBtn.disabled = false;
    }
}

let filteredData = {};
let searchQuery = '';

function calculateMarkup(basePrice) {
    const marginType = document.getElementById('margin-type').value;
    const markupValue = parseFloat(document.getElementById('markup-value').value) || 0;
    const roundTo = document.getElementById('round-to').value;
    
    let finalPrice = 0;
    
    if (marginType === 'percentage') {
        // Percentage markup: price + (price * markup/100)
        finalPrice = basePrice * (1 + markupValue / 100);
    } else {
        // Profit margin: price + markup
        finalPrice = basePrice + markupValue;
    }
    
    // Apply rounding
    if (roundTo !== 'none') {
        const roundValue = parseFloat(roundTo);
        finalPrice = Math.ceil(finalPrice) - (1 - roundValue);
    }
    
    return finalPrice;
}

function applyPricingSettings() {
    if (Object.keys(pricingData).length > 0) {
        const currency = document.getElementById('currency-select').value;
        renderPricingTable(pricingData, currency);
    }
}

function filterTLDs(query) {
    searchQuery = query.toLowerCase();
    
    if (query === '') {
        filteredData = pricingData;
    } else {
        filteredData = {};
        Object.keys(pricingData).forEach(tld => {
            if (tld.toLowerCase().includes(searchQuery)) {
                filteredData[tld] = pricingData[tld];
            }
        });
    }
    
    const currency = document.getElementById('currency-select').value;
    renderPricingTable(filteredData, currency);
}

function renderPricingTable(pricing, currency) {
    const tbody = document.getElementById('pricing-tbody');
    tbody.innerHTML = '';

    // Get all TLDs as array (filtered)
    const allTLDs = Object.keys(pricing).filter(tld => {
        const price = pricing[tld];
        const registerPrice = parseFloat(price.Register || price.register || 0) || 0;
        const renewPrice = parseFloat(price.Renew || price.renew || 0) || 0;
        const transferPrice = parseFloat(price.Transfer || price.transfer || 0) || 0;
        // Skip if all prices are 0
        return !(registerPrice === 0 && renewPrice === 0 && transferPrice === 0);
    });

    // Show info about results
    const resultsInfo = document.getElementById('results-info');
    if (resultsInfo) {
        if (allTLDs.length === 0) {
            resultsInfo.textContent = (searchQuery && searchQuery.length > 0)
                ? (window.Lang && Lang.get ? Lang.get('crm.no_results_found', {query: searchQuery}) : 'لا توجد نتائج')
                : '';
        } else {
            resultsInfo.textContent = (window.Lang && Lang.get ? Lang.get('crm.showing_results', {from: 1, to: allTLDs.length, total: allTLDs.length}) : `عرض ${allTLDs.length} نطاق`);
        }
    }

    allTLDs.forEach((tld, index) => {
        const price = pricing[tld];
        
        // Handle different price formats
        const registerPrice = parseFloat(price.Register || price.register || 0) || 0;
        const renewPrice = parseFloat(price.Renew || price.renew || 0) || 0;
        const transferPrice = parseFloat(price.Transfer || price.transfer || 0) || 0;
        const restorePrice = parseFloat(price.Restore || price.restore || 0) || 0;
        const graceFee = parseFloat(price.GraceFee || price.graceFee || 0) || 0;

        // Skip if all prices are 0
        if (registerPrice === 0 && renewPrice === 0 && transferPrice === 0) {
            return;
        }

        // Check if sync fees is enabled
        const syncFees = document.getElementById('sync-fees').checked;

        // Calculate markup prices for all fields
        const markupRegister = calculateMarkup(registerPrice);
        const markupRenew = calculateMarkup(renewPrice);
        const markupTransfer = calculateMarkup(transferPrice);
        // Always apply markup to Restore and GraceFee
        const markupRestore = calculateMarkup(restorePrice);
        const markupGraceFee = calculateMarkup(graceFee);
        
        // If sync fees is disabled, user can edit Restore and GraceFee manually
        const restoreEditable = !syncFees;
        const graceFeeEditable = !syncFees;

        const row = document.createElement('tr');
        row.className = index % 2 === 0 ? 'bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700' : 'bg-slate-50 dark:bg-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800';
        
        const isRTL = '{{ app()->getLocale() }}' === 'ar';
        
        // Currency symbol
        const currSymbol = currency === 'USD' ? '$' : currency === 'EUR' ? '€' : currency === 'GBP' ? '£' : currency;
        
        row.innerHTML = `
            <td class="px-2 py-2 font-semibold text-slate-900 dark:text-white text-xs whitespace-nowrap sticky ${isRTL ? 'right-0' : 'left-0'} ${index % 2 === 0 ? 'bg-white dark:bg-slate-800' : 'bg-slate-50 dark:bg-slate-900'} shadow-sm z-10">.${tld}</td>
            <td class="px-1 py-2 text-center text-slate-700 dark:text-slate-300 text-xs whitespace-nowrap">${currSymbol}${registerPrice.toFixed(2)}</td>
            <td class="px-1 py-2 text-center text-slate-700 dark:text-slate-300 text-xs whitespace-nowrap">${currSymbol}${renewPrice.toFixed(2)}</td>
            <td class="px-1 py-2 text-center text-slate-700 dark:text-slate-300 text-xs whitespace-nowrap">${currSymbol}${transferPrice.toFixed(2)}</td>
            <td class="px-1 py-2 text-center text-slate-700 dark:text-slate-300 text-xs whitespace-nowrap">${currSymbol}${restorePrice.toFixed(2)}</td>
            <td class="px-1 py-2 text-center text-slate-700 dark:text-slate-300 text-xs whitespace-nowrap">${currSymbol}${graceFee.toFixed(2)}</td>
            <td class="px-1 py-2 text-center">
                <input type="number" step="0.01" value="${markupRegister.toFixed(2)}" 
                    class="w-full px-1 py-1 border border-slate-300 dark:border-slate-600 rounded bg-white dark:bg-slate-700 text-slate-900 dark:text-white text-center text-xs focus:ring-1 focus:ring-purple-500"
                    data-tld="${tld}" data-type="register">
            </td>
            <td class="px-1 py-2 text-center">
                <input type="number" step="0.01" value="${markupRenew.toFixed(2)}" 
                    class="w-full px-1 py-1 border border-slate-300 dark:border-slate-600 rounded bg-white dark:bg-slate-700 text-slate-900 dark:text-white text-center text-xs focus:ring-1 focus:ring-purple-500"
                    data-tld="${tld}" data-type="renew">
            </td>
            <td class="px-1 py-2 text-center">
                <input type="number" step="0.01" value="${markupTransfer.toFixed(2)}" 
                    class="w-full px-1 py-1 border border-slate-300 dark:border-slate-600 rounded bg-white dark:bg-slate-700 text-slate-900 dark:text-white text-center text-xs focus:ring-1 focus:ring-purple-500"
                    data-tld="${tld}" data-type="transfer">
            </td>
            <td class="px-1 py-2 text-center">
                <input type="number" step="0.01" value="${markupRestore.toFixed(2)}" 
                    class="w-full px-1 py-1 border border-slate-300 dark:border-slate-600 rounded bg-white dark:bg-slate-700 text-slate-900 dark:text-white text-center text-xs focus:ring-1 focus:ring-purple-500 ${restoreEditable ? '' : 'bg-slate-100 dark:bg-slate-600'}"
                    data-tld="${tld}" data-type="restore" ${restoreEditable ? '' : 'readonly'}>
            </td>
            <td class="px-1 py-2 text-center">
                <input type="number" step="0.01" value="${markupGraceFee.toFixed(2)}" 
                    class="w-full px-1 py-1 border border-slate-300 dark:border-slate-600 rounded bg-white dark:bg-slate-700 text-slate-900 dark:text-white text-center text-xs focus:ring-1 focus:ring-purple-500 ${graceFeeEditable ? '' : 'bg-slate-100 dark:bg-slate-600'}"
                    data-tld="${tld}" data-type="graceFee" ${graceFeeEditable ? '' : 'readonly'}>
            </td>
        `;

        tbody.appendChild(row);
    });
}

async function savePricing() {
    const inputs = document.querySelectorAll('#pricing-tbody input[type="number"]');
    const pricing = {};

    inputs.forEach(input => {
        const tld = input.dataset.tld;
        const type = input.dataset.type;
        
        if (!pricing[tld]) {
            pricing[tld] = { tld: tld };
        }

        // Save Pro Gineous prices (with markup applied)
        pricing[tld][`progineous_${type}`] = parseFloat(input.value) || 0;
        
        // Get Dynadot prices from pricingData
        if (pricingData[tld]) {
            pricing[tld].dynadot_register = parseFloat(pricingData[tld].Register || 0);
            pricing[tld].dynadot_renew = parseFloat(pricingData[tld].Renew || 0);
            pricing[tld].dynadot_transfer = parseFloat(pricingData[tld].Transfer || 0);
            pricing[tld].dynadot_restore = parseFloat(pricingData[tld].Restore || 0);
            pricing[tld].dynadot_graceFee = parseFloat(pricingData[tld].GraceFee || 0);
        }
    });

    // Get currency
    const currency = document.getElementById('currency-select').value;
    
    // Get pricing settings
    const marginType = document.getElementById('margin-type').value;
    const markupValue = parseFloat(document.getElementById('markup-value').value) || 0;
    const roundTo = document.getElementById('round-to').value;
    const syncFees = document.getElementById('sync-fees').checked;
    const autoRegister = document.getElementById('auto-register').checked;

    try {
        const saveBtn = document.getElementById('save-btn');
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<svg class="w-5 h-5 animate-spin inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Saving...';

        const response = await fetch('{{ route("admin.system-settings.domains.pricing.dynadot.save") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ 
                pricing: Object.values(pricing),
                settings: {
                    currency: currency,
                    margin_type: marginType,
                    markup_value: markupValue,
                    round_to: roundTo,
                    sync_fees: syncFees,
                    auto_register: autoRegister
                }
            })
        });

        const data = await response.json();

        if (data.success) {
            showToast(data.message || '{{ __("crm.pricing_saved_successfully") }}', 'success');
            saveBtn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg><span>{{ __("crm.save_pricing") }}</span>';
        } else {
            showToast('{{ __("crm.failed_to_save_pricing") }}: ' + (data.message || ''), 'error');
            saveBtn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg><span>{{ __("crm.save_pricing") }}</span>';
        }
        
        saveBtn.disabled = false;
    } catch (error) {
        console.error('Error:', error);
        showToast('{{ __("crm.failed_to_save_pricing") }}: ' + error.message, 'error');
        const saveBtn = document.getElementById('save-btn');
        saveBtn.disabled = false;
        saveBtn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg><span>{{ __("crm.save_pricing") }}</span>';
    }
}

/**
 * Show toast notification
 * @param {string} message - The message to display
 * @param {string} type - Type of toast: 'success', 'error', 'warning', 'info'
 * @param {number} duration - Duration in milliseconds (default: 5000)
 */
function showToast(message, type = 'success', duration = 5000) {
    const container = document.getElementById('toast-container');
    const isRTL = document.documentElement.dir === 'rtl';
    
    // Create toast element
    const toast = document.createElement('div');
    toast.className = `transform transition-all duration-300 ease-in-out ${isRTL ? 'translate-x-full' : '-translate-x-full'}`;
    
    // Toast colors based on type
    const colors = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        warning: 'bg-yellow-500',
        info: 'bg-blue-500'
    };
    
    // Toast icons
    const icons = {
        success: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>',
        error: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>',
        warning: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>',
        info: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'
    };
    
    toast.innerHTML = `
        <div class="${colors[type]} text-white px-6 py-4 rounded-lg shadow-2xl flex items-center gap-3 min-w-[300px] max-w-md">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                ${icons[type]}
            </svg>
            <p class="font-medium flex-1">${message}</p>
            <button onclick="this.parentElement.parentElement.remove()" class="hover:bg-white/20 rounded p-1 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    `;
    
    container.appendChild(toast);
    
    // Animate in
    setTimeout(() => {
        toast.classList.remove(isRTL ? 'translate-x-full' : '-translate-x-full');
        toast.classList.add('translate-x-0');
    }, 10);
    
    // Auto remove after duration
    setTimeout(() => {
        toast.classList.add(isRTL ? 'translate-x-full' : '-translate-x-full');
        toast.classList.remove('translate-x-0');
        setTimeout(() => toast.remove(), 300);
    }, duration);
}

// Update markup symbol based on margin type and currency
function updateMarkupSymbol() {
    const marginType = document.getElementById('margin-type').value;
    const currency = document.getElementById('currency-select').value;
    const symbolContainer = document.getElementById('markup-symbol');
    const input = document.getElementById('markup-value');
    
    if (!symbolContainer || !input) return;
    
    const symbolSpan = symbolContainer.querySelector('span');
    
    if (marginType === 'percentage') {
        // Show percentage symbol
        symbolSpan.textContent = '%';
        input.step = '1';
        input.min = '0';
        input.max = '100'; // Reasonable max for percentage
    } else {
        // Show currency symbol for profit margin
        const currencySymbols = {
            'USD': '$',
            'EUR': '€',
            'GBP': '£',
            'CAD': 'C$',
            'AUD': 'A$'
        };
        
        symbolSpan.textContent = currencySymbols[currency] || currency;
        input.step = '0.01';
        input.min = '0';
        input.removeAttribute('max'); // No max for fixed amount
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Set initial symbol
    updateMarkupSymbol();
    
    // Add event listeners
    const marginTypeSelect = document.getElementById('margin-type');
    const currencySelect = document.getElementById('currency-select');
    
    if (marginTypeSelect) {
        marginTypeSelect.addEventListener('change', updateMarkupSymbol);
    }
    
    if (currencySelect) {
        currencySelect.addEventListener('change', updateMarkupSymbol);
    }
});
</script>
@endsection
