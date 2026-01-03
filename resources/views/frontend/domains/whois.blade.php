@extends('frontend.layout')

@section('title', __('frontend.whois_lookup'))

@section('content')

<!-- Hero Section with Integrated Search -->
<section class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 py-24 overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute transform rotate-45 -left-1/4 -top-1/4 w-96 h-96 bg-white rounded-full"></div>
        <div class="absolute transform -rotate-45 -right-1/4 -bottom-1/4 w-96 h-96 bg-white rounded-full"></div>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto">
            <!-- Icon -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-white/20 backdrop-blur-sm rounded-3xl shadow-2xl">
                    <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
            
            <!-- Title -->
            <div class="text-center mb-12">
                <h1 class="text-5xl md:text-6xl font-bold text-white mb-6" dir="auto">
                    {{ __('frontend.whois_lookup') }}
                </h1>
                <p class="text-xl md:text-2xl text-blue-100 max-w-3xl mx-auto leading-relaxed" dir="auto">
                    {{ __('frontend.whois_description') }}
                </p>
            </div>
            
            <!-- Search Form -->
            <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-10">
                <form id="whois-form" class="space-y-6">
                    @csrf
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                            <svg class="w-6 h-6 text-gray-400 group-focus-within:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            name="domain" 
                            id="domain-input"
                            class="w-full pl-16 pr-6 py-6 text-lg border-2 border-gray-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all duration-200 outline-none placeholder-gray-400"
                            placeholder="{{ __('frontend.enter_domain_name') }}"
                            required
                        >
                    </div>
                    
                    <button 
                        type="submit" 
                        id="lookup-btn"
                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-6 px-8 rounded-2xl shadow-xl hover:shadow-2xl transform hover:scale-[1.02] active:scale-[0.98] transition-all duration-200 text-xl flex items-center justify-center gap-3"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span>{{ __('frontend.lookup') }}</span>
                    </button>
                </form>
                
                <!-- Loading State -->
                <div id="loading" class="hidden mt-8">
                    <div class="flex items-center justify-center gap-4 text-blue-600">
                        <div class="relative">
                            <div class="animate-spin rounded-full h-10 w-10 border-4 border-blue-200 border-t-blue-600"></div>
                            <div class="absolute inset-0 animate-ping rounded-full h-10 w-10 border-4 border-blue-300 opacity-20"></div>
                        </div>
                        <span class="text-lg font-semibold">{{ __('frontend.searching') }}...</span>
                    </div>
                </div>
                
                <!-- Error Message -->
                <div id="error-message" class="hidden mt-6">
                    <div class="bg-red-50 border-l-4 border-red-500 p-5 rounded-xl">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-red-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-red-800 mb-1">{{ __('frontend.error') }}</h4>
                                <p id="error-text" class="text-red-700"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Use Our WHOIS Search Section -->
