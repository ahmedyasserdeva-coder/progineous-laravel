@extends('admin.layout')

@section('title', __('crm.account_statement') . ' - ' . $client->first_name . ' ' . $client->last_name)

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-slate-800 to-slate-700 rounded-xl sm:rounded-2xl p-4 sm:p-6 md:p-8 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="absolute -top-24 {{ app()->getLocale() == 'ar' ? '-left-24' : '-right-24' }} w-48 sm:w-64 h-48 sm:h-64 bg-white/5 rounded-full blur-3xl"></div>
        
        <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 sm:h-16 sm:w-16 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-xl sm:text-2xl font-bold">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl md:text-3xl font-bold">{{ __('crm.account_statement') }}</h1>
                    <p class="text-white/70 text-sm sm:text-base">{{ $client->first_name }} {{ $client->last_name }} ({{ $client->email }})</p>
                </div>
            </div>
            <div class="flex flex-wrap gap-2 sm:gap-3">
                <a href="{{ route('admin.clients.statement.pdf', $client) }}" class="inline-flex items-center gap-2 bg-white text-slate-800 px-4 py-2 rounded-lg font-semibold hover:bg-slate-100 transition-all text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    {{ __('crm.export_pdf') }}
                </a>
                <a href="{{ route('admin.clients.show', $client) }}" class="inline-flex items-center gap-2 bg-white/20 text-white px-4 py-2 rounded-lg font-semibold hover:bg-white/30 transition-all text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    {{ __('crm.back') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        @php
            $totalInvoiced = $invoices->sum('total');
            $totalPaid = $invoices->where('status', 'paid')->sum('total');
            $totalUnpaid = $invoices->whereIn('status', ['unpaid', 'overdue'])->sum('total');
            $balance = $totalInvoiced - $totalPaid;
        @endphp
        
        <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">{{ __('crm.total_invoiced') }}</p>
                    <p class="text-xl font-bold text-gray-900">${{ number_format($totalInvoiced, 2) }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">{{ __('crm.total_paid') }}</p>
                    <p class="text-xl font-bold text-green-600">${{ number_format($totalPaid, 2) }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">{{ __('crm.total_unpaid') }}</p>
                    <p class="text-xl font-bold text-red-600">${{ number_format($totalUnpaid, 2) }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">{{ __('crm.balance_due') }}</p>
                    <p class="text-xl font-bold {{ $balance > 0 ? 'text-red-600' : 'text-green-600' }}">${{ number_format($balance, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoices Table -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                {{ __('crm.invoices') }}
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('crm.invoice_number') }}</th>
                        <th class="px-4 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('crm.date') }}</th>
                        <th class="px-4 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('crm.due_date') }}</th>
                        <th class="px-4 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('crm.status') }}</th>
                        <th class="px-4 py-3 text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('crm.subtotal') }}</th>
                        <th class="px-4 py-3 text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('crm.total') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($invoices as $invoice)
                        @php
                            $statusColors = [
                                'paid' => 'bg-green-100 text-green-700',
                                'unpaid' => 'bg-amber-100 text-amber-700',
                                'overdue' => 'bg-red-100 text-red-700',
                                'cancelled' => 'bg-gray-100 text-gray-700',
                                'refunded' => 'bg-purple-100 text-purple-700',
                                'draft' => 'bg-slate-100 text-slate-700',
                            ];
                            $statusColor = $statusColors[$invoice->status] ?? 'bg-gray-100 text-gray-700';
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <span class="font-mono text-sm font-medium text-blue-600">{{ $invoice->invoice_number }}</span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('M d, Y') }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                                    {{ ucfirst($invoice->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900 text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}">${{ number_format($invoice->subtotal, 2) }}</td>
                            <td class="px-4 py-3 text-sm font-semibold text-gray-900 text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}">${{ number_format($invoice->total, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                {{ __('crm.no_invoices_found') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                {{ __('crm.transactions') }}
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('crm.date') }}</th>
                        <th class="px-4 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('crm.gateway') }}</th>
                        <th class="px-4 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('crm.transaction_id') }}</th>
                        <th class="px-4 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('crm.invoice') }}</th>
                        <th class="px-4 py-3 text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('crm.amount') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($transactions as $transaction)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-600">{{ \Carbon\Carbon::parse($transaction->created_at)->format('M d, Y H:i') }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ ucfirst($transaction->gateway ?? 'N/A') }}</td>
                            <td class="px-4 py-3">
                                <span class="font-mono text-xs text-gray-600">{{ $transaction->transaction_id ?? 'N/A' }}</span>
                            </td>
                            <td class="px-4 py-3">
                                @if($transaction->invoice_number)
                                    <span class="font-mono text-sm text-blue-600">{{ $transaction->invoice_number }}</span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm font-semibold text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} {{ $transaction->status == 'completed' ? 'text-green-600' : 'text-amber-600' }}">
                                ${{ number_format($transaction->amount, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                                {{ __('crm.no_transactions_found') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Document Verification Section -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden" x-data="documentVerification()">
        <div class="px-6 py-4 bg-gradient-to-r from-slate-700 to-slate-600 text-white flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            <h2 class="text-lg font-semibold">{{ __('crm.document_verification') }}</h2>
        </div>
        
        <div class="p-6">
            <!-- Verification Tabs -->
            <div class="flex border-b border-gray-200 mb-6">
                <button @click="activeTab = 'upload'" 
                        :class="activeTab === 'upload' ? 'border-slate-600 text-slate-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="px-4 py-2 text-sm font-medium border-b-2 -mb-px transition-colors">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        {{ __('crm.upload_document') }}
                    </span>
                </button>
                <button @click="activeTab = 'id'" 
                        :class="activeTab === 'id' ? 'border-slate-600 text-slate-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="px-4 py-2 text-sm font-medium border-b-2 -mb-px transition-colors">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                        </svg>
                        {{ __('crm.verify_by_id') }}
                    </span>
                </button>
            </div>

            <!-- Upload Tab -->
            <div x-show="activeTab === 'upload'" x-cloak>
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-slate-400 transition-colors"
                     :class="{ 'border-slate-500 bg-slate-50': isDragging }"
                     @dragover.prevent="isDragging = true"
                     @dragleave.prevent="isDragging = false"
                     @drop.prevent="handleDrop($event)">
                    
                    <div x-show="!selectedFile">
                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-gray-600 mb-2">{{ __('crm.drag_drop_pdf') }}</p>
                        <p class="text-gray-400 text-sm mb-4">{{ __('crm.or') }}</p>
                        <label class="inline-flex items-center gap-2 bg-slate-600 text-white px-4 py-2 rounded-lg cursor-pointer hover:bg-slate-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            {{ __('crm.choose_file') }}
                            <input type="file" accept=".pdf" @change="handleFileSelect($event)" class="hidden">
                        </label>
                    </div>

                    <div x-show="selectedFile" class="space-y-4">
                        <div class="flex items-center justify-center gap-3">
                            <svg class="w-10 h-10 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20M10.92,12.31C10.68,11.54 10.15,9.08 11.55,9.04C12.95,9 12.03,12.16 12.03,12.16C12.42,13.65 14.05,14.72 14.05,14.72C14.55,14.57 17.4,14.24 17,15.72C16.57,17.2 13.5,15.81 13.5,15.81C11.55,15.95 10.09,16.47 10.09,16.47C8.96,18.58 7.64,19.5 7.1,18.61C6.43,17.5 9.23,16.07 9.23,16.07C10.68,13.72 10.9,12.35 10.92,12.31Z"/>
                            </svg>
                            <div class="text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                                <p class="font-medium text-gray-800" x-text="selectedFile?.name"></p>
                                <p class="text-sm text-gray-500" x-text="formatFileSize(selectedFile?.size)"></p>
                            </div>
                        </div>
                        <div class="flex justify-center gap-3">
                            <button @click="verifyDocument()" 
                                    :disabled="isVerifying"
                                    class="inline-flex items-center gap-2 bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors disabled:opacity-50">
                                <svg x-show="!isVerifying" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <svg x-show="isVerifying" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span x-text="isVerifying ? '{{ __('crm.verifying') }}' : '{{ __('crm.verify_document') }}'"></span>
                            </button>
                            <button @click="clearFile()" class="inline-flex items-center gap-2 bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                {{ __('crm.clear') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Verify by ID Tab -->
            <div x-show="activeTab === 'id'" x-cloak>
                <div class="max-w-md mx-auto">
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('crm.enter_document_id') }}</label>
                    <div class="flex gap-3">
                        <input type="text" 
                               x-model="documentId"
                               maxlength="12"
                               placeholder="XXXXXXXXXXXX"
                               class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-slate-500 font-mono text-lg tracking-wider uppercase text-center">
                        <button @click="verifyById()"
                                :disabled="isVerifying || documentId.length !== 12"
                                class="inline-flex items-center gap-2 bg-slate-600 text-white px-6 py-3 rounded-lg hover:bg-slate-700 transition-colors disabled:opacity-50">
                            <svg x-show="!isVerifying" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <svg x-show="isVerifying" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            {{ __('crm.verify') }}
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">{{ __('crm.document_id_hint') }}</p>
                </div>
            </div>

            <!-- Verification Result -->
            <div x-show="verificationResult" x-cloak class="mt-6">
                <!-- Success Result -->
                <div x-show="verificationResult?.verified" class="bg-green-50 border border-green-200 rounded-xl p-6">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-green-800 mb-2">✓ {{ __('crm.document_authentic') }}</h3>
                            <p class="text-green-700 mb-4" x-text="verificationResult?.message"></p>
                            
                            <!-- Document Summary -->
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-white/50 rounded-lg p-4 mb-4">
                                <div>
                                    <p class="text-xs text-green-600">{{ __('crm.document_id') }}</p>
                                    <p class="font-mono font-bold text-green-800" x-text="verificationResult?.document?.document_id"></p>
                                </div>
                                <div>
                                    <p class="text-xs text-green-600">{{ __('crm.generation_date') }}</p>
                                    <p class="font-medium text-green-800" x-text="verificationResult?.document?.generated_at"></p>
                                </div>
                                <div>
                                    <p class="text-xs text-green-600">{{ __('crm.client_name') }}</p>
                                    <p class="font-medium text-green-800" x-text="verificationResult?.document?.client_name"></p>
                                </div>
                                <div>
                                    <p class="text-xs text-green-600">{{ __('crm.email_address') }}</p>
                                    <p class="font-medium text-green-800 text-sm" x-text="verificationResult?.document?.client_email"></p>
                                </div>
                            </div>
                            
                            <!-- Financial Summary -->
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-white/50 rounded-lg p-4 mb-4">
                                <div>
                                    <p class="text-xs text-green-600">{{ __('crm.total_invoiced') }}</p>
                                    <p class="font-bold text-green-800">$<span x-text="parseFloat(verificationResult?.document?.total_invoiced || 0).toFixed(2)"></span></p>
                                </div>
                                <div>
                                    <p class="text-xs text-green-600">{{ __('crm.total_paid') }}</p>
                                    <p class="font-bold text-green-700">$<span x-text="parseFloat(verificationResult?.document?.total_paid || 0).toFixed(2)"></span></p>
                                </div>
                                <div>
                                    <p class="text-xs text-green-600">{{ __('crm.total_unpaid') }}</p>
                                    <p class="font-bold text-amber-600">$<span x-text="parseFloat(verificationResult?.document?.total_unpaid || 0).toFixed(2)"></span></p>
                                </div>
                                <div>
                                    <p class="text-xs text-green-600">{{ __('crm.balance_due') }}</p>
                                    <p class="font-bold" :class="parseFloat(verificationResult?.document?.balance || 0) > 0 ? 'text-red-600' : 'text-green-700'">$<span x-text="parseFloat(verificationResult?.document?.balance || 0).toFixed(2)"></span></p>
                                </div>
                            </div>
                            
                            <!-- Invoices Details -->
                            <div x-show="verificationResult?.document?.invoices?.length > 0" class="mb-4">
                                <h4 class="text-sm font-semibold text-green-800 mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    {{ __('crm.invoices') }} (<span x-text="verificationResult?.document?.invoices_count"></span>)
                                </h4>
                                <div class="bg-white rounded-lg overflow-hidden border border-green-200">
                                    <table class="w-full text-sm">
                                        <thead class="bg-green-100">
                                            <tr>
                                                <th class="px-3 py-2 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-green-700">{{ __('crm.invoice_number') }}</th>
                                                <th class="px-3 py-2 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-green-700">{{ __('crm.date') }}</th>
                                                <th class="px-3 py-2 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-green-700">{{ __('crm.status') }}</th>
                                                <th class="px-3 py-2 text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} text-xs font-medium text-green-700">{{ __('crm.total') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template x-for="invoice in verificationResult?.document?.invoices" :key="invoice.invoice_number">
                                                <tr class="border-t border-green-100">
                                                    <td class="px-3 py-2 font-mono text-green-800" x-text="invoice.invoice_number"></td>
                                                    <td class="px-3 py-2 text-green-700" x-text="invoice.date"></td>
                                                    <td class="px-3 py-2">
                                                        <span class="px-2 py-1 text-xs rounded-full" 
                                                              :class="{
                                                                  'bg-green-100 text-green-700': invoice.status === 'paid',
                                                                  'bg-amber-100 text-amber-700': invoice.status === 'unpaid',
                                                                  'bg-red-100 text-red-700': invoice.status === 'overdue',
                                                                  'bg-gray-100 text-gray-700': invoice.status === 'cancelled'
                                                              }"
                                                              x-text="invoice.status"></span>
                                                    </td>
                                                    <td class="px-3 py-2 text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} font-semibold text-green-800">$<span x-text="parseFloat(invoice.total).toFixed(2)"></span></td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <!-- Transactions Details -->
                            <div x-show="verificationResult?.document?.transactions?.length > 0">
                                <h4 class="text-sm font-semibold text-green-800 mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                    </svg>
                                    {{ __('crm.transactions') }} (<span x-text="verificationResult?.document?.transactions_count"></span>)
                                </h4>
                                <div class="bg-white rounded-lg overflow-hidden border border-green-200">
                                    <table class="w-full text-sm">
                                        <thead class="bg-green-100">
                                            <tr>
                                                <th class="px-3 py-2 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-green-700">{{ __('crm.transaction_id') }}</th>
                                                <th class="px-3 py-2 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-green-700">{{ __('crm.gateway') }}</th>
                                                <th class="px-3 py-2 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-green-700">{{ __('crm.status') }}</th>
                                                <th class="px-3 py-2 text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} text-xs font-medium text-green-700">{{ __('crm.amount') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template x-for="trans in verificationResult?.document?.transactions" :key="trans.transaction_id">
                                                <tr class="border-t border-green-100">
                                                    <td class="px-3 py-2 font-mono text-xs text-green-800" x-text="trans.transaction_id || 'N/A'"></td>
                                                    <td class="px-3 py-2 text-green-700" x-text="trans.gateway || 'N/A'"></td>
                                                    <td class="px-3 py-2">
                                                        <span class="px-2 py-1 text-xs rounded-full"
                                                              :class="trans.status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700'"
                                                              x-text="trans.status || 'pending'"></span>
                                                    </td>
                                                    <td class="px-3 py-2 text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} font-semibold text-green-800">$<span x-text="parseFloat(trans.amount).toFixed(2)"></span></td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <!-- Verification Badge -->
                            <div class="mt-4 pt-4 border-t border-green-200 text-center">
                                <span class="inline-flex items-center gap-2 px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                    {{ __('crm.all_data_verified') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Failed Result -->
                <div x-show="verificationResult && !verificationResult.verified && !verificationResult.warning" class="bg-red-50 border border-red-200 rounded-xl p-6">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-red-800 mb-2">✗ {{ __('crm.document_not_authentic') }}</h3>
                            <p class="text-red-700" x-text="verificationResult?.message"></p>
                            <p class="text-sm text-red-600 mt-2">{{ __('crm.document_tampered_warning') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Warning Result (Document belongs to other client) -->
                <div x-show="verificationResult?.warning" class="bg-amber-50 border border-amber-200 rounded-xl p-6">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-amber-800 mb-2">⚠ {{ __('crm.document_mismatch') }}</h3>
                            <p class="text-amber-700" x-text="verificationResult?.message"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .no-print { display: none !important; }
        body { background: white !important; }
    }
    [x-cloak] { display: none !important; }
</style>

<script>
function documentVerification() {
    return {
        activeTab: 'upload',
        isDragging: false,
        selectedFile: null,
        documentId: '',
        isVerifying: false,
        verificationResult: null,

        handleDrop(e) {
            this.isDragging = false;
            const files = e.dataTransfer.files;
            if (files.length && files[0].type === 'application/pdf') {
                this.selectedFile = files[0];
                this.verificationResult = null;
            }
        },

        handleFileSelect(e) {
            const files = e.target.files;
            if (files.length) {
                this.selectedFile = files[0];
                this.verificationResult = null;
            }
        },

        formatFileSize(bytes) {
            if (!bytes) return '';
            if (bytes < 1024) return bytes + ' B';
            if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
            return (bytes / (1024 * 1024)).toFixed(2) + ' MB';
        },

        clearFile() {
            this.selectedFile = null;
            this.verificationResult = null;
        },

        async verifyDocument() {
            if (!this.selectedFile) return;
            
            this.isVerifying = true;
            this.verificationResult = null;

            const formData = new FormData();
            formData.append('document', this.selectedFile);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

            try {
                const response = await fetch('{{ route("admin.clients.verify-document", $client) }}', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                this.verificationResult = data;
            } catch (error) {
                this.verificationResult = {
                    verified: false,
                    message: 'An error occurred during verification'
                };
            }

            this.isVerifying = false;
        },

        async verifyById() {
            if (this.documentId.length !== 12) return;
            
            this.isVerifying = true;
            this.verificationResult = null;

            try {
                const response = await fetch('{{ route("admin.clients.verify-document-id", $client) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ document_id: this.documentId })
                });
                
                const data = await response.json();
                this.verificationResult = data;
            } catch (error) {
                this.verificationResult = {
                    verified: false,
                    message: 'An error occurred during verification'
                };
            }

            this.isVerifying = false;
        }
    }
}
</script>
@endsection
