

<?php $__env->startSection('title', $product->name . ' - ' . __('frontend.configure_product') . ' - ' . config('app.name')); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.2.3/css/flag-icons.min.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="relative py-20 bg-gradient-to-br from-slate-50 via-blue-50/30 to-cyan-50/20 dark:from-slate-950 dark:via-blue-950/30 dark:to-cyan-950/20 min-h-screen">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 <?php echo e(app()->getLocale() == 'ar' ? 'left-0' : 'right-0'); ?> w-96 h-96 bg-gradient-to-br from-blue-400/10 to-cyan-400/5 rounded-full blur-3xl animate-float"></div>
        <div class="absolute -bottom-40 <?php echo e(app()->getLocale() == 'ar' ? 'right-0' : 'left-0'); ?> w-96 h-96 bg-gradient-to-tr from-cyan-400/10 to-blue-400/5 rounded-full blur-3xl animate-float animation-delay-2000"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-6xl mx-auto">
            <!-- Page Header -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center gap-2 px-5 py-2 bg-gradient-to-r from-blue-500/10 to-cyan-500/10 dark:from-blue-500/20 dark:to-cyan-500/20 backdrop-blur-sm rounded-full mb-6 border border-blue-200/50 dark:border-blue-700/50">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                    </svg>
                    <span class="text-sm font-bold text-blue-900 dark:text-blue-100">
                        <?php echo e(__('frontend.configure_product')); ?>

                    </span>
                </div>
                <h1 class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-4">
                    <?php echo e($product->name); ?>

                </h1>
                <p class="text-xl text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
                    <?php echo e(__('frontend.customize_your_hosting_plan')); ?>

                </p>
            </div>

            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Configuration Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white/90 dark:bg-slate-800/90 backdrop-blur-sm rounded-2xl shadow-xl p-8 border border-slate-200/50 dark:border-slate-700/50">
                        <form id="configure-form" action="<?php echo e(route('cart.add-hosting')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">

                            <!-- Error Messages -->
                            <?php if($errors->any()): ?>
                            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-red-600 dark:text-red-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-red-800 dark:text-red-200 mb-1"><?php echo e(__('frontend.error')); ?></h3>
                                        <ul class="text-sm text-red-700 dark:text-red-300 space-y-1">
                                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($error); ?></li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Domain Selection -->
                            <div class="mb-8">
                                <label class="block text-lg font-bold text-slate-900 dark:text-white mb-4">
                                    <svg class="w-5 h-5 inline-block <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                    </svg>
                                    <?php echo e(__('frontend.choose_domain')); ?>

                                </label>
                                
                                <div class="space-y-4">
                                    <!-- New Domain Name -->
                                    <label class="flex items-start p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl border-2 border-slate-200 dark:border-slate-600 cursor-pointer hover:border-blue-500 dark:hover:border-blue-500 transition-colors has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                                        <input type="radio" name="domain_option" value="new" class="mt-1 w-4 h-4 text-blue-600" checked onchange="toggleDomainOptions()">
                                        <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3'); ?> flex-1">
                                            <div class="font-bold text-slate-900 dark:text-white mb-1">
                                                <?php echo e(__('frontend.new_domain_name')); ?>

                                            </div>
                                            <div class="text-sm text-slate-600 dark:text-slate-400">
                                                <?php echo e(__('frontend.new_domain_name_desc')); ?>

                                            </div>
                                        </div>
                                    </label>

                                    <!-- Existing Domain Name -->
                                    <label class="flex items-start p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl border-2 border-slate-200 dark:border-slate-600 cursor-pointer hover:border-blue-500 dark:hover:border-blue-500 transition-colors has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                                        <input type="radio" name="domain_option" value="existing" class="mt-1 w-4 h-4 text-blue-600" onchange="toggleDomainOptions()">
                                        <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3'); ?> flex-1">
                                            <div class="font-bold text-slate-900 dark:text-white mb-1">
                                                <?php echo e(__('frontend.existing_domain_name')); ?>

                                            </div>
                                            <div class="text-sm text-slate-600 dark:text-slate-400">
                                                <?php echo e(__('frontend.existing_domain_name_desc')); ?>

                                            </div>
                                        </div>
                                    </label>
                                </div>

                                <!-- New Domain Options -->
                                <div id="new-domain-options" class="mt-4 space-y-4">
                                    <!-- Already in Cart or New Purchase -->
                                    <div class="grid grid-cols-2 gap-4">
                                        <label class="relative">
                                            <input type="radio" name="new_domain_type" value="in_cart" class="peer sr-only" checked onchange="toggleNewDomainType()">
                                            <div class="p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl border-2 border-slate-200 dark:border-slate-600 cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 transition-all hover:border-blue-400">
                                                <div class="text-center">
                                                    <div class="font-bold text-slate-900 dark:text-white mb-1">
                                                        <?php echo e(__('frontend.already_in_cart')); ?>

                                                    </div>
                                                    <div class="text-xs text-slate-600 dark:text-slate-400">
                                                        <?php echo e(__('frontend.select_from_cart')); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </label>

                                        <label class="relative">
                                            <input type="radio" name="new_domain_type" value="new_purchase" class="peer sr-only" onchange="toggleNewDomainType()">
                                            <div class="p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl border-2 border-slate-200 dark:border-slate-600 cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 transition-all hover:border-blue-400">
                                                <div class="text-center">
                                                    <div class="font-bold text-slate-900 dark:text-white mb-1">
                                                        <?php echo e(__('frontend.new_purchase')); ?>

                                                    </div>
                                                    <div class="text-xs text-slate-600 dark:text-slate-400">
                                                        <?php echo e(__('frontend.search_new_domain')); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>

                                    <!-- Domains in Cart Dropdown -->
                                    <div id="domains-in-cart" class="mt-4">
                                        <?php
                                            $cart = Session::get('cart', []);
                                            $domainsInCart = array_filter($cart, function($item) {
                                                return isset($item['type']) && $item['type'] === 'domain';
                                            });
                                        ?>
                                        
                                        <?php if(count($domainsInCart) > 0): ?>
                                            <label class="block text-sm font-bold text-slate-600 dark:text-slate-400 mb-2">
                                                <?php echo e(__('frontend.select_domain_from_cart')); ?>

                                            </label>
                                            <select name="cart_domain" id="cart-domain-select" class="w-full px-4 py-3 bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-slate-900 dark:text-white">
                                                <option value=""><?php echo e(__('frontend.select_domain')); ?></option>
                                                <?php $__currentLoopData = $domainsInCart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $domain): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($domain['domain']); ?>" 
                                                            data-tld="<?php echo e($domain['tld']); ?>" 
                                                            data-price="<?php echo e($domain['price'] ?? 0); ?>">
                                                        <?php echo e($domain['domain']); ?> (<?php echo e($domain['tld']); ?>)
                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        <?php else: ?>
                                            <div class="p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg">
                                                <p class="text-sm text-amber-800 dark:text-amber-200 flex items-center gap-2">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                    </svg>
                                                    <?php echo e(__('frontend.no_domains_in_cart')); ?>

                                                </p>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Search for New Domain -->
                                    <div id="search-new-domain" class="mt-4 hidden">
                                        <label class="block text-sm font-bold text-slate-600 dark:text-slate-400 mb-2">
                                            <?php echo e(__('frontend.find_a_domain_name')); ?>

                                        </label>
                                        <div class="flex gap-2">
                                            <input type="text" id="domain-search" placeholder="<?php echo e(__('frontend.enter_domain_to_search')); ?>" class="flex-1 px-4 py-3 bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-slate-900 dark:text-white">
                                            <button type="button" id="domain-search-btn" onclick="searchDomain()" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-bold rounded-lg transition-all">
                                                <?php echo e(__('frontend.search')); ?>

                                            </button>
                                        </div>
                                        
                                        <!-- Free Domain Notice -->
                                        <?php if(isset($product->free_domain_config) && !empty($product->free_domain_config)): ?>
                                        <div class="mt-3 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                                            <p class="text-sm text-green-800 dark:text-green-200 flex items-center gap-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <span>
                                                    <?php echo e(__('frontend.free_domain_available')); ?>

                                                    <strong>
                                                        <?php if(isset($product->free_domain_config['tlds'])): ?>
                                                            <?php echo e(implode(', ', array_map(fn($tld) => '.' . $tld, $product->free_domain_config['tlds']))); ?>

                                                        <?php endif; ?>
                                                    </strong>
                                                    <?php echo e(__('frontend.for_billing_cycles')); ?>

                                                    <strong>
                                                        <?php if(isset($product->free_domain_config['terms'])): ?>
                                                            <?php echo e(implode(', ', array_map(fn($term) => __('frontend.' . $term), $product->free_domain_config['terms']))); ?>

                                                        <?php endif; ?>
                                                    </strong>
                                                </span>
                                            </p>
                                        </div>
                                        <?php endif; ?>
                                        
                                        <!-- Search Results -->
                                        <div id="domain-search-results" class="mt-4 hidden"></div>
                                    </div>
                                </div>

                                <!-- Existing Domain Input -->
                                <div id="existing-domain-input" class="mt-4 hidden">
                                    <label class="block text-sm font-bold text-slate-600 dark:text-slate-400 mb-2">
                                        <?php echo e(__('frontend.enter_your_domain')); ?>

                                    </label>
                                    <div class="relative">
                                        <input type="text" name="existing_domain" id="existing-domain" placeholder="example.com" class="w-full px-4 py-3 pr-12 bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-slate-900 dark:text-white">
                                        <!-- Loading spinner inside input -->
                                        <div id="existing-domain-loader" class="hidden absolute right-3 top-1/2 -translate-y-1/2">
                                            <svg class="animate-spin h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="mt-2 text-xs text-slate-600 dark:text-slate-400">
                                        <?php echo e(__('frontend.existing_domain_note')); ?>

                                    </p>
                                    
                                    <!-- Verification Results for Existing Domain -->
                                    <div id="existing-domain-results" class="mt-3 hidden"></div>
                                </div>

                                <!-- Hidden input for selected domain -->
                                <input type="hidden" name="domain" id="selected-domain">
                                <input type="hidden" name="domain_price" id="domain-price" value="0">
                                <input type="hidden" name="domain_tld" id="domain-tld">
                            </div>

                            <!-- Billing Cycle -->
                            <div class="mb-8">
                                <label class="block text-lg font-bold text-slate-900 dark:text-white mb-4">
                                    <svg class="w-5 h-5 inline-block <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <?php echo e(__('frontend.billing_cycle')); ?>

                                </label>
                                
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <?php
                                        $pricingData = $product->pricing['recurring'] ?? [];
                                        
                                        // ترتيب دورات الفوترة
                                        $cycleOrder = [
                                            'monthly' => 1,
                                            'quarterly' => 2,
                                            'semi_annually' => 3,
                                            'semiannually' => 3,
                                            'annually' => 4,
                                            'biennially' => 5,
                                            'triennially' => 6
                                        ];
                                        
                                        // ترتيب البيانات حسب الترتيب المحدد
                                        uksort($pricingData, function($a, $b) use ($cycleOrder) {
                                            $orderA = $cycleOrder[$a] ?? 999;
                                            $orderB = $cycleOrder[$b] ?? 999;
                                            return $orderA - $orderB;
                                        });
                                        
                                        $availableCycles = array_keys($pricingData);
                                        $firstCycle = !empty($availableCycles) ? $availableCycles[0] : 'monthly';
                                    ?>
                                    
                                    <?php $__currentLoopData = $pricingData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cycle => $cycleData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $price = $cycleData['price'] ?? 0;
                                            $setupFee = $cycleData['setup_fee'] ?? 0;
                                        ?>
                                        <label class="relative">
                                            <input type="radio" name="billing_cycle" value="<?php echo e($cycle); ?>" data-price="<?php echo e($price); ?>" data-setup="<?php echo e($setupFee); ?>" class="peer sr-only" <?php echo e($cycle == $firstCycle ? 'checked' : ''); ?> onchange="updatePrice()">
                                            <div class="p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl border-2 border-slate-200 dark:border-slate-600 cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 transition-all hover:border-blue-400">
                                                <div class="text-center">
                                                    <div class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">
                                                        <?php echo e(__('frontend.' . $cycle)); ?>

                                                    </div>
                                                    <div class="text-xl font-bold text-slate-900 dark:text-white">
                                                        $<?php echo e(number_format($price, 2)); ?>

                                                    </div>
                                                    <?php if($setupFee > 0): ?>
                                                        <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                                            +$<?php echo e(number_format($setupFee, 2)); ?> <?php echo e(__('frontend.setup')); ?>

                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </label>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>

                            <!-- Data Center Location -->
                            <?php if(isset($product->datacenter_locations) && !empty($product->datacenter_locations)): ?>
                            <div class="mb-8">
                                <label class="block text-lg font-bold text-slate-900 dark:text-white mb-4">
                                    <svg class="w-5 h-5 inline-block <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <?php echo e(__('frontend.datacenter_location')); ?>

                                </label>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <?php
                                        $datacenterLocations = $product->datacenter_locations;
                                        $datacenterPrices = $product->datacenter_price ?? [];
                                        $firstDatacenter = !empty($datacenterLocations) ? $datacenterLocations[0] : null;
                                        
                                        // Define datacenter details with flag-icon codes
                                        $datacenterInfo = [
                                            'us-east' => ['name' => 'United States (East)', 'flag' => 'us', 'country' => 'USA'],
                                            'us-west' => ['name' => 'United States (West)', 'flag' => 'us', 'country' => 'USA'],
                                            'eu-west' => ['name' => 'Europe (West)', 'flag' => 'eu', 'country' => 'Europe'],
                                            'eu-central' => ['name' => 'Europe (Central)', 'flag' => 'eu', 'country' => 'Europe'],
                                            'asia-pacific' => ['name' => 'Asia Pacific', 'flag' => 'sg', 'country' => 'Asia'],
                                            'australia' => ['name' => 'Australia', 'flag' => 'au', 'country' => 'Australia'],
                                            'canada' => ['name' => 'Canada', 'flag' => 'ca', 'country' => 'Canada'],
                                            'uk' => ['name' => 'United Kingdom', 'flag' => 'gb', 'country' => 'UK'],
                                            'germany' => ['name' => 'Germany', 'flag' => 'de', 'country' => 'Germany'],
                                            'france' => ['name' => 'France', 'flag' => 'fr', 'country' => 'France'],
                                            'singapore' => ['name' => 'Singapore', 'flag' => 'sg', 'country' => 'Singapore'],
                                            'japan' => ['name' => 'Japan', 'flag' => 'jp', 'country' => 'Japan'],
                                        ];
                                    ?>
                                    
                                    <?php $__currentLoopData = $datacenterLocations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dcKey): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $dcPrice = $datacenterPrices[$dcKey] ?? 0;
                                            $dcInfo = $datacenterInfo[$dcKey] ?? ['name' => ucfirst(str_replace('-', ' ', $dcKey)), 'flag' => 'un', 'country' => ''];
                                        ?>
                                        <label class="relative cursor-pointer group">
                                            <input type="radio" name="datacenter" value="<?php echo e($dcKey); ?>" data-dc-price="<?php echo e($dcPrice); ?>" class="peer sr-only" <?php echo e($dcKey == $firstDatacenter ? 'checked' : ''); ?> onchange="updateDatacenterPrice()" required>
                                            <div class="p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl border-2 border-slate-200 dark:border-slate-600 peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 transition-all hover:border-blue-400 hover:shadow-md">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center gap-3">
                                                        <span class="fi fi-<?php echo e($dcInfo['flag']); ?> text-3xl" style="font-size: 2.5rem; line-height: 1;"></span>
                                                        <div>
                                                            <div class="font-bold text-slate-900 dark:text-white">
                                                                <?php echo e($dcInfo['name']); ?>

                                                            </div>
                                                            <?php if($dcInfo['country']): ?>
                                                                <div class="text-xs text-slate-500 dark:text-slate-400">
                                                                    <?php echo e($dcInfo['country']); ?>

                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <?php if($dcPrice > 0): ?>
                                                        <div class="text-sm font-bold text-blue-600 dark:text-blue-400">
                                                            +$<?php echo e(number_format($dcPrice, 2)); ?>/<?php echo e(__('frontend.month')); ?>

                                                        </div>
                                                    <?php else: ?>
                                                        <div class="text-xs font-bold text-green-600 dark:text-green-400">
                                                            <?php echo e(__('frontend.free')); ?>

                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </label>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- cPanel Accounts Selection (Reseller Hosting Only) -->
                            <?php if($product->enable_cpanel_tiers && $product->cpanelTiers->count() > 0): ?>
                            <div class="mb-8">
                                <label class="block text-lg font-bold text-slate-900 dark:text-white mb-4">
                                    <svg class="w-5 h-5 inline-block <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                    <?php echo e(__('frontend.cpanel_accounts')); ?>

                                </label>
                                
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                    <!-- Base Tier -->
                                    <label class="relative">
                                        <input type="radio" name="cpanel_tier" value="base" data-tier-price="0" class="peer sr-only" checked onchange="updatePrice()">
                                        <div class="p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl border-2 border-slate-200 dark:border-slate-600 cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 transition-all hover:border-blue-400">
                                            <div class="text-center">
                                                <div class="text-2xl font-bold text-slate-900 dark:text-white mb-1">
                                                    <?php echo e($product->base_cpanel_accounts); ?>

                                                </div>
                                                <div class="text-sm text-slate-600 dark:text-slate-400">
                                                    <?php echo e(__('frontend.accounts')); ?>

                                                </div>
                                                <div class="text-xs text-green-600 dark:text-green-400 font-medium mt-2">
                                                    <?php echo e(__('frontend.included')); ?>

                                                </div>
                                            </div>
                                        </div>
                                    </label>

                                    <!-- Additional Tiers -->
                                    <?php $__currentLoopData = $product->cpanelTiers->sortBy('tier'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <label class="relative">
                                            <input type="radio" 
                                                name="cpanel_tier" 
                                                value="<?php echo e($tier->id); ?>" 
                                                data-tier-price-monthly="<?php echo e($tier->monthly_price); ?>"
                                                data-tier-price-quarterly="<?php echo e($tier->quarterly_price); ?>"
                                                data-tier-price-semi-annually="<?php echo e($tier->semi_annually_price); ?>"
                                                data-tier-price-annually="<?php echo e($tier->annually_price); ?>"
                                                data-tier-price-biennially="<?php echo e($tier->biennially_price); ?>"
                                                data-tier-price-triennially="<?php echo e($tier->triennially_price); ?>"
                                                class="peer sr-only cpanel-tier-radio" 
                                                onchange="updatePrice()">
                                            <div class="p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl border-2 border-slate-200 dark:border-slate-600 cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 transition-all hover:border-blue-400">
                                                <div class="text-center">
                                                    <div class="text-2xl font-bold text-slate-900 dark:text-white mb-1">
                                                        <?php echo e($tier->tier); ?>

                                                    </div>
                                                    <div class="text-sm text-slate-600 dark:text-slate-400">
                                                        <?php echo e(__('frontend.accounts')); ?>

                                                    </div>
                                                    <div class="text-sm font-bold text-blue-600 dark:text-blue-400 mt-2">
                                                        +$<span class="tier-price-display"><?php echo e(number_format($tier->monthly_price, 2)); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Additional Options -->
                            <div class="mb-8">
                                <label class="block text-lg font-bold text-slate-900 dark:text-white mb-4">
                                    <svg class="w-5 h-5 inline-block <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                                    </svg>
                                    <?php echo e(__('frontend.additional_options')); ?>

                                </label>

                                <div class="space-y-3">
                                    <!-- SSL Certificate -->
                                    <label class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl border border-slate-200 dark:border-slate-600 cursor-pointer hover:border-blue-500 transition-colors">
                                        <div class="flex items-center gap-3">
                                            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                            </svg>
                                            <div>
                                                <div class="font-bold text-slate-900 dark:text-white">
                                                    <?php echo e(__('frontend.ssl_certificate')); ?>

                                                </div>
                                                <div class="text-sm text-green-600 dark:text-green-400 font-medium">
                                                    <?php echo e(__('frontend.free')); ?>

                                                </div>
                                            </div>
                                        </div>
                                        <input type="checkbox" name="ssl" value="1" checked disabled class="w-5 h-5 text-blue-600 rounded">
                                    </label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="sticky top-24 z-10">
                        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl p-6 border border-slate-200 dark:border-slate-700">
                            <!-- Header -->
                            <div class="flex items-center gap-3 mb-6 pb-6 border-b border-slate-200 dark:border-slate-700">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-slate-900 dark:text-white">
                                    <?php echo e(__('frontend.order_summary')); ?>

                                </h3>
                            </div>

                            <!-- Product Name -->
                            <div class="mb-4">
                                <div class="text-sm text-slate-600 dark:text-slate-400 mb-1">
                                    <?php echo e(__('frontend.product')); ?>

                                </div>
                                <div class="text-lg font-bold text-slate-900 dark:text-white">
                                    <?php echo e($product->name); ?>

                                </div>
                            </div>

                            <!-- Price Breakdown -->
                            <div class="space-y-3 mb-6 pb-6 border-b border-slate-200 dark:border-slate-700">
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-600 dark:text-slate-400"><?php echo e(__('frontend.setup_fee')); ?></span>
                                    <span class="font-bold text-slate-900 dark:text-white" id="setup-display"><?php echo e(__('frontend.free')); ?></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-600 dark:text-slate-400"><?php echo e(__('frontend.hosting_price')); ?></span>
                                    <span class="font-bold text-slate-900 dark:text-white" id="price-display">
                                        <?php
                                            $pricingData = $product->pricing['recurring'] ?? [];
                                            $firstCycle = !empty($pricingData) ? array_key_first($pricingData) : null;
                                            $firstPrice = $firstCycle ? ($pricingData[$firstCycle]['price'] ?? 0) : 0;
                                        ?>
                                        $<?php echo e(number_format($firstPrice, 2)); ?>

                                    </span>
                                </div>
                                
                                <!-- Domain (Hidden by default, shown when selected) -->
                                <div class="flex justify-between items-center hidden" id="domain-summary-row">
                                    <div class="flex flex-col">
                                        <span class="text-slate-600 dark:text-slate-400"><?php echo e(__('frontend.domain')); ?></span>
                                        <span class="text-xs text-slate-500 dark:text-slate-500" id="domain-name-display"></span>
                                    </div>
                                    <span class="font-bold text-slate-900 dark:text-white" id="domain-price-display">$0.00</span>
                                </div>
                            </div>

                            <!-- Total -->
                            <div class="mb-6 p-4 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl">
                                <div class="flex justify-between items-center">
                                    <span class="text-white/90 text-sm font-medium"><?php echo e(__('frontend.total_today')); ?></span>
                                    <span class="text-2xl font-black text-white" id="total-display">
                                        <?php
                                            $firstSetup = $firstCycle ? ($pricingData[$firstCycle]['setup_fee'] ?? 0) : 0;
                                            $firstTotal = $firstPrice + $firstSetup;
                                        ?>
                                        $<?php echo e(number_format($firstTotal, 2)); ?>

                                    </span>
                                </div>
                            </div>

                            <!-- Add to Cart Button -->
                            <button type="submit" form="configure-form" class="w-full py-4 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 mb-3">
                                <?php echo e(__('frontend.add_to_cart')); ?>

                            </button>

                            <a href="<?php echo e(route('hosting.shared')); ?>" class="block w-full py-3 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-900 dark:text-white text-center font-bold rounded-xl transition-all duration-300">
                                <?php echo e(__('frontend.back_to_plans')); ?>

                            </a>

                            <!-- Trust Badges -->
                            <div class="mt-6 pt-6 border-t border-slate-200 dark:border-slate-700 space-y-2">
                                <div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span><?php echo e(__('frontend.secure_checkout')); ?></span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    <span><?php echo e(__('frontend.ssl_encrypted')); ?></span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span><?php echo e(__('frontend.money_back_guarantee')); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $__env->startPush('styles'); ?>
<style>
@keyframes float {
    0%, 100% {
        transform: translateY(0) translateX(0);
    }
    25% {
        transform: translateY(-20px) translateX(10px);
    }
    50% {
        transform: translateY(-10px) translateX(-10px);
    }
    75% {
        transform: translateY(-15px) translateX(5px);
    }
}

.animate-float {
    animation: float 20s ease-in-out infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Free domain configuration from product
const freeDomainConfig = <?php echo json_encode($product->free_domain_config ?? null, 15, 512) ?>;
const productId = <?php echo e($product->id); ?>;

// Server nameservers configuration
<?php
    $serverNameserversData = [
        'nameserver1' => optional($product->server)->nameserver1,
        'nameserver2' => optional($product->server)->nameserver2,
        'nameserver3' => optional($product->server)->nameserver3,
        'nameserver4' => optional($product->server)->nameserver4,
    ];
?>
const serverNameservers = <?php echo json_encode($serverNameserversData, 15, 512) ?>;

// Translations for JavaScript
const translations = {
    domainVerified: '<?php echo e(__('frontend.domain_verified_existing')); ?>',
    dnsNameserversPoint: '<?php echo e(__('frontend.dns_nameservers_point')); ?>'
};

// Store domain search results globally
let currentSearchResults = [];
let currentSearchedDomain = '';

function toggleDomainOptions() {
    const domainOption = document.querySelector('input[name="domain_option"]:checked').value;
    const newDomainOptions = document.getElementById('new-domain-options');
    const existingDomainInput = document.getElementById('existing-domain-input');
    
    // Reset domain selection in hidden fields
    document.getElementById('selected-domain').value = '';
    document.getElementById('domain-price').value = '0';
    document.getElementById('domain-tld').value = '';
    
    // Hide domain in Order Summary when changing options
    const domainRow = document.getElementById('domain-summary-row');
    if (domainRow) {
        domainRow.classList.add('hidden');
    }
    
    if (domainOption === 'new') {
        newDomainOptions.classList.remove('hidden');
        existingDomainInput.classList.add('hidden');
        toggleNewDomainType(); // Initialize new domain type
    } else {
        newDomainOptions.classList.add('hidden');
        existingDomainInput.classList.remove('hidden');
    }
    
    updatePrice();
}

function toggleNewDomainType() {
    const newDomainType = document.querySelector('input[name="new_domain_type"]:checked').value;
    const domainsInCart = document.getElementById('domains-in-cart');
    const searchNewDomain = document.getElementById('search-new-domain');
    
    // Reset domain selection when switching type
    document.getElementById('selected-domain').value = '';
    document.getElementById('domain-price').value = '0';
    document.getElementById('domain-tld').value = '';
    
    // Hide domain in Order Summary
    const domainRow = document.getElementById('domain-summary-row');
    if (domainRow) {
        domainRow.classList.add('hidden');
    }
    
    if (newDomainType === 'in_cart') {
        domainsInCart.classList.remove('hidden');
        searchNewDomain.classList.add('hidden');
    } else {
        domainsInCart.classList.add('hidden');
        searchNewDomain.classList.remove('hidden');
    }
    
    updatePrice();
}

function searchDomain() {
    const searchInput = document.getElementById('domain-search');
    const domain = searchInput.value.trim();
    
    if (!domain) {
        alert('<?php echo e(__('frontend.please_enter_domain')); ?>');
        return;
    }
    
    const resultsDiv = document.getElementById('domain-search-results');
    resultsDiv.innerHTML = '<div class="text-center py-4"><svg class="animate-spin h-8 w-8 mx-auto text-blue-600" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></div>';
    resultsDiv.classList.remove('hidden');
    
    // Call domain search API
    fetch('<?php echo e(route('domains.check')); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        },
        body: JSON.stringify({ domain: domain })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Store results globally for re-rendering on billing cycle change
            currentSearchResults = data.results;
            currentSearchedDomain = domain;
            displayDomainResults(data.results, domain);
        } else {
            resultsDiv.innerHTML = `<div class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg text-red-800 dark:text-red-200">${data.message}</div>`;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        resultsDiv.innerHTML = '<div class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg text-red-800 dark:text-red-200"><?php echo e(__('frontend.error_occurred')); ?></div>';
    });
}

function displayDomainResults(results, searchedDomain) {
    const resultsDiv = document.getElementById('domain-search-results');
    const selectedCycle = document.querySelector('input[name="billing_cycle"]:checked').value;
    
    let html = '<div class="space-y-3">';
    
    results.forEach(result => {
        const tld = result.tld;
        const price = parseFloat(result.registration) || 0;
        const isFree = checkIfDomainIsFree(tld, selectedCycle);
        const displayPrice = isFree ? 0 : price;
        
        // Check if free domain is for first year only (biennially or triennially)
        const isMultiYear = ['biennially', 'triennially'].includes(selectedCycle);
        const showFirstYearNote = isFree && isMultiYear;
        
        if (result.available) {
            const priceColor = isFree ? 'text-green-600 dark:text-green-400 font-bold' : 'text-slate-500';
            const priceText = '<span class="' + priceColor + '">$' + displayPrice.toFixed(2) + '/<?php echo e(__('frontend.year')); ?></span>';
            
            // Build note for first year only
            let noteHtml = '';
            if (showFirstYearNote) {
                noteHtml = '<div class="text-xs text-amber-600 dark:text-amber-400 mt-1 flex items-center gap-1">' +
                    '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">' +
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>' +
                    '</svg>' +
                    '<span><?php echo e(__('frontend.free_first_year_only')); ?></span>' +
                    '</div>';
            }
            
            html += `
                <div class="p-4 bg-white dark:bg-slate-800 rounded-lg border-2 border-slate-200 dark:border-slate-700 hover:border-blue-500 transition-colors">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="font-bold text-slate-900 dark:text-white">` + result.domain + `</div>
                            <div class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                                ` + priceText + `
                                ` + noteHtml + `
                            </div>
                        </div>
                        <button type="button" onclick="selectDomain('` + result.domain + `', ` + displayPrice + `, '` + tld + `')" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-bold rounded-lg transition-all">
                            <?php echo e(__('frontend.select')); ?>

                        </button>
                    </div>
                </div>
            `;
        } else {
            html += `
                <div class="p-4 bg-slate-50 dark:bg-slate-900/50 rounded-lg border border-slate-200 dark:border-slate-700 opacity-50">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="font-bold text-slate-600 dark:text-slate-400">` + result.domain + `</div>
                            <div class="text-sm text-red-600 dark:text-red-400"><?php echo e(__('frontend.unavailable')); ?></div>
                        </div>
                        <span class="text-slate-400"><?php echo e(__('frontend.taken')); ?></span>
                    </div>
                </div>
            `;
        }
    });
    
    html += '</div>';
    resultsDiv.innerHTML = html;
}

function checkIfDomainIsFree(tld, billingCycle) {
    if (!freeDomainConfig) return false;
    
    // Check if TLD is in free domain list
    const freeTlds = freeDomainConfig.tlds || [];
    if (!freeTlds.includes(tld)) return false;
    
    // Check if billing cycle qualifies for free domain
    const freeTerms = freeDomainConfig.terms || [];
    if (!freeTerms.includes(billingCycle)) return false;
    
    return true;
}

// Add domain to cart via AJAX
function addDomainToCart(domain, price, tld) {
    fetch('<?php echo e(route('cart.add-domain')); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        },
        body: JSON.stringify({
            domain: domain,
            tld: tld,
            price: price,
            renewal_price: price,
            type: 'register' // Domain registration
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Domain added to cart:', domain);
            // Update cart count in header if exists
            const cartCountElements = document.querySelectorAll('.cart-count');
            if (cartCountElements.length > 0 && data.cartCount) {
                cartCountElements.forEach(el => {
                    el.textContent = data.cartCount;
                });
            }
        } else {
            console.error('Failed to add domain to cart:', data.message);
            // Show error message to user
            alert(data.message || '<?php echo e(__('frontend.error_occurred')); ?>');
        }
    })
    .catch(error => {
        console.error('Error adding domain to cart:', error);
        alert('<?php echo e(__('frontend.error_occurred')); ?>');
    });
}

function selectDomain(domain, price, tld) {
    console.log('Domain selected:', domain); // Debug log
    
    document.getElementById('selected-domain').value = domain;
    document.getElementById('domain-price').value = price;
    document.getElementById('domain-tld').value = tld;
    
    // Add domain to cart immediately
    addDomainToCart(domain, price, tld);
    
    // Update search input and disable it
    const searchInput = document.getElementById('domain-search');
    const searchBtn = document.getElementById('domain-search-btn');
    searchInput.value = domain;
    searchInput.disabled = true;
    searchInput.classList.add('opacity-50', 'cursor-not-allowed');
    
    // Disable search button
    if (searchBtn) {
        searchBtn.disabled = true;
        searchBtn.classList.add('opacity-50', 'cursor-not-allowed');
    }
    
    // Update Order Summary with domain info
    const domainRow = document.getElementById('domain-summary-row');
    const domainNameDisplay = document.getElementById('domain-name-display');
    const domainPriceDisplay = document.getElementById('domain-price-display');
    
    domainRow.classList.remove('hidden');
    domainNameDisplay.textContent = domain;
    
    // Format price display with FREE badge if price is 0
    if (price === 0 || price === '0') {
        domainPriceDisplay.innerHTML = '<span class="text-green-600 dark:text-green-400"><?php echo e(__('frontend.free')); ?></span>';
    } else {
        domainPriceDisplay.textContent = '$' + parseFloat(price).toFixed(2);
    }
    
    // Hide all search results immediately and show selected domain card with remove button (Updated v2)
    const resultsDiv = document.getElementById('domain-search-results');
    
    // Clear existing content first - use textContent first to force DOM update
    resultsDiv.textContent = '';
    
    // Force a reflow
    void resultsDiv.offsetWidth;
    
    const priceDisplay = price === 0 || price === '0' 
        ? '<span class="text-green-600 dark:text-green-400 font-bold"><?php echo e(__('frontend.free')); ?></span>'
        : '<span class="text-slate-900 dark:text-white">$' + parseFloat(price).toFixed(2) + '/<?php echo e(__('frontend.year')); ?></span>';
    
    // Set new content - this replaces ALL previous results immediately
    const selectedHtml = '<div class="p-4 bg-green-50 dark:bg-green-900/20 border-2 border-green-500 dark:border-green-600 rounded-lg animate-fade-in">' +
        '<div class="flex items-center justify-between">' +
            '<div class="flex-1">' +
                '<div class="flex items-center gap-2 text-green-800 dark:text-green-200">' +
                    '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">' +
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>' +
                    '</svg>' +
                    '<span class="font-bold">' + domain + '</span>' +
                '</div>' +
                '<div class="text-sm mt-1 text-slate-600 dark:text-slate-300">' +
                    priceDisplay +
                '</div>' +
            '</div>' +
            '<button type="button" onclick="removeDomain()" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg transition-all flex items-center gap-2">' +
                '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">' +
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>' +
                '</svg>' +
                '<?php echo e(__("frontend.remove_from_cart")); ?>' +
            '</button>' +
        '</div>' +
    '</div>';
    
    // Use setTimeout to ensure DOM is updated
    setTimeout(function() {
        resultsDiv.innerHTML = selectedHtml;
        resultsDiv.classList.remove('hidden');
        
        // Scroll into view to show the selected domain
        resultsDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }, 0);
    
    // Update total price
    updatePrice();
}

function removeDomain() {
    // Clear hidden fields
    document.getElementById('selected-domain').value = '';
    document.getElementById('domain-price').value = 0;
    document.getElementById('domain-tld').value = '';
    
    // Re-enable search input and clear it
    const searchInput = document.getElementById('domain-search');
    const searchBtn = document.getElementById('domain-search-btn');
    searchInput.value = '';
    searchInput.disabled = false;
    searchInput.classList.remove('opacity-50', 'cursor-not-allowed');
    
    // Re-enable search button
    if (searchBtn) {
        searchBtn.disabled = false;
        searchBtn.classList.remove('opacity-50', 'cursor-not-allowed');
    }
    
    // Hide domain row in Order Summary
    const domainRow = document.getElementById('domain-summary-row');
    domainRow.classList.add('hidden');
    
    // Clear search results
    const resultsDiv = document.getElementById('domain-search-results');
    resultsDiv.innerHTML = '';
    resultsDiv.classList.add('hidden');
    
    // Clear stored search results
    currentSearchResults = [];
    currentSearchedDomain = '';
    
    // Update total price
    updatePrice();
}

function updateDatacenterPrice() {
    updatePrice();
}

function updatePrice() {
    const selectedCycle = document.querySelector('input[name="billing_cycle"]:checked');
    let price = parseFloat(selectedCycle.dataset.price) || 0;
    const setupFee = parseFloat(selectedCycle.dataset.setup) || 0;
    
    // Re-calculate domain price based on new billing cycle (if domain is selected)
    const selectedDomain = document.getElementById('selected-domain').value;
    const selectedTld = document.getElementById('domain-tld').value;
    let domainPrice = 0;
    let isCartDomain = false; // Flag to check if domain is from cart
    
    if (selectedDomain && selectedTld) {
        // Check if it's the special FROM_CART marker
        if (selectedTld === 'FROM_CART') {
            domainPrice = 0; // Already in cart, don't add to total
            isCartDomain = true;
        }
        // Check if domain is from search results
        else if (currentSearchResults.length > 0) {
            const domainResult = currentSearchResults.find(r => r.domain === selectedDomain);
            if (domainResult) {
                const originalPrice = parseFloat(domainResult.registration) || 0;
                const isFree = checkIfDomainIsFree(selectedTld, selectedCycle.value);
                domainPrice = isFree ? 0 : originalPrice;
                // Update hidden field
                document.getElementById('domain-price').value = domainPrice;
            }
        } 
        // Check if domain is from cart
        else {
            const cartDomainSelect = document.getElementById('cart-domain-select');
            if (cartDomainSelect && cartDomainSelect.value === selectedDomain) {
                const selectedOption = cartDomainSelect.options[cartDomainSelect.selectedIndex];
                const originalPrice = parseFloat(selectedOption.dataset.price) || 0;
                const isFree = checkIfDomainIsFree(selectedTld, selectedCycle.value);
                domainPrice = isFree ? 0 : originalPrice;
                isCartDomain = true; // Mark as cart domain
                // Update hidden field
                document.getElementById('domain-price').value = domainPrice;
            } else {
                domainPrice = parseFloat(document.getElementById('domain-price').value) || 0;
            }
        }
    } else {
        domainPrice = parseFloat(document.getElementById('domain-price').value) || 0;
    }
    
    // Get datacenter price
    let datacenterPrice = 0;
    const selectedDatacenter = document.querySelector('input[name="datacenter"]:checked');
    if (selectedDatacenter) {
        const dcPricePerMonth = parseFloat(selectedDatacenter.dataset.dcPrice) || 0;
        
        // Calculate datacenter price based on billing cycle
        const billingCycle = selectedCycle.value;
        const months = {
            'monthly': 1,
            'quarterly': 3,
            'semi_annually': 6,
            'semiannually': 6,
            'annually': 12,
            'biennially': 24,
            'triennially': 36
        };
        
        const cycleMonths = months[billingCycle] || 1;
        datacenterPrice = dcPricePerMonth * cycleMonths;
    }
    
    // Get cPanel tier price (Reseller Hosting only)
    let cpanelTierPrice = 0;
    const selectedTier = document.querySelector('input[name="cpanel_tier"]:checked');
    if (selectedTier && selectedTier.value !== 'base') {
        const billingCycle = selectedCycle.value;
        const tierPriceAttr = 'tierPrice' + billingCycle.charAt(0).toUpperCase() + billingCycle.slice(1).replace('_', '');
        cpanelTierPrice = parseFloat(selectedTier.dataset[tierPriceAttr]) || 0;
        
        // Update tier price display in the selected tier card
        const tierPriceDisplay = selectedTier.closest('label').querySelector('.tier-price-display');
        if (tierPriceDisplay) {
            tierPriceDisplay.textContent = cpanelTierPrice.toFixed(2);
        }
    }
    
    // Update all tier price displays based on current billing cycle
    const allTierRadios = document.querySelectorAll('.cpanel-tier-radio');
    allTierRadios.forEach(function(radio) {
        const billingCycle = selectedCycle.value;
        let priceAttr = 'tierPrice';
        
        // Map billing cycle to data attribute
        const cycleMap = {
            'monthly': 'Monthly',
            'quarterly': 'Quarterly',
            'semi_annually': 'SemiAnnually',
            'semiannually': 'SemiAnnually',
            'annually': 'Annually',
            'biennially': 'Biennially',
            'triennially': 'Triennially'
        };
        
        priceAttr += cycleMap[billingCycle] || 'Monthly';
        const tierPrice = parseFloat(radio.dataset[priceAttr]) || 0;
        
        const tierPriceDisplay = radio.closest('label').querySelector('.tier-price-display');
        if (tierPriceDisplay) {
            tierPriceDisplay.textContent = tierPrice.toFixed(2);
        }
    });
    
    // Calculate total - don't add domain price if it's from cart (will be paid separately in cart)
    const totalPrice = price + setupFee + (isCartDomain ? 0 : domainPrice) + datacenterPrice + cpanelTierPrice;
    
    // Update displays
    document.getElementById('price-display').textContent = '$' + (price + datacenterPrice + cpanelTierPrice).toFixed(2);
    document.getElementById('setup-display').textContent = setupFee > 0 ? '$' + setupFee.toFixed(2) : '<?php echo e(__('frontend.free')); ?>';
    document.getElementById('total-display').textContent = '$' + totalPrice.toFixed(2);
    
    // Update domain price display in Order Summary if domain is selected
    if (selectedDomain) {
        const domainPriceDisplay = document.getElementById('domain-price-display');
        
        // Check if it's an existing domain (special case)
        if (selectedTld === 'EXISTING') {
            domainPriceDisplay.innerHTML = '<span class="text-slate-600 dark:text-slate-400"><?php echo e(__('frontend.existing')); ?></span>';
        }
        // Check if domain is from cart (using FROM_CART marker)
        else if (selectedTld === 'FROM_CART' || isCartDomain) {
            // Get cart domain details
            const cartDomainSelect = document.getElementById('cart-domain-select');
            if (cartDomainSelect && cartDomainSelect.value === selectedDomain) {
                const selectedOption = cartDomainSelect.options[cartDomainSelect.selectedIndex];
                const originalPrice = parseFloat(selectedOption.dataset.price) || 0;
                
                // If original price was 0, it's already paid in cart
                if (originalPrice === 0) {
                    domainPriceDisplay.innerHTML = '<span class="text-blue-600 dark:text-blue-400"><?php echo e(__('frontend.in_cart')); ?></span>';
                } 
                // Re-check if domain qualifies for free domain with current billing cycle
                else {
                    const cartDomainTld = selectedOption.dataset.tld;
                    const currentCycle = selectedCycle.value;
                    const isFreeNow = checkIfDomainIsFree(cartDomainTld, currentCycle);
                    
                    if (isFreeNow) {
                        // Domain will be FREE with hosting plan - show only "مجاني"
                        domainPriceDisplay.innerHTML = '<span class="text-green-600 dark:text-green-400 font-bold"><?php echo e(__('frontend.free')); ?></span>';
                    } else {
                        // Domain has a price in cart - show "من السلة"
                        domainPriceDisplay.innerHTML = '<span class="text-blue-600 dark:text-blue-400"><?php echo e(__('frontend.from_cart')); ?></span>';
                    }
                }
            }
        }
        // Domain is free (from search, not from cart)
        else if (domainPrice === 0) {
            domainPriceDisplay.innerHTML = '<span class="text-green-600 dark:text-green-400 font-bold"><?php echo e(__('frontend.free')); ?></span>';
        } 
        // Domain has a price (from search)
        else {
            domainPriceDisplay.textContent = '$' + domainPrice.toFixed(2);
        }
    }
    
    // Re-render domain search results ONLY if they exist AND no domain is selected yet
    const selectedDomainValue = document.getElementById('selected-domain').value;
    if (currentSearchResults.length > 0 && !selectedDomainValue) {
        displayDomainResults(currentSearchResults, currentSearchedDomain);
    }
}

// Handle cart domain selection
document.addEventListener('DOMContentLoaded', function() {
    toggleDomainOptions();
    updatePrice();
    
    // Cart domain select
    const cartDomainSelect = document.getElementById('cart-domain-select');
    if (cartDomainSelect) {
        cartDomainSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const selectedDomain = this.value;
            
            if (selectedDomain) {
                const domainTld = selectedOption.dataset.tld;
                const originalPrice = parseFloat(selectedOption.dataset.price) || 0;
                
                // Check current billing cycle
                const selectedCycle = document.querySelector('input[name="billing_cycle"]:checked').value;
                
                // Check if domain qualifies for free domain offer
                const isFree = checkIfDomainIsFree(domainTld, selectedCycle);
                const domainPrice = isFree ? 0 : originalPrice;
                
                document.getElementById('selected-domain').value = selectedDomain;
                document.getElementById('domain-price').value = domainPrice;
                // Mark as FROM_CART so it won't be added to total
                document.getElementById('domain-tld').value = 'FROM_CART';
                
                // Update Order Summary
                const domainRow = document.getElementById('domain-summary-row');
                const domainNameDisplay = document.getElementById('domain-name-display');
                const domainPriceDisplay = document.getElementById('domain-price-display');
                
                domainRow.classList.remove('hidden');
                domainNameDisplay.textContent = selectedDomain;
                
                // Display price for cart domains
                if (originalPrice === 0) {
                    // Domain already paid in cart
                    domainPriceDisplay.innerHTML = '<span class="text-blue-600 dark:text-blue-400"><?php echo e(__('frontend.in_cart')); ?></span>';
                } else if (isFree) {
                    // Domain will be FREE with this hosting plan - show only "مجاني"
                    domainPriceDisplay.innerHTML = '<span class="text-green-600 dark:text-green-400 font-bold"><?php echo e(__('frontend.free')); ?></span>';
                } else {
                    // Domain has a price in cart - show "من السلة"
                    domainPriceDisplay.innerHTML = '<span class="text-blue-600 dark:text-blue-400"><?php echo e(__('frontend.from_cart')); ?></span>';
                }
                
                updatePrice();
            }
        });
    }
    
    // Existing domain input with real-time verification
    const existingDomainInput = document.getElementById('existing-domain');
    console.log('Existing domain input element:', existingDomainInput);
    
    if (existingDomainInput) {
        let verifyTimeout = null;
        
        existingDomainInput.addEventListener('input', function() {
            const domain = this.value.trim();
            console.log('Input event triggered, domain:', domain);
            const resultsDiv = document.getElementById('existing-domain-results');
            
            // Clear previous timeout
            if (verifyTimeout) {
                clearTimeout(verifyTimeout);
            }
            
            const loader = document.getElementById('existing-domain-loader');
            
            // Clear previous results if empty
            if (!domain) {
                resultsDiv.innerHTML = '';
                resultsDiv.classList.add('hidden');
                if (loader) loader.classList.add('hidden');
                return;
            }
            
            // Show typing indicator
            resultsDiv.classList.remove('hidden');
            resultsDiv.innerHTML = '<div class="p-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg">' +
                '<p class="text-slate-600 dark:text-slate-400 text-sm"><?php echo e(__('frontend.type_domain_name')); ?>...</p>' +
            '</div>';
            
            // Wait for user to stop typing (500ms)
            verifyTimeout = setTimeout(function() {
                console.log('Timeout triggered, validating domain:', domain);
                // Basic domain validation
                const domainRegex = /^[a-zA-Z0-9][a-zA-Z0-9-]{0,61}[a-zA-Z0-9]?\.[a-zA-Z]{2,}$/;
                const isValid = domainRegex.test(domain);
                console.log('Domain validation result:', isValid);
                
                if (isValid) {
                    console.log('Domain valid, showing loader and calling verifyExistingDomain');
                    // Show loader inside input field
                    if (loader) {
                        loader.classList.remove('hidden');
                        console.log('Loader shown');
                    }
                    verifyExistingDomain(domain);
                } else {
                    console.log('Domain invalid, showing error message');
                    resultsDiv.innerHTML = '<div class="p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">' +
                        '<p class="text-yellow-800 dark:text-yellow-200 text-sm"><?php echo e(__('frontend.invalid_domain_format')); ?></p>' +
                    '</div>';
                }
            }, 500);
        });
    }
});

