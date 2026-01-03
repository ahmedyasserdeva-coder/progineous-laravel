@extends('frontend.client.layout')

@section('title', app()->getLocale() == 'ar' ? 'الإعدادات' : 'Settings')

@push('styles')
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
    .animate-fade-in {
        animation: fadeIn 0.2s ease-out;
    }
    
    /* Disconnect Modal Animation */
    #disconnectAccountModal .bg-white,
    #disconnectSuccessModal .bg-white {
        transform: scale(0.95);
        opacity: 0;
        transition: all 0.2s ease-out;
    }
    
    #disconnectAccountModal[style*="display: flex"] .bg-white,
    #disconnectSuccessModal[style*="display: flex"] .bg-white {
        transform: scale(1);
        opacity: 1;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-purple-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 py-8">
    <div class="container mx-auto px-4 max-w-4xl">
        @php $rtl = app()->getLocale() == 'ar'; @endphp
        
        {{-- Page Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">
                {{ app()->getLocale() == 'ar' ? 'الإعدادات' : 'Settings' }}
            </h1>
            <p class="text-slate-600 dark:text-slate-400">
                {{ app()->getLocale() == 'ar' ? 'إدارة إعدادات حسابك وتفضيلاتك' : 'Manage your account settings and preferences' }}
            </p>
        </div>

        {{-- Success/Error Messages --}}
        @if (session('success'))
            <div class="mb-6 animate-fade-in">
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <p class="text-green-800 dark:text-green-300 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 animate-fade-in">
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <p class="text-red-800 dark:text-red-300 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @if (session('info'))
            <div class="mb-6 animate-fade-in">
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-blue-800 dark:text-blue-300 font-medium">{{ session('info') }}</p>
                </div>
            </div>
        @endif

        {{-- Security Settings --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl overflow-hidden mb-6">
            <div class="p-6 border-b border-slate-200 dark:border-slate-700">
                <h2 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    {{ app()->getLocale() == 'ar' ? 'الأمان وكلمة المرور' : 'Security & Password' }}
                </h2>
            </div>

            <form id="passwordForm" class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    {{-- Current Password --}}
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            {{ app()->getLocale() == 'ar' ? 'كلمة المرور الحالية' : 'Current Password' }}
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   id="current_password" 
                                   name="current_password"
                                   class="w-full px-4 py-3 pr-12 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white"
                                   required>
                            <button type="button" 
                                    id="toggleCurrentPassword"
                                    class="absolute {{ app()->getLocale() == 'ar' ? 'left-3' : 'right-3' }} top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                                <svg id="currentEyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        {{-- Current Password Validation Message --}}
                        <div id="current-password-message" class="mt-2 text-sm hidden"></div>
                    </div>

                    {{-- New Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            {{ app()->getLocale() == 'ar' ? 'كلمة المرور الجديدة' : 'New Password' }}
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   id="password" 
                                   name="password"
                                   class="w-full px-4 py-3 pr-12 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white"
                                   required>
                            <button type="button" 
                                    id="togglePassword"
                                    class="absolute {{ app()->getLocale() == 'ar' ? 'left-3' : 'right-3' }} top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                                <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        
                        {{-- Password Strength Meter --}}
                        <div class="mt-3">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-xs font-medium text-slate-600 dark:text-slate-400">
                                    {{ app()->getLocale() == 'ar' ? 'قوة كلمة المرور:' : 'Password Strength:' }}
                                </span>
                                <span id="strengthText" class="text-xs font-semibold"></span>
                            </div>
                            <div class="h-2 bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden">
                                <div id="strengthBar" class="h-full transition-all duration-300 rounded-full" style="width: 0%"></div>
                            </div>
                        </div>
                        
                        {{-- Password Requirements --}}
                        <div class="mt-3 space-y-1">
                            <div id="req-length" class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                <span>{{ app()->getLocale() == 'ar' ? '8 أحرف على الأقل' : 'At least 8 characters' }}</span>
                            </div>
                            <div id="req-uppercase" class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                <span>{{ app()->getLocale() == 'ar' ? 'حرف كبير واحد على الأقل' : 'At least one uppercase letter' }}</span>
                            </div>
                            <div id="req-lowercase" class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                <span>{{ app()->getLocale() == 'ar' ? 'حرف صغير واحد على الأقل' : 'At least one lowercase letter' }}</span>
                            </div>
                            <div id="req-number" class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                <span>{{ app()->getLocale() == 'ar' ? 'رقم واحد على الأقل' : 'At least one number' }}</span>
                            </div>
                            <div id="req-special" class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                <span>{{ app()->getLocale() == 'ar' ? 'رمز خاص واحد على الأقل (!@#$...)' : 'At least one special character (!@#$...)' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            {{ app()->getLocale() == 'ar' ? 'تأكيد كلمة المرور' : 'Confirm Password' }}
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   id="password_confirmation" 
                                   name="password_confirmation"
                                   class="w-full px-4 py-3 pr-12 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white"
                                   required>
                            <button type="button" 
                                    id="toggleConfirmPassword"
                                    class="absolute {{ app()->getLocale() == 'ar' ? 'left-3' : 'right-3' }} top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                                <svg id="confirmEyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        {{-- Confirm Password Match Message --}}
                        <div id="confirm-password-message" class="mt-2 text-sm hidden"></div>
                    </div>
                </div>

                {{-- Error/Success Messages --}}
                <div id="passwordMessage" class="hidden mt-6"></div>

                {{-- Submit Button --}}
                <div class="mt-6">
                    <button type="submit" 
                            id="passwordButton"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                        <span id="passwordText">{{ app()->getLocale() == 'ar' ? 'تغيير كلمة المرور' : 'Change Password' }}</span>
                    </button>
                </div>
            </form>
        </div>

        {{-- Two-Factor Authentication --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl overflow-hidden mb-6">
            <div class="p-6 border-b border-slate-200 dark:border-slate-700">
                <h2 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    {{ app()->getLocale() == 'ar' ? 'المصادقة الثنائية' : 'Two-Factor Authentication' }}
                </h2>
                <p class="text-sm text-slate-600 dark:text-slate-400 mt-2">
                    {{ app()->getLocale() == 'ar' ? 'أضف طبقة إضافية من الأمان إلى حسابك' : 'Add an extra layer of security to your account' }}
                </p>
            </div>

            <div class="p-6">
                @if(!$user->google2fa_enabled)
                    {{-- 2FA Disabled State --}}
                    <div id="2fa-disabled-state">
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4 mb-4">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <div>
                                    <h3 class="font-semibold text-yellow-900 dark:text-yellow-200">
                                        {{ app()->getLocale() == 'ar' ? 'المصادقة الثنائية غير مفعلة' : 'Two-Factor Authentication is not enabled' }}
                                    </h3>
                                    <p class="text-sm text-yellow-800 dark:text-yellow-300 mt-1">
                                        {{ app()->getLocale() == 'ar' ? 'قم بتفعيل المصادقة الثنائية لحماية حسابك من الوصول غير المصرح به' : 'Enable two-factor authentication to protect your account from unauthorized access' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <button type="button" 
                                id="enable2FABtn"
                                class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <span>{{ app()->getLocale() == 'ar' ? 'تفعيل المصادقة الثنائية' : 'Enable Two-Factor Authentication' }}</span>
                        </button>
                    </div>

                    {{-- 2FA Setup Modal --}}
                    <div id="2fa-setup-modal" class="hidden mt-6">
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
                            <h3 class="font-bold text-lg text-blue-900 dark:text-blue-200 mb-4">
                                {{ app()->getLocale() == 'ar' ? 'إعداد المصادقة الثنائية' : 'Setup Two-Factor Authentication' }}
                            </h3>
                            
                            <div class="space-y-4">
                                {{-- Method Selection --}}
                                <div id="method-selection-section">
                                    <p class="text-sm text-slate-700 dark:text-slate-300 mb-4">
                                        {{ app()->getLocale() == 'ar' ? 'اختر طريقة التحقق المفضلة لديك:' : 'Choose your preferred verification method:' }}
                                    </p>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        {{-- Authenticator App Option --}}
                                        <div class="border-2 border-slate-300 dark:border-slate-600 rounded-lg p-4 cursor-pointer hover:border-blue-500 dark:hover:border-blue-400 transition-colors method-option" data-method="authenticator">
                                            <div class="flex items-start gap-3">
                                                <input type="radio" name="2fa_method" value="authenticator" id="method-authenticator" class="mt-1">
                                                <div class="flex-1">
                                                    <label for="method-authenticator" class="cursor-pointer">
                                                        <div class="flex items-center gap-2 mb-2">
                                                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                            </svg>
                                                            <h4 class="font-semibold text-slate-900 dark:text-white">
                                                                {{ app()->getLocale() == 'ar' ? 'تطبيق المصادقة' : 'Authenticator App' }}
                                                            </h4>
                                                        </div>
                                                        <p class="text-sm text-slate-600 dark:text-slate-400">
                                                            {{ app()->getLocale() == 'ar' ? 'استخدم Google Authenticator أو تطبيق مشابه' : 'Use Google Authenticator or similar app' }}
                                                        </p>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Email Option --}}
                                        <div class="border-2 border-slate-300 dark:border-slate-600 rounded-lg p-4 cursor-pointer hover:border-blue-500 dark:hover:border-blue-400 transition-colors method-option" data-method="email">
                                            <div class="flex items-start gap-3">
                                                <input type="radio" name="2fa_method" value="email" id="method-email" class="mt-1">
                                                <div class="flex-1">
                                                    <label for="method-email" class="cursor-pointer">
                                                        <div class="flex items-center gap-2 mb-2">
                                                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                            </svg>
                                                            <h4 class="font-semibold text-slate-900 dark:text-white">
                                                                {{ app()->getLocale() == 'ar' ? 'البريد الإلكتروني' : 'Email' }}
                                                            </h4>
                                                        </div>
                                                        <p class="text-sm text-slate-600 dark:text-slate-400">
                                                            {{ app()->getLocale() == 'ar' ? 'استلم رمز التحقق عبر البريد الإلكتروني' : 'Receive verification code via email' }}
                                                        </p>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex gap-3">
                                        <button type="button" 
                                                id="continueMethodSelection"
                                                disabled
                                                class="flex-1 bg-blue-600 hover:bg-blue-700 disabled:bg-slate-400 disabled:cursor-not-allowed text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                                            {{ app()->getLocale() == 'ar' ? 'متابعة' : 'Continue' }}
                                        </button>
                                        <button type="button" 
                                                id="cancelMethodSelection"
                                                class="flex-1 bg-slate-200 dark:bg-slate-700 text-slate-900 dark:text-white font-semibold py-3 px-6 rounded-lg hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors">
                                            {{ app()->getLocale() == 'ar' ? 'إلغاء' : 'Cancel' }}
                                        </button>
                                    </div>
                                </div>

                                {{-- Email Verification Step --}}
                                <div id="email-verification-section" class="hidden">
                                    <p class="text-sm text-slate-700 dark:text-slate-300 mb-3">
                                        {{ app()->getLocale() == 'ar' ? 'سيتم إرسال رمز التحقق إلى بريدك الإلكتروني للمتابعة' : 'A verification code will be sent to your email to continue' }}
                                    </p>
                                    <div class="flex gap-3">
                                        <button type="button" 
                                                id="sendEnableCode"
                                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                                            {{ app()->getLocale() == 'ar' ? 'إرسال رمز التحقق' : 'Send Verification Code' }}
                                        </button>
                                        <button type="button" 
                                                id="cancelEnableSetup"
                                                class="bg-slate-200 dark:bg-slate-700 text-slate-900 dark:text-white font-semibold py-3 px-6 rounded-lg hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors">
                                            {{ app()->getLocale() == 'ar' ? 'إلغاء' : 'Cancel' }}
                                        </button>
                                    </div>
                                    <div id="send-code-error" class="hidden text-sm text-red-600 dark:text-red-400 mt-3"></div>
                                </div>

                                {{-- Email Code Verification --}}
                                <div id="code-verification-section" class="hidden">
                                    <p class="text-sm text-slate-700 dark:text-slate-300 mb-3">
                                        {{ app()->getLocale() == 'ar' ? 'أدخل رمز التحقق المرسل إلى بريدك الإلكتروني:' : 'Enter the verification code sent to your email:' }}
                                    </p>
                                    <input type="text" 
                                           id="enableVerificationCode"
                                           maxlength="6"
                                           class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white mb-3 text-center text-2xl tracking-widest font-mono"
                                           placeholder="000000">
                                    <div id="code-verification-error" class="hidden text-sm text-red-600 dark:text-red-400 mb-3"></div>
                                    <div class="flex gap-3">
                                        <button type="button" 
                                                id="verifyEnableCode"
                                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                                            {{ app()->getLocale() == 'ar' ? 'تحقق' : 'Verify' }}
                                        </button>
                                        <button type="button" 
                                                id="cancelCodeVerification"
                                                class="flex-1 bg-slate-200 dark:bg-slate-700 text-slate-900 dark:text-white font-semibold py-3 px-6 rounded-lg hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors">
                                            {{ app()->getLocale() == 'ar' ? 'إلغاء' : 'Cancel' }}
                                        </button>
                                    </div>
                                </div>

                                {{-- Step 1: QR Code --}}
                                <div id="qr-code-section" class="hidden">
                                    <p class="text-sm text-slate-700 dark:text-slate-300 mb-3">
                                        {{ app()->getLocale() == 'ar' ? '1. امسح رمز QR باستخدام تطبيق Google Authenticator:' : '1. Scan this QR code with Google Authenticator app:' }}
                                    </p>
                                    <div class="flex justify-center bg-white p-4 rounded-lg mb-4" id="qr-code-container"></div>
                                    
                                    <p class="text-sm text-slate-700 dark:text-slate-300 mb-2">
                                        {{ app()->getLocale() == 'ar' ? 'أو أدخل هذا المفتاح يدوياً:' : 'Or enter this key manually:' }}
                                    </p>
                                    <div class="bg-slate-100 dark:bg-slate-700 p-3 rounded-lg font-mono text-sm text-center" id="secret-key"></div>
                                </div>

                                {{-- Step 2: Backup Codes --}}
                                <div id="backup-codes-section" class="hidden">
                                    <p class="text-sm text-slate-700 dark:text-slate-300 mb-3">
                                        {{ app()->getLocale() == 'ar' ? '2. احفظ هذه الرموز الاحتياطية في مكان آمن:' : '2. Save these backup codes in a safe place:' }}
                                    </p>
                                    <div class="bg-slate-100 dark:bg-slate-700 p-4 rounded-lg">
                                        <div id="backup-codes-list" class="grid grid-cols-2 gap-2 font-mono text-sm"></div>
                                    </div>
                                    <button type="button" 
                                            id="downloadBackupCodesSetup"
                                            class="mt-3 w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                        </svg>
                                        <span>{{ app()->getLocale() == 'ar' ? 'تنزيل الرموز الاحتياطية' : 'Download Backup Codes' }}</span>
                                    </button>
                                    <p class="text-xs text-orange-600 dark:text-orange-400 mt-2">
                                        {{ app()->getLocale() == 'ar' ? '⚠️ يمكن استخدام كل رمز مرة واحدة فقط' : '⚠️ Each code can only be used once' }}
                                    </p>
                                </div>

                                {{-- Step 3: Verify Code --}}
                                <div id="verify-code-section" class="hidden">
                                    <p class="text-sm text-slate-700 dark:text-slate-300 mb-3">
                                        {{ app()->getLocale() == 'ar' ? '3. أدخل الرمز المكون من 6 أرقام من التطبيق:' : '3. Enter the 6-digit code from the app:' }}
                                    </p>
                                    <input type="text" 
                                           id="verification-code"
                                           maxlength="6"
                                           pattern="[0-9]{6}"
                                           class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-slate-700 dark:text-white text-center text-2xl font-mono tracking-widest"
                                           placeholder="000000">
                                    <div id="verification-message" class="mt-2 text-sm hidden"></div>
                                </div>

                                {{-- Action Buttons --}}
                                <div class="flex gap-3 mt-4">
                                    <button type="button" 
                                            id="verify2FABtn"
                                            class="hidden bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                                        {{ app()->getLocale() == 'ar' ? 'تحقق وتفعيل' : 'Verify & Activate' }}
                                    </button>
                                    <button type="button" 
                                            id="cancel2FABtn"
                                            class="bg-slate-300 hover:bg-slate-400 dark:bg-slate-600 dark:hover:bg-slate-500 text-slate-800 dark:text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                                        {{ app()->getLocale() == 'ar' ? 'إلغاء' : 'Cancel' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- 2FA Enabled State --}}
                    <div id="2fa-enabled-state">
                        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 mb-4">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-green-900 dark:text-green-200">
                                        {{ app()->getLocale() == 'ar' ? 'المصادقة الثنائية مفعلة' : 'Two-Factor Authentication is enabled' }}
                                    </h3>
                                    <p class="text-sm text-green-800 dark:text-green-300 mt-1">
                                        {{ app()->getLocale() == 'ar' ? 'حسابك محمي بطبقة أمان إضافية' : 'Your account is protected with an extra layer of security' }}
                                    </p>
                                    <div class="mt-2 flex items-center gap-2">
                                        <span class="text-xs font-medium text-green-700 dark:text-green-300">
                                            {{ app()->getLocale() == 'ar' ? 'الطريقة:' : 'Method:' }}
                                        </span>
                                        @if($user->two_factor_method === 'email')
                                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-200 text-xs rounded-full">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                </svg>
                                                {{ app()->getLocale() == 'ar' ? 'البريد الإلكتروني' : 'Email' }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-200 text-xs rounded-full">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                </svg>
                                                {{ app()->getLocale() == 'ar' ? 'تطبيق المصادقة' : 'Authenticator App' }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            @if($user->two_factor_method !== 'email')
                                <button type="button" 
                                        id="regenerateCodesBtn"
                                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    <span>{{ app()->getLocale() == 'ar' ? 'إنشاء رموز احتياطية جديدة' : 'Regenerate Backup Codes' }}</span>
                                </button>
                            @endif
                            
                            <button type="button" 
                                    id="disable2FABtn"
                                    class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                <span>{{ app()->getLocale() == 'ar' ? 'تعطيل المصادقة الثنائية' : 'Disable 2FA' }}</span>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Connected Accounts --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl overflow-hidden mb-6">
            <div class="p-6 border-b border-slate-200 dark:border-slate-700">
                <h2 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                    </svg>
                    {{ app()->getLocale() == 'ar' ? 'ربط الحسابات' : 'Connected Accounts' }}
                </h2>
                <p class="text-slate-600 dark:text-slate-400 mt-2">
                    {{ app()->getLocale() == 'ar' ? 'قم بربط حساباتك الاجتماعية لتسجيل الدخول بسهولة وسرعة' : 'Link your social accounts for quick and easy sign-in' }}
                </p>
            </div>

            <div class="p-6 space-y-4">
                {{-- Google Account --}}
                <div class="flex items-center justify-between p-4 border-2 border-slate-200 dark:border-slate-700 rounded-xl hover:border-blue-400 dark:hover:border-blue-500 transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="currentColor"/>
                                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="currentColor"/>
                                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="currentColor"/>
                                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="currentColor"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-900 dark:text-white">Google</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400" id="google-status">
                                {{ app()->getLocale() == 'ar' ? 'غير مرتبط' : 'Not connected' }}
                            </p>
                        </div>
                    </div>
                    <div id="google-actions">
                        <a href="{{ route('auth.google') }}" 
                           id="google-connect-btn"
                           class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-600 text-white rounded-lg hover:from-blue-700 hover:to-cyan-700 transition-all duration-300 font-medium shadow-md hover:shadow-lg transform hover:-translate-y-0.5 inline-block">
                            {{ app()->getLocale() == 'ar' ? 'ربط الحساب' : 'Connect' }}
                        </a>
                        <button onclick="disconnectAccount('google')" 
                                id="google-disconnect-btn"
                                class="hidden px-6 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all duration-300 font-medium shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            {{ app()->getLocale() == 'ar' ? 'إلغاء الربط' : 'Disconnect' }}
                        </button>
                    </div>
                </div>

                {{-- GitHub Account --}}
                <div class="flex items-center justify-between p-4 border-2 border-slate-200 dark:border-slate-700 rounded-xl hover:border-slate-700 dark:hover:border-slate-500 transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-slate-700 to-slate-900 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-900 dark:text-white">GitHub</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400" id="github-status">
                                {{ app()->getLocale() == 'ar' ? 'غير مرتبط' : 'Not connected' }}
                            </p>
                        </div>
                    </div>
                    <div id="github-actions">
                        <a href="{{ route('auth.github') }}" 
                           id="github-connect-btn"
                           class="px-6 py-2.5 bg-gradient-to-r from-slate-700 to-slate-900 text-white rounded-lg hover:from-slate-800 hover:to-black transition-all duration-300 font-medium shadow-md hover:shadow-lg transform hover:-translate-y-0.5 inline-block">
                            {{ app()->getLocale() == 'ar' ? 'ربط الحساب' : 'Connect' }}
                        </a>
                        <button onclick="disconnectAccount('github')" 
                                id="github-disconnect-btn"
                                class="hidden px-6 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all duration-300 font-medium shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            {{ app()->getLocale() == 'ar' ? 'إلغاء الربط' : 'Disconnect' }}
                        </button>
                    </div>
                </div>

                {{-- LinkedIn Account --}}
                <div class="flex items-center justify-between p-4 border-2 border-slate-200 dark:border-slate-700 rounded-xl hover:border-blue-700 dark:hover:border-blue-600 transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-700 to-blue-900 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-900 dark:text-white">LinkedIn</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400" id="linkedin-status">
                                {{ app()->getLocale() == 'ar' ? 'غير مرتبط' : 'Not connected' }}
                            </p>
                        </div>
                    </div>
                    <div id="linkedin-actions">
                        <a href="{{ route('auth.linkedin') }}" 
                           id="linkedin-connect-btn"
                           class="px-6 py-2.5 bg-gradient-to-r from-blue-700 to-blue-900 text-white rounded-lg hover:from-blue-800 hover:to-blue-950 transition-all duration-300 font-medium shadow-md hover:shadow-lg transform hover:-translate-y-0.5 inline-block">
                            {{ app()->getLocale() == 'ar' ? 'ربط الحساب' : 'Connect' }}
                        </a>
                        <button onclick="disconnectAccount('linkedin')" 
                                id="linkedin-disconnect-btn"
                                class="hidden px-6 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all duration-300 font-medium shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            {{ app()->getLocale() == 'ar' ? 'إلغاء الربط' : 'Disconnect' }}
                        </button>
                    </div>
                </div>

                {{-- Info Box --}}
                <div class="flex items-start gap-3 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="text-sm text-blue-800 dark:text-blue-300">
                        <p class="font-medium mb-1">
                            {{ app()->getLocale() == 'ar' ? 'ملاحظة هامة:' : 'Important Note:' }}
                        </p>
                        <p>
                            {{ app()->getLocale() == 'ar' ? 'يمكنك ربط حساباتك الاجتماعية لاستخدامها في تسجيل الدخول فقط. يجب أن يكون البريد الإلكتروني مطابقاً للبريد المسجل في حسابك.' : 'You can link your social accounts to use them for sign-in only. The email must match your registered account email.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Disconnect Account Confirmation Modal --}}
        <div id="disconnectAccountModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 items-center justify-center p-4" style="display: none;">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full transform transition-all">
                {{-- Modal Header --}}
                <div class="flex items-center justify-between p-6 border-b border-slate-200 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white" id="disconnectModalTitle">
                            {{ app()->getLocale() == 'ar' ? 'إلغاء ربط الحساب' : 'Disconnect Account' }}
                        </h3>
                    </div>
                    <button onclick="closeDisconnectModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Modal Body --}}
                <div class="p-6">
                    <p class="text-slate-600 dark:text-slate-300 mb-4" id="disconnectModalMessage">
                        {{ app()->getLocale() == 'ar' ? 'هل أنت متأكد من إلغاء ربط حساب' : 'Are you sure you want to disconnect your' }}
                        <span id="disconnectProviderName" class="font-semibold text-slate-900 dark:text-white"></span>
                        {{ app()->getLocale() == 'ar' ? '؟' : ' account?' }}
                    </p>
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        {{ app()->getLocale() == 'ar' ? 'لن تتمكن من استخدام هذا الحساب لتسجيل الدخول بعد إلغاء الربط.' : 'You will not be able to use this account to sign in after disconnecting.' }}
                    </p>
                </div>

                {{-- Modal Footer --}}
                <div class="flex items-center justify-end gap-3 p-6 border-t border-slate-200 dark:border-gray-700 bg-slate-50 dark:bg-gray-900/50 rounded-b-2xl">
                    <button onclick="closeDisconnectModal()" 
                            class="px-6 py-2.5 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-gray-700 rounded-lg transition-all duration-200 font-medium">
                        {{ app()->getLocale() == 'ar' ? 'إلغاء' : 'Cancel' }}
                    </button>
                    <button onclick="confirmDisconnect()" 
                            class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-all duration-200 font-medium shadow-lg shadow-red-500/30">
                        {{ app()->getLocale() == 'ar' ? 'إلغاء الربط' : 'Disconnect' }}
                    </button>
                </div>
            </div>
        </div>

        {{-- Success Message Modal --}}
        <div id="disconnectSuccessModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 items-center justify-center p-4" style="display: none;">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full transform transition-all">
                {{-- Modal Header --}}
                <div class="flex items-center justify-between p-6 border-b border-slate-200 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white">
                            {{ app()->getLocale() == 'ar' ? 'تم بنجاح' : 'Success' }}
                        </h3>
                    </div>
                    <button onclick="closeSuccessModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Modal Body --}}
                <div class="p-6">
                    <p class="text-slate-600 dark:text-slate-300" id="successModalMessage">
                        {{ app()->getLocale() == 'ar' ? 'تم إلغاء ربط الحساب بنجاح' : 'Account disconnected successfully' }}
                    </p>
                </div>

                {{-- Modal Footer --}}
                <div class="flex items-center justify-end gap-3 p-6 border-t border-slate-200 dark:border-gray-700 bg-slate-50 dark:bg-gray-900/50 rounded-b-2xl">
                    <button onclick="closeSuccessModal()" 
                            class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-all duration-200 font-medium shadow-lg shadow-green-500/30">
                        {{ app()->getLocale() == 'ar' ? 'حسناً' : 'OK' }}
                    </button>
                </div>
            </div>
        </div>

        {{-- Active Sessions --}}
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">
                {{ app()->getLocale() == 'ar' ? 'الجلسات النشطة' : 'Active Sessions' }}
            </h2>
            <p class="text-gray-600 dark:text-gray-400 mb-6">
                {{ app()->getLocale() == 'ar' ? 'إدارة وتسجيل الخروج من جلساتك النشطة على الأجهزة الأخرى.' : 'Manage and log out your active sessions on other devices.' }}
            </p>

            <div class="space-y-4">
                @forelse($sessions as $session)
                    <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg {{ $session['is_current'] ? 'bg-blue-50 dark:bg-blue-900/20 border-blue-300 dark:border-blue-700' : '' }}">
                        <div class="flex items-center space-x-4 rtl:space-x-reverse flex-1">
                            <!-- Device Icon -->
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if(str_contains(strtolower($session['user_agent']), 'mobile') || str_contains(strtolower($session['user_agent']), 'android') || str_contains(strtolower($session['user_agent']), 'iphone'))
                                        <!-- Mobile Icon -->
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    @else
                                        <!-- Desktop Icon -->
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    @endif
                                </svg>
                            </div>

                            <!-- Session Info -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                        @php
                                            $userAgent = $session['user_agent'];
                                            $browser = 'Unknown Browser';
                                            $os = 'Unknown OS';
                                            
                                            // Detect Browser
                                            if (str_contains($userAgent, 'Chrome')) $browser = 'Chrome';
                                            elseif (str_contains($userAgent, 'Firefox')) $browser = 'Firefox';
                                            elseif (str_contains($userAgent, 'Safari') && !str_contains($userAgent, 'Chrome')) $browser = 'Safari';
                                            elseif (str_contains($userAgent, 'Edge')) $browser = 'Edge';
                                            elseif (str_contains($userAgent, 'Opera')) $browser = 'Opera';
                                            
                                            // Detect OS
                                            if (str_contains($userAgent, 'Windows')) $os = 'Windows';
                                            elseif (str_contains($userAgent, 'Mac')) $os = 'macOS';
                                            elseif (str_contains($userAgent, 'Linux')) $os = 'Linux';
                                            elseif (str_contains($userAgent, 'Android')) $os = 'Android';
                                            elseif (str_contains($userAgent, 'iPhone') || str_contains($userAgent, 'iPad')) $os = 'iOS';
                                        @endphp
                                        {{ $browser }} {{ app()->getLocale() == 'ar' ? 'على' : 'on' }} {{ $os }}
                                    </p>
                                    @if($session['is_current'])
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            {{ app()->getLocale() == 'ar' ? 'الجلسة الحالية' : 'Current Session' }}
                                        </span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $session['ip_address'] }} • {{ $session['last_activity']->diffForHumans() }}
                                </p>
                            </div>
                        </div>

                        <!-- Logout Button (only for other sessions) -->
                        @if(!$session['is_current'])
                            <button
                                onclick="logoutSession('{{ $session['id'] }}', this)"
                                class="flex-shrink-0 ms-4 px-3 py-1.5 text-sm font-medium text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors"
                            >
                                {{ app()->getLocale() == 'ar' ? 'تسجيل الخروج' : 'Logout' }}
                            </button>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            {{ app()->getLocale() == 'ar' ? 'لا توجد جلسات نشطة' : 'No active sessions' }}
                        </p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Logout Session Modal --}}
        <div id="logoutSessionModal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 items-center justify-center p-4">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl max-w-md w-full transform transition-all">
                <div class="p-6">
                    <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 dark:bg-red-900/30 rounded-full mb-4">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white text-center mb-2">
                        {{ app()->getLocale() == 'ar' ? 'تسجيل الخروج من الجلسة' : 'Logout Session' }}
                    </h3>
                    <p class="text-slate-600 dark:text-slate-400 text-center mb-6">
                        {{ app()->getLocale() == 'ar' ? 'هل أنت متأكد أنك تريد تسجيل الخروج من هذه الجلسة؟ سيتم إنهاء الجلسة فوراً على ذلك الجهاز.' : 'Are you sure you want to logout from this session? The session will be terminated immediately on that device.' }}
                    </p>
                    <div class="flex gap-3">
                        <button
                            onclick="cancelLogoutSession()"
                            class="flex-1 px-4 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 font-medium rounded-lg transition-colors"
                        >
                            {{ app()->getLocale() == 'ar' ? 'إلغاء' : 'Cancel' }}
                        </button>
                        <button
                            id="confirmLogoutSessionBtn"
                            class="flex-1 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors"
                        >
                            {{ app()->getLocale() == 'ar' ? 'تسجيل الخروج' : 'Logout' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Preferences --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl overflow-hidden mb-6">
            <div class="p-6 border-b border-slate-200 dark:border-slate-700">
                <h2 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ app()->getLocale() == 'ar' ? 'التفضيلات' : 'Preferences' }}
                </h2>
            </div>

            <div class="p-6 space-y-6">
                {{-- Language Preference --}}
                <div class="flex items-center justify-between pb-6 border-b border-slate-200 dark:border-slate-700">
                    <div>
                        <h3 class="font-semibold text-slate-900 dark:text-white mb-1">
                            {{ app()->getLocale() == 'ar' ? 'اللغة المفضلة' : 'Preferred Language' }}
                        </h3>
                        <p class="text-sm text-slate-600 dark:text-slate-400">
                            {{ app()->getLocale() == 'ar' ? 'اختر لغة العرض المفضلة لديك. سيتم حفظ اختيارك وتطبيقه تلقائياً عند تسجيل الدخول.' : 'Choose your preferred display language. Your choice will be saved and applied automatically when you login.' }}
                        </p>
                    </div>
                    <div class="flex gap-2">
                        <button
                            onclick="changeLanguage('en')"
                            class="language-btn px-4 py-2 rounded-lg transition-colors {{ $user->preferred_language == 'en' ? 'bg-blue-600 text-white' : 'bg-slate-200 dark:bg-slate-700 text-slate-900 dark:text-white hover:bg-slate-300 dark:hover:bg-slate-600' }}"
                            data-lang="en"
                        >
                            English
                        </button>
                        <button
                            onclick="changeLanguage('ar')"
                            class="language-btn px-4 py-2 rounded-lg transition-colors {{ $user->preferred_language == 'ar' ? 'bg-blue-600 text-white' : 'bg-slate-200 dark:bg-slate-700 text-slate-900 dark:text-white hover:bg-slate-300 dark:hover:bg-slate-600' }}"
                            data-lang="ar"
                        >
                            العربية
                        </button>
                    </div>
                </div>

                {{-- Email Notifications --}}
                <div class="flex items-center justify-between pb-6 border-b border-slate-200 dark:border-slate-700">
                    <div>
                        <h3 class="font-semibold text-slate-900 dark:text-white mb-1">
                            {{ app()->getLocale() == 'ar' ? 'إشعارات البريد الإلكتروني' : 'Email Notifications' }}
                        </h3>
                        <p class="text-sm text-slate-600 dark:text-slate-400">
                            {{ app()->getLocale() == 'ar' ? 'تلقي إشعارات عبر البريد الإلكتروني' : 'Receive notifications via email' }}
                        </p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                {{-- Notifications --}}
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold text-slate-900 dark:text-white mb-1">
                            {{ app()->getLocale() == 'ar' ? 'الإشعارات' : 'Notifications' }}
                        </h3>
                        <p class="text-sm text-slate-600 dark:text-slate-400">
                            {{ app()->getLocale() == 'ar' ? 'تلقي إشعارات داخل النظام' : 'Receive in-app notifications' }}
                        </p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-blue-600"></div>
                    </label>
                </div>
            </div>
        </div>

        {{-- Danger Zone --}}
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl overflow-hidden">
            <div class="p-6 border-b border-red-200 dark:border-red-800">
                <h2 class="text-xl font-bold text-red-700 dark:text-red-400 flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    {{ app()->getLocale() == 'ar' ? 'منطقة الخطر' : 'Danger Zone' }}
                </h2>
            </div>

            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold text-red-700 dark:text-red-400 mb-1">
                            {{ app()->getLocale() == 'ar' ? 'حذف الحساب' : 'Delete Account' }}
                        </h3>
                        <p class="text-sm text-red-600 dark:text-red-400">
                            {{ app()->getLocale() == 'ar' ? 'حذف حسابك نهائياً. هذا الإجراء لا يمكن التراجع عنه.' : 'Permanently delete your account. This action cannot be undone.' }}
                        </p>
                    </div>
                    <button type="button" 
                            class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                        {{ app()->getLocale() == 'ar' ? 'حذف الحساب' : 'Delete Account' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modals for 2FA Actions --}}
{{-- Disable 2FA Modal --}}
<div id="disable2FAModal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl max-w-md w-full p-6 animate-fade-in">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">
                    {{ app()->getLocale() == 'ar' ? 'تعطيل المصادقة الثنائية' : 'Disable Two-Factor Authentication' }}
                </h3>
            </div>
        </div>
        
        {{-- Step 1: Password --}}
        <div id="disable2FAStep1">
            <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">
                {{ app()->getLocale() == 'ar' ? 'أدخل كلمة المرور الخاصة بك لإرسال رمز التحقق' : 'Enter your password to send verification code' }}
            </p>
            <input type="password" 
                   id="disable2FAPassword"
                   class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-slate-700 dark:text-white mb-4"
                   placeholder="{{ app()->getLocale() == 'ar' ? 'كلمة المرور' : 'Password' }}">
            <div id="disable2FAPasswordError" class="hidden text-sm text-red-600 dark:text-red-400 mb-4"></div>
            <div class="flex gap-3">
                <button type="button" 
                        id="sendDisableCode"
                        class="flex-1 bg-red-600 hover:bg-red-700 text-white font-semibold py-3 rounded-lg transition-colors">
                    {{ app()->getLocale() == 'ar' ? 'إرسال الرمز' : 'Send Code' }}
                </button>
                <button type="button" 
                        onclick="closeDisable2FAModal()"
                        class="flex-1 bg-slate-200 dark:bg-slate-700 text-slate-900 dark:text-white font-semibold py-3 rounded-lg hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors">
                    {{ app()->getLocale() == 'ar' ? 'إلغاء' : 'Cancel' }}
                </button>
            </div>
        </div>

        {{-- Step 2: Email Code --}}
        <div id="disable2FAStep2" class="hidden">
            <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">
                {{ app()->getLocale() == 'ar' ? 'أدخل رمز التحقق المرسل إلى بريدك الإلكتروني' : 'Enter the verification code sent to your email' }}
            </p>
            <input type="text" 
                   id="disable2FACode"
                   maxlength="6"
                   class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-slate-700 dark:text-white mb-4 text-center text-2xl tracking-widest font-mono"
                   placeholder="000000">
            <div id="disable2FACodeError" class="hidden text-sm text-red-600 dark:text-red-400 mb-4"></div>
            <div class="flex gap-3">
                <button type="button" 
                        id="confirmDisable2FA"
                        class="flex-1 bg-red-600 hover:bg-red-700 text-white font-semibold py-3 rounded-lg transition-colors">
                    {{ app()->getLocale() == 'ar' ? 'تعطيل' : 'Disable' }}
                </button>
                <button type="button" 
                        onclick="closeDisable2FAModal()"
                        class="flex-1 bg-slate-200 dark:bg-slate-700 text-slate-900 dark:text-white font-semibold py-3 rounded-lg hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors">
                    {{ app()->getLocale() == 'ar' ? 'إلغاء' : 'Cancel' }}
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Regenerate Backup Codes Modal --}}
<div id="regenerateCodesModal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl max-w-md w-full p-6 animate-fade-in">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">
                    {{ app()->getLocale() == 'ar' ? 'إنشاء رموز احتياطية جديدة' : 'Regenerate Backup Codes' }}
                </h3>
            </div>
        </div>

        {{-- Step 1: Password --}}
        <div id="regenerateCodesStep1">
            <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">
                {{ app()->getLocale() == 'ar' ? 'أدخل كلمة المرور لإرسال رمز التحقق. الرموز القديمة لن تعمل بعد ذلك.' : 'Enter your password to send verification code. Old codes will no longer work.' }}
            </p>
            <input type="password" 
                   id="regenerateCodesPassword"
                   class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white mb-4"
                   placeholder="{{ app()->getLocale() == 'ar' ? 'كلمة المرور' : 'Password' }}">
            <div id="regenerateCodesPasswordError" class="hidden text-sm text-red-600 dark:text-red-400 mb-4"></div>
            <div class="flex gap-3">
                <button type="button" 
                        id="sendRegenerateCode"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition-colors">
                    {{ app()->getLocale() == 'ar' ? 'إرسال الرمز' : 'Send Code' }}
                </button>
                <button type="button" 
                        onclick="closeRegenerateCodesModal()"
                        class="flex-1 bg-slate-200 dark:bg-slate-700 text-slate-900 dark:text-white font-semibold py-3 rounded-lg hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors">
                    {{ app()->getLocale() == 'ar' ? 'إلغاء' : 'Cancel' }}
                </button>
            </div>
        </div>

        {{-- Step 2: Email Code --}}
        <div id="regenerateCodesStep2" class="hidden">
            <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">
                {{ app()->getLocale() == 'ar' ? 'أدخل رمز التحقق المرسل إلى بريدك الإلكتروني' : 'Enter the verification code sent to your email' }}
            </p>
            <input type="text" 
                   id="regenerateCodesCode"
                   maxlength="6"
                   class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white mb-4 text-center text-2xl tracking-widest font-mono"
                   placeholder="000000">
            <div id="regenerateCodesCodeError" class="hidden text-sm text-red-600 dark:text-red-400 mb-4"></div>
            <div class="flex gap-3">
                <button type="button" 
                        id="confirmRegenerateCodes"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition-colors">
                    {{ app()->getLocale() == 'ar' ? 'إنشاء' : 'Generate' }}
                </button>
                <button type="button" 
                        onclick="closeRegenerateCodesModal()"
                        class="flex-1 bg-slate-200 dark:bg-slate-700 text-slate-900 dark:text-white font-semibold py-3 rounded-lg hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors">
                    {{ app()->getLocale() == 'ar' ? 'إلغاء' : 'Cancel' }}
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Show Backup Codes Modal --}}
<div id="showBackupCodesModal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl max-w-md w-full p-6 animate-fade-in">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">
                    {{ app()->getLocale() == 'ar' ? 'رموزك الاحتياطية الجديدة' : 'Your New Backup Codes' }}
                </h3>
            </div>
        </div>
        <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">
            {{ app()->getLocale() == 'ar' ? 'احفظ هذه الرموز في مكان آمن. يمكن استخدام كل رمز مرة واحدة فقط.' : 'Save these codes in a safe place. Each code can only be used once.' }}
        </p>
        <div class="bg-slate-100 dark:bg-slate-700 p-4 rounded-lg mb-4">
            <div id="newBackupCodesList" class="grid grid-cols-2 gap-2 font-mono text-sm"></div>
        </div>
        <div class="flex gap-3">
            <button type="button" 
                    id="downloadBackupCodesModal"
                    class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg transition-colors flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                <span>{{ app()->getLocale() == 'ar' ? 'تنزيل' : 'Download' }}</span>
            </button>
            <button type="button" 
                    id="closeBackupCodesModal"
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition-colors">
                {{ app()->getLocale() == 'ar' ? 'حسناً، فهمت' : 'Got it' }}
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordForm = document.getElementById('passwordForm');
    const passwordButton = document.getElementById('passwordButton');
    const passwordText = document.getElementById('passwordText');
    const passwordMessage = document.getElementById('passwordMessage');
    const passwordInput = document.getElementById('password');
    const strengthBar = document.getElementById('strengthBar');
    const strengthText = document.getElementById('strengthText');
    const togglePasswordBtn = document.getElementById('togglePassword');
    const eyeIcon = document.getElementById('eyeIcon');

    // Toggle password visibility for New Password
    togglePasswordBtn.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        if (type === 'text') {
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
            `;
        } else {
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            `;
        }
    });

    // Toggle password visibility for Current Password
    const toggleCurrentPasswordBtn = document.getElementById('toggleCurrentPassword');
    const currentPasswordInput = document.getElementById('current_password');
    const currentEyeIcon = document.getElementById('currentEyeIcon');

    toggleCurrentPasswordBtn.addEventListener('click', function() {
        const type = currentPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        currentPasswordInput.setAttribute('type', type);
        
        if (type === 'text') {
            currentEyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
            `;
        } else {
            currentEyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            `;
        }
    });

    // Toggle password visibility for Confirm Password
    const toggleConfirmPasswordBtn = document.getElementById('toggleConfirmPassword');
    const confirmPasswordInput = document.getElementById('password_confirmation');
    const confirmEyeIcon = document.getElementById('confirmEyeIcon');

    toggleConfirmPasswordBtn.addEventListener('click', function() {
        const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPasswordInput.setAttribute('type', type);
        
        if (type === 'text') {
            confirmEyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
            `;
        } else {
            confirmEyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            `;
        }
    });

    // Password strength checker
    passwordInput.addEventListener('input', function() {
        const password = this.value;
        const strength = calculatePasswordStrength(password);
        
        // Update strength bar
        strengthBar.style.width = strength.percentage + '%';
        strengthBar.className = 'h-full transition-all duration-300 rounded-full ' + strength.colorClass;
        
        // Update strength text
        strengthText.textContent = strength.text;
        strengthText.className = 'text-xs font-semibold ' + strength.textColorClass;
        
        // Update requirements
        updateRequirement('req-length', password.length >= 8);
        updateRequirement('req-uppercase', /[A-Z]/.test(password));
        updateRequirement('req-lowercase', /[a-z]/.test(password));
        updateRequirement('req-number', /[0-9]/.test(password));
        updateRequirement('req-special', /[!@#$%^&*(),.?":{}|<>]/.test(password));
    });

    function calculatePasswordStrength(password) {
        let strength = 0;
        
        if (password.length === 0) {
            return {
                percentage: 0,
                text: '',
                colorClass: '',
                textColorClass: ''
            };
        }
        
        // Length check
        if (password.length >= 8) strength += 20;
        if (password.length >= 12) strength += 10;
        if (password.length >= 16) strength += 10;
        
        // Uppercase letter
        if (/[A-Z]/.test(password)) strength += 15;
        
        // Lowercase letter
        if (/[a-z]/.test(password)) strength += 15;
        
        // Numbers
        if (/[0-9]/.test(password)) strength += 15;
        
        // Special characters
        if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) strength += 15;
        
        // Determine strength level
        let level, colorClass, textColorClass, text;
        
        if (strength < 40) {
            level = 'weak';
            colorClass = 'bg-red-500';
            textColorClass = 'text-red-600 dark:text-red-400';
            text = '{{ app()->getLocale() == 'ar' ? 'ضعيفة' : 'Weak' }}';
        } else if (strength < 60) {
            level = 'fair';
            colorClass = 'bg-orange-500';
            textColorClass = 'text-orange-600 dark:text-orange-400';
            text = '{{ app()->getLocale() == 'ar' ? 'متوسطة' : 'Fair' }}';
        } else if (strength < 80) {
            level = 'good';
            colorClass = 'bg-yellow-500';
            textColorClass = 'text-yellow-600 dark:text-yellow-400';
            text = '{{ app()->getLocale() == 'ar' ? 'جيدة' : 'Good' }}';
        } else {
            level = 'strong';
            colorClass = 'bg-green-500';
            textColorClass = 'text-green-600 dark:text-green-400';
            text = '{{ app()->getLocale() == 'ar' ? 'قوية' : 'Strong' }}';
        }
        
        return {
            percentage: strength,
            colorClass: colorClass,
            textColorClass: textColorClass,
            text: text,
            level: level
        };
    }

    function updateRequirement(id, met) {
        const element = document.getElementById(id);
        if (met) {
            element.classList.remove('text-slate-500', 'dark:text-slate-400');
            element.classList.add('text-green-600', 'dark:text-green-400');
            element.querySelector('svg').innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            `;
        } else {
            element.classList.remove('text-green-600', 'dark:text-green-400');
            element.classList.add('text-slate-500', 'dark:text-slate-400');
            element.querySelector('svg').innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            `;
        }
    }

    // Current Password Validation
    const currentPasswordMessage = document.getElementById('current-password-message');
    let currentPasswordTimeout;

    currentPasswordInput.addEventListener('input', function() {
        clearTimeout(currentPasswordTimeout);
        
        const password = this.value.trim();
        
        if (password === '') {
            currentPasswordMessage.classList.add('hidden');
            currentPasswordInput.classList.remove('border-green-500', 'border-red-500');
            currentPasswordInput.classList.add('border-slate-300', 'dark:border-slate-600');
            return;
        }

        // Show loading state
        currentPasswordMessage.classList.remove('hidden', 'text-green-600', 'text-red-600', 'dark:text-green-400', 'dark:text-red-400');
        currentPasswordMessage.classList.add('text-blue-600', 'dark:text-blue-400');
        currentPasswordMessage.innerHTML = `
            <svg class="inline w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            {{ app()->getLocale() == 'ar' ? 'جاري التحقق...' : 'Checking...' }}
        `;

        currentPasswordTimeout = setTimeout(async function() {
            try {
                const response = await fetch('{{ route('settings.verify-current-password') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ current_password: password })
                });

                const data = await response.json();

                if (data.valid) {
                    // Valid password
                    currentPasswordMessage.classList.remove('text-blue-600', 'text-red-600', 'dark:text-blue-400', 'dark:text-red-400');
                    currentPasswordMessage.classList.add('text-green-600', 'dark:text-green-400');
                    currentPasswordMessage.innerHTML = `
                        <svg class="inline w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ app()->getLocale() == 'ar' ? 'كلمة المرور صحيحة' : 'Password is correct' }}
                    `;
                    currentPasswordInput.classList.remove('border-slate-300', 'border-red-500', 'dark:border-slate-600');
                    currentPasswordInput.classList.add('border-green-500');
                } else {
                    // Invalid password
                    currentPasswordMessage.classList.remove('text-blue-600', 'text-green-600', 'dark:text-blue-400', 'dark:text-green-400');
                    currentPasswordMessage.classList.add('text-red-600', 'dark:text-red-400');
                    currentPasswordMessage.innerHTML = `
                        <svg class="inline w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        {{ app()->getLocale() == 'ar' ? 'كلمة المرور غير صحيحة' : 'Password is incorrect' }}
                    `;
                    currentPasswordInput.classList.remove('border-slate-300', 'border-green-500', 'dark:border-slate-600');
                    currentPasswordInput.classList.add('border-red-500');
                }
            } catch (error) {
                console.error('Error:', error);
                currentPasswordMessage.classList.remove('text-blue-600', 'text-green-600', 'dark:text-blue-400', 'dark:text-green-400');
                currentPasswordMessage.classList.add('text-red-600', 'dark:text-red-400');
                currentPasswordMessage.innerHTML = `
                    <svg class="inline w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ app()->getLocale() == 'ar' ? 'حدث خطأ أثناء التحقق' : 'Error during verification' }}
                `;
            }
        }, 500);
    });

    // Confirm Password Match Validation
    const confirmPasswordMessage = document.getElementById('confirm-password-message');
    
    function checkPasswordMatch() {
        const newPassword = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        
        if (confirmPassword === '') {
            confirmPasswordMessage.classList.add('hidden');
            confirmPasswordInput.classList.remove('border-green-500', 'border-red-500');
            confirmPasswordInput.classList.add('border-slate-300', 'dark:border-slate-600');
            return;
        }
        
        confirmPasswordMessage.classList.remove('hidden');
        
        if (newPassword === confirmPassword) {
            // Passwords match
            confirmPasswordMessage.classList.remove('text-red-600', 'dark:text-red-400');
            confirmPasswordMessage.classList.add('text-green-600', 'dark:text-green-400');
            confirmPasswordMessage.innerHTML = `
                <svg class="inline w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ app()->getLocale() == 'ar' ? 'كلمات المرور متطابقة' : 'Passwords match' }}
            `;
            confirmPasswordInput.classList.remove('border-slate-300', 'border-red-500', 'dark:border-slate-600');
            confirmPasswordInput.classList.add('border-green-500');
        } else {
            // Passwords don't match
            confirmPasswordMessage.classList.remove('text-green-600', 'dark:text-green-400');
            confirmPasswordMessage.classList.add('text-red-600', 'dark:text-red-400');
            confirmPasswordMessage.innerHTML = `
                <svg class="inline w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                {{ app()->getLocale() == 'ar' ? 'كلمات المرور غير متطابقة' : 'Passwords do not match' }}
            `;
            confirmPasswordInput.classList.remove('border-slate-300', 'border-green-500', 'dark:border-slate-600');
            confirmPasswordInput.classList.add('border-red-500');
        }
    }
    
    // Check match when typing in confirm password field
    confirmPasswordInput.addEventListener('input', checkPasswordMatch);
    
    // Also check when typing in new password field (in case confirm is already filled)
    passwordInput.addEventListener('input', function() {
        if (confirmPasswordInput.value !== '') {
            checkPasswordMatch();
        }
    });

    // Prevent copy from Current Password field
    currentPasswordInput.addEventListener('copy', function(e) {
        e.preventDefault();
        const tempMessage = document.createElement('div');
        tempMessage.className = 'fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 animate-fade-in';
        tempMessage.textContent = '{{ app()->getLocale() == 'ar' ? 'النسخ غير مسموح' : 'Copy is not allowed' }}';
        document.body.appendChild(tempMessage);
        setTimeout(() => tempMessage.remove(), 2000);
    });

    // Prevent cut from Current Password field
    currentPasswordInput.addEventListener('cut', function(e) {
        e.preventDefault();
    });

    // Prevent paste into Current Password field
    currentPasswordInput.addEventListener('paste', function(e) {
        e.preventDefault();
        const tempMessage = document.createElement('div');
        tempMessage.className = 'fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 animate-fade-in';
        tempMessage.textContent = '{{ app()->getLocale() == 'ar' ? 'اللصق غير مسموح' : 'Paste is not allowed' }}';
        document.body.appendChild(tempMessage);
        setTimeout(() => tempMessage.remove(), 2000);
    });

    // Prevent copy from New Password field
    passwordInput.addEventListener('copy', function(e) {
        e.preventDefault();
        // Show a temporary message
        const tempMessage = document.createElement('div');
        tempMessage.className = 'fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 animate-fade-in';
        tempMessage.textContent = '{{ app()->getLocale() == 'ar' ? 'النسخ غير مسموح' : 'Copy is not allowed' }}';
        document.body.appendChild(tempMessage);
        setTimeout(() => tempMessage.remove(), 2000);
    });

    // Prevent cut from New Password field
    passwordInput.addEventListener('cut', function(e) {
        e.preventDefault();
    });

    // Prevent paste into Confirm Password field
    confirmPasswordInput.addEventListener('paste', function(e) {
        e.preventDefault();
        // Show a temporary message
        const tempMessage = document.createElement('div');
        tempMessage.className = 'fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 animate-fade-in';
        tempMessage.textContent = '{{ app()->getLocale() == 'ar' ? 'اللصق غير مسموح. يرجى كتابة كلمة المرور يدوياً' : 'Paste is not allowed. Please type the password manually' }}';
        document.body.appendChild(tempMessage);
        setTimeout(() => tempMessage.remove(), 3000);
    });

    // Prevent drag and drop into Confirm Password field
    confirmPasswordInput.addEventListener('drop', function(e) {
        e.preventDefault();
    });

    // Prevent copy from Confirm Password field
    confirmPasswordInput.addEventListener('copy', function(e) {
        e.preventDefault();
    });

    // Prevent cut from Confirm Password field
    confirmPasswordInput.addEventListener('cut', function(e) {
        e.preventDefault();
    });

    // Prevent paste into New Password field
    passwordInput.addEventListener('paste', function(e) {
        e.preventDefault();
        const tempMessage = document.createElement('div');
        tempMessage.className = 'fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 animate-fade-in';
        tempMessage.textContent = '{{ app()->getLocale() == 'ar' ? 'اللصق غير مسموح' : 'Paste is not allowed' }}';
        document.body.appendChild(tempMessage);
        setTimeout(() => tempMessage.remove(), 2000);
    });

    passwordForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        passwordButton.disabled = true;
        passwordText.textContent = '{{ app()->getLocale() == 'ar' ? 'جاري الحفظ...' : 'Saving...' }}';

        const formData = new FormData(passwordForm);

        try {
            const response = await fetch('{{ route('client.settings.update') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                },
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                showMessage(data.message, 'success', passwordMessage);
                passwordForm.reset();
            } else {
                showMessage(data.message || '{{ app()->getLocale() == 'ar' ? 'حدث خطأ' : 'An error occurred' }}', 'error', passwordMessage);
            }
        } catch (error) {
            showMessage('{{ app()->getLocale() == 'ar' ? 'حدث خطأ، الرجاء المحاولة مرة أخرى' : 'An error occurred, please try again' }}', 'error', passwordMessage);
        } finally {
            passwordButton.disabled = false;
            passwordText.textContent = '{{ app()->getLocale() == 'ar' ? 'تغيير كلمة المرور' : 'Change Password' }}';
        }
    });

    function showMessage(message, type, container) {
        const bgColor = type === 'success' ? 'bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-800' : 'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800';
        const textColor = type === 'success' ? 'text-green-700 dark:text-green-300' : 'text-red-700 dark:text-red-300';
        const iconColor = type === 'success' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400';
        
        container.className = `${bgColor} border rounded-lg p-4 mt-6`;
        container.innerHTML = `
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 ${iconColor} flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    ${type === 'success' 
                        ? '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>'
                        : '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>'
                    }
                </svg>
                <p class="text-sm ${textColor}">${message}</p>
            </div>
        `;
        container.classList.remove('hidden');
        
        if (type === 'success') {
            setTimeout(() => {
                container.classList.add('hidden');
            }, 5000);
        }
    }
});

