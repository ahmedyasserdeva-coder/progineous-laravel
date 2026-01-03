

<?php $__env->startSection('title', __('frontend.reseller_hosting') . ' - ' . config('app.name')); ?>

<?php $__env->startSection('meta_description', __('frontend.reseller_hosting_meta_desc') ?? 'استضافة ريسلر قوية ومرنة مع WHM/cPanel، موارد غير محدودة، أسعار تنافسية، وإدارة سهلة. ابدأ عملك كمزود استضافة مع Pro Gineous.'); ?>

<?php $__env->startSection('meta_keywords', __('frontend.reseller_hosting_keywords') ?? 'استضافة ريسلر, reseller hosting, WHM, cPanel, استضافة بيضاء, white label hosting, بيع استضافة, Pro Gineous'); ?>

<?php $__env->startPush('meta'); ?>
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo e(url()->current()); ?>">
    <meta property="og:title" content="<?php echo e(__('frontend.reseller_hosting')); ?> - <?php echo e(config('app.name')); ?>">
    <meta property="og:description" content="<?php echo e(__('frontend.reseller_hosting_meta_desc') ?? 'استضافة ريسلر قوية ومرنة مع WHM/cPanel وموارد غير محدودة'); ?>">
    <meta property="og:image" content="<?php echo e(asset('assets/reseller-hosting.png')); ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo e(url()->current()); ?>">
    <meta property="twitter:title" content="<?php echo e(__('frontend.reseller_hosting')); ?> - <?php echo e(config('app.name')); ?>">
    <meta property="twitter:description" content="<?php echo e(__('frontend.reseller_hosting_meta_desc') ?? 'استضافة ريسلر قوية ومرنة'); ?>">
    <meta property="twitter:image" content="<?php echo e(asset('assets/reseller-hosting.png')); ?>">

    <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo e(url()->current()); ?>">
    
    <!-- Flag Icons Library -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.2.3/css/flag-icons.min.css">
    
    <!-- AOS Library CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
    
    <!-- Custom Styles -->
    <style>
        [x-cloak] { display: none !important; }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes gradient {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient 3s ease infinite;
        }
        
        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }
        
        .animate-shimmer {
            animation: shimmer 2s infinite;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero Section -->
<section class="relative pt-24 pb-16 lg:pt-32 lg:pb-24 overflow-hidden min-h-[90vh] flex items-center">
    <!-- Background with Enhanced Gradient -->
    <div class="absolute inset-0 bg-gradient-to-br from-purple-50 via-pink-50 to-orange-50">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(168,85,247,0.1),transparent_50%)]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_70%_80%,rgba(249,115,22,0.1),transparent_50%)]"></div>
    </div>
    
    <!-- Animated Blobs -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 <?php echo e(app()->getLocale() == 'ar' ? 'left-10' : 'right-10'); ?> w-72 h-72 bg-gradient-to-br from-purple-400/30 to-pink-500/30 rounded-full blur-3xl animate-blob"></div>
        <div class="absolute bottom-20 <?php echo e(app()->getLocale() == 'ar' ? 'right-10' : 'left-10'); ?> w-96 h-96 bg-gradient-to-tr from-orange-400/30 to-red-500/30 rounded-full blur-3xl animate-blob animation-delay-2000"></div>
        <div class="absolute top-40 left-1/2 transform -translate-x-1/2 w-80 h-80 bg-gradient-to-br from-pink-400/20 to-purple-500/20 rounded-full blur-3xl animate-blob animation-delay-4000"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            <div class="text-center lg:text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> space-y-8">
                <!-- Badge -->
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-purple-100 border border-purple-200" data-aos="fade-down">
                    <svg class="w-5 h-5 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?> text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-bold text-purple-700"><?php echo e(app()->getLocale() == 'ar' ? 'استضافة ريسلر احترافية' : 'Professional Reseller Hosting'); ?></span>
                </div>

                <!-- Main Heading -->
                <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-black text-gray-900 leading-tight" data-aos="fade-up">
                    <?php echo e(app()->getLocale() == 'ar' ? 'ابدأ عملك في' : 'Start Your'); ?>

                    <span class="block text-transparent bg-clip-text bg-gradient-to-r from-purple-600 via-pink-600 to-orange-600">
                        <?php echo e(app()->getLocale() == 'ar' ? 'الاستضافة اليوم' : 'Hosting Business'); ?>

                    </span>
                </h1>

                <!-- Description -->
                <p class="text-lg lg:text-xl text-gray-600 leading-relaxed max-w-2xl mx-auto lg:mx-0" data-aos="fade-up" data-aos-delay="100">
                    <?php echo e(app()->getLocale() == 'ar' 
                        ? 'قم ببيع خدمات الاستضافة باسمك الخاص مع WHM/cPanel، موارد غير محدودة، ودعم فني مجاني على مدار الساعة.'
                        : 'Sell hosting services under your own brand with WHM/cPanel, unlimited resources, and 24/7 free technical support.'); ?>

                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4" data-aos="fade-up" data-aos-delay="200">
                    <a href="#plans" class="group relative inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-semibold text-lg rounded-2xl shadow-2xl hover:shadow-purple-500/50 transform hover:scale-105 transition-all duration-300 overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-pink-600 to-purple-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <span class="relative z-10"><?php echo e(__('frontend.view_plans') ?? 'اطلع على الباقات'); ?></span>
                        <svg class="w-5 h-5 <?php echo e(app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2'); ?> relative z-10 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e(app()->getLocale() == 'ar' ? 'M15 19l-7-7 7-7' : 'M9 5l7 7-7 7'); ?>"></path>
                        </svg>
                    </a>
                    
                    <a href="#features" class="inline-flex items-center px-8 py-4 bg-white text-purple-600 font-semibold text-lg rounded-2xl border-2 border-purple-200 hover:border-purple-400 hover:shadow-xl transition-all duration-300">
                        <svg class="w-5 h-5 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <?php echo e(__('frontend.learn_more') ?? 'اعرف المزيد'); ?>

                    </a>
                </div>

                <!-- Trust Badges -->
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-6 pt-8" data-aos="fade-up" data-aos-delay="300">
                    <div class="flex items-center gap-2">
                        <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm font-semibold text-gray-700"><?php echo e(app()->getLocale() == 'ar' ? 'WHM/cPanel مجاني' : 'Free WHM/cPanel'); ?></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm font-semibold text-gray-700"><?php echo e(app()->getLocale() == 'ar' ? 'شهادات SSL مجانية' : 'Free SSL Certificates'); ?></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm font-semibold text-gray-700"><?php echo e(app()->getLocale() == 'ar' ? 'نسخ احتياطي يومي' : 'Daily Backups'); ?></span>
                    </div>
                </div>
            </div>

            <!-- Right Illustration -->
            <div class="relative hidden lg:block" data-aos="fade-left" data-aos-delay="300">
                <div class="relative">
                    <!-- Main Server Illustration -->
                    <div class="relative z-10">
                        <svg class="w-full h-auto" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- Server Stack -->
                            <rect x="80" y="100" width="240" height="60" rx="8" fill="url(#grad1)" />
                            <rect x="80" y="170" width="240" height="60" rx="8" fill="url(#grad2)" />
                            <rect x="80" y="240" width="240" height="60" rx="8" fill="url(#grad3)" />
                            
                            <!-- LED Indicators -->
                            <circle cx="100" cy="130" r="4" fill="#10B981" class="animate-pulse" />
                            <circle cx="115" cy="130" r="4" fill="#10B981" />
                            <circle cx="100" cy="200" r="4" fill="#10B981" class="animate-pulse" style="animation-delay: 0.3s" />
                            <circle cx="115" cy="200" r="4" fill="#10B981" />
                            <circle cx="100" cy="270" r="4" fill="#10B981" class="animate-pulse" style="animation-delay: 0.6s" />
                            <circle cx="115" cy="270" r="4" fill="#10B981" />
                            
                            <!-- Gradients -->
                            <defs>
                                <linearGradient id="grad1" x1="80" y1="100" x2="320" y2="160">
                                    <stop offset="0%" stop-color="#A855F7" />
                                    <stop offset="100%" stop-color="#EC4899" />
                                </linearGradient>
                                <linearGradient id="grad2" x1="80" y1="170" x2="320" y2="230">
                                    <stop offset="0%" stop-color="#EC4899" />
                                    <stop offset="100%" stop-color="#F97316" />
                                </linearGradient>
                                <linearGradient id="grad3" x1="80" y1="240" x2="320" y2="300">
                                    <stop offset="0%" stop-color="#F97316" />
                                    <stop offset="100%" stop-color="#EF4444" />
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>

                    <!-- Floating Elements -->
                    <div class="absolute -top-8 -<?php echo e(app()->getLocale() == 'ar' ? 'left' : 'right'); ?>-8 bg-white p-4 rounded-2xl shadow-2xl animate-float">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-pink-600 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium"><?php echo e(app()->getLocale() == 'ar' ? 'أرباحك الشهرية' : 'Your Monthly Profit'); ?></p>
                                <p class="text-lg font-bold text-gray-900">$2,500+</p>
                            </div>
                        </div>
                    </div>

                    <div class="absolute bottom-8 -<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?>-8 bg-white p-4 rounded-2xl shadow-2xl animate-float" style="animation-delay: 1s;">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-orange-400 to-red-600 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium"><?php echo e(app()->getLocale() == 'ar' ? 'عملائك النشطين' : 'Active Clients'); ?></p>
                                <p class="text-lg font-bold text-gray-900">150+</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="relative py-20 lg:py-28 overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0 bg-gradient-to-b from-white via-purple-50/30 to-white"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16 lg:mb-20">
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-purple-100 border border-purple-200 mb-6">
                <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?> text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-sm font-bold text-purple-700"><?php echo e(__('frontend.features') ?? 'المميزات'); ?></span>
            </div>

            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-gray-900 mb-6">
                <?php echo e(__('frontend.reseller_hosting_features') ?? 'مميزات استضافة الريسلر'); ?>

            </h2>
            <p class="text-lg lg:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                <?php echo e(__('frontend.reseller_hosting_features_desc') ?? 'كل ما تحتاجه لبدء وإدارة عملك في مجال الاستضافة بنجاح'); ?>

            </p>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            <!-- Feature 1 -->
            <div class="group relative" data-aos="fade-up" data-aos-delay="100">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-500 to-pink-600 rounded-3xl opacity-0 group-hover:opacity-10 transition-opacity duration-500"></div>
                <div class="relative h-full p-8 bg-white rounded-3xl border-2 border-gray-100 hover:border-purple-200 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                    <div class="relative mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-100 to-pink-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <h3 class="text-xl lg:text-2xl font-bold text-gray-900 mb-3 group-hover:text-purple-600 transition-colors">
                        <?php echo e(app()->getLocale() == 'ar' ? 'White Label كامل' : 'Full White Label'); ?>

                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        <?php echo e(app()->getLocale() == 'ar' 
                            ? 'قم بتخصيص علامتك التجارية بالكامل مع إمكانية تخصيص WHM/cPanel بشعارك وألوانك الخاصة'
                            : 'Fully customize your brand with the ability to customize WHM/cPanel with your own logo and colors'); ?>

                    </p>
                </div>
            </div>

            <!-- Feature 2 -->
            <div class="group relative" data-aos="fade-up" data-aos-delay="200">
                <div class="absolute inset-0 bg-gradient-to-br from-pink-500 to-orange-600 rounded-3xl opacity-0 group-hover:opacity-10 transition-opacity duration-500"></div>
                <div class="relative h-full p-8 bg-white rounded-3xl border-2 border-gray-100 hover:border-pink-200 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                    <div class="relative mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-pink-100 to-orange-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <h3 class="text-xl lg:text-2xl font-bold text-gray-900 mb-3 group-hover:text-pink-600 transition-colors">
                        <?php echo e(app()->getLocale() == 'ar' ? 'موارد غير محدودة' : 'Unlimited Resources'); ?>

                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        <?php echo e(app()->getLocale() == 'ar' 
                            ? 'حسابات استضافة غير محدودة، نطاقات، قواعد بيانات، وحسابات بريد إلكتروني'
                            : 'Unlimited hosting accounts, domains, databases, and email accounts'); ?>

                    </p>
                </div>
            </div>

            <!-- Feature 3 -->
            <div class="group relative" data-aos="fade-up" data-aos-delay="300">
                <div class="absolute inset-0 bg-gradient-to-br from-orange-500 to-red-600 rounded-3xl opacity-0 group-hover:opacity-10 transition-opacity duration-500"></div>
                <div class="relative h-full p-8 bg-white rounded-3xl border-2 border-gray-100 hover:border-orange-200 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                    <div class="relative mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-orange-100 to-red-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <h3 class="text-xl lg:text-2xl font-bold text-gray-900 mb-3 group-hover:text-orange-600 transition-colors">
                        <?php echo e(app()->getLocale() == 'ar' ? 'أسعار مرنة' : 'Flexible Pricing'); ?>

                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        <?php echo e(app()->getLocale() == 'ar' 
                            ? 'حدد أسعارك الخاصة واحصل على أرباح عالية مع هامش ربح ممتاز'
                            : 'Set your own prices and get high profits with excellent profit margins'); ?>

                    </p>
                </div>
            </div>

            <!-- Feature 4 -->
            <div class="group relative" data-aos="fade-up" data-aos-delay="100">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-3xl opacity-0 group-hover:opacity-10 transition-opacity duration-500"></div>
                <div class="relative h-full p-8 bg-white rounded-3xl border-2 border-gray-100 hover:border-blue-200 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                    <div class="relative mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <h3 class="text-xl lg:text-2xl font-bold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors">
                        <?php echo e(app()->getLocale() == 'ar' ? 'دعم فني مجاني' : 'Free Technical Support'); ?>

                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        <?php echo e(app()->getLocale() == 'ar' 
                            ? 'فريق الدعم الفني لدينا يساعد عملائك مباشرة 24/7 دون تكلفة إضافية'
                            : 'Our technical support team helps your clients directly 24/7 at no extra cost'); ?>

                    </p>
                </div>
            </div>

            <!-- Feature 5 -->
            <div class="group relative" data-aos="fade-up" data-aos-delay="200">
                <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-teal-600 rounded-3xl opacity-0 group-hover:opacity-10 transition-opacity duration-500"></div>
                <div class="relative h-full p-8 bg-white rounded-3xl border-2 border-gray-100 hover:border-green-200 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                    <div class="relative mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-100 to-teal-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <h3 class="text-xl lg:text-2xl font-bold text-gray-900 mb-3 group-hover:text-green-600 transition-colors">
                        <?php echo e(app()->getLocale() == 'ar' ? 'SSL مجاني مدى الحياة' : 'Free SSL Certificates'); ?>

                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        <?php echo e(app()->getLocale() == 'ar' 
                            ? 'شهادات SSL مجانية غير محدودة لجميع نطاقات عملائك'
                            : 'Unlimited free SSL certificates for all your clients\' domains'); ?>

                    </p>
                </div>
            </div>

            <!-- Feature 6 -->
            <div class="group relative" data-aos="fade-up" data-aos-delay="300">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-3xl opacity-0 group-hover:opacity-10 transition-opacity duration-500"></div>
                <div class="relative h-full p-8 bg-white rounded-3xl border-2 border-gray-100 hover:border-indigo-200 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                    <div class="relative mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <h3 class="text-xl lg:text-2xl font-bold text-gray-900 mb-3 group-hover:text-indigo-600 transition-colors">
                        <?php echo e(app()->getLocale() == 'ar' ? 'نسخ احتياطي تلقائي' : 'Automatic Backups'); ?>

                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        <?php echo e(app()->getLocale() == 'ar' 
                            ? 'نسخ احتياطي يومي تلقائي لجميع حسابات عملائك مع استعادة سهلة'
                            : 'Daily automatic backups for all your clients\' accounts with easy restoration'); ?>

                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                <?php echo e(__('frontend.why_choose_progenious') ?? 'لماذا تختار Pro Gineous لاستضافة الموزعين؟'); ?>

            </h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                <?php echo e(__('frontend.why_choose_progenious_desc') ?? 'نقدم لك أفضل الحلول لبدء وتنمية عملك في الاستضافة مع دعم متكامل وتقنيات متطورة'); ?>

            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Reason 1 -->
            <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-8 hover:shadow-xl transition-all duration-300" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">
                    <?php echo e(__('frontend.guaranteed_uptime') ?? 'وقت تشغيل مضمون 99.9%'); ?>

                </h3>
                <p class="text-gray-600 leading-relaxed">
                    <?php echo e(__('frontend.guaranteed_uptime_desc') ?? 'بنية تحتية موثوقة مع مراقبة على مدار الساعة لضمان استمرارية خدمات عملائك دون انقطاع'); ?>

                </p>
            </div>

            <!-- Reason 2 -->
            <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl p-8 hover:shadow-xl transition-all duration-300" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">
                    <?php echo e(__('frontend.instant_activation') ?? 'تفعيل فوري'); ?>

                </h3>
                <p class="text-gray-600 leading-relaxed">
                    <?php echo e(__('frontend.instant_activation_desc') ?? 'احصل على حساب الريسلر الخاص بك جاهزاً للاستخدام فوراً بعد الدفع دون أي تأخير'); ?>

                </p>
            </div>

            <!-- Reason 3 -->
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-8 hover:shadow-xl transition-all duration-300" data-aos="fade-up" data-aos-delay="300">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">
                    <?php echo e(__('frontend.competitive_pricing') ?? 'أسعار تنافسية'); ?>

                </h3>
                <p class="text-gray-600 leading-relaxed">
                    <?php echo e(__('frontend.competitive_pricing_desc') ?? 'احصل على أفضل قيمة مقابل استثمارك مع أسعار مرنة تتيح لك تحقيق أرباح جيدة'); ?>

                </p>
            </div>

            <!-- Reason 4 -->
            <div class="bg-gradient-to-br from-orange-50 to-amber-50 rounded-2xl p-8 hover:shadow-xl transition-all duration-300" data-aos="fade-up" data-aos-delay="400">
                <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-amber-500 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">
                    <?php echo e(__('frontend.expert_support') ?? 'دعم فني متخصص'); ?>

                </h3>
                <p class="text-gray-600 leading-relaxed">
                    <?php echo e(__('frontend.expert_support_desc') ?? 'فريق دعم خبير متاح على مدار الساعة لمساعدتك أنت وعملائك في أي وقت'); ?>

                </p>
            </div>

            <!-- Reason 5 -->
            <div class="bg-gradient-to-br from-red-50 to-rose-50 rounded-2xl p-8 hover:shadow-xl transition-all duration-300" data-aos="fade-up" data-aos-delay="500">
                <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-rose-500 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">
                    <?php echo e(__('frontend.scalable_solutions') ?? 'حلول قابلة للتوسع'); ?>

                </h3>
                <p class="text-gray-600 leading-relaxed">
                    <?php echo e(__('frontend.scalable_solutions_desc') ?? 'نمو عملك معنا سهل وسلس، يمكنك الترقية إلى باقة أعلى في أي وقت دون توقف'); ?>

                </p>
            </div>

            <!-- Reason 6 -->
            <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl p-8 hover:shadow-xl transition-all duration-300" data-aos="fade-up" data-aos-delay="600">
                <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">
                    <?php echo e(__('frontend.detailed_documentation') ?? 'دليل شامل'); ?>

                </h3>
                <p class="text-gray-600 leading-relaxed">
                    <?php echo e(__('frontend.detailed_documentation_desc') ?? 'وثائق تقنية شاملة وفيديوهات تعليمية لمساعدتك في بدء وإدارة عملك بكفاءة'); ?>

                </p>
            </div>
        </div>

        <!-- Additional Benefits -->
        <div class="mt-16 bg-gradient-to-r from-purple-600 to-pink-600 rounded-3xl p-8 md:p-12" data-aos="fade-up">
            <div class="grid md:grid-cols-4 gap-8 text-center text-white">
                <div>
                    <div class="text-4xl font-bold mb-2">99.9%</div>
                    <div class="text-purple-100"><?php echo e(__('frontend.uptime_guarantee') ?? 'ضمان وقت التشغيل'); ?></div>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-2">24/7</div>
                    <div class="text-purple-100"><?php echo e(__('frontend.technical_support') ?? 'دعم فني'); ?></div>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-2">∞</div>
                    <div class="text-purple-100"><?php echo e(__('frontend.unlimited_accounts') ?? 'حسابات غير محدودة'); ?></div>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-2">100%</div>
                    <div class="text-purple-100"><?php echo e(__('frontend.white_label') ?? 'White Label'); ?></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Plans Section -->
