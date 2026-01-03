

<?php $__env->startSection('title', __('tickets.predefined_replies.title')); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900"><?php echo e(__('tickets.predefined_replies.title')); ?></h1>
            <p class="text-gray-500 text-sm mt-1"><?php echo e(__('tickets.predefined_replies.description')); ?></p>
        </div>
        <a href="<?php echo e(route('admin.predefined-replies.create')); ?>" 
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-colors shadow-lg shadow-blue-500/30">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <?php echo e(__('tickets.predefined_replies.add_new')); ?>

        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl border border-gray-200 p-4 mb-6">
        <form method="GET" class="flex flex-wrap items-center gap-4">
            <!-- Search -->
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                       placeholder="<?php echo e(__('tickets.predefined_replies.search_placeholder')); ?>"
                       class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>
            
            <!-- Department Filter -->
            <select name="department" class="px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                <option value=""><?php echo e(__('tickets.predefined_replies.all_departments')); ?></option>
                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($department->id); ?>" <?php echo e(request('department') == $department->id ? 'selected' : ''); ?>>
                        <?php echo e($department->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            
            <!-- Status Filter -->
            <select name="status" class="px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                <option value=""><?php echo e(__('tickets.predefined_replies.all_status')); ?></option>
                <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>><?php echo e(__('tickets.predefined_replies.active')); ?></option>
                <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>><?php echo e(__('tickets.predefined_replies.inactive')); ?></option>
            </select>
            
            <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
            </button>
            
            <?php if(request()->hasAny(['search', 'department', 'status'])): ?>
                <a href="<?php echo e(route('admin.predefined-replies.index')); ?>" class="px-4 py-2 text-gray-500 hover:text-gray-700">
                    <?php echo e(__('tickets.predefined_replies.clear_filters')); ?>

                </a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Replies List -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <?php if($replies->count() > 0): ?>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                <?php echo e(__('tickets.predefined_replies.name')); ?>

                            </th>
                            <th class="px-6 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                <?php echo e(__('tickets.department')); ?>

                            </th>
                            <th class="px-6 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                <?php echo e(__('tickets.status')); ?>

                            </th>
                            <th class="px-6 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                <?php echo e(__('tickets.predefined_replies.created_by')); ?>

                            </th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                <?php echo e(__('tickets.actions')); ?>

                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php $__currentLoopData = $replies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="font-medium text-gray-900"><?php echo e($reply->name); ?></p>
                                        <p class="text-sm text-gray-500 truncate max-w-xs"><?php echo e(Str::limit(strip_tags($reply->content), 60)); ?></p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if($reply->department): ?>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-blue-50 text-blue-700">
                                            <?php echo e($reply->department->name); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="text-gray-400 text-sm"><?php echo e(__('tickets.predefined_replies.global')); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if($reply->is_active): ?>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                            <?php echo e(__('tickets.predefined_replies.active')); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                            <?php echo e(__('tickets.predefined_replies.inactive')); ?>

                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    <?php echo e($reply->creator->name ?? '-'); ?>

                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="<?php echo e(route('admin.predefined-replies.edit', $reply)); ?>" 
                                           class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                           title="<?php echo e(__('tickets.edit')); ?>">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <form action="<?php echo e(route('admin.predefined-replies.destroy', $reply)); ?>" method="POST" class="inline"
                                              onsubmit="return confirm('<?php echo e(__('tickets.predefined_replies.confirm_delete')); ?>')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" 
                                                    class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                    title="<?php echo e(__('tickets.delete')); ?>">
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
            
            <!-- Pagination -->
            <?php if($replies->hasPages()): ?>
                <div class="px-6 py-4 border-t border-gray-100">
                    <?php echo e($replies->links()); ?>

                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="p-12 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-1"><?php echo e(__('tickets.predefined_replies.no_replies')); ?></h3>
                <p class="text-gray-500 mb-4"><?php echo e(__('tickets.predefined_replies.no_replies_description')); ?></p>
                <a href="<?php echo e(route('admin.predefined-replies.create')); ?>" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <?php echo e(__('tickets.predefined_replies.add_first')); ?>

                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\resources\views/admin/predefined-replies/index.blade.php ENDPATH**/ ?>