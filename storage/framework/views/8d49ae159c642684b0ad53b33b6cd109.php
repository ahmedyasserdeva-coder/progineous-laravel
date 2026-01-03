

<?php $__env->startSection('title', $service->domain . ' - ' . config('app.name')); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Cancellation Request Notice -->
        <?php if($service->cancellation_requested_at): ?>
        <div class="bg-orange-100 dark:bg-orange-900/30 border-l-4 border-orange-500 rounded-lg p-4 mb-6 shadow-md">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-orange-800 dark:text-orange-200 mb-1">
                        <?php echo e(__('frontend.cancellation_pending') ?? 'Cancellation Request Pending'); ?>

                    </h3>
                    <p class="text-sm text-orange-700 dark:text-orange-300 mb-2">
                        <?php echo e(__('frontend.cancellation_submitted_on') ?? 'Cancellation request submitted on'); ?>: 
                        <strong><?php echo e(\Carbon\Carbon::parse($service->cancellation_requested_at)->format('M d, Y \a\t h:i A')); ?></strong>
                    </p>
                    <p class="text-sm text-orange-600 dark:text-orange-400">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <?php echo e(__('frontend.cancellation_processing_notice') ?? 'Your request is being processed. Expected processing time: 24 hours.'); ?>

                    </p>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Service Header with Gradient and Usage Charts -->
        <div class="relative bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-700 rounded-2xl shadow-2xl overflow-hidden mb-8">
            <!-- Elegant Static Pattern -->
            <div class="absolute inset-0 opacity-10">
                <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                            <circle cx="20" cy="20" r="1.5" fill="white" opacity="0.3"/>
                        </pattern>
                        <pattern id="waves" width="100" height="100" patternUnits="userSpaceOnUse">
                            <path d="M0 50 Q 25 30, 50 50 T 100 50" stroke="white" stroke-width="0.5" fill="none" opacity="0.2"/>
                            <path d="M0 60 Q 25 40, 50 60 T 100 60" stroke="white" stroke-width="0.5" fill="none" opacity="0.15"/>
                        </pattern>
                        <linearGradient id="fadeGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:white;stop-opacity:0.15" />
                            <stop offset="50%" style="stop-color:white;stop-opacity:0.05" />
                            <stop offset="100%" style="stop-color:white;stop-opacity:0.1" />
                        </linearGradient>
                    </defs>
                    
                    <!-- Background layers -->
                    <rect width="100%" height="100%" fill="url(#grid)"/>
                    <rect width="100%" height="100%" fill="url(#waves)"/>
                    <rect width="100%" height="100%" fill="url(#fadeGradient)"/>
                    
                    <!-- Decorative circles -->
                    <circle cx="10%" cy="20%" r="120" fill="white" opacity="0.03"/>
                    <circle cx="85%" cy="70%" r="150" fill="white" opacity="0.04"/>
                    <circle cx="50%" cy="50%" r="200" fill="white" opacity="0.02"/>
                    
                    <!-- Elegant lines -->
                    <line x1="0" y1="30%" x2="100%" y2="30%" stroke="white" stroke-width="0.5" opacity="0.1"/>
                    <line x1="0" y1="70%" x2="100%" y2="70%" stroke="white" stroke-width="0.5" opacity="0.1"/>
                </svg>
            </div>
            
            <div class="relative px-8 py-10">
                <!-- Top Section: Service Info -->
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8">
                    <div class="flex items-start lg:items-center mb-6 lg:mb-0 gap-6">
                        <div class="flex-shrink-0 h-20 w-20 flex items-center justify-center bg-white/20 backdrop-blur-sm rounded-2xl ring-4 ring-white/30">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-3 mb-2">
                                <h1 class="text-3xl font-bold text-white">
                                    <?php echo e($service->domain); ?>

                                </h1>
                                <?php if($service->status === 'active'): ?>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-500/20 text-green-100 ring-2 ring-green-400/30 <?php echo e(app()->getLocale() == 'ar' ? 'flex-row-reverse' : ''); ?>">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3"/>
                                        </svg>
                                        <?php echo e(__('frontend.active') ?? 'Active'); ?>

                                    </span>
                                <?php elseif($service->status === 'pending'): ?>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-yellow-500/20 text-yellow-100 ring-2 ring-yellow-400/30 <?php echo e(app()->getLocale() == 'ar' ? 'flex-row-reverse' : ''); ?>">
                                        <svg class="w-3 h-3 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        <?php echo e(__('frontend.pending') ?? 'Pending'); ?>

                                    </span>
                                <?php elseif($service->status === 'suspended'): ?>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-500/20 text-red-100 ring-2 ring-red-400/30 <?php echo e(app()->getLocale() == 'ar' ? 'flex-row-reverse' : ''); ?>">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3"/>
                                        </svg>
                                        <?php echo e(__('frontend.suspended') ?? 'Suspended'); ?>

                                    </span>
                                <?php endif; ?>
                            </div>
                            <p class="text-blue-100 text-sm flex items-center gap-3 <?php echo e(app()->getLocale() == 'ar' ? 'flex-row-reverse' : ''); ?>">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                </svg>
                                <?php echo e($service->service_name ?? __('frontend.shared_hosting')); ?>

                            </p>
                            <p class="text-blue-200/80 text-xs mt-1 <?php echo e(app()->getLocale() == 'ar' ? 'text-right' : ''); ?>" dir="ltr">
                                <?php echo e(__('frontend.service_id') ?? 'Service ID'); ?>: #<?php echo e($service->order_id ?? $service->id); ?>

                            </p>
                        </div>
                    </div>
                    
                    <!-- Quick Access Buttons -->
                    <?php if($service->status === 'active' && $service->username): ?>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="<?php echo e(route('client.hosting.cpanel', $service->id)); ?>" target="_blank" class="inline-flex items-center justify-center px-6 py-3 bg-white text-blue-600 rounded-xl hover:bg-blue-50 font-semibold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 <?php echo e(app()->getLocale() == 'ar' ? 'flex-row-reverse' : ''); ?>">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            <?php echo e(__('frontend.open_cpanel') ?? 'Open cPanel'); ?>

                        </a>
                        <button class="inline-flex items-center justify-center px-6 py-3 bg-white/10 backdrop-blur-sm text-white rounded-xl hover:bg-white/20 font-semibold border-2 border-white/30 transition-all duration-200 <?php echo e(app()->getLocale() == 'ar' ? 'flex-row-reverse' : ''); ?>">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <?php echo e(__('frontend.get_support') ?? 'Get Support'); ?>

                        </button>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Usage Statistics Charts -->
                <?php if($service->status === 'active' && !empty($stats)): ?>
                <div id="statsSection" class="relative bg-white/5 backdrop-blur-xl rounded-2xl border border-white/30 p-8 shadow-2xl transition-all duration-500">
                    <!-- Glass effect overlay -->
                    <div class="absolute inset-0 bg-gradient-to-br from-white/10 via-white/5 to-transparent rounded-2xl"></div>
                    
                    <!-- Toggle Button -->
                    <button onclick="toggleStats()" class="absolute top-4 <?php echo e(app()->getLocale() == 'ar' ? 'left-4' : 'right-4'); ?> z-10 w-10 h-10 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center hover:bg-white/20 transition-all duration-200 ring-2 ring-white/20 hover:ring-white/30 group">
                        <svg id="statsToggleIcon" class="w-5 h-5 text-white transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                        </svg>
                    </button>
                    
                    <div id="statsContent" class="relative">
                        <h3 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
                            <div class="w-10 h-10 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center ring-2 ring-white/20">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <?php echo e(__('frontend.usage_statistics') ?? 'Usage Statistics'); ?>

                        </h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <!-- Disk Usage Chart -->
                        <div class="flex flex-col items-center chart-container group">
                            <div class="relative w-36 h-36 transition-all duration-300 group-hover:scale-110 group-hover:drop-shadow-2xl">
                                <canvas id="diskChart"></canvas>
                                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                    <div class="text-center">
                                        <div class="text-3xl font-bold text-white transition-all duration-300 group-hover:scale-110" id="disk-chart-percent"><?php echo e($stats['disk_percent']); ?>%</div>
                                    </div>
                                </div>
                                <!-- Tooltip -->
                                <div class="chart-tooltip absolute top-full left-1/2 -translate-x-1/2 mt-2 bg-gray-900 text-white text-xs rounded-lg px-3 py-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none z-10 whitespace-nowrap shadow-xl">
                                    <div class="font-semibold mb-1"><?php echo e(__('frontend.disk_usage') ?? 'Disk Usage'); ?></div>
                                    <div class="text-gray-300"><?php echo e(__('frontend.used') ?? 'Used'); ?>: <?php echo e($stats['disk_used']); ?></div>
                                    <div class="text-gray-300"><?php echo e(__('frontend.total') ?? 'Total'); ?>: <?php echo e($stats['disk_limit']); ?></div>
                                    <?php if($stats['disk_percent'] > 80): ?>
                                    <div class="text-red-400 mt-1">⚠️ <?php echo e(__('frontend.high_usage') ?? 'High Usage'); ?></div>
                                    <?php elseif($stats['disk_percent'] > 50): ?>
                                    <div class="text-yellow-400 mt-1">⚡ <?php echo e(__('frontend.moderate_usage') ?? 'Moderate'); ?></div>
                                    <?php else: ?>
                                    <div class="text-green-400 mt-1">✓ <?php echo e(__('frontend.healthy') ?? 'Healthy'); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="mt-4 text-center">
                                <h4 class="text-sm font-semibold text-white inline-flex items-center gap-2 transition-colors duration-200 group-hover:text-blue-300">
                                    <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                                    </svg>
                                    <?php echo e(__('frontend.disk_usage') ?? 'Disk'); ?>

                                </h4>
                                <p class="text-xs text-blue-100 mt-1" id="disk-chart-text" style="direction: ltr; text-align: center;"><?php echo e($stats['disk_used']); ?> / <?php echo e($stats['disk_limit']); ?></p>
                            </div>
                        </div>

                        <!-- Bandwidth Usage Chart -->
                        <div class="flex flex-col items-center chart-container group">
                            <div class="relative w-36 h-36 transition-all duration-300 group-hover:scale-110 group-hover:drop-shadow-2xl">
                                <canvas id="bandwidthChart"></canvas>
                                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                    <div class="text-center">
                                        <div class="text-3xl font-bold text-white transition-all duration-300 group-hover:scale-110" id="bandwidth-chart-percent"><?php echo e($stats['bandwidth_percent']); ?>%</div>
                                    </div>
                                </div>
                                <!-- Tooltip -->
                                <div class="chart-tooltip absolute top-full left-1/2 -translate-x-1/2 mt-2 bg-gray-900 text-white text-xs rounded-lg px-3 py-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none z-10 whitespace-nowrap shadow-xl">
                                    <div class="font-semibold mb-1"><?php echo e(__('frontend.bandwidth') ?? 'Bandwidth'); ?></div>
                                    <div class="text-gray-300"><?php echo e(__('frontend.used') ?? 'Used'); ?>: <?php echo e($stats['bandwidth_used']); ?></div>
                                    <div class="text-gray-300"><?php echo e(__('frontend.total') ?? 'Total'); ?>: <?php echo e($stats['bandwidth_limit']); ?></div>
                                    <?php if($stats['bandwidth_percent'] > 80): ?>
                                    <div class="text-red-400 mt-1">⚠️ <?php echo e(__('frontend.high_usage') ?? 'High Usage'); ?></div>
                                    <?php elseif($stats['bandwidth_percent'] > 50): ?>
                                    <div class="text-yellow-400 mt-1">⚡ <?php echo e(__('frontend.moderate_usage') ?? 'Moderate'); ?></div>
                                    <?php else: ?>
                                    <div class="text-green-400 mt-1">✓ <?php echo e(__('frontend.healthy') ?? 'Healthy'); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="mt-4 text-center">
                                <h4 class="text-sm font-semibold text-white inline-flex items-center gap-2 transition-colors duration-200 group-hover:text-green-300">
                                    <svg class="w-4 h-4 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                    </svg>
                                    <?php echo e(__('frontend.bandwidth') ?? 'Bandwidth'); ?>

                                </h4>
                                <p class="text-xs text-blue-100 mt-1" id="bandwidth-chart-text" style="direction: ltr; text-align: center;"><?php echo e($stats['bandwidth_used']); ?> / <?php echo e($stats['bandwidth_limit']); ?></p>
                            </div>
                        </div>

                        <!-- Addon Domains Chart -->
                        <div class="flex flex-col items-center chart-container group">
                            <div class="relative w-36 h-36 transition-all duration-300 group-hover:scale-110 group-hover:drop-shadow-2xl">
                                <canvas id="domainsChart"></canvas>
                                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                    <div class="text-center">
                                        <?php
                                            $addonPercent = 0;
                                            if (isset($stats['addon_domains']) && $stats['addon_domains'] > 0 && $stats['addon_domains'] != 999999) {
                                                $addonPercent = round((($stats['addon_domains_used'] ?? 0) / $stats['addon_domains']) * 100, 2);
                                            }
                                        ?>
                                        <div class="text-3xl font-bold text-white transition-all duration-300 group-hover:scale-110" id="domains-chart-percent"><?php echo e($addonPercent); ?>%</div>
                                    </div>
                                </div>
                                <!-- Tooltip -->
                                <div class="chart-tooltip absolute top-full left-1/2 -translate-x-1/2 mt-2 bg-gray-900 text-white text-xs rounded-lg px-3 py-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none z-10 whitespace-nowrap shadow-xl">
                                    <div class="font-semibold mb-1"><?php echo e(__('frontend.addon_domains') ?? 'Addon Domains'); ?></div>
                                    <div class="text-gray-300"><?php echo e(__('frontend.used') ?? 'Used'); ?>: <?php echo e($stats['addon_domains_used'] ?? 0); ?></div>
                                    <div class="text-gray-300"><?php echo e(__('frontend.total') ?? 'Total'); ?>: <?php echo e($stats['addon_domains'] == -1 || $stats['addon_domains'] == 999999 ? '∞' : $stats['addon_domains']); ?></div>
                                    <?php if($addonPercent > 80): ?>
                                    <div class="text-red-400 mt-1">⚠️ <?php echo e(__('frontend.high_usage') ?? 'High Usage'); ?></div>
                                    <?php elseif($addonPercent > 50): ?>
                                    <div class="text-yellow-400 mt-1">⚡ <?php echo e(__('frontend.moderate_usage') ?? 'Moderate'); ?></div>
                                    <?php else: ?>
                                    <div class="text-green-400 mt-1">✓ <?php echo e(__('frontend.healthy') ?? 'Healthy'); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="mt-4 text-center">
                                <h4 class="text-sm font-semibold text-white inline-flex items-center gap-2 transition-colors duration-200 group-hover:text-purple-300">
                                    <svg class="w-4 h-4 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                    </svg>
                                    <?php echo e(__('frontend.addon_domains') ?? 'Domains'); ?>

                                </h4>
                                <p class="text-xs text-blue-100 mt-1" id="domains-chart-text" style="direction: ltr; text-align: center;">
                                    <?php echo e($stats['addon_domains_used'] ?? 0); ?> / 
                                    <?php echo e($stats['addon_domains'] == -1 || $stats['addon_domains'] == 999999 ? '∞' : $stats['addon_domains']); ?>

                                </p>
                            </div>
                        </div>

                        <!-- Email Accounts Chart -->
                        <div class="flex flex-col items-center chart-container group">
                            <div class="relative w-36 h-36 transition-all duration-300 group-hover:scale-110 group-hover:drop-shadow-2xl">
                                <canvas id="emailChart"></canvas>
                                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                    <div class="text-center">
                                        <?php
                                            $emailPercent = 0;
                                            if (isset($stats['email_accounts']) && $stats['email_accounts'] > 0 && $stats['email_accounts'] != 999999) {
                                                $emailPercent = round((($stats['email_accounts_used'] ?? 0) / $stats['email_accounts']) * 100, 2);
                                            }
                                        ?>
                                        <div class="text-3xl font-bold text-white transition-all duration-300 group-hover:scale-110" id="email-chart-percent"><?php echo e($emailPercent); ?>%</div>
                                    </div>
                                </div>
                                <!-- Tooltip -->
                                <div class="chart-tooltip absolute top-full left-1/2 -translate-x-1/2 mt-2 bg-gray-900 text-white text-xs rounded-lg px-3 py-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none z-10 whitespace-nowrap shadow-xl">
                                    <div class="font-semibold mb-1"><?php echo e(__('frontend.email_accounts') ?? 'Email Accounts'); ?></div>
                                    <div class="text-gray-300"><?php echo e(__('frontend.used') ?? 'Used'); ?>: <?php echo e($stats['email_accounts_used'] ?? 0); ?></div>
                                    <div class="text-gray-300"><?php echo e(__('frontend.total') ?? 'Total'); ?>: <?php echo e($stats['email_accounts'] == -1 || $stats['email_accounts'] == 999999 ? '∞' : $stats['email_accounts']); ?></div>
                                    <?php if($emailPercent > 80): ?>
                                    <div class="text-red-400 mt-1">⚠️ <?php echo e(__('frontend.high_usage') ?? 'High Usage'); ?></div>
                                    <?php elseif($emailPercent > 50): ?>
                                    <div class="text-yellow-400 mt-1">⚡ <?php echo e(__('frontend.moderate_usage') ?? 'Moderate'); ?></div>
                                    <?php else: ?>
                                    <div class="text-green-400 mt-1">✓ <?php echo e(__('frontend.healthy') ?? 'Healthy'); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="mt-4 text-center">
                                <h4 class="text-sm font-semibold text-white inline-flex items-center gap-2 transition-colors duration-200 group-hover:text-orange-300">
                                    <svg class="w-4 h-4 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <?php echo e(__('frontend.email_accounts') ?? 'Email'); ?>

                                </h4>
                                <p class="text-xs text-blue-100 mt-1" id="email-chart-text" style="direction: ltr; text-align: center;">
                                    <?php echo e($stats['email_accounts_used'] ?? 0); ?> / 
                                    <?php echo e($stats['email_accounts'] == -1 || $stats['email_accounts'] == 999999 ? '∞' : $stats['email_accounts']); ?>

                                </p>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                
                <!-- Stats Notch (Hidden by default) -->
                <div id="statsNotch" class="hidden">
                    <button onclick="toggleStats()" class="w-full bg-white/5 backdrop-blur-xl border border-white/30 rounded-2xl px-6 py-3 shadow-xl hover:bg-white/10 transition-all duration-300 group">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center ring-2 ring-white/20 group-hover:ring-white/30 transition-all">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                </div>
                                <div class="<?php echo e(app()->getLocale() == 'ar' ? 'text-right' : 'text-left'); ?>">
                                    <h4 class="text-sm font-semibold text-white"><?php echo e(__('frontend.usage_statistics') ?? 'Usage Statistics'); ?></h4>
                                    <p class="text-xs text-blue-200" style="direction: ltr;">
                                        💾 <?php echo e($stats['disk_percent']); ?>% | 📊 <?php echo e($stats['bandwidth_percent']); ?>% | 🌐 <?php echo e($stats['addon_domains_used'] ?? 0); ?>/<?php echo e($stats['addon_domains'] == -1 || $stats['addon_domains'] == 999999 ? '∞' : $stats['addon_domains']); ?> | 📧 <?php echo e($stats['email_accounts_used'] ?? 0); ?>/<?php echo e($stats['email_accounts'] == -1 || $stats['email_accounts'] == 999999 ? '∞' : $stats['email_accounts']); ?>

                                    </p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-white transition-transform duration-300 group-hover:scale-110 group-hover:translate-y-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </button>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <script>
            function toggleStats() {
                const statsSection = document.getElementById('statsSection');
                const statsNotch = document.getElementById('statsNotch');
                const statsContent = document.getElementById('statsContent');
                const toggleIcon = document.getElementById('statsToggleIcon');
                
                if (statsSection.classList.contains('collapsed')) {
                    // Expand
                    statsSection.classList.remove('collapsed');
                    statsNotch.classList.add('hidden');
                    
                    // Show section first
                    statsSection.style.display = 'block';
                    
                    setTimeout(() => {
                        statsSection.style.height = 'auto';
                        statsSection.style.padding = '2rem';
                        statsSection.style.opacity = '1';
                        statsContent.style.display = 'block';
                        
                        // Rotate icon
                        toggleIcon.style.transform = 'rotate(0deg)';
                    }, 10);
                    
                    // Save state
                    localStorage.setItem('statsExpanded', 'true');
                } else {
                    // Collapse
                    statsSection.classList.add('collapsed');
                    
                    // Get current height for animation
                    const currentHeight = statsSection.offsetHeight;
                    statsSection.style.height = currentHeight + 'px';
                    
                    setTimeout(() => {
                        statsContent.style.display = 'none';
                        statsSection.style.height = '0px';
                        statsSection.style.padding = '0';
                        statsSection.style.opacity = '0';
                        
                        // Rotate icon
                        toggleIcon.style.transform = 'rotate(180deg)';
                        
                        // After animation, hide section and show notch
                        setTimeout(() => {
                            statsSection.style.display = 'none';
                            statsNotch.classList.remove('hidden');
                        }, 500);
                    }, 10);
                    
                    // Save state
                    localStorage.setItem('statsExpanded', 'false');
                }
            }
            
            // Restore state on page load
            document.addEventListener('DOMContentLoaded', function() {
                const statsExpanded = localStorage.getItem('statsExpanded');
                if (statsExpanded === 'false') {
                    // Initialize as collapsed
                    const statsSection = document.getElementById('statsSection');
                    const statsNotch = document.getElementById('statsNotch');
                    const statsContent = document.getElementById('statsContent');
                    const toggleIcon = document.getElementById('statsToggleIcon');
                    
                    statsSection.classList.add('collapsed');
                    statsSection.style.display = 'none';
                    statsContent.style.display = 'none';
                    statsNotch.classList.remove('hidden');
                    toggleIcon.style.transform = 'rotate(180deg)';
                }
            });
        </script>

        <div class="grid grid-cols-1 lg:grid-cols-9 gap-6">
            
            <!-- Main Content -->
            <div class="lg:col-span-6 space-y-6">
                
                <!-- Change cPanel Password Section -->
                <?php if($service->status === 'active'): ?>
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-2xl shadow-xl border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
                    <!-- Accordion Header (Clickable) -->
                    <button 
                        onclick="togglePasswordAccordion()" 
                        class="w-full relative bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 px-6 py-5 hover:from-blue-700 hover:via-indigo-700 hover:to-purple-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <div class="absolute inset-0 opacity-10">
                            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;1&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                        </div>
                        <div class="relative flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="h-12 w-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center ring-2 ring-white/30">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                    </svg>
                                </div>
                                <div class="<?php echo e(app()->getLocale() == 'ar' ? 'text-right' : 'text-left'); ?>">
                                    <h2 class="text-xl font-bold text-white">
                                        <?php echo e(__('frontend.change_cpanel_password') ?? 'Change cPanel Password'); ?>

                                    </h2>
                                    <p class="text-sm text-blue-100 mt-0.5"><?php echo e(__('frontend.update_cpanel_password') ?? 'Update your cPanel account password'); ?></p>
                                </div>
                            </div>
                            <!-- Accordion Arrow Icon -->
                            <div class="flex items-center">
                                <svg id="passwordAccordionIcon" class="w-6 h-6 text-white transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                    </button>

                    <!-- Accordion Content (Collapsible) -->
                    <div id="passwordAccordionContent" class="accordion-content space-y-6 overflow-hidden transition-all duration-500 ease-in-out" style="max-height: 0; opacity: 0; transform: translateY(-10px); padding: 0;">
                        <div class="p-6 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
                        <form id="changePasswordForm" class="space-y-4">
                            <?php echo csrf_field(); ?>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- New Password -->
                                <div>
                                    <label for="new_password" class="flex items-center gap-1.5 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                        <?php echo e(__('frontend.new_password') ?? 'New Password'); ?>

                                    </label>
                                    <div class="relative">
                                        <input type="password" id="new_password" name="new_password" required
                                            minlength="8"
                                            class="w-full px-4 py-3 <?php echo e(app()->getLocale() == 'ar' ? 'pl-10 pr-4' : 'pr-10 pl-4'); ?> rounded-lg border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all placeholder-gray-400 dark:placeholder-gray-500"
                                            placeholder="••••••••">
                                        <button type="button" onclick="toggleCpanelPasswordVisibility('new_password')" class="absolute inset-y-0 <?php echo e(app()->getLocale() == 'ar' ? 'left-0 pl-3 rounded-l-lg' : 'right-0 pr-3 rounded-r-lg'); ?> flex items-center hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                            <svg class="w-5 h-5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-600 dark:text-gray-400">
                                        <?php echo e(__('frontend.password_min_length') ?? 'Minimum 8 characters'); ?>

                                    </p>
                                </div>

                                <!-- Confirm Password -->
                                <div>
                                    <label for="confirm_password" class="flex items-center gap-1.5 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <?php echo e(__('frontend.confirm_password') ?? 'Confirm Password'); ?>

                                    </label>
                                    <div class="relative">
                                        <input type="password" id="confirm_password" name="confirm_password" required
                                            minlength="8"
                                            class="w-full px-4 py-3 <?php echo e(app()->getLocale() == 'ar' ? 'pl-10 pr-4' : 'pr-10 pl-4'); ?> rounded-lg border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all placeholder-gray-400 dark:placeholder-gray-500"
                                            placeholder="••••••••">
                                        <button type="button" onclick="toggleCpanelPasswordVisibility('confirm_password')" class="absolute inset-y-0 <?php echo e(app()->getLocale() == 'ar' ? 'left-0 pl-3 rounded-l-lg' : 'right-0 pr-3 rounded-r-lg'); ?> flex items-center hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                            <svg class="w-5 h-5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <p id="password-match-error" style="display: none;" class="mt-1 text-xs text-red-600 dark:text-red-400 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        <?php echo e(__('frontend.passwords_dont_match') ?? 'Passwords do not match'); ?>

                                    </p>
                                </div>
                            </div>

                            <!-- Generate Password Button -->
                            <div class="flex items-center gap-2">
                                <button type="button" onclick="generateCpanelPassword()" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30 text-blue-700 dark:text-blue-300 rounded-lg hover:from-blue-100 hover:to-indigo-100 dark:hover:from-blue-900/50 dark:hover:to-indigo-900/50 font-medium text-sm transition-all border border-blue-200 dark:border-blue-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    <?php echo e(__('frontend.generate_strong_password') ?? 'Generate Strong Password'); ?>

                                </button>
                                
                                <div class="flex-1 flex items-center gap-1.5 text-xs text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                    <?php echo e(__('frontend.password_strength_info') ?? 'Use a strong password with letters, numbers, and symbols'); ?>

                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex items-center gap-3 pt-2">
                                <button type="submit" id="changePasswordBtn" class="flex-1 px-6 py-3.5 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white rounded-lg font-semibold hover:from-blue-700 hover:via-indigo-700 hover:to-purple-700 focus:ring-4 focus:ring-blue-500/50 shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center gap-2 group">
                                    <svg class="w-5 h-5 group-hover:rotate-12 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                    </svg>
                                    <span id="changePasswordBtnText"><?php echo e(__('frontend.change_password') ?? 'Change Password'); ?></span>
                                </button>
                            </div>
                        </form>

                        <!-- Success/Error Messages -->
                        <div id="password-message" class="hidden mt-4"></div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Email Accounts Management (Accordion) -->
                <?php if($service->status === 'active'): ?>
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-2xl shadow-xl border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
                    <!-- Accordion Header (Clickable) -->
                    <button 
                        onclick="toggleEmailAccordion()" 
                        class="w-full relative bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 px-6 py-5 hover:from-green-700 hover:via-emerald-700 hover:to-teal-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        <div class="absolute inset-0 opacity-10">
                            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;1&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                        </div>
                        <div class="relative flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="h-12 w-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center ring-2 ring-white/30">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div class="<?php echo e(app()->getLocale() == 'ar' ? 'text-right' : 'text-left'); ?>">
                                    <h2 class="text-xl font-bold text-white">
                                        <?php echo e(__('frontend.email_accounts') ?? 'Email Accounts'); ?>

                                    </h2>
                                    <p class="text-sm text-green-100 mt-0.5"><?php echo e(__('frontend.manage_emails') ?? 'Manage your email accounts'); ?></p>
                                </div>
                            </div>
                            <!-- Accordion Arrow Icon -->
                            <div class="flex items-center">
                                <svg id="emailAccordionIcon" class="w-6 h-6 text-white transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                    </button>

                    <!-- Accordion Content (Collapsible) -->
                    <div id="emailAccordionContent" class="accordion-content space-y-6 overflow-hidden transition-all duration-500 ease-in-out" style="max-height: 0; opacity: 0; transform: translateY(-10px); padding: 0;">
                        <!-- Create Email Form -->
                        <div class="bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 rounded-xl p-4 sm:p-6 border border-green-200 dark:border-green-800 shadow-sm">
                            <div class="flex items-center justify-between mb-5">
                                <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                    <div class="h-8 w-8 bg-green-600 dark:bg-green-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                    </div>
                                    <?php echo e(__('frontend.create_email_account') ?? 'Create Email Account'); ?>

                                </h3>
                            </div>
                            
                            <form id="createEmailForm" class="space-y-4">
                                <?php echo csrf_field(); ?>
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                                    <!-- Email Username -->
                                    <div class="lg:col-span-2">
                                        <label for="email_username" class="flex items-center gap-1.5 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            <?php echo e(__('frontend.email_username') ?? 'Email Username'); ?>

                                        </label>
                                        <div class="flex flex-col sm:flex-row gap-2">
                                            <div class="flex-1">
                                                <input type="text" id="email_username" name="email_username" required
                                                    pattern="[a-zA-Z0-9._\-]+"
                                                    maxlength="64"
                                                    class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all placeholder-gray-400 dark:placeholder-gray-500"
                                                    placeholder="<?php echo e(__('frontend.enter_username') ?? 'username'); ?>"
                                                    title="<?php echo e(__('frontend.username_validation') ?? 'Only letters, numbers, dots, underscores and hyphens allowed'); ?>">
                                                <p id="username-error" style="display: none;" class="mt-1 text-xs text-red-600 dark:text-red-400 flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                    </svg>
                                                    <span id="username-error-text"></span>
                                                </p>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="text-gray-900 dark:text-white font-semibold text-lg">@</span>
                                                <div class="relative flex-1 sm:flex-none">
                                                    <select id="email_domain" name="email_domain" required
                                                        class="appearance-none w-full sm:min-w-[200px] pl-4 pr-10 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all font-semibold hover:border-green-400 dark:hover:border-green-500 cursor-pointer shadow-sm hover:shadow-md">
                                                        <option value="<?php echo e($service->domain); ?>"><?php echo e($service->domain); ?></option>
                                                    </select>
                                                    <!-- Dropdown Icon -->
                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                                        </svg>
                                                    </div>
                                                    <!-- Loading Indicator -->
                                                    <div id="domain-loading" style="display: none;" class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                        <svg class="animate-spin h-5 w-5 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24">
                                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="mt-2 text-xs text-gray-600 dark:text-gray-400 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                            </svg>
                                            <?php echo e(__('frontend.email_will_be') ?? 'Email will be'); ?>: <span class="font-mono text-green-600 dark:text-green-400 font-semibold <?php echo e(app()->getLocale() == 'ar' ? 'mr-1' : 'ml-1'); ?>" id="email_preview">username<?php echo e('@' . $service->domain); ?></span>
                                        </p>
                                    </div>

                                    <!-- Password -->
                                    <div>
                                        <label for="email_password" class="flex items-center gap-1.5 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                            </svg>
                                            <?php echo e(__('frontend.password') ?? 'Password'); ?>

                                        </label>
                                        <div class="relative">
                                            <input type="password" id="email_password" name="password" required
                                                class="w-full px-4 py-3 <?php echo e(app()->getLocale() == 'ar' ? 'pl-10 pr-4' : 'pr-10 pl-4'); ?> rounded-lg border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all placeholder-gray-400 dark:placeholder-gray-500"
                                                placeholder="••••••••">
                                            <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 <?php echo e(app()->getLocale() == 'ar' ? 'left-0 pl-3 rounded-l-lg' : 'right-0 pr-3 rounded-r-lg'); ?> flex items-center hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                                <svg id="eye-icon" class="w-5 h-5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <button type="button" onclick="generatePassword()" class="mt-2 inline-flex items-center gap-1 text-xs text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 font-medium transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                            </svg>
                                            <?php echo e(__('frontend.generate_strong_password') ?? 'Generate Strong Password'); ?>

                                        </button>
                                    </div>

                                    <!-- Quota -->
                                    <div>
                                        <label for="email_quota" class="flex items-center gap-1.5 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                                            </svg>
                                            <?php echo e(__('frontend.mailbox_quota') ?? 'Mailbox Quota (MB)'); ?>

                                        </label>
                                        <input type="number" id="email_quota" name="quota" value="250" min="10" max="10000"
                                            class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                                        <p class="mt-2 text-xs text-gray-600 dark:text-gray-400 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                            </svg>
                                            <?php echo e(__('frontend.quota_hint') ?? 'Set to 0 for unlimited'); ?>

                                        </p>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="pt-2">
                                    <button type="submit" id="createEmailBtn"
                                        class="w-full px-6 py-3.5 bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 text-white rounded-lg font-semibold hover:from-green-700 hover:via-emerald-700 hover:to-teal-700 focus:ring-4 focus:ring-green-500/50 shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center gap-2 group">
                                        <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        <span id="createEmailBtnText"><?php echo e(__('frontend.create_email') ?? 'Create Email Account'); ?></span>
                                    </button>
                                </div>
                            </form>

                            <!-- Success/Error Messages -->
                            <div id="email-message" class="hidden mt-4"></div>
                        </div>

                        <!-- Email Accounts List -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 sm:p-6 border border-gray-200 dark:border-gray-700 shadow-sm">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
                                <div>
                                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                        <div class="h-8 w-8 bg-gradient-to-br from-green-100 to-emerald-100 dark:from-green-900 dark:to-emerald-900 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                            </svg>
                                        </div>
                                        <?php echo e(__('frontend.existing_emails') ?? 'Existing Email Accounts'); ?>

                                    </h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 ml-10"><?php echo e(__('frontend.manage_existing_emails') ?? 'View and manage your existing email accounts'); ?></p>
                                </div>
                                <button onclick="refreshEmailList()" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30 text-green-700 dark:text-green-300 rounded-lg hover:from-green-100 hover:to-emerald-100 dark:hover:from-green-900/50 dark:hover:to-emerald-900/50 font-medium text-sm transition-all border border-green-200 dark:border-green-800 group">
                                    <svg class="w-4 h-4 mr-2 group-hover:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    <?php echo e(__('frontend.refresh') ?? 'Refresh'); ?>

                                </button>
                            </div>
                            
                            <div id="email-accounts-list" class="space-y-3">
                                <div class="flex flex-col items-center justify-center py-12">
                                    <div class="relative">
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <div class="w-16 h-16 bg-gradient-to-r from-green-400 to-emerald-400 rounded-full opacity-20 animate-ping"></div>
                                        </div>
                                        <svg class="animate-spin h-12 w-12 text-green-600 dark:text-green-400 relative z-10" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-4"><?php echo e(__('frontend.loading_emails') ?? 'Loading email accounts...'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- FTP Accounts Management (Accordion) -->
                <?php if($service->status === 'active'): ?>
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-2xl shadow-xl border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
                    <!-- Accordion Header (Clickable) -->
                    <button 
                        onclick="toggleFtpAccordion()" 
                        class="w-full relative bg-gradient-to-r from-orange-600 via-amber-600 to-yellow-600 px-6 py-5 hover:from-orange-700 hover:via-amber-700 hover:to-yellow-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                        <div class="absolute inset-0 opacity-10">
                            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;1&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                        </div>
                        <div class="relative flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="h-12 w-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center ring-2 ring-white/30">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                </div>
                                <div class="<?php echo e(app()->getLocale() == 'ar' ? 'text-right' : 'text-left'); ?>">
                                    <h2 class="text-xl font-bold text-white">
                                        <?php echo e(__('frontend.ftp_accounts') ?? 'FTP Accounts'); ?>

                                    </h2>
                                    <p class="text-sm text-orange-100 mt-0.5"><?php echo e(__('frontend.manage_ftp_accounts') ?? 'Manage your FTP accounts'); ?></p>
                                </div>
                            </div>
                            <!-- Accordion Arrow Icon -->
                            <div class="flex items-center">
                                <svg id="ftpAccordionIcon" class="w-6 h-6 text-white transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                    </button>

                    <!-- Accordion Content (Collapsible) -->
                    <div id="ftpAccordionContent" class="accordion-content space-y-6 overflow-hidden transition-all duration-500 ease-in-out" style="max-height: 0; opacity: 0; transform: translateY(-10px); padding: 0;">
                        <!-- Create FTP Account Form -->
                        <div class="bg-gradient-to-br from-orange-50 via-amber-50 to-yellow-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 rounded-xl p-4 sm:p-6 border border-orange-200 dark:border-orange-800 shadow-sm">
                            <div class="flex items-center justify-between mb-5">
                                <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                    <div class="h-8 w-8 bg-orange-600 dark:bg-orange-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                    </div>
                                    <?php echo e(__('frontend.create_ftp_account') ?? 'Create FTP Account'); ?>

                                </h3>
                            </div>
                            
                            <form id="createFtpForm" class="space-y-4">
                                <?php echo csrf_field(); ?>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Username -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            FTP Username
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 <?php echo e(app()->getLocale() == 'ar' ? 'right-0 pr-3' : 'left-0 pl-3'); ?> flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                            </div>
                                            <input 
                                                type="text" 
                                                id="ftp_username" 
                                                name="username"
                                                class="<?php echo e(app()->getLocale() == 'ar' ? 'pr-10 pl-4' : 'pl-10 pr-4'); ?> w-full px-4 py-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent dark:text-white transition-all" 
                                                placeholder="ftpuser"
                                                pattern="[a-zA-Z0-9_-]+"
                                                title="Username can only contain letters, numbers, underscore and dash (no @ symbol)"
                                                required>
                                        </div>
                                        <div class="mt-2 flex items-start gap-2">
                                            <svg class="w-4 h-4 text-orange-600 dark:text-orange-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                            </svg>
                                            <div class="text-xs text-gray-600 dark:text-gray-400">
                                                <p class="font-semibold text-orange-600 dark:text-orange-400">Enter username only (without @ or domain)</p>
                                                <p class="mt-0.5">Example: <code class="font-mono bg-gray-200 dark:bg-gray-700 px-1 rounded">ftpuser</code> will become <code class="font-mono bg-orange-100 dark:bg-orange-900/30 px-1 rounded text-orange-700 dark:text-orange-300">ftpuser@</code><code class="font-mono bg-orange-100 dark:bg-orange-900/30 px-1 rounded text-orange-700 dark:text-orange-300"><?php echo e($service->username); ?></code></p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Password -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            Password
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 <?php echo e(app()->getLocale() == 'ar' ? 'right-0 pr-3' : 'left-0 pl-3'); ?> flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                                </svg>
                                            </div>
                                            <input 
                                                type="password" 
                                                id="ftp_password" 
                                                name="password"
                                                class="<?php echo e(app()->getLocale() == 'ar' ? 'pr-10 pl-10' : 'pl-10 pr-10'); ?> w-full px-4 py-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent dark:text-white transition-all" 
                                                placeholder="••••••••"
                                                required>
                                            <button 
                                                type="button"
                                                onclick="toggleFtpPasswordVisibility('ftp_password')"
                                                class="absolute inset-y-0 <?php echo e(app()->getLocale() == 'ar' ? 'left-0 pl-3' : 'right-0 pr-3'); ?> flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <button type="button" onclick="generateFtpPassword()" class="mt-2 inline-flex items-center gap-1 text-xs text-orange-600 dark:text-orange-400 hover:text-orange-700 dark:hover:text-orange-300 font-medium transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                            </svg>
                                            Generate Strong Password (Strength > 65)
                                        </button>
                                    </div>

                                    <!-- Directory -->
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            Directory (Optional)
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 <?php echo e(app()->getLocale() == 'ar' ? 'right-0 pr-3' : 'left-0 pl-3'); ?> flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                                </svg>
                                            </div>
                                            <input 
                                                type="text" 
                                                id="ftp_directory" 
                                                name="directory"
                                                class="<?php echo e(app()->getLocale() == 'ar' ? 'pr-10 pl-4' : 'pl-10 pr-4'); ?> w-full px-4 py-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent dark:text-white transition-all" 
                                                placeholder="/public_html">
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Leave empty for home directory, or specify path like /public_html</p>
                                    </div>

                                    <!-- Quota -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            Quota (MB)
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 <?php echo e(app()->getLocale() == 'ar' ? 'right-0 pr-3' : 'left-0 pl-3'); ?> flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                                                </svg>
                                            </div>
                                            <input 
                                                type="number" 
                                                id="ftp_quota" 
                                                name="quota"
                                                class="<?php echo e(app()->getLocale() == 'ar' ? 'pr-10 pl-4' : 'pl-10 pr-4'); ?> w-full px-4 py-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent dark:text-white transition-all" 
                                                placeholder="Unlimited"
                                                min="0">
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Leave empty for unlimited</p>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="flex items-center gap-3 pt-2">
                                    <button type="submit" id="createFtpBtn" class="flex-1 px-6 py-3.5 bg-gradient-to-r from-orange-600 via-amber-600 to-yellow-600 text-white rounded-lg font-semibold hover:from-orange-700 hover:via-amber-700 hover:to-yellow-700 focus:ring-4 focus:ring-orange-500/50 shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center gap-2 group">
                                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        <span id="createFtpBtnText"><?php echo e(__('frontend.create_ftp_account') ?? 'Create FTP Account'); ?></span>
                                    </button>
                                </div>
                            </form>

                            <!-- Success/Error Messages -->
                            <div id="ftp-create-message" class="hidden mt-4"></div>
                        </div>

                        <!-- FTP Accounts List -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 sm:p-6 border border-gray-200 dark:border-gray-700">
                            <div class="flex items-start gap-3 mb-4">
                                <div class="h-9 w-9 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">
                                        <?php echo e(__('frontend.existing_ftp_accounts') ?? 'Existing FTP Accounts'); ?>

                                    </h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1"><?php echo e(__('frontend.view_manage_ftp') ?? 'View and manage your existing FTP accounts'); ?></p>
                                </div>
                            </div>

                            <!-- Loading State -->
                            <div id="ftp-loading" class="text-center py-8">
                                <div class="flex justify-center mb-4">
                                    <svg class="animate-spin h-10 w-10 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-4"><?php echo e(__('frontend.loading_ftp_accounts') ?? 'Loading FTP accounts...'); ?></p>
                            </div>

                            <!-- FTP Accounts List Container -->
                            <div id="ftp-list" class="hidden space-y-3"></div>

                            <!-- Empty State -->
                            <div id="ftp-empty" class="hidden text-center py-8">
                                <div class="flex justify-center mb-4">
                                    <div class="h-16 w-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-base font-medium text-gray-700 dark:text-gray-300 mb-1"><?php echo e(__('frontend.no_ftp_accounts') ?? 'No FTP accounts yet'); ?></p>
                                <p class="text-sm text-gray-500 dark:text-gray-400"><?php echo e(__('frontend.create_first_ftp') ?? 'Create your first FTP account above'); ?></p>
                            </div>

                            <!-- Error State -->
                            <div id="ftp-error" class="hidden text-center py-8">
                                <p class="text-red-500 dark:text-red-400"><?php echo e(__('frontend.failed_load_ftp') ?? 'Failed to load FTP accounts'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Database Wizard (Accordion) -->
                <?php if($service->status === 'active'): ?>
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-2xl shadow-xl border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
                    <!-- Accordion Header (Clickable) -->
                    <button 
                        onclick="toggleDatabaseWizardAccordion()" 
                        class="w-full relative bg-gradient-to-r from-blue-500 via-cyan-500 to-teal-500 px-6 py-5 hover:from-blue-600 hover:via-cyan-600 hover:to-teal-600 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <div class="absolute inset-0 opacity-10">
                            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;1&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                        </div>
                        <div class="relative flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="h-12 w-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center ring-2 ring-white/30">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                                    </svg>
                                </div>
                                <div class="<?php echo e(app()->getLocale() == 'ar' ? 'text-right' : 'text-left'); ?>">
                                    <h2 class="text-xl font-bold text-white">
                                        <?php echo e(__('frontend.database_wizard') ?? 'Database Wizard'); ?>

                                    </h2>
                                    <p class="text-sm text-blue-100 mt-0.5"><?php echo e(__('frontend.database_wizard_desc') ?? 'Create database, user, and assign privileges easily'); ?></p>
                                </div>
                            </div>
                            <!-- Accordion Arrow Icon -->
                            <div class="flex items-center">
                                <svg id="databaseWizardAccordionIcon" class="w-6 h-6 text-white transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                    </button>

                    <!-- Accordion Content (Collapsible) -->
                    <div id="databaseWizardAccordionContent" class="accordion-content space-y-6 overflow-hidden transition-all duration-500 ease-in-out" style="max-height: 0; opacity: 0; transform: translateY(-10px); padding: 0;">
                        <!-- Database Wizard Steps -->
                        <div class="bg-gradient-to-br from-blue-50 via-cyan-50 to-teal-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 rounded-xl p-4 sm:p-6 border border-blue-200 dark:border-blue-800 shadow-sm">
                            
                            <!-- Step Indicator -->
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center space-x-2">
                                    <div id="step-indicator-1" class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-600 text-white font-bold text-sm">1</div>
                                    <div class="h-1 w-12 bg-gray-300 dark:bg-gray-600" id="line-1"></div>
                                    <div id="step-indicator-2" class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-300 dark:bg-gray-600 text-gray-600 dark:text-gray-400 font-bold text-sm">2</div>
                                    <div class="h-1 w-12 bg-gray-300 dark:bg-gray-600" id="line-2"></div>
                                    <div id="step-indicator-3" class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-300 dark:bg-gray-600 text-gray-600 dark:text-gray-400 font-bold text-sm">3</div>
                                </div>
                                <button type="button" onclick="resetDatabaseWizard()" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium">
                                    <?php echo e(__('frontend.reset_wizard') ?? 'Reset Wizard'); ?>

                                </button>
                            </div>

                            <form id="databaseWizardForm" class="space-y-6">
                                <?php echo csrf_field(); ?>
                                
                                <!-- Step 1: Create Database -->
                                <div id="wizard-step-1" class="wizard-step">
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                            <div class="h-8 w-8 bg-blue-600 dark:bg-blue-500 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                </svg>
                                            </div>
                                            <?php echo e(__('frontend.step_1_create_database') ?? 'Step 1: Create Database'); ?>

                                        </h3>
                                    </div>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                                <?php echo e(__('frontend.database_name') ?? 'Database Name'); ?>

                                            </label>
                                            <div class="flex items-center gap-2">
                                                <span class="text-sm text-gray-600 dark:text-gray-400 font-mono"><?php echo e($service->username); ?>_</span>
                                                <input 
                                                    type="text" 
                                                    id="wizard_db_name" 
                                                    name="db_name"
                                                    class="flex-1 px-4 py-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:text-white transition-all" 
                                                    placeholder="myapp"
                                                    required>
                                            </div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1"><?php echo e(__('frontend.database_name_hint', ['username' => $service->username]) ?? 'Enter database name (will be prefixed with ' . $service->username . '_)'); ?></p>
                                        </div>
                                        
                                        <button type="button" onclick="createDatabaseStep()" class="w-full px-6 py-3 bg-gradient-to-r from-blue-500 via-cyan-500 to-teal-500 text-white rounded-lg font-semibold hover:from-blue-600 hover:via-cyan-600 hover:to-teal-600 focus:ring-4 focus:ring-blue-500/50 shadow-lg hover:shadow-xl transition-all duration-200">
                                            <?php echo e(__('frontend.create_database_continue') ?? 'Create Database & Continue'); ?>

                                        </button>
                                    </div>
                                </div>

                                <!-- Step 2: Create User -->
                                <div id="wizard-step-2" class="wizard-step hidden">
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                            <div class="h-8 w-8 bg-blue-600 dark:bg-blue-500 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                            </div>
                                            <?php echo e(__('frontend.step_2_create_user') ?? 'Step 2: Create User'); ?>

                                        </h3>
                                    </div>
                                    
                                    <div class="mb-4 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                                        <p class="text-sm text-green-700 dark:text-green-300">
                                            ✓ <?php echo e(__('frontend.database_created') ?? 'Database created'); ?>: <span id="created-db-name" class="font-mono font-bold"></span>
                                        </p>
                                    </div>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                                <?php echo e(__('frontend.database_user') ?? 'Database User'); ?>

                                            </label>
                                            <div class="flex items-center gap-2">
                                                <span class="text-sm text-gray-600 dark:text-gray-400 font-mono"><?php echo e($service->username); ?>_</span>
                                                <input 
                                                    type="text" 
                                                    id="wizard_db_user" 
                                                    name="db_user"
                                                    class="flex-1 px-4 py-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:text-white transition-all" 
                                                    placeholder="myapp_user"
                                                    required>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                                Password
                                            </label>
                                            <div class="relative">
                                                <input 
                                                    type="password" 
                                                    id="wizard_db_password" 
                                                    name="db_password"
                                                    class="w-full px-4 py-3 <?php echo e(app()->getLocale() == 'ar' ? 'pl-10 pr-4' : 'pr-10 pl-4'); ?> bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:text-white transition-all" 
                                                    placeholder="••••••••"
                                                    required>
                                                <button 
                                                    type="button"
                                                    onclick="togglePasswordVisibilityWizard('wizard_db_password')"
                                                    class="absolute inset-y-0 <?php echo e(app()->getLocale() == 'ar' ? 'left-0 pl-3' : 'right-0 pr-3'); ?> flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                </button>
                                            </div>
                                            <button type="button" onclick="generateDatabasePassword()" class="mt-2 inline-flex items-center gap-1 text-xs text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                </svg>
                                                <?php echo e(__('frontend.generate_strong_password') ?? 'Generate Strong Password'); ?>

                                            </button>
                                        </div>
                                        
                                        <div class="flex gap-3">
                                            <button type="button" onclick="goToWizardStep(1)" class="flex-1 px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-200">
                                                <?php echo e(__('frontend.back') ?? 'Back'); ?>

                                            </button>
                                            <button type="button" onclick="createUserStep()" class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-500 via-cyan-500 to-teal-500 text-white rounded-lg font-semibold hover:from-blue-600 hover:via-cyan-600 hover:to-teal-600 focus:ring-4 focus:ring-blue-500/50 shadow-lg hover:shadow-xl transition-all duration-200">
                                                <?php echo e(__('frontend.create_user_continue') ?? 'Create User & Continue'); ?>

                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 3: Assign Privileges -->
                                <div id="wizard-step-3" class="wizard-step hidden">
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                            <div class="h-8 w-8 bg-blue-600 dark:bg-blue-500 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                                </svg>
                                            </div>
                                            <?php echo e(__('frontend.step_3_assign_privileges') ?? 'Step 3: Assign Privileges'); ?>

                                        </h3>
                                    </div>
                                    
                                    <div class="mb-4 space-y-2">
                                        <div class="p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                                            <p class="text-sm text-green-700 dark:text-green-300">
                                                ✓ <?php echo e(__('frontend.database') ?? 'Database'); ?>: <span id="final-db-name" class="font-mono font-bold"></span>
                                            </p>
                                        </div>
                                        <div class="p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                                            <p class="text-sm text-green-700 dark:text-green-300">
                                                ✓ <?php echo e(__('frontend.user') ?? 'User'); ?>: <span id="final-db-user" class="font-mono font-bold"></span>
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                                <?php echo e(__('frontend.select_privileges') ?? 'Select Privileges'); ?>

                                            </label>
                                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                                <label class="flex items-center gap-3 p-3 bg-blue-50 dark:bg-blue-900/20 border-2 border-blue-600 dark:border-blue-500 rounded-lg cursor-pointer hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-all">
                                                    <input type="checkbox" id="priv-all" checked class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500" onchange="toggleAllPrivileges(this)">
                                                    <span class="text-sm font-bold text-blue-700 dark:text-blue-300">ALL PRIVILEGES</span>
                                                </label>
                                                
                                                <!-- Data Manipulation -->
                                                <label class="flex items-center gap-3 p-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                                                    <input type="checkbox" class="privilege-item w-4 h-4 text-blue-600 rounded focus:ring-blue-500" value="SELECT">
                                                    <span class="text-sm text-gray-900 dark:text-white">SELECT</span>
                                                </label>
                                                <label class="flex items-center gap-3 p-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                                                    <input type="checkbox" class="privilege-item w-4 h-4 text-blue-600 rounded focus:ring-blue-500" value="INSERT">
                                                    <span class="text-sm text-gray-900 dark:text-white">INSERT</span>
                                                </label>
                                                <label class="flex items-center gap-3 p-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                                                    <input type="checkbox" class="privilege-item w-4 h-4 text-blue-600 rounded focus:ring-blue-500" value="UPDATE">
                                                    <span class="text-sm text-gray-900 dark:text-white">UPDATE</span>
                                                </label>
                                                <label class="flex items-center gap-3 p-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                                                    <input type="checkbox" class="privilege-item w-4 h-4 text-blue-600 rounded focus:ring-blue-500" value="DELETE">
                                                    <span class="text-sm text-gray-900 dark:text-white">DELETE</span>
                                                </label>
                                                
                                                <!-- Structure -->
                                                <label class="flex items-center gap-3 p-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                                                    <input type="checkbox" class="privilege-item w-4 h-4 text-blue-600 rounded focus:ring-blue-500" value="CREATE">
                                                    <span class="text-sm text-gray-900 dark:text-white">CREATE</span>
                                                </label>
                                                <label class="flex items-center gap-3 p-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                                                    <input type="checkbox" class="privilege-item w-4 h-4 text-blue-600 rounded focus:ring-blue-500" value="DROP">
                                                    <span class="text-sm text-gray-900 dark:text-white">DROP</span>
                                                </label>
                                                <label class="flex items-center gap-3 p-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                                                    <input type="checkbox" class="privilege-item w-4 h-4 text-blue-600 rounded focus:ring-blue-500" value="INDEX">
                                                    <span class="text-sm text-gray-900 dark:text-white">INDEX</span>
                                                </label>
                                                <label class="flex items-center gap-3 p-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                                                    <input type="checkbox" class="privilege-item w-4 h-4 text-blue-600 rounded focus:ring-blue-500" value="ALTER">
                                                    <span class="text-sm text-gray-900 dark:text-white">ALTER</span>
                                                </label>
                                                
                                                <!-- Advanced -->
                                                <label class="flex items-center gap-3 p-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                                                    <input type="checkbox" class="privilege-item w-4 h-4 text-blue-600 rounded focus:ring-blue-500" value="CREATE TEMPORARY TABLES">
                                                    <span class="text-sm text-gray-900 dark:text-white">CREATE TEMPORARY TABLES</span>
                                                </label>
                                                <label class="flex items-center gap-3 p-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                                                    <input type="checkbox" class="privilege-item w-4 h-4 text-blue-600 rounded focus:ring-blue-500" value="LOCK TABLES">
                                                    <span class="text-sm text-gray-900 dark:text-white">LOCK TABLES</span>
                                                </label>
                                                <label class="flex items-center gap-3 p-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                                                    <input type="checkbox" class="privilege-item w-4 h-4 text-blue-600 rounded focus:ring-blue-500" value="EXECUTE">
                                                    <span class="text-sm text-gray-900 dark:text-white">EXECUTE</span>
                                                </label>
                                                <label class="flex items-center gap-3 p-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                                                    <input type="checkbox" class="privilege-item w-4 h-4 text-blue-600 rounded focus:ring-blue-500" value="CREATE VIEW">
                                                    <span class="text-sm text-gray-900 dark:text-white">CREATE VIEW</span>
                                                </label>
                                                <label class="flex items-center gap-3 p-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                                                    <input type="checkbox" class="privilege-item w-4 h-4 text-blue-600 rounded focus:ring-blue-500" value="SHOW VIEW">
                                                    <span class="text-sm text-gray-900 dark:text-white">SHOW VIEW</span>
                                                </label>
                                                <label class="flex items-center gap-3 p-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                                                    <input type="checkbox" class="privilege-item w-4 h-4 text-blue-600 rounded focus:ring-blue-500" value="CREATE ROUTINE">
                                                    <span class="text-sm text-gray-900 dark:text-white">CREATE ROUTINE</span>
                                                </label>
                                                <label class="flex items-center gap-3 p-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                                                    <input type="checkbox" class="privilege-item w-4 h-4 text-blue-600 rounded focus:ring-blue-500" value="ALTER ROUTINE">
                                                    <span class="text-sm text-gray-900 dark:text-white">ALTER ROUTINE</span>
                                                </label>
                                                <label class="flex items-center gap-3 p-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                                                    <input type="checkbox" class="privilege-item w-4 h-4 text-blue-600 rounded focus:ring-blue-500" value="EVENT">
                                                    <span class="text-sm text-gray-900 dark:text-white">EVENT</span>
                                                </label>
                                                <label class="flex items-center gap-3 p-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                                                    <input type="checkbox" class="privilege-item w-4 h-4 text-blue-600 rounded focus:ring-blue-500" value="TRIGGER">
                                                    <span class="text-sm text-gray-900 dark:text-white">TRIGGER</span>
                                                </label>
                                            </div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2"><?php echo e(__('frontend.all_privileges_recommended') ?? 'For most applications, "ALL PRIVILEGES" is recommended'); ?></p>
                                        </div>
                                        
                                        <div class="flex gap-3">
                                            <button type="button" onclick="goToWizardStep(2)" class="flex-1 px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-200">
                                                <?php echo e(__('frontend.back') ?? 'Back'); ?>

                                            </button>
                                            <button type="button" onclick="assignPrivilegesStep()" class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-500 via-cyan-500 to-teal-500 text-white rounded-lg font-semibold hover:from-blue-600 hover:via-cyan-600 hover:to-teal-600 focus:ring-4 focus:ring-blue-500/50 shadow-lg hover:shadow-xl transition-all duration-200">
                                                <?php echo e(__('frontend.assign_privileges_finish') ?? 'Assign Privileges & Finish'); ?>

                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Success Message -->
                                <div id="wizard-success" class="wizard-step hidden">
                                    <div class="text-center py-8">
                                        <div class="flex justify-center mb-4">
                                            <div class="h-16 w-16 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                                                <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2"><?php echo e(__('frontend.database_setup_complete') ?? 'Database Setup Complete!'); ?></h3>
                                        <p class="text-gray-600 dark:text-gray-400 mb-6"><?php echo e(__('frontend.database_configured_success') ?? 'Your database, user, and privileges have been configured successfully.'); ?></p>
                                        
                                        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 mb-6 text-left">
                                            <h4 class="font-semibold text-gray-900 dark:text-white mb-3"><?php echo e(__('frontend.connection_details') ?? 'Connection Details:'); ?></h4>
                                            <div class="space-y-2 text-sm font-mono">
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600 dark:text-gray-400"><?php echo e(__('frontend.database') ?? 'Database'); ?>:</span>
                                                    <span class="text-gray-900 dark:text-white" id="success-db-name"></span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600 dark:text-gray-400"><?php echo e(__('frontend.user') ?? 'User'); ?>:</span>
                                                    <span class="text-gray-900 dark:text-white" id="success-db-user"></span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600 dark:text-gray-400"><?php echo e(__('frontend.host') ?? 'Host'); ?>:</span>
                                                    <span class="text-gray-900 dark:text-white">localhost</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <button type="button" onclick="resetDatabaseWizard()" class="px-6 py-3 bg-gradient-to-r from-blue-500 via-cyan-500 to-teal-500 text-white rounded-lg font-semibold hover:from-blue-600 hover:via-cyan-600 hover:to-teal-600 focus:ring-4 focus:ring-blue-500/50 shadow-lg hover:shadow-xl transition-all duration-200">
                                            <?php echo e(__('frontend.create_another_database') ?? 'Create Another Database'); ?>

                                        </button>
                                    </div>
                                </div>
                            </form>

                            <!-- Messages -->
                            <div id="wizard-message" class="hidden mt-4"></div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Domains Manager (Accordion) -->
                <?php if($service->status === 'active'): ?>
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-2xl shadow-xl border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
                    <!-- Accordion Header (Clickable) -->
                    <button 
                        onclick="toggleDomainsAccordion()" 
                        class="w-full relative bg-gradient-to-r from-slate-600 via-gray-600 to-zinc-600 px-6 py-5 hover:from-slate-700 hover:via-gray-700 hover:to-zinc-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2">
                        <div class="absolute inset-0 opacity-10">
                            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;1&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                        </div>
                        <div class="relative flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="h-12 w-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center ring-2 ring-white/30">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                    </svg>
                                </div>
                                <div class="<?php echo e(app()->getLocale() == 'ar' ? 'text-right' : 'text-left'); ?>">
                                    <h2 class="text-xl font-bold text-white">
                                        <?php echo e(__('frontend.domains_manager') ?? 'Domains Manager'); ?>

                                    </h2>
                                    <p class="text-sm text-purple-100 mt-0.5"><?php echo e(__('frontend.manage_domains_subdomains') ?? 'Manage addon domains and subdomains'); ?></p>
                                </div>
                            </div>
                            <!-- Accordion Arrow Icon -->
                            <div class="flex items-center">
                                <svg id="domains-accordion-icon" class="w-6 h-6 text-white transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                    </button>

                    <!-- Accordion Content (Collapsible) -->
                    <div id="domains-accordion-content" class="accordion-content space-y-6 overflow-hidden transition-all duration-500 ease-in-out" style="max-height: 0; opacity: 0; transform: translateY(-10px); padding: 0;">
                        <div class="p-6 space-y-6">
                                
                                <!-- Add Addon Domain Section -->
                                <div class="bg-gradient-to-br from-slate-50 to-gray-50 dark:from-slate-900/20 dark:to-gray-900/20 rounded-xl p-6 border border-slate-200 dark:border-slate-800">
                                    <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        <?php echo e(__('frontend.add_addon_domain') ?? 'Add Addon Domain'); ?>

                                    </h4>
                                    
                                    <form id="addAddonDomainForm" class="space-y-4">
                                        <?php echo csrf_field(); ?>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label for="addon_domain" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                    <?php echo e(__('frontend.domain_name') ?? 'Domain Name'); ?>

                                                </label>
                                                <input type="text" id="addon_domain" name="domain" placeholder="example.com" required
                                                    class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent text-gray-900 dark:text-white">
                                            </div>
                                            
                                            <div>
                                                <label for="addon_subdomain" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                    <?php echo e(__('frontend.subdomain_prefix') ?? 'Subdomain Prefix'); ?>

                                                </label>
                                                <input type="text" id="addon_subdomain" name="subdomain" placeholder="<?php echo e(__('frontend.subdomain_prefix_placeholder') ?? 'example'); ?>" required
                                                    class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent text-gray-900 dark:text-white">
                                            </div>
                                        </div>

                                        <div>
                                            <label for="addon_directory" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                <?php echo e(__('frontend.document_root') ?? 'Document Root'); ?>

                                            </label>
                                            <div class="flex items-center gap-2">
                                                <span class="text-gray-500 dark:text-gray-400">/public_html/</span>
                                                <input type="text" id="addon_directory" name="directory" placeholder="<?php echo e(__('frontend.domain_name_placeholder') ?? 'example.com'); ?>" required
                                                    class="flex-1 px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent text-gray-900 dark:text-white">
                                            </div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1"><?php echo e(__('frontend.document_root_hint') ?? 'Directory where domain files will be stored'); ?></p>
                                        </div>

                                        <div id="addon-domain-message" class="hidden"></div>

                                        <button type="submit" id="addAddonDomainBtn" class="w-full px-6 py-3 bg-gradient-to-r from-slate-600 via-gray-600 to-zinc-600 text-white rounded-lg font-semibold hover:from-slate-700 hover:via-gray-700 hover:to-zinc-700 focus:ring-4 focus:ring-slate-500/50 shadow-lg hover:shadow-xl transition-all duration-200">
                                            <span id="addAddonDomainBtnText"><?php echo e(__('frontend.add_domain') ?? 'Add Domain'); ?></span>
                                        </button>
                                    </form>
                                </div>

                                <!-- Addon Domains List -->
                                <div class="pt-6">
                                    <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                        </svg>
                                        <?php echo e(__('frontend.addon_domains') ?? 'Addon Domains'); ?>

                                    </h4>
                                    <div id="addon-domains-list" class="space-y-3">
                                        <div class="flex items-center justify-center py-8">
                                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-slate-600"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Add Subdomain Section -->
                                <div class="mt-6 bg-gradient-to-br from-slate-50 to-gray-50 dark:from-slate-900/20 dark:to-gray-900/20 rounded-xl p-6 border border-slate-200 dark:border-slate-800">
                                    <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        <?php echo e(__('frontend.add_subdomain') ?? 'Add Subdomain'); ?>

                                    </h4>
                                    
                                    <form id="addSubdomainForm" class="space-y-4">
                                        <?php echo csrf_field(); ?>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label for="subdomain_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                    <?php echo e(__('frontend.subdomain_name') ?? 'Subdomain Name'); ?>

                                                </label>
                                                <input type="text" id="subdomain_name" name="subdomain" placeholder="<?php echo e(__('frontend.subdomain_name_placeholder') ?? 'blog'); ?>" required
                                                    class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent text-gray-900 dark:text-white">
                                            </div>
                                            
                                            <div>
                                                <label for="subdomain_domain" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                    <?php echo e(__('frontend.domain_selector') ?? 'Domain'); ?>

                                                </label>
                                                <select id="subdomain_domain" name="domain" required
                                                    class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent text-gray-900 dark:text-white">
                                                    <option value="<?php echo e($service->domain); ?>"><?php echo e($service->domain); ?></option>
                                                </select>
                                            </div>
                                        </div>

                                        <div>
                                            <label for="subdomain_directory" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                <?php echo e(__('frontend.document_root') ?? 'Document Root'); ?>

                                            </label>
                                            <div class="flex items-center gap-2">
                                                <span class="text-gray-500 dark:text-gray-400">/public_html/</span>
                                                <input type="text" id="subdomain_directory" name="directory" placeholder="<?php echo e(__('frontend.subdomain_name_placeholder') ?? 'blog'); ?>" required
                                                    class="flex-1 px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent text-gray-900 dark:text-white">
                                            </div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1"><?php echo e(__('frontend.document_root_hint') ?? 'Directory where domain files will be stored'); ?></p>
                                        </div>

                                        <div id="subdomain-message" class="hidden"></div>

                                        <button type="submit" id="addSubdomainBtn" class="w-full px-6 py-3 bg-gradient-to-r from-slate-600 via-gray-600 to-zinc-600 text-white rounded-lg font-semibold hover:from-slate-700 hover:via-gray-700 hover:to-zinc-700 focus:ring-4 focus:ring-slate-500/50 shadow-lg hover:shadow-xl transition-all duration-200">
                                            <span id="addSubdomainBtnText"><?php echo e(__('frontend.add_subdomain_btn') ?? 'Add Subdomain'); ?></span>
                                        </button>
                                    </form>
                                </div>

                                <!-- Subdomains List -->
                                <div class="pt-6">
                                    <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                        </svg>
                                        <?php echo e(__('frontend.subdomains') ?? 'Subdomains'); ?>

                                    </h4>
                                    <div id="subdomains-list" class="space-y-3">
                                        <div class="flex items-center justify-center py-8">
                                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-slate-600"></div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Zone Editor (DNS Management) - Accordion -->
                <?php if($service->status === 'active'): ?>
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-2xl shadow-xl border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
                    <!-- Accordion Header (Clickable) -->
                    <button 
                        onclick="toggleZoneEditorAccordion()" 
                        class="w-full relative bg-gradient-to-r from-purple-600 via-purple-500 to-indigo-600 px-6 py-5 hover:from-purple-700 hover:via-purple-600 hover:to-indigo-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                        <div class="absolute inset-0 opacity-10">
                            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;1&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                        </div>
                        <div class="relative flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="h-12 w-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center ring-2 ring-white/30">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                                    </svg>
                                </div>
                                <div class="<?php echo e(app()->getLocale() == 'ar' ? 'text-right' : 'text-left'); ?>">
                                    <h2 class="text-xl font-bold text-white">
                                        <?php echo e(__('frontend.zone_editor')); ?>

                                    </h2>
                                    <p class="text-sm text-purple-100 mt-0.5">
                                        <?php echo e(__('frontend.manage_dns_records')); ?>

                                    </p>
                                </div>
                            </div>
                            <svg id="zone-editor-icon" class="w-6 h-6 text-white transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </button>

                    <!-- Accordion Content -->
                    <div id="zone-editor-content" class="accordion-content space-y-6 overflow-hidden transition-all duration-500 ease-in-out" style="max-height: 0; opacity: 0; transform: translateY(-10px); padding: 0;">
                        <div class="p-6 space-y-6">
                            <!-- Zone Selection -->
                            <div class="bg-gradient-to-br from-purple-50 to-indigo-50 dark:from-purple-900/20 dark:to-indigo-900/20 rounded-xl p-6 border border-purple-200 dark:border-purple-800">
                                <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <?php echo e(__('frontend.select_zone') ?? 'Select Zone'); ?>

                                </h4>
                                <select id="dns-zone-select" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white dark:bg-gray-800 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    <option value=""><?php echo e(__('frontend.loading_zones')); ?></option>
                                </select>
                            </div>

                            <!-- Add DNS Record Form -->
                            <div class="bg-gradient-to-br from-purple-50 to-indigo-50 dark:from-purple-900/20 dark:to-indigo-900/20 rounded-xl p-6 border border-purple-200 dark:border-purple-800">
                                <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    <?php echo e(__('frontend.add_dns_record')); ?>

                                    </h4>
                                    <form id="addDNSRecordForm" class="space-y-4">
                                        <div>
                                            <label for="dns_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                <?php echo e(__('frontend.record_name')); ?>

                                            </label>
                                            <input type="text" id="dns_name" name="name" placeholder="<?php echo e(__('frontend.record_name_placeholder')); ?>" required
                                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white dark:bg-gray-800 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                        </div>
                                        <div>
                                            <label for="dns_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                <?php echo e(__('frontend.record_type')); ?>

                                            </label>
                                            <select id="dns_type" name="type" required
                                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white dark:bg-gray-800 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                                <option value=""><?php echo e(__('frontend.select_record_type')); ?></option>
                                                <option value="A">A</option>
                                                <option value="AAAA">AAAA</option>
                                                <option value="CNAME">CNAME</option>
                                                <option value="MX">MX</option>
                                                <option value="TXT">TXT</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="dns_record" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                <?php echo e(__('frontend.record_value')); ?>

                                            </label>
                                            <input type="text" id="dns_record" name="record" placeholder="<?php echo e(__('frontend.record_value_placeholder')); ?>" required
                                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white dark:bg-gray-800 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                        </div>
                                        <div id="dns_priority_field" class="hidden">
                                            <label for="dns_priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                <?php echo e(__('frontend.mx_priority')); ?>

                                            </label>
                                            <input type="number" id="dns_priority" name="priority" value="10" placeholder="<?php echo e(__('frontend.mx_priority_placeholder')); ?>"
                                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white dark:bg-gray-800 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                        </div>
                                        <div>
                                            <label for="dns_ttl" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                <?php echo e(__('frontend.ttl')); ?>

                                            </label>
                                            <input type="number" id="dns_ttl" name="ttl" value="14400" placeholder="<?php echo e(__('frontend.ttl_placeholder')); ?>"
                                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white dark:bg-gray-800 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                        </div>
                                        <div id="dns-record-message" class="hidden"></div>
                                        <button type="submit" id="addDNSRecordBtn" class="w-full px-6 py-3 bg-gradient-to-r from-purple-600 via-purple-500 to-indigo-600 text-white rounded-lg font-semibold hover:from-purple-700 hover:via-purple-600 hover:to-indigo-700 focus:ring-4 focus:ring-purple-500/50 shadow-lg hover:shadow-xl transition-all duration-200">
                                            <span id="addDNSRecordBtnText"><?php echo e(__('frontend.add_record')); ?></span>
                                        </button>
                                    </form>
                                </div>

                            <!-- DNS Records List -->
                            <div class="bg-gradient-to-br from-purple-50 to-indigo-50 dark:from-purple-900/20 dark:to-indigo-900/20 rounded-xl p-6 border border-purple-200 dark:border-purple-800">
                                <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                        </svg>
                                        <?php echo e(__('frontend.dns_records') ?? 'DNS Records'); ?>

                                    </h4>
                                    <div id="dns-records-list" class="space-y-2 max-h-[600px] overflow-y-auto">
                                        <div class="text-center py-8">
                                            <svg class="w-12 h-12 text-gray-400 dark:text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <p class="text-gray-500 dark:text-gray-400 text-sm"><?php echo e(__('frontend.select_zone_to_view_records')); ?></p>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Quick Tools Grid -->
                <?php if($service->status === 'active'): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <!-- File Manager -->
                    <a href="<?php echo e(route('client.hosting.file.manager', $service->id)); ?>" target="_blank" class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-xl p-6 border border-gray-200/50 dark:border-gray-700/50 hover:shadow-lg transition-all duration-200 cursor-pointer group block">
                        <div class="flex items-center justify-between mb-4">
                            <div class="h-12 w-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-1"><?php echo e(__('frontend.file_manager') ?? 'File Manager'); ?></h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400"><?php echo e(__('frontend.manage_files') ?? 'Manage your files'); ?></p>
                    </a>
                    
                    <!-- Databases -->
                    <a href="<?php echo e(route('client.hosting.databases', $service->id)); ?>" target="_blank" class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-xl p-6 border border-gray-200/50 dark:border-gray-700/50 hover:shadow-lg transition-all duration-200 cursor-pointer group block">
                        <div class="flex items-center justify-between mb-4">
                            <div class="h-12 w-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-1"><?php echo e(__('frontend.databases') ?? 'Databases'); ?></h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400"><?php echo e(__('frontend.manage_databases') ?? 'Manage databases'); ?></p>
                    </a>
                    
                    <!-- Email Accounts -->
                    <a href="<?php echo e(route('client.hosting.webmail', $service->id)); ?>" target="_blank" class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-xl p-6 border border-gray-200/50 dark:border-gray-700/50 hover:shadow-lg transition-all duration-200 cursor-pointer group block">
                        <div class="flex items-center justify-between mb-4">
                            <div class="h-12 w-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-1"><?php echo e(__('frontend.email_accounts') ?? 'Email Accounts'); ?></h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400"><?php echo e(__('frontend.manage_emails') ?? 'Manage emails'); ?></p>
                    </a>
                    
                    <!-- PHP Selector -->
                    <a href="<?php echo e(route('client.hosting.php.selector', $service->id)); ?>" target="_blank" class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-xl p-6 border border-gray-200/50 dark:border-gray-700/50 hover:shadow-lg transition-all duration-200 cursor-pointer group block">
                        <div class="flex items-center justify-between mb-4">
                            <div class="h-12 w-12 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-1"><?php echo e(__('frontend.php_selector')); ?></h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400"><?php echo e(__('frontend.manage_php_version')); ?></p>
                    </a>
                    
                    <!-- WordPress -->
                    <a href="<?php echo e(route('client.hosting.wordpress', $service->id)); ?>" target="_blank" class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-xl p-6 border border-gray-200/50 dark:border-gray-700/50 hover:shadow-lg transition-all duration-200 cursor-pointer group block">
                        <div class="flex items-center justify-between mb-4">
                            <div class="h-12 w-12 bg-gradient-to-br from-blue-600 to-blue-800 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <img src="<?php echo e(asset('assets/images/wordpress-logo-svgrepo-com.svg')); ?>" alt="WordPress" class="w-6 h-6 brightness-0 invert">
                            </div>
                        </div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-1"><?php echo e(__('frontend.wordpress') ?? 'WordPress'); ?></h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400"><?php echo e(__('frontend.install_wordpress') ?? 'Install WordPress'); ?></p>
                    </a>
                    
                    <!-- ModSecurity -->
                    <a href="<?php echo e(route('client.hosting.modsecurity', $service->id)); ?>" target="_blank" class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-xl p-6 border border-gray-200/50 dark:border-gray-700/50 hover:shadow-lg transition-all duration-200 cursor-pointer group block">
                        <div class="flex items-center justify-between mb-4">
                            <div class="h-12 w-12 bg-gradient-to-br from-red-600 to-orange-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-1"><?php echo e(__('frontend.modsecurity') ?? 'ModSecurity'); ?></h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400"><?php echo e(__('frontend.web_application_firewall') ?? 'Web Application Firewall'); ?></p>
                    </a>
                    
                    <!-- Sitejet Builder -->
                    <a href="<?php echo e(route('client.hosting.sitejet', $service->id)); ?>" target="_blank" class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-xl p-6 border border-gray-200/50 dark:border-gray-700/50 hover:shadow-lg transition-all duration-200 cursor-pointer group block">
                        <div class="flex items-center justify-between mb-4">
                            <div class="h-12 w-12 bg-gradient-to-br from-pink-600 to-rose-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-1"><?php echo e(__('frontend.sitejet_builder') ?? 'Sitejet Builder'); ?></h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400"><?php echo e(__('frontend.website_builder') ?? 'Website Builder'); ?></p>
                    </a>
                    
                    <!-- Social Media Management -->
                    <a href="<?php echo e(route('client.hosting.social', $service->id)); ?>" target="_blank" class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-xl p-6 border border-gray-200/50 dark:border-gray-700/50 hover:shadow-lg transition-all duration-200 cursor-pointer group block">
                        <div class="flex items-center justify-between mb-4">
                            <div class="h-12 w-12 bg-gradient-to-br from-violet-600 to-fuchsia-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-1"><?php echo e(__('frontend.social_media') ?? 'Social Media'); ?></h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400"><?php echo e(__('frontend.social_media_management') ?? 'Social Media Management'); ?></p>
                    </a>
                    
                    <!-- Sitepad -->
                    <a href="<?php echo e(route('client.hosting.sitepad', $service->id)); ?>" target="_blank" class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-xl p-6 border border-gray-200/50 dark:border-gray-700/50 hover:shadow-lg transition-all duration-200 cursor-pointer group block">
                        <div class="flex items-center justify-between mb-4">
                            <div class="h-12 w-12 bg-gradient-to-br from-teal-600 to-cyan-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-1"><?php echo e(__('frontend.sitepad') ?? 'Sitepad'); ?></h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400"><?php echo e(__('frontend.sitepad_builder') ?? 'Website Builder'); ?></p>
                    </a>
                </div>
                <?php endif; ?>
            </div>

            <!-- Right Sidebar -->
            <div class="lg:col-span-3 space-y-6">
                
                <!-- Service Details Card -->
                <div class="bg-gradient-to-br from-white via-blue-50/30 to-indigo-50/40 dark:from-gray-800 dark:via-gray-800 dark:to-gray-700 rounded-2xl shadow-xl overflow-hidden border border-blue-200/50 dark:border-gray-600 backdrop-blur-sm">
                    <!-- Header -->
                    <div class="px-6 py-5 bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 border-b border-blue-800 relative overflow-hidden">
                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_50%,rgba(255,255,255,0.1),transparent_50%)]" aria-hidden="true"></div>
                        <h2 class="text-lg font-bold text-white flex items-center gap-2 relative z-10">
                            <div class="h-9 w-9 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center ring-2 ring-white/30">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="drop-shadow-sm"><?php echo e(__('frontend.service_details') ?? 'Service Details'); ?></span>
                        </h2>
                    </div>
                    
                    <!-- Content -->
                    <div class="p-6 space-y-5">
                        <!-- Start Date -->
                        <div class="pb-5 border-b border-blue-100 dark:border-gray-600">
                            <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-emerald-50 to-green-50 dark:from-emerald-900/20 dark:to-green-900/20 rounded-xl border border-emerald-200/50 dark:border-emerald-700/30">
                                <div class="flex-shrink-0 h-12 w-12 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/30">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <span class="text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-wider mb-1 block"><?php echo e(__('frontend.start_date') ?? 'Start Date'); ?></span>
                                    <p class="text-base font-bold text-gray-900 dark:text-white"><?php echo e($service->activated_at ? $service->activated_at->format('M d, Y') : $service->created_at->format('M d, Y')); ?></p>
                                    <p class="text-xs text-gray-600 dark:text-gray-300 font-medium mt-0.5"><?php echo e($service->activated_at ? $service->activated_at->format('h:i A') : $service->created_at->format('h:i A')); ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- End Date (Renewal Date) -->
                        <div class="pb-5">
                            <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-rose-50 to-pink-50 dark:from-rose-900/20 dark:to-pink-900/20 rounded-xl border border-rose-200/50 dark:border-rose-700/30">
                                <div class="flex-shrink-0 h-12 w-12 bg-gradient-to-br from-rose-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg shadow-rose-500/30">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <span class="text-xs font-bold text-rose-700 dark:text-rose-400 uppercase tracking-wider mb-1 block"><?php echo e(__('frontend.end_date') ?? 'End Date'); ?></span>
                                    <?php if($service->next_due_date): ?>
                                        <p class="text-base font-bold text-gray-900 dark:text-white"><?php echo e($service->next_due_date->format('M d, Y')); ?></p>
                                        <p class="text-xs text-gray-600 dark:text-gray-300 font-medium mt-0.5"><?php echo e($service->next_due_date->format('h:i A')); ?></p>
                                    <?php elseif($service->expiry_date): ?>
                                        <p class="text-base font-bold text-gray-900 dark:text-white"><?php echo e($service->expiry_date->format('M d, Y')); ?></p>
                                        <p class="text-xs text-gray-600 dark:text-gray-300 font-medium mt-0.5"><?php echo e($service->expiry_date->format('h:i A')); ?></p>
                                    <?php else: ?>
                                        <p class="text-sm font-bold text-gray-500 dark:text-gray-400">Not Set</p>
                                        <!-- Debug: <?php echo e($service->getAttributes()['next_due_date'] ?? 'NULL in attributes'); ?> -->
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Server Information -->
                <?php if($service->server): ?>
                <div class="bg-gradient-to-br from-white via-indigo-50/30 to-purple-50/40 dark:from-gray-800 dark:via-gray-800 dark:to-gray-700 rounded-2xl shadow-xl overflow-hidden border border-indigo-200/50 dark:border-gray-600 backdrop-blur-sm">
                    <div class="px-6 py-5 bg-gradient-to-r from-indigo-600 via-purple-600 to-purple-700 border-b border-indigo-800 relative overflow-hidden">
                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_50%,rgba(255,255,255,0.1),transparent_50%)]" aria-hidden="true"></div>
                        <h2 class="text-lg font-bold text-white flex items-center gap-2 relative z-10">
                            <div class="h-9 w-9 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center ring-2 ring-white/30">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                                </svg>
                            </div>
                            <span class="drop-shadow-sm"><?php echo e(__('frontend.server_info') ?? 'Server Information'); ?></span>
                        </h2>
                    </div>
                    <div class="p-6 space-y-5">
                        <!-- Server Name -->
                        <div class="pb-5 border-b border-indigo-100 dark:border-gray-600">
                            <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 rounded-xl border border-blue-200/50 dark:border-blue-700/30">
                                <div class="flex-shrink-0 h-12 w-12 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/30">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <span class="text-xs font-bold text-blue-700 dark:text-blue-400 uppercase tracking-wider mb-1 block">Server</span>
                                    <p class="text-base font-bold text-gray-900 dark:text-white truncate"><?php echo e($service->server->name); ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <?php if($service->username): ?>
                        <!-- Username -->
                        <div class="pb-5 border-b border-indigo-100 dark:border-gray-600">
                            <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-indigo-50 to-violet-50 dark:from-indigo-900/20 dark:to-violet-900/20 rounded-xl border border-indigo-200/50 dark:border-indigo-700/30">
                                <div class="flex-shrink-0 h-12 w-12 bg-gradient-to-br from-indigo-500 to-violet-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/30">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <span class="text-xs font-bold text-indigo-700 dark:text-indigo-400 uppercase tracking-wider mb-1 block"><?php echo e(__('frontend.username')); ?></span>
                                    <p class="text-base font-mono font-bold text-gray-900 dark:text-white truncate"><?php echo e($service->username); ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if($service->server->hostname): ?>
                        <!-- Hostname -->
                        <div class="pb-5 border-b border-indigo-100 dark:border-gray-600">
                            <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-purple-50 to-fuchsia-50 dark:from-purple-900/20 dark:to-fuchsia-900/20 rounded-xl border border-purple-200/50 dark:border-purple-700/30">
                                <div class="flex-shrink-0 h-12 w-12 bg-gradient-to-br from-purple-500 to-fuchsia-600 rounded-xl flex items-center justify-center shadow-lg shadow-purple-500/30">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <span class="text-xs font-bold text-purple-700 dark:text-purple-400 uppercase tracking-wider mb-1 block">Hostname</span>
                                    <p class="text-sm font-mono text-gray-900 dark:text-white truncate"><?php echo e($service->server->hostname); ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if($service->server->nameserver1 || $service->server->nameserver2 || $service->server->nameserver3 || $service->server->nameserver4): ?>
                        <!-- DNS Nameservers -->
                        <div class="pb-5 border-b border-indigo-100 dark:border-gray-600">
                            <div class="p-4 bg-gradient-to-r from-cyan-50 to-sky-50 dark:from-cyan-900/20 dark:to-sky-900/20 rounded-xl border border-cyan-200/50 dark:border-cyan-700/30">
                                <div class="flex items-start gap-4 mb-3">
                                    <div class="flex-shrink-0 h-12 w-12 bg-gradient-to-br from-cyan-500 to-sky-600 rounded-xl flex items-center justify-center shadow-lg shadow-cyan-500/30">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <span class="text-xs font-bold text-cyan-700 dark:text-cyan-400 uppercase tracking-wider mb-2 block">DNS Nameservers</span>
                                        <div class="space-y-2">
                                            <?php if($service->server->nameserver1): ?>
                                            <p onclick="copyToClipboard('<?php echo e($service->server->nameserver1); ?>')" class="text-xs font-mono text-gray-900 dark:text-white truncate cursor-pointer px-3 py-2 rounded-lg border border-cyan-200/50 dark:border-cyan-700/30"><?php echo e($service->server->nameserver1); ?></p>
                                            <?php endif; ?>
                                            <?php if($service->server->nameserver2): ?>
                                            <p onclick="copyToClipboard('<?php echo e($service->server->nameserver2); ?>')" class="text-xs font-mono text-gray-900 dark:text-white truncate cursor-pointer px-3 py-2 rounded-lg border border-cyan-200/50 dark:border-cyan-700/30"><?php echo e($service->server->nameserver2); ?></p>
                                            <?php endif; ?>
                                            <?php if($service->server->nameserver3): ?>
                                            <p onclick="copyToClipboard('<?php echo e($service->server->nameserver3); ?>')" class="text-xs font-mono text-gray-900 dark:text-white truncate cursor-pointer px-3 py-2 rounded-lg border border-cyan-200/50 dark:border-cyan-700/30"><?php echo e($service->server->nameserver3); ?></p>
                                            <?php endif; ?>
                                            <?php if($service->server->nameserver4): ?>
                                            <p onclick="copyToClipboard('<?php echo e($service->server->nameserver4); ?>')" class="text-xs font-mono text-gray-900 dark:text-white truncate cursor-pointer px-3 py-2 rounded-lg border border-cyan-200/50 dark:border-cyan-700/30"><?php echo e($service->server->nameserver4); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if(isset($service->server_data['whm_package'])): ?>
                        <!-- Package -->
                        <div class="pb-5">
                            <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-xl border border-emerald-200/50 dark:border-emerald-700/30">
                                <div class="flex-shrink-0 h-12 w-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/30">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <span class="text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-wider mb-1 block">Package</span>
                                    <p class="text-base font-bold text-gray-900 dark:text-white truncate"><?php echo e(str_replace('progin5_', '', $service->server_data['whm_package'])); ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<!-- Modal for Success/Error Messages -->
