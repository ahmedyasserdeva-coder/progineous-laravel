@extends('frontend.client.layout')

@section('title', __('frontend.invoice') . ' #' . $invoice->invoice_number . ' - ' . config('app.name'))

@php
    // Check if invoice contains domain registration
    $hasDomainRegistration = false;
    $lastPaymentAttemptAt = session('payment_created_at');
    $canRetryPayment = true;
    
    foreach($invoice->order->items as $item) {
        if (stripos($item->product_name, 'domain registration') !== false || 
            stripos($item->product_name, 'تسجيل دومين') !== false ||
            $item->product_type === 'domain') {
            $hasDomainRegistration = true;
            break;
        }
    }
    
    // If has domain registration and no recent payment attempt
    if ($hasDomainRegistration && $invoice->status !== 'paid') {
        // If there's a payment attempt timestamp, check if within 60 minutes
        if ($lastPaymentAttemptAt) {
            $minutesSinceAttempt = \Carbon\Carbon::parse($lastPaymentAttemptAt)->diffInMinutes(now());
            if ($minutesSinceAttempt > 60) {
                $canRetryPayment = false;
            }
        } else {
            // No payment attempt yet, check order creation time
            $minutesSinceCreation = $invoice->order->created_at->diffInMinutes(now());
            if ($minutesSinceCreation > 60) {
                $canRetryPayment = false;
            }
        }
    }
@endphp

