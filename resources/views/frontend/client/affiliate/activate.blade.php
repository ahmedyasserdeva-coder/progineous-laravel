@extends('frontend.client.layout')

@section('title', app()->getLocale() == 'ar' ? 'برنامج التسويق بالعمولة' : 'Affiliate Program')

@section('content')
<div class="space-y-6">
    @php $rtl = app()->getLocale() == 'ar'; @endphp
    
    <!-- Page Header -->
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
            {{ app()->getLocale() == 'ar' ? 'برنامج التسويق بالعمولة' : 'Affiliate Program' }}
        </h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            {{ app()->getLocale() == 'ar' ? 'اربح عمولة على كل عميل جديد تحيله إلينا' : 'Earn commission on every new customer you refer to us' }}
        </p>
    </div>

    <!-- Main Content -->
    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Left Column - Benefits -->
        <div class="lg:col-span-2 space-y-4">
            <!-- Benefits Cards -->
            <div class="grid sm:grid-cols-3 gap-4">
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
                    <div class="w-10 h-10 bg-blue-50 dark:bg-blue-900/20 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-500" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 01-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004zM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 01-.921.42z" />
                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v.816a3.836 3.836 0 00-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 01-.921-.421l-.879-.66a.75.75 0 00-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 001.5 0v-.81a4.124 4.124 0 001.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 00-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 00.933-1.175l-.415-.33a3.836 3.836 0 00-1.719-.755V6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">
                        {{ app()->getLocale() == 'ar' ? '10% عمولة' : '10% Commission' }}
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ app()->getLocale() == 'ar' ? 'على كل عملية شراء' : 'On every purchase' }}
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
                    <div class="w-10 h-10 bg-blue-50 dark:bg-blue-900/20 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-500" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z" clip-rule="evenodd" />
                            <path fill-rule="evenodd" d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">
                        {{ app()->getLocale() == 'ar' ? 'تتبع مباشر' : 'Real-time Tracking' }}
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ app()->getLocale() == 'ar' ? 'لوحة تحكم متكاملة' : 'Complete dashboard' }}
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
                    <div class="w-10 h-10 bg-blue-50 dark:bg-blue-900/20 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-500" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M2.273 5.625A4.483 4.483 0 015.25 4.5h13.5c1.141 0 2.183.425 2.977 1.125A3 3 0 0018.75 3H5.25a3 3 0 00-2.977 2.625zM2.273 8.625A4.483 4.483 0 015.25 7.5h13.5c1.141 0 2.183.425 2.977 1.125A3 3 0 0018.75 6H5.25a3 3 0 00-2.977 2.625zM5.25 9a3 3 0 00-3 3v6a3 3 0 003 3h13.5a3 3 0 003-3v-6a3 3 0 00-3-3H15a.75.75 0 00-.75.75 2.25 2.25 0 01-4.5 0A.75.75 0 009 9H5.25z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">
                        {{ app()->getLocale() == 'ar' ? 'دفعات سهلة' : 'Easy Payouts' }}
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ app()->getLocale() == 'ar' ? 'سحب سريع وآمن' : 'Fast & secure withdrawal' }}
                    </p>
                </div>
            </div>

            <!-- How It Works -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-base font-medium text-gray-900 dark:text-white">
                        {{ app()->getLocale() == 'ar' ? 'كيف يعمل البرنامج؟' : 'How does it work?' }}
                    </h2>
                </div>
                <div class="p-5">
                    <div class="grid sm:grid-cols-4 gap-4">
                        <div class="text-center">
                            <div class="w-10 h-10 bg-blue-600 text-white rounded-lg flex items-center justify-center text-sm font-medium mx-auto mb-3">1</div>
                            <h4 class="font-medium text-gray-900 dark:text-white text-sm mb-1">
                                {{ app()->getLocale() == 'ar' ? 'سجّل' : 'Sign Up' }}
                            </h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ app()->getLocale() == 'ar' ? 'فعّل حسابك' : 'Activate account' }}
                            </p>
                        </div>
                        <div class="text-center">
                            <div class="w-10 h-10 bg-blue-600 text-white rounded-lg flex items-center justify-center text-sm font-medium mx-auto mb-3">2</div>
                            <h4 class="font-medium text-gray-900 dark:text-white text-sm mb-1">
                                {{ app()->getLocale() == 'ar' ? 'شارك' : 'Share' }}
                            </h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ app()->getLocale() == 'ar' ? 'انشر رابطك' : 'Share your link' }}
                            </p>
                        </div>
                        <div class="text-center">
                            <div class="w-10 h-10 bg-blue-600 text-white rounded-lg flex items-center justify-center text-sm font-medium mx-auto mb-3">3</div>
                            <h4 class="font-medium text-gray-900 dark:text-white text-sm mb-1">
                                {{ app()->getLocale() == 'ar' ? 'إحالات' : 'Referrals' }}
                            </h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ app()->getLocale() == 'ar' ? 'العملاء يسجلون' : 'Customers join' }}
                            </p>
                        </div>
                        <div class="text-center">
                            <div class="w-10 h-10 bg-blue-600 text-white rounded-lg flex items-center justify-center text-sm font-medium mx-auto mb-3">4</div>
                            <h4 class="font-medium text-gray-900 dark:text-white text-sm mb-1">
                                {{ app()->getLocale() == 'ar' ? 'اكسب' : 'Earn' }}
                            </h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ app()->getLocale() == 'ar' ? 'احصل على عمولتك' : 'Get commission' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Terms -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-base font-medium text-gray-900 dark:text-white">
                        {{ app()->getLocale() == 'ar' ? 'الشروط والأحكام' : 'Terms & Conditions' }}
                    </h2>
                </div>
                <div class="p-5">
                    <ul class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                            </svg>
                            {{ app()->getLocale() == 'ar' ? 'الحد الأدنى للسحب هو $50' : 'Minimum payout is $50' }}
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                            </svg>
                            {{ app()->getLocale() == 'ar' ? 'العمولة تُحسب على المشتريات المؤكدة فقط' : 'Commission is calculated on confirmed purchases only' }}
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                            </svg>
                            {{ app()->getLocale() == 'ar' ? 'يتم معالجة طلبات السحب خلال 3-5 أيام عمل' : 'Payout requests are processed within 3-5 business days' }}
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Why Join Our Affiliate Program -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-base font-medium text-gray-900 dark:text-white">
                        {{ app()->getLocale() == 'ar' ? 'لماذا تنضم لبرنامجنا؟' : 'User-first affiliate marketing' }}
                    </h2>
                </div>
                <div class="p-5">
                    <div class="space-y-5">
                        <!-- High Conversion Rates -->
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-green-50 dark:bg-green-900/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-500" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0112 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 013.498 1.307 4.491 4.491 0 011.307 3.497A4.49 4.49 0 0121.75 12a4.49 4.49 0 01-1.549 3.397 4.491 4.491 0 01-1.307 3.497 4.491 4.491 0 01-3.497 1.307A4.49 4.49 0 0112 21.75a4.49 4.49 0 01-3.397-1.549 4.49 4.49 0 01-3.498-1.306 4.491 4.491 0 01-1.307-3.498A4.49 4.49 0 012.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 011.307-3.497 4.49 4.49 0 013.497-1.307zm7.007 6.387a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900 dark:text-white mb-1">
                                    {{ app()->getLocale() == 'ar' ? 'معدلات تحويل عالية' : 'High conversion rates' }}
                                </h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ app()->getLocale() == 'ar' ? 'علامتنا التجارية والمواد الترويجية الفعالة تعني أن الزيارات التي ترسلها إلينا ستتحول إلى مبيعات.' : 'Our brand and effective promo materials mean the traffic you send our way will convert.' }}
                                </p>
                            </div>
                        </div>

                        <!-- Performance-based Commissions -->
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-blue-50 dark:bg-blue-900/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-500" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900 dark:text-white mb-1">
                                    {{ app()->getLocale() == 'ar' ? 'عمولات مبنية على الأداء' : 'Commissions based on performance' }}
                                </h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ app()->getLocale() == 'ar' ? 'كلما زادت مبيعاتك، زادت عمولتك.' : 'The more sales you make, the bigger your commission.' }}
                                </p>
                            </div>
                        </div>

                        <!-- Easy to Start -->
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-purple-50 dark:bg-purple-900/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-purple-600 dark:text-purple-500" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 4.5a.75.75 0 01.721.544l.813 2.846a3.75 3.75 0 002.576 2.576l2.846.813a.75.75 0 010 1.442l-2.846.813a3.75 3.75 0 00-2.576 2.576l-.813 2.846a.75.75 0 01-1.442 0l-.813-2.846a3.75 3.75 0 00-2.576-2.576l-2.846-.813a.75.75 0 010-1.442l2.846-.813A3.75 3.75 0 007.466 7.89l.813-2.846A.75.75 0 019 4.5zM18 1.5a.75.75 0 01.728.568l.258 1.036c.236.94.97 1.674 1.91 1.91l1.036.258a.75.75 0 010 1.456l-1.036.258c-.94.236-1.674.97-1.91 1.91l-.258 1.036a.75.75 0 01-1.456 0l-.258-1.036a2.625 2.625 0 00-1.91-1.91l-1.036-.258a.75.75 0 010-1.456l1.036-.258a2.625 2.625 0 001.91-1.91l.258-1.036A.75.75 0 0118 1.5zM16.5 15a.75.75 0 01.712.513l.394 1.183c.15.447.5.799.948.948l1.183.395a.75.75 0 010 1.422l-1.183.395c-.447.15-.799.5-.948.948l-.395 1.183a.75.75 0 01-1.422 0l-.395-1.183a1.5 1.5 0 00-.948-.948l-1.183-.395a.75.75 0 010-1.422l1.183-.395c.447-.15.799-.5.948-.948l.395-1.183A.75.75 0 0116.5 15z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900 dark:text-white mb-1">
                                    {{ app()->getLocale() == 'ar' ? 'سهولة البدء والنمو' : 'Easy to start and grow' }}
                                </h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ app()->getLocale() == 'ar' ? 'حقق التحويلات مع حزم البانرات المصممة باحترافية والصور والمزيد.' : 'Drive conversions with professionally-designed banner packages, screenshots, and more.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Activation Card -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 sticky top-6" x-data="{ loading: false, activated: false, referralLink: '' }">
                <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-base font-medium text-gray-900 dark:text-white">
                        {{ app()->getLocale() == 'ar' ? 'تفعيل الحساب' : 'Activate Account' }}
                    </h2>
                </div>
                <div class="p-5">
                    <!-- Not Activated State -->
                    <div x-show="!activated">
                        <div class="text-center mb-6">
                            <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M5.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM2.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM18.75 7.5a.75.75 0 00-1.5 0v2.25H15a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H21a.75.75 0 000-1.5h-2.25V7.5z" />
                                </svg>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ app()->getLocale() == 'ar' ? 'فعّل حسابك للحصول على رابط الإحالة الخاص بك' : 'Activate your account to get your referral link' }}
                            </p>
                        </div>
                        
                        <button @click="activateAffiliate()" 
                                :disabled="loading"
                                class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                            <template x-if="loading">
                                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </template>
                            <span>{{ app()->getLocale() == 'ar' ? 'تفعيل الآن' : 'Activate Now' }}</span>
                        </button>
                    </div>

                    <!-- Activated State -->
                    <div x-show="activated" x-cloak>
                        <div class="text-center mb-5">
                            <div class="w-16 h-16 bg-green-50 dark:bg-green-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-green-600 dark:text-green-500" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <h3 class="font-medium text-gray-900 dark:text-white mb-1">
                                {{ app()->getLocale() == 'ar' ? 'تم التفعيل!' : 'Activated!' }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ app()->getLocale() == 'ar' ? 'رابط الإحالة الخاص بك جاهز' : 'Your referral link is ready' }}
                            </p>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-xs text-gray-500 dark:text-gray-400 mb-2">{{ app()->getLocale() == 'ar' ? 'رابط الإحالة' : 'Referral Link' }}</label>
                            <div class="flex items-center gap-2">
                                <input type="text" x-model="referralLink" readonly 
                                    class="flex-1 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-2 text-sm text-gray-900 dark:text-white focus:outline-none">
                                <button @click="copyLink()" class="p-2 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M7.5 3.375c0-1.036.84-1.875 1.875-1.875h.375a3.75 3.75 0 013.75 3.75v1.875C13.5 8.161 14.34 9 15.375 9h1.875A3.75 3.75 0 0121 12.75v3.375C21 17.16 20.16 18 19.125 18h-9.75A1.875 1.875 0 017.5 16.125V3.375z" />
                                        <path d="M15 5.25a5.23 5.23 0 00-1.279-3.434 9.768 9.768 0 016.963 6.963A5.23 5.23 0 0017.25 7.5h-1.875A.375.375 0 0115 7.125V5.25zM4.875 6H6v10.125A3.375 3.375 0 009.375 19.5H16.5v1.125c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 013 20.625V7.875C3 6.839 3.84 6 4.875 6z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <a href="{{ route('client.affiliate') }}" 
                           class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                            {{ app()->getLocale() == 'ar' ? 'الذهاب للوحة التحكم' : 'Go to Dashboard' }}
                            <svg class="w-4 h-4 {{ $rtl ? 'rotate-180' : '' }}" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl p-6 md:p-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm11.378-3.917c-.89-.777-2.366-.777-3.255 0a.75.75 0 01-.988-1.129c1.454-1.272 3.776-1.272 5.23 0 1.513 1.324 1.513 3.518 0 4.842a3.75 3.75 0 01-.837.552c-.676.328-1.028.774-1.028 1.152v.75a.75.75 0 01-1.5 0v-.75c0-1.279 1.06-2.107 1.875-2.502.182-.088.351-.199.503-.331.83-.727.83-1.857 0-2.584zM12 18a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-white mb-2">
                        {{ app()->getLocale() == 'ar' ? 'الأسئلة الشائعة عن برنامج الأفلييت' : 'Affiliate program FAQs' }}
                    </h3>
                    <p class="text-blue-100 text-sm">
                        {{ app()->getLocale() == 'ar' ? 'اطلع على الأسئلة الشائعة لبدء عملك في التسويق بالعمولة بشكل صحيح.' : 'Check out the frequently asked questions to start your affiliate business on the right foot.' }}
                    </p>
                </div>
            </div>
            <a href="{{ route('client.affiliate.faqs') }}" 
               class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white text-blue-600 font-medium rounded-lg hover:bg-blue-50 transition-colors flex-shrink-0">
                {{ app()->getLocale() == 'ar' ? 'احصل على الإجابات' : 'Get answers' }}
                <svg class="w-4 h-4 {{ $rtl ? 'rotate-180' : '' }}" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
    </div>
</div>

<script>
function activateAffiliate() {
    const component = Alpine.$data(document.querySelector('[x-data]'));
    component.loading = true;

    fetch('{{ route('client.affiliate.activate') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        component.loading = false;
        if (data.success) {
            // Reload the page to go to affiliate dashboard
            window.location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        component.loading = false;
        alert('An error occurred. Please try again.');
    });
}

function copyLink() {
    const component = Alpine.$data(document.querySelector('[x-data]'));
    navigator.clipboard.writeText(component.referralLink);
}
</script>
@endsection
