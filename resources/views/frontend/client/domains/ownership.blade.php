@extends('frontend.client.layout')

@section('title', (app()->getLocale() == 'ar' ? 'تغيير الملكية - ' : 'Change Ownership - ') . $domain->domain_name)

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('client.domains.show', $domain) }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 mb-4">
                <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                {{ app()->getLocale() == 'ar' ? 'العودة للنطاق' : 'Back to Domain' }}
            </a>
            <h1 class="text-2xl font-bold text-gray-900">{{ app()->getLocale() == 'ar' ? 'تغيير الملكية' : 'Change Ownership' }}</h1>
            <p class="text-gray-500 mt-1">{{ $domain->domain_name }}</p>
        </div>

        <!-- Warning Card -->
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div>
                    <p class="text-sm font-semibold text-red-800">{{ app()->getLocale() == 'ar' ? 'تحذير: هذا الإجراء لا يمكن التراجع عنه!' : 'Warning: This action cannot be undone!' }}</p>
                    <p class="text-sm text-red-700 mt-1">{{ app()->getLocale() == 'ar' ? 'نقل ملكية النطاق سيزيل النطاق من حسابك بشكل نهائي ولن تتمكن من الوصول إليه مرة أخرى.' : 'Transferring domain ownership will permanently remove the domain from your account and you will no longer have access to it.' }}</p>
                </div>
            </div>
        </div>

        <!-- Transfer Form -->
        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden"
             x-data="{
                 loading: false,
                 lookingUp: false,
                 sendingOtp: false,
                 identifier: '',
                 confirmDomain: '',
                 otpCode: '',
                 showConfirmation: false,
                 otpSent: false,
                 otpResendCountdown: 0,
                 foundClient: null,
                 errorMessage: '',
                 successMessage: '',
                 transferComplete: false,
                 redirectUrl: '',
                 async lookupClient() {
                     if (!this.identifier || this.identifier.length < 3) {
                         this.errorMessage = '{{ app()->getLocale() == 'ar' ? 'أدخل البريد الإلكتروني أو اسم المستخدم' : 'Enter email or username' }}';
                         return;
                     }
                     
                     this.lookingUp = true;
                     this.errorMessage = '';
                     this.foundClient = null;
                     
                     try {
                         const res = await fetch('{{ route('client.domains.ownership.lookup', $domain) }}', {
                             method: 'POST',
                             headers: {
                                 'Content-Type': 'application/json',
                                 'X-CSRF-TOKEN': '{{ csrf_token() }}'
                             },
                             body: JSON.stringify({ identifier: this.identifier })
                         });
                         const data = await res.json();
                         if (data.success) {
                             this.foundClient = data.client;
                         } else {
                             this.errorMessage = data.message;
                         }
                     } catch (e) {
                         this.errorMessage = '{{ app()->getLocale() == 'ar' ? 'حدث خطأ أثناء البحث' : 'An error occurred while searching' }}';
                     }
                     this.lookingUp = false;
                 },
                 resetSearch() {
                     this.identifier = '';
                     this.foundClient = null;
                     this.errorMessage = '';
                     this.showConfirmation = false;
                     this.otpSent = false;
                     this.otpCode = '';
                     this.confirmDomain = '';
                 },
                 async sendOtp() {
                     if (!this.foundClient) return;
                     
                     this.sendingOtp = true;
                     this.errorMessage = '';
                     
                     try {
                         const res = await fetch('{{ route('client.domains.ownership.send-otp', $domain) }}', {
                             method: 'POST',
                             headers: {
                                 'Content-Type': 'application/json',
                                 'X-CSRF-TOKEN': '{{ csrf_token() }}'
                             },
                             body: JSON.stringify({ client_id: this.foundClient.id })
                         });
                         const data = await res.json();
                         if (data.success) {
                             this.otpSent = true;
                             this.showConfirmation = true;
                             this.startResendCountdown();
                         } else {
                             this.errorMessage = data.message;
                         }
                     } catch (e) {
                         this.errorMessage = '{{ app()->getLocale() == 'ar' ? 'حدث خطأ أثناء إرسال الكود' : 'An error occurred while sending the code' }}';
                     }
                     this.sendingOtp = false;
                 },
                 startResendCountdown() {
                     this.otpResendCountdown = 60;
                     const interval = setInterval(() => {
                         this.otpResendCountdown--;
                         if (this.otpResendCountdown <= 0) {
                             clearInterval(interval);
                         }
                     }, 1000);
                 },
                 async submitForm() {
                     if (!this.otpSent) {
                         await this.sendOtp();
                         return;
                     }
                     
                     if (!this.otpCode || this.otpCode.length !== 6) {
                         this.errorMessage = '{{ app()->getLocale() == 'ar' ? 'أدخل كود التحقق المكون من 6 أرقام' : 'Enter the 6-digit verification code' }}';
                         return;
                     }
                     
                     this.loading = true;
                     this.errorMessage = '';
                     
                     try {
                         const res = await fetch('{{ route('client.domains.ownership.transfer', $domain) }}', {
                             method: 'POST',
                             headers: {
                                 'Content-Type': 'application/json',
                                 'X-CSRF-TOKEN': '{{ csrf_token() }}'
                             },
                             body: JSON.stringify({
                                 client_id: this.foundClient.id,
                                 confirm_domain: this.confirmDomain,
                                 otp: this.otpCode
                             })
                         });
                         const data = await res.json();
                         if (data.success) {
                             this.successMessage = data.message;
                             this.transferComplete = true;
                             this.redirectUrl = data.redirect;
                             // Auto redirect after 3 seconds
                             setTimeout(() => {
                                 if (data.redirect) {
                                     window.location.href = data.redirect;
                                 }
                             }, 3000);
                         } else {
                             this.errorMessage = data.message || '{{ app()->getLocale() == 'ar' ? 'حدث خطأ' : 'An error occurred' }}';
                         }
                     } catch (e) {
                         this.errorMessage = '{{ app()->getLocale() == 'ar' ? 'حدث خطأ' : 'An error occurred' }}';
                     }
                     this.loading = false;
                 }
             }">
            <!-- Success Notification Overlay -->
            <div x-show="transferComplete" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" style="display: none;">
                <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 overflow-hidden" x-transition:enter="transition ease-out duration-300 delay-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                    <div class="p-8 text-center">
                        <!-- Success Icon -->
                        <div class="mx-auto w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        
                        <!-- Success Message -->
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ app()->getLocale() == 'ar' ? 'تم بنجاح!' : 'Success!' }}</h3>
                        <p class="text-gray-600 mb-6" x-text="successMessage"></p>
                        
                        <!-- Redirect Notice -->
                        <div class="flex items-center justify-center gap-2 text-sm text-gray-500 mb-6">
                            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>{{ app()->getLocale() == 'ar' ? 'سيتم تحويلك خلال 3 ثوانٍ...' : 'Redirecting in 3 seconds...' }}</span>
                        </div>
                        
                        <!-- Manual Redirect Button -->
                        <a :href="redirectUrl" class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition-colors">
                            <span>{{ app()->getLocale() == 'ar' ? 'الذهاب للنطاقات' : 'Go to Domains' }}</span>
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-900">{{ app()->getLocale() == 'ar' ? 'نقل ملكية النطاق' : 'Transfer Domain Ownership' }}</h2>
                <p class="text-sm text-gray-500 mt-1">{{ app()->getLocale() == 'ar' ? 'أدخل البريد الإلكتروني أو اسم المستخدم للحساب الذي تريد نقل النطاق إليه' : 'Enter the email or username of the account you want to transfer the domain to' }}</p>
            </div>

            <form @submit.prevent="foundClient ? submitForm() : lookupClient()" class="p-6 space-y-6">
                <!-- Current Owner Info -->
                <div class="p-4 bg-gray-50 rounded-xl">
                    <p class="text-sm text-gray-500 mb-1">{{ app()->getLocale() == 'ar' ? 'المالك الحالي' : 'Current Owner' }}</p>
                    <p class="font-medium text-gray-900">{{ auth('client')->user()->name }}</p>
                    <p class="text-sm text-gray-500">{{ auth('client')->user()->email }}</p>
                </div>

                <!-- Arrow Icon -->
                <div class="flex justify-center">
                    <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                        </svg>
                    </div>
                </div>

                <!-- New Owner Search -->
                <div x-show="!foundClient">
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'المالك الجديد (البريد الإلكتروني أو اسم المستخدم)' : 'New Owner (Email or Username)' }} <span class="text-red-500">*</span></label>
                    <div class="flex gap-2">
                        <input type="text" x-model="identifier" @keyup.enter.prevent="lookupClient()" :disabled="lookingUp" placeholder="{{ app()->getLocale() == 'ar' ? 'أدخل البريد الإلكتروني أو اسم المستخدم' : 'Enter email or username' }}" class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 disabled:bg-gray-100 disabled:cursor-not-allowed">
                        <button type="button" @click="lookupClient()" :disabled="lookingUp || !identifier" class="px-4 py-3 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                            <svg x-show="lookingUp" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <svg x-show="!lookingUp" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <span class="hidden sm:inline">{{ app()->getLocale() == 'ar' ? 'بحث' : 'Search' }}</span>
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">{{ app()->getLocale() == 'ar' ? 'يجب أن يكون الحساب مسجلاً مسبقاً في النظام' : 'The account must already be registered in the system' }}</p>
                    
                    <!-- Error Message -->
                    <div x-show="errorMessage" x-transition class="mt-3 p-3 bg-red-50 border border-red-200 rounded-xl">
                        <p class="text-sm text-red-600 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span x-text="errorMessage"></span>
                        </p>
                    </div>
                </div>

                <!-- Found Client Info -->
                <div x-show="foundClient" x-transition class="p-4 bg-green-50 border border-green-200 rounded-xl">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-green-600 font-medium">{{ app()->getLocale() == 'ar' ? 'تم العثور على المستخدم' : 'User Found' }}</p>
                                <p class="font-semibold text-gray-900" x-text="foundClient?.name"></p>
                                <p class="text-sm text-gray-500" x-text="foundClient?.email"></p>
                                <p class="text-xs text-gray-400" x-show="foundClient?.username">@<span x-text="foundClient?.username"></span></p>
                            </div>
                        </div>
                        <button type="button" @click="resetSearch()" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Confirmation Section -->
                <div x-show="showConfirmation && foundClient" x-transition class="space-y-4 pt-4 border-t border-gray-200">
                    <!-- OTP Input -->
                    <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-blue-800">{{ app()->getLocale() == 'ar' ? 'تم إرسال كود التحقق' : 'Verification code sent' }}</p>
                                <p class="text-sm text-blue-600 mt-1">{{ app()->getLocale() == 'ar' ? 'تحقق من بريدك الإلكتروني وأدخل الكود المكون من 6 أرقام' : 'Check your email and enter the 6-digit code' }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'كود التحقق' : 'Verification Code' }} <span class="text-red-500">*</span></label>
                        <div class="flex gap-2">
                            <input type="text" x-model="otpCode" maxlength="6" placeholder="000000" class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-center text-2xl tracking-widest font-mono" @input="otpCode = $event.target.value.replace(/[^0-9]/g, '').slice(0, 6)">
                            <button type="button" @click="sendOtp()" :disabled="sendingOtp || otpResendCountdown > 0" class="px-4 py-3 text-blue-600 hover:bg-blue-50 border border-blue-300 font-medium rounded-xl transition-colors disabled:opacity-50 disabled:cursor-not-allowed whitespace-nowrap">
                                <span x-show="sendingOtp" class="flex items-center gap-2">
                                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </span>
                                <span x-show="!sendingOtp && otpResendCountdown > 0" x-text="otpResendCountdown + 's'"></span>
                                <span x-show="!sendingOtp && otpResendCountdown <= 0">{{ app()->getLocale() == 'ar' ? 'إعادة إرسال' : 'Resend' }}</span>
                            </button>
                        </div>
                    </div>

                    <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl">
                        <p class="text-sm text-amber-800">{{ app()->getLocale() == 'ar' ? 'للتأكيد، أدخل اسم النطاق الكامل:' : 'To confirm, enter the full domain name:' }}</p>
                        <p class="font-mono font-bold text-amber-900 mt-1">{{ $domain->domain_name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'تأكيد اسم النطاق' : 'Confirm Domain Name' }} <span class="text-red-500">*</span></label>
                        <input type="text" x-model="confirmDomain" placeholder="{{ $domain->domain_name }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    </div>

                    <!-- Error Message in Confirmation -->
                    <div x-show="errorMessage" x-transition class="p-3 bg-red-50 border border-red-200 rounded-xl">
                        <p class="text-sm text-red-600 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span x-text="errorMessage"></span>
                        </p>
                    </div>
                </div>

                <!-- Submit Button -->
                <div x-show="foundClient" class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <button type="button" x-show="showConfirmation" @click="showConfirmation = false; confirmDomain = ''; otpCode = ''; errorMessage = ''" class="px-4 py-2 text-gray-600 hover:text-gray-900 transition-colors">
                        {{ app()->getLocale() == 'ar' ? 'رجوع' : 'Back' }}
                    </button>
                    <div x-show="!showConfirmation"></div>
                    <button type="submit" :disabled="loading || sendingOtp || (showConfirmation && (confirmDomain.toLowerCase() !== '{{ strtolower($domain->domain_name) }}' || otpCode.length !== 6))" class="px-6 py-2.5 font-semibold rounded-xl transition-colors disabled:opacity-50 flex items-center gap-2" :class="showConfirmation ? 'bg-red-600 text-white hover:bg-red-700' : 'bg-amber-600 text-white hover:bg-amber-700'">
                        <svg x-show="loading || sendingOtp" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span x-text="showConfirmation ? '{{ app()->getLocale() == 'ar' ? 'تأكيد النقل' : 'Confirm Transfer' }}' : '{{ app()->getLocale() == 'ar' ? 'إرسال كود التحقق' : 'Send Verification Code' }}'"></span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Info Notice -->
        <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-xl">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="text-sm font-medium text-blue-800">{{ app()->getLocale() == 'ar' ? 'ماذا يحدث عند نقل الملكية؟' : 'What happens when you transfer ownership?' }}</p>
                    <ul class="text-sm text-blue-700 mt-2 space-y-1 list-disc list-inside">
                        <li>{{ app()->getLocale() == 'ar' ? 'سيتم نقل النطاق للحساب الجديد فوراً' : 'The domain will be transferred to the new account immediately' }}</li>
                        <li>{{ app()->getLocale() == 'ar' ? 'ستفقد الوصول لإدارة النطاق' : 'You will lose access to manage the domain' }}</li>
                        <li>{{ app()->getLocale() == 'ar' ? 'إعدادات DNS والنيمسيرفر لن تتغير' : 'DNS settings and nameservers will not change' }}</li>
                        <li>{{ app()->getLocale() == 'ar' ? 'المالك الجديد سيكون مسؤولاً عن التجديد' : 'The new owner will be responsible for renewal' }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
