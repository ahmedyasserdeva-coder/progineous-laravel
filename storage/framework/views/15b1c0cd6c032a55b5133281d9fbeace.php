

<?php $__env->startSection('title', __('frontend.checkout') ?? 'Checkout' . ' - ' . config('app.name')); ?>

<?php $__env->startSection('content'); ?>
<section class="py-12 bg-slate-50 dark:bg-slate-900 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-2xl font-semibold text-slate-900 dark:text-white">
                    <?php echo e(__('frontend.checkout') ?? 'Checkout'); ?>

                </h1>
                <p class="text-slate-500 dark:text-slate-400 mt-1">
                    <?php echo e(__('frontend.complete_your_order') ?? 'Complete your order securely'); ?>

                </p>
            </div>

            <form action="<?php echo e(route('cart.checkout.process')); ?>" method="POST" class="space-y-6">
                <?php echo csrf_field(); ?>
                
                <div class="grid lg:grid-cols-3 gap-6">
                    <!-- Checkout Form -->
                    <div class="lg:col-span-2 space-y-4">
                    
                        <?php if(auth()->guard('client')->guest()): ?>
                        <!-- Contact Information (للضيوف فقط) -->
                        <div class="bg-white dark:bg-slate-800 rounded-xl p-6 border border-slate-200 dark:border-slate-700">
                            <!-- Toggle between Login and Register -->
                            <div class="flex items-center justify-between mb-5">
                                <h2 class="text-lg font-semibold text-slate-900 dark:text-white flex items-center gap-3">
                                    <span class="w-7 h-7 bg-slate-900 dark:bg-white rounded-full flex items-center justify-center text-white dark:text-slate-900 text-sm font-medium">
                                        1
                                    </span>
                                    <span id="form-title"><?php echo e(__('frontend.contact_information') ?? 'Contact Information'); ?></span>
                                </h2>
                                <button type="button" id="toggle-login-form" class="text-sm text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">
                                    <?php echo e(__('frontend.already_have_account') ?? 'Already have an account?'); ?>

                                    <span class="font-medium text-slate-900 dark:text-white underline"><?php echo e(__('frontend.login') ?? 'Login'); ?></span>
                                </button>
                            </div>
                            
                            <!-- Login Form (Hidden by default) -->
                            <div id="login-form-section" class="hidden">
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                                            <?php echo e(__('frontend.email')); ?> <span class="text-red-500">*</span>
                                        </label>
                                        <input type="email" id="login_email" name="login_email" class="w-full px-3 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-slate-500 focus:border-transparent text-sm" placeholder="<?php echo e(__('frontend.enter_email') ?? 'Enter your email'); ?>">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                                            <?php echo e(__('frontend.password')); ?> <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <input type="password" id="login_password" name="login_password" class="w-full px-3 py-2.5 pr-10 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-slate-500 focus:border-transparent text-sm" placeholder="<?php echo e(__('frontend.enter_password') ?? 'Enter your password'); ?>">
                                            <button type="button" id="toggle-login-password" class="absolute right-2 top-1/2 -translate-y-1/2 p-1 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 dark:border-slate-600 text-slate-900 focus:ring-slate-500">
                                            <span class="text-sm text-slate-600 dark:text-slate-400"><?php echo e(__('frontend.remember_me') ?? 'Remember me'); ?></span>
                                        </label>
                                        <a href="<?php echo e(route('login')); ?>" class="text-sm text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white">
                                            <?php echo e(__('frontend.forgot_password') ?? 'Forgot password?'); ?>

                                        </a>
                                    </div>
                                    <button type="button" id="login-submit-btn" class="w-full py-2.5 bg-slate-900 dark:bg-white hover:bg-slate-800 dark:hover:bg-slate-100 text-white dark:text-slate-900 font-medium rounded-lg transition-colors text-sm">
                                        <span id="login-btn-text"><?php echo e(__('frontend.login_and_continue') ?? 'Login & Continue'); ?></span>
                                        <span id="login-btn-loading" class="hidden">
                                            <svg class="animate-spin h-5 w-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                        </span>
                                    </button>
                                    <p id="login-error" class="text-sm text-red-600 dark:text-red-400 hidden"></p>
                                </div>
                            </div>
                            
                            <!-- Registration Form -->
                            <div id="register-form-section" class="space-y-4">
                            
                            <!-- Validation Errors -->
                            <?php if($errors->any()): ?>
                                <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-4 mb-4">
                                    <ul class="text-sm text-red-700 dark:text-red-300 space-y-1">
                                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($error); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Username -->
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                                    <?php echo e(__('frontend.username')); ?> <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" id="username" name="username" required pattern="[A-Za-z0-9]+" minlength="3" maxlength="20" title="<?php echo e(__('frontend.username_format')); ?>" class="w-full px-3 py-2.5 pr-24 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-slate-900 dark:focus:ring-white focus:border-transparent transition-shadow" placeholder="<?php echo e(__('frontend.username_placeholder')); ?>">
                                    
                                    <!-- Generate Username Button -->
                                    <button type="button" id="generate-username" class="absolute right-12 top-1/2 -translate-y-1/2 p-2 md:p-2 text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors touch-manipulation" title="<?php echo e(__('frontend.generate_random_username')); ?>">
                                        <svg class="w-6 h-6 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                        </svg>
                                    </button>
                                    
                                    <div id="username-spinner" class="hidden absolute right-3 top-1/2 -translate-y-1/2">
                                        <svg class="animate-spin h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </div>
                                    <div id="username-check" class="hidden absolute right-3 top-1/2 -translate-y-1/2">
                                        <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <div id="username-error-icon" class="hidden absolute right-3 top-1/2 -translate-y-1/2">
                                        <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </div>
                                </div>
                                <p id="username-message" class="mt-2 text-sm hidden"></p>
                            </div>
                            
                            <!-- Name Fields -->
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                                        <?php echo e(__('frontend.first_name')); ?> <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="first_name" name="first_name" required pattern="[A-Za-z]+" maxlength="15" title="<?php echo e(__('frontend.english_letters_only')); ?>" class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <p id="first-name-message" class="mt-2 text-sm text-red-600 dark:text-red-400 hidden"></p>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">
                                        <?php echo e(__('frontend.last_name')); ?> <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="last_name" name="last_name" required pattern="[A-Za-z]+" maxlength="15" title="<?php echo e(__('frontend.english_letters_only')); ?>" class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <p id="last-name-message" class="mt-2 text-sm text-red-600 dark:text-red-400 hidden"></p>
                                </div>
                            </div>
                            
                            <!-- Company Name (Optional) -->
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                                    <?php echo e(__('frontend.company_name')); ?> <span class="text-slate-400 text-xs">(<?php echo e(__('frontend.optional')); ?>)</span>
                                </label>
                                <input type="text" id="company_name" name="company_name" maxlength="30" pattern="[A-Za-z0-9\s]+" title="<?php echo e(__('frontend.english_letters_numbers_only')); ?>" class="w-full px-3 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-slate-500 focus:border-transparent text-sm">
                                <p id="company-name-message" class="mt-1 text-xs text-red-600 dark:text-red-400 hidden"></p>
                            </div>
                            
                            <!-- Email & Phone -->
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                                        <?php echo e(__('frontend.email')); ?> <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" id="email" name="email" required pattern="[A-Za-z0-9._%+\-]+@[A-Za-z0-9.\-]+\.[A-Za-z]{2,}" title="<?php echo e(__('frontend.english_letters_only')); ?>" class="w-full px-3 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-slate-500 focus:border-transparent text-sm">
                                    <p id="email-message" class="mt-1 text-xs text-red-600 dark:text-red-400 hidden"></p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                                        <?php echo e(__('frontend.phone_number')); ?> <span class="text-red-500">*</span>
                                    </label>
                                    <div class="flex" dir="ltr">
                                        <select id="country_code" name="country_code" required class="flex-shrink-0 w-20 px-2 py-2.5 text-xs border border-r-0 border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white rounded-l-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent">
                                            <?php
                                                $countriesData = [];
                                                $allCountries = \Rinvex\Country\CountryLoader::countries();
                                                foreach ($allCountries as $countryCode => $countryData) {
                                                    if (isset($countryData['calling_code']) && !empty($countryData['calling_code'])) {
                                                        $callingCodes = $countryData['calling_code'];
                                                        $code = is_array($callingCodes) ? $callingCodes[0] : $callingCodes;
                                                        
                                                        $countriesData[] = [
                                                            'code' => (string)$code,
                                                            'iso' => strtoupper($countryCode)
                                                        ];
                                                    }
                                                }
                                                // Remove duplicates and sort by calling code
                                                $countriesData = collect($countriesData)->unique('code')->sortBy(function($item) {
                                                    return (int)$item['code'];
                                                })->values()->toArray();
                                            ?>
                                            <?php $__currentLoopData = $countriesData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="+<?php echo e($country['code']); ?>" <?php echo e($country['iso'] == 'SA' ? 'selected' : ''); ?>>
                                                    +<?php echo e($country['code']); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <input type="tel" id="phone" name="phone" required pattern="[0-9]+" title="Numbers only" placeholder="512345678" class="flex-1 px-3 py-2.5 border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white rounded-r-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent text-sm">
                                    </div>
                                    <p id="phone-message" class="mt-1 text-xs text-red-600 dark:text-red-400 hidden"></p>
                                </div>
                            </div>
                            
                            <!-- Address Information Section -->
                            <div class="pt-4 border-t border-slate-200 dark:border-slate-700">
                                <h3 class="text-sm font-semibold text-slate-900 dark:text-white mb-3">
                                    <?php echo e(__('frontend.address_information')); ?>

                                </h3>
                                
                                <!-- Address 1 -->
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                                        <?php echo e(__('frontend.address_1')); ?> <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="address_1" name="address_1" required maxlength="100" class="w-full px-3 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-slate-500 focus:border-transparent text-sm" placeholder="<?php echo e(__('frontend.street_address')); ?>">
                                    <p id="address-1-message" class="mt-1 text-xs text-red-600 dark:text-red-400 hidden"></p>
                                </div>
                                
                                <!-- Address 2 (Optional) -->
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                                        <?php echo e(__('frontend.address_2')); ?> <span class="text-slate-400 text-xs">(<?php echo e(__('frontend.optional')); ?>)</span>
                                    </label>
                                    <input type="text" id="address_2" name="address_2" maxlength="100" pattern="[A-Za-z0-9\s\.\-,#/]*" title="<?php echo e(__('frontend.english_letters_numbers_only')); ?>" class="w-full px-3 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-slate-500 focus:border-transparent text-sm" placeholder="<?php echo e(__('frontend.apartment_suite')); ?>">
                                    <p id="address-2-message" class="mt-1 text-xs text-red-600 dark:text-red-400 hidden"></p>
                                </div>
                                
                                <!-- City, State, Postcode -->
                                <div class="grid md:grid-cols-3 gap-3 mb-3">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                                            <?php echo e(__('frontend.city')); ?> <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="city" name="city" required maxlength="20" pattern="[A-Za-z\s\-]+" title="<?php echo e(__('frontend.english_letters_only')); ?>" class="w-full px-3 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-slate-500 focus:border-transparent text-sm">
                                        <p id="city-message" class="mt-1 text-xs text-red-600 dark:text-red-400 hidden"></p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                                            <?php echo e(__('frontend.state_region')); ?> <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="state" name="state" required maxlength="20" pattern="[A-Za-z\s\-]+" title="<?php echo e(__('frontend.english_letters_only')); ?>" class="w-full px-3 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-slate-500 focus:border-transparent text-sm">
                                        <p id="state-message" class="mt-1 text-xs text-red-600 dark:text-red-400 hidden"></p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                                            <?php echo e(__('frontend.postcode')); ?> <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="postcode" name="postcode" required maxlength="15" pattern="[A-Za-z0-9\s\-]+" title="<?php echo e(__('frontend.english_letters_numbers_only')); ?>" class="w-full px-3 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-slate-500 focus:border-transparent text-sm">
                                        <p id="postcode-message" class="mt-1 text-xs text-red-600 dark:text-red-400 hidden"></p>
                                    </div>
                                </div>
                                
                                <!-- Country -->
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                                        <?php echo e(__('frontend.country')); ?> <span class="text-red-500">*</span>
                                    </label>
                                    <select name="country" required class="w-full px-3 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-slate-500 focus:border-transparent text-sm">
                                        <option value=""><?php echo e(__('frontend.select_country')); ?></option>
                                        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($code); ?>"><?php echo e($name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                
                                <!-- Tax Registration Number (Optional) -->
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                                        <?php echo e(__('frontend.tax_registration_number')); ?> <span class="text-slate-400 text-xs">(<?php echo e(__('frontend.optional')); ?>)</span>
                                    </label>
                                    <input type="text" id="tax_number" name="tax_number" maxlength="20" pattern="[A-Za-z0-9\-]*" title="<?php echo e(__('frontend.english_letters_numbers_only')); ?>" class="w-full px-3 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-slate-500 focus:border-transparent text-sm" placeholder="<?php echo e(__('frontend.vat_number')); ?>">
                                    <p id="tax-number-message" class="mt-1 text-xs text-red-600 dark:text-red-400 hidden"></p>
                                </div>
                            </div>

                            <!-- Security Section -->
                            <div class="pt-4 border-t border-slate-200 dark:border-slate-700">
                                <h3 class="text-sm font-semibold text-slate-900 dark:text-white mb-3">
                                    <?php echo e(__('frontend.account_security')); ?>

                                </h3>

                                <div class="grid md:grid-cols-2 gap-3">
                                    <!-- Password -->
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                                            <?php echo e(__('frontend.password')); ?> <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <input type="password" id="password" name="password" required minlength="8" class="w-full px-3 py-2.5 pr-10 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-slate-500 focus:border-transparent text-sm" placeholder="<?php echo e(__('frontend.enter_password')); ?>">
                                            <button type="button" id="toggle-password" class="absolute right-2 top-1/2 -translate-y-1/2 p-1 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                                                <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        <p id="password-message" class="mt-1 text-xs text-slate-500 dark:text-slate-400"><?php echo e(__('frontend.password_requirements')); ?></p>
                                    </div>

                                    <!-- Confirm Password -->
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                                            <?php echo e(__('frontend.confirm_password')); ?> <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <input type="password" id="password_confirmation" name="password_confirmation" required minlength="8" class="w-full px-3 py-2.5 pr-10 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-slate-500 focus:border-transparent text-sm" placeholder="<?php echo e(__('frontend.confirm_your_password')); ?>">
                                            <button type="button" id="toggle-password-confirm" class="absolute right-2 top-1/2 -translate-y-1/2 p-1 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                                                <svg id="eye-icon-confirm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        <p id="password-confirm-message" class="mt-1 text-xs text-red-600 dark:text-red-400 hidden"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if(auth()->guard('client')->check()): ?>
                        <!-- Authenticated User Info -->
                        <div class="bg-slate-100 dark:bg-slate-800 rounded-lg p-4 flex items-center gap-3">
                            <div class="w-10 h-10 bg-slate-900 dark:bg-white rounded-full flex items-center justify-center text-white dark:text-slate-900 flex-shrink-0">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-slate-900 dark:text-white">
                                    <?php echo e(auth()->guard('client')->user()->first_name); ?> <?php echo e(auth()->guard('client')->user()->last_name); ?>

                                </p>
                                <p class="text-sm text-slate-500 dark:text-slate-400">
                                    <?php echo e(auth()->guard('client')->user()->email); ?>

                                </p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Payment Method -->
                        <div class="bg-white dark:bg-slate-800 rounded-xl p-6 border border-slate-200 dark:border-slate-700">
                            <h2 class="text-lg font-semibold text-slate-900 dark:text-white mb-5 flex items-center gap-3">
                                <span class="w-7 h-7 bg-slate-900 dark:bg-white rounded-full flex items-center justify-center text-white dark:text-slate-900 text-sm font-medium">
                                    <?php if(auth()->guard('client')->check()): ?>
                                        1
                                    <?php else: ?>
                                        2
                                    <?php endif; ?>
                                </span>
                                <?php echo e(__('frontend.payment_method') ?? 'Payment Method'); ?>

                            </h2>
                        
                        <!-- Payment Methods Grid -->
                        <div class="space-y-3">
                            
                            <?php if(auth()->guard('client')->check()): ?>
                                <label class="payment-method-card block cursor-pointer">
                                    <input type="radio" name="payment_method" value="wallet" class="payment-method-radio sr-only" required>
                                    <div class="payment-method-content relative flex items-center p-4 border-2 border-slate-200 dark:border-slate-700 rounded-lg transition-all hover:border-slate-400 dark:hover:border-slate-500">
                                        <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1 ms-3">
                                            <div class="font-medium text-slate-900 dark:text-white">
                                                <?php echo e(__('frontend.wallet_balance') ?? 'Wallet Balance'); ?>

                                            </div>
                                            <div class="text-sm text-slate-500 dark:text-slate-400">
                                                <?php echo e(__('frontend.available') ?? 'Available'); ?>: $<?php echo e(number_format(auth('client')->user()->wallet_balance ?? 0, 2)); ?>

                                                <?php if((auth('client')->user()->wallet_balance ?? 0) < $total): ?>
                                                    <span class="text-red-500 ms-1">• <?php echo e(__('frontend.insufficient_balance') ?? 'Insufficient'); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="payment-method-checkmark hidden text-slate-900 dark:text-white">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    </div>
                                </label>
                            <?php endif; ?>

                            <?php if(isset($fawaterakPaymentMethods) && count($fawaterakPaymentMethods) > 0): ?>
                                <?php $__currentLoopData = $fawaterakPaymentMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <label class="payment-method-card block cursor-pointer">
                                        <input type="radio" name="payment_method" value="fawaterak_<?php echo e($method['paymentId']); ?>" class="payment-method-radio sr-only" required>
                                        <div class="payment-method-content relative flex items-center p-4 border-2 border-slate-200 dark:border-slate-700 rounded-lg transition-all hover:border-slate-400 dark:hover:border-slate-500">
                                            <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center">
                                                <?php if(!empty($method['logo'])): ?>
                                                    <img src="<?php echo e($method['logo']); ?>" alt="<?php echo e($method['nameEn']); ?>" class="max-w-full max-h-full object-contain">
                                                <?php else: ?>
                                                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                                    </svg>
                                                <?php endif; ?>
                                            </div>
                                            <div class="flex-1 ms-3">
                                                <div class="font-medium text-slate-900 dark:text-white">
                                                    <?php echo e(app()->getLocale() == 'ar' ? $method['nameAr'] : $method['nameEn']); ?>

                                                </div>
                                            </div>
                                            <div class="payment-method-checkmark hidden text-slate-900 dark:text-white">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </label>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="text-center py-6 text-slate-500 dark:text-slate-400">
                                    <p><?php echo e(__('frontend.no_payment_methods') ?? 'No payment methods available'); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <p id="payment-method-error" class="mt-4 text-sm text-red-600 dark:text-red-400 hidden"></p>
                    </div>
                </div>

                <!-- Order Summary (Sticky) -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-slate-800 rounded-xl p-5 border border-slate-200 dark:border-slate-700 sticky top-24">
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">
                            <?php echo e(__('frontend.order_summary') ?? 'Order Summary'); ?>

                        </h3>

                        <!-- Order Items -->
                        <div class="space-y-3 mb-4 pb-4 border-b border-slate-200 dark:border-slate-700">
                                <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="border-b border-slate-100 dark:border-slate-700/50 pb-3 last:border-0 last:pb-0">
                                        <div class="flex justify-between items-start gap-2 mb-1">
                                            <div class="flex-1">
                                                <p class="font-medium text-slate-900 dark:text-white text-sm break-all">
                                                <?php if(($item['type'] ?? 'domain') == 'hosting'): ?>
                                                    <?php echo e($item['product_name'] ?? __('frontend.hosting')); ?>

                                                <?php elseif(($item['type'] ?? 'domain') == 'vps'): ?>
                                                    <?php echo e($item['product_name'] ?? __('frontend.vps')); ?>

                                                <?php elseif(($item['type'] ?? 'domain') == 'dedicated'): ?>
                                                    <?php echo e($item['product_name'] ?? __('frontend.dedicated_server')); ?>

                                                <?php else: ?>
                                                    <?php echo e($item['domain'] ?? $item['product_name'] ?? 'Product'); ?>

                                                <?php endif; ?>
                                            </p>
                                            <p class="text-xs text-slate-500">
                                                <?php if(($item['type'] ?? 'domain') == 'hosting'): ?>
                                                    <?php echo e(__('frontend.hosting')); ?>

                                                <?php elseif(($item['type'] ?? 'domain') == 'vps'): ?>
                                                    <?php echo e(__('frontend.vps')); ?>

                                                <?php elseif(($item['type'] ?? 'domain') == 'dedicated'): ?>
                                                    <?php echo e(__('frontend.dedicated_server')); ?>

                                                <?php elseif(isset($item['action'])): ?>
                                                    <?php if($item['action'] == 'register'): ?>
                                                        <?php echo e(__('frontend.domain_registration')); ?>

                                                    <?php elseif($item['action'] == 'transfer'): ?>
                                                        <?php echo e(__('frontend.domain_transfer')); ?>

                                                    <?php else: ?>
                                                        <?php echo e(__('frontend.domain_renewal')); ?>

                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <?php echo e(__('frontend.domain')); ?>

                                                <?php endif; ?>
                                            </p>
                                        </div>
                                        <span class="font-bold text-slate-900 dark:text-white whitespace-nowrap">
                                            $<?php echo e(number_format($item['price'], 2)); ?>

                                        </span>
                                    </div>
                                    
                                    <!-- Item Details -->
                                    <div class="space-y-1 mt-2">
                                        <?php if(($item['type'] ?? 'domain') == 'hosting' || ($item['type'] ?? 'domain') == 'vps' || ($item['type'] ?? 'domain') == 'dedicated'): ?>
                                            
                                            <?php if(isset($item['domain']) && $item['domain']): ?>
                                                <div class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                                    </svg>
                                                    <?php echo e($item['domain']); ?>

                                                </div>
                                            <?php endif; ?>
                                            <?php if(isset($item['billing_cycle'])): ?>
                                                <div class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    <?php echo e(__('frontend.' . $item['billing_cycle'])); ?>

                                                </div>
                                            <?php endif; ?>
                                            <?php if(isset($item['datacenter_name']) && $item['datacenter_name']): ?>
                                                <div class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <?php echo e($item['datacenter_name']); ?>

                                                    <?php if(isset($item['datacenter_price']) && $item['datacenter_price'] > 0): ?>
                                                        <span class="text-purple-600 dark:text-purple-400">(+$<?php echo e(number_format($item['datacenter_price'], 2)); ?>)</span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if(($item['ssl'] ?? false) || ($item['backups'] ?? false) || ($item['privacy'] ?? false)): ?>
                                                <div class="flex flex-wrap gap-1 mt-1">
                                                    <?php if($item['ssl'] ?? false): ?>
                                                        <span class="inline-flex items-center gap-1 px-1.5 py-0.5 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 text-[10px] font-bold rounded">
                                                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                                            </svg>
                                                            SSL
                                                        </span>
                                                    <?php endif; ?>
                                                    <?php if($item['backups'] ?? false): ?>
                                                        <span class="inline-flex items-center gap-1 px-1.5 py-0.5 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 text-[10px] font-bold rounded">
                                                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                                                            </svg>
                                                            <?php echo e(__('frontend.backups')); ?>

                                                        </span>
                                                    <?php endif; ?>
                                                    <?php if($item['privacy'] ?? false): ?>
                                                        <span class="inline-flex items-center gap-1 px-1.5 py-0.5 bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-300 text-[10px] font-bold rounded">
                                                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                                            </svg>
                                                            <?php echo e(__('frontend.privacy')); ?>

                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            
                                            <?php if(isset($item['years']) && $item['years']): ?>
                                                <div class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    <?php echo e($item['years']); ?> <?php echo e($item['years'] > 1 ? __('frontend.years') : __('frontend.year')); ?>

                                                </div>
                                            <?php endif; ?>
                                            <?php if(isset($item['tld']) && $item['tld']): ?>
                                                <div class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                                    </svg>
                                                    .<?php echo e($item['tld']); ?>

                                                </div>
                                            <?php endif; ?>
                                            <?php if(isset($item['privacy']) && $item['privacy']): ?>
                                                <div class="flex items-center gap-2 text-xs text-green-600 dark:text-green-400">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                                    </svg>
                                                    <?php echo e(__('frontend.privacy_protection')); ?>

                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        
                                        
                                        <?php if(isset($item['quantity']) && $item['quantity'] > 1): ?>
                                            <div class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                                </svg>
                                                <?php echo e(__('frontend.quantity')); ?>: <?php echo e($item['quantity']); ?>

                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <!-- Totals -->
                        <div class="space-y-3 mb-6 pb-6 border-b border-slate-200 dark:border-slate-700">
                            <div class="flex justify-between text-slate-600 dark:text-slate-400">
                                <span><?php echo e(__('frontend.subtotal') ?? 'Subtotal'); ?></span>
                                <span class="font-bold">$<?php echo e(number_format($subtotal, 2)); ?></span>
                            </div>
                            
                            <?php if(session('coupon_code') && $discount > 0): ?>
                                <div class="flex justify-between text-green-600 dark:text-green-400">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                                        </svg>
                                        <?php echo e(__('frontend.discount')); ?> (<?php echo e(session('coupon_code')); ?>)
                                    </span>
                                    <span class="font-bold">-$<?php echo e(number_format($discount, 2)); ?></span>
                                </div>
                                <?php if(session('coupon_description')): ?>
                                    <div class="text-xs text-green-600 dark:text-green-400 italic">
                                        <?php echo e(session('coupon_description')); ?>

                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            <div class="flex justify-between text-slate-600 dark:text-slate-400">
                                <span><?php echo e(__('frontend.tax') ?? 'Tax'); ?></span>
                                <span class="font-bold">$0.00</span>
                            </div>
                        </div>

                        <!-- Grand Total -->
                        <div class="flex justify-between items-center mb-4">
                            <span class="font-semibold text-slate-900 dark:text-white"><?php echo e(__('frontend.total') ?? 'Total'); ?></span>
                            <span class="text-xl font-bold text-slate-900 dark:text-white">$<?php echo e(number_format($total, 2)); ?></span>
                        </div>

                        <!-- Terms and Conditions Agreement - Show only if user hasn't accepted before -->
                        <?php if(!Auth::guard('client')->check() || !Auth::guard('client')->user()->hasAcceptedTerms()): ?>
                        <div class="mb-4 pb-4 border-b border-slate-200 dark:border-slate-700">
                            <label class="flex items-start gap-2 cursor-pointer">
                                <input type="checkbox" id="terms-checkbox" name="accept_terms" required class="mt-0.5 w-4 h-4 rounded border-slate-300 dark:border-slate-600 text-slate-900 focus:ring-2 focus:ring-slate-500 dark:focus:ring-slate-400 cursor-pointer">
                                <span class="flex-1 text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                                    <?php echo e(__('frontend.i_agree_to_the') ?? 'I agree to the'); ?>

                                    <a href="<?php echo e(route('terms')); ?>" target="_blank" class="text-slate-900 dark:text-white hover:underline font-medium">
                                        <?php echo e(__('frontend.terms_and_conditions') ?? 'Terms and Conditions'); ?>

                                    </a>
                                    <?php echo e(__('frontend.and') ?? 'and'); ?>

                                    <a href="<?php echo e(route('privacy')); ?>" target="_blank" class="text-slate-900 dark:text-white hover:underline font-medium">
                                        <?php echo e(__('frontend.privacy_policy') ?? 'Privacy Policy'); ?>

                                    </a>
                                </span>
                            </label>
                            <p id="terms-error" class="mt-2 text-sm text-red-600 dark:text-red-400 hidden"></p>
                        </div>
                        <?php endif; ?>

                        <!-- Cloudflare Turnstile -->
                        <div class="mb-6 flex justify-center">
                            <div class="cf-turnstile" 
                                 data-sitekey="<?php echo e(config('services.turnstile.site_key', '1x00000000000000000000AA')); ?>" 
                                 data-theme="<?php echo e(Cookie::get('theme', 'light') == 'dark' ? 'dark' : 'light'); ?>"
                                 data-language="<?php echo e(app()->getLocale()); ?>"
                                 data-callback="onTurnstileSuccess"
                                 data-error-callback="onTurnstileError">
                            </div>
                        </div>

                        <!-- Place Order Button -->
                        <button type="submit" id="place-order-btn" class="w-full py-3 text-sm bg-slate-900 dark:bg-white hover:bg-slate-800 dark:hover:bg-slate-100 text-white dark:text-slate-900 font-medium rounded-lg transition-colors">
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <?php echo e(__('frontend.place_order') ?? 'Place Order'); ?>

                            </span>
                        </button>
                        
                        <a href="<?php echo e(route('cart.index')); ?>" class="block w-full py-2.5 text-sm bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 text-center font-medium rounded-lg transition-colors mt-2">
                            <?php echo e(__('frontend.back_to_cart') ?? 'Back to Cart'); ?>

                        </a>

                        <!-- Trust Badges -->
                        <div class="mt-4 pt-4 border-t border-slate-200 dark:border-slate-700 space-y-2">
                            <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                <span><?php echo e(__('frontend.secure_payment') ?? 'Secure Payment'); ?></span>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                <span><?php echo e(__('frontend.ssl_encrypted') ?? 'SSL Encrypted'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== Checkout Page Loaded ===');
    
    // ========== Login/Register Toggle ==========
    const toggleLoginBtn = document.getElementById('toggle-login-form');
    const loginFormSection = document.getElementById('login-form-section');
    const registerFormSection = document.getElementById('register-form-section');
    const formTitle = document.getElementById('form-title');
    const loginSubmitBtn = document.getElementById('login-submit-btn');
    const loginError = document.getElementById('login-error');
    const toggleLoginPassword = document.getElementById('toggle-login-password');
    let isLoginMode = false;
    
    if (toggleLoginBtn) {
        toggleLoginBtn.addEventListener('click', function() {
            isLoginMode = !isLoginMode;
            
            if (isLoginMode) {
                // Show login form
                loginFormSection.classList.remove('hidden');
                registerFormSection.classList.add('hidden');
                formTitle.textContent = '<?php echo e(__("frontend.login") ?? "Login"); ?>';
                toggleLoginBtn.innerHTML = '<?php echo e(__("frontend.new_customer") ?? "New customer?"); ?> <span class="font-medium text-slate-900 dark:text-white underline"><?php echo e(__("frontend.create_account") ?? "Create account"); ?></span>';
                
                // Disable required fields in register form
                document.querySelectorAll('#register-form-section [required]').forEach(el => {
                    el.removeAttribute('required');
                    el.dataset.wasRequired = 'true';
                });
            } else {
                // Show register form
                loginFormSection.classList.add('hidden');
                registerFormSection.classList.remove('hidden');
                formTitle.textContent = '<?php echo e(__("frontend.contact_information") ?? "Contact Information"); ?>';
                toggleLoginBtn.innerHTML = '<?php echo e(__("frontend.already_have_account") ?? "Already have an account?"); ?> <span class="font-medium text-slate-900 dark:text-white underline"><?php echo e(__("frontend.login") ?? "Login"); ?></span>';
                
                // Re-enable required fields
                document.querySelectorAll('#register-form-section [data-was-required]').forEach(el => {
                    el.setAttribute('required', '');
                });
            }
        });
    }
    
    // Toggle login password visibility
    if (toggleLoginPassword) {
        toggleLoginPassword.addEventListener('click', function() {
            const input = document.getElementById('login_password');
            input.type = input.type === 'password' ? 'text' : 'password';
        });
    }
    
    // Login submit
    if (loginSubmitBtn) {
        loginSubmitBtn.addEventListener('click', async function() {
            const email = document.getElementById('login_email').value;
            const password = document.getElementById('login_password').value;
            const remember = document.querySelector('input[name="remember"]')?.checked;
            
            if (!email || !password) {
                loginError.textContent = '<?php echo e(__("frontend.please_fill_all_fields") ?? "Please fill all fields"); ?>';
                loginError.classList.remove('hidden');
                return;
            }
            
            // Show loading
            document.getElementById('login-btn-text').classList.add('hidden');
            document.getElementById('login-btn-loading').classList.remove('hidden');
            loginSubmitBtn.disabled = true;
            loginError.classList.add('hidden');
            
            try {
                const response = await fetch('<?php echo e(route("login.post")); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        email: email,
                        password: password,
                        remember: remember
                    })
                });
                
                const data = await response.json();
                
                if (response.ok && data.success) {
                    // Reload page to show authenticated state
                    window.location.reload();
                } else {
                    loginError.textContent = data.message || '<?php echo e(__("frontend.invalid_credentials") ?? "Invalid email or password"); ?>';
                    loginError.classList.remove('hidden');
                }
            } catch (error) {
                loginError.textContent = '<?php echo e(__("frontend.login_error") ?? "An error occurred. Please try again."); ?>';
                loginError.classList.remove('hidden');
            } finally {
                document.getElementById('login-btn-text').classList.remove('hidden');
                document.getElementById('login-btn-loading').classList.add('hidden');
                loginSubmitBtn.disabled = false;
            }
        });
    }
    
    // ========== Username Check ==========
    const usernameInput = document.getElementById('username');
    console.log('Username input found:', !!usernameInput);
    
    const usernameSpinner = document.getElementById('username-spinner');
    const usernameCheck = document.getElementById('username-check');
    const usernameErrorIcon = document.getElementById('username-error-icon');
    const usernameMessage = document.getElementById('username-message');
    const generateButton = document.getElementById('generate-username');
    let checkTimeout;
    let isUsernameAvailable = false;

    // Generate random username function
    function generateRandomUsername() {
        const adjectives = ['cool', 'smart', 'happy', 'lucky', 'fast', 'bright', 'super', 'mega', 'ultra', 'pro', 'ace', 'bold', 'clever', 'dev', 'epic', 'flex', 'gold', 'hero', 'iron', 'jet'];
        const nouns = ['user', 'dev', 'host', 'cloud', 'web', 'tech', 'code', 'data', 'net', 'star', 'pro', 'admin', 'master', 'ninja', 'guru', 'boss', 'king', 'ace', 'expert', 'wizard'];
        const randomAdjective = adjectives[Math.floor(Math.random() * adjectives.length)];
        const randomNoun = nouns[Math.floor(Math.random() * nouns.length)];
        const randomNumber = Math.floor(Math.random() * 99999);
        
        return randomAdjective + randomNoun + randomNumber;
    }

    // Generate unique username with availability check
    async function generateUniqueUsername() {
        if (!usernameInput) return;
        
        // Show spinner
        if (usernameSpinner) usernameSpinner.classList.remove('hidden');
        if (usernameCheck) usernameCheck.classList.add('hidden');
        if (usernameErrorIcon) usernameErrorIcon.classList.add('hidden');
        if (usernameMessage) usernameMessage.classList.add('hidden');
        if (usernameInput) usernameInput.classList.remove('border-green-500', 'dark:border-green-500', 'border-red-500', 'dark:border-red-500');
        
        let attempts = 0;
        const maxAttempts = 10;
        
        while (attempts < maxAttempts) {
            const username = generateRandomUsername();
            usernameInput.value = username;
            
            try {
                const response = await fetch('/api/check-username', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ username: username })
                });
                
                const data = await response.json();
                
                if (data.available) {
                    // Username is available
                    if (usernameSpinner) usernameSpinner.classList.add('hidden');
                    showSuccess('<?php echo e(__("frontend.username_available")); ?>');
                    isUsernameAvailable = true;
                    return;
                }
            } catch (error) {
                console.error('Error checking username:', error);
            }
            
            attempts++;
        }
        
        // If we couldn't find a unique username after max attempts
        if (usernameSpinner) usernameSpinner.classList.add('hidden');
        showError('<?php echo e(__("frontend.username_check_error")); ?>');
    }

    // Generate username button click event
    if (generateButton) {
        generateButton.addEventListener('click', function() {
            generateUniqueUsername();
        });
    }

    if (usernameInput) {
        usernameInput.addEventListener('input', function(e) {
        let username = this.value;
        
        // Remove spaces automatically
        if (username.includes(' ')) {
            username = username.replace(/\s/g, '');
            this.value = username;
        }
        
        username = username.trim();
        
        // Reset state
        isUsernameAvailable = false;
        
        // Hide all icons
        if (usernameSpinner) usernameSpinner.classList.add('hidden');
        if (usernameCheck) usernameCheck.classList.add('hidden');
        if (usernameErrorIcon) usernameErrorIcon.classList.add('hidden');
        if (usernameMessage) usernameMessage.classList.add('hidden');
        
        // Reset border
        if (usernameInput) usernameInput.classList.remove('border-green-500', 'dark:border-green-500', 'border-red-500', 'dark:border-red-500');
        
        // Clear previous timeout
        clearTimeout(checkTimeout);
        
        // Validate format first
        if (username.length === 0) {
            return;
        }
        
        if (username.length < 3) {
            showError('<?php echo e(__("frontend.username_too_short")); ?>');
            return;
        }
        
        if (username.length > 20) {
            showError('<?php echo e(__("frontend.username_too_long")); ?>');
            return;
        }
        
        if (!/^[A-Za-z0-9]+$/.test(username)) {
            showError('<?php echo e(__("frontend.username_invalid_format")); ?>');
            return;
        }
        
        // Show spinner and check availability after short delay
        if (usernameSpinner) usernameSpinner.classList.remove('hidden');
        
        checkTimeout = setTimeout(() => {
            checkUsernameAvailability(username);
        }, 300); // Reduced from 500ms to 300ms for faster response
        });
    }
    
    function checkUsernameAvailability(username) {
        fetch('/api/check-username', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ username: username })
        })
        .then(response => response.json())
        .then(data => {
            if (usernameSpinner) usernameSpinner.classList.add('hidden');
            
            if (data.available) {
                showSuccess('<?php echo e(__("frontend.username_available")); ?>');
                isUsernameAvailable = true;
            } else {
                showError('<?php echo e(__("frontend.username_taken")); ?>');
                isUsernameAvailable = false;
            }
        })
        .catch(error => {
            console.error('Error checking username:', error);
            if (usernameSpinner) usernameSpinner.classList.add('hidden');
            showError('<?php echo e(__("frontend.username_check_error")); ?>');
            isUsernameAvailable = false;
        });
    }
    
    function showSuccess(message) {
        if (usernameCheck) usernameCheck.classList.remove('hidden');
        if (usernameMessage) {
            usernameMessage.textContent = message;
            usernameMessage.classList.remove('hidden', 'text-red-600', 'dark:text-red-400');
            usernameMessage.classList.add('text-green-600', 'dark:text-green-400');
        }
        if (usernameInput) {
            usernameInput.classList.remove('border-red-500', 'dark:border-red-500');
            usernameInput.classList.add('border-green-500', 'dark:border-green-500');
        }
    }
    
    function showError(message) {
        if (usernameErrorIcon) usernameErrorIcon.classList.remove('hidden');
        if (usernameMessage) {
            usernameMessage.textContent = message;
            usernameMessage.classList.remove('hidden', 'text-green-600', 'dark:text-green-400');
            usernameMessage.classList.add('text-red-600', 'dark:text-red-400');
        }
        if (usernameInput) {
            usernameInput.classList.remove('border-green-500', 'dark:border-green-500');
            usernameInput.classList.add('border-red-500', 'dark:border-red-500');
        }
    }
    
    // Validate before form submission - فقط إذا كان حقل Username موجود (للزوار فقط)
    console.log('Setting up username validation, input exists:', !!usernameInput);
    if (usernameInput) {
        const form = usernameInput.closest('form');
        console.log('Form found for username validation:', !!form);
        if (form) {
            form.addEventListener('submit', function(e) {
                console.log('=== USERNAME VALIDATION TRIGGERED ===');
                // فقط نفحص إذا كان Username مدخل وليس متاح
                // نتأكد أن الحقل موجود ومرئي (للزوار فقط)
                if (!usernameInput || usernameInput.offsetParent === null) {
                    // الحقل مش موجود أو مخفي - المستخدم مسجل دخول، نسمح بالإرسال
                    console.log('Username field not visible - user is logged in, allowing submit');
                    return;
                }
                
                const usernameValue = usernameInput.value.trim();
                console.log('Username validation:', {value: usernameValue, available: isUsernameAvailable});
                if (usernameValue && !isUsernameAvailable) {
                    e.preventDefault();
                    console.log('BLOCKED: Username not available!');
                    showError('<?php echo e(__("frontend.username_must_be_available")); ?>');
                    usernameInput.focus();
                }
            });
        }
    } else {
        console.log('No username input - user is logged in, username validation SKIPPED');
    }

    // First Name: Real-time validation - English letters only, no spaces
    const firstNameInput = document.getElementById('first_name');
    const firstNameMessage = document.getElementById('first-name-message');
    let firstNameTimeout;
    
    if (firstNameInput && firstNameMessage) {
        firstNameInput.addEventListener('input', function(e) {
            let value = this.value;
            
            // Remove any non-English letters (including spaces, numbers, Arabic, special chars)
            const cleaned = value.replace(/[^A-Za-z]/g, '');
            
            if (value !== cleaned) {
                this.value = cleaned;
                
                // Show warning message
                firstNameMessage.textContent = '<?php echo e(__("frontend.english_letters_only")); ?>';
                firstNameMessage.classList.remove('hidden');
                firstNameInput.classList.add('border-red-500', 'dark:border-red-500');
                
                // Clear previous timeout
                clearTimeout(firstNameTimeout);
                
                // Hide message after 3 seconds
                firstNameTimeout = setTimeout(() => {
                    firstNameMessage.classList.add('hidden');
                    firstNameInput.classList.remove('border-red-500', 'dark:border-red-500');
                }, 3000);
            }
        });
    }

    // Last Name: Real-time validation - English letters only, no spaces
    const lastNameInput = document.getElementById('last_name');
    const lastNameMessage = document.getElementById('last-name-message');
    let lastNameTimeout;
    
    if (lastNameInput && lastNameMessage) {
        lastNameInput.addEventListener('input', function(e) {
            let value = this.value;
            
            // Remove any non-English letters (including spaces, numbers, Arabic, special chars)
            const cleaned = value.replace(/[^A-Za-z]/g, '');
            
            if (value !== cleaned) {
                this.value = cleaned;
                
                // Show warning message
                lastNameMessage.textContent = '<?php echo e(__("frontend.english_letters_only")); ?>';
                lastNameMessage.classList.remove('hidden');
                lastNameInput.classList.add('border-red-500', 'dark:border-red-500');
                
                // Clear previous timeout
                clearTimeout(lastNameTimeout);
                
                // Hide message after 3 seconds
                lastNameTimeout = setTimeout(() => {
                    lastNameMessage.classList.add('hidden');
                    lastNameInput.classList.remove('border-red-500', 'dark:border-red-500');
                }, 3000);
            }
        });
    }

    // Company Name: Real-time validation - English letters, numbers, and spaces only
    const companyNameInput = document.getElementById('company_name');
    const companyNameMessage = document.getElementById('company-name-message');
    let companyNameTimeout;
    
    if (companyNameInput && companyNameMessage) {
        companyNameInput.addEventListener('input', function(e) {
            let value = this.value;
            
            // Remove any non-English letters, non-numbers, and non-spaces
            const cleaned = value.replace(/[^A-Za-z0-9\s]/g, '');
            
            if (value !== cleaned) {
                this.value = cleaned;
                
                // Show warning message
                companyNameMessage.textContent = '<?php echo e(__("frontend.english_letters_numbers_only")); ?>';
                companyNameMessage.classList.remove('hidden');
                companyNameInput.classList.add('border-red-500', 'dark:border-red-500');
                
                // Clear previous timeout
                clearTimeout(companyNameTimeout);
                
                // Hide message after 3 seconds
                companyNameTimeout = setTimeout(() => {
                    companyNameMessage.classList.add('hidden');
                    companyNameInput.classList.remove('border-red-500', 'dark:border-red-500');
                }, 3000);
            }
        });
    }

    // Email: Real-time validation - English letters and valid email characters only
    const emailInput = document.getElementById('email');
    const emailMessage = document.getElementById('email-message');
    let emailTimeout;
    
    if (emailInput && emailMessage) {
        emailInput.addEventListener('input', function(e) {
            let value = this.value;
            
            // Remove any non-English letters, non-numbers, and non-valid email characters
            // Allow: A-Z, a-z, 0-9, @, ., -, _, +, %
            const cleaned = value.replace(/[^A-Za-z0-9@.\-_+%]/g, '');
            
            if (value !== cleaned) {
                this.value = cleaned;
                
                // Show warning message
                emailMessage.textContent = '<?php echo e(__("frontend.english_letters_only")); ?>';
                emailMessage.classList.remove('hidden');
                emailInput.classList.add('border-red-500', 'dark:border-red-500');
                
                // Clear previous timeout
                clearTimeout(emailTimeout);
                
                // Hide message after 3 seconds
                emailTimeout = setTimeout(() => {
                    emailMessage.classList.add('hidden');
                    emailInput.classList.remove('border-red-500', 'dark:border-red-500');
                }, 3000);
            } else {
                // Check email availability after valid input
                checkEmailAvailability();
            }
        });
    }

    // Check Email Availability Function
    let emailCheckTimeout;
    async function checkEmailAvailability() {
        const email = emailInput.value;
        
        // Clear previous timeout
        clearTimeout(emailCheckTimeout);
        
        // Validate email format first
        const emailRegex = /^[A-Za-z0-9._%+\-]+@[A-Za-z0-9.\-]+\.[A-Za-z]{2,}$/;
        if (!emailRegex.test(email)) {
            emailInput.classList.remove('border-green-500', 'dark:border-green-500', 'border-red-500', 'dark:border-red-500');
            emailMessage.classList.add('hidden');
            return;
        }
        
        // Debounce the check
        emailCheckTimeout = setTimeout(async () => {
            try {
                const response = await fetch('<?php echo e(route("api.check-email")); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ email: email })
                });
                
                const data = await response.json();
                
                if (data.available) {
                    emailInput.classList.remove('border-red-500', 'dark:border-red-500');
                    emailInput.classList.add('border-green-500', 'dark:border-green-500');
                    emailMessage.textContent = '<?php echo e(__("frontend.email_available")); ?>';
                    emailMessage.classList.remove('hidden', 'text-red-600', 'dark:text-red-400');
                    emailMessage.classList.add('text-green-600', 'dark:text-green-400');
                } else {
                    emailInput.classList.remove('border-green-500', 'dark:border-green-500');
                    emailInput.classList.add('border-red-500', 'dark:border-red-500');
                    emailMessage.textContent = '<?php echo e(__("frontend.email_already_used")); ?>';
                    emailMessage.classList.remove('hidden', 'text-green-600', 'dark:text-green-400');
                    emailMessage.classList.add('text-red-600', 'dark:text-red-400');
                }
            } catch (error) {
                console.error('Error checking email:', error);
            }
        }, 500);
    }

    // Phone: Real-time validation - Numbers only
    const phoneInput = document.getElementById('phone');
    const phoneMessage = document.getElementById('phone-message');
    let phoneTimeout;
    
    if (phoneInput && phoneMessage) {
        phoneInput.addEventListener('input', function(e) {
            let value = this.value;
            
            // Remove any non-numeric characters
            const cleaned = value.replace(/[^0-9]/g, '');
            
            if (value !== cleaned) {
                this.value = cleaned;
                
                // Show warning message
                phoneMessage.textContent = '<?php echo e(__("frontend.numbers_only")); ?>';
                phoneMessage.classList.remove('hidden');
                phoneInput.classList.add('border-red-500', 'dark:border-red-500');
                
                // Clear previous timeout
                clearTimeout(phoneTimeout);
                
                // Hide message after 3 seconds
                phoneTimeout = setTimeout(() => {
                    phoneMessage.classList.add('hidden');
                    phoneInput.classList.remove('border-red-500', 'dark:border-red-500');
                }, 3000);
            } else {
                // Check phone availability after valid input
                checkPhoneAvailability();
            }
        });
    }

    // Check Phone Availability Function
    let phoneCheckTimeout;
    async function checkPhoneAvailability() {
        const phone = phoneInput.value;
        const countryCodeSelect = document.getElementById('country_code');
        const countryCode = countryCodeSelect ? countryCodeSelect.value : '';
        
        // Clear previous timeout
        clearTimeout(phoneCheckTimeout);
        
        // Check if phone is valid (at least 7 digits)
        if (phone.length < 7) {
            phoneInput.classList.remove('border-green-500', 'dark:border-green-500', 'border-red-500', 'dark:border-red-500');
            phoneMessage.classList.add('hidden');
            return;
        }
        
        // Debounce the check
        phoneCheckTimeout = setTimeout(async () => {
            try {
                const response = await fetch('<?php echo e(route("api.check-phone")); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ 
                        phone: phone,
                        country_code: countryCode
                    })
                });
                
                const data = await response.json();
                
                if (data.available) {
                    phoneInput.classList.remove('border-red-500', 'dark:border-red-500');
                    phoneInput.classList.add('border-green-500', 'dark:border-green-500');
                    phoneMessage.textContent = '<?php echo e(__("frontend.phone_available")); ?>';
                    phoneMessage.classList.remove('hidden', 'text-red-600', 'dark:text-red-400');
                    phoneMessage.classList.add('text-green-600', 'dark:text-green-400');
                } else {
                    phoneInput.classList.remove('border-green-500', 'dark:border-green-500');
                    phoneInput.classList.add('border-red-500', 'dark:border-red-500');
                    phoneMessage.textContent = '<?php echo e(__("frontend.phone_already_used")); ?>';
                    phoneMessage.classList.remove('hidden', 'text-green-600', 'dark:text-green-400');
                    phoneMessage.classList.add('text-red-600', 'dark:text-red-400');
                }
            } catch (error) {
                console.error('Error checking phone:', error);
            }
        }, 500);
    }

    // Address 1: Real-time validation - English letters, numbers, and allowed symbols only
    const address1Input = document.getElementById('address_1');
    const address1Message = document.getElementById('address-1-message');
    let address1Timeout;
    
    if (address1Input && address1Message) {
        address1Input.addEventListener('input', function(e) {
            let value = this.value;
            
            // Remove any non-English characters (Allow: A-Z, a-z, 0-9, space, . - , # /)
            const cleaned = value.replace(/[^A-Za-z0-9\s.\-,#/]/g, '');
            
            if (value !== cleaned) {
                this.value = cleaned;
                
                // Show warning message
                address1Message.textContent = '<?php echo e(__("frontend.english_letters_numbers_only")); ?>';
                address1Message.classList.remove('hidden');
                address1Input.classList.add('border-red-500', 'dark:border-red-500');
                
                // Clear previous timeout
                clearTimeout(address1Timeout);
                
                // Hide message after 3 seconds
                address1Timeout = setTimeout(() => {
                    address1Message.classList.add('hidden');
                    address1Input.classList.remove('border-red-500', 'dark:border-red-500');
                }, 3000);
            }
        });
    }

    // Address 2: Real-time validation - English letters, numbers, and allowed symbols only
    const address2Input = document.getElementById('address_2');
    const address2Message = document.getElementById('address-2-message');
    let address2Timeout;
    
    if (address2Input && address2Message) {
        address2Input.addEventListener('input', function(e) {
            let value = this.value;
            
            // Remove any non-English characters (Allow: A-Z, a-z, 0-9, space, . - , # /)
            const cleaned = value.replace(/[^A-Za-z0-9\s.\-,#/]/g, '');
            
            if (value !== cleaned) {
                this.value = cleaned;
                
                // Show warning message
                address2Message.textContent = '<?php echo e(__("frontend.english_letters_numbers_only")); ?>';
                address2Message.classList.remove('hidden');
                address2Input.classList.add('border-red-500', 'dark:border-red-500');
                
                // Clear previous timeout
                clearTimeout(address2Timeout);
                
                // Hide message after 3 seconds
                address2Timeout = setTimeout(() => {
                    address2Message.classList.add('hidden');
                    address2Input.classList.remove('border-red-500', 'dark:border-red-500');
                }, 3000);
            }
        });
    }

    // City: Real-time validation - English letters, spaces, and hyphens only
    const cityInput = document.getElementById('city');
    const cityMessage = document.getElementById('city-message');
    let cityTimeout;
    
    if (cityInput && cityMessage) {
        cityInput.addEventListener('input', function(e) {
            let value = this.value;
            
            // Remove any non-English characters (Allow: A-Z, a-z, space, -)
            const cleaned = value.replace(/[^A-Za-z\s\-]/g, '');
            
            if (value !== cleaned) {
                this.value = cleaned;
                
                // Show warning message
                cityMessage.textContent = '<?php echo e(__("frontend.english_letters_only")); ?>';
                cityMessage.classList.remove('hidden');
                cityInput.classList.add('border-red-500', 'dark:border-red-500');
                
                // Clear previous timeout
                clearTimeout(cityTimeout);
                
                // Hide message after 3 seconds
                cityTimeout = setTimeout(() => {
                    cityMessage.classList.add('hidden');
                    cityInput.classList.remove('border-red-500', 'dark:border-red-500');
                }, 3000);
            }
        });
    }

    // State: Real-time validation - English letters, spaces, and hyphens only
    const stateInput = document.getElementById('state');
    const stateMessage = document.getElementById('state-message');
    let stateTimeout;
    
    if (stateInput && stateMessage) {
        stateInput.addEventListener('input', function(e) {
            let value = this.value;
            
            // Remove any non-English characters (Allow: A-Z, a-z, space, -)
            const cleaned = value.replace(/[^A-Za-z\s\-]/g, '');
            
            if (value !== cleaned) {
                this.value = cleaned;
                
                // Show warning message
                stateMessage.textContent = '<?php echo e(__("frontend.english_letters_only")); ?>';
                stateMessage.classList.remove('hidden');
                stateInput.classList.add('border-red-500', 'dark:border-red-500');
                
                // Clear previous timeout
                clearTimeout(stateTimeout);
                
                // Hide message after 3 seconds
                stateTimeout = setTimeout(() => {
                    stateMessage.classList.add('hidden');
                    stateInput.classList.remove('border-red-500', 'dark:border-red-500');
                }, 3000);
            }
        });
    }

    // Postcode: Real-time validation - English letters, numbers, spaces, and hyphens only
    const postcodeInput = document.getElementById('postcode');
    const postcodeMessage = document.getElementById('postcode-message');
    let postcodeTimeout;
    
    if (postcodeInput && postcodeMessage) {
        postcodeInput.addEventListener('input', function(e) {
            let value = this.value;
            
            // Remove any non-English characters (Allow: A-Z, a-z, 0-9, space, -)
            const cleaned = value.replace(/[^A-Za-z0-9\s\-]/g, '');
            
            if (value !== cleaned) {
                this.value = cleaned;
                
                // Show warning message
                postcodeMessage.textContent = '<?php echo e(__("frontend.english_letters_numbers_only")); ?>';
                postcodeMessage.classList.remove('hidden');
                postcodeInput.classList.add('border-red-500', 'dark:border-red-500');
                
                // Clear previous timeout
                clearTimeout(postcodeTimeout);
                
                // Hide message after 3 seconds
                postcodeTimeout = setTimeout(() => {
                    postcodeMessage.classList.add('hidden');
                    postcodeInput.classList.remove('border-red-500', 'dark:border-red-500');
                }, 3000);
            }
        });
    }

    // Tax Number: Real-time validation - English letters, numbers, and hyphens only
    const taxNumberInput = document.getElementById('tax_number');
    const taxNumberMessage = document.getElementById('tax-number-message');
    let taxNumberTimeout;
    
    if (taxNumberInput && taxNumberMessage) {
        taxNumberInput.addEventListener('input', function(e) {
            let value = this.value;
            
            // Remove any non-English characters (Allow: A-Z, a-z, 0-9, -)
            const cleaned = value.replace(/[^A-Za-z0-9\-]/g, '');
            
            if (value !== cleaned) {
                this.value = cleaned;
                
                // Show warning message
                taxNumberMessage.textContent = '<?php echo e(__("frontend.english_letters_numbers_only")); ?>';
                taxNumberMessage.classList.remove('hidden');
                taxNumberInput.classList.add('border-red-500', 'dark:border-red-500');
                
                // Clear previous timeout
                clearTimeout(taxNumberTimeout);
                
                // Hide message after 3 seconds
                taxNumberTimeout = setTimeout(() => {
                    taxNumberMessage.classList.add('hidden');
                    taxNumberInput.classList.remove('border-red-500', 'dark:border-red-500');
                }, 3000);
            } else if (value.length > 0) {
                // Check tax number availability after valid input
                checkTaxNumberAvailability();
            }
        });
    }

    // Check Tax Number Availability Function
    let taxNumberCheckTimeout;
    async function checkTaxNumberAvailability() {
        const taxNumber = taxNumberInput.value.trim();
        
        // Clear previous timeout
        clearTimeout(taxNumberCheckTimeout);
        
        // Check if tax number is provided (it's optional but if provided, check availability)
        if (taxNumber.length === 0) {
            taxNumberInput.classList.remove('border-green-500', 'dark:border-green-500', 'border-red-500', 'dark:border-red-500');
            taxNumberMessage.classList.add('hidden');
            return;
        }
        
        // Check minimum length (at least 3 characters)
        if (taxNumber.length < 3) {
            taxNumberInput.classList.remove('border-green-500', 'dark:border-green-500', 'border-red-500', 'dark:border-red-500');
            taxNumberMessage.classList.add('hidden');
            return;
        }
        
        // Debounce the check
        taxNumberCheckTimeout = setTimeout(async () => {
            try {
                const response = await fetch('<?php echo e(route("api.check-tax-number")); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ tax_number: taxNumber })
                });
                
                const data = await response.json();
                
                if (data.available) {
                    taxNumberInput.classList.remove('border-red-500', 'dark:border-red-500');
                    taxNumberInput.classList.add('border-green-500', 'dark:border-green-500');
                    taxNumberMessage.textContent = '<?php echo e(__("frontend.tax_number_available")); ?>';
                    taxNumberMessage.classList.remove('hidden', 'text-red-600', 'dark:text-red-400');
                    taxNumberMessage.classList.add('text-green-600', 'dark:text-green-400');
                } else {
                    taxNumberInput.classList.remove('border-green-500', 'dark:border-green-500');
                    taxNumberInput.classList.add('border-red-500', 'dark:border-red-500');
                    taxNumberMessage.textContent = '<?php echo e(__("frontend.tax_number_already_used")); ?>';
                    taxNumberMessage.classList.remove('hidden', 'text-green-600', 'dark:text-green-400');
                    taxNumberMessage.classList.add('text-red-600', 'dark:text-red-400');
                }
            } catch (error) {
                console.error('Error checking tax number:', error);
            }
        }, 500);
    }

    // Password Toggle Functionality
    const passwordInput = document.getElementById('password');
    const passwordConfirmInput = document.getElementById('password_confirmation');
    const togglePasswordBtn = document.getElementById('toggle-password');
    const togglePasswordConfirmBtn = document.getElementById('toggle-password-confirm');

    togglePasswordBtn?.addEventListener('click', function() {
        const type = passwordInput.type === 'password' ? 'text' : 'password';
        passwordInput.type = type;
    });

    togglePasswordConfirmBtn?.addEventListener('click', function() {
        const type = passwordConfirmInput.type === 'password' ? 'text' : 'password';
        passwordConfirmInput.type = type;
    });

    // Password Validation
    let passwordTimeout;
    const passwordMessage = document.getElementById('password-message');
    const passwordConfirmMessage = document.getElementById('password-confirm-message');

    passwordInput?.addEventListener('input', function() {
        const value = this.value;
        
        // English characters only validation
        const originalValue = value;
        const englishValue = value.replace(/[^A-Za-z0-9!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/g, '');
        
        if (originalValue !== englishValue) {
            this.value = englishValue;
            this.classList.add('border-red-500', 'dark:border-red-500');
            passwordMessage.textContent = '<?php echo e(__("frontend.english_characters_only")); ?>';
            passwordMessage.classList.remove('text-slate-500', 'dark:text-slate-400', 'text-green-600', 'dark:text-green-400');
            passwordMessage.classList.add('text-red-600', 'dark:text-red-400');
            passwordMessage.classList.remove('hidden');
            
            clearTimeout(passwordTimeout);
            passwordTimeout = setTimeout(() => {
                if (this.value.length >= 8) {
                    this.classList.remove('border-red-500', 'dark:border-red-500');
                    passwordMessage.textContent = '<?php echo e(__("frontend.password_requirements")); ?>';
                    passwordMessage.classList.remove('text-red-600', 'dark:text-red-400');
                    passwordMessage.classList.add('text-slate-500', 'dark:text-slate-400');
                }
            }, 3000);
            return;
        }

        // Password strength indicator
        if (value.length >= 8) {
            this.classList.remove('border-red-500', 'dark:border-red-500');
            this.classList.add('border-green-500', 'dark:border-green-500');
            passwordMessage.textContent = '<?php echo e(__("frontend.password_strong")); ?>';
            passwordMessage.classList.remove('text-red-600', 'dark:text-red-400', 'text-slate-500', 'dark:text-slate-400');
            passwordMessage.classList.add('text-green-600', 'dark:text-green-400');
            passwordMessage.classList.remove('hidden');
        } else {
            this.classList.remove('border-green-500', 'dark:border-green-500');
            passwordMessage.textContent = '<?php echo e(__("frontend.password_requirements")); ?>';
            passwordMessage.classList.remove('text-green-600', 'dark:text-green-400', 'text-red-600', 'dark:text-red-400');
            passwordMessage.classList.add('text-slate-500', 'dark:text-slate-400');
        }

        // Check if passwords match
        if (passwordConfirmInput.value) {
            checkPasswordMatch();
        }
    });

    // Confirm Password Validation
    passwordConfirmInput?.addEventListener('input', function() {
        const value = this.value;
        
        // English characters only validation
        const originalValue = value;
        const englishValue = value.replace(/[^A-Za-z0-9!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/g, '');
        
        if (originalValue !== englishValue) {
            this.value = englishValue;
            this.classList.add('border-red-500', 'dark:border-red-500');
            passwordConfirmMessage.textContent = '<?php echo e(__("frontend.english_characters_only")); ?>';
            passwordConfirmMessage.classList.remove('hidden');
            
            setTimeout(() => {
                checkPasswordMatch();
            }, 3000);
            return;
        }

        checkPasswordMatch();
    });

    function checkPasswordMatch() {
        const password = passwordInput.value;
        const confirmPassword = passwordConfirmInput.value;

        if (confirmPassword.length === 0) {
            passwordConfirmInput.classList.remove('border-red-500', 'dark:border-red-500', 'border-green-500', 'dark:border-green-500');
            passwordConfirmMessage.classList.add('hidden');
            return;
        }

        if (password === confirmPassword) {
            passwordConfirmInput.classList.remove('border-red-500', 'dark:border-red-500');
            passwordConfirmInput.classList.add('border-green-500', 'dark:border-green-500');
            passwordConfirmMessage.textContent = '<?php echo e(__("frontend.passwords_match")); ?>';
            passwordConfirmMessage.classList.remove('text-red-600', 'dark:text-red-400');
            passwordConfirmMessage.classList.add('text-green-600', 'dark:text-green-400');
            passwordConfirmMessage.classList.remove('hidden');
        } else {
            passwordConfirmInput.classList.remove('border-green-500', 'dark:border-green-500');
            passwordConfirmInput.classList.add('border-red-500', 'dark:border-red-500');
            passwordConfirmMessage.textContent = '<?php echo e(__("frontend.passwords_dont_match")); ?>';
            passwordConfirmMessage.classList.remove('text-green-600', 'dark:text-green-400');
            passwordConfirmMessage.classList.add('text-red-600', 'dark:text-red-400');
            passwordConfirmMessage.classList.remove('hidden');
        }
    }

    // Payment Method Selection
    const paymentMethodRadios = document.querySelectorAll('.payment-method-radio');
    const paymentMethodCards = document.querySelectorAll('.payment-method-card');
    
    paymentMethodRadios.forEach((radio, index) => {
        radio.addEventListener('change', function() {
            // Remove selection from all cards
            paymentMethodCards.forEach(card => {
                const content = card.querySelector('.payment-method-content');
                const checkmark = card.querySelector('.payment-method-checkmark');
                content.classList.remove('border-blue-500', 'dark:border-blue-400', 'bg-blue-50', 'dark:bg-blue-900/20');
                checkmark.classList.add('hidden');
            });
            
            // Add selection to current card
            if (this.checked) {
                const card = paymentMethodCards[index];
                const content = card.querySelector('.payment-method-content');
                const checkmark = card.querySelector('.payment-method-checkmark');
                content.classList.add('border-blue-500', 'dark:border-blue-400', 'bg-blue-50', 'dark:bg-blue-900/20');
                checkmark.classList.remove('hidden');
            }
        });
    });
    
    // Auto-select first payment method if available
    if (paymentMethodRadios.length > 0) {
        // Check if wallet payment exists and has insufficient balance
        const walletRadio = document.querySelector('input[name="payment_method"][value="wallet"]');
        <?php if(auth()->guard('client')->check()): ?>
        const walletBalance = <?php echo e(auth('client')->user()->wallet_balance ?? 0); ?>;
        const orderTotal = <?php echo e($total); ?>;
        
        if (walletRadio && walletBalance < orderTotal) {
            // Disable wallet option if insufficient balance
            walletRadio.disabled = true;
            walletRadio.closest('.payment-method-card').style.opacity = '0.5';
            walletRadio.closest('.payment-method-card').style.cursor = 'not-allowed';
            
            // Select first non-disabled payment method
            const enabledRadio = Array.from(paymentMethodRadios).find(radio => !radio.disabled);
            if (enabledRadio) {
                enabledRadio.checked = true;
                enabledRadio.dispatchEvent(new Event('change'));
            }
        } else {
            paymentMethodRadios[0].checked = true;
            paymentMethodRadios[0].dispatchEvent(new Event('change'));
        }
        <?php else: ?>
        paymentMethodRadios[0].checked = true;
        paymentMethodRadios[0].dispatchEvent(new Event('change'));
        <?php endif; ?>
    }

    // Terms and Conditions Checkbox Handler
    const termsCheckbox = document.getElementById('terms-checkbox');
    const placeOrderBtn = document.getElementById('place-order-btn');
    const termsError = document.getElementById('terms-error');
    
    console.log('=== Terms Validation Setup ===');
    console.log('Terms checkbox found:', !!termsCheckbox);
    console.log('Place order button found:', !!placeOrderBtn);
    
    // إذا كان المستخدم قد وافق على الشروط سابقاً، لن يكون هناك checkbox
    const termsAlreadyAccepted = !termsCheckbox;
    console.log('Terms already accepted:', termsAlreadyAccepted);
    
    if (placeOrderBtn) {
        console.log('Setting up button click handler');
        
        // استخدم button click بدل form submit عشان نتأكد إنه شغال
        placeOrderBtn.addEventListener('click', function(e) {
            console.log('=== PLACE ORDER BUTTON CLICKED ===');
            console.log('Terms already accepted:', termsAlreadyAccepted);
            if (termsCheckbox) {
                console.log('Terms checked:', termsCheckbox.checked);
            }
            console.log('Button type:', this.type);
            
            // Check terms only if checkbox exists (user hasn't accepted before)
            if (termsCheckbox && !termsCheckbox.checked) {
                console.log('BLOCKED: Terms not accepted!');
                e.preventDefault();
                e.stopPropagation();
                
                termsError.textContent = '<?php echo e(__("frontend.please_accept_terms") ?? "Please accept the terms and conditions"); ?>';
                termsError.classList.remove('hidden');
                
                // Scroll to terms checkbox
                termsCheckbox.scrollIntoView({ behavior: 'smooth', block: 'center' });
                
                // Shake animation
                termsCheckbox.parentElement.classList.add('shake');
                setTimeout(() => {
                    termsCheckbox.parentElement.classList.remove('shake');
                }, 500);
                return false;
            }
            
            // Check Turnstile (تحذير فقط للتطوير المحلي)
            const turnstileResponse = document.querySelector('[name="cf-turnstile-response"]');
            if (!turnstileResponse || !turnstileResponse.value) {
                // تحذير فقط - لا نوقف الإرسال في بيئة التطوير
                console.warn('Turnstile token not found - continuing anyway for local development');
            }
            
            // Show loading state
            console.log('=== Terms validated, allowing form submit ===');
            const loadingText = '<?php echo e(__("frontend.processing") ?? "Processing..."); ?>';
            this.disabled = true;
            this.innerHTML = '<span class="flex items-center justify-center gap-2"><svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>' + loadingText + '</span>';
            console.log('Button disabled, submitting form...');
            
            // Submit the form manually
            const form = this.closest('form') || document.querySelector('form[action*="checkout.process"]') || document.querySelector('form');
            console.log('Form search result:', !!form);
            if (form) {
                console.log('Form found, submitting...');
                console.log('Form action:', form.action);
                console.log('Form method:', form.method);
                
                // Check CSRF token
                const csrfToken = form.querySelector('[name="_token"]');
                console.log('CSRF token found:', !!csrfToken);
                console.log('CSRF token value:', csrfToken ? csrfToken.value.substring(0, 20) + '...' : 'MISSING');
                
                // Check payment method
                const paymentMethod = form.querySelector('[name="payment_method"]');
                console.log('Payment method field:', !!paymentMethod);
                console.log('Payment method value:', paymentMethod ? paymentMethod.value : 'MISSING');
                
                // Log form data
                const formData = new FormData(form);
                console.log('Form data entries:');
                for (let [key, value] of formData.entries()) {
                    if (key === '_token') {
                        console.log(`  ${key}: ${value.substring(0, 20)}...`);
                    } else if (key === 'password' || key === 'password_confirmation') {
                        console.log(`  ${key}: [HIDDEN]`);
                    } else {
                        console.log(`  ${key}: ${value}`);
                    }
                }
                
                form.submit();
            } else {
                console.error('ERROR: Form not found by any method!');
                console.log('Allowing default button submit behavior...');
                // لو مالقناش form، خليه يعمل default submit (لأن type="submit")
            }
        });
        
        // Hide error when checkbox is checked
        termsCheckbox.addEventListener('change', function() {
            if (this.checked) {
                termsError.classList.add('hidden');
            }
        });
    }

    // Cloudflare Turnstile Callbacks
    window.onTurnstileSuccess = function(token) {
        console.log('Turnstile verification successful');
    };

    window.onTurnstileError = function(error) {
        console.error('Turnstile verification failed:', error);
        alert('<?php echo e(app()->getLocale() == "ar" ? "فشل التحقق الأمني. يرجى إعادة المحاولة." : "Security verification failed. Please try again."); ?>');
    };
});
</script>

<style>
.payment-method-radio:checked + .payment-method-content {
    border-color: #1e293b !important;
    background-color: #f8fafc;
}

.dark .payment-method-radio:checked + .payment-method-content {
    border-color: #e2e8f0 !important;
    background-color: #1e293b;
}

.payment-method-radio:checked + .payment-method-content .payment-method-checkmark {
    display: block;
}
</style>

<?php $__env->startPush('scripts'); ?>
<!-- Cloudflare Turnstile -->
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\resources\views/frontend/cart/checkout.blade.php ENDPATH**/ ?>