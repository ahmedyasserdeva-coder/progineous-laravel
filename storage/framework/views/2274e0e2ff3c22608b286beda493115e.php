

<?php $__env->startSection('title', __('frontend.shared_hosting') . ' - ' . __('frontend.best_shared_hosting_provider')); ?>

<?php $__env->startSection('meta_description', __('frontend.shared_hosting_meta_desc') ?? 'استضافة مشتركة بأفضل الأسعار مع مساحة تخزين غير محدودة، دومين مجاني، SSL مجاني، cPanel، وأداء عالي. ابدأ موقعك الآن مع Pro Gineous.'); ?>

<?php $__env->startSection('meta_keywords', __('frontend.shared_hosting_keywords') ?? 'استضافة مشتركة, استضافة مواقع, shared hosting, web hosting, استضافة رخيصة, دومين مجاني, SSL مجاني, cPanel, استضافة سريعة, استضافة آمنة, Pro Gineous'); ?>

<?php $__env->startPush('meta'); ?>
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo e(url()->current()); ?>">
    <meta property="og:title" content="<?php echo e(__('frontend.shared_hosting')); ?> - <?php echo e(__('frontend.best_shared_hosting_provider') ?? 'Pro Gineous'); ?>">
    <meta property="og:description" content="<?php echo e(__('frontend.shared_hosting_meta_desc') ?? 'استضافة مشتركة بأفضل الأسعار مع مساحة تخزين غير محدودة، دومين مجاني، SSL مجاني، وأداء عالي'); ?>">
    <meta property="og:image" content="<?php echo e(asset('assets/image.png')); ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="<?php echo e(__('frontend.shared_hosting')); ?> - Pro Gineous">
    <meta property="og:site_name" content="Pro Gineous">
    <meta property="og:locale" content="<?php echo e(app()->getLocale() == 'ar' ? 'ar_AR' : 'en_US'); ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo e(url()->current()); ?>">
    <meta property="twitter:title" content="<?php echo e(__('frontend.shared_hosting')); ?> - <?php echo e(__('frontend.best_shared_hosting_provider') ?? 'Pro Gineous'); ?>">
    <meta property="twitter:description" content="<?php echo e(__('frontend.shared_hosting_meta_desc') ?? 'استضافة مشتركة بأفضل الأسعار مع مساحة تخزين غير محدودة'); ?>">
    <meta property="twitter:image" content="<?php echo e(asset('assets/image.png')); ?>">
    <meta property="twitter:image:alt" content="<?php echo e(__('frontend.shared_hosting')); ?> - Pro Gineous">
    <meta name="twitter:site" content="@ProGineous">
    <meta name="twitter:creator" content="@ProGineous">

    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="<?php echo e(__('frontend.shared_hosting')); ?> - Pro Gineous">
    <meta itemprop="description" content="<?php echo e(__('frontend.shared_hosting_meta_desc') ?? 'استضافة مشتركة بأفضل الأسعار'); ?>">
    <meta itemprop="image" content="<?php echo e(asset('assets/image.png')); ?>">

    <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo e(url()->current()); ?>">

    <!-- Additional SEO Tags -->
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="author" content="Pro Gineous">
    <meta name="publisher" content="Pro Gineous">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('structured-data'); ?>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Product",
  "name": "<?php echo e(__('frontend.shared_hosting')); ?>",
  "description": "<?php echo e(__('frontend.shared_hosting_meta_desc') ?? 'استضافة مشتركة بأفضل الأسعار مع مساحة تخزين غير محدودة، دومين مجاني، SSL مجاني، cPanel، وأداء عالي'); ?>",
  "brand": {
    "@type": "Brand",
    "name": "Pro Gineous"
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "4.8",
    "reviewCount": "2847"
  }
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Service",
  "serviceType": "<?php echo e(__('frontend.shared_hosting')); ?>",
  "provider": {
    "@type": "Organization",
    "name": "Pro Gineous",
    "url": "<?php echo e(url('/')); ?>"
  },
  "areaServed": {
    "@type": "Country",
    "name": ["United States", "Saudi Arabia", "United Arab Emirates", "Egypt", "Jordan", "Kuwait", "Qatar", "Bahrain", "Oman"]
  }
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "<?php echo e(__('frontend.home')); ?>",
      "item": "<?php echo e(url('/')); ?>"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "<?php echo e(__('frontend.hosting')); ?>",
      "item": "<?php echo e(url('/hosting')); ?>"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "<?php echo e(__('frontend.shared_hosting')); ?>",
      "item": "<?php echo e(url()->current()); ?>"
    }
  ]
}
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<!-- Hero Section - Simplified -->
<section class="relative py-16 lg:py-24 bg-gradient-to-br from-slate-50 via-blue-50/30 to-cyan-50/20 dark:from-slate-900 dark:via-blue-950/30 dark:to-cyan-950/20 overflow-hidden">
    <!-- Decorative Background Elements -->
    <div class="absolute inset-0 pointer-events-none">
        <!-- Large gradient orb top right -->
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-400/20 dark:bg-blue-500/10 rounded-full blur-3xl"></div>
        <!-- Large gradient orb bottom left -->
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-cyan-400/20 dark:bg-cyan-500/10 rounded-full blur-3xl"></div>
    </div>

    <div class="container mx-auto px-4 lg:px-8 relative">
        <div class="max-w-4xl mx-auto">
            <div class="text-center">
                <!-- Trust Badge -->
                <div class="mb-6 inline-flex items-center gap-2 rounded-full bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm px-4 py-2 shadow-sm border border-blue-100 dark:border-blue-800/50">
                    <span class="text-sm font-semibold text-blue-600 dark:text-blue-400" dir="auto">
                        <?php echo e(__('frontend.trusted_by')); ?> <span class="text-gray-900 dark:text-white">50,000+</span> <?php echo e(__('frontend.customers')); ?>

                    </span>
                </div>

                <!-- Title -->
                <h1 class="text-4xl lg:text-6xl font-bold mb-4" dir="auto">
                    <span class="block text-gray-900 dark:text-white"><?php echo e(__('frontend.shared_hosting_hero_title')); ?></span>
                    <span class="block bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent"><?php echo e(__('frontend.shared_hosting_hero_highlight')); ?></span>
                </h1>
                
                <!-- Subtitle -->
                <p class="mt-6 text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto" dir="auto">
                    <?php echo e(__('frontend.shared_hosting_hero_subtitle')); ?>

                </p>

                <!-- CTA Button -->
                <div class="mt-8">
                    <a href="#plans" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white text-lg font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                        <span dir="auto"><?php echo e(__('frontend.start_now')); ?></span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                </div>

                <!-- Trust Indicators -->
                <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-full shadow-sm border border-green-100 dark:border-green-800/50">
                        <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300" dir="auto"><?php echo e(__('frontend.100_uptime')); ?></span>
                    </div>
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-full shadow-sm border border-green-100 dark:border-green-800/50">
                        <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300" dir="auto"><?php echo e(__('frontend.highest_performance')); ?></span>
                    </div>
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-full shadow-sm border border-green-100 dark:border-green-800/50">
                        <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300" dir="auto"><?php echo e(__('frontend.cpanel_control')); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pricing Plans Section -->
