<!-- Footer with Glass Morphism -->
<footer class="relative overflow-hidden" dir="<?php echo e(app()->getLocale() == 'ar' ? 'rtl' : 'ltr'); ?>">
    <!-- Animated Background Blobs -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 <?php echo e(app()->getLocale() == 'ar' ? '-left-40' : '-right-40'); ?> w-96 h-96 bg-gradient-to-br from-blue-400/30 to-purple-500/30 rounded-full blur-3xl animate-blob"></div>
        <div class="absolute -bottom-40 <?php echo e(app()->getLocale() == 'ar' ? '-right-40' : '-left-40'); ?> w-96 h-96 bg-gradient-to-tr from-cyan-400/30 to-blue-500/30 rounded-full blur-3xl animate-blob animation-delay-2000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-br from-purple-400/20 to-pink-500/20 rounded-full blur-3xl animate-blob animation-delay-4000"></div>
    </div>

    <!-- Glass Container -->
    <div class="relative glass-footer backdrop-blur-3xl bg-white/40 dark:bg-gray-900/40 border-t border-white/20">
        <div class="w-full px-4 py-12 lg:py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-8 lg:gap-6">
                
                <!-- Company Info -->
                <div class="space-y-4 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?>">
                    <div class="flex items-center gap-3">
                        <?php if(!empty($websiteLogo ?? setting('website_logo'))): ?>
                            <!-- Display uploaded logo -->
                            <img src="<?php echo e(asset('storage/' . ($websiteLogo ?? setting('website_logo')))); ?>" 
                                 alt="<?php echo e($companyName ?? setting('company_name', 'Pro Gineous')); ?>" 
                                 class="h-12 w-auto object-contain">
                        <?php else: ?>
                            <!-- Fallback to icon + text -->
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                                </svg>
                            </div>
                            <span class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                <?php echo e($companyName ?? setting('company_name', 'Pro Gineous')); ?>

                            </span>
                        <?php endif; ?>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed">
                        <?php echo e(__('frontend.footer_description')); ?>

                    </p>
                    
                    <!-- Social Media -->
                    <div class="flex items-center gap-3 pt-2">
                        <a href="#" class="w-10 h-10 rounded-xl bg-white/60 hover:bg-white/80 backdrop-blur-sm flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg group">
                            <svg class="w-5 h-5 text-gray-600 group-hover:text-blue-600 transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-xl bg-white/60 hover:bg-white/80 backdrop-blur-sm flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg group">
                            <svg class="w-5 h-5 text-gray-600 group-hover:text-blue-400 transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-xl bg-white/60 hover:bg-white/80 backdrop-blur-sm flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg group">
                            <svg class="w-5 h-5 text-gray-600 group-hover:text-pink-600 transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-xl bg-white/60 hover:bg-white/80 backdrop-blur-sm flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg group">
                            <svg class="w-5 h-5 text-gray-600 group-hover:text-blue-700 transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Domains -->
                <div class="text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?>">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">
                        <?php echo e(__('frontend.domains')); ?>

                    </h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="<?php echo e(route('domains.search')); ?>" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm block">
                                <?php echo e(__('frontend.domain_name_search')); ?>

                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('domains.transfer')); ?>" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm block"><?php echo e(__('frontend.domain_transfer')); ?>

                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('domains.new-tlds')); ?>" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm block"><?php echo e(__('frontend.new_tlds')); ?>

                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('domains.bulk-search')); ?>" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm block"><?php echo e(__('frontend.bulk_domain_search')); ?>

                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('domains.tld-list')); ?>" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm block"><?php echo e(__('frontend.tld_list')); ?>

                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('domains.whois')); ?>" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm block"><?php echo e(__('frontend.whois_lookup')); ?>

                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('domains.freedns')); ?>" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm block"><?php echo e(__('frontend.free_dns')); ?>

                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Hosting -->
                <div class="text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?>">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">
                        <?php echo e(__('frontend.hosting')); ?>

                    </h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="<?php echo e(route('hosting.shared')); ?>" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm block"><?php echo e(__('frontend.shared_hosting')); ?>

                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('hosting.cloud')); ?>" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm block"><?php echo e(__('frontend.cloud_hosting')); ?>

                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm block"><?php echo e(__('frontend.reseller_hosting')); ?>

                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm flex items-center">
                                <?php echo e(__('frontend.wordpress_hosting')); ?>

                                <span class="mr-2 ml-2 px-2 py-0.5 text-xs font-semibold text-blue-600 bg-blue-100 rounded-full"><?php echo e(__('frontend.coming_soon')); ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('vps.hosting')); ?>" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm block"><?php echo e(__('frontend.vps_hosting')); ?>

                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('dedicated.servers')); ?>" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm block"><?php echo e(__('frontend.dedicated_servers')); ?>

                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm block"><?php echo e(__('frontend.migrate_to_pro_gineous')); ?>

                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Email -->
                <div class="text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?>">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">
                        <?php echo e(__('frontend.business_email')); ?>

                    </h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm block"><?php echo e(__('frontend.business_email')); ?>

                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm block"><?php echo e(__('frontend.migrate_email')); ?>

                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm block"><?php echo e(__('frontend.anti_spam_protection')); ?>

                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm block"><?php echo e(__('frontend.login_to_webmail')); ?>

                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Transfer to Us -->
                <div class="text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?>">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">
                        <?php echo e(__('frontend.transfer_to_us')); ?>

                    </h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm block"><?php echo e(__('frontend.transfer_domains')); ?>

                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm block"><?php echo e(__('frontend.migrate_hosting')); ?>

                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm flex items-center">
                                <?php echo e(__('frontend.migrate_wordpress')); ?>

                                <span class="mr-2 ml-2 px-2 py-0.5 text-xs font-semibold text-blue-600 bg-blue-100 rounded-full"><?php echo e(__('frontend.coming_soon')); ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm block"><?php echo e(__('frontend.migrate_email')); ?>

                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Security -->
                <div class="text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?>">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">
                        <?php echo e(__('frontend.security')); ?>

                    </h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm block"><?php echo e(__('frontend.domain_privacy')); ?>

                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm block"><?php echo e(__('frontend.website_security')); ?>

                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm block"><?php echo e(__('frontend.fix_hacked_website')); ?>

                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm block"><?php echo e(__('frontend.cdn')); ?>

                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm block"><?php echo e(__('frontend.fast_vpn')); ?>

                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm block"><?php echo e(__('frontend.cyber_insurance')); ?>

                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm block"><?php echo e(__('frontend.2fa')); ?>

                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm block"><?php echo e(__('frontend.public_dns')); ?>

                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm block"><?php echo e(__('frontend.anti_spam_protection')); ?>

                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Help Center -->
                <div class="text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?>">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">
                        <?php echo e(__('frontend.help_center')); ?>

                    </h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm block"><?php echo e(__('frontend.status_updates')); ?>

                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm block"><?php echo e(__('frontend.knowledgebase')); ?>

                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm block"><?php echo e(__('frontend.submit_ticket')); ?>

                            </a>
                        </li>
                        <li>
                            <a href="#" onclick="event.preventDefault(); showIntercom();" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm block"><?php echo e(__('frontend.live_chat')); ?>

                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm block"><?php echo e(__('frontend.report_abuse')); ?>

                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 text-sm block"><?php echo e(__('frontend.discounts')); ?>

                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Featured Links -->
                <div class="text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?>">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">
                        <?php echo e(__('frontend.featured_links')); ?>

                    </h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="<?php echo e(route('about')); ?>" class="relative group block px-3 py-2 rounded-lg bg-gradient-to-r from-indigo-500/10 via-blue-500/10 to-cyan-500/10 hover:from-indigo-500/20 hover:via-blue-500/20 hover:to-cyan-500/20 transition-all duration-300 border border-indigo-500/20 hover:border-indigo-500/40 hover:shadow-lg hover:shadow-indigo-500/20">
                                <span class="text-sm font-semibold bg-gradient-to-r from-indigo-600 via-blue-600 to-cyan-600 bg-clip-text text-transparent">
                                    <?php echo e(__('frontend.about_us')); ?>

                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('careers')); ?>" class="relative group block px-3 py-2 rounded-lg bg-gradient-to-r from-purple-500/10 via-pink-500/10 to-red-500/10 hover:from-purple-500/20 hover:via-pink-500/20 hover:to-red-500/20 transition-all duration-300 border border-purple-500/20 hover:border-purple-500/40 hover:shadow-lg hover:shadow-purple-500/20">
                                <span class="text-sm font-semibold bg-gradient-to-r from-purple-600 via-pink-600 to-red-600 bg-clip-text text-transparent">
                                    <?php echo e(__('frontend.careers')); ?>

                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="relative group block px-3 py-2 rounded-lg bg-gradient-to-r from-blue-500/10 via-cyan-500/10 to-teal-500/10 hover:from-blue-500/20 hover:via-cyan-500/20 hover:to-teal-500/20 transition-all duration-300 border border-blue-500/20 hover:border-blue-500/40 hover:shadow-lg hover:shadow-blue-500/20">
                                <span class="text-sm font-semibold bg-gradient-to-r from-blue-600 via-cyan-600 to-teal-600 bg-clip-text text-transparent">
                                    <?php echo e(__('frontend.pro_gineous_students')); ?>

                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="relative group block px-3 py-2 rounded-lg bg-gradient-to-r from-orange-500/10 via-amber-500/10 to-yellow-500/10 hover:from-orange-500/20 hover:via-amber-500/20 hover:to-yellow-500/20 transition-all duration-300 border border-orange-500/20 hover:border-orange-500/40 hover:shadow-lg hover:shadow-orange-500/20">
                                <span class="text-sm font-semibold bg-gradient-to-r from-orange-600 via-amber-600 to-yellow-600 bg-clip-text text-transparent">
                                    <?php echo e(__('frontend.affiliates')); ?>

                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="relative group block px-3 py-2 rounded-lg bg-gradient-to-r from-green-500/10 via-emerald-500/10 to-teal-500/10 hover:from-green-500/20 hover:via-emerald-500/20 hover:to-teal-500/20 transition-all duration-300 border border-green-500/20 hover:border-green-500/40 hover:shadow-lg hover:shadow-green-500/20">
                                <span class="text-sm font-semibold bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 bg-clip-text text-transparent">
                                    <?php echo e(__('frontend.send_feedback')); ?>

                                </span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Contact Information -->
                <div class="text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?>">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">
                        <?php echo e(__('frontend.contact_information')); ?>

                    </h3>
                    <div class="space-y-4">
                        <!-- Email -->
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1"><?php echo e(__('frontend.email')); ?></p>
                                <a href="mailto:info@progineous.com" class="text-sm text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                    info@progineous.com
                                </a>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1"><?php echo e(__('frontend.phone')); ?></p>
                                <a href="tel:+201009839264" class="text-sm text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors" dir="ltr">
                                    +20 100 983 9264
                                </a>
                            </div>
                        </div>

                        <!-- UK Address -->
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-2 flex items-center gap-1">
                                    <span class="font-semibold">🇬🇧 <?php echo e(__('frontend.uk_office')); ?></span>
                                </p>
                                <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
                                    <?php echo e(__('frontend.uk_address')); ?>

                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    <?php echo e(__('frontend.registration_number')); ?>: 16307182
                                </p>
                            </div>
                        </div>

                        <!-- Egypt Address -->
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-2 flex items-center gap-1">
                                    <span class="font-semibold">🇪🇬 <?php echo e(__('frontend.egypt_office')); ?></span>
                                </p>
                                <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
                                    <?php echo e(__('frontend.egypt_address')); ?>

                                </p>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 space-y-0.5">
                                    <p><?php echo e(__('frontend.registration_number')); ?>: 90088</p>
                                    <p><?php echo e(__('frontend.tax_registration_number')); ?>: 755-552-334</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Payment Methods -->
            <div class="mt-12 pt-8 border-t border-white/20">
                <div class="text-center">
                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-6">
                        <?php echo e(__('frontend.payment_methods')); ?>

                    </h4>
                    <div class="flex flex-wrap items-center justify-center gap-4">
                        <?php if(isset($fawaterakPaymentMethods) && count($fawaterakPaymentMethods) > 0): ?>
                            <?php $__currentLoopData = $fawaterakPaymentMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="group relative">
                                    <div class="w-20 h-14 bg-white/80 backdrop-blur-md rounded-xl p-2 flex items-center justify-center hover:bg-white transition-all duration-300 hover:scale-110 hover:shadow-lg border border-white/40">
                                        <img src="<?php echo e($method['logo']); ?>" 
                                             alt="<?php echo e($method['nameEn'] ?? $method['name_en'] ?? 'Payment Method'); ?>" 
                                             class="max-w-full max-h-full object-contain"
                                             loading="lazy"
                                             title="<?php echo e($method['nameAr'] ?? $method['name_ar'] ?? 'طريقة دفع'); ?>">
                                    </div>
                                    <!-- Tooltip on hover -->
                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-1 bg-gray-900 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap pointer-events-none">
                                        <?php echo e(app()->getLocale() == 'ar' ? ($method['nameAr'] ?? $method['name_ar'] ?? 'طريقة دفع') : ($method['nameEn'] ?? $method['name_en'] ?? 'Payment Method')); ?>

                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <!-- Fallback Payment Icons -->
                            <div class="w-16 h-10 bg-white/60 backdrop-blur-sm rounded-lg p-2 flex items-center justify-center hover:bg-white/80 transition-all duration-300 hover:scale-110 shadow-sm">
                                <svg class="w-full h-full text-blue-600" fill="currentColor" viewBox="0 0 48 48">
                                    <path d="M44 4H4C1.79 4 0 5.79 0 8v32c0 2.21 1.79 4 4 4h40c2.21 0 4-1.79 4-4V8c0-2.21-1.79-4-4-4zm0 36H4V12h40v28z"/>
                                </svg>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="mt-12 pt-8 border-t border-white/20">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <p class="text-sm text-gray-600 dark:text-gray-400 text-center md:text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?>">
                        © <?php echo e(date('Y')); ?> <?php echo e($companyName ?? setting('company_name', 'Pro Gineous')); ?>. <?php echo e(__('frontend.all_rights_reserved')); ?>

                    </p>
                    <div class="flex flex-wrap items-center justify-center md:justify-<?php echo e(app()->getLocale() == 'ar' ? 'start' : 'end'); ?> gap-4 text-sm text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?>">
                        <a href="#" class="px-3 py-1.5 text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md whitespace-nowrap">
                            <?php echo e(__('frontend.terms_and_conditions')); ?>

                        </a>
                        <a href="#" class="px-3 py-1.5 text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md whitespace-nowrap">
                            <?php echo e(__('frontend.privacy_policy')); ?>

                        </a>
                        <a href="#" class="px-3 py-1.5 text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md whitespace-nowrap">
                            <?php echo e(__('frontend.udrp')); ?>

                        </a>
                        <a href="#" class="px-3 py-1.5 text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md whitespace-nowrap">
                            <?php echo e(__('frontend.domain_registration_data_disclosure')); ?>

                        </a>
                        <a href="#" class="px-3 py-1.5 text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md whitespace-nowrap">
                            <?php echo e(__('frontend.cookie_preferences')); ?>

                        </a>
                    </div>
                </div>
            </div>

            <!-- ICANN & Palestine Support Section -->
            <div class="mt-8 pt-8 border-t border-white/20">
                <div class="flex flex-col lg:flex-row items-center justify-center gap-8 lg:gap-12">
                    <!-- ICANN Section -->
                    <div class="flex flex-col md:flex-row items-center justify-center gap-6">
                        <!-- ICANN Logo -->
                        <div class="flex-shrink-0">
                            <img src="<?php echo e(asset('logo/R.png')); ?>" 
                                 alt="ICANN Accredited Registrar" 
                                 class="h-12 w-auto object-contain"
                                 loading="lazy">
                        </div>
                        <!-- ICANN Text -->
                        <div class="text-center md:text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?>">
                            <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                <?php echo e(__('frontend.icann_accredited')); ?>

                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                <?php echo e(__('frontend.serving_since')); ?>

                            </p>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="hidden lg:block w-px h-16 bg-white/20"></div>

                    <!-- Palestine Support Section -->
                    <div class="relative">
                        <div class="flex items-center gap-4 px-6 py-3 rounded-xl bg-gradient-to-r from-green-600/10 via-white/10 to-red-600/10 border-2 border-white/30 backdrop-blur-sm hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                            <!-- Palestine Flag -->
                            <div class="flex-shrink-0">
                                <div class="w-14 h-10 rounded shadow-md overflow-hidden relative">
                                    <!-- Black stripe -->
                                    <div class="absolute top-0 left-0 right-0 h-1/3 bg-black"></div>
                                    <!-- White stripe -->
                                    <div class="absolute top-1/3 left-0 right-0 h-1/3 bg-white"></div>
                                    <!-- Green stripe -->
                                    <div class="absolute bottom-0 left-0 right-0 h-1/3 bg-green-600"></div>
                                    <!-- Red triangle -->
                                    <svg class="absolute top-0 left-0 w-full h-full" viewBox="0 0 56 40" preserveAspectRatio="none">
                                        <polygon points="0,0 0,40 22,20" fill="#E4312B"/>
                                    </svg>
                                </div>
                            </div>
                            <!-- Support Text -->
                            <div class="text-center">
                                <p class="text-sm font-bold bg-gradient-to-r from-green-600 via-black to-red-600 bg-clip-text text-transparent animate-pulse">
                                    <?php echo e(__('frontend.support_palestine')); ?>

                                </p>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-0.5">
                                    🕊️ <?php echo e(__('frontend.stand_with_palestine')); ?>

                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php /**PATH C:\laragon\www\resources\views/frontend/partials/footer.blade.php ENDPATH**/ ?>