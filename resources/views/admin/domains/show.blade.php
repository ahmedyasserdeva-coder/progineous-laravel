@extends('admin.layout')

@section('title', $domain->domain_name . ' - ' . __('crm.domain_management'))

@section('content')
<div class="container mx-auto px-4 py-6" x-data="domainManager()">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.clients.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    {{ __('crm.clients') }}
                </a>
            </li>
            @if($domain->client)
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <a href="{{ route('admin.clients.show', $domain->client) }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">
                        {{ $domain->client->first_name }} {{ $domain->client->last_name }}
                    </a>
                </div>
            </li>
            @endif
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-500">{{ $domain->domain_name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl p-6 text-white mb-6">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-lg backdrop-blur-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold">{{ $domain->domain_name }}</h1>
                    <p class="text-white/70 text-sm">{{ __('crm.domain_id') ?? 'Domain ID' }}: #{{ $domain->id }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <!-- Dynamic Status Badge in Header -->
                <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-semibold bg-white/20 text-white"
                      x-data="{
                          statusLabels: {
                              'active': { en: 'Active', ar: 'نشط' },
                              'pending': { en: 'Pending', ar: 'قيد الانتظار' },
                              'pending_registration': { en: 'Pending Registration', ar: 'في انتظار التسجيل' },
                              'pending_transfer': { en: 'Pending Transfer', ar: 'في انتظار النقل' },
                              'grace_period': { en: 'Grace Period', ar: 'فترة السماح' },
                              'redemption_period': { en: 'Redemption Period', ar: 'فترة الاسترداد' },
                              'expired': { en: 'Expired', ar: 'منتهي' },
                              'transferred_away': { en: 'Transferred Away', ar: 'تم نقله' },
                              'cancelled': { en: 'Cancelled', ar: 'ملغي' },
                              'fraud': { en: 'Fraud', ar: 'احتيال' }
                          },
                          isArabic: {{ app()->getLocale() == 'ar' ? 'true' : 'false' }},
                          getLabel() {
                              return this.isArabic ? this.statusLabels[status]?.ar : this.statusLabels[status]?.en;
                          }
                      }">
                    <svg x-show="status === 'active'" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <svg x-show="status === 'pending' || status === 'pending_registration' || status === 'pending_transfer'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <svg x-show="status === 'expired' || status === 'cancelled'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <svg x-show="status === 'grace_period' || status === 'redemption_period' || status === 'fraud'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <span x-text="getLabel()"></span>
                </span>
                @if($domain->client)
                <a href="{{ route('admin.clients.show', $domain->client) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 text-white rounded-lg hover:bg-white/30 transition-colors text-sm font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    {{ __('crm.view_client') }}
                </a>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Domain Details Card -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        {{ __('crm.domain_details') ?? 'Domain Details' }}
                    </h3>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Order ID -->
                        <div class="group flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100 hover:bg-white hover:border-gray-200 hover:shadow-sm transition-all duration-200">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center group-hover:bg-slate-500 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500 mb-0.5">{{ __('crm.order_id') ?? 'Order ID' }}</p>
                                <p class="text-sm font-semibold text-gray-900 truncate">
                                    @if($domain->order)
                                        <a href="#" class="text-blue-600 hover:underline">#{{ $domain->order_id }}</a>
                                    @else
                                        {{ $domain->order_id ? '#' . $domain->order_id : '-' }}
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Order Type -->
                        <div class="group flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100 hover:bg-white hover:border-gray-200 hover:shadow-sm transition-all duration-200">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg {{ ($domain->order_type ?? 'register') == 'register' ? 'bg-green-100 text-green-600 group-hover:bg-green-500' : 'bg-blue-100 text-blue-600 group-hover:bg-blue-500' }} flex items-center justify-center group-hover:text-white transition-colors">
                                @if(($domain->order_type ?? 'register') == 'register')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                    </svg>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500 mb-0.5">{{ __('crm.order_type') ?? 'Order Type' }}</p>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ ($domain->order_type ?? 'register') == 'register' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ ($domain->order_type ?? 'register') == 'register' ? (__('crm.register') ?? 'Register') : (__('crm.transfer') ?? 'Transfer') }}
                                </span>
                            </div>
                        </div>

                        <!-- Domain Name -->
                        <div class="group flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100 hover:bg-white hover:border-gray-200 hover:shadow-sm transition-all duration-200">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center group-hover:bg-blue-500 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0 overflow-hidden">
                                <p class="text-xs text-gray-500 mb-0.5">{{ __('crm.domain') ?? 'Domain' }}</p>
                                <template x-if="!editingDomainName">
                                    <div class="flex items-center gap-2">
                                        <p class="text-sm font-semibold text-gray-900 truncate" x-text="domainName"></p>
                                        <button @click="editingDomainName = true" class="flex-shrink-0 text-gray-400 hover:text-blue-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                                <template x-if="editingDomainName">
                                    <div class="flex items-center gap-1">
                                        <input type="text" x-model="domainName" 
                                               class="min-w-0 flex-1 px-2 py-1 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                               @keydown.enter="updateDomainName()" @keydown.escape="editingDomainName = false">
                                        <button @click="updateDomainName()" class="flex-shrink-0 p-1 text-blue-600 hover:text-blue-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </button>
                                        <button @click="editingDomainName = false" class="flex-shrink-0 p-1 text-gray-400 hover:text-red-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- TLD -->
                        <div class="group flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100 hover:bg-white hover:border-gray-200 hover:shadow-sm transition-all duration-200">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center group-hover:bg-indigo-500 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500 mb-0.5">{{ __('crm.tld') }}</p>
                                <p class="text-sm font-semibold text-gray-900 truncate">.{{ ltrim($domain->tld, '.') }}</p>
                            </div>
                        </div>

                        <!-- Registrar -->
                        <div class="group flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100 hover:bg-white hover:border-gray-200 hover:shadow-sm transition-all duration-200">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center group-hover:bg-purple-500 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500 mb-0.5">{{ __('crm.registrar') ?? 'Registrar' }}</p>
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ $domain->registrar ?? 'Dynadot' }}</p>
                            </div>
                        </div>

                        <!-- Registrar Domain ID -->
                        <div class="group flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100 hover:bg-white hover:border-gray-200 hover:shadow-sm transition-all duration-200">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-cyan-100 text-cyan-600 flex items-center justify-center group-hover:bg-cyan-500 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500 mb-0.5">{{ __('crm.registrar_domain_id') ?? 'Registrar Domain ID' }}</p>
                                <p class="text-sm font-mono text-gray-900 truncate">{{ $domain->registrar_domain_id ?? '-' }}</p>
                            </div>
                        </div>

                        <!-- Auth Code (Transfer Code) - Only show for transfer orders -->
                        @if(($domain->order_type ?? 'register') == 'transfer')
                        @php
                            $authCode = null;
                            // Check domain configuration first
                            if (!empty($domain->configuration['auth_code'])) {
                                $authCode = $domain->configuration['auth_code'];
                            }
                            // Check related OrderItem if not found
                            if (empty($authCode) && $domain->order_id) {
                                $orderItem = \App\Models\OrderItem::where('order_id', $domain->order_id)
                                    ->where('type', 'domain')
                                    ->first();
                                if ($orderItem) {
                                    $authCode = $orderItem->configuration['auth_code'] ?? null;
                                }
                            }
                        @endphp
                        <div class="group flex items-center gap-3 p-3 bg-amber-50 rounded-xl border border-amber-200 hover:bg-amber-100 hover:border-amber-300 hover:shadow-sm transition-all duration-200">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-amber-600 mb-0.5">{{ __('crm.transfer_auth_code') ?? 'Transfer Auth Code' }}</p>
                                <template x-if="!editingAuthCode">
                                    <div class="flex items-center gap-2">
                                        <p class="text-sm font-mono font-semibold text-amber-800 truncate" x-text="authCode || '{{ __('crm.not_set') ?? 'Not set' }}'"></p>
                                        <button @click="editingAuthCode = true" class="flex-shrink-0 text-amber-500 hover:text-amber-700 transition-colors" title="{{ __('crm.edit') ?? 'Edit' }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </button>
                                        <button x-show="authCode" @click="navigator.clipboard.writeText(authCode); $dispatch('notify', {message: '{{ __('crm.copied') ?? 'Copied!' }}', type: 'success'})" 
                                                class="flex-shrink-0 text-amber-500 hover:text-amber-700 transition-colors" title="{{ __('crm.copy') ?? 'Copy' }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                                <template x-if="editingAuthCode">
                                    <div class="flex items-center gap-1">
                                        <input type="text" x-model="authCode" 
                                               class="min-w-0 flex-1 px-2 py-1 text-sm font-mono border border-amber-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 bg-white"
                                               placeholder="{{ __('crm.enter_auth_code') ?? 'Enter auth code...' }}"
                                               @keydown.enter="updateAuthCode()" @keydown.escape="editingAuthCode = false">
                                        <button @click="updateAuthCode()" class="flex-shrink-0 p-1 text-green-600 hover:text-green-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </button>
                                        <button @click="editingAuthCode = false" class="flex-shrink-0 p-1 text-gray-400 hover:text-red-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                        @endif

                        <!-- First Payment Amount -->
                        <div class="group flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100 hover:bg-white hover:border-gray-200 hover:shadow-sm transition-all duration-200">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-green-100 text-green-600 flex items-center justify-center group-hover:bg-green-500 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500 mb-0.5">{{ __('crm.first_payment_amount') ?? 'First Payment Amount' }}</p>
                                <template x-if="!editingFirstPayment">
                                    <div class="flex items-center gap-2">
                                        <p class="text-sm font-bold text-green-600" dir="ltr">$<span x-text="parseFloat(firstPaymentAmount).toFixed(2)"></span></p>
                                        <button @click="editingFirstPayment = true" class="text-gray-400 hover:text-blue-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                                <template x-if="editingFirstPayment">
                                    <div class="flex items-center gap-2">
                                        <div class="relative flex-1">
                                            <span class="absolute inset-y-0 start-0 flex items-center ps-2 text-gray-500 text-sm">$</span>
                                            <input type="number" step="0.01" min="0" x-model="firstPaymentAmount" 
                                                   class="w-full ps-6 pe-2 py-1 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                                   @keydown.enter="updateFirstPayment()" @keydown.escape="editingFirstPayment = false">
                                        </div>
                                        <button @click="updateFirstPayment()" class="text-green-600 hover:text-green-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </button>
                                        <button @click="editingFirstPayment = false" class="text-gray-400 hover:text-red-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Recurring Amount -->
                        <div class="group flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100 hover:bg-white hover:border-gray-200 hover:shadow-sm transition-all duration-200">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500 mb-0.5">{{ __('crm.recurring_amount') ?? 'Recurring Amount' }}</p>
                                <template x-if="!editingRecurringAmount">
                                    <div class="flex items-center gap-2">
                                        <p class="text-sm font-bold text-blue-600" dir="ltr">$<span x-text="parseFloat(recurringAmount).toFixed(2)"></span></p>
                                        <button @click="editingRecurringAmount = true" class="text-gray-400 hover:text-blue-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                                <template x-if="editingRecurringAmount">
                                    <div class="flex items-center gap-2">
                                        <div class="relative flex-1">
                                            <span class="absolute inset-y-0 start-0 flex items-center ps-2 text-gray-500 text-sm">$</span>
                                            <input type="number" step="0.01" min="0" x-model="recurringAmount" 
                                                   class="w-full ps-6 pe-2 py-1 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                   @keydown.enter="updateRecurringAmount()" @keydown.escape="editingRecurringAmount = false">
                                        </div>
                                        <button @click="updateRecurringAmount()" class="text-blue-600 hover:text-blue-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </button>
                                        <button @click="editingRecurringAmount = false" class="text-gray-400 hover:text-red-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Registration Period -->
                        <div class="group flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100 hover:bg-white hover:border-gray-200 hover:shadow-sm transition-all duration-200">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500 mb-0.5">{{ __('crm.registration_period') ?? 'Registration Period' }}</p>
                                <template x-if="!editingRegistrationPeriod">
                                    <div class="flex items-center gap-2">
                                        <p class="text-sm font-semibold text-gray-900"><span x-text="registrationPeriod"></span> {{ __('crm.years') ?? 'Year(s)' }}</p>
                                        <button @click="editingRegistrationPeriod = true" class="text-gray-400 hover:text-amber-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                                <template x-if="editingRegistrationPeriod">
                                    <div class="flex items-center gap-2">
                                        <select x-model="registrationPeriod" 
                                                class="py-1 px-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                            <option value="1">1 {{ __('crm.year') ?? 'Year' }}</option>
                                            <option value="2">2 {{ __('crm.years') ?? 'Years' }}</option>
                                            <option value="3">3 {{ __('crm.years') ?? 'Years' }}</option>
                                            <option value="4">4 {{ __('crm.years') ?? 'Years' }}</option>
                                            <option value="5">5 {{ __('crm.years') ?? 'Years' }}</option>
                                            <option value="10">10 {{ __('crm.years') ?? 'Years' }}</option>
                                        </select>
                                        <button @click="updateRegistrationPeriod()" class="text-amber-600 hover:text-amber-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </button>
                                        <button @click="editingRegistrationPeriod = false" class="text-gray-400 hover:text-red-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="group flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100 hover:bg-white hover:border-gray-200 hover:shadow-sm transition-all duration-200">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center group-hover:bg-rose-500 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500 mb-0.5">{{ __('crm.payment_method') ?? 'Payment Method' }}</p>
                                @php
                                    // Try to get payment method from multiple sources
                                    $paymentMethod = $domain->payment_method;
                                    
                                    // If not in domain, try from order
                                    if (empty($paymentMethod) && $domain->order) {
                                        $paymentMethod = $domain->order->payment_method;
                                    }
                                    
                                    // If still empty, try from invoice payments
                                    if (empty($paymentMethod) && $domain->order?->invoice) {
                                        $firstPayment = $domain->order->invoice->payments()->first();
                                        if ($firstPayment) {
                                            $paymentMethod = $firstPayment->gateway;
                                        }
                                    }
                                @endphp
                                @if($paymentMethod)
                                    <p class="text-sm font-semibold text-gray-900">{{ ucfirst(str_replace('_', ' ', $paymentMethod)) }}</p>
                                @else
                                    <p class="text-sm text-gray-400">-</p>
                                @endif
                            </div>
                        </div>

                        <!-- Promotion Code -->
                        <div class="md:col-span-2 group flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100 hover:bg-white hover:border-gray-200 hover:shadow-sm transition-all duration-200">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-violet-100 text-violet-600 flex items-center justify-center group-hover:bg-violet-500 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500 mb-0.5">{{ __('crm.promotion_code') ?? 'Promotion Code' }}</p>
                                @if($domain->promotion_code)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-violet-100 text-violet-700 rounded-full text-xs font-medium">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        {{ $domain->promotion_code }}
                                    </span>
                                @else
                                    <p class="text-sm text-gray-400">{{ __('crm.no_promo_applied') ?? 'No promotion applied' }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Important Dates Card -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ __('crm.important_dates') ?? 'Important Dates' }}
                    </h3>
                    <button @click="fetchDomainDates()" 
                            :disabled="fetchingDates"
                            class="inline-flex items-center gap-2 px-3 py-1.5 text-sm font-medium text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="w-4 h-4" :class="fetchingDates ? 'animate-spin' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <span x-text="fetchingDates ? '{{ __('crm.fetching') ?? 'Fetching...' }}' : '{{ __('crm.get') ?? 'Get' }}'"></span>
                    </button>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Registration Date -->
                        <div class="bg-green-50 rounded-lg p-4 border border-green-100">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="p-1.5 bg-green-100 rounded">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <span class="text-xs font-medium text-green-700">{{ __('crm.registration_date') }}</span>
                            </div>
                            <p class="text-lg font-bold text-green-800" x-text="registrationDate || '-'"></p>
                            <p class="text-xs text-green-600 mt-1" x-text="registrationDateHuman || ''"></p>
                        </div>

                        <!-- Expiry Date -->
                        <div class="rounded-lg p-4 border transition-colors"
                             :class="expiryStatus === 'expired' ? 'bg-red-50 border-red-100' : (expiryStatus === 'expiring' ? 'bg-amber-50 border-amber-100' : 'bg-blue-50 border-blue-100')">
                            <div class="flex items-center justify-between gap-2 mb-2">
                                <div class="flex items-center gap-2">
                                    <div class="p-1.5 rounded"
                                         :class="expiryStatus === 'expired' ? 'bg-red-100' : (expiryStatus === 'expiring' ? 'bg-amber-100' : 'bg-blue-100')">
                                        <svg class="w-4 h-4" :class="expiryStatus === 'expired' ? 'text-red-600' : (expiryStatus === 'expiring' ? 'text-amber-600' : 'text-blue-600')" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-medium" :class="expiryStatus === 'expired' ? 'text-red-700' : (expiryStatus === 'expiring' ? 'text-amber-700' : 'text-blue-700')">{{ __('crm.expiry_date') }}</span>
                                </div>
                                <button @click="editingExpiryDate = !editingExpiryDate" class="p-1 hover:bg-white/50 rounded transition-colors" :class="expiryStatus === 'expired' ? 'text-red-600' : (expiryStatus === 'expiring' ? 'text-amber-600' : 'text-blue-600')">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                </button>
                            </div>
                            <!-- Display Mode -->
                            <div x-show="!editingExpiryDate">
                                <p class="text-lg font-bold" :class="expiryStatus === 'expired' ? 'text-red-800' : (expiryStatus === 'expiring' ? 'text-amber-800' : 'text-blue-800')" x-text="expiryDate || '-'"></p>
                                <p class="text-xs mt-1" :class="expiryStatus === 'expired' ? 'text-red-600' : (expiryStatus === 'expiring' ? 'text-amber-600' : 'text-blue-600')" x-text="expiryDateHuman || ''"></p>
                            </div>
                            <!-- Edit Mode -->
                            <div x-show="editingExpiryDate" x-cloak class="space-y-2">
                                <input type="date" 
                                       x-model="expiryDateInput"
                                       class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <div class="flex gap-2">
                                    <button @click="updateExpiryDate()" class="flex-1 px-2 py-1 text-xs font-medium text-white bg-blue-600 rounded hover:bg-blue-700 transition-colors">
                                        {{ __('crm.save') ?? 'Save' }}
                                    </button>
                                    <button @click="editingExpiryDate = false" class="flex-1 px-2 py-1 text-xs font-medium text-gray-700 bg-gray-200 rounded hover:bg-gray-300 transition-colors">
                                        {{ __('crm.cancel') ?? 'Cancel' }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Next Due Date -->
                        <div class="bg-purple-50 rounded-lg p-4 border border-purple-100">
                            <div class="flex items-center justify-between gap-2 mb-2">
                                <div class="flex items-center gap-2">
                                    <div class="p-1.5 bg-purple-100 rounded">
                                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-medium text-purple-700">{{ __('crm.next_due_date') ?? 'Next Due Date' }}</span>
                                </div>
                                <button @click="editingNextDueDate = !editingNextDueDate" class="p-1 text-purple-600 hover:bg-purple-100 rounded transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                </button>
                            </div>
                            <!-- Display Mode -->
                            <div x-show="!editingNextDueDate">
                                <p class="text-lg font-bold text-purple-800" x-text="nextDueDate || '-'"></p>
                                <p class="text-xs text-purple-600 mt-1" x-text="nextDueDateHuman || ''"></p>
                            </div>
                            <!-- Edit Mode -->
                            <div x-show="editingNextDueDate" x-cloak class="space-y-2">
                                <input type="date" 
                                       x-model="nextDueDateInput"
                                       class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                <div class="flex gap-2">
                                    <button @click="updateNextDueDate()" class="flex-1 px-2 py-1 text-xs font-medium text-white bg-purple-600 rounded hover:bg-purple-700 transition-colors">
                                        {{ __('crm.save') ?? 'Save' }}
                                    </button>
                                    <button @click="editingNextDueDate = false" class="flex-1 px-2 py-1 text-xs font-medium text-gray-700 bg-gray-200 rounded hover:bg-gray-300 transition-colors">
                                        {{ __('crm.cancel') ?? 'Cancel' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nameservers Card -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-4 sm:px-5 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 flex items-center gap-3">
                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-500/25 flex-shrink-0">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <span class="block truncate">{{ __('crm.nameservers') }}</span>
                                <p class="text-xs font-normal text-gray-500 mt-0.5 hidden sm:block">{{ __('crm.nameservers_description') ?? 'Configure DNS servers for your domain' }}</p>
                            </div>
                        </h3>
                        <div class="flex gap-2 w-full sm:w-auto">
                            <button @click="fetchNameservers()" 
                                    :disabled="fetchingNameservers"
                                    class="inline-flex items-center justify-center gap-2 px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-blue-700 bg-blue-100 border border-blue-200 rounded-xl hover:bg-blue-200 hover:border-blue-300 transition-all duration-200 shadow-sm flex-1 sm:flex-initial disabled:opacity-50 disabled:cursor-not-allowed">
                                <svg class="w-4 h-4 flex-shrink-0" :class="fetchingNameservers ? 'animate-spin' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                <span class="truncate" x-text="fetchingNameservers ? '{{ __('crm.fetching') ?? 'Fetching...' }}' : '{{ __('crm.get') ?? 'Get' }}'"></span>
                            </button>
                            <button @click="resetNameservers()" 
                                    class="inline-flex items-center justify-center gap-2 px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm flex-1 sm:flex-initial">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                <span class="truncate">{{ __('crm.reset_to_default') ?? 'Reset to Default' }}</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-4 sm:p-6">
                    @php
                        $nameservers = $domain->nameservers;
                        if (is_string($nameservers)) {
                            $nameservers = json_decode($nameservers, true) ?? [];
                        }
                        $nameservers = is_array($nameservers) ? $nameservers : [];
                    @endphp
                    <div class="space-y-3">
                        @for($i = 1; $i <= 4; $i++)
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br {{ $i <= 2 ? 'from-blue-500 to-blue-600' : 'from-gray-400 to-gray-500' }} flex items-center justify-center shadow-sm flex-shrink-0">
                                    <span class="text-white text-sm font-bold">{{ $i }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <input type="text" 
                                           x-model="nameservers[{{ $i - 1 }}]"
                                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-sm font-mono bg-white placeholder-gray-400 transition-all duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 hover:border-gray-400"
                                           placeholder="ns{{ $i }}.example.com">
                                </div>
                                @if($i <= 2)
                                    <span class="text-xs font-medium text-blue-600 bg-blue-100 px-2 py-1 rounded-md flex-shrink-0 hidden sm:inline-block">{{ __('crm.required') ?? 'Required' }}</span>
                                @endif
                            </div>
                        @endfor
                    </div>
                    
                    <!-- Additional Nameservers (Collapsible) -->
                    <div x-data="{ showMore: false }" class="mt-4">
                        <button @click="showMore = !showMore" 
                                class="inline-flex items-center gap-2 text-xs sm:text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors">
                            <svg class="w-4 h-4 transition-transform duration-200" :class="showMore ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                            <span x-text="showMore ? '{{ __('crm.hide_additional_ns') ?? 'Hide additional nameservers' }}' : '{{ __('crm.show_additional_ns') ?? 'Show additional nameservers' }}'"></span>
                        </button>
                        
                        <div x-show="showMore" x-collapse class="mt-3 space-y-3">
                            @for($i = 5; $i <= 6; $i++)
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-gray-300 to-gray-400 flex items-center justify-center shadow-sm flex-shrink-0">
                                        <span class="text-white text-sm font-bold">{{ $i }}</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <input type="text" 
                                               x-model="nameservers[{{ $i - 1 }}]"
                                               class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-sm font-mono bg-white placeholder-gray-400 transition-all duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 hover:border-gray-400"
                                               placeholder="ns{{ $i }}.example.com">
                                    </div>
                                    <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded-md flex-shrink-0 hidden sm:inline-block">{{ __('crm.optional') ?? 'Optional' }}</span>
                                </div>
                            @endfor
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="mt-5 sm:mt-6 pt-4 sm:pt-5 border-t border-gray-100 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 sm:gap-4">
                        <div class="flex items-center gap-2 text-xs sm:text-sm text-gray-500 order-2 sm:order-1 justify-center sm:justify-start">
                            <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-center sm:text-start">{{ __('crm.nameservers_tip') ?? 'Changes may take up to 48 hours to propagate globally' }}</span>
                        </div>
                        <button @click="saveNameservers()" 
                                class="order-1 sm:order-2 inline-flex items-center justify-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 text-sm font-medium shadow-md whitespace-nowrap">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>{{ __('crm.save_nameservers') ?? 'Save Nameservers' }}</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Registrar Commands Card -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ __('crm.registrar_commands') ?? 'Registrar Commands' }}
                    </h3>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <!-- Register -->
                        <button @click="executeCommand('register')" 
                                class="flex flex-col items-center gap-2 p-4 rounded-lg border border-gray-200 hover:border-green-300 hover:bg-green-50 transition-colors group">
                            <div class="p-2 rounded-lg bg-green-100 text-green-600 group-hover:bg-green-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <span class="text-xs font-medium text-gray-700">{{ __('crm.register') ?? 'Register' }}</span>
                        </button>

                        <!-- Transfer -->
                        <button @click="executeCommand('transfer')" 
                                class="flex flex-col items-center gap-2 p-4 rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-colors group">
                            <div class="p-2 rounded-lg bg-blue-100 text-blue-600 group-hover:bg-blue-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                </svg>
                            </div>
                            <span class="text-xs font-medium text-gray-700">{{ __('crm.transfer') ?? 'Transfer' }}</span>
                        </button>

                        <!-- Renew -->
                        <button @click="executeCommand('renew')" 
                                class="flex flex-col items-center gap-2 p-4 rounded-lg border border-gray-200 hover:border-purple-300 hover:bg-purple-50 transition-colors group">
                            <div class="p-2 rounded-lg bg-purple-100 text-purple-600 group-hover:bg-purple-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                            </div>
                            <span class="text-xs font-medium text-gray-700">{{ __('crm.renew') ?? 'Renew' }}</span>
                        </button>

                        <!-- Modify Contact Details -->
                        <button @click="executeCommand('modify-contact')" 
                                class="flex flex-col items-center gap-2 p-4 rounded-lg border border-gray-200 hover:border-amber-300 hover:bg-amber-50 transition-colors group">
                            <div class="p-2 rounded-lg bg-amber-100 text-amber-600 group-hover:bg-amber-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-medium text-gray-700 text-center">{{ __('crm.modify_contact') ?? 'Modify Contact' }}</span>
                        </button>

                        <!-- Get EPP Code -->
                        <button @click="executeCommand('get-epp-code')" 
                                class="flex flex-col items-center gap-2 p-4 rounded-lg border border-gray-200 hover:border-cyan-300 hover:bg-cyan-50 transition-colors group">
                            <div class="p-2 rounded-lg bg-cyan-100 text-cyan-600 group-hover:bg-cyan-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-medium text-gray-700">{{ __('crm.get_epp_code') ?? 'Get EPP Code' }}</span>
                        </button>

                        <!-- Request Delete -->
                        <button @click="executeCommand('request-delete')" 
                                class="flex flex-col items-center gap-2 p-4 rounded-lg border border-gray-200 hover:border-red-300 hover:bg-red-50 transition-colors group">
                            <div class="p-2 rounded-lg bg-red-100 text-red-600 group-hover:bg-red-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </div>
                            <span class="text-xs font-medium text-gray-700">{{ __('crm.request_delete') ?? 'Request Delete' }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Status Card -->
            @php
                $statusConfigJson = [
                    'active' => ['bg' => 'bg-green-500', 'light' => 'bg-green-50', 'border' => 'border-green-200', 'text' => 'text-green-700', 'icon' => 'check-circle', 'label' => __('crm.status_active'), 'labelAr' => 'نشط'],
                    'pending' => ['bg' => 'bg-amber-500', 'light' => 'bg-amber-50', 'border' => 'border-amber-200', 'text' => 'text-amber-700', 'icon' => 'clock', 'label' => __('crm.status_pending'), 'labelAr' => 'قيد الانتظار'],
                    'pending_registration' => ['bg' => 'bg-blue-500', 'light' => 'bg-blue-50', 'border' => 'border-blue-200', 'text' => 'text-blue-700', 'icon' => 'clock', 'label' => __('crm.status_pending_registration'), 'labelAr' => 'في انتظار التسجيل'],
                    'pending_transfer' => ['bg' => 'bg-indigo-500', 'light' => 'bg-indigo-50', 'border' => 'border-indigo-200', 'text' => 'text-indigo-700', 'icon' => 'switch', 'label' => __('crm.status_pending_transfer'), 'labelAr' => 'في انتظار النقل'],
                    'grace_period' => ['bg' => 'bg-orange-500', 'light' => 'bg-orange-50', 'border' => 'border-orange-200', 'text' => 'text-orange-700', 'icon' => 'warning', 'label' => __('crm.status_grace_period'), 'labelAr' => 'فترة السماح'],
                    'redemption_period' => ['bg' => 'bg-red-500', 'light' => 'bg-red-50', 'border' => 'border-red-200', 'text' => 'text-red-700', 'icon' => 'warning', 'label' => __('crm.status_redemption_period'), 'labelAr' => 'فترة الاسترداد'],
                    'expired' => ['bg' => 'bg-red-600', 'light' => 'bg-red-50', 'border' => 'border-red-200', 'text' => 'text-red-700', 'icon' => 'x-circle', 'label' => __('crm.status_expired'), 'labelAr' => 'منتهي'],
                    'transferred_away' => ['bg' => 'bg-gray-500', 'light' => 'bg-gray-50', 'border' => 'border-gray-200', 'text' => 'text-gray-700', 'icon' => 'logout', 'label' => __('crm.status_transferred_away'), 'labelAr' => 'تم نقله'],
                    'cancelled' => ['bg' => 'bg-gray-600', 'light' => 'bg-gray-50', 'border' => 'border-gray-200', 'text' => 'text-gray-700', 'icon' => 'ban', 'label' => __('crm.status_cancelled'), 'labelAr' => 'ملغي'],
                    'fraud' => ['bg' => 'bg-rose-600', 'light' => 'bg-rose-50', 'border' => 'border-rose-200', 'text' => 'text-rose-700', 'icon' => 'warning', 'label' => __('crm.status_fraud'), 'labelAr' => 'احتيال'],
                ];
            @endphp
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm" 
                 x-data="{ 
                    showOptions: false,
                    currentStatus: status,
                    statusConfig: {{ Js::from($statusConfigJson) }},
                    isArabic: {{ app()->getLocale() == 'ar' ? 'true' : 'false' }},
                    getStatusLabel() {
                        return this.isArabic ? (this.statusConfig[this.currentStatus]?.labelAr || this.currentStatus) : (this.statusConfig[this.currentStatus]?.label || this.currentStatus);
                    },
                    getStatusClass(type) {
                        return this.statusConfig[this.currentStatus]?.[type] || '';
                    },
                    selectStatus(newStatus) {
                        this.currentStatus = newStatus;
                        status = newStatus;
                        updateStatus();
                        this.showOptions = false;
                    }
                 }"
                 x-init="$watch('status', value => currentStatus = value)">
                <!-- Current Status Display -->
                <div class="p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">{{ __('crm.status') }}</h3>
                        <div class="h-2 w-2 rounded-full animate-pulse" :class="getStatusClass('bg')"></div>
                    </div>
                    
                    <!-- Status Badge - Dynamic -->
                    <div class="flex items-center gap-3 p-4 rounded-xl border mb-4 transition-all duration-300"
                         :class="getStatusClass('light') + ' ' + getStatusClass('border')">
                        <div class="flex-shrink-0 w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300"
                             :class="getStatusClass('bg')">
                            <!-- Check Circle Icon -->
                            <svg x-show="statusConfig[currentStatus]?.icon === 'check-circle'" class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <!-- Clock Icon -->
                            <svg x-show="statusConfig[currentStatus]?.icon === 'clock'" class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <!-- Switch Icon -->
                            <svg x-show="statusConfig[currentStatus]?.icon === 'switch'" class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                            <!-- Warning Icon -->
                            <svg x-show="statusConfig[currentStatus]?.icon === 'warning'" class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <!-- X Circle Icon -->
                            <svg x-show="statusConfig[currentStatus]?.icon === 'x-circle'" class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <!-- Logout Icon -->
                            <svg x-show="statusConfig[currentStatus]?.icon === 'logout'" class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <!-- Ban Icon -->
                            <svg x-show="statusConfig[currentStatus]?.icon === 'ban'" class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-lg font-bold transition-all duration-300" :class="getStatusClass('text')" x-text="getStatusLabel()"></p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ __('crm.current_status') ?? 'Current Status' }}</p>
                        </div>
                    </div>

                    <!-- Status Selector Button -->
                    <button @click="showOptions = !showOptions" 
                            type="button"
                            class="w-full flex items-center justify-between gap-3 p-3 rounded-xl border border-gray-200 bg-gray-50 hover:bg-white hover:border-gray-300 transition-all duration-200 cursor-pointer">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">{{ __('crm.change_status') ?? 'Change Status' }}</span>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': showOptions }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    
                    <!-- Expandable Options List -->
                    <div x-show="showOptions" 
                         x-collapse
                         class="mt-3 border border-gray-200 rounded-xl bg-white overflow-hidden">
                        <div class="max-h-64 overflow-y-auto">
                            <template x-for="(config, key) in statusConfig" :key="key">
                                <button type="button"
                                        @click="selectStatus(key)"
                                        class="w-full flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-colors border-b border-gray-100 last:border-0"
                                        :class="currentStatus === key ? 'bg-blue-50' : ''">
                                    <span class="w-3 h-3 rounded-full flex-shrink-0" :class="config.bg"></span>
                                    <span class="text-sm flex-1" 
                                          :class="[currentStatus === key ? 'font-semibold text-gray-900' : 'text-gray-700', isArabic ? 'text-right' : 'text-left']"
                                          x-text="isArabic ? config.labelAr : config.label"></span>
                                    <svg x-show="currentStatus === key" class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Registrar Lock Card -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        {{ __('crm.registrar_lock') ?? 'Registrar Lock' }}
                    </h3>
                </div>
                <div class="p-5">
                    <div class="group flex items-center gap-4 p-4 rounded-xl border transition-all duration-200" :class="registrarLock ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200'">
                        <div class="flex-shrink-0 w-12 h-12 rounded-xl flex items-center justify-center transition-colors" :class="registrarLock ? 'bg-green-100 text-green-600' : 'bg-gray-200 text-gray-500'">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-900">{{ __('crm.transfer_lock') ?? 'Transfer Lock' }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ __('crm.transfer_lock_description') ?? 'Prevents unauthorized domain transfers' }}</p>
                        </div>
                        <button @click="toggleRegistrarLock()" 
                                :class="registrarLock ? 'bg-green-500' : 'bg-gray-300'"
                                class="relative inline-flex h-7 w-12 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            <span :class="registrarLock ? 'translate-x-5 rtl:-translate-x-5' : 'translate-x-0'"
                                  class="pointer-events-none inline-block h-6 w-6 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Auto Renew Card -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        {{ __('crm.auto_renew') }}
                    </h3>
                </div>
                <div class="p-5">
                    <div class="group flex items-center gap-4 p-4 rounded-xl border transition-all duration-300" 
                         :class="autoRenew ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200'">
                        <div class="flex-shrink-0 w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300" 
                             :class="autoRenew ? 'bg-green-100 text-green-600' : 'bg-gray-200 text-gray-500'">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-900">{{ __('crm.automatic_renewal') ?? 'Automatic Renewal' }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ __('crm.auto_renew_description') ?? 'Domain will renew automatically' }}</p>
                        </div>
                        <button @click="toggleTool('auto_renew')" 
                                :class="autoRenew ? 'bg-green-500' : 'bg-gray-300'"
                                class="relative inline-flex h-7 w-12 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            <span :class="autoRenew ? 'translate-x-5 rtl:-translate-x-5' : 'translate-x-0'"
                                  class="pointer-events-none inline-block h-6 w-6 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- ID Protection Card -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        {{ __('crm.id_protection') ?? 'ID Protection' }}
                    </h3>
                </div>
                <div class="p-5">
                    <div class="group flex items-center gap-4 p-4 rounded-xl border transition-all duration-300" 
                         :class="idProtection ? 'bg-indigo-50 border-indigo-200' : 'bg-gray-50 border-gray-200'">
                        <div class="flex-shrink-0 w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300" 
                             :class="idProtection ? 'bg-indigo-100 text-indigo-600' : 'bg-gray-200 text-gray-500'">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-900">{{ __('crm.whois_privacy') ?? 'WHOIS Privacy' }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ __('crm.id_protection_description') ?? 'Hide your personal info from WHOIS' }}</p>
                        </div>
                        <button @click="toggleTool('id_protection')" 
                                :class="idProtection ? 'bg-indigo-500' : 'bg-gray-300'"
                                class="relative inline-flex h-7 w-12 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            <span :class="idProtection ? 'translate-x-5 rtl:-translate-x-5' : 'translate-x-0'"
                                  class="pointer-events-none inline-block h-6 w-6 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Management Tools Card -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ __('crm.management_tools') ?? 'Management Tools' }}
                    </h3>
                </div>
                <div class="p-4 space-y-2">
                    <!-- DNS Management -->
                    <div class="group flex items-center justify-between p-3 rounded-xl border transition-all duration-200 cursor-pointer hover:shadow-sm" 
                         :class="dnsManagement ? 'bg-blue-50 border-blue-200' : 'bg-gray-50 border-gray-100 hover:border-gray-200'"
                         @click="toggleTool('dns_management')">
                        <div class="flex items-center gap-3">
                            <div class="p-2.5 rounded-xl transition-colors" :class="dnsManagement ? 'bg-blue-100 text-blue-600' : 'bg-gray-200 text-gray-500'">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ __('crm.dns_management') ?? 'DNS Management' }}</p>
                                <p class="text-xs text-gray-500">{{ __('crm.dns_management_desc') ?? 'Manage DNS records' }}</p>
                            </div>
                        </div>
                        <div :class="dnsManagement ? 'bg-blue-500' : 'bg-gray-300'"
                             class="relative inline-flex h-6 w-11 flex-shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out">
                            <span :class="dnsManagement ? 'translate-x-5 rtl:-translate-x-5' : 'translate-x-0'"
                                  class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                        </div>
                    </div>

                    <!-- Email Forwarding -->
                    <div class="group flex items-center justify-between p-3 rounded-xl border transition-all duration-200 cursor-pointer hover:shadow-sm" 
                         :class="emailForwarding ? 'bg-purple-50 border-purple-200' : 'bg-gray-50 border-gray-100 hover:border-gray-200'"
                         @click="toggleTool('email_forwarding')">
                        <div class="flex items-center gap-3">
                            <div class="p-2.5 rounded-xl transition-colors" :class="emailForwarding ? 'bg-purple-100 text-purple-600' : 'bg-gray-200 text-gray-500'">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ __('crm.email_forwarding') ?? 'Email Forwarding' }}</p>
                                <p class="text-xs text-gray-500">{{ __('crm.email_forwarding_desc') ?? 'Forward emails to another address' }}</p>
                            </div>
                        </div>
                        <div :class="emailForwarding ? 'bg-purple-500' : 'bg-gray-300'"
                             class="relative inline-flex h-6 w-11 flex-shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out">
                            <span :class="emailForwarding ? 'translate-x-5 rtl:-translate-x-5' : 'translate-x-0'"
                                  class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Client Info Card -->
            @if($domain->client)
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl shadow-sm overflow-hidden">
                <div class="p-5">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="h-14 w-14 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center text-xl font-bold text-white">
                            {{ strtoupper(substr($domain->client->first_name, 0, 1)) }}{{ strtoupper(substr($domain->client->last_name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-base font-semibold text-white">{{ $domain->client->first_name }} {{ $domain->client->last_name }}</p>
                            <p class="text-sm text-white/60">{{ $domain->client->email }}</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.clients.show', $domain->client) }}" 
                       class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white/10 text-white rounded-xl hover:bg-white/20 transition-all text-sm font-medium backdrop-blur-sm border border-white/10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        {{ __('crm.view_client') }}
                    </a>
                </div>
            </div>
            @endif

            <!-- Auth Code Card -->
            @if($domain->auth_code)
            <div class="bg-gradient-to-br from-amber-500 to-orange-500 rounded-xl shadow-sm overflow-hidden">
                <div class="p-5" x-data="{ showCode: false, copied: false }">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white">{{ __('crm.auth_code') }}</h3>
                            <p class="text-xs text-white/70">{{ __('crm.epp_transfer_code') ?? 'EPP Transfer Code' }}</p>
                        </div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-3 border border-white/20">
                        <div class="flex items-center gap-2">
                            <code class="flex-1 text-sm font-mono text-white bg-white/10 px-4 py-2.5 rounded-lg" 
                                  x-text="showCode ? '{{ $domain->auth_code }}' : '••••••••••••'"></code>
                            <button @click="showCode = !showCode" 
                                    class="p-2.5 text-white/80 hover:text-white bg-white/10 rounded-lg hover:bg-white/20 transition-colors">
                                <svg x-show="!showCode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="showCode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                            <button @click="navigator.clipboard.writeText('{{ $domain->auth_code }}'); copied = true; setTimeout(() => copied = false, 2000)" 
                                    class="p-2.5 text-white/80 hover:text-white bg-white/10 rounded-lg hover:bg-white/20 transition-colors">
                                <svg x-show="!copied" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                <svg x-show="copied" class="w-5 h-5 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Delete Domain -->
            <div class="bg-white rounded-xl border border-red-200 shadow-sm overflow-hidden">
                <div class="p-5">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="p-2.5 bg-red-100 rounded-xl">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-red-800">{{ __('crm.danger_zone') ?? 'Danger Zone' }}</h3>
                            <p class="text-xs text-red-600">{{ __('crm.delete_warning') ?? 'This action cannot be undone' }}</p>
                        </div>
                    </div>
                    <form action="{{ route('admin.domains.destroy', $domain) }}" method="POST" onsubmit="return confirm('{{ __('crm.confirm_delete_domain') ?? 'Are you sure you want to delete this domain?' }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-all text-sm font-semibold shadow-sm hover:shadow-md">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            {{ __('crm.delete_domain') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function domainManager() {
    return {
        domainId: {{ $domain->id }},
        status: '{{ $domain->status }}',
        registrarLock: {{ $domain->registrar_lock ? 'true' : 'false' }},
        nameservers: @json($domain->nameservers_array ?? []),
        dnsManagement: {{ $domain->dns_management ? 'true' : 'false' }},
        emailForwarding: {{ $domain->email_forwarding ? 'true' : 'false' }},
        idProtection: {{ $domain->id_protection ? 'true' : 'false' }},
        autoRenew: {{ $domain->auto_renew ? 'true' : 'false' }},
        firstPaymentAmount: {{ $domain->first_payment_amount ?? 0 }},
        editingFirstPayment: false,
        recurringAmount: {{ $domain->recurring_amount ?? 0 }},
        editingRecurringAmount: false,
        registrationPeriod: {{ $domain->registration_period ?? 1 }},
        editingRegistrationPeriod: false,
        domainName: '{{ $domain->domain_name }}',
        editingDomainName: false,
        @php
            $authCodeValue = null;
            if (!empty($domain->configuration['auth_code'])) {
                $authCodeValue = $domain->configuration['auth_code'];
            } elseif ($domain->order_id) {
                $orderItemForAuth = \App\Models\OrderItem::where('order_id', $domain->order_id)->where('type', 'domain')->first();
                if ($orderItemForAuth) {
                    $authCodeValue = $orderItemForAuth->configuration['auth_code'] ?? null;
                }
            }
        @endphp
        authCode: '{{ $authCodeValue ?? '' }}',
        editingAuthCode: false,
        
        // Important Dates
        fetchingDates: false,
        fetchingNameservers: false,
        registrationDate: '{{ $domain->registration_date ? $domain->registration_date->format("M d, Y") : "" }}',
        registrationDateHuman: '{{ $domain->registration_date ? $domain->registration_date->diffForHumans() : "" }}',
        expiryDate: '{{ $domain->expiry_date ? $domain->expiry_date->format("M d, Y") : "" }}',
        expiryDateHuman: '{{ $domain->expiry_date ? $domain->expiry_date->diffForHumans() : "" }}',
        expiryDateInput: '{{ $domain->expiry_date ? $domain->expiry_date->format("Y-m-d") : "" }}',
        editingExpiryDate: false,
        expiryStatus: '{{ $domain->expiry_date && $domain->expiry_date->isPast() ? "expired" : ($domain->expiry_date && $domain->expiry_date->diffInDays(now()) < 30 ? "expiring" : "active") }}',
        nextDueDate: '{{ $domain->next_due_date ? $domain->next_due_date->format("M d, Y") : "" }}',
        nextDueDateHuman: '{{ $domain->next_due_date ? $domain->next_due_date->diffForHumans() : "" }}',
        nextDueDateInput: '{{ $domain->next_due_date ? $domain->next_due_date->format("Y-m-d") : "" }}',
        editingNextDueDate: false,
        
        async toggleTool(tool) {
            try {
                const response = await fetch(`/unleasha/domains/${this.domainId}/toggle-tool`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ tool: tool })
                });
                const data = await response.json();
                if (data.success) {
                    // Update the local state
                    if (tool === 'dns_management') this.dnsManagement = data.value;
                    if (tool === 'email_forwarding') this.emailForwarding = data.value;
                    if (tool === 'id_protection') this.idProtection = data.value;
                    if (tool === 'auto_renew') this.autoRenew = data.value;
                    this.showNotification(data.message, 'success');
                } else {
                    this.showNotification(data.message || 'Error toggling tool', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                this.showNotification('Error toggling tool', 'error');
            }
        },
        
        async updateStatus() {
            try {
                const response = await fetch(`/unleasha/domains/${this.domainId}/update-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ status: this.status })
                });
                const data = await response.json();
                if (data.success) {
                    this.showNotification(data.message, 'success');
                } else {
                    this.showNotification(data.message || 'Error updating status', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                this.showNotification('Error updating status', 'error');
            }
        },
        
        async toggleRegistrarLock() {
            try {
                const response = await fetch(`/unleasha/domains/${this.domainId}/toggle-registrar-lock`, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                const data = await response.json();
                if (data.success) {
                    this.registrarLock = data.registrar_lock;
                    this.showNotification(data.message, 'success');
                }
            } catch (error) {
                console.error('Error:', error);
                this.showNotification('Error toggling registrar lock', 'error');
            }
        },
        
        async saveNameservers() {
            try {
                const response = await fetch(`/unleasha/domains/${this.domainId}/update-nameservers`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ nameservers: this.nameservers })
                });
                const data = await response.json();
                if (data.success) {
                    this.showNotification(data.message, 'success');
                }
            } catch (error) {
                console.error('Error:', error);
                this.showNotification('Error saving nameservers', 'error');
            }
        },
        
        async resetNameservers() {
            if (!confirm('{{ __("crm.confirm_reset_nameservers") ?? "Are you sure you want to reset nameservers to default?" }}')) return;
            
            try {
                const response = await fetch(`/unleasha/domains/${this.domainId}/reset-nameservers`, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                const data = await response.json();
                if (data.success) {
                    this.nameservers = data.nameservers;
                    this.showNotification(data.message, 'success');
                }
            } catch (error) {
                console.error('Error:', error);
                this.showNotification('Error resetting nameservers', 'error');
            }
        },
        
        async updateDomainName() {
            try {
                const response = await fetch(`/unleasha/domains/${this.domainId}/update-domain-name`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ domain_name: this.domainName })
                });
                const data = await response.json();
                if (data.success) {
                    this.editingDomainName = false;
                    this.showNotification(data.message, 'success');
                } else {
                    this.showNotification(data.message || 'Error updating domain name', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                this.showNotification('Error updating domain name', 'error');
            }
        },
        
        async updateAuthCode() {
            try {
                const response = await fetch(`/unleasha/domains/${this.domainId}/update-auth-code`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ auth_code: this.authCode })
                });
                const data = await response.json();
                if (data.success) {
                    this.editingAuthCode = false;
                    this.showNotification(data.message, 'success');
                } else {
                    this.showNotification(data.message || '{{ __("crm.error_updating_auth_code") ?? "Error updating auth code" }}', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                this.showNotification('{{ __("crm.error_updating_auth_code") ?? "Error updating auth code" }}', 'error');
            }
        },
        
        async executeCommand(command) {
            // Special warning for delete command
            if (command === 'request-delete') {
                const warningMessage = `{{ __("crm.delete_domain_warning") ?? "⚠️ WARNING: This action is IRREVERSIBLE!\\n\\n• The domain will be permanently deleted\\n• NO REFUND will be given\\n• This only works within 5 days of registration\\n\\nAre you absolutely sure you want to delete this domain?" }}`;
                if (!confirm(warningMessage)) return;
                // Double confirmation
                const domainName = '{{ $domain->domain_name }}';
                const typedName = prompt(`{{ __("crm.type_domain_to_confirm") ?? "To confirm deletion, please type the domain name:" }}`);
                if (typedName !== domainName) {
                    this.showNotification('{{ __("crm.domain_name_mismatch") ?? "Domain name does not match. Deletion cancelled." }}', 'error');
                    return;
                }
            } else {
                if (!confirm(`{{ __("crm.confirm_execute_command") ?? "Are you sure you want to execute this command?" }}`)) return;
            }
            
            try {
                const response = await fetch(`/unleasha/domains/${this.domainId}/${command}`, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                const data = await response.json();
                if (data.success) {
                    this.showNotification(data.message, 'success');
                    if (data.auth_code) {
                        alert('EPP Code: ' + data.auth_code);
                    }
                    if (['enable-id-protection', 'disable-id-protection', 'request-delete'].includes(command)) {
                        setTimeout(() => window.location.reload(), 1000);
                    }
                } else {
                    this.showNotification(data.message || 'Error executing command', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                this.showNotification('Error executing command', 'error');
            }
        },
        
        async updateFirstPayment() {
            try {
                const response = await fetch(`/unleasha/domains/${this.domainId}/update-first-payment`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ first_payment_amount: this.firstPaymentAmount })
                });
                const data = await response.json();
                if (data.success) {
                    this.editingFirstPayment = false;
                    this.showNotification(data.message, 'success');
                } else {
                    this.showNotification(data.message || 'Error updating amount', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                this.showNotification('Error updating amount', 'error');
            }
        },
        
        async updateRecurringAmount() {
            try {
                const response = await fetch(`/unleasha/domains/${this.domainId}/update-recurring-amount`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ recurring_amount: this.recurringAmount })
                });
                const data = await response.json();
                if (data.success) {
                    this.editingRecurringAmount = false;
                    this.showNotification(data.message, 'success');
                } else {
                    this.showNotification(data.message || 'Error updating amount', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                this.showNotification('Error updating amount', 'error');
            }
        },
        
        async updateRegistrationPeriod() {
            try {
                const response = await fetch(`/unleasha/domains/${this.domainId}/update-registration-period`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ registration_period: this.registrationPeriod })
                });
                const data = await response.json();
                if (data.success) {
                    this.editingRegistrationPeriod = false;
                    this.showNotification(data.message, 'success');
                } else {
                    this.showNotification(data.message || 'Error updating period', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                this.showNotification('Error updating period', 'error');
            }
        },
        
        async updateExpiryDate() {
            try {
                const response = await fetch(`/unleasha/domains/${this.domainId}/update-expiry-date`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ expiry_date: this.expiryDateInput })
                });
                const data = await response.json();
                if (data.success) {
                    this.editingExpiryDate = false;
                    this.expiryDate = data.expiry_date;
                    this.expiryDateHuman = data.expiry_date_human;
                    this.expiryStatus = data.expiry_status;
                    this.showNotification(data.message, 'success');
                } else {
                    this.showNotification(data.message || '{{ __("crm.error_updating_date") ?? "Error updating date" }}', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                this.showNotification('{{ __("crm.error_updating_date") ?? "Error updating date" }}', 'error');
            }
        },
        
        async updateNextDueDate() {
            try {
                const response = await fetch(`/unleasha/domains/${this.domainId}/update-next-due-date`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ next_due_date: this.nextDueDateInput })
                });
                const data = await response.json();
                if (data.success) {
                    this.editingNextDueDate = false;
                    this.nextDueDate = data.next_due_date;
                    this.nextDueDateHuman = data.next_due_date_human;
                    this.showNotification(data.message, 'success');
                } else {
                    this.showNotification(data.message || '{{ __("crm.error_updating_date") ?? "Error updating date" }}', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                this.showNotification('{{ __("crm.error_updating_date") ?? "Error updating date" }}', 'error');
            }
        },
        
        async fetchDomainDates() {
            this.fetchingDates = true;
            try {
                const response = await fetch(`/unleasha/domains/${this.domainId}/fetch-dates-from-dynadot`, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                const data = await response.json();
                if (data.success) {
                    // Update dates
                    this.registrationDate = data.dates.registration_date || '';
                    this.registrationDateHuman = data.dates.registration_date_human || '';
                    this.expiryDate = data.dates.expiry_date || '';
                    this.expiryDateHuman = data.dates.expiry_date_human || '';
                    this.expiryStatus = data.dates.expiry_status || 'active';
                    this.nextDueDate = data.dates.next_due_date || '';
                    this.nextDueDateHuman = data.dates.next_due_date_human || '';
                    this.showNotification(data.message, 'success');
                } else {
                    this.showNotification(data.message || 'Error fetching dates from Dynadot', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                this.showNotification('Error fetching dates from Dynadot', 'error');
            } finally {
                this.fetchingDates = false;
            }
        },
        
        async fetchNameservers() {
            this.fetchingNameservers = true;
            try {
                const response = await fetch(`/unleasha/domains/${this.domainId}/fetch-nameservers-from-dynadot`, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                const data = await response.json();
                if (data.success) {
                    // Update nameservers
                    this.nameservers = data.nameservers || [];
                    this.showNotification(data.message, 'success');
                } else {
                    this.showNotification(data.message || '{{ __("crm.error_fetching_nameservers") ?? "Error fetching nameservers" }}', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                this.showNotification('{{ __("crm.error_fetching_nameservers") ?? "Error fetching nameservers" }}', 'error');
            } finally {
                this.fetchingNameservers = false;
            }
        },
        
        showNotification(message, type = 'success') {
            alert(message);
        }
    }
}
</script>
@endpush
@endsection
