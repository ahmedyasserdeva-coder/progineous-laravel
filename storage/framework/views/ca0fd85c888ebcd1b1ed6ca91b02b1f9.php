

<?php $__env->startSection('title', __('frontend.shared_hosting') . ' - ' . config('app.name')); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* Simple fade animation for cards */
    @keyframes fadeIn {
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
        animation: fadeIn 0.4s ease-out;
    }
    
    /* Service row hover effect */
    .service-row {
        transition: all 0.2s ease;
    }
    
    .service-row:hover {
        background-color: rgba(59, 130, 246, 0.05);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-purple-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 py-8">
    <div class="container mx-auto px-4 max-w-7xl">
        
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2 flex items-center gap-3">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                </svg>
                <?php echo e(__('frontend.shared_hosting')); ?>

            </h1>
            <p class="text-slate-600 dark:text-slate-400">
                <?php echo e(__('frontend.manage_your_hosting_services') ?? 'Manage all your hosting services from one place'); ?>

            </p>
        </div>
        
        <!-- Statistics Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Total Services Card -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-6 border border-slate-200 dark:border-slate-700 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">
                            <?php echo e(__('frontend.total_services') ?? 'Total Services'); ?>

                        </p>
                        <p class="text-3xl font-bold text-slate-900 dark:text-white">
                            <?php echo e($stats['total']); ?>

                        </p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Active Services Card -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-6 border border-slate-200 dark:border-slate-700 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">
                            <?php echo e(__('frontend.active') ?? 'Active'); ?>

                        </p>
                        <p class="text-3xl font-bold text-green-600 dark:text-green-400">
                            <?php echo e($stats['active']); ?>

                        </p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Pending Services Card -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-6 border border-slate-200 dark:border-slate-700 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">
                            <?php echo e(__('frontend.pending') ?? 'Pending'); ?>

                        </p>
                        <p class="text-3xl font-bold text-orange-600 dark:text-orange-400">
                            <?php echo e($stats['pending']); ?>

                        </p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Suspended Services Card -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-6 border border-slate-200 dark:border-slate-700 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">
                            <?php echo e(__('frontend.suspended') ?? 'Suspended'); ?>

                        </p>
                        <p class="text-3xl font-bold text-red-600 dark:text-red-400">
                            <?php echo e($stats['suspended']); ?>

                        </p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Services List Section -->
        <?php if($hostingServices->count() > 0): ?>
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl overflow-hidden">
                <!-- Header -->
                <div class="p-6 border-b border-slate-200 dark:border-slate-700">
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                        <?php echo e(__('frontend.your_hosting_services') ?? 'Your Hosting Services'); ?>

                    </h2>
                    <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                        <span class="font-semibold text-blue-600"><?php echo e($hostingServices->total()); ?></span> 
                        <?php echo e(__('frontend.services_found') ?? 'services found'); ?>

                    </p>
                </div>
                
                <!-- Desktop Table View -->
                <div class="hidden lg:block overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    <?php echo e(__('frontend.service') ?? 'Service'); ?>

                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    <?php echo e(__('frontend.domain') ?? 'Domain'); ?>

                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    <?php echo e(__('frontend.status') ?? 'Status'); ?>

                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    <?php echo e(__('frontend.created_date') ?? 'Created'); ?>

                                </th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    <?php echo e(__('frontend.actions') ?? 'Actions'); ?>

                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            <?php $__currentLoopData = $hostingServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="service-row border-b border-slate-100 dark:border-slate-700 last:border-0">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-md">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900"><?php echo e($service->service_name); ?></p>
                                            <p class="text-xs text-gray-500 mt-1">#<?php echo e($service->order_id); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-2 text-sm font-medium text-gray-700">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                        </svg>
                                        <?php echo e($service->domain ?? 'N/A'); ?>

                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <?php if($service->status === 'active'): ?>
                                        <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-gradient-to-r from-green-500 to-green-600 text-white text-xs font-semibold rounded-full shadow-md">
                                            <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
                                            <?php echo e(__('frontend.active')); ?>

                                        </span>
                                    <?php elseif($service->status === 'pending'): ?>
                                        <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-gradient-to-r from-orange-500 to-orange-600 text-white text-xs font-semibold rounded-full shadow-md">
                                            <span class="w-1.5 h-1.5 bg-white rounded-full"></span>
                                            <?php echo e(__('frontend.pending')); ?>

                                        </span>
                                    <?php elseif($service->status === 'suspended'): ?>
                                        <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-semibold rounded-full shadow-md">
                                            <span class="w-1.5 h-1.5 bg-white rounded-full"></span>
                                            <?php echo e(__('frontend.suspended')); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-gradient-to-r from-gray-400 to-gray-500 text-white text-xs font-semibold rounded-full shadow-md">
                                            <?php echo e(ucfirst($service->status)); ?>

                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-sm text-gray-700">
                                        <p class="font-semibold"><?php echo e($service->created_at->format('M d, Y')); ?></p>
                                        <p class="text-xs text-gray-500"><?php echo e($service->created_at->diffForHumans()); ?></p>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <?php if($service->status === 'terminated'): ?>
                                        <span class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-300 text-gray-500 text-sm font-semibold rounded-lg cursor-not-allowed">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                            </svg>
                                            <?php echo e(__('frontend.terminated') ?? 'Terminated'); ?>

                                        </span>
                                    <?php else: ?>
                                        <a href="<?php echo e(route('client.hosting.show', $service->id)); ?>" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            <?php echo e(__('frontend.view_details') ?? 'View Details'); ?>

                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Mobile/Tablet Card View -->
                <div class="lg:hidden divide-y divide-gray-100">
                    <?php $__currentLoopData = $hostingServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="p-5 service-item">
                        <div class="flex items-start gap-3 mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center shadow-md shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base font-bold text-gray-900 mb-0.5"><?php echo e($service->service_name); ?></h3>
                                <p class="text-xs text-gray-500">#<?php echo e($service->order_id); ?></p>
                            </div>
                            <?php if($service->status === 'active'): ?>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gradient-to-r from-green-500 to-green-600 text-white text-xs font-semibold rounded-full shadow-md shrink-0">
                                    <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
                                    <?php echo e(__('frontend.active')); ?>

                                </span>
                            <?php elseif($service->status === 'pending'): ?>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gradient-to-r from-orange-500 to-orange-600 text-white text-xs font-semibold rounded-full shadow-md shrink-0">
                                    <?php echo e(__('frontend.pending')); ?>

                                </span>
                            <?php elseif($service->status === 'suspended'): ?>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-semibold rounded-full shadow-md shrink-0">
                                    <?php echo e(__('frontend.suspended')); ?>

                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="bg-gray-50 rounded-xl p-4 mb-4 space-y-2.5">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                    </svg>
                                    <?php echo e(__('frontend.domain')); ?>

                                </span>
                                <span class="font-semibold text-gray-900"><?php echo e($service->domain ?? 'N/A'); ?></span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <?php echo e(__('frontend.created_date')); ?>

                                </span>
                                <div class="text-right">
                                    <p class="font-semibold text-gray-900"><?php echo e($service->created_at->format('M d, Y')); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo e($service->created_at->diffForHumans()); ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <?php if($service->status === 'terminated'): ?>
                            <span class="flex items-center justify-center gap-2 w-full px-5 py-3 bg-gray-300 text-gray-500 font-semibold rounded-lg cursor-not-allowed">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                </svg>
                                <?php echo e(__('frontend.terminated') ?? 'Terminated'); ?>

                            </span>
                        <?php else: ?>
                            <a href="<?php echo e(route('client.hosting.show', $service->id)); ?>" class="flex items-center justify-center gap-2 w-full px-5 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <?php echo e(__('frontend.view_details') ?? 'View Details'); ?>

                            </a>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                
                <!-- Pagination -->
                <?php if($hostingServices->hasPages()): ?>
                <div class="px-6 py-5 bg-gray-50 border-t border-gray-200">
                    <?php echo e($hostingServices->links()); ?>

                </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <!-- Empty State -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl p-12 text-center">
                <div class="max-w-md mx-auto">
                    <div class="w-20 h-20 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                        </svg>
                    </div>
                    
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-3">
                        <?php echo e(__('frontend.no_hosting_services') ?? 'No Hosting Services'); ?>

                    </h3>
                    <p class="text-slate-600 dark:text-slate-400 mb-6">
                        <?php echo e(__('frontend.no_hosting_services_description') ?? 'You don\'t have any hosting services yet. Start by ordering a new service.'); ?>

                    </p>
                    
                    <a href="<?php echo e(route('home')); ?>" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <?php echo e(__('frontend.order_hosting') ?? 'Order Hosting'); ?>

                    </a>
                </div>
            </div>
        <?php endif; ?>
        
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.client.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\resources\views/frontend/client/hosting/index.blade.php ENDPATH**/ ?>