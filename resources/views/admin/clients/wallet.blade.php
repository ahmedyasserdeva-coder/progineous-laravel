@extends('admin.layout')

@section('title', __('crm.wallet') . ' - ' . $client->first_name . ' ' . $client->last_name)

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 rounded-xl sm:rounded-2xl p-4 sm:p-6 md:p-8 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="absolute -top-24 {{ app()->getLocale() == 'ar' ? '-left-24' : '-right-24' }} w-48 sm:w-64 h-48 sm:h-64 bg-white/5 rounded-full blur-3xl"></div>
        
        <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 sm:h-16 sm:w-16 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M21 18v1c0 1.1-.9 2-2 2H5c-1.11 0-2-.9-2-2V5c0-1.1.89-2 2-2h14c1.1 0 2 .9 2 2v1h-9c-1.11 0-2 .9-2 2v8c0 1.1.89 2 2 2h9zm-9-2h10V8H12v8zm4-2.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl md:text-3xl font-bold">{{ __('crm.wallet') }}</h1>
                    <p class="text-white/70 text-sm sm:text-base">{{ $client->first_name }} {{ $client->last_name }} ({{ '@' . $client->username }})</p>
                </div>
            </div>
            <div class="flex flex-wrap gap-2 sm:gap-3">
                <a href="{{ route('admin.clients.show', $client) }}" class="inline-flex items-center gap-2 bg-white/20 text-white px-4 py-2 rounded-lg font-semibold hover:bg-white/30 transition-all text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    {{ __('crm.back') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Wallet Card & Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Wallet Card -->
        <div class="lg:col-span-2">
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-6 sm:p-8 text-white relative overflow-hidden">
                <div class="absolute top-0 {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 {{ app()->getLocale() == 'ar' ? '-translate-x-1/2' : 'translate-x-1/2' }}"></div>
                
                <div class="relative">
                    <div class="flex items-start justify-between mb-8">
                        <div>
                            <p class="text-white/60 text-sm mb-1">{{ __('crm.current_balance') }}</p>
                            <p class="text-4xl sm:text-5xl font-bold">${{ number_format($client->wallet_balance ?? 0, 2) }}</p>
                        </div>
                        <svg class="w-12 h-12 text-white/20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M21 18v1c0 1.1-.9 2-2 2H5c-1.11 0-2-.9-2-2V5c0-1.1.89-2 2-2h14c1.1 0 2 .9 2 2v1h-9c-1.11 0-2 .9-2 2v8c0 1.1.89 2 2 2h9zm-9-2h10V8H12v8zm4-2.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/>
                        </svg>
                    </div>

                    @if($client->wallet_card_number)
                        <div class="mb-6">
                            <p class="text-white/60 text-xs mb-1">{{ __('crm.card_number') }}</p>
                            <p class="text-xl sm:text-2xl font-mono tracking-wider">{{ $client->wallet_card_number }}</p>
                        </div>
                    @endif

                    <div class="flex items-center justify-between pt-4 border-t border-white/10">
                        <div>
                            <p class="text-white/60 text-xs">{{ __('crm.account_holder') }}</p>
                            <p class="font-semibold">{{ $client->first_name }} {{ $client->last_name }}</p>
                        </div>
                        <div class="text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}">
                            <p class="text-white/60 text-xs">{{ __('crm.email') }}</p>
                            <p class="font-semibold text-sm">{{ $client->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="space-y-4">
            <!-- Add Credit -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200 bg-green-50">
                    <h3 class="text-lg font-semibold text-green-800 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        {{ __('crm.add_credit') }}
                    </h3>
                </div>
                <form action="{{ route('admin.clients.wallet.add-credit', $client) }}" method="POST" class="p-4 space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('crm.amount') }}</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'right-0 pr-3' : 'left-0 pl-3' }} flex items-center text-gray-500">$</span>
                            <input type="number" name="amount" step="0.01" min="0.01" required
                                   class="w-full {{ app()->getLocale() == 'ar' ? 'pr-8 pl-3' : 'pl-8 pr-3' }} py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                   placeholder="0.00">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('crm.reason') }}</label>
                        <select name="reason" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">{{ __('crm.select_reason') }}</option>
                            <option value="{{ __('crm.reason_refund') }}">{{ __('crm.reason_refund') }}</option>
                            <option value="{{ __('crm.reason_compensation') }}">{{ __('crm.reason_compensation') }}</option>
                            <option value="{{ __('crm.reason_bonus') }}">{{ __('crm.reason_bonus') }}</option>
                            <option value="{{ __('crm.reason_promotion') }}">{{ __('crm.reason_promotion') }}</option>
                            <option value="{{ __('crm.reason_adjustment') }}">{{ __('crm.reason_adjustment') }}</option>
                            <option value="{{ __('crm.reason_other') }}">{{ __('crm.reason_other') }}</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 px-4 rounded-lg transition-colors">
                        {{ __('crm.add_credit') }}
                    </button>
                </form>
            </div>

            <!-- Deduct Credit -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200 bg-red-50">
                    <h3 class="text-lg font-semibold text-red-800 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                        </svg>
                        {{ __('crm.deduct_credit') }}
                    </h3>
                </div>
                <form action="{{ route('admin.clients.wallet.deduct-credit', $client) }}" method="POST" class="p-4 space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('crm.amount') }}</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'right-0 pr-3' : 'left-0 pl-3' }} flex items-center text-gray-500">$</span>
                            <input type="number" name="amount" step="0.01" min="0.01" max="{{ $client->wallet_balance ?? 0 }}" required
                                   class="w-full {{ app()->getLocale() == 'ar' ? 'pr-8 pl-3' : 'pl-8 pr-3' }} py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                   placeholder="0.00">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">{{ __('crm.max_available') }}: ${{ number_format($client->wallet_balance ?? 0, 2) }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('crm.reason') }}</label>
                        <select name="reason" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            <option value="">{{ __('crm.select_reason') }}</option>
                            <option value="{{ __('crm.reason_chargeback') }}">{{ __('crm.reason_chargeback') }}</option>
                            <option value="{{ __('crm.reason_correction') }}">{{ __('crm.reason_correction') }}</option>
                            <option value="{{ __('crm.reason_fee') }}">{{ __('crm.reason_fee') }}</option>
                            <option value="{{ __('crm.reason_penalty') }}">{{ __('crm.reason_penalty') }}</option>
                            <option value="{{ __('crm.reason_other') }}">{{ __('crm.reason_other') }}</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 px-4 rounded-lg transition-colors"
                            {{ ($client->wallet_balance ?? 0) <= 0 ? 'disabled' : '' }}>
                        {{ __('crm.deduct_credit') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Transaction History -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ __('crm.transaction_history') }}
            </h3>
        </div>
        
        @if($transactions->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('crm.reference') }}</th>
                            <th class="px-5 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('crm.type') }}</th>
                            <th class="px-5 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('crm.description') }}</th>
                            <th class="px-5 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('crm.amount') }}</th>
                            <th class="px-5 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('crm.status') }}</th>
                            <th class="px-5 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('crm.date') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($transactions as $transaction)
                            <tr class="hover:bg-gray-50">
                                <!-- Reference -->
                                <td class="px-5 py-4 whitespace-nowrap">
                                    @if($transaction->reference || $transaction->transaction_reference)
                                        <a href="{{ route('admin.clients.wallet.transaction', [$client, $transaction->id]) }}" 
                                           class="text-sm font-mono text-blue-600 hover:text-blue-800 hover:underline">
                                            {{ $transaction->reference ?? $transaction->transaction_reference }}
                                        </a>
                                    @else
                                        <a href="{{ route('admin.clients.wallet.transaction', [$client, $transaction->id]) }}" 
                                           class="text-sm font-mono text-blue-600 hover:text-blue-800 hover:underline">
                                            #{{ $transaction->id }}
                                        </a>
                                    @endif
                                </td>
                                
                                <!-- Type -->
                                <td class="px-5 py-4 whitespace-nowrap">
                                    @if($transaction->payment_method == 'transfer_fee')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ __('crm.transfer_fee') }}
                                        </span>
                                    @elseif($transaction->payment_method == 'wallet_transfer')
                                        @if($transaction->type == 'deposit')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M8 5a1 1 0 100 2h5.586l-1.293 1.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L13.586 5H8zM12 15a1 1 0 100-2H6.414l1.293-1.293a1 1 0 10-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L6.414 15H12z"/>
                                                </svg>
                                                {{ __('crm.transfer_received') }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M8 5a1 1 0 100 2h5.586l-1.293 1.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L13.586 5H8zM12 15a1 1 0 100-2H6.414l1.293-1.293a1 1 0 10-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L6.414 15H12z"/>
                                                </svg>
                                                {{ __('crm.transfer_sent') }}
                                            </span>
                                        @endif
                                    @else
                                        @if($transaction->type == 'deposit')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ __('crm.deposit') }}
                                            </span>
                                        @elseif($transaction->type == 'deduction')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ __('crm.deduction') }}
                                            </span>
                                        @elseif($transaction->type == 'refund')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5 2a2 2 0 00-2 2v14l3.5-2 3.5 2 3.5-2 3.5 2V4a2 2 0 00-2-2H5zm2.5 3a1.5 1.5 0 100 3 1.5 1.5 0 000-3zm6.207.293a1 1 0 00-1.414 0l-6 6a1 1 0 101.414 1.414l6-6a1 1 0 000-1.414zM12.5 10a1.5 1.5 0 100 3 1.5 1.5 0 000-3z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ __('crm.refund') }}
                                            </span>
                                        @elseif($transaction->type == 'withdrawal')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ __('crm.withdrawal') }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ ucfirst($transaction->type ?? 'Unknown') }}
                                            </span>
                                        @endif
                                    @endif
                                </td>
                                
                                <!-- Description -->
                                <td class="px-5 py-4 text-sm text-gray-900">
                                    @php
                                        $desc = $transaction->description;
                                        
                                        // If description is empty, try to get from metadata
                                        if (empty($desc) && $transaction->metadata) {
                                            $metadata = is_array($transaction->metadata) ? $transaction->metadata : json_decode($transaction->metadata, true);
                                            $desc = $metadata['description'] ?? null;
                                        }
                                        
                                        // If still empty, generate from type and payment_method
                                        if (empty($desc)) {
                                            if ($transaction->payment_method == 'wallet_payment') {
                                                $desc = __('crm.wallet_payment');
                                            } elseif ($transaction->type == 'withdrawal') {
                                                $desc = __('crm.withdrawal');
                                            } elseif ($transaction->type == 'deposit') {
                                                $desc = __('crm.deposit');
                                            } else {
                                                $desc = '-';
                                            }
                                        }
                                        
                                        // Check if description is a translation key
                                        if ($desc && str_contains($desc, '.') && !str_contains($desc, ' ')) {
                                            $translated = __($desc);
                                            if ($translated !== $desc) {
                                                $desc = $translated;
                                            }
                                        }
                                    @endphp
                                    {{ $desc }}
                                </td>
                                
                                <!-- Amount -->
                                <td class="px-5 py-4 whitespace-nowrap text-sm font-semibold {{ in_array($transaction->type, ['deposit', 'refund']) ? 'text-green-600' : 'text-red-600' }}">
                                    {{ in_array($transaction->type, ['deposit', 'refund']) ? '+' : '-' }}${{ number_format($transaction->amount, 2) }}
                                </td>
                                
                                <!-- Status -->
                                <td class="px-5 py-4 whitespace-nowrap">
                                    @if($transaction->status == 'completed')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ __('crm.completed') }}
                                        </span>
                                    @elseif($transaction->status == 'pending')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <svg class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            {{ __('crm.pending') }}
                                        </span>
                                    @elseif($transaction->status == 'cancelled')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ __('crm.cancelled') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ __('crm.failed') }}
                                        </span>
                                    @endif
                                </td>
                                
                                <!-- Date -->
                                <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $transaction->created_at->format('Y-m-d H:i') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($transactions->hasPages())
                <div class="px-5 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $transactions->links() }}
                </div>
            @endif
        @else
            <div class="px-5 py-12 text-center">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <p class="text-gray-500">{{ __('crm.no_transactions') }}</p>
            </div>
        @endif
    </div>
</div>
@endsection
