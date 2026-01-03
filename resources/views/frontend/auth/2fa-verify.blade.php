@extends('frontend.layout')

@section('title', app()->getLocale() == 'ar' ? 'التحقق بخطوتين' : 'Two-Factor Verification')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        {{-- Logo --}}
        <div class="text-center mb-8">
            <a href="{{ route('home') }}">
                <img src="{{ asset('logo/pro Gineous_white logo_blue icon.svg') }}" alt="Logo" class="h-16 mx-auto">
            </a>
            <h2 class="mt-6 text-3xl font-extrabold text-slate-900 dark:text-white">
                {{ app()->getLocale() == 'ar' ? 'التحقق بخطوتين' : 'Two-Factor Verification' }}
            </h2>
            <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                @if(session('2fa_method') === 'email')
                    {{ app()->getLocale() == 'ar' ? 'تم إرسال رمز التحقق إلى بريدك الإلكتروني' : 'A verification code has been sent to your email' }}
                @else
                    {{ app()->getLocale() == 'ar' ? 'أدخل الرمز من تطبيق المصادقة' : 'Enter the code from your authenticator app' }}
                @endif
            </p>
        </div>

        {{-- Verification Form --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl p-8">
            <form method="POST" action="{{ route('2fa.verify.post') }}">
                @csrf

                {{-- Code Input --}}
                <div class="mb-6">
                    <label for="code" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ app()->getLocale() == 'ar' ? 'رمز التحقق' : 'Verification Code' }}
                    </label>
                    <input type="text" 
                           id="code"
                           name="code"
                           maxlength="6"
                           required
                           autofocus
                           class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white text-center text-2xl tracking-widest font-mono @error('code') border-red-500 @enderror"
                           placeholder="000000">
                    
                    @error('code')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    {{ app()->getLocale() == 'ar' ? 'تحقق' : 'Verify' }}
                </button>

                {{-- Back to Login --}}
                <div class="mt-4 text-center">
                    <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                        {{ app()->getLocale() == 'ar' ? 'العودة لتسجيل الدخول' : 'Back to Login' }}
                    </a>
                </div>
            </form>

            @if(session('2fa_method') === 'email')
                {{-- Resend Code Option --}}
                <div class="mt-6 pt-6 border-t border-slate-200 dark:border-slate-700 text-center">
                    <p class="text-sm text-slate-600 dark:text-slate-400">
                        {{ app()->getLocale() == 'ar' ? 'لم تستلم الرمز؟' : 'Didn\'t receive the code?' }}
                    </p>
                    <form method="POST" action="{{ route('login.post') }}" class="mt-2">
                        @csrf
                        <button type="submit" class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                            {{ app()->getLocale() == 'ar' ? 'إعادة إرسال الرمز' : 'Resend Code' }}
                        </button>
                    </form>
                </div>
            @endif
        </div>

        {{-- Security Notice --}}
        <div class="mt-6 text-center">
            <p class="text-xs text-slate-500 dark:text-slate-400">
                {{ app()->getLocale() == 'ar' ? 'حسابك محمي بالمصادقة الثنائية' : 'Your account is protected with two-factor authentication' }}
            </p>
        </div>
    </div>
</div>

<script>
// Auto-submit when 6 digits entered
document.getElementById('code').addEventListener('input', function(e) {
    if (this.value.length === 6) {
        // Optional: auto-submit form
        // this.form.submit();
    }
});

// Only allow numbers
document.getElementById('code').addEventListener('keypress', function(e) {
    if (!/[0-9]/.test(e.key)) {
        e.preventDefault();
    }
});
</script>
@endsection
