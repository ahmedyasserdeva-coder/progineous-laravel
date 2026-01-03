

<?php $__env->startSection('title', __('crm.clients') . ' - Admin Panel'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* Custom Scrollbar Styles */
    .table-scroll-container {
        scrollbar-width: thin;
        scrollbar-color: #94a3b8 #e2e8f0;
        -webkit-overflow-scrolling: touch;
        overflow-x: auto;
        overflow-y: visible;
    }
    .table-scroll-container::-webkit-scrollbar {
        height: 12px;
    }
    .table-scroll-container::-webkit-scrollbar-track {
        background: #e2e8f0;
    }
    .table-scroll-container::-webkit-scrollbar-thumb {
        background: #94a3b8;
        border-radius: 6px;
        border: 2px solid #e2e8f0;
    }
    .table-scroll-container::-webkit-scrollbar-thumb:hover {
        background: #64748b;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Page Header Widget -->
    <div class="bg-gradient-to-r from-slate-800 to-slate-700 rounded-xl sm:rounded-2xl p-4 sm:p-6 md:p-8 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="absolute -top-24 <?php echo e(app()->getLocale() == 'ar' ? '-left-24' : '-right-24'); ?> w-48 sm:w-64 h-48 sm:h-64 bg-white/5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 <?php echo e(app()->getLocale() == 'ar' ? '-right-24' : '-left-24'); ?> w-48 sm:w-64 h-48 sm:h-64 bg-white/5 rounded-full blur-3xl"></div>
        
        <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 sm:gap-3 mb-1 sm:mb-2">
                    <div class="p-2 sm:p-2.5 bg-white/20 backdrop-blur-sm rounded-lg sm:rounded-xl">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h1 class="text-xl sm:text-2xl md:text-3xl font-bold"><?php echo e(__('crm.clients')); ?></h1>
                </div>
                <p class="text-white/70 text-xs sm:text-sm md:text-base"><?php echo e(__('crm.manage_all_clients')); ?></p>
            </div>
            <a href="<?php echo e(route('admin.clients.create')); ?>" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-white text-slate-800 px-4 sm:px-5 py-2 sm:py-2.5 rounded-lg sm:rounded-xl font-semibold hover:bg-slate-100 transition-all shadow-lg hover:shadow-xl text-sm sm:text-base">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                <?php echo e(__('crm.add_new_client')); ?>

            </a>
        </div>
    </div>

    <!-- Statistics Widgets -->
    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4">
        <!-- Total Clients -->
        <div class="bg-white rounded-xl p-4 md:p-5 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3">
                <div class="p-2.5 md:p-3 bg-blue-100 rounded-xl flex-shrink-0">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xl md:text-2xl font-bold text-gray-900"><?php echo e(\App\Models\Client::count()); ?></p>
                    <p class="text-xs md:text-sm text-gray-500 truncate"><?php echo e(__('crm.total_clients')); ?></p>
                </div>
            </div>
        </div>
        
        <!-- Active Clients -->
        <div class="bg-white rounded-xl p-4 md:p-5 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3">
                <div class="p-2.5 md:p-3 bg-green-100 rounded-xl flex-shrink-0">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xl md:text-2xl font-bold text-gray-900"><?php echo e(\App\Models\Client::where('status', 'active')->count()); ?></p>
                    <p class="text-xs md:text-sm text-gray-500 truncate"><?php echo e(__('crm.active_clients')); ?></p>
                </div>
            </div>
        </div>
        
        <!-- New This Month -->
        <div class="bg-white rounded-xl p-4 md:p-5 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3">
                <div class="p-2.5 md:p-3 bg-amber-100 rounded-xl flex-shrink-0">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xl md:text-2xl font-bold text-gray-900"><?php echo e(\App\Models\Client::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count()); ?></p>
                    <p class="text-xs md:text-sm text-gray-500 truncate"><?php echo e(__('crm.new_this_month')); ?></p>
                </div>
            </div>
        </div>
        
        <!-- Suspended Clients -->
        <div class="bg-white rounded-xl p-4 md:p-5 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-3">
                <div class="p-2.5 md:p-3 bg-red-100 rounded-xl flex-shrink-0">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xl md:text-2xl font-bold text-gray-900"><?php echo e(\App\Models\Client::where('status', 'suspended')->count()); ?></p>
                    <p class="text-xs md:text-sm text-gray-500 truncate"><?php echo e(__('crm.suspended_clients')); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filters Widget -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3 sm:p-4 md:p-5">
        <form action="<?php echo e(route('admin.clients.index')); ?>" method="GET" class="space-y-3 sm:space-y-4 lg:space-y-0 lg:flex lg:items-center lg:gap-4">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 <?php echo e(app()->getLocale() == 'ar' ? 'right-0 pr-3' : 'left-0 pl-3'); ?> flex items-center pointer-events-none">
                    <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                       class="w-full <?php echo e(app()->getLocale() == 'ar' ? 'pr-9 sm:pr-10' : 'pl-9 sm:pl-10'); ?> py-2 sm:py-2.5 text-sm sm:text-base border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                       placeholder="<?php echo e(__('crm.search_clients_placeholder')); ?>">
            </div>
            <div class="flex flex-col xs:flex-row sm:flex-row gap-2 sm:gap-3">
                <!-- Custom Dropdown -->
                <div class="relative flex-1 sm:flex-none sm:w-44" x-data="{ 
                    open: false, 
                    selected: '<?php echo e(request('status')); ?>',
                    options: [
                        { value: '', label: '<?php echo e(__('crm.all_statuses')); ?>' },
                        { value: 'active', label: '<?php echo e(__('crm.active')); ?>' },
                        { value: 'inactive', label: '<?php echo e(__('crm.inactive')); ?>' },
                        { value: 'suspended', label: '<?php echo e(__('crm.suspended')); ?>' }
                    ],
                    get selectedLabel() {
                        return this.options.find(o => o.value === this.selected)?.label || '<?php echo e(__('crm.all_statuses')); ?>';
                    }
                }" @click.away="open = false">
                    <input type="hidden" name="status" :value="selected">
                    <button type="button" @click="open = !open" 
                            class="w-full flex items-center justify-between px-3 sm:px-4 py-2 sm:py-2.5 text-sm sm:text-base border border-gray-300 rounded-lg sm:rounded-xl bg-white hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        <span class="truncate" x-text="selectedLabel"></span>
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400 transition-transform duration-200 <?php echo e(app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2'); ?> flex-shrink-0" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                         class="absolute z-50 mt-1 w-full bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
                        <template x-for="option in options" :key="option.value">
                            <button type="button" @click="selected = option.value; open = false" 
                                    class="w-full px-4 py-2.5 text-sm text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> hover:bg-gray-50 transition-colors flex items-center justify-between"
                                    :class="selected === option.value ? 'bg-blue-50 text-blue-700' : 'text-gray-700'">
                                <span x-text="option.label"></span>
                                <svg x-show="selected === option.value" class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </button>
                        </template>
                    </div>
                </div>
                <button type="submit" class="flex-1 sm:flex-none sm:w-auto inline-flex items-center justify-center gap-1.5 sm:gap-2 px-4 sm:px-5 py-2 sm:py-2.5 bg-slate-800 hover:bg-slate-700 text-white text-sm sm:text-base rounded-lg sm:rounded-xl transition-colors">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <span><?php echo e(__('crm.search')); ?></span>
                </button>
            </div>
        </form>
    </div>

    <!-- Clients List Widget -->
    <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Header -->
        <div class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center justify-between">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900"><?php echo e(__('crm.clients_list')); ?></h3>
                <span class="text-xs sm:text-sm text-gray-500"><?php echo e($clients->total()); ?> <?php echo e(__('crm.clients')); ?></span>
            </div>
        </div>
        
        <?php if($clients->count() > 0): ?>
            <!-- Table View with Horizontal Scroll -->
            <div class="overflow-x-auto table-scroll-container">
                <table class="divide-y divide-gray-200" style="min-width: 1200px; width: 100%;">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase tracking-wider whitespace-nowrap">
                                ID
                            </th>
                            <th scope="col" class="px-4 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase tracking-wider whitespace-nowrap">
                                <?php echo e(__('crm.username')); ?>

                            </th>
                            <th scope="col" class="px-4 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase tracking-wider whitespace-nowrap">
                                <?php echo e(__('crm.first_name')); ?>

                            </th>
                            <th scope="col" class="px-4 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase tracking-wider whitespace-nowrap">
                                <?php echo e(__('crm.last_name')); ?>

                            </th>
                            <th scope="col" class="px-4 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase tracking-wider whitespace-nowrap">
                                <?php echo e(__('crm.company_name')); ?>

                            </th>
                            <th scope="col" class="px-4 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase tracking-wider whitespace-nowrap">
                                <?php echo e(__('crm.email_address')); ?>

                            </th>
                            <th scope="col" class="px-4 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase tracking-wider whitespace-nowrap">
                                <?php echo e(__('crm.wallet_balance')); ?>

                            </th>
                            <th scope="col" class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider whitespace-nowrap">
                                <?php echo e(__('crm.services')); ?>

                            </th>
                            <th scope="col" class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider whitespace-nowrap">
                                <?php echo e(__('crm.domains')); ?>

                            </th>
                            <th scope="col" class="px-4 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase tracking-wider whitespace-nowrap">
                                <?php echo e(__('crm.created')); ?>

                            </th>
                            <th scope="col" class="px-4 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase tracking-wider whitespace-nowrap">
                                <?php echo e(__('crm.status')); ?>

                            </th>
                            <th scope="col" class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider whitespace-nowrap">
                                <?php echo e(__('crm.actions')); ?>

                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <a href="<?php echo e(route('admin.clients.show', $client)); ?>" class="hover:text-blue-600 hover:underline transition-colors">
                                    #<?php echo e($client->id); ?>

                                </a>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">
                                <a href="<?php echo e(route('admin.clients.show', $client)); ?>" class="hover:text-blue-600 hover:underline transition-colors">
                                    <?php echo e('@' . $client->username); ?>

                                </a>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php echo e($client->first_name); ?>

                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php echo e($client->last_name); ?>

                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">
                                <?php echo e($client->company_name ?? '-'); ?>

                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                <a href="<?php echo e(route('admin.clients.show', $client)); ?>" class="hover:text-blue-600 hover:underline transition-colors">
                                    <?php echo e($client->email); ?>

                                </a>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm font-semibold <?php echo e(($client->wallet_balance ?? 0) > 0 ? 'text-green-600' : 'text-gray-900'); ?>">
                                $<?php echo e(number_format($client->wallet_balance ?? 0, 2)); ?>

                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center justify-center min-w-[28px] h-7 px-2 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                    <?php echo e($client->services_count ?? $client->services()->count()); ?>

                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center justify-center min-w-[28px] h-7 px-2 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                                    <?php echo e($client->services()->where('type', 'domain')->count()); ?>

                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($client->created_at->format('M d, Y')); ?>

                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <?php
                                    $statusConfig = [
                                        'active' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'dot' => 'bg-green-500'],
                                        'inactive' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'dot' => 'bg-gray-500'],
                                        'suspended' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'dot' => 'bg-red-500'],
                                        'pending' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'dot' => 'bg-amber-500'],
                                    ];
                                    $config = $statusConfig[$client->status] ?? $statusConfig['inactive'];
                                ?>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium <?php echo e($config['bg']); ?> <?php echo e($config['text']); ?>">
                                    <span class="w-1.5 h-1.5 rounded-full <?php echo e($config['dot']); ?>"></span>
                                    <?php echo e(ucfirst($client->status ?? 'unknown')); ?>

                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <a href="<?php echo e(route('admin.clients.show', $client)); ?>" class="p-2 text-slate-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="<?php echo e(__('crm.view')); ?>">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="<?php echo e(route('admin.clients.edit', $client)); ?>" class="p-2 text-slate-600 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="<?php echo e(__('crm.edit')); ?>">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="<?php echo e(route('admin.clients.destroy', $client)); ?>" method="POST" class="inline" onsubmit="return confirm('<?php echo e(__('crm.confirm_delete_client')); ?>')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="p-2 text-slate-600 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="<?php echo e(__('crm.delete')); ?>">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <!-- Empty State -->
            <div class="px-4 sm:px-6 py-10 sm:py-16 text-center">
                <div class="flex flex-col items-center justify-center">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gray-100 rounded-full flex items-center justify-center mb-3 sm:mb-4">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-1"><?php echo e(__('crm.no_clients_found')); ?></h3>
                    <p class="text-gray-500 text-xs sm:text-sm mb-4 sm:mb-6"><?php echo e(__('crm.no_clients_description')); ?></p>
                    <a href="<?php echo e(route('admin.clients.create')); ?>" class="inline-flex items-center gap-1.5 sm:gap-2 px-4 sm:px-5 py-2 sm:py-2.5 bg-slate-800 hover:bg-slate-700 text-white text-sm sm:text-base rounded-lg sm:rounded-xl transition-colors">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <?php echo e(__('crm.add_first_client')); ?>

                    </a>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Pagination -->
        <?php if($clients->hasPages()): ?>
        <div class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 border-t border-gray-200 bg-gray-50">
            <?php echo e($clients->withQueryString()->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\resources\views/admin/clients/index.blade.php ENDPATH**/ ?>