// Load QRCode library
const script = document.createElement('script');
script.src = 'https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js';
document.head.appendChild(script);

// Two-Factor Authentication JavaScript
const enable2FABtn = document.getElementById('enable2FABtn');
const disable2FABtn = document.getElementById('disable2FABtn');
const regenerateCodesBtn = document.getElementById('regenerateCodesBtn');
const verify2FABtn = document.getElementById('verify2FABtn');
const cancel2FABtn = document.getElementById('cancel2FABtn');
const sendEnableCode = document.getElementById('sendEnableCode');
const cancelEnableSetup = document.getElementById('cancelEnableSetup');
const verifyEnableCode = document.getElementById('verifyEnableCode');
const cancelCodeVerification = document.getElementById('cancelCodeVerification');
const continueMethodSelection = document.getElementById('continueMethodSelection');
const cancelMethodSelection = document.getElementById('cancelMethodSelection');
const methodSelectionSection = document.getElementById('method-selection-section');
const emailVerificationSection = document.getElementById('email-verification-section');
const codeVerificationSection = document.getElementById('code-verification-section');
const qrCodeSection = document.getElementById('qr-code-section');

let selected2FAMethod = null;

// Method selection
document.querySelectorAll('.method-option').forEach(option => {
    option.addEventListener('click', function() {
        const method = this.dataset.method;
        const radio = this.querySelector('input[type="radio"]');
        radio.checked = true;
        selected2FAMethod = method;
        
        // Enable continue button
        continueMethodSelection.disabled = false;
        
        // Update border styling
        document.querySelectorAll('.method-option').forEach(opt => {
            opt.classList.remove('border-blue-500', 'dark:border-blue-400', 'bg-blue-50', 'dark:bg-blue-900/20');
            opt.classList.add('border-slate-300', 'dark:border-slate-600');
        });
        this.classList.remove('border-slate-300', 'dark:border-slate-600');
        this.classList.add('border-blue-500', 'dark:border-blue-400', 'bg-blue-50', 'dark:bg-blue-900/20');
    });
});