<section id="plans" class="py-16 lg:py-24 bg-white dark:bg-gray-900">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-4" dir="auto">
                    <?php echo e(__('frontend.choose_your_plan')); ?>

                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto" dir="auto">
                    <?php echo e(__('frontend.choose_plan_desc')); ?>

                </p>
            </div>

            <!-- Billing Period Dropdown -->
            <div class="flex justify-center mb-12">
                <div class="w-full sm:w-auto sm:min-w-[320px]">
                    <?php
                        $billingPeriods = [
                            'monthly' => ['label' => __('frontend.monthly'), 'discount' => null],
                            'quarterly' => ['label' => __('frontend.quarterly'), 'discount' => '5%'],
                            'semiannually' => ['label' => __('frontend.semi_annually'), 'discount' => '10%'],
                            'annually' => ['label' => __('frontend.annually'), 'discount' => '15%'],
                            'biennially' => ['label' => __('frontend.biennially'), 'discount' => '20%'],
                            'triennially' => ['label' => __('frontend.triennially'), 'discount' => '25%']
                        ];
                    ?>
                    
                    <div class="relative">
                        <label class="block text-center mb-3">
                            <span class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide" dir="auto">
                                <?php echo e(__('frontend.select_billing_period') ?? 'اختر فترة الدفع'); ?>

                            </span>
                        </label>
                        
                        <div class="relative">
                            <select 
                                id="billingPeriodSelect"
                                onchange="switchBillingPeriod(this.value)"
                                class="w-full appearance-none <?php echo e(app()->getLocale() == 'ar' ? 'text-right pr-5 pl-12' : 'text-left pl-5 pr-12'); ?> py-3.5 text-base font-semibold text-gray-900 dark:text-white bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-xl hover:border-blue-500 dark:hover:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all cursor-pointer shadow-sm"
                                dir="<?php echo e(app()->getLocale() == 'ar' ? 'rtl' : 'ltr'); ?>"
                            >
                                <?php $__currentLoopData = $billingPeriods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($period); ?>" <?php echo e($loop->first ? 'selected' : ''); ?>>
                                        <?php echo e($data['label']); ?>

                                        <?php if($data['discount']): ?>
                                            • <?php echo e(__('frontend.save_up_to')); ?> <?php echo e($data['discount']); ?>

                                        <?php endif; ?>
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            
                            <div class="absolute top-1/2 -translate-y-1/2 pointer-events-none <?php echo e(app()->getLocale() == 'ar' ? 'left-4' : 'right-4'); ?>">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pricing Cards Grid -->
            <?php if($plans->count() > 0): ?>
                <?php
                    $gridCols = $plans->count() >= 3 ? '3' : ($plans->count() == 2 ? '2' : '1');
                ?>
                <div class="grid grid-cols-1 md:grid-cols-<?php echo e($gridCols); ?> gap-8 items-start max-w-6xl mx-auto">
                    <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $isPopular = $index == 1 && $plans->count() >= 3;
                            
                            $currentLocale = app()->getLocale();
                            
                            if ($currentLocale === 'ar' && $plan->features_list_ar) {
                                $features = is_array($plan->features_list_ar) ? $plan->features_list_ar : array_filter(array_map('trim', explode("\n", $plan->features_list_ar)));
                            } elseif ($plan->features) {
                                $features = is_array($plan->features) ? $plan->features : (is_string($plan->features) ? json_decode($plan->features, true) : []);
                            } elseif ($plan->features_list) {
                                $features = is_array($plan->features_list) ? $plan->features_list : array_filter(array_map('trim', explode("\n", $plan->features_list)));
                            } else {
                                $features = [];
                            }
                            
                            $freeDomainConfig = is_array($plan->free_domain_config) ? $plan->free_domain_config : (is_string($plan->free_domain_config) ? json_decode($plan->free_domain_config, true) : null);
                        ?>
                        
                        <div id="plan-card-<?php echo e($plan->id); ?>" class="relative w-full <?php echo e($isPopular ? 'bg-gradient-to-br from-blue-600 to-blue-700 md:-mt-4 md:mb-4' : 'bg-white dark:bg-gray-800'); ?> rounded-2xl p-8 shadow-xl <?php echo e($isPopular ? '' : 'border-2 border-gray-200 dark:border-gray-700'); ?> hover:shadow-2xl transition-all">
                            <!-- Popular Badge -->
                            <?php if($isPopular): ?>
                                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                                    <span class="inline-block px-6 py-2 bg-white text-blue-600 font-bold text-sm rounded-full shadow-lg">
                                        <?php echo e(__('frontend.most_popular')); ?>

                                    </span>
                                </div>
                            <?php endif; ?>

                            <!-- Plan Header -->
                            <div class="text-center mb-6">
                                <h3 class="text-2xl font-bold <?php echo e($isPopular ? 'text-white' : 'text-gray-900 dark:text-white'); ?> mb-2" dir="auto">
                                    <?php echo e($plan->name); ?>

                                </h3>
                                
                                <?php if($plan->short_description): ?>
                                    <p class="text-sm <?php echo e($isPopular ? 'text-blue-100' : 'text-gray-600 dark:text-gray-400'); ?>" dir="auto">
                                        <?php echo e($plan->short_description); ?>

                                    </p>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Free Domain Badge -->
                            <?php if($freeDomainConfig && isset($freeDomainConfig['type']) && in_array($freeDomainConfig['type'], ['reg_transfer', 'first_year'])): ?>
                                <div class="mb-6">
                                    <div class="inline-flex items-center justify-center w-full gap-2 px-4 py-2.5 <?php echo e($isPopular ? 'bg-white/10 border-white/30' : 'bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/30 dark:to-cyan-900/30 border-blue-200 dark:border-blue-700'); ?> rounded-xl border">
                                        <svg class="w-4 h-4 <?php echo e($isPopular ? 'text-white' : 'text-blue-600 dark:text-blue-400'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <div class="flex-1 text-center">
                                            <span class="text-sm font-semibold <?php echo e($isPopular ? 'text-white' : 'text-gray-900 dark:text-white'); ?>" dir="auto">
                                                <?php echo e(__('frontend.free_domain')); ?>

                                            </span>
                                            <?php if(isset($freeDomainConfig['tlds']) && is_array($freeDomainConfig['tlds']) && count($freeDomainConfig['tlds']) > 0): ?>
                                                <span class="ml-2 text-xs <?php echo e($isPopular ? 'text-blue-100' : 'text-blue-600 dark:text-cyan-400'); ?>" dir="ltr">
                                                    (<?php $__currentLoopData = $freeDomainConfig['tlds']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $tld): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php echo e($index > 0 ? ', ' : ''); ?>.<?php echo e(strtolower($tld)); ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>)
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Price Display -->
                            <div class="pricing-display text-center mb-8" data-plan-id="<?php echo e($plan->id); ?>">
                                <div class="flex items-baseline justify-center gap-2">
                                    <span class="text-5xl font-black <?php echo e($isPopular ? 'text-white' : 'text-blue-600 dark:text-blue-400'); ?>">
                                        $<span class="price-amount"><?php echo e(number_format($plan->pricing['recurring']['monthly']['price'] ?? $plan->price ?? 0, 2)); ?></span>
                                    </span>
                                    <span class="text-lg <?php echo e($isPopular ? 'text-blue-100' : 'text-gray-600 dark:text-gray-400'); ?> price-period" dir="auto">
                                        /<?php echo e(__('frontend.month')); ?>

                                    </span>
                                </div>
                            </div>

                            <!-- Store prices in JavaScript -->
                            <script>
                                window.planPrices_<?php echo e($plan->id); ?> = {
                                    monthly: parseFloat(<?php echo e($plan->pricing['recurring']['monthly']['price'] ?? $plan->price ?? 0); ?>),
                                    quarterly: parseFloat(<?php echo e($plan->pricing['recurring']['quarterly']['price'] ?? (($plan->pricing['recurring']['monthly']['price'] ?? $plan->price ?? 0) * 3)); ?>),
                                    semiannually: parseFloat(<?php echo e($plan->pricing['recurring']['semi_annually']['price'] ?? (($plan->pricing['recurring']['monthly']['price'] ?? $plan->price ?? 0) * 6)); ?>),
                                    annually: parseFloat(<?php echo e($plan->pricing['recurring']['annually']['price'] ?? (($plan->pricing['recurring']['monthly']['price'] ?? $plan->price ?? 0) * 12)); ?>),
                                    biennially: parseFloat(<?php echo e($plan->pricing['recurring']['biennially']['price'] ?? (($plan->pricing['recurring']['monthly']['price'] ?? $plan->price ?? 0) * 24)); ?>),
                                    triennially: parseFloat(<?php echo e($plan->pricing['recurring']['triennially']['price'] ?? (($plan->pricing['recurring']['monthly']['price'] ?? $plan->price ?? 0) * 36)); ?>)
                                };
                                
                                window.datacenterPrices_<?php echo e($plan->id); ?> = {
                                    <?php if($plan->datacenter_price && is_array($plan->datacenter_price)): ?>
                                        <?php $__currentLoopData = $plan->datacenter_price; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location => $price): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            '<?php echo e($location); ?>': parseFloat(<?php echo e($price ?? 0); ?>),
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                };
                            </script>

                            <!-- Datacenter Location Selector -->
                            <?php if($plan->datacenter_locations && is_array($plan->datacenter_locations) && count($plan->datacenter_locations) > 0): ?>
                                <?php
                                    $datacenterInfo = [
                                        'us-east' => ['name_en' => 'USA - East Coast', 'name_ar' => 'الولايات المتحدة - الساحل الشرقي', 'flag' => '🇺🇸'],
                                        'us-west' => ['name_en' => 'USA - West Coast', 'name_ar' => 'الولايات المتحدة - الساحل الغربي', 'flag' => '🇺🇸'],
                                        'eu-west' => ['name_en' => 'Europe - West', 'name_ar' => 'أوروبا - الغرب', 'flag' => '🇪🇺'],
                                        'eu-central' => ['name_en' => 'Europe - Central', 'name_ar' => 'أوروبا - الوسط', 'flag' => '🇪🇺'],
                                        'asia-east' => ['name_en' => 'Asia - East', 'name_ar' => 'آسيا - الشرق', 'flag' => '🌏'],
                                        'asia-south' => ['name_en' => 'Asia - South', 'name_ar' => 'آسيا - الجنوب', 'flag' => '🌏'],
                                        'middle-east' => ['name_en' => 'Middle East', 'name_ar' => 'الشرق الأوسط', 'flag' => '🇦🇪'],
                                    ];
                                ?>
                                
                                <div class="mb-6">
                                    <label class="block text-center mb-2">
                                        <span class="text-xs font-semibold <?php echo e($isPopular ? 'text-white' : 'text-gray-600 dark:text-gray-400'); ?> uppercase" dir="auto">
                                            <?php echo e(__('frontend.select_datacenter') ?? 'اختر موقع مركز البيانات'); ?>

                                        </span>
                                    </label>
                                    
                                    <div class="relative">
                                        <select 
                                            id="datacenter_<?php echo e($plan->id); ?>"
                                            name="datacenter"
                                            onchange="updatePriceWithDatacenter(<?php echo e($plan->id); ?>)"
                                            class="w-full appearance-none <?php echo e(app()->getLocale() == 'ar' ? 'text-right pr-4 pl-10' : 'text-left pl-4 pr-10'); ?> py-3 text-sm font-semibold <?php echo e($isPopular ? 'bg-white/20 text-white border-white/30 backdrop-blur-sm' : 'bg-white dark:bg-gray-700 text-gray-900 dark:text-white border-gray-300 dark:border-gray-600'); ?> border-2 rounded-xl focus:outline-none transition-all cursor-pointer"
                                            dir="<?php echo e(app()->getLocale() == 'ar' ? 'rtl' : 'ltr'); ?>"
                                        >
                                            <?php $__currentLoopData = $plan->datacenter_locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if(isset($datacenterInfo[$location])): ?>
                                                    <option value="<?php echo e($location); ?>">
                                                        <?php echo e($datacenterInfo[$location]['flag']); ?> 
                                                        <?php echo e(app()->getLocale() == 'ar' ? $datacenterInfo[$location]['name_ar'] : $datacenterInfo[$location]['name_en']); ?>

                                                        <?php if(isset($plan->datacenter_price[$location]) && $plan->datacenter_price[$location] > 0): ?>
                                                            (+$<?php echo e($plan->datacenter_price[$location]); ?>/<?php echo e(__('frontend.month')); ?>)
                                                        <?php endif; ?>
                                                    </option>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        
                                        <div class="absolute top-1/2 -translate-y-1/2 pointer-events-none <?php echo e(app()->getLocale() == 'ar' ? 'left-3' : 'right-3'); ?>">
                                            <svg class="w-4 h-4 <?php echo e($isPopular ? 'text-white' : 'text-gray-500 dark:text-gray-400'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Features List -->
                            <ul class="space-y-4 mb-8" id="features-list-<?php echo e($plan->id); ?>">
                                <?php if(is_array($features) && count($features) > 0): ?>
                                    <?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $featureIndex => $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="flex items-start gap-3 <?php echo e($featureIndex >= 6 ? 'hidden feature-extra-' . $plan->id : ''); ?>" data-plan-id="<?php echo e($plan->id); ?>">
                                            <svg class="w-5 h-5 <?php echo e($isPopular ? 'text-white' : 'text-green-500'); ?> flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span class="text-base <?php echo e($isPopular ? 'text-white' : 'text-gray-700 dark:text-gray-300'); ?>" dir="auto">
                                                <?php echo e(is_array($feature) ? (app()->getLocale() == 'ar' ? ($feature['ar'] ?? $feature['en']) : ($feature['en'] ?? $feature['ar'])) : $feature); ?>

                                            </span>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </ul>

                            <!-- Show More Button -->
                            <?php if(is_array($features) && count($features) > 6): ?>
                                <div class="text-center mb-6">
                                    <button 
                                        onclick="toggleFeatures(<?php echo e($plan->id); ?>)" 
                                        id="toggle-btn-<?php echo e($plan->id); ?>"
                                        class="inline-flex items-center gap-2 px-4 py-2 <?php echo e($isPopular ? 'bg-white/20 hover:bg-white/30 text-white' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300'); ?> rounded-lg text-sm font-medium transition-all"
                                    >
                                        <span id="toggle-text-<?php echo e($plan->id); ?>"><?php echo e(__('frontend.show_more')); ?></span>
                                        <svg id="toggle-icon-<?php echo e($plan->id); ?>" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                </div>
                            <?php endif; ?>

                            <!-- CTA Button -->
                            <a href="<?php echo e(route('products.show', $plan->id)); ?>" class="block w-full text-center px-6 py-4 <?php echo e($isPopular ? 'bg-white text-blue-600 hover:bg-gray-50' : 'bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white'); ?> font-bold text-base rounded-xl shadow-lg hover:shadow-xl transition-all">
                                <?php echo e(__('frontend.get_started')); ?>

                            </a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="text-center py-12">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 dark:bg-gray-800 rounded-full mb-4">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2"><?php echo e(__('frontend.no_plans_available')); ?></h3>
                    <p class="text-gray-600 dark:text-gray-400"><?php echo e(__('frontend.no_plans_available_desc')); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Additional Benefits Section -->
