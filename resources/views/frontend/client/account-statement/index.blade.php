@extends('frontend.client.layout')

@section('title', app()->getLocale() == 'ar' ? 'كشف الحساب' : 'Account Statement')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-purple-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 py-8">
    <div class="container mx-auto px-4 max-w-6xl">
        @php $rtl = app()->getLocale() == 'ar'; @endphp
        
        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 md:mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white mb-2">
                    {{ app()->getLocale() == 'ar' ? 'كشف الحساب' : 'Account Statement' }}
                </h1>
                <p class="text-sm md:text-base text-slate-600 dark:text-slate-400">
                    {{ app()->getLocale() == 'ar' ? 'عرض جميع فواتيرك ومعاملاتك' : 'View all your invoices and transactions' }}
                </p>
            </div>
            <a href="{{ route('client.account-statement.pdf') }}" 
               class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                {{ app()->getLocale() == 'ar' ? 'تحميل PDF' : 'Download PDF' }}
            </a>
        </div>

        {{-- Summary Cards --}}
        @php
            $totalInvoiced = $invoices->sum('total');
            $totalPaid = $invoices->where('status', 'paid')->sum('total');
            $totalUnpaid = $invoices->whereIn('status', ['unpaid', 'overdue'])->sum('total');
            $balance = $totalInvoiced - $totalPaid;
        @endphp
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6 md:mb-8">
            <div class="bg-white dark:bg-slate-800 rounded-xl p-4 shadow-lg">
                <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">
                    {{ app()->getLocale() == 'ar' ? 'إجمالي الفواتير' : 'Total Invoiced' }}
                </p>
                <p class="text-xl md:text-2xl font-bold text-slate-900 dark:text-white">
                    ${{ number_format($totalInvoiced, 2) }}
                </p>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-xl p-4 shadow-lg">
                <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">
                    {{ app()->getLocale() == 'ar' ? 'إجمالي المدفوع' : 'Total Paid' }}
                </p>
                <p class="text-xl md:text-2xl font-bold text-green-600">
                    ${{ number_format($totalPaid, 2) }}
                </p>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-xl p-4 shadow-lg">
                <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">
                    {{ app()->getLocale() == 'ar' ? 'غير المدفوع' : 'Unpaid' }}
                </p>
                <p class="text-xl md:text-2xl font-bold text-amber-600">
                    ${{ number_format($totalUnpaid, 2) }}
                </p>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-xl p-4 shadow-lg">
                <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">
                    {{ app()->getLocale() == 'ar' ? 'الرصيد المستحق' : 'Balance Due' }}
                </p>
                <p class="text-xl md:text-2xl font-bold {{ $balance > 0 ? 'text-red-600' : 'text-green-600' }}">
                    ${{ number_format($balance, 2) }}
                </p>
            </div>
        </div>

        {{-- Invoices Section --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg overflow-hidden mb-6 md:mb-8">
            <div class="p-4 sm:p-5 border-b border-slate-200 dark:border-slate-700">
                <h2 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    {{ app()->getLocale() == 'ar' ? 'الفواتير' : 'Invoices' }}
                    <span class="text-sm font-normal text-slate-500">({{ $invoices->count() }})</span>
                </h2>
            </div>

            @if($invoices->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 dark:bg-slate-700/50">
                            <tr>
                                <th class="px-4 py-3 text-{{ $rtl ? 'right' : 'left' }} text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase">
                                    {{ app()->getLocale() == 'ar' ? 'رقم الفاتورة' : 'Invoice #' }}
                                </th>
                                <th class="px-4 py-3 text-{{ $rtl ? 'right' : 'left' }} text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase">
                                    {{ app()->getLocale() == 'ar' ? 'التاريخ' : 'Date' }}
                                </th>
                                <th class="px-4 py-3 text-{{ $rtl ? 'right' : 'left' }} text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase">
                                    {{ app()->getLocale() == 'ar' ? 'تاريخ الاستحقاق' : 'Due Date' }}
                                </th>
                                <th class="px-4 py-3 text-{{ $rtl ? 'left' : 'right' }} text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase">
                                    {{ app()->getLocale() == 'ar' ? 'المبلغ' : 'Amount' }}
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase">
                                    {{ app()->getLocale() == 'ar' ? 'الحالة' : 'Status' }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                            @foreach($invoices as $invoice)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                                <td class="px-4 py-3 font-medium text-slate-900 dark:text-white">
                                    {{ $invoice->invoice_number }}
                                </td>
                                <td class="px-4 py-3 text-slate-600 dark:text-slate-400 text-sm">
                                    {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('M d, Y') }}
                                </td>
                                <td class="px-4 py-3 text-slate-600 dark:text-slate-400 text-sm">
                                    {{ $invoice->due_date ? \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') : '-' }}
                                </td>
                                <td class="px-4 py-3 text-{{ $rtl ? 'left' : 'right' }} font-semibold text-slate-900 dark:text-white">
                                    ${{ number_format($invoice->total, 2) }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @php
                                        $statusColors = [
                                            'paid' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                            'unpaid' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                                            'overdue' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                            'cancelled' => 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-400',
                                            'draft' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                            'refunded' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                                        ];
                                        $statusLabels = [
                                            'paid' => app()->getLocale() == 'ar' ? 'مدفوعة' : 'Paid',
                                            'unpaid' => app()->getLocale() == 'ar' ? 'غير مدفوعة' : 'Unpaid',
                                            'overdue' => app()->getLocale() == 'ar' ? 'متأخرة' : 'Overdue',
                                            'cancelled' => app()->getLocale() == 'ar' ? 'ملغاة' : 'Cancelled',
                                            'draft' => app()->getLocale() == 'ar' ? 'مسودة' : 'Draft',
                                            'refunded' => app()->getLocale() == 'ar' ? 'مستردة' : 'Refunded',
                                        ];
                                    @endphp
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColors[$invoice->status] ?? 'bg-slate-100 text-slate-700' }}">
                                        {{ $statusLabels[$invoice->status] ?? ucfirst($invoice->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-8 text-center">
                    <svg class="w-12 h-12 mx-auto text-slate-300 dark:text-slate-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-slate-500 dark:text-slate-400">
                        {{ app()->getLocale() == 'ar' ? 'لا توجد فواتير' : 'No invoices found' }}
                    </p>
                </div>
            @endif
        </div>

        {{-- Transactions Section --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-slate-200 dark:border-slate-700">
                <h2 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    {{ app()->getLocale() == 'ar' ? 'المعاملات' : 'Transactions' }}
                    <span class="text-sm font-normal text-slate-500">({{ $transactions->count() }})</span>
                </h2>
            </div>

            @if($transactions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 dark:bg-slate-700/50">
                            <tr>
                                <th class="px-4 py-3 text-{{ $rtl ? 'right' : 'left' }} text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase">
                                    {{ app()->getLocale() == 'ar' ? 'رقم المعاملة' : 'Transaction ID' }}
                                </th>
                                <th class="px-4 py-3 text-{{ $rtl ? 'right' : 'left' }} text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase">
                                    {{ app()->getLocale() == 'ar' ? 'التاريخ' : 'Date' }}
                                </th>
                                <th class="px-4 py-3 text-{{ $rtl ? 'right' : 'left' }} text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase">
                                    {{ app()->getLocale() == 'ar' ? 'طريقة الدفع' : 'Gateway' }}
                                </th>
                                <th class="px-4 py-3 text-{{ $rtl ? 'left' : 'right' }} text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase">
                                    {{ app()->getLocale() == 'ar' ? 'المبلغ' : 'Amount' }}
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase">
                                    {{ app()->getLocale() == 'ar' ? 'الحالة' : 'Status' }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                            @foreach($transactions as $transaction)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                                <td class="px-4 py-3 font-mono text-sm text-slate-900 dark:text-white">
                                    {{ $transaction->transaction_id ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3 text-slate-600 dark:text-slate-400 text-sm">
                                    {{ \Carbon\Carbon::parse($transaction->created_at)->format('M d, Y H:i') }}
                                </td>
                                <td class="px-4 py-3 text-slate-600 dark:text-slate-400 text-sm capitalize">
                                    {{ $transaction->gateway ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-{{ $rtl ? 'left' : 'right' }} font-semibold text-green-600">
                                    +${{ number_format($transaction->amount, 2) }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @php
                                        $statusColors = [
                                            'completed' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                            'pending' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                                            'failed' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                            'refunded' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                                        ];
                                        $statusLabels = [
                                            'completed' => app()->getLocale() == 'ar' ? 'مكتمل' : 'Completed',
                                            'pending' => app()->getLocale() == 'ar' ? 'قيد الانتظار' : 'Pending',
                                            'failed' => app()->getLocale() == 'ar' ? 'فشل' : 'Failed',
                                            'refunded' => app()->getLocale() == 'ar' ? 'مسترد' : 'Refunded',
                                        ];
                                    @endphp
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColors[$transaction->status] ?? 'bg-slate-100 text-slate-700' }}">
                                        {{ $statusLabels[$transaction->status] ?? ucfirst($transaction->status ?? 'Unknown') }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-8 text-center">
                    <svg class="w-12 h-12 mx-auto text-slate-300 dark:text-slate-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    <p class="text-slate-500 dark:text-slate-400">
                        {{ app()->getLocale() == 'ar' ? 'لا توجد معاملات' : 'No transactions found' }}
                    </p>
                </div>
            @endif
        </div>

        {{-- Back Button --}}
        <div class="mt-6 text-center">
            <a href="{{ route('client.wallet') }}" 
               class="inline-flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">
                <svg class="w-5 h-5 {{ $rtl ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ app()->getLocale() == 'ar' ? 'العودة إلى المحفظة' : 'Back to Wallet' }}
            </a>
        </div>
    </div>
</div>
@endsection
