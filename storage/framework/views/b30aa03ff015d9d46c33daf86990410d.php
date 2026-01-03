

<?php $__env->startSection('title', __('crm.dashboard') . ' - Progineous Hosting'); ?>
<?php $__env->startSection('page-title', __('crm.dashboard')); ?>

<?php $__env->startSection('content'); ?>
<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
    <!-- Total Hosting Plans -->
    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-xl bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                </svg>
            </div>
            <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-4' : 'ml-4'); ?> flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-600 truncate"><?php echo e(__('crm.hosting_plans')); ?></p>
                <p class="text-2xl font-bold text-gray-900"><?php echo e(number_format($stats['total_products'])); ?></p>
            </div>
        </div>
    </div>

    <!-- Total Orders -->
    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-xl bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-4' : 'ml-4'); ?> flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-600 truncate"><?php echo e(__('crm.total_orders')); ?></p>
                <p class="text-2xl font-bold text-gray-900"><?php echo e(number_format($stats['total_orders'])); ?></p>
            </div>
        </div>
    </div>

    <!-- Total Customers -->
    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-xl bg-gradient-to-r from-purple-500 to-purple-600 text-white shadow-lg">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                </svg>
            </div>
            <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-4' : 'ml-4'); ?> flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-600 truncate"><?php echo e(__('crm.total_customers')); ?></p>
                <p class="text-2xl font-bold text-gray-900"><?php echo e(number_format($stats['total_customers'] ?? 0)); ?></p>
            </div>
        </div>
    </div>

    <!-- Total Domain Names -->
    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-xl bg-gradient-to-r from-orange-500 to-orange-600 text-white shadow-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                </svg>
            </div>
            <div class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-4' : 'ml-4'); ?> flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-600 truncate"><?php echo e(__('crm.total_domains')); ?></p>
                <p class="text-2xl font-bold text-gray-900"><?php echo e(number_format($stats['total_domains'] ?? 0)); ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Welcome Section -->
<div class="bg-gradient-to-br from-white to-blue-50 rounded-2xl shadow-sm border border-blue-100 p-6 sm:p-8 text-center">
    <div class="max-w-2xl mx-auto">
        <!-- Icon -->
        <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        
        <!-- Content -->
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">
            <?php echo e(__('crm.welcome_back')); ?>

        </h2>
        <p class="text-gray-600 mb-8 text-base sm:text-lg leading-relaxed">
            <?php echo e(__('crm.advanced_crm')); ?>

            <br class="hidden sm:block">
            <span class="text-blue-600 font-medium"><?php echo e(__('crm.most_advanced_crm')); ?></span>
        </p>
        
        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="#" class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <svg class="w-5 h-5 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                </svg>
                <?php echo e(__('crm.create_order')); ?>

            </a>
            
            <a href="<?php echo e(route('home')); ?>" class="inline-flex items-center justify-center px-6 py-3 bg-white border-2 border-gray-200 text-gray-700 font-medium rounded-xl hover:border-gray-300 hover:bg-gray-50 transition-all duration-200">
                <svg class="w-5 h-5 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
                <?php echo e(__('crm.view_reports')); ?>

            </a>
        </div>
    </div>
</div>

<!-- Quick Info Cards -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
    <!-- System Status -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900"><?php echo e(__('crm.system_status')); ?></h3>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                <span class="w-2 h-2 bg-green-400 rounded-full <?php echo e(app()->getLocale() == 'ar' ? 'ml-1' : 'mr-1'); ?>"></span>
                <?php echo e(__('crm.connected')); ?>

            </span>
        </div>
        
        <div class="space-y-3">
            <div class="flex justify-between items-center py-2">
                <span class="text-gray-600"><?php echo e(__('crm.database')); ?></span>
                <span class="text-green-600 font-medium"><?php echo e(__('crm.connected')); ?></span>
            </div>
            <div class="flex justify-between items-center py-2">
                <span class="text-gray-600"><?php echo e(__('crm.services_api')); ?></span>
                <span class="text-green-600 font-medium"><?php echo e(__('crm.running')); ?></span>
            </div>
            <div class="flex justify-between items-center py-2">
                <span class="text-gray-600"><?php echo e(__('crm.last_backup')); ?></span>
                <span class="text-gray-500 text-sm"><?php echo e(now()->format('d/m/Y H:i')); ?></span>
            </div>
        </div>
    </div>
    
    <!-- Quick Links -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4"><?php echo e(__('crm.quick_links')); ?></h3>
        
        <div class="space-y-3">
            <a href="#" class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors group">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center <?php echo e(app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3'); ?> group-hover:bg-blue-200 transition-colors">
                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900"><?php echo e(__('crm.manage_products')); ?></p>
                    <p class="text-xs text-gray-500"><?php echo e(__('crm.view_and_edit_products')); ?></p>
                </div>
                <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
            </a>
            
            <a href="#" class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors group">
                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center <?php echo e(app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3'); ?> group-hover:bg-green-200 transition-colors">
                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900"><?php echo e(__('crm.reports')); ?></p>
                    <p class="text-xs text-gray-500"><?php echo e(__('crm.view_sales_reports')); ?></p>
                </div>
                <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>