if (enable2FABtn) {
    enable2FABtn.addEventListener('click', function() {
        // Show setup modal
        document.getElementById('2fa-disabled-state').classList.add('hidden');
        document.getElementById('2fa-setup-modal').classList.remove('hidden');
        
        // Show method selection
        methodSelectionSection.classList.remove('hidden');
        emailVerificationSection.classList.add('hidden');
        codeVerificationSection.classList.add('hidden');
        qrCodeSection.classList.add('hidden');
        
        // Reset selection
        selected2FAMethod = null;
        continueMethodSelection.disabled = true;
        document.querySelectorAll('.method-option').forEach(opt => {
            opt.classList.remove('border-blue-500', 'dark:border-blue-400', 'bg-blue-50', 'dark:bg-blue-900/20');
            opt.classList.add('border-slate-300', 'dark:border-slate-600');
        });
        document.querySelectorAll('input[name="2fa_method"]').forEach(radio => radio.checked = false);
    });
}

// Cancel method selection
if (cancelMethodSelection) {
    cancelMethodSelection.addEventListener('click', function() {
        document.getElementById('2fa-disabled-state').classList.remove('hidden');
        document.getElementById('2fa-setup-modal').classList.add('hidden');
    });
}

// Continue with selected method
if (continueMethodSelection) {
    continueMethodSelection.addEventListener('click', function() {
        if (!selected2FAMethod) return;
        
        methodSelectionSection.classList.add('hidden');
        emailVerificationSection.classList.remove('hidden');
    });
}

