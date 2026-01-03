@extends('frontend.client.layout')

@section('title', app()->getLocale() == 'ar' ? 'في انتظار الدفع - Pro Gineous' : 'Payment Pending - Pro Gineous')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            
            @php
                $paymentInfo = session('payment_info');
                $pendingTransaction = session('pending_transaction');
            @endphp

            @if($paymentInfo)
                <!-- Payment Instructions Card -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-2xl p-8 mb-6">
                    
                    <!-- Header -->
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-amber-500 to-orange-500 rounded-full mb-4">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">
                            {{ app()->getLocale() == 'ar' ? 'في انتظار الدفع' : 'Payment Pending' }}
                        </h1>
                        <p class="text-slate-600 dark:text-slate-400">
                            {{ app()->getLocale() == 'ar' ? 'يرجى استكمال الدفع باستخدام الكود أدناه' : 'Please complete the payment using the code below' }}
                        </p>
                    </div>

                    <!-- Payment Amount -->
                    @if($pendingTransaction && isset($pendingTransaction['amount']))
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl p-6 mb-6 text-center">
                            <p class="text-sm text-slate-600 dark:text-slate-400 mb-2">
                                {{ app()->getLocale() == 'ar' ? 'المبلغ المطلوب' : 'Amount Due' }}
                            </p>
                            <p class="text-4xl font-bold text-blue-600 dark:text-blue-400">
                                ${{ number_format($pendingTransaction['amount'], 2) }}
                            </p>
                        </div>
                    @endif

                    <!-- Fawry Payment Instructions -->
                    @if($paymentInfo['type'] === 'fawry')
                        <div class="space-y-6">
                            <!-- Fawry Code -->
                            <div class="text-center">
                                <p class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
                                    {{ app()->getLocale() == 'ar' ? 'كود فوري' : 'Fawry Code' }}
                                </p>
                                <div class="inline-flex items-center justify-center bg-slate-100 dark:bg-slate-700 rounded-2xl px-8 py-4">
                                    <span class="text-4xl font-bold text-slate-900 dark:text-white tracking-wider">
                                        {{ $paymentInfo['code'] }}
                                    </span>
                                </div>
                                @if(isset($paymentInfo['expire_date']))
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-3">
                                        {{ app()->getLocale() == 'ar' ? 'صالح حتى: ' : 'Valid until: ' }}{{ $paymentInfo['expire_date'] }}
                                    </p>
                                @endif
                            </div>

                            <!-- Instructions -->
                            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-6">
                                <h3 class="font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ app()->getLocale() == 'ar' ? 'خطوات الدفع' : 'Payment Steps' }}
                                </h3>
                                <ol class="space-y-3 text-sm text-slate-700 dark:text-slate-300">
                                    @if(app()->getLocale() == 'ar')
                                        <li class="flex gap-3">
                                            <span class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold">1</span>
                                            <span>توجه لأقرب فرع فوري</span>
                                        </li>
                                        <li class="flex gap-3">
                                            <span class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold">2</span>
                                            <span>اطلب الدفع برقم كود: <strong>{{ $paymentInfo['code'] }}</strong></span>
                                        </li>
                                        <li class="flex gap-3">
                                            <span class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold">3</span>
                                            <span>ادفع المبلغ المطلوب نقداً</span>
                                        </li>
                                        <li class="flex gap-3">
                                            <span class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold">4</span>
                                            <span>سيتم إضافة الرصيد تلقائياً بعد تأكيد الدفع</span>
                                        </li>
                                    @else
                                        <li class="flex gap-3">
                                            <span class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold">1</span>
                                            <span>Go to the nearest Fawry branch</span>
                                        </li>
                                        <li class="flex gap-3">
                                            <span class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold">2</span>
                                            <span>Request payment with code: <strong>{{ $paymentInfo['code'] }}</strong></span>
                                        </li>
                                        <li class="flex gap-3">
                                            <span class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold">3</span>
                                            <span>Pay the required amount in cash</span>
                                        </li>
                                        <li class="flex gap-3">
                                            <span class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold">4</span>
                                            <span>Your balance will be added automatically after payment confirmation</span>
                                        </li>
                                    @endif
                                </ol>
                            </div>
                        </div>
                    @endif

                    <!-- Aman Payment Instructions -->
                    @if($paymentInfo['type'] === 'aman')
                        <div class="space-y-6">
                            <div class="text-center">
                                <p class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
                                    {{ app()->getLocale() == 'ar' ? 'كود أمان' : 'Aman Code' }}
                                </p>
                                <div class="inline-flex items-center justify-center bg-slate-100 dark:bg-slate-700 rounded-2xl px-8 py-4">
                                    <span class="text-4xl font-bold text-slate-900 dark:text-white tracking-wider">
                                        {{ $paymentInfo['code'] }}
                                    </span>
                                </div>
                            </div>

                            <div class="bg-green-50 dark:bg-green-900/20 rounded-xl p-6">
                                <h3 class="font-bold text-slate-900 dark:text-white mb-4">
                                    {{ app()->getLocale() == 'ar' ? 'خطوات الدفع' : 'Payment Steps' }}
                                </h3>
                                <ol class="space-y-3 text-sm text-slate-700 dark:text-slate-300">
                                    @if(app()->getLocale() == 'ar')
                                        <li class="flex gap-3">
                                            <span class="flex-shrink-0 w-6 h-6 bg-green-600 text-white rounded-full flex items-center justify-center text-xs font-bold">1</span>
                                            <span>توجه لأقرب ماكينة أمان</span>
                                        </li>
                                        <li class="flex gap-3">
                                            <span class="flex-shrink-0 w-6 h-6 bg-green-600 text-white rounded-full flex items-center justify-center text-xs font-bold">2</span>
                                            <span>أدخل كود أمان: <strong>{{ $paymentInfo['code'] }}</strong></span>
                                        </li>
                                        <li class="flex gap-3">
                                            <span class="flex-shrink-0 w-6 h-6 bg-green-600 text-white rounded-full flex items-center justify-center text-xs font-bold">3</span>
                                            <span>أكمل عملية الدفع</span>
                                        </li>
                                    @else
                                        <li class="flex gap-3">
                                            <span class="flex-shrink-0 w-6 h-6 bg-green-600 text-white rounded-full flex items-center justify-center text-xs font-bold">1</span>
                                            <span>Go to the nearest Aman machine</span>
                                        </li>
                                        <li class="flex gap-3">
                                            <span class="flex-shrink-0 w-6 h-6 bg-green-600 text-white rounded-full flex items-center justify-center text-xs font-bold">2</span>
                                            <span>Enter Aman code: <strong>{{ $paymentInfo['code'] }}</strong></span>
                                        </li>
                                        <li class="flex gap-3">
                                            <span class="flex-shrink-0 w-6 h-6 bg-green-600 text-white rounded-full flex items-center justify-center text-xs font-bold">3</span>
                                            <span>Complete the payment process</span>
                                        </li>
                                    @endif
                                </ol>
                            </div>
                        </div>
                    @endif

                    <!-- Meeza/Mobile Wallet Instructions -->
                    @if($paymentInfo['type'] === 'meeza')
                        <div class="space-y-6">
                            <div class="text-center">
                                <p class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
                                    {{ app()->getLocale() == 'ar' ? 'رقم المرجع' : 'Reference Number' }}
                                </p>
                                <div class="inline-flex items-center justify-center bg-slate-100 dark:bg-slate-700 rounded-2xl px-8 py-4">
                                    <span class="text-3xl font-bold text-slate-900 dark:text-white tracking-wider">
                                        {{ $paymentInfo['reference'] }}
                                    </span>
                                </div>
                            </div>

                            @if(isset($paymentInfo['qr_code']))
                                <div class="text-center">
                                    <p class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
                                        {{ app()->getLocale() == 'ar' ? 'امسح الكود' : 'Scan QR Code' }}
                                    </p>
                                    <div class="inline-block bg-white p-4 rounded-2xl shadow-lg">
                                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($paymentInfo['qr_code']) }}" 
                                             alt="QR Code" 
                                             class="w-[200px] h-[200px]"
                                             loading="lazy">
                                    </div>
                                </div>
                            @endif

                            <div class="bg-purple-50 dark:bg-purple-900/20 rounded-xl p-6">
                                <h3 class="font-bold text-slate-900 dark:text-white mb-4">
                                    {{ app()->getLocale() == 'ar' ? 'خطوات الدفع' : 'Payment Steps' }}
                                </h3>
                                <ol class="space-y-3 text-sm text-slate-700 dark:text-slate-300">
                                    @if(app()->getLocale() == 'ar')
                                        <li class="flex gap-3">
                                            <span class="flex-shrink-0 w-6 h-6 bg-purple-600 text-white rounded-full flex items-center justify-center text-xs font-bold">1</span>
                                            <span>افتح تطبيق محفظتك الإلكترونية</span>
                                        </li>
                                        <li class="flex gap-3">
                                            <span class="flex-shrink-0 w-6 h-6 bg-purple-600 text-white rounded-full flex items-center justify-center text-xs font-bold">2</span>
                                            <span>امسح كود QR أو أدخل الرقم المرجعي</span>
                                        </li>
                                        <li class="flex gap-3">
                                            <span class="flex-shrink-0 w-6 h-6 bg-purple-600 text-white rounded-full flex items-center justify-center text-xs font-bold">3</span>
                                            <span>أكمل عملية الدفع</span>
                                        </li>
                                    @else
                                        <li class="flex gap-3">
                                            <span class="flex-shrink-0 w-6 h-6 bg-purple-600 text-white rounded-full flex items-center justify-center text-xs font-bold">1</span>
                                            <span>Open your mobile wallet app</span>
                                        </li>
                                        <li class="flex gap-3">
                                            <span class="flex-shrink-0 w-6 h-6 bg-purple-600 text-white rounded-full flex items-center justify-center text-xs font-bold">2</span>
                                            <span>Scan QR code or enter reference number</span>
                                        </li>
                                        <li class="flex gap-3">
                                            <span class="flex-shrink-0 w-6 h-6 bg-purple-600 text-white rounded-full flex items-center justify-center text-xs font-bold">3</span>
                                            <span>Complete the payment process</span>
                                        </li>
                                    @endif
                                </ol>
                            </div>
                        </div>
                    @endif

                    <!-- Basta/Masary Instructions -->
                    @if($paymentInfo['type'] === 'basta')
                        <div class="space-y-6">
                            <div class="text-center">
                                <p class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
                                    {{ app()->getLocale() == 'ar' ? 'كود مصاري' : 'Masary Code' }}
                                </p>
                                <div class="inline-flex items-center justify-center bg-slate-100 dark:bg-slate-700 rounded-2xl px-8 py-4">
                                    <span class="text-4xl font-bold text-slate-900 dark:text-white tracking-wider">
                                        {{ $paymentInfo['code'] }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex gap-4 mt-8">
                        <a href="{{ route('client.wallet') }}" class="flex-1 btn-secondary text-center">
                            {{ app()->getLocale() == 'ar' ? 'العودة للمحفظة' : 'Back to Wallet' }}
                        </a>
                        <a href="{{ route('client.dashboard') }}" class="flex-1 btn-primary text-center">
                            {{ app()->getLocale() == 'ar' ? 'الصفحة الرئيسية' : 'Dashboard' }}
                        </a>
                    </div>
                </div>

                <!-- Important Note -->
                <div class="bg-amber-50 dark:bg-amber-900/20 border-2 border-amber-200 dark:border-amber-800 rounded-2xl p-6">
                    <div class="flex gap-3">
                        <svg class="w-6 h-6 text-amber-600 dark:text-amber-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-amber-800 dark:text-amber-300 mb-2">
                                {{ app()->getLocale() == 'ar' ? 'ملاحظة هامة' : 'Important Note' }}
                            </p>
                            <p class="text-sm text-amber-700 dark:text-amber-400">
                                {{ app()->getLocale() == 'ar' 
                                    ? 'سيتم تحديث رصيدك تلقائياً بمجرد إتمام عملية الدف��. قد يستغرق الأمر بضع دقائق.'
                                    : 'Your balance will be updated automatically once the payment is completed. This may take a few minutes.' }}
                            </p>
                        </div>
                    </div>
                </div>

            @else
                <!-- No Payment Info -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-2xl p-12 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-slate-100 dark:bg-slate-700 rounded-full mb-6">
                        <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-4">
                        {{ app()->getLocale() == 'ar' ? 'لا توجد معلومات دفع' : 'No Payment Information' }}
                    </h2>
                    <p class="text-slate-600 dark:text-slate-400 mb-8">
                        {{ app()->getLocale() == 'ar' 
                            ? 'لم يتم العثور على معلومات الدفع. يرجى بدء عملية دفع جديدة.'
                            : 'No payment information found. Please start a new payment process.' }}
                    </p>
                    <a href="{{ route('client.wallet.add-funds') }}" class="btn-primary inline-block">
                        {{ app()->getLocale() == 'ar' ? 'إضافة رصيد' : 'Add Funds' }}
                    </a>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
