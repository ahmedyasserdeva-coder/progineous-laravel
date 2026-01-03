@extends('frontend.client.layout')

@section('title', $domain->domain_name)

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    <!-- Back Link -->
    <a href="{{ route('client.domains.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-900 transition-colors">
        <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        {{ app()->getLocale() == 'ar' ? 'العودة للنطاقات' : 'Back to domains' }}
    </a>

    <!-- Domain Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-gray-900 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">{{ $domain->domain_name }}</h1>
                <p class="text-sm text-gray-500">{{ app()->getLocale() == 'ar' ? 'مُسجّل منذ' : 'Registered' }} {{ $domain->registration_date ? $domain->registration_date->format('M Y') : '-' }}</p>
            </div>
        </div>

        @php
            $statusStyles = [
                'active' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
                'pending' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
                'pending_registration' => 'bg-blue-50 text-blue-700 ring-blue-600/20',
                'pending_transfer' => 'bg-indigo-50 text-indigo-700 ring-indigo-600/20',
                'expired' => 'bg-red-50 text-red-700 ring-red-600/20',
                'cancelled' => 'bg-gray-50 text-gray-600 ring-gray-500/20',
                'grace_period' => 'bg-orange-50 text-orange-700 ring-orange-600/20',
                'redemption_period' => 'bg-red-50 text-red-700 ring-red-600/20',
                'transferred_away' => 'bg-slate-50 text-slate-600 ring-slate-500/20',
            ];
            $statusLabels = [
                'active' => ['en' => 'Active', 'ar' => 'نشط'],
                'pending' => ['en' => 'Pending', 'ar' => 'قيد الانتظار'],
                'pending_registration' => ['en' => 'Pending Registration', 'ar' => 'قيد التسجيل'],
                'pending_transfer' => ['en' => 'Pending Transfer', 'ar' => 'قيد النقل'],
                'expired' => ['en' => 'Expired', 'ar' => 'منتهي'],
                'cancelled' => ['en' => 'Cancelled', 'ar' => 'ملغي'],
                'grace_period' => ['en' => 'Grace Period', 'ar' => 'فترة السماح'],
                'redemption_period' => ['en' => 'Redemption Period', 'ar' => 'فترة الاسترداد'],
                'transferred_away' => ['en' => 'Transferred Away', 'ar' => 'تم نقله خارجياً'],
            ];
        @endphp
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium ring-1 ring-inset {{ $statusStyles[$domain->status] ?? $statusStyles['pending'] }}">
            {{ app()->getLocale() == 'ar' ? ($statusLabels[$domain->status]['ar'] ?? $domain->status) : ($statusLabels[$domain->status]['en'] ?? $domain->status) }}
        </span>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Overview Cards -->
            <div class="grid grid-cols-2 gap-4">
                <!-- Expiry Date -->
                <div class="bg-white rounded-2xl border border-gray-200 p-5">
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">
                        {{ app()->getLocale() == 'ar' ? 'ينتهي في' : 'Expires' }}
                    </p>
                    @if($domain->expiry_date)
                        <p class="text-2xl font-semibold {{ $domain->expiry_date->isPast() ? 'text-red-600' : ($domain->expiry_date->diffInDays(now()) <= 30 ? 'text-amber-600' : 'text-gray-900') }}">
                            {{ $domain->expiry_date->format('d M Y') }}
                        </p>
                        <p class="text-sm text-gray-500 mt-1">
                            @if($domain->expiry_date->isPast())
                                {{ app()->getLocale() == 'ar' ? 'منتهي' : 'Expired' }}
                            @else
                                {{ $domain->expiry_date->diffForHumans() }}
                            @endif
                        </p>
                    @else
                        <p class="text-2xl font-semibold text-gray-300">—</p>
                    @endif
                </div>

                <!-- Auto Renew -->
                <div class="bg-white rounded-2xl border border-gray-200 p-5"
                     x-data="{
                         enabled: {{ $domain->auto_renew ? 'true' : 'false' }},
                         loading: false,
                         async toggle() {
                             if (this.loading || '{{ $domain->status }}' !== 'active') return;
                             this.loading = true;
                             try {
                                 const res = await fetch('{{ route('client.domains.toggle-auto-renew', $domain) }}', {
                                     method: 'POST',
                                     headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                                 });
                                 const data = await res.json();
                                 if (data.success) this.enabled = data.value;
                             } catch (e) { console.error(e); }
                             this.loading = false;
                         }
                     }">
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">
                        {{ app()->getLocale() == 'ar' ? 'التجديد التلقائي' : 'Auto Renew' }}
                    </p>
                    <div class="flex items-center justify-between">
                        <p class="text-2xl font-semibold" :class="enabled ? 'text-emerald-600' : 'text-gray-400'" x-text="enabled ? '{{ app()->getLocale() == 'ar' ? 'مفعّل' : 'On' }}' : '{{ app()->getLocale() == 'ar' ? 'معطّل' : 'Off' }}'"></p>
                        <button @click="toggle()"
                                :disabled="loading || '{{ $domain->status }}' !== 'active'"
                                :class="{ 'opacity-50 cursor-not-allowed': '{{ $domain->status }}' !== 'active' }"
                                class="relative w-11 h-6 rounded-full transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900"
                                :style="enabled ? 'background-color: #10b981' : 'background-color: #e5e7eb'">
                            <span class="absolute top-0.5 w-5 h-5 bg-white rounded-full shadow transition-all duration-200"
                                  :class="enabled ? '{{ app()->getLocale() == 'ar' ? 'left-0.5' : 'left-5' }}' : '{{ app()->getLocale() == 'ar' ? 'left-5' : 'left-0.5' }}'"></span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Domain Information -->
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-sm font-semibold text-gray-900">{{ app()->getLocale() == 'ar' ? 'معلومات النطاق' : 'Domain Information' }}</h2>
                </div>
                <div class="divide-y divide-gray-100">
                    <div class="px-6 py-4 flex justify-between items-center">
                        <span class="text-sm text-gray-500">{{ app()->getLocale() == 'ar' ? 'اسم النطاق' : 'Domain Name' }}</span>
                        <span class="text-sm font-medium text-gray-900">{{ $domain->domain_name }}</span>
                    </div>
                    <div class="px-6 py-4 flex justify-between items-center">
                        <span class="text-sm text-gray-500">{{ app()->getLocale() == 'ar' ? 'الامتداد' : 'Extension' }}</span>
                        <span class="text-sm font-medium text-gray-900">{{ $domain->tld }}</span>
                    </div>
                    <div class="px-6 py-4 flex justify-between items-center">
                        <span class="text-sm text-gray-500">{{ app()->getLocale() == 'ar' ? 'تاريخ التسجيل' : 'Registration Date' }}</span>
                        <span class="text-sm font-medium text-gray-900">{{ $domain->registration_date ? $domain->registration_date->format('M d, Y') : '—' }}</span>
                    </div>
                    <div class="px-6 py-4 flex justify-between items-center">
                        <span class="text-sm text-gray-500">{{ app()->getLocale() == 'ar' ? 'تاريخ الانتهاء' : 'Expiry Date' }}</span>
                        <span class="text-sm font-medium text-gray-900">{{ $domain->expiry_date ? $domain->expiry_date->format('M d, Y') : '—' }}</span>
                    </div>
                    <div class="px-6 py-4 flex justify-between items-center">
                        <span class="text-sm text-gray-500">{{ app()->getLocale() == 'ar' ? 'فترة التسجيل' : 'Registration Period' }}</span>
                        <span class="text-sm font-medium text-gray-900">{{ $domain->registration_period }} {{ app()->getLocale() == 'ar' ? 'سنة' : 'year(s)' }}</span>
                    </div>
                    <div class="px-6 py-4 flex justify-between items-center">
                        <span class="text-sm text-gray-500">{{ app()->getLocale() == 'ar' ? 'نوع الطلب' : 'Order Type' }}</span>
                        <span class="text-sm font-medium text-gray-900">
                            {{ ($domain->order_type ?? 'register') == 'register'
                                ? (app()->getLocale() == 'ar' ? 'تسجيل جديد' : 'Registration')
                                : (app()->getLocale() == 'ar' ? 'نقل' : 'Transfer') }}
                        </span>
                    </div>
                    <!-- SSL Status -->
                    <div class="px-6 py-4"
                         x-data="{
                             checking: true,
                             hasSSL: null,
                             sslInfo: null,
                             error: false,
                             showDetails: false,
                             async checkSSL() {
                                 this.checking = true;
                                 this.error = false;
                                 try {
                                     const res = await fetch('{{ route('client.domains.check-ssl', $domain) }}');
                                     const data = await res.json();
                                     this.hasSSL = data.has_ssl;
                                     this.sslInfo = data.ssl_info;
                                 } catch (e) {
                                     this.error = true;
                                 }
                                 this.checking = false;
                             }
                         }"
                         x-init="checkSSL()">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">{{ app()->getLocale() == 'ar' ? 'حالة SSL' : 'SSL Status' }}</span>
                            <div class="flex items-center gap-2">
                                <!-- Loading State -->
                                <template x-if="checking">
                                    <div class="flex items-center gap-2">
                                        <svg class="animate-spin h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <span class="text-sm text-gray-400">{{ app()->getLocale() == 'ar' ? 'جاري الفحص...' : 'Checking...' }}</span>
                                    </div>
                                </template>
                                <!-- SSL Active -->
                                <template x-if="!checking && hasSSL === true">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-sm font-medium text-green-600">{{ app()->getLocale() == 'ar' ? 'مفعّل' : 'Active' }}</span>
                                        <!-- Show Details Button -->
                                        <button x-show="sslInfo" @click="showDetails = !showDetails" class="text-xs text-primary-600 hover:text-primary-700 underline">
                                            <span x-text="showDetails ? '{{ app()->getLocale() == 'ar' ? 'إخفاء' : 'Hide' }}' : '{{ app()->getLocale() == 'ar' ? 'التفاصيل' : 'Details' }}'"></span>
                                        </button>
                                    </div>
                                </template>
                                <!-- SSL Not Active -->
                                <template x-if="!checking && hasSSL === false">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-sm font-medium text-red-600">{{ app()->getLocale() == 'ar' ? 'غير مفعّل' : 'Not Active' }}</span>
                                    </div>
                                </template>
                                <!-- Error State -->
                                <template x-if="!checking && error">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-sm text-gray-400">{{ app()->getLocale() == 'ar' ? 'فشل الفحص' : 'Check Failed' }}</span>
                                    </div>
                                </template>
                                <!-- Refresh Button -->
                                <button x-show="!checking" @click="checkSSL()" class="p-1 text-gray-400 hover:text-gray-600 transition-colors" title="{{ app()->getLocale() == 'ar' ? 'إعادة الفحص' : 'Refresh' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <!-- SSL Details Panel -->
                        <div x-show="showDetails && sslInfo" x-collapse class="mt-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="grid grid-cols-2 gap-3 text-xs">
                                <div>
                                    <span class="text-gray-500">{{ app()->getLocale() == 'ar' ? 'الجهة المصدرة' : 'Issuer' }}</span>
                                    <p class="font-medium text-gray-900" x-text="sslInfo?.issuer"></p>
                                </div>
                                <div>
                                    <span class="text-gray-500">{{ app()->getLocale() == 'ar' ? 'النطاق' : 'Common Name' }}</span>
                                    <p class="font-medium text-gray-900" x-text="sslInfo?.common_name"></p>
                                </div>
                                <div>
                                    <span class="text-gray-500">{{ app()->getLocale() == 'ar' ? 'صالحة من' : 'Valid From' }}</span>
                                    <p class="font-medium text-gray-900" x-text="sslInfo?.valid_from"></p>
                                </div>
                                <div>
                                    <span class="text-gray-500">{{ app()->getLocale() == 'ar' ? 'صالحة حتى' : 'Valid Until' }}</span>
                                    <p class="font-medium text-gray-900" x-text="sslInfo?.valid_to"></p>
                                </div>
                                <div class="col-span-2">
                                    <span class="text-gray-500">{{ app()->getLocale() == 'ar' ? 'الأيام المتبقية' : 'Days Remaining' }}</span>
                                    <p class="font-medium" :class="sslInfo?.days_remaining < 30 ? 'text-orange-600' : 'text-green-600'">
                                        <span x-text="sslInfo?.days_remaining"></span> {{ app()->getLocale() == 'ar' ? 'يوم' : 'days' }}
                                        <span x-show="sslInfo?.is_expired" class="text-red-600 font-bold">({{ app()->getLocale() == 'ar' ? 'منتهية!' : 'Expired!' }})</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nameservers -->
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden"
                 x-data="{
                     editing: false,
                     loading: false,
                     checking: false,
                     showPresets: false,
                     showPropagationNotice: false,
                     ns1: '{{ $domain->nameservers[0] ?? '' }}',
                     ns2: '{{ $domain->nameservers[1] ?? '' }}',
                     ns3: '{{ $domain->nameservers[2] ?? '' }}',
                     ns4: '{{ $domain->nameservers[3] ?? '' }}',
                     originalNs: @js($domain->nameservers ?? []),
                     liveNs: [],
                     lastChecked: null,
                     nsMatched: null,
                     presets: {
                         progineous: {
                             name: '{{ app()->getLocale() == 'ar' ? 'Pro Gineous DNS' : 'Pro Gineous DNS' }}',
                             ns: ['ns1.mysecurecloudhost.com', 'ns2.mysecurecloudhost.com', 'ns3.mysecurecloudhost.com', 'ns4.mysecurecloudhost.com']
                         },
                         cloudflare: {
                             name: 'Cloudflare DNS',
                             ns: []
                         }
                     },
                     async checkLiveNs() {
                         this.checking = true;
                         try {
                             const res = await fetch('{{ route('client.domains.check-nameservers', $domain) }}');
                             const data = await res.json();
                             if (data.success) {
                                 this.liveNs = data.live_nameservers || [];
                                 this.nsMatched = data.matched;
                                 this.lastChecked = new Date().toLocaleTimeString();
                                 
                                 // Update originalNs and form fields with stored nameservers (updated in DB)
                                 if (data.stored_nameservers && data.stored_nameservers.length > 0) {
                                     this.originalNs = data.stored_nameservers;
                                     this.ns1 = data.stored_nameservers[0] || '';
                                     this.ns2 = data.stored_nameservers[1] || '';
                                     this.ns3 = data.stored_nameservers[2] || '';
                                     this.ns4 = data.stored_nameservers[3] || '';
                                 }
                             }
                         } catch (e) {
                             console.error('Error checking nameservers:', e);
                         }
                         this.checking = false;
                     },
                     async applyPreset(preset) {
                         if (preset === 'progineous') {
                             this.showPresets = false;
                             this.loading = true;
                             const nameservers = this.presets.progineous.ns;
                             try {
                                 const res = await fetch('{{ route('client.domains.update-nameservers', $domain) }}', {
                                     method: 'POST',
                                     headers: {
                                         'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                         'Accept': 'application/json',
                                         'Content-Type': 'application/json'
                                     },
                                     body: JSON.stringify({ nameservers })
                                 });
                                 const data = await res.json();
                                 if (data.success) {
                                     this.originalNs = data.nameservers;
                                     this.ns1 = data.nameservers[0] || '';
                                     this.ns2 = data.nameservers[1] || '';
                                     this.ns3 = data.nameservers[2] || '';
                                     this.ns4 = data.nameservers[3] || '';
                                     this.showDnsPropagationAlert();
                                 } else {
                                     if (typeof Swal !== 'undefined') {
                                         Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: data.message, showConfirmButton: false, timer: 3000 });
                                     } else {
                                         alert(data.message);
                                     }
                                 }
                             } catch (e) {
                                 console.error(e);
                             }
                             this.loading = false;
                         } else if (preset === 'cloudflare') {
                             console.log('Cloudflare preset clicked');
                             this.showPresets = false;
                             this.loading = true;
                             try {
                                 console.log('Fetching:', '{{ route('client.domains.setup-cloudflare', $domain) }}');
                                 const res = await fetch('{{ route('client.domains.setup-cloudflare', $domain) }}', {
                                     method: 'POST',
                                     headers: {
                                         'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                         'Accept': 'application/json',
                                         'Content-Type': 'application/json'
                                     }
                                 });
                                 console.log('Response status:', res.status);
                                 const data = await res.json();
                                 console.log('Response data:', data);
                                 if (data.success) {
                                     this.originalNs = data.nameservers;
                                     this.ns1 = data.nameservers[0] || '';
                                     this.ns2 = data.nameservers[1] || '';
                                     this.ns3 = data.nameservers[2] || '';
                                     this.ns4 = data.nameservers[3] || '';
                                     this.showDnsPropagationAlert();
                                 } else {
                                     if (typeof Swal !== 'undefined') {
                                         Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: data.message, showConfirmButton: false, timer: 5000 });
                                     } else {
                                         alert(data.message);
                                     }
                                 }
                             } catch (e) {
                                 console.error(e);
                                 if (typeof Swal !== 'undefined') {
                                     Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: '{{ app()->getLocale() == 'ar' ? 'حدث خطأ في الاتصال' : 'Connection error occurred' }}', showConfirmButton: false, timer: 3000 });
                                 } else {
                                     alert('{{ app()->getLocale() == 'ar' ? 'حدث خطأ في الاتصال' : 'Connection error occurred' }}');
                                 }
                             }
                             this.loading = false;
                         }
                     },
                     showDnsPropagationAlert() {
                         this.showPropagationNotice = true;
                         // Auto-hide after 30 seconds
                         setTimeout(() => { this.showPropagationNotice = false; }, 30000);
                     },
                     async save() {
                         this.loading = true;
                         const nameservers = [this.ns1, this.ns2, this.ns3, this.ns4].filter(ns => ns.trim() !== '');
                         try {
                             const res = await fetch('{{ route('client.domains.update-nameservers', $domain) }}', {
                                 method: 'POST',
                                 headers: {
                                     'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                     'Accept': 'application/json',
                                     'Content-Type': 'application/json'
                                 },
                                 body: JSON.stringify({ nameservers })
                             });
                             const data = await res.json();
                             if (data.success) {
                                 this.originalNs = data.nameservers;
                                 this.editing = false;
                                 this.showDnsPropagationAlert();
                                 this.checkLiveNs();
                             } else {
                                 if (typeof Swal !== 'undefined') {
                                     Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: data.message, showConfirmButton: false, timer: 3000 });
                                 } else {
                                     alert(data.message);
                                 }
                             }
                         } catch (e) {
                             console.error(e);
                         }
                         this.loading = false;
                     },
                     cancel() {
                         this.ns1 = this.originalNs[0] || '';
                         this.ns2 = this.originalNs[1] || '';
                         this.ns3 = this.originalNs[2] || '';
                         this.ns4 = this.originalNs[3] || '';
                         this.editing = false;
                     }
                 }"
                 x-init="checkLiveNs(); setInterval(() => checkLiveNs(), 30000);">
                <!-- DNS Propagation Notice -->
                <div x-show="showPropagationNotice" x-cloak
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     class="bg-blue-50 border-b border-blue-100 px-6 py-4">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-blue-800">
                                {{ app()->getLocale() == 'ar' ? 'تم تحديث خوادم الأسماء بنجاح' : 'Nameservers Updated Successfully' }}
                            </p>
                            <p class="text-sm text-blue-600 mt-1">
                                {{ app()->getLocale() == 'ar' ? 'قد يستغرق انتشار DNS حتى 24 ساعة ليصبح فعالاً في جميع أنحاء العالم.' : 'DNS propagation may take up to 24 hours to take effect worldwide.' }}
                            </p>
                        </div>
                        <button @click="showPropagationNotice = false" class="flex-shrink-0 text-blue-400 hover:text-blue-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-sm font-semibold text-gray-900">{{ app()->getLocale() == 'ar' ? 'خوادم الأسماء' : 'Nameservers' }}</h2>
                    @if($domain->status == 'active')
                    <div class="flex items-center gap-2" x-show="!editing">
                        <!-- Presets Dropdown -->
                        <div class="relative">
                            <button @click="showPresets = !showPresets" @click.away="showPresets = false"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                {{ app()->getLocale() == 'ar' ? 'إعداد سريع' : 'Quick Setup' }}
                                <svg class="w-3.5 h-3.5 transition-transform" :class="{ 'rotate-180': showPresets }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="showPresets" x-cloak
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-50">

                                <!-- Pro Gineous DNS -->
                                <button @click="applyPreset('progineous')"
                                        class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
                                    <div class="w-8 h-8 rounded-lg bg-white border border-gray-100 flex items-center justify-center flex-shrink-0 p-0.5">
                                        <img src="{{ asset('logo/pro Gineous Blue_defult icon.png') }}" alt="Pro Gineous" class="w-full h-full object-contain">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-gray-900">Pro Gineous DNS</p>
                                        <p class="text-xs text-gray-500">{{ app()->getLocale() == 'ar' ? 'استضافة Pro Gineous' : 'Pro Gineous Hosting' }}</p>
                                    </div>
                                </button>

                                <!-- Cloudflare DNS -->
                                <button @click="applyPreset('cloudflare')"
                                        class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
                                    <div class="w-8 h-8 rounded-lg bg-white border border-gray-100 flex items-center justify-center flex-shrink-0 p-1">
                                        <img src="{{ asset('logo/cloudflare.svg') }}" alt="Cloudflare" class="w-full h-full object-contain">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-gray-900">Cloudflare DNS</p>
                                        <p class="text-xs text-gray-500">{{ app()->getLocale() == 'ar' ? 'حماية وسرعة' : 'Protection & Speed' }}</p>
                                    </div>
                                </button>
                            </div>
                        </div>

                        <!-- Edit Button -->
                        <button @click="editing = true" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                            {{ app()->getLocale() == 'ar' ? 'تعديل' : 'Edit' }}
                        </button>
                    </div>
                    @endif
                </div>
                <div class="p-6 relative">
                    <!-- Loading Overlay -->
                    <div x-show="loading" x-cloak
                         class="absolute inset-0 bg-white/80 backdrop-blur-sm flex items-center justify-center z-10 rounded-b-2xl">
                        <div class="flex flex-col items-center gap-3">
                            <svg class="animate-spin h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            <p class="text-sm font-medium text-gray-600">{{ app()->getLocale() == 'ar' ? 'جارٍ تحديث خوادم الأسماء...' : 'Updating nameservers...' }}</p>
                        </div>
                    </div>

                    <!-- Live Status Indicator -->
                    <div class="flex items-center justify-between mb-4 p-3 rounded-xl" :class="nsMatched === true ? 'bg-green-50 border border-green-200' : nsMatched === false ? 'bg-yellow-50 border border-yellow-200' : 'bg-gray-50 border border-gray-200'">
                        <div class="flex items-center gap-2">
                            <template x-if="checking">
                                <svg class="animate-spin h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                            </template>
                            <template x-if="!checking && nsMatched === true">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </template>
                            <template x-if="!checking && nsMatched === false">
                                <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </template>
                            <template x-if="!checking && nsMatched === null">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </template>
                            <span class="text-xs font-medium" :class="nsMatched === true ? 'text-green-700' : nsMatched === false ? 'text-yellow-700' : 'text-gray-600'">
                                <template x-if="checking">
                                    <span>{{ app()->getLocale() == 'ar' ? 'جاري التحقق...' : 'Checking...' }}</span>
                                </template>
                                <template x-if="!checking && nsMatched === true">
                                    <span>{{ app()->getLocale() == 'ar' ? 'خوادم الأسماء متطابقة' : 'Nameservers Matched' }}</span>
                                </template>
                                <template x-if="!checking && nsMatched === false">
                                    <span>{{ app()->getLocale() == 'ar' ? 'في انتظار انتشار DNS' : 'Waiting for DNS Propagation' }}</span>
                                </template>
                                <template x-if="!checking && nsMatched === null">
                                    <span>{{ app()->getLocale() == 'ar' ? 'حالة DNS غير معروفة' : 'DNS Status Unknown' }}</span>
                                </template>
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span x-show="lastChecked" class="text-xs text-gray-400" x-text="lastChecked"></span>
                            <button @click="checkLiveNs()" :disabled="checking" class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-white rounded-lg transition-colors" :class="{ 'opacity-50': checking }">
                                <svg class="w-4 h-4" :class="{ 'animate-spin': checking }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- View Mode -->
                    <div x-show="!editing" class="space-y-2">
                        <template x-if="originalNs.length > 0">
                            <template x-for="(ns, index) in originalNs" :key="index">
                                <div class="flex items-center gap-3 px-4 py-3 bg-gray-50 rounded-xl">
                                    <div class="w-2 h-2 rounded-full" :class="liveNs.map(n => n.toLowerCase()).includes(ns.toLowerCase()) ? 'bg-emerald-500' : 'bg-yellow-500'"></div>
                                    <code class="text-sm text-gray-700 flex-1" x-text="ns"></code>
                                    <span x-show="liveNs.map(n => n.toLowerCase()).includes(ns.toLowerCase())" class="text-xs text-green-600">{{ app()->getLocale() == 'ar' ? 'فعّال' : 'Active' }}</span>
                                    <span x-show="!liveNs.map(n => n.toLowerCase()).includes(ns.toLowerCase())" class="text-xs text-yellow-600">{{ app()->getLocale() == 'ar' ? 'قيد الانتشار' : 'Propagating' }}</span>
                                </div>
                            </template>
                        </template>
                        <template x-if="originalNs.length === 0">
                            <p class="text-sm text-gray-400">{{ app()->getLocale() == 'ar' ? 'لم يتم تعيين خوادم أسماء' : 'No nameservers configured' }}</p>
                        </template>
                    </div>

                    <!-- Edit Mode -->
                    <div x-show="editing" x-cloak class="space-y-3">
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1.5">NS1 <span class="text-red-500">*</span></label>
                                <input type="text" x-model="ns1" placeholder="ns1.example.com"
                                       class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1.5">NS2 <span class="text-red-500">*</span></label>
                                <input type="text" x-model="ns2" placeholder="ns2.example.com"
                                       class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1.5">NS3 <span class="text-gray-400">({{ app()->getLocale() == 'ar' ? 'اختياري' : 'Optional' }})</span></label>
                                <input type="text" x-model="ns3" placeholder="ns3.example.com"
                                       class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1.5">NS4 <span class="text-gray-400">({{ app()->getLocale() == 'ar' ? 'اختياري' : 'Optional' }})</span></label>
                                <input type="text" x-model="ns4" placeholder="ns4.example.com"
                                       class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            </div>
                        </div>

                        <div class="flex items-center gap-3 pt-3">
                            <button @click="save()" :disabled="loading || !ns1.trim() || !ns2.trim()"
                                    :class="{ 'opacity-50 cursor-not-allowed': loading || !ns1.trim() || !ns2.trim() }"
                                    class="flex-1 py-2.5 bg-gray-900 text-white text-sm font-medium rounded-xl hover:bg-gray-800 transition-colors">
                                <span x-show="!loading">{{ app()->getLocale() == 'ar' ? 'حفظ التغييرات' : 'Save Changes' }}</span>
                                <span x-show="loading" class="flex items-center justify-center gap-2">
                                    <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                    </svg>
                                    {{ app()->getLocale() == 'ar' ? 'جاري الحفظ...' : 'Saving...' }}
                                </span>
                            </button>
                            <button @click="cancel()" :disabled="loading" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                                {{ app()->getLocale() == 'ar' ? 'إلغاء' : 'Cancel' }}
                            </button>
                        </div>

                        <p class="text-xs text-gray-400 mt-2">
                            {{ app()->getLocale() == 'ar' ? 'يجب إدخال خادمي أسماء على الأقل (NS1 و NS2)' : 'At least 2 nameservers are required (NS1 and NS2)' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column (Security & Renewal) -->
        <div class="space-y-6">
            <!-- Security Settings -->
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden"
                 x-data="{
                     transferLock: {{ $domain->registrar_lock ? 'true' : 'false' }},
                     whoisPrivacy: {{ $domain->id_protection ? 'true' : 'false' }},
                     loadingLock: false,
                     loadingPrivacy: false,
                     loadingAuthCode: false,
                     authCode: null,
                     showAuthCode: false,
                     async toggleTransferLock() {
                         this.loadingLock = true;
                         try {
                             const res = await fetch('{{ route('client.domains.toggle-transfer-lock', $domain) }}', {
                                 method: 'POST',
                                 headers: {
                                     'Content-Type': 'application/json',
                                     'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                 }
                             });
                             const data = await res.json();
                             if (data.success) {
                                 this.transferLock = data.value;
                             } else {
                                 alert(data.message);
                             }
                         } catch (e) {
                             alert('{{ app()->getLocale() == 'ar' ? 'حدث خطأ' : 'An error occurred' }}');
                         }
                         this.loadingLock = false;
                     },
                     async toggleWhoisPrivacy() {
                         this.loadingPrivacy = true;
                         try {
                             const res = await fetch('{{ route('client.domains.toggle-whois-privacy', $domain) }}', {
                                 method: 'POST',
                                 headers: {
                                     'Content-Type': 'application/json',
                                     'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                 }
                             });
                             const data = await res.json();
                             if (data.success) {
                                 this.whoisPrivacy = data.value;
                             } else {
                                 alert(data.message);
                             }
                         } catch (e) {
                             alert('{{ app()->getLocale() == 'ar' ? 'حدث خطأ' : 'An error occurred' }}');
                         }
                         this.loadingPrivacy = false;
                     },
                     async getAuthCode() {
                         this.loadingAuthCode = true;
                         try {
                             const res = await fetch('{{ route('client.domains.get-auth-code', $domain) }}');
                             const data = await res.json();
                             if (data.success) {
                                 this.authCode = data.auth_code;
                                 this.showAuthCode = true;
                             } else {
                                 alert(data.message);
                             }
                         } catch (e) {
                             alert('{{ app()->getLocale() == 'ar' ? 'حدث خطأ' : 'An error occurred' }}');
                         }
                         this.loadingAuthCode = false;
                     },
                     copied: false,
                     copyAuthCode() {
                         navigator.clipboard.writeText(this.authCode);
                         this.copied = true;
                         setTimeout(() => { this.copied = false; }, 2000);
                     }
                 }">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-sm font-semibold text-gray-900">{{ app()->getLocale() == 'ar' ? 'الأمان' : 'Security' }}</h2>
                </div>
                <div class="p-4 space-y-3">
                    <!-- Transfer Lock -->
                    <div class="flex items-center justify-between p-3 rounded-xl transition-colors" :class="transferLock ? 'bg-emerald-50' : 'bg-gray-50'">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors" :class="transferLock ? 'bg-emerald-100 text-emerald-600' : 'bg-gray-200 text-gray-400'">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-700">{{ app()->getLocale() == 'ar' ? 'قفل النقل' : 'Transfer Lock' }}</span>
                        </div>
                        <button @click="toggleTransferLock()" :disabled="loadingLock" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2" :class="transferLock ? 'bg-emerald-600' : 'bg-gray-200'">
                            <span class="sr-only">Toggle transfer lock</span>
                            <span :class="transferLock ? '{{ app()->getLocale() == 'ar' ? 'translate-x-1' : 'translate-x-6' }}' : '{{ app()->getLocale() == 'ar' ? 'translate-x-6' : 'translate-x-1' }}'" class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform shadow">
                                <svg x-show="loadingLock" class="w-4 h-4 animate-spin text-gray-400" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </span>
                        </button>
                    </div>

                    <!-- WHOIS Privacy -->
                    <div class="flex items-center justify-between p-3 rounded-xl transition-colors" :class="whoisPrivacy ? 'bg-emerald-50' : 'bg-gray-50'">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors" :class="whoisPrivacy ? 'bg-emerald-100 text-emerald-600' : 'bg-gray-200 text-gray-400'">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-700">{{ app()->getLocale() == 'ar' ? 'خصوصية WHOIS' : 'WHOIS Privacy' }}</span>
                        </div>
                        <button @click="toggleWhoisPrivacy()" :disabled="loadingPrivacy" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2" :class="whoisPrivacy ? 'bg-emerald-600' : 'bg-gray-200'">
                            <span class="sr-only">Toggle WHOIS privacy</span>
                            <span :class="whoisPrivacy ? '{{ app()->getLocale() == 'ar' ? 'translate-x-1' : 'translate-x-6' }}' : '{{ app()->getLocale() == 'ar' ? 'translate-x-6' : 'translate-x-1' }}'" class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform shadow">
                                <svg x-show="loadingPrivacy" class="w-4 h-4 animate-spin text-gray-400" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </span>
                        </button>
                    </div>

                    <!-- Authorization Code -->
                    <div class="p-3 rounded-xl bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700">{{ app()->getLocale() == 'ar' ? 'كود التفويض (EPP)' : 'Authorization Code (EPP)' }}</span>
                            </div>
                            <button @click="getAuthCode()" :disabled="loadingAuthCode" class="px-3 py-1.5 text-xs font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors disabled:opacity-50">
                                <span x-show="!loadingAuthCode">{{ app()->getLocale() == 'ar' ? 'الحصول على الكود' : 'Get Code' }}</span>
                                <svg x-show="loadingAuthCode" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </div>
                        <!-- Auth Code Display -->
                        <div x-show="showAuthCode" x-transition class="mt-3 p-3 bg-white rounded-lg border border-gray-200">
                            <div class="flex items-center justify-between gap-2">
                                <code class="text-sm font-mono text-gray-800 break-all" x-text="authCode"></code>
                                <button @click="copyAuthCode()" class="flex-shrink-0 p-1.5 rounded-lg transition-colors" :class="copied ? 'text-green-600 bg-green-50' : 'text-gray-400 hover:text-blue-600 hover:bg-blue-50'" title="{{ app()->getLocale() == 'ar' ? 'نسخ' : 'Copy' }}">
                                    <!-- Copy Icon -->
                                    <svg x-show="!copied" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                    <!-- Checkmark Icon -->
                                    <svg x-show="copied" x-transition class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </button>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">{{ app()->getLocale() == 'ar' ? 'استخدم هذا الكود لنقل النطاق إلى مسجل آخر' : 'Use this code to transfer the domain to another registrar' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions Section -->
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-sm font-semibold text-gray-900">{{ app()->getLocale() == 'ar' ? 'الإجراءات' : 'Actions' }}</h2>
                </div>
                <div class="p-4 space-y-3">
                    <!-- Contact Information -->
                    <a href="{{ route('client.domains.contacts', $domain) }}" class="flex items-center justify-between p-3 rounded-xl bg-gray-50 hover:bg-blue-50 transition-colors group cursor-pointer">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-blue-600 transition-colors">{{ app()->getLocale() == 'ar' ? 'معلومات الاتصال' : 'Contact Information' }}</span>
                                <p class="text-xs text-gray-500">{{ app()->getLocale() == 'ar' ? 'إدارة بيانات التسجيل والتواصل' : 'Manage registration & contact details' }}</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 transition-colors {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>

                    <!-- Change Ownership -->
                    <a href="{{ route('client.domains.ownership', $domain) }}" class="flex items-center justify-between p-3 rounded-xl bg-gray-50 hover:bg-amber-50 transition-colors group cursor-pointer">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center group-hover:bg-amber-200 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                </svg>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-amber-600 transition-colors">{{ app()->getLocale() == 'ar' ? 'تغيير الملكية' : 'Change Ownership' }}</span>
                                <p class="text-xs text-gray-500">{{ app()->getLocale() == 'ar' ? 'نقل ملكية النطاق لحساب آخر' : 'Transfer domain ownership to another account' }}</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-amber-600 transition-colors {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>

                    <!-- Renew Domain -->
                    @if($domain->status === 'active')
                    <div x-data="{ renewLoading: false }" 
                         class="flex items-center justify-between p-3 rounded-xl bg-gray-50 hover:bg-emerald-50 transition-colors group cursor-pointer"
                         @click="if(!renewLoading) { renewLoading = true; addDomainRenewalToCart(); }">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                                <svg x-show="!renewLoading" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                <svg x-show="renewLoading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-emerald-600 transition-colors">{{ app()->getLocale() == 'ar' ? 'تجديد النطاق' : 'Renew Domain' }}</span>
                                <p class="text-xs text-gray-500">
                                    @if($renewalPrice > 0)
                                        {{ app()->getLocale() == 'ar' ? 'سنة واحدة مقابل' : '1 year for' }} ${{ number_format($renewalPrice, 2) }}
                                    @else
                                        {{ app()->getLocale() == 'ar' ? 'إضافة سنة إضافية للنطاق' : 'Add another year to your domain' }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-emerald-600 transition-colors {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Domain Health Check & Activity Log Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
        <!-- Domain Health Check -->
        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden"
             x-data="{
                 loading: false,
                 loaded: false,
                 checks: {},
                 score: 0,
                 overall: 'unknown',
                 async runHealthCheck() {
                     this.loading = true;
                     try {
                         const res = await fetch('{{ route('client.domains.health-check', $domain) }}');
                         const data = await res.json();
                         if (data.success) {
                             this.checks = data.checks;
                             this.score = data.score;
                             this.overall = data.overall;
                             this.loaded = true;
                         }
                     } catch (e) {
                         console.error(e);
                     }
                     this.loading = false;
                 }
             }">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h2 class="text-sm font-semibold text-gray-900">{{ app()->getLocale() == 'ar' ? 'فحص صحة النطاق' : 'Domain Health Check' }}</h2>
                </div>
                <button @click="runHealthCheck()" 
                        :disabled="loading"
                        class="px-3 py-1.5 text-xs font-medium text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors disabled:opacity-50 flex items-center gap-2">
                    <svg x-show="loading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    <span x-text="loading ? '{{ app()->getLocale() == 'ar' ? 'جاري الفحص...' : 'Checking...' }}' : (loaded ? '{{ app()->getLocale() == 'ar' ? 'إعادة الفحص' : 'Re-check' }}' : '{{ app()->getLocale() == 'ar' ? 'فحص الآن' : 'Run Check' }}')"></span>
                </button>
            </div>
            
            <div class="p-4">
                <!-- Not Checked Yet -->
                <template x-if="!loaded && !loading">
                    <div class="text-center py-8">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500">{{ app()->getLocale() == 'ar' ? 'اضغط على "فحص الآن" للبدء' : 'Click "Run Check" to start' }}</p>
                    </div>
                </template>

                <!-- Loading -->
                <template x-if="loading">
                    <div class="text-center py-8">
                        <div class="w-16 h-16 mx-auto mb-4">
                            <svg class="animate-spin w-16 h-16 text-indigo-500" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500">{{ app()->getLocale() == 'ar' ? 'جاري فحص النطاق...' : 'Checking domain health...' }}</p>
                    </div>
                </template>

                <!-- Results -->
                <template x-if="loaded && !loading">
                    <div>
                        <!-- Score -->
                        <div class="mb-4 p-4 rounded-xl" :class="{
                            'bg-emerald-50': overall === 'healthy',
                            'bg-amber-50': overall === 'warning',
                            'bg-red-50': overall === 'critical'
                        }">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center" :class="{
                                        'bg-emerald-100 text-emerald-600': overall === 'healthy',
                                        'bg-amber-100 text-amber-600': overall === 'warning',
                                        'bg-red-100 text-red-600': overall === 'critical'
                                    }">
                                        <span class="text-lg font-bold" x-text="score + '%'"></span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold" :class="{
                                            'text-emerald-700': overall === 'healthy',
                                            'text-amber-700': overall === 'warning',
                                            'text-red-700': overall === 'critical'
                                        }" x-text="overall === 'healthy' ? '{{ app()->getLocale() == 'ar' ? 'صحة ممتازة' : 'Excellent Health' }}' : (overall === 'warning' ? '{{ app()->getLocale() == 'ar' ? 'يحتاج اهتمام' : 'Needs Attention' }}' : '{{ app()->getLocale() == 'ar' ? 'حرج' : 'Critical' }}')"></p>
                                        <p class="text-xs text-gray-500">{{ app()->getLocale() == 'ar' ? 'تقييم صحة النطاق' : 'Domain health score' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Checks List -->
                        <div class="space-y-2">
                            <template x-for="(check, key) in checks" :key="key">
                                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center" :class="{
                                            'bg-emerald-100 text-emerald-600': check.status === 'success',
                                            'bg-amber-100 text-amber-600': check.status === 'warning',
                                            'bg-red-100 text-red-600': check.status === 'error'
                                        }">
                                            <svg x-show="check.status === 'success'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            <svg x-show="check.status === 'warning'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                            </svg>
                                            <svg x-show="check.status === 'error'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-700" x-text="check.name"></p>
                                            <p class="text-xs text-gray-500" x-text="check.message"></p>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Activity Log -->
        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden"
             x-data="{
                 loading: true,
                 activities: [],
                 async loadActivities() {
                     this.loading = true;
                     try {
                         const res = await fetch('{{ route('client.domains.activity-log', $domain) }}');
                         const data = await res.json();
                         if (data.success) {
                             this.activities = data.activities;
                         }
                     } catch (e) {
                         console.error(e);
                     }
                     this.loading = false;
                 }
             }"
             x-init="loadActivities()">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-sm font-semibold text-gray-900">{{ app()->getLocale() == 'ar' ? 'سجل النشاطات' : 'Activity Log' }}</h2>
                </div>
                <button @click="loadActivities()" 
                        :disabled="loading"
                        class="p-1.5 text-gray-400 hover:text-gray-600 transition-colors disabled:opacity-50">
                    <svg class="w-4 h-4" :class="{ 'animate-spin': loading }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </button>
            </div>
            
            <div class="p-4 max-h-96 overflow-y-auto">
                <!-- Loading -->
                <template x-if="loading">
                    <div class="text-center py-8">
                        <svg class="animate-spin w-8 h-8 text-purple-500 mx-auto mb-3" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        <p class="text-sm text-gray-500">{{ app()->getLocale() == 'ar' ? 'جاري التحميل...' : 'Loading...' }}</p>
                    </div>
                </template>

                <!-- Empty State -->
                <template x-if="!loading && activities.length === 0">
                    <div class="text-center py-8">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500">{{ app()->getLocale() == 'ar' ? 'لا توجد نشاطات حتى الآن' : 'No activities yet' }}</p>
                    </div>
                </template>

                <!-- Activities List -->
                <template x-if="!loading && activities.length > 0">
                    <div class="space-y-4">
                        <template x-for="activity in activities" :key="activity.id">
                            <div class="flex gap-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center">
                                        <svg x-show="activity.event === 'created'" class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        <svg x-show="activity.event === 'updated'" class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        <svg x-show="activity.event === 'deleted'" class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        <svg x-show="!['created', 'updated', 'deleted'].includes(activity.event)" class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-700" x-text="activity.description"></p>
                                    <p class="text-xs text-gray-400 mt-1" x-text="activity.time_ago"></p>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- DNS Records (Cloudflare) - Full Width -->
    @if($cloudflareActive)
    <div class="bg-white rounded-2xl border border-gray-200 mt-8"
                 x-data="{
                     loading: true,
                     records: [],
                     showAddForm: false,
                     editingRecord: null,
                     newRecord: {
                         type: 'A',
                         name: '',
                         content: '',
                         ttl: 1,
                         proxied: false,
                         priority: 10,
                         data: { priority: '', weight: '', port: '', target: '', flags: 0, tag: 'issue', value: '', cert_type: '', key_tag: '', algorithm: '', certificate: '', dnskey_flags: '', protocol: 3, dnskey_algorithm: '', public_key: '', ds_key_tag: '', ds_algorithm: '', digest_type: '', digest: '', https_priority: '', https_target: '', https_value: '', lat_degrees: '', lat_minutes: 0, lat_seconds: 0, lat_direction: 'N', long_degrees: '', long_minutes: 0, long_seconds: 0, long_direction: 'E', precision_horz: 0, precision_vert: 0, altitude: 0, size: 0, naptr_order: '', naptr_preference: '', naptr_flags: '', naptr_service: '', naptr_regex: '', naptr_replacement: '', smimea_usage: '', smimea_selector: '', smimea_matching_type: '', smimea_certificate: '', sshfp_algorithm: '', sshfp_type: '', sshfp_fingerprint: '', svcb_priority: '', svcb_target: '', svcb_value: '', tlsa_usage: '', tlsa_selector: '', tlsa_matching_type: '', tlsa_certificate: '', uri_priority: '', uri_weight: '', uri_target: '' }
                     },
                     recordTypes: ['A', 'AAAA', 'CAA', 'CERT', 'CNAME', 'HTTPS', 'LOC', 'MX', 'NAPTR', 'NS', 'OPENPGPKEY', 'PTR', 'SMIMEA', 'SRV', 'SSHFP', 'SVCB', 'TLSA', 'TXT', 'URI'],
                     resetRecordFields() {
                         this.newRecord.content = '';
                         this.newRecord.data = { priority: '', weight: '', port: '', target: '', flags: 0, tag: 'issue', value: '', cert_type: '', key_tag: '', algorithm: '', certificate: '', dnskey_flags: '', protocol: 3, dnskey_algorithm: '', public_key: '', ds_key_tag: '', ds_algorithm: '', digest_type: '', digest: '', https_priority: '', https_target: '', https_value: '', lat_degrees: '', lat_minutes: 0, lat_seconds: 0, lat_direction: 'N', long_degrees: '', long_minutes: 0, long_seconds: 0, long_direction: 'E', precision_horz: 0, precision_vert: 0, altitude: 0, size: 0, naptr_order: '', naptr_preference: '', naptr_flags: '', naptr_service: '', naptr_regex: '', naptr_replacement: '', smimea_usage: '', smimea_selector: '', smimea_matching_type: '', smimea_certificate: '', sshfp_algorithm: '', sshfp_type: '', sshfp_fingerprint: '', svcb_priority: '', svcb_target: '', svcb_value: '', tlsa_usage: '', tlsa_selector: '', tlsa_matching_type: '', tlsa_certificate: '', uri_priority: '', uri_weight: '', uri_target: '' };
                     },
                     async loadRecords() {
                         this.loading = true;
                         try {
                             const res = await fetch('{{ route('client.domains.dns-records', $domain) }}');
                             const data = await res.json();
                             if (data.success) {
                                 this.records = data.records;
                             }
                         } catch (e) {
                             console.error(e);
                         }
                         this.loading = false;
                     },
                     async addRecord() {
                         this.loading = true;
                         try {
                             const res = await fetch('{{ route('client.domains.dns-records.add', $domain) }}', {
                                 method: 'POST',
                                 headers: {
                                     'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                     'Accept': 'application/json',
                                     'Content-Type': 'application/json'
                                 },
                                 body: JSON.stringify(this.newRecord)
                             });
                             const data = await res.json();
                             if (data.success) {
                                 this.records.push(data.record);
                                 this.showAddForm = false;
                                 this.newRecord = {
                                     type: 'A',
                                     name: '',
                                     content: '',
                                     ttl: 1,
                                     proxied: false,
                                     priority: 10,
                                     data: { priority: 10, weight: 100, port: 443, target: '', flags: 0, tag: 'issue', value: '' }
                                 };
                             } else {
                                 alert(data.message);
                             }
                         } catch (e) {
                             console.error(e);
                         }
                         this.loading = false;
                     },
                     async updateRecord(record) {
                         this.loading = true;
                         try {
                             const res = await fetch('{{ url('my-domains/' . $domain->id . '/dns-records') }}/' + record.id, {
                                 method: 'PUT',
                                 headers: {
                                     'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                     'Accept': 'application/json',
                                     'Content-Type': 'application/json'
                                 },
                                 body: JSON.stringify(record)
                             });
                             const data = await res.json();
                             if (data.success) {
                                 const index = this.records.findIndex(r => r.id === record.id);
                                 if (index !== -1) this.records[index] = data.record;
                                 this.editingRecord = null;
                             } else {
                                 alert(data.message);
                             }
                         } catch (e) {
                             console.error(e);
                         }
                         this.loading = false;
                     },
                     async deleteRecord(recordId) {
                         if (!confirm('{{ app()->getLocale() == 'ar' ? 'هل أنت متأكد من حذف هذا السجل؟' : 'Are you sure you want to delete this record?' }}')) return;
                         this.loading = true;
                         try {
                             const res = await fetch('{{ url('my-domains/' . $domain->id . '/dns-records') }}/' + recordId, {
                                 method: 'DELETE',
                                 headers: {
                                     'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                     'Accept': 'application/json'
                                 }
                             });
                             const data = await res.json();
                             if (data.success) {
                                 this.records = this.records.filter(r => r.id !== recordId);
                             } else {
                                 alert(data.message);
                             }
                         } catch (e) {
                             console.error(e);
                         }
                         this.loading = false;
                     },
                     getTypeColor(type) {
                         const colors = {
                             'A': 'bg-blue-100 text-blue-700',
                             'AAAA': 'bg-purple-100 text-purple-700',
                             'CNAME': 'bg-green-100 text-green-700',
                             'TXT': 'bg-gray-100 text-gray-700',
                             'MX': 'bg-orange-100 text-orange-700',
                             'NS': 'bg-indigo-100 text-indigo-700'
                         };
                         return colors[type] || 'bg-gray-100 text-gray-700';
                     }
                 }"
                 x-init="loadRecords()">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 flex items-center justify-center">
                            <img src="{{ asset('logo/cloudflare.svg') }}" alt="Cloudflare" class="w-full h-full object-contain">
                        </div>
                        <h2 class="text-sm font-semibold text-gray-900">{{ app()->getLocale() == 'ar' ? 'سجلات DNS (Cloudflare)' : 'DNS Records (Cloudflare)' }}</h2>
                    </div>
                    <button @click="showAddForm = !showAddForm" class="text-sm text-blue-600 hover:text-blue-700 font-medium flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        {{ app()->getLocale() == 'ar' ? 'إضافة سجل' : 'Add Record' }}
                    </button>
                </div>

                <div class="p-6 relative">
                    <!-- Loading Overlay -->
                    <div x-show="loading" x-cloak class="absolute inset-0 bg-white/80 backdrop-blur-sm flex items-center justify-center z-10">
                        <svg class="animate-spin h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                    </div>

                    <!-- Add Record Form -->
                    <div x-show="showAddForm" x-cloak class="mb-6 p-4 bg-gray-50 rounded-xl border border-gray-200">
                        <h3 class="text-sm font-medium text-gray-900 mb-4">{{ app()->getLocale() == 'ar' ? 'إضافة سجل جديد' : 'Add New Record' }}</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                            <!-- Type -->
                            <div x-data="{ typeOpen: false }" class="relative" style="z-index: 100;">
                                <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'النوع' : 'Type' }}</label>
                                <button type="button" @click="typeOpen = !typeOpen" @click.away="typeOpen = false" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-left flex justify-between items-center">
                                    <span x-text="newRecord.type"></span>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div x-show="typeOpen" x-transition class="absolute left-0 right-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-48 overflow-y-auto" style="z-index: 9999;">
                                    <template x-for="type in recordTypes" :key="type">
                                        <button type="button" @click="newRecord.type = type; resetRecordFields(); typeOpen = false" class="w-full px-3 py-2 text-sm text-left hover:bg-gray-100" :class="{'bg-blue-50 text-blue-600': newRecord.type === type}" x-text="type"></button>
                                    </template>
                                </div>
                            </div>

                            <!-- Name (All types) -->
                            <div class="sm:col-span-3">
                                <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'الاسم' : 'Name' }}</label>
                                <input type="text" x-model="newRecord.name" placeholder="@" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- IPv4 Address (A) -->
                            <div x-show="newRecord.type === 'A'" class="sm:col-span-4">
                                <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'عنوان IPv4' : 'IPv4 Address' }}</label>
                                <input type="text" x-model="newRecord.content" placeholder="192.168.1.1" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- IPv6 Address (AAAA) -->
                            <div x-show="newRecord.type === 'AAAA'" class="sm:col-span-4">
                                <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'عنوان IPv6' : 'IPv6 Address' }}</label>
                                <input type="text" x-model="newRecord.content" placeholder="2001:db8::1" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- Target (CNAME) -->
                            <div x-show="newRecord.type === 'CNAME'" class="sm:col-span-4">
                                <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'الهدف' : 'Target' }}</label>
                                <input type="text" x-model="newRecord.content" placeholder="example.com" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- MX Fields -->
                            <div x-show="newRecord.type === 'MX'">
                                <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'خادم البريد' : 'Mail Server' }}</label>
                                <input type="text" x-model="newRecord.content" placeholder="mail.example.com" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div x-show="newRecord.type === 'MX'">
                                <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'الأولوية' : 'Priority' }}</label>
                                <input type="number" x-model="newRecord.priority" placeholder="10" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- TXT Content -->
                            <div x-show="newRecord.type === 'TXT'" class="sm:col-span-4">
                                <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'المحتوى' : 'Content' }}</label>
                                <textarea x-model="newRecord.content" placeholder="v=spf1 include:_spf.google.com ~all" rows="3" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                            </div>

                            <!-- NS Nameserver -->
                            <div x-show="newRecord.type === 'NS'" class="sm:col-span-4">
                                <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'خادم الأسماء' : 'Nameserver' }}</label>
                                <input type="text" x-model="newRecord.content" placeholder="ns1.example.com" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- SRV Fields -->
                            <template x-if="newRecord.type === 'SRV'">
                                <div class="sm:col-span-4 space-y-4">
                                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'الأولوية' : 'Priority' }} <span class="text-red-500">*</span></label>
                                            <input type="number" x-model="newRecord.data.priority" placeholder="0 - 65535" min="0" max="65535" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'الوزن' : 'Weight' }} <span class="text-red-500">*</span></label>
                                            <input type="number" x-model="newRecord.data.weight" placeholder="0 - 65535" min="0" max="65535" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'المنفذ' : 'Port' }} <span class="text-red-500">*</span></label>
                                            <input type="number" x-model="newRecord.data.port" placeholder="0 - 65535" min="0" max="65535" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'الهدف' : 'Target' }} <span class="text-red-500">*</span></label>
                                        <input type="text" x-model="newRecord.data.target" placeholder="E.g. www.example.com" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>
                            </template>

                            <!-- CAA Fields -->
                            <template x-if="newRecord.type === 'CAA'">
                                <div class="sm:col-span-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'العلامات' : 'Flags' }} <span class="text-red-500">*</span></label>
                                        <input type="number" x-model="newRecord.data.flags" value="0" readonly class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg bg-gray-100 text-gray-500 cursor-not-allowed">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'الوسم' : 'Tag' }} <span class="text-red-500">*</span></label>
                                        <select x-model="newRecord.data.tag" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="issue">{{ app()->getLocale() == 'ar' ? 'السماح بأسماء مضيفين محددة فقط' : 'Only allow specific hostnames' }}</option>
                                            <option value="issuewild">{{ app()->getLocale() == 'ar' ? 'السماح بـ wildcards فقط' : 'Only allow wildcards' }}</option>
                                            <option value="issueemail">{{ app()->getLocale() == 'ar' ? 'السماح بشهادات البريد الإلكتروني فقط' : 'Only allow certifying email addresses' }}</option>
                                            <option value="iodef">{{ app()->getLocale() == 'ar' ? 'إرسال تقارير الانتهاك إلى URL' : 'Send violation reports to URL (http:, https:, or mailto:)' }}</option>
                                        </select>
                                    </div>
                                    <div class="sm:col-span-4">
                                        <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'اسم نطاق CA' : 'CA domain name' }} <span class="text-red-500">*</span></label>
                                        <input type="text" x-model="newRecord.data.value" :placeholder="newRecord.data.tag === 'iodef' ? 'mailto:admin@example.com' : 'letsencrypt.org'" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <p class="text-xs text-gray-400 mt-1" x-show="newRecord.data.tag === 'iodef'">{{ app()->getLocale() == 'ar' ? 'استخدم http:, https:, أو mailto:' : 'Use http:, https:, or mailto:' }}</p>
                                    </div>
                                </div>
                            </template>

                            <!-- CERT Fields -->
                            <template x-if="newRecord.type === 'CERT'">
                                <div class="sm:col-span-4 grid grid-cols-2 sm:grid-cols-4 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'نوع الشهادة' : 'Cert. type' }} <span class="text-red-500">*</span></label>
                                        <input type="number" x-model="newRecord.data.cert_type" placeholder="0 - 65535" min="0" max="65535" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'علامة المفتاح' : 'Key tag' }} <span class="text-red-500">*</span></label>
                                        <input type="number" x-model="newRecord.data.key_tag" placeholder="0 - 65535" min="0" max="65535" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'الخوارزمية' : 'Algorithm' }} <span class="text-red-500">*</span></label>
                                        <input type="number" x-model="newRecord.data.algorithm" placeholder="0 - 255" min="0" max="255" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div class="sm:col-span-4">
                                        <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'الشهادة (Base64)' : 'Certificate (Base64)' }} <span class="text-red-500">*</span></label>
                                        <textarea x-model="newRecord.data.certificate" placeholder="E.g. TEpBNFYyTGtWUVpsTHpaa0htQXVPd0...wxREdCM3BRTTNWbUwyVIRNNERKWg==" rows="3" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                                    </div>
                                </div>
                            </template>

                            <!-- PTR -->
                            <div x-show="newRecord.type === 'PTR'" class="sm:col-span-4">
                                <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'اسم النطاق' : 'Domain Name' }}</label>
                                <input type="text" x-model="newRecord.content" placeholder="example.com" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- HTTPS Fields -->
                            <template x-if="newRecord.type === 'HTTPS'">
                                <div class="sm:col-span-4 grid grid-cols-2 sm:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'الأولوية' : 'Priority' }} <span class="text-red-500">*</span></label>
                                        <input type="number" x-model="newRecord.data.https_priority" placeholder="0 - 65535" min="0" max="65535" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'الهدف' : 'Target' }} <span class="text-red-500">*</span></label>
                                        <input type="text" x-model="newRecord.data.https_target" placeholder="." class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div class="sm:col-span-3">
                                        <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'القيمة' : 'Value' }}</label>
                                        <input type="text" x-model="newRecord.data.https_value" placeholder='E.g. alpn="h3,h2" ipv4hint="127.0.0.1" ipv6hint="::1"' class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>
                            </template>

                            <!-- LOC Fields -->
                            <template x-if="newRecord.type === 'LOC'">
                                <div class="sm:col-span-4 space-y-4">
                                    <!-- Set Latitude -->
                                    <div>
                                        <h4 class="text-xs font-semibold text-gray-700 mb-2">{{ app()->getLocale() == 'ar' ? 'تعيين خط العرض' : 'Set latitude' }}</h4>
                                        <div class="grid grid-cols-4 gap-3">
                                            <div>
                                                <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'الدرجات' : 'Degrees' }} <span class="text-red-500">*</span></label>
                                                <input type="number" x-model="newRecord.data.lat_degrees" placeholder="0 - 90" min="0" max="90" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'الدقائق' : 'Minutes' }} <span class="text-red-500">*</span></label>
                                                <input type="number" x-model="newRecord.data.lat_minutes" placeholder="0" min="0" max="59" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'الثواني' : 'Seconds' }} <span class="text-red-500">*</span></label>
                                                <input type="number" x-model="newRecord.data.lat_seconds" placeholder="0" min="0" max="59.999" step="0.001" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'الاتجاه' : 'Direction' }} <span class="text-red-500">*</span></label>
                                                <select x-model="newRecord.data.lat_direction" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                    <option value="N">{{ app()->getLocale() == 'ar' ? 'شمال' : 'North' }}</option>
                                                    <option value="S">{{ app()->getLocale() == 'ar' ? 'جنوب' : 'South' }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Set Longitude -->
                                    <div>
                                        <h4 class="text-xs font-semibold text-gray-700 mb-2">{{ app()->getLocale() == 'ar' ? 'تعيين خط الطول' : 'Set longitude' }}</h4>
                                        <div class="grid grid-cols-4 gap-3">
                                            <div>
                                                <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'الدرجات' : 'Degrees' }} <span class="text-red-500">*</span></label>
                                                <input type="number" x-model="newRecord.data.long_degrees" placeholder="0 - 180" min="0" max="180" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'الدقائق' : 'Minutes' }} <span class="text-red-500">*</span></label>
                                                <input type="number" x-model="newRecord.data.long_minutes" placeholder="0" min="0" max="59" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'الثواني' : 'Seconds' }} <span class="text-red-500">*</span></label>
                                                <input type="number" x-model="newRecord.data.long_seconds" placeholder="0" min="0" max="59.999" step="0.001" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'الاتجاه' : 'Direction' }} <span class="text-red-500">*</span></label>
                                                <select x-model="newRecord.data.long_direction" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                    <option value="E">{{ app()->getLocale() == 'ar' ? 'شرق' : 'East' }}</option>
                                                    <option value="W">{{ app()->getLocale() == 'ar' ? 'غرب' : 'West' }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Precision -->
                                    <div>
                                        <h4 class="text-xs font-semibold text-gray-700 mb-2">{{ app()->getLocale() == 'ar' ? 'الدقة (بالأمتار)' : 'Precision (in meters)' }}</h4>
                                        <div class="grid grid-cols-4 gap-3">
                                            <div>
                                                <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'أفقي' : 'Horizontal' }} <span class="text-red-500">*</span></label>
                                                <input type="number" x-model="newRecord.data.precision_horz" placeholder="0" min="0" step="0.01" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'عمودي' : 'Vertical' }} <span class="text-red-500">*</span></label>
                                                <input type="number" x-model="newRecord.data.precision_vert" placeholder="0" min="0" step="0.01" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'الارتفاع' : 'Altitude' }} <span class="text-red-500">*</span></label>
                                                <input type="number" x-model="newRecord.data.altitude" placeholder="0" step="0.01" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'الحجم' : 'Size' }} <span class="text-red-500">*</span></label>
                                                <input type="number" x-model="newRecord.data.size" placeholder="0" min="0" step="0.01" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <!-- NAPTR Fields -->
                            <template x-if="newRecord.type === 'NAPTR'">
                                <div class="sm:col-span-4 space-y-4">
                                    <div class="grid grid-cols-4 gap-3">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'الترتيب' : 'Order' }} <span class="text-red-500">*</span></label>
                                            <input type="number" x-model="newRecord.data.naptr_order" placeholder="0 - 65535" min="0" max="65535" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'التفضيل' : 'Preference' }} <span class="text-red-500">*</span></label>
                                            <input type="number" x-model="newRecord.data.naptr_preference" placeholder="0 - 65535" min="0" max="65535" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'الأعلام' : 'Flags' }} <span class="text-red-500">*</span></label>
                                            <input type="text" x-model="newRecord.data.naptr_flags" placeholder="S, A, U, P" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'الخدمة' : 'Service' }} <span class="text-red-500">*</span></label>
                                            <input type="text" x-model="newRecord.data.naptr_service" placeholder="E.g. protocol=..." class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'التعبير النمطي' : 'RegEx' }}</label>
                                            <input type="text" x-model="newRecord.data.naptr_regex" placeholder="E.g. delim-char=..." class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'البديل' : 'Replacement' }}</label>
                                            <input type="text" x-model="newRecord.data.naptr_replacement" placeholder="" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <!-- OPENPGPKEY Fields -->
                            <template x-if="newRecord.type === 'OPENPGPKEY'">
                                <div class="sm:col-span-4">
                                    <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'المفتاح العام (Base64)' : 'Public Key (Base64)' }} <span class="text-red-500">*</span></label>
                                    <textarea x-model="newRecord.content" placeholder="E.g. TEpBNFYyTGtWUVpsTHpaa0htQXVPd0...wxREdCM3BRTTNWbUwyVlRNNERKWg==" rows="3" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                                </div>
                            </template>

                            <!-- SMIMEA Fields -->
                            <template x-if="newRecord.type === 'SMIMEA'">
                                <div class="sm:col-span-4 space-y-4">
                                    <div class="grid grid-cols-3 gap-3">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'الاستخدام' : 'Usage' }} <span class="text-red-500">*</span></label>
                                            <input type="number" x-model="newRecord.data.smimea_usage" placeholder="0 - 255" min="0" max="255" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'المحدد' : 'Selector' }} <span class="text-red-500">*</span></label>
                                            <input type="number" x-model="newRecord.data.smimea_selector" placeholder="0 - 255" min="0" max="255" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'نوع المطابقة' : 'Matching type' }} <span class="text-red-500">*</span></label>
                                            <input type="number" x-model="newRecord.data.smimea_matching_type" placeholder="0 - 255" min="0" max="255" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'الشهادة (سداسي عشري)' : 'Certificate (hexadecimal)' }} <span class="text-red-500">*</span></label>
                                        <textarea x-model="newRecord.data.smimea_certificate" placeholder="E.g. 436c6f7564666c...61726520444e53" rows="3" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                                    </div>
                                </div>
                            </template>

                            <!-- SSHFP Fields -->
                            <template x-if="newRecord.type === 'SSHFP'">
                                <div class="sm:col-span-4 space-y-4">
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'الخوارزمية' : 'Algorithm' }} <span class="text-red-500">*</span></label>
                                            <input type="number" x-model="newRecord.data.sshfp_algorithm" placeholder="0 - 255" min="0" max="255" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'النوع' : 'Type' }} <span class="text-red-500">*</span></label>
                                            <input type="number" x-model="newRecord.data.sshfp_type" placeholder="0 - 255" min="0" max="255" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'البصمة (سداسي عشري)' : 'Fingerprint (hexadecimal)' }} <span class="text-red-500">*</span></label>
                                        <textarea x-model="newRecord.data.sshfp_fingerprint" placeholder="E.g. 436c6f7564666c...61726520444e53" rows="3" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                                    </div>
                                </div>
                            </template>

                            <!-- SVCB Fields -->
                            <template x-if="newRecord.type === 'SVCB'">
                                <div class="sm:col-span-4 space-y-4">
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'الأولوية' : 'Priority' }} <span class="text-red-500">*</span></label>
                                            <input type="number" x-model="newRecord.data.svcb_priority" placeholder="0 - 65535" min="0" max="65535" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'الهدف' : 'Target' }} <span class="text-red-500">*</span></label>
                                            <input type="text" x-model="newRecord.data.svcb_target" placeholder="" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'القيمة' : 'Value' }}</label>
                                        <input type="text" x-model="newRecord.data.svcb_value" placeholder="E.g. alpn=\"h3,h2\" ipv4hint=\"127.0.0.1\" ipv6hint=\"::1\"" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>
                            </template>

                            <!-- TLSA Fields -->
                            <template x-if="newRecord.type === 'TLSA'">
                                <div class="sm:col-span-4 space-y-4">
                                    <div class="grid grid-cols-3 gap-3">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'الاستخدام' : 'Usage' }} <span class="text-red-500">*</span></label>
                                            <input type="number" x-model="newRecord.data.tlsa_usage" placeholder="0 - 255" min="0" max="255" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'المحدد' : 'Selector' }} <span class="text-red-500">*</span></label>
                                            <input type="number" x-model="newRecord.data.tlsa_selector" placeholder="0 - 255" min="0" max="255" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'نوع المطابقة' : 'Matching type' }}</label>
                                            <input type="number" x-model="newRecord.data.tlsa_matching_type" placeholder="0 - 255" min="0" max="255" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'الشهادة (سداسي عشري)' : 'Certificate (hexadecimal)' }} <span class="text-red-500">*</span></label>
                                        <textarea x-model="newRecord.data.tlsa_certificate" placeholder="E.g. 436c6f7564666c...61726520444e53" rows="3" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                                    </div>
                                </div>
                            </template>

                            <!-- URI Fields -->
                            <template x-if="newRecord.type === 'URI'">
                                <div class="sm:col-span-4 space-y-4">
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'الأولوية' : 'Priority' }} <span class="text-red-500">*</span></label>
                                            <input type="number" x-model="newRecord.data.uri_priority" placeholder="0 - 255" min="0" max="255" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'الوزن' : 'Weight' }} <span class="text-red-500">*</span></label>
                                            <input type="number" x-model="newRecord.data.uri_weight" placeholder="0 - 65535" min="0" max="65535" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-1.5">{{ app()->getLocale() == 'ar' ? 'الهدف' : 'Target' }} <span class="text-red-500">*</span></label>
                                        <textarea x-model="newRecord.data.uri_target" placeholder="" rows="3" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                                    </div>
                                </div>
                            </template>

                            <!-- TTL (All types) -->
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1.5">TTL</label>
                                <select x-model="newRecord.ttl" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="1">{{ app()->getLocale() == 'ar' ? 'تلقائي' : 'Auto' }}</option>
                                    <option value="60">1 {{ app()->getLocale() == 'ar' ? 'دقيقة' : 'minute' }}</option>
                                    <option value="300">5 {{ app()->getLocale() == 'ar' ? 'دقائق' : 'minutes' }}</option>
                                    <option value="600">10 {{ app()->getLocale() == 'ar' ? 'دقائق' : 'minutes' }}</option>
                                    <option value="900">15 {{ app()->getLocale() == 'ar' ? 'دقيقة' : 'minutes' }}</option>
                                    <option value="1800">30 {{ app()->getLocale() == 'ar' ? 'دقيقة' : 'minutes' }}</option>
                                    <option value="3600">1 {{ app()->getLocale() == 'ar' ? 'ساعة' : 'hour' }}</option>
                                    <option value="7200">2 {{ app()->getLocale() == 'ar' ? 'ساعة' : 'hours' }}</option>
                                    <option value="18000">5 {{ app()->getLocale() == 'ar' ? 'ساعات' : 'hours' }}</option>
                                    <option value="43200">12 {{ app()->getLocale() == 'ar' ? 'ساعة' : 'hours' }}</option>
                                    <option value="86400">1 {{ app()->getLocale() == 'ar' ? 'يوم' : 'day' }}</option>
                                </select>
                            </div>

                            <!-- Proxied (A, AAAA, CNAME only) -->
                            <div x-show="['A', 'AAAA', 'CNAME'].includes(newRecord.type)" class="flex items-center gap-2 self-end pb-2">
                                <input type="checkbox" x-model="newRecord.proxied" id="proxied" class="rounded border-gray-300 text-orange-500 focus:ring-orange-500">
                                <label for="proxied" class="text-sm text-gray-600 flex items-center gap-1">
                                    <img src="{{ asset('logo/cloudflare.svg') }}" alt="" class="w-4 h-4">
                                    {{ app()->getLocale() == 'ar' ? 'Proxy' : 'Proxied' }}
                                </label>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 mt-4">
                            <button @click="addRecord()" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                {{ app()->getLocale() == 'ar' ? 'إضافة' : 'Add' }}
                            </button>
                            <button @click="showAddForm = false" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                                {{ app()->getLocale() == 'ar' ? 'إلغاء' : 'Cancel' }}
                            </button>
                        </div>
                    </div>

                    <!-- Records List -->
                    <div class="dns-records-list space-y-2 h-[400px] overflow-y-auto pr-2">
                        <template x-if="records.length === 0 && !loading">
                            <p class="text-sm text-gray-400 text-center py-4">{{ app()->getLocale() == 'ar' ? 'لا توجد سجلات DNS' : 'No DNS records found' }}</p>
                        </template>

                        <template x-for="record in records" :key="record.id">
                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors group">
                                <!-- Type Badge -->
                                <span :class="getTypeColor(record.type)" class="px-2 py-1 text-xs font-semibold rounded-md min-w-[50px] text-center" x-text="record.type"></span>

                                <!-- Record Info -->
                                <div class="flex-1 min-w-0">
                                    <template x-if="editingRecord !== record.id">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 truncate" x-text="record.name"></p>
                                            <p class="text-xs text-gray-500 truncate" x-text="record.content"></p>
                                        </div>
                                    </template>
                                    <template x-if="editingRecord === record.id">
                                        <div class="flex flex-col gap-2">
                                            <input type="text" x-model="record.name" class="px-2 py-1 text-sm border border-gray-200 rounded focus:ring-1 focus:ring-blue-500">
                                            <input type="text" x-model="record.content" class="px-2 py-1 text-sm border border-gray-200 rounded focus:ring-1 focus:ring-blue-500">
                                            <!-- Proxy Toggle in Edit Mode -->
                                            <template x-if="['A', 'AAAA', 'CNAME'].includes(record.type)">
                                                <div class="flex items-center gap-2">
                                                    <button type="button"
                                                        @click="record.proxied = !record.proxied"
                                                        :class="record.proxied ? 'bg-orange-500' : 'bg-gray-300'"
                                                        class="relative inline-flex h-5 w-9 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none">
                                                        <span :class="record.proxied ? 'translate-x-4' : 'translate-x-0'" class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                                    </button>
                                                    <span class="text-xs" :class="record.proxied ? 'text-orange-500' : 'text-gray-500'" x-text="record.proxied ? 'Proxied' : 'DNS Only'"></span>
                                                </div>
                                            </template>
                                        </div>
                                    </template>
                                </div>

                                <!-- Proxied Status -->
                                <template x-if="['A', 'AAAA', 'CNAME'].includes(record.type)">
                                    <span class="text-xs">
                                        <img src="{{ asset('logo/cloudflare.svg') }}"
                                             class="w-6 h-6 transition-all"
                                             :class="record.proxied ? 'opacity-100' : 'opacity-30 grayscale'"
                                             :title="record.proxied ? 'Proxied' : 'DNS Only'">
                                    </span>
                                </template>

                                <!-- Actions -->
                                <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <template x-if="editingRecord !== record.id">
                                        <button @click="editingRecord = record.id" class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </button>
                                    </template>
                                    <template x-if="editingRecord === record.id">
                                        <button @click="updateRecord(record)" class="p-1.5 text-green-600 hover:bg-green-50 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </button>
                                    </template>
                                    <template x-if="editingRecord === record.id">
                                        <button @click="editingRecord = null" class="p-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </template>
                                    <button @click="deleteRecord(record.id)" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
    @endif