<section class="py-16 sm:py-20 lg:py-24 bg-white dark:bg-gray-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 2xl:px-16">
        <div class="w-full max-w-6xl xl:max-w-5xl 2xl:max-w-4xl mx-auto">
        <div class="bg-gradient-to-br from-blue-50 to-purple-50 dark:from-gray-800 dark:to-gray-800 rounded-2xl md:rounded-3xl p-6 sm:p-8 md:p-10 lg:p-12 border border-blue-100 dark:border-gray-700">
            <!-- Header -->
            <div class="text-center mb-8 md:mb-10 lg:mb-12">
                <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-3 md:mb-4" dir="auto">
                    <?php echo e(__('frontend.make_more_online')); ?>

                </h2>
                <p class="text-base sm:text-lg md:text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto" dir="auto">
                    <?php echo e(__('frontend.fast_easy_hosting_desc')); ?>

                </p>
            </div>

            <!-- Benefits Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5 md:gap-6">
                <!-- Unlimited Bandwidth -->
                <div class="flex items-start gap-3 md:gap-4 p-4 md:p-5 bg-white dark:bg-gray-800/50 rounded-xl md:rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-all duration-300">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 md:w-12 md:h-12 aspect-square bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg md:rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-base md:text-lg font-bold text-gray-900 dark:text-white mb-1" dir="auto">
                            <?php echo e(__('frontend.unlimited_bandwidth')); ?>

                        </h3>
                        <p class="text-sm md:text-base text-gray-600 dark:text-gray-400" dir="auto">
                            <?php echo e(__('frontend.unmetered_traffic')); ?>

                        </p>
                    </div>
                </div>

                <!-- Free AI Website Builder -->
                <div class="flex items-start gap-3 md:gap-4 p-4 md:p-5 bg-white dark:bg-gray-800/50 rounded-xl md:rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-all duration-300">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 md:w-12 md:h-12 aspect-square bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg md:rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-base md:text-lg font-bold text-gray-900 dark:text-white mb-1" dir="auto">
                            <?php echo e(__('frontend.free_ai_website_builder')); ?>

                        </h3>
                        <p class="text-sm md:text-base text-gray-600 dark:text-gray-400" dir="auto">
                            <?php echo e(__('frontend.easy_management')); ?>

                        </p>
                    </div>
                </div>

                <!-- Domain Name & Privacy Protection -->
                <div class="flex items-start gap-3 md:gap-4 p-4 md:p-5 bg-white dark:bg-gray-800/50 rounded-xl md:rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-all duration-300">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 md:w-12 md:h-12 aspect-square bg-gradient-to-br from-green-500 to-green-600 rounded-lg md:rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-base md:text-lg font-bold text-gray-900 dark:text-white mb-1" dir="auto">
                            <?php echo e(__('frontend.domain_privacy_protection')); ?>

                        </h3>
                        <p class="text-sm md:text-base text-gray-600 dark:text-gray-400" dir="auto">
                            <?php echo e(__('frontend.data_protection')); ?>

                        </p>
                    </div>
                </div>

                <!-- Free Automatic SSL Installation -->
                <div class="flex items-start gap-3 md:gap-4 p-4 md:p-5 bg-white dark:bg-gray-800/50 rounded-xl md:rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-all duration-300">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 md:w-12 md:h-12 aspect-square bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg md:rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-base md:text-lg font-bold text-gray-900 dark:text-white mb-1" dir="auto">
                            <?php echo e(__('frontend.free_auto_ssl')); ?>

                        </h3>
                        <p class="text-sm md:text-base text-gray-600 dark:text-gray-400" dir="auto">
                            <?php echo e(__('frontend.secure_your_site')); ?>

                        </p>
                    </div>
                </div>

                <!-- Free CDN -->
                <div class="flex items-start gap-3 md:gap-4 p-4 md:p-5 bg-white dark:bg-gray-800/50 rounded-xl md:rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-all duration-300">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 md:w-12 md:h-12 aspect-square bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg md:rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-base md:text-lg font-bold text-gray-900 dark:text-white mb-1" dir="auto">
                            <?php echo e(__('frontend.free_cdn')); ?>

                        </h3>
                        <p class="text-sm md:text-base text-gray-600 dark:text-gray-400" dir="auto">
                            <?php echo e(__('frontend.true_stability')); ?>

                        </p>
                    </div>
                </div>

                <!-- Free Website Migration -->
                <div class="flex items-start gap-3 md:gap-4 p-4 md:p-5 bg-white dark:bg-gray-800/50 rounded-xl md:rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-all duration-300">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 md:w-12 md:h-12 aspect-square bg-gradient-to-br from-pink-500 to-pink-600 rounded-lg md:rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-base md:text-lg font-bold text-gray-900 dark:text-white mb-1" dir="auto">
                            <?php echo e(__('frontend.free_website_migration')); ?>

                        </h3>
                        <p class="text-sm md:text-base text-gray-600 dark:text-gray-400" dir="auto">
                            <?php echo e(__('frontend.move_site_hassle_free')); ?>

                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<!-- AI Website Builder & Security Section -->
<section class="py-16 sm:py-20 lg:py-24 bg-gray-50 dark:bg-gray-800">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 2xl:px-16">
        <div class="w-full max-w-6xl xl:max-w-5xl 2xl:max-w-4xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
            
            <!-- Left Side: AI Website Builder -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl md:rounded-3xl p-6 sm:p-8 md:p-10 border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300">
                <!-- Header -->
                <div class="mb-6 md:mb-8">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-purple-100 to-blue-100 dark:from-purple-900/30 dark:to-blue-900/30 rounded-full mb-4">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-sm font-bold text-purple-700 dark:text-purple-300">AI Website Builder</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3" dir="auto">
                        <?php echo e(__('frontend.ai_website_building')); ?>

                    </h2>
                </div>

                <!-- Features List -->
                <div class="space-y-6">
                    <!-- Feature 1 -->
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 mt-1">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2" dir="auto">
                                <?php echo e(__('frontend.create_website_needs')); ?>

                            </h3>
                            <p class="text-sm md:text-base text-gray-600 dark:text-gray-400" dir="auto">
                                <?php echo e(__('frontend.create_website_needs_desc')); ?>

                            </p>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 mt-1">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2" dir="auto">
                                <?php echo e(__('frontend.save_time_automation')); ?>

                            </h3>
                            <p class="text-sm md:text-base text-gray-600 dark:text-gray-400" dir="auto">
                                <?php echo e(__('frontend.save_time_automation_desc')); ?>

                            </p>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 mt-1">
                            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2" dir="auto">
                                <?php echo e(__('frontend.no_special_skills')); ?>

                            </h3>
                            <p class="text-sm md:text-base text-gray-600 dark:text-gray-400" dir="auto">
                                <?php echo e(__('frontend.no_special_skills_desc')); ?>

                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Security with Imunify360 -->
            <div class="bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-gray-900 dark:to-gray-900 rounded-2xl md:rounded-3xl p-6 sm:p-8 md:p-10 border border-emerald-200 dark:border-gray-700 hover:shadow-xl transition-all duration-300">
                <!-- Header -->
                <div class="mb-6 md:mb-8">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 rounded-full mb-4 shadow-sm">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <span class="text-sm font-bold text-emerald-700 dark:text-emerald-300">Imunify360</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-2" dir="auto">
                        <?php echo e(__('frontend.shared_hosting_security')); ?>

                    </h2>
                    <p class="text-sm font-semibold text-emerald-700 dark:text-emerald-400" dir="auto">
                        <?php echo e(__('frontend.included_business_plans')); ?>

                    </p>
                </div>

                <!-- Security Features -->
                <div class="space-y-6">
                    <!-- Feature 1 -->
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 mt-1">
                            <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2" dir="auto">
                                <?php echo e(__('frontend.realtime_protection')); ?>

                            </h3>
                            <p class="text-sm md:text-base text-gray-700 dark:text-gray-400" dir="auto">
                                <?php echo e(__('frontend.realtime_protection_desc')); ?>

                            </p>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 mt-1">
                            <div class="w-10 h-10 bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2" dir="auto">
                                <?php echo e(__('frontend.automatic_patching')); ?>

                            </h3>
                            <p class="text-sm md:text-base text-gray-700 dark:text-gray-400" dir="auto">
                                <?php echo e(__('frontend.automatic_patching_desc')); ?>

                            </p>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 mt-1">
                            <div class="w-10 h-10 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2" dir="auto">
                                <?php echo e(__('frontend.proactive_defence')); ?>

                            </h3>
                            <p class="text-sm md:text-base text-gray-700 dark:text-gray-400" dir="auto">
                                <?php echo e(__('frontend.proactive_defence_desc')); ?>

                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
</section>

<!-- Additional Premium Features Section -->
<section class="py-16 sm:py-20 lg:py-24 bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 2xl:px-16">
        <div class="w-full max-w-6xl xl:max-w-5xl 2xl:max-w-4xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            
            <!-- Feature 1: AutoBackup -->
            <div class="group bg-white dark:bg-gray-800 rounded-2xl p-6 md:p-8 border border-gray-200 dark:border-gray-700 hover:shadow-2xl hover:scale-105 transition-all duration-300">
                <div class="mb-6">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white mb-3" dir="auto">
                        <?php echo e(__('frontend.turnback_time_autobackup')); ?>

                    </h3>
                    <p class="text-base text-gray-600 dark:text-gray-400" dir="auto">
                        <?php echo e(__('frontend.turnback_time_autobackup_desc')); ?>

                    </p>
                </div>
            </div>

            <!-- Feature 2: AI Website Builder -->
            <div class="group bg-white dark:bg-gray-800 rounded-2xl p-6 md:p-8 border border-gray-200 dark:border-gray-700 hover:shadow-2xl hover:scale-105 transition-all duration-300">
                <div class="mb-6">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white mb-3" dir="auto">
                        <?php echo e(__('frontend.build_website_ai')); ?>

                    </h3>
                    <p class="text-base text-gray-600 dark:text-gray-400" dir="auto">
                        <?php echo e(__('frontend.build_website_ai_desc')); ?>

                    </p>
                </div>
            </div>

            <!-- Feature 3: Fast Content Delivery with DDoS -->
            <div class="group bg-white dark:bg-gray-800 rounded-2xl p-6 md:p-8 border border-gray-200 dark:border-gray-700 hover:shadow-2xl hover:scale-105 transition-all duration-300">
                <div class="mb-6">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white mb-3" dir="auto">
                        <?php echo e(__('frontend.deliver_content_fast')); ?>

                    </h3>
                    <p class="text-base text-gray-600 dark:text-gray-400" dir="auto">
                        <?php echo e(__('frontend.deliver_content_fast_desc')); ?>

                    </p>
                </div>
            </div>

            <!-- Feature 4: Free Cloud Storage EU -->
            <div class="group bg-white dark:bg-gray-800 rounded-2xl p-6 md:p-8 border border-gray-200 dark:border-gray-700 hover:shadow-2xl hover:scale-105 transition-all duration-300">
                <div class="mb-6">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white mb-3" dir="auto">
                        <?php echo e(__('frontend.free_cloud_storage_eu')); ?>

                    </h3>
                    <p class="text-base text-gray-600 dark:text-gray-400" dir="auto">
                        <?php echo e(__('frontend.free_cloud_storage_eu_desc')); ?>

                    </p>
                </div>
            </div>

            <!-- Feature 5: Sustainable EU Datacenter -->
            <div class="group bg-white dark:bg-gray-800 rounded-2xl p-6 md:p-8 border border-gray-200 dark:border-gray-700 hover:shadow-2xl hover:scale-105 transition-all duration-300 md:col-span-2 lg:col-span-1">
                <div class="mb-6">
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white mb-3" dir="auto">
                        <?php echo e(__('frontend.sustainable_eu_datacenter')); ?>

                    </h3>
                    <p class="text-base text-gray-600 dark:text-gray-400" dir="auto">
                        <?php echo e(__('frontend.sustainable_eu_datacenter_desc')); ?>

                    </p>
                </div>
            </div>

        </div>
    </div>
    </div>
</section>

<!-- Shared Hosting Features Section -->
<div class="py-16 sm:py-20 lg:py-24 bg-white dark:bg-gray-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 2xl:px-16">
        <div class="w-full max-w-6xl xl:max-w-5xl 2xl:max-w-4xl mx-auto">
        <!-- Section Title -->
        <div class="text-center mb-12 sm:mb-16">
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                <?php echo e(__('frontend.shared_hosting_features')); ?>

            </h2>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
            <!-- Feature 1: Free SSL Certificates -->
            <div class="group bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-750 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 hover:scale-105">
                <div class="flex items-start gap-6">
                    <!-- Icon -->
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="flex-1">
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-3">
                            <?php echo e(__('frontend.free_ssl_certificates')); ?>

                        </h3>
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                            <?php echo e(__('frontend.free_ssl_certificates_desc')); ?>

                        </p>
                    </div>
                </div>
            </div>

            <!-- Feature 2: 24/7 Live Support -->
            <div class="group bg-gradient-to-br from-green-50 to-emerald-50 dark:from-gray-800 dark:to-gray-750 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 hover:scale-105">
                <div class="flex items-start gap-6">
                    <!-- Icon -->
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="flex-1">
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-3">
                            <?php echo e(__('frontend.24_7_live_support')); ?>

                        </h3>
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                            <?php echo e(__('frontend.24_7_live_support_desc')); ?>

                        </p>
                    </div>
                </div>
            </div>

            <!-- Feature 3: WordPress and cPanel -->
            <div class="group bg-gradient-to-br from-purple-50 to-pink-50 dark:from-gray-800 dark:to-gray-750 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 hover:scale-105">
                <div class="flex items-start gap-6">
                    <!-- Icon -->
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="flex-1">
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-3">
                            <?php echo e(__('frontend.wordpress_and_cpanel')); ?>

                        </h3>
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                            <?php echo e(__('frontend.wordpress_and_cpanel_desc')); ?>

                        </p>
                    </div>
                </div>
            </div>

            <!-- Feature 4: Personalized Email Service -->
            <div class="group bg-gradient-to-br from-orange-50 to-red-50 dark:from-gray-800 dark:to-gray-750 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 hover:scale-105">
                <div class="flex items-start gap-6">
                    <!-- Icon -->
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="flex-1">
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-3">
                            <?php echo e(__('frontend.personalized_email_service')); ?>

                        </h3>
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                            <?php echo e(__('frontend.personalized_email_service_desc')); ?>

                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<!-- Pro Gineous Zero Downtime Section -->
