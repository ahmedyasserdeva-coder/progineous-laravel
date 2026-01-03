@extends('frontend.client.layout')

@section('title', __('Payment Pending'))

@section('content')
<div class="w-full">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header with Glass Effect -->
        <div class="mb-8 glass rounded-2xl p-6 shadow-custom">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent mb-3">
                @if(app()->getLocale() == 'ar')
                    في انتظار إتمام الدفع
                @else
                    Payment Pending
                @endif
            </h1>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('client.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">
                            <svg class="w-4 h-4 me-2.5" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                            @if(app()->getLocale() == 'ar')
                                لوحة التحكم
                            @else
                                Dashboard
                            @endif
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400 rtl:rotate-180" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ms-1 text-sm text-blue-600 md:ms-2 font-semibold">
                                @if(app()->getLocale() == 'ar')
                                    في انتظار الدفع
                                @else
                                    Payment Pending
                                @endif
                            </span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        @php
            $paymentInfo = session('order_payment_info');
            $paymentData = $paymentInfo['payment_data'] ?? [];
            $paymentMethodId = $paymentInfo['payment_method_id'] ?? null;
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Payment Code/Reference Card (if available) -->
                @if(!empty($paymentData))
                <div class="glass-dark rounded-2xl shadow-custom p-8 glow-blue">
                    @if($paymentMethodId == 3)
                        <!-- Fawry Code - Based on payment_method_id = 3 -->
                        <div class="text-center">
                            <div class="inline-block p-4 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full mb-4 shadow-lg glow-blue">
                                <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent mb-4">
                                @if(app()->getLocale() == 'ar')
                                    كود فوري
                                @else
                                    Fawry Code
                                @endif
                            </h3>
                            <div class="glass rounded-2xl p-8 my-6 shadow-depth border-2 border-blue-200">
                                <p class="text-sm text-gray-700 mb-3 font-semibold">
                                    @if(app()->getLocale() == 'ar')
                                        الرقم المرجعي للدفع
                                    @else
                                        Payment Reference Number
                                    @endif
                                </p>
                                <div class="flex items-center justify-between gap-4">
                                    <p class="text-5xl font-bold text-blue-600 font-mono tracking-wider">
                                        {{ $paymentData['fawryCode'] ?? $paymentData['meezaReference'] ?? $paymentData['reference'] ?? 'N/A' }}
                                    </p>
                                    <button onclick="copyPaymentReference()" class="p-4 bg-blue-100 hover:bg-blue-200 rounded-xl transition-all hover:scale-110 shadow-depth" title="Copy">
                                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                    @elseif($paymentMethodId == 12)
                        <!-- Aman Code - Based on payment_method_id = 12 -->
                        <div class="text-center">
                            <div class="inline-block p-4 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full mb-4 shadow-lg glow-blue">
                                <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-800 bg-clip-text text-transparent mb-4">
                                @if(app()->getLocale() == 'ar')
                                    كود امان
                                @else
                                    Aman Code
                                @endif
                            </h3>
                            <div class="glass rounded-2xl p-8 my-6 shadow-depth border-2 border-blue-200">
                                <p class="text-sm text-gray-700 mb-3 font-semibold">
                                    @if(app()->getLocale() == 'ar')
                                        الرقم المرجعي للدفع
                                    @else
                                        Payment Reference Number
                                    @endif
                                </p>
                                <div class="flex items-center justify-between gap-4">
                                    <p class="text-5xl font-bold text-blue-600 font-mono tracking-wider">{{ $paymentData['amanCode'] }}</p>
                                    <button onclick="copyPaymentReference()" class="p-4 bg-blue-100 hover:bg-blue-200 rounded-xl transition-all hover:scale-110 shadow-depth" title="Copy">
                                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                    @elseif($paymentMethodId == 4)
                        <!-- Mobile Wallet Reference - Based on payment_method_id = 4 - Minimal Design -->
                        <div class="space-y-6">
                            <!-- Header -->
                            <div class="flex items-center justify-center gap-3">
                                <div class="p-2 bg-blue-50 rounded-lg">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-800">
                                    @if(app()->getLocale() == 'ar')
                                        المحفظة الإلكترونية
                                    @else
                                        Mobile Wallet
                                    @endif
                                </h3>
                            </div>

                            <!-- Payment Reference Card -->
                            <div class="glass rounded-xl p-6 border border-blue-100 shadow-sm">
                                <label class="text-xs font-medium text-gray-500 uppercase tracking-wide block mb-3">
                                    @if(app()->getLocale() == 'ar')
                                        رقم الدفع
                                    @else
                                        Payment Reference
                                    @endif
                                </label>
                                <div class="flex items-center justify-between gap-4 p-4 bg-gradient-to-br from-blue-50 to-blue-100/50 rounded-lg border border-blue-200">
                                    <span class="text-3xl font-bold text-blue-600 font-mono tracking-wide">
                                        {{ $paymentData['meezaReference'] ?? $paymentData['mobileWalletNumber'] ?? $paymentData['reference'] ?? 'N/A' }}
                                    </span>
                                    <button onclick="copyPaymentReference()" class="p-2.5 bg-white hover:bg-blue-50 rounded-lg transition-all hover:scale-105 shadow-sm border border-blue-200" title="Copy">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            @if(!empty($paymentData['meezaQrCode']) || !empty($paymentData['qrCode']))
                            <!-- QR Code Section -->
                            <div class="glass rounded-xl p-6 border border-blue-100 shadow-sm">
                                <label class="text-xs font-medium text-gray-500 uppercase tracking-wide block mb-4 text-center">
                                    @if(app()->getLocale() == 'ar')
                                        امسح للدفع
                                    @else
                                        Scan to Pay
                                    @endif
                                </label>
                                <div class="flex justify-center">
                                    <div class="relative">
                                        @php
                                            $qrCodeData = $paymentData['meezaQrCode'] ?? $paymentData['qrCode'];
                                        @endphp
                                        <div class="p-4 bg-white rounded-xl shadow-sm border border-blue-100">
                                            {!! QrCode::size(200)->generate($qrCodeData) !!}
                                        </div>
                                        <!-- QR Code Corner Accents -->
                                        <div class="absolute top-0 left-0 w-6 h-6 border-t-2 border-l-2 border-blue-500 rounded-tl-lg"></div>
                                        <div class="absolute top-0 right-0 w-6 h-6 border-t-2 border-r-2 border-blue-500 rounded-tr-lg"></div>
                                        <div class="absolute bottom-0 left-0 w-6 h-6 border-b-2 border-l-2 border-blue-500 rounded-bl-lg"></div>
                                        <div class="absolute bottom-0 right-0 w-6 h-6 border-b-2 border-r-2 border-blue-500 rounded-br-lg"></div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-center gap-2 mt-4">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                                    <p class="text-xs text-gray-600 font-medium">
                                        @if(app()->getLocale() == 'ar')
                                            جاهز للمسح
                                        @else
                                            Ready to Scan
                                        @endif
                                    </p>
                                </div>
                            </div>
                            @endif
                        </div>
                        
                    @elseif(!empty($paymentData['masaryCode']) || !empty($paymentData['bastaCode']))
                        <!-- Basata Code -->
                        <div class="text-center">
                            <div class="inline-block p-4 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-full mb-4 shadow-lg glow-blue">
                                <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-cyan-800 bg-clip-text text-transparent mb-4">
                                @if(app()->getLocale() == 'ar')
                                    كود بساطة
                                @else
                                    Basata Code
                                @endif
                            </h3>
                            <div class="glass rounded-2xl p-8 my-6 shadow-depth border-2 border-blue-200">
                                <p class="text-sm text-gray-700 mb-3 font-semibold">
                                    @if(app()->getLocale() == 'ar')
                                        الرقم المرجعي للدفع
                                    @else
                                        Payment Reference Number
                                    @endif
                                </p>
                                <div class="flex items-center justify-between gap-4">
                                    <p class="text-5xl font-bold text-blue-600 font-mono tracking-wider">
                                        {{ $paymentData['masaryCode'] ?? $paymentData['bastaCode'] }}
                                    </p>
                                    <button onclick="copyPaymentReference()" class="p-4 bg-blue-100 hover:bg-blue-200 rounded-xl transition-all hover:scale-110 shadow-depth" title="Copy">
                                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                @endif

                <!-- Payment Status Card - Minimal Design -->
                <div class="glass rounded-xl shadow-sm p-5 border border-blue-100">
                    <!-- Status Header -->
                    <div class="flex items-center justify-between mb-5 pb-3.5 border-b border-gray-200">
                        <div class="flex items-center gap-2.5">
                            <div class="p-1.5 bg-blue-50 rounded-lg">
                                <svg class="w-4 h-4 text-blue-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-base font-semibold text-gray-800">
                                    @if(app()->getLocale() == 'ar')
                                        في انتظار الدفع
                                    @else
                                        Payment Pending
                                    @endif
                                </h2>
                                <p class="text-xs text-gray-500">
                                    @if(app()->getLocale() == 'ar')
                                        جاري انتظار التأكيد
                                    @else
                                        Awaiting confirmation
                                    @endif
                                </p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700 border border-yellow-200">
                            <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full mr-1.5 animate-pulse"></span>
                            @if(app()->getLocale() == 'ar')
                                قيد الانتظار
                            @else
                                Pending
                            @endif
                        </span>
                    </div>

                    <!-- Timer & Status Indicator -->
                    <div class="space-y-2.5 mb-5">
                        <!-- Countdown Timer -->
                        <div class="flex items-center justify-between p-2.5 bg-gradient-to-r from-yellow-50 to-orange-50 rounded-lg border border-yellow-200" id="timer-container">
                            <div class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-xs font-medium text-gray-700">
                                    @if(app()->getLocale() == 'ar')
                                        الوقت المتبقي
                                    @else
                                        Time Remaining
                                    @endif
                                </span>
                            </div>
                            <span class="text-xs font-bold text-yellow-800" id="remaining-time">60 minutes</span>
                        </div>

                        <!-- Status Check Indicator -->
                        <div class="flex items-center justify-between p-2.5 bg-blue-50 rounded-lg border border-blue-200 opacity-0 transition-opacity duration-300" id="check-indicator">
                            <div class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-blue-600 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span class="text-xs text-blue-700 font-medium">
                                    @if(app()->getLocale() == 'ar')
                                        جاري التحقق...
                                    @else
                                        Checking...
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                        
                    <!-- Payment Instructions -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg p-4 border border-blue-100">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 p-1.5 bg-white rounded-lg shadow-sm">
                                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h5 class="text-sm font-semibold text-blue-900 mb-1.5">
                                    @if(app()->getLocale() == 'ar')
                                        كيفية إتمام الدفع
                                    @else
                                        Payment Instructions
                                    @endif
                                </h5>
                                <p class="text-xs text-gray-700 leading-relaxed mb-2.5">
                                    @if(app()->getLocale() == 'ar')
                                        يرجى إكمال عملية الدفع من خلال الطريقة المختارة. سيتم تحديث حالة طلبك تلقائياً خلال دقائق.
                                    @else
                                        Please complete your payment using the selected method. Your order status will be updated automatically.
                                    @endif
                                </p>
                                
                                <!-- Time Limit Notice -->
                                <div class="flex items-start gap-2 p-2 bg-yellow-50 border border-yellow-200 rounded text-xs mb-2">
                                    <svg class="w-3.5 h-3.5 text-yellow-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-yellow-800 font-medium">
                                        @if(app()->getLocale() == 'ar')
                                            المهلة: 60 دقيقة من وقت الإنشاء
                                        @else
                                            Time limit: 60 minutes from creation
                                        @endif
                                    </span>
                                </div>
                                
                                <!-- Auto Check Notice -->
                                <div class="flex items-center gap-1.5 text-xs text-gray-600">
                                    <div class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-pulse"></div>
                                    <span>
                                        @if(app()->getLocale() == 'ar')
                                            التحقق التلقائي كل دقيقتين
                                        @else
                                            Auto-checking every 2 minutes
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items Card -->
                <div class="glass rounded-xl shadow-sm overflow-hidden border border-blue-100">
                    <div class="bg-blue-50 px-5 py-3.5 border-b border-blue-200">
                        <h3 class="text-base font-semibold text-gray-800 flex items-center gap-2.5">
                            <div class="p-1.5 bg-white rounded-lg shadow-sm">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            @if(app()->getLocale() == 'ar')
                                تفاصيل الطلب
                            @else
                                Order Details
                            @endif
                        </h3>
                    </div>
                    <div class="p-5">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 border-b border-gray-200">
                                    <tr>
                                        <th class="px-3 py-2.5 text-start text-xs font-semibold text-gray-700">
                                            @if(app()->getLocale() == 'ar')
                                                الخدمة / المنتج
                                            @else
                                                Item
                                            @endif
                                        </th>
                                        <th class="px-3 py-2.5 text-center text-xs font-semibold text-gray-700">
                                            @if(app()->getLocale() == 'ar')
                                                الكمية
                                            @else
                                                Qty
                                            @endif
                                        </th>
                                        <th class="px-3 py-2.5 text-end text-xs font-semibold text-gray-700">
                                            @if(app()->getLocale() == 'ar')
                                                السعر
                                            @else
                                                Price
                                            @endif
                                        </th>
                                        <th class="px-3 py-2.5 text-end text-xs font-semibold text-gray-700">
                                            @if(app()->getLocale() == 'ar')
                                                المجموع
                                            @else
                                                Total
                                            @endif
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($order->items as $item)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-3 py-3">
                                            @php
                                                // استخراج اسم المنتج والدومين من product_name
                                                $parts = explode(' - ', $item->product_name);
                                                $serviceName = $parts[0] ?? $item->product_name;
                                                $domain = $parts[1] ?? ($item->configuration['domain'] ?? null);
                                                
                                                // بناء عنوان المنتج - استخدام اسم الخطة مباشرة إن وجد
                                                if ($item->configuration['plan'] && !empty($item->configuration['plan'])) {
                                                    $displayName = $item->configuration['plan'];
                                                } elseif ($item->type === 'domain') {
                                                    $displayName = 'Domain Registration';
                                                } else {
                                                    $displayName = $serviceName;
                                                }
                                            @endphp
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $displayName }}
                                            </div>
                                            @if($item->configuration)
                                            <div class="text-xs text-gray-500 mt-0.5 space-y-0.5">
                                                @if($item->configuration['product_type'] && !empty($item->configuration['product_type']))
                                                    @php
                                                        // تنظيف نوع المنتج من التكرار
                                                        $productType = str_replace(['_hosting', ' Hosting', 'hosting'], '', $item->configuration['product_type']);
                                                        $productType = trim($productType, '_ ');
                                                        $productType = ucfirst($productType);
                                                    @endphp
                                                    <div class="text-blue-600 font-medium">{{ $productType }} Hosting</div>
                                                @endif
                                                @if($domain)
                                                    <div>🌐 {{ $domain }}</div>
                                                @elseif(isset($item->configuration['hostname']))
                                                    <div>🖥️ {{ $item->configuration['hostname'] }}</div>
                                                @endif
                                            </div>
                                            @endif
                                        </td>
                                        <td class="px-3 py-3 text-center text-sm text-gray-700">{{ $item->quantity }}</td>
                                        <td class="px-3 py-3 text-end text-sm text-gray-700">${{ number_format($item->unit_price, 2) }}</td>
                                        <td class="px-3 py-3 text-end text-sm font-medium text-gray-900">${{ number_format($item->subtotal, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="border-t border-gray-200 bg-gray-50">
                                    @if($order->discount > 0)
                                    <tr>
                                        <td colspan="3" class="px-3 py-2 text-end text-xs font-medium text-gray-700">
                                            @if(app()->getLocale() == 'ar')
                                                المجموع الفرعي:
                                            @else
                                                Subtotal:
                                            @endif
                                        </td>
                                        <td class="px-3 py-2 text-end text-sm text-gray-900">${{ number_format($order->subtotal, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="px-3 py-2 text-end text-xs font-medium text-gray-700">
                                            @if(app()->getLocale() == 'ar')
                                                الخصم:
                                            @else
                                                Discount:
                                            @endif
                                        </td>
                                        <td class="px-3 py-2 text-end text-sm text-red-600 font-medium">-${{ number_format($order->discount, 2) }}</td>
                                    </tr>
                                    @endif
                                    @if($order->tax > 0)
                                    <tr>
                                        <td colspan="3" class="px-3 py-2 text-end text-xs font-medium text-gray-700">
                                            @if(app()->getLocale() == 'ar')
                                                الضريبة:
                                            @else
                                                Tax:
                                            @endif
                                        </td>
                                        <td class="px-3 py-2 text-end text-sm text-gray-900">${{ number_format($order->tax, 2) }}</td>
                                    </tr>
                                    @endif
                                    <tr class="bg-blue-50 border-t border-blue-200">
                                        <td colspan="3" class="px-3 py-2.5 text-end text-sm font-bold text-gray-900">
                                            @if(app()->getLocale() == 'ar')
                                                الإجمالي:
                                            @else
                                                Total:
                                            @endif
                                        </td>
                                        <td class="px-3 py-2.5 text-end text-lg font-bold text-blue-600">${{ number_format(isset($order->targetInvoice) ? $order->targetInvoice->total : $order->total, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Order Info Card -->
                <div class="glass rounded-xl shadow-sm p-5 border border-blue-100">
                    <div class="flex items-center gap-2.5 mb-4 pb-3 border-b border-gray-200">
                        <div class="p-1.5 bg-blue-50 rounded-lg">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-base font-semibold text-gray-800">
                            @if(app()->getLocale() == 'ar')
                                معلومات الطلب
                            @else
                                Order Information
                            @endif
                        </h3>
                    </div>
                    
                    <div class="space-y-3.5">
                        <div class="p-3 bg-blue-50 rounded-lg border border-blue-100">
                            <label class="text-gray-600 text-xs block mb-1.5 font-medium">
                                @if(app()->getLocale() == 'ar')
                                    رقم الطلب
                                @else
                                    Order Number
                                @endif
                            </label>
                            <div class="text-lg font-bold text-blue-600">#{{ $order->id }}</div>
                        </div>
                        
                        <div class="p-3 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg border border-blue-200">
                            <label class="text-gray-600 text-xs block mb-1.5 font-medium">
                                @if(app()->getLocale() == 'ar')
                                    المبلغ المطلوب
                                @else
                                    Amount Due
                                @endif
                            </label>
                            <div class="text-2xl font-bold text-blue-600">${{ number_format(isset($order->targetInvoice) ? $order->targetInvoice->total : $order->total, 2) }}</div>
                        </div>

                        @if($order->payment_gateway_id)
                        <div class="p-3 bg-white rounded-lg border border-blue-200 shadow-sm">
                            <label class="text-gray-700 text-xs block mb-1.5 font-medium">
                                @if(app()->getLocale() == 'ar')
                                    رقم الفاتورة
                                @else
                                    Invoice ID
                                @endif
                            </label>
                            <div class="flex items-center justify-between gap-2">
                                <div class="font-mono text-sm font-semibold text-gray-800 break-all">{{ $order->payment_gateway_id }}</div>
                                <button onclick="copyInvoiceId()" class="p-1.5 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors flex-shrink-0" title="Copy">
                                    <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                </button>
                            </div>
                            <p class="text-gray-500 text-xs mt-1.5">
                                @if(app()->getLocale() == 'ar')
                                    رقم الفاتورة الداخلي
                                @else
                                    Internal invoice reference
                                @endif
                            </p>
                        </div>
                        @endif

                        <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <label class="text-gray-600 text-xs block mb-1.5 font-medium">
                                @if(app()->getLocale() == 'ar')
                                    تاريخ الطلب
                                @else
                                    Order Date
                                @endif
                            </label>
                            <div class="text-sm font-medium text-gray-700">{{ $order->created_at->format('Y-m-d H:i') }}</div>
                        </div>

                        <div class="p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                            <label class="text-gray-600 text-xs block mb-1.5 font-medium">
                                @if(app()->getLocale() == 'ar')
                                    حالة الدفع
                                @else
                                    Payment Status
                                @endif
                            </label>
                            <div class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-yellow-100 text-yellow-800 border border-yellow-300">
                                <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full mr-1.5 animate-pulse"></span>
                                @if(app()->getLocale() == 'ar')
                                    في الانتظار
                                @else
                                    Pending
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Instructions Card -->
                <div class="glass rounded-xl shadow-sm p-5 border border-blue-100">
                    <div class="flex items-center gap-2.5 mb-4 pb-3 border-b border-gray-200">
                        <div class="p-1.5 bg-blue-50 rounded-lg">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-base font-semibold text-gray-800">
                            @if(app()->getLocale() == 'ar')
                                خطوات الدفع
                            @else
                                Payment Steps
                            @endif
                        </h3>
                    </div>
                    
                    <div class="space-y-2.5">
                        @if(app()->getLocale() == 'ar')
                        <div class="flex items-start gap-2.5 p-2.5 bg-blue-50 rounded-lg border border-blue-100">
                            <div class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-bold">1</div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-800">توجه إلى نقطة الدفع</h4>
                                <p class="text-xs text-gray-600 mt-0.5">اذهب إلى أقرب نقطة (فوري، امان، بساطة) أو استخدم المحفظة</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-2.5 p-2.5 bg-blue-50 rounded-lg border border-blue-100">
                            <div class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-bold">2</div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-800">استخدم الرقم المرجعي</h4>
                                <p class="text-xs text-gray-600 mt-0.5">قدم الرقم المرجعي المذكور أعلاه</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-2.5 p-2.5 bg-blue-50 rounded-lg border border-blue-100">
                            <div class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-bold">3</div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-800">ادفع المبلغ</h4>
                                <p class="text-xs text-gray-600 mt-0.5">ادفع: <span class="font-semibold text-blue-600">${{ number_format(isset($order->targetInvoice) ? $order->targetInvoice->total : $order->total, 2) }}</span></p>
                            </div>
                        </div>
                        <div class="flex items-start gap-2.5 p-2.5 bg-green-50 rounded-lg border border-green-100">
                            <div class="flex-shrink-0 w-6 h-6 rounded-full bg-green-600 text-white flex items-center justify-center text-xs font-bold">4</div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-800">انتظر التأكيد</h4>
                                <p class="text-xs text-gray-600 mt-0.5">سيتم التأكيد تلقائياً خلال دقائق</p>
                            </div>
                        </div>
                        @else
                        <div class="flex items-start gap-2.5 p-2.5 bg-blue-50 rounded-lg border border-blue-100">
                            <div class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-bold">1</div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-800">Go to Payment Point</h4>
                                <p class="text-xs text-gray-600 mt-0.5">Visit Fawry, Aman, Basata or use mobile wallet</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-2.5 p-2.5 bg-blue-50 rounded-lg border border-blue-100">
                            <div class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-bold">2</div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-800">Use Reference Number</h4>
                                <p class="text-xs text-gray-600 mt-0.5">Provide the reference number shown above</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-2.5 p-2.5 bg-blue-50 rounded-lg border border-blue-100">
                            <div class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-bold">3</div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-800">Pay Amount</h4>
                                <p class="text-xs text-gray-600 mt-0.5">Pay: <span class="font-semibold text-blue-600">${{ number_format(isset($order->targetInvoice) ? $order->targetInvoice->total : $order->total, 2) }}</span></p>
                            </div>
                        </div>
                        <div class="flex items-start gap-2.5 p-2.5 bg-green-50 rounded-lg border border-green-100">
                            <div class="flex-shrink-0 w-6 h-6 rounded-full bg-green-600 text-white flex items-center justify-center text-xs font-bold">4</div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-800">Wait for Confirmation</h4>
                                <p class="text-xs text-gray-600 mt-0.5">Will be confirmed automatically within minutes</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Help Card -->
                <div class="glass rounded-xl shadow-sm p-5 border border-blue-100">
                    <div class="text-center">
                        <div class="inline-flex p-2 bg-blue-50 rounded-lg mb-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-base text-gray-800 mb-1.5">
                            @if(app()->getLocale() == 'ar')
                                هل تحتاج مساعدة؟
                            @else
                                Need Help?
                            @endif
                        </h3>
                        <p class="text-xs text-gray-600 mb-4">
                            @if(app()->getLocale() == 'ar')
                                إذا واجهت أي مشكلة، تواصل معنا
                            @else
                                Contact us if you face any issues
                            @endif
                        </p>
                        <a href="#" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors w-full">
                            <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            @if(app()->getLocale() == 'ar')
                                تواصل مع الدعم
                            @else
                                Contact Support
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyInvoiceId() {
    const invoiceId = '{{ $order->payment_gateway_id }}';
    navigator.clipboard.writeText(invoiceId).then(() => {
        // Show success feedback
        const btn = event.currentTarget;
        const originalHTML = btn.innerHTML;
        btn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
        btn.classList.add('bg-green-500');
        
        setTimeout(() => {
            btn.innerHTML = originalHTML;
            btn.classList.remove('bg-green-500');
        }, 2000);
    });
}

@if(!empty($paymentData))
function copyPaymentReference() {
    @if(!empty($paymentData['fawryCode']))
        const reference = '{{ $paymentData['fawryCode'] }}';
    @elseif(!empty($paymentData['amanCode']))
        const reference = '{{ $paymentData['amanCode'] }}';
    @elseif(!empty($paymentData['meezaReference']))
        const reference = '{{ $paymentData['meezaReference'] }}';
    @elseif(!empty($paymentData['mobileWalletNumber']))
        const reference = '{{ $paymentData['mobileWalletNumber'] }}';
    @elseif(!empty($paymentData['masaryCode']))
        const reference = '{{ $paymentData['masaryCode'] }}';
    @elseif(!empty($paymentData['bastaCode']))
        const reference = '{{ $paymentData['bastaCode'] }}';
    @else
        const reference = '';
    @endif
    
    if (reference) {
        navigator.clipboard.writeText(reference).then(() => {
            // Show success feedback
            const btn = event.currentTarget;
            const originalHTML = btn.innerHTML;
            btn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
            btn.classList.add('bg-green-500');
            
            setTimeout(() => {
                btn.innerHTML = originalHTML;
                btn.classList.remove('bg-green-500');
            }, 2000);
        });
    }
}
@endif

// Auto-check payment status every 30 seconds
let checkStatusInterval;
let timeoutTimer;
const CHECK_INTERVAL = 30000; // 30 seconds
const TIMEOUT_DURATION = 3600000; // 60 minutes

function checkPaymentStatus() {
    // Show checking indicator
    const indicator = document.getElementById('check-indicator');
    if (indicator) {
        indicator.style.opacity = '1';
    }
    
    fetch('{{ route("payment.check-status", $order->id) }}', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log('Payment status check:', data);
        
        // Hide checking indicator
        setTimeout(() => {
            if (indicator) {
                indicator.style.opacity = '0';
            }
        }, 1000);
        
        if (data.success) {
            if (data.status === 'paid') {
                // Payment successful - redirect to success page
                clearInterval(checkStatusInterval);
                clearTimeout(timeoutTimer);
                
                // Show success message before redirect
                if (indicator) {
                    indicator.innerHTML = '<svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><span class="text-xs text-green-700 font-medium">@if(app()->getLocale() == 'ar') تم الدفع بنجاح! @else Payment successful! @endif</span>';
                    indicator.className = indicator.className.replace('bg-blue-50 border-blue-200', 'bg-green-50 border-green-200');
                }
                
                setTimeout(() => {
                    window.location.href = data.redirect_url;
                }, 1500);
                
            } else if (data.status === 'failed' || data.status === 'timeout') {
                // Payment failed or timeout - redirect to failed page
                clearInterval(checkStatusInterval);
                clearTimeout(timeoutTimer);
                
                setTimeout(() => {
                    window.location.href = data.redirect_url;
                }, 1500);
                
            } else if (data.status === 'pending') {
                // Still pending - show remaining time
                if (data.minutes_remaining !== undefined) {
                    updateRemainingTime(data.minutes_remaining);
                }
            }
        }
    })
    .catch(error => {
        console.error('Error checking payment status:', error);
        
        // Hide checking indicator on error
        if (indicator) {
            indicator.style.opacity = '0';
        }
    });
}

function updateRemainingTime(minutes) {
    const timeElement = document.getElementById('remaining-time');
    if (timeElement) {
        // Round minutes to nearest integer
        const totalMinutes = Math.floor(minutes);
        const hours = Math.floor(totalMinutes / 60);
        const mins = totalMinutes % 60;
        
        @if(app()->getLocale() == 'ar')
            if (hours > 0) {
                timeElement.textContent = `${hours} ساعة و ${mins} دقيقة`;
            } else {
                timeElement.textContent = `${mins} دقيقة`;
            }
        @else
            if (hours > 0) {
                timeElement.textContent = `${hours}h ${mins}m`;
            } else {
                timeElement.textContent = `${mins} minutes`;
            }
        @endif
        
        // Change color based on remaining time
        const parent = timeElement.parentElement.parentElement;
        if (totalMinutes < 10) {
            parent.className = parent.className.replace('from-yellow-100 to-yellow-200', 'from-red-100 to-red-200');
            parent.className = parent.className.replace('border-yellow-300', 'border-red-300');
            timeElement.className = timeElement.className.replace('text-yellow-900', 'text-red-900');
        } else if (totalMinutes < 30) {
            parent.className = parent.className.replace('from-yellow-100 to-yellow-200', 'from-orange-100 to-orange-200');
            parent.className = parent.className.replace('border-yellow-300', 'border-orange-300');
            timeElement.className = timeElement.className.replace('text-yellow-900', 'text-orange-900');
        }
    }
}

// Calculate initial remaining time
function calculateRemainingMinutes() {
    const orderCreatedAt = new Date('{{ $order->created_at->toIso8601String() }}');
    const now = new Date();
    const minutesPassed = Math.floor((now - orderCreatedAt) / 1000 / 60);
    return Math.max(0, 60 - minutesPassed);
}

// Start checking payment status when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Update initial remaining time
    const initialMinutes = calculateRemainingMinutes();
    updateRemainingTime(initialMinutes);
    
    // Update countdown every minute
    setInterval(function() {
        const minutes = calculateRemainingMinutes();
        updateRemainingTime(minutes);
        
        if (minutes <= 0) {
            clearInterval(checkStatusInterval);
            checkPaymentStatus(); // Final check
        }
    }, 60000); // Update every minute
    
    // Wait 10 seconds before first check to give Fawaterak time to process
    setTimeout(function() {
        checkPaymentStatus();
        
        // Then check every 120 seconds
        checkStatusInterval = setInterval(checkPaymentStatus, CHECK_INTERVAL);
    }, 10000); // 10 second delay before first check
    
    // Set timeout to stop checking after 60 minutes
    timeoutTimer = setTimeout(function() {
        clearInterval(checkStatusInterval);
        console.log('Payment timeout - 60 minutes exceeded');
        // Force check one last time
        checkPaymentStatus();
    }, TIMEOUT_DURATION);
});

// Cleanup on page unload
window.addEventListener('beforeunload', function() {
    if (checkStatusInterval) {
        clearInterval(checkStatusInterval);
    }
    if (timeoutTimer) {
        clearTimeout(timeoutTimer);
    }
});
</script>
@endsection
