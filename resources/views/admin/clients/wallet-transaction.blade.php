@extends('admin.layout')

@section('title', __('crm.transaction_details') . ' - ' . ($transaction->reference ?? '#' . $transaction->id))

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.clients.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    {{ __('crm.clients') }}
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <a href="{{ route('admin.clients.show', $client) }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">
                        {{ $client->first_name }} {{ $client->last_name }}
                    </a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <a href="{{ route('admin.clients.wallet', $client) }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">
                        {{ __('crm.wallet') }}
                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-500">{{ __('crm.transaction_details') }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Transaction Details Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">{{ __('crm.transaction_details') }}</h1>
                        <p class="text-sm text-gray-500 font-mono">{{ $transaction->reference ?? $transaction->transaction_reference ?? '#' . $transaction->id }}</p>
                    </div>
                </div>
                
                <!-- Status Badge -->
                <div>
                    @if($transaction->status == 'completed')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('crm.completed') }}
                        </span>
                    @elseif($transaction->status == 'pending')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('crm.pending') }}
                        </span>
                    @elseif($transaction->status == 'cancelled')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('crm.cancelled') }}
                        </span>
                    @elseif($transaction->status == 'failed')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('crm.failed') }}
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                            {{ ucfirst($transaction->status ?? 'Unknown') }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Amount Section -->
        <div class="px-6 py-6 bg-gradient-to-r from-gray-50 to-white border-b border-gray-200">
            <div class="text-center">
                <p class="text-sm text-gray-500 mb-1">{{ __('crm.amount') }}</p>
                <p class="text-4xl font-bold {{ $transaction->amount >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $transaction->amount >= 0 ? '+' : '' }}${{ number_format(abs($transaction->amount), 2) }}
                </p>
                <p class="text-sm text-gray-500 mt-2">
                    @if($transaction->type == 'deposit')
                        <span class="inline-flex items-center gap-1 text-green-600">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('crm.deposit') }}
                        </span>
                    @elseif($transaction->type == 'withdrawal')
                        <span class="inline-flex items-center gap-1 text-red-600">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('crm.withdrawal') }}
                        </span>
                    @elseif($transaction->type == 'deduction')
                        <span class="inline-flex items-center gap-1 text-amber-600">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('crm.deduction') }}
                        </span>
                    @elseif($transaction->type == 'refund')
                        <span class="inline-flex items-center gap-1 text-blue-600">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 2a2 2 0 00-2 2v14l3.5-2 3.5 2 3.5-2 3.5 2V4a2 2 0 00-2-2H5z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('crm.refund') }}
                        </span>
                    @else
                        {{ ucfirst($transaction->type ?? 'Unknown') }}
                    @endif
                </p>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="px-6 py-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Reference -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">{{ __('crm.reference') }}</p>
                    <p class="text-sm font-mono text-gray-900">{{ $transaction->reference ?? $transaction->transaction_reference ?? '-' }}</p>
                </div>

                <!-- Transaction ID -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">{{ __('crm.transaction_id') }}</p>
                    <p class="text-sm font-mono text-gray-900">#{{ $transaction->id }}</p>
                </div>

                <!-- Payment Method -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">{{ __('crm.payment_method') }}</p>
                    <p class="text-sm text-gray-900">
                        @php
                            $methodKey = 'crm.' . $transaction->payment_method;
                            $methodLabel = __($methodKey);
                        @endphp
                        {{ $methodLabel !== $methodKey ? $methodLabel : ucwords(str_replace('_', ' ', $transaction->payment_method ?? '-')) }}
                    </p>
                </div>

                <!-- Payment Provider -->
                @if($transaction->payment_provider)
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">{{ __('crm.payment_provider') }}</p>
                    <p class="text-sm text-gray-900">{{ ucfirst($transaction->payment_provider) }}</p>
                </div>
                @endif

                <!-- Created Date -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">{{ __('crm.created_at') }}</p>
                    <p class="text-sm text-gray-900">{{ $transaction->created_at?->format('Y-m-d H:i:s') ?? '-' }}</p>
                </div>

                <!-- Completed Date -->
                @if($transaction->completed_at)
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">{{ __('crm.completed_at') }}</p>
                    <p class="text-sm text-gray-900">{{ $transaction->completed_at?->format('Y-m-d H:i:s') ?? '-' }}</p>
                </div>
                @endif
            </div>

            <!-- Order & Invoice Information -->
            @php
                $meta = is_string($transaction->metadata) ? json_decode($transaction->metadata, true) : $transaction->metadata;
                $invoiceNumber = $meta['invoice_number'] ?? null;
                $invoiceId = $meta['invoice_id'] ?? null;
                $orderNumber = $meta['order_number'] ?? null;
                $orderId = $meta['order_id'] ?? null;
            @endphp
            @if($invoiceNumber || $orderNumber)
            <div class="mt-6">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">{{ __('crm.related_records') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($invoiceNumber && $invoiceId)
                    <div class="bg-purple-50 rounded-lg p-4">
                        <p class="text-xs text-purple-600 uppercase tracking-wide mb-1">{{ __('crm.invoice_number') }}</p>
                        <a href="{{ route('admin.invoices.show', $invoiceId) }}" target="_blank"
                           class="text-sm font-mono text-purple-700 hover:text-purple-900 hover:underline inline-flex items-center gap-1">
                            {{ $invoiceNumber }}
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </a>
                    </div>
                    @elseif($invoiceNumber)
                    <div class="bg-purple-50 rounded-lg p-4">
                        <p class="text-xs text-purple-600 uppercase tracking-wide mb-1">{{ __('crm.invoice_number') }}</p>
                        <p class="text-sm font-mono text-purple-700">{{ $invoiceNumber }}</p>
                    </div>
                    @endif
                    @if($orderNumber)
                    <div class="bg-indigo-50 rounded-lg p-4">
                        <p class="text-xs text-indigo-600 uppercase tracking-wide mb-1">{{ __('crm.order_number') }}</p>
                        <p class="text-sm font-mono text-indigo-700">{{ $orderNumber }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Description -->
            @php
                $desc = $transaction->description;
                if (empty($desc) && $transaction->metadata) {
                    $metadata = is_string($transaction->metadata) ? json_decode($transaction->metadata, true) : $transaction->metadata;
                    $desc = $metadata['description'] ?? null;
                }
            @endphp
            @if($desc)
            <div class="mt-6 bg-gray-50 rounded-lg p-4">
                <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">{{ __('crm.description') }}</p>
                <p class="text-sm text-gray-900">{{ $desc }}</p>
            </div>
            @endif

            <!-- Notes -->
            @if($transaction->notes)
            <div class="mt-4 bg-gray-50 rounded-lg p-4">
                <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">{{ __('crm.notes') }}</p>
                <p class="text-sm text-gray-900">{{ $transaction->notes }}</p>
            </div>
            @endif

            <!-- Fawaterak Details -->
            @if($transaction->fawaterak_invoice_id || $transaction->fawaterak_invoice_key)
            <div class="mt-6">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">{{ __('crm.fawaterak_details') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @if($transaction->fawaterak_invoice_id)
                    <div class="bg-blue-50 rounded-lg p-4">
                        <p class="text-xs text-blue-600 uppercase tracking-wide mb-1">Invoice ID</p>
                        <p class="text-sm font-mono text-blue-900">{{ $transaction->fawaterak_invoice_id }}</p>
                    </div>
                    @endif
                    @if($transaction->fawaterak_invoice_key)
                    <div class="bg-blue-50 rounded-lg p-4">
                        <p class="text-xs text-blue-600 uppercase tracking-wide mb-1">Invoice Key</p>
                        <p class="text-sm font-mono text-blue-900">{{ $transaction->fawaterak_invoice_key }}</p>
                    </div>
                    @endif
                    @if($transaction->fawaterak_reference_id)
                    <div class="bg-blue-50 rounded-lg p-4">
                        <p class="text-xs text-blue-600 uppercase tracking-wide mb-1">Reference ID</p>
                        <p class="text-sm font-mono text-blue-900">{{ $transaction->fawaterak_reference_id }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Metadata -->
            @if($transaction->metadata)
            @php
                $metadata = is_string($transaction->metadata) ? json_decode($transaction->metadata, true) : $transaction->metadata;
                // Keys to exclude from metadata display (already shown elsewhere)
                $excludeKeys = ['description', 'invoice_number', 'invoice_id', 'order_number', 'order_id'];
            @endphp
            @php
                $filteredMetadata = collect($metadata)->except($excludeKeys)->toArray();
            @endphp
            @if($filteredMetadata && count($filteredMetadata) > 0)
            <div class="mt-6">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">{{ __('crm.metadata') }}</h3>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($filteredMetadata as $key => $value)
                            <div class="border-b border-gray-200 pb-2 last:border-0">
                                <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">{{ ucwords(str_replace('_', ' ', $key)) }}</p>
                                <p class="text-sm text-gray-900">
                                    @if(is_array($value))
                                        {{ json_encode($value) }}
                                    @else
                                        {{ $value ?? '-' }}
                                    @endif
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            @endif
        </div>

        <!-- Footer Actions -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            <div class="flex justify-between items-center">
                <a href="{{ route('admin.clients.wallet', $client) }}" class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900">
                    <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('crm.back_to_wallet') }}
                </a>
                
                <div class="text-sm text-gray-500">
                    {{ __('crm.client') }}: <a href="{{ route('admin.clients.show', $client) }}" class="text-blue-600 hover:underline">{{ $client->first_name }} {{ $client->last_name }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