@section('content')
<div class="min-h-screen py-8 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('client.invoices') }}" class="inline-flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>{{ __('frontend.back_to_invoices') }}</span>
            </a>
        </div>

        <!-- Invoice Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
            
            <!-- Invoice Header -->
            <div class="border-b border-gray-200 dark:border-gray-700 px-8 py-8 bg-gray-50/50 dark:bg-gray-900/50">
                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6">
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">{{ __('frontend.invoice') }}</p>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">
                                #{{ $invoice->invoice_number }}
                            </h1>
                        </div>
                        @if($invoice->status === 'paid')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-600 dark:bg-green-400"></span>
                                {{ __('frontend.paid') }}
                            </span>
                        @elseif($invoice->status === 'pending')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-600 dark:bg-yellow-400"></span>
                                {{ __('frontend.pending') }}
                            </span>
                        @elseif($invoice->status === 'cancelled')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-full bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-600 dark:bg-red-400"></span>
                                {{ __('frontend.cancelled') }}
                            </span>
                        @endif
                    </div>
                    
                    <div class="flex gap-2">
                        @if($invoice->status !== 'paid' && $canRetryPayment)
                        <button type="button" onclick="openPaymentModal()" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            <span>{{ __('frontend.pay_now') }}</span>
                        </button>
                        @elseif($invoice->status !== 'paid' && !$canRetryPayment)
                        <div class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <span>
                                @if(app()->getLocale() == 'ar')
                                    انتهت مهلة الدفع
                                @else
                                    Payment Expired
                                @endif
                            </span>
                        </div>
                        @endif
                        <a href="{{ route('client.invoices.download', $invoice->id) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span>{{ __('frontend.download_pdf') }}</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Payment Timeout Warning for Domain Registration -->
            @if($hasDomainRegistration && !$canRetryPayment && $invoice->status !== 'paid')
            <div class="mx-8 mb-8 p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg">
                <div class="flex gap-3">
                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-sm font-semibold text-amber-900 dark:text-amber-300 mb-1">
                            @if(app()->getLocale() == 'ar')
                                انتهت مهلة الدفع
                            @else
                                Payment Period Expired
                            @endif
                        </h3>
                        <p class="text-sm text-amber-800 dark:text-amber-400">
                            @if(app()->getLocale() == 'ar')
                                هذه الفاتورة تحتوي على تسجيل دومين جديد. مهلة الدفع (60 دقيقة) انتهت ولا يمكن إعادة المحاولة. يرجى التواصل مع الدعم الفني لإنشاء طلب جديد.
                            @else
                                This invoice contains a new domain registration. The payment period (60 minutes) has expired and cannot be retried. Please contact support to create a new order.
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Invoice Details -->
            <div class="p-8">
                
                <!-- Client Info & Pay To -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 pb-8 border-b border-gray-200 dark:border-gray-700">
                    <!-- Invoiced To -->
                    <div>
                        <h2 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">
                            {{ __('frontend.invoiced_to') }}
                        </h2>
                        
                        <div class="bg-gray-50 dark:bg-gray-900/50 rounded-lg p-5 space-y-2.5">
                            <div class="text-base font-semibold text-gray-900 dark:text-white">
                                {{ $invoice->client->full_name ?? 'N/A' }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                {{ $invoice->client->email ?? 'N/A' }}
                            </div>
                            @if($invoice->client->phone)
                            <div class="text-sm text-gray-600 dark:text-gray-400" dir="ltr">
                                {{ $invoice->client->phone }}
                            </div>
                            @endif
                            @if($invoice->client->company_name)
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                {{ $invoice->client->company_name }}
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Pay To -->
                    <div>
                        <h2 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">
                            {{ __('frontend.pay_to') }}
                        </h2>
                        
                        <div class="bg-gray-50 dark:bg-gray-900/50 rounded-lg p-5 space-y-2.5">
                            <div class="text-base font-semibold text-gray-900 dark:text-white">
                                {{ config('app.name', 'Company Name') }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                <span class="font-medium">{{ __('frontend.reg_no') }}:</span> 90088
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                <span class="font-medium">{{ __('frontend.vat') }}:</span> 755-552-334
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                Bani Waldin Ihsanan Tower - 3rd Floor, Mostafa Kamel Street, Beni Suef Center, Beni Suef Governorate
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Dates -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    <div class="bg-gray-50 dark:bg-gray-900/50 rounded-lg px-4 py-3.5 border-l-2 border-blue-500">
                        <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1.5">
                            {{ __('frontend.invoice_date') }}
                        </div>
                        <div class="text-sm font-semibold text-gray-900 dark:text-white">
                            {{ $invoice->invoice_date->format('M d, Y') }}
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 dark:bg-gray-900/50 rounded-lg px-4 py-3.5 border-l-2 border-purple-500">
                        <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1.5">
                            {{ __('frontend.due_date') }}
                        </div>
                        <div class="text-sm font-semibold text-gray-900 dark:text-white">
                            {{ $invoice->due_date->format('M d, Y') }}
                        </div>
                    </div>
                    
                    @if($invoice->paid_at)
                    <div class="bg-green-50 dark:bg-green-900/20 rounded-lg px-4 py-3.5 border-l-2 border-green-500">
                        <div class="text-xs font-semibold text-green-700 dark:text-green-400 uppercase tracking-wide mb-1.5">
                            {{ __('frontend.paid_date') }}
                        </div>
                        <div class="text-sm font-semibold text-green-700 dark:text-green-400">
                            {{ $invoice->paid_at->format('M d, Y') }}
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Order Items -->
                @if($invoice->order && $invoice->order->items->count() > 0)
                <div class="mb-8">
                    <h2 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">
                        {{ __('frontend.order_items') }}
                    </h2>
                    
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900/50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                        {{ __('frontend.item') }}
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                        {{ __('frontend.qty') }}
                                    </th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                        {{ __('frontend.price') }}
                                    </th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                        {{ __('frontend.total') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($invoice->order->items as $item)
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="text-sm text-gray-900 dark:text-white">
                                            {{ $item->product_name ?? $item->item_name ?? 'N/A' }}
                                        </div>
                                        @if($item->description)
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                            {{ $item->description }}
                                        </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                        {{ $item->quantity ?? 1 }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-sm text-gray-900 dark:text-white">
                                        {{ number_format($item->unit_price ?? 0, 2) }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-sm font-medium text-gray-900 dark:text-white">
                                        {{ number_format($item->total ?? (($item->unit_price ?? 0) * ($item->quantity ?? 1)), 2) }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                <!-- Invoice Summary -->
                <div class="flex justify-end mb-8">
                    <div class="w-full md:w-96 bg-gray-50 dark:bg-gray-900/50 rounded-lg p-6 space-y-3">
                        <div class="flex justify-between py-2 text-sm">
                            <span class="text-gray-600 dark:text-gray-400">{{ __('frontend.subtotal') }}</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($invoice->subtotal, 2) }} {{ $invoice->currency ?? 'EGP' }}</span>
                        </div>
                        
                        @if($invoice->tax > 0)
                        <div class="flex justify-between py-2 text-sm">
                            <span class="text-gray-600 dark:text-gray-400">{{ __('frontend.tax') }}</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ number_format($invoice->tax, 2) }} {{ $invoice->currency ?? 'EGP' }}</span>
                        </div>
                        @endif
                        
                        @if($invoice->discount > 0)
                        <div class="flex justify-between py-2 text-sm">
                            <span class="text-gray-600 dark:text-gray-400">{{ __('frontend.discount') }}</span>
                            <span class="font-medium text-green-600 dark:text-green-400">-{{ number_format($invoice->discount, 2) }} {{ $invoice->currency ?? 'EGP' }}</span>
                        </div>
                        @endif
                        
                        <div class="flex justify-between pt-4 mt-3 border-t-2 border-gray-300 dark:border-gray-600">
                            <span class="text-base font-bold text-gray-900 dark:text-white">{{ __('frontend.total') }}</span>
                            <span class="text-lg font-bold text-gray-900 dark:text-white">{{ number_format($invoice->total, 2) }} {{ $invoice->currency ?? 'EGP' }}</span>
                        </div>
                        
                        @if($invoice->paid_amount > 0)
                        <div class="flex justify-between py-2.5 text-sm bg-green-100/80 dark:bg-green-900/30 px-4 -mx-6 mt-3 rounded-lg">
                            <span class="font-medium text-green-700 dark:text-green-400">{{ __('frontend.paid_amount') }}</span>
                            <span class="font-bold text-green-700 dark:text-green-400">{{ number_format($invoice->paid_amount, 2) }} {{ $invoice->currency ?? 'EGP' }}</span>
                        </div>
                        @endif
                        
                        @if($invoice->balance > 0)
                        <div class="flex justify-between py-2.5 text-sm bg-red-100/80 dark:bg-red-900/30 px-4 -mx-6 rounded-lg">
                            <span class="font-medium text-red-700 dark:text-red-400">{{ __('frontend.balance_due') }}</span>
                            <span class="font-bold text-red-700 dark:text-red-400">{{ number_format($invoice->balance, 2) }} {{ $invoice->currency ?? 'EGP' }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Notes -->
                @if($invoice->notes)
                <div class="mt-8 p-5 bg-blue-50/50 dark:bg-blue-900/10 border-l-2 border-blue-500 rounded-lg">
                    <div class="text-xs font-semibold text-blue-700 dark:text-blue-400 uppercase tracking-wide mb-2">
                        {{ __('frontend.notes') }}
                    </div>
                    <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
                        {{ $invoice->notes }}
                    </p>
                </div>
                @endif

                <!-- Transaction History -->
                @php
                    $transactions = $invoice->getAllTransactions();
                @endphp
                
                @if($transactions->count() > 0)
                <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                    <h2 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">
                        {{ __('frontend.transaction_history') }}
                    </h2>

                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900/50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                        {{ __('frontend.date') }}
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                        {{ __('frontend.gateway') }}
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                        {{ __('frontend.transaction_id') }}
                                    </th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                        {{ __('frontend.amount') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($transactions as $transaction)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($transaction['date'])->format('M d, Y') }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                        {{ $transaction['gateway'] }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400 font-mono">
                                        {{ $transaction['transaction_id'] }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-sm font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ number_format($transaction['amount'], 2) }} {{ $transaction['currency'] }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

            </div>
        </div>

    </div>
</div>

<style>
@media print {
    /* Hide everything in layout except content */
    .client-sidebar,
    .client-sidebar-overlay,
    header,
    footer,
    nav:not(.invoice-nav),
    aside,
    .preloader {
        display: none !important;
    }
    
    /* Force layout container to block */
    .client-layout-container {
        display: block !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    
    /* Make main content full width */
    .client-main-content {
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
    }
    
    .client-main-content > div {
        max-width: 100% !important;
        min-height: auto !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    
    /* Hide back button and action buttons */
    .mb-6,
    a[href*="download"],
    button[onclick*="print"] {
        display: none !important;
    }
    
    /* Reset page styles */
    * {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }
    
    html, body {
        background: white !important;
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
    }
    
    body::before {
        display: none !important;
    }
    
    /* Content area - reduce padding */
    .min-h-screen {
        min-height: auto !important;
        padding: 5mm !important;
        background: white !important;
    }
    
    .max-w-4xl {
        max-width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    
    /* Invoice card - remove extra spacing */
    .bg-white, .dark\:bg-gray-800 {
        background: white !important;
        border: none !important;
        box-shadow: none !important;
    }
    
    /* Reduce padding in invoice sections */
    .px-8 {
        padding-left: 15px !important;
        padding-right: 15px !important;
    }
    
    .py-8 {
        padding-top: 15px !important;
        padding-bottom: 15px !important;
    }
    
    .p-8 {
        padding: 15px !important;
    }
    
    .mb-8 {
        margin-bottom: 15px !important;
    }
    
    .pb-8 {
        padding-bottom: 15px !important;
    }
    
    .space-y-3 > * + * {
        margin-top: 8px !important;
    }
    
    .gap-6 {
        gap: 15px !important;
    }
    
    .bg-gray-50\/50, .dark\:bg-gray-900\/50,
    .bg-gray-50, .dark\:bg-gray-900\/50 {
        background: #fafafa !important;
    }
    
    /* Text colors */
    .text-gray-600, .text-gray-700, .text-gray-900,
    .dark\:text-gray-400, .dark\:text-white {
        color: #000 !important;
    }
    
    .text-gray-500, .dark\:text-gray-400 {
        color: #666 !important;
    }
    
    /* Borders */
    .border-gray-200, .dark\:border-gray-700 {
        border-color: #ddd !important;
    }
    
    /* Status badges */
    .bg-green-100 { background-color: #d1fae5 !important; }
    .text-green-700, .dark\:text-green-400 { color: #065f46 !important; }
    .bg-green-600, .dark\:bg-green-400 { background-color: #059669 !important; }
    
    .bg-yellow-100 { background-color: #fef3c7 !important; }
    .text-yellow-700, .dark\:text-yellow-400 { color: #92400e !important; }
    .bg-yellow-600, .dark\:bg-yellow-400 { background-color: #d97706 !important; }
    
    .bg-red-100 { background-color: #fee2e2 !important; }
    .text-red-700, .dark\:text-red-400 { color: #991b1b !important; }
    .bg-red-600, .dark\:bg-red-400 { background-color: #dc2626 !important; }
    
    /* Remove shadows and rounded corners */
    .shadow-sm, .shadow, .rounded-lg { 
        box-shadow: none !important; 
        border-radius: 0 !important;
    }
    
    /* Reduce table padding */
    .px-4 {
        padding-left: 8px !important;
        padding-right: 8px !important;
    }
    
    .py-3, .py-4 {
        padding-top: 6px !important;
        padding-bottom: 6px !important;
    }
    
    /* Tables */
    table { 
        page-break-inside: auto !important;
        font-size: 0.9em !important;
    }
    tr { 
        page-break-inside: avoid !important; 
        page-break-after: auto !important; 
    }
    
    /* Prevent page breaks in important sections */
    .border-b { 
        page-break-after: avoid !important; 
    }
    
    /* Keep sections together */
    .grid {
        page-break-inside: avoid !important;
    }
    
    /* Page settings */
    @page {
        size: A4;
        margin: 8mm;
    }
}
</style>

<!-- Payment Method Modal -->
@if($invoice->status !== 'paid')
<div id="paymentModal" class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full transform transition-all">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('frontend.select_payment_method') }}</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ __('frontend.choose_payment_method') }}</p>
        </div>
        
        <form id="paymentForm" action="{{ route('order.retry-payment', $invoice->order_id) }}" method="POST" class="p-6">
            @csrf
            <input type="hidden" name="payment_method_id" id="selectedPaymentMethod" value="">
            <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
            
            <div class="space-y-3">
                <!-- Account Wallet -->
                <label class="flex items-center p-4 border-2 border-gray-200 dark:border-gray-700 rounded-xl hover:border-green-500 dark:hover:border-green-500 cursor-pointer transition-all group">
                    <input type="radio" name="payment_option" value="wallet" class="w-5 h-5 text-green-600 focus:ring-green-500" required>
                    <div class="ml-3 {{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                        <div class="flex items-center gap-2">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ __('frontend.account_wallet') }}</span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            @if(app()->getLocale() == 'ar')
                                الرصيد المتاح: ${{ number_format(Auth::guard('client')->user()->wallet_balance ?? 0, 2) }}
                            @else
                                Available Balance: ${{ number_format(Auth::guard('client')->user()->wallet_balance ?? 0, 2) }}
                            @endif
                        </p>
                    </div>
                </label>
                
                <!-- Credit Card -->
                <label class="flex items-center p-4 border-2 border-gray-200 dark:border-gray-700 rounded-xl hover:border-blue-500 dark:hover:border-blue-500 cursor-pointer transition-all group">
                    <input type="radio" name="payment_option" value="2" class="w-5 h-5 text-blue-600 focus:ring-blue-500" required>
                    <div class="ml-3 {{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                        <div class="flex items-center gap-2">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ __('frontend.credit_card') }}</span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Visa, Mastercard</p>
                    </div>
                </label>
                
                <!-- Fawry -->
                <label class="flex items-center p-4 border-2 border-gray-200 dark:border-gray-700 rounded-xl hover:border-blue-500 dark:hover:border-blue-500 cursor-pointer transition-all group">
                    <input type="radio" name="payment_option" value="3" class="w-5 h-5 text-blue-600 focus:ring-blue-500">
                    <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                        <div class="flex items-center gap-2">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ __('frontend.fawry') }}</span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Pay at Fawry stores</p>
                    </div>
                </label>
                
                <!-- Mobile Wallet -->
                <label class="flex items-center p-4 border-2 border-gray-200 dark:border-gray-700 rounded-xl hover:border-blue-500 dark:hover:border-blue-500 cursor-pointer transition-all group">
                    <input type="radio" name="payment_option" value="4" class="w-5 h-5 text-blue-600 focus:ring-blue-500">
                    <div class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} flex-1">
                        <div class="flex items-center gap-2">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ __('frontend.mobile_wallet') }}</span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Vodafone Cash, Orange Money</p>
                    </div>
                </label>
            </div>
            
            <div class="flex gap-3 mt-6">
                <button type="button" onclick="closePaymentModal()" class="flex-1 px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">
                    {{ __('frontend.cancel') }}
                </button>
                <button type="submit" class="flex-1 px-4 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 rounded-lg transition-all">
                    {{ __('frontend.proceed_payment') }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openPaymentModal() {
    document.getElementById('paymentModal').classList.remove('hidden');
    document.getElementById('paymentModal').classList.add('flex');
}

function closePaymentModal() {
    document.getElementById('paymentModal').classList.add('hidden');
    document.getElementById('paymentModal').classList.remove('flex');
}

// Update hidden input when radio changes
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('paymentForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const selectedRadio = document.querySelector('input[name="payment_option"]:checked');
            if (selectedRadio) {
                document.getElementById('selectedPaymentMethod').value = selectedRadio.value;
            }
        });
    }
});

// Close modal on outside click
document.getElementById('paymentModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closePaymentModal();
    }
});
</script>
@endif
@endsection
