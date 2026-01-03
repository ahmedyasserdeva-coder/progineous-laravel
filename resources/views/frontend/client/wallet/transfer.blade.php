@extends('frontend.client.layout')

@section('title', app()->getLocale() == 'ar' ? 'تحويل الرصيد' : 'Transfer Funds')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-purple-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 py-8">
    <div class="container mx-auto px-4 max-w-4xl">
        @php $rtl = app()->getLocale() == 'ar'; @endphp
        
        {{-- Back Button --}}
        <a href="{{ route('client.wallet') }}" class="inline-flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white mb-6 transition-colors">
            <svg class="w-5 h-5 {{ $rtl ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            {{ app()->getLocale() == 'ar' ? 'العودة إلى المحفظة' : 'Back to Wallet' }}
        </a>

        {{-- Page Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">
                {{ app()->getLocale() == 'ar' ? 'تحويل الرصيد' : 'Transfer Funds' }}
            </h1>
            <p class="text-slate-600 dark:text-slate-400">
                {{ app()->getLocale() == 'ar' ? 'حول الأموال إلى محفظة عميل آخر' : 'Send money to another client\'s wallet' }}
            </p>
        </div>

        {{-- Current Balance Card --}}
        <div class="bg-gradient-to-br from-blue-600 to-purple-600 rounded-2xl shadow-xl p-6 mb-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm mb-1">
                        {{ app()->getLocale() == 'ar' ? 'رصيدك الحالي' : 'Your Current Balance' }}
                    </p>
                    <p class="text-3xl font-bold font-mono">
                        ${{ number_format(auth('client')->user()->wallet_balance, 2) }}
                    </p>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Transfer Form --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl overflow-hidden">
            <div class="p-6 border-b border-slate-200 dark:border-slate-700">
                <h2 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                    {{ app()->getLocale() == 'ar' ? 'تفاصيل التحويل' : 'Transfer Details' }}
                </h2>
            </div>

            <form id="transferForm" class="p-6 space-y-6">
                @csrf

                {{-- Receiver Card Number --}}
                <div>
                    <label for="receiver_card_number" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ app()->getLocale() == 'ar' ? 'رقم بطاقة المستلم' : 'Receiver Card Number' }}
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 {{ $rtl ? 'right-0 pr-3' : 'left-0 pl-3' }} flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                        </div>
                        <input type="text" 
                               id="receiver_card_number" 
                               name="receiver_card_number"
                               placeholder="XXXX XXXX XXXX XXXX"
                               maxlength="19"
                               class="{{ $rtl ? 'pr-10 text-right' : 'pl-10' }} w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white font-mono"
                               required>
                    </div>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        {{ app()->getLocale() == 'ar' ? 'أدخل رقم بطاقة المحفظة للمستلم (16 رقم بمسافات)' : 'Enter the receiver\'s wallet card number (16 digits with spaces)' }}
                    </p>
                    <div class="mt-2 flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ app()->getLocale() == 'ar' ? 'مثال: 5123 4567 8901 2345' : 'Example: 5123 4567 8901 2345' }}</span>
                    </div>
                </div>

                {{-- Receiver Info Display --}}
                <div id="receiverInfo" class="hidden bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <div class="bg-blue-600 text-white rounded-full p-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-blue-900 dark:text-blue-100">
                                {{ app()->getLocale() == 'ar' ? 'المستلم' : 'Receiver' }}
                            </p>
                            <p id="receiverName" class="text-lg font-bold text-blue-900 dark:text-blue-100"></p>
                        </div>
                    </div>
                </div>

                {{-- Amount --}}
                <div>
                    <label for="amount" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ app()->getLocale() == 'ar' ? 'المبلغ' : 'Amount' }}
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 {{ $rtl ? 'right-0 pr-3' : 'left-0 pl-3' }} flex items-center pointer-events-none">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">$</span>
                        </div>
                        <input type="number" 
                               id="amount" 
                               name="amount"
                               step="0.01"
                               min="1"
                               max="{{ auth('client')->user()->wallet_balance }}"
                               placeholder="0.00"
                               class="{{ $rtl ? 'pr-10 text-right' : 'pl-10' }} w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white font-mono text-lg"
                               required>
                    </div>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        {{ app()->getLocale() == 'ar' ? 'الحد الأقصى:' : 'Maximum:' }} 
                        <span class="font-medium">${{ number_format(auth('client')->user()->wallet_balance, 2) }}</span>
                    </p>
                </div>

                {{-- Transfer Summary --}}
                <div id="transferSummary" class="hidden bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg p-4 space-y-2">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-600 dark:text-slate-400">{{ app()->getLocale() == 'ar' ? 'المبلغ المحول' : 'Transfer Amount' }}</span>
                        <span id="summaryAmount" class="font-semibold text-slate-900 dark:text-white">$0.00</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-600 dark:text-slate-400">{{ app()->getLocale() == 'ar' ? 'رسوم التحويل (1%)' : 'Transfer Fee (1%)' }}</span>
                        <span id="summaryFee" class="font-semibold text-orange-600 dark:text-orange-400">$0.00</span>
                    </div>
                    <div class="border-t border-slate-300 dark:border-slate-600 pt-2 mt-2"></div>
                    <div class="flex justify-between items-center">
                        <span class="font-semibold text-slate-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'الإجمالي' : 'Total' }}</span>
                        <span id="summaryTotal" class="font-bold text-lg text-blue-600 dark:text-blue-400">$0.00</span>
                    </div>
                </div>

                {{-- Notes (Optional) --}}
                <div>
                    <label for="notes" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ app()->getLocale() == 'ar' ? 'ملاحظات (اختياري)' : 'Notes (Optional)' }}
                    </label>
                    <textarea id="notes" 
                              name="notes"
                              rows="3"
                              maxlength="500"
                              placeholder="{{ app()->getLocale() == 'ar' ? 'أضف ملاحظة لهذا التحويل...' : 'Add a note for this transfer...' }}"
                              class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white {{ $rtl ? 'text-right' : '' }}"></textarea>
                </div>

                {{-- Error Message --}}
                <div id="errorMessage" class="hidden bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <p id="errorText" class="text-sm text-red-700 dark:text-red-300"></p>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div>
                    <button type="submit" 
                            id="submitButton"
                            disabled
                            class="w-full bg-green-600 hover:bg-green-700 disabled:bg-slate-300 disabled:cursor-not-allowed text-white font-semibold py-3 px-6 rounded-lg transition-colors flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                        <span id="submitText">{{ app()->getLocale() == 'ar' ? 'تحويل الآن' : 'Transfer Now' }}</span>
                    </button>
                </div>
            </form>
        </div>

        {{-- OTP Modal --}}
        <div id="otpModal" style="display: none;" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl max-w-md w-full p-6 transform transition-all">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">
                        {{ app()->getLocale() == 'ar' ? 'أدخل رمز التحقق' : 'Enter Verification Code' }}
                    </h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">
                        {{ app()->getLocale() == 'ar' ? 'تم إرسال رمز مكون من 6 أرقام إلى بريدك الإلكتروني' : 'A 6-digit code has been sent to your email' }}
                    </p>
                </div>

                <div class="mb-6">
                    <input type="text" 
                           id="otpInput" 
                           maxlength="6"
                           placeholder="000000"
                           class="w-full text-center text-2xl font-mono tracking-widest px-4 py-3 border-2 border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-slate-700 dark:text-white"
                           autocomplete="off">
                    <p id="otpError" class="hidden mt-2 text-sm text-red-600 dark:text-red-400 text-center"></p>
                </div>

                <div class="flex gap-3">
                    <button type="button" 
                            id="closeOtpModal"
                            class="flex-1 bg-slate-200 hover:bg-slate-300 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-900 dark:text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                        {{ app()->getLocale() == 'ar' ? 'إلغاء' : 'Cancel' }}
                    </button>
                    <button type="button" 
                            id="verifyOtpButton"
                            class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                        {{ app()->getLocale() == 'ar' ? 'تحقق وتحويل' : 'Verify & Transfer' }}
                    </button>
                </div>

                <div class="mt-4 text-center">
                    <button type="button" 
                            id="resendOtpButton"
                            class="text-sm text-purple-600 hover:text-purple-700 dark:text-purple-400 font-medium">
                        {{ app()->getLocale() == 'ar' ? 'إعادة إرسال الرمز' : 'Resend Code' }}
                    </button>
                </div>
            </div>
        </div>

        {{-- Info Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-8">
            <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg">
                <div class="flex items-start gap-3">
                    <div class="bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg p-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-900 dark:text-white mb-1">
                            {{ app()->getLocale() == 'ar' ? 'تحويل فوري' : 'Instant Transfer' }}
                        </h3>
                        <p class="text-sm text-slate-600 dark:text-slate-400">
                            {{ app()->getLocale() == 'ar' ? 'يتم تحويل الأموال فوراً إلى محفظة المستلم' : 'Funds are transferred instantly to the receiver\'s wallet' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg">
                <div class="flex items-start gap-3">
                    <div class="bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-lg p-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-900 dark:text-white mb-1">
                            {{ app()->getLocale() == 'ar' ? 'آمن ومحمي' : 'Safe & Secure' }}
                        </h3>
                        <p class="text-sm text-slate-600 dark:text-slate-400">
                            {{ app()->getLocale() == 'ar' ? 'جميع التحويلات محمية ومشفرة بالكامل' : 'All transfers are fully encrypted and protected' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('transferForm');
    const submitButton = document.getElementById('submitButton');
    const submitText = document.getElementById('submitText');
    const cardNumberInput = document.getElementById('receiver_card_number');
    const amountInput = document.getElementById('amount');
    const receiverInfo = document.getElementById('receiverInfo');
    const receiverName = document.getElementById('receiverName');
    const errorMessage = document.getElementById('errorMessage');
    const errorText = document.getElementById('errorText');
    
    // OTP Modal elements
    const otpModal = document.getElementById('otpModal');
    const otpInput = document.getElementById('otpInput');
    const otpError = document.getElementById('otpError');
    const closeOtpModal = document.getElementById('closeOtpModal');
    const verifyOtpButton = document.getElementById('verifyOtpButton');
    const resendOtpButton = document.getElementById('resendOtpButton');
    
    let receiverVerified = false;
    let receiverId = null;
    let otpCode = null;
    let verifyTimeout = null;

    // Auto-verify receiver
    async function autoVerifyReceiver(cardNumber) {
        // Validate card number format (16 digits with spaces)
        const cardNumberPattern = /^\d{4} \d{4} \d{4} \d{4}$/;
        if (!cardNumberPattern.test(cardNumber)) {
            return;
        }

        try {
            const response = await fetch('{{ route('client.wallet.verify-receiver') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({ card_number: cardNumber })
            });

            const data = await response.json();

            if (data.success) {
                receiverVerified = true;
                receiverId = data.receiver.id;
                receiverName.textContent = data.receiver.name;
                receiverInfo.classList.remove('hidden');
                submitButton.disabled = false;
                errorMessage.classList.add('hidden');
            } else {
                showError(data.message || '{{ app()->getLocale() == 'ar' ? 'رقم البطاقة غير صحيح' : 'Invalid card number' }}');
                receiverVerified = false;
                submitButton.disabled = true;
                receiverInfo.classList.add('hidden');
            }
        } catch (error) {
            showError('{{ app()->getLocale() == 'ar' ? 'حدث خطأ، الرجاء المحاولة مرة أخرى' : 'An error occurred, please try again' }}');
            receiverVerified = false;
            submitButton.disabled = true;
        }
    }

    // Format card number input and trigger auto-verification
    cardNumberInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\s/g, '');
        let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
        e.target.value = formattedValue;
        
        // Reset verification state
        receiverVerified = false;
        submitButton.disabled = true;
        receiverInfo.classList.add('hidden');
        
        // Clear previous timeout
        if (verifyTimeout) {
            clearTimeout(verifyTimeout);
        }
        
        // Auto-verify when card number is complete (19 characters including spaces)
        if (formattedValue.length === 19) {
            verifyTimeout = setTimeout(() => {
                autoVerifyReceiver(formattedValue);
            }, 300); // 300ms debounce
        }
    });

    // Calculate and display transfer fee
    const transferSummary = document.getElementById('transferSummary');
    const summaryAmount = document.getElementById('summaryAmount');
    const summaryFee = document.getElementById('summaryFee');
    const summaryTotal = document.getElementById('summaryTotal');

    amountInput.addEventListener('input', function() {
        const amount = parseFloat(this.value) || 0;
        
        if (amount > 0) {
            const fee = Math.round(amount * 0.01 * 100) / 100; // 1% fee
            const total = amount + fee;
            
            summaryAmount.textContent = '$' + amount.toFixed(2);
            summaryFee.textContent = '$' + fee.toFixed(2);
            summaryTotal.textContent = '$' + total.toFixed(2);
            transferSummary.classList.remove('hidden');
        } else {
            transferSummary.classList.add('hidden');
        }
    });

    // Hide error when user types
    [cardNumberInput, amountInput].forEach(input => {
        input.addEventListener('input', function() {
            errorMessage.classList.add('hidden');
        });
    });

    // Submit transfer
    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        if (!receiverVerified) {
            showError('{{ app()->getLocale() == 'ar' ? 'الرجاء التحقق من المستلم أولاً' : 'Please verify receiver first' }}');
            return;
        }

        const amount = parseFloat(amountInput.value);
        const fee = Math.round(amount * 0.01 * 100) / 100; // 1% fee
        const totalAmount = amount + fee;
        const maxBalance = parseFloat('{{ auth('client')->user()->wallet_balance }}');

        if (amount <= 0) {
            showError('{{ app()->getLocale() == 'ar' ? 'المبلغ يجب أن يكون أكبر من صفر' : 'Amount must be greater than zero' }}');
            return;
        }

        if (totalAmount > maxBalance) {
            showError('{{ app()->getLocale() == 'ar' ? 'رصيدك غير كافٍ (المبلغ + رسوم التحويل 1%)' : 'Insufficient balance (amount + 1% transfer fee)' }}');
            return;
        }

        submitButton.disabled = true;
        submitText.textContent = '{{ app()->getLocale() == 'ar' ? 'جاري الإرسال...' : 'Sending...' }}';

        // Send OTP and show modal
        try {
            const otpResponse = await fetch('{{ route('client.wallet.send-transfer-otp') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            });

            const otpData = await otpResponse.json();

            if (otpData.success) {
                // Show OTP modal
                otpModal.style.display = 'flex';
                otpInput.value = '';
                otpInput.focus();
                otpError.classList.add('hidden');
                submitButton.disabled = false;
                submitText.textContent = '{{ app()->getLocale() == 'ar' ? 'تحويل الآن' : 'Transfer Now' }}';
            } else {
                showError(otpData.message || '{{ app()->getLocale() == 'ar' ? 'فشل إرسال رمز التحقق' : 'Failed to send verification code' }}');
                submitButton.disabled = false;
                submitText.textContent = '{{ app()->getLocale() == 'ar' ? 'تحويل الآن' : 'Transfer Now' }}';
            }
        } catch (error) {
            showError('{{ app()->getLocale() == 'ar' ? 'حدث خطأ، الرجاء المحاولة مرة أخرى' : 'An error occurred, please try again' }}');
            submitButton.disabled = false;
            submitText.textContent = '{{ app()->getLocale() == 'ar' ? 'تحويل الآن' : 'Transfer Now' }}';
        }
    });

    // Close OTP Modal
    closeOtpModal.addEventListener('click', function() {
        otpModal.style.display = 'none';
        otpInput.value = '';
        otpError.classList.add('hidden');
    });

    // Resend OTP
    resendOtpButton.addEventListener('click', async function() {
        resendOtpButton.disabled = true;
        resendOtpButton.textContent = '{{ app()->getLocale() == 'ar' ? 'جاري الإرسال...' : 'Sending...' }}';

        try {
            const response = await fetch('{{ route('client.wallet.send-transfer-otp') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            });

            const data = await response.json();

            if (data.success) {
                otpInput.value = '';
                otpError.textContent = '{{ app()->getLocale() == 'ar' ? 'تم إرسال الرمز بنجاح' : 'Code sent successfully' }}';
                otpError.classList.remove('hidden');
                otpError.classList.remove('text-red-600', 'dark:text-red-400');
                otpError.classList.add('text-green-600', 'dark:text-green-400');
                setTimeout(() => {
                    otpError.classList.add('hidden');
                    otpError.classList.remove('text-green-600', 'dark:text-green-400');
                    otpError.classList.add('text-red-600', 'dark:text-red-400');
                }, 3000);
            } else {
                otpError.textContent = data.message || '{{ app()->getLocale() == 'ar' ? 'فشل إرسال رمز التحقق' : 'Failed to send verification code' }}';
                otpError.classList.remove('hidden');
            }
        } catch (error) {
            otpError.textContent = '{{ app()->getLocale() == 'ar' ? 'حدث خطأ، الرجاء المحاولة مرة أخرى' : 'An error occurred, please try again' }}';
            otpError.classList.remove('hidden');
        } finally {
            resendOtpButton.disabled = false;
            resendOtpButton.textContent = '{{ app()->getLocale() == 'ar' ? 'إعادة الإرسال' : 'Resend' }}';
        }
    });

    // Verify OTP and complete transfer
    verifyOtpButton.addEventListener('click', async function() {
        const code = otpInput.value.trim();
        
        if (!code || code.length !== 6) {
            otpError.textContent = '{{ app()->getLocale() == 'ar' ? 'الرجاء إدخال رمز مكون من 6 أرقام' : 'Please enter a 6-digit code' }}';
            otpError.classList.remove('hidden');
            return;
        }

        verifyOtpButton.disabled = true;
        verifyOtpButton.textContent = '{{ app()->getLocale() == 'ar' ? 'جاري التحويل...' : 'Processing...' }}';

        const formData = new FormData(form);
        formData.append('receiver_id', receiverId);
        formData.append('otp_code', code);

        try {
            const response = await fetch('{{ route('client.wallet.transfer') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                otpModal.style.display = 'none';
                showSuccessNotification(data.message);
                setTimeout(() => {
                    window.location.href = '{{ route('client.wallet') }}';
                }, 2000);
            } else {
                otpError.textContent = data.message || '{{ app()->getLocale() == 'ar' ? 'فشل التحويل' : 'Transfer failed' }}';
                otpError.classList.remove('hidden');
                verifyOtpButton.disabled = false;
                verifyOtpButton.innerHTML = '{{ app()->getLocale() == 'ar' ? 'تحقق وتحويل' : 'Verify & Transfer' }}';
            }
        } catch (error) {
            otpError.textContent = '{{ app()->getLocale() == 'ar' ? 'حدث خطأ، الرجاء المحاولة مرة أخرى' : 'An error occurred, please try again' }}';
            otpError.classList.remove('hidden');
            verifyOtpButton.disabled = false;
            verifyOtpButton.innerHTML = '{{ app()->getLocale() == 'ar' ? 'تحقق وتحويل' : 'Verify & Transfer' }}';
        }
    });

    // Allow only numbers in OTP input
    otpInput.addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/\D/g, '');
        otpError.classList.add('hidden');
    });

    function showError(message) {
        errorText.textContent = message;
        errorMessage.classList.remove('hidden');
        errorMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function showSuccessNotification(message) {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 {{ $rtl ? "right-4" : "left-4" }} md:{{ $rtl ? "right-8" : "left-8" }} z-50 transform transition-all duration-300 ease-in-out';
        notification.style.opacity = '0';
        notification.style.transform = 'translateY(-20px)';
        
        notification.innerHTML = `
            <div class="bg-green-600 text-white px-6 py-4 rounded-lg shadow-2xl flex items-center gap-3 min-w-[300px] max-w-md">
                <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1">
                    <p class="font-semibold text-sm">${message}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-white hover:text-green-100 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.style.opacity = '1';
            notification.style.transform = 'translateY(0)';
        }, 100);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateY(-20px)';
            setTimeout(() => notification.remove(), 300);
        }, 5000);
    }
});
</script>
@endsection