<section class="py-16 sm:py-20 lg:py-24 bg-gradient-to-br from-indigo-50 via-blue-50 to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 overflow-hidden">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 2xl:px-16">
        <div class="w-full max-w-6xl xl:max-w-5xl 2xl:max-w-4xl mx-auto">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <div class="inline-flex items-center justify-center px-4 py-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-full mb-6">
                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                <span class="text-indigo-600 dark:text-indigo-400 font-semibold"><?php echo e(__('frontend.pro_gineous_technology')); ?></span>
            </div>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                <?php echo e(__('frontend.zero_downtime_hosting')); ?>

            </h2>
            <p class="text-lg sm:text-xl text-gray-600 dark:text-gray-300">
                <?php echo e(__('frontend.zero_downtime_subtitle')); ?>

            </p>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            <!-- Feature 1: Uptime Guarantee -->
            <div class="group relative bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 dark:border-gray-700 hover:border-indigo-200 dark:hover:border-indigo-700 hover:-translate-y-2">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-t-2xl"></div>
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-4">
                        <?php echo e(__('frontend.uptime_guarantee')); ?>

                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                        <?php echo e(__('frontend.uptime_guarantee_desc')); ?>

                    </p>
                </div>
            </div>

            <!-- Feature 2: Redundant Infrastructure -->
            <div class="group relative bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 dark:border-gray-700 hover:border-blue-200 dark:hover:border-blue-700 hover:-translate-y-2">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-t-2xl"></div>
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                        </svg>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-4">
                        <?php echo e(__('frontend.redundant_infrastructure')); ?>

                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                        <?php echo e(__('frontend.redundant_infrastructure_desc')); ?>

                    </p>
                </div>
            </div>

            <!-- Feature 3: Instant Failover -->
            <div class="group relative bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 dark:border-gray-700 hover:border-green-200 dark:hover:border-green-700 hover:-translate-y-2">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-green-500 to-emerald-500 rounded-t-2xl"></div>
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-4">
                        <?php echo e(__('frontend.instant_failover')); ?>

                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                        <?php echo e(__('frontend.instant_failover_desc')); ?>

                    </p>
                </div>
            </div>

            <!-- Feature 4: Load Balancing -->
            <div class="group relative bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 dark:border-gray-700 hover:border-orange-200 dark:hover:border-orange-700 hover:-translate-y-2">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-orange-500 to-red-500 rounded-t-2xl"></div>
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                        </svg>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-4">
                        <?php echo e(__('frontend.load_balancing')); ?>

                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                        <?php echo e(__('frontend.load_balancing_desc')); ?>

                    </p>
                </div>
            </div>

            <!-- Feature 5: Proactive Monitoring -->
            <div class="group relative bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 dark:border-gray-700 hover:border-purple-200 dark:hover:border-purple-700 hover:-translate-y-2">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-purple-500 to-pink-500 rounded-t-2xl"></div>
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-4">
                        <?php echo e(__('frontend.proactive_monitoring')); ?>

                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                        <?php echo e(__('frontend.proactive_monitoring_desc')); ?>

                    </p>
                </div>
            </div>

            <!-- Feature 6: Business Continuity -->
            <div class="group relative bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 dark:border-gray-700 hover:border-teal-200 dark:hover:border-teal-700 hover:-translate-y-2">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-teal-500 to-cyan-500 rounded-t-2xl"></div>
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-4">
                        <?php echo e(__('frontend.business_continuity')); ?>

                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                        <?php echo e(__('frontend.business_continuity_desc')); ?>

                    </p>
                </div>
            </div>
        </div>

        <!-- Bottom CTA -->
        <div class="mt-16 text-center">
            <div class="inline-flex items-center gap-3 px-6 py-3 bg-white dark:bg-gray-800 rounded-full shadow-lg">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="text-gray-700 dark:text-gray-300 font-semibold"><?php echo e(__('frontend.uptime_guarantee')); ?></span>
                </div>
                <span class="text-gray-400">•</span>
                <span class="text-indigo-600 dark:text-indigo-400 font-bold"><?php echo e(__('frontend.pro_gineous_powered')); ?></span>
            </div>
        </div>
    </div>
    </div>
</section>

<!-- Price Comparison Section -->
<section class="py-16 sm:py-20 lg:py-24 bg-white dark:bg-gray-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 2xl:px-16">
        <div class="w-full max-w-6xl xl:max-w-5xl 2xl:max-w-4xl mx-auto">
        <!-- Section Header -->
        <div class="text-center mb-12 sm:mb-16">
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                <?php echo e(__('frontend.price_comparison_title')); ?>

            </h2>
            <p class="text-lg sm:text-xl text-gray-600 dark:text-gray-300">
                <?php echo e(__('frontend.price_comparison_subtitle')); ?>

            </p>
        </div>

        <!-- Comparison Table - Desktop -->
        <div class="hidden lg:block mb-12">
            <div class="w-full">
                <div class="overflow-hidden shadow-xl rounded-2xl border border-gray-200 dark:border-gray-700">
                    <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-gray-800 dark:to-gray-750">
                            <tr>
                                <th scope="col" class="px-4 py-4 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                                    <?php echo e(__('frontend.hosting_provider')); ?>

                                </th>
                                <th scope="col" class="px-2 py-4 text-center text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                                    <?php echo e(__('frontend.starting_price')); ?>

                                </th>
                                <th scope="col" class="px-2 py-4 text-center text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                                    <?php echo e(__('frontend.renewal_price')); ?>

                                </th>
                                <th scope="col" class="px-2 py-4 text-center text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                                    <?php echo e(__('frontend.storage')); ?>

                                </th>
                                <th scope="col" class="px-2 py-4 text-center text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                                    <?php echo e(__('frontend.free_domain')); ?>

                                </th>
                                <th scope="col" class="px-2 py-4 text-center text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                                    <?php echo e(__('frontend.money_back_guarantee')); ?>

                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <!-- Pro Gineous Row (Highlighted) -->
                            <tr class="bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 border-2 border-indigo-500">
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center">
                                            <span class="text-white font-bold text-lg">P</span>
                                        </div>
                                        <div>
                                            <div class="text-lg font-bold text-gray-900 dark:text-white"><?php echo e(__('frontend.pro_gineous')); ?></div>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                <?php echo e(__('frontend.best_value')); ?>

                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">$10.00</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400"><?php echo e(__('frontend.per_month')); ?></div>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    <div class="text-xl font-semibold text-gray-900 dark:text-white">$10.00</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400"><?php echo e(__('frontend.per_month')); ?></div>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">70GB SSD</span>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    <svg class="w-6 h-6 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    <div class="text-lg font-bold text-gray-900 dark:text-white">30 <?php echo e(__('frontend.days')); ?></div>
                                </td>
                            </tr>

                            <!-- Namecheap -->
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-750">
                                <td class="px-3 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-shrink-0 w-10 h-10 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center">
                                            <span class="text-orange-600 dark:text-orange-400 font-bold text-lg">N</span>
                                        </div>
                                        <div class="text-base font-semibold text-gray-900 dark:text-white">Namecheap</div>
                                    </div>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    <div class="text-xl font-semibold text-gray-900 dark:text-white">$5.88</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400"><?php echo e(__('frontend.per_month')); ?></div>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    <div class="text-xl font-semibold text-gray-900 dark:text-white">$5.88</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400"><?php echo e(__('frontend.per_month')); ?></div>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">20GB</span>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    <svg class="w-6 h-6 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    <div class="text-base font-semibold text-gray-900 dark:text-white">30 <?php echo e(__('frontend.days')); ?></div>
                                </td>
                            </tr>

                            <!-- Hostinger -->
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-750">
                                <td class="px-3 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-shrink-0 w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                                            <span class="text-purple-600 dark:text-purple-400 font-bold text-lg">H</span>
                                        </div>
                                        <div class="text-base font-semibold text-gray-900 dark:text-white">Hostinger</div>
                                    </div>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    <div class="text-xl font-semibold text-gray-900 dark:text-white">$10.99</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400"><?php echo e(__('frontend.per_month')); ?></div>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    <div class="text-xl font-semibold text-gray-900 dark:text-white">$10.99</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400"><?php echo e(__('frontend.per_month')); ?></div>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">20GB</span>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    <svg class="w-6 h-6 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    <div class="text-base font-semibold text-gray-900 dark:text-white">30 <?php echo e(__('frontend.days')); ?></div>
                                </td>
                            </tr>

                            <!-- GoDaddy -->
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-750">
                                <td class="px-3 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-shrink-0 w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                                            <span class="text-green-600 dark:text-green-400 font-bold text-lg">G</span>
                                        </div>
                                        <div class="text-base font-semibold text-gray-900 dark:text-white">GoDaddy</div>
                                    </div>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    <div class="text-xl font-semibold text-gray-900 dark:text-white">$10.99</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400"><?php echo e(__('frontend.per_month')); ?></div>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    <div class="text-xl font-semibold text-gray-900 dark:text-white">$10.99</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400"><?php echo e(__('frontend.per_month')); ?></div>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">25GB</span>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    <svg class="w-6 h-6 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    <div class="text-base font-semibold text-gray-900 dark:text-white">30 <?php echo e(__('frontend.days')); ?></div>
                                </td>
                            </tr>

                            <!-- Bluehost -->
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-750">
                                <td class="px-3 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-shrink-0 w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                            <span class="text-blue-600 dark:text-blue-400 font-bold text-lg">B</span>
                                        </div>
                                        <div class="text-base font-semibold text-gray-900 dark:text-white">Bluehost</div>
                                    </div>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    <div class="text-xl font-semibold text-gray-900 dark:text-white">$9.99</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400"><?php echo e(__('frontend.per_month')); ?></div>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    <div class="text-xl font-semibold text-gray-900 dark:text-white">$9.99</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400"><?php echo e(__('frontend.per_month')); ?></div>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">10GB</span>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    <svg class="w-6 h-6 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    <div class="text-base font-semibold text-gray-900 dark:text-white">30 <?php echo e(__('frontend.days')); ?></div>
                                </td>
                            </tr>

                            <!-- DreamHost -->
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-750">
                                <td class="px-3 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-shrink-0 w-10 h-10 bg-teal-100 dark:bg-teal-900/30 rounded-lg flex items-center justify-center">
                                            <span class="text-teal-600 dark:text-teal-400 font-bold text-lg">D</span>
                                        </div>
                                        <div class="text-base font-semibold text-gray-900 dark:text-white">DreamHost</div>
                                    </div>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    <div class="text-xl font-semibold text-gray-900 dark:text-white">$6.99</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400"><?php echo e(__('frontend.per_month')); ?></div>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    <div class="text-xl font-semibold text-gray-900 dark:text-white">$10.99</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400"><?php echo e(__('frontend.per_month')); ?></div>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">25GB</span>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    <svg class="w-6 h-6 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    <div class="text-base font-semibold text-gray-900 dark:text-white">30 <?php echo e(__('frontend.days')); ?></div>
                                </td>
                            </tr>

                            <!-- SiteGround -->
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-750">
                                <td class="px-3 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-shrink-0 w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                                            <span class="text-red-600 dark:text-red-400 font-bold text-lg">S</span>
                                        </div>
                                        <div class="text-base font-semibold text-gray-900 dark:text-white">SiteGround</div>
                                    </div>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    <div class="text-xl font-semibold text-gray-900 dark:text-white">$17.99</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400"><?php echo e(__('frontend.per_month')); ?></div>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    <div class="text-xl font-semibold text-gray-900 dark:text-white">$17.99</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400"><?php echo e(__('frontend.per_month')); ?></div>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">10GB</span>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    <svg class="w-6 h-6 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </td>
                                <td class="px-2 py-3 whitespace-nowrap text-center">
                                    <div class="text-base font-semibold text-gray-900 dark:text-white">30 <?php echo e(__('frontend.days')); ?></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Price Disclaimer -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <?php echo e(__('frontend.price_comparison_note')); ?>

                    </p>
                </div>
            </div>
        </div>

        <!-- Comparison Cards - Mobile -->
        <div class="lg:hidden space-y-6 mb-12">
            <!-- Pro Gineous Card -->
            <div class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-2xl p-6 border-2 border-indigo-500 shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center">
                            <span class="text-white font-bold text-xl">P</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white"><?php echo e(__('frontend.pro_gineous')); ?></h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                <?php echo e(__('frontend.best_value')); ?>

                            </span>
                        </div>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400"><?php echo e(__('frontend.starting_price')); ?></span>
                        <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">$10.00<?php echo e(__('frontend.per_month')); ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400"><?php echo e(__('frontend.renewal_price')); ?></span>
                        <span class="text-lg font-semibold text-gray-900 dark:text-white">$10.00<?php echo e(__('frontend.per_month')); ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400"><?php echo e(__('frontend.storage')); ?></span>
                        <span class="font-semibold text-gray-900 dark:text-white">70GB SSD</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400"><?php echo e(__('frontend.free_domain')); ?></span>
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400"><?php echo e(__('frontend.money_back_guarantee')); ?></span>
                        <span class="font-bold text-gray-900 dark:text-white">30 <?php echo e(__('frontend.days')); ?></span>
                    </div>
                </div>
            </div>

            <!-- Other Providers - Simplified -->
            <?php
                $competitors = [
                    ['name' => 'Namecheap', 'color' => 'orange', 'start' => '$5.88', 'renewal' => '$5.88', 'storage' => '20GB', 'domain' => true],
                    ['name' => 'Hostinger', 'color' => 'purple', 'start' => '$10.99', 'renewal' => '$10.99', 'storage' => '20GB', 'domain' => true],
                    ['name' => 'GoDaddy', 'color' => 'green', 'start' => '$10.99', 'renewal' => '$10.99', 'storage' => '25GB', 'domain' => true],
                    ['name' => 'Bluehost', 'color' => 'blue', 'start' => '$9.99', 'renewal' => '$9.99', 'storage' => '10GB', 'domain' => true],
                    ['name' => 'DreamHost', 'color' => 'teal', 'start' => '$10.99', 'renewal' => '$10.99', 'storage' => '25GB', 'domain' => true],
                    ['name' => 'SiteGround', 'color' => 'red', 'start' => '$17.99', 'renewal' => '$17.99', 'storage' => '10GB', 'domain' => false],
                ];
            ?>

            <?php $__currentLoopData = $competitors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-<?php echo e($provider['color']); ?>-100 dark:bg-<?php echo e($provider['color']); ?>-900/30 rounded-lg flex items-center justify-center">
                        <span class="text-<?php echo e($provider['color']); ?>-600 dark:text-<?php echo e($provider['color']); ?>-400 font-bold"><?php echo e(substr($provider['name'], 0, 1)); ?></span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white"><?php echo e($provider['name']); ?></h3>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400"><?php echo e(__('frontend.starting_price')); ?></span>
                        <span class="font-semibold text-gray-900 dark:text-white"><?php echo e($provider['start']); ?><?php echo e(__('frontend.per_month')); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400"><?php echo e(__('frontend.renewal_price')); ?></span>
                        <span class="font-semibold text-gray-900 dark:text-white"><?php echo e($provider['renewal']); ?><?php echo e(__('frontend.per_month')); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400"><?php echo e(__('frontend.storage')); ?></span>
                        <span class="font-semibold text-gray-900 dark:text-white"><?php echo e($provider['storage']); ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        <!-- Price Disclaimer for Mobile -->
        <div class="lg:hidden mt-6 text-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <?php echo e(__('frontend.price_comparison_note')); ?>

            </p>
        </div>
    </div>
    </div>