<div id="messageModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Background backdrop with blur effect -->
    <div id="modalBackdrop" class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>
    
    <!-- Modal Container - Centered -->
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <!-- Modal panel -->
        <div id="modalPanel" class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl transform transition-all w-full max-w-lg">
            <!-- Modal Content -->
            <div class="bg-white dark:bg-gray-800 px-6 pt-6 pb-4">
                <div class="sm:flex sm:items-start">
                    <!-- Icon -->
                    <div id="modalIcon" class="mx-auto flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-full sm:mx-0 sm:h-14 sm:w-14 transition-all duration-300">
                        <!-- Success Icon (Hidden by default) -->
                        <svg id="successIcon" class="hidden h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <!-- Error Icon (Hidden by default) -->
                        <svg id="errorIcon" class="hidden h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <!-- Text Content -->
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-1">
                        <h3 class="text-xl font-bold leading-6 text-gray-900 dark:text-white mb-2" id="modalTitle">
                            Message
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-600 dark:text-gray-300" id="modalMessage">
                                Message content goes here
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Actions -->
            <div class="bg-gray-50 dark:bg-gray-900/50 px-6 py-4 sm:flex sm:flex-row-reverse rounded-b-2xl">
                <button type="button" onclick="closeModal()" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-3 text-base font-semibold text-white focus:outline-none focus:ring-2 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-200 transform hover:scale-105" id="modalButton">
                    <?php echo e(__('frontend.close') ?? 'Close'); ?>

                </button>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Background backdrop with blur effect -->
    <div id="confirmBackdrop" class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>
    
    <!-- Modal Container - Centered -->
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <!-- Modal panel -->
        <div id="confirmPanel" class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl transform transition-all w-full max-w-lg">
            <div class="bg-white dark:bg-gray-800 px-6 pt-6 pb-4">
                <div class="sm:flex sm:items-start">
                    <!-- Warning Icon -->
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-full bg-gradient-to-br from-yellow-400 to-orange-500 sm:mx-0 sm:h-14 sm:w-14 shadow-lg">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-1">
                        <h3 class="text-xl font-bold leading-6 text-gray-900 dark:text-white mb-2" id="confirmTitle">
                            <?php echo e(__('frontend.confirm_delete') ?? 'Confirm Delete'); ?>

                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-600 dark:text-gray-300" id="confirmMessage">
                                <!-- Message will be dynamically updated via JavaScript -->
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-900/50 px-6 py-4 sm:flex sm:flex-row-reverse gap-3 rounded-b-2xl">
                <button type="button" onclick="confirmDelete()" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-base font-semibold text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm transition-all duration-200 transform hover:scale-105">
                    <?php echo e(__('frontend.delete') ?? 'Delete'); ?>

                </button>
                <button type="button" onclick="closeConfirmModal()" class="mt-3 sm:mt-0 w-full inline-flex justify-center rounded-xl border-2 border-gray-300 dark:border-gray-600 shadow-sm px-6 py-3 bg-white dark:bg-gray-800 text-base font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:w-auto sm:text-sm transition-all duration-200">
                    <?php echo e(__('frontend.cancel') ?? 'Cancel'); ?>

                </button>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<!-- Custom Accordion Animation Styles -->