// Function to verify existing domain
function verifyExistingDomain(domain) {
    console.log('verifyExistingDomain called with domain:', domain);
    const resultsDiv = document.getElementById('existing-domain-results');
    const loader = document.getElementById('existing-domain-loader');
    
    console.log('resultsDiv:', resultsDiv, 'loader:', loader);
    
    // Clear previous results and hide them during verification
    resultsDiv.innerHTML = '';
    resultsDiv.classList.add('hidden');
    
    // Check existing domain using new endpoint that also checks WHM
    console.log('Sending fetch request to /domains/check-existing');
    fetch('/domains/check-existing', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        },
        body: JSON.stringify({ domain: domain })
    })
        .then(response => {
            console.log('Response received:', response);
            console.log('Response status:', response.status, 'OK:', response.ok);
            if (!response.ok) {
                throw new Error('HTTP error! status: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log('Data received:', data);
            console.log('Data structure:', JSON.stringify(data, null, 2));
            // Hide loader
            if (loader) loader.classList.add('hidden');
            
            // Show results div
            resultsDiv.classList.remove('hidden');
            
            if (data.success && data.can_use) {
                // Domain can be used - it's registered and not in use
                document.getElementById('selected-domain').value = domain;
                document.getElementById('domain-price').value = 0;
                document.getElementById('domain-tld').value = 'EXISTING';
                
                // Update Order Summary
                const domainRow = document.getElementById('domain-summary-row');
                const domainNameDisplay = document.getElementById('domain-name-display');
                const domainPriceDisplay = document.getElementById('domain-price-display');
                
                domainRow.classList.remove('hidden');
                domainNameDisplay.textContent = domain;
                domainPriceDisplay.innerHTML = '<span class="text-slate-600 dark:text-slate-400"><?php echo e(__('frontend.existing')); ?></span>';
                
                // Build nameservers HTML
                var nameserversHtml = '';
                var hasNameservers = false;
                
                // Filter out null/empty nameservers and build HTML
                var nameserversList = [];
                if (serverNameservers.nameserver1) nameserversList.push(serverNameservers.nameserver1);
                if (serverNameservers.nameserver2) nameserversList.push(serverNameservers.nameserver2);
                if (serverNameservers.nameserver3) nameserversList.push(serverNameservers.nameserver3);
                if (serverNameservers.nameserver4) nameserversList.push(serverNameservers.nameserver4);
                
                if (nameserversList.length > 0) {
                    hasNameservers = true;
                    nameserversHtml = '<div class="mt-3 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">' +
                        '<p class="text-blue-800 dark:text-blue-200 font-bold text-xs mb-2">' + translations.dnsNameserversPoint + '</p>' +
                        '<div class="space-y-1">';
                    
                    nameserversList.forEach(function(ns) {
                        nameserversHtml += '<div class="flex items-center gap-2">' +
                            '<svg class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">' +
                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>' +
                            '</svg>' +
                            '<code class="text-xs font-mono text-blue-800 dark:text-blue-200 bg-white dark:bg-slate-800 px-2 py-1 rounded">' + ns + '</code>' +
                        '</div>';
                    });
                    
                    nameserversHtml += '</div></div>';
                }
                
                // Show success message with nameservers
                resultsDiv.innerHTML = '<div class="p-3 bg-green-50 dark:bg-green-900/20 border-2 border-green-500 dark:border-green-600 rounded-lg">' +
                    '<div class="flex items-center gap-2">' +
                        '<svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">' +
                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>' +
                        '</svg>' +
                        '<div>' +
                            '<p class="text-green-800 dark:text-green-200 font-bold text-sm">' + domain + '</p>' +
                            '<p class="text-green-700 dark:text-green-300 text-xs">' + translations.domainVerified + '</p>' +
                        '</div>' +
                    '</div>' +
                    nameserversHtml +
                '</div>';
                
                updatePrice();
            } else {
                // Domain cannot be used - show specific error message
                let errorMessage = data.message || '<?php echo e(__('frontend.error_verifying_domain')); ?>';
                let errorIcon = '';
                
                if (data.reason === 'in_use_whm' || data.reason === 'in_use_service') {
                    // Domain is already in use
                    errorIcon = '<svg class="w-5 h-5 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">' +
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>' +
                    '</svg>';
                } else if (data.reason === 'not_registered') {
                    // Domain is not registered
                    errorIcon = '<svg class="w-5 h-5 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">' +
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>' +
                    '</svg>';
                } else {
                    errorIcon = '<svg class="w-5 h-5 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">' +
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>' +
                    '</svg>';
                }
                
                resultsDiv.innerHTML = '<div class="p-3 bg-red-50 dark:bg-red-900/20 border-2 border-red-500 dark:border-red-600 rounded-lg">' +
                    '<div class="flex items-start gap-2">' +
                        errorIcon +
                        '<div>' +
                            '<p class="text-red-800 dark:text-red-200 font-bold text-sm">' + domain + '</p>' +
                            '<p class="text-red-700 dark:text-red-300 text-xs mt-1">' + errorMessage + '</p>' +
                        '</div>' +
                    '</div>' +
                '</div>';
                
                // Clear domain selection
                document.getElementById('selected-domain').value = '';
                document.getElementById('domain-price').value = 0;
                document.getElementById('domain-tld').value = '';
                
                // Hide domain from order summary
                const domainRow = document.getElementById('domain-summary-row');
                if (domainRow) domainRow.classList.add('hidden');
            }
        })
        .catch(error => {
            console.error('Error verifying domain:', error);
            console.error('Error details:', error.message, error.stack);
            // Hide loader
            if (loader) loader.classList.add('hidden');
            
            // Show results div with error
            resultsDiv.classList.remove('hidden');
            resultsDiv.innerHTML = '<div class="p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">' +
                '<p class="text-red-800 dark:text-red-200 text-sm"><?php echo e(__('frontend.error_verifying_domain')); ?></p>' +
                '<p class="text-red-700 dark:text-red-300 text-xs mt-1">Error: ' + error.message + '</p>' +
            '</div>';
        });
}

// Update price when billing cycle changes
document.addEventListener('DOMContentLoaded', function() {
    
    // Update price when billing cycle changes
    document.querySelectorAll('input[name="billing_cycle"]').forEach(input => {
        input.addEventListener('change', updatePrice);
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\resources\views/products/show.blade.php ENDPATH**/ ?>