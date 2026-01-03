@extends('admin.layout')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">{{ __('crm.add_new_client') }}</h1>
            <p class="mt-1 text-sm text-gray-600">{{ __('crm.create_new_client_description') }}</p>
        </div>
        <a href="{{ route('admin.clients.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors duration-200">
            <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            {{ __('crm.back_to_clients') }}
        </a>
    </div>

    <!-- Notification Container -->
    <div id="notification-container" class="fixed top-4 {{ app()->getLocale() == 'ar' ? 'left-4' : 'right-4' }} z-50 hidden">
        <div id="notification-box" class="bg-white rounded-lg shadow-lg border-l-4 p-4 min-w-80 max-w-md transform transition-all duration-300 ease-in-out">
            <div class="flex items-start">
                <div id="notification-icon" class="flex-shrink-0">
                    <!-- Icon will be inserted here -->
                </div>
                <div class="flex-1 {{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }}">
                    <p id="notification-message" class="text-sm font-medium text-gray-900"></p>
                </div>
                <button type="button" onclick="hideNotification()" class="flex-shrink-0 {{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }} text-gray-400 hover:text-gray-600">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.clients.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <!-- Account Username -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-purple-500 px-6 py-4">
                <h2 class="text-lg font-semibold text-white flex items-center">
                    <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                    </svg>
                    {{ __('crm.account_username') }}
                </h2>
            </div>
            
            <div class="p-6">
                <div class="max-w-2xl">
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('crm.username') }} <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'right-0 pr-3' : 'left-0 pl-3' }} flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <input type="text" name="username" id="username" required
                               minlength="6"
                               maxlength="9"
                               pattern="[a-z0-9_-]+"
                               title="{{ __('crm.username_validation') }}"
                               class="w-full {{ app()->getLocale() == 'ar' ? 'pr-10 pl-24' : 'pl-10 pr-24' }} py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200"
                               value="{{ old('username') }}"
                               placeholder="{{ __('crm.username_placeholder') }}"
                               style="text-transform: lowercase;">
                        
                        <!-- Auto Generate Icon Button -->
                        <button type="button" id="auto-generate-username" 
                                title="{{ __('crm.auto_generate') }}"
                                class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-0 ml-2' : 'right-0 mr-2' }} flex items-center px-3 text-purple-600 hover:text-purple-800 transition-colors duration-200 group">
                            <svg class="w-5 h-5 group-hover:rotate-180 transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                        
                        <!-- Loading Spinner -->
                        <div id="username-spinner" class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-14 pl-3' : 'right-14 pr-3' }} flex items-center hidden">
                            <svg class="animate-spin h-5 w-5 text-purple-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                        <!-- Success Icon -->
                        <div id="username-success" class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-14 pl-3' : 'right-14 pr-3' }} flex items-center hidden">
                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <!-- Error Icon -->
                        <div id="username-error" class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-14 pl-3' : 'right-14 pr-3' }} flex items-center hidden">
                            <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    @error('username')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p id="username-message" class="mt-2 text-xs text-gray-500">{{ __('crm.username_hint') }}</p>
                </div>
            </div>
        </div>
        
        <!-- Personal Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="bg-gradient-to-r from-blue-600 to-blue-500 px-6 py-4 rounded-t-xl">
                <h2 class="text-lg font-semibold text-white flex items-center">
                    <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                    {{ __('crm.personal_information') }}
                </h2>
            </div>
            
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- First Name -->
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('crm.first_name') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="first_name" id="first_name" required
                           pattern="[a-zA-Z\s]+"
                           title="{{ __('crm.first_name_english_only') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                           value="{{ old('first_name') }}">
                    @error('first_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">{{ __('crm.english_letters_only_hint') }}</p>
                </div>

                <!-- Last Name -->
                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('crm.last_name') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="last_name" id="last_name" required
                           pattern="[a-zA-Z\s]+"
                           title="{{ __('crm.last_name_english_only') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                           value="{{ old('last_name') }}">
                    @error('last_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">{{ __('crm.english_letters_only_hint') }}</p>
                </div>

                <!-- Company Name (Optional) -->
                <div>
                    <label for="company_name" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('crm.company_name') }} <span class="text-gray-400 text-xs">({{ __('crm.optional') }})</span>
                    </label>
                    <input type="text" name="company_name" id="company_name"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                           value="{{ old('company_name') }}">
                </div>

                <!-- Email Address with Verification -->
                <div class="md:col-span-2">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('crm.email_address') }} <span class="text-red-500">*</span>
                    </label>
                    
                    <div class="flex gap-2 mb-3">
                        <div class="relative flex-1">
                            <input type="email" name="email" id="email" required
                                   pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}"
                                   title="{{ __('crm.email_validation') }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                   value="{{ old('email') }}"
                                   placeholder="{{ __('crm.email_address') }}">
                            <!-- Verification Status Icon -->
                            <div id="email-verify-status" class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-0 pl-3' : 'right-0 pr-3' }} flex items-center hidden">
                                <svg id="email-verified-icon" class="h-5 w-5 text-green-500 hidden" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        <!-- Send OTP Button -->
                        <button type="button" id="send-otp-btn" 
                                class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200 whitespace-nowrap flex items-center gap-2 disabled:bg-gray-400 disabled:cursor-not-allowed">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                            <span id="send-otp-text">{{ __('crm.send_verification_code') }}</span>
                        </button>
                    </div>
                    
                    <!-- OTP Input (Hidden by default) -->
                    <div id="otp-verification-section" class="hidden">
                        <div class="flex gap-2">
                            <div class="relative flex-1">
                                <input type="text" id="otp-code" maxlength="6" pattern="\d{6}"
                                       placeholder="{{ __('crm.enter_verification_code') }}"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200 text-center text-2xl font-mono tracking-wider">
                                <!-- Verification Spinner -->
                                <div id="otp-verify-spinner" class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-0 pl-3' : 'right-0 pr-3' }} flex items-center hidden">
                                    <svg class="animate-spin h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                            </div>
                            <button type="button" id="verify-otp-btn" 
                                    class="px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200 whitespace-nowrap flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                {{ __('crm.verify_email') }}
                            </button>
                            <button type="button" id="resend-otp-btn" 
                                    class="px-4 py-2.5 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-200 whitespace-nowrap">
                                🔄 {{ __('crm.resend_code') }}
                            </button>
                        </div>
                        <p id="otp-countdown" class="mt-2 text-xs text-gray-500"></p>
                    </div>
                    
                    <input type="hidden" name="email_verified" id="email-verified-input" value="0">
                    
                    <p id="email-message" class="mt-2 text-xs text-gray-500"></p>
                    
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('crm.password') }} <span class="text-red-500">*</span>
                    </label>
                    
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                               minlength="8"
                               pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};':&quot;\\|,.<>\/?])[A-Za-z\d!@#$%^&*()_+\-=\[\]{};':&quot;\\|,.<>\/?]{8,}$"
                               title="{{ __('crm.password_requirements') }}"
                               class="w-full {{ app()->getLocale() == 'ar' ? 'pr-4 pl-12' : 'pl-4 pr-12' }} py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                               placeholder="{{ __('crm.enter_password') }}">
                        
                        <!-- Toggle Password Visibility Button -->
                        <button type="button" id="toggle-password" 
                                title="{{ __('crm.show_password') }}"
                                class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-0 ml-3' : 'right-0 mr-3' }} flex items-center text-gray-500 hover:text-gray-700 transition-colors duration-200">
                            <!-- Eye Icon (Show) -->
                            <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <!-- Eye Slash Icon (Hide) -->
                            <svg id="eye-slash-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Password Strength Meter -->
                    <div class="mt-2">
                        <div class="flex items-center gap-1 mb-1">
                            <div id="strength-bar-1" class="h-1 flex-1 bg-gray-200 rounded transition-colors duration-300"></div>
                            <div id="strength-bar-2" class="h-1 flex-1 bg-gray-200 rounded transition-colors duration-300"></div>
                            <div id="strength-bar-3" class="h-1 flex-1 bg-gray-200 rounded transition-colors duration-300"></div>
                            <div id="strength-bar-4" class="h-1 flex-1 bg-gray-200 rounded transition-colors duration-300"></div>
                        </div>
                        <p id="strength-text" class="text-xs text-gray-500">{{ __('crm.password_strength') }}: <span id="strength-label">{{ __('crm.not_entered') }}</span></p>
                    </div>
                    
                    <!-- Compromised Password Warning -->
                    <div id="compromised-warning" class="hidden mt-3 p-3 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-red-800">{{ __('crm.password_is_compromised') }}</p>
                                <p class="text-xs text-red-700 mt-1">{{ __('crm.password_compromised') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Password Requirements Checklist -->
                    <div class="mt-3 space-y-1 text-xs">
                        <div id="req-length" class="hidden items-center gap-2 text-red-500">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ __('crm.min_8_characters') }}</span>
                        </div>
                        <div id="req-uppercase" class="hidden items-center gap-2 text-red-500">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ __('crm.one_uppercase') }}</span>
                        </div>
                        <div id="req-lowercase" class="hidden items-center gap-2 text-red-500">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ __('crm.one_lowercase') }}</span>
                        </div>
                        <div id="req-special" class="hidden items-center gap-2 text-red-500">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ __('crm.one_special_character') }}</span>
                        </div>
                        <div id="req-number" class="hidden items-center gap-2 text-red-500">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ __('crm.one_number') }}</span>
                        </div>
                        <div id="req-no-arabic" class="hidden items-center gap-2 text-red-500">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ __('crm.no_arabic_or_spaces') }}</span>
                        </div>
                        <div id="req-no-personal" class="hidden items-center gap-2 text-red-500">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ __('crm.no_personal_info') }}</span>
                        </div>
                    </div>
                    
                    <!-- Generate Password Button -->
                    <button type="button" id="generate-password" 
                            class="mt-3 w-full px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white rounded-lg transition-all duration-200 flex items-center justify-center gap-2 group">
                        <svg class="w-4 h-4 group-hover:rotate-180 transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ __('crm.generate_strong_password') }}</span>
                    </button>
                    
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone Number with Country Code -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('crm.phone_number') }} <span class="text-red-500">*</span>
                    </label>
                    
                    <div class="flex flex-col sm:flex-row gap-2">
                        <!-- Country Code Selector -->
                        <div id="country-selector" class="relative w-full sm:w-36" 
                             x-data="{ 
                                 open: false, 
                                 search: '', 
                                 selected: { 
                                     code: 'EG', 
                                     dial: '+20', 
                                     name: '{{ app()->getLocale() == "ar" ? "مصر" : "Egypt" }}', 
                                     flag: '🇪🇬' 
                                 },
                                 selectCountry(code, dial, name, flag) {
                                     this.selected = { code, dial, name, flag };
                                     this.open = false;
                                     this.search = '';
                                     document.getElementById('country_code').value = code;
                                     if (window.onCountrySelected) {
                                         window.onCountrySelected();
                                     }
                                 }
                             }"
                             @click.outside="open = false">
                            <button type="button" @click="open = !open"
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg bg-white hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 flex items-center justify-between">
                                <span class="flex items-center {{ app()->getLocale() == 'ar' ? 'gap-2' : 'gap-2' }} text-sm">
                                    <span x-text="selected.flag" class="text-xl"></span>
                                    <span x-text="selected.dial" class="font-medium"></span>
                                </span>
                                <svg class="w-4 h-4 text-gray-400 {{ app()->getLocale() == 'ar' ? 'rotate-0' : '' }}" 
                                     :class="open ? 'transform rotate-180' : ''"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            
                            <!-- Dropdown -->
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform scale-95"
                                 x-transition:enter-end="opacity-100 transform scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 transform scale-100"
                                 x-transition:leave-end="opacity-0 transform scale-95"
                                 @click.stop
                                 style="z-index: 9999;"
                                 class="absolute {{ app()->getLocale() == 'ar' ? 'right-0 sm:right-0' : 'left-0 sm:left-0' }} mt-1 w-full sm:w-80 bg-white border border-gray-300 rounded-lg shadow-xl max-h-96 overflow-hidden"
                                 dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                                <!-- Search -->
                                <div class="p-3 border-b bg-gray-50">
                                    <div class="relative">
                                        <svg class="absolute {{ app()->getLocale() == 'ar' ? 'right-3' : 'left-3' }} top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                        <input type="text" 
                                               id="country-search"
                                               x-model="search"
                                               @input="window.filterCountries($event.target.value)"
                                               @click.stop
                                               @mousedown.stop
                                               placeholder="{{ __('crm.search_country') }}"
                                               dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}"
                                               class="w-full {{ app()->getLocale() == 'ar' ? 'pr-10 pl-3 text-right' : 'pl-10 pr-3 text-left' }} py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>
                                
                                <!-- Countries List -->
                                <div class="overflow-y-auto max-h-64 sm:max-h-80" id="countries-list" @click.stop>
                                    <!-- Countries will be dynamically loaded here -->
                                </div>
                            </div>
                            
                            <input type="hidden" name="country_code" id="country_code" x-model="selected.code" value="EG">
                        </div>
                        
                        <!-- Phone Input -->
                        <div class="relative flex-1">
                            <input type="tel" name="phone" id="phone" required
                                   placeholder="{{ __('crm.enter_phone_number') }}"
                                   class="w-full {{ app()->getLocale() == 'ar' ? 'pr-4 pl-24' : 'pl-4 pr-24' }} py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                   value="{{ old('phone') }}">
                            
                            <!-- Validation Status Icons -->
                            <div id="phone-spinner" class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-0 pl-3' : 'right-0 pr-3' }} hidden items-center">
                                <svg class="animate-spin h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                            <div id="phone-success" class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-0 pl-3' : 'right-0 pr-3' }} hidden items-center">
                                <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div id="phone-error" class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-0 pl-3' : 'right-0 pr-3' }} hidden items-center">
                                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Phone Message -->
                    <p id="phone-message" class="mt-2 text-xs text-gray-500"></p>
                    
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Address Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-green-500 px-6 py-4 rounded-t-xl">
                <h2 class="text-lg font-semibold text-white flex items-center">
                    <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                    </svg>
                    {{ __('crm.address_information') }}
                </h2>
            </div>
            
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Address 1 (English Only) -->
                <div class="md:col-span-2">
                    <label for="address1" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('crm.address_1') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="address1" id="address1" required
                           pattern="[A-Za-z0-9\s\.,#\-]+"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                           placeholder="{{ __('crm.english_only') }}"
                           value="{{ old('address1') }}">
                    <p class="mt-1 text-xs text-gray-500">{{ __('crm.english_letters_only') }}</p>
                </div>

                <!-- Address 2 (Optional) -->
                <div class="md:col-span-2">
                    <label for="address2" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('crm.address_2') }} <span class="text-gray-400 text-xs">({{ __('crm.optional') }}) - {{ __('crm.english_only') }}</span>
                    </label>
                    <input type="text" name="address2" id="address2"
                           pattern="[A-Za-z0-9\s\.,#\-]*"
                           placeholder="{{ __('crm.english_letters_only') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                           value="{{ old('address2') }}">
                    <p class="mt-1 text-xs text-gray-500">{{ __('crm.english_letters_only') }}</p>
                </div>

                <!-- City -->
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('crm.city') }} <span class="text-red-500">*</span> <span class="text-gray-400 text-xs">- {{ __('crm.english_only') }}</span>
                    </label>
                    <input type="text" name="city" id="city" required
                           pattern="[A-Za-z\s\-]+"
                           placeholder="{{ __('crm.english_only') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                           value="{{ old('city') }}">
                </div>

                <!-- State/Region -->
                <div>
                    <label for="state" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('crm.state_region') }} <span class="text-red-500">*</span> <span class="text-gray-400 text-xs">- {{ __('crm.english_only') }}</span>
                    </label>
                    <input type="text" name="state" id="state" required
                           pattern="[A-Za-z\s\-]+"
                           placeholder="{{ __('crm.english_only') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                           value="{{ old('state') }}">
                </div>

                <!-- Postcode -->
                <div>
                    <label for="postcode" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('crm.postcode') }} <span class="text-red-500">*</span> <span class="text-gray-400 text-xs">- {{ __('crm.english_only') }}</span>
                    </label>
                    <input type="text" name="postcode" id="postcode" required
                           pattern="[A-Za-z0-9\s\-]+"
                           placeholder="{{ __('crm.english_only') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                           value="{{ old('postcode') }}">
                </div>

                <!-- Country (Using rinvex/countries - English names only) -->
                <div>
                    <label for="country" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('crm.country') }} <span class="text-red-500">*</span> <span class="text-gray-400 text-xs">- {{ __('crm.english_only') }}</span>
                    </label>
                    <select name="country" id="country" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                        <option value="">{{ __('crm.select_country') }}</option>
                        @foreach(countries() as $code => $country)
                            <option value="{{ $code }}" {{ old('country') == $code ? 'selected' : '' }}>
                                {{ $country['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tax Registration Number (Optional) -->
                <div class="md:col-span-2">
                    <label for="tax_number" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('crm.tax_number') }} <span class="text-gray-400 text-xs">({{ __('crm.optional') }}) - {{ __('crm.english_only') }}</span>
                    </label>
                    <input type="text" name="tax_number" id="tax_number"
                           pattern="[A-Za-z0-9\s\-]*"
                           placeholder="{{ __('crm.english_only') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                           value="{{ old('tax_number') }}">
                    <p class="mt-1 text-xs text-gray-500">{{ __('crm.english_letters_numbers_only') }}</p>
                </div>
            </div>
        </div>

        <!-- Account Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-purple-500 px-6 py-4">
                <h2 class="text-lg font-semibold text-white flex items-center">
                    <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                    </svg>
                    {{ __('crm.account_settings') }}
                </h2>
            </div>
            
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Language -->
                <div>
                    <label for="language" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('crm.language') }}
                    </label>
                    <select name="language" id="language"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                        <option value="ar" {{ old('language') == 'ar' ? 'selected' : '' }}>العربية</option>
                        <option value="en" {{ old('language') == 'en' ? 'selected' : '' }}>English</option>
                    </select>
                </div>

                <!-- Currency -->
                <div>
                    <label for="currency" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('crm.currency') }}
                    </label>
                    <select name="currency" id="currency"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                        <option value="EGP" {{ old('currency') == 'EGP' ? 'selected' : '' }}>EGP - Egyptian Pound</option>
                        <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                        <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                        <option value="SAR" {{ old('currency') == 'SAR' ? 'selected' : '' }}>SAR - Saudi Riyal</option>
                    </select>
                </div>

                <!-- Payment Method -->
                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('crm.payment_method') }}
                    </label>
                    <select name="payment_method" id="payment_method"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                        <option value="credit_card">{{ __('crm.credit_card') }}</option>
                        <option value="bank_transfer">{{ __('crm.bank_transfer') }}</option>
                        <option value="paypal">PayPal</option>
                        <option value="cash">{{ __('crm.cash') }}</option>
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('crm.status') }}
                    </label>
                    <select name="status" id="status"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>{{ __('crm.active') }}</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>{{ __('crm.inactive') }}</option>
                        <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>{{ __('crm.suspended') }}</option>
                    </select>
                </div>

                <!-- Billing Contact -->
                <div>
                    <label for="billing_contact" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('crm.billing_contact') }}
                    </label>
                    <input type="text" name="billing_contact" id="billing_contact"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                           value="{{ old('billing_contact') }}">
                </div>

                <!-- How did you find us? -->
                <div>
                    <label for="referral_source" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('crm.how_did_you_find_us') }}
                    </label>
                    <select name="referral_source" id="referral_source"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                        <option value="">{{ __('crm.select_option') }}</option>
                        <option value="google">Google</option>
                        <option value="facebook">Facebook</option>
                        <option value="friend">{{ __('crm.friend_referral') }}</option>
                        <option value="other">{{ __('crm.other') }}</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Email Notifications -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-500 px-6 py-4">
                <h2 class="text-lg font-semibold text-white flex items-center">
                    <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                    </svg>
                    {{ __('crm.email_notifications') }}
                </h2>
            </div>
            
            <div class="p-6 space-y-4">
                <div class="flex items-start">
                    <input type="checkbox" name="email_general" id="email_general" value="1" checked
                           class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="email_general" class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} text-sm">
                        <span class="font-medium text-gray-900">{{ __('crm.general_emails') }}</span>
                        <p class="text-gray-600">{{ __('crm.general_emails_desc') }}</p>
                    </label>
                </div>

                <div class="flex items-start">
                    <input type="checkbox" name="email_invoice" id="email_invoice" value="1" checked
                           class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="email_invoice" class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} text-sm">
                        <span class="font-medium text-gray-900">{{ __('crm.invoice_emails') }}</span>
                        <p class="text-gray-600">{{ __('crm.invoice_emails_desc') }}</p>
                    </label>
                </div>

                <div class="flex items-start">
                    <input type="checkbox" name="email_support" id="email_support" value="1" checked
                           class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="email_support" class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} text-sm">
                        <span class="font-medium text-gray-900">{{ __('crm.support_emails') }}</span>
                        <p class="text-gray-600">{{ __('crm.support_emails_desc') }}</p>
                    </label>
                </div>

                <div class="flex items-start">
                    <input type="checkbox" name="email_product" id="email_product" value="1" checked
                           class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="email_product" class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} text-sm">
                        <span class="font-medium text-gray-900">{{ __('crm.product_emails') }}</span>
                        <p class="text-gray-600">{{ __('crm.product_emails_desc') }}</p>
                    </label>
                </div>

                <div class="flex items-start">
                    <input type="checkbox" name="email_domain" id="email_domain" value="1" checked
                           class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="email_domain" class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} text-sm">
                        <span class="font-medium text-gray-900">{{ __('crm.domain_emails') }}</span>
                        <p class="text-gray-600">{{ __('crm.domain_emails_desc') }}</p>
                    </label>
                </div>

                <div class="flex items-start">
                    <input type="checkbox" name="email_affiliate" id="email_affiliate" value="1"
                           class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="email_affiliate" class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} text-sm">
                        <span class="font-medium text-gray-900">{{ __('crm.affiliate_emails') }}</span>
                        <p class="text-gray-600">{{ __('crm.affiliate_emails_desc') }}</p>
                    </label>
                </div>
            </div>
        </div>

        <!-- Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-orange-600 to-orange-500 px-6 py-4">
                <h2 class="text-lg font-semibold text-white flex items-center">
                    <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                    </svg>
                    {{ __('crm.settings') }}
                </h2>
            </div>
            
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-center">
                    <input type="checkbox" name="late_fees" id="late_fees" value="1"
                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="late_fees" class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} text-sm font-medium text-gray-700">
                        {{ __('crm.late_fees') }}
                    </label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="overdue_notices" id="overdue_notices" value="1" checked
                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="overdue_notices" class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} text-sm font-medium text-gray-700">
                        {{ __('crm.overdue_notices') }}
                    </label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="tax_exempt" id="tax_exempt" value="1"
                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="tax_exempt" class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} text-sm font-medium text-gray-700">
                        {{ __('crm.tax_exempt') }}
                    </label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="separate_invoices" id="separate_invoices" value="1"
                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="separate_invoices" class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} text-sm font-medium text-gray-700">
                        {{ __('crm.separate_invoices') }}
                    </label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="disable_cc_processing" id="disable_cc_processing" value="1"
                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="disable_cc_processing" class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} text-sm font-medium text-gray-700">
                        {{ __('crm.disable_cc_processing') }}
                    </label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="marketing_emails_opt_in" id="marketing_emails_opt_in" value="1"
                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="marketing_emails_opt_in" class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} text-sm font-medium text-gray-700">
                        {{ __('crm.marketing_emails_opt_in') }}
                    </label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="status_update" id="status_update" value="1" checked
                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="status_update" class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} text-sm font-medium text-gray-700">
                        {{ __('crm.status_update') }}
                    </label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="allow_sso" id="allow_sso" value="1"
                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="allow_sso" class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} text-sm font-medium text-gray-700">
                        {{ __('crm.allow_single_sign_on') }}
                    </label>
                </div>
            </div>
        </div>

        <!-- Owner -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-pink-600 to-pink-500 px-6 py-4">
                <h2 class="text-lg font-semibold text-white flex items-center">
                    <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                    </svg>
                    {{ __('crm.owner') }}
                </h2>
            </div>
            
            <div class="p-6 space-y-4">
                <div class="flex items-center space-x-4 {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }}">
                    <input type="radio" name="owner_type" id="owner_new" value="new" checked
                           class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                    <label for="owner_new" class="text-sm font-medium text-gray-700">
                        {{ __('crm.create_new_user') }}
                    </label>
                </div>

                <div class="flex items-center space-x-4 {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }}">
                    <input type="radio" name="owner_type" id="owner_existing" value="existing"
                           class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                    <label for="owner_existing" class="text-sm font-medium text-gray-700">
                        {{ __('crm.associate_existing_user') }}
                    </label>
                </div>

                <div id="existing_user_select" class="hidden">
                    <label for="existing_user_id" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('crm.select_existing_user') }}
                    </label>
                    <select name="existing_user_id" id="existing_user_id"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">{{ __('crm.select_user') }}</option>
                        <!-- Users will be populated here -->
                    </select>
                </div>
            </div>
        </div>

        <!-- Admin Notes -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-teal-600 to-teal-500 px-6 py-4">
                <h2 class="text-lg font-semibold text-white flex items-center">
                    <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                    </svg>
                    {{ __('crm.admin_notes') }}
                </h2>
            </div>
            
            <div class="p-6">
                <textarea name="admin_notes" id="admin_notes" rows="4"
                          class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                          placeholder="{{ __('crm.admin_notes_placeholder') }}">{{ old('admin_notes') }}</textarea>
            </div>
        </div>

        <!-- Send Welcome Email -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-6">
                <div class="flex items-start">
                    <input type="checkbox" name="send_welcome_email" id="send_welcome_email" value="1" checked
                           class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="send_welcome_email" class="{{ app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3' }} text-sm">
                        <span class="font-medium text-gray-900">{{ __('crm.send_welcome_email') }}</span>
                        <p class="text-gray-600">{{ __('crm.send_welcome_email_desc') }}</p>
                    </label>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end space-x-4 {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }}">
            <a href="{{ route('admin.clients.index') }}" 
               class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200">
                {{ __('crm.cancel') }}
            </a>
            <button type="submit" 
                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                <span class="flex items-center">
                    <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/>
                    </svg>
                    {{ __('crm.create_client') }}
                </span>
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Translations
    const translations = {
        firstLastNameRequired: '{{ __("crm.first_last_name_required") }}',
        invalidEmail: '{{ __("crm.invalid_email") }}',
        emailAlreadyExists: '{{ __("crm.email_already_exists") }}',
        sending: '{{ __("crm.sending") }}',
        sendVerificationCode: '{{ __("crm.send_verification_code") }}',
        enterVerificationCode: '{{ __("crm.enter_verification_code") }}',
        otpSendFailed: '{{ __("crm.otp_send_failed") }}',
        invalidOrExpiredOtp: '{{ __("crm.invalid_or_expired_otp") }}',
        emailNotVerified: '{{ __("crm.email_not_verified") }}',
        passwordCopied: '{{ __("crm.password_copied") }}',
        showPassword: '{{ __("crm.show_password") }}',
        hidePassword: '{{ __("crm.hide_password") }}',
        notEntered: '{{ __("crm.not_entered") }}',
        veryWeak: '{{ __("crm.very_weak") }}',
        weak: '{{ __("crm.weak") }}',
        medium: '{{ __("crm.medium") }}',
        strong: '{{ __("crm.strong") }}',
        veryStrong: '{{ __("crm.very_strong") }}',
        checkingPasswordSecurity: '{{ __("crm.checking_password_security") }}',
        passwordIsCompromised: '{{ __("crm.password_is_compromised") }}',
        invalid_phone: '{{ __("crm.invalid_phone") }}',
        invalid_phone_format: '{{ __("crm.invalid_phone_format") }}',
        phone_available: '{{ __("crm.phone_available") }}',
        phone_already_exists: '{{ __("crm.phone_already_exists") }}',
        checking_phone: '{{ __("crm.checking_phone") }}',
        enter_phone_number: '{{ __("crm.enter_phone_number") }}',
        country_auto_detected: '{{ __("crm.country_auto_detected") }}',
        no_results: '{{ __("crm.no_results") }}'
    };
    
    // Get form inputs
    const usernameInput = document.getElementById('username');
    const firstNameInput = document.getElementById('first_name');
    const lastNameInput = document.getElementById('last_name');
    
    // Password functionality
    const passwordInput = document.getElementById('password');
    const togglePasswordBtn = document.getElementById('toggle-password');
    const eyeIcon = document.getElementById('eye-icon');
    const eyeSlashIcon = document.getElementById('eye-slash-icon');
    const generatePasswordBtn = document.getElementById('generate-password');
    
    // Toggle password visibility
    if (togglePasswordBtn) {
        togglePasswordBtn.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            if (type === 'text') {
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
                togglePasswordBtn.setAttribute('title', translations.hidePassword);
            } else {
                eyeIcon.classList.remove('hidden');
                eyeSlashIcon.classList.add('hidden');
                togglePasswordBtn.setAttribute('title', translations.showPassword);
            }
        });
    }
    
    // Password validation and strength checker
    function validatePassword(password) {
        // Get personal information
        const username = usernameInput.value.toLowerCase();
        const firstName = firstNameInput.value.toLowerCase();
        const lastName = lastNameInput.value.toLowerCase();
        const passwordLower = password.toLowerCase();
        
        // Check if password contains personal info
        let containsPersonalInfo = false;
        if (username && username.length >= 3 && passwordLower.includes(username)) {
            containsPersonalInfo = true;
        }
        if (firstName && firstName.length >= 3 && passwordLower.includes(firstName)) {
            containsPersonalInfo = true;
        }
        if (lastName && lastName.length >= 3 && passwordLower.includes(lastName)) {
            containsPersonalInfo = true;
        }
        
        const requirements = {
            length: password.length >= 8,
            uppercase: /[A-Z]/.test(password),
            lowercase: /[a-z]/.test(password),
            special: /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password),
            number: /\d/.test(password),
            noArabic: !/[\u0600-\u06FF]/.test(password),
            noSpaces: !/\s/.test(password),
            noPersonalInfo: !containsPersonalInfo
        };
        
        // Update requirements checklist - show only if NOT met, hide if met
        const reqLength = document.getElementById('req-length');
        const reqUppercase = document.getElementById('req-uppercase');
        const reqLowercase = document.getElementById('req-lowercase');
        const reqSpecial = document.getElementById('req-special');
        const reqNumber = document.getElementById('req-number');
        const reqNoArabic = document.getElementById('req-no-arabic');
        const reqNoPersonal = document.getElementById('req-no-personal');
        
        if (requirements.length) {
            reqLength.classList.add('hidden');
        } else {
            reqLength.classList.remove('hidden');
            reqLength.className = 'flex items-center gap-2 text-red-500';
        }
        
        if (requirements.uppercase) {
            reqUppercase.classList.add('hidden');
        } else {
            reqUppercase.classList.remove('hidden');
            reqUppercase.className = 'flex items-center gap-2 text-red-500';
        }
        
        if (requirements.lowercase) {
            reqLowercase.classList.add('hidden');
        } else {
            reqLowercase.classList.remove('hidden');
            reqLowercase.className = 'flex items-center gap-2 text-red-500';
        }
        
        if (requirements.special) {
            reqSpecial.classList.add('hidden');
        } else {
            reqSpecial.classList.remove('hidden');
            reqSpecial.className = 'flex items-center gap-2 text-red-500';
        }
        
        if (requirements.number) {
            reqNumber.classList.add('hidden');
        } else {
            reqNumber.classList.remove('hidden');
            reqNumber.className = 'flex items-center gap-2 text-red-500';
        }
        
        if (requirements.noArabic && requirements.noSpaces) {
            reqNoArabic.classList.add('hidden');
        } else {
            reqNoArabic.classList.remove('hidden');
            reqNoArabic.className = 'flex items-center gap-2 text-red-500';
        }
        
        if (requirements.noPersonalInfo) {
            reqNoPersonal.classList.add('hidden');
        } else {
            reqNoPersonal.classList.remove('hidden');
            reqNoPersonal.className = 'flex items-center gap-2 text-red-500';
        }
        
        return requirements;
    }
    
    function calculatePasswordStrength(password) {
        if (password.length === 0) {
            return { strength: 0, label: translations.notEntered, color: 'bg-gray-200' };
        }
        
        let strength = 0;
        const requirements = validatePassword(password);
        
        // Basic checks
        if (requirements.length) strength++;
        if (requirements.uppercase) strength++;
        if (requirements.lowercase) strength++;
        if (requirements.special) strength++;
        if (requirements.number) strength++;
        if (requirements.noArabic && requirements.noSpaces) strength++;
        if (requirements.noPersonalInfo) strength++;
        
        // Additional strength factors
        if (password.length >= 12) strength++;
        if (password.length >= 16) strength++;
        if (/\d/.test(password)) strength++; // Has number
        
        // Determine label and color
        let label, color;
        if (strength <= 2) {
            label = translations.veryWeak;
            color = 'bg-red-500';
        } else if (strength <= 4) {
            label = translations.weak;
            color = 'bg-orange-500';
        } else if (strength <= 6) {
            label = translations.medium;
            color = 'bg-yellow-500';
        } else if (strength <= 7) {
            label = translations.strong;
            color = 'bg-green-500';
        } else {
            label = translations.veryStrong;
            color = 'bg-emerald-600';
        }
        
        return { strength: Math.min(strength, 8), label, color };
    }
    
    function updateStrengthMeter(password) {
        const { strength, label, color } = calculatePasswordStrength(password);
        const bars = [
            document.getElementById('strength-bar-1'),
            document.getElementById('strength-bar-2'),
            document.getElementById('strength-bar-3'),
            document.getElementById('strength-bar-4')
        ];
        
        // Update strength label
        document.getElementById('strength-label').textContent = label;
        
        // Update strength bars
        const filledBars = Math.ceil(strength / 2); // 0-4 bars
        bars.forEach((bar, index) => {
            if (index < filledBars) {
                bar.className = `h-1 flex-1 ${color} rounded transition-colors duration-300`;
            } else {
                bar.className = 'h-1 flex-1 bg-gray-200 rounded transition-colors duration-300';
            }
        });
    }
    
    // Check if password is compromised (debounced)
    let passwordCheckTimeout = null;
    function checkPasswordCompromised(password) {
        clearTimeout(passwordCheckTimeout);
        
        const compromisedWarning = document.getElementById('compromised-warning');
        
        if (password.length < 8) {
            compromisedWarning.classList.add('hidden');
            return;
        }
        
        passwordCheckTimeout = setTimeout(() => {
            fetch('{{ route("admin.clients.check-password") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ password: password })
            })
            .then(response => response.json())
            .then(data => {
                if (data.checked && data.compromised) {
                    compromisedWarning.classList.remove('hidden');
                } else {
                    compromisedWarning.classList.add('hidden');
                }
            })
            .catch(error => {
                console.error('Error checking password:', error);
                compromisedWarning.classList.add('hidden');
            });
        }, 1000); // Check after 1 second of no typing
    }
    
    // Listen to password input
    if (passwordInput) {
        passwordInput.addEventListener('input', function(e) {
            // Remove Arabic characters and spaces
            const cleanValue = e.target.value.replace(/[\u0600-\u06FF\s]/g, '');
            if (cleanValue !== e.target.value) {
                e.target.value = cleanValue;
            }
            
            updateStrengthMeter(e.target.value);
            checkPasswordCompromised(e.target.value);
        });
        
        passwordInput.addEventListener('keypress', function(e) {
            // Prevent Arabic characters and spaces
            if (/[\u0600-\u06FF\s]/.test(e.key)) {
                e.preventDefault();
            }
        });
        
        passwordInput.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedText = (e.clipboardData || window.clipboardData).getData('text');
            const cleanText = pastedText.replace(/[\u0600-\u06FF\s]/g, '');
            document.execCommand('insertText', false, cleanText);
        });
    }
    
    // Re-validate password when personal info changes
    if (usernameInput) {
        usernameInput.addEventListener('input', function() {
            if (passwordInput && passwordInput.value) {
                updateStrengthMeter(passwordInput.value);
            }
        });
    }
    
    if (firstNameInput) {
        firstNameInput.addEventListener('input', function() {
            if (passwordInput && passwordInput.value) {
                updateStrengthMeter(passwordInput.value);
            }
        });
    }
    
    if (lastNameInput) {
        lastNameInput.addEventListener('input', function() {
            if (passwordInput && passwordInput.value) {
                updateStrengthMeter(passwordInput.value);
            }
        });
    }
    
    // Generate strong password
    if (generatePasswordBtn) {
        generatePasswordBtn.addEventListener('click', function() {
            const length = 16;
            const uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            const lowercase = 'abcdefghijklmnopqrstuvwxyz';
            const numbers = '0123456789';
            const special = '!@#$%^&*()_+-=[]{}|;:,.<>?';
            
            let password = '';
            
            // Ensure at least one of each required character
            password += uppercase[Math.floor(Math.random() * uppercase.length)];
            password += lowercase[Math.floor(Math.random() * lowercase.length)];
            password += numbers[Math.floor(Math.random() * numbers.length)];
            password += special[Math.floor(Math.random() * special.length)];
            
            // Fill the rest randomly
            const allChars = uppercase + lowercase + numbers + special;
            for (let i = password.length; i < length; i++) {
                password += allChars[Math.floor(Math.random() * allChars.length)];
            }
            
            // Shuffle the password
            password = password.split('').sort(() => Math.random() - 0.5).join('');
            
            // Set the password
            passwordInput.value = password;
            passwordInput.setAttribute('type', 'text');
            eyeIcon.classList.add('hidden');
            eyeSlashIcon.classList.remove('hidden');
            
            // Update strength meter
            updateStrengthMeter(password);
            
            // Copy to clipboard
            navigator.clipboard.writeText(password).then(() => {
                showNotification(translations.passwordCopied, 'success');
            });
        });
    }
    
    // Toggle existing user select
    const ownerRadios = document.querySelectorAll('input[name="owner_type"]');
    const existingUserSelect = document.getElementById('existing_user_select');
    
    ownerRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'existing') {
                existingUserSelect.classList.remove('hidden');
            } else {
                existingUserSelect.classList.add('hidden');
            }
        });
    });
    
    // Validate username - alphanumeric, underscore, dash
    let usernameTimeout = null;
    
    // General notification function
    function showNotification(message, type = 'error') {
        const container = document.getElementById('notification-container');
        const box = document.getElementById('notification-box');
        const icon = document.getElementById('notification-icon');
        const messageEl = document.getElementById('notification-message');
        
        // Set message
        messageEl.textContent = message;
        
        // Set icon and colors based on type
        if (type === 'error') {
            box.className = 'bg-white rounded-lg shadow-lg border-l-4 border-red-500 p-4 min-w-80 max-w-md transform transition-all duration-300 ease-in-out';
            icon.innerHTML = '<svg class="h-6 w-6 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>';
        } else if (type === 'success') {
            box.className = 'bg-white rounded-lg shadow-lg border-l-4 border-green-500 p-4 min-w-80 max-w-md transform transition-all duration-300 ease-in-out';
            icon.innerHTML = '<svg class="h-6 w-6 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>';
        } else if (type === 'warning') {
            box.className = 'bg-white rounded-lg shadow-lg border-l-4 border-yellow-500 p-4 min-w-80 max-w-md transform transition-all duration-300 ease-in-out';
            icon.innerHTML = '<svg class="h-6 w-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>';
        } else {
            box.className = 'bg-white rounded-lg shadow-lg border-l-4 border-blue-500 p-4 min-w-80 max-w-md transform transition-all duration-300 ease-in-out';
            icon.innerHTML = '<svg class="h-6 w-6 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>';
        }
        
        // Show notification
        container.classList.remove('hidden');
        setTimeout(() => {
            box.classList.add('animate-slideIn');
        }, 10);
        
        // Auto hide after 5 seconds
        setTimeout(() => {
            hideNotification();
        }, 5000);
    }
    
    window.hideNotification = function() {
        const container = document.getElementById('notification-container');
        const box = document.getElementById('notification-box');
        box.classList.remove('animate-slideIn');
        setTimeout(() => {
            container.classList.add('hidden');
        }, 300);
    };
    
    // Auto-generate username function
    function generateUsername() {
        const firstName = document.getElementById('first_name').value.trim().toLowerCase();
        const lastName = document.getElementById('last_name').value.trim().toLowerCase();
        
        if (!firstName || !lastName) {
            showNotification(translations.firstLastNameRequired, 'warning');
            return;
        }
        
        // Generate username patterns
        const separators = ['_', '-'];
        const separator = separators[Math.floor(Math.random() * separators.length)];
        const randomNum = Math.floor(Math.random() * 9) + 1; // 1-9
        
        // Create username: firstname_lastname or firstname-lastname
        let username = `${firstName}${separator}${lastName}`;
        
        // Limit to 9 characters max
        if (username.length > 9) {
            // Try first 4 chars of first name + separator + first 4 of last name
            username = `${firstName.substring(0, 4)}${separator}${lastName.substring(0, 3)}`;
        }
        
        // If still too long, use initials
        if (username.length > 9) {
            username = `${firstName.charAt(0)}${lastName}${randomNum}`;
            if (username.length > 9) {
                username = username.substring(0, 9);
            }
        }
        
        // If less than 6 characters, add random number
        if (username.length < 6) {
            username += randomNum;
        }
        
        // Ensure max 9 characters
        username = username.substring(0, 9);
        
        // Convert to lowercase and remove any invalid chars
        username = username.toLowerCase().replace(/[^a-z0-9_-]/g, '');
        
        // Remove 3+ consecutive repeating characters (allow 2)
        username = username.replace(/(.)\1{2,}/g, '$1$1');
        
        // Set the username
        document.getElementById('username').value = username;
        
        // Trigger validation
        document.getElementById('username').dispatchEvent(new Event('input'));
    }
    
    // Attach auto-generate button
    document.getElementById('auto-generate-username').addEventListener('click', generateUsername);
    
    // Auto-generate on first/last name blur if username is empty
    document.getElementById('first_name').addEventListener('blur', function() {
        const usernameField = document.getElementById('username');
        if (!usernameField.value && this.value && document.getElementById('last_name').value) {
            generateUsername();
        }
    });
    
    document.getElementById('last_name').addEventListener('blur', function() {
        const usernameField = document.getElementById('username');
        if (!usernameField.value && this.value && document.getElementById('first_name').value) {
            generateUsername();
        }
    });
    
    function validateUsername(input) {
        input.addEventListener('input', function() {
            // Convert to lowercase automatically
            let value = this.value.toLowerCase();
            
            // Remove any invalid characters
            value = value.replace(/[^a-z0-9_-]/g, '');
            
            // Remove 3+ consecutive repeating characters (allow 2)
            value = value.replace(/(.)\1{2,}/g, '$1$1');
            
            this.value = value;
            
            // Clear previous timeout
            if (usernameTimeout) {
                clearTimeout(usernameTimeout);
            }
            
            const username = this.value;
            const spinner = document.getElementById('username-spinner');
            const successIcon = document.getElementById('username-success');
            const errorIcon = document.getElementById('username-error');
            const messageElement = document.getElementById('username-message');
            
            // Hide all icons
            spinner.classList.add('hidden');
            successIcon.classList.add('hidden');
            errorIcon.classList.add('hidden');
            
            // Reset border color
            this.classList.remove('border-red-500', 'border-green-500');
            this.classList.add('border-gray-300');
            
            // Check minimum length
            if (username.length < 6 && username.length > 0) {
                messageElement.textContent = '{{ __("crm.username_min_length") }}';
                messageElement.classList.remove('text-gray-500', 'text-green-600');
                messageElement.classList.add('text-red-600');
                this.classList.remove('border-gray-300');
                this.classList.add('border-red-500');
                errorIcon.classList.remove('hidden');
                return;
            }
            
            // If valid length, check availability
            if (username.length >= 6) {
                spinner.classList.remove('hidden');
                messageElement.textContent = '{{ __("crm.checking_username") }}';
                messageElement.classList.remove('text-red-600', 'text-green-600');
                messageElement.classList.add('text-gray-500');
                
                // AJAX check after 500ms delay
                usernameTimeout = setTimeout(() => {
                    fetch('{{ route("admin.clients.check-username") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ username: username })
                    })
                    .then(response => response.json())
                    .then(data => {
                        spinner.classList.add('hidden');
                        
                        if (data.available) {
                            successIcon.classList.remove('hidden');
                            messageElement.textContent = data.message;
                            messageElement.classList.remove('text-gray-500', 'text-red-600');
                            messageElement.classList.add('text-green-600');
                            input.classList.remove('border-gray-300', 'border-red-500');
                            input.classList.add('border-green-500');
                        } else {
                            errorIcon.classList.remove('hidden');
                            messageElement.textContent = data.message;
                            messageElement.classList.remove('text-gray-500', 'text-green-600');
                            messageElement.classList.add('text-red-600');
                            input.classList.remove('border-gray-300', 'border-green-500');
                            input.classList.add('border-red-500');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        spinner.classList.add('hidden');
                    });
                }, 500);
            } else {
                messageElement.textContent = '{{ __("crm.username_hint") }}';
                messageElement.classList.remove('text-red-600', 'text-green-600');
                messageElement.classList.add('text-gray-500');
            }
        });
        
        input.addEventListener('keypress', function(e) {
            // Prevent typing invalid characters
            const char = String.fromCharCode(e.which);
            if (!/[a-z0-9_-]/.test(char)) {
                e.preventDefault();
                
                // Show visual feedback
                this.classList.add('border-red-500', 'shake');
                setTimeout(() => {
                    this.classList.remove('border-red-500', 'shake');
                    this.classList.add('border-gray-300');
                }, 500);
                return;
            }
            
            // Prevent 3+ consecutive repeating characters (allow 2)
            const lastTwoChars = this.value.slice(-2);
            if (lastTwoChars.length === 2 && lastTwoChars[0] === lastTwoChars[1] && lastTwoChars[0] === char) {
                e.preventDefault();
                
                // Show visual feedback
                this.classList.add('border-red-500', 'shake');
                setTimeout(() => {
                    this.classList.remove('border-red-500', 'shake');
                    this.classList.add('border-gray-300');
                }, 500);
            }
        });
    }
    
    function validateEnglishLetters(input) {
        input.addEventListener('input', function() {
            // Remove any non-English letters and non-space characters
            this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
        });
        
        input.addEventListener('keypress', function(e) {
            // Prevent typing non-English letters
            const char = String.fromCharCode(e.which);
            if (!/[a-zA-Z\s]/.test(char)) {
                e.preventDefault();
                
                // Show visual feedback
                this.classList.add('border-red-500', 'shake');
                setTimeout(() => {
                    this.classList.remove('border-red-500', 'shake');
                }, 500);
            }
        });
    }
    
    function validateEmail(input) {
        input.addEventListener('input', function() {
            // Remove Arabic characters, spaces, and invalid email characters
            this.value = this.value.replace(/[\u0600-\u06FF\s]/g, '');
        });
        
        input.addEventListener('keypress', function(e) {
            const char = String.fromCharCode(e.which);
            // Prevent Arabic characters and spaces
            if (/[\u0600-\u06FF\s]/.test(char)) {
                e.preventDefault();
                
                // Show visual feedback
                this.classList.add('border-red-500', 'shake');
                setTimeout(() => {
                    this.classList.remove('border-red-500', 'shake');
                }, 500);
            }
        });
        
        input.addEventListener('paste', function(e) {
            // Get pasted data
            const pastedData = (e.clipboardData || window.clipboardData).getData('text');
            
            // Check if contains Arabic or spaces
            if (/[\u0600-\u06FF\s]/.test(pastedData)) {
                e.preventDefault();
                
                // Show visual feedback
                this.classList.add('border-red-500', 'shake');
                setTimeout(() => {
                    this.classList.remove('border-red-500', 'shake');
                }, 500);
            }
        });
    }
    
    validateUsername(usernameInput);
    validateEnglishLetters(firstNameInput);
    validateEnglishLetters(lastNameInput);
    
    // ============================================
    // EMAIL VERIFICATION (OTP) FUNCTIONALITY
    // ============================================
    
    const emailInput = document.getElementById('email');
    validateEmail(emailInput); // Apply email validation
    const sendOtpBtn = document.getElementById('send-otp-btn');
    const sendOtpText = document.getElementById('send-otp-text');
    const otpSection = document.getElementById('otp-verification-section');
    const otpCodeInput = document.getElementById('otp-code');
    const verifyOtpBtn = document.getElementById('verify-otp-btn');
    const resendOtpBtn = document.getElementById('resend-otp-btn');
    const emailMessage = document.getElementById('email-message');
    const emailVerifyStatus = document.getElementById('email-verify-status');
    const emailVerifiedIcon = document.getElementById('email-verified-icon');
    const otpVerifySpinner = document.getElementById('otp-verify-spinner');
    const emailVerifiedInput = document.getElementById('email-verified-input');
    const otpCountdown = document.getElementById('otp-countdown');
    
    let countdownInterval = null;
    let countdownSeconds = 600; // 10 minutes
    let emailCheckTimeout = null;
    
    // Check if there's an active OTP session on page load
    function checkActiveOtpSession() {
        const email = emailInput.value.trim();
        if (email) {
            const otpSentTime = localStorage.getItem('otp_sent_at_' + email);
            if (otpSentTime) {
                const elapsedSeconds = Math.floor((Date.now() - parseInt(otpSentTime)) / 1000);
                const remainingSeconds = 600 - elapsedSeconds;
                
                // If still within 10 minutes
                if (remainingSeconds > 0) {
                    otpSection.classList.remove('hidden');
                    sendOtpBtn.classList.add('hidden');
                    startCountdown();
                } else {
                    // Expired, clear localStorage
                    localStorage.removeItem('otp_sent_at_' + email);
                }
            }
        }
    }
    
    // Check on page load
    window.addEventListener('DOMContentLoaded', checkActiveOtpSession);
    
    // Real-time email availability check
    emailInput.addEventListener('input', function() {
        const email = this.value.trim();
        
        // Clear previous timeout
        if (emailCheckTimeout) {
            clearTimeout(emailCheckTimeout);
        }
        
        // Clear previous message if email is being modified
        if (email.length > 0 && emailVerifiedInput.value === '1') {
            emailVerifiedInput.value = '0';
            emailMessage.classList.add('hidden');
            sendOtpBtn.classList.remove('hidden');
            otpSection.classList.add('hidden');
        }
        
        // Check email after user stops typing (500ms delay)
        if (email.length > 0 && isValidEmail(email)) {
            emailCheckTimeout = setTimeout(() => {
                checkEmailAvailability(email);
            }, 500);
        }
    });
    
    function checkEmailAvailability(email) {
        fetch('{{ route("admin.clients.check-email") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ email: email })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.available) {
                showEmailMessage('{{ __("crm.email_already_exists") }}', 'error');
                sendOtpBtn.disabled = true;
            } else {
                emailMessage.classList.add('hidden');
                sendOtpBtn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error checking email:', error);
        });
    }
    
    // Send OTP
    sendOtpBtn.addEventListener('click', function() {
        const email = emailInput.value.trim();
        
        if (!email || !isValidEmail(email)) {
            showEmailMessage('{{ __("crm.invalid_email") }}', 'error');
            return;
        }
        
        // Disable button and show loading
        sendOtpBtn.disabled = true;
        sendOtpText.textContent = '{{ __("crm.sending") }}';
        
        fetch('{{ route("admin.clients.send-otp") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ email: email })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showEmailMessage(data.message, 'success');
                otpSection.classList.remove('hidden');
                sendOtpBtn.classList.add('hidden');
                
                // Store OTP send time in localStorage
                const otpSentTime = Date.now();
                localStorage.setItem('otp_sent_at_' + email, otpSentTime);
                
                startCountdown();
            } else {
                // Check if there's a cooldown error with remaining seconds
                if (data.remaining_seconds) {
                    // Store the cooldown info and start countdown
                    const otpSentTime = Date.now() - ((600 - data.remaining_seconds) * 1000);
                    localStorage.setItem('otp_sent_at_' + email, otpSentTime);
                    
                    // Show OTP section if it was already sent
                    otpSection.classList.remove('hidden');
                    sendOtpBtn.classList.add('hidden');
                    startCountdown();
                }
                
                showEmailMessage(data.message, 'error');
                sendOtpBtn.disabled = false;
                sendOtpText.textContent = '{{ __("crm.send_verification_code") }}';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showEmailMessage('{{ __("crm.otp_send_failed") }}', 'error');
            sendOtpBtn.disabled = false;
            sendOtpText.textContent = '{{ __("crm.send_verification_code") }}';
        });
    });
    
    // Verify OTP
    verifyOtpBtn.addEventListener('click', function() {
        const email = emailInput.value.trim();
        const otp = otpCodeInput.value.trim();
        
        if (!otp || otp.length !== 6) {
            showEmailMessage('{{ __("crm.enter_verification_code") }}', 'error');
            return;
        }
        
        // Show loading spinner
        otpVerifySpinner.classList.remove('hidden');
        verifyOtpBtn.disabled = true;
        
        fetch('{{ route("admin.clients.verify-otp") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ email: email, otp: otp })
        })
        .then(response => response.json())
        .then(data => {
            otpVerifySpinner.classList.add('hidden');
            verifyOtpBtn.disabled = false;
            
            if (data.success) {
                showEmailMessage(data.message, 'success');
                emailVerifyStatus.classList.remove('hidden');
                emailVerifiedIcon.classList.remove('hidden');
                emailInput.classList.add('border-green-500');
                emailVerifiedInput.value = '1';
                otpSection.classList.add('hidden');
                emailInput.readOnly = true;
                clearInterval(countdownInterval);
                
                // Clear localStorage after successful verification
                localStorage.removeItem('otp_sent_at_' + email);
                
                // Lock the email field
                emailInput.classList.add('bg-gray-100');
            } else {
                showEmailMessage(data.message, 'error');
                otpCodeInput.classList.add('border-red-500', 'shake');
                setTimeout(() => {
                    otpCodeInput.classList.remove('border-red-500', 'shake');
                }, 500);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            otpVerifySpinner.classList.add('hidden');
            verifyOtpBtn.disabled = false;
            showEmailMessage('{{ __("crm.invalid_or_expired_otp") }}', 'error');
        });
    });
    
    // Resend OTP
    resendOtpBtn.addEventListener('click', function() {
        const email = emailInput.value.trim();
        const otpSentTime = localStorage.getItem('otp_sent_at_' + email);
        
        if (otpSentTime) {
            const elapsedSeconds = Math.floor((Date.now() - parseInt(otpSentTime)) / 1000);
            const remainingSeconds = 600 - elapsedSeconds;
            
            if (remainingSeconds > 0) {
                const remainingMinutes = Math.ceil(remainingSeconds / 60);
                showEmailMessage('{{ __("crm.otp_cooldown", ["minutes" => ""]) }}'.replace(':minutes', remainingMinutes), 'error');
                return;
            }
        }
        
        otpCodeInput.value = '';
        clearInterval(countdownInterval);
        
        // Clear old data
        localStorage.removeItem('otp_sent_at_' + email);
        
        // Reset UI
        otpSection.classList.add('hidden');
        sendOtpBtn.classList.remove('hidden');
        sendOtpBtn.disabled = false;
        
        // Trigger send OTP
        sendOtpBtn.click();
    });
    
    // OTP Input - only numbers and auto-submit
    otpCodeInput.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '').substring(0, 6);
        
        // Auto verify when 6 digits entered
        if (this.value.length === 6) {
            verifyOtpBtn.click();
        }
    });
    
    // Helper Functions
    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }
    
    function showEmailMessage(message, type) {
        emailMessage.textContent = message;
        emailMessage.classList.remove('text-gray-500', 'text-green-600', 'text-red-600');
        
        if (type === 'success') {
            emailMessage.classList.add('text-green-600');
        } else if (type === 'error') {
            emailMessage.classList.add('text-red-600');
        } else {
            emailMessage.classList.add('text-gray-500');
        }
    }
    
    function startCountdown() {
        const email = emailInput.value.trim();
        const otpSentTime = localStorage.getItem('otp_sent_at_' + email);
        
        if (otpSentTime) {
            // Calculate remaining seconds
            const elapsedSeconds = Math.floor((Date.now() - parseInt(otpSentTime)) / 1000);
            countdownSeconds = Math.max(0, 600 - elapsedSeconds); // 600 seconds = 10 minutes
        } else {
            countdownSeconds = 600; // Default to 10 minutes
        }
        
        // Clear any existing interval
        if (countdownInterval) {
            clearInterval(countdownInterval);
        }
        
        // Update countdown every second
        countdownInterval = setInterval(() => {
            countdownSeconds--;
            
            const minutes = Math.floor(countdownSeconds / 60);
            const seconds = countdownSeconds % 60;
            
            otpCountdown.textContent = `⏰ ${minutes}:${seconds.toString().padStart(2, '0')}`;
            
            if (countdownSeconds <= 0) {
                clearInterval(countdownInterval);
                otpCountdown.textContent = '{{ __("crm.invalid_or_expired_otp") }}';
                otpCountdown.classList.add('text-red-600');
                
                // Clear localStorage
                localStorage.removeItem('otp_sent_at_' + email);
            }
        }, 1000);
        
        // Initial display
        const minutes = Math.floor(countdownSeconds / 60);
        const seconds = countdownSeconds % 60;
        otpCountdown.textContent = `⏰ ${minutes}:${seconds.toString().padStart(2, '0')}`;
    }
    
    // Prevent form submission if email not verified
    document.querySelector('form').addEventListener('submit', function(e) {
        const emailVerified = emailVerifiedInput.value;
        
        if (emailVerified !== '1') {
            e.preventDefault();
            showEmailMessage('{{ __("crm.email_not_verified") }}', 'error');
            emailInput.classList.add('border-red-500', 'shake');
            setTimeout(() => {
                emailInput.classList.remove('border-red-500', 'shake');
            }, 500);
            
            // Scroll to email field
            emailInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });

    // ===== Phone Number Validation =====
    const phoneInput = document.getElementById('phone');
    const countryCodeInput = document.getElementById('country_code');
    const phoneSpinner = document.getElementById('phone-spinner');
    const phoneSuccess = document.getElementById('phone-success');
    const phoneError = document.getElementById('phone-error');
    const phoneMessage = document.getElementById('phone-message');
    const countriesList = document.getElementById('countries-list');
    const countrySearch = document.getElementById('country-search');
    
    let phoneCheckTimeout;
    let isPhoneAvailable = false;

    // Comprehensive list of countries with dial codes and flags
    const countries = [
        { code: 'AF', dial: '+93', name: 'Afghanistan / أفغانستان', flag: '🇦🇫' },
        { code: 'AL', dial: '+355', name: 'Albania / ألبانيا', flag: '🇦🇱' },
        { code: 'DZ', dial: '+213', name: 'Algeria / الجزائر', flag: '🇩🇿' },
        { code: 'AS', dial: '+1-684', name: 'American Samoa / ساموا الأمريكية', flag: '🇦🇸' },
        { code: 'AD', dial: '+376', name: 'Andorra / أندورا', flag: '🇦🇩' },
        { code: 'AO', dial: '+244', name: 'Angola / أنغولا', flag: '🇦🇴' },
        { code: 'AI', dial: '+1-264', name: 'Anguilla / أنغويلا', flag: '🇦🇮' },
        { code: 'AQ', dial: '+672', name: 'Antarctica / القارة القطبية', flag: '🇦🇶' },
        { code: 'AG', dial: '+1-268', name: 'Antigua and Barbuda / أنتيغوا', flag: '🇦🇬' },
        { code: 'AR', dial: '+54', name: 'Argentina / الأرجنتين', flag: '🇦🇷' },
        { code: 'AM', dial: '+374', name: 'Armenia / أرمينيا', flag: '🇦🇲' },
        { code: 'AW', dial: '+297', name: 'Aruba / أروبا', flag: '🇦🇼' },
        { code: 'AU', dial: '+61', name: 'Australia / أستراليا', flag: '🇦🇺' },
        { code: 'AT', dial: '+43', name: 'Austria / النمسا', flag: '🇦🇹' },
        { code: 'AZ', dial: '+994', name: 'Azerbaijan / أذربيجان', flag: '🇦🇿' },
        { code: 'BS', dial: '+1-242', name: 'Bahamas / الباهاما', flag: '🇧🇸' },
        { code: 'BH', dial: '+973', name: 'Bahrain / البحرين', flag: '🇧🇭' },
        { code: 'BD', dial: '+880', name: 'Bangladesh / بنغلاديش', flag: '🇧🇩' },
        { code: 'BB', dial: '+1-246', name: 'Barbados / بربادوس', flag: '🇧🇧' },
        { code: 'BY', dial: '+375', name: 'Belarus / بيلاروسيا', flag: '🇧🇾' },
        { code: 'BE', dial: '+32', name: 'Belgium / بلجيكا', flag: '🇧🇪' },
        { code: 'BZ', dial: '+501', name: 'Belize / بليز', flag: '🇧🇿' },
        { code: 'BJ', dial: '+229', name: 'Benin / بنين', flag: '🇧🇯' },
        { code: 'BM', dial: '+1-441', name: 'Bermuda / برمودا', flag: '🇧🇲' },
        { code: 'BT', dial: '+975', name: 'Bhutan / بوتان', flag: '🇧🇹' },
        { code: 'BO', dial: '+591', name: 'Bolivia / بوليفيا', flag: '🇧🇴' },
        { code: 'BA', dial: '+387', name: 'Bosnia and Herzegovina / البوسنة', flag: '🇧🇦' },
        { code: 'BW', dial: '+267', name: 'Botswana / بوتسوانا', flag: '🇧🇼' },
        { code: 'BR', dial: '+55', name: 'Brazil / البرازيل', flag: '🇧🇷' },
        { code: 'BN', dial: '+673', name: 'Brunei / بروناي', flag: '🇧🇳' },
        { code: 'BG', dial: '+359', name: 'Bulgaria / بلغاريا', flag: '🇧🇬' },
        { code: 'BF', dial: '+226', name: 'Burkina Faso / بوركينا فاسو', flag: '🇧🇫' },
        { code: 'BI', dial: '+257', name: 'Burundi / بوروندي', flag: '🇧🇮' },
        { code: 'KH', dial: '+855', name: 'Cambodia / كمبوديا', flag: '🇰🇭' },
        { code: 'CM', dial: '+237', name: 'Cameroon / الكاميرون', flag: '🇨🇲' },
        { code: 'CA', dial: '+1', name: 'Canada / كندا', flag: '🇨🇦' },
        { code: 'CV', dial: '+238', name: 'Cape Verde / الرأس الأخضر', flag: '🇨🇻' },
        { code: 'KY', dial: '+1-345', name: 'Cayman Islands / جزر كايمان', flag: '🇰🇾' },
        { code: 'CF', dial: '+236', name: 'Central African Republic / أفريقيا الوسطى', flag: '🇨🇫' },
        { code: 'TD', dial: '+235', name: 'Chad / تشاد', flag: '🇹🇩' },
        { code: 'CL', dial: '+56', name: 'Chile / تشيلي', flag: '🇨🇱' },
        { code: 'CN', dial: '+86', name: 'China / الصين', flag: '🇨🇳' },
        { code: 'CO', dial: '+57', name: 'Colombia / كولومبيا', flag: '🇨🇴' },
        { code: 'KM', dial: '+269', name: 'Comoros / جزر القمر', flag: '🇰🇲' },
        { code: 'CG', dial: '+242', name: 'Congo / الكونغو', flag: '🇨🇬' },
        { code: 'CD', dial: '+243', name: 'Congo (DRC) / الكونغو الديمقراطية', flag: '🇨🇩' },
        { code: 'CK', dial: '+682', name: 'Cook Islands / جزر كوك', flag: '🇨🇰' },
        { code: 'CR', dial: '+506', name: 'Costa Rica / كوستاريكا', flag: '🇨🇷' },
        { code: 'HR', dial: '+385', name: 'Croatia / كرواتيا', flag: '🇭🇷' },
        { code: 'CU', dial: '+53', name: 'Cuba / كوبا', flag: '🇨🇺' },
        { code: 'CY', dial: '+357', name: 'Cyprus / قبرص', flag: '🇨🇾' },
        { code: 'CZ', dial: '+420', name: 'Czech Republic / التشيك', flag: '🇨🇿' },
        { code: 'DK', dial: '+45', name: 'Denmark / الدنمارك', flag: '🇩🇰' },
        { code: 'DJ', dial: '+253', name: 'Djibouti / جيبوتي', flag: '🇩🇯' },
        { code: 'DM', dial: '+1-767', name: 'Dominica / دومينيكا', flag: '🇩🇲' },
        { code: 'DO', dial: '+1-809', name: 'Dominican Republic / الدومينيكان', flag: '🇩🇴' },
        { code: 'EC', dial: '+593', name: 'Ecuador / الإكوادور', flag: '🇪🇨' },
        { code: 'EG', dial: '+20', name: 'Egypt / مصر', flag: '🇪🇬' },
        { code: 'SV', dial: '+503', name: 'El Salvador / السلفادور', flag: '🇸🇻' },
        { code: 'GQ', dial: '+240', name: 'Equatorial Guinea / غينيا الاستوائية', flag: '🇬🇶' },
        { code: 'ER', dial: '+291', name: 'Eritrea / إريتريا', flag: '🇪🇷' },
        { code: 'EE', dial: '+372', name: 'Estonia / إستونيا', flag: '🇪🇪' },
        { code: 'ET', dial: '+251', name: 'Ethiopia / إثيوبيا', flag: '🇪🇹' },
        { code: 'FJ', dial: '+679', name: 'Fiji / فيجي', flag: '🇫🇯' },
        { code: 'FI', dial: '+358', name: 'Finland / فنلندا', flag: '🇫🇮' },
        { code: 'FR', dial: '+33', name: 'France / فرنسا', flag: '🇫🇷' },
        { code: 'GA', dial: '+241', name: 'Gabon / الغابون', flag: '🇬🇦' },
        { code: 'GM', dial: '+220', name: 'Gambia / غامبيا', flag: '🇬🇲' },
        { code: 'GE', dial: '+995', name: 'Georgia / جورجيا', flag: '🇬🇪' },
        { code: 'DE', dial: '+49', name: 'Germany / ألمانيا', flag: '🇩🇪' },
        { code: 'GH', dial: '+233', name: 'Ghana / غانا', flag: '🇬🇭' },
        { code: 'GR', dial: '+30', name: 'Greece / اليونان', flag: '🇬🇷' },
        { code: 'GL', dial: '+299', name: 'Greenland / جرينلاند', flag: '🇬🇱' },
        { code: 'GD', dial: '+1-473', name: 'Grenada / غرينادا', flag: '🇬🇩' },
        { code: 'GU', dial: '+1-671', name: 'Guam / غوام', flag: '🇬🇺' },
        { code: 'GT', dial: '+502', name: 'Guatemala / غواتيمالا', flag: '🇬🇹' },
        { code: 'GN', dial: '+224', name: 'Guinea / غينيا', flag: '🇬🇳' },
        { code: 'GW', dial: '+245', name: 'Guinea-Bissau / غينيا بيساو', flag: '🇬🇼' },
        { code: 'GY', dial: '+592', name: 'Guyana / غيانا', flag: '🇬🇾' },
        { code: 'HT', dial: '+509', name: 'Haiti / هايتي', flag: '🇭🇹' },
        { code: 'HN', dial: '+504', name: 'Honduras / هندوراس', flag: '🇭🇳' },
        { code: 'HK', dial: '+852', name: 'Hong Kong / هونغ كونغ', flag: '🇭🇰' },
        { code: 'HU', dial: '+36', name: 'Hungary / المجر', flag: '🇭🇺' },
        { code: 'IS', dial: '+354', name: 'Iceland / آيسلندا', flag: '🇮🇸' },
        { code: 'IN', dial: '+91', name: 'India / الهند', flag: '🇮🇳' },
        { code: 'ID', dial: '+62', name: 'Indonesia / إندونيسيا', flag: '🇮🇩' },
        { code: 'IR', dial: '+98', name: 'Iran / إيران', flag: '🇮🇷' },
        { code: 'IQ', dial: '+964', name: 'Iraq / العراق', flag: '🇮🇶' },
        { code: 'IE', dial: '+353', name: 'Ireland / أيرلندا', flag: '🇮🇪' },
        { code: 'IL', dial: '+972', name: 'Israel / إسرائيل', flag: '🇮🇱' },
        { code: 'IT', dial: '+39', name: 'Italy / إيطاليا', flag: '🇮🇹' },
        { code: 'CI', dial: '+225', name: 'Ivory Coast / ساحل العاج', flag: '🇨🇮' },
        { code: 'JM', dial: '+1-876', name: 'Jamaica / جامايكا', flag: '🇯🇲' },
        { code: 'JP', dial: '+81', name: 'Japan / اليابان', flag: '🇯🇵' },
        { code: 'JO', dial: '+962', name: 'Jordan / الأردن', flag: '🇯🇴' },
        { code: 'KZ', dial: '+7', name: 'Kazakhstan / كازاخستان', flag: '🇰🇿' },
        { code: 'KE', dial: '+254', name: 'Kenya / كينيا', flag: '🇰🇪' },
        { code: 'KI', dial: '+686', name: 'Kiribati / كيريباتي', flag: '🇰🇮' },
        { code: 'KW', dial: '+965', name: 'Kuwait / الكويت', flag: '🇰🇼' },
        { code: 'KG', dial: '+996', name: 'Kyrgyzstan / قيرغيزستان', flag: '🇰🇬' },
        { code: 'LA', dial: '+856', name: 'Laos / لاوس', flag: '🇱🇦' },
        { code: 'LV', dial: '+371', name: 'Latvia / لاتفيا', flag: '🇱🇻' },
        { code: 'LB', dial: '+961', name: 'Lebanon / لبنان', flag: '🇱🇧' },
        { code: 'LS', dial: '+266', name: 'Lesotho / ليسوتو', flag: '🇱🇸' },
        { code: 'LR', dial: '+231', name: 'Liberia / ليبيريا', flag: '🇱🇷' },
        { code: 'LY', dial: '+218', name: 'Libya / ليبيا', flag: '🇱🇾' },
        { code: 'LI', dial: '+423', name: 'Liechtenstein / ليختنشتاين', flag: '🇱🇮' },
        { code: 'LT', dial: '+370', name: 'Lithuania / ليتوانيا', flag: '🇱🇹' },
        { code: 'LU', dial: '+352', name: 'Luxembourg / لوكسمبورغ', flag: '🇱🇺' },
        { code: 'MO', dial: '+853', name: 'Macao / ماكاو', flag: '🇲🇴' },
        { code: 'MK', dial: '+389', name: 'Macedonia / مقدونيا', flag: '🇲🇰' },
        { code: 'MG', dial: '+261', name: 'Madagascar / مدغشقر', flag: '🇲🇬' },
        { code: 'MW', dial: '+265', name: 'Malawi / مالاوي', flag: '🇲🇼' },
        { code: 'MY', dial: '+60', name: 'Malaysia / ماليزيا', flag: '🇲🇾' },
        { code: 'MV', dial: '+960', name: 'Maldives / المالديف', flag: '🇲🇻' },
        { code: 'ML', dial: '+223', name: 'Mali / مالي', flag: '🇲🇱' },
        { code: 'MT', dial: '+356', name: 'Malta / مالطا', flag: '🇲🇹' },
        { code: 'MH', dial: '+692', name: 'Marshall Islands / جزر مارشال', flag: '🇲🇭' },
        { code: 'MR', dial: '+222', name: 'Mauritania / موريتانيا', flag: '🇲🇷' },
        { code: 'MU', dial: '+230', name: 'Mauritius / موريشيوس', flag: '🇲🇺' },
        { code: 'MX', dial: '+52', name: 'Mexico / المكسيك', flag: '🇲🇽' },
        { code: 'FM', dial: '+691', name: 'Micronesia / ميكرونيزيا', flag: '🇫🇲' },
        { code: 'MD', dial: '+373', name: 'Moldova / مولدوفا', flag: '🇲🇩' },
        { code: 'MC', dial: '+377', name: 'Monaco / موناكو', flag: '🇲🇨' },
        { code: 'MN', dial: '+976', name: 'Mongolia / منغوليا', flag: '🇲🇳' },
        { code: 'ME', dial: '+382', name: 'Montenegro / الجبل الأسود', flag: '🇲🇪' },
        { code: 'MA', dial: '+212', name: 'Morocco / المغرب', flag: '🇲🇦' },
        { code: 'MZ', dial: '+258', name: 'Mozambique / موزمبيق', flag: '🇲🇿' },
        { code: 'MM', dial: '+95', name: 'Myanmar / ميانمار', flag: '🇲🇲' },
        { code: 'NA', dial: '+264', name: 'Namibia / ناميبيا', flag: '🇳🇦' },
        { code: 'NR', dial: '+674', name: 'Nauru / ناورو', flag: '🇳🇷' },
        { code: 'NP', dial: '+977', name: 'Nepal / نيبال', flag: '🇳🇵' },
        { code: 'NL', dial: '+31', name: 'Netherlands / هولندا', flag: '🇳🇱' },
        { code: 'NZ', dial: '+64', name: 'New Zealand / نيوزيلندا', flag: '🇳🇿' },
        { code: 'NI', dial: '+505', name: 'Nicaragua / نيكاراغوا', flag: '🇳🇮' },
        { code: 'NE', dial: '+227', name: 'Niger / النيجر', flag: '🇳🇪' },
        { code: 'NG', dial: '+234', name: 'Nigeria / نيجيريا', flag: '🇳🇬' },
        { code: 'KP', dial: '+850', name: 'North Korea / كوريا الشمالية', flag: '🇰🇵' },
        { code: 'NO', dial: '+47', name: 'Norway / النرويج', flag: '🇳🇴' },
        { code: 'OM', dial: '+968', name: 'Oman / عُمان', flag: '🇴🇲' },
        { code: 'PK', dial: '+92', name: 'Pakistan / باكستان', flag: '🇵🇰' },
        { code: 'PW', dial: '+680', name: 'Palau / بالاو', flag: '🇵🇼' },
        { code: 'PS', dial: '+970', name: 'Palestine / فلسطين', flag: '🇵🇸' },
        { code: 'PA', dial: '+507', name: 'Panama / بنما', flag: '🇵🇦' },
        { code: 'PG', dial: '+675', name: 'Papua New Guinea / بابوا غينيا', flag: '🇵🇬' },
        { code: 'PY', dial: '+595', name: 'Paraguay / باراغواي', flag: '🇵🇾' },
        { code: 'PE', dial: '+51', name: 'Peru / بيرو', flag: '🇵🇪' },
        { code: 'PH', dial: '+63', name: 'Philippines / الفلبين', flag: '🇵🇭' },
        { code: 'PL', dial: '+48', name: 'Poland / بولندا', flag: '🇵🇱' },
        { code: 'PT', dial: '+351', name: 'Portugal / البرتغال', flag: '🇵🇹' },
        { code: 'PR', dial: '+1-787', name: 'Puerto Rico / بورتوريكو', flag: '🇵🇷' },
        { code: 'QA', dial: '+974', name: 'Qatar / قطر', flag: '🇶🇦' },
        { code: 'RO', dial: '+40', name: 'Romania / رومانيا', flag: '🇷🇴' },
        { code: 'RU', dial: '+7', name: 'Russia / روسيا', flag: '🇷🇺' },
        { code: 'RW', dial: '+250', name: 'Rwanda / رواندا', flag: '🇷🇼' },
        { code: 'WS', dial: '+685', name: 'Samoa / ساموا', flag: '🇼🇸' },
        { code: 'SM', dial: '+378', name: 'San Marino / سان مارينو', flag: '🇸🇲' },
        { code: 'ST', dial: '+239', name: 'Sao Tome and Principe / ساو تومي', flag: '🇸🇹' },
        { code: 'SA', dial: '+966', name: 'Saudi Arabia / السعودية', flag: '🇸🇦' },
        { code: 'SN', dial: '+221', name: 'Senegal / السنغال', flag: '🇸🇳' },
        { code: 'RS', dial: '+381', name: 'Serbia / صربيا', flag: '🇷🇸' },
        { code: 'SC', dial: '+248', name: 'Seychelles / سيشل', flag: '🇸🇨' },
        { code: 'SL', dial: '+232', name: 'Sierra Leone / سيراليون', flag: '🇸🇱' },
        { code: 'SG', dial: '+65', name: 'Singapore / سنغافورة', flag: '🇸🇬' },
        { code: 'SK', dial: '+421', name: 'Slovakia / سلوفاكيا', flag: '🇸🇰' },
        { code: 'SI', dial: '+386', name: 'Slovenia / سلوفينيا', flag: '🇸🇮' },
        { code: 'SB', dial: '+677', name: 'Solomon Islands / جزر سليمان', flag: '🇸🇧' },
        { code: 'SO', dial: '+252', name: 'Somalia / الصومال', flag: '🇸🇴' },
        { code: 'ZA', dial: '+27', name: 'South Africa / جنوب أفريقيا', flag: '🇿🇦' },
        { code: 'KR', dial: '+82', name: 'South Korea / كوريا الجنوبية', flag: '🇰🇷' },
        { code: 'SS', dial: '+211', name: 'South Sudan / جنوب السودان', flag: '🇸🇸' },
        { code: 'ES', dial: '+34', name: 'Spain / إسبانيا', flag: '🇪🇸' },
        { code: 'LK', dial: '+94', name: 'Sri Lanka / سريلانكا', flag: '🇱🇰' },
        { code: 'SD', dial: '+249', name: 'Sudan / السودان', flag: '🇸🇩' },
        { code: 'SR', dial: '+597', name: 'Suriname / سورينام', flag: '🇸🇷' },
        { code: 'SZ', dial: '+268', name: 'Swaziland / سوازيلاند', flag: '🇸🇿' },
        { code: 'SE', dial: '+46', name: 'Sweden / السويد', flag: '🇸🇪' },
        { code: 'CH', dial: '+41', name: 'Switzerland / سويسرا', flag: '🇨🇭' },
        { code: 'SY', dial: '+963', name: 'Syria / سوريا', flag: '🇸🇾' },
        { code: 'TW', dial: '+886', name: 'Taiwan / تايوان', flag: '🇹🇼' },
        { code: 'TJ', dial: '+992', name: 'Tajikistan / طاجيكستان', flag: '🇹🇯' },
        { code: 'TZ', dial: '+255', name: 'Tanzania / تنزانيا', flag: '🇹🇿' },
        { code: 'TH', dial: '+66', name: 'Thailand / تايلاند', flag: '🇹🇭' },
        { code: 'TG', dial: '+228', name: 'Togo / توغو', flag: '🇹🇬' },
        { code: 'TO', dial: '+676', name: 'Tonga / تونغا', flag: '🇹🇴' },
        { code: 'TT', dial: '+1-868', name: 'Trinidad and Tobago / ترينيداد', flag: '🇹🇹' },
        { code: 'TN', dial: '+216', name: 'Tunisia / تونس', flag: '🇹🇳' },
        { code: 'TR', dial: '+90', name: 'Turkey / تركيا', flag: '🇹🇷' },
        { code: 'TM', dial: '+993', name: 'Turkmenistan / تركمانستان', flag: '🇹🇲' },
        { code: 'TV', dial: '+688', name: 'Tuvalu / توفالو', flag: '🇹🇻' },
        { code: 'UG', dial: '+256', name: 'Uganda / أوغندا', flag: '🇺🇬' },
        { code: 'UA', dial: '+380', name: 'Ukraine / أوكرانيا', flag: '🇺🇦' },
        { code: 'AE', dial: '+971', name: 'United Arab Emirates / الإمارات', flag: '🇦🇪' },
        { code: 'GB', dial: '+44', name: 'United Kingdom / بريطانيا', flag: '🇬🇧' },
        { code: 'US', dial: '+1', name: 'United States / الولايات المتحدة', flag: '🇺🇸' },
        { code: 'UY', dial: '+598', name: 'Uruguay / أوروغواي', flag: '🇺🇾' },
        { code: 'UZ', dial: '+998', name: 'Uzbekistan / أوزبكستان', flag: '🇺🇿' },
        { code: 'VU', dial: '+678', name: 'Vanuatu / فانواتو', flag: '🇻🇺' },
        { code: 'VA', dial: '+379', name: 'Vatican City / الفاتيكان', flag: '🇻🇦' },
        { code: 'VE', dial: '+58', name: 'Venezuela / فنزويلا', flag: '🇻🇪' },
        { code: 'VN', dial: '+84', name: 'Vietnam / فيتنام', flag: '🇻🇳' },
        { code: 'YE', dial: '+967', name: 'Yemen / اليمن', flag: '🇾🇪' },
        { code: 'ZM', dial: '+260', name: 'Zambia / زامبيا', flag: '🇿🇲' },
        { code: 'ZW', dial: '+263', name: 'Zimbabwe / زيمبابوي', flag: '🇿🇼' }
    ];

    // Populate countries list on page load
    function populateCountries(filterText = '') {
        const filter = filterText.toLowerCase();
        const filteredCountries = countries.filter(country => 
            country.name.toLowerCase().includes(filter) || 
            country.dial.includes(filter) ||
            country.code.toLowerCase().includes(filter)
        );

        const isRTL = document.documentElement.lang === 'ar' || document.dir === 'rtl' || document.documentElement.dir === 'rtl';
        
        countriesList.innerHTML = filteredCountries.map(country => `
            <div class="px-3 sm:px-4 py-2.5 hover:bg-blue-50 active:bg-blue-100 cursor-pointer flex items-center ${isRTL ? 'flex-row-reverse' : 'flex-row'} gap-2 sm:gap-3 transition-colors duration-150 border-b border-gray-100 last:border-0" 
                 @click="selectCountry('${country.code}', '${country.dial}', \`${country.name}\`, '${country.flag}')"
                 x-on:click="selectCountry('${country.code}', '${country.dial}', \`${country.name}\`, '${country.flag}')">
                <span class="text-xl sm:text-2xl flex-shrink-0">${country.flag}</span>
                <span class="text-gray-700 flex-1 text-sm sm:text-base truncate">${country.name}</span>
                <span class="text-gray-500 text-xs sm:text-sm font-medium flex-shrink-0">${country.dial}</span>
            </div>
        `).join('');

        // Show "no results" message if no countries found
        if (filteredCountries.length === 0) {
            countriesList.innerHTML = `
                <div class="px-4 py-8 text-center text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <p>${translations.no_results || 'No results found'}</p>
                </div>
            `;
        }
    }

    // Select country function (for backwards compatibility and non-Alpine clicks)
    window.selectCountry = function(code, dial, name, flag) {
        // Get the country selector element
        const countrySelector = document.getElementById('country-selector');
        if (countrySelector && Alpine && Alpine.raw) {
            // Get Alpine data from the element
            const data = Alpine.$data(countrySelector);
            if (data && data.selectCountry) {
                // Call Alpine's selectCountry method
                data.selectCountry(code, dial, name, flag);
            }
        }
    };
    
    // Callback when country is selected
    window.onCountrySelected = function() {
        // Clear search
        if (countrySearch) {
            countrySearch.value = '';
        }
        populateCountries();
        
        // Validate phone if already entered
        if (phoneInput && phoneInput.value.trim()) {
            validatePhoneNumber();
        }
    };

    // Initialize countries list
    populateCountries();

    // Filter countries function (global scope for Alpine.js)
    window.filterCountries = function(searchText) {
        populateCountries(searchText);
    };

    // Country search functionality
    countrySearch.addEventListener('input', function() {
        populateCountries(this.value);
    });

    // Phone validation function
    function validatePhoneNumber() {
        const phone = phoneInput.value.trim();
        const countryCode = countryCodeInput.value;

        // Clear previous timeout
        if (phoneCheckTimeout) {
            clearTimeout(phoneCheckTimeout);
        }

        // Reset states
        phoneSpinner.classList.add('hidden');
        phoneSuccess.classList.add('hidden');
        phoneError.classList.add('hidden');
        phoneMessage.textContent = '';
        phoneMessage.className = 'text-sm mt-1';
        isPhoneAvailable = false;

        // Validate minimum length
        if (phone.length === 0) {
            return;
        }

        if (phone.length < 6) {
            phoneError.classList.remove('hidden');
            phoneMessage.textContent = translations.enter_phone_number;
            phoneMessage.classList.add('text-gray-500');
            return;
        }

        // Show spinner
        phoneSpinner.classList.remove('hidden');
        phoneMessage.textContent = translations.checking_phone;
        phoneMessage.classList.add('text-blue-600');

        // Debounce validation (500ms)
        phoneCheckTimeout = setTimeout(() => {
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            fetch('{{ route("admin.clients.validate-phone") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken ? csrfToken.getAttribute('content') : '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    phone: phone,
                    country_code: countryCode
                })
            })
            .then(response => response.json())
            .then(data => {
                phoneSpinner.classList.add('hidden');

                if (data.valid) {
                    // Auto-detect country if different
                    if (data.country_code && data.country_code !== countryCode) {
                        const detectedCountry = countries.find(c => c.code === data.country_code);
                        if (detectedCountry) {
                            selectCountry(
                                detectedCountry.code,
                                detectedCountry.dial,
                                detectedCountry.name,
                                detectedCountry.flag
                            );
                            
                            // Show notification about auto-detection
                            showNotification(
                                '{{ __("crm.info") }}',
                                `${translations.country_auto_detected || 'Country auto-detected'}: ${detectedCountry.name}`,
                                'info'
                            );
                        }
                    }

                    if (data.available) {
                        phoneSuccess.classList.remove('hidden');
                        phoneMessage.textContent = translations.phone_available;
                        phoneMessage.classList.add('text-green-600');
                        isPhoneAvailable = true;

                        // Update phone input with formatted number
                        if (data.formatted_display) {
                            phoneInput.value = data.formatted_display.replace(data.country_code ? `+${countries.find(c => c.code === data.country_code)?.dial?.replace('+', '') || ''}` : '', '').trim();
                        }
                    } else {
                        phoneError.classList.remove('hidden');
                        phoneMessage.textContent = translations.phone_already_exists;
                        phoneMessage.classList.add('text-red-600');
                    }
                } else {
                    phoneError.classList.remove('hidden');
                    phoneMessage.textContent = data.message || translations.invalid_phone_format;
                    phoneMessage.classList.add('text-red-600');
                }
            })
            .catch(error => {
                console.error('Phone validation error:', error);
                phoneSpinner.classList.add('hidden');
                phoneError.classList.remove('hidden');
                phoneMessage.textContent = translations.invalid_phone;
                phoneMessage.classList.add('text-red-600');
            });
        }, 500);
    }

    // Phone input event listeners
    phoneInput.addEventListener('input', validatePhoneNumber);

    // Prevent non-numeric characters (except + at start)
    phoneInput.addEventListener('keypress', function(e) {
        const char = String.fromCharCode(e.which);
        if (!/[0-9+]/.test(char)) {
            e.preventDefault();
        }
        // Allow + only at the beginning
        if (char === '+' && this.value.length > 0) {
            e.preventDefault();
        }
    });

    // Prevent paste of non-numeric characters
    phoneInput.addEventListener('paste', function(e) {
        e.preventDefault();
        const pastedText = (e.clipboardData || window.clipboardData).getData('text');
        const cleanedText = pastedText.replace(/[^0-9+]/g, '');
        // Remove + if not at start
        const finalText = cleanedText.charAt(0) === '+' ? '+' + cleanedText.slice(1).replace(/\+/g, '') : cleanedText.replace(/\+/g, '');
        this.value = finalText;
        validatePhoneNumber();
    });

    // ===== Address Fields Validation (English Only) =====
    
    // Address 1 validation
    const address1Input = document.getElementById('address1');
    if (address1Input) {
        address1Input.addEventListener('keypress', function(e) {
            const char = String.fromCharCode(e.which);
            if (!/[A-Za-z0-9\s\.,#\-]/.test(char)) {
                e.preventDefault();
            }
        });
        address1Input.addEventListener('input', function() {
            this.value = this.value.replace(/[^A-Za-z0-9\s\.,#\-]/g, '');
        });
        address1Input.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedText = (e.clipboardData || window.clipboardData).getData('text');
            const cleanedText = pastedText.replace(/[^A-Za-z0-9\s\.,#\-]/g, '');
            this.value = cleanedText;
        });
    }

    // Address 2 validation
    const address2Input = document.getElementById('address2');
    if (address2Input) {
        address2Input.addEventListener('keypress', function(e) {
            const char = String.fromCharCode(e.which);
            if (!/[A-Za-z0-9\s\.,#\-]/.test(char)) {
                e.preventDefault();
            }
        });
        address2Input.addEventListener('input', function() {
            this.value = this.value.replace(/[^A-Za-z0-9\s\.,#\-]/g, '');
        });
        address2Input.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedText = (e.clipboardData || window.clipboardData).getData('text');
            const cleanedText = pastedText.replace(/[^A-Za-z0-9\s\.,#\-]/g, '');
            this.value = cleanedText;
        });
    }

    // City validation (letters, spaces, hyphens only)
    const cityInput = document.getElementById('city');
    if (cityInput) {
        cityInput.addEventListener('keypress', function(e) {
            const char = String.fromCharCode(e.which);
            if (!/[A-Za-z\s\-]/.test(char)) {
                e.preventDefault();
            }
        });
        cityInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^A-Za-z\s\-]/g, '');
        });
        cityInput.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedText = (e.clipboardData || window.clipboardData).getData('text');
            const cleanedText = pastedText.replace(/[^A-Za-z\s\-]/g, '');
            this.value = cleanedText;
        });
    }

    // State validation (letters, spaces, hyphens only)
    const stateInput = document.getElementById('state');
    if (stateInput) {
        stateInput.addEventListener('keypress', function(e) {
            const char = String.fromCharCode(e.which);
            if (!/[A-Za-z\s\-]/.test(char)) {
                e.preventDefault();
            }
        });
        stateInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^A-Za-z\s\-]/g, '');
        });
        stateInput.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedText = (e.clipboardData || window.clipboardData).getData('text');
            const cleanedText = pastedText.replace(/[^A-Za-z\s\-]/g, '');
            this.value = cleanedText;
        });
    }

    // Postcode validation (letters, numbers, spaces, hyphens only)
    const postcodeInput = document.getElementById('postcode');
    if (postcodeInput) {
        postcodeInput.addEventListener('keypress', function(e) {
            const char = String.fromCharCode(e.which);
            if (!/[A-Za-z0-9\s\-]/.test(char)) {
                e.preventDefault();
            }
        });
        postcodeInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^A-Za-z0-9\s\-]/g, '');
        });
        postcodeInput.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedText = (e.clipboardData || window.clipboardData).getData('text');
            const cleanedText = pastedText.replace(/[^A-Za-z0-9\s\-]/g, '');
            this.value = cleanedText;
        });
    }

    // Tax Number validation (letters, numbers, spaces, hyphens only)
    const taxNumberInput = document.getElementById('tax_number');
    if (taxNumberInput) {
        taxNumberInput.addEventListener('keypress', function(e) {
            const char = String.fromCharCode(e.which);
            if (!/[A-Za-z0-9\s\-]/.test(char)) {
                e.preventDefault();
            }
        });
        taxNumberInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^A-Za-z0-9\s\-]/g, '');
        });
        taxNumberInput.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedText = (e.clipboardData || window.clipboardData).getData('text');
            const cleanedText = pastedText.replace(/[^A-Za-z0-9\s\-]/g, '');
            this.value = cleanedText;
        });
    }
});
</script>

<style>
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

.shake {
    animation: shake 0.3s ease-in-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-slideIn {
    animation: slideIn 0.3s ease-out forwards;
}
</style>
@endsection