<style>
    .accordion-content {
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Smooth icon rotation */
    #emailAccordionIcon {
        transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Add subtle glow effect when accordion is open */
    .accordion-open {
        box-shadow: 0 4px 20px rgba(16, 185, 129, 0.1);
    }
    
    /* Modal Animation Styles */
    #modalBackdrop, #confirmBackdrop {
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
    }
    
    #modalPanel, #confirmPanel {
        opacity: 0;
        transform: scale(0.95);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Modal icon animation */
    #modalIcon {
        animation: modalIconBounce 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }
    
    @keyframes modalIconBounce {
        0% {
            transform: scale(0);
            opacity: 0;
        }
        50% {
            transform: scale(1.1);
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }
    
    /* Smooth hover effect on accordion button */
    button[onclick="toggleEmailAccordion()"]:hover #emailAccordionIcon {
        transform: scale(1.1);
    }
    
    /* Enhanced Domain Select Dropdown */
    #email_domain {
        background-image: none !important;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
    }
    
    #email_domain:hover {
        transform: translateY(-1px);
    }
    
    #email_domain:focus {
        transform: translateY(0);
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
    }
    
    #email_domain option {
        padding: 10px;
        font-weight: 600;
        background-color: white;
        color: #1f2937;
    }
    
    /* Dark mode for options */
    .dark #email_domain option {
        background-color: #374151;
        color: #f3f4f6;
    }
    
    /* Main domain styling - specific and persistent */
    #email_domain option[data-main="true"] {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        color: white !important;
        font-weight: 700;
    }
    
    /* Hover state for non-main options */
    #email_domain option:hover:not([data-main="true"]) {
        background-color: #f3f4f6;
    }
    
    .dark #email_domain option:hover:not([data-main="true"]) {
        background-color: #4b5563;
    }
    
    /* Selected state */
    #email_domain option:checked {
        background-color: #10b981;
        color: white;
    }
    
    #email_domain option[data-main="true"]:checked {
        background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
        color: white !important;
    }
    
    /* Smooth loading transition */
    #domain-loading {
        animation: fadeIn 0.3s ease-in-out;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
