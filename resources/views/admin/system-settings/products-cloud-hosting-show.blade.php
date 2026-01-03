@extends('admin.layout')

@section('page-title', $product->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-slate-700 hover:text-purple-600 dark:text-slate-400 dark:hover:text-white">
                    <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                    </svg>
                    {{ __('crm.dashboard') }}
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <a href="{{ route('admin.system-settings.index') }}" class="{{ app()->getLocale() == 'ar' ? 'mr-1 md:mr-2' : 'ml-1 md:ml-2' }} text-sm font-medium text-slate-700 hover:text-purple-600 dark:text-slate-400 dark:hover:text-white">
                        {{ __('crm.system_settings') }}
                    </a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <a href="{{ route('admin.system-settings.products') }}" class="{{ app()->getLocale() == 'ar' ? 'mr-1 md:mr-2' : 'ml-1 md:ml-2' }} text-sm font-medium text-slate-700 hover:text-purple-600 dark:text-slate-400 dark:hover:text-white">
                        {{ __('crm.products_services') }}
                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span class="{{ app()->getLocale() == 'ar' ? 'mr-1 md:mr-2' : 'ml-1 md:ml-2' }} text-sm font-medium text-slate-500 dark:text-slate-400">{{ $product->name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl shadow-lg p-8 mb-8 text-white">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-6">
                <div class="flex-shrink-0 w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold mb-2">{{ $product->name }}</h1>
                    @if($product->tagline)
                        <p class="text-purple-100 text-lg">{{ $product->tagline }}</p>
                    @endif
                    <div class="flex items-center gap-4 mt-3">
                        @if($product->is_active)
                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-green-500/20 text-white border border-green-300/30">
                                {{ __('crm.active') }}
                            </span>
                        @else
                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-red-500/20 text-white border border-red-300/30">
                                {{ __('crm.inactive') }}
                            </span>
                        @endif
                        @if($product->is_featured)
                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-yellow-500/20 text-white border border-yellow-300/30">
                                ⭐ {{ __('crm.featured') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.system-settings.products.cloud-hosting.edit', $product->id) }}" class="flex items-center gap-2 px-5 py-3 bg-white/20 hover:bg-white/30 text-white rounded-lg transition-colors backdrop-blur-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    <span>{{ __('crm.edit') }}</span>
                </a>
                <a href="{{ route('admin.system-settings.products') }}" class="flex items-center gap-2 px-5 py-3 bg-white/20 hover:bg-white/30 text-white rounded-lg transition-colors backdrop-blur-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>{{ __('crm.back') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Pricing Information -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800 px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ __('crm.pricing_information') }}
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Base Price -->
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-900/10 rounded-lg p-6 border border-purple-200 dark:border-purple-800">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-slate-600 dark:text-slate-400">{{ __('crm.base_price') }}</p>
                                    <p class="text-3xl font-bold text-purple-700 dark:text-purple-400">${{ number_format($product->price, 2) }}</p>
                                </div>
                            </div>
                            <div class="pt-3 border-t border-purple-200 dark:border-purple-800">
                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-purple-600 text-white">
                                    {{ ucfirst(str_replace('_', ' ', $product->payment_type)) }}
                                </span>
                            </div>
                        </div>

                        <!-- Payment Type Details -->
                        <div class="space-y-4">
                            @if($product->pricing && is_array($product->pricing))
                                @php
                                    $pricingData = [];
                                    
                                    // Handle one_time pricing
                                    if (isset($product->pricing['one_time']) && is_array($product->pricing['one_time']) && isset($product->pricing['one_time']['price']) && $product->pricing['one_time']['price'] > 0) {
                                        $pricingData['one_time'] = [
                                            'price' => $product->pricing['one_time']['price'],
                                            'setup_fee' => $product->pricing['one_time']['setup_fee'] ?? 0
                                        ];
                                    }
                                    
                                    // Handle recurring pricing
                                    if (isset($product->pricing['recurring']) && is_array($product->pricing['recurring'])) {
                                        foreach ($product->pricing['recurring'] as $cycle => $data) {
                                            if (is_array($data) && isset($data['price']) && $data['price'] > 0) {
                                                $pricingData[$cycle] = [
                                                    'price' => $data['price'],
                                                    'setup_fee' => $data['setup_fee'] ?? 0
                                                ];
                                            }
                                        }
                                    }
                                @endphp
                                
                                @foreach($pricingData as $cycle => $data)
                                    <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-900/50 rounded-lg border border-slate-200 dark:border-slate-700">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">
                                                    {{ ucfirst(str_replace('_', ' ', $cycle)) }}
                                                </span>
                                                @if($data['setup_fee'] > 0)
                                                    <span class="block text-xs text-slate-500 dark:text-slate-400">
                                                        {{ __('crm.setup_fee') }}: ${{ number_format($data['setup_fee'], 2) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <span class="text-lg font-bold text-slate-900 dark:text-white">
                                            ${{ number_format($data['price'], 2) }}
                                        </span>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            @if($product->description)
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800 px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        {{ __('crm.description') }}
                    </h2>
                </div>
                <div class="p-6">
                    <div class="prose prose-slate dark:prose-invert max-w-none">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                </div>
            </div>
            @endif

            <!-- Features (English) -->
            @php
                $featuresList = [];
                if ($product->features && is_array($product->features) && count($product->features) > 0) {
                    $featuresList = $product->features;
                } elseif ($product->features_list) {
                    // features_list is already an array thanks to Accessor
                    if (is_array($product->features_list)) {
                        $featuresList = $product->features_list;
                    } else {
                        // Fallback: split by line breaks if it's still a string
                        $featuresList = array_filter(array_map('trim', explode("\n", $product->features_list)));
                    }
                }
            @endphp
            
            @if(count($featuresList) > 0)
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800 px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ __('crm.features') }} (English)
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($featuresList as $feature)
                            <div class="flex items-start gap-3 p-4 bg-slate-50 dark:bg-slate-900/50 rounded-lg border border-slate-200 dark:border-slate-700">
                                <div class="flex-shrink-0 w-6 h-6 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mt-0.5">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <span class="text-slate-700 dark:text-slate-300">{{ $feature }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Features (Arabic) -->
            @php
                $featuresListAr = [];
                if ($product->features_list_ar) {
                    // features_list_ar is already an array thanks to Accessor
                    if (is_array($product->features_list_ar)) {
                        $featuresListAr = $product->features_list_ar;
                    } else {
                        // Fallback: split by line breaks if it's still a string
                        $featuresListAr = array_filter(array_map('trim', explode("\n", $product->features_list_ar)));
                    }
                }
            @endphp
            
            @if(count($featuresListAr) > 0)
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800 px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ __('crm.features') }} (العربية)
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($featuresListAr as $feature)
                            <div class="flex items-start gap-3 p-4 bg-slate-50 dark:bg-slate-900/50 rounded-lg border border-slate-200 dark:border-slate-700" dir="rtl">
                                <div class="flex-shrink-0 w-6 h-6 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mt-0.5">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <span class="text-slate-700 dark:text-slate-300">{{ $feature }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Datacenter Locations -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800 px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <h2 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ __('crm.datacenter_locations') }}
                        </h2>
                        @if($product->datacenter_locations && is_array($product->datacenter_locations) && count($product->datacenter_locations) > 0)
                            <span class="inline-flex items-center gap-2 px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400 rounded-lg text-sm font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ count($product->datacenter_locations) }} {{ __('crm.locations_available') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="p-6">
                @if($product->datacenter_locations && is_array($product->datacenter_locations) && count($product->datacenter_locations) > 0)
                    @php
                        $datacenterPrices = $product->datacenter_price ?? [];
                        $locationMap = [
                            'us-east' => ['flag' => 'us', 'name' => __('crm.us_east')],
                            'us-west' => ['flag' => 'us', 'name' => __('crm.us_west')],
                            'us-central' => ['flag' => 'us', 'name' => __('crm.us_central')],
                            'canada' => ['flag' => 'ca', 'name' => __('crm.canada')],
                            'south-america' => ['flag' => 'br', 'name' => __('crm.south_america')],
                            'eu-west' => ['flag' => 'eu', 'name' => __('crm.eu_west')],
                            'eu-central' => ['flag' => 'eu', 'name' => __('crm.eu_central')],
                            'eu-north' => ['flag' => 'eu', 'name' => __('crm.eu_north')],
                            'asia-east' => ['flag' => 'cn', 'name' => __('crm.asia_east')],
                            'asia-south' => ['flag' => 'in', 'name' => __('crm.asia_south')],
                            'asia-pacific' => ['flag' => 'sg', 'name' => __('crm.asia_pacific')],
                            'australia' => ['flag' => 'au', 'name' => __('crm.australia')],
                            'uae' => ['flag' => 'ae', 'name' => __('crm.uae')],
                            'saudi-arabia' => ['flag' => 'sa', 'name' => __('crm.saudi_arabia')],
                            'egypt' => ['flag' => 'eg', 'name' => __('crm.egypt')],
                            'jordan' => ['flag' => 'jo', 'name' => __('crm.jordan')],
                            'bahrain' => ['flag' => 'bh', 'name' => __('crm.bahrain')],
                            'kuwait' => ['flag' => 'kw', 'name' => __('crm.kuwait')],
                            'africa' => ['flag' => 'za', 'name' => __('crm.africa')],
                        ];
                    @endphp
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($product->datacenter_locations as $location)
                            @if(isset($locationMap[$location]))
                                <div class="p-4 bg-slate-50 dark:bg-slate-900/50 rounded-lg border border-slate-200 dark:border-slate-700 hover:border-purple-300 dark:hover:border-purple-600 hover:shadow-md transition-all">
                                    <div class="flex items-center gap-3 mb-3">
                                        <span class="fi fi-{{ $locationMap[$location]['flag'] }} text-3xl flex-shrink-0"></span>
                                        <span class="text-sm font-semibold text-slate-900 dark:text-white">
                                            {{ $locationMap[$location]['name'] }}
                                        </span>
                                    </div>
                                    <div class="flex justify-end">
                                        @if(isset($datacenterPrices[$location]) && $datacenterPrices[$location] > 0)
                                            <span class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-bold bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-lg">
                                                <span>+</span>
                                                <span>${{ number_format($datacenterPrices[$location], 2) }}</span>
                                            </span>
                                        @else
                                            <span class="inline-flex px-3 py-1.5 text-xs font-semibold bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400 rounded-lg">
                                                {{ __('crm.included') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <!-- No Datacenters Selected -->
                    <div class="text-center py-8">
                        <div class="flex flex-col items-center">
                            <svg class="w-16 h-16 text-slate-400 dark:text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-slate-500 dark:text-slate-400 mb-4">{{ __('crm.no_datacenters_selected') }}</p>
                            <a href="{{ route('admin.system-settings.products.cloud-hosting.edit', $product->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                <span>{{ __('crm.add_datacenters') }}</span>
                            </a>
                        </div>
                    </div>
                @endif
                </div>
            </div>

        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            
            <!-- Quick Stats -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800 px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">{{ __('crm.quick_info') }}</h3>
                </div>
                <div class="p-6 space-y-4">
                    
                    <!-- Product Type -->
                    <div class="flex items-center justify-between pb-4 border-b border-slate-200 dark:border-slate-700">
                        <span class="text-sm text-slate-600 dark:text-slate-400">{{ __('crm.type') }}</span>
                        <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300">
                            {{ __('crm.cloud_hosting') }}
                        </span>
                    </div>

                    <!-- Status -->
                    <div class="flex items-center justify-between pb-4 border-b border-slate-200 dark:border-slate-700">
                        <span class="text-sm text-slate-600 dark:text-slate-400">{{ __('crm.status') }}</span>
                        @if($product->is_active)
                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                {{ __('crm.active') }}
                            </span>
                        @else
                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300">
                                {{ __('crm.inactive') }}
                            </span>
                        @endif
                    </div>

                    <!-- Payment Type -->
                    <div class="flex items-center justify-between pb-4 border-b border-slate-200 dark:border-slate-700">
                        <span class="text-sm text-slate-600 dark:text-slate-400">{{ __('crm.payment_type') }}</span>
                        <span class="text-sm font-medium text-slate-900 dark:text-white">
                            {{ ucfirst(str_replace('_', ' ', $product->payment_type)) }}
                        </span>
                    </div>

                    <!-- Require Domain -->
                    <div class="flex items-center justify-between pb-4 border-b border-slate-200 dark:border-slate-700">
                        <span class="text-sm text-slate-600 dark:text-slate-400">{{ __('crm.require_domain') }}</span>
                        @if($product->require_domain)
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                {{ __('crm.yes') }}
                            </span>
                        @else
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded bg-slate-100 dark:bg-slate-900/30 text-slate-800 dark:text-slate-300">
                                {{ __('crm.no') }}
                            </span>
                        @endif
                    </div>

                    <!-- Auto Setup -->
                    <div class="flex items-center justify-between pb-4 border-b border-slate-200 dark:border-slate-700">
                        <span class="text-sm text-slate-600 dark:text-slate-400">{{ __('crm.auto_setup') }}</span>
                        <span class="text-sm font-medium text-slate-900 dark:text-white">
                            {{ ucfirst(str_replace('_', ' ', $product->auto_setup)) }}
                        </span>
                    </div>

                    <!-- Server -->
                    @if($product->server)
                    <div class="flex items-center justify-between pb-4 border-b border-slate-200 dark:border-slate-700">
                        <span class="text-sm text-slate-600 dark:text-slate-400">{{ __('crm.server') }}</span>
                        <span class="text-sm font-medium text-slate-900 dark:text-white">
                            {{ $product->server->name }}
                        </span>
                    </div>
                    @endif

                    <!-- Created At -->
                    <div class="flex items-center justify-between pb-4 border-b border-slate-200 dark:border-slate-700">
                        <span class="text-sm text-slate-600 dark:text-slate-400">{{ __('crm.created_at') }}</span>
                        <span class="text-sm text-slate-900 dark:text-white">
                            {{ $product->created_at->format('Y-m-d') }}
                        </span>
                    </div>

                    <!-- Updated At -->
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-600 dark:text-slate-400">{{ __('crm.updated_at') }}</span>
                        <span class="text-sm text-slate-900 dark:text-white">
                            {{ $product->updated_at->format('Y-m-d') }}
                        </span>
                    </div>

                </div>
            </div>

            <!-- Actions Card -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800 px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">{{ __('crm.actions') }}</h3>
                </div>
                <div class="p-6 space-y-3">
                    <a href="{{ route('admin.system-settings.products.cloud-hosting.edit', $product->id) }}" class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        <span>{{ __('crm.edit_product') }}</span>
                    </a>
                    
                    <form action="{{ route('admin.system-settings.products.cloud-hosting.destroy', $product->id) }}" method="POST" onsubmit="return confirm('{{ app()->getLocale() == 'ar' ? 'هل أنت متأكد من حذف هذه الخطة؟ لا يمكن التراجع عن هذا الإجراء.' : 'Are you sure you want to delete this plan? This action cannot be undone.' }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            <span>{{ __('crm.delete_product') }}</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Free Domain Config -->
            @if($product->free_domain_config && is_array($product->free_domain_config))
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800 px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                        </svg>
                        {{ __('crm.free_domain') }}
                    </h3>
                </div>
                <div class="p-6 space-y-3">
                    @php
                        $freeDomainEnabled = isset($product->free_domain_config['type']) && 
                                           !empty($product->free_domain_config['type']) && 
                                           $product->free_domain_config['type'] !== 'none';
                    @endphp
                    
                    @if($freeDomainEnabled)
                        <div class="flex items-center gap-2 text-green-600 dark:text-green-400 mb-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="font-medium">{{ __('crm.enabled') }}</span>
                        </div>
                        
                        <!-- Free Domain Type -->
                        @if(isset($product->free_domain_config['type']))
                        <div class="pb-3 border-b border-slate-200 dark:border-slate-700">
                            <p class="text-xs text-slate-600 dark:text-slate-400 mb-2">{{ __('crm.free_domain_type') }}:</p>
                            <span class="inline-flex px-3 py-1 text-sm font-medium bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400 rounded">
                                @if($product->free_domain_config['type'] === 'reg_only')
                                    {{ __('crm.registration_only') }}
                                @elseif($product->free_domain_config['type'] === 'transfer_only')
                                    {{ __('crm.transfer_only') }}
                                @elseif($product->free_domain_config['type'] === 'reg_transfer')
                                    {{ __('crm.registration_and_transfer') }}
                                @else
                                    {{ ucfirst(str_replace('_', ' ', $product->free_domain_config['type'])) }}
                                @endif
                            </span>
                        </div>
                        @endif
                        
                        <!-- Free Domain Terms -->
                        @if(isset($product->free_domain_config['terms']) && is_array($product->free_domain_config['terms']) && count($product->free_domain_config['terms']) > 0)
                        <div class="pb-3 border-b border-slate-200 dark:border-slate-700">
                            <p class="text-xs text-slate-600 dark:text-slate-400 mb-2">{{ __('crm.applicable_billing_cycles') }}:</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($product->free_domain_config['terms'] as $term)
                                    <span class="inline-flex px-2 py-1 text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded">
                                        {{ ucfirst(str_replace('_', ' ', $term)) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        
                        <!-- Available TLDs -->
                        @if(isset($product->free_domain_config['tlds']) && is_array($product->free_domain_config['tlds']) && count($product->free_domain_config['tlds']) > 0)
                            <div>
                                <p class="text-xs text-slate-600 dark:text-slate-400 mb-2">{{ __('crm.available_tlds') }}:</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($product->free_domain_config['tlds'] as $tld)
                                        <span class="inline-flex px-2 py-1 text-xs font-medium bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400 rounded">
                                            .{{ $tld }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="flex items-center gap-2 text-slate-600 dark:text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            <span>{{ __('crm.not_enabled') }}</span>
                        </div>
                    @endif
                </div>
            </div>
            @endif

        </div>

    </div>

</div>
@endsection