// Cancel enable setup
if (cancelEnableSetup) {
    cancelEnableSetup.addEventListener('click', function() {
        document.getElementById('2fa-disabled-state').classList.remove('hidden');
        document.getElementById('2fa-setup-modal').classList.add('hidden');
        document.getElementById('send-code-error').classList.add('hidden');
    });
}

// Send enable code
if (sendEnableCode) {
    sendEnableCode.addEventListener('click', async function() {
        const errorDiv = document.getElementById('send-code-error');
        
        sendEnableCode.disabled = true;
        sendEnableCode.textContent = '{{ app()->getLocale() == 'ar' ? 'جاري الإرسال...' : 'Sending...' }}';

        try {
            const response = await fetch('{{ route('settings.2fa.send-enable-code') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            const data = await response.json();

            if (data.success) {
                emailVerificationSection.classList.add('hidden');
                codeVerificationSection.classList.remove('hidden');
                document.getElementById('enableVerificationCode').focus();
            } else {
                errorDiv.textContent = data.message;
                errorDiv.classList.remove('hidden');
            }
        } catch (error) {
            console.error('Error:', error);
            errorDiv.textContent = '{{ app()->getLocale() == 'ar' ? 'حدث خطأ' : 'An error occurred' }}';
            errorDiv.classList.remove('hidden');
        } finally {
            sendEnableCode.disabled = false;
            sendEnableCode.textContent = '{{ app()->getLocale() == 'ar' ? 'إرسال رمز التحقق' : 'Send Verification Code' }}';
        }
    });
}

// Cancel code verification
if (cancelCodeVerification) {
    cancelCodeVerification.addEventListener('click', function() {
        document.getElementById('2fa-disabled-state').classList.remove('hidden');
        document.getElementById('2fa-setup-modal').classList.add('hidden');
        document.getElementById('code-verification-error').classList.add('hidden');
        document.getElementById('enableVerificationCode').value = '';
    });
}

// Verify enable code and show QR
if (verifyEnableCode) {
    verifyEnableCode.addEventListener('click', async function() {
        const code = document.getElementById('enableVerificationCode').value;
        const errorDiv = document.getElementById('code-verification-error');
        
        if (!code || code.length !== 6) {
            errorDiv.textContent = '{{ app()->getLocale() == 'ar' ? 'الرجاء إدخال رمز مكون من 6 أرقام' : 'Please enter a 6-digit code' }}';
            errorDiv.classList.remove('hidden');
            return;
        }

        verifyEnableCode.disabled = true;
        verifyEnableCode.textContent = '{{ app()->getLocale() == 'ar' ? 'جاري التحقق...' : 'Verifying...' }}';

        try {
            const response = await fetch('{{ route('settings.2fa.enable') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ 
                    code: code,
                    method: selected2FAMethod || 'authenticator'
                })
            });

            const data = await response.json();

            if (data.success) {
                // If email method, just reload the page (no QR code needed)
                if (data.method === 'email') {
                    location.reload();
                    return;
                }
                
                // Hide code verification section
                codeVerificationSection.classList.add('hidden');
                
                // Show QR code with logo
                qrCodeSection.classList.remove('hidden');
                const qrContainer = document.getElementById('qr-code-container');
                qrContainer.innerHTML = ''; // Clear container
                
                // Wait for QRCode library to load
                const waitForQRCode = setInterval(() => {
                    if (typeof QRCode !== 'undefined') {
                        clearInterval(waitForQRCode);
                        
                        // Create canvas for QR code with logo
                        const canvas = document.createElement('canvas');
                        canvas.width = 250;
                        canvas.height = 250;
                        const ctx = canvas.getContext('2d');
                        
                        // Generate QR code on temporary div
                        const tempDiv = document.createElement('div');
                        const qr = new QRCode(tempDiv, {
                            text: data.qrCodeUrl,
                            width: 250,
                            height: 250,
                            colorDark: "#000000",
                            colorLight: "#ffffff",
                            correctLevel: QRCode.CorrectLevel.H
                        });
                        
                        // Wait for QR code to be generated
                        setTimeout(() => {
                            const qrImg = tempDiv.querySelector('img');
                            if (qrImg) {
                                // Draw QR code on canvas
                                ctx.drawImage(qrImg, 0, 0);
                                
                                // Load and draw logo in center
                                const logo = new Image();
                                logo.crossOrigin = 'anonymous';
                                logo.onload = function() {
                                    const logoSize = 60;
                                    const logoX = (canvas.width - logoSize) / 2;
                                    const logoY = (canvas.height - logoSize) / 2;
                                    
                                    // Draw white background circle for logo
                                    ctx.fillStyle = '#ffffff';
                                    ctx.beginPath();
                                    ctx.arc(canvas.width / 2, canvas.height / 2, logoSize / 2 + 5, 0, 2 * Math.PI);
                                    ctx.fill();
                                    
                                    // Draw logo
                                    ctx.drawImage(logo, logoX, logoY, logoSize, logoSize);
                                    
                                    // Display final QR code
                                    const finalImg = document.createElement('img');
                                    finalImg.src = canvas.toDataURL();
                                    finalImg.className = 'mx-auto border-4 border-white rounded-lg shadow-lg';
                                    finalImg.alt = 'QR Code';
                                    qrContainer.appendChild(finalImg);
                                };
                                logo.onerror = function() {
                                    // If logo fails to load, show QR without logo
                                    const finalImg = document.createElement('img');
                                    finalImg.src = canvas.toDataURL();
                                    finalImg.className = 'mx-auto border-4 border-white rounded-lg shadow-lg';
                                    finalImg.alt = 'QR Code';
                                    qrContainer.appendChild(finalImg);
                                };
                                logo.src = '{{ asset('logo/pro Gineous_white logo_blue icon.svg') }}';
                            }
                        }, 500);
                    }
                }, 100);
                
                document.getElementById('secret-key').textContent = data.secret;
                
                // Show backup codes
                document.getElementById('backup-codes-section').classList.remove('hidden');
                const backupCodesList = document.getElementById('backup-codes-list');
                backupCodesList.innerHTML = '';
                data.backupCodes.forEach(code => {
                    const div = document.createElement('div');
                    div.className = 'bg-white dark:bg-slate-600 p-2 rounded text-center';
                    div.textContent = code;
                    backupCodesList.appendChild(div);
                });
                
                // Setup download button for backup codes (during setup)
                const downloadBtnSetup = document.getElementById('downloadBackupCodesSetup');
                downloadBtnSetup.onclick = function() {
                    downloadBackupCodes(data.backupCodes);
                };
                
                // Show verification section
                document.getElementById('verify-code-section').classList.remove('hidden');
                document.getElementById('verify2FABtn').classList.remove('hidden');
            } else {
                errorDiv.textContent = data.message;
                errorDiv.classList.remove('hidden');
            }
        } catch (error) {
            console.error('Error:', error);
            errorDiv.textContent = '{{ app()->getLocale() == 'ar' ? 'حدث خطأ' : 'An error occurred' }}';
            errorDiv.classList.remove('hidden');
        } finally {
            verifyEnableCode.disabled = false;
            verifyEnableCode.textContent = '{{ app()->getLocale() == 'ar' ? 'تحقق' : 'Verify' }}';
        }
    });
}

