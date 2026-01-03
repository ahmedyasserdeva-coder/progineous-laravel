@extends('frontend.client.layout')

@section('title', app()->getLocale() == 'ar' ? 'الأسئلة الشائعة - برنامج الأفلييت' : 'Affiliate Program FAQs')

@section('content')
<div class="space-y-6">
    @php $rtl = app()->getLocale() == 'ar'; @endphp
    
    <!-- Page Header -->
    <div>
        <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-4">
            <a href="{{ route('client.affiliate.activate') }}" class="hover:text-blue-600 dark:hover:text-blue-500">
                {{ app()->getLocale() == 'ar' ? 'برنامج الأفلييت' : 'Affiliate Program' }}
            </a>
            <svg class="w-4 h-4 {{ $rtl ? 'rotate-180' : '' }}" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M16.28 11.47a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 01-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 011.06-1.06l7.5 7.5z" clip-rule="evenodd" />
            </svg>
            <span class="text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'الأسئلة الشائعة' : 'FAQs' }}</span>
        </nav>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
            {{ app()->getLocale() == 'ar' ? 'الأسئلة الشائعة عن برنامج الأفلييت' : 'Affiliate Program FAQs' }}
        </h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            {{ app()->getLocale() == 'ar' ? 'كل ما تحتاج معرفته للبدء في التسويق بالعمولة' : 'Everything you need to know to start affiliate marketing' }}
        </p>
    </div>

    <!-- Quick Navigation -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
        <h2 class="text-sm font-medium text-gray-900 dark:text-white mb-4">{{ app()->getLocale() == 'ar' ? 'التنقل السريع' : 'Quick Navigation' }}</h2>
        <div class="flex flex-wrap gap-2">
            <a href="#general" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-lg text-sm font-medium hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                </svg>
                {{ app()->getLocale() == 'ar' ? 'عام' : 'General' }}
            </a>
            <a href="#commissions" class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 rounded-lg text-sm font-medium hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 01-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004zM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 01-.921.42z" />
                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v.816a3.836 3.836 0 00-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 01-.921-.421l-.879-.66a.75.75 0 00-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 001.5 0v-.81a4.124 4.124 0 001.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 00-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 00.933-1.175l-.415-.33a3.836 3.836 0 00-1.719-.755V6z" clip-rule="evenodd" />
                </svg>
                {{ app()->getLocale() == 'ar' ? 'العمولات' : 'Commissions' }}
            </a>
            <a href="#payouts" class="inline-flex items-center gap-2 px-4 py-2 bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 rounded-lg text-sm font-medium hover:bg-purple-100 dark:hover:bg-purple-900/30 transition-colors">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M2.273 5.625A4.483 4.483 0 015.25 4.5h13.5c1.141 0 2.183.425 2.977 1.125A3 3 0 0018.75 3H5.25a3 3 0 00-2.977 2.625zM2.273 8.625A4.483 4.483 0 015.25 7.5h13.5c1.141 0 2.183.425 2.977 1.125A3 3 0 0018.75 6H5.25a3 3 0 00-2.977 2.625zM5.25 9a3 3 0 00-3 3v6a3 3 0 003 3h13.5a3 3 0 003-3v-6a3 3 0 00-3-3H15a.75.75 0 00-.75.75 2.25 2.25 0 01-4.5 0A.75.75 0 009 9H5.25z" />
                </svg>
                {{ app()->getLocale() == 'ar' ? 'الدفعات' : 'Payouts' }}
            </a>
            <a href="#tracking" class="inline-flex items-center gap-2 px-4 py-2 bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400 rounded-lg text-sm font-medium hover:bg-orange-100 dark:hover:bg-orange-900/30 transition-colors">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z" clip-rule="evenodd" />
                    <path fill-rule="evenodd" d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z" clip-rule="evenodd" />
                </svg>
                {{ app()->getLocale() == 'ar' ? 'التتبع' : 'Tracking' }}
            </a>
            <a href="#promotional" class="inline-flex items-center gap-2 px-4 py-2 bg-pink-50 dark:bg-pink-900/20 text-pink-600 dark:text-pink-400 rounded-lg text-sm font-medium hover:bg-pink-100 dark:hover:bg-pink-900/30 transition-colors">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.25 2.25a3 3 0 00-3 3v4.318a3 3 0 00.879 2.121l9.58 9.581c.92.92 2.39 1.186 3.548.428a18.849 18.849 0 005.441-5.44c.758-1.16.492-2.629-.428-3.548l-9.58-9.581a3 3 0 00-2.122-.879H5.25zM6.375 7.5a1.125 1.125 0 100-2.25 1.125 1.125 0 000 2.25z" clip-rule="evenodd" />
                </svg>
                {{ app()->getLocale() == 'ar' ? 'الترويج' : 'Promotional' }}
            </a>
        </div>
    </div>

    <!-- FAQ Sections -->
    <div class="space-y-6">
        
        <!-- General Questions -->
        <div id="general" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
            <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center gap-3">
                <div class="w-8 h-8 bg-blue-50 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-500" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                    </svg>
                </div>
                <h2 class="text-base font-medium text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'أسئلة عامة' : 'General Questions' }}</h2>
            </div>
            <div class="divide-y divide-gray-100 dark:divide-gray-700" x-data="{ open: null }">
                <!-- FAQ Item 1 -->
                <div class="p-5">
                    <button @click="open = open === 1 ? null : 1" class="w-full flex items-center justify-between gap-4 text-{{ $rtl ? 'right' : 'left' }}">
                        <span class="font-medium text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'ما هو برنامج التسويق بالعمولة؟' : 'What is the affiliate program?' }}</span>
                        <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': open === 1 }" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.53 16.28a.75.75 0 01-1.06 0l-7.5-7.5a.75.75 0 011.06-1.06L12 14.69l6.97-6.97a.75.75 0 111.06 1.06l-7.5 7.5z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open === 1" x-collapse class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                        {{ app()->getLocale() == 'ar' ? 'برنامج التسويق بالعمولة هو شراكة تتيح لك كسب عمولة على كل عميل جديد تحيله إلينا. ببساطة، تشارك رابط الإحالة الخاص بك، وعندما يقوم شخص ما بالتسجيل والشراء من خلاله، تحصل على نسبة من قيمة المبيعات.' : 'Our affiliate program is a partnership that allows you to earn commission on every new customer you refer to us. Simply share your referral link, and when someone signs up and makes a purchase through it, you earn a percentage of the sale value.' }}
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="p-5">
                    <button @click="open = open === 2 ? null : 2" class="w-full flex items-center justify-between gap-4 text-{{ $rtl ? 'right' : 'left' }}">
                        <span class="font-medium text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'كيف يمكنني الانضمام للبرنامج؟' : 'How can I join the program?' }}</span>
                        <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': open === 2 }" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.53 16.28a.75.75 0 01-1.06 0l-7.5-7.5a.75.75 0 011.06-1.06L12 14.69l6.97-6.97a.75.75 0 111.06 1.06l-7.5 7.5z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open === 2" x-collapse class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                        {{ app()->getLocale() == 'ar' ? 'الانضمام سهل وسريع! كل ما عليك هو تسجيل الدخول لحسابك، ثم الذهاب لقسم الأفلييت والنقر على زر "تفعيل الآن". ستحصل فوراً على رابط الإحالة الخاص بك.' : 'Joining is easy and quick! Simply log in to your account, go to the Affiliate section, and click "Activate Now". You\'ll instantly receive your unique referral link.' }}
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="p-5">
                    <button @click="open = open === 3 ? null : 3" class="w-full flex items-center justify-between gap-4 text-{{ $rtl ? 'right' : 'left' }}">
                        <span class="font-medium text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'هل هناك رسوم للانضمام؟' : 'Are there any fees to join?' }}</span>
                        <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': open === 3 }" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.53 16.28a.75.75 0 01-1.06 0l-7.5-7.5a.75.75 0 011.06-1.06L12 14.69l6.97-6.97a.75.75 0 111.06 1.06l-7.5 7.5z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open === 3" x-collapse class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                        {{ app()->getLocale() == 'ar' ? 'لا، الانضمام لبرنامج الأفلييت مجاني تماماً. لا توجد أي رسوم خفية أو تكاليف اشتراك.' : 'No, joining our affiliate program is completely free. There are no hidden fees or subscription costs.' }}
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="p-5">
                    <button @click="open = open === 4 ? null : 4" class="w-full flex items-center justify-between gap-4 text-{{ $rtl ? 'right' : 'left' }}">
                        <span class="font-medium text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'هل يمكنني الترويج بأي طريقة؟' : 'Can I promote in any way I want?' }}</span>
                        <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': open === 4 }" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.53 16.28a.75.75 0 01-1.06 0l-7.5-7.5a.75.75 0 011.06-1.06L12 14.69l6.97-6.97a.75.75 0 111.06 1.06l-7.5 7.5z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open === 4" x-collapse class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                        {{ app()->getLocale() == 'ar' ? 'نعم، يمكنك الترويج عبر مدونتك، قنوات التواصل الاجتماعي، يوتيوب، البريد الإلكتروني، وغيرها. فقط تأكد من الالتزام بسياساتنا وعدم استخدام طرق غير أخلاقية أو مضللة.' : 'Yes, you can promote through your blog, social media channels, YouTube, email, and more. Just make sure to follow our policies and avoid unethical or misleading methods.' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Commissions -->
        <div id="commissions" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
            <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center gap-3">
                <div class="w-8 h-8 bg-green-50 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-600 dark:text-green-500" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 01-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004zM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 01-.921.42z" />
                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v.816a3.836 3.836 0 00-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 01-.921-.421l-.879-.66a.75.75 0 00-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 001.5 0v-.81a4.124 4.124 0 001.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 00-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 00.933-1.175l-.415-.33a3.836 3.836 0 00-1.719-.755V6z" clip-rule="evenodd" />
                    </svg>
                </div>
                <h2 class="text-base font-medium text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'العمولات' : 'Commissions' }}</h2>
            </div>
            <div class="divide-y divide-gray-100 dark:divide-gray-700" x-data="{ open: null }">
                <!-- FAQ Item 1 -->
                <div class="p-5">
                    <button @click="open = open === 1 ? null : 1" class="w-full flex items-center justify-between gap-4 text-{{ $rtl ? 'right' : 'left' }}">
                        <span class="font-medium text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'كم نسبة العمولة التي سأحصل عليها؟' : 'What commission rate will I receive?' }}</span>
                        <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': open === 1 }" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.53 16.28a.75.75 0 01-1.06 0l-7.5-7.5a.75.75 0 011.06-1.06L12 14.69l6.97-6.97a.75.75 0 111.06 1.06l-7.5 7.5z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open === 1" x-collapse class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                        {{ app()->getLocale() == 'ar' ? 'نسبة العمولة الأساسية هي 10% على كل عملية شراء. يمكن أن تزيد هذه النسبة بناءً على أدائك وعدد الإحالات الناجحة.' : 'The base commission rate is 10% on every purchase. This rate can increase based on your performance and number of successful referrals.' }}
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="p-5">
                    <button @click="open = open === 2 ? null : 2" class="w-full flex items-center justify-between gap-4 text-{{ $rtl ? 'right' : 'left' }}">
                        <span class="font-medium text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'متى تُضاف العمولة لحسابي؟' : 'When is the commission added to my account?' }}</span>
                        <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': open === 2 }" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.53 16.28a.75.75 0 01-1.06 0l-7.5-7.5a.75.75 0 011.06-1.06L12 14.69l6.97-6.97a.75.75 0 111.06 1.06l-7.5 7.5z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open === 2" x-collapse class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                        {{ app()->getLocale() == 'ar' ? 'تُضاف العمولة لحسابك بعد تأكيد الدفع من العميل المُحال. عادةً ما يستغرق ذلك من 24-48 ساعة.' : 'Commission is added to your account after payment confirmation from the referred customer. This usually takes 24-48 hours.' }}
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="p-5">
                    <button @click="open = open === 3 ? null : 3" class="w-full flex items-center justify-between gap-4 text-{{ $rtl ? 'right' : 'left' }}">
                        <span class="font-medium text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'هل أحصل على عمولة للتجديدات؟' : 'Do I earn commission on renewals?' }}</span>
                        <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': open === 3 }" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.53 16.28a.75.75 0 01-1.06 0l-7.5-7.5a.75.75 0 011.06-1.06L12 14.69l6.97-6.97a.75.75 0 111.06 1.06l-7.5 7.5z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open === 3" x-collapse class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                        {{ app()->getLocale() == 'ar' ? 'نعم! تحصل على عمولة على جميع مشتريات العميل المُحال، بما في ذلك التجديدات والترقيات والخدمات الإضافية.' : 'Yes! You earn commission on all purchases made by the referred customer, including renewals, upgrades, and additional services.' }}
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="p-5">
                    <button @click="open = open === 4 ? null : 4" class="w-full flex items-center justify-between gap-4 text-{{ $rtl ? 'right' : 'left' }}">
                        <span class="font-medium text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'هل هناك حد أقصى للعمولات؟' : 'Is there a cap on commissions?' }}</span>
                        <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': open === 4 }" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.53 16.28a.75.75 0 01-1.06 0l-7.5-7.5a.75.75 0 011.06-1.06L12 14.69l6.97-6.97a.75.75 0 111.06 1.06l-7.5 7.5z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open === 4" x-collapse class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                        {{ app()->getLocale() == 'ar' ? 'لا، لا يوجد حد أقصى للعمولات! كلما زادت إحالاتك الناجحة، زادت أرباحك بلا حدود.' : 'No, there\'s no cap on commissions! The more successful referrals you make, the more you earn without limits.' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Payouts -->
        <div id="payouts" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
            <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center gap-3">
                <div class="w-8 h-8 bg-purple-50 dark:bg-purple-900/20 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-purple-600 dark:text-purple-500" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M2.273 5.625A4.483 4.483 0 015.25 4.5h13.5c1.141 0 2.183.425 2.977 1.125A3 3 0 0018.75 3H5.25a3 3 0 00-2.977 2.625zM2.273 8.625A4.483 4.483 0 015.25 7.5h13.5c1.141 0 2.183.425 2.977 1.125A3 3 0 0018.75 6H5.25a3 3 0 00-2.977 2.625zM5.25 9a3 3 0 00-3 3v6a3 3 0 003 3h13.5a3 3 0 003-3v-6a3 3 0 00-3-3H15a.75.75 0 00-.75.75 2.25 2.25 0 01-4.5 0A.75.75 0 009 9H5.25z" />
                    </svg>
                </div>
                <h2 class="text-base font-medium text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'الدفعات والسحب' : 'Payouts & Withdrawals' }}</h2>
            </div>
            <div class="divide-y divide-gray-100 dark:divide-gray-700" x-data="{ open: null }">
                <!-- FAQ Item 1 -->
                <div class="p-5">
                    <button @click="open = open === 1 ? null : 1" class="w-full flex items-center justify-between gap-4 text-{{ $rtl ? 'right' : 'left' }}">
                        <span class="font-medium text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'ما هو الحد الأدنى للسحب؟' : 'What is the minimum payout amount?' }}</span>
                        <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': open === 1 }" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.53 16.28a.75.75 0 01-1.06 0l-7.5-7.5a.75.75 0 011.06-1.06L12 14.69l6.97-6.97a.75.75 0 111.06 1.06l-7.5 7.5z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open === 1" x-collapse class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                        {{ app()->getLocale() == 'ar' ? 'الحد الأدنى للسحب هو $50. بمجرد وصول رصيدك لهذا المبلغ، يمكنك طلب السحب.' : 'The minimum payout amount is $50. Once your balance reaches this amount, you can request a withdrawal.' }}
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="p-5">
                    <button @click="open = open === 2 ? null : 2" class="w-full flex items-center justify-between gap-4 text-{{ $rtl ? 'right' : 'left' }}">
                        <span class="font-medium text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'ما هي طرق الدفع المتاحة؟' : 'What payment methods are available?' }}</span>
                        <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': open === 2 }" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.53 16.28a.75.75 0 01-1.06 0l-7.5-7.5a.75.75 0 011.06-1.06L12 14.69l6.97-6.97a.75.75 0 111.06 1.06l-7.5 7.5z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open === 2" x-collapse class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                        {{ app()->getLocale() == 'ar' ? 'نوفر عدة طرق للدفع تشمل: التحويل البنكي، PayPal، والتحويل لرصيد حسابك لاستخدامه في خدماتنا.' : 'We offer several payment methods including: Bank transfer, PayPal, and transfer to your account balance to use on our services.' }}
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="p-5">
                    <button @click="open = open === 3 ? null : 3" class="w-full flex items-center justify-between gap-4 text-{{ $rtl ? 'right' : 'left' }}">
                        <span class="font-medium text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'كم يستغرق معالجة طلب السحب؟' : 'How long does it take to process a withdrawal?' }}</span>
                        <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': open === 3 }" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.53 16.28a.75.75 0 01-1.06 0l-7.5-7.5a.75.75 0 011.06-1.06L12 14.69l6.97-6.97a.75.75 0 111.06 1.06l-7.5 7.5z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open === 3" x-collapse class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                        {{ app()->getLocale() == 'ar' ? 'يتم معالجة طلبات السحب خلال 3-5 أيام عمل. قد يستغرق وصول المبلغ لحسابك وقتاً إضافياً حسب طريقة الدفع.' : 'Withdrawal requests are processed within 3-5 business days. It may take additional time for the funds to reach your account depending on the payment method.' }}
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="p-5">
                    <button @click="open = open === 4 ? null : 4" class="w-full flex items-center justify-between gap-4 text-{{ $rtl ? 'right' : 'left' }}">
                        <span class="font-medium text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'هل هناك رسوم على السحب؟' : 'Are there any withdrawal fees?' }}</span>
                        <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': open === 4 }" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.53 16.28a.75.75 0 01-1.06 0l-7.5-7.5a.75.75 0 011.06-1.06L12 14.69l6.97-6.97a.75.75 0 111.06 1.06l-7.5 7.5z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open === 4" x-collapse class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                        {{ app()->getLocale() == 'ar' ? 'لا نفرض رسوماً على السحب. ولكن قد تفرض بعض البنوك أو مزودي الدفع رسوماً خاصة بهم.' : 'We don\'t charge withdrawal fees. However, some banks or payment providers may charge their own fees.' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Tracking -->
        <div id="tracking" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
            <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center gap-3">
                <div class="w-8 h-8 bg-orange-50 dark:bg-orange-900/20 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-orange-600 dark:text-orange-500" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z" clip-rule="evenodd" />
                        <path fill-rule="evenodd" d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z" clip-rule="evenodd" />
                    </svg>
                </div>
                <h2 class="text-base font-medium text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'التتبع والإحصائيات' : 'Tracking & Statistics' }}</h2>
            </div>
            <div class="divide-y divide-gray-100 dark:divide-gray-700" x-data="{ open: null }">
                <!-- FAQ Item 1 -->
                <div class="p-5">
                    <button @click="open = open === 1 ? null : 1" class="w-full flex items-center justify-between gap-4 text-{{ $rtl ? 'right' : 'left' }}">
                        <span class="font-medium text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'كيف يتم تتبع الإحالات؟' : 'How are referrals tracked?' }}</span>
                        <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': open === 1 }" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.53 16.28a.75.75 0 01-1.06 0l-7.5-7.5a.75.75 0 011.06-1.06L12 14.69l6.97-6.97a.75.75 0 111.06 1.06l-7.5 7.5z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open === 1" x-collapse class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                        {{ app()->getLocale() == 'ar' ? 'يتم تتبع الإحالات عبر رابط الإحالة الخاص بك الذي يحتوي على كود تتبع فريد. عندما يقوم شخص بالنقر على رابطك والتسجيل، يتم ربطه بحسابك تلقائياً.' : 'Referrals are tracked through your unique referral link that contains a unique tracking code. When someone clicks your link and signs up, they\'re automatically linked to your account.' }}
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="p-5">
                    <button @click="open = open === 2 ? null : 2" class="w-full flex items-center justify-between gap-4 text-{{ $rtl ? 'right' : 'left' }}">
                        <span class="font-medium text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'كم مدة صلاحية ملف تعريف الارتباط (Cookie)؟' : 'How long does the cookie last?' }}</span>
                        <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': open === 2 }" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.53 16.28a.75.75 0 01-1.06 0l-7.5-7.5a.75.75 0 011.06-1.06L12 14.69l6.97-6.97a.75.75 0 111.06 1.06l-7.5 7.5z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open === 2" x-collapse class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                        {{ app()->getLocale() == 'ar' ? 'ملف تعريف الارتباط (Cookie) صالح لمدة 30 يوماً. إذا قام الزائر بالتسجيل خلال هذه الفترة، ستُحتسب الإحالة لك.' : 'The tracking cookie lasts for 30 days. If the visitor signs up within this period, the referral will be credited to you.' }}
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="p-5">
                    <button @click="open = open === 3 ? null : 3" class="w-full flex items-center justify-between gap-4 text-{{ $rtl ? 'right' : 'left' }}">
                        <span class="font-medium text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'أين يمكنني رؤية إحصائياتي؟' : 'Where can I see my statistics?' }}</span>
                        <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': open === 3 }" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.53 16.28a.75.75 0 01-1.06 0l-7.5-7.5a.75.75 0 011.06-1.06L12 14.69l6.97-6.97a.75.75 0 111.06 1.06l-7.5 7.5z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open === 3" x-collapse class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                        {{ app()->getLocale() == 'ar' ? 'يمكنك متابعة جميع إحصائياتك من لوحة تحكم الأفلييت الخاصة بك، حيث ستجد تفاصيل الإحالات، العمولات، والمدفوعات.' : 'You can track all your statistics from your affiliate dashboard, where you\'ll find details on referrals, commissions, and payments.' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Promotional Materials -->
        <div id="promotional" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
            <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center gap-3">
                <div class="w-8 h-8 bg-pink-50 dark:bg-pink-900/20 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-pink-600 dark:text-pink-500" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.25 2.25a3 3 0 00-3 3v4.318a3 3 0 00.879 2.121l9.58 9.581c.92.92 2.39 1.186 3.548.428a18.849 18.849 0 005.441-5.44c.758-1.16.492-2.629-.428-3.548l-9.58-9.581a3 3 0 00-2.122-.879H5.25zM6.375 7.5a1.125 1.125 0 100-2.25 1.125 1.125 0 000 2.25z" clip-rule="evenodd" />
                    </svg>
                </div>
                <h2 class="text-base font-medium text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'المواد الترويجية' : 'Promotional Materials' }}</h2>
            </div>
            <div class="divide-y divide-gray-100 dark:divide-gray-700" x-data="{ open: null }">
                <!-- FAQ Item 1 -->
                <div class="p-5">
                    <button @click="open = open === 1 ? null : 1" class="w-full flex items-center justify-between gap-4 text-{{ $rtl ? 'right' : 'left' }}">
                        <span class="font-medium text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'هل توفرون مواد ترويجية؟' : 'Do you provide promotional materials?' }}</span>
                        <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': open === 1 }" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.53 16.28a.75.75 0 01-1.06 0l-7.5-7.5a.75.75 0 011.06-1.06L12 14.69l6.97-6.97a.75.75 0 111.06 1.06l-7.5 7.5z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open === 1" x-collapse class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                        {{ app()->getLocale() == 'ar' ? 'نعم، نوفر مجموعة متنوعة من المواد الترويجية تشمل بانرات بأحجام مختلفة، صور للمنتجات، ونصوص ترويجية جاهزة للاستخدام.' : 'Yes, we provide a variety of promotional materials including banners in different sizes, product images, and ready-to-use promotional text.' }}
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="p-5">
                    <button @click="open = open === 2 ? null : 2" class="w-full flex items-center justify-between gap-4 text-{{ $rtl ? 'right' : 'left' }}">
                        <span class="font-medium text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'هل يمكنني إنشاء موادي الترويجية الخاصة؟' : 'Can I create my own promotional materials?' }}</span>
                        <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': open === 2 }" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.53 16.28a.75.75 0 01-1.06 0l-7.5-7.5a.75.75 0 011.06-1.06L12 14.69l6.97-6.97a.75.75 0 111.06 1.06l-7.5 7.5z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open === 2" x-collapse class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                        {{ app()->getLocale() == 'ar' ? 'نعم، يمكنك إنشاء موادك الترويجية الخاصة طالما تلتزم بإرشادات العلامة التجارية الخاصة بنا ولا تتضمن معلومات مضللة.' : 'Yes, you can create your own promotional materials as long as you follow our brand guidelines and don\'t include misleading information.' }}
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="p-5">
                    <button @click="open = open === 3 ? null : 3" class="w-full flex items-center justify-between gap-4 text-{{ $rtl ? 'right' : 'left' }}">
                        <span class="font-medium text-gray-900 dark:text-white">{{ app()->getLocale() == 'ar' ? 'هل يمكنني استخدام إعلانات مدفوعة؟' : 'Can I use paid advertising?' }}</span>
                        <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{ 'rotate-180': open === 3 }" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.53 16.28a.75.75 0 01-1.06 0l-7.5-7.5a.75.75 0 011.06-1.06L12 14.69l6.97-6.97a.75.75 0 111.06 1.06l-7.5 7.5z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open === 3" x-collapse class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                        {{ app()->getLocale() == 'ar' ? 'نعم، يمكنك استخدام الإعلانات المدفوعة على منصات مثل Google Ads و Facebook Ads. فقط تأكد من عدم المزايدة على اسم علامتنا التجارية مباشرة.' : 'Yes, you can use paid advertising on platforms like Google Ads and Facebook Ads. Just make sure not to bid directly on our brand name.' }}
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Still Have Questions -->
    <div class="bg-gray-50 dark:bg-gray-800/50 rounded-xl border border-gray-200 dark:border-gray-700 p-6 text-center">
        <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-6 h-6 text-blue-600 dark:text-blue-500" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M4.848 2.771A49.144 49.144 0 0112 2.25c2.43 0 4.817.178 7.152.52 1.978.292 3.348 2.024 3.348 3.97v6.02c0 1.946-1.37 3.678-3.348 3.97a48.901 48.901 0 01-3.476.383.39.39 0 00-.297.17l-2.755 4.133a.75.75 0 01-1.248 0l-2.755-4.133a.39.39 0 00-.297-.17 48.9 48.9 0 01-3.476-.384c-1.978-.29-3.348-2.024-3.348-3.97V6.741c0-1.946 1.37-3.68 3.348-3.97zM6.75 8.25a.75.75 0 01.75-.75h9a.75.75 0 010 1.5h-9a.75.75 0 01-.75-.75zm.75 2.25a.75.75 0 000 1.5H12a.75.75 0 000-1.5H7.5z" clip-rule="evenodd" />
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
            {{ app()->getLocale() == 'ar' ? 'لا تزال لديك أسئلة؟' : 'Still have questions?' }}
        </h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
            {{ app()->getLocale() == 'ar' ? 'فريق الدعم لدينا جاهز لمساعدتك في أي استفسار' : 'Our support team is ready to help you with any inquiry' }}
        </p>
        <a href="mailto:support@progenius.com" 
           class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                <path d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z" />
                <path d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z" />
            </svg>
            {{ app()->getLocale() == 'ar' ? 'تواصل معنا' : 'Contact Us' }}
        </a>
    </div>
</div>
@endsection
