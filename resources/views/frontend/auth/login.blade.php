@extends('frontend.layout')

@section('title', __('frontend.login'))

@push('scripts')
<!-- Cloudflare Turnstile -->
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
<!-- Login Scripts -->
<script src="{{ asset('js/login.js') }}" defer></script>
@endpush

@section('content')
<div class="min-h-screen flex items-center justify-center py-8 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Animated Background -->
    <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-white to-cyan-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">
        <!-- Animated Circles -->
        <div class="absolute top-0 left-0 w-72 h-72 bg-blue-200 dark:bg-blue-900 rounded-full mix-blend-multiply dark:mix-blend-soft-light filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute top-0 right-0 w-72 h-72 bg-cyan-200 dark:bg-cyan-900 rounded-full mix-blend-multiply dark:mix-blend-soft-light filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-0 left-1/2 w-72 h-72 bg-sky-200 dark:bg-sky-900 rounded-full mix-blend-multiply dark:mix-blend-soft-light filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
    </div>

    <div class="max-w-md w-full space-y-6 relative z-10">
        <!-- Logo & Title -->
        <div class="text-center">
            <h2 class="text-4xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-cyan-600 dark:from-blue-400 dark:to-cyan-400 mb-3">
                {{ __('frontend.login') }}
            </h2>
            <p class="text-slate-600 dark:text-slate-400 text-lg">
                {{ __('frontend.welcome_back') }}
            </p>
        </div>

        <!-- Login Form -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/20 dark:border-slate-700/50 p-8 md:p-10">
            <!-- Session Error Messages (Google OAuth errors) -->
            @if (session('error'))
                <div class="mb-6 animate-shake">
                    <div class="group relative overflow-hidden bg-white dark:bg-slate-800/50 backdrop-blur-sm rounded-2xl border border-red-200/50 dark:border-red-800/30 shadow-sm hover:shadow-md transition-all duration-300">
                        <div class="absolute inset-0 bg-gradient-to-r from-red-50/50 to-transparent dark:from-red-900/10 dark:to-transparent"></div>
                        <div class="relative p-4 flex items-start gap-3">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Session Success Messages -->
            @if (session('success'))
                <div class="mb-6 animate-slideDown">
                    <div class="group relative overflow-hidden bg-white dark:bg-slate-800/50 backdrop-blur-sm rounded-2xl border border-green-200/50 dark:border-green-800/30 shadow-sm hover:shadow-md transition-all duration-300">
                        <div class="absolute inset-0 bg-gradient-to-r from-green-50/50 to-transparent dark:from-green-900/10 dark:to-transparent"></div>
                        <div class="relative p-4 flex items-start gap-3">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
                @php
                    $errorMessage = $errors->first('email');
                    preg_match('/(\d+)/', $errorMessage, $matches);
                    $remainingAttempts = $matches[0] ?? null;
                    
                    // Determine color based on remaining attempts
                    $attemptColor = 'blue';
                    if ($remainingAttempts) {
                        if ($remainingAttempts <= 1) {
                            $attemptColor = 'red';
                        } elseif ($remainingAttempts <= 2) {
                            $attemptColor = 'orange';
                        } elseif ($remainingAttempts <= 3) {
                            $attemptColor = 'yellow';
                        }
                    }
                @endphp
                
                <div class="mb-6 space-y-3 animate-shake">
                    <!-- Error Message Card -->
                    <div class="group relative overflow-hidden bg-white dark:bg-slate-800/50 backdrop-blur-sm rounded-2xl border border-red-200/50 dark:border-red-800/30 shadow-sm hover:shadow-md transition-all duration-300">
                        <div class="absolute inset-0 bg-gradient-to-r from-red-50/50 to-transparent dark:from-red-900/10 dark:to-transparent"></div>
                        <div class="relative p-4 flex items-start gap-3">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                @foreach ($errors->all() as $error)
                                    @php
                                        // Split error message to separate main text from attempts
                                        $parts = explode('.', $error);
                                        $mainError = $parts[0] . '.';
                                        $attemptsInfo = isset($parts[1]) ? trim($parts[1]) : '';
                                        // Remove attempts info from error if it exists
                                        if (preg_match('/(محاولات متبقية|Remaining attempts)/', $attemptsInfo)) {
                                            $mainError = $parts[0] . '.';
                                        } else {
                                            $mainError = $error;
                                        }
                                    @endphp
                                    <p class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $mainError }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <!-- Login Attempts Counter (Minimal Design) -->
                    @if($remainingAttempts && $remainingAttempts > 0 && $remainingAttempts < 5)
                        <div class="relative overflow-hidden bg-white dark:bg-slate-800/50 backdrop-blur-sm rounded-2xl border border-slate-200/50 dark:border-slate-700/30 shadow-sm">
                            <div class="p-4">
                                <!-- Header -->
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 rounded-full {{ $remainingAttempts <= 1 ? 'bg-red-500 animate-pulse' : ($remainingAttempts <= 2 ? 'bg-orange-500' : 'bg-blue-500') }}"></div>
                                        <span class="text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide">
                                            {{ app()->getLocale() == 'ar' ? 'محاولات متبقية' : 'Attempts Left' }}
                                        </span>
                                    </div>
                                    <span class="text-lg font-bold {{ $remainingAttempts <= 1 ? 'text-red-600 dark:text-red-400' : ($remainingAttempts <= 2 ? 'text-orange-600 dark:text-orange-400' : 'text-blue-600 dark:text-blue-400') }}">
                                        {{ $remainingAttempts }}
                                    </span>
                                </div>
                                
                                <!-- Dots Indicator (Minimal) -->
                                <div class="flex items-center gap-2 mb-3">
                                    @for($i = 1; $i <= 5; $i++)
                                        <div class="flex-1 h-1.5 rounded-full transition-all duration-300 {{ $i <= $remainingAttempts ? 'bg-gradient-to-r ' . ($remainingAttempts <= 1 ? 'from-red-500 to-red-600' : ($remainingAttempts <= 2 ? 'from-orange-500 to-orange-600' : 'from-blue-500 to-blue-600')) : 'bg-slate-200 dark:bg-slate-700' }}"></div>
                                    @endfor
                                </div>
                                
                                <!-- Warning Message (Minimal) -->
                                @if($remainingAttempts <= 2)
                                    <div class="flex items-start gap-2 p-3 bg-gradient-to-r {{ $remainingAttempts == 1 ? 'from-red-50 to-red-50/50 dark:from-red-900/20 dark:to-red-900/10' : 'from-orange-50 to-orange-50/50 dark:from-orange-900/20 dark:to-orange-900/10' }} rounded-xl border {{ $remainingAttempts == 1 ? 'border-red-200/50 dark:border-red-800/30' : 'border-orange-200/50 dark:border-orange-800/30' }}">
                                        <svg class="w-4 h-4 {{ $remainingAttempts == 1 ? 'text-red-600 dark:text-red-400' : 'text-orange-600 dark:text-orange-400' }} flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                        </svg>
                                        <p class="text-xs {{ $remainingAttempts == 1 ? 'text-red-700 dark:text-red-300' : 'text-orange-700 dark:text-orange-300' }} leading-relaxed">
                                            @if($remainingAttempts == 1)
                                                {{ app()->getLocale() == 'ar' ? 'محاولة أخيرة! سيتم حظر الحساب لمدة 15 دقيقة بعد ذلك.' : 'Last attempt! Account will be blocked for 15 minutes after this.' }}
                                            @else
                                                {{ app()->getLocale() == 'ar' ? 'يرجى التأكد من بيانات تسجيل الدخول.' : 'Please verify your login credentials.' }}
                                            @endif
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
                @csrf

                <!-- Email or Username -->
                <div class="relative group">
                    <label for="email" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2 {{ app()->getLocale() == 'ar' ? 'mr-1' : 'ml-1' }}">
                        {{ app()->getLocale() == 'ar' ? 'البريد الإلكتروني أو اسم المستخدم' : 'Email or Username' }}
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'right-0 pr-3' : 'left-0 pl-3' }} flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <input type="text" id="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full {{ app()->getLocale() == 'ar' ? 'pr-10 pl-4' : 'pl-10 pr-4' }} py-3.5 rounded-xl border-2 border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-4 focus:ring-blue-500/20 transition-all duration-200"
                            placeholder="{{ app()->getLocale() == 'ar' ? 'your@email.com أو username' : 'your@email.com or username' }}">
                    </div>
                </div>

                <!-- Password -->
                <div class="relative group">
                    <label for="password" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2 {{ app()->getLocale() == 'ar' ? 'mr-1' : 'ml-1' }}">
                        {{ __('frontend.password') }}
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'right-0 pr-3' : 'left-0 pl-3' }} flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input type="password" id="password" name="password" required
                            class="w-full {{ app()->getLocale() == 'ar' ? 'pr-10 pl-12' : 'pl-10 pr-12' }} py-3.5 rounded-xl border-2 border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-4 focus:ring-blue-500/20 transition-all duration-200"
                            placeholder="••••••••">
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-0 pl-3' : 'right-0 pr-3' }} flex items-center text-slate-400 hover:text-blue-500 transition-colors">
                            <svg id="eye-open" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg id="eye-closed" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between pt-2">
                    <label class="flex items-center cursor-pointer group">
                        <div class="relative">
                            <input type="checkbox" name="remember" class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 dark:bg-slate-600 rounded-full peer peer-checked:bg-gradient-to-r peer-checked:from-blue-600 peer-checked:to-cyan-600 transition-all duration-200"></div>
                            <div class="absolute top-1 w-4 h-4 bg-white rounded-full shadow-sm transition-all duration-200 
                                {{ app()->getLocale() == 'ar' ? 'right-1 peer-checked:right-[26px]' : 'left-1 peer-checked:left-[26px]' }}"></div>
                        </div>
                        <span class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} text-sm font-medium text-slate-600 dark:text-slate-400 group-hover:text-slate-900 dark:group-hover:text-slate-200 transition-colors">{{ __('frontend.remember_me') }}</span>
                    </label>
                    <a href="#" class="text-sm font-semibold text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors relative group">
                        {{ __('frontend.forgot_password') }}
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 dark:bg-blue-400 group-hover:w-full transition-all duration-300"></span>
                    </a>
                </div>

                <!-- Cloudflare Turnstile -->
                <div class="flex justify-center">
                    <div class="cf-turnstile" 
                         data-sitekey="{{ config('services.turnstile.site_key', '1x00000000000000000000AA') }}" 
                         data-theme="{{ Cookie::get('theme', 'light') == 'dark' ? 'dark' : 'light' }}"
                         data-language="{{ app()->getLocale() }}"
                         data-callback="onTurnstileSuccess"
                         data-error-callback="onTurnstileError">
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="submit-btn" disabled class="group relative w-full px-6 py-4 bg-gradient-to-r from-blue-600 via-blue-500 to-cyan-600 hover:from-blue-700 hover:via-blue-600 hover:to-cyan-700 text-white font-bold text-lg rounded-xl shadow-2xl shadow-blue-500/40 hover:shadow-blue-500/60 transition-all duration-300 transform hover:-translate-y-1 hover:scale-[1.02] active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none overflow-hidden">
                    <!-- Normal State -->
                    <span id="btn-text" class="relative z-10 flex items-center justify-center gap-2">
                        {{ __('frontend.login') }}
                        <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </span>
                    
                    <!-- Loading State (Hidden by default) -->
                    <span id="btn-loading" class="hidden relative z-10 flex items-center justify-center gap-3">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>{{ app()->getLocale() == 'ar' ? 'جاري تسجيل الدخول...' : 'Logging in...' }}</span>
                    </span>
                    
                    <div class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                </button>

                <!-- Register Link -->
                <div class="text-center pt-4">
                    <p class="text-slate-600 dark:text-slate-400">
                        {{ __('frontend.dont_have_account') }}
                        <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors relative group">
                            {{ __('frontend.register_now') }}
                            <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600 dark:bg-blue-400 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Social Login (Optional) -->
        <div class="space-y-6">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t-2 border-slate-300 dark:border-slate-700"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-6 py-2 bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm text-slate-500 dark:text-slate-400 font-medium rounded-full border-2 border-slate-300 dark:border-slate-700">
                        {{ __('frontend.or_continue_with') }}
                    </span>
                </div>
            </div>

            <!-- Social Login Buttons -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <!-- Google Login -->
                <a href="{{ route('auth.google') }}" class="group relative px-4 py-3.5 bg-white dark:bg-slate-800 border-2 border-slate-300 dark:border-slate-600 rounded-xl hover:border-blue-500 dark:hover:border-blue-400 hover:shadow-lg hover:shadow-blue-500/20 transition-all duration-300 transform hover:-translate-y-0.5 overflow-hidden block">
                    <div class="relative z-10 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                        </svg>
                        <span class="text-sm font-semibold text-slate-700 dark:text-slate-300 group-hover:text-slate-900 dark:group-hover:text-white">Google</span>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-500/5 to-cyan-500/5 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div>
                </a>

                <!-- GitHub Login -->
                <a href="{{ route('auth.github') }}" class="group relative px-4 py-3.5 bg-white dark:bg-slate-800 border-2 border-slate-300 dark:border-slate-600 rounded-xl hover:border-slate-700 dark:hover:border-slate-500 hover:shadow-lg hover:shadow-slate-500/20 transition-all duration-300 transform hover:-translate-y-0.5 overflow-hidden block">
                    <div class="relative z-10 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5 text-slate-700 dark:text-slate-300 group-hover:text-slate-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                        </svg>
                        <span class="text-sm font-semibold text-slate-700 dark:text-slate-300 group-hover:text-slate-900 dark:group-hover:text-white">GitHub</span>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-r from-slate-500/5 to-slate-700/5 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div>
                </a>

                <!-- LinkedIn Login -->
                <a href="{{ route('auth.linkedin') }}" class="group relative px-4 py-3.5 bg-white dark:bg-slate-800 border-2 border-slate-300 dark:border-slate-600 rounded-xl hover:border-blue-700 dark:hover:border-blue-600 hover:shadow-lg hover:shadow-blue-700/20 transition-all duration-300 transform hover:-translate-y-0.5 overflow-hidden block">
                    <div class="relative z-10 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5 text-blue-700 dark:text-blue-600 group-hover:text-blue-800 dark:group-hover:text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                        <span class="text-sm font-semibold text-slate-700 dark:text-slate-300 group-hover:text-slate-900 dark:group-hover:text-white">LinkedIn</span>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-700/5 to-blue-900/5 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div>
                </a>
            </div>
        </div>

        <!-- Security Badge -->
        <div class="flex items-center justify-center gap-2 text-sm text-slate-500 dark:text-slate-400 pb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            <span>Secured by SSL Encryption</span>
        </div>
    </div>
</div>

<!-- Animation Styles -->
<style>
@keyframes blob {
    0% {
        transform: translate(0px, 0px) scale(1);
    }
    33% {
        transform: translate(30px, -50px) scale(1.1);
    }
    66% {
        transform: translate(-20px, 20px) scale(0.9);
    }
    100% {
        transform: translate(0px, 0px) scale(1);
    }
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}

@keyframes shake {
    0%, 100% {
        transform: translateX(0);
    }
    10%, 30%, 50%, 70%, 90% {
        transform: translateX(-5px);
    }
    20%, 40%, 60%, 80% {
        transform: translateX(5px);
    }
}

.animate-shake {
    animation: shake 0.5s ease-in-out;
}

@keyframes bounce {
    0%, 100% {
        transform: translateY(0) scale(1);
    }
    25% {
        transform: translateY(-15px) scale(1.05);
    }
    50% {
        transform: translateY(-8px) scale(1.02);
    }
    75% {
        transform: translateY(-12px) scale(1.03);
    }
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: transparent;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(to bottom, #2563eb, #0891b2);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(to bottom, #1d4ed8, #0e7490);
}
</style>
@endsection