if (verify2FABtn) {
    verify2FABtn.addEventListener('click', async function() {
        const code = document.getElementById('verification-code').value;
        const messageDiv = document.getElementById('verification-message');
        
        if (code.length !== 6) {
            messageDiv.classList.remove('hidden', 'text-green-600', 'dark:text-green-400');
            messageDiv.classList.add('text-red-600', 'dark:text-red-400');
            messageDiv.innerHTML = `
                <svg class="inline w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                {{ app()->getLocale() == 'ar' ? 'الرجاء إدخال رمز مكون من 6 أرقام' : 'Please enter a 6-digit code' }}
            `;
            return;
        }

        try {
            const response = await fetch('{{ route('settings.2fa.verify') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ code })
            });

            const data = await response.json();

            if (data.success) {
                messageDiv.classList.remove('hidden', 'text-red-600', 'dark:text-red-400');
                messageDiv.classList.add('text-green-600', 'dark:text-green-400');
                messageDiv.innerHTML = `
                    <svg class="inline w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    ${data.message}
                `;
                
                // Reload page after 2 seconds
                setTimeout(() => location.reload(), 2000);
            } else {
                messageDiv.classList.remove('hidden', 'text-green-600', 'dark:text-green-400');
                messageDiv.classList.add('text-red-600', 'dark:text-red-400');
                messageDiv.innerHTML = `
                    <svg class="inline w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    ${data.message}
                `;
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });
}

if (cancel2FABtn) {
    cancel2FABtn.addEventListener('click', function() {
        location.reload();
    });
}

// Disable 2FA Modal Logic
function closeDisable2FAModal() {
    const modal = document.getElementById('disable2FAModal');
    modal.classList.add('hidden');
    // Reset to step 1
    document.getElementById('disable2FAStep1').classList.remove('hidden');
    document.getElementById('disable2FAStep2').classList.add('hidden');
    document.getElementById('disable2FAPassword').value = '';
    document.getElementById('disable2FACode').value = '';
    document.getElementById('disable2FAPasswordError').classList.add('hidden');
    document.getElementById('disable2FACodeError').classList.add('hidden');
}

if (disable2FABtn) {
    const modal = document.getElementById('disable2FAModal');
    const passwordInput = document.getElementById('disable2FAPassword');
    const codeInput = document.getElementById('disable2FACode');
    const passwordErrorDiv = document.getElementById('disable2FAPasswordError');
    const codeErrorDiv = document.getElementById('disable2FACodeError');
    const sendCodeBtn = document.getElementById('sendDisableCode');
    const confirmBtn = document.getElementById('confirmDisable2FA');
    const step1 = document.getElementById('disable2FAStep1');
    const step2 = document.getElementById('disable2FAStep2');
    
    disable2FABtn.addEventListener('click', function() {
        modal.classList.remove('hidden');
        step1.classList.remove('hidden');
        step2.classList.add('hidden');
        passwordInput.value = '';
        codeInput.value = '';
        passwordErrorDiv.classList.add('hidden');
        codeErrorDiv.classList.add('hidden');
    });
    
    // Step 1: Send verification code
    sendCodeBtn.addEventListener('click', async function() {
        const password = passwordInput.value;
        
        if (!password) {
            passwordErrorDiv.textContent = '{{ app()->getLocale() == 'ar' ? 'الرجاء إدخال كلمة المرور' : 'Please enter your password' }}';
            passwordErrorDiv.classList.remove('hidden');
            return;
        }

        sendCodeBtn.disabled = true;
        sendCodeBtn.textContent = '{{ app()->getLocale() == 'ar' ? 'جاري الإرسال...' : 'Sending...' }}';

        try {
            const response = await fetch('{{ route('settings.2fa.send-disable-code') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ password })
            });

            const data = await response.json();

            if (data.success) {
                step1.classList.add('hidden');
                step2.classList.remove('hidden');
                codeInput.focus();
            } else {
                passwordErrorDiv.textContent = data.message;
                passwordErrorDiv.classList.remove('hidden');
            }
        } catch (error) {
            console.error('Error:', error);
            passwordErrorDiv.textContent = '{{ app()->getLocale() == 'ar' ? 'حدث خطأ' : 'An error occurred' }}';
            passwordErrorDiv.classList.remove('hidden');
        } finally {
            sendCodeBtn.disabled = false;
            sendCodeBtn.textContent = '{{ app()->getLocale() == 'ar' ? 'إرسال الرمز' : 'Send Code' }}';
        }
    });

    // Step 2: Verify code and disable 2FA
    confirmBtn.addEventListener('click', async function() {
        const code = codeInput.value;
        
        if (!code || code.length !== 6) {
            codeErrorDiv.textContent = '{{ app()->getLocale() == 'ar' ? 'الرجاء إدخال رمز مكون من 6 أرقام' : 'Please enter a 6-digit code' }}';
            codeErrorDiv.classList.remove('hidden');
            return;
        }

        confirmBtn.disabled = true;
        confirmBtn.textContent = '{{ app()->getLocale() == 'ar' ? 'جاري المعالجة...' : 'Processing...' }}';

        try {
            const response = await fetch('{{ route('settings.2fa.disable') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ code })
            });

            const data = await response.json();

            if (data.success) {
                location.reload();
            } else {
                codeErrorDiv.textContent = data.message;
                codeErrorDiv.classList.remove('hidden');
            }
        } catch (error) {
            console.error('Error:', error);
            codeErrorDiv.textContent = '{{ app()->getLocale() == 'ar' ? 'حدث خطأ' : 'An error occurred' }}';
            codeErrorDiv.classList.remove('hidden');
        } finally {
            confirmBtn.disabled = false;
            confirmBtn.textContent = '{{ app()->getLocale() == 'ar' ? 'تعطيل' : 'Disable' }}';
        }
    });
    
    // Close modal on background click
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeDisable2FAModal();
        }
    });
}

