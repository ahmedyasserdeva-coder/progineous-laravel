@extends('admin.layout')

@section('title', __('crm.affiliate_details') . ' - ' . $client->first_name . ' ' . $client->last_name)

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-amber-600 to-orange-600 rounded-xl sm:rounded-2xl p-4 sm:p-6 md:p-8 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="absolute -top-24 {{ app()->getLocale() == 'ar' ? '-left-24' : '-right-24' }} w-48 sm:w-64 h-48 sm:h-64 bg-white/5 rounded-full blur-3xl"></div>
        
        <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="h-16 w-16 sm:h-20 sm:w-20 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center">
                    <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl md:text-3xl font-bold">{{ __('crm.affiliate_details') }}</h1>
                    <p class="text-white/70 text-sm sm:text-base">{{ $client->first_name }} {{ $client->last_name }} ({{ '@' . $client->username }})</p>
                    <p class="text-white/60 text-xs sm:text-sm">{{ __('crm.referral_code') }}: <span class="font-mono font-bold">{{ $affiliate->referral_code }}</span></p>
                </div>
            </div>
            <div class="flex flex-wrap gap-2 sm:gap-3">
                <a href="{{ route('admin.clients.show', $client) }}" class="inline-flex items-center gap-2 bg-white/20 text-white px-4 py-2 rounded-lg font-semibold hover:bg-white/30 transition-all text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    {{ __('crm.back_to_client') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
        <!-- Tier -->
        <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
            <p class="text-xs text-gray-500 mb-1">{{ __('crm.tier') }}</p>
            <div class="flex items-center gap-2">
                @if($affiliate->tier)
                    <span class="text-lg">{{ $affiliate->tier->icon ?? '🎖️' }}</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $affiliate->tier->name }}</span>
                @else
                    <span class="text-sm font-semibold text-gray-500">-</span>
                @endif
            </div>
        </div>

        <!-- Commission Rate -->
        <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
            <p class="text-xs text-gray-500 mb-1">{{ __('crm.commission_rate') }}</p>
            <p class="text-xl font-bold text-amber-600">{{ number_format($affiliate->commission_rate, 0) }}%</p>
        </div>

        <!-- Link Clicks -->
        <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
            <p class="text-xs text-gray-500 mb-1">{{ __('crm.link_clicks') }}</p>
            <p class="text-xl font-bold text-blue-600">{{ number_format($stats['link_clicks']) }}</p>
        </div>

        <!-- Total Referrals -->
        <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
            <p class="text-xs text-gray-500 mb-1">{{ __('crm.total_referrals') }}</p>
            <p class="text-xl font-bold text-purple-600">{{ number_format($stats['total_referrals']) }}</p>
        </div>

        <!-- Conversion Rate -->
        <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
            <p class="text-xs text-gray-500 mb-1">{{ __('crm.conversion_rate') }}</p>
            <p class="text-xl font-bold text-green-600">{{ $stats['conversion_rate'] }}%</p>
        </div>

        <!-- Total Earnings -->
        <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
            <p class="text-xs text-gray-500 mb-1">{{ __('crm.total_earnings') }}</p>
            <p class="text-xl font-bold text-green-600">${{ number_format($stats['total_earnings'], 2) }}</p>
        </div>

        <!-- Pending Balance -->
        <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
            <p class="text-xs text-gray-500 mb-1">{{ __('crm.pending_balance') }}</p>
            <p class="text-xl font-bold text-amber-600">${{ number_format($stats['pending_earnings'], 2) }}</p>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-wrap gap-3">
        <button type="button" onclick="document.getElementById('addBalanceModal').classList.remove('hidden')" 
                class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-green-600 hover:bg-green-700 rounded-lg transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            {{ __('crm.add_balance') }}
        </button>
        <button type="button" onclick="document.getElementById('deductBalanceModal').classList.remove('hidden')" 
                class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
            </svg>
            {{ __('crm.deduct_balance') }}
        </button>
    </div>

    <!-- Referral Link -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
        <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
            </svg>
            {{ __('crm.referral_link') }}
        </h3>
        <div class="flex items-center gap-3">
            <input type="text" readonly value="{{ $affiliate->referral_link }}" 
                   class="flex-1 bg-gray-50 border border-gray-300 rounded-lg px-4 py-2.5 text-sm font-mono text-gray-700" dir="ltr">
            <button onclick="copyToClipboard('{{ $affiliate->referral_link }}')" 
                    class="px-4 py-2.5 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                </svg>
                {{ __('crm.copy') }}
            </button>
        </div>
    </div>

    <!-- Tier Progress -->
    @if($allTiers->count() > 1)
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 sm:p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
                {{ __('crm.tier_progress') }}
            </h3>
            {{-- Change Tier Button --}}
            <button type="button" onclick="document.getElementById('changeTierModal').classList.remove('hidden')" 
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-amber-700 bg-amber-50 hover:bg-amber-100 rounded-lg border border-amber-200 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                {{ __('crm.change_tier') }}
            </button>
        </div>
        
        <!-- Grid Layout for Tiers -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
            @foreach($allTiers as $index => $tier)
                @php
                    $isActive = $affiliate->tier_id && $tier->id <= $affiliate->tier_id;
                    $isCurrent = $affiliate->tier_id == $tier->id;
                    $isPast = $affiliate->tier_id && $tier->id < $affiliate->tier_id;
                @endphp
                
                <div class="flex items-center gap-2 px-3 py-2 rounded-lg {{ $isCurrent ? 'bg-amber-50 border-2 border-amber-400' : ($isPast ? 'bg-green-50 border border-green-200' : 'bg-gray-50 border border-gray-200') }}">
                    <span class="text-lg flex-shrink-0">{{ $tier->icon ?? '🎖️' }}</span>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-1">
                            <p class="text-sm font-medium truncate {{ $isCurrent ? 'text-amber-700' : ($isPast ? 'text-green-700' : 'text-gray-600') }}">{{ $tier->name }}</p>
                            @if($isCurrent)
                                <span class="text-[10px] bg-amber-500 text-white px-1 rounded flex-shrink-0">{{ __('crm.current') }}</span>
                            @elseif($isPast)
                                <svg class="w-3.5 h-3.5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            @endif
                        </div>
                        <p class="text-xs {{ $isCurrent ? 'text-amber-500' : ($isPast ? 'text-green-500' : 'text-gray-400') }}">{{ $tier->commission_rate }}%</p>
                    </div>
                </div>
            @endforeach
        </div>
        
        {{-- Next Tier Info --}}
        @if($affiliate->tier)
            @php
                $nextTier = $allTiers->where('id', '>', $affiliate->tier_id)->first();
            @endphp
            @if($nextTier)
                <div class="mt-3 pt-3 border-t border-gray-100 flex items-center gap-2 text-sm">
                    <span class="text-gray-500">{{ __('crm.next_tier') }}:</span>
                    <span class="font-medium text-gray-700">{{ $nextTier->name }} ({{ $nextTier->commission_rate }}%)</span>
                </div>
            @else
                <div class="mt-3 pt-3 border-t border-gray-100">
                    <span class="text-sm text-green-600 font-medium">✓ {{ __('crm.max_tier_reached') }}</span>
                </div>
            @endif
        @endif
    </div>
    @endif

    <!-- Change Tier Modal -->
    <div id="changeTierModal" class="hidden fixed inset-0 z-[9999] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-2 sm:p-4">
            {{-- Backdrop --}}
            <div class="fixed inset-0 bg-black/50" onclick="document.getElementById('changeTierModal').classList.add('hidden')"></div>
            
            {{-- Modal Content --}}
            <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-lg mx-2 sm:mx-auto text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                <form action="{{ route('admin.clients.updateAffiliateTier', $client) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    {{-- Header --}}
                    <div class="flex items-center justify-between p-4 border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 flex items-center justify-center h-9 w-9 sm:h-10 sm:w-10 rounded-full bg-amber-100">
                                <svg class="h-4 w-4 sm:h-5 sm:w-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <h3 class="text-base sm:text-lg font-semibold text-gray-900">{{ __('crm.change_tier') }}</h3>
                        </div>
                        <button type="button" onclick="document.getElementById('changeTierModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 p-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    
                    {{-- Body --}}
                    <div class="p-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('crm.select_tier') }}</label>
                        <div class="space-y-2 max-h-[50vh] overflow-y-auto">
                            @foreach($allTiers as $tier)
                                <label class="flex items-center gap-2 sm:gap-3 p-2.5 sm:p-3 rounded-lg border cursor-pointer hover:bg-gray-50 transition-colors {{ $affiliate->tier_id == $tier->id ? 'border-amber-400 bg-amber-50' : 'border-gray-200' }}">
                                    <input type="radio" name="tier_id" value="{{ $tier->id }}" {{ $affiliate->tier_id == $tier->id ? 'checked' : '' }}
                                           class="w-4 h-4 text-amber-600 border-gray-300 focus:ring-amber-500 flex-shrink-0">
                                    <span class="text-lg sm:text-xl flex-shrink-0">{{ $tier->icon ?? '🎖️' }}</span>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $tier->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $tier->commission_rate }}%</p>
                                    </div>
                                    @if($affiliate->tier_id == $tier->id)
                                        <span class="text-[10px] sm:text-xs bg-amber-500 text-white px-1.5 sm:px-2 py-0.5 rounded flex-shrink-0">{{ __('crm.current') }}</span>
                                    @endif
                                </label>
                            @endforeach
                        </div>
                    </div>
                    
                    {{-- Footer --}}
                    <div class="flex flex-col-reverse sm:flex-row gap-2 p-4 border-t border-gray-100 bg-gray-50 rounded-b-xl">
                        <button type="button" onclick="document.getElementById('changeTierModal').classList.add('hidden')"
                                class="w-full sm:w-auto px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                            {{ __('crm.cancel') }}
                        </button>
                        <button type="submit"
                                class="w-full sm:w-auto px-4 py-2.5 bg-amber-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-amber-700 transition-colors sm:ms-auto">
                            {{ __('crm.save_changes') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Referrals -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ __('crm.referrals') }} ({{ $stats['total_referrals'] }})
                </h3>
            </div>
            <div class="overflow-x-auto">
                @if($referrals->count() > 0)
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 uppercase">{{ __('crm.client') }}</th>
                                <th class="px-4 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 uppercase">{{ __('crm.date') }}</th>
                                <th class="px-4 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 uppercase">{{ __('crm.status') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($referrals as $referral)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-semibold text-gray-600">
                                                {{ strtoupper(substr($referral->referredClient->name ?? 'U', 0, 2)) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $referral->referredClient->name ?? '-' }}</p>
                                                <p class="text-xs text-gray-500">{{ $referral->referredClient->email ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $referral->created_at->format('M d, Y') }}</td>
                                    <td class="px-4 py-3">
                                        @if($referral->status === 'converted')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                                {{ __('crm.converted') }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                                {{ __('crm.pending') }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if($referrals->hasPages())
                        <div class="px-4 py-3 border-t border-gray-100">
                            {{ $referrals->links() }}
                        </div>
                    @endif
                @else
                    <div class="px-4 py-8 text-center">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <p class="text-sm text-gray-500">{{ __('crm.no_referrals_yet') }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Commissions History -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ __('crm.commissions') }}
                </h3>
            </div>
            <div class="overflow-x-auto">
                @if($commissions->count() > 0)
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 uppercase">{{ __('crm.date') }}</th>
                                <th class="px-4 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 uppercase">{{ __('crm.amount') }}</th>
                                <th class="px-4 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 uppercase">{{ __('crm.status') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($commissions as $commission)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $commission->created_at->format('M d, Y') }}</td>
                                    <td class="px-4 py-3">
                                        <span class="text-sm font-semibold text-green-600">${{ number_format($commission->commission_amount, 2) }}</span>
                                        <span class="text-xs text-gray-400">({{ $commission->commission_rate }}%)</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-700',
                                                'approved' => 'bg-green-100 text-green-700',
                                                'paid' => 'bg-blue-100 text-blue-700',
                                                'cancelled' => 'bg-red-100 text-red-700',
                                            ];
                                        @endphp
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $statusColors[$commission->status] ?? 'bg-gray-100 text-gray-700' }}">
                                            {{ ucfirst($commission->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if($commissions->hasPages())
                        <div class="px-4 py-3 border-t border-gray-100">
                            {{ $commissions->links() }}
                        </div>
                    @endif
                @else
                    <div class="px-4 py-8 text-center">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm text-gray-500">{{ __('crm.no_commissions_yet') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Payouts History -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                {{ __('crm.payout_history') }}
            </h3>
        </div>
        <div class="overflow-x-auto">
            @if($payouts->count() > 0)
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 uppercase">{{ __('crm.date') }}</th>
                            <th class="px-4 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 uppercase">{{ __('crm.amount') }}</th>
                            <th class="px-4 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 uppercase">{{ __('crm.method') }}</th>
                            <th class="px-4 py-3 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-medium text-gray-500 uppercase">{{ __('crm.status') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($payouts as $payout)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $payout->created_at->format('M d, Y') }}</td>
                                <td class="px-4 py-3">
                                    <span class="text-sm font-semibold text-gray-900">${{ number_format($payout->amount, 2) }}</span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ ucfirst($payout->payment_method ?? '-') }}</td>
                                <td class="px-4 py-3">
                                    @php
                                        $payoutStatusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-700',
                                            'processing' => 'bg-blue-100 text-blue-700',
                                            'completed' => 'bg-green-100 text-green-700',
                                            'failed' => 'bg-red-100 text-red-700',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $payoutStatusColors[$payout->status] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ ucfirst($payout->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($payouts->hasPages())
                    <div class="px-4 py-3 border-t border-gray-100">
                        {{ $payouts->links() }}
                    </div>
                @endif
            @else
                <div class="px-4 py-8 text-center">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <p class="text-sm text-gray-500">{{ __('crm.no_payouts_yet') }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Account Info -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ __('crm.account_info') }}
            </h3>
        </div>
        <div class="p-5">
            <dl class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <dt class="text-xs text-gray-500">{{ __('crm.status') }}</dt>
                    <dd class="text-sm font-medium">
                        @if($affiliate->status === 'active')
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                {{ __('crm.active') }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                {{ ucfirst($affiliate->status) }}
                            </span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500">{{ __('crm.minimum_payout') }}</dt>
                    <dd class="text-sm font-medium text-gray-900">${{ number_format($affiliate->minimum_payout, 2) }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500">{{ __('crm.payment_method') }}</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ ucfirst($affiliate->payment_method ?? '-') }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500">{{ __('crm.joined_affiliate') }}</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $affiliate->created_at->format('M d, Y') }}</dd>
                </div>
            </dl>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert('{{ __("crm.copied_to_clipboard") }}');
    });
}
</script>