</style>

<script>
    // Copy to Clipboard Function with Simple Toast
    function copyToClipboard(text) {
        console.log('Copying:', text); // Debug
        navigator.clipboard.writeText(text).then(function() {
            console.log('Copy success!'); // Debug
            showToast(<?php echo json_encode(__('frontend.copied_successfully'), 15, 512) ?>, 'success');
        }).catch(function(err) {
            console.error('Failed to copy: ', err);
            showToast(<?php echo json_encode(__('frontend.copy_failed'), 15, 512) ?>, 'error');
        });
    }

    // Simple Toast Notification Function
    function showToast(message, type) {
        console.log('Showing toast:', message, type); // Debug
        
        // Remove existing toast if any
        const existingToast = document.getElementById('custom-toast');
        if (existingToast) {
            existingToast.remove();
        }

        // Create toast element
        const toast = document.createElement('div');
        toast.id = 'custom-toast';
        toast.style.cssText = 'position: fixed; top: 20px; left: 50%; transform: translateX(-50%) translateY(-30px) scale(0.9); z-index: 9999; padding: 12px 20px; border-radius: 50px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55); opacity: 0; min-width: 240px; backdrop-filter: blur(10px);';
        
        if (type === 'success') {
            toast.style.background = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
            toast.style.color = 'white';
            toast.innerHTML = `
                <div style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                    <div style="background: rgba(255,255,255,0.2); border-radius: 50%; padding: 6px; display: flex; align-items: center; justify-content: center;">
                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <span style="font-weight: 600; font-size: 14px; letter-spacing: 0.3px;">${message}</span>
                </div>
            `;
        } else {
            toast.style.background = 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)';
            toast.style.color = 'white';
            toast.innerHTML = `
                <div style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                    <div style="background: rgba(255,255,255,0.2); border-radius: 50%; padding: 6px; display: flex; align-items: center; justify-content: center;">
                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <span style="font-weight: 600; font-size: 14px; letter-spacing: 0.3px;">${message}</span>
                </div>
            `;
        }

        // Add to document
        document.body.appendChild(toast);
        console.log('Toast added to body'); // Debug

        // Animate in with bounce effect
        setTimeout(() => {
            toast.style.opacity = '1';
            toast.style.transform = 'translateX(-50%) translateY(0) scale(1)';
            console.log('Toast animated in'); // Debug
        }, 10);

        // Remove after 3 seconds with fade out
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(-50%) translateY(-30px) scale(0.95)';
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.remove();
                    console.log('Toast removed'); // Debug
                }
            }, 400);
        }, 3000);
    }

    // Initialize Charts
    <?php if($service->status === 'active' && !empty($stats)): ?>
    let diskChart, bandwidthChart, domainsChart, emailChart;
    
    function initializeCharts() {
        // Create gradient colors for charts
        const createGradient = (ctx, color1, color2) => {
            const gradient = ctx.createLinearGradient(0, 0, 0, 200);
            gradient.addColorStop(0, color1);
            gradient.addColorStop(1, color2);
            return gradient;
        };

        const chartConfig = (canvasId, percent, color1, color2, bgColor) => {
            const ctx = document.getElementById(canvasId).getContext('2d');
            const gradient = createGradient(ctx, color1, color2);
            
            return {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [0, 100], // Start at 0 for animation
                        backgroundColor: [gradient, bgColor],
                        borderWidth: 0,
                        cutout: '75%'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: false }
                    },
                    animation: {
                        animateRotate: true,
                        animateScale: true,
                        duration: 2000,
                        easing: 'easeInOutQuart',
                        onComplete: function() {
                            // Add subtle pulse animation
                            const canvas = this.canvas;
                            canvas.style.animation = 'chartPulse 3s ease-in-out infinite';
                        }
                    }
                }
            };
        };

        // Disk Chart - Blue to Cyan Gradient
        const diskPercent = <?php echo e($stats['disk_percent'] ?? 0); ?>;
        diskChart = new Chart(
            document.getElementById('diskChart'), 
            chartConfig('diskChart', diskPercent, '#3b82f6', '#06b6d4', 'rgba(224, 242, 254, 0.2)')
        );
        // Animate to actual value
        setTimeout(() => {
            diskChart.data.datasets[0].data = [diskPercent, 100 - diskPercent];
            diskChart.update();
        }, 100);

        // Bandwidth Chart - Green to Emerald Gradient
        const bandwidthPercent = <?php echo e($stats['bandwidth_percent'] ?? 0); ?>;
        bandwidthChart = new Chart(
            document.getElementById('bandwidthChart'),
            chartConfig('bandwidthChart', bandwidthPercent, '#10b981', '#059669', 'rgba(209, 250, 229, 0.2)')
        );
        setTimeout(() => {
            bandwidthChart.data.datasets[0].data = [bandwidthPercent, 100 - bandwidthPercent];
            bandwidthChart.update();
        }, 300);

        // Domains Chart - Purple to Pink Gradient
        const domainsPercent = <?php echo e($addonPercent ?? 0); ?>;
        domainsChart = new Chart(
            document.getElementById('domainsChart'),
            chartConfig('domainsChart', domainsPercent, '#8b5cf6', '#ec4899', 'rgba(243, 232, 255, 0.2)')
        );
        setTimeout(() => {
            domainsChart.data.datasets[0].data = [domainsPercent, 100 - domainsPercent];
            domainsChart.update();
        }, 500);

        // Email Chart - Orange to Amber Gradient
        const emailPercent = <?php echo e($emailPercent ?? 0); ?>;
        emailChart = new Chart(
            document.getElementById('emailChart'),
            chartConfig('emailChart', emailPercent, '#f59e0b', '#f97316', 'rgba(254, 243, 199, 0.2)')
        );
        setTimeout(() => {
            emailChart.data.datasets[0].data = [emailPercent, 100 - emailPercent];
            emailChart.update();
        }, 700);

        // Add CSS animation for pulse effect
        if (!document.getElementById('chart-animations')) {
            const style = document.createElement('style');
            style.id = 'chart-animations';
            style.textContent = `
                @keyframes chartPulse {
                    0%, 100% { 
                        filter: drop-shadow(0 0 0 rgba(255, 255, 255, 0));
                    }
                    50% { 
                        filter: drop-shadow(0 0 15px rgba(255, 255, 255, 0.3));
                    }
                }
                .chart-container:hover canvas {
                    animation: none !important;
                    filter: drop-shadow(0 0 20px rgba(255, 255, 255, 0.4)) !important;
                }
            `;
            document.head.appendChild(style);
        }
    }

    // Initialize charts on page load
    document.addEventListener('DOMContentLoaded', initializeCharts);
    <?php endif; ?>

    // Auto-refresh usage statistics every 5 minutes
    <?php if($service->status === 'active' && !empty($stats)): ?>
    let statsRefreshInterval = null;
    
    function updateStats() {
        fetch('<?php echo e(route('client.hosting.stats', $service->id)); ?>', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.stats) {
                const stats = data.stats;
                
                // Update Disk Usage
                if (stats.disk_used && stats.disk_limit) {
                    const diskChartText = document.querySelector('#disk-chart-text');
                    const diskChartPercent = document.querySelector('#disk-chart-percent');
                    if (diskChartText) diskChartText.textContent = `${stats.disk_used} / ${stats.disk_limit}`;
                    if (diskChartPercent) diskChartPercent.textContent = `${stats.disk_percent}%`;
                    
                    // Update chart
                    if (diskChart) {
                        diskChart.data.datasets[0].data = [stats.disk_percent, 100 - stats.disk_percent];
                        diskChart.update();
                    }
                }
                
                // Update Bandwidth
                if (stats.bandwidth_used && stats.bandwidth_limit) {
                    const bandwidthChartText = document.querySelector('#bandwidth-chart-text');
                    const bandwidthChartPercent = document.querySelector('#bandwidth-chart-percent');
                    if (bandwidthChartText) bandwidthChartText.textContent = `${stats.bandwidth_used} / ${stats.bandwidth_limit}`;
                    if (bandwidthChartPercent) bandwidthChartPercent.textContent = `${stats.bandwidth_percent}%`;
                    
                    // Update chart
                    if (bandwidthChart) {
                        bandwidthChart.data.datasets[0].data = [stats.bandwidth_percent, 100 - stats.bandwidth_percent];
                        bandwidthChart.update();
                    }
                }
                
                // Update Addon Domains
                if (stats.addon_domains !== undefined) {
                    const addonUsed = stats.addon_domains_used || 0;
                    const addonTotal = (stats.addon_domains == -1 || stats.addon_domains == 999999) ? '∞' : stats.addon_domains;
                    const addonPercent = (stats.addon_domains > 0 && stats.addon_domains != 999999) 
                        ? Math.round((addonUsed / stats.addon_domains) * 100 * 100) / 100 
                        : 0;
                    
                    const domainsChartText = document.querySelector('#domains-chart-text');
                    const domainsChartPercent = document.querySelector('#domains-chart-percent');
                    if (domainsChartText) domainsChartText.textContent = `${addonUsed} / ${addonTotal}`;
                    if (domainsChartPercent) domainsChartPercent.textContent = `${addonPercent}%`;
                    
                    // Update chart
                    if (domainsChart) {
                        domainsChart.data.datasets[0].data = [addonPercent, 100 - addonPercent];
                        domainsChart.update();
                    }
                }
                
                // Update Email Accounts
                if (stats.email_accounts !== undefined) {
                    const emailUsed = stats.email_accounts_used || 0;
                    const emailTotal = (stats.email_accounts == -1 || stats.email_accounts == 999999) ? '∞' : stats.email_accounts;
                    const emailPercent = (stats.email_accounts > 0 && stats.email_accounts != 999999) 
                        ? Math.round((emailUsed / stats.email_accounts) * 100 * 100) / 100 
                        : 0;
                    
                    const emailChartText = document.querySelector('#email-chart-text');
                    const emailChartPercent = document.querySelector('#email-chart-percent');
                    if (emailChartText) emailChartText.textContent = `${emailUsed} / ${emailTotal}`;
                    if (emailChartPercent) emailChartPercent.textContent = `${emailPercent}%`;
                    
                    // Update chart
                    if (emailChart) {
                        emailChart.data.datasets[0].data = [emailPercent, 100 - emailPercent];
                        emailChart.update();
                    }
                }
                
                console.log('Stats updated at:', new Date().toLocaleString());
            }
        })
        .catch(error => {
            console.error('Error updating stats:', error);
        });
    }
    
    // Update stats immediately on page load
    updateStats();
    
    // Update stats every 5 minutes (300000 milliseconds)
    statsRefreshInterval = setInterval(updateStats, 300000);
    
    // Clean up interval when page is unloaded
    window.addEventListener('beforeunload', function() {
        if (statsRefreshInterval) {
            clearInterval(statsRefreshInterval);
        }
    });
    <?php endif; ?>

    // Email Management Functions
    <?php if($service->status === 'active'): ?>
    
    // Update email preview and validate username
    const serviceDomain = '<?php echo e($service->domain); ?>';
    const usernameInput = document.getElementById('email_username');
    const usernameError = document.getElementById('username-error');
    const usernameErrorText = document.getElementById('username-error-text');
    
    function validateUsername(value) {
        // Only allow letters, numbers, dots, underscores, and hyphens
        const validPattern = /^[a-zA-Z0-9._-]+$/;
        
        if (!value) {
            return { valid: true, message: '' };
        }
        
        if (!validPattern.test(value)) {
            return { 
                valid: false, 
                message: '<?php echo e(__('frontend.username_invalid_chars') ?? 'Only letters, numbers, dots, underscores and hyphens allowed'); ?>'
            };
        }
        
        if (value.length < 1) {
            return { 
                valid: false, 
                message: '<?php echo e(__('frontend.username_too_short') ?? 'Username is too short'); ?>'
            };
        }
        
        if (value.length > 64) {
            return { 
                valid: false, 
                message: '<?php echo e(__('frontend.username_too_long') ?? 'Username is too long (max 64 characters)'); ?>'
            };
        }
        
        return { valid: true, message: '' };
    }
    
    usernameInput?.addEventListener('input', function(e) {
        let value = e.target.value;
        
        // Remove invalid characters automatically
        const cleanValue = value.replace(/[^a-zA-Z0-9._-]/g, '');
        if (value !== cleanValue) {
            e.target.value = cleanValue;
            value = cleanValue;
        }
        
        // Update preview with selected domain
        const preview = document.getElementById('email_preview');
        if (preview) {
            const domainSelect = document.getElementById('email_domain');
            const selectedDomain = domainSelect ? domainSelect.value : serviceDomain;
            preview.textContent = (value || 'username') + '@' + selectedDomain;
        }
        
        // Validate and show error if needed
        const validation = validateUsername(value);
        if (!validation.valid && value.length > 0) {
            usernameError.classList.remove('hidden');
            usernameErrorText.textContent = validation.message;
            e.target.classList.add('border-red-500', 'dark:border-red-500');
            e.target.classList.remove('border-gray-300', 'dark:border-gray-600');
        } else {
            usernameError.classList.add('hidden');
            e.target.classList.remove('border-red-500', 'dark:border-red-500');
            e.target.classList.add('border-gray-300', 'dark:border-gray-600');
        }
    });

    // Toggle password visibility
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('email_password');
        const eyeIcon = document.getElementById('eye-icon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }
    }

    // Generate strong password
    function generatePassword() {
        const length = 16;
        const charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
        let password = '';
        for (let i = 0; i < length; i++) {
            password += charset.charAt(Math.floor(Math.random() * charset.length));
        }
        document.getElementById('email_password').value = password;
        document.getElementById('email_password').type = 'text';
    }

    // Create email account
    document.getElementById('createEmailForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validate username before submission
        const username = usernameInput.value;
        const validation = validateUsername(username);
        
        if (!validation.valid) {
            usernameError.classList.remove('hidden');
            usernameErrorText.textContent = validation.message;
            usernameInput.classList.add('border-red-500', 'dark:border-red-500');
            usernameInput.focus();
            return false;
        }
        
        const btn = document.getElementById('createEmailBtn');
        const btnText = document.getElementById('createEmailBtnText');
        const originalText = btnText.textContent;
        
        // Disable button
        btn.disabled = true;
        btnText.textContent = '<?php echo e(__('frontend.creating') ?? 'Creating...'); ?>';
        
        const formData = new FormData(this);
        
        fetch('<?php echo e(route('client.hosting.emails.create', $service->id)); ?>', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            const messageDiv = document.getElementById('email-message');
            
            if (data.success) {
                messageDiv.className = 'mt-4 p-4 bg-green-100 dark:bg-green-900/30 border border-green-300 dark:border-green-700 text-green-800 dark:text-green-200 rounded-lg flex items-start';
                messageDiv.innerHTML = `
                    <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>${data.message}</span>
                `;
                messageDiv.classList.remove('hidden');
                
                // Reset form
                document.getElementById('createEmailForm').reset();
                const domainSelect = document.getElementById('email_domain');
                const defaultDomain = domainSelect ? domainSelect.options[0].value : serviceDomain;
                document.getElementById('email_preview').textContent = 'username@' + defaultDomain;
                
                // Refresh email list
                refreshEmailList();
                
                // Update stats
                if (typeof updateStats === 'function') {
                    updateStats();
                }
                
                // Hide message after 5 seconds
                setTimeout(() => {
                    messageDiv.classList.add('hidden');
                }, 5000);
            } else {
                messageDiv.className = 'mt-4 p-4 bg-red-100 dark:bg-red-900/30 border border-red-300 dark:border-red-700 text-red-800 dark:text-red-200 rounded-lg flex items-start';
                messageDiv.innerHTML = `
                    <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span>${data.message}</span>
                `;
                messageDiv.classList.remove('hidden');
            }
        })
        .catch(error => {
            const messageDiv = document.getElementById('email-message');
            messageDiv.className = 'mt-4 p-4 bg-red-100 dark:bg-red-900/30 border border-red-300 dark:border-red-700 text-red-800 dark:text-red-200 rounded-lg';
            messageDiv.textContent = '<?php echo e(__('frontend.error_occurred') ?? 'An error occurred. Please try again.'); ?>';
            messageDiv.classList.remove('hidden');
            console.error('Error:', error);
        })
        .finally(() => {
            btn.disabled = false;
            btnText.textContent = originalText;
        });
    });

    // Load email list
    function loadEmailList() {
        const listDiv = document.getElementById('email-accounts-list');
        
        fetch('<?php echo e(route('client.hosting.emails.list', $service->id)); ?>', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Support both 'emails' and 'accounts' response keys
            const emailList = data.emails || data.accounts || [];
            
            if (data.success && emailList) {
                if (emailList.length === 0) {
                    listDiv.innerHTML = `
                        <div class="text-center py-12">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 rounded-2xl mb-4">
                                <svg class="w-10 h-10 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <p class="text-base font-medium text-gray-700 dark:text-gray-300 mb-1"><?php echo e(__('frontend.no_emails_yet') ?? 'No email accounts yet'); ?></p>
                            <p class="text-sm text-gray-500 dark:text-gray-400"><?php echo e(__('frontend.create_first_email') ?? 'Create your first email account using the form above'); ?></p>
                        </div>
                    `;
                } else {
                    listDiv.innerHTML = emailList.map((email, index) => `
                        <div class="bg-gradient-to-r from-white to-gray-50 dark:from-gray-700 dark:to-gray-700/50 rounded-xl p-4 border-2 border-gray-200 dark:border-gray-600 hover:border-green-300 dark:hover:border-green-700 hover:shadow-lg transition-all duration-200 group">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                <div class="flex items-center gap-4 flex-1 min-w-0">
                                    <div class="relative flex-shrink-0">
                                        <div class="h-12 w-12 bg-gradient-to-br from-green-400 to-emerald-500 dark:from-green-600 dark:to-emerald-700 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                        <div class="absolute -top-1 -right-1 h-4 w-4 bg-green-500 rounded-full border-2 border-white dark:border-gray-700"></div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm sm:text-base font-bold text-gray-900 dark:text-white truncate group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">
                                            ${email.email}
                                        </p>
                                        <div class="flex flex-wrap items-center gap-2 mt-1.5">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-blue-100 dark:bg-blue-900/30 text-xs font-medium text-blue-700 dark:text-blue-300">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                                                </svg>
                                                <?php echo e(__('frontend.quota') ?? 'Quota'); ?>: ${email.humandiskquota || 'Unlimited'}
                                            </span>
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-purple-100 dark:bg-purple-900/30 text-xs font-medium text-purple-700 dark:text-purple-300">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                                </svg>
                                                <?php echo e(__('frontend.used') ?? 'Used'); ?>: ${email.humandiskused || '0 KB'}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 sm:ml-4">
                                    <button onclick="deleteEmail('${email.user}', '${email.email}')" 
                                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-lg font-medium text-sm transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5 group/btn"
                                        title="<?php echo e(__('frontend.delete') ?? 'Delete'); ?>">
                                        <svg class="w-4 h-4 sm:mr-1.5 group-hover/btn:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        <span class="hidden sm:inline"><?php echo e(__('frontend.delete') ?? 'Delete'); ?></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `).join('');
                }
            } else {
                listDiv.innerHTML = `
                    <div class="text-center py-8">
                        <p class="text-red-500 dark:text-red-400"><?php echo e(__('frontend.failed_to_load') ?? 'Failed to load email accounts'); ?></p>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error loading emails:', error);
            listDiv.innerHTML = `
                <div class="text-center py-8">
                    <p class="text-red-500 dark:text-red-400"><?php echo e(__('frontend.error_occurred') ?? 'An error occurred'); ?></p>
                </div>
            `;
        });
    }

    // Refresh email list
    function refreshEmailList() {
        loadEmailList();
    }

    // Modal Functions
    function showModal(title, message, type = 'success') {
        const modal = document.getElementById('messageModal');
        const modalTitle = document.getElementById('modalTitle');
        const modalMessage = document.getElementById('modalMessage');
        const modalIcon = document.getElementById('modalIcon');
        const modalButton = document.getElementById('modalButton');
        const successIcon = document.getElementById('successIcon');
        const errorIcon = document.getElementById('errorIcon');
        const modalBackdrop = document.getElementById('modalBackdrop');
        const modalPanel = document.getElementById('modalPanel');
        
        // Set content
        modalTitle.textContent = title;
        modalMessage.textContent = message;
        
        // Configure based on type
        if (type === 'success') {
            modalIcon.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-full bg-gradient-to-br from-green-400 to-green-600 sm:mx-0 sm:h-12 sm:w-12 shadow-lg';
            successIcon.classList.remove('hidden');
            errorIcon.classList.add('hidden');
            modalButton.className = 'w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-base font-semibold text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-200 transform hover:scale-105';
        } else {
            modalIcon.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-full bg-gradient-to-br from-red-400 to-red-600 sm:mx-0 sm:h-12 sm:w-12 shadow-lg';
            errorIcon.classList.remove('hidden');
            successIcon.classList.add('hidden');
            modalButton.className = 'w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-base font-semibold text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-200 transform hover:scale-105';
        }
        
        // Show modal with animation
        modal.classList.remove('hidden');
        
        // Animate backdrop
        setTimeout(() => {
            modalBackdrop.style.opacity = '1';
        }, 10);
        
        // Animate panel
        setTimeout(() => {
            modalPanel.style.transform = 'scale(1)';
            modalPanel.style.opacity = '1';
        }, 50);
    }
    
    function closeModal() {
        const modal = document.getElementById('messageModal');
        const modalBackdrop = document.getElementById('modalBackdrop');
        const modalPanel = document.getElementById('modalPanel');
        
        // Animate out
        modalBackdrop.style.opacity = '0';
        modalPanel.style.transform = 'scale(0.95)';
        modalPanel.style.opacity = '0';
        
        // Hide after animation
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
    
    // Confirmation Modal Functions
    let pendingDeleteEmail = null;
    let pendingDeleteFullEmail = null;
    
    function showConfirmModal(emailUser, fullEmail = null) {
        pendingDeleteEmail = emailUser;
        pendingDeleteFullEmail = fullEmail;
        const modal = document.getElementById('confirmModal');
        const backdrop = document.getElementById('confirmBackdrop');
        const panel = document.getElementById('confirmPanel');
        const confirmMessage = document.getElementById('confirmMessage');
        
        // Update message with email address
        const displayEmail = fullEmail || emailUser;
        confirmMessage.innerHTML = `<?php echo e(__('frontend.confirm_delete_email_text') ?? 'Are you sure you want to delete'); ?><br><strong class="text-red-600 dark:text-red-400 font-mono">${displayEmail}</strong>?`;
        
        modal.classList.remove('hidden');
        
        setTimeout(() => {
            backdrop.style.opacity = '1';
        }, 10);
        
        setTimeout(() => {
            panel.style.transform = 'scale(1)';
            panel.style.opacity = '1';
        }, 50);
    }
    
    function closeConfirmModal() {
        const modal = document.getElementById('confirmModal');
        const backdrop = document.getElementById('confirmBackdrop');
        const panel = document.getElementById('confirmPanel');
        
        backdrop.style.opacity = '0';
        panel.style.transform = 'scale(0.95)';
        panel.style.opacity = '0';
        
        setTimeout(() => {
            modal.classList.add('hidden');
            pendingDeleteEmail = null;
        }, 300);
    }
    
    function confirmDelete() {
        if (pendingDeleteEmail) {
            closeConfirmModal();
            // Extract domain from full email if available
            let emailDomain = '<?php echo e($service->domain); ?>';
            if (pendingDeleteFullEmail && pendingDeleteFullEmail.includes('@')) {
                emailDomain = pendingDeleteFullEmail.split('@')[1];
            }
            performDelete(pendingDeleteEmail, emailDomain);
        }
    }
    
    // Close modal on backdrop click
    document.addEventListener('DOMContentLoaded', function() {
        const modalBackdrop = document.getElementById('modalBackdrop');
        if (modalBackdrop) {
            modalBackdrop.addEventListener('click', closeModal);
        }
        
        const confirmBackdrop = document.getElementById('confirmBackdrop');
        if (confirmBackdrop) {
            confirmBackdrop.addEventListener('click', closeConfirmModal);
        }
        
        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const messageModal = document.getElementById('messageModal');
                const confirmModal = document.getElementById('confirmModal');
                
                if (!confirmModal.classList.contains('hidden')) {
                    closeConfirmModal();
                } else if (!messageModal.classList.contains('hidden')) {
                    closeModal();
                }
            }
        });
    });

    // Delete email account
    function deleteEmail(emailUser, fullEmail = null) {
        showConfirmModal(emailUser, fullEmail);
    }
    
    function performDelete(emailUser, emailDomain = '<?php echo e($service->domain); ?>') {
        fetch('<?php echo e(route('client.hosting.emails.delete', $service->id)); ?>', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ 
                email_user: emailUser,
                email_domain: emailDomain 
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showModal(
                    '<?php echo e(__('frontend.success') ?? 'Success'); ?>',
                    data.message || '<?php echo e(__('frontend.email_deleted_successfully') ?? 'Email account deleted successfully'); ?>',
                    'success'
                );
                refreshEmailList();
                if (typeof updateStats === 'function') {
                    updateStats();
                }
            } else {
                showModal(
                    '<?php echo e(__('frontend.error') ?? 'Error'); ?>',
                    data.message || '<?php echo e(__('frontend.failed_to_delete') ?? 'Failed to delete email account'); ?>',
                    'error'
                );
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showModal(
                '<?php echo e(__('frontend.error') ?? 'Error'); ?>',
                '<?php echo e(__('frontend.error_occurred') ?? 'An error occurred'); ?>',
                'error'
            );
        });
    }

    // Load available domains
    function loadDomains() {
        const domainSelect = document.getElementById('email_domain');
        const domainLoading = document.getElementById('domain-loading');
        
        // Show loading indicator
        if (domainLoading) {
            domainLoading.style.display = 'flex';
        }
        
        // Disable select during loading
        if (domainSelect) {
            domainSelect.disabled = true;
            domainSelect.style.opacity = '0.6';
        }
        
        fetch('<?php echo e(route('client.hosting.domains.list', $service->id)); ?>', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.domains && domainSelect) {
                if (data.domains.length > 0) {
                    // Clear existing options
                    domainSelect.innerHTML = '';
                    
                    // Add all domains as options with icons
                    data.domains.forEach((domain, index) => {
                        const option = document.createElement('option');
                        option.value = domain;
                        
                        // Mark main domain with indicator
                        if (domain === '<?php echo e($service->domain); ?>') {
                            option.textContent = `${domain} (Main)`;
                            option.setAttribute('data-main', 'true');
                        } else {
                            option.textContent = domain;
                        }
                        
                        domainSelect.appendChild(option);
                    });
                    
                    // Auto-select main domain
                    domainSelect.value = '<?php echo e($service->domain); ?>';
                }
            }
        })
        .catch(error => {
            console.error('Error loading domains:', error);
            // Keep default domain on error
        })
        .finally(() => {
            // Hide loading indicator
            if (domainLoading) {
                domainLoading.style.display = 'none';
            }
            
            // Re-enable select
            if (domainSelect) {
                domainSelect.disabled = false;
                domainSelect.style.opacity = '1';
            }
        });
    }

    // Update email preview when domain changes
    const domainSelectEl = document.getElementById('email_domain');
    if (domainSelectEl) {
        domainSelectEl.addEventListener('change', function() {
            const usernameInputEl = document.getElementById('email_username');
            const preview = document.getElementById('email_preview');
            if (preview && usernameInputEl) {
                const username = usernameInputEl.value || 'username';
                preview.textContent = username + '@' + this.value;
            }
        });
    }

    // Load email list and domains on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadEmailList();
        loadDomains();
    });
    
    <?php endif; ?>
    
    // Accordion Toggle Function for Email Accounts Section with Smooth Animations
    function toggleEmailAccordion() {
        const content = document.getElementById('emailAccordionContent');
        const icon = document.getElementById('emailAccordionIcon');
        const accordionCard = content.closest('.bg-white\\/80');
        
        if (content.classList.contains('accordion-content')) {
            // Check if accordion is closed (has opacity-0)
            const isClosed = content.style.opacity === '0' || content.classList.contains('opacity-0');
            
            if (isClosed) {
                // Open accordion with smooth animation
                content.classList.remove('opacity-0');
                content.style.opacity = '1';
                content.style.maxHeight = '5000px'; // Large value to accommodate any content size
                content.style.transform = 'translateY(0)';
                content.style.padding = '1rem 1.5rem'; // Add padding when open (sm:p-6)
                icon.style.transform = 'rotate(180deg)';
                
                // Add glow effect to card
                if (accordionCard) {
                    accordionCard.classList.add('accordion-open');
                }
                
                // Optional: Add scale animation to icon
                icon.style.transition = 'transform 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
            } else {
                // Close accordion with smooth animation
                content.classList.add('opacity-0');
                content.style.opacity = '0';
                content.style.maxHeight = '0';
                content.style.transform = 'translateY(-10px)';
                content.style.padding = '0'; // Remove padding when closed to eliminate white space
                icon.style.transform = 'rotate(0deg)';
                
                // Remove glow effect from card
                if (accordionCard) {
                    accordionCard.classList.remove('accordion-open');
                }
            }
        }
    }
    
    // Add smooth scroll behavior when opening accordion
    document.addEventListener('DOMContentLoaded', function() {
        const accordionButton = document.querySelector('button[onclick="toggleEmailAccordion()"]');
        if (accordionButton) {
            accordionButton.addEventListener('click', function() {
                setTimeout(() => {
                    const content = document.getElementById('emailAccordionContent');
                    if (content && content.style.opacity === '1') {
                        // Smooth scroll to accordion when opened
                        accordionButton.scrollIntoView({ 
                            behavior: 'smooth', 
                            block: 'nearest' 
                        });
                    }
                }, 100);
            });
        }
    });

    // Accordion Toggle Function for FTP Section with Smooth Animations
    function toggleFtpAccordion() {
        const content = document.getElementById('ftpAccordionContent');
        const icon = document.getElementById('ftpAccordionIcon');
        const accordionCard = content.closest('.bg-white\\/80');
        
        if (content.classList.contains('accordion-content')) {
            // Check if accordion is closed (has opacity-0)
            const isClosed = content.style.opacity === '0' || content.classList.contains('opacity-0');
            
            if (isClosed) {
                // Open accordion with smooth animation
                content.classList.remove('opacity-0');
                content.style.opacity = '1';
                content.style.maxHeight = '5000px';
                content.style.transform = 'translateY(0)';
                content.style.padding = '1rem 1.5rem';
                icon.style.transform = 'rotate(180deg)';
                
                if (accordionCard) {
                    accordionCard.classList.add('accordion-open');
                }
                
                icon.style.transition = 'transform 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
                
                // Load FTP accounts when opened
                loadFtpList();
            } else {
                // Close accordion with smooth animation
                content.classList.add('opacity-0');
                content.style.opacity = '0';
                content.style.maxHeight = '0';
                content.style.transform = 'translateY(-10px)';
                content.style.padding = '0';
                icon.style.transform = 'rotate(0deg)';
                
                if (accordionCard) {
                    accordionCard.classList.remove('accordion-open');
                }
            }
        }
    }

    // Accordion Toggle Function for Password Section with Smooth Animations
    function togglePasswordAccordion() {
        const content = document.getElementById('passwordAccordionContent');
        const icon = document.getElementById('passwordAccordionIcon');
        const accordionCard = content.closest('.bg-white\\/80');
        
        if (content.classList.contains('accordion-content')) {
            // Check if accordion is closed (has opacity-0)
            const isClosed = content.style.opacity === '0' || content.classList.contains('opacity-0');
            
            if (isClosed) {
                // Open accordion with smooth animation
                content.classList.remove('opacity-0');
                content.style.opacity = '1';
                content.style.maxHeight = '5000px'; // Large value to accommodate any content size
                content.style.transform = 'translateY(0)';
                content.style.padding = '1rem 1.5rem'; // Add padding when open (sm:p-6)
                icon.style.transform = 'rotate(180deg)';
                
                // Add glow effect to card
                if (accordionCard) {
                    accordionCard.classList.add('accordion-open');
                }
                
                // Optional: Add scale animation to icon
                icon.style.transition = 'transform 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
            } else {
                // Close accordion with smooth animation
                content.classList.add('opacity-0');
                content.style.opacity = '0';
                content.style.maxHeight = '0';
                content.style.transform = 'translateY(-10px)';
                content.style.padding = '0'; // Remove padding when closed to eliminate white space
                icon.style.transform = 'rotate(0deg)';
                
                // Remove glow effect from card
                if (accordionCard) {
                    accordionCard.classList.remove('accordion-open');
                }
            }
        }
    }

    // cPanel Password Management Functions
    <?php if($service->status === 'active'): ?>
    
    // Toggle password visibility for cPanel password fields
    function toggleCpanelPasswordVisibility(fieldId) {
        const field = document.getElementById(fieldId);
        if (field) {
            field.type = field.type === 'password' ? 'text' : 'password';
        }
    }

    // Generate strong password for cPanel
    function generateCpanelPassword() {
        const length = 16;
        const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+-=[]{}|;:,.<>?";
        let password = "";
        
        // Ensure at least one of each type
        password += "ABCDEFGHIJKLMNOPQRSTUVWXYZ"[Math.floor(Math.random() * 26)]; // Uppercase
        password += "abcdefghijklmnopqrstuvwxyz"[Math.floor(Math.random() * 26)]; // Lowercase
        password += "0123456789"[Math.floor(Math.random() * 10)]; // Number
        password += "!@#$%^&*()_+-="[Math.floor(Math.random() * 14)]; // Special char
        
        // Fill the rest randomly
        for (let i = password.length; i < length; i++) {
            password += charset[Math.floor(Math.random() * charset.length)];
        }
        
        // Shuffle the password
        password = password.split('').sort(() => Math.random() - 0.5).join('');
        
        // Set to both fields
        document.getElementById('new_password').value = password;
        document.getElementById('confirm_password').value = password;
        
        // Show fields as text temporarily
        document.getElementById('new_password').type = 'text';
        document.getElementById('confirm_password').type = 'text';
        
        // Hide error message
        const errorMsg = document.getElementById('password-match-error');
        if (errorMsg) {
            errorMsg.style.display = 'none';
        }
    }

    // Validate password match
    function validatePasswordMatch() {
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        const errorMsg = document.getElementById('password-match-error');
        
        if (confirmPassword && newPassword !== confirmPassword) {
            errorMsg.style.display = 'flex';
            return false;
        } else {
            errorMsg.style.display = 'none';
            return true;
        }
    }

    // Add event listeners for password validation
    document.addEventListener('DOMContentLoaded', function() {
        const confirmPasswordField = document.getElementById('confirm_password');
        if (confirmPasswordField) {
            confirmPasswordField.addEventListener('input', validatePasswordMatch);
        }
    });

    // Handle password change form submission
    const changePasswordForm = document.getElementById('changePasswordForm');
    if (changePasswordForm) {
        changePasswordForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate passwords match
            if (!validatePasswordMatch()) {
                showModal(
                    '<?php echo e(__('frontend.error') ?? 'Error'); ?>',
                    '<?php echo e(__('frontend.passwords_dont_match') ?? 'Passwords do not match'); ?>',
                    'error'
                );
                return;
            }
            
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (newPassword.length < 8) {
                showModal(
                    '<?php echo e(__('frontend.error') ?? 'Error'); ?>',
                    '<?php echo e(__('frontend.password_too_short') ?? 'Password must be at least 8 characters long'); ?>',
                    'error'
                );
                return;
            }
            
            const btn = document.getElementById('changePasswordBtn');
            const btnText = document.getElementById('changePasswordBtnText');
            const originalText = btnText.textContent;
            
            // Disable button and show loading
            btn.disabled = true;
            btn.style.opacity = '0.6';
            btnText.textContent = '<?php echo e(__('frontend.changing_password') ?? 'Changing Password...'); ?>';
            
            fetch('<?php echo e(route('client.hosting.change-password', $service->id)); ?>', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    new_password: newPassword,
                    confirm_password: confirmPassword
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showModal(
                        '<?php echo e(__('frontend.success') ?? 'Success'); ?>',
                        data.message || '<?php echo e(__('frontend.password_changed_successfully') ?? 'Password changed successfully'); ?>',
                        'success'
                    );
                    
                    // Reset form
                    changePasswordForm.reset();
                } else {
                    showModal(
                        '<?php echo e(__('frontend.error') ?? 'Error'); ?>',
                        data.message || '<?php echo e(__('frontend.failed_to_change_password') ?? 'Failed to change password'); ?>',
                        'error'
                    );
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showModal(
                    '<?php echo e(__('frontend.error') ?? 'Error'); ?>',
                    '<?php echo e(__('frontend.error_occurred') ?? 'An error occurred while changing password'); ?>',
                    'error'
                );
            })
            .finally(() => {
                // Re-enable button
                btn.disabled = false;
                btn.style.opacity = '1';
                btnText.textContent = originalText;
            });
        });
    }
    
    // FTP Account Management Functions
    
    // Toggle password visibility for FTP password field
    function toggleFtpPasswordVisibility(fieldId) {
        const field = document.getElementById(fieldId);
        if (field) {
            const type = field.getAttribute('type') === 'password' ? 'text' : 'password';
            field.setAttribute('type', type);
        }
    }
    
    // Generate strong FTP password
    function generateFtpPassword() {
        // Generate a 20-character strong password (strength > 65)
        const uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        const lowercase = 'abcdefghijklmnopqrstuvwxyz';
        const numbers = '0123456789';
        const symbols = '!@#$%^&*()_+-=[]{}|;:,.<>?';
        
        let password = '';
        
        // Ensure we have at least 4 of each type for high strength
        for (let i = 0; i < 4; i++) {
            password += uppercase.charAt(Math.floor(Math.random() * uppercase.length));
            password += lowercase.charAt(Math.floor(Math.random() * lowercase.length));
            password += numbers.charAt(Math.floor(Math.random() * numbers.length));
            password += symbols.charAt(Math.floor(Math.random() * symbols.length));
        }
        
        // Add 4 more random characters
        const allChars = uppercase + lowercase + numbers + symbols;
        for (let i = 0; i < 4; i++) {
            password += allChars.charAt(Math.floor(Math.random() * allChars.length));
        }
        
        // Shuffle the password
        password = password.split('').sort(() => Math.random() - 0.5).join('');
        
        // Set password in field
        const passwordField = document.getElementById('ftp_password');
        if (passwordField) {
            passwordField.value = password;
            passwordField.type = 'text'; // Show the generated password
        }
        
        return password;
    }
    
    // Load FTP accounts list
    function loadFtpList() {
        const loadingEl = document.getElementById('ftp-loading');
        const listEl = document.getElementById('ftp-list');
        const emptyEl = document.getElementById('ftp-empty');
        const errorEl = document.getElementById('ftp-error');
        
        // Show loading state
        loadingEl.classList.remove('hidden');
        listEl.classList.add('hidden');
        emptyEl.classList.add('hidden');
        errorEl.classList.add('hidden');
        
        fetch('<?php echo e(route('client.hosting.ftp.list', $service->id)); ?>')
            .then(response => response.json())
            .then(data => {
                loadingEl.classList.add('hidden');
                
                if (data.success && data.accounts && data.accounts.length > 0) {
                    listEl.classList.remove('hidden');
                    displayFtpList(data.accounts);
                } else {
                    emptyEl.classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error('Error loading FTP accounts:', error);
                loadingEl.classList.add('hidden');
                errorEl.classList.remove('hidden');
            });
    }
    
    // Display FTP accounts list
    function displayFtpList(accounts) {
        const listEl = document.getElementById('ftp-list');
        
        if (!accounts || accounts.length === 0) {
            listEl.innerHTML = '';
            return;
        }
        
        listEl.innerHTML = accounts.map(account => `
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-600 hover:shadow-md transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            <div class="h-8 w-8 bg-orange-600 dark:bg-orange-500 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">${account.user || account.username}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">${account.dir || account.directory || '/'}</p>
                            </div>
                        </div>
                        <div class="ml-11 space-y-1">
                            ${account.quota ? `
                                <div class="flex items-center text-xs text-gray-600 dark:text-gray-300">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                                    </svg>
                                    <span>Quota: ${account.quota} MB</span>
                                </div>
                            ` : ''}
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2 ml-4">
                        <button 
                            onclick="deleteFtpAccount('${account.user || account.username}')"
                            class="p-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors"
                            title="Delete FTP Account">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
    }
    
    // Create FTP account form submission
    document.getElementById('createFtpForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const username = document.getElementById('ftp_username').value.trim();
        const password = document.getElementById('ftp_password').value;
        const directory = document.getElementById('ftp_directory').value;
        const quota = document.getElementById('ftp_quota').value;
        
        // Validate username - should not contain @ symbol
        if (username.includes('@')) {
            showModal('Invalid Username', 'FTP username should not contain @ symbol. Enter username only (e.g., "ftpuser"), it will automatically become "ftpuser{{ $service->username }}"', 'error');
            return;
        }
        
        // Validate username format
        if (!/^[a-zA-Z0-9_-]+$/.test(username)) {
            showModal('Invalid Username', 'Username can only contain letters, numbers, underscore (_) and dash (-)', 'error');
            return;
        }
        
        const btn = document.getElementById('createFtpBtn');
        const btnText = document.getElementById('createFtpBtnText');
        const originalText = btnText.textContent;
        
        // Disable button and show loading
        btn.disabled = true;
        btn.style.opacity = '0.6';
        btnText.textContent = 'Creating...';
        
        fetch('<?php echo e(route('client.hosting.ftp.create', $service->id)); ?>', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                username: username,
                password: password,
                directory: directory,
                quota: quota
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showModal('Success', data.message || 'FTP account created successfully', 'success');
                document.getElementById('createFtpForm').reset();
                loadFtpList();
            } else {
                showModal('Error', data.message || 'Failed to create FTP account', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showModal('Error', 'An error occurred while creating FTP account', 'error');
        })
        .finally(() => {
            btn.disabled = false;
            btn.style.opacity = '1';
            btnText.textContent = originalText;
        });
    });
    
    // Delete FTP account
    function deleteFtpAccount(username) {
        if (!confirm('Are you sure you want to delete this FTP account: ' + username + '?')) {
            return;
        }
        
        fetch('<?php echo e(route('client.hosting.ftp.delete', $service->id)); ?>', {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                username: username
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showModal('Success', data.message || 'FTP account deleted successfully', 'success');
                loadFtpList();
            } else {
                showModal('Error', data.message || 'Failed to delete FTP account', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showModal('Error', 'An error occurred while deleting FTP account', 'error');
        });
    }

    // ============================================
    // Database Wizard Functions
    // ============================================
    
    // Toggle Database Wizard Accordion
    function toggleDatabaseWizardAccordion() {
        const content = document.getElementById('databaseWizardAccordionContent');
        const icon = document.getElementById('databaseWizardAccordionIcon');
        
        if (content.style.maxHeight === '0px' || content.style.maxHeight === '') {
            content.style.maxHeight = content.scrollHeight + 'px';
            content.style.opacity = '1';
            content.style.transform = 'translateY(0)';
            content.style.padding = '1.5rem';
            icon.style.transform = 'rotate(180deg)';
            
            setTimeout(() => {
                content.style.maxHeight = 'none';
            }, 500);
        } else {
            content.style.maxHeight = content.scrollHeight + 'px';
            content.offsetHeight;
            content.style.maxHeight = '0';
            content.style.opacity = '0';
            content.style.transform = 'translateY(-10px)';
            content.style.padding = '0';
            icon.style.transform = 'rotate(0deg)';
        }
    }

    let wizardData = {
        dbName: '',
        dbUser: '',
        dbPassword: ''
    };

    function goToWizardStep(step) {
        // Hide all steps
        document.querySelectorAll('.wizard-step').forEach(el => el.classList.add('hidden'));
        document.getElementById('wizard-message').classList.add('hidden');
        
        // Show target step
        document.getElementById('wizard-step-' + step).classList.remove('hidden');
        
        // Update step indicators
        updateStepIndicators(step);
    }

    function updateStepIndicators(currentStep) {
        for (let i = 1; i <= 3; i++) {
            const indicator = document.getElementById('step-indicator-' + i);
            const line = document.getElementById('line-' + i);
            
            if (i < currentStep) {
                // Completed step
                indicator.classList.remove('bg-gray-300', 'dark:bg-gray-600', 'text-gray-600', 'dark:text-gray-400', 'bg-blue-600');
                indicator.classList.add('bg-green-600', 'text-white');
                if (line) {
                    line.classList.remove('bg-gray-300', 'dark:bg-gray-600');
                    line.classList.add('bg-green-600');
                }
            } else if (i === currentStep) {
                // Current step
                indicator.classList.remove('bg-gray-300', 'dark:bg-gray-600', 'text-gray-600', 'dark:text-gray-400', 'bg-green-600');
                indicator.classList.add('bg-blue-600', 'text-white');
                if (line) {
                    line.classList.remove('bg-green-600');
                    line.classList.add('bg-gray-300', 'dark:bg-gray-600');
                }
            } else {
                // Future step
                indicator.classList.remove('bg-blue-600', 'bg-green-600', 'text-white');
                indicator.classList.add('bg-gray-300', 'dark:bg-gray-600', 'text-gray-600', 'dark:text-gray-400');
                if (line) {
                    line.classList.remove('bg-green-600');
                    line.classList.add('bg-gray-300', 'dark:bg-gray-600');
                }
            }
        }
    }

    function createDatabaseStep() {
        const dbName = document.getElementById('wizard_db_name').value.trim();
        
        if (!dbName) {
            showWizardMessage('Please enter a database name', 'error');
            return;
        }

        showWizardMessage('Creating database...', 'info');

        fetch('<?php echo e(route('client.hosting.create-database', $service->id)); ?>', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ database: dbName })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                wizardData.dbName = data.database || '<?php echo e($service->username); ?>_' + dbName;
                document.getElementById('created-db-name').textContent = wizardData.dbName;
                document.getElementById('final-db-name').textContent = wizardData.dbName;
                goToWizardStep(2);
            } else {
                showWizardMessage(data.message || 'Failed to create database', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showWizardMessage('An error occurred while creating database', 'error');
        });
    }

    function createUserStep() {
        const dbUser = document.getElementById('wizard_db_user').value.trim();
        const dbPassword = document.getElementById('wizard_db_password').value.trim();
        
        if (!dbUser || !dbPassword) {
            showWizardMessage('Please enter username and password', 'error');
            return;
        }

        if (dbPassword.length < 5) {
            showWizardMessage('Password must be at least 5 characters', 'error');
            return;
        }

        showWizardMessage('Creating database user...', 'info');

        fetch('<?php echo e(route('client.hosting.create-database-user', $service->id)); ?>', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ 
                username: dbUser,
                password: dbPassword 
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                wizardData.dbUser = data.username || '<?php echo e($service->username); ?>_' + dbUser;
                wizardData.dbPassword = dbPassword;
                document.getElementById('final-db-user').textContent = wizardData.dbUser;
                goToWizardStep(3);
            } else {
                showWizardMessage(data.message || 'Failed to create user', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showWizardMessage('An error occurred while creating user', 'error');
        });
    }

    function toggleAllPrivileges(checkbox) {
        const privilegeCheckboxes = document.querySelectorAll('.privilege-item');
        if (checkbox.checked) {
            // When ALL is checked, disable individual checkboxes
            privilegeCheckboxes.forEach(cb => {
                cb.disabled = true;
                cb.checked = false;
            });
        } else {
            // When ALL is unchecked, enable individual checkboxes
            privilegeCheckboxes.forEach(cb => {
                cb.disabled = false;
                cb.checked = false;
            });
        }
    }

    // Handle individual privilege checkbox changes
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.privilege-item').forEach(cb => {
            cb.addEventListener('change', function() {
                // If any individual privilege is checked/unchecked, uncheck ALL
                const allCheckbox = document.getElementById('priv-all');
                if (allCheckbox && allCheckbox.checked) {
                    allCheckbox.checked = false;
                    toggleAllPrivileges(allCheckbox);
                }
            });
        });
    });

    function assignPrivilegesStep() {
        showWizardMessage('Assigning privileges...', 'info');

        // Get selected privileges
        let privileges = 'ALL';
        const allPrivCheckbox = document.getElementById('priv-all');
        
        if (!allPrivCheckbox.checked) {
            const selectedPrivs = [];
            document.querySelectorAll('.privilege-item:checked').forEach(cb => {
                selectedPrivs.push(cb.value);
            });
            
            if (selectedPrivs.length === 0) {
                showWizardMessage('Please select at least one privilege', 'error');
                return;
            }
            
            privileges = selectedPrivs.join(',');
        }

        fetch('<?php echo e(route('client.hosting.assign-database-privileges', $service->id)); ?>', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ 
                database: wizardData.dbName,
                username: wizardData.dbUser,
                privileges: privileges
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('success-db-name').textContent = wizardData.dbName;
                document.getElementById('success-db-user').textContent = wizardData.dbUser;
                
                // Hide all steps
                document.querySelectorAll('.wizard-step').forEach(el => el.classList.add('hidden'));
                // Show success
                document.getElementById('wizard-success').classList.remove('hidden');
                
                // Update all indicators to completed
                updateStepIndicators(4);
                
                showWizardMessage('Database setup completed successfully!', 'success');
            } else {
                showWizardMessage(data.message || 'Failed to assign privileges', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showWizardMessage('An error occurred while assigning privileges', 'error');
        });
    }

    function resetDatabaseWizard() {
        wizardData = { dbName: '', dbUser: '', dbPassword: '' };
        
        // Reset form
        document.getElementById('databaseWizardForm').reset();
        
        // Hide all steps
        document.querySelectorAll('.wizard-step').forEach(el => el.classList.add('hidden'));
        document.getElementById('wizard-success').classList.add('hidden');
        document.getElementById('wizard-message').classList.add('hidden');
        
        // Show first step
        document.getElementById('wizard-step-1').classList.remove('hidden');
        
        // Reset indicators
        updateStepIndicators(1);
    }

    function showWizardMessage(message, type = 'info') {
        const messageDiv = document.getElementById('wizard-message');
        messageDiv.classList.remove('hidden', 'bg-blue-50', 'bg-green-50', 'bg-red-50', 'border-blue-200', 'border-green-200', 'border-red-200', 'text-blue-700', 'text-green-700', 'text-red-700');
        
        if (type === 'success') {
            messageDiv.classList.add('bg-green-50', 'border-green-200', 'text-green-700', 'dark:bg-green-900/20', 'dark:border-green-800', 'dark:text-green-300');
        } else if (type === 'error') {
            messageDiv.classList.add('bg-red-50', 'border-red-200', 'text-red-700', 'dark:bg-red-900/20', 'dark:border-red-800', 'dark:text-red-300');
        } else {
            messageDiv.classList.add('bg-blue-50', 'border-blue-200', 'text-blue-700', 'dark:bg-blue-900/20', 'dark:border-blue-800', 'dark:text-blue-300');
        }
        
        messageDiv.className += ' p-4 rounded-lg border';
        messageDiv.textContent = message;
    }

    function generateDatabasePassword() {
        const length = 16;
        const charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
        let password = '';
        for (let i = 0; i < length; i++) {
            password += charset.charAt(Math.floor(Math.random() * charset.length));
        }
        document.getElementById('wizard_db_password').value = password;
        document.getElementById('wizard_db_password').type = 'text';
    }

    function togglePasswordVisibilityWizard(fieldId) {
        const field = document.getElementById(fieldId);
        field.type = field.type === 'password' ? 'text' : 'password';
    }

    // ===== Domains Manager Functions =====
    let domainsLoaded = false; // Track if domains have been loaded
    
    function toggleDomainsAccordion() {
        const content = document.getElementById('domains-accordion-content');
        const icon = document.getElementById('domains-accordion-icon');
        
        if (content.style.maxHeight === '0px' || content.style.maxHeight === '') {
            // Opening accordion - use a large max-height to ensure all content is visible
            content.style.maxHeight = '5000px';
            content.style.opacity = '1';
            content.style.transform = 'translateY(0)';
            content.style.padding = '1.5rem';
            icon.style.transform = 'rotate(180deg)';
            
            // Load domains data only once
            if (!domainsLoaded) {
                refreshAddonDomainsList();
                refreshSubdomainsList();
                domainsLoaded = true;
            }
        } else {
            // Closing accordion
            content.style.maxHeight = '0';
            content.style.opacity = '0';
            content.style.transform = 'translateY(-10px)';
            content.style.padding = '0';
            icon.style.transform = 'rotate(0deg)';
        }
    }

    // Add Addon Domain
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-fill subdomain and directory when domain is entered
        const addonDomainInput = document.getElementById('addon_domain');
        const addonSubdomainInput = document.getElementById('addon_subdomain');
        const addonDirectoryInput = document.getElementById('addon_directory');
        
        if (addonDomainInput && addonSubdomainInput && addonDirectoryInput) {
            addonDomainInput.addEventListener('input', function(e) {
                const domainValue = e.target.value.trim();
                
                if (domainValue) {
                    // Extract domain name without extension (e.g., "example" from "example.com")
                    const domainName = domainValue.split('.')[0];
                    
                    // Auto-fill subdomain prefix
                    addonSubdomainInput.value = domainName;
                    
                    // Auto-fill directory (full domain name)
                    addonDirectoryInput.value = domainValue;
                } else {
                    addonSubdomainInput.value = '';
                    addonDirectoryInput.value = '';
                }
            });
        }
        
        const addAddonForm = document.getElementById('addAddonDomainForm');
        if (addAddonForm) {
            addAddonForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const btn = document.getElementById('addAddonDomainBtn');
                const btnText = document.getElementById('addAddonDomainBtnText');
                const messageDiv = document.getElementById('addon-domain-message');
                
                const formData = {
                    domain: document.getElementById('addon_domain').value.trim(),
                    subdomain: document.getElementById('addon_subdomain').value.trim(),
                    directory: document.getElementById('addon_directory').value.trim()
                };

                btn.disabled = true;
                btnText.textContent = 'Adding...';
                messageDiv.classList.add('hidden');
                
                fetch('<?php echo e(route("client.hosting.domains.addon.add", $service->id)); ?>', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        messageDiv.className = 'p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg';
                        messageDiv.innerHTML = `
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <p class="text-sm text-green-800 dark:text-green-200">${data.message || 'Addon domain added successfully!'}</p>
                            </div>
                        `;
                        messageDiv.classList.remove('hidden');
                        addAddonForm.reset();
                        
                        setTimeout(() => {
                            refreshAddonDomainsList();
                        }, 1000);
                    } else {
                        messageDiv.className = 'p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg';
                        messageDiv.innerHTML = `
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                <p class="text-sm text-red-800 dark:text-red-200">${data.message || 'Failed to add addon domain'}</p>
                            </div>
                        `;
                        messageDiv.classList.remove('hidden');
                    }
                    
                    btn.disabled = false;
                    btnText.textContent = 'Add Domain';
                })
                .catch(error => {
                    console.error('Error:', error);
                    messageDiv.className = 'p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg';
                    messageDiv.innerHTML = `
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            <p class="text-sm text-red-800 dark:text-red-200">An error occurred</p>
                        </div>
                    `;
                    messageDiv.classList.remove('hidden');
                    btn.disabled = false;
                    btnText.textContent = 'Add Domain';
                });
            });
        }

        // Auto-fill subdomain directory when subdomain name is entered
        const subdomainNameInput = document.getElementById('subdomain_name');
        const subdomainDomainSelect = document.getElementById('subdomain_domain');
        const subdomainDirectoryInput = document.getElementById('subdomain_directory');
        
        function updateSubdomainDirectory() {
            if (subdomainNameInput && subdomainDomainSelect && subdomainDirectoryInput) {
                const subdomainName = subdomainNameInput.value.trim();
                const domainName = subdomainDomainSelect.value;
                
                if (subdomainName && domainName) {
                    // Create full subdomain: subdomain.domain.com
                    subdomainDirectoryInput.value = subdomainName + '.' + domainName;
                } else {
                    subdomainDirectoryInput.value = '';
                }
            }
        }
        
        if (subdomainNameInput && subdomainDomainSelect && subdomainDirectoryInput) {
            subdomainNameInput.addEventListener('input', updateSubdomainDirectory);
            subdomainDomainSelect.addEventListener('change', updateSubdomainDirectory);
        }

        // Add Subdomain
        const addSubdomainForm = document.getElementById('addSubdomainForm');
        if (addSubdomainForm) {
            addSubdomainForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const btn = document.getElementById('addSubdomainBtn');
                const btnText = document.getElementById('addSubdomainBtnText');
                const messageDiv = document.getElementById('subdomain-message');
                
                const formData = {
                    subdomain: document.getElementById('subdomain_name').value.trim(),
                    domain: document.getElementById('subdomain_domain').value,
                    directory: document.getElementById('subdomain_directory').value.trim()
                };

                btn.disabled = true;
                btnText.textContent = 'Adding...';
                messageDiv.classList.add('hidden');
                
                fetch('<?php echo e(route("client.hosting.domains.subdomain.add", $service->id)); ?>', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        messageDiv.className = 'p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg';
                        messageDiv.innerHTML = `
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <p class="text-sm text-green-800 dark:text-green-200">${data.message || 'Subdomain added successfully!'}</p>
                            </div>
                        `;
                        messageDiv.classList.remove('hidden');
                        addSubdomainForm.reset();
                        
                        setTimeout(() => {
                            refreshSubdomainsList();
                        }, 1000);
                    } else {
                        messageDiv.className = 'p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg';
                        messageDiv.innerHTML = `
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                <p class="text-sm text-red-800 dark:text-red-200">${data.message || 'Failed to add subdomain'}</p>
                            </div>
                        `;
                        messageDiv.classList.remove('hidden');
                    }
                    
                    btn.disabled = false;
                    btnText.textContent = 'Add Subdomain';
                })
                .catch(error => {
                    console.error('Error:', error);
                    messageDiv.className = 'p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg';
                    messageDiv.innerHTML = `
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            <p class="text-sm text-red-800 dark:text-red-200">An error occurred</p>
                        </div>
                    `;
                    messageDiv.classList.remove('hidden');
                    btn.disabled = false;
                    btnText.textContent = 'Add Subdomain';
                });
            });
        }
    });

    // Update Domain Dropdown with main domain and addon domains
    function updateDomainDropdown(addonDomains) {
        const domainDropdown = document.getElementById('subdomain_domain');
        if (!domainDropdown) return;
        
        // Start with the main domain
        let options = `<option value="<?php echo e($service->domain); ?>"><?php echo e($service->domain); ?></option>`;
        
        // Add all addon domains
        if (addonDomains && addonDomains.length > 0) {
            addonDomains.forEach(domain => {
                options += `<option value="${domain.domain}">${domain.domain}</option>`;
            });
        }
        
        domainDropdown.innerHTML = options;
    }

    // Refresh Addon Domains List
    function refreshAddonDomainsList() {
        const listContainer = document.getElementById('addon-domains-list');
        
        listContainer.innerHTML = '<div class="flex items-center justify-center py-8"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-slate-600"></div></div>';
        
        fetch('<?php echo e(route("client.hosting.domains.addon.list", $service->id)); ?>', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.domains && data.domains.length > 0) {
                // Update the domain dropdown for subdomains
                updateDomainDropdown(data.domains);
                
                listContainer.innerHTML = data.domains.map(domain => {
                    return `
                    <div class="bg-white dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <h5 class="font-semibold text-gray-900 dark:text-white">${domain.domain}</h5>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Directory: /public_html/${domain.directory}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="https://${domain.domain}" target="_blank" class="px-3 py-1.5 bg-slate-100 dark:bg-slate-900/30 text-slate-700 dark:text-slate-300 rounded-lg text-xs font-medium hover:bg-slate-200 dark:hover:bg-slate-900/50 transition">
                                    Visit
                                </a>
                            </div>
                        </div>
                    </div>
                    `;
                }).join('');
            } else {
                listContainer.innerHTML = `
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-400 dark:text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">No addon domains found</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            listContainer.innerHTML = `
                <div class="text-center py-8">
                    <p class="text-red-600 dark:text-red-400 text-sm">Failed to load addon domains</p>
                </div>
            `;
        });
    }

    // Refresh Subdomains List
    function refreshSubdomainsList() {
        const listContainer = document.getElementById('subdomains-list');
        
        listContainer.innerHTML = '<div class="flex items-center justify-center py-8"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div></div>';
        
        fetch('<?php echo e(route("client.hosting.domains.subdomain.list", $service->id)); ?>', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.subdomains && data.subdomains.length > 0) {
                listContainer.innerHTML = data.subdomains.map(subdomain => {
                    return `
                    <div class="bg-white dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <h5 class="font-semibold text-gray-900 dark:text-white">${subdomain.subdomain}.${subdomain.domain}</h5>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Directory: /public_html/${subdomain.directory}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="https://${subdomain.subdomain}.${subdomain.domain}" target="_blank" class="px-3 py-1.5 bg-slate-100 dark:bg-slate-900/30 text-slate-700 dark:text-slate-300 rounded-lg text-xs font-medium hover:bg-slate-200 dark:hover:bg-slate-900/50 transition">
                                    Visit
                                </a>
                            </div>
                        </div>
                    </div>
                    `;
                }).join('');
            } else {
                listContainer.innerHTML = `
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-400 dark:text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">No subdomains found</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            listContainer.innerHTML = `
                <div class="text-center py-8">
                    <p class="text-red-600 dark:text-red-400 text-sm">Failed to load subdomains</p>
                </div>
            `;
        });
    }

    // Delete Addon Domain
    function deleteAddonDomain(domain) {
        if (!confirm(`Are you sure you want to delete the addon domain "${domain}"?`)) {
            return;
        }
        
        // Get CSRF token from meta tag or any form
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || 
                         document.querySelector('input[name="_token"]')?.value;
        
        if (!csrfToken) {
            alert('CSRF token not found');
            return;
        }
        
        fetch('<?php echo e(route("client.hosting.domains.addon.delete", $service->id)); ?>', {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ domain: domain })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                refreshAddonDomainsList();
            } else {
                alert(data.message || 'Failed to delete addon domain');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the addon domain');
        });
    }

    // Delete Subdomain
    function deleteSubdomain(subdomain, domain) {
        if (!confirm(`Are you sure you want to delete the subdomain "${subdomain}.${domain}"?`)) {
            return;
        }
        
        // Get CSRF token from meta tag or any form
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || 
                         document.querySelector('input[name="_token"]')?.value;
        
        if (!csrfToken) {
            alert('CSRF token not found');
            return;
        }
        
        fetch('<?php echo e(route("client.hosting.domains.subdomain.delete", $service->id)); ?>', {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ subdomain: subdomain, domain: domain })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                refreshSubdomainsList();
            } else {
                alert(data.message || 'Failed to delete subdomain');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the subdomain');
        });
    }

    // ==================== Zone Editor (DNS) Functions ====================
    
    // Load DNS Zones
    function loadDNSZones() {
        fetch('<?php echo e(route("client.hosting.dns.zones.list", $service->id)); ?>', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('DNS Zones Response:', data); // Debug logging
            const select = document.getElementById('dns-zone-select');
            if (data.success && data.zones && data.zones.length > 0) {
                select.innerHTML = '<option value=""><?php echo e(__('frontend.select_zone_placeholder')); ?></option>' +
                    data.zones.map(zone => `<option value="${zone.domain}">${zone.domain}</option>`).join('');
            } else {
                console.log('No zones or not successful. Success:', data.success, 'Zones:', data.zones); // Debug
                select.innerHTML = '<option value=""><?php echo e(__('frontend.no_zones_available')); ?></option>';
            }
        })
        .catch(error => {
            console.error('Error loading zones:', error);
            document.getElementById('dns-zone-select').innerHTML = '<option value=""><?php echo e(__('frontend.error_loading_zones')); ?></option>';
        });
    }

    // Load DNS Records for selected zone
    document.getElementById('dns-zone-select')?.addEventListener('change', function() {
        const domain = this.value;
        const recordsList = document.getElementById('dns-records-list');
        
        if (!domain) {
            recordsList.innerHTML = `
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-400 dark:text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400 text-sm"><?php echo e(__('frontend.select_zone_to_view_records')); ?></p>
                </div>
            `;
            return;
        }

        recordsList.innerHTML = '<div class="flex items-center justify-center py-8"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-purple-600"></div><span class="ml-3 text-gray-600 dark:text-gray-400"><?php echo e(__('frontend.loading_records')); ?></span></div>';

        fetch('<?php echo e(route("client.hosting.dns.records.get", $service->id)); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ domain: domain })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.records && data.records.length > 0) {
                const recordTypes = ['A', 'AAAA', 'CNAME', 'MX', 'TXT'];
                const filteredRecords = data.records.filter(record => recordTypes.includes(record.type));
                
                if (filteredRecords.length > 0) {
                    recordsList.innerHTML = filteredRecords.map(record => {
                        let value = record.address || record.cname || record.exchange || record.txtdata || record.record;
                        return `
                        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                            <div class="flex items-start justify-between gap-2">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="px-2 py-0.5 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 rounded text-xs font-semibold">${record.type}</span>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white truncate">${record.name || '@'}</span>
                                    </div>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 truncate">${value}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">TTL: ${record.ttl}s</p>
                                </div>
                            </div>
                        </div>
                        `;
                    }).join('');
                } else {
                    recordsList.innerHTML = `
                        <div class="text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400 text-sm"><?php echo e(__('frontend.no_records_found')); ?></p>
                        </div>
                    `;
                }
            } else {
                recordsList.innerHTML = `
                    <div class="text-center py-8">
                        <p class="text-gray-500 dark:text-gray-400 text-sm"><?php echo e(__('frontend.no_records_found')); ?></p>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            recordsList.innerHTML = `
                <div class="text-center py-8">
                    <p class="text-red-600 dark:text-red-400 text-sm"><?php echo e(__('frontend.error_loading_records')); ?></p>
                </div>
            `;
        });
    });

    // Show/hide priority field based on record type
    document.getElementById('dns_type')?.addEventListener('change', function() {
        const priorityField = document.getElementById('dns_priority_field');
        const recordValueInput = document.getElementById('dns_record');
        
        if (this.value === 'MX') {
            priorityField.classList.remove('hidden');
            recordValueInput.placeholder = 'mail.example.com (domain name only)';
        } else if (this.value === 'A' || this.value === 'AAAA') {
            priorityField.classList.add('hidden');
            recordValueInput.placeholder = '<?php echo e(__('frontend.record_value_placeholder')); ?>';
        } else if (this.value === 'CNAME') {
            priorityField.classList.add('hidden');
            recordValueInput.placeholder = 'example.com (domain name)';
        } else if (this.value === 'TXT') {
            priorityField.classList.add('hidden');
            recordValueInput.placeholder = 'Text content...';
        } else {
            priorityField.classList.add('hidden');
            recordValueInput.placeholder = '<?php echo e(__('frontend.record_value_placeholder')); ?>';
        }
    });

    // Add DNS Record
    document.getElementById('addDNSRecordForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const domain = document.getElementById('dns-zone-select').value;
        if (!domain) {
            alert('<?php echo e(__('frontend.please_select_zone')); ?>');
            return;
        }

        const formData = new FormData(this);
        
        // Validate required fields
        if (!formData.get('name') || !formData.get('type') || !formData.get('record')) {
            alert('<?php echo e(__('frontend.please_fill_all_fields')); ?>');
            return;
        }
        
        // Validate MX record value (must be domain name, not IP)
        if (formData.get('type') === 'MX') {
            const recordValue = formData.get('record');
            // Simple check: if it looks like an IP address, reject it
            if (/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/.test(recordValue)) {
                alert('<?php echo e(__('frontend.mx_must_be_domain')); ?>');
                return;
            }
        }
        
        const data = {
            domain: domain,
            name: formData.get('name'),
            type: formData.get('type'),
            record: formData.get('record'),
            ttl: formData.get('ttl') || 14400
        };

        if (formData.get('type') === 'MX') {
            data.priority = formData.get('priority') || 10;
        }

        const btn = document.getElementById('addDNSRecordBtn');
        const btnText = document.getElementById('addDNSRecordBtnText');
        const originalText = btnText.textContent;
        
        btn.disabled = true;
        btnText.textContent = 'Adding...';

        fetch('<?php echo e(route("client.hosting.dns.records.add", $service->id)); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            const messageDiv = document.getElementById('dns-record-message');
            messageDiv.classList.remove('hidden');
            
            if (data.success) {
                messageDiv.className = 'p-4 bg-green-100 dark:bg-green-900/30 border border-green-300 dark:border-green-700 rounded-lg';
                messageDiv.innerHTML = `
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <p class="text-sm font-medium text-green-800 dark:text-green-200">${data.message}</p>
                    </div>
                `;
                document.getElementById('addDNSRecordForm').reset();
                document.getElementById('dns-zone-select').dispatchEvent(new Event('change'));
            } else {
                messageDiv.className = 'p-4 bg-red-100 dark:bg-red-900/30 border border-red-300 dark:border-red-700 rounded-lg';
                messageDiv.innerHTML = `
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <p class="text-sm font-medium text-red-800 dark:text-red-200">${data.message}</p>
                    </div>
                `;
            }

            setTimeout(() => {
                messageDiv.classList.add('hidden');
            }, 5000);
        })
        .catch(error => {
            console.error('Error:', error);
            const messageDiv = document.getElementById('dns-record-message');
            messageDiv.classList.remove('hidden');
            messageDiv.className = 'p-4 bg-red-100 dark:bg-red-900/30 border border-red-300 dark:border-red-700 rounded-lg';
            messageDiv.innerHTML = `
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <p class="text-sm font-medium text-red-800 dark:text-red-200">An error occurred</p>
                </div>
            `;
        })
        .finally(() => {
            btn.disabled = false;
            btnText.textContent = originalText;
        });
    });

    // Load zones on page load
    loadDNSZones();

    // Toggle Zone Editor Accordion
    let zoneEditorLoaded = false;
    
    function toggleZoneEditorAccordion() {
        const content = document.getElementById('zone-editor-content');
        const icon = document.getElementById('zone-editor-icon');
        
        if (content.style.maxHeight === '0px' || content.style.maxHeight === '') {
            // Opening accordion - use a large max-height to ensure all content is visible
            content.style.maxHeight = '5000px';
            content.style.opacity = '1';
            content.style.transform = 'translateY(0)';
            content.style.padding = '1.5rem';
            icon.style.transform = 'rotate(180deg)';
            
            // Load zones data only once
            if (!zoneEditorLoaded) {
                loadDNSZones();
                zoneEditorLoaded = true;
            }
        } else {
            // Closing accordion
            content.style.maxHeight = '0';
            content.style.opacity = '0';
            content.style.transform = 'translateY(-10px)';
            content.style.padding = '0';
            icon.style.transform = 'rotate(0deg)';
        }
    }

    // ========== SSL/TLS Functions ==========
    
    // Load SSL Certificates
    function loadSSLCertificates() {
        const certificatesList = document.getElementById('ssl-certificates-list');
        
        fetch('/services/hosting/<?php echo e($service->id); ?>/ssl/certificates')
            .then(response => response.json())
            .then(data => {
                console.log('SSL Certificates Response:', data);
                
                if (data.success && data.certificates && data.certificates.length > 0) {
                    certificatesList.innerHTML = data.certificates.map(cert => {
                        const expiryDate = new Date(cert.not_after * 1000);
                        const now = new Date();
                        const daysRemaining = Math.floor((expiryDate - now) / (1000 * 60 * 60 * 24));
                        const isExpired = daysRemaining < 0;
                        const isExpiringSoon = daysRemaining < 30 && daysRemaining >= 0;
                        
                        let statusClass = 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300';
                        let statusText = '<?php echo e(__('frontend.active')); ?>';
                        
                        if (isExpired) {
                            statusClass = 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300';
                            statusText = '<?php echo e(__('frontend.expired')); ?>';
                        } else if (isExpiringSoon) {
                            statusClass = 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300';
                            statusText = '<?php echo e(__('frontend.expiring_soon')); ?>';
                        }
                        
                        return `
                            <div class="bg-white dark:bg-gray-800/50 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex-1">
                                        <h5 class="font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                            </svg>
                                            ${cert.domains ? cert.domains.join(', ') : (cert.domain || 'N/A')}
                                        </h5>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            <?php echo e(__('frontend.issuer')); ?>: ${cert.issuer_organization || cert.issuer || 'N/A'}
                                        </p>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full ${statusClass}">
                                        ${statusText}
                                    </span>
                                </div>
                                <div class="grid grid-cols-2 gap-3 text-xs">
                                    <div>
                                        <p class="text-gray-500 dark:text-gray-400"><?php echo e(__('frontend.valid_until')); ?></p>
                                        <p class="font-medium text-gray-900 dark:text-white">${expiryDate.toLocaleDateString()}</p>
                                    </div>
                                    <div class="text-<?php echo e(app()->getLocale() === 'ar' ? 'left' : 'right'); ?>">
                                        <p class="text-gray-500 dark:text-gray-400"><?php echo e(__('frontend.days_remaining')); ?></p>
                                        <p class="font-medium ${isExpired ? 'text-red-600 dark:text-red-400' : isExpiringSoon ? 'text-yellow-600 dark:text-yellow-400' : 'text-green-600 dark:text-green-400'}">
                                            ${isExpired ? '0' : daysRemaining}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        `;
                    }).join('');
                } else {
                    certificatesList.innerHTML = `
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-400 dark:text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400 text-sm"><?php echo e(__('frontend.no_certificates')); ?></p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error loading SSL certificates:', error);
                certificatesList.innerHTML = `
                    <div class="text-center py-8">
                        <p class="text-red-600 dark:text-red-400 text-sm"><?php echo e(__('frontend.error_loading_records')); ?></p>
                    </div>
                `;
            });
    }


    // ========== PHP Selector Functions ==========
    
    let phpSelectorLoaded = false;

    function togglePHPSelectorAccordion() {
        const content = document.getElementById('php-selector-content');
        const icon = document.getElementById('php-selector-icon');
        
        if (content.style.maxHeight === '0px' || content.style.maxHeight === '') {
            content.style.maxHeight = '2000px';
            content.style.opacity = '1';
            content.style.transform = 'translateY(0)';
            content.style.padding = '1.5rem';
            icon.style.transform = 'rotate(180deg)';
            
            if (!phpSelectorLoaded) {
                loadPHPVersions();
                loadCurrentPHPVersion();
                phpSelectorLoaded = true;
            }
        } else {
            content.style.maxHeight = '0';
            content.style.opacity = '0';
            content.style.transform = 'translateY(-10px)';
            content.style.padding = '0';
            icon.style.transform = 'rotate(0deg)';
        }
    }

    function loadPHPVersions() {
        fetch('/services/hosting/<?php echo e($service->id); ?>/php/versions')
            .then(response => response.json())
            .then(data => {
                const versionSelect = document.getElementById('php_version');
                
                if (data.data && data.data.versions) {
                    const versions = Object.values(data.data.versions);
                    versionSelect.innerHTML = versions.map(version => 
                        `<option value="${version}">${version}</option>`
                    ).join('');
                } else {
                    versionSelect.innerHTML = '<option value="">No versions available</option>';
                }
            })
            .catch(error => {
                console.error('Error loading PHP versions:', error);
            });
    }

    function loadCurrentPHPVersion() {
        fetch('/services/hosting/<?php echo e($service->id); ?>/php/current')
            .then(response => response.json())
            .then(data => {
                const currentVersionDiv = document.getElementById('current-php-version');
                
                if (data.data && data.data.versions) {
                    const currentVersion = Object.values(data.data.versions)[0] || 'Unknown';
                    currentVersionDiv.textContent = currentVersion;
                } else {
                    currentVersionDiv.textContent = 'Unknown';
                }
            })
            .catch(error => {
                console.error('Error loading current PHP version:', error);
                document.getElementById('current-php-version').textContent = 'Error loading version';
            });
    }

    // Handle PHP version form submission
    document.getElementById('php-version-form')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = this.querySelector('button[type="submit"]');
        const btnText = document.getElementById('changePHPBtnText');
        const originalText = btnText.textContent;
        
        submitBtn.disabled = true;
        btnText.textContent = '<?php echo e(__('frontend.processing')); ?>...';
        
        const formData = {
            version: document.getElementById('php_version').value
        };
        
        fetch('/services/hosting/<?php echo e($service->id); ?>/php/set', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            const messageDiv = document.getElementById('php-message');
            messageDiv.classList.remove('hidden');
            
            if (data.status === 1 || data.data) {
                messageDiv.className = 'p-4 bg-green-100 dark:bg-green-900/30 border border-green-300 dark:border-green-700 rounded-lg';
                messageDiv.innerHTML = `
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <p class="text-sm font-medium text-green-800 dark:text-green-200"><?php echo e(__('frontend.php_version_updated')); ?></p>
                    </div>
                `;
                loadCurrentPHPVersion();
            } else {
                messageDiv.className = 'p-4 bg-red-100 dark:bg-red-900/30 border border-red-300 dark:border-red-700 rounded-lg';
                messageDiv.innerHTML = `
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <p class="text-sm font-medium text-red-800 dark:text-red-200">${data.message || 'Error updating PHP version'}</p>
                    </div>
                `;
            }
            
            setTimeout(() => {
                messageDiv.classList.add('hidden');
            }, 5000);
        })
        .catch(error => {
            console.error('Error:', error);
            const messageDiv = document.getElementById('php-message');
            messageDiv.classList.remove('hidden');
            messageDiv.className = 'p-4 bg-red-100 dark:bg-red-900/30 border border-red-300 dark:border-red-700 rounded-lg';
            messageDiv.innerHTML = `
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <p class="text-sm font-medium text-red-800 dark:text-red-200">An error occurred</p>
                </div>
            `;
        })
        .finally(() => {
            submitBtn.disabled = false;
            btnText.textContent = originalText;
        });
    });

    <?php endif; ?>
</script>
<?php $__env->stopPush(); ?>

<!-- Request Cancellation Button -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
    <div class="flex justify-start">
        <?php if($service->cancellation_requested_at): ?>
        <button disabled class="inline-flex items-center gap-2 px-6 py-3 bg-gray-400 cursor-not-allowed text-white font-semibold rounded-xl opacity-60">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <?php echo e(__('frontend.cancellation_requested') ?? 'Cancellation Requested'); ?>

        </button>
        <?php else: ?>
        <button onclick="openCancellationModal()" class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            <?php echo e(__('frontend.request_cancellation') ?? 'Request Cancellation'); ?>

        </button>
        <?php endif; ?>
    </div>
</div>

<!-- Cancellation Confirmation Modal -->
<div id="cancellationModal" style="display: none; background-color: rgba(0, 0, 0, 0.8);" class="fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full transform transition-all">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <?php echo e(__('frontend.confirm_cancellation_title') ?? 'Confirm Cancellation'); ?>

                </h3>
                <button onclick="closeCancellationModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div id="modalStep1" class="space-y-4">
                <p class="text-gray-600 dark:text-gray-400">
                    <?php echo e(__('frontend.cancellation_warning') ?? 'Are you sure you want to cancel this service? A verification code will be sent to your email.'); ?>

                </p>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <?php echo e(__('frontend.cancellation_reason_label') ?? 'Reason for Cancellation'); ?> <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="cancellationReasonSelect" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:text-white appearance-none bg-no-repeat" style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27%236b7280%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-position: right 0.75rem center; background-size: 1.5em 1.5em; padding-right: 2.5rem; padding-left: 1rem;">
                            <option value=""><?php echo e(__('frontend.select_reason') ?? 'Select a reason'); ?></option>
                        <option value="too_expensive"><?php echo e(__('frontend.reason_too_expensive') ?? 'Too expensive'); ?></option>
                        <option value="switching_provider"><?php echo e(__('frontend.reason_switching_provider') ?? 'Switching to another provider'); ?></option>
                        <option value="not_satisfied"><?php echo e(__('frontend.reason_not_satisfied') ?? 'Not satisfied with service'); ?></option>
                        <option value="technical_issues"><?php echo e(__('frontend.reason_technical_issues') ?? 'Technical issues'); ?></option>
                        <option value="no_longer_needed"><?php echo e(__('frontend.reason_no_longer_needed') ?? 'No longer needed'); ?></option>
                        <option value="other"><?php echo e(__('frontend.reason_other') ?? 'Other'); ?></option>
                        </select>
                    </div>
                    <p id="reasonError" style="display: none;" class="text-sm text-red-600 dark:text-red-400 mt-2"><?php echo e(__('frontend.reason_required') ?? 'Please select a reason'); ?></p>
                </div>
                
                <div id="otherReasonField" style="display: none;">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <?php echo e(__('frontend.please_specify') ?? 'Please specify'); ?> <span class="text-red-500">*</span>
                    </label>
                    <textarea id="otherReasonText" rows="3" placeholder="<?php echo e(__('frontend.enter_reason') ?? 'Enter your reason here...'); ?>" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:text-white resize-none"></textarea>
                    <p id="otherReasonError" style="display: none;" class="text-sm text-red-600 dark:text-red-400 mt-2"><?php echo e(__('frontend.other_reason_required') ?? 'Please enter your reason'); ?></p>
                </div>
                
                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                    <p class="text-sm text-yellow-800 dark:text-yellow-200">
                        <strong><?php echo e(__('frontend.note') ?? 'Note'); ?>:</strong> <?php echo e(__('frontend.cancellation_note') ?? 'Your service will remain active until the end of the billing period.'); ?>

                    </p>
                </div>
                <div class="flex gap-3 justify-end">
                    <button onclick="closeCancellationModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium rounded-lg transition-colors">
                        <?php echo e(__('frontend.cancel') ?? 'Cancel'); ?>

                    </button>
                    <button onclick="sendVerificationCode()" id="sendCodeBtn" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                        <?php echo e(__('frontend.send_code') ?? 'Send Verification Code'); ?>

                    </button>
                </div>
            </div>

            <div id="modalStep2" style="display: none;" class="space-y-4">
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-4">
                    <p class="text-sm text-blue-800 dark:text-blue-200">
                        <?php echo e(__('frontend.code_sent') ?? 'A verification code has been sent to your email address.'); ?>

                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <?php echo e(__('frontend.verification_code') ?? 'Verification Code'); ?>

                    </label>
                    <input type="text" id="verificationCode" maxlength="6" placeholder="000000" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:text-white text-center text-2xl tracking-widest font-mono">
                    <p id="codeError" style="display: none;" class="text-sm text-red-600 dark:text-red-400 mt-2"></p>
                </div>
                <div class="flex gap-3 justify-end">
                    <button onclick="closeCancellationModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium rounded-lg transition-colors">
                        <?php echo e(__('frontend.cancel') ?? 'Cancel'); ?>

                    </button>
                    <button onclick="verifyAndSubmit()" id="verifyBtn" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                        <?php echo e(__('frontend.verify_and_submit') ?? 'Verify & Submit'); ?>

                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Processing Modal -->
<div id="processingModal" style="display: none; background-color: rgba(0, 0, 0, 0.4);" class="fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full p-8 text-center">
        <div class="mb-6">
            <div class="mx-auto w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
            <?php echo e(__('frontend.request_submitted') ?? 'Request Submitted'); ?>

        </h3>
        <p class="text-gray-600 dark:text-gray-400 mb-2">
            <?php echo e(__('frontend.cancellation_processing') ?? 'Your cancellation request is being processed.'); ?>

        </p>
        <p class="text-sm text-gray-500 dark:text-gray-500 mb-6">
            <?php echo e(__('frontend.processing_time') ?? 'Expected processing time: 24 hours'); ?>

        </p>
        <button onclick="closeProcessingModal()" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
            <?php echo e(__('frontend.close') ?? 'Close'); ?>

        </button>
    </div>
</div>

<script>
let verificationCodeSent = false;

function openCancellationModal() {
    document.getElementById('cancellationModal').style.display = 'flex';
    document.getElementById('modalStep1').style.display = 'block';
    document.getElementById('modalStep2').style.display = 'none';
}

function closeCancellationModal() {
    document.getElementById('cancellationModal').style.display = 'none';
    document.getElementById('verificationCode').value = '';
    document.getElementById('codeError').style.display = 'none';
    document.getElementById('cancellationReasonSelect').value = '';
    document.getElementById('otherReasonText').value = '';
    document.getElementById('otherReasonField').style.display = 'none';
    document.getElementById('reasonError').style.display = 'none';
    document.getElementById('otherReasonError').style.display = 'none';
    verificationCodeSent = false;
}

// Show/hide other reason field based on selection
document.addEventListener('DOMContentLoaded', function() {
    const reasonSelect = document.getElementById('cancellationReasonSelect');
    const otherReasonField = document.getElementById('otherReasonField');
    
    if (reasonSelect && otherReasonField) {
        reasonSelect.addEventListener('change', function() {
            if (this.value === 'other') {
                otherReasonField.style.display = 'block';
            } else {
                otherReasonField.style.display = 'none';
                document.getElementById('otherReasonText').value = '';
                document.getElementById('otherReasonError').style.display = 'none';
            }
            document.getElementById('reasonError').style.display = 'none';
        });
    }
});

function sendVerificationCode() {
    const reasonSelect = document.getElementById('cancellationReasonSelect');
    const otherReasonText = document.getElementById('otherReasonText');
    const reasonError = document.getElementById('reasonError');
    const otherReasonError = document.getElementById('otherReasonError');
    
    // Validate reason selection
    if (!reasonSelect.value) {
        reasonError.style.display = 'block';
        return;
    }
    reasonError.style.display = 'none';
    
    // Validate other reason text if "other" is selected
    if (reasonSelect.value === 'other' && !otherReasonText.value.trim()) {
        otherReasonError.style.display = 'block';
        return;
    }
    otherReasonError.style.display = 'none';
    
    const btn = document.getElementById('sendCodeBtn');
    const originalText = btn.textContent;
    btn.disabled = true;
    btn.innerHTML = '<svg class="animate-spin h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
    
    const reason = reasonSelect.value === 'other' ? otherReasonText.value.trim() : reasonSelect.options[reasonSelect.selectedIndex].text;
    
    fetch('<?php echo e(route("client.hosting.send-cancellation-code", $service->id)); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        },
        body: JSON.stringify({ reason: reason })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            verificationCodeSent = true;
            document.getElementById('modalStep1').style.display = 'none';
            document.getElementById('modalStep2').style.display = 'block';
        } else {
            alert(data.message || '<?php echo e(__("frontend.error_sending_code") ?? "Error sending verification code"); ?>');
        }
    })
    .catch(error => {
        alert('<?php echo e(__("frontend.error_occurred") ?? "An error occurred. Please try again."); ?>');
    })
    .finally(() => {
        btn.disabled = false;
        btn.textContent = originalText;
    });
}

function verifyAndSubmit() {
    const code = document.getElementById('verificationCode').value;
    const errorDiv = document.getElementById('codeError');
    const btn = document.getElementById('verifyBtn');
    
    if (!code || code.length < 6) {
        errorDiv.textContent = '<?php echo e(__("frontend.enter_valid_code") ?? "Please enter a valid 6-digit code"); ?>';
        errorDiv.style.display = 'block';
        return;
    }
    
    errorDiv.style.display = 'none';
    const originalText = btn.textContent;
    btn.disabled = true;
    btn.innerHTML = '<svg class="animate-spin h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
    
    fetch('<?php echo e(route("client.hosting.verify-cancellation", $service->id)); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        },
        body: JSON.stringify({ code: code })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeCancellationModal();
            document.getElementById('processingModal').style.display = 'flex';
        } else {
            errorDiv.textContent = data.message || '<?php echo e(__("frontend.invalid_code") ?? "Invalid verification code"); ?>';
            errorDiv.style.display = 'block';
        }
    })
    .catch(error => {
        errorDiv.textContent = '<?php echo e(__("frontend.error_occurred") ?? "An error occurred. Please try again."); ?>';
        errorDiv.style.display = 'block';
    })
    .finally(() => {
        btn.disabled = false;
        btn.textContent = originalText;
    });
}

function closeProcessingModal() {
    document.getElementById('processingModal').style.display = 'none';
    location.reload();
}
</script>

<?php $__env->stopSection(); ?>





<?php echo $__env->make('frontend.client.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\resources\views/frontend/client/hosting/show.blade.php ENDPATH**/ ?>