<section class="py-20 bg-white dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full text-sm font-semibold mb-4" dir="auto">
                    {{ __('frontend.powerful_features') }}
                </span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6" dir="auto">
                    {{ __('frontend.use_whois_search') }}
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto" dir="auto">
                    {{ __('frontend.use_whois_search_desc') }}
                </p>
            </div>
            
            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1: Domain Information -->
                <div class="group bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4" dir="auto">
                        {{ __('frontend.domain_information') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed" dir="auto">
                        {{ __('frontend.domain_information_desc') }}
                    </p>
                </div>
                
                <!-- Feature 2: Registrar Details -->
                <div class="group bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4" dir="auto">
                        {{ __('frontend.registrar_details') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed" dir="auto">
                        {{ __('frontend.registrar_details_desc') }}
                    </p>
                </div>
                
                <!-- Feature 3: Contact Information -->
                <div class="group bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4" dir="auto">
                        {{ __('frontend.contact_information') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed" dir="auto">
                        {{ __('frontend.contact_information_desc') }}
                    </p>
                </div>
                
                <!-- Feature 4: Name Servers -->
                <div class="group bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4" dir="auto">
                        {{ __('frontend.nameserver_info') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed" dir="auto">
                        {{ __('frontend.nameserver_info_desc') }}
                    </p>
                </div>
                
                <!-- Feature 5: Domain Status -->
                <div class="group bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4" dir="auto">
                        {{ __('frontend.domain_status') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed" dir="auto">
                        {{ __('frontend.domain_status_desc') }}
                    </p>
                </div>
                
                <!-- Feature 6: IP Information -->
                <div class="group bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4" dir="auto">
                        {{ __('frontend.ip_information') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed" dir="auto">
                        {{ __('frontend.ip_information_desc') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How WHOIS Works Section -->
<section class="py-20 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4" dir="auto">
                    {{ __('frontend.how_whois_works') }}
                </h2>
            </div>

            <!-- Content Card -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 md:p-12 border border-gray-200 dark:border-gray-700">
                <div class="space-y-6 text-lg text-gray-700 dark:text-gray-300 leading-relaxed">
                    <!-- Paragraph 1 -->
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <p dir="auto">{{ __('frontend.whois_works_p1') }}</p>
                    </div>

                    <!-- Paragraph 2 -->
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <p dir="auto">{{ __('frontend.whois_works_p2') }}</p>
                    </div>

                    <!-- Paragraph 3 -->
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <p dir="auto">{{ __('frontend.whois_works_p3') }}</p>
                    </div>
                </div>

                <!-- CTA Button -->
                <div class="mt-10 text-center">
                    <a href="#whois-form" class="inline-flex items-center gap-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-4 px-8 rounded-2xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span dir="auto">{{ __('frontend.make_your_whois_search') }}</span>
                    </a>
                </div>
            </div>

            <!-- Info Badge -->
            <div class="mt-8 text-center">
                <div class="inline-flex items-center gap-2 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 px-6 py-3 rounded-full text-sm font-semibold">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <span dir="auto">{{ __('frontend.icann_compliant_whois') }}</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- What is WHOIS Used For Section -->
<section class="py-20 bg-white dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6" dir="auto">
                    {{ __('frontend.what_is_whois_used_for') }}
                </h2>
            </div>

            <!-- Main Content -->
            <div class="mb-12">
                <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-3xl p-8 md:p-10 border border-purple-200 dark:border-purple-800">
                    <p class="text-lg text-gray-700 dark:text-gray-300 leading-relaxed mb-4" dir="auto">
                        {{ __('frontend.whois_used_for_intro') }}
                    </p>
                    <p class="text-lg text-gray-700 dark:text-gray-300 leading-relaxed" dir="auto">
                        {{ __('frontend.whois_used_for_extended') }}
                    </p>
                </div>
            </div>

            <!-- Use Cases Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Use Case 1: Domain Acquisition -->
                <div class="group bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700 hover:border-purple-300 dark:hover:border-purple-700">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2" dir="auto">
                                {{ __('frontend.domain_acquisition') }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400" dir="auto">
                                {{ __('frontend.domain_acquisition_desc') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Use Case 2: Legal Investigation -->
                <div class="group bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700 hover:border-pink-300 dark:hover:border-pink-700">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2" dir="auto">
                                {{ __('frontend.legal_investigation') }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400" dir="auto">
                                {{ __('frontend.legal_investigation_desc') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Use Case 3: Journalism Research -->
                <div class="group bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700 hover:border-indigo-300 dark:hover:border-indigo-700">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2" dir="auto">
                                {{ __('frontend.journalism_research') }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400" dir="auto">
                                {{ __('frontend.journalism_research_desc') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Use Case 4: Network Diagnosis -->
                <div class="group bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-700">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2" dir="auto">
                                {{ __('frontend.network_diagnosis') }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400" dir="auto">
                                {{ __('frontend.network_diagnosis_desc') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Privacy Warning -->
            <div class="mt-12">
                <div class="bg-amber-50 dark:bg-amber-900/20 border-l-4 border-amber-500 rounded-xl p-6">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-lg font-bold text-amber-900 dark:text-amber-300 mb-2" dir="auto">
                                {{ __('frontend.whois_privacy_title') }}
                            </h4>
                            <p class="text-amber-800 dark:text-amber-200" dir="auto">
                                {{ __('frontend.whois_privacy_warning') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- WHOIS FAQs Section -->
<section class="py-20 bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4" dir="auto">
                    {{ __('frontend.whois_faqs') }}
                </h2>
            </div>

            <!-- FAQ Accordion -->
            <div class="space-y-4">
                <!-- FAQ 1 -->
                <details class="group bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300">
                    <summary class="cursor-pointer px-6 py-5 font-bold text-lg text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors flex items-center justify-between" dir="auto">
                        <span class="flex items-center gap-3">
                            <span class="flex-shrink-0 w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center text-blue-600 dark:text-blue-400 font-bold text-sm">1</span>
                            {{ __('frontend.faq_1_q') }}
                        </span>
                        <svg class="w-5 h-5 text-gray-500 group-open:rotate-180 transition-transform flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </summary>
                    <div class="px-6 pb-6 pt-2 text-gray-700 dark:text-gray-300 leading-relaxed border-t border-gray-100 dark:border-gray-700" dir="auto">
                        <p>{{ __('frontend.faq_1_a') }}</p>
                    </div>
                </details>

                <!-- FAQ 2 -->
                <details class="group bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300">
                    <summary class="cursor-pointer px-6 py-5 font-bold text-lg text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors flex items-center justify-between" dir="auto">
                        <span class="flex items-center gap-3">
                            <span class="flex-shrink-0 w-8 h-8 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold text-sm">2</span>
                            {{ __('frontend.faq_2_q') }}
                        </span>
                        <svg class="w-5 h-5 text-gray-500 group-open:rotate-180 transition-transform flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </summary>
                    <div class="px-6 pb-6 pt-2 text-gray-700 dark:text-gray-300 leading-relaxed border-t border-gray-100 dark:border-gray-700" dir="auto">
                        <p>{{ __('frontend.faq_2_a') }}</p>
                    </div>
                </details>

                <!-- FAQ 3 -->
                <details class="group bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300">
                    <summary class="cursor-pointer px-6 py-5 font-bold text-lg text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors flex items-center justify-between" dir="auto">
                        <span class="flex items-center gap-3">
                            <span class="flex-shrink-0 w-8 h-8 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center text-purple-600 dark:text-purple-400 font-bold text-sm">3</span>
                            {{ __('frontend.faq_3_q') }}
                        </span>
                        <svg class="w-5 h-5 text-gray-500 group-open:rotate-180 transition-transform flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </summary>
                    <div class="px-6 pb-6 pt-2 text-gray-700 dark:text-gray-300 leading-relaxed border-t border-gray-100 dark:border-gray-700" dir="auto">
                        <p>{{ __('frontend.faq_3_a') }}</p>
                    </div>
                </details>

                <!-- FAQ 4 -->
                <details class="group bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300">
                    <summary class="cursor-pointer px-6 py-5 font-bold text-lg text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors flex items-center justify-between" dir="auto">
                        <span class="flex items-center gap-3">
                            <span class="flex-shrink-0 w-8 h-8 bg-pink-100 dark:bg-pink-900/30 rounded-full flex items-center justify-center text-pink-600 dark:text-pink-400 font-bold text-sm">4</span>
                            {{ __('frontend.faq_4_q') }}
                        </span>
                        <svg class="w-5 h-5 text-gray-500 group-open:rotate-180 transition-transform flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </summary>
                    <div class="px-6 pb-6 pt-2 text-gray-700 dark:text-gray-300 leading-relaxed border-t border-gray-100 dark:border-gray-700" dir="auto">
                        <p>{{ __('frontend.faq_4_a') }}</p>
                    </div>
                </details>

                <!-- FAQ 5 -->
                <details class="group bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300">
                    <summary class="cursor-pointer px-6 py-5 font-bold text-lg text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors flex items-center justify-between" dir="auto">
                        <span class="flex items-center gap-3">
                            <span class="flex-shrink-0 w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center text-green-600 dark:text-green-400 font-bold text-sm">5</span>
                            {{ __('frontend.faq_5_q') }}
                        </span>
                        <svg class="w-5 h-5 text-gray-500 group-open:rotate-180 transition-transform flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </summary>
                    <div class="px-6 pb-6 pt-2 text-gray-700 dark:text-gray-300 leading-relaxed border-t border-gray-100 dark:border-gray-700" dir="auto">
                        <p>{{ __('frontend.faq_5_a') }}</p>
                    </div>
                </details>

                <!-- FAQ 6 -->
                <details class="group bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300">
                    <summary class="cursor-pointer px-6 py-5 font-bold text-lg text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors flex items-center justify-between" dir="auto">
                        <span class="flex items-center gap-3">
                            <span class="flex-shrink-0 w-8 h-8 bg-orange-100 dark:bg-orange-900/30 rounded-full flex items-center justify-center text-orange-600 dark:text-orange-400 font-bold text-sm">6</span>
                            {{ __('frontend.faq_6_q') }}
                        </span>
                        <svg class="w-5 h-5 text-gray-500 group-open:rotate-180 transition-transform flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </summary>
                    <div class="px-6 pb-6 pt-2 text-gray-700 dark:text-gray-300 leading-relaxed border-t border-gray-100 dark:border-gray-700" dir="auto">
                        <p>{{ __('frontend.faq_6_a') }}</p>
                    </div>
                </details>

                <!-- FAQ 7 -->
                <details class="group bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300">
                    <summary class="cursor-pointer px-6 py-5 font-bold text-lg text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors flex items-center justify-between" dir="auto">
                        <span class="flex items-center gap-3">
                            <span class="flex-shrink-0 w-8 h-8 bg-teal-100 dark:bg-teal-900/30 rounded-full flex items-center justify-center text-teal-600 dark:text-teal-400 font-bold text-sm">7</span>
                            {{ __('frontend.faq_7_q') }}
                        </span>
                        <svg class="w-5 h-5 text-gray-500 group-open:rotate-180 transition-transform flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </summary>
                    <div class="px-6 pb-6 pt-2 text-gray-700 dark:text-gray-300 leading-relaxed border-t border-gray-100 dark:border-gray-700" dir="auto">
                        <p>{{ __('frontend.faq_7_a') }}</p>
                    </div>
                </details>
            </div>

            <!-- Help CTA -->
            <div class="mt-12 text-center">
                <button onclick="showIntercom()" class="inline-flex items-center gap-2 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 px-6 py-4 rounded-xl border border-blue-200 dark:border-blue-800 hover:bg-blue-100 dark:hover:bg-blue-900/30 hover:border-blue-300 dark:hover:border-blue-700 transition-all duration-200 cursor-pointer">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-semibold" dir="auto">{{ __('frontend.still_have_questions') }}</span>
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Results Section -->
<section id="results-section" class="py-20 bg-gray-50 dark:bg-gray-800 hidden">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-700">
                <!-- Results Header -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div dir="auto">
                            <h2 class="text-3xl font-bold text-white">
                                {{ __('frontend.whois_information') }}
                            </h2>
                            <p class="text-blue-100 mt-1">{{ __('frontend.detailed_domain_data') }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Results Content -->
                <div class="p-8 md:p-12">
                    <div id="whois-data" class="space-y-2">
                        <!-- Results will be inserted here by JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Smooth scroll to search form when clicking "Make your Whois search" button
document.addEventListener('DOMContentLoaded', function() {
    const searchButton = document.querySelector('a[href="#whois-form"]');
    if (searchButton) {
        searchButton.addEventListener('click', function(e) {
            e.preventDefault();
            const formSection = document.getElementById('whois-form');
            if (formSection) {
                formSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
                // Focus on input after scroll
                setTimeout(() => {
                    document.getElementById('domain-input').focus();
                }, 600);
            }
        });
    }
});

document.getElementById('whois-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const domain = document.getElementById('domain-input').value.trim();
    const loadingDiv = document.getElementById('loading');
    const errorDiv = document.getElementById('error-message');
    const resultsSection = document.getElementById('results-section');
    const lookupBtn = document.getElementById('lookup-btn');
    
    // Reset states
    loadingDiv.classList.remove('hidden');
    errorDiv.classList.add('hidden');
    resultsSection.classList.add('hidden');
    lookupBtn.disabled = true;
    
    try {
        const response = await fetch('{{ route("domains.whois.lookup") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ domain: domain })
        });
        
        const data = await response.json();
        
        loadingDiv.classList.add('hidden');
        lookupBtn.disabled = false;
        
        if (data.success) {
            displayResults(data.data);
            resultsSection.classList.remove('hidden');
            // Smooth scroll to results
            setTimeout(() => {
                resultsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 100);
        } else {
            showError(data.message || '{{ __('frontend.whois_error') }}');
        }
        
    } catch (error) {
        loadingDiv.classList.add('hidden');
        lookupBtn.disabled = false;
        showError('{{ __('frontend.network_error') }}');
    }
});

function showError(message) {
    const errorDiv = document.getElementById('error-message');
    const errorText = document.getElementById('error-text');
    errorText.textContent = message;
    errorDiv.classList.remove('hidden');
}

function displayResults(data) {
    const whoisDataDiv = document.getElementById('whois-data');
    let html = '';
    
    // Function to create info row
    const createRow = (label, value) => {
        if (!value || value === '' || value === null || value === undefined) return '';
        return `
            <div class="flex flex-col sm:flex-row border-b border-gray-200 dark:border-gray-700 pb-5 mb-5 hover:bg-gray-50 dark:hover:bg-gray-800/50 rounded-lg transition-colors p-4" dir="auto">
                <div class="sm:w-1/3 font-semibold text-gray-700 dark:text-gray-300 mb-2 sm:mb-0 flex items-center gap-2" dir="auto">
                    <svg class="w-2 h-2 text-blue-500 fill-current flex-shrink-0" viewBox="0 0 8 8">
                        <circle cx="4" cy="4" r="4"/>
                    </svg>
                    ${label}
                </div>
                <div class="sm:w-2/3 text-gray-900 dark:text-white break-all" dir="auto">
                    ${Array.isArray(value) ? value.filter(Boolean).map(v => `<span class="inline-block bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-lg mb-1 ${document.dir === 'rtl' ? 'ml-1' : 'mr-1'}">${v}</span>`).join('') : value}
                </div>
            </div>
        `;
    };
    
    // Display domain information
    if (data.DomainInfo) {
        html += '<div class="mb-10"><h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-8 pb-4 border-b-4 border-blue-500 flex items-center gap-3" dir="auto"><svg class="w-8 h-8 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ __('frontend.domain_information') }}</h3>';
        const info = data.DomainInfo;
        html += createRow('{{ __('frontend.domain_name') }}', info.Name);
        html += createRow('{{ __('frontend.registrar') }}', info.Registrar);
        html += createRow('{{ __('frontend.created_date') }}', info.Created);
        html += createRow('{{ __('frontend.expiry_date') }}', info.Expires);
        html += createRow('{{ __('frontend.updated_date') }}', info.Updated);
        html += createRow('{{ __('frontend.status') }}', info.Status);
        
        // Name servers
        if (info.NameServers && info.NameServers.length > 0) {
            html += createRow('{{ __('frontend.name_servers') }}', info.NameServers);
        }
        html += '</div>';
    }
    
    // Display registrant contact
    if (data.RegistrantContact) {
        const contact = data.RegistrantContact;
        const hasContactData = contact.Name || contact.Organization || contact.Email || contact.Phone || 
                              contact.Address1 || contact.City || contact.State || contact.PostalCode || contact.Country;
        
        if (hasContactData) {
            html += '<div class="mb-10"><h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-8 pb-4 border-b-4 border-purple-500 flex items-center gap-3" dir="auto"><svg class="w-8 h-8 text-purple-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>{{ __('frontend.registrant_contact') }}</h3>';
            html += createRow('{{ __('frontend.name') }}', contact.Name);
            html += createRow('{{ __('frontend.organization') }}', contact.Organization);
            html += createRow('{{ __('frontend.email') }}', contact.Email);
            html += createRow('{{ __('frontend.phone') }}', contact.Phone);
            
            const address = [
                contact.Address1,
                contact.Address2,
                contact.City,
                contact.State,
                contact.PostalCode,
                contact.Country
            ].filter(Boolean);
            
            if (address.length > 0) {
                html += createRow('{{ __('frontend.address') }}', address.join(', '));
            }
            html += '</div>';
        }
    }
    
    // Display raw WHOIS data in collapsible section
    if (data.RawData) {
        html += `
            <div class="mt-10">
                <details class="bg-gradient-to-br from-gray-100 to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700">
                    <summary class="cursor-pointer font-bold text-gray-900 dark:text-white text-xl hover:text-blue-600 dark:hover:text-blue-400 p-6 flex items-center gap-3">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                        {{ __('frontend.raw_whois_data') }}
                        <svg class="w-5 h-5 ml-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                    </summary>
                    <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="bg-gray-900 rounded-xl overflow-auto p-6">
                            <pre class="text-sm text-green-400 font-mono whitespace-pre-wrap">${escapeHtml(data.RawData)}</pre>
                        </div>
                    </div>
                </details>
            </div>
        `;
    }
    
    whoisDataDiv.innerHTML = html || '<p class="text-gray-600 dark:text-gray-400 text-center py-8">{{ __('frontend.no_whois_data') }}</p>';
}

function escapeHtml(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, m => map[m]);
}
</script>

@endsection