</section>

<!-- Plans Comparison Section - New Professional Design -->
<section class="py-16 sm:py-20 lg:py-24 bg-gradient-to-br from-gray-50 via-white to-gray-100 dark:from-gray-900 dark:via-gray-850 dark:to-gray-800">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 2xl:px-16">
        <div class="w-full max-w-7xl xl:max-w-6xl 2xl:max-w-5xl mx-auto">
        <!-- Section Header -->
        <div class="text-center mb-12 sm:mb-16">
            <div class="inline-flex items-center justify-center px-4 py-2 mb-4 text-sm font-semibold text-indigo-600 bg-indigo-100 dark:bg-indigo-900/30 dark:text-indigo-400 rounded-full">
                <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                <?php echo e(__('frontend.compare_our_plans')); ?>

            </div>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-gray-900 dark:text-white mb-4">
                <?php echo e(__('frontend.choose_perfect_plan')); ?>

            </h2>
            <p class="text-lg sm:text-xl text-gray-600 dark:text-gray-300">
                <?php echo e(__('frontend.compare_our_plans_subtitle')); ?>

            </p>
        </div>

        <!-- Pricing Cards Header - Desktop & Mobile -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12 max-w-5xl mx-auto">
            <!-- Startup Plan -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-xl border-2 border-gray-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Startup</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4"><?php echo e(__('frontend.best_for_beginners')); ?></p>
                <div class="mb-6">
                    <span class="text-5xl font-extrabold text-indigo-600 dark:text-indigo-400">$10</span>
                    <span class="text-xl text-gray-600 dark:text-gray-400">/<?php echo e(__('frontend.month')); ?></span>
                </div>
                <a href="<?php echo e(route('register')); ?>?plan=startup" class="block w-full text-center px-6 py-3 text-base font-semibold text-white bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                    <?php echo e(__('frontend.choose_plan')); ?>

                </a>
            </div>

            <!-- Essential Plan - Popular -->
            <div class="bg-gradient-to-br from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 rounded-2xl p-8 shadow-2xl border-2 border-yellow-500 hover:shadow-3xl transition-all duration-300 transform scale-105">
                <div class="text-center mb-4">
                    <span class="inline-flex items-center px-4 py-1 rounded-full text-sm font-bold bg-gradient-to-r from-yellow-500 to-orange-500 text-white shadow-lg">
                        🔥 <?php echo e(__('frontend.most_popular')); ?>

                    </span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Essential</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4"><?php echo e(__('frontend.best_for_business')); ?></p>
                <div class="mb-6">
                    <span class="text-5xl font-extrabold text-yellow-600 dark:text-yellow-400">$13</span>
                    <span class="text-xl text-gray-600 dark:text-gray-400">/<?php echo e(__('frontend.month')); ?></span>
                </div>
                <a href="<?php echo e(route('register')); ?>?plan=essential" class="block w-full text-center px-6 py-3 text-base font-semibold text-white bg-gradient-to-r from-yellow-500 to-orange-500 rounded-xl hover:from-yellow-600 hover:to-orange-600 transition-all duration-200 shadow-lg hover:shadow-xl">
                    <?php echo e(__('frontend.choose_plan')); ?>

                </a>
            </div>

            <!-- Ultimate Plan -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-xl border-2 border-gray-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Ultimate</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4"><?php echo e(__('frontend.best_for_enterprises')); ?></p>
                <div class="mb-6">
                    <span class="text-5xl font-extrabold text-indigo-600 dark:text-indigo-400">$19</span>
                    <span class="text-xl text-gray-600 dark:text-gray-400">/<?php echo e(__('frontend.month')); ?></span>
                </div>
                <a href="<?php echo e(route('register')); ?>?plan=ultimate" class="block w-full text-center px-6 py-3 text-base font-semibold text-white bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                    <?php echo e(__('frontend.choose_plan')); ?>

                </a>
            </div>
        </div>

        <!-- Features Comparison Table - Desktop Only -->
        <div class="hidden lg:block max-w-5xl mx-auto">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-700">
                
                <!-- Resources Section -->
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                        <h4 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 <?php echo e(app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                            </svg>
                            <?php echo e(__('frontend.resources_performance')); ?>

                        </h4>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        <div class="grid grid-cols-4 gap-4 px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-750">
                            <div class="font-semibold text-gray-900 dark:text-white"><?php echo e(__('frontend.storage_space')); ?></div>
                            <div class="text-center text-gray-900 dark:text-white font-medium">70 GB SSD</div>
                            <div class="text-center bg-yellow-50 dark:bg-yellow-900/10 -mx-4 px-4 py-2 text-gray-900 dark:text-white font-medium">150 GB SSD</div>
                            <div class="text-center text-gray-900 dark:text-white font-medium">250 GB SSD</div>
                        </div>
                        <div class="grid grid-cols-4 gap-4 px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-750">
                            <div class="font-semibold text-gray-900 dark:text-white"><?php echo e(__('frontend.ram_memory')); ?></div>
                            <div class="text-center text-gray-900 dark:text-white font-medium">1.5 GB DDR4</div>
                            <div class="text-center bg-yellow-50 dark:bg-yellow-900/10 -mx-4 px-4 py-2 text-gray-900 dark:text-white font-medium">2 GB DDR4</div>
                            <div class="text-center text-gray-900 dark:text-white font-medium">3 GB DDR4</div>
                        </div>
                        <div class="grid grid-cols-4 gap-4 px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-750">
                            <div class="font-semibold text-gray-900 dark:text-white"><?php echo e(__('frontend.cpu_cores')); ?></div>
                            <div class="text-center text-gray-900 dark:text-white font-medium">1.5 Core Gen 7</div>
                            <div class="text-center bg-yellow-50 dark:bg-yellow-900/10 -mx-4 px-4 py-2 text-gray-900 dark:text-white font-medium">1.5 Core Gen 7</div>
                            <div class="text-center text-gray-900 dark:text-white font-medium">2 Core Gen 7</div>
                        </div>
                        <div class="grid grid-cols-4 gap-4 px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-750">
                            <div class="font-semibold text-gray-900 dark:text-white"><?php echo e(__('frontend.bandwidth')); ?></div>
                            <div class="text-center text-gray-900 dark:text-white font-medium"><?php echo e(__('frontend.unlimited')); ?></div>
                            <div class="text-center bg-yellow-50 dark:bg-yellow-900/10 -mx-4 px-4 py-2 text-gray-900 dark:text-white font-medium"><?php echo e(__('frontend.unlimited')); ?></div>
                            <div class="text-center text-gray-900 dark:text-white font-medium"><?php echo e(__('frontend.unlimited')); ?></div>
                        </div>
                        <div class="grid grid-cols-4 gap-4 px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-750">
                            <div class="font-semibold text-gray-900 dark:text-white"><?php echo e(__('frontend.performance_boost')); ?></div>
                            <div class="text-center text-gray-900 dark:text-white font-medium"><?php echo e(__('frontend.up_to_2x')); ?></div>
                            <div class="text-center bg-yellow-50 dark:bg-yellow-900/10 -mx-4 px-4 py-2 text-gray-900 dark:text-white font-medium"><?php echo e(__('frontend.up_to_5x')); ?></div>
                            <div class="text-center text-gray-900 dark:text-white font-medium"><?php echo e(__('frontend.up_to_10x')); ?></div>
                        </div>
                        <div class="grid grid-cols-4 gap-4 px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-750">
                            <div class="font-semibold text-gray-900 dark:text-white"><?php echo e(__('frontend.monthly_visits')); ?></div>
                            <div class="text-center text-gray-900 dark:text-white font-medium">50,000</div>
                            <div class="text-center bg-yellow-50 dark:bg-yellow-900/10 -mx-4 px-4 py-2 text-gray-900 dark:text-white font-medium">150,000</div>
                            <div class="text-center text-gray-900 dark:text-white font-medium">250,000</div>
                        </div>
                    </div>
                </div>

                <!-- Websites & Email Section -->
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <div class="bg-gradient-to-r from-blue-600 to-cyan-600 px-6 py-4">
                        <h4 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 <?php echo e(app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                            </svg>
                            <?php echo e(__('frontend.websites_email')); ?>

                        </h4>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        <div class="grid grid-cols-4 gap-4 px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-750">
                            <div class="font-semibold text-gray-900 dark:text-white"><?php echo e(__('frontend.number_of_websites')); ?></div>
                            <div class="text-center text-gray-900 dark:text-white font-medium">150</div>
                            <div class="text-center bg-yellow-50 dark:bg-yellow-900/10 -mx-4 px-4 py-2 text-gray-900 dark:text-white font-medium">200</div>
                            <div class="text-center text-gray-900 dark:text-white font-medium">350</div>
                        </div>
                        <div class="grid grid-cols-4 gap-4 px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-750">
                            <div class="font-semibold text-gray-900 dark:text-white"><?php echo e(__('frontend.email_accounts')); ?></div>
                            <div class="text-center text-gray-900 dark:text-white font-medium">150</div>
                            <div class="text-center bg-yellow-50 dark:bg-yellow-900/10 -mx-4 px-4 py-2 text-gray-900 dark:text-white font-medium">200</div>
                            <div class="text-center text-gray-900 dark:text-white font-medium">350</div>
                        </div>
                    </div>
                </div>

                <!-- Advanced Features Section -->
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4">
                        <h4 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 <?php echo e(app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <?php echo e(__('frontend.advanced_features')); ?>

                        </h4>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        <div class="grid grid-cols-4 gap-4 px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-750">
                            <div class="font-semibold text-gray-900 dark:text-white"><?php echo e(__('frontend.free_cdn')); ?></div>
                            <div class="text-center">
                                <svg class="w-6 h-6 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                            <div class="text-center bg-yellow-50 dark:bg-yellow-900/10 -mx-4 px-4 py-2">
                                <svg class="w-6 h-6 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div class="text-center">
                                <svg class="w-6 h-6 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        </div>
                        <div class="grid grid-cols-4 gap-4 px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-750">
                            <div class="font-semibold text-gray-900 dark:text-white"><?php echo e(__('frontend.auto_backup')); ?></div>
                            <div class="text-center">
                                <svg class="w-6 h-6 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                            <div class="text-center bg-yellow-50 dark:bg-yellow-900/10 -mx-4 px-4 py-2">
                                <svg class="w-6 h-6 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div class="text-center">
                                <svg class="w-6 h-6 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        </div>
                        <div class="grid grid-cols-4 gap-4 px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-750">
                            <div class="font-semibold text-gray-900 dark:text-white"><?php echo e(__('frontend.cloud_storage')); ?></div>
                            <div class="text-center">
                                <svg class="w-6 h-6 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                            <div class="text-center bg-yellow-50 dark:bg-yellow-900/10 -mx-4 px-4 py-2">
                                <svg class="w-6 h-6 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div class="text-center">
                                <svg class="w-6 h-6 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        </div>
                        <div class="grid grid-cols-4 gap-4 px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-750">
                            <div class="font-semibold text-gray-900 dark:text-white"><?php echo e(__('frontend.dedicated_ip')); ?></div>
                            <div class="text-center">
                                <svg class="w-6 h-6 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                            <div class="text-center bg-yellow-50 dark:bg-yellow-900/10 -mx-4 px-4 py-2">
                                <svg class="w-6 h-6 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                            <div class="text-center">
                                <svg class="w-6 h-6 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        </div>
                        <div class="grid grid-cols-4 gap-4 px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-750">
                            <div class="font-semibold text-gray-900 dark:text-white"><?php echo e(__('frontend.wordpress_ai_tools')); ?></div>
                            <div class="text-center">
                                <svg class="w-6 h-6 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                            <div class="text-center bg-yellow-50 dark:bg-yellow-900/10 -mx-4 px-4 py-2">
                                <svg class="w-6 h-6 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                            <div class="text-center">
                                <svg class="w-6 h-6 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        </div>
                        <div class="grid grid-cols-4 gap-4 px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-750">
                            <div class="font-semibold text-gray-900 dark:text-white"><?php echo e(__('frontend.priority_support')); ?></div>
                            <div class="text-center">
                                <svg class="w-6 h-6 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                            <div class="text-center bg-yellow-50 dark:bg-yellow-900/10 -mx-4 px-4 py-2">
                                <svg class="w-6 h-6 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                            <div class="text-center">
                                <svg class="w-6 h-6 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Standard Features (Included in All Plans) -->
                <div>
                    <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4">
                        <h4 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 <?php echo e(app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <?php echo e(__('frontend.included_all_plans')); ?>

                        </h4>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <?php
                                $standardFeatures = [
                                    'cpanel_control_panel',
                                    'oneclick_wordpress',
                                    'unlimited_ssl',
                                    'litespeed_server',
                                    'standard_woocommerce',
                                    'free_website_migration',
                                    'prebuilt_templates',
                                    'wordpress_auto_updates',
                                    'wp_vulnerabilities_scanner',
                                    'wordpress_multisite',
                                    'wpcli_ssh_access',
                                    'wordpress_staging',
                                    'object_cache_wordpress',
                                    'dragdrop_website_builder',
                                    'enhanced_ddos_protection',
                                    'web_application_firewall',
                                    'malware_scanner',
                                    'secure_access_manager',
                                    'free_whois_privacy',
                                    'global_data_centers',
                                    'uptime_guarantee',
                                    'customer_support_247',
                                    'money_back_guarantee'
                                ];
                            ?>
                            
                            <?php $__currentLoopData = $standardFeatures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?> mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-sm text-gray-700 dark:text-gray-300"><?php echo e(__('frontend.' . $feature)); ?></span>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Mobile: Simple Feature List -->
        <div class="lg:hidden space-y-6 mt-12">
            <div class="text-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2"><?php echo e(__('frontend.all_plans_include')); ?></h3>
                <p class="text-gray-600 dark:text-gray-400"><?php echo e(__('frontend.premium_features_included')); ?></p>
            </div>
            
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-xl">
                <div class="grid grid-cols-1 gap-3">
                    <?php $__currentLoopData = $standardFeatures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 <?php echo e(app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3'); ?> mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300"><?php echo e(__('frontend.' . $feature)); ?></span>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Technology & Trust Section -->
<section class="py-16 sm:py-20 lg:py-24 bg-white dark:bg-gray-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 2xl:px-16">
        <div class="w-full max-w-6xl xl:max-w-5xl 2xl:max-w-4xl mx-auto">
        <div class="space-y-16">
            
            <!-- Expect the Latest Technology -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="order-2 lg:order-1">
                    <div class="inline-flex items-center justify-center px-4 py-2 mb-4 text-sm font-semibold text-blue-600 bg-blue-100 dark:bg-blue-900/30 dark:text-blue-400 rounded-full">
                        <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <?php echo e(__('frontend.latest_technology')); ?>

                    </div>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-white mb-6">
                        <?php echo e(__('frontend.expect_latest_technology')); ?>

                    </h2>
                    <p class="text-lg text-gray-600 dark:text-gray-300 leading-relaxed mb-6">
                        <?php echo e(__('frontend.expect_latest_technology_desc')); ?>

                    </p>
                    <div class="flex flex-wrap gap-3">
                        <span class="px-4 py-2 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-medium">PowerEdge M1000e</span>
                        <span class="px-4 py-2 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-medium">100% Uptime</span>
                        <span class="px-4 py-2 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-medium">High-Speed SAN</span>
                        <span class="px-4 py-2 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-medium">Fully Redundant</span>
                    </div>
                </div>
                <div class="order-1 lg:order-2">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl transform rotate-3"></div>
                        <div class="relative bg-gradient-to-br from-blue-600 to-purple-700 rounded-2xl p-8 text-white">
                            <svg class="w-20 h-20 mb-4 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                            </svg>
                            <h3 class="text-2xl font-bold mb-2"><?php echo e(__('frontend.blade_enclosure')); ?></h3>
                            <p class="text-blue-100"><?php echo e(__('frontend.state_of_art_infrastructure')); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Develop with Ease -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl transform -rotate-3"></div>
                        <div class="relative bg-gradient-to-br from-green-600 to-emerald-700 rounded-2xl p-8 text-white">
                            <svg class="w-20 h-20 mb-4 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                            </svg>
                            <h3 class="text-2xl font-bold mb-2"><?php echo e(__('frontend.developer_friendly')); ?></h3>
                            <p class="text-green-100"><?php echo e(__('frontend.latest_software_versions')); ?></p>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="inline-flex items-center justify-center px-4 py-2 mb-4 text-sm font-semibold text-green-600 bg-green-100 dark:bg-green-900/30 dark:text-green-400 rounded-full">
                        <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                        </svg>
                        <?php echo e(__('frontend.for_developers')); ?>

                    </div>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-white mb-6">
                        <?php echo e(__('frontend.develop_with_ease')); ?>

                    </h2>
                    <p class="text-lg text-gray-600 dark:text-gray-300 leading-relaxed mb-6">
                        <?php echo e(__('frontend.develop_with_ease_desc')); ?>

                    </p>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        <div class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-sm font-medium">CMS Choice</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-sm font-medium">Jailshell SSH</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-sm font-medium">PHP Latest</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-sm font-medium">Python</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-sm font-medium">Node.js</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-sm font-medium">Ruby</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-sm font-medium">Perl</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-sm font-medium">Databases</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hosting You Can Trust -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="order-2 lg:order-1">
                    <div class="inline-flex items-center justify-center px-4 py-2 mb-4 text-sm font-semibold text-purple-600 bg-purple-100 dark:bg-purple-900/30 dark:text-purple-400 rounded-full">
                        <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <?php echo e(__('frontend.security_reliability')); ?>

                    </div>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-white mb-6">
                        <?php echo e(__('frontend.hosting_you_can_trust')); ?>

                    </h2>
                    <p class="text-lg text-gray-600 dark:text-gray-300 leading-relaxed mb-6">
                        <?php echo e(__('frontend.hosting_you_can_trust_desc')); ?>

                    </p>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white mb-1"><?php echo e(__('frontend.hosting_guarantee')); ?></h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400"><?php echo e(__('frontend.highest_quality_commitment')); ?></p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white mb-1"><?php echo e(__('frontend.account_isolation')); ?></h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400"><?php echo e(__('frontend.no_noisy_neighbor')); ?></p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white mb-1"><?php echo e(__('frontend.continuous_monitoring')); ?></h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400"><?php echo e(__('frontend.security_updates_2fa')); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="order-1 lg:order-2">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl transform rotate-3"></div>
                        <div class="relative bg-gradient-to-br from-purple-600 to-pink-700 rounded-2xl p-8 text-white">
                            <svg class="w-20 h-20 mb-4 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <h3 class="text-2xl font-bold mb-2"><?php echo e(__('frontend.pro_gineous_guarantee')); ?></h3>
                            <p class="text-purple-100"><?php echo e(__('frontend.excellence_in_hosting')); ?></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
</section>

<!-- Why Pro Gineous Section -->
<section class="py-16 sm:py-20 lg:py-24 bg-gradient-to-br from-gray-50 to-blue-50 dark:from-gray-900 dark:to-gray-800">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 2xl:px-16">
        <div class="w-full max-w-6xl xl:max-w-5xl 2xl:max-w-4xl mx-auto">
            
            <!-- Section Header -->
            <div class="text-center mb-16">
                <div class="inline-flex items-center justify-center px-4 py-2 mb-4 text-sm font-semibold text-blue-600 bg-blue-100 dark:bg-blue-900/30 dark:text-blue-400 rounded-full">
                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                    <?php echo e(__('frontend.why_us')); ?>

                </div>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-gray-900 dark:text-white mb-6">
                    <?php echo e(__('frontend.why_pro_gineous')); ?>

                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                    <?php echo e(__('frontend.why_pro_gineous_desc')); ?>

                </p>
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- Feature 1: 24/7 Expert Support -->
                <div class="group bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                        <?php echo e(__('frontend.expert_support_247')); ?>

                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                        <?php echo e(__('frontend.expert_support_247_desc')); ?>

                    </p>
                </div>

                <!-- Feature 2: 99.9% Uptime Guarantee -->
                <div class="group bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                        <?php echo e(__('frontend.uptime_guarantee_999')); ?>

                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                        <?php echo e(__('frontend.uptime_guarantee_999_desc')); ?>

                    </p>
                </div>

                <!-- Feature 3: Lightning-Fast Speed -->
                <div class="group bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                        <?php echo e(__('frontend.lightning_fast_speed')); ?>

                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                        <?php echo e(__('frontend.lightning_fast_speed_desc')); ?>

                    </p>
                </div>

                <!-- Feature 4: Free SSL Certificates -->
                <div class="group bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                        <?php echo e(__('frontend.free_ssl_certificates')); ?>

                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                        <?php echo e(__('frontend.free_ssl_certificates_desc')); ?>

                    </p>
                </div>

                <!-- Feature 5: Daily Backups -->
                <div class="group bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                        <?php echo e(__('frontend.daily_backups')); ?>

                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                        <?php echo e(__('frontend.daily_backups_desc')); ?>

                    </p>
                </div>

                <!-- Feature 6: Easy Website Management -->
                <div class="group bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-rose-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                        <?php echo e(__('frontend.easy_website_management')); ?>

                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                        <?php echo e(__('frontend.easy_website_management_desc')); ?>

                    </p>
                </div>

            </div>

            <!-- Bottom CTA -->
            <div class="mt-16 text-center">
                <div class="inline-flex flex-col sm:flex-row items-center gap-4 bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-xl border border-gray-200 dark:border-gray-700">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 text-center sm:<?php echo e(app()->getLocale() == 'ar' ? 'text-right' : 'text-left'); ?>">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                            <?php echo e(__('frontend.ready_to_get_started')); ?>

                        </h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            <?php echo e(__('frontend.join_thousands_customers')); ?>

                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="#plans" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                            <?php echo e(__('frontend.view_plans')); ?>

                            <svg class="w-5 h-5 <?php echo e(app()->getLocale() == 'ar' ? 'rotate-180' : ''); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-16 sm:py-20 lg:py-24 bg-white dark:bg-gray-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 2xl:px-16">
        <div class="w-full max-w-4xl xl:max-w-3xl 2xl:max-w-3xl mx-auto">
            
            <!-- Section Header -->
            <div class="text-center mb-16">
                <div class="inline-flex items-center justify-center px-4 py-2 mb-4 text-sm font-semibold text-blue-600 bg-blue-100 dark:bg-blue-900/30 dark:text-blue-400 rounded-full">
                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <?php echo e(__('frontend.faq')); ?>

                </div>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-gray-900 dark:text-white mb-6">
                    <?php echo e(__('frontend.frequently_asked_questions')); ?>

                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-300">
                    <?php echo e(__('frontend.faq_desc')); ?>

                </p>
            </div>

            <!-- FAQ Accordion -->
            <div class="space-y-4">
                
                <!-- FAQ 1 -->
                <div x-data="{ open: false }" class="bg-gray-50 dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300">
                    <button @click="open = !open" class="w-full px-6 py-5 flex items-center justify-between text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                        <span class="font-bold text-gray-900 dark:text-white text-lg flex-1 <?php echo e(app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4'); ?>">
                            <?php echo e(__('frontend.faq_what_is_shared_hosting')); ?>

                        </span>
                        <svg :class="{ 'rotate-180': open }" class="w-6 h-6 text-blue-600 dark:text-blue-400 transform transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-5">
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                            <?php echo e(__('frontend.faq_what_is_shared_hosting_answer')); ?>

                        </p>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div x-data="{ open: false }" class="bg-gray-50 dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300">
                    <button @click="open = !open" class="w-full px-6 py-5 flex items-center justify-between text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                        <span class="font-bold text-gray-900 dark:text-white text-lg flex-1 <?php echo e(app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4'); ?>">
                            <?php echo e(__('frontend.faq_good_for_small_business')); ?>

                        </span>
                        <svg :class="{ 'rotate-180': open }" class="w-6 h-6 text-blue-600 dark:text-blue-400 transform transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-5">
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                            <?php echo e(__('frontend.faq_good_for_small_business_answer')); ?>

                        </p>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div x-data="{ open: false }" class="bg-gray-50 dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300">
                    <button @click="open = !open" class="w-full px-6 py-5 flex items-center justify-between text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                        <span class="font-bold text-gray-900 dark:text-white text-lg flex-1 <?php echo e(app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4'); ?>">
                            <?php echo e(__('frontend.faq_how_to_setup_account')); ?>

                        </span>
                        <svg :class="{ 'rotate-180': open }" class="w-6 h-6 text-blue-600 dark:text-blue-400 transform transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-5">
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                            <?php echo e(__('frontend.faq_how_to_setup_account_answer')); ?>

                        </p>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div x-data="{ open: false }" class="bg-gray-50 dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300">
                    <button @click="open = !open" class="w-full px-6 py-5 flex items-center justify-between text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                        <span class="font-bold text-gray-900 dark:text-white text-lg flex-1 <?php echo e(app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4'); ?>">
                            <?php echo e(__('frontend.faq_how_to_use_cpanel')); ?>

                        </span>
                        <svg :class="{ 'rotate-180': open }" class="w-6 h-6 text-blue-600 dark:text-blue-400 transform transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-5">
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                            <?php echo e(__('frontend.faq_how_to_use_cpanel_answer')); ?>

                        </p>
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div x-data="{ open: false }" class="bg-gray-50 dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300">
                    <button @click="open = !open" class="w-full px-6 py-5 flex items-center justify-between text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                        <span class="font-bold text-gray-900 dark:text-white text-lg flex-1 <?php echo e(app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4'); ?>">
                            <?php echo e(__('frontend.faq_wordpress_compatible')); ?>

                        </span>
                        <svg :class="{ 'rotate-180': open }" class="w-6 h-6 text-blue-600 dark:text-blue-400 transform transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-5">
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                            <?php echo e(__('frontend.faq_wordpress_compatible_answer')); ?>

                        </p>
                    </div>
                </div>

                <!-- FAQ 6 -->
                <div x-data="{ open: false }" class="bg-gray-50 dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300">
                    <button @click="open = !open" class="w-full px-6 py-5 flex items-center justify-between text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                        <span class="font-bold text-gray-900 dark:text-white text-lg flex-1 <?php echo e(app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4'); ?>">
                            <?php echo e(__('frontend.faq_how_to_migrate')); ?>

                        </span>
                        <svg :class="{ 'rotate-180': open }" class="w-6 h-6 text-blue-600 dark:text-blue-400 transform transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-5">
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                            <?php echo e(__('frontend.faq_how_to_migrate_answer')); ?>

                        </p>
                    </div>
                </div>

                <!-- FAQ 7 -->
                <div x-data="{ open: false }" class="bg-gray-50 dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300">
                    <button @click="open = !open" class="w-full px-6 py-5 flex items-center justify-between text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                        <span class="font-bold text-gray-900 dark:text-white text-lg flex-1 <?php echo e(app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4'); ?>">
                            <?php echo e(__('frontend.faq_shared_vs_vps')); ?>

                        </span>
                        <svg :class="{ 'rotate-180': open }" class="w-6 h-6 text-blue-600 dark:text-blue-400 transform transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-5">
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                            <?php echo e(__('frontend.faq_shared_vs_vps_answer')); ?>

                        </p>
                    </div>
                </div>

                <!-- FAQ 8 -->
                <div x-data="{ open: false }" class="bg-gray-50 dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300">
                    <button @click="open = !open" class="w-full px-6 py-5 flex items-center justify-between text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                        <span class="font-bold text-gray-900 dark:text-white text-lg flex-1 <?php echo e(app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4'); ?>">
                            <?php echo e(__('frontend.faq_server_location')); ?>

                        </span>
                        <svg :class="{ 'rotate-180': open }" class="w-6 h-6 text-blue-600 dark:text-blue-400 transform transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-5">
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                            <?php echo e(__('frontend.faq_server_location_answer')); ?>

                        </p>
                    </div>
                </div>

                <!-- FAQ 9 -->
                <div x-data="{ open: false }" class="bg-gray-50 dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300">
                    <button @click="open = !open" class="w-full px-6 py-5 flex items-center justify-between text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                        <span class="font-bold text-gray-900 dark:text-white text-lg flex-1 <?php echo e(app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4'); ?>">
                            <?php echo e(__('frontend.faq_which_plan_to_choose')); ?>

                        </span>
                        <svg :class="{ 'rotate-180': open }" class="w-6 h-6 text-blue-600 dark:text-blue-400 transform transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-5">
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                            <?php echo e(__('frontend.faq_which_plan_to_choose_answer')); ?>

                        </p>
                    </div>
                </div>

                <!-- FAQ 10 -->
                <div x-data="{ open: false }" class="bg-gray-50 dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300">
                    <button @click="open = !open" class="w-full px-6 py-5 flex items-center justify-between text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                        <span class="font-bold text-gray-900 dark:text-white text-lg flex-1 <?php echo e(app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4'); ?>">
                            <?php echo e(__('frontend.faq_is_secure')); ?>

                        </span>
                        <svg :class="{ 'rotate-180': open }" class="w-6 h-6 text-blue-600 dark:text-blue-400 transform transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-5">
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                            <?php echo e(__('frontend.faq_is_secure_answer')); ?>

                        </p>
                    </div>
                </div>

                <!-- FAQ 11 -->
                <div x-data="{ open: false }" class="bg-gray-50 dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300">
                    <button @click="open = !open" class="w-full px-6 py-5 flex items-center justify-between text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                        <span class="font-bold text-gray-900 dark:text-white text-lg flex-1 <?php echo e(app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4'); ?>">
                            <?php echo e(__('frontend.faq_how_many_websites')); ?>

                        </span>
                        <svg :class="{ 'rotate-180': open }" class="w-6 h-6 text-blue-600 dark:text-blue-400 transform transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-5">
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                            <?php echo e(__('frontend.faq_how_many_websites_answer')); ?>

                        </p>
                    </div>
                </div>

                <!-- FAQ 12 -->
                <div x-data="{ open: false }" class="bg-gray-50 dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300">
                    <button @click="open = !open" class="w-full px-6 py-5 flex items-center justify-between text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                        <span class="font-bold text-gray-900 dark:text-white text-lg flex-1 <?php echo e(app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4'); ?>">
                            <?php echo e(__('frontend.faq_shared_vs_dedicated')); ?>

                        </span>
                        <svg :class="{ 'rotate-180': open }" class="w-6 h-6 text-blue-600 dark:text-blue-400 transform transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-5">
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                            <?php echo e(__('frontend.faq_shared_vs_dedicated_answer')); ?>

                        </p>
                    </div>
                </div>

                <!-- FAQ 13 -->
                <div x-data="{ open: false }" class="bg-gray-50 dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300">
                    <button @click="open = !open" class="w-full px-6 py-5 flex items-center justify-between text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                        <span class="font-bold text-gray-900 dark:text-white text-lg flex-1 <?php echo e(app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4'); ?>">
                            <?php echo e(__('frontend.faq_email_services')); ?>

                        </span>
                        <svg :class="{ 'rotate-180': open }" class="w-6 h-6 text-blue-600 dark:text-blue-400 transform transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-5">
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                            <?php echo e(__('frontend.faq_email_services_answer')); ?>

                        </p>
                    </div>
                </div>

            </div>

            <!-- Contact Support CTA -->
            <div class="mt-12 text-center">
                <p class="text-gray-600 dark:text-gray-300 mb-6">
                    <?php echo e(__('frontend.faq_still_have_questions')); ?>

                </p>
                <a href="#" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 text-white font-bold rounded-xl shadow-lg hover:bg-blue-700 hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <?php echo e(__('frontend.contact_support')); ?>

                </a>
            </div>

        </div>
    </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 sm:py-20 lg:py-24 bg-gradient-to-br from-blue-600 via-indigo-700 to-purple-800 relative overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-20 left-20 w-72 h-72 bg-white rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-20 w-96 h-96 bg-purple-300 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s"></div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 2xl:px-16 relative z-10">
        <div class="max-w-5xl xl:max-w-4xl 2xl:max-w-3xl mx-auto">
        <div class="text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6" dir="auto">
                <?php echo e(__('frontend.ready_to_start')); ?>

            </h2>
            <p class="text-xl text-blue-100 mb-12" dir="auto">
                <?php echo e(__('frontend.start_hosting_today')); ?>

            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#plans" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-blue-600 font-bold rounded-xl shadow-2xl hover:shadow-3xl transform hover:scale-105 transition-all duration-300">
                    <span dir="auto"><?php echo e(__('frontend.get_started_now')); ?></span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
                <a href="#" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white/10 backdrop-blur-sm text-white font-bold rounded-xl border-2 border-white/30 hover:bg-white/20 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <span dir="auto"><?php echo e(__('frontend.contact_sales')); ?></span>
                </a>
            </div>
        </div>
        </div>
    </div>
</section>

<style>
/* Prevent horizontal overflow */
body {
    overflow-x: hidden;
    max-width: 100vw;
}

*, *::before, *::after {
    box-sizing: border-box;
}

/* Ensure sections don't overflow */
section {
    max-width: 100vw;
    overflow-x: hidden;
}

/* Ensure all containers respect viewport width */
.container,
[class*="max-w-"] {
    max-width: 100%;
}

/* Prevent grid overflow */
.grid {
    width: 100%;
}

/* Ensure proper responsive behavior */
@media (max-width: 768px) {
    .md\:scale-105,
    .md\:transform {
        transform: none !important;
    }
}

/* Pricing Cards - Fixed to top alignment */
#plans .grid > div {
    align-self: flex-start !important;
}

/* Smooth transition for feature expansion */
.feature-extra-[data-plan-id] {
    transition: all 0.3s ease-in-out;
}

/* Glassmorphism Effects */
.glass-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
}

.glass-card-strong {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(25px);
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.2);
}

.glass-badge {
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    padding: 0.5rem 1rem;
    border-radius: 1rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.glass-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1rem;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border-radius: 9999px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
}

.glass-pill:hover {
    background: rgba(255, 255, 255, 0.15);
    transform: translateY(-2px);
}

/* Animations */
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 1s ease-out;
}

@keyframes fade-in-up {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fade-in-up 0.8s ease-out forwards;
    opacity: 0;
}

@keyframes fade-in-left {
    from {
        opacity: 0;
        transform: translateX(50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.animate-fade-in-left {
    animation: fade-in-left 1s ease-out;
}

@keyframes blob {
    0%, 100% {
        transform: translate(0, 0) scale(1);
    }
    25% {
        transform: translate(30px, -30px) scale(1.1);
    }
    50% {
        transform: translate(-30px, 30px) scale(0.9);
    }
    75% {
        transform: translate(30px, 30px) scale(1.05);
    }
}

.animate-blob {
    animation: blob 20s infinite cubic-bezier(0.4, 0, 0.2, 1);
}

@keyframes float {
    0%, 100% {
        transform: translateY(0) rotate(0deg);
    }
    50% {
        transform: translateY(-25px) rotate(3deg);
    }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

@keyframes grow {
    from {
        width: 0;
    }
}

@keyframes gradient {
    0%, 100% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
}

.animate-gradient {
    background-size: 200% 200%;
    animation: gradient 3s ease infinite;
}

/* Custom Select Dropdown Styling */
#billingPeriodSelect {
    background-image: none !important;
}

#billingPeriodSelect:hover {
    transform: translateY(-1px);
}

#billingPeriodSelect:active {
    transform: translateY(0);
}

#billingPeriodSelect option {
    padding: 12px;
    background-color: white;
    color: #1f2937;
}

@media (prefers-color-scheme: dark) {
    #billingPeriodSelect option {
        background-color: #1f2937;
        color: #f9fafb;
    }
}

/* Animation Delays */
.animation-delay-200 {
    animation-delay: 0.2s;
}

.animation-delay-400 {
    animation-delay: 0.4s;
}

.animation-delay-600 {
    animation-delay: 0.6s;
}

.animation-delay-800 {
    animation-delay: 0.8s;
}

.animation-delay-1000 {
    animation-delay: 1s;
}

.animation-delay-1500 {
    animation-delay: 1.5s;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-3000 {
    animation-delay: 3s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}

.animation-delay-6000 {
    animation-delay: 6s;
}

/* Smooth Scrolling */
html {
    scroll-behavior: smooth;
    scroll-padding-top: 100px;
}

/* Hover Effects for Glass Cards */
.glass-card:hover,
.glass-card-strong:hover {
    background: rgba(255, 255, 255, 0.2);
    box-shadow: 0 12px 48px 0 rgba(31, 38, 135, 0.3);
}
</style>

<script>
function toggleFeatures(planId) {
    const card = document.getElementById('plan-card-' + planId);
    const extraFeatures = document.querySelectorAll('.feature-extra-' + planId);
    const toggleText = document.getElementById('toggle-text-' + planId);
    const toggleIcon = document.getElementById('toggle-icon-' + planId);
    
    const isHidden = extraFeatures[0].classList.contains('hidden');
    
    // Get the card's current position before expanding
    const cardRect = card.getBoundingClientRect();
    const scrollBefore = window.pageYOffset;
    const cardTopBefore = cardRect.top + scrollBefore;
    
    // Toggle features visibility
    extraFeatures.forEach(feature => {
        if (isHidden) {
            feature.classList.remove('hidden');
        } else {
            feature.classList.add('hidden');
        }
    });
    
    // After DOM update, maintain the card's top position
    requestAnimationFrame(() => {
        const cardRectAfter = card.getBoundingClientRect();
        const cardTopAfter = cardRectAfter.top + window.pageYOffset;
        
        // If the card moved up (which happens when content expands), scroll to compensate
        if (cardTopAfter !== cardTopBefore && isHidden) {
            const diff = cardTopBefore - cardTopAfter;
            window.scrollBy({
                top: -diff,
                behavior: 'instant'
            });
        }
    });
    
    // Update button text and icon
    if (isHidden) {
        toggleText.textContent = '<?php echo e(__("frontend.show_less")); ?>';
        toggleIcon.style.transform = 'rotate(180deg)';
    } else {
        toggleText.textContent = '<?php echo e(__("frontend.show_more")); ?>';
        toggleIcon.style.transform = 'rotate(0deg)';
    }
}

// Billing Period Switcher
let currentPeriod = 'monthly';

function switchBillingPeriod(period) {
    currentPeriod = period;
    
    // Update prices for all plans - get unique plan IDs first
    const uniquePlanIds = new Set();
    document.querySelectorAll('.pricing-display[data-plan-id]').forEach(el => {
        uniquePlanIds.add(el.getAttribute('data-plan-id'));
    });
    
    // Process each unique plan ID
    uniquePlanIds.forEach(planId => {
        const prices = window['planPrices_' + planId];
        
        console.log('=== Processing Plan ID:', planId);
        console.log('Prices object:', prices);
        console.log('Selected period:', period);
        
        if (prices && prices[period]) {
            const totalPrice = prices[period];
            let displayPrice = totalPrice;
            let periodText = '';
            
            console.log('Total price for', period, ':', totalPrice);
            
            // Get datacenter cost if applicable
            const datacenterSelect = document.getElementById('datacenter_' + planId);
            let datacenterTotalCost = 0;
            
            if (datacenterSelect) {
                const selectedDatacenter = datacenterSelect.value;
                const datacenterPrices = window['datacenterPrices_' + planId];
                
                if (datacenterPrices && datacenterPrices[selectedDatacenter]) {
                    const datacenterMonthlyCost = datacenterPrices[selectedDatacenter];
                    
                    // Calculate datacenter cost for the period
                    switch(period) {
                        case 'monthly':
                            datacenterTotalCost = datacenterMonthlyCost;
                            break;
                        case 'quarterly':
                            datacenterTotalCost = datacenterMonthlyCost * 3;
                            break;
                        case 'semiannually':
                            datacenterTotalCost = datacenterMonthlyCost * 6;
                            break;
                        case 'annually':
                            datacenterTotalCost = datacenterMonthlyCost * 12;
                            break;
                        case 'biennially':
                            datacenterTotalCost = datacenterMonthlyCost * 24;
                            break;
                        case 'triennially':
                            datacenterTotalCost = datacenterMonthlyCost * 36;
                            break;
                    }
                    
                    console.log('Datacenter monthly cost:', datacenterMonthlyCost);
                    console.log('Datacenter total cost for period:', datacenterTotalCost);
                }
            }
            
            // Calculate display price and period text based on billing period
            switch(period) {
                case 'monthly':
                    displayPrice = totalPrice + datacenterTotalCost;
                    periodText = '<?php echo e(__("frontend.per_month")); ?>';
                    break;
                case 'quarterly':
                    displayPrice = totalPrice + datacenterTotalCost;
                    periodText = '<?php echo e(__("frontend.per_quarter")); ?>';
                    break;
                case 'semiannually':
                    displayPrice = totalPrice + datacenterTotalCost;
                    periodText = '<?php echo e(__("frontend.per_6months")); ?>';
                    break;
                case 'annually':
                    displayPrice = totalPrice + datacenterTotalCost;
                    periodText = '<?php echo e(__("frontend.per_year")); ?>';
                    break;
                case 'biennially':
                    displayPrice = totalPrice + datacenterTotalCost;
                    periodText = '<?php echo e(__("frontend.per_2years")); ?>';
                    break;
                case 'triennially':
                    displayPrice = totalPrice + datacenterTotalCost;
                    periodText = '<?php echo e(__("frontend.per_3years")); ?>';
                    break;
            }
            
            console.log('Calculated display price (with datacenter):', displayPrice);
            
            // Find ALL pricing display elements with this plan ID and update them
            const priceElements = document.querySelectorAll(`.pricing-display[data-plan-id="${planId}"]`);
            console.log('Found', priceElements.length, 'pricing elements with plan ID', planId);
            
            priceElements.forEach((priceElement, index) => {
                console.log('Updating element', index);
                const priceAmountElement = priceElement.querySelector('.price-amount');
                console.log('Price amount element:', priceAmountElement);
                
                if (priceAmountElement) {
                    priceAmountElement.textContent = displayPrice.toFixed(2);
                    console.log('Updated price to:', displayPrice.toFixed(2));
                }
                
                // Update period label
                const periodLabel = priceElement.querySelector('.price-period');
                if (periodLabel) {
                    periodLabel.textContent = periodText;
                    console.log('Updated period label to:', periodText);
                }
            });
        } else {
            console.error('❌ No prices found for plan', planId, 'or period', period);
        }
    });
}

// Update price with datacenter cost
function updatePriceWithDatacenter(planId) {
    console.log('=== Updating price with datacenter for Plan:', planId);
    
    const datacenterSelect = document.getElementById('datacenter_' + planId);
    if (!datacenterSelect) {
        console.error('Datacenter select not found for plan:', planId);
        return;
    }
    
    const selectedDatacenter = datacenterSelect.value;
    const datacenterPrices = window['datacenterPrices_' + planId];
    const planPrices = window['planPrices_' + planId];
    
    console.log('Selected datacenter:', selectedDatacenter);
    console.log('Datacenter prices:', datacenterPrices);
    console.log('Plan prices:', planPrices);
    
    if (!datacenterPrices || !planPrices) {
        console.error('Prices not found for plan:', planId);
        return;
    }
    
    // Get datacenter additional cost (monthly)
    const datacenterMonthlyCost = datacenterPrices[selectedDatacenter] || 0;
    console.log('Datacenter monthly cost:', datacenterMonthlyCost);
    
    // Get base price for current period
    const basePriceForPeriod = planPrices[currentPeriod] || planPrices.monthly;
    
    // Calculate total datacenter cost based on period
    let datacenterTotalCost = 0;
    switch(currentPeriod) {
        case 'monthly':
            datacenterTotalCost = datacenterMonthlyCost;
            break;
        case 'quarterly':
            datacenterTotalCost = datacenterMonthlyCost * 3;
            break;
        case 'semiannually':
            datacenterTotalCost = datacenterMonthlyCost * 6;
            break;
        case 'annually':
            datacenterTotalCost = datacenterMonthlyCost * 12;
            break;
        case 'biennially':
            datacenterTotalCost = datacenterMonthlyCost * 24;
            break;
        case 'triennially':
            datacenterTotalCost = datacenterMonthlyCost * 36;
            break;
    }
    
    console.log('Datacenter total cost for period:', datacenterTotalCost);
    
    // Calculate final price
    const finalPrice = basePriceForPeriod + datacenterTotalCost;
    console.log('Base price:', basePriceForPeriod);
    console.log('Final price (with datacenter):', finalPrice);
    
    // Update price display
    const priceElements = document.querySelectorAll(`.pricing-display[data-plan-id="${planId}"]`);
    priceElements.forEach((priceElement) => {
        const priceAmountElement = priceElement.querySelector('.price-amount');
        if (priceAmountElement) {
            priceAmountElement.textContent = finalPrice.toFixed(2);
            console.log('✅ Updated price display to:', finalPrice.toFixed(2));
        }
    });
}

// Initialize datacenter listeners on page load
document.addEventListener('DOMContentLoaded', function() {
    // Update prices when datacenter changes
    document.querySelectorAll('[id^="datacenter_"]').forEach(select => {
        const planId = select.id.replace('datacenter_', '');
        // Trigger initial calculation
        updatePriceWithDatacenter(planId);
    });
});
</script>

<?php $__env->stopSection(); ?>





<?php echo $__env->make('frontend.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\resources\views/frontend/hosting/shared.blade.php ENDPATH**/ ?>