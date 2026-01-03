@extends('frontend.layout')

@section('title', __('frontend.shared_hosting') . ' - Pro Gineous')

@section('content')

<!-- Hero Section -->
<section class="relative bg-white dark:bg-gray-900 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
        <div class="lg:grid lg:grid-cols-12 lg:gap-8 items-center">
            <!-- Content -->
            <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white sm:text-5xl md:text-6xl" dir="auto">
                    <span class="block">{{ __('frontend.shared_hosting') }}</span>
                    <span class="block text-blue-600">{{ __('frontend.powerful_reliable') }}</span>
                </h1>
                <p class="mt-3 text-base text-gray-500 dark:text-gray-400 sm:mt-5 sm:text-xl lg:text-lg xl:text-xl" dir="auto">
                    {{ __('frontend.shared_hosting_description') }}
                </p>
                
                <div class="mt-8 sm:max-w-lg sm:mx-auto sm:text-center lg:text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} lg:mx-0">
                    <a href="#plans" class="inline-block px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 md:text-lg md:px-10">
                        {{ __('frontend.view_plans') }}
                    </a>
                </div>
            </div>
            
            <!-- Image -->
            <div class="mt-12 lg:mt-0 lg:col-span-6">
                <div class="relative mx-auto w-full rounded-lg shadow-lg lg:max-w-md">
                    <div class="relative block w-full bg-white dark:bg-gray-800 rounded-lg overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                    <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                    <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                </div>
                                <span class="text-xs text-gray-500 dark:text-gray-400">cPanel</span>
                            </div>
                            <div class="space-y-3">
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-3/4"></div>
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded"></div>
                                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-5/6"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-16 bg-gray-50 dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl" dir="auto">
                {{ __('frontend.key_features') }}
            </h2>
            <p class="mt-4 text-lg text-gray-500 dark:text-gray-400" dir="auto">
                {{ __('frontend.everything_you_need') }}
            </p>
        </div>

        <div class="mt-12 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Feature 1 -->
            <div class="text-center">
                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white mx-auto">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white" dir="auto">{{ __('frontend.unlimited_storage') }}</h3>
                <p class="mt-2 text-base text-gray-500 dark:text-gray-400" dir="auto">{{ __('frontend.ssd_storage') }}</p>
            </div>

            <!-- Feature 2 -->
            <div class="text-center">
                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white mx-auto">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white" dir="auto">{{ __('frontend.free_ssl') }}</h3>
                <p class="mt-2 text-base text-gray-500 dark:text-gray-400" dir="auto">{{ __('frontend.ssl_included') }}</p>
            </div>

            <!-- Feature 3 -->
            <div class="text-center">
                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white mx-auto">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white" dir="auto">{{ __('frontend.high_speed') }}</h3>
                <p class="mt-2 text-base text-gray-500 dark:text-gray-400" dir="auto">{{ __('frontend.fast_performance') }}</p>
            </div>

            <!-- Feature 4 -->
            <div class="text-center">
                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white mx-auto">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white" dir="auto">{{ __('frontend.support_247') }}</h3>
                <p class="mt-2 text-base text-gray-500 dark:text-gray-400" dir="auto">{{ __('frontend.expert_support') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Pricing Plans -->
<section id="plans" class="py-16 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl" dir="auto">
                {{ __('frontend.choose_your_plan') }}
            </h2>
            <p class="mt-4 text-lg text-gray-500 dark:text-gray-400" dir="auto">
                {{ __('frontend.flexible_pricing') }}
            </p>
        </div>

        <!-- Billing Period Selector -->
        <div class="mt-8 flex justify-center">
            <select id="billingPeriod" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                <option value="monthly">{{ __('frontend.monthly') }}</option>
                <option value="quarterly">{{ __('frontend.quarterly') }} - {{ __('frontend.save') }} 5%</option>
                <option value="semiannually">{{ __('frontend.semi_annually') }} - {{ __('frontend.save') }} 10%</option>
                <option value="annually" selected>{{ __('frontend.annually') }} - {{ __('frontend.save') }} 15%</option>
                <option value="biennially">{{ __('frontend.biennially') }} - {{ __('frontend.save') }} 20%</option>
                <option value="triennially">{{ __('frontend.triennially') }} - {{ __('frontend.save') }} 25%</option>
            </select>
        </div>

        <!-- Plans Grid -->
        @if($plans->count() > 0)
        <div class="mt-12 space-y-4 sm:mt-16 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-6 lg:max-w-4xl lg:mx-auto xl:max-w-none xl:mx-0 xl:grid-cols-{{ $plans->count() > 3 ? '4' : $plans->count() }}">
            @foreach($plans as $index => $plan)
            @php
                $isPopular = $index == 1 && $plans->count() >= 3;
                $currentLocale = app()->getLocale();
                
                if ($currentLocale === 'ar' && $plan->features_list_ar) {
                    $features = is_array($plan->features_list_ar) ? $plan->features_list_ar : array_filter(array_map('trim', explode("\n", $plan->features_list_ar)));
                } elseif ($plan->features) {
                    $features = is_array($plan->features) ? $plan->features : json_decode($plan->features, true);
                } elseif ($plan->features_list) {
                    $features = is_array($plan->features_list) ? $plan->features_list : array_filter(array_map('trim', explode("\n", $plan->features_list)));
                } else {
                    $features = [];
                }
            @endphp
            
            <div class="border {{ $isPopular ? 'border-blue-600 shadow-lg' : 'border-gray-200 dark:border-gray-700' }} rounded-lg divide-y divide-gray-200 dark:divide-gray-700 relative">
                @if($isPopular)
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                    <span class="bg-blue-600 text-white px-3 py-1 text-sm font-semibold rounded-full">
                        {{ __('frontend.most_popular') }}
                    </span>
                </div>
                @endif
                
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white" dir="auto">{{ $plan->name }}</h3>
                    @if($plan->tagline)
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400" dir="auto">{{ $plan->tagline }}</p>
                    @endif
                    
                    <p class="mt-4">
                        <span class="text-4xl font-extrabold text-gray-900 dark:text-white" data-monthly-price="{{ $plan->price }}">
                            ${{ number_format($plan->price, 2) }}
                        </span>
                        <span class="text-base font-medium text-gray-500 dark:text-gray-400">
                            /{{ __('frontend.month') }}
                        </span>
                    </p>
                    
                    <a href="{{ route('order.configure', ['type' => 'shared', 'id' => $plan->id]) }}" 
                       class="mt-6 block w-full text-center px-4 py-2 border border-transparent rounded-md {{ $isPopular ? 'bg-blue-600 text-white hover:bg-blue-700' : 'bg-gray-100 text-gray-900 hover:bg-gray-200 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700' }}">
                        {{ __('frontend.order_now') }}
                    </a>
                </div>
                
                <div class="px-6 pt-6 pb-8">
                    <h4 class="text-sm font-medium text-gray-900 dark:text-white tracking-wide uppercase" dir="auto">
                        {{ __('frontend.whats_included') }}
                    </h4>
                    <ul class="mt-4 space-y-3">
                        @foreach($features as $feature)
                        <li class="flex space-x-3 rtl:space-x-reverse">
                            <svg class="flex-shrink-0 h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm text-gray-700 dark:text-gray-300" dir="auto">{{ is_array($feature) ? $feature['name'] ?? $feature['text'] ?? '' : $feature }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="mt-12 text-center">
            <p class="text-gray-500 dark:text-gray-400" dir="auto">{{ __('frontend.no_plans_available') }}</p>
        </div>
        @endif
    </div>
</section>

@push('scripts')
<script>
document.getElementById('billingPeriod').addEventListener('change', function() {
    const period = this.value;
    const discounts = {
        'monthly': 0,
        'quarterly': 0.05,
        'semiannually': 0.10,
        'annually': 0.15,
        'biennially': 0.20,
        'triennially': 0.25
    };
    
    document.querySelectorAll('[data-monthly-price]').forEach(el => {
        const monthlyPrice = parseFloat(el.dataset.monthlyPrice);
        const discount = discounts[period];
        const finalPrice = monthlyPrice * (1 - discount);
        el.textContent = '$' + finalPrice.toFixed(2);
    });
});
</script>
@endpush

@endsection
