@extends('frontend.client.layout')

@section('title', (app()->getLocale() == 'ar' ? 'معلومات الاتصال - ' : 'Contact Information - ') . $domain->domain_name)

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('client.domains.show', $domain) }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 mb-4">
                <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                {{ app()->getLocale() == 'ar' ? 'العودة للنطاق' : 'Back to Domain' }}
            </a>
            <h1 class="text-2xl font-bold text-gray-900">{{ app()->getLocale() == 'ar' ? 'معلومات الاتصال' : 'Contact Information' }}</h1>
            <p class="text-gray-500 mt-1">{{ $domain->domain_name }}</p>
        </div>

        <div class="space-y-6" x-data="contactsManager()">
            <!-- Registrant Contact -->
            <div class="bg-white rounded-2xl border border-gray-200 overflow-visible">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between cursor-pointer" @click="toggleSection('registrant')">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            {{ app()->getLocale() == 'ar' ? 'بيانات المسجل (Registrant)' : 'Registrant Contact' }}
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">{{ app()->getLocale() == 'ar' ? 'مالك النطاق الرسمي' : 'Official domain owner' }}</p>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': sections.registrant }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
                <div x-show="sections.registrant" x-collapse>
                    <form @submit.prevent="submitForm('registrant')" class="p-6 space-y-4">
                        <!-- Success Message -->
                        <div x-show="successMessage.registrant" x-transition class="p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span x-text="successMessage.registrant" class="text-green-700 font-medium"></span>
                        </div>
                        <!-- General Error Message -->
                        <div x-show="errors.registrant.general" x-transition class="p-4 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span x-text="errors.registrant.general" class="text-red-700 font-medium"></span>
                        </div>
                        <!-- Name Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'الاسم الأول' : 'First Name' }} <span class="text-red-500">*</span></label>
                                <input type="text" x-model="forms.registrant.first_name" @input="errors.registrant.first_name = null" :class="errors.registrant.first_name ? 'border-red-500' : 'border-gray-300'" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <p x-show="errors.registrant.first_name" x-text="errors.registrant.first_name" class="text-red-500 text-sm mt-1"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'اسم العائلة' : 'Last Name' }} <span class="text-red-500">*</span></label>
                                <input type="text" x-model="forms.registrant.last_name" @input="errors.registrant.last_name = null" :class="errors.registrant.last_name ? 'border-red-500' : 'border-gray-300'" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <p x-show="errors.registrant.last_name" x-text="errors.registrant.last_name" class="text-red-500 text-sm mt-1"></p>
                            </div>
                        </div>
                        <!-- Organization -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'المؤسسة/الشركة' : 'Organization' }}</label>
                            <input type="text" x-model="forms.registrant.organization" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <!-- Email & Phone -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'البريد الإلكتروني' : 'Email' }} <span class="text-red-500">*</span></label>
                                <input type="email" x-model="forms.registrant.email" @input="errors.registrant.email = null" :class="errors.registrant.email ? 'border-red-500' : 'border-gray-300'" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <p x-show="errors.registrant.email" x-text="errors.registrant.email" class="text-red-500 text-sm mt-1"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'رقم الهاتف' : 'Phone' }} <span class="text-red-500">*</span></label>
                                <input type="tel" x-model="forms.registrant.phone" @input="errors.registrant.phone = null" :class="errors.registrant.phone ? 'border-red-500' : 'border-gray-300'" placeholder="+201234567890" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <p x-show="errors.registrant.phone" x-text="errors.registrant.phone" class="text-red-500 text-sm mt-1"></p>
                            </div>
                        </div>
                        <!-- Address -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'العنوان' : 'Address' }} <span class="text-red-500">*</span></label>
                            <input type="text" x-model="forms.registrant.address1" @input="errors.registrant.address1 = null" :class="errors.registrant.address1 ? 'border-red-500' : 'border-gray-300'" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 mb-2">
                            <p x-show="errors.registrant.address1" x-text="errors.registrant.address1" class="text-red-500 text-sm mt-1"></p>
                            <input type="text" x-model="forms.registrant.address2" placeholder="{{ app()->getLocale() == 'ar' ? 'العنوان 2 (اختياري)' : 'Address 2 (Optional)' }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <!-- City, State, Zip -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'المدينة' : 'City' }} <span class="text-red-500">*</span></label>
                                <input type="text" x-model="forms.registrant.city" @input="errors.registrant.city = null" :class="errors.registrant.city ? 'border-red-500' : 'border-gray-300'" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <p x-show="errors.registrant.city" x-text="errors.registrant.city" class="text-red-500 text-sm mt-1"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'المنطقة/الولاية' : 'State/Province' }} <span class="text-red-500">*</span></label>
                                <input type="text" x-model="forms.registrant.state" @input="errors.registrant.state = null" :class="errors.registrant.state ? 'border-red-500' : 'border-gray-300'" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <p x-show="errors.registrant.state" x-text="errors.registrant.state" class="text-red-500 text-sm mt-1"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'الرمز البريدي' : 'Postal Code' }} <span class="text-red-500">*</span></label>
                                <input type="text" x-model="forms.registrant.zip" @input="errors.registrant.zip = null" :class="errors.registrant.zip ? 'border-red-500' : 'border-gray-300'" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <p x-show="errors.registrant.zip" x-text="errors.registrant.zip" class="text-red-500 text-sm mt-1"></p>
                            </div>
                        </div>
                        <!-- Country -->
                        <div x-data="countrySelector('registrant')" class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'الدولة' : 'Country' }} <span class="text-red-500">*</span></label>
                            <p x-show="errors.registrant.country" x-text="errors.registrant.country" class="text-red-500 text-sm mb-1"></p>
                            <div class="relative">
                                <button type="button" @click="open = !open; errors.registrant.country = null" :class="errors.registrant.country ? 'border-red-500' : 'border-gray-300'" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-left flex items-center justify-between">
                                    <span x-text="getSelectedCountryName()" class="text-gray-900"></span>
                                    <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                <input type="hidden" x-model="forms.registrant.country">
                                <div x-show="open" @click.away="open = false" x-transition class="absolute z-[9999] w-full mt-2 bg-white border border-gray-300 rounded-xl shadow-2xl max-h-60 overflow-hidden">
                                    <div class="p-2 border-b border-gray-200 sticky top-0 bg-white">
                                        <input type="text" x-model="search" @input="filterCountries" placeholder="{{ app()->getLocale() == 'ar' ? 'ابحث عن دولة...' : 'Search country...' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div class="overflow-y-auto max-h-48">
                                        <template x-for="country in filteredCountries" :key="country.code">
                                            <button type="button" @click="selectCountry(country.code); open = false" class="w-full px-4 py-2.5 text-left hover:bg-blue-50 transition-colors" :class="{ 'bg-blue-100': forms.registrant.country === country.code }">
                                                <span x-text="country.name"></span>
                                            </button>
                                        </template>
                                        <div x-show="filteredCountries.length === 0" class="px-4 py-8 text-center text-gray-500">
                                            {{ app()->getLocale() == 'ar' ? 'لا توجد نتائج' : 'No results found' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end pt-4 border-t border-gray-100">
                            <button type="submit" :disabled="loading.registrant" class="px-5 py-2 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-colors disabled:opacity-50 flex items-center gap-2 text-sm">
                                <svg x-show="loading.registrant" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                {{ app()->getLocale() == 'ar' ? 'حفظ' : 'Save' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Admin Contact -->
            <div class="bg-white rounded-2xl border border-gray-200 overflow-visible">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between cursor-pointer" @click="toggleSection('admin')">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            {{ app()->getLocale() == 'ar' ? 'جهة الاتصال الإدارية (Admin)' : 'Admin Contact' }}
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">{{ app()->getLocale() == 'ar' ? 'المسؤول عن إدارة النطاق' : 'Responsible for domain management' }}</p>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': sections.admin }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
                <div x-show="sections.admin" x-collapse>
                    <form @submit.prevent="submitForm('admin')" class="p-6 space-y-4">
                        <!-- Success Message -->
                        <div x-show="successMessage.admin" x-transition class="p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span x-text="successMessage.admin" class="text-green-700 font-medium"></span>
                        </div>
                        <!-- General Error Message -->
                        <div x-show="errors.admin.general" x-transition class="p-4 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span x-text="errors.admin.general" class="text-red-700 font-medium"></span>
                        </div>
                        <div class="mb-4 p-3 bg-blue-50 rounded-xl">
                            <label class="inline-flex items-center gap-2 text-sm text-blue-700 cursor-pointer">
                                <input type="checkbox" x-model="copyFromRegistrant.admin" @change="if(copyFromRegistrant.admin) copyData('admin')" class="rounded border-blue-300 text-blue-600 focus:ring-blue-500">
                                {{ app()->getLocale() == 'ar' ? 'نسخ من بيانات المسجل' : 'Copy from Registrant' }}
                            </label>
                        </div>
                        <!-- Name Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'الاسم الأول' : 'First Name' }} <span class="text-red-500">*</span></label>
                                <input type="text" x-model="forms.admin.first_name" @input="errors.admin.first_name = null" :class="errors.admin.first_name ? 'border-red-500' : 'border-gray-300'" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <p x-show="errors.admin.first_name" x-text="errors.admin.first_name" class="text-red-500 text-sm mt-1"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'اسم العائلة' : 'Last Name' }} <span class="text-red-500">*</span></label>
                                <input type="text" x-model="forms.admin.last_name" @input="errors.admin.last_name = null" :class="errors.admin.last_name ? 'border-red-500' : 'border-gray-300'" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <p x-show="errors.admin.last_name" x-text="errors.admin.last_name" class="text-red-500 text-sm mt-1"></p>
                            </div>
                        </div>
                        <!-- Organization -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'المؤسسة/الشركة' : 'Organization' }}</label>
                            <input type="text" x-model="forms.admin.organization" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <!-- Email & Phone -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'البريد الإلكتروني' : 'Email' }} <span class="text-red-500">*</span></label>
                                <input type="email" x-model="forms.admin.email" @input="errors.admin.email = null" :class="errors.admin.email ? 'border-red-500' : 'border-gray-300'" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <p x-show="errors.admin.email" x-text="errors.admin.email" class="text-red-500 text-sm mt-1"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'رقم الهاتف' : 'Phone' }} <span class="text-red-500">*</span></label>
                                <input type="tel" x-model="forms.admin.phone" @input="errors.admin.phone = null" :class="errors.admin.phone ? 'border-red-500' : 'border-gray-300'" placeholder="+201234567890" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <p x-show="errors.admin.phone" x-text="errors.admin.phone" class="text-red-500 text-sm mt-1"></p>
                            </div>
                        </div>
                        <!-- Address -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'العنوان' : 'Address' }} <span class="text-red-500">*</span></label>
                            <input type="text" x-model="forms.admin.address1" @input="errors.admin.address1 = null" :class="errors.admin.address1 ? 'border-red-500' : 'border-gray-300'" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 mb-2">
                            <p x-show="errors.admin.address1" x-text="errors.admin.address1" class="text-red-500 text-sm mt-1"></p>
                            <input type="text" x-model="forms.admin.address2" placeholder="{{ app()->getLocale() == 'ar' ? 'العنوان 2 (اختياري)' : 'Address 2 (Optional)' }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <!-- City, State, Zip -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'المدينة' : 'City' }} <span class="text-red-500">*</span></label>
                                <input type="text" x-model="forms.admin.city" @input="errors.admin.city = null" :class="errors.admin.city ? 'border-red-500' : 'border-gray-300'" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <p x-show="errors.admin.city" x-text="errors.admin.city" class="text-red-500 text-sm mt-1"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'المنطقة/الولاية' : 'State/Province' }} <span class="text-red-500">*</span></label>
                                <input type="text" x-model="forms.admin.state" @input="errors.admin.state = null" :class="errors.admin.state ? 'border-red-500' : 'border-gray-300'" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <p x-show="errors.admin.state" x-text="errors.admin.state" class="text-red-500 text-sm mt-1"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'الرمز البريدي' : 'Postal Code' }} <span class="text-red-500">*</span></label>
                                <input type="text" x-model="forms.admin.zip" @input="errors.admin.zip = null" :class="errors.admin.zip ? 'border-red-500' : 'border-gray-300'" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <p x-show="errors.admin.zip" x-text="errors.admin.zip" class="text-red-500 text-sm mt-1"></p>
                            </div>
                        </div>
                        <!-- Country -->
                        <div x-data="countrySelector('admin')" class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'الدولة' : 'Country' }} <span class="text-red-500">*</span></label>
                            <p x-show="errors.admin.country" x-text="errors.admin.country" class="text-red-500 text-sm mb-1"></p>
                            <div class="relative">
                                <button type="button" @click="open = !open" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-left flex items-center justify-between">
                                    <span x-text="getSelectedCountryName()" class="text-gray-900"></span>
                                    <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                <input type="hidden" x-model="forms.admin.country">
                                <div x-show="open" @click.away="open = false" x-transition class="absolute z-[9999] w-full mt-2 bg-white border border-gray-300 rounded-xl shadow-2xl max-h-60 overflow-hidden">
                                    <div class="p-2 border-b border-gray-200 sticky top-0 bg-white">
                                        <input type="text" x-model="search" @input="filterCountries" placeholder="{{ app()->getLocale() == 'ar' ? 'ابحث عن دولة...' : 'Search country...' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div class="overflow-y-auto max-h-48">
                                        <template x-for="country in filteredCountries" :key="country.code">
                                            <button type="button" @click="selectCountry(country.code); open = false" class="w-full px-4 py-2.5 text-left hover:bg-blue-50 transition-colors" :class="{ 'bg-blue-100': forms.admin.country === country.code }">
                                                <span x-text="country.name"></span>
                                            </button>
                                        </template>
                                        <div x-show="filteredCountries.length === 0" class="px-4 py-8 text-center text-gray-500">
                                            {{ app()->getLocale() == 'ar' ? 'لا توجد نتائج' : 'No results found' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end pt-4 border-t border-gray-100">
                            <button type="submit" :disabled="loading.admin" class="px-5 py-2 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-colors disabled:opacity-50 flex items-center gap-2 text-sm">
                                <svg x-show="loading.admin" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                {{ app()->getLocale() == 'ar' ? 'حفظ' : 'Save' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Technical Contact -->
            <div class="bg-white rounded-2xl border border-gray-200 overflow-visible">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between cursor-pointer" @click="toggleSection('technical')">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ app()->getLocale() == 'ar' ? 'جهة الاتصال التقنية (Technical)' : 'Technical Contact' }}
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">{{ app()->getLocale() == 'ar' ? 'المسؤول عن الأمور التقنية' : 'Responsible for technical matters' }}</p>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': sections.technical }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
                <div x-show="sections.technical" x-collapse>
                    <form @submit.prevent="submitForm('technical')" class="p-6 space-y-4">
                        <!-- Success Message -->
                        <div x-show="successMessage.technical" x-transition class="p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span x-text="successMessage.technical" class="text-green-700 font-medium"></span>
                        </div>
                        <!-- General Error Message -->
                        <div x-show="errors.technical.general" x-transition class="p-4 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span x-text="errors.technical.general" class="text-red-700 font-medium"></span>
                        </div>
                        <div class="mb-4 p-3 bg-cyan-50 rounded-xl">
                            <label class="inline-flex items-center gap-2 text-sm text-cyan-700 cursor-pointer">
                                <input type="checkbox" x-model="copyFromRegistrant.technical" @change="if(copyFromRegistrant.technical) copyData('technical')" class="rounded border-cyan-300 text-cyan-600 focus:ring-cyan-500">
                                {{ app()->getLocale() == 'ar' ? 'نسخ من بيانات المسجل' : 'Copy from Registrant' }}
                            </label>
                        </div>
                        <!-- Name Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'الاسم الأول' : 'First Name' }} <span class="text-red-500">*</span></label>
                                <input type="text" x-model="forms.technical.first_name" @input="errors.technical.first_name = null" :class="errors.technical.first_name ? 'border-red-500' : 'border-gray-300'" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <p x-show="errors.technical.first_name" x-text="errors.technical.first_name" class="text-red-500 text-sm mt-1"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'اسم العائلة' : 'Last Name' }} <span class="text-red-500">*</span></label>
                                <input type="text" x-model="forms.technical.last_name" @input="errors.technical.last_name = null" :class="errors.technical.last_name ? 'border-red-500' : 'border-gray-300'" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <p x-show="errors.technical.last_name" x-text="errors.technical.last_name" class="text-red-500 text-sm mt-1"></p>
                            </div>
                        </div>
                        <!-- Organization -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'المؤسسة/الشركة' : 'Organization' }}</label>
                            <input type="text" x-model="forms.technical.organization" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <!-- Email & Phone -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'البريد الإلكتروني' : 'Email' }} <span class="text-red-500">*</span></label>
                                <input type="email" x-model="forms.technical.email" @input="errors.technical.email = null" :class="errors.technical.email ? 'border-red-500' : 'border-gray-300'" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <p x-show="errors.technical.email" x-text="errors.technical.email" class="text-red-500 text-sm mt-1"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'رقم الهاتف' : 'Phone' }} <span class="text-red-500">*</span></label>
                                <input type="tel" x-model="forms.technical.phone" @input="errors.technical.phone = null" :class="errors.technical.phone ? 'border-red-500' : 'border-gray-300'" placeholder="+201234567890" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <p x-show="errors.technical.phone" x-text="errors.technical.phone" class="text-red-500 text-sm mt-1"></p>
                            </div>
                        </div>
                        <!-- Address -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'العنوان' : 'Address' }} <span class="text-red-500">*</span></label>
                            <input type="text" x-model="forms.technical.address1" @input="errors.technical.address1 = null" :class="errors.technical.address1 ? 'border-red-500' : 'border-gray-300'" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 mb-2">
                            <p x-show="errors.technical.address1" x-text="errors.technical.address1" class="text-red-500 text-sm mt-1"></p>
                            <input type="text" x-model="forms.technical.address2" placeholder="{{ app()->getLocale() == 'ar' ? 'العنوان 2 (اختياري)' : 'Address 2 (Optional)' }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <!-- City, State, Zip -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'المدينة' : 'City' }} <span class="text-red-500">*</span></label>
                                <input type="text" x-model="forms.technical.city" @input="errors.technical.city = null" :class="errors.technical.city ? 'border-red-500' : 'border-gray-300'" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <p x-show="errors.technical.city" x-text="errors.technical.city" class="text-red-500 text-sm mt-1"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'المنطقة/الولاية' : 'State/Province' }} <span class="text-red-500">*</span></label>
                                <input type="text" x-model="forms.technical.state" @input="errors.technical.state = null" :class="errors.technical.state ? 'border-red-500' : 'border-gray-300'" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <p x-show="errors.technical.state" x-text="errors.technical.state" class="text-red-500 text-sm mt-1"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'الرمز البريدي' : 'Postal Code' }} <span class="text-red-500">*</span></label>
                                <input type="text" x-model="forms.technical.zip" @input="errors.technical.zip = null" :class="errors.technical.zip ? 'border-red-500' : 'border-gray-300'" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <p x-show="errors.technical.zip" x-text="errors.technical.zip" class="text-red-500 text-sm mt-1"></p>
                            </div>
                        </div>
                        <!-- Country -->
                        <div x-data="countrySelector('technical')" class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'الدولة' : 'Country' }} <span class="text-red-500">*</span></label>
                            <p x-show="errors.technical.country" x-text="errors.technical.country" class="text-red-500 text-sm mb-1"></p>
                            <div class="relative">
                                <button type="button" @click="open = !open; errors.technical.country = null" :class="errors.technical.country ? 'border-red-500' : 'border-gray-300'" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-left flex items-center justify-between">
                                    <span x-text="getSelectedCountryName()" class="text-gray-900"></span>
                                    <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                <input type="hidden" x-model="forms.technical.country">
                                <div x-show="open" @click.away="open = false" x-transition class="absolute z-[9999] w-full mt-2 bg-white border border-gray-300 rounded-xl shadow-2xl max-h-60 overflow-hidden">
                                    <div class="p-2 border-b border-gray-200 sticky top-0 bg-white">
                                        <input type="text" x-model="search" @input="filterCountries" placeholder="{{ app()->getLocale() == 'ar' ? 'ابحث عن دولة...' : 'Search country...' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div class="overflow-y-auto max-h-48">
                                        <template x-for="country in filteredCountries" :key="country.code">
                                            <button type="button" @click="selectCountry(country.code); open = false" class="w-full px-4 py-2.5 text-left hover:bg-blue-50 transition-colors" :class="{ 'bg-blue-100': forms.technical.country === country.code }">
                                                <span x-text="country.name"></span>
                                            </button>
                                        </template>
                                        <div x-show="filteredCountries.length === 0" class="px-4 py-8 text-center text-gray-500">
                                            {{ app()->getLocale() == 'ar' ? 'لا توجد نتائج' : 'No results found' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end pt-4 border-t border-gray-100">
                            <button type="submit" :disabled="loading.technical" class="px-5 py-2 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-colors disabled:opacity-50 flex items-center gap-2 text-sm">
                                <svg x-show="loading.technical" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                {{ app()->getLocale() == 'ar' ? 'حفظ' : 'Save' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Billing Contact -->
            <div class="bg-white rounded-2xl border border-gray-200 overflow-visible">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between cursor-pointer" @click="toggleSection('billing')">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            {{ app()->getLocale() == 'ar' ? 'جهة اتصال الفوترة (Billing)' : 'Billing Contact' }}
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">{{ app()->getLocale() == 'ar' ? 'المسؤول عن الفواتير والمدفوعات' : 'Responsible for billing and payments' }}</p>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': sections.billing }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
                <div x-show="sections.billing" x-collapse>
                    <form @submit.prevent="submitForm('billing')" class="p-6 space-y-4">
                        <!-- Success Message -->
                        <div x-show="successMessage.billing" x-transition class="p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span x-text="successMessage.billing" class="text-green-700 font-medium"></span>
                        </div>
                        <!-- General Error Message -->
                        <div x-show="errors.billing.general" x-transition class="p-4 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span x-text="errors.billing.general" class="text-red-700 font-medium"></span>
                        </div>
                        <div class="mb-4 p-3 bg-amber-50 rounded-xl">
                            <label class="inline-flex items-center gap-2 text-sm text-amber-700 cursor-pointer">
                                <input type="checkbox" x-model="copyFromRegistrant.billing" @change="if(copyFromRegistrant.billing) copyData('billing')" class="rounded border-amber-300 text-amber-600 focus:ring-amber-500">
                                {{ app()->getLocale() == 'ar' ? 'نسخ من بيانات المسجل' : 'Copy from Registrant' }}
                            </label>
                        </div>
                        <!-- Name Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'الاسم الأول' : 'First Name' }} <span class="text-red-500">*</span></label>
                                <input type="text" x-model="forms.billing.first_name" @input="errors.billing.first_name = null" :class="errors.billing.first_name ? 'border-red-500' : 'border-gray-300'" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <p x-show="errors.billing.first_name" x-text="errors.billing.first_name" class="text-red-500 text-sm mt-1"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'اسم العائلة' : 'Last Name' }} <span class="text-red-500">*</span></label>
                                <input type="text" x-model="forms.billing.last_name" @input="errors.billing.last_name = null" :class="errors.billing.last_name ? 'border-red-500' : 'border-gray-300'" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <p x-show="errors.billing.last_name" x-text="errors.billing.last_name" class="text-red-500 text-sm mt-1"></p>
                            </div>
                        </div>
                        <!-- Organization -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'المؤسسة/الشركة' : 'Organization' }}</label>
                            <input type="text" x-model="forms.billing.organization" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <!-- Email & Phone -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'البريد الإلكتروني' : 'Email' }} <span class="text-red-500">*</span></label>
                                <input type="email" x-model="forms.billing.email" @input="errors.billing.email = null" :class="errors.billing.email ? 'border-red-500' : 'border-gray-300'" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <p x-show="errors.billing.email" x-text="errors.billing.email" class="text-red-500 text-sm mt-1"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'رقم الهاتف' : 'Phone' }} <span class="text-red-500">*</span></label>
                                <input type="tel" x-model="forms.billing.phone" @input="errors.billing.phone = null" :class="errors.billing.phone ? 'border-red-500' : 'border-gray-300'" placeholder="+201234567890" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <p x-show="errors.billing.phone" x-text="errors.billing.phone" class="text-red-500 text-sm mt-1"></p>
                            </div>
                        </div>
                        <!-- Address -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'العنوان' : 'Address' }} <span class="text-red-500">*</span></label>
                            <input type="text" x-model="forms.billing.address1" @input="errors.billing.address1 = null" :class="errors.billing.address1 ? 'border-red-500' : 'border-gray-300'" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 mb-2">
                            <p x-show="errors.billing.address1" x-text="errors.billing.address1" class="text-red-500 text-sm mt-1"></p>
                            <input type="text" x-model="forms.billing.address2" placeholder="{{ app()->getLocale() == 'ar' ? 'العنوان 2 (اختياري)' : 'Address 2 (Optional)' }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <!-- City, State, Zip -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'المدينة' : 'City' }} <span class="text-red-500">*</span></label>
                                <input type="text" x-model="forms.billing.city" @input="errors.billing.city = null" :class="errors.billing.city ? 'border-red-500' : 'border-gray-300'" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <p x-show="errors.billing.city" x-text="errors.billing.city" class="text-red-500 text-sm mt-1"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'المنطقة/الولاية' : 'State/Province' }} <span class="text-red-500">*</span></label>
                                <input type="text" x-model="forms.billing.state" @input="errors.billing.state = null" :class="errors.billing.state ? 'border-red-500' : 'border-gray-300'" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <p x-show="errors.billing.state" x-text="errors.billing.state" class="text-red-500 text-sm mt-1"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'الرمز البريدي' : 'Postal Code' }} <span class="text-red-500">*</span></label>
                                <input type="text" x-model="forms.billing.zip" @input="errors.billing.zip = null" :class="errors.billing.zip ? 'border-red-500' : 'border-gray-300'" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <p x-show="errors.billing.zip" x-text="errors.billing.zip" class="text-red-500 text-sm mt-1"></p>
                            </div>
                        </div>
                        <!-- Country -->
                        <div x-data="countrySelector('billing')" class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() == 'ar' ? 'الدولة' : 'Country' }} <span class="text-red-500">*</span></label>
                            <p x-show="errors.billing.country" x-text="errors.billing.country" class="text-red-500 text-sm mb-1"></p>
                            <div class="relative">
                                <button type="button" @click="open = !open; errors.billing.country = null" :class="errors.billing.country ? 'border-red-500' : 'border-gray-300'" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-left flex items-center justify-between">
                                    <span x-text="getSelectedCountryName()" class="text-gray-900"></span>
                                    <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                <input type="hidden" x-model="forms.billing.country">
                                <div x-show="open" @click.away="open = false" x-transition class="absolute z-[9999] w-full mt-2 bg-white border border-gray-300 rounded-xl shadow-2xl max-h-60 overflow-hidden">
                                    <div class="p-2 border-b border-gray-200 sticky top-0 bg-white">
                                        <input type="text" x-model="search" @input="filterCountries" placeholder="{{ app()->getLocale() == 'ar' ? 'ابحث عن دولة...' : 'Search country...' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div class="overflow-y-auto max-h-48">
                                        <template x-for="country in filteredCountries" :key="country.code">
                                            <button type="button" @click="selectCountry(country.code); open = false" class="w-full px-4 py-2.5 text-left hover:bg-blue-50 transition-colors" :class="{ 'bg-blue-100': forms.billing.country === country.code }">
                                                <span x-text="country.name"></span>
                                            </button>
                                        </template>
                                        <div x-show="filteredCountries.length === 0" class="px-4 py-8 text-center text-gray-500">
                                            {{ app()->getLocale() == 'ar' ? 'لا توجد نتائج' : 'No results found' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end pt-4 border-t border-gray-100">
                            <button type="submit" :disabled="loading.billing" class="px-5 py-2 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-colors disabled:opacity-50 flex items-center gap-2 text-sm">
                                <svg x-show="loading.billing" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                {{ app()->getLocale() == 'ar' ? 'حفظ' : 'Save' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            </div>
        </div>
    </div>
</div>

<!-- Info Notice -->
        <div class="mt-6 p-4 bg-amber-50 border border-amber-200 rounded-xl">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div>
                    <p class="text-sm font-medium text-amber-800">{{ app()->getLocale() == 'ar' ? 'ملاحظة مهمة' : 'Important Notice' }}</p>
                    <p class="text-sm text-amber-700 mt-1">{{ app()->getLocale() == 'ar' ? 'تغيير معلومات الاتصال قد يتطلب تأكيداً عبر البريد الإلكتروني وقد يستغرق بعض الوقت للتفعيل.' : 'Changing contact information may require email verification and may take some time to take effect.' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const countries = [
    {code: 'AF', name: 'Afghanistan'}, {code: 'AX', name: 'Åland Islands'}, {code: 'AL', name: 'Albania'},
    {code: 'DZ', name: 'Algeria'}, {code: 'AS', name: 'American Samoa'}, {code: 'AD', name: 'Andorra'},
    {code: 'AO', name: 'Angola'}, {code: 'AI', name: 'Anguilla'}, {code: 'AQ', name: 'Antarctica'},
    {code: 'AG', name: 'Antigua and Barbuda'}, {code: 'AR', name: 'Argentina'}, {code: 'AM', name: 'Armenia'},
    {code: 'AW', name: 'Aruba'}, {code: 'AU', name: 'Australia'}, {code: 'AT', name: 'Austria'},
    {code: 'AZ', name: 'Azerbaijan'}, {code: 'BS', name: 'Bahamas'}, {code: 'BH', name: 'Bahrain'},
    {code: 'BD', name: 'Bangladesh'}, {code: 'BB', name: 'Barbados'}, {code: 'BY', name: 'Belarus'},
    {code: 'BE', name: 'Belgium'}, {code: 'BZ', name: 'Belize'}, {code: 'BJ', name: 'Benin'},
    {code: 'BM', name: 'Bermuda'}, {code: 'BT', name: 'Bhutan'}, {code: 'BO', name: 'Bolivia'},
    {code: 'BQ', name: 'Bonaire, Sint Eustatius and Saba'}, {code: 'BA', name: 'Bosnia and Herzegovina'},
    {code: 'BW', name: 'Botswana'}, {code: 'BV', name: 'Bouvet Island'}, {code: 'BR', name: 'Brazil'},
    {code: 'IO', name: 'British Indian Ocean Territory'}, {code: 'BN', name: 'Brunei Darussalam'},
    {code: 'BG', name: 'Bulgaria'}, {code: 'BF', name: 'Burkina Faso'}, {code: 'BI', name: 'Burundi'},
    {code: 'KH', name: 'Cambodia'}, {code: 'CM', name: 'Cameroon'}, {code: 'CA', name: 'Canada'},
    {code: 'CV', name: 'Cape Verde'}, {code: 'KY', name: 'Cayman Islands'}, {code: 'CF', name: 'Central African Republic'},
    {code: 'TD', name: 'Chad'}, {code: 'CL', name: 'Chile'}, {code: 'CN', name: 'China'},
    {code: 'CX', name: 'Christmas Island'}, {code: 'CC', name: 'Cocos (Keeling) Islands'}, {code: 'CO', name: 'Colombia'},
    {code: 'KM', name: 'Comoros'}, {code: 'CG', name: 'Congo'}, {code: 'CD', name: 'Congo, Democratic Republic'},
    {code: 'CK', name: 'Cook Islands'}, {code: 'CR', name: 'Costa Rica'}, {code: 'CI', name: "Côte d'Ivoire"},
    {code: 'HR', name: 'Croatia'}, {code: 'CU', name: 'Cuba'}, {code: 'CW', name: 'Curaçao'},
    {code: 'CY', name: 'Cyprus'}, {code: 'CZ', name: 'Czech Republic'}, {code: 'DK', name: 'Denmark'},
    {code: 'DJ', name: 'Djibouti'}, {code: 'DM', name: 'Dominica'}, {code: 'DO', name: 'Dominican Republic'},
    {code: 'EC', name: 'Ecuador'}, {code: 'EG', name: 'Egypt'}, {code: 'SV', name: 'El Salvador'},
    {code: 'GQ', name: 'Equatorial Guinea'}, {code: 'ER', name: 'Eritrea'}, {code: 'EE', name: 'Estonia'},
    {code: 'ET', name: 'Ethiopia'}, {code: 'FK', name: 'Falkland Islands'}, {code: 'FO', name: 'Faroe Islands'},
    {code: 'FJ', name: 'Fiji'}, {code: 'FI', name: 'Finland'}, {code: 'FR', name: 'France'},
    {code: 'GF', name: 'French Guiana'}, {code: 'PF', name: 'French Polynesia'}, {code: 'TF', name: 'French Southern Territories'},
    {code: 'GA', name: 'Gabon'}, {code: 'GM', name: 'Gambia'}, {code: 'GE', name: 'Georgia'},
    {code: 'DE', name: 'Germany'}, {code: 'GH', name: 'Ghana'}, {code: 'GI', name: 'Gibraltar'},
    {code: 'GR', name: 'Greece'}, {code: 'GL', name: 'Greenland'}, {code: 'GD', name: 'Grenada'},
    {code: 'GP', name: 'Guadeloupe'}, {code: 'GU', name: 'Guam'}, {code: 'GT', name: 'Guatemala'},
    {code: 'GG', name: 'Guernsey'}, {code: 'GN', name: 'Guinea'}, {code: 'GW', name: 'Guinea-Bissau'},
    {code: 'GY', name: 'Guyana'}, {code: 'HT', name: 'Haiti'}, {code: 'HM', name: 'Heard Island and McDonald Islands'},
    {code: 'VA', name: 'Holy See (Vatican City State)'}, {code: 'HN', name: 'Honduras'}, {code: 'HK', name: 'Hong Kong'},
    {code: 'HU', name: 'Hungary'}, {code: 'IS', name: 'Iceland'}, {code: 'IN', name: 'India'},
    {code: 'ID', name: 'Indonesia'}, {code: 'IR', name: 'Iran'}, {code: 'IQ', name: 'Iraq'},
    {code: 'IE', name: 'Ireland'}, {code: 'IM', name: 'Isle of Man'}, {code: 'IL', name: 'Israel'},
    {code: 'IT', name: 'Italy'}, {code: 'JM', name: 'Jamaica'}, {code: 'JP', name: 'Japan'},
    {code: 'JE', name: 'Jersey'}, {code: 'JO', name: 'Jordan'}, {code: 'KZ', name: 'Kazakhstan'},
    {code: 'KE', name: 'Kenya'}, {code: 'KI', name: 'Kiribati'}, {code: 'KP', name: 'Korea, North'},
    {code: 'KR', name: 'Korea, South'}, {code: 'KW', name: 'Kuwait'}, {code: 'KG', name: 'Kyrgyzstan'},
    {code: 'LA', name: 'Laos'}, {code: 'LV', name: 'Latvia'}, {code: 'LB', name: 'Lebanon'},
    {code: 'LS', name: 'Lesotho'}, {code: 'LR', name: 'Liberia'}, {code: 'LY', name: 'Libya'},
    {code: 'LI', name: 'Liechtenstein'}, {code: 'LT', name: 'Lithuania'}, {code: 'LU', name: 'Luxembourg'},
    {code: 'MO', name: 'Macao'}, {code: 'MK', name: 'Macedonia'}, {code: 'MG', name: 'Madagascar'},
    {code: 'MW', name: 'Malawi'}, {code: 'MY', name: 'Malaysia'}, {code: 'MV', name: 'Maldives'},
    {code: 'ML', name: 'Mali'}, {code: 'MT', name: 'Malta'}, {code: 'MH', name: 'Marshall Islands'},
    {code: 'MQ', name: 'Martinique'}, {code: 'MR', name: 'Mauritania'}, {code: 'MU', name: 'Mauritius'},
    {code: 'YT', name: 'Mayotte'}, {code: 'MX', name: 'Mexico'}, {code: 'FM', name: 'Micronesia'},
    {code: 'MD', name: 'Moldova'}, {code: 'MC', name: 'Monaco'}, {code: 'MN', name: 'Mongolia'},
    {code: 'ME', name: 'Montenegro'}, {code: 'MS', name: 'Montserrat'}, {code: 'MA', name: 'Morocco'},
    {code: 'MZ', name: 'Mozambique'}, {code: 'MM', name: 'Myanmar'}, {code: 'NA', name: 'Namibia'},
    {code: 'NR', name: 'Nauru'}, {code: 'NP', name: 'Nepal'}, {code: 'NL', name: 'Netherlands'},
    {code: 'NC', name: 'New Caledonia'}, {code: 'NZ', name: 'New Zealand'}, {code: 'NI', name: 'Nicaragua'},
    {code: 'NE', name: 'Niger'}, {code: 'NG', name: 'Nigeria'}, {code: 'NU', name: 'Niue'},
    {code: 'NF', name: 'Norfolk Island'}, {code: 'MP', name: 'Northern Mariana Islands'}, {code: 'NO', name: 'Norway'},
    {code: 'OM', name: 'Oman'}, {code: 'PK', name: 'Pakistan'}, {code: 'PW', name: 'Palau'},
    {code: 'PS', name: 'Palestine'}, {code: 'PA', name: 'Panama'}, {code: 'PG', name: 'Papua New Guinea'},
    {code: 'PY', name: 'Paraguay'}, {code: 'PE', name: 'Peru'}, {code: 'PH', name: 'Philippines'},
    {code: 'PN', name: 'Pitcairn'}, {code: 'PL', name: 'Poland'}, {code: 'PT', name: 'Portugal'},
    {code: 'PR', name: 'Puerto Rico'}, {code: 'QA', name: 'Qatar'}, {code: 'RE', name: 'Réunion'},
    {code: 'RO', name: 'Romania'}, {code: 'RU', name: 'Russian Federation'}, {code: 'RW', name: 'Rwanda'},
    {code: 'BL', name: 'Saint Barthélemy'}, {code: 'SH', name: 'Saint Helena'}, {code: 'KN', name: 'Saint Kitts and Nevis'},
    {code: 'LC', name: 'Saint Lucia'}, {code: 'MF', name: 'Saint Martin'}, {code: 'PM', name: 'Saint Pierre and Miquelon'},
    {code: 'VC', name: 'Saint Vincent and the Grenadines'}, {code: 'WS', name: 'Samoa'}, {code: 'SM', name: 'San Marino'},
    {code: 'ST', name: 'Sao Tome and Principe'}, {code: 'SA', name: 'Saudi Arabia'}, {code: 'SN', name: 'Senegal'},
    {code: 'RS', name: 'Serbia'}, {code: 'SC', name: 'Seychelles'}, {code: 'SL', name: 'Sierra Leone'},
    {code: 'SG', name: 'Singapore'}, {code: 'SX', name: 'Sint Maarten'}, {code: 'SK', name: 'Slovakia'},
    {code: 'SI', name: 'Slovenia'}, {code: 'SB', name: 'Solomon Islands'}, {code: 'SO', name: 'Somalia'},
    {code: 'ZA', name: 'South Africa'}, {code: 'GS', name: 'South Georgia'}, {code: 'SS', name: 'South Sudan'},
    {code: 'ES', name: 'Spain'}, {code: 'LK', name: 'Sri Lanka'}, {code: 'SD', name: 'Sudan'},
    {code: 'SR', name: 'Suriname'}, {code: 'SJ', name: 'Svalbard and Jan Mayen'}, {code: 'SZ', name: 'Swaziland'},
    {code: 'SE', name: 'Sweden'}, {code: 'CH', name: 'Switzerland'}, {code: 'SY', name: 'Syrian Arab Republic'},
    {code: 'TW', name: 'Taiwan'}, {code: 'TJ', name: 'Tajikistan'}, {code: 'TZ', name: 'Tanzania'},
    {code: 'TH', name: 'Thailand'}, {code: 'TL', name: 'Timor-Leste'}, {code: 'TG', name: 'Togo'},
    {code: 'TK', name: 'Tokelau'}, {code: 'TO', name: 'Tonga'}, {code: 'TT', name: 'Trinidad and Tobago'},
    {code: 'TN', name: 'Tunisia'}, {code: 'TR', name: 'Turkey'}, {code: 'TM', name: 'Turkmenistan'},
    {code: 'TC', name: 'Turks and Caicos Islands'}, {code: 'TV', name: 'Tuvalu'}, {code: 'UG', name: 'Uganda'},
    {code: 'UA', name: 'Ukraine'}, {code: 'AE', name: 'United Arab Emirates'}, {code: 'GB', name: 'United Kingdom'},
    {code: 'US', name: 'United States'}, {code: 'UM', name: 'United States Minor Outlying Islands'}, {code: 'UY', name: 'Uruguay'},
    {code: 'UZ', name: 'Uzbekistan'}, {code: 'VU', name: 'Vanuatu'}, {code: 'VE', name: 'Venezuela'},
    {code: 'VN', name: 'Vietnam'}, {code: 'VG', name: 'Virgin Islands, British'}, {code: 'VI', name: 'Virgin Islands, U.S.'},
    {code: 'WF', name: 'Wallis and Futuna'}, {code: 'EH', name: 'Western Sahara'}, {code: 'YE', name: 'Yemen'},
    {code: 'ZM', name: 'Zambia'}, {code: 'ZW', name: 'Zimbabwe'}
];

function countrySelector(formType) {
    return {
        open: false,
        search: '',
        filteredCountries: countries,
        
        getSelectedCountryName() {
            const selectedCode = this.forms[formType].country;
            if (!selectedCode) return '{{ app()->getLocale() == 'ar' ? 'اختر الدولة' : 'Select Country' }}';
            const country = countries.find(c => c.code === selectedCode);
            return country ? country.name : '{{ app()->getLocale() == 'ar' ? 'اختر الدولة' : 'Select Country' }}';
        },
        
        filterCountries() {
            if (!this.search.trim()) {
                this.filteredCountries = countries;
            } else {
                const searchLower = this.search.toLowerCase();
                this.filteredCountries = countries.filter(c => 
                    c.name.toLowerCase().includes(searchLower) || 
                    c.code.toLowerCase().includes(searchLower)
                );
            }
        },
        
        selectCountry(code) {
            this.forms[formType].country = code;
            this.search = '';
            this.filteredCountries = countries;
        }
    }
}

function contactsManager() {
    const defaultContact = {
        first_name: '',
        last_name: '',
        organization: '',
        email: '',
        phone: '',
        address1: '',
        address2: '',
        city: '',
        state: '',
        zip: '',
        country: ''
    };
    
    return {
        sections: {
            registrant: true,
            admin: false,
            technical: false,
            billing: false
        },
        loading: {
            registrant: false,
            admin: false,
            technical: false,
            billing: false
        },
        copyFromRegistrant: {
            admin: false,
            technical: false,
            billing: false
        },
        errors: {
            registrant: {},
            admin: {},
            technical: {},
            billing: {}
        },
        successMessage: {
            registrant: '',
            admin: '',
            technical: '',
            billing: ''
        },
        forms: {
            registrant: { ...defaultContact, ...@js($contacts['registrant'] ?? []) },
            admin: { ...defaultContact, ...@js($contacts['admin'] ?? $contacts['registrant'] ?? []) },
            technical: { ...defaultContact, ...@js($contacts['technical'] ?? $contacts['registrant'] ?? []) },
            billing: { ...defaultContact, ...@js($contacts['billing'] ?? $contacts['registrant'] ?? []) }
        },
        
        toggleSection(section) {
            this.sections[section] = !this.sections[section];
        },
        
        copyData(target) {
            this.forms[target] = { ...this.forms.registrant };
        },
        
        async submitForm(type) {
            // Clear previous errors and success message
            this.errors[type] = {};
            this.successMessage[type] = '';
            
            const form = this.forms[type];
            const fieldLabels = {
                first_name: '{{ app()->getLocale() == 'ar' ? 'الاسم الأول مطلوب' : 'First Name is required' }}',
                last_name: '{{ app()->getLocale() == 'ar' ? 'اسم العائلة مطلوب' : 'Last Name is required' }}',
                email: '{{ app()->getLocale() == 'ar' ? 'البريد الإلكتروني مطلوب' : 'Email is required' }}',
                phone: '{{ app()->getLocale() == 'ar' ? 'رقم الهاتف مطلوب' : 'Phone is required' }}',
                address1: '{{ app()->getLocale() == 'ar' ? 'العنوان مطلوب' : 'Address is required' }}',
                city: '{{ app()->getLocale() == 'ar' ? 'المدينة مطلوبة' : 'City is required' }}',
                state: '{{ app()->getLocale() == 'ar' ? 'المنطقة مطلوبة' : 'State is required' }}',
                zip: '{{ app()->getLocale() == 'ar' ? 'الرمز البريدي مطلوب' : 'Postal Code is required' }}',
                country: '{{ app()->getLocale() == 'ar' ? 'الدولة مطلوبة' : 'Country is required' }}'
            };
            
            // Check required fields
            const requiredFields = ['first_name', 'last_name', 'email', 'phone', 'address1', 'city', 'state', 'zip', 'country'];
            let hasErrors = false;
            
            requiredFields.forEach(field => {
                if (!form[field] || form[field].trim() === '') {
                    this.errors[type][field] = fieldLabels[field];
                    hasErrors = true;
                }
            });
            
            // Validate patterns
            const namePattern = /^[A-Za-z\s]+$/;
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const addressPattern = /^[A-Za-z0-9\s.,'#/-]+$/;
            const cityStatePattern = /^[A-Za-z\s]+$/;
            const zipPattern = /^[A-Za-z0-9\s-]+$/;
            
            if (form.first_name && !namePattern.test(form.first_name)) {
                this.errors[type].first_name = '{{ app()->getLocale() == 'ar' ? 'أحرف إنجليزية فقط' : 'English letters only' }}';
                hasErrors = true;
            }
            if (form.last_name && !namePattern.test(form.last_name)) {
                this.errors[type].last_name = '{{ app()->getLocale() == 'ar' ? 'أحرف إنجليزية فقط' : 'English letters only' }}';
                hasErrors = true;
            }
            if (form.email && !emailPattern.test(form.email)) {
                this.errors[type].email = '{{ app()->getLocale() == 'ar' ? 'بريد إلكتروني غير صحيح' : 'Invalid email' }}';
                hasErrors = true;
            }
            if (form.address1 && !addressPattern.test(form.address1)) {
                this.errors[type].address1 = '{{ app()->getLocale() == 'ar' ? 'أحرف إنجليزية وأرقام فقط' : 'English letters and numbers only' }}';
                hasErrors = true;
            }
            if (form.city && !cityStatePattern.test(form.city)) {
                this.errors[type].city = '{{ app()->getLocale() == 'ar' ? 'أحرف إنجليزية فقط' : 'English letters only' }}';
                hasErrors = true;
            }
            if (form.state && !cityStatePattern.test(form.state)) {
                this.errors[type].state = '{{ app()->getLocale() == 'ar' ? 'أحرف إنجليزية فقط' : 'English letters only' }}';
                hasErrors = true;
            }
            if (form.zip && !zipPattern.test(form.zip)) {
                this.errors[type].zip = '{{ app()->getLocale() == 'ar' ? 'أحرف إنجليزية وأرقام فقط' : 'English letters and numbers only' }}';
                hasErrors = true;
            }
            
            if (hasErrors) {
                return;
            }
            
            this.loading[type] = true;
            try {
                const res = await fetch('{{ route('client.domains.contacts.update', $domain) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        contact_type: type,
                        contact: this.forms[type]
                    })
                });
                const data = await res.json();
                if (data.success) {
                    this.successMessage[type] = data.message || '{{ app()->getLocale() == 'ar' ? 'تم الحفظ بنجاح' : 'Saved successfully' }}';
                    setTimeout(() => this.successMessage[type] = '', 5000);
                } else {
                    // Parse backend error and show in field
                    const errorMsg = data.message || '{{ app()->getLocale() == 'ar' ? 'حدث خطأ' : 'An error occurred' }}';
                    
                    // Try to detect which field the error is about
                    if (errorMsg.toLowerCase().includes('phone')) {
                        this.errors[type].phone = errorMsg;
                    } else if (errorMsg.toLowerCase().includes('email')) {
                        this.errors[type].email = errorMsg;
                    } else if (errorMsg.toLowerCase().includes('address')) {
                        this.errors[type].address1 = errorMsg;
                    } else if (errorMsg.toLowerCase().includes('city')) {
                        this.errors[type].city = errorMsg;
                    } else if (errorMsg.toLowerCase().includes('state') || errorMsg.toLowerCase().includes('province')) {
                        this.errors[type].state = errorMsg;
                    } else if (errorMsg.toLowerCase().includes('zip') || errorMsg.toLowerCase().includes('postal')) {
                        this.errors[type].zip = errorMsg;
                    } else if (errorMsg.toLowerCase().includes('country')) {
                        this.errors[type].country = errorMsg;
                    } else if (errorMsg.toLowerCase().includes('missing') && errorMsg.toLowerCase().includes('contact')) {
                        // Missing contact error - show as general error
                        this.errors[type].general = errorMsg;
                    } else if (errorMsg.toLowerCase().includes('name')) {
                        this.errors[type].first_name = errorMsg;
                    } else {
                        // General error
                        this.errors[type].general = errorMsg;
                    }
                }
            } catch (e) {
                this.errors[type].first_name = '{{ app()->getLocale() == 'ar' ? 'حدث خطأ في الاتصال' : 'Connection error' }}';
            }
            this.loading[type] = false;
        }
    }
}
</script>
@endsection






