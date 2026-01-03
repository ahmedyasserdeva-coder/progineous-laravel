@extends('frontend.client.layout')

@section('title', (app()->getLocale() == 'ar' ? 'فواتيري' : 'My Invoices') . ' - ' . config('app.name'))

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white {{ app()->getLocale() == 'ar' ? 'text-right' : '' }}">
                        {{ app()->getLocale() == 'ar' ? 'فواتيري' : 'My Invoices' }}
                    </h1>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 {{ app()->getLocale() == 'ar' ? 'text-right' : '' }}">
                        {{ app()->getLocale() == 'ar' ? 'عرض وإدارة جميع فواتيرك' : 'View and manage all your invoices' }}
                    </p>
                </div>
            </div>
        </div>

        @if($invoices->count() > 0)
        <!-- Invoices Table -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gradient-to-r from-blue-600 to-indigo-600">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-bold text-white uppercase tracking-wider">
                                {{ app()->getLocale() == 'ar' ? 'رقم الفاتورة' : 'Invoice #' }}
                            </th>
                            <th scope="col" class="px-6 py-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-bold text-white uppercase tracking-wider">
                                {{ app()->getLocale() == 'ar' ? 'التاريخ' : 'Date' }}
                            </th>
                            <th scope="col" class="px-6 py-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-bold text-white uppercase tracking-wider">
                                {{ app()->getLocale() == 'ar' ? 'تاريخ الاستحقاق' : 'Due Date' }}
                            </th>
                            <th scope="col" class="px-6 py-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-bold text-white uppercase tracking-wider">
                                {{ app()->getLocale() == 'ar' ? 'المبلغ' : 'Amount' }}
                            </th>
                            <th scope="col" class="px-6 py-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-bold text-white uppercase tracking-wider">
                                {{ app()->getLocale() == 'ar' ? 'الحالة' : 'Status' }}
                            </th>
                            <th scope="col" class="px-6 py-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-bold text-white uppercase tracking-wider">
                                {{ app()->getLocale() == 'ar' ? 'الإجراءات' : 'Actions' }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($invoices as $invoice)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <div class="{{ app()->getLocale() == 'ar' ? 'mr-4' : 'ml-4' }}">
                                        <div class="text-sm font-bold text-gray-900 dark:text-white">
                                            {{ $invoice->invoice_number }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white font-medium">
                                    {{ $invoice->invoice_date->format('M d, Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white font-medium">
                                    {{ $invoice->due_date->format('M d, Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900 dark:text-white">
                                    {{ number_format($invoice->total, 2) }} {{ $invoice->currency ?? 'EGP' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($invoice->status === 'paid')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3"/>
                                        </svg>
                                        {{ app()->getLocale() == 'ar' ? 'مدفوعة' : 'Paid' }}
                                    </span>
                                @elseif($invoice->status === 'pending')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3"/>
                                        </svg>
                                        {{ app()->getLocale() == 'ar' ? 'معلقة' : 'Pending' }}
                                    </span>
                                @elseif($invoice->status === 'cancelled')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3"/>
                                        </svg>
                                        {{ app()->getLocale() == 'ar' ? 'ملغاة' : 'Cancelled' }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3"/>
                                        </svg>
                                        {{ ucfirst($invoice->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('client.invoices.show', $invoice->id) }}" class="inline-flex items-center gap-1.5 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        {{ app()->getLocale() == 'ar' ? 'عرض' : 'View' }}
                                    </a>
                                    <a href="{{ route('client.invoices.download', $invoice->id) }}" target="_blank" class="inline-flex items-center gap-1.5 text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        {{ app()->getLocale() == 'ar' ? 'تحميل' : 'Download' }}
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($invoices->hasPages())
            <div class="bg-white dark:bg-gray-800 px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $invoices->links() }}
            </div>
            @endif
        </div>
        @else
        <!-- Empty State -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700 p-12">
            <div class="text-center">
                <div class="mx-auto h-24 w-24 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                    {{ app()->getLocale() == 'ar' ? 'لا توجد فواتير' : 'No Invoices' }}
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    {{ app()->getLocale() == 'ar' ? 'ليس لديك أي فواتير حتى الآن' : 'You don\'t have any invoices yet' }}
                </p>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
