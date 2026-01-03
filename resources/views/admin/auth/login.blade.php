<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@lang('CRM Admin Portal') - Progineous</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: {{ app()->getLocale() == 'ar' ? "'Cairo', sans-serif" : "'Inter', sans-serif" }};
        }
        
        .login-bg {
            background: linear-gradient(135deg, #1e293b 0%, #334155 25%, #475569 50%, #64748b 75%, #94a3b8 100%);
            background-size: 300% 300%;
            animation: gradientMove 20s ease infinite;
            position: relative;
            overflow: hidden;
        }
        
        .login-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='m36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E") repeat;
            pointer-events: none;
        }
        
        @keyframes gradientMove {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        .glass-container {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            max-height: calc(100vh - 1.5rem);
            overflow-y: auto;
        }
        
        @media (min-width: 640px) {
            .glass-container {
                border-radius: 16px;
                max-height: calc(100vh - 2rem);
            }
        }
        
        @media (min-width: 768px) {
            .glass-container {
                border-radius: 20px;
                max-height: none;
                overflow-y: visible;
            }
        }
        
        @media (min-width: 1024px) {
            .glass-container {
                border-radius: 24px;
            }
        }
        
        @media (min-width: 1280px) {
            .glass-container {
                border-radius: 28px;
            }
        }
        
        .input-field {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 12px;
        }
        
        @media (min-width: 640px) {
            .input-field {
                font-size: 14px;
            }
        }
        
        @media (min-width: 768px) {
            .input-field {
                font-size: 15px;
            }
        }
        
        @media (min-width: 1024px) {
            .input-field {
                font-size: 16px;
            }
        }
        
        .input-field:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(59, 130, 246, 0.5);
            box-shadow: 
                0 0 0 3px rgba(59, 130, 246, 0.1),
                0 8px 25px rgba(0, 0, 0, 0.1);
            transform: translateY(-1px);
        }
        
        @media (min-width: 768px) {
            .input-field:focus {
                box-shadow: 
                    0 0 0 4px rgba(59, 130, 246, 0.1),
                    0 10px 30px rgba(0, 0, 0, 0.1);
                transform: translateY(-2px);
            }
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            border: 2px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 
                0 15px 35px rgba(59, 130, 246, 0.25),
                0 0 0 2px rgba(255, 255, 255, 0.1);
        }
        
        @media (min-width: 768px) {
            .btn-primary:hover {
                transform: translateY(-3px);
                box-shadow: 
                    0 20px 40px rgba(59, 130, 246, 0.3),
                    0 0 0 2px rgba(255, 255, 255, 0.1);
            }
        }
        
        @media (min-width: 1024px) {
            .btn-primary:hover {
                transform: translateY(-4px);
                box-shadow: 
                    0 25px 50px rgba(59, 130, 246, 0.35),
                    0 0 0 2px rgba(255, 255, 255, 0.1);
            }
        }
        
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s;
        }
        
        .btn-primary:hover::before {
            left: 100%;
        }
        
        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
            display: none;
        }
        
        @media (min-width: 768px) {
            .floating-elements {
                display: block;
            }
        }
        
        .floating-circle {
            position: absolute;
            background: linear-gradient(45deg, rgba(59, 130, 246, 0.1), rgba(139, 92, 246, 0.1));
            border-radius: 50%;
            animation: floatAnimation 15s infinite linear;
        }
        
        .floating-circle:nth-child(1) {
            width: 60px;
            height: 60px;
            top: 10%;
            left: 5%;
            animation-delay: 0s;
            animation-duration: 20s;
        }
        
        .floating-circle:nth-child(2) {
            width: 90px;
            height: 90px;
            top: 70%;
            right: 10%;
            animation-delay: 5s;
            animation-duration: 25s;
        }
        
        .floating-circle:nth-child(3) {
            width: 50px;
            height: 50px;
            bottom: 20%;
            left: 15%;
            animation-delay: 10s;
            animation-duration: 18s;
        }
        
        .floating-circle:nth-child(4) {
            width: 70px;
            height: 70px;
            top: 30%;
            right: 20%;
            animation-delay: 15s;
            animation-duration: 22s;
        }
        
        @media (min-width: 1024px) {
            .floating-circle:nth-child(1) {
                width: 100px;
                height: 100px;
            }
            
            .floating-circle:nth-child(2) {
                width: 150px;
                height: 150px;
            }
            
            .floating-circle:nth-child(3) {
                width: 80px;
                height: 80px;
            }
            
            .floating-circle:nth-child(4) {
                width: 120px;
                height: 120px;
            }
        }
        
        @keyframes floatAnimation {
            0%, 100% { 
                transform: translateY(0px) translateX(0px) rotate(0deg);
                opacity: 0.3;
            }
            25% { 
                transform: translateY(-50px) translateX(30px) rotate(90deg);
                opacity: 0.6;
            }
            50% { 
                transform: translateY(-20px) translateX(-20px) rotate(180deg);
                opacity: 0.4;
            }
            75% { 
                transform: translateY(-80px) translateX(10px) rotate(270deg);
                opacity: 0.7;
            }
        }
        
        .logo-glow {
            filter: drop-shadow(0 0 20px rgba(59, 130, 246, 0.3));
            animation: logoGlow 3s ease-in-out infinite alternate;
        }
        
        @keyframes logoGlow {
            from { filter: drop-shadow(0 0 20px rgba(59, 130, 246, 0.3)); }
            to { filter: drop-shadow(0 0 30px rgba(59, 130, 246, 0.6)); }
        }
        
        .language-toggle {
            position: fixed;
            top: 8px;
            {{ app()->getLocale() == 'ar' ? 'left: 8px' : 'right: 8px' }};
            z-index: 1000;
        }
        
        @media (min-width: 640px) {
            .language-toggle {
                top: 12px;
                {{ app()->getLocale() == 'ar' ? 'left: 12px' : 'right: 12px' }};
            }
        }
        
        @media (min-width: 768px) {
            .language-toggle {
                top: 16px;
                {{ app()->getLocale() == 'ar' ? 'left: 16px' : 'right: 16px' }};
            }
        }
        
        @media (min-width: 1024px) {
            .language-toggle {
                top: 20px;
                {{ app()->getLocale() == 'ar' ? 'left: 20px' : 'right: 20px' }};
            }
        }
        
        @media (min-width: 1280px) {
            .language-toggle {
                top: 24px;
                {{ app()->getLocale() == 'ar' ? 'left: 24px' : 'right: 24px' }};
            }
        }
        
        .slide-in {
            animation: slideInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="login-bg min-h-screen flex items-center justify-center p-2 sm:p-3 md:p-4 lg:p-6">
    <!-- Language Toggle -->
    <div class="language-toggle">
        <div class="flex items-center space-x-1 sm:space-x-1.5 md:space-x-2">
            <a href="{{ route('language.switch', 'ar') }}" 
               class="px-1.5 py-0.5 sm:px-2 sm:py-1 md:px-3 md:py-2 rounded-md md:rounded-lg text-[10px] sm:text-xs md:text-sm lg:text-base font-medium transition-all duration-300 {{ app()->getLocale() == 'ar' ? 'bg-white/20 text-white' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                العربية
            </a>
            <a href="{{ route('language.switch', 'en') }}" 
               class="px-1.5 py-0.5 sm:px-2 sm:py-1 md:px-3 md:py-2 rounded-md md:rounded-lg text-[10px] sm:text-xs md:text-sm lg:text-base font-medium transition-all duration-300 {{ app()->getLocale() == 'en' ? 'bg-white/20 text-white' : 'text-white/70 hover:text-white hover:bg-white/10' }}">
                English
            </a>
        </div>
    </div>

    <!-- Floating Background Elements -->
    <div class="floating-elements">
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
    </div>
    
    <!-- Main Login Container -->
    <div class="glass-container p-3 sm:p-5 md:p-6 lg:p-8 xl:p-10 w-[90%] sm:w-[80%] md:w-[70%] lg:w-[60%] xl:w-[50%] 2xl:w-[45%] max-w-2xl mx-auto slide-in">
        <!-- Logo and Branding -->
        <div class="text-center mb-2 sm:mb-3 md:mb-4 lg:mb-5 xl:mb-6">
            <div class="logo-glow inline-block mb-1.5 sm:mb-2 md:mb-3 lg:mb-4 xl:mb-5">
                <img src="{{ asset('logo/pro Gineous_white logo.svg') }}" 
                     alt="Pro Gineous" 
                     class="h-10 sm:h-12 md:h-14 lg:h-16 xl:h-20 w-auto object-contain mx-auto">
            </div>
            <h1 class="text-base sm:text-lg md:text-xl lg:text-2xl xl:text-3xl font-bold text-white mb-1 sm:mb-1.5 md:mb-2">
                {{ __('crm.crm_admin_portal') }}
            </h1>
            <p class="text-white/80 text-xs sm:text-sm md:text-base lg:text-lg">
                {{ __('crm.advanced_crm') }}
            </p>
            <div class="mt-1.5 sm:mt-2 md:mt-2.5 lg:mt-3 xl:mt-3.5 text-white/60 text-[9px] sm:text-[10px] md:text-xs lg:text-sm">
                <span class="inline-flex items-center px-1.5 sm:px-2 md:px-2.5 lg:px-3 xl:px-3.5 py-0.5 sm:py-0.5 md:py-1 lg:py-1.5 rounded-full bg-white/10 backdrop-blur-sm">
                    <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-green-400 rounded-full {{ app()->getLocale() == 'ar' ? 'ml-1 sm:ml-1.5' : 'mr-1 sm:mr-1.5' }} animate-pulse"></span>
                    <span class="hidden sm:inline">Progineous Hosting v3.0</span>
                    <span class="sm:hidden">v3.0</span>
                </span>
            </div>
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-2 sm:space-y-3 md:space-y-4 lg:space-y-5" id="loginForm" style="opacity: 0.5; pointer-events: none;">
            @csrf
            
            <!-- Email Field -->
            <div class="space-y-1 sm:space-y-1.5 md:space-y-2">
                <label for="email" class="block text-[10px] sm:text-xs md:text-sm lg:text-base font-semibold text-white/90">
                    {{ __('crm.email_address') }}
                </label>
                <div class="relative">
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           disabled
                           class="input-field w-full px-2.5 sm:px-3 md:px-4 lg:px-5 py-2 sm:py-2.5 md:py-3 lg:py-3.5 xl:py-4 {{ app()->getLocale() == 'ar' ? 'pr-8 sm:pr-9 md:pr-10 lg:pr-11 xl:pr-12' : 'pl-8 sm:pl-9 md:pl-10 lg:pl-11 xl:pl-12' }} rounded-lg md:rounded-xl text-xs sm:text-sm md:text-base text-white placeholder-white/50 focus:outline-none @error('email') border-red-400/50 @enderror"
                           placeholder="{{ __('crm.enter_email') }}"
                           required>
                    <div class="absolute {{ app()->getLocale() == 'ar' ? 'right-2.5 sm:right-3 md:right-3.5 lg:right-4' : 'left-2.5 sm:left-3 md:left-3.5 lg:left-4' }} top-1/2 transform -translate-y-1/2">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 md:w-4.5 md:h-4.5 lg:w-5 lg:h-5 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                        </svg>
                    </div>
                </div>
                @error('email')
                    <p class="text-[10px] sm:text-xs md:text-sm text-red-300">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Field -->
            <div class="space-y-1 sm:space-y-1.5 md:space-y-2">
                <label for="password" class="block text-[10px] sm:text-xs md:text-sm lg:text-base font-semibold text-white/90">
                    {{ __('crm.password') }}
                </label>
                <div class="relative">
                    <input type="password" 
                           id="password" 
                           name="password"
                           disabled
                           class="input-field w-full px-2.5 sm:px-3 md:px-4 lg:px-5 py-2 sm:py-2.5 md:py-3 lg:py-3.5 xl:py-4 {{ app()->getLocale() == 'ar' ? 'pr-8 sm:pr-9 md:pr-10 lg:pr-11 xl:pr-12 pl-8 sm:pl-9 md:pl-10 lg:pl-11 xl:pl-12' : 'pl-8 sm:pl-9 md:pl-10 lg:pl-11 xl:pl-12 pr-8 sm:pr-9 md:pr-10 lg:pr-11 xl:pl-12' }} rounded-lg md:rounded-xl text-xs sm:text-sm md:text-base text-white placeholder-white/50 focus:outline-none @error('password') border-red-400/50 @enderror"
                           placeholder="{{ __('crm.enter_password') }}"
                           required>
                    <div class="absolute {{ app()->getLocale() == 'ar' ? 'right-2.5 sm:right-3 md:right-3.5 lg:right-4' : 'left-2.5 sm:left-3 md:left-3.5 lg:left-4' }} top-1/2 transform -translate-y-1/2">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 md:w-4.5 md:h-4.5 lg:w-5 lg:h-5 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <button type="button" 
                            onclick="togglePassword()"
                            class="absolute {{ app()->getLocale() == 'ar' ? 'left-2.5 sm:left-3 md:left-3.5 lg:left-4' : 'right-2.5 sm:right-3 md:right-3.5 lg:right-4' }} top-1/2 transform -translate-y-1/2 text-white/60 hover:text-white transition-colors">
                        <svg id="eyeOpen" class="w-3.5 h-3.5 sm:w-4 sm:h-4 md:w-4.5 md:h-4.5 lg:w-5 lg:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg id="eyeClosed" class="w-3.5 h-3.5 sm:w-4 sm:h-4 md:w-4.5 md:h-4.5 lg:w-5 lg:h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L8.464 8.464M18.364 18.364L16.95 16.95m1.414-1.414L16.95 16.95m0 0L15.536 15.536m1.414 1.414L18.364 18.364M15.536 15.536l-4.242-4.242"/>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="text-[10px] sm:text-xs md:text-sm text-red-300">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me & Options -->
            <div class="flex items-center justify-between text-[10px] sm:text-xs md:text-sm">
                <label class="flex items-center">
                    <input type="checkbox" 
                           id="remember" 
                           name="remember"
                           disabled
                           class="w-3 h-3 sm:w-3.5 sm:h-3.5 md:w-4 md:h-4 rounded border-white/30 bg-white/10 text-blue-500 focus:ring-blue-500/20 focus:ring-2">
                    <span class="{{ app()->getLocale() == 'ar' ? 'mr-1.5 sm:mr-2 md:mr-2.5' : 'ml-1.5 sm:ml-2 md:ml-2.5' }} text-white/90">
                        {{ __('crm.remember_me') }}
                    </span>
                </label>
                <a href="{{ route('admin.password.request') }}" class="text-blue-300 hover:text-blue-200 transition-colors">
                    {{ __('crm.forgot_password') }}
                </a>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                    id="submitButton"
                    disabled
                    class="btn-primary w-full py-2 sm:py-2.5 md:py-3 lg:py-3.5 xl:py-4 rounded-lg md:rounded-xl text-white font-bold text-xs sm:text-sm md:text-base lg:text-lg relative overflow-hidden group">
                <span class="relative z-10">
                    {{ __('crm.access_crm_portal') }}
                </span>
            </button>
        </form>

        <!-- Error/Success Messages -->
        @if (session('error'))
            <div class="mt-2 sm:mt-3 md:mt-4 lg:mt-5 p-2 sm:p-2.5 md:p-3 lg:p-3.5 rounded-lg md:rounded-xl bg-red-500/20 border border-red-400/30 backdrop-blur-sm">
                <div class="flex items-center">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 md:w-4.5 md:h-4.5 lg:w-5 lg:h-5 text-red-300 {{ app()->getLocale() == 'ar' ? 'ml-1.5 sm:ml-2 md:ml-2.5' : 'mr-1.5 sm:mr-2 md:mr-2.5' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-red-200 text-[10px] sm:text-xs md:text-sm">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Footer Info -->
        <div class="mt-3 sm:mt-4 md:mt-5 lg:mt-6 pt-2 sm:pt-3 md:pt-4 lg:pt-5 border-t border-white/10 text-center">
            <p class="text-white/60 text-[9px] sm:text-[10px] md:text-xs lg:text-sm">
                {{ __('crm.powered_by') }} 
                <span class="text-white font-semibold">Progineous Technologies</span>
            </p>
            <p class="text-white/40 text-[8px] sm:text-[9px] md:text-[10px] lg:text-xs mt-0.5 sm:mt-1">
                {{ __('crm.most_advanced_crm') }}
            </p>
        </div>
    </div>

    <script>
        // Translation strings
        const translations = {
            locationAccessRequired: "{{ __('crm.location_access_required') }}",
            locationForSecurity: "{{ __('crm.location_for_security') }}",
            locationAccessGranted: "{{ __('crm.location_access_granted') }}",
            loginNowSecure: "{{ __('crm.login_now_secure') }}",
            locationAccessDenied: "{{ __('crm.location_access_denied') }}",
            locationPermissionDenied: "{{ __('crm.location_permission_denied') }}",
            locationUnavailable: "{{ __('crm.location_unavailable') }}",
            locationTimeout: "{{ __('crm.location_timeout') }}",
            locationUnknownError: "{{ __('crm.location_unknown_error') }}",
            canContinueWithoutLocation: "{{ __('crm.can_continue_without_location') }}",
            cannotLoginWithoutLocation: "{{ __('crm.cannot_login_without_location') }}",
            locationNotSupported: "{{ __('crm.location_not_supported') }}",
            browserNoLocation: "{{ __('crm.browser_no_location') }}"
        };
        
        // Get current language
        const currentLang = "{{ app()->getLocale() }}";
        const isRTL = currentLang === 'ar';
        
        // Notification position classes based on language
        const notificationPosition = isRTL 
            ? 'fixed top-3 sm:top-4 right-3 sm:right-4 left-3 sm:left-auto' 
            : 'fixed top-3 sm:top-4 left-3 sm:left-4 right-3 sm:right-auto';
        
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const eyeOpen = document.getElementById('eyeOpen');
            const eyeClosed = document.getElementById('eyeClosed');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                passwordField.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }

        // Geolocation request and login tracking
        document.addEventListener('DOMContentLoaded', function() {
            // Don't focus on email - form is disabled until location granted
            requestLocationAccess();
        });

        function requestLocationAccess() {
            if ("geolocation" in navigator) {
                // Show location request notification
                showLocationNotification();
                
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        // Location granted
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;
                        
                        // Store location data for login
                        sessionStorage.setItem('loginLatitude', latitude);
                        sessionStorage.setItem('loginLongitude', longitude);
                        sessionStorage.setItem('locationAccuracy', position.coords.accuracy);
                        
                        // Show success message
                        showLocationSuccess(latitude, longitude);
                        
                        // Log the successful location access
                        logLocationAccess(latitude, longitude);
                    },
                    function(error) {
                        // Location denied or error
                        handleLocationError(error);
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            } else {
                // Browser doesn't support geolocation
                showLocationNotSupported();
            }
        }

        function showLocationNotification() {
            const notification = document.createElement('div');
            notification.id = 'location-notification';
            notification.className = notificationPosition + ' bg-blue-600 text-white p-3 sm:p-4 rounded-lg shadow-lg z-50 sm:max-w-sm';
            notification.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <div class="font-semibold text-sm sm:text-base">${translations.locationAccessRequired}</div>
                        <div class="text-xs sm:text-sm opacity-90">${translations.locationForSecurity}</div>
                    </div>
                </div>
            `;
            document.body.appendChild(notification);
        }

        function showLocationSuccess(lat, lng) {
            const notification = document.getElementById('location-notification');
            if (notification) {
                notification.className = notificationPosition + ' bg-green-600 text-white p-3 sm:p-4 rounded-lg shadow-lg z-50 sm:max-w-sm';
                notification.innerHTML = `
                    <div class="flex items-center">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <div class="font-semibold text-sm sm:text-base">${translations.locationAccessGranted}</div>
                            <div class="text-xs sm:text-sm opacity-90">${translations.loginNowSecure}</div>
                        </div>
                    </div>
                `;
                
                // Enable the login form
                enableLoginForm();
                
                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }
        }
        
        function enableLoginForm() {
            const loginForm = document.getElementById('loginForm');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const rememberCheckbox = document.getElementById('remember');
            const submitButton = document.getElementById('submitButton');
            
            // Enable all inputs
            emailInput.disabled = false;
            passwordInput.disabled = false;
            rememberCheckbox.disabled = false;
            submitButton.disabled = false;
            
            // Remove disabled styling
            loginForm.style.opacity = '1';
            loginForm.style.pointerEvents = 'auto';
            
            // Focus on email field
            emailInput.focus();
        }

        function handleLocationError(error) {
            let errorMessage = '';
            let canProceed = false; // Keep form disabled by default
            
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    errorMessage = translations.locationPermissionDenied;
                    canProceed = false; // Block login if permission denied - KEEP DISABLED
                    break;
                case error.POSITION_UNAVAILABLE:
                    errorMessage = translations.locationUnavailable;
                    canProceed = false; // Block login - KEEP DISABLED
                    break;
                case error.TIMEOUT:
                    errorMessage = translations.locationTimeout;
                    canProceed = false; // Block login - KEEP DISABLED
                    break;
                default:
                    errorMessage = translations.locationUnknownError;
                    canProceed = false; // Block login - KEEP DISABLED
                    break;
            }
            
            // Form stays disabled in all error cases
            
            const notification = document.getElementById('location-notification');
            if (notification) {
                notification.className = notificationPosition + ' bg-red-600 text-white p-3 sm:p-4 rounded-lg shadow-lg z-50 sm:max-w-sm';
                notification.innerHTML = `
                    <div class="flex flex-col gap-2">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <div class="font-semibold text-sm sm:text-base">${translations.locationAccessDenied}</div>
                                <div class="text-xs sm:text-sm opacity-90">${errorMessage}</div>
                                <div class="text-[10px] sm:text-xs mt-1 font-bold">${translations.cannotLoginWithoutLocation}</div>
                            </div>
                        </div>
                    </div>
                `;
                // Notification stays permanently (doesn't auto-remove)
            }
        }

        function showLocationNotSupported() {
            const notification = document.createElement('div');
            notification.className = notificationPosition + ' bg-red-600 text-white p-3 sm:p-4 rounded-lg shadow-lg z-50 sm:max-w-sm';
            notification.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <div class="font-semibold text-sm sm:text-base">${translations.locationNotSupported}</div>
                        <div class="text-xs sm:text-sm opacity-90">${translations.browserNoLocation}</div>
                        <div class="text-[10px] sm:text-xs mt-1 font-bold">${translations.cannotLoginWithoutLocation}</div>
                    </div>
                </div>
            `;
            document.body.appendChild(notification);
            // Form stays disabled - notification stays permanently
        }

        function logLocationAccess(lat, lng) {
            // Send location data to server for logging
            fetch('/unleasha/log-location', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    latitude: lat,
                    longitude: lng,
                    accuracy: sessionStorage.getItem('locationAccuracy'),
                    timestamp: new Date().toISOString()
                })
            }).catch(error => {
                console.log('Location logging failed:', error);
            });
        }

        // Add location data to login form submission
        document.addEventListener('submit', function(e) {
            if (e.target.id === 'loginForm') {
                console.log('🚀 Form submitted');
                const latitude = sessionStorage.getItem('loginLatitude');
                const longitude = sessionStorage.getItem('loginLongitude');
                
                console.log('📍 Location:', { latitude, longitude });
                
                if (latitude && longitude) {
                    // Add hidden fields for location
                    const latField = document.createElement('input');
                    latField.type = 'hidden';
                    latField.name = 'login_latitude';
                    latField.value = latitude;
                    
                    const lngField = document.createElement('input');
                    lngField.type = 'hidden';
                    lngField.name = 'login_longitude';
                    lngField.value = longitude;
                    
                    e.target.appendChild(latField);
                    e.target.appendChild(lngField);
                    
                    console.log('✅ Location fields added to form');
                } else {
                    console.warn('⚠️ No location data found in sessionStorage');
                }
            }
        });
    </script>
</body>
</html>