<!-- Add Balance Modal -->
<div id="addBalanceModal" class="hidden fixed inset-0 z-[9999] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-2 sm:p-4">
        <div class="fixed inset-0 bg-black/50" onclick="document.getElementById('addBalanceModal').classList.add('hidden')"></div>
        
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-md mx-2 sm:mx-auto text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
            <form action="{{ route('admin.clients.addAffiliateBalance', $client) }}" method="POST">
                @csrf
                
                <div class="flex items-center justify-between p-4 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-full bg-green-100">
                            <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ __('crm.add_balance') }}</h3>
                    </div>
                    <button type="button" onclick="document.getElementById('addBalanceModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                <div class="p-4 space-y-4">
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-sm text-gray-600">{{ __('crm.current_balance') }}: <span class="font-bold text-green-600">${{ number_format($affiliate->pending_earnings, 2) }}</span></p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('crm.amount') }} ($)</label>
                        <input type="number" name="amount" step="0.01" min="0.01" required
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                               placeholder="0.00">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('crm.reason') }} <span class="text-red-500">*</span></label>
                        <select name="reason" required
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">{{ __('crm.select_reason') }}</option>
                            <option value="bonus">{{ __('crm.bonus') }}</option>
                            <option value="adjustment">{{ __('crm.adjustment') }}</option>
                            <option value="promotion">{{ __('crm.promotion') }}</option>
                            <option value="other">{{ __('crm.other') }}</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('crm.notes') }}</label>
                        <textarea name="notes" rows="2" 
                                  class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                  placeholder="{{ __('crm.optional_notes') }}"></textarea>
                    </div>
                </div>
                
                <div class="flex flex-col-reverse sm:flex-row gap-2 p-4 border-t border-gray-100 bg-gray-50 rounded-b-xl">
                    <button type="button" onclick="document.getElementById('addBalanceModal').classList.add('hidden')"
                            class="w-full sm:w-auto px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        {{ __('crm.cancel') }}
                    </button>
                    <button type="submit"
                            class="w-full sm:w-auto px-4 py-2.5 bg-green-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-green-700 transition-colors sm:ms-auto">
                        {{ __('crm.add_balance') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Deduct Balance Modal -->
<div id="deductBalanceModal" class="hidden fixed inset-0 z-[9999] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-2 sm:p-4">
        <div class="fixed inset-0 bg-black/50" onclick="document.getElementById('deductBalanceModal').classList.add('hidden')"></div>
        
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-md mx-2 sm:mx-auto text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
            <form action="{{ route('admin.clients.deductAffiliateBalance', $client) }}" method="POST">
                @csrf
                
                <div class="flex items-center justify-between p-4 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-full bg-red-100">
                            <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ __('crm.deduct_balance') }}</h3>
                    </div>
                    <button type="button" onclick="document.getElementById('deductBalanceModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                <div class="p-4 space-y-4">
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-sm text-gray-600">{{ __('crm.current_balance') }}: <span class="font-bold text-green-600">${{ number_format($affiliate->pending_earnings, 2) }}</span></p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('crm.amount') }} ($)</label>
                        <input type="number" name="amount" step="0.01" min="0.01" max="{{ $affiliate->pending_earnings }}" required
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                               placeholder="0.00">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('crm.reason') }} <span class="text-red-500">*</span></label>
                        <select name="reason" required
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            <option value="">{{ __('crm.select_reason') }}</option>
                            <option value="correction">{{ __('crm.correction') }}</option>
                            <option value="chargeback">{{ __('crm.chargeback') }}</option>
                            <option value="refund">{{ __('crm.refund') }}</option>
                            <option value="other">{{ __('crm.other') }}</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('crm.notes') }}</label>
                        <textarea name="notes" rows="2" 
                                  class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                  placeholder="{{ __('crm.optional_notes') }}"></textarea>
                    </div>
                </div>
                
                <div class="flex flex-col-reverse sm:flex-row gap-2 p-4 border-t border-gray-100 bg-gray-50 rounded-b-xl">
                    <button type="button" onclick="document.getElementById('deductBalanceModal').classList.add('hidden')"
                            class="w-full sm:w-auto px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        {{ __('crm.cancel') }}
                    </button>
                    <button type="submit"
                            class="w-full sm:w-auto px-4 py-2.5 bg-red-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-red-700 transition-colors sm:ms-auto">
                        {{ __('crm.deduct_balance') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