// Regenerate Backup Codes Modal Logic
function closeRegenerateCodesModal() {
    const modal = document.getElementById('regenerateCodesModal');
    modal.classList.add('hidden');
    // Reset to step 1
    document.getElementById('regenerateCodesStep1').classList.remove('hidden');
    document.getElementById('regenerateCodesStep2').classList.add('hidden');
    document.getElementById('regenerateCodesPassword').value = '';
    document.getElementById('regenerateCodesCode').value = '';
    document.getElementById('regenerateCodesPasswordError').classList.add('hidden');
    document.getElementById('regenerateCodesCodeError').classList.add('hidden');
}

if (regenerateCodesBtn) {
    const modal = document.getElementById('regenerateCodesModal');
    const passwordInput = document.getElementById('regenerateCodesPassword');
    const codeInput = document.getElementById('regenerateCodesCode');
    const passwordErrorDiv = document.getElementById('regenerateCodesPasswordError');
    const codeErrorDiv = document.getElementById('regenerateCodesCodeError');
    const sendCodeBtn = document.getElementById('sendRegenerateCode');
    const confirmBtn = document.getElementById('confirmRegenerateCodes');
    const step1 = document.getElementById('regenerateCodesStep1');
    const step2 = document.getElementById('regenerateCodesStep2');
    const showModal = document.getElementById('showBackupCodesModal');
    const closeShowModal = document.getElementById('closeBackupCodesModal');
    
    regenerateCodesBtn.addEventListener('click', function() {
        modal.classList.remove('hidden');
        step1.classList.remove('hidden');
        step2.classList.add('hidden');
        passwordInput.value = '';
        codeInput.value = '';
        passwordErrorDiv.classList.add('hidden');
        codeErrorDiv.classList.add('hidden');
    });
    
    // Step 1: Send verification code
    sendCodeBtn.addEventListener('click', async function() {
        const password = passwordInput.value;
        
        if (!password) {
            passwordErrorDiv.textContent = '{{ app()->getLocale() == 'ar' ? 'الرجاء إدخال كلمة المرور' : 'Please enter your password' }}';
            passwordErrorDiv.classList.remove('hidden');
            return;
        }

        sendCodeBtn.disabled = true;
        sendCodeBtn.textContent = '{{ app()->getLocale() == 'ar' ? 'جاري الإرسال...' : 'Sending...' }}';

        try {
            const response = await fetch('{{ route('settings.2fa.send-regenerate-code') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ password })
            });

            const data = await response.json();

            if (data.success) {
                step1.classList.add('hidden');
                step2.classList.remove('hidden');
                codeInput.focus();
            } else {
                passwordErrorDiv.textContent = data.message;
                passwordErrorDiv.classList.remove('hidden');
            }
        } catch (error) {
            console.error('Error:', error);
            passwordErrorDiv.textContent = '{{ app()->getLocale() == 'ar' ? 'حدث خطأ' : 'An error occurred' }}';
            passwordErrorDiv.classList.remove('hidden');
        } finally {
            sendCodeBtn.disabled = false;
            sendCodeBtn.textContent = '{{ app()->getLocale() == 'ar' ? 'إرسال الرمز' : 'Send Code' }}';
        }
    });

    // Step 2: Verify code and regenerate backup codes
    confirmBtn.addEventListener('click', async function() {
        const code = codeInput.value;
        
        if (!code || code.length !== 6) {
            codeErrorDiv.textContent = '{{ app()->getLocale() == 'ar' ? 'الرجاء إدخال رمز مكون من 6 أرقام' : 'Please enter a 6-digit code' }}';
            codeErrorDiv.classList.remove('hidden');
            return;
        }

        confirmBtn.disabled = true;
        confirmBtn.textContent = '{{ app()->getLocale() == 'ar' ? 'جاري الإنشاء...' : 'Generating...' }}';

        try {
            const response = await fetch('{{ route('settings.2fa.regenerate') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ code })
            });

            const data = await response.json();

            if (data.success) {
                // Hide password modal
                modal.classList.add('hidden');
                
                // Show backup codes in new modal
                const codesList = document.getElementById('newBackupCodesList');
                codesList.innerHTML = '';
                data.backupCodes.forEach(code => {
                    const div = document.createElement('div');
                    div.className = 'bg-white dark:bg-slate-600 p-2 rounded text-center';
                    div.textContent = code;
                    codesList.appendChild(div);
                });
                showModal.classList.remove('hidden');
            } else {
                codeErrorDiv.textContent = data.message;
                codeErrorDiv.classList.remove('hidden');
            }
        } catch (error) {
            console.error('Error:', error);
            codeErrorDiv.textContent = '{{ app()->getLocale() == 'ar' ? 'حدث خطأ' : 'An error occurred' }}';
            codeErrorDiv.classList.remove('hidden');
        } finally {
            confirmBtn.disabled = false;
            confirmBtn.textContent = '{{ app()->getLocale() == 'ar' ? 'إنشاء' : 'Generate' }}';
        }
    });
    
    closeShowModal.addEventListener('click', function() {
        showModal.classList.add('hidden');
    });
    
    // Close modals on background click
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeRegenerateCodesModal();
        }
    });
    
    showModal.addEventListener('click', function(e) {
        if (e.target === showModal) {
            showModal.classList.add('hidden');
        }
    });
}

