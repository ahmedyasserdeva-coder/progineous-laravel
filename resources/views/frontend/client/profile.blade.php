@extends('frontend.client.layout')

@section('title', app()->getLocale() == 'ar' ? 'الملف الشخصي' : 'Profile')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.4/build/css/intlTelInput.css">
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-purple-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 py-8">
    <div class="container mx-auto px-4 max-w-4xl">
        @php $rtl = app()->getLocale() == 'ar'; @endphp
        
        {{-- Profile Card --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl overflow-hidden mb-6">
            <div class="p-6 border-b border-slate-200 dark:border-slate-700">
                <div class="flex items-center gap-4">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-600 to-purple-600 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                        {{ strtoupper(substr(auth('client')->user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-900 dark:text-white">
                            {{ auth('client')->user()->name ?? __('frontend.client') }}
                        </h2>
                        <p class="text-slate-600 dark:text-slate-400">
                            {{ auth('client')->user()->email ?? 'client@example.com' }}
                        </p>
                        <p class="text-sm text-slate-500 dark:text-slate-500 mt-1">
                            {{ app()->getLocale() == 'ar' ? 'عضو منذ' : 'Member since' }} 
                            {{ auth('client')->user()->created_at ? auth('client')->user()->created_at->format('M Y') : 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>

            <form id="profileForm" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Username --}}
                    <div>
                        <label for="username" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            {{ app()->getLocale() == 'ar' ? 'اسم المستخدم' : 'Username' }}
                        </label>
                        @php
                            $canChangeUsername = true;
                            $daysUntilChange = 0;
                            
                            if (auth('client')->user()->username_last_changed_at) {
                                $daysSinceChange = (int) now()->diffInDays(auth('client')->user()->username_last_changed_at);
                                if ($daysSinceChange < 30) {
                                    $canChangeUsername = false;
                                    $daysUntilChange = 30 - $daysSinceChange;
                                }
                            }
                        @endphp
                        
                        <div class="relative">
                            <input type="text" 
                                   id="username" 
                                   name="username"
                                   value="{{ auth('client')->user()->username ?? '' }}"
                                   maxlength="9"
                                   pattern="[a-zA-Z0-9]*"
                                   class="w-full px-4 py-3 {{ $rtl ? 'pl-12 pr-4' : 'pr-12 pl-4' }} border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white {{ !$canChangeUsername ? 'bg-slate-100 dark:bg-slate-900 text-slate-500 dark:text-slate-400' : '' }}"
                                   {{ !$canChangeUsername ? 'readonly' : '' }}>
                            
                            @if($canChangeUsername)
                                <button type="button" 
                                        id="generateUsername"
                                        class="absolute {{ $rtl ? 'left-3' : 'right-3' }} top-1/2 -translate-y-1/2 p-2 text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors"
                                        title="{{ app()->getLocale() == 'ar' ? 'توليد اسم مستخدم عشوائي' : 'Generate random username' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                </button>
                            @endif
                            
                            <div id="usernameValidation" class="hidden mt-1 text-xs"></div>
                            <div id="usernameAvailability" class="hidden mt-1 text-xs"></div>
                        </div>
                        
                        @if(!$canChangeUsername)
                            <div class="mt-1 flex items-center gap-2 text-xs text-orange-600 dark:text-orange-400 bg-orange-50 dark:bg-orange-900/10 px-3 py-2 rounded-lg border border-orange-200 dark:border-orange-800">
                                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                                <span class="font-medium">{{ app()->getLocale() == 'ar' ? 'متاح بعد:' : 'Available in:' }}</span>
                                <div class="flex items-center gap-1.5 font-mono font-semibold" 
                                     id="usernameCountdown" 
                                     data-end-date="{{ auth('client')->user()->username_last_changed_at ? auth('client')->user()->username_last_changed_at->addDays(30)->toIso8601String() : '' }}">
                                    <span id="countdown-days">-</span><span class="text-[10px]">{{ app()->getLocale() == 'ar' ? 'ي' : 'd' }}</span>
                                    <span>:</span>
                                    <span id="countdown-hours">-</span><span class="text-[10px]">{{ app()->getLocale() == 'ar' ? 'س' : 'h' }}</span>
                                    <span>:</span>
                                    <span id="countdown-minutes">-</span><span class="text-[10px]">{{ app()->getLocale() == 'ar' ? 'د' : 'm' }}</span>
                                    <span>:</span>
                                    <span id="countdown-seconds">-</span><span class="text-[10px]">{{ app()->getLocale() == 'ar' ? 'ث' : 's' }}</span>
                                </div>
                            </div>
                        @else
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                {{ app()->getLocale() == 'ar' 
                                    ? 'أحرف إنجليزية وأرقام فقط، بدون مسافات (حد أقصى 9 أحرف) • تغيير مرة كل 30 يوم' 
                                    : 'English letters & numbers only, no spaces (max 9 chars) • Change once every 30 days' }}
                            </p>
                        @endif
                    </div>

                    {{-- Status (Read Only) --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            {{ app()->getLocale() == 'ar' ? 'حالة الحساب' : 'Account Status' }}
                        </label>
                        <div class="px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg bg-slate-100 dark:bg-slate-900">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                {{ auth('client')->user()->status == 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                {{ auth('client')->user()->status == 'inactive' ? 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400' : '' }}
                                {{ auth('client')->user()->status == 'suspended' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : '' }}">
                                {{ ucfirst(auth('client')->user()->status ?? 'active') }}
                            </span>
                        </div>
                    </div>

                    {{-- First Name --}}
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            {{ app()->getLocale() == 'ar' ? 'الاسم الأول' : 'First Name' }}
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="first_name" 
                               name="first_name"
                               value="{{ auth('client')->user()->first_name ?? '' }}"
                               maxlength="10"
                               pattern="[a-zA-Z]*"
                               class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white {{ $rtl ? 'text-right' : '' }}"
                               required>
                        <div id="firstNameValidation" class="mt-1 text-xs hidden"></div>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                            {{ app()->getLocale() == 'ar' 
                                ? 'أحرف إنجليزية فقط، بدون مسافات (حد أقصى 10 أحرف)' 
                                : 'English letters only, no spaces (max 10 chars)' }}
                        </p>
                    </div>

                    {{-- Last Name --}}
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            {{ app()->getLocale() == 'ar' ? 'الاسم الأخير' : 'Last Name' }}
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="last_name" 
                               name="last_name"
                               value="{{ auth('client')->user()->last_name ?? '' }}"
                               maxlength="10"
                               pattern="[a-zA-Z]*"
                               class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white {{ $rtl ? 'text-right' : '' }}"
                               required>
                        <div id="lastNameValidation" class="mt-1 text-xs hidden"></div>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                            {{ app()->getLocale() == 'ar' 
                                ? 'أحرف إنجليزية فقط، بدون مسافات (حد أقصى 10 أحرف)' 
                                : 'English letters only, no spaces (max 10 chars)' }}
                        </p>
                    </div>

                    {{-- Email --}}
                    <div>
                        @php
                            $canChangeEmail = true;
                            $daysUntilEmailChange = 0;
                            
                            if (auth('client')->user()->email_last_changed_at) {
                                $daysSinceChange = (int) now()->diffInDays(auth('client')->user()->email_last_changed_at);
                                $canChangeEmail = $daysSinceChange >= 30;
                                $daysUntilEmailChange = $canChangeEmail ? 0 : (30 - $daysSinceChange);
                            }
                        @endphp
                        
                        <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            {{ app()->getLocale() == 'ar' ? 'البريد الإلكتروني' : 'Email' }}
                            <span class="text-red-500">*</span>
                        </label>
                        
                        {{-- Email with Request Change Button --}}
                        <div class="relative">
                            <input type="email" 
                                   id="email" 
                                   name="email"
                                   value="{{ auth('client')->user()->email ?? '' }}"
                                   pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}"
                                   class="w-full px-4 py-3 {{ app()->getLocale() == 'ar' ? 'pl-40' : 'pr-40' }} border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white"
                                   dir="ltr"
                                   readonly
                                   required>
                            <button type="button"
                                    id="requestEmailChangeBtn"
                                    class="absolute {{ app()->getLocale() == 'ar' ? 'left-2' : 'right-2' }} top-1/2 -translate-y-1/2 px-3 py-1.5 text-xs font-medium text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-md transition-colors {{ !$canChangeEmail ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    {{ !$canChangeEmail ? 'disabled' : '' }}>
                                {{ app()->getLocale() == 'ar' ? 'طلب تغيير' : 'Request Change' }}
                            </button>
                        </div>
                        
                        @if(!$canChangeEmail)
                            <div class="mt-1 flex items-center gap-2 text-xs text-orange-600 dark:text-orange-400 bg-orange-50 dark:bg-orange-900/10 px-3 py-2 rounded-lg border border-orange-200 dark:border-orange-800">
                                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                                <span class="font-medium">{{ app()->getLocale() == 'ar' ? 'متاح بعد:' : 'Available in:' }}</span>
                                <div class="flex items-center gap-1.5 font-mono font-semibold" 
                                     id="emailCountdown" 
                                     data-end-date="{{ auth('client')->user()->email_last_changed_at ? auth('client')->user()->email_last_changed_at->addDays(30)->toIso8601String() : '' }}">
                                    <span id="email-countdown-days">-</span><span class="text-[10px]">{{ app()->getLocale() == 'ar' ? 'ي' : 'd' }}</span>
                                    <span>:</span>
                                    <span id="email-countdown-hours">-</span><span class="text-[10px]">{{ app()->getLocale() == 'ar' ? 'س' : 'h' }}</span>
                                    <span>:</span>
                                    <span id="email-countdown-minutes">-</span><span class="text-[10px]">{{ app()->getLocale() == 'ar' ? 'د' : 'm' }}</span>
                                    <span>:</span>
                                    <span id="email-countdown-seconds">-</span><span class="text-[10px]">{{ app()->getLocale() == 'ar' ? 'ث' : 's' }}</span>
                                </div>
                            </div>
                        @endif
                        
                        {{-- Step 1: Verify Current Email --}}
                        <div id="verifyCurrentEmailSection" class="hidden mt-3 p-4 bg-blue-50 dark:bg-blue-900/10 border border-blue-200 dark:border-blue-800 rounded-lg">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                    1
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-semibold text-slate-900 dark:text-slate-100 mb-2">
                                        {{ app()->getLocale() == 'ar' ? 'التحقق من البريد الحالي' : 'Verify Current Email' }}
                                    </h4>
                                    <p class="text-xs text-slate-600 dark:text-slate-400 mb-3">
                                        {{ app()->getLocale() == 'ar' 
                                            ? 'سيتم إرسال كود تحقق إلى بريدك الحالي: ' 
                                            : 'A verification code will be sent to your current email: ' }}
                                        <span class="font-semibold">{{ auth('client')->user()->email }}</span>
                                    </p>
                                    <button type="button"
                                            id="sendCurrentEmailCodeBtn"
                                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                                        {{ app()->getLocale() == 'ar' ? 'إرسال كود التحقق' : 'Send Verification Code' }}
                                    </button>
                                    
                                    {{-- Current Email Code Input --}}
                                    <div id="currentEmailCodeInput" class="hidden mt-3">
                                        <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-2">
                                            {{ app()->getLocale() == 'ar' ? 'أدخل كود التحقق' : 'Enter Verification Code' }}
                                        </label>
                                        <div class="flex gap-2">
                                            <input type="text"
                                                   id="currentEmailCode"
                                                   maxlength="6"
                                                   pattern="[0-9]*"
                                                   inputmode="numeric"
                                                   class="flex-1 px-3 py-2 text-center text-lg font-mono tracking-widest border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-slate-700 dark:text-white"
                                                   placeholder="000000">
                                            <button type="button"
                                                    id="verifyCurrentEmailBtn"
                                                    class="px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg transition-colors">
                                                {{ app()->getLocale() == 'ar' ? 'تحقق' : 'Verify' }}
                                            </button>
                                        </div>
                                        <div id="currentEmailCodeMessage" class="mt-2 text-xs hidden"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Step 2: Enter New Email --}}
                        <div id="newEmailSection" class="hidden mt-3 p-4 bg-green-50 dark:bg-green-900/10 border border-green-200 dark:border-green-800 rounded-lg">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                    2
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-semibold text-slate-900 dark:text-slate-100 mb-2">
                                        {{ app()->getLocale() == 'ar' ? 'أدخل البريد الإلكتروني الجديد' : 'Enter New Email' }}
                                    </h4>
                                    <div class="mb-3">
                                        <input type="email"
                                               id="newEmail"
                                               pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}"
                                               class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-green-500 dark:bg-slate-700 dark:text-white"
                                               dir="ltr"
                                               placeholder="{{ app()->getLocale() == 'ar' ? 'البريد الإلكتروني الجديد' : 'New email address' }}">
                                        <div id="newEmailAvailability" class="mt-1 text-xs hidden"></div>
                                    </div>
                                    <button type="button"
                                            id="sendNewEmailCodeBtn"
                                            class="px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg transition-colors">
                                        {{ app()->getLocale() == 'ar' ? 'إرسال كود التحقق للبريد الجديد' : 'Send Code to New Email' }}
                                    </button>
                                    
                                    {{-- New Email Code Input --}}
                                    <div id="newEmailCodeInput" class="hidden mt-3">
                                        <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-2">
                                            {{ app()->getLocale() == 'ar' ? 'أدخل كود التحقق المرسل للبريد الجديد' : 'Enter Code Sent to New Email' }}
                                        </label>
                                        <div class="flex gap-2">
                                            <input type="text"
                                                   id="newEmailCode"
                                                   maxlength="6"
                                                   pattern="[0-9]*"
                                                   inputmode="numeric"
                                                   class="flex-1 px-3 py-2 text-center text-lg font-mono tracking-widest border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-green-500 dark:bg-slate-700 dark:text-white"
                                                   placeholder="000000">
                                            <button type="button"
                                                    id="verifyNewEmailBtn"
                                                    class="px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg transition-colors">
                                                {{ app()->getLocale() == 'ar' ? 'تحقق واحفظ' : 'Verify & Save' }}
                                            </button>
                                        </div>
                                        <div id="newEmailCodeMessage" class="mt-2 text-xs hidden"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <input type="hidden" id="emailVerified" name="email_verified" value="0">
                        <input type="hidden" id="emailChangeToken" name="email_change_token">
                        
                        <div id="emailValidation" class="mt-1 text-xs hidden"></div>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                            {{ app()->getLocale() == 'ar' 
                                ? 'أحرف إنجليزية وأرقام فقط، بدون مسافات • يمكن التغيير مرة كل 30 يوم' 
                                : 'English letters and numbers only, no spaces • Change once every 30 days' }}
                        </p>
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label for="phone" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            {{ app()->getLocale() == 'ar' ? 'رقم الهاتف' : 'Phone Number' }}
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" 
                               id="phone" 
                               name="phone"
                               value="{{ auth('client')->user()->phone ?? '' }}"
                               inputmode="numeric"
                               class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white"
                               required>
                        <input type="hidden" id="phone_full" name="phone_full">
                        <div id="phoneValidation" class="mt-1 text-xs hidden"></div>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                            {{ app()->getLocale() == 'ar' 
                                ? 'أرقام فقط (حد أقصى 17 رقم)' 
                                : 'Numbers only (max 17 digits)' }}
                        </p>
                    </div>

                    {{-- Company Name --}}
                    <div class="md:col-span-2">
                        <label for="company_name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            {{ app()->getLocale() == 'ar' ? 'اسم الشركة' : 'Company Name' }}
                        </label>
                        <input type="text" 
                               id="company_name" 
                               name="company_name"
                               value="{{ auth('client')->user()->company_name ?? '' }}"
                               maxlength="30"
                               pattern="[a-zA-Z0-9\s]*"
                               class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white">
                        <div id="companyNameValidation" class="mt-1 text-xs hidden"></div>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                            {{ app()->getLocale() == 'ar' 
                                ? 'أحرف إنجليزية وأرقام ومسافات فقط (حد أقصى 30 حرف)' 
                                : 'English letters, numbers and spaces only (max 30 chars)' }}
                        </p>
                    </div>

                    {{-- Address 1 --}}
                    <div class="md:col-span-2">
                        <label for="address1" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            {{ app()->getLocale() == 'ar' ? 'العنوان 1' : 'Address Line 1' }}
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="address1" 
                               name="address1"
                               value="{{ auth('client')->user()->address1 ?? '' }}"
                               maxlength="50"
                               pattern="[a-zA-Z0-9\s]*"
                               class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white"
                               required>
                        <div id="address1Validation" class="mt-1 text-xs hidden"></div>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                            {{ app()->getLocale() == 'ar' 
                                ? 'أحرف إنجليزية وأرقام ومسافات فقط (حد أقصى 50 حرف)' 
                                : 'English letters, numbers and spaces only (max 50 chars)' }}
                        </p>
                    </div>

                    {{-- Address 2 --}}
                    <div class="md:col-span-2">
                        <label for="address2" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            {{ app()->getLocale() == 'ar' ? 'العنوان 2 (اختياري)' : 'Address Line 2 (Optional)' }}
                        </label>
                        <input type="text" 
                               id="address2" 
                               name="address2"
                               value="{{ auth('client')->user()->address2 ?? '' }}"
                               maxlength="50"
                               pattern="[a-zA-Z0-9\s]*"
                               class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white">
                        <div id="address2Validation" class="mt-1 text-xs hidden"></div>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                            {{ app()->getLocale() == 'ar' 
                                ? 'أحرف إنجليزية وأرقام ومسافات فقط (حد أقصى 50 حرف)' 
                                : 'English letters, numbers and spaces only (max 50 chars)' }}
                        </p>
                    </div>

                    {{-- City --}}
                    <div>
                        <label for="city" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            {{ app()->getLocale() == 'ar' ? 'المدينة' : 'City' }}
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="city" 
                               name="city"
                               value="{{ auth('client')->user()->city ?? '' }}"
                               maxlength="20"
                               pattern="[a-zA-Z0-9\s]*"
                               class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white"
                               required>
                        <div id="cityValidation" class="mt-1 text-xs hidden"></div>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                            {{ app()->getLocale() == 'ar' 
                                ? 'أحرف إنجليزية وأرقام ومسافات فقط (حد أقصى 20 حرف)' 
                                : 'English letters, numbers and spaces only (max 20 chars)' }}
                        </p>
                    </div>

                    {{-- State --}}
                    <div>
                        <label for="state" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            {{ app()->getLocale() == 'ar' ? 'المحافظة/الولاية' : 'State/Province' }}
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="state" 
                               name="state"
                               value="{{ auth('client')->user()->state ?? '' }}"
                               maxlength="20"
                               pattern="[a-zA-Z0-9\s]*"
                               class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white"
                               required>
                        <div id="stateValidation" class="mt-1 text-xs hidden"></div>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                            {{ app()->getLocale() == 'ar' 
                                ? 'أحرف إنجليزية وأرقام ومسافات فقط (حد أقصى 20 حرف)' 
                                : 'English letters, numbers and spaces only (max 20 chars)' }}
                        </p>
                    </div>

                    {{-- Postcode --}}
                    <div>
                        <label for="postcode" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            {{ app()->getLocale() == 'ar' ? 'الرمز البريدي' : 'Postal Code' }}
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="postcode" 
                               name="postcode"
                               value="{{ auth('client')->user()->postcode ?? '' }}"
                               maxlength="10"
                               pattern="[a-zA-Z0-9\s]*"
                               class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white"
                               required>
                        <div id="postcodeValidation" class="hidden mt-1 text-xs"></div>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                            {{ app()->getLocale() == 'ar' ? 'أحرف إنجليزية وأرقام ومسافات فقط (حد أقصى 10 أحرف)' : 'English letters, numbers and spaces only (max 10 characters)' }}
                        </p>
                    </div>

                    {{-- Country --}}
                    <div>
                        <label for="country" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            {{ app()->getLocale() == 'ar' ? 'الدولة' : 'Country' }}
                            <span class="text-red-500">*</span>
                        </label>
                        <select id="country" 
                                name="country"
                                class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white {{ $rtl ? 'text-right' : '' }}"
                                required>
                            <option value="">{{ app()->getLocale() == 'ar' ? 'اختر الدولة' : 'Select Country' }}</option>
                            <option value="EG" {{ (auth('client')->user()->country ?? '') == 'EG' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'مصر' : 'Egypt' }}</option>
                            <option value="SA" {{ (auth('client')->user()->country ?? '') == 'SA' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'السعودية' : 'Saudi Arabia' }}</option>
                            <option value="AE" {{ (auth('client')->user()->country ?? '') == 'AE' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'الإمارات' : 'UAE' }}</option>
                            <option value="KW" {{ (auth('client')->user()->country ?? '') == 'KW' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'الكويت' : 'Kuwait' }}</option>
                            <option value="QA" {{ (auth('client')->user()->country ?? '') == 'QA' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'قطر' : 'Qatar' }}</option>
                            <option value="BH" {{ (auth('client')->user()->country ?? '') == 'BH' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'البحرين' : 'Bahrain' }}</option>
                            <option value="OM" {{ (auth('client')->user()->country ?? '') == 'OM' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'عمان' : 'Oman' }}</option>
                            <option value="JO" {{ (auth('client')->user()->country ?? '') == 'JO' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'الأردن' : 'Jordan' }}</option>
                            <option value="LB" {{ (auth('client')->user()->country ?? '') == 'LB' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'لبنان' : 'Lebanon' }}</option>
                            <option value="IQ" {{ (auth('client')->user()->country ?? '') == 'IQ' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'العراق' : 'Iraq' }}</option>
                            <option value="US" {{ (auth('client')->user()->country ?? '') == 'US' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'الولايات المتحدة' : 'United States' }}</option>
                            <option value="GB" {{ (auth('client')->user()->country ?? '') == 'GB' ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? 'المملكة المتحدة' : 'United Kingdom' }}</option>
                        </select>
                    </div>

                    {{-- Tax Number --}}
                    <div>
                        <label for="tax_number" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            {{ app()->getLocale() == 'ar' ? 'الرقم الضريبي' : 'Tax Number' }}
                        </label>
                        <input type="text" 
                               id="tax_number" 
                               name="tax_number"
                               value="{{ auth('client')->user()->tax_number ?? '' }}"
                               pattern="[a-zA-Z0-9\-]*"
                               class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white">
                        <div id="taxNumberValidation" class="hidden mt-1 text-xs"></div>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                            {{ app()->getLocale() == 'ar' ? 'أحرف إنجليزية وأرقام وعلامة (-) فقط' : 'English letters, numbers and hyphen (-) only' }}
                        </p>
                    </div>

                    {{-- Billing Contact --}}
                    <div>
                        <label for="billing_contact" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            {{ app()->getLocale() == 'ar' ? 'جهة اتصال الفواتير' : 'Billing Contact' }}
                        </label>
                        <input type="text" 
                               id="billing_contact" 
                               name="billing_contact"
                               value="{{ auth('client')->user()->billing_contact ?? '' }}"
                               maxlength="30"
                               pattern="[a-zA-Z\s]*"
                               class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white">
                        <div id="billingContactValidation" class="hidden mt-1 text-xs"></div>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                            {{ app()->getLocale() == 'ar' ? 'أحرف إنجليزية ومسافات فقط (حد أقصى 30 حرف)' : 'English letters and spaces only (max 30 characters)' }}
                        </p>
                    </div>
                </div>

                {{-- Error/Success Messages --}}
                <div id="messageContainer" class="hidden mt-6"></div>

                {{-- Submit Button --}}
                <div class="mt-6 flex gap-3">
                    <button type="submit" 
                            id="submitButton"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span id="submitText">{{ app()->getLocale() == 'ar' ? 'حفظ التغييرات' : 'Save Changes' }}</span>
                    </button>
                    <a href="{{ route('client.dashboard') }}" 
                       class="bg-slate-200 hover:bg-slate-300 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-900 dark:text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                        {{ app()->getLocale() == 'ar' ? 'إلغاء' : 'Cancel' }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.4/build/js/intlTelInput.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('profileForm');
    const submitButton = document.getElementById('submitButton');
    const submitText = document.getElementById('submitText');
    const messageContainer = document.getElementById('messageContainer');

    // Initialize intl-tel-input for phone number
    const phoneInput = document.querySelector("#phone");
    const phoneFullInput = document.querySelector("#phone_full");
    let iti = null;
    
    if (phoneInput) {
        iti = window.intlTelInput(phoneInput, {
            initialCountry: "eg",
            preferredCountries: ["eg", "sa", "ae", "kw", "qa", "bh", "om", "jo", "lb", "iq"],
            separateDialCode: true,
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.4/build/js/utils.js",
            autoPlaceholder: "aggressive",
            formatOnDisplay: true,
            nationalMode: true,
            customContainer: "w-full",
        });

        // Set initial value if exists
        if (phoneInput.value) {
            // If phone has country code, set it properly
            if (phoneInput.value.startsWith('+')) {
                iti.setNumber(phoneInput.value);
            } else {
                phoneInput.value = phoneInput.value;
            }
        }
        
        // Real-time validation - numbers only
        const phoneValidation = document.getElementById('phoneValidation');
        
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value;
            
            // Remove any non-numeric characters (except spaces which intl-tel-input adds)
            let sanitized = value.replace(/[^0-9\s]/g, '');
            
            // Count only digits (without spaces)
            let digitsOnly = sanitized.replace(/\s/g, '');
            
            // Limit to 17 digits
            if (digitsOnly.length > 17) {
                // Keep only first 17 digits
                digitsOnly = digitsOnly.substring(0, 17);
                sanitized = digitsOnly;
                
                // Show warning message
                if (phoneValidation) {
                    phoneValidation.className = 'mt-1 text-xs text-orange-600 dark:text-orange-400 flex items-center gap-1';
                    phoneValidation.innerHTML = `
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ app()->getLocale() == 'ar' ? 'الحد الأقصى 17 رقم' : 'Maximum 17 digits' }}</span>
                    `;
                    phoneValidation.classList.remove('hidden');
                    
                    // Hide after 3 seconds
                    setTimeout(() => {
                        phoneValidation.classList.add('hidden');
                    }, 3000);
                }
            }
            
            // If value was changed, update the input and show warning
            if (value !== sanitized) {
                e.target.value = sanitized;
                
                // Show warning message for non-numeric characters
                if (phoneValidation && digitsOnly.length <= 17) {
                    phoneValidation.className = 'mt-1 text-xs text-orange-600 dark:text-orange-400 flex items-center gap-1';
                    phoneValidation.innerHTML = `
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ app()->getLocale() == 'ar' ? 'أرقام فقط مسموحة' : 'Only numbers allowed' }}</span>
                    `;
                    phoneValidation.classList.remove('hidden');
                    
                    // Hide after 3 seconds
                    setTimeout(() => {
                        phoneValidation.classList.add('hidden');
                    }, 3000);
                }
            }
            
            // Auto-format the number and update hidden field
            const currentValue = iti.getNumber();
            if (currentValue) {
                phoneFullInput.value = currentValue;
            }
        });

        // Update hidden field on change
        phoneInput.addEventListener('blur', function() {
            if (iti.isValidNumber()) {
                phoneFullInput.value = iti.getNumber();
            }
        });

        phoneInput.addEventListener('countrychange', function() {
            phoneFullInput.value = iti.getNumber();
        });
    }
    const usernameInput = document.getElementById('username');
    const usernameValidation = document.getElementById('usernameValidation');
    const usernameAvailability = document.getElementById('usernameAvailability');
    const generateUsernameBtn = document.getElementById('generateUsername');
    const originalUsername = '{{ auth('client')->user()->username ?? '' }}';
    let usernameCheckTimeout = null;

    const emailInput = document.getElementById('email');
    const emailValidation = document.getElementById('emailValidation');
    const emailAvailability = document.getElementById('emailAvailability');
    const originalEmail = '{{ auth('client')->user()->email ?? '' }}';
    let emailCheckTimeout = null;

    // Countdown Timer for email change
    const emailCountdownContainer = document.getElementById('emailCountdown');
    if (emailCountdownContainer) {
        const endDate = emailCountdownContainer.getAttribute('data-end-date');
        
        if (endDate) {
            const emailCountdownDays = document.getElementById('email-countdown-days');
            const emailCountdownHours = document.getElementById('email-countdown-hours');
            const emailCountdownMinutes = document.getElementById('email-countdown-minutes');
            const emailCountdownSeconds = document.getElementById('email-countdown-seconds');
            
            function updateEmailCountdown() {
                const now = new Date().getTime();
                const end = new Date(endDate).getTime();
                const distance = end - now;
                
                if (distance < 0) {
                    location.reload();
                    return;
                }
                
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                
                emailCountdownDays.textContent = days.toString().padStart(2, '0');
                emailCountdownHours.textContent = hours.toString().padStart(2, '0');
                emailCountdownMinutes.textContent = minutes.toString().padStart(2, '0');
                emailCountdownSeconds.textContent = seconds.toString().padStart(2, '0');
            }
            
            updateEmailCountdown();
            setInterval(updateEmailCountdown, 1000);
        }
    }

    // Email Change Verification System
    const requestEmailChangeBtn = document.getElementById('requestEmailChangeBtn');
    const verifyCurrentEmailSection = document.getElementById('verifyCurrentEmailSection');
    const sendCurrentEmailCodeBtn = document.getElementById('sendCurrentEmailCodeBtn');
    const currentEmailCodeInput = document.getElementById('currentEmailCodeInput');
    const verifyCurrentEmailBtn = document.getElementById('verifyCurrentEmailBtn');
    const newEmailSection = document.getElementById('newEmailSection');
    const sendNewEmailCodeBtn = document.getElementById('sendNewEmailCodeBtn');
    const newEmailCodeInput = document.getElementById('newEmailCodeInput');
    const verifyNewEmailBtn = document.getElementById('verifyNewEmailBtn');
    const newEmailInput = document.getElementById('newEmail');
    const emailVerifiedInput = document.getElementById('emailVerified');
    const emailChangeTokenInput = document.getElementById('emailChangeToken');
    const newEmailAvailability = document.getElementById('newEmailAvailability');

    let currentEmailVerified = false;
    let newEmailVerified = false;

    // Step 1: Request Email Change
    if (requestEmailChangeBtn) {
        requestEmailChangeBtn.addEventListener('click', function() {
            if (this.disabled) return;
            verifyCurrentEmailSection.classList.remove('hidden');
            this.classList.add('hidden');
        });
    }

    // Step 2: Send Code to Current Email
    if (sendCurrentEmailCodeBtn) {
        sendCurrentEmailCodeBtn.addEventListener('click', function() {
            const btn = this;
            btn.disabled = true;
            btn.innerHTML = '<svg class="animate-spin h-4 w-4 mx-auto" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

            fetch('{{ route("profile.send-current-email-code") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    currentEmailCodeInput.classList.remove('hidden');
                    btn.innerHTML = '{{ app()->getLocale() == "ar" ? "تم الإرسال ✓" : "Sent ✓" }}';
                    btn.classList.add('bg-green-600');
                    
                    const messageDiv = document.getElementById('currentEmailCodeMessage');
                    messageDiv.className = 'mt-2 text-xs text-green-600 dark:text-green-400 flex items-center gap-1';
                    messageDiv.innerHTML = '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg><span>' + data.message + '</span>';
                    messageDiv.classList.remove('hidden');
                } else {
                    btn.disabled = false;
                    btn.innerHTML = '{{ app()->getLocale() == "ar" ? "إرسال كود التحقق" : "Send Verification Code" }}';
                    alert(data.message);
                }
            })
            .catch(error => {
                btn.disabled = false;
                btn.innerHTML = '{{ app()->getLocale() == "ar" ? "إرسال كود التحقق" : "Send Verification Code" }}';
                alert('{{ app()->getLocale() == "ar" ? "حدث خطأ، حاول مرة أخرى" : "Error occurred, try again" }}');
            });
        });
    }

    // Step 3: Verify Current Email Code
    if (verifyCurrentEmailBtn) {
        verifyCurrentEmailBtn.addEventListener('click', function() {
            const code = document.getElementById('currentEmailCode').value;
            if (!code || code.length !== 6) {
                alert('{{ app()->getLocale() == "ar" ? "يرجى إدخال كود مكون من 6 أرقام" : "Please enter 6-digit code" }}');
                return;
            }

            const btn = this;
            btn.disabled = true;
            btn.innerHTML = '<svg class="animate-spin h-4 w-4 mx-auto" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

            fetch('{{ route("profile.verify-current-email") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ code: code })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    currentEmailVerified = true;
                    verifyCurrentEmailSection.classList.add('opacity-50', 'pointer-events-none');
                    newEmailSection.classList.remove('hidden');
                    
                    const messageDiv = document.getElementById('currentEmailCodeMessage');
                    messageDiv.className = 'mt-2 text-xs text-green-600 dark:text-green-400 flex items-center gap-1';
                    messageDiv.innerHTML = '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg><span>' + data.message + '</span>';
                    messageDiv.classList.remove('hidden');
                } else {
                    btn.disabled = false;
                    btn.innerHTML = '{{ app()->getLocale() == "ar" ? "تحقق" : "Verify" }}';
                    
                    const messageDiv = document.getElementById('currentEmailCodeMessage');
                    messageDiv.className = 'mt-2 text-xs text-red-600 dark:text-red-400 flex items-center gap-1';
                    messageDiv.innerHTML = '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg><span>' + data.message + '</span>';
                    messageDiv.classList.remove('hidden');
                }
            })
            .catch(error => {
                btn.disabled = false;
                btn.innerHTML = '{{ app()->getLocale() == "ar" ? "تحقق" : "Verify" }}';
                alert('{{ app()->getLocale() == "ar" ? "حدث خطأ، حاول مرة أخرى" : "Error occurred, try again" }}');
            });
        });
    }

    // Step 4: Check New Email Availability
    if (newEmailInput) {
        let emailCheckTimeout;
        newEmailInput.addEventListener('input', function() {
            const email = this.value.trim();
            
            if (!email) {
                newEmailAvailability.classList.add('hidden');
                return;
            }

            // Check if it's a valid email format
            const emailRegex = /^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/;
            if (!emailRegex.test(email)) {
                newEmailAvailability.className = 'mt-1 text-xs text-orange-600 dark:text-orange-400';
                newEmailAvailability.textContent = '{{ app()->getLocale() == "ar" ? "صيغة البريد الإلكتروني غير صحيحة" : "Invalid email format" }}';
                newEmailAvailability.classList.remove('hidden');
                return;
            }

            clearTimeout(emailCheckTimeout);
            emailCheckTimeout = setTimeout(() => {
                fetch('{{ route("profile.check-email") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ email: email })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.available) {
                        newEmailAvailability.className = 'mt-1 text-xs text-green-600 dark:text-green-400 flex items-center gap-1';
                        newEmailAvailability.innerHTML = '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg><span>' + data.message + '</span>';
                        newEmailAvailability.classList.remove('hidden');
                    } else {
                        newEmailAvailability.className = 'mt-1 text-xs text-red-600 dark:text-red-400 flex items-center gap-1';
                        newEmailAvailability.innerHTML = '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg><span>' + data.message + '</span>';
                        newEmailAvailability.classList.remove('hidden');
                    }
                });
            }, 500);
        });
    }

    // Step 5: Send Code to New Email
    if (sendNewEmailCodeBtn) {
        sendNewEmailCodeBtn.addEventListener('click', function() {
            if (!currentEmailVerified) {
                alert('{{ app()->getLocale() == "ar" ? "يرجى التحقق من بريدك الحالي أولاً" : "Please verify your current email first" }}');
                return;
            }

            const newEmail = newEmailInput.value.trim();
            if (!newEmail) {
                alert('{{ app()->getLocale() == "ar" ? "يرجى إدخال البريد الإلكتروني الجديد" : "Please enter new email" }}');
                return;
            }

            const btn = this;
            btn.disabled = true;
            btn.innerHTML = '<svg class="animate-spin h-4 w-4 mx-auto" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

            fetch('{{ route("profile.send-new-email-code") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ new_email: newEmail })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    newEmailCodeInput.classList.remove('hidden');
                    btn.innerHTML = '{{ app()->getLocale() == "ar" ? "تم الإرسال ✓" : "Sent ✓" }}';
                    btn.classList.add('bg-green-600');
                    
                    const messageDiv = document.getElementById('newEmailCodeMessage');
                    messageDiv.className = 'mt-2 text-xs text-green-600 dark:text-green-400 flex items-center gap-1';
                    messageDiv.innerHTML = '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg><span>' + data.message + '</span>';
                    messageDiv.classList.remove('hidden');
                } else {
                    btn.disabled = false;
                    btn.innerHTML = '{{ app()->getLocale() == "ar" ? "إرسال كود التحقق للبريد الجديد" : "Send Code to New Email" }}';
                    alert(data.message);
                }
            })
            .catch(error => {
                btn.disabled = false;
                btn.innerHTML = '{{ app()->getLocale() == "ar" ? "إرسال كود التحقق للبريد الجديد" : "Send Code to New Email" }}';
                alert('{{ app()->getLocale() == "ar" ? "حدث خطأ، حاول مرة أخرى" : "Error occurred, try again" }}');
            });
        });
    }

    // Step 6: Verify New Email Code and Complete Change
    if (verifyNewEmailBtn) {
        verifyNewEmailBtn.addEventListener('click', function() {
            const code = document.getElementById('newEmailCode').value;
            const newEmail = newEmailInput.value.trim();
            
            if (!code || code.length !== 6) {
                alert('{{ app()->getLocale() == "ar" ? "يرجى إدخال كود مكون من 6 أرقام" : "Please enter 6-digit code" }}');
                return;
            }

            const btn = this;
            btn.disabled = true;
            btn.innerHTML = '<svg class="animate-spin h-4 w-4 mx-auto" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

            fetch('{{ route("profile.verify-new-email") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ code: code, new_email: newEmail })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    newEmailVerified = true;
                    emailVerifiedInput.value = '1';
                    emailChangeTokenInput.value = data.token;
                    emailInput.value = newEmail;
                    
                    const messageDiv = document.getElementById('newEmailCodeMessage');
                    messageDiv.className = 'mt-2 text-xs text-green-600 dark:text-green-400 flex items-center gap-1';
                    messageDiv.innerHTML = '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg><span>{{ app()->getLocale() == "ar" ? "تم التحقق بنجاح! جاري حفظ التغييرات..." : "Verified successfully! Saving changes..." }}</span>';
                    messageDiv.classList.remove('hidden');
                    
                    newEmailSection.classList.add('opacity-50', 'pointer-events-none');
                    btn.innerHTML = '{{ app()->getLocale() == "ar" ? "تم التحقق ✓" : "Verified ✓" }}';
                    
                    // Auto-submit the form after successful verification
                    setTimeout(async () => {
                        const form = document.getElementById('profileForm');
                        const formData = new FormData(form);
                        
                        try {
                            const response = await fetch('{{ route('client.profile.update') }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                                    'Accept': 'application/json',
                                },
                                body: formData
                            });

                            const saveData = await response.json();

                            if (saveData.success) {
                                messageDiv.innerHTML = '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg><span>{{ app()->getLocale() == "ar" ? "تم الحفظ بنجاح! جاري إعادة تحميل الصفحة..." : "Saved successfully! Reloading page..." }}</span>';
                                
                                setTimeout(() => {
                                    location.reload();
                                }, 1500);
                            } else {
                                messageDiv.className = 'mt-2 text-xs text-red-600 dark:text-red-400 flex items-center gap-1';
                                messageDiv.innerHTML = '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg><span>' + (saveData.message || '{{ app()->getLocale() == "ar" ? "فشل الحفظ" : "Save failed" }}') + '</span>';
                            }
                        } catch (error) {
                            messageDiv.className = 'mt-2 text-xs text-red-600 dark:text-red-400 flex items-center gap-1';
                            messageDiv.innerHTML = '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg><span>{{ app()->getLocale() == "ar" ? "حدث خطأ أثناء الحفظ" : "Error occurred while saving" }}</span>';
                        }
                    }, 1000);
                } else {
                    btn.disabled = false;
                    btn.innerHTML = '{{ app()->getLocale() == "ar" ? "تحقق واحفظ" : "Verify & Save" }}';
                    
                    const messageDiv = document.getElementById('newEmailCodeMessage');
                    messageDiv.className = 'mt-2 text-xs text-red-600 dark:text-red-400 flex items-center gap-1';
                    messageDiv.innerHTML = '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg><span>' + data.message + '</span>';
                    messageDiv.classList.remove('hidden');
                }
            })
            .catch(error => {
                btn.disabled = false;
                btn.innerHTML = '{{ app()->getLocale() == "ar" ? "تحقق واحفظ" : "Verify & Save" }}';
                alert('{{ app()->getLocale() == "ar" ? "حدث خطأ، حاول مرة أخرى" : "Error occurred, try again" }}');
            });
        });
    }

    // Countdown Timer for username change
    const countdownContainer = document.getElementById('usernameCountdown');
    if (countdownContainer) {
        const endDate = countdownContainer.getAttribute('data-end-date');
        
        if (endDate) {
            const countdownDays = document.getElementById('countdown-days');
            const countdownHours = document.getElementById('countdown-hours');
            const countdownMinutes = document.getElementById('countdown-minutes');
            const countdownSeconds = document.getElementById('countdown-seconds');
            
            function updateCountdown() {
                const now = new Date().getTime();
                const end = new Date(endDate).getTime();
                const distance = end - now;
                
                if (distance < 0) {
                    // Countdown finished - reload page to enable username change
                    location.reload();
                    return;
                }
                
                // Calculate time units
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                
                // Update display with leading zeros
                countdownDays.textContent = days.toString().padStart(2, '0');
                countdownHours.textContent = hours.toString().padStart(2, '0');
                countdownMinutes.textContent = minutes.toString().padStart(2, '0');
                countdownSeconds.textContent = seconds.toString().padStart(2, '0');
            }
            
            // Update immediately
            updateCountdown();
            
            // Update every second
            setInterval(updateCountdown, 1000);
        }
    }

    // Real-time validation for username format (English letters and numbers only)
    if (usernameInput && !usernameInput.hasAttribute('readonly')) {
        usernameInput.addEventListener('input', function(e) {
            let value = e.target.value;
            
            // Remove any characters that are not English letters or numbers
            let sanitized = value.replace(/[^a-zA-Z0-9]/g, '');
            
            // If value was changed, update the input and show warning
            if (value !== sanitized) {
                e.target.value = sanitized;
                
                // Show warning message
                usernameValidation.className = 'mt-1 text-xs text-orange-600 dark:text-orange-400 flex items-center gap-1';
                usernameValidation.innerHTML = `
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ app()->getLocale() == 'ar' ? 'أحرف إنجليزية وأرقام فقط (بدون مسافات)' : 'English letters and numbers only (no spaces)' }}</span>
                `;
                usernameValidation.classList.remove('hidden');
                
                // Hide after 3 seconds
                setTimeout(() => {
                    usernameValidation.classList.add('hidden');
                }, 3000);
            } else if (value.length > 0) {
                // Show format hint
                usernameValidation.className = 'mt-1 text-xs text-blue-600 dark:text-blue-400 flex items-center gap-1';
                usernameValidation.innerHTML = `
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ app()->getLocale() == 'ar' ? 'صالح (أحرف إنجليزية وأرقام)' : 'Valid (English letters and numbers)' }}</span>
                `;
                usernameValidation.classList.remove('hidden');
            } else {
                usernameValidation.classList.add('hidden');
            }
        });
    }

    // Real-time validation for first_name (English letters only, no spaces)
    const firstNameInput = document.getElementById('first_name');
    const firstNameValidation = document.getElementById('firstNameValidation');
    
    if (firstNameInput) {
        firstNameInput.addEventListener('input', function(e) {
            let value = e.target.value;
            
            // Remove any characters that are not English letters
            let sanitized = value.replace(/[^a-zA-Z]/g, '');
            
            // If value was changed, update the input and show warning
            if (value !== sanitized) {
                e.target.value = sanitized;
                
                // Show warning message
                firstNameValidation.className = 'mt-1 text-xs text-orange-600 dark:text-orange-400 flex items-center gap-1';
                firstNameValidation.innerHTML = `
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ app()->getLocale() == 'ar' ? 'أحرف إنجليزية فقط (بدون مسافات أو أرقام)' : 'English letters only (no spaces or numbers)' }}</span>
                `;
                firstNameValidation.classList.remove('hidden');
                
                // Hide after 3 seconds
                setTimeout(() => {
                    firstNameValidation.classList.add('hidden');
                }, 3000);
            } else if (value.length > 0) {
                // Show valid message
                firstNameValidation.className = 'mt-1 text-xs text-blue-600 dark:text-blue-400 flex items-center gap-1';
                firstNameValidation.innerHTML = `
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ app()->getLocale() == 'ar' ? 'صالح' : 'Valid' }}</span>
                `;
                firstNameValidation.classList.remove('hidden');
            } else {
                firstNameValidation.classList.add('hidden');
            }
        });
    }

    // Real-time validation for last_name (English letters only, no spaces)
    const lastNameInput = document.getElementById('last_name');
    const lastNameValidation = document.getElementById('lastNameValidation');
    
    if (lastNameInput) {
        lastNameInput.addEventListener('input', function(e) {
            let value = e.target.value;
            
            // Remove any characters that are not English letters
            let sanitized = value.replace(/[^a-zA-Z]/g, '');
            
            // If value was changed, update the input and show warning
            if (value !== sanitized) {
                e.target.value = sanitized;
                
                // Show warning message
                lastNameValidation.className = 'mt-1 text-xs text-orange-600 dark:text-orange-400 flex items-center gap-1';
                lastNameValidation.innerHTML = `
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ app()->getLocale() == 'ar' ? 'أحرف إنجليزية فقط (بدون مسافات أو أرقام)' : 'English letters only (no spaces or numbers)' }}</span>
                `;
                lastNameValidation.classList.remove('hidden');
                
                // Hide after 3 seconds
                setTimeout(() => {
                    lastNameValidation.classList.add('hidden');
                }, 3000);
            } else if (value.length > 0) {
                // Show valid message
                lastNameValidation.className = 'mt-1 text-xs text-blue-600 dark:text-blue-400 flex items-center gap-1';
                lastNameValidation.innerHTML = `
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ app()->getLocale() == 'ar' ? 'صالح' : 'Valid' }}</span>
                `;
                lastNameValidation.classList.remove('hidden');
            } else {
                lastNameValidation.classList.add('hidden');
            }
        });
    }

    // Real-time validation for company_name (English letters, numbers, and spaces only)
    const companyNameInput = document.getElementById('company_name');
    const companyNameValidation = document.getElementById('companyNameValidation');
    
    if (companyNameInput) {
        companyNameInput.addEventListener('input', function(e) {
            let value = e.target.value;
            
            // Remove any characters that are not English letters, numbers, or spaces
            let sanitized = value.replace(/[^a-zA-Z0-9\s]/g, '');
            
            // Limit to 30 characters
            if (sanitized.length > 30) {
                sanitized = sanitized.substring(0, 30);
            }
            
            // If value was changed, update the input and show warning
            if (value !== sanitized) {
                e.target.value = sanitized;
                
                // Show warning message
                companyNameValidation.className = 'mt-1 text-xs text-orange-600 dark:text-orange-400 flex items-center gap-1';
                companyNameValidation.innerHTML = `
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ app()->getLocale() == 'ar' ? 'أحرف إنجليزية وأرقام ومسافات فقط (حد أقصى 30 حرف)' : 'English letters, numbers and spaces only (max 30 chars)' }}</span>
                `;
                companyNameValidation.classList.remove('hidden');
                
                // Hide after 3 seconds
                setTimeout(() => {
                    companyNameValidation.classList.add('hidden');
                }, 3000);
            } else if (value.length > 0) {
                // Show valid message
                companyNameValidation.className = 'mt-1 text-xs text-blue-600 dark:text-blue-400 flex items-center gap-1';
                companyNameValidation.innerHTML = `
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ app()->getLocale() == 'ar' ? 'صالح' : 'Valid' }}</span>
                `;
                companyNameValidation.classList.remove('hidden');
            } else {
                companyNameValidation.classList.add('hidden');
            }
        });
    }

    // Real-time validation for address1 (English letters, numbers, and spaces only)
    const address1Input = document.getElementById('address1');
    const address1Validation = document.getElementById('address1Validation');
    
    if (address1Input) {
        address1Input.addEventListener('input', function(e) {
            let value = e.target.value;
            
            // Remove any characters that are not English letters, numbers, or spaces
            let sanitized = value.replace(/[^a-zA-Z0-9\s]/g, '');
            
            // Limit to 50 characters
            if (sanitized.length > 50) {
                sanitized = sanitized.substring(0, 50);
            }
            
            // If value was changed, update the input and show warning
            if (value !== sanitized) {
                e.target.value = sanitized;
                
                // Show warning message
                address1Validation.className = 'mt-1 text-xs text-orange-600 dark:text-orange-400 flex items-center gap-1';
                address1Validation.innerHTML = `
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ app()->getLocale() == 'ar' ? 'أحرف إنجليزية وأرقام ومسافات فقط (حد أقصى 50 حرف)' : 'English letters, numbers and spaces only (max 50 chars)' }}</span>
                `;
                address1Validation.classList.remove('hidden');
                
                // Hide after 3 seconds
                setTimeout(() => {
                    address1Validation.classList.add('hidden');
                }, 3000);
            } else if (value.length > 0) {
                // Show valid message
                address1Validation.className = 'mt-1 text-xs text-blue-600 dark:text-blue-400 flex items-center gap-1';
                address1Validation.innerHTML = `
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ app()->getLocale() == 'ar' ? 'صالح' : 'Valid' }}</span>
                `;
                address1Validation.classList.remove('hidden');
            } else {
                address1Validation.classList.add('hidden');
            }
        });
    }

    // Real-time validation for address2 (English letters, numbers, and spaces only)
    const address2Input = document.getElementById('address2');
    const address2Validation = document.getElementById('address2Validation');
    
    if (address2Input) {
        address2Input.addEventListener('input', function(e) {
            let value = e.target.value;
            
            // Remove any characters that are not English letters, numbers, or spaces
            let sanitized = value.replace(/[^a-zA-Z0-9\s]/g, '');
            
            // Limit to 50 characters
            if (sanitized.length > 50) {
                sanitized = sanitized.substring(0, 50);
            }
            
            // If value was changed, update the input and show warning
            if (value !== sanitized) {
                e.target.value = sanitized;
                
                // Show warning message
                address2Validation.className = 'mt-1 text-xs text-orange-600 dark:text-orange-400 flex items-center gap-1';
                address2Validation.innerHTML = `
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ app()->getLocale() == 'ar' ? 'أحرف إنجليزية وأرقام ومسافات فقط (حد أقصى 50 حرف)' : 'English letters, numbers and spaces only (max 50 chars)' }}</span>
                `;
                address2Validation.classList.remove('hidden');
                
                // Hide after 3 seconds
                setTimeout(() => {
                    address2Validation.classList.add('hidden');
                }, 3000);
            } else if (value.length > 0) {
                // Show valid message
                address2Validation.className = 'mt-1 text-xs text-blue-600 dark:text-blue-400 flex items-center gap-1';
                address2Validation.innerHTML = `
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ app()->getLocale() == 'ar' ? 'صالح' : 'Valid' }}</span>
                `;
                address2Validation.classList.remove('hidden');
            } else {
                address2Validation.classList.add('hidden');
            }
        });
    }

    // Real-time validation for city (English letters, numbers, and spaces only)
    const cityInput = document.getElementById('city');
    const cityValidation = document.getElementById('cityValidation');
    
    if (cityInput) {
        cityInput.addEventListener('input', function(e) {
            let value = e.target.value;
            
            // Remove any characters that are not English letters, numbers, or spaces
            let sanitized = value.replace(/[^a-zA-Z0-9\s]/g, '');
            
            // Limit to 20 characters
            if (sanitized.length > 20) {
                sanitized = sanitized.substring(0, 20);
            }
            
            // If value was changed, update the input and show warning
            if (value !== sanitized) {
                e.target.value = sanitized;
                
                // Show warning message
                cityValidation.className = 'mt-1 text-xs text-orange-600 dark:text-orange-400 flex items-center gap-1';
                cityValidation.innerHTML = `
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ app()->getLocale() == 'ar' ? 'أحرف إنجليزية وأرقام ومسافات فقط (حد أقصى 20 حرف)' : 'English letters, numbers and spaces only (max 20 chars)' }}</span>
                `;
                cityValidation.classList.remove('hidden');
                
                // Hide after 3 seconds
                setTimeout(() => {
                    cityValidation.classList.add('hidden');
                }, 3000);
            } else if (value.length > 0) {
                // Show valid message
                cityValidation.className = 'mt-1 text-xs text-blue-600 dark:text-blue-400 flex items-center gap-1';
                cityValidation.innerHTML = `
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ app()->getLocale() == 'ar' ? 'صالح' : 'Valid' }}</span>
                `;
                cityValidation.classList.remove('hidden');
            } else {
                cityValidation.classList.add('hidden');
            }
        });
    }

    // Real-time validation for state (English letters, numbers, and spaces only)
    const stateInput = document.getElementById('state');
    const stateValidation = document.getElementById('stateValidation');
    
    if (stateInput) {
        stateInput.addEventListener('input', function(e) {
            let value = e.target.value;
            
            // Remove any characters that are not English letters, numbers, or spaces
            let sanitized = value.replace(/[^a-zA-Z0-9\s]/g, '');
            
            // Limit to 20 characters
            if (sanitized.length > 20) {
                sanitized = sanitized.substring(0, 20);
            }
            
            // If value was changed, update the input and show warning
            if (value !== sanitized) {
                e.target.value = sanitized;
                
                // Show warning message
                stateValidation.className = 'mt-1 text-xs text-orange-600 dark:text-orange-400 flex items-center gap-1';
                stateValidation.innerHTML = `
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ app()->getLocale() == 'ar' ? 'أحرف إنجليزية وأرقام ومسافات فقط (حد أقصى 20 حرف)' : 'English letters, numbers and spaces only (max 20 chars)' }}</span>
                `;
                stateValidation.classList.remove('hidden');
                
                // Hide after 3 seconds
                setTimeout(() => {
                    stateValidation.classList.add('hidden');
                }, 3000);
            } else if (value.length > 0) {
                // Show valid message
                stateValidation.className = 'mt-1 text-xs text-blue-600 dark:text-blue-400 flex items-center gap-1';
                stateValidation.innerHTML = `
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ app()->getLocale() == 'ar' ? 'صالح' : 'Valid' }}</span>
                `;
                stateValidation.classList.remove('hidden');
            } else {
                stateValidation.classList.add('hidden');
            }
        });
    }

    // Real-time validation for postcode (English letters, numbers, and spaces only)
    const postcodeInput = document.getElementById('postcode');
    const postcodeValidation = document.getElementById('postcodeValidation');
    
    if (postcodeInput) {
        postcodeInput.addEventListener('input', function(e) {
            let value = e.target.value;
            
            // Remove any characters that are not English letters, numbers, or spaces
            let sanitized = value.replace(/[^a-zA-Z0-9\s]/g, '');
            
            // Limit to 10 characters
            if (sanitized.length > 10) {
                sanitized = sanitized.substring(0, 10);
            }
            
            // If value was changed, update the input and show warning
            if (value !== sanitized) {
                e.target.value = sanitized;
                
                // Show warning message
                postcodeValidation.className = 'mt-1 text-xs text-orange-600 dark:text-orange-400 flex items-center gap-1';
                postcodeValidation.innerHTML = `
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ app()->getLocale() == 'ar' ? 'أحرف إنجليزية وأرقام ومسافات فقط (حد أقصى 10 أحرف)' : 'English letters, numbers and spaces only (max 10 chars)' }}</span>
                `;
                postcodeValidation.classList.remove('hidden');
                
                // Hide after 3 seconds
                setTimeout(() => {
                    postcodeValidation.classList.add('hidden');
                }, 3000);
            } else if (value.length > 0) {
                // Show valid message
                postcodeValidation.className = 'mt-1 text-xs text-blue-600 dark:text-blue-400 flex items-center gap-1';
                postcodeValidation.innerHTML = `
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ app()->getLocale() == 'ar' ? 'صالح' : 'Valid' }}</span>
                `;
                postcodeValidation.classList.remove('hidden');
            } else {
                postcodeValidation.classList.add('hidden');
            }
        });
    }

    // Real-time validation for tax number (English letters, numbers, and hyphen only)
    const taxNumberInput = document.getElementById('tax_number');
    const taxNumberValidation = document.getElementById('taxNumberValidation');
    
    if (taxNumberInput) {
        taxNumberInput.addEventListener('input', function(e) {
            let value = e.target.value;
            
            // Remove any characters that are not English letters, numbers, or hyphen
            let sanitized = value.replace(/[^a-zA-Z0-9\-]/g, '');
            
            // If value was changed, update the input and show warning
            if (value !== sanitized) {
                e.target.value = sanitized;
                
                // Show warning message
                taxNumberValidation.className = 'mt-1 text-xs text-orange-600 dark:text-orange-400 flex items-center gap-1';
                taxNumberValidation.innerHTML = `
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ app()->getLocale() == 'ar' ? 'أحرف إنجليزية وأرقام وعلامة (-) فقط' : 'English letters, numbers and hyphen (-) only' }}</span>
                `;
                taxNumberValidation.classList.remove('hidden');
                
                // Hide after 3 seconds
                setTimeout(() => {
                    taxNumberValidation.classList.add('hidden');
                }, 3000);
            } else if (value.length > 0) {
                // Show valid message
                taxNumberValidation.className = 'mt-1 text-xs text-blue-600 dark:text-blue-400 flex items-center gap-1';
                taxNumberValidation.innerHTML = `
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ app()->getLocale() == 'ar' ? 'صالح' : 'Valid' }}</span>
                `;
                taxNumberValidation.classList.remove('hidden');
            } else {
                taxNumberValidation.classList.add('hidden');
            }
        });
    }

    // Real-time validation for billing contact (English letters and spaces only)
    const billingContactInput = document.getElementById('billing_contact');
    const billingContactValidation = document.getElementById('billingContactValidation');
    
    if (billingContactInput) {
        billingContactInput.addEventListener('input', function(e) {
            let value = e.target.value;
            
            // Remove any characters that are not English letters or spaces
            let sanitized = value.replace(/[^a-zA-Z\s]/g, '');
            
            // Limit to 30 characters
            if (sanitized.length > 30) {
                sanitized = sanitized.substring(0, 30);
            }
            
            // If value was changed, update the input and show warning
            if (value !== sanitized) {
                e.target.value = sanitized;
                
                // Show warning message
                billingContactValidation.className = 'mt-1 text-xs text-orange-600 dark:text-orange-400 flex items-center gap-1';
                billingContactValidation.innerHTML = `
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ app()->getLocale() == 'ar' ? 'أحرف إنجليزية ومسافات فقط (حد أقصى 30 حرف)' : 'English letters and spaces only (max 30 chars)' }}</span>
                `;
                billingContactValidation.classList.remove('hidden');
                
                // Hide after 3 seconds
                setTimeout(() => {
                    billingContactValidation.classList.add('hidden');
                }, 3000);
            } else if (value.length > 0) {
                // Show valid message
                billingContactValidation.className = 'mt-1 text-xs text-blue-600 dark:text-blue-400 flex items-center gap-1';
                billingContactValidation.innerHTML = `
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ app()->getLocale() == 'ar' ? 'صالح' : 'Valid' }}</span>
                `;
                billingContactValidation.classList.remove('hidden');
            } else {
                billingContactValidation.classList.add('hidden');
            }
        });
    }

    // Real-time validation for email (no Arabic letters or spaces)
    if (emailInput) {
        emailInput.addEventListener('input', function(e) {
            let value = e.target.value;
            
            // Remove Arabic letters, spaces, and invalid characters
            // Keep only: a-z, A-Z, 0-9, @, ., _, %, +, -
            let sanitized = value.replace(/[^a-zA-Z0-9@._+\-%]/g, '');
            
            // If value was changed, update the input and show warning
            if (value !== sanitized) {
                e.target.value = sanitized;
                
                // Show warning message
                emailValidation.className = 'mt-1 text-xs text-orange-600 dark:text-orange-400 flex items-center gap-1';
                emailValidation.innerHTML = `
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ app()->getLocale() == 'ar' ? 'لا يُسمح بالأحرف العربية أو المسافات' : 'Arabic letters or spaces not allowed' }}</span>
                `;
                emailValidation.classList.remove('hidden');
                
                // Hide after 3 seconds
                setTimeout(() => {
                    emailValidation.classList.add('hidden');
                }, 3000);
            } else if (value.length > 0) {
                // Check if it's a valid email format
                const emailPattern = /^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/;
                if (emailPattern.test(value)) {
                    emailValidation.className = 'mt-1 text-xs text-blue-600 dark:text-blue-400 flex items-center gap-1';
                    emailValidation.innerHTML = `
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ app()->getLocale() == 'ar' ? 'تنسيق البريد الإلكتروني صحيح' : 'Valid email format' }}</span>
                    `;
                    emailValidation.classList.remove('hidden');
                } else {
                    emailValidation.classList.add('hidden');
                }
            } else {
                emailValidation.classList.add('hidden');
            }
        });
    }

    // Check email availability on input
    if (emailInput && !emailInput.hasAttribute('readonly') && emailAvailability) {
        emailInput.addEventListener('input', function(e) {
            const newEmail = e.target.value.trim();
            
            // Clear previous timeout
            if (emailCheckTimeout) {
                clearTimeout(emailCheckTimeout);
            }
            
            // Hide availability message if email is same as original or empty
            if (newEmail === originalEmail || newEmail === '') {
                emailAvailability.classList.add('hidden');
                return;
            }
            
            // Check email format first
            const emailPattern = /^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/;
            if (!emailPattern.test(newEmail)) {
                emailAvailability.classList.add('hidden');
                return;
            }
            
            // Debounce the check
            emailCheckTimeout = setTimeout(async () => {
                try {
                    const response = await fetch('{{ route('profile.check-email') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ email: newEmail })
                    });
                    
                    const data = await response.json();
                    
                    if (data.available) {
                        emailAvailability.className = 'mt-1 text-xs text-green-600 dark:text-green-400 flex items-center gap-1';
                        emailAvailability.innerHTML = `
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ app()->getLocale() == 'ar' ? 'البريد الإلكتروني متاح' : 'Email available' }}</span>
                        `;
                        emailAvailability.classList.remove('hidden');
                    } else {
                        emailAvailability.className = 'mt-1 text-xs text-red-600 dark:text-red-400 flex items-center gap-1';
                        emailAvailability.innerHTML = `
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ app()->getLocale() == 'ar' ? 'هذا البريد الإلكتروني مستخدم من قبل عميل آخر، لا يمكن استخدامه' : 'This email is used by another client and cannot be used' }}</span>
                        `;
                        emailAvailability.classList.remove('hidden');
                    }
                } catch (error) {
                    console.error('Error checking email:', error);
                }
            }, 500);
        });
    }

    // Generate random username
    if (generateUsernameBtn) {
        generateUsernameBtn.addEventListener('click', async function() {
            // Disable button during generation
            generateUsernameBtn.disabled = true;
            generateUsernameBtn.classList.add('opacity-50', 'cursor-not-allowed');
            
            try {
                const response = await fetch('{{ route('client.profile.generate-username') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                    }
                });
                
                const data = await response.json();
                
                if (data.success && data.username) {
                    usernameInput.value = data.username;
                    
                    // Show success message
                    usernameAvailability.className = 'mt-1 text-xs text-green-600 dark:text-green-400 flex items-center gap-1';
                    usernameAvailability.innerHTML = `
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ app()->getLocale() == 'ar' ? 'اسم المستخدم متاح' : 'Username available' }}</span>
                    `;
                    usernameAvailability.classList.remove('hidden');
                    
                    // Add animation
                    usernameInput.classList.add('ring-2', 'ring-green-500');
                    setTimeout(() => {
                        usernameInput.classList.remove('ring-2', 'ring-green-500');
                    }, 1000);
                }
            } catch (error) {
                console.error('Error generating username:', error);
            } finally {
                // Re-enable button
                generateUsernameBtn.disabled = false;
                generateUsernameBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        });
    }

    // Check username availability on input
    if (usernameInput && !usernameInput.hasAttribute('readonly')) {
        usernameInput.addEventListener('input', function(e) {
            const newUsername = e.target.value.trim();
            
            // Clear previous timeout
            if (usernameCheckTimeout) {
                clearTimeout(usernameCheckTimeout);
            }
            
            // Hide message if username is same as original
            if (!newUsername || newUsername === originalUsername) {
                usernameAvailability.classList.add('hidden');
                return;
            }
            
            // Check after 500ms of no typing
            usernameCheckTimeout = setTimeout(async () => {
                if (newUsername.length < 3) {
                    usernameAvailability.className = 'mt-1 text-xs text-orange-600 dark:text-orange-400';
                    usernameAvailability.textContent = '{{ app()->getLocale() == 'ar' ? 'اسم المستخدم يجب أن يكون 3 أحرف على الأقل' : 'Username must be at least 3 characters' }}';
                    usernameAvailability.classList.remove('hidden');
                    return;
                }
                
                try {
                    const response = await fetch('{{ route('client.profile.check-username') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ username: newUsername })
                    });
                    
                    const data = await response.json();
                    
                    if (data.available) {
                        usernameAvailability.className = 'mt-1 text-xs text-green-600 dark:text-green-400 flex items-center gap-1';
                        usernameAvailability.innerHTML = `
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ app()->getLocale() == 'ar' ? 'اسم المستخدم متاح' : 'Username available' }}</span>
                        `;
                        usernameAvailability.classList.remove('hidden');
                    } else {
                        usernameAvailability.className = 'mt-1 text-xs text-red-600 dark:text-red-400 flex items-center gap-1';
                        usernameAvailability.innerHTML = `
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ app()->getLocale() == 'ar' ? 'اسم المستخدم مستخدم بالفعل' : 'Username already taken' }}</span>
                        `;
                        usernameAvailability.classList.remove('hidden');
                    }
                } catch (error) {
                    console.error('Error checking username:', error);
                }
            }, 500);
        });
    }

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        // Update phone number with full international format
        if (iti && iti.isValidNumber()) {
            phoneInput.value = iti.getNumber();
        }

        submitButton.disabled = true;
        submitText.textContent = '{{ app()->getLocale() == 'ar' ? 'جاري الحفظ...' : 'Saving...' }}';

        const formData = new FormData(form);

        try {
            const response = await fetch('{{ route('client.profile.update') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                },
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                showMessage(data.message, 'success');
            } else {
                showMessage(data.message || '{{ app()->getLocale() == 'ar' ? 'حدث خطأ' : 'An error occurred' }}', 'error');
            }
        } catch (error) {
            showMessage('{{ app()->getLocale() == 'ar' ? 'حدث خطأ، الرجاء المحاولة مرة أخرى' : 'An error occurred, please try again' }}', 'error');
        } finally {
            submitButton.disabled = false;
            submitText.textContent = '{{ app()->getLocale() == 'ar' ? 'حفظ التغييرات' : 'Save Changes' }}';
        }
    });

    function showMessage(message, type) {
        const bgColor = type === 'success' ? 'bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-800' : 'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800';
        const textColor = type === 'success' ? 'text-green-700 dark:text-green-300' : 'text-red-700 dark:text-red-300';
        const iconColor = type === 'success' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400';
        
        messageContainer.className = `${bgColor} border rounded-lg p-4 mt-6`;
        messageContainer.innerHTML = `
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
        messageContainer.classList.remove('hidden');
        
        if (type === 'success') {
            setTimeout(() => {
                messageContainer.classList.add('hidden');
            }, 5000);
        }
    }
});
</script>

<style>
#usernameCountdown span[id^="countdown-"] {
    transition: all 0.2s ease-in-out;
    display: inline-block;
    min-width: 18px;
    text-align: center;
}

/* intl-tel-input custom styles */
.iti { 
    width: 100%; 
    display: block;
}
.iti__flag-container { 
    padding: 0; 
}
.iti__selected-flag { 
    padding: 12px;
    background: transparent;
    border: 1px solid rgb(203 213 225);
    border-right: none;
    border-radius: 0.5rem 0 0 0.5rem;
    height: 100%;
}
.dark .iti__selected-flag {
    background: rgb(51 65 85);
    border-color: rgb(71 85 105);
}
.iti__selected-dial-code {
    margin-left: 6px;
    margin-right: 6px;
    font-weight: 500;
}
.iti input[type="tel"] {
    padding-left: 90px !important;
}
.iti__country-list {
    background: white;
    border: 1px solid rgb(203 213 225);
    border-radius: 0.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    max-height: 200px;
    z-index: 50;
}
.dark .iti__country-list {
    background: rgb(51 65 85);
    border-color: rgb(71 85 105);
}
.iti__country {
    padding: 8px 12px;
    color: rgb(30 41 59);
}
.dark .iti__country {
    color: rgb(226 232 240);
}
.iti__country:hover {
    background: rgb(241 245 249);
}
.dark .iti__country:hover {
    background: rgb(71 85 105);
}
.iti__country.iti__highlight {
    background: rgb(224 242 254);
}
.dark .iti__country.iti__highlight {
    background: rgb(30 58 138);
}
.iti__dial-code {
    color: rgb(100 116 139);
}
.dark .iti__dial-code {
    color: rgb(148 163 184);
}
</style>
@endsection