</div>

<style>
    [x-cloak] { display: none !important; }

    /* Custom Scrollbar for DNS Records */
    .dns-records-list::-webkit-scrollbar {
        width: 6px;
    }
    .dns-records-list::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    .dns-records-list::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }
    .dns-records-list::-webkit-scrollbar-thumb:hover {
        background: #a1a1a1;
    }
</style>

<script>
function addDomainRenewalToCart() {
    fetch('{{ route('cart.add-domain') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            domain: '{{ $domain->domain_name }}',
            price: {{ $renewalPrice ?? 0 }},
            type: 'renew',
            tld: '{{ $domain->tld }}',
            renewal_price: {{ $renewalPrice ?? 0 }}
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('{{ app()->getLocale() == 'ar' ? 'تمت إضافة التجديد للسلة' : 'Renewal added to cart' }}', 'success');
            setTimeout(() => {
                window.location.href = '{{ route('cart.index') }}';
            }, 1500);
        } else {
            // If domain already in cart, redirect to cart anyway
            if (data.message && data.message.includes('already')) {
                window.location.href = '{{ route('cart.index') }}';
            } else {
                showToast(data.message || '{{ app()->getLocale() == 'ar' ? 'حدث خطأ' : 'An error occurred' }}', 'error');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('{{ app()->getLocale() == 'ar' ? 'حدث خطأ في الاتصال' : 'Connection error' }}', 'error');
    });
}

function showToast(message, type = 'info') {
    // Remove existing toast
    const existingToast = document.getElementById('custom-toast');
    if (existingToast) existingToast.remove();
    
    // Create toast element
    const toast = document.createElement('div');
    toast.id = 'custom-toast';
    toast.className = `fixed top-4 {{ app()->getLocale() == 'ar' ? 'left-4' : 'right-4' }} z-50 px-6 py-3 rounded-xl shadow-lg transform transition-all duration-300 flex items-center gap-3`;
    
    // Set colors based on type
    if (type === 'success') {
        toast.classList.add('bg-emerald-500', 'text-white');
    } else if (type === 'error') {
        toast.classList.add('bg-red-500', 'text-white');
    } else {
        toast.classList.add('bg-gray-800', 'text-white');
    }
    
    // Icon
    const icon = type === 'success' 
        ? '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>'
        : '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>';
    
    toast.innerHTML = icon + '<span class="font-medium">' + message + '</span>';
    document.body.appendChild(toast);
    
    // Animate in
    setTimeout(() => toast.classList.add('translate-y-0', 'opacity-100'), 10);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        toast.classList.add('opacity-0', '-translate-y-2');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>
@endsection