// Auto-format verification code input (add spaces every 3 digits)
const verificationCodeInput = document.getElementById('verification-code');
if (verificationCodeInput) {
    verificationCodeInput.addEventListener('input', function(e) {
        // Only allow numbers
        this.value = this.value.replace(/[^0-9]/g, '');
    });
}

// Auto-format enable verification code input
const enableVerificationCodeInput = document.getElementById('enableVerificationCode');
if (enableVerificationCodeInput) {
    enableVerificationCodeInput.addEventListener('input', function(e) {
        // Only allow numbers
        this.value = this.value.replace(/[^0-9]/g, '');
    });
}

// Function to download backup codes as text file
function downloadBackupCodes(codes) {
    const date = new Date().toISOString().split('T')[0];
    const appName = '{{ config('app.name') }}';
    const content = `${appName} - Two-Factor Authentication Backup Codes\n` +
                   `Generated: ${new Date().toLocaleString()}\n` +
                   `\n` +
                   `⚠️ IMPORTANT: Keep these codes in a safe place!\n` +
                   `Each code can only be used once.\n` +
                   `\n` +
                   `Backup Codes:\n` +
                   `━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n` +
                   codes.map((code, index) => `${index + 1}. ${code}`).join('\n') +
                   `\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n`;
    
    const blob = new Blob([content], { type: 'text/plain' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `${appName.replace(/\s+/g, '_')}_2FA_Backup_Codes_${date}.txt`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
}

// Setup download button in backup codes modal
const downloadBtnModal = document.getElementById('downloadBackupCodesModal');
if (downloadBtnModal) {
    downloadBtnModal.addEventListener('click', function() {
        const codesList = document.getElementById('newBackupCodesList');
        const codes = Array.from(codesList.children).map(div => div.textContent);
        downloadBackupCodes(codes);
    });
}

// Logout Session Function
let currentSessionToLogout = null;
let currentLogoutButton = null;

function logoutSession(sessionId, buttonElement) {
    currentSessionToLogout = sessionId;
    currentLogoutButton = buttonElement;
    
    // Show modal
    const modal = document.getElementById('logoutSessionModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function cancelLogoutSession() {
    const modal = document.getElementById('logoutSessionModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    currentSessionToLogout = null;
    currentLogoutButton = null;
}

async function confirmLogoutSession() {
    if (!currentSessionToLogout || !currentLogoutButton) return;
    
    const modal = document.getElementById('logoutSessionModal');
    const confirmBtn = document.getElementById('confirmLogoutSessionBtn');
    confirmBtn.disabled = true;
    confirmBtn.textContent = '{{ app()->getLocale() == 'ar' ? 'جاري تسجيل الخروج...' : 'Logging out...' }}';

    try {
        const response = await fetch(`/settings/sessions/${currentSessionToLogout}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        const data = await response.json();

        if (data.success) {
            // Hide modal
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            
            // Show success message
            const alertDiv = document.createElement('div');
            alertDiv.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in';
            alertDiv.textContent = data.message;
            document.body.appendChild(alertDiv);

            // Remove the session from the list
            const sessionElement = currentLogoutButton.closest('.border');
            if (sessionElement) {
                sessionElement.style.opacity = '0';
                sessionElement.style.transition = 'opacity 0.3s';
                setTimeout(() => sessionElement.remove(), 300);
            }

            // Remove alert after 3 seconds
            setTimeout(() => {
                alertDiv.style.opacity = '0';
                alertDiv.style.transition = 'opacity 0.3s';
                setTimeout(() => alertDiv.remove(), 300);
            }, 3000);
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            alert(data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        alert('{{ app()->getLocale() == 'ar' ? 'حدث خطأ أثناء تسجيل الخروج' : 'An error occurred while logging out' }}');
    } finally {
        confirmBtn.disabled = false;
        confirmBtn.textContent = '{{ app()->getLocale() == 'ar' ? 'تسجيل الخروج' : 'Logout' }}';
        currentSessionToLogout = null;
        currentLogoutButton = null;
    }
}

// Setup confirm button
document.getElementById('confirmLogoutSessionBtn')?.addEventListener('click', confirmLogoutSession);

// Close modal on backdrop click
document.getElementById('logoutSessionModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        cancelLogoutSession();
    }
});

// Close modal on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('logoutSessionModal');
        if (modal && !modal.classList.contains('hidden')) {
            cancelLogoutSession();
        }
    }
});

// Language Change Function
async function changeLanguage(lang) {
    try {
        const response = await fetch('{{ route('settings.language.update') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ language: lang })
        });

        const data = await response.json();

        if (data.success) {
            // Show success message
            const alertDiv = document.createElement('div');
            alertDiv.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
            alertDiv.textContent = data.message;
            document.body.appendChild(alertDiv);

            // Reload page after 1 second to apply new language
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            alert(data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('{{ app()->getLocale() == 'ar' ? 'حدث خطأ أثناء تحديث اللغة' : 'An error occurred while updating language' }}');
    }
}

// Update Connected Accounts Status
document.addEventListener('DOMContentLoaded', function() {
    const connectedAccounts = @json($connectedAccounts ?? ['google' => false, 'github' => false, 'linkedin' => false]);
    
    // Update Google status
    if (connectedAccounts.google) {
        const googleStatus = document.getElementById('google-status');
        const googleConnectBtn = document.getElementById('google-connect-btn');
        const googleDisconnectBtn = document.getElementById('google-disconnect-btn');
        
        if (googleStatus) {
            googleStatus.textContent = '{{ app()->getLocale() == 'ar' ? 'مرتبط' : 'Connected' }}';
            googleStatus.className = 'text-sm text-green-600 dark:text-green-400 font-medium';
        }
        
        if (googleConnectBtn) {
            googleConnectBtn.classList.add('hidden');
        }
        
        if (googleDisconnectBtn) {
            googleDisconnectBtn.classList.remove('hidden');
        }
    }
    
    // Update GitHub status
    if (connectedAccounts.github) {
        const githubStatus = document.getElementById('github-status');
        const githubConnectBtn = document.getElementById('github-connect-btn');
        const githubDisconnectBtn = document.getElementById('github-disconnect-btn');
        
        if (githubStatus) {
            githubStatus.textContent = '{{ app()->getLocale() == 'ar' ? 'مرتبط' : 'Connected' }}';
            githubStatus.className = 'text-sm text-green-600 dark:text-green-400 font-medium';
        }
        
        if (githubConnectBtn) {
            githubConnectBtn.classList.add('hidden');
        }
        
        if (githubDisconnectBtn) {
            githubDisconnectBtn.classList.remove('hidden');
        }
    }
    
    // Update LinkedIn status
    if (connectedAccounts.linkedin) {
        const linkedinStatus = document.getElementById('linkedin-status');
        const linkedinConnectBtn = document.getElementById('linkedin-connect-btn');
        const linkedinDisconnectBtn = document.getElementById('linkedin-disconnect-btn');
        
        if (linkedinStatus) {
            linkedinStatus.textContent = '{{ app()->getLocale() == 'ar' ? 'مرتبط' : 'Connected' }}';
            linkedinStatus.className = 'text-sm text-green-600 dark:text-green-400 font-medium';
        }
        
        if (linkedinConnectBtn) {
            linkedinConnectBtn.classList.add('hidden');
        }
        
        if (linkedinDisconnectBtn) {
            linkedinDisconnectBtn.classList.remove('hidden');
        }
    }
});

// Global variable to store the provider being disconnected
let currentDisconnectProvider = null;

// Provider names in both languages
const providerNames = {
    google: '{{ app()->getLocale() == 'ar' ? 'جوجل' : 'Google' }}',
    github: '{{ app()->getLocale() == 'ar' ? 'جيت هب' : 'GitHub' }}',
    linkedin: '{{ app()->getLocale() == 'ar' ? 'لينكد إن' : 'LinkedIn' }}'
};

// Function to show disconnect confirmation modal
function disconnectAccount(provider) {
    currentDisconnectProvider = provider;
    
    // Update modal with provider name
    const providerNameElement = document.getElementById('disconnectProviderName');
    if (providerNameElement) {
        providerNameElement.textContent = providerNames[provider] || provider;
    }
    
    // Show modal
    const modal = document.getElementById('disconnectAccountModal');
    if (modal) {
        modal.style.display = 'flex';
        // Trigger animation
        setTimeout(() => {
            modal.querySelector('.bg-white').style.transform = 'scale(1)';
            modal.querySelector('.bg-white').style.opacity = '1';
        }, 10);
    }
}

// Function to close disconnect modal
function closeDisconnectModal() {
    const modal = document.getElementById('disconnectAccountModal');
    if (modal) {
        modal.querySelector('.bg-white').style.transform = 'scale(0.95)';
        modal.querySelector('.bg-white').style.opacity = '0';
        setTimeout(() => {
            modal.style.display = 'none';
            currentDisconnectProvider = null;
        }, 200);
    }
}

// Function to confirm disconnect and make API call
async function confirmDisconnect() {
    if (!currentDisconnectProvider) {
        return;
    }
    
    const provider = currentDisconnectProvider;
    
    // Close confirmation modal
    closeDisconnectModal();
    
    try {
        const response = await fetch(`/settings/disconnect/${provider}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Update UI
            const status = document.getElementById(`${provider}-status`);
            const connectBtn = document.getElementById(`${provider}-connect-btn`);
            const disconnectBtn = document.getElementById(`${provider}-disconnect-btn`);
            
            if (status) {
                status.textContent = '{{ app()->getLocale() == 'ar' ? 'غير مرتبط' : 'Not connected' }}';
                status.className = 'text-sm text-slate-600 dark:text-slate-400';
            }
            
            if (connectBtn) {
                connectBtn.classList.remove('hidden');
            }
            
            if (disconnectBtn) {
                disconnectBtn.classList.add('hidden');
            }
            
            // Show success modal
            showSuccessModal();
        } else {
            alert(data.message || '{{ app()->getLocale() == 'ar' ? 'حدث خطأ' : 'An error occurred' }}');
        }
    } catch (error) {
        console.error('Error disconnecting account:', error);
        alert('{{ app()->getLocale() == 'ar' ? 'حدث خطأ في الاتصال' : 'Connection error occurred' }}');
    }
}

// Function to show success modal
function showSuccessModal() {
    const modal = document.getElementById('disconnectSuccessModal');
    if (modal) {
        modal.style.display = 'flex';
        // Trigger animation
        setTimeout(() => {
            modal.querySelector('.bg-white').style.transform = 'scale(1)';
            modal.querySelector('.bg-white').style.opacity = '1';
        }, 10);
    }
}

// Function to close success modal
function closeSuccessModal() {
    const modal = document.getElementById('disconnectSuccessModal');
    if (modal) {
        modal.querySelector('.bg-white').style.transform = 'scale(0.95)';
        modal.querySelector('.bg-white').style.opacity = '0';
        setTimeout(() => {
            modal.style.display = 'none';
        }, 200);
    }
}

// Close modals when clicking outside
document.addEventListener('click', function(event) {
    const disconnectModal = document.getElementById('disconnectAccountModal');
    const successModal = document.getElementById('disconnectSuccessModal');
    
    if (disconnectModal && event.target === disconnectModal) {
        closeDisconnectModal();
    }
    
    if (successModal && event.target === successModal) {
        closeSuccessModal();
    }
});
</script>
@endsection
