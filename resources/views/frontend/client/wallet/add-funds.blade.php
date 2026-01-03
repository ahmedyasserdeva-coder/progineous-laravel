@extends('frontend.client.layout')

@section('title', app()->getLocale() == 'ar' ? 'إضافة رصيد - Pro Gineous' : 'Add Funds - Pro Gineous')

@section('content')
<!-- Background Gradient -->
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">
<div class="container mx-auto px-4 py-8">
    <!-- Page Header with Animation -->
    <div class="mb-8 animate-fade-in">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-3">
                    <div class="p-3 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl shadow-lg shadow-blue-500/30">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold bg-gradient-to-r from-slate-900 via-blue-800 to-indigo-900 dark:from-white dark:via-blue-200 dark:to-indigo-200 bg-clip-text text-transparent">
                            {{ app()->getLocale() == 'ar' ? 'إضافة رصيد' : 'Add Funds' }}
                        </h1>
                        <p class="text-slate-600 dark:text-slate-400 mt-1 text-sm">
                            {{ app()->getLocale() == 'ar' ? 'أضف رصيد إلى محفظتك لاستخدامه في الدفعات المستقبلية' : 'Add balance to your wallet for future payments' }}
                        </p>
                    </div>
                </div>
            </div>
            <a href="{{ route('client.wallet') }}" class="btn-back group">
                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} group-hover:{{ app()->getLocale() == 'ar' ? 'translate-x-1' : '-translate-x-1' }} transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ app()->getLocale() == 'ar' ? 'العودة للمحفظة' : 'Back to Wallet' }}
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border-2 border-green-300 dark:border-green-700 rounded-xl flex items-start gap-3 animate-fade-in shadow-lg shadow-green-500/20">
            <svg class="w-6 h-6 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm font-medium text-green-700 dark:text-green-300">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Error Message -->
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border-2 border-red-300 dark:border-red-700 rounded-xl flex items-start gap-3 animate-fade-in shadow-lg shadow-red-500/20">
            <svg class="w-6 h-6 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm font-medium text-red-700 dark:text-red-300">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Info Message -->
    @if(session('info'))
        <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 border-2 border-blue-300 dark:border-blue-700 rounded-xl flex items-start gap-3 animate-fade-in shadow-lg shadow-blue-500/20">
            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm font-medium text-blue-700 dark:text-blue-300">{{ session('info') }}</p>
        </div>
    @endif

    <!-- Validation Error Messages -->
    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border-2 border-red-300 dark:border-red-700 rounded-xl animate-fade-in shadow-lg shadow-red-500/20">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div class="flex-1">
                    @foreach($errors->all() as $error)
                        <p class="text-sm font-medium text-red-700 dark:text-red-300 mb-1 last:mb-0">• {{ $error }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 animate-slide-up">
        <!-- Add Funds Form -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Amount Selection Card -->
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-3xl shadow-2xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-200/50 dark:border-slate-700/50 p-6 md:p-8 hover:shadow-3xl transition-all duration-300">
                <form method="POST" action="{{ route('client.wallet.store-funds') }}" id="add-funds-form">
                    @csrf

                    <!-- Amount Selection -->
                    <div class="mb-8">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="p-2 bg-gradient-to-br from-blue-100 to-indigo-100 dark:from-blue-900/30 dark:to-indigo-900/30 rounded-xl">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <label class="text-lg font-bold text-slate-800 dark:text-slate-200">
                                {{ app()->getLocale() == 'ar' ? 'اختر المبلغ' : 'Select Amount' }}
                            </label>
                        </div>
                        
                        <!-- Predefined Amounts with Enhanced Design -->
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-6">
                            @foreach($predefinedAmounts as $amount)
                                <button type="button" 
                                        onclick="selectAmount({{ $amount }})"
                                        class="amount-btn group relative overflow-hidden px-5 py-4 bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-700/50 dark:to-slate-800/50 border-2 border-slate-200 dark:border-slate-600 rounded-2xl hover:border-blue-500 dark:hover:border-blue-400 hover:shadow-lg hover:shadow-blue-500/20 transition-all duration-300 hover:-translate-y-1">
                                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/0 to-indigo-500/0 group-hover:from-blue-500/10 group-hover:to-indigo-500/10 transition-all duration-300"></div>
                                    <div class="relative">
                                        <div class="text-2xl font-bold text-slate-800 dark:text-slate-200 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                            ${{ number_format($amount) }}
                                        </div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ $client->currency }}</div>
                                    </div>
                                    <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </button>
                            @endforeach
                        </div>

                        <!-- Custom Amount with Enhanced Design -->
                        <div class="relative group">
                            <label class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-2">
                                {{ app()->getLocale() == 'ar' ? 'أو أدخل مبلغاً مخصصاً' : 'Or enter custom amount' }}
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'right-0 pr-5' : 'left-0 pl-5' }} flex items-center pointer-events-none z-10">
                                    <span class="text-2xl font-bold text-slate-400 dark:text-slate-500">$</span>
                                </div>
                                <input type="number" 
                                       id="amount" 
                                       name="amount" 
                                       value="{{ old('amount') }}"
                                       min="10" 
                                       max="100000" 
                                       step="1"
                                       required
                                       class="w-full {{ app()->getLocale() == 'ar' ? 'pr-20 pl-5' : 'pl-20 pr-5' }} py-5 rounded-2xl border-2 border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-4 focus:ring-blue-500/20 focus:shadow-lg focus:shadow-blue-500/20 transition-all duration-300 text-2xl font-bold"
                                       placeholder="0.00"
                                       oninput="updateSummary()">
                                <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-0 pl-5' : 'right-0 pr-5' }} flex items-center pointer-events-none">
                                    <span class="text-sm font-semibold text-slate-400 dark:text-slate-500">{{ $client->currency }}</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-3">
                                <p class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ app()->getLocale() == 'ar' ? 'الحد الأدنى: $10' : 'Min: $10' }}
                                </p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    {{ app()->getLocale() == 'ar' ? 'الحد الأقصى: $100,000' : 'Max: $100,000' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Methods -->
                    <div class="mb-8">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="p-2 bg-gradient-to-br from-emerald-100 to-teal-100 dark:from-emerald-900/30 dark:to-teal-900/30 rounded-xl">
                                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                            </div>
                            <label class="text-lg font-bold text-slate-800 dark:text-slate-200">
                                {{ app()->getLocale() == 'ar' ? 'اختر طريقة الدفع' : 'Choose Payment Method' }}
                            </label>
                        </div>
                        
                        <!-- Fawaterak Payment Methods -->
                        @if(isset($fawaterakPaymentMethods) && count($fawaterakPaymentMethods) > 0)
                            <div class="mb-6">
                                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-3">
                                    @foreach($fawaterakPaymentMethods as $method)
                                        <label class="payment-method-card relative group cursor-pointer">
                                            <input type="radio" 
                                                   name="payment_method" 
                                                   value="fawaterak_{{ $method['paymentId'] }}" 
                                                   data-fawaterak-id="{{ $method['paymentId'] }}"
                                                   class="peer sr-only"
                                                   required>
                                            <div class="relative flex flex-col items-center justify-center p-4 bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-600 rounded-xl hover:border-blue-500 dark:hover:border-blue-400 hover:shadow-lg hover:shadow-blue-500/10 peer-checked:border-blue-600 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 peer-checked:shadow-lg peer-checked:shadow-blue-500/30 transition-all duration-300 hover:-translate-y-1 min-h-[120px]">
                                                @if(isset($method['logo']) && $method['logo'])
                                                    <div class="w-16 h-16 mb-3 bg-white dark:bg-slate-700 rounded-lg p-2 flex items-center justify-center border border-slate-100 dark:border-slate-600 group-hover:scale-110 transition-transform duration-300">
                                                        <img src="{{ $method['logo'] }}" 
                                                             alt="{{ app()->getLocale() == 'ar' ? $method['name_ar'] : $method['name_en'] }}" 
                                                             class="max-w-full max-h-full object-contain"
                                                             loading="lazy">
                                                    </div>
                                                @else
                                                    <div class="w-16 h-16 mb-3 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                                        </svg>
                                                    </div>
                                                @endif
                                                <div class="text-center w-full px-2">
                                                    <span class="text-xs font-bold text-slate-900 dark:text-white block leading-tight line-clamp-2">
                                                        {{ app()->getLocale() == 'ar' ? $method['name_ar'] : $method['name_en'] }}
                                                    </span>
                                                </div>
                                                <!-- Selected Checkmark -->
                                                <div class="absolute top-2 right-2 w-6 h-6 bg-blue-600 rounded-full items-center justify-center hidden peer-checked:flex">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Additional Payment Methods -->
                        @if(isset($additionalPaymentMethods) && count($additionalPaymentMethods) > 0)
                            <div class="mb-4">
                                <h4 class="text-sm font-semibold text-slate-600 dark:text-slate-400 mb-3 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ app()->getLocale() == 'ar' ? 'طرق دفع أخرى' : 'Other Payment Methods' }}
                                </h4>
                                <div class="space-y-3">
                                    @foreach($additionalPaymentMethods as $method)
                                        <label class="payment-method-card relative flex items-center p-5 border-2 border-slate-200 dark:border-slate-600 rounded-2xl cursor-pointer hover:border-blue-500 dark:hover:border-blue-400 hover:shadow-lg hover:shadow-blue-500/10 transition-all duration-300 group {{ !$method['enabled'] ? 'opacity-50 cursor-not-allowed' : 'hover:-translate-y-0.5' }}">
                                            <input type="radio" 
                                                   name="payment_method" 
                                                   value="{{ $method['id'] }}" 
                                                   class="w-5 h-5 text-blue-600 focus:ring-blue-500 focus:ring-2 {{ app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4' }}"
                                                   {{ !$method['enabled'] ? 'disabled' : '' }}
                                                   required>
                                            <div class="flex-1">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center gap-3">
                                                        <span class="text-3xl">{{ $method['icon'] }}</span>
                                                        <div>
                                                            <span class="font-bold text-slate-900 dark:text-white block">{{ $method['name'] }}</span>
                                                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-0.5">{{ $method['description'] }}</p>
                                                        </div>
                                                    </div>
                                                    @if(!$method['enabled'])
                                                        <span class="text-xs px-3 py-1.5 bg-gradient-to-r from-slate-200 to-slate-300 dark:from-slate-700 dark:to-slate-600 text-slate-700 dark:text-slate-300 rounded-full font-semibold">
                                                            {{ app()->getLocale() == 'ar' ? 'قريباً' : 'Coming Soon' }}
                                                        </span>
                                                    @else
                                                        <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                                                            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="absolute inset-0 bg-gradient-to-r from-blue-500/0 to-indigo-500/0 group-hover:from-blue-500/5 group-hover:to-indigo-500/5 rounded-2xl transition-all duration-300 pointer-events-none"></div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Submit Button with Enhanced Design -->
                    <button type="submit" 
                            class="group relative w-full px-8 py-5 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 hover:from-blue-700 hover:via-indigo-700 hover:to-purple-700 text-white font-bold text-lg rounded-2xl shadow-2xl shadow-blue-500/40 hover:shadow-3xl hover:shadow-blue-500/60 transition-all duration-300 transform hover:-translate-y-1 hover:scale-[1.02] active:scale-[0.98] overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></div>
                        <span class="relative flex items-center justify-center gap-3">
                            <svg class="w-6 h-6 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <span>{{ app()->getLocale() == 'ar' ? 'متابعة للدفع' : 'Continue to Payment' }}</span>
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </span>
                    </button>

                    <!-- Security Badge -->
                    <div class="mt-4 flex items-center justify-center gap-2 text-sm text-slate-500 dark:text-slate-400">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <span>{{ app()->getLocale() == 'ar' ? 'معاملة آمنة ومشفرة' : 'Secure & Encrypted Transaction' }}</span>
                    </div>
                </form>
            </div>
        </div>

        <!-- Enhanced Summary Sidebar -->
        <div class="lg:col-span-1">
            <div class="sticky top-24 space-y-4">
                <!-- Summary Card -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-3xl shadow-2xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-200/50 dark:border-slate-700/50 p-6 hover:shadow-3xl transition-all duration-300">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2.5 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl shadow-lg shadow-purple-500/30">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">
                            {{ app()->getLocale() == 'ar' ? 'ملخص الإضافة' : 'Order Summary' }}
                        </h3>
                    </div>

                    <div class="space-y-4">
                        <!-- Amount -->
                        <div class="flex items-start justify-between gap-3 pb-4 border-b-2 border-dashed border-slate-200 dark:border-slate-700">
                            <span class="text-sm font-medium text-slate-600 dark:text-slate-400 flex items-center gap-2 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ app()->getLocale() == 'ar' ? 'المبلغ' : 'Amount' }}
                            </span>
                            <span id="summary-amount" class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white break-words text-right flex-1 min-w-0">
                                $0.00
                            </span>
                        </div>

                        <!-- Fees -->
                        <div class="flex items-center justify-between pb-4 border-b-2 border-dashed border-slate-200 dark:border-slate-700">
                            <span class="text-sm font-medium text-slate-600 dark:text-slate-400 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                {{ app()->getLocale() == 'ar' ? 'رسوم المعاملة' : 'Transaction Fees' }}
                            </span>
                            <span class="flex items-center gap-1.5 text-sm font-bold text-emerald-600 dark:text-emerald-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ app()->getLocale() == 'ar' ? 'مجاناً' : 'Free' }}
                            </span>
                        </div>

                        <!-- Total with Animation -->
                        <div class="pt-2 pb-4">
                            <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl text-center">
                                <div class="flex items-center justify-center gap-2 mb-3">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                    </svg>
                                    <span class="text-base font-bold text-slate-900 dark:text-white">
                                        {{ app()->getLocale() == 'ar' ? 'الإجمالي' : 'Total Amount' }}
                                    </span>
                                </div>
                                <span id="summary-total" class="block text-3xl sm:text-4xl font-black bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent break-words">
                                    $0.00
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Cards -->
                <div class="space-y-3">
                    <!-- Security Info -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 backdrop-blur-xl rounded-2xl p-4 border border-blue-200/50 dark:border-blue-800/50">
                        <div class="flex items-start gap-3">
                            <div class="p-2 bg-blue-500 rounded-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs text-blue-800 dark:text-blue-200 font-medium leading-relaxed">
                                    {{ app()->getLocale() == 'ar' 
                                        ? 'سيتم إضافة الرصيد إلى محفظتك فوراً بعد تأكيد عملية الدفع.' 
                                        : 'Balance will be added to your wallet immediately after payment confirmation.' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Benefits -->
                    <div class="bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 backdrop-blur-xl rounded-2xl p-4 border border-emerald-200/50 dark:border-emerald-800/50">
                        <div class="space-y-2">
                            <div class="flex items-center gap-2 text-xs text-emerald-800 dark:text-emerald-200">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>{{ app()->getLocale() == 'ar' ? 'معاملات فورية' : 'Instant Processing' }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-emerald-800 dark:text-emerald-200">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>{{ app()->getLocale() == 'ar' ? 'بدون رسوم إضافية' : 'No Hidden Fees' }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-emerald-800 dark:text-emerald-200">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>{{ app()->getLocale() == 'ar' ? 'دعم فني 24/7' : '24/7 Support' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
function selectAmount(amount) {
    const amountInput = document.getElementById('amount');
    amountInput.value = amount;
    
    // Add pulse animation
    amountInput.classList.add('scale-105');
    setTimeout(() => amountInput.classList.remove('scale-105'), 200);
    
    updateSummary();
    
    // Enhanced visual feedback with animations
    document.querySelectorAll('.amount-btn').forEach(btn => {
        btn.classList.remove('border-blue-500', 'dark:border-blue-400', 'scale-105', 'shadow-lg', 'shadow-blue-500/30');
        btn.classList.add('border-slate-200', 'dark:border-slate-600');
        
        // Remove checkmark
        const checkmark = btn.querySelector('.absolute.top-2');
        if (checkmark) checkmark.style.opacity = '0';
    });
    
    // Highlight selected button
    event.target.closest('.amount-btn').classList.remove('border-slate-200', 'dark:border-slate-600');
    event.target.closest('.amount-btn').classList.add('border-blue-500', 'dark:border-blue-400', 'scale-105', 'shadow-lg', 'shadow-blue-500/30');
    
    // Show checkmark
    const checkmark = event.target.closest('.amount-btn').querySelector('.absolute.top-2');
    if (checkmark) checkmark.style.opacity = '1';
}

function updateSummary() {
    const amount = parseFloat(document.getElementById('amount').value) || 0;
    const currency = '{{ $client->currency }}';
    
    // Format with animation
    const summaryAmount = document.getElementById('summary-amount');
    const summaryTotal = document.getElementById('summary-total');
    
    // Add animation class
    summaryAmount.classList.add('scale-110');
    summaryTotal.classList.add('scale-110');
    
    setTimeout(() => {
        summaryAmount.classList.remove('scale-110');
        summaryTotal.classList.remove('scale-110');
    }, 200);
    
    // Format numbers with proper currency (no notation for large numbers)
    const formattedAmount = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
        notation: 'standard' // This ensures full number display, not scientific notation
    }).format(amount);
    
    summaryAmount.textContent = formattedAmount;
    summaryTotal.textContent = formattedAmount;
}

// Add smooth scroll behavior
document.addEventListener('DOMContentLoaded', function() {
    updateSummary();
    
    // Add transition to all amount buttons
    document.querySelectorAll('.amount-btn').forEach(btn => {
        btn.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
    });
    
    // Add input validation
    const amountInput = document.getElementById('amount');
    amountInput.addEventListener('input', function() {
        if (this.value < 0) this.value = 0;
        if (this.value > 100000) this.value = 100000;
        updateSummary();
    });
    
    // Add form submission loading state
    const form = document.getElementById('add-funds-form');
    form.addEventListener('submit', function(e) {
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <span class="relative flex items-center justify-center gap-3">
                <svg class="animate-spin w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <span>{{ app()->getLocale() == 'ar' ? 'جاري المعالجة...' : 'Processing...' }}</span>
            </span>
        `;
    });
});

// Add number counter animation
function animateValue(element, start, end, duration) {
    let startTimestamp = null;
    const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        const value = progress * (end - start) + start;
        element.textContent = '$' + value.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        if (progress < 1) {
            window.requestAnimationFrame(step);
        }
    };
    window.requestAnimationFrame(step);
}
</script>

<style>
/* Enhanced Button Styles */
.btn-back {
    display: inline-flex;
    align-items: center;
    padding: 0.75rem 1.5rem;
    background: white;
    border: 2px solid #e2e8f0;
    color: #475569;
    font-weight: 600;
    border-radius: 1rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.btn-back:hover {
    border-color: #3b82f6;
    background: linear-gradient(to right, #eff6ff, #dbeafe);
    color: #2563eb;
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(59, 130, 246, 0.2);
}

.dark .btn-back {
    background: rgba(51, 65, 85, 0.6);
    border-color: rgba(148, 163, 184, 0.3);
    color: #cbd5e1;
}

.dark .btn-back:hover {
    border-color: #3b82f6;
    background: rgba(37, 99, 235, 0.15);
    color: #60a5fa;
}

/* Animations */
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slide-up {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes pulse-subtle {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.8;
    }
}

.animate-fade-in {
    animation: fade-in 0.6s ease-out;
}

.animate-slide-up {
    animation: slide-up 0.8s ease-out;
}

/* Custom Scrollbar */
::-webkit-scrollbar {
    width: 10px;
}

::-webkit-scrollbar-track {
    background: rgba(226, 232, 240, 0.3);
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(to bottom, #3b82f6, #6366f1);
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(to bottom, #2563eb, #4f46e5);
}

/* Enhanced Input Focus */
input[type="number"]:focus {
    outline: none;
}

/* Payment Method Selected State */
input[type="radio"]:checked + div .payment-method-card {
    border-color: #3b82f6;
}

/* Smooth Transitions */
* {
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

/* Glass Effect */
.glass {
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
}

.dark .glass {
    background: rgba(30, 41, 59, 0.7);
}

/* Hover Effects */
.hover\:shadow-3xl:hover {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

/* Amount Button Active State */
.amount-btn.active {
    border-color: #3b82f6 !important;
    background: linear-gradient(to bottom right, #eff6ff, #dbeafe) !important;
    transform: scale(1.05);
}

.dark .amount-btn.active {
    background: linear-gradient(to bottom right, rgba(37, 99, 235, 0.2), rgba(59, 130, 246, 0.15)) !important;
}

/* Number Input - Hide Arrows */
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type="number"] {
    -moz-appearance: textfield;
}

/* Loading State */
@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

.animate-spin {
    animation: spin 1s linear infinite;
}

/* Scale Animation */
.scale-105 {
    transform: scale(1.05);
}

.scale-110 {
    transform: scale(1.1);
}

/* Responsive Improvements */
@media (max-width: 768px) {
    .animate-fade-in h1 {
        font-size: 2rem;
    }
    
    .amount-btn {
        padding: 0.875rem 1rem;
    }
}

/* Enhanced Shadows */
.shadow-3xl {
    box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.3);
}
</style>
@endsection
