@extends('frontend.layout')

@section('title', __('frontend.tld_list'))

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
                        {{ __('frontend.pricing_list') }}
                    </span>
                </div>
                
                <!-- Title -->
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black text-transparent bg-clip-text bg-gradient-to-r from-slate-900 via-blue-800 to-indigo-900 dark:from-slate-100 dark:via-blue-200 dark:to-indigo-200 mb-6 leading-tight sm:leading-snug px-4">
                    {{ __('frontend.tld_list_title') }}
                </h1>
                
                <!-- Subtitle -->
                <p class="text-base sm:text-lg md:text-xl text-slate-600 dark:text-slate-300 max-w-3xl mx-auto leading-relaxed px-4">
                    {{ __('frontend.tld_list_desc') }}
                </p>
            </div>
        </div>
    </section>

    <!-- Search and Filter Section -->
    <section class="py-8 relative z-10">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                
                <!-- Search Bar -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl shadow-xl border border-slate-200/50 dark:border-slate-700/50 p-6 mb-8">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <!-- Search Input -->
                        <div class="flex-1 relative">
                            <input
                                type="text"
                                id="tldSearch"
                                placeholder="{{ __('frontend.search_tld') }}"
                                class="w-full px-4 py-3 {{ app()->getLocale() == 'ar' ? 'pr-12' : 'pl-12' }} bg-slate-50 dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-700 rounded-xl focus:border-blue-500 dark:focus:border-blue-400 focus:ring-4 focus:ring-blue-500/20 outline-none transition-all duration-300 text-slate-800 dark:text-slate-100"
                                oninput="filterTLDs()"
                            >
                            <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'right-0 pr-4' : 'left-0 pl-4' }} flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Category Filter -->
                        <div class="sm:w-64">
                            <select
                                id="categoryFilter"
                                onchange="filterTLDs()"
                                class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-700 rounded-xl focus:border-blue-500 dark:focus:border-blue-400 focus:ring-4 focus:ring-blue-500/20 outline-none transition-all duration-300 text-slate-800 dark:text-slate-100"
                            >
                                <option value="all">{{ __('frontend.all_categories') }}</option>
                                <option value="popular">{{ __('frontend.popular') }}</option>
                                <option value="new">{{ __('frontend.new_tlds') }}</option>
                                <option value="cheap">{{ __('frontend.budget_friendly') }}</option>
                                <option value="premium">{{ __('frontend.premium') }}</option>
                            </select>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="mt-6 flex flex-wrap items-center gap-4 text-sm">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                            <span class="text-slate-600 dark:text-slate-400">
                                <span id="totalCount" class="font-bold text-slate-800 dark:text-slate-200">{{ count($tlds) }}</span> 
                                {{ __('frontend.total_extensions') }}
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                            <span class="text-slate-600 dark:text-slate-400">
                                <span id="visibleCount" class="font-bold text-slate-800 dark:text-slate-200">{{ count($tlds) }}</span> 
                                {{ __('frontend.showing') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Info Alert about N/A -->
                <div class="bg-blue-50/50 dark:bg-blue-900/10 border-l-4 border-blue-500 rounded-lg p-4 mb-6">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-bold text-blue-900 dark:text-blue-200 mb-1">
                                {{ __('frontend.important_note') }}
                            </h4>
                            <p class="text-sm text-blue-800 dark:text-blue-300 leading-relaxed">
                                {{ __('frontend.na_explanation') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- TLD Table -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl shadow-xl border border-slate-200/50 dark:border-slate-700/50 overflow-hidden">
                    <!-- Table Header - Desktop -->
                    <div class="hidden md:grid md:grid-cols-6 gap-4 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border-b border-slate-200 dark:border-slate-700">
                        <div class="font-bold text-slate-800 dark:text-slate-200 text-sm uppercase tracking-wider">
                            {{ __('frontend.extension') }}
                        </div>
                        <div class="font-bold text-slate-800 dark:text-slate-200 text-sm uppercase tracking-wider text-center">
                            {{ __('frontend.registration') }}
                        </div>
                        <div class="font-bold text-slate-800 dark:text-slate-200 text-sm uppercase tracking-wider text-center">
                            {{ __('frontend.renewal') }}
                        </div>
                        <div class="font-bold text-slate-800 dark:text-slate-200 text-sm uppercase tracking-wider text-center">
                            {{ __('frontend.transfer') }}
                        </div>
                        <div class="font-bold text-slate-800 dark:text-slate-200 text-sm uppercase tracking-wider text-center">
                            {{ __('frontend.restore') }}
                        </div>
                        <div class="font-bold text-slate-800 dark:text-slate-200 text-sm uppercase tracking-wider text-center">
                            {{ __('frontend.action') }}
                        </div>
                    </div>

                    <!-- Table Body -->
                    <div id="tldTableBody" class="divide-y divide-slate-200 dark:divide-slate-700">
                        @foreach($tlds as $tld)
                        <div class="tld-row p-4 sm:p-6 hover:bg-blue-50/50 dark:hover:bg-slate-700/30 transition-colors duration-200"
                             data-tld="{{ $tld['tld'] }}"
                             data-register="{{ $tld['register'] }}"
                             data-category="{{ in_array($tld['tld'], ['com', 'net', 'org', 'io', 'co']) ? 'popular' : (in_array($tld['tld'], ['app', 'dev', 'ai', 'tech', 'cloud']) ? 'new' : ($tld['register'] < 10 ? 'cheap' : ($tld['register'] > 50 ? 'premium' : 'all'))) }}">
                            
                            <!-- Mobile Layout -->
                            <div class="md:hidden space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-xl font-black text-blue-600 dark:text-blue-400">.{{ $tld['tld'] }}</span>
                                    <a href="{{ route('domains.search') }}?tld={{ $tld['tld'] }}" 
                                       class="px-3 py-1.5 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg font-semibold hover:scale-105 transition-transform text-xs">
                                        {{ __('frontend.register') }}
                                    </a>
                                </div>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-center">
                                    <div>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">{{ __('frontend.registration') }}</p>
                                        <p class="text-sm font-bold text-slate-800 dark:text-slate-200">${{ number_format($tld['register'], 2) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">{{ __('frontend.renewal') }}</p>
                                        <p class="text-sm font-bold text-slate-800 dark:text-slate-200">${{ number_format($tld['renew'], 2) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">{{ __('frontend.transfer') }}</p>
                                        <p class="text-sm font-bold text-slate-800 dark:text-slate-200">${{ number_format($tld['transfer'], 2) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">{{ __('frontend.restore') }}</p>
                                        <p class="text-sm font-bold text-slate-800 dark:text-slate-200">
                                            @if($tld['restore'] && $tld['restore'] > 0)
                                                ${{ number_format($tld['restore'], 2) }}
                                            @else
                                                <span class="text-slate-400">N/A</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Desktop Layout -->
                            <div class="hidden md:grid md:grid-cols-6 gap-4 items-center">
                                <div>
                                    <span class="text-xl font-black text-blue-600 dark:text-blue-400">.{{ $tld['tld'] }}</span>
                                </div>
                                <div class="text-center">
                                    <span class="text-lg font-bold text-slate-800 dark:text-slate-200">${{ number_format($tld['register'], 2) }}</span>
                                    <span class="text-xs text-slate-500 dark:text-slate-400">/{{ __('frontend.year') }}</span>
                                </div>
                                <div class="text-center">
                                    <span class="text-lg font-bold text-slate-800 dark:text-slate-200">${{ number_format($tld['renew'], 2) }}</span>
                                    <span class="text-xs text-slate-500 dark:text-slate-400">/{{ __('frontend.year') }}</span>
                                </div>
                                <div class="text-center">
                                    <span class="text-lg font-bold text-slate-800 dark:text-slate-200">${{ number_format($tld['transfer'], 2) }}</span>
                                    <span class="text-xs text-slate-500 dark:text-slate-400">/{{ __('frontend.year') }}</span>
                                </div>
                                <div class="text-center">
                                    @if($tld['restore'] && $tld['restore'] > 0)
                                        <span class="text-lg font-bold text-slate-800 dark:text-slate-200">${{ number_format($tld['restore'], 2) }}</span>
                                        <span class="text-xs text-slate-500 dark:text-slate-400">/{{ __('frontend.year') }}</span>
                                    @else
                                        <span class="text-sm text-slate-400 dark:text-slate-500">N/A</span>
                                    @endif
                                </div>
                                <div class="text-center">
                                    <a href="{{ route('domains.search') }}?tld={{ $tld['tld'] }}" 
                                       class="inline-flex items-center justify-center px-6 py-2.5 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg font-semibold hover:scale-105 transition-transform text-sm">
                                        {{ __('frontend.register') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- No Results Message -->
                    <div id="noResults" class="hidden p-12 text-center">
                        <svg class="w-16 h-16 mx-auto mb-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-xl font-bold text-slate-700 dark:text-slate-300 mb-2">{{ __('frontend.no_results_found') }}</h3>
                        <p class="text-slate-500 dark:text-slate-400">{{ __('frontend.try_different_search') }}</p>
                    </div>
                </div>

                <!-- Info Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                    <!-- Card 1 -->
                    <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl rounded-xl p-6 border border-slate-200/50 dark:border-slate-700/50">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200 mb-2">{{ __('frontend.competitive_pricing') }}</h3>
                        <p class="text-sm text-slate-600 dark:text-slate-400">{{ __('frontend.competitive_pricing_desc') }}</p>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl rounded-xl p-6 border border-slate-200/50 dark:border-slate-700/50">
                        <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200 mb-2">{{ __('frontend.instant_activation') }}</h3>
                        <p class="text-sm text-slate-600 dark:text-slate-400">{{ __('frontend.instant_activation_desc') }}</p>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl rounded-xl p-6 border border-slate-200/50 dark:border-slate-700/50">
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200 mb-2">{{ __('frontend.free_support') }}</h3>
                        <p class="text-sm text-slate-600 dark:text-slate-400">{{ __('frontend.free_support_desc') }}</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

</div>

@push('scripts')
<script>
function filterTLDs() {
    const searchTerm = document.getElementById('tldSearch').value.toLowerCase().trim();
    const category = document.getElementById('categoryFilter').value;
    const rows = document.querySelectorAll('.tld-row');
    const noResults = document.getElementById('noResults');
    const visibleCountSpan = document.getElementById('visibleCount');
    
    let visibleCount = 0;
    
    rows.forEach(row => {
        const tld = row.dataset.tld.toLowerCase();
        const rowCategory = row.dataset.category;
        const register = parseFloat(row.dataset.register);
        
        // Check search term
        const matchesSearch = searchTerm === '' || tld.includes(searchTerm);
        
        // Check category
        let matchesCategory = false;
        if (category === 'all') {
            matchesCategory = true;
        } else if (category === 'popular') {
            matchesCategory = rowCategory === 'popular';
        } else if (category === 'new') {
            matchesCategory = rowCategory === 'new';
        } else if (category === 'cheap') {
            matchesCategory = register < 10;
        } else if (category === 'premium') {
            matchesCategory = register > 50;
        }
        
        // Show or hide row
        if (matchesSearch && matchesCategory) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    // Update visible count
    visibleCountSpan.textContent = visibleCount;
    
    // Show/hide no results message
    if (visibleCount === 0) {
        noResults.classList.remove('hidden');
    } else {
        noResults.classList.add('hidden');
    }
}

// Clear search on load
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('tldSearch').value = '';
    document.getElementById('categoryFilter').value = 'all';
});
</script>
@endpush
@endsection
