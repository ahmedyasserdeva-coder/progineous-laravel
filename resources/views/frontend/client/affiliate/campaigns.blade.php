@extends('frontend.client.layout')

@section('title', __('affiliate.campaigns'))

@section('content')
<div class="space-y-6" x-data="campaignManager()">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-2">
                <a href="{{ route('client.affiliate') }}" class="hover:text-blue-600 dark:hover:text-blue-400">{{ __('affiliate.dashboard') }}</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span>{{ __('affiliate.campaigns') }}</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('affiliate.campaign_links') }}</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('affiliate.campaigns_description') }}</p>
        </div>
        <button @click="showCreateModal = true" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z" clip-rule="evenodd" />
            </svg>
            {{ __('affiliate.create_campaign') }}
        </button>
    </div>

    <!-- Source Filter Tabs -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-2">
        <div class="flex flex-wrap gap-2">
            <button @click="filterBySource('all')" 
                :class="activeFilter === 'all' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700'"
                class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors">
                {{ __('affiliate.all_sources') }}
            </button>
            @foreach($sources as $key => $sourceItem)
            <button @click="filterBySource('{{ $key }}')"
                :class="activeFilter === '{{ $key }}' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700'"
                class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors">
                {{ $sourceItem['name'] }}
            </button>
            @endforeach
        </div>
    </div>

    <!-- Campaigns Grid -->
    @if($campaigns->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($campaigns as $campaign)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <!-- Campaign Header -->
            <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-3">
                        <!-- Source Icon -->
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center
                            @if($campaign->source === 'facebook') bg-blue-100 dark:bg-blue-900/30
                            @elseif($campaign->source === 'twitter') bg-sky-100 dark:bg-sky-900/30
                            @elseif($campaign->source === 'instagram') bg-pink-100 dark:bg-pink-900/30
                            @elseif($campaign->source === 'youtube') bg-red-100 dark:bg-red-900/30
                            @elseif($campaign->source === 'tiktok') bg-gray-100 dark:bg-gray-700
                            @elseif($campaign->source === 'linkedin') bg-blue-100 dark:bg-blue-900/30
                            @elseif($campaign->source === 'whatsapp') bg-green-100 dark:bg-green-900/30
                            @elseif($campaign->source === 'telegram') bg-sky-100 dark:bg-sky-900/30
                            @elseif($campaign->source === 'email') bg-gray-100 dark:bg-gray-700
                            @elseif($campaign->source === 'website') bg-purple-100 dark:bg-purple-900/30
                            @else bg-gray-100 dark:bg-gray-700 @endif">
                            @if($campaign->source === 'facebook')
                                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            @elseif($campaign->source === 'twitter')
                                <svg class="w-5 h-5 text-sky-500" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            @elseif($campaign->source === 'instagram')
                                <svg class="w-5 h-5 text-pink-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                            @elseif($campaign->source === 'youtube')
                                <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            @elseif($campaign->source === 'tiktok')
                                <svg class="w-5 h-5 text-gray-900 dark:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                            @elseif($campaign->source === 'linkedin')
                                <svg class="w-5 h-5 text-blue-700" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                            @elseif($campaign->source === 'whatsapp')
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            @elseif($campaign->source === 'telegram')
                                <svg class="w-5 h-5 text-sky-500" fill="currentColor" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
                            @elseif($campaign->source === 'email')
                                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z"/><path d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z"/></svg>
                            @elseif($campaign->source === 'website')
                                <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM6.262 6.072a8.25 8.25 0 1010.562-.766 4.5 4.5 0 01-1.318 1.357L14.25 7.5l.165.33a.809.809 0 01-1.086 1.085l-.604-.302a1.125 1.125 0 00-1.298.21l-.132.131c-.439.44-.439 1.152 0 1.591l.296.296c.256.257.622.374.98.314l1.17-.195c.323-.054.654.036.905.245l1.33 1.108c.32.267.46.694.358 1.1a8.7 8.7 0 01-2.288 4.04l-.723.724a1.125 1.125 0 01-1.298.21l-.153-.076a1.125 1.125 0 01-.622-1.006v-1.089c0-.298-.119-.585-.33-.796l-1.347-1.347a1.125 1.125 0 01-.21-1.298L9.75 12l-1.64-1.64a6 6 0 01-1.676-3.257l-.172-1.03z" clip-rule="evenodd"/></svg>
                            @else
                                <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M4.848 2.771A49.144 49.144 0 0112 2.25c2.43 0 4.817.178 7.152.52 1.978.292 3.348 2.024 3.348 3.97v6.02c0 1.946-1.37 3.678-3.348 3.97a48.901 48.901 0 01-3.476.383.39.39 0 00-.297.17l-2.755 4.133a.75.75 0 01-1.248 0l-2.755-4.133a.39.39 0 00-.297-.17 48.9 48.9 0 01-3.476-.384c-1.978-.29-3.348-2.024-3.348-3.97V6.741c0-1.946 1.37-3.68 3.348-3.97zM6.75 8.25a.75.75 0 01.75-.75h9a.75.75 0 010 1.5h-9a.75.75 0 01-.75-.75zm.75 2.25a.75.75 0 000 1.5H12a.75.75 0 000-1.5H7.5z" clip-rule="evenodd"/></svg>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white">{{ $campaign->name }}</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $sources[$campaign->source]['name'] ?? 'Other' }}</p>
                        </div>
                    </div>
                    <!-- Status Badge -->
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                        @if($campaign->status === 'active') bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400
                        @elseif($campaign->status === 'paused') bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400
                        @else bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400 @endif">
                        {{ ucfirst($campaign->status) }}
                    </span>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-3 divide-x divide-gray-200 dark:divide-gray-700 bg-gray-50 dark:bg-gray-900/50">
                <div class="px-4 py-3 text-center">
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ number_format($campaign->clicks) }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('affiliate.clicks') }}</p>
                </div>
                <div class="px-4 py-3 text-center">
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ number_format($campaign->referrals) }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('affiliate.referrals') }}</p>
                </div>
                <div class="px-4 py-3 text-center">
                    <p class="text-lg font-semibold text-green-600 dark:text-green-500">${{ number_format($campaign->earnings, 2) }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('affiliate.earnings') }}</p>
                </div>
            </div>

            <!-- Campaign Link -->
            <div class="p-4">
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5">{{ __('affiliate.tracking_link') }}</label>
                <div class="flex gap-2">
                    <input type="text" readonly value="{{ $campaign->tracking_link }}" 
                        class="flex-1 text-xs bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg px-3 py-2 text-gray-600 dark:text-gray-300 font-mono">
                    <button onclick="copyToClipboard('{{ $campaign->tracking_link }}')" 
                        class="p-2 text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors"
                        title="{{ __('affiliate.copy_link') }}">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7.5 3.375c0-1.036.84-1.875 1.875-1.875h.375a3.75 3.75 0 013.75 3.75v1.875C13.5 8.161 14.34 9 15.375 9h1.875A3.75 3.75 0 0121 12.75v3.375C21 17.16 20.16 18 19.125 18h-9.75A1.875 1.875 0 017.5 16.125V3.375z" />
                            <path d="M15 5.25a5.23 5.23 0 00-1.279-3.434 9.768 9.768 0 016.963 6.963A5.23 5.23 0 0017.25 7.5h-1.875A.375.375 0 0115 7.125V5.25zM4.875 6H6v10.125A3.375 3.375 0 009.375 19.5H16.5v1.125c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 013 20.625V7.875C3 6.839 3.84 6 4.875 6z" />
                        </svg>
                    </button>
                    <button @click="showQRModal('{{ $campaign->qr_code_url }}', '{{ $campaign->name }}', '{{ $campaign->tracking_link }}', {{ $campaign->clicks }}, {{ $campaign->referrals }})"
                        class="p-2 text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors"
                        title="{{ __('affiliate.show_qr') }}">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 4.875C3 3.839 3.84 3 4.875 3h4.5c1.036 0 1.875.84 1.875 1.875v4.5c0 1.036-.84 1.875-1.875 1.875h-4.5A1.875 1.875 0 013 9.375v-4.5zM4.875 4.5a.375.375 0 00-.375.375v4.5c0 .207.168.375.375.375h4.5a.375.375 0 00.375-.375v-4.5a.375.375 0 00-.375-.375h-4.5zm7.875.375c0-1.036.84-1.875 1.875-1.875h4.5C20.16 3 21 3.84 21 4.875v4.5c0 1.036-.84 1.875-1.875 1.875h-4.5a1.875 1.875 0 01-1.875-1.875v-4.5zm1.875-.375a.375.375 0 00-.375.375v4.5c0 .207.168.375.375.375h4.5a.375.375 0 00.375-.375v-4.5a.375.375 0 00-.375-.375h-4.5zM6 6.75A.75.75 0 016.75 6h.75a.75.75 0 01.75.75v.75a.75.75 0 01-.75.75h-.75A.75.75 0 016 7.5v-.75zm9.75 0A.75.75 0 0116.5 6h.75a.75.75 0 01.75.75v.75a.75.75 0 01-.75.75h-.75a.75.75 0 01-.75-.75v-.75zM3 14.625c0-1.036.84-1.875 1.875-1.875h4.5c1.036 0 1.875.84 1.875 1.875v4.5c0 1.036-.84 1.875-1.875 1.875h-4.5A1.875 1.875 0 013 19.125v-4.5zm1.875-.375a.375.375 0 00-.375.375v4.5c0 .207.168.375.375.375h4.5a.375.375 0 00.375-.375v-4.5a.375.375 0 00-.375-.375h-4.5zm7.875-.75a.75.75 0 01.75-.75h.75a.75.75 0 01.75.75v.75a.75.75 0 01-.75.75h-.75a.75.75 0 01-.75-.75v-.75zm.75 3.75a.75.75 0 00-.75.75v.75c0 .414.336.75.75.75h.75a.75.75 0 00.75-.75v-.75a.75.75 0 00-.75-.75h-.75zm3-3.75a.75.75 0 01.75-.75h2.25a.75.75 0 010 1.5H18v2.25a.75.75 0 01-1.5 0v-3zm3 3.75a.75.75 0 00-.75.75v.75c0 .414.336.75.75.75h.75a.75.75 0 00.75-.75v-.75a.75.75 0 00-.75-.75h-.75zM6 16.5a.75.75 0 01.75-.75h.75a.75.75 0 01.75.75v.75a.75.75 0 01-.75.75h-.75A.75.75 0 016 17.25v-.75z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Actions -->
            <div class="px-4 py-3 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <div class="text-xs text-gray-500 dark:text-gray-400">
                    @if($campaign->last_click_at)
                        {{ __('affiliate.last_click') }}: {{ $campaign->last_click_at->diffForHumans() }}
                    @else
                        {{ __('affiliate.no_clicks_yet') }}
                    @endif
                </div>
                <div class="flex items-center gap-1">
                    @if($campaign->status === 'active')
                    <button onclick="updateCampaignStatus({{ $campaign->id }}, 'paused')" class="p-1.5 text-yellow-600 hover:bg-yellow-100 dark:hover:bg-yellow-900/30 rounded-lg transition-colors" title="{{ __('affiliate.pause') }}">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M6.75 5.25a.75.75 0 01.75-.75H9a.75.75 0 01.75.75v13.5a.75.75 0 01-.75.75H7.5a.75.75 0 01-.75-.75V5.25zm7.5 0A.75.75 0 0115 4.5h1.5a.75.75 0 01.75.75v13.5a.75.75 0 01-.75.75H15a.75.75 0 01-.75-.75V5.25z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    @else
                    <button onclick="updateCampaignStatus({{ $campaign->id }}, 'active')" class="p-1.5 text-green-600 hover:bg-green-100 dark:hover:bg-green-900/30 rounded-lg transition-colors" title="{{ __('affiliate.activate') }}">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.5 5.653c0-1.426 1.529-2.33 2.779-1.643l11.54 6.348c1.295.712 1.295 2.573 0 3.285L7.28 19.991c-1.25.687-2.779-.217-2.779-1.643V5.653z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    @endif
                    <button onclick="deleteCampaign({{ $campaign->id }})" class="p-1.5 text-red-600 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-lg transition-colors" title="{{ __('affiliate.delete') }}">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($campaigns->hasPages())
    <div class="flex justify-center">
        {{ $campaigns->links() }}
    </div>
    @endif
    @else
    <!-- Empty State -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-12 text-center">
        <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-gray-400" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M19.902 4.098a3.75 3.75 0 00-5.304 0l-4.5 4.5a3.75 3.75 0 001.035 6.037.75.75 0 01-.646 1.353 5.25 5.25 0 01-1.449-8.45l4.5-4.5a5.25 5.25 0 117.424 7.424l-1.757 1.757a.75.75 0 11-1.06-1.06l1.757-1.757a3.75 3.75 0 000-5.304zm-7.389 4.267a.75.75 0 011-.353 5.25 5.25 0 011.449 8.45l-4.5 4.5a5.25 5.25 0 11-7.424-7.424l1.757-1.757a.75.75 0 111.06 1.06l-1.757 1.757a3.75 3.75 0 105.304 5.304l4.5-4.5a3.75 3.75 0 00-1.035-6.037.75.75 0 01-.354-1z" clip-rule="evenodd" />
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('affiliate.no_campaigns') }}</h3>
        <p class="text-gray-500 dark:text-gray-400 mb-6 max-w-md mx-auto">{{ __('affiliate.no_campaigns_description') }}</p>
        <button @click="showCreateModal = true" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z" clip-rule="evenodd" />
            </svg>
            {{ __('affiliate.create_first_campaign') }}
        </button>
    </div>
    @endif

    <!-- Create Campaign Modal -->
    <div x-show="showCreateModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="showCreateModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500/75 dark:bg-gray-900/75 transition-opacity" @click="showCreateModal = false"></div>

            <div x-show="showCreateModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-gray-800 shadow-xl rounded-2xl">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('affiliate.create_campaign') }}</h3>
                    <button @click="showCreateModal = false" class="p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                <form @submit.prevent="createCampaign">
                    <div class="space-y-4">
                        <!-- Campaign Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('affiliate.campaign_name') }} *</label>
                            <input type="text" x-model="newCampaign.name" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="{{ __('affiliate.campaign_name_placeholder') }}">
                        </div>

                        <!-- Source Platform -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('affiliate.source_platform') }} *</label>
                            <div class="grid grid-cols-4 gap-2">
                                @foreach($sources as $key => $source)
                                <label class="cursor-pointer">
                                    <input type="radio" name="source" x-model="newCampaign.source" value="{{ $key }}" class="sr-only peer">
                                    <div class="p-2 border border-gray-200 dark:border-gray-700 rounded-lg text-center peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/30 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <div class="flex flex-col items-center gap-1">
                                            @if($key === 'facebook')
                                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                            @elseif($key === 'twitter')
                                            <svg class="w-5 h-5 text-sky-500" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                            @elseif($key === 'instagram')
                                            <svg class="w-5 h-5 text-pink-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                            @elseif($key === 'youtube')
                                            <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                            @elseif($key === 'tiktok')
                                            <svg class="w-5 h-5 text-gray-900 dark:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                                            @elseif($key === 'linkedin')
                                            <svg class="w-5 h-5 text-blue-700" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                            @elseif($key === 'whatsapp')
                                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                            @elseif($key === 'telegram')
                                            <svg class="w-5 h-5 text-sky-500" fill="currentColor" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
                                            @elseif($key === 'email')
                                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z"/><path d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z"/></svg>
                                            @elseif($key === 'website')
                                            <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM6.262 6.072a8.25 8.25 0 1010.562-.766 4.5 4.5 0 01-1.318 1.357L14.25 7.5l.165.33a.809.809 0 01-1.086 1.085l-.604-.302a1.125 1.125 0 00-1.298.21l-.132.131c-.439.44-.439 1.152 0 1.591l.296.296c.256.257.622.374.98.314l1.17-.195c.323-.054.654.036.905.245l1.33 1.108c.32.267.46.694.358 1.1a8.7 8.7 0 01-2.288 4.04l-.723.724a1.125 1.125 0 01-1.298.21l-.153-.076a1.125 1.125 0 01-.622-1.006v-1.089c0-.298-.119-.585-.33-.796l-1.347-1.347a1.125 1.125 0 01-.21-1.298L9.75 12l-1.64-1.64a6 6 0 01-1.676-3.257l-.172-1.03z" clip-rule="evenodd" /></svg>
                                            @else
                                            <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M4.848 2.771A49.144 49.144 0 0112 2.25c2.43 0 4.817.178 7.152.52 1.978.292 3.348 2.024 3.348 3.97v6.02c0 1.946-1.37 3.678-3.348 3.97a48.901 48.901 0 01-3.476.383.39.39 0 00-.297.17l-2.755 4.133a.75.75 0 01-1.248 0l-2.755-4.133a.39.39 0 00-.297-.17 48.9 48.9 0 01-3.476-.384c-1.978-.29-3.348-2.024-3.348-3.97V6.741c0-1.946 1.37-3.68 3.348-3.97zM6.75 8.25a.75.75 0 01.75-.75h9a.75.75 0 010 1.5h-9a.75.75 0 01-.75-.75zm.75 2.25a.75.75 0 000 1.5H12a.75.75 0 000-1.5H7.5z" clip-rule="evenodd" /></svg>
                                            @endif
                                            <span class="text-xs text-gray-600 dark:text-gray-400">{{ $source['name'] }}</span>
                                        </div>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('affiliate.description') }}</label>
                            <textarea x-model="newCampaign.description" rows="2"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="{{ __('affiliate.description_placeholder') }}"></textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="button" @click="showCreateModal = false" class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            {{ __('affiliate.cancel') }}
                        </button>
                        <button type="submit" :disabled="isLoading" class="flex-1 px-4 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50 flex items-center justify-center gap-2">
                            <svg x-show="isLoading" class="w-4 h-4 animate-spin" viewBox="0 0 24 24" fill="none">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            {{ __('affiliate.create') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- QR Code Modal -->
    <div x-show="showQR" x-cloak class="fixed inset-0 z-50 overflow-y-auto backdrop-blur-sm" aria-labelledby="qr-modal" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 py-8">
            <div x-show="showQR" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gradient-to-br from-gray-900/80 via-gray-800/70 to-gray-900/80" @click="showQR = false"></div>

            <div x-show="showQR" 
                x-transition:enter="ease-out duration-300" 
                x-transition:enter-start="opacity-0 scale-90 translate-y-4" 
                x-transition:enter-end="opacity-100 scale-100 translate-y-0" 
                x-transition:leave="ease-in duration-200" 
                x-transition:leave-start="opacity-100 scale-100" 
                x-transition:leave-end="opacity-0 scale-90" 
                class="relative w-full max-w-md mx-auto">
                
                <!-- Decorative background elements -->
                <div class="absolute -inset-1 bg-gradient-to-r from-blue-500 via-blue-600 to-blue-500 rounded-3xl blur-lg opacity-30 animate-pulse"></div>
                
                <!-- Modal content -->
                <div class="relative bg-white dark:bg-gray-900 rounded-3xl shadow-2xl overflow-hidden">
                    <!-- Header with gradient -->
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M3 11h8V3H3v8zm2-6h4v4H5V5zM3 21h8v-8H3v8zm2-6h4v4H5v-4zM13 3v8h8V3h-8zm6 6h-4V5h4v4zM13 13h2v2h-2zM15 15h2v2h-2zM13 17h2v2h-2zM17 13h2v2h-2zM19 15h2v2h-2zM17 17h2v2h-2zM15 19h2v2h-2zM19 19h2v2h-2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-white" x-text="qrCampaignName"></h3>
                                    <p class="text-sm text-white/70">{{ __('affiliate.campaign_qr_code') }}</p>
                                </div>
                            </div>
                            <button @click="showQR = false" class="w-8 h-8 bg-white/10 hover:bg-white/20 backdrop-blur rounded-lg flex items-center justify-center transition-colors">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- QR Code section -->
                    <div class="p-6">
                        <div class="relative mx-auto w-fit">
                            <!-- QR container with styling -->
                            <div class="relative bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 p-6 rounded-2xl shadow-inner" id="qr-container">
                                <!-- Corner decorations -->
                                <div class="absolute top-2 left-2 w-4 h-4 border-l-2 border-t-2 border-blue-500 rounded-tl-lg"></div>
                                <div class="absolute top-2 right-2 w-4 h-4 border-r-2 border-t-2 border-blue-400 rounded-tr-lg"></div>
                                <div class="absolute bottom-2 left-2 w-4 h-4 border-l-2 border-b-2 border-blue-400 rounded-bl-lg"></div>
                                <div class="absolute bottom-2 right-2 w-4 h-4 border-r-2 border-b-2 border-blue-500 rounded-br-lg"></div>
                                
                                <!-- QR Code -->
                                <div class="bg-white p-3 rounded-xl shadow-lg relative">
                                    <img :src="qrCodeUrl" alt="QR Code" class="w-52 h-52" id="qr-image">
                                    <!-- Logo overlay -->
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="bg-white p-2 rounded-xl shadow-md ring-2 ring-gray-100">
                                            <img src="{{ asset('logo/pro Gineous_white logo_blue icon.svg') }}" alt="Logo" class="w-12 h-12">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Scan indicator -->
                            <div class="absolute -bottom-3 left-1/2 -translate-x-1/2">
                                <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white text-xs font-medium px-4 py-1.5 rounded-full shadow-lg flex items-center gap-1.5">
                                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                                    {{ __('affiliate.ready_to_scan') }}
                                </div>
                            </div>
                        </div>
                        
                        <!-- Description -->
                        <p class="text-center text-sm text-gray-500 dark:text-gray-400 mt-6 mb-6">
                            {{ __('affiliate.scan_qr_description') }}
                        </p>
                        
                        <!-- Action buttons -->
                        <div class="grid grid-cols-2 gap-3">
                            <button @click="downloadQR()" class="group relative px-4 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium rounded-xl transition-all duration-200 flex items-center justify-center gap-2 shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 hover:-translate-y-0.5">
                                <svg class="w-5 h-5 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                {{ __('affiliate.download_qr') }}
                            </button>
                            <button @click="copyTrackingLink()" class="group px-4 py-3 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-xl transition-all duration-200 flex items-center justify-center gap-2 hover:-translate-y-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                {{ __('affiliate.copy_link') }}
                            </button>
                        </div>
                    </div>
                    
                    <!-- Footer stats -->
                    <div class="bg-gray-50 dark:bg-gray-800/50 px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-center gap-6 text-sm">
                            <div class="flex items-center gap-2 text-gray-500 dark:text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <span x-text="qrStats.clicks || 0"></span> {{ __('affiliate.clicks') }}
                            </div>
                            <div class="w-px h-4 bg-gray-300 dark:bg-gray-600"></div>
                            <div class="flex items-center gap-2 text-gray-500 dark:text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span x-text="qrStats.referrals || 0"></span> {{ __('affiliate.referrals') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function campaignManager() {
    return {
        showCreateModal: false,
        showQR: false,
        qrCodeUrl: '',
        qrCampaignName: '',
        qrTrackingLink: '',
        qrStats: { clicks: 0, referrals: 0 },
        isLoading: false,
        isFiltering: false,
        activeFilter: 'all',
        campaignSources: @json($usedSources ?? []),
        newCampaign: {
            name: '',
            source: 'facebook',
            description: '',
            destination_url: ''
        },

        filterBySource(source) {
            // Navigate to filtered page
            const url = new URL(window.location.href);
            url.searchParams.set('source', source);
            url.searchParams.delete('page'); // Reset to first page
            window.location.href = url.toString();
        },

        init() {
            // Set active filter from URL
            const urlParams = new URLSearchParams(window.location.search);
            this.activeFilter = urlParams.get('source') || 'all';
        },

        showQRModal(url, name, trackingLink = '', clicks = 0, referrals = 0) {
            this.qrCodeUrl = url;
            this.qrCampaignName = name;
            this.qrTrackingLink = trackingLink;
            this.qrStats = { clicks, referrals };
            this.showQR = true;
        },

        copyTrackingLink() {
            if (this.qrTrackingLink) {
                navigator.clipboard.writeText(this.qrTrackingLink).then(() => {
                    alert('{{ __("affiliate.copied") }}');
                });
            }
        },

        async downloadQR() {
            try {
                // Create a canvas to combine QR and logo
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                const size = 400; // High resolution
                canvas.width = size;
                canvas.height = size;

                // Load QR image
                const qrImg = new Image();
                qrImg.crossOrigin = 'anonymous';
                
                qrImg.onload = async () => {
                    // Draw white background
                    ctx.fillStyle = '#ffffff';
                    ctx.fillRect(0, 0, size, size);
                    
                    // Draw QR code
                    ctx.drawImage(qrImg, 0, 0, size, size);
                    
                    // Load and draw logo
                    const logoImg = new Image();
                    logoImg.crossOrigin = 'anonymous';
                    logoImg.onload = () => {
                        const logoSize = size * 0.2; // 20% of QR size
                        const logoX = (size - logoSize) / 2;
                        const logoY = (size - logoSize) / 2;
                        
                        // Draw white background for logo
                        ctx.fillStyle = '#ffffff';
                        ctx.beginPath();
                        ctx.roundRect(logoX - 8, logoY - 8, logoSize + 16, logoSize + 16, 8);
                        ctx.fill();
                        
                        // Draw logo
                        ctx.drawImage(logoImg, logoX, logoY, logoSize, logoSize);
                        
                        // Download
                        const link = document.createElement('a');
                        link.download = this.qrCampaignName.replace(/[^a-z0-9]/gi, '_') + '_qr.png';
                        link.href = canvas.toDataURL('image/png');
                        link.click();
                    };
                    logoImg.src = '{{ asset("logo/pro Gineous_white logo_blue icon.svg") }}';
                };
                
                qrImg.src = this.qrCodeUrl;
            } catch (error) {
                console.error('Error downloading QR:', error);
                // Fallback: direct download
                const link = document.createElement('a');
                link.href = this.qrCodeUrl;
                link.download = this.qrCampaignName + '_qr.png';
                link.click();
            }
        },

        async createCampaign() {
            this.isLoading = true;
            try {
                const response = await fetch('{{ route("client.affiliate.campaigns.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(this.newCampaign)
                });

                const data = await response.json();
                
                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.message || 'Error creating campaign');
                }
            } catch (error) {
                alert('Error creating campaign');
            } finally {
                this.isLoading = false;
            }
        }
    }
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        // Show success toast or feedback
        alert('{{ __("affiliate.copied") }}');
    });
}

async function updateCampaignStatus(id, status) {
    if (!confirm('{{ __("affiliate.confirm_status_change") }}')) return;
    
    try {
        const response = await fetch(`/affiliate/campaigns/${id}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ status })
        });

        const data = await response.json();
        
        if (data.success) {
            window.location.reload();
        } else {
            alert(data.message || 'Error updating campaign');
        }
    } catch (error) {
        alert('Error updating campaign');
    }
}

async function deleteCampaign(id) {
    if (!confirm('{{ __("affiliate.confirm_delete_campaign") }}')) return;
    
    try {
        const response = await fetch(`/affiliate/campaigns/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        });

        const data = await response.json();
        
        if (data.success) {
            window.location.reload();
        } else {
            alert(data.message || 'Error deleting campaign');
        }
    } catch (error) {
        alert('Error deleting campaign');
    }
}
</script>
@endsection
