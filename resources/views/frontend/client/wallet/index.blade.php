@extends('frontend.client.layout')

@section('title', app()->getLocale() == 'ar' ? 'المحفظة' : 'Wallet')

@push('styles')
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .animate-fade-in {
        animation: fadeIn 0.3s ease-out;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-purple-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 py-8">
    <div class="container mx-auto px-4 max-w-7xl">
        @php $rtl = app()->getLocale() == 'ar'; @endphp
        
        {{-- Page Header --}}
        <div class="mb-6 md:mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white mb-2">
                {{ app()->getLocale() == 'ar' ? 'محفظتي' : 'My Wallet' }}
            </h1>
            <p class="text-sm md:text-base text-slate-600 dark:text-slate-400">
                {{ app()->getLocale() == 'ar' ? 'إدارة رصيدك ومعاملاتك المالية' : 'Manage your balance and transactions' }}
            </p>
        </div>

        {{-- Wallet Balance Card - Premium Mastercard Style --}}
        <div class="relative bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 rounded-2xl md:rounded-3xl shadow-2xl overflow-hidden mb-6 md:mb-8 transform hover:scale-[1.02] transition-all duration-300">
            {{-- Animated gradient overlay --}}
            <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 via-purple-600/20 to-pink-600/20 opacity-50"></div>
            
            {{-- Decorative mesh pattern --}}
            <div class="absolute inset-0 opacity-5">
                <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                            <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1" opacity="0.3"/>
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#grid)" />
                </svg>
            </div>
            
            {{-- Glowing orbs --}}
            <div class="absolute -top-24 {{ $rtl ? '-left-24' : '-right-24' }} w-64 h-64 bg-gradient-to-br from-purple-500/30 to-pink-500/30 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 {{ $rtl ? '-right-24' : '-left-24' }} w-64 h-64 bg-gradient-to-br from-blue-500/30 to-cyan-500/30 rounded-full blur-3xl"></div>
            
            <div class="relative p-4 sm:p-6 md:p-8 text-white">
                {{-- Top section with chip and logo --}}
                <div class="flex items-start justify-between mb-6 md:mb-8">
                    {{-- Card chip with animation --}}
                    <div class="w-10 h-8 sm:w-14 sm:h-11 bg-gradient-to-br from-amber-300 via-amber-400 to-amber-600 rounded-lg flex items-center justify-center shadow-xl transform hover:rotate-6 transition-transform">
                        <div class="grid grid-cols-3 gap-0.5 w-7 h-5 sm:w-9 sm:h-7">
                            @for($i = 0; $i < 9; $i++)
                                <div class="bg-amber-900/40 rounded-sm"></div>
                            @endfor
                        </div>
                    </div>
                    
                    {{-- Mastercard circles with glow effect --}}
                    <div class="flex items-center gap-0">
                        <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-full bg-gradient-to-br from-red-500 to-red-600 shadow-lg shadow-red-500/50"></div>
                        <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-full bg-gradient-to-br from-amber-400 to-amber-500 shadow-lg shadow-amber-500/50 {{ $rtl ? '-mr-5 sm:-mr-6' : '-ml-5 sm:-ml-6' }}"></div>
                    </div>
                </div>
                
                {{-- NFC Contactless Icon --}}
                <div class="hidden sm:block absolute top-6 sm:top-8 {{ $rtl ? 'right-16 sm:right-24' : 'left-16 sm:left-24' }} opacity-40">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path>
                    </svg>
                </div>
                
                {{-- Balance section --}}
                <div class="mb-6 md:mb-8">
                    <p class="text-slate-300 text-[10px] sm:text-xs uppercase tracking-[0.1em] sm:tracking-[0.2em] mb-1 sm:mb-2 font-light flex items-center gap-1 sm:gap-2">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                            <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                        </svg>
                        {{ app()->getLocale() == 'ar' ? 'الرصيد المتاح' : 'Available Balance' }}
                    </p>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold tracking-tight font-mono bg-gradient-to-r from-white via-slate-100 to-slate-300 bg-clip-text text-transparent break-all">
                        ${{ number_format($balance, 2) }}
                    </h2>
                </div>
                
                {{-- Card number with shine effect --}}
                @php
                    // Get unique wallet card number (generates if not exists)
                    $fullCardNumber = $client->getWalletCardNumber();
                    $cardParts = explode(' ', $fullCardNumber);
                    $part1 = $cardParts[0] ?? '';
                    $part2 = $cardParts[1] ?? '';
                    $part3 = $cardParts[2] ?? '';
                    $part4 = $cardParts[3] ?? '';
                    
                    // Masked version - show only last 4 digits
                    $maskedPart1 = '****';
                    $maskedPart2 = '****';
                    $maskedPart3 = '****';
                @endphp
                <div class="mb-6 md:mb-8">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3">
                        <div id="cardNumber" class="flex flex-wrap items-center gap-1.5 sm:gap-2 md:gap-3 font-mono text-sm sm:text-lg md:text-xl lg:text-2xl tracking-[0.1em] sm:tracking-[0.15em] md:tracking-[0.2em] lg:tracking-[0.3em]">
                            <span class="text-slate-400 card-part-1" data-real="{{ $part1 }}" data-masked="{{ $maskedPart1 }}">{{ $maskedPart1 }}</span>
                            <span class="text-slate-400 card-part-2" data-real="{{ $part2 }}" data-masked="{{ $maskedPart2 }}">{{ $maskedPart2 }}</span>
                            <span class="text-slate-400 hidden sm:inline card-part-3" data-real="{{ $part3 }}" data-masked="{{ $maskedPart3 }}">{{ $maskedPart3 }}</span>
                            <span class="text-white font-semibold card-part-4">{{ $part4 }}</span>
                        </div>
                        <div class="flex items-center gap-1">
                            {{-- Toggle visibility button --}}
                            <button onclick="toggleCardVisibility()" 
                                    id="toggleCardBtn"
                                    class="self-start p-1.5 sm:p-2 rounded-lg bg-white/10 hover:bg-white/20 transition-colors group"
                                    title="{{ app()->getLocale() == 'ar' ? 'إظهار/إخفاء رقم البطاقة' : 'Show/Hide card number' }}">
                                <svg id="eyeIcon" class="w-4 h-4 sm:w-5 sm:h-5 text-slate-300 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg id="eyeOffIcon" class="hidden w-4 h-4 sm:w-5 sm:h-5 text-slate-300 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                            
                            {{-- Copy button - hidden by default --}}
                            <button id="copyCardBtn" onclick="copyCardNumber('{{ $fullCardNumber }}')" 
                                    class="hidden self-start p-1.5 sm:p-2 rounded-lg bg-white/10 hover:bg-white/20 transition-colors group"
                                    title="{{ app()->getLocale() == 'ar' ? 'نسخ رقم البطاقة' : 'Copy card number' }}">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-slate-300 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                
                <script>
                // Toggle card number visibility
                let cardVisible = false;
                let otpVerified = false;
                
                function toggleCardVisibility() {
                    if (!otpVerified) {
                        // Show OTP modal
                        showOtpModal();
                        return;
                    }
                    
                    cardVisible = !cardVisible;
                    
                    const parts = ['card-part-1', 'card-part-2', 'card-part-3'];
                    const eyeIcon = document.getElementById('eyeIcon');
                    const eyeOffIcon = document.getElementById('eyeOffIcon');
                    const copyBtn = document.getElementById('copyCardBtn');
                    
                    parts.forEach(className => {
                        const element = document.querySelector('.' + className);
                        if (element) {
                            if (cardVisible) {
                                element.textContent = element.dataset.real;
                            } else {
                                element.textContent = element.dataset.masked;
                            }
                        }
                    });
                    
                    // Toggle eye icons and copy button
                    if (cardVisible) {
                        eyeIcon.classList.add('hidden');
                        eyeOffIcon.classList.remove('hidden');
                        copyBtn.classList.remove('hidden'); // Show copy button
                    } else {
                        eyeIcon.classList.remove('hidden');
                        eyeOffIcon.classList.add('hidden');
                        copyBtn.classList.add('hidden'); // Hide copy button
                    }
                }
                
                function copyCardNumber(cardNumber) {
                    const button = event.currentTarget;
                    const originalHTML = button.innerHTML;
                    
                    // Try modern clipboard API first
                    if (navigator.clipboard && navigator.clipboard.writeText) {
                        navigator.clipboard.writeText(cardNumber).then(function() {
                            showCopySuccess(button, originalHTML);
                        }).catch(function(err) {
                            fallbackCopy(cardNumber, button, originalHTML);
                        });
                    } else {
                        fallbackCopy(cardNumber, button, originalHTML);
                    }
                }
                
                function fallbackCopy(text, button, originalHTML) {
                    // Fallback method using textarea
                    const textarea = document.createElement('textarea');
                    textarea.value = text;
                    textarea.style.position = 'fixed';
                    textarea.style.opacity = '0';
                    document.body.appendChild(textarea);
                    textarea.select();
                    
                    try {
                        const successful = document.execCommand('copy');
                        if (successful) {
                            showCopySuccess(button, originalHTML);
                        } else {
                            showCopyError();
                        }
                    } catch (err) {
                        console.error('Failed to copy: ', err);
                        showCopyError();
                    } finally {
                        document.body.removeChild(textarea);
                    }
                }
                
                function showCopySuccess(button, originalHTML) {
                    button.innerHTML = `
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    `;
                    
                    setTimeout(function() {
                        button.innerHTML = originalHTML;
                    }, 2000);
                }
                
                function showCopyError() {
                    alert('{{ app()->getLocale() == 'ar' ? 'فشل النسخ. يرجى النسخ يدوياً' : 'Failed to copy. Please copy manually' }}');
                }
                </script>
                
                {{-- Card holder info with modern styling --}}
                <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 sm:gap-0 mb-4 sm:mb-6">
                    <div>
                        <p class="text-slate-400 text-[8px] sm:text-[9px] uppercase tracking-[0.1em] sm:tracking-[0.15em] mb-1 sm:mb-1.5 font-light">
                            {{ app()->getLocale() == 'ar' ? 'اسم صاحب البطاقة' : 'Card Holder Name' }}
                        </p>
                        <p class="text-white text-sm sm:text-base font-semibold uppercase tracking-wide sm:tracking-wider truncate max-w-[200px] sm:max-w-none">
                            {{ $client->first_name ?? $client->username }} {{ $client->last_name ?? '' }}
                        </p>
                    </div>
                    <div class="{{ $rtl ? 'sm:text-left' : 'sm:text-right' }}">
                        <p class="text-slate-400 text-[8px] sm:text-[9px] uppercase tracking-[0.1em] sm:tracking-[0.15em] mb-1 sm:mb-1.5 font-light">
                            {{ app()->getLocale() == 'ar' ? 'تاريخ الانضمام' : 'Member Since' }}
                        </p>
                        <p class="text-white text-sm sm:text-base font-semibold font-mono">
                            {{ $client->created_at->format('m/y') }}
                        </p>
                    </div>
                </div>
                
                {{-- Stats section with glass effect --}}
                <div class="grid grid-cols-2 gap-2 sm:gap-3 md:gap-4 pt-4 sm:pt-6 border-t border-white/10">
                    <div class="bg-white/5 backdrop-blur-sm rounded-lg sm:rounded-xl p-2.5 sm:p-3 md:p-4 border border-white/10 hover:bg-white/10 transition-colors">
                        <div class="flex items-center gap-1 sm:gap-2 mb-1 sm:mb-2">
                            <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-green-400 animate-pulse"></div>
                            <p class="text-slate-400 text-[10px] sm:text-xs font-light">
                                {{ app()->getLocale() == 'ar' ? 'إجمالي الإيداعات' : 'Total Deposits' }}
                            </p>
                        </div>
                        <p class="text-sm sm:text-lg md:text-xl font-bold font-mono text-green-400 break-all">
                            ${{ number_format($stats['total_deposits'], 2) }}
                        </p>
                    </div>
                    <div class="bg-white/5 backdrop-blur-sm rounded-lg sm:rounded-xl p-2.5 sm:p-3 md:p-4 border border-white/10 hover:bg-white/10 transition-colors">
                        <div class="flex items-center gap-1 sm:gap-2 mb-1 sm:mb-2">
                            <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-amber-400 animate-pulse"></div>
                            <p class="text-slate-400 text-[10px] sm:text-xs font-light">
                                {{ app()->getLocale() == 'ar' ? 'معاملات معلقة' : 'Pending Transactions' }}
                            </p>
                        </div>
                        <p class="text-sm sm:text-lg md:text-xl font-bold font-mono text-amber-400">
                            {{ $stats['pending_transactions'] }}
                        </p>
                    </div>
                </div>
                
                {{-- Card type indicator --}}
                <div class="hidden sm:block absolute bottom-3 sm:bottom-4 {{ $rtl ? 'left-4 sm:left-8' : 'right-4 sm:right-8' }} opacity-50">
                    <p class="text-white text-[10px] sm:text-xs font-bold tracking-wider sm:tracking-widest uppercase">Premium</p>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="mb-6 md:mb-8 grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Add Funds Card --}}
            <a href="{{ route('client.wallet.add-funds') }}" 
               class="group bg-white dark:bg-slate-800 rounded-xl md:rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-4 sm:p-5 md:p-6 border-2 border-transparent hover:border-green-500 block">
                <div class="flex items-center gap-3 sm:gap-4">
                    <div class="bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-lg sm:rounded-xl p-3 sm:p-4 group-hover:scale-110 transition-transform flex-shrink-0">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white mb-0.5 sm:mb-1">
                            {{ app()->getLocale() == 'ar' ? 'إضافة أموال' : 'Add Funds' }}
                        </h3>
                        <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm truncate">
                            {{ app()->getLocale() == 'ar' ? 'شحن محفظتك بسهولة وأمان' : 'Top up your wallet easily' }}
                        </p>
                    </div>
                </div>
            </a>

            {{-- Transfer Funds Card --}}
            <a href="{{ route('client.wallet.transfer-form') }}" 
               class="group bg-white dark:bg-slate-800 rounded-xl md:rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-4 sm:p-5 md:p-6 border-2 border-transparent hover:border-blue-500 block">
                <div class="flex items-center gap-3 sm:gap-4">
                    <div class="bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg sm:rounded-xl p-3 sm:p-4 group-hover:scale-110 transition-transform flex-shrink-0">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white mb-0.5 sm:mb-1">
                            {{ app()->getLocale() == 'ar' ? 'تحويل الرصيد' : 'Transfer Funds' }}
                        </h3>
                        <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm truncate">
                            {{ app()->getLocale() == 'ar' ? 'حول الأموال إلى محفظة أخرى' : 'Send money to another wallet' }}
                        </p>
                    </div>
                </div>
            </a>

            {{-- Request Account Statement Card --}}
            <a href="{{ route('client.account-statement') }}" 
               class="group bg-white dark:bg-slate-800 rounded-xl md:rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-4 sm:p-5 md:p-6 border-2 border-transparent hover:border-purple-500 block">
                <div class="flex items-center gap-3 sm:gap-4">
                    <div class="bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-lg sm:rounded-xl p-3 sm:p-4 group-hover:scale-110 transition-transform flex-shrink-0">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white mb-0.5 sm:mb-1">
                            {{ app()->getLocale() == 'ar' ? 'كشف الحساب' : 'Account Statement' }}
                        </h3>
                        <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm truncate">
                            {{ app()->getLocale() == 'ar' ? 'عرض وتحميل كشف حسابك' : 'View & download your statement' }}
                        </p>
                    </div>
                </div>
            </a>
        </div>

        {{-- Transactions History --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl md:rounded-2xl shadow-lg overflow-hidden">
            <div class="p-4 sm:p-5 md:p-6 border-b border-slate-200 dark:border-slate-700">
                <h2 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white">
                    {{ app()->getLocale() == 'ar' ? 'سجل المعاملات' : 'Transaction History' }}
                </h2>
            </div>

            @if($transactions->count() > 0)
                {{-- Mobile Cards View --}}
                <div id="mobile-transactions" class="block md:hidden divide-y divide-slate-200 dark:divide-slate-700">
                    @foreach($transactions as $transaction)
                        <div class="p-4 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1">
                                        @if($transaction->payment_method == 'transfer_fee')
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ app()->getLocale() == 'ar' ? 'رسوم تحويل' : 'Transfer Fee' }}
                                            </span>
                                        @elseif($transaction->payment_method == 'wallet_transfer')
                                            @if($transaction->type == 'deposit')
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M8 5a1 1 0 100 2h5.586l-1.293 1.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L13.586 5H8zM12 15a1 1 0 100-2H6.414l1.293-1.293a1 1 0 10-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L6.414 15H12z"/>
                                                    </svg>
                                                    {{ app()->getLocale() == 'ar' ? 'تحويل مستلم' : 'Transfer Received' }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M8 5a1 1 0 100 2h5.586l-1.293 1.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L13.586 5H8zM12 15a1 1 0 100-2H6.414l1.293-1.293a1 1 0 10-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L6.414 15H12z"/>
                                                    </svg>
                                                    {{ app()->getLocale() == 'ar' ? 'تحويل مرسل' : 'Transfer Sent' }}
                                                </span>
                                            @endif
                                        @else
                                            @if($transaction->type == 'deposit')
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd"/>
                                                    </svg>
                                                    {{ app()->getLocale() == 'ar' ? 'إيداع' : 'Deposit' }}
                                                </span>
                                            @elseif($transaction->type == 'deduction')
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                                    </svg>
                                                    {{ app()->getLocale() == 'ar' ? 'خصم' : 'Deduction' }}
                                                </span>
                                            @elseif($transaction->type == 'refund')
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M5 2a2 2 0 00-2 2v14l3.5-2 3.5 2 3.5-2 3.5 2V4a2 2 0 00-2-2H5zm2.5 3a1.5 1.5 0 100 3 1.5 1.5 0 000-3zm6.207.293a1 1 0 00-1.414 0l-6 6a1 1 0 101.414 1.414l6-6a1 1 0 000-1.414zM12.5 10a1.5 1.5 0 100 3 1.5 1.5 0 000-3z" clip-rule="evenodd"/>
                                                    </svg>
                                                    {{ app()->getLocale() == 'ar' ? 'استرداد' : 'Refund' }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd"/>
                                                    </svg>
                                                    {{ app()->getLocale() == 'ar' ? 'سحب' : 'Withdrawal' }}
                                                </span>
                                            @endif
                                        @endif
                                        @if($transaction->status == 'completed')
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ app()->getLocale() == 'ar' ? 'مكتمل' : 'Completed' }}
                                            </span>
                                        @elseif($transaction->status == 'pending')
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                                <svg class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                                {{ app()->getLocale() == 'ar' ? 'معلق' : 'Pending' }}
                                            </span>
                                        @elseif($transaction->status == 'cancelled')
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ app()->getLocale() == 'ar' ? 'ملغي' : 'Cancelled' }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ app()->getLocale() == 'ar' ? 'فشل' : 'Failed' }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <p class="text-xs font-mono text-slate-500 dark:text-slate-400 truncate">
                                            {{ $transaction->reference }}
                                        </p>
                                        <button onclick="copyReference('{{ $transaction->reference }}')" 
                                                class="flex-shrink-0 p-1 text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors"
                                                title="{{ app()->getLocale() == 'ar' ? 'نسخ الرقم المرجعي' : 'Copy Reference' }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="{{ $rtl ? 'text-left mr-3' : 'text-right ml-3' }}">
                                    <p class="text-base sm:text-lg font-semibold {{ $transaction->type == 'deposit' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                        {{ $transaction->type == 'deposit' ? '+' : '-' }}${{ number_format($transaction->amount, 2) }}
                                    </p>
                                    <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-0.5">
                                        {{ $transaction->created_at->format('Y-m-d') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Desktop Table View --}}
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 dark:bg-slate-900/50">
                            <tr>
                                <th class="px-4 lg:px-6 py-3 lg:py-4 {{ $rtl ? 'text-right' : 'text-left' }} text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider">
                                    {{ app()->getLocale() == 'ar' ? 'المرجع' : 'Reference' }}
                                </th>
                                <th class="px-4 lg:px-6 py-3 lg:py-4 {{ $rtl ? 'text-right' : 'text-left' }} text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider">
                                    {{ app()->getLocale() == 'ar' ? 'النوع' : 'Type' }}
                                </th>
                                <th class="px-4 lg:px-6 py-3 lg:py-4 {{ $rtl ? 'text-right' : 'text-left' }} text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider">
                                    {{ app()->getLocale() == 'ar' ? 'المبلغ' : 'Amount' }}
                                </th>
                                <th class="px-4 lg:px-6 py-3 lg:py-4 {{ $rtl ? 'text-right' : 'text-left' }} text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider">
                                    {{ app()->getLocale() == 'ar' ? 'الحالة' : 'Status' }}
                                </th>
                                <th class="px-4 lg:px-6 py-3 lg:py-4 {{ $rtl ? 'text-right' : 'text-left' }} text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider">
                                    {{ app()->getLocale() == 'ar' ? 'التاريخ' : 'Date' }}
                                </th>
                            </tr>
                        </thead>
                        <tbody id="desktop-transactions" class="divide-y divide-slate-200 dark:divide-slate-700">
                            @foreach($transactions as $transaction)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                    <td class="px-4 lg:px-6 py-3 lg:py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs sm:text-sm font-mono text-slate-900 dark:text-white">
                                                {{ $transaction->reference }}
                                            </span>
                                            <button onclick="copyReference('{{ $transaction->reference }}')" 
                                                    class="p-1 text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors"
                                                    title="{{ app()->getLocale() == 'ar' ? 'نسخ الرقم المرجعي' : 'Copy Reference' }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="px-4 lg:px-6 py-3 lg:py-4 whitespace-nowrap">
                                        @if($transaction->payment_method == 'transfer_fee')
                                            <span class="inline-flex items-center gap-1 px-2 sm:px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400">
                                                <svg class="w-3 sm:w-4 h-3 sm:h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ app()->getLocale() == 'ar' ? 'رسوم تحويل' : 'Transfer Fee' }}
                                            </span>
                                        @elseif($transaction->payment_method == 'wallet_transfer')
                                            @if($transaction->type == 'deposit')
                                                <span class="inline-flex items-center gap-1 px-2 sm:px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                                    <svg class="w-3 sm:w-4 h-3 sm:h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M8 5a1 1 0 100 2h5.586l-1.293 1.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L13.586 5H8zM12 15a1 1 0 100-2H6.414l1.293-1.293a1 1 0 10-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L6.414 15H12z"/>
                                                    </svg>
                                                    {{ app()->getLocale() == 'ar' ? 'تحويل مستلم' : 'Transfer Received' }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2 sm:px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400">
                                                    <svg class="w-3 sm:w-4 h-3 sm:h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M8 5a1 1 0 100 2h5.586l-1.293 1.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L13.586 5H8zM12 15a1 1 0 100-2H6.414l1.293-1.293a1 1 0 10-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L6.414 15H12z"/>
                                                    </svg>
                                                    {{ app()->getLocale() == 'ar' ? 'تحويل مرسل' : 'Transfer Sent' }}
                                                </span>
                                            @endif
                                        @else
                                            @if($transaction->type == 'deposit')
                                                <span class="inline-flex items-center gap-1 px-2 sm:px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                    <svg class="w-3 sm:w-4 h-3 sm:h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd"/>
                                                    </svg>
                                                    {{ app()->getLocale() == 'ar' ? 'إيداع' : 'Deposit' }}
                                                </span>
                                            @elseif($transaction->type == 'deduction')
                                                <span class="inline-flex items-center gap-1 px-2 sm:px-3 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400">
                                                    <svg class="w-3 sm:w-4 h-3 sm:h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                                    </svg>
                                                    {{ app()->getLocale() == 'ar' ? 'خصم' : 'Deduction' }}
                                                </span>
                                            @elseif($transaction->type == 'refund')
                                                <span class="inline-flex items-center gap-1 px-2 sm:px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                                    <svg class="w-3 sm:w-4 h-3 sm:h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M5 2a2 2 0 00-2 2v14l3.5-2 3.5 2 3.5-2 3.5 2V4a2 2 0 00-2-2H5zm2.5 3a1.5 1.5 0 100 3 1.5 1.5 0 000-3zm6.207.293a1 1 0 00-1.414 0l-6 6a1 1 0 101.414 1.414l6-6a1 1 0 000-1.414zM12.5 10a1.5 1.5 0 100 3 1.5 1.5 0 000-3z" clip-rule="evenodd"/>
                                                    </svg>
                                                    {{ app()->getLocale() == 'ar' ? 'استرداد' : 'Refund' }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2 sm:px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                                    <svg class="w-3 sm:w-4 h-3 sm:h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd"/>
                                                    </svg>
                                                    {{ app()->getLocale() == 'ar' ? 'سحب' : 'Withdrawal' }}
                                                </span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="px-4 lg:px-6 py-3 lg:py-4 whitespace-nowrap">
                                        <span class="text-base sm:text-lg font-semibold {{ $transaction->type == 'deposit' || $transaction->type == 'refund' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            {{ $transaction->type == 'deposit' || $transaction->type == 'refund' ? '+' : '-' }}${{ number_format($transaction->amount, 2) }}
                                        </span>
                                    </td>
                                    <td class="px-4 lg:px-6 py-3 lg:py-4 whitespace-nowrap">
                                        @if($transaction->status == 'completed')
                                            <span class="inline-flex items-center gap-1 px-2 sm:px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                <svg class="w-3 sm:w-4 h-3 sm:h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ app()->getLocale() == 'ar' ? 'مكتمل' : 'Completed' }}
                                            </span>
                                        @elseif($transaction->status == 'pending')
                                            <span class="inline-flex items-center gap-1 px-2 sm:px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                                <svg class="w-3 sm:w-4 h-3 sm:h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                                {{ app()->getLocale() == 'ar' ? 'معلق' : 'Pending' }}
                                            </span>
                                        @elseif($transaction->status == 'cancelled')
                                            <span class="inline-flex items-center gap-1 px-2 sm:px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400">
                                                <svg class="w-3 sm:w-4 h-3 sm:h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ app()->getLocale() == 'ar' ? 'ملغي' : 'Cancelled' }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 sm:px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                                <svg class="w-3 sm:w-4 h-3 sm:h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ app()->getLocale() == 'ar' ? 'فشل' : 'Failed' }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 lg:px-6 py-3 lg:py-4 whitespace-nowrap text-xs sm:text-sm text-slate-600 dark:text-slate-400">
                                        {{ $transaction->created_at->format('Y-m-d H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div id="pagination-container" class="p-4 sm:p-5 md:p-6 border-t border-slate-200 dark:border-slate-700">
                    {{ $transactions->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="p-8 sm:p-10 md:p-12 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 bg-slate-100 dark:bg-slate-700 rounded-full mb-3 sm:mb-4">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold text-slate-900 dark:text-white mb-2">
                        {{ app()->getLocale() == 'ar' ? 'لا توجد معاملات بعد' : 'No Transactions Yet' }}
                    </h3>
                    <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400 mb-5 sm:mb-6 px-4">
                        {{ app()->getLocale() == 'ar' ? 'ابدأ بإضافة أموال إلى محفظتك' : 'Start by adding funds to your wallet' }}
                    </p>
                    <a href="{{ route('client.wallet.add-funds') }}" 
                       class="inline-flex items-center gap-2 px-5 py-2.5 sm:px-6 sm:py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white text-sm sm:text-base font-semibold rounded-xl hover:shadow-lg transition-all">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        {{ app()->getLocale() == 'ar' ? 'إضافة أموال' : 'Add Funds' }}
                    </a>
                </div>
            @endif
        </div>

    </div>
</div>

{{-- OTP Verification Modal --}}
<div id="otpModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-800 rounded-2xl max-w-md w-full p-6 shadow-2xl transform transition-all">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">
                {{ app()->getLocale() == 'ar' ? 'تحقق من الهوية' : 'Identity Verification' }}
            </h3>
            <p class="text-sm text-slate-600 dark:text-slate-400">
                {{ app()->getLocale() == 'ar' ? 'سنرسل رمز التحقق إلى بريدك الإلكتروني' : 'We will send a verification code to your email' }}
            </p>
            <p class="text-sm font-semibold text-blue-600 dark:text-blue-400 mt-2">
                {{ Auth::guard('client')->user()->email }}
            </p>
        </div>

        <div id="otpStep1" class="mb-4">
            <button onclick="sendOtp()" id="sendOtpBtn" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold py-3 rounded-xl hover:shadow-lg transition-all">
                {{ app()->getLocale() == 'ar' ? 'إرسال الكود' : 'Send Code' }}
            </button>
        </div>

        <div id="otpStep2" class="hidden">
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                    {{ app()->getLocale() == 'ar' ? 'أدخل الكود المكون من 6 أرقام' : 'Enter 6-digit code' }}
                </label>
                <input type="text" id="otpCode" maxlength="6" 
                       class="w-full px-4 py-3 text-center text-2xl font-mono tracking-widest border-2 border-slate-300 dark:border-slate-600 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:bg-slate-700 dark:text-white"
                       placeholder="000000">
                <p id="otpError" class="text-red-500 text-sm mt-2 hidden"></p>
            </div>
            <button onclick="verifyOtp()" id="verifyOtpBtn" class="w-full bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold py-3 rounded-xl hover:shadow-lg transition-all mb-2">
                {{ app()->getLocale() == 'ar' ? 'تحقق' : 'Verify' }}
            </button>
            <button onclick="sendOtp()" class="w-full text-blue-600 dark:text-blue-400 text-sm font-medium py-2 hover:underline">
                {{ app()->getLocale() == 'ar' ? 'إعادة إرسال الكود' : 'Resend Code' }}
            </button>
        </div>

        <button onclick="closeOtpModal()" class="w-full text-slate-600 dark:text-slate-400 font-medium py-2 mt-4">
            {{ app()->getLocale() == 'ar' ? 'إلغاء' : 'Cancel' }}
        </button>
    </div>
</div>

<script>
function showOtpModal() {
    const modal = document.getElementById('otpModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.getElementById('otpStep1').classList.remove('hidden');
    document.getElementById('otpStep2').classList.add('hidden');
    document.getElementById('otpCode').value = '';
    document.getElementById('otpError').classList.add('hidden');
}

function closeOtpModal() {
    const modal = document.getElementById('otpModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

async function sendOtp() {
    const btn = document.getElementById('sendOtpBtn');
    const originalText = btn.textContent;
    btn.disabled = true;
    btn.textContent = '{{ app()->getLocale() == 'ar' ? 'جاري الإرسال...' : 'Sending...' }}';
    
    try {
        const response = await fetch('{{ route('client.wallet.send-card-otp') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            document.getElementById('otpStep1').classList.add('hidden');
            document.getElementById('otpStep2').classList.remove('hidden');
            document.getElementById('otpCode').focus();
        } else {
            alert(data.message);
        }
    } catch (error) {
        alert('{{ app()->getLocale() == 'ar' ? 'حدث خطأ. حاول مرة أخرى.' : 'An error occurred. Try again.' }}');
    } finally {
        btn.disabled = false;
        btn.textContent = originalText;
    }
}

async function verifyOtp() {
    const otpCode = document.getElementById('otpCode').value;
    const errorEl = document.getElementById('otpError');
    
    if (otpCode.length !== 6) {
        errorEl.textContent = '{{ app()->getLocale() == 'ar' ? 'الكود يجب أن يكون 6 أرقام' : 'Code must be 6 digits' }}';
        errorEl.classList.remove('hidden');
        return;
    }
    
    const btn = document.getElementById('verifyOtpBtn');
    const originalText = btn.textContent;
    btn.disabled = true;
    btn.textContent = '{{ app()->getLocale() == 'ar' ? 'جاري التحقق...' : 'Verifying...' }}';
    
    try {
        const response = await fetch('{{ route('client.wallet.verify-card-otp') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ otp_code: otpCode })
        });
        
        const data = await response.json();
        
        if (data.success) {
            otpVerified = true;
            closeOtpModal();
            // Now actually toggle visibility
            toggleCardVisibility();
        } else {
            errorEl.textContent = data.message;
            errorEl.classList.remove('hidden');
        }
    } catch (error) {
        errorEl.textContent = '{{ app()->getLocale() == 'ar' ? 'حدث خطأ. حاول مرة أخرى.' : 'An error occurred. Try again.' }}';
        errorEl.classList.remove('hidden');
    } finally {
        btn.disabled = false;
        btn.textContent = originalText;
    }
}

// Copy Reference Function
function copyReference(reference) {
    // Create temporary input element
    const tempInput = document.createElement('input');
    tempInput.value = reference;
    document.body.appendChild(tempInput);
    tempInput.select();
    
    try {
        // Try to copy using modern clipboard API
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(reference).then(() => {
                showCopyNotification();
            }).catch(() => {
                // Fallback to execCommand
                document.execCommand('copy');
                showCopyNotification();
            });
        } else {
            // Fallback for older browsers
            document.execCommand('copy');
            showCopyNotification();
        }
    } catch (err) {
        console.error('Failed to copy:', err);
    }
    
    document.body.removeChild(tempInput);
}

function showCopyNotification() {
    const message = '{{ app()->getLocale() == 'ar' ? 'تم نسخ الرقم المرجعي!' : 'Reference copied!' }}';
    
    // Create notification element
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 {{ $rtl ? 'left-4' : 'right-4' }} bg-green-600 text-white px-4 py-3 rounded-lg shadow-lg z-50 flex items-center gap-2 animate-fade-in';
    notification.innerHTML = `
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        <span class="font-medium">${message}</span>
    `;
    
    document.body.appendChild(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateY(-10px)';
        notification.style.transition = 'all 0.3s ease-out';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// AJAX Pagination
document.addEventListener('click', function(e) {
    // Check if clicked element is a pagination link
    const paginationLink = e.target.closest('#pagination-container a');
    if (!paginationLink) return;
    
    e.preventDefault();
    
    const url = paginationLink.href;
    
    // Show loading state
    const mobileContainer = document.getElementById('mobile-transactions');
    const desktopContainer = document.getElementById('desktop-transactions');
    const paginationContainer = document.getElementById('pagination-container');
    
    if (mobileContainer) {
        mobileContainer.style.opacity = '0.5';
    }
    if (desktopContainer) {
        desktopContainer.style.opacity = '0.5';
    }
    
    // Fetch paginated data
    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update mobile view
            if (mobileContainer) {
                mobileContainer.innerHTML = data.mobileHtml;
                mobileContainer.style.opacity = '1';
            }
            
            // Update desktop view
            if (desktopContainer) {
                desktopContainer.innerHTML = data.desktopHtml;
                desktopContainer.style.opacity = '1';
            }
            
            // Update pagination
            if (paginationContainer) {
                paginationContainer.innerHTML = data.paginationHtml;
            }
            
            // Scroll to top of transactions table smoothly
            const transactionsCard = document.querySelector('.bg-white.dark\\:bg-slate-800.rounded-lg.shadow-sm');
            if (transactionsCard) {
                transactionsCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    })
    .catch(error => {
        console.error('Pagination error:', error);
        // Restore opacity
        if (mobileContainer) mobileContainer.style.opacity = '1';
        if (desktopContainer) desktopContainer.style.opacity = '1';
    });
});
</script>

@endsection
