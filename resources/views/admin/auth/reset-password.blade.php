<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('crm.reset_password') }} - {{ __('crm.crm_admin_portal') }}</title>
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
<body class="login-bg flex items-center justify-center min-h-screen p-3 sm:p-4">
    
    <!-- Language Switcher -->
    <div class="language-toggle">
        <div class="flex gap-1 sm:gap-2 bg-white/10 backdrop-blur-md rounded-md sm:rounded-lg p-1 sm:p-1.5">
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
    
    <!-- Main Container -->
    <div class="glass-container p-4 sm:p-5 md:p-6 lg:p-8 xl:p-10 w-[90%] sm:w-[80%] md:w-[70%] lg:w-[60%] xl:w-[50%] 2xl:w-[45%] max-w-2xl mx-auto slide-in relative z-10">
        <!-- Logo and Branding -->
        <div class="text-center mb-3 sm:mb-4 md:mb-5 lg:mb-6 xl:mb-8">
            <div class="logo-glow inline-block mb-2 sm:mb-3 md:mb-4 lg:mb-5 xl:mb-6">
                <img src="{{ asset('logo/pro Gineous_white logo.svg') }}" 
                     alt="Pro Gineous" 
                     class="h-12 sm:h-14 md:h-16 lg:h-20 xl:h-24 w-auto object-contain mx-auto">
            </div>
            <h1 class="text-lg sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl font-bold text-white mb-1.5 sm:mb-2 md:mb-2.5 lg:mb-3">
                {{ __('crm.reset_password') }}
            </h1>
            <p class="text-white/80 text-sm sm:text-base md:text-lg lg:text-xl">
                {{ __('crm.enter_new_password') }}
            </p>
        </div>

        <!-- Reset Password Form -->
        <form method="POST" action="{{ route('admin.password.update') }}" id="resetPasswordForm" class="space-y-3 sm:space-y-4 md:space-y-5 lg:space-y-6" style="opacity: 0.5; pointer-events: none;">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            
            <!-- Email Field -->
            <div class="space-y-1.5 sm:space-y-2 md:space-y-2.5">
                <label for="email" class="block text-xs sm:text-sm md:text-base lg:text-lg font-semibold text-white/90">
                    {{ __('crm.email_address') }}
                </label>
                <div class="relative">
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email', request('email')) }}"
                           disabled
                           class="input-field w-full px-3 sm:px-4 md:px-5 lg:px-6 py-2.5 sm:py-3 md:py-3.5 lg:py-4 xl:py-5 {{ app()->getLocale() == 'ar' ? 'pr-9 sm:pr-10 md:pr-11 lg:pr-12 xl:pr-14' : 'pl-9 sm:pl-10 md:pl-11 lg:pl-12 xl:pl-14' }} rounded-lg md:rounded-xl lg:rounded-2xl text-white placeholder-white/50 focus:outline-none @error('email') border-red-400/50 @enderror"
                           placeholder="{{ __('crm.enter_email') }}"
                           required>
                    <div class="absolute {{ app()->getLocale() == 'ar' ? 'right-3 sm:right-4 md:right-4.5 lg:right-5' : 'left-3 sm:left-4 md:left-4.5 lg:left-5' }} top-1/2 transform -translate-y-1/2">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-5.5 md:h-5.5 lg:w-6 lg:h-6 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                        </svg>
                    </div>
                </div>
                @error('email')
                    <p class="text-xs sm:text-sm md:text-base text-red-300">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Field -->
            <div class="space-y-1.5 sm:space-y-2 md:space-y-2.5">
                <label for="password" class="block text-xs sm:text-sm md:text-base lg:text-lg font-semibold text-white/90">
                    {{ __('crm.new_password') }}
                </label>
                <div class="relative">
                    <input type="password" 
                           id="password" 
                           name="password" 
                           disabled
                           class="input-field w-full px-3 sm:px-4 md:px-5 lg:px-6 py-2.5 sm:py-3 md:py-3.5 lg:py-4 xl:py-5 {{ app()->getLocale() == 'ar' ? 'pr-9 sm:pr-10 md:pr-11 lg:pr-12 xl:pr-14' : 'pl-9 sm:pl-10 md:pl-11 lg:pl-12 xl:pl-14' }} rounded-lg md:rounded-xl lg:rounded-2xl text-white placeholder-white/50 focus:outline-none @error('password') border-red-400/50 @enderror"
                           placeholder="{{ __('crm.enter_password') }}"
                           required>
                    <div class="absolute {{ app()->getLocale() == 'ar' ? 'right-3 sm:right-4 md:right-4.5 lg:right-5' : 'left-3 sm:left-4 md:left-4.5 lg:left-5' }} top-1/2 transform -translate-y-1/2">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-5.5 md:h-5.5 lg:w-6 lg:h-6 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                </div>
                @error('password')
                    <p class="text-xs sm:text-sm md:text-base text-red-300">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Confirmation Field -->
            <div class="space-y-1.5 sm:space-y-2 md:space-y-2.5">
                <label for="password_confirmation" class="block text-xs sm:text-sm md:text-base lg:text-lg font-semibold text-white/90">
                    {{ __('crm.confirm_password') }}
                </label>
                <div class="relative">
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           disabled
                           class="input-field w-full px-3 sm:px-4 md:px-5 lg:px-6 py-2.5 sm:py-3 md:py-3.5 lg:py-4 xl:py-5 {{ app()->getLocale() == 'ar' ? 'pr-9 sm:pr-10 md:pr-11 lg:pr-12 xl:pr-14' : 'pl-9 sm:pl-10 md:pl-11 lg:pl-12 xl:pl-14' }} rounded-lg md:rounded-xl lg:rounded-2xl text-white placeholder-white/50 focus:outline-none"
                           placeholder="{{ __('crm.confirm_password') }}"
                           required>
                    <div class="absolute {{ app()->getLocale() == 'ar' ? 'right-3 sm:right-4 md:right-4.5 lg:right-5' : 'left-3 sm:left-4 md:left-4.5 lg:left-5' }} top-1/2 transform -translate-y-1/2">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-5.5 md:h-5.5 lg:w-6 lg:h-6 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    id="submitButton"
                    disabled
                    class="btn-primary w-full py-2 sm:py-2.5 md:py-3 lg:py-3.5 xl:py-4 rounded-lg md:rounded-xl text-white font-bold text-xs sm:text-sm md:text-base lg:text-lg relative overflow-hidden group">
                <span class="relative z-10">
                    {{ __('crm.reset_password_button') }}
                </span>
            </button>
        </form>

        <!-- Back to Login -->
        <div class="mt-3 sm:mt-4 md:mt-5 text-center">
            <a href="{{ route('admin.login') }}" class="text-white/80 hover:text-white text-[10px] sm:text-xs md:text-sm transition-colors inline-flex items-center gap-1 sm:gap-2">
                <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() == 'ar' ? 'M14 5l7 7m0 0l-7 7m7-7H3' : 'M10 19l-7-7m0 0l7-7m-7 7h18' }}"/>
                </svg>
                {{ __('crm.back_to_login') }}
            </a>
        </div>

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

        // Geolocation request
        document.addEventListener('DOMContentLoaded', function() {
            requestLocationAccess();
        });

        function requestLocationAccess() {
            if ("geolocation" in navigator) {
                showLocationNotification();
                
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;
                        
                        sessionStorage.setItem('resetPasswordLatitude', latitude);
                        sessionStorage.setItem('resetPasswordLongitude', longitude);
                        
                        showLocationSuccess();
                    },
                    function(error) {
                        handleLocationError(error);
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            } else {
                showLocationNotSupported();
            }
        }

        function showLocationNotification() {
            const notification = document.createElement('div');
            notification.id = 'location-notification';
            notification.className = notificationPosition + ' bg-blue-600 text-white p-3 sm:p-4 rounded-lg shadow-lg z-50 sm:max-w-sm';
            notification.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 ${isRTL ? 'ml-2' : 'mr-2'}" fill="currentColor" viewBox="0 0 20 20">
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

        function showLocationSuccess() {
            const notification = document.getElementById('location-notification');
            if (notification) {
                notification.className = notificationPosition + ' bg-green-600 text-white p-3 sm:p-4 rounded-lg shadow-lg z-50 sm:max-w-sm';
                notification.innerHTML = `
                    <div class="flex items-center">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 ${isRTL ? 'ml-2' : 'mr-2'}" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <div class="font-semibold text-sm sm:text-base">${translations.locationAccessGranted}</div>
                            <div class="text-xs sm:text-sm opacity-90">${translations.loginNowSecure}</div>
                        </div>
                    </div>
                `;
                
                enableForm();
                
                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }
        }
        
        function enableForm() {
            const form = document.getElementById('resetPasswordForm');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const submitButton = document.getElementById('submitButton');
            
            emailInput.disabled = false;
            passwordInput.disabled = false;
            passwordConfirmationInput.disabled = false;
            submitButton.disabled = false;
            
            form.style.opacity = '1';
            form.style.pointerEvents = 'auto';
            
            passwordInput.focus();
        }

        function handleLocationError(error) {
            let errorMessage = '';
            
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    errorMessage = translations.locationPermissionDenied;
                    break;
                case error.POSITION_UNAVAILABLE:
                    errorMessage = translations.locationUnavailable;
                    break;
                case error.TIMEOUT:
                    errorMessage = translations.locationTimeout;
                    break;
                default:
                    errorMessage = translations.locationUnknownError;
                    break;
            }
            
            const notification = document.getElementById('location-notification');
            if (notification) {
                notification.className = notificationPosition + ' bg-red-600 text-white p-3 sm:p-4 rounded-lg shadow-lg z-50 sm:max-w-sm';
                notification.innerHTML = `
                    <div class="flex items-center">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 ${isRTL ? 'ml-2' : 'mr-2'}" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <div class="font-semibold text-sm sm:text-base">${translations.locationAccessDenied}</div>
                            <div class="text-xs sm:text-sm opacity-90">${errorMessage}</div>
                            <div class="text-[10px] sm:text-xs mt-1 font-bold">${translations.cannotLoginWithoutLocation}</div>
                        </div>
                    </div>
                `;
            }
        }

        function showLocationNotSupported() {
            const notification = document.createElement('div');
            notification.className = notificationPosition + ' bg-red-600 text-white p-3 sm:p-4 rounded-lg shadow-lg z-50 sm:max-w-sm';
            notification.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 ${isRTL ? 'ml-2' : 'mr-2'}" fill="currentColor" viewBox="0 0 20 20">
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
        }
    </script>
</body>
</html>