<section id="plans" class="py-20 bg-gradient-to-br from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                <?php echo e(__('frontend.choose_your_plan') ?? 'اختر الباقة المناسبة'); ?>

            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                <?php echo e(__('frontend.reseller_plans_desc') ?? 'باقات ريسلر مرنة تناسب جميع الاحتياجات وجميع الميزانيات'); ?>

            </p>
        </div>

        <?php if($plans && $plans->count() > 0): ?>
            <div x-data="{ cycle: 'monthly', open: false }">
                <!-- Billing Cycle Dropdown -->
                <div class="flex justify-center mb-12">
                    <div class="relative inline-block w-full max-w-md">
                        <button @click="open = !open" type="button"
                            class="relative w-full cursor-pointer rounded-2xl bg-white py-4 px-6 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> shadow-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 border-2 border-gray-100">
                            <span class="flex items-center justify-between">
                                <span class="flex items-center">
                                    <span class="block text-base font-semibold text-gray-900" x-text="
                                        cycle === 'monthly' ? '<?php echo e(__('frontend.monthly') ?? 'شهري'); ?>' :
                                        cycle === 'quarterly' ? '<?php echo e(__('frontend.quarterly') ?? 'ربع سنوي'); ?>' :
                                        cycle === 'semiannually' ? '<?php echo e(__('frontend.semiannually') ?? 'نصف سنوي'); ?>' :
                                        cycle === 'annually' ? '<?php echo e(__('frontend.annually') ?? 'سنوي'); ?>' :
                                        cycle === 'biennially' ? '<?php echo e(__('frontend.biennially') ?? 'سنتين'); ?>' :
                                        '<?php echo e(__('frontend.triennially') ?? 'ثلاث سنوات'); ?>'
                                    "></span>
                                </span>
                                <svg class="h-5 w-5 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </span>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute z-10 mt-2 w-full rounded-2xl bg-white shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none"
                            style="display: none;">
                            <div class="py-2">
                                <button @click="cycle = 'monthly'; open = false" class="block w-full px-6 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                    <?php echo e(__('frontend.monthly') ?? 'شهري'); ?>

                                </button>
                                <button @click="cycle = 'quarterly'; open = false" class="block w-full px-6 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                    <?php echo e(__('frontend.quarterly') ?? 'ربع سنوي'); ?> <span class="text-green-600 font-semibold">(<?php echo e(__('frontend.save_10') ?? 'وفر 10%'); ?>)</span>
                                </button>
                                <button @click="cycle = 'semiannually'; open = false" class="block w-full px-6 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                    <?php echo e(__('frontend.semiannually') ?? 'نصف سنوي'); ?> <span class="text-green-600 font-semibold">(<?php echo e(__('frontend.save_15') ?? 'وفر 15%'); ?>)</span>
                                </button>
                                <button @click="cycle = 'annually'; open = false" class="block w-full px-6 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                    <?php echo e(__('frontend.annually') ?? 'سنوي'); ?> <span class="text-orange-600 font-semibold">(<?php echo e(__('frontend.save_20') ?? 'وفر 20%'); ?>)</span>
                                </button>
                                <button @click="cycle = 'biennially'; open = false" class="block w-full px-6 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                    <?php echo e(__('frontend.biennially') ?? 'سنتين'); ?> <span class="text-orange-600 font-semibold">(<?php echo e(__('frontend.save_30') ?? 'وفر 30%'); ?>)</span>
                                </button>
                                <button @click="cycle = 'triennially'; open = false" class="block w-full px-6 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                    <?php echo e(__('frontend.triennially') ?? 'ثلاث سنوات'); ?> <span class="text-red-600 font-semibold">(<?php echo e(__('frontend.save_40') ?? 'وفر 40%'); ?>)</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Plans Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $pricing = is_array($plan->pricing) ? $plan->pricing : [];
                        $features = app()->getLocale() == 'ar' 
                            ? (is_array($plan->features_list_ar) ? $plan->features_list_ar : $plan->features_list_ar) 
                            : (is_array($plan->features_list) ? $plan->features_list : $plan->features_list);
                        
                        $monthlyPrice = $pricing['recurring']['monthly']['price'] ?? 0;
                        $quarterlyPrice = $pricing['recurring']['quarterly']['price'] ?? 0;
                        $semiannuallyPrice = $pricing['recurring']['semi_annually']['price'] ?? 0;
                        $annuallyPrice = $pricing['recurring']['annually']['price'] ?? 0;
                        $bienniallyPrice = $pricing['recurring']['biennially']['price'] ?? 0;
                        $trienniallyPrice = $pricing['recurring']['triennially']['price'] ?? 0;
                    ?>
                    
                    <div class="relative group" data-aos="fade-up" data-aos-delay="<?php echo e(($index + 1) * 100); ?>" x-data="{ 
                        monthlyPrice: <?php echo e($monthlyPrice); ?>,
                        quarterlyPrice: <?php echo e($quarterlyPrice); ?>,
                        semiannuallyPrice: <?php echo e($semiannuallyPrice); ?>,
                        annuallyPrice: <?php echo e($annuallyPrice); ?>,
                        bienniallyPrice: <?php echo e($bienniallyPrice); ?>,
                        trienniallyPrice: <?php echo e($trienniallyPrice); ?>

                    }">
                        <?php if($plan->is_featured): ?>
                            <!-- Featured Badge -->
                            <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 z-20">
                                <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white text-sm font-bold rounded-full shadow-xl">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?> animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <?php echo e(app()->getLocale() == 'ar' ? 'الأكثر شعبية' : 'Most Popular'); ?>

                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="relative h-full bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border-2 <?php echo e($plan->is_featured ? 'border-purple-500 scale-105' : 'border-gray-200'); ?> overflow-hidden">
                            <?php if($plan->is_featured): ?>
                                <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-pink-500/5"></div>
                            <?php endif; ?>
                            
                            <div class="relative p-8">
                                <!-- Plan Name -->
                                <h3 class="text-2xl font-bold text-gray-900 mb-4"><?php echo e($plan->name); ?></h3>
                                
                                <!-- Price -->
                                <div class="mb-6">
                                    <div class="flex items-baseline gap-2">
                                        <span class="text-5xl font-black text-gray-900">
                                            $<span x-text="
                                                cycle === 'monthly' ? monthlyPrice :
                                                cycle === 'quarterly' ? quarterlyPrice :
                                                cycle === 'semiannually' ? semiannuallyPrice :
                                                cycle === 'annually' ? annuallyPrice :
                                                cycle === 'biennially' ? bienniallyPrice :
                                                trienniallyPrice
                                            "></span>
                                        </span>
                                        <span class="text-gray-500 font-medium" x-text="
                                            cycle === 'monthly' ? '/<?php echo e(__('frontend.per_month') ?? 'شهر'); ?>' :
                                            cycle === 'quarterly' ? '/<?php echo e(__('frontend.per_3_months') ?? '3 أشهر'); ?>' :
                                            cycle === 'semiannually' ? '/<?php echo e(__('frontend.per_6_months') ?? '6 أشهر'); ?>' :
                                            cycle === 'annually' ? '/<?php echo e(__('frontend.per_year') ?? 'سنة'); ?>' :
                                            cycle === 'biennially' ? '/<?php echo e(__('frontend.per_2_years') ?? 'سنتين'); ?>' :
                                            '/<?php echo e(__('frontend.per_3_years') ?? '3 سنوات'); ?>'
                                        "></span>
                                    </div>
                                </div>

                                <!-- CTA Button -->
                                <a href="<?php echo e(route('products.show', $plan->id)); ?>" class="block w-full text-center px-6 py-4 <?php echo e($plan->is_featured ? 'bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700' : 'bg-gray-900 hover:bg-gray-800'); ?> text-white font-bold rounded-xl transition-all duration-300 transform hover:scale-105 mb-8">
                                    <?php echo e(__('frontend.get_started') ?? 'ابدأ الآن'); ?>

                                </a>

                                <!-- Free Domains Badge -->
                                <?php
                                    $freeDomainConfig = $plan->free_domain_config;
                                    $showFreeDomain = false;
                                    $freeDomainTlds = [];
                                    
                                    if ($freeDomainConfig && isset($freeDomainConfig['tlds'])) {
                                        $freeDomainTlds = $freeDomainConfig['tlds'];
                                        $terms = $freeDomainConfig['terms'] ?? [];
                                        // Show if applicable to current billing terms
                                        if (in_array('annually', $terms) || in_array('biennially', $terms) || in_array('triennially', $terms)) {
                                            $showFreeDomain = true;
                                        }
                                    }
                                ?>
                                
                                <?php if($showFreeDomain && count($freeDomainTlds) > 0): ?>
                                    <div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border-2 border-green-200" x-show="cycle === 'annually' || cycle === 'biennially' || cycle === 'triennially'">
                                        <div class="flex items-start gap-3">
                                            <div class="flex-shrink-0">
                                                <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-500 rounded-lg flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <h5 class="text-sm font-bold text-green-900 mb-2">
                                                    <?php echo e(__('frontend.free_domain_included') ?? 'نطاق مجاني متضمن'); ?>

                                                </h5>
                                                <p class="text-xs text-green-700 mb-3">
                                                    <?php echo e(__('frontend.free_domain_desc') ?? 'احصل على نطاق مجاني عند الاشتراك السنوي أو الأطول'); ?>

                                                </p>
                                                <div class="flex flex-wrap gap-2">
                                                    <?php $__currentLoopData = $freeDomainTlds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tld): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <span class="inline-flex items-center px-2.5 py-1 bg-white text-green-700 text-xs font-semibold rounded-lg border border-green-300">
                                                            .<?php echo e($tld); ?>

                                                        </span>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                                <p class="text-xs text-green-600 mt-2 font-medium">
                                                    <?php if(isset($freeDomainConfig['type']) && $freeDomainConfig['type'] === 'reg_transfer_renewal'): ?>
                                                        <?php echo e(__('frontend.free_domain_note_renewal') ?? '* النطاق مجاني للتسجيل والنقل والتجديد'); ?>

                                                    <?php else: ?>
                                                        <?php echo e(__('frontend.free_domain_note') ?? '* النطاق مجاني للسنة الأولى فقط'); ?>

                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- Features List -->
                                <?php if($features && count($features) > 0): ?>
                                    <div class="space-y-4">
                                        <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-4"><?php echo e(__('frontend.features_included') ?? 'المميزات المتضمنة'); ?></h4>
                                        <ul class="space-y-3">
                                            <?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li class="flex items-start gap-3">
                                                    <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="text-gray-600 text-sm"><?php echo e($feature); ?></span>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-20">
                <div class="inline-flex items-center px-6 py-3 bg-purple-100 text-purple-700 rounded-full mb-4">
                    <svg class="w-6 h-6 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <?php echo e(__('frontend.coming_soon') ?? 'قريباً'); ?>

                </div>
                <p class="text-gray-600 text-lg">
                    <?php echo e(__('frontend.reseller_plans_coming_soon') ?? 'باقات استضافة الريسلر ستكون متاحة قريباً'); ?>

                </p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- cPanel Reseller Hosting Benefits Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                <?php echo e(__('frontend.cpanel_reseller_benefits') ?? 'مميزات استضافة الموزعين cPanel'); ?>

            </h2>
            <p class="text-lg text-gray-600 max-w-4xl mx-auto leading-relaxed">
                <?php echo e(__('frontend.cpanel_reseller_benefits_desc') ?? 'كل حساب استضافة موزعين cPanel يتيح لك إنشاء حسابات cPanel فرعية متعددة، كل منها مستقل عن الآخر بموارده الخاصة ومجموعة محددة من القيود. هذا يعني أنه يمكنك بيع الاستضافة لعملائك بناءً على موارد محددة أو مميزات استضافة معينة، بالإضافة إلى تقديم ترقيات للمستخدمين الذين يحتاجون إلى موارد إضافية.'); ?>

            </p>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Great Business Features -->
            <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl p-8" data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center <?php echo e(app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4'); ?>">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">
                        <?php echo e(__('frontend.great_business_features') ?? 'مميزات تجارية رائعة'); ?>

                    </h3>
                </div>
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5 <?php echo e(app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-gray-700"><?php echo e(__('frontend.completely_whitelabel') ?? 'White Label بالكامل'); ?></span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5 <?php echo e(app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-gray-700"><?php echo e(__('frontend.instant_setup') ?? 'إعداد فوري'); ?></span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5 <?php echo e(app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-gray-700"><?php echo e(__('frontend.unlimited_free_migrations') ?? 'انتقالات مجانية غير محدودة'); ?></span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5 <?php echo e(app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-gray-700"><?php echo e(__('frontend.choice_of_locations') ?? 'اختيار من 20 موقع'); ?></span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5 <?php echo e(app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-gray-700"><?php echo e(__('frontend.offsite_backups') ?? 'نسخ احتياطية خارجية لمدة 30 يوم'); ?></span>
                    </li>
                </ul>
            </div>

            <!-- Key Technical Benefits -->
            <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-8" data-aos="fade-up" data-aos-delay="200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center <?php echo e(app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4'); ?>">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">
                        <?php echo e(__('frontend.key_technical_benefits') ?? 'المميزات التقنية الرئيسية'); ?>

                    </h3>
                </div>
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-purple-600 flex-shrink-0 mt-0.5 <?php echo e(app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-gray-700"><?php echo e(__('frontend.unlimited_nvme_ssd') ?? 'مساحة NvME/SSD غير محدودة'); ?></span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-purple-600 flex-shrink-0 mt-0.5 <?php echo e(app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-gray-700"><?php echo e(__('frontend.distributed_anycast_dns') ?? 'DNS Anycast موزع مع خوادم أسماء مخصصة'); ?></span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-purple-600 flex-shrink-0 mt-0.5 <?php echo e(app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-gray-700"><?php echo e(__('frontend.high_cloudlinux_lve') ?? 'حدود CloudLinux LVE عالية'); ?></span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-purple-600 flex-shrink-0 mt-0.5 <?php echo e(app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-gray-700"><?php echo e(__('frontend.free_ssl_certificates') ?? 'شهادات SSL مجانية'); ?></span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-purple-600 flex-shrink-0 mt-0.5 <?php echo e(app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-gray-700"><?php echo e(__('frontend.unlimited_bandwidth') ?? 'باندويث غير محدود'); ?></span>
                    </li>
                </ul>
            </div>

            <!-- Additional Features -->
            <div class="bg-gradient-to-br from-orange-50 to-amber-50 rounded-2xl p-8" data-aos="fade-up" data-aos-delay="300">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-amber-500 rounded-xl flex items-center justify-center <?php echo e(app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4'); ?>">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">
                        <?php echo e(__('frontend.additional_features') ?? 'مميزات إضافية'); ?>

                    </h3>
                </div>
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-orange-600 flex-shrink-0 mt-0.5 <?php echo e(app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-gray-700"><?php echo e(__('frontend.free_domain_registration') ?? 'تسجيل أو نقل دومين مجاني واحد'); ?></span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-orange-600 flex-shrink-0 mt-0.5 <?php echo e(app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-gray-700"><?php echo e(__('frontend.email_reputation_protection') ?? 'حماية سمعة البريد الإلكتروني Mailchannels/SpamXperts'); ?></span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-orange-600 flex-shrink-0 mt-0.5 <?php echo e(app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-gray-700"><?php echo e(__('frontend.premium_tools') ?? 'LiteSpeed، CloudLinux، LScache، Jetbackup، Imunify360، Softaculous، Sitepad والمزيد...'); ?></span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Infrastructure Highlight -->
        <div class="mt-12 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 rounded-3xl p-8 md:p-12 text-center text-white" data-aos="fade-up" data-aos-delay="400">
            <div class="max-w-4xl mx-auto">
                <h3 class="text-2xl md:text-3xl font-bold mb-4">
                    <?php echo e(__('frontend.world_leading_infrastructure') ?? 'بنية تحتية رائدة عالمياً'); ?>

                </h3>
                <p class="text-lg text-white/90 leading-relaxed">
                    <?php echo e(__('frontend.world_leading_infrastructure_desc') ?? 'كل هذا مدعوم بالبنية التحتية الرائدة عالمياً من Pro Gineous، مما يضمن أداءً عالياً واستقراراً لا مثيل له لعملك وعملائك.'); ?>

                </p>
            </div>
        </div>
    </div>
</section>

<!-- cPanel Reseller Hosting Features Section -->
<section class="py-20 bg-gradient-to-br from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                <?php echo e(__('frontend.cpanel_reseller_features') ?? 'مميزات استضافة الموزعين cPanel'); ?>

            </h2>
            <p class="text-lg text-gray-600 max-w-4xl mx-auto leading-relaxed">
                <?php echo e(__('frontend.cpanel_reseller_features_desc') ?? 'بيئة الاستضافة المثالية: قوية ومرنة، سهلة الاستخدام ومع إضافات مهمة مثل النسخ الاحتياطية، شهادات SSL وخوادم الأسماء المخصصة متضمنة كمعيار.'); ?>

            </p>
        </div>

        <!-- Technology Highlights -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-16" data-aos="fade-up" data-aos-delay="100">
            <div class="bg-white rounded-xl p-6 text-center shadow-lg hover:shadow-xl transition-all duration-300 border-2 border-purple-100 hover:border-purple-300">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                    </svg>
                </div>
                <h4 class="font-bold text-gray-900"><?php echo e(__('frontend.whm_cpanel') ?? 'WHM/cPanel'); ?></h4>
            </div>

            <div class="bg-white rounded-xl p-6 text-center shadow-lg hover:shadow-xl transition-all duration-300 border-2 border-blue-100 hover:border-blue-300">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                    </svg>
                </div>
                <h4 class="font-bold text-gray-900"><?php echo e(__('frontend.software') ?? 'البرمجيات'); ?></h4>
            </div>

            <div class="bg-white rounded-xl p-6 text-center shadow-lg hover:shadow-xl transition-all duration-300 border-2 border-green-100 hover:border-green-300">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
                <h4 class="font-bold text-gray-900"><?php echo e(__('frontend.whitelabel') ?? 'Whitelabel'); ?></h4>
            </div>

            <div class="bg-white rounded-xl p-6 text-center shadow-lg hover:shadow-xl transition-all duration-300 border-2 border-orange-100 hover:border-orange-300">
                <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-amber-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <h4 class="font-bold text-gray-900"><?php echo e(__('frontend.support_24_7') ?? 'دعم 24/7'); ?></h4>
            </div>

            <div class="bg-white rounded-xl p-6 text-center shadow-lg hover:shadow-xl transition-all duration-300 border-2 border-indigo-100 hover:border-indigo-300">
                <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                    </svg>
                </div>
                <h4 class="font-bold text-gray-900"><?php echo e(__('frontend.server_setup') ?? 'إعداد الخادم'); ?></h4>
            </div>

            <div class="bg-white rounded-xl p-6 text-center shadow-lg hover:shadow-xl transition-all duration-300 border-2 border-pink-100 hover:border-pink-300">
                <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-rose-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h4 class="font-bold text-gray-900"><?php echo e(__('frontend.email') ?? 'البريد الإلكتروني'); ?></h4>
            </div>

            <div class="bg-white rounded-xl p-6 text-center shadow-lg hover:shadow-xl transition-all duration-300 border-2 border-teal-100 hover:border-teal-300">
                <div class="w-16 h-16 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h4 class="font-bold text-gray-900"><?php echo e(__('frontend.fully_managed') ?? 'إدارة كاملة'); ?></h4>
            </div>

            <div class="bg-white rounded-xl p-6 text-center shadow-lg hover:shadow-xl transition-all duration-300 border-2 border-red-100 hover:border-red-300">
                <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-pink-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h4 class="font-bold text-gray-900"><?php echo e(__('frontend.instant_setup') ?? 'إعداد فوري'); ?></h4>
            </div>
        </div>

        <!-- Detailed Features -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Fully Managed -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300" data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-start mb-6">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-4' : 'ml-4'); ?>">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                            <?php echo e(__('frontend.fully_managed') ?? 'إدارة كاملة'); ?>

                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            <?php echo e(__('frontend.fully_managed_desc') ?? 'لا يُشترط خبرة تقنية. نحن نتولى إدارة الخادم بالكامل، مما يضمن تشغيل استضافتك بسرعة وأمان.'); ?>

                        </p>
                    </div>
                </div>
            </div>

            <!-- cPanel/WHM -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300" data-aos="fade-up" data-aos-delay="200">
                <div class="flex items-start mb-6">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                        </svg>
                    </div>
                    <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-4' : 'ml-4'); ?>">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                            <?php echo e(__('frontend.cpanel_whm') ?? 'cPanel/WHM'); ?>

                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            <?php echo e(__('frontend.cpanel_whm_desc') ?? 'واجهة WHM الرائدة في السوق، والتي تتيح لك إنشاء حسابات cPanel فردية لكل موقع من مواقعك.'); ?>

                        </p>
                    </div>
                </div>
            </div>

            <!-- Everything Included -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300" data-aos="fade-up" data-aos-delay="300">
                <div class="flex items-start mb-6">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-4' : 'ml-4'); ?>">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                            <?php echo e(__('frontend.everything_included') ?? 'كل شيء متضمن'); ?>

                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            <?php echo e(__('frontend.everything_included_desc') ?? 'لا توجد رسوم خفية أو بيع إضافي للميزات الأساسية. شهادات SSL، الانتقالات، حسابات البريد الإلكتروني، خوادم الأسماء المخصصة - كل هذا وأكثر متضمن في السعر الشهري.'); ?>

                        </p>
                    </div>
                </div>
            </div>

            <!-- Free Migrations -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300" data-aos="fade-up" data-aos-delay="400">
                <div class="flex items-start mb-6">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-amber-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                    </div>
                    <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-4' : 'ml-4'); ?>">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                            <?php echo e(__('frontend.free_migrations') ?? 'انتقالات مجانية'); ?>

                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            <?php echo e(__('frontend.free_migrations_desc') ?? 'يمكننا نقل مواقعك من مزودي الخدمة الخارجيين إلينا، بالسرعة والوقت الذي تختاره. إذا كنت تريد، يمكننا البدء فوراً.'); ?>

                        </p>
                    </div>
                </div>
            </div>

            <!-- Money-back Guarantee -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300" data-aos="fade-up" data-aos-delay="500">
                <div class="flex items-start mb-6">
                    <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-4' : 'ml-4'); ?>">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                            <?php echo e(__('frontend.money_back_guarantee') ?? 'ضمان استرداد الأموال'); ?>

                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            <?php echo e(__('frontend.money_back_guarantee_desc') ?? 'جرّب لمدة 30 يوماً. سنرد لك أموالك إذا لم تكن راضياً. الموزعون المميزون لديهم ضمان استرداد لمدة 45 يوماً.'); ?>

                        </p>
                    </div>
                </div>
            </div>

            <!-- Instant Setup -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300" data-aos="fade-up" data-aos-delay="600">
                <div class="flex items-start mb-6">
                    <div class="w-14 h-14 bg-gradient-to-br from-pink-500 to-rose-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-4' : 'ml-4'); ?>">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                            <?php echo e(__('frontend.instant_setup') ?? 'إعداد فوري'); ?>

                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            <?php echo e(__('frontend.instant_setup_desc') ?? 'اطلب الآن وكن جاهزاً للعمل في ثوانٍ. إذا كانت لديك عمليات انتقال، يمكننا البدء بها على الفور أيضاً.'); ?>

                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Web Host Manager (WHM) Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                <?php echo e(__('frontend.whm_title') ?? 'Web Host Manager (WHM)'); ?>

            </h2>
            <p class="text-lg text-gray-600 max-w-4xl mx-auto leading-relaxed">
                <?php echo e(__('frontend.whm_desc') ?? 'Web Host Manager هو واجهة مستعرض رسومية تتيح لك إدارة حسابات الاستضافة الخاصة بك بسرعة وسهولة. إنشاء حساب بسيط مثل إدخال اسم نطاق، ويمكنك بعد ذلك تسجيل الدخول إلى لوحة التحكم الخاصة بكل موقع بنقرة واحدة.'); ?>

            </p>
        </div>

        <!-- WHM Features Grid -->
        <div class="grid md:grid-cols-2 gap-8 mb-12">
            <!-- Bulk cPanel Management -->
            <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300" data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-start mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"></path>
                        </svg>
                    </div>
                    <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-5' : 'ml-5'); ?>">
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">
                            <?php echo e(__('frontend.bulk_cpanel_management') ?? 'إدارة cPanel الجماعية'); ?>

                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            <?php echo e(__('frontend.bulk_cpanel_management_desc') ?? 'قم بإدراج جميع حسابات cPanel، وتعليقها وإنهائها. قم بتسجيل الدخول إلى كل واحد منها بسهولة، دون الحاجة إلى تذكر بيانات تسجيل دخول منفصلة.'); ?>

                        </p>
                    </div>
                </div>
            </div>

            <!-- Easy Migrations -->
            <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300" data-aos="fade-up" data-aos-delay="200">
                <div class="flex items-start mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                    </div>
                    <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-5' : 'ml-5'); ?>">
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">
                            <?php echo e(__('frontend.easy_migrations') ?? 'انتقالات سهلة'); ?>

                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            <?php echo e(__('frontend.easy_migrations_desc') ?? 'إذا كنت تستخدم بالفعل WHM أو cPanel مع مضيفك الحالي، يمكننا بسهولة ترحيل النسخ الاحتياطية لـ cPanel إلى حساب الموزع الجديد الخاص بك.'); ?>

                        </p>
                    </div>
                </div>
            </div>

            <!-- Packages & Feature Lists -->
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300" data-aos="fade-up" data-aos-delay="300">
                <div class="flex items-start mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-5' : 'ml-5'); ?>">
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">
                            <?php echo e(__('frontend.packages_feature_lists') ?? 'الباقات وقوائم المميزات'); ?>

                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            <?php echo e(__('frontend.packages_feature_lists_desc') ?? 'قم بإنشاء باقات الاستضافة الخاصة بك، مع حدود مساحة القرص والباندويث والموارد الأخرى. قم بترقية وتخفيض المواقع بين الباقات، ومراجعة استخدامها.'); ?>

                        </p>
                    </div>
                </div>
            </div>

            <!-- Backup Tools -->
            <div class="bg-gradient-to-br from-orange-50 to-amber-50 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300" data-aos="fade-up" data-aos-delay="400">
                <div class="flex items-start mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-amber-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                        </svg>
                    </div>
                    <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-5' : 'ml-5'); ?>">
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">
                            <?php echo e(__('frontend.backup_tools') ?? 'أدوات النسخ الاحتياطي'); ?>

                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            <?php echo e(__('frontend.backup_tools_desc') ?? 'يتم عمل نسخة احتياطية لكل موقع مرتين يومياً، ويمكنك الاستعادة الذاتية باستخدام Jetbackup. نمنحك أيضاً وصولاً كاملاً إلى أداة النسخ الاحتياطي الخاصة بـ cPanel. الموزعون المميزون يحصلون على نسخ احتياطية أربع مرات يومياً.'); ?>

                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- WHM Benefits Banner -->
        <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 rounded-3xl p-8 md:p-12 text-white" data-aos="fade-up" data-aos-delay="500">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div>
                    <h3 class="text-2xl md:text-3xl font-bold mb-4">
                        <?php echo e(__('frontend.whm_power_control') ?? 'قوة وتحكم كامل'); ?>

                    </h3>
                    <p class="text-lg text-white/90 leading-relaxed mb-6">
                        <?php echo e(__('frontend.whm_power_control_desc') ?? 'WHM يمنحك السيطرة الكاملة على جميع حسابات الاستضافة الخاصة بك من مكان واحد. إدارة احترافية مع أدوات قوية.'); ?>

                    </p>
                    <div class="flex flex-wrap gap-4">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-white <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span><?php echo e(__('frontend.one_click_login') ?? 'تسجيل دخول بنقرة واحدة'); ?></span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-white <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span><?php echo e(__('frontend.resource_monitoring') ?? 'مراقبة الموارد'); ?></span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-white <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span><?php echo e(__('frontend.automated_backups') ?? 'نسخ احتياطية تلقائية'); ?></span>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-white/80"><?php echo e(__('frontend.daily_backups') ?? 'نسخ احتياطية يومية'); ?></span>
                                <span class="text-2xl font-bold">2x</span>
                            </div>
                            <div class="h-px bg-white/20"></div>
                            <div class="flex items-center justify-between">
                                <span class="text-white/80"><?php echo e(__('frontend.premium_backups') ?? 'نسخ احتياطية مميزة'); ?></span>
                                <span class="text-2xl font-bold">4x</span>
                            </div>
                            <div class="h-px bg-white/20"></div>
                            <div class="flex items-center justify-between">
                                <span class="text-white/80"><?php echo e(__('frontend.jetbackup_access') ?? 'وصول Jetbackup'); ?></span>
                                <span class="text-2xl font-bold">✓</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Software & Tools Section -->
<section class="py-20 bg-gradient-to-br from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                <?php echo e(__('frontend.software_tools') ?? 'البرمجيات والأدوات'); ?>

            </h2>
            <p class="text-lg text-gray-600 max-w-4xl mx-auto leading-relaxed">
                <?php echo e(__('frontend.software_tools_desc') ?? 'أدوات قوية ومرنة لتثبيت وإدارة التطبيقات بسهولة. كل ما تحتاجه لبناء مواقع ويب احترافية.'); ?>

            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- One-Click WordPress -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 border-blue-100 hover:border-blue-300" data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-start mb-6">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.158 12.786l-2.698 7.84c.806.236 1.657.365 2.54.365 1.047 0 2.051-.18 2.986-.51-.024-.037-.046-.078-.065-.123l-2.763-7.572zm-5.316 3.713c-.78-1.422-1.221-3.05-1.221-4.786 0-1.944.558-3.754 1.521-5.28-.096-.012-.19-.018-.285-.018-1.787 0-3.24 1.453-3.24 3.24 0 1.206.66 2.258 1.638 2.82l2.587 7.024zm10.912-11.783c.828 0 1.581-.32 2.146-.842-1.67-1.514-3.889-2.437-6.318-2.437-2.999 0-5.646 1.385-7.376 3.547.166-.006.33-.013.495-.013.806 0 2.054.098 2.054.098.415.025.464.59.049.638 0 0-.417.049-.881.073l2.805 8.335 1.687-5.056-1.2-3.279c-.415-.024-.806-.073-.806-.073-.415-.025-.367-.663.049-.638 0 0 1.273.098 2.03.098.806 0 2.054-.098 2.054-.098.415-.025.464.59.049.638 0 0-.418.049-.881.073l2.785 8.282.768-2.563c.332-1.065.586-1.83.586-2.488 0-.904-.325-1.53-.604-2.015-.372-.604-.72-1.116-.72-1.72 0-.675.512-1.302 1.234-1.302zM12 15.895c-.414 0-.813-.043-1.197-.123l1.271-3.696 1.302 3.569c.009.02.018.038.028.057-.396.118-.81.193-1.404.193zm7.951-10.179c.09.658.141 1.365.141 2.125 0 1.048-.196 2.227-.784 3.703l-3.148 9.097c3.064-1.787 5.127-5.101 5.127-8.896 0-2.026-.585-3.917-1.596-5.514l.26-.515z"/>
                        </svg>
                    </div>
                    <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-5' : 'ml-5'); ?>">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">
                            <?php echo e(__('frontend.one_click_wordpress') ?? 'WordPress بنقرة واحدة'); ?>

                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            <?php echo e(__('frontend.one_click_wordpress_desc') ?? 'تثبيت فوري لـ WordPress من خلال Softaculous. كن جاهزاً للعمل في بضع نقرات فقط.'); ?>

                        </p>
                    </div>
                </div>
            </div>

            <!-- Optimised -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 border-purple-100 hover:border-purple-300" data-aos="fade-up" data-aos-delay="200">
                <div class="flex items-start mb-6">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-5' : 'ml-5'); ?>">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">
                            <?php echo e(__('frontend.optimised') ?? 'محسّن'); ?>

                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            <?php echo e(__('frontend.optimised_desc') ?? 'نحن نعلم البرامج التي ستقوم بتشغيلها ونحن نحسنها بالفعل. حدود عالية، إعدادات منطقية.'); ?>

                        </p>
                    </div>
                </div>
            </div>

            <!-- 300+ Software Autoinstalls -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 border-green-100 hover:border-green-300" data-aos="fade-up" data-aos-delay="300">
                <div class="flex items-start mb-6">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-5' : 'ml-5'); ?>">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">
                            <?php echo e(__('frontend.software_autoinstalls') ?? '300+ تطبيق بتثبيت تلقائي'); ?>

                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            <?php echo e(__('frontend.software_autoinstalls_desc') ?? 'اختر من بين أكثر من 300 تطبيق يمكنك تثبيته بنقرة واحدة، بدون أي رسوم إضافية.'); ?>

                        </p>
                    </div>
                </div>
            </div>

            <!-- Install Old Versions -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 border-orange-100 hover:border-orange-300" data-aos="fade-up" data-aos-delay="400">
                <div class="flex items-start mb-6">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-amber-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-5' : 'ml-5'); ?>">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">
                            <?php echo e(__('frontend.install_old_versions') ?? 'تثبيت النسخ القديمة'); ?>

                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            <?php echo e(__('frontend.install_old_versions_desc') ?? 'تصفح البرامج حسب الفئة، ثم قم بتثبيت أحدث إصدار مستقر، أو الإصدارات التاريخية السابقة.'); ?>

                        </p>
                    </div>
                </div>
            </div>

            <!-- PHP Configuration -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 border-indigo-100 hover:border-indigo-300" data-aos="fade-up" data-aos-delay="500">
                <div class="flex items-start mb-6">
                    <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-5' : 'ml-5'); ?>">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">
                            <?php echo e(__('frontend.php_configuration') ?? 'إعدادات PHP'); ?>

                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            <?php echo e(__('frontend.php_configuration_desc') ?? 'قم بتغيير إصدار PHP وضبط إعدادات PHP مباشرة من داخل cPanel.'); ?>

                        </p>
                    </div>
                </div>
            </div>

            <!-- SSH Enabled -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 border-teal-100 hover:border-teal-300" data-aos="fade-up" data-aos-delay="600">
                <div class="flex items-start mb-6">
                    <div class="w-14 h-14 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-5' : 'ml-5'); ?>">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">
                            <?php echo e(__('frontend.ssh_enabled') ?? 'SSH مُفعّل'); ?>

                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            <?php echo e(__('frontend.ssh_enabled_desc') ?? 'SSH مُفعّل افتراضياً على كل حساب cPanel تقوم بإنشائه (المنفذ 22). لا حاجة لتعديل الإعدادات أو طلب الإذن.'); ?>

                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Software Stats Banner -->
        <div class="mt-12 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 rounded-3xl p-8 md:p-12 text-white text-center" data-aos="fade-up" data-aos-delay="700">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div>
                    <div class="text-4xl md:text-5xl font-bold mb-2">300+</div>
                    <div class="text-blue-100 text-sm md:text-base"><?php echo e(__('frontend.applications') ?? 'تطبيق'); ?></div>
                </div>
                <div>
                    <div class="text-4xl md:text-5xl font-bold mb-2">1-Click</div>
                    <div class="text-blue-100 text-sm md:text-base"><?php echo e(__('frontend.installation') ?? 'تثبيت'); ?></div>
                </div>
                <div>
                    <div class="text-4xl md:text-5xl font-bold mb-2">SSH</div>
                    <div class="text-blue-100 text-sm md:text-base"><?php echo e(__('frontend.access') ?? 'وصول'); ?></div>
                </div>
                <div>
                    <div class="text-4xl md:text-5xl font-bold mb-2">PHP</div>
                    <div class="text-blue-100 text-sm md:text-base"><?php echo e(__('frontend.customization') ?? 'تخصيص'); ?></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Advanced Features Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                <?php echo e(__('frontend.advanced_features') ?? 'المميزات المتقدمة'); ?>

            </h2>
            <p class="text-lg text-gray-600 max-w-4xl mx-auto leading-relaxed">
                <?php echo e(__('frontend.advanced_features_desc') ?? 'مميزات احترافية متقدمة لبناء علامتك التجارية وإدارة عملك بكفاءة وسهولة.'); ?>

            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Custom Nameservers -->
            <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300" data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-start mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                        </svg>
                    </div>
                    <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-5' : 'ml-5'); ?>">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">
                            <?php echo e(__('frontend.custom_nameservers') ?? 'خوادم أسماء مخصصة'); ?>

                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            <?php echo e(__('frontend.custom_nameservers_desc') ?? 'خوادم الأسماء المخصصة هي خوادم DNS التي يتم تعيينها على اسم النطاق، على سبيل المثال ns1.yourhostingbrand.com و ns2.yourhostingbrand.com. قم بإعداد خوادم الأسماء المخصصة بدون تكلفة إضافية.'); ?>

                        </p>
                    </div>
                </div>
            </div>

            <!-- Fully Whitelabel -->
            <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300" data-aos="fade-up" data-aos-delay="200">
                <div class="flex items-start mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-5' : 'ml-5'); ?>">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">
                            <?php echo e(__('frontend.fully_whitelabel') ?? 'Whitelabel بالكامل'); ?>

                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            <?php echo e(__('frontend.fully_whitelabel_desc') ?? 'ابنِ وأدِر عملك الخاص في استضافة الويب، مع هويتك التجارية الخاصة. منصة الموزعين الخاصة بنا مُعلّمة بالكامل، لذلك لن يعرف عملاؤك أبداً عن Pro Gineous.'); ?>

                        </p>
                    </div>
                </div>
            </div>

            <!-- Anycast DNS -->
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300" data-aos="fade-up" data-aos-delay="300">
                <div class="flex items-start mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-5' : 'ml-5'); ?>">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">
                            <?php echo e(__('frontend.anycast_dns') ?? 'Anycast DNS'); ?>

                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            <?php echo e(__('frontend.anycast_dns_desc') ?? 'نقوم بعمل Anycast لعناوين IP لخوادم DNS الخاصة بنا، مما يعني أنها "معلنة" من مواقع متعددة حول العالم. يتم توجيه الطلبات بعد ذلك بناءً على أقصر مسار إلى أقرب عقدة قادرة على خدمة الطلب.'); ?>

                        </p>
                    </div>
                </div>
            </div>

            <!-- Single DNS Cluster -->
            <div class="bg-gradient-to-br from-orange-50 to-amber-50 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300" data-aos="fade-up" data-aos-delay="400">
                <div class="flex items-start mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-amber-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                        </svg>
                    </div>
                    <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-5' : 'ml-5'); ?>">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">
                            <?php echo e(__('frontend.single_dns_cluster') ?? 'مجموعة DNS واحدة'); ?>

                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            <?php echo e(__('frontend.single_dns_cluster_desc') ?? 'أتمتة حسابات موزعين متعددة، دون الحاجة إلى إنشاء مجموعات متعددة من سجلات DNS. بغض النظر عن عدد الحسابات التي لديك معنا، يمكنك استخدام مجموعة واحدة من خوادم الأسماء.'); ?>

                        </p>
                    </div>
                </div>
            </div>

            <!-- Billing Integration -->
            <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300" data-aos="fade-up" data-aos-delay="500">
                <div class="flex items-start mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-5' : 'ml-5'); ?>">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">
                            <?php echo e(__('frontend.billing_integration') ?? 'تكامل الفوترة'); ?>

                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            <?php echo e(__('frontend.billing_integration_desc') ?? 'منصتنا متوافقة مع برامج الفوترة مثل Upmind، WHMCS، Blesta، Hostbill وبرامج أخرى سهلة الاستخدام.'); ?>

                        </p>
                    </div>
                </div>
            </div>

            <!-- LVE Controls -->
            <div class="bg-gradient-to-br from-red-50 to-pink-50 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300" data-aos="fade-up" data-aos-delay="600">
                <div class="flex items-start mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-pink-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                    </div>
                    <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-5' : 'ml-5'); ?>">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">
                            <?php echo e(__('frontend.lve_controls') ?? 'ضوابط LVE'); ?>

                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            <?php echo e(__('frontend.lve_controls_desc') ?? 'كموزع، يمكنك تعيين حدود LVE الخاصة بك للباقات داخل حسابك. نحن نحدد الموارد لكل حساب cPanel، ولكن إذا كنت ترغب يمكنك تقليل هذه الحدود على أساس كل حساب، على سبيل المثال إذا كنت تريد بيع باقات أصغر وأكبر.'); ?>

                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Advanced Features Highlight -->
        <div class="mt-12 bg-gradient-to-r from-purple-600 via-pink-600 to-red-600 rounded-3xl p-8 md:p-12 text-white" data-aos="fade-up" data-aos-delay="700">
            <div class="text-center">
                <h3 class="text-2xl md:text-3xl font-bold mb-4">
                    <?php echo e(__('frontend.professional_platform') ?? 'منصة احترافية متكاملة'); ?>

                </h3>
                <p class="text-lg text-white/90 leading-relaxed mb-6 max-w-3xl mx-auto">
                    <?php echo e(__('frontend.professional_platform_desc') ?? 'كل ما تحتاجه لبناء عمل استضافة ناجح، من خوادم الأسماء المخصصة إلى تكامل الفوترة الكامل.'); ?>

                </p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-8">
                    <div class="text-center">
                        <div class="text-3xl font-bold mb-1">100%</div>
                        <div class="text-sm text-white/80"><?php echo e(__('frontend.white_label') ?? 'White Label'); ?></div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold mb-1"><?php echo e(__('frontend.global') ?? 'Global'); ?></div>
                        <div class="text-sm text-white/80"><?php echo e(__('frontend.anycast') ?? 'Anycast'); ?></div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold mb-1"><?php echo e(__('frontend.custom') ?? 'Custom'); ?></div>
                        <div class="text-sm text-white/80"><?php echo e(__('frontend.nameservers') ?? 'Nameservers'); ?></div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold mb-1"><?php echo e(__('frontend.easy') ?? 'Easy'); ?></div>
                        <div class="text-sm text-white/80"><?php echo e(__('frontend.integration') ?? 'Integration'); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Infrastructure & Technology Section -->
<section class="py-20 bg-gradient-to-br from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                <?php echo e(__('frontend.infrastructure_technology') ?? 'البنية التحتية والتكنولوجيا'); ?>

            </h2>
            <p class="text-lg text-gray-600 max-w-4xl mx-auto leading-relaxed">
                <?php echo e(__('frontend.infrastructure_technology_desc') ?? 'أحدث التقنيات والبنية التحتية القوية لضمان أداء استثنائي وأمان عالي لمواقعك ومواقع عملائك.'); ?>

            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- CloudLinux OS -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 border-blue-100 hover:border-blue-300" data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-start mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-5' : 'ml-5'); ?>">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">
                            <?php echo e(__('frontend.cloudlinux_os') ?? 'CloudLinux OS'); ?>

                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            <?php echo e(__('frontend.cloudlinux_os_desc') ?? 'CloudLinux هو تفرع من نظام التشغيل Linux الذي يضيف الأمان ويضع قيوداً على الموارد التي يمكن لأي مستخدم cPanel استخدامها. نحن لا نستخدمه للحد من قوتك - ولكن لحماية المواقع الأخرى في بيئة مشتركة من موقع آخر قد يكون ضاراً أو معطلاً.'); ?>

                        </p>
                    </div>
                </div>
            </div>

            <!-- NvME / SSD -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 border-purple-100 hover:border-purple-300" data-aos="fade-up" data-aos-delay="200">
                <div class="flex items-start mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-5' : 'ml-5'); ?>">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">
                            <?php echo e(__('frontend.nvme_ssd') ?? 'NvME / SSD'); ?>

                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            <?php echo e(__('frontend.nvme_ssd_desc') ?? 'نقدم NvME حيثما أمكن، وعلى الأقل محركات الأقراص ذات الحالة الصلبة. بسبب البنية التحتية السحابية التي تدعم حسابات الموزعين، يتم حل مشاكل الأجهزة بسهولة مع عدم حدوث أي انقطاع أو حد أدنى من الانقطاع.'); ?>

                        </p>
                    </div>
                </div>
            </div>

            <!-- Imunify360 -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 border-green-100 hover:border-green-300" data-aos="fade-up" data-aos-delay="300">
                <div class="flex items-start mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01"></path>
                        </svg>
                    </div>
                    <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-5' : 'ml-5'); ?>">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">
                            <?php echo e(__('frontend.imunify360') ?? 'Imunify360'); ?>

                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            <?php echo e(__('frontend.imunify360_desc') ?? 'يوفر Imunify360 أمان البرامج الضارة والحماية ضد العديد من تهديدات المواقع الشائعة. يمكنك استخدامه لفحص موقع وتنظيف الملفات المصابة.'); ?>

                        </p>
                    </div>
                </div>
            </div>

            <!-- Offsite Backups -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 border-orange-100 hover:border-orange-300" data-aos="fade-up" data-aos-delay="400">
                <div class="flex items-start mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-amber-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                    </div>
                    <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-5' : 'ml-5'); ?>">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">
                            <?php echo e(__('frontend.offsite_backups_title') ?? 'نسخ احتياطية خارجية'); ?>

                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            <?php echo e(__('frontend.offsite_backups_desc') ?? 'نأخذ نسختين احتياطيتين يومياً ونخزنهما لمدة 30 يوماً. يمكنك التصفح والتنزيل والاستعادة الذاتية للنسخ الاحتياطية من خلال واجهة Jetbackup في كل من WHM و cPanel.'); ?>

                        </p>
                    </div>
                </div>
            </div>

            <!-- Replicated Setup -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 border-indigo-100 hover:border-indigo-300" data-aos="fade-up" data-aos-delay="500">
                <div class="flex items-start mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                        </svg>
                    </div>
                    <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-5' : 'ml-5'); ?>">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">
                            <?php echo e(__('frontend.replicated_setup') ?? 'إعداد متماثل'); ?>

                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            <?php echo e(__('frontend.replicated_setup_desc') ?? 'يتم إنشاء كل حساب موزع وخادم نقوم بتوفيره بشكل متطابق. بمجرد أن يكون لديك موقع واحد معنا، فإنك تعلم أن بيئة الاستضافة لأي موقع آخر معنا ستكون متطابقة تماماً.'); ?>

                        </p>
                    </div>
                </div>
            </div>

            <!-- Infinitely Scalable -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 border-teal-100 hover:border-teal-300" data-aos="fade-up" data-aos-delay="600">
                <div class="flex items-start mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                        </svg>
                    </div>
                    <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-5' : 'ml-5'); ?>">
                        <h3 class="text-xl font-bold text-gray-900 mb-3">
                            <?php echo e(__('frontend.infinitely_scalable') ?? 'قابل للتوسع بلا حدود'); ?>

                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            <?php echo e(__('frontend.infinitely_scalable_desc') ?? 'يمكننا إضافة الموارد مثل قوة المعالجة الإضافية أو الذاكرة أو مساحة القرص SSD بسهولة. هذا يعني أننا لا نحتاج إلى تحديد أشياء مثل الباندويث أو التخزين، لأننا يمكننا الاستمرار في زيادة الحدود.'); ?>

                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Infrastructure Stats Banner -->
        <div class="mt-12 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 rounded-3xl p-8 md:p-12 text-white" data-aos="fade-up" data-aos-delay="700">
            <div class="text-center mb-8">
                <h3 class="text-2xl md:text-3xl font-bold mb-3">
                    <?php echo e(__('frontend.enterprise_infrastructure') ?? 'بنية تحتية على مستوى المؤسسات'); ?>

                </h3>
                <p class="text-lg text-white/90 max-w-3xl mx-auto">
                    <?php echo e(__('frontend.enterprise_infrastructure_desc') ?? 'تقنيات متقدمة وبنية تحتية قوية لضمان الأداء والأمان الأمثل.'); ?>

                </p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-4xl font-bold mb-2"><?php echo e(__('frontend.nvme') ?? 'NvME'); ?></div>
                    <div class="text-sm text-white/80"><?php echo e(__('frontend.ultra_fast_storage') ?? 'تخزين فائق السرعة'); ?></div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold mb-2">2x/Day</div>
                    <div class="text-sm text-white/80"><?php echo e(__('frontend.backups') ?? 'نسخ احتياطية'); ?></div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold mb-2">30 Days</div>
                    <div class="text-sm text-white/80"><?php echo e(__('frontend.retention') ?? 'الاحتفاظ'); ?></div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold mb-2">∞</div>
                    <div class="text-sm text-white/80"><?php echo e(__('frontend.scalable') ?? 'قابل للتوسع'); ?></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Email Features Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                <?php echo e(__('frontend.email_features') ?? 'مميزات البريد الإلكتروني'); ?>

            </h2>
            <p class="text-lg text-gray-600 max-w-4xl mx-auto leading-relaxed">
                <?php echo e(__('frontend.email_features_desc') ?? 'حلول بريد إلكتروني متقدمة لضمان وصول رسائلك بنجاح مع حماية كاملة من البريد المزعج.'); ?>

            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto">
            <!-- Outbound Filtering -->
            <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl p-10 shadow-xl hover:shadow-2xl transition-all duration-300" data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-start mb-6">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"></path>
                        </svg>
                    </div>
                    <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-6' : 'ml-6'); ?>">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">
                            <?php echo e(__('frontend.outbound_filtering') ?? 'تصفية البريد الصادر'); ?>

                        </h3>
                        <p class="text-gray-600 leading-relaxed mb-6">
                            <?php echo e(__('frontend.outbound_filtering_desc') ?? 'لا حاجة للمعاناة بسبب سمعة البريد السيئة. يتم توجيه جميع البريد الصادر الذي نرسله من خلال أحد شركائنا في تسليم البريد، MailChannels و SpamExperts. هذا يعني أننا يمكننا ضمان إمكانية تسليم بريدك دون أي مشاكل في القائمة السوداء.'); ?>

                        </p>
                        <div class="flex flex-wrap gap-3">
                            <div class="flex items-center bg-white px-4 py-2 rounded-lg shadow-sm">
                                <svg class="w-5 h-5 text-blue-600 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-700"><?php echo e(__('frontend.mailchannels') ?? 'MailChannels'); ?></span>
                            </div>
                            <div class="flex items-center bg-white px-4 py-2 rounded-lg shadow-sm">
                                <svg class="w-5 h-5 text-blue-600 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-700"><?php echo e(__('frontend.spamexperts') ?? 'SpamExperts'); ?></span>
                            </div>
                            <div class="flex items-center bg-white px-4 py-2 rounded-lg shadow-sm">
                                <svg class="w-5 h-5 text-blue-600 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-700"><?php echo e(__('frontend.no_blacklisting') ?? 'لا قوائم سوداء'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Generous Mailing Limits -->
            <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-10 shadow-xl hover:shadow-2xl transition-all duration-300" data-aos="fade-up" data-aos-delay="200">
                <div class="flex items-start mb-6">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-6' : 'ml-6'); ?>">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">
                            <?php echo e(__('frontend.generous_mailing_limits') ?? 'حدود بريدية سخية'); ?>

                        </h3>
                        <p class="text-gray-600 leading-relaxed mb-6">
                            <?php echo e(__('frontend.generous_mailing_limits_desc') ?? 'يمكنك إرسال 100 بريد إلكتروني في الساعة من كل حساب cPanel. يتم فحص كل رسالة، وأي رسائل مصنفة كبريد مزعج سيتم عزلها. يمكننا زيادة هذا الحد ضمن حدود معقولة أيضاً، على الرغم من أننا لا ندعم البريد الجماعي.'); ?>

                        </p>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between bg-white px-4 py-3 rounded-lg shadow-sm">
                                <span class="text-sm font-medium text-gray-700"><?php echo e(__('frontend.emails_per_hour') ?? 'رسائل في الساعة'); ?></span>
                                <span class="text-2xl font-bold text-purple-600">100</span>
                            </div>
                            <div class="flex items-center bg-white px-4 py-3 rounded-lg shadow-sm">
                                <svg class="w-5 h-5 text-purple-600 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-700"><?php echo e(__('frontend.spam_scanning') ?? 'فحص البريد المزعج'); ?></span>
                            </div>
                            <div class="flex items-center bg-white px-4 py-3 rounded-lg shadow-sm">
                                <svg class="w-5 h-5 text-purple-600 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-700"><?php echo e(__('frontend.increase_available') ?? 'زيادة متاحة عند الطلب'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Email Stats Banner -->
        <div class="mt-12 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 rounded-3xl p-8 md:p-12 text-white text-center" data-aos="fade-up" data-aos-delay="300">
            <h3 class="text-2xl md:text-3xl font-bold mb-3">
                <?php echo e(__('frontend.reliable_email_delivery') ?? 'تسليم بريد إلكتروني موثوق'); ?>

            </h3>
            <p class="text-lg text-white/90 mb-8 max-w-3xl mx-auto">
                <?php echo e(__('frontend.reliable_email_delivery_desc') ?? 'شراكات قوية مع أفضل مزودي خدمات البريد لضمان وصول رسائلك دائماً.'); ?>

            </p>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                    <div class="text-4xl font-bold mb-2">100/h</div>
                    <div class="text-sm text-white/80"><?php echo e(__('frontend.per_account') ?? 'لكل حساب'); ?></div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                    <div class="text-4xl font-bold mb-2">100%</div>
                    <div class="text-sm text-white/80"><?php echo e(__('frontend.spam_protected') ?? 'محمي من السبام'); ?></div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20 md:col-span-1 col-span-2">
                    <div class="text-4xl font-bold mb-2">0</div>
                    <div class="text-sm text-white/80"><?php echo e(__('frontend.blacklist_issues') ?? 'مشاكل القوائم السوداء'); ?></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Client Management & Billing Section -->
<section class="py-20 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <!-- Content -->
            <div data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                    <?php echo e(__('frontend.manage_clients_billing') ?? 'إدارة عملائك، الفواتير ودعم العملاء'); ?>

                </h2>
                <p class="text-lg text-gray-700 mb-6 leading-relaxed">
                    <?php echo e(__('frontend.upmind_integration_intro') ?? 'تعمل استضافة الموزعين من Pro Gineous بشكل مثالي مع برنامج إدارة العملاء والفواتير Upmind.'); ?>

                </p>
                <p class="text-gray-600 mb-6 leading-relaxed">
                    <?php echo e(__('frontend.upmind_automation_desc') ?? 'يمكن إنشاء حسابات cPanel لعملائك تلقائياً، وتعليقها، وترقيتها والمزيد مع نظام التكامل العميق الكامل هذا. يمكنك حتى إقران حسابات موزعين متعددة من Pro Gineous!'); ?>

                </p>
                <p class="text-gray-600 mb-8 leading-relaxed">
                    <?php echo e(__('frontend.upmind_setup_desc') ?? 'ببساطة أدخل بيانات اعتماد الموزع الخاصة بك في لوحة Upmind الخاصة بك لبدء أتمتة طلبات عملائك، والمدفوعات ومعالجة الدعم.'); ?>

                </p>

                <!-- Features List -->
                <div class="space-y-4 mb-8">
                    <div class="flex items-start">
                        <div class="w-6 h-6 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <p class="text-gray-700 <?php echo e(app()->getLocale() == 'ar' ? 'mr-4' : 'ml-4'); ?>">
                            <?php echo e(__('frontend.auto_cpanel_creation') ?? 'إنشاء حسابات cPanel تلقائياً'); ?>

                        </p>
                    </div>
                    <div class="flex items-start">
                        <div class="w-6 h-6 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <p class="text-gray-700 <?php echo e(app()->getLocale() == 'ar' ? 'mr-4' : 'ml-4'); ?>">
                            <?php echo e(__('frontend.auto_suspend_upgrade') ?? 'تعليق وترقية تلقائية'); ?>

                        </p>
                    </div>
                    <div class="flex items-start">
                        <div class="w-6 h-6 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <p class="text-gray-700 <?php echo e(app()->getLocale() == 'ar' ? 'mr-4' : 'ml-4'); ?>">
                            <?php echo e(__('frontend.multiple_accounts_support') ?? 'دعم حسابات موزعين متعددة'); ?>

                        </p>
                    </div>
                    <div class="flex items-start">
                        <div class="w-6 h-6 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <p class="text-gray-700 <?php echo e(app()->getLocale() == 'ar' ? 'mr-4' : 'ml-4'); ?>">
                            <?php echo e(__('frontend.free_upmind') ?? 'استخدام Upmind مجاناً'); ?>

                        </p>
                    </div>
                </div>

                <!-- CTA Button -->
                <a href="#" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-indigo-700 transform hover:scale-105 transition-all duration-300 shadow-lg">
                    <?php echo e(__('frontend.read_upmind_guide') ?? 'اقرأ دليل Upmind'); ?>

                    <svg class="w-5 h-5 <?php echo e(app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e(app()->getLocale() == 'ar' ? 'M15 19l-7-7 7-7' : 'M9 5l7 7-7 7'); ?>"></path>
                    </svg>
                </a>
            </div>

            <!-- Image/Illustration -->
            <div class="relative" data-aos="fade-up" data-aos-delay="100">
                <div class="bg-gradient-to-br from-blue-100 to-indigo-100 rounded-3xl p-8 shadow-2xl">
                    <div class="bg-white rounded-2xl p-8 shadow-lg">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 <?php echo e(app()->getLocale() == 'ar' ? 'mr-4' : 'ml-4'); ?>"><?php echo e(__('frontend.upmind') ?? 'Upmind'); ?></h3>
                            </div>
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-sm font-semibold rounded-full">
                                <?php echo e(__('frontend.connected') ?? 'متصل'); ?>

                            </span>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                                <span class="text-gray-700"><?php echo e(__('frontend.active_clients') ?? 'عملاء نشطون'); ?></span>
                                <span class="text-2xl font-bold text-blue-600">247</span>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                                <span class="text-gray-700"><?php echo e(__('frontend.monthly_revenue') ?? 'إيرادات شهرية'); ?></span>
                                <span class="text-2xl font-bold text-green-600">$12,450</span>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                                <span class="text-gray-700"><?php echo e(__('frontend.auto_renewals') ?? 'تجديدات تلقائية'); ?></span>
                                <span class="text-2xl font-bold text-purple-600">89%</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Floating Badge -->
                <div class="absolute -top-4 -right-4 bg-white px-6 py-3 rounded-full shadow-xl border-4 border-blue-100">
                    <p class="text-sm font-bold text-blue-600"><?php echo e(__('frontend.free_to_use') ?? 'مجاني'); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Easy Migration Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <!-- Image/Illustration (Left Side) -->
            <div class="relative order-2 lg:order-1" data-aos="fade-up">
                <div class="bg-gradient-to-br from-green-50 to-teal-50 rounded-3xl p-8 shadow-2xl">
                    <div class="bg-white rounded-2xl p-8">
                        <!-- Migration Progress -->
                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-sm font-semibold text-gray-700"><?php echo e(__('frontend.migration_progress') ?? 'تقدم الانتقال'); ?></span>
                                <span class="text-sm font-bold text-green-600">85%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                                <div class="bg-gradient-to-r from-green-500 to-teal-500 h-3 rounded-full transition-all duration-500" style="width: 85%"></div>
                            </div>
                        </div>

                        <!-- Migration Steps -->
                        <div class="space-y-4">
                            <div class="flex items-center p-3 bg-green-50 rounded-lg border-2 border-green-200">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-700 <?php echo e(app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3'); ?>"><?php echo e(__('frontend.accounts_analyzed') ?? 'تحليل الحسابات'); ?></span>
                            </div>
                            <div class="flex items-center p-3 bg-green-50 rounded-lg border-2 border-green-200">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-700 <?php echo e(app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3'); ?>"><?php echo e(__('frontend.data_transfer') ?? 'نقل البيانات'); ?></span>
                            </div>
                            <div class="flex items-center p-3 bg-blue-50 rounded-lg border-2 border-blue-200 animate-pulse">
                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-white animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-700 <?php echo e(app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3'); ?>"><?php echo e(__('frontend.dns_configuration') ?? 'تكوين DNS'); ?></span>
                            </div>
                            <div class="flex items-center p-3 bg-gray-100 rounded-lg border-2 border-gray-200">
                                <div class="w-8 h-8 bg-gray-400 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-xs text-white font-bold">4</span>
                                </div>
                                <span class="text-sm text-gray-500 <?php echo e(app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3'); ?>"><?php echo e(__('frontend.final_verification') ?? 'التحقق النهائي'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Floating Badges -->
                <div class="absolute -top-4 -left-4 bg-white px-6 py-3 rounded-full shadow-xl border-4 border-green-100">
                    <p class="text-sm font-bold text-green-600"><?php echo e(__('frontend.free_migration') ?? 'انتقال مجاني'); ?></p>
                </div>
                <div class="absolute -bottom-4 -right-4 bg-white px-6 py-3 rounded-full shadow-xl border-4 border-teal-100">
                    <p class="text-sm font-bold text-teal-600"><?php echo e(__('frontend.expert_support') ?? 'دعم خبراء'); ?></p>
                </div>
            </div>

            <!-- Content (Right Side) -->
            <div class="order-1 lg:order-2" data-aos="fade-up" data-aos-delay="100">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                    <?php echo e(__('frontend.moving_easy') ?? 'الانتقال إلى Pro Gineous سهل!'); ?>

                </h2>
                <p class="text-lg text-gray-700 mb-6 leading-relaxed">
                    <?php echo e(__('frontend.migration_intro') ?? 'دعنا نقوم بترحيل مواقعك الإلكترونية وحسابات الاستضافة الموجودة إلى موزع Pro Gineous الخاص بك مجاناً.'); ?>

                </p>
                <p class="text-gray-600 mb-6 leading-relaxed">
                    <?php echo e(__('frontend.migration_details') ?? 'هل لديك حالياً حساب موزع في مكان آخر؟ أو ربما الكثير من حسابات cPanel الفردية؟ يمكن لفريق الهجرة الخبير لدينا نقل استضافتك الحالية إلى حساب الموزع الخاص بك في Pro Gineous.'); ?>

                </p>
                <p class="text-gray-600 mb-8 leading-relaxed">
                    <?php echo e(__('frontend.no_extra_charge') ?? 'لا توجد رسوم إضافية، ويمكنك طلب عمليات انتقال جديدة متى أردت.'); ?>

                </p>

                <!-- Benefits List -->
                <div class="grid md:grid-cols-2 gap-4 mb-8">
                    <div class="flex items-start p-4 bg-green-50 rounded-xl border border-green-200">
                        <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3'); ?>">
                            <h4 class="font-bold text-gray-900 mb-1"><?php echo e(__('frontend.completely_free') ?? 'مجاني تماماً'); ?></h4>
                            <p class="text-sm text-gray-600"><?php echo e(__('frontend.no_hidden_costs') ?? 'بدون تكاليف خفية'); ?></p>
                        </div>
                    </div>
                    <div class="flex items-start p-4 bg-green-50 rounded-xl border border-green-200">
                        <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3'); ?>">
                            <h4 class="font-bold text-gray-900 mb-1"><?php echo e(__('frontend.unlimited_requests') ?? 'طلبات غير محدودة'); ?></h4>
                            <p class="text-sm text-gray-600"><?php echo e(__('frontend.migrate_anytime') ?? 'انتقل متى تريد'); ?></p>
                        </div>
                    </div>
                    <div class="flex items-start p-4 bg-green-50 rounded-xl border border-green-200">
                        <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3'); ?>">
                            <h4 class="font-bold text-gray-900 mb-1"><?php echo e(__('frontend.expert_team') ?? 'فريق خبراء'); ?></h4>
                            <p class="text-sm text-gray-600"><?php echo e(__('frontend.professional_migration') ?? 'انتقال احترافي'); ?></p>
                        </div>
                    </div>
                    <div class="flex items-start p-4 bg-green-50 rounded-xl border border-green-200">
                        <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3'); ?>">
                            <h4 class="font-bold text-gray-900 mb-1"><?php echo e(__('frontend.minimal_downtime') ?? 'توقف أدنى'); ?></h4>
                            <p class="text-sm text-gray-600"><?php echo e(__('frontend.seamless_transfer') ?? 'نقل سلس'); ?></p>
                        </div>
                    </div>
                </div>

                <!-- CTA Button -->
                <a href="#" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-teal-600 text-white font-semibold rounded-xl hover:from-green-700 hover:to-teal-700 transform hover:scale-105 transition-all duration-300 shadow-lg">
                    <?php echo e(__('frontend.start_migration') ?? 'ابدأ الانتقال'); ?>

                    <svg class="w-5 h-5 <?php echo e(app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e(app()->getLocale() == 'ar' ? 'M15 19l-7-7 7-7' : 'M9 5l7 7-7 7'); ?>"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Global Datacentre Locations Section -->
<section class="py-20 bg-gradient-to-br from-slate-900 via-blue-900 to-indigo-900 relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="inline-flex items-center justify-center p-2 bg-blue-500/20 rounded-full mb-4">
                <span class="px-4 py-1 bg-blue-500 text-white text-sm font-semibold rounded-full">
                    <?php echo e(__('frontend.global_network') ?? 'شبكة عالمية'); ?>

                </span>
            </div>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-6">
                <?php echo e(__('frontend.datacenter_locations') ?? 'أكثر من 20 موقع عالمي لمراكز البيانات'); ?>

            </h2>
            <p class="text-lg text-blue-100 max-w-4xl mx-auto leading-relaxed">
                <?php echo e(__('frontend.datacenter_desc') ?? 'نقوم بالنشر على مزودي السحابة العالميين لنوفر لك أكثر من 20 موقعاً عالمياً متصلاً بشكل مذهل. سيتم إعداد حساب الموزع الجديد الخاص بك على الفور ويكون جاهزاً للاستخدام في أقل من دقيقة!'); ?>

            </p>
        </div>

        <!-- Datacenter Grid with Advanced Network Visualization -->
        <div class="relative overflow-hidden">
            <!-- Network Connection Lines SVG with Glow Effect -->
            <svg class="absolute inset-0 w-full h-full pointer-events-none" style="z-index: 0;">
                <defs>
                    <!-- Primary gradient for main connections -->
                    <linearGradient id="lineGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#60a5fa;stop-opacity:0.5" />
                        <stop offset="50%" style="stop-color:#818cf8;stop-opacity:0.6" />
                        <stop offset="100%" style="stop-color:#a78bfa;stop-opacity:0.5" />
                    </linearGradient>
                    
                    <!-- Accent gradient for special connections -->
                    <linearGradient id="accentGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" style="stop-color:#34d399;stop-opacity:0.4" />
                        <stop offset="100%" style="stop-color:#60a5fa;stop-opacity:0.4" />
                    </linearGradient>
                    
                    <!-- Glow filter for connections -->
                    <filter id="glow">
                        <feGaussianBlur stdDeviation="2" result="coloredBlur"/>
                        <feMerge>
                            <feMergeNode in="coloredBlur"/>
                            <feMergeNode in="SourceGraphic"/>
                        </feMerge>
                    </filter>
                </defs>
                
                <!-- Main network mesh lines -->
                <g stroke="url(#lineGradient)" stroke-width="1.5" fill="none" filter="url(#glow)">
                    <!-- Horizontal connections (all rows) -->
                    <line x1="10%" y1="10%" x2="30%" y2="15%" class="animate-pulse" style="animation-duration: 3s;"/>
                    <line x1="30%" y1="15%" x2="50%" y2="20%" class="animate-pulse" style="animation-duration: 3.5s;"/>
                    <line x1="50%" y1="20%" x2="70%" y2="15%" class="animate-pulse" style="animation-duration: 4s;"/>
                    <line x1="70%" y1="15%" x2="90%" y2="10%" class="animate-pulse" style="animation-duration: 3.2s;"/>
                    
                    <line x1="10%" y1="35%" x2="30%" y2="40%" class="animate-pulse" style="animation-duration: 3.8s;"/>
                    <line x1="30%" y1="40%" x2="50%" y2="35%" class="animate-pulse" style="animation-duration: 4.2s;"/>
                    <line x1="50%" y1="35%" x2="70%" y2="40%" class="animate-pulse" style="animation-duration: 3.6s;"/>
                    <line x1="70%" y1="40%" x2="90%" y2="35%" class="animate-pulse" style="animation-duration: 4.5s;"/>
                    
                    <line x1="10%" y1="60%" x2="30%" y2="65%" class="animate-pulse" style="animation-duration: 3.3s;"/>
                    <line x1="30%" y1="65%" x2="50%" y2="60%" class="animate-pulse" style="animation-duration: 4.1s;"/>
                    <line x1="50%" y1="60%" x2="70%" y2="65%" class="animate-pulse" style="animation-duration: 3.7s;"/>
                    <line x1="70%" y1="65%" x2="90%" y2="60%" class="animate-pulse" style="animation-duration: 3.9s;"/>
                    
                    <line x1="10%" y1="85%" x2="30%" y2="90%" class="animate-pulse" style="animation-duration: 4.3s;"/>
                    <line x1="30%" y1="90%" x2="50%" y2="85%" class="animate-pulse" style="animation-duration: 3.4s;"/>
                    <line x1="50%" y1="85%" x2="70%" y2="90%" class="animate-pulse" style="animation-duration: 4.4s;"/>
                    
                    <!-- Vertical connections (all columns) -->
                    <line x1="10%" y1="10%" x2="10%" y2="35%" class="animate-pulse" style="animation-duration: 3.5s;"/>
                    <line x1="10%" y1="35%" x2="10%" y2="60%" class="animate-pulse" style="animation-duration: 4s;"/>
                    <line x1="10%" y1="60%" x2="10%" y2="85%" class="animate-pulse" style="animation-duration: 3.7s;"/>
                    
                    <line x1="30%" y1="15%" x2="30%" y2="40%" class="animate-pulse" style="animation-duration: 3.8s;"/>
                    <line x1="30%" y1="40%" x2="30%" y2="65%" class="animate-pulse" style="animation-duration: 4.2s;"/>
                    <line x1="30%" y1="65%" x2="30%" y2="90%" class="animate-pulse" style="animation-duration: 3.4s;"/>
                    
                    <line x1="50%" y1="20%" x2="50%" y2="35%" class="animate-pulse" style="animation-duration: 3.6s;"/>
                    <line x1="50%" y1="35%" x2="50%" y2="60%" class="animate-pulse" style="animation-duration: 4.1s;"/>
                    <line x1="50%" y1="60%" x2="50%" y2="85%" class="animate-pulse" style="animation-duration: 4.5s;"/>
                    
                    <line x1="70%" y1="15%" x2="70%" y2="40%" class="animate-pulse" style="animation-duration: 3.9s;"/>
                    <line x1="70%" y1="40%" x2="70%" y2="65%" class="animate-pulse" style="animation-duration: 4.3s;"/>
                    <line x1="70%" y1="65%" x2="70%" y2="90%" class="animate-pulse" style="animation-duration: 3.6s;"/>
                    
                    <line x1="90%" y1="10%" x2="90%" y2="35%" class="animate-pulse" style="animation-duration: 3.7s;"/>
                    <line x1="90%" y1="35%" x2="90%" y2="60%" class="animate-pulse" style="animation-duration: 4.4s;"/>
                </g>
                
                <!-- Diagonal accent connections with different gradient -->
                <g stroke="url(#accentGradient)" stroke-width="1" opacity="0.7">
                    <!-- Major cross-connections -->
                    <line x1="10%" y1="10%" x2="90%" y2="60%" class="animate-pulse" style="animation-duration: 5s;"/>
                    <line x1="90%" y1="10%" x2="10%" y2="85%" class="animate-pulse" style="animation-duration: 5.5s;"/>
                    
                    <!-- Mid-range diagonals -->
                    <line x1="10%" y1="35%" x2="70%" y2="65%" class="animate-pulse" style="animation-duration: 4.8s;"/>
                    <line x1="90%" y1="35%" x2="30%" y2="65%" class="animate-pulse" style="animation-duration: 5.2s;"/>
                    <line x1="30%" y1="15%" x2="70%" y2="90%" class="animate-pulse" style="animation-duration: 4.9s;"/>
                    <line x1="70%" y1="15%" x2="10%" y2="60%" class="animate-pulse" style="animation-duration: 5.3s;"/>
                    
                    <!-- Additional mesh connections -->
                    <line x1="50%" y1="20%" x2="10%" y2="60%" class="animate-pulse" style="animation-duration: 4.6s;"/>
                    <line x1="50%" y1="35%" x2="90%" y2="85%" class="animate-pulse" style="animation-duration: 5.1s;"/>
                </g>
                
                <!-- Animated data flow dots -->
                <g fill="#60a5fa" opacity="0.6">
                    <circle cx="50%" cy="30%" r="2" class="animate-ping" style="animation-duration: 2s;"/>
                    <circle cx="30%" cy="50%" r="2" class="animate-ping" style="animation-duration: 2.5s;"/>
                    <circle cx="70%" cy="40%" r="2" class="animate-ping" style="animation-duration: 3s;"/>
                    <circle cx="40%" cy="70%" r="2" class="animate-ping" style="animation-duration: 2.8s;"/>
                </g>
            </svg>

            <!-- Datacenter Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 mb-12 relative" style="z-index: 1;">
            <!-- United States - New York -->
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 hover:bg-white/20 transition-all duration-300 transform hover:scale-105 border border-white/20" data-aos="fade-up" data-aos-delay="50">
                <div class="text-center mb-3"><span class="fi fi-us rounded-full inline-block" style="width: 3rem; height: 3rem; font-size: 3rem; line-height: 1;"></span></div>
                <h4 class="text-white font-bold text-center mb-1"><?php echo e(__('frontend.new_york') ?? 'New York'); ?></h4>
                <p class="text-blue-200 text-xs text-center"><?php echo e(__('frontend.usa') ?? 'USA'); ?></p>
            </div>

            <!-- United States - Los Angeles -->
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 hover:bg-white/20 transition-all duration-300 transform hover:scale-105 border border-white/20" data-aos="fade-up" data-aos-delay="100">
                <div class="text-center mb-3"><span class="fi fi-us" style="font-size: 3rem; line-height: 1;"></span></div>
                <h4 class="text-white font-bold text-center mb-1"><?php echo e(__('frontend.los_angeles') ?? 'Los Angeles'); ?></h4>
                <p class="text-blue-200 text-xs text-center"><?php echo e(__('frontend.usa') ?? 'USA'); ?></p>
            </div>

            <!-- United States - Chicago -->
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 hover:bg-white/20 transition-all duration-300 transform hover:scale-105 border border-white/20" data-aos="fade-up" data-aos-delay="150">
                <div class="text-center mb-3"><span class="fi fi-us" style="font-size: 3rem; line-height: 1;"></span></div>
                <h4 class="text-white font-bold text-center mb-1"><?php echo e(__('frontend.chicago') ?? 'Chicago'); ?></h4>
                <p class="text-blue-200 text-xs text-center"><?php echo e(__('frontend.usa') ?? 'USA'); ?></p>
            </div>

            <!-- United Kingdom - London -->
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 hover:bg-white/20 transition-all duration-300 transform hover:scale-105 border border-white/20" data-aos="fade-up" data-aos-delay="200">
                <div class="text-center mb-3"><span class="fi fi-gb" style="font-size: 3rem; line-height: 1;"></span></div>
                <h4 class="text-white font-bold text-center mb-1"><?php echo e(__('frontend.london') ?? 'London'); ?></h4>
                <p class="text-blue-200 text-xs text-center"><?php echo e(__('frontend.uk') ?? 'UK'); ?></p>
            </div>

            <!-- Netherlands - Amsterdam -->
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 hover:bg-white/20 transition-all duration-300 transform hover:scale-105 border border-white/20" data-aos="fade-up" data-aos-delay="250">
                <div class="text-center mb-3"><span class="fi fi-nl" style="font-size: 3rem; line-height: 1;"></span></div>
                <h4 class="text-white font-bold text-center mb-1"><?php echo e(__('frontend.amsterdam') ?? 'Amsterdam'); ?></h4>
                <p class="text-blue-200 text-xs text-center"><?php echo e(__('frontend.netherlands') ?? 'Netherlands'); ?></p>
            </div>

            <!-- Germany - Frankfurt -->
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 hover:bg-white/20 transition-all duration-300 transform hover:scale-105 border border-white/20" data-aos="fade-up" data-aos-delay="300">
                <div class="text-center mb-3"><span class="fi fi-de" style="font-size: 3rem; line-height: 1;"></span></div>
                <h4 class="text-white font-bold text-center mb-1"><?php echo e(__('frontend.frankfurt') ?? 'Frankfurt'); ?></h4>
                <p class="text-blue-200 text-xs text-center"><?php echo e(__('frontend.germany') ?? 'Germany'); ?></p>
            </div>

            <!-- France - Paris -->
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 hover:bg-white/20 transition-all duration-300 transform hover:scale-105 border border-white/20" data-aos="fade-up" data-aos-delay="350">
                <div class="text-center mb-3"><span class="fi fi-fr" style="font-size: 3rem; line-height: 1;"></span></div>
                <h4 class="text-white font-bold text-center mb-1"><?php echo e(__('frontend.paris') ?? 'Paris'); ?></h4>
                <p class="text-blue-200 text-xs text-center"><?php echo e(__('frontend.france') ?? 'France'); ?></p>
            </div>

            <!-- Canada - Toronto -->
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 hover:bg-white/20 transition-all duration-300 transform hover:scale-105 border border-white/20" data-aos="fade-up" data-aos-delay="400">
                <div class="text-center mb-3"><span class="fi fi-ca" style="font-size: 3rem; line-height: 1;"></span></div>
                <h4 class="text-white font-bold text-center mb-1"><?php echo e(__('frontend.toronto') ?? 'Toronto'); ?></h4>
                <p class="text-blue-200 text-xs text-center"><?php echo e(__('frontend.canada') ?? 'Canada'); ?></p>
            </div>

            <!-- Singapore -->
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 hover:bg-white/20 transition-all duration-300 transform hover:scale-105 border border-white/20" data-aos="fade-up" data-aos-delay="450">
                <div class="text-center mb-3"><span class="fi fi-sg" style="font-size: 3rem; line-height: 1;"></span></div>
                <h4 class="text-white font-bold text-center mb-1"><?php echo e(__('frontend.singapore_city') ?? 'Singapore'); ?></h4>
                <p class="text-blue-200 text-xs text-center"><?php echo e(__('frontend.singapore') ?? 'Singapore'); ?></p>
            </div>

            <!-- Japan - Tokyo -->
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 hover:bg-white/20 transition-all duration-300 transform hover:scale-105 border border-white/20" data-aos="fade-up" data-aos-delay="500">
                <div class="text-center mb-3"><span class="fi fi-jp" style="font-size: 3rem; line-height: 1;"></span></div>
                <h4 class="text-white font-bold text-center mb-1"><?php echo e(__('frontend.tokyo') ?? 'Tokyo'); ?></h4>
                <p class="text-blue-200 text-xs text-center"><?php echo e(__('frontend.japan') ?? 'Japan'); ?></p>
            </div>

            <!-- Australia - Sydney -->
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 hover:bg-white/20 transition-all duration-300 transform hover:scale-105 border border-white/20" data-aos="fade-up" data-aos-delay="550">
                <div class="text-center mb-3"><span class="fi fi-au" style="font-size: 3rem; line-height: 1;"></span></div>
                <h4 class="text-white font-bold text-center mb-1"><?php echo e(__('frontend.sydney') ?? 'Sydney'); ?></h4>
                <p class="text-blue-200 text-xs text-center"><?php echo e(__('frontend.australia') ?? 'Australia'); ?></p>
            </div>

            <!-- Australia - Melbourne -->
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 hover:bg-white/20 transition-all duration-300 transform hover:scale-105 border border-white/20" data-aos="fade-up" data-aos-delay="600">
                <div class="text-center mb-3"><span class="fi fi-au" style="font-size: 3rem; line-height: 1;"></span></div>
                <h4 class="text-white font-bold text-center mb-1"><?php echo e(__('frontend.melbourne') ?? 'Melbourne'); ?></h4>
                <p class="text-blue-200 text-xs text-center"><?php echo e(__('frontend.australia') ?? 'Australia'); ?></p>
            </div>

            <!-- India - Mumbai -->
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 hover:bg-white/20 transition-all duration-300 transform hover:scale-105 border border-white/20" data-aos="fade-up" data-aos-delay="650">
                <div class="text-center mb-3"><span class="fi fi-in" style="font-size: 3rem; line-height: 1;"></span></div>
                <h4 class="text-white font-bold text-center mb-1"><?php echo e(__('frontend.mumbai') ?? 'Mumbai'); ?></h4>
                <p class="text-blue-200 text-xs text-center"><?php echo e(__('frontend.india') ?? 'India'); ?></p>
            </div>

            <!-- India - Bangalore -->
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 hover:bg-white/20 transition-all duration-300 transform hover:scale-105 border border-white/20" data-aos="fade-up" data-aos-delay="700">
                <div class="text-center mb-3"><span class="fi fi-in" style="font-size: 3rem; line-height: 1;"></span></div>
                <h4 class="text-white font-bold text-center mb-1"><?php echo e(__('frontend.bangalore') ?? 'Bangalore'); ?></h4>
                <p class="text-blue-200 text-xs text-center"><?php echo e(__('frontend.india') ?? 'India'); ?></p>
            </div>

            <!-- Brazil - São Paulo -->
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 hover:bg-white/20 transition-all duration-300 transform hover:scale-105 border border-white/20" data-aos="fade-up" data-aos-delay="750">
                <div class="text-center mb-3"><span class="fi fi-br" style="font-size: 3rem; line-height: 1;"></span></div>
                <h4 class="text-white font-bold text-center mb-1"><?php echo e(__('frontend.sao_paulo') ?? 'São Paulo'); ?></h4>
                <p class="text-blue-200 text-xs text-center"><?php echo e(__('frontend.brazil') ?? 'Brazil'); ?></p>
            </div>

            <!-- South Korea - Seoul -->
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 hover:bg-white/20 transition-all duration-300 transform hover:scale-105 border border-white/20" data-aos="fade-up" data-aos-delay="800">
                <div class="text-center mb-3"><span class="fi fi-kr" style="font-size: 3rem; line-height: 1;"></span></div>
                <h4 class="text-white font-bold text-center mb-1"><?php echo e(__('frontend.seoul') ?? 'Seoul'); ?></h4>
                <p class="text-blue-200 text-xs text-center"><?php echo e(__('frontend.south_korea') ?? 'South Korea'); ?></p>
            </div>

            <!-- Spain - Madrid -->
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 hover:bg-white/20 transition-all duration-300 transform hover:scale-105 border border-white/20" data-aos="fade-up" data-aos-delay="850">
                <div class="text-center mb-3"><span class="fi fi-es" style="font-size: 3rem; line-height: 1;"></span></div>
                <h4 class="text-white font-bold text-center mb-1"><?php echo e(__('frontend.madrid') ?? 'Madrid'); ?></h4>
                <p class="text-blue-200 text-xs text-center"><?php echo e(__('frontend.spain') ?? 'Spain'); ?></p>
            </div>

            <!-- Italy - Milan -->
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 hover:bg-white/20 transition-all duration-300 transform hover:scale-105 border border-white/20" data-aos="fade-up" data-aos-delay="900">
                <div class="text-center mb-3"><span class="fi fi-it" style="font-size: 3rem; line-height: 1;"></span></div>
                <h4 class="text-white font-bold text-center mb-1"><?php echo e(__('frontend.milan') ?? 'Milan'); ?></h4>
                <p class="text-blue-200 text-xs text-center"><?php echo e(__('frontend.italy') ?? 'Italy'); ?></p>
            </div>

            <!-- Sweden - Stockholm -->
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 hover:bg-white/20 transition-all duration-300 transform hover:scale-105 border border-white/20" data-aos="fade-up" data-aos-delay="950">
                <div class="text-center mb-3"><span class="fi fi-se" style="font-size: 3rem; line-height: 1;"></span></div>
                <h4 class="text-white font-bold text-center mb-1"><?php echo e(__('frontend.stockholm') ?? 'Stockholm'); ?></h4>
                <p class="text-blue-200 text-xs text-center"><?php echo e(__('frontend.sweden') ?? 'Sweden'); ?></p>
            </div>

            <!-- Poland - Warsaw -->
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 hover:bg-white/20 transition-all duration-300 transform hover:scale-105 border border-white/20" data-aos="fade-up" data-aos-delay="1000">
                <div class="text-center mb-3"><span class="fi fi-pl" style="font-size: 3rem; line-height: 1;"></span></div>
                <h4 class="text-white font-bold text-center mb-1"><?php echo e(__('frontend.warsaw') ?? 'Warsaw'); ?></h4>
                <p class="text-blue-200 text-xs text-center"><?php echo e(__('frontend.poland') ?? 'Poland'); ?></p>
            </div>

            <!-- United Arab Emirates - Dubai -->
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 hover:bg-white/20 transition-all duration-300 transform hover:scale-105 border border-white/20" data-aos="fade-up" data-aos-delay="1050">
                <div class="text-center mb-3"><span class="fi fi-ae" style="font-size: 3rem; line-height: 1;"></span></div>
                <h4 class="text-white font-bold text-center mb-1"><?php echo e(__('frontend.dubai') ?? 'Dubai'); ?></h4>
                <p class="text-blue-200 text-xs text-center"><?php echo e(__('frontend.uae') ?? 'UAE'); ?></p>
            </div>

            <!-- South Africa - Johannesburg -->
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 hover:bg-white/20 transition-all duration-300 transform hover:scale-105 border border-white/20" data-aos="fade-up" data-aos-delay="1100">
                <div class="text-center mb-3"><span class="fi fi-za" style="font-size: 3rem; line-height: 1;"></span></div>
                <h4 class="text-white font-bold text-center mb-1"><?php echo e(__('frontend.johannesburg') ?? 'Johannesburg'); ?></h4>
                <p class="text-blue-200 text-xs text-center"><?php echo e(__('frontend.south_africa') ?? 'South Africa'); ?></p>
            </div>

            <!-- Egypt - Cairo -->
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 hover:bg-white/20 transition-all duration-300 transform hover:scale-105 border border-white/20" data-aos="fade-up" data-aos-delay="1150">
                <div class="text-center mb-3"><span class="fi fi-eg" style="font-size: 3rem; line-height: 1;"></span></div>
                <h4 class="text-white font-bold text-center mb-1"><?php echo e(__('frontend.cairo') ?? 'Cairo'); ?></h4>
                <p class="text-blue-200 text-xs text-center"><?php echo e(__('frontend.egypt') ?? 'Egypt'); ?></p>
            </div>

            <!-- Saudi Arabia - Riyadh -->
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 hover:bg-white/20 transition-all duration-300 transform hover:scale-105 border border-white/20" data-aos="fade-up" data-aos-delay="1200">
                <div class="text-center mb-3"><span class="fi fi-sa" style="font-size: 3rem; line-height: 1;"></span></div>
                <h4 class="text-white font-bold text-center mb-1"><?php echo e(__('frontend.riyadh') ?? 'Riyadh'); ?></h4>
                <p class="text-blue-200 text-xs text-center"><?php echo e(__('frontend.saudi_arabia') ?? 'Saudi Arabia'); ?></p>
            </div>
        </div>

        <!-- Stats Banner -->
        <div class="bg-gradient-to-r from-blue-500/20 via-indigo-500/20 to-purple-500/20 backdrop-blur-sm rounded-2xl p-8 border border-white/20" data-aos="fade-up" data-aos-delay="1250">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-4xl md:text-5xl font-bold text-white mb-2">24+</div>
                    <div class="text-blue-200 text-sm"><?php echo e(__('frontend.global_locations') ?? 'مواقع عالمية'); ?></div>
                </div>
                <div>
                    <div class="text-4xl md:text-5xl font-bold text-white mb-2">&lt;1min</div>
                    <div class="text-blue-200 text-sm"><?php echo e(__('frontend.instant_setup') ?? 'إعداد فوري'); ?></div>
                </div>
                <div>
                    <div class="text-4xl md:text-5xl font-bold text-white mb-2">99.9%</div>
                    <div class="text-blue-200 text-sm"><?php echo e(__('frontend.uptime_guarantee') ?? 'ضمان وقت التشغيل'); ?></div>
                </div>
                <div>
                    <div class="text-4xl md:text-5xl font-bold text-white mb-2">24/7</div>
                    <div class="text-blue-200 text-sm"><?php echo e(__('frontend.network_monitoring') ?? 'مراقبة الشبكة'); ?></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section with Tabs -->
<section class="py-20 bg-gradient-to-br from-gray-50 to-blue-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                <?php echo e(__('frontend.faq_title') ?? 'الأسئلة الشائعة حول استضافة الموزعين'); ?>

            </h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                <?php echo e(__('frontend.faq_desc') ?? 'إجابات شاملة على جميع أسئلتك حول خدمة استضافة الموزعين'); ?>

            </p>
        </div>

        <!-- Tabs Navigation -->
        <div class="mb-8" data-aos="fade-up" data-aos-delay="100" x-data="{ activeTab: 'reselling' }">
            <div class="flex flex-wrap justify-center gap-4 mb-12">
                <button @click="activeTab = 'reselling'" 
                        :class="activeTab === 'reselling' ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg' : 'bg-white text-gray-700 hover:bg-gray-100'"
                        class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105">
                    <?php echo e(__('frontend.tab_reselling') ?? 'الاستضافة'); ?>

                </button>
                <button @click="activeTab = 'migrations'" 
                        :class="activeTab === 'migrations' ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg' : 'bg-white text-gray-700 hover:bg-gray-100'"
                        class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105">
                    <?php echo e(__('frontend.tab_migrations') ?? 'الانتقال'); ?>

                </button>
                <button @click="activeTab = 'resources'" 
                        :class="activeTab === 'resources' ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg' : 'bg-white text-gray-700 hover:bg-gray-100'"
                        class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105">
                    <?php echo e(__('frontend.tab_resources') ?? 'الموارد'); ?>

                </button>
            </div>

            <!-- Reselling Tab Content -->
            <div x-show="activeTab === 'reselling'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                <div class="space-y-4">
                    <!-- Question 1 -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden" x-data="{ open: false }">
                        <button @click="open = !open" class="w-full px-6 py-5 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <span class="font-bold text-lg text-gray-900"><?php echo e(__('frontend.faq_how_signup') ?? 'كيف أقوم بالتسجيل؟'); ?></span>
                            <svg :class="open ? 'rotate-180' : ''" class="w-6 h-6 text-purple-600 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="px-6 pb-5">
                            <p class="text-gray-600 leading-relaxed">
                                <?php echo e(__('frontend.faq_how_signup_answer') ?? 'يمكنك طلب استضافة الموزعين من خلال نظام الطلب الخاص بنا بشكل طبيعي. بعد الطلب، ستتمكن من تقديم إما مرجع المؤسسة الخيرية الخاص بك أو تفاصيل عن مؤسستك غير الربحية. نقوم بمراجعة هذا ثم إعداد الحساب؛ لا ينبغي أن يستغرق الأمر أكثر من بضع دقائق.'); ?>

                            </p>
                        </div>
                    </div>

                    <!-- Question 2 -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden" x-data="{ open: false }">
                        <button @click="open = !open" class="w-full px-6 py-5 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <span class="font-bold text-lg text-gray-900"><?php echo e(__('frontend.faq_support') ?? 'هل يمكنني استخدام دعم Pro Gineous؟'); ?></span>
                            <svg :class="open ? 'rotate-180' : ''" class="w-6 h-6 text-purple-600 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="px-6 pb-5">
                            <p class="text-gray-600 leading-relaxed">
                                <?php echo e(__('frontend.faq_support_answer') ?? 'نعم، دعمنا الكامل 24/7 سعيد بالمساعدة. يمكننا أيضاً ترحيل موقعك من مزودي الخدمة الآخرين. نحن متاحون عبر الدردشة المباشرة والتذاكر والهاتف.'); ?>

                            </p>
                        </div>
                    </div>

                    <!-- Question 3 -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden" x-data="{ open: false }">
                        <button @click="open = !open" class="w-full px-6 py-5 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <span class="font-bold text-lg text-gray-900"><?php echo e(__('frontend.faq_technical_exp') ?? 'هل أحتاج إلى خبرة تقنية في تطوير المواقع أو إدارة الخوادم؟'); ?></span>
                            <svg :class="open ? 'rotate-180' : ''" class="w-6 h-6 text-purple-600 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="px-6 pb-5">
                            <p class="text-gray-600 leading-relaxed mb-4">
                                <?php echo e(__('frontend.faq_technical_exp_answer') ?? 'كل ما نبيعه مصمم بحيث لا تحتاج إلى أي خبرة أو معرفة تقنية مسبقة. من حيث إدارة الخادم، نحن نعتني بكل شيء. سواء كنت تأخذ أصغر خطة استضافة Go لدينا، أو إذا ذهبت للحصول على خادم مخصص، فإن الأنظمة مُدارة بالكامل.'); ?>

                            </p>
                            <p class="text-gray-600 leading-relaxed">
                                <?php echo e(__('frontend.faq_technical_exp_answer2') ?? 'نقدم أكثر من 300 تطبيق مختلف لبناء المواقع يمكنك تثبيتها تلقائياً لبناء موقع بنفسك. الأكثر شعبية إلى حد بعيد هو WordPress، الذي يشغل أكثر من 35٪ من المواقع على الإنترنت ويعمل بشكل مثالي على Pro Gineous.'); ?>

                            </p>
                        </div>
                    </div>

                    <!-- Question 4 -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden" x-data="{ open: false }">
                        <button @click="open = !open" class="w-full px-6 py-5 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <span class="font-bold text-lg text-gray-900"><?php echo e(__('frontend.faq_client_features') ?? 'هل ستحتوي لوحة تحكم عميلي على نفس الميزات التي لدي؟'); ?></span>
                            <svg :class="open ? 'rotate-180' : ''" class="w-6 h-6 text-purple-600 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="px-6 pb-5">
                            <p class="text-gray-600 leading-relaxed">
                                <?php echo e(__('frontend.faq_client_features_answer') ?? 'نعم، إلى حد ما. أنت فقط، الموزع لديك حق الوصول إلى لوحة الموزع الشاملة التي تسمح لك بالتحكم وإدارة جميع حسابات cPanel الخاصة بك. ثم لديك السيطرة على الميزات التي يمكن لكل حساب cPanel الوصول إليها، سواء بشكل فردي أو من خلال الباقات.'); ?>

                            </p>
                        </div>
                    </div>

                    <!-- Question 5 -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden" x-data="{ open: false }">
                        <button @click="open = !open" class="w-full px-6 py-5 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <span class="font-bold text-lg text-gray-900"><?php echo e(__('frontend.faq_manage_account') ?? 'كيف أقوم بإدارة حساب استضافة الموزع الخاص بي؟'); ?></span>
                            <svg :class="open ? 'rotate-180' : ''" class="w-6 h-6 text-purple-600 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="px-6 pb-5">
                            <p class="text-gray-600 leading-relaxed">
                                <?php echo e(__('frontend.faq_manage_account_answer') ?? 'يأتي حساب الموزع الخاص بك مع لوحتي تحكم، cPanel و WHM. WHM هو لوحة تحكم الموزع الخاصة بك وهنا حيث تقوم بإدارة جميع حسابات cPanel الفرعية لعملائك. من هنا يمكنك إنشاء حسابات إضافية، وإدارة الموارد والقيود، وإضافة ميزات إضافية وهكذا.'); ?>

                            </p>
                        </div>
                    </div>

                    <!-- Question 6 -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden" x-data="{ open: false }">
                        <button @click="open = !open" class="w-full px-6 py-5 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <span class="font-bold text-lg text-gray-900"><?php echo e(__('frontend.faq_activation_time') ?? 'كم من الوقت يستغرق تفعيل باقة استضافة الموزع الخاصة بي؟'); ?></span>
                            <svg :class="open ? 'rotate-180' : ''" class="w-6 h-6 text-purple-600 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="px-6 pb-5">
                            <p class="text-gray-600 leading-relaxed">
                                <?php echo e(__('frontend.faq_activation_time_answer') ?? 'بمجرد طلبك ودفعك لحساب استضافة الموزع الخاص بك، يجب أن تتلقى تفاصيل الترحيب الخاصة بك لتسجيل الدخول والبدء في غضون دقائق قليلة فقط. في حالات نادرة، قد نحتاج إلى الاتصال لمناقشة المزيد من التفاصيل معك إذا كان طلبك غير عادي قليلاً أو إذا كانت هناك أي معلومات مفقودة.'); ?>

                            </p>
                        </div>
                    </div>

                    <!-- Question 7 -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden" x-data="{ open: false }">
                        <button @click="open = !open" class="w-full px-6 py-5 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <span class="font-bold text-lg text-gray-900"><?php echo e(__('frontend.faq_what_is_reseller') ?? 'ما هي استضافة الموزعين وهل ستفيدني؟'); ?></span>
                            <svg :class="open ? 'rotate-180' : ''" class="w-6 h-6 text-purple-600 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="px-6 pb-5">
                            <p class="text-gray-600 leading-relaxed">
                                <?php echo e(__('frontend.faq_what_is_reseller_answer') ?? 'استضافة الموزعين هي خيار رائع لعدة حالات استخدام. الحالة الأولى والأكثر وضوحاً، هي للشخص أو الشركة التي تريد "إعادة بيع" مساحة الاستضافة - لذلك يتم منحك قدراً معيناً من الموارد والحسابات القصوى، ويمكنك تقسيم هذا وبيع مساحة الاستضافة لعملائك. مثالي لوكالات تصميم الويب أو تطوير الويب الذين يسعدون بإدارة مساحة الويب لعملائهم.'); ?>

                            </p>
                        </div>
                    </div>

                    <!-- Question 8 -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden" x-data="{ open: false }">
                        <button @click="open = !open" class="w-full px-6 py-5 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <span class="font-bold text-lg text-gray-900"><?php echo e(__('frontend.faq_payment_methods') ?? 'ما هي طرق الدفع التي تقبلونها؟'); ?></span>
                            <svg :class="open ? 'rotate-180' : ''" class="w-6 h-6 text-purple-600 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="px-6 pb-5">
                            <p class="text-gray-600 leading-relaxed">
                                <?php echo e(__('frontend.faq_payment_methods_answer') ?? 'نقبل بطاقات الائتمان أو الخصم، PayPal، التحويل البنكي، والخصم المباشر. يجب أن يتم الدفع الأول ببطاقة ائتمان أو خصم، PayPal أو التحويل البنكي.'); ?>

                            </p>
                        </div>
                    </div>

                    <!-- Question 9 -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden" x-data="{ open: false }">
                        <button @click="open = !open" class="w-full px-6 py-5 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <span class="font-bold text-lg text-gray-900"><?php echo e(__('frontend.faq_money_back') ?? 'هل تقدمون ضمان استعادة الأموال؟'); ?></span>
                            <svg :class="open ? 'rotate-180' : ''" class="w-6 h-6 text-purple-600 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="px-6 pb-5">
                            <p class="text-gray-600 leading-relaxed">
                                <?php echo e(__('frontend.faq_money_back_answer') ?? 'نعم، نفعل. تأتي خطط استضافة الويب واستضافة الموزعين لدينا مع ضمان استعادة الأموال لمدة 30 يوماً. يرجى ملاحظة أن الشروط تنطبق. يمكن لفرد واحد أو شركة أو مجموعة من الكيانات ذات الصلة استخدام ضمان استعادة الأموال مرة واحدة فقط.'); ?>

                            </p>
                        </div>
                    </div>

                    <!-- Question 10 -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden" x-data="{ open: false }">
                        <button @click="open = !open" class="w-full px-6 py-5 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <span class="font-bold text-lg text-gray-900"><?php echo e(__('frontend.faq_white_label') ?? 'هل استضافة Pro Gineous علامة بيضاء؟'); ?></span>
                            <svg :class="open ? 'rotate-180' : ''" class="w-6 h-6 text-purple-600 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="px-6 pb-5">
                            <p class="text-gray-600 leading-relaxed">
                                <?php echo e(__('frontend.faq_white_label_answer') ?? 'كل ما نقدمه للموزعين في Pro Gineous هو علامة بيضاء تماماً. هذا يعني أنه لا يوجد أي ذكر أو إشارة إلى Pro Gineous داخل لوحات التحكم الخاصة بك أو عملائك. نوفر أيضاً خوادم أسماء مخصصة للعلامة التجارية مجاناً - بحيث يمكنك الحصول على ns1.yourcompany.com و ns2.yourcompany.com لاستخدام عملائك.'); ?>

                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Migrations Tab Content -->
            <div x-show="activeTab === 'migrations'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                <div class="space-y-4">
                    <!-- Question 1 -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden" x-data="{ open: false }">
                        <button @click="open = !open" class="w-full px-6 py-5 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <span class="font-bold text-lg text-gray-900"><?php echo e(__('frontend.faq_can_migrate') ?? 'هل يمكن لـ Pro Gineous ترحيل مواقعي الحالية؟'); ?></span>
                            <svg :class="open ? 'rotate-180' : ''" class="w-6 h-6 text-purple-600 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="px-6 pb-5">
                            <p class="text-gray-600 leading-relaxed">
                                <?php echo e(__('frontend.faq_can_migrate_answer') ?? 'نعم. لدينا فريق مخصص للهجرة سينقل مواقعك من مزود الخدمة الحالي الخاص بك إلى Pro Gineous. سنحتاج إلى الوصول إلى مزود الاستضافة القديم الخاص بك. بمجرد تقديم طلب للاستضافة، يرجى فتح تذكرة هجرة في منطقة العميل الخاصة بنا.'); ?>

                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resources Tab Content -->
            <div x-show="activeTab === 'resources'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                <div class="space-y-4">
                    <!-- Question 1 -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden" x-data="{ open: false }">
                        <button @click="open = !open" class="w-full px-6 py-5 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <span class="font-bold text-lg text-gray-900"><?php echo e(__('frontend.faq_customize_resources') ?? 'هل يمكنني تخصيص استخدام الموارد، مثل إضافة مساحة قرص إضافية؟'); ?></span>
                            <svg :class="open ? 'rotate-180' : ''" class="w-6 h-6 text-purple-600 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="px-6 pb-5">
                            <p class="text-gray-600 leading-relaxed">
                                <?php echo e(__('frontend.faq_customize_resources_answer') ?? 'في خططنا غير المحدودة وغير المحدودة للموزعين، يمكنك اختيار عدد حسابات cPanel التي تريدها في حساب الموزع الخاص بك. إذا كنت على موزع Go الخاص بنا وتريد إضافة مساحة قرص إضافية، يجب عليك الترقية إلى موزع غير محدود 25. نحن لا نقدم باقات مخصصة بناءً على موزع Go.'); ?>

                            </p>
                        </div>
                    </div>

                    <!-- Question 2 -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden" x-data="{ open: false }">
                        <button @click="open = !open" class="w-full px-6 py-5 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <span class="font-bold text-lg text-gray-900"><?php echo e(__('frontend.faq_ssl_certificates') ?? 'هل يقدم Pro Gineous شهادات SSL؟'); ?></span>
                            <svg :class="open ? 'rotate-180' : ''" class="w-6 h-6 text-purple-600 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="px-6 pb-5">
                            <p class="text-gray-600 leading-relaxed">
                                <?php echo e(__('frontend.faq_ssl_certificates_answer') ?? 'سيتم توفير كل نطاق ونطاق فرعي يشير إلى خادم Pro Gineous تلقائياً بشهادة SSL تغطي الموقع. بمجرد أن يشير نطاق إلينا، يعمل التشغيل الآلي الخاص بنا في غضون ساعة ويعين شهادة SSL للموقع. لا يوجد شيء تحتاج إلى القيام به، العملية آلية بالكامل.'); ?>

                            </p>
                        </div>
                    </div>

                    <!-- Question 3 -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden" x-data="{ open: false }">
                        <button @click="open = !open" class="w-full px-6 py-5 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <span class="font-bold text-lg text-gray-900"><?php echo e(__('frontend.faq_backup_services') ?? 'هل يقدم Pro Gineous خدمات النسخ الاحتياطي؟'); ?></span>
                            <svg :class="open ? 'rotate-180' : ''" class="w-6 h-6 text-purple-600 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="px-6 pb-5">
                            <p class="text-gray-600 leading-relaxed">
                                <?php echo e(__('frontend.faq_backup_services_answer') ?? 'نعم، يقوم Pro Gineous بعمل نسخة احتياطية لجميع الملفات وقواعد البيانات تحت حسابك مرتين يومياً، ويخزنها لمدة 30 يوماً. لذلك في أي نقطة زمنية، هناك عدد كبير من نقاط الاستعادة للاختيار من بينها. هذه الخدمة مشمولة مجاناً في جميع باقات الاستضافة.'); ?>

                            </p>
                        </div>
                    </div>

                    <!-- Question 4 -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden" x-data="{ open: false }">
                        <button @click="open = !open" class="w-full px-6 py-5 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <span class="font-bold text-lg text-gray-900"><?php echo e(__('frontend.faq_emails_included') ?? 'كم عدد رسائل البريد الإلكتروني المضمنة؟'); ?></span>
                            <svg :class="open ? 'rotate-180' : ''" class="w-6 h-6 text-purple-600 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="px-6 pb-5">
                            <p class="text-gray-600 leading-relaxed">
                                <?php echo e(__('frontend.faq_emails_included_answer') ?? 'يمكنك إنشاء العديد من صناديق البريد كما تريد. يمكن تعيين حد الإرسال إلى 1000 بريد إلكتروني في الساعة لكل حساب cPanel. إذا كنت بحاجة إلى إرسال أكثر من هذا، فيرجى إخبارنا ويمكننا المراجعة ولكن ضع في اعتبارك أننا لسنا مزود بريد إلكتروني جماعي.'); ?>

                            </p>
                        </div>
                    </div>

                    <!-- Question 5 -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden" x-data="{ open: false }">
                        <button @click="open = !open" class="w-full px-6 py-5 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <span class="font-bold text-lg text-gray-900"><?php echo e(__('frontend.faq_php_versions') ?? 'ما هي إصدارات PHP التي يمكنني استخدامها؟'); ?></span>
                            <svg :class="open ? 'rotate-180' : ''" class="w-6 h-6 text-purple-600 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="px-6 pb-5">
                            <p class="text-gray-600 leading-relaxed">
                                <?php echo e(__('frontend.faq_php_versions_answer') ?? 'من خلال CloudLinux نوفر إصدارات PHP التاريخية المصححة، وأيضاً أحدث الإصدارات المستقرة. هذا يعني أنه يمكنك تشغيل كل شيء من PHP 5.2 إلى PHP 8. لتغيير إصدار PHP في حسابك، قم بتسجيل الدخول إلى cPanel وانقر على "إصدارات PHP" من هناك، يمكنك تحديد إصدار متاح من القائمة المنسدلة.'); ?>

                            </p>
                        </div>
                    </div>

                    <!-- Question 6 -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden" x-data="{ open: false }">
                        <button @click="open = !open" class="w-full px-6 py-5 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <span class="font-bold text-lg text-gray-900"><?php echo e(__('frontend.faq_upgrade_downgrade') ?? 'هل يمكنني ترقية أو تخفيض خطتي؟'); ?></span>
                            <svg :class="open ? 'rotate-180' : ''" class="w-6 h-6 text-purple-600 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="px-6 pb-5">
                            <p class="text-gray-600 leading-relaxed">
                                <?php echo e(__('frontend.faq_upgrade_downgrade_answer') ?? 'نعم. من السهل الترقية و / أو التخفيض. يرجى فقط إعلام فريق الدعم لدينا، أو طلب الترقية من خلال النظام. بالنسبة للترقيات، سنقوم بتحصيل تكلفة الترقية بالتناسب حتى نهاية مدة الفوترة الحالية. بالنسبة للتخفيضات، يمكننا تخفيضك في نهاية مدتك.'); ?>

                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 mx-4 sm:mx-6 lg:mx-8 mb-16">
    <div class="max-w-5xl mx-auto bg-gradient-to-r from-purple-600 to-pink-600 rounded-3xl p-12 lg:p-16 text-center shadow-xl" data-aos="fade-up">
        <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-6">
            <?php echo e(app()->getLocale() == 'ar' ? 'هل أنت مستعد لبدء عملك؟' : 'Ready to Start Your Business?'); ?>

        </h2>
        <p class="text-xl text-purple-100 mb-10 max-w-2xl mx-auto">
            <?php echo e(app()->getLocale() == 'ar' 
                ? 'انضم إلى مئات الشركاء الناجحين وابدأ في بيع خدمات الاستضافة باسمك التجاري اليوم' 
                : 'Join hundreds of successful partners and start selling hosting services under your brand today'); ?>

        </p>
        
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="#plans" class="inline-flex items-center px-8 py-4 bg-white text-purple-600 font-bold text-lg rounded-xl hover:bg-gray-50 transform hover:scale-105 transition-all duration-300 shadow-lg">
                <?php echo e(__('frontend.get_started') ?? 'ابدأ الآن'); ?>

                <svg class="w-5 h-5 <?php echo e(app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e(app()->getLocale() == 'ar' ? 'M15 19l-7-7 7-7' : 'M9 5l7 7-7 7'); ?>"></path>
                </svg>
            </a>
            
            <a href="<?php echo e(route('home')); ?>" class="inline-flex items-center px-8 py-4 bg-transparent text-white font-bold text-lg rounded-xl border-2 border-white hover:bg-white hover:text-purple-600 transition-all duration-300">
                <?php echo e(__('frontend.contact_us') ?? 'تواصل معنا'); ?>

            </a>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<!-- AOS Library JS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true,
        offset: 100
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('frontend.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\resources\views/frontend/hosting/reseller.blade.php ENDPATH**/ ?>